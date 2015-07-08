<?php
add_action('wp_enqueue_scripts', 'das_create_new_design_head');
function  das_create_new_design_head() {

	// this is the new way to fire the upload option
	wp_enqueue_media();
	wp_enqueue_script('jquery');
}

// Really simple way of posting from the front end for WordPress
function simple_das_fep($content = null) {
	global $post, $wp_roles, $my_post_ID, $next_version;

	// We're outputing a lot of html and the easiest way
	// to do it is with output buffering from php.
	ob_start();

	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	$role_final = isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
	$das_project_rename_singular = get_option('das-settings-singular-pb-fep-name') ? get_option('das-settings-singular-pb-fep-name') : __('Project', 'design-approval-system');
?>

<div id="simple-das-fep-postbox" class="<?php if(is_user_logged_in()) echo 'closed'; else echo 'loggedout'?>">
  <?php do_action( 'simple_das_fep_notices' ); ?>
  <?php echo '<p class="das-create-post-error simple-das-error">'.__('Please fill out the <strong>Required</strong> options below to continue.', 'design-approval-system').'</p>' ?>
  <div class="simple-das-fep-inputarea">
    <?php if($role_final == 'Administrator' || $role_final == 'DAS Designer')  {


		// this gets post id from the url so we can pass it below to show the information in the inputs etc.
		$_GET["das_post"] = isset($_GET["das_post"]) ? $_GET["das_post"] : '';
		$_GET["nextversion"] = isset($_GET["nextversion"]) ? $_GET["nextversion"] : '';

		$my_post_ID = isset($_GET["das_post"]) ? $_GET["das_post"] : '';
		$next_version = isset($_GET["nextversion"]) ? $_GET["nextversion"] : '';

		if (isset($my_post_ID) && $my_post_ID && $next_version !== 'yes' ) { ?>
    <h3><?php _e('You are now Editing this '.$das_project_rename_singular.'', 'design-approval-system'); ?></h3>
    <?php }
		elseif(isset($next_version) && $next_version == 'yes' )  { ?>
    <h3><?php _e('You are now Creating a New Version', 'design-approval-system'); ?></h3>
    <?php }
		else { ?>
    <h3><?php echo __('Create New '.$das_project_rename_singular.'', 'design-approval-system'); ?></h3>
    <?php } ?>
    <form id="new_post" name="new_post" method="post" action="<?php if ($my_post_ID && $next_version !== 'yes') { echo the_permalink().'?das_post='.$my_post_ID.'&success='.$my_post_ID; } else { echo the_permalink().'?new=yes&tab=2'; } ?>">
      <p class="das-enter-order-number">
        <label><?php _e('Enter Order Number', 'design-approval-system'); ?> *</label>
        <?php $design_title = get_the_title( $my_post_ID ); ?>
        <input type="text" id="fep-post-title" name="post_title" placeholder="ie* Order44553 V1" value="<?php if (isset($my_post_ID) && $my_post_ID) { echo $design_title; } ?>"/>
      </p>
      <p class="das-enter-contact">
        <label><?php echo __('Customer Name *', 'design-approval-system'); ?></label>
        <select name="custom_client_name" id="custom_client_name">
          <?php echo '<option value="custom_clients_name">';
		_e('Please Select', 'design-approval-system');
		echo '</option>';
		$client_roles = get_option('das-settings-client-role');
		$client_users_name = get_users('blog_id=1&orderby=display_name&role='.$client_roles.'');

		foreach ($client_users_name as $user) {
			$clients_name = $user->display_name;
			$clients_email = $user->user_email;
			$meta = get_post_meta($my_post_ID, 'custom_client_name', true);
			$row = $clients_name;

			echo '<option value="'.$row.'"', $meta == $row ? 'selected="selected"':'','>'.$row.' ['.$clients_email.'] </option>';
		}
		?></select>
      </p>
      <p style="display:none" class="das-select-client-email">
        <label>Client Email *</label>
        <input type="text" name="custom_clients_email" id="custom_clients_email" value="<?php if (isset($_POST["custom_clients_email"]))
			echo $_POST["custom_clients_email"]; if (isset($my_post_ID) && $my_post_ID) { echo get_post_field('custom_clients_email', $my_post_ID); } ?>" size="30">
      </p>
      <p class="das-select-das-category">
        <?php custom_taxonomy_dropdown( 'das_categories' ); ?>
      </p>
      <p class="das-create-new-das-category">
        <label><?php _e('Create a New Company Name / Order Number', 'design-approval-system'); ?></label>
        <input type="text" name="newcat" value="" />
      </p>
      <p style="display:none">
        <label for="custom_name_of_design">Name of the Project</label>
        <input type="text" name="custom_name_of_design" id="custom_name_of_design" value="<?php if (isset($my_post_ID)) { echo get_post_field('custom_name_of_design', $my_post_ID); } ?>" size="30">
      </p>
      <p>
        <label><?php _e('Version Number', 'design-approval-system'); ?></label>
        <?php $version_meta = get_post_meta($my_post_ID, 'custom_version_of_design', true);

?>
        <select name="custom_version_of_design" id="custom_version_of_design">
          <?php if($version_meta == 'Version 1' && $next_version == 'yes') { ?>
          <option value="Version 2" selected='selected'><?php _e('Version 2', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 1" <?php if($version_meta == 'Version 1'){echo "selected='selected'";} ?>><?php _e('Version 1', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 2' && $next_version == 'yes') { ?>
          <option value="Version 3" selected='selected'><?php _e('Version 3', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 2" <?php if($version_meta == 'Version 2'){echo "selected='selected'";} ?>><?php _e('Version 2', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 3' && $next_version == 'yes') { ?>
          <option value="Version 4" selected='selected'><?php _e('Version 4', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 3" <?php if($version_meta == 'Version 3'){echo "selected='selected'";} ?>><?php _e('Version 3', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 4' && $next_version == 'yes') { ?>
          <option value="Version 5" selected='selected'><?php _e('Version 5', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 4" <?php if($version_meta == 'Version 4'){echo "selected='selected'";} ?>><?php _e('Version 4', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 5' && $next_version == 'yes') { ?>
          <option value="Version 6" selected='selected'><?php _e('Version 6', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 5" <?php if($version_meta == 'Version 5'){echo "selected='selected'";} ?>><?php _e('Version 5', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 6' && $next_version == 'yes') { ?>
          <option value="Version 7" selected='selected'><?php _e('Version 7', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 6" <?php if($version_meta == 'Version 6'){echo "selected='selected'";} ?>><?php _e('Version 6', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 7' && $next_version == 'yes') { ?>
          <option value="Version 8" selected='selected'><?php _e('Version 8', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 7" <?php if($version_meta == 'Version 7'){echo "selected='selected'";} ?>><?php _e('Version 7', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 8' && $next_version == 'yes') { ?>
          <option value="Version 9" selected='selected'><?php _e('Version 9', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 8" <?php if($version_meta == 'Version 7'){echo "selected='selected'";} ?>><?php _e('Version 8', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 9' && $next_version == 'yes') { ?>
          <option value="Version 10" selected='selected'><?php _e('Version 10', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 9" <?php if($version_meta == 'Version 9'){echo "selected='selected'";} ?>><?php _e('Version 9', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 10' && $next_version == 'yes') { ?>
          <option value="Version 11" selected='selected'><?php _e('Version 11', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 10" <?php if($version_meta == 'Version 10'){echo "selected='selected'";} ?>><?php _e('Version 10', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 11' && $next_version == 'yes') { ?>
          <option value="Version 12" selected='selected'>><?php _e('Version 12', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 11" <?php if($version_meta == 'Version 11'){echo "selected='selected'";} ?>><?php _e('Version 11', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 12' && $next_version == 'yes') { ?>
          <option value="Version 13" selected='selected'><?php _e('Version 13', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 12" <?php if($version_meta == 'Version 12'){echo "selected='selected'";} ?>><?php _e('Version 12', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 13' && $next_version == 'yes') { ?>
          <option value="Version 14" selected='selected'><?php _e('Version 14', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 13" <?php if($version_meta == 'Version 13'){echo "selected='selected'";} ?>><?php _e('Version 13', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 14' && $next_version == 'yes') { ?>
          <option value="Version 15" selected='selected'><?php _e('Version 15', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 14" <?php if($version_meta == 'Version 14'){echo "selected='selected'";} ?>><?php _e('Version 14', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 15' && $next_version == 'yes') { ?>
          <option value="Version 16" selected='selected'><?php _e('Version 16', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 15" <?php if($version_meta == 'Version 15'){echo "selected='selected'";} ?>><?php _e('Version 15', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 16' && $next_version == 'yes') { ?>
          <option value="Version 17" selected='selected'>><?php _e('Version 17', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 16" <?php if($version_meta == 'Version 16'){echo "selected='selected'";} ?>><?php _e('Version 16', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 17' && $next_version == 'yes') { ?>
          <option value="Version 18" selected='selected'><?php _e('Version 18', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 17" <?php if($version_meta == 'Version 17'){echo "selected='selected'";} ?>><?php _e('Version 17', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 18' && $next_version == 'yes') { ?>
          <option value="Version 19" selected='selected'>Version 19</option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 18" <?php if($version_meta == 'Version 18'){echo "selected='selected'";} ?>><?php _e('Version 18', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 19' && $next_version == 'yes') { ?>
          <option value="Version 20"  selected='selected'><?php _e('Version 20', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 19" <?php if($version_meta == 'Version 19'){echo "selected='selected'";} ?>><?php _e('Version 19', 'design-approval-system'); ?></option>
          <?php }?>
          <?php if($version_meta == 'Version 20' && $next_version == 'yes') { ?>
          <option value="Version 21"  selected='selected'><?php _e('Version 21', 'design-approval-system'); ?></option>
          <?php }
		elseif ($next_version == NULL) { ?>
          <option value="Version 20" <?php if($version_meta == 'Version 20'){echo "selected='selected'";} ?>><?php _e('Version 20', 'design-approval-system'); ?></option>
          <?php }?>
        </select>
      </p>


       <p class="das-due-date">
        <label><?php _e('When the Project will Start and End', 'design-approval-system'); ?><small><?php _e('ie* 2-15-17 thru 2-15-18', 'design-approval-system'); ?></small></label>
        <input type="text" name="custom_project_start_end" id="custom_project_start_end" value="<?php if (isset($my_post_ID)) { echo get_post_field('custom_project_start_end', $my_post_ID); } ?>" />
      </p>


      <label><?php _e('Set '.$das_project_rename_singular.' Thumbnail', 'design-approval-system'); ?><small><?php _e('To set the Thumbnail which shows on the '.$das_project_rename_singular.' Board click the Thumbnail Icon below and upload or choose an existing photo.', 'design-approval-system'); ?></small></label>
      <!-- Your add & remove image links -->
            <div class="project-large-thumbnail">
              <?php $das_thumbnail_image_id = get_post_thumbnail_id( $my_post_ID );
		// echo $das_thumbnail_image_id; ?>
              <div class="das-dynamic-image-holder">
                <?php if (isset($my_post_ID) && $my_post_ID) { echo get_the_post_thumbnail( $my_post_ID, 'thumbnail' );  } ?>
              </div>
              <div class="pb-no-thumbnail-image" <?php if (!empty($das_thumbnail_image_id)) { echo "style='display:none'"; } ?>></div>
              <a class="upload-custom-img" <?php if (!empty($das_thumbnail_image_id)) { echo "style='display:none'"; } ?> href="javascript:;">
              <?php _e('Set Thumbnail Image', 'design-approval-system') ?>
              </a> <a <?php if (empty($das_thumbnail_image_id)) { echo "style='display:none'"; } ?> class="delete-custom-img" href="javascript:;">
              <?php _e('Change Image', 'design-approval-system') ?>
              </a> </div>

      <!-- A hidden input to set and post the chosen image id -->
      <input id="das-custom-img-id" name="das_custom_img_id" value="<?php if (isset($my_post_ID) && $my_post_ID) { echo get_post_thumbnail_id( $my_post_ID ); } ?> " type="hidden" />
      <p class="das-enter-content-media-etc">
        <label><?php _e('Set Design Media to be Approved', 'design-approval-system'); ?><br/>
          <small><?php _e("Click the 'add media' button below to add an image, pdf, video etc. Make sure before you click the 'Insert Into Page' button that you choose the proper size from the 'Attachment Display Settings' column of the popup.", 'design-approval-system'); ?></small></label>
        <textarea class="fep-content" name="posttext" id="fep-post-text" rows="4" cols="60" style="display:none"><?php if (isset($my_post_ID) && $my_post_ID) { echo get_post_field('post_content', $my_post_ID); } ?>
</textarea>
  <?php
		if ($my_post_ID) {
			$post_id = $my_post_ID;
			$post = get_post( $post_id, OBJECT, 'edit' );
			$content = $post->post_content;
		}
		else {
			$content = '';
		}

		$editor_id = 'editpost';

		wp_editor( $content, $editor_id );

		?></p>

     <?php

		// Allow the clients changes notes to customer area else show the allow comments options
		if(get_option('das-gq-theme-client-changes-global') == '1') { ?>
      <div class="clear"></div>
      <?php $designer_content_meta = get_post_meta($my_post_ID, 'custom_designer_notes', true); ?>
      <p>
        <label><?php _e($das_project_rename_singular.' Notes to Customer', 'design-approval-system'); ?></label>
        <textarea name="custom_designer_notes" id="custom_designer_notes" cols="60" rows="4"><?php if (isset($my_post_ID) && $my_post_ID) { echo $designer_content_meta; } ?>
</textarea>

      </p>
      <?php }
		else {
			?><p><label><?php _e('Allow Comments', 'design-approval-system'); ?><br/><small><?php _e("This will show the Comments button on the design template.", 'design-approval-system'); ?></small></label>
          <select name="comment_status" id="comment_status">
          		<option value="open" <?php if(comments_open()){echo "selected='selected'";} ?>>Yes</option>
          		<option value="0" <?php if($my_post_ID->comment_status){echo "selected='selected'";} ?>>No</option>
          </select></p>
         <?php
		}?>

      <div class="clear"></div>
       <?php
		$das_product_id = get_post_meta($my_post_ID, 'das_design_woo_product_id', true);
		$custom_woo_product_price = get_post_meta($my_post_ID, 'custom_woo_product', true);
		$set_woo_product_price = get_post_meta($das_product_id, '_price', true);
		if ($custom_woo_product_price != $set_woo_product_price) {
			$product_set = $set_woo_product_price;
		}//END IF
		else {
			$product_set = $custom_woo_product_price;
		}

		//Woo for DAS
		if(is_plugin_active('woocommerce/woocommerce.php') && is_plugin_active('das-premium/das-premium.php')) {  ?>
     <?php $custom_woo_product = get_post_meta($my_post_ID, 'custom_woo_product', true); ?>
      <p>
        <label for="custom_woo_product"><?php _e('Turn into a WooCommerce Product?', 'design-approval-system'); ?><br/>
				<small><?php _e('Selecting yes will create a product in Woocommerce.', 'design-approval-system'); ?></small></label>
				<select name="custom_woo_product" id="custom_woo_product"><option value="no-woo-product" <?php if($custom_woo_product == 'no-woo-product'){echo "selected='selected'";} ?>><?php _e('No, Do not create a Woo product.', 'design-approval-system'); ?></option><option value="yes-woo-product" <?php if($custom_woo_product == 'yes-woo-product'){echo "selected='selected'";} ?>><?php _e('Yes, Create or Update this Design as a Woo product.', 'design-approval-system'); ?></option></select><br/>
                 </p>
                    <p>
				 <label for="custom_woo_design_price"><?php _e('Price of Design', 'design-approval-system'); ?><br/> <small><?php _e('Price of the '.$das_project_rename_singular.'. The price will always update in WooCommerce if you make changes.', 'design-approval-system'); ?></small></label>
       			 <?php $custom_woo_design_price = get_post_meta($my_post_ID, 'custom_woo_design_price', true); ?>
				<input type="text" name="custom_woo_design_price" id="custom_woo_design_price" value="<?php echo $custom_woo_design_price ?>" size="30">
							<br/>
      </p>
      <?php } ?>

      <p style="display:none">
        <label>Tags</label>
        <input id="fep-tags" name="tags" type="text" tabindex="2" autocomplete="off" value="<?php esc_attr_e( 'Add tags', 'simple-das-fep' ); ?>" onfocus="this.value=(this.value=='<?php echo esc_js( __( 'Add tags', 'simple-das-fep' ) ); ?>') ? '' : this.value;" onblur="this.value=(this.value=='') ? '<?php echo esc_js( __( 'Add tags', 'simple-das-fep' ) ); ?>' : this.value;" />
      </p>
      <input type="text" name="custom_das_template_options" id="custom_das_template_options" value="das-gq-theme-main.php" style="display:none">
      <input type="text" name="custom_login_no_login" id="custom_login_no_login" value="yes-login" style="display:none">
      <input type="text" name="my_post_ID" id="my_post_ID" value="<?php echo $my_post_ID; ?>" style="display:none">
      <input type="text" name="next_version" id="next_version" value="<?php echo $next_version; ?>" style="display:none">
      <input type="text" name="custom_designers_name" id="custom_designers_name" value="<?php echo $current_user->nickname; ?>" style="display:none">
      <input type="text" name="custom_designers_email" id="custom_designers_email" value="<?php echo $current_user->user_email; ?>" style="display:none">
      <?php $new_version = isset($_GET['nextversion']) ? $_GET['nextversion'] : ''; ?>
      <input id="submit" type="submit" tabindex="3" value="<?php if($my_post_ID && $new_version !== 'yes') { _e( 'Update Post', 'design-approval-system' ); } else { _e( 'Post', 'design-approval-system' ); } ?>" />
      <!-- <input type="hidden" name="comment_status" id="comment_status" value="open" /> -->
      <input type="hidden" name="action" value="post" />
      <input type="hidden" name="empty-description" id="empty-description" value="1"/>
      <?php wp_nonce_field( 'new-post' ); ?>
    </form>

<script>
jQuery(document).ready(function($) {
  jQuery('.content-2 #submit').live('click', function( event ){
	 // Error Check
	 if(jQuery('#fep-post-title').val() == '' || jQuery('#custom_client_name').val() == 'custom_clients_name' || jQuery('#existing-project-select').val() == 'existing_client' && jQuery('.das-create-new-das-category input').val() == '' || jQuery('#wp-editpost-wrap').hasClass('html-active') == true && jQuery('#editpost').val() == '' || jQuery('#wp-editpost-wrap').hasClass('tmce-active') == true && tinyMCE.get('editpost').getContent() == '' || jQuery('#existing-project-select').val() == '' && jQuery('.das-create-new-das-category input').val() == '') {
		jQuery('.das-create-post-error').show();
		// Animate the scrolling motion.
				jQuery("body, html").animate({
					scrollTop:0
				},"slow");
		event.preventDefault();
	}
	// Post/Design Title
	if(jQuery('#fep-post-title').val() == '') {
		jQuery('.das-enter-order-number').addClass('das-error-input');
	}
	else {
		jQuery('.das-enter-order-number').removeClass('das-error-input');
	}
	// Select Client
	if(jQuery('#custom_client_name').val() == 'custom_clients_name') {
		jQuery('.das-enter-contact').addClass('das-error-input');
	}
	else {
		jQuery('.das-enter-contact').removeClass('das-error-input');
	}
	// Select Category
	if(jQuery('#existing-project-select').val() == 'existing_client' && jQuery('.das-create-new-das-category input').val() == '') {
		jQuery('.das-select-das-category').addClass('das-error-input');
	}
	else {
		jQuery('.das-select-das-category').removeClass('das-error-input');
	}
	// New Category Input
	if(jQuery('.das-create-new-das-category input').val() == '' && jQuery('#existing-project-select').val() == null) {
		jQuery('.das-create-new-das-category').addClass('das-error-input');
	}
	else {
		jQuery('.das-create-new-das-category').removeClass('das-error-input');
	}
	// Content Area
	 if(jQuery('#wp-editpost-wrap').hasClass('html-active') == true && jQuery('#editpost').val() == '') {
		// alert('asdfasdf');
		jQuery('.das-enter-content-media-etc').addClass('das-error-input');
	}
	else {
		 jQuery('.das-enter-content-media-etc').removeClass('das-error-input');
	}
	// Content Area
	 if(jQuery('#wp-editpost-wrap').hasClass('tmce-active') == true && tinyMCE.get('editpost').getContent() == '') {
		jQuery('.das-enter-content-media-etc').addClass('das-error-input');
	}
	else {
		// jQuery('.das-enter-content-media-etc').removeClass('das-error-input');
	}
 });

		 // This selector is called every time a select box is changed
		  jQuery("select#custom_client_name").change(function(){
			  // varible to hold string
			  var str = "";
			  var finalString = "";
			  jQuery("select#custom_client_name option:selected").each(function(){
				  // when the select box is changed, we add the value text to the varible
				  str += jQuery(this).text() + " ";

			  });
			   var matches = str.match(/\[(.*?)\]/);
				if (matches) {
					var submatch = matches[1];
				}
			  // then display it in the following class
			  jQuery("#custom_clients_email").val(submatch);

		  })

		  // This selector is called every time a select box is changed
		  jQuery("select#existing-project-select").change(function(){
			  // varible to hold string
			  var str = "";
			  var finalString = "";
			  jQuery("select#existing-project-select option:selected").each(function(){
				  // when the select box is changed, we add the value text to the varible
				  str += jQuery(this).text() + " ";

			  });
			   var matches = str;
			  // then display it in the following class
			  jQuery("#custom_name_of_design").val(matches);

			  })


	// Makes sure the media uploader is on the upload tab when openened instead of the media library
	wp.media.controller.Library.prototype.defaults.contentUserSetting=false;


	jQuery(document).on("DOMNodeInserted", function(){
		// Lock uploads to "Uploaded to this post"
		jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
	});


	// Uploading files
	var file_frame;
	var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
	var set_to_post_id = <?php echo $post->ID ?>; // Set this


	   jQuery('.ls_test_media').live('click', function( event ){

		event.preventDefault();

		 // If the media frame already exists, reopen it.
		if ( file_frame ) {
		  // Set the post ID to what we want
		  file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
		  // Open frame
		  file_frame.open();
		  return;
		} else {
		  // Set the wp.media post id so the uploader grabs the ID we want when initialised
		  wp.media.model.settings.post.id = set_to_post_id;
		}

	    // Create the media frame.
		file_frame  = wp.media(
		{
			button: { text: '<?php _e('Insert Media or Zip', 'design-approval-system'); ?>', },
		frame:   'select',
		state:   'mystate',
		// This is commented out so we can see the zip icon too if zips are uploaded
		// library:   {type: 'image'},
		multiple:   false
		});

		file_frame.states.add([

	new wp.media.controller.Library({
		id:         'mystate',

		title: '<?php _e('Insert Media', 'design-approval-system'); ?>',
		priority:   20,
		toolbar:    'select',
		filterable: 'uploaded',
		library:    wp.media.query( file_frame.options.library ),
		multiple:   file_frame.options.multiple ? 'reset' : false,
		editable:   false,
		displayUserSettings: false,
		displaySettings: false,
		allowLocalEdits: false,
	}),
	]);

	    // When an image is selected, run a callback.
		file_frame.on( 'select', function() {
		// We set multiple to false so only get one image from the uploader
	    attachment = file_frame.state().get('selection').first().toJSON();

		  // Restore the main post ID
		  wp.media.model.settings.post.id = wp_media_post_id;

		  Object:
			 attachment.filename
			 attachment.link
			 attachment.menuOrder

		  		// Do something with attachment.id and/or attachment.url here
				var $edit = $("#fep-post-text");
				var curValue = $edit.val();
				var newValue = curValue + ' <a href="' + attachment.url + '">' + attachment.filename + '</a><br/>';
				$edit.val(newValue);


		});

	file_frame.open();


	});

});

////////////////////////////////////////////////////////////////////
// This is the wp medai frame for the Featured Image/ Thumbnail ///
//////////////////////////////////////////////////////////////////
jQuery(function($){
	  // Set all variables to be used in scope
  	var frame
	var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
	var set_to_post_id = <?php echo $post->ID ?>; // Set this


  // ADD IMAGE LINK
  jQuery('.content-2 .upload-custom-img, .content-2 .project-large-thumbnail').live('click', function( event ){

//	alert(tinyMCE.get('editpost').getContent());
    event.preventDefault();

    // If the media frame already exists, reopen it.
		if ( frame ) {
		  // Set the post ID to what we want
		  frame.uploader.uploader.param( 'post_id', set_to_post_id );
		  // Open frame
		  frame.open();
		  return;
		} else {
		  // Set the wp.media post id so the uploader grabs the ID we want when initialised
		  wp.media.model.settings.post.id = set_to_post_id;
		}

    // Create a new media frame
    frame = wp.media({
      title: '<?php _e('Select or Upload Media for the Thumbnail', 'design-approval-system'); ?>',
      button: {
        text: '<?php _e('Use this media', 'design-approval-system'); ?>'
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected in the media frame...
    frame.on( 'select', function() {
        // We set multiple to false so only get one image from the uploader
		  attachment = frame.state().get('selection').first().toJSON();

		  // Restore the main post ID
		  wp.media.model.settings.post.id = wp_media_post_id;

		  Object:
			 attachment.filename
			 attachment.id
			 attachment.link
			 attachment.menuOrder

				$('.das-dynamic-image-holder').html( '' );
				$('#das-custom-img-id').val('');
				$('.das-dynamic-image-holder').prepend( '<img src="'+ attachment.sizes.thumbnail.url +'" alt="" style="max-width:150px;" class="das-featured-image-attach"/><br/>' );
				$('.pb-no-thumbnail-image, .upload-custom-img').hide();
			//	$('.project-large-thumbnail').addClass('upload-custom-img');
			 //   $('.project-large-thumbnail').removeClass('delete-custom-img');
				$('.delete-custom-img').show();

    			var $edit = $("#das-custom-img-id");
				var curValue = $edit.val();
				var newValue = curValue + attachment.id;
				$edit.val(newValue);
   	 });
    // Finally, open the modal on click
    frame.open();
  });

});
</script>
    <style>
.das-error-input label:before { color: rgb(223, 37, 37) !important; content:'<?php _e('Required:', 'design-approval-system'); ?> ' }
</style>
    <?php } else { ?>
    <h3><?php _e('Create New Design Post', 'design-approval-system'); ?></h3>
    <p><?php _e('Please', 'design-approval-system'); ?> <a href="<?php echo wp_login_url( get_permalink()  . '#tab2' ); ?>" title="Login"><?php _e('Login', 'design-approval-system'); ?></a> <?php _e('to create a new design post.', 'design-approval-system'); ?></p>
    <?php } ?>
  </div>
</div>
<!-- #simple-das-fep-postbox -->
<?php
	// Output the content.
	$output .= ob_get_contents();
	ob_end_clean();
	// return only if we're inside a page. This won't list anything on a post or archive page.
	if (is_page()) return  $output;
}

// Add the shortcode to WordPress.
add_shortcode('simple-das-fep', 'simple_das_fep');

function simple_das_fep_notices(){
?>
<script>
  jQuery( ".content-2" ).fadeIn();
  jQuery( ".content-1" ).hide();
  jQuery( ".content-3" ).hide();

   jQuery( ".tab-2" ).addClass('active');
   jQuery( ".tab-1" ).removeClass('active');
   jQuery( ".tab-3" ).removeClass('active');
</script>
<?php

	global $notice_array;
	foreach($notice_array as $notice){
		echo '<p class="simple-das-notice">' . $notice . '</p>';
	}
}


function simple_das_fep_add_post(){
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'post' ){
		if ( !is_user_logged_in() )
			return;
		global $current_user, $next_version, $post;



		get_posts('post_type=designapprovalsystem');

		$user_id  = $current_user->ID;
		$post_title     = $_POST['post_title'];
		$post_content = $_POST['editpost'];




		$my_post_ID       = $_POST['my_post_ID'];
		$next_version       = $_POST['next_version'];
		$project_name          = $_POST['custom_name_of_design'];

		if (!empty($_POST['newcat'])) {
			$custom_name_of_design        = isset($_POST['newcat']) ? $_POST['newcat'] : '';
		}
		else {
			$custom_name_of_design        = isset($_POST['custom_name_of_design']) ? $_POST['custom_name_of_design'] : '';
		}
		$custom_client_name           = isset($_POST['custom_client_name']) ? $_POST['custom_client_name'] : '';

		$custom_clients_email       = isset($_POST['custom_clients_email']) ? $_POST['custom_clients_email'] : '';

		$custom_designers_name       = isset($_POST['custom_designers_name']) ? $_POST['custom_designers_name'] : '';

		$custom_designers_email       = isset($_POST['custom_designers_email']) ? $_POST['custom_designers_email'] : '';

		$custom_das_template_options  =  isset($_POST['custom_das_template_options']) ? $_POST['custom_das_template_options'] : '';

		$custom_login_no_login        = isset($_POST['custom_login_no_login']) ? $_POST['custom_login_no_login'] : '';

		$custom_version_of_design     = isset($_POST['custom_version_of_design']) ? $_POST['custom_version_of_design'] : '';

		$comment_status      =  isset($_POST['comment_status']) ? $_POST['comment_status'] : '';

		$das_post_thumbnail = isset($_POST['das_custom_img_id']) ? $_POST['das_custom_img_id'] : '';

		$custom_project_start_end      =  isset($_POST['custom_project_start_end']) ? $_POST['custom_project_start_end'] : '';

		// premium option
		$custom_designer_notes        = isset($_POST['custom_designer_notes']) ? $_POST['custom_designer_notes'] : '';
		// premium options
		$custom_woo_design_price     = isset($_POST['custom_woo_design_price']) ? $_POST['custom_woo_design_price'] : '';
		$custom_woo_product      =  isset($_POST['custom_woo_product']) ? $_POST['custom_woo_product'] : '';




		// $tags   = $_POST['tags'];
		if(!empty($_REQUEST['newcat'])){
			$location       = trim($_POST['newcat']);
		}
		else {
			$_POST['das_categories'] = isset($_POST['das_categories']) ? $_POST['das_categories'] : '';
			$location       = trim($_POST['das_categories']);
		}

		global $error_array;
		$error_array = array();

		if (empty($post_title)) $error_array[]='Please Enter an Order Number.';
		if (isset($_POST['custom_client_name']) && $_POST['custom_client_name'] == 'custom_clients_name') $error_array[]='Please Select a Contact Name.';
		if (isset($_POST['das_categories']) == 'existing_client' && empty($custom_name_of_design)) $error_array[]='Please Select an Existing Company Name / Order Number or Enter a New one.';
		if (empty($post_content)) $error_array[]='Please Enter some Content.';

		if (count($error_array) == 0){


			if ($my_post_ID && $next_version !== 'yes') {
				$my_post = array(
					'post_type'     => 'designapprovalsystem',
					'tax_input'    => array( $location ),
					'post_content' => $post_content,
					'post_author' => $user_id,
					'post_title' => $post_title,
					'comment_status' => $comment_status,
					'ID' => $my_post_ID,
				);
			}
			else {
				$my_post = array(
					'post_author' => $user_id,
					'post_title' => $post_title,
					'post_type'     => 'designapprovalsystem',
					'tax_input'    => array( $location ),
					'post_content' => $post_content,
					'comment_status' => $comment_status,
					// 'tags_input' => $tags,
					'post_status' => 'publish'
				);
			}

			// Here is where we create a new category
			if(isset($_POST['submit'])){

				if(!empty($_REQUEST['newcat'])){

					$cat_ID = get_cat_ID( $_POST['newcat'] );

					//If not create new category
					if($cat_ID == 0) {
						$cat_name = $_POST['newcat'];
						$parenCatID = 0;
						$new_cat_ID = wp_create_category($cat_name,$parenCatID);

						echo 'Category added successfully.<br />';
					}
					else { echo 'That category already exists<br />'; }
				}
			}
			global $next_version;

			if ($my_post_ID && $next_version !== 'yes') {

				$my_post_ID = wp_update_post($my_post);


				if(!empty( $_POST['custom_name_of_design'] ))
				{
					update_post_meta($my_post_ID, 'custom_name_of_design', $custom_name_of_design);
				}
				if(!empty( $_POST['custom_clients_email'] ))
				{
					update_post_meta($my_post_ID, 'custom_clients_email', $custom_clients_email);
					update_post_meta($my_post_ID, 'custom_client_name', $custom_client_name);
				}

				update_post_meta($my_post_ID, 'custom_designers_name', $custom_designers_name);
				update_post_meta($my_post_ID, 'custom_designers_email', $custom_designers_email);
				update_post_meta($my_post_ID, 'custom_das_template_options', $custom_das_template_options);
				update_post_meta($my_post_ID, 'custom_login_no_login', $custom_login_no_login);
				update_post_meta($my_post_ID, 'custom_version_of_design', $custom_version_of_design);
				update_post_meta($my_post_ID, 'custom_designer_notes', $custom_designer_notes);
				update_post_meta($my_post_ID, 'custom_project_start_end', $custom_project_start_end);

				// This adds the options we neeed to Update an existing woo product
				if (is_plugin_active('das-premium/das-premium.php')) {
					update_post_meta($my_post_ID, 'custom_woo_design_price', $custom_woo_design_price);
					update_post_meta($my_post_ID, 'custom_woo_product', $custom_woo_product);
					// This needs to be corrected to work with new posts and others
					$post_id = $my_post_ID;
					include WP_CONTENT_DIR .'/plugins/das-premium/includes/woocommerce-for-das-meta-box.php';
				}

				set_post_thumbnail($my_post_ID , $das_post_thumbnail);
				wp_set_object_terms($my_post_ID, $location,'das_categories');

			}
			else {

				// need to make it so when browser is refreshred a new post is not created from the last
				// if($_GET['new'] !== 'yes') {
				$post_id = wp_insert_post($my_post);
				// }

				add_post_meta($post_id, 'custom_client_name', $custom_client_name, true);
				add_post_meta($post_id, 'custom_clients_email', $custom_clients_email, true);
				add_post_meta($post_id, 'custom_designers_name', $custom_designers_name, true);
				add_post_meta($post_id, 'custom_designers_email', $custom_designers_email, true);
				add_post_meta($post_id, 'custom_das_template_options', $custom_das_template_options, true);
				add_post_meta($post_id, 'custom_login_no_login', $custom_login_no_login, true);
				add_post_meta($post_id, 'custom_version_of_design', $custom_version_of_design, true);
				add_post_meta($post_id, 'custom_designer_notes', $custom_designer_notes, true);
				add_post_meta($post_id, 'custom_name_of_design', $custom_name_of_design, true);
				add_post_meta($post_id, 'comment_status', $comment_status, true);

				add_post_meta($post_id, 'custom_woo_design_price', $custom_woo_design_price, true);
				add_post_meta($post_id, 'custom_woo_product', $custom_woo_product, true);

				set_post_thumbnail($post_id , $das_post_thumbnail);
				wp_set_object_terms($post_id, $location,'das_categories');

				// This adds the options we neeed to Create a new woo product
				if (is_plugin_active('das-premium/das-premium.php')) {
					include WP_CONTENT_DIR .'/plugins/das-premium/includes/woocommerce-for-das-meta-box.php';
				};
			}

			global $notice_array;
			$notice_array = array();

			$slickPermalink = array(
				'numberposts' => 1,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'designapprovalsystem',
				'post_status' => 'publish',
				'suppress_filters' => true
			);
			$recent_posts = wp_get_recent_posts($slickPermalink);

			foreach( $recent_posts as $recent ){
				$last_post = '<a href="' . get_permalink($recent["ID"]) . '" target="_blank">' . get_permalink($recent["ID"]) .' </a>';
			};
			// $_GET["success"] = isset($_GET["success"]) ? $_GET["success"] : '';
			if(isset($_GET['success']) && $_GET['success'] !== 'yes') {
				$success_variable = get_permalink($_GET["success"]);
				$notice_array[] = 'Your post has been updated.<br/>Please review it here: <a href="' . $success_variable . '">' . $success_variable .'</a><br/>Create a <a href="'.get_permalink().'?tab=2">New Post</a>.';
			}
			else {
				$notice_array[] = 'Your post is live.<br/>Please review it here: '. $last_post .'<br/>Create a <a href="'.get_permalink().'?tab=2">New Post</a>.';
			}

			add_action('simple_das_fep_notices', 'simple_das_fep_notices');
		} else {
			// add_action('simple_das_fep_notices', 'simple_das_errors');
		}
	}

}
add_action('init','simple_das_fep_add_post');

// This spits out the select options for our custom das_categories taxonomy
function custom_taxonomy_dropdown( $taxonomy ) {
	global $post, $my_post_ID;

	// show all das categories by using hide_empty => 0
	$terms = get_terms( $taxonomy, array(
			'orderby'    => 'count',
			'hide_empty' => 0,
		) );
	if ( $terms ) {

		if ($my_post_ID) {  // echo get_the_category( $my_post_ID );
			$terms2 = get_the_terms($my_post_ID, $taxonomy );
			$das_active_post_cat = array();
			foreach ( $terms2 as $term2 ) {
				$das_active_post_cat[] = $term2->name;
			}
			$categories = join( ", ", $das_active_post_cat );
		}
		else {
			$categories = get_post_meta($my_post_ID, 'custom_name_of_design', true);
		}

		echo '<label>Choose an Existing Company Name / Order Number *</label> ';
		printf( '<select name="%s" class="postform" id="existing-project-select">', esc_attr( $taxonomy ) );
		echo '<option value="existing_client">';
		_e('Please Select', 'design-approval-system');
		echo '</option>';
		foreach ( $terms as $term ) {
			printf( '<option value="%s" %s>%s</option>', esc_attr( $term->slug ), esc_html( $categories == $term->name ? 'selected="selected"':'' ), esc_html( $term->name ) );
			//  echo '<option value="'.$term->slug.'"', '>'.$term->name.'</option>';
		}
		print( '</select>' );
	}

}