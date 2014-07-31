<?php
// This is our function we will fire when the restart tour button is clicked. You will need a new one for each Plugin tour you add.
/**************************************************************************************************************************************/
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
add_action( 'wp_ajax_dasplugin_wp_pointers_remove', 'dasplugin_wp_pointers_remove' );


// Function to Fire the Activation/Deactivation Notes. This is only active when the pointer has not been closed.
function my_dasplugin_activate() {
  add_option( 'Activated_Plugin', 'Design-Approval-Sytem' );
}
register_activation_hook( __FILE__, 'my_dasplugin_activate' );

function load_dasplugin() {
    if ( is_admin()) {
        delete_option( 'Activated_Plugin', 'Design-Approval-Sytem' );
        /* do stuff once right after activation */
        include_once dirname( __FILE__ ) . '/welcome-notes.php';
    }
}
add_action( 'admin_init', 'load_dasplugin' );
// end activation notes
/**************************************************************************************************************************************/



/************************************************
 	Function file for Design System plugin
************************************************/
if ( ! function_exists( 'is_plugin_active' ) )
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    // Makes sure the plugin is defined before trying to use it
	
// Project Board Scripts
function  das_project_board() {
	wp_register_style( 'das_project_board_style', plugins_url( 'admin/css/project-board.css', dirname(__FILE__) ) );  
	wp_enqueue_style('das_project_board_style');
	
	wp_register_script( "das_project_board_script", WP_PLUGIN_URL.'/design-approval-system/admin/js/project-board.js', array('jquery') );
	
	wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'das_project_board_script' );
}
add_action('wp_enqueue_scripts', 'das_project_board');

// we want to run the scripts above in the admin area, that is why we have the next add_action.
if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-projects-page') {
	add_action('admin_init', 'das_project_board');
}

// SRL added to allow only admin to view the edit button on project board, else it will show up as a view button with link. Function call is on the das-project-board-page in admin folder. 3-16-13
function is_admin_logged_in(){
global $user_ID; 

	if( $user_ID  && current_user_can('level_10') ) :
	return true;
	else : 
	return false;
	endif;
}
// Redirect all users that try to access the site url on front end to view active projects coming from the content loop. (*ie. http://www.slickremix.com/testblog/?post_type=designapprovalsystem&page=design-approval-system-projects-page). So anything containing the word ?post_type=designapprovalsystem in the URL will get redirected to the home page
function das_admin_redirect() {
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		if (false !== strpos($url,'?post_type=designapprovalsystem')){
			wp_redirect(home_url()); 
			exit;
		}
}
add_action('get_header', 'das_admin_redirect');

function my_columns_filter_das($columns) {
 // unset($columns['author']);
 // unset($columns['categories']);
    unset($columns['tags']);
    unset($columns['custom-fields']);
    //unset($columns['comments']);
    return $columns;
}
function my_das_column_init() {
	add_filter( 'manage_edit-designapprovalsystem_columns', 'my_columns_filter_das');
}
add_action( 'admin_init' , 'my_das_column_init' );

