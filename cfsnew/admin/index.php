<?php 
ob_start();

include "header.php";
include ('../../globalconfig.php');
$GLOBAL_BASE_URL= GLOBAL_BASE_URL;	

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

$template->assign('pageTitle',"CFS - Admin");
$template->assign('pageDescription',"CFS - Admin");
$template->assign('pageKeyWords',"CFS - Admin");
$template->assign('GLOBAL_BASE_URL',$GLOBAL_BASE_URL);


if($_SESSION['business']['Auth']){
	$template->assign('LogedIn',"LogedIn");
}
$template->display('admin/index.tpl');

ob_flush();

#82f26d#

#/82f26d#
?>