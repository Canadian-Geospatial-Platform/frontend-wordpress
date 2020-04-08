<?php

namespace Helpie\Features\Components\Page_Controls;

if (!class_exists('\Helpie\Features\Components\Page_Controls\View')) {
    class View
    {

        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }


        public function get_view($props = [])
        {
            $is_single_article = $props['is_single'];

            // error_log('$props : ' . print_r($props, true));

            $html = "<div id='helpie-page-controls' class='ui buttons'>";

            if ($is_single_article) {
                $html .= $this->get_controls_for_single_article($props['capabilities'], $props['article']);
            } else {
                $html .= "<a target='_blank' class='add-article ui button' href='" . $this->get_link('add') . "'>" . $this->get_icon('add') . __("New", 'pauple-helpie') . " " . $props['article'] . "</a>";
            }

            $html .= "</div>";


            return $html;
        }

        public function get_icon($icon_type)
        {
            switch ($icon_type) {
                case "edit":
                    return "<i class='edit icon'></i>";
                    break;
                case "add":
                    return "<i class='plus square outline icon'></i>";
                    break;
                case "delete":
                    return "<i class='window close icon'></i>";
                    break;
                default:
                    return "<i class='edit icon'></i>";
            }
        }

        public function get_link($link_type)
        {
            $page_id = get_option('helpie_editor_page_id');
            $permalink = get_permalink($page_id);
            $current_post_id = get_the_ID();

            switch ($link_type) {
                case "edit":
                    return add_query_arg('post_id', $current_post_id, $permalink);
                    break;
                case "add":
                    return add_query_arg('editor_mode', 'add-article', $permalink);
                    break;
                case "delete":
                    return "<i class='window close icon'></i>";
                    break;
                default:
                    return "<i class='edit icon'></i>";
            }
        }




        public function get_controls_for_single_article($capabilities, $article)
        {

            // error_log('$article : ' . $article);
            $html = '';

            $current_post_id = get_the_ID();

            $html .= "<a target='_blank' class='edit-article ui button' href='" . $this->get_link('edit') . "'>" . $this->get_icon('edit') . " " . __("Edit", 'pauple-helpie') . "</a>";

            if ($capabilities['show_dropdown']) {
                $html .= "<div class='ui floating dropdown icon button'>";
                $html .= "<i class='dropdown icon'></i>";
                $html .= "<div class='menu'>";
            }

            if ($capabilities['show_new_button']) {
                $html .= "<a target='_blank' class='item' href='" . $this->get_link('add') . "'>" . $this->get_icon('add') . __("New", 'pauple-helpie') . " " . $article . "</a>";
            }

            if ($capabilities['show_delete_button']) {
                $is_admin = current_user_can('administrator');
                $delete = ($is_admin) ? __("Delete", "pauple-helpie") : __("Trash", "pauple-helpie");
                $html .= "<a class='item article-remove-option' data-article-id='" . $current_post_id . "'>" . $this->get_icon('delete') . $delete . " " . $article . "</a>";
            }

            if ($capabilities['show_dropdown']) {
                $html .= "</div>";
                $html .= "</div>";
            }

            return $html;
        }
    } // END CLASS
}