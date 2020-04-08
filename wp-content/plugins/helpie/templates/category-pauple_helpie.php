<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_helpie_header();
$term = get_queried_object();

$category_view = new \Helpie\Templates\Views\Category_Page\Category_Page_View();
$category_view->get($term);
get_footer();
