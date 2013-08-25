<?php
/************************************************
 	Function file for Design System plugin
************************************************/
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
    unset($columns['comments']);
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
add_action( 'init', 'register_taxonomy_das_categories' );
function register_taxonomy_das_categories() {

    $labels2 = array( 
        'name' => _x( 'Project Names', 'das_categories' ),
        'singular_name' => _x( 'Project Name', 'das_categories' ),
        'search_items' => _x( 'Search Project Names', 'das_categories' ),
        //'popular_items' => _x( 'Popular Project Names', 'das_categories' ),
        'all_items' => _x( 'All Project Names', 'das_categories' ),
        'parent_item' => _x( 'Parent Project Name', 'das_categories' ),
        'parent_item_colon' => _x( 'Parent Project Name:', 'das_categories' ),
        'edit_item' => _x( 'Edit Project Name', 'das_categories' ),
        'update_item' => _x( 'Update Project Name', 'das_categories' ),
        'add_new_item' => _x( 'Add New Project Name', 'das_categories' ),
        'new_item_name' => _x( 'New Project Name', 'das_categories' ),
        'separate_items_with_commas' => _x( 'Separate Project Names with commas', 'das_categories' ),
        'add_or_remove_items' => _x( 'Add or remove Project Names', 'das_categories' ),
        'choose_from_most_used' => _x( 'Choose from the most used Project Names', 'das_categories' ),
        'menu_name' => _x( 'Project Names', 'das_categories' ),
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
	
	flush_rewrite_rules();
}
function my_cpt_post_types( $post_types ) {
    $post_types[] = 'Design Approval System';
    return $post_types;
}
//Create DAS Custom Post type
add_filter( 'cpt_post_types', 'my_cpt_post_types' );

function das_custom_post_type_init() {
    $args = array(
		'label' => 'Design Approval System',
		'labels' => array (
               'menu_name' => 'Projects',
               'name' => 'All Your Designs',
			   'singular_name' => 'Project',
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
		
		flush_rewrite_rules();
}
add_action( 'init', 'das_custom_post_type_init' );

add_filter( 'attribute_escape', 'rename_second_das_submenu_name', 10, 2 );

// THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
function das_admin_css() {
   echo '<link rel="stylesheet" id="DAS-ADMIN-CSS" href="'.DAS_PLUGIN_PATH.'/design-approval-system/admin/css/admin.css" type="text/css" media="all">';
}

add_action('admin_head', 'das_admin_css');

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
add_action('admin_menu', 'register_das_video_submenu_page');

function register_das_video_submenu_page() {
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', 'Design Approval System Videos', 'Tutorial Videos', 'manage_options', 'design-approval-system-video-page', 'das_video_page' );
}
//Enque admin-setttings.css only for this page
function das_video_settings_admin_scripts(){
	wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
	wp_enqueue_style( 'og-admin-css' );
}
if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-video-page') {
  add_action('admin_enqueue_scripts', 'das_video_settings_admin_scripts');
}

//Adds News & Updates Page page to DAS sub menu
add_action('admin_menu', 'register_das_news_updates_submenu_page');
function register_das_news_updates_submenu_page() {
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', 'Design Approval System News & Updates', 'DAS News', 'manage_options', 'design-approval-system-news-updates-page', 'das_news_updates_page' );
}
//Enque admin-setttings.css only for this page
function das_news_settings_admin_scripts(){
	wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
	wp_enqueue_style( 'og-admin-css' );
	wp_register_style('news-admin-css', plugins_url( 'design-approval-system/admin/css/news-updates-styles.css'));
	wp_enqueue_style( 'news-admin-css' );
}
if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-news-updates-page') {
  add_action('admin_enqueue_scripts', 'das_news_settings_admin_scripts');
}

//Adds Help page to DAS sub menu
add_action('admin_menu', 'register_das_help_submenu_page');
function register_das_help_submenu_page() {
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', 'Design Approval System Help', 'Help', 'manage_options', 'design-approval-system-help-page', 'das_help_page' );
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
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', 'Design Approval System Settings', 'Settings', 'manage_options', 'design-approval-system-settings-page', 'das_settings_page' ); 
}
//Enque admin-setttings.css only for this page
function das_main_settings_admin_scripts(){
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', ''.plugins_url( 'admin/js/das-settings-page-image-uploader.js' , dirname(__FILE__) ).'', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
	wp_enqueue_style('thickbox');
	wp_register_style('og-admin-css', plugins_url( 'design-approval-system/admin/css/admin-settings.css'));
	wp_enqueue_style( 'og-admin-css' );
}
if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-settings-page') {
  add_action('admin_enqueue_scripts', 'das_main_settings_admin_scripts');
}

