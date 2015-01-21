<?php 
 /*This is DAS Default Template*/
?> 
<!--default das template CSS-->
<link rel="stylesheet" type="text/css" media="all" href="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/css/styles.css" />

</head>
<body <?php body_class(); ?> id="design-template">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div class="header-top"></div>
<!--/header-top-->

<div class="show-notes">show notes</div>
<!--/show-notes-->

<div class="header-wrap">
  <div class="main-logo-tab">
    <div id="main-logo"> <a href="/"><img src="<?php echo get_option('das_default_theme_logo_image'); ?>" alt="<?php echo get_option('das-settings-company-name'); ?>" /></a></div>
    <!--/main-logo--> 
  </div>
  <!--/main-logo-tab-->
  
  
  
<?php 
// BEGIN WOO CHECKOUT BUTTON
// make sure woocommerce plugin is active and woo for das is active before returning shortcode
if(is_plugin_active('woocommerce/woocommerce.php') && is_plugin_active('woocommerce-for-das/woocommerce-for-das.php') ) { 
	$das_woo_product = get_post_meta($post->ID, 'das_design_woo_product_id', true);
	$das_custom_woo_product = get_post_meta($post->ID, 'custom_woo_product', true);
	
	if (!empty($das_woo_product) && $das_custom_woo_product == 'yes-woo-product') { ?>
	  <div class="main-checkout-tab"><?php echo do_shortcode('[add_to_cart id="'.$das_woo_product.'"]'); ?></div>
		  <?php }
} 
// END WOO CHECKOUT BUTTON 
?>
          
  
  <div class="header-info-wrap">
    <div class="designers-name-wrap">Designer: <?php echo get_post_meta($post->ID, 'custom_designers_name', true); ?></div>
    <ul class="header-title-text">
      <li>Company</li>
      <li>Date</li>
      <li class="color-dark-grey">Title</li>
    </ul>
    <ul class="header-title-notes-wrap">
      <li> <?php echo get_post_meta($post->ID, 'custom_client_name', true); ?> <br/>
      </li>
      <li>
        <?php the_time('l, F jS, Y') ?>
        at
        <?php the_time() ?>
      </li>
      <li class="color-dark-grey"><?php echo get_post_meta($post->ID, 'custom_name_of_design', true); ?></li>
    </ul>
    <div class="clear"></div>
  </div>
  <!--/header-info-wrap-->
  
  <div class="header-tabs-wrap">
    <ul id="das-nav">
      <?php if(is_plugin_active('das-design-login/das-design-login.php') and $login_required == 'yes-login') { ?>
      <li class="logout-btn-wrap"><a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="logout-btn">Log Out</a></li>
      <?php } ?>
      
      <?php if (get_post_meta($post->ID, 'custom_project_start_end', true) == '') { ?> 
                            <?php } 
							else { ?>
                            
                           <li><a class="project-timeline">Timeline: <?php echo get_post_meta($post->ID, 'custom_project_start_end', true); ?></a></li>
								
						<?php	} ?>
                        
                        
      
      <li><a href="#" class="hide-notes">Hide Notes</a></li>
      <li id="das-nav-history"><a href="javascript:;" class="versions" id="versions-tooltip">Versions</a>
        <?php 
echo '<ul>';

 if ( 'designapprovalsystem' == get_post_type() ) {

	$das_cats = wp_get_post_terms( $post->ID, 'das_categories' );

	if ( $das_cats ) {
		$das_cats_ids = array();
		foreach( $das_cats as $individual_das_cats ) $das_cats_ids[] = $individual_das_cats->term_id;
		
		$args = array(
			'tax_query' => array(
				array(
					'taxonomy'  => 'das_categories',
					'terms' 	=> $das_cats_ids,
					'operator'  => 'IN'
				)
			),
		
			'posts_per_page' 		=> -1,
			'ignore_sticky_posts' 	=> 1
);

		$my_query = new wp_query( $args );
		if( $my_query->have_posts() ) {
			
			while ( $my_query->have_posts() ) :
				$my_query->the_post();?>
      <li> <a href="<?php the_permalink() ?>" rel="bookmark">Design <?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?> </a> </li>
      <?php endwhile;
		}
		wp_reset_query();
	}
}

