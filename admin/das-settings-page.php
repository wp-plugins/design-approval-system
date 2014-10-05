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
?>
<div class="das-settings-admin-wrap">
  <h2><?php _e('Design Approval System Settings', 'design-approval-system') ?></h2>
  <a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/design-approval-system/" target="_blank"><?php _e('Get Extensions Here!', 'design-approval-system') ?></a>
  <div class="use-of-plugin"><?php _e("Please fill out the settings below. If you don't understand what a field is for click the question mark next to that title.", "design-approval-system") ?></div>
  <h3><?php _e('COMPANY INFO', 'design-approval-system') ?></h3>
  <form method="post" class="das-settings-admin-form" action="options.php">
  
     <?php // get our registered settings from the gq theme functions 
	 	   settings_fields('design-approval-system-settings'); ?> 
    
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label"><?php _e('Company Logo (required)', 'design-approval-system') ?>: <a class="question1"><?php _e('?', 'design-approval-system') ?></a></div>
      <input id="das_default_theme_logo_image" name="das_default_theme_logo_image" class="das-settings-admin-input" type="text"  value="<?php echo get_option('das_default_theme_logo_image'); ?>" />
      <input id="das_logo_image_button" class="upload_image_button" type="button" value="<?php _e('Upload Image') ?>" />
      
      <div class="das-settings-admin-input-example upload-logo-size"><?php _e('This logo will be displayed at the top of all your design posts. Size for the "default" template is 124px X 20px.', 'design-approval-system') ?></div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer1">
        <ul>
          <li><?php _e('Your logo will be placed at the left right of the page.', 'design-approval-system') ?></li>
        </ul>
        <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/admin-help-logo.jpg" alt="Header Logo Example" /> <a class="im-done"><?php _e('close', 'design-approval-system') ?></a> </div>
      <!--/das-settings-id-answer-->
      
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label"><?php _e('Company Name (required)', 'design-approval-system') ?></div>
      <input name="das-settings-company-name" class="das-settings-admin-input" type="text" id="das-settings-company-name" value="<?php echo get_option('das-settings-company-name'); ?>" />
      <div class="das-settings-admin-input-example"><?php _e('This is used when sending emails to a client, and will also appear on the approval form too.') ?></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label"><?php _e('Company Email Address (required)', 'design-approval-system') ?></div>
      <input name="das-settings-company-email" class="das-settings-admin-input" type="text" id="das-settings-company-email" value="<?php echo get_option('das-settings-company-email'); ?>" />
      <div class="das-settings-admin-input-example"><?php _e('This is required to send emails to a client through our system', 'design-approval-system') ?></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
     <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label"><?php _e('Should Users be logged in to Approve Designs?', 'design-approval-system') ?></div>
     
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
      
      <div class="das-custom-checkbox-wrap"><?php _e('<strong>NOTE:</strong> If you check this option on each design post you will have to manually add the Signature and select Yes to approve the design so a star will appear on the project board, if you want to. This is a good option if you are just trying to get something approved quicky without the hassle of creating users for your clients.', 'design-approval-system') ?></div>
     
     
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    
    
   <?php if(is_plugin_active('das-changes-extension/das-changes-extension.php')) { ?> 
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label"><?php _e('Should Users be logged in to Make Change Requests?', 'design-approval-system') ?></div>
     
      <input name="das-settings-changes-login-overide" class="das-settings-admin-input fleft" type="checkbox" id="das-settings-changes-login-overide" value="1" <?php checked( '1', get_option( 'das-settings-changes-login-overide' ) ); ?> /> 
      <?php 
	   $changesLoginOveride = get_option( 'das-settings-changes-login-overide' );
		
if ($changesLoginOveride == '1') {
  _e('Checked, you are not requiring clients to login before Making Change Requests.', 'design-approval-system');
}
else	{
  _e('Not checked, you are requiring clients to login before Making Change Requests.', 'design-approval-system');
}

?>  
      
      <div class="das-custom-checkbox-wrap"><?php _e('<strong>NOTE:</strong> If you check this option you will have to manually add the comments to each design post from your email then the comments will appear on the project board and front end. This is a good option if you just want to get comments submitted quickly and don\'t want to create users for you clients. ', 'design-approval-system') ?></div>
     
     
    </div>
    <!--/das-settings-admin-input-wrap-->
    <?php } ?>
    
    
    
    
   
    
    <div class="das-settings-admin-input-wrap company-info-style ">
   <div class="das-settings-admin-input-label"><?php _e('SMTP Settings. Need Help or having problems connecting?', 'design-approval-system') ?> <a href="http://www.slickremix.com/docs/gmail-or-server-smtp-setup/" target="_blank"><?php _e('See Instructions', 'design-approval-system') ?></a></div>
      <div class="das-settings-admin-input-label das-smtp-custom"<?php _e('Send emails using SMTP', 'design-approval-system') ?>><!--<a class="question7">?</a>--></div>

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
   
   <label><?php  _e('SMTP Server') ?></label>
   <input type="text" name="das-smtp-server" id="das-smtp-server" value="<?php echo get_option( 'das-smtp-server' ); ?>" placeholder="<?php  _e('mail.yourdomain.com or smtp.gmail.com etc.', 'design-approval-system') ?>">
  
   <?php $dasSSLorTLSoption = get_option( 'das-settings-das-ssl-or-tls-option'); ?>
   <label><?php  _e('SSL / TLS') ?></label>
   <select id="das-settings-das-ssl-or-tls-option" name="das-settings-das-ssl-or-tls-option">
            <option value="" <?php if ($dasSSLorTLSoption == '' ) echo 'selected="selected"'; ?>><?php echo('None'); ?></option>
            <option value="ssl" <?php if ($dasSSLorTLSoption == 'ssl' ) echo 'selected="selected"'; ?>><?php echo('SSL'); ?></option>
            <option value="tls" <?php if ($dasSSLorTLSoption == 'tls' ) echo 'selected="selected"'; ?>><?php echo('TLS'); ?></option>
   </select>
   <div class="clear"></div>
   
   <label><?php  _e('SMTP Port') ?></label>
   <input type="text" name="das-smtp-port" value="<?php echo get_option( 'das-smtp-port' ); ?>"  placeholder="<?php  _e('Typically port 465 for ssl and port 587 for tls', 'design-approval-system') ?>">
   
   <label class="checkbox-label"><?php  _e('SMTP Authenticate?') ?></label>
   <input class="checkbox-input" type="checkbox" name="das-smtp-checkbox-authenticate" id="das-smtp-checkbox-authenticate" value="1" <?php echo checked( '1', get_option( 'das-smtp-checkbox-authenticate' ) ); ?>/>
   <div class="clear"></div>
   <label><?php  _e('Authenticate Username') ?></label>
   <input type="text" name="das-smtp-authenticate-username" id="das-smtp-authenticate-username" value="<?php echo get_option( 'das-smtp-authenticate-username' ); ?>" placeholder="<?php  _e('example@yourdomain.com', 'design-approval-system') ?>">
   
   <label><?php  _e('Authenticate Password') ?></label>
   <input type="password" name="das-smtp-authenticate-password" id="das-smtp-authenticate-password" value="<?php echo get_option( 'das-smtp-authenticate-password' ); ?>">
 
   <label></label><input type="submit" class="das-settings-admin-submit-btn" style="float:none; width:200px; margin-left:3px;" value="Save SMTP Settings">
   <div class="clear"></div>
   <br/>
   <div class="das-custom-checkbox-wrap">
   
   
   <div style="text-transform: none; font-weight: normal; "><p><?php _e('<strong>SEND TEST EMAIL USING BASIC SENDMAIL OR SMTP EMAIL SETTINGS</strong><ol class="smtp-check-list"><li>Make sure all settings have been saved.</li><li>To send a SMTP test email make sure you have the SMTP option checked and the settings filled out, otherwise it will send the test email using the default sendmail method.</li><li>The test email will be sent to the one you added in the Company Email Address field or the SMTP Authenticate Username field if you have checked the use SMTP checkbox.</li></ol>', 'design-approval-system') ?> </p>
   
