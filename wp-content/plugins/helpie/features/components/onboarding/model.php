<?php

namespace Helpie\Features\Components\Onboarding;

if (!class_exists('\Helpie\Features\Components\Onboarding\Model')) {
    class Model
    {
        public function get_args()
        {
            $args = [
                'pages' => $this->get_pages_props(),
                'demos' => $this->get_demos_props(),
            ];

            return $args;
        }

        public function set_page_info($args)
        {
            $entries = get_option('helpiekb_imported_entries', true);
            $settings = get_option('helpie-kb', true);

            $settings['helpie_mp_location'] = 'page';
            $settings['helpie_mp_slug'] = $args['page']['page_slug'];
            $settings['helpie_mp_select_page'] = $entries['pages'][0];
            $settings['helpie_mp_meta_title'] = $args['page']['page_name'];
            $settings['mp_hero_section_order']['kb_main_title'] = $args['page']['page_name'];

            $page = array(
                'ID' => $entries['pages'][0],
                'post_title' => $args['page']['page_name'],
                'post_name' => $args['page']['page_slug'],
            );

            // update page info
            if (!is_null(get_post($page['ID']))) {
                wp_update_post($page);
            }

            // if elementor plugin is not active
            if (!is_plugin_active('elementor/elementor.php')) {
                wp_delete_post($entries['pages'][0], true);
                $settings['helpie_mp_location'] = 'archive';
                unset($entries['pages'][0]);
                update_option('helpiekb_imported_entries', $entries);
            }

            update_option('helpie-kb', $settings);
        }

        private function get_pages_props()
        {
            return [
                [
                    'title' => 'Page Setup',
                    'sub_title' => 'Manage basic main page settings',
                    'icon_class' => 'rocket',
                ],

                [
                    'title' => 'Demo Content & Dummy Content',
                    'sub_title' => 'Content to get started',
                    'icon_class' => 'newspaper outline',
                ],

                [
                    'title' => 'Imported Demo',
                    'sub_title' => 'Manage your imported demo',
                    'icon_class' => 'rocket',
                ],
            ];
        }

        private function get_demos_props()
        {
            return [
                'startup' => [
                    'name' => 'startup',
                    'preview' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/demos/startup-preview.svg',
                    'xml_file' => HELPIE_PLUGIN_PATH . '/includes/asset-files/xml/startup.xml',
                ],

                'teamspace' => [
                    'name' => 'teamspace',
                    'preview' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/demos/teamspace-preview.svg',
                    'xml_file' => HELPIE_PLUGIN_PATH . '/includes/asset-files/xml/teamspace.xml',
                ],
                'wiki' => [
                    'name' => 'wiki',
                    'preview' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/demos/wiki-preview.svg',
                    'xml_file' => HELPIE_PLUGIN_PATH . '/includes/asset-files/xml/wiki.xml',
                ],
                'wikilite' => [
                    'name' => 'wikilite',
                    'preview' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/demos/wikilite-preview.svg',
                    'xml_file' => HELPIE_PLUGIN_PATH . '/includes/asset-files/xml/wikilite.xml',
                ],
                'woostore' => [
                    'name' => 'woostore',
                    'preview' => HELPIE_PLUGIN_URL . '/includes/asset-files/images/demos/woostore-preview.svg',
                    'xml_file' => HELPIE_PLUGIN_PATH . '/includes/asset-files/xml/woostore.xml',
                ],
            ];
        }
    }
}
