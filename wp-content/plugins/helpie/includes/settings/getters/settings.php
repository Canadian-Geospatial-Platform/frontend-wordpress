<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Settings')) {
    class Settings
    {
        public function __construct()
        {
            $this->core = new \Helpie\Includes\Settings\Getters\Core_Getter();
            $this->styles = new \Helpie\Includes\Settings\Getters\Style_Getter();
            $this->components = new \Helpie\Includes\Settings\Getters\Components();
            $this->main_page = new \Helpie\Includes\Settings\Getters\Mp_Settings();
            $this->single_page = new \Helpie\Includes\Settings\Getters\Sp_Getter();
            $this->category_page = new \Helpie\Includes\Settings\Getters\Cp_Getter();
            $this->search = new \Helpie\Includes\Settings\Getters\Search();
            $this->autolinking = new \Helpie\Includes\Settings\Getters\Autolinking();
            $this->password_protection = new \Helpie\Includes\Settings\Getters\Password_Protection();

            $options = get_option('helpie-kb'); // unique id of the framework
            // error_log('$options : ' . print_r($options, true));

        }
    }
}