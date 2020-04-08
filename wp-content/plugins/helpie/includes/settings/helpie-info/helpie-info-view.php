<?php

namespace Helpie\Includes\Settings\Helpie_Info;

if (!defined('ABSPATH')) {
    exit;
}
// Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Helpie_Info\Helpie_Info_View')) {

    class Helpie_Info_View
    {

        public function __construct()
        {
            $this->envato_view = new \Helpie\Includes\Core\Envato\Helpie_Envato_View();
        }

        public function render()
        {
            echo $this->get_view();
        }

        public function get_view()
        {
            echo $this->envato_view->get_view();
        }

    }

}