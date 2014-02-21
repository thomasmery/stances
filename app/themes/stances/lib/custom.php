<?php
/**
 * Custom functions
 */

// disable default attachments for Attachments plugin
// as we will be implementing our own
define( 'ATTACHMENTS_DEFAULT_INSTANCE', false );

/**
 * Attachments
 */
function _attachments( $attachments )
{
  $fields         = array(
    array(
      'name'      => 'title',                         // unique field name
      'type'      => 'text',                          // registered field type
      'label'     => __( 'Title', 'attachments' ),    // label to display
      'default'   => 'title',                         // default value upon selection
    ),
    array(
      'name'      => 'caption',                       // unique field name
      'type'      => 'textarea',                      // registered field type
      'label'     => __( 'Caption', 'attachments' ),  // label to display
      'default'   => 'caption',                       // default value upon selection
    ),
  );

  $args = array(

    // title of the meta box (string)
    'label'         => 'Project Medias',

    // all post types to utilize (string|array)
    'post_type'     => array( 'project' ),

    // meta box position (string) (normal, side or advanced)
    'position'      => 'normal',

    // meta box priority (string) (high, default, low, core)
    'priority'      => 'high',

    // allowed file type(s) (array) (image|video|text|audio|application)
    'filetype'      => null,  // no filetype limit

    // include a note within the meta box (string)
    //'note'          => 'Attach files here!',

    // by default new Attachments will be appended to the list
    // but you can have then prepend if you set this to false
    'append'        => true,

    // text for 'Attach' button in meta box (string)
    'button_text'   => __( 'Attach Files', 'attachments' ),

    // text for modal 'Attach' button (string)
    'modal_text'    => __( 'Attach', 'attachments' ),

    // which tab should be the default in the modal (string) (browse|upload)
    'router'        => 'browse',

    // fields array
    'fields'        => $fields,

  );

  $attachments->register( 'attachments', $args ); // unique instance name
}

add_action( 'attachments_register', '_attachments' );

/**
 * Add categories support for pages
 * Add Excerpt support for pages
 */
function stances_augment_pages() {
	
	register_taxonomy_for_object_type('category', 'page');
	add_post_type_support( 'page', 'excerpt' );

	
}
add_action('init','stances_augment_pages');



/**
 * MAIN QUERY operations
 *
 * manipulates main wp query at the pre_get_posts level 
 * is used to filter posts by category, post-type etc...
 */
function stances_main_query_operations( $query ) {

	if($query->is_main_query() && is_home()) {
		$query->set('posts_per_page', 1);
	}

	return $query;

}
add_action('pre_get_posts', 'stances_main_query_operations');


/**
 * PAGES MENU
 */

/**
 * Show a pages menu filtered by category
 */
function stances_category_pages_menu() {

	$output = '';
	$categories = array();
	$qo = get_queried_object();

	// make sure we have the term infos (category in this case)
	if(!isset($qo->term_id) && !isset($qo->slug)) {
		
		// if we don't we might be on a post that belongs to a category we want to show a pages menu for
		// i.e. prod-exec && post-prod
		$categories_to_show_pages_menu_for = array('production-executive', 'post-production');
		if(in_category($categories_to_show_pages_menu_for, $qo->ID) || 
			post_is_in_descendant_category($categories_to_show_pages_menu_for, $qo->ID)
		) {

			//then we fetch the categories for this post
			$_categories = wp_get_post_terms($qo->ID, 'category');

			// we actually want parent categories if it exists
			// because page can be assigned to a sub-category
			// but the code below that displays the pages works with root categories
			foreach ($_categories as $_category) {
				
				if($_category->parent) {

					array_push( $categories, get_term($_category->parent, 'category'));

				}
				else {

					array_push($categories, $_category);

				}
			}

		}

	}
	else {
		$categories = array($qo);
	}

	foreach($categories as $category) {

		$wp_query = new WP_Query();
		$args = array('post_type' => 'page', 'category_name' => $category->slug, 'posts_per_page' => -1);

		$results = $wp_query->query($args);
		
		$walker = new Stances_Walker_Pages_Tree();
		$defaults = array(
			'depth' => 0,
			'link_before' => '', 
			'link_after' => '', 
			'walker' => $walker,
		);

		$output .= walk_page_tree($results, 0, 0, $defaults);
		
		$output .= '<p><img src="' . get_template_directory_uri() . '/assets/img/separation.png" width="100%" height="10"></p>';
		$output .= '<div><span class="intropole">' . $category->description . '</span></div>';

	}
	



	return $output;

}

class Stances_Walker_Pages_Tree extends Walker_Page {
	
	
	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $depth Depth of page. Used for padding.
	 * @param int $current_page Page ID.
	 * @param array $args
	 */
	function start_el(&$output, $page, $depth, $args, $current_page) {
		
		if ( $depth )
			$indent = str_repeat("\t", $depth);
		else
			$indent = '';

		extract($args, EXTR_SKIP);
		$css_class = array('page_item', 'page-item-'.$page->ID);
		if ( !empty($current_page) ) {
			$_current_page = get_page( $current_page );
			_get_post_ancestors($_current_page);
			if ( isset($_current_page->ancestors) && in_array($page->ID, (array) $_current_page->ancestors) )
				$css_class[] = 'current_page_ancestor';
			if ( $page->ID == $current_page )
				$css_class[] = 'current_page_item';
			elseif ( $_current_page && $page->ID == $_current_page->post_parent )
				$css_class[] = 'current_page_parent';
		} elseif ( $page->ID == get_option('page_for_posts') ) {
			$css_class[] = 'current_page_parent';
		}
		
		$output .= '<div class="page-menu-item">';
		$output .= '<p>';
		$output .= '<a href="' . get_permalink($page->ID) . '" title="' . esc_attr(apply_filters( 'the_title', $page->post_title, $page->ID)) . '">';

		$output .= '<span class="image">' . get_the_post_thumbnail($page->ID, 'page-menu-thumb') . '</span>';
		$output .= '<span class="textbold">' . apply_filters( 'the_title', $page->post_title, $page->ID) . '</span>';
		$output .= 	'<br>';
		$output .= $page->post_excerpt;

		$output .= '</a>';
		$output .= '</p>';
		$output .= '</div>';

		if ( !empty($show_date) ) {
			if ( 'modified' == $show_date )
				$time = $page->post_modified;
			else
				$time = $page->post_date;

			$output .= " " . mysql2date($date_format, $time);
		}
	}
	
}



