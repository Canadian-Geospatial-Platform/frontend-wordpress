<?php

namespace Helpie\Templates\Views\Single_View;

include_once HELPIE_PLUGIN_PATH . 'features/domain/models/tags-model.php';

if (!class_exists('\Helpie\Templates\Views\Single_View\Single_View')) {
    class Single_View
    {
        private $fields_builder;
        private $viewProps;

        public function __construct()
        {
            $this->fields_builder = new \Helpie\Includes\Utils\Builders\Fields_Builder();
            $this->viewmodel = new \Helpie\Templates\Views\Single_View\Single_Viewmodel();
            $this->editor = new \Helpie\Features\Components\Frontend_Editor\Editor_Controller();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->custom_styles = new \Helpie\Features\Services\Custom_Styles();
            $this->set_viewProps();
        }

        public function set_viewProps()
        {
            $post = get_post(get_the_ID());
            $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($post);

            $this->viewProps = array(
                'post_id' => $kb_article->get_the_ID(),
                'post_title' => $kb_article->get_title(),
                'post_content' => $kb_article->get_the_content(),
                'category_id' => $kb_article->get_category_id(),
                'tags' => $kb_article->get_tags_list(),
            );
        }

        protected function get_page_controls()
        {
            $html = '';

            if ($this->viewmodel->show_frontend_editor()) {
                // echo $this->editor_view->get_options_button('single-template');
                $html .= "<div class='helpie-row options-row'>";
                $html .= "<div class='wrapper'>";
                $html .= $this->editor->controls->get_pages_buttons('single');
                $html .= "</div>";
                $html .= "</div>";
            }

            return $html;
        }


        public function render($content, $primary_class)
        {

            echo $this->custom_styles->get_style();
            echo "<div class='helpie-single-page-module single-page " . $primary_class . "'>";
            $this->render_top_area();

            // echo $this->get_page_controls();

            $this->render_main_area();
            $this->viewmodel->update_pageviews();
            echo $this->get_closing_html();
        }

        public function render_top_area()
        {
            $ple_top_area = new \Helpie\Features\Components\Partials\Helpie_Top_Area();
            $ple_top_area->render('single_template');
        }

        public function get_article_tags()
        {
            $tags = wp_get_post_terms(get_the_ID(), 'helpie_tag');

            $html = "<div class='article-tags-container'>";
            // $html .= "<div class='tag-title'>Tags</div>";
            $numItems = count($tags);
            $i = 0;

            foreach ($tags as $tag) {
                $html .= " <span class='single-tag'>" . $tag->name . "</span> ";
                if (++$i !== $numItems) {
                    $html .= " , ";
                }
            }

            $html .= "</div>";

            return $html;
        }

        public function render_main_area()
        {

            // Start the loop.
            while (have_posts()) : the_post();

                $html_content = $this->get_html_content();

                include_once HELPIE_PLUGIN_PATH . '/includes/utils/builders/template-abstract-factory.php';
                $ple_helpie_abs_factory = new \Helpie\Includes\Utils\Builders\Template_Abstract_Factory();
                $ple_helpie_abs_factory->render('single_template', $html_content);

            // End of the loop.
            endwhile;
        }

        public function get_html_content()
        {
            $html_content = '';

            $post_status = get_post_status(get_the_ID());
            $is_pending = (isset($post_status) && $post_status == 'pending');

            if ($is_pending) {
                return "<p> This post is pending review</p> ";
            }

            if (!$is_pending) {
                return $this->get_main_content_section();
            }

            return $html_content;
        }

        public function get_tag_html()
        {
            /* Start of Tags feature */
            $tags_model = new \Helpie\Features\Domain\Models\Tags_Model();
            $permitted_added_tag = $tags_model->get_permitted_added_tag(get_the_ID());
            $permitted_updated_tag = $tags_model->get_permitted_updated_tag(get_the_ID());

            $tags = '';
            if (isset($permitted_added_tag)) {
                $tags .= "<span class='added_tag'>" . $permitted_added_tag . "</span>";
            }

            if (isset($permitted_updated_tag)) {
                $tags .= "<span class='updated_tag'>" . $permitted_updated_tag . "</span>";
            }

            return $tags;
        }

        public function get_last_updated_html()
        {
            $updated_by = new \Helpie\Features\Components\Partials\Updated_By();
            $html_content = $updated_by->get_view();

            return $html_content;
        }

        public function get_title_part()
        {
            $html_content = '';


            $title_class = ['article-title'];
            $post_title_class = apply_filters('helpie_kb_single_post_title', $title_class);

            $post_title = $this->viewProps['post_title'];
            $html_content .= "<div class='article-title-outer'>";
            $html_content .= "<div class='" . implode(' ', $post_title_class) . "'>";
            $html_content .= "<h1 data-post-id='" . get_the_ID() . "'>" . $post_title . '</h1>' . $this->get_tag_html();
            $html_content .= "</div>";
            $html_content .= "</div>";

            return $html_content;
        }

        public function get_content_part()
        {
            $content_class = ['article-content'];
            $post_content_class = apply_filters('helpie_kb_single_post_content', $content_class);

            $post_content = $this->viewmodel->get_post_content();

            $edit_content_button_html = "<small class='helpie-edit-button'><a class='helpie-edit-article-content'><i class='fa fa-pencil' aria-hidden='true'></i></a></small>";

            $html_content = '';
            $html_content .= "<div class='article-content-outer'>";
            $html_content .= "<div class='" . implode(' ', $post_content_class) . "'>";
            $html_content .= $post_content;
            $html_content .= "</div></div>";

            return $html_content;
        }

        public function get_main_content_section()
        {
            $html_content = '';
            $html_content .= $this->get_page_controls();
            $html_content .= $this->get_title_part();
            $html_content .= $this->get_content_part();

            $html_content .= "<div class='helpie-row'>";
            $html_content .= $this->get_article_tags();
            $html_content .= "</div>";



            $html_content .= $this->get_last_updated_html();

            if ($this->show_pageviews()) {
                $html_content .= $this->get_pageviews_html();
            }

            $helpie_voting_builder = new \Helpie\Features\Components\Voting\Voting_Controller();
            $html_content .= $helpie_voting_builder->get_view();

            return $html_content;
        }

        public function get_pageviews_html()
        {
            $ph_pageviews = get_post_meta(get_the_iD(), 'ph_pageviews', true);

            if (!isset($ph_pageviews) || $ph_pageviews == null) {
                $ph_pageviews = 0;
            }

            $html_content = '';
            $html_content .= "<span class='pauple-helpie-pageviews'>";
            $html_content .= "<span class='value'>" . $ph_pageviews . "</span>";

            $html_content .= " read";
            if (1 < $ph_pageviews) {
                $html_content .= "s";
            }

            $html_content .= "</span>";

            return $html_content;
        }

        public function show_pageviews()
        {

            return $this->settings->single_page->show_pageviews();
        }

        public function get_closing_html()
        {
            return "<div style='clear:both;'></div>"
                . "</div>"
                . "<div style='clear:both;'></div>"
                . "</div><!-- .primary-view -->"
                . "<div style='clear:both;'></div>"
                . "</div> <!-- .helpie-single-page-module -->";
        }
    } // END CLASS
}