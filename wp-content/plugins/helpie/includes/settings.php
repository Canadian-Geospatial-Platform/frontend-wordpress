<?php

namespace Helpie\Includes;

/* Dependencies */

use \Helpie\Includes\Translations as Translations;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings')) {
    class Settings
    {
        public function __construct()
        {
            /* Actions */
            add_action('init', [$this, 'setup_options_init']);
            add_action('init', [$this, 'init']);

            // $this->init();

            // add_action('csf_helpie-kb_sections', [$this, 'filter_args']);

            /* Filters */
            add_filter('csf_helpie-kb_sections', [$this, 'filter_args']);
            add_filter('csf_helpie-kb_saved', [$this, 'onSettingsSave']);

            // $this->init();
            $this->extras = new \Helpie\Includes\Settings\Partials\Extras();
        }

        public function onSettingsSave($settings)
        {

            if ($settings['helpie_search_page'] == '') {
                return;
            }

            $search_page_option = 'helpdesk_search_page_id';
            update_option($search_page_option, $settings['helpie_search_page']);

            // error_log('onSettingsSave $settings : ' . print_r($settings, true));
        }

        public function filter_args($content)
        {
            return $content;
        }

        public function setup_options_init()
        {
            require_once HELPIE_PLUGIN_PATH . 'includes/settings/settings-config.php';
        }

        public function init()
        {
            $this->setup_options_init();

            if (!function_exists('\CSF') && !class_exists('\CSF')) {
                require_once HELPIE_PLUGIN_PATH . 'includes/lib/codestar-framework/codestar-framework.php';
            }

            // require_once 'settings-config.php';

            if (class_exists('\CSF')) {

                // Set a unique slug-like ID
                $prefix = 'helpie-kb';

                // Create options
                \CSF::createOptions($prefix, array(
                    'menu_title' => Translations::getStrings('HelpieSettings'),
                    'menu_parent' => 'edit.php?post_type=pauple_helpie',
                    'menu_type' => 'submenu', // menu, submenu, options, theme, etc.
                    'menu_slug' => 'helpie-kb-settings',
                    'framework_title' => Translations::getStrings('HelpieSettings'),
                    'theme' => 'light',
                    'show_search' => false, // TODO: Enable once autofill password is fixed
                ));

                // Create a section
                $this->main_page($prefix);
                $this->single_page($prefix);
                $this->category_page($prefix);
                $this->search($prefix);

                $this->frontend_editor($prefix);
                $this->styles($prefix);
                $this->password_protect($prefix);
                $this->dynamic_capabilities($prefix);
                $this->toc($prefix);
                $this->autolinking($prefix);
                $this->components($prefix);
                $this->demo_import($prefix);
                $this->backup($prefix);

                /* Additional */
                $this->can_view_posts();
                $this->can_view_topics();
                // error_log('Settings_New');
            }
        }

        public function autolinking($prefix)
        {
            // Create a section
            \CSF::createSection($prefix, array(
                'title' => Translations::getStrings('Autolinking'),
                'icon' => 'fa fa-link',
                'fields' => array(
                    array(
                        'id' => 'autolinking_enable',
                        'type' => 'switcher',
                        'title' => __('Enable Auto Linking', 'pauple-helpie'),
                        'default' => false,
                        'desc' => __('Enable Wiki Auto Linking', 'pauple-helpie'),
                    ),

                ),
            ));
        }
        public function main_page($prefix)
        {
            $main_page_button = $this->extras->get_main_page_url();
            // Create a section
            \CSF::createSection($prefix, array(
                'title' => __('Main Page', 'pauple-helpie'),
                'icon' => 'fa fa-home',
                'fields' => array(
                    array(
                        'type' => 'subheading',
                        'content' => __('Template', 'pauple-helpie'),
                    ),
                    array(
                        'id' => 'helpie_mp_sidebar_template',
                        'type' => 'image_select',
                        'title' => __('Template', 'pauple-helpie'),
                        'options' => array(
                            'both-side-sidebars' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/both-side-sidebars.png',
                            'left-sidebar' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/left-sidebar.png',
                            'right-sidebar' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/right-sidebar.png',
                            'full-width' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/full-width.png',
                            'boxed-width' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/boxed-width.png',
                        ),
                        'default' => 'boxed-width',
                        'desc' => __("Template Type for your Knowledge Base's Main Page. Both Side Sidebars, Left / Right Sidebar, Full-Width ( without wrapper ), Boxed-Width.", "pauple-helpie"),
                    ),
                    // A Submessage
                    array(
                        'type' => 'submessage',
                        'style' => 'success',
                        'content' => __('You can add widgets to your sidebar from Appearance -> Widgets', 'pauple-helpie'),
                    ),
                    array(
                        'id' => 'helpie_mp_sidebar1',
                        'type' => 'select',
                        'title' => __('Sidebar 1', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => 'sidebars',
                        'default' => 'helpie_sidebar',
                        'dependency' => array('helpie_mp_sidebar_template', 'any', 'both-side-sidebars,left-sidebar,right-sidebar'),
                    ),
                    array(
                        'id' => 'helpie_mp_sidebar2',
                        'type' => 'select',
                        'title' => __('Sidebar 2', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => 'sidebars',
                        'default' => 'helpie_sidebar',
                        'dependency' => array('helpie_mp_sidebar_template', '==', 'both-side-sidebars'),
                    ),

                    // A Submessage
                    array(
                        'type' => 'submessage',
                        'style' => 'success',
                        'content' => __('There are 4 ways to customize the Main Page', 'pauple-helpie')
                        . '<br><br>1) ' . __('Use the settings below', 'pauple-helpie')
                        . '<br> 2) ' . __('Change "Where do you want your main page?" and choose a page, then apply the shortcode mentioned', 'pauple-helpie')
                        . '<br>3) ' . __('Change the main page and use Elementor page builder', 'pauple-helpie')
                        . '<br> 4) <a href="http://helpiewp.com/knowledge-base-elementor-template-builder-integration/">' . __('Use Elementor Pro Theme Builder', 'pauple-helpie') . '</a>'
                        . '( ' . __('Need\'s to enable below CPT Archive option', 'pauple-helpie') . ' )',
                    ),
                    array(
                        'id' => 'helpie_mp_location',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Where do you want your main page?', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'archive' => __('CPT Archive', 'pauple-helpie'),
                            'page' => __('Select a Page', 'pauple-helpie'),
                        ),
                        'default' => 'archive',
                    ),
                    array(
                        'id' => 'helpie_mp_select_page',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Select Page to be KB Main Page', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => 'pages',
                        'dependency' => array('helpie_mp_location', '==', 'page'),
                        'desc' => '<b>[pauple_helpie_main_page_shortcode]</b> -> ' . __('Add this shortcode to the selected page', 'pauple-helpie'),
                        'query_args' => array(
                            'posts_per_page' => -1,
                        ),
                    ),

                    array(
                        'id' => 'helpie_mp_slug',
                        'type' => 'text',
                        'title' => __('Main Page Slug', 'pauple-helpie'),
                        'default' => 'helpdesk',
                    ),
                    array(
                        'type' => 'content',
                        'content' => '<div class="button-container">'
                        . '<span><b>' . __('Where is my main page?', 'pauple-helpie') . '</b></span>'
                        . '<br>'
                        . $main_page_button . '<span>' . __('Save and Refresh Page if you changed it', 'pauple-helpie') . '.</span></div>',
                    ),
                    array(
                        'type' => 'subheading',
                        'title' => __('Hero Section', 'pauple-helpie'),
                        'subtitle' => __('Style settings for Hero Section are in Design sub-menu', 'pauple-helpie'),
                    ),

                    array(
                        'id' => 'mp_hero_section_order',
                        'type' => 'sortable',
                        'title' => __('Hero Section Control', 'pauple-helpie'),
                        'desc' => __('Control order and visibility of these components in Main Page', 'pauple-helpie'),
                        'fields' => array(
                            array(
                                'id' => 'kb_main_title',
                                'type' => 'text',
                                'title' => __('Knowledge Base Main Title', 'pauple-helpie'),
                                // 'default' => __('Helpdesk', 'pauple-helpie'),
                                'desc' => __('Displayed in Hero section and also in Breadcrumbs.', 'pauple-helpie'),
                            ),

                            array(
                                'id' => 'kb_main_subtitle',
                                'type' => 'text',
                                'title' => __('Knowledge Base Subtitle', 'pauple-helpie'),
                                // 'default' => 'We’re here to help.',
                                'desc' => __('Displayed in Hero section.', 'pauple-helpie'),
                            ),

                            array(
                                'id' => 'main_page_search_display',
                                'type' => 'switcher',
                                'title' => __('Search Display', 'pauple-helpie'),
                                // 'default' => true,
                                'desc' => __('Displayed in Hero section.', 'pauple-helpie'),
                            ),

                        ),
                        'default' => array(
                            'kb_main_title' => __('Helpdesk', 'pauple-helpie'),
                            'kb_main_subtitle' => __('We’re here to help.', 'pauple-helpie'),
                            'main_page_search_display' => true,

                        ),
                    ),

                    // array(
                    //     'id' => 'kb_main_title',
                    //     'type' => 'text',
                    //     'title' => __('Knowledge Base Main Title', 'pauple-helpie'),
                    //     'default' => 'Helpdesk',
                    //     'desc' => 'Displayed in Hero section and also in Breadcrumbs.'
                    // ),
                    // array(
                    //     'id' => 'kb_main_subtitle',
                    //     'type' => 'text',
                    //     'title' => __('Knowledge Base Subtitle', 'pauple-helpie'),
                    //     'default' => 'We’re here to help.',
                    //     'desc' => 'Displayed in Hero section.'
                    // ),
                    array(
                        'type' => 'subheading',
                        'content' => __('Meta Data', 'pauple-helpie'),
                        'dependency' => array('helpie_mp_location', '==', 'archive'),
                    ),
                    array(
                        'type' => 'submessage',
                        'style' => 'normal',
                        'content' => __('This works only when you set CPT Archive for Where do you want your main page?', 'pauple-helpie'),
                        'dependency' => array('helpie_mp_location', '==', 'archive'),
                    ),
                    array(
                        'id' => 'helpie_mp_meta_title',
                        'type' => 'text',
                        'title' => __('Main Page Meta Title', 'pauple-helpie'),
                        'dependency' => array('helpie_mp_location', '==', 'archive'),
                        'desc' => __('Keep your meta title between 60 and 64 characters', 'pauple-helpie'),
                        'default' => 'helpdesk',
                    ),
                    array(
                        'id' => 'helpie_mp_meta_description',
                        'type' => 'text',
                        'title' => __('Main Page Meta Description', 'pauple-helpie'),
                        'dependency' => array('helpie_mp_location', '==', 'archive'),
                        'desc' => __('Keep your meta description between 150 and 154 characters', 'pauple-helpie'),
                        'default' => 'We are here to help.',
                    ),

                    array(
                        'type' => 'subheading',
                        'content' => __('Main Page Components Settings', 'pauple-helpie'),
                    ),
                    // array(
                    //     'id' => 'main_page_search_display',
                    //     'type' => 'switcher',
                    //     'title' => __('Search Display', 'pauple-helpie'),
                    //     'default' => true,
                    //     'desc' => 'Search Inside Hero section'
                    // ),

                    array(
                        'id' => 'mp_components_order',
                        'type' => 'sortable',
                        'title' => __('Components Control', 'pauple-helpie'),
                        'desc' => __('Control order and visibility of these components in Main Page', 'pauple-helpie'),
                        'fields' => array(
                            array(
                                'id' => 'helpie_mp_show_stats',
                                'type' => 'switcher',
                                'title' => __('Show Stats', 'pauple-helpie'),
                                'default' => false,
                            ),
                            array(
                                'id' => 'main_page_categories',
                                'type' => 'switcher',
                                'title' => __('Main Page - Categories', 'pauple-helpie'),
                                'default' => true,
                            ),
                            array(
                                'id' => 'show_article_listing',
                                'type' => 'switcher',
                                'title' => __('Show Article Listing', 'pauple-helpie'),
                                'default' => false,
                            ),
                        ),
                        'default' => array(
                            'helpie_mp_show_stats' => false,
                            'main_page_categories' => true,
                            'show_article_listing' => false,
                        ),
                    ),

                    array(
                        'id' => 'helpie_mp_article_listing',
                        'type' => 'subheading',
                        'content' => __('Article Listing', 'pauple-helpie'),
                        'dependency' => array('show_article_listing', '==', 'true'),
                    ),

                    array(
                        'id' => 'helpie_mp_article_listing_title',
                        'type' => 'text',
                        'title' => __('Title', 'pauple-helpie'),
                        'default' => 'KB Article Listing',
                        'dependency' => array('show_article_listing', '==', 'true'),
                    ),
                    array(
                        'id' => 'helpie_mp_article_listing_sortby',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Sort By', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'alphabetical' => 'Alphabetical',
                            'recent' => 'Recent',
                            'updated' => 'Recently Updated',
                            'popular' => 'Popular',
                        ),
                        'default' => 'recent',
                        'dependency' => array('show_article_listing', '==', 'true'),
                    ),
                    array(
                        'id' => 'helpie_mp_article_listing_topics',
                        'type' => 'select',
                        'chosen' => true,
                        'multiple' => true,
                        'title' => __('Topics', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => 'csf_get_all_helpie_kb_topics',
                        'default' => 'all',
                        'dependency' => array('show_article_listing', '==', 'true'),
                    ),

                    array(
                        'id' => 'helpie_mp_article_listing_style',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Style', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'list' => __('List', 'pauple-helpie'),
                            'card' => __('Card', 'pauple-helpie'),
                        ),
                        'default' => 'list',
                        'dependency' => array('show_article_listing', '==', 'true'),
                    ),

                    array(
                        'id' => 'helpie_mp_article_listing_num_of_cols',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Num Of Columns', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'one' => 1,
                            'two' => 2,
                            'three' => 3,
                            'four' => 4,
                        ),
                        'default' => 'three',
                        'dependency' => array('show_article_listing|helpie_mp_article_listing_style', '==|==', 'true|card'),
                    ),
                    array(
                        'id' => 'helpie_mp_article_listing_show_image',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Show Image', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'true' => 'True',
                            'false' => 'False',
                        ),
                        'default' => 'true',
                        'dependency' => array('show_article_listing|helpie_mp_article_listing_style', '==|==', 'true|card'),
                    ),

                    array(
                        'id' => 'helpie_mp_article_listing_show_extra',
                        'title' => __('Show Extra Info', 'pauple-helpie'),
                        'default' => __('true', 'pauple-helpie'),
                        'chosen' => true,
                        'options' => array(
                            'true' => __('True', 'pauple-helpie'),
                            'false' => __('False', 'pauple-helpie'),
                        ),
                        'type' => 'select',

                        'dependency' => array('show_article_listing|helpie_mp_article_listing_style', '==|==', 'true|card'),
                    ),

                    array(
                        'id' => 'helpie_mp_article_listing_limit',
                        'type' => 'text',
                        'title' => __('Limit', 'pauple-helpie'),
                        'default' => 5,
                        'validate' => 'csf_validate_numeric',
                        'dependency' => array('show_article_listing', '==', 'true'),
                    ),

                    array(
                        'id' => 'mp_categories_settings',
                        'type' => 'subheading',
                        'content' => __('Category Listing', 'pauple-helpie'),
                        'dependency' => array('main_page_categories', '==', 'true'),
                    ),
                    array(
                        'id' => 'helpie_mp_template',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Main Page Categories Listing Style', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'boxed' => __('Boxed', 'pauple-helpie'),
                            'boxed1' => __('Boxed1', 'pauple-helpie'),
                            'modern' => __('Modern', 'pauple-helpie'),
                        ),
                        'default' => 'boxed',
                        'dependency' => array('main_page_categories', '==', 'true'),
                    ),
                    array(
                        'id' => 'helpie_mp_boxed_description',
                        'type' => 'switcher',
                        'title' => __('Show Description', 'pauple-helpie'),
                        'dependency' => array('main_page_categories', '==', 'true'),
                        'default' => false,
                    ),
                    array(
                        'id' => 'category_listing_graphic_type',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Image or Icon', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'image' => __('Image', 'pauple-helpie'),
                            'icon' => __('Icon', 'pauple-helpie'),
                        ),
                        'default' => 'image',
                        'desc' => __('Default icon color is set from Style -> Primary Brand color', 'pauple-helpie'),
                        'dependency' => array('main_page_categories', '==', 'true'),
                    ),
                    array(
                        'id' => 'category_listing_children_type',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Children Type', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'none' => __('Dont show Children', 'pauple-helpie'),
                            'articles' => __('Articles', 'pauple-helpie'),
                            'sub-categories' => __('Sub Categories', 'pauple-helpie'),
                        ),
                        'default' => 'articles',
                        'dependency' => array('main_page_categories|helpie_mp_template', '==|!=', 'true|boxed'),
                    ),
                    array(
                        'id' => 'helpie_mp_cl_cols',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Num Of Columns', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'one' => '1',
                            'two' => '2',
                            'three' => '3',
                            'four' => '4',
                        ),
                        'default' => 'three',
                        'dependency' => array('main_page_categories', '==', 'true'),
                    ),
                    array(
                        'id' => 'helpie_mp_no_cat_articles',
                        'type' => 'text',
                        'title' => __('Number of articles under each category', 'pauple-helpie'),
                        'default' => 5,
                        'validate' => 'csf_validate_numeric',
                        'dependency' => array('main_page_categories', '==', 'true'),
                    ),
                    array(
                        'id' => 'helpie_mp_cats',
                        'type' => 'sorter',
                        'title' => __('Main Page Categories', 'pauple-helpie'),
                        // 'options' => 'csf_get_all_helpie_kb_topics',
                        'default' => \get_sorter_terms(),
                        'enabled_title' => __('Enabled', 'pauple-helpie'),
                        'disabled_title' => __('Disabled', 'pauple-helpie'),
                        // 'dependency' => array('main_page_categories', '==', 'true'),
                    ),

                ),
            ));
        }

        public function search($prefix)
        {

            $search_single_item_selectors = [
                '.helpie-main-content-area .helpie-search-listing .helpie-element.item',
                '.helpie-main-content-area .helpie-search-listing .helpie-element.item:first-child',
            ];

            $search_page_id = get_option('helpdesk_search_page_id');

            // Create a section
            \CSF::createSection($prefix, array(
                'title' => Translations::getStrings('SearchSettings'),
                'icon' => 'fa fa-search',
                'fields' => array(
                    // array(
                    //     'id' => 'search_placeholder',
                    //     'type' => 'text',
                    //     'title' => __('Search Placeholder', 'pauple-helpie'),
                    //     'default' => 'Helpdesk',
                    // ),
                    // A Submessage
                    // array(
                    //     'type'    => 'submessage',
                    //     'style'   => 'success',
                    //     'content' => 'There are 4 ways to customize Main Page. <br><br>
                    //      1) Use the settings below,
                    //     <br> 2) Change "Where do you want your main page?" and choose a page, then apply the shortcode mentioned
                    //     <br>3) Change Main Page and use Elementor Page Builder
                    //     <br> 4) <a href="http://helpiewp.com/knowledge-base-elementor-template-builder-integration/">Use Elementor Pro Theme Builder</a>',
                    // ),
                    // array(
                    //     'id' => 'helpie_mp_location',
                    //     'type' => 'select',
                    //     'chosen' => true,
                    //     'title' => __('Where do you want your main page?', 'pauple-helpie'),
                    //     'placeholder' => __('Select an option', 'pauple-helpie'),
                    //     'options' => array(
                    //         'archive' => __('CPT Archive', 'pauple-helpie'),
                    //         'page' => __('Select a Page', 'pauple-helpie'),
                    //     ),
                    //     'default' => 'archive',
                    // ),
                    array(
                        'id' => 'helpie_search_page',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Select page to be a search page', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => 'pages',
                        'default' => $search_page_id,
                        'desc' => '<b>[pauple_helpie_search_results_page] </b> -> ' . __('Add this shortcode to the selected page', 'pauple-helpie'),
                        'query_args' => array(
                            'posts_per_page' => -1,
                        ),
                    ),
                    array(
                        'id' => 'helpie_search_placeholder_text',
                        'type' => 'text',
                        'title' => __('Search placeholder text', 'pauple-helpie'),
                        'default' => 'What can I help you with?',
                    ),

                    array(
                        'id' => 'search_no_query_text',
                        'type' => 'text',
                        'title' => __('No Query Text', 'pauple-helpie'),
                        'default' => 'Please search something !',
                    ),

                    array(
                        'id' => 'empty_search_result_label',
                        'type' => 'text',
                        'title' => __('Empty search results label', 'pauple-helpie'),
                        'default' => __('Did not match any articles !', 'pauple-helpie'),
                    ),

                    array(
                        'id' => 'helpie_search_page_featured_image_show',
                        'type' => 'switcher',
                        'title' => __('Show Featured Image', 'pauple-helpie'),
                        'default' => true,
                    ),

                    array(
                        'id' => 'helpie_search_page_meta_data_show',
                        'type' => 'switcher',
                        'title' => __('Show Metadata', 'pauple-helpie'),
                        'default' => true,
                    ),

                    array(
                        'id' => 'helpie_search_page_description_show',
                        'type' => 'switcher',
                        'title' => __('Show Result Description', 'pauple-helpie'),
                        'default' => true,
                    ),

                    array(
                        'id' => 'helpie_search_page_tags_show',
                        'type' => 'switcher',
                        'title' => __('Show Tags', 'pauple-helpie'),
                        'default' => true,
                    ),

                    array(
                        'id' => 'helpie_search_page_description_length',
                        'type' => 'text',
                        'title' => __('Description Length', 'pauple-helpie'),
                        'default' => 200,
                        'dependency' => array('helpie_search_page_description_show', '==', '1'),
                    ),

                    array(
                        'type' => 'submessage',
                        'style' => 'success',
                        'content' => '<b>' . __('Description Length', 'pauple-helpie') . ':</b> ' . __('Set value to "-1" to get max value', 'pauple-helpie'),
                        'dependency' => array('helpie_search_page_description_show', '==', '1'),
                    ),

                    /* Design */
                    array(
                        'type' => 'subheading',
                        'content' => __('STYLE', 'pauple-helpie'),
                    ),

                    array(
                        'type' => 'subheading',
                        'content' => __('Single Result', 'pauple-helpie'),
                    ),

                    array(
                        'id' => 'search-header-typography',
                        'type' => 'typography',
                        'title' => __('Header Typography', 'pauple-helpie'),
                        'output' => array('.helpie-search-listing .helpie-element .item-content .header'),
                        'output_important' => true,
                        'text_align' => false,
                    ),

                    array(
                        'id' => 'search-title-typography',
                        'type' => 'typography',
                        'title' => __('Title Typography', 'pauple-helpie'),
                        'output' => array('.helpie-search-listing .item-content .header .item-title'),
                        'output_important' => true,
                        'text_align' => false,
                    ),

                    array(
                        'id' => 'search-cat-typography',
                        'type' => 'typography',
                        'title' => __('Category Typography', 'pauple-helpie'),
                        'output' => array('.helpie-search-listing .helpie-element .item-content .header .item-cat_name'),
                        'output_important' => true,
                        'text_align' => false,
                    ),

                    array(
                        'id' => 'search-meta-typography',
                        'type' => 'typography',
                        'title' => __('Metadata Typography', 'pauple-helpie'),
                        'output' => array('.helpie-search-listing .helpie-element .item-content .meta'),
                        'output_important' => true,
                        'text_align' => false,
                    ),

                    array(
                        'id' => 'search-text-typography',
                        'type' => 'typography',
                        'title' => __('Search Text Typography', 'pauple-helpie'),
                        'output' => array('.helpie-search-listing .helpie-element .item-content .description p'),
                        'output_important' => true,
                        'text_align' => false,
                    ),

                    array(
                        'id' => 'helpiekb_search_results_single_border',
                        'type' => 'border',
                        'title' => __('Border', 'pauple-helpie'),
                        'output' => $search_single_item_selectors,
                        'output_important' => true,
                    ),

                    array(
                        'id' => 'helpiekb_search_results_single_padding',
                        'type' => 'spacing',
                        'title' => __('Padding', 'pauple-helpie'),
                        'output' => $search_single_item_selectors,
                        'output_mode' => 'padding',
                        'output_important' => true,
                    ),

                    array(
                        'id' => 'helpiekb_search_results_single_margin',
                        'type' => 'spacing',
                        'title' => __('Margin', 'pauple-helpie'),
                        'output' => $search_single_item_selectors,
                        'output_mode' => 'margin',
                        'output_important' => true,
                    ),

                    array(
                        'type' => 'subheading',
                        'content' => __('Search Box', 'pauple-helpie'),
                    ),
                    array(
                        'id' => 'helpie_show_search_border',
                        'type' => 'switcher',
                        'title' => __('Show border', 'pauple-helpie'),
                        'default' => false,
                    ),

                    array(
                        'id' => 'helpie_search_border_color',
                        'type' => 'color',
                        'title' => __('Search border color', 'pauple-helpie'),
                        'default' => false,
                    ),

                    array(
                        'id' => 'helpie_search_border_style',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Search border style', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'rounded' => __('Rounded', 'pauple-helpie'),
                            'semi-rounded' => __('Semi Rounded', 'pauple-helpie'),
                            'squared' => __('Squared', 'pauple-helpie'),
                        ),
                        'default' => 'semi-rounded',
                    ),

                    // array(
                    //     'id'    => 'autosuggest-title-typography',
                    //     'type'  => 'typography',
                    //     'title' => 'Autosuggest Title Typography',
                    // ),
                    // array(
                    //     'id'    => 'autosuggest-category-typography',
                    //     'type'  => 'typography',
                    //     'title' => 'Autosuggest Category Typography',
                    // ),
                    // array(
                    //     'id'    => 'autosuggest-text-typography',
                    //     'type'  => 'typography',
                    //     'title' => 'Autosuggest Text Typography',
                    // ),
                ),
            ));
        }

        public function frontend_editor($prefix)
        {
            // Create a section
            \CSF::createSection($prefix, array(
                'title' => Translations::getStrings('FrontendEditor'),
                'icon' => 'fa fa-font',
                'fields' => array(

                    0 => array(
                        'id' => 'kb_frontend_enable',
                        'type' => 'switcher',
                        'title' => __('Enable Frontend Editing', 'pauple-helpie'),
                        'default' => false,
                    ),
                    1 => array(
                        'id' => 'kb_num_of_revisions',
                        'type' => 'text',
                        'title' => __('Number of Revisions', 'pauple-helpie'),
                        'default' => 20,
                        'validate' => 'csf_validate_numeric',
                        'dependency' => array('kb_frontend_enable', '==', '1'),
                    ),
                    2 => array(
                        'id' => 'kb_editor_type',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Editor Type', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'inline' => __('Inline Editor', 'pauple-helpie'),
                            'wpeditor' => __('WordPress Tinymce Editor', 'pauple-helpie'),
                        ),
                        'default' => 'inline',
                        'dependency' => array('kb_frontend_enable', '==', '1'),
                    ),

                ),

            ));
        }

        public function password_protect($prefix)
        {

            // Create a section

            \CSF::createSection($prefix, array(

                'title' => Translations::getStrings('PasswordSettings'),
                'icon' => 'fa fa-unlock-alt',
                'fields' => array(
                    array(
                        'type' => 'subheading',
                        'content' => __('Password Settings', 'pauple-helpie'),
                    ),
                    // A Submessage
                    array(
                        'type' => 'submessage',
                        'style' => 'info',
                        'content' => __('Passwords are not required for admin', 'pauple-helpie'),
                    ),
                    array(

                        'id' => 'helpie_password_options',
                        'type' => 'repeater',
                        'title' => __('Passwords', 'pauple-helpie'),
                        'fields' => array(
                            array(
                                'id' => 'password_for_content',
                                'type' => 'select',
                                'chosen' => true,
                                'multiple' => true,
                                'title' => __('Category', 'pauple-helpie'),
                                'placeholder' => __('Select an option', 'pauple-helpie'),
                                'options' => 'csf_get_all_helpie_kb_mp_topics',
                                'default' => 'all',
                            ),
                            array(
                                'id' => 'password_for',
                                'type' => 'text',
                                'title' => __('Password', 'pauple-helpie'),
                                'attributes' => array(
                                    'type' => 'password',
                                ),
                            ),
                        ),
                    ),

                    array(
                        'id' => 'helpie_password_remember_days',
                        'type' => 'text',
                        'title' => __('Remember password for this many days', 'pauple-helpie'),
                        'default' => 7,
                        'validate' => 'csf_validate_numeric',
                    ),
                ),
            ));
        }

        public function styles($prefix)
        {
            // Create a section
            \CSF::createSection(
                $prefix,
                array(
                    'title' => Translations::getStrings('Design'),
                    'icon' => 'fa fa-magic',
                    'fields' => array(

                        array(
                            'id' => 'design',
                            'type' => 'tabbed',
                            // 'title'         => Translations::getStrings('Design'),
                            'tabs' => array(
                                array(
                                    'title' => __('Layout', 'pauple-helpie'),
                                    'icon' => 'fa fa-columns',
                                    'fields' => $this->layout($prefix),
                                ),
                                array(
                                    'title' => __('Typography', 'pauple-helpie'),
                                    'icon' => 'fa fa-align-center',
                                    'fields' => $this->typography($prefix),
                                ),
                                array(
                                    'title' => __('Hero Section', 'pauple-helpie'),
                                    'icon' => 'fa fa-building',
                                    'fields' => $this->hero_section_design(),
                                ),
                                // array(
                                //     'title'     => 'Search',
                                //     'icon'      => 'fa fa-search',
                                //     'fields'    => $this->search_design()
                                // ),
                            ),
                        ),
                    ),
                )

            );
        }

        public function layout($prefix)
        {
            return array(
                array(
                    'type' => 'subheading',
                    'content' => __('Layout', 'pauple-helpie'),
                ),

                array(
                    'id' => 'helpiekb-wrapper-width',
                    'type' => 'dimensions',
                    'title' => __('Wrapper Width', 'pauple-helpie'),
                    'default' => array(
                        'width' => '980',
                        'unit' => 'px',
                    ),
                    'height' => false,
                    'output' => "#helpiekb-main-wrapper",
                ),

                array(
                    'type' => 'subheading',
                    'content' => __('KB Content Area', 'pauple-helpie'),
                ),
                array(
                    'id' => 'helpie_margin_top_desktop',
                    'type' => 'text',
                    'title' => __('Overall margin-top - Desktop', 'pauple-helpie'),
                    'default' => 0,
                    'validate' => 'csf_validate_numeric',
                ),

                array(
                    'id' => 'helpie_margin_top_tablet',
                    'type' => 'text',
                    'title' => __('Overall margin-top - Tablet', 'pauple-helpie'),
                    'default' => 0,
                    'validate' => 'csf_validate_numeric',
                ),
                array(
                    'id' => 'helpie_margin_top_mobile',
                    'type' => 'text',
                    'title' => __('Overall margin-top - Mobile', 'pauple-helpie'),
                    'default' => 0,
                    'validate' => 'csf_validate_numeric',
                ),
            );
        }

        public function hero_section_design()
        {
            return array(
                array(
                    'type' => 'subheading',
                    'content' => __('Hero Section', 'pauple-helpie'),
                ),

                array(
                    'id' => 'helpie_wa_background_type',
                    'type' => 'select',
                    'chosen' => true,
                    'placeholder' => __('Select an option', 'pauple-helpie'),
                    'title' => __('Hero Area background style', 'pauple-helpie'),
                    'options' => array(
                        'single-color' => __('Use Primary Color', 'pauple-helpie'),
                        'color-gradient' => __('Color Gradient', 'pauple-helpie'),
                        'background-image' => __('Background Image', 'pauple-helpie'),
                        'gradient-plus-background-image' => __('Gradient + Illustration', 'pauple-helpie'),
                    ),
                    'default' => 'single-color',
                ),

                array(
                    'id' => 'helpie_brand_primary_color',
                    'type' => 'color',
                    'title' => __('Primary Brand Color', 'pauple-helpie'),
                    'default' => '#f4f3f3',
                    'output' => '.helpie_helpdesk',
                    'output_mode' => 'background-color',
                    'output_important' => true,
                ),

                array(
                    'id' => 'helpie_wa_image',
                    'title' => __('Hero Area Image', 'pauple-helpie'),
                    'type' => 'media',
                    'title' => 'Media',
                    'library' => 'image',
                    'dependency' => array('helpie_wa_background_type', '==', 'background-image'),
                ),

                array(
                    'id' => 'helpie_wa_illustration',
                    'type' => 'image_select',
                    'title' => __('Hero Area illustration', 'pauple-helpie'),
                    'options' => array(
                        'snowy-mountain' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_wa_illustration/snowy-mountain.png',
                        'team-space' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_wa_illustration/team-space.png',
                        'books' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_wa_illustration/books.png',
                        'bubbles' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_wa_illustration/bubbles.png',
                    ),
                    'default' => 'team-space',
                    'dependency' => array('helpie_wa_background_type', '==', 'gradient-plus-background-image'),
                ),

                array(
                    'id' => 'helpie_wa_gradient1',
                    'type' => 'color',
                    'title' => __('Hero Area Gradient Color 1', 'pauple-helpie'),
                    'default' => '#777777',
                    'dependency' => array('helpie_wa_background_type', '==', 'color-gradient'),
                ),

                array(
                    'id' => 'helpie_wa_gradient2',
                    'type' => 'color',
                    'title' => __('Hero Area Gradient Color 2', 'pauple-helpie'),
                    'default' => '#777777',
                    'dependency' => array('helpie_wa_background_type', '==', 'color-gradient'),
                ),

                array(
                    'id' => 'helpie_brand_title_color',
                    'type' => 'color',
                    'title' => __('Hero Area Title Color', 'pauple-helpie'),
                    'default' => '#03363d',
                ),

                array(
                    'id' => 'helpie_wa_text_color',
                    'type' => 'color',
                    'title' => __('Welcome Area text color', 'pauple-helpie'),
                    'default' => '#03363d',
                ),

                array(
                    'id' => 'helpiekb_wa_padding',
                    'type' => 'spacing',
                    'title' => __('Main Hero Section - Padding', 'pauple-helpie'),
                    'output' => '.helpie_helpdesk',
                    'output_mode' => 'padding',
                    'output_important' => true,
                ),
            );
        }

        public function typography($prefix)
        {
            return array(
                array(
                    'type' => 'subheading',
                    'content' => __('Knowledgebase Typography', 'pauple-helpie'),
                ),
                array(
                    'id' => 'h1-typography',
                    'type' => 'typography',
                    'title' => __('h1 - Typography', 'pauple-helpie'),
                    'output' => '.helpie-single-page-module h1',
                    'output_important' => true,
                ),
                array(
                    'id' => 'h2-typography',
                    'type' => 'typography',
                    'title' => __('h2 - Typography', 'pauple-helpie'),
                    'output' => array('.helpie-single-page-module h2'),
                    'output_important' => true,
                ),
                array(
                    'id' => 'h3-typography',
                    'type' => 'typography',
                    'title' => __('h3 - Typography', 'pauple-helpie'),
                    'output' => array('.helpie-single-page-module h3'),
                    'output_important' => true,
                ),
                array(
                    'id' => 'h4-typography',
                    'type' => 'typography',
                    'title' => __('h4 - Typography', 'pauple-helpie'),
                    'output' => array('.helpie-single-page-module h4'),
                    'output_important' => true,
                ),
                array(
                    'id' => 'h5-typography',
                    'type' => 'typography',
                    'title' => __('h5 - Typography', 'pauple-helpie'),
                    'output' => array('.helpie-single-page-module h5'),
                    'output_important' => true,
                ),
                array(
                    'id' => 'h6-typography',
                    'type' => 'typography',
                    'title' => __('h6 - Typography', 'pauple-helpie'),
                    'output' => array('.helpie-single-page-module h6'),
                    'output_important' => true,
                ),
                array(
                    'id' => 'p-typography',
                    'type' => 'typography',
                    'title' => __('p tag - Typography', 'pauple-helpie'),
                    'output' => array('.helpie-single-page-module p'),
                    'output_important' => true,
                ),

                // TODO : Not working. Check
                // array(
                //     'id'    => 'link-color',
                //     'type'  => 'link_color',
                //     'title' => 'Link Color',
                //     'output' => array('.helpie-single-page-module a'),
                //     'output_important' => true,
                // ),

            );
        }
        public function dynamic_capabilities($prefix)
        {
            $cap_fields = $this->get_cap_fields('global');
            $cap_fields_can_publish = $this->get_cap_fields('global', 'can_publish'); // this is default value for edit, publish, approve.

            \CSF::createSection($prefix, array(
                'title' => Translations::getStrings('DynamicCapabilities'),
                'icon' => 'fa fa-users',
                'fields' => array(
                    array(
                        'type' => 'subheading',
                        'content' => __('Dynamic Capabilities', 'pauple-helpie'),
                    ),
                    // A Submessage
                    array(
                        'type' => 'submessage',
                        'style' => 'info',
                        'content' => __('These restrictions do not apply for admin', 'pauple-helpie'),
                    ),

                    array(
                        'type' => 'submessage',
                        'style' => 'success',
                        'content' => __('You can control these conditions at Global, Topic and Article levels', 'pauple-helpie') . '. <a href="http://helpiewp.com/dynamic-capabilities/">' . __('Learn More', 'pauple-helpie') . ' >></a>',
                    ),
                    array(
                        'id' => 'helpie_dynamic_capability',
                        'type' => 'tabbed',
                        'tabs' => array(
                            array(
                                'title' => __('Can View', 'pauple-helpie'),
                                'icon' => 'fa fa-eye',
                                'fields' => array(
                                    array(
                                        'id' => 'can_view',
                                        'type' => 'fieldset',
                                        'title' => __('Who Can View', 'pauple-helpie'),
                                        'fields' => $cap_fields,
                                    ),
                                ),
                            ),

                            array(
                                'title' => __('Can Edit', 'pauple-helpie'),
                                'icon' => 'fa fa-pencil',
                                'fields' => array(
                                    array(
                                        'id' => 'can_edit',
                                        'type' => 'fieldset',
                                        'title' => __('Who Can Edit', 'pauple-helpie'),
                                        'fields' => $cap_fields_can_publish,
                                    ),
                                ),
                            ),

                            array(
                                'title' => __('Can Publish', 'pauple-helpie'),
                                'icon' => 'fa fa-book',
                                'fields' => array(
                                    array(
                                        'id' => 'can_publish',
                                        'type' => 'fieldset',
                                        'title' => __('Who Can Publish', 'pauple-helpie'),
                                        'fields' => $cap_fields_can_publish,
                                    ),
                                ),
                            ),

                            array(
                                'title' => __('Can Approve', 'pauple-helpie'),
                                'icon' => 'fa fa-check',
                                'fields' => array(
                                    array(
                                        'id' => 'can_approve',
                                        'type' => 'fieldset',
                                        'title' => __('Who Can Approve', 'pauple-helpie'),
                                        'fields' => $cap_fields_can_publish,
                                    ),
                                ),
                            ),

                        ),
                    ),
                ),
            ));
        }

        public function components($prefix)
        {
            // Create a section
            \CSF::createSection(
                $prefix,
                array(
                    'title' => __('Components', 'pauple-helpie'),
                    'icon' => 'fa fa-inbox',
                    'fields' => array(

                        array(
                            'id' => 'helpie_breadcrumbs',
                            'type' => 'switcher',
                            'title' => __('Breadcrumbs', 'pauple-helpie'),
                            'default' => true,
                        ),
                        array(
                            'id' => 'article_order',
                            'type' => 'select',
                            'title' => __('Article Order', 'pauple-helpie'),
                            'chosen' => true,
                            'placeholder' => __('Select an option', 'pauple-helpie'),
                            'options' => array(
                                'alphabetical' => __('Alphabetical', 'pauple-helpie'),
                                'menu_order' => __('Menu Order', 'pauple-helpie'),
                                'asc_post_date' => __('Asc Post Date', 'pauple-helpie'),
                                'desc_post_date' => __('Desc Post Date', 'pauple-helpie'),
                            ),
                            'default' => 'menu_order',
                        ),

                    ),
                )
            );
        }

        public function demo_import($prefix)
        {
            $entries = get_option('helpiekb_imported_entries');
            if ($this->isset_entries($entries)) {
                $demo_section = $this->extras->get_demo_section($entries);
                // Create a section
                \CSF::createSection(
                    $prefix,
                    array(
                        'title' => __('Demo Import', 'pauple-helpie'),
                        'icon' => 'fa fa-gift',
                        'fields' => array(

                            array(
                                'type' => 'content',
                                'content' => $demo_section,
                            ),
                        ),
                    )
                );
            }
        }

        protected function isset_entries($entries)
        {
            $isset = false;
            if (!empty($entries)) {
                foreach ($entries as $type) {
                    if (isset($type) && !empty($type)) {
                        $isset = true;
                    }
                }
            }

            return $isset;
        }

        public function backup($prefix)
        {
            // Create a section
            \CSF::createSection(
                $prefix,
                array(
                    'title' => Translations::getStrings('BackupRestore'),
                    'icon' => 'fa fa-download',
                    'fields' => array(
                        array(
                            'type' => 'subheading',
                            'content' => __('Backup and Restore Settings', 'pauple-helpie'),
                            'subtitle' => __('Currently does not backup topic-level, article-level dynamic caps', 'pauple-helpie'),
                        ),
                        // A Submessage
                        array(
                            'type' => 'submessage',
                            'style' => 'success',
                            'content' => __('The backup will download a JSON file. To import, open the JSON file and copy everything and paste below', 'pauple-helpie'),
                        ),
                        array(
                            'type' => 'backup',
                        ),
                    ),
                )
            );
        }

        public function toc($prefix)
        {
            // Create a section
            \CSF::createSection($prefix, array(
                'title' => Translations::getStrings('TableofContents'),
                'icon' => 'fa fa-bars',
                'fields' => array(

                    array(
                        'id' => 'helpie_sidebar_title',
                        'type' => 'text',
                        'title' => __('Table of Contents Title', 'pauple-helpie'),
                        'default' => 'Table of Contents',
                    ),
                    array(
                        'id' => 'helpie_sidebar_fixed',
                        'type' => 'switcher',
                        'title' => __('Fixed Sidebar Position', 'pauple-helpie'),
                        'default' => false,
                    ),
                    array(
                        'id' => 'helpie_sidebar_type',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Sidebar Type', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'full-nav' => __('Full Navigation', 'pauple-helpie'),
                            'page-scroll-only' => __('In-Page Navigation only', 'pauple-helpie'),
                        ),
                        'default' => 'full-nav',
                        'desc' => __('If you Select In-Page-Only other than single page default to Full Navigation', 'pauple-helpie'),
                    ),
                    array(
                        'type' => 'subheading',
                        'title' => __('Full Navigation Settings', 'pauple-helpie'),
                        'subtitle' => __('Full Navigation shows categories, articles, etc', 'pauple-helpie'),
                        'dependency' => array('helpie_sidebar_type', '==', 'full-nav'),
                    ),
                    array(
                        'id' => 'helpie_sidebar_auto_toc',
                        'type' => 'switcher',
                        'title' => __('Show In-Page Navigation in Table Of Contents', 'pauple-helpie'),
                        'desc' => __('Showing In-Page-Nav Within a Current Post in Single Page Only', 'pauple-helpie'),
                        'dependency' => array('helpie_sidebar_type', '==', 'full-nav'),
                        'default' => false,
                    ),

                    array(
                        'id' => 'helpie_sidebar_categories',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Sidebar Categories', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'all' => __('All', 'pauple-helpie'),
                            'mp' => __('Main Page', 'pauple-helpie'),
                        ),
                        'default' => 'all',
                        'dependency' => array('helpie_sidebar_type', '==', 'full-nav'),
                        'desc' => __('If you Select Main Page options Sidebar will display Categories of Main Page', 'pauple-helpie'),
                    ),
                    // array(
                    //     'id' => 'helpie_sidebar_cat_toggle',
                    //     'type' => 'switcher',
                    //     'title' => __('Toggle Category children', 'pauple-helpie'),
                    //     'default' => true,
                    //     'dependency' => array('helpie_sidebar_type', '==', 'full-nav'),
                    // ),
                    array(
                        'id' => 'helpie_sidebar_category_anchor_link',
                        'type' => 'switcher',
                        'title' => __('Category anchor link', 'pauple-helpie'),
                        'default' => false,
                        'dependency' => array('helpie_sidebar_type', '==', 'full-nav'),
                    ),
                    array(
                        'id' => 'helpie_sidebar_num_of_child_category',
                        'type' => 'text',
                        'title' => __('Number of child category to show', 'pauple-helpie'),
                        'default' => 5,
                        'validate' => 'csf_validate_numeric',
                        'dependency' => array('helpie_sidebar_type', '==', 'full-nav'),
                    ),
                    array(
                        'id' => 'helpie_sidebar_num_of_articles',
                        'type' => 'text',
                        'title' => __('Number of articles to show under each category', 'pauple-helpie'),
                        'default' => 5,
                        'validate' => 'csf_validate_numeric',
                        'dependency' => array('helpie_sidebar_type', '==', 'full-nav'),
                    ),

                    array(
                        'id' => 'helpie_sidebar_show_articles',
                        'type' => 'switcher',
                        'title' => __('Show Articles in TOC', 'pauple-helpie'),
                        'default' => true,
                        'dependency' => array('helpie_sidebar_type', '==', 'full-nav'),
                    ),
                    array(
                        'type' => 'subheading',
                        'title' => __('In-Page Navigation Settings', 'pauple-helpie'),
                        'subtitle' => __('In-Page Navigation is built from h1-h6 tags found in the article', 'pauple-helpie'),
                    ),

                    array(
                        'id' => 'helpie_auto_toc_exclude_headings',
                        'type' => 'select',
                        'multiple' => true,
                        'chosen' => true,
                        'title' => __('Exclude Headings', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            '1' => 'h1',
                            '2' => 'h2',
                            '3' => 'h3',
                            '4' => 'h4',
                            '5' => 'h5',
                            '6' => 'h6',
                        ),
                        'desc' => __('Lower level headings without parents will be treated as root entries', 'pauple-helpie'),
                    ),
                    array(
                        'id' => 'helpie_auto_toc_title',
                        'type' => 'text',
                        'title' => __('In-Page Navigation Title', 'pauple-helpie'),
                        'default' => 'In This Article',
                    ),
                    array(
                        'id' => 'helpie_auto_toc_bullet',
                        'type' => 'switcher',
                        'title' => __('Numeric Bullet', 'pauple-helpie'),
                        'default' => false,
                    ),
                    array(
                        'id' => 'helpie_auto_toc_section_page_url',
                        'type' => 'switcher',
                        'title' => __('Section Page URL', 'pauple-helpie'),
                        'default' => false,
                    ),
                    array(
                        'id' => 'helpie_auto_toc_section_page_url_text',
                        'type' => 'text',
                        'title' => __('Section Page URL Text', 'pauple-helpie'),
                        'default' => 'helpie-sp',
                    ),
                    array(
                        'id' => 'helpie_auto_toc_back_to_top_link',
                        'type' => 'switcher',
                        'title' => __('Back to top link', 'pauple-helpie'),
                        'default' => false,
                    ),
                    array(
                        'id' => 'helpie_auto_toc_back_to_top_text',
                        'type' => 'text',
                        'title' => __('Back to top Text', 'pauple-helpie'),
                        'default' => 'Back to Top',
                        'dependency' => array('helpie_auto_toc_back_to_top_link', '==', 'true'),

                    ),
                    array(
                        'id' => 'helpie_auto_toc_scroll_back_to_site_top',
                        'type' => 'switcher',
                        'title' => __('Scroll Back to Site Top', 'pauple-helpie'),
                        'dependency' => array('helpie_auto_toc_back_to_top_link', '==', 'true'),
                        'desc' => __('by default, back to top scrolls to article text top', 'pauple-helpie'),
                        'default' => false,
                    ),
                    array(
                        'id' => 'helpie_auto_toc_smooth_scroll',
                        'type' => 'switcher',
                        'title' => __('Smooth Scroll', 'pauple-helpie'),
                        'default' => true,
                    ),

                ),

            ));
        }

        public function single_page($prefix)
        {
            // SECTION: Single Article

            \CSF::createSection($prefix, array(
                'title' => Translations::getStrings('SingleArticlePage'),
                'icon' => 'fa fa-file',

                'fields' => array(
                    array(
                        'type' => 'subheading',
                        'content' => __('Single - Template Settings', 'pauple-helpie'),
                    ),
                    // A Submessage
                    array(
                        'type' => 'submessage',
                        'style' => 'success',
                        'content' => '<b>' . __('Template Source', 'pauple-helpie') . '</b> ' . __('Use the Theme Template to get', 'pauple-helpie') . ' : </br>'
                        . '1) ' . __('Your Theme Template', 'pauple-helpie')
                        . '</br>2) ' . __('Elementor Theme Builder Template (not for page builder)', 'pauple-helpie'),
                    ),
                    array(
                        'id' => 'helpie_sp_template_source',
                        'type' => 'select',
                        'title' => __('Template Source', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'chosen' => true,
                        'options' => array(
                            'helpie' => __('Helpie Default Template', 'pauple-helpie'),
                            'elementor' => __('Theme Single Template', 'pauple-helpie'),
                        ),
                        'default' => 'helpie',
                    ),
                    // A Submessage
                    array(
                        'type' => 'submessage',
                        'style' => 'success',
                        'content' => __('You can add widgets to your sidebar from Appearance -> Widgets', 'pauple-helpie'),
                    ),

                    // A Submessage
                    array(
                        'type' => 'submessage',
                        'style' => 'warning',
                        'content' => __("You can add HelpieKB's Table of Contents to your sidebar", "pauple-helpie"),
                        'dependency' => array('helpie_sp_template_source', '==', 'elementor'),
                    ),

                    array(
                        'id' => 'helpie_sp_template',
                        'type' => 'image_select',
                        'title' => __('Template', 'pauple-helpie'),
                        'options' => array(
                            'both-side-sidebars' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/both-side-sidebars.png',
                            'left-sidebar' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/left-sidebar.png',
                            'right-sidebar' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/right-sidebar.png',
                            'full-width' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/full-width.png',
                        ),
                        'default' => 'left-sidebar',
                        'dependency' => array('helpie_sp_template_source', '==', 'helpie'),
                    ),

                    array(
                        'id' => 'helpie_sp_sidebar1',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Sidebar 1', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => 'sidebars',
                        'default' => 'helpie_sidebar',
                        'dependency' => array('helpie_sp_template|helpie_sp_template_source', 'any|==', 'both-side-sidebars,left-sidebar,right-sidebar|helpie'),
                    ),
                    array(
                        'id' => 'helpie_sp_sidebar2',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Sidebar 2', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => 'sidebars',
                        'default' => 'helpie_sidebar',
                        'dependency' => array('helpie_sp_template|helpie_sp_template_source', '==|==', 'both-side-sidebars|helpie'),
                    ),
                    array(
                        'type' => 'subheading',
                        'content' => __('Single - Labelling', 'pauple-helpie'),
                    ),
                    array(
                        'id' => 'helpie_sp_cpt_label',
                        'type' => 'text',
                        'title' => __('Single Post Label', 'pauple-helpie'),
                        'default' => __('Article', 'pauple-helpie'),
                        'help' => "Changes the Single post Wiki Label 'Article' into your Custom Label.",
                    ),

                    array(
                        'id' => 'helpie_sp_cpt_label_plural',
                        'type' => 'text',
                        'title' => __('Single Post Label Plural', 'pauple-helpie'),
                        'default' => __('Articles', 'pauple-helpie'),
                    ),

                    array(
                        'type' => 'subheading',
                        'content' => __('Components', 'pauple-helpie'),
                    ),

                    array(
                        'id' => 'helpie_single_page_search_display',
                        'type' => 'switcher',
                        'title' => __('Show Search', 'pauple-helpie'),
                        'default' => true,
                    ),

                    array(
                        'id' => 'helpie_single_page_updatedby_display',
                        'type' => 'switcher',
                        'title' => __('Show Author Name', 'pauple-helpie'),
                        'default' => true,
                    ),
                    array(
                        'id' => 'helpie_single_page_updatedon_display',
                        'type' => 'switcher',
                        'title' => __('Show Last Updated On', 'pauple-helpie'),
                        'default' => false,
                    ),
                    array(
                        'id' => 'helpie_single_page_show_pageviews',
                        'type' => 'switcher',
                        'title' => __('Show Number of Reads', 'pauple-helpie'),
                        'default' => false,
                    ),

                    array(
                        'type' => 'subheading',
                        'content' => __('Voting', 'pauple-helpie'),
                    ),

                    array(
                        'id' => 'helpie_voting_template',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Voting system', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'classic' => __('Classic', 'pauple-helpie'),
                            'emotion' => __('Emotion', 'pauple-helpie'),
                            'none' => __('None', 'pauple-helpie'),
                        ),
                        'default' => 'emotion',
                    ),

                    array(
                        'id' => 'helpie_voting_label',
                        'type' => 'text',
                        'title' => __('Voting Label', 'pauple-helpie'),
                        'default' => __('How did you like this article?', 'pauple-helpie'),
                    ),

                    array(
                        'id' => 'helpie_voting_access',
                        'type' => 'switcher',
                        'title' => __('Allow non-logged in users to vote', 'pauple-helpie'),
                        'dependency' => array('helpie_voting_template', '!=', 'none'),
                        'default' => false,
                    ),

                    array(
                        'type' => 'subheading',
                        'content' => __('Comments', 'pauple-helpie'),
                        'dependency' => array('helpie_sp_template_source', '==', 'helpie'),
                    ),

                    array(
                        'id' => 'helpie_show_comments',
                        'type' => 'switcher',
                        'title' => __('Show comments', 'pauple-helpie'),
                        'default' => false,
                        'dependency' => array('helpie_sp_template_source', '==', 'helpie'),
                    ),
                    array(
                        'type' => 'subheading',
                        'content' => __('Style', 'pauple-helpie'),
                        'dependency' => array('helpie_sp_template_source', '==', 'helpie'),
                    ),
                    array(
                        'id' => 'helpie_post_title_color',
                        'type' => 'color',
                        'title' => __('Single Post - Title Color', 'pauple-helpie'),
                        'default' => '#777777',
                        'dependency' => array('helpie_sp_template_source', '==', 'helpie'),
                    ),
                ),
            ));
        }

        public function category_page($prefix)
        {
            // Create a section
            \CSF::createSection($prefix, array(
                'title' => __('Category Page', 'pauple-helpie'),
                'icon' => 'fa fa-folder-open',
                'fields' => array(
                    array(
                        'id' => 'helpie_cp_template',
                        'type' => 'image_select',
                        'title' => __('Template', 'pauple-helpie'),
                        'options' => array(
                            'both-side-sidebars' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/both-side-sidebars.png',
                            'left-sidebar' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/left-sidebar.png',
                            'right-sidebar' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/right-sidebar.png',
                            'full-width' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/helpie_cp_template/full-width.png',
                        ),
                        'default' => 'left-sidebar',
                    ),
                    // A Submessage
                    array(
                        'type' => 'submessage',
                        'style' => 'success',
                        'content' => __('You can add widgets to your sidebar from Appearance -> Widgets', 'pauple-helpie'),
                    ),
                    array(
                        'id' => 'helpie_cp_sidebar1',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Sidebar 1', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => 'sidebars',
                        'default' => 'helpie_sidebar',
                        'dependency' => array('helpie_cp_template', 'any', 'both-side-sidebars,left-sidebar,right-sidebar'),
                    ),
                    array(
                        'id' => 'helpie_cp_sidebar2',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Sidebar 2', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => 'sidebars',
                        'default' => 'helpie_sidebar',
                        'dependency' => array('helpie_cp_template', '==', 'both-side-sidebars'),
                    ),

                    array(
                        'id' => 'helpie_cat_page_search_display',
                        'type' => 'switcher',
                        'title' => __('Search Display', 'pauple-helpie'),
                        'default' => true,
                    ),
                    array(
                        'id' => 'helpie_cp_slug',
                        'type' => 'text',
                        'title' => __('Category Page Slug', 'pauple-helpie'),
                        'default' => 'helpdesk_category',
                    ),
                    array(
                        'id' => 'helpie_cat_title_color',
                        'type' => 'color',
                        'title' => __('Category Page - Title Color', 'pauple-helpie'),
                        'default' => '#777777',
                        'output' => array('.helpie-single-page-module.category-page h1'),
                        'output_important' => true,
                    ),
                    array(
                        'type' => 'subheading',
                        'title' => __('Article Listing', 'pauple-helpie'),
                        'subtitle' => '',
                    ),
                    array(
                        'id' => 'helpie_cp_article_list_style',
                        'type' => 'select',
                        'title' => __('Article List Style', 'pauple-helpie'),
                        'options' => array(
                            'minimal' => __('Minimal', 'pauple-helpie'),
                            'boxed' => __('Boxed', 'pauple-helpie'),

                        ),
                        'default' => 'boxed',
                    ),

                    array(
                        'id' => 'helpie_cp_article_list_columns',
                        'type' => 'select',
                        'title' => __('Article List - Number of Columns', 'pauple-helpie'),
                        'options' => array(
                            'one' => __('1 - One', 'pauple-helpie'),
                            'two' => __('2 - Two', 'pauple-helpie'),

                        ),
                        'default' => 'two',
                    ),
                    array(
                        'id' => 'helpie_cp_article_text-typography',
                        'type' => 'typography',
                        'title' => __('Article List - Typography', 'pauple-helpie'),
                        'output' => array('.helpie-single-page-module .helpiekb-box-list li a'),
                        'output_important' => true,
                    ),
                    array(
                        'id' => 'helpie_cp_article_border',
                        'type' => 'border',
                        'title' => __('Article List - Border', 'pauple-helpie'),
                        'output' => array('.helpie-single-page-module .helpiekb-box-list li a'),
                        'output_important' => true,
                    ),
                    array(
                        'id' => 'helpie_cp_article_margin',
                        'type' => 'spacing',
                        'title' => __('Article List - Margin', 'pauple-helpie'),
                        'output' => array('.helpie-single-page-module .helpiekb-box-list li a'),
                        'output_mode' => 'margin',
                        'output_important' => true,
                    ),
                    // array(
                    //     'id'    => 'helpie_cp_article_icon',
                    //     'type'  => 'icon',
                    //     'title' => 'Article List - Icon',
                    // ),
                    array(
                        'id' => 'helpie_cp_article_icon_color',
                        'type' => 'color',
                        'title' => __('Article List - Icon Color', 'pauple-helpie'),
                        'output' => '.helpie-single-page-module .helpiekb-box-list li a::after',
                        'output_important' => true,
                    ),
                    array(
                        'type' => 'subheading',
                        'title' => __('Child Category List', 'pauple-helpie'),
                        'subtitle' => '',
                    ),
                    array(
                        'id' => 'helpie_cp_child_category_template',
                        'type' => 'select',
                        'chosen' => true,
                        'title' => __('Child Category Listing Style', 'pauple-helpie'),
                        'placeholder' => __('Select an option', 'pauple-helpie'),
                        'options' => array(
                            'boxed' => __('Boxed', 'pauple-helpie'),
                            /* boxed1 has issues  - no articles displayed for boxed1 */
                            // 'boxed1' => __('Boxed1', 'pauple-helpie'),
                            'modern' => __('Modern', 'pauple-helpie'),
                        ),
                        'default' => 'boxed',
                        // 'dependency' => array('main_page_categories', '==', 'true'),
                    ),
                ),
            ));
        }

        public function get_capabilities_fields($prefix)
        {
            $cap_fields = $this->get_cap_fields();

            \CSF::createSection($prefix, array(
                // 'parent' => 'user_access',
                'title' => 'Can View',
                'icon' => 'fa fa-eye',
                'fields' => array(

                    array(
                        'id' => 'can_view',
                        'type' => 'fieldset',
                        'title' => 'Who Can View',
                        'fields' => $cap_fields,
                    ),
                ),
            ));

            \CSF::createSection($prefix, array(
                // 'parent' => 'user_access',
                'title' => 'Can Edit',
                'icon' => 'fa fa-pencil',
                'fields' => array(

                    array(
                        'id' => 'can_edit',
                        'type' => 'fieldset',
                        'title' => 'Who Can Edit',
                        'fields' => $cap_fields,
                    ),
                ),
            ));

            \CSF::createSection($prefix, array(
                // 'parent' => 'user_access',
                'title' => 'Can Publish',
                'icon' => 'fa fa-book',
                'fields' => array(

                    array(
                        'id' => 'can_publish',
                        'type' => 'fieldset',
                        'title' => 'Who Can Publish',
                        'fields' => $cap_fields,
                    ),
                ),
            ));

            \CSF::createSection($prefix, array(
                // 'parent' => 'user_access',
                'title' => 'Can Approve',
                'icon' => 'fa fa-check',
                'fields' => array(

                    array(
                        'id' => 'can_approve',
                        'type' => 'fieldset',
                        'title' => 'Who Can Approve',
                        'fields' => $cap_fields,
                    ),
                ),
            ));
        }

        protected function get_all_usernames()
        {
            if (isset($this->usernames) && is_array($this->usernames)) {
                return $this->usernames;
            }

            $args = array(
                // 'number' => 10000,
                'offset' => 0,
                'fields' => array('ID', 'display_name'),
            );

            $users = \get_users($args);

            $this->usernames = array();

            foreach ($users as $user) {
                $this->usernames[$user->ID] = $user->display_name;
            }

            return $this->usernames;
        }

        public function get_cap_fields($scope = 'other', $cap = 'can_view')
        {
            $usernames = $this->get_all_usernames();

            // $roles = $this->get_editable_roles();

            $fields = array(
                array(
                    'id' => 'type',
                    'type' => 'select',
                    'title' => __('Select By', 'pauple-helpie'),
                    'placeholder' => __('Select an option', 'pauple-helpie'),
                    'options' => array(
                        // 'default' => __('Default from Parent / Global', 'pauple-helpie'),
                        'all' => __('All', 'pauple-helpie'),
                        'none' => __('No One', 'pauple-helpie'),
                        'logged_in' => __('Logged in', 'pauple-helpie'),
                        'roles' => __('Role', 'pauple-helpie'),
                        'user_id' => __('User name', 'pauple-helpie'),
                    ),

                ),

                array(
                    'id' => 'rule',
                    'type' => 'select',
                    'dependency' => array('type', 'any', 'roles,user_id'),
                    'title' => __('Rule', 'pauple-helpie'),
                    'placeholder' => __('Select an option', 'pauple-helpie'),
                    'options' => array(
                        // 'default' => __('Default', 'pauple-helpie'),
                        'all_except' => __('Everyone Except', 'pauple-helpie'),
                        'only' => __('Only', 'pauple-helpie'),
                    ),
                    'default' => 'all',
                ),

                array(
                    'id' => 'usernames',
                    'type' => 'select',
                    'dependency' => array('type', '==', 'user_id'),
                    'chosen' => true,
                    'multiple' => true,
                    'title' => __('Usernames', 'pauple-helpie'),
                    'placeholder' => __('Select an option', 'pauple-helpie'),
                    'options' => $usernames,
                    'default' => 'option-2',
                ),
                array(
                    'id' => 'roles',
                    'type' => 'select',
                    'dependency' => array('type', '==', 'roles'),
                    'chosen' => true,
                    'multiple' => true,
                    'title' => __('Roles', 'pauple-helpie'),
                    'placeholder' => __('Select an option', 'pauple-helpie'),
                    'options' => 'get_dynamic_caps_roles',
                    'default' => 'option-2',
                ),

            );

            // Global should not have 'default'

            if ($scope == 'global') {
                if ($cap == 'can_view') {
                    $fields[0]['default'] = 'all';
                } else {
                    $fields[0]['default'] = 'none';
                }
            }

            if ($scope != 'global') {
                $fields[0]['options'] = array_merge(array('default' => __('Default from Parent / Global', 'pauple-helpie')), $fields[0]['options']);
                $fields[0]['default'] = 'default';
            }

            return $fields;
        }

        public function can_view_posts()
        {

            $prefix = '_helpie_kb_post_options';

            \CSF::createMetabox($prefix, array(
                'title' => 'Helpie KB',
                'post_type' => 'pauple_helpie',
                'show_restore' => true,
            ));

            $this->get_capabilities_fields($prefix);
        }

        public function can_view_topics()
        {
            // Field: fieldset

            $prefix = '_helpie_kb_options';

            // Create taxonomy options

            \CSF::createTaxonomyOptions($prefix, array(
                'taxonomy' => 'helpdesk_category',
            ));

            $this->get_capabilities_fields($prefix);
        }
    } // END CLASS
}
