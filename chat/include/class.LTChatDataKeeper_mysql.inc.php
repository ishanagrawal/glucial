<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
 class LTChatDataKeeper
 {   
   function initialize()
   {
   	 session_start();

   	 $db_host = LTChat_Main_dbhost;
     $db_user = LTChat_Main_dbuser;
     $db_password = LTChat_Main_dbpassword;
     $db_name = LTChat_Main_dbname;

	 $link = mysql_connect($db_host,$db_user,$db_password) or die(mysql_error());
	 mysql_select_db($db_name) or die(mysql_error());   
   }
   //---------------------------------------------------

   function set_chat_variable($var_name, $var_value)
   {
     $var_name = addslashes($var_name);
     $var_value = addslashes($var_value);
     mysql_query("delete from ".LTChat_Main_prefix."chat_config where var_name = '{$var_name}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
     mysql_query("insert into ".LTChat_Main_prefix."chat_config(var_name, var_value, chat_id) values ('{$var_name}', '{$var_value}','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }
   
   function get_chat_variables()
   {
   	  $out = array();
      $result = mysql_query("select * from ".LTChat_Main_prefix."chat_config where chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

      while ($row = mysql_fetch_object($result))
      	$out[$row->var_name] = $row->var_value;

	  return $out;
   }
   //---------------------------------------------------

   function user_logged_in()
   {
       if($_SESSION['LTChart_user_id'] != null && $_SESSION['LTChart_user_nick'] != null)
         return true;
  	   else
  	     return false;
   }
   
   function get_statistics()
   {
   	 $stats = array();
   	 $stats['registered_users'] = 0;
   	 $result = mysql_query("select count(id) as users from ".LTChat_Main_prefix."users where kicked != '1' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   	 if($row = mysql_fetch_object($result))
   	   $stats['registered_users'] = $row->users;

   	 $result = mysql_query("select * from ".LTChat_Main_prefix."users where kicked != '1' and chat_id = '".LTChat_Main_CHAT_ID."' order by id desc limit 0,1") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   	 if($row = mysql_fetch_object($result))
   	   $stats['last_registered'] = $row;

   	 $result = mysql_query("select count(id) as suma from ".LTChat_Main_prefix."private_talk where chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   	 if($row = mysql_fetch_object($result))
   	   $stats['private_messages_count'] = $row->suma;

   	 $result = mysql_query("select count(id) as suma from  ".LTChat_Main_prefix."talk where chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   	 if($row = mysql_fetch_object($result))
   	   $stats['messages_count'] = $row->suma;

   	 return $stats;
   }

   function delete_user($id)
   {
	  	mysql_query("delete from ".LTChat_Main_prefix."ignore where (from_users_id = '{$id}' or to_users_id = '{$id}') and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	  	mysql_query("delete from ".LTChat_Main_prefix."friends where (from_users_id = '{$id}' or to_users_id = '{$id}') and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	  	mysql_query("delete from ".LTChat_Main_prefix."users_var where ".LTChat_Main_prefix."users_id = '{$id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	  	mysql_query("delete from ".LTChat_Main_prefix."users where id = '{$id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }

   function login_user($login, $password, $guest)
   {       

   	   $hostname = addslashes(gethostbyaddr($_SERVER['REMOTE_ADDR']));
  	   $login = addslashes($login);

  	   if($guest == 1)
  	   {
  	   	 $password = rand(0,12345678);
  	   	 $this->add_user($login, $password, array(), $guest);
  	   }

	   $result = mysql_query("select * from ".LTChat_Main_prefix."users where nick = '{$login}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	   $time = time();

	   if($row = mysql_fetch_object($result))
	   {
	   	  if($password != $row->password && md5($password) != $row->password)
	   	    return array('error' => ChDK_log_err_bad_password);

	   	  if($row->reason != "")
	   	    return array('error' => ChDK_log_err_banned, 'reason' => $row->reason);

		  $_SESSION['LTChart_user_id'] = $row->id;
		  $_SESSION['LTChart_user_nick'] = $row->nick;
		  $_SESSION['LTChart_user_rights'] = $row->rights;
   	      mysql_query("update ".LTChat_Main_prefix."users set last_seen = '".time()."', last_host = '{$hostname}', last_ip = '{$_SERVER['REMOTE_ADDR']}' where id = '{$_SESSION['LTChart_user_id']}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

   	      // usuniecie niepotrzebnych smieci 
		  $result = mysql_query("select * from ".LTChat_Main_prefix."users where (( rights = 'Standard' and last_seen < ".time()." - ".get_ConfVar("ChDK_delete_user_after").") or 
		  													  ( rights = 'Guest' and last_seen <".time()." - ".get_ConfVar("ChDK_delete_guest_after").")) and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

		  while ($row_u = mysql_fetch_object($result))
		  	$this->delete_user($row_u->id);

		  mysql_query("update ".LTChat_Main_prefix."users set picture_url = '' where rights = 'Standard' and last_seen < ".time()." - ".ChDK_delete_free_avatar_after." and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
		  return true;
	   }
	   
	   return array('error' => ChDK_log_err_bad_login);
   }

   function add_user($login, $password, $other_options = array(), $guest = 0)
   {
  	   $login = addslashes($login);

  	   if((boolean)get_ConfVar("LTChat_md5_passwords"))  $password = md5($password);
  	     
  	   $password = addslashes($password);
  	   
  	   $rights = "Standard";
  	   if($guest == 1)
  	     $rights = "Guest";

	   mysql_query("insert into ".LTChat_Main_prefix."users(nick,password,last_seen, rights,chat_id) values ('{$login}', '{$password}','".time()."','{$rights}','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

	   if(mysql_affected_rows() == -1)
	     return false;
	   else
	   {
	     $result = mysql_query("select * from ".LTChat_Main_prefix."users where nick = '{$login}' and password = '{$password}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
		 if($user = mysql_fetch_object($result))
		 {
		   if(is_array($other_options))
		     foreach ($other_options as $ot_id => $ot_ar)
		     {
		       $value = addslashes($ot_ar['value']);
		       mysql_query("INSERT INTO `".LTChat_Main_prefix."users_var` (`".LTChat_Main_prefix."users_var_names_id` , `".LTChat_Main_prefix."users_id` , `value`, chat_id) VALUES ('{$ot_id}', '{$user->id}', '{$value}','".LTChat_Main_CHAT_ID."');") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
		     }
		 }
		 else 
		   return false;
	   	 
	     return true;
	   }
   }
   
   function update_other_fields($to_update)
   {
   	 foreach ($to_update as $id => $value)
   	 {
   	   $value = addslashes($value);
	   mysql_query("delete from `".LTChat_Main_prefix."users_var` where ".LTChat_Main_prefix."users_var_names_id = '{$id}' and ".LTChat_Main_prefix."users_id = '{$_SESSION['LTChart_user_id']}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	   mysql_query("INSERT INTO `".LTChat_Main_prefix."users_var` (`".LTChat_Main_prefix."users_var_names_id` , `".LTChat_Main_prefix."users_id` , `value`, chat_id ) VALUES ('{$id}', '{$_SESSION['LTChart_user_id']}', '{$value}','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   	 }
   }

   function enter_room($room)
   {
     $time = time();
  	 mysql_query("delete from `".LTChat_Main_prefix."who_is_online` where `users_id` = '{$_SESSION['LTChart_user_id']}' and room = '{$room}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	 mysql_query("insert into ".LTChat_Main_prefix."who_is_online(action_time, users_id, room, online,chat_id) values  ('{$time}', '{$_SESSION['LTChart_user_id']}','{$room}','1','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }

   function delete_offline_users()
   {
  	 $time = time();
  	 // usuniecie uzytkownikow ktorzy wyszli z chata

  	 $result = mysql_query("select * from ".LTChat_Main_prefix."who_is_online where online = '1' and action_time < {$time}-".get_ConfVar("LTChart_offline_user_after")." and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	 while ($row = mysql_fetch_object($result))
  	 {
	   mysql_query("delete from ".LTChat_Main_prefix."who_is_online where who_id = '{$row->who_id}' and room = '{$row->room}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	   mysql_query("insert into ".LTChat_Main_prefix."who_is_online(action_time, users_id, room, online, chat_id) values  ('{$time}', '{$row->users_id}','{$row->room}','0','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	 }
   }
   
   function user_action($room)
   {
   	 $room = addslashes($room);
  	 $time = time();
  	 if($this->user_logged_in())
  	 {
   	   mysql_query("update ".LTChat_Main_prefix."users set last_seen = '".time()."' where id = '{$_SESSION['LTChart_user_id']}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   	   
   	   $this->delete_offline_users();
  
  	   $result = mysql_query("select * from `".LTChat_Main_prefix."who_is_online` where `users_id` = '{$_SESSION['LTChart_user_id']}' and `room` = '{$room}' and chat_id = '".LTChat_Main_CHAT_ID."' order by who_id asc") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	   if($row = mysql_fetch_object($result))
  	   {
  	   	  if($row->online == '0')
  	   	  {
  	   	  	mysql_query("delete from ".LTChat_Main_prefix."who_is_online where  users_id = '{$_SESSION['LTChart_user_id']}' and room = '{$row->room}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	        mysql_query("insert into ".LTChat_Main_prefix."who_is_online(action_time, users_id, room, online, chat_id) values  ('{$time}', '{$_SESSION['LTChart_user_id']}','{$room}','1','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	   	  }
  	   	  else
  	   	  {
  	   	    mysql_query("update ".LTChat_Main_prefix."who_is_online set action_time  = '{$time}', online = '1' where who_id = '{$row->who_id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	   	  }
  	   }
  	   else
  	   {
	     mysql_query("delete from ".LTChat_Main_prefix."who_is_online where who_id = '{$row->who_id}' and room = '{$row->room}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	     mysql_query("insert into ".LTChat_Main_prefix."who_is_online(action_time, users_id, room, online, chat_id) values  ('{$time}', '{$_SESSION['LTChart_user_id']}','{$room}','1','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
  	   }

  	   mysql_query("delete from ".LTChat_Main_prefix."who_is_online where action_time < {$time}-".get_ConfVar("LTChart_delete_offline_data")." and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	   return true;
  	 }
  	 else 
  	   return false;
   }
   
   function get_my_new_private_messages($last_id)
   {
   	 $result = mysql_query("SELECT U.nick as user, U.id as user_id, PT.id, PT.users_id_from, PT.users_id_to, PT.text, PT.time, PT.delivered_from, PT.delivered_to FROM `".LTChat_Main_prefix."users` U , `".LTChat_Main_prefix."private_talk` PT WHERE PT.users_id_from = U.id and PT.users_id_to = '{$_SESSION['LTChart_user_id']}' and PT.id > '{$last_id}'  and delivered_from = '1' and delivered_to = '0' and time + 10 < ".time()." and PT.chat_id = '".LTChat_Main_CHAT_ID."' and U.chat_id = '".LTChat_Main_CHAT_ID."' order by id desc") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

     while ($row = mysql_fetch_object($result))
       $out[] = $row;

     return $out;
   }

   function set_avatar($file_path)
   {
     $file_path = addslashes($file_path);
     mysql_query("update ".LTChat_Main_prefix."users set picture_url = '{$file_path}' where id = '{$_SESSION['LTChart_user_id']}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	 mysql_query("delete from ".LTChat_Main_prefix."who_is_online where users_id = '{$_SESSION['LTChart_user_id']}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }
   
   function get_avatars_list()
   {
     $result = mysql_query("select nick, picture_url from ".LTChat_Main_prefix."users where picture_url <> '' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
     while ($row = mysql_fetch_array($result,MYSQL_ASSOC))
       $out[$row['picture_url']] = $row['nick'];

     return $out;
   }
   
   function get_user_by_nick($nick, $simple = false)
   {
   	 $nick = addslashes($nick);
     $result = mysql_query("select * from ".LTChat_Main_prefix."users where nick = '{$nick}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

     if($row = mysql_fetch_object($result))
     {
       if(!$simple)
       {
         $result = mysql_query("SELECT * FROM `".LTChat_Main_prefix."users_var` where ".LTChat_Main_prefix."users_id = '{$row->id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
         while ($res_vars = mysql_fetch_object($result))
           $row->other_fields[] = $res_vars;
       }
       return $row;
     }
     else
       return null;
   }
   
   function get_user_by_id($id, $simple = false)
   {
   	 $id = addslashes($id);
     $result = mysql_query("select * from ".LTChat_Main_prefix."users where id = '{$id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

     if($row = mysql_fetch_object($result))
     {
       if(!$simple)
       {
         $result = mysql_query("SELECT * FROM `".LTChat_Main_prefix."users_var` where ".LTChat_Main_prefix."users_id = '{$row->id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
         while ($res_vars = mysql_fetch_object($result))
           $row->other_fields[] = $res_vars;
       }
       return $row;
     }
     else
       return null;
   }
   
   // pobranie listy pol ktore uzytkownik wypelnia przy rejestracji
   function get_registration_fields()
   {
     $result = mysql_query("select * from ".LTChat_Main_prefix."users_var_names where chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
     
     while ($row = mysql_fetch_object($result))
		$out[] = $row;

     return $out;
   }
   
   function del_reg_field($id)
   {
   	 $result = mysql_query("select * from `".LTChat_Main_prefix."users_var_names` where id = '{$id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

   	 if($row = mysql_fetch_object($result))
   	 {
      mysql_query("delete from `".LTChat_Main_prefix."users_var_names` where id = '{$id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
      mysql_query("delete from `".LTChat_Main_prefix."users_var` where ".LTChat_Main_prefix."users_var_names_id  = '{$id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   	 }
   }

   function add_reg_field($f_name, $item, $required, $lenght, $options)
   {
   	 $f_name = addslashes($f_name);
   	 $item = addslashes($item);
   	 $lenght = addslashes($lenght);
   	 $options = addslashes($options);
   	 
   	 mysql_query("INSERT INTO `".LTChat_Main_prefix."users_var_names` ( `id` , `var_name` , `var_type` , `var_length` , `options` , `required`, chat_id ) VALUES ('', '{$f_name}', '{$item}', '{$lenght}', '{$options}' , '{$required}', '".LTChat_Main_CHAT_ID."');") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }
   
//------------ rooms ---------------------------------------------------
   function add_room($room_name, $room_cat)
   {
   	 $room_name = addslashes($room_name);
   	 $room_cat = addslashes($room_cat);
   	 $result = mysql_query("select * from ".LTChat_Main_prefix."rooms where room_name = '{$room_name}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

   	 if(mysql_num_rows($result) > 0)
   	   return ChFun_croom_ErrExists;
   	   
	 mysql_query("insert into ".LTChat_Main_prefix."rooms(room_name, room_cat, chat_id) values ('{$room_name}', '{$room_cat}', '".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	 return true;
   }

   function set_default_room($room_id)
   {
     mysql_query("update ".LTChat_Main_prefix."rooms set `default` = '0' where chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   	 $room_id = addslashes($room_id);
     mysql_query("update ".LTChat_Main_prefix."rooms set `default` = '1' where id = '{$room_id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }

   function delete_room($room_id)
   {
   	 $room_id = addslashes($room_id);
     mysql_query("delete from ".LTChat_Main_prefix."rooms where id = '{$room_id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }

   function kick_user($user_id, $reason)
   {
   	 $reason = addslashes($reason);
   	 $uesr_id = addslashes($uesr_id);

     mysql_query("update ".LTChat_Main_prefix."users set kicked = '1', reason = '{$reason}' where id='{$user_id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }

   function get_all_rooms()
   {
   	 $this->delete_offline_users();
   	 $undefined = $out = array();

     $result = mysql_query("select * from ".LTChat_Main_prefix."rooms where chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
     while ($row = mysql_fetch_object($result))
       $out[] = $row;

     $result = mysql_query("select ".LTChat_Main_prefix."users.id, nick, room from `".LTChat_Main_prefix."who_is_online`,`".LTChat_Main_prefix."users` where users_id = ".LTChat_Main_prefix."users.id and online = '1' and `".LTChat_Main_prefix."who_is_online`.`chat_id` = '".LTChat_Main_CHAT_ID."' and `".LTChat_Main_prefix."users`.`chat_id` = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
     while ($row = mysql_fetch_object($result))
     {
     	for($i = 0; $i < count($out); $i++)
     	{
     	  if($out[$i]->room_name == $row->room)
     	  {
     	    $out[$i]->users_online[] = array('nick' => $row->nick, 'id' => $row->id);
     	    break;
     	  }
     	}
     	if($out[$i]->room_name != $row->room)
     	  $undefined[$row->room][] = $row->nick;
     }


     return array('defined' => $out, 'undefined' => $undefined);
   }
############## rooms ###################################################

//----------------- friend ---------------------------------------------
   function friend_user_del($user_id)
   {
     mysql_query("delete from ".LTChat_Main_prefix."friends where from_users_id = '{$_SESSION['LTChart_user_id']}' and to_users_id = '{$user_id}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }

   function friend_user_add($user_id)
   {
     mysql_query("insert into ".LTChat_Main_prefix."friends(from_users_id, to_users_id, chat_id) values ('{$_SESSION['LTChart_user_id']}','{$user_id}','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }
   
   function get_friend_list()
   {
   	 $result = mysql_query("select U.id as users_id, U.nick, U.`picture_url` from ".LTChat_Main_prefix."users as U, ".LTChat_Main_prefix."friends as F where F.from_users_id = '{$_SESSION['LTChart_user_id']}' and F.to_users_id = U.id and F.chat_id = '".LTChat_Main_CHAT_ID."' and U.chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	 while($row = mysql_fetch_object($result))
	   $out['from'][] = $row;

	 $result = mysql_query("select U.nick, F.from_users_id from ".LTChat_Main_prefix."users as U, ".LTChat_Main_prefix."friends as F where F.to_users_id = '{$_SESSION['LTChart_user_id']}' and F.from_users_id = U.id and F.chat_id = '".LTChat_Main_CHAT_ID."' and U.chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	 while($row = mysql_fetch_object($result))
	   $out['to'][] = $row;

	 return $out;
   }
################### friend #############################################

//----------------- ignore ---------------------------------------------
   function ignore_user_del($user_id)
   {
     mysql_query("delete from ".LTChat_Main_prefix."ignore where from_users_id = '{$_SESSION['LTChart_user_id']}' and to_users_id = '{$user_id}'and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }

   function ignore_user_add($user_id)
   {
     mysql_query("insert into ".LTChat_Main_prefix."ignore(from_users_id, to_users_id, chat_id) values ('{$_SESSION['LTChart_user_id']}','{$user_id}','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }
################## ignore #############################################
   
   function post_shoutbox_msg($text, $login, $shoutbox_id)
   {
   	   $text = addslashes($text);
   	   $login = addslashes($login);
       mysql_query("INSERT INTO `".LTChat_Main_prefix."shoutbox` (text, nick, shout_id, chat_id) values ('{$text}', '{$login}', '{$shoutbox_id}','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }

   function post_private_msg($text, $private_id, $delivered)
   {
   	 mysql_query("update ".LTChat_Main_prefix."users set posted_msg = posted_msg + 1 where id = '{$_SESSION['LTChart_user_id']}'and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

   	 if($delivered)		$delivered = 1;
   	 else				$delivered = 0;

     $user = $_SESSION['LTChart_user_nick'];

     $room = addslashes($room);
     $user = addslashes($user);
     $text = addslashes($text);
	 $time = time();

	 if($private_id >= 0 && trim($text) != "")
	 {
	   $result = mysql_query("select * from ".LTChat_Main_prefix."ignore where ( from_users_id = '{$_SESSION['LTChart_user_id']}' and to_users_id = '{$private_id}' ) or (from_users_id = '{$private_id}' and to_users_id = '{$_SESSION['LTChart_user_id']}') and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	   if($row = mysql_fetch_object($result))
	   {
	   	 if($row->to_users_id == $_SESSION['LTChart_user_id'])	$text = "/ERROR ignore ".ERROR_ignore_from;
	   	 if($row->to_users_id == $private_id)					$text = "/ERROR ignore ".ERROR_ignore_to;
	   }

	   $insert_msg = "INSERT INTO `".LTChat_Main_prefix."private_talk` (`users_id_from` , `users_id_to` , `text` , `time`, `delivered_from`, chat_id) VALUES 
       											    ('{$_SESSION['LTChart_user_id']}','{$private_id}', '{$text}', '{$time}', '{$delivered}','".LTChat_Main_CHAT_ID."')";
       mysql_query($insert_msg) or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
       return $text;
	 }
	 else
     {
       return $text;
     }
   }

   function post_msg($text, $room)
   {
   	 mysql_query("update ".LTChat_Main_prefix."users set posted_msg = posted_msg + 1 where id = '{$_SESSION['LTChart_user_id']}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

     $user = $_SESSION['LTChart_user_nick'];
     $user = addslashes($user);
     $room = addslashes($room);
     $text = addslashes($text);
	 $time = time();

	 if(trim($text) != "")
     {
		mysql_query("INSERT INTO `".LTChat_Main_prefix."talk` (`user` , `room` , `text` , `time`, `chat_id`) VALUES ('{$user}','{$room}', '{$text}', '{$time}','".LTChat_Main_CHAT_ID."')") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
		return true;
     }
     else 
       return false;
   }

   function get_users_list_from_array($users)
   {
   	
	  $time = time();
   	  if(is_array($users))
   	  {
        foreach ($users as $id)
          $where .= " or O.users_id = '{$id}' ";
		
        $query_select = "SELECT `O`.`who_id` as id, `O`.`users_id`, `O`.`online`, `O`.`room`, `O`.`action_time`, U.`nick`,U.`picture_url`,U.`id` as user_id FROM `".LTChat_Main_prefix."who_is_online` O, `".LTChat_Main_prefix."users` U WHERE O.users_id = U.id and (1=2 {$where}) and `O`.`chat_id` = '".LTChat_Main_CHAT_ID."' and O.online = '1' and U.chat_id = '".LTChat_Main_CHAT_ID."' order by who_id asc";

		$result = mysql_query($query_select) or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	    while ($row = mysql_fetch_object($result))
	      $out[] = $row;
   	  }
	  return $out;
   }
   
   
   function get_users_list($room = NULL, $who_id = 0)
   {
   	 $time = time();

	 if($who_id == 0)	   $query_select = "SELECT `O`.`who_id` as id, `O`.`users_id`, `O`.`online`, `O`.`room`, `O`.`action_time`, U.`nick`,U.`picture_url`,U.`id` as user_id FROM `".LTChat_Main_prefix."who_is_online` O, `".LTChat_Main_prefix."users` U WHERE O.users_id = U.id and O.online = '1' and `O`.`room` = '{$room}' and `O`.`chat_id` = '".LTChat_Main_CHAT_ID."' and U.chat_id = '".LTChat_Main_CHAT_ID."' order by who_id asc";
	 else				   $query_select = "SELECT `O`.`who_id` as id, `O`.`users_id`, `O`.`online`, `O`.`room`, `O`.`action_time`, U.`nick`,U.`picture_url`,U.`id` as user_id FROM `".LTChat_Main_prefix."who_is_online` O, `".LTChat_Main_prefix."users` U WHERE O.users_id = U.id and O.who_id > '{$who_id}' and `O`.`room` = '{$room}' and `U`.`chat_id` = '".LTChat_Main_CHAT_ID."' and `O`.`chat_id` = '".LTChat_Main_CHAT_ID."' group by online order by who_id asc";

	 $result = mysql_query($query_select) or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
     while ($row = mysql_fetch_object($result))
       $out[] = $row;

     return $out;
   }
   
   function get_shoutbox_elements($sbox_id,  $lastid)
   {
   	 if($lastid == 0)  $limit = get_ConfVar("ChDK_max_SB_msg_on_enter");
   	 else 			   $limit = get_ConfVar("ChDK_max_SB_msg_get");

	 $result = mysql_query("select *,".LTChat_Main_prefix."shoutbox.nick as user from ".LTChat_Main_prefix."shoutbox where shout_id = '{$sbox_id}' and id > '{$lastid}' and chat_id = '".LTChat_Main_CHAT_ID."' order by id desc limit 0, {$limit}") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	 while ($row = mysql_fetch_object($result))
	   $out[] = $row;

	 return $out;
   }
   
   function get_msg_elements($room, $lastid)
   {
   	 if($lastid == 0)
   	 {
   	 	$time_back = " and time > ".time()."-".get_ConfVar("ChDK_max_msg_time_back");
   	 	$limit = get_ConfVar("ChDK_max_msg_on_enter");
   	 }
   	 else
   	   $limit = get_ConfVar("ChDK_max_msg_get");
	 
	 $result = mysql_query("select * from ".LTChat_Main_prefix."talk where room = '{$room}' and chat_id = '".LTChat_Main_CHAT_ID."' and id > '{$lastid}' {$time_back} order by id desc limit 0, {$limit}") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	 while ($row = mysql_fetch_object($result))
	   $out[] = $row;

	 return $out;
   }
   
   function get_prv_msg_elements($lastid, $private_id = -1)
   {
   	   if($lastid == 0)		$limit = get_ConfVar("ChDK_max_msg_on_enter");
       else					$limit = get_ConfVar("ChDK_max_msg_get");

   	   $result = mysql_query("SELECT U.nick as user, PT.id, PT.users_id_from, PT.users_id_to, PT.text, PT.time, PT.delivered_from, PT.delivered_to FROM `".LTChat_Main_prefix."users` U , `".LTChat_Main_prefix."private_talk` PT WHERE  PT.chat_id = '".LTChat_Main_CHAT_ID."' and U.chat_id = '".LTChat_Main_CHAT_ID."' and PT.users_id_from = U.id  and PT.id > '{$lastid}' and ( ( PT.users_id_from = '{$_SESSION['LTChart_user_id']}' and delivered_from = '0' ) or ( PT.users_id_to = '{$_SESSION['LTChart_user_id']}' and delivered_to = '0' ) ) and (PT.users_id_from = '{$private_id}' or PT.users_id_to = '{$private_id}') order by id desc") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

	   while ($row = mysql_fetch_object($result))
	   {
	   	 if($row->users_id_from == $_SESSION['LTChart_user_id'])
	   	   mysql_query("UPDATE `".LTChat_Main_prefix."private_talk` set delivered_from = '1' where id = {$row->id} and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
	   	 if($row->users_id_to == $_SESSION['LTChart_user_id'])
	   	   mysql_query("UPDATE `".LTChat_Main_prefix."private_talk` set delivered_to = '1' where id = {$row->id} and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);

	   	 $out[] = $row;
	   }
	   return $out;
   }

   function get_user_name()
   {
     return $_SESSION['LTChart_user_nick'];
   }

   function get_user_id()
   {
     return $_SESSION['LTChart_user_id'];
   }
   
   function get_user_rights()
   {
     return $_SESSION['LTChart_user_rights'];
   }
   
   function delete_message_id($id, $private_id)
   {
     if($private_id < 0)	mysql_query("delete from ".LTChat_Main_prefix."talk where id = '{$id}' and user = '{$_SESSION['LTChart_user_nick']}' and chat_id = '".LTChat_Main_CHAT_ID."'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
     else					mysql_query("delete from `".LTChat_Main_prefix."private_talk` where chat_id = '".LTChat_Main_CHAT_ID."' and id = '{$id}' and `users_id_from` = '{$_SESSION['LTChart_user_id']}' or `users_id_to` = '{$_SESSION['LTChart_user_id']}'") or debug(mysql_error(), "LTChatDataKeeper", __LINE__);
   }
 }
?>