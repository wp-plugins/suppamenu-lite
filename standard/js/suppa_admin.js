/**
 * Admin Script
 *
 * @package 	CTFramework
 * @author		Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link		http://vamospace.com
 * @since		Version 1.0
 *
 */

(function($) {

	var suppa_menu = {

		// Mega Posts : Menu Item Child , show Category settings
		initSortables : function() {
			var currentDepth = 0, originalDepth, minDepth, maxDepth,
				prev, next, prevBottom, nextThreshold, helperHeight, transport,
				menuEdge = api.menuList.offset().left,
				body = $('body'), maxChildDepth,
				menuMaxDepth = initialMenuMaxDepth();

			if( 0 !== $( '#menu-to-edit li' ).length )
				$( '.drag-instructions' ).show();

			// Use the right edge if RTL.
			menuEdge += api.isRTL ? api.menuList.width() : 0;

			api.menuList.sortable({
				handle: '.menu-item-handle',
				placeholder: 'sortable-placeholder',
				start: function(e, ui) {
					var height, width, parent, children, tempHolder;

					// handle placement for rtl orientation
					if ( api.isRTL )
						ui.item[0].style.right = 'auto';

					transport = ui.item.children('.menu-item-transport');

					// Set depths. currentDepth must be set before children are located.
					originalDepth = ui.item.menuItemDepth();
					updateCurrentDepth(ui, originalDepth);

					// Attach child elements to parent
					// Skip the placeholder
					parent = ( ui.item.next()[0] == ui.placeholder[0] ) ? ui.item.next() : ui.item;
					children = parent.childMenuItems();
					transport.append( children );

					// Update the height of the placeholder to match the moving item.
					height = transport.outerHeight();
					// If there are children, account for distance between top of children and parent
					height += ( height > 0 ) ? (ui.placeholder.css('margin-top').slice(0, -2) * 1) : 0;
					height += ui.helper.outerHeight();
					helperHeight = height;
					height -= 2; // Subtract 2 for borders
					ui.placeholder.height(height);

					// Update the width of the placeholder to match the moving item.
					maxChildDepth = originalDepth;
					children.each(function(){
						var depth = $(this).menuItemDepth();
						maxChildDepth = (depth > maxChildDepth) ? depth : maxChildDepth;
					});
					width = ui.helper.find('.menu-item-handle').outerWidth(); // Get original width
					width += api.depthToPx(maxChildDepth - originalDepth); // Account for children
					width -= 2; // Subtract 2 for borders
					ui.placeholder.width(width);

					// Update the list of menu items.
					tempHolder = ui.placeholder.next();
					tempHolder.css( 'margin-top', helperHeight + 'px' ); // Set the margin to absorb the placeholder
					ui.placeholder.detach(); // detach or jQuery UI will think the placeholder is a menu item
					$(this).sortable( 'refresh' ); // The children aren't sortable. We should let jQ UI know.
					ui.item.after( ui.placeholder ); // reattach the placeholder.
					tempHolder.css('margin-top', 0); // reset the margin

					// Now that the element is complete, we can update...
					updateSharedVars(ui);
				},
				stop: function(e, ui) {

					var children, subMenuTitle,
						depthChange = currentDepth - originalDepth;

					// Return child elements to the list
					children = transport.children().insertAfter(ui.item);

					// Add "sub menu" description
					subMenuTitle = ui.item.find( '.item-title .is-submenu' );
					if ( 0 < currentDepth )
						subMenuTitle.show();
					else
						subMenuTitle.hide();

					// Update depth classes
					if ( 0 !== depthChange ) {
						ui.item.updateDepthClass( currentDepth );
						children.shiftDepthClass( depthChange );
						updateMenuMaxDepth( depthChange );
					}
					// Register a change
					api.registerChange();
					// Update the item data.
					ui.item.updateParentMenuItemDBId();

					// address sortable's incorrectly-calculated top in opera
					ui.item[0].style.top = 0;

					// handle drop placement for rtl orientation
					if ( api.isRTL ) {
						ui.item[0].style.left = 'auto';
						ui.item[0].style.right = 0;
					}

					api.refreshKeyboardAccessibility();
					api.refreshAdvancedAccessibility();


					if( !ui.item.is('.suppa_menu_item_mega_posts') && ui.item.is('.menu-item-depth-1') )
					{

						var suppa_item 			= ui.item;
						var suppa_item_parent	= suppa_item.parents('.suppa_menu_item');

						var suppa_item_classes 	= suppa_item.attr('class').split(' ');

						if( suppa_item.prev('.menu-item').is('.suppa_menu_item_mega_posts') )
						{
							var suppa_prev_classes = suppa_item.prev('.menu-item').attr('class').split(' ');
							suppa_item_classes[1] = suppa_prev_classes[1];
							suppa_item_classes[2] = suppa_prev_classes[2];
							var suppa_new_class_string = "";

							$.each( suppa_item_classes , function( index, value ) {
								suppa_new_class_string = suppa_new_class_string + value + " ";
							});
							suppa_item.attr('class',suppa_new_class_string);
						}

					}

				},
				change: function(e, ui) {
					// Make sure the placeholder is inside the menu.
					// Otherwise fix it, or we're in trouble.
					if( ! ui.placeholder.parent().hasClass('menu') ){
						(prev.length) ? prev.after( ui.placeholder ) : api.menuList.prepend( ui.placeholder );
					}
					updateSharedVars(ui);


				},
				sort: function(e, ui) {
					var offset = ui.helper.offset(),
						edge = api.isRTL ? offset.left + ui.helper.width() : offset.left,
						depth = api.negateIfRTL * api.pxToDepth( edge - menuEdge );
					// Check and correct if depth is not within range.
					// Also, if the dragged element is dragged upwards over
					// an item, shift the placeholder to a child position.
					if ( depth > maxDepth || offset.top < prevBottom ) depth = maxDepth;
					else if ( depth < minDepth ) depth = minDepth;

					if( depth != currentDepth )
						updateCurrentDepth(ui, depth);

					// If we overlap the next element, manually shift downwards
					if( nextThreshold && offset.top + helperHeight > nextThreshold ) {
						next.after( ui.placeholder );
						updateSharedVars( ui );
						$( this ).sortable( 'refreshPositions' );
					}
				}
			});

			function updateSharedVars(ui) {
				var depth;

				prev = ui.placeholder.prev();
				next = ui.placeholder.next();

				// Make sure we don't select the moving item.
				if( prev[0] == ui.item[0] ) prev = prev.prev();
				if( next[0] == ui.item[0] ) next = next.next();

				prevBottom = (prev.length) ? prev.offset().top + prev.height() : 0;
				nextThreshold = (next.length) ? next.offset().top + next.height() / 3 : 0;
				minDepth = (next.length) ? next.menuItemDepth() : 0;

				if( prev.length )
					maxDepth = ( (depth = prev.menuItemDepth() + 1) > api.options.globalMaxDepth ) ? api.options.globalMaxDepth : depth;
				else
					maxDepth = 0;
			}

			function updateCurrentDepth(ui, depth) {
				ui.placeholder.updateDepthClass( depth, currentDepth );
				currentDepth = depth;
			}

			function initialMenuMaxDepth() {
				if( ! body[0].className ) return 0;
				var match = body[0].className.match(/menu-max-depth-(\d+)/);
				return match && match[1] ? parseInt( match[1], 10 ) : 0;
			}

			function updateMenuMaxDepth( depthChange ) {
				var depth, newDepth = menuMaxDepth;
				if ( depthChange === 0 ) {
					return;
				} else if ( depthChange > 0 ) {
					depth = maxChildDepth + depthChange;
					if( depth > menuMaxDepth )
						newDepth = depth;
				} else if ( depthChange < 0 && maxChildDepth == menuMaxDepth ) {
					while( ! $('.menu-item-depth-' + newDepth, api.menuList).length && newDepth > 0 )
						newDepth--;
				}
				// Update the depth class.
				body.removeClass( 'menu-max-depth-' + menuMaxDepth ).addClass( 'menu-max-depth-' + newDepth );
				menuMaxDepth = newDepth;
			}
		},

		// Delete Menu Types if item is not depth === 0
		eventOnClickMenuSave : function() {
			var locs = '',
			menuName = $('#menu-name'),
			menuNameVal = menuName.val();
			// Cancel and warn if invalid menu name
			if( !menuNameVal || menuNameVal == menuName.attr('title') || !menuNameVal.replace(/\s+/, '') ) {
				menuName.parent().addClass('form-invalid');
				return false;
			}
			// Copy menu theme locations
			$('#nav-menu-theme-locations select').each(function() {
				locs += '<input type="hidden" name="' + this.name + '" value="' + $(this).val() + '" />';
			});
			$('#update-nav-menu').append( locs );
			// Update menu item position data
			api.menuList.find('.menu-item-data-position').val( function(index) { return index + 1; } );
			window.onbeforeunload = null;

			// Delete Menu types for depth > 0
			api.menuList.find('.suppa_menu_item').each(function(){
				var c = $(this);
				if( !c.is('.menu-item-depth-0') )
				{
					c.find('.admin_suppa_box_menu_type').remove();
					c.find('#menu-item-suppa-link_position_container').remove();
					c.find('#menu-item-suppa-link_logged_in').remove();
					c.find('#menu-item-suppa-link_icon_only').remove();

					/** Remove Mega Posts Box for non mega posts items **/
					if( !c.is('.suppa_menu_item_mega_posts') )
					{
						c.find('.admin_suppa_box_mega_posts').remove();
					}
				}
				else
				{
					if( c.is('.suppa_menu_item_mega_posts') )
					{
						c.find('.admin_suppa_box_mega_posts').remove();
					}
					var menu_item_type = c.find('.admin_suppa_box_menu_item_types input:checked').val();

					c.find('.suppa_box_type').each(function(){
						if( !jQuery(this).is('.admin_suppa_box_option_inside_'+menu_item_type) )
							jQuery(this).remove();
					});
				}
			});

			return true;
		},

		/** Switch Menu Backend with Ajax **/
		addItemToMenu : function(menuItem, processMethod, callback) {
			var menu = jQuery('#menu').val(),
				nonce = jQuery('#menu-settings-column-nonce').val();

			processMethod = processMethod || function(){};
			callback = callback || function(){};

			params = {
				'action': 'suppa_switch_menu_walker',
				'menu': menu,
				'menu-settings-column-nonce': nonce,
				'menu-item': menuItem
			};

			jQuery.post( ajaxurl, params, function(menuMarkup) {
				var ins = jQuery('#menu-instructions');
				processMethod(menuMarkup, params);
				if( ! ins.hasClass('menu-instructions-inactive') && ins.siblings().length )
					ins.addClass('menu-instructions-inactive');
				callback();
			});
		},

		/** Show / Hide Options Container **/
		options_container : function()
		{
			jQuery( document ).on('click', '.admin_suppa_box_header a',
				function()
				{
					var $this 	= jQuery(this);
					if( $this.text() == '+' )
					{
						$this.parents('.admin_suppa_box').find('.admin_suppa_box_container').slideDown(80);
						$this.text('-');
					}
					else
					{
						$this.parents('.admin_suppa_box').find('.admin_suppa_box_container').slideUp(80);
						$this.text('+');
					}
				}
			);
		},

		/** Show / Hide Menu type options **/
		menu_type_options : function()
		{
			jQuery( document ).on('click', '.suppa_menu_type',
				function()
				{
					var $this 	= jQuery(this);
					var type 	= $this.val();
					var parent 	= $this.parents('.suppa_menu_item');

					parent.find('.menu-item-handle .item-type').text('( '+type+' )');
					$this.parents('.admin_suppa_box_container').find('.admin_suppa_box_option_inside').slideUp(80);
					$this.parents('.admin_suppa_box_container').find('.admin_suppa_box_option_inside_'+type).slideDown(80);

					if( type == 'mega_posts' )
					{
						var classes 			= parent.attr('class').split(' ');
						classes[2] = "suppa_menu_item_mega_posts";

						var parent_new_class	= "";
						$.each( classes , function( index, value ) {
  							parent_new_class = parent_new_class + value + " ";
						});
						parent.attr('class',parent_new_class);


						$this.parents('#menu-to-edit').find('.' + classes[1] ).each(function(){
							var son 			= jQuery(this);
							var son_classes 	= son.attr('class').split(' ');
							var son_new_class 	= "";
							son_classes[2] = "suppa_menu_item_mega_posts";

							if( ! son.is('.menu-item-depth-0') )
							{
								$.each( son_classes , function( index, value ) {
		  							son_new_class = son_new_class + value + " ";
								});
								son.attr('class',son_new_class);
							}
						});

					}

				}
			);
		},

		/** Upload Images with Wordpress ( wp 3.5.2+ ) **/
		upload_images : function()
		{
			jQuery( document ).on('click', '.admin_suppa_upload', function(){

				var send_attachment_bkp = wp.media.editor.send.attachment;
			    var $this = jQuery(this);

			    wp.media.editor.send.attachment = function(props, attachment) {
			        $this.parent().find('.admin_suppa_upload_input').val(attachment.url);
				    // back to first state
				    wp.media.editor.send.attachment = send_attachment_bkp;
				};

				wp.media.editor.open();

				return false;
			});
		},

		/** Show / Hide More Options When Disable FullWidth **/
		fullwidth_checkbox_click : function()
		{
			jQuery( document ).on('click', '.admin_suppa_fullwidth_checkbox',
				function()
				{
					var $this = jQuery(this);
					if( $this.is(':checked') )
					{
						$this.val('on');
						$this.parents('.admin_suppa_box_option_inside').find('.admin_suppa_fullwidth_div').hide();
					}
					else
					{
						$this.val('off');
						$this.parents('.admin_suppa_box_option_inside').find('.admin_suppa_fullwidth_div').show();
					}
				}
			);
		},

		/** Show / Hide FullWidth More Options When Page Load  **/
		fullwidth_checkbox : function()
		{
			jQuery('.admin_suppa_fullwidth_checkbox').each(function(){
				var $this = jQuery(this);
				if( $this.is(':checked') )
				{
					$this.parents('.admin_suppa_box_option_inside').find('.admin_suppa_fullwidth_div').hide();
				}
				else
				{
					$this.parents('.admin_suppa_box_option_inside').find('.admin_suppa_fullwidth_div').show();
				}
			});
		},

		/** Add Tinymce Editor **/
		wp_editor_set_content : function()
		{
			jQuery( document ).on('click', '.admin_suppa_edit_button',
				function()
				{
					var $this = jQuery(this);
					var $id 	= $this.attr('id');

					var $textarea 	= $this.parent().parent().find('textarea');
					var $content 	= $textarea.val();

					jQuery('.admin_suppa_getContent_button').attr('id', $id);

					tinyMCE.get('suppa_wp_editor_the_editor').setContent( $content, {format : 'raw'});

					jQuery('.era_admin_widgets_container').fadeIn(100);

					jQuery('.suppa_wp_editor_container').fadeIn(100);

					return false;
				}
			);
		},

		/** Get Content from WordPress Editor **/
		wp_editor_get_content : function()
		{
			jQuery( document ).on('click', '.admin_suppa_getContent_button',
				function()
				{
					var $this 	= jQuery(this);
					var $id 	= $this.attr('id');
					var $textarea 	= jQuery('#edit-menu-item-suppa-html_content-'+$id);

					var content;
					var editor = tinyMCE.get('suppa_wp_editor_the_editor');
					if (editor) {
					    // Ok, the active tab is Visual
					    content = editor.getContent();
					} else {
					    // The active tab is HTML, so just query the textarea
					    content = $('#'+'suppa_wp_editor_the_editor').val();
					}

					$textarea.val( content );

					jQuery('.era_admin_widgets_container').fadeOut(100);
					jQuery('.suppa_wp_editor_container').fadeOut(100);

					return false;
				}
			);
		},

		/** Show Front Awesome Widget **/
		show_fontAwesome_widget : function()
		{
			jQuery( document ).on('click', '.admin_suppa_selectIcon_button',
				function()
				{
					var $this = jQuery(this);
					var $id 	= $this.attr('id');

					jQuery('.admin_suppa_addIcon_button').attr('id', $id);

					jQuery('.era_admin_widgets_container').fadeIn(100);
					jQuery('.suppa_fontAwesome_container').fadeIn(100);

					return false;
				}
			);
		},

		/** Add Font Awesome Icon to the Hidden Input **/
		add_fontAwesome_icon : function()
		{
			jQuery( document ).on('click', '.admin_suppa_addIcon_button',
				function()
				{
					var $this 	= jQuery(this);
					var $id 	= $this.attr('id');
					var $icon 	= jQuery('.suppa_fontAwesome_container').find('.selected').find('span').attr('class');

					jQuery('.admin_suppa_fontAwesome_icon_hidden-'+$id).val( $icon );
					jQuery('.admin_suppa_fontAwesome_icon_box_preview-'+$id).children('span').attr('class',$icon);
					jQuery('.era_admin_widgets_container').fadeOut(100);
					jQuery('.suppa_fontAwesome_container').fadeOut(100);

					return false;
				}
			);
		},

		/** Select Font Awesome Icon **/
		select_fontAwesome_icon : function()
		{
			jQuery( document ).on('click', '.admin_suppa_fontAwesome_icon_box',
				function(){
					var $this 	= jQuery(this);

					jQuery('.admin_suppa_fontAwesome_icon_box').removeClass('selected')
					$this.addClass('selected');

					return false;
				}
			);
		},

		/** Close Widget Container **/
		close_widget_container : function()
		{
			jQuery( document ).on('click', '.era_admin_widget_box_header a',
				function(){

					jQuery('.era_admin_widgets_container').fadeOut(100);
					jQuery('.era_admin_widget_box').fadeOut(100);

					return false;
				}
			);
		},

		/** Upload or Font Awesome **/
		upload_or_fontAwesome : function()
		{
			jQuery( document ).on('change', '.menu-item-suppa-link_icon_type',
				function()
				{
					var $selected = jQuery(this).find('option:selected').val();
					if( $selected == 'upload' )
					{
						jQuery(this).parent().parent().find('.admin_suppa_box_option_inside_icon_upload').fadeIn(80);
						jQuery(this).parent().parent().find('.admin_suppa_box_option_inside_icon_fontawesome').fadeOut(80);
					}
					else if( $selected == 'fontawesome' )
					{
						jQuery(this).parent().parent().find('.admin_suppa_box_option_inside_icon_upload').fadeOut(80);
						jQuery(this).parent().parent().find('.admin_suppa_box_option_inside_icon_fontawesome').fadeIn(80);
					}
					else
					{

					}
					return false;
				}
			);
		},

		// Ajax : Save Menu Location
		ajax_save_location : function()
		{
			jQuery( document ).on('click', '#admin_suppa_save_menu_location',
				function( event )
				{
					event.preventDefault();

					var $this = jQuery(this);
					$this.addClass('admin_suppa_save_menu_location_saving');

					// Get Checked Locations
					var dataString = "";
					jQuery('#suppa_menu_location_selected').find('input:checked').each(function(){
						dataString = dataString + ',' + jQuery(this).val() + '=' + jQuery(this).parent().find('.suppa_menu_location_skin').val();
					});
					dataString = dataString.substr(1);

					var $data = {
						action 		: 'save_locations_skins',
						nonce 		: jQuery('#admin_suppa_save_menu_location_nonce').val(),
						location 	: dataString,
					};

					jQuery.post(ajaxurl, $data, function(response) {
						/** Remove Alert **/
						$this.removeClass('admin_suppa_save_menu_location_saving');
						jQuery('body').append('<div class="suppa_location_saved">Location Saved</div>');
						setTimeout( function(){
							jQuery('.suppa_location_saved').remove();
						},2000);
					});
					return false;
				}
			);
		},


		// Use Icon Only Checkbox
		icon_only_checkbox : function()
		{
			jQuery( document ).on('click', '.suppa_use_icon_only',
				function()
				{
					var $this = jQuery(this);

					if( $this.is(':checked') )
					{
						$this.val('on');
					}
					else
					{
						$this.val('off');
					}
				}
			);
		},


		// Get category id after the menu items loads
		getCatID : function()
		{
			jQuery( '.suppa_all_cats_tax_types' ).each(function(){
				var $this 	= jQuery(this);
				var $cat 	= $this.parent()
								.find('.menu-item-suppa-posts_category').val();
				$this.find('option').removeAttr('selected');
				$this.find('option[value="'+$cat+'"]')
					.attr('selected','selected').text();

				console.log( $cat );
			});
		},


		// Set Cat/taxonomy
		setCatID : function()
		{
			jQuery( document ).on( 'change', '#suppa_all_cats_tax_types', function( event ){
					var $this = jQuery(this).parent();

					//Latest Posts
					$this.parent().find('.menu-item-suppa-posts_category')
						.val( jQuery(this).find(':selected').val() );

					$this.parent().find('.menu-item-suppa-posts_taxonomy')
						.val( jQuery(this).find(':selected').attr('data-taxonomy') );

					//Mega Posts
					$this.parent().find('.menu-item-suppa-mega_posts_category')
						.val( jQuery(this).find(':selected').val() );

					$this.parent().find('.menu-item-suppa-mega_posts_taxonomy')
						.val( jQuery(this).find(':selected').attr('data-taxonomy') );
			});
		},

	};// End Object

	suppa_menu.menu_type_options();
	suppa_menu.options_container();

	suppa_menu.upload_images();

	suppa_menu.fullwidth_checkbox();
	suppa_menu.fullwidth_checkbox_click();

	// Widgets
	suppa_menu.wp_editor_set_content();
	suppa_menu.wp_editor_get_content();
	suppa_menu.show_fontAwesome_widget();
	suppa_menu.select_fontAwesome_icon();
	suppa_menu.add_fontAwesome_icon();
	suppa_menu.close_widget_container();

	suppa_menu.upload_or_fontAwesome();
	suppa_menu.ajax_save_location();

	suppa_menu.icon_only_checkbox();
	suppa_menu.getCatID();
	suppa_menu.setCatID();

	/** Switch Menu Backend with Ajax **/
	if(typeof wpNavMenu != 'undefined')
	{
		// Add Our Item to Menu
		wpNavMenu.addItemToMenu = suppa_menu.addItemToMenu;

		// Delete Menu Types if item is not depth === 0
		wpNavMenu.eventOnClickMenuSave = suppa_menu.eventOnClickMenuSave;

		// Mega Posts : Menu Item Child , show Category settings
		wpNavMenu.initSortables = suppa_menu.initSortables;

		api = wpNavMenu;
	}


})(jQuery);