<?php
/**
 * @package Responsive Video Shortcodes
 * @version 1.16
 */
/*
Plugin Name: Responsive Video Shortcodes
Plugin URI: http://wordpress.org/extend/plugins/responsive-video-shortcodes/
Description: This tiny Plugin allows you to embed Online Video from YouTube, Vimeo and more for a responsive Layout - they scale according to the screen size. It features shortcode and widget.
Author: Felix Arntz
Version: 1.16
Author URI: http://www.leaves-and-love.net/
*/

define( 'RESPVID_VERSION', '1.16' );

require( plugin_dir_path( __FILE__ ) . 'respvid-widget.php' );

/**
 * Loads the plugin translations.
 * 
 * @since 1.15
 */
function resp_load_translations()
{
	load_plugin_textdomain( 'respvid', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'resp_load_translations' );

/**
 * Registers and enqueues the necessary CSS stylesheet.
 * 
 * @since 1.0
 */
function resp_scripts_init()
{
	wp_register_style( 'resp-video-style', plugin_dir_url( __FILE__ ) . 'respvid.css' );
    wp_enqueue_style( 'resp-video-style' );
}  
add_action('wp_enqueue_scripts', 'resp_scripts_init');

/**
 * Registers the included Responsive Video Widget.
 * 
 * @since 1.0
 */
function resp_widgets_init()
{
	register_widget( 'respvid_widget' );
}
add_action( 'widgets_init', 'resp_widgets_init' );

/**
 * Renders the content of the options page.
 * 
 * Since the plugin only consists of an easy-to-use shortcode and a widget, there are no settings to display.
 * Instead, the options page shows a short guide on how to use these things.
 * 
 * @since 1.0
 */
function resp_options_page()
{
	echo '<div class="wrap">' . "\n";
	echo '<h2><a href="http://www.leaves-and-love.net/responsive-video-shortcodes/" target="_blank">Responsive Video Shortcodes</a> - ' . __('Settings') . '</h2>' . "\n";
	echo '<p><strong>' . __('You\'re lucky!', 'respvid') . '</strong><br />' . __('This plugin does not require any settings. However, you find a short tutorial on this page to see how the shortcode and the widget work.', 'respvid') . '</p>' . "\n";
	echo '<p>' . __('This plugin supports all the video hosting platforms that Wordpress natively supports. You can find a list of these in the', 'respvid') . ' <a href="http://codex.wordpress.org/Embeds" target="_blank">Wordpress Codex</a>.<br />' . "\n";
	echo __('Furthermore (although it is not the original purpose of the plugin) you can also use the shortcode to display other oEmbed media in a responsive manner. For this reason, the plugin also allows some aspect ratios that would be weird for video, like 3:2, 3:1 and 5:6.', 'respvid' ) . ' ' . "\n";
	echo __('A few recommendations? Many images use an aspect ratio of 3:2, the 3:1 ratio might be useful for single audio like from Soundcloud or Spotify, while the 5:6 thing is a good choice for audio playlists or something like that.', 'respvid' ) . '</p>' . "\n";
	echo '<h3>' . __('Shortcode usage', 'respvid') . '</h3>' . "\n";
	echo '<p style="margin-left: 20px;">' . __('Example', 'respvid') . ': <code>[video align="right" aspect_ratio="16:9" width="90" autoplay="0"]http://www.youtube.com/watch?v=xxxxxxxxxxx[/video]</code></p>' . "\n";
	echo '<p>' . __('This shortcode allows you to embed video from video hosting platforms (and some other media) in a responsive way. It can be used for any platform that the <a href="http://codex.wordpress.org/Embeds" target="_blank">Wordpress oEmbed Feature</a> supports.', 'respvid') . '<br />';
	echo __('All you need to do is insert the video URL as the content between, the shortcode will then handle the responsive embedding.', 'respvid') . '</p>' . "\n";
	echo '<h3>' . __('Parameters', 'respvid') . '</h3>' . "\n";
	echo '<p>' . __('The shortcode uses the following three parameters:', 'respvid') . '</p>' . "\n";
	echo '<ul>' . "\n";
	echo '<li style="margin-left:20px;"><strong>align</strong><br />' . __('The alignment of the video; if you use &quot;left&quot; or &quot;right&quot;, it will be a float layout.', 'respvid' ) . '<br /><em>' . __('Possible values:', 'respvid' ) . '</em> left, center, right<br /><em>' . __( 'Default', 'respvid' ) . ':</em> center</li>' . "\n";
	echo '<li style="margin-left:20px;"><strong>aspect_ratio</strong><br />' . __('The aspect ratio of the video; be careful: not all services look good on every ratio.', 'respvid' ) . '<br /><em>' . __('Possible values:', 'respvid' ) . '</em> 4:3, 16:9, 21:9, 3:2, 3:1, 5:6<br /><em>' . __( 'Default', 'respvid' ) . ':</em> 16:9</li>' . "\n";
	echo '<li style="margin-left:20px;"><strong>width</strong><br />' . __('The width of the video in percent; please only write the number, NOT the percent sign.', 'respvid' ) . '<br /><em>' . __('Possible values:', 'respvid' ) . '</em>' . __( 'every full number between 1 and 100', 'respvid' ) . '<br /><em>' . __( 'Default', 'respvid' ) . ':</em> 100</li>' . "\n";
	echo '<li style="margin-left:20px;"><strong>autoplay</strong><br />' . __('If the media content should start playing automatically; sadly, as of now Vimeo and Soundcloud are the only platforms supporting autoplays in oEmbed; this attribute will not change anything when used with another provider', 'respvid' ) . '<br /><em>' . __('Possible values:', 'respvid' ) . '</em> 0, 1<br /><em>' . __( 'Default', 'respvid' ) . ':</em> 0</li>' . "\n";
	echo '</ul>' . "\n";
	echo '<p>' . __('<em>Note:</em> All parameters are optional. If they are not given, the default values are used.', 'respvid') . '</p>' . "\n";
	echo '<h3>' . __('Widget usage', 'respvid') . '</h3>' . "\n";
	echo '<p>' . __('Using the widget you can display a list of videos (or other media) in a responsive way - the videos scale down according to the widget width. The widget furthermore supports RTL language formatting.') . '</p>' . "\n";
	echo '<p>' . __('The widget settings are rather self-explainatory. All you need to do is to type in the URLs of your videos into the text area (one URL per line!). You can then choose the aspect ratio of the videos (note again: not all hosting services support all ratios!) as well as how many videos will be displayed in a row. If you tick the checkbox, the videos will be presented from right-to-left - and that\'s about it.', 'respvid' ) . '</p>' . "\n";
	echo '</div>' . "\n";
}

/**
 * Adds an options page to the WordPress Settings menu.
 * 
 * @since 1.0
 */
function resp_menu()
{
	add_options_page( 'Responsive Video', 'Responsive Video', 'publish_posts', 'resp-video-menu', 'resp_options_page' );
}
add_action( 'admin_menu', 'resp_menu' );

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
 * @see resp_before_video(), resp_embed_video(), resp_after_video()
 * @since 1.0
 */
function resp_video_shortcode( $atts , $content = null )
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
	
	$embed = resp_validate_attributes( $align, $aspect_ratio, $width, $autoplay );
	
	$code = resp_before_video( $embed['align'], $embed['aspect-ratio'], $embed['width'] );
	$code .= resp_embed_video( $content, $embed['autoplay'] );
	$code .= resp_after_video();
	return $code;
}
add_shortcode( 'video', 'resp_video_shortcode' );

