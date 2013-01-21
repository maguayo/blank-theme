<?php

//=================================================//
//=================== POST TYPES ==================//
//=================================================//
/*
register_post_type( 'plugins', array(
    'label' => __('Plugins'),
	'singular_label' => __('Plugins'),
	'public' => true,
	'show_ui' => true,
	'exclude_from_search' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'menu_position' => -1,
	'rewrite' => true,
	'supports' => array('title', 'excerpt', 'thumbnail')
));*/

//=================================================//
//==================== METABOXES ==================//
//=================================================//
/*
$prefix = 'cf_';
global $meta_boxes;
$meta_boxes = array();

$meta_boxes[] = array(
	'id' => 'banner', // ID del metabox
	'title' => 'Banner', // Titulo que aparecera en el panel de administracion
	'pages' => array('post'), // Post Type donde añadiremos el metabox
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name'		=> 'Banner (960x320)',
			'id'		=> $prefix . 'banner_img', // ID con el que se le llamará para coger el valor
			'desc'		=> '',
			'type'		=> 'image', // Tipo: image, text, wysiwyg, file, option...
		)
	)
);*/

/**
 * Register meta boxes
 */
/*
function cf_register_meta_boxes(){
	global $meta_boxes;

	if ( class_exists( 'RW_Meta_Box' ) ){
		foreach ( $meta_boxes as $meta_box ){
			new RW_Meta_Box( $meta_box );
		}
	}
}
add_action( 'admin_init', 'cf_register_meta_boxes' );
*/
?>