// SRL added 6-6-13 to allow us to record the approved information directly to db
function my_script_enqueuer() {
   wp_register_script( "my_dasChecker_script", WP_PLUGIN_URL.'/design-approval-system/templates/slickremix/js/my_dasChecker_script.js', array('jquery') );
   wp_localize_script( 'my_dasChecker_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'my_dasChecker_script' );
	// Load validate
	// wp_enqueue_script('validate','http://ajax.microsoft.com/ajax/jQuery.Validate/1.6/jQuery.Validate.min.js', array('jquery'), true);

}
add_action( 'init', 'my_script_enqueuer' );

// This is for the APPROVAL PROCESS submission
add_action( 'wp_ajax_my_user_dasChecker', 'my_user_dasChecker' );
// this function is being called from my_dasChecker_script.js... it calls the ajax in this case. 
function my_user_dasChecker() {
    $post_id = $_POST['post_id'];
    $post_meta = $_POST['post_meta']; 
	// this meta says yes approved and makes it possible for the stars to appear on project board. I have hard coded the answer Yes so we don't need to get meta values here.
    update_post_meta( $post_id, 'custom_client_approved', 'Yes' );
	// this meta is the clients actual signature.
    update_post_meta( $post_id, 'custom_client_approved_signature', $post_meta );
    echo 'Meta Updated';
    die();
} // end of my_ajax_callback()


// This is for the DESIGN REQUEST/CHANGES submission
add_action( 'wp_ajax_my_client_changes_dasChecker', 'my_client_changes_dasChecker' );
// this function is being called from my_dasChecker_script.js... it calls the ajax in this case. 
function my_client_changes_dasChecker() {
    $post_id = $_POST['post_id'];
    $post_meta = $_POST['post_meta']; 
	// this meta is for the clients notes
    update_post_meta( $post_id, 'custom_client_notes', $post_meta );
    echo get_post_meta( $post_id, 'custom_client_notes', $post_meta );
    die();
} // end of my_ajax_callback()



//Create Taxenomy for DAS
function register_taxonomy_das_categories() {

    $labels2 = array( 
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

    $args1 = array( 
        'labels' => $labels2,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        //'show_tagcloud' => true,
        'hierarchical' => true,
        'update_count_callback' => '_update_post_term_count',
        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'das_categories', array('Design Approval System'), $args1 );

}
function design_approval_system__custom_tax_activate() {
	register_taxonomy_das_categories();
	// register taxonomies/post types here
	 flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'design_approval_system__custom_tax_activate' );
add_action( 'init', 'register_taxonomy_das_categories' );



function my_cpt_post_types( $post_types ) {
    $post_types[] = __('Design Approval System', 'design-approval-system');
    return $post_types;
}
//Create DAS Custom Post type
add_filter( 'cpt_post_types', 'my_cpt_post_types' );


function das_custom_post_type_init() {
    $args = array(
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
		 
	    register_post_type( 'Design Approval System', $args );
		
 }
function design_approval_system_activate() {
	das_custom_post_type_init();
	// register taxonomies/post types here
	 flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'design_approval_system_activate' );
add_action( 'init', 'das_custom_post_type_init' );









add_filter( 'attribute_escape', 'rename_second_das_submenu_name', 10, 2 );

// THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
function das_admin_css() {
	wp_register_style('DAS-ADMIN-CSS', plugins_url( 'design-approval-system/admin/css/admin.css'));
	wp_enqueue_style( 'DAS-ADMIN-CSS' );
	
global $post_type;
       if( 'designapprovalsystem' == $post_type ) {
	// custom scripts for the custom post type designapprovalsystem edit post page in the admin area.	   
	wp_register_style('DAS-post-edit', plugins_url( 'design-approval-system/admin/css/post-edit.css'));
	wp_enqueue_style( 'DAS-post-edit' );  	   
	wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-tabs' ); 
	wp_register_script( 'das-admin', plugins_url( 'admin/js/admin.js',  dirname(__FILE__) ) );
	wp_enqueue_script('das-admin'); 
	}
  } //end das_admin_css
add_action('admin_enqueue_scripts', 'das_admin_css');


function das_admin_js() {
		
	global $post_type;
	
if( 'designapprovalsystem' == $post_type ) { ?>
<script>
	  jQuery('#custom_post_template option[value="default"]').removeAttr('selected');
	  jQuery('#custom_post_template option[value="default"]').remove();
	  
	  jQuery(document).ready(function() {
	   if (jQuery("#custom_post_template").selectedIndex <= 0) {
				jQuery('#custom_post_template option[value="das-slick-template-v4.php"]').attr('selected, selected');
		}
		<?php if(is_plugin_active('das-roles-extension/das-roles-extension.php')) { ?>
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
	<?php } ?>
		
	  });
</script>
<?php
	}
} // end das_admin_js
// It says admin head but really its putting this script in the footer, which is where we need it.  
add_action('admin_head', 'das_admin_js');
/**
 * Renames the first occurence of 'See All Academias' to 'Academias'
 * and deactivates itself then.
 * @param $safe_text
 * @param $text
 */
function rename_second_das_submenu_name( $safe_text, $text )
{
    if ( 'Projects' !== $text )
    {
        return $safe_text;
    }

    // We are on the main menu item now. The filter is not needed anymore.
    remove_filter( 'attribute_escape', 'rename_second_das_submenu_name' );

    return 'DAS';
}

//Adds Project Board page to DAS sub menu
add_action('admin_menu', 'register_das_projects_submenu_page');

function register_das_projects_submenu_page() {
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', 'Project Board', '', 'read', 'design-approval-system-projects-page', 'das_projects_page' );

}
//Enque admin-setttings.css only for this page
function das_projects_settings_admin_scripts(){
	wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
	wp_enqueue_style( 'og-admin-css' );
}
if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-projects-page') {
  add_action('admin_enqueue_scripts', 'das_projects_settings_admin_scripts');
}

//Adds Video page to DAS sub menu
// add_action('admin_menu', 'register_das_video_submenu_page');

// function register_das_video_submenu_page() {
//	add_submenu_page( 'edit.php?post_type=designapprovalsystem', __('Design Approval System Videos', 'design-approval-system'), __('Tutorial Videos', 'design-approval-system'), 'manage_options', 'design-approval-system-video-page', 'das_video_page' );
// }
//Enque admin-setttings.css only for this page
// function das_video_settings_admin_scripts(){
//	wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
//	wp_enqueue_style( 'og-admin-css' );
// }
// if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-video-page') {
//  add_action('admin_enqueue_scripts', 'das_video_settings_admin_scripts');
// }

//Adds News & Updates Page page to DAS sub menu
// add_action('admin_menu', 'register_das_news_updates_submenu_page');
// function register_das_news_updates_submenu_page() {
// 	add_submenu_page( 'edit.php?post_type=designapprovalsystem', __('Design Approval System News & Updates', 'design-approval-system'), __('DAS News', 'design-approval-system'), 'manage_options', 'design-approval-system-news-updates-page', // 'das_news_updates_page' );
// }

//Enque admin-setttings.css only for this page
// function das_news_settings_admin_scripts(){
//	wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
//	wp_enqueue_style( 'og-admin-css' );
//	wp_register_style('news-admin-css', plugins_url( 'design-approval-system/admin/css/news-updates-styles.css'));
//	wp_enqueue_style( 'news-admin-css' );
// }
// if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-news-updates-page') {
//  add_action('admin_enqueue_scripts', 'das_news_settings_admin_scripts');
// }

//Adds Help page to DAS sub menu
add_action('admin_menu', 'register_das_help_submenu_page');
function register_das_help_submenu_page() {
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', __('Design Approval System Help', 'design-approval-system'), __('Help', 'design-approval-system'), 'manage_options', 'design-approval-system-help-page', 'das_help_page' );
}
//Enque admin-setttings.css only for this page
function das_help_settings_admin_scripts(){
	wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
	wp_enqueue_style( 'og-admin-css' );
}
if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-help-page') {
  add_action('admin_enqueue_scripts', 'das_help_settings_admin_scripts');
}

add_action('admin_menu','remove_tags_menu');
function remove_tags_menu() {
    // remove_submenu_page was introduced in 3.1
    remove_submenu_page( 'edit.php?post_type=designapprovalsystem', 'edit-tags.php?taxonomy=post_tag&amp;post_type=designapprovalsystem' );
}

//Adds setting page to DAS sub menu
add_action('admin_menu', 'register_das_settings_submenu_page');

function register_das_settings_submenu_page() {
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', __('Design Approval System Settings', 'design-approval-system'), __('Settings', 'design-approval-system'), 'manage_options', 'design-approval-system-settings-page', 'das_settings_page' ); 
}
//Enque admin-setttings.css only for this page
function das_main_settings_admin_scripts(){
	wp_enqueue_script('jquery');
	// This is all we need to call our media manager scripts and styles for the logo upload button
	wp_enqueue_media('media');
	wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
	wp_enqueue_style( 'og-admin-css' );
}
if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-settings-page') {
  add_action('admin_enqueue_scripts', 'das_main_settings_admin_scripts');
}

