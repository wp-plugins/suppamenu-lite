<?php

$all_skins = get_option('suppa_all_skins');
$this->add_select(
    array(
        'group_id'          => 'settings',
        'option_id'         => 'skin_modify',
        'title'             => __( 'Load a Skin' , 'suppa_menu' ) ,
        'desc'              => __( 'Load the skin options to admin panel, then modify them and save' , 'suppa_menu' ),
        'select_options'    => $all_skins,
        'value'             => 'bastlow',
        'after'             => '&nbsp;&nbsp;&nbsp;<button class="button button-primary ctf-btn-load-skin">'.__('Load Skin','suppa_menu').'</button>'
    )
);