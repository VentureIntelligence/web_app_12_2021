<?php
include "../header.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}
/*$sql = "SELECT DATABASE()";
$res = mysql_query( $sql ) or die( $sql );
print_r( mysql_fetch_array( $res ) );*/

$template->assign( "pageTitle", 'XBRL' );
$template->assign("run_id",date( 'ymdhis' ));
$template->display('admin/xbrlparse.tpl');

?>