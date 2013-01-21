<!DOCTYPE html>
<!--[if IE 6]> <html id="ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]> <html id="ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html id="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!--> 
<html <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title();?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
