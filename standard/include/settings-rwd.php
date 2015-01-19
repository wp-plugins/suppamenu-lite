<?php
echo '<h3 class="ctf_page_title">' . __('Responsive settings','suppa_menu') . '</h3>';

/** Responsive Web Design **/

// Enable RWD
$this->add_checkbox(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'settings-responsive_enable',
		'title'				=> __( 'Enable Responsive Design on Mobile ' , 'suppa_menu' ),
		'desc'				=> __( 'Enable the responsive design mobile devices( IOS, Android ... )' , 'suppa_menu' ),
		'value'				=> 'on',
		'fetch'				=> 'yes',
	)
);


// RWD Width
$this->add_text_input(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'settings_responsive_start_width',
		'value'				=> '960px',
		'title'				=> __( 'RWD Start Work When Device <= To This Width' , 'suppa_menu' ),
		'desc'				=> __( 'Set the width for RWD to start work' , 'suppa_menu' )
	)
);

// RWD Text
$this->add_text_input(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'settings-responsive_text',
		'value'				=> 'Menu',
		'title'				=> __( 'Add Responsive Text ' , 'suppa_menu' ),
		'desc'				=> __( 'Add a text like "Responsive Menu"' , 'suppa_menu' )
	)
);

