<?php
/**************************
* PHPMAILER Configuration *
***************************/

define('PHPMAILER_LIB_DIR',MAIN_LIB_DIR.'phpmailer/');
define('PHPMAILER_WRAPPER_LIB_DIR',MAIN_WRAPPER_LIB_DIR);

// Default parameters (Override as necessary)

define('PHPMAILER_FROM','no-reply@webulb.com');
define('PHPMAILER_FROMNAME','Webulb Team');
define('PHPMAILER_FROM_PWD','Thinkpositive7');
define('PHPMAILER_HOST','mail.webulb.com');
define('PHPMAILER_MAILER','smtp');
define('PHPMAILER_WORDWRAP','75');


require_once(PHPMAILER_WRAPPER_LIB_DIR.'phpmailer.php');
?>
