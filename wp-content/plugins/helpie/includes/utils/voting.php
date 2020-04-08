<?php

namespace Helpie\Includes\Utils;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly



if (!class_exists('\Helpie\Includes\Utils\Voting')) {
    class Voting
    { 
        public function __construct(){
            $this->post = new \Helpie\Includes\Utils\Post();
            
        }

        public function cast_vote_as_user($user_id, $vote)
        {
            $post_type = 'pauple_helpie';
            $term_value = '1.0.5';
            $taxonomy = 'helpie_add_tag';

            wp_set_current_user($user_id);

            $insert_info = $this->post->insert_term_with_post($post_type, $term_value, $taxonomy);
            $post_id = $insert_info[0];

            $this->vote_handler = new \Helpie\Features\Components\Voting\Article_Vote_Handler($post_id, $user_id);
            $this->vote_handler->cast_vote($vote);
            $this->vote_handler->update_vote();
        }

        
    } // END CLASS

}