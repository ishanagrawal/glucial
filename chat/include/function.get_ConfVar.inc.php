<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  function get_ConfVar($var_name)
  {
	if(isset($GLOBALS['LTChatConfig'][$var_name]))
	  return $GLOBALS['LTChatConfig'][$var_name];
	elseif(defined($var_name)) 
	  return constant($var_name);
	else 
	  return null;
  }
?>