<?php 
function das_projects_page() {
	
global $current_user; get_currentuserinfo();
										
$user_id = $current_user->ID;
$user_blogs = get_blogs_of_user( $user_id );

foreach ($user_blogs AS $user_blog) {
  if ($user_blog->path == '/'){
	  # do nothing
  }
  else {
 	 $user_blog_id = $user_blog->userblog_id;
  }
}
if (current_user_can_for_blog($user_blog_id, 'administrator') || current_user_can_for_blog($user_blog_id, 'das_designer')) {
?>
<div class="das-project-admin-wrap">
<a class="buy-extensions-btn" href="http://www.slickremix.com/product-category/design-approval-system-extensions/" target="_blank"><?php _e('Get Extensions Here!', 'design-approval-system') ?></a>
<h2 class="project-board-header"><?php _e('Project Board', 'design-approval-system') ?></h2>
<div class="use-of-plugin"><?php _e('Below are your Clients and their Projects: We suggest you use the', 'design-approval-system') ?> <a href="http://www.slickremix.com/product/select-user-and-email-extension/" target="_blank"><?php _e('Select User and Email, DAS Extension', 'design-approval-system') ?></a> <?php _e('to make this list work seamlessly. Learn how to use and setup the', 'design-approval-system') ?> <a href="http://www.slickremix.com/2013/01/22/das-project-board-tutorial/" target="_blank"><?php _e('Project Board Here', 'design-approval-system') ?></a>. </div>
<?php
//Custom DAS Post Type
$post_type = 'designapprovalsystem';
//Custom DAS Taxonomies (aka Categories)
$tax = 'das_categories';

$client = get_terms( $tax );

//Client and Terms arrays.
$clients_names = array();
$term_names = array();
$post_counts = array();
$approved_main_designs_count = array();

//Loop to custom taxonomy to build Client and Terms arrays.
foreach ($client as $term) :
	$args = array(
	  'post_type' => $post_type,
	  'posts_per_page' => -1,
	  'post_status'   => 'publish',
	  'ignore_sticky_posts' => 1,
	  'tax_query' => array(
			   array(
				 'taxonomy' => $tax,
				 'field'    => 'ID',
				 'terms'   => array( $term->term_id )
			   ),	 
	   ), 
	   'orderby' => 'title', 
	   'order' => 'ASC'
	);
	$my_query2 = new WP_Query($args);
	
	 $post_counts[] = $my_query2->post_count;
	 
	if( $my_query2->have_posts() ) : 
	  while ( $my_query2->have_posts() ) : $my_query2->the_post(); global $post;   
		$clients_name = get_post_meta($post->ID, 'custom_client_name', true);
		  $clients_names[] = $clients_name;
		  $term_names[$term->name] = $clients_name;
		  
		  $title_approved_checker = get_post_meta($post->ID, 'custom_client_approved', true);
		  $approved_main_designs_count[$clients_name][$term->name][] = $title_approved_checker;
											
	endwhile; endif;   		
endforeach;
//END Build Arrays
 
//Clean up Clients Array So no duplicate client titles happen.
$final_clients_names = array_unique($clients_names);

//Start loop for displaying Client Name [Final Build loop]				
foreach ($final_clients_names as $key => $value) :
$first_counter = 0;	

//Client Name	
echo '<h2>'.$value.'</h2>'; 

//Client Name value for check.
$client_value = $value;

$counter = 0;

	//loop for displaying Project Name
	foreach ($term_names as $key => $value) :
	  $term_value = $value; 
	if($client_value == $value) {
		
		?>
<h3 class='pb-cat-header'> <?php echo $key ?>
  <?php if(in_array("Yes", $approved_main_designs_count[$value][$key])) { echo'<div class="das-approved-design-subtitle"></div>'; } ?>
  <span><?php echo $post_counts[$counter]; ?></span></h3>
<?php echo "<div class='das-project-list-wrap'>";
			echo "<ul class='das-project-list'>";
		//loop for displaying posts for Project
		foreach ($client as $term) :
		$args = array(
			'post_type' => $post_type,
			'posts_per_page' => -1,
			'post_status'   => 'publish',
			'caller_get_posts' => 1,
			'orderby' => 'name',
			'order' => 'ASC',
			'tax_query' => array(
					 array(
					   'taxonomy' => $tax,
					   'field'    => 'ID',
					   'terms'   => array( $term->term_id )
					 ),	 
			 ), 
			 'orderby' => 'name', 
			 'order' => 'ASC'
		  );
		  
		   
		   $my_query = new WP_Query($args);
		   	 	
						if( $my_query->have_posts() ) : ?>
<?php while ( $my_query->have_posts() ) : $my_query->the_post(); global $post; 
								
							 
								$final_client_value = get_post_meta($post->ID, 'custom_client_name', true);
								$final_term_value = $term->name;
								
								//Design Link creation
								if(($term_value == $final_client_value) && ($key == $final_term_value)) {?>
<li>
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
        
       
        <strong><?php _e('Client Email', 'design-approval-system') ?></strong>: <a href="mailto:<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>"><?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?></a><br/>
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
</li>
<?php }
					    endwhile; endif;   ?>
<?php endforeach; 
			echo "</ul>";
		echo "</div>";
		}
		$counter++;
	endforeach;
	
endforeach;

$first_counter++;


		  
// Restore original Query & Post Data
wp_reset_query();
wp_reset_postdata();
?>
<?php
// this ends the if das user is logged in or not action

} else {
global $current_user; get_currentuserinfo();
										
$user_id = $current_user->ID;
$user_blogs = get_blogs_of_user( $user_id );

foreach ($user_blogs AS $user_blog) {
  if ($user_blog->path == '/'){
	  # do nothing
  }
  else {
	  
  $user_blog_id = $user_blog->userblog_id;
  
  }
}
$user = wp_get_current_user();
$this_users_email = $user->user_email;

?>
<div class="das-project-admin-wrap">
  <h2 class="project-board-header"><?php _e('Project Board', 'design-approval-system') ?></h2>
  <?php

//Custom DAS Post Type
$post_type = 'designapprovalsystem';
//Custom DAS Taxonomies (aka Categories)
$tax = 'das_categories';

$client = get_terms( $tax );

//Client and Terms arrays.
$clients_emails = array();
$clients_names = array();
$term_names = array();
$post_counts = array();

//Loop to custom taxonomy to build Client and Terms arrays.
foreach ($client as $term) :
	$args = array(
	  'post_type' => $post_type,
	  'post_per_page' => 0,
	  'post_status'   => 'publish',
	  'caller_get_posts' => 1,
	  'tax_query' => array(
			   array(
				 'taxonomy' => $tax,
				 'field'    => 'ID',
				 'terms'   => array( $term->term_id )
			   ),	 
	   ), 
	   'orderby' => 'title', 
	   'order' => 'ASC'
	);
	$my_query2 = new WP_Query($args);
	
	 $post_counts[] = $my_query2->post_count;
	 
	if( $my_query2->have_posts() ) : 
	     while ( $my_query2->have_posts() ) : $my_query2->the_post(); global $post;   
		$clients_email = get_post_meta($post->ID, 'custom_clients_email', true);
		  $clients_emails[] = $clients_email;
		  $term_names[$term->name] = $clients_email;
		  $clients_names[] = get_post_meta($post->ID, 'custom_client_name', true);
		  
		  $title_approved_checker = get_post_meta($post->ID, 'custom_client_approved', true);
		  $approved_main_designs_count[$clients_email][$term->name][] = $title_approved_checker;
											
	endwhile; endif;   		
endforeach;
//END Build Arrays
 
//Clean up Clients Array So no duplicate client titles happen.
$final_clients_emails = array_unique($clients_emails);
			
//Start loop for displaying Client Name [Final Build loop]				
foreach ($final_clients_emails as $key => $value)  :

if ($value == $this_users_email) {
	
	foreach($clients_names as $number => $title){
		if ($number == $key) {
			$client_title = $title;
		}
	}
	
//Client Name	
echo "<h2>".$client_title."</h2>"; 

//Client Name value for check.
$client_value = $value;

$counter = 0;
	//loop for displaying Project Name
	foreach ($term_names as $key => $value) :
	  $term_value = $value; 
	if($client_value == $value) {
		
		?>
<h3 class='pb-cat-header'> <?php echo $key ?>
  <?php if(in_array("Yes", $approved_main_designs_count[$value][$key])) { echo'<div class="das-approved-design-subtitle"></div>'; } ?>
  <span><?php echo $post_counts[$counter]; ?></span></h3>
<?php echo "<div class='das-project-list-wrap'>";
			echo "<ul class='das-project-list'>";
		//loop for displaying posts for Project
		foreach ($client as $term) :
		$args = array(
			'post_type' => $post_type,
			'post_per_page' => -1,
			'post_status'   => 'publish',
			'caller_get_posts' => 1,'orderby'                  => 'name',
	'order'                    => 'ASC',
			'tax_query' => array(
					 array(
					   'taxonomy' => $tax,
					   'field'    => 'ID',
					   'terms'   => array( $term->term_id )
					 ),	 
			 ), 
			 'orderby' => 'name', 
			 'order' => 'ASC'
		  );
		   $my_query = new WP_Query($args);
		   	 	
						if( $my_query->have_posts() ) : ?>
  <?php while ( $my_query->have_posts() ) : $my_query->the_post(); global $post; 
								
							
								$final_client_value = get_post_meta($post->ID, 'custom_clients_email', true);
								$final_term_value = $term->name;
								
								//Design Link creation
								if(($term_value == $final_client_value) && ($key == $final_term_value)) {?>
  <li>
    <div class='project-large-thumbnail'>
      <?php
													if ( has_post_thumbnail()) {
													   echo the_post_thumbnail('thumbnail');
													} else {
													 //do nothing or whatever you need when no custom field or text was found
													  echo "<div class='pb-no-thumbnail-image'></div>";
													}
												?>
      <a href='<?php the_permalink();?>' title='<?php the_title_attribute(); ?>' target="_blank" class='project-list-link'><?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?></a>
      <?php 
											
											$name = get_post_meta($post->ID, 'custom_client_approved', true);
												if ($name == 'Yes'){ ?>
      <div class="das-approved-design"><a class="icon-view-all" target="_blank" href="<?php the_permalink();?>"><span class="view-all-articles"><?php _e('Approved', 'design-approval-system') ?><span class="arrow-right"></span></span></a></div>
      <?php 
												} else {
												 //do nothing or whatever you need when no custom field or text was found
												}
										
										
 //Woo for DAS
								if(is_plugin_active('woocommerce-for-das/woocommerce-for-das.php') && is_plugin_active('woocommerce/woocommerce.php')) { 										
	//WOOCOMMERCE 
							 	$custom_woo_product = get_post_meta($post->ID, 'custom_woo_product', true);
								$das_product_id = get_post_meta($post->ID, 'das_design_woo_product_id', true); 
								echo $das_product_price;
								
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
							} //END IF WOOCOMMERCE and DAS
												
	?>
          
    </div>
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
								
		  <? } ?>
         <strong><?php _e('Client Email', 'design-approval-system') ?></strong>: <a href="mailto:<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>"><?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?></a><br/>
         <strong><?php _e('Designer', 'design-approval-system') ?></strong>: <?php echo get_post_meta($post->ID, 'custom_designers_name', true); ?><br/>
         <?php
		 if(get_post_meta($post->ID, 'custom_client_approved', true) == 'Yes') { ?>
        <strong><?php _e('Client Approved', 'design-approval-system') ?></strong>: <span class="custom_client_approved"><?php echo get_post_meta($post->ID, 'custom_client_approved', true); ?><span class="arrow-right"></span></span><br/>
        <strong><?php _e('Client Signature', 'design-approval-system') ?></strong>: <span class="custom_client_approved"><?php echo get_post_meta($post->ID, 'custom_client_approved_signature', true); ?><span class="arrow-right"></span></span><br/>
        <?php }  
                else { }
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
  </li>
  <?php }
  
					    endwhile; endif;   ?>
  <?php endforeach; 
			echo "</ul>";
		echo "</div>";
		}
		$counter++;
	endforeach;
} 
endforeach;
$first_counter++;

 }
 




		  
// Restore original Query & Post Data
wp_reset_query();
wp_reset_postdata();
?>
  <br class="clear"/>
  <a class="das-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a> </div>
<!--/das-help-admin-wrap--> 
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("li").hover(function(){
				jQuery(this).find('.project-notes-entry-utility').show();
			},
		function(){
			jQuery(this).find('.project-notes-entry-utility').fadeOut('fast');
		 }); 
		 
		 jQuery('.project-notes-show').click(function() {
            jQuery(this).nextAll('.project-notes-wrap:first').toggle();
        return false;
    });
	
		 jQuery('.project-notes-show-all').click(function() {
            jQuery('.project-notes-wrap').toggle();
        return false;
    });
	
	 jQuery('.pb-cat-header').click(function() {
            jQuery(this).next('.das-project-list-wrap').slideToggle('fast');
        return false;
    });
	
	}); 
</script>
<?php
	if (current_user_can('edit_post')) {
		include('walkthrough/walkthrough.php');	
	}
}
?>