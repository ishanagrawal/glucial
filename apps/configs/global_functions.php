<?php

class Global_Functions
{
    #region handle_err($err_type)
    /**
    * Handle different types of errors 
    * error type
    * 1 - Database Error
    * 2 - Wrong Request Error (Access to undefined area of the application)
    * @access public
    * @author Ngoc Binh Tran <binhngoc17@gmail.com>
    * @since  Sunday April 22nd 2007
    *
    * @param string $tmp_str_sql
    * @param string $tmp_str_file
    * @param int $tmp_int_line
    * @param bool $tmp_bool_buffer
    */
    
    public function handle_err($err_type) {
        
        if ($err_type == 1) {
            
            die($GLOBALS['Smarty']->fetch($GLOBALS['view_directory'] . 'err_msg'. DIRECTORY_SEPARATOR . 'database_err.tpl'));
	
        } else if ($err_type == 2) {
            
            die("Access");
        }
    }
    
}
?>