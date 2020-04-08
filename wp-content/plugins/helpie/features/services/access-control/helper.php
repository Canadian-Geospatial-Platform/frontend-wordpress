<?php

namespace Helpie\Features\Services\Access_Control;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Services\Access_Control\Helper')) {
    class Helper
    {

        public function page_has_helpie($content)
        {
            $page_has_helpie = false;
            $shortcodes = new \Helpie\Includes\Shortcodes();
            $shortcodes_list = $shortcodes->shortcode_list;

            $has_helpie_shortcodes = false;

            foreach ($shortcodes_list as $shortcode) {
                if (has_shortcode($content, $shortcode)) {
                    $has_helpie_shortcodes = true;
                    break;
                }
            }

            $post_type = get_post_type();

            if ($post_type == 'pauple_helpie' || $has_helpie_shortcodes) {
                $page_has_helpie = true;
            }

            return $page_has_helpie;
        }

        // is current page, the single post of 'pauple_helpie' post type
        public function is_single_article()
        {
            return (is_singular('pauple_helpie') && is_single(get_the_ID()));
        }

        public function get_all_terms_without_filter($no_filter_args)
        {
            // error_log('$no_filter_args : ' . print_r($no_filter_args, true));
            $is_parent_param_set = isset($no_filter_args['parent']);
            if ($is_parent_param_set && !empty($no_filter_args)) {

                // $hide_empty = $no_filter_args['hide_empty'] ? $no_filter_args['hide_empty'] : 1;
                $args = array(
                    "taxonomy" => 'helpdesk_category',
                    "hide_empty" => false,
                    "parent" => $no_filter_args['parent'],
                );
                remove_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Remove action for this specific get_term_children()
                $terms = get_terms($args);
                add_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Add action to reset original filter

                return $terms;
            } else {
                return get_all_helpie_kb_topics($no_filter_args);
            }
        }

        public function get_terms_without_filter($post_id)
        {
            $query_service = \Helpie\Features\Services\Query::getInstance();
            $posts_by_topic = $query_service->get_all_posts_by_topic();

            $terms = [];

            foreach ($posts_by_topic as $term_id => $posts) {
                // error_log('term_id: ' . $term_id);
                foreach ($posts as $key => $post) {

                    // error_log('$post->ID : ' . $post->ID);
                    // error_log('$post_id : ' . $post_id);
                    if ($post->ID == $post_id) {
                        array_push($terms, $term_id);
                        break;
                    }
                }
            }

            // error_log('$terms : ' . print_r($terms, true));
            return $terms;
        }

        public function get_terms_without_filter_old($post_id)
        {
            $taxonomy = 'helpdesk_category';

            remove_action('pre_get_terms', 'helpie_kb_pre_get_terms'); // Remove action for this specific get_term_children()
            // $terms = get_the_terms($post_id,  $taxonomy);
            // wp_get_post_terms is better because get_the_terms uses cache and hence filtered items are not got
            $terms = wp_get_post_terms($post_id, $taxonomy);
            add_action('pre_get_terms', 'helpie_kb_pre_get_terms'); // Add action to reset original filter

            return $terms;
        }

        public function is_top_level_article($child_terms_id_array, $taxonomy, $article)
        {
            if (has_term($child_terms_id_array, $taxonomy, $article) == null || has_term($child_terms_id_array, $taxonomy, $article) == '') {
                return true;
            }

            if (has_term($child_terms_id_array, $taxonomy, $article) == false || empty($child_terms_id_array)) {
                return true;
            }

            return false;
        }

        public function has_included_descendants($term_id, $content)
        {
            $has_included_descendants = false;

            // $term_lineage is the ancestry of term including self in lowest to highest in hierrachy.
            // That is, first item is term itself and last item is the top most parent term
            $term_lineage = $this->get_term_children($term_id);
            array_unshift($term_lineage, $term_id);

            $included_terms = (array) $content['included']['topics'];

            foreach ($term_lineage as $single_term_id) {
                $is_included = (in_array($single_term_id, $included_terms));

                if ($is_included) {
                    $has_included_descendants = true;
                    break;
                }
            }

            return $has_included_descendants;
        }

        public function get_term_children($term_id)
        {
            remove_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 2); // Remove action for this specific get_term_children()
            $terms = get_term_children($term_id, 'helpdesk_category');
            add_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 2); // Add action to reset original filter

            return $terms;
        }

        public function is_global_excluded($content)
        {
            // error_log('$content : ' . print_r($content, true));
            return !$content['global'];
        }

        public function is_term_not_included($term_id, $content)
        {
            $is_term_not_included = true;

            // $term_lineage is the ancestry of term including self in lowest to highest in hierrachy.
            // That is, first item is term itself and last item is the top most parent term
            $term_lineage = get_ancestors($term_id, 'helpdesk_category');
            array_unshift($term_lineage, $term_id);

            $excluded_terms = (array) $content['excluded']['topics'];
            $included_terms = (array) $content['included']['topics'];

            foreach ($term_lineage as $single_term_id) {

                $is_included = (in_array($single_term_id, $included_terms));
                $is_excluded = (in_array($single_term_id, $excluded_terms));
                if ($is_included) {
                    $is_term_not_included = false;
                    break;
                }
            }

            return $is_term_not_included;
        }

        public function is_term_excluded($term_id, $content)
        {
            $is_term_excluded = false;

            // $term_lineage is the ancestry of term including self in lowest to highest in hierrachy.
            // That is, first item is term itself and last item is the top most parent term
            $term_lineage = get_ancestors($term_id, 'helpdesk_category');
            array_unshift($term_lineage, $term_id);

            $excluded_terms = (array) $content['excluded']['topics'];
            $included_terms = (array) $content['included']['topics'];

            foreach ($term_lineage as $single_term_id) {

                $is_included = (in_array($single_term_id, $included_terms));
                $is_excluded = (in_array($single_term_id, $excluded_terms));
                if ($is_included) {
                    $is_term_excluded = false;
                    break;
                }

                if ($is_excluded) {
                    $is_term_excluded = true;
                    break;
                }
            }

            return $is_term_excluded;
        }

        public function is_term_included($term_id, $content)
        {
            $is_term_included = false;

            // $term_lineage is the ancestry of term including self in lowest to highest in hierrachy.
            // That is, first item is term itself and last item is the top most parent term
            $term_lineage = get_ancestors($term_id, 'helpdesk_category');
            array_unshift($term_lineage, $term_id);

            $excluded_terms = (array) $content['excluded']['topics'];
            $included_terms = (array) $content['included']['topics'];

            foreach ($term_lineage as $single_term_id) {

                $is_included = (in_array($single_term_id, $included_terms));
                $is_excluded = (in_array($single_term_id, $excluded_terms));
                if ($is_included) {
                    $is_term_included = true;
                    break;
                }

                if ($is_excluded) {
                    $is_term_included = false;
                    break;
                }
            }

            return $is_term_included;
        }
    } // END CLASS
}
