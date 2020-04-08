<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Core_Getter')) {
    class Core_Getter
    {
        public function __construct()
        {
            // $this->core_options = get_option('helpie_core_options_main');
            $this->core_options = get_option('helpie-kb'); // unique id of the framework
        }

        public function get_kb_title()
        {
            $title = 'Helpdesk';
            if (isset($this->core_options['kb_main_title'])) {
                $title = sanitize_text_field($this->core_options['kb_main_title']);
            }
            return $title;
        }

        public function get_kb_subtitle()
        {
            $subtitle = 'We’re here to help.';
            if (isset($this->core_options['kb_main_subtitle'])) {
                $subtitle = sanitize_text_field($this->core_options['kb_main_subtitle']);
            }
            return $subtitle;
        }

        public function get_show_subtitle()
        {
            $subtitle = '';
            if (isset($this->core_options['kb_show_subtitle'])) {
                $subtitle = sanitize_text_field($this->core_options['kb_main_subtitle']);
            }
            return $subtitle;
        }

        public function get_num_of_revisions()
        {
            $num = 20;
            if (isset($this->core_options['kb_num_of_revisions'])) {
                $num = sanitize_text_field($this->core_options['kb_num_of_revisions']);
            }
            return $num;
        }

        public function get_editor_type()
        {
            $editor_type = 'inline';
            if (isset($this->core_options['kb_editor_type'])) {
                $editor_type = sanitize_text_field($this->core_options['kb_editor_type']);
            }
            return $editor_type;
        }

        public function is_frontend_editing_enabled()
        {
            $frontend_editing_option = false;
            if (isset($this->core_options['kb_frontend_enable'])) {
                $frontend_editing_option = $this->core_options['kb_frontend_enable'];
            }

            return $frontend_editing_option;
        }

        public function get_kb_edit_capability_roles()
        {
            $kb_edit_capability_roles = $this->get_capability_roles('kb_edit_capability');
            return $kb_edit_capability_roles;
        }

        public function get_kb_publish_capability_roles()
        {
            $kb_edit_capability_roles = $this->get_capability_roles('kb_publish_capability');
            return $kb_edit_capability_roles;
        }

        public function get_kb_approve_capability_roles()
        {
            $kb_edit_capability_roles = $this->get_capability_roles('kb_approve_capability');
            return $kb_edit_capability_roles;
        }

        protected function get_capability_roles($option_name)
        {
            $option = get_option($option_name);

            $capability_roles = array();
            // Fixes issue in multisite

            if (isset($option[$option_name])) {
                $capability_roles = $option[$option_name];
            } else {
                $capability_roles = $option;
            }

            if (!is_array($capability_roles)) {
                $capability_roles = (explode(",", $capability_roles));
            }

            // If $capability_roles is empty, then assign administrator to interface it

            if (!isset($capability_roles) || empty($capability_roles)) {
                array_push($capability_roles, 'administrator');
            }

            return $capability_roles;
        }
    } // END CLASS
}