<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Rating' );
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."rating.php";
$rating = new rating();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
$template->assign("companies" , $cprofile->getCompanies($where2,$order2));

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if(isset($_POST["AddRating"])){
	if($_POST['answer']["Url"]!= ""){
		$Insert_Rating['CId_FK']       = $_POST['answer']["CompanyId"];
		$Insert_Rating['Title']       = $_POST['answer']["Title"];
		$Insert_Rating['YearUrl']       = $_POST['answer']["Url"];
		
		$rating->update($Insert_Rating);
		$template->assign('SuccessMsg',"State Added Successfully");
		header("Location:rating.php");
		//pr($_POST);
	}	
}

$template->assign('pageTitle',"Add Rating");
$template->assign('pageDescription',"Add Rating");
$template->assign('pageKeyWords',"Add Rating");
$template->display('admin/rating.tpl');

?>