<?php

// Select a skin to Modify
$all_skins = array(
    'bastlow' => 'bastlow' ,
    'calvarine' => 'calvarine' ,
    'cyberia' => 'cyberia' ,
    'default' => 'default' ,
    'demo' => 'demo' ,
    'jallon' => 'jallon' ,
    'light' => 'light' ,
    'redow' => 'redow' ,
    'redrosa' => 'redrosa' ,
    'ubuntus' => 'ubuntus' ,
    'ubuntus2' => 'ubuntus2' ,
    'wally' => 'wally'
);

$all_skins = get_option('suppa_all_skins');

$this->add_select(
    array(
        'group_id'          => 'settings',
        'option_id'         => 'skin_modify',
        'title'             => __( 'Load a Skin' , 'suppa_menu' ) ,
        'desc'              => __( 'Load the skin options to admin panel, then modify them and save' , 'suppa_menu' ),
        'select_options'    => $all_skins,
        'value'             => 'demo',
    )
);