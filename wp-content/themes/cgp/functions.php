<?php 

function cgp_enqueue_styles() {
    wp_enqueue_style('child-style', 
            get_stylesheet_directory_uri() . '/style.css', 
            array($parent_style), 
            wp_get_theme()->get('Version')
            );
}
add_action('wp_enqueue_scripts', 'cgp_enqueue_styles');
 ?>