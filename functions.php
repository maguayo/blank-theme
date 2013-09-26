<?php 
// Re-define meta box path and URL
define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/meta-box' ) );
define( 'RWMB_DIR', trailingslashit( STYLESHEETPATH . '/meta-box' ) );

// Include the meta box script
require_once RWMB_DIR . 'meta-box.php';

// Include the meta box definition (the file where you define meta boxes, see `demo/demo.php`)
include 'demo.php';
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
/* ====================== MENUS ==================== */
/* ================================================= */

// Menu functions with support for WordPress 3.0 menus
if(function_exists('wp_nav_menu')){
    add_theme_support('nav-menus');
    register_nav_menus(array(
        'primary' => esc_html__( 'Primary Navigation', 'hemav' ),
    ));
}

function default_menu_nav() {
    if(function_exists('wp_nav_menu'))
        wp_nav_menu( array( 'container_class' => 'navigation-menu',
            'container_id' => 'navigation-menu',
            'menu_id'    => 'main-top-menu',
            'menu_class' => 'sf-menu',
            'link_before'=> '<span>',
            'link_after' => '</span>',
            'theme_location' => 'primary',
            'fallback_cb' => 'default_menu_nav_fallback' )
        );
    else
        default_menu_nav_fallback();
 }

function default_menu_nav_fallback() {
    global $udesign_options;
    $menu_html = '<div id="navigation-menu" class="navigation-menu">';
    $menu_html .= '<ul id="main-top-menu" class="sf-menu">';
    $menu_html .= is_front_page() ? "<li class='current_page_item'>" : "<li>";
    $menu_html .= '<a href="'.get_bloginfo('url').'"><span>'.esc_html__('Home', 'hemav').'</span></a></li>';
    $menu_html .= wp_list_pages('depth=5&title_li=0&sort_column=menu_order&link_before=<span>&link_after=</span>&echo=0');
    $menu_html .= '</ul>';
    $menu_html .= '</div>';
    echo $menu_html;
}

/* ================================================= */
/* ================== QTRANSLATE =================== */
/* ================================================= */

// Enable qTranslate for WordPress SEO
/*function qtranslate_filter($text){
  return __($text);
}

add_filter('wpseo_title', 'qtranslate_filter', 10, 1);
add_filter('wpseo_metadesc', 'qtranslate_filter', 10, 1);
add_filter('wpseo_metakey', 'qtranslate_filter', 10, 1);
add_filter('wpseo_opengraph_title', 'qtranslate_filter', 10, 1);
*/

/* ================================================= */
/* ================= MIS FUNCIONES ================= */
/* ================================================= */


function cogerImagen($customField){
    $images = rwmb_meta($customField, 'type=image');
    foreach ($images as $image):
        $result = $image['full_url'];
    endforeach;

    return $result;
}

function cogerImagenArray($customField){
    $result = array("thumbnail" => '', "url" => '', 'alt' => '');
    $images = rwmb_meta($customField, 'type=image');
    foreach ($images as $image):
        $result['url'] = $image['full_url'];
        $result['alt'] = $image['alt'];
        $result['thumbnail'] = $image['url'];
    endforeach;

    return $result;
}


add_action('admin_head', 'customStylesAdmin');

function customStylesAdmin() {
  echo '<style>
    label[for="cf_media_servicios_texto"],
    #wp-cf_media_servicios_texto-wrap{
        display: none;
    }
  </style>';
}

function custom_admin_js() {
    $url = get_option('siteurl');
    $url = get_bloginfo('template_directory') . '/js/wp-admin.js';
    echo '<script type="text/javascript" src="'. $url . '"></script>';
}
add_action('admin_footer', 'custom_admin_js');

?>