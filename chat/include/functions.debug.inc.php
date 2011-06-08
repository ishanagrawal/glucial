<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  function debug($var, $class = null, $line = null)
  {
  	return;

    $v = var_export($var, true);
    $f = fopen("_debug.txt","a");
    
    fwrite($f,"{$class} ($line)\n".stripslashes($v)."\n\n");
    fclose($f);
  }

  function dtrueme()
  {
//    if($_SERVER['REMOTE_ADDR'] == '83.29.144.71')
//      return true;
    return false;
  }
  
  function dme($var)
  {
  	if(!dtrueme())  return;
  	 
    echo "<pre>";
    print_r($var);
    echo "</pre>";
  }

  function d($var)
  {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
  }
?>