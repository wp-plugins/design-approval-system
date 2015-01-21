<?php
/*
Plugin Name: Design Approval System
Plugin URI: http://slickremix.com/
Description: A plugin to display Projects or Designs and have a client approve them by giving a digital signature.
Version: 4.0.5
Author: SlickRemix
Author URI: http://slickremix.com/
Requires at least: wordpress 3.5.0
Tested up to: wordpress 4.1
Stable tag: 4.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * @package    			Design Approval System
 * @category   			Core
 * @author     		    SlickRemix
 * @copyright  			Copyright (c) 2012-2015 SlickRemix

If you need support or want to tell us thanks please contact us at info@slickremix.com or use our support forum on slickremix.com

This is the main file for building the plugin into wordpress

*/
define( 'DAS_PLUGIN_PATH', plugins_url() ) ;

// Include core files and classes
include( 'includes/das-functions.php' );
include( 'includes/das-meta-box.php' );
include( 'admin/das-settings-page.php' );
include( 'admin/das-help-page.php' );
include( 'admin/das-projects-page.php' );
include( 'updates/update-functions.php' );


function ap_action_init()
{
// Localization
load_plugin_textdomain('design-approval-system', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
// Add actions
add_action('init', 'ap_action_init');

	
function design_approval_system__activate() {	
		/* Add member role to the site */
	add_role('das_designer', 'DAS Designer', array(
		'read' => true,
		'edit_posts' => true,
		'delete_posts' => true,
		'manage_network' => false,			
		'manage_sites' => false,
		'manage_network_users' => false,
		'manage_network_themes' => false,
		'manage_network_options' => false,
		'unfiltered_html' => false,
		'activate_plugins' => false,
		'create_users' => true,
		'delete_plugins' => false,
		'delete_themes' => false,
		'delete_users' => false,
		'edit_files' => false,
		'edit_plugins' => false,
		'edit_theme_options' => false,
		'edit_themes' => false,
		'edit_users' => true,
		'export' => true,
		'import' => true,
		'install_plugins' => false,
		'install_themes' => false,
		'list_users' => false,
		'manage_options' => true,
		'promote_users' => true,
		'remove_users' => true,
		'switch_themes' => false,
		'unfiltered_upload' => false,
		'update_core' => false,
		'update_plugins' => false,
		'update_themes' => false,
		'edit_dashboard' => false,
		'moderate_comments' => true,
		'manage_categories' => true,
		'manage_links' => true,
		'unfiltered_html' => true,
		'edit_others_posts' => true,
		'edit_pages' => true,
		'edit_others_pages' => true,
		'edit_published_pages' => true,
		'publish_pages' => true,
		'delete_pages' => true,
		'delete_others_pages' => true,
		'delete_published_pages' => true,
		'delete_others_posts' => true,
		'delete_private_posts' => true,
		'edit_private_posts' => true,
		'read_private_posts' => true,
		'delete_private_pages' => true,
		'edit_private_pages' => true,
		'read_private_pages' => true,
		'edit_published_posts' => true,
		'upload_files' => true, 
		'publish_posts' => true,
		'delete_published_posts' => true,
		'manage_woocommerce_products' => true,
		'edit_product' => true,
		'read_product' => true,
		'delete_product' => true,
		'edit_products' => true,
		'edit_others_products' => true,
		'publish_products' => true,
		'read_private_products' => true,
		'delete_products' => true,
		'delete_private_products' => true,
		'delete_published_products' => true,
		'delete_others_products' => true,
		'edit_private_products' => true,
		'edit_published_products' => true,
		
	));
	
	/* Add DAS Client role to the site */
	add_role('das_client', 'DAS Client', array(
		'read' => true,
		'edit_others_posts' => true,
		'edit_published_posts' => true,
		'upload_files' => true, 
	));
}

function design_approval_system__deactivate() { 
	remove_role( 'das_designer');
	remove_role( 'das_client' );
	//das_roles_remove();
}
register_activation_hook( __FILE__, 'design_approval_system__activate' );
register_deactivation_hook( __FILE__, 'design_approval_system__deactivate' );

/**
 * Returns current plugin version. SRL added
 * 
 * @return string Plugin version
 */
function dasystem_version() {
	$plugin_data = get_plugin_data( __FILE__ );
	$plugin_version = $plugin_data['Version'];
	return $plugin_version;
}		
?>