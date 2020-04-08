<?php

namespace Helpie\Includes\Views;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Views\Card_View')) {
    class Card_View
    {

        /* EXAMPLE USAGE:

        $viewProps = array(
            'collection' => array(
                'show_image' => true,
                'num_of_cols' => 'three',
                'show_extra' => true,

            ),

            'items' => array(
                0 => array(
                    'title' => 'Item Title',
                    'link' => 'http://localhost/item-title',
                    'meta' => 'Getting Started',
                    'image_url' => '....',
                    'description' => 'Item Description',
                    'date' =>
                    'user_name' => 'Admin'
                )
            )
        );
        */

        public function get_view($viewProps)
        {
            $num_of_cols = $viewProps['collection']['num_of_cols'];

            $html = "<div class='ui " . $num_of_cols . " column grid stackable'>";

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
            $html  = "<div class='column'>";

            $attr1 = "data-post-id='" . $props['post_id'] . "'";
            $attr2 = "data-term-id='" . $props['term_id'] . "'";
            $data_attrs = $attr1 . " " . $attr2;

            $classes = 'ui fluid card helpie-element ';
            $classes .= $props['lock_class'];
            
            $href = ($props['link'])?'href = "'.$props['link'].'"': '';
            
            $html .= "<div class='" . $classes . "' " . $data_attrs . ">";

            $show_image_true = ($collectionProps['show_image'] == 'true');
            $show_extra_true = ($collectionProps['show_extra'] == 'true');

            if ($show_image_true && isset($props['image_url']) && !empty($props['image_url'])) {
                $html .= "<a class='image' " . $href . ">";
                $html .= "<img src='" . $props['image_url'] . "'>";
                $html .= "</a>";
            }

            $html .= "<div class='item-content'>";
            
            if (isset($props['title']) && !empty($props['title'])) {                
                $html .= "<a " . $href . " class='header'>" . $props['icon'] . " " . __($props['title'], 'pauple-helpie') . "</a>";
            }

            if ($show_extra_true && isset($props['meta']) && !empty($props['meta'])) {
                $html .= "<div class='meta'>";
                $html .= "<a>" . $props['meta'] . "</a>";
                $html .= "</div>";
            }

            if (isset($props['description']) && !empty($props['description'])) {
                $html .= "<div class='description'>";
                $html .= "Matthew is an interior designer living in New York.";
                $html .= "</div>";
            }

            $html .= "</div>";


            if ($show_extra_true) {
                $html .= "<div class='extra content'>";

                if (isset($props['date']) && !empty($props['date'])) {
                    $html .= "<span class='right floated'>" . $props['date'] . "</span>";
                }

                if ($collectionProps['show_user_name'] == true && isset($props['user_name']) && !empty($props['user_name'])) {
                    $html .= "<span><i class='user icon'></i>";
                    $html .= __($props['user_name'], 'pauple-helpie');
                    $html .= "</span>";
                }
                $html .= "</div>";
            }

            $html .= "</div>";
            $html .= "</div>";

            return $html;
        }
    }
}