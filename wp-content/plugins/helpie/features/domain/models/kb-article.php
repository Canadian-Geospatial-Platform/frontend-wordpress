<?php

namespace Helpie\Features\Domain\Models;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Domain\Models\Kb_Article')) {
    class Kb_Article
    {
        private $article;

        public function __construct($article)
        {
            $this->article = $article;
        }

        /* Revisions */

        public function get_revisions()
        {
            return wp_get_post_revisions($this->article->ID);
        }

        // The post object that can be published in the frontend
        public function get_published_post_object($post_id)
        {
            if (get_post_status($post_id) == 'awaiting') {
                $last_approved_revision = $this->get_last_approved_revision($post_id);
                if (isset($last_approved_revision) && $last_approved_revision != null) {
                    return $last_approved_revision;
                } else {
                    return get_post($post_id);
                }
            } else {
                return get_post($post_id);
            }
        }

        public function get_last_approved_revision($post_id)
        {
            $last_approved_revision_id = get_post_meta($post_id, 'last_approved_revision', true);
            $last_approved_revision = wp_get_post_revision($last_approved_revision_id);
            return $last_approved_revision;
        }

        /* Main */
        public function get_the_ID()
        {
            return $this->article->ID;
        }

        public function get_title()
        {
            $published_post = $this->get_published_post_object($this->article->ID);
            $post_title = $published_post->post_title;
            return ucfirst($post_title);
        }

        public function get_the_content()
        {
            $published_post = $this->get_published_post_object($this->article->ID);
            $content = $published_post->post_content;

            $content = wp_kses_post($content);
            // $content = sanitize_text_field($content);
            // $content = html_entity_decode($content);

            return $content;
        }

        public function get_tags_list()
        {
            $terms = get_the_terms($this->article->ID, 'helpie_tag');
            $terms_list = array();

            if (isset($terms) && !empty($terms)) {
                foreach ($terms as $term) {
                    array_push($terms_list, ucfirst($term->name));
                }
            }
            return $terms_list;
        }

        public function get_permalink()
        {
            return get_permalink($this->article->ID);
        }

        public function get_date()
        {
            $date = get_the_date('M jS y', $this->article->ID);
            $date = _x($date, 'Trasnlatable date');

            return $date;
        }

        public function get_category_id()
        {
            $terms = get_the_terms($this->article->ID, 'helpdesk_category');
            $term = $terms[0];
            if (isset($term)) {
                return $term->term_id;
            } else {
                return false;
            }
        }

        public function get_top_most_category_id()
        {
            $terms = get_the_terms($this->article->ID, 'helpdesk_category');
            $term = $terms[0];

            $term_id = $term->term_id;

            $top_most_term_id = $this->get_term_top_most_parent($term_id, 'helpdesk_category');
            return $top_most_term_id;
        }        

        // determine the topmost parent of a term
        public function get_term_top_most_parent($term_id, $taxonomy)
        {
            // start from the current term
            $parent = get_term_by('id', $term_id, $taxonomy);

            if (isset($parent) && !empty($parent)) {
                // climb up the hierarchy until we reach a term with parent = '0'
                while ($parent->parent != '0') {
                    $term_id = $parent->parent;
                    $parent = get_term_by('id', $term_id, $taxonomy);
                }
            }

            return $parent->term_id;
        }

        public function get_category_name()
        {
            $terms = get_the_terms($this->article->ID, 'helpdesk_category');
            $term = $terms[0];
            return $term->name;
        }

        public function get_thumbnail_url()
        {
            // $thumbnail_url = get_the_post_thumbnail_url($this->article->ID);
            $image_id = get_post_thumbnail_id($this->article->ID);
            $thumbnail_url = wp_get_attachment_url($image_id, 'medium');
            if (!isset($thumbnail_url) || empty($thumbnail_url)) {
                $thumbnail_url = plugins_url('includes/asset-files/images/article-cover-dummy.jpg', HELPIE_PLUGIN_FILE_PATH);
            }

            return $thumbnail_url;
        }

        public function get_author_name()
        {
            $author_id = $this->article->post_author;
            $author = get_userdata($author_id);

            if (isset($author) && !empty($author)) {
                return ucfirst($author->display_name);
            } else {
                return '';
            }
        }

        public function get_author_avatar_url()
        {
            $author_id = $this->article->post_author;
            return get_avatar_url($author_id);
        }

        public function get_read_time()
        {
            $content = $this->article->post_content;
            $words_per_min = 275; // Average WPM of a human
            $num_of_words = str_word_count($content);

            $read_time = ($num_of_words / $words_per_min);
            $read_time = ceil($read_time);

            $read_time_string = $read_time . __('min read', 'pauple_helpie');
            return $read_time_string;
        }

        public function get_post_image($size = 'medium')
        {
            return get_the_post_thumbnail($this->article->ID, $size);
        }

        public function get_category_image($size = 'medium')
        {
            $category_id = $this->get_category_id();
            $image_id = get_term_meta($category_id, 'category-image-id', true);

            return wp_get_attachment_image($image_id, $size);
        }

        public function get_fallback_image()
        {
            $fallback_img_src = plugins_url('includes/asset-files/images/article-cover-dummy.jpg', HELPIE_PLUGIN_FILE_PATH);

            return '<img src ="' . $fallback_img_src . '">';
        }

        public function get_image_as_fallback_manner()
        {
            if (!empty($this->get_post_image())) {
                return $this->get_post_image();
            } elseif (!empty($this->get_category_image())) {
                return $this->get_category_image();
            }

            return $this->get_fallback_image();
        }
    }
}