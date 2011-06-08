<?php 	
//require_once("../configs/config.php");
session_start();
require_once("textChat.php");
$submit = new chat();


$query = "insert into
                text_chat
                values
                (" . $_SESSION['user_informations']['uid'] . ","
                . $_GET['chat_id'] . ",'" . $_GET["chat"] . "',NOW())";
$submit->connect_easy($query);
?>