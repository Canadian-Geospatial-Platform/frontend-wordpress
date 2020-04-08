<?php

namespace Helpie\Features\Components\Imports;

if (!class_exists('\Helpie\Features\Components\Imports\Controller')) {
    class Controller
    {
        public function __construct()
        {
            $this->model = new \Helpie\Features\Components\Imports\Model();
            $this->view = new \Helpie\Features\Components\Imports\View();
        }

        public function run_import($args)
        {
            $details = $this->model->import($args);
            return $details;
        }

        // On Ajax for to Set demo categories of dom window js object
        public function get_demos_categories($args)
        {
            $demo_items = $this->model->get_demos_categories($args);
            return $demo_items;
        }

        // On Settings Page Delete Demo entries
        public function delete_demo_entries($args)
        {
            return $this->model->delete_entries($args);
        }

        // On Settings Page Load check list Entries view
        public function get_demo_content_check_list_view($args)
        {
            return $this->view->get_demo_content_view($args);
        }
    }
}
