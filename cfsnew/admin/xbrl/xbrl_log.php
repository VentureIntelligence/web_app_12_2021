<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}
$xbrl = new xbrl_insert();
/*$sql = "SELECT DATABASE()";
$res = mysql_query( $sql ) or die( $sql );
print_r( mysql_fetch_array( $res ) );*/
$current_date = date( 'Y-m-d' );
$fullList = $xbrl->selectLog( '', $current_date, $current_date, ' ORDER BY lt.created_on DESC', ' GROUP BY lt.cin' );

$template->assign( "pageTitle", 'XBRL LOG' );
$template->assign( "today_run", $fullList );
$template->display('admin/xbrl_log.tpl');

?>