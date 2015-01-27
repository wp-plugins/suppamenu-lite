<?php

/**
 * This file holds various classes and methods necessary to edit the wordpress menu.
 *
 * @package 	CTFramework
 * @author		Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link		http://vamospace.com
 * @since		Version 1.0
 *
 */

/**
 * This class contains various methods necessary to create mega menus in the backend
 * @package CTFramework
 *
 */
if( !class_exists( 'suppa_walkers' ) ){

	class suppa_walkers{

		static $project_settings;
		static $offline_db;

		/**
		 * Actions/Filters
		 * @package CTFramework
		 */
		public function init( $project_settings , $offline_db ){

			/** Variables **/
			self::$project_settings = $project_settings;
			self::$offline_db 		= $offline_db;

			if( count( self::$offline_db ) == 0 ){
				self::$offline_db['settings-responsive_text'] = 'Menu';
				self::$offline_db['logo_enable'] = 'off';
				self::$offline_db['rwd_logo_enable'] = 'off';
				self::$offline_db['submenu-megaposts-post_width'] = '200px';
				self::$offline_db['submenu-megaposts-post_height'] = '160px';
				self::$offline_db['posts_img_effect'] = 'none';
				self::$offline_db['submenu-posts-post_width'] = '200px';
				self::$offline_db['submenu-posts-post_height'] = '160px';
				self::$offline_db['latest_posts_view_all'] = 'View All...';
			}

			/** Load style & javascript to admin : nav-menus.php only **/
			add_action('admin_menu', array($this,'load_menus_css') , 9);
			add_action( 'admin_print_styles-nav-menus.php', array( $this , 'load_menus_js' ) , 3000 );

			/** Replace the selected menu args **/
			add_filter( 'wp_nav_menu_args', array( $this,'replace_args'), 3000);

			/** add new options to the walker **/
			add_filter( 'wp_edit_nav_menu_walker', array( $this,'replace_backend_walker') , 3000 );

			/** save suppa menu new options **/
			add_action( 'wp_update_nav_menu_item', array( $this,'update_menu'), 101, 3);

			/** Add WP Edior & Font Awesome Widgets on the Footer **/
			add_action( 'admin_footer', array( $this , 'add_widgets' ) );

			/** Ajax : Save Menu Location **/
			add_action( 'wp_ajax_save_locations_skins' , array( $this , 'save_locations_skins' ) );

			add_action( 'admin_head', array( $this , 'add_accordion_metabox' ) );

			/** Swith To Suppa Walker Axtion **/
			add_action( 'wp_ajax_suppa_switch_menu_walker' , array( $this , 'switch_menu_walker' ) );

		}


		/**
		 *
		 * Add JS & CSS only on nav-menus.php
		 * @package CTFramework
		 *
		 */
		function load_menus_css( )
		{
			if( basename( $_SERVER['PHP_SELF'] ) == "nav-menus.php" )
			{
				wp_enqueue_style ( 'suppa_menu_admin_menu_css', plugins_url('../css/' , __FILE__ ). 'suppa_admin_menus.css');
				wp_enqueue_style ( 'suppa_menu_admin_fontAwesome', plugins_url('../css/fontAwesome/' , __FILE__ ). 'style.css');
			}
		}
		function load_menus_js( )
		{
			if( basename( $_SERVER['PHP_SELF'] ) == "nav-menus.php" )
			{
				// WP 3.5+
				// Enqueue Media uploader scripts and environment [ wp_enqueue_media() ].
				// Strongly suggest to use this function on the admin_enqueue_scripts action hook. Using it on admin_init hook breaks it
				// How To : http://stackoverflow.com/questions/13847714/wordpress-3-5-custom-media-upload-for-your-theme-options
				// Don't Foooooooooooooooooorget to  array('jquery' , 'media-upload' , 'thickbox')  to the enqueue
				wp_enqueue_media();
				wp_enqueue_script( 'suppa_menu_admin_js' , plugins_url('../js/'  , __FILE__ ).'suppa_admin.js',  array('jquery' , 'media-upload' , 'thickbox' , 'jquery-ui-core' , 'jquery-ui-draggable' , 'jquery-ui-droppable' , 'jquery-ui-sortable' ), '1.0.0', true );
			}
		}

		/**
		 *
		 * Add Select Location Meta Box
		 * @package CTFramework
		 *
		 */
		function add_accordion_metabox()
		{
			add_meta_box( 'nav-menu-theme-suppa-location', __( 'SuppaMenu Locations & Skins' , 'suppa_menu' ), array( $this , 'display_select_location_meta_box' ) , 'nav-menus', 'side', 'high' );
		}


		/**
		 *
		 * Select Location Meta Box Render
		 * @package CTFramework
		 *
		 */
		function display_select_location_meta_box()
		{
			// Get Settings
			$settings = array();

			// Add Accordion Menu Locations
			$menu_locations = get_registered_nav_menus();
			$menus = get_terms('nav_menu');
			$all_skins 		= get_option('suppa_all_skins');

			if( get_option('suppa_locations_skins') )
			{
				$saved_locations = get_option('suppa_locations_skins');

				echo '
				<p>
					<div id="suppa_menu_location_selected">
					';
						foreach ($menu_locations as $key => $value)
						{
							if( array_key_exists($key, $saved_locations) )
							{
								echo '
									<div>
									<input type="checkbox" value="'.$key.'" checked >&nbsp;&nbsp;&nbsp;'.$value.'
									<br/>
									'.__('Select skin : ').' <select class="suppa_menu_location_skin">';
									foreach ( $all_skins as $skin => $skin_n )
									{
										if( $skin == $saved_locations[$key] )
											echo '<option selected="selected">'.$skin.'</option>';
										else
											echo '<option >'.$skin.'</option>';
									}
								echo '
									</select>
									</div>';
							}
							else
							{
								echo '<div>
									<input type="checkbox" value="'.$key.'" >&nbsp;&nbsp;&nbsp;'.$value.
									'<br/>
									'.__('Select skin : ').' <select class="suppa_menu_location_skin">';
									foreach ( $all_skins as $skin )
									{
										if( $skin == $saved_locations[$key] )
											echo '<option selected="selected">'.$skin.'</option>';
										else
											echo '<option >'.$skin.'</option>';
									}
								echo '
									</select>
									</div>';
							}
							echo '<br/>';
						}
				echo '
					</div><!--suppa_menu_location_selected-->
				</p>';
			}
			else
			{
				echo '
					<p>
						<div id="suppa_menu_location_selected">
						';
							foreach ($menu_locations as $key => $value)
							{

								echo '
									<div>
									<input type="checkbox" value="'.$key.'" >&nbsp;&nbsp;&nbsp;'.$value;
								echo
									'<br/>
									'.__('Select skin : ').'<select class="suppa_menu_location_skin">';
									foreach ( $all_skins as $skin )
									{
										echo '<option >'.$skin.'</option>';
									}
								echo '
									</select>
									</div><br/>';
							}
				echo '
						</div><!--suppa_menu_location_selected-->
					</p>';
			}

			echo '
				<p>
					<span>
						<input type="submit" class="button-primary" value="Save" id="admin_suppa_save_menu_location">
						<input type="hidden" value="'.wp_create_nonce("suppa_menu_location_nonce").'" id="admin_suppa_save_menu_location_nonce">

					</span>
				</p>
				<br/><br/>
			';

		}


		/**
		 *
		 * Add WP Edior & Font Awesome Widgets on the Footer
		 * @package CTFramework
		 *
		 */
		function add_widgets()
		{
			global $fontAwesome;

			if( basename( $_SERVER['PHP_SELF'] ) == "nav-menus.php" ){
				// Add Widgets
				echo '
				<input type="hidden" id="admin_suppa_plugin_url" value="'.plugins_url( '../js/tinymce/' , __FILE__ ).'" />
				<div class="era_admin_widgets_container" >
					<div class="era_admin_widget_box suppa_wp_editor_container" >

						<div class="era_admin_widget_box_header">
							<span>WP Editor</span>
							<a>x</a>
						</div>

						<div class="era_admin_widget_box_inside" >

							';

							wp_editor( '', 'suppa_wp_editor_the_editor', $settings = array() );

							echo '
							<div class="admin_suppa_clearfix"></div>
						</div>

						<div class="era_admin_widget_box_footer">
							<button class="era_admin_widgets_container_button admin_suppa_getContent_button">Add</button>
						</div>

					</div>
					';



				echo '
					<div class="era_admin_widget_box suppa_fontAwesome_container" >

						<div class="era_admin_widget_box_header">
							<span>Select an Icon</span>
							<a>x</a>
						</div>

						<div class="era_admin_widget_box_inside" >';

						foreach ( $fontAwesome as $icon )
						{
							echo '
								<span class="admin_suppa_fontAwesome_icon_box">
									<span aria-hidden="true" class="'.$icon.'"></span>
								</span>
							';

						}

				echo '
							<div class="admin_suppa_clearfix"></div>
						</div>

						<div class="era_admin_widget_box_footer">
							<button class="era_admin_widgets_container_button admin_suppa_addIcon_button">Add</button>
						</div>

					</div>
				</div>';
			}
		}


		/**
		 *
		 * After plugin install create css js files
		 * @package CTFramework
		 *
		 */
		function after_plugin_install_create_css_js_files(){

			// Save Locations & Create Skins
			$locations = get_option( 'suppa_locations_skins' );
			foreach ( $locations as $loc => $skin ){
				do_action( 'CTF_suppa_menu_after_db_save', array( $loc , $skin ) );
			}

			// Save Thumbnail sizes
			do_action( 'CTF_suppa_menu_save_thumb_sizes' );
		}



		/**
		 *
		 * Ajax : Save Menu Location
		 * @package CTFramework
		 *
		 */
		function save_locations_skins()
		{
			check_ajax_referer( 'suppa_menu_location_nonce', 'nonce' );

			// Save Locations & Create Skins
			$locations	= $_POST['location'];
			$locations = explode(",",$locations);
			$loc_arr	= array();
			foreach ( $locations as $loc )
			{
				$loc_inf = explode("=",$loc);
				$loc_arr[ $loc_inf[0] ] = $loc_inf[1];
				do_action( 'CTF_suppa_menu_after_db_save', array( $loc_inf[0] , $loc_inf[1] ) );
			}
			update_option('suppa_locations_skins', $loc_arr );

			// Save Thumbnail sizes
			do_action( 'CTF_suppa_menu_save_thumb_sizes' );

			die( __("Menus & Skins Ready !","suppa_menu") );
		}


		/**
		 *
		 * Replace the selected menu args
		 * @package CTFramework
		 *
		 */
		function replace_args($args){

			if( get_option('suppa_locations_skins') ){

				/** RWD **/
				$rwd_menu_text = self::$offline_db['settings-responsive_text'];
				if( function_exists('icl_t') ){
					$rwd_menu_text = icl_t('admin_texts_plugin_CTF_suppa_menu', '[CTF_suppa_menu__group__settings]settings-responsive_text', 'Menu');
				}

				$rwd_wrap = '
				<div class="suppaMenu_rwd_wrap" >
					<div class="suppa_rwd_top_button_container">
						<span class="suppa_rwd_button"><span aria-hidden="true" class="suppa-reorder"></span></span>
						<span class="suppa_rwd_text">' . $rwd_menu_text . '</span>
					</div>
					<div class="suppa_rwd_menus_container" ></div>
				</div>
				';

				$saved_locations 	= get_option('suppa_locations_skins');
				foreach ( $saved_locations as $location => $skin){

					if( $args['theme_location'] == $location ){

						// Get Skin Options
						$skin_options = get_option('suppamenu_skin_'.$skin);

						// Get Thumbs Sizes
						$thumbs = get_option('suppa_thumbs_sizes');
						$thumbs = $thumbs[$skin];

						$args['walker'] 				= new suppa_menu_walker( $skin_options, $thumbs );
						$args['container_class'] 	= $args['theme_location'].' suppaMenu_wrap';
						$args['menu_class']			= 'suppaMenu';
						$args['items_wrap']			= '<div id="%1$s" class="%2$s">%3$s</div>' . $rwd_wrap;
						$args['depth']					= 4;
						$args['container']			= 'div';

					}// End If

				}// End Foreach

			}// End If

			return $args;
		}


		/**
		 *
		 * Tells wordpress to use our backend walker instead of the default one
		 * @package CTFramework
		 *
		 */
		function replace_backend_walker($name)
		{
			return 'suppa_menu_backend_walker';
		}



		/*
		 * Save and Update the Custom Navigation Menu Item Properties by checking all $_POST vars with the name of $check
		 * @param int $menu_id
		 * @param int $menu_item_db
		 */
		function update_menu($menu_id, $menu_item_db)
		{
			$all_keys = array(
								'menu_type' ,
								'dropdown_width',
								'logo_image',
								'logo_image_retina',
								'links_fullwidth',
								'links_width',
								'links_align',
								'links_column_width',
								'link_icon_only',
								'html_fullwidth',
								'html_width',
								'html_align',
								'html_content',
								'link_position',
								'link_icon_type',
								'link_icon_image',
								'link_icon_image_hover',
								'link_icon_image',
								'link_icon_fontawesome',
								'link_icon_fontawesome_size',
								'posts_taxonomy',
								'posts_category',
								'posts_number',
								'search_text',
								'logo_image_height',
								'logo_image_width',
								'link_icon_image_height',
								'link_icon_image_width',
								'link_user_logged',
								'mega_posts_category',
								'mega_posts_taxonomy',
								'mega_posts_number',
								'linksTwoSubmenuWidth',
								'linksTwoSubmenuAlign',
								'linksTwo_categoriesWidth',
								'dropdown_open_pos'
							);

			foreach ( $all_keys as $key )
			{
				if(!isset($_POST['menu-item-suppa-'.$key][$menu_item_db]))
				{
					$_POST['menu-item-suppa-'.$key][$menu_item_db] = "";
				}

				$value = $_POST['menu-item-suppa-'.$key][$menu_item_db];
				update_post_meta( $menu_item_db, '_menu-item-suppa-'.$key, $value );
			}
		}


		/**
		 * Very Important .
		 * Replace The WP add menu item by AJAX
		 * This Will be remove when they add an action in the future
		 *
		 */
		public function switch_menu_walker()
		{
			if ( ! current_user_can( 'edit_theme_options' ) )
			die('-1');

			check_ajax_referer( 'add-menu_item', 'menu-settings-column-nonce' );

			require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

			$item_ids = wp_save_nav_menu_items( 0, $_POST['menu-item'] );
			if ( is_wp_error( $item_ids ) )
				die('-1');

			foreach ( (array) $item_ids as $menu_item_id ) {
				$menu_obj = get_post( $menu_item_id );
				if ( ! empty( $menu_obj->ID ) ) {
					$menu_obj = wp_setup_nav_menu_item( $menu_obj );
					$menu_obj->label = $menu_obj->title; // don't show "(pending)" in ajax-added items
					$menu_items[] = $menu_obj;
				}
			}

			if ( ! empty( $menu_items ) ) {
				$args = array(
					'after' => '',
					'before' => '',
					'link_after' => '',
					'link_before' => '',
					'walker' => new suppa_menu_backend_walker,
				);
				echo walk_nav_menu_tree( $menu_items, 0, (object) $args );
			}

			die('end');
		}
	}
}