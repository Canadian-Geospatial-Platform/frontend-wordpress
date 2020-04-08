<?php

namespace Widgetry;

if (!class_exists('\Widgetry\Model')) {
    class Model
    {
        protected $helper;

        public function __construct()
        {
            $this->helper = new \Helpie\Includes\Utils\Pauple_Helper();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
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

        public function get_default_args()
        {
            $args = $this->get_manual_default_args();

            // Second Layer: Helpie Settings Values
            $view_settings = $this->get_settings();

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
    } // End class
}