<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
/*
  $_GET['room'];
  $_GET['lastid'];
  $_GET['user'];
  $_GET['text'];
  $_GET['time'];
*/

  include_once("./include/LTChatConfig.php");
  $chat = new LTChatCore();


  header('Content-type: text/xml');

  if($_GET['private_id'] == "")		$private_id = -1;
  else 								$private_id = (int)urldecode($_GET['private_id']);

  if($_GET['datatype'] == "all_data")
  {
    $var = $chat->get_all_xml_data(urldecode($_GET['room']), $private_id, (int)$_GET['msg_last_id'], (int)$_GET['prv_msg_last_id'], (int)$_GET['user_status_last_id']);
    echo $var;
  }
  
  if($_GET['datatype'] == "private" && $private_id > 0)
  {
    echo $chat->get_all_private_xml_data($private_id, (int)$_GET['msg_last_id'], (int)$_GET['user_status_last_id']);
  }
  
  if($_GET['datatype'] == 'shoutbox')
  {
    echo $chat->get_shoutbox_xml_data((int)$private_id, (int)$_GET['msg_last_id']);
  }
?>