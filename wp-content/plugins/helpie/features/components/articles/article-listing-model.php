<?php

namespace Helpie\Features\Components\Articles;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Articles\Article_Listing_Model')) {
    class Article_Listing_Model extends \Helpie\Includes\Core\Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->style_config = new \Helpie\Features\Components\Articles\Style_Config_Model();
            $this->fields_model = new \Helpie\Features\Components\Articles\Fields_Model();
        }

        public function get_viewProps($args)
        {
            $args = $this->append_fallbacks($args);

            $viewProps = array(
                'collection' => $this->get_collection_props($args),
                'items' => $this->get_items_props($args['articles']),
            );

            return $viewProps;
        }

        public function get_style_config()
        {
            return $this->style_config->get_config();
        }

        public function get_fields()
        {
            return $this->fields_model->get_fields();
        }

        public function get_settings()
        {
            return $this->settings->main_page->get_article_listing_settings();
        }

        public function get_default_args()
        {
            $args = $this->fields_model->get_default_args();
            // Second Layer: Helpie Settings Values
            $view_settings = $this->get_settings();

            $args = array_merge($args, $view_settings);

            return $args;
        }

        public function get_field($field_name)
        {
            $fields = $this->get_fields();
            return $fields[$field_name];
        }

        /* PROTECTED METHODS */

        protected function append_fallbacks($args)
        {

            // Get Default Values from GET - FIELDS
            $fields = $this->get_fields();
            foreach ($fields as $key => $field) {
                $args[$key] = !empty($args[$key]) ? $args[$key] : $field['default'];
            }

            // Style Settings used in the view
            $args['article_listing_title_icon'] = !empty($args['article_listing_title_icon']) ? $args['article_listing_title_icon'] : '';
            $args['article_listing_title_icon_position'] = !empty($args['article_listing_title_icon_position']) ? $args['article_listing_title_icon_position'] : 'before';

            // Convert '1' to 'one' and so on
            $args['num_of_cols'] = $this->helper->numeric_processing($args['num_of_cols']);

            $articles = get_helpie_kb_articles($args);
            $args['articles'] = $articles;

            return $args;
        }

        protected function get_items_props($articles)
        {
            $itemsProps = array();
            $count = 0;

            foreach ($articles as $article) {
                $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($article);
                $itemsProps[$count] = $this->map_domain_props_to_view_item_props($kb_article);
                $count++;
            }

            return $itemsProps;
        }

        protected function map_domain_props_to_view_item_props($kb_article)
        {
            $read_time = $kb_article->get_read_time();
            $post_id = $kb_article->get_the_ID();

            $itemProps = array(
                'post_id' => $post_id,
                'term_id' => $kb_article->get_top_most_category_id(),
                'title' => $kb_article->get_title(),
                'link' => $kb_article->get_permalink(),
                'image_url' => $kb_article->get_thumbnail_url(),
                'meta' => $kb_article->get_category_name(),
                'date' => $kb_article->get_date(),
                'user_name' => $kb_article->get_author_name(),
                'user_image_url' => $kb_article->get_author_avatar_url(),
            );

            $itemProps = apply_filters("helpiekb/article_listing_single_item_filter", "article", $post_id, $itemProps, "article_listing");

            return $itemProps;
        }

        protected function get_collection_props($args)
        {
            $collectionProps = array(
                'num_of_cols' => $args['num_of_cols'],
                'show_user_name' => $this->show_user_name(),
                'show_image' => $args['show_image'],
                'show_extra' => $args['show_extra'],
                'article_listing_title_icon' => $args['article_listing_title_icon'],
            );

            $collectionProps = array_merge($collectionProps, $args);

            return $collectionProps;
        }

        protected function show_user_name()
        {
            return $this->settings->single_page->show_user_name();
        }
    }
}