<?php 
////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////
//////////////////// Admin Project Board Page ////////////////////////////
/////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
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
if (current_user_can_for_blog($user_blog_id, 'administrator') || current_user_can_for_blog($user_blog_id, 'das_designer')) { ?>
<div class="das-project-admin-wrap-main">

<a class="buy-extensions-btn" href="http://www.slickremix.com/product-category/design-approval-system-extensions/" target="_blank"><?php _e('Get Extensions Here!', 'design-approval-system') ?></a>
<h2 class="project-board-header"><?php _e('Project Board', 'design-approval-system') ?></h2>
<div class="use-of-plugin"><?php _e('Below are your Clients and their Projects: We suggest you use the', 'design-approval-system') ?> <a href="http://www.slickremix.com/downloads/select-user-and-email-das-extension/" target="_blank"><?php _e('Select User and Email, DAS Extension', 'design-approval-system') ?></a> <?php _e('to make this list work seamlessly. Learn how to use and setup the', 'design-approval-system') ?> <a href="http://www.slickremix.com/2013/01/22/das-project-board-tutorial/" target="_blank"><?php _e('Project Board Here', 'design-approval-system') ?></a>. </div>

<?php 
		// echo our short code for the Public Board
	  echo do_shortcode('[DASPublicBoard]');
// this ends the if admin or das user is logged in or not action
?>
</div> <?php // <!--das-project-admin-wrap-main--> ?>

<?php } 

 else {

?>
<div class="das-project-admin-wrap-main">
  <h2 class="project-board-header"><?php _e('Project Board', 'design-approval-system') ?></h2>
 	

<?php // echo our short code for the Public Board
	  echo do_shortcode('[DASPrivateBoard]'); ?>

  <br class="clear"/>
</div> <?php // <!--das-project-admin-wrap-main--> ?>


<?php
		
	} // end if admin or das user can
} // das_projects_page
?>