<?php

/*
Plugin Name: .Suppamenu Lite
Plugin URI: http://codecanyon.net/item/suppamenu-all-purpose-wordpress-mega-menus/7265033??ref=vamospace
Description: All-Purpose WordPress Mega Menus Plugin. Please read the <a href="http://vamospace.com/docs/suppa">Guide</a>
Version: 1.5.1
Author: Sabri Taieb
Author URI: http://vamospace.com
Copyright 2014  Sabri Taieb , Codezag http://vamospace.com
Support Forum : http://vamospace.com/support
*/


/** Files Required **/
require_once("core/class-all_fonts.php");
require_once('core/class-get_categories.php');
require_once('core/ctf_options.class.php');
require_once('core/ctf_setup.class.php');
require_once('core/array-fontAwesome.php');
require_once('standard/include/class-suppa_walkers.php');
require_once('standard/include/walker-frontend.php');

if( is_admin() ){
	require_once('core/class-resize_thumbnails.php');
	require_once('standard/include/class-customs_to_files.php');
	require_once('standard/include/walker-backend.php');
}

/** Defined **/
$upload_dir = wp_upload_dir();
$suppa_settings = array (

	// Plugin Settings
	'default_skin'		=> 'bastlow',
	'plugin_id'			=> 'CTF_suppa_menu', // Don't ever ever ever change it
	'version'			=> '1.5.1',
	'guide'				=> 'http://vamospace.com/docs/suppa/',
	'support_forum'		=> 'http://vamospace.com/support/',
	'image_resize'		=> true,  // false to disable the image resizing
	'textdomain' 		=> 'suppa_menu', // Localisation ( translate )
	'plugin_url'		=> plugins_url( '' , __FILE__ ) . '/' ,
	'plugin_dir'		=> plugin_dir_path( __FILE__ ),
	'uploads_url'		=> $upload_dir['baseurl'],
	'icon_url'			=> plugins_url( '' , __FILE__ ) . '/standard/img/icon.png',

	// Add Menu Page , Submenu Page Settins
	'menu_type'		=> 'menu_page',				// menu_page or submenu_page
	'page_title'	=> 'Suppamenu Lite Settings' ,	// page_title
	'menu_title'	=> 'Suppamenu Lite' ,			// menu_title
	'capability'	=> 'manage_options'	,		// capability

	// Framework Settings
	'framework_version'	=> '3.2',
);


/** [PLUGIN_NAME] CLASS **/
class codetemp_suppa_menu extends ctf_setup {

	/** Variables **/
	public $project_settings;
	static $plugin_activate;

	public function __construct( $project_settings = array() ){

		$this->project_settings = $project_settings;
		self::$plugin_activate = $project_settings;

		/** This must be first , generate plugin_id **/
		parent::__construct();

		/** -------------------------------------------------------------------------------- **/

		/** Start Mega Menu walkers **/
		$suppaWalkers = new suppa_walkers();
		$suppaWalkers->init( $this->project_settings , $this->groups_db_offline );

		/** Add Support For WP 3+ Menus **/
		if( @$this->groups_db_offline['settings-theme_implement'] == 'on'
			|| @$this->groups_db_offline['settings-theme_implement_count'] > 0
		){

			if( @$this->groups_db_offline['settings-theme_implement'] == 'on' ){
				register_nav_menus( array(
					'suppa_menu_location' => 'Suppamenu'
				));
			}

			$count = (int)@$this->groups_db_offline['settings-theme_implement_count'];
			if( $count > 0 ){
				for( $i=1; $i <= $count ; $i++ ){
					register_nav_menus( array(
						'suppa_menu_location_'.$i => 'Suppamenu ('.$i.')'
					));
				}
			}

		}

		/** -------------------------------------------------------------------------------- **/

		/** Thumbnail Resize with Timthumb-Alternative **/
		if( is_admin() && $thumbs = get_option('suppa_thumbs_sizes') ) {
			foreach ( $thumbs as $type => $siz ){
				$resi = new ctf_resize_thumbnails( $siz['recent'][0], $siz['recent'][1] );
				$resi->wp_actions();
			}
		}

		/** -------------------------------------------------------------------------------- **/

		/** Admin : Load CSS & JS **/
		add_action( 'admin_enqueue_scripts' , array( $this , 'backend_css_js' ) );

		/** -------------------------------------------------------------------------------- **/

		/** Front-End : Load CSS & JS **/
		add_action( 'wp_head' , array( $this , 'frontend_head_style' ) , 1 );

		/** Front-End : Load CSS & JS **/
		add_action( 'wp_footer' , array( $this , 'frontend_footer_scripts' ) , 10 );

		/** -------------------------------------------------------------------------------- **/
		if( is_admin() ){
			$save_customs = new suppa_customs2files( $this->project_settings, $this->groups_db_offline );
		}

		/** Load Skin Options From DB **/
		add_action('wp_ajax_suppa_load_skin_options', array( $this, 'load_skin_options') );
	}


