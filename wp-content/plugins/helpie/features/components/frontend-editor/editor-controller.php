<?php

namespace Helpie\Features\Components\Frontend_Editor;

// include_once HELPIE_PLUGIN_PATH . 'includes/utils/test-helpers.php';

if (!class_exists('\Helpie\Features\Components\Frontend_Editor\Editor_Controller')) {
    class Editor_Controller
    {
        public $controls;

        public function __construct()
        {
            $this->model = new \Helpie\Features\Components\Frontend_Editor\Editor_Model();
            $this->view = new \Helpie\Features\Components\Frontend_Editor\Editor_View($this->model);
            $this->controls = new \Helpie\Features\Components\Frontend_Editor\Views\Controls();
        }

        public function get_view($args = array())
        {
            // Required
            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();
            $can_user_modify_any_topic = $dynamic_caps->can_user_modify_any_topic();

            $viewProps = $this->model->get_viewProps($args);
            $collectionProps = $viewProps['collection'];

            $html = "<div class='helpie-edit-page-container'>";

            // if ($this->can_access_editor($collectionProps)) {
            //     $html .= $this->view->get($viewProps);
            // } else {
            //     $html .= __("You do not have access to edit this article", 'pauple-helpie');
            // }

            if ($can_user_modify_any_topic) {
                $html .= $this->view->get($viewProps);
            } else {
                $html .= __("You do not have access to edit this article", 'pauple-helpie');
            }

            $html .= "</div>";

            return $html;
        }

        /* PROTECTED */

        protected function can_access_editor($collectionProps)
        {

            $can_edit = ($collectionProps['can_edit'] == true);
            $can_publish = ($collectionProps['can_publish'] == true);
            $can_approve = ($collectionProps['can_approve'] == true);

            if ($can_edit || $can_publish || $can_approve) {
                return true;
            }

            return false;
        }
    } // END CLASS
}
