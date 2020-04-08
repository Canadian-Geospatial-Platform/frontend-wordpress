<?php

namespace Helpie\Includes\Update;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// Class to handle updates from version less than 1.1.0

if (!class_exists('\Helpie\Includes\Update\Update_191')) {
    class Update_191
    {

        public function update()
        {
            $settings = get_option('helpie-kb');
            // error_log('$settings : ' . print_r($settings, true));

            /* Hero Section Order */
            $settings = $this->hero_section_migrations($settings);

            /* Components Order */
            $settings = $this->mp_components_migrations($settings);

            /* Design Settings */
            $settings = $this->design_migrations($settings);

            /* Set new version for verification later */
            $settings['last_version'] = '1.9.1';

            $result = \update_option('helpie-kb', $settings);
            $updated_option = get_option('helpie-kb');

            if (isset($updated_option['last_version']) && $updated_option['last_version'] == '1.9.1') {
                $result = true;
            }

            // error_log('Update_190 -> update() $result : ' . $result);
            return $result; // update passed or not  ( boolean )
        }


        private function design_migrations($settings)
        {
            if (!isset($settings['design']) || !is_array($settings['design'])) {
                $settings['design'] = [];
            }

            $props = [
                'helpie_margin_top_desktop',
                'helpie_margin_top_tablet',
                'helpie_margin_top_mobile',
                'helpie_wa_background_type',
                'helpie_brand_primary_color',
                'helpie_wa_image',
                'helpie_wa_illustration',
                'helpie_wa_gradient1',
                'helpie_wa_gradient2',
                'helpie_brand_title_color',
                'helpie_wa_text_color'
            ];

            foreach ($props as $key => $prop) {

                if (isset($settings[$prop]) && !empty($settings[$prop])) {
                    $settings['design'][$prop] = $settings[$prop];
                }
            }

            return $settings;
        }

        private function hero_section_migrations($settings)
        {

            if (!isset($settings['mp_hero_section_order'])) {
                $settings['mp_hero_section_order'] = [];
            }

            $settings['mp_hero_section_order']['kb_main_title'] =  $settings['kb_main_title'];
            $settings['mp_hero_section_order']['main_page_search_display'] =  $settings['main_page_search_display'];
            $settings['mp_hero_section_order']['kb_main_subtitle'] =  $settings['kb_main_subtitle'];

            return $settings;
        }

        private function mp_components_migrations($settings)
        {
            if (!isset($settings['mp_components_order'])) {
                $settings['mp_components_order'] = [];
            }

            $settings['mp_components_order']['helpie_mp_show_stats'] = $settings['helpie_mp_show_stats'];
            $settings['mp_components_order']['main_page_categories'] = $settings['main_page_categories'];
            $settings['mp_components_order']['show_article_listing'] = $settings['show_article_listing'];

            return $settings;
        }
    } // END CLASS

}