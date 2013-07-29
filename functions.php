<?php 

include('includes/postypes.php');
include('includes/theme-options.php');

add_theme_support('post-thumbnails');


/* ================================================= */
/* ============= DISABLE UPDATE MESSAGE ============ */
/* ================================================= */
 
function hideUpdateNag(){
    remove_action( 'admin_notices', 'update_nag', 3 );
}
add_action('admin_menu','hideUpdateNag');


/* ================================================= */
/* ================ CUSTOM LOGIN LOGO ============== */
/* ================================================= */

function customLoginLogo() {
    $image = 'logo.png';
    $output = '<style type="text/css">
        h1 a{
            background-image: url('.get_bloginfo('template_directory').'/img/'.$image.') !important;
            height: 100px !important;
        }
    </style>';
    echo($output);
}
add_action('login_head', 'customLoginLogo');


/* ================================================= */
/* ======= DISABLE ADMIN BAR AND REMOVE ITEMS ====== */
/* ================================================= */

add_filter('show_admin_bar', '__return_false');

function remove_menus(){
    global $menu;
    $restricted = array(__('Herramientas'),__('Enlaces'), __('Apariencia'), __('Usuarios'));
    end ($menu);
    while (prev($menu)){
        $value = explode(' ',$menu[key($menu)][0]);
        if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
    }
}
add_action('admin_menu', 'remove_menus');


?>