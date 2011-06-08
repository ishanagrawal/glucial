<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
// Report simple running errors
  error_reporting(E_ERROR | E_WARNING | E_PARSE);
  ini_set("register_globals", false);

// wersja chata
  define("Ch_VER", "1.3");

  if(eregi("(.*)\\\\(.*)\\\\(.*)",__FILE__, $path))
  {
    define("LTChart_path", $path[1]);
	define("Win", true);
	define("PATH_SEP","\\\\");
  }
  elseif (eregi("(.*)/(.*)/(.*)",__FILE__, $path))
  {
    define("LTChart_path", $path[1]);
	define("Win", false);
	define("PATH_SEP","/");
  }
  else 
  {
    define("LTChart_path","./");
	define("PATH_SEP","/");
  }

  if(defined("LTChat_Main_datasource"))  die("Fatal error!");
	
  include_once(LTChart_path."/include/LTChatMainConfig.inc.php");

  if(LTChat_Main_datasource == "mysql")
    include_once(LTChart_path."/include/class.LTChatDataKeeper_mysql.inc.php");

  include_once(LTChart_path."/include/class.LTChatCoreFunctions.inc.php");
  include_once(LTChart_path."/include/class.LTChatCore.inc.php");
  include_once(LTChart_path."/include/class.LTChatTplParser.inc.php");
  include_once(LTChart_path."/include/function.ConfigVars.inc.php");
  include_once(LTChart_path."/include/function.get_ConfVar.inc.php");
  include_once(LTChart_path."/include/functions.debug.inc.php");

//////////////////////////////////////////////////////
// PERFORMANCE
//////////////////////////////////////////////////////

//  ConfigVars("PERFORMANCE", "LTChart_offline_user_after", "Informacja po jakim czasie braku reakcji od uzytkownika zostaje on wyrzucony z kanalu (sekundy)", 'int');
  define("LTChart_offline_user_after", 6); // ~~!~~  
  
//  ConfigVars("PERFORMANCE", "LTChart_delete_offline_data", "Po jakim czasie informacjie o tym ze uzytkownik jest offline maja byc wywalone z tabeli", 'int');
  define("LTChart_delete_offline_data", 60*60);
  
//  ConfigVars("PERFORMANCE", "ChRefreshAfter", "Co jaki czas strona ma sprawdzac czy przyszly jakies nowe wiadomosci.(milisekundy)", 'int');
  define("ChRefreshAfter", 1500);

//  ConfigVars("PERFORMANCE", "ChDK_max_msg_get", "Maksymalna ilosc wiadomosci chata ktore uzytkownik moze pobrac", 'int');
  define("ChDK_max_msg_get", 50);     // chat

//  ConfigVars("PERFORMANCE", "ChDK_max_SB_msg_get", "Maksymalna ilosc wiadomosci shoutboxa ktore uzytkownik moze pobrac", 'int');
  define("ChDK_max_SB_msg_get", 50);  // shoutbox

//  ConfigVars("PERFORMANCE", "ChDK_max_msg_time_back", "Przy wejsciu do pokoju uzytkownik nie dostanie wiadomosci starszych niz (ilosc) sekund", 'int');
  define("ChDK_max_msg_time_back", 10);
  
//  ConfigVars("PERFORMANCE", "ChDK_max_msg_on_enter", "Przy wjesciu do pokoju ile wiadomosci wstecz moze dostac uzytkownik", 'int');
  define("ChDK_max_msg_on_enter", 1);
  
//  ConfigVars("PERFORMANCE", "ChDK_max_SB_msg_on_enter", "Przy wjesciu do shoutboxa ile wiadomosci wstecz moze dostac uzytkownik", 'int');
  define("ChDK_max_SB_msg_on_enter", 10);  // shoutbox
######################################################
## PERFORMANCE 
######################################################

  define("LTChatCore_guest_account", true);
  define("LTChat_md5_passwords", true);

