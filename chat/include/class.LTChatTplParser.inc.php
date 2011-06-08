<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
 class LTChatTplParser
 {
   var $LTChartCore;
   var $language_config;
   var $room;
   var $private_id;
   
   var $title;

   function LTChatTplParser($room = NULL, $private_id = -1)
   {
   	 if($private_id >= 0)
   	   $room = '';
   	 
   	 $this->private_id = $private_id;
   	 $this->room = $room;
   	 
   	 session_start();

     $this->LTChartCore = new LTChatCore();
   	 $this->language_config = $GLOBALS['language_config'];
     
     
     if(isset($_POST['login']))
     {
       $this->login_err = $this->LTChartCore->login_user();
     }
   }

   function get_tpl($tpl_name, $replace = array(), $recurrent = false)
   {
     if($recurrent == false)
     {
       $replace['#header#'] = $this->get_tpl("_header.tpl", $replace, true);
       $replace['#footer#'] = $this->get_tpl("_footer.tpl", $replace, true);
     }

     $replace['#LTChatRoomChangeMsg#'] = str_replace("'","\'",LTChatRoomChangeMsg);
   	 $replace['#css_link#'] = LTTpl_css_link;
   	 $replace['#room#'] = $this->room;
   	 $replace['#private_id#'] = $this->private_id;
   	 $replace['#LTChatTemplatePath#'] = LTChatTemplatePath;
   	 $replace['#PageEncoding#'] = ChPageEncoding;
   	 $replace['#refresh_after#'] = get_ConfVar("ChRefreshAfter");

   	 $replace['#title#'] = $this->title;

     $tpl_ar = file(LTChatTemplateSystemPath.$tpl_name);
     if(is_array($tpl_ar))
       $tpl = implode(null, $tpl_ar);
     
     if(is_array($replace))
       $tpl = strtr($tpl, $replace);

     if(is_array($this->language_config[$tpl_name]))
	   $tpl = strtr($tpl, $this->language_config[$tpl_name]);

     return $tpl;
   }

   function get_users_list_frame()
   {
     return $this->get_tpl("frame_users_list.tpl",array("#datatype#" => "users_list"));
   }

   function get_prv_chat_frame()
   {
     return $this->get_tpl("frame_prv_talk.tpl",array("#datatype#" => "msg"));
   }

   function get_talk_frame()
   {
     return $this->get_tpl("frame_talk.tpl",array("#datatype#" => "msg"));
   }
   
   function get_talk_shoutbox_frame()
   {
        return $this->get_tpl("frame_talk_shoutbox.tpl",array("#datatype#" => "msg"));
   }

   function get_login_form()
   {
	 $replace = array('#info#' => '', '#post_login#' => $_POST['login'], '#password#' => '');
	 $info = $this->login_err;

	 if($info === true)
	 {
	   $replace['#info#'] = '#info_user_added#';
	   $replace['#post_login#'] = '';
	 }
	 elseif($info !== false)
	   $replace['#info#'] = $info;


 	 $optgroup_tpl = ChFun_configrooms_OotGroup;
 	 $option_tpl = ChFun_configrooms_Ootion;

 	 $data = $this->LTChartCore->get_all_rooms();
 	 $select_data = array();
 	 if(is_array($data['rooms']['defined']))
 	   foreach ($data['rooms']['defined'] as $room)
 	     $select_data[$room->room_cat][] = array('room_name' => $room->room_name, 'users_online' => count($room->users_online), 'room_id' => $room->id, 'default' => $room->default);

 	 foreach ($select_data as $room_cat => $rooms)
 	 {
 	   $options = "";
 	   foreach ($rooms as $room_info)
	   {
	 	 if($room_info['default'] == 1)	$default = ChFun_croom_Default;
	 	 else 							$default = "";

	 	 $options .= str_replace(array("#name#","#value#", "#users_online#", "#default#"), array($room_info['room_name'], $room_info['room_name'], $room_info['users_online'], $default), $option_tpl);
	   }
	   $select_data_str .= str_replace(array("#options#","#label#"),array($options, $room_cat), $optgroup_tpl);
 	 }

	 if($select_data_str)
   	   $replace['#rooms#'] = str_replace(array("#rooms#","#seltext#"),array($select_data_str,LTTpl_login_selroom),ChLoginRooms);
   	 else 
   	   $replace['#rooms#'] = "";
 
   	 if($_POST['guest'] == true)
   	   $checked = "checked";
   	 if(get_ConfVar("LTChatCore_guest_account") == true)
   	   $replace['#guest_login#'] = str_replace(array("#guest_name#","#checked#"), array("guest",$checked), ChLoginGuest);
     else 
   	   $replace['#guest_login#'] = "";
   	 
	 $replace['#menu#'] = $this->get_menu();

     return $this->get_tpl('login_form.tpl', $replace);
   }
   
   function get_menu()
   {
   	 $links = array();   	 

   	 $links['login']['branch'] = "login";
   	 $links['login']['text'] = ChMenuLogin;

   	 $links['reg']['branch'] = "reg";
   	 $links['reg']['text'] = ChMenuRegister;
   	 
   	 $links['statistics']['branch'] = "statistics";
   	 $links['statistics']['text'] = ChMenuStatistics;

   	 foreach ($this->get_static_html_list() as $k => $l)
   	 {
   	   $links[] = array('branch' => 'static_html', 'doc_id' => $k, 'text' => ucfirst(str_replace(array('_','-', '.html', '.htm'),array(' ', ' ','',''),$l)));
   	 }


   	 if($_GET['branch'] == '')
   	   $_GET['branch'] = "login";
   	   
   	 $this->title = ChMenuLogin;

   	 foreach ($links as $link)
   	 {
   	   if($_GET['branch'] == $link['branch'] && $_GET['doc_id'] == $link['doc_id']){	$tpl = ChMenuItemInactive;  $this->title = $link['text'];  }
   	   else										$tpl = ChMenuItemActive;  

   	   if(isset($link['doc_id']))
   	     $href = "./index.php?branch={$link['branch']}&doc_id={$link['doc_id']}";
   	   else
   	     $href = "./index.php?branch={$link['branch']}";
   	   
   	   if($items != null)  $items .= ChMenuItemSeparator;
   	   $items .= str_replace(array("#link#","#text#"), array($href, $link['text']), $tpl);
  	 }  	 

     return $this->get_tpl('menu.tpl', array('#menu_items#' => $items));
   }
   
   function get_statistics()
   {
   	 $replace = array('#menu#' => $this->get_menu()); 
	 $info = $this->LTChartCore->get_statistics();

	 define("LTChat_statistics_item","<tr><td align=right valign=top><b>#item_name#:</b></td><td>#value#</td></tr>");
	 define("LTChat_statistics_items_separator",", ");
	 
	 $rooms = "";
	 foreach ($info['rooms']['defined'] as $room)
	 	if(!$rooms)		$rooms .= $room->room_name;
	 	else			$rooms .= LTChat_statistics_items_separator.$room->room_name;

	 $online = "";
	 foreach ($info['online'] as $k => $on)
	 	if(!$online)	$online .= $k;
	 	else			$online .= LTChat_statistics_items_separator.$k;

	 $last_user = $info['stats']['last_registered']->nick;
	 
	 if($info['stats']['last_registered']->rights == "Guest")
	   $last_user .= " (".LTChat_statistics_nick_guest.")";

	 if($rooms)  $items .= str_replace(array("#item_name#","#value#"), array(LTChat_statistics_rooms_txt, $rooms), LTChat_statistics_item);
	 if($online) $items .= str_replace(array("#item_name#","#value#"), array(LTChat_statistics_online_txt, $online), LTChat_statistics_item);
	 $items .= str_replace(array("#item_name#","#value#"), array(LTChat_statistics_last_reg_txt, $last_user), LTChat_statistics_item);
	 $items .= str_replace(array("#item_name#","#value#"), array(LTChat_statistics_registered_txt, $info['stats']['registered_users']), LTChat_statistics_item);
	 $items .= str_replace(array("#item_name#","#value#"), array(LTChat_statistics_prv_count_txt, $info['stats']['private_messages_count']), LTChat_statistics_item);
	 $items .= str_replace(array("#item_name#","#value#"), array(LTChat_statistics_msg_count_txt, $info['stats']['messages_count']), LTChat_statistics_item);
	 $items .= str_replace(array("#item_name#","#value#"), array(LTChat_statistics_msg_sum, $info['stats']['messages_count'] + $info['stats']['private_messages_count']), LTChat_statistics_item);

	 $replace['#items#'] = $items;
	 
	 
     return $this->get_tpl('statistics.tpl', $replace);
   }

   function get_registration_fields($values)
   {
     if(is_array($reg_fields = $this->LTChartCore->get_registration_fields()))
     {
       $fields['integer'] = ChFieldInteger;
       $fields['float'] = ChFieldFloat;
       $fields['date'] = ChFieldDate;
       $fields['text'] = ChFielText;
       $fields['textarea'] = ChFielTextarea;
       $fields['radio'] = ChFieldRadio;
       $fields['radio_option'] = ChFieldRadioOption;
       $fields['select'] = ChFielSelect;
       $fields['select_option'] = ChFielSelectOption;

       $post_fields_data = array();
       foreach ($reg_fields as $field)
       	 if(isset($fields[$field->var_type]))
         {
		    $rep_name = $field->var_name;
		    $rep_var_name = "form{$field->id}";
			$rep_value = $values[$rep_var_name];
         	$post_fields_data[$field->id]['value'] = stripslashes($values[$rep_var_name]);
         	$post_fields_data[$field->id]['required'] = $field->required;

         	$required="";
         	if($field->required == 1)
         	{
         	  $replace['#required_desc#'] = LTTpl_required_reg_desc;
         	  $required = LTTpl_required_reg_mark;
         	}

         	switch ($field->var_type)
			{
			  case 'radio':
			  case 'select':
			    $select = "";

			    $option_tpl = $fields["{$field->var_type}_option"];
			    $option_ex = explode("|", $field->options);
			    $options_out = "";
			    $opt_counter = 0;

			    foreach ($option_ex as $opt)
			    {
			      $select = ""; $opt_counter++;
			      if($rep_value == $opt_counter)
			        if($field->var_type == 'radio')  $select = " checked ";
			        elseif($field->var_type == 'select')  $select = " selected ";

			      $options_out .= str_replace(array("#var_name#", "#text#", "#val#","#select#"), array($rep_var_name, $opt, $opt_counter++, $select), $option_tpl);
			    }
			    $other_fields .= str_replace(array("#required#","#name#","#var_name#", "#options#"), array($required , $rep_name,$rep_var_name, $options_out), $fields[$field->var_type]);
			  break;
			  default:
			    $rep_length = $field->var_lenght;
			    $other_fields .= str_replace(array("#required#","#name#","#var_name#","#value#", "#length#"), array($required, $rep_name, $rep_var_name, $rep_value, $rep_length), $fields[$field->var_type]);
			  break;
			}
         }
     }
     return array('post_fields_data' => $post_fields_data, 'other_fields' => $other_fields);
   }
   
   function get_static_html_list()
   {
	$list = array();
	if ($handle = opendir(LTChart_path."/static_html"))
	{
	   while (false !== ($file = readdir($handle)))
	   {
	       if (is_file(LTChart_path."/static_html/{$file}"))
	       {
	         $list[] = $file;
	       }
	   }
	   closedir($handle);
	}
   	
     return $list;
   }

   function get_registration_form()
   {
	 $replace = array('#required#'=> LTTpl_required_reg_mark, '#info#' => '', '#post_login#' => stripslashes($_POST['login']), '#password#' => '', '#room#' => $this->room);
	 
	 $registration_fields = $this->get_registration_fields($_POST);
     $replace['#other_fields#'] = $registration_fields['other_fields'];
     $post_fields_data = $registration_fields['post_fields_data'];

     $replace['#required_desc#'] = LTTpl_required_reg_desc;
     $replace['#menu#'] = $this->get_menu();

	 $info = $this->LTChartCore->add_user($post_fields_data);

	 if(LTChatCore_user_error_too_short_login === $info)		$replace['#info#'] = '#ERROR_login_too_short#';
	 if(LTChatCore_user_error_too_short_password === $info)  	$replace['#info#'] = '#ERROR_password_too_short#';
     if(LTChatCore_user_errro_user_exists === $info)			$replace['#info#'] = '#ERROR_user_exists#';
     if(LTChatCore_user_error_fill_required === $info)			$replace['#info#'] = '#ERROR_fill_required_fields#';
     if(LTChatCore_user_error_nick == $info)					$replace['#info#'] = '#ERROR_login_bad_chars#';

     if($info === true)
	   $replace['#info#'] = LTTpl_user_added;

     return $this->get_tpl('registration_form.tpl', $replace);
   }
   
   function get_static_html($html_id)
   {
   	
	 $docs = $this->get_static_html_list();

	 if(!isset($docs[$html_id]))
	 {
 	   $tpl = str_replace("#error#",LTTpl_static_html,LTTpl_static_html_tpl);
	 }
	 else 
	 {
	   $html_name = $docs[$html_id];

       if(file_exists(LTChart_path."/static_html/".$html_name))
         $tpl_ar = file(LTChart_path."/static_html/".$html_name);

       $tpl = implode($tpl_ar);
     }

     return $this->get_tpl("static_html.tpl",array('#static_html#' => $tpl, '#menu#' => $this->get_menu()));
   }
   
   function pass_params_via_tpl($template, $params)
   {
	  $other_vars = urlencode(serialize($params));   
      return "./command_tpl.php?load_template={$template}&other_vars={$other_vars}";
   }

   function get_command_tpl($template, $other_vars)
   {
   	 $info_user_set = false;
   	 switch ($template)
   	 {
   	 	case "command_configrooms.tpl":
   	 	{
		  if(count($_POST) > 0)
		  {
		  	if($_POST['type'] == "add")
		  	{
				$inf = $this->LTChartCore->add_room($_POST);
				if($inf === ChFun_croom_ErrNoCat) $info = ChFun_croom_TxtRc;
				elseif($inf === ChFun_croom_ErrNoRoom) $info = ChFun_croom_TxtRn;
	  			elseif($inf === ChFun_croom_ErrLenCat) $info = str_replace("#max_room_cat_name#",LTChat_MaxRoomCatName, ChFun_croom_TxtLRc);
	  			elseif($inf === ChFun_croom_ErrLenRoom) $info = str_replace("#max_room_name#",LTChat_MaxRoomName, ChFun_croom_TxtLRn);
	  			elseif($inf === ChFun_croom_ErrExists) $info = ChFun_croom_TxtExists;
	  			else $info = ChFun_croom_RoomAdded;
		  	}
		  	elseif ($_POST['type'] == "del")
		  	{
		  	  if(ChFun_croom_ErrNoRoomSel === $this->LTChartCore->delete_room($_POST['selected_channel']))  $info = ChFun_croom_TxtNoRoomSel;
		  	  else $info = ChFun_croom_RoomDeleted;
		  	}
		  	elseif ($_POST['type'] == "def")
		  	{
		  	  if(ChFun_croom_ErrNoRoomSel === $this->LTChartCore->set_default_room($_POST['selected_channel']))  $info = ChFun_croom_TxtNoRoomSelDef;
		  	  else $info = ChFun_croom_DefaultChanged;
		  	}
		  }

		  $replace['#add_room_text#'] = ChFun_configrooms_add;
		  $replace['#category_name_text#'] = ChFun_configrooms_cat_name;
		  $replace['#room_name_text#']  =ChFun_configrooms_room_name;
		  $replace['#rooms_list_text#'] = ChFun_configrooms_defined;
		  $replace['#submit#'] = ChFun_configrooms_submit;
		  $replace['#delete_text#'] = ChFun_configrooms_delete;
		  $replace['#set_default_text#'] = ChFun_configrooms_default;
		  

		  /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
		  $data = $this->LTChartCore->command_tpl_params($template);

   	 	  $optgroup_tpl = ChFun_configrooms_OotGroup;
   	 	  $option_tpl = ChFun_configrooms_Ootion;

   	 	  $select_data = array();
   	 	  if(is_array($data['rooms']['defined']))
   	 	    foreach ($data['rooms']['defined'] as $room)
   	 	      $select_data[$room->room_cat][] = array('room_name' => $room->room_name, 'users_online' => count($room->users_online), 'room_id' => $room->id, 'default' => $room->default);

   	 	  foreach ($select_data as $room_cat => $rooms)
   	 	  {
   	 	  	  $options = "";
   	 	  	  foreach ($rooms as $room_info)
	   	 	  {
	   	 	  	if($room_info['default'] == 1)	$default = ChFun_croom_Default;
	   	 	  	else 							$default = "";

	   	 	    $options .= str_replace(array("#name#","#value#", "#users_online#", "#default#"), array($room_info['room_name'], $room_info['room_id'], $room_info['users_online'], $default), $option_tpl);
	   	 	  }
	   	 	  $select_data .= str_replace(array("#options#","#label#"),array($options, $room_cat), $optgroup_tpl);
   	 	  }
   	 	  $replace['#rooms_list#'] = $select_data;
   	 	  $replace['#info#'] = $info;

   	 	  break;
   	 	}
   	 	
   	 	case "command_configreg.tpl":
   	 	{
		  $this->title = ChFun_configreg_Title;
		  
		  if(isset($other_vars['delete_id']))
		    $info = $this->LTChartCore->del_reg_field($other_vars['delete_id']);

		  if(count($_POST) > 0)
		    $this->LTChartCore->add_reg_field($_POST);

		  $data = $this->LTChartCore->command_tpl_params($template);
		  

		  $replace['#options_text#'] = ChFun_configreg_add_options_text;
		  $replace['#add_text#'] = ChFun_configreg_add_text;
		  $replace['#field_name_text#'] = ChFun_configreg_add_field_name;
		  $replace['#field_name#'] = 'f_name';
		  $replace['#items_text#'] = ChFun_configreg_add_items_text;
		  $replace['#required_text#'] = ChFun_configreg_add_required_text;
		  $replace['#length_text#'] = ChFun_configreg_add_length_text;
		  $replace['#item_name#'] = 'item';
		  $replace['#required_name#'] = 'required';
		  $replace['#length_name#'] = 'lenght';
		  $replace['#options_name#'] = 'options';
		  $replace['#submit#'] = ChFun_configreg_add_submit;
		  		  
	
		  foreach (explode(",",ChFun_user_var_names) as $item)
			$items .= str_replace("#name#",$item, ChFun_configreg_add_items);

		  $replace['#items#'] = $items;


		  
		  
		  $fields_desc = str_replace(array("#var_name#","#var_type#","#var_length#","#required#","#delete#"),
		  						  array(ChFun_configreg_name, ChFun_configreg_type, ChFun_configreg_length, ChFun_configreg_required,ChFun_configreg_delete), ChFun_configreg_Fields_th);
		  if(is_array($data['reg_fields']))
		    foreach($data['reg_fields'] as $field)
		    {
		   	  $del_link = $this->pass_params_via_tpl($template, array('delete_id' => $field->id));
		  	  $fields .= str_replace(array("#var_name#","#var_type#","#var_length#","#required#","#delete#","#del_link#"),
		  						  array($field->var_name, $field->var_type,$field->var_length, $field->required, ChFun_configreg_delete, $del_link),ChFun_configreg_Fields_td);
		    }

		  $replace["#fields_desc#"] = $fields_desc;
	      $replace['#fields#'] = $fields;
	      $replace['#add#'] = $add;
   	 	  break;
   	 	}

   	 	case "command_config.tpl":
   	 	{
//		    /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
		    $data = $this->LTChartCore->command_tpl_params($template);

 	        include_once(LTChart_path."/include/LTChatModVars.inc.php");

			if(count($_POST) > 0)
			  $this->LTChartCore->set_chat_variable($_POST);

			$config = array();
            foreach ($GLOBALS['ConfigVarsInfo'] as $var_name => $info)
 	          if($info['type'] == "int")
 	          {
				$config[$info['category']] .= str_replace(array("#description#", "#value#", "#name#", "#submit#"), array($info['description'], get_ConfVar($var_name), $var_name, LTTpl_config_submit), ChFun_config_FieldInt);
 	          }
			  elseif($info['type'] == "boolean")
			  {
			  	if(get_ConfVar($var_name))	$value = ChTPL_ENABLED;
			  	else 				  	  	$value = ChTPL_Disabled;
			  	
				$config[$info['category']] .= str_replace(array("#description#", "#value#", "#name#", "#submit#"), array($info['description'], $value, $var_name, LTTpl_config_submit), ChFun_config_FieldBoolean);
			  }

 	        foreach ($config as $c_name => $content)
			  $out .= str_replace(array("#name#","#items#"), array($c_name, $content), ChFun_config_category);

		    $this->title = LTTpl_config_title;
		    $replace['#config#'] = $out;
   	 	  break;
   	 	}
   	 	case "command_avatar.tpl":
   	 	{
		  if($other_vars['file_name'] != "")
		    $this->LTChartCore->set_avatar($other_vars['file_name']);
		    
		  $data = $this->LTChartCore->command_tpl_params($template);


		  $avatars_array = array_chunk($data['avatars'], ChFun_avatar_table_td_items * ChFun_avatar_table_tr_items);
		  
		  $page = 0;
		  if(is_numeric($other_vars['page']))
		    $page = (int)$other_vars['page'];

		  $avatars_rows = array_chunk($avatars_array[$page], ChFun_avatar_table_td_items);

		  foreach ($avatars_rows as $row_items)
		  {
			$rows = "";
		    foreach ($row_items as $file_info)
		    {
		      $select_link = $this->pass_params_via_tpl($template, array('file_name' => $file_info['link'], 'page' => $page));
		      
		      if($file_info['owner'])
		        $item = str_replace(array("#link#", "#user#","#LTChatTemplatePath#"), array($file_info['link'], $file_info['owner'], LTChatTemplatePath), ChFun_avatar_item_unavailable);
		      else 
		        $item = str_replace(array("#link#", "#user#","#select_link#","#LTChatTemplatePath#"), array($file_info['link'], $file_info['owner'], $select_link, LTChatTemplatePath), ChFun_avatar_item_available);

			  $rows .= str_replace("#item#",$item,ChFun_avatar_table_td);
		    }
		    $out .= str_replace("#rows#",$rows, ChFun_avatar_table_tr);
		  }
		  $out = str_replace("#data#", $out, ChFun_avatar_table);
		  $replace['#avatars#'] = $out;
		  

		  for($i = 0; $i < count($avatars_rows); $i++)
		  {
		  	 $link = $this->pass_params_via_tpl($template, array('page' => $i));
		  	 if($page == $i)
		  	   $pages .= str_replace(array("#nr#","#link#"), array($i+1, $link), ChFun_avatar_pages_selected);
		  	 else
		  	   $pages .= str_replace(array("#nr#","#link#"), array($i+1, $link), ChFun_avatar_pages_unselected);
		  }
		  $pages = str_replace("#items#", $pages, ChFun_avatar_pages_body);

		  $replace['#avatars_pages#'] = $pages;
   	 			
   	 	  $this->title = LTTpl_avatar_title;
   	 	  break;
   	 	
   	 	}
   	 	case "command_fullhelp.tpl":
   	 	{

		    /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
		    $data = $this->LTChartCore->command_tpl_params($template);

	   	 	$item_tpl = $this->get_tpl("command_fullhelp_item.tpl");
	
	   	 	if(is_array($data['functions']))
			  foreach ($data['functions'] as $command)
			    $items .= str_replace("#item#", $command, $item_tpl);

			$replace['#items#'] = $items;
			$this->title = LTTpl_fullhelp_title;
			$replace['#description#'] = LTTpl_fullhelp_desc;
	   	 	break;
   	 	}
	   	case "command_bug_form.tpl":
	   	{
		    /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
		    $data = $this->LTChartCore->command_tpl_params($template);

			$replace['#ver#'] = Ch_VER;
			$replace['#submit#'] = LTTpl_bug_send;
			$this->title = LTTpl_bug_title;
			break;
	   	}
		case "command_info.tpl":
		    /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
		    $data = $this->LTChartCore->command_tpl_params($template);

			$template = "command_me.tpl";
			$user_name = $other_vars['login'];
			$info_user_set = true;
		case "command_me.tpl":
		    /* pobranie dodatkowych informacji z klasy LTChatCoreFunctions */
		    $data = $this->LTChartCore->command_tpl_params($template);

            if(!$info_user_set)  $user_name = $this->LTChartCore->get_user_name();

			if($this->LTChartCore->get_user_name() == $user_name)
		      $info_user_set = false;

			if(count($_POST) > 0)
			  $err_info = $this->LTChartCore->update_other_fields($_POST);

			if($err_info === LTChatCore_user_error_fill_required)
			  $error = LTTpl_me_error_fill_required;
			elseif ($err_info === LTChatCore_user_error_bad_type)
			  $error = LTTpl_me_error_bad_type;
			
			$replace['#error#'] = $error;
			$user_data = $this->LTChartCore->get_user_by_nick($user_name);

			$post_s = array();
			if(is_array($user_data->other_fields))
			  foreach ($user_data->other_fields as $field)
			  {
			  	eval("\$post_s[\"form{\$field->".LTChat_Main_prefix."users_var_names_id}\"] = \$field->value;");
			  }

			$registration_fields = $this->get_registration_fields($post_s);

			$replace['#other_fields#'] = $registration_fields['other_fields'];

			define(LTTpl_me_reg_date, "Y-m-d G:i:s");
			define(LTTpl_me_last_seen_date, "Y-m-d G:i:s");
		    
			$replace['#registration_date#'] = ($user_data->registered != 0)?date(LTTpl_me_reg_date,$user_data->registered):"No data";
			$replace['#registration_text#'] = LTTpl_me_reg_text;
			
			$replace['#last_seen_value#'] = ($user_data->last_seen != 0)?date(LTTpl_me_last_seen_date,$user_data->last_seen):"No data";
			$replace['#last_seen_text#'] = LTTpl_me_last_seen_text;
			
			$replace['#posted_msg_text#'] = LTTpl_me_posted_msg_text;
			$replace['#posted_msg_value#'] = $user_data->posted_msg;

			$replace['#last_host_text#'] = LTTpl_me_last_host_text;
			$replace['#last_host_value#'] = $user_data->last_host;

			$replace['#last_ip_text#'] = LTTpl_me_last_ip_text;
			$replace['#last_ip_value#'] = $user_data->last_ip;

			if(!$user_data->picture_url)
			  $replace['#picture_url#'] = "./img/avatars/noavatar.gif";
			else
			  $replace['#picture_url#'] = $user_data->picture_url;

		    $this->title = str_replace("#user#",$user_data->nick, LTTpl_me_title);
			$replace['#login#'] = $user_data->nick;

			if($info_user_set)
			  $replace['#submit#'] = "";
			else
			  $replace['#submit#'] = str_replace('#send#',LTTpl_me_send,ChFun_me_submit);

	   		break;
	   		
	   		default:
	   		{
	   			exit;
	   		}
   	 }
   	 return $this->get_tpl($template, $replace);
   }

   function get_chat()
   {
   	 if(!$this->LTChartCore->user_action($this->room))
   	   return $this->get_login_form();
   	 else
   	   return $this->get_tpl('chat_view.tpl');
   }

   function get_shoutbox($sbox_id)
   {
   	 $sbox_id = (int)$sbox_id;

     return $this->get_tpl('shoutbox_view.tpl', array('#send#' => LTTpl_shoutbox_submit, '#message#' => LTTpl_shoutbox_msg, '#login#' => LTTpl_shoutbox_nick, '#sbox_id#' => $sbox_id));
   }
   
   function show_private_chat()
   {
   	 if(!$this->LTChartCore->user_action($this->room))
   	   return $this->get_login_form();
   	 else
   	 {
   	   $this->title = ChFun_prv_Title;
   	   return $this->get_tpl('standard_private_chat_view.tpl');
   	 }
   }
 }
?>