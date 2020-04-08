<?php

namespace Helpie\Includes\Update;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/* 1. Migrate can_show_catp_sidebar to corresponding option */
/* 2. Migrate can_show_sp_sidebar to corresponding option */

if (!class_exists('\Helpie\Includes\Update\Update_Handler')) {
    class Update_Handler
    {
        public function __construct()
        {
            // error_log('Update_Handler');
            $this->services = new \Helpie\Includes\Services();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->default_value_setter = new \Helpie\Includes\Update\Default_Value_Setter();

            // Handles updates from version less than 1.1.0
            $this->update_below_110 = new \Helpie\Includes\Update\Update_Below_110();

            $this->update_below_130 = new \Helpie\Includes\Update\Update_Below_130();
            $this->migrate_settings_service = new \Helpie\Includes\Update\Migrate_Settings_Service();
        }

        /* This is the main method used now */
        public function set_default_values_after_update()
        {
            // error_log('set_default_values_after_update ');
            $this->default_value_setter->set_default_values_after_update();
            // $this->set_default_publishing_settings();

            /* Data Transformation */
            $this->transform_core_settings_data();
            $this->transform_mp_settings_data();
            $this->update_from_below_150();
        }

        // protected function set_default_publishing_settings(){
        //
        // }

        protected function transform_mp_settings_data()
        {
            $mp_options = get_option('helpie_mp_options');
            $this->set_default_mp_children_type($mp_options);
        }

        protected function set_default_mp_children_type($mp_options)
        {
            if (!isset($mp_options['category_listing_children_type'])) {
                $listing_type = $this->settings->main_page->get_listing_type();
                if ($listing_type == 'boxed1') {
                    $children_type = 'articles';
                } else { // Keep 'modern' and 'boxed' children as none
                    $children_type = 'none';
                }

                $mp_options['category_listing_children_type'] = $children_type;

                update_option('helpie_mp_options', $mp_options);
            }
        }

        protected function transform_core_settings_data()
        {
            $core_options = get_option('helpie_core_options_main');

            $is_edit_capability_set = (isset($core_options['kb_edit_capability']));
            $is_not_array = (!is_array($core_options['kb_edit_capability']));

            if ($is_edit_capability_set && $is_not_array) {
                $value = $core_options['kb_edit_capability'];
                $core_options['kb_edit_capability'] = array(
                    'kb_edit_capability' => $core_options['kb_edit_capability'],
                );
                update_option('helpie_core_options_main', $core_options);
            }

            // $core_options = get_option('helpie_core_options_main');
        }

        public function set_default_values_before_update()
        {
            $this->default_value_setter->set_default_values_before_update();
        }

        public function update()
        {
            if (is_admin()) {
                $user_version = get_option('pauple_helpie_plugin_version');
                if (!isset($user_version) || empty($user_version)) {
                    $user_version = '0.0.0';
                }

                $this->update_from_version($user_version);
            }
        } // End of update method

        public function update_from_version($user_version)
        {
            $this->update_from_version_older_versions($user_version);

            $this->update_from_below_150();

            /*  Below v1.8.1 */
            $this->update_from_below_181($user_version);

            /*  Below v1.9 */
            $this->update_from_below_190($user_version);
        }

        protected function update_from_below_190($user_version)
        {
            if ($this->is_user_version_below('1.9', $user_version)) {
                $mp_options = get_option('helpie_mp_options');
                if (isset($mp_options) && isset($mp_options['helpie_mp_cats']) && $mp_options['helpie_mp_cats'] != '') {
                    $dnd_terms = [];
                    $dnd_terms['enabled'] = explode(",", $mp_options['helpie_mp_cats']);
                    $dnd_terms['enabled'] = array_filter($dnd_terms['enabled']); // remove empty values

                    // Append 'term-id_'
                    foreach ($dnd_terms['enabled'] as $key => $value) {
                        $dnd_terms['enabled'][$key] = 'term-id_' . $value;
                    }

                    array_filter($dnd_terms['enabled']);
                    // $dnd_terms['enabled'] = $mp_options['helpie_mp_cats'];
                    $this->services->update_category_order($dnd_terms);
                }
                /* Set New Version in DB */

                $this->set_new_version_in_db();
            }
        }

        protected function update_from_below_181($user_version)
        {
            if ($this->is_user_version_below('1.8.1', $user_version)) {
                $this->add_shortcode_to_search_page();

                /* Set New Version in DB */

                $this->set_new_version_in_db();
            }
        }

        protected function add_shortcode_to_search_page()
        {
            $page_id = get_option('helpdesk_search_page_id');
            error_log('page_id:  ' . $page_id);
            if (isset($page_id)) {
                $search_post = array(
                    'ID' => $page_id,
                    'post_content' => '[pauple_helpie_search_results_page]',
                );
                wp_update_post($search_post);
            }
        }

        protected function update_from_below_150()
        {
            $options_to_copy = array(
                0 => array(
                    'from' => array('main_page_recent_articles', 'helpie_mp_template'),
                    'to' => array('show_article_listing', 'helpie_mp_template'),
                ),
            );

            $this->migrate_settings_service->copy_option_properties($options_to_copy);
        }

        protected function is_user_version_below($version, $user_version)
        {
            return (isset($user_version) && $user_version < $version) || !isset($user_version);
        }

        public function update_from_version_older_versions($user_version)
        {
            if ($this->is_user_version_below('1.0.0', $user_version)) {
                $this->set_default_values_before_update();
                $this->update_options($user_version);
                $this->set_default_values_after_update();

                $this->set_new_version_in_db();
            }

            if ($this->is_user_version_below('1.0.5', $user_version)) {
                $this->set_default_values_105();

                $this->set_new_version_in_db();
            }

            if ($this->is_user_version_below('1.0.6', $user_version)) {
                $this->set_default_values_106();

                $this->set_new_version_in_db();
            }

            if ($this->is_user_version_below('1.0.8', $user_version)) {
                $this->update_values_108();

                $this->set_new_version_in_db();
            }

            if ($this->is_user_version_below('1.1', $user_version)) {
                $this->update_values_11();

                $this->set_new_version_in_db();
            }

            if ($this->is_user_version_below('1.2.3', $user_version)) {
                $this->update_values_123();

                $this->set_new_version_in_db();
            }
        }

        public function update_options($current_version)
        {
            $is_version_below_100 = (isset($current_version) && $current_version < '1.0.0');
            $is_version_not_set = (!isset($current_version));

            if ($is_version_below_100 || $is_version_not_set) {
                $this->update_below_110->migrate_options_below_100();
            } else {
                // do nothing
            }
        }

        public function set_default_values_105()
        {
            $this->update_below_110->set_default_values_105();
        }

        public function set_default_values_106()
        {
            $this->update_below_110->set_default_values_106();
        }

        public function update_values_108()
        {
            $this->update_below_110->set_default_values_106();
        }

        public function update_values_11()
        {
            $this->update_below_130->update_values_11();
        }

        public function update_values_123()
        {
            $this->update_below_130->update_values_123();
        }

        public function set_new_version_in_db()
        {
            update_option('pauple_helpie_plugin_version', HELPIE_PLUGIN_VERSION);
        }
    } // End of Class
}