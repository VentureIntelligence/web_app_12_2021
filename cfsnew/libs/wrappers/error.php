<?php

error_reporting(E_ALL);
define('ECLIPSE_ROOT', 'eclipse/');

require_once (ERRORREPORTER_LIB_DIR.'Error.php');

$reporter =& new ErrorReporter();
$reporter->setDateFormat('[Y-m-d H:i:s]');
$reporter->setStrictContext(false);
$reporter->setExcludeObjects(true);

if (ERROR_SILENT_MODE) {
	ini_set('display_errors', 0);
	$reporter->addReporter('file',E_NOTICE_NONE,MAIN_LOG_DIR.'errors.log');
} else {
	$reporter->addReporter('console', E_ERROR_ALL | E_WARNING_ALL | E_USER_NOTICE | E_DEBUG);
}

if(ERROR_LOG_USER_NOTICE) {
	$reporter->addReporter('file',E_USER_NOTICE,MAIN_LOG_DIR.'user_notice.log');
}

ErrorList::singleton($reporter, 'error');

?>