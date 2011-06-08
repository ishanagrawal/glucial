<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/

/*
- dodaæ opis budowy plaginu z plikami 
- wysy³anie wiadomoœci do wszystkich pokoi jako plugin !!!
- pobranie iluœ tam wiadomoœci wstecz przy chacie prywatnym 
- dorobienie buziek przy prywatnym chacie !!!
- dorobienie dodawania uzytkownikow z lini komend  (10 minut)

~2) zmiana wygladu chata (ok 2h)
 - dorobienie ilosci znakow jakie mozna wpisywac w polach do logowania
   - dodanie tam tabeli statystycznej
     - ilosc wyslanych wiadomosci w sumie na chacie
   - moze dodac checkboxa z zapamietaj haslo
7) wykorzystaï¿½ wysylanie rowniez do pobierania nowych wiadomoï¿½ci (15 minut)
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