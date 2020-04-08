<?php

namespace Helpie\Includes\Settings\Getters;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Settings\Getters\Mp_Settings')) {
    class Mp_Settings
    {
        public function __construct()
        {
            $this->options = get_option('helpie-kb'); // unique id of the framework
            // error_log('$this->options : ' . print_r($this->options['opt-sportable-1'], true));
        }

        /* PRIMARY */
        public function get_sidebar_template()
        {
            $mp_grp = $this->options;

            if (isset($mp_grp['helpie_mp_sidebar_template']) && !empty($mp_grp['helpie_mp_sidebar_template'])) {
                return $mp_grp['helpie_mp_sidebar_template'];
            } else {
                return 'boxed-width';
            }
        }

        public function get_mp_location()
        {
            $mp_grp = $this->options;

            if (isset($mp_grp['helpie_mp_location'])) {
                $helpie_mp_location = $mp_grp['helpie_mp_location'];
            } else {
                $helpie_mp_location = 'archive';
            }

            return $helpie_mp_location;
        }

        public function get_mp_selected_page()
        {
            $mp_grp = $this->options;

            if (isset($mp_grp['helpie_mp_select_page'])) {
                return $mp_grp['helpie_mp_select_page'];
            }

            return false;
        }

        public function mp_hero_section_order()
        {
            $mp_hero_section_order =   array(
                'kb_main_title' =>  'Helpdesk',
                'kb_main_subtitle' => 'We’re here to help.',
                'main_page_search_display' => 1,
            );

            if (isset($this->options['mp_hero_section_order']) && is_array($this->options['mp_hero_section_order'])) {
                $mp_hero_section_order = $this->options['mp_hero_section_order'];
            }

            return $mp_hero_section_order;
        }

        public function mp_components_order()
        {
            $mp_components_order =   array(
                'helpie_mp_show_stats' => 0,
                'main_page_categories' => 1,
                'show_article_listing' => 0
            );

            if (isset($this->options['mp_components_order']) && is_array($this->options['mp_components_order'])) {
                $mp_components_order = $this->options['mp_components_order'];
            }

            return $mp_components_order;
        }

        public function get_mp_meta_title()
        {
            $mp_grp = $this->options;
            $title = __('Helpdesk', 'pauple-helpie');
            if (isset($mp_grp['helpie_mp_meta_title'])) {
                $title = $mp_grp['helpie_mp_meta_title'];
            }

            return $title;
        }

        public function get_mp_meta_description()
        {
            $mp_grp = $this->options;

            $description = "";
            if (isset($mp_grp['helpie_mp_meta_description'])) {
                $description = $mp_grp['helpie_mp_meta_description'];
            }

            return $description;
        }

        public function get_mp_slug()
        {
            $mp_grp = $this->options;

            if (isset($mp_grp['helpie_mp_slug'])) {
                $cpt_slug = $mp_grp['helpie_mp_slug'];
            } else {
                $cpt_slug = 'helpdesk';
            }

            return $cpt_slug;
        }

        public function show_stats()
        {
            $mp_options = $this->options;
            $option_name = 'helpie_mp_show_stats';


            $show = false;
            if (array_key_exists($option_name, $mp_options) && !empty($mp_options[$option_name])) {
                $show = $mp_options[$option_name];
            }

            return $show;
        }

        /* COMPONENTS */
        public function can_show_mp_search()
        {
            $mp_options = $this->options;
            $option_name = 'main_page_search_display';

            $show = true;
            if (array_key_exists($option_name, $mp_options) && !empty($mp_options[$option_name])) {
                $show = $mp_options[$option_name];
            }

            return $show;
        }

        public function show_article_listing()
        {
            $mp_options = $this->options;
            $option_name = 'show_article_listing';
            $show = false;
            if (array_key_exists($option_name, $mp_options) && !empty($mp_options[$option_name])) {
                $show = $mp_options[$option_name];
            }
            return $show;
        }

        public function can_show_mp_categories()
        {
            // $option = get_option('helpie_mp_options');

            $can_show_mp_categories = true;
            $option = $this->options;

            if (array_key_exists("main_page_categories", $this->options) && !empty($this->options['main_page_categories'])) {
                $can_show_mp_categories = $this->options['main_page_categories'];
            }


            return $can_show_mp_categories;
        }

        /* Category Listing */

        public function get_listing_type()
        {

            $option_grp = $this->options;

            $listing_type = 'boxed';

            if (isset($option_grp['helpie_mp_template'])) {
                $listing_type = sanitize_text_field($option_grp['helpie_mp_template']);
            }

            return $listing_type;
        }

        public function is_boxed_description_on()
        {

            $mp_options = $this->options;

            // error_log('$mp_options : ' . print_r($mp_options, true));
            $is_boxed_description_on = false;
            if (isset($mp_options) && !empty($mp_options) && isset($mp_options['helpie_mp_boxed_description'])) {
                $is_boxed_description_on = $mp_options['helpie_mp_boxed_description'];
            }

            return $is_boxed_description_on;
        }

        public function get_category_listing_graphic_type()
        {

            $mp_options = $this->options;

            if (!isset($mp_options['category_listing_graphic_type']) || empty($mp_options['category_listing_graphic_type'])) {
                return 'image';
            }

            return $mp_options['category_listing_graphic_type'];
        }

        public function get_helpie_mp_category_listing_children_type()
        {
            // $mp_grp = get_option('helpie_mp_options');
            $mp_grp = $this->options;
            // error_log('$mp_grp : ' . print_r($mp_grp, true));
            if (isset($mp_grp['category_listing_children_type']) && !empty($mp_grp['category_listing_children_type'])) {
                $children_type = $mp_grp['category_listing_children_type'];
            } else {
                $listing_type = $this->get_listing_type();
                if ($listing_type == 'boxed1') {
                    $children_type = 'articles';
                } else { // Keep 'modern' and 'boxed' children as none
                    $children_type = 'none';
                }
            }

            return $children_type;
        }

        public function get_mp_cats()
        {
            $mp_grp = $this->options;

            // error_log('$mp_grp [helpie_mp_cats] : ' . print_r($mp_grp['helpie_mp_cats'], true));

            $condition1 = (!isset($mp_grp['helpie_mp_cats']) || empty($mp_grp['helpie_mp_cats']) || !is_array($mp_grp['helpie_mp_cats']));

            // Step 1: Level 1 - default
            if ($condition1) {
                $mp_cats = ['enabled' => [], 'disabled' => []];
            }

            // Step 2: Set actual value
            if (!$condition1) {
                $mp_cats = $mp_grp['helpie_mp_cats'];
            }

            // Step 3: Level 2 - default ( after setting value )
            if (!isset($mp_cats['enabled']) || !is_array($mp_cats['enabled'])) {
                $mp_cats['enabled'] = [];
            }

            if (!isset($mp_cats['disabled']) || !is_array($mp_cats['disabled'])) {
                $mp_cats['disabled'] = [];
            }

            // error_log('$mp_cats : ' . print_r($mp_cats, true));

            return $mp_cats;
        }

        public function get_mp_category_cols()
        {
            // $mp_grp = get_option('helpie_mp_options');
            $mp_grp = $this->options;

            if (isset($mp_grp['helpie_mp_cl_cols']) && !empty($mp_grp['helpie_mp_cl_cols'])) {
                $no_cols = $mp_grp['helpie_mp_cl_cols'];
            } else {
                $no_cols = 'three';
            }

            return $no_cols;
        }

        // Gets the number of category articles to show based on the
        // current settings in 'Main Page Settings'
        public function get_no_of_category_articles()
        {
            // $mp_grp = get_option('helpie_mp_options');
            $mp_grp = $this->options;
            return isset($mp_grp['helpie_mp_no_cat_articles']) ? $mp_grp['helpie_mp_no_cat_articles'] : 5;
        }

        public function get_article_listing_settings()
        {
            $settings_args = array();
            $article_listing_model = new \Helpie\Features\Components\Articles\Article_Listing_Model();
            $article_fields = $article_listing_model->get_fields();

            foreach ($article_fields as $field) {
                $option_name = 'helpie_mp_article_listing_' . $field['name'];
                $options = $this->options;
                $option_value = isset($options[$option_name]) ? $options[$option_name] : $field['default'];
                $settings_args[$field['name']] = $option_value;
            }

            return $settings_args;
        }
    } // END CLASS
}