// Re-Construct Submenu Item
function edit_admin_menus() {
	global $submenu;
		$submenu['edit.php?post_type=designapprovalsystem'][10][0] = __('Add New Project', 'design-approval-system');
		
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

		//DAS News
	//	$submenu['edit.php?post_type=designapprovalsystem'][20][0] = __('News', 'design-approval-system');
	//	$submenu['edit.php?post_type=designapprovalsystem'][20][1] = 'manage_options';
	//	$submenu['edit.php?post_type=designapprovalsystem'][20][2] = 'design-approval-system-news-updates-page';
	//	$submenu['edit.php?post_type=designapprovalsystem'][20][3] = __('Design Approval System News & Updates', 'design-approval-system');
		
		//Walk Through
	//	$submenu['edit.php?post_type=designapprovalsystem'][21][0] = __('Walk-Through', 'design-approval-system');
	//	$submenu['edit.php?post_type=designapprovalsystem'][21][1] = 'manage_options';
	//	$submenu['edit.php?post_type=designapprovalsystem'][21][2] = 'edit.php?post_type=designapprovalsystem&page=design-approval-system-projects-page&step=1';
		
		
		//Tutorial Videos
	//	$submenu['edit.php?post_type=designapprovalsystem'][22][0] = __('Tutorial Videos', 'design-approval-system');
	//	$submenu['edit.php?post_type=designapprovalsystem'][22][1] = 'manage_options';
	//	$submenu['edit.php?post_type=designapprovalsystem'][22][2] = 'design-approval-system-video-page';
	//	$submenu['edit.php?post_type=designapprovalsystem'][22][3] = __('Design Approval System Videos', 'design-approval-system');
		
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
		
		
	if (is_plugin_active('das-design-login/das-design-login.php')) {	
		//Login Settings Ajaxed Login * 6-15-13 SRL
		$submenu['edit.php?post_type=designapprovalsystem'][22][0] = __('Login Settings', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][22][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][22][2] = 'das-design-login-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][22][3] = __('Design Approval System Login Settings', 'design-approval-system');
	}
	
	if (is_plugin_active('das-clean-theme/das-clean-theme.php')) {	
		 
		$submenu['edit.php?post_type=designapprovalsystem'][23][0] = __('Clean Theme Settings', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][23][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][23][2] = 'das-clean-theme-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][23][3] = __('Clean Theme Settings Page', 'design-approval-system');
	}
	
	if (is_plugin_active('das-gq-theme/das-gq-theme.php')) {	
		 
		$submenu['edit.php?post_type=designapprovalsystem'][24][0] = __('GQ Theme Settings', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][24][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][24][2] = 'das-gq-theme-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][24][3] = __('GQ Theme Settings', 'design-approval-system');
	}
	
}
add_action( 'admin_menu', 'edit_admin_menus' );



