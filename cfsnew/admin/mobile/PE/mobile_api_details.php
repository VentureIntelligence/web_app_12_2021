
<?php

include "../../header.php";
require_once MODULES_DIR."xbrl.php";
if(!$_SESSION['business']['Auth']){
	header('Location: ../../login.php');
	die();
}

require_once MODULES_DIR."pe_apiDetails.php";
$apitracking = new apiDetails();

$xbrl = new xbrl_insert();
/*$sql = "SELECT DATABASE()";
$res = mysql_query( $sql ) or die( $sql );
print_r( mysql_fetch_array( $res ) );*/
$Fields1 = array("user");
$Fields2 = array("apiName");
$orderby = 'user asc';
$orderby = 'apiName asc';	

$apitrackinglist = $apitracking->getFullList($Page,$Fields1,$where,$orderby,"name");
$apicountlist = $apitracking->getcountList($Page,$Fields2,$where,$orderby1,"name");

$template->assign('apitrackinglist',json_encode( $apitrackinglist ));
$template->assign('apicountlist',json_encode( $apicountlist ));

$template->assign( "pageTitle", 'Mobile API Tracking' );
$template->display('admin/mobile_pe_api_details.tpl');

?>