/**
 * STAFF MEMBERS
 */

function stances_staff_member_list() {

	$output = '<ul>';

	$wp_query = new WP_Query();
	$args = array('post_type' => 'staff-member', 'orderby' => 'menu_order', 'order' => 'ASC');

	$results = $wp_query->query($args);
		
	$walker = new Stances_Walker_Staff_Members();
	$defaults = array(
		'depth' => 0,
		'link_before' => '', 
		'link_after' => '', 
		'walker' => $walker,
	);

	$output .= walk_page_tree($results, 0, 0, $defaults);

	$output .= '</ul>';

	return $output;

}
class Stances_Walker_Staff_Members extends Walker_Page {
	
	
	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Page data object.
	 * @param int $depth Depth of page. Used for padding.
	 * @param int $current_page Page ID.
	 * @param array $args
	 */
	function start_el(&$output, $page, $depth, $args, $current_page) {
		
		if ( $depth )
			$indent = str_repeat("\t", $depth);
		else
			$indent = '';

		extract($args, EXTR_SKIP);

		$categories = wp_get_post_terms($page->ID, 'category');
		$categories_names = array();
		foreach($categories as $category) {
		
			array_push($categories_names, $category->name);

		}

		$output .= '<div class="categories">';
		$output .= join(' / ', $categories_names);
		$output .= '</div>';

		$output .= $indent . 
				'<div id="'. $page->post_name . '">
					<h4>';
		$output .= 	$link_before;
		
		$output .= '<a href="' . 
					get_permalink($page->ID) . 
					'" title="' . 
					esc_attr(apply_filters( 'the_title', $page->post_title, $page->ID)) . 
					'">';

		$output .= 	apply_filters( 'the_title', $page->post_title, $page->ID);

		$output .= '</a>';

		$output .= 	$link_after;

		$output .= '</h4>';
		
		$output .= '<div class="full-content">' . $page->post_content . '</div>';

		$output .= '</div>';
		
	}
	
}

/**
 * VIDEOS
 */

/**
 * allows to pass custom params to oembed
 */
function stances_oembed_fetch_url_filter($provider, $url, $args) {

	// do not loop through defaults
	unset($args['width']);
	unset($args['height']);
	unset($args['discover']);

	// loop through custom args
	foreach($args as $arg_k => $arg_v) {

		// add the to provider url
		$provider = add_query_arg( $arg_k, $arg_v, $provider );

	};

	return $provider;

}
add_action('oembed_fetch_url', 'stances_oembed_fetch_url_filter', 10, 3);

/**
 * returns an embed for video of given post
 * relies on the presence of a project-video meta attribute
 * 
 * @param  object	$post a wp post
 * @return string	the embed code for the video
 */
function get_stances_video_markup($post) {

	if($video_url = get_post_meta($post->ID, 'project-video', true)) {

		// extract params
		$parts = explode('?', $video_url);
		$video_url = $parts[0];
		$stances_oembed_params = array();
		if(isset($parts[1])) {
			parse_str($parts[1], $stances_oembed_params);	
		} 


		$defaults = array('width' => 800);
		$stances_oembed_params = array_merge($defaults, $stances_oembed_params);

		$embed = wp_oembed_get($video_url, $stances_oembed_params);

		return '<div class="video-iframe-wrapper">'.$embed.'</div>';

	}

	return '';

}

/**
 * UTILITIES
 */
if ( ! function_exists( 'post_is_in_descendant_category' ) ) {
	function post_is_in_descendant_category( $cats, $_post = null ) {
		foreach ( (array) $cats as $cat ) {
			// get_term_children() accepts integer ID only
			if (!is_int($cat)) $cat = get_category_by_slug($cat)->term_id;
			$descendants = get_term_children( (int) $cat, 'category' );
			if ( $descendants && in_category( $descendants, $_post ) )
				return true;
		}
		return false;
	}
}

function the_post_thumbnail_caption() {

  global $post;

  $thumb_id = get_post_thumbnail_id($post->id);

  $args = array(
	'post_type' => 'attachment',
	'post_status' => null,
	'post_parent' => $post->ID,
	'include'  => $thumb_id
	); 

   $thumbnail_image = get_posts($args);

   if ($thumbnail_image && isset($thumbnail_image[0])) {

     //show thumbnail title
     // echo $thumbnail_image[0]->post_title; 

     //Uncomment to show the thumbnail caption
     echo $thumbnail_image[0]->post_excerpt; 

     //Uncomment to show the thumbnail description
     //echo $thumbnail_image[0]->post_content; 

     //Uncomment to show the thumbnail alt field
     //$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
     //if(count($alt)) echo $alt;

  }
}
