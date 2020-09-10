<?php

include "../../header.php";
require_once MODULES_DIR."xbrl.php";
if(!$_SESSION['business']['Auth']){
	header('Location: ../../login.php');
	die();
}

require_once MODULES_DIR."pe_apitracking.php";

$apitracking = new apitracking();

$xbrl = new xbrl_insert();
/*$sql = "SELECT DATABASE()";
$res = mysql_query( $sql ) or die( $sql );
print_r( mysql_fetch_array( $res ) );*/
$current_date = date( 'Y-m-d' );
$fullList = $xbrl->selectLog( '', $current_date, $current_date, ' ORDER BY lt.created_on DESC', ' GROUP BY lt.cin' );
$Fields1 = array("id,apiName","apiURL","user", "deviceId","companyName","advisorName","investorName",  "deviceType", "DATE_FORMAT( createdAt,  '%d-%m-%Y %T' ) as createdAt");
$orderby = 'id asc';	

$apitrackinglist = $apitracking->getFullList($Page,$Fields1,$where,$orderby,"name");

$template->assign('apitrackinglist',json_encode( $apitrackinglist ));
$template->assign( "pageTitle", 'Mobile API Tracking' );
$template->assign( "today_run", $fullList );
$template->display('admin/mobile_pe_api_tracker_vi.tpl');

?>