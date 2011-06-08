<?php

class Chat extends Zend_Db_Table_Abstract
{
    //Set up table name & primary keys
    protected $_name = 'chat';
    protected $_primary = 'id';
    
    protected $observer;
    protected $_sequence = true;
    
    
}

?>