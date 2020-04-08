<?php

namespace Helpie\Features\Services\Access_Control\Types;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Services\Access_Control\Types\Role_Based')) {
    class Role_Based
    {
        private $taxonomy = 'helpdesk_category';

        public function __construct()
        {
            $this->helper = new \Helpie\Includes\Utils\Pauple_Helper();
            $this->selected_terms_for_user_role = array();
            $this->dnd_getter = new \Helpie\Includes\Core\Lib\Dnd\Getter();
        }

        public function is_category_allowed_for_current_user_new($term_id)
        {
            $user_role_selected_terms = $this->get_selected_terms_for_user_role();
            $dnd_excluded_terms = $this->dnd_getter->get_all_excluded_categories();

            if (in_array('all', $user_role_selected_terms)) {
                return !in_array($term_id, $dnd_excluded_terms);
            }

            $allowed_categories = array_diff($user_role_selected_terms, $dnd_excluded_terms);
            return in_array($term_id, $allowed_categories);
        }

        public function is_category_allowed_for_current_user($term_id, $location = 'other')
        {

            $is_allowed = false;

            $is_allowed_category = $this->is_category_allowed_for_current_user_new($term_id);
            $is_child_of_allowed_category = $this->is_child_of_allowed_terms($term_id, $this->taxonomy);

            // 1. Is allowed category or sub-category of allowed category
            if ($is_allowed_category || $is_child_of_allowed_category) {
                $is_allowed = true;
            }

            // 2. Return $is_allowed if not from single-post template
            if ($location != 'single') {
                return $is_allowed;
            }

            // 3. Is term set
            if (isset($term_id) && !empty($term_id) && $term_id != '') {
                return $is_allowed;
            }

            // 4. Allow articles without terms if "All" categories are allowed
            $user_role_selected_terms = $this->get_selected_terms_for_user_role();

            if (in_array('all', $user_role_selected_terms)) {
                $is_allowed = true;
            }

            return $is_allowed;
        }



        public function get_selected_terms_for_user_role()
        {
            $option_name = '';
            $roles = $this->get_user_roles();

            foreach ($roles as $role) {
                $option_name = $role . '_allowed_helpie_terms';
                break;
            }

            $terms = get_option($option_name);

            // The data structure of the $role.'_allowed_helpie_terms'
            // option now needs this, it might have been different before
            if (isset($terms[$option_name])) {
                $terms = explode(",", $terms[$option_name]);
            }

            if (!isset($terms) || !is_array($terms)) {
                $terms = array();
            }

            return $terms;
        }

        /* Protected Methods */

        protected function is_child_of_allowed_terms($term_id, $taxonomy)
        {
            $top_most_parent_term_id = $this->helper->get_term_top_most_parent($term_id, $taxonomy);

            if (!isset($top_most_parent_term_id) || $top_most_parent_term_id == null) {
                return false;
            }

            $is_allowed_category = $this->is_category_allowed_for_current_user_new($top_most_parent_term_id);

            return $is_allowed_category;
        }
        protected function get_user_roles()
        {
            $current_user = \wp_get_current_user();
            $roles = $current_user->roles;

            return $roles;
        }
    } // END CLASS
}