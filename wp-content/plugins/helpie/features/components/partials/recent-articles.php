<div class='recent-articles'><h3>Recent Articles</h3>
  <ul>

  <?php
    $args = array('post_type' => 'pauple_helpie', 'order' => 'DESC', 'posts_per_page' => 5);
    $loop = new \WP_Query($args);

    while ($loop->have_posts()) : $loop->the_post();
      echo "<li class='faa-parent animated-hover'><i class='fa fa-file-text-o faa-float helpie-article-link' aria-hidden='true'></i><a href='".get_permalink()."'>".get_the_title().'</a></li>';
    endwhile;
  ?>

</ul>
</div> <!-- .recent-articles -->
