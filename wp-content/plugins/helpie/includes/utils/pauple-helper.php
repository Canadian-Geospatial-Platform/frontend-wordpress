<?php

namespace Helpie\Includes\Utils;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Utils\Pauple_Helper')) {
    class Pauple_Helper
    {




        public function is_post_type($post_id = 0)
        {
            $my_post_type = 'pauple_helpie';

            if ($post_id != 0) {
                $myPost = get_post($post_id);
                $post_type = get_post_type($post_id);
            } else {
                global $post;
                $post_type = $post->post_type;
            }

            if ($post_type == $my_post_type) {
                return true;
            }

            return false;
        }

        // determine the topmost parent of a term
        public function get_term_top_most_parent($term_id, $taxonomy)
        {

            if (!isset($term_id) || $term_id == '') {
                return $term_id;
            }

            // Start from the current term
            $parent = get_term_by('id', $term_id, $taxonomy);

            // error_log('$parent : ' . print_r($parent, true));
            if (!is_object($parent)) {
                return $term_id;
            }
            // Climb up the hierarchy until we reach a term with parent = '0'
            while ($parent->parent != '0') {
                $term_id = $parent->parent;
                $parent = get_term($term_id, $taxonomy);
            }

            return $parent->term_id;
        }

        public function helpie_error_log($value = null)
        {
            if (is_object($value)) {
                ob_start(); // start buffer capture
                var_dump($value); // dump the values
                $contents = ob_get_contents(); // put the buffer into a variable
                ob_end_clean(); // end capture
                error_log($contents); // log contents of the result of var_dump( $object )
            } elseif (is_array($value)) {
                error_log(print_r($value, true));
            } else {
                error_log($value);
            }
        }

        public function is_value_in_given_array($value, $array)
        {
            // 1. If not correct dataType, return false
            if (!$this->is_valid_array($array)) {
                return false;
            }

            // 2. True condition
            if (in_array($value, $array)) {
                return true;
            }

            return false;
        }

        public function is_valid_array($array)
        {
            // 1. If not correct dataType, return false
            if (isset($array) && is_array($array) && !empty($array)) {
                return true;
            }

            return false;
        }

        public function is_assoc(array $arr)
        {
            if (array() === $arr) {
                return false;
            }

            return array_keys($arr) !== range(0, count($arr) - 1);
        }

        // programmatically create some basic pages, and then set Home and Blog
        // setup a function to check if these pages exist
        public function the_slug_exists($post_name)
        {
            global $wpdb;
            if ($wpdb->get_row("SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "'", 'ARRAY_A')) {
                return true;
            } else {
                return false;
            }
        }

        public function numeric_processing($num_of_cols)
        {
            if ($num_of_cols == '1' || $num_of_cols == 'one') {
                return 'one';
            } elseif ($num_of_cols == '2' || $num_of_cols == 'two') {
                return 'two';
            } elseif ($num_of_cols == '3' || $num_of_cols == 'three') {
                return 'three';
            } elseif ($num_of_cols == '4' || $num_of_cols == 'four') {
                return 'four';
            } else {
                return 'three';
            }
        }

        public function create_wp_page($page_slug, $page_title, $page_content)
        {
            // create the blog page
            // error_log('activated: ' . $_GET['activated']);
            if (!is_admin()) {
                return 0;
            }

            $page_check = get_page_by_title($page_title);

            if (isset($page_check->ID) || $this->the_slug_exists($page_slug)) {
                return 0;
            }

            $page = array(
                'post_type' => 'page',
                'post_title' => $page_title,
                'post_content' => $page_content,
                'post_status' => 'publish',
                'post_author' => 1,
                'post_slug' => $page_slug,
            );
            $page_id = wp_insert_post($page);
            return $page_id;
        }

        public function create_new_post_with_meta($new_ticket_info, $post_type, $new_ticket_meta_info)
        {
            $my_post = array(
                'post_title' => $new_ticket_info['title'],
                'post_content' => $new_ticket_meta_info['message'],
                'post_status' => 'publish',
                'post_author' => $new_ticket_info['post_author'],
                'post_type' => $post_type,
            );

            // Insert the post into the database
            $post_id = wp_insert_post($my_post);

            $messages = array(
                0 => array(
                    'posted_by' => $new_ticket_info['post_author'],
                    'posted_date' => current_time('timestamp'),
                    'content' => $new_ticket_meta_info['message'],
                ),
            );

            //  $new_ticket_meta_keys = array('type', 'status', 'priority', 'dept', 'messages', 'mode', 'for_customer', 'support_agent');

            foreach ($new_ticket_meta_info as $key => $value) {
                $meta_key = $key;
                if ($key == 'message') {
                    $meta_key = 'messages';
                    add_post_meta($post_id, 'ticket-' . $meta_key, $messages, true);
                } else {
                    add_post_meta($post_id, 'ticket-' . $meta_key, $new_ticket_meta_info[$meta_key], true);
                }
            }

            error_log('create_new_post_with_meta: post_id --- ' . $post_id);
            return $post_id;
        }

        public function secondsToWords($seconds)
        {
            $ret = "";

            /*** get the days ***/
            $days = intval(intval($seconds) / (3600 * 24));
            if ($days > 0) {
                $ret .= "$days days ";
            }

            /*** get the hours ***/
            $hours = (intval($seconds) / 3600) % 24;
            if ($hours > 0) {
                $ret .= "$hours hours ";
            }

            /*** get the minutes ***/
            $minutes = (intval($seconds) / 60) % 60;
            if ($minutes > 0) {
                $ret .= "$minutes minutes ";
            }

            // If the reponse time is less than a minute
            if (($days <= 0) && ($hours <= 0) && ($minutes <= 0)) {
                /*** get the seconds ***/
                $seconds = intval($seconds) % 60;
                if ($seconds > 0) {
                    $ret .= "$seconds seconds";
                }
            }

            $ret = trim($ret);
            return $ret;
        }

        /* Optimized to solve issue when it's an ajax call */
        public function check_if_user_is_admin()
        {
            if (!is_user_logged_in()) {
                return false;
            }

            $user = wp_get_current_user();

            if (in_array('administrator', (array)$user->roles)) {
                return true;
            }
        }


        public function get_post_id($wp_obj)
        {
            if (isset($wp_obj) && $wp_obj != null) {
                $post = $wp_obj;
                $post_id = $post->ID;
            } else {
                $post_id = get_the_ID();
            }

            return $post_id;
        }
    } // End of Class
}