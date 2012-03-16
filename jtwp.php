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

// Switch them to JTWP if the request is from a handset
if(get_option('reroute_iphone') == 'on' && preg_match('/(chrome|iphone)/i', $_SERVER['HTTP_USER_AGENT']))
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




add_action('admin_menu', 'jtwp_plugin_menu');

function jtwp_plugin_menu() {
	add_options_page('JTWP Options', 'JTWP Options', 'manage_options', 'jtwp', 'jtwp_plugin_options');
}

function jtwp_plugin_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	
	$reroute_iphone = get_option('jtwp_reroute_iphone');
	
	if ($_POST)
	{
		if (isset($_POST['jtwp_reroute_iphone']))
		{
			$reroute_iphone = "on";
		}
		else 
		{
			$reroute_iphone = "off";
		}	
		update_option('jtwp_reroute_iphone', $reroute_iphone);
	}

	$display_iphone_position = get_option('jtwp_display_iphone_position');
	if (isset($_POST['jtwp_display_iphone_position']))
	{
		$display_iphone_position = $_POST['jtwp_display_iphone_position'];
		update_option('jtwp_display_iphone_position', $display_iphone_position);
	}
	
	$publisher_alias = get_option('jtwp_publisher_alias');	
	if (isset($_POST['jtwp_publisher_alias']))
	{
		$publisher_alias = $_POST['jtwp_publisher_alias'];
		update_option('jtwp_publisher_alias', $publisher_alias);
	}
	
	$adspot_alias = get_option('jtwp_adspot_alias');
	if (isset($_POST['jtwp_adspot_alias']))
	{
		$adspot_alias = $_POST['jtwp_adspot_alias'];
		update_option('jtwp_adspot_alias', $adspot_alias);
	}
	
	?>
	
	<form name="jtwp_admin" method="POST" action="">

		<p>Re-route:
			<ul>
				<li>iPhone Requests <input type="checkbox" name="jtwp_reroute_iphone" <?php if ($reroute_iphone == "on") echo "checked";?>/></li>
				<li>...and place ads on the
					<ul>
						<li><input type="radio" name="jtwp_display_iphone_position" value="top" <?php if ($display_iphone_position == "top") echo "checked"; ?>/>top</li>
						<li><input type="radio" name="jtwp_display_iphone_position" value="bottom" <?php if ($display_iphone_position == "bottom") echo "checked"; ?>/>bottom</li>
					</ul>
				</li>
			</ul>
		</p>
		
		<hr />
			
		<p>Enter Publisher Alias:
			<input type="text" name="jtwp_publisher_alias" value="<?php echo $publisher_alias; ?>" />
		</p>
		
		<p>Enter AdSpot Alias:
			<input type="text" name="jtwp_adspot_alias" value="<?php echo $adspot_alias; ?>" />
		</p>
		
		<hr />

		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
		</p>

</form>

<?php 
}
?>
