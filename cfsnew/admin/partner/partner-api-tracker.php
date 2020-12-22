
<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

require_once MODULES_DIR."partnerapitracking.php";

$apitracking = new apitracking();

$Fields1 = array("id,apiName","apiURL","user","deviceId", "deviceType","companyName", "apiType", "CONVERT_TZ(DATE_FORMAT( createdAt,  '%Y-%m-%d %T' ),'+00:00','+00:00') as createdAt");
$orderby = 'id';	

$apitrackinglist = $apitracking->getFullList($Page,$Fields1,$where,$orderby,"apiName");

$template->assign('apitrackinglist',json_encode( $apitrackinglist ));

$template->assign( "pageTitle", 'Partner API Tracking' );
$template->display('admin/partner_api_tracker.tpl');

?>