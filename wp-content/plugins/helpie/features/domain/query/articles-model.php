<?php

namespace Helpie\Features\Domain\Query;

if (!class_exists('\Helpie\Features\Domain\Query\Articles_Model')) {
    class Articles_Model
    {

        private $kb_articles = null;

        public function __construct()
        {
            $this->post_type = 'pauple_helpie';
            $this->taxonomy = 'helpdesk_category';
            $this->mp_option_key = 'helpie_mp_options';

            $this->category_repo = new \Helpie\Features\Domain\Repositories\Category_Repository();
            $this->tags_model = new \Helpie\Features\Domain\Models\Tags_Model();
        }

        public function get_default_args()
        {
            $mainpage_category = $this->category_repo->get_mainpage_category();

            $args = array(
                'numberposts' => -1,
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'helpdesk_category',
                        'field' => 'id',
                        'terms' => $mainpage_category,
                    ),
                ),
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post_type' => 'pauple_helpie',
                'post_status' => 'publish, awaiting',
            );

            return $args;
        }

        public function get_articles_without_args()
        {

            if ($this->kb_articles == null) {
                $args = [];
                $this->kb_articles = $this->get_articles($args);
            }

            return $this->kb_articles;
        }


        public function get_articles($input_args = array())
        {
            global $post;
            $args = $this->get_default_args();


            $args['orderby'] = !empty($input_args['orderby']) ? $input_args['orderby'] : $args['orderby'];
            $args['order'] = !empty($input_args['order']) ? $input_args['order'] : $args['order'];
            $args['posts_per_page'] = !empty($input_args['limit']) ? $input_args['limit'] : $args['posts_per_page'];
            $args['s'] = !empty($input_args['s']) ? $input_args['s'] : null;

            if (isset($input_args['sortby'])) {
                if ($input_args['sortby'] == 'alphabetical') {
                    $args['orderby'] = 'title';
                    $args['order'] = 'ASC';
                } elseif ($input_args['sortby'] == 'popular') {
                    $args['orderby'] = 'meta_value';
                    $args['order'] = 'DESC';
                    $args['meta_key'] = 'ph_pageviews';
                    $args['type'] = 'NUMERIC';
                } elseif ($input_args['sortby'] == 'updated') {
                    $args['orderby'] = 'modified';
                    $args['order'] = 'DESC';
                }
            }


            if (isset($input_args['topics'])) {
                $args['tax_query'][0]['terms'] = $input_args['topics'];
            }

            if (isset($input_args['tax_query'])) {
                $args['tax_query'][] = $input_args['tax_query'][0];
                $args['tax_query']['relation'] = 'AND';
            }

            // $posts = get_posts($args);
            $posts = $this->get_posts($args);

            return $posts;
        }

        public function get_posts($args)
        {
            $results    = [];

            $args_perf = [
                'no_found_rows'          => true,
                // 'update_post_meta_cache' => false,
                // 'update_post_term_cache' => false,
            ];

            $args = array_merge($args, $args_perf);

            // Remove pre_get_term filter for querying post
            remove_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Remove action for this specific get_term_children()
            $query = new \WP_Query($args);
            add_action('pre_get_terms', 'helpie_kb_pre_get_terms', 10, 3); // Add action to reset original filter

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    // Optionally, pick parts of the post and create a custom collection.
                    $query->the_post();
                    $results[] = get_post();
                }
                wp_reset_postdata();

                return $results;
            }

            return $results;
        }

        public function get_status_filtered_posts($posts)
        {
            $filtered_posts = array();

            foreach ($posts as $post) {
                $post_id = $post->ID;
                $post_status = get_post_status($post_id);

                $published_revision_id = null;

                if (get_post_meta($post_id, 'last_approved_revision', true) !== null && get_post_meta($post_id, 'last_approved_revision', true) != '') {
                    $published_revision_id = get_post_meta($post_id, 'last_approved_revision', true);
                    // error_log("published_revision_id: " . $published_revision_id);
                }

                $is_published = ($post_status == 'publish');
                // error_log('post_id: ' . $post_id . ' , is_published: ' . $is_published);
                $has_published_revision = ($post_status == 'awaiting' && isset($published_revision_id));
                // error_log('has_published_revision: ' . ($post_status == 'awaiting' && isset($published_revision_id)));

                if ($is_published || $has_published_revision) {
                    // error_log('post_id: ' . $post_id . " , published_revision_id: " . $published_revision_id);
                    array_push($filtered_posts, $post);
                }
            }

            return $filtered_posts;
        }

        public function get_recent_articles($limit = 3)
        {
            $args['limit'] = !empty($limit) ? $limit : 3;

            return $this->get_articles($args);
        }

        // the term visible 'get_visible_articles' means same as
        // 'main_page' in  category_repo->get_mainpage_category()
        // It Means all articles visible to current user
        // ( including locked ones which are visible but needs password to access the content inside)

        public function get_visible_articles()
        {
            $mainpage_category = $this->category_repo->get_mainpage_category();
            $args = array(
                'numberposts' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'helpdesk_category',
                        'field' => 'id',
                        'terms' => $mainpage_category,
                    ),
                ),
                'orderby' => 'post_date',
                'order' => 'DESC',
                'post_type' => 'pauple_helpie',
                'post_status' => 'publish, awaiting',
            );

            return get_posts($args);
        }

        // Duplicate Method: Change the calls to kb-article's method
        public function get_read_time($content)
        {
            $words_per_min = 275; // Average WPM of a human
            $num_of_words = str_word_count($content);

            $read_time = ($num_of_words / $words_per_min);

            return ceil($read_time);
        }

        public function get_articles_of_term($term, $include_children = true, $limit = -1)
        {
            $order_info = $this->get_article_order_info();
            $taxonomy = $this->taxonomy;

            $args = array(
                'post_status' => 'publish, awaiting',
                'post_type' => $this->post_type,
                'orderby' => $order_info['orderby'],
                'order' => $order_info['order'],
                // 'posts_per_page' => $limit,
                'numberposts' => $limit,
                'tax_query' => array(
                    array(
                        'taxonomy' => $this->taxonomy,
                        'field' => 'id',
                        'terms' => $term->term_id,
                        'include_children' => $include_children,
                        'operator' => 'IN',
                    ),
                ),
            );

            $articles = get_posts($args);

            return $articles;
        }

        public function get_model_of_articles_of_term($term, $include_children = true)
        {
            if (is_numeric($term)) {
                $term = get_term($term, $this->taxonomy);
            }

            // wp_reset_query();

            $model = array();
            $count = 0;

            $articles = $this->get_articles_of_term($term, $include_children);

            foreach ($articles as $article) {
                $model[$count] = $this->get_articles_model_from_wp_object($article);
                ++$count;
            }

            // wp_reset_postdata();

            return $model;
        }

        /* PROTECTED METHODS */

        protected function get_articles_model_from_wp_object($article)
        {
            $permitted_added_tag = $this->tags_model->get_permitted_added_tag($article->ID);
            $permitted_updated_tag = $this->tags_model->get_permitted_updated_tag($article->ID);
            $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($article);
            return array(
                'ID' => $article->ID,
                'title' => $kb_article->get_title(),
                'permalink' => get_the_permalink($article->ID),
                'permitted_added_tag' => $permitted_added_tag,
                'permitted_updated_tag' => $permitted_updated_tag,
            );
        }

        protected function get_article_order_info()
        {

            $settings = new \Helpie\Includes\Settings\Getters\Settings();
            $article_order = $settings->components->get_article_order();

            return $this->get_article_order_info_from_article_order($article_order);
        }

        protected function get_article_order_info_from_article_order($article_order)
        {

            switch ($article_order) {
                case "asc_post_date":
                    $orderby = 'post_date';
                    $order = 'ASC';
                    break;
                case "desc_post_date":
                    $orderby = 'post_date';
                    $order = 'DESC';
                    break;
                case "alphabetical":
                    $orderby = 'title';
                    $order = 'ASC';
                    break;
                default:
                    $orderby = 'menu_order';
                    $order = 'ASC';
                    break;
            }

            return array(
                'orderby' => $orderby,
                'order' => $order,
            );
        }
    }
}