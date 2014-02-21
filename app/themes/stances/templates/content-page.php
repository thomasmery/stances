<?php while (have_posts()) : the_post(); ?>
	<div id="DivCompetenceTitre">
		<p>
			<?php echo get_the_post_thumbnail($post->ID, 'full', array('class' => "imageflottante5")); ?>
			<span class="texttitre2"><?php the_title(); ?></span>
		</p>
	</div>
	<div id="divcompetence">
		<?php the_content(); ?>
		<p><span class="fichetech3"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/separation.png" width="530" height="10"></p>
	</div>
<?php endwhile; ?>

