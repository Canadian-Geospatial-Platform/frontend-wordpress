<?php

namespace Helpie\Features\Components\Articles;

if (!class_exists('\Helpie\Features\Components\Articles\Article_Listing')) {
    class Article_Listing
    {
        public function __construct()
        {
            // Models
            $this->article_listing_model = new \Helpie\Features\Components\Articles\Article_Listing_Model();

            // Views
            $this->article_listing_view = new \Helpie\Features\Components\Articles\Article_Listing_View();
        }

        // Check with User Access and Password Protected Modules
        public function get_view($args)
        {

            $viewProps = $this->article_listing_model->get_viewProps($args);            

            $html = $this->article_listing_view->get($viewProps);

            return $html;
        }
    }
}
