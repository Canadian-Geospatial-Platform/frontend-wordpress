<?php

namespace Helpie\Includes\Update;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Update\Default_Value_Setter')) {
    class Default_Value_Setter
    {
        public function set_default_values_after_update()
        {
            /* Core Page */
            $this->set_core_default_values();

            /* Style Page */
            $this->set_style_default_values();

            /* Components */
            $this->set_components_default_values();

            /* Main Page */
            $this->set_mp_default_values();

            /* Single Page */
            $this->set_sp_default_values();

            /* Category Page */
            $this->set_cp_default_values();
        }

        // Used when updating from version below 1.0.0
        public function set_default_values_before_update()
        {
            /* Main Page */

            $mp_options = get_option('helpie_mp_options');

            if (!isset($mp_options['main_page_search_display'])) {
                $mp_options['main_page_search_display'] = 'on';
            }

            if (!isset($mp_options['main_page_categories'])) {
                $mp_options['main_page_categories'] = 'on';
            }

            if (!isset($mp_options['main_page_popular'])) {
                $mp_options['main_page_popular'] = 'on';
            }

            update_option('helpie_mp_options', $mp_options);
        }

        /* PROTECTED METHODS */
        protected function set_core_default_values()
        {
            $core_options = get_option('helpie_core_options_main');

            $defaults_array = array(
                'kb_main_title' => 'Helpdesk',
                'kb_main_subtitle' => 'We’re here to help.',
                'kb_edit_capability' => array('kb_edit_capability' => 'administrator, editor'),
            );

            $core_options = $this->set_option_to_grp_if_not_set($defaults_array, $core_options);

            update_option('helpie_core_options_main', $core_options);
        }

        protected function set_style_default_values()
        {
            $style_options = get_option('helpie_style_options');

            $defaults_array = array(
                'helpie_brand_primary_color' => '#F4F3F3',
                'helpie_brand_title_color' => '#03363d',
                'helpie_wa_text_color' => '#03363d',
                'helpie_show_search_border' => '',
                'helpie_search_border_color' => '',
                'helpie_search_border_style' => 'squared',
                'helpie_search_placeholder_text' => 'What can I help you with?',
            );

            $style_options = $this->set_option_to_grp_if_not_set($defaults_array, $style_options);

            update_option('helpie_style_options', $style_options);
        }

        protected function set_components_default_values()
        {
            $component_options = get_option('helpie_components_options');

            $defaults_array = array(
                'helpie_breadcrumbs' => 'on',
                'helpie_sidebar_categories' => 'all',
                'helpie_sidebar_cat_toggle' => 'on',
                'helpie_sidebar_auto_toc' => 'on',
                'helpie_auto_toc_title' => 'In This Article',
                'helpie_auto_toc_section_page_url' => 'on',
                'helpie_auto_toc_section_page_url_text' => 'helpie-sp',
                'helpie_auto_toc_back_to_top_text' => 'Back to Top',
                'helpie_auto_toc_scroll_back_to_site_top' => '',
                'helpie_auto_toc_smooth_scroll' => 'on',
                'helpie_sidebar_show_articles' => 'on',
            );
            $component_options = $this->set_option_to_grp_if_not_set($defaults_array, $component_options);

            update_option('helpie_components_options', $component_options);
        }

        protected function set_mp_default_values()
        {
            $mp_options = get_option('helpie_mp_options');

            $defaults_array = array(
                'helpie_mp_slug' => 'pauple_helpie',
                'helpie_mp_sidebar_template' => 'boxed-width',
                'helpie_mp_sidebar1' => 'helpie_sidebar',
                'helpie_mp_sidebar2' => 'helpie_sidebar',
                'helpie_mp_template' => 'boxed',
                'helpie_mp_cl_cols' => 'three',
                'helpie_mp_no_cat_articles' => '5',
                'helpie_mp_location' => 'archive',
            );

            $mp_options = $this->set_option_to_grp_if_not_set($defaults_array, $mp_options);

            update_option('helpie_mp_options', $mp_options);
        }

        protected function set_sp_default_values()
        {
            $sp_options = get_option('helpie_sp_options');

            $defaults_array = array(
                'helpie_sp_template' => 'left-sidebar',
                'helpie_sp_sidebar1' => 'helpie_sidebar',
                'helpie_sp_sidebar2' => 'helpie_sidebar',
                'helpie_sp_cpt_label' => 'Article',
                'helpie_sp_cpt_label_plural' => 'Articles',
                'helpie_sp_show_edit_button' => '',
                'helpie_voting_template' => 'emotion',
                'helpie_single_page_updatedby_display' => 'on',
                'helpie_single_page_search_display' => 'on',
                'article_order' => 'menu_order',
            );

            $sp_options = $this->set_option_to_grp_if_not_set($defaults_array, $sp_options);

            update_option('helpie_sp_options', $sp_options);
        }

        protected function set_cp_default_values()
        {
            $cp_options = get_option('helpie_cp_options');

            $defaults_array = array(
                'helpie_cp_template' => 'left-sidebar',
                'helpie_cp_sidebar1' => 'helpie_sidebar',
                'helpie_cp_sidebar2' => 'helpie_sidebar',
                'helpie_cp_slug' => 'helpdesk_category',
                'helpie_cat_page_search_display' => 'on',
            );

            $cp_options = $this->set_option_to_grp_if_not_set($defaults_array, $cp_options);

            update_option('helpie_cp_options', $cp_options);
        }

        protected function set_option_to_grp_if_not_set($defaults_array, $option_grp)
        {
            foreach ($defaults_array as $key => $value) {
                if (!isset($option_grp[$key])) {
                    $option_grp[$key] = $value;
                }
            }

            return $option_grp;
        }
    }
}
