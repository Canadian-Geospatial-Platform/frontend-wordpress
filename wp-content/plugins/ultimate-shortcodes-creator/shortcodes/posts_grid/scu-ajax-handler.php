<?php
/***************************************************************************
* Author:		
* Description:	
* Return:		json html
****************************************************************************/
	
if(!defined('ABSPATH')) {
	die('Please don\'t access this file directly.');
}

// Check if the call is from the right place
if ( ! wp_verify_nonce(  $_POST['security'], 'scu-ajax-nonce' ) ) {
	die ( 'Busted!' );
}
$atts = (isset($_REQUEST["atts"])) ? $_REQUEST["atts"] : null;
$category = (isset($_REQUEST["category"])) ? $_REQUEST["category"] : null;

$args = array(
	'numberposts'	=> $atts['max_posts'],
	'category'		=> $category,
	'offset'		=> 0
);
$posts = get_posts( $args );
if( ! empty( $posts ) ) {
	$output2 = '';
	foreach ( $posts as $key=>$p ) {
		$featured_img_url = get_the_post_thumbnail_url($p->ID, 'thumbnail');	// full, medium, thumbnail
		$output2 .= '<div class="grid-item ';
		$output2 .= $category;
		$output2 .= '">';
		$output2 .= '<a href="' . get_permalink( $p->ID ) . '">';
		$output2 .= '<img src="'.$featured_img_url.'" alt="sample" /></a>';
		$output2 .= '<h5 class="title2">'.$p->post_title.'</h5>';
		$output2 .= '<h6 class="author2">'.$p->post_author;
		$output2 .= ' - <span class="date2">'.date('d/m/Y',$p->post_date).'</span></h6>';
		$output2 .= '</div>';
	}
}
header( "Content-Type: application/json" );
echo json_encode($output2);
wp_die(); // this is required to terminate immediately and return a proper response

?>