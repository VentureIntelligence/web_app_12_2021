<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

require_once MODULES_DIR."pe_apiDetails.php";
$apitracking = new apiDetails();

$xbrl = new xbrl_insert();
$params=$_GET;
$category=$params["type"];

$template->assign("type", $category);
//$template->assign( "pageTitle", 'Create Partner' );
$template->display('admin/PE/add_partner.tpl');

?>