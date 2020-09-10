<?php
include "../header.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}


$template->assign( "pageTitle", 'Forex Update' );
$template->display('admin/forex_update.tpl');

?>