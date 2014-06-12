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
add_action( 'init', 'register_taxonomy_das_categories' );
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
	
	flush_rewrite_rules();
}
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
		
		flush_rewrite_rules();
}
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
add_action('admin_menu', 'register_das_video_submenu_page');

function register_das_video_submenu_page() {
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', __('Design Approval System Videos', 'design-approval-system'), __('Tutorial Videos', 'design-approval-system'), 'manage_options', 'design-approval-system-video-page', 'das_video_page' );
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
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', __('Design Approval System News & Updates', 'design-approval-system'), __('DAS News', 'design-approval-system'), 'manage_options', 'design-approval-system-news-updates-page', 'das_news_updates_page' );
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
		$submenu['edit.php?post_type=designapprovalsystem'][20][0] = __('News', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][20][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][20][2] = 'design-approval-system-news-updates-page';
		$submenu['edit.php?post_type=designapprovalsystem'][20][3] = __('Design Approval System News & Updates', 'design-approval-system');
		
		//Walk Through
		$submenu['edit.php?post_type=designapprovalsystem'][21][0] = __('Walk-Through', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][21][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][21][2] = 'edit.php?post_type=designapprovalsystem&page=design-approval-system-projects-page&step=1';
		
		
		//Tutorial Videos
		$submenu['edit.php?post_type=designapprovalsystem'][22][0] = __('Tutorial Videos', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][22][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][22][2] = 'design-approval-system-video-page';
		$submenu['edit.php?post_type=designapprovalsystem'][22][3] = __('Design Approval System Videos', 'design-approval-system');
		
		//Help
		$submenu['edit.php?post_type=designapprovalsystem'][23][0] = __('Help', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][23][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][23][2] = 'design-approval-system-help-page';
		$submenu['edit.php?post_type=designapprovalsystem'][23][3] = __('Design Approval System Help', 'design-approval-system');
		
		
		//Settings
		$submenu['edit.php?post_type=designapprovalsystem'][24][0] = __('Settings', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][24][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][24][2] = 'design-approval-system-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][24][3] = __('Settings', 'design-approval-system');
		
		
	if (is_plugin_active('das-design-login/das-design-login.php')) {	
		//Login Settings Ajaxed Login * 6-15-13 SRL
		$submenu['edit.php?post_type=designapprovalsystem'][25][0] = __('Login Settings', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][25][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][25][2] = 'das-design-login-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][25][3] = __('Design Approval System Login Settings', 'design-approval-system');
	}
	
	if (is_plugin_active('das-clean-theme/das-clean-theme.php')) {	
		 
		$submenu['edit.php?post_type=designapprovalsystem'][26][0] = __('Clean Theme Settings', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][26][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][26][2] = 'das-clean-theme-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][26][3] = __('Clean Theme Settings Page', 'design-approval-system');
	}
	
	if (is_plugin_active('das-gq-theme/das-gq-theme.php')) {	
		 
		$submenu['edit.php?post_type=designapprovalsystem'][27][0] = __('GQ Theme Settings', 'design-approval-system');
		$submenu['edit.php?post_type=designapprovalsystem'][27][1] = 'manage_options';
		$submenu['edit.php?post_type=designapprovalsystem'][27][2] = 'das-gq-theme-settings-page';
		$submenu['edit.php?post_type=designapprovalsystem'][27][3] = __('GQ Theme Settings', 'design-approval-system');
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
		
//Prevent Clients from accessing media page
function prevent_admin_access()
{
    if ( false !== strpos( strtolower( $_SERVER['REQUEST_URI'] ), '/wp-admin/upload.php' ) && current_user_can( 'das_client' ) )
        wp_redirect( admin_url('') );
}
add_action( 'init', 'prevent_admin_access', 0 );

//Remove Media page from menu for clients
add_action( 'admin_menu', 'my_remove_menu_pages' );

    function my_remove_menu_pages() {
		if (current_user_can('das_client')){
        	remove_menu_page('upload.php'); 
		}          
    }

//Walkthrough Scripts
  add_action('admin_enqueue_scripts', 'walkthrough_scripts');
  // THIS GIVES US SOME OPTIONS FOR STYLING THE ADMIN AREA
  function walkthrough_scripts() {
	  wp_register_style( 'walkthrough_jquerytour_css', plugins_url( 'admin/walkthrough/css/jquerytour.css',  dirname(__FILE__) ) );
	  wp_enqueue_style('walkthrough_jquerytour_css'); 
	  wp_register_script( 'wt_cookie', plugins_url( 'admin/walkthrough/js/jquery.cookie.js',  dirname(__FILE__) ) );
	  wp_enqueue_script('wt_cookie'); 
  }

// Create new Post Template for Doc It
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
?>