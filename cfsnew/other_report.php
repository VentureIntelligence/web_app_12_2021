<?php 
include "header.php";
include "sessauth.php";
require_once MODULES_DIR."nanoToolCfs.php";
$nanoToolCfs = new nanoToolCfs();


$template->assign('pageTitle',"CFS :: Other Report");
$template->assign('pageDescription',"CFS - Other Report");
$template->assign('pageKeyWords',"CFS - Other Report");




 if(($_POST) && $_POST['month1']!='--' &&  $_POST['month2']!='--' &&  $_POST['year1']!='--' &&  $_POST['year2']!='--' ){
    
    $fromDate = '20'.$_POST['year1'].'-'.$_POST['month1'].'-01';
    $toDate = '20'.$_POST['year2'].'-'.$_POST['month2'].'-31';
    
    $template->assign('month1',$month1);
    $template->assign('month2',$month2);
    
    $template->assign('year1',$year1);
    $template->assign('year2',$year2);
    
    $reportList = $nanoToolCfs->getFullList_dateFilter($fromDate,$toDate);
    
}else{
    $reportList = $nanoToolCfs->getFullList();
}



$template->assign('reportList',$reportList);
$template->assign('ReportsCount',count($reportList));


$template->display('other_report.tpl');

include("footer.php");





?>
