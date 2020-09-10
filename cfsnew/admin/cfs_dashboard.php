<!-- T935 CFS Dashboard Module File Created -->
<?php 
ob_start();

include "header.php";

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

$template->assign('pageTitle',"CFS Dashboard Analytics");
$template->assign('pageDescription',"CFS Dashboard Analytics");
$template->assign('pageKeyWords',"CFS Dashboard Analytics");

if($_SESSION['business']['Auth']){
	$template->assign('LogedIn',"LogedIn");
}

require_once MODULES_DIR."cprofile.php";
$getcfsdashboard = new cprofile();
$cfsdashboard = $getcfsdashboard->getcfsdashboard();
$cfsdashboard_industries = $getcfsdashboard->getcfsdashboardIndustries();

$url = $_SERVER['REQUEST_URI'];
$dashboardpage = substr($url, -17);

if($dashboardpage == 'cfs_dashboard.php'){
	$url_valid = true;
}
// print_r($cfsdashboard_industries);die;
$induscount = count($cfsdashboard_industries);
$incount = ($induscount/2);

$inductryarr = array_chunk($cfsdashboard_industries,$incount);

$template->assign('cfsdashboard',$cfsdashboard);
$template->assign('industries1',$inductryarr[0]);
$template->assign('industries2',$inductryarr[1]);
$template->assign('incount',$incount);
$template->assign('url_valid',$url_valid);
$template->display('admin/cfs_dashboard.tpl');


ob_flush();

#82f26d#

#/82f26d#
?>