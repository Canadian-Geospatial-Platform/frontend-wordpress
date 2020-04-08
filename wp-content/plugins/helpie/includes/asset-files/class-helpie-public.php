<?php

namespace Helpie\Includes\Asset_Files;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/**
 * The public-facing functionality of the plugin.
 */
class Class_Helpie_Public
{
    /**
     * The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->scripts_handler = new \Helpie\Includes\Core\Scripts_Handler();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles()
    {
        // This is now imported in helpie.scss directly
        // wp_enqueue_style('animate-css', plugin_dir_url(__FILE__).'vendors/animate.css', array(), null );

        $query_args = array(
            'family' => 'Raleway:400,500,600',
            'subset' => 'latin,latin-ext',
        );
        wp_enqueue_style('google_fonts', "https://fonts.googleapis.com/css?family=Cormorant+Garamond:300,400,500,700|Merriweather:400,700|Montserrat:400,700|Open+Sans:300,400,600,700|Raleway:300,400,500,700", array(), null);

        $handle = 'semantic-ui';

        if (!wp_style_is($handle, 'enqueued')) {
            wp_enqueue_style('semantic-ui', HELPIE_PLUGIN_URL . 'includes/asset-files/vendors/semantic/bundle/semantic.min.css', array(), $this->version, null);
        }

        $this->scripts_handler->load_dependencies();
        $this->scripts_handler->register_kb_frontend_style();

        $css_src = includes_url('css/') . 'editor.css';
        wp_enqueue_style('tinymce_css');
    }

    public function enqueue_frontend_kb_scripts()
    {

        $this->scripts_handler->enqueue_kb_frontend_scripts();
    }

    public function enqueue_scripts()
    {
        $helpie_search_nonce = wp_create_nonce('helpie_search_nonce');
        $article_vote_nonce = wp_create_nonce('article_vote_nonce');
        $password_protect_check_nonce = wp_create_nonce('password_protect_check_nonce');

        // jquery.autocomplete.js is loading from kb-frontend-bundle.js so no need enqeue version after 1.7.3
        // wp_enqueue_script('jquery-autocomplete', plugin_dir_url(__FILE__).'vendors/autocomplete/jquery.autocomplete.js', array('jquery'), $this->version, false);

        // wp_enqueue_script('toastr-notification', plugin_dir_url(__FILE__) . 'vendors/toastr/toastr.js', array('jquery'), $this->version, true);
        // wp_enqueue_script('highlight-syntax', plugin_dir_url(__FILE__) . 'vendors/prism/prism.js', array('jquery'), $this->version, true);

        // if ($this->is_helpie_post_template()) {
        //     wp_enqueue_script('semantic-ui', plugin_dir_url(__FILE__) . 'vendors/semantic/semantic.js', array('jquery'), $this->version, true);

        //     $this->enqueue_frontend_kb_scripts();
        // }

        // This jquery is a test to see that it causes conflict
        // wp_enqueue_script('jquery-ajax', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js?ver=4.8.1');
    }

    public function is_helpie_post_template()
    {
        global $wp_query, $post;

        $return_value = false;

        if (isset($post) && $post != null) {
            $page_id = $post->ID;
            $plugin_search_option = get_option('helpdesk_search_page_id');
            $helpie_editor_page_id = get_option('helpie_editor_page_id');

            $is_mainpage = is_post_type_archive('pauple_helpie');
            $is_category = is_tax('helpdesk_category');
            $is_single = ($post->post_type == 'pauple_helpie');
            $is_search = ($plugin_search_option == $page_id);

            $is_editor = ($helpie_editor_page_id == $page_id);

            if ($is_mainpage || $is_category || $is_single || $is_search || $is_editor) {
                $return_value = true;
            } else {
                $return_value = false;
            }
        }

        return $return_value;
    } // is_helpie_post_template
}