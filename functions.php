<?php // BEGIN 

/******************* PLUGIN > META BOX ***********************/
include('includes/postypes.php');
include('includes/pagina-opciones.php');

add_theme_support( 'post-thumbnails' );

//=================================================//
//============= DISABLE UPDATE MESSAGE ============//
//=================================================//
 
function hideUpdateNag(){
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action('admin_menu','hideUpdateNag');

//=================================================//
//================ CUSTOM LOGIN LOGO ==============//
//=================================================//

function my_custom_login_logo() {
    $image = 'logo.png';
    $output = '<style type="text/css">h1 a {background-image:url('.get_bloginfo('template_directory').'/img/'.$image.')!important;height:100px!important;}</style>';
    echo($output);
}
add_action('login_head', 'my_custom_login_logo');

//=================================================//
//=============== DISABLE ADMIN BAR ===============//
//=================================================//

add_filter( 'show_admin_bar', '__return_false' );

function remove_menus () {
global $menu;
    $restricted = array(__('Herramientas'),__('Enlaces'), __('Apariencia'), __('Usuarios'));
    end ($menu);
    while (prev($menu)){
        $value = explode(' ',$menu[key($menu)][0]);
        if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
    }
}
add_action('admin_menu', 'remove_menus');

//=================================================//
//============== CUSTOM FIELDS IMAGES =============//
//=================================================//

function custom_image($key){
    global $wpdb, $post;

    $meta = get_post_meta(get_the_ID(), $key, false);
    if (!is_array($meta)) $meta = (array) $meta;
    if (!empty($meta)) {
        $meta = implode(',', $meta);
        $images = $wpdb->get_col("
            SELECT ID FROM $wpdb->posts
            WHERE post_type = 'attachment'
            AND ID in ($meta)
            ORDER BY menu_order ASC
        ");
        foreach ($images as $att) {
            $src = wp_get_attachment_image_src($att, 'full');
            $src = $src[0];
            return $src;
        }
    }
}

// END 
