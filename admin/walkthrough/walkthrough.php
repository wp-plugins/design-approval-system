<?php 
$_GET["step"] = filter_var($_GET["step"], FILTER_SANITIZE_STRING);
$step = $_GET["step"];

if ($_GET['post_type'] == 'designapprovalsystem') {
  add_action('admin_enqueue_scripts', 'das_walkthrough_cookie_scripts');
  function das_walkthrough_cookie_scripts() {
  }
}
?>
<script>
	jQuery(function() {
				var config = [
					{
						"name" 		: "tour_1",
						"text"		: "<p>This page shows all of your clients and projects. You can view the details of each design, and if a design is approved a STAR will appear next to that project and design version.</p> <p>By following the Next 3 steps in our walk-through your project board will come alive!</p><p>Step 1: Make sure you have filled out the details in the Settings page</p>",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_2",
						"text"		: "<p>Step 2: Create a Project Name.<br/>Make your name relative to your client and your project. Like this example,</p><p><i>Bomber Eyewear – Home Trial</i>.</p><p>This will make it easy to see very quickly, what project was for who.",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_3",
						"text"		: "<p>Step 3: Add a New Design.<br/>Fill out the title with the name of your client and project. This is how we do it:</p><p><i>Bomber Eyewear, Home Trial V1</i></p><p>Then add your photo, video, music, or whatever you need approved into the large textbox on the page.</p> <p>Fill out the Design Approval Fields, making sure to enter your clients name and email.</p><p>Finally, make sure and check your Project Name for this Design version in the right sidebar and add a Featured Image. This is very important as it's what helps organize the Project Board.<p>That's all, now your project board should have one project and a design version.</p>",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_4",
						"text"		: "<p>This page displays a list of all your designs with a date title and author (designer name).</p> <p>You can also edit, add new or delete designs here too.</p>",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_5",
						"text"		: "<p>This page displays a list of all your clients that you will have signed up on the <a href='user-new.php'>add new users</a> page.</p> <p>When you sign up a DAS Client and they login, they will only be able to see the Project Board and there projects. They will not be able to edit designs or add new ones. By logging in your client will also be able to Approve Designs, or *makes Changes. (* if you have the premium extension).</p><p>IMPORTANT: Make sure your designs have the client's email you signed them up with so only your client can see his/her projects when they login.</p>",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_6",
						"text"		: "<p>This page displays a list of all your designers that you will have signed up on the <a href='user-new.php'>add new users</a> page.</p><p>When you sign up a DAS Designer and they login they will be able to see all of wordpress, but they can't edit your main wordpress settings.</p>",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_7",
						"text"		: "<p>Here you can stay up to date with all of our latest news and events happening with the Design Approval System. You can follow our <a href='https://www.facebook.com/groups/163760557102843/' target='_blank'>Group here</a> and Like our Facebook <a href='https://www.facebook.com/DesignApprovalSystem' target='_blank'>Page here</a>.</p>",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_8",
						"text"		: "<p>Take a Walk-Through of the DAS menu items, and the 3 easy steps to get your project board up a running.</p>",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_9",
						"text"		: "<p>Look at tutorial videos we produced for the Design Approval System and the premium extensions we have available.</p> <p>IMPORTANT: Be sure to look at the Walk-Through as we have recently updated the names of some menu items.</p>",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_10",
						"text"		: "<p>You can find some good FAQS here, along with system settings about your worpress and the Design Approval System Version.</p><p>IMPORTANT: If you need help and want to submit an email or post on our support forum, please make sure and copy the System Info information on this page.",
						"time" 		: 5000
					},
					{
						"name" 		: "tour_11",
						"text"		: "<p>This is what makes the Design Approval System work. Add your company logo and fill out all the details to get up and running. Many cool options here.</p>",
						"time" 		: 5000
					}

				],
				//define if steps should change automatically
				autoplay	= false,
				//timeout for the step
				showtime,
				//current step of the tour
				step		= 0,
				
				page_step = <?php if($step ==''){print'0';} else{ print $step;}?>;
				//total number of steps
				total_steps	= config.length;
				
				
				
			
				//Cookie START	
				if (jQuery.cookie('notice') == 'closed' && page_step ==''){
				  hideControls();
				} else {
				  showControls();
				  
				  if (page_step =='1'){
				 	startTour()
				  }
				}
				  // Show or hide on load depending on cookie 
						  
				jQuery('#tourcontrols .close, #endtour').click(function(e) {
				  e.preventDefault();
				  jQuery.cookie('notice','closed');
				   hideControls();
				});
				
				
				
				jQuery('#activatetour').live('click',startTour);
				jQuery('#canceltour').live('click',endTour);
				jQuery('#endtour').live('click',endTour);
				jQuery('#restarttour').live('click',restartTour);
				jQuery('#nextstep').live('click',nextStep);
				jQuery('#prevstep').live('click',prevStep);
				
				function startTour(){
					jQuery('#activatetour').remove();
					jQuery('#endtour,#restarttour').show();
					if(!autoplay && total_steps > 1)
						jQuery('#nextstep').show();
					showOverlay();
					nextStep();
				}
				
				function nextStep(){
					if(!autoplay){
						if(step > 0)
							jQuery('#prevstep').show();
						else
							jQuery('#prevstep').hide();
						if(step == total_steps-1)
							jQuery('#nextstep').hide();
						else
							jQuery('#nextstep').show();	
					}	
					if(step >= total_steps){
						//if last step then end tour
						endTour();
						return false;
					}
					++step;
					showTooltip();
				}
				
				function prevStep(){
					if(!autoplay){
						if(step > 2)
							jQuery('#prevstep').show();
						else
							jQuery('#prevstep').hide();
						if(step == total_steps)
							jQuery('#nextstep').show();
					}		
					if(step <= 1)
						return false;
					--step;
					showTooltip();
				}
				
				function endTour(){
					step = 0;
					if(autoplay) clearTimeout(showtime);
					removeTooltip();
					hideControls();
					hideOverlay();
				}
				
				function restartTour(){
					step = 0;
					if(autoplay) clearTimeout(showtime);
					nextStep();
				}
				
				function showTooltip(){
					//remove current tooltip
					removeTooltip();
					
					var step_config		= config[step-1];
					var $elem			= jQuery('.' + step_config.name);
					
					if(autoplay)
						showtime	= setTimeout(nextStep,step_config.time);
					
					var bgcolor 		= step_config.bgcolor;
					var color	 		= step_config.color;
					
					var $tooltip		= jQuery('<div>',{
						id			: 'tour_tooltip',
						className 	: 'tooltip tooltip-'+step_config.name,
						html		: ''+step_config.text+'<span class="tooltip_arrow"></span>'
					}).css({
						'display'			: 'none',
						'background-color'	: bgcolor,
						'color'				: color
					});
					
					//position the tooltip correctly:
					
					//the css properties the tooltip should have
					var properties		= {};
					
					if(step_config.name == 'tour_1') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(2)').prepend($tooltip);
					};
					if(step_config.name == 'tour_2') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(3)').prepend($tooltip);
					};
					if(step_config.name == 'tour_3') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(4)').prepend($tooltip);
					};
					if(step_config.name == 'tour_4') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(5)').prepend($tooltip);
					};
					if(step_config.name == 'tour_5') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(6)').prepend($tooltip);
					};
					if(step_config.name == 'tour_6') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(7)').prepend($tooltip);
					};
					if(step_config.name == 'tour_7') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(8)').prepend($tooltip);
					};
					if(step_config.name == 'tour_8') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(9)').prepend($tooltip);
					};
					if(step_config.name == 'tour_9') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(10)').prepend($tooltip);
					};
					if(step_config.name == 'tour_10') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(11)').prepend($tooltip);
					};
					if(step_config.name == 'tour_11') {
						//append the tooltip but hide it
						jQuery('#menu-posts-designapprovalsystem ul li:nth-child(12)').prepend($tooltip);
					};
					
					
					    //show the new tooltip
						$tooltip.css(properties).fadeIn('fast');
				}
				
				function removeTooltip(){
					jQuery('#tour_tooltip').fadeOut('fast').remove();
				}
				
				function showControls(){
					/*
					we can restart or stop the tour,
					and also navigate through the steps
					 */
					var $tourcontrols  = '<div id="tourcontrols" class="tourcontrols">';
					$tourcontrols += '<p>DAS Walk-Through</p>';
					$tourcontrols += '<span class="button" id="activatetour">Start the tour</span>';
						if(!autoplay){
							$tourcontrols += '<div class="nav"><span class="button" id="prevstep" style="display:none;">< Previous</span>';
							$tourcontrols += '<span class="button" id="nextstep" style="display:none;">Next ></span></div>';
						}
						$tourcontrols += '<a id="restarttour" style="display:none;">Restart the tour</span>';
						$tourcontrols += '<a id="endtour" style="display:none;">End the tour</a>';
						$tourcontrols += '<span class="close" id="canceltour"></span>';
					$tourcontrols += '</div>';
					
					jQuery('BODY').prepend($tourcontrols);
					jQuery('#tourcontrols').animate({'right':'30px'},1500);
				}

				// Don't need this... Saving for later user. SRL jQuery('#menu-posts-designapprovalsystem ul li:nth-child(11) a').live('click',showControls);
				
				function hideControls(){
					jQuery('#tourcontrols').fadeOut('fast');
				}
				
				function showOverlay(){
					var $overlay	= '<div id="tour_overlay" class="overlay"></div>';
					jQuery('BODY').prepend($overlay);
				}
				
				function hideOverlay(){
					jQuery('#tour_overlay').fadeOut('fast');
				}	
});
</script>