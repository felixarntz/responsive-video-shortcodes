<?php
/*
Plugin Name:    Responsive Video Shortcodes
Plugin URI:     http://wordpress.org/plugins/responsive-video-shortcodes/
Description:    This tiny plugin allows you to embed online video from YouTube, Vimeo and more for a responsive layout - they scale according to the screen size. It features shortcode and widget.
Version:        1.2.5
Author:         Felix Arntz
Author URI:     http://leaves-and-love.net/
Text Domain:    responsive-video-shortcodes
Domain Path:    /languages/
License:        GPL v3
License URI:    http://opensource.org/licenses/GPL-3.0

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
/**
 * @package ResponsiveVideoShortcodes
 * @version 1.2.5
 * @author Felix Arntz <felix-arntz@leaves-and-love.net>
 */

define( 'RESPVID_VERSION', '1.2.5' );
define( 'RESPVID_MAINFILE', __FILE__ );
define( 'RESPVID_PATH', plugin_dir_path( RESPVID_MAINFILE ) );
define( 'RESPVID_URL', plugin_dir_url( RESPVID_MAINFILE ) );
define( 'RESPVID_BASENAME', plugin_basename( RESPVID_MAINFILE ) );
define( 'RESPVID_WEBSITE', 'http://wordpress.org/plugins/responsive-video-shortcodes/' );

/**
 * Initializes the plugin's frontend class
 * 
 * @since 1.2.0
 */
function respvid_init()
{
  if( !is_admin() || is_admin() && defined( 'DOING_AJAX' ) && DOING_AJAX )
  {
    require_once( RESPVID_PATH . 'respvid-frontend.php' );
  }
  else
  {
    require_once( RESPVID_PATH . 'respvid-backend.php' );
  }
  require_once( RESPVID_PATH . 'respvid-utilities.php' );
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
  load_plugin_textdomain( 'responsive-video-shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'wp_loaded', 'respvid_load_translations' );
