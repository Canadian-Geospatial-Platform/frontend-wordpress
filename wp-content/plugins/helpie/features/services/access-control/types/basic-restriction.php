<?php

namespace Helpie\Features\Services\Access_Control\Types;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Services\Access_Control\Types\Basic_Restriction')) {
    class Basic_Restriction
    {

        public function has_access()
        {
            $access_condition = $this->get();

            if ($access_condition == 'user_role') /* TODO: no return so far */;
            elseif ($access_condition == 'logged-in-user') {
                return is_user_logged_in();
            }

            return true;
        }

        public function get()
        {
            $plugin_settings = get_option('helpie_user_access_options');

            if (isset($plugin_settings['helpie_basic_user_access']) && !empty($plugin_settings['helpie_basic_user_access'])) {
                return $plugin_settings['helpie_basic_user_access'];
            }

            return 'anyone';

        }

    } // END CLASS
}