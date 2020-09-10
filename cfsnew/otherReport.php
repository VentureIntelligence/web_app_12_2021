<?php
include "header.php";
require_once MODULES_DIR."nanoToolCfs.php";
$nanoToolCfs = new nanoToolCfs();


/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//pr($_REQUEST);//exit;
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}
	
/*Delete Function Starts*/
if($_REQUEST["op"] == "delete" && $_REQUEST["extra"] != ""){
	$nanoToolCfs->delete($_REQUEST["extra"]);
}
/*Delete Function Ends*/



$reportList = $nanoToolCfs->getFullList();

//echo "<pre>"; print_r($reportList); exit;

$template->assign('reportList',$reportList);


$template->assign('pageTitle',"report Management");
$template->assign('pageDescription',"report Management");
$template->assign('pageKeyWords',"report Management");
$template->display('admin/otherReport.tpl');
mysql_close();
?>