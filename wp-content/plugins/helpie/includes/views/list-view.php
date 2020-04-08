<?php

namespace Helpie\Includes\Views;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Views\List_View')) {
    class List_View
    {

        /* EXAMPLE USAGE:

        $viewProps = array(
            'collection' => array(
                'show_image' => true
            ),

            'items' => array(
                0 => array(
                    'title' => 'Item Title',
                    'link' => 'http://localhost/item-title'
                )
            )
        );
        */

        public function get_view($viewProps)
        {
            $html = "<div class='ui relaxed divided list'>";

            for ($ii = 0; $ii < sizeof($viewProps['items']); $ii++) {
                $itemProps = $viewProps['items'][$ii];
                $collectionProps = $viewProps['collection'];
                $html .= $this->get_item($itemProps, $collectionProps);
            }

            $html .= "</div>";
            return $html;
        }

        public function get_item($props, $collectionProps)
        {
            $attr1 = '';
            if (isset($props['post_id'])) {
                $attr1 = "data-post-id='" . $props['post_id'] . "'";
            }

            $attr2 = "data-term-id='" . $props['term_id'] . "'";
            $data_attrs = $attr1 . " " . $attr2;

            $classes = 'item helpie-element ';
            $classes .= $props['lock_class'];

            $href = ($props['link'])?'href = "'.$props['link'].'"': '';

            $html = "<div class='" . $classes . "' " . $data_attrs . ">";

            $html .= "<div class='item-content'>";

            $icon_html = ($collectionProps['show_image']) ? $props['icon'] : '';

            $html .= "<a " . $href . " class='header'>" . $icon_html . " " . $props['title'] . "</a>";


            // $html .= "<div class='description'>".$props['title']."</div>";
            $html .= "</div>";
            $html .= "</div>";

            return $html;
        }
    }
}