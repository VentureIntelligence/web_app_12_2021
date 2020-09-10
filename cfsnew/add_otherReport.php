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
	
if(isset($_POST["AddReport"])){
    
    
                $nanocode=stripslashes($_POST['answer']["embedCode"]);                  
                $filename=trim($_POST['answer']["reportTitle"]).'_'.rand().'.html';

                $target_file='../nanofolder/'.$filename;  
                
                $handle = fopen($target_file, "w");
                
                var_dump($handle);
                
                fwrite($handle, $nanocode); // write it
                fclose($handle);
                    
               
		$Insert_Report['reportTitle']       = $_POST['answer']["reportTitle"];
		$Insert_Report['reportPeriod']          = $_POST['answer']["reportPeriod"];
		$Insert_Report['definition']    = $_POST['answer']["definition"];
		//$Insert_Report['embedCode']    = $_POST['answer']["embedCode"];
		$Insert_Report['embedCode']    = $filename;
		$Insert_Report['date']           = date('Y-m-d', strtotime($_POST['answer']["date"]));
		
		$nanoToolCfs->update($Insert_Report);
                
                $id = $nanoToolCfs->elements['id'];
                
                
                
		header("Location:otherReport.php");
		
}



        
$template->assign('pageTitle',"Add Report");
$template->assign('pageDescription',"Add Report");
$template->assign('pageKeyWords',"Add Report");
$template->display('admin/add_otherReport.tpl');

?>