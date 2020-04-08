<?php

namespace Helpie\Features\Components\Sidebar;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Sidebar\Sidebar_Controller'))
{
    class Sidebar_Controller
    {
        public function __construct()
        {
            $this->sidebar_model = new \Helpie\Features\Components\Sidebar\Model\Sidebar_Model();
            $this->sidebar_view = new \Helpie\Features\Components\Sidebar\View\Sidebar_View();
        }

        public function get_sidebar( $args )
        {           
            $viewProps = $this->sidebar_model->get_viewProps( $args );            
            $view = $this->sidebar_view->get_view( $viewProps['items'] );

            return $view;
        }        
    }
}