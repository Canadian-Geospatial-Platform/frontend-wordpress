<?php

namespace Helpie\Includes\Core;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://pauple.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */

if (!class_exists('\Helpie\Includes\Core\Pauple_Helpie_I18n')) {
class Pauple_Helpie_I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
        $path = dirname(dirname(dirname(dirname( plugin_basename( __FILE__ ) )))).'/languages/';
        load_plugin_textdomain('pauple-helpie', false,$path);
	}



} // END CLASS
}
