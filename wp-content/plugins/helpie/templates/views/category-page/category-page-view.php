<?php

namespace Helpie\Templates\Views\Category_Page;

if (!class_exists('Helpie\Templates\Views\Category_Page\Category_Page_View')) {
    class Category_Page_View
    {

        public function __construct()
        {
            $this->model = new \Helpie\Templates\Views\Category_Page\Category_Page_Model();
        }
        public function get($terms)
        {

            $viewProps = $this->model->get_viewProps($terms);
            $this->viewProps = $viewProps;
            $this->collectionProps = $viewProps['collection'];
            $items = $viewProps['items'];
            $this->items = $items;
            $custom_styles = new \Helpie\Features\Services\Custom_Styles();
            echo $custom_styles->get_style();

            echo "<div class='helpie-single-page-module category-page'>";
            $this->get_top_area();
            echo $this->get_editor_controls();
            echo $this->get_body();
            echo $this->get_bottom();
        }

        public function get_top_area()
        {
            $ple_top_area = new \Helpie\Features\Components\Partials\Helpie_Top_Area();
            $ple_top_area->render('category_template');
        }

        public function get_editor_controls()
        {
            $editor = new \Helpie\Features\Components\Frontend_Editor\Editor_Controller();
            $html = '';

            if ($this->collectionProps['editor_control']) {
                $html .= "<div class='helpie-row options-row'>";
                $html .= "<div class='wrapper'>";
                $html .= $editor->controls->get_pages_buttons();
                $html .= "</div>";
                $html .= "</div>";
            }

            return $html;
        }

        public function get_body()
        {

            $this->render_body();

            $html = "</div><!-- .wrapper -->";
            $html .= "</div><!-- .helpie-main-content-area -->";
            $html .= "<div style='clear:both;'>";
            $html .= "</div>";
            echo $html;
        }

        public function get_bottom()
        {
            $html = "</div><div class='clear'></div></div></main><!-- .site-main -->
                    </div><!-- .content-area -->";

            return $html;
        }

        private function render_body()
        {
            $term = get_queried_object();
            $html_content = '';

            $this->pp_controller = new \Helpie\Features\Services\Password_Protect\Controller();
            $html_content .= $this->pp_controller->get_Modal();

            if ($this->have_posts()) {

                $html_content .= $this->get_content($term);

                $this->factory_render($html_content);
                echo "<div class='clear'></div>";
            } else if (!$this->collectionProps['is_accessible']) {

                $html_content .= "You DO NOT have access. Login to get access: <a style='text-decoration: underline;' href='" . wp_login_url() . "'>Login</a>";
                $this->factory_render($html_content);
            } else {

                ob_start();
                get_template_part('template-parts/content', 'none');
                $html_content .= ob_get_contents();
                ob_end_clean();

                $this->factory_render($html_content);
            }
        }

        private function have_posts($index = 0)
        {
            $item = $this->items[$index];
            if (!empty($item)) {
                return true;
            }
            return false;
        }
        private function factory_render($html_content)
        {
            include_once HELPIE_PLUGIN_PATH . '/includes/utils/builders/template-abstract-factory.php';
            $ple_helpie_abs_factory = new \Helpie\Includes\Utils\Builders\Template_Abstract_Factory();
            $ple_helpie_abs_factory->render('category_template', $html_content);
        }

        private function get_content($term)
        {
            $html_content = '';
            $html_content .= "<h1>" . __($term->name, 'pauple-helpie') . "</h1>";
            $html_content .= "<div class='helpie-main-section'>";

            // before category content action hook

            $html_content .= $this->get_action_content("helpie_kb_before_category_content");
            $html_content .= $this->get_category_html(0);
            $html_content .= "<div class='clear'></div>";
            $html_content .= $this->get_action_content("helpie_kb_after_category_content");
            $html_content .= '</div>';

            /* Modifiers */
            $html_content = $this->get_locked_message($html_content, $term); // use '=', not '.='

            return $html_content;
        }

        private function get_locked_message($html_content, $term)
        {
            // error_log("Term : " . print_r($term, true));
            $is_unlocked = apply_filters('helpiekb/is_unlocked', 'category', $term->term_id);

            if ($is_unlocked) {
                return $html_content;
            }

            // If locked, then replace old html_content with this
            $html_content = $this->pp_controller->get_access_restricted_message();
            $html_content .= $this->pp_controller->get_Modal();

            return $html_content;
        }

        private function get_category_html($index = 0)
        {

            $item = $this->items[$index];
            $html = '';

            if ($index != 0) {
                $html .= $this->get_category_title($item['title']);
            }

            $html .= $this->get_articles($item['articles']);
            $html .= $this->get_child_categories($item['child']);
            $html .= "<div class='clear'></div>";
            return $html;
        }

        // TO DO: Optimize looping
        // Move to model and Convert to hierrachy before sending to viewProps
        private function get_child_categories($child_term_ids)
        {

            if (empty($child_term_ids)) {
                return '';
            }

            $icon_html = '<i class="fa fa-book"></i>';

            $html = "<div class='helpiekb-container'>";
            $html .= "<h3 class='helpiekb-cat-page-subheader'>" . $icon_html . __('Child Topics', 'pauple-helpie') . "</h3>";
            $term = get_queried_object();

            $args = array(
                'sortby' => 'custom',
                'topics' => $child_term_ids,
                'parent' => $term->term_id,
                'num_of_cols' => 2,
                'num_of_articles' => 99,
                'type' => $this->collectionProps['child_category_template'],
            );

            $category_list = new \Helpie\Features\Components\Category_Listing\Category_Listing();
            $html .= $category_list->get_view($args);

            $html .= "</div>";

            return $html;
        }

        private function get_category_title($title)
        {
            $html = '';
            $html .= '<h2>' . __($title, 'pauple-helpie') . '</h2>';
            $html .= "<div class='helpie-child-articles-section'>";
            $html .= "</div>";

            return $html;
        }

        private function get_articles($articles)
        {
            $boxlist_viewProps = [
                'collection' => [
                    'article_list_style' => $this->collectionProps['article_list_style'],
                    'article_list_columns' => $this->collectionProps['article_list_columns'],
                ],
                'items' => $articles,
            ];
            $boxlist = new \Helpie\Includes\Views\Boxlist_View();
            $html = $boxlist->get_view($boxlist_viewProps);

            return $html;
        }

        private function get_action_content($action)
        {
            ob_start();
            $html = do_action($action);
            $html = ob_get_contents();
            $html .= "<div class='clear'></div>";
            ob_end_clean();

            return $html;
        }
    } // END CLASS
}
