<?php

namespace Helpie\Features\Components\Toc\View;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Components\Toc\View\Id_Added_Content_View')) {

    class Id_Added_Content_View
    {
        public function get_view($viewProps, $content)
        {
            $content = $this->get_expressioned_content($viewProps, $content);

            return $content;
        }

        // protected methods

        protected function get_expressioned_content($viewProps, $content)
        {
            $collectionProps = $viewProps['collection'];
            $props = $viewProps['items'];
            $exclude = $this->get_excluded_heads($collectionProps);

            $headingsPattern = '/(<h([' . $exclude . '])[^>]*>)(\S.*)(<\/h\2>)/msuU';

            $ii = 0; // passing to closure for each iteration

            $content = preg_replace_callback($headingsPattern, function ($matches) use (&$ii, &$props) {

                $matches[0] = $matches[1]; // Head Tag With its html attributes
                $matches[0] .= '<span id="' . $props[$ii]['head_id'] . '">'; // Adding Generated Id
                $matches[0] .= $matches[3]; // Head Tag Inner Html Content
                $matches[0] .= '</span>';
                $matches[0] .= $matches[4]; // closing Head tag

                $ii++;

                return $matches[0];
            }, $content);

            return $content;
        }

        protected function get_excluded_heads($collectionProps)
        {
            $exclude = $collectionProps['exclude_heads'];

            if (isset($exclude) && !empty($exclude)) {

                $exclude = implode(',', array_diff([1, 2, 3, 4, 5, 6], $exclude));

                return (empty($exclude)) ? '0' : $exclude;
            }

            return '1-6';
        }

    }
}
