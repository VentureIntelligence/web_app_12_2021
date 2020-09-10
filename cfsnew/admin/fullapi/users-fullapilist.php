<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

require_once MODULES_DIR."fullapi_details_list.php";

$fullapi_details = new fullapi_details_list();

$Fields = array("fullapi_user_id,userName","user_company","userType","userToken", "validityFrom", "validityTo", "serachCount", "apiCount", "CONVERT_TZ(DATE_FORMAT( createdAt,  '%Y-%m-%d %T' ),'+00:00','+05:30') as createdAt");

$fullapi_list = $fullapi_details->getFullList($Page,$Fields,$where,$orderby,"userName");

$template->assign('fullapi_list',json_encode( $fullapi_list ));

$template->assign( "pageTitle", 'Manage Users' );
$template->display('admin/fullapi_users_list.tpl');

?>