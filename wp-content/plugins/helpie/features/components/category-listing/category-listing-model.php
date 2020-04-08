<?php

namespace Helpie\Features\Components\Category_Listing;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Category_Listing\Category_Listing_Model')) {
    class Category_Listing_Model extends \Helpie\Includes\Core\Model
    {
        private $taxonomy = 'helpdesk_category';

        public function __construct()
        {
            parent::__construct();

            // Models
            $this->category_repo = new \Helpie\Features\Domain\Repositories\Category_Repository();
            $this->articles_model = new \Helpie\Features\Domain\Query\Articles_Model();
            $this->fields_model = new \Helpie\Features\Components\Category_Listing\Fields_Model();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->style_config = new \Helpie\Features\Components\Category_Listing\Style_Config_Model();
        }

        // Get the entire Props need to render a View
        // Input args can come from 1. Settings 2. Shortcode 3. Widget 4. Elementor Widget
        public function get_viewProps($args)
        {
            $args = $this->append_fallbacks($args);

            $args = $this->process($args);

            $taxonomy = $this->taxonomy;

            // error_log('args: ' . print_r($args, true));
            $categories = $this->category_repo->get_categories($args);

            // Setting viewProps
            $viewProps = array();
            $viewProps['collection'] = $this->get_collection_props($args);
            $viewProps['items'] = $this->get_categories_list_prop($categories, $viewProps['collection']);

            // echo "<pre>";
            // print_r($viewProps['collection']);
            // echo "</pre>";
            return $viewProps;
        }

        public function process($args)
        {
            $args['num_of_cols'] = $this->helper->numeric_processing($args['num_of_cols']);

            return $args;
        }

        public function get_style_config()
        {
            return $this->style_config->get_config();
        }

        public function get_fields()
        {
            return $this->fields_model->get_fields();
        }

        public function get_default_args()
        {
            $args = $this->fields_model->get_default_args();
            // Second Layer: Helpie Settings Values
            $view_settings = $this->get_settings();

            $args = array_merge($args, $view_settings);

            return $args;
        }

        public function get_settings()
        {
            $listing_type = $this->settings->main_page->get_listing_type();
            $num_of_cols = $this->settings->main_page->get_mp_category_cols();
            $num_of_articles = $this->settings->main_page->get_no_of_category_articles();
            $is_boxed_description_on = $this->settings->main_page->is_boxed_description_on();
            $children_type = $this->settings->main_page->get_helpie_mp_category_listing_children_type();
            $graphic_type = $this->settings->main_page->get_category_listing_graphic_type();

            $args = array(
                'type' => $listing_type,
                'num_of_cols' => $num_of_cols,
                'num_of_articles' => $num_of_articles,
                'show_description' => $is_boxed_description_on,
                'children_type' => $children_type,
                'graphic_type' => $graphic_type,
            );

            return $args;
        }

        protected function append_fallbacks($args)
        {
            $defaults = $this->get_default_args($args);

            foreach ($defaults as $key => $value) {
                if (!isset($args[$key]) || empty($args[$key])) {
                    $args[$key] = $value;
                }
            }

            return $args;
        }

        /* PROTECTED METHODS */

        protected function get_collection_props($args)
        {
            $collectionProps = array(
                'show_image' => $args['show_image'],
            );

            $collectionProps = array_merge($collectionProps, $args);

            return $collectionProps;
        }

        protected function get_categories_list_prop($categories, $collectionProps)
        {
            $taxonomy = $this->taxonomy;


            $listing_type = $collectionProps['type'];

            $children_type = $collectionProps['children_type'];
            $input_num_of_articles = $collectionProps['num_of_articles'];
            $categoriesListProps = array();
            $count = 0;
            foreach ($categories as $term) {
                $kb_category = new \Helpie\Features\Domain\Models\Kb_Category($term);

                $image_id = get_term_meta($term->term_id, 'category-image-id', true);

                $articles_object = [];

                if ($listing_type != 'boxed' && $children_type == 'articles') {
                    $articles_object = $this->articles_model->get_model_of_articles_of_term($term);
                }

                $sub_categories_object = $this->get_subcategories_of_category($term);
                if ($children_type == 'sub-categories') {
                    $num_of_articles = $this->get_number_of_article_to_show($sub_categories_object, $input_num_of_articles);
                } else {

                    $num_of_articles = $this->get_number_of_article_to_show($articles_object, $input_num_of_articles);
                }



                $image = $this->get_image($image_id, $term);


                if ($children_type == 'sub-categories') {
                    $children_count = $kb_category->get_child_category_count();
                } else {
                    $children_count = $kb_category->get_count();
                }

                $categoriesListProps[$count] = array(
                    'title' => $term->name,
                    'term_id' => $term->term_id,
                    'taxonomy' => $taxonomy,
                    'link' => get_term_link($term, $taxonomy),
                    'image' => $image,
                    'image_url' => wp_get_attachment_thumb_url($image_id),
                    'show_description' => $this->settings->main_page->is_boxed_description_on(),
                    'description' => $kb_category->get_category_description(),
                    'num_of_articles' => $num_of_articles,
                    'count' => $children_count,
                    'icon' => $kb_category->get_icon(),
                    'icon_code' => $kb_category->get_icon_code(),
                );

                $categoriesListProps[$count] = apply_filters("helpiekb/category_listing_single_item_filter", "category", $term->term_id, $categoriesListProps[$count], "category_listing");

                if ($children_type == 'articles') {
                    $categoriesListProps[$count]['children'] = $this->get_article_props_of_term($articles_object, $categoriesListProps[$count]);
                } else {
                    $categoriesListProps[$count]['children'] = $this->get_child_terms_props($categoriesListProps[$count]);
                }
                                
                $count++;
            }

            return $categoriesListProps;
        }

        private function get_image($image_id, $term)
        {
            if (isset($image_id) && !empty($image_id)) {
                $url = $this->get_image_url($image_id);
            }

            // Default image
            if (!isset($url) || $url == '') {
                $url = plugins_url('includes/asset-files/images/article-cover-dummy.jpg', HELPIE_PLUGIN_FILE_PATH);
            }

            $image = "<img src='" . $url . "'/>";

            return $image;
        }


        private function get_image_url($attachment_id)
        {
            $image_attributes = wp_get_attachment_image_src($attachment_id);

            return $image_attributes[0];
        }


        // Only used to get object size of subcategories of category
        protected function get_subcategories_of_category($term)
        {
            $taxonomy = $this->taxonomy;
            $child_term_ids = get_term_children($term->term_id, $taxonomy);
            $sub_categories_object = array();
            foreach ($child_term_ids as $child_term_id) {
                $child_term = get_term_by('id', $child_term_id, $taxonomy);

                $kb_category = new \Helpie\Features\Domain\Models\Kb_Category($child_term);
                array_push($sub_categories_object, $kb_category);
            }

            return $sub_categories_object;
        }
        protected function get_child_terms_props($categoryProps)
        {
            $childTermsProps = array();
            $taxonomy = $categoryProps['taxonomy'];
            $child_term_ids = get_term_children($categoryProps['term_id'], $taxonomy);
            $count = 0;

            foreach ($child_term_ids as $child_term_id) {
                $child_term = get_term_by('id', $child_term_id, $taxonomy);

                $kb_category = new \Helpie\Features\Domain\Models\Kb_Category($child_term);
                
                $child_icon = $kb_category->get_icon();
                $child_icon_code = $kb_category->get_icon_code();

                $childTermsProps[$count] = array(
                    'id' => $child_term_id,
                    'title' => $child_term->name,
                    'icon' => $child_icon,
                    'icon_code' => $child_icon_code,
                    'link' => get_term_link($child_term, $taxonomy),
                    'taxonomy' => $taxonomy,
                    'term_id' => $categoryProps['term_id'], // parent term_id
                );

                $childTermsProps[$count] = apply_filters("helpiekb/category_listing_single_item_filter", "category", $child_term_id, $childTermsProps[$count], "category_listing");

                $count++;
            }

            return $childTermsProps;
        }

        protected function get_number_of_article_to_show($articles_object, $input_num_of_articles)
        {
            $num_of_articles = 0;
            $articles_present = (isset($articles_object) && !empty($articles_object));

            if ($articles_present == false) {
                return;
            }

            $is_num_of_articles_input_set = (isset($input_num_of_articles) || !empty($input_num_of_articles));
            $num_of_articles = sizeof($articles_object);

            if ($is_num_of_articles_input_set) {
                $num_of_articles = $this->get_lower_number($num_of_articles, $input_num_of_articles);
            }

            return $num_of_articles;
        }

        protected function get_lower_number($number1, $number2)
        {
            return ($number1 < $number2) ? $number1 : $number2;
        }

        protected function get_article_props_of_term($articles_object, $categoryProps)
        {
            $articleProps = array();

            $num_of_articles = $categoryProps['num_of_articles'];

            for ($ii = 0; $ii < $num_of_articles; ++$ii) {
                if (isset($articles_object[$ii]) && !empty($articles_object[$ii])) {
                    $article_model = $articles_object[$ii];
                    $articleProps[$ii] = array(
                        'id' => $article_model['ID'],
                        'title' => $article_model['title'],
                        'link' => $article_model['permalink'],                        
                        'permitted_added_tag' => $article_model['permitted_added_tag'],
                        'permitted_updated_tag' => $article_model['permitted_updated_tag'],
                        'term_id' => $categoryProps['term_id'],
                    );

                    $articleProps[$ii] = apply_filters("helpiekb/category_listing_single_item_filter", "article", $article_model['ID'], $articleProps[$ii], "category_listing");
                }
            }

            return $articleProps;
        }
    } // END CLASS
}