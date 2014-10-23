<?php
echo '<h3 class="ctf_page_title">' . __('Search form settings','suppa_menu') . '</h3>';

/** Search Form **/

// Enable Modern Search Form
$this->add_checkbox(
	array(
		'group_id'			=> 'settings', 
		'option_id'			=> 'settings_modern_search', 
		'title'				=> __( 'Enable Modern Search Form' , 'suppa_menu' ), 	
		'desc'				=> __( 'Enable the modern search form' , 'suppa_menu' ), 	
		'value'				=> 'off', 	
		'fetch'				=> 'yes',
	)
);

// Search Form Display
$this->add_checkbox(
	array(
		'group_id'			=> 'settings', 
		'option_id'			=> 'settings_rwd_search_form_display', 
		'title'				=> __( 'Display Search form on RWD' , 'suppa_menu' ), 	
		'desc'				=> __( 'Display search form on responsive web design' , 'suppa_menu' ), 	
		'value'				=> 'off', 	
		'fetch'				=> 'yes',
	)
);