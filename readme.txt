=== Plugin Name ===

Plugin Name:       Responsive Video Shortcodes
Plugin URI:        http://wordpress.org/plugins/responsive-video-shortcodes/
Tags:              autoplay, embed, iframe, media, oembed, responsive, rtl, shortcodes, url, video, widget, youtube, vimeo, soundcloud
Author URI:        http://leaves-and-love.net
Author:            Felix Arntz
Donate link:       http://leaves-and-love.net/wordpress-plugins/
Contributors:      flixos90
Requires at least: 3.2 
Tested up to:      4.3
Stable tag:        1.2.5
Version:           1.2.5
License:           GPL v3 
License URI:       http://www.gnu.org/licenses/gpl-3.0

This tiny plugin allows you to embed online video from YouTube, Vimeo and more media for a responsive layout - they scale according to the screen size. It features shortcode and widget.

== Description ==

> **No longer maintained:**
> This plugin is no longer maintained. Unfortunately I don't have the capacities to keep up with this project as there are other WordPress-related projects & plugins that are higher priority to me, and to a certain degree I also feel like, while this plugin serves a specific useful purpose, its job should rather be done by a theme (and many do so already). Also, if I started this plugin now, I wouldn't go for a shortcode, but just handle the videos automatically to make them responsive. But I don't want to go to much into detail here.
> I want to thank all the users of this plugin, you really gave me a warm welcome here (this was my first plugin!). I understand if you feel a little let down now, but there are only 24 hours in a day... I hope you can see my point of view as well.
> Generally however, I think this plugin is good to go on without any updates as this part of functionality shouldn't open any security holes. The downside is that there won't be any enhancements any longer. So again, thank you so much for your motivation and that you use the plugin!

Responsive Video Shortcodes is a tiny plugin that allows you to embed video files from the popular video hosting platforms in a responsive design. It is based on the WordPress oEmbed feature, so it supports every online service that is natively supported by WordPress. All you need to do is use the shortcode and put a video URL in the content between the tags. Alternatively, you can use the included widget to display a (responsive) list of videos.

You can furthermore use the plugin to display even non-video media in a responsive manner, for example Flickr images, Soundcloud songs or Spotify playlists.

= Shortcode Compatibility =

Since version 1.2.0, a compatibility mode exists to make this plugin's [video] shortcode compatible with the WordPress Core [video] shortcode which has been introduced in 3.6. This plugin's shortcode creates a wrapper around embedded videos and other media to make them responsive. It has nothing to do with the homonymous WordPress Core shortcode (which handles HTML5 video). Please keep in mind that the WordPress [video] shortcode is self-closing while this plugin's [video] shortcode isn't. This is how the two shortcodes can be separated from each other.

= Supported Aspect ratios =

* 4:3 (mainly for video)
* 16:9 (mainly for video)
* 21:9 (mainly for video)
* 3:2 (for some images)
* 3:1 (recommended to use with single audio tracks)
* 5:6 (recommended to use with audio playlists)
* 1:1 (for square images or tweets with images)

= Autoplay functionality =

As of Version 1.1.6, Vimeo and Soundcloud are the only platforms supporting autoplays using oEmbed (the WordPress way to embed media). Therefore it is currently not possible to extend the plugin to add the autoplay functionality for another provider. However, if more platforms start supporting this, it will be implemented in future versions of the plugin aswell.

== Installation ==

1. Upload the entire `responsive-video` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Use the shortcode or the widget - or both.

The shortcode can use the attributes 'align', 'aspect_ratio', 'width' and 'autoplay'.

You will find a 'Responsive Video' menu in your WordPress settings. There are no settings to configure, so it contains a detailed tutorial on how to use the shortcode.

== Frequently Asked Questions ==

= What is the name of the shortcode? =

You should use the enclosing [video] shortcode.

= How do I use the shortcode? =

You find a detailed description in the 'Responsive Video' menu in your WordPress settings.

= Why aren't my videos shown in the widget? =

Maybe you entered them the wrong way. Please give only ONE VIDEO URL per line, and DO NOT separate them by an additional character.

== Screenshots ==

1. Video Examples
2. Shortcode Examples
3. Widget Example

== Changelog ==

= 1.2.5 =
* changed textdomain to `responsive-video-shortcodes` for translate.wordpress.org

= 1.2.4 =
* Added new aspect ratio 1:1
* Fixed a CSS bug by applying !important to the embed properties

= 1.2.3 =
* Includes Spanish translation (credit to Andrew Kurtis <andrewk@webhostinghub.com>)

= 1.2.2 =
* Frontend and backend classes now use Singleton Pattern
* Added composer.json
* Now on Packagist

= 1.2.1 =
* Minor Changes under the Hood

= 1.2.0 =
* Compatibility Mode for WordPress [video] shortcode included
* Plugin is now fully object-oriented
* Widget security improved

= 1.1.0 =
* Widget for Responsive Video List added
* Plugin now translation-ready

= 1.0.0 =
* First stable version

== Upgrade Notice ==

The current version of Responsive Video Shortcodes requires WordPress 3.2 or higher. Some video hosting platforms might not be available for use if you do not have the current version of WordPress installed.

== Additional Credit ==

This plugin would not exist without the amazing articles by [Thierry Koblentz](http://alistapart.com/article/creating-intrinsic-ratios-for-video) and [Anders M. Andersen](http://amobil.se/2011/11/responsive-embeds/).
