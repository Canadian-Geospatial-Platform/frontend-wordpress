<?php

namespace Helpie\Includes\Views;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Views\Hero_View')) {
    class Hero_View
    {
        public function get_view($viewProps)
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();


            $this->viewProps = $viewProps;
            $html = "<div class='helpie-element helpie_helpdesk '>";
            $mp_hero_section_order = $this->settings->main_page->mp_hero_section_order();

            // error_log('$mp_hero_section_order : ' . print_r($mp_hero_section_order, true));
            foreach ($mp_hero_section_order as $function => $show_condition) {
                if ($show_condition) {
                    $html .=  self::$function(); // fire sequencial from order

                }
            }
            $html .= "</div>";
            $html .= "<div class='clear'></div>";

            return $html;
        }

        public function kb_main_title()
        {
            return "<h1 class='header'>" . __($this->viewProps['title'], 'pauple-helpie') . "</h1>";
        }

        public function kb_main_subtitle()
        {
            $html = "<div class='item-content'>";
            $html .= "<span>" . __($this->viewProps['subtitle'], 'pauple-helpie') . "</span>";
            $html .= "</div>";

            return $html;
        }

        public function main_page_search_display()
        {
            $pauple_helpie_components = new \Helpie\Includes\Components();
            return  $pauple_helpie_components->get_helpie_search();
        }
    }
}