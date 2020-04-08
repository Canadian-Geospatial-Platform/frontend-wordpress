<?php
/**
 * The file that defines the core plugin class
 *
 * @author   cmorillas1@gmail.com
 * @category API
 * @package  Frontend
 */
 
namespace SCU\frontend;
use SCU\Main as Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Frontend /*extends \CMBShortcodes\Main */{	

	protected $shortcodes_in_page = array();	// Array of shortcodes that are present in current page (including widgets)
	//Main::$installedShortcodes				// Array of installed shortcodes
	protected $active_shortcodes = array();		// Array of shortcodes that are in page, installed and config.ini-enabled
	protected $added_shortcodes = array();		// Array of shortcodes objects
		
	
	private function _presentShortcodes( $content, $tag ) {		// Own version of the original has _shortocde() in shortcodes.php

		if ( false === strpos( $content, '[' ) ) {
			return false;
		}
		preg_match_all( '/' . get_shortcode_regex([$tag]) . '/', $content, $matches, PREG_SET_ORDER );		
		if ( empty( $matches ) ) {
			return false;
		}
		foreach ( $matches as $shortcode ) {
			if ( $tag === $shortcode[2] ) {
				$attr = shortcode_parse_atts( $shortcode[3] );
				if(isset($attr['name'])) {
					$this->shortcodes_in_page[] = $attr['name'];
				}
			} 
			if ( ! empty( $shortcode[5] )) {	// && _presentShortcodes( $shortcode[5], $tag ) ) {
				$this->_presentShortcodes($shortcode[5], $tag);
			}
		}
	}

	public function addShortcodes() {
		// Check shortcodes in current post
		global $post;
		$this->_presentShortcodes($post->post_content, 'scu');

		// Check shortcodes in any text widget
	//	$text_widgets = get_option('widget_text');		
	//	foreach ($text_widgets as $key => $text_widget) {
	//		$this->_presentShortcodes($text_widget['text'], 'scu');
	//	}

		// Check shortcodes in any custom html widget
	//	$html_widgets = get_option('widget_custom_html');
	//	foreach ($html_widgets as $key => $html_widget) {
	//		$this->_presentShortcodes($html_widget['content'], 'scu');
	//	}

		if(empty($this->shortcodes_in_page)) {
			return;
		}

		$potencial_shortcodes = array_intersect(Main::$availableShortcodes, $this->shortcodes_in_page);
		foreach ($potencial_shortcodes as $key => $shortcode) {			
			$ini_file = wp_normalize_path(dirname( __FILE__, 2).'/shortcodes/'.$shortcode.'/scu-config.ini');
			if(file_exists($ini_file)) {
				$config_array = parse_ini_file($ini_file, true);
				$enabled = $config_array["config"]["enabled"];
				if($enabled) {
					$this->active_shortcodes[] = $shortcode;
				}
			}
			else {
				wp_die($ini_file.__(' does not exit', 'ultimate-shortcodes-creator'));
			}
		}

		if(empty($this->active_shortcodes)) {
			return;
		}

		$this->enqueueCommonScripts();

		add_shortcode( 'scu', array( $this, 'shortcode_handler' ) );

		foreach ($this->active_shortcodes as $key => $shortcode) {

			require_once(realpath(dirname( __FILE__ ).'/class-shortcode.php'));	// See also wp_normalize_path()
			$this->added_shortcodes[] = new Shortcode($shortcode);
		}
	}

	public function enqueueCommonScripts() {		
		// Enqueue common styles and scripts
		$js_ver = '1.0';
		$js_file_url = plugins_url( '', __FILE__ ).'/assets/js/scu-common.js';		
		wp_register_script('scu-common-js', $js_file_url, array( 'jquery' ), $js_ver , false);
		wp_enqueue_script ('scu-common-js');
		wp_localize_script('scu-common-js', 'scu_common', array(		// Send vars to the javascript file			
			'ajaxurl' => admin_url( 'admin-ajax.php' ),	
			'ajaxNonce' => wp_create_nonce( 'scu-ajax-nonce' ),
			'requests' => $_REQUEST
		));		
	}

	public function shortcode_handler( $atts = [], $content = null ) {		
		static $count = 0;				// Increments when a new shortcode is executed in the page
		$count++;

		//$atts = shortcode_atts(array('param1' => 'default1','param2' => 'default2'), $atts);	//set defaults values if needed

		if(!isset($atts["name"])) {
			return(__('attribute "name" does not exit', 'ultimate-shortcodes-creator'));
		}
		$shortcode = $atts["name"];
		$resources_url = \SCU\URL.'/shortcodes/'.$shortcode.'/resources/assets/';
		$output = '<div class="scu-shortcode sc-'.$shortcode.'"';
		if($atts) {
			foreach($atts as $key => $att) {
				$output .= ' data-'.$key.'="'.$att.'"';
			}
		}
		$output .= '>';
		$output .= '<div class="scu-content" style="display:none;">'.$content.'</div>';
		
		$shortcode_config_file = wp_normalize_path(dirname( __FILE__, 2).'/shortcodes/'.$shortcode.'/scu-config.ini'); // File exists because it has been already checked before
		$config_array = parse_ini_file($shortcode_config_file, true);
		if($config_array["type"]["html"]) {
			$html_file_path = wp_normalize_path(dirname( __FILE__, 2).'/shortcodes/'.$shortcode.'/scu-html.php');
			if(!file_exists($html_file_path)) {
				wp_die($html_file_path.__(' does not exit', 'ultimate-shortcodes-creator'), E_USER_ERROR);
			}
			ob_start();			
			include ($html_file_path);
			$output .= ob_get_clean();
		}
		else {
			$output .= $content;
		}
	
		$output .= "</div>";		
	
		return do_shortcode($output);
	}
	
	public function __construct() {

		// Check if url/?safe-mode=true in case the site brokes
		if(isset($_GET["safe-mode"]) && (strtolower($_GET["safe-mode"])=='true')) {
			return;
		}
		
   		add_action('wp', array( $this, 'addShortcodes'), 12);	// 'wp' is the earliest action when $post is available

	}		
}

$frontendInstance = new Frontend();	// Without Singletron Pattern
?>