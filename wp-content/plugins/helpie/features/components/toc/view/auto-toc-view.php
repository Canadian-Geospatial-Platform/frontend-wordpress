<?php

namespace Helpie\Features\Components\Toc\View;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Toc\View\Auto_Toc_View')) {
    class Auto_Toc_View
    {
        public function get($viewProps)
        {
            $itemProps = $viewProps['items'];
            $collectionProps = $viewProps['collection'];

            if ($collectionProps['toc_type'] == 'page-scroll-only')
            {
                return $this->in_pageAutoTOC($itemProps, $collectionProps);
            }

            return $this->get_html($itemProps, $collectionProps);
        }

        public function in_pageAutoTOC($props, $collectionProps)
        {
            $html  = $this->get_header($collectionProps);
            $html .= $this->get_html($props, $collectionProps);
            $html .= $this->get_footer();

            return $html;
        }

        protected function get_html($props, $collectionProps)
        {
            if(empty($props)){
                return '<div class="no-heads">'.__('No headers found ...', 'pauple-helpie').'</div>';
            }

            $html = '';
            foreach ($props as $prop)
            {
                $hash = 'href = "#'.$prop['head_id'].'"';
                $serial = implode('.', explode('-', $prop['serial']));
                $class = $this->get_scrollable_class($collectionProps);

                $bullet = '';
                if ($collectionProps['show_numeric_bullet'] == true)
                {
                    $bullet = '<span class="helpieBullet">'.$serial.'</span>'.'. ';
                }

                $html .='<a '.$class.$hash.'>'.$bullet.__($prop['text'], 'pauple-helpie').'</a>';

            }

            return $html;
        }

        protected function get_header($collectionProps)
        {
            $html  = '<div class="helpie-toc">';
            $html .= '<div class="ui top attached large label auto-toc-title">';
            $html .= __($collectionProps['auto_toc_title'], 'pauple-helpie');
            $html .= '</div>';

            $html .= ' <div class="ui middle aligned selection list"> ';

            return $html;
        }

        protected function get_footer()
        {
            $html  = '</div>';
            $html .= '</div>';

            return $html;
        }

        protected function get_scrollable_class($collectionProps)
        {
            $hash = ($collectionProps['show_section_page_url'] == true) ? 'hash' : '';
            $smooth_scroll = ($collectionProps['smooth_scroll'] == true) ? 'smooth-scroll' : '';

            $classes = $smooth_scroll.' '.$hash;
            $class = 'class ="item '.$classes.'"';

            return $class;
        }
    }
}
