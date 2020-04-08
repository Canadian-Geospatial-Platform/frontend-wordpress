<?php

namespace Helpie\Includes;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * The file that defines the core plugin class.
 */

/**
 * The core plugin class.
 *
 */

if (!class_exists('\Helpie\Includes\PAUPLE_HELPIE')) {
    class PAUPLE_HELPIE
    {
        /**
         * The loader that's responsible for maintaining and registering all hooks that power
         * the plugin.
         */

        protected $loader;

        /**
         * The unique identifier of this plugin.
         */

        protected $plugin_name;

        /**
         * The current version of the plugin.
         */

        protected $version;

        /**
         * Define the core functionality of the plugin.
         */

        public function __construct()
        {
            $this->plugin_name = 'pauple-helpie';
            $this->version = HELPIE_PLUGIN_VERSION;

            $this->load_dependencies();
            // $this->set_locale();
            $this->define_admin_hooks();
            $this->define_public_hooks();
        }

        /**
         * Load the required dependencies for this plugin.
         *
         * Include the following files that make up the plugin:
         *
         * - PAUPLE_HELPIE_LOADER_CLS. Orchestrates the hooks of the plugin.
         * - PAUPLE_HELPIE_i18n_CLS. Defines internationalization functionality.
         * - PAUPLE_HELPIE_ADMIN_CLS. Defines all hooks for the admin area.
         * - PAUPLE_HELPIE_PUBLIC_CLS. Defines all hooks for the public side of the site.
         *
         * Create an instance of the loader which will be used to register the hooks
         * with WordPress.
         *
         * @since    1.0.0
         */

        private function load_dependencies()
        {

            /**
             * The class responsible for orchestrating the actions and filters of the
             * core plugin.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-helpie-loader.php';

            /**
             * The class responsible for defining all actions that occur in the admin area.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/core/ajax-handler.php';
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/admin/class-helpie-admin.php';

            /**
             * The class responsible for defining all actions that occur in the public-facing
             * side of the site.
             */

            $publishing_service = new \Helpie\Features\Services\Publishing\Publishing();

            add_action('init', array($publishing_service, 'register_awaiting_post_status'));
            // add_action('post_updated', array( $publishing_service, 'post_update_handler'), 13, 2);
            add_action('save_post', array($publishing_service, 'save_post_handler'), 13, 2);

            // add_action('publish_pauple_helpie', array( $publishing_service, 'post_insert_handler'), 10, 3);

            add_filter('wp_revisions_to_keep', array($publishing_service, 'set_revision_count'), 10, 2);
            // add_filter('pre_get_posts', array( $publishing_service, 'pre_get_posts'));

            // require_once plugin_dir_path(dirname(__FILE__)).'/includes/asset-files/class-helpie-public.php';

            $this->loader = new \Helpie\Includes\PAUPLE_HELPIE_LOADER_CLS();
        }

        /*  Define the locale for this plugin for internationalization. */

        // private function set_locale()
        // {
        //     $plugin_i18n = new \Helpie\Includes\Core\Pauple_Helpie_I18n();
        //     // $plugin_i18n->load_plugin_textdomain();
        //     $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
        // }

        /**
         * Register all of the hooks related to the admin area functionality
         * of the plugin.
         */

        private function define_admin_hooks()
        {
            $plugin_admin = new \Helpie\Includes\Admin\PAUPLE_HELPIE_ADMIN_CLS($this->get_plugin_name(), $this->get_version());

            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
            $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

            /**
             * Calendar Plugin compatability Issue when our Insights page and their scripts
             * both uses Chart JS below hook to prevent Settings page CSF Scripts Error
             */
            if (isset($_GET['page']) && $_GET['page'] == 'pauple-insights') {
                add_action('admin_enqueue_scripts', function () {
                    wp_dequeue_script('csf');
                    wp_deregister_script('csf');
                }, 21);
            }
        }

        /**
         * Register all of the hooks related to the public-facing functionality
         * of the plugin.
         */
        private function define_public_hooks()
        {
            $plugin_public = new \Helpie\Includes\Asset_Files\Class_Helpie_Public($this->get_plugin_name(), $this->get_version());

            $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
            $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        }

        /**
         * Run the loader to execute all of the hooks with WordPress.
         */

        public function run()
        {
            $this->loader->run();
        }

        /**
         * The name of the plugin used to uniquely identify it within the context of
         * WordPress and to define internationalization functionality.
         */
        public function get_plugin_name()
        {
            return $this->plugin_name;
        }

        /**
         * The reference to the class that orchestrates the hooks with the plugin.
         */

        public function get_loader()
        {
            return $this->loader;
        }

        /**
         * Retrieve the version number of the plugin.
         */
        public function get_version()
        {
            return $this->version;
        }
    } // END CLASS
}
