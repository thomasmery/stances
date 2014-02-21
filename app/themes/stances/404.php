<?php get_template_part('templates/page', 'header'); ?>

<div id="divppdetail">
	<p class="alert alert-warning">
	  <?php _e('Sorry, but the page you were trying to view does not exist.', 'stances'); ?>
	</p>

	<p><?php _e('It looks like this was the result of either:', 'stances'); ?></p>
	<ul>
	  <li><?php _e('a mistyped address', 'stances'); ?></li>
	  <li><?php _e('an out-of-date link', 'stances'); ?></li>
	</ul>
</div>
