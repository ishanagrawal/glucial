<?php 
class whoIsOnline { 
     
    var $time_to_remain_online; 
    var $max_time_online; 
     
    function __construct() {
		echo "obj created";
	} 
     
    function setSessionTime($mins) { 
        $this->time_to_remain_online = time() + ($mins * 60); 
        $this->max_time_online = $mins * 60; //cleanup time 
		echo "\n<br>session time funtion working";
    } 
    function isOnline($user_id) { 
        $check = false; 
        $a = mysql_query("SELECT user_name FROM `online` WHERE user_id=$user_id LIMIT 0,1"); 
		echo "<br>user_id".$user_id;
		echo "<br>debug.info".$a;
        if($a) { 
            if(mysql_num_rows($a) > 0) { 
                $check = true; 
            } 
            mysql_free_result($a); 
        } 
        return $check; 
    } 
	
    function getAllOnlineUsers() { 
        $check = false; 
		//add a timestamp condition
        $a = mysql_query("SELECT user_name FROM online where UNIX_TIMESTAMP() - log_time > 50"); 
		//echo "<br>user_id".$user_id;
		//echo "<br>debug.info".$a;
		while ($row = mysql_fetch_assoc($a)) {
		echo "\n<br>currently online user: ".$row['user_name'];
		}
    } 
	
    function recordUser($glucial_user_id) { 
		echo "\n<br>reaches inside recordUser";
        global $CURUSER; 
		echo "\n<br>current user is present:".$CURUSER['glucial_user_id'];
        //check if user is not guest 
        if(array_key_exists('glucial_user_id',$CURUSER)) { 
            //first time visit? 
			echo "key exists";
            $tco = $this->time_to_remain_online; 
            if(!isset($_SESSION['user_online']) || ($_SESSION['user_online'] - time()) <=0) { 
                if($this->isOnline($CURUSER['glucial_user_id'])) { 
                    mysql_query("UPDATE `online` SET log_time=$tco WHERE user_id=$CURUSER[glucial_user_id]"); 
                } 
                else { 
                    mysql_query("INSERT INTO `online` (`user_id`, `user_name`, `log_time`) VALUES($CURUSER[glucial_user_id],'$CURUSER[glucial_user]',$tco)");
                } 
                $_SESSION['user_online'] = $tco; 
            } 
        } 
    } 
    function removeOnlineUser($user_id) { 
        mysql_query("DELETE FROM `online` WHERE user_id=$user_id"); 
        if(isset($_SESSION['user_online'])) { 
            unset($_SESSION['user_online']); 
        } 
    } 
    //peform cleanup after certain period of time ... this function will be called by cron 
    function cleanup() { 
        $inactive = time()-$this->max_time_online; 
         
        $query = "DELETE FROM `online` WHERE `log_time` <= $inactive" ; 
        mysql_query($query); 
    } 
} 
?>