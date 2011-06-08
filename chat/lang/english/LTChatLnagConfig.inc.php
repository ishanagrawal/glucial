<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/

  define("LTTpl_required_reg_mark","*");
  define("LTTpl_login_selroom","Select room");
  define("LTTpl_static_html","Document doesn't exists");
  define("LTTpl_required_reg_desc","* Field can not be empty.");
  define("LTChatCore_user_doesnt_exists", "User \"#user#\" doesn't exists.");
  define("ChFunBadCommand", "Command \"#command#\" is wrong. Please use \"/?\" or \"/help\" to view the help.");
  define("LTChatRoomChangeMsg", "You entered room \"#room_name#\"");
  define("ChFunBadFunction","Function is not implemented");
 
  define("ChFunNoRights","You can not use this command. You are not the administrator.");
 
  
  define("ChCore_login_err_bad_pass","Bad password.");
  define("ChCore_login_err_bad_login","Bad login. User doesn't exist.");
  define("ChCore_guest_user_exists","You can not login to this user. Nick has been allready taken.");
  
//------------------------ fullhelp -------------------------
  define("LTTpl_fullhelp_title","Command list");
  define("LTTpl_fullhelp_desc","Command list whitch can be used in the chat");
########################## fullhelp #########################
 
//------------------------ me -------------------------------
  define("LTTpl_me_title", "User \"#user#\" profile.");
  define("LTTpl_me_send", "Update your profile");
  define("LTTpl_me_error_fill_required","Fill all required fields");
  define("LTTpl_me_error_bad_type", "You entered wrang type of data");
########################## me ###############################
 
//------------------------ bug ------------------------------
  define("LTTpl_bug_title", "Bug report");
  define("LTTpl_bug_send", "Send report");
########################## bug ##############################
 
  
//------------------------ config ---------------------------
  define("LTTpl_config_title","Chat config");
  define("LTTpl_config_submit","Save");
########################## config ###########################
 
////////////////////////////////////////////////////////////
// COMMANDS
////////////////////////////////////////////////////////////
 
//------------------------ help ----------------------------
// jezeli komenda nie jest rozpoznawana przez system
  define("ChFun_help_UnknownCommand",ChFunBadCommand);
########################## help #############################
 
//------------------------ whoami ---------------------------
  define("ChFun_whoami", "You are logged in as \"#user#\".");
//######################## whoami ###########################
 
//------------------------ ping -----------------------------
  define("ChFun_ping_BadHost", "Bad host name");
  define("ChFun_ping_Disabled", "Low level socket support is disabled on this server.");
  define("ChFun_ping_ResolveErr", "Can't resolve hostname (#host#)");
  define("ChFun_ping_Info", "Pinging  #host# [#ip#] with 32 bytes of data:");
  define("ChFun_ping_Info_resp", "Reply from #ip#: bytes=#b# time=#time#ms");
  define("ChFun_ping_Info_Timeout", "Request time limit is up.");
//######################## ping #############################
 
//------------------------ kick -----------------------------
  define("ChFun_kick_BadNick", "User \"#user#\" doesn't exists.");
  define("ChFun_kick_OkReason", "User \"#user#\" was deletet because of: \"#reason#\"");
  define("ChFun_kick_Ok", "User \"#user#\" was deleted.");
########################## kick #############################
 
//------------------------ prv ------------------------------
// tytul prywatnego chata
  define("ChFun_prv_Title","Private chat");
  define("ChFun_prv_msgtome", "You can not send private message to your self!");
########################## prv ##############################
 
//------------------------ configreg ------------------------
// tytul prywatnego chata
  define("ChFun_configreg_Title","User registration config");
  define("ChFun_configreg_name","Name");
  define("ChFun_configreg_type","Type");
  define("ChFun_configreg_length","Length");
  define("ChFun_configreg_required","Required");
  define("ChFun_configreg_delete","Delete");
 
  define("ChFun_configreg_add_text","Add field to registration");
  define("ChFun_configreg_add_submit", "Save");
  define("ChFun_configreg_add_field_name", "Field name");
  define("ChFun_configreg_add_items_text", "Field type");
  define("ChFun_configreg_add_required_text", "Required");
  define("ChFun_configreg_add_length_text", "Field Length");
  define("ChFun_configreg_add_options_text", "Separate options with | sign");
 
