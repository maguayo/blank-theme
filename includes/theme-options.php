<?php


/* ================================================== */
/* ================= DEFAULT OPTIONS ================ */
/* ================================================== */

add_action( 'init', 'empty_admin_init' );
function empty_admin_init() {
  $panel_settings = get_option("panel_settings");
  if ( empty( $panel_settings ) ) :
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

add_action( 'admin_menu', 'empty_options_init' );
function empty_options_init() {
	$panel_settings_page = add_menu_page('apariencia', 'Apariencia', '10', 'apariencia', 'empty_options');
	add_action("load-{$panel_settings_page}", 'empty_load_settings_page');
}


/* ================================================== */
/* ============= UPDATE THE OPTION PAGES ============ */
/* ================================================== */
function empty_load_settings_page() {
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

function empty_save_theme_settings() {
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
				$panel_settings['neoxid_analytics'] = $_POST['neoxid_analytics'];
				$panel_settings['neoxid_emailcontacta'] = $_POST['neoxid_emailcontacta'];
				break;
			case 'social':
				/* OPCION DE GENERAL */
				$panel_settings['neoxid_facebook'] = $_POST['neoxid_facebook'];
				$panel_settings['neoxid_twitter'] = $_POST['neoxid_twitter'];
				$panel_settings['neoxid_googleplus'] = $_POST['neoxid_googleplus'];
				$panel_settings['neoxid_pinterest'] = $_POST['neoxid_pinterest'];
				$panel_settings['neoxid_linkedin'] = $_POST['neoxid_linkedin'];
				$panel_settings['neoxid_youtube'] = $_POST['neoxid_youtube'];
				$panel_settings['neoxid_vimeo'] = $_POST['neoxid_vimeo'];
				break;
			case 'style' : 
				/* OPCION DE STYLE */
				$panel_settings['neoxid_bgcolor'] = $_POST['neoxid_bgcolor'];
				break;
		}

	endif;
	$updated = update_option( "panel_settings", $panel_settings );
}


/* ================================================== */
/* ====================== TABS ====================== */
/* ================================================== */

function empty_admin_tabs($current = 'general')  { 
    $tabs = array('general' => 'General', 'social' => 'Social', 'style' => 'Style'); //AÑADE O ELIMINA TABS
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
			<form method="post" action="<?php admin_url( 'admin.php?page=apariencia' ); ?>">
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
									<div class="field">
										<label>Google Analytics (site ID): </label>
										<input type="text" id="neoxid_analytics" name="neoxid_analytics" value="<?php echo $panel_settings['neoxid_analytics']; ?>" placeholder="UA-XXXXX-X" />
									</div>
									<div class="field">
										<label>Email contacta: </label>
										<input type="email" id="neoxid_emailcontacta" name="neoxid_emailcontacta" value="<?php echo $panel_settings['neoxid_emailcontacta']; ?>" placeholder="name@domain.com" />
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
										<input type="url" id="neoxid_facebook" name="neoxid_facebook" value="<?php echo $panel_settings['neoxid_facebook']; ?>" placeholder="http://facebook.com/page_name" />
									</div>
									<div class="field">
										<label>Twitter URL: </label>
										<input type="url" id="neoxid_twitter" name="neoxid_twitter" value="<?php echo $panel_settings['neoxid_twitter']; ?>" placeholder="http://twitter.com/username" />
									</div>
									<div class="field">
										<label>Google Plus URL: </label>
										<input type="url" id="neoxid_googleplus" name="neoxid_googleplus" value="<?php echo $panel_settings['neoxid_googleplus']; ?>" placeholder="http://plus.google.com/ID" />
									</div>
									<div class="field">
										<label>Pinterest URL: </label>
										<input type="url" id="neoxid_pinterest" name="neoxid_pinterest" value="<?php echo $panel_settings['neoxid_pinterest']; ?>" placeholder="http://pinterest.com/page_name" />
									</div>
									<div class="field">
										<label>Linkedin URL: </label>
										<input type="url" id="neoxid_linkedin" name="neoxid_linkedin" value="<?php echo $panel_settings['neoxid_linkedin']; ?>" placeholder="http://linkedin.com/page_name" />
									</div>
									<div class="field">
										<label>Youtube URL: </label>
										<input type="url" id="neoxid_youtube" name="neoxid_youtube" value="<?php echo $panel_settings['neoxid_youtube']; ?>" placeholder="http://youtube.com/page_name" />
									</div>
									<div class="field">
										<label>Vimeo URL: </label>
										<input type="url" id="neoxid_vimeo" name="neoxid_vimeo" value="<?php echo $panel_settings['neoxid_vimeo']; ?>" placeholder="http://vimeo.com/page_name" />
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
										<input type="color" id="neoxid_bgcolor" name="neoxid_bgcolor" value="<?php echo $panel_settings['neoxid_bgcolor']; ?>" />
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