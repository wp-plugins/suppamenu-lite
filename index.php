<?php

/*
Plugin Name: .SuppaMenu ( Lite )
Plugin URI: http://vamospace.com
Description: A Lite Mega Menu Version of <a href="http://suppamegamenu.com">Suppamenu Pro</a>. Please read the <a href="http://vamospace.com/docs/suppa">Guide</a>
Version: 1.1.2
Author: Sabri Taieb
Author URI: http://vamospace.com
Copyright 2014  Sabri Taieb , Codezag http://vamospace.com
*/

/** Defined **/
$upload_dir = wp_upload_dir();
$suppa_settings = array
				(
					// Plugin Settings
					'plugin_id'			=> 'CTF_suppa_menu', // Don't ever ever ever change it
					'version'			=> '1.1.2',
					'guide'				=> 'http://vamospace.com/docs/suppa/',
					'support_forum'	=> 'http://vamospace.com/support/',
					'image_resize'		=> true, // false to disable the image resizing
					'plugin_url'		=> plugins_url( '' , __FILE__ ) . '/' ,
					'uploads_url'		=> $upload_dir['baseurl'],
					'icon_url'			=> plugins_url( '' , __FILE__ ) . '/standard/img/icon.png' ,
					'textdomain' 		=> 'suppa_menu', // Localisation ( translate )

					'plugin_dir'		=> plugin_dir_path( __FILE__ ),

					// Add Menu Page , Submenu Page Settins
					'menu_type'			=> 'menu_page',				// menu_page or submenu_page
					'page_title'		=> 'Suppamenu Settings' ,	// page_title
					'menu_title'		=> 'Suppamenu( Lite )' ,		// menu_title
					'capability'		=> 'manage_options'	,		// capability

					// Framework Settings
					'framework_version'	=> '3.1 suppa',

					// Database Settings
					'groups'			=> array('style','settings') // Don't ever ever ever change it
				);

/** Files Required **/
require_once("core/class-all_fonts.php");
require_once('core/class-get_categories.php');
require_once('core/class-resize_thumbnails.php');
require_once('core/ctf_options.class.php');
require_once('core/ctf_setup.class.php');
require_once('core/array-fontAwesome.php');
require_once('standard/include/class-suppa_walkers.php');
require_once('standard/include/class-customs_to_files.php');

/** Create [PLUGIN_NAME] CLASS **/
class codetemp_suppa_menu extends ctf_setup {

	/** Variables **/
	public $project_settings;
	static $plugin_activate;

