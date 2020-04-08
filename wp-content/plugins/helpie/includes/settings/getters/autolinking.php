<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Autolinking')) {
    class Autolinking
    {
        public function __construct()
        {
            // $this->options = get_option('helpie_sp_options');
            $this->options = get_option('helpie-kb'); // unique id of the framework
        }

        public function get_settings()
        {

            $settings = [];

            $fields = $this->get_fields();
            foreach ($fields as $key => $field) {

                if (isset($this->options[$field['codestar_id']])) {
                    $settings[$key] = $this->options[$field['codestar_id']];
                } else {
                    // default
                    $settings[$key] = $field['default'];
                }
            }

            return $settings;
        }

        public function get_fields()
        {
            $fields = array(
                'autolinking_enable' => array(
                    'default' => false,
                    'type' => 'boolean',
                    'codestar_id' => 'autolinking_enable'
                ),
            );

            return $fields;
        }
    } // END CLASS
}