// Checks to see if Custom Post Template is installed and activated.
add_action( 'admin_notices', 'das_dependencies' );
function das_dependencies() {

if (is_plugin_active('design-approval-system/design-approval-system.php')) {

			if (get_option('das_default_theme_logo_image') =='') {
			echo '<div class="error"><p>' . __( 'Warning: The <strong>Design Approval System</strong> plugin needs you to fill the in REQUIRED fields on <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page"><strong>settings page</strong></a>.', 'my-theme' ) . '</p></div>';
			}
			elseif (get_option('das-settings-company-name') =='') {
			echo '<div class="error"><p>' . __( 'Warning: The <strong>Design Approval System</strong> plugin needs you to fill the in REQUIRED fields on <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page"><strong>settings page</strong></a>.', 'my-theme' ) . '</p></div>';
			}
			elseif (get_option('das-settings-company-email') =='') {
			echo '<div class="error"><p>' . __( 'Warning: The <strong>Design Approval System</strong> plugin needs you to fill the in REQUIRED fields on <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page"><strong>settings page</strong></a>.', 'my-theme' ) . '</p></div>';
			}
	}
}

remove_role( 'das_designer');

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
    'edit_posts' => false,
    'delete_posts' => false,
	'manage_options' => true,
	'upload_files' => true,
));

		global $wp_roles;
		if ( !isset( $wp_roles ) )
			$wp_roles = new WP_Roles();
	
		$das_client = $wp_roles->get_role('das_client');
		


//Walkthrough Scripts
//  add_action('admin_enqueue_scripts', 'walkthrough_scripts');


  // THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
