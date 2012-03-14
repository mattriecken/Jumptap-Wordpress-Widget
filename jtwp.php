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
	$classes[] = "blue";
	return $classes;
}

add_filter( "body_class", "turn_body_blue" );

?>
