<!-- Available PHP variables: -->
<!-- $content:			content of the shortcode -->
<!-- $atts:				array of attributes of the shortcode -->
<!-- $resources_url:	url of the shortcode resources dir -->

<?php
global	$wp_version;
//echo($atts["name"]);
echo ('Wordpress version: '.$wp_version.'<br>');
echo ('Shortcode: ['.$atts["name"].'] successfully installed.<br> ');

?>
<div class="scu_grid_header">
	<h4>Categories</h4>	
	<div class="scu_grid_header_menu">
		<?php
		$categories = explode(',',$atts["categories"]);
		$out =  '<a class="button" data-filter="*">All</a>';
		foreach($categories as $key=>$category ) {			
			$out .= '<a class="button" data-filter="'.$category.' ">'.get_cat_name($category).'</a>';
		}
		echo($out);
		?>
	</div>		
</div>
<div class="grid">
<?php

$args = array(
	'numberposts'	=> $atts["max_posts"],
	//'category'		=> $category,
	'offset'		=> 0
);
$posts = get_posts( $args );
if( ! empty( $posts ) ) {
	$output2 = '';
	foreach ( $posts as $key=>$p ) {
		$featured_img_url = get_the_post_thumbnail_url($p->ID, 'thumbnail');	// full, medium, thumbnail
		$post_url = get_permalink( $p->ID );
		$title = $p->post_title;
		//$author = the_author_meta( 'nickname' , $p->post_author );
		$author = get_userdata($p->post_author)->data->user_nicename;
		$date = date_format(date_create_from_format("Y-m-d H:i:s", $p->post_date), 'd/m/Y');
		$output2 .= '<article class="grid-item ';
		$output2 .= $category;
		$output2 .= '">';
		
		//$output2 .= '<a href="' . get_permalink( $p->ID ) . '">';
		$output2 .= '<img src="'.$featured_img_url.'" alt="sample" />';
		$output2 .= '<h5 class="title2">'.$title.'</h5>';
		$output2 .= '<h6 class="author2">'.$author;
		$output2 .= ' - <span class="date2">'.$date.'</span></h6>';
		$output2 .= '<a  href="'.$post_url.'">';
		$output2 .= '<div class="mask">';
		$output2 .= '<p class="info">Read More</p></div></a>';
		$output2 .= '</article>';
		
		//$output .= '<li><a href="' . get_permalink( $p->ID ) . '">'. $p->post_title . '</a></li>';
	}
	echo($output2);
}
?>
</div>