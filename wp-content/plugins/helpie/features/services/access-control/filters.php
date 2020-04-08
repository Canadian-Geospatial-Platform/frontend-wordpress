<?php

namespace Helpie\Features\Services\Access_Control;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

include_once HELPIE_PLUGIN_PATH . 'includes/utils/pauple-helper.php';

if (!class_exists('\Helpie\Features\Services\Access_Control\Filters')) {
    class Filters
    {
        public function __construct($dynamic_caps)
        {
            /* helper needs to be first */
            $this->helper = new \Helpie\Includes\Utils\Pauple_Helper();

            $this->category = 'helpdesk_category';
            $this->post_type = 'pauple_helpie';
            $this->filter_posts();
            $this->filter_terms();
            $this->helpie_hooks();
            $this->content_filter();



            $this->dynamic_caps = $dynamic_caps;
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function content_filter()
        {
            $toc_controller = new \Helpie\Features\Components\Toc\Toc_Controller();

            /* TODO: Check Permissions */

            // TOC Component
            add_filter('the_content', array($toc_controller, 'get_backtotop'));
            add_filter('the_content', array($this, 'toc_inpage_nav'));

            // Single Page Components
            if (!has_filter('the_content', array($this, 'single_page_content_module'))) {
                add_filter('the_content', array($this, 'single_page_content_module'));
            }
        }


        /* Adding Breadcrumbs, Voting, Updated By via filters */
        public function single_page_content_module($content)
        {
            $template_source = $this->settings->single_page->get_template_source();

            if ($template_source == 'helpie') {
                return $content;
            }
            ob_start();
            do_action('helpiekb_single_title_after');
            $title_after = ob_get_clean();

            ob_start();
            do_action('helpiekb_single_content_after');
            $content_after = ob_get_clean();

            $content = $title_after . $content . $content_after;

            return $content;
        }

        public function toc_inpage_nav($content)
        {
            $should_modify_header = $this->header_title_modifier_condition($content);

            if ($should_modify_header) {
                $toc_controller = new \Helpie\Features\Components\Toc\Toc_Controller();
                return $toc_controller->get_content($content);
            }
            return $content;
        }

        public function header_title_modifier_condition($content)
        {
            $helpie_sidebar_type = $this->settings->components->get_toc_type();
            $show_auto_toc = $this->settings->components->show_auto_toc();

            $inPageNavOption = ($helpie_sidebar_type == 'page-scroll-only');
            $sidebar_autoTOC = $show_auto_toc;

            $component_options = get_option('helpie-kb');
            $has_component_options = (isset($component_options) && !empty($component_options));

            if ($has_component_options && ($inPageNavOption || isset($sidebar_autoTOC))) {
                $has_auto_toc = (isset($sidebar_autoTOC) && ($sidebar_autoTOC));
                $has_inPageNav = $inPageNavOption;
            } else {
                $has_component_options = false;
                $has_auto_toc = false;
                $has_inPageNav = false;
            }

            $post_type = get_post_type();

            if (($has_component_options && ($post_type == 'pauple_helpie') && ($has_auto_toc || $has_inPageNav)) || has_shortcode($content, 'helpie_kb_toc')) {
                return true;
            }

            return false;
        }
        public function filter_posts()
        {
            if (!has_action('pre_get_posts', 'helpie_kb_filter_posts')) {
                add_action('pre_get_posts', 'helpie_kb_filter_posts');

                // add_filter('the_title', 'helpie_kb_the_title');
            }

            if (!has_action('the_content', 'helpie_kb_the_content')) {
                add_filter('the_content', 'helpie_kb_the_content', 10, 2);
            }
        }

        public function filter_terms()
        {
            if (!has_action('helpie_kb_pre_get_terms')) {
                add_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 2);
                // error_log(' pre_get_terms: ');
            }
        }



        public function helpie_hooks()
        {
            $is_admin_user = $this->helper->check_if_user_is_admin();

            if ($is_admin_user) {
                return;
            }

            // TODO: This works, replace Category Repository with this
            add_filter('helpie_kb_pre_get_terms', array($this, 'helpie_filter_terms'), 10, 2);
            add_action('helpie_kb_filter_posts', array($this, 'helpie_filter_posts'));
            add_filter('helpie_kb_the_content', array($this, 'filter_the_content'), 10, 2);
        }

        public function helpie_filter_terms($query)
        {
            $allowed_content = $this->dynamic_caps->get_allowed_content('can_view');

            $filter_get_terms = new \Helpie\Features\Services\Access_Control\Strategies\Filter_Get_Terms($query, $allowed_content);
            return $filter_get_terms->filter();
        }

        public function helpie_filter_posts($query)
        {

            // error_log('helpie_filter_posts');
            $allowed_content = $this->dynamic_caps->get_allowed_content('can_view');

            $filter_get_posts = new \Helpie\Features\Services\Access_Control\Strategies\Filter_Get_Posts($query, $allowed_content);
            $filter_get_posts->filter();
        }

        public function filter_the_content($content)
        {
            // error_log('filter_the_content : ' . $content);

            $post_id = get_the_ID();

            $final_has_cap = $this->dynamic_caps->get_final_article_has_cap($post_id, 'can_view');

            if (!$final_has_cap) {
                $content = "You DO NOT have access. Login to get access: <a style='text-decoration: underline;' href='" . wp_login_url() . "'>Login</a>";
            }


            return $content;
        }
    } // END CLASS

}