<?php

namespace Helpie\Templates\Views\Category_Page;

if (!class_exists('Helpie\Templates\Views\Category_Page\Category_Page_Model')) {
    class Category_Page_Model
    {
        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->editor = new \Helpie\Features\Components\Frontend_Editor\Editor_Controller();
        }

        public function get_viewProps($args)
        {
            // $args = $this->append_fallbacks($args);

            $viewProps = array(
                'collection' => $this->get_collection_props($args),
                'items' => $this->get_items_props($args),
            );

            return $viewProps;
        }

        public function get_collection_props($term)
        {
            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();
            $can_view = $dynamic_caps->get_final_topic_has_cap($term->term_id, 'can_view');


            $editor_control = $this->show_frontend_editor($term);
            $props = array(
                'editor_control' => $editor_control,
                'is_accessible' => $can_view,
                'article_list_style' =>  $this->settings->category_page->get_article_list_style(),
                'article_list_columns' => $this->settings->category_page->get_article_list_columns(),
                'child_category_template' => $this->settings->category_page->get_child_category_template(),

            );

            return $props;
        }

        public function show_frontend_editor($term)
        {
            if ($this->settings->core->is_frontend_editing_enabled() != true) {
                return false;
            }

            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();
            $can_edit = $dynamic_caps->get_final_topic_has_cap($term->term_id, 'can_edit');
            $can_publish = $dynamic_caps->get_final_topic_has_cap($term->term_id, 'can_publish');
            $can_approve = $dynamic_caps->get_final_topic_has_cap($term->term_id, 'can_approve');

            if ($can_edit || $can_publish || $can_approve) {
                return true;
            }

            return false;
        }

        public function get_items_props($args)
        {

            // error_log('get_items_props');
            $term = get_terms($args);
            // error_log('$terms : ' . print_r($term, true));

            $items_props = $this->get_categoriesProps($term);
            // error_log('$items_props : ' . print_r($items_props, true));

            return $items_props;
        }

        public function get_categoriesProps($wp_categories)
        {

            $container = array();

            foreach ($wp_categories as $cat_key => $wp_category) {
                // parent Category
                $kb_category = new \Helpie\Features\Domain\Models\Kb_Category($wp_category);
                $single_category_viewProps = $this->get_category_viewProps($kb_category);
                array_push($container, $single_category_viewProps);

                // child categories
                if (isset($kb_category->child) && !empty($kb_category->child)) {
                    $wp_child_categories = $kb_category->get_child_categories_wpobjects();
                    foreach ($wp_child_categories as $sub_cat_key => $wp_child_category) {
                        $kb_child_category = new \Helpie\Features\Domain\Models\Kb_Category($wp_child_category);
                        $single_child_category_viewProps = $this->get_category_viewProps($kb_child_category);
                        array_push($container, $single_child_category_viewProps);
                    }
                }
            }

            // error_log('$container : ' . print_r($container, true));
            return $container;
        }



        public function get_category_viewProps($kb_category)
        {

            $articles = $kb_category->get_top_level_articles(-1);
            // error_log('get_category_viewProps count($articles) : ' . count($articles));
            $category = array(
                'id' => $kb_category->term_id,
                'title' => $kb_category->name,
                'parent' => $kb_category->parent,
                'child' => $kb_category->child,
                'link' => $kb_category->get_category_link(),
                'articles' => $this->get_articles($articles),
            );
            return $category;
        }

        protected function get_articles($articles)
        {
            $articles_props = array();
            $ii = 0;
            foreach ($articles as $article) {

                $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($article);
                $single_article_props = $this->set_single_article($kb_article);
                array_push($articles_props, $single_article_props);
                $ii++;
            }

            return $articles_props;
        }

        protected function set_single_article($kb_article)
        {
            $post_id = $kb_article->get_the_ID();

            return array(
                'title' => $kb_article->get_title(),
                'link' => $kb_article->get_permalink(),
                'id' => $post_id,
            );
        }
    }
}