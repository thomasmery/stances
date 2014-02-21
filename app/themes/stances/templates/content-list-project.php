<article <?php post_class(); ?>>
  <p>
    <a href="<?php the_permalink(); ?>">
      <?php echo get_the_post_thumbnail($post->ID, 'project-list-thumb'); ?>
    </a>
  </p>
  <h2 class="texttitre"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <div class="fichetech"><?php get_template_part('templates/project-meta'); ?></div>
  <p><img src="<?php echo get_template_directory_uri(); ?>/assets/img/separation.png" width="530" height="10"> </p>
</article>
