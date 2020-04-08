<?php

namespace Helpie\Includes\Settings\Partials;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Partials\Extras')) {
    class Extras
    {
        public function __construct()
        {
            $this->helpie_model = new \Helpie\Includes\Core\Core_Models\Helpie_Model();
        }

        public function get_main_page_url($margin_left = 0)
        {
            $href = $this->helpie_model->get_mainpage_permalink();

            $html = "<a style='margin-left: " . $margin_left . "em;' target ='_blank' class='ui labeled icon small button' href=" . $href . ">";
            $html .= __("Visit Main Page", HELPIE_DOMAIN);
            $html .= "<i class='external alternate icon'></i>";
            $html .= "</a>";

            return $html;
        }

        public function get_demo_section($entries)
        {
            $imports = new \Helpie\Features\Components\Imports\Controller();
            return $imports->get_demo_content_check_list_view($entries);
        }
    }
}
