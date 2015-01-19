<?php
/**
 * Responsive Style
 *
 * @package 	CTFramework
 * @author		Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link		http://vamospace.com
 * @since		Version 1.0
 *
 */
echo '<h3 class="ctf_page_title">' . __('Responsive Style','suppa_menu') . '</h3>';

// Logo Padding
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Logo Padding' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_logo_padding_top',
					'value'				=> '0px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_logo_padding_bottom',
					'value'				=> '0px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_logo_padding_left',
					'value'				=> '0px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_logo_padding_right',
					'value'				=> '0px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the padding ( Top, Bottom, Left, Right )' , 'suppa_menu' ).'</span>

		</div>';

echo '<br/><br/><br/>';

// 3Bars Icon Size
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd_3bars_icon_size',
		'title'				=> __( '3Bars Icon Size' , 'suppa_menu' ),
		'desc'				=> __( 'Set rwd 3bars icon size' , 'suppa_menu' ),
		'value'				=> '20px',
	),
	'suppa_all_op_container'
);

// 3Bars Icon Color
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd_3bars_icon_color',
		'title'				=> __( '3Bars Icon Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set rwd 3bars icon color' , 'suppa_menu' ),
		'value'				=> '#ffffff',
	),
	'suppa_all_op_container'
);

// 3Bars Right Margin
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd_3bars_icon_right_margin',
		'title'				=> __( '3Bars Right Margin' , 'suppa_menu' ),
		'desc'				=> __( 'Set rwd 3bars icon right margin' , 'suppa_menu' ),
		'value'				=> '20px',
	),
	'suppa_all_op_container'
);

echo '<br/><br/><br/>';

// RWD Text Font
$this->add_font(
	array(
		'group_id'			=> 'style', 		// Group to save this option on
		'option_id'			=> 'rwd_text_font', 		// Option ID
		'title'				=> __( 'RWD Text Typography' , 'suppa_menu' ), 		// Title
		'desc'				=> __( 'Set rwd text typography' , 'suppa_menu' ), 		// Description or Help
		'font_size'			=> 14,	// Font Size
		'font_type'			=> 'px',	// Font Size Type
		'font_family'		=> "'Arial', 'Verdana' sans-serif",	// Font Family
		'font_style'		=> 'normal',	// Font Style
		'font_color'		=> '#ffffff',	// Font Color
		'fetch'				=> 'yes',	// Fetch Database
	),
	'suppa_all_op_container'
);

// RWD Text Left Margin
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd_text_left_margin',
		'title'				=> __( 'RWD Text Left Margin' , 'suppa_menu' ),
		'desc'				=> __( 'Set rwd Text left margin' , 'suppa_menu' ),
		'value'				=> '20px',
	),
	'suppa_all_op_container'
);

echo "<br/><br/><br/>";

// Main Links Height
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd_main_links_height',
		'title'				=> __( 'Main Links Height' , 'suppa_menu' ),
		'desc'				=> __( 'Set main links height' , 'suppa_menu' ),
		'value'				=> '35px',
	),
	'suppa_all_op_container'
);

// Main Links Font
$this->add_font(
	array(
		'group_id'			=> 'style', 		// Group to save this option on
		'option_id'			=> 'rwd_main_links_font', 		// Option ID
		'title'				=> __( 'Main Links Typography' , 'suppa_menu' ), 		// Title
		'desc'				=> __( 'Set the main links typography' , 'suppa_menu' ), 		// Description or Help
		'font_size'			=> 15,	// Font Size
		'font_type'			=> 'px',	// Font Size Type
		'font_family'		=> "'Arial', 'Verdana' sans-serif",	// Font Family
		'font_style'		=> 'normal',	// Font Style
		'font_color'		=> '#c9c9c9',	// Font Color
		'fetch'				=> 'yes',	// Fetch Database
	),
	'suppa_all_op_container'
);

// Color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd-main_links_color_hover',
		'value'				=> '#ffffff',
		'title'				=> __( 'Color ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the main links color when user hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Background
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd_main_links_bg',
		'value'				=> '#0b1b26',
		'title'				=> __( 'Background' , 'suppa_menu' ),
		'desc'				=> __( 'Set the main links background color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Background ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd_main_links_bg_hover',
		'value'				=> '#153245',
		'title'				=> __( 'Background ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the main links background color when you hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Bottom Border
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd_main_links_bottom_border_color',
		'value'				=> '#2b2b2b',
		'title'				=> __( 'Bottom Border Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the main links bottom border color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Left Margin
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'rwd_main_links_left_margin',
		'title'				=> __( 'Main Link Left Margin' , 'suppa_menu' ),
		'desc'				=> __( 'Set rwd main links left margin' , 'suppa_menu' ),
		'value'				=> '20px',
	),
	'suppa_all_op_container'
);

// Arrow Style
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Arrow Style' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_main_links_arrow_width',
					'value'				=> '14px',
				),
				'ctf_option_no_border'
			);

			$this->add_colorpicker(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_main_links_arrow_color',
					'value'				=> '#c9c9c9',
				),
				'ctf_option_no_border'
			);

			$this->add_colorpicker(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_main_links_arrow_color_hover',
					'value'				=> '#ffffff',
				),
				'ctf_option_no_border'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the arrow style ( Size , Color , Color[Hover] , Margin Right , Margin Top )' , 'suppa_menu' ).'</span>

		</div>';

echo "<br/><br/><br/>";

// Submenus Padding
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Submenus Padding' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_submenu_padding_top',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_submenu_padding_right',
					'value'				=> '0px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_submenu_padding_bottom',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'rwd_submenu_padding_left',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the submenus padding ( Top , Right , Bottom , Left )' , 'suppa_menu' ).'</span>

		</div>';

?>