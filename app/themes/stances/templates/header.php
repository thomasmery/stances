<div id="LayoutDivBandeau"><a href="<?php get_bloginfo('home_url'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/HOME-LogoStances.png"></a></div>

<?php
  if (has_nav_menu('primary_navigation')) :
    wp_nav_menu(array(
        'theme_location' => 'primary_navigation',
        'menu_id' => 'LayoutDivMenu'
      )
    );
  endif;
?>