echo '</ul>';
?>
      </li>
      <li><a class="version-tab"><?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?></a></li>
    </ul>
  </div>
  <!--/header-tabs-wrap--> 
  
</div>
<!--header-wrap-->




<div class="designers-photo-wrap">
  <div class="designers-photo-content">
    <?php the_content();?>
  </div>
  <!--/designers-photo-content-->
  
  <div class="clear"></div>
</div>
<!--designers-photo-wrap-->

<div class="forms-wrapper">

  <div class="approved-form-wrap">
    <div class="status-area1">
      <h2>Status: <span class="color-green">Approve</span></h2>
      <a href="javascript:;" class="close">X</a>
      <div class="clear"></div>
      <div class="approved-form-text">Please be sure to double check this design comp thoroughly for any errors or discrepancies in
        design, grammar, spelling, and overall vision. Your signature below represents the final
        approval of this design comp as is, and any changes from your previously approved copy will
        be charged accordingly.<br/>
        <br/>
        As the authorized decision maker of my firm I acknowledge that I have reviewed and
        approved the proposed design comps designed by <?php echo get_option('das-settings-company-name'); ?>, and presented on <?php echo date('F j, Y'); ?>. </div>
      <!--/approved-form-text-->
      
      <div class="digital-signature-wrap">
        <?php
					
					//Check if Variable is empty if so do default text
					if (get_option('das-settings-approved-dig-sig-message-to-designer') == '') {
						$das_settings_approved_dig_sig_message_to_designer = 'This design comp has been approved by the client. Please take the next appropriate step.';
					}
					else{
						$das_settings_approved_dig_sig_message_to_designer = get_option('das-settings-approved-dig-sig-message-to-designer');
					}
					
					if (get_option('das-settings-approved-dig-sig-message-to-clients') == '') {
						$das_settings_approved_dig_sig_message_to_clients = 'Thank you for approving your design comp. We will now take the next steps in finalizing your project. Below is a confirmation of your submission.
						
						As the authorized decision maker of my firm I acknowledge that I have reviewed and approved the proposed design comps designed by '.get_option('das-settings-company-name').'.';
					}
					else{
						$das_settings_approved_dig_sig_message_to_clients = get_option('das-settings-approved-dig-sig-message-to-clients');
					}
					
					?>
                    
                    

         
        <form action="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/form-processes/new-approved-digital-signature-process.php" class="myform" id="sendDigitalSignature" method="post" name="sendDigitalSignature">
          <input id="human1" type="text"  name="human1" />
          <input name="email1" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>" />
          <div class="label-digital-signature">
            <label>Digital Signature:</label>
            <br/>
            <!-- note: this name used to be a1 but it is now changed to a more comprehensive name -->
            <input type="text" name="custom_client_approved_signature" id="custom_client_approved_signature" value="<?php echo esc_html( get_post_meta( $post->ID, 'custom_client_approved_signature', true) ); ?>" />
            <!-- note: value="Yes" tells DAS to save the approved meta info to make the stars appear in project board -->
            <input type="hidden" value="Yes" name="custom_client_approved" id="custom_client_approved" />
            <input type="hidden" name="designer_email" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_designers_email', true); ?>" />
            <input type="hidden" value="<?php echo get_permalink() ?>" name="designtitle" />
            <input type="hidden" value="<?php echo get_post_meta($post->ID, 'custom_name_of_design', true); ?>" name="customNameOfDesign" />
            <input type="hidden" value="<?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?>" name="version4"  />
            <input type="hidden" value="<?php echo get_post_meta($post->ID, 'custom_client_name', true); ?>" name="companyname4"  />
            <input type="hidden" value="<?php echo get_option('das-settings-company-name'); ?>" name="dasSettingsCompanyName" />
            <input type="hidden" value="<?php echo get_option('das-settings-company-email'); ?>" name="dasSettingsCompanyEmail" />
            <input type="hidden" value="<?php echo ''.$das_settings_approved_dig_sig_message_to_designer.''; ?>" name="dasSettingsApprovedDigSigMessageToDesigner" />
            <input type="hidden" value="<?php echo ''.$das_settings_approved_dig_sig_message_to_clients.''; ?>" name="dasSettingsApprovedDigSigMessageToClients" />
            <input type="hidden" value="<?php echo get_post_meta($post->ID, 'custom_das_template_options', true); ?>" name="templateName" />
       
            <a id="submit" class="das-submit-signature" rel="<?php echo $post->ID; ?>">Submit</a>
            
          </div>
        </form>
        
      </div>
      <!--/status-area1--> 
    </div>
    <!--/digital-signature-wrap-->
    
    <div class="clear"></div>
  </div>
  <!--/approved-form-wrap-->
  
  <div class="approved-thankyou-form-wrap">
    <div class="dig-sig-thank-you-message">
      <?php  
	   		$company_name = get_option('das-settings-company-name'); 
          if (get_option('das-settings-approved-dig-sig-thank-you') == '') {
				echo 'Thank you for approving your design comp.<br/> '.$company_name.' will now take the next steps in finalizing your project.';
		  }
          else{
				echo get_option('das-settings-approved-dig-sig-thank-you');
          }
	   ?>
    </div>
    <!--/dig-sig-thank-you-message--> 
  </div>
  <!--/approved-thankyou-form-wrap--> 
  <!-----/status-Approved FORM--END------>
  
  <?php if(is_plugin_active('das-changes-extension/das-changes-extension.php')) {
	include('wp-content/plugins/das-changes-extension/das-changes-extension-template.php');
}?>
</div>
<!--forms-wrapper-->

