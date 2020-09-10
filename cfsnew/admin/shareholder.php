<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Shareholder' );
include "conf_Admin.php";
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."shareinformation.php";
$shareinformation = new shareinformation();
$template->assign("companies" , $cprofile->getCompanies($where2,$order2));
require_once MODULES_DIR."shareround.php";
$city = new shareround();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if(isset($_POST["AddShare"])){
	if($_POST['answer']["CompanyId"]!= ""){
		$Update_CProfile['CId_FK'] 			= $_POST['answer']['CompanyId'];
		$Update_CProfile['Title']       = $_POST['answer']["Title"];
		$Update_CProfile['Name']       = $_POST['answer']["Name"];
		$Update_CProfile['Noofshares']       = $_POST['answer']["Noofshares"];
		$Update_CProfile['Stake']       = $_POST['answer']["Stake"];
		$Update_CProfile['Type']       = $_POST['answer']["Type"];
		
		$shareinformation->update($Update_CProfile);
		$template->assign('SuccessMsg',"State Added Successfully");
		header("Location:shareholder.php");
		//pr($_POST);
	}	
}
$template->assign('roundname',$city->getRoundname($where3));
$template->assign('pageTitle',"Add Shareinformation");
$template->assign('pageDescription',"Add Shareinformation");
$template->assign('pageKeyWords',"Add Shareinformation");
$template->display('admin/shareholder.tpl');

?>