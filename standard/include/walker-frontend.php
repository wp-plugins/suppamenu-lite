<?php

/*
|   Suppa Back-End Menu Walker
|
|*/


if( !class_exists( 'suppa_menu_walker' ) )
{

    /**
     * This walker is for the frontend
     */
    class suppa_menu_walker extends Walker {

        /**
         * @see Walker::$tree_type
         * @var string
         */
        var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
        /**
         * @see Walker::$db_fields
         * @todo Decouple this.
         * @var array
         */
        var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );


        /**
         * Suppa Menu Variables
         */
        var $menu_type                      = '';
        var $menu_key                       = '_menu-item-suppa-';
        var $top_level_counter              = 0;
        var $dropdown_first_level_conuter   = 0;
        var $dropdown_second_level_conuter  = 0;
        var $dropdown_sub_open_pos          = '';
        var $column                         = 0;
        var $dropdown_width                 = "180px";
        var $dropdown_position              = "left";
        var $links_column_width             = "180px";
        var $mega_posts_items               = array();
        var $suppa_item_id                  = 0;
        var $linksTwo_parentLink_ID         = 0;
        var $linksTwo_childsContainer       = "";
        var $megaLinksTwo_first_item		= true;

        var $thumb_sizes                    = array();
        var $skin_options                   = array();

        function __construct( $skin_options = array(), $thumb_sizes = array() ){
            $this->skin_options = $skin_options;
            $this->thumb_sizes  = $thumb_sizes;
        }

        /**
         * @see Walker::start_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        function start_lvl(&$output, $depth = 0, $args = array())
        {
            // DropDown
            if( $this->menu_type == 'dropdown' )
            {
                if( $depth >= 1 )
                    $output = str_replace("<span class=\"suppa_ar_arrow_right_".$this->dropdown_first_level_conuter.'_'.$depth."\"></span>", '<span class="era_suppa_arrow_box suppa_fa_carret_right"><span aria-hidden="true" class="suppa-caret-right"></span></span><span class="era_suppa_arrow_box suppa_fa_carret_left"><span aria-hidden="true" class="suppa-caret-left"></span></span>' , $output );

                $css_left = '0px';
                if( $depth != 0 )
                    $css_left = $this->dropdown_width;

                $output .= '<div class="suppa_submenu suppa_submenu_'.$depth.' '.$this->dropdown_sub_open_pos.'" style="width:'.$this->dropdown_width.';'.$this->dropdown_position.':'.$css_left.';" >';
            }

        }


        /**
         * @see Walker::end_lvl()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param int $depth Depth of page. Used for padding.
         */
        function end_lvl(&$output, $depth = 0, $args = array())
        {
            global $wp_query;

            // Dropdown
            if( $this->menu_type == 'dropdown' )
            {
                $output .= '</div>';
            }

        }

        /**
         * @see Walker::start_el()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param int $current_page Menu item ID.
         * @param object $args
         */
        function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {

            global $wp_query;

            // Link Meta
            $item_meta = get_post_meta( $item->ID );

            // Link attributes
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

            // Link Icon
            $link_title = $item->title;
            $icon_type  = @$item_meta['_menu-item-suppa-link_icon_type'][0];
            $icon       = @$item_meta['_menu-item-suppa-link_icon_image'][0];
            $icon_hover = @$item_meta['_menu-item-suppa-link_icon_image_hover'][0];
            $icon_only  = @$item_meta['_menu-item-suppa-link_icon_only'][0];
            $FA_icon    = @$item_meta['_menu-item-suppa-link_icon_fontawesome'][0];
            $link_html  = "";

            // Link Classes
            $class_names = '';
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
            $class_names = esc_attr( $class_names );
            if( $depth === 0 )
            {
                $class_names .= ' suppa_top_level_link';
            }

            // Item Description
            $description    = ! empty( $item->description ) ? '<span class="suppa_item_desc">'.$item->description.'</span>' : '';

            // Item Icon
            if( $icon_type == "upload" ){
                if( $icon != "" ){
                    $check_retina_icon  = ( $icon_hover != "" ) ? $icon_hover : $icon;
                    $check_icon_only    = ( $icon_only == "on" ) ? '' : '<span class="suppa_item_title">'.$link_title.$description.'</span>' ;
                    $link_html = '<img class="suppa_upload_img suppa_UP_icon" src="'.$icon.'" alt="'.$link_title.'" data-icon="'.$icon.'" data-retina="'.$check_retina_icon.'" >'.$check_icon_only;
                }
                else{
                    $link_html = '<span class="suppa_item_title">'.$link_title.$description.'</span>';
                }
            }
            else if( $icon_type == "fontawesome" ){
                if( $FA_icon != "" ){
                    $check_icon_only    = ( $icon_only == "on" ) ? '' : '<span class="suppa_item_title">'.$link_title.$description.'</span>';
                    $link_html = '<span class="ctf_suppa_fa_box suppa_FA_icon"><span aria-hidden="true" class="'.$FA_icon.'" ></span></span>'.$check_icon_only;
                }
                else{
                    $link_html = '<span class="suppa_item_title">'.$link_title.$description.'</span>';
                }
            }
            else{
                $link_html = '<span class="suppa_item_title">'.$link_title.$description.'</span>';
            }

            // If Level 0
            if( $depth === 0 ){

            	$this->megaLinksTwo_first_item = true;
            	$this->linksTwo_childsContainer = "";

                $this->top_level_counter += 1;
                $this->menu_type =  @$item_meta[$this->menu_key.'menu_type'][0];

                $this_item_position =  @$item_meta[$this->menu_key.'link_position'][0];
                $this_item_position_class = ' suppa_menu_position_'.$this_item_position.' ';
                $class_names .= $this_item_position_class;

                $this_item_position_css = ( $this_item_position == "right" || $this_item_position == "none" ) ? ' float:none; ' : ' float:left; ';

                // User Log in/out/both
                $is_user_logged_in = is_user_logged_in();
                $user_logged_in_out =  @$item_meta[$this->menu_key.'link_user_logged'][0];
                $display_item = ' display:none !important; ';
                if( $user_logged_in_out == 'both' )
                { $display_item = ''; }
                else if ( $user_logged_in_out == 'logged_in' && $is_user_logged_in )
                { $display_item = ''; }
                else if ( $user_logged_in_out == 'logged_out' && !$is_user_logged_in )
                { $display_item = ''; }

                // Dropdown
                if( 'dropdown' == $this->menu_type ){
                    $this->dropdown_width =  @$item_meta[$this->menu_key.'dropdown_width'][0];
                    if( @$item_meta[$this->menu_key.'dropdown_open_pos'][0] != '' ){
                        $this->dropdown_position =  'right';
                        $this->dropdown_sub_open_pos = 'suppa_submenu_pos_right';
                    }
                    else{
                        $this->dropdown_position =  'left';
                        $this->dropdown_sub_open_pos = 'suppa_submenu_pos_left';
                    }

                    $arrow = '';
                    $has_arrow = '';
                    if( in_array( 'menu-item-has-children' , $item->classes ) ){
                        $has_arrow = ' suppa_top_links_has_arrow ';
                        $arrow = '<span class="era_suppa_arrow_box ctf_suppa_fa_box_top_arrow"><span aria-hidden="true" class="suppa-caret-down"></span></span>';
                    }

                    $item_output = '<div style="'.$this_item_position_css.' '.$display_item.'" class="'.$item->classes[0].' suppa_menu suppa_menu_dropdown suppa_menu_'.$this->top_level_counter.'" ><a '.$attributes.' class="'.$class_names.' '.$has_arrow.'" >'.$link_html.$arrow.'</a>';
                    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
                }

                // Posts
                else if( 'posts' == $this->menu_type ){

                    $output .= '<div style="'.$this_item_position_css.$display_item.'" class="'.$item->classes[0].' suppa_menu suppa_menu_posts suppa_menu_'.$this->top_level_counter.'">';

                    // Reset the query
                    wp_reset_query();

                    // The Query : Load All Posts
                    $post_category =  @$item_meta[$this->menu_key.'posts_category'][0];
                    if( !preg_match('/^[0-9]+$/', $post_category) )
                    {
                        $args = array(
                            'suppress_filters'  => true,
                            'post_type'         => $post_category,
                            'posts_per_page'    => @$item_meta[$this->menu_key.'posts_number'][0]
                        );
                    }
                    else
                    {
                        $args = array(
                            'suppress_filters'  => true,
                            'post_type'         => 'any',
                            'posts_per_page'    =>  @$item_meta[$this->menu_key.'posts_number'][0],
                            'tax_query'         => array(
                                array(
                                    'taxonomy'  =>  @$item_meta[$this->menu_key.'posts_taxonomy'][0],
                                    'field'     => 'id',
                                    'terms'     =>  @(int)$item_meta[$this->menu_key.'posts_category'][0]
                                )
                            )
                        );
                    }

                    $the_query = new WP_Query( $args );

                    $posts_wrap = '';
                    $posts_view_all = '';
                    $has_arrow = ' suppa_top_links_has_arrow ';
                    $upload_dir = wp_upload_dir();

                    // The Loop
                    if( $the_query->have_posts() ) :

                    $output .= '<a class="'.$class_names.' '.$has_arrow.'" '.$attributes.' >'.$link_html.'<span class="era_suppa_arrow_box ctf_suppa_fa_box_top_arrow"><span aria-hidden="true" class="suppa-caret-down"></span></span></a>';
                    $output .= '<div class="suppa_submenu suppa_submenu_posts" >';

                    while ( $the_query->have_posts() ) :
                        $the_query->the_post();

                        $id     = get_the_ID();
                        //$thumb    = wp_get_attachment_thumb_url( get_post_thumbnail_id( $id ) );
                        $imgurl = wp_get_attachment_url( get_post_thumbnail_id( $id ) );
                        $retina = $imgurl;

                        $resized_width  = $this->thumb_sizes['recent'][0];
                        $resized_height = $this->thumb_sizes['recent'][1];

                        // If Resize Enable
                        if( suppa_walkers::$project_settings['image_resize'] )
                        {
                            $resized_img = preg_replace("/\.[a-zA-z]{1,4}$/", "", $imgurl);
                            $resized_ext = preg_match("/\.[a-zA-z]{1,4}$/", $imgurl, $matches);

                            $path = explode('uploads',$resized_img);

                            $resized_path = "";
                            $retina_path = "";

                            if( isset($matches[0]) )
                            {
                                $tmp_resized = $resized_img;

                                $resized_img = $tmp_resized.'-'.$resized_width.'x'.$resized_height.$matches[0];
                                $retina_img  = $tmp_resized.'-'.$resized_width.'x'.$resized_height.'@2x'.$matches[0];

                                $resized_path= $upload_dir['basedir'].$path[1].'-'.$resized_width.'x'.$resized_height.$matches[0];
                                $retina_path = $upload_dir['basedir'].$path[1].'-'.$resized_width.'x'.$resized_height.'@2x'.$matches[0];
                            }

                            // Detect if image exists
                            if( file_exists($resized_path) )
                            {
                                $imgurl = $resized_img;
                            }

                            // Detect if retina image exists
                            if( file_exists($retina_path) )
                            {
                                $retina = $retina_img;
                            }

                        }
                        $post_title     = get_the_title();
                        $post_link      = get_permalink();
                        $post_date      = '<span class="suppa_post_link_date">'.get_the_date().'</span>';
                        $post_comment_n = '<span class="suppa_post_link_comments">'.get_comments_number().'</span>';

                        $posts_wrap .= '<div class="suppa_post" >';
                        $posts_wrap .= '<a href="'.$post_link.'" title="'.$post_title.'" >';
                        $posts_wrap .= '<img style="width:'.$resized_width.'px;height:'.$resized_height.'px;" class="suppa_lazy_load '. $this->thumb_sizes['hover'] .'" data-original="'.$imgurl.'" data-retina="'.$retina.'" alt="'.$post_title.'" />';
                        $posts_wrap .= '<div class="suppa_post_link_container" ><span class="suppa_post_link_title">'.$post_title.'</span></div>';
                        $posts_wrap .= '</a><div class="suppa_clearfix"></div></div><!--suppa_post-->';

                    endwhile;

                    /* Restore original Post Data
                     * NB: Because we are using new WP_Query we aren't stomping on the
                     * original $wp_query and it does not need to be reset.
                    */
                    wp_reset_postdata();

                    $posts_view_all = '<a href="'.$item->url.'" class="suppa_latest_posts_view_all">'. __('View All...','suppa_menu') .'</a>';
                    $output .= $posts_wrap.$posts_view_all.'</div>';

                    else:

                    $output .= '<a class="'.$class_names.'" '.$attributes.' >'.$link_html.'</a>';

                    endif;

                    $output .= '</div>';
                }


                // Search Form
                else if( 'search' == $this->menu_type ){

                    $search_text =  @$item_meta[$this->menu_key.'search_text'][0];

                    // Normal
                    if( $this->skin_options['settings_modern_search'] == 'normal' ){
                        $output .= '<div style="'.$this_item_position_css.$display_item.'" class="'.$item->classes[0].' suppa_menu suppa_menu_search suppa_search_normal suppa_menu_'.$this->top_level_counter.'">';
                        $output .= '    <form action="'.get_bloginfo('url').'" method="get" >';
                        $output .= '        <input type="text" name="s" class="suppa_search_input" value="" placeholder="'.$search_text.'" >';
                        $output .= '        <button class="suppa_search_icon" type="submit">
                                                <span aria-hidden="true" class="suppa-search"></span>
                                            </button>
                                        </form>';
                        $output .= '</div>';
                    }

                    // Boxed
                    else if( $this->skin_options['settings_modern_search'] == 'boxed' ){
                        $output .= '<div style="'.$this_item_position_css.$display_item.'" class="'.$item->classes[0].' suppa_menu suppa_menu_search suppa_search_boxed suppa_menu_'.$this->top_level_counter.'" >';
                        $output .= '<span aria-hidden="true" class="suppa_top_level_link suppa_search_icon suppa-search"></span>';
                        $output .= '<div class="suppa_submenu" style="'.@$item_meta[$this->menu_key.'link_position'][0].':0px !important;" >';
                        $output .= '    <form action="'.get_bloginfo('url').'" method="get" >';
                        $output .= '        <input type="text" name="s" class="suppa_search_input" value="" placeholder="'.$search_text.'" >';
                        $output .= '    </form>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }

                    // Modern
                    else if( $this->skin_options['settings_modern_search'] == 'modern' ){
                        $output .= '<div style="'.$this_item_position_css.$display_item.'" class="'.$item->classes[0].' suppa_menu suppa_menu_search suppa_search_modern suppa_menu_'.$this->top_level_counter.'" >';
                        $output .= '<span aria-hidden="true" class="suppa_top_level_link suppa_search_icon suppa-search"></span>';
                        $output .= '<div class="suppa_submenu_modern_search" >';
                        $output .= '    <form action="'.get_bloginfo('url').'" method="get" >';
                        $output .= '        <input type="text" name="s" class="suppa_search_input" value="" placeholder="'.$search_text.'" >';
                        $output .= '        <span aria-hidden="true" class="suppa_search_modern_close suppa-remove"></span>';
                        $output .= '    </form>';
                        $output .= '</div>';
                        $output .= '</div>';
                    }

                }


            }


            // Dropdown
            if( 'dropdown' == $this->menu_type )
            {
                if( $depth == 1 )
                {
                    $this->dropdown_first_level_conuter += 1;
                    $item_output = '<div class="suppa_dropdown_item_container"><a class="'.$class_names.'" '.$attributes.' >'.$link_html.'<span class="suppa_ar_arrow_right_'.$this->dropdown_first_level_conuter.'_'.$depth.'"></span></a> ';
                    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
                }
                else if( $depth == 2 )
                {
                    $this->dropdown_second_level_conuter += 1;
                    $item_output = '<div class="suppa_dropdown_item_container"><a class="'.$class_names.'" '.$attributes.' >'.$link_html.'<span class="suppa_ar_arrow_right_'.$this->dropdown_second_level_conuter.'_'.$depth.'"></span></a> ';
                    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
                }
                else if( $depth == 3 )
                {
                    $item_output = '<div class="suppa_dropdown_item_container"><a class="'.$class_names.'" '.$attributes.' >'.$link_html.'</span></a> ';
                    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
                }
            }

        }

        /**
         * @see Walker::end_el()
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Page data object. Not used.
         * @param int $depth Depth of page. Not Used.
         */
        function end_el(&$output, $object, $depth = 0, $args = array() )
        {
            global $wp_query;

            // Dropdown
            if( 'dropdown' == $this->menu_type )
            {
                $output .= '</div>';
            }

        }// End Func


    }// End Class
}