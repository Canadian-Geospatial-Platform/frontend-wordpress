<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Cp_Getter')) {
    class Cp_Getter
    {
        public function __construct()
        {
            // $this->options = get_option('helpie_cp_options');
            $this->options = get_option('helpie-kb'); // unique id of the framework
            // error_log('$this->options : ' . print_r($this->options, true));
        }

        public function show_search()
        {


            $show_search = true;
            $show_search = isset($this->options['helpie_cat_page_search_display']) ? $this->options['helpie_cat_page_search_display'] : false;

            return $show_search;
        }

        // TODO: Extract this method. Has duplicates in other getters
        public function can_show_module($option_name)
        {
            $show = false;

            if (isset($this->options[$option_name])) {
                $value = sanitize_text_field($this->options[$option_name]);
                if ($value == "on") {
                    $show = true;
                }
            }

            return $show;
        }

        public function get_child_category_template()
        {
            $template = "boxed";

            if (isset($this->options['helpie_cp_child_category_template'])) {
                $template = $this->options['helpie_cp_child_category_template'];
            }

            return $template;
        }

        public function get_article_list_style()
        {
            $list_style = "boxed";

            if (isset($this->options['helpie_cp_article_list_style'])) {
                $list_style = $this->options['helpie_cp_article_list_style'];
            }

            return $list_style;
        }

        public function get_article_list_columns()
        {
            $columns = "two";

            if (isset($this->options['helpie_cp_article_list_columns'])) {
                $columns = $this->options['helpie_cp_article_list_columns'];
            }

            return $columns;
        }


        public function get_template()
        {
            $template = "left-sidebar";

            if (isset($this->options['helpie_cp_template'])) {
                $template = $this->options['helpie_cp_template'];
            }

            return $template;
        }

        public function can_show_catp_sidebar()
        {

            $can_show_sidebar = true;



            if (array_key_exists('helpie_cat_page_sidebar_display', $this->options) && !empty($this->options['helpie_cat_page_sidebar_display'])) {
                $can_show_sidebar = $this->options['helpie_cat_page_sidebar_display'];
            }
            return $can_show_sidebar;
        }

        public function get_cpt_category_slug()
        {
            $cp_slug = "helpdesk_category";

            if (isset($this->options['helpie_cp_slug'])) {
                $cp_slug = $this->options['helpie_cp_slug'];
            }

            return $cp_slug;
        }
    }
}