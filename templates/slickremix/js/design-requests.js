jQuery(document).ready(function() {	
//Pop-ups
	jQuery('.design-approval-btn').click(function () {	
		jQuery('.pop-up-backg, .approved-form-wrap').fadeIn();
	});
	
	jQuery('#paid').click(function () {	
		jQuery('.pop-up-backg, .design-request-form-wrap').fadeIn();
	});
	
	jQuery('#not-paid').click(function () {	
		jQuery('.pop-up-backg, .additional-design-request-form-wrap').fadeIn();
	});
	jQuery('.close, #cancel').click(function () {	
		jQuery('.pop-up-backg, .approved-form-wrap, .design-request-form-wrap, .additional-design-request-form-wrap').fadeOut();
	});
});	