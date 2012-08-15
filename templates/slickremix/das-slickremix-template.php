<?php
/*
Template Name Posts: Design Approval Page
*/
?>
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
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?>
</title>
<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<link rel="stylesheet" type="text/css" media="all" href="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/css/styles.css" />
<script type="text/javascript" src="<?php print includes_url(); ?>/js/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/jquery.tools.min.js"></script>
<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/jquery.form.js"></script>

<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/design-requests.js"></script>

</head>

<body <?php body_class(); ?> id="design-template">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div class="header-top"></div>
<!--/header-top-->

<div class="show-notes">show notes</div>
<!--/show-notes-->

<div class="header-wrap">
  <div class="main-logo-tab">
    <div id="main-logo"> <a href="/"><img src="<?php echo get_option('image_1'); ?>" alt="<?php echo get_option('das-settings-company-name'); ?>" /></a> </div>
    <!--/main-logo--> 
  </div>
  <!--/main-logo-tab-->
  
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
  
  <div class="header-tabs-wrap"> <a class="project-timeline">Project Timeline: <?php echo get_post_meta($post->ID, 'custom_project_start_end', true); ?></a> <a href="#" class="hide-notes">Hide Notes</a> <a href="javascript:;" class="versions" id="versions-tooltip">Versions</a> <a class="version-tab"><?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?></a> </div>
  <!--/header-tabs-wrap--> 
  
</div>
<!--header-wrap-->

<div class="designers-photo-wrap">
  <div class="designers-photo-content"> <?php echo get_the_content() ?> </div>
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
      <div class="approved-form-text"> Please be sure to double check this design comp thoroughly for any errors or discrepancies in
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
        <form form class="myform" id="sendDigitalSignature" method="post" action="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/form-processes/new-approved-digital-signature-process.php" name="sendDigitalSignature">
          <input id="human1" type="text"  name="human1" />
          <input name="email1" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>" />
          <div class="label-digital-signature">
            <label>Digital Signature:</label>
            <br/>
            <input type="text" name="a1"/>
            <input type="hidden" value="<?php echo get_permalink() ?>" name="designtitle" />
            <input type="hidden" value="<?php echo get_option('das-settings-company-name'); ?>" name="dasSettingsCompanyName" />
            <input type="hidden" value="<?php echo get_option('das-settings-company-email'); ?>" name="dasSettingsCompanyEmail" />
            <input type="hidden" value="<?php echo ''.$das_settings_approved_dig_sig_message_to_designer.''; ?>" name="dasSettingsApprovedDigSigMessageToDesigner" />
            <input type="hidden" value="<?php echo ''.$das_settings_approved_dig_sig_message_to_clients.''; ?>" name="dasSettingsApprovedDigSigMessageToClients" />
            <input type="submit" value="Submit" class="submit-signature" id="submit" onClick="jQuery('#sendDigitalSignature').ajaxSubmit({ target: '#output'}); return false;" />
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
  <!-----/status-Approcoved FORM--END------>
  
  <?php if(is_plugin_active('das-changes-extension/das-changes-extension.php')) {
	include('wp-content/plugins/das-changes-extension/das-changes-extension-template.php');
}?>
</div>
<!--forms-wrapper-->

<div class="desginers-notes-backg">
  <div class="designers-notes-wrap">
    <div class="designers-notes-content-left-wrap">
      <div class="desginers-notes-tab">Designers Notes</div>
      <br class="clear"/>
      <div class="designers-notes-content-left">
        <div class="designer-notes-text">
          <?php
            if (get_option('das-settings-email-for-designers-message-to-clients') == '') {
                $das_settings_email_for_designers_message_to_clients = 'Please review your design comp for changes and/or errors:';
            }
            else{
                $das_settings_email_for_designers_message_to_clients = get_option('das-settings-approved-dig-sig-message-to-clients');
            }?>
          <form class="myform" id="sendEmailforDesigner" method="post" action="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/form-processes/new-email-for-designer-process.php" name="sendEmailforDesigner">
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
              <?php edit_post_link( __( 'Edit'), '<span class="edit-link">', '</span> | <input type="submit" value="Send Email" id="send-email-for-designer" onClick="jQuery(\'#sendEmailforDesigner\').ajaxSubmit({ target: \'#output\'}); return false;" /> <span id="send-email-for-designer-done">Thank-you. Your email has been sent.</span>' ); ?>
            </div>
            <!-- .entry-utility -->
          </form>
        </div>
        <!-- designer-notes-text -->
        <div class="client-notes <?php echo get_post_meta($post->ID, 'custom_client_notes_on_off', true); ?>">
          <h3>Client request's from previous version</h3>
          <?php echo get_post_meta($post->ID, 'custom_client_notes', true); ?> </div>
      </div>
      <!--designers-notes-content-left--> 
    </div>
    <!--designers-notes-content-left-wrap-->
    
    <div class="designers-notes-content-right-wrap">
      <div class="desginers-options-tab">Design Options</div>
      <br class="clear"/>
      <div class="designers-notes-content-right"> Would you like to Approve this Design? <a href="javascript:;" class="design-option-btn design-approval-btn">Approval</a> </div>
      <!--designers-notes-content-right-->
      
      <?php if(is_plugin_active('das-changes-extension/das-changes-extension.php')) { ?>
      <div class="designers-notes-content-right changes-wrap"> Would you like to make Changes to this Design? <a href="javascript:;" class="design-option-btn" id="<?php echo get_post_meta($post->ID, 'custom_paid_not_paid', true); ?>">Changes</a> </div>
      <!--designers-notes-content-right-->
      <?php }?>
    </div>
    <!--designers-notes-content-right-wrap-->
    <div class="clear"></div>
  </div>
  <!--designers-notes-wrap-->
  <div class="pop-up-backg"></div>
  <!--pop-up-backg---> 
