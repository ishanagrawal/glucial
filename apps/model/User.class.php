<?php

class User extends Zend_Db_Table_Abstract
{
    //Set up table name & primary keys
    protected $_name = 'user';
    protected $_primary = 'id';
    
    protected $observer;
    protected $_sequence = true;
    
    function postulate_table($db_info) {
        //echo "Hi";
        //print_r($db_info);
        $output =
        shell_exec("mysql -u{$db_info['username']} -p{$db_info['password']} -h {$db_info['host']} -D {$db_info['dbname']} < "
                   . $GLOBALS['model_directory'] . "insert_users.sql");    
        //$output = shell_exec('ls -lart');
        echo "<pre>$output</pre>";
    }
    
}

?>