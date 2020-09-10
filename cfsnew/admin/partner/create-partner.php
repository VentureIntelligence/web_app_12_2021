<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

require_once MODULES_DIR."apiDetails.php";
$apitracking = new apiDetails();

$xbrl = new xbrl_insert();

//$template->assign( "pageTitle", 'Create Partner' );
$template->display('admin/add_partner.tpl');

?>