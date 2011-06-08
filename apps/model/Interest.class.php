<?php

class Interest extends Zend_Db_Table_Abstract
{
    //Set up table name & primary keys
    protected $_name = 'interest';
    protected $_primary = 'id';
    
    protected $observer;
    protected $_sequence = true;
    
    
}

?>