//  function walkthrough_scripts() {
//	  wp_register_style( 'walkthrough_jquerytour_css', plugins_url( 'admin/walkthrough/css/jquerytour.css',  dirname(__FILE__) ) );
//	  wp_enqueue_style('walkthrough_jquerytour_css'); 
//	  wp_register_script( 'wt_cookie', plugins_url( 'admin/walkthrough/js/jquery.cookie.js',  dirname(__FILE__) ) );
//	  wp_enqueue_script('wt_cookie'); 
 // }

// Create new Post Template for DAS
function DAS_post_template($das_post_template_load) {
	  global $post;
	   if ($post->post_type == 'designapprovalsystem') {
			//Get Selected Template for Design Post Page.
			$das_post_template = get_post_meta($post->ID, 'custom_das_template_options', true);
			
			//Theme Locations for Template file in root of theme or "DAS" folder.
			$overridden_template_in_folder = locate_template('das/'.$das_post_template);
			$overridden_template = locate_template($das_post_template);
			
			//Check if Theme has a custom template file in DAS folder
			 if($overridden_template_in_folder != '') {
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
				// echo "No DAS Template. Using Default.";
				 //DAS Default Template
				 if($das_post_template == 'das-default-template.php' or empty($das_post_template)){
					  $das_post_template_load = WP_CONTENT_DIR.'/plugins/design-approval-system/framework/das-main-frame.php';
				 }
				 //Clean Theme Template
				 if($das_post_template == 'das-clean-theme-template.php'){
					  $das_post_template_load = WP_CONTENT_DIR.'/plugins/das-clean-theme/framework/das-clean-theme-main-frame.php';
				 }
				  //GQ Theme Template
				 if($das_post_template == 'das-gq-theme-template.php'){
					  $das_post_template_load = WP_CONTENT_DIR.'/plugins/das-gq-theme/framework/das-gq-theme-main-frame.php';
				 }
			}
	  }
	  return $das_post_template_load;
}
add_filter('single_template','DAS_post_template',999);

add_action( 'pre_get_posts', 'das_woo_pre_get_posts_query' );
 
function das_woo_pre_get_posts_query( $q ) {
 
if ( ! $q->is_main_query() ) return;
if ( ! $q->is_post_type_archive() ) return;
if ( ! is_admin() ) {
 
$q->set( 'tax_query', array(array(
	'taxonomy' => 'product_cat',
	'field' => 'slug',
	'terms' => array( 'DAS Designs' ), // Don't display products in the membership category on the shop page . For multiple category , separate it with comma.
	'operator' => 'NOT IN'
)));
 
}
 
remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );
 
}

$dasPrivatePublicPlugin = is_plugin_active('das-public-private-project-board/das-public-private-project-board.php');

if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-projects-page' || $dasPrivatePublicPlugin ) {
	
// Begin Shortcode Functions
////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
//////////////////// Private Shortcode ///////////////////////////////////
/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

