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



?>