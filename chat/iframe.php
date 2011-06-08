<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  include_once("./include/LTChatConfig.php");

  if($_POST['room'] != "")		$room = $_POST['room'];
  else							$room = 'home';

  $LTParser = new LTChatTplParser($room);
  if($_GET['type'] == 'chat_frame')
    echo $LTParser->get_talk_frame();
  elseif($_GET['type'] == 'shoutbox_frame')
    echo $LTParser->get_talk_shoutbox_frame();
  elseif($_GET['type'] == 'users_list')
    echo $LTParser->get_users_list_frame();
  elseif($_GET['type'] == 'private_chat')
    echo $LTParser->get_prv_chat_frame();
  
?>