<?php

namespace Helpie\Includes\Utils;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Utils\Test_Helpers')) {
    class Test_Helpers
    {

        public function __construct()
        {
            $this->users = new \Helpie\Includes\Utils\Users();
            $this->voting = new \Helpie\Includes\Utils\Voting();
            $this->post = new \Helpie\Includes\Utils\Post();
            $this->plugin = new \Helpie\Includes\Utils\Plugin();
        }

        /* Execute Private / Protected methods */
        public static function executeMethod($methodName, $className, $args = [])
        {
            $class = new \ReflectionClass($className);
            $method = $class->getMethod($methodName);
            $method->setAccessible(true);
            $obj = new $className();
            $term_info = $method->invokeArgs($obj, $args);
            return $term_info;
        }


        public function content_setup()
        {
            $taxonomy = 'helpdesk_category';
            $post_info = array();
            $post_info['term-1'] = $this->insert_term_with_post('pauple_helpie', 'a-term-1', 'helpdesk_category', 'Term1 Post Title');
            $post_info['term-2'] = $this->insert_term_with_post('pauple_helpie', 'd-term-2', 'helpdesk_category', 'Term2 Post Title');
            $post_info['term-3'] = $this->insert_term_with_post('pauple_helpie', 'c-term-3', 'helpdesk_category', 'Term3 Post Title');
            $post_info['term-4'] = $this->insert_term_with_post('pauple_helpie', 'b-term-4', 'helpdesk_category', 'Term4 Post Title');
            $term_info_5 = wp_insert_term('f-term-5', $taxonomy);
            $post_info['term-5'] = array(
                0 => '',
                1 => $term_info_5['term_id'],
            );

            return $post_info;
        }

        public function delete_plugin_data()
        {
            $this->plugin->delete_plugin_data();
        }

        public function create_new_user($role = 'subscriber', $username = 'subman', $password = 'subpass', $email = 'submail@pauple.com')
        {
            return $this->users->create_new_user($role, $username, $password, $email);;
        }

        public function get_page_title_for_slug($page_slug)
        {
            $page = get_page_by_path($page_slug, OBJECT);
            $title = (isset($page)) ? $page->post_title : false;
            return $title;
        }

        public function does_page_exist($page_title)
        {
            $page = get_page_by_title($page_title);
            return (isset($page) && !empty($page)) ? true : false;
        }


        public function insert_term_with_post($post_type, $term_value, $taxonomy, $post_title = 'random', $post_content = 'demo text', $parent_term_id = 0)
        {
            return $this->post->insert_term_with_post($post_type, $term_value, $taxonomy, $post_title, $post_content, $parent_term_id);
        }

        public function insert_post_to_child_term($post_type, $term_value, $taxonomy, $parent_term)
        {
            return $this->post->insert_post_to_child_term($post_type, $term_value, $taxonomy, $parent_term);
        }

        public function insert_post_with_term($post_type, $term_id, $taxonomy, $post_title = 'random', $post_content = 'demo text')
        {
            return $this->post->insert_post_with_term($post_type, $term_id, $taxonomy, $post_title, $post_content);
        }

        public function cast_vote_as_user($user_id, $vote)
        {
            $this->voting->cast_vote_as_user($user_id, $vote);
        }

        public function activatePlugin($I)
        {
            $this->plugin->activatePlugin($I);
        }
    } // END CLASS
}