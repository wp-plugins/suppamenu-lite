/*********************************************************************************************************
 *
 * Codetemp Framework ( CTFramework )
 *
 * @author Taieb Sabri (codetemp), http://vamospace.com
 * @version 1.2.5
 *
 * Start 2013-6-2
 * Last Update 2013-10-07
 *
 * Required WP 3.5+ (*)
 *
 * --- You Are Not Allowed To Use This Framework , To Build WordPress Plugins or Themes !!!
 * --- You Have To Purchase A Licence From codezag@gmail.com
 *
 /*********************************************************************************************************/


jQuery(document).ready(function(){

	/** Import Message **/
	if( jQuery( document ).find('.suppa_fileuploaded').length > 0 )
	{
		jQuery(".codetemp_ajax_response_backup").fadeIn(200);

		setTimeout( function(){

			jQuery(".codetemp_ajax_response_backup").fadeOut(200);

		}, 4000 );
	}


	/** Main Nav : Show/Hide pages **/
	jQuery('.codetemp_main_nav').on({
		click : function(){
			var $this = jQuery(this);
			var $target = $this.attr('href').replace( '#' , '' );

			jQuery('.codetemp_main_nav > li').removeClass('selected');
			$this.parent().addClass('selected');

			$this.parents('.codetemp_nav_pages_container').find('.codetemp_page').slideUp(200);

			if( $this.parents('.codetemp_nav_pages_container').find('#'+$target).length > 0 )
				$this.parents('.codetemp_nav_pages_container').find('#'+$target).slideDown(200);
			else
				$this.parents('.codetemp_nav_pages_container').find('#'+$target+'_1').slideDown(200);
			return false;
		}
	}, '> li > a' );
	/* second nav */
	jQuery('.codetemp_main_nav ul').on({
		click : function(){
			var $this = jQuery(this);
			var $target = $this.attr('href').replace( '#' , '' );

			jQuery('.codetemp_main_nav ul a').removeClass('selected');
			$this.addClass('selected');

			$this.parents('.codetemp_nav_pages_container').find('.codetemp_page').slideUp(200);
			$this.parents('.codetemp_nav_pages_container').find('#'+$target).slideDown(200);

			return false;
		}
	}, 'a' );


	/** Tab : Show / Hide **/
	jQuery('.codetemp_pages_container').on({
		click : function(){
			jQuery(this).parent().parent().parent().children('.codetemp_tab_inside').slideToggle(200);
		}
	}, '.codetemp_tab_display_icon' );


	/** Ace Editor **/
	var ace_editors = [];
	jQuery('.codetemp_pages_container').find('.ctf_option_ace_editor').each(function(i){
		var $this = jQuery(this);
		var $this_id = $this.attr('id');

		ace_editors[i] = ace.edit( $this_id + "_ace" );
		ace_editors[i].setTheme("ace/theme/monokai");
		ace_editors[i].setOptions({
			fontSize: "13pt"
		});
	});


	/** Ajax **/
	jQuery('.codetemp_settings_container').on({
		click : function(){

			var $this 				= jQuery(this);
			var $form 				= $this.parents('#codetemp_form');
			var $nonce 				= $form.find('#nonce').val();
			var $parent 			= $form.find('#codetemp_parent').val();
			var $group_id 			= $form.find('#codetemp_group_id').val();
			var $option_id 			= $form.find('#codetemp_option_id').val();
			var $wp_ajax_function 	= $form.find('#action').val();
			var $plugin_url 		= $form.find('#codetemp_plugin_url').val();
			var $data				= "";

			// Set Loading Image
			var $html_ajax_img_load = $plugin_url + 'core/img/ajax-loader.gif';
			var $html_ajax_img_save = $plugin_url + 'core/img/success_icon.png';
			var $html_ajax_res = jQuery('.codetemp_ajax_response');

			$html_ajax_res.children('img').attr( 'src' , $html_ajax_img_load );
			$html_ajax_res.children('span').text('');

			// Solve Tinymce issue
			if( typeof tinyMCE !== "undefined" )
				tinyMCE.triggerSave();

			// Get Content From ACE Editors
			jQuery('.codetemp_pages_container').find('.ctf_option_ace_editor').each(function(i){
				jQuery(this).val( ace_editors[i].getSession().getValue() );
			});

			// Update or ADD Options ( all or by ID )
			if( $this.is('.codetemp_button_update_all') )
			{
				$html_ajax_res.show();

				// Added New Skins to "select tag"
				var $new_skin = jQuery('#suppa_skin_name').val();
				if( $new_skin != "" )
				{
					jQuery('select[name="skin_modify"]').append('<option value="'+$new_skin+'">'+$new_skin+'</option>');
				}

				// Search Groups
				var $data_string = "";
				var $op_count = 0;
				var $op_sep = "";

				// Add Options to their group
				$form.find('.codetemp_nav_pages_container').find('input[type="text"], input[type="hidden"], input[type="password"], input[type="radio"]:checked, input[type="checkbox"], textarea,select').each(function(){
					if( $op_count == 0 )
					{
						$op_sep = '__ctfand__';
					}
					$op_count = $op_count + 1;

					var $this = jQuery(this);
					var $name = $this.attr('name');

					$data_string = $data_string + $op_sep +	$name + '__ctfequal__'	+ encodeURIComponent( $this.val() );

				});

				// Ajax Call
				jQuery.ajax({
					type	:	'POST',
					url		:	ajaxurl,
					data	:	{
									action 				: $wp_ajax_function,
									ctf_request_type 	: 'update_all',
									nonce 				: $nonce,
									data_string 		: $data_string,
									skin_name 			: jQuery('#suppa_skin_name').val()
							 },
					cache	: false,
					success	: function( response )
					{
						$html_ajax_res.children('img').remove();
						$html_ajax_res.children('span').html( response );
						setTimeout(function(){
							$html_ajax_res.fadeOut(200);
						}, 4000);
					},
					error	: function( )
					{
						$request_response = 'ajax_error';
					}
				});

				return false;
			}

			// Reset All Options
			else if( $this.is('.codetemp_button_reset_all') )
			{
				var r=confirm("Yes , Reset!");
				if (r==false)
				{
					$html_ajax_res.fadeOut(200) ;
					return false;
				}
				$html_ajax_res.show();

				$all_data = 'nonce=' + $nonce + '&action=' + $wp_ajax_function + '&ctf_request_type=reset_all';

				jQuery.ajax({
					type	: 'POST',
					url		: ajaxurl,
					data	: $all_data,
					cache	: false,
					async	: false,
					success	: function( response )
					{
						$html_ajax_res.children('img').attr( 'src' , $html_ajax_img_save );
						$html_ajax_res.children('span').html(response);

						setTimeout( function(){
							location.reload( true );
						},4000);

					},
					error	: function( response )
					{
						$html_ajax_res.children('img').attr( 'src' , $html_ajax_img_save );
						$html_ajax_res.children('span').text(response);

						setTimeout( function(){
							$html_ajax_res.fadeOut(200);
						}, 1000 );
					}
				});
			}

			return false;
		}
	}, '.codetemp_button_update_all, .codetemp_button_reset_all, .codetemp_button_delete_group, .codetemp_button_delete_option' );

	/** Hide Saving Box **/
	jQuery('.codetemp_ajax_response_close').click(function(event){
		jQuery('.codetemp_ajax_response').fadeOut(200);
		event.preventDefault();
	});

	/** Checkbox **/
	jQuery('.codetemp_pages_container').find('input[type="checkbox"]').each(function(){
		var $this = jQuery(this);
		var $this_id = $this.attr('id');

		if( $this.val().toLowerCase() == 'on' )
		{
			jQuery('.codetemp_pages_container label[for="'+$this_id+'"]').css({ 'background-position' : 'left center' });
		}
		else
		{
			jQuery('.codetemp_pages_container label[for="'+$this_id+'"]').css({ 'background-position' : 'right center' });
		}
	});

	jQuery('.codetemp_pages_container').on({
		click : function()
		{
			var $this = jQuery(this);
			var $this_id = $this.attr('id');
			if( $this.val().toLowerCase() == 'on' )
			{
				$this.val('off');
				jQuery('.codetemp_pages_container label[for="'+$this_id+'"]').css({ 'background-position' : 'right center' });
			}
			else
			{
				$this.val('on');
				jQuery('.codetemp_pages_container label[for="'+$this_id+'"]').css({ 'background-position' : 'left center' });
			}

			return false;
		}
	}, '.ctf_option_checkbox' );



	/** Colorpicker **/
	jQuery('input.ctf_option_colorpicker').ColorPicker({
			onSubmit: function(hsb, hex, rgb, el)
			{
				jQuery(el).val("#" + hex);
				jQuery(el).ColorPickerHide();
				jQuery(el).next().css({"background-color":"#"+hex});
			},
			onBeforeShow: function ()
			{
				jQuery(this).ColorPickerSetColor(this.value);
			}
		})
		.bind('keyup', function()
		{
			jQuery(this).ColorPickerSetColor(this.value);
		}
	);


	/** Upload Images with Wordpress **/
	// WP 3.5+
	// Enqueue Media uploader scripts and environment [ wp_enqueue_media() ].
	// Strongly suggest to use this function on the admin_enqueue_scripts action hook. Using it on admin_init hook breaks it
	// How To : http://stackoverflow.com/questions/13847714/wordpress-3-5-custom-media-upload-for-your-theme-options
	// Don't Foooooooooooooooooorget to  array('jquery' , 'media-upload' , 'thickbox')  to the enqueue
	jQuery( '.codetemp_pages_container' ).on({
		click : function()
		{
		    var send_attachment_bkp = wp.media.editor.send.attachment;
		    var $this = jQuery(this);

		    wp.media.editor.send.attachment = function(props, attachment) {
		        $this.prev().val(attachment.url);
		        // back to first state
		        wp.media.editor.send.attachment = send_attachment_bkp;
		    };

		    wp.media.editor.open();

		    return false;
		}
	}, '.ctf_option_upload_button' );



	/** Font Style **/
	jQuery('.codetemp_pages_container').on({
		click : function()
		{
			var $this			= jQuery(this).parents('.ctf_option_container_font');
			var $box			= $this.find('.ctf_box_desc');
			var $font_size		= $this.find('.ctf_option_font_size').val();
			var $font_family	= $this.find('.ctf_option_font_family').val();
			var $font_style		= $this.find('.ctf_option_font_family_style').val();
			var $font_color		= $this.find('.ctf_option_font_color').val();
			  WebFont.load({
			    google: {
			      families: [ $this.find('.ctf_option_font_family').find(':selected').text() ]
			    }
			  });

			$box.parents('.ctf_box').slideDown(200);
			$box.css({ 'line-height' : '1.5em' , 'font-size' : $font_size+'px' , 'font-family' : $font_family , 'color' : $font_color });

			$box.attr('style', $box.attr('style') + $font_style );

			return	false;
		}
	}, '.ctf_option_font_demo' );


	/** BOX'S : Hide **/
	jQuery('.ctf_box').on({
		click : function(){
			jQuery(this).parents('.ctf_box').slideUp(200);
			return false;
		}
	}, '.ctf_box_close');

});