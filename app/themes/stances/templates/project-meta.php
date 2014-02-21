<?php 
	
	$project_types = wp_get_post_terms($post->ID, 'project-type');
	$project_types_names = array_map(function($term) { return $term->name; }, $project_types);
	$project_types_html = implode(', ', $project_types_names);

	$project_date = get_post_meta($post->ID, 'project-date', true);
	$project_duration = get_post_meta($post->ID, 'project-duration', true);
	$project_location = get_post_meta($post->ID, 'project-location', true);
	$project_production = get_post_meta($post->ID, 'project-production', true);
	$project_direction = get_post_meta($post->ID, 'project-direction', true);
	$project_broadcast = get_post_meta($post->ID, 'project-broadcast', true);

	$project_infos_html = <<<HTML

<ul>
	<li><span class="GENRE">$project_types_html</span> — $project_duration — $project_date</li>
	<li>Production : $project_production</li> 
	<li>Réalistation : $project_direction</li> 
	<li>Diffusion : $project_broadcast</li> 
</ul>

HTML;

echo $project_infos_html;

?>


	
