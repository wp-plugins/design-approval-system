<?php
function das_video_page() {
?>
<div class="das-video-admin-wrap">
 <a class="buy-extensions-btn" href="http://www.slickremix.com/downloads/category/design-approval-system/" target="_blank"><?php _e('Get Extensions Here!', 'design-approval-system') ?></a>
<h2><?php _e('DAS Instructional Videos', 'design-approval-system') ?></h2>
<div class="use-of-plugin"><?php _e("Watch the videos below to learn more about the Design Approval System and what it can do for you.<br/>
We have short &amp; full length tutorials, plus instructions  on a few of our Premium Extensions.<br/>If you have questions or need help don't forget to check out our <a href='http://www.slickremix.com/support-forum/' target='_blank'>Support Forum<', 'design-approval-system')</a>") ?></div>

<div class="iframe-wrap">
  <h3><?php _e('Why should I use the Design Approval System?', 'design-approval-system') ?></h3>
  <iframe width="600" height="450" src="http://www.youtube.com/embed/0pdDca0onbY" frameborder="0" allowfullscreen></iframe>
</div> 
<div class="iframe-wrap">
  <h3><a href="http://www.slickremix.com/downloads/design-login-das-extension/" target="_blank"><?php _e('Design Login, Premium Extension', 'design-approval-system') ?></a></h3>
  <iframe width="600" height="450" src="http://www.youtube.com/embed/qCU1fjP6Z78" frameborder="0" allowfullscreen></iframe>
</div>
<div class="iframe-wrap">
  <h3><a href="http://www.slickremix.com/downloads/select-user-and-email-das-extension/" target="_blank"><?php _e('Select User and Email, Premium Extension', 'design-approval-system') ?></a></h3>
  <iframe width="600" height="450" src="http://www.youtube.com/embed/rhwNXR_qbPM" frameborder="0" allowfullscreen></iframe>
</div>
<div class="iframe-wrap iframe-odd">
  <h3>Design Approval System & <a href="http://www.slickremix.com/downloads/client-changes-das-extension/" target="_blank"><?php _e('Client Changes, Premium Extension</a> - Full Tutorial', 'design-approval-system') ?></h3>
  <iframe width="600" height="450" src="http://www.youtube.com/embed/pYdF2OJCOv4" frameborder="0" allowfullscreen></iframe>
</div>
<div class="iframe-wrap iframe-odd"> 
  <h3><?php _e('A Quick look at the Design Approval System, Wordpress Plugin', 'design-approval-system') ?></h3>
  <iframe width="600" height="450" src="http://www.youtube.com/embed/1CtzTrPuc1A" frameborder="0" allowfullscreen></iframe>
</div>
  <br class="clear"/> 
</div><!--/das-help-admin-wrap-->
<?php
	include('walkthrough/walkthrough.php');	
}
?>