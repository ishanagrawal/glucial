<html>
<head></head>
<body>

<?php
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
}
else 
{
	//echo "Not Hi";
	$query="INSERT INTO user (external_id,fname,lname,email,gender,country,state,city,zip,profile_url,created,login_provider,login_provider_uid)
	VALUES ('$_GET[UID]','$_GET[firstName]','$_GET[lastName]','$_GET[email]','$_GET[gender]','$_GET[country]','$_GET[state]','$_GET[city]','$_GET[zip]','$_GET[profileURL]','$_GET[timestamp]','$_GET[loginProvider]','$_GET[loginProviderUID]')";
	if (!mysql_query($query,$con))
	{
		die('Error: ' . mysql_error());
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

 
//Dummy record 
$time = (time()+(3600*24*1000000)); 
setcookie('glucial_user',$_GET['firstName'],$time); 
setcookie('glucial_user_id',$user_id."",$time); 
 
echo "<br>\ncookie user:".$_COOKIE['glucial_user'];
echo "<br>\ncookie user_id:".$_COOKIE['glucial_user_id'];

if (isset($_COOKIE['glucial_user']) && $_COOKIE['glucial_user'] != '' && isset($_COOKIE['glucial_user_id']) && is_numeric($_COOKIE['glucial_user_id'])){ 
    //you may want to validate your user record here 
    $CURUSER['glucial_user'] = $_COOKIE['glucial_user']; 
    $CURUSER['glucial_user_id'] = $_COOKIE['glucial_user_id']; 
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
?>

<?php
mysql_close($con);
?>

</body>
</html>