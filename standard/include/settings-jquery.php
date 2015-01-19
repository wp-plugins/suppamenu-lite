<?php
echo '<h3 class="ctf_page_title">' . __('Jquery settings','suppa_menu') . '</h3>';

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
								"easeOutCubic" => "easeOutCubic",
								"easeInOutCubic" => "easeInOutCubic",
								"easeInQuart" => "easeInQuart",
								"easeOutQuart" => "easeOutQuart",
								"easeInOutQuart" => "easeInOutQuart",
								"easeInQuint" => "easeInQuint",
								"easeOutQuint" => "easeOutQuint",
								"easeInOutQuint" => "easeInOutQuint",
								"easeInExpo" => "easeInExpo",
								"easeOutExpo" => "easeOutExpo",
								"easeInOutExpo" => "easeInOutExpo",
								"easeInSine" => "easeInSine",
								"easeOutSine" => "easeOutSine",
								"easeInOutSine" => "easeInOutSine",
								"easeInCirc" => "easeInCirc",
								"easeOutCirc" => "easeOutCirc",
								"easeInOutCirc" => "easeInOutCirc",
								"easeInElastic" => "easeInElastic",
								"easeOutElastic" => "easeOutElastic",
								"easeInOutElastic" => "easeInOutElastic",
								"easeInBack" => "easeInBack",
								"easeOutBack" => "easeOutBack",
								"easeInOutBack" => "easeInOutBack",
								"easeInBounce" => "easeInBounce",
								"easeOutBounce" => "easeOutBounce",
								"easeInOutBounce" => "easeInOutBounce",
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