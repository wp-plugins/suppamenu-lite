/**
 *
 * Suppa Menu Object
 *
**/
suppaMenuOB = {


    /**
     * Logo
     *
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */
    logo : function ( $menu, config )
    {
        if( config.logo_enable == 'on' && config.logo_src != "" )
        {
            var $logo_tag = '<a href="'+config.site_url+'" class="suppa_menu_logo" ><img src="' + config.logo_src + '" /></a>';
            $menu.find('.suppaMenu')
                .prepend( $logo_tag );
        }
        if( config.rwd_logo_enable == 'on' && config.rwd_logo_src != "" )
        {
            var $logo_tag = '<a href="'+config.site_url+'" class="suppa_rwd_logo" ><img src="' + config.rwd_logo_src + '" /></a>';
            $menu.find('.suppa_rwd_top_button_container')
                .prepend( $logo_tag );
        }
    },



    /**
     * Search Form For Desktops / Laptops
     *
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */
    searchFormDesktop : function ( $menu, config )
    {
        if( config.modern_search == 'on' )
        {
            $menu.find('.suppa_search_icon').click(function(event){
                event.preventDefault();
                jQuery(this).addClass('suppa_search_icon_ClassHover')
                    .parent('.suppa_menu_search').css('position','static')
                    .find('.suppa_search_form')
                    .addClass('suppa_search_form_big');
            });

            jQuery('.suppa_search_icon_remove').click(function(event){
                event.preventDefault();
                event.stopPropagation();
                jQuery(this)
                    .parents('.suppa_menu_search').css('position','relative')
                    .find('.suppa_search_icon_ClassHover').removeClass('suppa_search_icon_ClassHover');

                jQuery(this)
                    .parents('.suppa_search_form')
                    .removeClass('suppa_search_form_big')
                    .hide(0);
            });
        }
    },


    /**
     * Adjust Links Style Two - Links Container Width
     *
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */
    adjustLinksStyleTwo : function ( $menu, config )
    {
        $menu.find('.suppa_menu_linksTwo').each(function(){
            var $this               = jQuery(this);
            var thisWidth           = $this.find('.suppa_submenu').width();
            var catContainerWidth   = $this.find('.suppa_linksTwo_categoriesContainer').width();
            var targetWidth = thisWidth - catContainerWidth - 1;
            $this.find('.suppa_linksTwo_cat').width( targetWidth );
        });
    },



    /**
     * Close Submenus when user click outside the menu
     *
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */
    clickOutsideCloseSubmenus : function ( $menu , config )
    {
        //But not when the menu is clicked
        $menu.click( function(e){
            e.stopPropagation();
        });

        jQuery(document).on( 'click' , function(e)
        {
            var $top_links = $menu.find('.suppa_menu > a');

            $menu.find('*[data-preventclick="prevent"]')
                    .attr('data-preventclick','')
                    .removeClass( 'suppa_menu_class_hover' );

            $menu.find('.suppa_dropdown_item_container')
                .removeClass( 'suppa_menu_class_dropdown_levels_hover' );

            $menu.find('.suppa_search_icon')
                .removeClass('suppa_search_icon_ClassHover');

            // Hide All Submenu's
            switch ( config.jquery_anim )
            {
            case "none":
                $menu.find('.suppa_submenu').stop(true, true).hide( config.jquery_time / 2 );
                $menu.find('.suppa_rwd_menus_container').stop(true, true).hide( config.jquery_time / 2 );
                break;
            case "fade":
                $menu.find('.suppa_submenu').stop(true, true).fadeOut( config.jquery_time / 2 );
                $menu.find('.suppa_rwd_menus_container').stop(true, true).fadeOut( config.jquery_time / 2 );
                break;
            case "slide":
                $menu.find('.suppa_submenu').stop(true, true).slideUp( config.jquery_time / 2 );
                $menu.find('.suppa_rwd_menus_container').stop(true, true).slideUp( config.jquery_time / 2 );
                break;
            default:
                $menu.find('.suppa_submenu').stop(true, true).hide( config.jquery_anim , {} , config.jquery_time / 2 );
                $menu.find('.suppa_rwd_menus_container').stop(true, true).hide( config.jquery_anim , {} , config.jquery_time / 2 );
            }

            // Default CSS Values
            /** CSS **/
            $top_links.css({ 'color' : '' , 'background-color' : '' });
            $top_links.children('.ctf_suppa_fa_box_top_arrow').css({'color' : '' });

        });
    },


    /**
     * Click Trigger Function
     *
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */
    clickTrigger : function ( $menu , config )
    {
        /*** Hover : Top Level Links ***/
        $menu.children('.suppaMenu').find('.suppa_menu').each(function(){
            var $this = jQuery(this);

            $this.click(function( event ){

                /** Lazy Load & Retina **/
                if( $this.is('.suppa_menu_posts') )
                {
                    $this.find('.suppa_lazy_load').each(function(){
                        var $cur_img = jQuery(this);
                        $cur_img.removeClass('suppa_lazy_load');
                        // Retina
                        if( config.retina_device )
                        {
                            $cur_img.attr( 'src', $cur_img.attr('data-retina') );
                        }
                        else
                        {
                            $cur_img.attr( 'src', $cur_img.attr('data-original') );
                        }
                    });
                }

                // If No Submenu Found Don't Prevent
                if( $this.children('.suppa_submenu').length > 0 )
                {
                    // Prevent First Click
                    if( $this.attr('data-preventClick') != "prevent" )
                    {
                        $this.attr('data-preventClick' , 'prevent' );
                        event.preventDefault();

                        /** All items except this **/
                        $this.siblings().attr('data-preventClick','');

                        /** Hide SubMenu's **/
                        $menu.children('.suppaMenu').find('.suppa_menu').each(function(){
                            var $second = jQuery(this);

                            switch ( config.jquery_anim )
                            {
                            case "none":
                                $second.children('.suppa_submenu').stop(true, true).hide( config.jquery_time / 2 );
                                break;
                            case "fade":
                                $second.children('.suppa_submenu').stop(true, true).fadeOut( config.jquery_time / 2 );
                                break;
                            case "slide":
                                $second.children('.suppa_submenu').stop(true, true).slideUp( config.jquery_time / 2 );
                                break;
                            }

                        });

                        /** CSS **/
                        $this.addClass('suppa_menu_class_hover');
                        $this.siblings().removeClass('suppa_menu_class_hover');

                    }

                    // Display Submenu
                    switch ( config.jquery_anim )
                    {
                    case "none":
                        $this.children('.suppa_submenu').stop(true, true).show( config.jquery_time, config.jquery_easings );

                        break;
                    case "fade":
                        $this.children('.suppa_submenu').stop(true, true).fadeIn( config.jquery_time, config.jquery_easings );

                        break;
                    case "slide":
                        $this.children('.suppa_submenu').stop(true, true).slideDown( config.jquery_time, config.jquery_easings );

                        break;
                    }

                }

            });

        });

        /*** DropDown Levels Show/Hide ***/
        $menu.find('.suppa_dropdown_item_container').each(function(){
            var $this = jQuery(this);
            $this.click(function(event){
                if( $this.children('.suppa_submenu').length != 0 )
                {
                    // Prevent First Click
                    if( $this.attr('data-preventClick') != "prevent" )
                    {
                        // Display Submenu
                        switch ( config.jquery_anim )
                        {
                        case "none":
                            $this.parent().find('.suppa_submenu').stop(true, true).hide( config.jquery_time / 2 );
                            $this.children('.suppa_submenu').stop(true, true).show( config.jquery_time, config.jquery_easings );

                            break;
                        case "fade":
                            $this.parent().find('.suppa_submenu').stop(true, true).fadeOut( config.jquery_time / 2 );
                            $this.children('.suppa_submenu').stop(true, true).fadeIn( config.jquery_time, config.jquery_easings );

                            break;
                        case "slide":
                            $this.parent().find('.suppa_submenu').stop(true, true).slideUp( config.jquery_time / 2 );
                            $this.children('.suppa_submenu').stop(true, true).slideDown( config.jquery_time, config.jquery_easings );

                            break;
                        }

                        $this.attr('data-preventClick' , 'prevent' );
                        event.preventDefault();

                        /** All items except $this **/
                        $this.siblings().attr('data-preventClick','');
                        $this.find('.suppa_menu_class_dropdown_levels_hover').attr('data-preventClick','');

                        /** CSS **/
                        $this.addClass('suppa_menu_class_dropdown_levels_hover');
                        $this.siblings().removeClass('suppa_menu_class_dropdown_levels_hover');
                        $this.find('.suppa_menu_class_dropdown_levels_hover').removeClass('suppa_menu_class_dropdown_levels_hover');
                    }
                }
            });
        });

    },


    /**
     * Hover & Hover-Intent Trigger Function
     *
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */
    hoverTrigger : function ( $menu , config )
    {
        /*** HoverIntent : Top Level Links ***/
        $menu.children('.suppaMenu').find('.suppa_menu').each(function()
        {
            var $this = jQuery(this);
            var $timeout_show;
            var $timeout_hide;

            $this.mouseenter(function(event){

                    $this.siblings().css('z-index','1');
                    $this.css('z-index','2');

                    clearTimeout( $timeout_hide );
                    $timeout_show = setTimeout( function(){

                        switch ( config.jquery_anim )
                        {
                        case "none":
                            $this.children('.suppa_submenu').stop(true, true).show( config.jquery_time , config.jquery_easings );
                            break;
                        case "fade":
                            $this.children('.suppa_submenu').stop(true, true).fadeIn( config.jquery_time , config.jquery_easings );
                            break;
                        case "slide":
                            $this.children('.suppa_submenu').stop(true, true).slideDown( config.jquery_time , config.jquery_easings );
                            break;
                        }
                    },220);

                    /** Lazy Load & Retina **/
                    if( $this.is('.suppa_menu_posts') )
                    {
                        $this.find('.suppa_lazy_load').each(function(){
                            var $cur_img = jQuery(this);
                            $cur_img.removeClass('suppa_lazy_load');
                            // Retina
                            if( config.retina_device )
                            {
                                $cur_img.attr( 'src', $cur_img.attr('data-retina') );
                            }
                            else
                            {
                                $cur_img.attr( 'src', $cur_img.attr('data-original') );
                            }
                        });
                    }
            });

            $this.mouseleave(function(event){

                clearTimeout( $timeout_show );
                $timeout_hide = setTimeout( function(){
                    switch ( config.jquery_anim )
                    {
                    case "none":
                        $this.children('.suppa_submenu').stop(true, true).hide( config.jquery_time / 4 );
                        break;
                    case "fade":
                        $this.children('.suppa_submenu').stop(true, true).fadeOut( config.jquery_time / 4 );
                        break;
                    case "slide":
                        $this.children('.suppa_submenu').stop(true, true).slideUp( config.jquery_time / 4 );
                        break;
                    }
                },100);
            });

        });

        /*** DropDown ***/
        $menu.find('.suppa_menu_dropdown .suppa_dropdown_item_container').each(function(){

            var $this = jQuery(this);
            var $drop_show;
            var $drop_hide;

            $this.hover(function(){

                clearTimeout( $drop_hide );
                $drop_show = setTimeout( function()
                {
                    switch ( config.jquery_anim )
                    {
                        case "none":
                            $this.children('.suppa_submenu').stop(true, true).show( config.jquery_time, config.jquery_easings );
                            break;
                        case "fade":
                            $this.children('.suppa_submenu').stop(true, true).fadeIn( config.jquery_time, config.jquery_easings );
                            break;
                        case "slide":
                            $this.children('.suppa_submenu').stop(true, true).slideDown( config.jquery_time, config.jquery_easings );
                            break;
                    }
                },230);

            },function(){

                clearTimeout( $drop_show );
                $drop_hide = setTimeout( function()
                {
                    switch ( config.jquery_anim )
                    {
                        case "none":
                            $this.children('.suppa_submenu').stop(true, true).hide( config.jquery_time / 2 );
                            break;
                        case "fade":
                            $this.children('.suppa_submenu').stop(true, true).fadeOut( config.jquery_time / 2 );
                            break;
                        case "slide":
                            $this.children('.suppa_submenu').stop(true, true).slideUp( config.jquery_time / 2 );
                            break;
                    }
                },130);
            });

        });

    },


    /**
     * Create RWD New Menu, Then change the class's of Menu's & Submenu's
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */
    rwdBuild : function ( $menu, config )
    {
        // Clone the menus
        var $clone_menus    = $menu.children('.suppaMenu').html();
        var $rwd            = $menu.children('.suppaMenu_rwd_wrap');
        $rwd.children('.suppa_rwd_menus_container').append($clone_menus);

        // Change Menus & Submenus Class's
        $rwd.find('.suppa_menu').each(function(){
            var $menu_class_attr = jQuery(this).attr('class');
            $menu_class_attr = $menu_class_attr.replace(/suppa_menu/g,'suppa_rwd_menu');
            jQuery(this).attr('class',$menu_class_attr);
            jQuery(this).removeClass('suppa_top_level_link');
        });
        $rwd.find('.suppa_submenu').each(function(){
            var $menu_class_attr = jQuery(this).attr('class');
            $menu_class_attr = $menu_class_attr.replace(/suppa_submenu/g,'suppa_rwd_submenu');
            jQuery(this).attr('class',$menu_class_attr);
        });
        $rwd.find('.era_suppa_arrow_box').each(function(){
            var $menu_class_attr = jQuery(this).attr('class');
            $menu_class_attr = $menu_class_attr.replace(/.+/g,'era_rwd_suppa_arrow_box');
            jQuery(this).attr('class',$menu_class_attr);
        });
        $rwd.find('.suppa_rwd_menu_dropdown .suppa-caret-right').attr('class','suppa-caret-down');
        $rwd.find('.suppa_menu_logo').hide();

        // Logo
        if( config.rwd_logo_enable == 'on' )
        {
            $rwd.find('.suppa_rwd_text').css({ 'float' : 'right' })
        }

        // Search Form
        var search_form     = $menu.find('.suppa_rwd_menu_search');

        // Modern Search
        if( config.modern_search_on = 'on' )
            search_form.children('form').addClass('suppa_search_form_big');

        // Clone search
        var search_clone    = search_form.clone();
        search_form.remove();

        // append search to the end
        if( config.rwd_search == 'on' )
            $rwd.children('.suppa_rwd_menus_container').append( search_clone );

        // Fix for HTML Menu Not Full Width
        $rwd.find('.suppa_rwd_submenu_html');

        // Remove Style from Dropdown submenus
        $rwd.find('.suppa_rwd_menu_dropdown .suppa_rwd_submenu').removeAttr('style');

        // WPML Languages first
        var $wpml = $rwd.find('.suppa_rwd_menu_languages').clone();
        $rwd.find('.suppa_rwd_menu_languages').remove();
        $rwd.find('.suppa_rwd_menus_container').prepend( $wpml );

        // If Menu width > Parent With & Responsive Enable
        if( $menu.children('.suppaMenu').width() > $menu.parent().width() )
        {
            $menu.children('.suppaMenu').width( $menu.parent().width() );
            $menu.find('.suppaMenu_rwd_wrap').width( $menu.parent().width() );
        }

    },


    /**
     * RWD Trigger
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */

    rwdTrigger : function ( $menu, config )
    {
        var $rwd    = $menu.children('.suppaMenu_rwd_wrap');
        var $rwd_c  = $rwd.children('.suppa_rwd_menus_container');
        $rwd_c.width( $menu.width() );

        // Fixed Width for Slide animation
        jQuery( window ).on( 'resize', function(){
            $rwd_c.width( $menu.parent().width() );
        });

        // Display RWD
        if( config.rwd_logo_enable == 'on' )
        {
            $rwd.find('.suppa_rwd_text, .suppa_rwd_button').on({
                'click': function( event )
                {
                    event.preventDefault();

                    switch ( config.jquery_anim )
                    {
                    case "none":
                        $rwd_c.stop(true,true).toggle(config.jquery_time);
                        break;
                    case "fade":
                        $rwd_c.stop(true,true).fadeToggle(config.jquery_time);
                        break;
                    case "slide":
                        $rwd_c.stop(true,true).slideToggle(config.jquery_time);
                        break;
                    }
                }
            });
        }
        else
        {
            $rwd.find('.suppa_rwd_top_button_container').on({
                'click': function( event )
                {
                    event.preventDefault();

                    switch ( config.jquery_anim )
                    {
                    case "none":
                        $rwd_c.stop(true,true).toggle(config.jquery_time);
                        break;
                    case "fade":
                        $rwd_c.stop(true,true).fadeToggle(config.jquery_time);
                        break;
                    case "slide":
                        $rwd_c.stop(true,true).slideToggle(config.jquery_time);
                        break;
                    }
                }
            });
        }



        // Link click
        $rwd.find('.suppa_rwd_menu > a, .suppa_rwd_submenu > .suppa_dropdown_item_container > a').each(function(){
            var $this = jQuery(this);
            $this.on({
                'click' : function( event ){

                    if( !$this.is('.era_rwd_suppa_submenu_box') )
                    {
                        if( $this.parent().find('.suppa_rwd_submenu').length > 0 )
                        {
                            event.preventDefault();
                            event.stopPropagation();

                            switch ( config.jquery_anim )
                            {
                            case "none":
                                $this.parent().children('.suppa_rwd_submenu').show(config.jquery_time);
                                break;
                            case "fade":
                                $this.parent().children('.suppa_rwd_submenu').fadeIn(config.jquery_time);
                                break;
                            case "slide":
                                $this.parent().children('.suppa_rwd_submenu').slideDown(config.jquery_time);
                                break;
                            }

                            /** Lazy Load & Retina **/
                            if( $this.parent().is('.suppa_rwd_menu_posts') )
                            {
                                $this.parent().find('.suppa_lazy_load').each(function(){
                                    var $cur_img = jQuery(this);
                                    $cur_img.removeClass('suppa_lazy_load');
                                    // Retina
                                    if( config.retina_device )
                                    {
                                        $cur_img.attr( 'src', $cur_img.attr('data-retina') );
                                    }
                                    else
                                    {
                                        $cur_img.attr( 'src', $cur_img.attr('data-original') );
                                    }
                                });
                            }

                            $this.children('.era_rwd_suppa_arrow_box')
                                .addClass('era_rwd_suppa_arrow_both_open')
                                .children('span')
                                .attr('class','suppa-caret-up');
                            $this.addClass('era_rwd_suppa_submenu_box era_rwd_suppa_link_both_open');

                        }
                    }

                }
            });
        });

        // Arrow click
        $rwd.find('.suppa_rwd_menu > a > .era_rwd_suppa_arrow_box, .suppa_rwd_submenu > .suppa_dropdown_item_container > a > .era_rwd_suppa_arrow_box').each(function(){
            var $this = jQuery(this);

            $this.on({
                'click' : function( event ){

                    if( $this.is('.era_rwd_suppa_arrow_both_open') )
                    {
                        event.preventDefault();
                        event.stopPropagation();

                        if( $this.parent().is('.era_rwd_suppa_submenu_box') )
                        {

                            switch ( config.jquery_anim )
                            {
                            case "none":
                                $this.parent().parent().children('.suppa_rwd_submenu').stop(true, true).hide(config.jquery_time / 2);
                                break;
                            case "fade":
                                $this.parent().parent().children('.suppa_rwd_submenu').stop(true, true).fadeOut(config.jquery_time / 2);
                                break;
                            case "slide":
                                $this.parent().parent().children('.suppa_rwd_submenu').stop(true, true).slideUp(config.jquery_time / 2);
                                break;
                            }

                            $this.removeClass('era_rwd_suppa_arrow_both_open')
                                    .children('span').attr('class','suppa-caret-down');
                            $this.parent().removeClass('era_rwd_suppa_submenu_box era_rwd_suppa_link_both_open');
                        }
                    }
                }
            });

        });

    },


    /**
     * RWD For Desktops / Laptops
     *
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */
    rwdDesktops : function ( $menu, config )
    {

        var $starting_width     = config.rwd_start_width,
            $window_width       = jQuery(window).width(),
            $menu_to_hide_show  = $menu.find('.suppaMenu'),
            $menu_width         = $menu_to_hide_show.width();

        if( config.rwd_enable_desk == 'on' )
        {
            // Start RWD
            suppaMenuOB.rwdBuild( $menu , config );
            suppaMenuOB.rwdTrigger( $menu , config );

            var $rwd_menus = $menu.find('.suppaMenu_rwd_wrap');

            if( $starting_width >= $window_width )
            {
                $menu_to_hide_show.hide();
                $rwd_menus.show();
            }

            // Resize
            jQuery( window ).on( 'resize', function(){

                $window_width   = jQuery(window).width();
                if( $starting_width >= $window_width )
                {
                    $menu_to_hide_show.hide();
                    $rwd_menus.show();
                }
                else
                {
                    $menu_to_hide_show.show();
                    $rwd_menus.hide();
                }

                if( $menu.children('.suppaMenu').width() >= $window_width )
                    $menu.children('.suppaMenu').css('width', $window_width );
                else if ( $menu.children('.suppaMenu').width() < $window_width && $menu_width <= $window_width )
                    $menu.children('.suppaMenu').css('width', $menu_width );
                else
                    $menu.children('.suppaMenu').width( $menu_width );

            });

            // Close When click outside
            suppaMenuOB.clickOutsideCloseSubmenus( $menu, config );
        }
    },


    /**
     * Adjust Submenu Align for HTML/LINKS on RWD
     *
     * @param $menu the menu object
     * @param config Custom menu settings & style
     *
     */
    rwdAdjustSubmenuAlign : function ( $menu, config )
    {
        $menu.find('.suppa_rwd_submenu_columns_wrap, .suppa_rwd_submenu_html').each(function(){
            jQuery(this).attr('style','width:100%;');
        });
    },

};



