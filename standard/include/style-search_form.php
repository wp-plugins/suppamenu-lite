<?php
/**
 * Search Style
 *
 * @package 	CTFramework
 * @author		Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link		http://vamospace.com
 * @since		Version 1.0
 *
 */

echo '<h3 class="ctf_page_title">' . __('Search Form Style','suppa_menu') . '</h3>';

// Form Margin
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Search Form Margin' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-search_margin_top',
					'value'				=> '13px',
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-search_margin_right',
					'value'				=> '10px',
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-search_margin_left',
					'value'				=> '10px',
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the search form margin ( Top , Right , Left )' , 'suppa_menu' ).'</span>

		</div>';

echo '<br/><br/><br/>';

// Button Icon Padding
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-search-button_icon_size',
		'value'				=> '14px',
		'title'				=> __( 'Search Icon Size' , 'suppa_menu' ),
		'desc'				=> __( 'Set the button icon size' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Search Icon Padding' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'search_padding_top',
					'value'				=> '0px',
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'search_padding_left',
					'value'				=> '0px',
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'search_padding_right',
					'value'				=> '0px',
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Search icon padding ( top, left, right )' , 'suppa_menu' ).'</span>

		</div>';

// Button Icon color
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-search-button_icon_color',
		'value'				=> '#ffffff',
		'title'				=> __( 'Search Icon Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the button icon color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Button Background color
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-search-button_bg_color',
		'value'				=> '#06456e',
		'title'				=> __( 'Search Icon Backgound Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the button backgound color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

echo '<br/><br/><br/>';

// Input Width
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-search-input_width',
		'value'				=> '150px',
		'title'				=> __( 'Input Width' , 'suppa_menu' ),
		'desc'				=> __( 'Set the width of the search input' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Input Height
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-search-input_height',
		'value'				=> '26px',
		'title'				=> __( 'Input Height' , 'suppa_menu' ),
		'desc'				=> __( 'Set the height of the search input' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Input Background color
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-search-input_bg_color',
		'value'				=> '#ffffff',
		'title'				=> __( 'Input Backgound Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the input backgound color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Input Border radius
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'search_input_border_radius',
		'value'				=> '0px',
		'title'				=> __( 'Input Border Radius' , 'suppa_menu' ),
		'desc'				=> __( 'Input Border Radius' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);


echo '<br/><br/><br/>';

// Search Text Font
$this->add_font(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-search-text_font',
		'title'				=> __( 'Search Text Typography' , 'suppa_menu' ),
		'desc'				=> __( 'Set the search text typography' , 'suppa_menu' ),
		'font_size'			=> 12,	// Font Size
		'font_type'			=> 'px',	// Font Size Type
		'font_family'		=> "'Arial', 'Verdana' sans-serif",	// Font Family
		'font_style'		=> 'normal',	// Font Style
		'font_color'		=> '#16213b',	// Font Color
	),
	'suppa_all_op_container'
);

// Search Text Padding
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Search Text Padding' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-search-text_padding_left',
					'value'				=> '5px',
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-search-text_padding_right',
					'value'				=> '5px',
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the search text padding ( Left , Right )' , 'suppa_menu' ).'</span>

		</div>';