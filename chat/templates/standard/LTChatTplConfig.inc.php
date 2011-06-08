<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
// Styl emotikon
  define("LTChat_emotStyle","<img src='#path#'>");
  define("LTTpl_static_html_tpl","<center><span style='color:red'>#error#</span></center>");

//------------------------ emoticons -----------------------
  define("ChFun_emoticons_Style","\"#info#\" <img src='#path#'><br>");
########################## emoticons #######################

//------------------------ help ----------------------------
// wyglad listy dostepnych komend z helpa
  define("ChFun_help_ListStyle","#commands#<Br>");
// wyglad jezeli uzytkownik wybierze odpowiednią pozycje z helpa
  define("ChFun_help_InfoStyle","<span style='color:green;'>#commands#</span> #except_params_static# #params# #Description#<BR>");
// jezeli pozycja z helpa ma wiecej opcji ktore moze robic kazda opcja ma swoj opis ktorego styl mozna wyswietlic
  define("ChFun_help_DescArStyle","<br><span style='color:green;'>#param#</span> => #Description#");
########################## help #############################

//------------------------ url ------------------------------
  define("ChFun_url_Style","<a href=\"#link#\" title=\"#title#\" target=\"_blank\">#text#</a>");
########################## url ##############################

//------------------------ configrooms ----------------------
  define("ChFun_friend_Show","#friend_from_text#:<br><i>#friend_from#</i><br><br>#friend_to_text#:<br><i>#friend_to#</i><br>");
  define("ChFun_friend_ShowSep",", ");
########################## configrooms ######################

//------------------------ configrooms ----------------------
  define("ChFun_configrooms_OotGroup","<optgroup label=\"#label#\">#options#</optgroup>");
  define("ChFun_configrooms_Ootion","<option value=\"#value#\">#name# (#users_online#) #default#</option>");
########################## configrooms ######################

//------------------------ configreg ------------------------
//'integer', 'float', 'text', 'date', 'select', 'radio', 'textarea'
  define("ChFun_configreg_add_items", "<option value='#name#'>#name#</option>");
  define("ChFun_configreg_Fields_th", "<tr><th>#var_name#</th><th>#var_type#</th><th>#var_length#</th><th>#required#</th><th>#delete#</th></tr>");
  define("ChFun_configreg_Fields_td", "<tr><td align=center>#var_name#</td><td>#var_type#</td><td>#var_length#</td><td>#required#</td><td><a href='#del_link#'>#delete#</a></td></tr>");
########################## configreg ########################

//------------------------ me -------------------------------
  define("ChFun_me_submit","<tr><td colspan=\"2\" align=\"center\"><br><input type=\"submit\" value=\"#send#\"></td></tr>");
########################## me ###############################

//------------------------ ping -----------------------------
  define("ChFun_ping_Separator", "<br>");
########################## ping #############################

  // menu
  define("ChMenuItemActive", "<a href=\"#link#\">#text#</a>");
  define("ChMenuItemInactive", "#text#");
  define("ChMenuItemSeparator", " | ");  
  
//------------------------ config ---------------------------
  define("ChFun_config_FieldInt", "<tr><td><form method=post>#description#<br><input type = text value='#value#' name='#name#'> <input type=submit value='#submit#'></form></td></tr>");
  define("ChFun_config_FieldBoolean", "<tr><td><form method=post>#description#<br><select name='#name#'><option value='1'>true</option><option value='0'>false</option></select>(#value#)<input type=submit value='#submit#'></form></td></tr>");
  define("ChFun_config_category", "<table align=center><tr><td align=center><b>#name#</b></td></tr>#items#</table>");
########################## config ###########################

