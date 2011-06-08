<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
// zalozenie baz danych
// skrypt do wysylania xmla
// parsowanie xmla i wstawianie
// wysylanie wiadomosci  
  class LTChatCore
  {
  	 var $LTChatDataKeeper;
  	 var $LTChatCoreFunctions;

/* lista slow ktore nie mozna uzywac przy czacie */
  	 var $stop_words;
  	 var $stop_words_loaded = false;
/* miesiace napisane w odpowiednim jezyku */
  	 var $months;
/*
// wartosci zdefiniowane w chacie przez uzytkownika 
     var $LTChatConfig;
     var $LTChatConfig_loaded = false;
*/  	 

  	 function LTChatCore()
  	 {
       $this->LTChatDataKeeper = new LTChatDataKeeper();
       $this->LTChatDataKeeper->initialize();
       $GLOBALS['LTChatConfig'] = $this->LTChatDataKeeper->get_chat_variables();

       
       if(!file_exists(LTChart_path."/lang/".get_ConfVar("LTChatLanguage")."/LTChatLnagConfig.inc.php"))	define("LTChatLanguage", "english");
       else																									define("LTChatLanguage", get_ConfVar("LTChatLanguage"));

//     glowny config jezykow
 	   include_once(LTChart_path."/lang/".LTChatLanguage."/LTChatLnagConfig.inc.php");
// 	   tablica z jezykami 
 	   include_once(LTChart_path."/include/LTChatLangArray.inc.php"); 	   

 	   if(get_ConfVar("LTChatTemplateName") == null)	define("LTChatTemplateName", "standard");
       else												define("LTChatTemplateName", get_ConfVar("LTChatTemplateName"));         

	   // link do templateu uzywanego przez silnik
       define("LTChatTemplateSystemPath",LTChart_path."/templates/".LTChatTemplateName."/");
	   // link do templateu uzywanego ( ten link jest wykozystywany na stronie)
	   define("LTChatTemplatePath","./templates/".LTChatTemplateName."/");

	   // link do css dla shoutboxa
	   
 	   if(get_ConfVar("LTTpl_css_link") == null)	define("LTTpl_css_link", LTChatTemplatePath."css/default.css");
       else											define("LTTpl_css_link", get_ConfVar("LTTpl_css_link"));

//       debug(LTTpl_css_link);
  //     define("LTTpl_css_link", "http://localhost/~chat/templates/standard/css/shoutbox/phBlue4.css");

       include_once(LTChatTemplateSystemPath."/LTChatTplConfig.inc.php"); 	   

       $this->months = $GLOBALS['language_config']['months'];
  	   if(!is_array($this->months))
  	     $this->months = array();

  	   
       $this->LTChatCoreFunctions = new LTChatCoreFunctions($this->LTChatDataKeeper);
 	   $this->LTChatCoreFunctions->set_language_config($GLOBALS['language_config']);
  	 }

  	 function set_chat_variable($variables)
  	 {
  	   if($_SESSION['LTChart_user_rights'] != "Admin")
  	     return;

	   foreach ($variables as $v_name => $value);
  	   {
  	     foreach ($GLOBALS['ConfigVarsInfo'] as $var_name => $info)
  	   	   if($var_name == $v_name)
  	   	     break;
  	   	 if($var_name != $v_name)
  	   	 {
  	   	 	unset($variables[$v_name]);
  	   	 }
  	   	 else 
  	   	 {
  	   	   if($info['type'] == "int" && $value == "".intval($value))
  	   	   {
  	         $this->LTChatDataKeeper->set_chat_variable($var_name, $value);
  	         $GLOBALS['LTChatConfig'][$var_name] = $value;
  	   	   }
  	   	   if($info['type'] == "boolean" && $value == "0" || $value == "1")
  	   	   {
  	         $this->LTChatDataKeeper->set_chat_variable($var_name, $value);
  	         $GLOBALS['LTChatConfig'][$var_name] = $value;
  	   	   }
  	   	 }
  	   }
  	 }

  	 function load_stop_words()
  	 {
  	   if($this->stop_words_loaded) return;

  	   // load emoticons //
  	   if(file_exists(LTChatTemplateSystemPath."tpl_emoticons.txt"))
  	   {
		  $tpl_emoticons = file(LTChatTemplateSystemPath."tpl_emoticons.txt");
		  foreach ($tpl_emoticons as $line)
		  {
		  	$lines = explode("\t",$line);
		  	if(count($lines) <2) continue;

		  	$from = htmlspecialchars($lines[0]);
		  	$this->stop_words[$from] = str_replace("#path#",LTChatTemplatePath."img/emoticons/".$lines[count($lines)-1],LTChat_emotStyle);
		  }
  	   }
  	   
  	   if(file_exists(LTChart_path."/lang/".LTChatLanguage."/stop_words.txt"))
  	   {
		  $f_stop_words = file(LTChart_path."/lang/".LTChatLanguage."/stop_words.txt");
		  foreach ($f_stop_words as $line)
		  {
		  	$lines = explode("\t",$line);
		  	if(count($lines) <2) continue;

		  	$from = htmlspecialchars($lines[0]);
		  	$this->stop_words[$from] = $lines[count($lines)-1];
		  }
  	   }
  	 }
  	 
  	 function set_avatar($f_path)
  	 {
  	   $list = $this->LTChatDataKeeper->get_avatars_list();
  	   if(is_array($list))
  	     foreach ($list as $file_path => $f_name)
  	   	   if($f_path == $file_path)
  	   	     return false;

  	   $ex = explode("/", str_replace("\\","/",$f_path));
  	   if($ex[0] == "." && $ex[1] == "img" && $ex[2] == "avatars" && !isset($ex[4]) && file_exists($f_path))
  	     $this->LTChatDataKeeper->set_avatar($f_path);
  	 }

  	 function login_user()
  	 {
  	   if($_POST['guest'] == 'on')  $guest = 1;
  	   else 						$guest = 0;

  	   
  	   if($guest == 1 && is_object($this->LTChatDataKeeper->get_user_by_nick(stripslashes($_POST['login']))))
  	   	 return ChCore_guest_user_exists;
  	   
  	   if($guest == 1)
  	   {
	  	   if(eregi("([a-zA-Z0-9_])*",$_POST['login'],$res))
	  	   {
	  	   	 if(strlen($res[0]) != strlen($_POST['login']))
	  	       return ChTPL_RegErrUserBadNick;
	  	   }
	  	   else
	  	     return ChTPL_RegErrUserBadNick;
  	   }
  	   

  	   $info = $this->LTChatDataKeeper->login_user(stripslashes($_POST['login']), stripslashes($_POST['password']), $guest);

  	   if($info === true)  return;
  	   elseif(isset($info['error']) && $info['error'] === ChDK_log_err_bad_password)
  	   {
		 return ChCore_login_err_bad_pass;
  	   }
  	   elseif(isset($info['error']) && $info['error'] === ChDK_log_err_bad_login)
  	   {
  	     return ChCore_login_err_bad_login;
  	   }
  	   elseif(isset($info['error']) && $info['error'] === ChDK_log_err_banned)
	   {
	   	 if($info['reason'] == "")
	   	   return str_replace(array("#user#"), array($_POST['login']), ChFun_kick_Ok);
	   	 else
	   	   return str_replace(array("#user#", "#reason#"), array($_POST['login'], $info['reason']), ChFun_kick_OkReason);
	   }
  	 }
  	 
  	 function user_logged_in()
  	 {
  	 	return $this->LTChatDataKeeper->user_logged_in();
  	 }
  	 
  	 function get_registration_fields()
  	 {
		return $this->LTChatDataKeeper->get_registration_fields();
  	 }
  	 
  	 function update_other_fields($other_options)
  	 {
  	   $fields = $this->get_registration_fields();
  	   $to_update = array();

  	   foreach ($fields as $field)
  	   {
  	     if($field->required == 1 && $other_options["form{$field->id}"] == null)
  	       return LTChatCore_user_error_fill_required;

  	     if($field->var_type == 'integer' && $other_options["form{$field->id}"] != "".intval($other_options["form{$field->id}"]))
  	        return LTChatCore_user_error_bad_type;
  	     
  	     $to_update[$field->id] = stripslashes($other_options["form{$field->id}"]);
  	   }

  	   $this->LTChatDataKeeper->update_other_fields($to_update);
  	   return true;
  	 }

  	 function add_user($other_options)
  	 {
  	   if(!isset($_POST['login'])) return false;
  	   
  	   $_POST['login'] = stripslashes($_POST['login']);
  	   $_POST['password'] = stripslashes($_POST['password']);

  	   if(strlen($_POST['login']) < LTChatCore_user_min_login_charss)		return LTChatCore_user_error_too_short_login;
  	   if(strlen($_POST['password']) < LTChatCore_user_min_password_chars)	return LTChatCore_user_error_too_short_password;
  	   
  	   if(eregi("([a-zA-Z0-9_])*",$_POST['login'],$res))
  	   {
  	   	 if(strlen($res[0]) != strlen($_POST['login']))
  	       return LTChatCore_user_error_nick;
  	   }
  	   else 
  	     return LTChatCore_user_error_nick;


  	   if(is_array($other_options))
	     foreach ($other_options as $ot_id => $ot_ar)
	       if($ot_ar['required'] == 1 && $ot_ar['value'] == null)
			return LTChatCore_user_error_fill_required;

  	   if($this->LTChatDataKeeper->add_user($_POST['login'], $_POST['password'], $other_options) == false)
  	     return LTChatCore_user_errro_user_exists;
  	   else
  	     return true;
  	 }
  	 
  	 function del_reg_field($id)
  	 {
       if($this->LTChatDataKeeper->get_user_rights() != "Admin") return false;

       $id = (int)$id;

       $this->LTChatDataKeeper->del_reg_field($id);
  	 }

  	 function add_reg_field($post)
  	 {
       if($this->LTChatDataKeeper->get_user_rights() != "Admin") return false;

       foreach ($_POST as $k => $v)
         $_POST[$k] = htmlspecialchars(stripslashes($v));

       if($_POST['required'] == "on")	$required = 1;
       else								$required = 0;

       $this->LTChatDataKeeper->add_reg_field($_POST['f_name'], $_POST['item'], $required, (int)$_POST['lenght'], trim($_POST['options'],"|"));
  	 }

  	 function user_action($room)
  	 {
  	   return $this->LTChatDataKeeper->user_action($room);
  	 }
  	 
  	 function command_tpl_params($template_name)
     {
	   $help = $GLOBALS['language_config']['help'];
	   foreach ($help as $commands)
	   {
	     if($commands['load_template'] == $template_name && is_callable(array(get_class($this->LTChatCoreFunctions),$commands['execute_tpl_function'])))
		   return call_user_func(array($this->LTChatCoreFunctions,$commands['execute_tpl_function']));
	   }
	   return array();
     }

     function post_shoutbox_msg($text, $login, $shoutbox_id)
     {
	   $this->LTChatDataKeeper->post_shoutbox_msg($text, $login, (int)$shoutbox_id);
     }

  	 // w tym miejscu dorobic wywalanie uzytkownika jezeli jest odpowiedni post
     function post_msg($text, $room, $private_id)
     {
       if($this->user_logged_in())
       {
       	 if($private_id < 0)
	       $this->LTChatDataKeeper->post_msg($text, $room);
	     else
	       $this->LTChatDataKeeper->post_private_msg($text, $private_id, false);
       }
     }
     
     function xml_encode_characters($data)
     {
       return str_replace(array("#", "&", "*" , "<", ">"),array("#hash#", "#and#", "#star#", "#pale_open#","#pale_close#"), $data);
     }
     
     function get_user_name()
     {
       return $this->LTChatDataKeeper->get_user_name();
     }
     
     function get_user_by_nick($nick)
     {
       return $this->LTChatDataKeeper->get_user_by_nick($nick);
     }
     
	 function msg_to_xml($data_type, $result, $room, $lastid, $private_id)
	 {
	   $months = $this->months;

       $room = addslashes($room);
       $lastid = (int)$lastid;

       $counter = count($result);

       if(is_array($result))
         foreach ($result as $row)
         {
           $other_options = "";

           if($data_type == 'shoutbox_msg')
      	     $row->user = htmlspecialchars($row->user);

       	   $row->user = $this->xml_encode_characters($row->user);

       	   $row->hour = date("G",$row->time);
		   $row->minute = date("i",$row->time);
		   $row->second = date("s",$row->time);

		   $row->time = strtr(date("Y-F-d H:m:s",$row->time),$months);

           if($row->text[0] == '/' && $data_type != 'shoutbox_msg')
           {
           	 $is_command = "true";

           	 $command = $this->LTChatCoreFunctions->command($row, $room, $private_id);
           	 if(is_array($command['other_options']))
           	 foreach($command['other_options'] as $option_name => $option_value)
           	   $other_options .= str_replace(array("#value#","#option#"),array($option_value, $option_name),LTChart_xml_data_more_options);

           	 if(isset($command['data_type']))
           	   $data_type = $command['data_type'];

           	 if($command['type'] == 'private' && $row->user == $this->LTChatDataKeeper->get_user_name())
           	   $row->text = $command['text'];
           	 elseif($command['type'] == 'public')
           	   $row->text = $command['text'];
           	 elseif($command['type'] == 'skip')
           	   continue;
           	 else
           	   continue;

           	 $row->text = $this->xml_encode_characters($row->text);
           	 if($command['type'] == 'public')
           	   $is_command = "false";
           }
           else
           {
           	 $is_command = "false";
       	     $row->text = htmlspecialchars($row->text);
       	     $this->load_stop_words();
             $row->text = strtr($row->text, $this->stop_words);
       	     $row->text = $this->xml_encode_characters($row->text);
           }

       	   $data_array[$counter] = str_replace(array("#other_options#","#user#","#user_id#","#time#", "#hour#","#minute#","#second#","#text#","#id#","#is_command#","#LTChatTemplatePath#","#data_type#"),
         									   array($other_options, $row->user,$row->user_id, $row->time, $row->hour, $row->minute, $row->second, $row->text, $row->id, $is_command, LTChatTemplatePath, $data_type), LTChart_message_xml_data);

           $counter--;
	    }

	   for($i = 1;$i <= count($result); $i++)
	     $data_out .= $data_array[$i];
	
	   return $data_out;
	 }

	 function get_all_rooms()
	 {
  	   return array('rooms' => $this->LTChatDataKeeper->get_all_rooms());
	 }
	 
	 function get_statistics()
	 {
	   $info = $this->LTChatDataKeeper->get_all_rooms();
	   $stats = $this->LTChatDataKeeper->get_statistics();
	 
	   $users_online = array();
	   foreach ($info as $room_cats)
	     foreach ($room_cats as $room)
	 	   if(is_array($room->users_online))
	 	     foreach ($room->users_online as $user)
	 	       $users_online[$user['nick']]['nick'] = $user['nick'];
	 	       
  	   return array('rooms' => $info, 'online' => $users_online, 'stats' => $stats);
	 }
	 
	 
     function enter_room($room)
     {
       $this->LTChatDataKeeper->enter_room($room);
     }

     function get_users_list_xml_elements($room, $who_id, $private = false, $user_id = -1)
     {
       if($private)
	     $users_list = $this->LTChatDataKeeper->get_users_list_from_array(array($user_id,$_SESSION['LTChart_user_id']));
       else
	     $users_list = $this->LTChatDataKeeper->get_users_list($room, $who_id);

       if(is_array($users_list))
       {
       	 $friends_list = array();
	     if($who_id == 0)
	     {
	       $friends_list = $this->LTChatDataKeeper->get_friend_list();
	     }

	     if(is_array($users_list))
	       foreach ($users_list as $u_key => $user)
	       {
	         $users_list[$u_key]->action = true;
	         if(is_array($friends_list['from']))
	           foreach ($friends_list['from'] as $f_key => $friend)
	             if($friend->users_id == $user->users_id)
	             {
	               $users_list[$u_key]->friend = true;
	               unset($friends_list['from'][$f_key]);
	               break;
	             }
	       }

		 if(is_array($friends_list['from']))
	       foreach ($friends_list['from'] as $f_key => $friend)
	       {
	         $friend->action = false;
	         $friend->friend = true;
	         $friend->online = false;
	         $users_list[] = $friend;
	       }

	     foreach ($users_list as $user)
	     {
	       $options = "";
	       foreach ($user as $key => $item)
	       {
		     $item = htmlspecialchars($item);
       	     $item = $this->xml_encode_characters($item);
	         $options .= str_replace(array("#value#","#option#"),array($item, $key),LTChart_xml_data_more_options);
	       }
	       $options .= str_replace(array("#value#","#option#"),array(time(),"time_stamp"),LTChart_xml_data_more_options);

	       $data_out .= str_replace("#options#", $options,LTChart_user_xml_data);
	     }
       }
	   return $data_out;
     }

     function get_my_new_private_messages_xml_elements($last_id)
     {
       $refresh_counter = 10;
       while($refresh_counter-- != 0)
       {
	     if(($message_list = $this->LTChatDataKeeper->get_my_new_private_messages($last_id)) != null) break;
	     break;
         sleep(1);
       }

       return $this->msg_to_xml('private_msg',$message_list, null, 0, 1);
     }

     function get_msg_xml_elements($room, $lastid, $private_id = -1)
     {
   	   if($private_id < 0)
   	     $result = $this->LTChatDataKeeper->get_msg_elements($room, $lastid);
   	   else
   	     $result = $this->LTChatDataKeeper->get_prv_msg_elements($lastid, $private_id);

       return $this->msg_to_xml('msg',$result, $room, $lastid, $private_id);
     }

     function get_all_private_xml_data($private_id, $prv_msg_last_id,  $user_status_last_id)
     {
	   if(!$this->user_logged_in())  return false;

	   if($room != '')
		 $this->LTChatDataKeeper->user_action($room);

	   $data_out = $this->get_msg_xml_elements(null, $prv_msg_last_id, $private_id);
	   if($prv_msg_last_id == 0)
	   	 if($data_out != null)
	       $data_out = $this->get_users_list_xml_elements($room, $user_status_last_id, true, $private_id).$data_out;

	   return str_replace("#data#", $data_out, LTChart_message_xml_header);
     }
     
     function get_all_xml_data($room, $private_id, $msg_last_id, $prv_msg_last_id, $user_status_last_id)
     {
	   if(!$this->user_logged_in())  return false;

	   if($room != '')
	   {
	     $this->LTChatDataKeeper->user_action($room);
	   }

	   $data_out  = $this->get_msg_xml_elements($room, $msg_last_id, $private_id);
	   $data_out .= $this->get_my_new_private_messages_xml_elements($prv_msg_last_id);
	   $data_out .= $this->get_users_list_xml_elements($room, $user_status_last_id);

	   return str_replace("#data#", $data_out, LTChart_message_xml_header);
     }

     // ------------------------ soutbox functions ------------------------------
     function get_shoutbox_xml_elements($sbox_id, $msg_last_id)
     {
       $result = $this->LTChatDataKeeper->get_shoutbox_elements($sbox_id, $msg_last_id);
       return $this->msg_to_xml('shoutbox_msg', $result, $room, $lastid, $private_id);     
     }
     
     function get_shoutbox_xml_data($sbox_id, $msg_last_id)
     {
	   $data_out  = $this->get_shoutbox_xml_elements($sbox_id, $msg_last_id);
	   return str_replace("#data#", $data_out, LTChart_message_xml_header);
     }
     // ------------------------ soutbox functions ------------------------------
     function set_default_room($room_id)
     {
       if($room_id == "")
         return ChFun_croom_ErrNoRoomSel;
       else 
         return $this->LTChatDataKeeper->set_default_room($room_id);
     }
     function delete_room($room_id)
     {
       if($room_id == "")
         return ChFun_croom_ErrNoRoomSel;
       else 
         return $this->LTChatDataKeeper->delete_room($room_id);
     }

     function add_room($data)
     {
       if($this->LTChatDataKeeper->get_user_rights() != "Admin") return false;
     	
       $room_cat = stripslashes($data['rooom_cat']);
       $room_name = stripslashes($data['rooom_name']);
	   if($room_cat == "")  return ChFun_croom_ErrNoCat;
	   elseif ($room_name == "")  return ChFun_croom_ErrNoRoom;
	   elseif (strlen($room_cat) > LTChat_MaxRoomCatName) return ChFun_croom_ErrLenCat;
	   elseif (strlen($room_name) > LTChat_MaxRoomName) return ChFun_croom_ErrLenRoom;
	   else return $this->LTChatDataKeeper->add_room($room_name, $room_cat);
     }
  }
?>