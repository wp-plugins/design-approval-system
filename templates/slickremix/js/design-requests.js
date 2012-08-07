$(document).ready(function() {	
//Pop-ups
	$('.design-approval-btn').click(function () {	
		$('.pop-up-backg, .approved-form-wrap').fadeIn();
	});
	
	$('#paid').click(function () {	
		$('.pop-up-backg, .design-request-form-wrap').fadeIn();
	});
	
	$('#not-paid').click(function () {	
		$('.pop-up-backg, .additional-design-request-form-wrap').fadeIn();
	});
	$('.close, #cancel').click(function () {	
		$('.pop-up-backg, .approved-form-wrap, .design-request-form-wrap, .additional-design-request-form-wrap').fadeOut();
	});
	
//Tabs
$('.comments-tab').addClass('design-tab-selected');
	
	$('.comments-tab').click(function () {	
		$('.comments-tab').addClass('design-tab-selected');
		$('.changes-tab, .additions-tab, .omissions-tab').removeClass('design-tab-selected');
		$('#b2, #b3, #b4').hide();
		$('#b1').slideDown();
	});

	$('.changes-tab').click(function () {	
		$('.changes-tab').addClass('design-tab-selected');
		$('.comments-tab, .additions-tab, .omissions-tab').removeClass('design-tab-selected');
		$('#b1, #b3, #b4').hide();
		$('#b2').slideDown();
	});
	
	$('.additions-tab').click(function () {	
		$('.additions-tab').addClass('design-tab-selected');
		$('.comments-tab, .changes-tab, .omissions-tab').removeClass('design-tab-selected');
		$('#b1, #b2, #b4').hide();
		$('#b3').slideDown();
	});

	$('.omissions-tab').click(function () {	
		$('.omissions-tab').addClass('design-tab-selected');
		$('.comments-tab, .changes-tab, .additions-tab').removeClass('design-tab-selected');
		$('#b1, #b2, #b3').hide();
		$('#b4').slideDown();
	});
});	