//------------------------ avatar ---------------------------
  define("ChFun_avatar_item_available", "<table cellspacing=0 cellpadding=0 width=120 border=0 align='center'><tr valign=bottom> 	  <td background='#LTChatTemplatePath#img/av_img/top.gif' height=25 align=center style='color:red;'>#user#</td>	</tr>	<tr valign=middle align=center> 	  <td background='#LTChatTemplatePath#img/av_img/bottom.gif' height=102> 	    <a href='#select_link#'><img border=0 src='#link#'></a>	  </TD>	</TR>	</TABLE>");
  define("ChFun_avatar_item_unavailable", "  <table cellspacing=0 cellpadding=0 width=120 border=0 align='center'>	<tr valign=bottom> 	  <td background='#LTChatTemplatePath#img/av_img/top.gif' height=25 align=center style='color:red;'>#user#</td>	</tr>	<tr valign=middle align=center> 	  <td background='#LTChatTemplatePath#img/av_img/bottom.gif' height=102> 	    <img style='opacity: .5;filter: alpha(opacity=10);-moz-opacity: .5;' border=0 src='#link#'>	  </TD>	</TR>	</TABLE>");
  
  define("ChFun_avatar_table", "<table align=center>#data#</table>");
  define("ChFun_avatar_table_td", "<td>#item#</td>");
  define("ChFun_avatar_table_tr","<tr>#rows#</tr>");

  define("ChFun_avatar_table_td_items",4);
  define("ChFun_avatar_table_tr_items",4);
  define("ChFun_avatar_pages_body","<table align=center><tr>#items#</tr></table>");
  define("ChFun_avatar_pages_unselected","<td><a href='#link#'>#nr#</a></td>");
  define("ChFun_avatar_pages_selected","<td><b>#nr#</b></td>");
########################## avatar ###########################

// login_form.tpl
	  define("ChLoginRooms","<tr><td align=\"center\">#seltext#</td><td><select name='room'>#rooms#</select></td></tr>");
	  define("ChLoginGuest","		  <tr>
		    <td colspan=\"2\"><INPUT type=\"checkbox\" id='guest' name=\"#guest_name#\" onClick=\"guest_change();\" #checked#> #guest#</td>
		  <script>
		    function guest_change()
		    {
		    	var pass = document.getElementById(\"password\");
                var guest = document.getElementById(\"guest\");
		    	
		    	if(guest.checked)
		    	{
		    	  pass.value = \"******\";
		    	  pass.disabled = true;
		    	}
		    	else
		    	{
		    	  pass.value = \"\";
		    	  pass.disabled = false;
		    	}
			}
			guest_change();
		  </script>
		  </tr>
		  ");

  // pola widoczne przy rejestracji oraz przy wyswietlaniu informacji o uzytkowniku 
  define("ChFieldInteger", "<tr><td valign=\"top\">#required# #name#</td><td><input type=\"text\" name=\"#var_name#\" value=\"#value#\"></td></tr>");
  define("ChFieldFloat", "<tr><td valign=\"top\">#required# #name#</td><td><input type=\"text\" name=\"#var_name#\" value=\"#value#\"></td></tr>");
  define("ChFieldDate", "<tr><td valign=\"top\">#required# #name#</td><td><input type=\"text\" name=\"#var_name#\" value=\"#value#\"></td></tr>");
  define("ChFieldRadio", "<tr><td valign=\"top\">#required# #name#</td><td>#options#</td></td>");
  define("ChFieldRadioOption", "<input type=\"radio\" name=\"#var_name#\" value=\"#val#\" #select#> #text#  <br>");
  define("ChFielSelect","<tr><td valign=\"top\">#required# #name#</td><td><select name=\"#var_name#\">#options#</select></td></td>");
  define("ChFielSelectOption","<option value=\"#val#\" #select#>#text#</option>");
  define("ChFielText","<tr><td valign=\"top\">#required# #name#</td><td><input type=\"text\" name=\"#var_name#\" value=\"#value#\" style=\"width:100%\"></input></td></tr>");
  define("ChFielTextarea","<tr><td valign=\"top\">#required# #name#</td><td><textarea name=\"#var_name#\" style=\"width:100%;height:60px;\">#value#</textarea></td></tr>");

?>