<?php

session_start();
$dotPosition = strpos($_SERVER['REQUEST_URI'], ".");
$fileName = substr($_SERVER['REQUEST_URI'], 15, $dotposition - 15);
$templateFile = $fileName . '.tpl';

//define("DOCUMENT_ROOT", getenv("DOCUMENT_ROOT"));
$GLOBALS = Array();
$GLOBALS['root_directory'] = getenv("DOCUMENT_ROOT") . DIRECTORY_SEPARATOR . 'binhngoc' . DIRECTORY_SEPARATOR;
$GLOBALS['app_directory'] = $GLOBALS['root_directory'] . 'apps' . DIRECTORY_SEPARATOR;
$GLOBALS['lib_directory'] = $GLOBALS['root_directory'] . 'libs' . DIRECTORY_SEPARATOR;
$GLOBALS['model_directory'] = $GLOBALS['app_directory'] . 'model' . DIRECTORY_SEPARATOR;
$GLOBALS['config_directory'] = $GLOBALS['app_directory'] . 'configs' . DIRECTORY_SEPARATOR;
$GLOBALS['view_directory'] = $GLOBALS['app_directory'] . 'views' . DIRECTORY_SEPARATOR;
if ($_SESSION['user_informations']['uid'] != '') {
    
	$GLOBALS['Smarty']->assign('uid', $_SESSION['user_informations']['uid']);
	$GLOBALS['Smarty']->assign('is_login', 'y');
	$user = new User();
	
	$user_info = $user->fetchRow("id = ?", $_SESSION['user_informations']['uid']);
	$GLOBALS['Smarty']->assign('user_info', $user_info);
	WhoIsOnline::recordUser($_SESSION['user_informations']['uid']);
	
} else {
	
	//redirect all access to inaccessible pages
	if ($fileName == 'chat') {
		header( 'Location: ' . $GLOBALS['app_directory'] . '/home.html' ) ;
	}

	$GLOBALS['Smarty']->assign('is_login', 'n');
	
}

//Smarty Configuration


include_once($GLOBALS['root_directory'] . 'libs/smarty/Smarty.class.php');

$GLOBALS['Smarty'] = new Smarty;
$GLOBALS['Smarty']->template_dir = $GLOBALS['root_directory'] . 'apps' . DIRECTORY_SEPARATOR  . 'views' . DIRECTORY_SEPARATOR;
$GLOBALS['Smarty']->compile_dir = $GLOBALS['root_directory'] . 'libs' . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'templates_c' . DIRECTORY_SEPARATOR;
$GLOBALS['Smarty']->cache_dir = $GLOBALS['root_directory'] . 'libs' . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
$GLOBALS['Smarty']->configs_dir = $GLOBALS['root_directory'] . 'apps' . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR;
//Set include path to easily load Zend Components
//for Window server
//$path = str_replace("/", "\\", DOCUMENT_ROOT . '/conveee/libs/');

//For Linux server
set_include_path(get_include_path() . PATH_SEPARATOR . $GLOBALS['lib_directory']);

//Set up of environment - Still not very sure what does it do
//defined('APPLICATION_PATH') || define('APPLICATION_PATH', DOCUMENT_ROOT . '/conveee/apps/');
//set_include_path(implode(PATH_SEPARATOR, array(
//    realpath(APPLICATION_PATH . '/../library'),
//    get_include_path(),
//)));
//require_once 'Zend/Application.php';

//Zend Framework Loader
include_once($GLOBALS['root_directory'] . 'libs/Zend/Loader.php');


//Database Connection
Zend_Loader::loadClass('Zend_Db'); 
Zend_Loader::loadClass('Zend_Db_Table');
Zend_Loader::loadClass('Zend_Db_Table_Abstract');

$GLOBALS['db_info'] = array(
   'host' => 'glucial.db.7868385.hostedresource.com',
   'username' => 'glucial',
   'password' => 'Conveee101',
   'dbname' => 'glucial'
);
//print_r($GLOBALS['db_info']);
$GLOBALS['db'] = Zend_Db::factory('PDO_Mysql',$GLOBALS['db_info']);
$GLOBALS['db']->getConnection();
Zend_Db_Table::setDefaultAdapter($GLOBALS['db']);

//include relevant models into the application
if (file_exists($GLOBALS['config_directory'] . 'global_functions.php'))
{
	require_once $GLOBALS['config_directory'] . 'global_functions.php';
        
}

if (file_exists($GLOBALS['config_directory'] . 'WhoIsOnline.class.php'))
{
	require_once $GLOBALS['config_directory'] . 'WhoIsOnline.class.php';
        
}

if (file_exists($GLOBALS['model_directory'] . 'User.class.php'))
{
	require_once $GLOBALS['model_directory'] . 'User.class.php';
        
}

if (file_exists($GLOBALS['model_directory'] . 'Chat.class.php'))
{
	require_once $GLOBALS['model_directory'] . 'Chat.class.php';
        
}

if (file_exists($GLOBALS['model_directory'] . 'Interest.class.php'))
{
	require_once $GLOBALS['model_directory'] . 'Interest.class.php';
        
}

if (file_exists($GLOBALS['model_directory'] . 'Topic.class.php'))
{
	require_once $GLOBALS['model_directory'] . 'Topic.class.php';
        
}

if (file_exists($GLOBALS['model_directory'] . 'Notification.class.php'))
{
	require_once $GLOBALS['model_directory'] . 'Notification.class.php';
        
}

$dotposition = strpos($_SERVER['REQUEST_URI'], ".");
$template_url = substr($_SERVER['REQUEST_URI'], 15, $dotposition - 15) . ".tpl";
