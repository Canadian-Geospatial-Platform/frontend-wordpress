<?php

namespace Helpie\Includes\Utils\Builders;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Helpie\Includes\Utils\Builders\Template_Abstract_Factory')) {
    class Template_Abstract_Factory
    {

        private $template_name;
        private $sidebar_template_style;

        public function __construct()
        {

            $this->settings = new \Helpie\Includes\Settings\Getters\Settings();
        }

        public function render_main_area_start()
        {
            // Fix for Divi Theme Header not shrinking : Add id 'main-content' to one big module
            $id = 'main-content';

            echo "<div id='" . $id . "' class='helpie-primary-view " . $this->sidebar_template_style . "'><div id='helpiekb-main-wrapper' class='wrapper'>";
        }

        public function render_main_area_stop()
        { }

        public function render_content($content)
        {
            $html_content = '';
            $html_content .= "<div id='primary' class='content-area " . $this->sidebar_template_style . "'>";
            $html_content .= "<main id='main' class='site-main' role='main'>";
            $html_content .= "<div class='wrapper'>";
            echo $html_content;
            echo $content;

            if (is_single()) {
                $this->render_comments_section();
            }

            echo "<div class='lol clear'></div>";
            echo "</div>";
            echo "<div class='lol clear'></div>";
            echo "</main></div>";
        }

        public function render_comments_section()
        {
            $post_id = get_the_ID();            

            $is_unlocked = apply_filters('helpiekb/is_unlocked', 'article', $post_id);

            $show_comments = $this->settings->single_page->show_comments();
            $have_comments = (comments_open() || get_comments_number()); // If comments are open or we have at least one comment, load up the comment template.
            if ($is_unlocked && $show_comments && $have_comments) {
                comments_template('', true);
            }
        }

        public function render_sidebar($position, $sidebar_count = 'single')
        {
            $args = array(
                'position' => $position,
                'template' => $this->template_name,
                'count' => $sidebar_count,
            );

            $sidebar_controller = new \Helpie\Features\Components\Sidebar\Sidebar_Controller();
            $sidebar = $sidebar_controller->get_sidebar($args);

            echo $sidebar;
        }

        public function render($template_name, $content)
        {
            $this->template_name = $template_name;

            if ($template_name == 'single_template') {
                // $this->sidebar_template_style = $this->sp_options['helpie_sp_template'];

                $this->sidebar_template_style = $this->settings->single_page->get_template();
            } elseif ($template_name == 'category_template') {
                $this->sidebar_template_style = $this->settings->category_page->get_template();
            }

            $this->render_main_area_start();

            if ($this->sidebar_template_style == 'left-sidebar') {
                $this->render_sidebar('left');
                $this->render_content($content);
            } elseif ($this->sidebar_template_style == 'right-sidebar') {
                $this->render_content($content);
                $this->render_sidebar('right');
            } elseif ($this->sidebar_template_style == 'both-side-sidebars') {
                $this->render_sidebar('left', 'both');
                $this->render_content($content);
                $this->render_sidebar('right', 'both');
            } elseif ($this->sidebar_template_style == 'full-width') {
                $this->render_content($content);
            }
        }
    } // END CLASS
}