<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add News' );
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."news.php";
$news = new news();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
$template->assign("companies" , $cprofile->getCompanies($where2,$order2));

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if(isset($_POST["AddNews"])){
	if($_POST['answer']["Name"]!= ""){
		$Insert_News['CId_FK']       = $_POST['answer']["CompanyId"];
		$Insert_News['Date']       = $_POST['answer']["Date"];
		$Insert_News['Name']       = $_POST['answer']["Name"];
		$Insert_News['Url']       = $_POST['answer']["url"];
		
		$news->update($Insert_News);
		$template->assign('SuccessMsg',"State Added Successfully");
		header("Location:news.php");
		//pr($_POST);
	}	
}

$template->assign('pageTitle',"Add News");
$template->assign('pageDescription',"Add News");
$template->assign('pageKeyWords',"Add News");
$template->display('admin/news.tpl');

?>