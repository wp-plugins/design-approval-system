jQuery(document).ready(function() {
	
 jQuery(".das-submit-signature").click(function() {
		
	var validation = jQuery("#sendDigitalSignature #custom_client_approved_signature").val(); 
	
	if(validation == "" || validation == " ")
	{
	  alert("Please enter your name.");
	  jQuery("input[name=custom_client_approved_signature]").addClass('hightlight1');
	  return false;
	}
	
				var check = jQuery("input#das-gq-theme-agree-to-terms").is(":checked");
				var checkVisible = jQuery("input#das-gq-theme-agree-to-terms").is(":hidden");
				if(!check && !checkVisible)
				{
						alert("You must read and agree with the Terms & Conditions.");
						return false;	
				}
	
	 	jQuery("input[name=custom_client_approved_signature]").removeClass('hightlight1');
        console.log('Submit Function');
        var postMeta = jQuery('input[name="custom_client_approved_signature"]').val();
		console.log(postMeta);
		var postID = jQuery('.das-submit-signature').prop("rel");
		console.log(postID);
        var button = jQuery('.das-submit-signature').html('saving...');
		console.log(button);
		
        jQuery.ajax({
            data: {action: "my_user_dasChecker", post_id: postID, post_meta: postMeta  },
            type: 'POST',
            url: myAjax.ajaxurl,
            success: function( response ) { 
				jQuery('.approved-wrap').fadeIn();
				jQuery('.not-approved-wrap').hide();
				console.log('Well Done and got this from sever: ' + response);
				console.log('Form process sending');
				jQuery('#sendDigitalSignature').ajaxSubmit({ target: '#output'}); 
				return false;
				
			}
        }); // end of ajax()
        return false;
    }); // end of document.ready
}); // end of form.submit




jQuery(document).ready(function() {
    jQuery("#das-submit-design-request").click(function() {
	// custom_client_changes is the id for the design request textarea	
	// var validation = tinymce.activeEditor.getContent(); 
	var validation = jQuery('#custom_client_changes').val();
	if(validation == "" || validation == " ")
	{
	  alert("Please add some text before submitting the form.");
	  return false;
	}
        console.log('Submit Function');
							// custom_client_changes is the id for the design request textarea, not going to use tinymce anymore	
       // var postMeta = tinymce.activeEditor.getContent();
							var postMeta = jQuery('#custom_client_changes').val();
		console.log(postMeta);
		var postID = jQuery('.das-submit-requests').prop("rel");
		console.log(postID);
        var button = jQuery('.das-submit-requests').html('saving...');
		console.log(button);
		
        jQuery.ajax({
            data: {action: "my_client_changes_dasChecker", post_id: postID, post_meta: postMeta  },
            type: 'POST',
            url: myAjax.ajaxurl,
            success: function( result ) { 
				jQuery('.client-notes-textarea').html(result);
				console.log('Client notes posted: ' + result);
				jQuery('.custom_client_changes').html(result);
				console.log('Client notes echoed to textarea for email form process double check: ' + result);
				console.log('Form process sending');
				jQuery('#sendDesignRequests').ajaxSubmit({ target: '#output'}); 
       			var button2 = jQuery('.das-submit-requests').html('Submit');
				console.log(button2);
			}
        }); // end of ajax()
        return false;
    }); // end of click function
	
	
	
	
	 jQuery("#das-submit-design-request-not-logged-in").click(function() {
	 
	// custom_client_changes is the id for the design request textarea	
	 var validation = jQuery('#custom_client_changes').val();
	// var validation = tinymce.activeEditor.getContent();
	if(validation == "" || validation == " ")
	{
	  alert("Please add some text before submitting the form.");
	  return false;
	}
	else {
        console.log('Submit Function');
		 var postMeta = jQuery('#custom_client_changes').val();
		console.log(postMeta);
		var postID = jQuery('.das-submit-requests').prop("rel");
		console.log(postID);
        var button = jQuery('.das-submit-requests').html('saving...');
		console.log(button);
		//jQuery( "#sendDesignRequests" ).submit();
		 jQuery.ajax({
            data: {action: "my_client_changes_dasChecker", post_id: postID, post_meta: postMeta  },
            type: 'POST',
            url: myAjax.ajaxurl,
            success: function( result ) {
			//	console.log('Client notes posted: ' + result);
			//	jQuery('.custom_client_changes').html(result);
				console.log('Client notes echoed to textarea for email form process double check: ' + result);
				console.log('Form process sending');
				jQuery('#sendDesignRequests').ajaxSubmit({ target: '#output'});
       			// var button2 = jQuery('.das-submit-requests').html('Submit Comments');
				console.log(button2);
				
			}
        }); // end of ajax()
        return false;
	}
        return false;
    }); // end of click function
	
	
}); // end of document ready