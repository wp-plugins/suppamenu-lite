<?php
/**
 * Responsive Style
 *
 * @package 	CTFramework
 * @author		Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link		http://codetemp.com
 * @since		Version 1.3
 *
 */
echo '<h3 class="ctf_page_title">' . __('Posts settings','suppa_menu') . '</h3>';

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
