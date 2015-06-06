<?php
/*
	This is file is for creating the das settings page for Wordpress's backend
*/
// SRL added 6-6-13 to allow us to record the approved information directly to db

//Main setting page function
function das_settings_page() {
	
   wp_register_script( "das_settings_page_script", WP_PLUGIN_URL.'/design-approval-system/admin/js/admin.js', array('jquery') ); 
   wp_register_script( "das_settings_page_script2", WP_PLUGIN_URL.'/design-approval-system/templates/slickremix/js/jquery.form.js', array('jquery') );

   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'das_settings_page_script' );
   wp_enqueue_script( 'das_settings_page_script2' );
   
   $dasPremiumCheck = 'das-premium/das-premium.php';
   $dasPremiumActive = is_plugin_active($dasPremiumCheck);
?>

<div class="das-settings-admin-wrap">
<h2>
<?php _e('Design Approval System Settings', 'design-approval-system') ?>
</h2>
<a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/design-approval-system/" target="_blank" style="display:none;">
<?php _e('Get Extensions Here!', 'design-approval-system') ?>
</a>
<div class="use-of-plugin">
<?php _e("Please fill out the settings below. If you don't understand what a field is for click the question mark next to that title.", "design-approval-system") ?>
</div>
<h3>
<?php _e('Company Info', 'design-approval-system') ?>
</h3>
<form method="post" class="das-settings-admin-form" action="options.php">
<?php // get our registered settings from the gq theme functions 
	 	   settings_fields('design-approval-system-settings'); ?>
<!-- hiding this until future use -->
<div class="das-settings-admin-input-wrap company-info-style" style="display:none">
<div class="das-settings-admin-input-label">
<?php _e('Company Logo (required)', 'design-approval-system') ?>
: <a class="question1">
<?php _e('?', 'design-approval-system') ?>
</a></div>
<input id="das_default_theme_logo_image" name="das_default_theme_logo_image" class="das-settings-admin-input" type="text"  value="<?php // echo get_option('das_default_theme_logo_image'); ?>" />
<input id="das_logo_image_button" class="upload_image_button" type="button" value="<?php _e('Upload Image') ?>" />
<div class="das-settings-admin-input-example upload-logo-size">
<?php _e('This logo will be displayed at the top of all your design posts. Size for the "default" template is 124px X 20px.', 'design-approval-system') ?>
</div>
<div class="clear"></div>
<div class="das-settings-id-answer answer1">
<ul>
<li>
<?php _e('Your logo will be placed at the left right of the page.', 'design-approval-system') ?>
</li>
</ul>
<img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/admin-help-logo.jpg" alt="Header Logo Example" /> <a class="im-done">
<?php _e('close', 'design-approval-system') ?>
</a> </div>
<!--/das-settings-id-answer-->

<div class="clear"></div>
</div>
<!--/das-settings-admin-input-wrap-->

<div class="das-settings-admin-input-wrap company-info-style">
<div class="das-settings-admin-input-label">
<?php _e('Company Name (required)', 'design-approval-system') ?>
</div>
<input name="das-settings-company-name" class="das-settings-admin-input" type="text" id="das-settings-company-name" value="<?php echo get_option('das-settings-company-name'); ?>" />
<div class="das-settings-admin-input-example">
<?php _e('This is used when sending emails to a client, and will also appear on the approval form too.') ?>
</div>
</div>
<!--/das-settings-admin-input-wrap-->

<div class="das-settings-admin-input-wrap company-info-style">
<div class="das-settings-admin-input-label">
<?php _e('Company Email Address (required)', 'design-approval-system') ?>
</div>
<input name="das-settings-company-email" class="das-settings-admin-input" type="text" id="das-settings-company-email" value="<?php echo get_option('das-settings-company-email'); ?>" />
<div class="das-settings-admin-input-example">
<?php _e('This is required to send emails to a client through our system', 'design-approval-system') ?>
</div>
</div>
<!--/das-settings-admin-input-wrap-->

