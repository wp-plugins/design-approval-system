 <ul class="das-comment-list" id="das-comments-list">
	<?php 
    $id = get_the_ID();
    $comments = get_comments('post_id='.$id);
   
    if ( $comments && comments_open()  && is_user_logged_in() == true) {
		?><?php 
        foreach($comments as $comment) :
            ?><li><strong><?php echo $comment->comment_author;?>: <?php echo get_comment_date('n-j-Y', $comment); ?> . </strong><span class="das-even-color"><?php echo $comment->comment_content?></span></li><?php
        endforeach;
		?><?php
	}
	elseif(!comments_open() && is_user_logged_in() == true) {
			echo '<li class="das-make-changes-note">';
			_e("Comments are closed for this project.", "design-approval-system");
			echo '</li>';
	}
	elseif(is_user_logged_in() !== true) {
			echo '<li class="das-make-changes-note">';
		  
		 _e("You must be", "design-approval-system");
		 echo ' <a href="';
		 echo   wp_login_url(get_permalink());
		 echo '">';
		 _e("logged in", "design-approval-system");
		 echo '</a> ';
		  _e("to make comments.", "design-approval-system"); 
		 echo '</li>';	
	}
	else { echo '<li class="das-make-changes-note">';
		 _e("Use the 'Comment' button above to get started.", "design-approval-system");
		 echo '</li>';	
	}
 ?></ul>