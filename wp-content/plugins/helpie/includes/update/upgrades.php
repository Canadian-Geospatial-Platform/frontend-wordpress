<?php

namespace Helpie\Includes\Update;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
/**
 * Helpie upgrades.
 *
 * Helpie upgrades handler class is responsible for updating different
 * Helpie versions.
 *
 * @since 1.9
 */
if (!class_exists('\Helpie\Includes\Update\Upgrades')) {
    class Upgrades
    {
        /**
         * Add actions.
         *
         * Hook into WordPress actions and launch Helpie upgrades.
         *
         * @static
         * @since 1.9
         * @access public
         */
        public static function add_actions()
        {
            add_action('init', [__CLASS__, 'init'], 20);
        }
        /**
         * Init.
         *
         * Initialize Helpie upgrades.
         *
         * Fired by `init` action.
         *
         * @static
         * @since 1.9
         * @access public
         */
        public static function init()
        {
            $helpie_plugin_version = get_option('pauple_helpie_plugin_version');

            // Normal init.
            if (HELPIE_PLUGIN_VERSION === $helpie_plugin_version) {
                return;
            }

            $upgrade_success = self::check_upgrades($helpie_plugin_version);

            // error_log('$upgrade_success : ' . $upgrade_success);
            if ($upgrade_success) {
                \update_option('pauple_helpie_plugin_version', HELPIE_PLUGIN_VERSION);
            }
        }
        /**
         * Check upgrades.
         *
         * Checks whether a given Helpie version needs to be upgraded.
         *
         * If an upgrade required for a specific Helpie version, it will update
         * the `pauple_helpie_plugin_version` option in the database.
         *
         * @static
         * @since 1.0.10
         * @access private
         *
         * @param string $helpie_version
         */
        public static function check_upgrades($helpie_plugin_version)
        {
            $upgrade_success = false;
            $helpie_kb_upgrades = get_option('helpie_kb_upgrades', []);

            $upgrades = [
                '1.0.0' => 'upgrade_v100',
                '1.0.5' => 'upgrade_v105',
                '1.0.6' => 'upgrade_v106',
                '1.0.8' => 'upgrade_v108',
                '1.1.0' => 'upgrade_v110',
                '1.2.3' => 'upgrade_v123',
                '1.5.0' => 'upgrade_v150',
                '1.8.1' => 'upgrade_v181',
                '1.9.0' => 'upgrade_v190',
                '1.9.1' => 'upgrade_v191',
            ];

            $allow_fresh_install_action = true;

            // Special Condition only for version 1.9.0.2
            if (!$helpie_plugin_version && self::is_changed_v1902()) {
                $helpie_plugin_version = '1.9.0.2';
                $allow_fresh_install_action = false;
            }

            // It's a new install.
            if (!$helpie_plugin_version && $allow_fresh_install_action) {
                self::fresh_install_action($upgrades);
                return true;
            }

            // error_log(' $helpie_plugin_version : ' . $helpie_plugin_version);

            // TODO: Uncomment after testing
            foreach ($upgrades as $version => $function) {

                if (version_compare($helpie_plugin_version, $version, '<') && !isset($helpie_kb_upgrades[$version])) {

                    $result = self::$function(); // fire sequencial upgrade from given array value

                    // error_log('$version : ' . $version  . " , result: " . $result);

                    if ($result == false) {
                        break;
                    } else {
                        $upgrade_success = true;
                    }

                    $helpie_kb_upgrades[$version] = true;
                    \update_option('helpie_kb_upgrades', $helpie_kb_upgrades);
                }
            }

            // $result = self::upgrade_v191();

            return $upgrade_success;
        }


        private static function is_changed_v1902()
        {
            $options = get_option('helpie-kb');

            /* Future Version Protection */
            // 1. Future version in update process should not enter this method
            // 2. Freshly installed future updates shouldn't have kb_main_title

            /* Checking 1902 */
            // 3. Fresh 1902 can skip this
            // 4. 1902 version should not have mp_hero_section_order

            if (isset($options['kb_main_title']) && !isset($options['mp_hero_section_order'])) {
                return true;
            }

            return false;
        }


        private static function upgrade_v191()
        {

            $update_191 = new \Helpie\Includes\Update\Update_191();
            $result = $update_191->update();
            return $result;
        }

        private static function upgrade_v190()
        {

            $update_190 = new \Helpie\Includes\Update\Update_190();
            $result = $update_190->update();
            return $result;
        }

        private static function fresh_install_action($upgrades)
        {
            $helpie_plugin_version = 0.0;
            foreach ($upgrades as $version => $method_name) {
                $helpie_kb_upgrades[$version] = true;
            }
            update_option('helpie_kb_upgrades', $helpie_kb_upgrades);
        }
        private static function upgrade_v100()
        {
            $default_value_setter = new \Helpie\Includes\Update\Default_Value_Setter();
            $default_value_setter->set_default_values_before_update();

            $update_below_110 = new \Helpie\Includes\Update\Update_Below_110();
            $update_below_110->migrate_options_below_100();

            include_once HELPIE_PLUGIN_PATH . 'includes/update/update-handler.php';
            $update_handler = new \Helpie\Includes\Update\Update_Handler();
            $update_handler->set_default_values_after_update();
        }

        private static function upgrade_v105()
        {
            $update_below_110 = new \Helpie\Includes\Update\Update_Below_110();
            $update_below_110->set_default_values_105();
        }

        private static function upgrade_v106()
        {
            $update_below_110 = new \Helpie\Includes\Update\Update_Below_110();
            $update_below_110->set_default_values_106();
        }

        private static function upgrade_v108()
        {
            // $update_below_110 = new \Helpie\Includes\Update\Update_Below_110();
            // $update_below_110->set_default_values_108();
        }

        private static function upgrade_v110()
        {
            $update_below_130 = new \Helpie\Includes\Update\Update_Below_130();
            $update_below_130->update_values_11();
        }

        private static function upgrade_v123()
        {
            $update_below_130 = new \Helpie\Includes\Update\Update_Below_130();
            $update_below_130->update_values_123();
        }

        private static function upgrade_v150()
        {
            $options_to_copy = array(
                0 => array(
                    'from' => array('main_page_recent_articles', 'helpie_mp_template'),
                    'to' => array('show_article_listing', 'helpie_mp_template'),
                ),
            );

            $migrate_settings_service = new \Helpie\Includes\Update\Migrate_Settings_Service();
            $migrate_settings_service->copy_option_properties($options_to_copy);
        }

        private static function upgrade_v181()
        {
            $page_id = get_option('helpdesk_search_page_id');

            if (isset($page_id)) {
                $search_post = array(
                    'ID' => $page_id,
                    'post_content' => '[pauple_helpie_search_results_page]',
                );
                $result = wp_update_post($search_post);

                if ($result == 0) {
                    return false;
                }

                return true;
            }
        }
    } // END CLASS
}