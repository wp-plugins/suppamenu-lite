<?php
echo '<h3 class="ctf_page_title">' . __('Logo Settings','suppa_menu') . '</h3>';

// Enable Logo
$this->add_checkbox(
	array(
		'group_id'			=> 'settings', 
		'option_id'			=> 'logo_enable', 
		'title'				=> __( 'Enable Logo' , 'suppa_menu' ), 	
		'desc'				=> __( 'Display a nice logo for your awesome site' , 'suppa_menu' ), 	
		'value'				=> 'off', 	
		'fetch'				=> 'yes',
	),
	'suppa_all_op_container'
);
// Logo
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Logo' , 'suppa_menu' ).'</span>';
			

			$this->add_upload(
				array(
					'group_id'			=> 'settings', 		
					'option_id'			=> 'logo_src', 		
					'value'				=> '', 		 				
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			$this->add_upload(
				array(
					'group_id'			=> 'settings', 		
					'option_id'			=> 'logo_retina_src', 		
					'value'				=> '', 		
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Upload Logo ( Normal, Retina )' , 'suppa_menu' ).'</span>

		</div>';

// Logo Padding
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Logo Padding' , 'suppa_menu' ).'</span>';
			
			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'title-padding_top', 		
					'value'				=> '0px', 		 				
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'title-padding_left', 		
					'value'				=> '0px', 		 				
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'title-padding_right', 		
					'value'				=> '0px', 		
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the padding ( Top , Left , Right )' , 'suppa_menu' ).'</span>

		</div>';

echo '<br/><br/><br/>';

// Enable Logo
$this->add_checkbox(
	array(
		'group_id'			=> 'settings', 
		'option_id'			=> 'rwd_logo_enable', 
		'title'				=> __( 'Enable Logo for RWD' , 'suppa_menu' ), 	
		'desc'				=> __( 'Display a nice logo on the RWD' , 'suppa_menu' ), 	
		'value'				=> 'off', 	
		'fetch'				=> 'yes',
	),
	'suppa_all_op_container'
);

// RWD Logo
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Logo for RWD' , 'suppa_menu' ).'</span>';
			

			$this->add_upload(
				array(
					'group_id'			=> 'settings', 		
					'option_id'			=> 'rwd_logo_src', 		
					'value'				=> '', 		 				
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			$this->add_upload(
				array(
					'group_id'			=> 'settings', 		
					'option_id'			=> 'rwd_logo_retina_src', 		
					'value'				=> '', 		
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Upload Logo for Responsive WD ( Normal, Retina )' , 'suppa_menu' ).'</span>

		</div>';

// Logo Padding
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'RWD Logo Padding' , 'suppa_menu' ).'</span>';
			
			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'rwd_logo_padding_top', 		
					'value'				=> '0px', 		 				
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'rwd_logo_padding_left', 		
					'value'				=> '0px', 		 				
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'rwd_logo_padding_right', 		
					'value'				=> '0px', 		
					'class'				=> 'ctf_option_box_shadow'
				),
				'ctf_container_box_shadow'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the padding ( Top , Left , Right )' , 'suppa_menu' ).'</span>

		</div>';