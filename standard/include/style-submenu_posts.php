<?php
/**
 * Submenu Type Posts Style
 *
 * @package 	CTFramework
 * @author		Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link		http://vamospace.com
 * @since		Version 1.0
 *
 */

echo '<h3 class="ctf_page_title">' . __('Submenu Latest Posts Style','suppa_menu') . '</h3>';

// Post Thumbnail Width
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-posts-post_width',
		'value'				=> '209px',
		'title'				=> __( '[Latest Posts] Thumbnail Width' , 'suppa_menu' ),
		'desc'				=> __( 'Set the latest posts menu type Thumbnail width' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Post Thumbnail Height
$this->add_text_input(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-posts-post_height',
		'value'				=> '160px',
		'title'				=> __( '[Latest Posts] Thumbnail Height' , 'suppa_menu' ),
		'desc'				=> __( 'Set the latest posts menu type Thumbnail height' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Post Margin
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Post Margin' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-posts-post_margin_top',
					'value'				=> '15px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-posts-post_margin_right',
					'value'				=> '0px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-posts-post_margin_bottom',
					'value'				=> '15px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-posts-post_margin_left',
					'value'				=> '15px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the post margin ( Top , Right , Bottom , Left )' , 'suppa_menu' ).'</span>

		</div>';

echo '<br/><br/><br/>';

// Post Link Font
$this->add_font(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-posts-post_link_font',
		'title'				=> __( 'Post Link Typography' , 'suppa_menu' ),
		'desc'				=> __( 'Set the post link typography' , 'suppa_menu' ),
		'font_size'			=> 14,	// Font Size
		'font_type'			=> 'px',	// Font Size Type
		'font_family'		=> "'Arial', 'Verdana' sans-serif",	// Font Family
		'font_style'		=> 'normal',	// Font Style
		'font_color'		=> '#f1f1f1',	// Font Color
	),
	'suppa_all_op_container'
);

// Post Link Background color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'latest_posts_link_bg_color',
		'value'				=> '#313131',
		'title'				=> __( 'Post Link Background Color' , 'suppa_menu' ),
		'desc'				=> __( 'Set the post link background color ' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Post Link color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'submenu-posts-post_link_color_hover',
		'value'				=> '#ffffff',
		'title'				=> __( 'Post Link Color ( Hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set the post link color when you hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Post Link Padding
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Post Link Padding' , 'suppa_menu' ).'</span>';

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-posts-post_link_padding_top',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-posts-post_link_padding_right',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-posts-post_link_padding_bottom',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style',
					'option_id'			=> 'submenu-posts-post_link_padding_left',
					'value'				=> '10px',
					'class'				=> 'ctf_option_border_radius'
				),
				'ctf_container_border_radius'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the post link padding ( Top , Right , Bottom , Left )' , 'suppa_menu' ).'</span>

		</div>';

echo '<br/><br/><br/>';


// Post Link Background color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'latest_posts_view_all_color',
		'value'				=> '#313131',
		'title'				=> __( 'View All Button color' , 'suppa_menu' ),
		'desc'				=> __( 'Set View All Button color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Post Link color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'latest_posts_view_all_bg',
		'value'				=> '#ffffff',
		'title'				=> __( 'View All Button background color' , 'suppa_menu' ),
		'desc'				=> __( 'Set View All Button background color' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);


// Post Link Background color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'latest_posts_view_all_color_hover',
		'value'				=> '#313131',
		'title'				=> __( 'View All Button color ( hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set View All Button color when you hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);

// Post Link color ( Hover )
$this->add_colorpicker(
	array(
		'group_id'			=> 'style',
		'option_id'			=> 'latest_posts_view_all_bg_hover',
		'value'				=> '#ffffff',
		'title'				=> __( 'View All Button background color ( hover )' , 'suppa_menu' ),
		'desc'				=> __( 'Set View All Button background color when you hover over' , 'suppa_menu' )
	),
	'suppa_all_op_container'
);
