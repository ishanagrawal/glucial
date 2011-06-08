<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
  $GLOBALS['language_config'] = array();
  $GLOBALS['language_config']['registration_form.tpl']['#login#'] = ChTPL_RegLogin;
  $GLOBALS['language_config']['registration_form.tpl']['#pass#'] = ChTPL_RegPass;
  $GLOBALS['language_config']['registration_form.tpl']['#submit#'] = ChTPL_RegSub;
  
  $GLOBALS['language_config']['registration_form.tpl']['#ERROR_login_too_short#'] = str_replace("#chars#", LTChatCore_user_min_login_chars, ChTPL_RegErrLogTooShort);
  $GLOBALS['language_config']['registration_form.tpl']['#ERROR_password_too_short#'] = str_replace("#chars#", LTChatCore_user_min_password_chars , ChTPL_RegErrPasTooShort);
  $GLOBALS['language_config']['registration_form.tpl']['#ERROR_user_exists#'] = ChTPL_RegErrUserExists;
  $GLOBALS['language_config']['registration_form.tpl']['#ERROR_fill_required_fields#'] = ChTPL_RegErrFillAllFields;
  $GLOBALS['language_config']['registration_form.tpl']['#ERROR_login_bad_chars#'] = ChTPL_RegErrUserBadNick;
  
  

  $GLOBALS['language_config']['login_form.tpl']['#login#'] = ChTPL_LogLogin;
  $GLOBALS['language_config']['login_form.tpl']['#pass#'] = ChTPL_LogPass;
  $GLOBALS['language_config']['login_form.tpl']['#submit#'] = ChTPL_LogSub;
  $GLOBALS['language_config']['login_form.tpl']['#guest#'] = ChTPL_LogGuest;

  
  
  $GLOBALS['language_config']['months']['January'] = ChFun_January;
  $GLOBALS['language_config']['months']['February'] = ChFun_February;
  $GLOBALS['language_config']['months']['March'] = ChFun_March;
  $GLOBALS['language_config']['months']['April'] = ChFun_April;
  $GLOBALS['language_config']['months']['May'] = ChFun_May;
  $GLOBALS['language_config']['months']['June'] = ChFun_June;
  $GLOBALS['language_config']['months']['July'] = ChFun_July;
  $GLOBALS['language_config']['months']['August'] = ChFun_August;
  $GLOBALS['language_config']['months']['September'] = ChFun_September;
  $GLOBALS['language_config']['months']['October'] = ChFun_October;
  $GLOBALS['language_config']['months']['November'] = ChFun_November;
  $GLOBALS['language_config']['months']['December'] = ChFun_December;

  
  
  $GLOBALS['language_config']['help']['help'] = array(		'commands' => array("/help","/?"),
  												'params' => array("[ ".LTChatCOM_help_param." ]"),
	  											'execute_function' => 'command_show_help',
	  											'Description' => LTChatCOM_help_desc,
  												'Admin' => true,
  												'Guest' => true,
  												'Standard' => true
	  											);

  $GLOBALS['language_config']['help']['fullhelp'] 	= array('commands' => array("/fullhelp"),
  												'execute_tpl_function' => 'command_tpl_fullhelp',
  												'params' => array(),
		  										'load_template'	=> 'command_fullhelp.tpl',
  												'Description' => LTChatCOM_fullhelp_desc,
  												'Admin' => true,
  												'Guest' => true,
  												'Standard' => true
  												);

  $GLOBALS['language_config']['help']['bug']	= array(	'commands' => array("/bug","/suggest"),
		  													'execute_tpl_function' => 'command_tpl_bug',
  															'params' => array(),
		  													'load_template'	=> 'command_bug_form.tpl',
  															'Description' => LTChatCOM_bug_desc,
			  												'Admin' => true,
			  												'Guest' => true,
			  												'Standard' => true
  															);

  $GLOBALS['language_config']['help']['room'] = array(		'commands' => array("/room"),
  															'execute_function' => 'command_room',
  															'params' => array("{ ".LTChatCOM_room_param." }"),
  															'Description' => LTChatCOM_room_desc,
			  												'Admin' => true,
			  												'Guest' => true,
			  												'Standard' => true
  															);

  $GLOBALS['language_config']['help']['clear'] = array(	'commands' => array("/clear"),
  												'execute_function' => 'command_clear',
  												'params' => array(),
  												'Description' => LTChatCOM_clear_desc,
  												'Admin' => true,
  												'Guest' => true,
  												'Standard' => true
  												);

  $GLOBALS['language_config']['help']['ignore'] = array(	'commands' => array("/ignore"),
  												'execute_function' => 'command_ignore',
  												'params' => array("{ ".LTChatCOM_ignore_param." }"),
  												'except_params_static' => array("add" => "-add", "del" => "-del"),
  												'Description' => array('add' => LTChatCOM_ignore_desc_add,
  																	   'del' => LTChatCOM_ignore_desc_del),
  												'Admin' => true,
  												'Guest' => false,
  												'Standard' => true
  												);

  $GLOBALS['language_config']['help']['prv'] = array(	'commands' => array("/private","/prv"),
					  									'execute_function' => 'command_private_msg',
	  													'params' => array("{ ".LTChatCOM_prv_param." }"),
	  													'Description' => LTChatCOM_prv_desc,
		  												'Admin' => true,
		  												'Guest' => true,
		  												'Standard' => true
	  													);

  $GLOBALS['language_config']['help']['removefriend'] = array(	'commands' => array("/removefriend", "/removebuddy"),
			  													'execute_function' => 'command_removefriend',
  																'params' => array("{ ".LTChatCOM_removefriend_param." }"),
  																'Description' => LTChatCOM_removefriend_desc,
				  												'Admin' => true,
				  												'Guest' => false,
				  												'Standard' => true
  																);

  $GLOBALS['language_config']['help']['friend'] = array(	'commands' => array("/friend", "/buddy"),
			  												'execute_function' => 'command_friend',
			  												'params' => array("[ Username ]"),
			  												'except_params_static' => array("add" => "-add", "del" => "-del", "show" => "-show"),
			  												'Description' => array('add' => LTChatCOM_friend_desc_add,
					  															   'del' => LTChatCOM_friend_desc_del,
					  															   'show' => LTChatCOM_friend_desc_show),
			  												'Admin' => true,
			  												'Guest' => false,
			  												'Standard' => true
															);

  $GLOBALS['language_config']['help']['url'] = array(		'commands' => array("/url"),
				  											'execute_function' => 'command_url',
	  														'params' => array("{ ".LTChatCOM_url_param." }"),
	  														'Description' => LTChatCOM_url_desc,
			  												'Admin' => true,
			  												'Guest' => true,
			  												'Standard' => true
	  														);


  $GLOBALS['language_config']['help']['unignore'] = array(	'commands' => array("/unignore"),
		  										'execute_function' => 'command_unignore',
		  										'params' => array("{ ".LTChatCOM_unignore_param." }"),
		  										'Description' => LTChatCOM_unignore_desc,
  												'Admin' => true,
  												'Guest' => false,
  												'Standard' => true
		  										);

  $GLOBALS['language_config']['help']['kick'] = array(		'commands' => array("/kick"),
  												'execute_function' => 'command_kick',
  												'params' => array("{ ".LTChatCOM_kick_param1." }","[ ".LTChatCOM_kick_param2." ]"),
  												'Description' => LTChatCOM_kick_desc,
  												'Admin' => true,
  												'Guest' => false,
  												'Standard' => false
  												);

  $GLOBALS['language_config']['help']['me'] = array(		'commands' => array("/myprofile","/me"),
  												'execute_tpl_function' => 'command_tpl_me',
		  										'load_template'	=> 'command_me.tpl',
  												'Description' => LTChatCOM_me_desc,
  												'Admin' => true,
  												'Guest' => false,
  												'Standard' => true
  												);

  $GLOBALS['language_config']['help']['whoami'] = array(	'commands' => array("/whoami"),
  												'execute_function' => 'command_whoami',
  												'Description' => LTChatCOM_whoami_desc,
  												'Admin' => true,
  												'Guest' => true,
  												'Standard' => true
  												);

  $GLOBALS['language_config']['help']['ping'] = array(	'commands' => array("/ping"),
  												'params' => array("{ ".LTChatCOM_ping_param." }"),
  												'execute_function' => 'command_ping',
  												'Description' => LTChatCOM_ping_desc,
  												'Admin' => true,
  												'Guest' => true,
  												'Standard' => true
  												);

  $GLOBALS['language_config']['help']['logout'] = array(	'commands' => array("/logout","/exit"),
  															'execute_function' => 'command_logout',
  															'Description' => LTChatCOM_logout_desc,
			  												'Admin' => true,
			  												'Guest' => true,
			  												'Standard' => true
  															);

  $GLOBALS['language_config']['help']['configrooms'] = array(	'commands' => array("/configrooms","/crooms"),
  													'execute_tpl_function' => 'command_tpl_configrooms',
			  										'load_template'	=> 'command_configrooms.tpl',
  													'Description' => LTChatCOM_configrooms_desc,
	  												'Admin' => true,
	  												'Guest' => false,
	  												'Standard' => false
  													);

  $GLOBALS['language_config']['help']['skin']  = array(	'commands' => array("/skin"),
  												'execute_function' => 'command_skin',
  												'except_params_static' => array("setskin" => "-setskin","setcss" => "-setcss", "showskins" => "-showskins", "showcss" => "-showcss"),
  												'params' => array("[ ".LTChatCOM_skin_param1." | ".LTChatCOM_skin_param2." ]"),
  												'Description' => array(
  												 					   'setskin' => LTChatCOM_skin_desc_setskin,
  												 					   'setcss' => LTChatCOM_skin_desc_setcss,
		  															   'showskins' => LTChatCOM_skin_desc_showskins,
		  															   'showcss' => LTChatCOM_skin_desc_showcss),
  												'Admin' => true,
  												'Guest' => false,
  												'Standard' => false);

  $GLOBALS['language_config']['help']['whois'] = array(	'commands' => array("/whois", "/info", "/profile"),
  												'execute_tpl_function' => 'command_tpl_info',
  												'execute_function' => 'command_info',
  												'load_template'	=> 'command_info.tpl',
  												'params' => array("{ ".LTChatCOM_whois_param." }"),
  												'Description' => LTChatCOM_whois_desc,
  												'Admin' => true,
  												'Guest' => true,
  												'Standard' => true
  												);

  $GLOBALS['language_config']['help']['emoticons'] 	= array('commands' => array("/emoticons","/emot"),
				  											'execute_function' => 'command_emoticons',
  															'Description' => LTChatCOM_emoticons_desc,
				  											'Admin' => true,
				  											'Guest' => true,
				  											'Standard' => true
  															);

  $GLOBALS['language_config']['help']['config']	= array(	'commands' => array("/config"),
		  													'execute_tpl_function' => 'command_tpl_config',
  															'params' => array(),
		  													'load_template'	=> 'command_config.tpl',
  															'Description' => LTChatCOM_config_desc,
			  												'Admin' => true,
			  												'Guest' => false,
			  												'Standard' => false
  															);

  $GLOBALS['language_config']['help']['avatar']	= array(	'commands' => array("/avatar"),
		  													'execute_tpl_function' => 'command_tpl_avatar',
  															'params' => array(),
		  													'load_template'	=> 'command_avatar.tpl',
  															'Description' => LTChatCOM_avatar_desc,
			  												'Admin' => true,
			  												'Guest' => false,
			  												'Standard' => true
  															);

  $GLOBALS['language_config']['help']['configreg']	= array(	'commands' => array("/configreg"),
		  													'execute_tpl_function' => 'command_tpl_configreg',
  															'params' => array(),
		  													'load_template'	=> 'command_configreg.tpl',
  															'Description' => LTChatCOM_configreg_desc,
			  												'Admin' => true,
			  												'Guest' => false,
			  												'Standard' => false
  															);
?>