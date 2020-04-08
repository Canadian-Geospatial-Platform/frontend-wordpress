<?php

namespace Helpie\Includes\Admin;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class PAUPLE_HELPIE_ADMIN_CLS
{
    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function is_helpie_enqueue_page($hook_suffix)
    {

        $is_settings_page = (isset($_GET['page']) && ($_GET['page'] == 'helpie-kb-settings'));
        if (
            $hook_suffix == 'pauple_helpie_page_pauple-insights'
            || $hook_suffix == 'pauple_helpie_page_Helpie'
            || $hook_suffix == 'pauple_helpie_page_helpie_setttings_page'
            || $hook_suffix == 'widgets.php'
            || (isset($_GET['post_type']) && ($_GET['post_type'] == 'pauple_helpie') && ($hook_suffix == 'edit-tags.php' || $hook_suffix == 'term.php'))
            || $is_settings_page
            || $hook_suffix == 'pauple_helpie_page_onboarding'
        ) {
            return true;
        } else {
            return false;
        }
    }

    public function enqueue_styles($hook_suffix)
    {
        if ($this->is_helpie_enqueue_page($hook_suffix) == true) {
            wp_enqueue_style('helpie-password', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/password-strength-meter/password.min.css', array(), null);
            wp_enqueue_style('font-awesome', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/font-awesome/css/font-awesome.min.css', array(), null);
            wp_enqueue_style('semantic-ui', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/semantic/bundle/semantic.min.css', array(), $this->version, null);
            wp_enqueue_style('dragula-css', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/dragula/dragula.min.css', array(), null);

            /* Color Picker */
            wp_enqueue_style('color-picker', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/minicolors/jquery.minicolors.css', array(), null);
        }
        wp_enqueue_style($this->plugin_name, HELPIE_PLUGIN_URL . 'includes/asset-files/bundle/css/kb-admin-app.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts($hook_suffix)
    {

        if ($this->is_helpie_enqueue_page($hook_suffix) == true) {

            wp_enqueue_script('helpie-password', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/password-strength-meter/password.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script('semantic-ui', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/semantic/bundle/semantic.min.js', array('jquery'), $this->version, true);

            /* Color Picker */
            wp_enqueue_script('color-picker', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/minicolors/jquery.minicolors.min.js', array('jquery'), $this->version, false);

            if (isset($_GET['page']) && $_GET['page'] == 'pauple-insights') {
                /* Chart Js for Insights */
                wp_enqueue_script('ChartJS', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/chart-js/chart.bundle.min.js', array('jquery'), $this->version, false);
            }

            /* Cookie Js for Password Protection */
            wp_enqueue_script('cookie-js', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/cookie-js/cookie.min.js', array('jquery'), $this->version, true);

            // kb admin app bundle scripts entry
            $this->enqueue_helpie_admin_script();

            // envato update scripts
            $this->load_envato_update_scripts();

            // Drag and drop for category in helpie settings
            $this->enqueue_drag_and_drop_script();

            // Passsword Protect Settings
            $this->enqueue_password_protect_settings_js();
        }
    }

    protected function load_envato_update_scripts()
    {
        $helpie_update_nonce = wp_create_nonce('helpie_update_nonce');
        wp_localize_script($this->plugin_name, 'helpieUpdateNonce', $helpie_update_nonce);
    }

    public function enqueue_helpie_admin_script()
    {
        wp_enqueue_script($this->plugin_name, HELPIE_PLUGIN_URL . 'includes/asset-files/bundle/js/kb-admin-app.bundle.js', array('jquery'), $this->version, true);

        $helpie_wa_image = '';
        $helpie_wa_image_url = '';

        $helpie_style_options = get_option('helpie_style_options', 0);

        if (isset($helpie_style_options) && !empty($helpie_style_options)) {
            if (isset($helpie_style_options['helpie_wa_image'])) {
                $helpie_wa_image = $helpie_style_options['helpie_wa_image'];
                $helpie_wa_image_url = wp_get_attachment_url($helpie_wa_image);
            }
        }

        if ($helpie_wa_image != '' && isset($helpie_wa_image)) {
            // $helpie_wa_image = '';
            wp_localize_script($this->plugin_name, 'helpie_wa_image', $helpie_wa_image);
        }

        if ($helpie_wa_image_url != '' && isset($helpie_wa_image_url)) {
            wp_localize_script($this->plugin_name, 'helpie_wa_image_url', $helpie_wa_image_url);
        }

        $helpie_insights_nonce = wp_create_nonce('helpie_search_nonce');
        wp_localize_script($this->plugin_name, 'helpieInsightsNonce', $helpie_insights_nonce);
        wp_localize_script($this->plugin_name, 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    protected function enqueue_drag_and_drop_script()
    {
        $helpie_mp_options = get_option('helpie_mp_options');
        $article_dnd_nonce = wp_create_nonce('article_dnd_nonce');

        $helpie_dnd_include = 'empty-value';

        if (isset($helpie_mp_options)) {
            if (isset($helpie_mp_options['helpie_mp_cats']) && !empty($helpie_mp_options['helpie_mp_cats'])) {
                $helpie_mp_cats = $helpie_mp_options['helpie_mp_cats'];
                $helpie_dnd_include = $helpie_mp_cats;
            }
        }

        wp_enqueue_script('dragula-js', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/dragula/dragula.min.js', array('jquery'), $this->version, true);

        wp_localize_script($this->plugin_name, 'articleDNDNonce', $article_dnd_nonce);
        wp_localize_script($this->plugin_name, 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

        wp_localize_script($this->plugin_name, 'MainPageDNDTerms', $helpie_dnd_include);
    }

    protected function enqueue_password_protect_settings_js()
    {
        $handle = $this->plugin_name;

        // translatable Strings to passing javascripts
        $translatable_js_strings = array(
            'shortPass' => __('The password is too short', 'pauple-helpie'),
            'badPass' => __('Weak: try combining letters & numbers', 'pauple-helpie'),
            'goodPass' => __('Medium: try using special characters', 'pauple-helpie'),
            'strongPass' => __('Strong password', 'pauple-helpie'),
            'enterPass' => __('Type your password', 'pauple-helpie'),
        );

        $helpie_password_protect_nonce = wp_create_nonce('helpie_password_protect_nonce');
        wp_localize_script($handle, 'passwordProtectNonce', $helpie_password_protect_nonce);
        wp_localize_script($handle, 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

        // You Can Access these object from javascript
        wp_localize_script($handle, 'translatble_strings', $translatable_js_strings);
    }
}
