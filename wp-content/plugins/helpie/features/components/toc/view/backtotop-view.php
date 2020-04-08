<?php

namespace Helpie\Features\Components\Toc\View;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Components\Toc\View\Backtotop_View')) {

    class Backtotop_View
    {
        public function get_view($collectionProps, $content)
        {
            if ($collectionProps['show_back_to_top'] == true) {

                $html = $this->get_html($collectionProps);
                $content = $this->get_expression($content, $html);

                return $content;
            }

            return $content;
        }

        // protected Methods
        protected function get_html($collectionProps)
        {
            $html = '<div class="helpieBackToTop ' . $this->get_classes($collectionProps) . '">';
            $html .= '<a class="anchor-text">' . __($collectionProps['back_to_top_text'], 'pauple-helpie');
            $html .= ' &#8593;';
            $html .= '</a>';
            $html .= '</div>';

            return $html;
        }
        protected function get_expression($content, $html)
        {

            $headingsPattern = '/<h([1-6])[^>]*>\S.*<\/h\1>/msuU';
            $content = preg_replace_callback($headingsPattern, function ($matches) use (&$html) {
                $head = $matches[0];

                $matches[0] = '<div class="headings-wrapper">'; // Heading Wrapper
                $matches[0] .= $head; // Head Tag With content
                $matches[0] .= $html; // Adding Backtotop html
                $matches[0] .= '</div>'; // closing div

                return $matches[0];
            }, $content);

            return $content;
        }

        protected function get_classes($collectionProps)
        {
            $backToTop = ($collectionProps['scroll_back_to_top'] == true) ? 'pageTop' : 'articleTop';
            $smooth_scroll = ($collectionProps['smooth_scroll'] == true) ? 'smooth-scroll' : '';

            return $smooth_scroll . ' ' . $backToTop;
        }
    }
}