<?php

namespace Helpie\Features\Services\Access_Control\Strategies;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Services\Access_Control\Strategies\Filter_Get_Terms')) {
    class Filter_Get_Terms
    {

        public function __construct($query, $content)
        {
            $this->access_helper = new \Helpie\Features\Services\Access_Control\Helper();
            $this->query = $query;
            $this->content = $content;
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->terms = null;
        }

        public function filter()
        {

            /* Filtering criteria */
            $this->dynamic_caps_based_filter();
            $this->dnd_exclude();

            // error_log('end Filter_Get_Terms $this->query : ' . print_r($this->query, true));
        }

        protected function dynamic_caps_based_filter()
        {
            $prev_included_topics_in_query = $this->query->query_vars['include'] ?: [];


            $included_topics = (array) $this->content['included']['topics'];

            $exclude = array();
            $no_filter_args = array(
                'parent' => $this->query->query_vars['parent'],
            );

            if (!isset($this->terms) || $this->terms == null) {
                $this->terms = $this->get_all_terms_without_filter($no_filter_args);
            }

            $terms = $this->terms;

            $all_terms_ids = [];
            foreach ($terms as $term) {
                $all_terms_ids[] = $term->term_id;
            }

            // Return if no terms are found
            if (!is_array($terms) && count($terms) < 1) {
                return $terms;
            }

            $new_include = [];
            // Check $include_condition for all terms
            foreach ($terms as $term) {
                $include_condition = $this->term_include_condition($term, $included_topics);

                if ($include_condition) {
                    // $this->query->query_vars['include'][] = $term->term_id;
                    $new_include[] =   $term->term_id;
                } else {
                    $exclude[] = $term->term_id;
                }
            }


            // exclude procedure
            $is_global_excluded = $this->access_helper->is_global_excluded($this->content);


            // Interset with pre-included terms from anywhere else
            if (is_array($prev_included_topics_in_query) && !empty($prev_included_topics_in_query)) {
                $final_include = array_intersect($new_include, $prev_included_topics_in_query);
                $final_include = array_values($final_include);
                $this->query->query_vars['include'] = $final_include;
            }

            if (empty($this->query->query_vars['include']) && !empty($exclude)) {
                $this->query->query_vars['exclude'] = $exclude;
            }


            // Exclude all condition
            if (empty($this->query->query_vars['include']) && !empty($prev_included_topics_in_query)) {

                // error_log('empty result');
                $this->query->query_vars['include'] = false;
                $this->query->query_vars['exclude'] = $all_terms_ids;
            }


            // error_log('after global $this->query->query_vars : ' . print_r($this->query->query_vars['include'], true));
        }

        protected function all_top_level_terms_id()
        {
            $no_filter_args = array(
                'parent' => 0,
            );
            $terms = $this->get_all_terms_without_filter($no_filter_args);

            $all_terms_ids = [];
            foreach ($terms as $term) {
                $all_terms_ids[] = $term->term_id;
            }

            return $all_terms_ids;
        }

        protected function term_include_condition($term, $included_topics)
        {

            $is_included = (in_array($term->term_id, $included_topics));
            $is_topic_excluded = $this->is_term_excluded($term->term_id);
            $has_included_descendants = $this->access_helper->has_included_descendants($term->term_id, $this->content);
            $has_included_posts = $this->has_included_posts($term->term_id);
            $is_parent_excluded = $this->is_parent_excluded($term);
            $is_parent_included = $this->is_parent_included($term);

            $is_global_excluded = $this->access_helper->is_global_excluded($this->content);

            $parent_excluded_condition = ($is_parent_excluded && ($is_included || $has_included_descendants || $has_included_posts));
            $parent_included_condition = (($is_parent_included) && ($is_included || !$is_topic_excluded || $has_included_descendants || $has_included_posts));
            $parent_default_condition = ((!$is_global_excluded  && !$is_parent_excluded) && ($is_included || !$is_topic_excluded || $has_included_descendants || $has_included_posts));

            if ($term->term_id == 17) {
                // error_log('TEST TERM CONDITIONS');
                // error_log('$term->term_id : ' . $term->term_id);
                // error_log('$parent_excluded_condition : ' . $parent_excluded_condition);
                // error_log('$parent_included_condition : ' . $parent_included_condition);
                // error_log('$parent_default_condition : ' . $parent_default_condition);
                // error_log('$is_included : ' . $is_included);
                // error_log('$is_topic_excluded : ' . $is_topic_excluded);
                // error_log('$has_included_descendants : ' . $has_included_descendants);
                // error_log('$has_included_posts : ' . $has_included_posts);
            }

            return ($parent_excluded_condition || $parent_included_condition || $parent_default_condition || $is_included);
        }

        protected function dnd_exclude()
        {
            $helpie_mp_cats = $this->settings->main_page->get_mp_cats();
            $disabled = $helpie_mp_cats['disabled'];
            $disabled_term_ids = [];

            foreach ((array) $disabled as $key => $value) {
                $disabled_term_ids[] = str_replace('term-id_', '', $key);
            }

            $prev_included = $this->query->query_vars['include'] ?: [];
            $new_included = array_diff($prev_included, $disabled_term_ids);

            $prev_excluded = $this->query->query_vars['exclude'] ?: [];
            $new_excluded = array_merge($prev_excluded, $disabled_term_ids);

            /* Set include query */
            $this->query->query_vars['include'] = $new_included;

            // error_log('$prev_included : ' . print_r($prev_included, true));
            // error_log('$disabled_term_ids : ' . print_r($disabled_term_ids, true));
            // error_log('$new_included : ' . print_r($new_included, true));


            /* If there is no previous inclusions */
            if (empty($this->query->query_vars['include']) && !empty($prev_included)) {
                $all_terms_ids = $this->all_top_level_terms_id();
                $this->query->query_vars['include'] = false;
                $this->query->query_vars['exclude'] = $all_terms_ids;
            }

            if (empty($this->query->query_vars['include']) && empty($prev_included)) {
                $this->query->query_vars['include'] = false;
                $this->query->query_vars['exclude'] = $new_excluded;
            }

            // error_log('$this->query->query_vars : ' . print_r($this->query->query_vars, true));
        }

        /* PROTECTED METHODS */

        protected function is_parent_included($term)
        {

            if ($term->parent == 0) {
                $is_global_excluded = $this->access_helper->is_global_excluded($this->content);
                // TODO: Add condition to check Global Access Control
                return !$is_global_excluded;
            }

            return $this->is_term_included($term->parent);
        }

        protected function is_term_included($term_id)
        {
            return $this->access_helper->is_term_excluded($term_id, $this->content);
        }

        protected function is_parent_excluded($term)
        {

            if ($term->parent == 0) {
                $is_global_excluded = $this->access_helper->is_global_excluded($this->content);
                // TODO: Add condition to check Global Access Control

                // error_log('$is_global_excluded : ' . $is_global_excluded);
                return $is_global_excluded;
            }

            return $this->is_term_excluded($term->parent);
        }
        protected function has_included_posts($term_id)
        {
            $included_posts = (array) $this->content['included']['posts'];

            $query_service = \Helpie\Features\Services\Query::getInstance();
            return $query_service->has_included_posts($term_id, $included_posts);
        }



        protected function get_all_terms_without_filter($no_filter_args)
        {
            return $this->access_helper->get_all_terms_without_filter($no_filter_args);
        }

        protected function is_term_excluded($term_id)
        {
            return $this->access_helper->is_term_excluded($term_id, $this->content);
        }
    } // END CLASS
}