<?php
/**
 * The file that defines the core plugin class
 *
 * @author   cmorillas1@gmail.com
 * @category API
 * @package  CMB_Admin
 */

// We don't use settings API here (https://developer.wordpress.org/plugins/settings/)
// Nothing to be saved in the wp_options table of the wordpress database

// add_action('current_screen', ...) is the first hook where $current_screen, $pagenow, and $plugin_page globals are available 

namespace SCU\admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Edit_Save_Shortcode {
	public static function save_shortcode() {
		WP_Filesystem();
		global $wp_filesystem;
		require_once (\SCU\PATH.'/vendor/WriteiniFile.php');
		$shortcode = basename(sanitize_text_field($_GET['shortcode']));
		$shortcode_path = \SCU\PATH.'shortcodes/'.$shortcode;

		// Create scu-config.ini file
		$iniFileName = $shortcode_path.'/scu-config.ini';
		$iniFile = new \WriteiniFile\WriteiniFile($iniFileName);
		$iniFile->update(['general' => ['author' =>  sanitize_text_field($_POST['general_author'])]]);
		$iniFile->update(['general' => ['description' => sanitize_text_field($_POST['general_description'])]]);
		$iniFile->update(['config' => ['enabled' => (isset($_POST['general_enabled']) ? 1 : 0)]]);
		$iniFile->update(['type' => ['html' => (isset($_POST['general_type_html']) ? 1 : 0)]]);
		$iniFile->update(['type' => ['css' => (isset($_POST['general_type_css']) ? 1 : 0)]]);
		$iniFile->update(['type' => ['js' => (isset($_POST['general_type_js']) ? 1 : 0)]]);
		$iniFile->update(['type' => ['ajax' => (isset($_POST['general_type_ajax']) ? 1 : 0)]]);
		$iniFile->update(['type' => ['resources_css' => (isset($_POST['general_type_resources_css']) ? 1 : 0)]]);
		$iniFile->update(['type' => ['resources_js' => (isset($_POST['general_type_resources_js']) ? 1 : 0)]]);
		$iniFile->update(['type' => ['resources_assets' => (isset($_POST['general_type_resources_assets']) ? 1 : 0)]]);
		$iniFile->write();

		// Create scu-html.php, scu-style.css, scu-js.js, scu-script.js and scu-ajax-handler.php filea
		$file_path = $shortcode_path.'/scu-html.php';
		$wp_filesystem->put_contents($file_path, wp_unslash($_POST['code-editor-html']), FS_CHMOD_FILE);	
		$file_path = $shortcode_path.'/scu-style.css';
		$wp_filesystem->put_contents($file_path, wp_unslash($_POST['code-editor-css']), FS_CHMOD_FILE);	
		$file_path = $shortcode_path.'/scu-js.js';
		$wp_filesystem->put_contents($file_path, wp_unslash($_POST['code-editor-js']), FS_CHMOD_FILE);
		self::createScript($shortcode);
		$file_path = $shortcode_path.'/scu-ajax-handler.php';
		$wp_filesystem->put_contents($file_path, wp_unslash($_POST['code-editor-ajax']), FS_CHMOD_FILE);
		$result = 'saved';
		$shortcodeRedirect = sanitize_text_field($_GET['shortcode']);

		// Create subidrectories if they are missing
		$target_dir=realpath($shortcode_path.'/languages');
		if(!$target_dir) {$wp_filesystem->mkdir($shortcode_path.'/languages');}
		$target_dir=realpath($shortcode_path.'/resources');
		if(!$target_dir) {$wp_filesystem->mkdir($shortcode_path.'/resources');}
		$target_dir=realpath($shortcode_path.'/resources/assets');
		if(!$target_dir) {$wp_filesystem->mkdir($shortcode_path.'/resources/assets');}
		$target_dir=realpath($shortcode_path.'/resources/css');
		if(!$target_dir) {$wp_filesystem->mkdir($shortcode_path.'/resources/css');}
		$target_dir=realpath($shortcode_path.'/resources/js');
		if(!$target_dir) {$wp_filesystem->mkdir($shortcode_path.'/resources/js');}

		// If user changes the name of the shortcode, move directory to the new shortcode name
		if(sanitize_text_field($_POST['shortcode_name']) != sanitize_text_field($_GET['shortcode'])) {		
			$src_dir=$wp_filesystem->find_folder($shortcode_path);
			$mimes = wp_get_mime_types();
			add_filter( 'mime_types', function($existing_mimes) {		// Allow folder name be equal to any mime extension
				$existing_mimes = array ();
				return $existing_mimes;
			});
			$target_folder = wp_unique_filename($wp_filesystem->find_folder(\SCU\PATH.'shortcodes'), basename(sanitize_text_field($_POST['shortcode_name'])));
			add_filter( 'mime_types', function($previous_mimes) {		// Set mimes back to normal.
				$previous_mimes = $mimes;
				return $previous_mimes;
			});
			$target_dir = $wp_filesystem->find_folder(\SCU\PATH.'shortcodes/'.$target_folder);
			$wp_filesystem->mkdir($target_dir);
			if(copy_dir($src_dir, $target_dir)) {
				$shortcodeRedirect = $target_folder;
				//self::createScript($target_folder);		// Is it really needed ?
				$wp_filesystem->rmdir($src_dir, true);					
			}
			else {
				wp_die(__('Error copying directory', 'ultimate-shortcodes-creator'));
			}				
		}
		
		if ( isset( $result ) ) {
			$_SERVER['REQUEST_URI'] = remove_query_arg( array( 'shortcode' ) );			
			wp_redirect( esc_url_raw( add_query_arg( array('shortcode' => $shortcodeRedirect, 'result' => $result ) ) ) );
			exit;
		}
	}
	private static function createScript($shortcode) {		
		WP_Filesystem();
		global $wp_filesystem;

		ob_start();
		?>

		(function($) {					
			"use strict";	// Throws more exceptions
			var shortcode = document.currentScript.getAttribute('data-name');
			var ajaxurl = scu_common.ajaxurl;
			let url = document.currentScript.src;
			var resources_url = url.substring(0, url.lastIndexOf('/')) + "/resources/assets/";

			//$.ajaxSettings.headers["x-custom"] = 'value';
			//$.ajaxSetup({
			//	headers: { 'Scu-Referer': url.substring(0, url.lastIndexOf('/')) }
			//});
			//delete $.ajaxSettings.headers["Scu-Referer"];


			$(document).ready(function() {
				$(".sc-"+shortcode).each(function() {
					var current = this;
					var content = $(this).children(".scu-content").html();							
					var atts = $(this).data();			
					var ajaxdata = {
						action: 'scu_ajax_handler',
						security: scu_common.ajaxNonce,
						content: content,
						//i18n: i18n,
						atts: atts
					};
				
					
				/***************************************************
				* Begin specific shortcode js
				****************************************************/
							
				<?php
					$jsfilepath = \SCU\PATH.'shortcodes/'.$shortcode.'/scu-js.js';				
					readfile($jsfilepath);				
				?>

				/***************************************************
				* End of specific shortcode js
				****************************************************/
				
				});
			});
			
		})(jQuery);

		<?php
		$content = ob_get_clean();

		$file_path = \SCU\PATH.'shortcodes/'.$shortcode.'/scu-script.js';
		$wp_filesystem->put_contents($file_path, $content);
	}
}
?>