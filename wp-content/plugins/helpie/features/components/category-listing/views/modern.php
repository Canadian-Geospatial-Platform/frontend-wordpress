<?php

namespace Helpie\Features\Components\Category_Listing\Views;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Category_Listing\Views\Modern')) {
    class Modern
    {
        private $collectionProps;

        public function __construct($viewProps)
        {
            $this->collectionProps = $viewProps['collection'];
        }

        public function render()
        {
            echo $this->get_view();
        }

        public function get_view($viewProps)
        {
            $num_of_cols = $viewProps['collection']['num_of_cols'];

            $html = "<div class='category-list ui " . $num_of_cols . " column grid items stackable'>";

            $term_count = 0;

            for ($ii = 0; $ii < sizeof($viewProps['items']); $ii++) {
                $html .= $this->get_single_term_html($viewProps['items'][$ii]);
                ++$term_count;
            }

            $html .= '</div>';

            return $html;
        }

        protected function get_single_term_html($termProps)
        {
            $html = '';

            $html = "<div class='column'>";

            $classes = 'helpie-element item term-id-' . $termProps['term_id'];            
            $classes .= ' ' . $termProps['lock_class'];
            

            $html .= "<div class='" . $classes . "'>";

            $html .= $this->get_image_area_html($termProps);
            $html .= $this->get_content_area_html($termProps);

            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }

        protected function get_image_area_html($termProps)
        {
            $html = '';

            $show_image_true = ($this->collectionProps['show_image'] == 'true');

            if ($show_image_true == false) {
                return $html;
            }

            if ($termProps['is_password_permitted']) {
                $html .= "<div class='ui tiny circular image'>";

                if ($this->collectionProps['graphic_type'] == 'icon') {
                    $html .= $termProps['icon'];
                } else {
                    $html .= $termProps['image'];
                }

                $html .= "</div>";
            } else {
                if (isset($termProps['icon']) && !empty($termProps['icon'])) {
                    $html .= "<a class='ui tiny image'>";
                    $html .= "<i class='fa fa-lock' aria-hidden=true></i>";
                    $html .= "</a>";
                }
            }

            return $html;
        }

        protected function get_content_area_html($props)
        {
            $html = '';
            $html .= "<div class='middle aligned item-content'>";

            $href = ($props['link'])?'href = "'.$props['link'].'"': '';

            $html .= "<a class='header' " . $href . "><h3 >" . $props['title'] . "</h3></a>";

            if ($this->collectionProps['show_description'] == true) {
                $html .= "<div class='description'>";
                $html .= $props['description'];
                $html .= '</div>';
            }

            if ($this->collectionProps['children_type'] != 'none') {
                $html .= $this->get_articles_of_term_html($props['children'], $props['num_of_articles']);
            }

            $count_string = __('articles in this topic', 'pauple-helpie');
            if ($this->collectionProps['children_type'] == 'sub-categories') {
                $count_string = __('sub topics in this topic', 'pauple-helpie');
            }

            $html .= "<div class='meta'>";
            $html .= "<span><strong>" . $props['count'] . " </strong>" . $count_string . "</span>";
            $html .= "</div>";

            $html .= '</div>';

            return $html;
        }

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