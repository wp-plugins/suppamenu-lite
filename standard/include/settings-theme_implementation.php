<?php
echo '<h3 class="ctf_page_title">' . __('Theme Implementation','suppa_menu') . '</h3>';


// Theme Implementation
$this->add_select(
   array(
      'group_id'        => 'settings',
      'option_id'       => 'settings-theme_implement_count',
      'title'           => __( 'Select How Many Menu Locations' , 'suppa_menu' ),
      'desc'            => __( 'Select How Many Menu Locations' , 'suppa_menu' ) . ' ' . __('you want to add in your site,' , 'suppa_menu' ) .' '. __('then paste this code','suppa_menu') . ' &#60;?php suppa_implement(); ?&#62; ' . __('in your header.php ' , 'suppa_menu' ) . ' ' .__(' after body tag or on any position in your theme.' , 'suppa_menu' ) .'( <a href="#">'. __('video tutorial here','suppa_menu') . '</a> )',
      'value'           => 0,
      'fetch'           => 'yes',
      'select_options'  => array( 0=>0, 1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10, 20=>20 ),
   )
);