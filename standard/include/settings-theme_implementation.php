<?php
echo '<h3 class="ctf_page_title">' . __('Theme Implementation','suppa_menu') . '</h3>';


// Theme Implementation
$this->add_checkbox(
	array(
		'group_id'			=> 'settings', 
		'option_id'			=> 'settings-theme_implement', 
		'title'				=> __( 'Support WP 3.+ Menus' , 'suppa_menu' ), 	
		'desc'				=> __( 'Enable this if your theme does not support wordpress 3.+ menus, then paste this code &#60;?php suppa_implement(); ?&#62; in your header.php after body tag' , 'suppa_menu' ), 	
		'value'				=> 'off', 	
		'fetch'				=> 'yes',
	)
);
