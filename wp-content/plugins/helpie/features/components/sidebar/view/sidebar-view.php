<?php

namespace Helpie\Features\Components\Sidebar\View;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Sidebar\View\Sidebar_View'))
{
    class Sidebar_View
    {
        public function __construct()
        {
            $this->toc_controller = new \Helpie\Features\Components\Toc\Toc_Controller();
        }

        public function get_view( $itemsProps )
        {
            $items = $itemsProps;

            $html  = '';
            $html .= $this->get_mobile_sidebar_button();

            $html .= "<div class='pauple-helpie-single-sidebar ". $items['wrapper_classes'] ."'>";

            $html .= "<div class='helpie-sidebar-fixer'>";
            // $html .= "<div class='page-scroll-nav'>";

            if ($items['sidebar_type'] == 'helpie_sidebar') {
                $html .= $this->get_helpie_toc();
            } else {
                $html .= $this->get_other_wp_sidebar( $items['sidebar_type'] );
            }

            // $html .= "<div class='clear'></div>";
            // $html .= "</div>";
            $html .= "<div class='clear'></div>";
            $html .= "</div>";

            $html .= "</div>";

            return $html;
        }

        protected function get_mobile_sidebar_button()
        {
            $button  = "<div class='mobile-toc-button'>";
            $button .= "<i class='large bars icon'> </i>";
            $button .= "</div>";

            return $button;
        }

        protected function get_helpie_toc()
        {
            $toc_view = $this->toc_controller->get_view();

            return $toc_view;
        }

        protected function get_other_wp_sidebar( $template )
        {
            $html = '';
            ob_start();
            dynamic_sidebar( $template );
            $sidebar = ob_get_contents();
            ob_end_clean();
            $html .= $sidebar;

            return $html;
        }
    }
}
