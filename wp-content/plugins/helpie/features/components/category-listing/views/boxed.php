<?php

namespace Helpie\Features\Components\Category_Listing\Views;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Category_Listing\Views\Boxed')) {
    class Boxed
    {
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

            $html = '';
            $html .= "<div class='category-list ui " . $num_of_cols . " column grid items stackable'>";

            for ($ii = 0; $ii < sizeof($viewProps['items']); $ii++) {
                $html .= $this->get_single_category_box($viewProps['items'][$ii]);
            }

            $html .= '</div>';

            return $html;
        }

        /* PROTECTED METHODS */

        protected function get_single_category_box($props)
        {
            $html = "<div class='column'>";

            $classes = 'helpie-element  term-id-' . $props['term_id'];            
            $classes .= ' '.$props['lock_class'];   
            
            $href = ($props['link'])?'href = "'.$props['link'].'"': '';

            $html .= "<a class='" . $classes . "' " . $href . ">";

            if ($this->collectionProps['show_image'] == 'true') {
                $html .= $this->get_sicon_html($props['image'], $props['icon_code']);
            }

            $html .= $this->get_title_html($props['title'], $props['is_password_permitted']);

            if ($this->collectionProps['show_description'] == true) {
                $html .= $this->get_description_html($props['description']);
            }

            $html .= $this->get_browse_button();
            $html .= '</a></div>';

            return $html;
        }

        protected function get_sicon_html($image_html, $icon_code)
        {
            if ($this->collectionProps['graphic_type'] == 'icon') {
                return "<div class='sicon'> <i class='fa ". $icon_code . "'></i></div>";
            } else {
                return "<div class='sicon'>" . $image_html . '</div>';
            }
        }

        protected function get_title_html($title, $is_password_permitted_content)
        {
            $html = "<div class='title header'>";

            if (!$is_password_permitted_content) {
                $html .= "<i class='ui lock icon'></i>";
            }

            $html .= __($title, 'pauple-helpie');
            $html .= '</div>';

            return $html;
        }

        protected function get_description_html($description)
        {
            $description_html = "<div class='description'>" . $description . '</div>';

            return $description_html;
        }

        protected function get_browse_button()
        {
            return "<button class='browser-all'>" . __('Browse All', 'pauple-helpie') . '</button>';
        }
    }
}