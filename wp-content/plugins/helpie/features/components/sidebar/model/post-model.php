<?php

namespace Helpie\Features\Components\Sidebar\Model;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


if (!class_exists('\Helpie\Features\Components\Sidebar\Model\Post_Model')) {
    class Post_Model
    {
        public function __construct()
        {
            $this->category_repo = new \Helpie\Features\Domain\Repositories\Category_Repository();
        }

        public function is_current_post($post_id)
        {
            $is_current_post = false;
            $current_post_info = $this->get_current_post_info();

            if (isset($current_post_info) && !empty($current_post_info)) {
                if (isset($current_post_info['post_id']) && ($current_post_info['post_id'] == $post_id)) {
                    $is_current_post = true;
                }
            }

            return $is_current_post;
        }

        public function get_current_post_info()
        {
            if (!isset($current_post_info)) {
                $current_post_info = array();
            }

            if (is_post_type_archive('pauple_helpie')) {
                $current_post_info['page_type'] = 'main';
            } elseif (is_singular('pauple_helpie') && is_single(get_the_ID())) {
                $current_post_info['post_id'] = get_the_ID();
                // $terms = array();
                $terms = get_the_terms(get_the_ID(), 'helpdesk_category');
                $current_post_info['term'] = array();

                if (isset($terms) && !empty($terms)) {
                    foreach ($terms as $term) {
                        $current_post_info['term'] = array(
                            'term_id' => $term->term_id,
                            'name' => $term->name,
                        );
                        break;
                    }

                    $term_id = $term->term_id;

                    // echo "term_id: " . $term->term_id;
                    $current_post_info['top_most_term_id'] = $this->category_repo->get_top_most_parent_term_id($term_id, 'helpdesk_category');
                    $current_post_info['lineage'] = $this->get_term_lineage($term_id);
                }
            } elseif (is_tax("helpdesk_category")) {
                $term_id = get_queried_object()->term_id;
                if (isset($term_id) && $term_id != 0) {
                    $current_post_info['top_most_term_id'] = $this->category_repo->get_top_most_parent_term_id($term_id, 'helpdesk_category');
                    $current_post_info['lineage'] = $this->get_term_lineage($term_id);
                }
            }

            return $current_post_info;
        }

        protected function get_term_lineage($term_id)
        {
            $lineage = get_ancestors($term_id, 'helpdesk_category');

            array_push($lineage, $term_id);
            return $lineage;
        }

        public function is_top_level_article($child_terms_id_array, $taxonomy, $article)
        {
            if (has_term($child_terms_id_array, $taxonomy, $article) == null || has_term($child_terms_id_array, $taxonomy, $article)  == '') {
                return true;
            }

            if (has_term($child_terms_id_array, $taxonomy, $article) == false || empty($child_terms_id_array)) {
                return true;
            }

            return false;
        }
    }
}