</div>
<!--designer-notes-backg-->

<div style="display:none" id="output"></div>
<?php endwhile; ?>
<div id="versions-tooltip-menu" class="tooltip">
  
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
</div>
<!--versions-tooltip-menu--> 

<script type="text/javascript">
	// We placed this javascript here to make it easy to customize things if you want using simple jquery and flowplayer jquery tools. Enjoy!
	jQuery(document).ready(function() {
		jQuery('.hide-notes').click(function () {
			jQuery('.main-logo-tab,  .desginers-notes-backg, .header-wrap').hide();
			jQuery('.header-wrap').slideUp();
			jQuery('.show-notes').show();
			jQuery('.show-notes a').fadeIn(1000);
			jQuery('body').css('background', 'none #000000');
		});
		jQuery('.show-notes').click(function () {	
			jQuery('.header-wrap, .desginers-notes-backg, ').slideDown();
			jQuery('.show-notes').hide();
			jQuery('.main-logo-tab').fadeIn(1000);
			jQuery('body').css('background', 'url(<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/images/designer-backg-grey.png) no-repeat top left #000000');
		});
		jQuery("#versions-tooltip").tooltip({
			// use div.tooltip as our tooltip
			tip: '.tooltip',
			// use the fade effect instead of the default
			effect: 'fade',
			// make fadeOutSpeed similar to the browser's default
			fadeOutSpeed: 100,
			// the time before the tooltip is shown
			predelay: 100,
			// tweak the position
			position: "bottom right",
			offset: [ 0, -122]
		});
		
	});	
</script>
</body>
</html>
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
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?>
</title>
<?php include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); ?>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<link rel="stylesheet" type="text/css" media="all" href="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/css/styles.css" />
<script type="text/javascript" src="<?php print includes_url(); ?>/js/jquery/jquery.js"></script>
<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/jquery.tools.min.js"></script>
<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/jquery.form.js"></script>

<script type="text/javascript" src="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/js/design-requests.js"></script>

</head>

<body <?php body_class(); ?> id="design-template">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<div class="header-top"></div>
<!--/header-top-->

<div class="show-notes">show notes</div>
<!--/show-notes-->

<div class="header-wrap">
  <div class="main-logo-tab">
    <div id="main-logo"> <a href="/"><img src="<?php echo get_option('image_1'); ?>" alt="<?php echo get_option('das-settings-company-name'); ?>" /></a> </div>
    <!--/main-logo--> 
  </div>
  <!--/main-logo-tab-->
  
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
  
  <div class="header-tabs-wrap"> <a class="project-timeline">Project Timeline: <?php echo get_post_meta($post->ID, 'custom_project_start_end', true); ?></a> <a href="#" class="hide-notes">Hide Notes</a> <a href="javascript:;" class="versions" id="versions-tooltip">Versions</a> <a class="version-tab"><?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?></a> </div>
  <!--/header-tabs-wrap--> 
  
</div>
<!--header-wrap-->

<div class="designers-photo-wrap">
  <div class="designers-photo-content"> <?php echo get_the_content() ?> </div>
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
      <div class="approved-form-text"> Please be sure to double check this design comp thoroughly for any errors or discrepancies in
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
        <form form class="myform" id="sendDigitalSignature" method="post" action="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/form-processes/new-approved-digital-signature-process.php" name="sendDigitalSignature">
          <input id="human1" type="text"  name="human1" />
          <input name="email1" class="design-client-email" value="<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>" />
          <div class="label-digital-signature">
            <label>Digital Signature:</label>
            <br/>
            <input type="text" name="a1"/>
            <input type="hidden" value="<?php echo get_permalink() ?>" name="designtitle" />
            <input type="hidden" value="<?php echo get_option('das-settings-company-name'); ?>" name="dasSettingsCompanyName" />
            <input type="hidden" value="<?php echo get_option('das-settings-company-email'); ?>" name="dasSettingsCompanyEmail" />
            <input type="hidden" value="<?php echo ''.$das_settings_approved_dig_sig_message_to_designer.''; ?>" name="dasSettingsApprovedDigSigMessageToDesigner" />
            <input type="hidden" value="<?php echo ''.$das_settings_approved_dig_sig_message_to_clients.''; ?>" name="dasSettingsApprovedDigSigMessageToClients" />
            <input type="submit" value="Submit" class="submit-signature" id="submit" onClick="jQuery('#sendDigitalSignature').ajaxSubmit({ target: '#output'}); return false;" />
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
  <!-----/status-Approcoved FORM--END------>
  
  <?php if(is_plugin_active('das-changes-extension/das-changes-extension.php')) {
	include('wp-content/plugins/das-changes-extension/das-changes-extension-template.php');
}?>
</div>
<!--forms-wrapper-->

