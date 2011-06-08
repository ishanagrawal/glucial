<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/
function make_menu($items)
{
  $out = "<TABLE border=\"0\" align=\"center\" width=\"90%\" cellpadding=\"0\" cellspacing=\"0\">";

  if(is_array($items))
    foreach($items as $item)
    {
      if($item['info'] == 'sub_disabled')
      	$out .= "		<tr><Td class=\"category_menu_item\">&nbsp;<IMG style='padding-left:3px;padding-bottom:2px;' src=\"http://www.ajaxchat.org/img/menu/arr_sub.bmp\"> <span style=\"color:#aaaaaa;font-size:11px;\">{$item['title']}</td></tr>";
      elseif($item['info'] == 'selected')
      	$out .= "		<tr><Td class=\"category_menu_item\">&nbsp;<IMG style='padding-left:3px;padding-bottom:2px;' src=\"http://www.ajaxchat.org/img/menu/arr_sub.bmp\"> <span style=\"color:blue;font-size:11px;\">{$item['title']}</td></tr>";
      elseif($item['info'] == 'main')
        $out .= "		<tr><Td class=\"category_menu_item\"><IMG src=\"./img/install/menu/arr.bmp\" style=\"padding-bottom:2px;\"> <a href=\"{$item['link']}\">{$item['title']}</a></td></tr>";
      else 
        $out .= "		<tr><Td class=\"category_menu_item\">&nbsp;<IMG style='padding-left:3px;padding-bottom:2px;' src=\"./img/install/menu/arr_sub.bmp\"> <a href=\"{$item['link']}\">{$item['title']}</a></td></tr>";
    }
  
  $out .= "</TABLE>";

  return $out;
}