<div class="das-settings-admin-input-wrap company-info-style">
<div class="das-settings-admin-input-label">
<?php _e('Should Clients be logged in to View Designs?', 'design-approval-system') ?>
</div>
<input name="das-settings-approve-login-overide" class="das-settings-admin-input fleft" type="checkbox" id="das-settings-approve-login-overide" value="1" <?php checked( '1', get_option( 'das-settings-approve-login-overide' ) ); ?> />
<?php 
	   $approveLoginOveride = get_option( 'das-settings-approve-login-overide' );
		
if ($approveLoginOveride == '1') {
  _e('Checked, you are not requiring clients to login before approving designs.', 'design-approval-system');
}
else	{
  _e('Not checked, you require clients to be logged in before approving.', 'design-approval-system');
}

?>
<div class="das-custom-checkbox-wrap">
<?php _e('This is a good option if you are just trying to get something approved quicky without the hassle of creating a user for your client.<br/><br/><strong>PLEASE NOTE:</strong> If you check this option, your client will be able to Approve the Project but, you will have to manually edit the design post and add the Signature and select Yes to approve the design so a star will appear on the project board. This is only required if you want to see the star next to approved projects on the project board.<br/><br/>Your client will also not be able to add comments about changes if they did not want to approve the project (unless you are using the Client Changes add on that comes with DAS Premium). Additionally your clients will not be able to view their own personal project board. You cannot have this checked if you\'re using the Media Upload option either that is available in DAS Premium.', 'design-approval-system') ?>
</div>
</div>
<!--/das-settings-admin-input-wrap-->

<h3>
<?php _e('Replace Project Board and Front End Titles', 'design-approval-system') ?>
</h3>
<div class="subtext-of-title">
<?php _e('Add your own custom name in place of the word Project(s) and Design Project on the Project Board.', 'design-approval-system') ?>
</div>
<div class="das-settings-admin-input-wrap company-info-style pb-board-and-fep-options">
<label>
<?php _e('Singular version of the word to replace Project.') ?>
</label>
<input name="das-settings-singular-pb-fep-name" class="das-settings-admin-input" type="text" id="das-settings-singular-pb-fep-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Project', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-settings-singular-pb-fep-name') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
<label>
<?php _e("Plural version of the word to replace 'Projects'.") ?>
</label>
<input name="das-settings-plural-pb-fep-name" class="das-settings-admin-input" type="text" id="das-settings-plural-pb-fep-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Projects', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-settings-plural-pb-fep-name') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
<label>
<?php _e("The Tab for admins and designers on the front end 'Project Designs'.") ?>
</label>
<input name="das-settings-pb-fep-name" class="das-settings-admin-input" type="text" id="das-settings-pb-fep-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Project Designs', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-settings-pb-fep-name') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?>  />
</div>
<!--/das-settings-admin-input-wrap-->

<h3>
<?php _e('Smtp Info', 'design-approval-system') ?>
</h3>
<div class="das-settings-admin-input-wrap company-info-style ">
<div class="das-settings-admin-input-label">
<?php _e('Send emails using SMTP. Need Help or having problems connecting?', 'design-approval-system') ?>
<a href="http://www.slickremix.com/docs/gmail-or-server-smtp-setup/" target="_blank">
<?php _e('See Instructions', 'design-approval-system') ?>
</a></div>
<div class="das-settings-admin-input-label das-smtp-custom"></div>
<input name="das-settings-smtp" class="das-settings-admin-input" type="checkbox"  id="das-settings-smtp" value="1" <?php checked( '1', get_option( 'das-settings-smtp' ) ); ?>/>
<?php    
 
     $smtp_checked =  get_option( 'das-settings-smtp' );
		
if ($smtp_checked == '1') {
  _e('Checked, you are now using SMTP to send emails. You must contact your host provider if you are unsure of the settings to enter.', 'design-approval-system');
}
else	{
  _e('Not checked, you are using sendmail. If your experiencing email troubles we suggest you check the box and enter your SMTP info.', 'design-approval-system');
}
   ?>
