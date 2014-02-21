<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
  <div class="gridContainer clearfix">

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'stances'); ?>
    </div>
  <![endif]-->

  <?php
    do_action('get_header');
    // Use Bootstrap's navbar if enabled in config.php
    if (current_theme_supports('bootstrap-top-navbar')) {
      get_template_part('templates/header-top-navbar');
    } else {
      get_template_part('templates/header');
    }
  ?>

  <?php include roots_template_path(); ?>

  <?php if (roots_display_sidebar()) : ?>
    <aside id="PPdetail2" class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
      <?php include roots_sidebar_path(); ?>
    </aside><!-- /.sidebar -->
  <?php endif; ?>

  <?php get_template_part('templates/footer'); ?>

  </div>
</body>
</html>
