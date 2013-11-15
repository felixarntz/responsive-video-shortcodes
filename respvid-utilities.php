<?php
/**
 * @package Responsive Video Shortcodes
 * @version 1.2
 * @author Felix Arntz <felix-arntz@leaves-and-love.net>
 */	
/**
 * Returns an array of allowed aspect ratios.
 * 
 * @return array contains the aspect ratios that are valid
 * @since 1.15
 */
function respvid_get_allowed_aspect_ratios()
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

?>