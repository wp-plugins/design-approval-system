<html>>
<head>
</head>
<body>
<?php
require_once('class.phpmailer.php');
//Retrieve form data. 
//GET - user submitted data using AJAX
//POST - in case user does not support javascript, we'll use POST instead
$email4 = ($_GET['email4']) ?$_GET['email4'] : $_POST['email4'];
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

if (!$human4 ['human4'] == '') {$errors[count($errors)] = 'It appears you may be trying to submit spam. Please disreguard this notice and try again if we made a mistake.'; }

//if the errors array is empty, send the mail
?></script><?
if (!$errors) {

	/* Client recieving the Design Comp */
	//recipient
	$to = $companyname4 .  '<' . $email4 . '>';
	 
	//sender
	$from = $das_settings_company_name. '<' .$das_settings_company_email. '>';
	
	//subject and the html message
	$subject = $customNameOfDesign  . ' - ' . $version4  . ' - ' . $companyname4;	
	$message = nl2br('From: '.$das_settings_company_name. '	
	For: ' . $companyname4 . '
	' . $version4 . '
	
	' . $das_settings_email_for_designers_message_to_clients . '
	' . $link4 . '

	');

	//send the mail
	sendmail($to, $subject, $message, $from);

	/* confirmation to sender */
	//recipient
	$to = $das_settings_company_name. '<' .$das_settings_company_email. '>'; // note the comma to add additional recipients
	 
	//sender
	$from = $das_settings_company_name. '<' .$das_settings_company_email. '>' ;
	
	//subject and the html message
	$subject = $customNameOfDesign  . ' - ' . $version4  . ' - ' . $companyname4;			
	$message = nl2br('' . $companyname4 . ' Comp was sent Successfully. 
	' . $version4 . '
	
	' . $link4 . '
	 ');

	//send the mail
	$result = sendmail($to, $subject, $message, $from);
	
	//if POST was used, display the message straight away
	?><script language="JavaScript">jQuery(document).ready(function(){<?
	if ($_POST) {
		if ($result) echo "
					jQuery('#send-email-for-designer').hide();
					jQuery('#send-email-for-designer-done').fadeIn();
					";
		else echo "alert('Sorry, unexpected error. Please try again!');";

		
	//else if GET was used, return the boolean value so that 
	//ajax script can react accordingly
	//1 means success, 0 means failed
	} else {
		echo $result;	
	}
	?>});</script><?
//if the errors array has values
} else {
	//display the errors message
	?><script language="JavaScript">jQuery(document).ready(function(){<?
	//for ($i=0; $i<count($errors); $i++) $disperrors.= htmlspecialchars($errors[$i]) . '\n';
	//echo("alert('".$disperrors."');");
	//no alert for errors anymore
	?>});</script><?
	exit;
}

//Simple mail function with HTML header
function sendmail($to, $subject, $message, $from) {

       	$mail = new PHPMailer ();
       	$mail->CharSet = "utf-8";
       	$mail->From = $from;
		$mail->FromName = $companyname;
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
</body></html>