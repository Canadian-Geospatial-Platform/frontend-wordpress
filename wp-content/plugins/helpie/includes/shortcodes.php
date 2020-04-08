<?php

namespace Helpie\Includes;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Shortcodes')) {
    class Shortcodes
    {
        private $syntax_id = 1;
        private $components;

        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->scripts_handler = new \Helpie\Includes\Core\Scripts_Handler();
            $this->pp_controller = new \Helpie\Features\Services\Password_Protect\Controller();

            $this->shortcode_list = [
                'pauple_helpie_main_page_shortcode',
                'pauple_helpie_categories_listing',
                'pauple_helpie_welcome_area',
                'helpie_kb_code',
                'pauple_helpie_search',
                'pauple_helpie_search_results_page',
                'pauple_helpie_recent_articles_box',
                'pauple_helpie_frontend_stats',
                'helpie_kb_articles',
                'helpie_kb_toc',
            ];
        }

        public function ph_main_page_shortcode()
        {
            $main_page_builder = new \Helpie\Templates\views\Main_Page\Main_Page_Builder();
            $html = "<div class='helpie-single-page-module'>";
            $html .= $main_page_builder->get_html();
            $html .= "</div>";
            $html .= "<div style='clear:both;'></div>";

            return $html;
        }

        public function pauple_helpie_categories_listing($atts)
        {
            $this->dynamic_caps = get_helpie_kb_capabilities('kb-main');

            $widget_model = new \Helpie\Features\Components\Category_Listing\Category_Listing_Model();
            $defaults = $widget_model->get_default_args();
            $categories_listing_html = '';
            if ($this->dynamic_caps['can_view']) {
                $args = shortcode_atts($defaults, $atts);

                foreach ($args as $key => $value) {
                    $args[$key] = sanitize_key($value);
                }

                $category_list = new \Helpie\Features\Components\Category_Listing\Category_Listing();
                $categories_listing_html .= $category_list->get_view($args);
                wp_reset_query();
            } else {
                $categories_listing_html .= "You DO NOT have access. Login to get access: <a style='text-decoration: underline;' href='" . wp_login_url() . "'>Login</a>";
            }

            $categories_listing_html .= $this->pp_controller->get_Modal();

            return $categories_listing_html;
        }

        public function pauple_helpie_welcome_area($atts, $content = null)
        {
            // Enqueue Scripts if Not already included
            $this->scripts_handler->enqueue_semantic_scripts();
            $this->scripts_handler->enqueue_kb_frontend_scripts();

            $this->hero_model = new \Helpie\Features\Components\Hero\Hero_Area_Model();
            $defaults = $this->hero_model->get_default_args();

            $args = shortcode_atts($defaults, $atts);

            $hero_area = new \Helpie\Features\Components\Hero\Hero_Area($args);
            return $hero_area->get_view($args);
        }

        public function pauple_helpie_search($atts, $content = null)
        {
            $pauple_helpie_components = new \Helpie\Includes\Components();
            return $pauple_helpie_components->phelpie_show_search();
        }

        public function pauple_helpie_search_results_page($atts, $content = null)
        {
            $this->dynamic_caps = get_helpie_kb_capabilities('kb-main');

            $this->search_controller = new \Helpie\Features\Components\Search\Search_Controller();

            if ($this->dynamic_caps['can_view']) {
                $args = $this->get_search_args();
                return $this->search_controller->get_view($args);
            }

            // TO-DO: Refactor views/no-access.php
            return "You DO NOT have access. Login to get access: <a class='text-decoration: underline;' href='" . wp_login_url() . "'>Login</a>";
        }

        protected function get_search_args()
        {

            // 1. Set 'content_area_class'
            $helpie_catp_content_area_class = 'full-width';

            if ($this->settings->category_page->can_show_catp_sidebar()) {
                $helpie_catp_content_area_class = 'partial-width';
            }

            $args = array(
                'content_area_class' => $helpie_catp_content_area_class,
            );

            return $args;
        }

        public function recent_articles_box($atts, $content = null)
        {
            $article_listing = new \Helpie\Features\Components\Articles\Article_Listing();
            $args = array(
                'title' => 'Recent Articles',
                'type' => 'recent',
                'style' => 'card',
                'num_of_cols' => 'three',
                'limit' => 3,
            );

            return $article_listing->get_view($args);
        }

        public function helpie_kb_code($atts, $content = null)
        {
            if ($content != null) {
                $handle = 'highlight-syntax';
                $list = 'enqueued';
                if (!wp_script_is($handle, $list)) { // if file is not enqueued
                    wp_enqueue_style('highlight-syntax', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/prism/prism.css', array(), $this->version, null);
                    wp_enqueue_script('highlight-syntax', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/prism/prism.js', array(), $this->version, null);
                }
                $default = array(
                    'lang' => 'markup',
                );
                $args = shortcode_atts($default, $atts);
                $full_content = "<pre class='language-" . $args['lang'] . "'><code>";
                $full_content .= wp_strip_all_tags($content);
                $full_content .= '</code></pre>';

                return $full_content;
            }
        } // End of pauple_helpie_syntax_highlight

        public function helpie_kb_articles($atts, $content = null)
        {
            $this->articles_listing_model = new \Helpie\Features\Components\Articles\Article_Listing_Model();
            $defaults = $this->articles_listing_model->get_default_args();

            $args = shortcode_atts($defaults, $atts);

            $article_listing = new \Helpie\Features\Components\Articles\Article_Listing();

            $article_listing_html = $article_listing->get_view($args);
            $article_listing_html .= $this->pp_controller->get_Modal();

            return $article_listing_html;
        } // End of pauple_helpie_syntax_highlight

        public function frontend_stats($atts, $content = null)
        {
            $this->stats_model = new \Helpie\Features\Components\Stats\Stats_Model();
            $defaults = $this->stats_model->get_default_args();

            $args = shortcode_atts($defaults, $atts);

            $frontend_stats = new \Helpie\Features\Components\Stats\Frontend_Stats();
            return $frontend_stats->get_view($args);
        }

        public function helpie_kb_toc($atts, $content = null)
        {
            $toc_model = new \Helpie\Features\Components\Toc\Model\Toc_Model();
            $defaults = $toc_model->get_default_args();

            $args = shortcode_atts($defaults, $atts);

            $toc_controller = new \Helpie\Features\Components\Toc\Toc_Controller();

            $toc_html = $toc_controller->get_view($args);
            $toc_html .= $this->pp_controller->get_Modal();

            return $toc_html;
        }

        public static function helpie_kb_voting($atts, $content = null)
        {
            $voting_model = new \Helpie\Features\Components\Voting\Voting_Model();
            $defaults = $voting_model->get_default_args();

            $args = shortcode_atts($defaults, $atts);

            $voting_controller = new \Helpie\Features\Components\Voting\Voting_Controller();
            return $voting_controller->get_view($args);
        }

        public static function helpie_kb_breadcrumbs($atts, $content = null)
        {
            $breadcrumbs_model = new \Helpie\Features\Components\Breadcrumbs\Breadcrumbs_Model();
            $defaults = $breadcrumbs_model->get_default_args();

            $args = shortcode_atts($defaults, $atts);

            $breadcrumbs = new \Helpie\Features\Components\Breadcrumbs\Breadcrumbs();
            return $breadcrumbs->get_view($args);
        }

        public static function helpie_kb_search_results($atts, $content = null)
        {
            $model = new \Helpie\Features\Components\Search\Models\Search_Model();
            $defaults = $model->get_default_args();

            $args = shortcode_atts($defaults, $atts);

            $controller = new \Helpie\Features\Components\Search\Search_Controller();
            return $controller->get_view($args);
        }

        public static function helpie_kb_page_controls($atts, $content = null)
        {
            $model = new \Helpie\Features\Components\Page_Controls\Model();
            $defaults = $model->get_default_args();

            $args = shortcode_atts($defaults, $atts);

            $controller = new \Helpie\Features\Components\Page_Controls\Controller();
            return $controller->get_view($args);
        }

        public static function helpie_kb_test($atts, $content = null)
        {

            $tax_query_fake = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'helpdesk_category',
                    'field' => 'id',
                    'terms' => array(3),
                    'operator' => 'IN',
                    'include_children' => false,
                ),
                array(
                    'taxonomy' => 'helpdesk_category',
                    'field' => 'id',
                    'terms' => array(12),
                    'operator' => 'NOT IN',
                    'include_children' => false,
                ),
            );
            $args = array(
                'post_status' => 'publish, awaiting',
                'post_type' => 'pauple_helpie',

                'numberposts' => 4,
                'tax_query' => $tax_query_fake,
            );

            $articles = get_posts($args);

            $html = '';

            foreach ($articles as $article) {
                $html .= " - " . $article->ID;
            }
            return $html;
        }
    }
}

