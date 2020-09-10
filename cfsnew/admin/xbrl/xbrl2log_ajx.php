<?php
include "../header.php";

require_once MODULES_DIR."xbrl2.php";

if( isset( $_POST ) ) {
	$runID = $_POST[ 'runid' ];
	$xbrl2 = new xbrl2();
	$fullList = $xbrl2->select( $runID );
	echo json_encode( $fullList );	
}
?>