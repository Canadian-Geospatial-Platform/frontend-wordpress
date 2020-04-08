<?php

namespace Helpie\Features\Services\Dynamic_Caps;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps')) {
    class Dynamic_Caps
    {
        // Hold the class instance.
        private static $instance = null;


        private $allowed_content = [
            'can_view' => null,
            'can_edit' => null,
            'can_publish' => null,
            'can_approve' => null,
        ];


        public function __construct($strategy = null)
        {
            $this->access_helper = new \Helpie\Features\Services\Access_Control\Helper();
            $this->user_id = get_current_user_id();
            // $cap_settings_cls = new \Helpie\Features\Services\Dynamic_Caps\Cap_Settings();
            // $this->cap_settings = $cap_settings_cls->get();

            $this->cap_settings_cls =  \Helpie\Features\Services\Dynamic_Caps\Cap_Settings::getInstance();
            $this->cap_settings = $this->cap_settings_cls->get();

            if ($strategy == null) {
                $this->strategy = new \Helpie\Features\Services\Dynamic_Caps\Caps_Strategy();
            } else {
                $this->strategy = $strategy;
            }
        }

        // The object is created from within the class itself
        // only if the class has no instance.
        public static function getInstance()
        {
            if (self::$instance == null) {
                self::$instance = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();
            }

            return self::$instance;
        }


        public function execute_strategy($user_id = null, $cap_name)
        {
            // error_log('execute_strategy');
            foreach ($this->cap_settings['topics'] as $item_id => $rules) {
                $this->get_single_capability($cap_name, $item_id, 'topic');
            }

            foreach ($this->cap_settings['posts'] as $item_id => $rules) {
                $this->get_single_capability($cap_name, $item_id, 'post');
            }
        }

        public function get_allowed_content($cap_name)
        {

            if ($this->allowed_content[$cap_name] != null) {
                return $this->allowed_content[$cap_name];
            }

            $this->allowed_content[$cap_name] = $this->get_allowed_content_executer($cap_name);

            return $this->allowed_content[$cap_name];
        }


        public function get_allowed_content_executer($cap_name)
        {

            $content = array(
                'included' => array(
                    'posts' => array(),
                    'topics' => array(),
                ),
                'excluded' => array(
                    'posts' => array(),
                    'topics' => array(),
                ),
                'global' => true,
            );

            // error_log('execute_strategy');

            // GLobal
            $has_cap = $this->get_global_single_capability($cap_name);
            if ($has_cap) {
                $content['global'] = true;
            } else {
                $content['global'] = false;
            }

            // Topic
            foreach ($this->cap_settings['topics'] as $item_id => $rules) {
                $type = 'topic';
                $has_cap = $this->get_single_capability($cap_name, $item_id, $type);

                // if ($item_id == 12) {
                //     error_log(' 12 $has_cap : ' . $has_cap);
                //     error_log('12 $content : ' . print_r($content, true));
                // }

                if ($has_cap !== 'none' && $has_cap == true) {
                    array_push($content['included']['topics'], $item_id);
                } else if ($has_cap == false) {
                    array_push($content['excluded']['topics'], $item_id);
                } else {
                    // DO NOTHING
                }
            }

            // Single Article
            foreach ($this->cap_settings['posts'] as $item_id => $rules) {
                $type = 'post';
                $has_cap = $this->get_single_capability($cap_name, $item_id, $type);

                if ($has_cap !== 'none' && $has_cap == true) {
                    array_push($content['included']['posts'], $item_id);
                } else if ($has_cap == false) {
                    array_push($content['excluded']['posts'], $item_id);
                } else {
                    // $has_cap == 'none'
                    // if ($item_id == 1483) {
                    //     error_log(' 1483 $has_cap : ' . $has_cap);
                    //     error_log('1483 $content : ' . print_r($content, true));
                    // }
                }
            }

            return $content;
        }

        // Modify = Edit (or) Publish (or) Approve
        public function can_user_modify_any_topic()
        {
            $mod_caps = ['can_edit', 'can_publish', 'can_approve'];

            $can_user_modify_topic = false;

            foreach ($mod_caps as $cap_name) {
                $allowed_content = $this->get_allowed_content($cap_name);
                $global_has_cap = $this->get_global_single_capability($cap_name);

                if ($global_has_cap == true) {
                    $can_user_modify_topic = true;
                    break;
                }
                // $has_cap_for_any_topic = false;
                if (isset($allowed_content['included']['topics']) && is_array($allowed_content['included']['topics']) && !empty($allowed_content['included']['topics'])) {
                    // $has_cap_for_any_topic = true;
                    $can_user_modify_topic = true;
                    break;
                }
            }

            return $can_user_modify_topic;
        }

        // Here 'Publish' =  Publish (or) Approve
        public function can_user_edit_any_topic()
        {
            $mod_caps = ['can_edit'];

            $can_user_modify_topic = false;

            foreach ($mod_caps as $cap_name) {
                $allowed_content = $this->get_allowed_content($cap_name);
                $global_has_cap = $this->get_global_single_capability($cap_name);

                if ($global_has_cap == true) {
                    $can_user_modify_topic = true;
                    break;
                }
                // $has_cap_for_any_topic = false;
                if (isset($allowed_content['included']['topics']) && is_array($allowed_content['included']['topics']) && !empty($allowed_content['included']['topics'])) {
                    // $has_cap_for_any_topic = true;
                    $can_user_modify_topic = true;
                    break;
                }
            }

            return $can_user_modify_topic;
        }

        // Here 'Publish' =  Publish (or) Approve
        public function can_user_approve_any_topic()
        {
            $mod_caps = ['can_approve'];

            $can_user_modify_topic = false;

            foreach ($mod_caps as $cap_name) {
                $allowed_content = $this->get_allowed_content($cap_name);
                $global_has_cap = $this->get_global_single_capability($cap_name);

                if ($global_has_cap == true) {
                    $can_user_modify_topic = true;
                    break;
                }
                // $has_cap_for_any_topic = false;
                if (isset($allowed_content['included']['topics']) && is_array($allowed_content['included']['topics']) && !empty($allowed_content['included']['topics'])) {
                    // $has_cap_for_any_topic = true;
                    $can_user_modify_topic = true;
                    break;
                }
            }

            return $can_user_modify_topic;
        }

        // Here 'Publish' =  Publish (or) Approve
        public function can_user_publish_any_topic()
        {
            $mod_caps = ['can_publish', 'can_approve'];

            $can_user_modify_topic = false;

            foreach ($mod_caps as $cap_name) {
                $allowed_content = $this->get_allowed_content($cap_name);
                $global_has_cap = $this->get_global_single_capability($cap_name);

                if ($global_has_cap == true) {
                    $can_user_modify_topic = true;
                    break;
                }
                // $has_cap_for_any_topic = false;
                if (isset($allowed_content['included']['topics']) && is_array($allowed_content['included']['topics']) && !empty($allowed_content['included']['topics'])) {
                    // $has_cap_for_any_topic = true;
                    $can_user_modify_topic = true;
                    break;
                }
            }

            return $can_user_modify_topic;
        }

        public function get_final_topic_has_cap($term_id, $cap_name)
        {

            // $term = get_term($term_id, 'helpdesk_category');
            $topic_has_cap = $this->does_term_have_caps($term_id, $cap_name);
            $global_has_cap = $this->get_global_single_capability($cap_name);

            $condition1 = ($topic_has_cap !== 'none' && $topic_has_cap == true);
            $condition2 = ($topic_has_cap === 'none' && $global_has_cap == true);

            if ($condition1 || $condition2) {
                return true;
            } else {
                return false;
            }
        }

        public function get_final_article_has_cap($post_id, $cap_name)
        {

            $article_has_cap = $this->get_article_single_capability($post_id, $cap_name);
            $terms_ids = $this->access_helper->get_terms_without_filter($post_id);

            $topic_has_cap = 'none';

            if (isset($terms_ids) && !empty($terms_ids)) {
                foreach ($terms_ids as $term_id) {
                    $has_cap = $this->does_term_have_caps($term_id, $cap_name);

                    if ($has_cap == false) {
                        $topic_has_cap = false;
                        break;
                    } else if ($has_cap !== 'none' && $has_cap == true) {
                        $topic_has_cap = true;
                    }
                }
            }

            $global_has_cap = $this->get_global_single_capability($cap_name);

            $condition1 = ($article_has_cap !== 'none' && $article_has_cap == true);
            $condition2 = ($article_has_cap === 'none' && $topic_has_cap !== 'none' && $topic_has_cap == true);
            $condition3 = ($article_has_cap === 'none' && $topic_has_cap === 'none' && $global_has_cap == true);

            // error_log('$cap_name : ' . $cap_name);
            // error_log('$condition1 : ' . $condition1);
            // error_log('$condition2 : ' . $condition2);
            // error_log('$condition3 : ' . $condition3);
            if ($condition1 || $condition2 || $condition3) {
                return true;
            } else {
                return false;
            }
        }

        protected function does_term_have_caps($term_id, $cap_name)
        {
            $topic_has_cap = 'none';

            // $term_lineage is the ancestry of term including self in lowest to highest in hierrachy.
            // That is, first item is term itself and last item is the top most parent term
            $term_lineage = get_ancestors($term_id, 'helpdesk_category');
            array_unshift($term_lineage, $term_id);

            foreach ($term_lineage as $single_term_id) {

                $has_cap = $this->get_topic_single_capability($single_term_id, $cap_name);


                if ($has_cap == false) {
                    $topic_has_cap = false;
                    break;
                } else if ($has_cap !== 'none' && $has_cap == true) {
                    $topic_has_cap = true;
                    break;
                }


                // error_log(' $single_term_id: ' . $single_term_id);
                // error_log('$topic_has_cap : ' . $topic_has_cap);
            }




            return $topic_has_cap;
        }

        public function get_global_single_capability($cap_name)
        {

            if (current_user_can('administrator')) {
                return true;
            }

            $user_id = $this->user_id;
            $rule_set = $this->cap_settings['global'][$cap_name];

            $args = array(
                'user_id' => $user_id,
                'rule_set' => $rule_set,
                'item_id' => 'global',
                'type' => 'global',
                'cap_settings' => $this->cap_settings,
            );

            // error_log('get_global_single_capability $args : ' . print_r($args['rule_set'], true));
            return $this->strategy->has_cap($args);
        }

        public function get_article_single_capability($post_id, $cap_name)
        {

            if (current_user_can('administrator')) {
                return true;
            }
            $user_id = $this->user_id;

            $rule_set = isset($this->cap_settings['posts'][$post_id][$cap_name]) ? $this->cap_settings['posts'][$post_id][$cap_name] : array();

            $args = array(
                'user_id' => $user_id,
                'rule_set' => $rule_set,
                'item_id' => $post_id,
                'type' => 'post',
                'cap_settings' => $this->cap_settings,
            );

            // error_log('$cap_name : ' . $cap_name);
            // error_log('$this->cap_settings : ' . print_r($this->cap_settings['posts'][$post_id], true));
            // error_log('$args - ruleset : ' . print_r($args['rule_set'], true));
            return $this->strategy->has_cap($args);
        }

        public function get_topic_single_capability($term_id, $cap_name)
        {

            if (current_user_can('administrator')) {
                return true;
            }

            $user_id = $this->user_id;

            if (isset($this->cap_settings['topics'][$term_id])) {
                $rule_set = $this->cap_settings['topics'][$term_id][$cap_name];
            } else {
                $rule_set = $this->cap_settings_cls->default_item_rules($cap_name);
            }

            $args = array(
                'user_id' => $user_id,
                'rule_set' => $rule_set,
                'item_id' => $term_id,
                'type' => 'topic',
                'cap_settings' => $this->cap_settings,
            );

            return $this->strategy->has_cap($args);
        }

        /* Protected */

        protected function get_single_capability($cap_name, $item_id, $type = 'topic')
        {

            $post_id = $item_id;
            $term_id = $item_id;

            $post_has_topic_rule = false;

            if ($type == 'topic' || ($type == 'post' && $post_has_topic_rule)) {
                $has_topic_cap = $this->get_topic_single_capability($term_id, $cap_name);
                return $has_topic_cap;
            } else {
                $has_article_cap = $this->get_article_single_capability($post_id, $cap_name);
                return $has_article_cap;
            }
        }
    } // END CLASS

}