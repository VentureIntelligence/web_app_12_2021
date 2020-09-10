<?php

session_start();
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Edit User' );
include "sessauth.php";

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}


require_once MODULES_DIR."pe_partners_details_list.php";
$view_partner_details = new partners_details_list();
$partner_id = $_GET["pid"];
$partner_details = $view_partner_details->getPartnerDetails($partner_id);
$user_id = $partner_details[user_id];
$external_details = $view_partner_details->getExternalDetails($user_id);

//$template->assign('partner_details1',"dfbdf"); 
$template->assign('partner_details',$partner_details);
$template->assign('external_details',$external_details); 

//$template->assign("partner_details" , $partner_details);
$template->assign( "pageTitle", 'View Partner' );
$template->display("admin/PE/viewpartner.tpl");

?>