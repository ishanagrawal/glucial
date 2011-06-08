<?php

include_once('configs/config.php');
//print_r($_SESSION['user_informations']);
$user = new User();
    
	function getUserInfo($userId)
	{
		$otherUserInfo = $user->fetchRow("id = ?", $userId);

		$GLOBALS['Smarty']->assign('other_user_info', $other_user_info);	
	}

	function getUserListBasedOnMatching($userId)
	{
		required("class.matching.php");
		$matching = new Matching($userId);
		$matchedUsers = $matching->getMatchingUsers();
		$GLOBALS['Smarty']->assign('matchedUsers', $matchedUsers);
	}
if(!empty($_GET['uid'])) {
    //Check whether this user would be able to view other users'profile or not
    $aUser = Array();
    $aUID = Array();
    
    if ($_GET['uid'] == $_SESSION['user_informations']['uid']) {
	
	$lUsers = $user->fetchAll($user->select());
	
	foreach($lUsers->toArray() as $oUser) {
	    
	    $aUser[$oUser['id']] = $oUser;
	    $aUser[$oUser['id']]['status'] = WhoIsOnline::checkUser($oUser['id']);
	    $aUID[] = $oUser['id'];
            
	}
	
        $uid = implode(",", $aUID);
        $GLOBALS['Smarty']->assign('uid', $uid);
        
    }
    
    $user_info = $user->find($_GET['uid'])->current();
    

} 
$GLOBALS['Smarty']->assign('aUser', $aUser);
$GLOBALS['Smarty']->assign('fname', $user_info['fname']);
$GLOBALS['Smarty']->assign('lname', $user_info['lname']);

$GLOBALS['Smarty']->display($template_url);

