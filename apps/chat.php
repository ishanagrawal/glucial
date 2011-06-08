<?php
include_once('configs/config.php');

$chat = new Chat();
if (!empty($_POST['start_chat'])) {
    
    require_once '../libs/tokbox/API_Config.php';
    require_once '../libs/tokbox/OpenTokSDK.php';
    require_once '../libs/tokbox/SessionPropertyConstants.php';
    
    $apiObj = new OpenTokSDK(API_Config::API_KEY, API_Config::API_SECRET);
    
    if(!empty($_REQUEST['sessionId'])) {
        
        $sessionId = $_REQUEST['sessionId'];
    
    } else {
        
        $session = $apiObj->create_session($_SERVER["REMOTE_ADDR"]);
        $sessionId = $session->getSessionId();
    
    }
    
    $GLOBALS['Smarty']->assign("opentok_sessionid",$session->getSessionId());
    $GLOBALS['Smarty']->assign("opentok_token",$apiObj->generate_token());
    $data = array(
        'id'  => '',
        'session_id'  => $session->getSessionId(),
        'token'  => $apiObj->generate_token(),
        'topic_id'  => "",
        'user_id1'  => $_SESSION['user_informations']['uid'],
        'user_id2'  => $_POST['target_uid'],
        'comments'  => '',
        'start_time'  => date('Y-m-d h-m-s'),
        'end_time'  => '',
        'is_accepted' => 'y'
    );
    
    $chat->insert($data);
    
} else if (!empty($_POST['accept_chat'])) {
    
    $row = $table->fetchRow(
        "user_id1 = " . $_POST['chat_partner_id'] . " AND user_id2 = " . $_SESSION['user_id'] . " AND end_time = '' "
    );
    
    if (empty($row)) {
        Global_Functions::handle_err(2);    
    } else {
        
        $GLOBALS['Smarty']->assign("opentok_sessionid", $row['session_id']);
        $GLOBALS['Smarty']->assign("opentok_token",$row['token']);
            
    }
    
} else {
    
    Global_Functions::handle_err(2);

}

$GLOBALS['Smarty']->display($template_url);

?>