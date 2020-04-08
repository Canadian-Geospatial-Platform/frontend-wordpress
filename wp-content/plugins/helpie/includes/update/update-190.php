<?php

namespace Helpie\Includes\Update;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// Class to handle updates from version less than 1.1.0

if (!class_exists('\Helpie\Includes\Update\Update_190')) {
    class Update_190
    {

        public function update()
        {
            error_log(' Update_190->update() ');
            $new_settings = get_option('helpie-kb');

            $new_settings = $this->settings_migration_to_codestar($new_settings);
            $new_settings = $this->migrate_access_control_to_dynamic_caps($new_settings);
            $new_settings = $this->migration_passwords($new_settings);
            $new_settings = $this->migrate_publishing_to_dynamic_caps($new_settings);
            $new_settings['last_version'] = '1.9';

            // Search Page
            $this->search_page_migrate();
            // error_log('$new_settings : ' . print_r($new_settings, true));
            $result = \update_option('helpie-kb', $new_settings);
            $updated_option = get_option('helpie-kb');

            if (isset($updated_option['last_version']) && $updated_option['last_version'] == '1.9') {
                $result = true;
            }

            error_log('Update_190 -> update() $result : ' . $result);
            return $result; // update passed or not  ( boolean )
        }

        private function settings_migration_to_codestar($new_settings)
        {

            // error_log('settings_migration_to_codestar');
            // error_log('$new_settings : ' . print_r($new_settings, true));
            $old_settings = [];
            $old_settings['core'] = get_option('helpie_core_options_main');
            $old_settings['style'] = get_option('helpie_style_options');
            $old_settings['components'] = get_option('helpie_components_options');
            $old_settings['sp'] = get_option('helpie_sp_options');
            $old_settings['cp'] = get_option('helpie_cp_options');
            $old_settings['mp'] = get_option('helpie_mp_options');

            $skip_list = ['kb_edit_capability'];
            $toggle_items = [
                ['core', 'kb_frontend_enable'], ['style', 'helpie_show_search_border'], ['components', 'helpie_breadcrumbs'], ['components', 'helpie_sidebar_fixed'],
                ['components', 'helpie_sidebar_cat_toggle'], ['components', 'helpie_sidebar_category_anchor_link'], ['components', 'helpie_sidebar_auto_toc'],
                ['components', 'helpie_sidebar_show_articles'], ['components', 'helpie_auto_toc_bullet'], ['components', 'helpie_auto_toc_section_page_url'],
                ['components', 'helpie_auto_toc_back_to_top_link'], ['components', 'helpie_auto_toc_scroll_back_to_site_top'], ['components', 'helpie_auto_toc_smooth_scroll'],
                ['mp', 'helpie_mp_show_stats'], ['mp', 'main_page_search_display'], ['mp', 'show_article_listing'], ['mp', 'main_page_categories'], ['mp', 'helpie_mp_boxed_description'],
                ['sp', 'helpie_single_page_search_display'], ['sp', 'helpie_single_page_updatedby_display'], ['sp', 'helpie_single_page_updatedon_display'], ['sp', 'helpie_single_page_show_pageviews'],
                ['sp', 'helpie_voting_access'], ['sp', 'helpie_show_comments'], ['mp', 'helpie_cat_page_search_display'],
            ];

            foreach ($old_settings as $key => $setting) {

                foreach ($setting as $singleOptionkey => $singleOptionValue) {

                    if (in_array($singleOptionkey, $skip_list)) {
                        continue;
                    }

                    // For image fields
                    if ($singleOptionkey == 'helpie_wa_image') {
                        $singleOptionValue = $this->image_loop_action($singleOptionValue);
                    }

                    // MP DND - include
                    if ($singleOptionkey == 'helpie_mp_cats') {
                        $new_settings = $this->mp_include_cats_loop_action($new_settings, $singleOptionkey, $singleOptionValue);
                        continue;
                    }

                    // MP DND - exclude
                    if ($singleOptionkey == 'helpie_excluded_mp_cats') {
                        $new_settings = $this->mp_exclude_cats_loop_action($new_settings, $singleOptionValue);
                        continue;
                    }

                    // Final Assignment of singleOptionValue to Key

                    $new_settings[$singleOptionkey] = $singleOptionValue;
                }
            }

            // error_log('$old_settings : ' . print_r($old_settings, true));

            // For Toggle Fields
            $new_settings = $this->final_toggle_action($new_settings, $old_settings, $toggle_items);
            // For multi-select options
            $new_settings = $this->final_multiselect_action($new_settings);
            // Additional 'helpie_mp_cats' ( categories DND ) action
            $new_settings = $this->final_mp_cats_action($new_settings);

            // error_log('$new_settings : ' . print_r($new_settings, true));

            return $new_settings;
        }

        private function image_loop_action($singleOptionValue)
        {
            $attachment_id = $singleOptionValue;
            $src_url = wp_get_attachment_url($attachment_id);
            $singleOptionValue = [];
            $singleOptionValue['url'] = $src_url;
            $singleOptionValue['id'] = $attachment_id;

            return $singleOptionValue;
        }

        private function mp_exclude_cats_loop_action($new_settings, $singleOptionValue)
        {
            if (!isset($new_settings['helpie_mp_cats']) || !is_array($new_settings['helpie_mp_cats'])) {
                $new_settings['helpie_mp_cats'] = [];
            }

            $old_disabled = explode(',', $singleOptionValue);
            $new_settings['helpie_mp_cats']['disabled'] = [];

            foreach ($old_disabled as $term_id) {
                $term_exists = term_exists((int)$term_id, 'helpdesk_category');

                if (!isset($term_id) || $term_id == '' || $term_exists === 0 || $term_exists === null) {
                    continue;
                }

                $term = get_term($term_id, 'helpdesk_category');
                $new_settings['helpie_mp_cats']['disabled']['term-id_' . $term_id] = $term->name;
            }

            return $new_settings;
        }

        private function mp_include_cats_loop_action($new_settings, $singleOptionValue)
        {
            if (!isset($new_settings['helpie_mp_cats']) || !is_array($new_settings['helpie_mp_cats'])) {
                $new_settings['helpie_mp_cats'] = [];
            }

            $old_enabled = explode(',', $singleOptionValue);
            $new_settings['helpie_mp_cats']['enabled'] = [];

            foreach ($old_enabled as $term_id) {
                $term_exists = term_exists((int)$term_id, 'helpdesk_category');

                if (!isset($term_id) || $term_id == '' || $term_exists === 0 || $term_exists === null) {
                    continue;
                }

                $term = get_term($term_id, 'helpdesk_category');
                $new_settings['helpie_mp_cats']['enabled']['term-id_' . $term_id] = $term->name;
            }

            return $new_settings;
        }
        private function final_toggle_action($new_settings, $old_settings, $toggle_items)
        {
            foreach ($toggle_items as $item) {
                $item_name = $item[1];
                $old_settings_key = $item[0];
                $isset_condition = array_key_exists($item_name, $old_settings[$old_settings_key]) && !empty($old_settings[$old_settings_key][$item_name]);

                if ($isset_condition && $old_settings[$old_settings_key][$item_name] == 'on') {
                    $new_settings[$item_name] = "1";
                } else {
                    $new_settings[$item_name] = "0";
                }
            }

            return $new_settings;
        }

        private function final_multiselect_action($new_settings)
        {
            // $multiselect_options = ['helpie_auto_toc_exclude_headings'];
            $old_exclude_heading = get_option('helpie_auto_toc_exclude_headings');
            $new_settings['helpie_auto_toc_exclude_headings'] = isset($old_exclude_heading['helpie_auto_toc_exclude_headings']) ? explode(',', $old_exclude_heading['helpie_auto_toc_exclude_headings']) : [];
            return $new_settings;
        }

        private function final_mp_cats_action($new_settings)
        {
            $terms = $this->get_top_level_terms();

            $enabled_disabled_terms = [];

            if (!isset($new_settings['helpie_mp_cats']) || !is_array($new_settings['helpie_mp_cats'])) {
                $new_settings['helpie_mp_cats'] = ['enabled' => [], 'disabled' => []];
            }

            if (!isset($new_settings['helpie_mp_cats']['disabled']) || !is_array($new_settings['helpie_mp_cats']['disabled'])) {
                $new_settings['helpie_mp_cats']['disabled'] = [];
            }

            foreach ($new_settings['helpie_mp_cats']['enabled'] as $key => $value) {
                $term_id = str_replace('term-id_', '', $key);
                array_push($enabled_disabled_terms, $term_id);
            }

            foreach ($new_settings['helpie_mp_cats']['disabled'] as $key => $value) {
                $term_id = str_replace('term-id_', '', $key);
                array_push($enabled_disabled_terms, $term_id);
            }

            foreach ($terms as $term) {

                if (!in_array($term->term_id, $enabled_disabled_terms)) {
                    $new_settings['helpie_mp_cats']['enabled']['term-id_' . $term->term_id] = $term->name;
                }
            }
            return $new_settings;
        }

        private function migrate_publishing_to_dynamic_caps($new_settings)
        {

            // $new_settings = \get_option('helpie-kb');

            $dynamic_caps_option = $new_settings['helpie_dynamic_capability'];

            if (!isset($dynamic_caps_option) || !is_array($dynamic_caps_option)) {
                $dynamic_caps_option = [];
            }

            $caps = ['edit', 'publish', 'approve'];
            foreach ($caps as $cap) {
                $ruleset = array();
                $option_name = 'kb_' . $cap . '_capability';
                $option = get_option($option_name);

                if (!isset($option) || empty($option)) {
                    continue;
                }

                $cap_roles = $option[$option_name];
                $cap_roles = explode(',', $cap_roles);


                // TODO: Refactor using strtolower and array_map
                if (($key = array_search('administrator', $cap_roles)) !== false) {
                    unset($cap_roles[$key]);
                }

                if (($key = array_search('Administrator', $cap_roles)) !== false) {
                    unset($cap_roles[$key]);
                }


                if (in_array('anyone', $cap_roles)) {
                    $ruleset['type'] = 'all';
                } else if (empty($cap_roles)) {
                    $ruleset['type'] = 'none';
                } else {
                    $ruleset['type'] = 'roles';
                    $ruleset['rule'] = 'only';
                    $ruleset['roles'] = $cap_roles;
                }

                $dynamic_caps_option['can_' . $cap] = $ruleset;
            }
            $new_settings['helpie_dynamic_capability'] = $dynamic_caps_option;
            // \update_option('helpie-kb', $new_settings);
            return $new_settings;
        }

        private function search_page_migrate()
        {
            $page_id = get_option('helpdesk_search_page_id');

            if (!isset($page_id)) {
                return;
            }

            $post = get_post($page_id);
            $search_page_content = $post->post_content;
            if (isset($search_page_content) && (empty($search_page_content) || $search_page_content == '')) {
                $search_post = array(
                    'ID' => $page_id,
                    'post_content' => '[pauple_helpie_search_results_page]',
                );
                wp_update_post($search_post);
            }
        }

        private function migration_passwords($new_settings)
        {
            $pass_key = 'helpie_password_options';
            $password_options = get_option($pass_key);

            if (!isset($new_settings[$pass_key]) || !is_array($new_settings[$pass_key])) {
                $new_settings[$pass_key] = [];
            }

            foreach ($password_options as $old_key => $value) {

                $iterator = preg_replace("/[^0-9\.]/", '', $old_key); // Get numbers from string
                $new_key = preg_replace('/[0-9]+/', '', $old_key); // Remove numbers from string
                $new_key = rtrim($new_key, "_"); // remove last "_"

                $new_settings[$pass_key][$iterator] = isset($new_settings[$pass_key][$iterator]) ? $new_settings[$pass_key][$iterator] : [];

                if ($new_key == 'password_for_content') {
                    $new_settings[$pass_key][$iterator][$new_key] = explode(",", $value);
                } else {
                    $new_settings[$pass_key][$iterator][$new_key] = $value;
                }
            }

            return $new_settings;
        }

        private function migrate_access_control_to_dynamic_caps($new_settings)
        {
            $dynamic_caps_option = $new_settings['helpie_dynamic_capability'];

            $basic_ua = 'anyone';
            $plugin_settings = get_option('helpie_user_access_options');

            if (isset($plugin_settings['helpie_basic_user_access']) && !empty($plugin_settings['helpie_basic_user_access'])) {
                $basic_ua = $plugin_settings['helpie_basic_user_access'];
            }

            if ($basic_ua == 'logged-in-user') {
                $new_settings = $this->basic_ua_condition_loggedin($new_settings);
            }

            $this->get_unselected_terms_for_user_role($basic_ua);

            return $new_settings;
        }

        private function basic_ua_condition_loggedin($new_settings)
        {

            if (!isset($new_settings['helpie_dynamic_capability']) || !is_array($new_settings['helpie_dynamic_capability'])) {
                $new_settings['helpie_dynamic_capability'] = [];
            }
            $dynamic_caps_option = $new_settings['helpie_dynamic_capability'];
            if (!isset($dynamic_caps_option['can_view']) || !is_array($dynamic_caps_option['can_view'])) {
                $dynamic_caps_option['can_view'] = [];
            }
            $dynamic_caps_option['can_view']['type'] = 'logged_in';

            $new_settings['helpie_dynamic_capability'] = $dynamic_caps_option;

            return $new_settings;
        }

        private function get_top_level_terms()
        {
            $args = array(
                "taxonomy" => 'helpdesk_category',
                // "hide_empty" => 1,
                "parent" => 0,
            );
            remove_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Remove action for this specific get_term_children()
            $top_level_terms = get_terms($args);
            add_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Add action to reset original filter

            return $top_level_terms;
        }
        private function unselected_topics_for_role($selected_topics)
        {
            $top_level_terms = $this->get_top_level_terms();
            $unselected_topics = array();

            foreach ($top_level_terms as $term) {

                if (!in_array($term->term_id, $selected_topics)) {
                    array_push($unselected_topics, $term);
                }
            }

            return $unselected_topics;
        }

        private function get_terms_as_array($terms)
        {
            // The data structure of the $role.'_allowed_helpie_terms'
            // option now needs this, it might have been different before
            if (isset($terms)) {
                $terms = explode(",", $terms);
            }

            if (!isset($terms) || !is_array($terms)) {
                $terms = array();
            }

            return $terms;
        }

        private function get_unselected_terms_for_user_role($basic_ua)
        {

            $option_name = '';
            global $wp_roles;

            $roles = $wp_roles->roles;

            $term_exluded_roles = array();
            foreach ($roles as $role_name => $role) {

                if ($role_name == 'administrator') {
                    continue;
                }
                $option_name = $role_name . '_allowed_helpie_terms';

                $terms_from_options = get_option($option_name);
                $term_id_array = $this->get_terms_as_array($terms_from_options[$option_name]);

                if (in_array('all', $term_id_array)) {
                    continue;
                }

                // Get unselected_topics for role
                $unselected_topics = $this->unselected_topics_for_role($term_id_array);

                // Get add role to unselected term_exluded_roles
                if (isset($unselected_topics) && !empty($unselected_topics)) {
                    foreach ($unselected_topics as $term) {
                        if (!isset($term_exluded_roles[$term->term_id]) || !is_array($term_exluded_roles[$term->term_id])) {
                            $term_exluded_roles[$term->term_id] = array();
                        }

                        array_push($term_exluded_roles[$term->term_id], $role_name);
                    }
                }
            }

            // error_log('$unselected_topics : ' . print_r($unselected_topics, true));
            // error_log('$term_exluded_roles : ' . print_r($term_exluded_roles, true));

            // Setting $all_meta_value ( term_rules )
            if (isset($term_exluded_roles) && !empty($term_exluded_roles)) {
                foreach ($term_exluded_roles as $term_id => $excluded_roles) {

                    $all_meta_value = ['can_view' => []];
                    $meta_value = isset($all_meta_value['can_view']) ? $all_meta_value['can_view'] : [];
                    $meta_value['type'] = 'roles';
                    $meta_value['rule'] = 'all_except';
                    $meta_value['roles'] = $excluded_roles;

                    // Exclude 'guest' role if its logged-in-user
                    if ($basic_ua == 'logged-in-user') {
                        array_push($meta_value['roles'], 'guest');
                    }

                    $all_meta_value['can_view'] = $meta_value;
                    $result = update_term_meta($term_id, '_helpie_kb_options', $all_meta_value);
                    // error_log('$all_meta_value : ' . print_r($all_meta_value, true));
                    // error_log('$result : ' . $result);
                }
            }
        }
    } // END CLASS

}