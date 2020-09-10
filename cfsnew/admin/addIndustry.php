<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Industry' );
require_once MODULES_DIR."industries.php";
$industries = new industries();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
//pr($_POST);//exit;
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}
	
if(isset($_POST["AddIndustry"])){
	if($_POST['answer']["IndustryName"]!= ""){
		$Insert_Industry['IndustryName']       = $_POST['answer']["IndustryName"];
		$Insert_Industry['Added_Date']      = date("Y-m-d:H:i:s");
		$industries->update($Insert_Industry);
		$template->assign('SuccessMsg',"Industry Added Successfully");
		header("Location:addIndustry.php");
		
	}	
}

$template->assign('pageTitle',"Add Industry");
$template->assign('pageDescription',"Add Industry");
$template->assign('pageKeyWords',"Add Industry");
$template->display('admin/addIndustry.tpl');

?>