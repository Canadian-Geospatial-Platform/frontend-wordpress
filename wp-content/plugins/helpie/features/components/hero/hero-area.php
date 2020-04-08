<?php

namespace Helpie\Features\Components\Hero;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Hero\Hero_Area')) {
    class Hero_Area
    {
        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();

            // Views
            $this->hero_view = new \Helpie\Includes\Views\Hero_View();
            $this->editor = new \Helpie\Features\Components\Frontend_Editor\Editor_Controller();
            // Models
            $this->hero_model = new \Helpie\Features\Components\Hero\Hero_Area_Model();
            $this->scripts_handler = new \Helpie\Includes\Core\Scripts_Handler();
        }
        public function get_view($args = null)
        {
            $this->scripts_handler->enqueue_semantic_scripts();
            $this->scripts_handler->enqueue_kb_frontend_scripts();

            $heroViewProps = $this->hero_model->get_viewProps($args);

            $html = "";
            $html .= "<div class='helpie_kb_hero'>";

            if ($this->hero_model->show_frontend_editor()) {
                $html .= "<div class='helpie-row options-row'>";
                $html .= $this->editor->controls->get_pages_buttons();
                $html .= "</div>";
            }

            $html .= $this->hero_view->get_view($heroViewProps);

            $html .= "</div>";

            return $html;
        }

        protected function get_frontend_editor_options()
        {
            $html = "<div class='helpie-editor-fields'>";
            $html .= "<button class='add-new-article'><i class='fa fa-plus-circle' aria-hidden='true'></i>Add Article</button>";
            $html .= "</div>";

            return $html;
        }
    }
}