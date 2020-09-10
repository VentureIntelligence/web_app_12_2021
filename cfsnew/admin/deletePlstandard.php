<?php
session_start();
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Delete P & L Standard' );
userPermissionCheck('','Log History');
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."rating.php";
$rating = new rating();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
//$template->assign("companies" , $cprofile->getCompanies($where2,$order2));
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."growthpercentage.php";
$growthpercentage = new growthpercentage();
require_once MODULES_DIR."cagr.php";
$cagr = new cagr();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if(isset($_POST["AddRating"])){
	if($_POST['answer']["CompanyId"]!= ""){
		$Insert_Rating['CId_FK']       = $_POST['answer']["CompanyId"];
		
		$plstandard->deleteCompany($_POST['answer']["CompanyId"]);
		$growthpercentage->deleteCompany($_POST['answer']["CompanyId"]);
		$cagr->deleteCompany($_POST['answer']["CompanyId"]);
		$UploadedFilePath = "../../cfs-old/media/plstandard/PLStandard_".$_POST['answer']["CompanyId"].".xls";
        unlink($UploadedFilePath);
		header("Location:deletePlstandard.php");
		//pr($_POST);
	}	
}

$template->assign('pageTitle',"Delete PL Standard");
$template->assign('pageDescription',"Delete PL Standard");
$template->assign('pageKeyWords',"Delete PL Standard");
$template->display('admin/deletePlstandard.tpl');

?>