<?php

namespace Helpie\Features\Components\Frontend_Editor;

include_once HELPIE_PLUGIN_PATH . 'features/domain/models/tags-model.php';

if (!class_exists('\Helpie\Features\Components\Frontend_Editor\Editor_View')) {
    class Editor_View
    {
        private $fields_builder;

        public function __construct($model)
        {
            $this->fields_builder = new \Helpie\Includes\Utils\Builders\Fields_Builder();
            $this->controls_view = new \Helpie\Features\Components\Frontend_Editor\Views\Controls();
            $this->model = $model;
        }

        public function get($viewProps)
        {
            $html = $this->get_main_view($viewProps);
            return $html;
        }

        public function get_main_view($viewProps)
        {
            // CSS Before Content Translateble placeholder for title and content ..
            $html = '';

            $this->custom_styles = new \Helpie\Features\Services\Custom_Styles();
            $html .= $this->custom_styles->get_style();
            $itemsProps = $viewProps['items'];
            $collectionProps = $viewProps['collection'];

            $editor_classes = $this->get_editor_classes($collectionProps);
            $data_attrs = $this->get_data_attrs($itemsProps, $collectionProps);

            $html .= "<div class='" . $editor_classes . "' " . $data_attrs . "'>";
            $html .= $this->get_sidebar($collectionProps, $itemsProps);
            $html .= $this->get_main_area($collectionProps, $itemsProps);
            $html .= "<div class='clear'></div>";
            $html .= "</div>";
            return $html;
        }

        /* PROTECTED METHODS */

        protected function get_sidebar($collectionProps, $itemsProps)
        {
            $html = '';
            $html .= "<div class='helpie-sidebar'>";
            $html .= $this->controls_view->get_view($collectionProps, $itemsProps);
            $html .= "</div>";

            $html .= "<style>html{background-color: #fff !important;}</style>";

            return $html;
        }

        protected function get_main_area($collectionProps, $itemsProps)
        {
            $post_id = $collectionProps['post_id'];
            $post_props = $itemsProps[0]; // Get lastest revision

            $html = '';
            $html .= "<div class='content-area'>";
            if ($collectionProps['editor_mode'] == 'add-article') {
                $html .= $this->get_basic_content_area('', '', $collectionProps['editor_type']);
            } else {
                $content = (isset($post_props['content'])) ? $post_props['content'] : "";
                $html .= $this->get_basic_content_area($post_props['title'], $content, $collectionProps['editor_type']);
                $html .= $this->get_diff_area($post_id, $itemsProps);
            }
            $html .= "</div>";

            return $html;
        }

        protected function get_data_attrs($itemsProps, $collectionProps)
        {
            $post_id = $collectionProps['post_id'];
            $latest_revision_id = $itemsProps[0]['id'];
            $data_attrs = "data-post-id='" . $post_id . "' data-revision-id='" . $latest_revision_id . "'";
            return $data_attrs;
        }

        protected function get_editor_classes($collectionProps)
        {
            $editor_classes = 'helpie-article-editor';

            if ($collectionProps['editor_mode'] == 'add-article') {
                $editor_classes .= ' ' . 'add-article';
            } else {
                $editor_classes .= ' ' . 'edit-article';
            }

            return $editor_classes;
        }

        protected function get_diff_area($post_id, $itemsProps)
        {
            $html = '';
            $html .= "<div class='revision-diff-area'>";
            $html .= "<div class='table-area'>";
            $html .= $this->get_revision_ui_diff($post_id, $itemsProps);
            $html .= "</div>";

            $html .= "</div>";
            return $html;
        }

        protected function get_basic_content_area($title = '', $content = '', $editor_type = 'inline')
        {
            $html = '';
            $html .= "<div class='basic-content-area'>";
            $html .= $this->get_title($title);

            if ($editor_type == 'wpeditor') {
                $html .= $this->get_wpeditor($content);
            } else {
                $html .= $this->get_text($content);
            }

            $html .= "</div>";

            return $html;
        }

        protected function get_wpeditor($content)
        {
            ob_start();
            wp_editor($content, 'content-tinymce');
            $html = ob_get_contents();
            ob_end_clean();

            return $html;
        }

        protected function get_title($title)
        {
            $html = "<h1 id='title-tinymce' class='title tinymce'>";
            $html .= $title;
            $html .= "</h1>";

            return $html;
        }

        protected function get_text($content)
        {
            $content_class = ['article-content'];
            $post_content_class = apply_filters('helpie_kb_single_post_content', $content_class);
            $html = "<div id='content-tinymce' class='editor-content tinymce " . implode(' ', $post_content_class) . " '>";
            $html .= $content;
            $html .= "</div>";

            return $html;
        }

        protected function get_revision_ui_diff($post_id, $itemsProps)
        {
            $diff_array = $this->model->get_revision_diff_array($post_id, $itemsProps);
            $html = '';
            $html .= "<h3>Title Changes:</h3>";
            $html .= $diff_array[0]['diff'];
            $html .= "<h3>Content Changes:</h3>";
            if (isset($diff_array[1])) {
                $html .= $diff_array[1]['diff'];
            }

            return $html;
        }
    } // END CLASS
}
