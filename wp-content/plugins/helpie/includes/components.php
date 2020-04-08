<?php

namespace Helpie\Includes;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

global $pauple_helpie_options;

if (!class_exists('\Helpie\Includes\Components')) {
    class Components
    {
        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function get_helpie_search()
        {
            global $pauple_helpie_options;
            $plugin_search_option = get_option('helpdesk_search_page_id');
            $search_page_id = $plugin_search_option;
            if ($this->settings->main_page->can_show_mp_search()) {
                $search_controller = new \Helpie\Features\Components\Search\Search_Controller();
                return $search_controller->get_search_box_view();
            }
        }

        public function phelpie_show_search()
        {
            global $pauple_helpie_options;
            $plugin_search_option = get_option('helpdesk_search_page_id');
            $search_page_id = $plugin_search_option;
            if ($this->settings->main_page->can_show_mp_search()) {
                $search_controller = new \Helpie\Features\Components\Search\Search_Controller();
                return $search_controller->get_search_box_view();
            }
        }

    } // END CLASS
}