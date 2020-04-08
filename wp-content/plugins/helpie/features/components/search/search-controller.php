<?php

namespace Helpie\Features\Components\Search;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Search\Search_Controller')) {
    class Search_Controller
    {
        public function __construct()
        {
            $this->search_model = new \Helpie\Features\Components\Search\Models\Search_Model();

            // Views
            $this->search_list_view = '';
            $this->pagination_view = '';

            //scripts
            $this->scripts_handler = new \Helpie\Includes\Core\Scripts_Handler();
        }
        public function get_view($args)
        {
            $viewProps = $this->search_model->get_viewProps($args);
            $pagination_view = new \Helpie\Features\Components\Search\Views\Pagination_View();
            $this->search_view = new \Helpie\Features\Components\Search\Views\Search_Results_View($pagination_view);

            $html = $this->search_view->get($viewProps);

            return $html;
        }

        public function get_search_box_view()
        {
            $this->scripts_handler->enqueue_semantic_scripts();
            $this->scripts_handler->enqueue_kb_frontend_scripts();
            $search_box_view = new \Helpie\Features\Components\Search\Views\Search_Box_View();
            return $search_box_view->get();
        }
    } // Class Ends
}