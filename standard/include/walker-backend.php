<?php

/*
 |  Suppa Back-End Menu Walker
*/

if( !class_exists( 'suppa_menu_backend_walker' ) ){

    /**
     * @package CTFramework
     * @since 1.0
     * @uses Walker_Nav_Menu
     */
    class suppa_menu_backend_walker extends Walker_Nav_Menu
    {
        protected $suppa_menu_type;
        protected $suppa_menu_father_and_sons_id = 0;
        protected $suppa_all_categories;


        function __construct()
        {
            $this->suppa_all_categories = era_get_categories::all_cats_by_select( 'suppa_all_cats_tax_types', 'suppa_all_cats_tax_types' , '', 0, true );
        }


        /**
         * @see Walker_Nav_Menu::start_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         * @param int $depth Depth of page.
         */
        function start_lvl(&$output, $depth = 0, $args = array() ){}

        /**
         * @see Walker_Nav_Menu::end_lvl()
         * @since 3.0.0
         *
         * @param string $output Passed by reference.
         * @param int $depth Depth of page.
         */
        function end_lvl(&$output, $depth = 0, $args = array() ) {}

        /**
         * @see Walker::start_el()
         * @since 3.0.0
         *
         * @param string $output Passed by reference. Used to append additional content.
         * @param object $item Menu item data object.
         * @param int $depth Depth of menu item. Used for padding.
         * @param int $current_page Menu item ID.
         * @param object $args
         */
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {

            global $_wp_nav_menu_max_depth;
            $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

            ob_start();
            $item_id    = esc_attr( $item->ID );

            $removed_args = array(
                'action',
                'customlink-tab',
                'edit-menu-item',
                'menu-item',
                'page-tab',
                '_wpnonce',
            );

            $original_title = '';
            if ( 'taxonomy' == $item->type ) {
                $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
            } elseif ( 'post_type' == $item->type ) {
                $original_object = get_post( $item->object_id );
                $original_title = $original_object->post_title;
            }

            $classes = array(
                'menu-item menu-item-depth-' . $depth,
                'menu-item-' . esc_attr( $item->object ),
                'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
            );

            $title      = $item->title;

            if ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
                $classes[] = 'pending';
                /* translators: %s: title of menu item in draft status */
                $title = sprintf( __('%s (Pending)','suppa_menu'), $item->title );
            }

            $title = empty( $item->label ) ? $title : $item->label;

            if( $depth == 0 )
            {
                $this->suppa_menu_father_and_sons_id = $this->suppa_menu_father_and_sons_id + 1;
                $this->suppa_menu_type = get_post_meta( $item->ID, '_menu-item-suppa-menu_type', true);
            }

            $depth_class = "suppa_menu_item suppa_menu_father_and_sons_id_" . $this->suppa_menu_father_and_sons_id . " suppa_menu_item_" . $this->suppa_menu_type . " ";

            $item_meta = get_post_meta( $item->ID );

            // Get Menu Type
            $menu_type  = ( @$item_meta['_menu-item-suppa-menu_type'][0] == "" ) ? "dropdown" : @$item_meta['_menu-item-suppa-menu_type'][0];

            ?>

            <li  id="menu-item-<?php echo $item_id; ?>" class="<?php echo $depth_class; echo implode(' ', $classes ); ?>">

                <dl class="menu-item-bar">
                    <dt class="menu-item-handle" style="position:relative;" >
                        <span class="item-title"><?php echo esc_html( $title ); ?></span>
                        <span class="item-controls">
                            <span class="item-type item-type-default"><?php echo "( ".esc_html( $menu_type )." )"; ?></span>
                            <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php _e('Edit Menu Item','suppa_menu'); ?>" href="<?php
                                echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                            ?>"><?php _e( 'Edit Menu Item','suppa_menu' ); ?></a>
                        </span>
                    </dt>
                </dl>

                <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
                    <?php if( 'custom' == $item->type ) : ?>
                        <p class="field-url description description-wide">
                            <label for="edit-menu-item-url-<?php echo $item_id; ?>">
                                <?php _e( 'URL' ,'suppa_menu' ); ?><br />
                                <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
                            </label>
                        </p>
                    <?php endif; ?>
                    <p class="description description-thin description-label avia_label_desc_on_active">
                        <label for="edit-menu-item-title-<?php echo $item_id; ?>">
                        <span class='avia_default_label'><?php _e( 'Navigation Label','suppa_menu' ); ?></span>
                            <br />
                            <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
                        </label>
                    </p>
                    <p class="description description-thin description-title">
                        <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
                            <?php _e( 'Title Attribute','suppa_menu' ); ?><br />
                            <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
                        </label>
                    </p>
                    <p class="field-link-target description description-thin">
                        <label for="edit-menu-item-target-<?php echo $item_id; ?>">
                            <?php _e( 'link Target','suppa_menu' ); ?><br />
                            <select id="edit-menu-item-target-<?php echo $item_id; ?>" class="widefat edit-menu-item-target" name="menu-item-target[<?php echo $item_id; ?>]">
                                <option value="" <?php selected( $item->target, ''); ?>><?php _e('Same window or tab','suppa_menu'); ?></option>
                                <option value="_blank" <?php selected( $item->target, '_blank'); ?>><?php _e('New window or tab','suppa_menu'); ?></option>
                            </select>
                        </label>
                    </p>
                    <p class="field-css-classes description description-thin">
                        <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
                            <?php _e( 'CSS Classes (optional)','suppa_menu' ); ?><br />
                            <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
                        </label>
                    </p>
                    <p class="field-xfn description description-thin">
                        <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
                            <?php _e( 'link Relationship (XFN)' ,'suppa_menu'); ?><br />
                            <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
                        </label>
                    </p>
                    <p class="field-description description description-wide">
                        <label for="edit-menu-item-description-<?php echo $item_id; ?>">
                            <?php _e( 'Description' ,'suppa_menu'); ?><br />
                            <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->post_content ); ?></textarea>
                        </label>
                    </p>

                    <!-- *************** Suppa Options *************** -->
                    <div class="admin_suppa_clearfix"></div>

                    <br/>
                    <br/>

                    <div class='admin_suppa_options'>

                        <!-- *************** new item *************** -->
                        <div class="admin_suppa_box admin_suppa_box_menu_type" >

                            <?php
                                // Menu Type
                                $title  = __( 'Choose the menu type' , 'suppa_menu' );
                                $key    = "menu-item-suppa-menu_type";
                            ?>

                            <div class="admin_suppa_box_header">
                                <span><?php echo $title; ?> :</span>
                                <a>+</a>
                            </div>


                            <div class="admin_suppa_box_container">

                                <!-- Select Menu Type -->
                                <div class="admin_suppa_box_menu_item_types">

                                    <label>
                                        <input type="radio" value="dropdown" class="suppa_menu_type <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" <?php if($menu_type=="dropdown") echo "checked"; ?> /> &nbsp;&nbsp; <?php _e('Use as DropDown','suppa_menu'); ?><br/>
                                    </label>


                                    <label>
                                        <input type="radio" value="posts" class="suppa_menu_type <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" <?php if($menu_type=="posts") echo "checked"; ?> /> &nbsp;&nbsp; <?php _e('Use as Recent Posts','suppa_menu'); ?><br/>
                                    </label>


                                    <label>
                                        <input type="radio" value="search" class="suppa_menu_type <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" <?php if($menu_type=="search") echo "checked"; ?> /> &nbsp;&nbsp; <?php _e('Use as Search Form','suppa_menu'); ?><br/>
                                    </label>

                                    <label>
                                        <input type="radio" value="social" class="suppa_menu_type <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" <?php if($menu_type=="social") echo "checked"; ?> /> &nbsp;&nbsp; <?php _e('Use as Social Media','suppa_menu'); ?><br/>
                                    </label>

                                </div>


                                <br/><br/>


                                <!-- Menu Type : Social -->
                                <div <?php if( 'social' != $menu_type) echo "style='display:none;'"; ?> class="admin_suppa_box_option_inside suppa_box_type admin_suppa_box_option_inside_social">
                                    <?php _e( 'Try To Upload or select an icon from the "Link Settings" under this ' , 'suppa_menu' ); ?>
                                </div>


                                <!-- Menu Type : DropDown -->
                                <div <?php if( 'dropdown' != $menu_type) echo "style='display:none;'"; ?> class="admin_suppa_box_option_inside suppa_box_type admin_suppa_box_option_inside_dropdown">

                                    <?php
                                        // Width
                                        $title  = __( 'Submenu Width' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-dropdown_width";
                                        $value  = @$item_meta['_menu-item-suppa-dropdown_width'][0];

                                        if($value == "") $value = "180px";
                                    ?>

                                    <span class="fl" ><?php echo $title; ?></span>
                                    <input maxlength="7" type="text" value="<?php echo $value; ?>" id="edit-<?php echo $key.'-'.$item_id; ?>" class="fr <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" />

                                    <?php
                                        // Open Sub Postion
                                        $title  = __( 'Open Submenu To Right ?' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-dropdown_open_pos";
                                        $value  = @$item_meta['_menu-item-suppa-dropdown_open_pos'][0];
                                        $checked = ( $value != '' ) ? 'checked' : '' ;
                                    ?>
                                    <div class="admin_suppa_clearfix"></div>
                                    <br/>
                                    <span class="fl" ><?php echo $title; ?></span>
                                    <input <?php echo $checked; ?> type="checkbox" value="on" id="edit-<?php echo $key.'-'.$item_id; ?>" class="fr <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" />

                                    <div class="admin_suppa_clearfix"></div>
                                </div>


                                <!-- Menu Type : Search -->
                                <div <?php if( 'search' != $menu_type) echo "style='display:none;'"; ?> class="admin_suppa_box_option_inside suppa_box_type admin_suppa_box_option_inside_search">

                                    <?php
                                        // Menu Type
                                        $title  = __( 'Search Text' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-search_text";
                                        $value  = @$item_meta['_menu-item-suppa-search_text'][0];

                                        if($value == "") $value = "Search...";
                                    ?>

                                    <span class="fl" ><?php echo $title; ?></span>

                                    <input type="text" value="<?php echo $value; ?>" id="edit-<?php echo $key.'-'.$item_id; ?>" class="fr <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" />

                                    <div class="admin_suppa_clearfix"></div>

                                </div>


                                <!-- Menu Type : Posts -->
                                <div <?php if( 'posts' != $menu_type) echo "style='display:none;'"; ?> class="admin_suppa_box_option_inside suppa_box_type admin_suppa_box_option_inside_posts">

                                    <?php
                                        // Select a Category
                                        $title  = __( 'Select a Category' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-posts_category";
                                        $value  = @$item_meta['_menu-item-suppa-posts_category'][0];

                                        if($value == "")
                                        {
                                            $value = 0;
                                        }

                                        echo $title;

                                    ?>
                                    <div>
                                        <?php
                                            $id     = 'edit-'.$key.'-'.$item_id;
                                            $class  = $key;
                                            $name   = $key . "[". $item_id ."]";

                                            echo '<input type="hidden" value="' . $value . '" id="' . $id . '" class="' . $class . '" name="' . $name . '" />';
                                            echo $this->suppa_all_categories;
                                            //era_get_categories::all_cats_by_select( $id, $class, $name, $selected_cat );
                                        ?>


                                        <!-- Taxonomy -->
                                        <?php
                                            // Taxonomy
                                            $key    = "menu-item-suppa-posts_taxonomy";
                                            $value  = @$item_meta['_menu-item-suppa-posts_taxonomy'][0];

                                            if($value == "")
                                            {
                                                $value = "category";
                                            }
                                        ?>
                                        <input type="hidden" value="<?php echo $value; ?>" id="edit-<?php echo $key.'-'.$item_id; ?>" class="suppa_taxonomy <?php echo $key; ?>" name="<?php echo $key . '['. $item_id .']';?>" />

                                    </div>

                                    <div class="admin_suppa_clearfix"></div>

                                    <br/>
                                    <?php
                                        // Align
                                        $title  = __( 'Posts Number' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-posts_number";
                                        $value  = @$item_meta['_menu-item-suppa-posts_number'][0];

                                        if($value == "") $value = 1;

                                        echo $title;
                                    ?>

                                    <div>
                                        <select id="edit-<?php echo $key.'-'.$item_id; ?>" class=" <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" >
                                        <?php
                                            for ( $i = 1; $i <= 20; $i++  )
                                            {
                                                if( $i == $value )
                                                {
                                                    echo '<option selected="selected" >'.$i.'</option>';
                                                }
                                                else
                                                {
                                                    echo '<option>'.$i.'</option>';
                                                }
                                            }
                                        ?>
                                        </select>
                                    </div>

                                    <div class="admin_suppa_clearfix"></div>
                                </div>


                            </div>
                        </div>
                        <!-- *************** end item *************** -->

                        <!-- *************** new item *************** -->
                        <div class="admin_suppa_clearfix"></div>
                        <div class="admin_suppa_box admin_suppa_box_link_settings" >

                            <div class="admin_suppa_box_header">
                                <span><?php _e('Link Settings :','suppa_menu'); ?></span>
                                <a>+</a>
                            </div>
                            <div class="admin_suppa_box_container admin_suppa_box_container_settings">

                                <div id="menu-item-suppa-link_logged_in" >
                                    <?php
                                        // User Logged In / Out
                                        $title  = __( 'Show link when user' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-link_user_logged";
                                        $value  = @$item_meta['_menu-item-suppa-link_user_logged'][0];

                                        if($value == "") $value = "both";
                                    ?>

                                    <?php echo $title; ?>
                                    <select id="edit-<?php echo $key.'-'.$item_id; ?>" class=" <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" >
                                        <option value="both" <?php if( 'both' == $value ) echo 'selected="selected"'; ?> ><?php _e('Both Logged in/out','suppa_menu'); ?></option>
                                        <option value="logged_in" <?php if( 'logged_in' == $value ) echo 'selected="selected"'; ?> ><?php _e('Logged in','suppa_menu'); ?></option>
                                        <option value="logged_out" <?php if( 'logged_out' == $value ) echo 'selected="selected"'; ?> ><?php _e('Logged out','suppa_menu'); ?></option>
                                    </select>

                                    <div class="admin_suppa_clearfix"></div>

                                </div>

                                <br/>

                                <div id="menu-item-suppa-link_position_container" >
                                    <?php
                                        // Position
                                        $title  = __( 'Position' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-link_position";
                                        $value  = @$item_meta['_menu-item-suppa-link_position'][0];

                                        if($value == "") $value = "left";
                                    ?>

                                    <?php echo $title; ?>
                                    <select id="edit-<?php echo $key.'-'.$item_id; ?>" class=" <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" >
                                        <option value="left" <?php if( 'left' == $value ) echo 'selected="selected"'; ?> ><?php _e('Left','suppa_menu'); ?></option>
                                        <option value="right" <?php if( 'right' == $value ) echo 'selected="selected"'; ?> ><?php _e('Right','suppa_menu'); ?></option>
                                        <option value="none" <?php if( 'none' == $value ) echo 'selected="selected"'; ?> ><?php _e('None','suppa_menu'); ?></option>
                                    </select>

                                    <div class="admin_suppa_clearfix"></div>

                                </div>


                                <div id="menu-item-suppa-link_icon_only">
                                    <?php
                                        // Use icon only
                                        $title  = __( 'Use icon only' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-link_icon_only";
                                        $value  = @$item_meta['_menu-item-suppa-link_icon_only'][0];

                                        if( $value == "" ){
                                            $value = "off";
                                        }
                                    ?>
                                    <label for="edit-<?php echo $key.'-'.$item_id; ?>">

                                        <?php echo $title; ?>
                                        <input <?php if( $value == 'on' ) echo 'checked'; ?> type="checkbox" value="<?php echo $value; ?>" id="edit-<?php echo $key.'-'.$item_id; ?>" class="fr suppa_use_icon_only <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" />

                                    </label>
                                </div>

                                <?php
                                    // Upload or Font Awesome
                                    $title  = __( 'Upload Icon' , 'suppa_menu' );
                                    $key    = "menu-item-suppa-link_icon_type";
                                    $value  = @$item_meta['_menu-item-suppa-link_icon_type'][0];

                                    if($value == "")
                                    { $value = "icon_type"; }

                                    $icon_type = $value;
                                ?>
                                <label for="edit-<?php echo $key.'-'.$item_id; ?>" >

                                    <?php echo $title; ?>

                                    <select id="edit-<?php echo $key.'-'.$item_id; ?>" class=" <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>"  >
                                        <option value="icon_type" <?php if( 'icon_type' == $value ) echo 'selected="selected"' ?> ><?php _e('No Icon','suppa_menu'); ?></option>
                                        <option value="upload" <?php if( 'upload' == $value ) echo 'selected="selected"' ?> ><?php _e('Upload new icon','suppa_menu'); ?></option>
                                        <option value="fontawesome" <?php if( 'fontawesome' == $value ) echo 'selected="selected"' ?> ><?php _e('Font Awesome icon','suppa_menu'); ?></option>
                                    </select>

                                    <div class="admin_suppa_clearfix"></div>

                                </label>

                                <div <?php if( $icon_type != 'upload' ) echo 'style="display:none;"' ; ?> class="admin_suppa_box_option_inside admin_suppa_box_option_inside_icon_upload">

                                    <?php
                                        // Use icon only
                                        $title  = __( 'Icon' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-link_icon_image";
                                        $value  = @$item_meta['_menu-item-suppa-link_icon_image'][0];

                                        if($value == "") $value = "";
                                        $uploaded_icon = $value;
                                    ?>
                                    <?php echo $title; ?>
                                    <div>
                                        <input type="text" value="<?php echo $value; ?>" id="edit-<?php echo $key.'-'.$item_id; ?>" class="admin_suppa_upload_input <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" />

                                        <button class="admin_suppa_upload button-primary fr">Upload</button> <br/>
                                    </div>

                                    <div class="admin_suppa_clearfix"></div>

                                    <br/>
                                    <?php
                                        // Use icon only
                                        $title  = __( 'Icon (Retina)' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-link_icon_image_hover";
                                        $value  = @$item_meta['_menu-item-suppa-link_icon_image_hover'][0];

                                        if($value == "") $value = "";
                                    ?>
                                    <?php echo $title; ?>
                                    <div>
                                        <input type="text" value="<?php echo $value; ?>" id="edit-<?php echo $key.'-'.$item_id; ?>" class="admin_suppa_upload_input <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" />

                                        <button class="admin_suppa_upload button-primary fr">Upload</button> <br/>
                                    </div>
                                    <div class="admin_suppa_clearfix"></div>

                                </div>

                                <div <?php if( $icon_type != 'fontawesome' ) echo 'style="display:none;"' ; ?> class="admin_suppa_box_option_inside admin_suppa_box_option_inside_icon_fontawesome">

                                    <?php
                                        // Use icon only
                                        $title  = __( 'Icon' , 'suppa_menu' );
                                        $key    = "menu-item-suppa-link_icon_fontawesome";
                                        $value  = @$item_meta['_menu-item-suppa-link_icon_fontawesome'][0];

                                        if($value == "") $value = "";
                                        $value_icon = $value;
                                    ?>
                                    <?php echo $title; ?>

                                    <button id="<?php echo $item->ID; ?>" class="admin_suppa_selectIcon_button button-primary fr">Select</button>
                                    <input type="hidden" value="<?php echo $value_icon; ?>" id="edit-<?php echo $key.'-'.$item_id; ?>" class="fr admin_suppa_fontAwesome_icon_hidden-<?php echo $item->ID; ?> <?php echo $key; ?>" name="<?php echo $key . "[". $item_id ."]";?>" />
                                    <div class="admin_suppa_clearfix"></div>

                                    <br/>

                                    <span class="admin_suppa_fontAwesome_icon_box_preview admin_suppa_fontAwesome_icon_box_preview-<?php echo $item->ID; ?>">
                                        <span style="font-size:20px; ?>;" aria-hidden="true" class="<?php echo $value_icon; ?>"></span>
                                    </span>

                                    <br/><br/>

                                </div>

                            </div>
                        </div>
                        <!-- *************** end item *************** -->

                    </div>
                    <!-- *************** end Suppa Options *************** -->

                    <div class="menu-item-actions description-wide submitbox">
                        <?php if( 'custom' != $item->type ) : ?>
                            <p class="link-to-original">
                                <?php printf( __('Original: %s','suppa_menu'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
                            </p>
                        <?php endif; ?>
                        <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
                        echo wp_nonce_url(
                            add_query_arg(
                                array(
                                    'action' => 'delete-menu-item',
                                    'menu-item' => $item_id,
                                ),
                                remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
                            ),
                            'delete-menu_item_' . $item_id
                        ); ?>"><?php _e('Remove','suppa_menu'); ?></a> <span class="meta-sep"> | </span> <a class="item-cancel submitcancel" id="cancel-<?php echo $item_id; ?>" href="<?php    echo add_query_arg( array('edit-menu-item' => $item_id, 'cancel' => time()), remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) );
                            ?>#menu-item-settings-<?php echo $item_id; ?>">Cancel</a>
                    </div>

                    <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
                    <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
                    <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
                    <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
                    <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
                    <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
                </div><!-- .menu-item-settings-->
                <ul class="menu-item-transport"></ul>
            <?php
            $output .= ob_get_clean();
        }
    }


}