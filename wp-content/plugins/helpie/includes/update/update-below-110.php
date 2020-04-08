<?php

namespace Helpie\Includes\Update;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// Class to handle updates from version less than 1.1.0

if (!class_exists('\Helpie\Includes\Update\Update_Below_110')) {
    class Update_Below_110
    {
        public function __construct()
        {
            $this->migrate_settings_service = new \Helpie\Includes\Update\Migrate_Settings_Service();
        }


        public function migrate_options_below_100()
        {
            $options_to_copy = array(
                0 => array(
                    'from' => array( 'helpie_components_options', 'main_page_template' ),
                    'to' => array( 'helpie_mp_options', 'helpie_mp_template'),
                ),

                1 => array(
                    'from' => array( 'helpie_components_options', 'helpie_single_page_sidebar_display'),
                    'to' => array( 'helpie_sp_options', 'helpie_sp_template'),
                    'old_values' => array( 'on', ''),
                    'new_values' => array( 'left-sidebar', 'full-width')
                ),

                2 => array(
                    'from' => array( 'helpie_components_options', 'helpie_cat_page_sidebar_display'),
                    'to' => array( 'helpie_cp_options', 'helpie_cp_template' ),
                    'old_values' => array( 'on', ''),
                    'new_values' => array( 'left-sidebar', 'full-width')
                ),

                3 => array(
                    'from' => array( 'helpie_components_options', 'main_page_categories'),
                    'to' => array( 'helpie_mp_options', 'main_page_categories'),
                ),

                4 => array(
                    'from' => array( 'helpie_components_options', 'main_page_popular'),
                    'to' => array( 'helpie_mp_options', 'main_page_popular'),
                ),

                5 => array(
                    'from' => array( 'helpie_components_options', 'helpie_single_page_search_display'),
                    'to' => array( 'helpie_sp_options', 'helpie_single_page_search_display'),
                ),

                6 => array(
                    'from' => array( 'helpie_components_options', 'helpie_cat_page_search_display'),
                    'to' => array( 'helpie_cp_options', 'helpie_cat_page_search_display'),
                ),
            );
            $this->migrate_settings_service->copy_option_properties($options_to_copy);
        }

        public function set_default_values_105()
        {
            $mp_options = get_option('helpie_mp_options');

            if (!isset($mp_options['helpie_mp_sidebar_template'])) {
                $mp_options['helpie_mp_sidebar_template'] = 'full-width';
            }

            update_option('helpie_mp_options', $mp_options);
        }

        public function set_default_values_106()
        {
            $added_tag = get_option('helpie_show_added_tags');

            if (!$added_tag) {
                $added_tag = array(
                0 => 'all',
              );
            }

            update_option('helpie_show_added_tags', $added_tag);

            $updated_tag = get_option('helpie_show_updated_tags');

            if (!$updated_tag) {
                $updated_tag = array(
                0 => 'all',
              );
            }

            update_option('helpie_show_updated_tags', $updated_tag);
        }

        public function update_values_108()
        {
            $core_options = get_option('helpie_core_options_main');

            if (isset($core_options['helpie_basic_user_access']) && !empty($core_options['helpie_basic_user_access'])) {
                $helpie_user_access_options = array();
                $helpie_user_access_options['helpie_basic_user_access'] = $core_options['helpie_basic_user_access'];
                update_option('helpie_user_access_options', $helpie_user_access_options);
            }
        }
    }
}
