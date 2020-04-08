<?php

namespace Helpie\Includes\Core;

if (!class_exists('\Helpie\Includes\Core\Model')) {
    class Model
    {
        protected $helper;

        public function __construct()
        {
            $this->helper = new \Helpie\Includes\Utils\Pauple_Helper();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }
    } // End class
}
