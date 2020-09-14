<?php

session_start();
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Edit User' );
include "sessauth.php";

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}


require_once MODULES_DIR."fullapi_details_list.php";
$view_fullapi_details = new fullapi_details_list();
$fullapi_user_id = $_GET["pid"];
$fullapi_details = $view_fullapi_details->getUserDetails($fullapi_user_id);
$user_id = $fullapi_details[user_id];
$external_details = $view_fullapi_details->getExternalDetails($user_id);

//$template->assign('partner_details1',"dfbdf"); 
$template->assign('fullapi_details',$fullapi_details);
$template->assign('external_details',$external_details); 

//$template->assign("partner_details" , $partner_details);
$template->assign( "pageTitle", 'View User' );
$template->display("admin/viewfullapi_user.tpl");

?>