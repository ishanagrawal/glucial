<?php 
session_start();
require_once("textChat.php");
$refresh = new chat();
require_once("textChat.php");
$query="select
            u.fName, u.lName, c.text 
            FROM text_chat c, user u
            where u.id = c.uid AND chat_id =" . $_GET['chat_id'] . " ORDER BY c.time";

$a=$refresh->connect_easy($query);
$refresh->show($a);
?>