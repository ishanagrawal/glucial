<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
function connect()
{
 
  $db_host = "localhost";
  $db_user = "root";
  $db_password = "krasnal";
  $db_name = "lkchat";

  $link = mysql_connect($db_host,$db_user,$db_password);// or die("fuck! polaczenie z baza lezy!!!");
  mysql_select_db($db_name) or die(mysql_error());

  return $link;
}
?>