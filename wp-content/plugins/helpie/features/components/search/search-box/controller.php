<?php

namespace Helpie\Features\Components\Search\Search_Box;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Search\Search_Box\Controller')) {
    class Controller
    {

        public function get_view($args)
        {
            $pauple_helpie_components = new \Helpie\Includes\Components();
            return $pauple_helpie_components->phelpie_show_search();
        }
    } // END CLASS
}