########################## configreg ########################
 
//------------------------ friend ---------------------------
  define("ChFun_friend_from_text","Your friend list");
  define("ChFun_friend_to_text","List of users witch added you to the their friend list");
  define("ChFun_friend_Eempty","Your friend list is empty");
  define("ChFun_friend_Add", "User \"#user#\" was added to your friend list.");
  define("ChFun_friend_Del", "User \"#user#\" was deleted from your friend list.");
########################## friend ###########################
  
//------------------------ ignore ---------------------------
  define("ChFun_ignore_Add", "User \"#user#\" was added to your ignore list.");
  define("ChFun_ignore_Del", "User \"#user#\" was deleted from your ignore list.");
 
  define("ERROR_ignore_msg_from", "This user ignors your private messages.");
  define("ERROR_ignore_msg_to", "You ignore this user.");
########################## ignore ###########################
 
//------------------------ configroom -----------------------
  /* napis w select-ie ktory mowi ktory pokoj jest wybrany jako ten do ktorego uzytkownik zostanie zalogowany po starcei  */
  define("ChFun_croom_Default"," (Default)"); // mozna zmieniac
  /* Tekst pojawiajacy sie przy zmianie defaultowego pokoju */
  define("ChFun_croom_TxtNoRoomSelDef", "Select room witch should be set as default.");
  define("ChFun_croom_DefaultChanged", "Default room was changed.");
 
  /* informacja ze pokoj zostal usuniety */
  define("ChFun_croom_RoomDeleted", "Room deleted");
  define("ChFun_croom_TxtRc", "You didn't write category name.");
  define("ChFun_croom_TxtRn", "You didn't write room name.");
  define("ChFun_croom_TxtLRc", "Category name is too long. Max(#max_room_cat_name#)");  
  define("ChFun_croom_TxtLRn", "Room name is too long. Max(#max_room_name#)");  
  define("ChFun_croom_TxtExists", "Room with the name you typed allready exists. Please write different name.");
  define("ChFun_croom_RoomAdded", "Room changed.");
  define("ChFun_croom_TxtNoRoomSel", "Select room you want to delete.");
########################## configroom #######################
 
//------------------------ info -----------------------------
  define("ChFun_info_BadUserName", "User \"#user#\" doesn't exists.");
########################## info #############################
 
//------------------------ skin -----------------------------
  define("ChFun_skin_List", "#name# ");
  define("ChFun_skin_ListSep", ", ");
  define("ChFun_skin_UnParam" , "Unknown param \"#param#\"");
  define("ChFun_skin_CssChanged" , "Css changed to \"#css_name#\"");
  define("ChFun_skin_SkinChanged" , "Skin changed to \"#skin_name#\"");
  define("ChFun_skin_BadCss" , "Bad Css name");
  define("ChFun_skin_BadSkin" , "Bad Skin name");
########################## skin ############################
 
//------------------------ avatar --------------------------
  define("LTTpl_avatar_title", "Select avatara");
########################## avatar ##########################

//------------------------ configrooms ---------------------
  define("ChFun_configrooms_add", "Add room");
  define("ChFun_configrooms_cat_name", "Category name");
  define("ChFun_configrooms_room_name", "Room name");
  define("ChFun_configrooms_defined", "List of available rooms");
  define("ChFun_configrooms_submit", "Create room");
  define("ChFun_configrooms_delete", "Delete");
  define("ChFun_configrooms_default","Set as default");
########################## configrooms #####################

//------------------------ room ----------------------------
  define("ChFun_room_Changed", "Room changed to \"#room#\".");
  define("ChFun_room_BadName", "Bad Room Name");
########################## room ############################
 
############################################################
## COMMANDS
############################################################
 
