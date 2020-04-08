<?php

namespace Helpie\Features\Components\Hero;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Hero\Hero_Area_Model')) {
    class Hero_Area_Model
    {
        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->publishing_service = new \Helpie\Features\Services\Publishing\Publishing();
        }

        public function get_viewProps($args = array())
        {

            // First Layer: Fill with defaults
            $viewProps = $this->get_default_args();

            if (isset($args) && is_array($args)) {
                $viewProps = array_merge($viewProps, $args);
            }

            return $viewProps;
        }

        public function get_hero_settings()
        {

            $mp_hero_section_order = $this->settings->main_page->mp_hero_section_order();
            $view_settings = array(
                'title' => $mp_hero_section_order['kb_main_title'],
                'subtitle' => $mp_hero_section_order['kb_main_subtitle'],
                // 'show_subtitle' => $this->settings->core->get_show_subtitle(),
            );

            return $view_settings;
        }

        public function show_frontend_editor()
        {
            // The General show_frontend_editor rules
            if ($this->publishing_service->show_frontend_editor() != true) {
                return false;
            }

            return true;
        }

        public function get_style_config()
        {
            $style_config = array(

                'element' => array(
                    'name' => 'helpie_element',
                    'selector' => '.helpie_kb_hero .helpie-element',
                    'label' => __('Single Item', 'elementor'),
                    'styleProps' => array('text-align', 'background', 'border', 'border_radius', 'padding', 'margin'),
                    'children' => array(
                        'title' => array(
                            'name' => 'helpie_element_title',
                            'selector' => '.helpie_kb_hero .helpie-element > .header',
                            'label' => __('Single Item Title', 'pauple-helpie'),
                            'styleProps' => array('color', 'typography', 'text-align', 'border'),
                        ),
                        'content' => array(
                            'name' => 'helpie_element_content',
                            'selector' => '.helpie_kb_hero .helpie-element > .item-content',
                            'label' => __('Single Item Content', 'pauple-helpie'),
                            'styleProps' => array('color', 'typography', 'text-align', 'border'),
                        ),

                        'search' => array(
                            'name' => 'helpie_kb_hero_search',
                            'selector' => '.helpie_kb_hero .helpie-element .pauple-helpie-search-box input[type=text]',
                            'label' => __('Search', 'pauple-helpie'),
                            'styleProps' => array('background', 'color', 'typography', 'text-align', 'border', 'border_radius', 'box_shadow', 'margin', 'padding'),
                        ),
                    ),
                ),
            );

            return $style_config;
        }

        public function get_default_args()
        {
            $args = $this->get_manual_default_args();

            // Second Layer: Helpie Settings Values
            $view_settings = $this->get_hero_settings();

            $args = array_merge($args, $view_settings);

            return $args;
        }

        public function get_manual_default_args()
        {
            $args = array();

            // Get Default Values from GET - FIELDS
            $fields = $this->get_fields();
            foreach ($fields as $key => $field) {
                $args[$key] = $field['default'];
            }

            return $args;
        }

        public function get_fields()
        {
            $fields = array(
                'title' => $this->get_title_field(),
                'subtitle' => $this->get_subtitle_field(),
                'show_subtitle' => $this->get_show_subtitle_field(),
            );

            return $fields;
        }

        // FIELDS
        protected function get_title_field()
        {
            return array(
                'name' => 'title',
                'label' => __('Title', 'pauple-helpie'),
                'default' => __('Help Center', 'pauple-helpie'),
                'type' => 'text',
            );
        }

        protected function get_subtitle_field()
        {
            return array(
                'name' => 'subtitle',
                'label' => __('Sub Title', 'pauple-helpie'),
                'default' => __('We are here to help.', 'pauple-helpie'),
                'type' => 'text',
            );
        }

        protected function get_show_subtitle_field()
        {
            return array(
                'name' => 'show_subtitle',
                'label' => __('Show Sub-Title', 'pauple-helpie'),
                'default' => __('true', 'pauple-helpie'),
                'options' => array(
                    'true' => __('True', 'pauple-helpie'),
                    'false' => __('False', 'pauple-helpie'),
                ),
                'type' => 'select',
            );
        }
    } // END CLASS
}