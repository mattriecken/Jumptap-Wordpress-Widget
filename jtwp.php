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

require_once(dirname(__FILE__) . "/jtwp_admin.php");

// Switch them to JTWP if the request is from a handset
if(get_option('jtwp_reroute_iphone') == 'on' && preg_match('/(chrom|iphone)/i', $_SERVER['HTTP_USER_AGENT']))
{
	switch_theme('jtwptheme','jtwptheme');
}

register_activation_hook(__FILE__, 'jtwp_activate');
register_deactivation_hook(__FILE__, "jtwp_remove_theme");

if (!function_exists("jtwp_activate"))
{
	function jtwp_activate()
	{
		
		$local_theme_directory = dirname(__FILE__) . "/themes/jtwptheme";
		$wp_theme_directory = get_theme_root() . "/jtwptheme";
		
		jtwp_copy_theme($local_theme_directory, $wp_theme_directory);
	}
}

function jtwp_copy_theme($source_directory, $destination_directory)
{
	if (!is_dir($destination_directory))
	{
		mkdir($destination_directory);
	}

	$directory_handle = opendir($source_directory);


	while ($source_file = readdir($directory_handle))
	{
		if ($source_file[0] == ".")
		{
			continue;
		}

		$source_file_path = "$source_directory/$source_file";
		$destination_file_path = "$destination_directory/$source_file";

		if (is_dir($source_file_path))
		{
			jtwp_copy_theme($source_file_path, $destination_file_path);
			continue;
		}

		copy($source_file_path, $destination_file_path);
	}

	closedir($directory_handle);
}

function jtwp_deactivate()
{
	$wp_theme_directory = get_theme_root() . "/jtwptheme";
	
	jtwp_remove_theme($wp_theme_directory);
}

function jtwp_remove_theme($directory_path)
{
	if (!is_dir($directory_path) || is_link($directory_path))
	{
		return unlink($directory_path);
	}
	
	foreach (scandir($directory_path) as $file)
	{
		if ($file == '.' || $file == '..')
		{
			continue;
		}
		if (!jtwp_remove_theme($directory_path.DIRECTORY_SEPARATOR.$file))
		{
			if (!jtwp_remove_theme($directory_path.DIRECTORY_SEPARATOR.$file))
			{
				return false;
			}
		};
	}
	return rmdir($directory_path);
}





?>