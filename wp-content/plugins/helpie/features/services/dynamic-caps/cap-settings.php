<?php

namespace Helpie\Features\Services\Dynamic_Caps;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Services\Dynamic_Caps\Cap_Settings')) {
    class Cap_Settings
    {
        // Hold the class instance.
        private static $instance = null;
        private static $cap_settings = null;

        // The constructor is private
        // to prevent initiation with outer code.
        private function __construct()
        {
            // The expensive process (e.g.,db connection) goes here.
        }

        // The object is created from within the class itself
        // only if the class has no instance.
        public static function getInstance()
        {
            if (self::$instance == null) {
                self::$instance = new \Helpie\Features\Services\Dynamic_Caps\Cap_Settings();
            }

            return self::$instance;
        }


        public static function get()
        {
            if (isset(self::$cap_settings) && is_array(self::$cap_settings)) {
                return self::$cap_settings;
            }


            self::$cap_settings = array();
            self::$cap_settings['global'] = self::get_global_rules();
            self::$cap_settings['topics'] = self::get_topic_rules();
            self::$cap_settings['posts'] = self::get_post_rules();

            // error_log('self::$cap_settings : ' . print_r(self::$cap_settings, true));
            return self::$cap_settings;
        }

        protected static function get_global_rules()
        {

            $options = get_option('helpie-kb');

            if (!isset($options['helpie_dynamic_capability']) || empty($options['helpie_dynamic_capability'])) {
                $rules = [
                    'can_view' => array(
                        'type' => 'all',
                    ),
                    'can_edit' => array(
                        'type' => 'roles',
                        'rule' => 'only',
                        'items' => array('administrator'),
                    ),
                    'can_approve' => array(
                        'type' => 'roles',
                        'rule' => 'only',
                        'items' => array('administrator'),
                    ),
                    'can_publish' => array(
                        'type' => 'roles',
                        'rule' => 'only',
                        'items' => array('administrator'),
                    ),
                ];
            } else {
                $caps = ['can_view', 'can_edit', 'can_publish', 'can_approve'];
                $rules = self::get_item_cap_settings($caps, $options['helpie_dynamic_capability']);
            }

            return $rules;
        }
        // Stored in term_meta
        protected static function get_topic_rules()
        {
            $topic_rules = self::get_rules_from_meta('topic');
            // error_log('$topic_rules  : ' . print_r($topic_rules, true));
            return $topic_rules;
        }
        protected static function get_post_rules()
        {
            // $posts = get_all_helpie_kb_articles();
            // $cap_name = 'can_view';
            // $post_rules = self::get_rules_from_meta($posts, $cap_name, 'post');
            $post_rules = self::get_rules_from_meta('post');
            // error_log('$post_rules  : ' . print_r($post_rules, true));
            return $post_rules;
        }

        protected static function get_rules_from_meta($type = 'topic')
        {
            // $db = new \Helpie\Features\Services\DB_Old();
            $db =  \Helpie\Features\Services\DB::getInstance();

            if ($type == 'post') {
                $items = $db->get_post_meta();
            } else {
                $items = $db->get_term_meta();
            }

            // error_log('$items : ' . print_r($items, true));

            $rules = array();

            // Validation
            if (!isset($items) || empty($items)) {
                return $rules;
            }

            $caps = ['can_view', 'can_edit', 'can_publish', 'can_approve'];


            foreach ($items as $key => $item) {

                $item_id = $key;
                $all_meta = $item;

                if (!isset($all_meta) || !is_array($all_meta)) {
                    $all_meta = self::default_item_rules();
                }

                // if ($item_id == 4) {
                //     error_log('$all_meta : ' . print_r($all_meta, true));
                // }

                $rules[$item_id] = self::get_item_cap_settings($caps, $all_meta);
            }


            // error_log('$rules : ' . print_r($rules, true));

            return $rules;
        }





        protected static function get_rules_from_meta_old($items, $cap_name, $type = 'topic')
        {
            $rules = array();

            // Validation
            if (!isset($items) || empty($items)) {
                return $rules;
            }


            $caps = ['can_view', 'can_edit', 'can_publish', 'can_approve'];
            foreach ($items as $item) {

                $item_id = self::get_item_id($item, $type);
                $all_meta = self::get_item_meta($item, $type);

                if (!isset($all_meta) || !is_array($all_meta)) {
                    $all_meta = self::default_item_rules();
                }

                // if ($item_id == 4) {
                //     error_log('$all_meta : ' . print_r($all_meta, true));
                // }

                $rules[$item_id] = self::get_item_cap_settings($caps, $all_meta);
            }
            return $rules;
        }

        public static function default_item_rules($cap = 'none')
        {
            $default_rules = [
                'can_view' => array(
                    'type' => 'default',
                ),
                'can_edit' => array(
                    'type' => 'default',
                ),
                'can_approve' => array(
                    'type' => 'default',
                ),
                'can_publish' => array(
                    'type' => 'default',
                ),
            ];

            if ($cap == 'none') {
                return $default_rules;
            }

            return $default_rules[$cap];
        }
        protected static function get_item_cap_settings($caps, $all_meta)
        {
            $rules = array();

            // Reset condition for $all_meta
            if (!isset($all_meta) || !is_array($all_meta)) {
                $all_meta = [];
            }
            foreach ($caps as $cap_name) {
                # code...
                if (!isset($all_meta[$cap_name]) || !is_array($all_meta[$cap_name])) {

                    $all_meta[$cap_name] = self::default_item_rules($cap_name);
                }
                $meta = $all_meta[$cap_name];

                $rules[$cap_name] = array();
                $rules[$cap_name]['type'] = isset($meta['type']) ? $meta['type'] : 'default';
                $rules[$cap_name]['rule'] = isset($meta['rule']) ? $meta['rule'] : 'only';

                if ($rules[$cap_name]['type'] == 'roles' && isset($meta['roles'])) {
                    $rules[$cap_name]['items'] = $meta['roles'];
                } else if ($rules[$cap_name]['type'] == 'user_id' && isset($meta['usernames'])) {
                    $rules[$cap_name]['items'] = $meta['usernames'];
                }
            }

            return $rules;
        }

        protected static function converted_item_key()
        { }

        public static function get_item_id($item, $type = 'topic')
        {
            if ($type == 'topic') {
                return $item->term_id;
            }

            return $item->ID;
        }

        public static function get_item_meta($item, $type = 'topic')
        {
            if ($type == 'topic') {
                $all_meta = get_term_meta($item->term_id, '_helpie_kb_options', true);
            } else {
                $all_meta = get_post_meta($item->ID, '_helpie_kb_post_options', true);
            }

            // error_log('$all_meta : ' . print_r($all_meta, true));
            return $all_meta;
        }
    }
}