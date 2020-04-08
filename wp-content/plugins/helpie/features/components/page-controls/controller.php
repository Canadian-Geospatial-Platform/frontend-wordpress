<?php

namespace Helpie\Features\Components\Page_Controls;

if (!class_exists('\Helpie\Features\Components\Page_Controls\Controller')) {
    class Controller
    {
        public function __construct()
        {
            $this->fields_builder = new \Helpie\Includes\Utils\Builders\Fields_Builder();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->helper = new \Helpie\Features\Services\Access_Control\Helper();
            $this->model = new \Helpie\Features\Components\Page_Controls\Model();
            $this->view = new \Helpie\Features\Components\Page_Controls\View();

            // Single Cpt Name default to "Article"
            $this->article = $this->settings->single_page->get_single_cpt_name();
        }


        public function get_view($args = array())
        {
            $viewProps = $this->model->get_viewProps($args);

            // error_log('$viewProps : ' . print_r($viewProps, true));
            return $this->get_pages_buttons();
        }


        public function get_pages_buttons($page = 'other')
        {

            $props = [
                'is_single' =>   $this->helper->is_single_article(),
                'capabilities' => $this->get_capabilities(),
                'page' => $page,
                'article' => $this->article
            ];


            return $this->view->get_view($props);
        }

        public function get_capabilities()
        {
            $current_post_id = get_the_ID();

            $capabilities = [
                'show_new_button' =>  $this->show_add_new_article_button($current_post_id),
                'show_delete_button' =>  $this->get_delete_button($current_post_id)
            ];

            $capabilities['show_dropdown'] = $capabilities['show_new_button'] || $capabilities['show_delete_button'];

            return $capabilities;
        }


        public function show_add_new_article_button($post_id)
        {
            if ($this->settings->core->is_frontend_editing_enabled() != true) {
                return false;
            }

            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();
            $can_edit = $dynamic_caps->get_final_article_has_cap($post_id, 'can_edit');
            $can_publish = $dynamic_caps->get_final_article_has_cap($post_id, 'can_publish');
            $can_approve = $dynamic_caps->get_final_article_has_cap($post_id, 'can_approve');

            if ($can_edit || $can_publish || $can_approve) {
                return true;
            }

            return false;
        }

        public function get_delete_button($article_id)
        {
            $publishing_service = new \Helpie\Features\Services\Publishing\Publishing();
            $is_admin = current_user_can('administrator');
            $capability = $publishing_service->get_current_user_publishing_capability($article_id);
            if ($is_admin || $capability['can_approve']) {

                $popup = new \Helpie\Features\Components\Frontend_Editor\Views\Popup();
                $popup->render_delete_popup();
                return true;
            }

            return false;
        }
    } // END CLASS
}