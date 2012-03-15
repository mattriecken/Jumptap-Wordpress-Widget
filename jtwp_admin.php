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


function jtwp_plugin_menu() {
	add_options_page('JTWP Options', 'JTWP', 'manage_options', 'jtwp_plugin', 'jtwp_plugin_options');
}

function jtwp_plugin_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}

add_action('admin_menu', 'jtwp_plugin_menu');


?>
