<?php

namespace Helpie\Includes\Core;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

add_action('wp_ajax_helpie_search_autosuggest', array('Helpie\Includes\Core\Ajax_Handler', 'helpie_search_autosuggest'));
add_action('wp_ajax_nopriv_helpie_search_autosuggest', array('Helpie\Includes\Core\Ajax_Handler', 'helpie_search_autosuggest')); // add 'ajax' action when not logged in

if (!class_exists('\Helpie\Includes\Core\Ajax_Handler')) {
    class Ajax_Handler
    {
        public function get_common_words()
        {
            // EEEEEEK Stop words
            $commonWords = array('a', 'able', 'about', 'above', 'abroad', 'according', 'accordingly', 'across', 'actually', 'adj', 'after', 'afterwards', 'again', 'against', 'ago', 'ahead', 'ain\'t', 'all', 'allow', 'allows', 'almost', 'alone', 'along', 'alongside', 'already', 'also', 'although', 'always', 'am', 'amid', 'amidst', 'among', 'amongst', 'an', 'and', 'another', 'any', 'anybody', 'anyhow', 'anyone', 'anything', 'anyway', 'anyways', 'anywhere', 'apart', 'appear', 'appreciate', 'appropriate', 'are', 'aren\'t', 'around', 'as', 'a\'s', 'aside', 'ask', 'asking', 'associated', 'at', 'available', 'away', 'awfully', 'b', 'back', 'backward', 'backwards', 'be', 'became', 'because', 'become', 'becomes', 'becoming', 'been', 'before', 'beforehand', 'begin', 'behind', 'being', 'believe', 'below', 'beside', 'besides', 'best', 'better', 'between', 'beyond', 'both', 'brief', 'but', 'by', 'c', 'came', 'can', 'cannot', 'cant', 'can\'t', 'caption', 'cause', 'causes', 'certain', 'certainly', 'changes', 'clearly', 'c\'mon', 'co', 'co.', 'com', 'come', 'comes', 'concerning', 'consequently', 'consider', 'considering', 'contain', 'containing', 'contains', 'corresponding', 'could', 'couldn\'t', 'course', 'c\'s', 'currently', 'd', 'dare', 'daren\'t', 'definitely', 'described', 'despite', 'did', 'didn\'t', 'different', 'directly', 'do', 'does', 'doesn\'t', 'doing', 'done', 'don\'t', 'down', 'downwards', 'during', 'e', 'each', 'edu', 'eg', 'eight', 'eighty', 'either', 'else', 'elsewhere', 'end', 'ending', 'enough', 'entirely', 'especially', 'et', 'etc', 'even', 'ever', 'evermore', 'every', 'everybody', 'everyone', 'everything', 'everywhere', 'ex', 'exactly', 'example', 'except', 'f', 'fairly', 'far', 'farther', 'few', 'fewer', 'fifth', 'first', 'five', 'followed', 'following', 'follows', 'for', 'forever', 'former', 'formerly', 'forth', 'forward', 'found', 'four', 'from', 'further', 'furthermore', 'g', 'get', 'gets', 'getting', 'given', 'gives', 'go', 'goes', 'going', 'gone', 'got', 'gotten', 'greetings', 'h', 'had', 'hadn\'t', 'half', 'happens', 'hardly', 'has', 'hasn\'t', 'have', 'haven\'t', 'having', 'he', 'he\'d', 'he\'ll', 'hello', 'help', 'hence', 'her', 'here', 'hereafter', 'hereby', 'herein', 'here\'s', 'hereupon', 'hers', 'herself', 'he\'s', 'hi', 'him', 'himself', 'his', 'hither', 'hopefully', 'how', 'howbeit', 'however', 'hundred', 'i', 'i\'d', 'ie', 'if', 'ignored', 'i\'ll', 'i\'m', 'immediate', 'in', 'inasmuch', 'inc', 'inc.', 'indeed', 'indicate', 'indicated', 'indicates', 'inner', 'inside', 'insofar', 'instead', 'into', 'inward', 'is', 'isn\'t', 'it', 'it\'d', 'it\'ll', 'its', 'it\'s', 'itself', 'i\'ve', 'j', 'just', 'k', 'keep', 'keeps', 'kept', 'know', 'known', 'knows', 'l', 'last', 'lately', 'later', 'latter', 'latterly', 'least', 'less', 'lest', 'let', 'let\'s', 'like', 'liked', 'likely', 'likewise', 'little', 'look', 'looking', 'looks', 'low', 'lower', 'ltd', 'm', 'made', 'mainly', 'make', 'makes', 'many', 'may', 'maybe', 'mayn\'t', 'me', 'mean', 'meantime', 'meanwhile', 'merely', 'might', 'mightn\'t', 'mine', 'minus', 'miss', 'more', 'moreover', 'most', 'mostly', 'mr', 'mrs', 'much', 'must', 'mustn\'t', 'my', 'myself', 'n', 'name', 'namely', 'nd', 'near', 'nearly', 'necessary', 'need', 'needn\'t', 'needs', 'neither', 'never', 'neverf', 'neverless', 'nevertheless', 'new', 'next', 'nine', 'ninety', 'no', 'nobody', 'non', 'none', 'nonetheless', 'noone', 'no-one', 'nor', 'normally', 'not', 'nothing', 'notwithstanding', 'novel', 'now', 'nowhere', 'o', 'obviously', 'of', 'off', 'often', 'oh', 'ok', 'okay', 'old', 'on', 'once', 'one', 'ones', 'one\'s', 'only', 'onto', 'opposite', 'or', 'other', 'others', 'otherwise', 'ought', 'oughtn\'t', 'our', 'ours', 'ourselves', 'out', 'outside', 'over', 'overall', 'own', 'p', 'particular', 'particularly', 'past', 'per', 'perhaps', 'placed', 'please', 'plus', 'possible', 'presumably', 'probably', 'provided', 'provides', 'q', 'que', 'quite', 'qv', 'r', 'rather', 'rd', 're', 'really', 'reasonably', 'recent', 'recently', 'regarding', 'regardless', 'regards', 'relatively', 'respectively', 'right', 'round', 's', 'said', 'same', 'saw', 'say', 'saying', 'says', 'second', 'secondly', 'see', 'seeing', 'seem', 'seemed', 'seeming', 'seems', 'seen', 'self', 'selves', 'sensible', 'sent', 'serious', 'seriously', 'seven', 'several', 'shall', 'shan\'t', 'she', 'she\'d', 'she\'ll', 'she\'s', 'should', 'shouldn\'t', 'since', 'six', 'so', 'some', 'somebody', 'someday', 'somehow', 'someone', 'something', 'sometime', 'sometimes', 'somewhat', 'somewhere', 'soon', 'sorry', 'specified', 'specify', 'specifying', 'still', 'sub', 'such', 'sup', 'sure', 't', 'take', 'taken', 'taking', 'tell', 'tends', 'th', 'than', 'thank', 'thanks', 'thanx', 'that', 'that\'ll', 'thats', 'that\'s', 'that\'ve', 'the', 'their', 'theirs', 'them', 'themselves', 'then', 'thence', 'there', 'thereafter', 'thereby', 'there\'d', 'therefore', 'therein', 'there\'ll', 'there\'re', 'theres', 'there\'s', 'thereupon', 'there\'ve', 'these', 'they', 'they\'d', 'they\'ll', 'they\'re', 'they\'ve', 'thing', 'things', 'think', 'third', 'thirty', 'this', 'thorough', 'thoroughly', 'those', 'though', 'three', 'through', 'throughout', 'thru', 'thus', 'till', 'to', 'together', 'too', 'took', 'toward', 'towards', 'tried', 'tries', 'truly', 'try', 'trying', 't\'s', 'twice', 'two', 'u', 'un', 'under', 'underneath', 'undoing', 'unfortunately', 'unless', 'unlike', 'unlikely', 'until', 'unto', 'up', 'upon', 'upwards', 'us', 'use', 'used', 'useful', 'uses', 'using', 'usually', 'v', 'value', 'various', 'versus', 'very', 'via', 'viz', 'vs', 'w', 'want', 'wants', 'was', 'wasn\'t', 'way', 'we', 'we\'d', 'welcome', 'well', 'we\'ll', 'went', 'were', 'we\'re', 'weren\'t', 'we\'ve', 'what', 'whatever', 'what\'ll', 'what\'s', 'what\'ve', 'when', 'whence', 'whenever', 'where', 'whereafter', 'whereas', 'whereby', 'wherein', 'where\'s', 'whereupon', 'wherever', 'whether', 'which', 'whichever', 'while', 'whilst', 'whither', 'who', 'who\'d', 'whoever', 'whole', 'who\'ll', 'whom', 'whomever', 'who\'s', 'whose', 'why', 'will', 'willing', 'wish', 'with', 'within', 'without', 'wonder', 'won\'t', 'would', 'wouldn\'t', 'x', 'y', 'yes', 'yet', 'you', 'you\'d', 'you\'ll', 'your', 'you\'re', 'yours', 'yourself', 'yourselves', 'you\'ve', 'z', 'zero');

            return $commonWords;
        }

        public static function removeCommonWords($input)
        {
            $ajax_cls = new Ajax_Handler();
            $commonWords = $ajax_cls->get_common_words();

            return preg_replace('/\b(' . implode('|', $commonWords) . ')\b/', '', $input);
        }

        public static function search_insights()
        {

            if (isset($_GET['search'])) {
                $search_query = $_GET['search'];
                self::save_searched_input($search_query);
            }
        }

        public static function get_search_words_array($string)
        {
            $new_string = self::removeCommonWords($string);
            $new_string = strtolower($new_string);

            $word_array = preg_split('/\s+/', $new_string);
            $word_array = array_map('trim', $word_array);

            $inputArray = array();
            foreach ($word_array as $key => $value) {
                $inputArray[$value] = 1;
            }

            return $inputArray;
        }

        public static function save_searched_input($string)
        {
            $prev_searches = array();
            $prev_searches = get_option('helpie_searches');
            $curr_searches = self::get_search_words_array($string);
            $total_searches = array();

            if (!isset($prev_searches) || !is_array($prev_searches)) {
                $prev_searches = array();
            }
            foreach (array_keys($curr_searches + $prev_searches) as $key) {
                $total_searches[$key] = (isset($curr_searches[$key]) ? $curr_searches[$key] : 0) + (isset($prev_searches[$key]) ? $prev_searches[$key] : 0);
            }

            $total_searches = array_filter($total_searches);

            update_option('helpie_searches', $total_searches);
        }

        public static function helpie_search_autosuggest()
        {
            $ajaxInput = sanitize_text_field($_POST['query_value']);

            $search_model = new \Helpie\Features\Components\Search\Models\Search_Model();
            $resultOfQuery = $search_model->get_autosuggest($ajaxInput);

            print_r(json_encode($resultOfQuery, JSON_NUMERIC_CHECK));

            wp_die(); // this is required to terminate immediately and return a proper response
        }

        public function has_user_voted_already($user_vote_array, $post_id)
        {
            $has_voted = false;
            foreach ($user_vote_array as $key => $value) {
                if ($key == $post_id) {
                    $has_voted = true;
                }
            }

            return $has_voted;
        }

        public static function article_voting_callback()
        {
            global $wpdb; // this is how you get access to the database

            $vote_value = sanitize_text_field($_POST['voteValue']);
            $post_id = sanitize_text_field($_POST['postID']);
            $user_id = sanitize_text_field($_POST['userID']);
            $vote_handler = new \Helpie\Features\Components\Voting\Article_Vote_Handler($post_id, $user_id);
            $vote_handler->cast_vote($vote_value);
            $vote_handler->update_vote();

            wp_reset_query();
        }

        public static function insights()
        {
            global $wpdb; // this is how you get access to the database

            $posts_array = get_helpie_kb_articles();
            $heart_vote = 0;
            $smile_vote = 0;
            $meh_vote = 0;
            $frown_vote = 0;

            foreach ($posts_array as $post) {
                $ID = $post->ID;
                $heart_vote = $heart_vote + (int) get_post_meta($ID, 'helpie_vote_heart_count', true);
                $smile_vote = $smile_vote + (int) get_post_meta($ID, 'helpie_vote_smile_count', true);
                $meh_vote = $meh_vote + (int) get_post_meta($ID, 'helpie_vote_meh_count', true);
                $frown_vote = $frown_vote + (int) get_post_meta($ID, 'helpie_vote_frown_count', true);
            }

            $votes_array = array(
                'heart' => $heart_vote,
                'smile' => $smile_vote,
                'meh' => $meh_vote,
                'frown' => $frown_vote,
            );

            print_r(json_encode($votes_array, JSON_NUMERIC_CHECK));

            wp_die(); // this is required to terminate immediately and return a proper response

            wp_reset_postdata();
        }

        public function ajax_get_article_info()
        {
            $post_id = 0;
            if (isset($_POST['post_id'])) {
                $post_id = sanitize_text_field($_POST['post_id']);
                $post = get_post($post_id);
                $title = get_the_title($post_id);
                // remove shortcode filter from the_content filter
                remove_filter('the_content', 'do_shortcode', 11);
                $content = (isset($post->post_content)) ? $post->post_content : "";
                $post_content = apply_filters('the_content', $content);

                $category = get_the_terms($post_id, 'helpdesk_category');

                $category_term_id = '';

                if (isset($category) && isset($category[0])) {
                    $category_term_id = $category[0]->term_id;
                }

                $tags = get_the_terms($post_id, 'helpie_tag');

                $tags_info = array();
                $count = 0;
                if (isset($tags) && !empty($tags)) {
                    foreach ($tags as $tag) {
                        $tags_info[$count]['term_id'] = $tag->term_id;
                        $tags_info[$count]['name'] = $tag->name;
                        $count++;
                    }
                }

                $response = array(
                    'post_id' => $post_id,
                    'post_title' => $title,
                    'post_content' => wpautop($post_content),
                    'category_id' => $category_term_id,
                    'tags_info' => $tags_info,
                );

                print_r(json_encode($response, JSON_NUMERIC_CHECK));
                wp_die();
            }
        }

        public function publish_new_article($post_title, $post_content, $category_id = 0, $tags_array = '', $post_state = 'add', $post_id = 0)
        {

            // Create post object
            $post = array(
                'post_title' => wp_strip_all_tags($_POST['post_title']),
                'post_type' => 'pauple_helpie',
                'post_content' => $post_content,
                'post_status' => 'publish',
                'post_author' => get_current_user_id(),
            );

            if ($post_state == 'edit') {
                $post['ID'] = $post_id;
                $post_id = wp_update_post($post);
            } else {
                // Insert the post into the database
                $post_id = wp_insert_post($post);
            }

            // Set 'helpdesk_category' value
            $taxonomy = 'helpdesk_category';
            $category_ids_array = array();
            array_push($category_ids_array, $category_id);
            wp_set_post_terms($post_id, $category_ids_array, $taxonomy);

            // Set 'helpie_tag' value
            if (isset($tags_array) && !empty($tags_array)) {
                $taxonomy = 'helpie_tag';
                wp_set_post_terms($post_id, $tags_array, $taxonomy);
            }

            // Return ajax response
            echo get_permalink($post_id);
        }

        public function publish_new()
        {
            $post_content = wp_kses_post($_POST['post_content']);
            $post_id = sanitize_text_field($_POST['post_id']);

            // Create post object
            $post = array(
                'post_title' => wp_strip_all_tags($_POST['post_title']),
                'post_type' => 'pauple_helpie',
                'post_content' => $post_content,
                'post_status' => 'publish',
                'post_author' => get_current_user_id(),
            );

            $post['ID'] = $post_id;
            $post_id = wp_update_post($post);

            echo $post_id;

            wp_die(); // this is required to terminate immediately and return a proper response

            wp_reset_postdata();
        }

        public function helpie_onboarding()
        {
            $onboarding = new \Helpie\Features\Components\Onboarding\Controller();
            $response = $onboarding->get_demos_categories();

            print_r(json_encode($response, JSON_NUMERIC_CHECK));
            wp_die();
            wp_reset_postdata();
        }

        public function helpie_onboarding_submit()
        {
            $onboarding = new \Helpie\Features\Components\Onboarding\Controller();
            $response = $onboarding->run_importer();

            print_r(json_encode($response, JSON_NUMERIC_CHECK));
            wp_die();
            wp_reset_postdata();
        }
    } // END CLASS
}

