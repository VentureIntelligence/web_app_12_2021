<?php session_start();session_save_path("/tmp");
/***************************
* Auth module cofiguration *
****************************/
//ob_end_clean();
//session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
//ob_start();



define('AUTH_MAX_LOGIN_ATTEMPTS',100);

require_once(MODULES_DIR.'Auth.php');
require_once(APP_MODULES_DIR.'AuthStart.php');

// Include basic funtions 
require_once(APP_MODULES_DIR.'functions.php');


?>