////////////////////////////////////////////////////////////
// SHOUTBOX
////////////////////////////////////////////////////////////
  define("LTTpl_shoutbox_msg", "Message");
  define("LTTpl_shoutbox_nick", "Nick");
  define("LTTpl_shoutbox_submit", "Send");
############################################################
## SHOUTBOX
############################################################
 
// menu.tpl //////////////////////////////////////////////////
  define("ChMenuHelp","Help");
  define("ChMenuRules","Rules");
  define("ChMenuStatistics","Statistic data");
  define("ChMenuRegister","Register yourself");
  define("ChMenuLogin","Login");
##############################################################

// statistics.tpl
	 define("LTChat_statistics_rooms_txt","Rooms");
	 define("LTChat_statistics_online_txt","Users online");
	 define("LTChat_statistics_last_reg_txt","Last registered chatter");
	 define("LTChat_statistics_registered_txt","Registered users");
	 define("LTChat_statistics_prv_count_txt","Private messages count");
	 define("LTChat_statistics_msg_count_txt","Messages count");
	 define("LTChat_statistics_msg_sum","All messages count");
	 define("LTChat_statistics_nick_guest","Guest");


// registration_form.tpl
  define("LTTpl_user_added","User added."); 
  define("ChTPL_RegLogin", "User");
  define("ChTPL_RegPass", "Password");
  define("ChTPL_RegSub", "Send");
 
  define("ChTPL_RegErrLogTooShort", "The minimal number of signs required for login is #chars# .");
  define("ChTPL_RegErrPasTooShort", "The minimal number od signs required for password is #chars#.");
  define("ChTPL_RegErrUserBadNick", "Bad user name. You can use only signs: 0-9 a-Z and _.");
  define("ChTPL_RegErrUserExists", "This user allready exists.");
  define("ChTPL_RegErrFillAllFields", "Fill all required fields.");
  
//  command.tpl
  define("ChTPL_ENABLED", "Enabled");
  define("ChTPL_Disabled", "Disabled");

#####################
//  login_form.tpl
  define("ChTPL_LogLogin", "User");
  define("ChTPL_LogPass", "Password");
  define("ChTPL_LogSub", "Enter");
  define("ChTPL_LogGuest", "Guest login");
 
  define("ChFun_January", "January");
  define("ChFun_February", "February");
  define("ChFun_March", "March");
  define("ChFun_April", "April");
  define("ChFun_May", "May");
  define("ChFun_June", "June");
  define("ChFun_July", "July");
  define("ChFun_August", "August");
  define("ChFun_September", "September");
  define("ChFun_October", "October");
  define("ChFun_November", "November");
  define("ChFun_December", "December");
 
  
