<?php

/* ================================================== */
/* ========= CHANGE TEXT "Insert into Post" ========= */
/* ================================================== */

function panel_settings_setup() {
    global $pagenow;
    if('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow){
        add_filter( 'gettext', 'replace_thickbox_text' , 1, 2 );
    }
}

add_action('admin_init', 'panel_settings_setup');

function replace_thickbox_text($translated_text, $text){  
    if('Insert into Post' == $text){
        $referer = strpos( wp_get_referer(), 'wptuts-settings' );
        if($referer != '') return 'Use this Image';
    }
    return $translated_text;
}


function delete_image( $image_url ) {
    global $wpdb;
    
    // We need to get the image's meta ID..
    $query = "SELECT ID FROM wp_posts where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";  
    $results = $wpdb -> get_results($query);

    // And delete them (if more than one attachment is in the Library
    foreach ( $results as $row ) {
        wp_delete_attachment( $row -> ID );
    }   
}

/* ================================================== */
/* ========== JAVASCRIPT TO UPLOAD IMAGES  ========== */
/* ================================================== */

function panel_settings_enqueue_scripts(){
    wp_register_script( 'wptuts-upload', get_template_directory_uri() .'/includes/js/wptuts-upload.js', array('jquery','media-upload','thickbox') );  
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_script('media-upload');
	wp_enqueue_script('wptuts-upload');
}
add_action('admin_enqueue_scripts', 'panel_settings_enqueue_scripts');


/* ================================================== */
/* ================= DEFAULT OPTIONS ================ */
/* ================================================== */

add_action('init', 'empty_admin_init');
function empty_admin_init(){
  	$panel_settings = get_option("panel_settings");

  	if(empty($panel_settings)):
		$panel_settings = array(
			/*'empty_color' => '#336699',
			'empty_wsize' => '120px'*/
		);
		add_option("panel_settings", $panel_settings, '', 'yes' );
	endif;
}


/* ================================================== */
/* =============== ADD THE OPTION PAGE ============== */
/* ================================================== */

add_action('admin_menu', 'empty_options_init');
function empty_options_init(){
    $panel_settings_page = add_menu_page('Theme Options', 'Theme Options', 'activate_plugins', 'apariencia', 'empty_options', get_bloginfo('template_directory') . '/images/icons/config.png');
	add_action("load-{$panel_settings_page}", 'empty_load_settings_page');
}


/* ================================================== */
/* ============= UPDATE THE OPTION PAGES ============ */
/* ================================================== */
function empty_load_settings_page(){
	if($_POST["empty-settings-submit"] == 'Y'):
		check_admin_referer("empty-settings-page");
		empty_save_theme_settings();
		$url_parameters = isset($_GET['tab'])? 'updated=true&tab=' . $_GET['tab'] : 'updated=true';
		wp_redirect(admin_url('admin.php?page=apariencia&' . $url_parameters));
		exit;
	endif;	
}


/* ================================================== */
/* ================ SAVE THE OPTIONS ================ */
/* ================================================== */

function empty_save_theme_settings(){
	global $pagenow;
	$panel_settings = get_option("panel_settings");

	if($pagenow == 'admin.php' && $_GET['page'] == 'apariencia'):

		if(isset ( $_GET['tab']))
	        $tab = $_GET['tab']; 
	    else
	        $tab = 'general'; 

	    switch ( $tab ){
			case 'general':
				/* OPCION DE GENERAL */
				$panel_settings['panel_analytics'] = $_POST['panel_analytics'];
				$panel_settings['panel_emailcontacta'] = $_POST['panel_emailcontacta'];
				$panel_settings['panel_logo'] = $_POST['panel_logo'];
				$panel_settings['favicon'] = $_POST['favicon'];
				$panel_settings['panel_direccion'] = $_POST['panel_direccion'];
				$panel_settings['panel_telefono'] = $_POST['panel_telefono'];
				$panel_settings['panel_copy'] = $_POST['panel_copy'];
				break;
			case 'social':
				/* OPCION DE GENERAL */
				$panel_settings['panel_facebook'] = $_POST['panel_facebook'];
				$panel_settings['panel_twitter'] = $_POST['panel_twitter'];
				$panel_settings['panel_googleplus'] = $_POST['panel_googleplus'];
				$panel_settings['panel_pinterest'] = $_POST['panel_pinterest'];
				$panel_settings['panel_linkedin'] = $_POST['panel_linkedin'];
				$panel_settings['panel_youtube'] = $_POST['panel_youtube'];
				$panel_settings['panel_vimeo'] = $_POST['panel_vimeo'];
				break;
			case 'style' : 
				/* OPCION DE STYLE */
				$panel_settings['panel_bgcolor'] = $_POST['panel_bgcolor'];
				break;
		}

	endif;
	$updated = update_option( "panel_settings", $panel_settings );
}


