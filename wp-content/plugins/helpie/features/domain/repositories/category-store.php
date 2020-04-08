<?php

namespace Helpie\Features\Domain\Repositories;

/**
 * New Category Query ( May rename as Query_Interpreter)
 *
 */

if (!class_exists('\Helpie\Features\Domain\Repositories\Category_Store')) {
    class Category_Store
    {
        private $wp_query_args;
        private $mp_option_key = 'helpie_mp_options';

        public function __construct($query_vars = array())
        {
            $this->wp_query_args = $query_vars;
            $this->dnd_getter = new \Helpie\Includes\Core\Lib\Dnd\Getter($this->mp_option_key);
        }

        public function get()
        {
            return $this->wp_query_args;
        }

        public function interprete($args)
        {
            if ($args['parent'] == 0) {
                $this->filter($args);
            }
            $this->sort($args['sortby']);

            return $this;
        }

        /* Filters topics in a funnel manner */
        public function filter($args)
        {
            // 1. Filter by topics
            $this->filter_topics($args);
        }

        public function filter_topics($args)
        {
            // error_log('filter_topics');
            // error_log('$args : ' . print_r($args, true));
            if (isset($args['topics'])) {
                $this->wp_query_args['include'] = $this->get_categories_by_topics($args['topics']);
            }
        }

        public function filter_by_dnd($args)
        {
            if (!isset($args['dnd_filter'])) {
                return;
            }

            if ($args['dnd_filter'] == 'mp_dnd') {
                $dnd_included_cats_array = $this->get_all_included_categories();
                $this->filter_wp_query_args($dnd_included_cats_array);
            }
        }

        public function filter_visibilities($args)
        {

            if (!isset($args['site_visibility'])) {
                return new \WP_Error('broke', __(" Missing argument: 'site_visibility' ", "pauple_helpie"));
            }

            switch ($args['site_visibility']) {
                case "visible_only":
                    $this->wp_query_args['exclude'] = $this->get_all_excluded_categories();
                    break;
                default:
                    // default code here
            }

            switch ($args['user_visibility']) {
                case "visible_only":
                    // Do nothing
                    break;
                default:
                    // default code here
            }
        }

        public function filter_wp_query_args($filter_array)
        {

            $previous = $this->wp_query_args['include'];
            if (isset($previous) && !empty($previous)) {
                $this->wp_query_args['include'] = array_intersect($previous, $filter_array);
            } else {
                $this->wp_query_args['include'] = $filter_array;
            }
        }

        public function sort($sortby)
        {

            // $sortby = 'term_order';

            if (isset($sortby)) {
                switch ($sortby) {
                    case "alphabetical":
                        $this->wp_query_args['orderby'] = 'title';
                        $this->wp_query_args['order'] = 'ASC';
                        break;
                    case "popular":
                        $this->wp_query_args['orderby'] = 'meta_value';
                        $this->wp_query_args['order'] = 'DESC';
                        $this->wp_query_args['meta_key'] = 'ph_pageviews';
                        $this->wp_query_args['type'] = 'NUMERIC';
                        break;
                    case "updated":
                        $this->wp_query_args['orderby'] = 'modified';
                        $this->wp_query_args['order'] = 'DESC';
                        break;
                    case "count":
                        $this->wp_query_args['orderby'] = 'count';
                        $this->wp_query_args['order'] = 'DESC';
                        break;
                    case "term_order":
                        $this->wp_query_args['orderby'] = 'meta_value_num';
                        $this->wp_query_args['order'] = 'ASC';
                        $this->wp_query_args['meta_key'] = 'term_order';
                        $this->wp_query_args['type'] = 'NUMERIC';
                        break;
                    default:
                        $this->wp_query_args['orderby'] = 'include';
                        $this->wp_query_args['order'] = 'ASC';
                        break;
                }

                // error_log('$this->wp_query_args : ' . print_r($this->wp_query_args, true));

            }
        } // end sort()

        public function get_categories_by_topics($input_terms = null)
        {
            $categories = array();

            // If Array, then make into a string
            // Input from Elementor comes as array
            if (!is_array($input_terms)) {
                $input_terms_array = explode(",", $input_terms);
            } else {
                $input_terms_array = $input_terms;
            }

            if ($input_terms != 'all') {
                // $input_terms_array = $input_terms;
                return $input_terms_array;
            } else {
                return null;
            }
        }

        // Categories included / dragged via 'Main Page Categories' option
        public function get_all_included_categories()
        {
            return $this->dnd_getter->get_all_included_categories();
        }

        // Categories excluded / dragged-out via 'Main Page Categories' option
        protected function get_all_excluded_categories()
        {
            return $this->dnd_getter->get_all_excluded_categories();
        }
    }
}