$pauple_helpie_shortcodes = new \Helpie\Includes\Shortcodes();

add_shortcode('pauple_helpie_main_page_shortcode', array($pauple_helpie_shortcodes, 'ph_main_page_shortcode'));
add_shortcode('pauple_helpie_categories_listing', array($pauple_helpie_shortcodes, 'pauple_helpie_categories_listing'));
add_shortcode('pauple_helpie_welcome_area', array($pauple_helpie_shortcodes, 'pauple_helpie_welcome_area'));
add_shortcode('helpie_kb_code', array($pauple_helpie_shortcodes, 'helpie_kb_code'));
add_shortcode('pauple_helpie_search', array($pauple_helpie_shortcodes, 'pauple_helpie_search'));
add_shortcode('pauple_helpie_search_results_page', array($pauple_helpie_shortcodes, 'pauple_helpie_search_results_page'));
add_shortcode('pauple_helpie_recent_articles_box', array($pauple_helpie_shortcodes, 'recent_articles_box'));
add_shortcode('pauple_helpie_frontend_stats', array($pauple_helpie_shortcodes, 'frontend_stats'));
add_shortcode('helpie_kb_articles', array($pauple_helpie_shortcodes, 'helpie_kb_articles'));
add_shortcode('helpie_kb_toc', array($pauple_helpie_shortcodes, 'helpie_kb_toc'));
add_shortcode('helpie_kb_voting', array($pauple_helpie_shortcodes, 'helpie_kb_voting'));
add_shortcode('helpie_kb_breadcrumbs', array($pauple_helpie_shortcodes, 'helpie_kb_breadcrumbs'));
add_shortcode('helpie_kb_search_results', array($pauple_helpie_shortcodes, 'helpie_kb_search_results'));
add_shortcode('helpie_kb_page_controls', array($pauple_helpie_shortcodes, 'helpie_kb_page_controls'));

/* Test Shortcode */
add_shortcode('helpie_kb_test', array($pauple_helpie_shortcodes, 'helpie_kb_test'));

/* Need Fixing: This code causes content to disapper */
// remove_filter('the_content', 'wpautop');
// add_filter('the_content', 'wpautop', 99);
// add_filter('the_content', array('Helpie\Includes\Shortcodes', 'pauple_helpie_syntax_highlight'), 100);
