<?php
	require_once '../dbconnectvi.php';
	$DB = new dbInvestments();
	session_start();
	if( isset( $_POST ) ) {
		$jsonObj = /*json_decode( */$_POST[ 'jsonObj' ]/* )*/;
		/*$jsonObj = (array) $jsonObj;
		$cinArray = array_keys( $jsonObj );
		print_r( json_encode( $jsonObj ) );*/

		header('Content-Description: File Transfer');
    	header('Content-Type: application/force-download');
		header('Content-disposition: attachment; filename=MA_API.json');
		echo $jsonObj;
		exit;
	}
?>