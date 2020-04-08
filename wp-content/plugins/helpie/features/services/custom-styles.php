<?php

/**
 * Implements Custom Styles from Settings to the Frontend
 *
 * @package    helpie-kb
 * @subpackage services
 * @author     essekia
 * @version    1.9.1
 * ...
 */

namespace Helpie\Features\Services;

use PhpParser\Builder\Property;

if (!class_exists('\Helpie\Features\Services\Custom_Styles')) {
    class Custom_Styles
    {
        public function __construct()
        {
            $this->options = get_option('helpie-kb');
            $this->design = isset($this->options['design']) ? $this->options['design'] : [];
            // $this->hook();
            $this->style = '';
            $this->unit_based_props = ['font-size', 'line-height', 'letter-spacing'];
        }

        public function hook()
        {
            add_action('the_content', [$this, 'load_style']);
        }

        public function load_style($content)
        {

            $helper = new \Helpie\Features\Services\Access_Control\Helper();

            if ($helper->page_has_helpie($content)) {
                return $content . $this->get_style();
            }
        }

        public function get_style_only()
        {
            $this->style .= $this->get_welcome_area_style();
            $this->style .= $this->get_single_page_style();
            $this->style .= $this->get_components_style();
            $this->style .= $this->get_layout_styles();

            // error_log('$this->style : ' . $this->style);
            return $this->style;
        }

        public function get_layout_styles()
        {
            // error_log('get_layout_styles ');
            // error_log('$this->options : ' . print_r($this->options, true));

            $design = $this->design;
            $style_content = '';

            if (!isset($design) || empty($design)) {
                return $style_content;
            }

            if (isset($design['helpiekb-wrapper-width'])) {
                $value = $design['helpiekb-wrapper-width']['width'] . $design['helpiekb-wrapper-width']['unit'];
                $style_content .= '#helpiekb-main-wrapper { width:  ' . $value . ';} ';
            }

            $style_content .= $this->get_elements_typography($design);
            return $style_content;
        }





        public function get_style()
        {

            $final_style = "<style>" . $this->get_style_only() . "</style>";

            return $final_style;
        }

        public function get_components_style()
        {
            $style_content = '';
            $border_size = '0';
            if (isset($this->options['helpie_show_search_border'])) {
                $show_border = $this->options['helpie_show_search_border'];

                if ($show_border) {
                    $border_size = '3px';
                } else {
                    $border_size = '0';
                }
            }

            if (isset($this->options['helpie_search_border_color'])) {
                $value = $this->options['helpie_search_border_color'];
                $style_content .= " .pauple-helpie-search-box input[type=text]{ border: solid " . $border_size . " " . $value . "}";
            }

            if (isset($this->options['helpie_search_border_style'])) {
                $value = $this->options['helpie_search_border_style'];

                if ($value == 'rounded') {
                    $implied_value = '21px';
                } elseif ($value == 'semi-rounded') {
                    $implied_value = '8px';
                } else {
                    $implied_value = 0;
                }
                $style_content .= " .pauple-helpie-search-box input[type=text]{ border-radius: " . $implied_value . "}";
            }

            // Categories Listing Icon Color
            if (isset($this->design['helpie_brand_primary_color'])) {
                $style_content .= " .helpie-category-listing .category-list .column .helpie-element i.fa { color:  " . $this->design['helpie_brand_primary_color'] . "; } ";
            }

            // Translateble string placeholder for frontend editor

            $style_content .= " .helpie-article-editor #title-tinymce:empty:before{content: '" . __("Title here...", "pauple-helpie") . "'}";
            $style_content .= " .helpie-article-editor #content-tinymce:empty:before{content: '" . __("Content here...", "pauple-helpie") . "'}";

            return $style_content;
        }




        public function get_single_page_style()
        {
            $style_content = '';
            if (isset($this->options['helpie_post_title_color'])) {
                $value = $this->options['helpie_post_title_color'];
                // $style_content .= $value;
                $style_content .= " .helpie-single-page-module.single-page h1{ color: " . $value . " !important}";
            }

            /* Margin Top */

            if (isset($this->design['helpie_margin_top_desktop'])) {
                $value = $this->design['helpie_margin_top_desktop'];
                $style_content .= " .helpie-single-page-module{ margin-top: " . $value . "px}";
            }

            if (isset($this->design['helpie_margin_top_tablet'])) {
                $value = $this->design['helpie_margin_top_tablet'];
                $style_content .= "@media (max-width:1024px) {";
                $style_content .= " .helpie-single-page-module{ margin-top: " . $value . "px}";
                $style_content .= "}";
            }

            if (isset($this->design['helpie_margin_top_mobile'])) {
                $value = $this->design['helpie_margin_top_mobile'];
                $style_content .= "@media (max-width:479px) {";
                $style_content .= " .helpie-single-page-module{ margin-top: " . $value . "px}";
                $style_content .= "}";
            }

            return $style_content;
        }

        /* TODO: Migrate to Codestar's output */
        public function get_welcome_area_style()
        {
            $style = '';
            $background_type = 'single-color';
            $selector = ' ' . '.helpie_helpdesk, .pauple-helpie-search-row-type2' . ' ';

            if (isset($this->design['helpie_wa_background_type'])) {
                $background_type = $this->design['helpie_wa_background_type'];
            }

            if ($background_type == 'single-color') {
                $style .= $this->get_welcome_area_single_color_bg($selector);
            } elseif ($background_type == 'color-gradient') {
                $style .= $this->get_welcome_area_color_gradient_bg($selector);
            } elseif ($background_type == 'background-image') {
                $style .= $this->get_welcome_area_image_bg($selector);
            } elseif ($background_type == 'gradient-plus-background-image') {
                $style .= $this->get_welcome_area_gradient_plus_image_bg($selector);
            }

            if (isset($this->design['helpie_brand_title_color'])) {
                $value = $this->design['helpie_brand_title_color'];
                $style .= " .helpie_helpdesk h1.header{ color: " . $value . " !important}";
            }
            if (isset($this->design['helpie_wa_text_color'])) {
                $value = $this->design['helpie_wa_text_color'];
                $style .= " .helpie_helpdesk > .item-content{ color: " . $value . "}";
            }

            if (isset($this->design['helpiekb_wa_padding'])) {
                $value = $this->design['helpiekb_wa_padding'];
                // $style .= " .helpie_helpdesk > .item-content{ color: " . $value . "}";
                $selector = ' .helpie_helpdesk';
                $style .= $this->get_spacing_css($selector, $value, 'padding');
            }

            return $style;
        }

        private function get_spacing_css($selector, $options, $property = 'padding')
        {
            // error_log('get_spacing_css : ');
            // error_log('$options : ' . print_r($options, true));

            $default = '0px';

            $unit = $options['unit'];

            $css = $selector . " { ";
            $css .= $property . " : ";
            $css .= (isset($options['top']) & !empty($options['top'])) ? $options['top'] . $unit . " " : $default;
            $css .= (isset($options['right']) & !empty($options['right'])) ? $options['right'] . $unit . " " : $default;
            $css .= (isset($options['bottom']) & !empty($options['bottom'])) ? $options['bottom'] . $unit . " " : $default;
            $css .= (isset($options['left']) & !empty($options['left'])) ? $options['left'] . $unit : $default;
            $css .= " !important; } ";

            return $css;
        }

        // private function does_value_exist($array, $key)
        // {
        //     if ((isset($array[$key]) & !empty($array[$key]))) {
        //         return true;
        //     }

        //     return false;
        // }


        public function get_welcome_area_single_color_bg($selector)
        {
            $style = '';

            if (isset($this->design['helpie_brand_primary_color'])) {
                $value = $this->design['helpie_brand_primary_color'];
                $styleProps = array(
                    'background' => $value,
                );

                $style .= $this->get_style_string($selector, $styleProps);
            }

            return $style;
        }

        public function get_welcome_area_color_gradient_bg($selector)
        {

            $gradient1 = (isset($this->design['helpie_wa_gradient1'])) ? $this->design['helpie_wa_gradient1'] : '#F0C27B';
            $gradient2 = (isset($this->design['helpie_wa_gradient2'])) ? $this->design['helpie_wa_gradient2'] : '#4B1248';

            // Don't remove space in keys or else it will be duplicate keys
            $styleProps = array(
                'background' => $gradient1, /* fallback for old browsers */
                ' background' => "-webkit-linear-gradient(to right, " . $gradient2 . ", " . $gradient1 . ")", /* Chrome 10-25, Safari 5.1-6 */
                ' background ' => "linear-gradient(to right, " . $gradient2 . ", " . $gradient1 . ")", /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            );

            $style = $this->get_style_string($selector, $styleProps);
            return $style;
        }

        public function get_welcome_area_image_bg($selector)
        {
            $styleProps = array();

            if (isset($this->design['helpie_wa_image'])) {
                // $helpie_wa_image = $this->design['helpie_wa_image']['url'];
                // $src_url = wp_get_attachment_url($helpie_wa_image);

                $src_url = $this->design['helpie_wa_image']['url'];

                $styleProps['background-image'] = "url('" . $src_url . "')";
                $styleProps['background-size'] = "cover";
            }

            $style = $this->get_style_string($selector, $styleProps);
            return $style;
        }

        public function get_welcome_area_gradient_plus_image_bg($selector)
        {
            $styleProps = array();

            if (isset($this->design['helpie_wa_image'])) {
                $gradient1 = (isset($this->design['helpie_wa_gradient1'])) ? $this->design['helpie_wa_gradient1'] : '#F0C27B';
                $gradient2 = (isset($this->design['helpie_wa_gradient2'])) ? $this->design['helpie_wa_gradient2'] : '#4B1248';

                $helpie_wa_illustration = $this->design['helpie_wa_illustration'];

                $src_url = HELPIE_PLUGIN_URL . 'includes/asset-files/images/vector-illustrations/' . $helpie_wa_illustration . '.png';

                $styleProps['background-image'] = "url('" . $src_url . "'),  linear-gradient(-150deg, " . $gradient1 . " 0%, " . $gradient2 . " 97%)";
                $styleProps['background-size'] = "cover";
            }

            $style = $this->get_style_string($selector, $styleProps);
            return $style;
        }

        /* Private Methods */

        private function get_elements_typography($design)
        {
            $css = '';

            if (!isset($design) || empty($design)) {
                return $css;
            }


            foreach ($design as $key => $option) {
                if (strpos($key, 'typography') == true) {
                    $tag = str_replace('-typography', '', $key);

                    $selector = '.helpie-single-page-module ' . $tag;

                    $css .= $this->get_single_typography_css($selector, $option);
                }
            }

            return $css;
        }

        private function get_single_typography_css($selector, $option)
        {
            $css = $selector . ' { ';

            foreach ($option as $property => $value) {

                if (in_array($property,  $this->unit_based_props)) {
                    $value = $value . $option['unit'];
                }
                $css .= $property . ' : ' . $value . ' !important;';
            }
            $css .= ' } ';

            return $css;
        }

        private function get_style_string($selector, $styleProps)
        {
            $style = $selector . "{";

            foreach ($styleProps as $key => $value) {
                $style .= $key . " : " . $value . ';';
            }

            $style .= "}";
            return $style;
        }
    } // END CLASS

}