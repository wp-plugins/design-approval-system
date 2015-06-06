<?php
/*
Plugin Name: Design Approval System
Plugin URI: http://slickremix.com/
Description: A plugin to display Projects or Designs and have a client approve them by giving a digital signature.
Version: 4.0.8
Author: SlickRemix
Author URI: http://slickremix.com/
Requires at least: wordpress 3.6.0
Tested up to: wordpress 4.2.2
Stable tag: 4.0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * @package    			Design Approval System
 * @category   			Core
 * @author     		    SlickRemix
 * @copyright  			Copyright (c) 2012-2015 SlickRemix
If you need support or want to tell us thanks please contact us at support@slickremix.com or use our support forum on slickremix.com
This is the main file for building the plugin into wordpress
*/
define( 'DAS_PLUGIN_PATH', plugins_url() ) ;
// Include Core Class
include( 'includes/core-class.php' );
//Admin Menu Class
include( 'includes/admin-menu-class.php' );
//WalkThrough Class
include( 'includes/walk-through-class.php' );
include( 'includes/admin-tour-pointers.php' );
//Project Board Class
include( 'includes/project-board-functions.php' );
//GQ Theme
include( 'templates/gq-template/gq-template-class.php' );
include( 'templates/gq-template/admin/das-gq-theme-settings-page.php' );
include( 'templates/gq-template/das-gq-theme-functions.php' );
//Meta Box
include( 'includes/das-meta-box.php' );
//Admin Pages
include( 'admin/das-settings-page.php' );
include( 'admin/das-help-page.php' );
include( 'admin/das-projects-page.php' );
//Register Clients Front End Form Class
include( 'includes/das-register-clients-shortcode.php' );
//Create New Design Post Class
include( 'includes/das-create-new-design-post-shortcode.php' );
// Updater For Premium Plugins
include( 'updates/update-functions.php' );
function ap_action_init() {
	// Localization
	load_plugin_textdomain('design-approval-system', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
// Add actions
add_action('init', 'ap_action_init');
if ( ! function_exists( 'is_plugin_active' ) )
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
// Makes sure the plugin is defined before trying to use it
// Make sure php version is greater than 5.3
if ( function_exists( 'phpversion' ) )
	$phpversion = phpversion();
$phpcheck = '5.2.9';
if ($phpversion > $phpcheck) {
	// Include our own Settings link to plugin activation and update page. NOT NEEDED IN THIS PLUGIN
	add_filter("plugin_action_links_".plugin_basename(__FILE__), "das_main_plugin_actions", 10, 4);
	function das_main_plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
		array_unshift($actions, "<a href=\"".menu_page_url('design-approval-system-settings-page', false)."\">".__("Settings")."</a>");
		return $actions;
	}
} // end if php version check
else {
	// if the php version is not at least 5.3 do action
	deactivate_plugins( 'das-premium/das-premium.php' );
	deactivate_plugins( 'design-approval-system/design-approval-system.php' );
	add_action( 'admin_notices', 'das_client_changes_required_php_check1' );
	function das_client_changes_required_php_check1() {
		echo '<div class="error"><p>' . __( 'Warning: Your version of php must be 5.3 or greater to use this plugin. Please upgrade the php by contacting your host provider. Some host providers will allow you to change this yourself in the hosting control panel too.', 'my-theme' ) . '</p></div>';
	}
}
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
	//Create Page for Frontend Manager
	$project_link = get_option('das-gq-theme-settings-project-board-btn-link');
		if(empty($project_link)){
		$new_post = array(
			  'comment_status' => 'closed', // 'closed' means no comments.
			  'post_content' => '[DASFrontEndManager]', //The full text of the post.
			  'post_name' => 'project-manager',// The name (slug) for your post
			  'post_status' => 'publish', //Set the status of the new post.
			  'post_title' => 'Project Manager', //The title of your post.
			  'post_type' => 'page'  //Sometimes you want to post a page.
		);  
		// Insert the post into the database
		$new_project_manager_page_id = wp_insert_post($new_post);
		
		if($new_project_manager_page_id !== '0' || $new_project_manager_page_id !== false){
			$default_project_manager_page_url = get_permalink($new_project_manager_page_id);
			update_option('das-gq-theme-settings-project-board-btn-link', $default_project_manager_page_url);
		}	
			
	}
	
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

if (dasystem_version() > '1.0' && dasystem_version() < '4.0.8') {
	// Better update message
	$path = plugin_basename( __FILE__ );
	$hook = "in_plugin_update_message-{$path}";
	add_action( $hook, 'your_update_message_cb', 20, 2 );
	/**
	 * Displays an update message for plugin list screens.
	 * Shows only the version updates from the current until the newest version
	 */
	function your_update_message_cb() {
		$output = '<div class="das-update-message">'.__( '4.0.8+ is a Major Update so it is important that you read the upgrade notice and changes before you update this plugin. To see what changes and improvements we have made <a href="http://www.slickremix.com/design-approval-system-major-changes" target="_blank">please click here</a>. All current premium extension owners will be getting a coupon to recieve the new DAS Premium Plugin for FREE.').'</div>';
		return print $output;
	}
}
// Include Leave feedback, Get support and Plugin info links to plugin activation and update page.
add_filter("plugin_row_meta", "das_main_add_leave_feedback_link", 10, 2);
function das_main_add_leave_feedback_link( $links, $file ) {
	if ( $file === plugin_basename( __FILE__ ) ) {
		$links['feedback'] = '<a href="http://wordpress.org/support/view/plugin-reviews/design-approval-system" target="_blank">' . __( 'Leave feedback', 'gd_quicksetup' ) . '</a>';
		$links['support']  = '<a href="http://wordpress.org/support/plugin/design-approval-system" target="_blank">' . __( 'Get support', 'gd_quicksetup' ) . '</a>';
	}
	return $links;
}
?>