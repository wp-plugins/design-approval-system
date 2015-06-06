<?php
namespace Design_Approval_System;
class DAS_Walk_Through extends Design_Approval_System_Core {
	function __construct() {
		if (is_admin()) {
			add_action( 'wp_ajax_dasplugin_wp_pointers_remove', array($this,'dasplugin_wp_pointers_remove'));
			add_action( 'admin_init', array($this,'load_dasplugin'));
		};
		register_activation_hook( __FILE__, array($this,'my_dasplugin_activate'));
	}
	//**************************************************
	// DAS Walkthrough on Activation
	//**************************************************
	function my_dasplugin_activate() {
		//This is only active when the pointer has not been closed.
		add_option( 'Activated_Plugin', 'Design-Approval-Sytem' );
	}
	//**************************************************
	// DAS Walkthrough on De-Activation
	//**************************************************
	function load_dasplugin() {
		// we only want to fire and show the tutorial to the admin otherwise the tour will not follow the proper steps because some menu items will be missing.
		if ( is_admin()) {
			delete_option( 'Activated_Plugin', 'Design-Approval-Sytem' );
			/* do stuff once right after activation */
			include_once dirname( __FILE__ ) . '/welcome-notes.php';
		}
	}
	//**************************************************
	// DAS Remove Walkthrough Pointers
	//**************************************************
	function dasplugin_wp_pointers_remove() {
		$user_meta = get_user_meta(get_current_user_id(), "dismissed_wp_pointers", TRUE);
		$user_key = 'dasplugin_tour1';
		$my_options = array(','.$user_key, $user_key.',', $user_key);

		$fixd_meta = str_replace($my_options, '', $user_meta);
		if ($user_meta) {
			update_user_meta(get_current_user_id(), 'dismissed_wp_pointers', $fixd_meta);
		}
		// Print meta data for testing to make sure the user key info is deleted.
		// Test by clicking your close button on the pointer, then go to the plugins page, you should see the tour again.
		// Uncomment the next 2 lines to see array coming from database under, user_meta / dismissed_wp_pointers
		// $meta_data_check = get_user_meta(get_current_user_id(), 'dismissed_wp_pointers', true);
		// print Print_r ($meta_data_check);
	}
}
new DAS_Walk_Through();
?>