<?php
echo '<h3 class="ctf_page_title">' . __('Submenu Dropdown Style','suppa_menu') . '</h3>';

// SubMenu Type Mega Links
// DropDown Links Font
$this->add_font(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'submenu-dropdown-link_font', 		
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

// DropDown Links color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'submenu-dropdown-link_color_hover', 		
		'value'				=> '#ffffff',
		'title'				=> __( 'Links Color ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the links color when you hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// DropDown Links Bottom Border color
$this->add_colorpicker(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'submenu_dropdown_link_bg_hover', 		
		'value'				=> '#0b1b26',
		'title'				=> __( 'Links Background Color ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the links background color when user hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// DropDown Links Bottom Border color
$this->add_colorpicker(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'submenu_dropdown_link_border_color', 		
		'value'				=> '#193345',
		'title'				=> __( 'Links Bottom Border Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the links bottom border color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);


// Links Padding 
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Links Padding' , 'suppa_menu' ).'</span>';
			
			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'submenu_dropdown_link_padding_top', 		
					'value'				=> '10px', 		 				
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'submenu_dropdown_link_padding_right', 		
					'value'				=> '10px', 		 				
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'submenu_dropdown_link_padding_bottom', 		
					'value'				=> '10px', 		 				
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'submenu_dropdown_link_padding_left', 		
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
		'option_id'			=> 'dropdown_desc_font', 		// Option ID
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
		'option_id'			=> 'dropdown_desc_color_hover', 		
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
		'option_id'			=> 'dropdown_desc_padding_top', 		
		'value'				=> '5px',
		'title'				=> __( 'Top Padding ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the description top padding' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

echo '<br/><br/><br/>';

// Arrow Style
echo 	'<div class="ctf_option_container suppa_all_op_container">
		<span class="ctf_option_title">'.__( 'Arrow Style' , 'suppa_menu' ).'</span>';
		
		$this->add_text_input(
			array(
				'group_id'			=> 'style', 		
				'option_id'			=> 'dropdown-links-arrow_width', 		
				'value'				=> '14px', 		 				
			),
			'ctf_option_no_border'
		);

		$this->add_colorpicker(
			array(
				'group_id'			=> 'style', 		
				'option_id'			=> 'dropdown-links-arrow_color', 		
				'value'				=> '#c9c9c9', 		 				
			),
			'ctf_option_no_border'
		);

		$this->add_colorpicker(
			array(
				'group_id'			=> 'style', 		
				'option_id'			=> 'dropdown-links_arrow_color_hover', 		
				'value'				=> '#ffffff', 		 				
			),
			'ctf_option_no_border'
		);

		$this->add_text_input(
			array(
				'group_id'			=> 'style', 		
				'option_id'			=> 'dropdown-links-arrow_position_right', 		
				'value'				=> '10px', 		 				
			),
			'ctf_option_no_border'
		);

		$this->add_text_input(
			array(
				'group_id'			=> 'style', 		
				'option_id'			=> 'dropdown-links-arrow_position_top', 		
				'value'				=> '0px', 		 				
			),
			'ctf_option_no_border'
		);

		echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the dropdown arrow style ( Size , Color , Color[Hover] , Margin Right , Margin Top )' , 'suppa_menu' ).'</span>

	</div>';