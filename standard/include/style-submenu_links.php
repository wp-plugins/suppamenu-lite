<?php
/**
 * Submenu Type Links Style
 *
 * @package 	CTFramework
 * @author		Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link		http://vamospace.com
 * @since		Version 1.0
 *
 */

echo '<h3 class="ctf_page_title">' . __('Submenu Mega Links Style','suppa_menu') . '</h3>';

// Column Margin Right
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu_column_right_margin',
		'value'				=> '12px',
		'title'				=> __( 'Column Right Margin' , 'suppa_menu' ),
		'desc'				=> __( 'Set the column right margin (px)' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

echo '<br/><br/><br/>';

// Title Link Font
$this->add_font(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-links-title_link_font',
		'title'				=> __( 'Title Typography' , 'suppa_menu' ),
		'desc'				=> __( 'Set the title typography' , 'suppa_menu' ),
		'font_size'			=> 18,	// Font Size
		'font_type'			=> 'px',	// Font Size Type
		'font_family'		=> "'Arial', 'Verdana' sans-serif",	// Font Family
		'font_style'		=> 'normal',	// Font Style
		'font_color'		=> '#c9c9c9',	// Font Color
	),
	'suppa_all_op_container'
);

// Title Link color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-links-title_link_color_hover',
		'value'				=> '#ffffff',
		'title'				=> __( 'Title Color ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the title color when you hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Title Bottom Border color
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-links-title_bottom_border_color',
		'value'				=> '#1d3c4d',
		'title'				=> __( 'Title Bottom Border Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the title bottom border color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Title Padding
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Title Padding' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-links-title_padding_top',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-links-title_padding_right',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-links-title_padding_bottom',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-links-title_padding_left',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the title padding ( Top , Right , Bottom , Left )' , 'suppa_menu' ).'</span>

		</div>';


echo '<br/><br/><br/>';

// SubMenu Type Mega Links
// Links Font
$this->add_font(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-links-links_font',
		'title'				=> __( 'Links Typography' , 'suppa_menu' ),
		'desc'				=> __( 'Set the links typography' , 'suppa_menu' ),
		'font_size'			=> 14,	// Font Size
		'font_type'			=> 'px',	// Font Size Type
		'font_family'		=> "'Arial', 'Verdana' sans-serif",	// Font Family
		'font_style'		=> 'normal',	// Font Style
		'font_color'		=> '#c9c9c9',	// Font Color
	),
	'suppa_all_op_container'
);

// Links color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-links-links_color_hover',
		'value'				=> '#ffffff',
		'title'				=> __( 'Links Color ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the Links color when you hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Links Padding
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Links Padding' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-links-links_padding_top',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-links-links_padding_right',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-links-links_padding_bottom',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-links-links_padding_left',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the links padding ( Top , Right , Bottom , Left )' , 'suppa_menu' ).'</span>

		</div>';


echo '<br/><br/><br/>';

/* Description Style */
$this->add_font(
	array(
		'group_id'			=> 'style', 		// Group to save this option on
		'option_id'			=> 'megalinks_desc_font', 		// Option ID
		'title'				=> __( 'Description Typography' , 'suppa_menu' ), 		// Title
		'desc'				=> __( 'Set the Description typography' , 'suppa_menu' ), 		// Description or Help
		'font_size'			=> 12,	// Font Size
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
		'option_id'			=> 'megalinks_desc_color_hover',
		'value'				=> '#ffffff',
		'title'				=> __( 'Color ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the description color when you hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Padding
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'megalinks_desc_padding_top',
		'value'				=> '5px',
		'title'				=> __( 'Top Padding ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the description top padding' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);