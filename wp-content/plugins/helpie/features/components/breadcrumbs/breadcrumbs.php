<?php

namespace Helpie\Features\Components\Breadcrumbs;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


if (!class_exists('\Helpie\Features\Components\Breadcrumbs\Breadcrumbs')) {
    class Breadcrumbs
    {
        private $breadcrumbs_model;

        public function __construct()
        {
            $this->breadcrumbs_model = new \Helpie\Features\Components\Breadcrumbs\Breadcrumbs_Model();
        }

        public function get_view($current_term_id = '')
        {

            $html = '';

            $post_id = get_the_ID();
            $page = is_archive() ? 'archive' : 'single';
            $bread_info = $this->breadcrumbs_model->get_info($post_id, $page);

            // error_log('$bread_info : ' . print_r($bread_info, true));

            $order = ['post_type', 'parent_term', 'term', 'post'];

            $html .= "<div class='breadcrumbs pauple_helpie_breadcrumbs'>";

            for ($ii = 0; $ii < sizeof($bread_info); $ii++) {
                $key = $order[$ii];
                if (isset($bread_info[$key]) && !empty($bread_info[$key])) {

                    if ($ii != 0) {
                        $html .= $this->get_separator();
                    }

                    $html .= $this->single_item($bread_info[$key]['permalink'], $bread_info[$key]['title']);
                }
            }

            $html .= '</div>';

            return $html;
        } // end qt_custom_breadcrumbs()

        private function single_item($link = '', $title = '')
        {
            return  "<a class='mainpage-link' href='" . $link . "'>" . $title . '</a> ';
        }

        private function get_separator()
        {
            $html = "<span class='helpiekb_separator'> &nbsp;&nbsp; <i class='fa fa-angle-right' aria-hidden='true'></i>&nbsp;&nbsp;</span>";
            return $html;
        }
    } // end of class
}
