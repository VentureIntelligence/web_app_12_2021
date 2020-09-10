<?php

require_once(SMARTY_LIB_DIR.'Smarty.class.php');

class Template extends Smarty {

   function Template() {
   
   		// Class Constructor. These automatically get set with each new instance.

		$this->Smarty();

		$this->template_dir = SMARTY_TEMPLATE_DIR;
		$this->compile_dir = SMARTY_COMPILE_DIR;
		$this->config_dir = SMARTY_CONFIG_DIR;
		$this->cache_dir = SMARTY_CACHE_DIR; 
		
		$this->caching = SMARTY_CACHE_SWITCH;
		$this->assign('app_name',APP_NAME);
   }

}


$template = new Template;

$template->compile_check = true;
$template->debugging = false;
$template->use_sub_dirs = false;
$template->caching = false;


?>