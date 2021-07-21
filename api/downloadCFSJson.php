<?php
	require_once '../dbconnectvi.php';
	$DB = new dbInvestments();
	session_start();
	if( isset( $_POST ) ) {
		$jsonObj = /*json_decode( */$_POST[ 'jsonObj' ]/* )*/;
		$jsonType = $_POST[ 'jsonType' ];
		/*$jsonObj = (array) $jsonObj;
		$cinArray = array_keys( $jsonObj );
		print_r( json_encode( $jsonObj ) );*/

		/*header('Content-Description: File Transfer');
    	header('Content-Type: application/force-download');
		header('Content-disposition: attachment; filename=CFS_API.json');*/
		header("Pragma: public");
	    header("Expires: 0"); // set expiration time
	    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	    /*header("Content-Type: application/force-download");
	    header("Content-Type: application/octet-stream");
	    header("Content-Type: application/download");*/
	    header("Content-Disposition: attachment; filename=CFS_API.".$jsonType);
	    
	    header("Content-Transfer-Encoding: binary");
	    //header("Content-Length: ".strlen($the_data));
		echo $jsonObj;
		exit;
	}
?>