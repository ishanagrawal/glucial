<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  define("LTTpl_required_reg_mark","*");

  define("LTTpl_login_selroom","Wybierz pokój");

  define("LTTpl_static_html","Dokument nie istnieje.");

  define("LTTpl_required_reg_desc","* Zaznaczone pola muszą zostać wypełnione.");

  define("LTChatCore_user_doesnt_exists", "Użytkownik \"#user#\" nie istnieje.");

  define("ChFunBadCommand", "Komenda \"#command#\" jest niepoprawna. Wpisz \"/?\" lub \"/help\" aby wyświetlić pomoc.");
  define("LTChatRoomChangeMsg", "Jesteś w pokoju \"#room_name#\".");
  define("ChFunBadFunction","Funkcja nie została zaimplementowana");

  define("ChFunNoRights","Nie masz praw do wykonania tego polecenia.");
  
  define("ChCore_login_err_bad_pass","Złe hasło.");
  define("ChCore_login_err_bad_login","Zły login.");
  define("ChCore_guest_user_exists","Nie możesz zalogować się na tego użytkownika. Nazwa została już zarezerwowana.");
  
//------------------------ fullhelp -------------------------
  define("LTTpl_fullhelp_title","Loista komend");
  define("LTTpl_fullhelp_desc","Lista komend która może być uzyta w czacie.");
########################## fullhelp #########################

//------------------------ me -------------------------------
  define("LTTpl_me_title", "Profil użytkownika \"#user#\".");
  define("LTTpl_me_send", "Uaktualnij swój profil.");
  define("LTTpl_me_error_fill_required","Wymagane pola muszą być wypełnione.");
  define("LTTpl_me_error_bad_type", "Wpisano zły typ danych");
########################## me ###############################

//------------------------ bug ------------------------------
  define("LTTpl_bug_title", "Raport o błędach");
  define("LTTpl_bug_send", "Wyślij raport");
########################## bug ##############################
  
//------------------------ config ---------------------------
  define("LTTpl_config_title","Konfiguracja czata");
  define("LTTpl_config_submit","Zapisz");
########################## config ###########################

////////////////////////////////////////////////////////////
// COMMANDS
////////////////////////////////////////////////////////////

//------------------------ help ----------------------------
// jezeli komenda nie jest rozpoznawana przez system
  define("ChFun_help_UnknownCommand",ChFunBadCommand);
########################## help #############################

//------------------------ whoami ---------------------------
  define("ChFun_whoami", "Jesteś zalogowany jako \"#user#\".");
//######################## whoami ###########################

//------------------------ ping -----------------------------
  define("ChFun_ping_BadHost", "Zła nazwa hosta");
  define("ChFun_ping_Disabled", "Niskopoziomowa obsługa socket-ów jest wyłączona na tym serwerze.");
  define("ChFun_ping_ResolveErr", "Nie można znaleźć hosta (#host#).");
  define("ChFun_ping_Info", "Badanie #host# [#ip#] z użyciem 32 bajtów danych:");
  define("ChFun_ping_Info_resp", "Odpowiedź z #ip#: bajtów=#b# czas=#time#");
  define("ChFun_ping_Info_Timeout", "Upłynoł limit czasu rządania.");
//######################## ping #############################

//------------------------ kick -----------------------------
  define("ChFun_kick_BadNick", "Użytkownik \"#user#\" nie istnieje.");
  define("ChFun_kick_OkReason", "Użytkownik \"#user#\" został usunięty z powodu: \"#reason#\"");
  define("ChFun_kick_Ok", "Użytkownik \"#user#\" został usunięty.");
########################## kick #############################

//------------------------ prv ------------------------------
// tytul prywatnego chata
  define("ChFun_prv_Title","Rozmowa prywatna");
  define("ChFun_prv_msgtome", "Nie możesz wysłać prywatnej wiadomości do siebie samego!");
########################## prv ##############################

//------------------------ configreg ------------------------
// tytul prywatnego chata
  define("ChFun_configreg_Title","Konfiguracja rejestracji użytkowników");
  define("ChFun_configreg_name","Nazwa");
  define("ChFun_configreg_type","Typ");
  define("ChFun_configreg_length","Długość");
  define("ChFun_configreg_required","Wymagany");
  define("ChFun_configreg_delete","Usuń");

  define("ChFun_configreg_add_text","Dodaj pola do rejestracji.");
  define("ChFun_configreg_add_submit", "Zapisz");
  define("ChFun_configreg_add_field_name", "Nazwa pola");
  define("ChFun_configreg_add_items_text", "Typ pola");
  define("ChFun_configreg_add_required_text", "Wymagany");
  define("ChFun_configreg_add_length_text", "Długość pola");
  define("ChFun_configreg_add_options_text", "Opcje oddziel znakiem |");

