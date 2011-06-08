<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  include_once("./include/LTChatConfig.php");

  session_start();
  $_SESSION = array();

  if (isset($_COOKIE[session_name()]))
    setcookie(session_name(), null, time()-42000, '/'); 
  session_destroy();
  
  $location = urldecode($_GET['back']);
  if($location == null)
    $location = "./";

  header("Location: {$location}");
?>