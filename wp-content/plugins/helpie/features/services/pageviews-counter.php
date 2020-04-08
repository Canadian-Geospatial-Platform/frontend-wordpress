<?php

namespace Helpie\Features\Services;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Services\Pageviews_Counter')) {
    class Pageviews_Counter
    {
        private $views;

        public function __construct()
        {
        }

        public function get_pageviews($post_id)
        {
            $pageviews = 0;

            if (get_post_meta($post_id, 'ph_pageviews', true) != null) {
                $pageviews = intval(get_post_meta($post_id, 'ph_pageviews', true));
            }
            return $pageviews;
        }

        public function update_pageviews($post_id)
        {
            $pageviews = $this->get_pageviews($post_id);
            $new_pageviews = (int) $pageviews + 1;
            update_post_meta($post_id, 'ph_pageviews', $new_pageviews);
        }
    } // END CLASS
}