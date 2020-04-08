<?php

namespace Helpie\Features\Domain\Models;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Domain\Models\Kb_Category')) {
    class Kb_Category
    {
        public $term_id;

        public $taxonomy = 'helpdesk_category';      

        public function __construct($category)
        {
            $this->articles_query = new \Helpie\Features\Domain\Query\Articles_Model();
            $this->category = $category;
            $this->slug = $this->category->slug;
            $this->name = $this->category->name;
            $this->parent = $this->category->parent;
            $this->term_id = $this->category->term_id;
           
            // get_direct_child of category.
            $this->child = $this->get_child_category();
        }
        public function get_category_link()
        {
            return get_term_link($this->category);
        }

        public function get_category_description()
        {
            $description = term_description($this->term_id, $this->taxonomy);
            $description_formatted = $description;

            return $description_formatted;
        }

        public function get_count()
        {
            return $this->category->count;
        }

        public function get_child_category()
        {
            $child = array();
            $child_object = get_terms($this->taxonomy, ['parent' => $this->term_id]);
            foreach ($child_object as $children) {
                array_push($child, $children->term_id);
            }

            return $child;
        }

        public function get_child_category_count()
        {
            $child_terms = get_term_children($this->term_id, $this->taxonomy);
            return sizeof($child_terms);
        }

        public function get_icon()
        {
            $term_id = $this->term_id;            
            $icon = get_term_meta($term_id, 'helpie-category-icon', true);

            $icon = ($icon)?"<i class='fa ".$icon."'></i>" : "<i class='fa fa-circle-o-notch'></i>";
            return $icon;
        }

        public function get_icon_code()
        {
            $term_id = $this->term_id;            
            $icon_code = get_term_meta($term_id, 'helpie-category-icon', true);

            return ($icon_code)?$icon_code : "fa-circle-o-notch";            
        }

        public function get_image($size = 'medium')
        {
            $image_id = get_category_image_id($this->term_id);
            return wp_get_attachment_image($image_id, $size);
        }

        public function get_top_level_articles($limit = 5)
        {
            $articles = $this->get_articles_of_term($limit);
            $child_terms_id_array = $this->get_child_categories();

            $article_count = 0;
            $top_level_articles = array();

            foreach ($articles as $article) {
                if ($this->is_top_level_article($child_terms_id_array, $this->taxonomy, $article)) {
                    if ($limit != '-1' && $article_count >= $limit) {
                        break;
                    }
                    array_push($top_level_articles, $article);
                }
                $article_count++;
            }

            return $top_level_articles;
        }

        // determine the topmost parent of a term
        public function get_term_top_most_parent($term_id)
        {
            // start from the current term
            $parent = get_term_by('id', $term_id, $this->taxonomy);

            if (!isset($parent) || empty($parent)) {
                return $parent->term_id;
            }

            // climb up the hierarchy until we reach a term with parent = '0'
            while ($parent->parent != '0') {
                $term_id = $parent->parent;
                $parent = get_term_by('id', $term_id, $this->taxonomy);
            }

            return $parent->term_id;
        }

        public function get_child_categories()
        {

            $args = array(
                "taxonomy" => $this->taxonomy,
                // "hide_empty" => 1,
                "parent" => $this->term_id,
            );

            $child_categories = get_terms($args);
            $child_category_ids = array();
            $child_category_ids = array_map(function ($term) {
                return $term->term_id;
            }, $child_categories);

            return $child_category_ids;
        }

        public function get_child_categories_wpobjects()
        {
            $children_array = array();

            $term_children = $this->get_child_categories();

            foreach ($term_children as $child_id) {
                $term = get_term_by('id', $child_id, $this->taxonomy);
                array_push($children_array, $term);
            }

            return $children_array;
        }

        public function get_articles_of_term($limit, $include_children = false)
        {
            // error_log('$this->category : ' . print_r($this->category, true));
            return $this->articles_query->get_articles_of_term($this->category, $include_children, $limit);
        }

        // NOTE: Consider moving to KB_Article
        public function is_top_level_article($child_terms_id_array, $taxonomy, $article)
        {
            if (has_term($child_terms_id_array, $taxonomy, $article) == null || has_term($child_terms_id_array, $taxonomy, $article) == '') {
                return true;
            }

            if (has_term($child_terms_id_array, $taxonomy, $article) == false || empty($child_terms_id_array)) {
                return true;
            }

            return false;
        }

        /* PROTECTED METHODS */

        protected function limit_text($text, $limit)
        {
            if (str_word_count($text, 0) > $limit) {
                $words = str_word_count($text, 2);
                $pos = array_keys($words);
                $text = substr($text, 0, $pos[$limit]) . '...';
            }
            return $text;
        }
    } // END CLASS
}