//  ConfigVars("LTChart_CONF_OTHER", "LTChatCore_user_min_login_chars", "Minimalna ilosc znakow dopuszczalna przy rejestracji", 'int');
  define("LTChatCore_user_min_login_chars",5);

//  ConfigVars("LTChart_CONF_OTHER", "LTChatCore_user_min_password_chars", "minimalna ilosc znakow dopuszczalna przy hasle", 'int');
  define("LTChatCore_user_min_password_chars",5);
  
// po jakim czasie nie logowania sie na chata uzytkownik ma byc usuniety.(seconds)
  define("ChDK_delete_user_after", 60*60*24*30);

// po jakim czasie nie logowania sie na chata avatar uzytkownika ma zostać zwolniony
  define("ChDK_delete_free_avatar_after",60*60*24*10);

  define("ChDK_delete_guest_after", 60*60*10);
  
//////////////////////////////////////////////////////
// RESTRICTED AREA
//////////////////////////////////////////////////////  
  define("LTChatCore_user_error_too_short_login",1);
  define("LTChatCore_user_error_too_short_password",2);
  define("LTChatCore_user_errro_user_exists",3);
  define("LTChatCore_user_error_fill_required",4);
  define("LTChatCore_user_error_bad_type",5);
  define("LTChatCore_user_error_nick",6);
  
// XML CONFIG
// co zostanie wpisanie w meta tagu:
// <meta http-equiv="content-type" content="text/html; charset=****">
// oraz w polu kodowania znak�w w xmlu
  define("ChPageEncoding","UTF-8");

// styl xmla do uzytkownika
  define("LTChart_message_xml_data",'
    <msg>
      #other_options#
      <datatype>#data_type#</datatype>
      <user_name>#user#</user_name>
      <user_id>#user_id#</user_id>
  	  <time_stamp>#time#</time_stamp>
      <hour>#hour#</hour>
      <minute>#minute#</minute>
      <second>#second#</second>
      <text>#text#</text>
      <id>#id#</id>
      <is_command>#is_command#</is_command>
  	  <LTChatTemplatePath>#LTChatTemplatePath#</LTChatTemplatePath>
    </msg>');

  define("LTChart_user_xml_data",'<info><datatype>user_status</datatype>#options#</info>');
  define("LTChart_xml_data_more_options",'<#option#>#value#</#option#>');
  define("LTChart_message_xml_header",'<?xml version="1.0" encoding="'. ChPageEncoding .'"?><results>	<data>#data#</data></results>');

//  OGRANICZONE ROWNIEZ PRZEZ BAZE DANYCH
  define("LTChat_MaxRoomCatName", 40);
  define("LTChat_MaxRoomName", 40);

  /* nie wpisano nazwy kategori pokoju ChFun_croom_TxtRc*/
  define("ChFun_croom_ErrNoCat", 0);
  /* nie wpisano nazwy pokoju ChFun_croom_ErrNoRoom*/
  define("ChFun_croom_ErrNoRoom", 1);
  /* zbyt dluga nazwa kategori pokoju ChFun_croom_TxtLRc*/
  define("ChFun_croom_ErrLenCat", 3);
  /* zbyt dluga nazwa kategori pokoju ChFun_croom_TxtLRn*/
  define("ChFun_croom_ErrLenRoom", 4);
  /* pokoj juz istnieje ChFun_croom_TxtExists*/
  define("ChFun_croom_ErrExists", 5);
  /* Nie zaznaczono pokoju przy usuwaniu ChFun_croom_TxtNoRoomSel*/
  define("ChFun_croom_ErrNoRoomSel", 6);

// logowanie
  define("ChDK_log_err_bad_password", 0);
  define("ChDK_log_err_bad_login", 1);
  define("ChDK_log_err_banned", 2);

  define("ERROR_ignore_from",0);
  define("ERROR_ignore_to",1);

// logowanie
  define("ChFun_user_var_names","integer,float,text,date,select,radio,textarea")
######################################################
## RESTRICTED AREA
######################################################  
?>