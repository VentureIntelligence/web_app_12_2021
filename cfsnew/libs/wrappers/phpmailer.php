<?php
require_once(PHPMAILER_LIB_DIR.'class.phpmailer.php');

class MyMailer extends PHPMailer {
    // Set default variables for all new objects
    var $From     = PHPMAILER_FROM;
    var $FromName = PHPMAILER_FROMNAME;
    var $Host     = PHPMAILER_HOST;
    var $Mailer   = PHPMAILER_MAILER;
    var $WordWrap = PHPMAILER_WORDWRAP;

	function MyMailer($SMTPAuth = true, $IsHTML = false) {
		$this->IsSMTP();
		$this->SMTPAuth = $SMTPAuth;
		$this->Username = PHPMAILER_FROM;
		$this->Password = PHPMAILER_FROM_PWD;
		$this->IsHTML($IsHTML); 
	} 
	
    // Replace the default error_handler
    function error_handler($msg) {
       // Do your things here
        exit;
    }

    // Create an additional function
    function do_something($something) {
        // Place your new code here
    }
}

?>