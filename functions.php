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


function custom_excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if(count($excerpt)>=$limit){
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    }else{
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
    return $excerpt;
}

/* ================================================= */
/* ==================== TWITTER ==================== */
/* ================================================= */

function buildBaseString($baseURI, $method, $params) {
    $r = array();
    ksort($params);
    foreach($params as $key=>$value){
        $r[] = "$key=" . rawurlencode($value);
    }
    return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function buildAuthorizationHeader($oauth) {
    $r = 'Authorization: OAuth ';
    $values = array();
    foreach($oauth as $key=>$value)
        $values[] = "$key=\"" . rawurlencode($value) . "\"";
    $r .= implode(', ', $values);
    return $r;
}

function returnTweet(){
    $oauth_access_token         = "X";
    $oauth_access_token_secret  = "X";
    $consumer_key               = "X";
    $consumer_secret            = "X";
    $twitter_timeline           = "user_timeline";  //  mentions_timeline / user_timeline / home_timeline / retweets_of_me

    $request = array(
        'screen_name' => 'USERNAME',
        'count'       => '3'
    );

    $oauth = array(
        'oauth_consumer_key'     => $consumer_key,
        'oauth_nonce'            => time(),
        'oauth_signature_method' => 'HMAC-SHA1',
        'oauth_token'            => $oauth_access_token,
        'oauth_timestamp'        => time(),
        'oauth_version'          => '1.0'
    );

    $oauth = array_merge($oauth, $request);

    $base_info = buildBaseString("https://api.twitter.com/1.1/statuses/$twitter_timeline.json", 'GET', $oauth);
    $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
    $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
    $oauth['oauth_signature'] = $oauth_signature;

    $header = array(buildAuthorizationHeader($oauth), 'Expect:');
    $options = array( CURLOPT_HTTPHEADER => $header,
                      CURLOPT_HEADER => false,
                      CURLOPT_URL => "https://api.twitter.com/1.1/statuses/$twitter_timeline.json?". http_build_query($request),
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_SSL_VERIFYPEER => false);

    $feed = curl_init();
    curl_setopt_array($feed, $options);
    $json = curl_exec($feed);
    curl_close($feed);

    return json_decode($json, true);
}

function poner_links($text){
    $text = twitter_it($text);
    $text = link_it($text);
    return $text;
}

function link_it($text){
    $text = preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t>]*)/is", "$1$2<a href=\"$3\">$3</a>", $text);
    $text = preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r>]*)/is", "$1$2<a href=\"http://$3\" >$3</a>", $text);
    $text = preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "<a href=\"mailto:$2@$3\">$2@$3</a>", $text);
    return($text);
}

function twitter_it($text){
    $text = preg_replace("/@(\w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $text); 
    $text = preg_replace("/\#(\w+)/", '<a href="http://search.twitter.com/search?q=$1" target="_blank">#$1</a>',$text); 
    return $text;
}



?>