$ajax_handler = new \Helpie\Includes\Core\Ajax_Handler();
$publishing_service = new \Helpie\Features\Services\Publishing\Publishing();

add_filter('wp_kses_allowed_html', array($publishing_service, 'custom_wpkses_post_tags'), 10, 2);

add_action('wp_ajax_helpie_get_revision', array($publishing_service, 'get_revision'));
add_action('wp_ajax_nopriv_helpie_get_revision', array($publishing_service, 'get_revision')); // add 'ajax' action when not logged in

add_action('wp_ajax_helpie_delete_revision', array($publishing_service, 'delete_revision_ajax_action'));
add_action('wp_ajax_nopriv_helpie_delete_revision', array($publishing_service, 'delete_revision_ajax_action')); // add 'ajax' action when not logged in

add_action('wp_ajax_delete_single_article', array($publishing_service, 'delete_single_article'));
add_action('wp_ajax_nopriv_delete_single_article', array($publishing_service, 'delete_single_article')); // add 'ajax' action when not logged in

add_action('wp_ajax_helpie_publish', array($publishing_service, 'publish_ajax_action'));
add_action('wp_ajax_nopriv_helpie_publish', array($publishing_service, 'publish_ajax_action')); // add 'ajax' action when not logged in

add_action('wp_ajax_helpie_publish_img', array($publishing_service, 'publish_img_ajax_action'));
add_action('wp_ajax_nopriv_helpie_publish_img', array($publishing_service, 'publish_img_ajax_action')); // add 'ajax' action when not logged in

