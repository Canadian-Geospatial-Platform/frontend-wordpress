<?php

namespace Helpie\Templates\Views\Main_Page;

if (!class_exists('Helpie\Templates\Views\Main_Page\Main_Page_Builder')) {
    class Main_Page_Builder
    {

        private $sidebar_template_style;
        private $template_name;

        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();

            // Set Props
            $this->template_name = 'mainpage_template';
            $this->sidebar_template_style = 'full-width';
            $this->sidebar_template_style = $this->settings->main_page->get_sidebar_template();
        }

        public function get_html()
        {
            // Fix for Divi Theme Header not shrinking
            $id = 'main-content';

            $html = "<div id='" . $id . "' class='helpie-primary-view " . $this->sidebar_template_style . "'><div id='helpiekb-main-wrapper' class='wrapper'>";
            if ($this->sidebar_template_style == 'left-sidebar') {
                $html .= $this->get_sidebar('left');
                $html .= $this->get_content();
            } elseif ($this->sidebar_template_style == 'right-sidebar') {
                $html .= $this->get_content();
                $html .= $this->get_sidebar('right');
            } elseif ($this->sidebar_template_style == 'both-side-sidebars') {
                $html .= $this->get_sidebar('left', 'both');
                $html .= $this->get_content();
                $html .= $this->get_sidebar('right', 'both');
            } elseif ($this->sidebar_template_style == 'full-width' || $this->sidebar_template_style == 'boxed-width') {
                $html .= $this->get_content();
            }

            $pp_controller = new \Helpie\Features\Services\Password_Protect\Controller();
            $html .= "<br>" . $pp_controller->get_Modal();

            $html .= "<div class='clear'></div>";
            $html .= "</div></div>";

            return $html;
        }

        public function render()
        {
            echo $this->get_html();
        }

        public function get_sidebar($position, $sidebar_count = 'single')
        {
            $args = array(
                'position' => $position,
                'template' => $this->template_name,
                'count' => $sidebar_count,
            );

            $sidebar_controller = new \Helpie\Features\Components\Sidebar\Sidebar_Controller();
            $sidebar = $sidebar_controller->get_sidebar($args);

            return $sidebar;
        }

        public function get_content()
        {
            return $this->get_have_access_content();
        }

        /* PROTECTED METHODS */

        protected function get_welcome_area()
        {
            $this->hero_area = new \Helpie\Features\Components\Hero\Hero_Area();
            $html = $this->hero_area->get_view();

            return $html;
        }

        protected function get_have_access_content()
        {
            $html = "<div class='content-area " . $this->sidebar_template_style . "'>";

            $html .= $this->get_welcome_area();

            $html .= "<div class='helpie-main-section'>";
            $html .= "<div class='wrapper'>";
            $html .= $this->get_mp_components();
            $html .= "</div>";
            $html .= "</div>";

            $html .= "</div>";

            return $html;
        }

        protected function get_mp_components()
        {
            $html = "";
            $mp_components_order = $this->settings->main_page->mp_components_order();

            // error_log('$mp_components_order : ' . print_r($mp_components_order, true));
            foreach ($mp_components_order as $function => $show_condition) {
                if ($show_condition) {
                    $html .= self::$function(); // fire sequencial from order

                }
            }

            return $html;
        }
        protected function get_no_access_content()
        {
            $html = "<div class='content-area " . $this->sidebar_template_style . "'>";
            $html .= "<div class='helpie-main-section'>";
            $html .= "<div class='wrapper'>";
            $html .= "You DO NOT have access. Login to get access: <a class='text-decoration: underline;' href='" . wp_login_url() . "'>Login</a>";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";

            // include plugin_dir_path(dirname(dirname(__FILE__))).'includes/views/no-access.php';
            return $html;
        }

        // Match function name with settings name
        protected function main_page_categories()
        {
            $html = "<div class='helpie-main-content-area'>";

            if ($this->settings->main_page->can_show_mp_categories()) {
                $html .= $this->get_category_listing_by_settings();
            }

            $html .= "</div>";

            return $html;
        }

        // Match function name with settings name
        protected function helpie_mp_show_stats()
        {
            $html = '';

            // if ($this->settings->main_page->show_stats()) {
            $frontend_stats = new \Helpie\Features\Components\Stats\Frontend_Stats();
            $html .= $frontend_stats->get_view();
            // }

            return $html;
        }

        // Match function name with settings name
        protected function show_article_listing()
        {
            $mp_settings = new \Helpie\Includes\Settings\Getters\Mp_Settings();

            $html = '';

            // if ($this->settings->main_page->show_article_listing()) {
            $article_listing = new \Helpie\Features\Components\Articles\Article_Listing();
            $args = $mp_settings->get_article_listing_settings();
            $html .= $article_listing->get_view($args);
            // }

            return $html;
        }

        protected function get_category_listing_by_settings()
        {
            $args = ['sortby' => 'term_order'];
            $category_listing = new \Helpie\Features\Components\Category_Listing\Category_Listing();
            return $category_listing->get_view($args);
        }
    } // END CLASS
}
