<?php

namespace Helpie\Features\Services\Password_Protect;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

include_once HELPIE_PLUGIN_PATH . 'includes/utils/pauple-helper.php';

if (!class_exists('\Helpie\Features\Services\Password_Protect\Model')) {
    class Model
    {
        private $cookie_name = 'helpie_password_transient';

        public function __construct()
        {
            $this->helper = new \Helpie\Includes\Utils\Pauple_Helper();
            $this->cookie = new \Helpie\Features\Services\Password_Protect\Services\Cookie($this->cookie_name);
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function is_unlock($type = 'category', $term_or_post_id = null)
        {
            $unlock = true;
            $term_id = $term_or_post_id;
            $protected_terms = $this->getItems();
            $saved_passwords = $this->cookie->get_passwords();

            // error_log('locked_terms : ' . print_r($protected_terms, true));
            // error_log('saved_passwords : ' . print_r($saved_passwords, true));

            if ($type == 'article') {
                remove_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3);
                $terms = get_the_terms($term_or_post_id, HELPIE_TAXONOMY);
                add_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3);

                $term_id = isset($terms) && !empty($terms) ? $terms[0]->term_id : '';
            }

            $top_most_term_id = $this->helper->get_term_top_most_parent($term_id, HELPIE_TAXONOMY);

            $is_set_protected_terms_in_db = (isset($protected_terms) && !empty($protected_terms)) ? true : false;
            $is_set_passwords_in_cookies = (isset($saved_passwords) && !empty($saved_passwords)) ? true : false;

            // error_log('$is_set_passwords_in_cookies : ' . print_r($is_set_passwords_in_cookies, true));
            // error_log('$is_set_protected_terms_in_db : ' . print_r($is_set_protected_terms_in_db, true));

            // 1st layer : Unlock 'all' terms and post for Admin
            $is_admin = $this->helper->check_if_user_is_admin();
            if ($is_admin) {
                return $unlock;
            }

            // 2nd layer : Lock 'all' terms or term found in db only
            if ($is_set_protected_terms_in_db) {
                $is_locked_term = $this->is_locked_terms($top_most_term_id, $protected_terms);
                $unlock = $is_locked_term;
            }

            // 3rd layer : Unlock 'all' terms or term if password found in cookies
            if ($is_set_passwords_in_cookies) {
                $found_in_transient = $this->is_password_found_in_transient($top_most_term_id, $protected_terms, $saved_passwords);
                $unlock = (!empty($found_in_transient)) ? $found_in_transient : $unlock;
            }

            // error_log('$unlock : ' . $unlock);

            return $unlock;
        }

        public function validate()
        {
            $result = $this->validation();
            wp_reset_query();
            print_r(json_encode($result, JSON_NUMERIC_CHECK));
            wp_die();
        }

        public function validation()
        {
            $items = $this->getItems();
            $collection = $this->getCollection();

            $props = [
                'items' => $this->getItems(),
                'collection' => $this->getCollection(),
            ];

            $result = array(
                'output' => 'wrong-password',
                'value' => '',
                'is_correct_password' => false,
            );

            // error_log('props: ' . print_r($props, true));
            // error_log('result: ' . print_r($result, true));

            $result = $this->check_password($props, $result);

            if (strpos($result['output'], 'http') !== false) {
                $this->save_password($props['collection']['input']);
            }

            return $result['output'];
        }

        protected function is_password_found_in_transient($term_id, $protected_terms, $saved_passwords)
        {
            $found_in_transient = false;

            $is_set_term_id = (isset($term_id) && !empty($term_id)) ? true : false;
            $is_term_lock = ($is_set_term_id && isset($protected_terms[$term_id]) && !empty($protected_terms[$term_id])) ? true : false;
            // error_log('is_term_lock : ' . $is_term_lock);

            $is_all_terms_lock = (isset($protected_terms['all']) && !empty($protected_terms['all'])) ? true : false;

            // error_log('$is_all_terms_lock  : ' . $is_all_terms_lock);
            // Check given "term_id" password found in cookies
            if ($is_term_lock) {
                $found_term_password = !!count(array_intersect($protected_terms[$term_id], $saved_passwords));
                // error_log('$found_term_password  : ' . $found_term_password);
                $found_in_transient = (!empty($found_term_password) && $found_term_password == true) ? true : false;
            }

            // Check 'all' password found in cookies
            if ($is_all_terms_lock && !$found_in_transient) {
                $password_of_all = $this->fix_password_value_datatype($protected_terms['all']);
                $found_in_transient = $this->helper->is_value_in_given_array($password_of_all, $saved_passwords);
                // error_log('$found_password_of_all  : ' . $password_of_all);
            }

            // error_log('found_in_transient  : ' . $found_in_transient);
            return $found_in_transient;
        }

        protected function is_locked_terms($term_id, $locked_terms)
        {
            $locked = false;
            $unlocked = true;

            // 1. locked term is the string 'all', then return every $term_id as locked_terms
            if (array_key_exists('all', $locked_terms)) {
                return $locked;
            }

            // term_id exist in locked terms
            if (!empty($term_id) && array_key_exists($term_id, $locked_terms)) {
                return $locked;
            }

            return $unlocked;
        }

        protected function getCollection()
        {
            $collection = array();

            if (isset($_POST['term_id']) && !empty($_POST['term_id'])) {
                $collection['term_id'] = $_POST['term_id'];
                $collection['top_most_term_id'] = $this->helper->get_term_top_most_parent($_POST['term_id'], HELPIE_TAXONOMY);
            }

            if (isset($_POST['input']) && !empty($_POST['input'])) {
                $collection['input'] = $_POST['input'];
            }

            if (isset($_POST['origin']) && !empty($_POST['origin'])) {
                $collection['origin'] = $_POST['origin'];
            }

            if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
                $collection['post_id'] = $_POST['post_id'];
            }

            return $collection;
        }

        protected function getItems()
        {
            $items = $this->settings->password_protection->get_passwords();

            if (!isset($items) || empty($items)) {
                return $items;
            }

            $protected_terms = [];
            foreach ($items as $rows => $terms) {
                foreach ($terms['password_for_content'] as $key => $term_id) {
                    if (!array_key_exists($term_id, $protected_terms)) {
                        $protected_terms[$term_id] = array();
                    }
                    array_push($protected_terms[$term_id], $terms['password_for']);
                }
            }

            return $protected_terms;
        }

        protected function check_password($props, $result)
        {
            // All Password Check
            if (isset($props['items']['all']) && !empty($props['items']['all'])) {
                $result['value'] = $this->fix_password_value_datatype($props['items']['all']);
                $result['is_correct_password'] = ($result['value'] == $props['collection']['input']);
            }

            // Parent and Child Term ID Password Check
            $term_id = $props['collection']['top_most_term_id'];
            if (!$result['is_correct_password'] && (isset($props['items'][$term_id]) && !empty($props['items'][$term_id]))) {
                $term_password = $props['items'][$term_id];
                // error_log('Term Password : ' . print_r($term_password, true));
                foreach ($term_password as $key => $value) {
                    if ($result['is_correct_password']) {
                        break;
                    }
                    $result['value'] = $this->fix_password_value_datatype($value);
                    $result['is_correct_password'] = ($value == $props['collection']['input']);
                }
            }

            // Set output link if correct password
            if ($result['is_correct_password'] && isset($props['collection']['origin'])) {
                if ($props['collection']['origin'] !== 'category') {
                    $result['output'] = get_the_permalink($props['collection']['post_id']);
                } else {
                    $term = get_term($props['collection']['term_id'], HELPIE_TAXONOMY);
                    $term_link = get_term_link($term);
                    $result['output'] = $term_link;
                }
            }

            return $result;
        }

        protected function save_password($password)
        {
            // unset($_COOKIE[$this->cookie_name]);
            $saved_passwords = $this->cookie->get_passwords();
            $password_exists = false;

            // 1. If any 'saved_password' is found in transient, the check for this password
            if (isset($saved_passwords) && !empty($saved_passwords)) {
                $password_exists = (in_array($password, $saved_passwords)) ? true : false;
            }

            // 2. If password not found, save password
            if ($password_exists == false) {
                $this->cookie->store_password_in_cookie($password);
            }
        }

        /**
         *  Fixes issue where the password value is sometimes stored as array
         *  and sometimes string
         */
        private function fix_password_value_datatype($value)
        {
            if (is_array($value)) {
                $value_array = $value;
                $value = '';
                $value = $value_array[0];
            }

            return $value;
        }

    } // End of class
}
