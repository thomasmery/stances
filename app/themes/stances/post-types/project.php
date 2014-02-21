<?php

function project_init() {
	register_post_type( 'project', array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'supports'          => array( 'title', 'editor', 'thumbnail' ),
		'has_archive'       => true,
		'query_var'         => true,
		'rewrite'    => array('slug' => 'projets'),
		'taxonomies' => array('category', 'project-type'),
 		'labels'            => array(
			'name'                => __( 'Projects', 'stances' ),
			'singular_name'       => __( 'Project', 'stances' ),
			'all_items'           => __( 'Projects', 'stances' ),
			'new_item'            => __( 'New project', 'stances' ),
			'add_new'             => __( 'Add New', 'stances' ),
			'add_new_item'        => __( 'Add New project', 'stances' ),
			'edit_item'           => __( 'Edit project', 'stances' ),
			'view_item'           => __( 'View project', 'stances' ),
			'search_items'        => __( 'Search projects', 'stances' ),
			'not_found'           => __( 'No projects found', 'stances' ),
			'not_found_in_trash'  => __( 'No projects found in trash', 'stances' ),
			'parent_item_colon'   => __( 'Parent project', 'stances' ),
			'menu_name'           => __( 'Projects', 'stances' ),
		),
	) );

}
add_action( 'init', 'project_init' );

/*
	Add custom fields
	using https://github.com/humanmade/Custom-Meta-Boxes
 */

function stances_project_custom_fields( array $meta_boxes ) {

    $meta_boxes[] = array(
        'title' => __( 'Projects custom fields', 'stances' ),
        'pages' => 'project',
        'context'    => 'normal',
        'priority'   => 'high',
        'fields' => array( 
        	array(
			    'id'   => 'project-video', 
			    'name' => __('Project Video', 'stances'), 
			    'type' => 'url',
			    'cols' => 12
        	),
        	array(
			    'id'   => 'project-date', 
			    'name' => __('Project date', 'stances'), 
			    'type' => 'text_small',
			    'cols' => 2
        	),
        	array(
			    'id'   => 'project-duration', 
			    'name' => __('Project duration', 'stances'), 
			    'type' => 'text_small',
			    'cols' => 2
        	),
        	array(
			    'id'   => 'project-location', 
			    'name' => __('Project location', 'stances'), 
			    'type' => 'text',
			    'cols' => 8
        	),
        	array(
			    'id'   => 'project-production', 
			    'name' => __('Project production', 'stances'), 
			    'type' => 'text',
			    'cols' => 4	
        	),
        	array(
			    'id'   => 'project-direction', 
			    'name' => __('Project direction', 'stances'), 
			    'type' => 'text',
			    'cols' => 4
        	),
        	array(
			    'id'   => 'project-broadcast', 
			    'name' => __('Project broadcast', 'stances'), 
			    'type' => 'text',
			    'cols' => 4
        	),

		),
    );

    return $meta_boxes; 

}
add_filter( 'cmb_meta_boxes', 'stances_project_custom_fields' );

/**
 * Add custom rewrite rules to get projects by categories
 */
function stance_projects_custom_rewrite_rules() {
    add_rewrite_rule("^projets/categorie/([^/]+)/page/?([0-9]{1,})/?$",'index.php?post_type=project&category_name=$matches[1]&paged=$matches[2]','top');
    add_rewrite_rule("^projets/categorie/([^/]+)/?",'index.php?post_type=project&category_name=$matches[1]','top');
}
add_action('init','stance_projects_custom_rewrite_rules');

function project_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['project'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Project updated. <a target="_blank" href="%s">View project</a>', 'stances'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'stances'),
		3 => __('Custom field deleted.', 'stances'),
		4 => __('Project updated.', 'stances'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s', 'stances'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Project published. <a href="%s">View project</a>', 'stances'), esc_url( $permalink ) ),
		7 => __('Project saved.', 'stances'),
		8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>', 'stances'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>', 'stances'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>', 'stances'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'project_updated_messages' );
