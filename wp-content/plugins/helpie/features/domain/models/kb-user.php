<?php

namespace Helpie\Features\Domain\Models;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Domain\Models\Kb_User')) {
    class Kb_User
    {
        public function get_default_review_roles()
        {
            $default_roles = array('editor' , 'administrator');

            $default_review_roles = array();

            for ($ii = 0; $ii < sizeof($default_roles); $ii++) {
                $role = $default_roles[$ii];
                if ($this->role_exists($role) && current_user_can($role)) {
                    array_push($default_review_roles, $role);
                }
            }

            return $default_review_roles;
        }
        // public reviewer_roles
        // Permissions
        public function can_trash()
        {
            $can_trash = false;

            $default_roles = array('editor' , 'administrator');

            for ($ii = 0; $ii < sizeof($default_roles); $ii++) {
                $role = $default_roles[$ii];
                if ($this->role_exists($role) && current_user_can($role)) {
                    $can_trash = true;
                    break;
                }
            }

            return $can_trash;
        }

        public function role_exists($role)
        {
            if (isset($role) && !empty($role)) {
                return $GLOBALS['wp_roles']->is_role($role);
            }

            return false;
        }
    }
}