/**
 * Returns content to be printed before the video.
 * 
 * @return string HTML code containing two divs with the necessary CSS classes attached
 * @since 1.0
 */
function resp_before_video( $align, $aspect, $width = null )
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
 * @return string HTML code containing the oEmbed
 * @since 1.0
 */
function resp_embed_video( $url, $autoplay = 0 )
{
	$regex = "/ (width|height)=\"[0-9\%]*\"/";
	$embed_code = wp_oembed_get( $url, array( 'width' => '100%', 'height' => '100%', 'autoplay' => $autoplay ) );
	if( !$embed_code )
	{
		return '<strong>' . __('Error: Invalid URL!', 'respvid') . '</strong>';
	}
	return preg_replace( $regex, '', $embed_code );
}

/**
 * Returns content to be printed after the video.
 * 
 * @return string HTML code containing two closing divs
 * @since 1.0
 */
function resp_after_video()
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
 * @since 1.0
 */
function resp_validate_attributes( $align, $aspect_ratio, $width, $autoplay )
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
	
	$allowed_ratios = resp_get_allowed_aspect_ratios();
	
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

/**
 * Returns an array of allowed aspect ratios.
 * 
 * @return array contains the aspect ratios that are valid
 * @since 1.15
 */
function resp_get_allowed_aspect_ratios()
{
	$allowed = array(
		'4:3',
		'16:9',
		'21:9',
		'3:2',
		'3:1',
		'5:6',
	);
	return $allowed;
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
 * @see resp_handle_additional_embed_args()
 * @since 1.15
 */
function resp_modify_wp_embed_defaults( $defaults = array() )
{
	$defaults['autoplay'] = 0;
	
	return $defaults;
}
add_filter( 'embed_defaults', 'resp_modify_wp_embed_defaults', 10, 1 );

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
 * @since 1.15
 */
function resp_handle_additional_embed_args( $provider, $url, $args = array() )
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
add_filter( 'oembed_fetch_url', 'resp_handle_additional_embed_args', 10, 3 );

?>