########################## configreg ########################

//------------------------ friend ---------------------------
  define("ChFun_friend_from_text","Lista twoich przyjaciół");
  define("ChFun_friend_to_text","Lista użytkownikow ktorzy dodali Cię do listy przyjaciół");
  define("ChFun_friend_Eempty","Twoja lista przyjaciół jest pusta");
  define("ChFun_friend_Add", "Użytkownik \"#user#\" został dodany do listy przyjaciół.");
  define("ChFun_friend_Del", "Użytkownik \"#user#\" został usunięty z listy przyjaciół.");
########################## friend ###########################
  
//------------------------ ignore ---------------------------
  define("ChFun_ignore_Add", "Użytkownik \"#user#\" został dodany do listy osób igorowanych.");
  define("ChFun_ignore_Del", "Użytkownik \"#user#\" został usunięty z listy osób ignorowanych.");

  define("ERROR_ignore_msg_from", "Użytkownik ignoruje twoje prywatne wiadomości.");
  define("ERROR_ignore_msg_to", "Ignorujesz tego użytkownika.");
########################## ignore ###########################

//------------------------ configroom -----------------------
  /* napis w select-ie ktory mowi ktory pokoj jest wybrany jako ten do ktorego uzytkownik zostanie zalogowany po starcei  */
  define("ChFun_croom_Default"," (Startowy)"); // mozna zmieniac
  /* Tekst pojawiajacy sie przy zmianie defaultowego pokoju */
  define("ChFun_croom_TxtNoRoomSelDef", "Wybierz pokój który ma zostać ustawiony jako startowy.");
  define("ChFun_croom_DefaultChanged", "Startowy pokój został zmieniony.");

  /* informacja ze pokoj zostal usuniety */
  define("ChFun_croom_RoomDeleted", "Pokój został usunięty.");
  define("ChFun_croom_TxtRc", "Nie podałeś nazwy kategorii.");
  define("ChFun_croom_TxtRn", "Nie podałeś nazwy pokoju.");
  define("ChFun_croom_TxtLRc", "Nazwa kategorii jest zbyt długa (Max #max_room_cat_name#).");  
  define("ChFun_croom_TxtLRn", "Nazwa pokoju jest zbyt długa (Max #max_room_name#).");  
  define("ChFun_croom_TxtExists", "Taki pokój już istnieje. Zmień nazwe pokoju.");
  define("ChFun_croom_RoomAdded", "Pokój został zmieniony.");
  define("ChFun_croom_TxtNoRoomSel", "Wybierz pokój do usunięcia.");
########################## configroom #######################

//------------------------ info -----------------------------
  define("ChFun_info_BadUserName", "Użytkownik \"#user#\" nie istnieje.");
########################## info #############################

//------------------------ skin -----------------------------
  define("ChFun_skin_List", "#name# ");
  define("ChFun_skin_ListSep", ", ");
  define("ChFun_skin_UnParam" , "Nieznany parametr \"#param#\".");
  define("ChFun_skin_CssChanged" , "Css zmieniony na \"#css_name#\".");
  define("ChFun_skin_SkinChanged" , "skórka zmieniona na \"#skin_name#\".");
  define("ChFun_skin_BadCss" , "Zła nazwa pliku Css.");
  define("ChFun_skin_BadSkin" , "Zła nazwa skórki.");
########################## skin #############################

//------------------------ avatar ---------------------------
  define("LTTpl_avatar_title", "Wybor awatara");
########################## avatar ###########################

//------------------------ configrooms ---------------------
  define("ChFun_configrooms_add", "Dodaj pokoj");
  define("ChFun_configrooms_cat_name", "Nazwa kategorii");
  define("ChFun_configrooms_room_name", "Nazwa pokoju");
  define("ChFun_configrooms_defined", "Lista zdefiniowanych pokoi");
  define("ChFun_configrooms_submit", "Stwórz pokój");
  define("ChFun_configrooms_delete", "Usuń");
  define("ChFun_configrooms_default","Ustaw jako domyślny");
########################## configrooms #####################

//------------------------ room -----------------------------
  define("ChFun_room_Changed", "Pokój zmieniony na \"#room#\".");
  define("ChFun_room_BadName", "Zła nazwa pokoju.");
########################## room #############################

############################################################
## COMMANDS
############################################################

////////////////////////////////////////////////////////////
// SHOUTBOX
////////////////////////////////////////////////////////////
  define("LTTpl_shoutbox_msg", "Wiadomość");
  define("LTTpl_shoutbox_nick", "Użytkownik");
  define("LTTpl_shoutbox_submit", "Wyślij");
