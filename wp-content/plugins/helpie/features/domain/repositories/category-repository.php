<?php

namespace Helpie\Features\Domain\Repositories;

/**
 * New Category Query
 *
 */
if (!class_exists('\Helpie\Features\Domain\Repositories\Category_Repository')) {
    class Category_Repository
    {
        private $category_query;

        public function __construct()
        {
            $this->category_query = new \Helpie\Features\Domain\Repositories\Category_Query();
        }

        // Categories that are available to the current user
        public function get_categories($args = array())
        {

            return $this->category_query->get_categories($args);
        }

        public function getMainPageCategories($input_terms = null)
        {
            $args = array(
                'dnd_filter' => 'mp_dnd',
            );
            return $this->category_query->get_categories($args);
        }

        public function get_category_options($show_all = false)
        {
            $category_options = [];
            $visible_terms = $this->get_categories();

            foreach ($visible_terms as $term) {
                if (!isset($term->term_id)) {
                    continue;
                }
                $category_options[$term->term_id] = $term->name;
            }

            if ($show_all == true) {
                $category_options = array('all' => 'All') + $category_options;
            }
            // error_log('Visible Terms : ' . print_r($category_options, true));

            return $category_options;
        }

        // @get_mainpage_category return array term_id.
        public function get_mainpage_category()
        {
            $category = array();
            $terms = $this->get_category_options();

            foreach ($terms as $key => $value) {
                array_push($category, $key);
            }

            return $category;
        }

        public function get_editor_category_options($show_all = false, $args = [], $ii = 0)
        {
            $category_options = [];

            $access_helper = new \Helpie\Features\Services\Access_Control\Helper();
            $topics = $access_helper->get_all_terms_without_filter($args);
            $ii++;

            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();
            foreach ($topics as $term) {

                $can_publish = $dynamic_caps->get_final_topic_has_cap($term->term_id, 'can_publish');
                $can_approve = $dynamic_caps->get_final_topic_has_cap($term->term_id, 'can_approve');

                $has_allowed_child = $this->has_allowed_child_topics($term->term_id);

                if ($can_approve || $can_publish || $has_allowed_child) {
                    $category_options[$term->term_id] = array(
                        'name' => $term->name,
                        'level' => $ii - 1,
                        'parent' => $term->parent,
                        'disabled' => false,
                    );

                    if (!$can_approve && !$can_publish) {
                        $category_options[$term->term_id]['disabled'] = true;
                    }
                    $args = array('parent' => $term->term_id);
                    $categories = $this->get_editor_category_options(false, $args, $ii);
                    $category_options = $category_options + $categories;
                }

            }

            return $category_options;
        }

        protected function has_allowed_child_topics($term_id)
        {
            $child_terms = get_term_children($term_id, 'helpdesk_category');
            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();

            $has_allowed_child = false;

            if (!isset($child_terms) || empty($child_terms)) {
                return $has_allowed_child;
            }

            foreach ($child_terms as $child_term_id) {
                $can_publish = $dynamic_caps->get_final_topic_has_cap($child_term_id, 'can_publish');
                $can_approve = $dynamic_caps->get_final_topic_has_cap($child_term_id, 'can_approve');

                if ($can_approve || $can_publish) {
                    $has_allowed_child = true;
                    break;
                }
            }

            return $has_allowed_child;
        }

        /**
         *  Gets the first ancestor ( top most parent ) term
         *  IE: If 'grand-parent-term' exists, gets 'grand-parent-term' or
         *  if only 'parent-term' exists, gets 'parent-term'->$term_id
         */
        public function get_top_most_parent_term_id($term_id, $taxonomy)
        {
            // start from the current term
            $parent = get_term_by('id', $term_id, $taxonomy);
            // climb up the hierarchy until we reach a term with parent = '0'
            if (isset($parent) && !empty($parent)) {
                while ($parent->parent != '0') {
                    $term_id = $parent->parent;

                    $parent = get_term_by('id', $term_id, $taxonomy);
                }
            }

            return $parent->term_id;
        }

        /* Callbacks
         *
         * These method needs to be public as it is a callback
         *
         */
        public function show_all_callback($query_vars)
        {
            $query_vars['site_visibility'] = 'all';
            return $query_vars;
        }

        /* NOT IN USE */

        // All Top-Level Categories
        // public function getAllCategories()
        // {
        //     add_filter('helpie_kb_category_object_query_args', array($this, 'remove_ua_filter_callback'), 10, 2);
        //     add_filter('helpie_kb_category_object_query_args', array($this, 'show_all_callback'), 10, 2);

        //     return $this->category_query->get_categories();
        // }

        // All categories except excluded categories in Main Page Settings
        // public function getSiteVisibleCategories()
        // {
        //     add_filter('helpie_kb_category_object_query_args', array($this, 'remove_ua_filter_callback'), 10, 2);
        //     return $this->category_query->get_categories();
        // }

        // public function remove_ua_filter_callback($query_vars)
        // {
        //     $query_vars['user_visibility'] = 'all';
        //     return $query_vars;
        // }
    }

}