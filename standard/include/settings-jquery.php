<?php
echo '<h3 class="ctf_page_title">' . __('Jquery settings','suppa_menu') . '</h3>';


// Selec jQuery Mode
$this->add_checkbox(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'settings-jquery_enable',
		'title'				=> __( 'Enable jQuery on noConflict Mode' , 'suppa_menu' ),
		'desc'				=> __( 'Enable jquery on noConflict mode ' , 'suppa_menu' ),
		'value'				=> 'off',
		'fetch'				=> 'yes',
	)
);

// jQuery Trigger
$this->add_select(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'settings-jquery_trigger',
		'title'				=> __( 'jQuery Trigger' , 'suppa_menu' ) ,
		'desc'				=> __( 'set the jquery trigger ( hover-intent is the best choice' , 'suppa_menu' ),
		'select_options'	=> array( 'click' => 'click' , 'hover-intent' => 'hover-intent' ),
		'value'				=> 'hover-intent',
	)
);

// jQuery Animation
$this->add_select(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'settings-jquery_animation',
		'title'				=> __( 'jQuery Animation' , 'suppa_menu' ) ,
		'desc'				=> __( 'set the jquery animation' , 'suppa_menu' ),
		'select_options'	=> array(
								'none' => 'none' ,
								'fade' => 'fade' ,
								'slide' => 'slide' ,
								),
		'value'				=> 'slide',
	)
);

// jQuery Easings
$this->add_select(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'settings-jquery_easings',
		'title'				=> __( 'jQuery Easings' , 'suppa_menu' ) ,
		'desc'				=> __( 'set the jquery easings' , 'suppa_menu' ),
		'select_options'	=> array(
								"linear" => "linear",
								"swing" => "swing",
								"easeInQuad" => "easeInQuad",
								"easeOutQuad" => "easeOutQuad",
								"easeInOutQuad" => "easeInOutQuad",
								"easeInCubic" => "easeInCubic",

								),
		'value'				=> 'linear',
	)
);

// Animation Time
$this->add_text_input(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'settings-jquery_animation_time',
		'value'				=> '350',
		'title'				=> __( 'Animation Time' , 'suppa_menu' ),
		'desc'				=> __( 'set the jquery animation Time ( by millisecond )' , 'suppa_menu' )
	)
);