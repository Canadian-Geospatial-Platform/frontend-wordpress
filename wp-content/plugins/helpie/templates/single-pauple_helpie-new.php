<?php get_helpie_header(); ?>

<?php while (have_posts()) : the_post(); ?>
<div class="helpie-single-page-module single-page no-scroll-module">
    <div id="main-content"
         class="helpie-primary-view left-sidebar">
        <div id="helpiekb-main-wrapper"
             class="wrapper">
            <div id="primary"
                 class="content-area left-sidebar">
                <main id="main"
                      class="site-main"
                      role="main">
                    <div class="wrapper">
                        <div class="article-title-outer">
                            <div class="article-title">
                                <!-- <h1 data-post-id="1282">Asas</h1> -->
                                <?php
                                    ?>
                                <?php the_title('<h1 class="page-title">', '</h1>') ?>
                                <?php
                                    ?>
                            </div>
                        </div>
                        <div class="article-content-outer">
                            <div class="article-content">
                                <?php the_content(); ?>
                                <?php
                                    // do_action('helpiekb_single_content_after');
                                    ?>
                            </div>
                        </div>

                        <div style="clear:both;"></div>
                        <div class="lol clear"></div>
                    </div>
                    <div class="lol clear"></div>
                </main>
            </div>
            <div style="clear:both;"></div>
        </div>
        <div style="clear:both;"></div>
    </div>
    <!-- .primary-view -->
    <div style="clear:both;"></div>
</div>
<?php endwhile; ?>


<?php get_footer(); ?>