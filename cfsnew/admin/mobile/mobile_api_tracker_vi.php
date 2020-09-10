<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

require_once MODULES_DIR."apitracking.php";
$apitracking = new apitracking();

$xbrl = new xbrl_insert();
/*$sql = "SELECT DATABASE()";
$res = mysql_query( $sql ) or die( $sql );
print_r( mysql_fetch_array( $res ) );*/
$current_date = date( 'Y-m-d' );
//$fullList = $xbrl->selectLog( '', $current_date, $current_date, ' ORDER BY lt.created_on DESC', ' GROUP BY lt.cin' );
$Fields1 = array("id,apiName","apiURL","user", "deviceId", "deviceType","companyName", "CONVERT_TZ(DATE_FORMAT( createdAt,  '%Y-%m-%d %T' ),'+00:00','+05:30') as createdAt");
$orderby = 'createdAt asc';	

$apitrackinglist = $apitracking->getFullList($Page,$Fields1,$where,$orderby,"name");

$template->assign('apitrackinglist',json_encode( $apitrackinglist ));
$template->assign( "pageTitle", 'Mobile API Tracking' );
//$template->assign( "today_run", $fullList );
$template->display('admin/mobile_api_tracker_vi.tpl');

?>