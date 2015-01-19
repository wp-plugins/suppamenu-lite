/*********************************************************************************************************
 *
 * Codetemp Framework ( CTFramework )
 *
 * @author Taieb Sabri (codetemp), http://vamospace.com
 *
 * @since 2.1.0
 *
 * Required WP 3.5+ (*)
 *
 * --- You Are Not Allowed To Use This Framework , To Build WordPress Plugins or Themes !!!
 * --- You Have To Purchase A Licence From codezag@gmail.com
 *
 /*********************************************************************************************************/

var era_add_inputs = {

	/** Input Text **/
	add_text_input : function( options )
	{
		var html_wrap = "";
		var settings = jQuery.extend({
		            // These are the defaults.
					'group_id'	: 0, 		// Group to save this option on
					'option_id'	: '', 		// Option ID
					'op_title'	: '', 		// Title
					'op_desc'	: '', 		// Description or Help
					'op_value'	: '', 		// option value
					'op_class'	: '', 		// css class
					'op_before'	: '', 		// html before
					'op_after'	: '', 		// html after
					'container_special_class' : '' // Container Class

		        }, options );
		var name = settings.group_id + '_ctfsep_' + settings.option_id;

		/** Detect ID **/
		if( jQuery('body').find('input[name="'+name+'"]').length > 0 )
			return '<h1>DEBUG : ID Exists </h1>';

		/** HTML Generate **/
		settings.op_title = ( settings.op_title != '' ) ? '<span class="ctf_option_title">' + settings.op_title + '</span>' : '';
		settings.op_desc = ( settings.op_desc != '' ) ? '<span class="ctf_option_desc">' + settings.op_desc + '</span>' : '';

		html_wrap = '<div class="ctf_option_container ' + settings.container_special_class + '">' + settings.op_title + settings.op_before + '<input type="text" class="ctf_option ctf_option_text_input ' + settings.op_class + '" name="' + name + '" value="' + settings.op_value + '" />' + settings.op_after + settings.op_desc + '</div>';

		/** Return HTML **/
		return html_wrap;
	}

	,
	/** Input Hidden **/
	add_hidden : function( options )
	{
		var html_wrap = "";
		var settings = jQuery.extend({
		            // These are the defaults.
					'group_id'	: 0, 		// Group to save this option on
					'option_id'	: '', 		// Option ID
					'op_value'	: '', 		// option value
					'container_special_class' : '' // Container Class
		        }, options );
		var name = settings.group_id + '_ctfsep_' + settings.option_id;

		/** Detect ID **/
		if( jQuery('body').find('input[name="'+name+'"]').length > 0 )
			return '<h1>DEBUG : ID Exists </h1>';

		html_wrap = '<div class="ctf_option_container ' + settings.container_special_class + '">' + '<input type="hidden" class="ctf_option ctf_option_text_input" name="' + name + '" value="' + settings.op_value + '" />' + '</div>';

		/** Return HTML **/
		return html_wrap;
	}

	,
	/** TextArea **/
	add_textarea : function( options )
	{
		var html_wrap = "";
		var settings = jQuery.extend({
		            // These are the defaults.
					'group_id'	: 0, 		// Group to save this option on
					'option_id'	: '', 		// Option ID
					'op_title'	: '', 		// Title
					'op_desc'	: '', 		// Description or Help
					'op_value'	: '', 		// option value
					'op_class'	: '', 		// css class
					'op_before'	: '', 		// html before
					'op_after'	: '', 		// html after
					'container_special_class' : '' // Container Class

		        }, options );
		var name = settings.group_id + '_ctfsep_' + settings.option_id;

		/** Detect ID **/
		if( jQuery('body').find('textarea[name="'+name+'"]').length > 0 )
			return '<h1>DEBUG : ID Exists </h1>';

		/** HTML Generate **/
		settings.op_title = ( settings.op_title != '' ) ? '<span class="ctf_option_title">' + settings.op_title + '</span>' : '';
		settings.op_desc = ( settings.op_desc != '' ) ? '<span class="ctf_option_desc">' + settings.op_desc + '</span>' : '';

		html_wrap = '<div class="ctf_option_container ' + settings.container_special_class + '">' + settings.op_title + settings.op_before + '<textarea class="ctf_option ctf_option_textarea ' + settings.op_class + '" name="' + name + '" >' + settings.op_value + '</textarea>' + settings.op_after + settings.op_desc + '</div>';

		/** Return HTML **/
		return html_wrap;
	}

	,
	/** Check Box **/
	add_checkbox : function( options )
	{
		var html_wrap = "";
		var settings = jQuery.extend({
		            // These are the defaults.
					'group_id'	: 0, 		// Group to save this option on
					'option_id'	: '', 		// Option ID
					'op_title'	: '', 		// Title
					'op_desc'	: '', 		// Description or Help
					'op_value'	: 'off', 		// option value
					'op_class'	: '', 		// css class
					'op_before'	: '', 		// html before
					'op_after'	: '', 		// html after
					'op_label_class' : '', // Label Class
					'container_special_class' : '' // Container Class

		        }, options );
		var name = settings.group_id + '_ctfsep_' + settings.option_id;

		/** Detect ID **/
		if( jQuery('body').find('input[name="'+name+'"]').length > 0 )
			return '<h1>DEBUG : ID Exists </h1>';

		/** HTML Generate **/
		settings.op_title = ( settings.op_title != '' ) ? '<span class="ctf_option_title">' + settings.op_title + '</span>' : '';
		settings.op_desc = ( settings.op_desc != '' ) ? '<span class="ctf_option_desc">' + settings.op_desc + '</span>' : '';
		var off = (settings.op_value == 'off') ? 'codetemp_checkbox_off' : '';

		html_wrap = '<div class="ctf_option_container ' + settings.container_special_class + '">' + settings.op_title + settings.op_before + '<label for="' + name +'" class="ctf_option_checkbox_label ' + off + ' ' + settings.op_label_class + '" ></label><input type="checkbox" class="ctf_option ctf_option_checkbox ' + settings.op_class + '" name="' + name + '" id="' + name + '" value="' + settings.op_value + '" checked />' + settings.op_after + settings.op_desc + '</div>';

		/** Return HTML **/
		return html_wrap;
	}

	,
	/** Select **/
	add_select : function( options )
	{
		var html_wrap = "";
		var settings = jQuery.extend({
		            // These are the defaults.
					'group_id'	: 0, 		// Group to save this option on
					'option_id'	: '', 		// Option ID
					'op_title'	: '', 		// Title
					'op_desc'	: '', 		// Description or Help
					'op_value'	: '', 		// option value
					'op_class'	: '', 		// css class
					'op_before'	: '', 		// html before
					'op_after'	: '', 		// html after
					'select_options' : '',   // Select Options
					'container_special_class' : '' // Container Class

		        }, options );
		var name = settings.group_id + '_ctfsep_' + settings.option_id;

		/** Detect ID **/
		if( jQuery('body').find('input[name="'+name+'"]').length > 0 )
			return '<h1>DEBUG : ID Exists </h1>';

		/** HTML Generate **/
		settings.op_title = ( settings.op_title != '' ) ? '<span class="ctf_option_title">' + settings.op_title + '</span>' : '';
		settings.op_desc = ( settings.op_desc != '' ) ? '<span class="ctf_option_desc">' + settings.op_desc + '</span>' : '';

		var select_content = "";
		for ( var object_key in settings.select_options )
		{
			var object_val = settings.select_options[object_key];
			var isSelected = ( settings.op_value == object_val ) ? ' selected="selected" ' : '';
			select_content = select_content + '<option value="' + settings.op_value + '" ' + isSelected + ' >' + object_key + '</option>';
		}

		html_wrap = '<div class="ctf_option_container ' + settings.container_special_class + '">' + settings.op_title + settings.op_before + '<select class="ctf_option ctf_option_select ' + settings.op_class + '" name="' + name + '" >' + select_content + '</select>' + settings.op_after + settings.op_desc + '</div>';

		/** Return HTML **/
		return html_wrap;
	}

	,
	/** Radio **/
	add_radio : function( options )
	{
		var html_wrap = "";
		var settings = jQuery.extend({
		            // These are the defaults.
					'group_id'	: 0, 		// Group to save this option on
					'option_id'	: '', 		// Option ID
					'op_title'	: '', 		// Title
					'op_desc'	: '', 		// Description or Help
					'op_value'	: '', 		// option value
					'op_class'	: '', 		// css class
					'op_before'	: '', 		// html before
					'op_after'	: '', 		// html after
					'select_options' : '',   // Select Options
					'container_special_class' : '' // Container Class

		        }, options );
		var name = settings.group_id + '_ctfsep_' + settings.option_id;

		/** Detect ID **/
		if( jQuery('body').find('input[name="'+name+'"]').length > 0 )
			return '<h1>DEBUG : ID Exists </h1>';

		/** HTML Generate **/
		settings.op_title = ( settings.op_title != '' ) ? '<span class="ctf_option_title">' + settings.op_title + '</span>' : '';
		settings.op_desc = ( settings.op_desc != '' ) ? '<span class="ctf_option_desc">' + settings.op_desc + '</span>' : '';

		html_wrap = '<div class="ctf_option_container ' + settings.container_special_class + '">' + settings.op_title + settings.op_before;

		var select_content = "";
		for ( var object_key in settings.select_options )
		{
			var object_val = settings.select_options[object_key];
			var isSelected = ( settings.op_value == object_val ) ? ' checked="checked" ' : '';
			select_content = select_content + '<input type="radio" class="ctf_option ctf_option_radio ' + settings.op_class + '" name="' + name + '" ' + isSelected + ' value="' + object_val + '" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + object_key + '<br/>';
		}

		html_wrap = html_wrap + select_content +  settings.op_after + settings.op_desc + '</div>';

		/** Return HTML **/
		return html_wrap;
	}

	,
	/** Colorpicker **/
	add_colorpicker : function( options )
	{
		var html_wrap = "";
		var settings = jQuery.extend({
		            // These are the defaults.
					'group_id'	: 0, 		// Group to save this option on
					'option_id'	: '', 		// Option ID
					'op_title'	: '', 		// Title
					'op_desc'	: '', 		// Description or Help
					'op_value'	: '', 		// option value
					'op_class'	: '', 		// css class
					'op_before'	: '', 		// html before
					'op_after'	: '', 		// html after
					'container_special_class' : '' // Container Class

		        }, options );
		var name = settings.group_id + '_ctfsep_' + settings.option_id;

		/** Detect ID **/
		if( jQuery('body').find('input[name="'+name+'"]').length > 0 )
			return '<h1>DEBUG : ID Exists </h1>';

		/** HTML Generate **/
		settings.op_title = ( settings.op_title != '' ) ? '<span class="ctf_option_title">' + settings.op_title + '</span>' : '';
		settings.op_desc = ( settings.op_desc != '' ) ? '<span class="ctf_option_desc">' + settings.op_desc + '</span>' : '';

		html_wrap = '<div class="ctf_option_container ' + settings.container_special_class + '">' + settings.op_title + settings.op_before + '<input type="text" class="ctf_option ctf_option_colorpicker ' + settings.op_class + '" name="' + name + '" value="' + settings.op_value + '" /><span class="ctf_option_colorpicker_color" style="background-color:' + settings.op_value + ';"></span><div class="clearfix"></div>' + settings.op_after + settings.op_desc + '</div>';

		/** Return HTML **/
		return html_wrap;
	}

	,
	/** Upload **/
	add_upload : function( options )
	{
		var html_wrap = "";
		var settings = jQuery.extend({
		            // These are the defaults.
					'group_id'	: 0, 		// Group to save this option on
					'option_id'	: '', 		// Option ID
					'op_title'	: '', 		// Title
					'op_desc'	: '', 		// Description or Help
					'op_value'	: '', 		// option value
					'op_class'	: '', 		// css class
					'op_before'	: '', 		// html before
					'op_after'	: '', 		// html after
					'container_special_class' : '' // Container Class

		        }, options );
		var name = settings.group_id + '_ctfsep_' + settings.option_id;

		/** Detect ID **/
		if( jQuery('body').find('input[name="'+name+'"]').length > 0 )
			return '<h1>DEBUG : ID Exists </h1>';

		/** HTML Generate **/
		settings.op_title = ( settings.op_title != '' ) ? '<span class="ctf_option_title">' + settings.op_title + '</span>' : '';
		settings.op_desc = ( settings.op_desc != '' ) ? '<span class="ctf_option_desc">' + settings.op_desc + '</span>' : '';

		html_wrap = '<div class="ctf_option_container ' + settings.container_special_class + '">' + settings.op_title + settings.op_before + '<input type="text" class="ctf_option ctf_option_upload fl ' + settings.op_class + '" name="' + name + '" value="' + settings.op_value + '" /><button class="ctf_option_upload_button"> Upload </button>' + settings.op_after + settings.op_desc + '</div>';

		/** Return HTML **/
		return html_wrap;
	}

	,
	/** Messages **/
	add_box : function( options)
	{
		var html_wrap = "";
		var settings = jQuery.extend({
		            // These are the defaults.
					'group_id'	: 0, 		// Group to save this option on
					'option_id'	: '', 		// Option ID
					'op_title'	: '', 		// Title
					'op_desc'	: '', 		// Description or Help
					'op_value'	: '', 		// option value
					'op_class'	: '', 		// css class
					'op_before'	: '', 		// html before
					'op_after'	: '', 		// html after
					'op_display' 	: 'show', 	// Display or not
					'op_type'	: 'normal', // Type of box
					'op_image'	: '',		// Box Image
					'op_width'	: '', 		// Box Width
					'container_special_class' : '' // Container Class


		        }, options );
		var name = settings.group_id + '_ctfsep_' + settings.option_id;

		/** HTML Generate **/
		settings.op_image 	= settings.op_image == '' ? '' : '<img class="ctf_box_img" src="' + settings.op_image + '" alt="" />';
		settings.op_title 	= settings.op_title == '' ? '' : '<span class="ctf_box_title">' + settings.op_value + '</span>';
		settings.op_desc 	= settings.op_desc == '' ? '' : '<span class="ctf_box_desc">' + settings.op_desc + '</span>';
		settings.op_width 	= settings.op_width == '' ? '' : ' width:' + settings.op_width + '; ';
		settings.op_display = settings.op_display == 'show' ? 'display:block;' : ' display:none; ';

		html_wrap = settings.op_before + '<div class="ctf_box ctf_box_type_' + settings.op_type + ' ' + settings.container_special_class + '" style=" ' + settings.op_width + settings.op_display + ' " >';
		html_wrap = html_wrap + settings.op_image + ' <div class="ctf_box_content">' + settings.op_title + settings.op_desc + '</div><a href="#" class="ctf_box_close">x</a><div class="clearfix"></div></div>' + settings.op_after;

		/** Return HTML **/
		return html_wrap;
	}

};