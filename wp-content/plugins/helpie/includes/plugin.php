<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('\Helpie_Kb_Plugin')) {
    class Helpie_Kb_Plugin
    {
        public $plugin_domain;
        public $views_dir;
        public $version;

        public function __construct()
        {
            $this->setup_autoload();
            $this->hooks();
            $this->load_files();
            $this->trackers();

            require HELPIE_PLUGIN_PATH . 'includes/class-helpie.php';

            $plugin = new \Helpie\Includes\PAUPLE_HELPIE();
            $plugin->run();
        }

        public function hooks()
        {
            /* Hooks */
            // add_action('init', array($this, 'register_load_hooks'));
            // error_log(' WP_FS__LOWEST_PRIORITY: ' . WP_FS__LOWEST_PRIORITY);
            // add_action('init', [$this, 'setup_options_init']);
            add_action('wp_loaded', array($this, 'wp_loaded'));
            register_activation_hook(HELPIE_PLUGIN_FILE_PATH, array($this, 'activate_plugin_name'));
            register_deactivation_hook(HELPIE_PLUGIN_FILE_PATH, array($this, 'deactivate_plugin_name'));

            remove_filter('term_description', 'wpautop'); // Remove <p> from term_description
            add_action('wp_enqueue_scripts', [$this, 'register_scripts']);

            if (HELPIE_KB_VENDOR == 'envato') {
                add_action('admin_menu', [$this, 'register_updates_page']);
            }

            /* Register Actions */
            $actions = new \Helpie\Features\Services\Actions();
        }

        public function register_scripts()
        {
            $script_handler = new \Helpie\Includes\Core\Scripts_Handler();
            $script_handler->register_scripts();
        }

        public function wp_loaded()
        {
            set_all_helpie_kb_topics();

            $query_service = \Helpie\Features\Services\Query::getInstance();
            $query_service->set_posts_by_topic();

            /* Responsible for filtering posts and terms by restrictions across entire plugin */
            $access_controller = new \Helpie\Features\Services\Access_Control\Controller();
            $access_controller->hooks();
        }

        public function load_files()
        {
            /* Must Load as earlier as possible */
            include_once HELPIE_PLUGIN_PATH . 'config/env.php';
            $this->load_hooked_classes();
        }

        public function load_hooked_classes()
        {
            // Includes
            // Need to load ajax handlers on start
            include_once HELPIE_PLUGIN_PATH . 'includes/core/ajax-handler.php';
            include_once HELPIE_PLUGIN_PATH . 'includes/core/class-cpt.php';
            include_once HELPIE_PLUGIN_PATH . 'includes/user-capabilities.php';
            include_once HELPIE_PLUGIN_PATH . 'includes/translations.php';

            include_once HELPIE_PLUGIN_PATH . 'includes/shortcodes.php';
            include_once HELPIE_PLUGIN_PATH . 'includes/widgets/helpie-widgets.php';
            include_once HELPIE_PLUGIN_PATH . 'includes/functions.php';

            $option_actions = new \Helpie\Includes\Actions\Option_Actions();
            $term_actions = new \Helpie\Includes\Actions\Term_Actions();
            $filters = new \Helpie\Includes\Actions\Filters();
            $autolinking = new \Helpie\Features\Services\Autolinking\Autolinking();
            $settings = new \Helpie\Includes\Settings();

            $this->load_update_handler();
            $register_templates = new \Helpie\Includes\Core\Register_Templates();

            $widgets = new \Helpie\Includes\Widgets\Register_Widgets();
            $widgets->load();

            $elementor_widgets = new \Helpie\Includes\Widgets\Register_Elementor_Widgets();
            $elementor_widgets->load();

            /* Password Protection Widget, Components Single Items and Content Hook */
            $password_controller = new \Helpie\Features\Services\Password_Protect\Controller();
            $password_controller->load_hooks();

            /* Admin Only  */
            if (is_admin()) {
                $insights = new \Helpie\Features\Components\Insights\Insights();

                require_once HELPIE_PLUGIN_PATH . 'includes/admin/admin-ajax.php';
                $this->envato_update_setup();
                $this->editor_controller = new \Helpie\Features\Components\Frontend_Editor\Editor_Controller();

                // Onboarding page with menu
                $onboarding = new \Helpie\Features\Components\Onboarding\Controller();
            }

            /* Force Elementor Template Support to add our CPT */
            add_filter('elementor_pro/utils/get_public_post_types', function ($post_types) {
                $settings = new \Helpie\Includes\Settings\Getters\Settings();
                $post_types[HELPIE_POST_TYPE] = $settings->single_page->get_single_cpt_name();
                return $post_types;
            });

            $this->kb_wp_notices();
        }

        public function trackers()
        {
            /* Tracks Modal Status */
            global $helpie_password_modal;
            $helpie_password_modal = 0;
        }

        public function register_updates_page()
        {
            // This page will be under "Settings"
            \add_submenu_page(
                'edit.php?post_type=pauple_helpie',
                __('Updates', 'pauple-helpie'),
                __('Updates', 'pauple-helpie'),
                'activate_plugins',
                'Helpie',
                array($this, 'create_info_page')
            );
        }

        public function create_info_page()
        {
            echo '<div class="wrap helpie-settings-page-wrap">';
            $helpie_info_view = new \Helpie\Includes\Settings\Helpie_Info\Helpie_Info_View();
            $helpie_info_view->render();
            echo "</div>";
        }
        public function envato_update_setup()
        {
            /* TODO:  \Helpie\Includes\Core\Envato\Envato_Update is called in 2 places. Write code for bi-vendor update */
            /* Initiate Envato Update API */
            if (HELPIE_KB_VENDOR == 'envato') {
                if (is_admin()) {
                    $envato_update = new \Helpie\Includes\Core\Envato\Envato_Update();
                    $envato_update->setup();
                }
            }
        }
        public function load_update_handler()
        {
            $run_update_handler = true;

            if ($run_update_handler == true) {
                // New updated migration
                $helpie_upgrades = new \Helpie\Includes\Update\Upgrades();
                $helpie_upgrades::add_actions();
            }
        }

        protected function setup_autoload()
        {
            require_once HELPIE_PLUGIN_PATH . 'includes/utils/autoloader.php';
            $autoloader = new \Helpie\Includes\Utils\AutoLoader();
            $autoloader->load(HELPIE_MODE);
        }

        public static function activate_plugin_name($network_wide)
        {
            global $wpdb;

            if (is_multisite() && $network_wide) {
                // Get all blogs in the network and activate plugin on each one
                $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
                foreach ($blog_ids as $blog_id) {
                    switch_to_blog($blog_id);
                    \Helpie\Includes\Core\Kb_Activator::activate();
                    restore_current_blog();
                }
            } else {
                \Helpie\Includes\Core\Kb_Activator::activate();
            }
        }

        public static function deactivate_plugin_name()
        {
            \Helpie\Includes\Core\Kb_Deactivator::deactivate();
        }

        public function kb_wp_notices()
        {
            $search = [
                'title' => 'Helpdesk Search',
                'name' => 'helpdesk_search',
                'content' => 'Helpdesk Search Page was deleted. Do you want to',
                'page_content' => '[pauple_helpie_search_results_page]',
                'dismiss_status' => 'helpdesk_search_notice_dismissed',
                'type' => 'warning',
            ];

            $editor = [
                'title' => 'Helpie Editor',
                'name' => 'helpie_editor',
                'content' => 'Frontend Editor Page was deleted. Do you want to',
                'dismiss_status' => 'restore_editor_page_notice_dismissed',
                'type' => 'warning',
            ];

            $onboard = [
                'title' => 'Onboarding',
                'name' => 'onboarding',
                'dismiss_status' => 'onboarding_setup_notice_dismissed',
                'type' => 'info',
                'content' => 'Setup your first content and choose your favourite demo to import !!!',
            ];

            new \Helpie\Includes\Utils\Notice($search);
            new \Helpie\Includes\Utils\Notice($editor);
            new \Helpie\Includes\Utils\Notice($onboard);
        }
    } // END CLASS

}

new Helpie_Kb_Plugin();