<div class="desginers-notes-backg">
  <div class="designers-notes-wrap">
    <div class="designers-notes-content-left-wrap">
      <div class="desginers-notes-tab">Designers Notes</div>
      <br class="clear"/>
      <div class="designers-notes-content-left">
        <div class="designer-notes-text">
          <?php
            if (get_option('das-settings-email-for-designers-message-to-clients') == '') {
                $das_settings_email_for_designers_message_to_clients = 'Please review your design comp for changes and/or errors:';
            }
            else{
                $das_settings_email_for_designers_message_to_clients = get_option('das-settings-approved-dig-sig-message-to-clients');
            }?>
          <form class="myform" id="sendEmailforDesigner" method="post" action="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/form-processes/new-email-for-designer-process.php" name="sendEmailforDesigner">
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
              <?php edit_post_link( __( 'Edit'), '<span class="edit-link">', '</span> | <input type="submit" value="Send Email" id="send-email-for-designer" onClick="jQuery(\'#sendEmailforDesigner\').ajaxSubmit({ target: \'#output\'}); return false;" /> <span id="send-email-for-designer-done">Thank-you. Your email has been sent.</span>' ); ?>
            </div>
            <!-- .entry-utility -->
          </form>
        </div>
        <!-- designer-notes-text -->
        <div class="client-notes <?php echo get_post_meta($post->ID, 'custom_client_notes_on_off', true); ?>">
          <h3>Client request's from previous version</h3>
          <?php echo get_post_meta($post->ID, 'custom_client_notes', true); ?> </div>
      </div>
      <!--designers-notes-content-left--> 
    </div>
    <!--designers-notes-content-left-wrap-->
    
    <div class="designers-notes-content-right-wrap">
      <div class="desginers-options-tab">Design Options</div>
      <br class="clear"/>
      <div class="designers-notes-content-right"> Would you like to Approve this Design? <a href="javascript:;" class="design-option-btn design-approval-btn">Approval</a> </div>
      <!--designers-notes-content-right-->
      
      <?php if(is_plugin_active('das-changes-extension/das-changes-extension.php')) { ?>
      <div class="designers-notes-content-right changes-wrap"> Would you like to make Changes to this Design? <a href="javascript:;" class="design-option-btn" id="<?php echo get_post_meta($post->ID, 'custom_paid_not_paid', true); ?>">Changes</a> </div>
      <!--designers-notes-content-right-->
      <?php }?>
    </div>
    <!--designers-notes-content-right-wrap-->
    <div class="clear"></div>
  </div>
  <!--designers-notes-wrap-->
  <div class="pop-up-backg"></div>
  <!--pop-up-backg---> 
</div>
<!--designer-notes-backg-->

<div style="display:none" id="output"></div>
<?php endwhile; ?>
<div id="versions-tooltip-menu" class="tooltip">
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
</div>
<!--versions-tooltip-menu--> 

<script type="text/javascript">
	// We placed this javascript here to make it easy to customize things if you want using simple jquery and flowplayer jquery tools. Enjoy!
	jQuery(document).ready(function() {
		jQuery('.hide-notes').click(function () {
			jQuery('.main-logo-tab,  .desginers-notes-backg, .header-wrap').hide();
			jQuery('.header-wrap').slideUp();
			jQuery('.show-notes').show();
			jQuery('.show-notes a').fadeIn(1000);
			jQuery('body').css('background', 'none #000000');
		});
		jQuery('.show-notes').click(function () {	
			jQuery('.header-wrap, .desginers-notes-backg, ').slideDown();
			jQuery('.show-notes').hide();
			jQuery('.main-logo-tab').fadeIn(1000);
			jQuery('body').css('background', 'url(<?php print DAS_PLUGIN_PATH ?>/design-approval-system/templates/slickremix/images/designer-backg-grey.png) no-repeat top left #000000');
		});
		jQuery("#versions-tooltip").tooltip({
			// use div.tooltip as our tooltip
			tip: '.tooltip',
			// use the fade effect instead of the default
			effect: 'fade',
			// make fadeOutSpeed similar to the browser's default
			fadeOutSpeed: 100,
			// the time before the tooltip is shown
			predelay: 100,
			// tweak the position
			position: "bottom right",
			offset: [ 0, -122]
		});
		
	});	
</script>
</body>
</html>