function das_private_project_board_function() {
  ob_start();
  
 if ( current_user_can_for_blog($user_blog_id, 'administrator') || current_user_can_for_blog($user_blog_id, 'das_designer') || current_user_can_for_blog($user_blog_id, 'das_client')) {
 
  ?> <div class="das-project-admin-wrap"> 
  
  <?php
  	$user_id = $current_user->ID;
$user_blogs = get_blogs_of_user( $user_id );

foreach ($user_blogs AS $user_blog) {
  if ($user_blog->path == '/'){
	  # do nothing
  }
  else {
	  
  $user_blog_id = $user_blog->userblog_id;
  
  }
}
$user = wp_get_current_user();
$this_users_email = $user->user_email;

//Custom DAS Post Type
$post_type = 'designapprovalsystem';
//Custom DAS Taxonomies (aka Categories)
$tax = 'das_categories';

$client = get_terms( $tax );

//Client and Terms arrays.
$clients_emails = array();
$clients_names = array();
$term_names = array();
$post_counts = array();

//Loop to custom taxonomy to build Client and Terms arrays.
foreach ($client as $term) :
	$args = array(
	  'post_type' => $post_type,
	  'post_per_page' => -1,
	  'nopaging' => true,
	  'post_status'   => 'publish',
	  'caller_get_posts' => 1,
	  'tax_query' => array(
			   array(
				 'taxonomy' => $tax,
				 'field'    => 'ID',
				 'terms'   => array( $term->term_id )
			   ),	 
	   ), 
	   'orderby' => 'title', 
	   'order' => 'ASC'
	);
	$my_query2 = new WP_Query($args);
	
	 $post_counts[] = $my_query2->post_count;
	 
	if( $my_query2->have_posts() ) : 
	     while ( $my_query2->have_posts() ) : $my_query2->the_post(); global $post;   
		$clients_email = get_post_meta($post->ID, 'custom_clients_email', true);
		  $clients_emails[] = $clients_email;
		  $term_names[$term->name] = $clients_email;
		  $clients_names[] = get_post_meta($post->ID, 'custom_client_name', true);
		  
		  $title_approved_checker = get_post_meta($post->ID, 'custom_client_approved', true);
		  $approved_main_designs_count[$clients_email][$term->name][] = $title_approved_checker;
											
	endwhile; endif;   		
endforeach;
//END Build Arrays
 
//Clean up Clients Array So no duplicate client titles happen.
$final_clients_emails = array_unique($clients_emails);
			
//Start loop for displaying Client Name [Final Build loop]				
foreach ($final_clients_emails as $key => $value)  :

if ($value == $this_users_email) {
	
	foreach($clients_names as $number => $title){
		if ($number == $key) {
			$client_title = $title;
		}
	}
	
//Client Name	
echo "<h2>".$client_title."</h2>"; 

//Client Name value for check.
$client_value = $value;

$counter = 0;
	//loop for displaying Project Name
	foreach ($term_names as $key => $value) :
	  $term_value = $value; 
	if($client_value == $value) {
		
		?>
<h3 class='pb-cat-header'> <?php echo $key ?>
  <?php if(in_array("Yes", $approved_main_designs_count[$value][$key])) { echo'<div class="das-approved-design-subtitle"></div>'; } ?>
  <span><?php echo $post_counts[$counter]; ?></span></h3>
<?php echo "<div class='das-project-list-wrap'>";
			echo "<ul class='das-project-list'>";
		//loop for displaying posts for Project
		foreach ($client as $term) :
		$args = array(
			'post_type' => $post_type,
			'post_per_page'     => -1,
	 		'nopaging'          => true,
			'post_status'       => 'publish',
			'caller_get_posts'  => 1,
			'orderby'   		=> 'name',
			'order'             => 'ASC',
			'tax_query'         => array(
				   array(
					 'taxonomy' => $tax,
					 'field'    => 'ID',
					 'terms'    => array( $term->term_id )
				   ),	 
			 ), 
			 'orderby'          => 'name', 
			 'order'            => 'ASC'
		  );
		   $my_query = new WP_Query($args);
		   	 	
						if( $my_query->have_posts() ) : ?>
  <?php while ( $my_query->have_posts() ) : $my_query->the_post(); global $post; 
								
							
								$final_client_value = get_post_meta($post->ID, 'custom_clients_email', true);
								$final_term_value = $term->name;
								
								//Design Link creation
								if(($term_value == $final_client_value) && ($key == $final_term_value)) {?>
  
  
  <li>
 	<?php $dirDASplugin = plugin_dir_path(__FILE__ );
				include($dirDASplugin . '../includes/das-project-boards.php'); ?>
</li>

  <?php }
  
					    endwhile; endif;   ?>
  <?php endforeach; 
			echo "</ul>";
		echo "</div>";
		}
		$counter++;
	endforeach;
} 
endforeach;
$first_counter++;

// Restore original Query & Post Data
wp_reset_query();
wp_reset_postdata();
?>

</div>
<!--/das-project-admin-wrap-->
<?php } // end of the if user is logged in statement
 else {
		echo '<p>Please <a href="'. wp_login_url( get_permalink() ) .'" title="Login">Login</a> to view your Project Board.</p>';
	}
?>  	
		<?php
  $output_string = ob_get_contents();
  ob_end_clean();
  return $output_string;
} // end Private Shortcode
	add_shortcode('DASPrivateBoard', 'das_private_project_board_function');


////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
//////////////////// Public Shortcode ////////////////////////////////////
/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////

