<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/

/*
- doda� opis budowy plaginu z plikami 
- wysy�anie wiadomo�ci do wszystkich pokoi jako plugin !!!
- pobranie ilu� tam wiadomo�ci wstecz przy chacie prywatnym 
- dorobienie buziek przy prywatnym chacie !!!
- dorobienie dodawania uzytkownikow z lini komend  (10 minut)

~2) zmiana wygladu chata (ok 2h)
 - dorobienie ilosci znakow jakie mozna wpisywac w polach do logowania
   - dodanie tam tabeli statystycznej
     - ilosc wyslanych wiadomosci w sumie na chacie
   - moze dodac checkboxa z zapamietaj haslo
7) wykorzysta� wysylanie rowniez do pobierania nowych wiadomo�ci (15 minut)
*/

  include_once("./include/LTChatConfig.php");
  
  if(!defined("LTChat_Main_datasource"))
  {
	header("Location: ./install.php");
	exit;
  }

  if($_POST['room'] != "")		$room = stripslashes($_POST['room']);
  else							$room = 'home';

  $LTParser = new LTChatTplParser($room);

  if($_GET['branch'] == "reg")				echo $LTParser->get_registration_form();
  elseif($_GET['branch'] == "shout")		echo $LTParser->get_shoutbox(0);
  elseif($_GET['branch'] == "static_html")	echo $LTParser->get_static_html($_GET['doc_id']);
  elseif($_GET['branch'] == "statistics")	echo $LTParser->get_statistics();
  else										echo $LTParser->get_chat();
?>