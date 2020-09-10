<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Sector' );
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

if(isset($_POST["AddSector"])){
	if($_POST['answer']["SectorName"]!= ""){
		$Insert_Sector['IndustryId_FK']       = $_POST['answer']["Industry"];
		$Insert_Sector['SectorName']       = $_POST['answer']["SectorName"];
		$Insert_Sector['naics_code']       = $_POST['answer']["naics_code"];
		$Insert_Sector['Added_Date']      = date("Y-m-d:H:i:s");
		$where = "IndustryId_FK='".$Insert_Sector['IndustryId_FK']."' and SectorName= '".$Insert_Sector['SectorName']."'";
		//pr($where);
		$value = $sectors->count($where);
		//pr($value);
		if($value == '0'){
			$sectors->update($Insert_Sector);
			$template->assign('SuccessMsg',"Sector Added Successfully");
		}else{
			$template->assign('SuccessMsg',"Already Available");
		}
		//header("Location:addSector.php");
		
	}	
}

$template->assign("industries" , $industries->getIndustries($where1,$order1));
$template->assign('pageTitle',"Add Sector");
$template->assign('pageDescription',"Add Sector");
$template->assign('pageKeyWords',"Add Sector");
$template->display('admin/addSector.tpl');

?>