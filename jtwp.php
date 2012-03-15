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

if (preg_match("/(iPhone|chrome)/i", $_SERVER['HTTP_USER_AGENT']))
{
	function change_template() 
	{
		return 'jtwptheme';
	}
	
	add_filter( 'template', "change_template" );
	add_filter( "stylesheet", "change_template" );
}


add_filter( "body_class", "turn_body_blue" );


<<<<<<< HEAD



=======
>>>>>>> origin/master
?>
