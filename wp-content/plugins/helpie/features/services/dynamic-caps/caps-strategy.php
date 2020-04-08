<?php

namespace Helpie\Features\Services\Dynamic_Caps;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Services\Dynamic_Caps\Caps_Strategy')) {
    class Caps_Strategy
    {
        public function __construct($query = null)
        {
            $this->query = $query;
        }

        public function has_cap($args = array())
        {
            // error_log('has_cap : ');
            $this->type = $args['type'];

            $rule_not_set = (!isset($args['rule_set']) || empty($args['rule_set']));

            $args['rule_set']['type'] = isset($args['rule_set']['type']) ? $args['rule_set']['type'] : 'default';
            $default = ($args['rule_set']['type'] == 'default');
            $show_all = ($args['rule_set']['type'] == 'all');
            $show_none = ($args['rule_set']['type'] == 'none');
            $logged_in_rule = ($args['rule_set']['type'] == 'logged_in');

            if ($rule_not_set || $default) {
                return 'none';
            }

            if ($logged_in_rule) {
                return is_user_logged_in();
            }

            // Rule : 'all'
            if ($show_all) {
                return $this->show_all($args['item_id']);
            }

            if ($show_none) {
                return $this->show_none($args['item_id']);
            }

            $user_role = $this->get_user_role($args['user_id']);
            $args['rule_set']['items'] = isset($args['rule_set']['items']) ? $args['rule_set']['items'] : array();
            $is_role_not_included = ($args['rule_set']['type'] == 'roles' && !in_array($user_role, (array) $args['rule_set']['items']));
            $is_user_id_not_included = ($args['rule_set']['type'] == 'user_id' && !in_array($args['user_id'], (array) $args['rule_set']['items']));
            $is_role_included = ($args['rule_set']['type'] == 'roles' && in_array($user_role, (array) $args['rule_set']['items']));
            $is_user_id_included = ($args['rule_set']['type'] == 'user_id' && in_array($args['user_id'], (array) $args['rule_set']['items']));

            // Combination of prev logic
            $is_user_included = ($is_role_included || $is_user_id_included);
            $is_user_not_included = ($is_role_not_included || $is_user_id_not_included);

            // Rule : 'only'
            $user_included_as_only = ($args['rule_set']['rule'] == 'only') && ($is_user_included);
            if ($user_included_as_only) {
                return $this->user_included_as_only($args['item_id']);
            }

            $user_not_included_as_only = ($args['rule_set']['rule'] == 'only') && ($is_role_not_included || $is_user_id_not_included);
            if ($user_not_included_as_only) {
                return $this->user_not_included_as_only($args['item_id']);
            }

            // Rule : 'all_except'
            $user_included_as_all_except = ($args['rule_set']['rule'] == 'all_except') && ($is_user_included);
            if ($user_included_as_all_except) {
                return $this->user_included_as_all_except($args['item_id']);
            }

            $user_not_included_as_all_except = ($args['rule_set']['rule'] == 'all_except') && ($is_user_not_included);
            if ($user_not_included_as_all_except) {
                return $this->user_not_included_as_all_except($args['item_id']);
            }
        }

        public function show_all($item_id)
        {
            return true;
        }

        public function show_none($item_id)
        {
            return false;
        }

        public function user_included_as_only($item_id)
        {
            return true;
        }

        public function user_not_included_as_only($item_id)
        {
            return false;
        }

        public function user_included_as_all_except($item_id)
        {
            return false;
        }

        public function user_not_included_as_all_except($item_id)
        {
            return true;
        }

        /* PROTECTED */

        protected function get_user_role($user_id)
        {

            if (!is_user_logged_in()) {
                return 'guest';
            }

            $user = get_user_by('id', $user_id);
            $roles = $user->roles;
            return $roles[0];
        }
    } // END CLASS

}