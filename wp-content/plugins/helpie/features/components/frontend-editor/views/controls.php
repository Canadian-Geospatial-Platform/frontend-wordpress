<?php

namespace Helpie\Features\Components\Frontend_Editor\Views;

if (!class_exists('\Helpie\Features\Components\Frontend_Editor\Views\Controls')) {
    class Controls
    {
        public function __construct()
        {
            $this->fields_builder = new \Helpie\Includes\Utils\Builders\Fields_Builder();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();

            // Single Cpt Name default to "Article"
            $this->article = $this->settings->single_page->get_single_cpt_name();
        }

        public function get_view($collectionProps, $itemsProps)
        {
            $html = '';
            $html .= "<div class='ui dividing right controls-section'>";
            // Mobile Button for controls
            $html .= "<button class='ui icon button mobile-controls'><i class='list ul icon'></i></button>";
            $html .= $this->get_editor_buttons($collectionProps);

            $is_add_mode = ($collectionProps['editor_mode'] == 'add-article');
            $can_user_publish_any_topic = $collectionProps['can_publish'] == true;
            $can_user_approve_any_topic = $collectionProps['can_approve'] == true;



            $can_publish_or_approve = ($can_user_publish_any_topic || $can_user_approve_any_topic);
            if (($is_add_mode && $can_publish_or_approve) || $can_user_approve_any_topic) {
                $html .= $this->sticky_controls($collectionProps, $itemsProps);
            }

            $html .= "</div>";
            return $html;
        }

        public function sticky_controls($collectionProps, $itemsProps)
        {
            $html = '';
            $html .= "<div class='ui sticky'>";
            $html .= "<div class='ui vertical  styled  fluid helpie-accordion menu'>";

            if ($collectionProps['can_approve'] == true) {
                $html .= $this->get_revision_controls($collectionProps, $itemsProps);
            }

            $is_add_mode = ($collectionProps['editor_mode'] == 'add-article');
            $can_user_approve = $collectionProps['can_approve'] == true;

            if ($is_add_mode || $can_user_approve) {

                $html .= $this->get_categories_field_html();
                $html .= $this->get_tags_field_html();
                $html .= $this->get_featured_image_field_html($collectionProps);
            }

            $html .= "</div>";
            $html .= "</div>";

            return $html;
        }

        public function get_revision_controls($collectionProps, $itemsProps)
        {
            $post_id = $collectionProps['post_id'];
            $published_revision_id = $collectionProps['published_revision_id'];

            $html = '';
            $html .= "<div class='item revisions'>";
            $html .= "<a class='item-title'><i class='caret right icon'></i> <b>" . __("Revisions", 'pauple-helpie') . "</b></a>";
            $html .= "<div class='item-content menu'>";

            $html .= $this->get_itemsHTML($itemsProps, $post_id, $published_revision_id);
            $html .= "</div></div>";

            return $html;
        }

        protected function get_categories_field_html()
        {

            $categories_options = $this->get_visible_categories();
            $categories_options[-1] = array(
                'name' => "-- " . __('Parent Wiki Category', 'pauple-helpie') . " --",
                'level' => 0,
                'parent' => 0,
            );

            $label = __('Select a Category', 'pauple-helpie');

            $html = '';
            $html .= "<div class='item'>";
            $html .= "<a class='item-title'><i class='caret down icon'></i> <b>" . __("Categories", 'pauple-helpie') . "</b></a>";
            $html .= "<div class='active item-content menu'>";
            $html .= "<div class='article-categories-field field'>";
            $html .= "<div class='single-field'>";
            $html .= $this->fields_builder->dropdown_frontend('helpdesk_category', $categories_options, $label, '', 3);
            $html .= "</div>";
            $html .= "</div>";

            $html .= $this->get_add_category_html();

            $html .= "</div></div>";

            return $html;
        }

        protected function get_tags_field_html()
        {
            $html = '';
            $html .= "<div class='item'>";
            $html .= "<a class='item-title'><i class='caret down icon'></i> <b>" . __('Tags', 'pauple-helpie') . "</b></a>";
            $html .= "<div class='active item-content menu'>";

            $html .= "<div class='article-terms-field field'>";

            $html .= "<div class='single-field  ui icon input'><label for='tags'></label>";
            $html .= "<input tabindex='4' type='text' id='add-article-tags' placeholder='" . __("Tags", "pauple-helpie") . "' name='add-article-tag' />";
            $html .= "</div>";
            $html .= "<span class='add-field-note'> " . __('Press Enter', 'pauple-helpie') . " <i class='reply icon'></i></span>";

            $html .= "<div class='terms-container'></div>";
            $html .= "<div class='clear'></div>";

            $html .= "</div>";

            $html .= "</div></div>";
            return $html;
        }

        protected function get_featured_image_field_html($props)
        {
            $html = '';
            $html .= "<div class='item'>";
            $html .= "<a class='item-title'><i class='caret down icon'></i> <b>" . __('Featured Image', 'pauple-helpie') . "</b></a>";
            $html .= "<div class='active item-content menu'>";

            $html .= '<div class="ui input" style="margin-bottom: 3px;"> ';
            $html .= '<input id="helpie_kb_featured_upload_image" type="text" name="ad_image" style="display: none;"/>';
            $html .= '</div>';
            $html .= '<button id="helpie_kb_featured_upload_image_button" class="fluid ui labeled icon button" style="outline: none;">
            <i class="upload icon"></i>' . __('Set Featured Image', 'pauple-helpie') . '</button>';

            $html .= "<div class='clear'></div>";
            $html .= '<img class="ui medium rounded image helpie_kb_featured_image" src="' . $props['post_thumbnail'] . '">';
            $html .= "</div></div>";
            return $html;
        }

        protected function get_add_category_html()
        {
            $html = "<div class='add-category-label'>";
            $html .= '<div class="ui label"><i class="plus icon"></i> ' . __("Add Category", "pauple-helpie") . '</div>';
            $html .= '</div>';

            $html .= "<div class='add-category ui icon input' style='display: none; margin-top: 11px;'>";
            $html .= "<input type='text' placeholder='" . __("Your New Category", "pauple-helpie") . "'>";
            $html .= "</div>";

            $html .= "<span class='add-field-note' style='display: none'> " . __('Press Enter', 'pauple-helpie') . " <i class='reply icon'></i></span>";

            return $html;
        }

        protected function get_visible_categories()
        {
            // Categories Field
            $categories_options = array();

            $categories_repo = new \Helpie\Features\Domain\Repositories\Category_Repository();
            $args = array('parent' => 0, 'hide_empty' => 'false');
            $categories_options = $categories_repo->get_editor_category_options(false, $args); // $show_all = false
            // error_log('categories_options : ' . print_r($categories_options, true));
            return $categories_options;
        }

        public function get_pages_buttons($page = 'other')
        {
            $page_controls = new \Helpie\Features\Components\Page_Controls\Controller();
            return $page_controls->get_pages_buttons($page);
        }


        public function get_editor_buttons($collectionProps)
        {
            $primary_button = array(
                'class' => 'submit-for-review',
                'label' => __('Submit For Review', 'pauple-helpie'),
            );
            $secondary_buttons = array(
                0 => array(
                    'class' => 'edit-article',
                    'icon-class' => 'edit',
                    'label' => 'Edit' . " " . $this->article,
                ),
                1 => array(
                    'class' => 'show-diff',
                    'icon-class' => 'hide',
                    'label' => __('Show Diff', 'pauple-helpie'),
                ),
                2 => array(
                    'class' => 'view-article-option',
                    'icon-class' => 'eye',
                    'label' => " " . __('View', 'pauple-helpie') . " " . $this->article,
                    'href' => get_permalink($collectionProps['post_id']),
                ),
            );


            if ($collectionProps['can_publish'] || $collectionProps['can_approve']) {
                $primary_button = array(
                    'class' => 'publish',
                    'label' => __('Publish', 'pauple-helpie'),
                );
            }

            if ($collectionProps['can_approve'] && $collectionProps['editor_mode'] == 'edit-article') {
                $secondary_buttons[3] = array(
                    'class' => 'remove',
                    'icon-class' => 'window close',
                    'label' => __('Remove Revision', 'pauple-helpie'),
                );
            }

            $html = $this->get_button_group($primary_button, $secondary_buttons);

            return $html;
        }

        public function get_button_group($primary_button, $secondary_buttons)
        {
            $html = "<div class='article-publish ui positive buttons'>";
            $html .= "<div class='publish ui button positive " . $primary_button['class'] . "'>" . $primary_button['label'] . "</div>";
            $html .= "<div class='article-publish-dd ui floating dropdown icon button'>";
            $html .= "<i class='dropdown icon'></i>";
            $html .= "<div class='menu'>";

            for ($ii = 0; $ii < sizeof($secondary_buttons); $ii++) {
                $button = $secondary_buttons[$ii];

                $html .= "<div class='item " . $button['class'] . "'>";

                if (isset($button['href'])) {
                    $html .= "<a target='_blank' href='" . $button['href'] . "'>";
                }

                $html .= "<i class='" . $button['icon-class'] . " icon'></i>";
                $html .= $button['label'];

                if (isset($button['href'])) {
                    $html .= "</a>";
                }

                $html .= "</div>";
            }

            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
            return $html;
        }

        public function get_itemsHTML($itemsProps, $post_id, $published_revision_id)
        {
            $count = 0;
            $revisionsProps = $itemsProps;
            $previous_revisionProps = null;
            $html = '';

            $last_item = sizeof($revisionsProps) - 1;

            // Reverse Array so we get $previous_revisionProps
            foreach (array_reverse($revisionsProps) as $revisionProps) {
                $data_attrs = $this->get_data_attrs_html($post_id, $revisionProps, $previous_revisionProps);
                $icon_html = '';

                $class = 'item';

                if ($count == $last_item) {
                    $class .= ' ' . 'active';
                }

                if ($published_revision_id == $revisionProps['id']) {
                    $icon_html = "<i class='check icon'></i>";
                    $class .= ' ' . 'published';
                }

                $this_html = "<a " . $data_attrs . " class='" . $class . "'>" . __("Revision", "pauple-helpie") . " " . $count . " " . $icon_html . "</a>";
                $html = $this_html . $html;
                $previous_revisionProps = $revisionProps;
                $count++;
            }

            return $html;
        }

        public function get_data_attrs_html($post_id, $revisionProps, $previous_revisionProps = null)
        {
            $data_attrs = "data-post-id='" . $post_id . "'";
            $data_attrs .= "data-revision-id='" . $revisionProps['id'] . "'";

            if ($previous_revisionProps != null) {
                $data_attrs .= " " . "data-previous-revision-id='" . $previous_revisionProps['id'] . "'";
            }

            return $data_attrs;
        }
    } // END CLASS
}