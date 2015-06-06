<?php
namespace Design_Approval_System;
class Admin_Menu extends Design_Approval_System_Core {
	function __construct() {
		//Rename Das Menu Item
		add_filter( 'attribute_escape', array($this,'rename_second_das_submenu_name'), 10, 2 );
		//Adds GQ setting page to DAS sub menu
		add_action('admin_menu', array($this,'register_das_gq_theme_settings_submenu_page'));
		//Adds setting page to DAS sub menu
		add_action('admin_menu', array($this,'register_das_settings_submenu_page'));
		//Register Help Menu Item
		add_action('admin_menu', array($this,'register_das_help_submenu_page'));
		//Remove Tags from Admin menu
		add_action('admin_menu', array($this,'remove_tags_menu'));
		//Re-order Sub-Menu Items
		add_action( 'admin_menu', array($this,'reorder_admin_sub_menus'));
	}
	//**************************************************
	// Rename Main Sub-Menu Item
	//**************************************************
	function rename_second_das_submenu_name( $safe_text, $text ) {
		if ( 'Projects' !== $text ) {
			return $safe_text;
		}
		// We are on the main menu item now. The filter is not needed anymore.
		remove_filter( 'attribute_escape', array($this,'rename_second_das_submenu_name'));
		return 'DAS';
	}
	//**************************************************
	// GQ Settings page Sub-Menu Item
	//**************************************************
	 function register_das_gq_theme_settings_submenu_page() {
 		add_submenu_page( 'edit.php?post_type=designapprovalsystem', __('GQ Theme Settings', 'design-approval-system'), __('GQ Template Settings', 'design-approval-system'), 'manage_options', 'das-gq-theme-settings-page', 'das_gq_theme_settings_page' ); 
	 }
	//**************************************************
	// Settings page Sub-Menu Item
	//**************************************************
	function register_das_settings_submenu_page() {
		add_submenu_page( 'edit.php?post_type=designapprovalsystem', __('Design Approval System Settings', 'design-approval-system'), __('Settings', 'design-approval-system'), 'manage_options', 'design-approval-system-settings-page', 'das_settings_page' );
	}
	//**************************************************
	// Help page Sub-Menu Item
	//**************************************************
	function register_das_help_submenu_page() {
		add_submenu_page( 'edit.php?post_type=designapprovalsystem', __('Design Approval System Help', 'design-approval-system'), __('Help', 'design-approval-system'), 'manage_options', 'design-approval-system-help-page', 'das_help_page' );
	}
	//**************************************************
	// Remove Tags from Admin Menu
	//**************************************************
	function remove_tags_menu() {
		// remove_submenu_page was introduced in 3.1
		remove_submenu_page( 'edit.php?post_type=designapprovalsystem', 'edit-tags.php?taxonomy=post_tag&amp;post_type=designapprovalsystem' );
	}
	//**************************************************
	// Reorder Sub-Menu Items
	//**************************************************
	function reorder_admin_sub_menus() {
		global $submenu;
			//$submenu['edit.php?post_type=designapprovalsystem'][10][0] = __('Add New Project', 'design-approval-system');
			
			//Project Board
			$submenu['edit.php?post_type=designapprovalsystem'][5][0] =  __('Project Board', 'design-approval-system');
			$submenu['edit.php?post_type=designapprovalsystem'][5][1] = 'read';
			$submenu['edit.php?post_type=designapprovalsystem'][5][2] = 'design-approval-system-projects-page';
			$submenu['edit.php?post_type=designapprovalsystem'][5][3] = __('Project Board', 'design-approval-system');
			
			//Project Names
			$submenu['edit.php?post_type=designapprovalsystem'][10][0] = __('Project Names', 'design-approval-system');
			$submenu['edit.php?post_type=designapprovalsystem'][10][1] = 'manage_categories';
			$submenu['edit.php?post_type=designapprovalsystem'][10][2] = 'edit-tags.php?taxonomy=das_categories&post_type=designapprovalsystem';
			
			//Add New Design
			$submenu['edit.php?post_type=designapprovalsystem'][16][0] = __('Add New Design', 'design-approval-system');
			$submenu['edit.php?post_type=designapprovalsystem'][16][1] = 'edit_posts';
			$submenu['edit.php?post_type=designapprovalsystem'][16][2] = 'post-new.php?post_type=designapprovalsystem';
			unset($submenu['edit.php?post_type=designapprovalsystem'][16][3]);
			
			//Designs
			$submenu['edit.php?post_type=designapprovalsystem'][17][0] = __('Designs', 'design-approval-system');
			$submenu['edit.php?post_type=designapprovalsystem'][17][1] = 'edit_posts';
			$submenu['edit.php?post_type=designapprovalsystem'][17][2] = 'edit.php?post_type=designapprovalsystem';
			
			//DAS Clients
			$submenu['edit.php?post_type=designapprovalsystem'][18][0] = __('DAS Clients', 'design-approval-system');
			$submenu['edit.php?post_type=designapprovalsystem'][18][1] = 'manage_categories';
			$submenu['edit.php?post_type=designapprovalsystem'][18][2] = 'users.php?role=das_client';
			unset($submenu['edit.php?post_type=designapprovalsystem'][18][3]);
			
			//DAS Designers
			$submenu['edit.php?post_type=designapprovalsystem'][19][0] = __('DAS Designers', 'design-approval-system');
			$submenu['edit.php?post_type=designapprovalsystem'][19][1] = 'manage_categories';
			$submenu['edit.php?post_type=designapprovalsystem'][19][2] = 'users.php?role=das_designer';
			unset($submenu['edit.php?post_type=designapprovalsystem'][19][3]);
			
			//Help
			$submenu['edit.php?post_type=designapprovalsystem'][20][0] = __('Help', 'design-approval-system');
			$submenu['edit.php?post_type=designapprovalsystem'][20][1] = 'manage_options';
			$submenu['edit.php?post_type=designapprovalsystem'][20][2] = 'design-approval-system-help-page';
			$submenu['edit.php?post_type=designapprovalsystem'][20][3] = __('Design Approval System Help', 'design-approval-system');
				
			//Settings
			$submenu['edit.php?post_type=designapprovalsystem'][21][0] = __('Settings', 'design-approval-system');
			$submenu['edit.php?post_type=designapprovalsystem'][21][1] = 'manage_options';
			$submenu['edit.php?post_type=designapprovalsystem'][21][2] = 'design-approval-system-settings-page';
			$submenu['edit.php?post_type=designapprovalsystem'][21][3] = __('Settings', 'design-approval-system');
			
			//Main Template Settings
			$submenu['edit.php?post_type=designapprovalsystem'][25][0] = __('Template Settings', 'design-approval-system');
			$submenu['edit.php?post_type=designapprovalsystem'][25][1] = 'manage_options';
			$submenu['edit.php?post_type=designapprovalsystem'][25][2] = 'das-gq-theme-settings-page';
			$submenu['edit.php?post_type=designapprovalsystem'][25][3] = __('Template Settings', 'design-approval-system');
			
			if(is_plugin_active('das-premium/das-premium.php')){
				//Plugin License 
				$submenu['edit.php?post_type=designapprovalsystem'][30][0] = __('Plugin License', 'design-approval-system');
				$submenu['edit.php?post_type=designapprovalsystem'][30][1] = 'manage_options';
				$submenu['edit.php?post_type=designapprovalsystem'][30][2] = 'pluginname-license';
				$submenu['edit.php?post_type=designapprovalsystem'][30][3] = __('Plugin License', 'design-approval-system');
			}
	}
}
new Admin_Menu();
?>