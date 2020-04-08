<?php

namespace Helpie\Features\Components\Toc\Model;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


if (!class_exists('\Helpie\Features\Components\Toc\Model\Fields_Model')) {
    class Fields_Model
    {
        public function __construct(){
            $this->category_repo = new \Helpie\Features\Domain\Repositories\Category_Repository();
        }
        
        public function get_fields()
        {
            $fields = array(
                'title' => $this->get_title_field(),
                'toc_type' => $this->get_toc_type_field(),
                'show_auto_toc' => $this->get_show_auto_toc_field(),
                'show_toc_articles' => $this->get_show_toc_articles_field(),
                'toggle_category_children' => $this->get_toggle_category_children_field(),
                'article_limit' => $this->get_article_limit_field(),
                'topics' => $this->get_topics_field(),
            );

            return $fields;
        }

        // FIELDS

        protected function get_article_limit_field()
        {
            return array(
                'name' => 'article_limit',
                'label' => __('Article Limit', 'pauple-helpie'),
                'default' => __(5, 'pauple-helpie'),
                'type' => 'number'
            );
        }

        protected function get_upto_child_category_limit_field()
        {
            return array(
                'name' => 'child_category_limit',
                'label' => __('Child Category Limit', 'pauple-helpie'),
                'default' => __(5, 'pauple-helpie'),
                'type' => 'number'
            );
        }


        protected function get_toggle_category_children_field()
        {
            return array(
                'name' => 'toggle_category_children',
                'label' => __('Toggle Category Children', 'pauple-helpie'),
                'default' => __('true', 'pauple-helpie'),
                'options' => array(
                    'true' => __('True', 'pauple-helpie'),
                    'false' => __('False', 'pauple-helpie')
                ),
                'type' => 'select'
            );
        }

        protected function get_show_auto_toc_field()
        {
            return array(
                'name' => 'show_auto_toc',
                'label' => __('Show Auto TOC', 'pauple-helpie'),
                'default' => __('true', 'pauple-helpie'),
                'options' => array(
                    'true' => __('True', 'pauple-helpie'),
                    'false' => __('False', 'pauple-helpie')
                ),
                'type' => 'select'
            );
        }

        protected function get_show_toc_articles_field()
        {
            return array(
                'name' => 'show_toc_articles',
                'label' => __('Show Articles in TOC', 'pauple-helpie'),
                'default' => __('true', 'pauple-helpie'),
                'options' => array(
                    'true' => __('True', 'pauple-helpie'),
                    'false' => __('False', 'pauple-helpie')
                ),
                'type' => 'select'
            );
        }

        protected function get_title_field()
        {
            return array(
                'name' => 'title',
                'label' => __('Title', 'pauple-helpie'),
                'default' => __('Table of Contents', 'pauple-helpie'),
                'type' => 'text'
            );
        }

        protected function get_toc_type_field()
        {
            return array(
                'name' => 'toc_type', // This is different in settings
                'label' => __('Type', 'pauple-helpie'),
                'default' => __('full-nav', 'pauple-helpie'),
                'options' => array(
                    'full-nav' => __('Full KB TOC', 'pauple-helpie'),
                    'page-scroll-only' => __('In Page TOC only', 'pauple-helpie')
                ),
                'type' => 'select'
            );
        }

        protected function get_topics_field()
        {
            $categories_options = $this->category_repo->get_category_options(true);  // $show_all = true


            return array(
                'name' => 'topics',
                'label' => __('Topics', 'pauple-helpie'),
                'default' => __('all', 'pauple-helpie'),
                'options' => $categories_options,
                'type' => 'multi-select'
            );
        }
    } // END CLASS
}
