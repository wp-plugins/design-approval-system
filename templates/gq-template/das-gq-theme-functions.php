<?php
/************************************************
 	Functions for the GQ plugin
************************************************/
 //MOVED ALL STYLES AND JS FOR THIS TEMPLATE TO THE MAIN THEME PAGE SO AS TO NOT OVERRIDE ANY OTHER TEMAPLTES THAT MAY BE IN USE.

// This is to ajax the comments from the comment form to the database and using js we return the success message.
add_action('comment_post', 'wdp_ajaxcomments_stop_for_ajax',20, 2);
function wdp_ajaxcomments_stop_for_ajax($comment_ID, $comment_status){
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	//If AJAX Request Then
		switch($comment_status){
			case '0':
				//notify moderator of unapproved comment
				wp_notify_moderator($comment_ID);
			case '1': //Approved comment
				echo "success";
				$commentdata=&get_comment($comment_ID, ARRAY_A);
				$post=&get_post($commentdata['comment_post_ID']); //Notify post author of comment
				if ( get_option('comments_notify') && $commentdata['comment_approved'] && $post->post_author != $commentdata['user_ID'] )
					wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
				break;
			default:
				echo "error";
		}	
		exit;
	}
}
// function add_plugin_caps() {
    // gets the author role
//     $role = get_role( 'das_client' );

    // This only works, because it accesses the class instance.
    // would allow the author to edit others' posts for current theme only
//     $role->add_cap( 'edit_others_posts' ); 
// }
// add_action( 'admin_init', 'add_plugin_caps');

// Hide the wp admin bar options for das clients... best approach is for users to hide this menu bar when setting up das clients. Additionally users that do try to access the edit page will be redirected to the same page.
add_action('admin_enqueue_scripts', 'das_gq_das_client');
add_action('wp_head', 'das_gq_das_client');
function  das_gq_das_client() {
	$das_client_gq =  current_user_can('das_client');
	 if($das_client_gq) {  
?>
<!-- qq theme CSS override -->
<style type="text/css">
	#wp-admin-bar-new-content, #menu-media, #wp-admin-bar-new-content, #wp-admin-bar-edit { display:none; }
</style>
<?php
	}
 }

if ( is_admin() ){
	add_action( 'admin_init', 'das_gq_theme_settings_page_register_settings' );
}

 function das_gq_theme_settings_page_register_settings() { 
  register_setting( 'das-gq-settings', 'das-gq-theme-main-wrapper-custom-terms' );
  register_setting( 'das-gq-settings', 'das-gq-theme-options-settings-custom-css-main-wrapper-padding' );
  register_setting( 'das-gq-settings', 'das-gq-theme-main-wrapper-padding-input' );
  register_setting( 'das-gq-settings', 'das-gq-theme-main-wrapper-width-input' );
  register_setting( 'das-gq-settings', 'das-gq-theme-main-wrapper-margin-input' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-project-board-btn' );
  register_setting( 'das-gq-settings', 'das-gq-theme-main-wrapper-css-input' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-project-board-btn' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-project-board-btn-link' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-designer-name-title' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-client-notes-name' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-title' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-client-notes-title' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-terms-title' );
  register_setting( 'das-gq-settings', 'das-gq-theme-options-settings-custom-css-first' );
  register_setting( 'das-gq-settings', 'das-gq-theme-options-settings-custom-css' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-custom-css' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-icon-color' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-main-header-text-color' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-main-header-background-color' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-text-link-color' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-background-color-boxes' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-background-color-even-comment-boxes' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-background-main-btns-hover' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-text-main-btns-hover' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-border-color' );
  register_setting( 'das-gq-settings', 'das-gq-theme-project-text-color' );
  register_setting( 'das-gq-settings', 'das-gq-theme-terms-popup-global' );
  register_setting( 'das-gq-settings', 'das-gq-theme-settings-project-board-btn-custom-name' );
  register_setting( 'das-gq-settings', 'das-gq-theme-client-changes-global' );
  register_setting( 'das-gq-settings', 'das-gq-theme-agree-to-terms-checkbox' );
  register_setting( 'das-gq-settings', 'das-gq-theme-hide-media-button-checkbox' );
}

// Admin scripts for only the pages we need them on
function das_gq_theme_settings_admin_scripts(){
	wp_enqueue_script('jquery');
	wp_register_style('my-custom-css', plugins_url( 'design-approval-system/templates/gq-template/admin/css/admin-settings.css'));
	wp_enqueue_style( 'my-custom-css' );
	wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
	wp_enqueue_style( 'og-admin-css' );
}
if (isset($_GET['page']) && $_GET['page'] == 'das-gq-theme-settings-page') {
  add_action('admin_enqueue_scripts', 'das_gq_theme_settings_admin_scripts');
}
?>