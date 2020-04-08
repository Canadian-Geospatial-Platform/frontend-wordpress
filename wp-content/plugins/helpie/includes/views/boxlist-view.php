<?php

namespace Helpie\Includes\Views;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Views\Boxlist_View')) {
    class Boxlist_View
    {

        public function get_view($viewProps)
        {

            $collectionProps = $viewProps['collection'];
            $articles = $viewProps['items'];
            $html = '';

            $extra_classes = '';

            if ($collectionProps['article_list_style'] == 'boxed') {
                $extra_classes .= ' boxed';
            }

            if ($collectionProps['article_list_columns'] == 'one') {
                $extra_classes .= ' one';
            }


            if (isset($articles)) {
                $count = 1;
                $html .= "<div class='helpiekb-container helpiekb-box-list-container'>";
                foreach ($articles as $article) {
                    if ($this->is_column_start($count, count($articles))) {
                        $html .= "<ul class='helpiekb-box-list " . $extra_classes . " child-category-list'>";
                    }
                    $html .= $this->get_article_li_html($article['link'], $article['title']);
                    if ($this->is_column_end($count, count($articles))) {
                        $html .= '</ul>';
                    }
                    $count++;
                }
            }

            $html .= "</div>";

            return $html;
        }

        public function get_article_li_html($permalink, $title)
        {
            $html = '';
            $html .= "<li class=''>";
            $html .= "<a href='" . $permalink . "'>" . __($title, 'pauple-helpie') . "</a>";
            $html .= "</li>";
            return $html;
        }

        public function is_column_start($count, $num_of_posts)
        {
            return ($count == 1 || $count == ceil($num_of_posts / 2) + 1);
        }

        public function is_column_end($count, $num_of_posts)
        {
            return ($count == ceil(($num_of_posts / 2)) || ($count == $num_of_posts));
        }
    } // END CLASS

}