	public function __construct( $project_settings = array() )
	{
		$this->project_settings = $project_settings;
		self::$plugin_activate = $project_settings;

		/** This must be first , generate plugin_id **/
		parent::__construct();

		/** -------------------------------------------------------------------------------- **/

		/** Start Mega Menu walkers **/
		new suppa_walkers( $this->project_settings , $this->groups_db_offline );

		/** Add Support For WP 3+ Menus **/
		if( isset( $this->groups_db_offline['settings-theme_implement'] ) && $this->groups_db_offline['settings-theme_implement'] == 'on' )
		{
			register_nav_menus( array(
				'suppa_menu_location' => 'Suppa Menu Location'
			) );
		}

		/** -------------------------------------------------------------------------------- **/

		/** Thumbnail Resize **/
		if( get_option('suppa_thumbs_sizes') )
		{
			$thumbs = get_option('suppa_thumbs_sizes');
			foreach ( $thumbs as $type => $siz )
			{
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

		$save_customs = new suppa_customs2files( $this->project_settings, $this->groups_db_offline );

	}



	/**
	 * Localisation ( WP Translate )
	 *
	 */
	public function translation_action()
	{
		load_plugin_textdomain( $this->project_settings['textdomain'] , false, basename( dirname( __FILE__ ) ) . '/languages' );
	}


	/**
	 *
	 * Build & Display Settings Page .
	 *
	 * ( this function change with every new plugin or theme )
	 *
	 */
	public function display_admin_page()
	{
		// Anouncements
		ctf_options::add_box(
			array(
				'type'		=> 'success',
				'title'		=> 'Suppamenu Pro <a href="http://suppamegamenu.com">Visit Demo Site</a>',
				'width'		=> '800px',
				'desc'		=> '<p>Go Pro Now and Get these Awesome Features:</p>
								<ol>
									<li> Layout
									<li> Sticky
									<li> Woocommerce Cart
									<li> Mega Posts : [Sub Type]
									<li> Mega Links : [Sub Type]
									<li> Mega Links Type {2} : [Sub Type]
									<li> Social Media : [Sub Type]
									<li> HTML &amp; Shotcodes : [Sub Type]
									<li> Ability To Style all of these new submenu types
									<li> Add Description to Links
									<li> Effects for Thumbnail ( Recent Posts/Mega Posts )
									<li> More jQuery Easings ( 26 More )
									<li> Life Time Support
								</ol>

							  ',
			)
		);


		// Header
		$header_desc 	= 'Suppa Menu ' . $this->project_settings['version'] . '<br/>Framework ' . $this->project_settings['framework_version'];
		$html_id 		= 'suppa_menu';
		echo $this->get_html_header( $header_desc , $html_id );

		// Nav & Pages
		echo '<div class="codetemp_nav_pages_container">';

		// NAV (Main)
		echo $this->get_html_nav( array(
									__( '<span class="icon ct-wrench"></span>Settings' , 'suppa_menu' )		=> array(
																												__( 'jQuery', 'suppa_menu' ),
																												__( 'Responsive', 'suppa_menu' ),
																												__( 'Suppport WP Menus', 'suppa_menu' ),
																												__( 'Search Form', 'suppa_menu' ),
																												__( 'Posts Settings', 'suppa_menu' ),
																												__( 'Logo Settings', 'suppa_menu' ),
																			),
									__( '<span class="icon ct-magic"></span>Menu Style' , 'suppa_menu' )	=> array(
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
																												//__( '[Mega Links Two] Main Links Icons', 'suppa_menu' ),
																												//__( '[Mega Links Two] Normal Links Icons', 'suppa_menu' ),

																			),
									__( '<span class="icon ct-magic"></span>Responsive Style' , 'suppa_menu' )	=> array(),
									__( '<span class="icon ct-magic"></span>Responsive Icons Style' , 'suppa_menu' )	=> array(),
									__( '<span class="icon ct-magic"></span>Custom CSS' , 'suppa_menu' )	=> array(),

								)
		);

		// Pages
		echo '		<!-- Pages Container -->
					<div class="codetemp_pages_container fl">';
					?>

						<!-- Menu Settings -->
						<div class="codetemp_page" id="codetemp_page_1">
							<?php require_once('standard/include/settings-general.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_1_1">
							<?php require_once('standard/include/settings-jquery.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_1_2">
							<?php require_once('standard/include/settings-rwd.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_1_3">
							<?php require_once('standard/include/settings-theme_implementation.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_1_4">
							<?php require_once('standard/include/settings-search_form.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_1_5">
							<?php require_once('standard/include/settings-posts.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_1_6">
							<?php require_once('standard/include/settings-logo.php') ?>
						</div>


						<!-- Menu Style -->
						<div class="codetemp_page" id="codetemp_page_2">
							<?php require_once('standard/include/style-general.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_2_1">
							<?php require_once('standard/include/style-top_level.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_2_2">
							<?php require_once('standard/include/style-current_top_link.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_2_3">
							<?php require_once('standard/include/style-submenu_general.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_2_4">
							<?php require_once('standard/include/style-submenu_posts.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_2_5">
							<?php require_once('standard/include/style-dropdown.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_2_6">
							<?php require_once('standard/include/style-search_form.php') ?>
						</div>

						<!-- Menu Icons -->
						<div class="codetemp_page" id="codetemp_page_3_1">
							<?php require_once('standard/include/style-top_level_icons.php') ?>
						</div>
						<div class="codetemp_page" id="codetemp_page_3_4">
							<?php require_once('standard/include/style-dropdown_icons.php') ?>
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

					<?php
		echo		'</div><!--codetemp_pages_container-->

					<div class="clearfix"></div>

			  </div><!--codetemp_nav_pages_container-->';

		// Footer
		echo $this->get_html_footer();
	}



	/**
	 *
	 *	Load Admin : CSS & JS
	 *
	 */
	public function backend_css_js($hook)
	{
		if( 'toplevel_page_CTF_suppa_menu' == $hook )
		{
			if( !get_option('suppa_first_install') )
				echo '<script type="text/javascript">alert("'.__('Suppa Database must be update, you have to deactivate and activate the plugin','suppa_menu').'");</script>';
			wp_enqueue_style('suppa_admin_menus_style', $this->project_settings['plugin_url'] . '/standard/css/suppa_admin_framework.css' );
			wp_enqueue_script('suppa_admin_load_skin', $this->project_settings['plugin_url'] . '/standard/js/load_skin.js' );
		}

		if( 'nav-menus.php' == $hook )
		{
			if( !get_option('suppa_first_install') )
				echo '<script type="text/javascript">alert("'.__('Suppa Database must be update, you have to deactivate and activate the plugin','suppa_menu').'");</script>';
			wp_enqueue_style('suppa_admin_menus_style', $this->project_settings['plugin_url'] . '/standard/css/suppa_admin_menus.css' );
			wp_enqueue_style('suppa_admin_menus_script', $this->project_settings['plugin_url'] . '/standard/js/suppa_admin.js' , array( 'jquery' ) );
		}

		wp_enqueue_style('suppa_tour', $this->project_settings['plugin_url'] . '/standard/css/suppa_tour.css' );
		wp_enqueue_style('suppa_admin_menus_script', $this->project_settings['plugin_url'] . '/standard/js/suppa_tour.js' , array( 'jquery' ) );

	}


	/**
	 *
	 *	Front-End : Head CSS
	 *
	 */
	public function frontend_head_style()
	{
		/** Used Google Fonts **/
		ctf_fonts::load_frontend_google_fonts();
		/** Main Style **/
		wp_enqueue_style('suppamenu_style' , $this->project_settings['plugin_url'] . 'standard/css/suppa_frontend_style.css', false , $this->project_settings['version'] );
		/** Font Awesome **/
		wp_enqueue_style( 'suppa_frontend_fontAwesome' , $this->project_settings['plugin_url'] . 'standard/css/fontAwesome/style-min.css' , false , $this->project_settings['version'] );

		/** Folders URL **/
		$upload_dir 	= wp_upload_dir();
		$css_folder_url	= $upload_dir['baseurl'].'/suppamenu2/css/';
		$js_folder_url	= $upload_dir['baseurl'].'/suppamenu2/js/';

		// SSL Support
		if( is_ssl() ){
			$css_folder_url = str_replace('http://', 'https://', $css_folder_url );
			$js_folder_url = str_replace('http://', 'https://', $js_folder_url );
		}

		if( get_option('suppa_locations_skins') )
		{
			$saved_locations 	= get_option('suppa_locations_skins');
			foreach ( $saved_locations as $loca => $skin )
			{
				wp_enqueue_style('suppamenu_custom_style_' . $loca , $css_folder_url . $loca . '.css' , false , $this->project_settings['version']);
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
		$css_folder_url	= $upload_dir['baseurl'].'/suppamenu2/css/';
		$js_folder_url	= $upload_dir['baseurl'].'/suppamenu2/js/';

		// SSL Support
		if( is_ssl() ){
			$css_folder_url = str_replace('http://', 'https://', $css_folder_url );
			$js_folder_url = str_replace('http://', 'https://', $js_folder_url );
		}

		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-effects-core');

		wp_enqueue_script('suppamenu_frontend_script' , $this->project_settings['plugin_url'] . 'standard/js/suppa_frontend.min.js' , array() , $this->project_settings['version'] , true );

		$saved_locations 	= get_option('suppa_locations_skins');
		foreach ( $saved_locations as $loca => $skin )
		{
			wp_enqueue_script('suppamenu_js_settings_file_' . $loca , $js_folder_url . $loca . '.js' , array('suppamenu_frontend_script') , $this->project_settings['version'] , true );
		}

	}

	static function plugin_install()
	{
		ob_start();
		// Create Skins Array
		$skins_folder 	= self::$plugin_activate['plugin_dir'] . 'standard/css/skins/';
		$scandir 		= @scandir($skins_folder );
		$all_skins 		= array();
		$upload_dir 	= wp_upload_dir();

		foreach ( $scandir as $key => $value)
		{
			if( $value != "." && $value != ".." )
			{
				$value = str_replace('.json', '', $value );
				$all_skins[$value] = $value;
			}
		}

        // Save Thumbnail sizes
		do_action( 'CTF_suppa_menu_save_thumb_sizes' );

		// Uploads Folder Check & Copy style files
		if( !is_writable($upload_dir['basedir']) )
		{
			die( __('Uploads Folder Must Be Writable','suppa_menu') );
		}
		else
		{
			if( !get_option('suppa_first_install') )
			{
				wp_mkdir_p( $upload_dir['basedir']. '/suppamenu2' );
				wp_mkdir_p( $upload_dir['basedir']. '/suppamenu2/skins' );
				wp_mkdir_p( $upload_dir['basedir']. '/suppamenu2/css' );
				wp_mkdir_p( $upload_dir['basedir']. '/suppamenu2/js' );

				//skins to copy
				foreach ( $all_skins as $key => $value )
				{
					@copy( $skins_folder . $value . '.json' , $upload_dir['basedir']. '/suppamenu2/skins/' . $value . '.json' );
				}
				add_option( 'suppa_all_skins', $all_skins );
				add_option( 'suppa_first_install', 'on' );

				$handle 	= 	@fopen( $upload_dir['basedir'] . '/suppamenu2/index.php' , 'w');
								@fwrite($handle, '<?php /** Silence is gold **/ ?>' );
								@fclose($handle);
			}

			ctf_fonts::get_googleFonts_list();
		}
		ob_end_clean();
    }


}// end class


/** Show Time **/
$suppa_menu_start = new codetemp_suppa_menu ( $suppa_settings );
/** Plugin Activation Hook **/
register_activation_hook( __FILE__, array( 'codetemp_suppa_menu', 'plugin_install' ) );

/** Theme Implementation for WP 3+ Menus **/
if( !function_exists('suppa_implement') )
{
	function suppa_implement()
	{
		$args = array();

		$args['walker'] 				= new suppa_menu_walker();
		$args['container_class'] 		= ' suppaMenu_wrap';
		$args['menu_class']				= ' suppaMenu';
		$args['items_wrap']				= '<div id="%1$s" class="%2$s">%3$s</div>';
		$args['depth']					= 4;
		$args['theme_location']			= 'suppa_menu_location';

		wp_nav_menu( $args );
	}
}

/** wooThemes canvas support**/
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
    suppa_implement();
}
add_shortcode('suppa_menu', 'suppa_menu_func');

?>