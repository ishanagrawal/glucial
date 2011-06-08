<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  function ConfigVars($category, $var_name, $var_desc, $type)
  {
  	global $ConfigVarsInfo;
  	
  	$ConfigVarsInfo[$var_name]['category'] = $category;
  	$ConfigVarsInfo[$var_name]['description'] = $var_desc;
  	$ConfigVarsInfo[$var_name]['type'] = $type;
  }
?>