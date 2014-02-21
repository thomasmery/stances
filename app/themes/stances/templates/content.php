<article <?php post_class(); ?> <?php if(is_home()) echo 'id="DivAccueil"'; ?>>

	<?php if(has_post_thumbnail()): ?>
		<div class="legende"><?php the_post_thumbnail_caption(); ?></div>
		<p>
			<a href="/projets/categorie/production-executive"><?php the_post_thumbnail('large')?></a>
		</p>
		<p>&nbsp;</p>
	<? endif; ?>

	<div class="textcenter" id="DivAccueil-text">
		<p>
			<h2 class="titrecenter"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p><?php the_content(); ?></p>
		</p>
	</div>

</article>
