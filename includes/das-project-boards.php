<?php
	
$output .= '<div class="project-large-thumbnail">';
    if ( has_post_thumbnail()) {
		$output .= get_the_post_thumbnail($post->ID,'thumbnail');
	} else {
		//do nothing or whatever you need when no custom field or text was found
		$output .= '<div class="pb-no-thumbnail-image"></div>';
	} 
	
	//Check if Design is Approved
	$approved_check = get_post_meta($post->ID, 'custom_client_approved', true);
	if ($approved_check == 'Yes'){ 
											
	    $output .= '<div class="das-approved-design"><a class="icon-view-all" target="_blank" href="'.get_permalink($post->ID).'"><span class="view-all-articles">'. __('Approved', 'design-approval-system').'<span class="arrow-right"></span></span></a></div>';
	    
		//Woo for DAS
		if(is_plugin_active('woocommerce/woocommerce.php') && is_plugin_active('das-premium/das-premium.php')) { 
			//WOOCOMMERCE 
			$custom_woo_product = get_post_meta($post->ID, 'custom_woo_product', true);
			$das_product_id = get_post_meta($post->ID, 'das_design_woo_product_id', true); 
			
			if ($custom_woo_product == 'yes-woo-product' && !empty($das_product_id)) {
				//Price of Design
				$das_product_price = get_post_meta($das_product_id, '_regular_price', true);
			}
			
			//Client Email
			$client_email = get_post_meta($post->ID, 'custom_clients_email', true);
			//Get user ID for design based on client's email
			$client_id = get_user_by( 'email', $client_email );
			
			//Check if client Purchased design
			if (wc_customer_bought_product($client_email, $client_id->ID, $das_product_id )) { 
					$output .= '<div class="das-purchased-design"><a class="icon-view-all" target="_blank" href="'.get_permalink($post->ID).'"><span class="view-all-articles">'.__('Purchased', 'design-approval-system').'<span class="arrow-right"></span></span></a></div>';
			}
			else{
				// might put shopping cart icon here echo 'Not Purchased';
			}
			//END WOOCOMMERCE
		}	//END IF WOOCOMMERCE and DAS			
	}
	
    $output .= '<a href="'.get_permalink($post->ID).'" title="'.the_title_attribute('echo=0').'" target="_blank" class="project-list-link">'.get_post_meta($post->ID, 'custom_version_of_design', true).'</a></div>';
  
   $output .= '<div class="pb-board-cover">';
          $output .= '<span class="project-notes-entry-utility project-notes-backg"></span>';
			if( current_user_can('administrator') || current_user_can('das_designer') ) {
				$front_end = get_option('das_frontend_post');
				
				$edit_link_url = !is_admin() ? '?das_post='.$post->ID.'&tab=2' :  get_edit_post_link($post->ID);
				
				$output .= isset($front_end) && $front_end == 'yes' ? '<span class="edit-link project-notes-entry-utility project-notes-edit"><a href="'.$edit_link_url.'">'.__('Edit', 'design-approval-system').'</a></span>' : '<span class="edit-link project-notes-entry-utility project-notes-edit"><a href="'.$edit_link_url.'">'.__('Edit', 'design-approval-system').'</a>  or '.$this->wp_das_delete_post_link().'</span>';
			}
			else {
			    $output .= '<span class="edit-link project-notes-entry-utility project-notes-edit"><a href="'.get_permalink($post->ID).'" target="_blank" title="'.the_title_attribute('echo=0').'">'.__('View', 'design-approval-system').'</a></span>';
			}
          $output .= '<span class="project-notes-entry-utility project-day-date">';
          $output .= get_the_time('l',$post->ID);
          $output .= '<br/>';
          $output .= get_the_time('F jS, Y',$post->ID);
          $output .= '</span> <span class="project-notes-entry-utility project-notes-show"><a href="#" title="Details">'.__('Details', 'design-approval-system').'</a></span>';
   $output .= '</div><!--pb-board-cover-->';
   
  $output .= '<div class="project-notes-wrap">';
    $output .= '<div class="project-details-wrap">';
      $output .= '<div class="project-notes-text-header">'.__('Details', 'design-approval-system').'</div>';
      $output .= '<div class="project-notes-detail-text-wrap"><strong>'.__('Post Name', 'design-approval-system').': </strong><a href="'.get_permalink($post->ID).'" target="_blank" title="'.the_title_attribute('echo=0').'">';
        $output .= the_title_attribute('echo=0');
        $output .= '</a><br/>';
        $output .= '<strong>'.get_post_meta($post->ID, 'custom_version_of_design', true).'</strong><br/>';
        $output .= '<strong>'.__('Company', 'design-approval-system').'</strong>: '.get_post_meta($post->ID, 'custom_name_of_design', true).'<br/>';
        
        	if (get_post_meta($post->ID, 'custom_project_start_end', true) != '') {  
            	$output .= '<strong>'.__('Timeline', 'design-approval-system').'</strong>: '.get_post_meta($post->ID, 'custom_project_start_end', true).'<br/>';
			} 
       
		// SRL . check to make sure the client logged in == $client_value so we know to show the email or not for the public project board. If the admin or designer are logged in they can see all emails on all projects, but if a client is logged in and looking at the project board they cannot see any projects emails, but they will be able to see email on there projects.
		$client_email_pb_check = get_post_meta($post->ID, 'custom_clients_email', true);
			
		if( current_user_can('administrator') || current_user_can('das_designer') || $client_value == $client_email_pb_check  ) { 
 			$output .= '<strong>'.__('Contact Email', 'design-approval-system').'</strong>: <a href="mailto:'.get_post_meta($post->ID, 'custom_clients_email', true).'">'.get_post_meta($post->ID, 'custom_clients_email', true).'</a><br/>';
 		} 
        $output .= '<strong>'.__('Designer', 'design-approval-system').'</strong>: '.get_post_meta($post->ID, 'custom_designers_name', true).'<br/>';
        
		if(get_post_meta($post->ID, 'custom_client_approved', true) == 'Yes') {
	        $output .= '<strong>'.__('Client Approved', 'design-approval-system').'</strong>: <span class="custom_client_approved">'.get_post_meta($post->ID, 'custom_client_approved', true).'<span class="arrow-right"></span></span><br/>';
	        $output .= '<strong>'.__('Client Signature', 'design-approval-system').'</strong>: <span class="custom_client_approved">'.get_post_meta($post->ID, 'custom_client_approved_signature', true).'<span class="arrow-right"></span></span><br/>';
        }  
		  
           
			//Woo for DAS
			if(is_plugin_active('woocommerce/woocommerce.php') && is_plugin_active('das-premium/das-premium.php')) { 
			   
			   $das_product_id = get_post_meta($post->ID, 'das_design_woo_product_id', true); 	   
			   $woofordascost = get_post_meta($das_product_id, '_regular_price', true);
			   $wooactualdasproduct = get_post_meta($post->ID, 'custom_woo_product', true); 
			   if($woofordascost && $wooactualdasproduct == 'yes-woo-product') {
					$output .= '<br/><strong>'.__('Cost:', 'design-approval-system').'</strong> '. get_post_meta($das_product_id, '_regular_price', true);    
			   }
			}
			  
        $output .= '<div class="clear"></div>';
      $output .= '</div>';
      $output .= '<div class="clear"></div>';
    $output .= '</div>';
 					//Designer Notes
					$custom_designer_notes = get_post_meta($post->ID, 'custom_designer_notes', true);
					if ($custom_designer_notes){
					  $output .= '<div class="project-text-header-designer-notes">Designer Notes</div>';
					  $output .= '<div class="project-notes-text-padding">';
					  $output .= get_post_meta($post->ID, 'custom_designer_notes', true); 
					  $output .= '</div>';
					}
					//Client Notes
					$custom_client_notes = get_post_meta($post->ID, 'custom_client_notes', true);
					if ($custom_client_notes){
					   $output .= '<div class="project-text-header-client-notes">'.__('Client Notes', 'design-approval-system').'</div>';
					   $output .= '<div class="project-notes-text-padding">';
					   $output .= get_post_meta($post->ID, 'custom_client_notes', true); 
					   $output .= '</div>';
					}
$output .= '</div>';
?>