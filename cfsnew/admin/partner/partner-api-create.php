<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}


$template->assign( "pageTitle", 'Select User Type' );
$template->display('admin/partner_api_create.tpl');

?>