<?php


if( !class_exists('ctf_resize_thumbnails') ) 
{
	/**
	* 
	*/
	class ctf_resize_thumbnails
	{
		public $width;
		public $height;

		function __construct( $width=300, $height=200 )
		{
			$this->width 	=(int)$width;
			$this->height 	=(int)$height;
		}
	

		/**
		 * WordPress Actions
		 *
		 */
		function wp_actions()
		{
			add_filter( 'wp_generate_attachment_metadata', array( $this , 'wp_attachment_meta' ) , 10, 2 );
			add_filter( 'delete_attachment',  array( $this , 'clean_images') );
		
		}



		/**
		 * Attachment Metadata
		 *
		 * This function is attached to the 'wp_generate_attachment_metadata' filter hook.
		 * http://code.tutsplus.com/tutorials/ensuring-your-theme-has-retina-support--wp-33430
		 *
		 */
		function wp_attachment_meta( $metadata, $attachment_id ) 
		{
		    $this->create_images( get_attached_file( $attachment_id ) );
		    return $metadata;
		}


		/**
		 * Crop Images & Retina
		 *
		 * This function is attached to the 'wp_generate_attachment_metadata' filter hook.
		 *
		 */
		function create_images( $file ) {

		    if ( $this->width || $this->height ) 
		    {
		        $resized_file = wp_get_image_editor( $file );

		        if ( ! is_wp_error( $resized_file ) ) 
		        {
		        	/** Create Image With Custom width / height  **/
		            $filename = $resized_file->generate_filename( $this->width . 'x' . $this->height );
		            $resized_file->resize( $this->width, $this->height, true );
		            $resized_file->save( $filename );
		            $info = $resized_file->get_size();

		        	/** Create Retina **/
		        	$resized_file = wp_get_image_editor( $file );
		            $filename = $resized_file->generate_filename( $this->width . 'x' . $this->height . '@2x' );
		            $resized_file->resize( $this->width * 2, $this->height * 2, true );
		            $resized_file->save( $filename );
		            // $info = $resized_file->get_size(); // $info for retina is not needed
		 
		            return array(
		                'file' => wp_basename( $filename ),
		                'width' => $info['width'],
		                'height' => $info['height'],
		            );
		        }
		    }
		    return false;
		}


		/**
		 * Delete custom / retina images
		 *
		 * This function is attached to the 'delete_attachment' filter hook.
		 * 
		 */
		function clean_images( $attachment_id ) 
		{
		    $meta = wp_get_attachment_metadata( $attachment_id );
		    
		    $upload_dir = wp_upload_dir();
			
		    $path 		= @pathinfo( $meta['file'] );
			if ( !in_array("dirname", $path))
				return;
			
			$custom_image = @$upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $path['filename'] . '-' . $this->width . 'x' . $this->height . '.' . $path['extension'] ;
			$retina_image = @$upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $path['filename'] . '-' . $this->width . 'x' . $this->height . '@2x.' . $path['extension'] ;

		    if ( file_exists( $custom_image ) )
		    {	
		    	@unlink( $custom_image ); 
		    }
		    if ( file_exists( $retina_image ) )
		    {	
		    	@unlink( $retina_image ); 
		    }

		}
		
		
	}// End Class

}// End If