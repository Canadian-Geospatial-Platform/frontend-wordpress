<?php

namespace Helpie\Includes;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Services')) {
    class Services
    {
        public function update_category_order($dnd_terms)
        {
            $order_count = 0;

            if (isset($dnd_terms['enabled']) && !empty($dnd_terms['enabled'])) {
                foreach ($dnd_terms['enabled'] as $key => $term) {
                    $term_id = str_replace('term-id_', '', $key);
                    update_term_meta($term_id, 'term_order', $order_count);
                    $order_count++;
                }
            }

            update_option('helpie_kb_category_last_order', $order_count);
        }
    } // END CLASS
}
