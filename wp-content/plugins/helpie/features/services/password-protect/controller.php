<?php

namespace Helpie\Features\Services\Password_Protect;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Services\Password_Protect\Controller')) {
    class Controller
    {
        public function __construct()
        {
            /* helper needs to be first */
            $this->helper = new \Helpie\Includes\Utils\Pauple_Helper();

            $this->model = new \Helpie\Features\Services\Password_Protect\Model();
            $this->view = new \Helpie\Features\Services\Password_Protect\View();
        }

        public function load_hooks()
        {
            // Password Protect Only for KB Article content filter
            add_filter('helpie_kb_the_content', array($this, 'filter_the_content'), 10, 2);

            // Is Unlock filter condition for Pages purpose
            add_filter('helpiekb/is_unlocked', array($this, 'is_unlock'), 10, 2);

            // Password Protect For each Components Single items
            add_filter("helpiekb/search_single_item_filter", [$this, 'items_filter_callback'], 10, 4);
            add_filter("helpiekb/toc_single_item_filter", [$this, 'items_filter_callback'], 10, 4);
            add_filter("helpiekb/article_listing_single_item_filter", [$this, 'items_filter_callback'], 10, 4);
            add_filter("helpiekb/category_listing_single_item_filter", [$this, 'items_filter_callback'], 10, 4);

            // Helpiekb and Elementor widgets After render content both filter and action
            add_filter('helpiekb/widget/after_render_content', [$this, 'render_content_callback'], 10, 3);
            add_action('elementor/widget/render_content', [$this, 'render_content_callback'], 10, 3);

            // Ajax validation action hook OnModal submit
            add_action('wp_ajax_helpie_validate_password', array($this->model, 'validate'));
            add_action('wp_ajax_nopriv_helpie_validate_password', array($this->model, 'validate'));
        }

        public function filter_the_content($content)
        {
            $is_admin_user = $this->helper->check_if_user_is_admin();

            if ($is_admin_user) {
                return $content;
            }

            $is_unlocked = $this->is_unlock('article', $this->helper->get_post_id(null));

            if (!$is_unlocked) {
                $content = $this->view->get_access_restricted_message();
            }

            echo $this->view->get_view();
            return $content;
        }

        public function items_filter_callback($type, $id, $items, $component = "")
        {
            $items['is_password_permitted'] = $this->is_unlock($type, $id);
            $items['icon'] = (isset($items['icon'])) ? $items['icon'] : '';

            $items['lock_class'] = '';

            if (!$items['is_password_permitted']) {
                $items['link'] = '';
                $items['icon'] = '<i class="ui lock icon"></i>';
                $items['lock_class'] = 'protected';

                switch ($component) {
                    case "article_listing":
                        $items['icon'] = '<i class="ui large lock icon"></i>';
                        break;

                    case "category_listing":
                        $items['icon'] = '<i class="fa fa-lock" aria-hidden="true"></i>';
                        break;
                }
            }

            return $items;
        }

        public function is_unlock($type, $id)
        {
            return $this->model->is_unlock($type, $id);

        }

        public function render_content_callback($content = '', $widget, $plugin = 'elementor')
        {
            $widgets_list = ['helpie-kb-category-listing', 'helpie-kb-article-listing', 'helpie-kb-toc-widget'];

            $widget_name = ($plugin == 'elementor') ? $widget->get_name() : $widget['classname'];
            if (in_array($widget_name, $widgets_list)) {
                $content .= $this->get_Modal();
            }

            return $content;
        }

        public function get_Modal()
        {
            return $this->view->get_view();
        }

        public function get_access_restricted_message()
        {
            return $this->view->get_access_restricted_message();
        }

    } // END CLASS
}
