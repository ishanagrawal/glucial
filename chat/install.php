<?
 /**************************************************
  * AjaxChat.org - PHP Free Live Chat Service      *
  * @copyright  Distributed under the BSD license  *
  * @author     2006 Lukasz Tlalka                 *
  * @link       http://www.ajaxchat.org            *
  **************************************************/

  include_once("./include/LTChatConfig.php");

  include_once(LTChart_path."/include/LTChatInstallation.php");
  
  if(!defined ("LTChat_Main_datasource"))
  {
  	define("LTChatIn_TERMS","Terms of use");
  	define("LTChatIn_INSTALLATION","Installation");
  	  define("LTChatIn_INSTALLATION_st1","Basic configuration");
  	  define("LTChatIn_INSTALLATION_st2","Data source set");
  	  define("LTChatIn_INSTALLATION_st3","Admin account set");
  	  define("LTChatIn_INSTALLATION_st4","Data overview");
  	  define("LTChatIn_INSTALLATION_st5","Saving");

  	$items['installation'] = array(	'title' => LTChatIn_INSTALLATION,
  									'link' => "./install.php?branch=installation",
  									'info' => 'main');

  	$items['install_st1'] = array(	'title' => "1) ".LTChatIn_INSTALLATION_st1,
  									'info' => 'sub_disabled');

  	$items['install_st2'] = array(	'title' => "2) ".LTChatIn_INSTALLATION_st2,
  									'info' => 'sub_disabled');
  									
  	$items['install_st3'] = array(	'title' => "3) ".LTChatIn_INSTALLATION_st3,
  									'info' => 'sub_disabled');

  	$items['install_st4'] = array(	'title' => "4) ".LTChatIn_INSTALLATION_st4,
  									'info' => 'sub_disabled');
  									
  	$items['install_st5'] = array(	'title' => "5) ".LTChatIn_INSTALLATION_st5,
  									'info' => 'sub_disabled');

  	$items['terms']		 = array(	'title' => LTChatIn_TERMS,
  									'link' => "http://www.ajaxchat.org/terms.html",
  									'info' => 'main');

    $INFO['#http_host#'] = $_SERVER['HTTP_HOST'];

  	if(eregi("(.*)/",$_SERVER['SCRIPT_NAME'], $reg))
  	  $INFO['#script#'] = $reg[1];

  	$INFO['#http_port#'] = $_SERVER['SERVER_PORT'];
	$INFO['#dbhost#'] = "";
	$INFO['#dbname#'] = "";
	$INFO['#dbuser#'] = "";
	$INFO['#dbpassword#'] = "";
	$INFO['#datasource_error#'] = "";
	  	
	
  	define("LTChatIn_lang_text","Language");
    define("LTChatIn_source_type","Data source type");
  	$REPLACE['#source_type_text#'] = LTChatIn_source_type;
  	$REPLACE['#domain_name_text#'] = "Domain name";
  	$REPLACE['#server_port_text#'] = "Server port";
  	$REPLACE['#script_path_text#'] = "Script path";
  	$REPLACE['#admin_username_text#'] = "Administrator username";
  	$REPLACE['#admin_password_text#'] = "Administrator password";
  	$REPLACE['#admin_password_conf_text#'] = "Administrator password [ Confirm ]";
  	$REPLACE['#db_hostname_text#'] = "Database server hostname / DSN";
  	$REPLACE['#db_name_text#'] = "Your database name";
  	$REPLACE['#db_user_name_text#'] = "Database username";
  	$REPLACE['#db_password_text#'] = "Database password";
  	$REPLACE['#db_prefix_text#'] = "Prefix for tables in database";

  	$out = LTChatIn_installation_text;
  	$REPLACE['#title#'] = LTChatIn_INSTALLATION;

  	$data = array();
  	if($_POST['data'] != '')  $data = unserialize(urldecode($_POST['data']));
    unset($_POST['data']);
  	$data = array_merge($data, $_POST);
  	$REPLACE['#data_value#'] = urlencode(serialize($data));

  	
  	foreach ($data as $k => $v)
  	  $INFO["#{$k}#"] = $v;

	if($_GET['branch'] == 'st3')
	{
		if($data['datasource'] == "mysql")
		{
		  $conn = @mysql_connect($data['dbhost'],$data['dbuser'],$data['dbpassword']) or $info2 = mysql_error();
		  if($conn)	mysql_select_db($data['dbname']) or $info2 = mysql_error();

		  if($info2)
		    $_GET['branch'] = 'st2';
		}
	}

	if($_GET['branch'] == 'st2')
	{
		  define("LTChatIn_bad_source_type","This data source is not avaliable in this version.");
		  if($data['datasource'] != "mysql")
		  {
		    $info2 = LTChatIn_bad_source_type;
		    $_GET['branch'] = 'st1';
		  }
	}

  	if($_GET['branch'] == 'st4')
  	{
  	  if($data['admin_pass1'] != $data['admin_pass2'])
	  {
	  	$info2 = "Administrator paswords doesnt mach.";
	  	$_GET['branch'] = 'st3';
	  }
  	}

	
	if($_GET['branch'] == 'st5')
	{
      if(is_writeable("./include/LTChatMainConfig.inc.php"))
	  {

	  	$available_items = array('lang', 'datasource','servername','serverport','scriptpath','dbhost','dbname','dbuser','dbpassword','prefix');
	  	
	  	foreach ($data as $name => $value)
	  	 foreach ($available_items as $item)
	  	   if($name == $item)
	  		 $define_items .= "	define(\"LTChat_Main_{$name}\",\"$value\");\n";

	  	$file_content = str_replace("#items#", $define_items, '<?
	define("LTChat_Main_CHAT_ID","0");
#items#?>');

	  	if($data['datasource'] == 'mysql')
	  	{
			$conn = mysql_connect($data['dbhost'],$data['dbuser'],$data['dbpassword']) or die(mysql_error());
			mysql_select_db($data['dbname']) or die(mysql_error());

	  		$sql_ar = explode(";",LTChatIn_mysql_dump);
	  		foreach ($sql_ar as $query)
	  		{
	  		  $query = str_replace("#prefix#",$data['prefix'], $query);
	  		  mysql_query($query);
	  		}

	  		$nick = addslashes(stripslashes($data['admin_name']));
	  		$pass = addslashes(stripslashes($data['admin_pass1']));

	  		mysql_query("INSERT INTO `{$data['prefix']}users` (`nick` , `password` , `rights` , `registered`) VALUES ( '{$nick}', '{$pass}', 'Admin', '".time()."');") or die(mysql_error());
	  		  
		   if (!$handle = fopen("./include/LTChatMainConfig.inc.php", 'w'))
		     die("Cannot open file (\"./include/LTChatMainConfig.inc.php\")");

		   if (fwrite($handle, $file_content) === FALSE)
		     die("Cannot open file (\"./include/LTChatMainConfig.inc.php\")");
 	  
		   $REPLACE['#info#'] = "Installation complet";
		   fclose($handle);
	  	}
	  	else 
	  	{
		  die("Installation error");
	  	}
	  }
	  else 
	  {
	  	$REPLACE['#info#'] = '';
	  	$info2 = "Change permissions to file \"./include/LTChatMainConfig.inc.php\" so that it will be writeable";
	  }
	}

	$REPLACE['#ERROR#'] = $info2;

    switch ($_GET['branch'])
    {      
      case "st1":
  		$out = LTChatIn_install_st1;
        $items['install_st1']['info'] = 'selected';
  		$REPLACE['#title#'] = LTChatIn_INSTALLATION_st1;
      break;

      case "st2":
  		$out = LTChatIn_install_st2;
        $items['install_st2']['info'] = 'selected';
  		$REPLACE['#title#'] = LTChatIn_INSTALLATION_st2;
      break;
      
      case "st3":
  		$out = LTChatIn_install_st3;
        $items['install_st3']['info'] = 'selected';
  		$REPLACE['#title#'] = LTChatIn_INSTALLATION_st3;
      break;

      case "st4":
  		$out = LTChatIn_install_st4;
        $items['install_st4']['info'] = 'selected';
  		$REPLACE['#title#'] = LTChatIn_INSTALLATION_st4;
      break;

      case "st5":
		$out = LTChatIn_install_st5;
		
        $items['install_st5']['info'] = 'selected';
  		$REPLACE['#title#'] = LTChatIn_INSTALLATION_st5;
      break;
    }

    define("LTChatIn_lang_options", "<option value='#value#'>#name#</option>");
    define("LTChatIn_CATEGORIES", "Categories");
    define("LTChatIn_proceed", "<div align=right><a href='./install.php?branch=st1'><img border=0 src='./img/install/proceed.gif'></a></div>");
    define("LTChatIn_proceed_submit", "
					<tr> 
					  <td align=\"right\" colspan=\"2\"><input type='image' src='./img/install/proceed.gif' /></td>
					</tr>");

	$tpl = INSTALL_TPL;

	// pobranie jezyków
	if ($handle = opendir('./lang/'))
	{
	   while (false !== ($file = readdir($handle)))
	   {
	       if (is_dir("./lang/{$file}") && $file != "." && $file != "..")
	       {
	       	  $lang_options .= str_replace(array("#value#","#name#"), array($file,$file), LTChatIn_lang_options);
	       }
	   }
	   closedir($handle);
	}
//	
	## pobranie jezykow
	$REPLACE['#menu#'] = make_menu($items);
	$REPLACE['#categories#'] = LTChatIn_CATEGORIES;
	$REPLACE['#language_text#'] = LTChatIn_lang_text;
	$REPLACE["#lang_options#"] = $lang_options;
	$REPLACE["#proceed#"] = LTChatIn_proceed;
	$REPLACE["#proceed_submit#"] = LTChatIn_proceed_submit;

	$out = strtr($out,$REPLACE);
  	$out = strtr($out,$INFO);
  	
  	$REPLACE['#text#'] = $out;
  	
	
	echo strtr($tpl,$REPLACE);
  }
  else 
  {
  	
    header("Location: ./");
    exit;
  }
?>