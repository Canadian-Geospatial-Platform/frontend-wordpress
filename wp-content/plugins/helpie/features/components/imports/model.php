<?php

namespace Helpie\Features\Components\Imports;

require_once HELPIE_PLUGIN_PATH . 'includes/lib/importer/parsers.php';
require_once HELPIE_PLUGIN_PATH . 'includes/lib/importer/importer.php';

if (!class_exists('\Helpie\Features\Components\Imports\Model')) {
    class Model
    {
        private $imported_option_name;

        public function __construct()
        {
            $this->imported_option_name = 'helpiekb_imported_entries';
        }

        public function import($args)
        {
            $parser = new \WXR_Parser();
            $importer = new \Pauple_WP_Importer();
            $args['categories'] = explode(',', $args['demo']['categories']);
            $data = $parser->parse($args['items']['xml_file']);
            $data = $this->exclude_postsandcategories($data, $args);
            $result = $importer->import($data);

            $this->store_imported_details($result['result']);

            return $result;
        }

        public function get_demos_categories($props)
        {
            $parser = new \WXR_Parser();

            foreach ($props['demos'] as $key => $demo) {
                $parsed_demo_data = $parser->parse($demo['xml_file']);
                $props['demos'][$key]['categories'] = $this->get_demos_terms($parsed_demo_data);
            }

            return $props;
        }

        public function delete_entries($args)
        {
            $entries = get_option($this->imported_option_name, true);

            if (!$args['checked_all']) {
                unset($args['checked_all']);
                $entries = $args;
            }

            if (isset($entries) && !empty($entries)) {
                foreach ($entries as $type => $data) {
                    if (isset($data) && !empty($data)) {
                        $this->delete_entry($data, $type);
                    }
                }
                return ['notice' => 'Selected content deleted !!'];
            }

            return ['error' => 'Couldn\'t able to delete content !!'];
        }

        protected function exclude_postsandcategories($data, $args)
        {
            // error_log('data : ' . print_r($data, true));

            if (isset($args['categories']) && !empty($args['categories']) && !in_array("all", $args['categories'])) {
                $excluded_data = [
                    'authors' => $data['authors'],
                    'posts' => [],
                    'categories' => $data['categories'],
                    'tags' => $data['tags'],
                    'terms' => [],
                    'base_url' => $data['base_url'],
                    'version' => $data['version'],
                ];

                foreach ($data['posts'] as $post) {

                    if ($post['post_type'] == HELPIE_POST_TYPE) {
                        foreach ($post['terms'] as $term) {
                            if (in_array($term['slug'], $args['categories']) && $term['domain'] == HELPIE_TAXONOMY) {
                                array_push($excluded_data['posts'], $post);
                                break;
                            }
                        }
                    }

                    // Other Post types
                    if ($post['post_type'] !== HELPIE_POST_TYPE) {
                        array_push($excluded_data['posts'], $post);
                    }

                }

                foreach ($data['terms'] as $term) {
                    if (in_array($term['slug'], $args['categories']) && $term['term_taxonomy'] == HELPIE_TAXONOMY) {
                        array_push($excluded_data['terms'], $term);
                    }
                    // Other Taxonomy
                    if ($term['term_taxonomy'] !== HELPIE_TAXONOMY) {
                        array_push($excluded_data['terms'], $term);
                    }
                }

                return $excluded_data;
            }

            return $data;
        }

        protected function store_imported_details($data)
        {
            if (isset($data['articles']) && !empty($data['articles'])) {
                update_option('helpiekb_imported_entries', $data);
            }

            if (isset($data['pages'][0]) && !empty($data['pages'][0])) {
                $kb_settings = get_post_meta($data['pages'][0], 'helpie-kb', true);
                if (isset($kb_settings) && !empty($kb_settings)) {
                    update_option('helpie-kb', $kb_settings);
                }
            }
        }

        protected function get_demos_terms($parsed_demo_data)
        {
            $terms = [];
            foreach ($parsed_demo_data['terms'] as $term) {
                if ($term['term_taxonomy'] == HELPIE_TAXONOMY) {
                    $terms[] = [
                        'name' => $term['term_name'],
                        'slug' => $term['slug'],
                    ];
                }
            }

            return $terms;
        }

        protected function delete_entry($data, $type)
        {
            foreach ($data as $key => $id) {
                switch ($type) {
                    case 'articles':
                        $map_type = 'post';
                        break;
                    case 'pages':
                        $map_type = 'post';
                        break;
                    case 'faqs':
                        $map_type = 'post';
                        break;
                    case 'attachments':
                        $map_type = 'attachment';
                        break;
                    case 'topics':
                        $map_type = 'taxonomy';
                        $term_type = 'helpdesk_category';
                        break;
                    case 'faq_topics':
                        $map_type = 'taxonomy';
                        $term_type = 'helpie_faq_category';
                        break;
                    case 'tags':
                        $map_type = 'taxonomy';
                        $term_type = 'helpie_tag';
                        break;
                    case 'up_tags':
                        $map_type = 'taxonomy';
                        $term_type = 'helpie_up_tag';
                        break;
                    case 'add_tags':
                        $map_type = 'taxonomy';
                        $term_type = 'helpie_add_tag';
                        break;
                }

                if (isset($map_type) && $this->is_exist($id, $map_type)) {
                    if ($map_type == 'post') {
                        $this->reset_page_info($id);
                        wp_delete_post($id, true);

                    }
                    if ($map_type == 'taxonomy' && isset($term_type)) {
                        wp_delete_term($id, $term_type);
                    }
                    if ($map_type == 'attachment') {
                        wp_delete_attachment($id, true);
                    }
                    $this->unset_id_from_entries($key, $type);
                }

            }
        }

        protected function is_exist($id, $map_type = 'taxonomy')
        {
            $exist = false;
            // post or attachment exist
            if (($map_type == 'post' || 'attachment') && !is_null(get_post($id))) {
                $exist = true;
            }
            // term exist
            if ($map_type == 'taxonomy' && !is_wp_error(get_term($id) && !is_null(get_term($id)))) {
                $exist = true;
            }

            return $exist;
        }

        protected function unset_id_from_entries($key, $type)
        {
            $entries = get_option($this->imported_option_name, true);
            if (isset($entries[$type][$key])) {
                unset($entries[$type][$key]);
                update_option($this->imported_option_name, $entries);
            }
        }

        protected function reset_page_info($id)
        {
            if (get_post($id)->post_type == 'page') {
                $settings = get_option('helpie-kb', true);
                $settings['helpie_mp_location'] = 'archive';
                $settings['helpie_mp_slug'] = 'helpdesk';
                $settings['helpie_mp_meta_title'] = 'Helpdesk';
                $settings['mp_hero_section_order']['kb_main_title'] = 'Helpdesk';
                update_option('helpie-kb', $settings);
            }
        }

    }
}
