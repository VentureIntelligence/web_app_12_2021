<?php
include "../header.php";

require_once MODULES_DIR."xbrl.php";

if( isset( $_POST ) ) {
	$cin = $_POST[ 'req_answer' ][ 'cin' ];
	if( !empty( $_POST[ 'req_answer' ][ 'from_date' ] ) ) {
		$from_date = date( 'Y-m-d', strtotime( $_POST[ 'req_answer' ][ 'from_date' ] ) );
		$to_date = date( 'Y-m-d', strtotime( $_POST[ 'req_answer' ][ 'to_date' ] ) );	
	} else {
		$from_date = $to_date = '';
	}
	$xbrl = new xbrl_insert();
	$fullList = $xbrl->selectLog( $cin, $from_date, $to_date, ' ORDER BY lt.id DESC' );
	echo json_encode( $fullList );	
}
?>