function das_public_project_board_function2() {
  ob_start();
?> 
<div class="das-project-admin-wrap"> 
<?php
//Custom DAS Post Type
$post_type = 'designapprovalsystem';
//Custom DAS Taxonomies (aka Categories)
$tax = 'das_categories';

$client = get_terms( $tax );

//Client and Terms arrays.
$clients_names = array();
$term_names = array();
$post_counts = array();
$approved_main_designs_count = array();

//Loop to custom taxonomy to build Client and Terms arrays.
foreach ($client as $term) :
	$args = array(
	  'post_type' 		    	=> $post_type,
	  'posts_per_page'		 => -1,
	  'post_status'   => 'publish',
	  'ignore_sticky_posts' => 1,
	  'tax_query' => array(
			   array(
				 'taxonomy' => $tax,
				 'field'    => 'ID',
				 'terms'   => array( $term->term_id )
			   ),	 
	   ), 
	   'orderby' => 'title', 
	   'order' => 'ASC'
	);
	$my_query2 = new WP_Query($args);
	
	 $post_counts[] = $my_query2->post_count;
	 
	if( $my_query2->have_posts() ) : 
	  while ( $my_query2->have_posts() ) : $my_query2->the_post(); global $post;   
		$clients_name = get_post_meta($post->ID, 'custom_client_name', true);
		  $clients_names[] = $clients_name;
		  $term_names[$term->name] = $clients_name;
		  
		  $title_approved_checker = get_post_meta($post->ID, 'custom_client_approved', true);
		  $approved_main_designs_count[$clients_name][$term->name][] = $title_approved_checker;
											
	endwhile; endif;   		
endforeach;
//END Build Arrays
 
//Clean up Clients Array So no duplicate client titles happen.
$final_clients_names = array_unique($clients_names);

//Start loop for displaying Client Name [Final Build loop]				
foreach ($final_clients_names as $key => $value) :
$first_counter = 0;	

//Client Name	
echo '<h2>'.$value.'</h2>'; 

//Client Name value for check.
$client_value = $value;

$counter = 0;

	//loop for displaying Project Name
	foreach ($term_names as $key => $value) :
	  $term_value = $value; 
	if($client_value == $value) {
		
		?>
<h3 class='pb-cat-header'> <?php echo $key ?>
  <?php if(in_array("Yes", $approved_main_designs_count[$value][$key])) { echo'<div class="das-approved-design-subtitle"></div>'; } ?>
  <span><?php echo $post_counts[$counter]; ?></span></h3>
<?php echo "<div class='das-project-list-wrap'>";
			echo "<ul class='das-project-list'>";
		//loop for displaying posts for Project
		foreach ($client as $term) :
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => -1,
			'post_status'   => 'publish',
			'caller_get_posts' => 1,
			'orderby' => 'name',
			'order' => 'ASC',
			'tax_query' => array(
					 array(
					   'taxonomy' => $tax,
					   'field'    => 'ID',
					   'terms'   => array( $term->term_id )
					 ),	 
			 ), 
			 'orderby' => 'name', 
			 'order' => 'ASC'
		  );
		  
		   
		   $my_query = new WP_Query($args);
		   	 	
						if( $my_query->have_posts() ) : ?>
<?php while ( $my_query->have_posts() ) : $my_query->the_post(); global $post; 
								
							 
								$final_client_value = get_post_meta($post->ID, 'custom_client_name', true);
								$final_term_value = $term->name;
								
								//Design Link creation
								if(($term_value == $final_client_value) && ($key == $final_term_value)) {
									
																		
									?>
<li>
 	<?php $dirDASplugin = plugin_dir_path(__FILE__ );
				include($dirDASplugin . '../includes/das-project-boards.php'); ?>
</li>
<?php }
					    endwhile; endif;   ?>
<?php endforeach; 
			echo "</ul>";
		echo "</div>";
		}
		$counter++;
	endforeach;
	
endforeach;

$first_counter++;

// Restore original Query & Post Data
wp_reset_query();
wp_reset_postdata();
?>
<br class="clear"/>

</div>
<!--/das-project-admin-wrap--> 
<?php
  $output_string = ob_get_contents();
  ob_end_clean();
  return $output_string;
}
	add_shortcode('DASPublicBoard', 'das_public_project_board_function2');
} // end if is das project board and if das public/private board is active





















































 

