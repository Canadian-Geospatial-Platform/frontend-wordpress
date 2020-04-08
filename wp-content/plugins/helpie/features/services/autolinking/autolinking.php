<?php

namespace Helpie\Features\Services\Autolinking;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Services\Autolinking\Autolinking')) {
    class Autolinking
    {
        public function __construct()
        {
            $this->hooks();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function hooks()
        {
            add_filter('the_content', array($this, 'the_content_handler'));
        }

        public function the_content_handler($content)
        {
            if (!$this->is_post_type()) {
                return $content;
            }

            $autolinking = $this->settings->autolinking->get_settings();

            if ($autolinking['autolinking_enable'] == true) {
                $posts = $this->get_posts();
                $word_counted_posts = $this->order_post_by_word_count($posts);
                $content = $this->execute($content, $word_counted_posts);
            }

            return $content;
        }

        protected function get_posts()
        {
            $results = [];

            $query_args = [
                'post_type' => ['pauple_helpie'],
                'post_status' => ['publish'],
                'orderby' => 'menu_order',
                'no_found_rows' => true,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false,
                'posts_per_page' => -1,
            ];

            $query = new \WP_Query($query_args);

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    // Optionally, pick parts of the post and create a custom collection.
                    $query->the_post();
                    $results[] = get_post();
                }
                wp_reset_postdata();

                return $results;
            }
        }

        protected function order_post_by_word_count($posts)
        {
            $posts_array = [];

            foreach ($posts as $post) {
                if (get_the_ID() !== $post->ID) {
                    array_push($posts_array, [
                        'ID' => $post->ID,
                        'title' => $post->post_title,
                        'word_count' => str_word_count($post->post_title),
                    ]);
                }
            }

            $word_count = array_column($posts_array, 'word_count');
            array_multisort($word_count, SORT_DESC, $posts_array);

            return $posts_array;
        }

        protected function execute($content, $posts)
        {
            $input = $content;
            $matches = array();

            // loop through words to find the closest
            foreach ($posts as $post) {

                $title = $post['title'];
                if (!isset($title) || empty($title)) {
                    continue;
                }

                // calculate the distance between the input word and the current word
                $pos = stripos($input, $title);

                if (is_numeric($pos)) {

                    // error_log('pos : ' . $pos);
                    // error_log('title : ' . $title);
                    // error_log('input : ' . $content);

                    $link = "<a href='" . get_permalink($post['ID']) . "'>$1</a>";

                    $pattern = '/(?![<\[].*)' // Not followed by an an opening angle or square bracket
                     . '\b' // Word boundary
                     . '(' . $title . ')' // 1: The title to be replaced
                     . '\b' // Word boundary
                     . '(?!' // Non-capturing group
                     . '[^<>\[\]]*?' // 0 or more characters that aren't angle or square brackets
                     . '[\]>]' // Character that isn't a closing angle or square bracket
                     . ')/i';

                    $content = preg_replace($pattern, $link, $content);

                    // Remove link within link
                    $content = preg_replace(
                        '#'
                        . '(<a [^>]+>)' // 1: Opening link tag with any number of attributes
                         . '(' // 2: Contents of the link tag
                         . '(?:' // Non-capturing group
                         . '(?!</a>)' // Not followed by closing link tag
                         . '.' // Any character
                         . ')' // End of non-capturing group
                         . '*' // 0 or more characters
                         . ')' // End of 2:
                         . '<a [^>]+>' // Embedded opening link tag with any number of attributes
                         . '([^<]*)' // 3: Contents of the embedded link tag
                         . '</a>' // Closing embedded link tag
                         . '(.*</a>)' // 4: 0 or more characters followed by a closing link tag
                         . '#iU',
                        '$1$2$3$4',
                        $content
                    );

                    array_push($matches, $title);
                }
            }

            return $content;
        }

        private function is_post_type()
        {
            $post_type = 'pauple_helpie';

            global $post;
            if (isset($post->post_type) && $post->post_type == $post_type) {
                return true;
            }

            return false;
        }
    } // END
}
