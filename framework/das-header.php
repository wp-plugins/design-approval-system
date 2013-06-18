<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title>
<?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	// $site_description = get_bloginfo( 'description', 'display' );
	// if ( $site_description && ( is_home() || is_front_page() ) )
	//	echo " | $site_description";

	// Add a page number if necessary:
	// if ( $paged >= 2 || $page >= 2 )
	//	echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?>
</title>
<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
<?php wp_head(); ?>

<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/tinymce/jquery.tinymce.min.js"></script>
  
    <script type="text/javascript">
tinymce.init({
            theme : "modern",
            mode: "specific_textareas", 
			skin : 'lightgray',
            language: "",
			width : 777,
			height:165,
			autoresize_min_height: 165,
			menubar:false,
    		statusbar: false,
			theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor,link",
            theme_advanced_toolbar_location : "top",
			theme_advanced_resizing : true,
			content_css : "<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/css/custom_tinymce.css",
			editor_selector :"dastinymceenabled"
        });</script>
    
<?php wp_enqueue_script( 'my_script_enqueuer' ); ?>
	
<!--<script type="text/javascript" src="< ?php print includes_url(); ?>js/jquery/jquery.js"></script> -->
<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/jquery.form.js"></script>
<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/design-requests.js"></script>