<?php

namespace Helpie\Features\Components\Category_Listing;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly



if (!class_exists('\Helpie\Features\Components\Category_Listing\Fields_Model')) {
    class Fields_Model
    {
        public function __construct()
        {
            $this->category_repo = new \Helpie\Features\Domain\Repositories\Category_Repository();
        }

        public function get_fields()
        {
            $fields = array(
                'title' => $this->get_title_field(),
                'show_widget_title' => $this->get_show_widget_title(),
                'sortby' => $this->get_sortby_field(),
                'topics' => $this->get_topics_field(),
                'num_of_cols' => $this->get_num_of_cols_field(),
                'type' => $this->get_type_field(),
                'children_type' => $this->get_children_type_field(),
                'num_of_articles' => $this->get_num_of_articles_field(),
                'show_image' => $this->get_show_image_field(),
                'show_description' => $this->get_show_description_field(),
            );

            return $fields;
        }

        public function get_default_args()
        {
            $args = array();

            // Get Default Values from GET - FIELDS
            $fields = $this->get_fields();
            foreach ($fields as $key => $field) {
                $args[$key] = $field['default'];
            }

            return $args;
        }

        // FIELDS
        protected function get_title_field()
        {
            return array(
                'name' => 'title',
                'label' => __('Title', 'pauple-helpie'),
                'default' => __('KB Category Listing', 'pauple-helpie'),
                'type' => 'text'
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

        protected function get_show_widget_title()
        {
            return array(
                'name' => 'show_widget_title',
                'label' => __('Show Widget Title', 'pauple-helpie'),
                'default' => __('false', 'pauple-helpie'),
                'options' => array(
                    'true' => __('True', 'pauple-helpie'),
                    'false' => __('False', 'pauple-helpie')
                ),
                'type' => 'select'
            );
        }

        protected function get_sortby_field()
        {
            return array(
                'name' => 'sortby',
                'label' => __('Sort By', 'pauple-helpie'),
                'default' => __('custom', 'pauple-helpie'),
                'options' => array(
                    'alphabetical' => __('Alphabetical', 'pauple-helpie'),
                    'count' => __('Article Count', 'pauple-helpie'),
                    'custom' => __('Custom', 'pauple-helpie'),
                ),
                'type' => 'select'
            );
        }

        protected function get_num_of_cols_field()
        {
            return array(
                'name' => 'num_of_cols',
                'label' => __('Num Of Columns', 'pauple-helpie'),
                'default' => __('three', 'pauple-helpie'),
                'options' => array(
                    'one' => __(1, 'pauple-helpie'),
                    'two' => __(2, 'pauple-helpie'),
                    'three' => __(3, 'pauple-helpie'),
                    'four' => __(4, 'pauple-helpie'),
                ),
                'type' => 'select'
            );
        }


        protected function get_type_field()
        {
            return array(
                'name' => 'type',
                'label' => __('Type', 'pauple-helpie'),
                'default' => __('boxed', 'pauple-helpie'),
                'options' => array(
                    'boxed'  => __('Boxed', 'pauple-helpie'),
                    'boxed1' => __('Boxed1', 'pauple-helpie'),
                    'modern' => __('Modern', 'pauple-helpie'),
                    'list'  => __('List', 'pauple-helpie')
                ),
                'type' => 'select'
            );
        }

        protected function get_children_type_field()
        {
            return array(
                'name' => 'children_type',
                'label' => __('Children Type', 'pauple-helpie'),
                'default' => __('articles', 'pauple-helpie'),
                'options' => array(
                    'none'  => __('Dont show Children', 'pauple-helpie'),
                    'articles' => __('Articles', 'pauple-helpie'),
                    'sub-categories' => __('Sub Categories', 'pauple-helpie')
                ),
                'type' => 'select'
            );
        }

        protected function get_num_of_articles_field()
        {
            return array(
                'name' => 'num_of_articles',
                'label' => __('Num of Articles', 'pauple-helpie'),
                'default' => __(5, 'pauple-helpie'),
                'type' => 'number'
            );
        }

        protected function get_show_description_field()
        {
            return array(
                'name' => 'show_description',
                'label' => __('Show Description', 'pauple-helpie'),
                'default' => __('true', 'pauple-helpie'),
                'options' => array(
                    'true' => __('True', 'pauple-helpie'),
                    'false' => __('False', 'pauple-helpie')
                ),
                'type' => 'select'
            );
        }

        protected function get_show_image_field()
        {
            return array(
                'name' => 'show_image',
                'label' => __('Show Image', 'pauple-helpie'),
                'default' => __('true', 'pauple-helpie'),
                'options' => array(
                    'true' => __('True', 'pauple-helpie'),
                    'false' => __('False', 'pauple-helpie')
                ),
                'type' => 'select'
            );
        }
    }
}
