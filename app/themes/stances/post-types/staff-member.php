<?php

function staff_member_init() {
	register_post_type( 'staff-member', array(
		'hierarchical'      => true,
		'public'            => true,
		'show_in_nav_menus' => true,
		'show_ui'           => true,
		'supports'          => array( 'title', 'editor', 'page-attributes' ),
		'has_archive'       => true,
		'query_var'         => true,
		'rewrite'           => true,
		'labels'            => array(
			'name'                => __( 'Staff Members', 'stances' ),
			'singular_name'       => __( 'Staff Members', 'stances' ),
			'all_items'           => __( 'Staff Members', 'stances' ),
			'new_item'            => __( 'New Staff Member', 'stances' ),
			'add_new'             => __( 'Add New', 'stances' ),
			'add_new_item'        => __( 'Add New Staff Member', 'stances' ),
			'edit_item'           => __( 'Edit Staff Member', 'stances' ),
			'view_item'           => __( 'View Staff Member', 'stances' ),
			'search_items'        => __( 'Search Staff Members', 'stances' ),
			'not_found'           => __( 'No Staff Members found', 'stances' ),
			'not_found_in_trash'  => __( 'No Staff Members found in trash', 'stances' ),
			'parent_item_colon'   => __( 'Parent Staff Member', 'stances' ),
			'menu_name'           => __( 'Staff Members', 'stances' ),
		),
		'taxonomies' => array('staff-category')
	) );

}
add_action( 'init', 'staff_member_init' );

function staff_member_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['staff_member'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Staff Member updated. <a target="_blank" href="%s">View Staff Member</a>', 'stances'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'stances'),
		3 => __('Custom field deleted.', 'stances'),
		4 => __('Staff Member updated.', 'stances'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Staff Member restored to revision from %s', 'stances'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Staff Member published. <a href="%s">View Staff Member</a>', 'stances'), esc_url( $permalink ) ),
		7 => __('Staff Member saved.', 'stances'),
		8 => sprintf( __('Staff Member submitted. <a target="_blank" href="%s">Preview Staff Member</a>', 'stances'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Staff Member scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Staff Member</a>', 'stances'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Staff Member draft updated. <a target="_blank" href="%s">Preview Staff Member</a>', 'stances'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'staff_member_updated_messages' );
