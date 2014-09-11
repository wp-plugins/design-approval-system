<html>
<head>
<?php require( '../../../../../../wp-blog-header.php' );?>
</head>
<body>
<?php
require_once('class.phpmailer.php');
// Retrieve form data. GET user submitted data using AJAX POST in case user does not support javascript, we'll use POST instead
$email4 = ($_GET['email4']) ?$_GET['email4'] : $_POST['email4'];
$designerEmail = ($_GET['designer_email']) ?$_GET['designer_email'] : $_POST['designer_email'];
$companyname4 = ($_GET['companyname4']) ?$_GET['companyname4'] : $_POST['companyname4'];
$version4 = ($_GET['version4']) ?$_GET['version4'] : $_POST['version4'];
$customNameOfDesign = ($_GET['customNameOfDesign']) ?$_GET['customNameOfDesign'] : $_POST['customNameOfDesign'];
$link4 = ($_GET['link4']) ?$_GET['link4'] : $_POST['link4'];
$pagetitle = ($_GET['pagetitle']) ?$_GET['pagetitle'] : $_POST['pagetitle'];
$human4 = ($_GET['human4']) ?$_GET['human4'] : $_POST['human4'];

//Company Info
$das_settings_company_name = ($_GET['dasSettingsCompanyName']) ?$_GET['dasSettingsCompanyName'] : $_POST['dasSettingsCompanyName'];
$das_settings_company_email = ($_GET['dasSettingsCompanyEmail']) ?$_GET['dasSettingsCompanyEmail'] : $_POST['dasSettingsCompanyEmail'];

//Messages
$das_settings_email_for_designers_message_to_clients = ($_GET['dasSettingsEmailForDesignersMessageToClients']) ?$_GET['dasSettingsEmailForDesignersMessageToClients'] : $_POST['dasSettingsEmailForDesignersMessageToClients'];

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

 	// to designer
	$to_designer = $das_settings_company_email;
	
	//subject to designer 
	$subject_designer = $customNameOfDesign  . ' - ' . $version4 . ' - ' . $companyname4;
	
	// message to designer
	$message_designer = nl2br('' . $companyname4 . ' Comp was sent Successfully. 
	' . $version4 . '
	
	' . $link4 . '
	
	 ');
	
	 ////////////////////////////
	///////// Client ///////////
   ////////////////////////////
	
	// to client
	$to_client = $email4;
	
	//subject to client
	$subject_client = $customNameOfDesign  . ' - ' . $version4 . ' - ' . $companyname4;
	
	// message to client
	$message_client = nl2br('From: '.$das_settings_company_name. '	
	For: ' . $companyname4 . '
	' . $version4 . '
	
	' . $das_settings_email_for_designers_message_to_clients . '
	' . $link4 . '

	');
	
	// Keeping SMPT elements here for future testing, place in $message above to see output.
	// SMPT: ' . $dasSettingsSmtp.'
	// SMPT server: ' . $das_smtp_server.'
	// SMPT Auth?: ' . $das_smtp_checkbox_authenticate.'
	// SMPT port: ' . $das_smtp_port.'
	// SMPT user: ' . $das_smtp_authenticate_username.'
	// SMPT pass: ' . $das_smtp_authenticate_password.'
	
	
foreach	($recipients as $recipient)	{
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
	  $mail->SMTPDebug  = 1;
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
  
  if ($recipient== "designer"){
	$mail->AddReplyTo = $from;
	$mail->FromName   = $das_settings_company_name;
	$mail->From       = $das_settings_company_email;
	$mail->AddAddress($to_designer, $das_settings_company_name);
	$mail->AddCC($designerEmail);
	$mail->Subject  = $subject_designer;
	$mail->MsgHTML($message_designer);
  }
  
  if ($recipient== "client"){
	$mail->AddReplyTo = $from;
	$mail->FromName   = $das_settings_company_name;
	$mail->From       = $das_settings_company_email;
	$mail->AddAddress($to_client, $companyname4);
	$mail->Subject  = $subject_client;
	$mail->MsgHTML($message_client);
  }
  
  if(!$myresult = $mail->Send()) {
	
  } else {
  }
}
	
	//if POST was used, display the message straight away
	?>
<script language="JavaScript">jQuery(document).ready(function(){<?
	if ($_POST) {
		if ($myresult) echo "
					jQuery('#send-email-for-designer').hide();
					jQuery('#send-email-for-designer-done').fadeIn();
					";
		else echo "alert('".$mail->ErrorInfo."');";

		
	//else if GET was used, return the boolean value so that 
	//ajax script can react accordingly
	//1 means success, 0 means failed
	} else {
	 echo "alert('Sorry, unexpected error. Please try again!');";
	}
	?>});</script>
<?
//if the errors array has values
} else {
	//display the errors message
	?>
<script language="JavaScript">jQuery(document).ready(function(){<?
	//for ($i=0; $i<count($errors); $i++) $disperrors.= htmlspecialchars($errors[$i]) . '\n';
	//echo("alert('".$disperrors."');");
	//no alert for errors anymore
	?>});</script>
<?
	exit;
}

?>
</body>
</html>