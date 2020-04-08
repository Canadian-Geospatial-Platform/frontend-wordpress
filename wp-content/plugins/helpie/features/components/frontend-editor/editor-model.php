<?php

namespace Helpie\Features\Components\Frontend_Editor;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Features\Components\Frontend_Editor\Editor_Model')) {
    class Editor_Model
    {
        public function __construct()
        {
            $this->publishing_service = new \Helpie\Features\Services\Publishing\Publishing();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function get_viewProps($args = array())
        {
            $collectionProps = $this->get_collectionProps($args);
            $itemsProps = $this->get_itemsProps($collectionProps);

            $viewProps = array(
                'collection' => $collectionProps,
                'items' => $itemsProps,
            );

            return $viewProps;
        }

        public function get_collectionProps($args)
        {
            $collectionProps = array();

            $post_id = $this->get_post_id_from_url();

            // Current Post Info

            $collectionProps['post_id'] = $post_id;
            $collectionProps['post_thumbnail'] = $this->get_post_thumbnail($post_id);
            $collectionProps['published_revision_id'] = get_post_meta($post_id, 'last_approved_revision', true);
            $collectionProps['has_category'] = $this->has_category($post_id);
            $collectionProps['editor_mode'] = $this->get_editor_mode_from_url();
            $collectionProps['editor_type'] = $this->settings->core->get_editor_type();

            // error_log('$collectionProps : ' . print_r($collectionProps, true));

            // Publishing Permissions

            $publishing_capabilities = $this->publishing_service->get_current_user_publishing_capability($post_id, $collectionProps['editor_mode']);

            $collectionProps = array_merge($collectionProps, $publishing_capabilities);

            return $collectionProps;
        }

        public function get_post_thumbnail($post_id)
        {
            $thumbnail_url = plugins_url('includes/asset-files/images/article-cover-dummy.jpg', HELPIE_PLUGIN_FILE_PATH);
            $url = get_the_post_thumbnail_url($post_id);
            return (isset($url) && !empty($url)) ? $url : $thumbnail_url;

        }

        public function has_category($post_id)
        {
            if (isset($post_id)) {
                $post = get_post($post_id);
                $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($post);
                $category_id = $kb_article->get_category_id() ?: '';
            }

            $has_category = false;
            if ($category_id != '') {
                $has_category = true;
            }

            return $has_category;
        }

        public function get_post_id_from_url()
        {
            $post_id = 0;

            if (isset($_GET['post_id'])) {
                $post_id = sanitize_text_field($_GET['post_id']);
            }

            return $post_id;
        }

        public function get_editor_mode_from_url()
        {
            $editor_mode = 'edit-article';

            if (isset($_GET['editor_mode'])) {
                $editor_mode = sanitize_text_field($_GET['editor_mode']);
            }

            return $editor_mode;
        }

        public function get_itemsProps($collectionProps)
        {
            $revisionsProps = $this->get_revisionsProps($collectionProps);

            if (!isset($revisionsProps) || empty($revisionsProps)) {
                $itemsProps = array();

                $itemsProps[0] = $this->get_articleProps($collectionProps);
            } else {
                $itemsProps = $revisionsProps;
            }

            return $itemsProps;
        }

        public function get_articleProps($collectionProps)
        {
            $post_id = $collectionProps['post_id'];
            $post = get_post($post_id);

            $articleProps = array();

            $articleProps['id'] = $post->ID;
            $articleProps['title'] = $post->post_title;
            $articleProps['content'] = $post->post_content;

            // Remove shortcode filter
            // remove_filter('the_content', 'do_shortcode', 11);
            // $post_content = apply_filters('the_content', $post->post_content);

            return $articleProps;
        }

        public function get_revisionsProps($collectionProps)
        {
            $post_id = $collectionProps['post_id'];
            $post = get_post($post_id);

            $revisionsProps = array();
            $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($post);
            $revisions = $kb_article->get_revisions();

            $count = 0;
            foreach ($revisions as $revision) {
                $revisionsProps[$count] = array();
                $revisionsProps[$count]['id'] = $revision->ID;
                $revisionsProps[$count]['title'] = $revision->post_title;
                $revisionsProps[$count]['content'] = $revision->post_content;

                $count++;

                // Remove Shortcode filter from the_content filters
                // remove_filter('the_content', 'do_shortcode', 11);
                // manually applying get_the_content filters to revisions.
                // $revisionsProps[$count]['content'] = apply_filters('the_content', $revision->post_content);
            }

            return $revisionsProps;
        }

        public function get_revision_diff_array($post_id, $itemsProps)
        {
            $latest_revision_id = $itemsProps[0]['id'];

            if (isset($itemsProps[1]['id'])) {
                $penultimate_revision_id = $itemsProps[1]['id'];
            } else {
                $penultimate_revision_id = $latest_revision_id;
            }
            //Penultimate: One before last

            require ABSPATH . 'wp-admin/includes/revision.php';
            $diff_array = wp_get_revision_ui_diff($post_id, $latest_revision_id, $penultimate_revision_id);

            return $diff_array;
        }
    } // END CLASS
}
