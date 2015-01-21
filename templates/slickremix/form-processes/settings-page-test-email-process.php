<html>
<head>
<?php require( '../../../../../../wp-load.php' );?>
</head>
<body>
<?php
require_once('class.phpmailer.php');
// Retrieve form data. GET user submitted data using AJAX POST in case user does not support javascript, we'll use POST instead

//Company Info
$das_settings_company_name = ($_GET['dasSettingsCompanyName']) ?$_GET['dasSettingsCompanyName'] : $_POST['dasSettingsCompanyName'];
$das_settings_smtp_email = ($_GET['das-smtp-authenticate-username']) ?$_GET['das-smtp-authenticate-username'] : $_POST['das-smtp-authenticate-username'];
$das_settings_company_email = ($_GET['dasSettingsCompanyEmail']) ?$_GET['dasSettingsCompanyEmail'] : $_POST['dasSettingsCompanyEmail'];


//flag to indicate which method it uses. If POST set it to 1
if ($_POST) $post=1;

//Simple server side validation for POST data, of course, you should validate the email

if (!$human4 ['human4'] == '') {$errors[count($errors)] = 'It appears you may be trying to submit spam. Please disreguard this notice and try again if we made a mistake.'; }


$recipients = array("designer", "client");

if (!$errors) {
 
	//sender this will always be the same
	$from = $das_settings_company_email;
	
	 ////////////////////////////
	///////// Designer /////////
   ////////////////////////////
	
	//check whether or not we are sending email to check SMTP or the default mail.
	$sending_SMTP_or_default = get_option( 'das-settings-smtp' );
 	 // SMTP Authenticate?
	  if ($das_smtp_checkbox_authenticate == '1') {
		$to_designer = $das_settings_smtp_email;
	  }
	  // Default sendmail	
	  else{
		  $to_designer = $das_settings_company_email;
	  }
	   
 
 $smtp_checked =  get_option( 'das-settings-smtp' );
		
if ($smtp_checked == '1') { 
	//subject 
	$subject_designer = 'SMTP Test Email From the Design Approval System';
	// message to designer
	$message_designer = 'Thanks for using our Design Approval System. This email confirms your SMTP Test Email has been delivered.';
}
else {
	//subject
	$subject_designer = 'Test Email From the Design Approval System';
	// message to designer
	$message_designer = 'Thanks for using our Design Approval System. This email confirms your Test Email has been delivered.';
}
	
	
	
	
	
 
  $mail = new PHPMailer();
	  
$dasSettingsSmtp = get_option( 'das-settings-smtp' );
	  
  if ($dasSettingsSmtp == '1') {
	  
	  $das_smtp_checkbox_authenticate = get_option('das-smtp-checkbox-authenticate');
	  
	  //SMTP Authenticate?
	  if ($das_smtp_checkbox_authenticate == '1') {
		  $das_smtp_checkbox_authenticate_final = true;
	  }
	  else{
		  $das_smtp_checkbox_authenticate_final = false;
	  }
	  
	  $mail->IsSMTP();  // telling the class to use SMTP
	//  $mail->SMTPDebug  = 0;
	  $mail->SMTPSecure = get_option( 'das-settings-das-ssl-or-tls-option');
	  $mail->SMTPAuth   = $das_smtp_checkbox_authenticate_final;
	  $mail->Port       = get_option( 'das-smtp-port' ); 
	  $mail->Host       = get_option( 'das-smtp-server' ); 
	  $mail->Username   = get_option( 'das-smtp-authenticate-username' ); 
	  $mail->Password   = get_option( 'das-smtp-authenticate-password' );
  }
  else {
	$mail->IsSendmail(); // telling the class to use SendMail transport
  }
  
   
	$mail->AddReplyTo = $from;
	$mail->FromName   = $das_settings_company_name;
	$mail->From       = $das_settings_company_email;
	$mail->AddAddress($to_designer, $das_settings_company_name);
	$mail->Subject  = $subject_designer;
	$mail->MsgHTML($message_designer);
  
  
  
  if(!$myresult = $mail->Send()) {

  } else {
	  
  }
 
	
	//if POST was used, display the message straight away  echo $mail->ErrorInfo
	?>
<script language="JavaScript">jQuery(document).ready(function(){<?php
	if ($_POST) {
		if ($myresult) echo "
					jQuery('#send-email-settings-page-test').hide();
					jQuery('#send-email-settings-page-test-done').fadeIn('slow');
					";
		else {?>
       				jQuery('#send-email-settings-page-test-error').html("<strong>CONNECTION FAILED:</strong> Please check your settings again as something appears to be incorrect."); 
					jQuery('#send-email-settings-page-test').hide();
					jQuery('#send-email-settings-page-test-error').fadeIn('slow');
				<?php }
		
	//else if GET was used, return the boolean value so that 
	//ajax script can react accordingly
	//1 means success, 0 means failed
	} else {
	 echo "alert('Sorry, unexpected error. Please try again!');";
	}
	?>});</script>

<?php
//if the errors array has values
} else {
	//display the errors message
	?>

<?php
	exit;
}

?>
</body>
</html>