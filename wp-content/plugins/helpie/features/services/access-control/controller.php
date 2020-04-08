<?php

namespace Helpie\Features\Services\Access_Control;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

include_once HELPIE_PLUGIN_PATH . 'includes/utils/pauple-helper.php';

// This is the primary controller of all access controls ( User_Role_Based, Password, Drag and Drop )
if (!class_exists('\Helpie\Features\Services\Access_Control\Controller')) {
    class Controller
    {
        private $dynamic_caps = null;

        public function __construct()
        {
            $this->mp_option_key = 'helpie_mp_options';
            $this->dnd_getter = new \Helpie\Includes\Core\Lib\Dnd\Getter($this->mp_option_key);
            $this->publishing = new \Helpie\Features\Services\Publishing\Publishing();
            $this->access_helper = new \Helpie\Features\Services\Access_Control\Helper();
            // $this->dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();

            $this->helper = new \Helpie\Includes\Utils\Pauple_Helper();

            /* Access Control Types */
            $this->basic_restriction = new \Helpie\Features\Services\Access_Control\Types\Basic_Restriction();
            $this->role_based = new \Helpie\Features\Services\Access_Control\Types\Role_Based();
        }

        public function hooks()
        {
            $this->register_hooks();
        }

        public function register_hooks()
        {
            $dynamic_caps_model = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();
            $filters = new \Helpie\Features\Services\Access_Control\Filters($dynamic_caps_model);
        }

        public function set_dynamic_caps()
        {
            if ($this->dynamic_caps == null) {
                $this->dynamic_caps =  \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps::getInstance();
            }
        }


        public function get_allowed_content()
        {
            $this->set_dynamic_caps();

            $allowed_content = $this->dynamic_caps->get_allowed_content('can_view');
            return $allowed_content;
        }

        // Capabilities Based on User, Location ( single page, category page, main page)
        public function get_dynamic_capabilities($location = 'single', $wp_obj = null)
        {

            $this->set_dynamic_caps();

            $dynamic_caps = array();
            $dynamic_caps['can_edit'] = $this->publishing->show_frontend_editor();
            $dynamic_caps_model = $this->dynamic_caps;

            if ($location == 'single') {
                $post_id = $this->helper->get_post_id($wp_obj);
                $terms = get_the_terms($post_id, 'helpdesk_category');
                $term = $terms[0];
                $dynamic_caps['can_view'] = $this->is_category_accessible($term, $location);
                $dynamic_caps['can_edit'] = $dynamic_caps_model->get_article_single_capability($post_id, 'can_edit');
            } else if ($location == 'category') {
                $term = $wp_obj;
                $dynamic_caps['can_view'] = $this->is_category_accessible($term, $location);
                $dynamic_caps['can_edit'] = $dynamic_caps_model->get_topic_single_capability($term->term_id, 'can_edit');
            } else if ($location == 'kb-main') {
                $dynamic_caps['can_view'] = $this->has_access();
            }

            return $dynamic_caps;
        }

        /* PROTECTED METHODS */

        /* DND */

        protected function get_all_excluded_categories()
        {
            $this->dnd_getter = new \Helpie\Includes\Core\Lib\Dnd\Getter();
            return $this->dnd_getter->get_all_excluded_categories();
        }

        // has_accesss
        protected function has_access()
        {
            return $this->basic_restriction->has_access();
        }

        protected function is_category_allowed_for_current_user($term_id, $location = 'other')
        {
            return $this->role_based->is_category_allowed_for_current_user($term_id, $location);
        }

        protected function is_category_accessible($term, $location)
        {
            $can_access = $this->is_category_allowed_for_current_user($term->term_id, $location);
            $has_access = $this->has_access();

            return ($has_access && $can_access);
        }
    } // END CLASS

}