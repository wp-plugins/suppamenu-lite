<?php

echo '<h3 class="ctf_page_title">' . __('Search form settings','suppa_menu') . '</h3>';

// Search Form Type
$this->add_select(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'settings_modern_search',
		'title'				=> __( 'Search Form Type' , 'suppa_menu' ),
		'desc'				=> __( 'Select the search form type' , 'suppa_menu' ),
		'value'				=> 'normal',
		'select_options'	=> array(
			__('Normal','suppa_menu') => 'normal',
			__('Boxed','suppa_menu') => 'boxed',
			__('Modern','suppa_menu') => 'modern'
		),
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