/**
 *
 * This run's when the DOM complete loading
 *
 */
(function(jQuery){

    jQuery.fn.suppamenu = function( options )
    {
        // Default Options
        var config = jQuery.extend({
            jquery_mode         : 'off',
            jquery_trig         : 'hover-intent',
            jquery_anim         : 'slide',
            jquery_time         : 450,
            rwd_enable          : 'on',
            rwd_enable_desk     : 'on',
            rwd_start_width     : 960,
            rwd_text            : 'Menu',
            box_layout          : 'wide_layout',
            scroll_enable       : 'on',
            scroll_enable_mob   : 'on',
            modern_search       : 'off',
            rwd_search          : 'off',
            logo_enable         : 'off',
            rwd_logo_enable     : 'off',
            logo_src            : '',
            logo_retina_src     : '',
            rwd_logo_src        : '',
            rwd_logo_retina_src : '',
            site_url            : '',
            recent_posts_view_all : 'off',
        }, options );

        /** Get Menu **/
        var $menu               = this,
            $menus_container    = $menu.find('.suppaMenu');


        /** UnBind Events **/
        $menu.removeAttr('id');
        $menu.find('.suppa_menu > a')
            .removeClass('menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-type-custom menu-item-object-custom');

        /** Detect Retina Devices **/
        if (window.devicePixelRatio >= 2)
        {
            config.retina_device = true;
            $menu.find('.suppa_upload_img').each(function(){
                var $this = jQuery(this);
                $this.attr('src', $this.attr('data-retina') );
            });

            /** Logo **/
            config.logo_src = config.logo_retina_src;
            config.rwd_logo_src = config.rwd_logo_retina_src;
        }
        else
        {
            config.retina_device = false;
        }

        /** Logo **/
        suppaMenuOB.logo( $menu, config );

        /** WPML Support **/
        var $wpml = $menu.find('.menu-item-language');
        if( $wpml.length > 0 )
        {

            $wpml.find('ul li').each(function(){
                var $this   = jQuery(this);
                var $son    = $this.children('a');
                $son.css({ 'padding-right' : $son.css('padding-left') });

                $this.replaceWith('<div class="suppa_dropdown_item_container" >' + $this.html() + '</div>');
            });

                var $text   = $menu.find('.menu-item-language > a').text();
                var $img    = $menu.find('.menu-item-language > a img').attr('class','suppa_wpml_icon').clone();

                $menu.find('.menu-item-language > a')
                    .html('')
                    .addClass('suppa_top_level_link suppa_menu_position_right suppa_top_links_has_arrow')
                    .append( $img )
                    .append( '<span class="suppa_item_title">' + $text + '</span> <span class="era_suppa_arrow_box ctf_suppa_fa_box_top_arrow"><span aria-hidden="true" class="suppa-caret-down"></span></span>' );

            var $wpml_ul = $wpml.find('ul');
            if( $wpml_ul.length > 0 )
            {
                $wpml_ul.replaceWith( '<div class="suppa_submenu suppa_submenu_0">' + $wpml_ul.html() + '</div>' );

                $wpml.find('.suppa_dropdown_item_container > a').each(function(){
                    var $text   = jQuery(this).text();
                    var $img    = jQuery(this).find('img').attr('class','suppa_upload_img suppa_UP_icon').clone();
                    jQuery(this)
                        .html('')
                        .append( $img )
                        .append( '<span class="suppa_item_title">' + $text + '</span>' )
                        .css({ 'padding-right' : '9px' });
                });

            }

            $wpml.replaceWith( '<div class="suppa_menu suppa_menu_dropdown suppa_menu_languages">' + $wpml.html() + '</div>' ) ;
        }


        /** Dropdowns Open Position **/
        //suppaMenuOB.dropdownOpenPosition( $menu , config );

        // Mobile
        $rwd_start_width = config.rwd_start_width;

        if( /ipad|iphone|ipod|android|blackberry|webos|windows phone/i.test( navigator.userAgent.toLowerCase() ) )
        {
            config.device = 'mobile';
            if( config.rwd_enable == 'on' && $rwd_start_width > $menu.parent().width() )
            {
                // Hide Menus
                $menus_container.css({'display':'none'});
                suppaMenuOB.rwdBuild( $menu , config );
                suppaMenuOB.rwdTrigger( $menu , config );
                $menu.find('.suppaMenu_rwd_wrap').css({ 'display' : 'block' });
            }
            else
            {
                if( $menus_container.width() > $menu.parent().width() )
                {
                    $menus_container.width( $menu.parent().width() );
                    jQuery( window ).on( 'resize' , function(){
                        $menus_container.width( $menu.parent().width() );
                    });
                }

                /** Click Trigger **/
                suppaMenuOB.clickTrigger( $menu , config );
            }

            /** Close Submenu's when click outside **/
            suppaMenuOB.clickOutsideCloseSubmenus( $menu, config );
        }

        // Desktop / Laptop
        else
        {
            config.device = 'desktop_laptop';
            /** Triggers **/
            switch( config.jquery_trig )
            {
                case 'click' :
                    suppaMenuOB.clickTrigger( $menu , config );

                    // Close Submenu's when click outside
                    suppaMenuOB.clickOutsideCloseSubmenus( $menu , config );
                break;

                case 'hover-intent' :
                    suppaMenuOB.hoverTrigger( $menu , config );
                break;
            }

            /** RWD for Desktops / Laptops **/
            suppaMenuOB.rwdDesktops( $menu, config );

        }

        /** Search Form **/
        suppaMenuOB.searchFormDesktop( $menu, config );

        /** Adjust Submenu Align **/
        suppaMenuOB.rwdAdjustSubmenuAlign( $menu, config );

        /** Box Layout **/
        if( config.box_layout == 'wide_layout' )
        {
            $menu.addClass('suppaMenu_wrap_wide_layout');
        }

        /** Recent Posts : View All Button **/
        if( config.recent_posts_view_all == "on" )
            $menu.find('.suppa_latest_posts_view_all').css('display','block');
        return this;
    };

}( jQuery ));