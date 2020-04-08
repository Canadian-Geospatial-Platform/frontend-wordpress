<?php

namespace Helpie\Features\Components\Breadcrumbs;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Breadcrumbs\Breadcrumbs_Model')) {
    class Breadcrumbs_Model
    {
        public function __construct()
        {
            $this->helpie_model = new \Helpie\Includes\Core\Core_Models\Helpie_Model();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function get_viewProps($args = array())
        {

            // First Layer: Fill with defaults
            $viewProps = $this->get_default_args();

            if (isset($args) && is_array($args)) {
                $viewProps = array_merge($viewProps, $args);
            }

            return $viewProps;
        }


        public function get_default_args()
        {
            $args = $this->get_manual_default_args();

            // Second Layer: Helpie Settings Values
            // $view_settings = $this->get_settings();

            // $args = array_merge($args, $view_settings);

            return $args;
        }


        public function get_settings()
        {
            $settings = array(
                'label' => $this->settings->single_page->get_voting_label(),
                'voting_template' =>  $this->settings->single_page->get_voting_template()

            );

            return $settings;
        }

        public function get_manual_default_args()
        {
            $args = array();

            // Get Default Values from GET - FIELDS
            $fields = $this->get_fields();
            foreach ($fields as $key => $field) {
                $args[$key] = $field['default'];
            }

            return $args;
        }

        public function get_fields()
        {
            $fields = array(
                'label' => $this->get_label_field(),
                // 'voting_template' => $this->get_voting_template_field(),
            );

            return $fields;
        }

        // FIELDS
        protected function get_label_field()
        {
            return array(
                'name' => 'label',
                'label' => __('Label', 'pauple-helpie'),
                'default' => __('How did you like this article?', 'pauple-helpie'),
                'type' => 'text',
            );
        }

        public function get_style_config()
        {
            $style_config = array(

                'element' => array(
                    'name' => 'helpie_element',
                    'selector' => '.pauple_helpie_breadcrumbs',
                    'label' => __('Breadcrumbs Container', 'elementor'),
                    'styleProps' => array('text-align', 'background', 'border', 'border_radius', 'padding', 'margin'),
                    'children' => array(
                        'label' => array(
                            'name' => 'helpie_element_link',
                            'selector' => '.pauple_helpie_breadcrumbs a',
                            'label' => __('Link', 'pauple-helpie'),
                            'styleProps' => array('color', 'typography', 'text-align', 'padding'),
                        ),
                        'icon' => array(
                            'name' => 'helpie_element_icon',
                            'selector' => '.pauple_helpie_breadcrumbs .helpiekb_separator',
                            'label' => __('Voting Icon', 'pauple-helpie'),
                            'styleProps' => array('color', 'text-align'),
                        ),

                    ),
                ),
            );

            return $style_config;
        }

        public function get_info($post_id, $page)
        {
            $breadcrumbs_info = array();

            $mp_hero_section_order = $this->settings->main_page->mp_hero_section_order();
            $breadcrumbs_info['post_type'] = array(
                'permalink' => $this->helpie_model->get_mainpage_permalink(),
                'title' => $mp_hero_section_order['kb_main_title'],
            );

            $taxonomy = 'helpdesk_category';
            if ($page == 'archive') {
                $queried_object = get_queried_object();

                $term_id = isset($queried_object->term_id) ? $queried_object->term_id : false;
                if ($term_id) {
                    $term = get_term($term_id);
                    $breadcrumbs_info['term'] = $this->get_term_info($term);
                    $breadcrumbs_info['parent_term'] = $this->get_parent_of_term($term);
                }
            } else {
                $breadcrumbs_info['parent_term'] = $this->get_parent_term_of_post($post_id, $taxonomy);
                $breadcrumbs_info['term'] = $this->get_term_of_post($post_id, $taxonomy);
                $breadcrumbs_info['post'] = $this->get_post_info($post_id);
            }

            return $breadcrumbs_info;
        }

        private function get_term_info($term)
        {
            return array(
                'permalink' => get_term_link($term),
                'title' => $term->name,
            );
        }
        private function get_post_info($post_id)
        {
            $post = get_post($post_id);
            $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($post);
            return  array(
                'permalink' => get_post_permalink($post_id),
                'title' => $kb_article->get_title(),
            );
        }

        private function get_parent_term_of_post($post_id, $taxonomy)
        {
            $parent_term_info = array();
            $terms = wp_get_post_terms($post_id, $taxonomy);

            $primary_term = $this->get_primary_term($post_id, $taxonomy);

            if (isset($primary_term) && !empty($primary_term)) {
                $term = get_term_by('id', $primary_term, $taxonomy);
                $parent_term_info = $this->get_parent_of_term($term);
            }

            foreach ($terms as $term) {
                $parent_term_info = $this->get_parent_of_term($term);
                break;
            }

            return $parent_term_info;
        }

        private function get_parent_of_term($term)
        {
            $parent_term_info = [];
            if (isset($term) && isset($term->parent) && !empty($term->parent) && $term->parent != 0) {
                $parent_term_id = $term->parent;
                $parent_term = get_term($parent_term_id, 'helpdesk_category');
                $parent_term_info = $this->get_term_info($parent_term);
            }

            return $parent_term_info;
        }

        private function get_term_of_post($post_id, $taxonomy)
        {
            $term_info = array();
            $terms = wp_get_post_terms($post_id, $taxonomy);
            $primary_term_id = $this->get_primary_term($post_id, $taxonomy);

            // Term from Yoast
            if (isset($primary_term_id) && !empty($primary_term_id)) {
                $primary_term = get_term_by('id', $primary_term_id, $taxonomy);
                return $term_info = $this->get_term_info($primary_term);
            }

            // First Term of n terms
            foreach ($terms as $term) {
                $term_info = $this->get_term_info($term);
                break;
            }

            return $term_info;
        }

        private function get_primary_term($post_id, $taxonomy)
        {
            $primary_term = get_post_meta($post_id, '_yoast_wpseo_primary_' . $taxonomy, true);
            $terms = $this->get_terms($post_id, $taxonomy);

            if (!in_array($primary_term, wp_list_pluck($terms, 'term_id'))) {
                $primary_term = false;
            }

            $primary_term = (int) $primary_term;
            return ($primary_term) ? ($primary_term) : false;
        }

        private function get_terms($post_id, $taxonomy)
        {
            $terms = get_the_terms($post_id, $taxonomy);

            if (!is_array($terms)) {
                $terms = array();
            }

            return $terms;
        }
    } // End of Class
}
