<?php
/**
 * @package Responsive Video Shortcodes
 * @version 1.1
 */
/*
Plugin Name: Responsive Video Shortcodes
Plugin URI: http://wordpress.org/extend/plugins/responsive-video-shortcodes/
Description: This tiny Plugin allows you to embed Online Video from YouTube, Vimeo and more for a responsive Layout - they scale according to the screen size.
Author: Felix Arntz
Version: 1.1
Author URI: http://www.leaves-and-love.net/
*/

require( plugin_dir_path( __FILE__ ) . 'respvid-widget.php' );

function resp_scripts_init()
{
	wp_register_style( 'resp-video-style', plugin_dir_url( __FILE__ ) . 'respvid.css' );
    wp_enqueue_style( 'resp-video-style' );
}  
add_action('wp_enqueue_scripts', 'resp_scripts_init');

function resp_widgets_init()
{
	register_widget( 'respvid_widget' );
}
add_action( 'widgets_init', 'resp_widgets_init' );

function resp_options_page()
{
	echo '<div class="wrap">' . "\n";
	echo '<h2><a href="http://www.leaves-and-love.net/responsive-video-shortcodes/" target="_blank">Responsive Video Shortcodes</a> - ' . __('Settings') . '</h2>' . "\n";
	echo '<p><strong>' . __('You\'re lucky!', 'respvid') . '</strong><br />' . __('This plugin does not require any settings. However, you find a short tutorial on this page to see how the shortcode and the widget work.', 'respvid') . '</p>' . "\n";
	echo '<p>' . __('This plugin supports all the video hosting platforms that Wordpress natively supports. You can find a list of these in the', 'respvid') . ' <a href="http://codex.wordpress.org/Embeds" target="_blank">Wordpress Codex</a>.</p>' . "\n";
	echo '<h3>' . __('Shortcode usage', 'respvid') . '</h3>' . "\n";
	echo '<p style="margin-left: 20px;">' . __('Example', 'respvid') . ': <code>[video align="right" aspect_ratio="16:9" width="90"]http://www.youtube.com/watch?v=xxxxxxxxxxx[/video]</code></p>' . "\n";
	echo '<p>' . __('This shortcode allows you to embed video from video hosting platforms in a responsive way. It can be used for any platform that the <a href="http://codex.wordpress.org/Embeds" target="_blank">Wordpress oEmbed Feature</a> supports.', 'respvid') . '<br />';
	echo __('All you need to do is insert the video URL as the content between, the shortcode will then handle the responsive embedding.', 'respvid') . '</p>' . "\n";
	echo '<h3>' . __('Parameters', 'respvid') . '</h3>' . "\n";
	echo '<p>' . __('The shortcode uses the following three parameters:', 'respvid') . '</p>' . "\n";
	echo '<ul>' . "\n";
	echo '<li style="margin-left:20px;"><strong>align</strong><br />' . __('The alignment of the video; if you use &quot;left&quot; or &quot;right&quot;, it will be a float layout.', 'respvid') . '<br />' . __('<em>Possible values:</em> left, center, right<br /><em>Default:</em> center', 'respvid') . '</li>' . "\n";
	echo '<li style="margin-left:20px;"><strong>aspect_ratio</strong><br />' . __('The aspect ratio of the video; be careful: not all video services support the 21:9 ratio.', 'respvid') . '<br />' . __('<em>Possible values:</em> 4:3, 16:9, 21:9<br /><em>Default:</em> 16:9', 'respvid') . '</li>' . "\n";
	echo '<li style="margin-left:20px;"><strong>width</strong><br />' . __('The width of the video in percent; please only write the number, NOT the % sign.', 'respvid') . '<br />' . __('<em>Possible values:</em> every full number between 1 and 100<br /><em>Default:</em> 100', 'respvid') . '</li>' . "\n";
	echo '</ul>' . "\n";
	echo '<p>' . __('<em>Note:</em> All parameters are optional. If they are not given, the default values are used.', 'respvid') . '</p>' . "\n";
	echo '<h3>' . __('Widget usage', 'respvid') . '</h3>' . "\n";
	echo '<p>' . __('Using the widget you can display a list of videos in a responsive way - the videos scale down according to the widget width. The widget furthermore supports RTL language formatting.') . '</p>' . "\n";
	echo '<p>' . __('The widget settings are rather self-explainatory. All you need to do is to type in the URLs of your videos into the text area (one URL per line!). You can then choose the aspect ratio of the videos (note again: not all hosting services support 21:9!) as well as how many videos will be displayed in a row. If you tick the checkbox, the videos will be presented from right-to-left - and that\'s about it.') . '</p>' . "\n";
	echo '</div>' . "\n";
}

function resp_menu()
{
	add_options_page( 'Responsive Video', 'Responsive Video', 'publish_posts', 'resp-video-menu', 'resp_options_page' );
}
add_action( 'admin_menu', 'resp_menu' );

function resp_video_shortcode( $atts , $content = null )
{
	// Attributes
	extract( shortcode_atts(
		array(
			'align' => 'center',
			'aspect_ratio' => '16:9',
			'width' => '100',
		), $atts )
	);
	
	$embed = resp_validate_attributes( $align, $aspect_ratio, $width );
	
	$code = resp_before_video( $embed['align'], $embed['aspect-ratio'], $embed['width'] );
	$code .= resp_embed_video( $content );
	$code .= resp_after_video();
	return $code;
}
add_shortcode( 'video', 'resp_video_shortcode' );

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

function resp_embed_video( $url )
{
	$regex = "/ (width|height)=\"[0-9\%]*\"/";
	$embed_code = wp_oembed_get( $url, array( 'width' => '100%', 'height' => '100%' ) );
	if( !$embed_code )
	{
		return '<strong>' . __('Error: Invalid URL!', 'respvid') . '</strong>';
	}
	return preg_replace( $regex, '', $embed_code );
}

function resp_after_video()
{
	$code = '</div>';
	$code .= '</div>';
	return $code;
}

/**
 * 
 * Validates the attributes for the shortcodes.
 * @param String $align the alignment of the video. Possible values are "left", "right" and "center" (default)
 * @param String $aspect_ratio the aspect ratio of the video. Possible values are "4:3", "21:9" and "16:9" (default)
 * @param int $width the width of the video in %. Must be greater than 0 and lower than 101. Default value is 100.
 * @return array $atts contains the validated attributes
 */
function resp_validate_attributes( $align, $aspect_ratio, $width )
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
	if( $aspect_ratio != '4:3' && $aspect_ratio != '16:9' && $aspect_ratio != '21:9' )
	{
		$atts['aspect-ratio'] = '16:9';
	}
	else
	{
		$atts['aspect-ratio'] = $aspect_ratio;
	}
	$atts['aspect-ratio'] = str_replace( ':', '-', $atts['aspect-ratio'] );
	$width = intval($width);
	if( $width < 1 || $width > 100 )
	{
		$atts['width'] = 100;
	}
	else
	{
		$atts['width'] = $width;
	}
	return $atts;
}

?>
