<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Search')) {
    class Search
    {
        public function __construct()
        {
            // $this->options = get_option('helpie_sp_options');
            $this->options = get_option('helpie-kb'); // unique id of the framework
        }

        public function get_settings()
        {

            $settings = [];

            $fields = $this->get_fields();
            foreach ($fields as $key => $field) {

                if (isset($this->options[$field['codestar_id']])) {
                    $settings[$key] = $this->options[$field['codestar_id']];
                } else {
                    // default
                    $settings[$key] = $field['default'];
                }
            }

            return $settings;
        }

        public function get_fields()
        {
            $fields = array(
                'placeholder_text' => array(
                    'default' => true,
                    'type' => 'text',
                    'codestar_id' => 'helpie_search_placeholder_text'
                ),
                'no_query_text' => array(
                    'default' => true,
                    'type' => 'text',
                    'codestar_id' => 'search_no_query_text'
                ),

                'empty_search_result_label' => array(
                    'default' => true,
                    'type' => 'text',
                    'codestar_id' => 'empty_search_result_label'
                ),

                'featured_image_show' => array(
                    'default' => true,
                    'type' => 'text',
                    'codestar_id' => 'helpie_search_page_featured_image_show'
                ),
                'description_show' => array(
                    'default' => true,
                    'type' => 'text',
                    'codestar_id' => 'helpie_search_page_description_show'
                ),
                'meta_data_show' => array(
                    'default' => true,
                    'type' => 'text',
                    'codestar_id' => 'helpie_search_page_meta_data_show'
                ),

                'tags_show' => array(
                    'default' => true,
                    'type' => 'text',
                    'codestar_id' => 'helpie_search_page_tags_show'
                ),

                'description_length' => array(
                    'default' => true,
                    'type' => 'text',
                    'codestar_id' => 'helpie_search_page_description_length'
                ),
            );

            return $fields;
        }
    } // END CLASS
}