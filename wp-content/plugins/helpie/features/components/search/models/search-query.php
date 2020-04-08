<?php

namespace Helpie\Features\Components\Search\Models;

if (!class_exists('\Helpie\Features\Components\Search\Models\Search_Query')) {
    class Search_Query
    {
        protected function get_visible_search_args($input_query, $mainpage_categories_array)
        {

            // search articles from visible articles
            $args = array(
                's' => $input_query,
                'numberposts' => -1,
                // 'tax_query' => array(
                //     array(
                //         'taxonomy' => 'helpdesk_category',
                //         'field' => 'id',
                //         'terms' => $mainpage_categories_array,
                //     ),
                // ),
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post_type' => 'pauple_helpie',
                'post_status' => 'publish, awaiting',
            );

            return $args;
        }
        protected function get_categories_like($input_query)
        {
            global $wpdb; // this is how you get access to the database

            $args = array(
                'post_type' => 'pauple_helpie',
                'post_status' => 'publish, awaiting',
            );

            $tax_query = array();

            // $tax_query['relation'] = 'AND';

            $tax_query[] = array(
                'taxonomy' => 'helpdesk_category',
                'field' => 'name',
                'terms' => $input_query,
            );

            $args['tax_query'] = $tax_query;

            // error_log('get_categories_like');
            $resultOfQuery = $this->get_query($args);

            return $resultOfQuery;
        }
        protected function get_tags_like($input_query)
        {
            global $wpdb; // this is how you get access to the database

            $args = array(
                'post_type' => 'pauple_helpie',
                'post_status' => 'publish, awaiting',
            );

            $tax_query = array();

            // $tax_query['relation'] = 'AND';

            $tax_query[] = array(
                'taxonomy' => 'helpie_tag',
                'field' => 'name',
                'terms' => $input_query,
            );

            $args['tax_query'] = $tax_query;

            // error_log('get_tags_like');
            // error_log('$args : ' . print_r($args, true));

            $resultOfQuery = $this->get_query($args);

            return $resultOfQuery;
        }

        protected function get_query($args)
        {
            // error_log('get_query');
            // // global $post;
            // error_log('$args : ' . print_r($args, true));
            $myposts = get_helpie_kb_articles($args);

            $resultOfQuery = array();
            $numOfPosts = 0;

            foreach ($myposts as $post): setup_postdata($post);

                $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($post);

                $kb_content = $kb_article->get_the_content();
                $kb_content = strip_shortcodes($kb_content);
                $kb_content = preg_replace('/\[.*\]/', '', $kb_content); // Because strip_shortcodes() doesn't work
                $kb_content = sanitize_text_field($kb_content);
                $kb_content = html_entity_decode(wp_strip_all_tags($kb_content));

                $resultOfQuery[$kb_article->get_the_ID()] = array(
                    'id' => $kb_article->get_the_ID(),
                    'title' => $kb_article->get_title(),
                    'link' => $kb_article->get_permalink(),
                    'image' => $kb_article->get_image_as_fallback_manner(),
                    'date' => $kb_article->get_date(),
                    'page_views' => get_post_meta($kb_article->get_the_ID(), 'ph_pageviews', true),
                    'content' => $kb_content,
                    'category' => $kb_article->get_category_name(),
                    'tags' => $kb_article->get_tags_list(),
                    'category_id' => $kb_article->get_category_id(),
                );

                $resultOfQuery[$kb_article->get_the_ID()] = apply_filters("helpiekb/search_single_item_filter", "article", $kb_article->get_the_id(), $resultOfQuery[$kb_article->get_the_ID()]);

                ++$numOfPosts;

            endforeach;
            wp_reset_postdata();

            return $resultOfQuery;
        }
    }
}
