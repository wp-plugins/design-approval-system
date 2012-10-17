<?php
/*This file builds the DAS design post pages*/

$das_current_selected_template = 'wp-content/plugins/design-approval-system/framework/das-default-template.php';
$das_default_template_login = 'wp-content/plugins/das-design-login/framework/das-design-login-check.php';

$login_required = get_post_meta($post->ID, 'custom_login_no_login', true);

if(is_plugin_active('das-design-login/das-design-login.php') and $login_required == 'yes-login') {

	  include($das_default_template_login);
}
else{
	  include('wp-content/plugins/design-approval-system/framework/das-header.php');
	  include($das_current_selected_template);
}
?>