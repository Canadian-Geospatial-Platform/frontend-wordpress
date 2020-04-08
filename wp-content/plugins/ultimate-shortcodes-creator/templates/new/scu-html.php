<!-- Available PHP variables: -->
<!-- $content:			content of the shortcode -->
<!-- $atts:				array of attributes of the shortcode -->
<!-- $resources_url:	url of the shortcode resources dir -->

<?php
global	$wp_version;
echo ('Wordpress version: '.$wp_version.'<br>');
echo ('Shortcode: ['.$atts["name"].'] successfully installed. ');
?>