/* ================================================== */
/* ====================== TABS ====================== */
/* ================================================== */

function empty_admin_tabs($current = 'general')  { 
    $tabs = array(
    	'general' => 'General', 
    	'social' => 'Social', 
    	'style' => 'Style'
    ); 
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ) :
        $class = ($tab == $current) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=apariencia&tab=$tab'>$name</a>";
    endforeach;
    echo '</h2>';
}


/* ================================================== */
/* ================== LAS OPCIONES ================== */
/* ================================================== */

function empty_options() {
	global $pagenow;
	$panel_settings = get_option("panel_settings");
?>

	<style type="text/css">
		#neoxid_panel input {
		    float: right;
		    height: 30px;
		    width: 300px;
		}

		#neoxid_panel .field {
		    line-height: 30px;
		    margin-bottom: 15px;
		    overflow: hidden;
		    width: 465px;
		}

		#upload_logo_preview,
		#upload_favicon_preview{
			width: 300px;
			float: right;
		}

		#upload_logo_preview img,
		#upload_favicon_preview img{
			max-width:100%; 
			display: block;
			margin: auto;
		}
	</style>

	<div class="wrap">
		<h2>Website Settings</h2>
		<?php
			if(isset($_GET['tab'])) 
				empty_admin_tabs($_GET['tab']); 
			else 
				empty_admin_tabs('general'); /* TAB PREDETERMINADA */
		?>
		<div id="poststuff">
			<form method="post" action="<?php admin_url('admin.php?page=apariencia'); ?>" enctype="multipart/form-data">
			<?php
				wp_nonce_field("empty-settings-page"); 
				if($pagenow == 'admin.php' && $_GET['page'] == 'apariencia'){
					if(isset($_GET['tab'])) 
						$tab = $_GET['tab']; 
					else 
						$tab = 'general'; 
					switch($tab){

						case 'general' : 
							// OPCIONES EN GENERAL, POR EJEMPLO: 
							?>
							<div id="neoxid_panel" class="postbox">
								<h3><span><?php _e('Opciones generales'); ?></span></h3>
								<div class="inside">

						            <!-- If we have any error by submiting the form, they will appear here -->
						            <?php settings_errors( 'wptuts-settings-errors' ); ?>
						            	
									<div class="field">
										<label>Logo: </label>
										<?php if ( '' != $panel_settings['panel_logo'] ): ?>
								            <input id="delete_logo_button" name="panel_delete_logo" type="submit" class="button" value="<?php _e( 'Delete Logo', 'wptuts' ); ?>" />
								        <?php endif; ?>
										<div id="upload_logo_preview">
									        <img src="<?php echo $panel_settings['panel_logo']; ?>" />
									    </div>
										<input type="text" id="logo_url" name="panel_logo" value="<?php echo $panel_settings['panel_logo']; ?>"  />
										<input id="upload_logo_button" type="button" class="button" value="Upload Logo" />
									</div>
									<div class="field">
										<label>Favicon: </label>
										<?php if ( '' != $panel_settings['favicon'] ): ?>
								            <input id="delete_favicon_button" name="panel_delete_logo" type="submit" class="button" value="<?php _e( 'Delete Favicon', 'wptuts' ); ?>" />
								        <?php endif; ?>
										<div id="upload_favicon_preview">
									        <img src="<?php echo $panel_settings['favicon']; ?>" />
									    </div>
										<input type="text" id="favicon_url" name="favicon" value="<?php echo $panel_settings['favicon']; ?>"  />
										<input id="upload_favicon_button" type="button" class="button" value="Upload Favicon" />
									</div>
									<div class="field">
										<label>Google Analytics (site ID): </label>
										<input type="text" id="neoxid_analytics" name="panel_analytics" value="<?php echo $panel_settings['panel_analytics']; ?>" placeholder="UA-XXXXX-X" />
									</div>
									<div class="field">
										<label>Email contacta: </label>
										<input type="email" id="neoxid_emailcontacta" name="panel_emailcontacta" value="<?php echo $panel_settings['panel_emailcontacta']; ?>" placeholder="name@domain.com" />
									</div>
									<div class="field">
										<label>Dirección footer: </label>
										<input type="text" id="neoxid_direccion" name="panel_direccion" value="<?php echo $panel_settings['panel_direccion']; ?>" placeholder="Dirección que aparece en el footer" />
									</div>
									<div class="field">
										<label>Teléfono: </label>
										<input type="text" id="neoxid_telefono" name="panel_telefono" value="<?php echo $panel_settings['panel_telefono']; ?>" placeholder="953258456" />
									</div>
									<div class="field">
										<label>Copyright: </label>
										<input type="text" id="panel_copy" name="panel_copy" value="<?php echo $panel_settings['panel_copy']; ?>" placeholder="© 2015 Company Name All rights reserved" />
									</div>
								</div>
							</div>
							<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
							<input type="hidden" name="empty-settings-submit" value="Y" />
						<?php	
						break;


						case 'social' : 
							// OPCIONES EN GENERAL, POR EJEMPLO: 
							?>
							<div id="neoxid_panel" class="postbox">
								<h3><span><?php _e('Perfiles sociales'); ?></span></h3>
								<div class="inside">
									<div class="field">
										<label>Facebook URL: </label>
										<input type="url" id="neoxid_facebook" name="panel_facebook" value="<?php echo $panel_settings['panel_facebook']; ?>" placeholder="http://facebook.com/page_name" />
									</div>
									<div class="field">
										<label>Twitter URL: </label>
										<input type="url" id="neoxid_twitter" name="panel_twitter" value="<?php echo $panel_settings['panel_twitter']; ?>" placeholder="http://twitter.com/username" />
									</div>
									<div class="field">
										<label>Google Plus URL: </label>
										<input type="url" id="neoxid_googleplus" name="panel_googleplus" value="<?php echo $panel_settings['panel_googleplus']; ?>" placeholder="http://plus.google.com/ID" />
									</div>
									<div class="field">
										<label>Pinterest URL: </label>
										<input type="url" id="neoxid_pinterest" name="panel_pinterest" value="<?php echo $panel_settings['panel_pinterest']; ?>" placeholder="http://pinterest.com/page_name" />
									</div>
									<div class="field">
										<label>Linkedin URL: </label>
										<input type="url" id="neoxid_linkedin" name="panel_linkedin" value="<?php echo $panel_settings['panel_linkedin']; ?>" placeholder="http://linkedin.com/page_name" />
									</div>
									<div class="field">
										<label>Youtube URL: </label>
										<input type="url" id="neoxid_youtube" name="panel_youtube" value="<?php echo $panel_settings['panel_youtube']; ?>" placeholder="http://youtube.com/page_name" />
									</div>
									<div class="field">
										<label>Vimeo URL: </label>
										<input type="url" id="neoxid_vimeo" name="panel_vimeo" value="<?php echo $panel_settings['panel_vimeo']; ?>" placeholder="http://vimeo.com/page_name" />
									</div>
								</div>
							</div>
							<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
							<input type="hidden" name="empty-settings-submit" value="Y" />
						<?php	
						break;


						case 'style' : 
							// OPCIONES EN STYLE, POR EJEMPLO: 
							?>
							<div id="neoxid_panel" class="postbox">
								<h3><span><?php _e('Estilos'); ?></span></h3>
								<div class="inside">
									<div class="field">
										<label>Color de fondo: </label>
										<input type="color" id="neoxid_bgcolor" name="panel_bgcolor" value="<?php echo $panel_settings['panel_bgcolor']; ?>" />
									</div>
								</div>
							</div>
							<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
							<input type="hidden" name="empty-settings-submit" value="Y" />

					</div> 		
						<?php 
						break;
					}
				}
				?>
			</form>
		</div>
	</div>
<?php
}


?>