define("INSTALL_TPL", "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<head>
<meta HTTP-EQUIV=\"content-type\" CONTENT=\"text/html; charset=UTF-8\">

<STYLE>
  *{
   font-size:12px;
   font-family: Verdana;
  }

  table.main_tab
  {
   font-size:14px;
   font-family: Verdana;
  }
  
  td.main_tab_title
  {
    font-weight:bold;
    font-size:11px;
    padding-left:2px;
    color:#1C5679;
  }

 .main_menu a:link		{ color: #FFFFFF; text-decoration: underline;  } 
 .main_menu a:hover		{ color: #FFFFFF; text-decoration: underline; }
 .main_menu a:visited	{ color: #FFFFFF; text-decoration: underline; }
 .main_menu a:active		{ color: #FFFFFF; text-decoration: underline; }

  td.main_menu
  {
	background-image: url('./img/install/menu/menu_bg.bmp');
	width:77px;
	height:24px;
	color:white;
	font-weight:bold;
	padding-left:3px;
	padding-right:3px;
	font-size:11px;
  }
  
  a:link
  {
    color:#1C5679;
    font-size:12px;
  }

  .category_menu_item
  {
    border-bottom:1px solid #EBEBEB;
    height:23px;
  }
  .category_menu_item a { color:#1C5679;font-size:11px;text-decoration: none; }
  input.login_form
  {
    font-size:13px;
    width:186px;
    height:20px;
  }
  span.login_form
  {
	font-size:11px;
	color:#7F7F7F;
	font-weight:bold;
  }
  td.login_form
  {
	font-size:11px;
  }

  </STYLE>

<TITLE>#title#</TITLE>
<meta name=\"description\" content=\"AjaxChat is a high performance php-based chat server software for a live chat-room or -module on every php-based site.\"/>
<meta name=\"keywords\" content=\"chat chat-module live-chat chat-room phpBB-chat postnuke-chat phpnuke-chat yabbse-chat vBulletin-chat phpkit-chat ThWBoard-chat vkpMx-chat\" />
<meta name=\"language\" content=\"en\" />
<meta name=\"robots\" content=\"index,follow\">
<META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"NO-CACHE\">
<LINK REL=\"SHORTCUT ICON\" HREF=\"./img/install/shortcut.bmp\">
</head>
<body>
<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" width=\"580\" style=\"padding-top:20px;\">
  <tr>
    <td width=\"200\" valign=\"top\">
    <center><img src=\"http://www.ajaxchat.org/img/logo.bmp\"></center><br>
    
<TABLE class=\"main_tab\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"200px;\">
  <tr>
    <td style=\"background-image: url(./img/install/main/main_lt.bmp); width:3px; height:21px;\"></td>
    <td style=\"background-image: url(./img/install/main/main_t_bar.bmp);\" class=\"main_tab_title\"> #categories#</td>
    <td style=\"background-image: url(./img/install/main/main_t_bar.bmp);padding-right:2px;\" align=\"right\"><IMG src=\"./img/install/main/main_arrow.gif\"></td>
    <td style=\"background-image: url(./img/install/main/main_rt.bmp); width:5px; height:21px;\"></td>
  </tr>
  <tr>
    <td style=\"background-image: url(./img/install/main/main_l_bar.bmp); width:3px; height:21px;\"></td>
    <td colspan=\"2\">
    #menu#
    </td>
    <td style=\"background-image: url(./img/install/main/main_r_bar.bmp); width:5px; height:21px;\"></td>
  </tr>
  <tr>
    <td style=\"background-image: url(./img/install/main/main_lb.bmp); width:3px; height:5px;\"></td>
    <td colspan=\"2\" style=\"background-image: url(./img/install/main/main_b_bar.bmp);\"></td>
    <td style=\"background-image: url(./img/install/main/main_rb.bmp);height:5px;\"></td>
  </tr>
</TABLE>
    </td>
    <td valign=\"top\"  width=\"450\">
	  <br>
		<TABLE class=\"main_tab\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"450\">
		  <tr>
		    <td style=\"background-image: url(./img/install/main/main_lt.bmp); width:3px; height:21px;\"></td>
		    <td style=\"background-image: url(./img/install/main/main_t_bar.bmp);\" class=\"main_tab_title\"> #title#</td>
		    <td style=\"background-image: url(./img/install/main/main_t_bar.bmp);padding-right:2px;\" align=\"right\"><IMG src=\"./img/install/main/main_arrow.gif\"></td>
		    <td style=\"background-image: url(./img/install/main/main_rt.bmp); width:5px; height:21px;\"></td>
		  </tr>
		  <tr>
		    <td style=\"background-image: url(./img/install/main/main_l_bar.bmp); width:3px; height:21px;\"></td>
		    <td colspan=\"2\" style=\"padding:4px;font-size:13px;background-image: url('./img/install/logo_bg.jpg');background-repeat: no-repeat;background-position: top right\">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;#text#
		    </td>
		    <td style=\"background-image: url(./img/install/main/main_r_bar.bmp); width:5px; height:21px;\"></td>
		  </tr>
		  <tr>
		    <td style=\"background-image: url(./img/install/main/main_lb.bmp); width:3px; height:5px;\"></td>
		    <td colspan=\"2\" style=\"background-image: url(./img/install/main/main_b_bar.bmp);\"></td>
		    <td style=\"background-image: url(./img/install/main/main_rb.bmp);height:5px;\"></td>
		  </tr>
		</TABLE>
    </td>
  </tr>
</table>
</body>");
  	
  	define("LTChatIn_installation_text","This step-by-step guide provides instructions for installing Chat service on servers running on any major Operating System (Windows<sup>&#174;</sup> or Linux) with and SQL database system, one of: MySQL (3.22 or higher), PostgreSQL 7.0.3 or higher , PHP (4.0.3 and above) with support for the database you intend to use above.<br><br> #proceed#");

  	define("LTChatIn_install_st1","
    	  		<center><span style='color:red'>#ERROR#</span></center>
  		<form action='./install.php?branch=st2' method=post>
    		<table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" border=\"0\" >
					<tr>
						<td  align=\"right\" width=\"30%\">#language_text#: </td>
						<td ><select name=\"lang\">#lang_options#</select></td>
					</tr>
					<tr>
						<td  align=\"right\">#source_type_text#: </td>
						<td ><select name=\"datasource\"><option value=\"mysql\">MySQL</option><option value=\"postgres\" disabled>PostgreSQL</option><option value=\"files\" disabled>Files</option></select></td>
					</tr>
					<tr>
						<td  align=\"right\">#domain_name_text#: </td>
						<td ><input type=\"text\" name=\"servername\" value=\"#http_host#\" disabled  /></td>
					</tr> 
					<tr>
						<td  align=\"right\">#server_port_text#: </td>
						<td ><input type=\"text\" name=\"serverport\" value=\"#http_port#\" disabled /></td>
					</tr>
					<tr>
						<td  align=\"right\">#script_path_text#: </td>
						<td ><input type=\"text\" name=\"scriptpath\" value=\"#script#\" /></td>
					</tr>
					#proceed_submit#
					</table></form>");

  	define("LTChatIn_install_st2","
    	  		<form action='./install.php?branch=st3' method=post>
    	  		<center><span style='color:red'>#ERROR#</span></center>
  		<table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" border=\"0\" >
					<tr>
						<td  align=\"right\">#db_hostname_text#: </td>
						<td ><input type=\"text\" name=\"dbhost\" value=\"#dbhost#\" /></td>
					</tr>
					<tr>
						<td  align=\"right\">#db_name_text#: </td>
						<td ><input type=\"text\" name=\"dbname\" value=\"#dbname#\" /></td>
					</tr>
					<tr>
						<td  align=\"right\">#db_user_name_text#: </td>
						<td ><input type=\"text\" name=\"dbuser\" value=\"#dbuser#\" /></td>
					</tr>
					<tr>
						<td  align=\"right\">#db_password_text#: </td>
						<td ><input type=\"password\" name=\"dbpassword\" value=\"#dbpassword#\" /></td>
					</tr>
					<tr>
						<td  align=\"right\">#db_prefix_text#: </td>
						<td ><input type=\"text\" name=\"prefix\" value=\"lt_\" /></td>
					</tr>
					#proceed_submit#
				</table><input type='hidden' name='data' value='#data_value#'></form>");
	

    	define("LTChatIn_install_st3","
<center><span style='color:red'>#ERROR#</span></center>    	  		<form action='./install.php?branch=st4' method=post>
  		<table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" border=\"0\" >
  					<tr>
						<td  align=\"right\">#admin_username_text#: </td>
						<td ><input type=\"text\" name=\"admin_name\" value=\"\" /></td>
					</tr>
					<tr>
						<td  align=\"right\">#admin_password_text#: </td>
						<td ><input type=\"password\" name=\"admin_pass1\" value=\"\" /></td>
					</tr>
					<tr>
						<td  align=\"right\">#admin_password_conf_text# : </td>
						<td ><input type=\"password\" name=\"admin_pass2\" value=\"\" /></td>
					</tr>
					#proceed_submit#</table><input type='hidden' name='data' value='#data_value#'></form>");
    	
    	define("LTChatIn_install_st4","
  		<form action='./install.php?branch=st5' method=post>
    		<table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" border=\"0\" >
					<tr>
						<td align=\"right\" width=50%><b>#language_text#: </td>
						<td >#lang#</td>
					</tr>
					<tr>
						<td  align=\"right\"><b>#source_type_text#: </td>
						<td >#datasource#</td>
					</tr>
					<tr>
						<td  align=\"right\"><b>#domain_name_text#: </td>
						<td >#http_host#</td>
					</tr> 
					<tr>
						<td  align=\"right\"><b>#server_port_text#: </td>
						<td >#http_port#</td>
					</tr>
					<tr>
						<td  align=\"right\"><b>#script_path_text#: </td>
						<td >#scriptpath#</td>
					</tr>
					<tr>
						<td  align=\"right\"><b>#db_hostname_text#: </td>
						<td >#dbhost#</td>
					</tr>
					<tr>
						<td  align=\"right\"><b>#db_name_text#: </td>
						<td >#dbname#</td>
					</tr>
					<tr>
						<td  align=\"right\"><b>#db_user_name_text#: </td>
						<td >#dbuser#</td>
					</tr>
					<tr>
						<td  align=\"right\"><b>#db_prefix_text#: </td>
						<td >#prefix#</td>
					</tr>
  					<tr>
						<td  align=\"right\"><b>#admin_username_text#: </td>
						<td >#admin_name#</td>
					</tr>
					#proceed_submit#</table><input type='hidden' name='data' value='#data_value#'></form>");

    	define("LTChatIn_install_st5","<center><span style='color:red'>#ERROR#</span>#info#</center>
        	  	<form action='./install.php?branch=st5' method=post>
    		<table width=\"100%\" cellpadding=\"2\" cellspacing=\"1\" border=\"0\" >
					#proceed_submit#
					</table>
					<input type='hidden' name='data' value='#data_value#'>
				</form>");
    	
define("LTChatIn_mysql_dump","
CREATE TABLE `#prefix#chat_config` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `var_name` varchar(40) NOT NULL default '',
  `var_value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
);


CREATE TABLE `#prefix#friends` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `from_users_id` int(11) NOT NULL default '0',
  `to_users_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);

 

CREATE TABLE `#prefix#ignore` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `from_users_id` int(11) NOT NULL default '0',
  `to_users_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);


CREATE TABLE `#prefix#private_talk` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `users_id_from` int(11) NOT NULL default '0',
  `users_id_to` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `time` int(11) NOT NULL default '0',
  `delivered_from` enum('0','1') NOT NULL default '0',
  `delivered_to` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
);


CREATE TABLE `#prefix#rooms` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `room_cat` varchar(40) NOT NULL default '',
  `room_name` varchar(40) NOT NULL default '',
  `default` enum('1','0') NOT NULL default '0',
  PRIMARY KEY  (`id`)
);


CREATE TABLE `#prefix#shoutbox` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `nick` varchar(40) NOT NULL default '',
  `shout_id` int(11) NOT NULL default '0',
  `text` varchar(255) NOT NULL default '',
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);


CREATE TABLE `#prefix#talk` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(40) NOT NULL default '',
  `room` varchar(40) NOT NULL default '',
  `text` varchar(255) NOT NULL default '',
  `time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);


CREATE TABLE `#prefix#users` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `nick` varchar(32) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `rights` enum('Admin','Guest','Standard') NOT NULL default 'Standard',
  `picture_url` varchar(255) default NULL,
  `registered` int(11) NOT NULL default '0',
  `posted_msg` int(11) NOT NULL default '0',
  `kicked` enum('0','1') NOT NULL default '0',
  `reason` varchar(255) NOT NULL default '',
  `last_seen` int(11) NOT NULL default '0',
  `last_host` varchar(20) NOT NULL default '',
  `last_ip` varchar(16) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nick` (`nick`)
);


CREATE TABLE `#prefix#users_var` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `#prefix#users_var_names_id` int(11) NOT NULL default '0',
  `#prefix#users_id` int(11) NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
);


CREATE TABLE `#prefix#users_var_names` (
  `chat_id` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `var_name` varchar(255) NOT NULL default '',
  `var_type` enum('integer','float','text','date','select','radio','textarea') NOT NULL default 'integer',
  `var_length` int(11) NOT NULL default '0',
  `options` text,
  `required` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
);


CREATE TABLE `#prefix#who_is_online` (
  `chat_id` int(11) NOT NULL default '0',
  `who_id` int(11) NOT NULL auto_increment,
  `users_id` int(11) NOT NULL default '0',
  `online` enum('0','1') NOT NULL default '0',
  `room` varchar(40) NOT NULL default '',
  `action_time` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`who_id`)
);");
    	
    	
?>