<?php

include_once '../site_connection.php';

$row = $_SESSION['user_row'];

// For testing - hardcoded email
$to_email = "furnivision7@gmail.com"; // Test email
$to_name = "Furnivision";

/**
 * This example shows making an SMTP connection with authentication.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "smtp.gmail.com";
//Set the SMTP port number
$mail->Port = 465;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
//Username to use for SMTP authentication
$mail->Username = SMTP_USERNAME;
//Password to use for SMTP authentication
$mail->Password = SMTP_PASSWORD;
//Set who the message is to be sent from
$mail->setFrom(SMTP_USERNAME, 'Furnivision');
//Set an alternative reply-to address
$mail->addReplyTo(SMTP_USERNAME, 'Furnivision');
//Set who the message is to be sent to
$mail->addAddress($to_email,$to_name);
//Set the subject line
$mail->Subject = 'OTP for password change';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body

$otp = rand(111111,999999);
$mail->msgHTML("Dear Customer,<br><br>Greeting of the day<br><br>Welcome to COZA STORE (PR_Store) <br>Your password change OTP is <b>".$otp."</b>"."<br><br>Thanks for being with us...<br><br>Thanks & Regards,<br>COZA STORE (PR_Store) (Coza Store)<br><br><br>*****************<br><i><b>Note:</b><br> - Please do not share this OTP to anyone...<br>- This is auto generated mail, requesting you kindly do not reply on this mail...<br>- This is not active shopping website, its made for learning purpose...");

//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if ($mail->send()) {
    $_SESSION['otp'] = $otp;
    echo "OTP sent successfully to " . $to_email;
    header('location:../otp.php');
} else {
    echo "Mailer Error: " . $mail->ErrorInfo;
    die();
}