	/**
	 * Load Skin options from db
	**/
	function load_skin_options(){
		$skin_name = $_POST['skin_name'];
		if( $skin_ops = get_option('suppamenu_skin_'.$skin_name) ){
			header('Content-Type: application/json');
			echo json_encode( $skin_ops );
		}
		die('');
	}


	/**
	 * Localisation ( WP Translate )
	**/
	public function translation_action(){
		load_plugin_textdomain( $this->project_settings['textdomain'] , false, basename( dirname( __FILE__ ) ) . '/languages' );
	}


	/**
	 * Build & Display Settings Page .
	 * ( this function change with every new plugin or theme )
	**/
	public function display_admin_page(){

		// Header
		$header_desc 	= 'Suppamenu ' . $this->project_settings['version'];
		$html_id 		= 'suppa_menu';
		echo $this->get_html_header( $header_desc , $html_id );

		// Nav & Pages
		echo '<div class="codetemp_nav_pages_container">';

		// NAV (Main)
		echo $this->get_html_nav( array(
			'<span class="icon ct-wrench"></span>' . __( 'Skin Settings' , 'suppa_menu' ) => array(
				__( 'Layout &amp; Logo', 'suppa_menu' ),
				__( 'Responsive', 'suppa_menu' ),
				__( 'Search Form', 'suppa_menu' ),
				__( 'Posts Settings', 'suppa_menu' ),
				__( 'jQuery', 'suppa_menu' ),
				__( 'Suppport WP Menus', 'suppa_menu' ),

			),
			__( '<span class="icon ct-magic"></span>Menu Style' , 'suppa_menu' )	=> array(
				__( 'Logo', 'suppa_menu' ),
				__( 'Top Level Links', 'suppa_menu' ),
				__( 'Current Links', 'suppa_menu' ),
				__( 'Submenu General', 'suppa_menu' ),
				__( '[Latest Posts]', 'suppa_menu' ),
				__( '[DropDown]', 'suppa_menu' ),
				__( 'Search Form', 'suppa_menu' ),
			),
			__( '<span class="icon ct-magic"></span>Menu Icons Style' , 'suppa_menu' )	=> array(
				__( 'Top Level Icons', 'suppa_menu' ),
				__( '[Dropdown] Icons', 'suppa_menu' ),
				__( 'Social Media', 'suppa_menu' ),
			),
			__( '<span class="icon ct-magic"></span>Responsive Style' , 'suppa_menu' )	=> array(),
			__( '<span class="icon ct-magic"></span>Responsive Icons Style' , 'suppa_menu' )	=> array(),
			__( '<span class="icon ct-magic"></span>Custom CSS' , 'suppa_menu' )	=> array(),
		));

		// Pages
		?>
				<!-- Pages Container -->
				<div class="codetemp_pages_container fl">

					<!-- Menu Settings -->
					<div class="codetemp_page" id="codetemp_page_1">
						<?php require_once('standard/include/settings-general.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_1_1">
						<?php require_once('standard/include/settings-logo.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_1_2">
						<?php require_once('standard/include/settings-rwd.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_1_3">
						<?php require_once('standard/include/settings-search_form.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_1_4">
						<?php require_once('standard/include/settings-posts.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_1_5">
						<?php require_once('standard/include/settings-jquery.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_1_6">
						<?php require_once('standard/include/settings-theme_implementation.php') ?>
					</div>

					<!-- Menu Style -->
					<div class="codetemp_page" id="codetemp_page_2">
						<?php require_once('standard/include/style-general.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_2_1">
						<?php require_once('standard/include/style-logo.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_2_2">
						<?php require_once('standard/include/style-top_level.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_2_3">
						<?php require_once('standard/include/style-current_top_link.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_2_4">
						<?php require_once('standard/include/style-submenu_general.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_2_5">
						<?php require_once('standard/include/style-submenu_posts.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_2_6">
						<?php require_once('standard/include/style-dropdown.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_2_7">
						<?php require_once('standard/include/style-search_form.php') ?>
					</div>

					<!-- Menu Icons -->
					<div class="codetemp_page" id="codetemp_page_3_1">
						<?php require_once('standard/include/style-top_level_icons.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_3_2">
						<?php require_once('standard/include/style-dropdown_icons.php') ?>
					</div>
					<div class="codetemp_page" id="codetemp_page_3_3">
						<?php require_once('standard/include/style-social.php') ?>
					</div>

					<!-- Responsive Style -->
					<div class="codetemp_page" id="codetemp_page_4">
						<?php require_once('standard/include/style-rwd.php') ?>
					</div>

					<!-- Responsive Icons -->
					<div class="codetemp_page" id="codetemp_page_5">
						<?php require_once('standard/include/style-rwd_icons.php') ?>
					</div>

					<!-- Custom CSS -->
					<div class="codetemp_page" id="codetemp_page_6">
						<?php require_once('standard/include/style-custom.php') ?>
					</div>


				</div><!--codetemp_pages_container-->
				<div class="clearfix"></div>

			</div><!--codetemp_nav_pages_container-->

		<?php
		// Footer
		echo $this->get_html_footer();
	}



	/**
	 *	Load Admin : CSS & JS
	 */
	public function backend_css_js($hook){
		if( 'toplevel_page_CTF_suppa_menu' == $hook )
		{
			wp_enqueue_style('suppa_admin_menus_style', $this->project_settings['plugin_url'] . '/standard/css/suppa_admin_framework.css' );
			wp_enqueue_script('suppa_admin_load_skin', $this->project_settings['plugin_url'] . '/standard/js/load_skin.js' );
		}

		if( 'nav-menus.php' == $hook )
		{
			wp_enqueue_style('suppa_admin_menus_style', $this->project_settings['plugin_url'] . '/standard/css/suppa_admin_menus.css' );
			wp_enqueue_style('suppa_admin_menus_script', $this->project_settings['plugin_url'] . '/standard/js/suppa_admin.js' , array( 'jquery' ) );
		}
	}


	/**
	 *	Front-End : Head CSS
	 */
	public function frontend_head_style(){

		// Cache version
		$cache_version = 250;
		if( get_option('suppa_cache_version') ){
			$cache_version = get_option('suppa_cache_version');
		}

		/** Used Google Fonts **/
		ctf_fonts::load_frontend_google_fonts();

		/** Main Style **/
		wp_enqueue_style( 'suppamenu_style',
								$this->project_settings['plugin_url'].'standard/css/suppa_frontend_style.css',
								false,
								$cache_version
		);

		/** Font Awesome **/
		wp_enqueue_style( 'suppa_frontend_fontAwesome',
								$this->project_settings['plugin_url'].'standard/css/fontAwesome/style-min.css',
								array('suppamenu_style'),
								$cache_version
		);
		/** Hover.css Effects **/
		wp_enqueue_style( 'suppa_frontend_hoverCSS',
								$this->project_settings['plugin_url'].'standard/css/hover-master/hover-min.css',
								array('suppamenu_style'),
								$cache_version
		);

		/** Folders URL **/
		$upload_dir 		= wp_upload_dir();
		$css_folder_url	= $upload_dir['baseurl'].'/suppamenu2/css/';

		// SSL Support
		if( is_ssl() ){
			$css_folder_url = str_replace('http://', 'https://', $css_folder_url );
		}

		if( get_option('suppa_locations_skins') )
		{
			$saved_locations 	= get_option('suppa_locations_skins');
			foreach ( $saved_locations as $loca => $skin )
			{
				wp_enqueue_style( 'suppamenu_custom_style_'.$loca,
										$css_folder_url.$loca.'.css',
										array('suppamenu_style'),
										$cache_version
				);
			}
		}

		/** Style for print **/
		//wp_enqueue_style( 'suppa_frontend_print' , $this->project_settings['plugin_url'] . 'standard/css/suppamenu_style_print.css' , false , $this->project_settings['version'] , 'print' );
	}


	/**
	 *
	 *	Front-End : Footer Scripts
	 *
	 */
	public function frontend_footer_scripts()
	{
		/** Folders URL **/
		$upload_dir 	= wp_upload_dir();
		$js_folder_url	= $upload_dir['baseurl'].'/suppamenu2/js/';

		// SSL Support
		if( is_ssl() ){
			$js_folder_url = str_replace('http://', 'https://', $js_folder_url );
		}

		// Cache version
		$cache_version = 250;
		if( get_option('suppa_cache_version') ){
			$cache_version = get_option('suppa_cache_version');
		}

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-effects-core');

		wp_enqueue_script('suppamenu_frontend_script',
								$this->project_settings['plugin_url'].'standard/js/suppa_frontend.min.js',
								false, // libraries are already loaded
								$cache_version, // Cache version
								true // Load script in footer
		);

		$saved_locations 	= get_option('suppa_locations_skins');
		if( is_array( $saved_locations ) ){
			foreach ( $saved_locations as $loca => $skin ){
				wp_enqueue_script('suppamenu_js_settings_file_'.$loca,
										$js_folder_url . $loca . '.js' ,
										array('suppamenu_frontend_script') ,
										$cache_version ,
										true
				);
			}
		}

	}

	static function plugin_install(){

		ob_start();

		$upload_dir = wp_upload_dir();
		if( ! is_writable($upload_dir['basedir']) )
			die( __('Uploads Folder Must Be Writable','suppa_menu') );

		// this used to create a cache version
		// to prevent cache browser issue
		if( ! get_option('suppa_cache_version') ){
			update_option('suppa_cache_version',250);
		}

		// if this the first install
		if( ! file_exists( $upload_dir['basedir']. '/suppamenu2' ) ){

			// Get All Skins Names
			$skins_folder 	= self::$plugin_activate['plugin_dir'] . 'standard/css/skins/';
			$scandir 		= @scandir($skins_folder );
			$all_skins 		= array();
			foreach ( $scandir as $key => $value){
				if( $value != "." && $value != ".." ){
					$value = str_replace('.json', '', $value );
					$all_skins[$value] = $value;
				}
			}
			update_option('suppa_all_skins',$all_skins);

			// Create Folders inside uploads folder
			@wp_mkdir_p( $upload_dir['basedir']. '/suppamenu2' );
			@wp_mkdir_p( $upload_dir['basedir']. '/suppamenu2/skins' );
			@wp_mkdir_p( $upload_dir['basedir']. '/suppamenu2/css' );
			@wp_mkdir_p( $upload_dir['basedir']. '/suppamenu2/js' );

			//skins to copy and save to Dabatase
			foreach ( $all_skins as $key => $value ){

				$curr_skin = $skins_folder . $value . '.json';

				$handle    = @fopen( $curr_skin, 'r' );
				$json_data = @fread( $handle, filesize($curr_skin) );
				$skin_data = json_decode( $json_data, true );
				@fclose($handle);

				// copy file to uploads/suppamenu2 folder
				@copy( $skins_folder . $value . '.json' , $upload_dir['basedir']. '/suppamenu2/skins/' . $value . '.json' );

				// save option to db
        		update_option( 'suppamenu_skin_'.$value, $skin_data );

				// save options of the default theme
				if( self::$plugin_activate['default_skin'] == $value){
					update_option( 'CTF_suppa_menu_settings', $skin_data );
				}
			}

			// create an index.html file inside "suppamenu2" folder
			$handle 	= 	@fopen( $upload_dir['basedir'] . '/suppamenu2/index.html' , 'w');
							@fwrite($handle, '<?php /** Silence is gold **/ ?>' );
							@fclose($handle);

		}

		// Else the plugin has been installed on this site
		else{

			// Get All Skins Names from uploads/suppamenu2/skins
			$skins_folder 	= $upload_dir['basedir']. '/suppamenu2/skins/';
			$all_skins 		= get_option('suppa_all_skins');

			//skins to copy and save to Dabatase
			foreach ( $all_skins as $skin_name => $value ){

				$curr_skin = $skins_folder . $skin_name . '.json';

				$handle    = @fopen($curr_skin, 'r');
				$json_data = @fread($handle,filesize($curr_skin));
				$skin_data = json_decode($json_data, true);
				@fclose($handle);

				// save option to db
        		update_option( 'suppamenu_skin_'.$skin_name, $skin_data );

        		// Create CSS/JS Files
				$suppaWalkers = new suppa_walkers();
				$suppaWalkers->after_plugin_install_create_css_js_files();
			}
		}

		// Google Fonts
		delete_option('suppa_googleFonts_used');
		ctf_fonts::get_googleFonts_list();

      	// Save Thumbnail sizes
		do_action( 'CTF_suppa_menu_save_thumb_sizes' );

		ob_end_clean();
    }


   /* Implementation Code */
   function implement_menu( $menu_number ){
   	if( $menu_number == '' ){
	   	wp_nav_menu( array( 'theme_location' => 'suppa_menu_location' ) );
   	}
   	else{
   		wp_nav_menu( array( 'theme_location' => 'suppa_menu_location_' . $menu_number ) );
   	}
   }


}// end class


/** Show Time **/
$suppa_menu_start = new codetemp_suppa_menu ( $suppa_settings );

/** Plugin Activation Hook **/
register_activation_hook( __FILE__, array( 'codetemp_suppa_menu', 'plugin_install' ) );


/** Theme Implementation for WP 3+ Menus **/
if( !function_exists('suppa_implement') ){

	function suppa_implement( $menu_number = '' ){

	   	if( $menu_number == '' ){

		   	wp_nav_menu( array( 'theme_location' => 'suppa_menu_location' ) );

	   	}
	   	else{

	   		wp_nav_menu( array( 'theme_location' => 'suppa_menu_location_' . $menu_number ) );

	   	}

	}

}

/** wooThemes canvas support **/
if ( ! function_exists( 'woo_nav' ) ) {
	function woo_nav() {
		global $woo_options;
		woo_nav_before();
		if ( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary-menu' ) )
		{
			wp_nav_menu( array( 'theme_location' => 'primary-menu' ) );
		}
		woo_nav_after();
	} // End woo_nav()
}
// remove canvas mobile menu
remove_action( 'woo_header_inside', 'woo_nav_toggle', 20 );

/** Shortcode For : Login Form **/
// http://pippinsplugins.com/wordpress-login-form-short-code/
function suppa_login_sc( $atts, $content = null ) {

	extract( shortcode_atts( array(
      'redirect' => ''
      ), $atts ) );

	if($redirect) {
		$redirect_url = $redirect;
	} else {
		$redirect_url = get_permalink();
	}
	$form = wp_login_form(array('echo' => false, 'redirect' => $redirect_url ));

	return $form;
}
add_shortcode('suppa_login_sc', 'suppa_login_sc');

/** Shortcode for the menu itself **/
function suppa_menu_func( $atts ) {
	if( gettype( $atts ) == "string" ){
		suppa_implement(1);
	}
	else{
		suppa_implement( $atts['id'] );
	}
}
add_shortcode('suppa_menu', 'suppa_menu_func');

?>