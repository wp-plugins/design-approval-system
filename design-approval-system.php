<?php
/*
Plugin Name: Design Approval System
Plugin URI: http://slickremix.com/
Description: A plugin to display Designs and have a client approve them by giving a digital signature.
Version: 2.6
Author: SlickRemix [Justin Labadie & Spencer Labadie]
Author URI: http://slickremix.com/
Requires at least: wordpress 3.4.0
Tested up to: wordpress 3.5.0
Stable tag: 2.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

 * @package    			Design Approval System
 * @category   			Core
 * @author     		    SlickRemix
 * @copyright  			Copyright (c) 2012 SlickRemix

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