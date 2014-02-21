<div class="content">
	<?php while (have_posts()) : the_post(); ?>
		
		<?php echo the_content(); ?>
		
	<?php endwhile; ?>
</div>

