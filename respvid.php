<?php
/**
 * @package Responsive Video Shortcodes
 * @version 1.2.1
 * @author Felix Arntz <felix-arntz@leaves-and-love.net>
 */
/*
Plugin Name: Responsive Video Shortcodes
Plugin URI: http://wordpress.org/extend/plugins/responsive-video-shortcodes/
Description: This tiny Plugin allows you to embed Online Video from YouTube, Vimeo and more for a responsive Layout - they scale according to the screen size. It features shortcode and widget.
Version: 1.2.1
Author: Felix Arntz
Author URI: http://leaves-and-love.net/
Text Domain: respvid
Domain Path: /languages/
License: GPL v3

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

define( 'RESPVID_VERSION', '1.2.1' );

define( 'RESPVID_PATH', plugin_dir_path( __FILE__ ) );
define( 'RESPVID_URL', plugin_dir_url( __FILE__ ) );
define( 'RESPVID_WEBSITE', 'http://leaves-and-love.net/responsive-video-shortcodes/' );

$respvid_frontend = null;
$respvid_backend = null;

/**
 * Initializes the plugin's frontend class
 * 
 * @since 1.2.0
 */
function respvid_init()
{
	require_once( RESPVID_PATH . 'respvid-utilities.php' );
	
	if( !is_admin() || is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX )
	{
		global $respvid_frontend;
		require_once( RESPVID_PATH . 'respvid-frontend.php' );
		$respvid_frontend = new Respvid_Frontend();
	}
	else
	{
		global $respvid_backend;
		require_once( RESPVID_PATH . 'respvid-backend.php' );
		$respvid_backend = new Respvid_Backend();
	}
	
	require_once( RESPVID_PATH . 'respvid-widget.php' );
}
add_action( 'plugins_loaded', 'respvid_init' );

/**
 * Registers the included Responsive Video Widget.
 * 
 * @since 1.0.0
 */
function respvid_widgets_init()
{
	register_widget( 'Respvid_Widget' );
}
add_action( 'widgets_init', 'respvid_widgets_init' );

/**
 * Loads the plugin translations.
 * 
 * @since 1.1.5
 */
function respvid_load_translations()
{
	load_plugin_textdomain( 'respvid', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'wp_loaded', 'respvid_load_translations' );
