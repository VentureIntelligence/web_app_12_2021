<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Round Name' );
require_once MODULES_DIR."shareround.php";
$shareround = new shareround();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if(isset($_POST["AddCity"])){
	if($_POST['answer']["City"]!= ""){
		$Insert_State['ShareName']        = $_POST['answer']["City"];
		$Insert_PLStandard['CreateDate']  = date("Y-m-d:H:i:s");
		
		$shareround->update($Insert_State);
		$template->assign('SuccessMsg',"State Added Successfully");
		header("Location:addRound.php");
		pr($_POST);
	}	
}

$template->assign('pageTitle',"Add Round Name");
$template->assign('pageDescription',"Add Round Name");
$template->assign('pageKeyWords',"Add Round Name");
$template->display('admin/addRound.tpl');

?>