<?php
// remove top admin bar links
// require_once( __DIR__ . '/ccrind-functions/remove-top-admin-links.php');
add_action( 'wp_before_admin_bar_render', 'remove_menu_buttons', 999 ); 
function remove_menu_buttons() 
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');				// Remove the comments link
    $wp_admin_bar->remove_menu('new-content');			// Remove the content link
	$wp_admin_bar->remove_menu('shortpixel_processing');	// remove shortpixel icon link
	$wp_admin_bar->remove_menu('archive');
	$wp_admin_bar->remove_menu('wpseo-menu');
	$wp_admin_bar->remove_menu('wplister_top');
}
?>