<?php

namespace Helpie\Features\Components\Search\Search_Box;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Search\Search_Box\Model')) {
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
                'label' =>  array(
                    'name' => 'label',
                    'label' => __('Label', 'pauple-helpie'),
                    'default' => __('How did you like this article?', 'pauple-helpie'),
                    'type' => 'text',
                ),

            );

            return $fields;
        }

        public function get_style_config()
        {
            $style_config = array(

                'element' => array(
                    'name' => 'helpie_element',
                    'selector' => '.pauple-helpie-search-box input[type=text]',
                    'label' => __('Voting Container', 'elementor'),
                    'styleProps' => array('text-align', 'color', 'background', 'border', 'border_radius', 'padding', 'margin'),
                    'children' => array(
                        'label' => array(
                            'name' => 'helpie_element_label',
                            'selector' => '.pauple-helpie-search-box input[type=text]::placeholder',
                            'label' => __('Placeholder', 'pauple-helpie'),
                            'styleProps' => array('color', 'typography', 'text-align'),
                        ),
                        'icon' => array(
                            'name' => 'helpie_element_icon',
                            'selector' => '.pauple-helpie-search-box button[type=submit].input-group-addon i.fa',
                            'label' => __('Icon', 'pauple-helpie'),
                            'styleProps' => array('color', 'font-size', 'padding', 'margin'),
                        ),
                    ),
                ),
            );

            return $style_config;
        }
    } // END CLASS
}