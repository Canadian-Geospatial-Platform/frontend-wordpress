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

if (!class_exists('\Helpie\Features\Services\DB_Old')) {
    class DB_Old
    {

        public function get_post_meta()
        {
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

            $items = [];
            foreach ($all_metas as $key => $value) {
                $items[$value->post_id] = unserialize($value->meta_value);
            }
            // error_log('$items : ' . print_r($items, true));
            return $items;
        }

        public function get_term_meta()
        {
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

            $items = [];
            foreach ($all_metas as $key => $value) {
                $items[$value->term_id] = unserialize($value->meta_value);
            }
            // error_log('$items : ' . print_r($items, true));
            return $items;
        }
    }
}