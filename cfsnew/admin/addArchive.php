<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Archive' );
include "conf_Admin.php";
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."archive.php";
$archive = new archive();
$template->assign("companies" , $cprofile->getCompanies($where2,$order2));

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if($_FILES["answer"]["name"]["PLStandard"] != NULL){
			if($_FILES['answer']['name']["PLStandard"] != ""){
			 	//$ExcelCheck = ExcelValid($_FILES['answer']['name']["PLStandard"],$_FILES['answer']['tmp_name']["PLStandard"]);
				//if($ExcelCheck == "1"){
					$PLStandard  = "archive";
					$Dir = FOLDER_CREATE_PATH.$PLStandard;
					//pr($Dir);
					if(!is_dir($Dir)){
						mkdir($Dir,0777);chmod($Dir, 0777);
					}
					$UploadedSourceFile = $_FILES['answer']['tmp_name']["PLStandard"];
					$imageFileName = $_POST['answer']["Type"].$_POST['answer']['Year'].$_REQUEST['answer']['CompanyId'].".xls";
					$Target_Path = $Dir.'/';
	//				pr($imageFileName)
					$strOriginalPath = $Target_Path.$imageFileName;
					//pr($strOriginalPath);
					 //move_uploaded_file($_FILES['answer']['tmp_name']["PLStandard"], $strOriginalPath);
					include('uploadCommon.php');
				//}else{
				//	$Error .= "Image Not Valid";
				//}	
		 }
}	
/*Image Upload Ends*/

if(isset($_POST["AddArchive"])){
	if($_POST['answer']["CompanyId"]!= ""){
		$Update_CProfile['CId_FK'] 			= $_POST['answer']['CompanyId'];
		$Update_CProfile['Type']       = $_POST['answer']["Type"];
		$Update_CProfile['Year']   		  =  $_POST['answer']['Year'];
		$Update_CProfile['Path']   		  =  $imageFileName;
		$Update_CProfile['CreateDate']      = date("Y-m-d:H:i:s");
    //		$Insert_CProfile['state_name']       = $_POST['answer']["Acquisitions"];
	//	$Insert_CProfile['Region']        = $_POST['answer']["Acquisitions"];
		
		$archive->update($Update_CProfile);
		$template->assign('SuccessMsg',"State Added Successfully");
		header("Location:addArchive.php");
		//pr($_POST);
	}	
}

$template->assign('pageTitle',"Add Archive");
$template->assign('pageDescription',"Add Archive");
$template->assign('pageKeyWords',"Add Archive");
$template->display('admin/addArchive.tpl');

?>