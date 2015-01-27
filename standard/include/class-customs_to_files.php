<?php
/**
 * Save Custom Css & JS to Files
 *
 * @package 	CTFramework
 * @author	Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link	http://vamospace.com
 * @since	Version 1.5
 *
 */


if( !class_exists('suppa_customs2files') ){

/**
*
*/
class suppa_customs2files{

	protected $project_settings;

	function __construct( $project_settings ){
		$this->project_settings = $project_settings;

		/** Project Actions / Filters **/
		add_action( $this->project_settings['plugin_id'] . '_skin_to_json' , array( $this, 'skin_to_json' ), 10, 2);
		add_action( $this->project_settings['plugin_id'] . '_after_db_save' , array( $this, 'save_to_files' ), 10, 2);
        add_action( $this->project_settings['plugin_id'] . '_save_thumb_sizes' , array( $this, 'save_thumb_sizes' ), 10, 2);

	}

    // Thumbnail Size
    function save_thumb_sizes() {
        if( get_option('suppa_locations_skins') )
        {
            $upload_dir     = wp_upload_dir();
            $thumbs         = array();
            $locations      = get_option('suppa_locations_skins');
            foreach ( $locations as $loc => $skin )
            {
                /** Get Options From Json File **/
                $json_file      =   $upload_dir['basedir']. '/suppamenu2/skins/' . $skin . '.json';
                $handle         =   @fopen($json_file, 'r');
                $json_data      =   @fread($handle,filesize($json_file));
                                    @fclose($handle);
                $json_data      =   json_decode($json_data, true);

                $thumbs[$skin] = array(
                                        'recent' => array( (int)$json_data['submenu-posts-post_width'], (int)$json_data['submenu-posts-post_height'] ) ,
                                        'hover'  => $json_data['posts_img_effect']
                                    );
            }
            update_option( 'suppa_thumbs_sizes', $thumbs );
        }
    }

    // Save skin options to JSON File & DATABASE
	function skin_to_json( $json ){
		unset( $json[''] );

		$upload_dir = 	wp_upload_dir();
		$my_file 	= 	$upload_dir['basedir'].'/suppamenu2/skins/'.$json['skin_modify'].'.json';
		$handle 	= 	@fopen($my_file, 'w');
						@fwrite($handle, json_encode($json) );
						@fclose($handle);

        update_option( 'suppamenu_skin_'.$json['skin_modify'], $json );
	}

    // Generate FrontEnd CSS & JS Settings
	function save_to_files( $location_info ){

        /** Create New Cache Versio, to prevent browser cache issues **/
        $cache_version = 250;
        if( get_option('suppa_cache_version') != false ){
            $cache_version = get_option('suppa_cache_version');
        }
        $cache_version = $cache_version + 1;
        update_option('suppa_cache_version',$cache_version);

		/** Folders **/
		$upload_dir 	= wp_upload_dir();
		$suppa_folder 	= $upload_dir['basedir'].'/suppamenu2/';
		$skins_folder 	= $upload_dir['basedir'].'/suppamenu2/skins/';
		$css_folder		= $upload_dir['basedir'].'/suppamenu2/css/';
		$js_folder		= $upload_dir['basedir'].'/suppamenu2/js/';

		/** Get Options From Database **/
		$skin_name 		=	$location_info[1];
		$skin_data 		= 	get_option('suppamenu_skin_'.$skin_name);

        /** Create The Style **/
        // Menu Background Image
        $menu_background = '';
        if( isset( $skin_data['menu_bg_bg_image'] ) and $skin_data['menu_bg_bg_image'] != '' ){
            $menu_background    = '
                background-image:url(\''. $skin_data['menu_bg_bg_image'].'\') !important;
                background-repeat:'.$skin_data['menu_bg_bg_repeat'].';
                background-attachment:'.$skin_data['menu_bg_bg_attachment'].';
                background-position:'.$skin_data['menu_bg_bg_position'].';
            ';
        }
        // Logo Background Image
        $logo_background = '';
        if( isset( $skin_data['logo_bg_bg_image'] ) and $skin_data['logo_bg_bg_image'] != '' ){
            $logo_background    = '
            background-image:url(\''. $skin_data['logo_bg_bg_image'].'\') !important;
            background-repeat:'.$skin_data['logo_bg_bg_repeat'].';
            background-attachment:'.$skin_data['logo_bg_bg_attachment'].';
            background-position:'.$skin_data['logo_bg_bg_position'].';
            ';
        }
        // SubMenu Background Image
        $submenu_background_image = '';
        if( isset( $skin_data['submenu-bg_bg_image'] ) and $skin_data['submenu-bg_bg_image'] != '' )
        {
            $submenu_background_image = '
            background-image:url(\''. $skin_data['submenu-bg_bg_image'].'\') !important;
            background-repeat:'.$skin_data['submenu-bg_bg_repeat'].';
            background-attachment:'.$skin_data['submenu-bg_bg_attachment'].';
            background-position:'.$skin_data['submenu-bg_bg_position'].';
            ';
        }
        // SubMenu Background Image
        $rwd_background_image = '';
        if( isset( $skin_data['rwd_container_bg_bg_image'] ) and $skin_data['rwd_container_bg_bg_image'] != '' )
        {
            $rwd_background_image = 'background-image:url(\''. $skin_data['rwd_container_bg_bg_image'].'\') !important;
                                         background-repeat:'.$skin_data['rwd_container_bg_bg_repeat'].';
                                         background-attachment:'.$skin_data['rwd_container_bg_bg_attachment'].';
                                         background-position:'.$skin_data['rwd_container_bg_bg_position'].';
                                        ';
        }

        /** The CSS Generator **/
        $custom_css =
        '
            /** ----------------------------------------------------------------
             ******** General Style
             ---------------------------------------------------------------- **/

            .'.$location_info[0].' .suppa_holder{
                height:'.$skin_data['menu_height'].' !important;
            }

            .'.$location_info[0].'.suppaMenu_wrap {
                height:'.$skin_data['menu_height'].' !important;
                z-index:'.$skin_data['menu_z_index'].';
            }

            .'.$location_info[0].'.suppaMenu_wrap_wide_layout {
                background-color:'.$skin_data['menu_bg_bg_color'].';

                /* Borders */
                border-top: '.$skin_data['menu_border_top_size'].' solid '.$skin_data['menu_border_top_color'].';
                border-left: '.$skin_data['menu_border_left_size'].' solid '.$skin_data['menu_border_left_color'].';

                /* CSS3 Gradient */
                background-image: -webkit-linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: -moz-linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: -o-linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: -ms-linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;

                '.$menu_background.'
            }

            .'.$location_info[0].' .suppaMenu {

                width:'.$skin_data['menu_width'].';
                z-index:'.$skin_data['menu_z_index'].';
                height:'.$skin_data['menu_height'].' !important;

                background-color:'.$skin_data['menu_bg_bg_color'].';

                /* Borders */
                border-top: '.$skin_data['menu_border_top_size'].' solid '.$skin_data['menu_border_top_color'].';
                border-right: '.$skin_data['menu_border_right_size'].' solid '.$skin_data['menu_border_right_color'].';
                border-bottom: '.$skin_data['menu_border_bottom_size'].' solid '.$skin_data['menu_border_bottom_color'].';
                border-left: '.$skin_data['menu_border_left_size'].' solid '.$skin_data['menu_border_left_color'].';

                /* CSS3 Gradient */
                background-image: -webkit-linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: -moz-linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: -o-linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: -ms-linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: linear-gradient('.$skin_data['menu_bg_gradient_dir'].', '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;

                '.$menu_background.'

                /* CSS3 Box Shadow */
                -moz-box-shadow   : 0px 0px '.$skin_data['menu_boxshadow_blur'].' '.$skin_data['menu_boxshadow_distance'].' '.$skin_data['menu_boxshadow_color'].';
                -webkit-box-shadow: 0px 0px '.$skin_data['menu_boxshadow_blur'].' '.$skin_data['menu_boxshadow_distance'].' '.$skin_data['menu_boxshadow_color'].';
                box-shadow        : 0px 0px '.$skin_data['menu_boxshadow_blur'].' '.$skin_data['menu_boxshadow_distance'].' '.$skin_data['menu_boxshadow_color'].';

                /* CSS3 Border Radius */
                -webkit-border-radius: '.$skin_data['menu_borderradius_top_left'].' '.$skin_data['menu_borderradius_top_right'].' '.$skin_data['menu_borderradius_bottom_right'].' '.$skin_data['menu_borderradius_bottom_left'].';
                -moz-border-radius: '.$skin_data['menu_borderradius_top_left'].' '.$skin_data['menu_borderradius_top_right'].' '.$skin_data['menu_borderradius_bottom_right'].' '.$skin_data['menu_borderradius_bottom_left'].';
                border-radius: '.$skin_data['menu_borderradius_top_left'].' '.$skin_data['menu_borderradius_top_right'].' '.$skin_data['menu_borderradius_bottom_right'].' '.$skin_data['menu_borderradius_bottom_left'].';

            }


            /** ----------------------------------------------------------------
             ******** Logo Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_menu_logo.logo_left_menu_right{
                height:'.$skin_data['menu_height'].' !important;
                border-right:1px solid '.$skin_data['top-links-border_color'].' !important;
            }
            .'.$location_info[0].' .suppa_menu_logo.logo_right_menu_left{
                height:'.$skin_data['menu_height'].' !important;
                border-left:1px solid '.$skin_data['top-links-border_color'].' !important;
            }

            .'.$location_info[0].' .suppa_menu_logo.logo_top_center,
            .'.$location_info[0].' .suppa_menu_logo.logo_top_left,
            .'.$location_info[0].' .suppa_menu_logo.logo_top_right{
                width:'.$skin_data['menu_width'].';
            }

            .'.$location_info[0].' .logo_top_center,
            .'.$location_info[0].' .logo_top_left,
            .'.$location_info[0].' .logo_top_right {

                background-color:'.$skin_data['logo_bg_bg_color'].';

                /* Borders */
                border-top: '.$skin_data['logo_border_top_size'].' solid '.$skin_data['logo_border_top_color'].';
                border-right: '.$skin_data['logo_border_right_size'].' solid '.$skin_data['logo_border_right_color'].';
                border-bottom: '.$skin_data['logo_border_bottom_size'].' solid '.$skin_data['logo_border_bottom_color'].';
                border-left: '.$skin_data['logo_border_left_size'].' solid '.$skin_data['logo_border_left_color'].';

                /* CSS3 Gradient */
                background-image: -webkit-linear-gradient('.$skin_data['logo_bg_gradient_dir'].', '.$skin_data['logo_bg_gradient_from'].', '.$skin_data['logo_bg_gradient_to'].') ;
                background-image: -moz-linear-gradient('.$skin_data['logo_bg_gradient_dir'].', '.$skin_data['logo_bg_gradient_from'].', '.$skin_data['logo_bg_gradient_to'].') ;
                background-image: -o-linear-gradient('.$skin_data['logo_bg_gradient_dir'].', '.$skin_data['logo_bg_gradient_from'].', '.$skin_data['logo_bg_gradient_to'].') ;
                background-image: -ms-linear-gradient('.$skin_data['logo_bg_gradient_dir'].', '.$skin_data['logo_bg_gradient_from'].', '.$skin_data['logo_bg_gradient_to'].') ;
                background-image: linear-gradient('.$skin_data['logo_bg_gradient_dir'].', '.$skin_data['logo_bg_gradient_from'].', '.$skin_data['logo_bg_gradient_to'].') ;

                '.$logo_background.'

                /* CSS3 Box Shadow */
                -moz-box-shadow   : 0px 0px '.$skin_data['logo_boxshadow_blur'].' '.$skin_data['logo_boxshadow_distance'].' '.$skin_data['logo_boxshadow_color'].';
                -webkit-box-shadow: 0px 0px '.$skin_data['logo_boxshadow_blur'].' '.$skin_data['logo_boxshadow_distance'].' '.$skin_data['logo_boxshadow_color'].';
                box-shadow        : 0px 0px '.$skin_data['logo_boxshadow_blur'].' '.$skin_data['logo_boxshadow_distance'].' '.$skin_data['logo_boxshadow_color'].';

                /* CSS3 Border Radius */
                -webkit-border-radius: '.$skin_data['logo_borderradius_top_left'].' '.$skin_data['logo_borderradius_top_right'].' '.$skin_data['logo_borderradius_bottom_right'].' '.$skin_data['logo_borderradius_bottom_left'].';
                -moz-border-radius: '.$skin_data['logo_borderradius_top_left'].' '.$skin_data['logo_borderradius_top_right'].' '.$skin_data['logo_borderradius_bottom_right'].' '.$skin_data['logo_borderradius_bottom_left'].';
                border-radius: '.$skin_data['logo_borderradius_top_left'].' '.$skin_data['logo_borderradius_top_right'].' '.$skin_data['logo_borderradius_bottom_right'].' '.$skin_data['logo_borderradius_bottom_left'].';
            }

            .'.$location_info[0].' .suppa_menu_logo img{
                padding-top:'.$skin_data['title-padding_top'].' !important;
                padding-bottom:'.$skin_data['title-padding_bottom'].' !important;
                padding-right:'.$skin_data['title-padding_right'].' !important;
                padding-left:'.$skin_data['title-padding_left'].' !important;
            }

            .'.$location_info[0].' .suppa_rwd_logo img{
                padding-top:'.$skin_data['rwd_logo_padding_top'].' !important;
                padding-bottom:'.$skin_data['rwd_logo_padding_bottom'].' !important;
                padding-right:'.$skin_data['rwd_logo_padding_right'].' !important;
                padding-left:'.$skin_data['rwd_logo_padding_left'].' !important;
            }


            /** ----------------------------------------------------------------
             ******** Top Level Links Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_top_level_link {
                height:'.$skin_data['menu_height'].' !important;
                color:'.$skin_data['top_level_font_font_color'].';
            }

            .'.$location_info[0].' .suppa_top_level_link .suppa_item_title{
                font-size:'.$skin_data['top_level_font_font_size'].'px !important;
                font-family:'.$skin_data['top_level_font_font_family'].' !important;
                '.$skin_data['top_level_font_font_family_style'].'
                color:'.$skin_data['top_level_font_font_color'].';
                padding-top:'.$skin_data['top_level_padding_top'].';
            }

            .'.$location_info[0].' .suppa_menu {
                height:'.$skin_data['menu_height'].' !important;
            }

            .'.$location_info[0].' .suppa_menu_mega_posts .suppa_top_level_link ,
            .'.$location_info[0].' .suppa_menu_dropdown .suppa_top_level_link ,
            .'.$location_info[0].' .suppa_menu_posts .suppa_top_level_link ,
            .'.$location_info[0].' .suppa_menu_html .suppa_top_level_link ,
            .'.$location_info[0].' .suppa_menu_links .suppa_top_level_link,
            .'.$location_info[0].' .suppa_menu_linksTwo .suppa_top_level_link{
                padding-left:'.$skin_data['top_level_padding_left'].';
                padding-right:'.$skin_data['top_level_padding_left'].';
                border-color:'.$skin_data['top-links-border_color'].';
            }

            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.suppa_top_links_has_arrow{
                padding-right:'.$skin_data['top_level_padding_right'].';
            }

            /** ----------------------------------------------------------------
             ******** Description Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_top_level_link .suppa_item_desc{
                font-size:'.$skin_data['top_level_desc_font_font_size'].'px !important;
                font-family:'.$skin_data['top_level_desc_font_font_family'].' !important;
                '.$skin_data['top_level_desc_font_font_family_style'].'
                color:'.$skin_data['top_level_desc_font_font_color'].';
                padding-top:'.$skin_data['top_level_desc_padding_top'].' !important;
            }
            .'.$location_info[0].' .suppa_menu:hover .suppa_top_level_link .suppa_item_desc{
                color:'.$skin_data['top_level_desc_color_hover'].';
            }

            /** ----------------------------------------------------------------
             ******** Top Level Links on [HOVER] Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_menu:hover .suppa_top_level_link{
                background-color:'.$skin_data['top_level_bg_hover'].';
                color:'.$skin_data['top_level_links_color_hover'].';
            }
            .'.$location_info[0].' .suppa_menu:hover .suppa_top_level_link .suppa_item_title{
                color:'.$skin_data['top_level_links_color_hover'].';
            }

            /** Needed for suppa_frontend.js **/
            .'.$location_info[0].' .suppa_menu.suppa_menu_class_hover .suppa_top_level_link{
                background-color:'.$skin_data['top_level_bg_hover'].';
                color:'.$skin_data['top_level_links_color_hover'].';
            }
            .'.$location_info[0].' .suppa_menu.suppa_menu_class_hover .suppa_top_level_link .suppa_item_title{
                color:'.$skin_data['top_level_links_color_hover'].';
            }
            .'.$location_info[0].' .suppa_menu.suppa_menu_class_hover .suppa_top_level_link .suppa_item_desc{
                color:'.$skin_data['top_level_desc_color_hover'].';
            }

            /* boder right or left */
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.suppa_menu_position_left,
            .'.$location_info[0].' .suppa_menu .suppa_menu_position_left{
                border-right:1px solid '.$skin_data['top-links-border_color'].';
            }
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.suppa_menu_position_right,
            .'.$location_info[0].' .suppa_menu .suppa_menu_position_right{
                border-left:1px solid '.$skin_data['top-links-border_color'].';
            }

            /** ----------------------------------------------------------------
             ******** Top Level Arrow Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_top_level_link .ctf_suppa_fa_box_top_arrow{
                    font-size:'.$skin_data['top-links-arrow_width'].' !important;
                    top:'.$skin_data['top-links-arrow_position_top'].' !important;
                    right:'.$skin_data['top-links-arrow_position_right'].' !important;

                    /* color/bg/border */
                    color:'.$skin_data['top-links-arrow_color'].';
            }
            .'.$location_info[0].' .suppa_menu:hover .suppa_top_level_link .ctf_suppa_fa_box_top_arrow{
                color:'.$skin_data['top-links-arrow_color_hover'].';
            }
            /** Needed for suppa_frontend.js **/
            .'.$location_info[0].' .suppa_menu.suppa_menu_class_hover .suppa_top_level_link .ctf_suppa_fa_box_top_arrow,
            .'.$location_info[0].' .suppa_menu.suppa_menu_class_hover .suppa_top_level_link .ctf_suppa_fa_box{
                color:'.$skin_data['top-links-arrow_color_hover'].' !important;
            }

            /** ----------------------------------------------------------------
             ******** Current Top Level Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-item,
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-item .ctf_suppa_fa_box,
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-item .suppa_item_title,
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-ancestor,
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-ancestor .ctf_suppa_fa_box,
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-ancestor .suppa_item_title{
                color:'.$skin_data['top-links-current_color'].' ;
            }

            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-item,
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-ancestor {
                background-color:'.$skin_data['top-links-current_bg'].';
            }

            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-ancestor .era_suppa_arrow_box span,
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link.current-menu-item .era_suppa_arrow_box span{
                color:'.$skin_data['top-links-current_arrow_color'].';
            }


            /** ----------------------------------------------------------------
             ******** Top Level Icons
             ---------------------------------------------------------------- **/
            /** F.Awesome Icons **/
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link .ctf_suppa_fa_box{
                color:'.$skin_data['top_level_font_font_color'].';
            }
            .'.$location_info[0].' .suppa_menu:hover .suppa_top_level_link .ctf_suppa_fa_box{
                color:'.$skin_data['top_level_links_color_hover'].';
            }
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link .ctf_suppa_fa_box{
                font-size:'.$skin_data['fontawesome_icons_size'].' !important;
                margin-top: '.$skin_data['top-links-fontawesome_icon_margin_top'].' !important;
                padding-right: '.$skin_data['top-links-fontawesome_icon_margin_right'].' !important;
            }

            /** Uploaded Icons **/
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link .suppa_upload_img{
                width : '.$skin_data['uploaded_icons_width'].' !important;
                height : '.$skin_data['uploaded_icons_width'].' !important;
                margin-top: '.$skin_data['top-links-normal_icon_margin_top'].' !important;
                padding-right: '.$skin_data['top-links-normal_icon_margin_right'].' !important;
            }



            /** ----------------------------------------------------------------
             ******** General Submenu
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_submenu {

                top:'.( (int)$skin_data['menu_height'] + (int)$skin_data['menu_border_bottom_size'] ).'px !important;

                /* color/bg/border */
                background-color:'.$skin_data['submenu-bg_bg_color'].';

                border-top: '.$skin_data['submenu-border-top_size'].' solid '.$skin_data['submenu-border-top_color'].';
                border-right: '.$skin_data['submenu-border-right_size'].' solid '.$skin_data['submenu-border-right_color'].';
                border-bottom: '.$skin_data['submenu-border-bottom_size'].' solid '.$skin_data['submenu-border-bottom_color'].';
                border-left: '.$skin_data['submenu-border-left_size'].' solid '.$skin_data['submenu-border-left_color'].';

                /* CSS3 Gradient */
                background-image: -webkit-linear-gradient('.$skin_data['submenu-bg-gradient_dir'].', '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: -moz-linear-gradient('.$skin_data['submenu-bg-gradient_dir'].', '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: -o-linear-gradient('.$skin_data['submenu-bg-gradient_dir'].', '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: -ms-linear-gradient('.$skin_data['submenu-bg-gradient_dir'].', '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: linear-gradient('.$skin_data['submenu-bg-gradient_dir'].', '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;

                '.$submenu_background_image.'

                /* CSS3 Box Shadow */
                -moz-box-shadow   : 0px 0px '.$skin_data['submenu-boxshadow_blur'].' '.$skin_data['submenu-boxshadow_distance'].' '.$skin_data['submenu-boxshadow_color'].';
                -webkit-box-shadow: 0px 0px '.$skin_data['submenu-boxshadow_blur'].' '.$skin_data['submenu-boxshadow_distance'].' '.$skin_data['submenu-boxshadow_color'].';
                box-shadow        : 0px 0px '.$skin_data['submenu-boxshadow_blur'].' '.$skin_data['submenu-boxshadow_distance'].' '.$skin_data['submenu-boxshadow_color'].';

                /* CSS3 Border Radius */
                -webkit-border-radius: '.$skin_data['submenu-borderradius_top_left'].' '.$skin_data['submenu-borderradius_top_right'].' '.$skin_data['submenu-borderradius_bottom_right'].' '.$skin_data['submenu-borderradius_bottom_left'].';
                -moz-border-radius: '.$skin_data['submenu-borderradius_top_left'].' '.$skin_data['submenu-borderradius_top_right'].' '.$skin_data['submenu-borderradius_bottom_right'].' '.$skin_data['submenu-borderradius_bottom_left'].';
                border-radius: '.$skin_data['submenu-borderradius_top_left'].' '.$skin_data['submenu-borderradius_top_right'].' '.$skin_data['submenu-borderradius_bottom_right'].' '.$skin_data['submenu-borderradius_bottom_left'].';
            }



            /** ----------------------------------------------------------------
             ******** SubMenu Posts
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_post {
                width: '.$skin_data['submenu-posts-post_width'].';
            }
            .'.$location_info[0].' .suppa_post a{
                width: '.$skin_data['submenu-posts-post_width'].';
            }
            .'.$location_info[0].' .suppa_post img{
                width: '.$skin_data['submenu-posts-post_width'].';
                height: '.$skin_data['submenu-posts-post_height'].';
            }
            .'.$location_info[0].' .suppa_post div.suppa_post_link_container {
                width: '.$skin_data['submenu-posts-post_width'].' !important;
            }

            .'.$location_info[0].' .suppa_post {
                margin: '.$skin_data['submenu-posts-post_margin_top'].' '.$skin_data['submenu-posts-post_margin_right'].' '.$skin_data['submenu-posts-post_margin_bottom'].' '.$skin_data['submenu-posts-post_margin_left'].' !important;
            }
            .'.$location_info[0].' .suppa_post div.suppa_post_link_container {
                background-color: '.$skin_data['latest_posts_link_bg_color'].';
            }
            .'.$location_info[0].' .suppa_post span {
                font-size:'.$skin_data['submenu-posts-post_link_font_font_size'].'px !important;
                font-family:'.$skin_data['submenu-posts-post_link_font_font_family'].' !important;
                '.$skin_data['submenu-posts-post_link_font_font_family_style'].'

                padding: '.$skin_data['submenu-posts-post_link_padding_top'].' '.$skin_data['submenu-posts-post_link_padding_right'].' '.$skin_data['submenu-posts-post_link_padding_bottom'].' '.$skin_data['submenu-posts-post_link_padding_left'].' !important;

                /* color/bg/border */
                color:'.$skin_data['submenu-posts-post_link_font_font_color'].';
            }

            .'.$location_info[0].' .suppa_post span:hover ,
            .'.$location_info[0].' .suppa_post span:hover {
                /* color/bg/border */
                color:'.$skin_data['submenu-posts-post_link_color_hover'].';
            }

            .'.$location_info[0].' .suppa_latest_posts_view_all{
                font-size:'.$skin_data['submenu-posts-post_link_font_font_size'].'px !important;
                font-family:'.$skin_data['submenu-posts-post_link_font_font_family'].' !important;
                '.$skin_data['submenu-posts-post_link_font_font_family_style'].'
                padding: '.$skin_data['submenu-posts-post_margin_top'].' '.$skin_data['submenu-posts-post_margin_left'].' ;
                margin: '.$skin_data['submenu-posts-post_margin_top'].' '.$skin_data['submenu-posts-post_margin_left'].';

                /* color/bg/border */
                color:'.$skin_data['latest_posts_view_all_color'].';
                background-color: '.$skin_data['latest_posts_view_all_bg'].';
            }

            .'.$location_info[0].' .suppa_latest_posts_view_all:hover{
                /* color/bg/border */
                color:'.$skin_data['latest_posts_view_all_color_hover'].';
                background-color: '.$skin_data['latest_posts_view_all_bg_hover'].';
            }


            /** ----------------------------------------------------------------
             ******** Submenu DropDown Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu a {
                font-size:'.$skin_data['submenu-dropdown-link_font_font_size'].'px !important;
                font-family:'.$skin_data['submenu-dropdown-link_font_font_family'].' !important;
                '.$skin_data['submenu-dropdown-link_font_font_family_style'].'
                border-bottom:1px solid '.$skin_data['submenu_dropdown_link_border_color'].';
                padding: '.$skin_data['submenu_dropdown_link_padding_top'].' '.$skin_data['submenu_dropdown_link_padding_right'].' '.$skin_data['submenu_dropdown_link_padding_bottom'].' '.$skin_data['submenu_dropdown_link_padding_left'].';
            }

            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu a .suppa_item_title{
                font-size:'.$skin_data['submenu-dropdown-link_font_font_size'].'px !important;
                font-family:'.$skin_data['submenu-dropdown-link_font_font_family'].' !important;
                '.$skin_data['submenu-dropdown-link_font_font_family_style'].'
                color:'.$skin_data['submenu-dropdown-link_font_font_color'].';
            }

            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu div:hover > a ,
            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu a:hover {
                color:'.$skin_data['submenu-dropdown-link_color_hover'].';
                background-color:'.$skin_data['submenu_dropdown_link_bg_hover'].';
                padding-left : '.( (int)$skin_data['submenu_dropdown_link_padding_left'] + ( (int)$skin_data['submenu_dropdown_link_padding_left'] / 3 ) ).'px;
            }
            .suppa_menu_dropdown > .suppa_submenu div:hover > a .suppa_item_title,
            .suppa_menu_dropdown > .suppa_submenu a:hover .suppa_item_title{
                color:'.$skin_data['submenu-dropdown-link_color_hover'].';
            }

            /** Needed for suppa_frontend.js **/
            .'.$location_info[0].' .suppa_submenu .suppa_menu_class_dropdown_levels_hover > a {
                color:'.$skin_data['submenu-dropdown-link_color_hover'].';
                background-color:'.$skin_data['submenu_dropdown_link_bg_hover'].';
            }
            .'.$location_info[0].' .suppa_submenu .suppa_menu_class_dropdown_levels_hover > a .suppa_item_title{
                color:'.$skin_data['submenu-dropdown-link_color_hover'].';
            }

            /** ----------------------------------------------------------------
             ******** Description Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu .suppa_item_desc{
                font-size:'.$skin_data['dropdown_desc_font_font_size'].'px !important;
                font-family:'.$skin_data['dropdown_desc_font_font_family'].' !important;
                '.$skin_data['dropdown_desc_font_font_family_style'].'
                color:'.$skin_data['dropdown_desc_font_font_color'].';

                padding-top:'.$skin_data['dropdown_desc_padding_top'].' !important;
            }
            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu div:hover > a .suppa_item_desc{
                color:'.$skin_data['dropdown_desc_font_font_color'].';
            }
            .'.$location_info[0].' .suppa_submenu .suppa_menu_class_dropdown_levels_hover > a .suppa_item_desc{
                color:'.$skin_data['dropdown_desc_color_hover'].';
            }

            /** ----------------------------------------------------------------
             ******** Submenu DropDown Icons Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu a .suppa_FA_icon{
                color:'.$skin_data['submenu-dropdown-link_font_font_color'].';
            }

            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu div:hover > a .suppa_FA_icon,
            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu a:hover .suppa_FA_icon{
                color:'.$skin_data['submenu-dropdown-link_color_hover'].';
            }

            /** Needed for suppa_frontend.js **/
            .'.$location_info[0].' .suppa_menu_class_dropdown_levels_hover > a .ctf_suppa_fa_box{
                color:'.$skin_data['submenu-dropdown-link_color_hover'].';
            }

            /** F.Awesome Icons **/
            .'.$location_info[0].' .suppa_menu_dropdown .suppa_submenu .suppa_FA_icon {
                font-size:'.$skin_data['submenu_dropdown_links_fontawesome_icons_size'].' !important;
                margin-top: '.$skin_data['submenu_dropdown_links_fontawesome_icon_margin_top'].' !important;
                padding-right: '.$skin_data['submenu_dropdown_links_fontawesome_icon_margin_right'].' !important;
            }

            /** Uploaded Icons **/
            .'.$location_info[0].' .suppa_menu_dropdown .suppa_submenu .suppa_UP_icon {
                width : '.$skin_data['submenu_dropdown_links_uploaded_icons_width'].' !important;
                height : '.$skin_data['submenu_dropdown_links_uploaded_icons_height'].' !important;
                margin-top: '.$skin_data['submenu_dropdown_links_normal_icon_margin_top'].' !important;
                padding-right: '.$skin_data['submenu_dropdown_links_normal_icon_margin_right'].';
            }

            /** Open Sub Right **/
            .'.$location_info[0].' .suppa_submenu.suppa_submenu_pos_right .suppa_FA_icon{
                padding-right: 0 !important;
                padding-left: '.$skin_data['submenu_dropdown_links_fontawesome_icon_margin_right'].' !important;
            }
            .'.$location_info[0].' .suppa_submenu.suppa_submenu_pos_right .suppa_UP_icon{
                padding-right: 0 !important;
                padding-left: '.$skin_data['submenu_dropdown_links_normal_icon_margin_right'].' !important;
            }


            /** ----------------------------------------------------------------
             ******** Submenu DropDown Arrow Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_menu_dropdown .suppa_submenu a .era_suppa_arrow_box {
                top:'.$skin_data['dropdown-links-arrow_position_top'].' !important;
                right:'.$skin_data['dropdown-links-arrow_position_right'].';
            }
            .'.$location_info[0].' .suppa_menu_dropdown .suppa_submenu a .era_suppa_arrow_box span {
                font-size:'.$skin_data['dropdown-links-arrow_width'].' !important;
                /* color/bg/border */
                color:'.$skin_data['dropdown-links-arrow_color'].';
            }
            .'.$location_info[0].' .suppa_menu_dropdown div:hover > a .era_suppa_arrow_box span {
                color:'.$skin_data['dropdown-links_arrow_color_hover'].' !important;
            }

            /** Needed for suppa_frontend.js **/
            .'.$location_info[0].' .suppa_menu_class_dropdown_levels_hover > a .era_suppa_arrow_box span{
                color:'.$skin_data['dropdown-links_arrow_color_hover'].' !important;
            }

            /** Open Sub Right **/
            .'.$location_info[0].' .suppa_submenu.suppa_submenu_pos_right .suppa_fa_carret_left{
                right: auto !important;
                left: '.$skin_data['dropdown-links-arrow_position_right'].';
            }
            .'.$location_info[0].' .suppa_submenu.suppa_submenu_pos_right .suppa_fa_carret_right {
                display:none !important;
            }

            /** Open Sub Left **/
            .'.$location_info[0].' .suppa_submenu.suppa_submenu_pos_left .suppa_fa_carret_left{
                display: none !important;
            }

            /** ----------------------------------------------------------------
             ******** Current Top Level Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu a.current-menu-item .suppa_item_title ,
            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu a.current-menu-item .ctf_suppa_fa_box,
            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu a.current-menu-item .suppa_item_title{
                color:'.$skin_data['submenu_current_link_color'].' ;
            }

            .'.$location_info[0].' .suppa_menu_dropdown .current-menu-item {
                background-color:'.$skin_data['submenu_current_link_bg'].';
            }

            .'.$location_info[0].' .suppa_menu_dropdown > .suppa_submenu a.current-menu-item .era_suppa_arrow_box span{
                color:'.$skin_data['submenu_current_link_arrow_color'].';
            }




            /** ----------------------------------------------------------------
             ******** Search Form Style
             ---------------------------------------------------------------- **/

             /** Form **/
            .'.$location_info[0].' .suppa_menu_search form {
                margin-top:'.$skin_data['submenu-search_margin_top'].';
                margin-right:'.$skin_data['submenu-search_margin_right'].';
                margin-left:'.$skin_data['submenu-search_margin_left'].';
                width:'.$skin_data['submenu-search-input_width'].';

            }

            /* Input */
            .'.$location_info[0].' input{
                background-color:'.$skin_data['submenu-search-input_bg_color'].';
                width:'.$skin_data['submenu-search-input_width'].';
                height:'.$skin_data['submenu-search-input_height'].';
                color:'.$skin_data['submenu-search-text_font_font_color'].' !important;

                padding-left:'.$skin_data['submenu-search-text_padding_left'].';
                padding-right:'.$skin_data['submenu-search-text_padding_right'].';

                font-size:'.$skin_data['submenu-search-text_font_font_size'].';
                font-family:'.$skin_data['submenu-search-text_font_font_family'].';
                '.$skin_data['submenu-search-text_font_font_family_style'].'

                -webkit-border-radius:'.$skin_data['search_input_border_radius'].' !important;
                -moz-border-radius:'.$skin_data['search_input_border_radius'].' !important;
                border-radius:'.$skin_data['search_input_border_radius'].' !important;

                border:1px solid '.$skin_data['menu_bg_bg_color'].';
            }
            .'.$location_info[0].' .suppa_menu_search ::-webkit-input-placeholder { /* WebKit browsers */
                color:'.$skin_data['submenu-search-text_font_font_color'].' !important;
            }
            .'.$location_info[0].' .suppa_menu_search :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
                color:'.$skin_data['submenu-search-text_font_font_color'].' !important;
                opacity:  1;
            }
            .'.$location_info[0].' .suppa_menu_search ::-moz-placeholder { /* Mozilla Firefox 19+ */
                color:'.$skin_data['submenu-search-text_font_font_color'].' !important;
                opacity:  1;
            }
            .'.$location_info[0].' .suppa_menu_search :-ms-input-placeholder { /* Internet Explorer 10+ */
                color:'.$skin_data['submenu-search-text_font_font_color'].' !important;
            }


            /* Normal: Form */
            .'.$location_info[0].' .suppa_search_normal form {
                height:'.$skin_data['submenu-search-input_height'].';
                width:'.$skin_data['submenu-search-input_width'].';
            }

            /* Normal : Search Icon */
            .'.$location_info[0].' .suppa_search_normal .suppa_search_icon{
                font-size:'.$skin_data['submenu-search-button_icon_size'].' !important;
                height:'.$skin_data['submenu-search-input_height'].';
                line-height:'.$skin_data['submenu-search-input_height'].';
                background-color:'.$skin_data['submenu-search-button_bg_color'].';

                border-radius: 0 '.$skin_data['search_input_border_radius'].' '.$skin_data['search_input_border_radius'].' 0 !important;

            }
            .'.$location_info[0].' .suppa_search_normal .suppa_search_icon span{
                color:'.$skin_data['submenu-search-button_icon_color'].';
                padding-left:'.$skin_data['search_padding_left'].';
                padding-right:'.$skin_data['search_padding_right'].';
            }


            /** Boxed **/
            .'.$location_info[0].' .suppa_search_boxed form {
                margin-bottom:'.$skin_data['submenu-search_margin_top'].';
            }

            /** Boxed : Top Icon **/
            .'.$location_info[0].' .suppa_top_level_link.suppa_search_icon{
                color:'.$skin_data['submenu-search-button_icon_color'].';
                padding-top:'.$skin_data['search_padding_top'].';
                padding-left:'.$skin_data['search_padding_left'].';
                padding-right:'.$skin_data['search_padding_right'].';
                height:'.( (int)$skin_data['menu_height'] - (int)$skin_data['search_padding_top'] ).'px !important;
            }
            .'.$location_info[0].' .suppa_menu:hover .suppa_top_level_link.suppa_search_icon{
                color:'.$skin_data['submenu-search-button_icon_color'].';
            }
            .'.$location_info[0].' .suppa_menu .suppa_top_level_link .ctf_suppa_fa_box{
                font-size:'.$skin_data['fontawesome_icons_size'].' !important;
                margin-top: '.$skin_data['top-links-fontawesome_icon_margin_top'].' !important;
                padding-right: '.$skin_data['top-links-fontawesome_icon_margin_right'].' !important;
            }

            /* Modern */
            .'.$location_info[0].' .suppa_submenu_modern_search{
                z-index:'.( (int)$skin_data['menu_z_index'] + 19999 ).';
                height:'.(int)$skin_data['menu_height'].'px !important;
            }
            .'.$location_info[0].' .suppa_submenu_modern_search form,
            .'.$location_info[0].' .suppa_submenu_modern_search input{
                height:'.(int)$skin_data['menu_height'].'px !important;
            }

            /* Modern : Close Icon */
            .'.$location_info[0].' .suppa_submenu_modern_search .suppa_search_modern_close{
                z-index:'.( (int)$skin_data['menu_z_index'] + 20001 ).';
                padding-top:'.$skin_data['search_padding_top'].';
                padding-left:'.$skin_data['search_padding_left'].';
                padding-right:'.$skin_data['search_padding_right'].';
                height:'.( (int)$skin_data['menu_height'] - (int)$skin_data['search_padding_top'] ).'px !important;
                font-size:'.$skin_data['fontawesome_icons_size'].' !important;
                color:'.$skin_data['submenu-search-text_font_font_color'].' !important;
            }

            /** ----------------------------------------------------------------
             ******** Responsive Web Design Style
             ---------------------------------------------------------------- **/

            .'.$location_info[0].' .suppa_rwd_top_button_container{
                height:'.$skin_data['menu_height'].' !important;
                background-color:'.$skin_data['menu_bg_bg_color'].';

                /* CSS3 Gradient */
                background-image: -webkit-linear-gradient(top, '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: -moz-linear-gradient(top, '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: -o-linear-gradient(top, '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: -ms-linear-gradient(top, '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;
                background-image: linear-gradient(top, '.$skin_data['menu_bg_gradient_from'].', '.$skin_data['menu_bg_gradient_to'].') ;

                '.$menu_background.'

                /* Borders */
                border-top: '.$skin_data['menu_border_top_size'].' solid '.$skin_data['menu_border_top_color'].';
                border-right: '.$skin_data['menu_border_right_size'].' solid '.$skin_data['menu_border_right_color'].';
                border-bottom: '.$skin_data['menu_border_bottom_size'].' solid '.$skin_data['menu_border_bottom_color'].';
                border-left: '.$skin_data['menu_border_left_size'].' solid '.$skin_data['menu_border_left_color'].';
            }

            .'.$location_info[0].' .suppa_rwd_menus_container {
                /* color/bg/border */
                background-color:'.$skin_data['submenu-bg_bg_color'].';

                /* CSS3 Gradient */
                background-image: -webkit-linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: -moz-linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: -o-linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: -ms-linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
            }


            /* Top Button & Text */
            .'.$location_info[0].' .suppa_rwd_button,
            .'.$location_info[0].' .suppa_rwd_text {
                line-height:'.$skin_data['menu_height'].' !important;
            }
            .'.$location_info[0].' .suppa_rwd_button {
                padding-right:'.$skin_data['rwd_3bars_icon_right_margin'].' !important;
                padding-left:'.$skin_data['rwd_3bars_icon_right_margin'].' !important;
                line-height:'.$skin_data['menu_height'].' !important;
            }
            .'.$location_info[0].' .suppa_rwd_button,
            .'.$location_info[0].' .suppa_rwd_button span{
                font-size:'.$skin_data['rwd_3bars_icon_size'].' !important;
                color:'.$skin_data['rwd_3bars_icon_color'].';
            }
            .'.$location_info[0].' .suppa_rwd_text{
                font-size:'.$skin_data['rwd_text_font_font_size'].'px !important;
                font-family:'.$skin_data['rwd_text_font_font_family'].' !important;
                '.$skin_data['rwd_text_font_font_family_style'].'
                color :'.$skin_data['rwd_text_font_font_color'].' !important;

                padding: 0px '.$skin_data['rwd_text_left_margin'].' !important;
                line-height:'.$skin_data['menu_height'].' !important;
            }


            /* Submenu for latest posts, mega links, mega posts, html */
            .'.$location_info[0].' .suppa_mega_posts_allposts_posts,
            .'.$location_info[0].' .suppa_rwd_submenu_posts,
            .'.$location_info[0].' .suppa_rwd_submenu_html,
            .'.$location_info[0].' .suppa_rwd_submenu_columns_wrap {
                background-color:'.$skin_data['submenu-bg_bg_color'].';
                border-bottom: '.$skin_data['submenu-border-bottom_size'].' solid '.$skin_data['submenu-border-bottom_color'].';

                /* CSS3 Gradient */
                background-image: -webkit-linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: -moz-linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: -o-linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: -ms-linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;
                background-image: linear-gradient(top, '.$skin_data['submenu-bg-gradient_from'].', '.$skin_data['submenu-bg-gradient_to'].') ;

                '.$submenu_background_image.'

                /* Padding */
                padding-top:'.$skin_data['rwd_submenu_padding_top'].' !important;
                padding-bottom:'.$skin_data['rwd_submenu_padding_bottom'].' !important;
                padding-right:'.$skin_data['rwd_submenu_padding_right'].' !important;
                padding-left:'.$skin_data['rwd_submenu_padding_left'].' !important;

                /* CSS3 Box Shadow */
                -moz-box-shadow   : 0px 0px '.$skin_data['submenu-boxshadow_blur'].' '.$skin_data['submenu-boxshadow_distance'].' '.$skin_data['submenu-boxshadow_color'].';
                -webkit-box-shadow: 0px 0px '.$skin_data['submenu-boxshadow_blur'].' '.$skin_data['submenu-boxshadow_distance'].' '.$skin_data['submenu-boxshadow_color'].';
                box-shadow        : 0px 0px '.$skin_data['submenu-boxshadow_blur'].' '.$skin_data['submenu-boxshadow_distance'].' '.$skin_data['submenu-boxshadow_color'].';
            }


            /* Main Links */
            .'.$location_info[0].' .suppa_rwd_menu > a,
            .'.$location_info[0].' .suppa_rwd_submenu_mega_posts > a,
            .'.$location_info[0].' .suppa_rwd_submenu > .suppa_dropdown_item_container > a {
                font-size:'.$skin_data['rwd_main_links_font_font_size'].'px !important;
                font-family:'.$skin_data['rwd_main_links_font_font_family'].' !important;
                '.$skin_data['rwd_main_links_font_font_family_style'].'
                color :'.$skin_data['rwd_main_links_font_font_color'].';

                height:'.$skin_data['rwd_main_links_height'].' !important;
                line-height:'.$skin_data['rwd_main_links_height'].' !important;
                border-bottom:1px solid '.$skin_data['rwd_main_links_bottom_border_color'].' !important;
                background-color:'.$skin_data['rwd_main_links_bg'].';
            }
            .'.$location_info[0].' .suppa_rwd_menu > a .suppa_item_title,
            .'.$location_info[0].' .suppa_rwd_submenu_mega_posts > a .suppa_item_title,
            .'.$location_info[0].' .suppa_rwd_submenu > .suppa_dropdown_item_container > a .suppa_item_title{
                font-size:'.$skin_data['rwd_main_links_font_font_size'].'px !important;
                font-family:'.$skin_data['rwd_main_links_font_font_family'].' !important;
                '.$skin_data['rwd_main_links_font_font_family_style'].'
                color :'.$skin_data['rwd_main_links_font_font_color'].';
            }

            .'.$location_info[0].' .era_rwd_suppa_link_both_open,
            .'.$location_info[0].' .suppa_rwd_menu:hover > a,
            .'.$location_info[0].' .suppa_rwd_submenu_mega_posts > a:hover,
            .'.$location_info[0].' .suppa_rwd_menu .suppa_dropdown_item_container a:hover {
                color :'.$skin_data['rwd-main_links_color_hover'].' !important;
                background-color :'.$skin_data['rwd_main_links_bg_hover'].' !important;
            }
            .'.$location_info[0].' .era_rwd_suppa_link_both_open .suppa_item_title,
            .'.$location_info[0].' .suppa_rwd_menu:hover > a .suppa_item_title,
            .'.$location_info[0].' .suppa_rwd_submenu_mega_posts > a:hover .suppa_item_title,
            .'.$location_info[0].' .suppa_rwd_menu .suppa_dropdown_item_container a:hover .suppa_item_title{
                color :'.$skin_data['rwd-main_links_color_hover'].' !important;
            }
            .'.$location_info[0].' .suppa_rwd_menus_container{
                border-top:1px solid '.$skin_data['rwd_main_links_bottom_border_color'].' !important;
            }

            .'.$location_info[0].' .suppa_rwd_menu > a{
                padding-left:'.$skin_data['rwd_main_links_left_margin'].' !important;
            }
            .'.$location_info[0].' .suppa_rwd_menu_dropdown > .suppa_rwd_submenu > .suppa_dropdown_item_container > a {
                padding-left:'.( (int)$skin_data['rwd_main_links_left_margin'] * 1.8 ).'px !important;
            }
            .'.$location_info[0].' .suppa_rwd_menu_dropdown > .suppa_rwd_submenu > .suppa_dropdown_item_container > .suppa_rwd_submenu > .suppa_dropdown_item_container > a {
                padding-left:'.( (int)$skin_data['rwd_main_links_left_margin'] * 2.8 ).'px !important;
            }
            .'.$location_info[0].' .suppa_rwd_menu_dropdown > .suppa_rwd_submenu > .suppa_dropdown_item_container > .suppa_rwd_submenu > .suppa_dropdown_item_container > .suppa_rwd_submenu > .suppa_dropdown_item_container > a {
                padding-left:'.( (int)$skin_data['rwd_main_links_left_margin'] * 3.8 ).'px !important;
            }

            /* Main Links Arrows */
            .'.$location_info[0].' .suppa_rwd_menu > a .era_rwd_suppa_arrow_box {
                font-size:'.$skin_data['rwd_main_links_arrow_width'].' !important;

                /* color/bg/border */
                color:'.$skin_data['rwd_main_links_arrow_color'].';
            }
            .'.$location_info[0].' .suppa_rwd_menu:hover > a .era_rwd_suppa_arrow_box {
                color:'.$skin_data['rwd_main_links_arrow_color_hover'].' !important;
            }
            .'.$location_info[0].' .era_rwd_suppa_arrow_both_open{
                color :'.$skin_data['rwd_main_links_font_font_color'].' !important;
                background-color:'.$skin_data['rwd_main_links_bg'].' !important;
            }
            .'.$location_info[0].' .era_rwd_suppa_link_both_open{
                color :'.$skin_data['rwd-main_links_color_hover'].' !important;
                background-color :'.$skin_data['rwd_main_links_bg_hover'].' !important;
            }

            /* Search Form */
            .'.$location_info[0].' .suppa_rwd_search{
                border-bottom:1px solid '.$skin_data['rwd_main_links_bottom_border_color'].' !important;
            }
            .'.$location_info[0].' .suppa_rwd_search{
                padding-top:'.$skin_data['rwd_submenu_padding_top'].' !important;
                padding-bottom:'.$skin_data['rwd_submenu_padding_bottom'].' !important;
                padding-right:'.$skin_data['rwd_submenu_padding_right'].' !important;
                padding-left:'.$skin_data['rwd_submenu_padding_left'].' !important;

            }
            .'.$location_info[0].' .suppa_rwd_search input[type="text"]{
                background-color:'.$skin_data['submenu-search-input_bg_color'].';
                height:'.$skin_data['submenu-search-input_height'].';
                line-height:'.$skin_data['submenu-search-input_height'].';
                color:'.$skin_data['submenu-search-text_font_font_color'].' !important;

                padding-left:'.$skin_data['submenu-search-text_padding_left'].';
                padding-right:'.$skin_data['submenu-search-text_padding_right'].';

                font-size:'.$skin_data['submenu-search-text_font_font_size'].';
                font-family:'.$skin_data['submenu-search-text_font_font_family'].';
                '.$skin_data['submenu-search-text_font_font_family_style'].'

                -webkit-border-radius:'.$skin_data['search_input_border_radius'].';
                -moz-border-radius:'.$skin_data['search_input_border_radius'].';
                border-radius:'.$skin_data['search_input_border_radius'].';

                border:1px solid '.$skin_data['menu_bg_bg_color'].';
            }


            /* Mega Posts */
            .'.$location_info[0].' .suppa_rwd_submenu_mega_posts > a {
                padding-left:'.( (int)$skin_data['rwd_main_links_left_margin'] * 2 ).'px !important;
            }


            /** ----------------------------------------------------------------
             ******** RWD Icons Style
             ---------------------------------------------------------------- **/
            .'.$location_info[0].' .suppa_rwd_menu > a .ctf_suppa_fa_box,
            .'.$location_info[0].' .suppa_rwd_menu .suppa_dropdown_item_container .ctf_suppa_fa_box{
                color :'.$skin_data['rwd_main_links_font_font_color'].';

            }
            .'.$location_info[0].' .era_rwd_suppa_link_both_open .ctf_suppa_fa_box,
            .'.$location_info[0].' .suppa_rwd_menu:hover > a .ctf_suppa_fa_box,
            .'.$location_info[0].' .suppa_rwd_menu .suppa_dropdown_item_container a:hover .ctf_suppa_fa_box {
                color :'.$skin_data['rwd-main_links_color_hover'].' !important;
            }


            /** F.Awesome Icons **/
            .'.$location_info[0].' .suppa_rwd_menu > a .suppa_FA_icon,
            .'.$location_info[0].' .suppa_rwd_menu .suppa_dropdown_item_container .suppa_FA_icon
             {
                font-size:'.$skin_data['rwd_links_fontawesome_icons_size'].' !important;
                padding-top: '.$skin_data['rwd_links_fontawesome_icon_margin_top'].' !important;
                padding-right: '.$skin_data['rwd_links_fontawesome_icon_margin_right'].' !important;
            }

            /** Uploaded Icons **/
            .'.$location_info[0].' .suppa_rwd_menu > a .suppa_UP_icon,
            .'.$location_info[0].' .suppa_rwd_menu .suppa_dropdown_item_container a .suppa_UP_icon
             {
                width : '.$skin_data['rwd_links_uploaded_icons_width'].' !important;
                height : '.$skin_data['rwd_links_uploaded_icons_height'].' !important;
                padding-top: '.$skin_data['rwd_links_normal_icon_margin_top'].' !important;
                padding-right: '.$skin_data['rwd_links_normal_icon_margin_right'].' !important;
            }

        ';
        $custom_css .= $skin_data['custom-css'];

        // Create the css file
		$my_file 	= $css_folder . $location_info[0] . '.css';
		$handle 	= 	@fopen($my_file, 'w');
						@fwrite($handle, $custom_css);
						@fclose($handle);


		/** Create JS file **/
        /** Suppa JS Parameters **/
        $site_url = site_url();
        if( is_multisite() )
        {
            $site_url = network_site_url();
        }

        $suppa_settings = "
        suppa_js_settings = new Object();
        suppa_js_settings.jquery_trig       = '".$skin_data['settings-jquery_trigger']."';
        suppa_js_settings.jquery_anim       = '".$skin_data['settings-jquery_animation']."';
        suppa_js_settings.jquery_easings    = '".$skin_data['settings-jquery_easings']."';
        suppa_js_settings.jquery_time       = ".(int)$skin_data['settings-jquery_animation_time'].";
        suppa_js_settings.rwd_enable        = '".$skin_data['settings-responsive_enable']."';
        suppa_js_settings.rwd_start_width   = ".(int)$skin_data['settings_responsive_start_width'].";
        suppa_js_settings.rwd_text          = '".$skin_data['settings-responsive_text']."';
        suppa_js_settings.box_layout        = '".$skin_data['menu-layout']."';
        suppa_js_settings.modern_search     = '".$skin_data['settings_modern_search']."';
        suppa_js_settings.rwd_search        = '".$skin_data['settings_rwd_search_form_display']."';
        suppa_js_settings.logo_enable       = '".$skin_data['logo_enable']."';
        suppa_js_settings.rwd_logo_enable   = '".$skin_data['rwd_logo_enable']."';
        suppa_js_settings.logo_src          = '".$skin_data['logo_src']."';
        suppa_js_settings.logo_retina_src   = '".$skin_data['logo_retina_src']."';
        suppa_js_settings.rwd_logo_src      = '".$skin_data['rwd_logo_src']."';
        suppa_js_settings.rwd_logo_retina_src   = '".$skin_data['rwd_logo_retina_src']."';
        suppa_js_settings.site_url          = '".$site_url."';
        suppa_js_settings.recent_posts_view_all = '".$skin_data['latest_posts_view_all']."';

	    jQuery('.".$location_info[0]."').suppamenu( suppa_js_settings );

        ";

        /** Save Generated Settings To File **/
        $my_file    = 	$js_folder . $location_info[0] . '.js' ;
        $handle     = 	@fopen($my_file, 'w');
        				@fwrite($handle, $suppa_settings);
        				@fclose($handle);
	}

	}
}// End IF