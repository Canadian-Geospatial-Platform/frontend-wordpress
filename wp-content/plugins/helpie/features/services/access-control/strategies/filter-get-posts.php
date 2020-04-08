<?php

namespace Helpie\Features\Services\Access_Control\Strategies;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Services\Access_Control\Strategies\Filter_Get_Posts')) {
    class Filter_Get_Posts
    {

        public function __construct($query, $content)
        {
            $this->access_helper = new \Helpie\Features\Services\Access_Control\Helper();
            $this->query = $query;
            $this->content = $content;
        }
        public function filter()
        {
            // error_log('filter-get-post');

            // error_log('$this->before_query : ' . print_r($this->query, true));
            $this->setup_AND_criteria();
            $this->exclude_global();
            $this->exclude_topics();
            $this->include_topics();
            $this->exclude_posts();
            $this->include_posts();

            // error_log('$this->query : ' . print_r($this->query, true));
        }

        public function setup_AND_criteria()
        {
            $tax_query = $this->query->get('tax_query') ?: array();

            if (!isset($tax_query['relation'])) {
                $tax_query['relation'] = 'AND';
                $this->query->set('tax_query', $tax_query);
            }
        }

        public function exclude_global()
        {

            if ($this->content['global'] != true) {
                error_log('exclude_global');
                $tax_query = $this->query->get('tax_query') ?: array();
                $tax_query[] = array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'helpdesk_category',
                        'field' => 'id',
                        'terms' => [],
                        'include_children' => false,
                    )
                );

                $this->query->set('tax_query', $tax_query);
            }
        }


        public function exclude_topics()
        {
            // error_log('$this->content : ' . print_r($this->content, true));
            $excluded_topics = (array) $this->content['excluded']['topics'];
            foreach ($excluded_topics as $topic_id) {
                $this->exclude_topic($topic_id);
            }
        }

        public function include_topics()
        {
            $included_topics = (array) $this->content['included']['topics'];

            foreach ($included_topics as $topic_id) {

                // Include Topic only if parent is excluded
                // $this->include_topic_if_needed($topic_id);

                $should_topic_be_included = $this->should_topic_be_included($topic_id);

                if ($should_topic_be_included) {
                    $this->include_topic($topic_id); // include parent topic
                }
            }
        }

        public function exclude_posts()
        {
            $excluded_posts = (array) $this->content['excluded']['posts'];
            foreach ($excluded_posts as $post_id) {
                array_push($this->query->query_vars['post__not_in'], $post_id);
            }
        }

        public function include_posts()
        {
            $included_posts = (array) $this->content['included']['posts'];

            foreach ($included_posts as $post_id) {
                $terms_ids = $this->get_terms_without_filter($post_id);

                // If no terms are foung, go to next iteration
                if (!isset($terms_ids) || empty($terms_ids)) {
                    continue;
                }

                foreach ($terms_ids as $term_id) {

                    $should_topic_be_included = $this->should_topic_be_included($term_id);
                    $is_term_included = $this->access_helper->is_term_included($term_id, $this->content);

                    $unexclude_condition = $this->unexclude_topic_condition($term_id);
                    $include_condition = (!$is_term_included && $should_topic_be_included);

                    if ($include_condition) {
                        $this->include_topic($term_id); // include parent topic
                    }

                    if ($unexclude_condition) {
                        // $this->include_topic($term_id); // unexclude parent topic
                        $this->manipulate_topic($term_id, 'NOT IN', 'remove');
                    }

                    if ($include_condition || $unexclude_condition) {
                        $this->exclude_other_unincluded_child_topics($term_id);
                        $this->exclude_other_unincluded_posts_of_topic($term_id);
                    }
                }
            }
        }

        /* PROTECTED METHODS */

        protected function unexclude_topic_condition($term_id)
        {
            $is_term_excluded = $this->is_term_excluded($term_id);
            return $is_term_excluded;
        }
        protected function should_topic_be_included($topic_id)
        {
            $is_global_excluded = $this->access_helper->is_global_excluded($this->content);

            $term = get_term($topic_id, 'helpdesk_category');
            if (($term->parent == 0) && ($is_global_excluded)) {
                return true;
            }

            $parent_term_id = $term->parent;

            // $is_parent_excluded = true;
            $is_parent_excluded = $this->is_term_excluded($parent_term_id);
            $is_parent_not_included = $this->access_helper->is_term_not_included($parent_term_id, $this->content);
            if ($is_parent_excluded || ($is_global_excluded && $is_parent_not_included)) {
                return true;
            } else {
                return false;
            }
        }

        protected function get_terms_without_filter($post_id)
        {
            return $this->access_helper->get_terms_without_filter($post_id);
        }

        protected function is_term_excluded($term_id)
        {
            return $this->access_helper->is_term_excluded($term_id, $this->content);
        }

        protected function exclude_other_unincluded_child_topics($term_id)
        {
            $term = get_term($term_id, 'helpdesk_category');

            if (($term->parent == 0)) {
                return;
            }

            $parent_term_id = $term->parent;
            $terms = $this->get_term_children($parent_term_id);
            $included_terms = (array) $this->content['included']['topics'];

            foreach ($terms as $term_id) {
                if (!in_array($term_id, $included_terms)) {
                    $this->exclude_topic($term_id);
                }
            }

            $this->remove_topic_from_not_in_and_in($parent_term_id);
        }

        protected function get_term_children($term_id)
        {
            remove_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Remove action for this specific get_term_children()
            $terms = get_term_children($term_id, 'helpdesk_category');
            add_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Add action to reset original filter

            return $terms;
        }

        protected function remove_topic_from_not_in_and_in($term_id)
        {
            $excluded_topics = (array) $this->content['excluded']['topics'];
            $included_topics = (array) $this->content['included']['topics'];

            if (!in_array($term_id, $excluded_topics)) {
                $this->manipulate_topic($term_id, 'NOT IN', 'remove');
            }
            if (!in_array($term_id, $included_topics)) {
                $this->manipulate_topic($term_id, 'IN', 'remove');
            }
        }

        protected function exclude_other_unincluded_posts_of_topic($term_id)
        {
            // error_log('exclude_other_unincluded_posts_of_topic: ' . $term_id);
            // Remove action for this specific get_posts()
            $posts = $this->get_top_level_articles($term_id);
            // error_log('posts count:  ' . count($posts));
            $included_articles = (array) $this->content['included']['posts'];

            foreach ($posts as $post) {
                // error_log('unincluded_posts_of_topic post_id: ' . $post->ID);
                $is_article_unincluded = (!in_array($post->ID, $included_articles));
                // $is_topic_unincluded = true;

                if ($is_article_unincluded) {
                    array_push($this->query->query_vars['post__not_in'], $post->ID);
                }
            }
        }

        protected function get_posts_of_topic($term_id)
        {
            remove_action('pre_get_posts', 'helpie_kb_filter_posts');

            $posts = get_posts(array(
                'post_type' => 'pauple_helpie',
                'numberposts' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'helpdesk_category',
                        'field' => 'id',
                        'terms' => $term_id,
                        'include_children' => false,
                    ),
                ),
            ));

            add_action('pre_get_posts', 'helpie_kb_filter_posts');

            return $posts;
        }

        public function get_top_level_articles($term_id)
        {

            // error_log('filter-get-posts get_top_level_articles() ');
            remove_action('pre_get_posts', 'helpie_kb_filter_posts');
            $term = get_term($term_id, 'helpdesk_category');
            $kb_category = new \Helpie\Features\Domain\Models\Kb_Category($term);
            $top_level_articles = $kb_category->get_top_level_articles('-1');
            // error_log('$top_level_articles : ' . print_r($top_level_articles, true));
            add_action('pre_get_posts', 'helpie_kb_filter_posts');

            return $top_level_articles;
        }

        protected function get_posts_of_topic_not_in_excluded_topics($term_id)
        {

            $excluded_topics = (array) $this->content['excluded']['topics'];
            remove_action('pre_get_posts', 'helpie_kb_filter_posts');

            $posts = get_posts(array(
                'post_type' => 'pauple_helpie',
                'numberposts' => -1,
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'helpdesk_category',
                        'field' => 'id',
                        'terms' => $term_id,
                        'operator' => 'IN',
                        'include_children' => false,
                    ),
                    array(
                        'taxonomy' => 'helpdesk_category',
                        'field' => 'id',
                        'terms' => $excluded_topics,
                        'operator' => 'NOT IN',
                        'include_children' => false,
                    ),
                ),
            ));

            add_action('pre_get_posts', 'helpie_kb_filter_posts');

            return $posts;
        }

        protected function exclude_topic($term_id)
        {
            // error_log('exclude_topic');
            $this->manipulate_topic($term_id, 'NOT IN');
        }

        protected function include_topic($term_id)
        {
            // error_log('include_topic: term_id: ' . $term_id);
            $this->manipulate_topic($term_id, 'IN');
        }

        protected function get_primary_filter_query($tax_query)
        {
            $index = false;

            foreach ($tax_query as $key => $query) {

                if (!is_array($query)) {
                    continue;
                }

                if (isset($query['relation']) && 'OR' == $query['relation']) {

                    $index = $key;
                    break;
                }
            }

            return $index;
        }
        protected function get_index_of_operation_tax_query($tax_query, $operator)
        {
            $index = false;

            foreach ($tax_query as $key => $query) {

                if (!is_array($query)) {
                    continue;
                }

                if (isset($query['operator']) && $operator == $query['operator']) {
                    $index = $key;
                    break;
                }
            }

            return $index;
        }

        protected function manipulate_topic($term_id, $operator, $action = 'add')
        {

            // $prev_taxquery = $this->query->get('tax_query');
            $tax_query = $this->query->get('tax_query') ?: array();
            // error_log('$tax_query : ' . print_r($tax_query, true));
            $primary_index = $this->get_primary_filter_query($tax_query); // param used for helpie's filtering ( inside 'OR' )

            if (is_numeric($primary_index)) {
                $filter_args = $tax_query[$primary_index];
            } else {
                $filter_args = array(
                    'relation' => 'OR',
                );
            }
            $tax_query_index = $this->get_index_of_operation_tax_query($filter_args, $operator);

            if (is_numeric($tax_query_index)) {
                $exclude_args = $filter_args[$tax_query_index];
                $exclude_args = $this->execute_action($exclude_args, $term_id, $action);
                $filter_args[$tax_query_index] = $exclude_args;
            } else {
                $exclude_args = array(
                    'taxonomy' => 'helpdesk_category',
                    'field' => 'id',
                    'terms' => array(),
                    'operator' => $operator,

                );
                $exclude_args = $this->execute_action($exclude_args, $term_id, $action);
                $filter_args[] = $exclude_args;
            }

            if (is_numeric($primary_index)) {
                $tax_query[$primary_index] = $filter_args;
            } else {
                $tax_query[] = $filter_args;
            }

            $this->query->set('tax_query', $tax_query);
            $this->query->tax_query = $tax_query;
            // error_log('$tax_query : ' . print_r($tax_query, true));
            return $term_id;
        }

        protected function execute_action($exclude_args, $term_id, $action)
        {
            if ($action == 'add') {
                array_push($exclude_args['terms'], $term_id);
            } else {
                if (($key = array_search($term_id, $exclude_args['terms'])) !== false) {
                    unset($exclude_args['terms'][$key]);
                }
            }

            return $exclude_args;
        }
    } // END CLASS
}