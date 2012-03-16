<?php

function plugin_admin_head() {
	print '<script type="text/javascript" src=' . plugins_url('jtwp/jtwpscript.js') . '></script>';
	print '<link rel="stylesheet" href=' . plugins_url('jtwp/jtwpstyle.css') . ' />';
}
add_action('admin_head', 'plugin_admin_head');

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

		<h1>JTWP Options</h1>
			<ul>
				Choose the device(s) you would like to intercept and route to your mobile theme:
				<hr />
				<li><input id="iphone_checkbox" type="checkbox" name="jtwp_reroute_iphone" <?php if ($reroute_iphone == "on") echo "checked";?>/> iPhone</li>
				<li>
				<div id="jtwp_display_options">
					<ul>
						<li><input type="radio" name="jtwp_display_iphone_position" value="top" <?php if ($display_iphone_position == "top") echo "checked"; ?>/>top</li>
						<li><input type="radio" name="jtwp_display_iphone_position" value="bottom" <?php if ($display_iphone_position == "bottom") echo "checked"; ?>/>bottom</li>
					</ul>
				</div>
				</li>
				<li><input id="android_checkbox" disabled type="checkbox" name="jtwp_reroute_android" /> Android</li>
				
			</ul>
		</p>
		
		<hr />
			
		<p>Enter Your Publisher Alias:
			<input type="text" name="jtwp_publisher_alias" value="<?php echo $publisher_alias; ?>" />
		</p>
		
		<p>Enter Your AdSpot Alias:
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