// Re-Construct Submenu Item
function edit_admin_menus() {
	global $submenu;
		$submenu['edit.php?post_type=designapprovalsystem'][10][0] = 'Add New Project';
		
		//Project Board
		$submenu['edit.php?post_type=designapprovalsystem'][5][0] = 'Project Board';
		$submenu['edit.php?post_type=designapprovalsystem'][5][1] = 'read';
		$submenu['edit.php?post_type=designapprovalsystem'][5][2] = 'design-approval-system-projects-page';
		$submenu['edit.php?post_type=designapprovalsystem'][5][3] = 'Project Board';
		
		//Project Names
		$submenu['edit.php?post_type=designapprovalsystem'][10][0] = 'Project Names';
		$submenu['edit.php?post_type=designapprovalsystem'][10][1] = 'manage_categories';
		$submenu['edit.php?post_type=designapprovalsystem'][10][2] = 'edit-tags.php?taxonomy=das_categories&post_type=designapprovalsystem';
		
		//Add New Design
		$submenu['edit.php?post_type=designapprovalsystem'][16][0] = 'Add New Design';
		$submenu['edit.php?post_type=designapprovalsystem'][16][1] = 'edit_posts';
		$submenu['edit.php?post_type=designapprovalsystem'][16][2] = 'post-new.php?post_type=designapprovalsystem';
		unset($submenu['edit.php?post_type=designapprovalsystem'][16][3]);
		
		//Designs
		$submenu['edit.php?post_type=designapprovalsystem'][17][0] = 'Designs';
		$submenu['edit.php?post_type=designapprovalsystem'][17][1] = 'edit_posts';
		$submenu['edit.php?post_type=designapprovalsystem'][17][2] = 'edit.php?post_type=designapprovalsystem';
		
		//DAS Clients
		$submenu['edit.php?post_type=designapprovalsystem'][18][0] = 'DAS Clients';
		$submenu['edit.php?post_type=designapprovalsystem'][18][1] = 'manage_categories';
		$submenu['edit.php?post_type=designapprovalsystem'][18][2] = 'users.php?role=das_client';
		unset($submenu['edit.php?post_type=designapprovalsystem'][18][3]);
		
		//DAS Designers
		$submenu['edit.php?post_type=designapprovalsystem'][19][0] = 'DAS Designers';
		$submenu['edit.php?post_type=designapprovalsystem'][19][1] = 'manage_categories';
		$submenu['edit.php?post_type=designapprovalsystem'][19][2] = 'users.php?role=das_designer';
		unset($submenu['edit.php?post_type=designapprovalsystem'][19][3]);

		//DAS News
		$submenu['edit.php?post_type=designapprovalsystem'][20][0] = 'News';
		$submenu['edit.php?post_type=designapprovalsystem'][20][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][20][2] = 'design-approval-system-news-updates-page';
		$submenu['edit.php?post_type=designapprovalsystem'][20][3] = 'Design Approval System News & Updates';
		
		//Walk Through
		$submenu['edit.php?post_type=designapprovalsystem'][21][0] = 'Walk-Through';
		$submenu['edit.php?post_type=designapprovalsystem'][21][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][21][2] = 'edit.php?post_type=designapprovalsystem&page=design-approval-system-projects-page&step=1';
		
		
		//Tutorial Videos
		$submenu['edit.php?post_type=designapprovalsystem'][22][0] = 'Tutorial Videos';
		$submenu['edit.php?post_type=designapprovalsystem'][22][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][22][2] = 'design-approval-system-video-page';
		$submenu['edit.php?post_type=designapprovalsystem'][22][3] = 'Design Approval System Videos';
		
		//Help
		$submenu['edit.php?post_type=designapprovalsystem'][23][0] = 'Help';
		$submenu['edit.php?post_type=designapprovalsystem'][23][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][23][2] = 'design-approval-system-help-page';
		$submenu['edit.php?post_type=designapprovalsystem'][23][3] = 'Design Approval System Help';
		
		
		//Settings
		$submenu['edit.php?post_type=designapprovalsystem'][24][0] = 'Settings';
		$submenu['edit.php?post_type=designapprovalsystem'][24][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][24][2] = 'design-approval-system-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][24][3] = 'Settings';
		
		
	if (is_plugin_active('das-design-login/das-design-login.php')) {	
		//Login Settings Ajaxed Login * 6-15-13 SRL
		$submenu['edit.php?post_type=designapprovalsystem'][25][0] = 'Login Settings';
		$submenu['edit.php?post_type=designapprovalsystem'][25][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][25][2] = 'das-design-login-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][25][3] = 'Design Approval System Login Settings';
	}	
	
	if (is_plugin_active('das-clean-theme/das-clean-theme.php')) {	
		 
		$submenu['edit.php?post_type=designapprovalsystem'][26][0] = 'Theme Settings';
		$submenu['edit.php?post_type=designapprovalsystem'][26][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][26][2] = 'das-clean-theme-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][26][3] = 'Clean Theme Settings Page';
	}	
		
}
add_action( 'admin_menu', 'edit_admin_menus' );

