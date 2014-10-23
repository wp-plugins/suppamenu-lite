<?php
echo '<h3 class="ctf_page_title">' . __('Top Level Icons','suppa_menu') . '</h3>';

// FontAwesome Icons Size
$this->add_text_input(
	array(
		'group_id'			=> 'style', 		
		'option_id'			=> 'fontawesome_icons_size', 		
		'title'				=> __( 'FontAwesome Icons Size' , 'suppa_menu' ), 		
		'desc'				=> __( 'Set the FontAwesome icons size ( px )' , 'suppa_menu' ), 		
		'value'				=> '20px', 		
	),
	'suppa_all_op_container'
);

// FontAwesome Icon Margin
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'FontAwesome Icon Margin' , 'suppa_menu' ).'</span>';
			
			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'top-links-fontawesome_icon_margin_top', 		
					'value'				=> '16px', 		 				
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'top-links-fontawesome_icon_margin_right', 		
					'value'				=> '10px', 		
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the font awesome icon margin ( Top , Right )' , 'suppa_menu' ).'</span>

		</div>';

echo '<br/><br/><br/>';

// FontAwesome Icon Margin
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Uploaded Icons Size' , 'suppa_menu' ).'</span>';
			
			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'uploaded_icons_width', 		
					'value'				=> '20px', 		 				
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'uploaded_icons_height', 		
					'value'				=> '20px', 		
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the Uploaded icons size ( Width , Height )' , 'suppa_menu' ).'</span>

		</div>';

// Uploaded Icon Margin
echo 	'<div class="ctf_option_container suppa_all_op_container">
			<span class="ctf_option_title">'.__( 'Uploaded Icon Margin' , 'suppa_menu' ).'</span>';
			
			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'top-links-normal_icon_margin_top', 		
					'value'				=> '16px', 		 				
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			$this->add_text_input(
				array(
					'group_id'			=> 'style', 		
					'option_id'			=> 'top-links-normal_icon_margin_right', 		
					'value'				=> '10px', 		
					'class'				=> 'ctf_option_gradient'
				),
				'ctf_container_gradient'
			);

			echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the uploaded icon margin ( Top , Right )' , 'suppa_menu' ).'</span>

		</div>';