
<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

require_once MODULES_DIR."apiDetails.php";
$apitracking = new apiDetails();

$xbrl = new xbrl_insert();
/*$sql = "SELECT DATABASE()";
$res = mysql_query( $sql ) or die( $sql );
print_r( mysql_fetch_array( $res ) );*/
$Fields1 = array("user");
$orderby = 'id';	

$apitrackinglist = $apitracking->getFullList($Page,$Fields1,$where,$orderby,"name");

$template->assign('apitrackinglist',json_encode( $apitrackinglist ));

$template->assign( "pageTitle", 'Mobile API Tracking' );
$template->display('admin/mobile_api_details.tpl');

?>