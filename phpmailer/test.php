<?php
//error_reporting(1);
ini_set('display_errors', '1');
date_default_timezone_set('Asia/Kolkata');
$email="pmanikiran_1998@yahoo.co.in";
$username="falcon";
$reg_code="1234567890";
$base="https://www.unsync.tk/";
$htmlbody='<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/><title>Welcome to UnSync, dear '.$username.'</title><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><link href="https://fonts.googleapis.com/css?family=Raleway:400,500,700,300,600" rel="stylesheet"><style>html,body{font-family:Raleway, Arial, Helvetica, sans-serif !important;text-align:center !important;display:block !important;color:#f0f0f0 !important}.container{width:80% !important;position:absolute !important;top:0 !important;left:10% !important;margin:0 !important;padding:0 !important;background-color:#303030 !important;box-sizing:border-box !important}section{width:100% !important;margin:0 !important;padding:0 !important;box-sizing:border-box !important}h1,h2,h3{margin:0 !important}.intro{background:url('.$base.'assets/images/mail/bg.jpg) no-repeat !important;background-size:cover !important;color:#fff !important;padding:100px 0px !important}.intro img{width:100px !important;height:100px !important;margin:10px !important}.intro h1{font-size:36px !important;font-weight:300 !important}.intro h2{font-size:16px !important;font-weight:800 !important}.body{padding:20px !important;border-bottom:1px solid #fff !important;box-sizing:border-box !important}.body h1{font-size:36px !important;color:#f0f0f0 !important;font-weight:700 !important}.body h2{font-size:23px !important;color:#cecece !important;font-weight:500 !important}.body h2 span{font-weight:bold !important}.body p{font-size:12px !important;color:#cecece !important}.body .code{color:#ccc !important;font-size:32px !important;padding:5px !important;margin:40px !important;font-family:Arial, Helvetica, sans-serif !important;font-weight:700 !important;background:#000 !important;border-radius:5px !important}.body a{font-size:16px !important;font-weight:500 !important;color:#a4a4a4 !important;text-decoration:none !important;width:120px !important;height:38px !important;display:block !important;background:#ededed !important;border-radius:2px !important;padding:0 !important;padding-top:20px !important}.body .regards{text-align:left !important;font-weight:400 !important;font-size:15px !important}.footer{padding:20px !important;padding-bottom:40px !important}.footer h3{float:left !important}.footer-links{float:right !important}.footer-links a{padding-right:10px !important}</style></head><body><div class="container"><section class="intro"><img src="'.$base.'assets/images/unsync.png"><h1>UnSync</h1><h2>Dont Waste Money!</h2></section><section class="body"><h1>Welcome</h1><h2>to UnSync, dear <span>'.$username.'</span></h2><p>Thank you for being part of UnSync family. Your account activation code is: </p><span class="code">'.$reg_code.'</span><p align="center"><a href="'.$base.'activate?email='.$email.'&code='.$reg_code.'">VERIFY NOW</a></p><p class="regards">Regards,<br><strong>UnSync Admin</strong><br><em>craziesthacker@gmail.com</em></p></section><section class="footer"><h3>&copy; UnSync 2016</h3><div class="footer-links"><a href="#"><img src="'.$base.'assets/images/mail/facebook.png"></a><a href="#"><img src="'.$base.'assets/images/mail/twitter.png"></a></div></section></div></body></html>';

require 'PHPMailerAutoload.php';
require 'vendor/autoload.php';

$mail = new PHPMailerOAuth;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->AuthType = 'XOAUTH2';
$mail->oauthUserEmail = "craziesthacker@gmail.com";
$mail->oauthClientId = "363989944846-fdl6vc7e4g559o6dkpqmheb6hfuidk5a.apps.googleusercontent.com";
$mail->oauthClientSecret = "B0JgH7zb9Q7Uuvh0ABwR-OhV";
$mail->oauthRefreshToken = "1/KyQb4N9fKkVT5sdmkcPGNIyBOyHSbyTZ9Vdfy6I7NYQ";
$mail->setFrom('craziesthacker@gmail.com', 'UnSync Admin');
$mail->addAddress($email, $username);
$mail->Subject = 'Welcome to UnSync, dear '.$username;
$mail->msgHTML('Hello World');
$mail->AltBody = 'This is a plain-text message body';
echo 'Works fine till sending...';
if (!$mail->send()) {
	echo "Mail Could not be sent!";
}
else
{
	echo "Mail Sent";
}
?>