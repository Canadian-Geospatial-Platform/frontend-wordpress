<?php

namespace Helpie\Features\Components\Insights;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Insights\Insights_Model')) {

    class Insights_Model
    {
        private static $list_length = 10;

        public static function get_articles_list()
        {

            $args = array('post_type' => 'pauple_helpie', 'order' => 'DESC', 'posts_per_page' => -1);
            $loop = new \WP_Query($args);
            $article_insights_array = array();
            $emotions = array(0 => 'heart', 1 => 'smile', 2 => 'meh', 3 => 'frown');

            while ($loop->have_posts()): $loop->the_post();
                $ID = get_the_id();
                // echo "HARAN: " . $ID;
                $article_votes = array();

                foreach ($emotions as $key => $value) {
                    $meta_key = 'helpie_vote_' . $value . '_count';
                    // print_r($meta_key);
                    if (get_post_meta($ID, $meta_key, true) != '') {
                        $article_votes[$value] = get_post_meta($ID, $meta_key, true);
                    } else {
                        $article_votes[$value] = 0;
                    }
                }
                // print_r($article_votes);
                $happiness_index = intval(self::user_happiness_index($article_votes));

                $article_insights_array[$ID] = array('post_id' => $ID, 'happiness_index' => $happiness_index, 'votes' => $article_votes, 'title' => get_the_title());
                // print_r($article_insights_array[$ID]);

                if ($article_votes != '' && is_array($article_votes)) {}

            endwhile;
            wp_reset_query();

            return $article_insights_array;
        }

        public static function get_users_list()
        {
            // The Query
            $args = array('orderby' => 'registered', 'order' => 'ASC');
            $user_query = new \WP_User_Query($args);
            $user_insight_array = array();
            // User Loop

            if (!empty($user_query->results)) {
                foreach ($user_query->results as $user) {
                    $votes_array_full = get_user_meta($user->ID, 'helpie_article_votes', true);

                    // echo "print_votes_array_full: ";
                    // echo "<pre>";
                    // print_r($votes_array_full);
                    // echo "</pre>";
                    // echo "... ends here.";

                    // print_r ("RAMA",$user);
                    // print_r("JAY",$user->ID);
                    $votes_array = $votes_array_full;
                    // $votes_array = (isset($votes_array_full[0]) ? $votes_array_full[0] : '');

                    if ($votes_array != '' && is_array($votes_array)) {

                        $vote_count_array = self::user_vote_count_array($votes_array);
                        $happiness_index = intval(self::user_happiness_index($vote_count_array));
                        // print_r($happiness_index);

                        $user_insight_array[$user->ID] = array('user_id' => $user->ID, 'votes' => $vote_count_array, 'happiness_index' => $happiness_index, 'display_name' => $user->display_name);
                        // print_r($user_insight_array);
                    }
                }
            }
            // echo "startes: <pre>";
            // print_r($user_insight_array);
            // echo "</pre> :::: emds";

            return $user_insight_array;

        } // get_users_list

        public static function get_best_articles_list()
        {
            $article_insights_array = self::get_articles_list();
            // print_r($article_insights_array);
            usort($article_insights_array, function ($a, $b) {
                if ($a['happiness_index'] == $b['happiness_index']) {
                    return 0;
                }

                return $a['happiness_index'] < $b['happiness_index'] ? 1 : -1;
            });
            $article_insights_array = array_slice($article_insights_array, 0, self::$list_length);
            return $article_insights_array;
        }

        public static function get_worst_articles_list()
        {
            $article_insights_array = self::get_articles_list();
            // print_r($article_insights_array);
            usort($article_insights_array, function ($a, $b) {
                if ($a['happiness_index'] == $b['happiness_index']) {
                    return 0;
                }

                return $a['happiness_index'] > $b['happiness_index'] ? 1 : -1;
            });
            $article_insights_array = array_slice($article_insights_array, 0, self::$list_length);
            return $article_insights_array;
        }

        public static function get_happy_users_list()
        {
            $user_insight_array = self::get_users_list();

            usort($user_insight_array, function ($a, $b) {
                if ($a['happiness_index'] === $b['happiness_index']) {
                    return 0;
                }

                return ($a['happiness_index'] < $b['happiness_index']) ? 1 : -1;
            });

            $user_insight_array = array_slice($user_insight_array, 0, self::$list_length);
            // print_r($user_insight_array);

            return $user_insight_array;
        } // end get_happy_users_list

        public static function get_unhappy_users_list()
        {
            $user_insight_array = self::get_users_list();

            usort($user_insight_array, function ($a, $b) {
                if ($a['happiness_index'] == $b['happiness_index']) {
                    return 0;
                }

                return $a['happiness_index'] > $b['happiness_index'] ? 1 : -1;
            });
            $user_insight_array = array_slice($user_insight_array, 0, self::$list_length);

            return $user_insight_array;
        }

        public static function user_vote_count_array($votes_array)
        {
            // echo " user_vote_count_array : ";
            // print_r($votes_array);

            $vote_count_array = array();

            foreach ($votes_array as $key => $value) {

                if (!isset($vote_count_array[$value])) {
                    $vote_count_array[$value] = 1;
                } else {
                    $vote_count_array[$value] = $vote_count_array[$value] + 1;
                }

            }

            return $vote_count_array;
        }

        public static function user_happiness_index($vote_count_array)
        {
            $happiness_index = 0;
            $emotion_value = array(
                'heart' => 3,
                'smile' => 1,
                'meh' => -1,
                'frown' => -2,
            );

            // echo " user_happiness_index : ";
            foreach ($vote_count_array as $emotion => $count) {
                if (isset($emotion_value[$emotion])) {
                    $happiness_index = $happiness_index + ($count * $emotion_value[$emotion]);
                }

                //  echo $emotion . " : " . $happiness_index.  ", ";
            }

            return $happiness_index;
        }

        /* find the most frequent word from 'pauple_helpie' post type */

        public function get_most_frequent_words($min_str_length = 3, $limit = 10)
        {

            $all_articles = array();
            $total_count = array();

            $posts_array = get_helpie_kb_articles();
            // print_r($posts_array) ;

            foreach ($posts_array as $post) {

                // splite the content string based on spaces
                $count = explode(" ", wp_strip_all_tags($post->post_content));

                // count the each word
                $all_articles[$post->ID] = array_count_values($count);
            }

            foreach ($all_articles as $single_article) {
                foreach ($single_article as $key => $value) {

                    $len = strlen($key);
                    if (isset($len) && $len > $min_str_length) {

                        if (!isset($total_count[$key])) {
                            $total_count[$key] = 0;
                        }

                        $total_count[$key] += $value; // sum of words from the all articles
                    }
                }
            }

            arsort($total_count);

            $word_limit = array_splice($total_count, 0, $limit);
            // print_r($word_limit);
            return $word_limit;
        }

        public function get_most_viewed_pages()
        {

            $posts_array = get_helpie_kb_articles();
            $all_articles = array();

            foreach ($posts_array as $post) {
                $all_articles[$post->ID] = array();
                $all_articles[$post->ID]['post_title'] = $post->post_title;
                $all_articles[$post->ID]['post_views'] = get_post_meta($post->ID, 'ph_pageviews', true);
            }

            usort($all_articles, function ($a, $b) {
                if ($a['post_views'] == $b['post_views']) {
                    return 0;
                }

                return $a['post_views'] < $b['post_views'] ? 1 : -1;
            });
            return $all_articles;

        }

    }

}