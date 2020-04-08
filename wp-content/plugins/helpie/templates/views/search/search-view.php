<?php
namespace Helpie\Templates\Views\Search;


if (!class_exists('\Helpie\Templates\Views\Search\Search_View')) {
    class Search_View
    {
        public function __construct()
        {
            $this->search_controller = new \Helpie\Features\Components\Search\Search_Controller();
        }

        /* Final View */
        public function render()
        {
            echo "<div class='helpie-single-page-module no-scroll-module'>";

            // include_once HELPIE_PLUGIN_PATH.'features/partials/helpie-top-area.php';
            $top_area = new \Helpie\Features\Components\Partials\Helpie_Top_Area();
            $top_area->render('search_template');

            $this->get_primary_view();
            echo $this->get_closing_html();
        }

        protected function get_primary_view()
        {
            // Fix for Divi Theme Header not shrinking
            $id = 'main-content';

            echo "<div id='" . $id . "' class='helpie-primary-view'>";
            echo "<div class='wrapper'>";

            $page_id = get_option('helpdesk_search_page_id');
            if (isset($page_id)) {
                $search_page = get_post($page_id);
                $content = $search_page->post_content;
                echo apply_filters('the_content', $content);
            } else {
                echo "Search Page not found";
            }
        }



        protected function get_closing_html()
        {
            $html = '';
            $html .= "</div>";
            $html .= "</main><!-- .site-main -->";
            $html .= "</div><!-- .content-area -->";
            $html .= "</div></div> <!-- .primary-view -->";
            $html .= "<div style='clear:both;'></div>";
            $html .= "</div> <!-- .helpie-single-page-module -->";
            return $html;
        }
    } // END CLASS
}