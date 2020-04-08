<?php

namespace Helpie\Includes\Core;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Core\Scripts_Handler')) {
    class Scripts_Handler
    {

        public function register_scripts()
        {
            $this->version = HELPIE_PLUGIN_VERSION;

            $this->register();
            $this->enqueue();

            $this->register_and_enqueue_frontend_editor_scripts();
        }

        public function register()
        {
            $this->register_semantic();
            $this->register_kb_frontend_scripts();
        }

        public function register_kb_frontend_scripts()
        {

            $handle = 'kb-frontend-app';
            $list = 'enqueued';

            // translatable Strings to passing javascripts
            $translatable_strings = new \Helpie\Features\Components\Partials\Translate_Strings();
            $loco_strings = $translatable_strings->get_strings();

            // Enqueue Scripts if Not already included
            if (!wp_script_is($handle, $list)) {
                $helpie_kb_frontend_nonce = wp_create_nonce('helpie_kb_frontend_nonce');

                wp_register_script($handle, HELPIE_PLUGIN_URL . 'includes/asset-files/bundle/js/kb-frontend-app.bundle.js', array('jquery'), HELPIE_PLUGIN_VERSION, true);

                // Supplements
                wp_localize_script($handle, 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

                wp_localize_script($handle, 'helpieKBFrontEndNonce', $helpie_kb_frontend_nonce);
                wp_localize_script($handle, 'helpieGlobal', array('plugin_url' => HELPIE_PLUGIN_URL));
                wp_localize_script($handle, 'domain', $this->get_site_domain());
                // You Can Access these object from javascript
                wp_localize_script($handle, 'helpie_strings', $loco_strings);
            }
        }

        public function enqueue()
        {
            $this->load_dependencies();
            $this->new_semantic_enqueue();
            $this->enqueue_kb_frontend_scripts();
        }

        public function register_semantic()
        {

            $handle = 'semantic-ui';
            // SEMANTIC
            wp_register_style($handle, HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/semantic/bundle/semantic.min.css', array(), $this->version, null);
            wp_register_script($handle, HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/semantic/bundle/semantic.min.js', array('jquery'), $this->version, true);
        }

        public function new_semantic_enqueue()
        {
            $handle = 'semantic-ui';
            $list = 'enqueued';
            if (!wp_script_is($handle, $list)) {
                wp_enqueue_style($handle);
                wp_enqueue_script($handle);
            }
        }

        public function enqueue_semantic_scripts()
        {

            $version = HELPIE_PLUGIN_VERSION;
            $handle = 'semantic-ui';
            $list = 'enqueued';

            // Enqueue this script if not already done
            if (!wp_script_is($handle, $list)) {
                wp_enqueue_style($handle, HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/semantic/bundle/semantic.min.css', array(), $version, null);
                wp_enqueue_script($handle, HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/semantic/bundle/semantic.min.js', array('jquery'), $version, true);
            }
        }

        public function get_site_domain()
        {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $domainName = $_SERVER['HTTP_HOST'] . '/';
            return $protocol . $domainName;
        }

        public function enqueue_kb_frontend_scripts()
        {
            $handle = 'kb-frontend-app';
            $list = 'enqueued';
            if (!wp_script_is($handle, $list)) {
                wp_enqueue_script('toastr-notification', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/toastr/toastr.js', array('jquery'), HELPIE_PLUGIN_VERSION, true);
                wp_enqueue_script('toastr-notification', '', array('jquery'), HELPIE_PLUGIN_VERSION, true);
                wp_enqueue_script('kb-frontend-app');
            }
        }

        public function load_dependencies()
        {

            /* STYLES */
            wp_enqueue_style('font-awesome', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/font-awesome/css/font-awesome.min.css', array(), null);
            wp_enqueue_style('font-awesome-animated', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/font-awesome/css/font-awesome-animated.min.css', array(), null);
            wp_enqueue_style('jquery-autocomplete-css', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/autocomplete/styles.css', array(), HELPIE_PLUGIN_VERSION, 'all');
            wp_enqueue_style('highlight-syntax', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/prism/prism.css', array(), HELPIE_PLUGIN_VERSION, null);
            wp_enqueue_style('toastr-notification', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/toastr/toastr.min.css', array(), HELPIE_PLUGIN_VERSION, null);

            /* SCRIPTS */
            wp_enqueue_script('highlight-syntax', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/prism/prism.js', array('jquery'), HELPIE_PLUGIN_VERSION, true);
        }

        protected function is_frontend_editor_page()
        {
            global $wp_query, $post;

            $is_editor = false;

            if (isset($post) && $post != null) {
                $page_id = $post->ID;
                $helpie_editor_page_id = get_option('helpie_editor_page_id');
                $is_editor = ($helpie_editor_page_id == $page_id);
            }

            return $is_editor;
        }

        public function register_kb_frontend_style()
        {

            $handle = 'kb-frontend-app';

            if (!wp_style_is($handle, 'enqueued')) {
                wp_enqueue_style($handle, HELPIE_PLUGIN_URL . 'includes/asset-files/bundle/css/kb-frontend-app.css', array(), HELPIE_PLUGIN_VERSION, 'all');
                $this->custom_styles = new \Helpie\Features\Services\Custom_Styles();
                $custom_css = $this->custom_styles->get_style_only();
                wp_add_inline_style($handle, $custom_css);
            }
        }

        /* Frontend Editor App Scripts */

        public function register_and_enqueue_frontend_editor_scripts()
        {

            $handle = 'kb-editor-app';

            if ($this->is_frontend_editor_page()) {
                error_log('Editor JS');
                $this->register_tinymce($handle);
                wp_enqueue_script('toastr-notification', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/toastr/toastr.js', array('jquery'), HELPIE_PLUGIN_VERSION, true);
                wp_enqueue_script('toastr-notification', '', array('jquery'), HELPIE_PLUGIN_VERSION, true);
                wp_register_script($handle, HELPIE_PLUGIN_URL . 'includes/asset-files/bundle/js/editor-app.bundle.js', array('jquery', 'toastr-notification'), HELPIE_PLUGIN_VERSION, true);
                $this->enqueue_frontend_editor($handle);
            }
        }

        protected function register_tinymce($handle)
        {
            if (!wp_script_is('tinymce_script', 'enqueued')) {
                $core_options = get_option('helpie_core_options_main');

                // Load Tinymce on the fly
                $js_src = includes_url('js/tinymce/') . 'tinymce.min.js';
                wp_register_script('tinymce_script', $js_src, array('jquery'), HELPIE_PLUGIN_VERSION, true);

                wp_enqueue_media();

                $inlite_js_src = includes_url('js/tinymce/') . 'themes/inlite/theme.min.js';
                wp_register_script('tinymce_inlite_script', $inlite_js_src, array('jquery'), HELPIE_PLUGIN_VERSION, true);
            }
        }

        protected function enqueue_frontend_editor($handle)
        {

            $list = 'enqueued';
            if (!wp_script_is($handle, $list)) {
                error_log('Not ENqueed');
                wp_enqueue_script('tinymce_script');
                wp_enqueue_script('tinymce_inlite_script');
                wp_enqueue_script($handle);
            }
        }
    } // END CLASS
}
