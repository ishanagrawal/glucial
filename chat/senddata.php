<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  include_once("./include/LTChatConfig.php");
  $chat = new LTChatCore();

  if($_POST['datatype'] == 'shoutbox')
    $chat->post_shoutbox_msg(stripslashes(str_replace("#and#","&",$_POST['msg'])),stripslashes(str_replace("#and#","&",$_POST['login'])), $_POST['private_id']);
  else
    $chat->post_msg(stripslashes(str_replace("#and#","&",$_POST['msg'])),stripslashes($_POST['room']), $_POST['private_id']);
?>