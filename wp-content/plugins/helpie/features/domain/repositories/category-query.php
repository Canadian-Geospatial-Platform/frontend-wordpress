<?php

namespace Helpie\Features\Domain\Repositories;

/**
 * New Category Query Object
 * NOTE: Don't use this anywhere else except Repositories
 */
if (!class_exists('\Helpie\Features\Domain\Repositories\Category_Query')) {
    class Category_Query extends \Helpie\Includes\Abstracts\Object_Query
    {

        /**
         * Get categories matching the current query vars.
         *
         * @return array|object of Kb_Article objects
         */

        public function get_categories($args = array())
        {
            $default_wp_args = $this->get_query_vars();
            $default_domain_args = $this->get_default_domain_args();
            $user_args = array_merge($default_wp_args, $default_domain_args, $args);
            $args = apply_filters('helpie_kb_category_object_query_args', $user_args);
            $results = $this->query($args);
            return apply_filters('helpie_kb_category_object_query', $results, $args);
        }

        public function get_default_domain_args()
        {

            return array(
                'topics' => 'all',
                'dnd_filter' => 'mp_dnd'
            );
        }
        /***
         * Implements User Queries from Shortcodes and
         * Should implement : sortBy, topics, user_visibility, site_visibility
         */
        public function query($query_vars)
        {

            $wp_query_args = $this->get_wp_query_args($query_vars);
            // error_log('$wp_query_args : ' . print_r($wp_query_args, true));
            $results = get_terms($wp_query_args);
            return $results;
        }

        /**
         * Valid query vars for categories.
         *
         * @return array
         */

        protected function get_default_query_vars()
        {
            return array_merge(
                parent::get_default_query_vars(),
                array(
                    'taxonomy' => 'helpdesk_category',
                    'parent' => 0,
                    'orderby' => 'include',
                    'order' => 'ASC', // matches the order of including
                    'hide_empty' => false,
                    'site_visibility' => 'visible_only',
                    'user_visibility' => 'visible_only',
                    'sortby' => 'default',
                )
            );
        }

        /**
         * Get valid WP_Query args from a Helpie_Category_Query's query variables.
         *
         * @since 3.2.0
         * @param array $query_vars Query vars from a Helpie_Category_Query.
         * @return array
         */
        protected function get_wp_query_args($query_vars)
        {
            // $wp_query_args = $query_vars;
            $store = new \Helpie\Features\Domain\Repositories\Category_Store($query_vars);
            $interpreted_wp_query_args = $store->interprete($query_vars)->get();
            $wp_query_args = wp_parse_args($interpreted_wp_query_args, $query_vars);
            return $wp_query_args;
        }
    } // END CLASS
}