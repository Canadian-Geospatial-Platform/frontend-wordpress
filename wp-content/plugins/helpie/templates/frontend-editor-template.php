<?php
if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

/*
 * Template Name: Editor Page
 * The template for Helpie's Frontend Editor
 *
 */

get_helpie_header();
// echo '<meta name="viewport" content="width=device-width, initial-scale=1">';

$editor_controller = new \Helpie\Features\Components\Frontend_Editor\Editor_Controller();
echo $editor_controller->get_view();

get_footer();
