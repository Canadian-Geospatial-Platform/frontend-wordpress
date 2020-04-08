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

class Edit_Render {
	private static function filesize_formatted($path) {
		$size = filesize($path);
		$units = array( 'b', 'kb', 'mb', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$power = $size > 0 ? floor(log($size, 1024)) : 0;
		return number_format($size / pow(1024, $power), 0, '.', ',') . ' ' . $units[$power];
	}
	public static function render() {
		require_once (\SCU\PATH.'/vendor/WriteiniFile.php');
		$availableShortcodes = \SCU\Main::$availableShortcodes;
		
		$shortcode = basename(sanitize_text_field($_GET['shortcode']));
		$shortcode_path = \SCU\PATH.'shortcodes/'.$shortcode;
		$cssFiles = glob($shortcode_path.'/resources/css/*', GLOB_NOESCAPE);
		$jsFiles = glob($shortcode_path.'/resources/js/*', GLOB_NOESCAPE);
		$assetFiles = glob($shortcode_path.'/resources/assets/*', GLOB_NOESCAPE);	 
		$iniFileName = $shortcode_path.'/scu-config.ini';
		$shortcode_ini = parse_ini_file($iniFileName, true);
		$iniFile = new \WriteiniFile\WriteiniFile($iniFileName);

		?>
		<div class="wrap"><h1 class="wp-heading-inline">

		<?php
			_e('Edit Shortcode', 'ultimate-shortcodes-creator');
		?>
		</h1><hr class="wp-header-end">
		<form method="post" action="" novalidate="novalidate">
			<!-- <input type="hidden" name="option_page" value="general"> -->
			<!-- <input type="hidden" name="action" value="update"> -->		
			<input type="hidden" id="_wpnonce" name="_wpnonce" value="<?php echo (wp_create_nonce('saved-shortcode')); ?>">
			<!-- <input type="hidden" name="_wp_http_referer" value="/wordpress/wp-admin/options-general.php"> -->

		<div id="titlediv" style="margin-top: 10px;">
			<div id="titlewrap">
				<label class="screen-reader-text" id="title-prompt-text" for="title"><?php _e('Shortcode Name', 'ultimate-shortcodes-creator'); ?></label>
				<input type="text" name="shortcode_name" size="30" value="<?php echo($shortcode)?>" id="title" autocomplete="off" placeholder="<?php _e('The shortcode name', 'ultimate-shortcodes-creator');?>" pattern="[^\s]+" title="No whitespaces please">
			</div>
		</div>
		<h2 class="nav-tab-wrapper" style="margin-top: 20px;">
			<div id="scu-edit-general-tab" class="nav-tab nav-tab-active" style="cursor: default; "><?php _e('General', 'ultimate-shortcodes-creator'); ?></div>
			<div id="scu-edit-html-tab" class="nav-tab" style="cursor: default; <?php echo((!$shortcode_ini['type']['html']) ? 'display: none;' : '') ?>"><?php _e('HTML/PHP Code', 'ultimate-shortcodes-creator'); ?></div>
			<div id="scu-edit-css-tab" class="nav-tab" style="cursor: default; <?php echo((!$shortcode_ini['type']['css']) ? 'display: none;' : '') ?>"><?php _e('CSS Code', 'ultimate-shortcodes-creator'); ?></div>
			<div id="scu-edit-js-tab" class="nav-tab" style="cursor: default; <?php echo((!$shortcode_ini['type']['js']) ? 'display: none;' : '') ?>"><?php _e('JS Code', 'ultimate-shortcodes-creator'); ?></div>	
			<div id="scu-edit-ajax-tab" class="nav-tab" style="cursor: default; <?php echo((!$shortcode_ini['type']['ajax']) ? 'display: none;' : '') ?>"><?php _e('PHP Ajax Code', 'ultimate-shortcodes-creator'); ?></div>			
			<div id="scu-edit-resources-css-tab" class="nav-tab" style="cursor: default; <?php echo((!$shortcode_ini['type']['resources_css']) ? 'display: none;' : '') ?>"><?php _e('CSS Files', 'ultimate-shortcodes-creator'); ?></div>
			<div id="scu-edit-resources-js-tab" class="nav-tab" style="cursor: default; <?php echo((!$shortcode_ini['type']['resources_js']) ? 'display: none;' : '') ?>"><?php _e('JS Files', 'ultimate-shortcodes-creator'); ?></div>
			<div id="scu-edit-resources-assets-tab" class="nav-tab" style="cursor: default; <?php echo((!$shortcode_ini['type']['resources_assets']) ? 'display: none;' : '') ?>"><?php _e('Other Resources', 'ultimate-shortcodes-creator'); ?></div>
		</h2>
		
		<div id="scu-edit-content" style="visibility: hidden; margin-top: 20px;">
	
			<div id="scu-edit-general-div" class="tab-div">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><?php _e('Enabled', 'ultimate-shortcodes-creator'); ?></th>									
							<td><input type="checkbox" id="general_enabled" name="general_enabled" value="1" <?php echo(($shortcode_ini['config']['enabled']) ? 'checked' : '') ?>></td>
						</tr>
						<tr>
							<th scope="row"><label for="general_author"><?php _e('Author', 'ultimate-shortcodes-creator'); ?></label></th>
							<td><input name="general_author" type="text" id="general_author" value="<?php echo ($shortcode_ini['general']['author']); ?>" class="regular-text"></td>
						</tr>
						<tr>
							<th scope="row"><label for="general_description"><?php _e('Description', 'ultimate-shortcodes-creator'); ?></label></th>
							<td><textarea required name="general_description" type="text" id="general_description" value="" class="regular-text" rows="5"><?php echo ($shortcode_ini['general']['description']); ?></textarea></td>
						</tr>
						<tr>
							<th scope="row"><?php _e('Type', 'ultimate-shortcodes-creator'); ?></th>									
							<td>
								<fieldset id="scu-edit-general-type">
									<legend class="screen-reader-text"><span>Otros ajustes de comentarios</span></legend>
									<label for="general_type_html">
										<input type="checkbox" name="general_type_html" id="general_type_html" value="1"  <?php echo(($shortcode_ini['type']['html']) ? 'checked' : '') ?>>
										<?php _e('HTML/PHP Code', 'ultimate-shortcodes-creator'); ?>
									</label>
									<br>
									<label for="general_type_css">
										<input type="checkbox" name="general_type_css" id="general_type_css" value="1"  <?php echo(($shortcode_ini['type']['css']) ? 'checked' : '') ?>>
										<?php _e('CSS Code', 'ultimate-shortcodes-creator'); ?>
									</label>
									<br>
									<label for="general_type_js">
										<input type="checkbox" name="general_type_js" id="general_type_js" value="1"  <?php echo(($shortcode_ini['type']['js']) ? 'checked' : '') ?>>
										<?php _e('Javascript Code', 'ultimate-shortcodes-creator'); ?>
									</label>
									<br>
									<label for="general_type_ajax">
										<input type="checkbox" name="general_type_ajax" id="general_type_ajax" value="1"  <?php echo(($shortcode_ini['type']['ajax']) ? 'checked' : '') ?>>
										<?php _e('PHP Ajax Code', 'ultimate-shortcodes-creator'); ?>
									</label>
									<br>
									<label for="general_type_resources_css">
										<input type="checkbox" name="general_type_resources_css" id="general_type_resources_css" value="1"  <?php echo(($shortcode_ini['type']['resources_css']) ? 'checked' : '') ?>>
										<?php _e('CSS Files', 'ultimate-shortcodes-creator'); ?>
									</label>
									<br>
									<label for="general_type_resources_js">
										<input type="checkbox" name="general_type_resources_js" id="general_type_resources_js" value="1"  <?php echo(($shortcode_ini['type']['resources_js']) ? 'checked' : '') ?>>
										<?php _e('Javascript files', 'ultimate-shortcodes-creator'); ?>
									</label>
									<br>
									<label for="general_type_resources_assets">
										<input type="checkbox" name="general_type_resources_assets" id="general_type_resources_assets" value="1"  <?php echo(($shortcode_ini['type']['resources_assets']) ? 'checked' : '') ?>>
										<?php _e('Other resources', 'ultimate-shortcodes-creator'); ?>
									</label>
									<br>																		  
								</fieldset> 
							</td>
						</tr>

					</tbody>
				</table>				
			</div>
			
			<div id="scu-edit-html-div" class="tab-div">
				<p>HTML/PHP: <?php echo($shortcode)?></p>
				<p><textarea id="code_editor_html" name="code-editor-html"><?php echo(file_get_contents(\SCU\PATH.'shortcodes/'.basename($shortcode).'/scu-html.php')); ?></textarea></p>
			</div>
			<div id="scu-edit-css-div" class="tab-div">
				<p>CSS: <?php echo($shortcode)?></p>
				<p><textarea id="code_editor_css" name="code-editor-css"><?php echo(file_get_contents(\SCU\PATH.'shortcodes/'.basename($shortcode).'/scu-style.css')); ?></textarea></p>
			</div>
			<div id="scu-edit-js-div" class="tab-div">
				<p>JS: <?php echo($shortcode)?></p>
				<p><textarea id="code_editor_js" name="code-editor-js"><?php echo(file_get_contents(\SCU\PATH.'shortcodes/'.basename($shortcode).'/scu-js.js')); ?></textarea></p>
			</div>
			<div id="scu-edit-ajax-div" class="tab-div">
				<p>AJAX: <?php echo($shortcode)?></p>
				<p><textarea id="code_editor_ajax" name="code-editor-ajax"><?php echo(file_get_contents(\SCU\PATH.'shortcodes/'.basename($shortcode).'/scu-ajax-handler.php')); ?></textarea></p>
			</div>
			<p class="submit">
				<?php submit_button( null, 'primary', 'submit', false ); ?>	
			</p>			
			</form>

			<div id="scu-edit-resources-css-div" class="tab-div" >
				<p><?php _e('Max file size: ', 'ultimate-shortcodes-creator'); echo ini_get('upload_max_filesize');?></p>				
				<div id="plupload-upload-ui-css" class="hide-if-no-js">
					<div id="drag-drop-area-css" class="drag-drop-area">
						<div class="drag-drop-inside">
							<p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
							<p><?php _ex('or', 'Uploader: Drop files here - or - Select Files'); ?></p>
							<p class="drag-drop-buttons"><input id="plupload-browse-button-css" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
						</div>
					</div>
					<div style="margin: 20px 0 10px 0;"><?php _e('Files in resources/css:', 'ultimate-shortcodes-creator'); ?></div>
					<div id="scu-filelist-css" class="scu-filelist">
					<?php
					foreach ($cssFiles as $key => $cssFile) {
						$output = '<div class="scu-file" id="'.$key.'">';
						$output .= '<div class="scu-file-name"><b>'.basename($cssFile).'</b>';
						$output .= ' ('.self::filesize_formatted($cssFile).') </div>';
						$output .= '<a href="#" class="scu-file-action">'.__('Delete', 'ultimate-shortcodes-creator').'</a>';
						$output .= '</div>';						
						echo $output;
					}
					?>
					</div>
				</div>
			</div>
			<div id="scu-edit-resources-js-div" class="tab-div" >
				<p><?php _e('Max file size: ', 'ultimate-shortcodes-creator'); echo ini_get('upload_max_filesize');?></p>
				<div id="plupload-upload-ui-js" class="hide-if-no-js">
					<div id="drag-drop-area-js" class="drag-drop-area">
						<div class="drag-drop-inside">
						<p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
						<p><?php _ex('or', 'Uploader: Drop files here - or - Select Files'); ?></p>
						<p class="drag-drop-buttons"><input id="plupload-browse-button-js" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
						</div>
					</div>
					<div style="margin: 20px 0 10px 0;"><?php _e('Files in resources/js:', 'ultimate-shortcodes-creator'); ?></div>
					<div id="scu-filelist-js" class="scu-filelist">
					<?php
					foreach ($jsFiles as $key => $jsFile) {
						$output = '<div class="scu-file" id="'.$key.'">';
						$output .= '<div class="scu-file-name"><b>'.basename($jsFile).'</b>';
						$output .= ' ('.self::filesize_formatted($jsFile).') </div>';
						$output .= '<a href="#" class="scu-file-action">'.__('Delete', 'ultimate-shortcodes-creator').'</a>';
						$output .= '</div>';						
						echo $output;
					}
					?>
					</div>
				</div>
			</div>
			<div id="scu-edit-resources-assets-div" class="tab-div" >
				<p><?php _e('Max file size: ', 'ultimate-shortcodes-creator'); echo ini_get('upload_max_filesize');?></p>
				<div id="plupload-upload-ui-assets" class="hide-if-no-js">
					<div id="drag-drop-area-assets" class="drag-drop-area">
						<div class="drag-drop-inside">
						<p class="drag-drop-info"><?php _e('Drop files here'); ?></p>
						<p><?php _ex('or', 'Uploader: Drop files here - or - Select Files'); ?></p>
						<p class="drag-drop-buttons"><input id="plupload-browse-button-assets" type="button" value="<?php esc_attr_e('Select Files'); ?>" class="button" /></p>
						</div>
					</div>
					<div style="margin: 20px 0 10px 0;"><?php _e('Files in resources/assets:', 'ultimate-shortcodes-creator'); ?></div>
					<div id="scu-filelist-assets" class="scu-filelist">
					<?php
					foreach ($assetFiles as $key => $assetFile) {
						$output = '<div class="scu-file" id="'.$key.'">';
						$output .= '<div class="scu-file-name"><b>'.basename($assetFile).'</b>';
						$output .= ' ('.self::filesize_formatted($assetFile).') </div>';
						$output .= '<a href="#" class="scu-file-action">'.__('Delete', 'ultimate-shortcodes-creator').'</a>';
						$output .= '</div>';						
						echo $output;
					}
					?>
					</div>
				</div>
			</div>		
		</div>	
		<?php	
	}
	
	public function __construct() {
		//add_action('admin_menu', array( $this, 'addMenu'), 10);		// Create sub page inside Settings menu in the admin pannel
	}
}
?>
