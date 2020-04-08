<?php

namespace Helpie\Features\Services\Publishing\Services;

if (!class_exists('\Helpie\Features\Services\Publishing\Services\WP_Service')) {
    class WP_Service
    {
        public function publish($postData, $publishing_capabilities)
        {
            $post_id = $this->insert_or_update_post($postData, $publishing_capabilities);
            if (isset($postData['category_id']) && !empty($postData['category_id'])) {
                $this->set_post_category($postData['category_id'], $post_id, $postData['parent_id']);
            }
            if (isset($postData['tags']) && !empty($postData['tags'])) {
                $this->set_post_tags($postData['tags'], $post_id);
            }

            return $post_id;
        }

        private function insert_or_update_post($postData, $publishing_capabilities)
        {
            // Create post object
            $post = array(
                'post_title' => $postData['post_title'],
                'post_type' => 'pauple_helpie',
                'post_content' => $postData['post_content'],
                'post_status' => 'publish',
            );

            $post_state = 'edit-article';

            if ($postData['post_state'] == 'add-article') {
                // Insert the post into the database
                $post_id = wp_insert_post($post);
                update_post_meta($post_id, '_edit_last', wp_get_current_user()->ID);
                if (isset($postData['attachment_id']) && !empty($postData['attachment_id']) && $postData['attachment_id']) {
                    set_post_thumbnail($post_id, $_POST['attachment_id']);
                }

            } else {
                $post_status = get_post_status($postData['post_id']);
                $can_publish = $publishing_capabilities['can_publish'];
                $can_approve = $publishing_capabilities['can_approve'];

                $cannot_publish_or_approve = ($can_publish == false && $can_approve == false);

                if ($post_status == 'pending' && $cannot_publish_or_approve) {
                    $post['post_status'] = 'pending';
                }

                $this->set_modified_author($postData);

                $post['ID'] = $postData['post_id'];
                $post_id = wp_update_post($post);
            }

            return $post_id;
        }

        private function set_post_category($category_id, $post_id, $parent_id)
        {
            // Set 'helpdesk_category' value
            $taxonomy = 'helpdesk_category';
            // error_log(' Term Id : '. print_r($category_id, true));
            // error_log('Parent Term ID : '. $parent_id);
            if (isset($parent_id) && !is_numeric($parent_id)) {
                $new_term_slug = $parent_id;
                $term_insert_info = wp_insert_term($new_term_slug, $taxonomy);
                $parent_id = $term_insert_info['term_id'];
            }
            // Create new category if it does not exist.
            //  If the category_id is not numeric, it is the slug of the new category
            if (isset($category_id) && !is_numeric($category_id)) {
                $args = array('parent' => $parent_id);
                $new_term_slug = $category_id;
                $term_insert_info = wp_insert_term($new_term_slug, $taxonomy, $args);
                $category_id = $term_insert_info['term_id'];
            }

            if (isset($category_id) && !empty($category_id)) {
                $category_ids_array = array();
                array_push($category_ids_array, $category_id);
                wp_set_post_terms($post_id, $category_ids_array, $taxonomy);
            }

            return $category_id;
        }

        private function set_post_tags($tags, $post_id)
        {
            // Set 'helpie_tag' value
            if (isset($tags) && !empty($tags)) {
                $taxonomy = 'helpie_tag';
                wp_set_post_terms($post_id, $tags, $taxonomy);
            }
        }

        public function set_modified_author($postData)
        {
            $post = get_post($postData['post_id']);
            if ($postData['post_title'] !== $post->post_title || $postData['post_content'] !== $post->post_content) {
                update_post_meta($postData['post_id'], '_edit_last', wp_get_current_user()->ID);
            };
        }
    } // END CLASS
}
