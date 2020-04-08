<?php

namespace Helpie\Includes\Core\Lib\Dnd;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Core\Lib\Dnd\Getter')) {
    class Getter
    {

        private $mp_cats = '';

        public function __construct()
        {
            // $this->option_key = $option_key;
            $this->option_key = 'helpie_mp_options';
        }

        // Categories included / dragged via 'Main Page Categories' option
        public function get_all_included_categories()
        {
            $mp_included_cat_array = $this->get_included_categories_without_newly_added();

            // Object with all helpdesk_categories
            $terms = get_terms('helpdesk_category', array('parent' => 0, 'hide_empty' => false));

            // Loop through all the helpdesk_categories and add categories which are not excluded
            foreach ($terms as $term) {
                if (!isset($term->term_id)) {
                    continue;
                }
                $key = $term->term_id;
                // Push newly created 'term_id' ( $key)
                if ($this->is_assorted_category($key)) {
                    array_push($mp_included_cat_array, $key);
                }
            }

            return $mp_included_cat_array;
        }

        // Check if the category is assorted,
        // i.e: new category which is neither included nor excluded by the Admin
        public function is_assorted_category($category_id)
        {
            $mp_excluded_cat_array = $this->get_all_excluded_categories();
            $mp_included_cat_array = $this->get_included_categories_without_newly_added();

            $not_in_included_list = (!in_array($category_id, $mp_included_cat_array));
            $not_in_excluded_list = (!in_array($category_id, $mp_excluded_cat_array));

            if ($not_in_included_list && $not_in_excluded_list) {
                return true;
            }

            return false;
        }

        // Categories excluded / dragged-out via 'Main Page Categories' option
        public function get_all_excluded_categories()
        {
            $mp_grp = get_option($this->option_key);

            $mp_excluded_cats = '';
            if (isset($mp_grp) && isset($mp_grp['helpie_excluded_mp_cats']) && !empty($mp_grp['helpie_excluded_mp_cats'])) {
                $mp_excluded_cats = $mp_grp['helpie_excluded_mp_cats'];
            }

            $mp_excluded_cat_array = array_filter(explode(',', $mp_excluded_cats));

            if (!isset($mp_excluded_cat_array) || !is_array($mp_excluded_cat_array)) {
                $mp_excluded_cat_array = array();
            }

            return $mp_excluded_cat_array;
        }

        // These are the categories that are stored when you drag and drop
        public function get_included_categories_without_newly_added()
        {
            $mp_grp = get_option($this->option_key);

            if (isset($mp_grp) && isset($mp_grp['helpie_mp_cats']) && !empty($mp_grp['helpie_mp_cats'])) {
                $this->mp_cats = $mp_grp['helpie_mp_cats'];
            }
            $mp_included_cat_array = array_filter(explode(',', $this->mp_cats));

            return $mp_included_cat_array;
        }

    } // END CLASS
}