// komendy
  define("LTChatCOM_help_desc", "Displays help document.");
  define("LTChatCOM_help_param", "Command");
  define("LTChatCOM_fullhelp_desc", "Displays list of all available commands with informations about them.");
  define("LTChatCOM_bug_desc", "Send a bug report.");
  define("LTChatCOM_room_desc", "Changes the room.");
  define("LTChatCOM_room_param", "Room name");
  define("LTChatCOM_clear_desc", "Clears the current chat window.");
  define("LTChatCOM_ignore_desc_add", "Add a user to your ignore list. That user cannot send you private messages and you can not see messages they send.");
  define("LTChatCOM_ignore_desc_del", "Remove a user from your ignore list. That user can now send you private messages and you can see messages they send.");
  define("LTChatCOM_ignore_param", "Username");
  define("LTChatCOM_prv_desc", "Allows you to send private messages.");
  define("LTChatCOM_prv_param", "Username");
  define("LTChatCOM_removefriend_desc", "Removes a friend from your friend list.");
  define("LTChatCOM_removefriend_param", "Username");
  define("LTChatCOM_friend_desc_add", "Adds a friend from your friend list.");
  define("LTChatCOM_friend_desc_del", "Removes a friend from your friend list.");
  define("LTChatCOM_friend_desc_show", "Displays all users on your friend list.");
  define("LTChatCOM_url_desc", "Allows you to insert a URL into the chat.");
  define("LTChatCOM_url_param", "URL address");
  define("LTChatCOM_unignore_desc", "Remove a user from your ignore list. That user can now send you private messages and you can see messages they send.");
  define("LTChatCOM_unignore_param", "Username");
  define("LTChatCOM_kick_desc", "Kick a user from the system. You may specify an optional reason. This command can only be used by administrators or operators.");
  define("LTChatCOM_kick_param1", "Username");
  define("LTChatCOM_kick_param2", "Reason");
  define("LTChatCOM_me_desc", "Informations about user.");
  define("LTChatCOM_whoami_desc", "Displays user nick.");
  define("LTChatCOM_ping_param", "Host");
  define("LTChatCOM_ping_desc", "sending icmp_echo_request packages to network hosts.");
  define("LTChatCOM_logout_desc", "Chat exit.");
  define("LTChatCOM_configrooms_desc", "Rooms configuration.");
  define("LTChatCOM_skin_desc_setskin", "Sets skin for the chat");
  define("LTChatCOM_skin_desc_showskins", "Shows a list of available skins");
  define("LTChatCOM_skin_desc_setcss", "Sets  css for the chat");
  define("LTChatCOM_skin_desc_showcss", "Shows a list of available css");
  define("LTChatCOM_skin_param1", "skin_name");
  define("LTChatCOM_skin_param2", "css_name");
  define("LTChatCOM_whois_desc", "Displays information about the specified user.");
  define("LTChatCOM_whois_param", "Username");
  define("LTChatCOM_emoticons_desc", "List of available  emoticons.");
  define("LTChatCOM_config_desc", "Chat variables configuration");
  define("LTChatCOM_avatar_desc", "Selection of avatar for user.");
  define("LTChatCOM_configreg_desc", "Registration fields configuration.");

// komendy  

  define(LTTpl_me_reg_text, "Registered since");
  define(LTTpl_me_last_seen_text, "Last seen");
  define(LTTpl_me_posted_msg_text, "Posted messages");
  define(LTTpl_me_last_host_text, "Last Host");
  define(LTTpl_me_last_ip_text, "Last IP");

  

/////////////// MODYFIKOWALNE ZMIENNE ///////////////////
  define("LTChart_CONF_PERFORMANCE","Performance");
  define("LTChart_CONF_OTHER","Other chat configuration");

  define("_DESC_LTChart_offline_user_after", "Information about the time limit for a user to be offline if he/she doesn't respond (seconds).");
  define("_DESC_LTChart_delete_offline_data", "Time after which information that a user is offline gets removed from the chart (seconds).");
  define("_DESC_ChRefreshAfter", "Time after which the page is refeshed (miliseconds).");
  define("_DESC_ChDK_max_msg_get", "Maximum amount of chat messages a user can receive");
  define("_DESC_ChDK_max_SB_msg_get", "Maximum amount of shoutboxa messages a user can receive");
  define("_DESC_ChDK_max_msg_time_back", "When entering a room the user will not receive messages older than (amount) seconds");
  define("_DESC_ChDK_max_msg_on_enter", "The amount of old messages for a user when entering a room");
  define("_DESC_ChDK_max_SB_msg_on_enter", "The amount of old messages for a user when entering a shoutboxa");
  define("_DESC_LTChatCore_user_min_login_chars", "Minimum number of signs allowed with login");
  define("_DESC_LTChatCore_user_min_password_chars", "Minimum number of signs allowed with password");
  define("_DESC_ChDK_delete_free_avatar_after", "User's avatar is deleted if the user doesn't log in longer than (seconds).");
  define("_DESC_ChDK_delete_guest_after", "Guest's account is deleted after (seconds).");
  define("_DESC_ChDK_delete_user_after", "User is deleted if he/she doesn't log in longer than (seconds).");
  define("_DESC_LTChatCore_guest_account", "Is log in to guest account allowed?");
  define("_DESC_LTChat_md5_passwords", "Encode password with the function md5");
?>