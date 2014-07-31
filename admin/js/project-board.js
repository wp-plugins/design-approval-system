jQuery(document).ready(function() {
	jQuery("li").hover(function(){
			jQuery(this).find('.project-notes-entry-utility').show();
		},
	function(){
		jQuery(this).find('.project-notes-entry-utility').fadeOut('fast');
	 }); 
	jQuery('.project-notes-show').click(function() {
		jQuery(this).closest('div').next('.project-notes-wrap').toggle();
	return false;
	});
	jQuery('.pb-cat-header').click(function() {
		jQuery(this).next('.das-project-list-wrap').slideToggle('fast');
	return false;
	});
});	 