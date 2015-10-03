<?php
/**
 * @package ResponsiveVideoShortcodes
 * @version 1.2.5
 * @author Felix Arntz <felix-arntz@leaves-and-love.net>
 */	
/**
 * Returns an array of allowed aspect ratios.
 * 
 * @return array contains the aspect ratios that are valid
 * @since 1.1.5
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
    '1:1',
	);
	return $allowed;
}
