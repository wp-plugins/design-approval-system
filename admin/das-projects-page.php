<?php 
namespace Design_Approval_System;

class Project_Board_Admin {
	/*
	 * Fired during plugins_loaded (very very early),
	 * so don't miss-use this, only actions and filters,
	 * current ones speak for themselves.
	 */
	function __construct() {
		
		add_action('admin_menu', array( $this,'add_options_submenu_page'));

		
		// Makes sure the plugin is defined before trying to use it
		if ( ! function_exists( 'is_plugin_active' ) )
			require_once( ABSPATH . '/wp-admin/includes/plugin.php' );

		// we want to run the scripts above in the admin area, that is why we have the next add_action.
		if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-projects-page' && is_admin()) {
			add_action('admin_enqueue_scripts', array($this,'project_board_scripts'));
		}
		else{
			add_action('wp_enqueue_scripts', array($this,'project_board_scripts'));
		}
	}
	
	function add_options_submenu_page(){
		add_submenu_page( 'edit.php?post_type=designapprovalsystem', 'Project Board', '', 'read', 'design-approval-system-projects-page', array( $this, 'projects_page') );
	}

	
	// Project Board Scripts
	function project_board_scripts() {
		wp_enqueue_script('jquery');
		wp_register_style('das_project_board_style', plugins_url('admin/css/project-board.css', dirname(__FILE__)));
		wp_enqueue_style('das_project_board_style');
		wp_register_script('das_project_board_script', WP_PLUGIN_URL.'/design-approval-system/admin/js/project-board.js', array('jquery'));
		wp_enqueue_script('das_project_board_script');
	}

	function plugin_options_page() {
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_settings_key;
?>
		<div class="wrap">
			<?php $this->plugin_options_tabs(); ?>
			<form method="post" action="options.php">
				<?php wp_nonce_field( 'update-options' ); ?>
				<?php settings_fields( $tab ); ?>
				<?php do_settings_sections( $tab ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	function plugin_options_tabs() {
		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->general_settings_key;
		$output ='';
		$output.= screen_icon();
		$output.= '<h2 class="nav-tab-wrapper">';
		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			$output.= '<a class="nav-tab ' . $active . '" href="?page=' . $this->plugin_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
		}
		$output.= '</h2>';
		echo $output;
	}
	function projects_page() {
		global $current_user; get_currentuserinfo();

		$user_id = $current_user->ID;
		$user_blogs = get_blogs_of_user( $user_id );

		foreach ($user_blogs as $user_blog) {
			if ($user_blog->path == '/') {
				# do nothing
			}
			else {
				$user_blog_id = $user_blog->userblog_id;
			}
		}
		$output ='';
		if (current_user_can_for_blog($user_blog_id, 'administrator') || current_user_can_for_blog($user_blog_id, 'das_designer')) { 
			$output .= '<div class="das-project-admin-wrap-main">';
			$output .= '<a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/design-approval-system/" target="_blank">'.__('Get Extensions Here!', 'design-approval-system') .'</a>';
			$output .= '<h2 class="project-board-header">'.__('Project Board', 'design-approval-system') .'</h2>';
			$output .= '<div class="use-of-plugin">'.__('Below are your Clients and their Projects. Learn how to use and setup the ', 'design-approval-system').'<a href="http://www.slickremix.com/docs/how-to-setup-the-project-board/" target="_blank">'. __('Project Board', 'design-approval-system').'</a> '.__('here').'.</div>';
			// echo our short code for the Public Board
			$output .= do_shortcode('[DASPublicBoard]');
			$output .= '</div><!--das-project-admin-wrap-main-->';
		 }
		 else {
			 $output .= '<div class="das-project-admin-wrap-main">';
			 $output .= '<h2 class="project-board-header">'.__('Project Board', 'design-approval-system').'</h2>';
			 // echo our short code for the Private Board
			 $output .= do_shortcode('[DASPrivateBoard]');
			 $output .= '<br class="clear"/></div><!--das-project-admin-wrap-main-->';	
		 } // end if admin or das user can
		 
		 echo $output;
	} // das_projects_page
		
};
new Project_Board_Admin();

?>