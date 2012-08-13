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
	
//Tabs
jQuery('.comments-tab').addClass('design-tab-selected');
	
	jQuery('.comments-tab').click(function () {	
		jQuery('.comments-tab').addClass('design-tab-selected');
		jQuery('.changes-tab, .additions-tab, .omissions-tab').removeClass('design-tab-selected');
		jQuery('#b2, #b3, #b4').hide();
		jQuery('#b1').slideDown();
	});

	jQuery('.changes-tab').click(function () {	
		jQuery('.changes-tab').addClass('design-tab-selected');
		jQuery('.comments-tab, .additions-tab, .omissions-tab').removeClass('design-tab-selected');
		jQuery('#b1, #b3, #b4').hide();
		jQuery('#b2').slideDown();
	});
	
	jQuery('.additions-tab').click(function () {	
		jQuery('.additions-tab').addClass('design-tab-selected');
		jQuery('.comments-tab, .changes-tab, .omissions-tab').removeClass('design-tab-selected');
		jQuery('#b1, #b2, #b4').hide();
		jQuery('#b3').slideDown();
	});

	jQuery('.omissions-tab').click(function () {	
		jQuery('.omissions-tab').addClass('design-tab-selected');
		jQuery('.comments-tab, .changes-tab, .additions-tab').removeClass('design-tab-selected');
		jQuery('#b1, #b2, #b3').hide();
		jQuery('#b4').slideDown();
	});
});	