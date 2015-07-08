<?php


/* ================================================= */
/* =================== POST TYPES ================== */
/* ================================================= */

register_post_type('inicio', array(
	$labels = array(
		'name'               => _x( 'Cases', 'post type general name' ),
		'singular_name'      => _x( 'Case', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'case' ),
		'add_new_item'       => __( 'Add New Case' ),
		'edit_item'          => __( 'Edit Case' ),
		'new_item'           => __( 'New Case' ),
		'all_items'          => __( 'All Cases' ),
		'view_item'          => __( 'View Case' ),
		'search_items'       => __( 'Search Cases' ),
		'not_found'          => __( 'No cases found' ),
		'not_found_in_trash' => __( 'No cases found in the Trash' ), 
		'parent_item_colon'  => '',
		'menu_name'          => 'Cases'
	),
	'labels' => $labels,
	'description'         => 'Business Cases & Teaching Material',
	'public'              => true,
	'show_ui' 	      => true,
	'menu_icon'           => 'dashicons-book',
	'menu_position'       => 5,
	'supports'            => array( 'title', 'editor', 'wpcom-markdown', 'revisions' ),
	'has_archive'         => false,
	'rewrite' 	      => true,
));



?>
