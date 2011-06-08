<?php 
session_start();
require_once("textChat.php");
$refresh = new chat();
require_once("textChat.php");
$query="select user_name, text from text_chat";
$a=$refresh->connect_easy($query);
$refresh->show($a);
?>