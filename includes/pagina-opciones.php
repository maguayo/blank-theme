<?php


/* ================================================== */
/* ================= DEFAULT OPTIONS ================ */
/* ================================================== */

add_action( 'init', 'empty_admin_init' );
function empty_admin_init() {
  $empty_settings = get_option( "empty_settings" );
  if ( empty( $empty_settings ) ) :
		$empty_settings = array(
			'empty_color' => '#336699',
			'empty_wsize' => '120px'
		);
		add_option("empty_settings", $empty_settings, '', 'yes' );
	endif;
}


/* ================================================== */
/* =============== ADD THE OPTION PAGE ============== */
/* ================================================== */

add_action( 'admin_menu', 'empty_options_init' );
function empty_options_init() {
	$empty_settings_page = add_options_page('empty', 'empty', '10', 'empty', 'empty_options');
	add_action("load-{$empty_settings_page}", 'empty_load_settings_page');
}


/* ================================================== */
/* ============= UPDATE THE OPTION PAGES ============ */
/* ================================================== */
function empty_load_settings_page() {
	if($_POST["empty-settings-submit"] == 'Y'):
		check_admin_referer("empty-settings-page");
		empty_save_theme_settings();
		$url_parameters = isset($_GET['tab'])? 'updated=true&tab=' . $_GET['tab'] : 'updated=true';
		wp_redirect(admin_url('options-general.php?page=empty&' . $url_parameters));
		exit;
	endif;
}


/* ================================================== */
/* ================ SAVE THE OPTIONS ================ */
/* ================================================== */

function empty_save_theme_settings() {
	global $pagenow;
	$empty_settings = get_option("empty_settings");
	
	if($pagenow == 'options-general.php' && $_GET['page'] == 'empty'):
		if ( isset ( $_GET['tab'] ) ) :
	        $tab = $_GET['tab']; 
	    else :
	        $tab = 'general'; 
	    switch ( $tab ){
	        case 'info' : 
	        	/* AQUI NO HEMOS PUESTO NINGUN INPUT ES UNA PAGINA INFORMATIVA*/
			break;
			case 'general':
				/* OPCION DE GENERAL */
				$empty_settings['empty_wsize'] = $_POST['empty_wsize'];
			break;
			case 'style' : 
				/* OPCION DE STYLE */
				$empty_settings['empty_color'] = $_POST['empty_color'];
			break;
			}
		endif;
	 endif;
	$updated = update_option( "empty_settings", $empty_settings );
}


/* ================================================== */
/* ====================== TABS ====================== */
/* ================================================== */

function empty_admin_tabs( $current = 'info' )  { 
    $tabs = array( 'info'=>'Info','general' => 'General', 'style' => 'Style' ); //AÑADE O ELIMINA TABS
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ) :
        $class = ($tab == $current) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=empty&tab=$tab'>$name</a>";
    endforeach;
    echo '</h2>';
}


/* ================================================== */
/* ================== LAS OPCIONES ================== */
/* ================================================== */

function empty_options() {
	global $pagenow;
	$empty_settings = get_option("empty_settings");
?>
	<div class="wrap">
		<h2>empty Settings</h2>
		<?php
			if(isset($_GET['tab'])) 
				empty_admin_tabs($_GET['tab']); 
			else 
				empty_admin_tabs('info'); /* TAB PREDETERMINADA */
		?>
		<div id="poststuff">
			<form method="post" action="<?php admin_url( 'options-general.php?page=empty' ); ?>">
			<?php
				wp_nonce_field("empty-settings-page"); 
				if($pagenow == 'options-general.php' && $_GET['page'] == 'empty'){
					if(isset($_GET['tab'])) 
						$tab = $_GET['tab']; 
					else 
						$tab = 'info'; 
					switch($tab){
						case 'info':
							// OPCIONES EN INFO, POR EJEMPLO:
							?>
							<div class="postbox">
								<h3><span><?php _e('hola!'); ?></span></h3>
								<div class="inside">
									<p>Este empty es la ostia... bla bla bla</p>
								</div>
							</div>
						<?php
						break;

						case 'general' : 
							// OPCIONES EN GENERAL, POR EJEMPLO: 
							?>
							<div class="postbox">
								<h3><span><?php _e('Modificar width'); ?></span></h3>
								<div class="inside">
									<input type="text" id="empty_wsize" name="empty_wsize" value="<?php echo $empty_settings['empty_wsize']; ?>">
								</div>
							</div>
							<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
							<input type="hidden" name="empty-settings-submit" value="Y" />
						<?php	
						break;

						case 'style' : 
							// OPCIONES EN STYLE, POR EJEMPLO: 
							?>
							<div class="postbox">
								<h3><span><?php _e('color'); ?></span></h3>
								<div class="inside">
									<input type="text" id="empty_color" name="empty_color" value="<?php echo $empty_settings['empty_color']; ?>">
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