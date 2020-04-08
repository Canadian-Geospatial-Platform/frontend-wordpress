<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Password_Protection')) {
    class Password_Protection
    {
        public function __construct()
        {
            $this->options = get_option('helpie-kb'); // unique id of the framework
        }

        public function get_passwords()
        {
            $passwords = isset($this->options['helpie_password_options']) ? $this->options['helpie_password_options'] : [];
            return $passwords;
        }

        public function get_settings()
        {
            $settings = [
                'remember_days' => 30, // default days
            ];

            if (isset($this->options['helpie_password_remember_days'])) {
                $settings['remember_days'] = $this->options['helpie_password_remember_days'];
            }

            return $settings;
        }
    } // END CLASS
}
