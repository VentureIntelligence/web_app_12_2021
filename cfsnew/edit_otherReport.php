<?php
include "header.php";
include "conf_Admin.php";
require_once MODULES_DIR."nanoToolCfs.php";
$nanoToolCfs = new nanoToolCfs();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//pr($_POST);//exit;
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}



if(isset($_POST["UpdateReport"])){
	
    
    
                $nanocode=stripslashes($_POST['answer']["embedCode"]);                  
                $filename=trim($_POST['answer']["reportTitle"]).'_'.rand().'.html';

                $target_file='../nanofolder/'.$filename;                   
                $handle = fopen($target_file, "w");
                
               
                fwrite($handle, $nanocode); // write it
                fclose($handle);
                
                
		$Update_CProfile['id']       = $_GET['rid'];
		$Update_CProfile['reportTitle']       = $_POST['answer']["reportTitle"];
		$Update_CProfile['reportPeriod']          = $_POST['answer']["reportPeriod"];
		$Update_CProfile['definition']    = $_POST['answer']["definition"];
		//$Update_CProfile['embedCode']    = $_POST['answer']["embedCode"];
		$Update_CProfile['embedCode']    = $filename;
		$Update_CProfile['date']           = date('Y-m-d', strtotime($_POST['answer']["date"]));
		
		//pr($Update_CProfile); exit;
		$nanoToolCfs->update($Update_CProfile);
		
                
         
}



if($_REQUEST["rid"] != ""){
	$id = $_REQUEST['rid'];
	$reportList = $nanoToolCfs->getOneList($id);
	
	$template->assign("reportList",$reportList);
        
        
        $embedCode = file_get_contents("../nanofolder/".$reportList['embedCode']);
        
        $template->assign("embedCode",$embedCode);
        
}else{
    header("Location:otherReport.php");
}		


     
        

$template->assign('pageTitle',"Edit Report");
$template->assign('pageDescription',"Edit Report");
$template->assign('pageKeyWords',"Edit Report");
$template->display('admin/edit_otherReport.tpl');
mysql_close();
?>