<div class="smpt-form-wrap">
<label>
<?php  _e('SMTP Server') ?>
</label>
<input type="text" name="das-smtp-server" id="das-smtp-server" value="<?php echo get_option( 'das-smtp-server' ); ?>" placeholder="<?php  _e('mail.yourdomain.com or smtp.gmail.com etc.', 'design-approval-system') ?>">
<?php $dasSSLorTLSoption = get_option( 'das-settings-das-ssl-or-tls-option'); ?>
<label>
<?php  _e('SSL / TLS') ?>
</label>
<select id="das-settings-das-ssl-or-tls-option" name="das-settings-das-ssl-or-tls-option">
<option value="" <?php if ($dasSSLorTLSoption == '' ) echo 'selected="selected"'; ?>><?php echo('None'); ?></option>
<option value="ssl" <?php if ($dasSSLorTLSoption == 'ssl' ) echo 'selected="selected"'; ?>><?php echo('SSL'); ?></option>
<option value="tls" <?php if ($dasSSLorTLSoption == 'tls' ) echo 'selected="selected"'; ?>><?php echo('TLS'); ?></option>
</select>
<div class="clear"></div>
<label>
<?php  _e('SMTP Port') ?>
</label>
<input type="text" name="das-smtp-port" value="<?php echo get_option( 'das-smtp-port' ); ?>"  placeholder="<?php  _e('Typically port 465 for ssl and port 587 for tls', 'design-approval-system') ?>">
<label class="checkbox-label">
<?php  _e('SMTP Authenticate?') ?>
</label>
<input class="checkbox-input" type="checkbox" name="das-smtp-checkbox-authenticate" id="das-smtp-checkbox-authenticate" value="1" <?php echo checked( '1', get_option( 'das-smtp-checkbox-authenticate' ) ); ?>/>
<div class="clear"></div>
<label>
<?php  _e('Authenticate Username') ?>
</label>
<input type="text" name="das-smtp-authenticate-username" id="das-smtp-authenticate-username" value="<?php echo get_option( 'das-smtp-authenticate-username' ); ?>" placeholder="<?php  _e('example@yourdomain.com', 'design-approval-system') ?>">
<label>
<?php  _e('Authenticate Password') ?>
</label>
<input type="password" name="das-smtp-authenticate-password" id="das-smtp-authenticate-password" value="<?php echo get_option( 'das-smtp-authenticate-password' ); ?>">
<label></label>
<input type="submit" class="das-settings-admin-submit-btn" style="float:none; width:200px; margin-left:3px;" value="<?php _e('Save SMTP Settings', 'design-approval-system'); ?>">
<div class="clear"></div>
<br/>
<div class="das-custom-checkbox-wrap">
<div style="text-transform: none; font-weight: normal; ">
<p>
<?php _e('<strong>SEND TEST EMAIL USING BASIC SENDMAIL OR SMTP EMAIL SETTINGS</strong><ol class="smtp-check-list"><li>Make sure all settings have been saved.</li><li>To send a SMTP test email make sure you have the SMTP option checked and the settings filled out, otherwise it will send the test email using the default sendmail method.</li><li>The test email will be sent to the one you added in the Company Email Address field or the SMTP Authenticate Username field if you have checked the use SMTP checkbox.</li></ol>', 'design-approval-system') ?>
</p>
<?php $das_smtp_checkbox = get_option('das-settings-smtp'); ?>
<a href="javascript:;" id="send-email-settings-page-test" onclick="jQuery('#settingsTestEmail').ajaxSubmit({ target: '#output'}); return false;" class="smtp-test-email-send-button">
<?php _e('Send Test Email', 'design-approval-system') ?>
</a>
<div id="send-email-settings-page-test-done" style="display:none; border: 1px solid rgb(177, 245, 144);
color: rgb(0, 0, 0);
background: rgb(229, 255, 211);
padding-left: 15px;
text-align: left;" class="smtp-test-email-send-button"><strong>
<?php _e('SUCCESS:', 'design-approval-system'); ?>
</strong>
<?php _e('Your', 'design-approval-system'); ?>
<?php
	  //SMTP Authenticate?
	  if ($das_smtp_checkbox == '1') {
		  _e('SMTP Test Email has been sent to ', 'design-approval-system'); ?>
<a href="mailto:<?php echo get_option('das-smtp-authenticate-username'); ?>"><?php echo get_option('das-smtp-authenticate-username'); ?></a>
<?php
	  }
	  //SMTP Authenticate?
	  if (!$das_smtp_checkbox == '1') {
		 _e('Default Test Email has been sent to ', 'design-approval-system'); ?>
<a href="mailto:<?php echo get_option('das-settings-company-email'); ?>"><?php echo get_option('das-settings-company-email'); ?></a>.
<?php
		 _e('You may need to check your spam folder for the first email unless you use SMTP.', 'design-approval-system');
	  }?>