############################################################
## SHOUTBOX
############################################################

// menu.tpl //////////////////////////////////////////////////
  define("ChMenuHelp","Pomoc");
  define("ChMenuRules","Zasady");
  define("ChMenuStatistics","Tabela statystyczna.");
  define("ChMenuRegister","Zarejstruj się");
  define("ChMenuLogin","Zaloguj się");
##############################################################

// statistics.tpl
	define("LTChat_statistics_rooms_txt","Pokoje");
	define("LTChat_statistics_online_txt","Użytkowincy online");
	define("LTChat_statistics_last_reg_txt","Ostatnio zarejestrowany");
	define("LTChat_statistics_registered_txt","Ilosc zarejestrowanych uzytkownikow");
	define("LTChat_statistics_prv_count_txt","Licznik prywatnych wiadomości");
	define("LTChat_statistics_msg_count_txt","Licznik wiadomości");
	define("LTChat_statistics_msg_sum","Licznik wszystkich wiadomości");
	define("LTChat_statistics_nick_guest","Goś");

  
// registration_form.tpl
  define("LTTpl_user_added","Użytkownik został dodany."); 
  define("ChTPL_RegLogin", "Użytkownik");
  define("ChTPL_RegPass", "Hasło");
  define("ChTPL_RegSub", "Wyślij");

  define("ChTPL_RegErrLogTooShort", "Minimalna ilosc znakow wymagana na login to #chars# znakow.");
  define("ChTPL_RegErrPasTooShort", "Minimalna ilosc znakow wymagana do hasla to #chars# znakow.");
  define("ChTPL_RegErrUserBadNick", "Zła nazwa użytkownika możliwe są tylko znaki 0-9 a-Z oraz _.");
  define("ChTPL_RegErrUserExists", "Użytkownik już istnieje.");
  define("ChTPL_RegErrFillAllFields", "Wypełnij wszystkie wymagane pola.");
  
//  login_form.tpl
  define("ChTPL_LogLogin", "Użytkownik");
  define("ChTPL_LogPass", "Hasło");
  define("ChTPL_LogSub", "Wejdź");
  define("ChTPL_LogGuest", "Loguj jako gość");

  define("ChFun_January", "Styczeń");
  define("ChFun_February", "Luty");
  define("ChFun_March", "Marzec");
  define("ChFun_April", "Kwiecień");
  define("ChFun_May", "Maj");
  define("ChFun_June", "Czerwiec");
  define("ChFun_July", "Lipiec");
  define("ChFun_August", "Sierpień");
  define("ChFun_September", "Wrzesien");
  define("ChFun_October", "Pazdziernik");
  define("ChFun_November", "Listopad");
  define("ChFun_December", "Grudzień");

// komendy
  define("LTChatCOM_help_desc", "Wyświetla dokument pomocy.");
  define("LTChatCOM_help_param", "Komenda");
  define("LTChatCOM_fullhelp_desc", "Wyświetla liste wszystkich dostępnych komend z informacjami o nich.");
  define("LTChatCOM_bug_desc", "Wyślij raport o błędach.");
  define("LTChatCOM_room_desc", "Zmiana pokoju.");
  define("LTChatCOM_room_param", "Nazwa pokoju");
  define("LTChatCOM_clear_desc", "Czyści okno czata.");
  define("LTChatCOM_ignore_desc_add", "Dodaje użytkownika do listy osób ignorowanych. Uzytkownik nie będzie mógł wysyłać prywatnych wiadomości do Ciebie.");
  define("LTChatCOM_ignore_desc_del", "Usówa użytkownika z listy osób ignorowanych.");
  define("LTChatCOM_ignore_param", "Nazwa użytkownika");
  define("LTChatCOM_prv_desc", "Pozwala na wysyłanie prywatnych wiadomości.");
  define("LTChatCOM_prv_param", "Nazwa Użytkownika");
  define("LTChatCOM_removefriend_desc", "Usówa użytkownika z listy przyjaciół.");
  define("LTChatCOM_removefriend_param", "Nazwa użytkownika");
  define("LTChatCOM_friend_desc_add", "Adds a friend from your friend list.");
  define("LTChatCOM_friend_desc_del", "Usówa użytkownika z listy przyjaciół.");
  define("LTChatCOM_friend_desc_show", "Wyświetla wszystkich użytkowników z twojej listy przyjaciół.");
  define("LTChatCOM_url_desc", "Pozwala na umieszczenie adresu URL jako wiadomość na czacie.");
  define("LTChatCOM_url_param", "Adres URL");
  define("LTChatCOM_unignore_desc", "Usówa użytkownika z listy osób ignorowanych.");
  define("LTChatCOM_unignore_param", "Nazwa Użytkownika");
  define("LTChatCOM_kick_desc", "Usówa użytkownika z systemu. Można podać powód usunięcia.");
  define("LTChatCOM_kick_param1", "Nazwa użytkownika");
  define("LTChatCOM_kick_param2", "Powód");
  define("LTChatCOM_me_desc", "Informacje o użytkowniku.");
  define("LTChatCOM_whoami_desc", "Wyświetla nazwe użytkownika.");
  define("LTChatCOM_ping_param", "Host");
  define("LTChatCOM_ping_desc", "Wysyła pakiety ICMP ECHO_REQUEST do hostów sieciowych.");
  define("LTChatCOM_logout_desc", "Wyjscie z czata.");
  define("LTChatCOM_configrooms_desc", "Konfiguracja pokoi.");
  define("LTChatCOM_configrooms_desc_setskin", "Ustawia skórki dla czata.");
  define("LTChatCOM_configrooms_desc_showskins", "Wyświetla liste dostepnych skinów.");
  define("LTChatCOM_configrooms_desc_setcss", "Ustawia css-a dla czata.");
  define("LTChatCOM_configrooms_desc_showcss", "Wyświetla liste dostępnych css-ów.");
  define("LTChatCOM_configrooms_param1", "Nazwa_skina");
  define("LTChatCOM_configrooms_param2", "Nazwa_css-a");
  define("LTChatCOM_whois_desc", "Wyświetla informacje o wybranym użytkowniku.");
  define("LTChatCOM_whois_param", "Nazwa użytkownika");
  define("LTChatCOM_emoticons_desc", "Lista dostepnych emotikon.");
  define("LTChatCOM_config_desc", "Konfiguracja zmiennych czata.");
  define("LTChatCOM_avatar_desc", "Wybór awatara dla użytkownika.");
  define("LTChatCOM_configreg_desc", "Konfiguracja pól przy rejestracji.");
 

