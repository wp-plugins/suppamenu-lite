<?php

/*********************************************************************************************************
 *
 * Codetemp Framework ( CTFramework )
 *
 * @author Taieb Sabri (codetemp), http://vamospace.com
 *
 * @since 1.0.0
 *
 * Required WP 3.5+ (*)
 *
 * --- You Are Not Allowed To Use This Framework , To Build WordPress Plugins or Themes !!!
 * --- You Have To Purchase A Licence From codezag@gmail.com
 *
 /*********************************************************************************************************/

if( !class_exists('ctf_setup') )
{
	/** CLASS **/
	class ctf_setup extends ctf_options
	{
		/**
		 *
		 *	Construct
		 *
		 */
		function __construct()
		{
			/** Create Groups **/
			$this->create_groups();

			/** Add : Admin Page **/
			add_action( 'admin_menu' , array( $this , 'add_admin_page' ) );

			/** Admin : Laod CSS **/
			add_action( 'admin_enqueue_scripts' , array( $this , 'core_admin_css' ) , 0 );

			/** Admin : Laod JS **/
			add_action( 'admin_enqueue_scripts' , array( $this , 'core_admin_js' ) , 0 );

			/** Front End : Load Google Fonts **/
			add_action( 'wp_enqueue_scripts' , array( $this , 'load_frontend_google_fonts' ) );

			/** AJAX **/
			add_action( 'wp_ajax_' . $this->project_settings['plugin_id'] . '_update_options' , array( $this , 'ajax_update_options' ) );

			/** Action : Save Style&Settings To Files **/
			add_action( $this->project_settings['plugin_id'] . '_save_style_to_files' , array( $this , 'save_style_to_files' ) );
			add_action( $this->project_settings['plugin_id'] . '_save_settings_to_files' , array( $this , 'save_settings_to_files' ) );

			/** Localisation ( Translation ) **/
			add_action('init', array( $this , 'translation_action') );
		}


		/**
		 *
		 *	Add : Admin Page
		 *
		 */
		function add_admin_page( )
		{
			add_menu_page(
				$this->project_settings['page_title'] 	, 		// page_title
				$this->project_settings['menu_title'] 	, 		// menu_title
				$this->project_settings['capability'] 	, 		// capability
				$this->project_settings['plugin_id']	, 		// menu_slug
				array( $this, 'display_admin_page' )	, 		// function
				$this->project_settings['icon_url']  	,		// icon_url
				37.2582255
			);
		}


		/**
		 *
		 *	Admin : Load CSS
		 *
		 */
		public function core_admin_css( $hook )
		{
			$page_1 = 'toplevel_page_'.$this->project_settings['plugin_id'];
			$page_2 = '_page_'.$this->project_settings['plugin_id'].'_';

			if( $page_1 == $hook or preg_match("/$page_2/",$hook,$match ) )
			{
				wp_enqueue_style( 'suppa_adminArea_style' , $this->project_settings['plugin_url'] . 'core/css/core.dev.css' , false , $this->project_settings['framework_version'] , 'screen' );

				wp_enqueue_script( 'era_webFonts_loader' , 'http://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js' );

				// Color picker style
				wp_enqueue_style( 'suppa_adminArea_colorpicker' , $this->project_settings['plugin_url'] . 'core/js/colorpicker/css/colorpicker.css' , false , $this->project_settings['framework_version'] , 'screen' );

				// Font-Awesome Icons Load
				wp_enqueue_style( 'suppa_adminArea_font_awesome' , $this->project_settings['plugin_url'] . 'core/css/codetempIcons/style-min.css' , false , $this->project_settings['framework_version'] , 'screen' );
			}
		}



		/**
		 *
		 *	Admin : Load JS
		 *
		 */
		public function core_admin_js( $hook )
		{
			$page_1 = 'toplevel_page_'.$this->project_settings['plugin_id'];
			$page_2 = '_page_'.$this->project_settings['plugin_id'].'_';

			if( $page_1 == $hook or preg_match("/$page_2/",$hook,$match ) )
			{
				// WP 3.5+
				// Enqueue Media uploader scripts and environment [ wp_enqueue_media() ].
				// Strongly suggest to use this function on the admin_enqueue_scripts action hook. Using it on admin_init hook breaks it
				// How To : http://stackoverflow.com/questions/13847714/wordpress-3-5-custom-media-upload-for-your-theme-options
				// Don't Foooooooooooooooooorget to  array('jquery' , 'media-upload' , 'thickbox')  to the enqueue
				wp_enqueue_media();

				wp_enqueue_script( 'ctf_core_add_inputs' , $this->project_settings['plugin_url'] . 'core/js/core_add_inputs.dev.js' , array('jquery') , $this->project_settings['framework_version'] , true );
				wp_enqueue_script( 'codetemp-core-admin-settings' , $this->project_settings['plugin_url'] . 'core/js/core.dev.js' , array('jquery' , 'media-upload' , 'thickbox' , 'jquery-ui-core' , 'jquery-ui-draggable' , 'jquery-ui-droppable' , 'jquery-ui-sortable' , 'ctf_core_add_inputs' ) , $this->project_settings['framework_version'] , true );
				wp_enqueue_script( 'codetemp-core-admin-ace-script' , $this->project_settings['plugin_url']  .'core/js/ace/ace.js' , array( 'codetemp-core-admin-settings' ) , $this->project_settings['framework_version'] , true );
				wp_enqueue_script( 'codetemp-core-admin-colorpicker-script' , $this->project_settings['plugin_url'] . 'core/js/colorpicker/js/colorpicker.js' , array( 'codetemp-core-admin-settings' ) , $this->project_settings['framework_version'] , true );
			}
		}


		/**
		 *
		 *	Get HTML Header
		 *
		 */
		public function get_html_header( $header_desc = "" , $html_id = "" )
		{
			$html = '<form id="codetemp_form" style="margin-top:20px;">

						<div class="codetemp_ajax_response" style="display:none;">
							<div class="codetemp_ajax_response_close" >x</div>
							<img src="' . $this->project_settings['plugin_url'] . 'core/img/ajax-loader.gif" alt="" />
							<span></span>
							<div class="clearfix"></div>
						</div>

						<input type="hidden" autocomplete="off" name="nonce" id="nonce" value="' . wp_create_nonce( $this->project_settings['plugin_id'] ) . '"/>
						<input type="hidden" autocomplete="off" name="action" id="action" value="' . $this->project_settings['plugin_id'] . '_update_options' . '" />
						<input type="hidden" autocomplete="off" name="codetemp_plugin_url" id="codetemp_plugin_url" value="' . $this->project_settings['plugin_url'] . '" />
						<input type="hidden" autocomplete="off" name="codetemp_uploads_url" id="codetemp_uploads_url" value="' . $this->project_settings['uploads_url'] . '" />

					 <div class="codetemp_settings_container" id="'.$html_id.'" >';

			// Header
			$html .= '
						<div class="codetemp_header" >
							<h3 class="fl">Vamospace.com</h3>
							<span class="codetemp_header_desc fr" >'.$header_desc.'</span>
							<div class="clearfix"></div>
						</div><!--codetemp_header-->

						<div class="codetemp_bread">

							<a href="' . $this->project_settings['support_forum'] . '" class="fl">
								<img src="' . $this->project_settings['plugin_url'] . 'core/img/rounded_support.png" alt="" class="fl" />
								<span class="fl" >'.__( 'Support Forum' , 'suppa_menu' ).'</span>
						 	</a>

							<a href="' . $this->project_settings['guide'] . '" class="fl">
								<img src="' . $this->project_settings['plugin_url'] . 'core/img/rounded_guide.png" alt="" class="fl" />
								<span class="fl" >'.__( 'Guide' , 'suppa_menu' ).'</span>
							</a>
							'.$this->get_html_button( 'update_all' , __( 'Save Skin' , 'suppa_menu' ) , 'fr' ).'
							<input type="text" placeholder="'.__('Skin Name','suppa_menu').'" class="fr" id="suppa_skin_name">

							<div class="clearfix"></div>

						</div><!--codetemp_bread-->';

			return $html;
		}


		/**
		 *
		 *	Get HTML NAV (Main)
		 *
		 * @param $nav Array
		 *
		 */
		public function get_html_nav( $nav = array() )
		{
			$html = '
						<!-- Main NAV -->
						<ul class="codetemp_main_nav fl"> ';

			$i = 0;
			foreach ( $nav as $key => $value )
			{
				$i++;
				$isSelected = $i == 1 ? ' class="selected" ' : '';
				$html .= '<li '.$isSelected.'>
								<a href="#codetemp_page_'.$i.'" >'.$key.'</a>
								';
				$j = 0;
				$value = array_filter($value);
				if( !empty($value) ) $html .= '<ul>';

					foreach ( $value as $key_2 )
					{
						$j++;
						$html .= '<li><a href="#codetemp_page_'.$i.'_'.$j.'" >'.$key_2.'</a></li>';
					}

				if( !empty($value) ) $html .= '</ul>';

				$html .= '
						</li>';
			}
			$html .='	</ul><!--codetemp_main_nav-->';

			return $html;
		}


		/**
		 *
		 *	Get HTML Footer
		 *
		 */
		public function get_html_footer()
		{

			$html ='	<div class="codetemp_bread">'
							.$this->get_html_button( 'update_all' , __( 'Save Skin' , 'suppa_menu' ) , 'fr' ).
							'<div class="clearfix"></div>
						</div><!--codetemp_bread-->';

			$html .=' 	<div class="codetemp_footer">

							<span>'.date('Y').' &copy; Build By CTFramework , <a href="http://vamospace.com">Vamospace.com</a></span>

							<div class="clearfix" ></div>
						</div>
						</div><!--codetemp_settings_container-->
					</form>
					';

			return $html;
		}


		/**
		 *
		 *	Get HTML Buttons
		 *
		 * @param $type String ( update_all , reset_all , delete_group , delete_option )
		 *
		 */
		public static function get_html_button( $type = 'update_all' , $text = 'Save All Settings' , $special_class = '' , $id ='' )
		{
			return  '<button class="codetemp_button codetemp_button_'.$type.' '.$special_class.'" id="'.$id.'" >'.$text.'</button>';
		}

	}// end class

}// end if