/**
 * This run's when the DOM complete loading
 */
(function( $ ){

   /** Object **/
   suppaMenuOB = {


      /**
       * Layout & Logo
       * @param $menu the menu object
       * @param config Custom menu settings & style
       */
      layout_and_logo : function ( $menu, config ){

          if( config.logo_enable == 'no_logo' || config.logo_enable == 'off' || config.logo_enable == '' ){
              return false;
          }
          else if( config.logo_enable == 'on' || config.logo_enable == 'logo_left_menu_right' ){
              var $logo_tag = '<a href="'+config.site_url+'" class="suppa_menu_logo logo_left_menu_right" ><img src="' + config.logo_src + '" /></a>';
              $menu.find('.suppaMenu')
                   .prepend( $logo_tag );
          }
          else if( config.logo_enable == 'logo_right_menu_left' ){
              var $logo_tag = '<a href="'+config.site_url+'" class="suppa_menu_logo logo_right_menu_left" ><img src="' + config.logo_src + '" /></a>';
              $menu.find('.suppaMenu')
                   .append( $logo_tag );
          }
          else if( config.logo_enable == 'logo_top_center' ){
              var $logo_tag = '<a href="'+config.site_url+'" class="suppa_menu_logo logo_top_center" ><img src="' + config.logo_src + '" /></a>';
              $menu.prepend( $logo_tag );
          }

          else if( config.logo_enable == 'logo_top_left' ){
              var $logo_tag = '<a href="'+config.site_url+'" class="suppa_menu_logo logo_top_left" ><img src="' + config.logo_src + '" /></a>';
              $menu.prepend( $logo_tag );
          }

          else if( config.logo_enable == 'logo_top_right' ){
              var $logo_tag = '<a href="'+config.site_url+'" class="suppa_menu_logo logo_top_right" ><img src="' + config.logo_src + '" /></a>';
              $menu.prepend( $logo_tag );
          }
      },



      /**
       * Layout & Logo
       * @param $menu the menu object
       * @param config Custom menu settings & style
       */
      rwd_layout_and_logo : function ( $rwd, config ){
          if( config.rwd_logo_enable == 'no_logo' || config.rwd_logo_enable == 'off' || config.rwd_logo_enable == '' ){
              return false;
          }
          else if( config.rwd_logo_enable == 'logo_left_menu_right' || config.rwd_logo_enable == 'on' ){
              var $logo_tag = '<a href="'+config.site_url+'" class="suppa_rwd_logo logo_left_menu_right" ><img src="' + config.rwd_logo_src + '" /></a>';
              $rwd.find('.suppa_rwd_top_button_container').prepend( $logo_tag );
              $rwd.find('.suppa_rwd_text').css({ 'float' : 'right' });
          }
          else if( config.rwd_logo_enable == 'logo_right_menu_left' ){
              var $logo_tag = '<a href="'+config.site_url+'" class="suppa_rwd_logo logo_right_menu_left" ><img src="' + config.rwd_logo_src + '" /></a>';
              $rwd.find('.suppa_rwd_top_button_container').append( $logo_tag );
              $rwd.find('.suppa_rwd_button').css({ 'float' : 'left' });
          }
          else if( config.rwd_logo_enable == 'logo_top_center' ){
              var $logo_tag = '<a href="'+config.site_url+'" class="suppa_rwd_logo logo_top_center" ><img src="' + config.rwd_logo_src + '" /></a>';
              $rwd.parent().prepend( $logo_tag );
          }
      },



      /**
       * Close Submenus when user click outside the menu
       *
       * @param $menu the menu object
       * @param config Custom menu settings & style
       *
       */
      clickOutsideCloseSubmenus : function ( $menu , config ){
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
      clickTrigger : function ( $menu , config ){
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
                  if( $this.is('.suppa_menu_mega_posts') )
                  {
                      $this.find('.suppa_mega_posts_allposts_posts:first .suppa_lazy_load').each(function(){
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

          /*** Mega Posts : Show/Hide Posts ***/
          $menu.find('.suppa_mega_posts_categories a').each(function(){
              var $this       = jQuery(this);
              var this_cat    = $this.attr('data-cat');

              $this.click(function(event){
                  // Prevent First Click
                  if( $this.attr('data-preventClick') != "prevent" )
                  {
                      // Display Submenu
                      switch ( config.jquery_anim )
                      {
                      case "none":
                          var $temp_parent = $this.parent().parent();

                          $temp_parent.find('.suppa_mega_posts_allposts_posts').stop(true, true).hide( config.jquery_time / 2 );
                          $temp_parent.find('div[data-cat="'+this_cat+'"]').show( config.jquery_time);

                          $temp_parent.find('div[data-cat="'+this_cat+'"]').find('.suppa_lazy_load').each(function(){
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

                          break;
                      case "fade":
                          var $temp_parent = $this.parent().parent();

                          $temp_parent.find('.suppa_mega_posts_allposts_posts').stop(true, true).hide( 0 );
                          $temp_parent.find('div[data-cat="'+this_cat+'"]').fadeIn( config.jquery_time );

                          $temp_parent.find('div[data-cat="'+this_cat+'"]').find('.suppa_lazy_load').each(function(){
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

                          break;
                      case "slide":
                          var $temp_parent = $this.parent().parent();

                          $temp_parent.find('.suppa_mega_posts_allposts_posts').stop(true, true).slideUp( config.jquery_time );
                          $temp_parent.find('div[data-cat="'+this_cat+'"]').slideDown( config.jquery_time);

                          $temp_parent.find('div[data-cat="'+this_cat+'"]').find('.suppa_lazy_load').each(function(){
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

                          break;
                      }

                      $this.attr('data-preventClick' , 'prevent' );
                      event.preventDefault();

                      /** All items except $this **/
                      $this.siblings().attr('data-preventClick','');

                      /** CSS **/
                      $this.addClass('suppa_mega_posts_cat_selected');
                      $this.siblings().removeClass('suppa_mega_posts_cat_selected');
                  }
              });

          });

           /*** Links Style Two : Show/Hide Links ***/
          $menu.find('.suppa_linksTwo_categoriesContainer a').each(function(){
              var $this       = jQuery(this);
              var targetDiv   = $this.attr('data-targetcat');

              $this.click(function(event){
                  // Prevent First Click
                  if( $this.attr('data-preventClick') != "prevent" )
                  {
                      $this.attr('data-preventClick' , 'prevent' );
                      event.preventDefault();

                      // Display Submenu
                      switch ( config.jquery_anim )
                      {
                      case "none":
                          var $temp_parent = $this.parent().parent();

                          $temp_parent.find('.suppa_linksTwo_cat').stop(true, true).hide( config.jquery_time / 2 );
                          $temp_parent.find('.suppa_linksTwo_cat_'+targetDiv).show( config.jquery_time);

                          break;
                      case "fade":
                          var $temp_parent = $this.parent().parent();

                          $temp_parent.find('.suppa_linksTwo_cat').stop(true, true).stop(true, true).hide( 0 );
                          $temp_parent.find('.suppa_linksTwo_cat_'+targetDiv).fadeIn( config.jquery_time );

                          break;
                      case "slide":
                          var $temp_parent = $this.parent().parent();

                          $temp_parent.find('.suppa_linksTwo_cat').stop(true, true).stop(true, true).slideUp( config.jquery_time );
                          $temp_parent.find('.suppa_linksTwo_cat_'+targetDiv).slideDown( config.jquery_time);

                          break;
                      }

                      /** All items except $this **/
                      $this.siblings().attr('data-preventClick','');

                      /** CSS **/
                      $this.addClass('suppa_linksTwo_categoriesContainer_current');
                      $this.siblings().removeClass('suppa_linksTwo_categoriesContainer_current');
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
      hoverTrigger : function ( $menu , config ){
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
                      if( $this.is('.suppa_menu_mega_posts') )
                      {
                          $this.find('.suppa_mega_posts_allposts_posts:first .suppa_lazy_load').each(function(){
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

          /*** Mega Posts : Show/Hide Posts ***/
          $menu.find('.suppa_mega_posts_categories a').each(function(){
              var $this       = jQuery(this);
              var this_cat    = $this.attr('data-cat');

              $this.mouseenter(function(event){

                  // Display Submenu
                  switch ( config.jquery_anim )
                  {
                      case "none":
                          var $temp_parent = $this.parent().parent();

                          $temp_parent.find('.suppa_mega_posts_allposts_posts').stop(true, true).hide( config.jquery_time / 2 );
                          $temp_parent.find('div[data-cat="'+this_cat+'"]').show( config.jquery_time );

                          $temp_parent.find('div[data-cat="'+this_cat+'"]').find('.suppa_lazy_load').each(function(){
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

                          break;
                      case "fade":
                          var $temp_parent = $this.parent().parent();

                          $temp_parent.find('.suppa_mega_posts_allposts_posts').stop(true, true).hide();
                          $temp_parent.find('div[data-cat="'+this_cat+'"]').fadeIn( config.jquery_time );

                          $temp_parent.find('div[data-cat="'+this_cat+'"]').find('.suppa_lazy_load').each(function(){
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

                          break;
                      case "slide":
                          var $temp_parent = $this.parent().parent();

                          $temp_parent.find('.suppa_mega_posts_allposts_posts').stop(true, true).slideUp( config.jquery_time );
                          $temp_parent.find('div[data-cat="'+this_cat+'"]').slideDown( config.jquery_time );

                          $temp_parent.find('div[data-cat="'+this_cat+'"]').find('.suppa_lazy_load').each(function(){
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

                          break;
                  }

                  /** CSS **/
                  $this.addClass('suppa_mega_posts_cat_selected');
                  $this.siblings().removeClass('suppa_mega_posts_cat_selected');

              });

          });

           /*** Links Style Two : Show/Hide Links ***/
          $menu.find('.suppa_linksTwo_categoriesContainer a').each(function(){
              var $this       = jQuery(this);
              var targetDiv   = $this.attr('data-targetcat');

              $this.mouseenter(function(event)
              {
                  // Display Submenu
                  switch ( config.jquery_anim )
                  {
                  case "none":
                      var $temp_parent = $this.parent().parent();

                      $temp_parent.find('.suppa_linksTwo_cat').stop(true, true).hide( config.jquery_time / 2 );
                      $temp_parent.find('.suppa_linksTwo_cat_'+targetDiv).show( config.jquery_time);

                      break;
                  case "fade":
                      var $temp_parent = $this.parent().parent();

                      $temp_parent.find('.suppa_linksTwo_cat').stop(true, true).stop(true, true).hide( 0 );
                      $temp_parent.find('.suppa_linksTwo_cat_'+targetDiv).fadeIn( config.jquery_time );

                      break;
                  case "slide":
                      var $temp_parent = $this.parent().parent();

                      $temp_parent.find('.suppa_linksTwo_cat').stop(true, true).stop(true, true).slideUp( config.jquery_time );
                      $temp_parent.find('.suppa_linksTwo_cat_'+targetDiv).slideDown( config.jquery_time);

                      break;
                  }

                  /** CSS **/
                  $this.addClass('suppa_linksTwo_categoriesContainer_current');
                  $this.siblings().removeClass('suppa_linksTwo_categoriesContainer_current');
              });
          });

      },


      /**
       * Create RWD New Menu, Then change the class's of Menu's & Submenu's
       * @param $menu the menu object
       * @param config Custom menu settings & style
       *
       */
      rwdBuild : function ( $menu, config ){
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
              if( ! jQuery(this).is('.suppa_fa_carret_left') ){
                  var $menu_class_attr = jQuery(this).attr('class');
                  $menu_class_attr = $menu_class_attr.replace(/.+/g,'era_rwd_suppa_arrow_box');
                  jQuery(this).attr('class',$menu_class_attr);
              }
          });
          $rwd.find('.suppa_rwd_menu_dropdown .suppa-caret-right').attr('class','suppa-caret-down');
          $rwd.find('.suppa_menu_logo').hide();

          // Logo
           suppaMenuOB.rwd_layout_and_logo( $rwd, config );

          // Mega Posts
          $rwd.find('.suppa_mega_posts_categories a').each(function(){
              var $this   = jQuery(this);
              var $cat    = $this.attr('data-cat');
              var $parent = $this.parent().parent();

              var $posts = $parent.find('div[data-cat="'+$cat+'"]').clone();
              $parent.find('div[data-cat="'+$cat+'"]').remove();
              var $clone = $this.clone();

              $parent.append( $clone ).append( $posts );
              $this.remove();
          });
          $rwd.find('.suppa_mega_posts_categories').remove();
          $rwd.find('.suppa_mega_posts_allposts').remove();
          $rwd.find('.suppa_rwd_menu_mega_posts .era_rwd_suppa_arrow_box span').attr('class','suppa-caret-down');

          // Mega Links Style Two
          $rwd.find('.suppa_rwd_menu_linksTwo').addClass('suppa_rwd_menu_dropdown');
          $rwd.find('.suppa_linksTwo_categoriesContainer a').each(function(){
              var $this       = jQuery(this);
              $this.find('.suppa-caret-right').attr('class','suppa-caret-down');

              var clone       = $this.clone()[0];
              var links_clone = $this.parents('.suppa_rwd_submenu')
                                      .find( '.suppa_linksTwo_cat_'+$this.attr('data-targetcat') )
                                      .attr('class','suppa_rwd_submenu suppa_rwd_submenu_'+$this.attr('data-targetcat'))
                                      .clone();
              $this.parents('.suppa_rwd_submenu')
                      .find( '.suppa_rwd_submenu_'+$this.attr('data-targetcat') )
                      .remove();

              $this.parents('.suppa_rwd_submenu')
                      .append( '<div class="suppa_dropdown_item_container suppa_dropdown_item_container_'+$this.attr('data-targetcat')+'"><a class="' + clone['className'] + '" href="' + clone['href']+ '">'+ clone['innerHTML'] +'</a></div>' );

              $this.parents('.suppa_rwd_submenu')
                      .find('.suppa_dropdown_item_container_'+$this.attr('data-targetcat'))
                      .append(links_clone)
                      .find('.suppa_rwd_submenu_'+$this.attr('data-targetcat') +' a ' )
                      .wrap('<div class="suppa_dropdown_item_container">');

          });
          $rwd.find('.suppa_linksTwo_categoriesContainer').remove();
          $rwd.find('.suppa_rwd_menu_linksTwo .suppa_rwd_submenu').removeAttr('style');

          // Search Form
          var search_wrap     = $menu.find('.suppa_rwd_menu_search');
          var search_form     = search_wrap.find('form');
          search_form.addClass('suppa_rwd_search');

          // Clone search
          var search_clone    = search_form.clone();

          // remove the search wrap
          search_wrap.remove();

          // append search to the end
          if( config.rwd_search == 'on' ){
            $rwd.children('.suppa_rwd_menus_container').append( '<div class="suppa_rwd_menu suppa_rwd_search_wrap"></div>' );
            $rwd.find('.suppa_rwd_search_wrap').append( search_clone );
          }

          // Fix for HTML Menu Not Full Width
          $rwd.find('.suppa_rwd_submenu_html').css('width','100%');

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
      rwdTrigger : function ( $menu, config ){
          var $rwd    = $menu.children('.suppaMenu_rwd_wrap');
          var $rwd_c  = $rwd.children('.suppa_rwd_menus_container');
          $rwd_c.width( $menu.width() );

          // Fixed Width for Slide animation
          jQuery( window ).on( 'resize', function(){
              $rwd_c.width( $menu.parent().width() );
          });

          // Display RWD
          if( config.rwd_logo_enable != 'no_logo' ){

              $rwd.parent().find('.suppa_rwd_logo');

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

          // Mega Posts
          // Category Link click
          $rwd.find('.suppa_rwd_submenu_mega_posts > a ').each(function(){
              var $this = jQuery(this);
              $this.on({
                  'click' : function( event ){

                      if( !$this.is('.era_rwd_suppa_submenu_box') )
                      {
                          event.preventDefault();
                          event.stopPropagation();

                          switch ( config.jquery_anim )
                          {
                          case "none":
                              $this.next('.suppa_mega_posts_allposts_posts').show(config.jquery_time);
                              break;
                          case "fade":
                              $this.next('.suppa_mega_posts_allposts_posts').fadeIn(config.jquery_time);
                              break;
                          case "slide":
                              $this.next('.suppa_mega_posts_allposts_posts').slideDown(config.jquery_time);
                              break;
                          }

                          /** Lazy Load & Retina **/
                          $this.next('.suppa_mega_posts_allposts_posts').find('.suppa_lazy_load').each(function(){
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


                          $this.children('.era_rwd_suppa_arrow_box')
                              .addClass('era_rwd_suppa_arrow_both_open')
                              .children('span')
                              .attr('class','suppa-caret-up');
                          $this.addClass('era_rwd_suppa_submenu_box era_rwd_suppa_link_both_open');
                      }

                  }
              });
          });

          // Category Link Arrow click
          $rwd.find('.suppa_rwd_submenu_mega_posts > a > span').each(function(){
              var $this = jQuery(this);

              $this.on({
                  'click' : function( event ){

                      if( $this.is('.era_rwd_suppa_arrow_both_open') )
                      {
                          event.preventDefault();
                          event.stopPropagation();

                          switch ( config.jquery_anim )
                          {
                          case "none":
                              $this.parent().next('.suppa_mega_posts_allposts_posts').stop(true, true).hide(config.jquery_time / 2);
                              break;
                          case "fade":
                              $this.parent().next('.suppa_mega_posts_allposts_posts').stop(true, true).fadeOut(config.jquery_time / 2);
                              break;
                          case "slide":
                              $this.parent().next('.suppa_mega_posts_allposts_posts').stop(true, true).slideUp(config.jquery_time / 2);
                              break;
                          }

                          $this.removeClass('era_rwd_suppa_arrow_both_open')
                                  .children('span').attr('class','suppa-caret-down');
                          $this.parent().removeClass('era_rwd_suppa_submenu_box era_rwd_suppa_link_both_open');

                      }
                  }
              });

          });
      },


      /**
       * Adjust Submenu Align for HTML/LINKS on RWD
       *
       * @param $menu the menu object
       * @param config Custom menu settings & style
       *
       */
      rwdAdjustSubmenuAlign : function ( $menu, config ){
          $menu.find('.suppa_rwd_submenu_columns_wrap, .suppa_rwd_submenu_html').each(function(){
              jQuery(this).attr('style','width:100%;');
          });
      },


      /**
       * Check & Support WPML
      **/
      wpml_support : function ( $menu, config ){
        var $wpml = $menu.find('.menu-item-language');
        if( $wpml.length > 0 ){
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
            if( $wpml_ul.length > 0 ){

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
      },


      /**
       * Retina Support, change icon/logo to retina
      **/
      retina_support : function ( $menu, config ){
        if( config.retina_device ){
            config.retina_device = true;
            $menu.find('.suppa_upload_img').each(function(){
                var $this = jQuery(this);
                $this.attr('src', $this.attr('data-retina') );
            });

            /** Logo **/
            config.logo_src = config.logo_retina_src;
            config.rwd_logo_src = config.rwd_logo_retina_src;
        }
      },


      responsive : function( $menu, config ){

        if( config.rwd_enable == 'on' ){

          suppaMenuOB.rwdBuild( $menu , config );
          suppaMenuOB.rwdTrigger( $menu , config );

          var $rwd_width          = config.rwd_start_width,
              $window_width       = jQuery(window).width(),
              $main_menu          = $menu.children('.suppaMenu'),
              $rwd_menus          = $menu.children('.suppaMenu_rwd_wrap'),
              $rwd_logo  = $menu.find('.suppa_rwd_logo'),
              $logo      = $menu.find('.suppa_menu_logo.logo_top_center, .suppa_menu_logo.logo_top_left, .suppa_menu_logo.logo_top_right');

            // Hide Main Menu & Show Responsive menu when the window width <= rwd start width
            if( $rwd_width >= $window_width ){
               $main_menu.hide();
               $rwd_menus.show();
               $rwd_logo.show();
               $logo.hide();
            }
            else{
               $main_menu.show();
               $rwd_menus.hide();
               $rwd_logo.hide();
               $logo.show();
            }

            // Window Resize
            jQuery( window ).on( 'resize', function(){

                $window_width   = jQuery(window).width();

                if( $rwd_width >= $window_width ){
                  $main_menu.hide();
                  $rwd_menus.show();
                  $rwd_logo.show();
                  $logo.hide();
                }
                else{
                  $main_menu.show();
                  $rwd_menus.hide();
                  $rwd_logo.hide();
                  $logo.show();
                }

            });

          }

      },

  };

  /** Plugin **/
  $.fn.suppamenu = function( options ){

      // Default Options
      var config = jQuery.extend({
          jquery_mode         : 'off',
          jquery_trig         : 'hover-intent',
          jquery_anim         : 'slide',
          jquery_time         : 450,
          rwd_enable          : 'on',
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
          retina_device         : ( window.devicePixelRatio >= 2 ),
      }, options );

      /** Get Menu **/
      var $menu_wrap  = this;

      /** UnBind Events **/
      $menu_wrap.removeAttr('id');
      $menu_wrap.find('a')
        .removeClass('menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-type-custom menu-item-object-custom');

      /** Detect Retina Devices **/
      suppaMenuOB.retina_support( $menu_wrap, config );

      /** Layout & Logo **/
      suppaMenuOB.layout_and_logo( $menu_wrap, config );

      /** WPML Support **/
      suppaMenuOB.wpml_support( $menu_wrap, config );

      /** Adjust Submenu Align **/
      suppaMenuOB.rwdAdjustSubmenuAlign( $menu_wrap, config );


      /** Box Layout **/
      if( config.box_layout == 'wide_layout' )
        $menu_wrap.addClass('suppaMenu_wrap_wide_layout');

      /** Recent Posts : View All Button **/
      if( config.recent_posts_view_all == "on" )
        $menu_wrap.find('.suppa_latest_posts_view_all').css('display','block');
      else
        $menu_wrap.find('.suppa_latest_posts_view_all').css('display','none');

      /** Responsive **/
      suppaMenuOB.responsive( $menu_wrap, config );

      /** Mobile **/
      if( /Android|iPhone|iPad|iPod|BlackBerry|webOS|IEMobile|Opera Mini/i.test(navigator.userAgent) && 'ontouchstart' in document.documentElement){
        // maybe this is a mobile but the responsive start is < from the device with !
        // hover is not good in this case
        config.jquery_trig = 'click';
      }

      // Desktop / Laptop
      /** Triggers **/
      switch( config.jquery_trig ){
        case 'click' :
            suppaMenuOB.clickTrigger( $menu_wrap , config );
        break;

        case 'hover-intent' :
            suppaMenuOB.hoverTrigger( $menu_wrap , config );
        break;
      }

      /** Close When click outside **/
      suppaMenuOB.clickOutsideCloseSubmenus( $menu_wrap, config );

      return this;
  };

}( jQuery ));