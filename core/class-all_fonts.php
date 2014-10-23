<?php

if( !class_exists('ctf_fonts') )
{
	/**
	 *
	 * Contain normal/google fonts
	 *
	 */
	class ctf_fonts {

		public static $standard = array(
								'Arial' => "'Arial' , sans-serif",
								'Arial Black' => "'Arial Black' , sans-serif",
								'Verdana' => "'Verdana' , sans-serif",
								'Impact' => "'Impact' , sans-serif",
								'Helvetica' => "'Helvetica' , sans-serif",
								'Georgia' => "'Georgia' , sans-serif",
								'Tahoma' => "'Tahoma' , sans-serif",
								'Courier New' => "'Courier New' , sans-serif"
							);

		/**
		 *
		 * Return the fonts
		 *
		 */
		static function font_list()
		{
        	$gwf = get_option('era_googleFonts');
        	$merged = array_merge( self::$standard, $gwf );
        	return $merged;
		}


		/**
		 *
		 * Return  only google fonts
		 *
		 */
		static function only_google_font_list()
		{
        	$gwf = get_option('era_googleFonts');
        	return $gwf;
		}


		/**
		 *
		 * Return  only standard fonts
		 *
		 */
		static function only_standard_font_list()
		{
        	return $this->standard;
		}


		/**
		 *
		 * Download googel fonts list
		 *
		 */
		static function get_googleFonts_list()
		{

		    $key = "AIzaSyBj2NGLBDMdyzLvqQc4RHi3g0cHnFfU6GI";
		    $sort= "alpha";
		    /*
		    alpha: Sort the list alphabetically
		    date: Sort the list by date added (most recent font added or updated first)
		    popularity: Sort the list by popularity (most popular family first)
		    style: Sort the list by number of styles available (family with most styles first)
		    trending: Sort the list by families seeing growth in usage (family seeing the most growth first)
		    */

		    $http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";

		    $google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $key . '&sort=' . $sort;
		    //lets fetch it
		    $response = wp_remote_retrieve_body( wp_remote_get($google_api_url, array('sslverify' => false )));
		    if( !is_wp_error( $response ) )
		    {
		        $data = json_decode($response, true);
		        $items = $data['items'];
		        foreach ($items as $item)
		        {
		            $font_list[$item['family']] .= "'" .$item['family'] . "' , " . $item['category'];
		        }

		        //save list to db
		        if( !get_option('era_googleFonts') )
		        	add_option( 'era_googleFonts' , $font_list );
		    }
		}


		/**
		 *
		 *	Save Font Used To DB
		 *
		 *	@param $font array()
		 *
		 */
		static function add_font_used( $font )
		{
			$split	=  explode( ',' , $font );
			$font	= $split[0];
			$font	= str_replace( "'" , "" , $font );
			$font	= str_replace( " " , "" , $font );

			if( get_option( 'suppa_googleFonts_used' )  )
			{
				$all_fonts = get_option( 'suppa_googleFonts_used' );
				$font_exists = false;
				if( !in_array($font, $all_fonts) && !array_key_exists($font, ctf_fonts::$standard ) )
				{
					$all_fonts[] = $font;
					update_option( 'suppa_googleFonts_used' , $all_fonts );
				}
			}
			else
			{
				update_option( 'suppa_googleFonts_used' , array($font) );
			}
		}


		/**
		 *
		 * Enqueue Google Fonts to the Front-End
		 *
		 */
		static function load_frontend_google_fonts()
		{
			if( get_option( 'suppa_googleFonts_used' )  )
			{
				$used_fonts 	= get_option( 'suppa_googleFonts_used' );
				$font_string 	= "";
				foreach ( $used_fonts as $font )
				{
					if( !array_key_exists($font, self::$standard ) )
					{
						$font_string .= '|' . $font;
					}
				}
				$font_string = substr($font_string, 1);
				$font_string = str_replace(' ' , '+', $font_string );
				$font_var = '300,400,600,700,900,300italic,400italic,600italic,700italic,900italic';

				if( $font_string != "" )
				{
					$http = (!empty($_SERVER['HTTPS'])) ? "https" : "http";
					wp_enqueue_style( 'suppa_googleFonts_used' , $http . "://fonts.googleapis.com/css?family=" . $font_string . ":" . $font_var );
				}
			}
		}

	} // end class

} // end if