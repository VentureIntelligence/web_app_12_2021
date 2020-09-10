
<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

require_once MODULES_DIR."fullapitracking.php";

$fullapitracking = new fullapitracking();

$Fields1 = array("id,apiName","apiURL","user","deviceId", "deviceType","companyName", "apiType", "CONVERT_TZ(DATE_FORMAT( createdAt,  '%Y-%m-%d %T' ),'+00:00','+05:30') as createdAt");
$orderby = 'id';	

$fullapitrackinglist = $fullapitracking->getFullList($Page,$Fields1,$where,$orderby,"apiName");

$template->assign('fullapitrackinglist',json_encode( $fullapitrackinglist ));

$template->assign( "pageTitle", 'User API Tracking' );
$template->display('admin/fullapi_tracker.tpl');

?>