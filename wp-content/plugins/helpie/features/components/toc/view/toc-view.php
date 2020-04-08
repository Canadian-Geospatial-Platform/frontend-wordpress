<?php

namespace Helpie\Features\Components\Toc\View;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Toc\View\Toc_View')) {
    class Toc_View
    {
        public function get($viewProps)
        {
            $this->viewProps = $viewProps;
            $this->collectionProps = $viewProps['collection'];
            $this->itemsProps = $viewProps['items'];

            $html = '';
            $html = '<div class="helpie-toc">';
            if (isset($viewProps['collection']['source']) && !empty($viewProps['collection']['source']) != ('widget')) {
                $html .= $this->get_header($this->collectionProps);
            }

            $html .= $this->get_body($this->itemsProps, $this->collectionProps);
            $html .= $this->get_footer();

            return $html;
        }

        protected function get_header($collectionProps)
        {
            // $html = '<div class="helpie-toc">';
            $html = '<div class="ui top attached large label collection-title">';
            $html .= __($collectionProps['title'], 'pauple-helpie');
            $html .= '</div>';

            return $html;
        }

        protected function get_body($itemsProps, $collectionProps)
        {
            return $this->get_categories_html($itemsProps, $collectionProps);
        }

        protected function get_categories_html($itemsProps, $collectionProps, $index = 0)
        {
            $html = '';
            foreach ($itemsProps as $itemProps) {

                if ($itemProps['parent'] == $index) {
                    $html .= $this->get_category_html($itemProps, $collectionProps);
                }
            }

            return $html;
        }

        protected function get_category_html($itemProps, $collectionProps)
        {
            $html = '<div class="helpie-accordion helpie-element">';
            $html .= $this->get_category_title($itemProps, $collectionProps);

            if ($itemProps['is_password_permitted']) {
                $html .= $this->get_category_content($itemProps, $collectionProps);
            }

            $html .= '</div>';

            return $html;
        }

        protected function is_current_lineage($itemProps)
        {
            $post_info = $this->get_current_post_info();

            // error_log('$post_info : ' . print_r($post_info, true));
            if (!$this->is_set($post_info) || empty($post_info['lineage'])) {
                return false;
            }

            if (in_array($itemProps['id'], $post_info['lineage'])) {
                return true;
            }

            return false;
        }


        protected function get_category_title($itemProps, $collectionProps)
        {
            $classes = 'item-title ';
            $classes .= $itemProps['lock_class'];
            $icon = '<i class="angle right icon"></i>';
            $href = '';            

            if ($this->is_current_lineage($itemProps)) {
                $icon = '<i class="angle down icon"></i>';
            }

            if ($collectionProps['category_anchor_link']) {
                $href = ($itemProps['link']) ? 'href = "' . $itemProps['link'] . '"' : '';
            }

            $html = '<div class="' . $classes . ' term-id-' . $itemProps['id'] . '">';

            // Angle and lock Icon
            if (($this->is_set($itemProps['articles']) && $collectionProps['show_toc_articles'] == true) || $this->is_set($itemProps['child']) || !$itemProps['is_password_permitted']) {
                $html .= ($itemProps['icon']) ? $itemProps['icon'] : $icon;
            }

            $html .= '<a ' . $href . ' class="cat">' . __($itemProps['title'], 'pauple-helpie') . '</a>';
            $html .= '</div>';

            return $html;
        }       

        protected function get_category_content($itemProps, $collectionProps)
        {
            $html = '';
            $active = $this->is_active_category($collectionProps);


            if ($this->is_current_lineage($itemProps)) {
                $active = 'active';
            }

            if ($this->is_set($itemProps['articles']) || $this->is_set($itemProps['child'])) {
                $html .= '<div class="item-content ' . $active . '">';

                if ($this->is_set($itemProps['articles']) && $collectionProps['show_toc_articles'] == true) {
                    $html .= $this->get_articles($itemProps['articles']);
                }
                if ($this->is_set($itemProps['child'])) {
                    $html .= $this->get_sub_category_html($itemProps, $collectionProps);
                }
                $html .= '</div>';
            }

            return $html;
        }

        public function get_sub_category_html($itemProps, $collectionProps)
        {
            $html = '';
            if ($this->is_set($itemProps['child'])) {
                $props = [];
                $limit = 0;
                foreach ($itemProps['child'] as $child) {
                    if ($collectionProps['child_category_limit'] == $limit) {
                        break;
                    }
                    $collection = array_filter($this->itemsProps, function ($element) use ($child) {
                        return ($element['id'] == $child);
                    });
                    array_push($props, array_values($collection));
                    $limit++;
                }

                foreach ($props as $prop) {
                    if ($this->is_set($props)) {
                        $html .= $this->get_category_html($prop[0], $collectionProps);
                    }
                }
            }
            return $html;
        }

        protected function get_articles($allArticlesProps)
        {
            $body_html = '<div class="helpie-accordion helpie-element">';

            foreach ($allArticlesProps as $articleProps) {
                $body_html .= $this->get_article_html($articleProps);
            }

            $body_html .= "</div>";

            return $body_html;
        }

        protected function get_article_html($articleProps)
        {
            $classes = 'article-id-' . $articleProps['id'];
            $active = $this->is_active_category($this->collectionProps);

            if ($articleProps['isCurrentPost'] == true) {
                $post_info = $this->get_current_post_info();
                if ($post_info['post_id'] == $articleProps['id']) {
                    $active = 'active';
                }

                $this->auto_toc_view = new \Helpie\Features\Components\Toc\View\Auto_TOC_View();
                $props = $articleProps['autoTOCProps'];

                $html = '<div class="helpie-accordion active helpie-element">';
                $html .= '<div class="item-title active">';
                $html .= '<a>' . __($articleProps['title'], 'pauple-helpie') . '</a>';
                $html .= '</div>';

                if ($this->collectionProps['show_auto_toc'] && !empty($props)) {
                    $viewProps = array(
                        'collection' => $this->collectionProps,
                        'items' => $props,
                    );

                    $html .= '<div class="ui selection list item-content ' . $active . '">';
                    $html .= $this->auto_toc_view->get($viewProps);
                    $html .= '</div>';
                }

                $html .= '</div>';

                return $html;
            }

            $html = '<div class="helpie-accordion helpie-element">';
            $html .= '<div class="item-title">';
            $html .= '<a href="' . $articleProps['link'] . '">' . __($articleProps['title'], 'pauple-helpie') . '</a>';
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }

        public function get_footer()
        {
            return "</div>";
        }

        protected function is_set($item)
        {
            return (isset($item) && !empty($item));
        }

        protected function get_current_post_info()
        {
            $post_model = new \Helpie\Features\Components\Sidebar\Model\Post_Model();
            return $post_model->get_current_post_info();
        }

        protected function is_active_category($collectionProps)
        {
            $active = 'active';
            if ($collectionProps['toggle_category_children']) {
                $active = '';
            }

            return $active;
        } // End Function
    } // END CLASS
}