<div class="designers-notes-backg">
  <div class="designers-notes-wrap">
    <div class="designers-notes-content-left-wrap">
      <div class="designers-notes-tab">Designer's Notes</div>
      <br class="clear"/>
      <div class="designers-notes-content-left">
        <div class="designer-notes-text">
          <?php
            if (get_option('das-settings-email-for-designers-message-to-clients') == '') {
                $das_settings_email_for_designers_message_to_clients = 'Please review your design comp for changes and/or errors:';
            }
            else{
                $das_settings_email_for_designers_message_to_clients = get_option('das-settings-email-for-designers-message-to-clients');
            }?>
          <form class="myform" id="sendEmailforDesigner" method="post" action="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/form-processes/new-email-for-designer-process.php" name="sendEmailforDesigner">
            <input type="hidden" value="<?php echo get_post_meta($post->ID, 'custom_name_of_design', true); ?>" name="customNameOfDesign" />
            <input type="hidden" name="designer_email" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_designers_email', true); ?>" />
            <input type="hidden" name="email4" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>" />
            <input type="hidden" name="companyname4" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_client_name', true); ?>" />
            <input type="hidden" name="version4" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?>" />
            <input type="hidden" name="link4" class="design-client-permalink" value="<?php echo get_permalink();?>" />
            <input type="hidden" value="<?php echo get_option('das-settings-company-name'); ?>" name="dasSettingsCompanyName" />
            <input type="hidden" value="<?php echo get_option('das-settings-company-email'); ?>" name="dasSettingsCompanyEmail" />
            <input type="hidden" value="<?php echo ''.$das_settings_email_for_designers_message_to_clients.''; ?>" name="dasSettingsEmailForDesignersMessageToClients" />
            <input type="hidden" value="<?php echo $post->post_title ?> "  name="pagetitle"  />
            <input id="human4" type="text"  name="human4" value="" />
            <?php echo get_post_meta($post->ID, 'custom_designer_notes', true); ?>
			
            <div class="entry-utility">
              <?php edit_post_link( __( 'Edit'), '<span class="edit-link">', '</span> | <span id="send-email-for-designer" onClick="jQuery(\'#sendEmailforDesigner\').ajaxSubmit({ target: \'#output\'}); return false;">Send Email</span> <span id="send-email-for-designer-done">Thank-you. Your email has been sent.</span>' ); 
			?> </div>
            <!-- .entry-utility -->
		
          </form>
        </div>
        <!-- designer-notes-text -->
          <div class="client-notes <?php echo get_post_meta($post->ID, 'custom_client_notes_on_off', true); ?>">
            <div class="client-notes-tab">Client Notes</div>
        	<div class="client-notes-textarea"><?php echo get_post_meta($post->ID, 'custom_client_notes', true); ?></div>
         </div>
      </div>
      <!--designers-notes-content-left--> 
    </div>
    <!--designers-notes-content-left-wrap-->
    
    <div class="designers-notes-content-right-wrap">
      <div class="designers-options-tab">Design Options</div> 
      <br class="clear"/>
      <div class="designers-notes-content-right"> 
    <?php
	 // new method for getting login url since some plugins/themes can create overrides for the basic wp_login_url();
	 $slickUrl = site_url('wp-login.php?redirect_to='. get_permalink(),'slick_login_post');
	 // Added SRL 8/24/14
	 $approveLoginOveride = get_option('das-settings-approve-login-overide');
	 
	if ( is_user_logged_in() || $approveLoginOveride == 1) {
	$alreadyapproved = get_post_meta($post->ID, 'custom_client_approved', true);
	if ($alreadyapproved == 'Yes') { ?>
    <div class="approved-wrap">You have approved this Design, Thank-You. <a href="javascript:;" class="design-option-btn">Approved</a></div><?php
	} 
	else { ?> <div class="not-approved-wrap">Would you like to Approve this Design? <a href="javascript:;" class="design-option-btn design-approval-btn">Approve</a></div><?php
		}
	}
	else if ( !is_user_logged_in() ) { ?>Would you like to Approve this Design? <a href="<?php echo $slickUrl ?>" class="design-option-btn">Login</a> <?php 
		} ?>		
		<div class="approved-wrap" style="display:none">"You have approved this Design, Thank-You. <a href="javascript:;" class="design-option-btn">Approved</a></div>
      </div>
      <!--designers-notes-content-right-->
      
      <?php if(is_plugin_active('das-changes-extension/das-changes-extension.php')) { 
	  
	   // Added SRL 8/24/14
	 $changesLoginOveride = get_option('das-settings-changes-login-overide');
	 
	if ( is_user_logged_in() || $changesLoginOveride == 1) {
	  ?><div class="designers-notes-content-right changes-wrap"> Would you like to make Changes to this Design? <a href="javascript:;" class="design-option-btn" id="<?php echo get_post_meta($post->ID, 'custom_paid_not_paid', true); ?>">Changes</a> </div>
      <!--designers-notes-content-right--> 
	  <?php }
      else if ( !is_user_logged_in() || $loginoveride ) {  ?>
	  <div class="designers-notes-content-right changes-wrap"> Would you like to make Changes to this Design? <a href="<?php echo $slickUrl ?>" class="design-option-btn">Login</a></div>
      <!--designers-notes-content-right--> 
     <?php } 
	     }?><!-- is user logged in if statement -->
    </div>
    <!--designers-notes-content-right-wrap-->
    <div class="clear"></div>
  </div>
  <!--designers-notes-wrap-->
  <div class="pop-up-backg"></div>
  <!--pop-up-backg---> 
