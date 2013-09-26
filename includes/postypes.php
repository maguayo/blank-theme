<?php


/* ================================================= */
/* =================== POST TYPES ================== */
/* ================================================= */

register_post_type('inicio', array(
    'labels' => array(
	    'name' => 'Ofertas trabajo',
	    'singular_name' => 'Ofertas trabajo',
	    'add_new' => 'Añadir oferta',
	    'add_new_item' => 'Añadir nueva oferta',
	    'edit_item' => 'Editar oferta',
	    'new_item' => 'Nueva Oferta',
	    'all_items' => 'Todas las ofertas',
	    'view_item' => 'Ver oferta',
	    'search_items' => 'Buscar ofertas',
	    'not_found' =>  'No se encuentran ofertas',
	    'not_found_in_trash' => 'No se encuentran ofertas en la basura', 
	    'parent_item_colon' => '',
	    'menu_name' => 'Inicio'
	 ),
	'public' => true,
	'show_ui' => true,
	'exclude_from_search' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'menu_position' => -1,
	'menu_icon' => get_bloginfo('template_directory') . '/images/icons/home.png', // 16px16
	'rewrite' =>  true, // array('slug' => 'inicio'),
	'supports' => array('title', 'editor')
));


/* ================================================= */
/* ==================== METABOXES ================== */
/* ================================================= */

$prefix = 'cf_';
global $meta_boxes;
$meta_boxes = array();


$meta_boxes[] = array(
	'id' => 'media_servicios', // ID del metabox
	'title' => 'Foto, Carousel y Video', // Titulo que aparecera en el panel de administracion
	'pages' => array('inicio'), // Post Type donde añadiremos el metabox
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name'    => '¿Servicio o Sector?',
			'id'      => $prefix . "media_servicios_radio",
			'type'    => 'radio',
			'options' => array(
				'servicio' => 'Servicio',
				'sector' => 'Sector',
			),
		),
		array(
			'name'	=> 'Imagen de la página',
			'id'	=> $prefix . 'media_servicios_img',
			'desc'	=> '',
			'type'	=> 'image_advanced',
			'max_file_uploads' => 1,
		),
		array(
			'name'	=> 'Video 1',
			'id'	=> $prefix . 'media_servicios_video1',
			'type'	=> 'oembed', 
		),
		array(
			'name'	=> '¿Como?',
			'id'	=> $prefix . 'media_servicios_como',
			'type'	=> 'wysiwyg', 
		),
	)
);



/**
 * Register meta boxes
 */

function cf_register_meta_boxes(){
	global $meta_boxes;

	if(class_exists('RW_Meta_Box')){
		foreach($meta_boxes as $meta_box){
			new RW_Meta_Box($meta_box);
		}
	}
}
add_action('admin_init', 'cf_register_meta_boxes');

?>