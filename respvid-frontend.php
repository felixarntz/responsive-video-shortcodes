<?php
/**
 * Class: Respvid_Frontend
 *
 * This class includes all methods required to use the responsive [video] shortcode in the WordPress frontend.
 * 
 * @package ResponsiveVideoShortcodes
 * @version 1.2.5
 * @author Felix Arntz <felix-arntz@leaves-and-love.net>
 */
class Respvid_Frontend
{
  private static $instance = null;

  public static function instance()
  {
    if( self::$instance === null )
    {
      self::$instance = new self;
    }
    return self::$instance;
  }

	private function __construct()
	{
		if( !shortcode_exists( 'video' ) )
		{
			add_shortcode( 'video', array( $this, 'video_shortcode' ) );
		}
		else
		{
			add_filter( 'wp_video_shortcode_override', array( $this, 'shortcode_compatibility_mode' ), 10, 4 );
		}
		
		add_filter( 'embed_defaults', array( $this, 'modify_wp_embed_defaults' ), 10, 1 );
		add_filter( 'oembed_fetch_url', array( $this, 'handle_additional_embed_args' ), 10, 3 );
		
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	
	/**
	 * Handles the 'video' shortcode.
	 * 
	 * Default values for the attributes are:
	 * <ul>
	 * <li>align: 'center'</li>
	 * <li>aspect_ratio: '16:9'</li>
	 * <li>width: '100'</li>
	 * <li>autoplay: '0'</li>
	 * </ul>
	 * 
	 * Watch out: Using autoplay with oEmbed is currently only supported by Vimeo and Soundcloud.
	 * However, there won't be any errors with the others, it just won't autoplay.
	 * 
	 * @param array $atts attributes passed by the shortcode
	 * @param string $content the content in between the shortcode tags
	 * @return string the output created by the shortcode
	 * @see before_video(), embed_video(), after_video()
	 * @since 1.0.0
	 */
	public function video_shortcode( $atts , $content = '' )
	{
		// Attributes
		extract( shortcode_atts(
			array(
				'align' => 'center',
				'aspect_ratio' => '16:9',
				'width' => '100',
				'autoplay' => 0,
			), $atts )
		);
		
		extract( $this->validate_attributes( $align, $aspect_ratio, $width, $autoplay ) );
		
		$aspect_ratio = str_replace( ':', '-', $aspect_ratio );
		
		return $this->get_embed_video( $content, $align, $aspect_ratio, $width, $autoplay );
	}
	
	/**
	 * Enables compatibility mode for the plugin.
	 * 
	 * Since WordPress 3.6 a shortcode named [video] is included in the Core. This shortcode handles HTML5 video.
	 * The difference between the WordPress [video] shortcode and this plugin's [video] shortcode is that the WordPress shortcode is self-closing, i.e. it does not take $content.
	 * 
	 * If the $content variable is empty, the shortcode is estimated to be WordPress Core.
	 * If it is not empty, it is assumed to be this plugin's shortcode.
	 * 
	 * This function is added as a filter to 'wp_video_shortcode_override'.
	 * 
	 * @param string $empty_string an empty variable to be replaced with shortcode markup (if necessary)
	 * @param array $attr attributes of the shortcode
	 * @param string $content shortcode content
	 * @param int $instances unique numeric ID of this video shortcode instance (not required here)
	 * @return string if $content is not empty, this plugin's video shortcode output, otherwise an empty string to continue executing the Core video shortcode
	 * @since 1.2.0
	 */
	public function shortcode_compatibility_mode( $empty_string, $atts, $content = '', $instance = 0 )
	{
		if( !empty( $content ) )
		{
			return $this->video_shortcode( $atts, $content );
		}
		return '';
	}
	
	/**
	 * Modifies the original WordPress embed defaults to allow an autoplay argument.
	 * 
	 * If autoplay is set to 1, the media will automatically start playing (if it is possible).
	 * Sadly, only two hosting providers support autoplays using oEmbed as of now (Vimeo and Soundcloud).
	 * Therefore the autoplay argument won't have any meaning for all the other platforms.
	 * 
	 * This function is called by the WordPress Core filter 'embed_defaults'.
	 * 
	 * @param array $defaults the embed defaults array
	 * @return array the modified embed defaults array containing an 'autoplay' key
	 * @see handle_additional_embed_args()
	 * @since 1.1.5
	 */
	public function modify_wp_embed_defaults( $defaults = array() )
	{
		$defaults['autoplay'] = 0;
		
		return $defaults;
	}
	
	/**
	 * Handles additional embed args that are not part of WordPress Core.
	 * 
	 * Currently, there is only one such argument, the 'autoplay' argument.
	 * It will only be used if it is set to 1, otherwise it would not do any change anyways.
	 * Sadly, only Vimeo and Soundcloud currently support autoplays using oEmbed.
	 * 
	 * Therefore, if the 'autoplay' argument is set to 1, it will only be passed if the oEmbed media is either from Vimeo or Soundcloud.
	 * 
	 * This function is called by the WordPress Core filter 'oembed_fetch_url'.
	 * 
	 * @param string $provider the oEmbed URL for the media
	 * @param string $url the original URL of the media
	 * @param array $args additional arguments (contain 'width', 'height' and 'autoplay' keys)
	 * @return string the provider string with a query argument for autoplay (if necessary)
	 * @link https://developer.vimeo.com/apis/oembed, http://developers.soundcloud.com/docs/oembed
	 * @since 1.1.5
	 */
	public function handle_additional_embed_args( $provider, $url, $args = array() )
	{
		if( $args['autoplay'] == 1 )
		{
			$values = array(
				'http://vimeo.com/api/oembed'		=> array( 'autoplay', 1 ),
				'http://soundcloud.com/oembed'		=> array( 'auto_play', true)
			);
			foreach( $values as $oembed_url => $params )
			{
				if( strpos( $provider, $oembed_url ) !== false )
				{
					$provider = add_query_arg( $params[0], $params[1], $provider );
					break;
				}
			}
		}
		
		return $provider;
	}
	
	/**
	 * Registers and enqueues the necessary CSS stylesheet.
	 * 
	 * @since 1.0.0
	 */
	public function enqueue_scripts()
	{
		wp_register_style( 'resp-video-style', RESPVID_URL . 'assets/respvid.css' );
		wp_enqueue_style( 'resp-video-style' );
	}
	
	/**
	 * Returns the embedded video.
	 * 
	 * This method is utilized by both shortcode and widget.
	 * 
	 * @param string $url the URL of the video
	 * @param string $align the alignment of the video
	 * @param string $aspect the aspect ratio of the video
	 * @param int $width the width of the video in percent
	 * @param int $autoplay either 0 for autoplay off or 1 for autoplay on
	 * @return string the whole HTML code with the embed and the containing divs
	 * @since 1.2.0
	 */
	public function get_embed_video( $url, $align, $aspect, $width = null, $autoplay = 0 )
	{
		$code = $this->before_video( $align, $aspect, $width );
		$code .= $this->embed_video( $url, $autoplay );
		$code .= $this->after_video();
		return $code;
	}
	
	/**
	 * Returns content to be printed before the video.
	 * 
	 * @param string $align the alignment of the video
	 * @param string $aspect the aspect ratio of the video
	 * @param int $width the width of the video in percent
	 * @return string HTML code containing two divs with the necessary CSS classes attached
	 * @since 1.0.0
	 */
	private function before_video( $align, $aspect, $width = null )
	{
		$code = '<div class="resp-video-' . $align . '"';
		if( isset ( $width ) )
		{
			$code .= ' style="width: ' . $width . '%;"';
		}
		$code .= '>';
		$code .= '<div class="resp-video-wrapper size-' . $aspect . '">';
		return $code;
	}
	
	/**
	 * Returns the output for the actual oEmbed media element.
	 * 
	 * Width or height parameters in the oEmbed code are removed so that the element can size dynamically.
	 * 
	 * @param string $url the URL of the video
	 * @param int $autoplay either 0 for autoplay off or 1 for autoplay on
	 * @return string HTML code containing the oEmbed
	 * @since 1.0.0
	 */
	private function embed_video( $url, $autoplay = 0 )
	{
		$regex = "/ (width|height)=\"[0-9\%]*\"/";
		$embed_code = wp_oembed_get( $url, array( 'width' => '100%', 'height' => '100%', 'autoplay' => $autoplay ) );
		if( !$embed_code )
		{
			return '<strong>' . __( 'Error: Invalid URL!', 'responsive-video-shortcodes' ) . '</strong>';
		}
		return preg_replace( $regex, '', $embed_code );
	}
	
	/**
	 * Returns content to be printed after the video.
	 * 
	 * @return string HTML code containing two closing divs
	 * @since 1.0.0
	 */
	private function after_video()
	{
		$code = '</div>';
		$code .= '</div>';
		return $code;
	}
	
	/**
	 * Validates the attributes for the shortcodes.
	 * 
	 * @param String $align the alignment of the video. Possible values are "left", "right" and "center" (default)
	 * @param String $aspect_ratio the aspect ratio of the video. Possible values are "4:3", "21:9" and "16:9" (default)
	 * @param int $width the width of the video in %. Must be greater than 0 and lower than 101. Default value is 100.
	 * @return array contains the validated attributes
	 * @since 1.0.0
	 */
	private function validate_attributes( $align, $aspect_ratio, $width, $autoplay )
	{
		$atts = null;
		if( $align != 'left' && $align != 'center' && $align != 'right' )
		{
			$atts['align'] = 'center';
		}
		else
		{
			$atts['align'] = $align;
		}
		
		$allowed_ratios = respvid_get_allowed_aspect_ratios();
		
		if( !in_array( $aspect_ratio, $allowed_ratios ) )
		{
			$atts['aspect-ratio'] = '16:9';
		}
		else
		{
			$atts['aspect-ratio'] = $aspect_ratio;
		}
		$atts['aspect-ratio'] = str_replace( ':', '-', $atts['aspect-ratio'] );
		$width = intval( $width );
		if( $width < 1 || $width > 100 )
		{
			$atts['width'] = 100;
		}
		else
		{
			$atts['width'] = $width;
		}
		$autoplay = intval( $autoplay );
		if( $autoplay > 0 )
		{
			$atts['autoplay'] = 1;
		}
		else
		{
			$atts['autoplay'] = 0;
		}
		return $atts;
	}
}

// Class instantiation
Respvid_Frontend::instance();
