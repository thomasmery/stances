<?php

function project_type_init() {
	register_taxonomy( 'project-type', array( 'project' ), array(
		'hierarchical'      => true,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => true,
		'capabilities'      => array(
			'manage_terms'  => 'edit_posts',
			'edit_terms'    => 'edit_posts',
			'delete_terms'  => 'edit_posts',
			'assign_terms'  => 'edit_posts'
		),
		'labels'            => array(
			'name'                       => __( 'Project types', 'stances' ),
			'singular_name'              => _x( 'Project type', 'taxonomy general name', 'stances' ),
			'search_items'               => __( 'Search project types', 'stances' ),
			'popular_items'              => __( 'Popular project types', 'stances' ),
			'all_items'                  => __( 'All project types', 'stances' ),
			'parent_item'                => __( 'Parent project type', 'stances' ),
			'parent_item_colon'          => __( 'Parent project type:', 'stances' ),
			'edit_item'                  => __( 'Edit project type', 'stances' ),
			'update_item'                => __( 'Update project type', 'stances' ),
			'add_new_item'               => __( 'New project type', 'stances' ),
			'new_item_name'              => __( 'New project type', 'stances' ),
			'separate_items_with_commas' => __( 'Project types separated by comma', 'stances' ),
			'add_or_remove_items'        => __( 'Add or remove project types', 'stances' ),
			'choose_from_most_used'      => __( 'Choose from the most used project types', 'stances' ),
			'menu_name'                  => __( 'Project types', 'stances' ),
		),
	) );

}
add_action( 'init', 'project_type_init' );
