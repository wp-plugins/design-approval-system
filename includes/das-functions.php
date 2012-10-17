<?php
/************************************************
 	Function file for Design System plugin
************************************************/
//Create Taxenomy for DAS
add_action( 'init', 'register_taxonomy_das_categories' );

function register_taxonomy_das_categories() {

    $labels2 = array( 
        'name' => _x( 'DAS Categories', 'das_categories' ),
        'singular_name' => _x( 'DAS Category', 'das_categories' ),
        'search_items' => _x( 'Search DAS Categories', 'das_categories' ),
        'popular_items' => _x( 'Popular DAS Categories', 'das_categories' ),
        'all_items' => _x( 'All DAS Categories', 'das_categories' ),
        'parent_item' => _x( 'Parent DAS Category', 'das_categories' ),
        'parent_item_colon' => _x( 'Parent DAS Category:', 'das_categories' ),
        'edit_item' => _x( 'Edit DAS Category', 'das_categories' ),
        'update_item' => _x( 'Update DAS Category', 'das_categories' ),
        'add_new_item' => _x( 'Add New DAS Category', 'das_categories' ),
        'new_item_name' => _x( 'New DAS Category', 'das_categories' ),
        'separate_items_with_commas' => _x( 'Separate das categories with commas', 'das_categories' ),
        'add_or_remove_items' => _x( 'Add or remove das categories', 'das_categories' ),
        'choose_from_most_used' => _x( 'Choose from the most used das categories', 'das_categories' ),
        'menu_name' => _x( 'DAS Categories', 'das_categories' ),
    );

    $args1 = array( 
        'labels' => $labels2,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
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
               'menu_name' => 'All Design Posts',
               'name' => 'Design Approval System'
            ),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => array('slug' => 'designs'),
		'query_var' => 'Design Approval System',
		'menu_icon' => ''.DAS_PLUGIN_PATH .'/design-approval-system/admin/images/design-approval-icon2.png',
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

/**
 * Renames the first occurence of 'See All Academias' to 'Academias'
 * and deactivates itself then.
 * @param $safe_text
 * @param $text
 */
function rename_second_das_submenu_name( $safe_text, $text )
{
    if ( 'All Design Posts' !== $text )
    {
        return $safe_text;
    }

    // We are on the main menu item now. The filter is not needed anymore.
    remove_filter( 'attribute_escape', 'rename_second_das_submenu_name' );

    return 'Design Approval System';
}

//Adds Tutorials page to DAS sub menu
add_action('admin_menu', 'register_das_help_submenu_page');

function register_das_help_submenu_page() {
	add_submenu_page( 'edit.php?post_type=designapprovalsystem', 'Design Approval System Help', 'Help', 'manage_options', 'design-approval-system-tutorials-page', 'das_help_page' );
}
 
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
?>
