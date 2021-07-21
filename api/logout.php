<?php
	require_once '../dbconnectvi.php';
	$DB = new dbInvestments();
	unset( $_SESSION[ 'api_username' ] );
	unset( $_SESSION[ 'hashKey' ] );
	unset( $_SESSION[ 'api_user_id' ] );
	unset( $_SESSION[ 'logged_db' ] );
	unset( $_SESSION[ 'is_admin' ] );
	session_destroy();
	header( 'Location: index.php' );
?>