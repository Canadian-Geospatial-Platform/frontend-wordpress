<?php

namespace Helpie\Features\Services\Publishing;

if (!class_exists('\Helpie\Features\Services\Publishing\Publishing_Model')) {
    class Publishing_Model
    {
        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function set_last_approved_revision($post_id)
        {
            $post_revisions = \wp_get_post_revisions($post_id);
            if (isset($post_revisions) && !empty($post_revisions)) {
                $latest_revision = array_shift($post_revisions);
                update_post_meta($post_id, 'last_approved_revision', $latest_revision->ID);
            } else {
                update_post_meta($post_id, 'last_approved_revision', $post_id);
            }
        }

        public function get_current_user_role()
        {
            global $wp_roles;
            $current_user = \wp_get_current_user();
            $roles = $current_user->roles;
            $role = array_shift($roles);

            return $role;
        }

        protected function is_edit_page($new_edit = null)
        {
            global $pagenow;
            //make sure we are on the backend
            if (!is_admin()) {
                return false;
            }

            if ($new_edit == "edit") {
                return in_array($pagenow, array('post.php'));
            } elseif ($new_edit == "new") //check for new post page
            {
                return in_array($pagenow, array('post-new.php'));
            } else //check for either new or edit
            {
                return in_array($pagenow, array('post.php', 'post-new.php'));
            }

        }

        protected function can_user($cap_name)
        {
            $has_cap = false;

            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();

            if (is_admin() || current_user_can('administrator')) {
                $has_cap = true;
                // error_log('is_admin $has_cap : ' . $has_cap);
                return $has_cap;
            }

            if (is_single() && get_post_type('pauple_helpie')) {
                $post_id = get_the_ID();
                $has_cap = $dynamic_caps->get_article_single_capability($post_id, $cap_name);
            } else if (is_tax('helpdesk_category') && get_post_type('pauple_helpie')) {
                $term_id = get_queried_object()->term_id;
                $has_cap = $dynamic_caps->get_topic_single_capability($term_id, $cap_name);
            }
            // error_log('$has_cap : ' . $has_cap);
            // $has_cap = false;
            return $has_cap;
        }
        public function can_current_user_edit()
        {
            $can_edit = false;

            // // Fallback Rules - True for all users
            // $can_edit = true;

            // // Settings Rules ( rules from Helpie Settings )
            // $edit_roles = $this->settings->core->get_kb_edit_capability_roles();
            // $can_edit = $this->is_current_user_capable('kb_edit_capability', $edit_roles);

            $can_edit = $this->can_user('can_edit');
            $can_edit = apply_filters('can_edit_helpie_kb', $can_edit);

            return $can_edit;
        }

        public function can_current_user_publish()
        {
            // $can_publish = false;

            // // Fallback Rules - True for all users
            // if ($this->get_current_user_role() == "administrator") {
            //     $can_publish = true;
            // }

            // // Settings Rules ( rules from Helpie Settings )
            // $publish_roles = $this->settings->core->get_kb_publish_capability_roles();
            // $can_publish = $this->is_current_user_capable('kb_publish_capability', $publish_roles);

            $can_publish = $this->can_user('can_publish');
            $can_publish = apply_filters('can_publish_helpie_kb', $can_publish);

            return $can_publish;
        }

        public function can_current_user_approve()
        {
            // $can_approve = false;

            // // Fallback Rules - True for all users
            // if ($this->get_current_user_role() == "administrator") {
            //     $can_approve = true;
            // }

            // // Settings Rules ( rules from Helpie Settings )
            // $approve_roles = $this->settings->core->get_kb_approve_capability_roles();
            // $can_approve = $this->is_current_user_capable('kb_approve_capability', $approve_roles);

            $can_approve = $this->can_user('can_approve');
            $can_approve = apply_filters('can_approve_helpie_kb', $can_approve);

            return $can_approve;
        }

        public function is_current_user_capable($capability_name, $capability_roles)
        {
            $user_id = get_current_user_id();
            $is_user_super_admin = is_super_admin($user_id);
            $is_user_admin = current_user_can('administrator');

            // 0. Check If $capability_roles has "anyone"

            if (in_array('anyone', $capability_roles)) {
                return true;
            }

            // 1. Check if user is logged in
            if (!is_user_logged_in()) {
                return false;
            }

            // 2. Check if Super_Admin
            if ($is_user_super_admin || $is_user_admin) {
                return true;
            }

            // 3. Check if 'capability_option' is set
            $capability_option = get_option($capability_name);
            if (!isset($capability_option) || empty($capability_option)) {
                return false;
            }

            // 4. Check if user has the capability role
            $user_has_role = $this->does_user_has_matching_role($user_id, $capability_roles);
            if ($user_has_role) {
                return true;
            }

            return false;
        }

        /* Protected Method */

        protected function does_user_has_matching_role($user_id, $capability_roles)
        {
            $user = new \WP_User($user_id);
            $has_role = false;

            if (empty($user->roles) || !is_array($user->roles)) {
                return false;
            }

            foreach ($user->roles as $role) {
                if (in_array($role, $capability_roles)) {
                    $has_role = true;
                    break;
                }
            }

            return $has_role;
        }
        // Gets User Role of password $user object,
        // if not object is passed, gets role of current user
        protected function get_user_role($user = null)
        {
            $user = ($user) ? new \WP_User($user) : wp_get_current_user();
            return ($user->roles) ? $user->roles[0] : false;
        }
    } // END CLASS
}