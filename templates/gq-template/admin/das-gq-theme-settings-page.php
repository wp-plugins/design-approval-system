<?php
//Main setting page function
function das_gq_theme_settings_page() {
	 
	$dasPremiumCheck = 'das-premium/das-premium.php';
    $dasPremiumActive = is_plugin_active($dasPremiumCheck); ?>
    
<div class="das-main-template-wrapper-all">
<div class="das-settings-admin-wrap" id="theme-settings-wrap">
  <h2><?php _e('Template Settings', 'design-approval-system'); ?></h2>
  <div class="use-of-plugin">
    <p><?php _e('These settings are for the front end design template where your customer can approve the design etc.', 'design-approval-system'); ?></p>
  </div>
  
  <form method="post" class="das-settings-admin-form" action="options.php">
  
    <?php // get our registered settings from the gq theme functions 
		  settings_fields('das-gq-settings'); ?> 
    
    
     <!-- custom option for padding -->
    <div class="das-gq-theme-settings-admin-input-wrap company-info-style das-gq-theme-turn-on-custom-colors das-settings-admin-input-wrap company-info-style">
      <div class="das-gq-theme-settings-admin-input-label das-gq-theme-wp-header-custom"><p class="special"><?php _e('Check the box to turn ON the custom padding option for the Design Template. This will make it so the menu and content fits nicely within your website, if it does not already. Simply define the numbers to suite your desired spacing. Here is how it works. 25px 20px 25px 30px. Lets break it down now. 25px = top padding, 20px = right padding, 25px = bottom padding and 30px = left padding. <br/><br/>The same idea applies to the margin option. However, if you set a Max-Width for the Main Design Template Wrapper too we can add auto to the left and right margin so the frame will be positioned in the middle of the screen. Give it a try, re-type check the box and add in the text you see in the inputs below and click the Save Changes button to see what happens.', 'design-approval-system'); ?></p></div>
    <p>
        <input name="das-gq-theme-options-settings-custom-css-main-wrapper-padding" class="das-gq-theme-settings-admin-input" type="checkbox"  id="das-gq-theme-options-settings-custom-css-main-wrapper-padding" value="1" <?php echo checked( '1', get_option( 'das-gq-theme-options-settings-custom-css-main-wrapper-padding' ) ); ?>/>
        <?php  
                        if (get_option( 'das-gq-theme-options-settings-custom-css-main-wrapper-padding' ) == '1') {
                          _e('<strong>Checked:</strong> Custom style options being used now.', 'design-approval-system');
                        }
                        else	{
                          _e('<strong>Not Checked:</strong> You are using the default styles.', 'design-approval-system');
                        }
                           ?>
       </p>  <p>
        <label><?php _e('Padding:', 'design-approval-system'); ?></label>
        <input name="das-gq-theme-main-wrapper-padding-input" class="das-gq-theme-settings-admin-input" type="text"  id="das-gq-theme-main-wrapper-padding-input" placeholder="25px 20px 25px 30px " value="<?php echo get_option('das-gq-theme-main-wrapper-padding-input'); ?>" title="Only Numbers and px are allowed"/>
      </p>
     <p>
        <label><?php _e('Max-Width:', 'design-approval-system'); ?></label>
        <input name="das-gq-theme-main-wrapper-width-input" class="das-gq-theme-settings-admin-input" type="text"  id="das-gq-theme-main-wrapper-width-input" placeholder="970px" value="<?php echo get_option('das-gq-theme-main-wrapper-width-input'); ?>" title="Only Numbers and px are allowed"/>
      </p>
      <p>
        <label><?php _e('Margin:', 'design-approval-system'); ?></label>
        <input name="das-gq-theme-main-wrapper-margin-input" class="das-gq-theme-settings-admin-input" type="text"  id="das-gq-theme-main-wrapper-margin-input" placeholder="20px auto 25px auto" value="<?php echo get_option('das-gq-theme-main-wrapper-margin-input'); ?>" title="Only Numbers and px are allowed"/>
      </p><br/>
       <p>
        <input name="das-gq-theme-options-settings-custom-css-first" class="das-gq-theme-settings-admin-input" type="checkbox"  id="das-gq-theme-options-settings-custom-css-first" value="1" <?php echo checked( '1', get_option( 'das-gq-theme-options-settings-custom-css-first' ) ); ?>/>
        <?php  
                        if (get_option( 'das-gq-theme-options-settings-custom-css-first' ) == '1') {
                            _e('<strong>Checked:</strong> Custom CSS option is being used now.', 'design-approval-system');
                        }
                        else	{
                           _e('<strong>Not Checked:</strong> You are using the default CSS.', 'design-approval-system');
                        }
                           ?>
       </p>
       <p>
         <label class="toggle-custom-textarea-show"><span><?php _e('Show', 'design-approval-system'); ?></span><span class="toggle-custom-textarea-hide"><?php _e('Hide', 'design-approval-system'); ?></span> <?php _e('custom CSS', 'design-approval-system'); ?></label>
       <div class="das-custom-css-text"><?php _e('<p>If you want to hide all but the design and options then copy and paste the first line below into the CSS input box. The header, footer and nav css below should hide most themes elements, if not you may need to look at the design page source code to pinpoint the id or class to hide the header etc.<p>

<p>header, #header nav, .nav-primary, footer, #footer { display:none; } /* this hides the themes header, footer and nav so you can just see the design and the options. */</p>

.das-custom-upload { display:none; } /* hide the add media button. */', 'design-approval-system'); ?></div>

      <textarea name="das-gq-theme-main-wrapper-css-input" class="das-gq-theme-settings-admin-input" id="das-gq-theme-main-wrapper-css-input"><?php echo get_option('das-gq-theme-main-wrapper-css-input'); ?></textarea>
      </p>
      <div class="clear"></div>
     
     
     <?php $das_premium = is_plugin_active('das-premium/das-premium.php'); ?>

    </div>
    <!--/das-gq-theme-settings-admin-input-wrap-->
    
    
   	
      <h3><?php _e('Media Upload Button Option', 'design-approval-system'); ?></h3>
    <div class="das-settings-admin-input-wrap company-info-style"> 
   
       <p class="special"><?php _e('Click the checkbox to add a Media upload button to the Wordpress Comments form or the Client Changes form. With this checked Clients can upload images, pdfs or zips. Clients will not see your whole media library, only the items they upload to their design post.', 'design-approval-system'); ?><br/><br/>
      <?php if(isset($das_premium) && $das_premium == true) { ?>
      <input name="das-gq-theme-hide-media-button-checkbox" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-hide-media-button-checkbox" value="1" <?php checked( '1', get_option( 'das-gq-theme-hide-media-button-checkbox' ) ); ?> /> 
      <?php 
	   $clientChangesActive = get_option( 'das-gq-theme-hide-media-button-checkbox' );
		
		if ($clientChangesActive == '1') {
		  _e('Checked, Media button in use', 'design-approval-system');
		}
		else	{
		  _e('Not checked, Media button is NOT being used', 'design-approval-system');
		}

?>  

    
 <?php  } else { ?>
	 <input name="das-gq-theme-client-changes-global" class="das-settings-admin-input fleft das-premium-required" type="checkbox" id="das-gq-theme-client-changes-global" value="1" disabled="disabled" /> 
 <?php _e('Premium Plugin Required to use this option', 'design-approval-system'); } ?>     </p>
<div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    
     <h3><?php _e('Project Board Options', 'design-approval-system'); ?></h3>
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label"><?php _e("Add a Project Board button to the GQ Templates Menu", 'design-approval-system'); ?></div>
      <p class="special">
        <input name="das-gq-theme-settings-project-board-btn" class="das-settings-admin-input" type="checkbox"  id="das-gq-theme-settings-project-board-btn" value="1" <?php echo checked( '1', get_option( 'das-gq-theme-settings-project-board-btn' ) ); ?>/>
        <?php    
 
		
if (get_option( 'das-gq-theme-settings-project-board-btn' ) == '1') {
   _e('<strong>Checked:</strong> Project Board Button has been added', 'design-approval-system');
}
else	{
  _e('<strong>Not Checked:</strong> Project Board Menu Button is OFF.', 'design-approval-system');
}
   ?>
      </p>
      <div class="clear"></div>
      <a class="das-gq-theme-settings-toggle" href="#"></a>
      <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/project-board-btn.png" alt="" /></div>
      <!--/das-settings-id-answer-->
      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label"><?php _e('Add a Custom Project Board Link', 'design-approval-system');?></div>
      <input name="das-gq-theme-settings-project-board-btn-link" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-project-board-btn-link" value="<?php echo get_option('das-gq-theme-settings-project-board-btn-link'); ?>" />
      <div class="das-settings-admin-input-example"><?php _e('Place a link here for the page or post you placed the shortcode [DASFrontEndManager] on. In our example we made a page called Project Board in wordpress, so this would be our link to the page, <strong>http://your-domain-here.com/project-board/</strong>. You must put the whole url in.', 'design-approval-system'); ?>
      </div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    
    <div class="das-settings-admin-input-wrap company-info-style">
      <div class="das-settings-admin-input-label"><?php _e('Custom Project Button Title', 'design-approval-system');?></div>
      <input name="das-gq-theme-settings-project-board-btn-custom-name" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-project-board-btn-custom-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-settings-singular-pb-fep-name') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
      <div class="das-settings-admin-input-example"><?php _e('If you leave this blank the button will be called Project Board', 'design-approval-system'); ?>
     
      </div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    
    
    
    <h3><?php _e('Terms &amp; Conditions Text and Popup Option', 'design-approval-system'); ?></h3>
    <div class="das-settings-admin-input-wrap company-info-style">
    
         <p class="special"><?php _e('Add any terms and conditions for your clients here. A terms button will appear on the Design Template if you fill this out and when a client goes to approve the design a checkbox will appear for them to check as well. This is for all design posts.', 'design-approval-system');?>
        </p> <p><label class="toggle-custom-textarea-show-terms"><span><?php _e('Show', 'design-approval-system'); ?></span><span class="toggle-custom-textarea-hide-terms"><?php _e('Hide', 'design-approval-system'); ?></span> <?php _e('Text', 'design-approval-system'); ?></label></p>
      <textarea name="das-gq-theme-main-wrapper-custom-terms" class="das-gq-theme-settings-admin-input" id="das-gq-theme-main-wrapper-custom-terms"><?php echo get_option('das-gq-theme-main-wrapper-custom-terms'); ?></textarea>
      <div class="clear"></div>
      
     <p class="special"><?php _e('If you check this option everytime you go to a design post the terms popup will always come up first so your clients understand right away your terms and conditions.', 'design-approval-system') ?><br/><br/>
     
      <input name="das-gq-theme-terms-popup-global" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-terms-popup-global" value="1" <?php checked( '1', get_option( 'das-gq-theme-terms-popup-global' ) ); ?> /> 
      <?php 
	   $termsPopupActive = get_option( 'das-gq-theme-terms-popup-global' );
		
if ($termsPopupActive == '1') {
  _e('Checked, you are showing the Terms popup when a design page loads.', 'design-approval-system');
}
else	{
  _e('Not checked, you are NOT showing the Terms popup when a design page loads.', 'design-approval-system');
}

?>  
    </p>
    
    
    
    <p class="special"><?php _e('Show an Agree to Terms and Conditions checkbox in the popup when approving a design', 'design-approval-system') ?><br/><br/>
     
      <input name="das-gq-theme-agree-to-terms-checkbox" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-agree-to-terms-checkbox" value="1" <?php checked( '1', get_option( 'das-gq-theme-agree-to-terms-checkbox' ) ); ?> /> 
      <?php 
	   $termsCheckboxActive = get_option( 'das-gq-theme-agree-to-terms-checkbox' );
		
if ($termsCheckboxActive == '1') {
  _e('Checked, you are showing the Agree to Terms and Conditions checkbox when approving a design', 'design-approval-system');
}
else	{
  _e('Not checked, you are NOT showing the Agree to terms checkbox when approving a design', 'design-approval-system');
}

?>  
    </p>
    
    
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    
    
       
    
    <?php $das_premium = is_plugin_active('das-premium/das-premium.php'); 
	if(isset($das_premium) && $das_premium == true) { ?>
     <h3><?php _e('Use Client Changes option instead of Wordpress Comments', 'design-approval-system') ?></h3>
      <div class="das-settings-admin-input-wrap company-info-style"><p style="margin-top:0;"><?php _e('This will allow the Client Changes option to work and show an additional Project Notes to Customer textarea on the front end tab for Create New Project. See an example of how the client changes options works here. <a class="das-color-white" href="http://www.slickremix.com/docs/client-changes-setup" target="_blank">http://www.slickremix.com/docs/client-changes-setup</a>', 'design-approval-system') ?></p>
    <p class="special">
     
      <input name="das-gq-theme-client-changes-global" class="das-settings-admin-input fleft" type="checkbox" id="das-gq-theme-client-changes-global" value="1" <?php checked( '1', get_option( 'das-gq-theme-client-changes-global' ) ); ?> /> 
      <?php 
	   $clientChangesActive = get_option( 'das-gq-theme-client-changes-global' );
		
if ($clientChangesActive == '1') {
  _e('Checked, you are using the Client Changes option for requested changes', 'design-approval-system');
}
else	{
  _e('Not checked, you are using wordpress comments for clients to request changes', 'design-approval-system');
}

?>  
    </p>
    </div>
    <!--/das-settings-admin-input-wrap-->
    <?php } ?>
    
 	
    
    
    <h3><?php _e('Custom Title Options', 'design-approval-system'); ?></h3>
    <div class="das-float-wrap-2column">
    	
     <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Terms Button Title', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-settings-terms-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-terms-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Terms', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-terms-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
        <div class="das-settings-admin-input-example"><?php _e('This changes the title for the text "Terms" in the menu button.', 'design-approval-system'); ?></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/terms-title.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Designer Title in Project Notes', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-settings-designer-name-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-designer-name-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Designer', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-designer-name-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
        <div class="das-settings-admin-input-example"><?php _e('This changes the word "Designer" next to where your name would be. For example you could change it to, Photographer: Your Name.', 'design-approval-system'); ?></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/designer-title.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Client Title in Project Notes', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-settings-client-notes-name" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-client-notes-name" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Client', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php echo get_option('das-gq-theme-settings-client-notes-name'); ?><?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-designer-name-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
        <div class="das-settings-admin-input-example"><?php _e('This changes the word "Client" next to where the clients name would be.', 'design-approval-system'); ?></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/client-title.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Project Details Title', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-settings-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Project Details', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?>/>
        <div class="das-settings-admin-input-example"><?php _e('This changes the title for  the text "Designer\'s Notes" near the bottom of the theme.', 'design-approval-system'); ?></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/project-details-title.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Project Comments Title', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-settings-client-notes-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-client-notes-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Project Notes', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-client-notes-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
        <div class="das-settings-admin-input-example"><?php _e('This changes the title for the text "Project Comments" near the bottom of the theme.', 'design-approval-system'); ?></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/project-comments-title.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Design Options Title<', 'design-approval-system'); ?>/div>
        <input name="das-gq-theme-settings-client-options-title" class="das-settings-admin-input" type="text" id="das-gq-theme-settings-client-options-title" placeholder="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? _e('Client Options', 'design-approval-system') : _e('Premium plugin required to edit.', 'design-approval-system'); ?>" value="<?php isset($dasPremiumActive) && $dasPremiumActive == true ? print get_option('das-gq-theme-settings-client-options-title') : ''; ?>" <?php isset($dasPremiumActive) && $dasPremiumActive == true ? '' : print 'readonly'; ?> />
        <div class="das-settings-admin-input-example"><?php _e('This changes the title for the text "Client Options" near the bottom of the theme.', 'design-approval-system'); ?></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/design-options-title.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      <div class="clear"></div>
    </div>
    <!-- das-float-wrap-2column -->
    
    <h3><?php _e('Custom Color Options', 'design-approval-system'); ?></h3>
    <div class="das-settings-admin-input-wrap company-info-style das-gq-theme-turn-on-custom-colors">
    		
            <div class="view-all-custom"><a class="icon-view-all das-color-options-open-close-all" href="#"><span class="view-all-articles"><?php _e('open / close', 'design-approval-system'); ?><br>
            <?php _e('help photos', 'design-approval-system'); ?><span class="arrow-right"></span></span></a></div>
            
            
            

            
      <div class="das-settings-admin-input-label das-wp-header-custom"> <?php _e('Check the box to turn on the custom color options below for this theme.', 'design-approval-system'); ?></div>
      <p>
        <input name="das-gq-theme-settings-custom-css" class="das-settings-admin-input" type="checkbox"  id="das-gq-theme-settings-custom-css" value="1" <?php echo checked( '1', get_option( 'das-gq-theme-settings-custom-css' ) ); ?>/>
        <?php    
 
		
if (get_option( 'das-gq-theme-settings-custom-css' ) == '1') {
   _e('<strong>Checked:</strong> Custom styles being used now.', 'design-approval-system');
}
else	{
  _e('<strong>Not Checked:</strong> You are using the default theme colors.', 'design-approval-system');
}
   ?>
      </p>
      
<a class="default-values-gq-theme-option1 das-custom-color-btn" href="javascript:;"><?php _e('Set Default Colors', 'design-approval-system'); ?></a> <a class="default-values-gq-theme-option2 das-custom-color-btn" href="javascript:;"><?php _e('Set Color Option 2', 'design-approval-system'); ?></a> 

      <div class="clear"></div>
    </div>
    <!--/das-settings-admin-input-wrap-->
    
    <div class="das-float-wrap-2column das-ct-color-options-wrap">
      
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Icon', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-icon-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-icon-color" value="<?php echo get_option('das-gq-theme-project-icon-color'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/gq-color-options.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Main header text', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-main-header-text-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-main-header-text-color" value="<?php echo get_option('das-gq-theme-project-main-header-text-color'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/main-header-text-gq-color.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Main header background', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-main-header-background-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-main-header-background-color" value="<?php echo get_option('das-gq-theme-project-main-header-background-color'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/main-header-backg-gq-color.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Main Buttons Hover Background', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-background-main-btns-hover" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-background-main-btns-hover" value="<?php echo get_option('das-gq-theme-project-background-main-btns-hover'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/main-buttons-hoverbackg-gq-color.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Main Buttons Text Hover', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-text-main-btns-hover" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-text-main-btns-hover" value="<?php echo get_option('das-gq-theme-project-text-main-btns-hover'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/main-menu-text-hover-gq-color.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Text Color', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-text-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-text-color" value="<?php echo get_option('das-gq-theme-project-text-color'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/text-color-gq-color.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Text link', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-text-link-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-text-link-color" value="<?php echo get_option('das-gq-theme-project-text-link-color'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/text-link-gq-color.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      
      
      
       <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Boxes background', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-background-color-boxes" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-background-color-boxes" value="<?php echo get_option('das-gq-theme-project-background-color-boxes'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/boxes-backg-gq-color.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Comments even background', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-background-color-even-comment-boxes" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-background-color-even-comment-boxes" value="<?php echo get_option('das-gq-theme-project-background-color-even-comment-boxes'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/comments-even-backg-gq-color.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      
      
      
      
      
      
      <div class="das-settings-admin-input-wrap company-info-style">
        <div class="das-settings-admin-input-label"><?php _e('Border Color', 'design-approval-system'); ?></div>
        <input name="das-gq-theme-project-border-color" class="das-settings-admin-input color" type="text" id="das-gq-theme-project-border-color" value="<?php echo get_option('das-gq-theme-project-border-color'); ?>" />
        <div class="das-settings-admin-input-example"></div>
        <div class="clear"></div>
        <a class="das-gq-theme-settings-toggle" href="#"></a>
        <div class="das-settings-id-answer"> <img src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/gq-template/admin/images/how-to/images/border-color-gq-color.png" alt="" /></div>
        <!--/das-settings-id-answer-->
        <div class="clear"></div>
      </div>
      <!--/das-settings-admin-input-wrap-->
      
      <div class="clear"></div>
    </div>
    <!-- das-float-wrap-2column -->
 
    <input type="submit" class="das-settings-admin-submit-btn" value="<?php _e('Save Changes') ?>" />
    
    <!-- <input class="das-settings-admin-submit-btn" name="Reset" type="submit" value="< ?php _e('reset', das-gq-theme-settings-title-color); ?>" /> 
         <input name="action" type="hidden" value="reset" /> -->
    
  </form> 
  
  <div class="das-settings-icon-wrap"><a href="https://www.facebook.com/SlickRemix" target="_blank" class="facebook-icon"></a></div>
  <a class="das-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a>
</div>
<!--/das-settings-admin-wrap--> 

<script type="text/javascript" src="<?php echo plugins_url(); ?>/design-approval-system/templates/gq-template/admin/js/jscolor/jscolor.js"></script> 
<script type="text/javascript" src="<?php echo plugins_url(); ?>/design-approval-system/templates/gq-template/admin/js/admin.js"></script>
 
<script>

jQuery( document ).ready(function() {
  jQuery( ".toggle-custom-textarea-show" ).click(function() {  
		 jQuery('textarea#das-gq-theme-main-wrapper-css-input').slideToggle('fast');
		  jQuery('.toggle-custom-textarea-show span').toggle();
		  jQuery('.das-custom-css-text').toggle();
		  
}); 

 jQuery( ".toggle-custom-textarea-show-terms" ).click(function() {  
		 jQuery('textarea#das-gq-theme-main-wrapper-custom-terms').slideToggle('fast');
		  jQuery('.toggle-custom-textarea-show-terms span').toggle();
		//  jQuery('.das-custom-css-text').toggle();
		  
}); 
	}); 	 
</script>
<?php
}
?>