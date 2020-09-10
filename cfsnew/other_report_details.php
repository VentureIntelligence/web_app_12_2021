<?php 
include "header.php";
include "sessauth.php";
require_once MODULES_DIR."nanoToolCfs.php";
$nanoToolCfs = new nanoToolCfs();


$template->assign('pageTitle',"CFS :: Other Report Details");
$template->assign('pageDescription',"CFS - Other Report Details");
$template->assign('pageKeyWords',"CFS - Other Report Details");

 if(($_POST) && $_POST['month1']!='--' &&  $_POST['month2']!='--' &&  $_POST['year1']!='--' &&  $_POST['year2']!='--' ){
    
    
    $template->assign('month1',$month1);
    $template->assign('month2',$month2);
    
    $template->assign('year1',$year1);
    $template->assign('year2',$year2);
 }

if($_REQUEST["rid"] != ""){
    
	$id = $_REQUEST['rid'];
	$reportList = $nanoToolCfs->getOneList($id);
	//print_r($reportList);
	$template->assign("reportList",$reportList);
}else{
    header("Location:other_report.php");
}


$template->display('other_report_details.tpl');

include("footer.php");





?>
