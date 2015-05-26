<!DOCTYPE html>
<!--[if IE 6]> <html id="ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]> <html id="ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html id="ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!--> 
<html <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo bloginfo("name");?> | <?php wp_title();?></title>
	<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/favicon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="keywords" content=""/>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/slicknav.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<header>	
		<div class="container">
			<nav id="menu-top">
				<?php $defaults = array(
					'menu'         => 'main-top-menu',
					'container_id' => 'menu',
					'menu_class'   => 'menu',
					'fallback_cb'  => 'wp_page_menu',
				); wp_nav_menu( $defaults ); ?>
			</nav>
		</div>
	</header>
