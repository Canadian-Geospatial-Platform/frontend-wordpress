<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/*
 * Template Name: Search results page
 * The template for displaying pages
 *
 */

get_helpie_header();

// $custom_styles = new \Helpie\Features\Services\Custom_Styles();
// echo $custom_styles->get_style();

$view = new \Helpie\Templates\Views\Search\Search_View();
$view->render();
?>


<?php get_footer(); ?>