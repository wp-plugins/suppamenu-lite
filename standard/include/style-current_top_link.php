<?php
echo '<h3 class="ctf_page_title">' . __('Current Links Style','suppa_menu') . '</h3>';


// Current Top Link color
$this->add_colorpicker(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'top-links-current_color', 		
		'value'				=> '#ffffff',
		'title'				=> __( 'Current Top Link color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the current top links color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Current Top Link Background 
$this->add_colorpicker(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'top-links-current_bg', 		
		'value'				=> '#2b2b2b',
		'title'				=> __( 'Current Top Link Background Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the current top links background color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Current Top Link Arrow Color 
$this->add_colorpicker(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'top-links-current_arrow_color', 		
		'value'				=> '#ffffff',
		'title'				=> __( 'Current Top Link Arrow Color ' , 'suppa_menu' ),
		'desc'				=> __( 'Set the current top links arrow color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);


echo '<br/><br/><br/>';



// Submenus Current Links color
$this->add_colorpicker(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'submenu_current_link_color', 		
		'value'				=> '#ffffff',
		'title'				=> __( 'Submenu Current Link color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the submenu current links color [Dropdown,Mega Links]' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Current Top Link Background 
$this->add_colorpicker(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'submenu_current_link_bg', 		
		'value'				=> '#2b2b2b',
		'title'				=> __( 'Submenu Current Link Background Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the submenu current links background color [Dropdown,Mega Links]' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Current Top Link Arrow Color 
$this->add_colorpicker(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'submenu_current_link_arrow_color', 		
		'value'				=> '#ffffff',
		'title'				=> __( 'Submenu Current Link Arrow Color ' , 'suppa_menu' ),
		'desc'				=> __( 'Set the submenu current links arrow color [Dropdown,Mega Links]' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);