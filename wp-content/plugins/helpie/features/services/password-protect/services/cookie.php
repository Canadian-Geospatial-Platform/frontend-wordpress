<?php

namespace Helpie\Features\Services\Password_Protect\Services;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

include_once HELPIE_PLUGIN_PATH . 'includes/utils/pauple-helper.php';

if (!class_exists('\Helpie\Features\Services\Password_Protect\Services\Cookie')) {
    class Cookie
    {

        public function __construct($name)
        {
            $this->name = $name;
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function get()
        {
            if (isset($_COOKIE[$this->name]) && !empty($_COOKIE[$this->name])) {
                return $_COOKIE[$this->name];
            }

            return false;
        }

        public function set($cookie_value)
        {
            $password_protection = $this->settings->password_protection->get_settings();
            $days = $password_protection['remember_days'];

            setcookie($this->name, $cookie_value, time() + (86400 * $days), "/");
        }

        public function get_passwords()
        {
            $cookie = $this->get();
            return $this->get_formatted_cookie($cookie);
        }

        public function store_password_in_cookie($password)
        {
            $saved_password = $this->get_passwords();

            if (!isset($saved_password) || !is_array($saved_password)) {
                $saved_password = array();
            }

            array_push($saved_password, $password);

            $cookie_value = json_encode($saved_password, JSON_NUMERIC_CHECK);
            $this->set($cookie_value);
        }

        public function get_formatted_cookie($cookie)
        {
            $formatted_cookie = array();

            if (isset($cookie) && !empty($cookie)) {
                $cookie = stripslashes($cookie);
                $formatted_cookie = json_decode($cookie, true);

                return $formatted_cookie;
            }

            return false;
        }

    } // END CLASS

}