/**
 * Plugin Name: My Amdin Pointers 
 * Plugin URI:  https://gist.github.com/brasofilo/6947539
 * Version:     0.1
 * Author:      Rodolfo Buaiz
 * Author URI:  http://brasofilo.com
 * Licence:     GPLv3
 * 
 * Based on 
 * - http://wp.tutsplus.com/tutorials/integrating-with-wordpress-ui-admin-pointers/
 * - https://github.com/rawcreative/wp-help-pointers
 * - http://wpengineer.com/2272/how-to-add-and-deactivate-the-new-feature-pointer-in-wordpress-3-3/
 * 
 */
add_action( 'admin_enqueue_scripts', 'myHelpPointers' );

function myHelpPointers()
{
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
    new B5F_Admin_Pointer( $pointers );
}


class B5F_Admin_Pointer
{
    public $screen_id;
    public $valid;
    public $pointers;

    /**
     * Register variables and start up plugin
     */
    public function __construct( $pointers = array( ) )
    {
        if( get_bloginfo( 'version' ) < '3.3' )
            return;

        $screen = get_current_screen();
        $this->screen_id = $screen->id;
        $this->register_pointers( $pointers );
        add_action( 'admin_enqueue_scripts', array( $this, 'add_pointers' ), 1000 );
        add_action( 'admin_print_footer_scripts', array( $this, 'add_scripts' ) );
    }


    /**
     * Register the available pointers for the current screen
     */
    public function register_pointers( $pointers )
    {
        $screen_pointers = null;
        foreach( $pointers as $ptr )
        {
            if( $ptr['screen'] == $this->screen_id )
            {
                $options = array(
                    'content'  => sprintf(
                        '<h3> %s </h3> <p> %s </p>', 
                        __( $ptr['title'], 'plugindomain' ), 
                        __( $ptr['content'], 'plugindomain' )
                    ),
                    'position' => $ptr['position']
                );
                $screen_pointers[$ptr['id']] = array(
                    'screen'  => $ptr['screen'],
                    'target'  => $ptr['target'],
                    'options' => $options
                );
            }
        }
        $this->pointers = $screen_pointers;
    }


    /**
     * Add pointers to the current screen if they were not dismissed
     */
    public function add_pointers()
    {
        if( !$this->pointers || !is_array( $this->pointers ) )
            return;

        // Get dismissed pointers
        $get_dismissed = get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true );
        $dismissed = explode( ',', (string) $get_dismissed );

        // Check pointers and remove dismissed ones.
        $valid_pointers = array( );
        foreach( $this->pointers as $pointer_id => $pointer )
        {
            if(
                in_array( $pointer_id, $dismissed ) 
                || empty( $pointer ) 
                || empty( $pointer_id ) 
                || empty( $pointer['target'] ) 
                || empty( $pointer['options'] )
            )
                continue;

            $pointer['pointer_id'] = $pointer_id;
            $valid_pointers['pointers'][] = $pointer;
        }

        if( empty( $valid_pointers ) )
            return;

        $this->valid = $valid_pointers;
        wp_enqueue_style( 'wp-pointer' );
        wp_enqueue_script( 'wp-pointer' );
    }


    /**
     * Print JavaScript if pointers are available
     */
    public function add_scripts()
    {
        if( empty( $this->valid ) )
            return;

        $pointers = json_encode( $this->valid );

        echo ' ?>
<script type="text/javascript">
//<![CDATA[
	jQuery(document).ready( function($) {
		var WPHelpPointer = <?php $pointers ?>;

		$.each(WPHelpPointer.pointers, function(i) {
			wp_help_pointer_open(i);
		});

		function wp_help_pointer_open(i) 
		{
			pointer = WPHelpPointer.pointers[i];
			$( pointer.target ).pointer( 
			{
				content: pointer.options.content,
				position: 
				{
					edge: pointer.options.position.edge,
					align: pointer.options.position.align
				},
				close: function() 
				{
					$.post( ajaxurl, 
					{
						pointer: pointer.pointer_id,
						action: "dismiss-wp-pointer"
					});
				}
			}).pointer("open");
		}
	});
//]]>
</script>
<?php ' ;
    }
    
}
?>