<?php

namespace Helpie\Features\Components\Partials;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('Helpie\Features\Components\Partials\Helpie_Top_Area')) {
    class Helpie_Top_Area
    {

        private $template_name;
        private $components;

        public function __construct()
        {            
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function render_search_area()
        {
            $helpie_components_options = get_option('helpie_components_options');
            $search_display = '';

            if (isset($helpie_components_options) && $helpie_components_options != null) {
                if (($this->template_name == 'category_template' || $this->template_name == 'search_template')) {
                    $search_display = $this->settings->category_page->show_search();
                } elseif ($this->template_name == 'single_template') {
                    $search_display = $this->settings->single_page->show_search();
                }

                if ($search_display == true) {
                    echo "<div class='pauple-helpie-search-row-type2'>";

                    $search_controller = new \Helpie\Features\Components\Search\Search_Controller();
                    echo $search_controller->get_search_box_view();

                    echo '</div>';
                }
            }
        }

        public function render_breadcrumbs()
        {
            $term = get_queried_object();
            if ($this->settings->components->can_show_breadcrumbs()) {
                $breadcrumbs = new \Helpie\Features\Components\Breadcrumbs\Breadcrumbs();
                echo $breadcrumbs->get_view($term->term_id);
            }
        }

        public function render($template_name)
        {
            $this->template_name = $template_name;
            if ($template_name != 'archive_template') {
                $this->render_search_area();
                $this->render_breadcrumbs();
            }            
        }
    } // END CLASS
}