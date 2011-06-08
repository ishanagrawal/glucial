<?php
session_start();	
require_once("textChat.php");
$submit = new chat();
echo "reaches inside submit file";
//$query="insert into text_chat values ('".$_SESSION['uid']."','".$_SESSION['firstName']."','".$_GET["chat"]."','000000',NOW())";
$query="insert into text_chat values ('007','ishan','".$_GET["chat"]."','000000',NOW())";
$submit->connect_easy($query);
?>