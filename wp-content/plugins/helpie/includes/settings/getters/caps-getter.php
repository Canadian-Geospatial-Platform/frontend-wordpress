<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Caps_Getter')) {
    class Caps_Getter
    {
        public function __construct()
        {
            $this->options = get_option('helpie-kb'); // unique id of the framework
        }

    }
}