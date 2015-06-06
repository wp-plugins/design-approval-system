
jQuery('.das-gq-theme-settings-toggle').click(function() {
		jQuery(this).next('.das-settings-id-answer').slideToggle('fast');
	return false;
	}); 
jQuery('.das-color-options-open-close-all').click(function() {
		jQuery('.das-ct-color-options-wrap .das-settings-id-answer').slideToggle('fast');
	return false;
	}); 
    
jQuery(".default-values-gq-theme-option1").click(function () {
	 // alert('wtf');
		
	  var myPicker1 = new jscolor.color(document.getElementById('das-gq-theme-project-icon-color'), {})
		myPicker1.fromString('A5ABAB') 
		
 	  var myPicker2 = new jscolor.color(document.getElementById('das-gq-theme-project-main-header-text-color'), {})
		myPicker2.fromString('1FC7BC') 
		
	  var myPicker3 = new jscolor.color(document.getElementById('das-gq-theme-project-main-header-background-color'), {})
		myPicker3.fromString('F2F2F2') 

	  var myPicker4 = new jscolor.color(document.getElementById('das-gq-theme-project-background-main-btns-hover'), {})
		myPicker4.fromString('1CB5AB') 
		
	  var myPicker5 = new jscolor.color(document.getElementById('das-gq-theme-project-text-main-btns-hover'), {})
		myPicker5.fromString('FFFFFF') 

	  var myPicker6 = new jscolor.color(document.getElementById('das-gq-theme-project-text-color'), {})
		myPicker6.fromString('09484A') 

	  var myPicker7 = new jscolor.color(document.getElementById('das-gq-theme-project-text-link-color'), {})
		myPicker7.fromString('525252') 

	  var myPicker8 = new jscolor.color(document.getElementById('das-gq-theme-project-background-color-boxes'), {})
		myPicker8.fromString('FFFFFF') 

	  var myPicker9 = new jscolor.color(document.getElementById('das-gq-theme-project-background-color-even-comment-boxes'), {})
		myPicker9.fromString('F5F5F5') 

	  var myPicker10 = new jscolor.color(document.getElementById('das-gq-theme-project-border-color'), {})
		myPicker10.fromString('EDEDED') 

 });

jQuery(".default-values-gq-theme-option2").click(function () {
	
	  var myPicker1 = new jscolor.color(document.getElementById('das-gq-theme-project-icon-color'), {})
		myPicker1.fromString('313333') 
		
 	  var myPicker2 = new jscolor.color(document.getElementById('das-gq-theme-project-main-header-text-color'), {})
		myPicker2.fromString('313333') 
		
	  var myPicker3 = new jscolor.color(document.getElementById('das-gq-theme-project-main-header-background-color'), {})
		myPicker3.fromString('F2F2F2') 

	  var myPicker4 = new jscolor.color(document.getElementById('das-gq-theme-project-background-main-btns-hover'), {})
		myPicker4.fromString('E6E6E6') 
		
	  var myPicker5 = new jscolor.color(document.getElementById('das-gq-theme-project-text-main-btns-hover'), {})
		myPicker5.fromString('030303') 

	  var myPicker6 = new jscolor.color(document.getElementById('das-gq-theme-project-text-color'), {})
		myPicker6.fromString('757575') 

	  var myPicker7 = new jscolor.color(document.getElementById('das-gq-theme-project-text-link-color'), {})
		myPicker7.fromString('8A8A8A') 

	  var myPicker8 = new jscolor.color(document.getElementById('das-gq-theme-project-background-color-boxes'), {})
		myPicker8.fromString('FFFFFF') 

	  var myPicker9 = new jscolor.color(document.getElementById('das-gq-theme-project-background-color-even-comment-boxes'), {})
		myPicker9.fromString('F2F2F2') 

	  var myPicker10 = new jscolor.color(document.getElementById('das-gq-theme-project-border-color'), {})
		myPicker10.fromString('FFFFFF') 

    });