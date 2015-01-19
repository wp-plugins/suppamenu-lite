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

jQuery(document).ready(function(){

	jQuery(document).on('click','.ctf-btn-load-skin',function(event){
		event.preventDefault();

		jQuery('.codetemp_main_nav li').show();

		var $form 			= jQuery(this).parents('#codetemp_form');
		var $uploads_url 	= $form.find('#codetemp_uploads_url').val();
		var $plugin_url 	= $form.find('#codetemp_plugin_url').val();
		var $theSelect 	= jQuery(this).parent().find('#skin_modify');

		// Set Loading Image
		var $html_ajax_img_load = $plugin_url + 'core/img/ajax-loader.gif';
		var $html_ajax_img_save = $plugin_url + 'core/img/success_icon.png';
		var $html_ajax_res = jQuery('.codetemp_ajax_response');

		$html_ajax_res.children('img').attr( 'src' , $html_ajax_img_load );
		$html_ajax_res.children('span').text('');
		$html_ajax_res.show();

		// AJAX
		jQuery.post( ajaxurl, {
				action 	: 'suppa_load_skin_options',
				skin_name : $theSelect.val(),
			},
			function( data ){
				jQuery.each( data, function( key, val ) {

					$op = jQuery('*[name="'+key+'"]');

					if( $op.is('.ctf_option_colorpicker') ){
						$op.val( val );
						$op.next('.ctf_option_colorpicker_color').css({'background-color':val})	;
					}
					else if( $op.is('.ctf_option_font_family') ){
						$op.find('option:selected').removeAttr('selected');
						$op.find('option[value="'+val+'"]').attr('selected','selected');
					}
					else
					{
						$op.val( val );
					}

				});

				$html_ajax_res.children('img').attr( 'src' , $html_ajax_img_save );
				$html_ajax_res.children('span').html('<div>All skin options are loaded to the admin area option</div><br/><br/><div>please save settings</div>');
				$html_ajax_res.delay(4000).hide(200);
			}
		);

	});

	jQuery('.ctf_option_colorpicker').change(function(){
		jQuery(this).next('.ctf_option_colorpicker_color').css({'background-color': jQuery(this).val() });
	});
});