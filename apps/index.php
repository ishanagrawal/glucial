<?php

include_once('configs/config.php');
$user = new User();
//print_r($options);
//print_r($GLOBALS['db_info']);
//$user->postulate_table($GLOBALS['db_info']);
//$sql = "DROP `user`";
//mysql_query($sql);
//require_once '../libs/tokbox/API_Config.php';
//require_once '../libs/tokbox/OpenTokSDK.php';
//require_once '../libs/tokbox/SessionPropertyConstants.php';
//
//$apiObj = new OpenTokSDK(API_Config::API_KEY, API_Config::API_SECRET);
//
//if(!empty($_REQUEST['sessionId'])) {
//    
//    $sessionId = $_REQUEST['sessionId'];
//
//} else {
//    
//    $session = $apiObj->create_session($_SERVER["REMOTE_ADDR"]);
//    $sessionId = $session->getSessionId();
//
//}
//
//$GLOBALS['Smarty']->assign("opentok_sessionid",$session->getSessionId());
//$GLOBALS['Smarty']->assign("opentok_token",$apiObj->generate_token());

//this is a table row array users
$ngoc = $user->find(1);
$GLOBALS['Smarty']->display($template_url);

//defined('APPLICATION_PATH')
//    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
