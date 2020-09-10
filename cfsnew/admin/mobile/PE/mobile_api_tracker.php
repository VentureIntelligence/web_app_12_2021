
<?php


include "../../header.php";
require_once MODULES_DIR."xbrl.php";
if(!$_SESSION['business']['Auth']){
	header('Location: ../../login.php');
	die();
}



require_once MODULES_DIR."pe_apitracking.php";
require_once MODULES_DIR."pe_customerTracking.php";



$apitracking = new apitracking();
$customerTracking = new customerTracking();



/*$sql = "SELECT DATABASE()";
$res = mysql_query( $sql ) or die( $sql );
print_r( mysql_fetch_array( $res ) );*/
$Fields1 = array("id,apiName","apiURL","user","companyName","advisorName","investorName","searchText", "deviceId","deviceType", "CONVERT_TZ(DATE_FORMAT( createdAt,  '%Y-%m-%d %T' ),'+00:00','+05:30') as createdAt");
$orderby = 'id';	

$Fields2 = array("id,username","fromAddress","toAddress","companyName", "message", "CONVERT_TZ(DATE_FORMAT( createdAt,  '%Y-%m-%d %T' ),'+00:00','+05:30') as createdAt");

$apitrackinglist = $apitracking->getFullList($Page,$Fields1,$where,$orderby,"name");
$customerTrackinglist = $customerTracking->getFullList($Page,$Fields2,$where,$orderby,"name");




$template->assign('apitrackinglist',json_encode( $apitrackinglist ));
$template->assign('customerTrackinglist',json_encode( $customerTrackinglist ));

$template->assign( "pageTitle", 'Mobile API Tracking' );
$template->display('admin/mobile_pe_api_tracker.tpl');

?>