<?php
include "../header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Forex Update' );
if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}


$template->assign( "pageTitle", 'Earnings Update' );
$template->display('admin/earning_update.tpl');

?>