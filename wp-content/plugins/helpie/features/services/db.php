<?php

/**
 * Implements WPDB Queries directly
 *
 * @package    helpie-kb
 * @subpackage services
 * @author     essekia
 * @version    1.9.1
 * ...
 */

namespace Helpie\Features\Services;

use PhpParser\Builder\Property;

if (!class_exists('\Helpie\Features\Services\DB')) {
    class DB
    {

        // Hold the class instance.
        private static $instance = null;
        private static $post_meta = null;
        private static $term_meta = null;

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
                self::$instance = new \Helpie\Features\Services\DB();
            }

            return self::$instance;
        }

        public static function get_post_meta()
        {

            if (isset(self::$post_meta) && is_array(self::$post_meta)) {
                return self::$post_meta;
            }

            global $wpdb;
            $meta_key = '_helpie_kb_post_options';
            $all_metas = $wpdb->get_results($wpdb->prepare(
                "
                    SELECT meta_value, post_id
                    FROM $wpdb->postmeta 
                    WHERE meta_key = %s
                ",
                $meta_key
            ));

            self::$post_meta = [];
            foreach ($all_metas as $key => $value) {
                self::$post_meta[$value->post_id] = unserialize($value->meta_value);
            }
            // error_log('self::$post_meta : ' . print_r(self::$post_meta, true));
            return self::$post_meta;
        }

        public function get_term_meta()
        {

            if (isset(self::$term_meta) && is_array(self::$term_meta)) {
                return self::$term_meta;
            }

            global $wpdb;
            $meta_key = '_helpie_kb_options';
            $all_metas = $wpdb->get_results($wpdb->prepare(
                "
                    SELECT meta_value, term_id
                    FROM $wpdb->termmeta 
                    WHERE meta_key = %s
                ",
                $meta_key
            ));

            self::$term_meta = [];
            foreach ($all_metas as $key => $value) {
                self::$term_meta[$value->term_id] = unserialize($value->meta_value);
            }
            // error_log('self::$term_meta  : ' . print_r(self::$term_meta , true));
            return self::$term_meta;
        }
    }
}