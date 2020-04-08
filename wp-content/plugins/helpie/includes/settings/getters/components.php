<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Components')) {
    class Components
    {
        public function __construct()
        {
            $this->options = get_option('helpie-kb'); // unique id of the framework
        }

        public function get_toc_settings()
        {
            return array(
                'show_auto_toc' => $this->show_auto_toc(),
                'show_toc_articles' => $this->show_toc_articles(),
                'title' => $this->get_title(),
                'category_anchor_link' => $this->get_category_anchor_link(),
                'toc_type' => $this->get_toc_type(),
                'toc_categories' => $this->get_toc_categories(),
                'toggle_category_children' => $this->toggle_category_children(),
                'article_limit' => $this->get_article_limit(),
                'child_category_limit' => $this->get_child_category_limit(),
                'exclude_heads' => $this->get_auto_toc_exclude_heads(),
                'auto_toc_title' => $this->get_auto_toc_title(),
                'show_numeric_bullet' => $this->get_auto_toc_numeric_bullet(),
                'show_back_to_top' => $this->get_auto_toc_back_to_top_link(),
                'back_to_top_text' => $this->get_auto_toc_back_to_top_text(),
                'show_section_page_url' => $this->get_auto_toc_section_page_url(),
                'section_page_url_text' => $this->get_auto_toc_section_page_url_text(),
                'scroll_back_to_top' => $this->get_auto_toc_scroll_back_to_site_top(),
                'smooth_scroll' => $this->get_auto_toc_smooth_scroll(),
            );
        }

        public function get_article_order()
        {
            $article_order = 'menu_order';
            if (isset($this->options['article_order'])) {
                $article_order = $this->options['article_order'];
            }

            return $article_order;
        }

        public function show_auto_toc()
        {
            $auto_toc_option = false;
            if (isset($this->options['helpie_sidebar_auto_toc'])) {
                $auto_toc_option = $this->options['helpie_sidebar_auto_toc'];
            }

            return $auto_toc_option;
        }

        public function show_toc_articles()
        {
            $show = true;
            if (isset($this->options['helpie_sidebar_show_articles'])) {
                $show = $this->options['helpie_sidebar_show_articles'];
            }

            return $show;
        }

        public function can_show_breadcrumbs()
        {
            $can_show_breadcrumbs = isset($this->options['helpie_breadcrumbs']) ? $this->options['helpie_breadcrumbs'] : true;
            return $can_show_breadcrumbs;
        }

        public function get_sidebar_position()
        {

            $position = false;
            if (isset($this->options['helpie_sidebar_fixed'])) {
                $position = $this->options['helpie_sidebar_fixed'];
            }

            return $position;
        }

        public function get_category_anchor_link()
        {
            $category_anchor_link = '';
            if (isset($this->options['helpie_sidebar_category_anchor_link'])) {
                $category_anchor_link = $this->options['helpie_sidebar_category_anchor_link'];
            }

            return $category_anchor_link;
        }

        public function toggle_category_children()
        {
            $toggle_category_children = true;
            // if (isset($this->options['helpie_sidebar_cat_toggle']) || $this->options['helpie_sidebar_cat_toggle'] == false) {

            if (array_key_exists("helpie_sidebar_cat_toggle", $this->options) && !empty($this->options['helpie_sidebar_cat_toggle'])) {
                $toggle_category_children = $this->options['helpie_sidebar_cat_toggle'];
            }

            return $toggle_category_children;
        }

        public function get_child_category_limit()
        {
            $child_category_limit = 5;
            if (isset($this->options['helpie_sidebar_num_of_child_category'])) {
                $child_category_limit = $this->options['helpie_sidebar_num_of_child_category'];
            }

            return $child_category_limit;
        }

        public function get_article_limit()
        {
            $article_limit = 5;
            if (isset($this->options['helpie_sidebar_num_of_articles'])) {
                $article_limit = $this->options['helpie_sidebar_num_of_articles'];
            }

            return $article_limit;
        }

        public function get_title()
        {
            $title = 'Table of Contents';
            if (isset($this->options['helpie_sidebar_title'])) {
                $title = $this->options['helpie_sidebar_title'];
            }

            return $title;
        }

        public function get_toc_type()
        {
            $toc_type = 'full-nav';
            if (isset($this->options['helpie_sidebar_type'])) {
                $toc_type = $this->options['helpie_sidebar_type'];
            }

            return $toc_type;
        }

        public function get_toc_categories()
        {
            $toc_categories = 'all';
            if (isset($this->options['helpie_sidebar_categories'])) {
                $toc_categories = $this->options['helpie_sidebar_categories'];
            }

            return $toc_categories;
        }

        public function get_auto_toc_exclude_heads()
        {
            $option_name = 'helpie_auto_toc_exclude_headings';
            // $option = get_option($option_name);
            $option = $this->options;

            $exlude_heads = array();

            if (isset($option[$option_name])) {
                $exlude_heads = $option[$option_name];
            }

            if (!is_array($exlude_heads) && !empty($exlude_heads)) {
                $exlude_heads = (explode(",", $exlude_heads));
            }

            return $exlude_heads;
        }

        public function get_auto_toc_title()
        {
            $title = __('In this article', 'pauple-helpie');
            if (isset($this->options['helpie_auto_toc_title'])) {
                $title = $this->options['helpie_auto_toc_title'];
            }

            return $title;
        }
        public function get_auto_toc_numeric_bullet()
        {
            $auto_toc_bullet = '';
            if (isset($this->options['helpie_auto_toc_bullet'])) {
                $auto_toc_bullet = $this->options['helpie_auto_toc_bullet'];
            }

            return $auto_toc_bullet;
        }

        public function get_auto_toc_section_page_url()
        {
            $section_page_url = true;
            if (array_key_exists("helpie_auto_toc_section_page_url", $this->options) && !empty($this->options['helpie_auto_toc_section_page_url'])) {
                $section_page_url = $this->options['helpie_auto_toc_section_page_url'];
            }

            return $section_page_url;
        }

        public function get_auto_toc_section_page_url_text()
        {
            $section_page_url_text = 'helpie-sp';
            if (isset($this->options['helpie_auto_toc_section_page_url_text'])) {
                $section_page_url_text = $this->options['helpie_auto_toc_section_page_url_text'];
            }

            return $section_page_url_text;
        }

        public function get_auto_toc_back_to_top_text()
        {
            $back_to_text = 'Back To Top ';
            if (isset($this->options['helpie_auto_toc_back_to_top_text'])) {
                $back_to_text = $this->options['helpie_auto_toc_back_to_top_text'];
            }

            return $back_to_text;
        }

        public function get_auto_toc_scroll_back_to_site_top()
        {
            $back_to_site_top = '';
            if (isset($this->options['helpie_auto_toc_scroll_back_to_site_top'])) {
                $back_to_site_top = $this->options['helpie_auto_toc_scroll_back_to_site_top'];
            }

            return $back_to_site_top;
        }

        public function get_auto_toc_back_to_top_link()
        {
            $back_to_top_link = '';
            if (isset($this->options['helpie_auto_toc_back_to_top_link'])) {
                $back_to_top_link = $this->options['helpie_auto_toc_back_to_top_link'];
            }

            return $back_to_top_link;
        }

        public function get_auto_toc_smooth_scroll()
        {
            $toc_smooth_scroll = '';
            if (isset($this->options['helpie_auto_toc_smooth_scroll'])) {
                $toc_smooth_scroll = $this->options['helpie_auto_toc_smooth_scroll'];
            }

            return $toc_smooth_scroll;
        }
    } // END CLASS
}