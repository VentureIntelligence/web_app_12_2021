
<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

require_once MODULES_DIR."pe_partner_apiDetails.php";
$partner_apitracking = new apiDetails();

$xbrl = new xbrl_insert();
/*$sql = "SELECT DATABASE()";
$res = mysql_query( $sql ) or die( $sql );
print_r( mysql_fetch_array( $res ) );*/
$Fields1 = array("user");
$orderby = 'user asc';	

$partner_apitrackinglist = $partner_apitracking->getFullList($Page,$Fields1,$where,$orderby,"name");

$template->assign('partner_apitrackinglist',json_encode( $partner_apitrackinglist ));

$template->assign( "pageTitle", 'Partner API Tracking' );
$template->display('admin/PE/partner_api_details.tpl');

?>