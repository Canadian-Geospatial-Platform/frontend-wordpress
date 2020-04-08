<?php

namespace Helpie\Features\Components\Category_Listing;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Category_Listing\Category_Listing')) {
    class Category_Listing
    {
        private $taxonomy = 'helpdesk_category';

        public function __construct()
        {
            // Models
            $this->category_listing_model = new \Helpie\Features\Components\Category_Listing\Category_Listing_Model();
        }

        public function get_view($args = array())
        {
            $viewProps = $this->category_listing_model->get_viewProps($args);

            $view = $this->get_view_type($viewProps);
            $view .= "<div class='clear'></div>";

            return $view;
        }

        /* PROTECTED METHODS */

        protected function get_view_type($viewProps)
        {
            $collectionProps = $viewProps['collection'];
            $listing_type = $viewProps['collection']['type'];
            // $viewProps['collection']['show_description'] = $viewProps['collection']['show_description'] === 'true' ? true : false;

            // error_log(' show_description: ' . print_r(gettype($viewProps['collection']['show_description']), true));
            if ($listing_type == 'boxed') {
                $this->boxed_view = new \Helpie\Features\Components\Category_Listing\Views\Boxed($viewProps);
                $view = $this->boxed_view->get_view($viewProps);
            } elseif ($listing_type == 'boxed1') {
                $this->boxed1_view = new \Helpie\Features\Components\Category_Listing\Views\Boxed1($viewProps);
                $view = $this->boxed1_view->get_view($viewProps);
            } elseif ($listing_type == 'modern') {
                $this->modern_view = new \Helpie\Features\Components\Category_Listing\Views\Modern($viewProps);
                $view = $this->modern_view->get_view($viewProps);
            } elseif ($listing_type == 'list') {
                $this->list_view = new \Helpie\Includes\Views\List_View();
                $view = $this->list_view->get_view($viewProps);
            } else {
                $view = $this->boxed_view->get_view($viewProps);
            }

            $view_type_identifier = "helpie-categories-section-" . $listing_type;
            // the ID  only exists to support user defined Custom CSS
            $html = "<div id='" . $view_type_identifier . "' class='content-section " . $view_type_identifier . "'>";
            // .category-main-content-boxed only exists to support user defined Custom CSS
            $html .= "<div class='category-main-content-boxed helpie-category-listing'>";

            if ($collectionProps['show_widget_title'] == 'true' && (!isset($collectionProps['source']) || $collectionProps['source'] != 'widget')) {
                $title_content = __($collectionProps['title'], 'pauple_helpie');
                $html .= "<h3 class='collection-title'>" . $title_content . "</h3>";
            }

            $html .= $view;

            $html .= "</div>";
            $html .= "</div>";

            // error_log('$html : ' . print_r($html, true));
            return $html;
        }
    }
}