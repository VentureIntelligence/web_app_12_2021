<?php

require_once(ADODB_LIB_DIR.'adodb.inc.php');

$db = ADONewConnection(ADODB_DATABASE_TYPE); 
$db->debug = ADODB_DEBUG_SWITCH;
$db->Connect(ADODB_SERVER, ADODB_USER, ADODB_PASSWORD, ADODB_DATABASE_NAME);

?>
