<?php

namespace Helpie\Includes\Core;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Fired during plugin deactivation
 */

include_once HELPIE_PLUGIN_PATH.'includes/utils/test-helpers.php';

if (!class_exists('\Helpie\Includes\Core\Kb_Deactivator')) {
class Kb_Deactivator{

	public static function deactivate() {
			// $test_helper = new Test_Helpers();
			// $test_helper->delete_plugin_data();
	}

} // END CLASS

}
