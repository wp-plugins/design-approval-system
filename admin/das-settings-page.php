<?php
/*
	This is file is for creating the options page for Wordpress's backend
*/

//Adds upload button and script to setting page
function das_settings_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', ''.plugins_url( 'admin/js/das-settings-page-image-uploader.js' , dirname(__FILE__) ).'', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}
function das_settings_admin_styles() {
	wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) && $_GET['page'] == 'design-approval-system-settings-page') {
  add_action('admin_print_scripts', 'das_settings_admin_scripts');
  add_action('admin_print_styles', 'das_settings_admin_styles');
}

//Main setting page function
function das_settings_page() {
?>
<link rel="stylesheet" id="das-settings-admin-css" href="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/css/admin-settings.css" type="text/css" media="all">

<div class="das-settings-admin-wrap">
  <h2>Design Approval System Settings</h2>
  <a class="buy-extensions-btn" href="http://www.slickremix.com/product-category/design-approval-system-extensions/" target="_blank">Get Extensions Here!</a>
  <div class="use-of-plugin">Please fill out the settings below. If you don't understand what a field is for please click question mark at end of label.</div>
  <h3>COMPANY INFO</h3>
  <form method="post" class="das-settings-admin-form" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label">Company Logo (required): <a class="question1">?</a></div>
      <input id="image_1" name="image_1" class="das-settings-admin-input" type="text"  value="<?php echo get_option('image_1'); ?>" />
      <input id="_btn" class="upload_image_button" type="button" value="Upload Image" />
      <div class="das-settings-admin-input-example upload-logo-size">This logo will be displayed at the top of all your design posts. Size for the "defualt" template is 124px X 20px. <?php if(is_plugin_active('das-clean-theme/das-clean-theme.php')) {?>If You are using the "Clean Theme" the size for the logo has to be 155px X 135px.<?php }?></div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer1">
        <ul>
          <li>Your logo will be placed at the left right of the page.</li>
        </ul>
        <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/admin-help-logo.jpg" width="857" height="133" alt="Header Logo Example" /> <a class="im-done">close</a> </div>
      <!--/das-settings-id-answer-->
      
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label">Company Name (required)</div>
      <input name="das-settings-company-name" class="das-settings-admin-input" type="text" id="das-settings-company-name" value="<?php echo get_option('das-settings-company-name'); ?>" />
      <div class="das-settings-admin-input-example">This is used when sending emails to a client, and will also appear on the approval form too.</div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label">Company Email Address (required)</div>
      <input name="das-settings-company-email" class="das-settings-admin-input" type="text" id="das-settings-company-email" value="<?php echo get_option('das-settings-company-email'); ?>" />
      <div class="das-settings-admin-input-example">This is required to send emails to a client through our system</div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap company-info-style ">
      <div class="das-settings-admin-input-label das-smtp-custom">Send emails using SMTP<!--<a class="question7">?</a>--></div>

      <input name="das-settings-smtp" class="das-settings-admin-input" type="checkbox"  id="das-settings-smtp" value="1" <?php checked( '1', get_option( 'das-settings-smtp' ) ); ?>/>
  <?php    
 
     $smtp_checked =  get_option( 'das-settings-smtp' );
		
if ($smtp_checked == '1') {
 echo "Checked, you are now using SMTP to send emails. You must contact your host provider if you are unsure of the settings to enter.";
}
else	{
  echo "Not checked, you are using sendmail. If your experiencing email troubles we suggest you check the box and enter your SMTP info.";
}
   ?>
  
   <div class="smpt-form-wrap">
   <label>SMTP Server</label>
   <input type="text" name="das-smtp-server" id="das-smtp-server" value="<?php echo get_option( 'das-smtp-server' ); ?>" placeholder="mail.yourdomain.com">
   
   <label>SMTP Port</label>
   <input type="text" name="das-smtp-port" value="<?php echo get_option( 'das-smtp-port' ); ?>"  placeholder="26 is usually the default SMPT port">
   
   <label class="checkbox-label">SMTP Authenticate?</label>
   <input class="checkbox-input" type="checkbox" name="das-smtp-checkbox-authenticate" id="das-smtp-checkbox-authenticate" value="1" <?php echo checked( '1', get_option( 'das-smtp-checkbox-authenticate' ) ); ?>/>
   
   <label>Authenticate Username</label>
   <input type="text" name="das-smtp-authenticate-username" id="das-smtp-authenticate-username" value="<?php echo get_option( 'das-smtp-authenticate-username' ); ?>" placeholder="example@yourdomain.com">
   
   <label>Authenticate Password</label>
   <input type="password" name="das-smtp-authenticate-password" id="das-smtp-authenticate-password" value="<?php echo get_option( 'das-smtp-authenticate-password' ); ?>">
   </div>
   
     <p><strong>NOTE:</strong> If you check SMTP authenticate and enter your username or password incorrectly the form will not submit and show Thank-You message, letting you know your information is incorrect. You should test this before allowing clients to use your Design Approval System.</p>
     <p>There are many things that can go wrong with sending mail through SMTP and most of the problems come from permission issues.</p>
     <ul>
 <li>1. Does your Host have permission to relay through the SMTP Host?</li>
 <li>2. Does your host require POP before SMTP?</li>
 <li>3. Does your Host require SMTP authentication?</li>
 <li>4. Are your SMTP settings correct for the remote host username / password?</li>
</ul>

<div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->

<?php if(is_plugin_active('das-clean-theme/das-clean-theme.php')) {
   include('../wp-content/plugins/das-clean-theme/admin/das-clean-theme-settings-page.php');
}?>
    
    <h3>Email for Designer Message</h3>
    <div class="subtext-of-title">These settings are for the email to your client, letting them know their design is ready to be reviewed.<br/>
      It also Includes a confirmation email to you the Designer too.</div>
    <div class="das-settings-admin-input-wrap">
      <div class="das-settings-admin-input-label">Message to Client (optional): <a class="question4">?</a></div>
      <textarea name="das-settings-email-for-designers-message-to-clients" class="das-settings-admin-input" id="das-settings-email-for-designers-message-to-clients"><?php echo get_option('das-settings-email-for-designers-message-to-clients'); ?></textarea>
      <div class="das-settings-admin-input-example">*NOTE* If you do not fill this out the <a class="question4">default text</a> will be used.</div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer4">
        <h4>The default text for this field is:</h4>
        <ul>
          <li>Please review your design comp for changes and/or errors:</li>
        </ul>
        <span>Example of Email</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-designers-email.jpg" width="857" height="189" /> <a class="im-done">close</a> </div>
      <!--/das-settings-id-answer-->
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <h3>Approved Digital Signature Email and Popup Message</h3>
    <div class="subtext-of-title">These settings are for the email to  you, the designer, letting you know the client has approved the design. <br/>
      It also Includes a confirmation email to your Client too.</div>
    <div class="das-settings-admin-input-wrap">
      <div class="das-settings-admin-input-label">Message to Designer (optional): <a class="question5">?</a></div>
      <textarea name="das-settings-approved-dig-sig-message-to-designer" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-message-to-designer"><?php echo get_option('das-settings-approved-dig-sig-message-to-designer'); ?></textarea>
      <div class="das-settings-admin-input-example">*NOTE* If you do not fill this out the <a class="question5">default text</a> will be used.</div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer5">
        <h4>The default text for this field is:</h4>
        <ul>
          <li>This design comp has been approved by the client. Please take the next appropriate step.</li>
        </ul>
        <span>Example of Email</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-designer.jpg" width="857" height="189" /> <a class="im-done">close</a> </div>
      <!--/das-settings-id-answer-->
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap">
      <div class="das-settings-admin-input-label">Message to Client (optional): <a class="question6">?</a></div>
      <textarea name="das-settings-approved-dig-sig-message-to-clients" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-message-to-clients"><?php echo get_option('das-settings-approved-dig-sig-message-to-clients'); ?></textarea>
      <div class="das-settings-admin-input-example">*NOTE* If you do not fill this out the <a class="question6">default text</a> will be used.</div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer6">
        <h4>The default text for this field is:</h4>
        <ul>
          <li>Thank you for approving your design comp. We will now take the next steps in finalizing your project. Below is a confirmation of your submission.<br/>
            As the authorized decision maker of my firm I acknowledge that I have reviewed and approved the proposed design comps designed by [Your Company Name].</li>
        </ul>
        <span>Example of Email</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-email.jpg" width="857" height="301" /> <a class="im-done">close</a> </div>
      <!--/das-settings-id-answer-->
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap">
      <div class="das-settings-admin-input-label">Thank You Message to Client after Digital Signature form is submitted (optional): <a class="question7">?</a></div>
      <textarea name="das-settings-approved-dig-sig-thank-you" class="das-settings-admin-input" type="text" id="das-settings-approved-dig-sig-thank-you"><?php echo get_option('das-settings-approved-dig-sig-thank-you'); ?></textarea>
      <div class="das-settings-admin-input-example">*NOTE* If you do not fill this out the <a class="question7">default text</a> will be used.</div>
      <div class="clear"></div>
      <div class="das-settings-id-answer answer7">
        <h4>The default text for this field is:</h4>
        <ul>
          <li>Thank you for approving your design comp. <br/>
            [Your Company Name] will now take the next steps in finalizing your project.</li>
        </ul>
        <span>Example of Pop Up Meessage that appears when a client approves a design</span> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/images/how-to/help-approval-popup.jpg" width="857" height="301" /> <a class="im-done">close</a> </div>
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

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="image_1, das-settings-company-name, das-settings-company-email, das-settings-smtp, das-smtp-server, das-smtp-port, das-smtp-checkbox-authenticate, das-smtp-authenticate-username, das-smtp-authenticate-password, <?php if(is_plugin_active('das-clean-theme/das-clean-theme.php')) {?>image_2,<?php }?> das-settings-email-for-designers-message-to-clients, das-settings-approved-dig-sig-message-to-designer, das-settings-approved-dig-sig-message-to-clients, das-settings-approved-dig-sig-thank-you<?php if(is_plugin_active('das-changes-extension/das-changes-extension.php')) {?>, das-settings-design-requests-message-to-designer, das-settings-design-requests-message-to-clients, das-settings-design-requests-thank-you, das-settings-add-design-requests-message-to-designer, das-settings-add-design-requests-message-to-clients, <?php }?> <?php if(is_plugin_active('das-roles-extension/das-roles-extension.php')) {?> das-settings-designer-role, das-settings-client-role <?php }?>" />
    <input type="submit" class="das-settings-admin-submit-btn" value="<?php _e('Save Changes') ?>" />
  </form>
  <div class="das-settings-facebook-btn"> 
  	<div class="fb-like" data-href="http://www.facebook.com/DesignApprovalSystem" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false"></div>
  </div><!--/das-settings-facebook-btn-->

  <div class="das-settings-paypal-btn">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="ATNELFK553MBQ">
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
  </div><!--/das-settings-Paypal-btn-->

  <a class="das-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a> </div>
<!--/das-settings-admin-wrap--> 
<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/js/admin.js"></script>

<?php if(is_plugin_active('das-clean-theme/das-clean-theme.php')) {?>
   <script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/das-clean-theme/admin/js/admin.js"></script>
<?php }?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=207730929318208";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php

	include('walkthrough/walkthrough.php');	

}
?>