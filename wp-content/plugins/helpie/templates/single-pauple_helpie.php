<?php
if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly
/*
 */

get_helpie_header();
while (have_posts()) : the_post();

    $content = get_the_content();

    $primary_class = 'no-scroll-module';
    if (has_shortcode($content, 'ph_sp_menu')) {
        $primary_class = 'page-scroll-module';
    }
endwhile;

$single_view = new \Helpie\Templates\Views\Single_View\Single_View();
$single_view->render($content, $primary_class);

get_footer();