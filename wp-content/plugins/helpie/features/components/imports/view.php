<?php

namespace Helpie\Features\Components\Imports;

if (!class_exists('\Helpie\Features\Components\Imports\View')) {
    class View
    {
        public function __construct()
        {
            $this->imported_option_name = 'helpiekb_imported_entries';
        }

        public function get_demo_content_view($entries)
        {
            $html = $this->get_demo_content($entries);

            $html .= '<button class="ui red basic button delete-demo-button">';
            $html .= '<i class="redo icon"></i>';
            $html .= __('Delete', HELPIE_DOMAIN);
            $html .= '</button>';

            // ob_start();
            // $onboarding = new \Helpie\Features\Components\Onboarding\Controller();
            // $onboarding->get_view();
            // $html .= ob_get_contents();
            // ob_clean();

            return $html;
        }

        protected function get_demo_content($entries)
        {
            $html = '';
            $html .= $this->get_top_attached_header();

            $html .= '<div class="ui attached segment pauple-import">';
            $html .= '<div class="ui mini list wrapper-list">';
            $html .= '<div class="ui checkbox check_all_checkbox">';
            $html .= '<input type="checkbox" name="all">';
            $html .= '<label>' . __('Select All', HELPIE_DOMAIN) . '</label>';
            $html .= '</div>';

            if (isset($entries) && !empty($entries)) {
                foreach ($entries as $type => $data) {
                    if (isset($data) && !empty($data)) {
                        $html .= $this->get_check_list($data, $type);
                    }
                }
            }
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }

        protected function get_top_attached_header()
        {
            $html = '<h3 class="ui top attached header">';
            $html .= '<i class="tasks icon"></i>';
            $html .= '<div class="content">';
            $html .= __('Demo', HELPIE_DOMAIN);
            $html .= '<div class="sub header">';
            $html .= __('Manage your imported demo entries', HELPIE_DOMAIN);
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</h3>';

            return $html;
        }

        protected function get_check_list($data, $type)
        {
            $html = '';

            $html .= '<div class="item">';
            $html .= '<div class="ui master checkbox">';
            $html .= '<input type="checkbox" name="' . $type . '">';
            $html .= '<label class="term_title">' . ucfirst($type) . '</label>';
            $html .= '</div>';
            $html .= '<div class="ui mini list">';
            foreach ($data as $key => $id) {
                $html .= $this->get_check_item($key, $id, $type);
            }
            $html .= '</div></div>';

            return $html;
        }

        protected function get_check_item($key, $id, $type)
        {
            $html = '';
            $title = null;
            switch ($type) {
                case 'articles':
                    $title = get_the_title($id);
                    break;
                case 'pages':
                    $title = get_the_title($id);
                    break;
                case 'faqs':
                    $title = get_the_title($id);
                    break;
                case 'attachments':
                    $title = get_the_title($id);
                    break;
                case 'topics':
                    $title = get_term($id)->name;
                    break;
                case 'faq_topics':
                    $title = get_term($id)->name;
                    break;
                case 'tags':
                    $title = get_term($id)->name;
                    break;
                case 'up_tags':
                    $title = get_term($id)->name;
                    break;
                case 'add_tags':
                    $title = get_term($id)->name;
                    break;
            }

            if (empty($title) || is_null($title)) {
                $this->unset_id_from_entries($key, $type);
            }

            $html .= $this->get_item($id, $title);

            return $html;
        }

        protected function get_item($id, $title)
        {
            $html = '<div class="item">';
            $html .= '<div class="ui child checkbox">';
            $html .= '<input type="checkbox" name="' . $id . '">';
            $html .= '<label>' . ucfirst($title) . '</label>';
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }

        protected function unset_id_from_entries($key, $type)
        {
            $entries = get_option($this->imported_option_name, true);
            if (isset($entries[$type][$key])) {
                unset($entries[$type][$key]);
                update_option($this->imported_option_name, $entries);
            }
        }
    }
}
