<?php

function project_category_init() {
	register_taxonomy( 'project-category', array( 'staff-member' ), array(
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
			'name'                       => __( 'Staff categories', 'stances' ),
			'singular_name'              => _x( 'Staff category', 'taxonomy general name', 'stances' ),
			'search_items'               => __( 'Search project categories', 'stances' ),
			'popular_items'              => __( 'Popular project categories', 'stances' ),
			'all_items'                  => __( 'All project categories', 'stances' ),
			'parent_item'                => __( 'Parent project category', 'stances' ),
			'parent_item_colon'          => __( 'Parent project category:', 'stances' ),
			'edit_item'                  => __( 'Edit project category', 'stances' ),
			'update_item'                => __( 'Update project category', 'stances' ),
			'add_new_item'               => __( 'New project category', 'stances' ),
			'new_item_name'              => __( 'New project category', 'stances' ),
			'separate_items_with_commas' => __( 'Staff categories separated by comma', 'stances' ),
			'add_or_remove_items'        => __( 'Add or remove project categories', 'stances' ),
			'choose_from_most_used'      => __( 'Choose from the most used project categories', 'stances' ),
			'menu_name'                  => __( 'Staff categories', 'stances' ),
		),
	) );

}
add_action( 'init', 'project_category_init' );
