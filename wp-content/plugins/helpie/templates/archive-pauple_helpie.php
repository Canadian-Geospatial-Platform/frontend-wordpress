<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_helpie_header();
?>

<div id="primary" class="helpie-primary content-area">
	<main id="main" class="site-main" role="main">
		<?php include HELPIE_PLUGIN_PATH . 'templates/views/main-page/main-page.php';?>
	</main><!-- .site-main -->
</div><!-- .content-area -->


<?php get_footer();?>
