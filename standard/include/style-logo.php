<?php
// Logo Padding
echo  '<div class="ctf_option_container suppa_all_op_container">
         <span class="ctf_option_title">'.__( 'Logo Padding' , 'suppa_menu' ).'</span>';

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'title-padding_top',
               'value'           => '0px',
               'class'           => 'ctf_option_border_radius'
            ),
            'ctf_container_border_radius'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'title-padding_bottom',
               'value'           => '0px',
               'class'           => 'ctf_option_border_radius'
            ),
            'ctf_container_border_radius'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'title-padding_left',
               'value'           => '0px',
               'class'           => 'ctf_option_border_radius'
            ),
            'ctf_container_border_radius'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'title-padding_right',
               'value'           => '0px',
               'class'           => 'ctf_option_border_radius'
            ),
            'ctf_container_border_radius'
         );

         echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the padding ( Top, Bottom , Left , Right )' , 'suppa_menu' ).'</span>

      </div>';

echo '<br/><br/><br/>';


// Menu Background
$this->add_background(
   array(
      'group_id'        => 'style',
      'option_id'       => 'logo_bg',
      'title'           => __( 'Background' , 'suppa_menu' ),
      'desc'            => __( 'Set the logo background' , 'suppa_menu' ),
      'bg_color'        => 'transparent',
      'fetch'           => 'yes',
   ),
   'suppa_all_op_container'
);

// Menu Background Gradient ( from -> to )
echo  '<div class="ctf_option_container suppa_all_op_container">
         <span class="ctf_option_title">'.__( 'Background Gradient' , 'suppa_menu' ).'</span>';

         $this->add_colorpicker(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_bg_gradient_from',
               'value'           => 'transparent',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         $this->add_colorpicker(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_bg_gradient_to',
               'value'           => 'transparent',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         $this->add_select(
             array(
                 'group_id'          => 'style',
                 'option_id'         => 'logo_bg_gradient_dir',
                 'select_options'    => array(
                                    'Left to Right' => 'left',
                                    'Right to Left' => 'right',
                                    'Top to Bottom' => 'top',
                                    'Bottom to Top' => 'Bottom'
                                 ),
                 'value'             => 'top',
             )
         );

         echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the background gradient color ( ex : from #000 to #fff )' , 'suppa_menu' ).'</span>

      </div>';

echo '<br/><br/><br/>';

// Menu Borders
echo  '<div class="ctf_option_container suppa_all_op_container">
         <span class="ctf_option_title">'.__( 'Borders' , 'suppa_menu' ).'</span>';

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_border_top_size',
               'value'           => '0px',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         $this->add_colorpicker(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_border_top_color',
               'value'           => '#111111',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_border_right_size',
               'value'           => '0px',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         $this->add_colorpicker(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_border_right_color',
               'value'           => '#111111',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_border_bottom_size',
               'value'           => '0px',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         $this->add_colorpicker(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_border_bottom_color',
               'value'           => '#111111',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_border_left_size',
               'value'           => '0px',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         $this->add_colorpicker(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_border_left_color',
               'value'           => '#111111',
               'class'           => 'ctf_option_gradient'
            ),
            'ctf_container_gradient'
         );

         echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the Borders ( Top , Right , Bottom , Left )' , 'suppa_menu' ).'</span>

      </div>';

echo '<br/><br/><br/>';

// Box Shadow
echo  '<div class="ctf_option_container suppa_all_op_container">
         <span class="ctf_option_title">'.__( 'Box Shadow' , 'suppa_menu' ).'</span>';

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_boxshadow_distance',
               'value'           => '0px',
               'class'           => 'ctf_option_box_shadow'
            ),
            'ctf_container_box_shadow'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_boxshadow_blur',
               'value'           => '0px',
               'class'           => 'ctf_option_box_shadow'
            ),
            'ctf_container_box_shadow'
         );

         $this->add_colorpicker(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_boxshadow_color',
               'value'           => 'rgba(0,0,0,0.2)',
               'class'           => 'ctf_option_box_shadow'
            ),
            'ctf_container_box_shadow'
         );

         echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the box shadow ( Distance , Blur , Color )' , 'suppa_menu' ).'</span>

      </div>';

echo '<br/><br/><br/>';

// Border Radius
echo  '<div class="ctf_option_container suppa_all_op_container">
         <span class="ctf_option_title">'.__( 'Border Radius' , 'suppa_menu' ).'</span>';

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_borderradius_top_left',
               'value'           => '0px',
               'class'           => 'ctf_option_border_radius'
            ),
            'ctf_container_border_radius'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_borderradius_top_right',
               'value'           => '0px',
               'class'           => 'ctf_option_border_radius'
            ),
            'ctf_container_border_radius'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_borderradius_bottom_right',
               'value'           => '0px',
               'class'           => 'ctf_option_border_radius'
            ),
            'ctf_container_border_radius'
         );

         $this->add_text_input(
            array(
               'group_id'        => 'style',
               'option_id'       => 'logo_borderradius_bottom_left',
               'value'           => '0px',
               'class'           => 'ctf_option_border_radius'
            ),
            'ctf_container_border_radius'
         );

         echo '<div class="clearfix"></div><span class="ctf_option_desc">'.__( 'Set the border radius ( Top Left , Top Right , Bottom Right , Bottom Left )' , 'suppa_menu' ).'</span>

      </div>';