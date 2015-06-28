<?php
echo '<h3 class="ctf_page_title">' . __('Layout &amp; Logo Settings','suppa_menu') . '</h3>';

// Enable Logo
$this->add_select(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'logo_enable',
		'title'				=> __( 'Layout &amp; Logo' , 'suppa_menu' ),
		'desc'				=> __( 'Select how the menu layout will be on your site' , 'suppa_menu' ),
      'select_options'  => array(
      	__('No Logo','era_fw')								=> 'no_logo',
			__('Logo Left, Menu Right', 'era_fw' )   		=> 'logo_left_menu_right',
			__('Logo Right, Menu Left', 'era_fw' )   		=> 'logo_right_menu_left',
			__('Logo Top Center, Menu Below','era_fw')   => 'logo_top_center',
			__('Logo Top Left, Menu Below','era_fw')  	=> 'logo_top_left',
			__('Logo Top Right, Menu Below','era_fw')   	=> 'logo_top_right',
      ),
      'value'				=> 'no_logo',
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

echo '<br/><br/><br/>';



// Enable Logo RWD
$this->add_select(
	array(
		'group_id'			=> 'settings',
		'option_id'			=> 'rwd_logo_enable',
		'title'				=> __( 'Layout &amp; Logo for RWD' , 'suppa_menu' ),
		'desc'				=> __( 'Select how the RWD layout will be on your site' , 'suppa_menu' ),
      'select_options'  => array(
      	__('No Logo','era_fw')								=> 'no_logo',
			__('Logo Left, Menu Right', 'era_fw' )   		=> 'logo_left_menu_right',
			__('Logo Right, Menu Left', 'era_fw' )   		=> 'logo_right_menu_left',
			__('Logo Top Center, Menu Below','era_fw')   => 'logo_top_center',
			//__('Logo Top Left, Menu Below','era_fw')  	=> 'logo_top_left',
			//__('Logo Top Right, Menu Below','era_fw')   	=> 'logo_top_right',
      ),
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