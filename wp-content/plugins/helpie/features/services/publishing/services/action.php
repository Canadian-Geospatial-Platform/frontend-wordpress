<?php

namespace Helpie\Features\Services\Publishing\Services;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * class only has action methods related to publishing
 * this is parent class of Publishing_Service and we seperate action from it
 */
if (!class_exists('\Helpie\Features\Services\Publishing\Services\Action')) {
    class Action
    {
        public function publish_ajax_action()
        {
            // get validated and sanitized post request fields
            $postData = $this->process_post_data();
            $publishing_capabilities = $this->get_current_user_publishing_capability();

            // publish postdata of front-editors
            $post_id = $this->wp_service->publish($postData, $publishing_capabilities);
            $response = array(
                'post_id' => $post_id,
                'permalink' => get_the_permalink($post_id),
            );

            // formating array to json
            print_r(json_encode($response, JSON_NUMERIC_CHECK));
            wp_die(); // this is required to terminate immediately and return a proper response
            wp_reset_postdata();
        }

        public function get_revision()
        {
            if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
                $post_id = $_POST['post_id'];
            }

            if (isset($_POST['revision_id']) && !empty($_POST['revision_id'])) {
                $revision_id = $_POST['revision_id'];
            }

            if (isset($_POST['previous_revision_id']) && !empty($_POST['previous_revision_id'])) {
                $previous_revision_id = $_POST['previous_revision_id'];
            }

            if (!isset($revision_id)) {
                echo __("No Revision ID", "pauple-helpie");
                wp_die();
            }

            // Gets a post revision
            $post = wp_get_post_revision($revision_id);

            $diff_array = array(
                '0' => array('diff' => 'No Change'),
            );
            if (isset($previous_revision_id)) {

                // Filters the fields displayed in the post revision diff UI.
                require ABSPATH . 'wp-admin/includes/revision.php';
                $diff_array = wp_get_revision_ui_diff($post_id, $revision_id, $previous_revision_id);
            }

            $post_props = array(
                'title' => $post->post_title,
                'content' => $post->post_content,
                'diff_array' => $diff_array,
            );

            // formating array to json
            print_r(json_encode($post_props, JSON_NUMERIC_CHECK));

            wp_die(); // this is required to terminate immediately and return a proper response

            wp_reset_postdata();
        }

        public function publish_img_ajax_action()
        {
            if (isset($_POST['post_id']) && !empty($_POST['post_id'])) {
                $post_id = $_POST['post_id'];
                if (isset($_POST['attachment_id']) && !empty($_POST['attachment_id'])) {
                    // Sets a post thumbnail
                    set_post_thumbnail($post_id, $_POST['attachment_id']);
                }
                $response['src'] = \get_the_post_thumbnail_url($post_id);
            } else {
                $response['attachment_id'] = (isset($_POST['attachment_id'])) ? $_POST['attachment_id'] : false;
            }
            print_r(json_encode($response, JSON_NUMERIC_CHECK));
            wp_die(); // this is required to terminate immediately and return a proper response
            wp_reset_postdata();
        }

        public function delete_single_article()
        {
            $article_id = 0;
            $option = 'trash';
            if (isset($_POST['article_id'])) {
                $article_id = sanitize_text_field($_POST['article_id']);
            }
            $option = sanitize_text_field($_POST['option']);

            switch ($option) {
                case "trash":
                    // Moves a post to the Trash
                    $delete_response = wp_trash_post($article_id);
                    break;
                case "delete":
                    // Removes or trashes a post
                    $delete_response = wp_delete_post($article_id);
                    break;
            }

            if (is_object($delete_response)) {
                $operation_status = true;
            } else {
                $operation_status = false;
            }

            $response = array(
                'article_id' => $article_id,
                'operation_status' => $operation_status,
                'forward_to' => $this->helpie_model->get_mainpage_permalink(),
            );

            print_r(json_encode($response, JSON_NUMERIC_CHECK));
            wp_die();
        }

        public function delete_revision_ajax_action()
        {
            $revision_id = sanitize_text_field($_POST['revision_id']);

            // Deletes the row from the posts table corresponding to the specified revision
            $response = wp_delete_post_revision($revision_id);

            // Get the type of a variable @gettype
            if (gettype($response) == 'WP_Post') {
                echo 1;
            }
            wp_die(); // this is required to terminate immediately and return a proper response
        }

    }
}
