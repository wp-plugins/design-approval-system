<?php
/**************************************************************
 	File that create custom fields for DAS plugin
***************************************************************/
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
// Add the DAS Meta Box
function add_das_meta_box() {
	add_meta_box(
		'custom_das_meta_box', // $id
		__('Design Approval System Fields', 'design-approval-system'), // $title
		'show_custom_das_meta_box', // $callback
		__('Design Approval System', 'design-approval-system'), // $page
		'normal', // $context
		'high'); // $priority
}
add_action('add_meta_boxes', 'add_das_meta_box');
//DAS metabox array
$prefix = 'custom_';
// if(is_plugin_active('das-roles-extension/das-roles-extension.php')) {
$designer_name_type = 'select_designer_name';
$designer_email_type = 'select_designer_email';
$client_name_type = 'select_client_name';
$client_email_type = 'select_client_email';
//} LEAVE THIS. I forsee an option being needed for people who don't what to have to create a client. Smaller business more likely.
//else {
// $designer_name_type = 'text';
// $designer_email_type = 'text';
// $client_name_type = 'text';
// $client_email_type = 'text';
//}
// Reminder: when making new tabs, their is like 4 or 5 places things need to be updated on this page so they work proper.
//TAB1
$custom_meta_fields_tab1 = array(
	array(
		'label'=> __('Designer\'s Name:', 'design-approval-system'),
		'desc' => __('Full name of Designer on this project.<br/><small>(This will be used on the design template)</small>', 'design-approval-system'),
		'id' => $prefix.'designers_name',
		'type' => $designer_name_type
	),
	array(
		'label'=> __('Designer\'s Email:', 'design-approval-system'),
		'desc' => __('Email address of Designer for this project.<br/><small>(Only 1 email address allowed)</small>', 'design-approval-system'),
		'id' => $prefix.'designers_email',
		'type' => $designer_email_type
	),
	array(
		'label'=> "Designer Notes:",
		'desc' => __('Notes about the project to the client.', 'design-approval-system'),
		'id' => $prefix.'designer_notes',
		'type' => 'textarea'
	)
);
//TAB2
$custom_meta_fields_tab2 = array(
	array(
		'label'=> __('Name of the Project', 'design-approval-system'),
		'desc' => __('The title or name of the project.<br/><small>(Example: Home Page)</small>', 'design-approval-system'),
		'id' => $prefix.'name_of_design',
		'type' => 'text'
	),
	array(
		'label'=> __('Version of the Project:', 'design-approval-system'),
		'desc' => __('What Version of the project is this?', 'design-approval-system'),
		'id' => $prefix.'version_of_design',
		'type' => 'select',
		'options' => array (
			'version1' => array (
				'label' => __('Version 1', 'design-approval-system'),
				'value' => __('Version 1', 'design-approval-system')
			),
			'version2' => array (
				'label' => __('Version 2', 'design-approval-system'),
				'value' => __('Version 2', 'design-approval-system')
			),
			'version3' => array (
				'label' => __('Version 3', 'design-approval-system'),
				'value' => __('Version 3', 'design-approval-system')
			),
			'version4' => array (
				'label' => __('Version 4', 'design-approval-system'),
				'value' => __('Version 4', 'design-approval-system')
			),
			'version5' => array (
				'label' => __('Version 5', 'design-approval-system'),
				'value' => __('Version 5', 'design-approval-system')
			),
			'version6' => array (
				'label' => __('Version 6', 'design-approval-system'),
				'value' => __('Version 6', 'design-approval-system')
			),
			'version7' => array (
				'label' => __('Version 7', 'design-approval-system'),
				'value' => __('Version 7', 'design-approval-system')
			),
			'version8' => array (
				'label' => __('Version 8', 'design-approval-system'),
				'value' => __('Version 8', 'design-approval-system')
			),
			'version9' => array (
				'label' => __('Version 9', 'design-approval-system'),
				'value' => __('Version 9', 'design-approval-system')
			),
			'version10' => array (
				'label' => __('Version 10', 'design-approval-system'),
				'value' => __('Version 10', 'design-approval-system')
			),
			'version11' => array (
				'label' => __('Version 11', 'design-approval-system'),
				'value' => __('Version 11', 'design-approval-system')
			),
			'version12' => array (
				'label' => __('Version 12', 'design-approval-system'),
				'value' => __('Version 12', 'design-approval-system')
			),
			'version13' => array (
				'label' => __('Version 13', 'design-approval-system'),
				'value' => __('Version 13', 'design-approval-system')
			),
			'version14' => array (
				'label' => __('Version 14', 'design-approval-system'),
				'value' => __('Version 14', 'design-approval-system')
			),
			'version15' => array (
				'label' => __('Version 15', 'design-approval-system'),
				'value' => __('Version 15', 'design-approval-system')
			),
			'version16' => array (
				'label' => __('Version 16', 'design-approval-system'),
				'value' => __('Version 16', 'design-approval-system')
			),
			'version17' => array (
				'label' => __('Version 17', 'design-approval-system'),
				'value' => __('Version 17', 'design-approval-system')
			),
			'version18' => array (
				'label' => __('Version 18', 'design-approval-system'),
				'value' => __('Version 18', 'design-approval-system')
			),
			'version19' => array (
				'label' => __('Version 19', 'design-approval-system'),
				'value' => __('Version 19', 'design-approval-system')
			),
			'version20' => array (
				'label' => __('Version 20', 'design-approval-system'),
				'value' => __('Version 20', 'design-approval-system')
			),
			'version21' => array (
				'label' => __('Version 21', 'design-approval-system'),
				'value' => __('Version 21', 'design-approval-system')
			),
			'version22' => array (
				'label' => __('Version 22', 'design-approval-system'),
				'value' => __('Version 22', 'design-approval-system')
			),
			'version23' => array (
				'label' => __('Version 23', 'design-approval-system'),
				'value' => __('Version 23', 'design-approval-system')
			),
			'version24' => array (
				'label' => __('Version 24', 'design-approval-system'),
				'value' => __('Version 24', 'design-approval-system')
			),
			'version25' => array (
				'label' => __('Version 25', 'design-approval-system'),
				'value' => __('Version 25', 'design-approval-system')
			),
		)
	),
	array(
		'label'=> __('Company or Client Name:', 'design-approval-system'),
		'desc' => __('Name of Company or Client this project is for.', 'design-approval-system'),
		'id' => $prefix.'client_name',
		'type' => $client_name_type
	),
	array(
		'label'=> __('Company or Client Email:', 'design-approval-system'),
		'desc' => __('Email address of Company or Client this project is for.<br/><small>(Only 1 email address allowed)</small>', 'design-approval-system'),
		'id' => $prefix.'clients_email',
		'type' => $client_email_type
	),
	array(
		'label'=> __('Project Start and End Date:', 'design-approval-system'),
		'desc' => __('When the project will start and end.<br/><small>(Example: 10-15-12 thru 10-20-12)</small>', 'design-approval-system'),
		'id' => $prefix.'project_start_end',
		'type' => 'text'
	),
//	array(
//		'label'=> __('Client Notes On or Off:', 'design-approval-system'),
//		'desc' => __('Make the client notes viewable on the page.', 'design-approval-system'),
//		'id' => $prefix.'client_notes_on_off',
//		'type' => 'select',
//		'options' => array (
//			'on' => array (
//				'label' => __('Client Notes On', 'design-approval-system'),
//				'value' => 'client-notes-on'
//			),
//			'off' => array (
//				'label' => __('Client Notes Off', 'design-approval-system'),
//				'value' => 'client-notes-off'
//			)
//		)
// 	),
	array(
		'label'=> __('Client Notes:', 'design-approval-system'),
		'desc' => __('Notes from the client about the project. When a client submits comments on the design page they will show up here automatically, if you have the client changes premium extension installed.', 'design-approval-system'),
		'id' => $prefix.'client_notes',
		'type' => 'textarea'
	)
);


