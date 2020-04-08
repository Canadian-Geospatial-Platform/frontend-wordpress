<?php

namespace Helpie\Includes\Utils\Test;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


if (!class_exists('\Helpie\Includes\Utils\Test\Test_Data')) {
    class Test_Data
    {
        public function get()
        {
            $categories_args = $this->get_category_terms();
            $child_categories_args = $this->get_category_child_terms();
            $tags_args =  $this->get_tag_terms();

            $terms_args = array_merge($categories_args, $child_categories_args, $tags_args);
            $articles_args = $this->get_articles_args();

            $content_args = array(
                'articles' => $articles_args,
                'terms' => $terms_args
            );

            return $content_args;
        }


        public function get_articles_args()
        {
            $articles_args = array(
                0 => array(
                    'post_title' => 'Post Title1',
                    'post_content' => 'Post Content1',
                    'terms' => array(
                        'helpdesk_category' => array( 'category1' ),
                        'helpie_tag' => array( 'tag1', 'tag2' )
                    ),
                ),
                1 => array(
                    'post_title' => 'Post Title2',
                    'post_content' => 'Post Content2',
                    'terms' => array(
                        'helpdesk_category' => array( 'category2' ),
                        'helpie_tag' => array( 'tag2')
                    ),
                ),
                2 => array(
                    'post_title' => 'Post Title3',
                    'post_content' => 'Post Content3',
                    'terms' => array(
                        'helpdesk_category' => array( 'category3' ),
                        'helpie_tag' => array( 'tag3')
                    ),
                ),
                3 => array(
                    'post_title' => 'Post Title4',
                    'post_content' => 'Post Content4',
                    'terms' => array(
                        'helpdesk_category' => array( 'category1-child' ),
                        'helpie_tag' => array( 'tag1', 'tag2' )
                    ),
                ),
                4 => array(
                    'post_title' => 'Post Title5',
                    'post_content' => 'Post Content5',
                    'terms' => array(
                        'helpdesk_category' => array( 'category2-child' ),
                        'helpie_tag' => array( 'tag2')
                    ),
                ),
                5 => array(
                    'post_title' => 'Post Title6',
                    'post_content' => 'Post Content6',
                    'terms' => array(
                        'helpdesk_category' => array( 'category3-child' ),
                        'helpie_tag' => array( 'tag3')
                    ),
                ),
            );

            return $articles_args;
        }


        public function get_category_terms()
        {
            $categories_args = array(
                0 => array(
                    'name' => 'Category1',
                    'taxonomy' => 'helpdesk_category'
                ),
                1 => array(
                    'name' => 'Category2',
                    'taxonomy' => 'helpdesk_category'
                ),
                2 => array(
                    'name' => 'Category3',
                    'taxonomy' => 'helpdesk_category'
                ),
                3 => array(
                    'name' => 'PasswordProtected',
                    'taxonomy' => 'helpdesk_category'
                )
            );

            return $categories_args;
        }


        public function get_category_child_terms()
        {
            $categories_args = array(
                0 => array(
                    'name' => 'Category1 child',
                    'taxonomy' => 'helpdesk_category',
                    'parent_name' => 'Category1'
                ),
                1 => array(
                    'name' => 'Category2 child',
                    'taxonomy' => 'helpdesk_category',
                    'parent_name' => 'Category2'
                ),
                2 => array(
                    'name' => 'Category3 child',
                    'taxonomy' => 'helpdesk_category',
                    'parent_name' => 'Category3'
                ),
                3 => array(
                    'name' => 'PasswordProtected child',
                    'taxonomy' => 'helpdesk_category',
                    'parent_name' => 'PasswordProtected'
                )
            );

            return $categories_args;
        }

        public function get_tag_terms()
        {
            $tags_args = array(
                0 => array(
                    'name' => 'tag1',
                    'taxonomy' => 'helpie_tag'
                ),
                1 => array(
                    'name' => 'tag2',
                    'taxonomy' => 'helpie_tag'
                ),
                2 => array(
                    'name' => 'tag3',
                    'taxonomy' => 'helpie_tag'
                ),
            );

            return $tags_args;
        }
    } // END CLASS
}