// komendy  

  define(LTTpl_me_reg_text, "Data rejestracji");
  define(LTTpl_me_last_seen_text, "Ostatnio widziany");
  define(LTTpl_me_posted_msg_text, "Wysłanych wiadomości");
  define(LTTpl_me_last_host_text, "Ostatni Host");
  define(LTTpl_me_last_ip_text, "Ostatnie IP");
  
/////////////// MODYFIKOWALNE ZMIENNE ///////////////////

  define("LTChart_CONF_PERFORMANCE","Szybkość");
  define("LTChart_CONF_OTHER","Inne opcje czata");

  define("_DESC_LTChart_offline_user_after", "Informacja po jakim czasie braku reakcji od uzytkownika zostaje on wyrzucony z kanalu (sekundy).");
  define("_DESC_LTChart_delete_offline_data", "Po jakim czasie informacjie o tym ze uzytkownik jest offline maja byc usunięte bazy (sekundy).");
  define("_DESC_ChRefreshAfter", "Co jaki czas system ma sprawdzac czy przyszły jakieś nowe wiadomości (milisekundy).");
  define("_DESC_ChDK_max_msg_get", "Maksymalna ilość wiadomości czata, które użytkownik może pobrać.");
  define("_DESC_ChDK_max_SB_msg_get", "Maksymalna ilość wiadomości shoutbox-a, które użytkownik może pobrać.");
  define("_DESC_ChDK_max_msg_time_back", "Przy wejsciu do pokoju uzytkownik nie dostanie wiadomosci starszych niż (sekundy).");
  define("_DESC_ChDK_max_msg_on_enter", "Przy wjeściu do pokoju ile wiadomości wstecz może dostać użytkownik.");
  define("_DESC_ChDK_max_SB_msg_on_enter", "Przy wjesciu do shoutboxa ile wiadomości wstecz może dostać użytkownik.");
  define("_DESC_LTChatCore_user_min_login_chars", "Minimalna ilosc znaków dopuszczalna przy loginie.");
  define("_DESC_LTChatCore_user_min_password_chars", "Minimalna ilosc znaków dopuszczalna przy haśle.");
  define("_DESC_ChDK_delete_free_avatar_after", "Odebranie avatara użytkownikowi jeżeli nie loguje się dłużej niż (sekund).");
  define("_DESC_ChDK_delete_guest_after", "Po jakim czasie konto gościa ma zostać usunięte (sekundy).");
  define("_DESC_ChDK_delete_user_after", "Usunięcie użytkownika jeżeli nie loguje się dłużej niż (sekund).");
  define("_DESC_LTChatCore_guest_account", "Czy jest dozwonlone logowanie na konto gościa.");
  define("_DESC_LTChat_md5_passwords", "Koduj hasło funkcją md5.");
?>