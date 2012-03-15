<?php
/**
 * @package JTWP
 * @version 0.1
 */
/*
Plugin Name: JTWP
Author: JTWP
Version: 0.1
*/

function turn_body_blue($classes)
{
	if (preg_match("/chrome/i", $_SERVER['HTTP_USER_AGENT']))
		$classes[] = "blue";
	
	return $classes;
}

add_filter( "body_class", "turn_body_blue" );





?>
