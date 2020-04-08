<?php

/**
 * Implements WPDB Queries directly
 *
 * @package    helpie-kb
 * @subpackage services
 * @author     essekia
 * @version    1.9.1
 * ...
 */

namespace Helpie\Features\Services;


/* TODO: Not used */

if (!class_exists('\Helpie\Features\Services\Query')) {
    class Query
    {

        // Hold the class instance.
        private static $instance = null;

        private  $posts_by_topic = [];

        private $has_included_posts = [];

        // The object is created from within the class itself
        // only if the class has no instance.
        public static function getInstance()
        {
            if (self::$instance == null) {
                self::$instance = new \Helpie\Features\Services\Query();
            }

            return self::$instance;
        }


        public function has_included_posts($term_id, $included_posts)
        {
            $has_included_posts = false;
            $query_service = \Helpie\Features\Services\Query::getInstance();
            $posts = $query_service->get_posts_by_topic($term_id);

            if (!isset($posts) || !is_array($posts)) {
                return $has_included_posts;
            }

            foreach ($posts as $post) {
                if (in_array($post->ID, $included_posts)) {
                    $has_included_posts = true;
                    break;
                }
            }


            return $has_included_posts;
        }


        public function set_posts_by_topic()
        {
            $posts = $this->get_posts_with_topic();
            // error_log('$posts : ' . print_r($posts, true));

            foreach ($posts as $post) {
                $term_id = $post->term_taxonomy_id;

                // error_log(' $term_id : ' .  $term_id);
                if (!isset($this->posts_by_topic[$term_id])) {
                    $this->posts_by_topic[$term_id] = [];
                }
                // array_push($this->posts_by_topic[$term_id], $post);
                $this->posts_by_topic[$term_id][$post->ID] = $post;
            }

            // error_log('$this->posts_by_topic : ' . print_r($this->posts_by_topic, true));
        }

        public function get_all_posts_by_topic()
        {
            return $this->posts_by_topic;
        }


        public function get_posts_by_topic($term_id)
        {
            // error_log('get_posts_by_topic');
            $this->set_posts_by_topic();

            if (isset($this->posts_by_topic[$term_id])) {
                return $this->posts_by_topic[$term_id];
            }

            return null; // easier to detect bugs when null is returned instead of empty array
        }


        public function get_posts_with_topic()
        {

            global $wpdb;

            $query =
                "
                SELECT $wpdb->posts.ID, $wpdb->term_taxonomy.term_taxonomy_id FROM $wpdb->posts
                LEFT JOIN $wpdb->term_relationships ON
                ($wpdb->posts.ID = $wpdb->term_relationships.object_id)
                LEFT JOIN $wpdb->term_taxonomy ON
                ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)
                WHERE $wpdb->posts.post_status = 'publish'
                AND $wpdb->term_taxonomy.taxonomy = 'helpdesk_category'
                ORDER BY post_date DESC
            ";

            $result = $wpdb->get_results($query);
            // error_log(' $result: ' . print_r($result, true));

            return $result;
        }



        public static function get_posts($args = [], $no_meta_tax = false)
        {
            $results    = [];

            $args_perf = [
                'no_found_rows'          => true,
                'posts_per_page' => -1,
            ];

            if ($no_meta_tax) {
                $args_perf['update_post_meta_cache'] = false;
                $args_perf['update_post_term_cache'] = false;
            }

            $args = array_merge($args, $args_perf);
            remove_action('pre_get_posts', 'helpie_kb_filter_posts');
            remove_action('pre_get_terms', 'helpie_kb_pre_get_terms'); // Remove action for this specific get_term_children()
            $query = new \WP_Query($args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    // Optionally, pick parts of the post and create a custom collection.
                    $query->the_post();
                    // $results[] = get_post();
                }
                wp_reset_postdata();



                return $results;
            }
            add_action('pre_get_posts', 'helpie_kb_filter_posts');
            add_action('pre_get_terms', 'helpie_kb_pre_get_terms'); // Add action to reset original filter

            return $results;
        }
    } // END CLASS
}