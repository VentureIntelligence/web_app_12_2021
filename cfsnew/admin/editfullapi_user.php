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
$edit_fullapi_user_details = new fullapi_details_list();
$fullapi_user_id = $_GET["pid"];
$fullapi_details = $edit_fullapi_user_details->getUserDetails($fullapi_user_id);
$user_id = $fullapi_details[user_id];
$external_details = $edit_fullapi_user_details->getExternalDetails($user_id);
// print_r($external_details);
// exit();


//$template->assign('partner_details1',"dfbdf"); 
$template->assign('fullapi_details',$fullapi_details); 
$template->assign('external_details',$external_details); 

//$template->assign("partner_details" , $partner_details);
$template->assign( "pageTitle", 'Edit User' );
$template->display("admin/editfullapi_user.tpl");

?>