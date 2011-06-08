<?php

require_once('smarty/Smarty.class.php');
require_once('smtemplate_config.php');

class SMTemplate{

	private $_smarty;

	function __construct(){
		$this->_smarty = new Smarty();

		global $smtemplate_config;
		$this->_smarty->template_dir = dir(__FILE__) . '/conveee/apps/templates/';
		$this->_smarty->compile_dir = dir(__FILE__) . '/conveee/libs/smarty/templates_c/';
		$this->_smarty->cache_dir = dir(__FILE__) . '/conveee/libs/smarty/cache/';
		$this->_smarty->configs_dir = dir(__FILE__) . '/conveee/apps/configs/';
	}
}