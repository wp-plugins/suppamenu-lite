<?php
/**
 * Responsive Style
 *
 * @package 	CTFramework
 * @author		Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link		http://vamospace.com
 * @since		Version 1.3
 *
 */
echo '<h3 class="ctf_page_title">' . __('Posts settings','suppa_menu') . '</h3>';

$this->add_select(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'posts_img_effect',
		'title'				=> __( 'Select image effect' , 'suppa_menu' ) ,
		'desc'				=> __( 'Select the image effect for thumbnails' , 'suppa_menu' ),
		'select_options'	=> array(
									'no effects' => 'no_effects',
									'push' => 'push',
									'pop' => 'pop',
									'rotate' => 'rotate',
									'float' => 'float',
									'sink' => 'sink',
									'skew' => 'skew',
									'Wobble Horizontal' => 'wobble-horizontal',
									'Wobble Vertical' => 'wobble-vertical',
									'Wobble To Bottom Right' => 'wobble-to-bottom-right',
									'Wobble To Top Right' => 'wobble-to-top-right',
									'Wobble Top' => 'wobble-top',
									'Wobble Bottom' => 'wobble-bottom',
									'Wobble Skew' => 'wobble-skew',
									'Buzz' => 'buzz',
									'Buzz Out' => 'buzz-out',
								),
		'value'				=> 'skew',
		'container'			=> 'yes',
		'fetch'				=> 'yes',
	)
);


// Enable View All Button
$this->add_checkbox(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'latest_posts_view_all',
		'title'				=> __( 'Enable "View all..." button in "latest posts" menu type ' , 'suppa_menu' ),
		'desc'				=> __( 'Enable "View all..." button in "latest posts" menu type' , 'suppa_menu' ),
		'value'				=> 'off',
		'fetch'				=> 'yes',
	)
);
