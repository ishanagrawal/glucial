<?php
include('../../configs/config.php');

if ($_SESSION['user_informations']['uid'] == '') {
    
    echo 'Session Time Out!';

} else {
            
    if ($_POST['msg'] == 'ping_host') {
        
        if (WhoIsOnline::recordUser($_SESSION['user_informations']['uid'])){
            echo 'success';
        }
        
    } else if ($_POST['msg'] == 'ping_friends') {
        
        echo 'failed';
        
    } else if ($_POST['msg'] == 'search_friends') {
        echo 'failed';
    } else {
        echo 'failed';
    }

}
?>