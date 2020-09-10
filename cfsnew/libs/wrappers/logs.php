<?php

require_once 'Log.php';

$conf = array('mode' => 0644, 'timeFormat' => '%X %x');


if (SQL_LOG_SWITCH) {

	$sql_log  = &Log::singleton('file', MAIN_LOG_DIR.SQL_LOG_FILE, $_SERVER['PHP_SELF'], $conf, LOG_INFO);

}

if (APPLICATION_LOG_SWITCH) {

	$app_log = &Log::singleton('file', MAIN_LOG_DIR.APPLICATION_LOG_FILE, $_SERVER['PHP_SELF'], $conf, LOG_INFO);
	
}

?>