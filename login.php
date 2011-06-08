<html>
<head></head>
<body>

<?php
session_start();

$con = mysql_connect("localhost","root","ishan1");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
//echo "select id from user where external_id='{$_GET['UID']}'";
mysql_select_db("glucial", $con);
$externalIds = mysql_query("select id from user where external_id='{$_GET['UID']}'");
if (!$externalIds) {
    die('Could not query:' . mysql_error());
}
//echo "externalIds: " (count(mysql_fetch_assoc($externalIds)));
if ($row = mysql_fetch_assoc($externalIds)) {
	echo "<br>\nWelcome ".$_GET['firstName'];
	//header("Location: http://localhost/profile.php?fname=".$_GET['firstName']);
	echo "Error! Redirect to profile page is not working!";
	//$_SESSION['uid'] = $row['id'];
	//$_SESSION['uid'] = $row
;}
else 
{
	//echo "Not Hi";
	$query="INSERT INTO user (external_id,fname,lname,email,gender,country,state,city,zip,profile_url,created,login_provider,login_provider_uid)
	VALUES ('$_GET[UID]','$_GET[firstName]','$_GET[lastName]','$_GET[email]','$_GET[gender]','$_GET[country]','$_GET[state]','$_GET[city]','$_GET[zip]','$_GET[profileURL]','$_GET[timestamp]','$_GET[loginProvider]','$_GET[loginProviderUID]')";
	if (!mysql_query($query,$con))
	{
		die('Error: ' . mysql_error());
	}
	//mailing
	
	
require("PHPMailer_v5.1/class.phpmailer.php");
echo "<br>I am in the mailing code";
$mail = new PHPMailer(); 
$mail->IsSMTP(); // send via SMTP
//IsSMTP(); // send via SMTP
$mail->SMTPSecure = "ssl";
$mail->SMTPAuth = true; // turn on SMTP authentication
$mail->Username = "ishan@glucial.com"; // SMTP username
$mail->Password = "ishan1234"; // SMTP password
$webmaster_email = "ishan@glucial.com"; //Reply to this email ID
$email=$_GET['email']; // Recipients email ID
$name=$_GET['firstName']; // Recipient's name
$mail->From = $webmaster_email;
echo "\n<br>I am HERE";
$mail->FromName = "Glucial";
$mail->AddAddress($email,$name);
$mail->AddReplyTo($webmaster_email,"Glucial");
$mail->WordWrap = 50; // set word wrap
//$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
$mail->IsHTML(true); // send as HTML
$mail->Subject = "Welcome to Glucial!";
$mail->Body = "Hi,
Welcome to Glucial! <br>We are happy to have you as one of our initial tester!<br>Thanks a lot for helping out! We will keep you 
updated of all exciting news(dont worry, we dont spam!) "; //HTML Body
$mail->AltBody = "Welcome to Glucial! We are happy to have you as one of our initial tester! Thanks a lot for helping out! We will keep you 
updated of all exciting news(dont worry, we dont spam!)"; //Text Body
if(!$mail->Send())
{
echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
echo "Message has been sent";
}

	
	
	echo "<br>\nWelcome ".$_GET['firstName']."!You have been registered!";
	//header("Location: http://localhost/profile.php?fname=".$_GET['firstName']);
	echo "Error! Redirect to profile page is not working!";
}

	$query="SELECT id FROM user where external_id='{$_GET['UID']}';";
	echo "<br>\n".$query;
	$externalIds = mysql_query($query,$con);
	$row= mysql_fetch_assoc($externalIds);
	$user_id=$row['id'];
	echo "<br>\nuser_id: ".$user_id;

$CURUSER = array(); //in this example i am holding loggined user data in CURUSER array 

 
//Set cookie 
$time = (time()+(3600*24*1000000)); 
setcookie("glucial_user",$_GET['firstName'],$time); 
setcookie("glucial_user_id",$user_id."",$time); 
 
echo "<br>\ncookie user:".$_COOKIE["glucial_user"];
echo "<br>\ncookie user_id:".$_COOKIE["glucial_user_id"];

if (isset($_COOKIE["glucial_user"]) && $_COOKIE["glucial_user"] != '' && isset($_COOKIE['glucial_user_id']) && is_numeric($_COOKIE['glucial_user_id'])){ 
    //you may want to validate your user record here 
    $CURUSER['glucial_user'] = $_COOKIE["glucial_user"]; 
    $CURUSER['glucial_user_id'] = $_COOKIE["glucial_user_id"]; 
	echo "<br>\nI am inside if statement";
} 

require("online.class.php"); 
$ONLINE = new whoIsOnline(); 
$ONLINE->setSessionTime(1); //5 mins check 
echo "\n<br>reaches here";
$ONLINE->recordUser($CURUSER['glucial_user_id']); 
$ONLINE->getAllOnlineUsers();
echo "\n<br>reaches after record user";
$ONLINE->cleanup(); //it is good to run this function by cron 

if(isset($CURUSER['glucial_user_id']) && $ONLINE->isOnline($CURUSER['glucial_user_id'])) { 
    echo 'User ', $CURUSER['glucial_user'], ' is online'; 
} 
header("Location: http://localhost/glucial/chatPage.php");
//header("Location: http://localhost/glucial/profile.php?fname=".$_GET['firstName']);
?>

<?php
mysql_close($con);
?>

</body>
</html>