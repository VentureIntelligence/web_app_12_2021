<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Delete Sector' );
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."industries.php";
$industries = new industries();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if(isset($_POST["Sector_Id"])){
	if($_POST['Sector_Id']!= "" && $_POST['Industry_Id']!= "" ){
				
		$sectors->delete($_POST['Sector_Id']);                
		header("Location:deleteSector.php?dltsucc");
	}	
}

if(isset($_GET['dltsucc'])){ 
    $template->assign("SuccessMsg", "Deleted");
}

$template->assign("industries" , $industries->getIndustries($where1,$order1));
$template->assign("pageTitle","Delete Sector");
$template->assign('pageDescription',"Delete Sector");
$template->assign('pageKeyWords',"Delete Sector");
$template->display('admin/deleteSector.tpl');

?>