</div>
<div id="send-email-settings-page-test-error" style="display:none;border: 1px solid rgb(245, 144, 144); color: rgb(0, 0, 0); background: rgb(255, 211, 211);padding-left: 15px;
text-align: left;" class="smtp-test-email-send-button"></div>
</div>
</div>
</div>
<div class="clear"></div>
</div>
<!--/das-settings-admin-input-wrap-->

<h3>
<?php  _e('Email for Designer Message', 'design-approval-system') ?>
</h3>
<div class="subtext-of-title">
<?php  _e('These settings are for the email to your client, letting them know their design is ready to be reviewed.<br/>
      It also Includes a confirmation email to you the Designer too.', 'design-approval-system') ?>
</div>
<div class="das-settings-admin-input-wrap">
<div class="das-settings-admin-input-label">
<?php _e('Message to Client (optional):', 'design-approval-system') ?>
<a class="question4">?</a></div>
<textarea name="das-settings-email-for-designers-message-to-clients" class="das-settings-admin-input" id="das-settings-email-for-designers-message-to-clients"><?php echo get_option('das-settings-email-for-designers-message-to-clients'); ?></textarea>
<div class="das-settings-admin-input-example">
<?php  _e("*NOTE* If you do not fill this out the <a class='question4'>default text</a> will be used.", "design-approval-system") ?>
</div>
<div class="clear"></div>
<div class="das-settings-id-answer answer4">
<h4>
<?php _e('The default text for this field is:', 'design-approval-system') ?>
</h4>
<ul>
<li>
<?php _e('Please review your design comp for changes and/or errors:', 'design-approval-system') ?>
</li>
</ul>
<span>
<?php _e('Example of Email', 'design-approval-system') ?>
</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-designers-email.jpg" /> <a class="im-done">
<?php _e('close', 'design-approval-system') ?>
</a> </div>
<!--/das-settings-id-answer-->
<div class="clear"></div>
</div>
<!--/das-settings-admin-input-wrap-->

<h3>
<?php _e('Approved Digital Signature Email and Popup Message', 'design-approval-system') ?>
</h3>
<div class="subtext-of-title">
<?php _e('These settings are for the email to you, the designer, letting you know the client has approved the design. <br/>
      It also includes a confirmation email to your Client too.', 'design-approval-system') ?>
</div>
<div class="das-settings-admin-input-wrap">
<div class="das-settings-admin-input-label">
<?php _e('Message to Designer (optional):', 'design-approval-system') ?>
<a class="question5">
<?php _e('?', 'design-approval-system') ?>
</a></div>
<textarea name="das-settings-approved-dig-sig-message-to-designer" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-message-to-designer"><?php echo get_option('das-settings-approved-dig-sig-message-to-designer'); ?></textarea>
<div class="das-settings-admin-input-example">
<?php _e("*NOTE* If you do not fill this out the <a class='question5'>default text</a> will be used.", "design-approval-system") ?>
</div>
<div class="clear"></div>
<div class="das-settings-id-answer answer5">
<h4>
<?php _e('The default text for this field is:', 'design-approval-system') ?>
</h4>
<ul>
<li>
<?php _e("This design comp has been approved by the client. Please take the next appropriate step.", "design-approval-system") ?>
</li>
</ul>
<span>
<?php _e('Example of Email', 'design-approval-system') ?>
</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-designer.jpg" /> <a class="im-done">
<?php _e('close', 'design-approval-system') ?>
</a> </div>
<!--/das-settings-id-answer-->
<div class="clear"></div>
</div>
<!--/das-settings-admin-input-wrap-->

<div class="das-settings-admin-input-wrap">
<div class="das-settings-admin-input-label">
<?php _e('Message to Client (optional):', 'design-approval-system') ?>
<a class="question6">
<?php _e('?', 'design-approval-system') ?>
</a></div>
<textarea name="das-settings-approved-dig-sig-message-to-clients" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-message-to-clients"><?php echo get_option('das-settings-approved-dig-sig-message-to-clients'); ?></textarea>
<div class="das-settings-admin-input-example">
<?php _e("*NOTE* If you do not fill this out the <a class='question6'>default text</a> will be used.", "design-approval-system") ?>
</div>
<div class="clear"></div>
<div class="das-settings-id-answer answer6">
<h4>
<?php _e('The default text for this field is:', 'design-approval-system') ?>
</h4>
<ul>
<li>
<?php _e('Thank you for approving your design comp. We will now take the next steps in finalizing your project. Below is a confirmation of your submission.<br/>
            As the authorized decision maker of my firm I acknowledge that I have reviewed and approved the proposed design comps designed by [Your Company Name].', 'design-approval-system') ?>
</li>
</ul>
<span>
<?php _e('Example of Email', 'design-approval-system') ?>
</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-email.jpg" /> <a class="im-done">
<?php _e('close', 'design-approval-system') ?>
</a> </div>
<!--/das-settings-id-answer-->
<div class="clear"></div>
</div>
<!--/das-settings-admin-input-wrap-->

<div class="das-settings-admin-input-wrap">
<div class="das-settings-admin-input-label">
<?php _e('Thank You Message to Client after Digital Signature form is submitted (optional):', 'design-approval-system') ?>
<a class="question7">?</a></div>
<textarea name="das-settings-approved-dig-sig-thank-you" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-thank-you"><?php echo get_option('das-settings-approved-dig-sig-thank-you'); ?></textarea>
<div class="das-settings-admin-input-example">
<?php _e("*NOTE* If you do not fill this out the <a class='question7'>default text</a> will be used.", "design-approval-system") ?>
</div>
<div class="clear"></div>
<div class="das-settings-id-answer answer7">
<h4>
<?php _e('The default text for this field is:', 'design-approval-system') ?>
</h4>
<ul>
<li>
<?php _e('Thank you for approving your design comp. <br/>
            [Your Company Name] will now take the next steps in finalizing your project.', 'design-approval-system') ?>
</li>
</ul>
<span>
<?php _e('Example of Pop Up Meessage that appears when a client approves a design', 'design-approval-system') ?>
</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-popup.jpg" /> <a class="im-done">
<?php _e('close', 'design-approval-system') ?>
</a> </div>
<!--/das-settings-id-answer-->
<div class="clear"></div>
</div>
<!--/das-settings-admin-input-wrap-->

<?php if(is_plugin_active('das-premium/das-premium.php')) {
	include('../wp-content/plugins/das-premium/includes/das-changes-extension/admin/das-changes-extension-settings-page.php');
}?>
<h3>
<?php _e('Select User and Email Settings', 'design-approval-system') ?>
</h3>
<div class="subtext-of-title">
<?php _e('These settings are for the roles used to create the drop down selections on the post page. ("Designers Name", "Clients Name", "Clients Email")', 'design-approval-system') ?>
</div>
<div class="das-settings-admin-input-wrap">
<div class="das-settings-admin-input-label">
<?php _e('What role is used for', 'design-approval-system') ?>
<strong>
<?php _e('Designers', 'design-approval-system') ?>
</strong>?:</div>
<div class="das-settings-role-wrap">
<?php 
		
		$das_designer_role = get_option('das-settings-designer-role') ;
		
          global $wp_roles;
       	  $das_roles = get_editable_roles();     
		 
		 	echo '<select name="das-settings-designer-role" id="das-settings-designer-role">';

			echo '<option value="">- '.__('Please select the role used for Designers', 'design-approval-system').' -</option>';  
			
			 foreach ($das_roles as $role => $details) {
				echo '<option value="'.esc_attr($role).'"', $das_designer_role == esc_attr($role) ? 'selected="selected"':'','>'.$details['name'].'</option>';		
			  }
			echo '</select>';
?>
</div>
<div class="das-settings-admin-input-example">
<?php _e('NOTE: This field determines which wordpress users will be displayed under the drop down for picking the "Designers Name" on post page.', 'design-approval-system') ?>
</div>
<div class="clear"></div>
</div>
<!--/das-settings-admin-input-wrap-->

<div class="das-settings-admin-input-wrap">
<div class="das-settings-admin-input-label">
<?php _e('What role is used for', 'design-approval-system') ?>
<strong>
<?php _e('Clients', 'design-approval-system') ?>
</strong>?: </div>
<div class="das-settings-role-wrap">
<?php 
		$das_client_role = get_option('das-settings-client-role');
		
         global $wp_roles;
       	 $das_roles = get_editable_roles();     
		 
		 	echo '<select name="das-settings-client-role" id="das-settings-client-role">';

			echo '<option value="">- '.__('Please select the role used for Clients', 'design-approval-system').' -</option>';  
			
			 foreach ($das_roles as $role => $details) {
				echo '<option value="'.esc_attr($role).'"', $das_client_role == esc_attr($role) ? 'selected="selected"':'','>'.$details['name'].'</option>';		
			  }
			  
			echo '</select>';
?>
</div>
<div class="das-settings-admin-input-example">
<?php _e('NOTE: This field determines which wordpress users will be displayed under the drop down for picking the "Client Name" & "Client Email" on post page.') ?>
</div>
<div class="clear"></div>
</div>
<!--/das-settings-admin-input-wrap-->

<h3>
<?php _e('Create New Customer Email Message', 'design-approval-system') ?>
</h3>
<div class="subtext-of-title">
<?php _e('This area is for the email message to the DAS Client that comes from using the Custom front end registration form that creates new DAS Clients') ?>
</div>
<div class="das-settings-admin-input-wrap">
<div class="das-settings-admin-input-label">
<?php _e('Email Message', 'design-approval-system') ?>
</div>
<textarea name="das-settings-register-new-das-client" class="das-settings-admin-input" type="text" id="das-settings-register-new-das-client"><?php echo get_option('das-settings-register-new-das-client'); ?></textarea>
<div class="das-settings-admin-input-example">
<?php _e("If you do not fill this out the DAS Client will only receive the username and password", "design-approval-system") ?>
</div>
<div class="clear"></div>
</div>
<!--/das-settings-admin-input-wrap-->

<input type="submit" class="das-settings-admin-submit-btn" value="<?php _e('Save Changes', 'design-approval-system') ?>" />
</form>
<div class="das-settings-icon-wrap"><a href="https://www.facebook.com/SlickRemix" target="_blank" class="facebook-icon"></a><a class="das-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a></div>
</div>
<!--/das-settings-admin-wrap-->

<form class="myform" id="settingsTestEmail" method="post" action="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/form-processes/settings-page-test-email-process.php" name="settingsTestEmail">
<input type="hidden" value="<?php echo get_option('das-settings-company-name'); ?>" name="dasSettingsCompanyName" />
<input type="hidden" value="<?php echo get_option( 'das-smtp-authenticate-username' ); ?>" name="dasSettingsCompanyEmail" />
<input type="hidden" value="<?php echo get_option( 'das-settings-company-email' ); ?>" name="dasSettingsCompanyEmail" />
<!-- <input type="submit"/> -->
</form>
<div style="display:none" id="output"></div>
<?php } ?>