</div>
<!--designer-notes-backg-->

<?php endwhile; ?>
<div style="display:none" id="output"></div>
<script type="text/javascript">
// We placed this javascript here to make it easy to customize things if you want using simple jquery tools. Enjoy!
function mainmenu(){
	
	jQuery(" #das-nav li").hover(function(){
			jQuery(this).find('ul:first').fadeIn('fast');
		},
	function(){
		jQuery(this).find('ul:first').fadeOut('fast');
	 });
}
	
	jQuery(document).ready(function() {
		mainmenu();
		
		jQuery('.hide-notes').click(function () {
			jQuery('.main-logo-tab,  .designers-notes-backg, .header-wrap').hide();
			jQuery('.header-wrap').slideUp();
			jQuery('.show-notes').show();
			jQuery('.show-notes a').fadeIn(1000);
			jQuery('body').css('background', 'none #000000');
		});
		jQuery('.show-notes').click(function () {	
			jQuery('.header-wrap, .designers-notes-backg').slideDown();
			jQuery('.show-notes').hide();
			jQuery('.main-logo-tab').fadeIn(1000);
			jQuery('body').css('background', 'url(<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/images/designer-backg-grey.png) no-repeat top left #000000');
		});
		
	});	
</script> 

<!-- this is the main template -->
<?php wp_footer(); ?>
</body>
</html>