// Checks to see if Custom Post Template is installed and activated.
add_action( 'admin_notices', 'das_dependencies' );

function das_dependencies() {
 	if (is_plugin_active('custom-post-template/custom-post-templates.php')) {
	}
	else  {
    	echo '<div class="error"><p>' . __( 'Warning: The <strong>Design Approval System</strong> plugin needs the <a href="plugin-install.php?tab=search&type=term&s=Custom+Post+Template&plugin-search-input=Search+Plugins"><strong>Custom Post Template</strong></a> plugin to be INSTALLED and ACTIVATED to function properly.', 'my-theme' ) . '</p></div>';
	}
	
// Checks to see if DAS is activated if so check to see if das slickremix theme file is in theme folder.
if (is_plugin_active('design-approval-system/design-approval-system.php')) {
		
$template_uri = get_bloginfo("template_url");
$tokens = explode('/', $template_uri);
$final_template_uri = $tokens[sizeof($tokens)-1];

	$das_slick_template = '../wp-content/themes/'.$final_template_uri.'/das-slick-template.php';
	
	$das_slick_template_v2 = '../wp-content/themes/'.$final_template_uri.'/das-slick-template-v2.php';
	
	$das_slick_template_v3 = '../wp-content/themes/'.$final_template_uri.'/das-slick-template-v3.php';
	
	$das_slick_template_v4 = '../wp-content/themes/'.$final_template_uri.'/das-slick-template-v4.php';
	
	$das_default_template = '../wp-content/themes/'.$final_template_uri.'/das-default-template.php';
	
	$das_template_file_uri = '../wp-content/plugins/design-approval-system/templates/slickremix/das-slickremix-template.php';
	
if (file_exists($das_slick_template)) {
		//delete old template file
		unlink($das_slick_template);
		
		//create new template file
		touch($das_default_template);
		$das_template_file = file_get_contents($das_template_file_uri);
		$theme_das_template_file = '../wp-content/themes/'.$final_template_uri.'/das-default-template.php';
		file_put_contents($theme_das_template_file, $das_template_file);
	}
	if (file_exists($das_slick_template_v2)) {
		//delete old template file
		unlink($das_slick_template_v2);
		
		//create new template file
		touch($das_default_template);
		$das_template_file = file_get_contents($das_template_file_uri);
		$theme_das_template_file = '../wp-content/themes/'.$final_template_uri.'/das-default-template.php';
		file_put_contents($theme_das_template_file, $das_template_file);
	}
	if (file_exists($das_slick_template_v3)) {
		//delete old template file
		unlink($das_slick_template_v3);
		
		//create new template file
		touch($das_default_template);
		$das_template_file = file_get_contents($das_template_file_uri);
		$theme_das_template_file = '../wp-content/themes/'.$final_template_uri.'/das-default-template.php';
		file_put_contents($theme_das_template_file, $das_template_file);
	}
	
	if (file_exists($das_slick_template_v4)) {
		//delete old template file
		unlink($das_slick_template_v4);
		
		//create new template file
		touch($das_default_template);
		$das_template_file = file_get_contents($das_template_file_uri);
		$theme_das_template_file = '../wp-content/themes/'.$final_template_uri.'/das-default-template.php';
		file_put_contents($theme_das_template_file, $das_template_file);
	}
	
	if (file_exists($das_default_template)) {
		//do nothing 
	}
	//Creates slickremix custom post template 
	else {
		touch($das_default_template);
		$das_template_file = file_get_contents($das_template_file_uri);
		$theme_das_template_file = '../wp-content/themes/'.$final_template_uri.'/das-default-template.php';
		file_put_contents($theme_das_template_file, $das_template_file);
}			
// Checks check if required settings are blank.
			if (get_option('image_1') =='') {
			echo '<div class="error"><p>' . __( 'Warning: The <strong>Design Approval System</strong> plugin needs you to fill the in REQUIRED fields on <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page"><strong>settings page</strong></a>. Additionally, if you are seeing any errors about not being able to copy or create the das-default-template.php then please <a target="_blank" href="http://www.slickremix.com/2013/06/03/error-on-install-regarding-template-creation/"><strong>click here for solution.</strong></a>', 'my-theme' ) . '</p></div>';
			}
			elseif (get_option('das-settings-company-name') =='') {
			echo '<div class="error"><p>' . __( 'Warning: The <strong>Design Approval System</strong> plugin needs you to fill the in REQUIRED fields on <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page"><strong>settings page</strong></a>.', 'my-theme' ) . '</p></div>';
			}
			elseif (get_option('das-settings-company-email') =='') {
			echo '<div class="error"><p>' . __( 'Warning: The <strong>Design Approval System</strong> plugin needs you to fill the in REQUIRED fields on <a href="edit.php?post_type=designapprovalsystem&page=design-approval-system-settings-page"><strong>settings page</strong></a>.', 'my-theme' ) . '</p></div>';
			}
	}
}

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
	'delete_published_posts' => true
));
/* Add DAS Client role to the site */
add_role('das_client', 'DAS Client', array(
    'read' => true,
    'edit_posts' => false,
    'delete_posts' => false,
	'manage_options' => true,
));

//Walkthrough Scripts
  add_action('admin_enqueue_scripts', 'walkthrough_scripts');
  // THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
  function walkthrough_scripts() {
	  wp_register_style( 'walkthrough_jquerytour_css', plugins_url( 'admin/walkthrough/css/jquerytour.css',  dirname(__FILE__) ) );
	  wp_enqueue_style('walkthrough_jquerytour_css'); 
	  wp_register_script( 'wt_cookie', plugins_url( 'admin/walkthrough/js/jquery.cookie.js',  dirname(__FILE__) ) );
	  wp_enqueue_script('wt_cookie'); 
  }
//}
?>