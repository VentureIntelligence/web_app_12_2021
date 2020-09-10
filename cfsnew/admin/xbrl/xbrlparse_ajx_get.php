<?php
include "../header.php";

require_once MODULES_DIR."xbrl.php";

$runID = $_GET[ 'run_id' ];
$xbrl = new xbrl_insert();
$fullList = $xbrl->select( $runID );
echo json_encode( $fullList );
?>