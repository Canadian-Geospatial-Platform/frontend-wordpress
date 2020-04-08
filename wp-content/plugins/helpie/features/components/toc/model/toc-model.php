<?php

namespace Helpie\Features\Components\Toc\Model;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Toc\Model\Toc_Model')) {
    class Toc_Model extends \Helpie\Includes\Core\Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->category_repo = new \Helpie\Features\Domain\Repositories\Category_Repository();
            $this->post_model = new \Helpie\Features\Components\Sidebar\Model\Post_Model();
            $this->style_config = new \Helpie\Features\Components\Toc\Model\Style_Config_Model();
            $this->auto_toc_model = new \Helpie\Features\Components\Toc\Model\Auto_Toc_model();
        }

        public function get_viewProps($args = array())
        {
            $collectionProps = $this->get_collectionProps($args);
            $itemsProps = $this->get_itemsProps($collectionProps);

            $viewProps = array(
                'collection' => $collectionProps,
                'items' => $itemsProps,
            );

            // error_log('$itemsProps : ' . print_r($itemsProps, true));

            return $viewProps;
        }

        public function get_collectionProps($args)
        {
            $default_args = $this->get_default_args();
            $this->view_settings = $this->settings->components->get_toc_settings();
            $collectionProps = array_merge($default_args, $this->view_settings, $args);
            return $collectionProps;
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

        public function get_fields()
        {
            $fields_model = new \Helpie\Features\Components\Toc\Model\Fields_Model();
            return $fields_model->get_fields();
        }
        /**
         * Used for elementor widget
         */
        public function get_style_config()
        {
            return $this->style_config->get_config();
        }

        public function get_itemsProps($collectionProps)
        {
            $args = $collectionProps;
            $wp_categories = $this->category_repo->get_categories($args);
            $categoriesProps =  $this->get_categoriesProps($wp_categories, $collectionProps);

            // error_log('$categoriesProps : ' . print_r($categoriesProps, true));
            return $categoriesProps;
        }

        public function get_categoriesProps($wp_categories, $collectionProps)
        {

            $container = array();

            foreach ($wp_categories as $cat_key => $wp_category) {
                // parent Category
                $kb_category = new \Helpie\Features\Domain\Models\Kb_Category($wp_category);
                $single_category_viewProps = $this->get_category_viewProps($kb_category, $collectionProps);
                array_push($container, $single_category_viewProps);

                // child categories
                if (isset($kb_category->child) && !empty($kb_category->child)) {
                    $wp_child_categories = $kb_category->get_child_categories_wpobjects();
                    $single_child_category_viewProps = $this->get_categoriesProps($wp_child_categories, $collectionProps);
                    $container = array_merge($container, $single_child_category_viewProps);
                }
            }

            return $container;
        }

        public function get_category_viewProps($kb_category, $collectionProps)
        {
            $article_limit = $collectionProps['article_limit'];
            $articles = $kb_category->get_top_level_articles($article_limit);

            $category = array(
                'id' => $kb_category->term_id,
                'title' => $kb_category->name,
                'parent' => $kb_category->parent,
                'child' => $kb_category->child,
                'link' => $kb_category->get_category_link(),
                'articles' => $this->get_articles($articles, $collectionProps),
            );

            $category = apply_filters("helpiekb/toc_single_item_filter", "category", $kb_category->term_id, $category);

            return $category;
        }

        protected function get_articles($articles, $collectionProps)
        {
            $articles_props = array();

            foreach ($articles as $article) {
                $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($article);
                $single_article_props = $this->set_single_article($kb_article, $collectionProps);
                array_push($articles_props, $single_article_props);
            }

            return $articles_props;
        }

        protected function set_single_article($kb_article, $collectionProps)
        {
            $post_id = $kb_article->get_the_ID();

            return array(
                'title' => $kb_article->get_title(),
                'isCurrentPost' => $this->is_current_post($post_id),
                'link' => $kb_article->get_permalink(),
                'id' => $post_id,
                'autoTOCProps' => $this->get_auto_toc_props($post_id, $collectionProps),
            );
        }

        protected function get_auto_toc_props($post_id, $collectionProps)
        {
            $isCurrentPost = $this->is_current_post($post_id);

            if ($isCurrentPost) {
                $viewProps = $this->auto_toc_model->get_viewProps($collectionProps);
                return $viewProps['items'];
            }

            return array();
        }

        /* Post_Model methods interface */

        public function is_current_post($article_id)
        {
            return $this->post_model->is_current_post($article_id);
        }

        public function get_current_post_info()
        {
            return $this->post_model->get_current_post_info();
        }

        public function is_top_level_article($child_terms_id_array, $taxonomy, $article)
        {
            return $this->post_model->is_top_level_article($child_terms_id_array, $taxonomy, $article);
        }
    }
}