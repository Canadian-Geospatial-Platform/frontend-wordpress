<?php

namespace Helpie\Features\Components\Page_Controls;

if (!class_exists('\Helpie\Features\Components\Page_Controls\Model')) {
    class Model extends \Helpie\Includes\Widgets\Model
    {

        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function get_settings()
        {
            $settings = array(
                'label' => $this->settings->single_page->get_voting_label(),
                'voting_template' =>  $this->settings->single_page->get_voting_template()
            );

            return $settings;
        }

        public function get_fields()
        {
            $fields = array(
                'label' => array(
                    'name' => 'label',
                    'label' => __('Label', 'pauple-helpie'),
                    'default' => __('How did you like this article?', 'pauple-helpie'),
                    'type' => 'text',
                ),
                'voting_template' => array(
                    'name' => 'voting_template',
                    'label' => __('Voting Template', 'pauple-helpie'),
                    'default' => __('emotion', 'pauple-helpie'),
                    'options' => array(
                        'classic' => __('Classic', 'pauple-helpie'),
                        'emotion' => __('Emotion', 'pauple-helpie'),
                    ),
                    'type' => 'select',
                ),
            );

            return $fields;
        }

        public function get_style_config()
        {
            $style_config = array(

                'element' => array(
                    'name' => 'helpie_element',
                    'selector' => '#helpie-page-controls',
                    'label' => __('Page Controls Container', 'elementor'),
                    'styleProps' => array('text-align', 'background', 'border', 'border_radius', 'padding', 'margin'),
                    'children' => array(
                        'label' => array(
                            'name' => 'helpie_element_label',
                            'selector' => '#helpie-page-controls .button',
                            'label' => __('Button', 'pauple-helpie'),
                            'styleProps' => array('background', 'color', 'typography', 'padding'),
                        ),
                        'icon' => array(
                            'name' => 'helpie_element_icon',
                            'selector' => '#helpie-page-controls .button i.icon',
                            'label' => __('Button Icon', 'pauple-helpie'),
                            'styleProps' => array('color',  'padding', 'margin'),
                        ),

                    ),
                ),
            );

            return $style_config;
        }
    } // END CLASS
}