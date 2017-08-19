<?php
	
	namespace Travelience\Helpers\Youtube;

	class Youtube
	{

    /**
     * Validate if the youtube link is valid and public
     *
     * @param String $url
     * @return Boolean
     */
    public static function validate( $url )
		{
		
			$code = self::code( $url );
			
			if(!$code)
			{
				return false;
			}
			
			$video = 'http://www.youtube.com/watch?v='.$code;
			$url = 'http://www.youtube.com/oembed?url='. $video .'&format=json';
			
			$content = @file_get_contents($url);
			
			if( str_contains($content, "title") )
			{
				return true;
			}
			
			return false;
		}

    /**
     * Get the standar url format
     *
     * @param String $url
     * @return String
     */
		public static function url($url)
		{
			if( !$url ) return $url;

			return 'http://www.youtube.com/watch?v=' . self::code( $url );
		}

    /**
     * Get the mp3 file of the youtube video, using youtubeinmp3.com api.
     *
     * @param String $url
     * @return String
     */
		public static function mp3( $url )
		{
      $code = self::code( $url );
			return 'http://www.youtubeinmp3.com/fetch/?video=https://www.youtube.com/watch?v=' . $code;
		}

    /**
     * Get data from youtube video
     *
     * @param String $url
     * @return String
     */
		public static function data( $url )
		{

      $url = 'https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=' . self::code( $url );

			if( !$json = @file_get_contents($url) )
			{
				return false;
			}

			return json_decode($json);

		}
		
    /**
     * Get the youtube id from url
     *
     * @param String $url
     * @return String
     */
		public static function code( $url )
		{

      if( strlen($url) < 10 )
      {
        return $url;
      }
		
			if( strpos($url,'watch?v=') !== false )
			{
				$url = explode('watch?v=', $url);
				$url = $url[1];
				
				if( strpos($url, '&') !== false )
				{
					$url = explode('&', $url);
					$url = $url[0];
					return $url;
				}
				
				return $url;
				
			}
		
			if( strpos($url, 'youtu.be/') !== false )
			{
				$url = explode('youtu.be/', $url);
				$url = $url[1];
				
				return $url;
			}
			
			return false;
			
		}
		
    /**
     * Get the embed html from youtube
     *
     * @param String $url
     * @return String
     */
		public static function embed( $url, $width='100%', $height='300', $params=[] )
		{
			
			if( !self::validate( $url ) )
			{
				return false;
			}

      $defaults = [
                    'autoplay' => false,
                    'rel' => 0
                  ];

      $params = array_merge($defaults, $params);

			$src = '//www.youtube.com/embed/' . self::code($url) .'?' . http_build_query($params);
			
			return '<iframe width="'. $width .'" height="'. $height .'" src="'. $src .'" frameborder="0" allowfullscreen></iframe>';
			
		}

		
	}

?>