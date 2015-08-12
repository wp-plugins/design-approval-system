<?php namespace Design_Approval_System;
class Design_Approval_System_Core {
	function __construct() {
		//Register DAS Taxonomies on plugin activation.
		register_activation_hook( __FILE__, array($this, 'design_approval_system__custom_tax_activate'));
		add_action( 'init', array($this, 'register_taxonomy_das_categories'));
		//Register DAS Custom Post Type on plugin activation.
		add_filter( 'cpt_post_types', array($this, 'das_cpt_post_type'));
		register_activation_hook( __FILE__, array($this, 'design_approval_system_activate'));
		add_action( 'init', array($this, 'das_custom_post_type_init'));
		//Admin CSS
		add_action('admin_enqueue_scripts', array($this, 'das_admin_css'));
		//Admin JS (Actually loads in footer)
		add_action('admin_head', array($this, 'das_admin_js'));
		//Register Settings Page Settings
		add_action( 'admin_init', array($this, 'das_settings_page_register_settings'));
		//Settings Page Scripts
		if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-settings-page') {
			add_action('admin_enqueue_scripts', array($this, 'das_main_settings_admin_scripts'));
		}
		//Help Page Scripts
		if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-help-page') {
			add_action('admin_enqueue_scripts', array($this, 'das_help_settings_admin_scripts'));
		}
		//DAS Dependencies
		add_action( 'admin_notices', array($this, 'das_dependencies'));
		//Ajax (next three Actions are all Relative to each other.)
		add_action( 'init', array($this, 'das_check_ajax'));
		// This is for the APPROVAL PROCESS submission
		add_action( 'wp_ajax_my_user_dasChecker', array($this, 'my_user_dasChecker'));
		// This is for the DESIGN REQUEST/CHANGES submission
		add_action( 'wp_ajax_my_client_changes_dasChecker',  array($this, 'my_client_changes_dasChecker'));
		//Override default Wordpress Post Template
		add_filter('single_template', array($this, 'DAS_post_template'), 999);
		//Front End Redirect
		add_action('get_header', array($this, 'das_admin_redirect'));
		//Remove DAS Categories from WooCommerce (needs to be put into WooFor DAS class
		add_action( 'pre_get_posts', array($this, 'das_woo_pre_get_posts_query'));
		//Start Walkthrough
		add_action( 'admin_enqueue_scripts', array($this,'myDasHelpPointers'));

		$old_plugs = $this->old_extenstions_check();
		//If there are old plugins Display notice!
		if($old_plugs == true){
			add_action('admin_notices', array($this,'das_old_plugin_admin_notice'));
			add_action( 'admin_init', array($this, 'das_old_plugins_ignore'));
		}
		add_action( 'admin_init', array($this, 'das_old_extenstions_block'));
	}
	//**************************************************
	// Block for Old Extenstions
	//**************************************************
	function das_old_extenstions_block() {
		global $current_user ;
		$user_id = $current_user->ID;
		$list_old_plugins = array(
			'das-gq-theme/das-gq-theme.php',
			'das-roles-extension/das-roles-extension.php',
			'das-changes-extension/das-changes-extension.php',
			'das-design-login/das-design-login.php',
			'das-public-private-project-board/das-public-private-project-board.php',
			'das-clean-theme/das-clean-theme.php',
			'woocommerce-for-das/woocommerce-for-das.php'
		);
		foreach($list_old_plugins as $single_plugin){
			if(is_plugin_active($single_plugin)){
				//Don't Let Old Plugins Activate
				deactivate_plugins($single_plugin);
				//Clear The hide message so user knows they can't activate old plugins
				delete_user_meta( $user_id, 'das_old_plugins_ignore');
			}
		}
	}
	//**************************************************
	// Check for Old Extenstions
	//**************************************************
	function old_extenstions_check() {
		// Check if get_plugins() function exists. This is required on the front end of the
		// site, since it is in a file that is normally only loaded in the admin.
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$all_plugins = get_plugins();
		$list_old_plugins = array(
			'das-gq-theme/das-gq-theme.php',
			'das-roles-extension/das-roles-extension.php',
			'das-changes-extension/das-changes-extension.php',
			'das-design-login/das-design-login.php',
			'das-public-private-project-board/das-public-private-project-board.php',
			'das-clean-theme/das-clean-theme.php',
			'woocommerce-for-das/woocommerce-for-das.php'
		);

		$any_old_plugins = false;
		if($all_plugins){
			foreach($all_plugins as $single_plugin => $single_plugin_info){
				//Are there old plugins Install in WordPress
				$any_old_plugins = in_array($single_plugin, $list_old_plugins);
				if($any_old_plugins){
					return true;
				}
			}
		}
	}
	//**************************************************
	// Old Extenstions List
	//**************************************************
	function das_old_plugin_admin_notice() {
		global $current_user ;
		//$is_an_admin = in_array('administrator', $current_user->roles);
		$user_id = $current_user->ID;
		/* Check that the user hasn't already clicked to ignore the message */
		if (!get_user_meta($user_id, 'das_old_plugins_ignore')) {
			echo '<div class="das-update-message das_old_plugins_message">';
			printf(__('Please uninstall ALL old DAS Plugins/Extenstions because they will no longer work with this version of DAS. All old features are now included in <a href="http://www.slickremix.com/downloads/das-premium/" target="_blank">DAS Premium</a>. Since you previously purchased one of the old extensions we want to give you 1 Year of DAS Premium for FREE! Please checkout with <a href="http://www.slickremix.com/downloads/das-premium/" target="_blank">DAS Premium</a> using COUPON CODE: <strong>dasmanager100</strong> | <a href="%1$s">HIDE NOTICE</a>'), '?das_old_plugins_ignore=0');
			echo "</div>";
		}
	}
	//**************************************************
	// Ignore Old Extenstions List
	//**************************************************
	function das_old_plugins_ignore() {
		global $current_user;
		$is_an_admin = in_array('administrator', $current_user->roles);
		$user_id = $current_user->ID;
		/* If user clicks to ignore the notice, add that to their user meta */
		if ( isset($_GET['das_old_plugins_ignore']) && '0' == $_GET['das_old_plugins_ignore'] && $is_an_admin == true) {
			add_user_meta($user_id, 'das_old_plugins_ignore', 'true', true);
			//delete_user_meta( $user_id, 'das_old_plugins_ignore');
		}
	}
	//**************************************************
	// DAS Admin CSS
	//**************************************************
	function das_admin_css() {
		global $post_type;
		wp_register_style('DAS-ADMIN-CSS', plugins_url( 'design-approval-system/admin/css/admin.css'));
		wp_enqueue_style( 'DAS-ADMIN-CSS' );
		if ( 'designapprovalsystem' == $post_type) {
			// custom scripts for the custom post type designapprovalsystem edit post page in the admin area.
			wp_register_style('DAS-post-edit', plugins_url( 'design-approval-system/admin/css/post-edit.css'));
			wp_enqueue_style( 'DAS-post-edit' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_register_script( 'das-admin', plugins_url( 'admin/js/admin.js',  dirname(__FILE__) ) );
			wp_enqueue_script('das-admin');
		}
	}
	//**************************************************
	// DAS Admin JS
	//**************************************************
	function das_admin_js() {
		global $post_type;
		if ( 'designapprovalsystem' == $post_type ) { ?>
		<script>
			  jQuery('#custom_post_template option[value="default"]').removeAttr('selected');
			  jQuery('#custom_post_template option[value="default"]').remove();
			  jQuery(document).ready(function() {
			   if (jQuery("#custom_post_template").selectedIndex <= 0) {
						jQuery('#custom_post_template option[value="das-slick-template-v4.php"]').attr('selected, selected');
				}
					   // This selector is called every time a select box is changed
						jQuery("select#custom_client_name").change(function(){
							// varible to hold string
							var str = "";
							var finalString = "";
							jQuery("select#custom_client_name option:selected").each(function(){
								// when the select box is changed, we add the value text to the varible
								str += jQuery(this).text() + " ";
							});
							 var matches = str.match(/\[(.*?)\]/);
							  if (matches) {
								  var submatch = matches[1];
							  }
							// then display it in the following class
							jQuery("#custom_clients_email").val(submatch);
						})
						// This selector is called every time a select box is changed
						jQuery("select#custom_designers_name").change(function(){
							// varible to hold string
							var str = "";
							var finalString = "";
							jQuery("select#custom_designers_name option:selected").each(function(){
								// when the select box is changed, we add the value text to the varible
								str += jQuery(this).text() + " ";
							});
							 var matches = str.match(/\[(.*?)\]/);
							  if (matches) {
								  var submatch = matches[1];
							  }
							// then display it in the following class
							jQuery("#custom_designers_email").val(submatch);
							})
			  });
		</script>
		<?php
		}
	}
	//**************************************************
	// DAS Help Page Scripts
	//**************************************************
	function das_help_settings_admin_scripts() {
		wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
		wp_enqueue_style( 'og-admin-css' );
	}
	//**************************************************
	// DAS Admin Redirect
	//**************************************************
	function das_admin_redirect() {
		$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		// Redirect all users that try to access the site url on front end to view active projects coming from the content loop. (*ie. http://www.slickremix.com/testblog/?post_type=designapprovalsystem&page=design-approval-system-projects-page). So anything containing the word ?post_type=designapprovalsystem in the URL will get redirected to the home page
		if (false !== strpos($url, '?post_type=designapprovalsystem')) {
			wp_redirect(home_url());
			exit;
		}
	}
	//**************************************************
	// Create DAS Taxonmies
	//**************************************************
	function register_taxonomy_das_categories() {
		$das_labels = array(
			'name' => _x( __('Project Names', 'design-approval-system'), 'das_categories' ),
			'singular_name' => _x( __('Project Name', 'design-approval-system'), 'das_categories' ),
			'search_items' => _x( __('Search Project Names', 'design-approval-system'), 'das_categories' ),
			//'popular_items' => _x( 'Popular Project Names', 'das_categories' ),
			'all_items' => _x( __('All Project Names', 'design-approval-system'), 'das_categories' ),
			'parent_item' => _x( __('Parent Project Name', 'design-approval-system'), 'das_categories' ),
			'parent_item_colon' => _x( __('Parent Project Name', 'design-approval-system'), 'das_categories' ),
			'edit_item' => _x( __('Edit Project Name', 'design-approval-system'), 'das_categories' ),
			'update_item' => _x( __('Update Project Name', 'design-approval-system'), 'das_categories' ),
			'add_new_item' => _x( __('Add New Project Name', 'design-approval-system'), 'das_categories' ),
			'new_item_name' => _x( __('New Project Name', 'design-approval-system'), 'das_categories' ),
			'separate_items_with_commas' => _x( __('Separate Project Names with commas', 'design-approval-system'), 'das_categories' ),
			'add_or_remove_items' => _x( __('Add or remove Project Names', 'design-approval-system'), 'das_categories' ),
			'choose_from_most_used' => _x( __('Choose from the most used Project Names', 'design-approval-system'), 'das_categories' ),
			'menu_name' => _x( __('Project Names', 'design-approval-system'), 'das_categories' ),
		);
		$das_labels_args = array(
			'labels' => $das_labels,
			'public' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			//'show_tagcloud' => true,
			'hierarchical' => true,
			'update_count_callback' => '_update_post_term_count',
			'rewrite' => true,
			'query_var' => true
		);
		register_taxonomy('das_categories', array('Design Approval System'), $das_labels_args);
	}
	//**************************************************
	// DAS Activation
	//**************************************************
	function design_approval_system__custom_tax_activate() {
		//Register DAS Taxonomies on Activation
		$this->register_taxonomy_das_categories();
		flush_rewrite_rules();
	}
	//**************************************************
	// Add DAS Custom Post Type
	//**************************************************
	function das_cpt_post_type($post_types) {
		$post_types[] = __('Design Approval System', 'design-approval-system');
		return $post_types;
	}
	//**************************************************
	// Create DAS Custom Post Type
	//**************************************************
	function das_custom_post_type_init() {
		$das_cpt_args = array(
			'label' => __('Design Approval System', 'design-approval-system'),
			'labels' => array (
				'menu_name' => __('Projects', 'design-approval-system'),
				'name' => __('All Your Designs', 'design-approval-system'),
				'singular_name' => __('Project', 'design-approval-system'),
			),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'has_archive' => false,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'designs'),
			'query_var' => 'Design Approval System',
			'menu_icon' => '',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'excerpt',
				'trackbacks',
				'custom-fields',
				'comments',
				'revisions',
				'thumbnail',
				'author',
			),
			// Set the available taxonomies here
			'taxonomies' => array('das_categories', 'post_tag')
		);
		register_post_type( 'Design Approval System', $das_cpt_args);
	}
	//**************************************************
	// Register DAS Custom Post Type on Activation
	//**************************************************
	function design_approval_system_activate() {
		$this->das_custom_post_type_init();
		flush_rewrite_rules();
	}
	//**************************************************
	// Register Settings (General Function)
	//**************************************************
	function register_settings($settings_name , $settings) {
		foreach ($settings as $key => $setting) {
			register_setting( $settings_name, $setting);
		}
	}
	//**************************************************
	// Register Settings Page Scripts and Styles
	//**************************************************
	function das_main_settings_admin_scripts() {
		wp_enqueue_script('jquery');
		// This is all we need to call our media manager scripts and styles for the logo upload button
		wp_enqueue_media('media');
		wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
		wp_enqueue_style( 'og-admin-css' );
	}
	//**************************************************
	// Register Setttings Page Settings
	//**************************************************
	function das_settings_page_register_settings() {
		$settings_page_options = array(
			//Main Settings
			'das_default_theme_logo_image',
			'das-settings-company-name',
			'das-settings-company-email',
			//SMTP Settings
			'das-settings-smtp',
			'das-smtp-server',
			'das-smtp-port',
			'das-smtp-checkbox-authenticate',
			'das-smtp-authenticate-username',
			'das-smtp-authenticate-password',
			//Email Settings
			'das-settings-email-for-designers-message-to-clients',
			'das-settings-approved-dig-sig-message-to-designer',
			'das-settings-approved-dig-sig-message-to-clients',
			'das-settings-approved-dig-sig-thank-you',
			'das-settings-approve-login-overide',
			'das-settings-das-ssl-or-tls-option',
			//Branding Settings
			'das-settings-plural-pb-fep-name',
			'das-settings-singular-pb-fep-name',
			'das-settings-pb-fep-name',
			//Client Changes Settings
			'das-settings-design-requests-message-to-designer',
			'das-settings-design-requests-message-to-clients',
			'das-settings-design-requests-thank-you',
			'das-settings-add-design-requests-message-to-designer',
			'das-settings-add-design-requests-message-to-clients',
			'das-settings-changes-login-overide',
			//Roles Settings
			'das-settings-designer-role',
			'das-settings-client-role',
			//Premium Settings
			'das-settings-register-new-das-client',
		);
		$this->register_settings('design-approval-system-settings', $settings_page_options);
	}
	//*************************************************************
	// Required Settings Fields
	//*************************************************************
	function das_dependencies() {
		$output = '';
		$das_settings_company_name = get_option('das-settings-company-name');
		$das_settings_company_email = get_option('das-settings-company-email');
		$output .= empty($das_settings_company_name) || empty($das_settings_company_email) ? '<div class="error"><p>' . __( 'Warning: The <strong>Design Approval System</strong> plugin needs you to fill the in REQUIRED fields on <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page"><strong>settings page</strong></a>.', 'design-approval-system' ) . '</p></div>' : '';
		echo $output;
	}
	//*************************************************************
	// Override default Wordpress Post Template with DAS Template
	//*************************************************************
	function DAS_post_template($das_post_template_load) {
		global $post;
		if ($post->post_type == 'designapprovalsystem') {
			//Get Selected Template for Design Post Page.
			$das_post_template = get_post_meta($post->ID, 'custom_das_template_options', true);
			//Theme Locations for Template file in root of theme or "DAS" folder.
			$overridden_template_in_folder = locate_template('das/'.$das_post_template);
			$overridden_template = locate_template($das_post_template);
			//Check if Theme has a custom template file in DAS folder
			if ($overridden_template_in_folder != '') {
				$das_post_template_load = $overridden_template_in_folder;
				//echo "DAS Template in folder";
			}
			//Check if Theme has a custom template file.
			elseif ($overridden_template != '') {
				// locate_template() returns path to file
				// if either the child theme or the parent theme have overridden the template
				$das_post_template_load = $overridden_template;
				// echo "DAS Template in root";
			}
			//Theme has no custom file so use DEFAULT custom theme file!
			else {
				//GQ Theme Template
				if ($das_post_template == 'das-gq-theme-main.php' || $das_post_template !== 'das-gq-theme-main.php') {
					$das_post_template_load = WP_CONTENT_DIR.'/plugins/design-approval-system/templates/post-page-template.php';
				}
			}
		}
		return $das_post_template_load;
	}
	//**************************************************
	// DAS Ajax
	//**************************************************
	function das_check_ajax() {
		// SRL added 6-6-13 to allow us to record the approved information directly to db
		wp_register_script( "dasChecker_script", DAS_PLUGIN_PATH.'/design-approval-system/templates/slickremix/js/my_dasChecker_script.js', array('jquery') );
		wp_localize_script( 'dasChecker_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'dasChecker_script' );
	}
	//**************************************************
	// DAS Approval Submission Ajax
	//**************************************************
	function my_user_dasChecker() {
		// this function is being called from my_dasChecker_script.js... it calls the ajax in this case.
		$post_id = $_POST['post_id'];
		$post_meta = $_POST['post_meta'];
		// this meta says yes approved and makes it possible for the stars to appear on project board. I have hard coded the answer Yes so we don't need to get meta values here.
		update_post_meta( $post_id, 'custom_client_approved', 'Yes' );
		// this meta is the clients actual signature.
		update_post_meta( $post_id, 'custom_client_approved_signature', $post_meta );
		echo 'Meta Updated';
		die();
	}
	//**************************************************
	// DAS DESIGN REQUEST/CHANGES Submission Ajax
	//**************************************************
	function my_client_changes_dasChecker() {
		// this function is being called from my_dasChecker_script.js... it calls the ajax in this case.
		$post_id = $_POST['post_id'];
		$post_meta = $_POST['post_meta'];
		// this meta is for the clients notes
		update_post_meta( $post_id, 'custom_client_notes', $post_meta );
		echo get_post_meta( $post_id, 'custom_client_notes', $post_meta );
		die();
	}
	//**************************************************
	// Check User level for Project Board Edit Button
	//**************************************************
	function is_admin_logged_in() {
		global $user_ID;
		if ( $user_ID  && current_user_can('level_10') ) :
			return true;
		else :
			return false;
		endif;
	}
	//**************************************************
	// Restore Post (Project Board Button)
	//**************************************************
	function wp_das_restore_post_link() {
		// http://wordpress.stackexchange.com/questions/95348/add-frontend-restore-link
		global $post;
		$post_id = $_GET['ids'];
		// no post?
		if ( !$post_id || !is_numeric( $post_id ) ) {
			return false;
		}
		$_wpnonce = wp_create_nonce( 'untrash-post_' . $post_id );
		$url = admin_url( 'post.php?post=' . $post_id . '&action=untrash&_wpnonce=' . $_wpnonce );
		$url = ' <a href="'.$url.'">Restore from Trash</a>';
		return $url;
	}
	//**************************************************
	// Delete Post (Project Board Button)
	//**************************************************
	function wp_das_delete_post_link($text = 'Trash', $confirm_required=true) {
		global $post;
		$delLink = get_delete_post_link( $post->ID);
		return $confirm_required
			? '<a href="' . $delLink . '" onclick="javascript:if(!confirm(\''. __('Are you sure you want to remove this post?', 'design-approval-system').'\')) return false;" />'.$text."</a>"
			: '<a href="' . $delLink . '">'.$text."</a>";
	}
	//**************************************************
	// Remove DAS Categories from Woo (Woo For DAS)
	//**************************************************
	function das_woo_pre_get_posts_query($q) {
		if (!$q->is_main_query()) return;
		if (!$q->is_post_type_archive()) return;
		if (!is_admin()) {
			$q->set( 'tax_query', array(array(
						'taxonomy' => 'product_cat',
						'field' => 'slug',
						'terms' => array( 'DAS Designs' ), // Don't display products in the membership category on the shop page . For multiple category , separate it with comma.
						'operator' => 'NOT IN'
					)));
		}
		remove_action( 'pre_get_posts', array($this, 'das_woo_pre_get_posts_query'));
	}
	//**************************************************
	// Call to Walkthrough
	//**************************************************
	function myDasHelpPointers() {
		$pointers = array(
			array(
				'id'       => 'xyz123',
				'screen'   => 'settings_page_options-general',
				'target'   => '#screen-meta-links',
				'title'    => 'Show plugin help',
				'content'  => 'Enable to see all the help texts or disable to view it tight.',
				'position' => array(
					'edge'  => 'top', // top, bottom, left, right
					'align' => 'left' // top, bottom, left, right, middle
				)
			),
			array(
				'id'       => 'xyz124',
				'screen'   => 'settings_page_options-general',
				'target'   => '#screen-meta-links',
				'title'    => 'Show plugin help',
				'content'  => 'Enable to see all the help texts or disable to view it tight.',
				'position' => array(
					'edge'  => 'right',
					'align' => 'right'
				)
			),
		);
		new DAS_Admin_Pointer( $pointers );
	}
}//END CLASS Design_Approval_System_Core
new Design_Approval_System_Core();