/**
 * Admin Script
 *
 * @package 	CTFramework
 * @author		Sabri Taieb ( codezag )
 * @copyright	Copyright (c) Sabri Taieb
 * @link		http://codetemp.com
 * @since		Version 1.0
 *
 */

jQuery(document).ready(function(){

	jQuery(document).on('change','#skin_modify',function(event){
		event.preventDefault();

			var $form 			= jQuery(this).parents('#codetemp_form');
			var $uploads_url 	= $form.find('#codetemp_uploads_url').val();
			var $plugin_url 	= $form.find('#codetemp_plugin_url').val();

			// Set Loading Image
			var $html_ajax_img_load = $plugin_url + 'core/img/ajax-loader.gif';
			var $html_ajax_img_save = $plugin_url + 'core/img/success_icon.png';
			var $html_ajax_res = jQuery('.codetemp_ajax_response');

			$html_ajax_res.children('img').attr( 'src' , $html_ajax_img_load );
			$html_ajax_res.children('span').text('');
			$html_ajax_res.show();


		var skin_url = $uploads_url + "/suppamenu2/skins/" + jQuery(this).val() + ".json";

		jQuery.getJSON( skin_url, function( data ) {
			jQuery.each( data, function( key, val ) {
				$op = jQuery('.codetemp_pages_container').find('*[name="'+key+'"]');
				$op.val( val );

				if( $op.is('.ctf_option_colorpicker') )
					$op.next('.ctf_option_colorpicker_color').css({'background-color':val})	;
			});

			$html_ajax_res.children('img').attr( 'src' , $html_ajax_img_save );
			$html_ajax_res.children('span').html('<div>All skin options are loaded to the admin area option</div><br/><br/><div>please save settings</div>');
			$html_ajax_res.delay(4000).hide(200)
		});
	});

	jQuery('.ctf_option_colorpicker').change(function(){
		jQuery(this).next('.ctf_option_colorpicker_color').css({'background-color': jQuery(this).val() });
	});
});