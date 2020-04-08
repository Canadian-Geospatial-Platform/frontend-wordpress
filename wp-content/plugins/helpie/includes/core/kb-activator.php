<?php

namespace Helpie\Includes\Core;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * Fired during plugin activation.
 * This class defines all code necessary to run during the plugin's activation.
 */

include_once HELPIE_PLUGIN_PATH . 'includes/update/update-handler.php';
include_once HELPIE_PLUGIN_PATH . 'includes/utils/test-helpers.php';

if (!class_exists('\Helpie\Includes\Core\Kb_Activator')) {
    class Kb_Activator
    {
        public static function activate()
        {
            $cpt = new \Helpie\Includes\Core\Class_Cpt();
            $cpt->register_element();

            // Create Pages
            self::create_page('helpdesk_search', 'helpdesk_search_page_id', 'Helpdesk Search', '[pauple_helpie_search_results_page]');
            self::create_page('helpie_editor_page', 'helpie_editor_page_id', 'Helpie Editor');

            if (self::is_settings_present() == false) {
                self::store_default_settings();
            }

            // Create Dummy Post, Term
            self::setup_dummy_content();

            flush_rewrite_rules();
        }

        public static function create_page($slug, $page_option_name, $page_title, $page_content = '')
        {
            $page_id = get_option($page_option_name);
            if (empty($page_id)) {
                $create_pages = new \Helpie\Includes\Core\Create_Pages();
                $create_pages->create($slug, $page_option_name, $page_title, $page_content);
            }
        }

        public static function setup_dummy_content()
        {
            $queried = new \WP_Query(['post_type' => HELPIE_POST_TYPE, 'post_status' => ['publish', 'trash']]);

            if ($queried->post_count < 1 && self::is_onboarding_skipped_or_imported_once()) {
                $helper = new \Helpie\Includes\Utils\Test_Helpers();
                $helper->insert_term_with_post(HELPIE_POST_TYPE, 'Getting Started', 'helpdesk_category', 'Your first Knowledge Base Article');
            }
            wp_reset_postdata();
        }

        public static function is_settings_present()
        {
            $is_settings_present = false;

            $helpie_core_options_main = get_option('helpie_core_options_main');

            $helpie_components_options = get_option('helpie_components_options');
            $helpie_mp_options = get_option('helpie_mp_options');
            $helpie_sp_options = get_option('helpie_sp_options');
            $helpie_cp_options = get_option('helpie_cp_options');

            if ((isset($helpie_core_options_main) && !empty($helpie_core_options_main))
                || (isset($helpie_components_options) && !empty($helpie_components_options))
                || (isset($helpie_mp_options) && !empty($helpie_mp_options))
                || (isset($helpie_sp_options) && !empty($helpie_sp_options))
                || (isset($helpie_cp_options) && !empty($helpie_cp_options))
            ) {
                $is_settings_present = true;
            }

            return $is_settings_present;
        }

        public static function store_default_settings()
        {

            // Core  options

            $option1 = array(
                'kb_main_title' => 'Helpdesk',
                'helpie_basic_user_access' => 'anyone',
                'kb_main_subtitle' => 'We’re here to help.',
            );
            update_option('helpie_core_options_main', $option1);

            // Style  options
            $style_options = array(
                'helpie_search_border_style' => 'semi-rounded',
            );
            update_option('helpie_style_options', $style_options);

            // User Access  options

            $roles = get_editable_roles();
            foreach ($roles as $role_key => $value) {
                $option2 = array(
                    0 => 'all',
                );
                $option_name = $role_key . '_allowed_helpie_terms';
                update_option($option_name, $option2);
            }

            // Component  options

            $option3 = array(
                'helpie_breadcrumbs' => 'on',
                'helpie_sidebar_type' => 'full-nav',
                'helpie_cat_page_sidebar_display' => 'on',
            );

            update_option('helpie_components_options', $option3);

            // Main Page options
            $terms = get_terms('helpdesk_category', array(
                'parent' => 0,
                'hide_empty' => false,
            ));

            $default_helpie_mp_cats = '';
            foreach ($terms as $term) {
                $default_helpie_mp_cats .= $term->term_id . ',';
            }

            $mp_options = array(
                'main_page_categories' => 'on',
                'main_page_popular' => 'on',
                // 'helpie_mp_template' => 'boxed1',
                'main_page_search_display' => 'on',
                'helpie_mp_cats' => $default_helpie_mp_cats,
                'helpie_mp_location' => 'archive',
            );
            update_option('helpie_mp_options', $mp_options);

            // Single Page options

            $sp_options = array(
                'helpie_single_page_search_display' => 'on',
            );
            update_option('helpie_sp_options', $sp_options);

            // Category Page options

            $cp_options = array(
                'helpie_cat_page_search_display' => 'on',
            );
            update_option('helpie_cp_options', $cp_options);

            // Frontend editing
            $core_options = get_option('helpie_core_options_main');

            if (isset($core_options['kb_frontend_enable']) && !empty($core_options['kb_frontend_enable'])) {
                $helpie_user_access_options['kb_frontend_enable'] = 'on';
                update_option('helpie_core_options_main', $helpie_user_access_options);
            }

            $kb_user = new \Helpie\Features\Domain\Models\Kb_User();
            // We use 'default_review_roles' to set default 'kb_edit_capability'
            $kb_edit_capability = $kb_user->get_default_review_roles();

            update_option('kb_edit_capability', $kb_edit_capability);
        }

        public static function is_onboarding_skipped_or_imported_once()
        {
            $skipped_or_imported_once = false;
            $imported = get_option('helpiekb_imported_entries');
            $skipped = get_option('onboarding_setup_notice_dismissed');

            if (!empty($imported) || !empty($skipped)) {
                $skipped_or_imported_once = true;
            }

            return $skipped_or_imported_once;
        }
    } // END CLASS
}
