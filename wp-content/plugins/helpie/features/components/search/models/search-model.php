<?php

namespace Helpie\Features\Components\Search\Models;

use \Helpie\Features\Components\Search\Models\Search_Query;

if (!class_exists('\Helpie\Features\Components\Search\Models\Search_Model')) {
    class Search_Model extends Search_Query
    {

        public function __construct()
        {
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function get_viewProps($args)
        {
            $collectionProps = $this->get_collectionProps($args);
            $view_props = array(
                'collection' => $collectionProps,
                'items' => $this->get_items_props($collectionProps),
            );

            return $view_props;
        }

        protected function get_collectionProps($args = array())
        {
            $default_args = $this->get_default_args($args);
            $args = array_merge($default_args, $args);

            $args = $this->get_interpreted_props($args);

            return $args;
        }

        public function get_default_args()
        {
            $args = $this->get_manual_default_args();

            // Second Layer: Helpie Settings Values
            $view_settings = $this->get_settings();

            $args = array_merge($args, $view_settings);

            return $args;
        }

        public function get_settings()
        {
            // $settings = array(
            //     'label' => $this->settings->single_page->get_voting_label(),
            //     'voting_template' =>  $this->settings->single_page->get_voting_template()
            // );

            $settings = $this->settings->search->get_settings();

            return $settings;
        }

        public function get_fields()
        {
            $fields = array(
                'range' => array(
                    'name' => 'range',
                    'label' => __('Range', 'pauple-helpie'),
                    'default' => __(3, 'pauple-helpie'),
                    'type' => 'number'
                ),
                'posts_per_page' => array(
                    'name' => 'posts_per_page',
                    'label' => __('Posts Per Page', 'pauple-helpie'),
                    'default' => __(10, 'pauple-helpie'),
                    'type' => 'number'
                ),
                'no_query_text' => array(
                    'name' => 'label',
                    'label' => __('No Search Query Label', 'pauple-helpie'),
                    'default' => __('Please search something!', 'pauple-helpie'),
                    'type' => 'text',
                ),
                'empty_search_result_label' => array(
                    'name' => 'label',
                    'label' => __('Empty Search Result Label', 'pauple-helpie'),
                    'default' => __('Did not match any articles !', 'pauple-helpie'),
                    'type' => 'text',
                ),
            );

            return $fields;
        }


        public function get_manual_default_args($args = array())
        {
            $args = array();

            // Get Default Values from GET - FIELDS
            $fields = $this->get_fields();
            foreach ($fields as $key => $field) {
                $args[$key] = $field['default'];
            }

            return $args;
        }



        public function get_style_config()
        {
            $style_config = array(

                'element' => array(
                    'name' => 'helpie_element',
                    'selector' => '.helpie-search-listing',
                    'label' => __('Search Results Container', 'elementor'),
                    'styleProps' => array('text-align', 'background', 'border', 'border_radius', 'box_shadow', 'padding', 'margin'),
                    'children' => array(
                        'single_item' => array(
                            'name' => 'helpie_element_single_item',
                            'selector' => '.helpie-search-listing .item',
                            'label' => __('Single Result', 'pauple-helpie'),
                            'styleProps' => array('text-align', 'background', 'border', 'border_radius', 'box_shadow', 'padding', 'margin'),
                        ),
                        'header' => array(
                            'name' => 'helpie_element_header',
                            'selector' => '.helpie-search-listing .item-content .header',
                            'label' => __('Header', 'pauple-helpie'),
                            'styleProps' => array('text-align', 'color', 'typography', 'padding', 'margin'),
                        ),
                        'post_title' => array(
                            'name' => 'helpie_element_post_title',
                            'selector' => '.helpie-search-listing .item-content .header .item-title',
                            'label' => __('Post Title', 'pauple-helpie'),
                            'styleProps' => array('color', 'typography', 'text-align'),
                        ),
                        'category_name' => array(
                            'name' => 'helpie_element_cat_name',
                            'selector' => '.helpie-search-listing .item-content .header span.item-cat_name',
                            'label' => __('Category Name', 'pauple-helpie'),
                            'styleProps' => array('color', 'typography', 'text-align'),
                        ),
                        'category_name' => array(
                            'name' => 'helpie_element_cat_name',
                            'selector' => '.helpie-search-listing .item-content .header span.item-cat_name',
                            'label' => __('Category Name', 'pauple-helpie'),
                            'styleProps' => array('color', 'typography', 'text-align'),
                        ),
                        'meta_icon' => array(
                            'name' => 'helpie_element_meta_icon',
                            'selector' => '.helpie-search-listing .item-content .meta i',
                            'label' => __('Meta Icons', 'pauple-helpie'),
                            'styleProps' => array('text-align', 'color', 'padding', 'margin'),
                        ),
                        'meta_value' => array(
                            'name' => 'helpie_element_meta_value',
                            'selector' => '.helpie-search-listing .item-content .meta .meta-value',
                            'label' => __('Meta Values', 'pauple-helpie'),
                            'styleProps' => array('text-align', 'color', 'padding', 'margin'),
                        ),
                        'excerpt' => array(
                            'name' => 'helpie_element_excerpt',
                            'selector' => '.helpie-search-listing .item-content .description',
                            'label' => __('Excerpt', 'pauple-helpie'),
                            'styleProps' => array('text-align', 'color', 'typography', 'padding', 'margin'),
                        ),


                    ),
                ),
            );

            return $style_config;
        }





        protected function get_interpreted_props($args)
        {
            $search_query = $this->get_search_input_query();

            $args['search_query'] = $search_query;
            $args['total_posts'] = $this->get_total_posts($search_query);
            $args['current_page'] = $this->get_current_page();

            return $args;
        }

        protected function get_items_props($collectionProps)
        {
            $search_query = $this->get_search_input_query();
            return $this->get_search_results($search_query, $collectionProps);
        }

        protected function get_total_posts($input_query)
        {
            $resultOfQuery = $this->get_advanced_search($input_query);
            $total_posts = count($resultOfQuery);

            return $total_posts;
        }

        protected function get_current_page()
        {
            $current_page = 1;
            if (isset($_GET['page'])) {
                $page_query_var = sanitize_text_field(htmlspecialchars($_GET['page']));
                $queried_page_value = str_replace("p", "", $page_query_var);
                if ($queried_page_value > 0) {
                    $current_page = $queried_page_value;
                }
            }
            return $current_page;
        }

        protected function get_search_input_query()
        {
            if (isset($_GET['search'])) {
                return sanitize_text_field($_GET['search']);
            }
        }

        public function get_autosuggest($input_query)
        {
            $input_query = trim($input_query);
            $resultOfQuery = "";
            if (strlen($input_query) > 0) {
                $resultOfQuery = $this->get_advanced_search($input_query);
                $resultOfQuery = $this->get_truncated_content($input_query, $resultOfQuery, true);
            }
            return $resultOfQuery;
        }

        public function get_search_results($input_query, $collectionProps)
        {
            $resultOfQuery = $this->get_advanced_search($input_query);
            $resultOfQuery = $this->get_truncated_content($input_query, $resultOfQuery, false);
            if (!empty($input_query)) {
                $resultOfQuery = $this->get_highlight_result($resultOfQuery);
            }

            $resultOfQuery = $this->get_paginate_results($collectionProps, $resultOfQuery);

            return $resultOfQuery;
        }

        protected function get_paginate_results($collectionProps, $resultOfQuery)
        {
            if ($collectionProps['total_posts'] > 0) {
                $start_from = ($collectionProps['posts_per_page'] * ($collectionProps['current_page'] - 1));
                $resultOfQuery = array_slice($resultOfQuery, $start_from, $collectionProps['posts_per_page']);
            }

            return $resultOfQuery;
        }
        protected function get_highlight_result($resultOfQuery)
        {
            foreach ($resultOfQuery as $key => $value) {
                $resultOfQuery[$key]['title'] = $this->get_highlighted($resultOfQuery[$key]['title']);
                $resultOfQuery[$key]['content'] = $this->get_highlighted($resultOfQuery[$key]['content']);
                $resultOfQuery[$key]['category'] = $this->get_highlighted($resultOfQuery[$key]['category']);
                $resultOfQuery[$key]['tags'] = $this->get_highlighted($resultOfQuery[$key]['tags']);
            }

            return $resultOfQuery;
        }

        protected function get_highlighted($subject)
        {
            $input_query = $this->get_search_input_query();
            $pattern = '/' . $input_query . '/i';
            $replace = '<strong>' . $input_query . '</strong>';

            $highlighted = preg_replace($pattern, $replace, $subject);

            return $highlighted;
        }

        public function get_advanced_search($input_query)
        {
            $resultOfQuery = $this->get_results_query($input_query);
            $resultOfQuery = $this->get_serp_score($input_query, $resultOfQuery);
            $resultOfQuery = array_values($resultOfQuery);

            return $resultOfQuery;
        }

        public function get_results_query($input_query)
        {
            global $wpdb; // this is how you get access to the database

            $category_repo = new \Helpie\Features\Domain\Repositories\Category_Repository();
            $mainpage_category = $category_repo->get_mainpage_category();

            $args = $this->get_visible_search_args($input_query, $mainpage_category);
            $result_tags = $this->get_tags_like($input_query);
            $result_categories = $this->get_categories_like($input_query);
            $resultOfQuery = $this->get_query($args);
            $resultOfQuery = array_unique(array_merge($resultOfQuery, $result_tags, $result_categories), SORT_REGULAR);

            return $resultOfQuery;
        }

        protected function get_serp_score($input_query, $resultOfQuery)
        {
            $serp_model = new \Helpie\Features\Components\Search\Models\SERP_Model();
            $input_keyword_array = explode(' ', $input_query);

            for ($ii = 0; $ii < sizeof($input_keyword_array); $ii++) {
                $resultOfQuery = $serp_model->get_title_based_point($input_keyword_array[$ii], $resultOfQuery);
                $resultOfQuery = $serp_model->get_content_based_point($input_keyword_array[$ii], $resultOfQuery);
                $resultOfQuery = $serp_model->get_category_based_point($input_keyword_array[$ii], $resultOfQuery);
                $resultOfQuery = $serp_model->get_tags_based_point($input_keyword_array[$ii], $resultOfQuery);
            }
            return $resultOfQuery;
        }

        protected function get_truncated_content($input_query, $resultOfQuery, $is_autosuggest)
        {
            foreach ($resultOfQuery as $key => $value) {

                $content = $resultOfQuery[$key]['content'];
                $content = wp_strip_all_tags(strip_shortcodes($content));
                if ($is_autosuggest == true) {
                    $content = $this->explode_content($content, 150);
                } else {
                    $content = $this->explode_content($content);
                }

                $content = $this->get_matched_content($content, $input_query);

                $resultOfQuery[$key]['content'] = $content;
            }

            return $resultOfQuery;
        }

        protected function get_matched_content($content, $input_query)
        {
            if (isset($input_query) && !empty($input_query)) {
                foreach ($content as $content_key => $content_value) {
                    $pos = stripos($content_value, $input_query);
                    if ($pos !== false) {
                        $content = $content_value;
                        break;
                    } else {
                        $content = $content_value;
                    }
                }
            } else {
                $content = $content[0];
            }

            return $content;
        }

        protected function get_substring($content, $start, $length = null)
        {
            if (function_exists('mb_substr')) {
                $sub_string = mb_substr($content, $start, $length, "utf-8");
            } else {
                $sub_string = substr($content, $start, $length);
            }

            return $sub_string;
        }

        protected function explode_content($content, $max_size = 350)
        {
            $parts = array();
            $prefix = '';

            while (true) {
                $content = trim((string)$content);
                if (strlen($content) <= $max_size) {
                    $parts[] = $prefix . $content;
                    break;
                }

                $offset = -(strlen($content) - $max_size);
                $cut_at_position = strrpos($content, ' ', $offset);
                if (false === $cut_at_position) {
                    $cut_at_position = $max_size;
                }
                $parts[] = $prefix . $this->get_substring($content, 0, $cut_at_position);
                $content = $this->get_substring($content, $cut_at_position);
                $prefix = '… ';
            }

            return $parts;
        }
    }
}