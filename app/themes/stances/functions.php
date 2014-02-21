<?php
/**
 * Roots includes
 */
require_once locate_template('/lib/utils.php');           // Utility functions
require_once locate_template('/lib/init.php');            // Initial theme setup and constants
require_once locate_template('/lib/wrapper.php');         // Theme wrapper class
require_once locate_template('/lib/sidebar.php');         // Sidebar class
require_once locate_template('/lib/config.php');          // Configuration
require_once locate_template('/lib/activation.php');      // Theme activation
require_once locate_template('/lib/titles.php');          // Page titles
require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/nav.php');             // Custom nav modifications
require_once locate_template('/lib/gallery.php');         // Custom [gallery] modifications
require_once locate_template('/lib/comments.php');        // Custom comments modifications
require_once locate_template('/lib/relative-urls.php');   // Root relative URLs
require_once locate_template('/lib/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/scripts.php');         // Scripts and stylesheets

// Custom Meta Boxes framework
require_once locate_template('/lib/Custom-Meta-Boxes/custom-meta-boxes.php');

// add Project post type
require_once locate_template('/post-types/project.php');

// add Project type taxonomy
require_once locate_template('/taxonomies/project-type.php');

// add Staff Member post type
require_once locate_template('/post-types/staff-member.php');

require_once locate_template('/taxonomies/staff-category.php');

require_once locate_template('/lib/custom.php'); // Custom functions
