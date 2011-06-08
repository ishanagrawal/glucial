<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  include_once("./include/LTChatConfig.php");

  $LTParser = new LTChatTplParser();
  
  echo $LTParser->get_command_tpl($_GET['load_template'], unserialize(stripslashes(urldecode($_GET['other_vars']))));
?>