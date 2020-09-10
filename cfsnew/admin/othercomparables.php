<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Other Comparables' );
include "conf_Admin.php";
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
$template->assign("companies" , $cprofile->getCompanies($where2,$order2));

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if(isset($_POST["AddCompetitors"])){
	if($_POST['answer']["CompanyId"]!= ""){
		$Update_CProfile['Company_Id'] 			= $_POST['answer']['CompanyId'];
		$Update_CProfile['otherCompareListed']       = serialize($_POST["LCompanyId"]);
		$Update_CProfile['otherCompareUnListed']       = serialize($_POST["UCompanyId"]);
		$Update_CProfile['Added_Date']      = date("Y-m-d:H:i:s");

		$cprofile->update($Update_CProfile);
		$template->assign('SuccessMsg',"State Added Successfully");
		header("Location:othercomparables.php");
		//pr($_POST['LCompanyId']);
		//pr($_POST['UCompanyId']);
	}	
}

$template->assign('pageTitle',"Add Other Comparables");
$template->assign('pageDescription',"Add Other Comparables");
$template->assign('pageKeyWords',"Add Other Comparables");
$template->display('admin/othercomparables.tpl');

?>