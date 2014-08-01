<?php
/**
 * Class: Respvid_Backend
 *
 * This class adds a menu page containing a short guide to the WordPress backend.
 * 
 * @package ResponsiveVideoShortcodes
 * @version 1.2.3
 * @author Felix Arntz <felix-arntz@leaves-and-love.net>
 */
class Respvid_Backend
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
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}
	
	/**
	 * Adds an options page to the WordPress Settings menu.
	 * 
	 * @since 1.0.0
	 */
	public function admin_menu()
	{
		add_options_page( 'Responsive Video', 'Responsive Video', 'publish_posts', 'resp-video-menu', array( $this, 'options_page' ) );
	}
	
	/**
	 * Renders the content of the options page.
	 * 
	 * Since the plugin only consists of an easy-to-use shortcode and a widget, there are no settings to display.
	 * Instead, the options page shows a short guide on how to use these things.
	 * 
	 * @since 1.0.0
	 */
	public function options_page()
	{
		echo '<div class="wrap">' . "\n";
		echo '<h2><a href="' . RESPVID_WEBSITE . '" target="_blank">Responsive Video Shortcodes</a> - ' . __('Settings') . '</h2>' . "\n";
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
}

// Class instantiation
Respvid_Backend::instance();
