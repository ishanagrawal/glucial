<?php

include_once('configs/config.php');

//session_start();
$user = new User();
$row = $user->fetchRow(
        "external_id = '{$_GET['UID']}'"
    );

//Validate all the user information that Facebook sends to us
//phpinfo();
if ($row) {
    
    //require($GLOBALS['root_directory'] . "libs/PHPMailer/class.phpmailer.php");
    //$mail = new PHPMailer(); 
    //$mail->IsSMTP(); // send via SMTP
    ////IsSMTP(); // send via SMTP
    //$mail->SMTPSecure = "ssl";
    //$mail->SMTPAuth = true; // turn on SMTP authentication
    //$mail->Username = "binhngoc17@gmail.com"; // SMTP username
    //$mail->Password = "*******"; // SMTP password
    //$webmaster_email = "binhngoc17@gmail.com"; //Reply to this email ID
    //$email=$_GET['email']; // Recipients email ID
    //$name=$_GET['firstName']; // Recipient's name
    //$mail->From = $webmaster_email;
    //$mail->FromName = "Glucial";
    //$mail->AddAddress($email,$name);
    //$mail->AddReplyTo($webmaster_email,"Glucial");
    //$mail->WordWrap = 50; // set word wrap
    ////$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
    ////$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
    //$mail->IsHTML(true); // send as HTML
    //$mail->Subject = "Welcome to Glucial!";
    //$mail->Body = "Hi,
    //Welcome to Glucial! <br>We are happy to have you as one of our initial tester!<br>Thanks a lot for helping out! We will keep you 
    //updated of all exciting news(dont worry, we dont spam!) "; //HTML Body
    //$mail->AltBody = "Welcome to Glucial! We are happy to have you as one of our initial tester! Thanks a lot for helping out! We will keep you 
    //updated of all exciting news(dont worry, we dont spam!)"; //Text Body
    ////$_SESSION['user_informations']['username'] = $row['username'];
    //if(!$mail->Send())
    //{
    //echo "Mailer Error: " . $mail->ErrorInfo;
    //}
    //else
    //{
    //echo "Message has been sent";
    //}
    $_SESSION['user_informations']['uid'] = $row['id'];
    $_SESSION['user_informations']['external_id'] = $row['external_id'];
    //print_r($_SESSION);
    header("Location: profile.php?uid=" . $row['id']);
    //$_SESSION['user_informations']['uid'] = $row['id'];
    
} else {
    
    $data = array(
	
	'external_id' => $_GET['UID'],
	'fname' => $_GET['firstName'],
	'lname' => $_GET['lastName'],
	'email' => $_GET['email'],
	'gender' => $_GET['gender'],
	'country' => $_GET['country'],
	'state' => $_GET['state'],
	'city' => $_GET['city'],
	'zip' => $_GET['zip'],
	'profile_url' => $_GET['profileURL'],
	'created' => $_GET['timestamp'],
	'login_provider' => $_GET['loginProvider'],
	'login_provider_uid' => $_GET['loginProviderUID'],
	'photo_url' => $_GET['photoURL'],
	'thumbnail_url' => $_GET['thumbnailURL'],
    );
    
    if ($uid = $user->insert($data)){

	$user_info = $user->find($uid);
	//$_SESSION['user_informations']['username'] = $user_info['username'];
	$_SESSION['user_informations']['uid'] = $user_info['id'];
	$_SESSION['user_informations']['external_id'] = $user_info['external_id'];
	header("Location: profile.php?uid=" . $uid);
	
    }
    
    
}