add_action('wp_ajax_helpie_ajax_get_article_info', array($ajax_handler, 'ajax_get_article_info'));
add_action('wp_ajax_nopriv_helpie_ajax_get_article_info', array($ajax_handler, 'ajax_get_article_info')); // add 'ajax' action when not logged in

add_action('wp_ajax_helpie_ajax_article_add', array($ajax_handler, 'ajax_article_add'));
add_action('wp_ajax_nopriv_helpie_ajax_article_add', array($ajax_handler, 'ajax_article_add')); // add 'ajax' action when not logged in

add_action('wp_ajax_helpie_ajax_article_update', array($ajax_handler, 'ajax_article_update'));
add_action('wp_ajax_nopriv_helpie_ajax_article_update', array($ajax_handler, 'ajax_article_update')); // add 'ajax' action when not logged in

add_action('wp_ajax_article_voting_callback', array($ajax_handler, 'article_voting_callback'));
add_action('wp_ajax_nopriv_article_voting_callback', array($ajax_handler, 'article_voting_callback')); // add 'ajax' action when not logged in

add_action('wp_ajax_insights', array($ajax_handler, 'insights'));
add_action('wp_ajax_helpie_onboarding', array($ajax_handler, 'helpie_onboarding'));
add_action('wp_ajax_helpie_onboarding_submit', array($ajax_handler, 'helpie_onboarding_submit'));

add_action('init', array($ajax_handler, 'search_insights'));
