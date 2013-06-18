jQuery(document).ready(function() {
    jQuery(".submit-signature").click(function() {
		
	var validation = jQuery("#sendDigitalSignature #custom_client_approved_signature").val(); 
	
	if(validation == "")
	{
	  alert("Please enter your name.");
	  jQuery("input[name=custom_client_approved_signature]").addClass('hightlight1');
	  return false;
	}   
		
	 	jQuery("input[name=custom_client_approved_signature]").removeClass('hightlight1');
        console.log('Submit Function');
        var postMeta = jQuery('input[name="custom_client_approved_signature"]').val();
		console.log(postMeta);
		var postID = jQuery('.submit-signature').prop("rel");
		console.log(postID);
        var button = jQuery('.submit-signature').html('saving...');
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
				jQuery('#sendDigitalSignature').ajaxSubmit({ target: '#output'}); return false;
			}
        }); // end of ajax()
        return false;
    }); // end of document.ready
}); // end of form.submit




jQuery(document).ready(function() {
    jQuery("#submit-design-request").click(function() {
	// custom_client_changes is the id for the design request textarea	
	var validation = tinymce.activeEditor.getContent(); 
	
	if(validation == "")
	{
	  alert("Please add some text before submitting the form.");
	  return false;
	}
        console.log('Submit Function');
		// custom_client_changes is the id for the design request textarea	
        var postMeta = tinymce.activeEditor.getContent();
		console.log(postMeta);
		var postID = jQuery('.submit-requests').prop("rel");
		console.log(postID);
        var button = jQuery('.submit-requests').html('saving...');
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
				jQuery('#sendDesignRequests').ajaxSubmit({ target: '#output'}); return false;
				
			}
        }); // end of ajax()
        return false;
    }); // end of document.ready
}); // end of form.submit