// if (is_plugin_active('das-premium/das-premium.php')) {
// 	$custom_meta_fields_tab2[] = array(
//		'label'=> __('Paid or Not Paid Version:', 'design-approval-system'),
//		'desc' => __('Has the next set of design changes been paid for by client? If not select "Not Paid" and the next time the client trys to submit changes they will be notified that they are being charged for additional changes. If a client decides to submit additional changes you will receive an email letting you know that they have accepted, additionally it will send them an email confirming this.', 'design-approval-system'),
//		'id' => $prefix.'paid_not_paid',
	//	'type' => 'select',
	//	'options' => array (
	//		'one' => array (
	//			'label' => __('Paid', 'design-approval-system'),
	//			'value' => 'paid', 'design-approval-system'
	//		),
	//		'two' => array (
	//			'label' => __('Not Paid', 'design-approval-system'),
	//			'value' => 'not-paid', 'design-approval-system'
	//		)
	//	)
//	);
// }


//TAB3
$custom_meta_fields_tab3 = array(
	array(
		'label'=> __('Design Approved:', 'design-approval-system'),
		'desc' => __('Did the client approve this version? If Yes, a STAR will appear for that project & version on your Project Board. This option will automatically change to "Yes" if a client submits their signature, but you can change it manually if you like. Once this option is set to "Yes" your client will not be able to approve this project version from the front end.', 'design-approval-system'),
		'id' => $prefix.'client_approved',
		'type' => 'select',
		'options' => array (
			'No' => array (
				'label' => __('No', 'design-approval-system'),
				'value' => __('No', 'design-approval-system')
			),
			'Yes' => array (
				'label' => __('Yes', 'design-approval-system'),
				'value' => __('Yes', 'design-approval-system')
			)
		)
	),
	array(
		'label'=> __('Client Approved Signature:', 'design-approval-system'),
		'desc' => __('If Approved, your clients digital signature will be here.', 'design-approval-system'),
		'id' => $prefix.'client_approved_signature',
		'type' => 'text'
	)
);
//TAB4
if (is_plugin_active('das-premium/das-premium.php')) {
	$custom_meta_fields_tab4[] = array(
		'label'=> __('Show custom login screen', 'design-approval-system'),
		'desc' => __('You must create a user for your client in wordpress to view this design now.', 'design-approval-system'),
		'id' => $prefix.'login_no_login',
		'type' => 'select',
		'options' => array (
			'two' => array (
				'label' => __('No, Login NOT Required', 'design-approval-system'),
				'value' => 'no-login',
			),
			'one' => array (
				'label' => __('Yes, Login Required', 'design-approval-system'),
				'value' => 'yes-login'
			)
		)
	);
}
//TAB5 START IF WOO for DAS
if (is_plugin_active('das-premium/das-premium.php')) {
	$custom_meta_fields_tab5[] = array(
		'label'=> __('Turn design into a WooCommerce Product?', 'design-approval-system'),
		'desc' => __('Selecting yes will create a product in Woocommerce. Keep "Yes" selected and the Product will always update information in Woocommerce when this design post is saved.', 'design-approval-system'),
		'id' => $prefix.'woo_product',
		'type' => 'select',
		'options' => array (
			'two' => array (
				'label' => __('No, Do not create or update this Design as a Woo product.', 'design-approval-system'),
				'value' => 'no-woo-product', 'design-approval-system'
			),
			'one' => array (
				'label' => __('Yes, Create or Update this Design as a Woo product.', 'design-approval-system'),
				'value' => 'yes-woo-product', 'design-approval-system'
			)
		)
	);
	global $post;
	$das_product_id = get_post_meta($post, 'das_design_woo_product_id', true);
	$custom_woo_product_price = get_post_meta($post, 'custom_woo_product', true);
	$set_woo_product_price = get_post_meta($das_product_id, '_price', true);
	if ($custom_woo_product_price != $set_woo_product_price) {
		$product_set = $set_woo_product_price;
	}//END IF
	else {
		$product_set =$custom_woo_product_price;
	}
	$custom_meta_fields_tab5[] =  array(
		'label'=> __('Price of Design', 'design-approval-system'),
		'desc' => __('Set the price of the design. (This will change the price of the Design product that has been created in WooCommerce)', 'design-approval-system'),
		'id' => $prefix.'woo_design_price',
		'type' => 'text',
		'value' => $product_set
	);
}//END IF WOO for DAS
$custom_meta_fields_tab6[0] = array(
	'label'=> __('Template Selection', 'design-approval-system'),
	'desc' => __('We are always looking for new talented template designers to help develop DAS further. <a href="mailto:info@slickremix.com">Contact us</a> if you are interested.</p>', 'design-approval-system'),
	'id' => $prefix.'das_template_options',
	'type' => 'select',
	'options' => array (
		'one' => array (
			'label' => __('Default GQ Template', 'design-approval-system'),
			'value' => 'das-default-template.php', 'design-approval-system'
		)
	)
);
// TAB7
$custom_meta_fields_tab7[] = array(
	'label'=> __('Terms &amp; Conditions', 'design-approval-system'),
	'desc' => __('By filling this out you will override the default Terms &amp; Conditions filled out on the GQ Template Settings Page for only this post.', 'design-approval-system'),
	'id' => $prefix.'gq-theme-terms-conditions',
	'type' => 'textarea'
);
// The Callback
function show_custom_das_meta_box() {
	global $custom_meta_fields_tab1, $custom_meta_fields_tab2, $custom_meta_fields_tab3, $custom_meta_fields_tab4, $custom_meta_fields_tab5, $custom_meta_fields_tab6, $custom_meta_fields_tab7, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />'; ?>
 <div class="das-panel-wrap">
 <div class="das-tabs-back"></div>
  <div id="das-tabs" class="ui-tabs-vertical ui-helper-clearfix">
  <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header">
    <li id="das-id-1" class="das-tab1"><a href="#das-tabs-1"><?php _e('Designer Info', 'design-approval-system') ?></a></li>
    <li id="das-id-2"><a href="#das-tabs-2"><?php _e('Client Info', 'design-approval-system') ?></a></li>
    <li id="das-id-3"><a href="#das-tabs-3"><?php _e('Approved', 'design-approval-system') ?></a></li>
    <?php if (is_plugin_active('das-premium/das-premium.php')) { ?><li id="das-id-4" style="display:none;"><a href="#das-tabs-4"><?php _e('Custom Login', 'design-approval-system') ?></a></li><?php } ?>
    <?php if (is_plugin_active('das-premium/das-premium.php')) { ?><li id="das-id-5"><a href="#das-tabs-5"><?php _e('Product Info', 'design-approval-system') ?></a></li><?php } ?>
    <li id="das-id-6" style="display:none;"><a href="#das-tabs-6"><?php _e('Template', 'design-approval-system') ?></a></li>
    <li id="das-id-7" style="display:none;"><a href="#das-tabs-7"><?php _e('GQ Options', 'design-approval-system') ?></a></li>
  </ul>
  <?php
	////////////////////////////
	// THIS IS THE FIRST TAB
	//////////////////////////
	// Begin the field table and loop
	echo '<div id="das-tabs-1" class="ui-tabs-panel ui-widget-content"><div class="das-tab-content-padding">';
	foreach ($custom_meta_fields_tab1 as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '
				 <label for="'.$field['id'].'">'.$field['label'].'</label>
				';
		switch ($field['type']) {
			// text
		case 'text':
			echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
			break;
			// Designer Name
		case 'select_designer_name':
			echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
			echo "<option value=''>";
			_e('Please Select Designer', 'design-approval-system');
			echo "</option>";
			$designer_roles = get_option('das-settings-designer-role');
			$designer_users_name = get_users('blog_id=1&orderby=display_name&role='.$designer_roles.'');
			foreach ($designer_users_name as $user) {
				$designer_name = $user->display_name;
				$designer_email = $user->user_email;
				$row = $designer_name;
				echo '<option value="'.$row.'"', $meta == $row ? 'selected="selected"':'', '>'.$row.' ['.$designer_email.'] </option>';
			}
			echo '</select><br /><span class="description">'.$field['desc'].'</span>';
			break;
			// Client Email
		case 'select_designer_email':
			echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
			break;
			// textarea
		case 'textarea':
			echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
			break;
		} //end switch
	} // end foreach
	echo '</div></div>'; // end wrap
	////////////////////////////
	// THIS IS THE SECOND TAB
	//////////////////////////
	// Begin the field table and loop
	echo '<div id="das-tabs-2" class="ui-tabs-panel ui-widget-content"><div class="das-tab-content-padding">';
	foreach ($custom_meta_fields_tab2 as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '
				 <label for="'.$field['id'].'">'.$field['label'].'</label>
				';
		switch ($field['type']) {
			// text
		case 'text':
			echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
			break;
			// textarea
		case 'textarea':
			echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
			break;
			// repeatable
		case 'repeatable':
			echo '<a class="repeatable-add button" href="#">';
			_e('Add Another design', 'design-approval-system');
			echo '</a><ul id="'.$field['id'].'-repeatable" class="custom_repeatable">';
			$i = 0;
			if ($meta) {
				foreach ($meta as $row) {
					echo '<li><span class="sort hndle">|||</span>
											<textarea name="'.$field['id'].'['.$i.']" id="'.$field['id'].'">'.$row.'</textarea>
											<a class="repeatable-remove button" href="#">-</a>
											</li>';
					$i++;
				}
			} else {
				echo '<li><span class="sort hndle">|||</span>
										<textarea name="'.$field['id'].'['.$i.']" id="'.$field['id'].'">'.$row.'</textarea>
										<a class="repeatable-remove button" href="#">';
				_e('Delete this design', 'design-approval-system');
				echo '</a></li>';
			}
			echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
			break;
			// checkbox
		case 'checkbox':
			echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ', $meta ? ' checked="checked"' : '', '/>
							<label for="'.$field['id'].'">'.$field['desc'].'</label>';
			break;
			// select
		case 'select':
			echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
			foreach ($field['options'] as $option) {
				echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
			}
			echo '</select><br /><span class="description">'.$field['desc'].'</span>';
			break;
			// Client Name
		case 'select_client_name':
			echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
			echo '<option value="">';
			_e('Please Select Client', 'design-approval-system');
			echo '</option>';
			$client_roles = get_option('das-settings-client-role');
			$client_users_name = get_users('blog_id=1&orderby=display_name&role='.$client_roles.'');
			foreach ($client_users_name as $user) {
				$clients_name = $user->display_name;
				$clients_email = $user->user_email;
				$row = $clients_name;
				echo '<option value="'.$row.'"', $meta == $row ? 'selected="selected"':'', '>'.$row.' ['.$clients_email.'] </option>';
			}
			echo '</select><br /><span class="description">'.$field['desc'].'</span>';
			break;
			// Client Email
		case 'select_client_email':
			echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
			break;
		} //end switch
	} // end foreach
	echo '</div></div>'; // end wrap
	////////////////////////////
	// THIS IS THE THIRD TAB
	//////////////////////////
	// Begin the field table and loop
	echo '<div id="das-tabs-3" class="ui-tabs-panel ui-widget-content"><div class="das-tab-content-padding">';
	foreach ($custom_meta_fields_tab3 as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '
				 <label for="'.$field['id'].'">'.$field['label'].'</label>
				';
		switch ($field['type']) {
			// text
		case 'text':
			echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
			break;
			// select
		case 'select':
			echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
			foreach ($field['options'] as $option) {
				echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
			}
			echo '</select><br /><span class="description">'.$field['desc'].'</span>';
			break;
		} //end switch
	} // end foreach
	echo '</div></div>'; // end wrap
	if (is_plugin_active('das-premium/das-premium.php')) {
		////////////////////////////
		// THIS IS THE FOURTH TAB
		//////////////////////////
		// Begin the field table and loop
		echo '<div id="das-tabs-4" class="ui-tabs-panel ui-widget-content"><div class="das-tab-content-padding">';
		foreach ($custom_meta_fields_tab4 as $field) {
			// get value of this field if it exists for this post
			$meta = get_post_meta($post->ID, $field['id'], true);
			// begin a table row with
			echo '
				 <label for="'.$field['id'].'">'.$field['label'].'</label>
				';
			switch ($field['type']) {
				// select
			case 'select':
				echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
				}
				echo '</select><br /><span class="description">'.$field['desc'].'</span>';
				break;
			} //end switch
		} // end foreach
		echo '</div></div>';
	}; // end das-design-login
	if (is_plugin_active('das-premium/das-premium.php')) {
		////////////////////////////
		// THIS IS THE FIFTH TAB
		//////////////////////////
		// Begin the field table and loop
		echo '<div id="das-tabs-5" class="ui-tabs-panel ui-widget-content"><div class="das-tab-content-padding">';
		foreach ($custom_meta_fields_tab5 as $field) {
			// get value of this field if it exists for this post
			$meta = get_post_meta($post->ID, $field['id'], true);
			// begin a table row with
			echo '
				 <label for="'.$field['id'].'">'.$field['label'].'</label>
				';
			switch ($field['type']) {
				// text
			case 'text':
				echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
				break;
				// select
			case 'select':
				echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
				foreach ($field['options'] as $option) {
					echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
				}
				echo '</select><br /><span class="description">'.$field['desc'].'</span>';
				break;
			} //end switch
		} // end foreach
		echo '</div></div>';
	}; // end woocommerce-for-das
	////////////////////////////
	// THIS IS THE SIXTH TAB
	//////////////////////////
	// Begin the field table and loop
	echo '<div id="das-tabs-6" class="ui-tabs-panel ui-widget-content"><div class="das-tab-content-padding">';
	foreach ($custom_meta_fields_tab6 as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '
				 <label for="'.$field['id'].'">'.$field['label'].'</label>
				';
		switch ($field['type']) {
			// text
		case 'text':
			echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
							<br /><span class="description">'.$field['desc'].'</span>';
			break;
			// select
		case 'select':
			echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
			foreach ($field['options'] as $option) {
				echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
			}
			echo '</select><br /><span class="description">'.$field['desc'].'</span>';
			break;
		} //end switch
	} // end foreach
	echo '</div></div>';  //end tab6
	////////////////////////////
	// THIS IS THE 7th TAB
	//////////////////////////
	// Begin the field table and loop
	echo '<div id="das-tabs-7" class="ui-tabs-panel ui-widget-content"><div class="das-tab-content-padding">';
	foreach ($custom_meta_fields_tab7 as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '
				 <label for="'.$field['id'].'">'.$field['label'].'</label>
				';
		switch ($field['type']) {
			// textarea
		case 'textarea':
			echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
							<br /><span class="description">'.$field['desc'].'</span>';
			break;
		} //end switch
	} // end foreach
	echo '</div></div>'; //end tab7
	echo '</div></div>'; // end tabs padding and main divs
} // Show show_custom_das_meta_box
// Save the Data
function save_custom_meta($post_id) {
	global $custom_meta_fields_tab1, $custom_meta_fields_tab2, $custom_meta_fields_tab3, $custom_meta_fields_tab4, $custom_meta_fields_tab5,  $custom_meta_fields_tab6,  $custom_meta_fields_tab7;
	$_POST['custom_meta_box_nonce'] = isset($_POST['custom_meta_box_nonce']) ? $_POST['custom_meta_box_nonce'] : '';
	// verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
		return $post_id;
	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	// loop through fields and save the data
	foreach ($custom_meta_fields_tab1 as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
	// loop through fields and save the data
	foreach ($custom_meta_fields_tab2 as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
	// loop through fields and save the data
	foreach ($custom_meta_fields_tab3 as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
	if (is_plugin_active('das-premium/das-premium.php')) {
		// loop through fields and save the data
		foreach ($custom_meta_fields_tab4 as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		} // end foreach
	};
	if (is_plugin_active('das-premium/das-premium.php')) {
		// loop through fields and save the data
		foreach ($custom_meta_fields_tab5 as $field) {
			$old = get_post_meta($post_id, $field['id'], true);
			$new = $_POST[$field['id']];
			if ($new && $new != $old) {
				update_post_meta($post_id, $field['id'], $new);
			} elseif ('' == $new && $old) {
				delete_post_meta($post_id, $field['id'], $old);
			}
		} // end foreach
	};
	// loop through fields and save the data
	foreach ($custom_meta_fields_tab6 as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
	// loop through fields and save the data
	foreach ($custom_meta_fields_tab7 as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];
		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], $new);
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	} // end foreach
	//Woo for DAS
	if (is_plugin_active('das-premium/das-premium.php')) {
		include(WP_CONTENT_DIR .'/plugins/das-premium/includes/woocommerce-for-das-meta-box.php');
	};
}
add_action('save_post', 'save_custom_meta');
?>