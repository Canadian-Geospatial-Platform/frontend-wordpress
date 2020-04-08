<?php

namespace Helpie\Features\Services;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

include_once HELPIE_PLUGIN_PATH . 'includes/utils/pauple-helper.php';


// All actions are registered here
// TODO: Move all actions here
if (!class_exists('\Helpie\Features\Services\Actions')) {
    class Actions
    {

        public function __construct()
        {

            if (!has_action('helpiekb_single_title_after', array($this, 'render_breadcrumbs'))) {
                add_action('helpiekb_single_title_after', array($this, 'render_breadcrumbs'), 90);
                add_action('helpiekb_single_title_after', array($this, 'render_page_controls'), 100);
                add_action('helpiekb_single_content_after', array($this, 'render_updated_by'), 90);
                add_action('helpiekb_single_content_after', array($this, 'render_pageviews'), 95);
                add_action('helpiekb_single_content_after', array($this, 'render_voting'), 100);
            }
        }

        public function render_breadcrumbs()
        {
            if (!$this->is_post_type()) {
                return;
            }

            $breadcrumbs = new \Helpie\Features\Components\Breadcrumbs\Breadcrumbs();
            $html = $breadcrumbs->get_view();
            echo $html;
        }

        public function render_page_controls()
        {
            $single_viewmodel = new \Helpie\Templates\Views\Single_View\Single_Viewmodel();

            if (!$single_viewmodel->show_frontend_editor()) {
                return;
            }

            if (!$this->is_post_type()) {
                return;
            }

            $editor = new \Helpie\Features\Components\Frontend_Editor\Editor_Controller();

            $html = '';

            $html .= "<div class='helpie-row options-row'>";
            $html .= "<div class='wrapper'>";
            $html .=  $editor->controls->get_pages_buttons('single');
            $html .=  "</div>";
            $html .= "</div>";

            echo $html;
        }



        public function render_updated_by()
        {

            $final_has_cap = $this->can_view_single();

            // Check permission
            if (!$final_has_cap || !$this->is_post_type()) {
                return;
            }
            $updated_by = new \Helpie\Features\Components\Partials\Updated_By();
            $html = $updated_by->get_view();

            echo $html;
        }

        public function render_pageviews()
        {

            $final_has_cap = $this->can_view_single();

            // Check permission
            if (!$final_has_cap || !$this->is_post_type()) {
                return;
            }
            $pageviews = new \Helpie\Features\Components\Partials\Pageviews();
            $html = $pageviews->get_view();

            echo $html;
        }


        public function render_voting()
        {

            $final_has_cap = $this->can_view_single();
            if (!$final_has_cap || !$this->is_post_type()) {
                return;
            }

            $voting = new \Helpie\Features\Components\Voting\Voting_Controller();
            $html = $voting->get_view();

            echo $html;
        }

        /* Protected Methods */
        protected function is_post_type()
        {
            $post_type = 'pauple_helpie';

            global $post;
            if ($post->post_type == $post_type) {
                return true;
            }

            return false;
        }

        protected function can_view_single()
        {
            $post_id = get_the_ID();
            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps(); // Cannot move to construct
            $final_has_cap = $dynamic_caps->get_final_article_has_cap($post_id, 'can_view');

            return $final_has_cap;
        }
    } // END CLASS
}