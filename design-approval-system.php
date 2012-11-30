<?php
/*
Plugin Name: Design Approval System
Plugin URI: http://slickremix.com/
Description: A plugin to display Designs and have a client approve them by giving a digital signature.
<<<<<<< .mine
Version: 2.3
Author: Slick Remix [Justin Labadie & Spencer Labadie]
=======
Version: 2.2
Author: Slick Remix [Justin Labadie & Spencer Labadie]
>>>>>>> .r632067
Author URI: http://slickremix.com/
Requires at least: wordpress 3.4.0
Tested up to: wordpress 3.5.0
<<<<<<< .mine
Stable tag: 2.3
=======
Stable tag: 2.2
>>>>>>> .r632067
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * @package    			Design Approval System
 * @category   			Core
 * @author     		    SlickRemix [Justin Labadie & Spencer Labadie]
 * @copyright  			Copyright (c) 2012 Slickremix

If you need support or want to tell us thanks please contact us at info@slickremix.com or use our support forum on slickremix.com

This is the main file for building the plugin into wordpress

*/
define( 'DAS_PLUGIN_PATH', plugins_url() ) ;

// Include core files and classes
include( 'includes/das-functions.php' );
include( 'includes/das-meta-box.php' );
include( 'admin/das-settings-page.php' );
include( 'admin/das-help-page.php' );
include( 'admin/das-video-page.php' );
include( 'admin/das-news-updates-page.php' );

/**
 * Returns current plugin version. SRL added
 * 
 * @return string Plugin version
 */
function dasystem_version() {
	$plugin_data = get_plugin_data( __FILE__ );
	$plugin_version = $plugin_data['Version'];
	return $plugin_version;
}
?>