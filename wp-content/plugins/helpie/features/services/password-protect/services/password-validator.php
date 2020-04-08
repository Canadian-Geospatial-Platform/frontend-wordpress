<?php

namespace Helpie\Features\Services\Password_Protect\Services;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Services\Password_Protect\Services\Password_Validator')) {
    class Password_Validator
    {

        public function validate($args)
        {
            error_log('validate args: ' . print_r($args, true));
            $result = array(
                'output' => 'wrong-password',
                'value' => '',
                'is_correct_password' => false,
            );

            $result = $this->check_password_for_all($args, $result);
            error_log('result: ' . print_r($result, true));
            $result = $this->check_password_for_term_id($args, $result);
            error_log('result: ' . print_r($result, true));
            $result = $this->validate_based_on_origin_destination($args, $result);
            error_log('result: ' . print_r($result, true));

            return $result;
        }

        public function check_password_for_all($args, $result)
        {
            if (isset($args['protected_terms']['all']) && !empty($args['protected_terms']['all'])) {
                $result['value'] = $this->fix_password_value_datatype($args['protected_terms']['all']);
                $result['is_correct_password'] = ($result['value'] == $args['password_input']);
            }

            return $result;
        }

        public function validate_based_on_origin_destination($args, $result)
        {
            $term_id = $args['term_id'];

            if (!$result['is_correct_password']) {
                return $result;
            }

            $destination = $args['destination'];

            $is_search_or_single_page_origin = ($args['origin_location'] == 'single-page' || $args['origin_location'] == 'search-page');
            if ($destination == 'single-page' || isset($args['origin_location']) && ($is_search_or_single_page_origin)) {
                $result['output'] = get_permalink($args['post_id']);
            } else {
                $taxonomy = 'helpdesk_category';
                $term = get_term($term_id, $taxonomy);
                $term_link = get_term_link($term);
                $result['output'] = $term_link;
            }

            return $result;
        }

        public function check_password_for_term_id($args, $result)
        {
            $term_id = $args['term_id'];

            if ($result['is_correct_password'] == true || !isset($args['protected_terms'][$term_id]) || empty($args['protected_terms'][$term_id])) {
                return $result;
            }

            $term_password = $args['protected_terms'][$term_id];
            foreach ($term_password as $key => $value) {
                $result['value'] = $this->fix_password_value_datatype($value);
                $result['is_correct_password'] = ($value == $args['password_input']);
                if ($result['is_correct_password']) {
                    break;
                }
            }

            return $result;

        }

        // Fixes issue where the password value is sometimes stored as array
        // and sometimes string
        public function fix_password_value_datatype($value)
        {
            if (is_array($value)) {
                $value_array = $value;
                $value = '';
                $value = $value_array[0];
            }

            return $value;
        }
    }
}