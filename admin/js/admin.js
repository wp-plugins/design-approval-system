 jQuery(function() {
	 
	 
	 // This is to open the media manager for our add logo option
	jQuery('#das_logo_image_button').click(function(){ 
		wp.media.editor.send.attachment = function(props, attachment){ 
			jQuery('#das_default_theme_logo_image').val(attachment.url);
		}
			wp.media.editor.open(this);
			return false;
		});
		
			
		// this hides any option fields if a custom theme is not installed in our tabbed area
	    jQuery("#custom_das-template-options option[value='']").remove();
		
		
		// check to see if the id exists then load the tabs. we only want this script loading on the post edit page.
		if(jQuery("#das-tabs").length == 0) {
		  // Variable is not defined 
				// alert('for testing only');
		} else {
   	 
		 jQuery("#das-tabs").tabs({
				create: function(event, ui){
					
						// we will visist the tabs save session at a later time.
						// var tab_selected = sessionStorage.getItem('tab_selected');
						// if (tab_selected) {
						//	history.pushState(null, null,tab_selected);
						//	jQuery(ui.newTab[0]).find('a[href^="#das-tab"]').attr("href");
						// }
						
						jQuery(this).tabs({'select': jQuery(this).find("ul").index(jQuery(this).find('a[href="' + window.location.hash + '"]').parent())});
					
				},
				activate: function(event, ui){
					var tab_select = jQuery(ui.newTab[0]).find('a[href^="#das-tab"]').attr("href");
						history.pushState(null, null,tab_select);
						//sessionStorage.setItem('tab_selected', tab_select)
				}
			});
	};
		
});
	  
/*"How to" Scripts*/
jQuery(".question1").click(function() {
	jQuery(".answer1").slideDown('slow');
});			
jQuery(".question2").click(function() {
	jQuery(".answer2").slideDown('slow');
});	
jQuery(".question3").click(function() {
	jQuery(".answer3").slideDown('slow');
});	
jQuery(".question4").click(function() {
	jQuery(".answer4").slideDown('slow');
});	
jQuery(".question5").click(function() {
	jQuery(".answer5").slideDown('slow');
});	
jQuery(".question6").click(function() {
	jQuery(".answer6").slideDown('slow');
});	
jQuery(".question7").click(function() {
	jQuery(".answer7").slideDown('slow');
});	
jQuery(".question8").click(function() {
	jQuery(".answer8").slideDown('slow');
});	
jQuery(".question9").click(function() {
	jQuery(".answer9").slideDown('slow');
});	
jQuery(".question10").click(function() {
	jQuery(".answer10").slideDown('slow');
});	
jQuery(".question11").click(function() {
	jQuery(".answer11").slideDown('slow');
});	
jQuery(".question12").click(function() {
	jQuery(".answer12").slideDown('slow');
});
/*im done button*/
jQuery(".im-done").click(function() {
	jQuery(".answer1, .answer2, .answer3, .answer4, .answer5, .answer6, .answer7, .answer8 ,.answer9 ,.answer10 ,.answer11, .answer12").slideUp('fast');
});