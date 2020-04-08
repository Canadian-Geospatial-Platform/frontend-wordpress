<?php

namespace Helpie\Includes\Core;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Core\Register_Templates')) {
    class Register_Templates
    {
        public function __construct()
        {
            add_filter('single_template', array($this, 'single_template_callback'));
            add_filter('archive_template', array($this, 'get_custom_post_type_template'));
            add_filter('taxonomy_template', array($this, 'get_cpt_category_template'));
            add_filter('page_template', array($this, 'assign_custom_templates'));
            add_action('template_redirect', array($this, 'redirect_search'));
            add_filter('template_include', array($this, 'template_chooser'));

            // priority set for 16 to overwrite the yoast-seo-premium-plugin hook
            add_filter('pre_get_document_title', [$this, 'fallback_helpie_archive_title'], 16);
            add_filter('wp_title', [$this, 'fallback_helpie_archive_title'], 16);
            add_action('wp_head', [$this, 'helpie_archive_description']);
            add_filter('document_title_parts', array($this, 'helpie_template_titles'));

            add_filter('body_class', array($this, 'editor_body_class'));

            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function editor_body_class($classes)
        {
            global $post;

            if (isset($post) && !empty($post)) {
                $page_id = $post->ID;
                $helpie_editor_page_id = get_option('helpie_editor_page_id');
                if ($helpie_editor_page_id == $page_id) {
                    $classes[] = 'helpie-editor-page';
                }
            }

            return $classes;
        }

        public function fallback_helpie_archive_title($title)
        {
            if (is_post_type_archive('pauple_helpie')) {
                $title = $this->settings->main_page->get_mp_meta_title();
            }
            return $title;
        }

        public function helpie_archive_description()
        {
            if (is_post_type_archive('pauple_helpie')) {
                echo '<meta name="description" content="' . $this->settings->main_page->get_mp_meta_description() . '">';
            }
        }

        public function helpie_template_titles($title_parts)
        {
            global $wp_query, $post;

            if (isset($post) && !empty($post)) {
                /* Checks for single template by post type */
                if ($post->post_type == 'pauple_helpie' && is_single()) {
                    // $post = get_post(get_the_ID());
                    $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($post);
                    $title_parts['title'] = __($kb_article->get_title(), 'pauple-helpie');
                } elseif (is_post_type_archive('pauple_helpie')) {
                    $title_parts['title'] = __($this->settings->main_page->get_mp_meta_title(), 'pauple-helpie');
                }
            }

            return $title_parts;
        }

        public function single_template_callback($single)
        {
            global $wp_query, $post;

            $template_source = $this->settings->single_page->get_template_source();

            if ($template_source == 'elementor') {
                return $single;
            }

            /* Checks for single template by post type */
            if ($post->post_type == 'pauple_helpie' && is_single()) {
                if (file_exists(HELPIE_PLUGIN_PATH . '/templates/single-pauple_helpie.php')) {
                    return HELPIE_PLUGIN_PATH . '/templates/single-pauple_helpie.php';
                }
            }

            return $single;
        }

        public static function get_custom_post_type_template($archive_template)
        {
            global $post;
            if (is_post_type_archive('pauple_helpie')) {
                if (file_exists(HELPIE_PLUGIN_PATH . '/templates/archive-pauple_helpie.php')) {
                    $archive_template = HELPIE_PLUGIN_PATH . '/templates/archive-pauple_helpie.php';
                }
            }

            return $archive_template;
        }

        public static function get_cpt_category_template($archive_template)
        {
            global $post;
            if (is_tax('helpdesk_category')) {

                if (file_exists(HELPIE_PLUGIN_PATH . '/templates/category-pauple_helpie.php')) {
                    $archive_template = HELPIE_PLUGIN_PATH . '/templates/category-pauple_helpie.php';
                }
            }

            return $archive_template;
        }

        public static function assign_custom_templates($page_template)
        {
            global $post;
            $page_id = $post->ID;
            $plugin_search_option = get_option('helpdesk_search_page_id');
            $helpie_editor_page_id = get_option('helpie_editor_page_id');
            if ($plugin_search_option == $page_id) {
                $page_template = HELPIE_PLUGIN_PATH . '/templates/search-results-page.php';
            } elseif ($helpie_editor_page_id == $page_id) {
                $page_template = HELPIE_PLUGIN_PATH . '/templates/frontend-editor-template.php';
            }

            return $page_template;
        }

        public static function redirect_search()
        {
            if (isset($_REQUEST['custom_search'])) {
                $plugin_search_option = get_option('helpdesk_search_page_id');
                $search_page_id = $plugin_search_option;
                $new_url = add_query_arg(array(
                    'search' => urlencode($_REQUEST['custom_search']),
                ), get_page_link($search_page_id));
                wp_redirect($new_url);

                exit();
            }
        }

        public static function template_chooser($template)
        {
            global $wp_query;
            $post_type = get_query_var('post_type');

            if (isset($_REQUEST['custom_search'])) {
                return locate_template('search-results-page.php'); //  redirect to archive-search.php
            }

            return $template;
        }
    }
}