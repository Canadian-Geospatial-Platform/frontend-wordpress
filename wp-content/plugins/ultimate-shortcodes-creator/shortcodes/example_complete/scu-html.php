<!-- Available PHP variables: -->
<!-- $content:			content of the shortcode -->
<!-- $atts:				array of attributes of the shortcode -->
<!-- $resources_url:	url of the shortcode resources dir -->

<?php
global	$wp_version;
echo 'Wordpress version: '.$wp_version.'<br>';
echo 'Attributes: '.json_encode($atts).'<br>';
echo 'Content: '.json_encode($content).'<br>';
echo 'Resources URL: '.$resources_url.'<br>';
?>
<p id="scu-test"></p>
<img id="scu-img-test" src="<?php echo($resources_url).'image1.png'; ?>">
