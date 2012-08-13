<html>
<head>
</head>
<body>
<?php
require_once('class.phpmailer.php');
//Retrieve form data. 
//GET - user submitted data using AJAX
//POST - in case user does not support javascript, we'll use POST instead
$a1 = ($_GET['a1']) ?$_GET['a1'] : $_POST['a1'];
$email1 = ($_GET['email1']) ?$_GET['email1'] : $_POST['email1'];
$designtitle = ($_GET['designtitle']) ?$_GET['designtitle'] : $_POST['designtitle'];
//Company Info
$das_settings_company_name = ($_GET['dasSettingsCompanyName']) ?$_GET['dasSettingsCompanyName'] : $_POST['dasSettingsCompanyName'];
$das_settings_company_email = ($_GET['dasSettingsCompanyEmail']) ?$_GET['dasSettingsCompanyEmail'] : $_POST['dasSettingsCompanyEmail'];
//Messages
$das_settings_approved_dig_sig_message_to_designer = ($_GET['dasSettingsApprovedDigSigMessageToDesigner']) ?$_GET['dasSettingsApprovedDigSigMessageToDesigner'] : $_POST['dasSettingsApprovedDigSigMessageToDesigner'];

$das_settings_approved_dig_sig_message_to_clients = ($_GET['dasSettingsApprovedDigSigMessageToClients']) ?$_GET['dasSettingsApprovedDigSigMessageToClients'] : $_POST['dasSettingsApprovedDigSigMessageToClients'];

$human1 = ($_GET['human1']) ?$_GET['human1'] : $_POST['human1'];
?>
<style type="text/css">
	.hightlight1, .hightlight2, .hightlight3   {
	}
	input.hightlight1, input.hightlight2, input.hightlight3  {

		border: 1px solid #FF3A52 !important;
	}
	.error, .error2 { color:red; display:block !important; }
</style>
<script language="JavaScript"><?

//flag to indicate which method it uses. If POST set it to 1
if ($_POST) $post=1;

//Simple server side validation for POST data, of course, you should validate the email
if (!$a1) {$errors[count($errors)] = 'Please enter your Digital Signature.'; ?>jQuery("input[name=a1]").addClass('hightlight1');jQuery(".error-message").addClass('error');
<?}else{?>jQuery("input[name=a1]").removeClass('hightlight1');jQuery(".error-message").removeClass('error');<?}


if (!$human1 ['human1'] == '') {$errors[count($errors)] = 'It appears you may be trying to submit spam. Please disreguard this notice and try again if we made a mistake.'; }

//if the errors array is empty, send the mail
?></script>
<?
if (!$errors) {

	//recipient
	$to = $das_settings_company_name. '<' .$das_settings_company_email. '>';  //. ', '; // note the comma to add additional recipients
	 
	//sender
	$from = $das_settings_company_name . ' <' . $das_settings_company_email . '>';

	//subject and the html message
	$subject = $a1 . ' approved a design comp';	
	$message = nl2br(''.$das_settings_approved_dig_sig_message_to_designer.'
	
	From: ' . $email1 . '
	Digital Signature: ' . $a1 . '
	
	Design Approved: ' . $designtitle.'
	');
    
	//send the mail
	sendmail($to, $subject, $message, $from);
	

	/* confirmation to Signer */
	//recipient
	$to = $a1 . '<' . $email1 . '>';

	 
	//sender
	$from = $das_settings_company_name. '<' .$das_settings_company_email. '>';
	
	//subject and the html message
	$subject = 'Design Comp Confirmation';	
	$message = nl2br(''.$das_settings_approved_dig_sig_message_to_clients.'
	
	From: ' . $email1 . '
	Digital Signature: ' . $a1 . '
	
	Design Approved: ' . $designtitle.'
	
  	Sincerely,
	'.$das_settings_company_name.'
	
	');

	//send the mail
	$result = sendmail($to, $subject, $message, $from);
	
	//if POST was used, display the message straight away
	?>
<script language="JavaScript">jQuery(document).ready(function(){<?
	if ($_POST) {
		if ($result) echo "
					jQuery('.approved-form-wrap').fadeOut();
					
					setTimeout (function(){
					//show the success message and the thank-you message
					jQuery('.approved-thankyou-form-wrap').fadeIn(400); },500);
					
					setTimeout (function(){
					//show the success message and the thank-you message
					jQuery('.approved-thankyou-form-wrap,.pop-up-backg').fadeOut(400); },4000);
					";
		else echo "alert('Sorry, unexpected error. Please try again!');";

		
	//else if GET was used, return the boolean value so that 
	//ajax script can react accordingly
	//1 means success, 0 means failed
	} else {
		echo $result;	
	}
	?>});</script>
<?
//if the errors array has values
} else {
	//display the errors message
	?>
<script language="JavaScript">$(document).ready(function(){<?
	//for ($i=0; $i<count($errors); $i++) $disperrors.= htmlspecialchars($errors[$i]) . '\n';
	//echo("alert('".$disperrors."');");
	//no alert for errors anymore
	?>});</script>
<?
	exit;
}

//Simple mail function with HTML header
function sendmail($to, $subject, $message, $from) {

       	$mail = new PHPMailer ();
       	$mail->CharSet = "utf-8";
       	$mail->From = $from;
		$mail->FromName = $das_settings_company_name;
       	$mail->AddAddress($to);
       //  $mail->AddBCC("spencer@slickremix.com");
       	$mail->IsHTML(true);
       	$mail->Subject = $subject;
       	$mail->Body=$message;
		foreach($_FILES as $file){
		$mail->AddAttachment($file['tmp_name'],$file['name']);
	}

       	$result = $mail->Send();
	
	if ($result) return 1;
	else return 0;
}
?>
</body>
</html>