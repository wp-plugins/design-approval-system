<?php function das_news_updates_page() { ?>
<div class="das-video-admin-wrap das-news-admin-wrap">
 <a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/design-approval-system/" target="_blank"><?php _e('Get Extensions Here!', 'design-approval-system') ?></a>
 <h2><?php _e('DAS News and Updates', 'design-approval-system') ?></h2>
<div class="use-of-plugin"><?php _e('Read articles below to find out about our most recent <strong>News</strong> and <strong>Updates</strong>.<br/>You can also join our <a href="https://www.facebook.com/groups/163760557102843/" target="_blank">Facebook Group</a> to receive updates in your news feed too.<br/> What better way to read about new updates, premium extensions or specials we have<br/>running. <strong>Thanks for the Support!</strong>', 'design-approval-system') ?></div>

<?php
//Number of Posts to show [max is 24] I believe Facebook is only allowing me to recieve that many
$post_limit = '15';

//Group ID 150550615035310
$group_id = '163760557102843';

//Access Token
$access_token = '226916994002335|ks3AFvyAOckiTA1u_aDoI4HYuuw';

//URL to get page info
$url1 = 'https://graph.facebook.com/'.$group_id.'?access_token='.$access_token.'';
$des = json_decode(file_get_contents($url1));

//URL to get Feeds
$url2 = 'https://graph.facebook.com/'.$group_id.'/feed?access_token='.$access_token.'';
$data = json_decode(file_get_contents($url2));

print '<div class="jal-fb-group-display">';
  print '<div class="jal-fb-header">';
  print '</div><!--/jal-fb-header-->';
 	
//Setup Count Posts
$count_posts = 0;
foreach($data->data as $d) {
if($count_posts==$post_limit)
break;

  print '<div class="jal-single-fb-post">';
      
      print '<div class="jal-fb-right-wrap">';
      	print '<div class="jal-fb-top-wrap">';
          print '<span class="jal-fb-post-time">on '.date('F j, Y H:i',strtotime($d->created_time)).'</span><div class="clear"></div>';
        print '</div><!--/jal-fb-top-wrap-->';

//Create Facebook Variables 
$FBtype = $d->type;
$FBmessage = $d->message;	
$FBpicture = $d->picture;
$FBlink = $d->link;
$FBname = $d->name;
$FBcaption = $d->caption;
$FBdescription = $d->description;
$FBicon = $d->icon;
$FBby = $d->properties->text;
$FBbylink = $d->properties->href;
$FBpost_id = $d->id;
    
	//Output Message  
	if ( $FBmessage == '' ) {
	}
	else {
		print '<div class="jal-fb-message">'.$FBmessage.'</div><div class="clear"></div> ';
	}
    
	//Output Link    
	if ( $FBtype == '' ) {
		
	}
	
	elseif ( $FBtype == 'status' ) {
		
		if (empty($FBpicture) || empty($FBname) || empty($FBdescription) || empty($FBcaption)) {
		}
		else	{
		
		print '<div class="jal-fb-link-wrap">';
		  //Output Link Pricture
		  if ( $FBpicture == '' ) {
		  }
		  else {
			  print '<a href="'.$FBlink.'" target="_blank" class="jal-fb-picture"><img border="0" alt="' .$d->from->name.'" src="'.$d->picture.'"/></a>';
		  };
		
		  
			print '<div class="jal-fb-description-wrap">';
			  //Output Link Name
			  if ( $FBname  == '' ) {
			  }
			  else {
				  print '<a href="'.$FBlink.'" target="_blank" class="jal-fb-name">'.$FBname.'</a>';
			  };
			  //Output Link Caption
			  if ( $FBcaption  == __('Attachment Unavailable This attachment may have been removed or the person who shared it may not have permission to share it with you.', 'design-approval-system') ) {
					print '<div class="jal-fb-caption" style="width:100% !important">';
					_e('This user\'s persmissions are keeping you from seeing this post. Please Click "See More" to view this post on this group\'s facebook wall.', 'design-approval-system');
					print '</div>';
			  }
			  else {
				  print '<div class="jal-fb-caption">'.$FBcaption.'</div>';
			  };
			  //Output Link Description
			  if ( $FBdescription  == '' ) {
			  }
			  else {
				  print '<div class="jal-fb-description">'.$FBdescription.'</div>';
			  };
			print '<div class="clear"></div></div><!--/jal-fb-description-wrap-->';
			
			print '<div class="clear"></div></div><!--/jal-fb-link-wrap-->';
		}
	} 
	
	elseif ( $FBtype == 'link' ) {
		
		if (empty($FBpicture) || empty($FBname) || empty($FBdescription) || empty($FBcaption)) {
		}
		else	{
				print '<div class="jal-fb-link-wrap">';
				  //Output Link Pricture
				  if ( $FBpicture == '' ) {
				  }
				  else {
					  print '<a href="'.$FBlink.'" target="_blank" class="jal-fb-picture"><img border="0" alt="' .$d->from->name.'" src="'.$d->picture.'"/></a>';
				  };
				  
				print '<div class="jal-fb-description-wrap">';
				  //Output Link Name
				  if ( $FBname  == '' ) {
				  }
				  else {
					  print '<a href="'.$FBlink.'" target="_blank" class="jal-fb-name">'.$FBname.'</a>';
				  };
				  //Output Link Caption
				  if ( $FBcaption  == '' ) {
				  }
				  else {
					  print '<div class="jal-fb-caption">'.$FBcaption.'</div>';
				  };
				  //Output Link Description
				  if ( $FBdescription  == '' ) {
				  }
				  else {
					  print '<div class="jal-fb-description">'.$FBdescription.'</div>';
				  };
				print '<div class="clear"></div></div><!--/jal-fb-description-wrap-->';
				
				print '<div class="clear"></div></div><!--/jal-fb-link-wrap-->';
		}
	} 
	
	//Output Video
	elseif ( $FBtype == 'video' ) {
		
		print '<div class="jal-fb-vid-wrap">';
		
		  if ( $FBpicture == '' ) {
		  }
		  else{	
		
		print '<a href="javascript:;" target="_blank" class="jal-fb-vid-picture fb-id'.$FBpost_id.' vid-btn'.$FBpost_id.'"><img border="0" alt="' .$d->from->name.'" src="'.$d->picture.'"/> <div class="jal-fb-vid-play-btn"></div> </a>';
		 
		print '<div id="video'.$FBpost_id.'" class="vid-div"></div>';
		 
		 	//strip Youtube URL then ouput Iframe and script
		 	if (strpos($FBlink, 'youtube') > 0) {
				 $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
        		 preg_match($pattern, $FBlink, $matches);
       		 	 $youtubeURLfinal = $matches[1];
		 
		 		print '<script>';
				print 'jQuery(document).ready(function() {';
				print 'jQuery(".vid-btn'.$FBpost_id.'").click(function() {';
					print 'jQuery(".fb-id'.$FBpost_id.'").hide();';
					print 'jQuery("#video'.$FBpost_id.'").show();';
					print 'jQuery("#video'.$FBpost_id.'").prepend(\'<iframe width="488" height="281" class="video'.$FBpost_id.'" style="display:none;" src="http://www.youtube.com/embed/'.$youtubeURLfinal.'?autoplay=1" frameborder="0" allowfullscreen></iframe>\');';
					print 'jQuery(".video'.$FBpost_id.'").show();';
				print '});';		
				print '});';	
				print '</script>';	
			}
			//strip Youtube URL then ouput Iframe and script
			else if (strpos($FBlink, 'youtu.be') > 0) {
				$pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
        		 preg_match($pattern, $FBlink, $matches);
       		 	 $youtubeURLfinal = $matches[1];
				
		 		print '<script>';
				print 'jQuery(document).ready(function() {';
				print 'jQuery(".vid-btn'.$FBpost_id.'").click(function() {';
					print 'jQuery(".fb-id'.$FBpost_id.'").hide();';
					print 'jQuery("#video'.$FBpost_id.'").show();';
					print 'jQuery("#video'.$FBpost_id.'").prepend(\'<iframe width="488" height="281" class="video'.$FBpost_id.'" style="display:none;" src="http://www.youtube.com/embed/'.$youtubeURLfinal.'?autoplay=1" frameborder="0" allowfullscreen></iframe>\');';
					print 'jQuery(".video'.$FBpost_id.'").show();';
				print '});';		
				print '});';	
				print '</script>';
			}
			
			//strip Vimeo URL then ouput Iframe and script
			
			else if (strpos($FBlink, 'vimeo') > 0) {
				
				$pattern = '/(\d+)/';
        		 preg_match($pattern, $FBlink, $matches);
       		 	 $vimeoURLfinal = $matches[0];
				
				print '<script>';
				print 'jQuery(document).ready(function() {';
				print 'jQuery(".vid-btn'.$FBpost_id.'").click(function() {';
					print 'jQuery(".fb-id'.$FBpost_id.'").hide();';
					print 'jQuery("#video'.$FBpost_id.'").show();';
					print 'jQuery("#video'.$FBpost_id.'").prepend(\'<iframe src="http://player.vimeo.com/video/'.$vimeoURLfinal.'?autoplay=1" class="video'.$FBpost_id.'" style="display:none;" width="488" height="390" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>\');';
					print 'jQuery(".video'.$FBpost_id.'").show();';
				print '});';		
				print '});';	
				print '</script>';
			} 
		}
						 
		print '<div class="jal-fb-description-wrap fb-id'.$FBpost_id.'">';
		
		  //Output Video Name
		  if ( $FBname  == '' ) {
		  }
		  else {
			  print '<a href="'.$FBlink.'" target="_blank" class="jal-fb-name fb-id'.$FBpost_id.'">'.$FBname.'</a>';
		  };
		  //Output Video Caption
		  if ( $FBcaption  == '' ) {
		  }
		  else {
			  print '<div class="jal-fb-caption fb-id'.$FBpost_id.'">'.$FBcaption.'</div>';
		  };
		  //Output Video Description
		  if ( $FBdescription  == '' ) {
		  }
		  else {
			  print '<div class="jal-fb-description fb-id'.$FBpost_id.'">'.$FBdescription.'</div>';
		  };
	  	print '<div class="clear"></div></div><!--/jal-fb-description-wrap-->';
		
	 	print '<div class="clear"></div></div><!--/jal-fb-vid-wrap-->';	
	}
	
	//Output Photo
	elseif ( $FBtype == 'photo' ) {
		
		print '<div class="jal-fb-link-wrap">';
		  
		  //Output Photo Picture
		  if ( $FBpicture == '' ) {
		  }
		  else {
			  print '<a href="'.$FBlink.'" target="_blank" class="jal-fb-picture"><img border="0" alt="' .$d->from->name.'" src="'.$d->picture.'"/></a>';
		  };
		  
		print '<div class="jal-fb-description-wrap">';
		  //Output Photo Name
		  if ( $FBname  == '' ) {
		  }
		  else {
			  print '<a href="'.$FBlink.'" target="_blank" class="jal-fb-name">'.$FBname.'</a>';
		  };
		  //Output Photo Caption
		  if ( $FBcaption  == '' ) {
		  }
		  else {
			  print '<div class="jal-fb-caption">'.$FBcaption.'</div>';
		  };
		  //Output Photo Description
		  if ( $FBdescription  == '' ) {
		  }
		  else {
			  print '<div class="jal-fb-description">'.$FBdescription.'</div>';
			  print '<div>By: <a href="'.$FBbylink.'">'.$FBby.'<a/></div>';
		  };
		print '</div><!--/jal-fb-description-wrap-->';
		
		print '<div class="clear"></div></div><!--/jal-fb-link-wrap-->';
	} 

  print '<div class="clear"></div>';
	print '</div><!--/jal-fb-right-wrap-->';
	
//	print '<a href="http://www.facebook.com/home.php?sk=group_'.$group_id.'&ap=1" target="_blank" class="jal-fb-see-more">See More</a>';
print '<div class="clear"></div>';
print '</div><!--/jal-single-fb-post-->';

     //Count the post 
	 $count_posts++;
	 }	
  print '</div><!--/jal-fb-group-display-->';
  print '<div class="clear"></div>'; 
  print '</div><!--/das-help-admin-wrap-->';

  include('walkthrough/walkthrough.php');	
}
?>