<?php
namespace Helpie\Features\Components\Category_Listing\Views;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Category_Listing\Views\Boxed1')) {
    class Boxed1
    {
        public function __construct($viewProps)
        {
            $this->collectionProps = $viewProps['collection'];
            // error_log(print_r($this->collectionProps), true);
        }
        public function render()
        {
            echo $this->get_view();
        }

        public function get_view($viewProps)
        {
            $num_of_cols = $viewProps['collection']['num_of_cols'];            

            $html = '';

            $html .= "<div class='category-list ui " . $num_of_cols . " column grid items stackable'>";

            for ($ii = 0; $ii < sizeof($viewProps['items']); $ii++) {
                $html .= $this->get_single_term_html($viewProps['items'][$ii]);
            }

            $html .= '</div>';

            return $html;
        }

        /* PROTECTED METHODS */

        protected function get_single_term_html($props)
        {            
            $term_link = $props['link'];
            $is_password_permitted_content = $props['is_password_permitted'];

            /* Rendering */
            $html = '';
            $html = "<div class='column'>";

            $classes = 'helpie-element  term-id-' . $props['term_id'];            
            $classes .= ' '.$props['lock_class'];   
            

            $html .= "<div class='" . $classes . "'>";

            if ($this->collectionProps['show_image'] == 'true') {
                $html .= $this->get_sicon_html($props['image'], $props['icon']);
            }

            $html .= "<div class='title header'>" . $props['title'] . '</div>';

            if ($this->collectionProps['show_description'] == true) {
                $html .= "<div class='description'>";
                $html .= $props['description'];
                $html .= '</div>';
            }

            if ($this->collectionProps['children_type'] != 'none') {
                $html .= $this->get_articles_of_term_html($props['children'], $props['num_of_articles']);
            }

            if ($is_password_permitted_content) {
                $anchor_html = $this->get_term_more_link($term_link);
                $html .= $anchor_html;
            }
            $html .= "<div class='clear'></div>";
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }

        protected function get_sicon_html($image_html, $icon)
        {
            if ($this->collectionProps['graphic_type'] == 'icon') {
                return "<div class='sicon'>" . $icon . "</div>";
            } else {
                return "<div class='sicon'>" . $image_html . '</div>';
            }
        }

        protected function get_term_more_link($term_link)
        {
            $anchor_html = "<a class='more' href='" . $term_link . "'>";
            $anchor_html .= __('More', 'pauple-helpie');
            $anchor_html .= '&nbsp;&nbsp;';
            $anchor_html .= "<i class='fa fa-arrow-right' aria-hidden='true'></i>";
            $anchor_html .= '</a>';

            return $anchor_html;
        }

        /* Article Methods */

        protected function get_articles_of_term_html($articleListProps, $num_of_articles)
        {
            $html = "<ul class='article-preview-list'>";

            for ($ii = 0; $ii < $num_of_articles; ++$ii) {
                $articleProps = $articleListProps[$ii];
                $child_items_view = new \Helpie\Features\Components\Category_Listing\Views\Partials\Child_Items();
                $html .= $child_items_view->get_view($articleProps);
            }

            $html .= '</ul>';

            return $html;
        }
    } // END CLASS
}