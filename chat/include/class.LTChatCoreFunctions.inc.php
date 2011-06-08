<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  class LTChatCoreFunctions
  {
  	var $LTChatDataKeeper;
  	var $language_config;

  	function LTChatCoreFunctions(&$LTChatDataKeeper)
  	{
  	  $this->LTChatDataKeeper = &$LTChatDataKeeper;
  	}
  	//---------------------------------------------------------------------
  	
  	function set_language_config($language_config)
  	{
  	  $this->language_config = $language_config;
  	}

  	function command_show_help_info_parse($command, $type)
  	{
  	   if($type == 'list')	$style = ChFun_help_ListStyle;
  	   else 				$style = ChFun_help_InfoStyle;
  	   
  	   if(is_array($command['commands']))
  	     foreach ($command['commands'] as $_commands)
  	       $commands .= "{$_commands} ";

  	   if(is_array($command['params']))
  	     foreach ($command['params'] as $_params)
  	       $params .= "$_params ";

  	   if(is_array($command['except_params_static']))
  	   {
  	     foreach ($command['except_params_static'] as $_except_params_static_key => $_except_params_static_value)
  	     {
  	       if(isset($except_params_static))
  	         $except_params_static .= " | ";

  	       $except_params_static .= "{$_except_params_static_value} ";
  	     }
  	     $except_params_static = "{{$except_params_static}}";
  	   }
  	   
  	   if(is_array($command['Description']))
  	   {
  	     $Description = "";
  	     foreach ($command['Description'] as $key => $desc)
  	     {
  	       $param = $command['except_params_static'][$key];
  	       $Description .= str_replace(array("#param#","#Description#"), array($param, $desc), ChFun_help_DescArStyle);
  	     }
  	   }
  	   else 
  	     $Description = $command['Description'];

  	   return str_replace(array("#commands#","#except_params_static#","#params#","#Description#"), array($commands, $except_params_static, $params, $Description), $style);
  	}

  	function command_show_help($command_info)
  	{
  	  $params = $command_info['params'];

      $help_info = $this->language_config['help'];
      if(!is_array($help_info)) return;

      if(is_array($params))
        foreach ($params as $key => $param)
        {
          $params[$key] = trim($param);
          if($params[$key] == '')
          {  unset($params[$key]);  continue;  }

          if($params[$key][0] != '/')
             $params[$key] = '/'.$params[$key];
        }

      if(!is_array($params) || count($params) == 0)
      {
        foreach ($help_info as $command_help)
        {
          if($command_help[$this->LTChatDataKeeper->get_user_rights()] == true && (is_callable(array(get_class($this),$command_help['execute_function'])) || is_callable(array(get_class($this),$command_help['execute_tpl_function']))) )
            $out .= $this->command_show_help_info_parse($command_help,'list');//str_replace(array("#command#","#args#","#description#"), array($com, $args, $desc), ChFun_help_ListStyle);
        }
      }
      else
      {
        foreach ($help_info as $command_help)
        {
          if(!is_callable(array(get_class($this),$command_help['execute_function'])) && !is_callable(array(get_class($this),$command_help['execute_tpl_function']))) continue;
          if($command_help[$this->LTChatDataKeeper->get_user_rights()] != true) continue;

          $next = true;
      	  foreach ($command_help['commands'] as $command)
      	  {
      	  	foreach ($params as $key => $param)
      	  	  if($param == $command)
      	  	  {  $next = false;  break;  }
      	  	if($param == $command)  break;
      	  }

      	  if($next) continue;
      	  $out .= $this->command_show_help_info_parse($command_help,'info');//str_replace(array("#command#","#args#","#description#"), array($com, $args, $desc), ChFun_help_InfoStyle);
        }

        if($out == '')
	      $out = str_replace("#command#",implode(" ",$params), ChFun_help_UnknownCommand);
      }
      return array('text' => $out, 'type' => 'private');
  	}
  	//---------------------------------------------------------------------
  	function command_tpl_configreg()
  	{
  	  return array('reg_fields' =>  $this->LTChatDataKeeper->get_registration_fields());
  	}
  	//---------------------------------------------------------------------

    function command_skin_get_css()
    {
    	$out = array();
		if ($handle = opendir(LTChatTemplateSystemPath."css"))
		{
		    while (false !== ($file = readdir($handle)))
		      if ($file != "." && $file != "..")
		      	$out[] = $file;

		    closedir($handle); 
		}
		return $out;
    }

    function command_skin_get_skins()
    {
    	$out = array();
		if ($handle = opendir(LTChart_path."/templates/"))
		{
		    while (false !== ($file = readdir($handle)))
		      if ($file != "." && $file != "..")
		      	$out[] = $file;

		    closedir($handle); 
		}
		return $out;
    }

  	function command_skin($command_info)
  	{
      $row = $command_info['row'];
  	  if($row->user == $this->LTChatDataKeeper->get_user_name())
  	  {

	      $params = $command_info['params'];
	  	  $data_css = $this->command_skin_get_css();
	  	  $data_skins = $this->command_skin_get_skins();
	
	  	  if($command_info['command_help']['except_params_static']['showcss'] == trim($params[1]))
	  	    $data = $data_css;
	  	  elseif($command_info['command_help']['except_params_static']['showskins'] == trim($params[1]))
	  	    $data = $data_skins;
	  	  elseif($command_info['command_help']['except_params_static']['setskin'] == trim($params[1]))
	  	  {
	  	  	unset($params[1]);
			$name = trim(implode(" ",$params));
			if(is_array($data_skins))
			  foreach ($data_skins as $skin)
			    if($skin == $name)
			    {
			      $out = str_replace("#skin_name#",$name, ChFun_skin_SkinChanged);
			      $this->LTChatDataKeeper->set_chat_variable("LTChatTemplateName", $name);
			      $this->LTChatDataKeeper->set_chat_variable("LTTpl_css_link", LTChatTemplatePath."css/default.css");
			    }
	
			if(!$out)	$out = ChFun_skin_BadSkin;
	  	  }
	  	  elseif($command_info['command_help']['except_params_static']['setcss'] == trim($params[1]))
	  	  {
	  	  	unset($params[1]);
			$name = trim(implode(" ",$params));
			if(is_array($data_css))
			  foreach ($data_css as $css)
			  {
				if($css == $name)
			    {
			      $out = str_replace("#css_name#",$name, ChFun_skin_CssChanged);
			      $this->LTChatDataKeeper->set_chat_variable("LTTpl_css_link", LTChatTemplatePath."css/{$name}");
			    }
			  }
	
			if(!$out)	$out = ChFun_skin_BadCss;
	  	  }
	
	  	  if(is_array($data))
	  	  {
	  	    foreach ($data as $file)
	  	    {
	  	      if($out)	$out = str_replace("#name#", $file, ChFun_skin_List.ChFun_skin_ListSep).$out;
	  	  	  else		$out = str_replace("#name#", $file, ChFun_skin_List);
	  	    }
	  	    return array('text' => $out, 'type' => 'private');
	  	  }
	  	  elseif($out)
	  	    return array('text' => $out, 'type' => 'private');
	  	  else
	  	    return array('text' => str_replace("#param#", $params[1], ChFun_skin_UnParam), 'type' => 'private');
  	  }
  	  return array('type' => 'skip');
  	  
  	}
  	//---------------------------------------------------------------------

  	function command_ping($command_info)
  	{
  	  $row = $command_info['row'];
  	  if($row->user == $this->LTChatDataKeeper->get_user_name())
  	  {
  	  	$HOST = trim($command_info['params'][1]);
  	  	if($HOST == "")
  	  	  $text = ChFun_ping_BadHost;
  	  	elseif(!function_exists("socket_create"))
  	  	  $text = ChFun_ping_Disabled;
  	  	elseif(($ip = gethostbyname($HOST)) == $HOST && !eregi("([0-9]*)\.([0-9]*)\.([0-9]*)\.([0-9]*)", $HOST))
  	  	{
  	  	  $text = str_replace("#host#", $HOST, ChFun_ping_ResolveErr);
  	  	}
  	  	else
  	  	{
          include_once(LTChart_path."/include/class.Net_Ping.inc.php");
          
		  $ping = new Net_Ping();
		  $text .= str_replace(array("#host#","#ip#"), array($HOST, $ip), ChFun_ping_Info).ChFun_ping_Separator;

		  for($i = 0; $i < 3; $i ++)
		  {
			  $ping->ping($HOST);
			  $b = 32;
		   	  if ($ping->time)		$text .= str_replace(array("#ip#","#b#","#time#"), array($ip, $b, $ping->time), ChFun_ping_Info_resp);
			  else				    $text .= ChFun_ping_Info_Timeout;
			  $text .= ChFun_ping_Separator;
		  }
  	  	}
	    return array('text' => $text, 'type' => 'private');
  	  }
  	  return array('type' => 'skip');
  	}
  	//---------------------------------------------------------------------
  	
  	function command_whoami($command_info)
  	{
  	   $text = str_replace("#user#", $this->LTChatDataKeeper->get_user_name(), ChFun_whoami);
	   return array('text' => $text, 'type' => 'private');
  	}
  	//---------------------------------------------------------------------

  	function command_logout($command_info)
  	{
  	  $row = $command_info['row'];
  	  if($row->user == $this->LTChatDataKeeper->get_user_name())
  	  {
  	    $this->LTChatDataKeeper->delete_message_id($row->id, -1);
  	    $other_options = array('function' => 'logout');
  	    return array('data_type' => 'functions', 'text' => '', 'type' => 'private', 'other_options' => $other_options);
  	  }

  	  return array('type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_tpl_avatar()
  	{
	  $avatars = array();
	  if (file_exists(LTChart_path . "/img/avatars/") && $handle = opendir(LTChart_path . "/img/avatars/"))
	  {		
	  	 $owners = $this->LTChatDataKeeper->get_avatars_list();
	  	 $noavatar_img = "";
		 while (false !== ($file = readdir($handle)))
		   if($file != "." && $file != "..")
		   {
		   	 $link = "./img/avatars/{$file}";
		   	 if($file == "noavatar.gif" || $file == "noavatar.jpg")
		       $noavatar_img = $file;
		   	 else
		   	 {
		       $avatars[$file]['link'] = $link;
		       $avatars[$file]['file_name'] = $file;
		       $avatars[$file]['owner'] = $owners[$link];
		   	 }
		   }
		 closedir($handle);
	  }

	  return array('avatars' => $avatars, 'noavatar' => $noavatar_img);
  	}
  	//---------------------------------------------------------------------

  	function command_tpl_me()
  	{
  	  return array();
  	}
  	
  	//---------------------------------------------------------------------
  	function command_kick($command_info)
  	{
  	  $row = $command_info['row'];
  	  if($row->user == $this->LTChatDataKeeper->get_user_name() && $row->room == $command_info['room'])
  	  {
  	    $this->LTChatDataKeeper->delete_message_id($row->id, -1);
        $user_name = trim($command_info['params'][1]);
        unset($command_info['params'][1]);
        $reason = trim(implode(" ",$command_info['params']));

		$user_info = $this->LTChatDataKeeper->get_user_by_nick($user_name);

        if($user_info == null)
  	  	  return array('text' => str_replace("#user#", $user_name, ChFun_kick_BadNick), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  	else
  	  	{
	      $this->LTChatDataKeeper->kick_user($user_info->id, $reason);

  	  	  if($reason == null)
  	  	  	return array('text' => str_replace(array("#user#"), array($user_name), ChFun_kick_Ok), 'type' => 'private');
  	  	  else 
  	  	  	return array('text' => str_replace(array("#user#","#reason#"), array($user_name, $reason), ChFun_kick_OkReason), 'type' => 'private');
  	  	}
  	  }
  	  else
  	    return array('text' => '', 'type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_private_msg($command_info)
  	{
  	  $params = $command_info['params'];
  	  $row = $command_info['row'];
  	  $room = $command_info['room'];
  	  $private_id = $command_info['private_id'];

  	  if($row->user == $this->LTChatDataKeeper->get_user_name() && $row->room == $room)
  	  {
  		$this->LTChatDataKeeper->delete_message_id($row->id, $private_id);
  		$user_info = $this->LTChatDataKeeper->get_user_by_nick(trim($params[1]));

  		if($user_info == null)
  		{
  		  $u_doesnt_exists = str_replace("#user#",htmlspecialchars(trim($params[1])), LTChatCore_user_doesnt_exists);
  		  return array('text' => $u_doesnt_exists, 'type' => 'private','other_options' => array('type_handle' => 'error'));
  		}
  		elseif ($user_info->nick == $row->user)
  		{
  		  return array('text' => ChFun_prv_msgtome, 'type' => 'private','other_options' => array('type_handle' => 'error'));
  		}

  		unset($params[1]);
  		$text = implode(" ",$params);

        $msg_text = $this->LTChatDataKeeper->post_private_msg($text, $user_info->id, 1);
        $error_exp = explode(" ",$msg_text);

		if($error_exp[0] == "/ERROR")
		{
		  $error_out = $this->command_ERROR(array('params'=> $error_exp));
		  $out = $error_out['text'];
		}
		else 
		{
	      $link = "./private.php?private_id={$user_info->id}";
	      $out = htmlspecialchars($text);
	      $data_type = "prv_msg_send";
	      $other_options = array('link' => $link, 'nick' => $user_info->nick);
		}

	  	$this->LTChatDataKeeper->delete_message_id($row->id, $private_id);
	  	
	  	if($data_type)
          return array('data_type' => $data_type, 'text' => $out, 'type' => 'private', 'other_options' => $other_options);
        else 
          return array('text' => $out, 'type' => 'private', 'other_options' => $other_options);        
  	  }
  	  else 
  	  {
  	  	return array('text' => '', 'type' => 'skip');
  	  }
  	}
  	//---------------------------------------------------------------------
    function command_emoticons($command_info)
    {
  	   if(file_exists(LTChatTemplateSystemPath."tpl_emoticons.txt"))
  	   {
		  $tpl_emoticons = file(LTChatTemplateSystemPath."tpl_emoticons.txt");
		  foreach ($tpl_emoticons as $line)
		  {
		  	$lines = explode("\t",$line);
		  	if(count($lines) <2) continue;

		  	$from = htmlspecialchars($lines[0]);
		  	$emoticons .= str_replace(array("#path#","#info#"),array(LTChatTemplatePath."img/emoticons/".$lines[count($lines)-1],$from), ChFun_emoticons_Style);
		  }
  	   }
  	   return array('text' => $emoticons, 'type' => 'private');
    }
  	//---------------------------------------------------------------------
    function command_removefriend($command_info)
    {
  	  $params = $command_info['params'];
      $params_new = array();
      $params_new[1] = $this->language_config['help']['friend']['except_params_static']['del'];
	  foreach ($params as $param)
	  	$params_new[] = $param;

	  $command_info['params'] = $params_new;
	  $command_info['command_help'] = $this->language_config['help']['friend'];
	  
	  return $this->command_friend($command_info);
    }

  	function command_friend($command_info)
  	{
  	  $row = $command_info['row'];
  	  if($row->user == $this->LTChatDataKeeper->get_user_name() && $row->room == $command_info['room'])
  	  {
	  	  $params = $command_info['params'];
	  	  $row = $command_info['row'];
	
	  	  $add_friend = true;
	  	  if($command_info['command_help']['except_params_static']['add'] == trim($params[1]))
	  	  {
	  	    unset($params[1]);
	  	  }
	  	  elseif($command_info['command_help']['except_params_static']['del'] == trim($params[1]))
	  	  {
	  	    unset($params[1]);
	  	  	$add_friend = false;
	  	  }
	  	  elseif($command_info['command_help']['except_params_static']['show'] == trim($params[1]))
	  	  {	
			$res = $this->LTChatDataKeeper->get_friend_list();
			if($res == null)
			{
	  		  return array('text' => ChFun_friend_Eempty, 'type' => 'private');
			}
			else 
			{
			  if(is_array($res['from']))
			    foreach ($res['from'] as $info)
			      if($friend_from == null)
			        $friend_from = $info->nick;
			      else 
			        $friend_from .= ChFun_friend_ShowSep.$info->nick;
			       
			  if(is_array($res['to']))
			    foreach ($res['to'] as $info)
			      if($friend_to == null)
			        $friend_to = $info->nick;
			      else
			        $friend_to .= ChFun_friend_ShowSep.$info->nick;
	
			  $out = str_replace(array("#friend_to#", "#friend_from#","#friend_from_text#","#friend_to_text#"), array($friend_to, $friend_from,ChFun_friend_from_text,ChFun_friend_to_text), ChFun_friend_Show);
	  		  return array('text' => $out, 'type' => 'private');
			  		
			}
	  	  }
	
	  	  $u_name = implode(" ", $params);
	      $u_name = trim($u_name);
	
	      $user_info = $this->LTChatDataKeeper->get_user_by_nick($u_name);
	  	  $this->LTChatDataKeeper->delete_message_id($row->id, $private_id);
	
	  	  if($user_info == null)
	  	  {
	  		$u_doesnt_exists = str_replace("#user#", $u_name, LTChatCore_user_doesnt_exists);
	  		return array('text' => $u_doesnt_exists, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	  	  }
	
	  	  if($add_friend)
	  	  {
	  	  	$out = str_replace("#user#", $user_info->nick, ChFun_friend_Add);
	  	    $this->LTChatDataKeeper->friend_user_add($user_info->id);
	  	  }
	  	  else
	  	  {
	  	  	$out = str_replace("#user#", $user_info->nick, ChFun_friend_Del);
	  	    $this->LTChatDataKeeper->friend_user_del($user_info->id);
	  	  }
	
	  	  return array('text' => $out, 'type' => 'private');
  	  }
  	  else 
  	    return array('text' => '', 'type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_unignore($command_info)
  	{
  	  $params = $command_info['params'];
      $params_new = array();
      $params_new[1] = $this->language_config['help']['ignore']['except_params_static']['del'];
	  foreach ($params as $param)
	  	$params_new[] = $param;

	  $command_info['params'] = $params_new;
	  $command_info['command_help'] = $this->language_config['help']['ignore'];
	  
	  return $this->command_ignore($command_info);
  	}

  	function command_ignore($command_info)
  	{
  	  if($row->user == $this->LTChatDataKeeper->get_user_name())
  	  	return array('text' => '', 'type' => 'skip');

  	  $params = $command_info['params'];
  	  $row = $command_info['row'];

  	  $add_ignore = true;
  	  if($command_info['command_help']['except_params_static']['add'] == $params[1])
  	    unset($params[1]);
  	  elseif($command_info['command_help']['except_params_static']['del'] == $params[1])
  	  {
  	    unset($params[1]);
  	  	$add_ignore = false;
  	  }

  	  $u_name = implode(" ", $params);
      $u_name = trim($u_name);

      $user_info = $this->LTChatDataKeeper->get_user_by_nick($u_name);
  	  $this->LTChatDataKeeper->delete_message_id($row->id, $private_id);

  	  if($user_info == null)
  	  {
  		$u_doesnt_exists = str_replace("#user#",$u_name, LTChatCore_user_doesnt_exists);
  		return array('text' => $u_doesnt_exists, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
  	  }

  	  if($add_ignore)
  	  {
  	  	$out = str_replace("#user#", $user_info->nick, ChFun_ignore_Add);
  	    $this->LTChatDataKeeper->ignore_user_add($user_info->id);
  	  }
  	  else
  	  {
  	  	$out = str_replace("#user#", $user_info->nick, ChFun_ignore_Del);
  	    $this->LTChatDataKeeper->ignore_user_del($user_info->id);
  	  }

  	  return array('text' => $out, 'type' => 'private');
  	}
  	//---------------------------------------------------------------------
  	
  	
  	function command_clear($command_info)
  	{
  	  $row = $command_info['row'];
  	  if($row->user == $this->LTChatDataKeeper->get_user_name())
  	  {
  	    $this->LTChatDataKeeper->delete_message_id($row->id, -1);
  	    $other_options = array('function' => 'clear');
  	    return array('data_type' => 'functions', 'text' => '', 'type' => 'private', 'other_options' => $other_options);
  	  }
  	  return array('type' => 'skip');
  	}
 
  	function command_tpl_fullhelp()
  	{
      $help_info = $this->language_config['help'];
      foreach ($help_info as $key => $command_help)
        if($command_help[$this->LTChatDataKeeper->get_user_rights()] == true && ( is_callable(array(get_class($this),$command_help['execute_function'])) || is_callable(array(get_class($this),$command_help['execute_tpl_function']))))
          $functions[$key] = $this->command_show_help_info_parse($command_help,'info');//str_replace(array("#command#","#args#","#description#"), array($com, $args, $desc), ChFun_help_ListStyle);

  	  return array('functions' => $functions);
  	}

  	function command_tpl_bug()
  	{
	  return array();
  	}

  	function command_tpl_config()
  	{
	  return array();
  	}
  
  	function load_tpl($command_info)
  	{
  	  $row = $command_info['row'];

  	  if(is_object($row))
  	    $this->LTChatDataKeeper->delete_message_id($row->id, -1);

  	  $other_vars = urlencode(serialize($command_info['other_vars']));
  	  $other_options = array('load_template' => $command_info['command_help']['load_template'], 'other_vars' => $other_vars);

  	  return array('data_type' => 'template', 'text' => '', 'type' => 'private', 'other_options' => $other_options);
  	}
  	//---------------------------------------------------------------------

  	function command_info($command_info)
  	{
	  $row = $command_info['row'];
  	  if($row->user == $this->LTChatDataKeeper->get_user_name())
  	  {
	  	  $params = $command_info['params'];

	  	  $this->LTChatDataKeeper->delete_message_id($row->id, -1);

	  	  $nick = implode(" ", $params);
	      $nick = trim($nick);

	      $user = $this->LTChatDataKeeper->get_user_by_nick($nick);
	      $command_info['other_vars']['login'] = $nick;

	      if($user == null)
	  	    return array('text' => str_replace("#user#", $nick, ChFun_info_BadUserName), 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	      else
	        return $this->load_tpl($command_info);
  	  }

  	  return array('type' => 'skip');
  	}
  	//---------------------------------------------------------------------
  	
  	function command_room($command_info)
  	{
	  $row = $command_info['row'];
  	  if($row->user == $this->LTChatDataKeeper->get_user_name())
  	  {
	  	  $params = $command_info['params'];
	
	  	  $this->LTChatDataKeeper->delete_message_id($row->id, -1);

	  	  $room = implode(" ", $params);
	      $room = trim($room);

	  	  if(count($params) > 1 || $room == null)
	  	  {
	  	    return array('text' => ChFun_room_BadName, 'type' => 'private', 'other_options' => array('type_handle' => 'error'));
	  	  }
	
	  	  $text = str_replace("#room#", $room, ChFun_room_Changed);
	  	  $other_options = array('new_room' => $room);
	
	  	  return array('data_type' => 'change_room','text' => $text, 'type' => 'private', 'other_options' => $other_options);
  	  }
  	  return array('type' => 'skip');
  	}
  	//---------------------------------------------------------------------

  	function command_url($command_info)
  	{
  	  $params = $command_info['params'];
  	  $param = implode(" ", $params);
      $param = trim($param);

      if(eregi("(http.?://)(.*)",$param, $r))
        $out .= str_replace(array("#link#","#title#","#text#"), array($r[0].urlencode($param), htmlspecialchars($param),$r[2]), ChFun_url_Style);
      else
        $out .= str_replace(array("#link#","#title#","#text#"), array("http://".urlencode($param),htmlspecialchars($param), $param), ChFun_url_Style);

      return array('text' => $out, 'type' => 'public');
  	}
  	//---------------------------------------------------------------------
  	function command_tpl_configrooms()
  	{
  	  return array('rooms' => $this->LTChatDataKeeper->get_all_rooms());
  	}
  	//---------------------------------------------------------------------

  	function command_ERROR($command_info)
  	{
	  $out['type'] = 'private';
	  $out['text'] = "Unknown error";
	
  	  if(is_array($command_info['params']))
  	  {
  	  	if($command_info['params'][1] == "ignore" && $command_info['params'][1] == ERROR_ignore_from)
  	  	  $out = array('type' => 'private', 'text' => ERROR_ignore_msg_from);

  	  	if($command_info['params'][1] == "ignore" && $command_info['params'][1] == ERROR_ignore_to)
  	  	  $out = array('type' => 'private', 'text' => ERROR_ignore_msg_to);
  	  }

	  return $out;
  	}
  	//---------------------------------------------------------------------

  	function command($row, $room, $private_id)
  	{
  	  $row->nick = "Chat Core";
  	  $command_ar = explode(" ",$row->text);

      $_command = trim($command_ar[0]);
      unset($command_ar[0]);
	  $params = $command_ar;

	  $function_params = array('params' => $params, 'row' => $row, 'room' => $room, 'private_id' => $private_id);

	  if($_command == "/ERROR")
	  {
  	    $this->LTChatDataKeeper->delete_message_id($row->id, 1);
		return $this->command_ERROR($function_params);
	  }
	  
	  $out['type'] = 'private';
	  $out['text'] = str_replace("#command#", $_command, ChFunBadCommand);
	  $out['other_options']['type_handle'] = 'error';

	  $help = $this->language_config['help'];
	  foreach ($help as $commands)
	    if(is_array($commands['commands']))
		  foreach ($commands['commands'] as $command)
		  {
		    if($command == $_command)
		    {
		      if($commands[$this->LTChatDataKeeper->get_user_rights()] !== true) 
		      {
			  	$out['type'] = 'private';
	  			$out['text'] = ChFunNoRights;
			  	$out['other_options']['type_handle'] = 'error';
		      }
			  elseif(is_callable(array(get_class($this),$commands['execute_function'])))
			  {
			  	$function_params['command_help'] = $commands;
			    $out = call_user_func(array($this,$commands['execute_function']),$function_params);
			  }
			  elseif(is_callable(array(get_class($this),$commands['execute_tpl_function'])))
			  {
			  	if($row->user == $this->LTChatDataKeeper->get_user_name() && $row->room == $room)
			  	{
			  	  $function_params['command_help'] = $commands;
			      $out = $this->load_tpl($function_params);
			  	}
			  	else 
			  	  $out['type'] = 'skip';
			  }
			  else
			  {
			  	$function_params['command_help'] = $commands;
	  			$out['text'] = ChFunBadFunction;
			  }

			  if(!isset($out['other_options']['type_handle']))
				$out['other_options']['type_handle'] = 'info';

			  return $out;
		    }
		  }

	  return $out;
  	}
  }
?>