<?php $das_smtp_checkbox = get_option('das-settings-smtp'); ?>
    <a href="javascript:;" id="send-email-settings-page-test" onclick="jQuery('#settingsTestEmail').ajaxSubmit({ target: '#output'}); return false;" class="smtp-test-email-send-button"><?php _e('Send Test Email', 'design-approval-system') ?></a>
    <div id="send-email-settings-page-test-done" style="display:none; border: 1px solid rgb(177, 245, 144);
color: rgb(0, 0, 0);
background: rgb(229, 255, 211);
padding-left: 15px;
text-align: left;" class="smtp-test-email-send-button"><strong>SUCCESS:</strong> Your <?php
	  //SMTP Authenticate?
	  if ($das_smtp_checkbox == '1') {
		 echo 'SMTP Test Email has been sent to '?>
		 <a href="mailto:<?php echo get_option('das-smtp-authenticate-username'); ?>"><?php echo get_option('das-smtp-authenticate-username'); ?></a> <?php
	  }
	  //SMTP Authenticate?
	  if (!$das_smtp_checkbox == '1') {
		 echo 'Default Test Email has been sent to '; ?>
		 <a href="mailto:<?php echo get_option('das-settings-company-email'); ?>"><?php echo get_option('das-settings-company-email'); ?></a>. <?php
		 echo 'You may need to check your spam folder for the first email unless you use SMTP.';
	  }?></div>
    
    
    <div id="send-email-settings-page-test-error" style="display:none;border: 1px solid rgb(245, 144, 144); color: rgb(0, 0, 0); background: rgb(255, 211, 211);padding-left: 15px;
