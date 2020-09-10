<?php
/**************************
* Smarty Template Engine  *
**************************/

define('SMARTY_LIB_DIR',MAIN_LIB_DIR.'smarty/');
define('SMARTY_WORK_DIR',MAIN_APP_DIR.'templates/');

define('SMARTY_TEMPLATE_DIR',SMARTY_WORK_DIR.'templates');
define('SMARTY_COMPILE_DIR',SMARTY_WORK_DIR.'templates_c');
define('SMARTY_CONFIG_DIR',SMARTY_WORK_DIR.'configs');
define('SMARTY_CACHE_DIR',SMARTY_WORK_DIR.'cache');

define('SMARTY_CACHE_SWITCH','false');

define('SMARTY_WRAPPER_LIB_DIR',MAIN_WRAPPER_LIB_DIR);

include(SMARTY_WRAPPER_LIB_DIR.'smarty.php');
?>
