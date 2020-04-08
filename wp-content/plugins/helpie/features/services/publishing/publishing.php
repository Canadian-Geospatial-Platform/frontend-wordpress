<?php

namespace Helpie\Features\Services\Publishing;

use Helpie\Features\Services\Publishing\Services\Action as Publishing_Action;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('\Helpie\Features\Services\Publishing\Publishing')) {
    class Publishing extends Publishing_Action
    {
        public function __construct()
        {
            $this->model = new \Helpie\Features\Services\Publishing\Publishing_Model();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->wp_service = new \Helpie\Features\Services\Publishing\Services\WP_Service();
            $this->helpie_model = new \Helpie\Includes\Core\Core_Models\Helpie_Model();
        }

        public function save_post_handler($post_id)
        {
            $myPost = get_post($post_id);
            $post_type = get_post_type($post_id);

            /**
             * If this isn't a 'pauple_helpie' post, don't update it.
             */

            if ("pauple_helpie" != $post_type) {
                return;
            }

            if ($myPost->post_modified_gmt == $myPost->post_date_gmt) {
                $this->new_post_handler($post_id);
            } else {
                $this->post_update_handler($post_id);
            }
        }

        protected function new_post_handler($post_id)
        {
            global $post;
            $post = get_post($post_id);

            $isAutoDraft = ($post->post_status == 'auto-draft');

            $this->save_current_post_revision($post);

            // check for specific user that needs this publish to pending. otherwise exit
            $publishing_capabilities = $this->get_current_user_publishing_capability($post_id);
            $can_publish = $publishing_capabilities['can_publish'];
            $can_approve = $publishing_capabilities['can_approve'];

            $cannot_publish = empty($can_publish) && empty($can_approve);


            /**
             * can publish capability and not a auto draft then update revision
             */

            if (($can_publish || $can_approve) && !$isAutoDraft) {

                /**
                 * update post meta of last_approved_revision for display revision
                 */
                $this->model->set_last_approved_revision($post_id);

                global $wpdb;
                $result = $wpdb->update(
                    $wpdb->posts,
                    array('post_status' => "publish"),
                    array('ID' => $post_id)
                );
                return;
            }

            /**
             * set post status as pending if can not publish capability
             */

            if ((($post->post_status == "publish" || "inherit") || $cannot_publish) && !$isAutoDraft) {

                global $wpdb;
                $result = $wpdb->update(
                    $wpdb->posts,
                    array('post_status' => "pending"),
                    array('ID' => $post_id)
                );
            }
        }

        protected function post_update_handler($post_id)
        {
            global $post;

            $post = get_post($post_id);
            $isNotAutoDraft = ($post->post_status !== 'auto-draft');
            $this->save_current_post_revision($post);
            $publishing_capabilities = $this->get_current_user_publishing_capability($post_id);

            if ($publishing_capabilities['can_publish'] || $publishing_capabilities['can_approve']) {
                $this->model->set_last_approved_revision($post_id);
                return;
            }
            if ($post->post_status == "publish" || $post->post_status == "inherit") {
                $last_approved_revision_id = get_post_meta($post->post_id, 'last_approved_revision', true);

                global $wpdb;
                $result = $wpdb->update(
                    $wpdb->posts,
                    array('post_status' => "awaiting"),
                    array('ID' => $post_id)
                );
            }
        }

        public function set_revision_count($num, $post)
        {
            if ('pauple_helpie' == $post->post_type) {
                $num = $this->settings->core->get_num_of_revisions();
            }

            return $num;
        }

        // Define new awaiting status for publishing on registering "paupole_helpie" CPT
        public function register_awaiting_post_status()
        {
            register_post_status('awaiting', array(
                'label' => _x('Changes Awaiting Approval', 'pauple_helpie'),
                'public' => true,
                'exclude_from_search' => false,
                'show_in_admin_all_list' => true,
                'show_in_admin_status_list' => true,
                'label_count' => _n_noop('Changes Awaiting Approval <span class="count">(%s)</span>', 'Changes Awaiting Approval <span class="count">(%s)</span>'),
            ));
        }

        public function custom_wpkses_post_tags($tags, $context)
        {
            if ('post' === $context) {
                $tags['iframe'] = array(
                    'src' => true,
                    'height' => true,
                    'width' => true,
                    'frameborder' => true,
                    'allowfullscreen' => true,
                );
            }
            return $tags;
        }

        public function get_current_user_publishing_capability($post_id = null, $editor_mode = 'add-article')
        {
            // error_log('$editor_mode : ' . $editor_mode);
            // Required
            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();

            $publishing_capabilities = array();

            if ($editor_mode == 'add-article') {
                $publishing_capabilities['can_edit'] = $dynamic_caps->can_user_edit_any_topic();
                $publishing_capabilities['can_publish'] = $dynamic_caps->can_user_publish_any_topic();
                $publishing_capabilities['can_approve'] = $dynamic_caps->can_user_approve_any_topic();
            } else {

                $publishing_capabilities['can_edit'] = $dynamic_caps->get_final_article_has_cap($post_id, 'can_edit');
                $publishing_capabilities['can_publish'] = $dynamic_caps->get_final_article_has_cap($post_id, 'can_publish');
                $publishing_capabilities['can_approve'] = $dynamic_caps->get_final_article_has_cap($post_id, 'can_approve');
            }
            // $post_id = get_the_ID();

            // error_log('$publishing_capabilities : ' . print_r($publishing_capabilities, true));

            return $publishing_capabilities;
        }

        // This is the general rule, you can add more rules in the particular component
        public function show_frontend_editor()
        {
            if ($this->settings->core->is_frontend_editing_enabled() != true) {
                return false;
            }
            $post_id = get_the_ID();
            $publishing_capabilities = $this->get_current_user_publishing_capability($post_id);

            $can_edit = ($publishing_capabilities['can_edit'] == true);
            $can_publish = ($publishing_capabilities['can_publish'] == true);
            $can_approve = ($publishing_capabilities['can_approve'] == true);

            if ($can_edit || $can_publish || $can_approve) {
                return true;
            }

            return false;
        }

        // This is the general rule, you can add more rules in the particular component
        public function show_add_new_article_button()
        {
            if ($this->settings->core->is_frontend_editing_enabled() != true) {
                return false;
            }
            $post_id = get_the_ID();
            $publishing_capabilities = $this->get_current_user_publishing_capability($post_id);

            $can_edit = ($publishing_capabilities['can_edit'] == true);
            $can_publish = ($publishing_capabilities['can_publish'] == true);
            $can_approve = ($publishing_capabilities['can_approve'] == true);

            if ($can_publish || $can_approve) {
                return true;
            }

            return false;
        }

        protected function save_current_post_revision($post)
        {
            /**
             *  @wp_get_post_revisions
             *  Returns all revisions of specified post or article.
             */

            if (0 < wp_get_post_revisions($post->ID) && !($post->post_status == 'auto-draft')) {

                /**
                 *  @wp_save_post_revision($post_id )
                 *  Creates a revision for the current version of a post.
                 */
                wp_save_post_revision($post->ID);
            }
        }

        /* PROTECTED METHODS */
        /**
         * sanitizing and validating text from given post request
         */
        protected function process_post_data()
        {
            $postData = array();

            if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
                $postData['post_id'] = sanitize_text_field($_POST['post_id']);
            }

            $postData['parent_id'] = sanitize_text_field($_POST['parent_id']);

            if (isset($_POST['post_title']) && !empty($_POST['post_title'])) {
                $postData['post_title'] = wp_strip_all_tags($_POST['post_title']);
            }

            if (isset($_POST['post_content']) && !empty($_POST['post_content'])) {
                $postData['post_content'] = wp_kses_post($_POST['post_content']);
            }

            if (isset($_POST['post_state']) && !empty($_POST['post_state'])) {
                $postData['post_state'] = sanitize_text_field($_POST['post_state']);
            } else {
                $postData['post_state'] = 'edit-article';
            }

            if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
                $postData['category_id'] = sanitize_text_field($_POST['category_id']);
            }

            if (isset($_POST['attachment_id']) && !empty($_POST['attachment_id'])) {
                $postData['attachment_id'] = sanitize_text_field($_POST['attachment_id']);
            }

            if (isset($_POST['tags']) && !empty($_POST['tags'])) {
                $postData['tags'] = sanitize_text_field($_POST['tags']);
                $postData['tags'] = explode(",", $postData['tags']);
            } else {
                $postData['tags'] = '';
            }

            return $postData;
        }
    } // END CLASS
}