<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?> id="divppdetail">

    <?php $video = get_stances_video_markup($post); ?>
    
    <?php if($video): ?>
      <p><?php echo $video ?></p>
    <?php else: ?>
      <p><?php echo get_the_post_thumbnail($post->ID, 'full'); ?></p>
    <?php endif; ?>


    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <div class="fichetech"><?php get_template_part('templates/project-meta'); ?></div>
    </header>
    <p><img src="<?php echo get_template_directory_uri(); ?>/assets/img/separation.png" width="530" height="10"> </p>
    <div class="fichetech3">
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'stances'), 'after' => '</p></nav>')); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
