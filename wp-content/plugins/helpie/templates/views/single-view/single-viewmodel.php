<?php

namespace Helpie\Templates\Views\Single_View;

if (!class_exists('\Helpie\Templates\Views\Single_View\Single_Viewmodel')) {
    class Single_Viewmodel
    {
        private $fields_builder;

        public function __construct()
        {
            $this->fields_builder = new \Helpie\Includes\Utils\Builders\Fields_Builder();
            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
            $this->toc_controller = new \Helpie\Features\Components\Toc\Toc_Controller();
        }


        public function show_frontend_editor()
        {

            $dynamic_caps = new \Helpie\Features\Services\Dynamic_Caps\Dynamic_Caps();
            $show_frontend_editor = $this->settings->core->is_frontend_editing_enabled();
            $post_id = get_the_ID();

            $can_view = $dynamic_caps->get_final_article_has_cap($post_id, 'can_view');
            $can_edit = $dynamic_caps->get_final_article_has_cap($post_id, 'can_edit');
            $can_publish = $dynamic_caps->get_final_article_has_cap($post_id, 'can_publish');
            $can_approve = $dynamic_caps->get_final_article_has_cap($post_id, 'can_approve');

            $is_unlocked = apply_filters('helpiekb/is_unlocked', 'article', $post_id);

            if ($show_frontend_editor && $can_view && ($can_edit || $can_publish || $can_approve) && $is_unlocked) {
                return true;
            }

            return false;
        }

        public function get_post_content()
        {
            $helpie_sidebar_type = $this->settings->components->get_toc_type();
            $show_auto_toc = $this->settings->components->show_auto_toc();

            $inPageNavOption = ($helpie_sidebar_type == 'page-scroll-only');
            $sidebar_autoTOC = $show_auto_toc;

            $component_options = get_option('helpie-kb');
            $has_component_options = (isset($component_options) && !empty($component_options));

            if ($has_component_options && ($inPageNavOption || isset($sidebar_autoTOC))) {
                $has_auto_toc = (isset($sidebar_autoTOC) && ($sidebar_autoTOC));
                $has_inPageNav = $inPageNavOption;
            } else {
                $has_component_options = false;
                $has_auto_toc = false;
                $has_inPageNav = false;
            }

            $post_id = get_the_ID();
            $post = get_post($post_id);

            $kb_article = new \Helpie\Features\Domain\Models\Kb_Article($post);
            $content = $kb_article->get_the_content();

            // add_filter('the_content', array($this->toc_controller, 'get_backtotop'));

            if (($has_component_options && ($has_auto_toc || $has_inPageNav)) || has_shortcode($content, 'helpie_kb_toc')) {
                add_filter('the_content', array($this->toc_controller, 'get_content'));
            }

            $post_content = apply_filters('the_content', $content);            

            return $post_content;
        }

        public function update_pageviews()
        {
            $post_id = get_the_ID();
            $pauple_helpie_aph = new \Helpie\Features\Services\Pageviews_Counter();
            $pauple_helpie_aph->update_pageviews($post_id);
        }
    } // END CLASS
}