<?php

namespace Helpie\Includes\Utils\Test;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


if (!class_exists('\Helpie\Includes\Utils\Test\Content_Setup')) {
    class Content_Setup
    {
        public function __construct()
        {
            $this->test_data = new \Helpie\Includes\Utils\Test\Test_Data();
        }

        public function setup_data()
        {
            $setup_data = $this->test_data->get();
            $articles_props = $setup_data['articles'];
            $terms_props = $setup_data['terms'];

            return $this->insert_content($articles_props, $terms_props);
        }


        public function insert_content($articles_props, $terms_props)
        {
            for ($ii = 0; $ii < sizeof($terms_props); $ii ++) {
                $terms_props[$ii] = $this->insert_new_term($terms_props[$ii]);
            }

            for ($ii = 0; $ii < sizeof($articles_props); $ii ++) {
                $articles_props[$ii] = $this->insert_new_post($articles_props[$ii]);
            }

            return array(
                'terms' => $terms_props,
                'articles' => $articles_props
            );
        }


        /*
            $term_args = array(
                'name' => 'Child Term Name',
                'taxonomy' => 'helpdesk_category',
                'parent_id' => 2 ( parent term id )
            );
        */

        public function insert_new_term($args)
        {
            if (isset($args['parent_name'])) {
                $term = get_term_by('name', $args['parent_name'], $args['taxonomy']);
                $args['parent_id'] = $term->term_id;
            }


            if (!isset($args['parent_id'])) {
                $args['parent_id'] = 0;
            }
            if (!term_exists($args['name'], $args['taxonomy'], $args['parent_id'])) {
                // echo "parent_term_id: " . $parent_term_id;
                $term_info = wp_insert_term($args['name'], $args['taxonomy'], array('parent' => $args['parent_id']));
                $term_id = $term_info['term_id'];
            } else {
                $term = get_term_by('slug', $term_value, $taxonomy);
                $term_id = $term->term_id;
            }
            $args['term_id'] = $term_id;
            $args['link'] = get_term_link($term_id);

            return $args;
        }
        /*
        $args = array(
            'post_title' => 'Post Title',
            'terms' => array(
                'helpdesk_category' => array( 'category1' ),
                'helpie_tag' => array('tag1', 'tag2'),
            ),
            'post_content' => 'Post Content'
        );
        */


        public function insert_new_post($args)
        {
            $post_id = wp_insert_post(
                array(
                    'post_title' => $args['post_title'],
                    'post_type' => 'pauple_helpie',
                    'post_content' => $args['post_content'],
                    'post_status' => 'publish'
                )
            );
            $args['post_id'] = $post_id;
            $args['permalink'] = get_post_permalink($post_id);



            if (isset($args['terms']) && !empty($args['terms'])) {
                $args['terms_ids'] = array();
                foreach ($args['terms'] as $taxonomy => $terms_array) {
                    // $cat_ids = array_map('intval', (array) $terms_array);
                    $term_slugs = array_unique($terms_array);
                    wp_set_object_terms($post_id, $term_slugs, $taxonomy);
                    $term_list = wp_get_post_terms($post_id, $taxonomy, array("fields" => "ids"));
                    $args['terms_ids'][$taxonomy] = $term_list;
                }
            }


            return $args;
        }
    } // END CLASS
}
