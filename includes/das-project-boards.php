 <div class='project-large-thumbnail'>
    <?php if ( has_post_thumbnail()) {
													   echo the_post_thumbnail('thumbnail');
													} else {
													 //do nothing or whatever you need when no custom field or text was found
													  echo "<div class='pb-no-thumbnail-image'></div>";
													} 
											  ?>
    <?php 
											//Check if Design is Approved
											$approved_check = get_post_meta($post->ID, 'custom_client_approved', true);
												if ($approved_check == 'Yes'){ 
												?>
    <div class="das-approved-design"><a class="icon-view-all" target="_blank" href="<?php the_permalink();?>"><span class="view-all-articles"><?php _e('Approved', 'design-approval-system') ?><span class="arrow-right"></span></span></a></div>
    
    
    
    
    						    <?php  //Woo for DAS
								if(is_plugin_active('woocommerce-for-das/woocommerce-for-das.php') && is_plugin_active('woocommerce/woocommerce.php')) { 
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
										if (wc_customer_bought_product($client_email, $client_id->ID, $das_product_id )) { ?>
											<div class="das-purchased-design"><a class="icon-view-all" target="_blank" href="<?php the_permalink();?>"><span class="view-all-articles"><?php _e('Purchased', 'design-approval-system') ?><span class="arrow-right"></span></span></a></div><?php
										}
										else{
											// might put shopping cart icon here echo 'Not Purchased';
										}
										//END WOOCOMMERCE
								}	//END IF WOOCOMMERCE and DAS			
						}
				?>
    
    <a href='<?php the_permalink();?>' title='<?php the_title_attribute(); ?>' target="_blank" class='project-list-link'><?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?></a> </div>
  
  <div class="pb-board-cover">
          <span class="project-notes-entry-utility project-notes-backg"></span>
          <?php if( current_user_can_for_blog($user_blog_id, 'administrator') || current_user_can_for_blog($user_blog_id, 'das_designer') ) : ?>
          <?php edit_post_link( __('Edit', 'design-approval-system'), '<span class="edit-link project-notes-entry-utility project-notes-edit">', '</span>' ); ?>
          <?php else : ?>
          <span class="edit-link project-notes-entry-utility project-notes-edit"><a href="<?php the_permalink();?>" target="_blank" title="<?php the_title_attribute(); ?>"><?php _e('View', 'design-approval-system') ?></a></span>
          <?php endif; ?>
          <span class="project-notes-entry-utility project-day-date">
          <?php the_time('l') ?>
          <br/>
          <?php the_time('F jS, Y') ?>
          </span> <span class="project-notes-entry-utility project-notes-show"><a href="#" title="Details"><?php _e('Details', 'design-approval-system') ?></a></span>
   </div><!--pb-board-cover-->
   
  <div class="project-notes-wrap">
    <div class="project-details-wrap">
      <div class='project-notes-text-header'><?php _e('Details', 'design-approval-system') ?></div>
      <div class='project-notes-detail-text-wrap'> <strong><?php _e('Post Name', 'design-approval-system') ?>:</strong> <a href='<?php the_permalink();?>' target="_blank" title='<?php the_title_attribute(); ?>'>
        <?php the_title(); ?>
        </a><br/>
        <strong><?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?></strong><br/>
        <strong><?php _e('Design Name', 'design-approval-system') ?></strong>: <?php echo get_post_meta($post->ID, 'custom_name_of_design', true); ?><br/>
        
        <?php if (get_post_meta($post->ID, 'custom_project_start_end', true) == '') { ?> 
                            <?php } 
							else { ?>
                            
                            <strong><?php _e('Timeline', 'design-approval-system') ?></strong>: <?php echo get_post_meta($post->ID, 'custom_project_start_end', true); ?><br/>
								
		<?	} ?>
        
       
        <?php 
			// SRL . check to make sure the client logged in == $client_value so we know to show the email or not for the public project board. If the admin or designer are logged in they can see all emails on all projects, but if a client is logged in and looking at the project board they cannot see any projects emails, but they will be able to see email on there projects.
			$client_email_pb_check = get_post_meta($post->ID, 'custom_clients_email', true);
			
		if( current_user_can_for_blog($user_blog_id, 'administrator') || current_user_can_for_blog($user_blog_id, 'das_designer') || $client_value == $client_email_pb_check  ) : ?>
 		 <strong><?php _e('Client Email', 'design-approval-system') ?></strong>: <a href="mailto:<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>"><?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?></a><br/>
 		<?php endif; ?>
        <strong><?php _e('Designer', 'design-approval-system') ?></strong>: <?php echo get_post_meta($post->ID, 'custom_designers_name', true); ?><br/>
        <?php 
			   if(get_post_meta($post->ID, 'custom_client_approved', true) == 'Yes') { ?>
        <strong><?php _e('Client Approved', 'design-approval-system') ?></strong>: <span class="custom_client_approved"><?php echo get_post_meta($post->ID, 'custom_client_approved', true); ?><span class="arrow-right"></span></span><br/>
        <strong><?php _e('Client Signature', 'design-approval-system') ?></strong>: <span class="custom_client_approved"><?php echo get_post_meta($post->ID, 'custom_client_approved_signature', true); ?><span class="arrow-right"></span></span><br/>
          <?php }  
                else {
                	
                }
               
			   if($custom_woo_product) {
					echo '<br/><strong>Cost:</strong> ' . get_post_meta($das_product_id, '_regular_price', true);    
			   }
			   
			    ?>
                
        
         
         
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div>
    <?php
					$custom_designer_notes = get_post_meta($post->ID, 'custom_designer_notes', true);
					if ($custom_designer_notes){
					   echo "<div class='project-text-header-designer-notes'>Designer Notes</div>";
					   echo "<div class='project-notes-text-padding'>";
					   echo get_post_meta($post->ID, 'custom_designer_notes', true); 
					   echo "</div>";
					} else {
					 //do nothing or whatever you need when no custom field or text was found
					}
				?>
    <?php
					$custom_client_notes = get_post_meta($post->ID, 'custom_client_notes', true);
					if ($custom_client_notes){
					   echo "<div class='project-text-header-client-notes'>Client Notes</div>";
					   echo "<div class='project-notes-text-padding'>";
					   echo get_post_meta($post->ID, 'custom_client_notes', true); 
					   echo "</div>";
					} else {
					 //do nothing or whatever you need when no custom field or text was found
					}
				?>
  </div>