text-align: left;" class="smtp-test-email-send-button"></div>
    
    </div>
   </div></div>
   			
   
   
          
  			
<div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
 
    <h3><?php  _e('Email for Designer Message', 'design-approval-system') ?></h3>
    <div class="subtext-of-title"><?php  _e('These settings are for the email to your client, letting them know their design is ready to be reviewed.<br/>
      It also Includes a confirmation email to you the Designer too.', 'design-approval-system') ?></div>
    <div class="das-settings-admin-input-wrap">
      <div class="das-settings-admin-input-label"><?php _e('Message to Client (optional):', 'design-approval-system') ?> <a class="question4">?</a></div>
      <textarea name="das-settings-email-for-designers-message-to-clients" class="das-settings-admin-input" id="das-settings-email-for-designers-message-to-clients"><?php echo get_option('das-settings-email-for-designers-message-to-clients'); ?></textarea>
      <div class="das-settings-admin-input-example"><?php  _e("*NOTE* If you do not fill this out the <a class='question4'>default text</a> will be used.", "design-approval-system") ?></div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer4">
        <h4><?php _e('The default text for this field is:', 'design-approval-system') ?></h4>
        <ul>
          <li><?php _e('Please review your design comp for changes and/or errors:', 'design-approval-system') ?></li>
        </ul>
        <span><?php _e('Example of Email', 'design-approval-system') ?></span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-designers-email.jpg" /> <a class="im-done"><?php _e('close', 'design-approval-system') ?></a> </div>
      <!--/das-settings-id-answer-->
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <h3><?php _e('Approved Digital Signature Email and Popup Message', 'design-approval-system') ?></h3>
    <div class="subtext-of-title"><?php _e('These settings are for the email to you, the designer, letting you know the client has approved the design. <br/>
      It also includes a confirmation email to your Client too.', 'design-approval-system') ?></div>
    <div class="das-settings-admin-input-wrap">
      <div class="das-settings-admin-input-label"><?php _e('Message to Designer (optional):', 'design-approval-system') ?> <a class="question5"><?php _e('?', 'design-approval-system') ?></a></div>
      <textarea name="das-settings-approved-dig-sig-message-to-designer" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-message-to-designer"><?php echo get_option('das-settings-approved-dig-sig-message-to-designer'); ?></textarea>
      <div class="das-settings-admin-input-example"><?php _e("*NOTE* If you do not fill this out the <a class='question5'>default text</a> will be used.", "design-approval-system") ?></div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer5">
        <h4><?php _e('The default text for this field is:', 'design-approval-system') ?></h4>
        <ul>
          <li><?php _e("This design comp has been approved by the client. Please take the next appropriate step.", "design-approval-system") ?></li>
        </ul>
        <span><?php _e('Example of Email', 'design-approval-system') ?></span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-designer.jpg" /> <a class="im-done"><?php _e('close', 'design-approval-system') ?></a> </div>
      <!--/das-settings-id-answer-->
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap">
      <div class="das-settings-admin-input-label"><?php _e('Message to Client (optional):', 'design-approval-system') ?> <a class="question6"><?php _e('?', 'design-approval-system') ?></a></div>
      <textarea name="das-settings-approved-dig-sig-message-to-clients" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-message-to-clients"><?php echo get_option('das-settings-approved-dig-sig-message-to-clients'); ?></textarea>
      <div class="das-settings-admin-input-example"><?php _e("*NOTE* If you do not fill this out the <a class='question6'>default text</a> will be used.", "design-approval-system") ?></div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer6">
        <h4><?php _e('The default text for this field is:', 'design-approval-system') ?></h4>
        <ul>
          <li><?php _e('Thank you for approving your design comp. We will now take the next steps in finalizing your project. Below is a confirmation of your submission.<br/>
            As the authorized decision maker of my firm I acknowledge that I have reviewed and approved the proposed design comps designed by [Your Company Name].', 'design-approval-system') ?></li>
        </ul>
        <span><?php _e('Example of Email', 'design-approval-system') ?></span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-email.jpg" /> <a class="im-done"><?php _e('close', 'design-approval-system') ?></a> </div>
      <!--/das-settings-id-answer-->
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap">
      <div class="das-settings-admin-input-label"><?php _e('Thank You Message to Client after Digital Signature form is submitted (optional):', 'design-approval-system') ?> <a class="question7">?</a></div>
      <textarea name="das-settings-approved-dig-sig-thank-you" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-thank-you"><?php echo get_option('das-settings-approved-dig-sig-thank-you'); ?></textarea>
      <div class="das-settings-admin-input-example"><?php _e("*NOTE* If you do not fill this out the <a class='question7'>default text</a> will be used.", "design-approval-system") ?></div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer7">
        <h4><?php _e('The default text for this field is:', 'design-approval-system') ?></h4>
        <ul>
          <li><?php _e('Thank you for approving your design comp. <br/>
            [Your Company Name] will now take the next steps in finalizing your project.', 'design-approval-system') ?></li>
        </ul>
        <span><?php _e('Example of Pop Up Meessage that appears when a client approves a design', 'design-approval-system') ?></span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-popup.jpg" /> <a class="im-done"><?php _e('close', 'design-approval-system') ?></a> </div>
      <!--/das-settings-id-answer-->
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <?php if(is_plugin_active('das-changes-extension/das-changes-extension.php')) {
	include('../wp-content/plugins/das-changes-extension/admin/das-changes-extension-settings-page.php');
}?>
	
    <?php if(is_plugin_active('das-roles-extension/das-roles-extension.php')) {
		include('../wp-content/plugins/das-roles-extension/admin/das-roles-extension-settings-page.php');
}?>
 
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
</form><div style="display:none" id="output"></div>
<?php } ?>