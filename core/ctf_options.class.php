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

/** CLASS **/
if( !class_exists('ctf_options') )
{
	/**
	 *
	 * All Methods that manage options
	 *
	 */
	class ctf_options extends ctf_fonts
	{
		protected $groups_db_offline;
		protected $options_verify_exist = array();
		protected $parent_offline_verify = array();

		/**
		 *
		 * Add New Groups to Database
		 * Save Groups to $groups_db_offline;
		 *
		 */
		public function create_groups()
		{
			if( !get_option( $this->project_settings['plugin_id'].'_settings' ) )
			{
				add_option( $this->project_settings['plugin_id'].'_settings' , array() );
				$this->groups_db_offline = array();
			}
			else
			{
				$this->groups_db_offline = get_option( $this->project_settings['plugin_id'].'_settings' );
			}
		}


		/**
		 *
		 * Verify Option ID
		 * (Do not use the same ID in the same Group)
		 *
		 * @param $group_id String
		 * @param $option_id String
		 *
		 */
		public function verify_option_id( $option_id )
		{
			// Check if Option ID Exist
			if (array_key_exists( $option_id , $this->options_verify_exist ) )
			{
				// ID Exist
			    return true;
			}
			else
			{
				$this->options_verify_exist[$option_id] = null;
				return false;
			}
		}



		/**
		 *
		 * Get option value
		 *
		 * @param $group_id String
		 * @param $option_id String
		 * @param $default_value String
		 *
		 */
		public function get_option_value( $option_id , $default_value )
		{
			// Return Saved Value
			if (array_key_exists( $option_id , $this->groups_db_offline ) )
			{
				$default_value = $this->groups_db_offline[$option_id];
			}
			else
			{
				$this->groups_db_offline[$option_id] = $default_value;
			}
			return $default_value;
		}


		/**
		 *
		 * Add Text Input
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_text_input( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'value'				=> '', 		// option value
				'class'				=> '', 		// css class
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));


			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );
			}


			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			$title = $title == '' ? '' : '<span class="ctf_option_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			$html = '<div class="ctf_option_container '.$container_special_class.'">
						'.$title.'
						'.$before.'<input type="text" autocomplete="off" class="ctf_option ctf_option_text_input '.$class.'" name="'.$option_id.'" value="'.esc_attr($value).'" />'.$after.'
						'.$desc.'
					</div>';

			echo $html;
		}



		/**
		 *
		 * Add Hidden Input
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_hidden( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'value'				=> '', 		// option value
				'container'			=> 'yes', 	// yes or no , container ( title + input + description )
				'class'				=> '', 		// css class
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			$html = $before.'<input type="hidden" autocomplete="off"  class="ctf_option ctf_option_hidden '.$class.'" name="'.$option_id.'" value="'.esc_attr($value).'" />'.$after;

			echo $html;
		}



		/**
		 *
		 *	Add Textarea
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_textarea( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'value'				=> '', 		// option value
				'container'			=> 'yes', 	// yes or no , container ( title + input + description )
				'class'				=> '', 		// css class
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			$title = $title == '' ? '' : '<span class="ctf_option_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			$html = '<div class="ctf_option_container '.$container_special_class.'">
						'.$title.'
						'.$before.'<textarea autocomplete="off"  class="ctf_option ctf_option_textarea '.$class.'" name="'.$option_id.'" >'.esc_attr($value).'</textarea>'.$after.'
						'.$desc.'
					</div>';

			echo $html;
		}



		/**
		 *
		 *	Add Checkbox
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_checkbox( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'value'				=> 'off', 	// option value
				'class'				=> '', 		// css class
				'label_class'		=> '',		// css class for label
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			$off =	$value == 'off' ? 'codetemp_checkbox_off' : '';
			$title = $title == '' ? '' : '<span class="ctf_option_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			$html = '
					<div class="ctf_option_container '.$container_special_class.'">
						'.$title.'
						'.$before.'<label for="'.$option_id.'" class="ctf_option_checkbox_label '.$off.' '.$label_class.'" ></label>
						<input autocomplete="off" type="checkbox" class="ctf_option ctf_option_checkbox '.$class.'" name="'.$option_id.'" id="'.$option_id.'" value="'.esc_attr($value).'" checked />'.$after.'
						'.$desc.'
					</div>';

			echo $html;
		}



		/**
		 *
		 *	Add Select
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_select( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'select_options'	=> array(), // array for select,radio
				'value'				=> 'off', 	// option value
				'container'			=> 'yes', 	// yes or no , container ( title + input + description )
				'class'				=> '', 		// css class
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			// Select Content
			$select_content = "";
			foreach ( $select_options as $key => $val )
			{
				$isSelected = esc_attr($val) == esc_attr($value) ? ' selected="selected" ' : '';
				$select_content .= '<option value="'.esc_attr($val).'" '.$isSelected.' >'.esc_attr($key).'</option>';
			}

			$title = $title == '' ? '' : '<span class="ctf_option_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			$html = '<div class="ctf_option_container '.$container_special_class.'">
						'.$title.'
						'.$before.'<select autocomplete="off" class="ctf_option ctf_option_select '.$class.'" name="'.$option_id.'" id="'.$option_id.'" >
							'.$select_content.'
						</select>'.$after.'
						'.$desc.'
					</div>';

			echo $html;
		}



		/**
		 *
		 *	Add Radio
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_radio( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'select_options'	=> array(), // array for select,radio
				'value'				=> 'off', 	// option value
				'class'				=> '', 		// css class
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}


			$title = $title == '' ? '' : '<span class="ctf_option_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			$html = '<div class="ctf_option_container '.$container_special_class.'">
						'.$title.$before;
						foreach ( $select_options as $key => $val )
						{
							$isSelected = $val == $value ? ' checked="checked" ' : '';
							$html .= '<input autocomplete="off" type="radio" class="ctf_option ctf_option_radio '.$class.'" name="'.$option_id.'" id="'.$option_id.'" '.$isSelected.' value="'.esc_attr($val).'" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$key.'<br/>';
						}
			$html .=	$after.$desc.'
					</div>';

			echo $html;
		}



		/**
		 *
		 *	Add WP_EDITOR
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_wp_editor( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'select_options'	=> array(), // array for select,radio
				'value'				=> 'off', 	// option value
				'container'			=> 'yes', 	// yes or no , container ( title + input + description )
				'class'				=> '', 		// css class
				'width'				=> '755', // WP_Editor Width
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			// Editor
			$args = array(
				'textarea_name'		=> $group_id.'_ctfsep_'.$option_id,
				'editor_class'		=> ' ctf_option ctf_option_wp_editor '.$class,
				'editor_css'		=> '<style type="text/css">.ctf_option_wp_editor, .wp-editor-container{ width:'.$width.'px !important; overflow:hidden; }</style>',
				'tinymce'			=> array( 'width' => $width , 'theme_advanced_path'=> false ),
			);

			$title = $title == '' ? '' : '<span class="ctf_option_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			echo 	'<div class="ctf_option_container '.$container_special_class.'">
						'.$title.$before;
						wp_editor(  $value , $group_id.'_ctfsep_'.$option_id , $args );
			echo 		$after.$desc.'
					</div>';

		}



		/**
		 *
		 * Add ColorPicker
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_colorpicker( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'value'				=> '', 		// option value
				'class'				=> '', 		// css class
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			$title = $title == '' ? '' : '<span class="ctf_option_title" >'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			$html = '<div class="ctf_option_container '.$container_special_class.'">
						'.$title.'
						'.$before.'<input autocomplete="off" type="text" class="ctf_option ctf_option_colorpicker '.$class.'" name="'.$option_id.'" value="'.esc_attr($value).'" />
						<span class="ctf_option_colorpicker_color" style="background-color:'.esc_attr($value).';"></span>'.$after.'
						<div class="clearfix"></div>
						'.$desc.'
					</div>';

			echo $html;
		}



		/**
		 *
		 * Add Upload
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_upload( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'value'				=> '', 		// option value
				'container'			=> 'yes', 	// yes or no , container ( title + input + description )
				'class'				=> '', 		// css class
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			$title = $title == '' ? '' : '<span class="ctf_option_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			$html = '<div class="ctf_option_container '.$container_special_class.'">
						'.$title.'
						'.$before.'<input autocomplete="off" type="text" class="ctf_option ctf_option_upload fl '.$class.'" name="'.$option_id.'" value="'.esc_attr($value).'" />
						<button class="ctf_option_upload_button">'.__( 'Upload' , 'suppa_menu' ).'</button>'.$after.'
						'.$desc.'
					</div>';

			echo $html;
		}




		/**
		 *
		 * Add Font
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_font( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'value'				=> '', 		// option value
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'font_size'			=> 12,	// Font Size
				'font_type'			=> 'px',	// Font Size Type
				'font_family'		=> "'Arial', 'Verdana', sans-serif",	// Font Family
				'font_style'		=> 'normal',	// Font Style
				'font_color'		=> '#000000',	// Font Color
				'fetch'				=> 'yes',	// Fetch Database

			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			$title = $title == '' ? '' : '<span class="ctf_option_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			echo 	'<div class="ctf_option_container ctf_option_container_font '.$container_special_class.'">

						'.$title.$before;

						// Font Size
						$font_sizes = array();
						for ( $i=7;  $i < 100;  $i++ )
						{
							$font_sizes[$i] = $i;
						}
						$this->add_select(
							array(
								'group_id'			=> $group_id,
								'option_id'			=> $option_id.'_font_size',
								'value'				=> $font_size,
								'class'				=> ' ctf_option_font_size '	,
								'select_options'	=> $font_sizes
							),
							'ctf_container_font'
						);

						// Font Family
						$this->add_select(
							array(
								'group_id'			=> $group_id,
								'option_id'			=> $option_id.'_font_family',
								'value'				=> $font_family,
								'class'				=> ' ctf_option_font_family '	,
								'select_options'	=> ctf_fonts::font_list()
							),
							'ctf_container_font'
						);
						$this->add_select(
							array(
								'group_id'			=> $group_id,
								'option_id'			=> $option_id.'_font_family_style',
								'value'				=> $font_style,
								'class'				=> ' ctf_option_font_family_style '	,
								'select_options'	=> array(
															'Normal'		=>	'font-style:normal;'	,
															'Italic'		=>	'font-style:italic;'	,
															'Bold'			=>	'font-weight:bold;'		,
															'Bold / Italic'	=>	'font-weight:bold;font-style:italic;'
														)
							),
							'ctf_container_font'
						);

						// Color Picker
						$this->add_colorpicker(
							array(
								'group_id'			=> $group_id,
								'option_id'			=> $option_id.'_font_color',
								'value'				=> $font_color,
								'class'				=> ' ctf_option_font_color '	,
							),
							'ctf_container_font'
						);

			echo 		'<button class="ctf_option_font_demo fl">'.__( 'Demo' , 'suppa_menu' ).'</button>
						<div class="clearfix"></div>';

						$this->add_box(
							array(
								'display'			=> 'hide',
								'width'				=> '468px',
								'desc'				=> 'Pellentesque habitant morbi tristique senectus .', 		// Description or Help
							)
						);

			echo 		$after.$desc.'
					</div>';
		}


		/**
		 *
		 * Add Background
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_background( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 			// Group to save this option on
				'option_id'			=> '', 			// Option ID
				'title'				=> '', 			// Title
				'desc'				=> '', 			// Description or Help
				'before'			=> '', 			// html before
				'after'				=> '', 			// html after
				'bg_color'			=> '#000000',
				'bg_repeat'			=> 'background-repeat',
				'bg_attachment'		=> 'background-attachment',
				'bg_position'		=> 'background-position',
				'bg_image'			=> '',
				'fetch'				=> 'yes',		// Fetch Database

			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			$title = $title == '' ? '' : '<span class="ctf_option_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';

			echo 	'<div class="ctf_option_container ctf_option_container_font '.$container_special_class.'">
						'.$title.$before;

						$this->add_colorpicker(
							array(
								'group_id'			=> $group_id,
								'option_id'			=> $option_id.'_bg_color',
								'value'				=> $bg_color,
								'fetch'				=> $fetch,
							),
							'ctf_container_background_color'
						);

						echo '<div class="clearfix"></div>';

						$this->add_select(
							array(
								'group_id'			=> $group_id,
								'option_id'			=> $option_id.'_bg_repeat',
								'select_options'	=> array(
															'background-repeat' => 'background-repeat',
															'repeat' => 'repeat' ,
															'no-repeat' => 'no-repeat' ,
															'repeat-x' => 'repeat-x' ,
															'repeat-y' => 'repeat-y'
														),
								'value'				=> $bg_repeat,
								'fetch'				=> $fetch,
							),
							'ctf_container_background_selects'
						);

						$this->add_select(
							array(
								'group_id'			=> $group_id,
								'option_id'			=> $option_id.'_bg_attachment',
								'select_options'	=> array(
															'background-attachment' => 'background-attachment',
															'scroll' => 'scroll' ,
															'fixed' => 'fixed' ,
															'local' => 'local'
														),
								'value'				=> $bg_attachment,
								'fetch'				=> $fetch,
							),
							'ctf_container_background_selects'
						);

						$this->add_select(
							array(
								'group_id'			=> $group_id,
								'option_id'			=> $option_id.'_bg_position',
								'select_options'	=> array(
															'background-position' 	=> 'background-position',
															'Left Top' 				=> 'Left Top' ,
															'Left Center' 			=> 'Left Center' ,
															'Left Bottom' 			=> 'Left Bottom' ,
															'Center Top' 			=> 'Center Top',
															'Center Center' 		=> 'Center Center' ,
															'Center Bottom' 		=> 'Center Bottom' ,
															'Right Top' 			=> 'Right Top' ,
															'Right Center' 			=> 'Right Center' ,
															'Right Bottom' 			=> 'Right Bottom' ,
														),
								'value'				=> $bg_position,
								'fetch'				=> $fetch,
							),
							'ctf_container_background_selects'
						);

						echo '<div class="clearfix"></div>';

						$this->add_upload(
							array(
								'group_id'			=> $group_id,
								'option_id'			=> $option_id.'_bg_image',
								'value'				=> $bg_image,
								'fetch'				=> $fetch,
							),
							'ctf_container_background_image'
						);

						echo $after.$desc.'

					</div>';

		}




		/**
		 *
		 * Add Ace Editor
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_ace_editor( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'group_id'			=> 0, 		// Group to save this option on
				'option_id'			=> '', 		// Option ID
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'value'				=> '', 		// option value
				'class'				=> '', 		// css class
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
				'fetch'				=> 'yes',	// Fetch Database
			)));

			// Verify the option_id
			if( $this->verify_option_id( $option_id ) )
			{
				die( __( '<script>alert("DEBUG : ID Exists '.$option_id.'"); console.log("DEBUG : ID Exists '.$option_id.'" );</script>' , 'suppa_menu' ) );

			}

			// Get the value
			if( $fetch == 'yes' )
			{
				$value = $this->get_option_value( $option_id , $value );
			}

			$desc = $desc == '' ? '' : '<span class="ctf_option_desc">'.$desc.'</span>';
			$html = '<div class="ctf_option_container '.$container_special_class.'">
						<span class="ctf_option_title" >'.$title.'</span>

						<div id="'.$option_id.'_ace" class="ctf_option_ace_editor_ace '.$class.'" >'.esc_attr($value).'</div>
						'.$before.'<textarea autocomplete="off" class="ctf_option ctf_option_ace_editor '.$class.'" name="'.$option_id.'" id="'.$option_id.'">'.esc_attr($value).'</textarea>'.$after.'
						'.$desc.'
					</div>';

			echo $html;
		}



		/**
		 *
		 * Add Notification Box's
		 * @param $config array
		 * @param $container_special_class string
		 *
		 */
		public function add_box( $config = array() , $container_special_class = "" )
		{
			extract( wp_parse_args( $config, array(
				'type'				=> 'normal',// Type : success, error, normal
				'title'				=> '', 		// Title
				'desc'				=> '', 		// Description or Help
				'image'				=> '',		// Image / Icon
				'class'				=> '', 		// css class
				'width'				=> '',		// css width
				'display'			=> 'show',	// Show / Hide
				'before'			=> '', 		// html before
				'after'				=> '', 		// html after
			)));

			$image = $image == '' ? '' : '<img class="ctf_box_img" src="'.$image.'" alt="" />';
			$title = $title == '' ? '' : '<span class="ctf_box_title">'.$title.'</span>';
			$desc = $desc == '' ? '' : '<span class="ctf_box_desc">'.$desc.'</span>';
			$width = $width == '' ? '' : ' width:'.$width.'; ';
			$display = $display == 'show' ? 'display:block;' : ' display:none; ';

			$html = $before.'<div class="ctf_box ctf_box_type_'.$type.' '.$container_special_class.'" style=" '.$width.' '.$display.' " >
								'.$image.'
								<div class="ctf_box_content">
									'.$title.'
									'.$desc.'
								</div>
								<a href="#" class="ctf_box_close">x</a>
								<div class="clearfix"></div>
					</div>'.$after;

			echo $html;
		}


		/**
		 *
		 *	Save , Reset , Delete Options
		 *
		 */
		public function ajax_update_options()
		{
			// All Data
			$ajax_data = $_REQUEST;

			// Check WP Nonce
			if( !wp_verify_nonce( $ajax_data['nonce'] , $this->project_settings['plugin_id'] ) ) {
				die( __( 'Funny Business ?' , 'suppa_menu' ) );
			}

			// Update Group : ( delete the options inside the group and save the new ones )
			if( $ajax_data['ctf_request_type'] == 'update_all' )
			{

				// Explode Data
				$data_rows = explode('__ctfand__', $ajax_data['data_string'] );
				$new_array_options = array();

				// Fetch Data
				foreach ( $data_rows as $row )
				{
					$row_explode 	= explode( '__ctfequal__' , $row);
					$name 			= $row_explode[0];

					// Decode Value
					$value 			= @urldecode( $row_explode[1] );
					$value 			= stripslashes( $value );

					// Used Fonts
					if( preg_match( "/.+_font_family$/" , $name ) )
					{
						ctf_fonts::add_font_used( $value );
						if( $value == 'null' ){
							$value = "Arial , sans-serif";
						}

					} // End IF

					// Add Decoded Option to $new_array_options
					$new_array_options[ $name ] = $value;

				}

				// Update The Parent
				update_option( $this->project_settings['plugin_id'].'_settings' , $new_array_options );

				if( $ajax_data['skin_name'] != "" )
				{
					$all_skins = get_option('suppa_all_skins');
					$all_skins[$ajax_data['skin_name']] = $ajax_data['skin_name'];
					update_option('suppa_all_skins', $all_skins);
					$new_array_options['skin_modify'] = $ajax_data['skin_name'];
				}

				do_action( $this->project_settings['plugin_id'].'_skin_to_json', $new_array_options );


				if( get_option('suppa_locations_skins') )
				{
					$saved_locations = get_option('suppa_locations_skins');

					foreach ( $saved_locations as $loca => $skin )
					{
						if( $skin == $new_array_options['skin_modify'] )
							do_action( $this->project_settings['plugin_id'].'_after_db_save', array( $loca , $skin ) );
					}
				}

				// Save Thumbnail sizes
				do_action( 'CTF_suppa_menu_save_thumb_sizes' );

				die( __( '<div>Settings Saved</div><br/><br/><div class="suppa_save_alert">Please clear your browser cache</div>' , 'suppa_menu' ) );

			}// end update_all

			die( __( 'Funny Business ?' , 'suppa_menu' ) );
			exit;
		}

	}// end class

}// end if