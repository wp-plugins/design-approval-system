<?php
function das_projects_page() {
?>
<link rel="stylesheet" id="das-settings-admin-css" href="<?php print DAS_PLUGIN_PATH ?>/design-approval-system/admin/css/admin-settings.css" type="text/css" media="all">

<?php
if (is_admin_logged_in()) {
?>

<div class="das-project-admin-wrap">
<a class="buy-extensions-btn" href="http://www.slickremix.com/product-category/design-approval-system-extensions/" target="_blank">Get Extensions Here!</a>
<h2 class="project-board-header">Project Board</h2>
<div class="use-of-plugin">Below are your Clients and their Projects: We suggest you use the <a href="http://www.slickremix.com/product/select-user-and-email-extension/" target="_blank">Select User and Email, DAS Extension</a> to make this list work seamlessly. Learn how to use and setup the <a href="http://www.slickremix.com/2013/01/22/das-project-board-tutorial/" target="_blank">Project Board Here</a>. </div>

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

//Loop to custom taxonomy to build Client and Terms arrays.
foreach ($client as $term) :
	$args = array(
	  'post_type' => $post_type,
	  'post_per_page' => -1,
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
		$clients_name = get_post_meta($post->ID, 'custom_client_name', true);
		  $clients_names[] = $clients_name;
		  $term_names[$term->name] = $clients_name;
		  
		 			 
	endwhile; endif;   	
endforeach;
//END Build Arrays
 
//Clean up Clients Array So no duplicate client titles happen.
$final_clients_names = array_unique($clients_names);
			
//Start loop for displaying Client Name [Final Build loop]				
foreach ($final_clients_names as $key => $value) :

//Client Name	
echo "<h2>".$value."</h2>"; 

//Client Name value for check.
$client_value = $value;

$counter = 0;
	//loop for displaying Project Name
	foreach ($term_names as $key => $value) :
	  $term_value = $value;
	
	if($client_value == $value) {
		echo "<h3 class='pb-cat-header'>".$key." <span>".$post_counts[$counter]."</span></h3>";
	
		echo "<div class='das-project-list-wrap'>";
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
								
							 
							 
								$final_client_value = get_post_meta($post->ID, 'custom_client_name', true);
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
                                             </div>	
                                             
											<span class="project-notes-entry-utility project-notes-backg"></span>
                                              
                                           
                      
					 
                                            <?php global $user_ID; if( $user_ID ) : ?>
<?php if( current_user_can('level_10') ) : ?>

<?php edit_post_link( __( 'Edit'), '<span class="edit-link project-notes-entry-utility project-notes-edit">', '</span>' ); ?>

<?php else : ?>

<span class="edit-link project-notes-entry-utility project-notes-edit"><a href="<?php the_permalink();?>" target="_blank" title="<?php the_title_attribute(); ?>">View</a></span>

<?php endif; ?>
<?php endif; ?>

                                            <span class="project-notes-entry-utility project-day-date"><?php the_time('l') ?><br/><?php the_time('F jS, Y') ?></span>
                                             <span class="project-notes-entry-utility project-notes-show"><a href="#" title="Details">Details</a></span>
                                              

                <div class="project-notes-wrap">
                	
                <div class="project-details-wrap">
                <div class='project-notes-text-header'>Details</div>
                 <div class='project-notes-detail-text-wrap'>
				 <strong>Post Name:</strong> <a href='<?php the_permalink();?>' target="_blank" title='<?php the_title_attribute(); ?>'><?php the_title(); ?></a><br/>
				 <strong><?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?></strong><br/>
                 <strong>Design Name</strong>: <?php echo get_post_meta($post->ID, 'custom_name_of_design', true); ?><br/>
                 <strong>Timeline</strong>: <?php echo get_post_meta($post->ID, 'custom_project_start_end', true); ?><br/>
				 <strong>Client Email</strong>: <a href="mailto:<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>"><?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?></a><br/>
                 <strong>Designer</strong>: <?php echo get_post_meta($post->ID, 'custom_designers_name', true); ?>
                
                </div><div class="clear"></div>
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


		  
// Restore original Query & Post Data
wp_reset_query();
wp_reset_postdata();
?>

<?php
// this ends the if das user is logged in or not action

} else {

$user = wp_get_current_user();
$this_users_name = $user->nickname;
?>

<div class="das-project-admin-wrap">
<h2 class="project-board-header">Project Board</h2>


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

//Loop to custom taxonomy to build Client and Terms arrays.
foreach ($client as $term) :
	$args = array(
	  'post_type' => $post_type,
	  'post_per_page' => -1,
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
		$clients_name = get_post_meta($post->ID, 'custom_client_name', true);
		  $clients_names[] = $clients_name;
		  $term_names[$term->name] = $clients_name;
		  
		 			 
	endwhile; endif;   	
endforeach;
//END Build Arrays
 
//Clean up Clients Array So no duplicate client titles happen.
$final_clients_names = array_unique($clients_names);
			
//Start loop for displaying Client Name [Final Build loop]				
foreach ($final_clients_names as $key => $value) :

if ($value == $this_users_name) {
	
//Client Name	
echo "<h2>".$value."</h2>"; 

//Client Name value for check.
$client_value = $value;

$counter = 0;
	//loop for displaying Project Name
	foreach ($term_names as $key => $value) :
	  $term_value = $value;
	
	if($client_value == $value) {
		echo "<h3 class='pb-cat-header'>".$key." <span>".$post_counts[$counter]."</span></h3>";
	
		echo "<div class='das-project-list-wrap'>";
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
								
							 
							 
								$final_client_value = get_post_meta($post->ID, 'custom_client_name', true);
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
                                             </div>	
                                             
											<span class="project-notes-entry-utility project-notes-backg"></span>
                                              
                                           
                      
					 
                                            <?php global $user_ID; if( $user_ID ) : ?>
<?php if( current_user_can('level_10') ) : ?>

<?php edit_post_link( __( 'Edit'), '<span class="edit-link project-notes-entry-utility project-notes-edit">', '</span>' ); ?>

<?php else : ?>

<span class="edit-link project-notes-entry-utility project-notes-edit"><a href="<?php the_permalink();?>" target="_blank" title="<?php the_title_attribute(); ?>">View</a></span>

<?php endif; ?>
<?php endif; ?>

                                            <span class="project-notes-entry-utility project-day-date"><?php the_time('l') ?><br/><?php the_time('F jS, Y') ?></span>
                                             <span class="project-notes-entry-utility project-notes-show"><a href="#" title="Details">Details</a></span>
                                              

                <div class="project-notes-wrap">
                	
                <div class="project-details-wrap">
                <div class='project-notes-text-header'>Details</div>
                 <div class='project-notes-detail-text-wrap'>
				 <strong>Post Name:</strong> <a href='<?php the_permalink();?>' target="_blank" title='<?php the_title_attribute(); ?>'><?php the_title(); ?></a><br/>
				 <strong><?php echo get_post_meta($post->ID, 'custom_version_of_design', true); ?></strong><br/>
                 <strong>Design Name</strong>: <?php echo get_post_meta($post->ID, 'custom_name_of_design', true); ?><br/>
                 <strong>Timeline</strong>: <?php echo get_post_meta($post->ID, 'custom_project_start_end', true); ?><br/>
				 <strong>Client Email</strong>: <a href="mailto:<?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?>"><?php echo get_post_meta($post->ID, 'custom_clients_email', true); ?></a><br/>
                 <strong>Designer</strong>: <?php echo get_post_meta($post->ID, 'custom_designers_name', true); ?>
                
                </div><div class="clear"></div>
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

 }
?>

<br class="clear"/>
  <a class="das-settings-admin-slick-logo" href="http://www.slickremix.com" target="_blank"></a> 
</div><!--/das-help-admin-wrap-->

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
}
?>