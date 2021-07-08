<?php
include "../header.php";
require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

require_once MODULES_DIR."basic_partners_details_list.php";

$partners_details = new partners_details_list();

$Fields = array("partner_id,partnerName","partner_company","partnerType","partnerToken", "validityFrom", "validityTo","overallCount", "CONVERT_TZ(DATE_FORMAT( createdAt,  '%Y-%m-%d %T' ),'+00:00','+05:30') as createdAt");

$partnerlist = $partners_details->getFullList($Page,$Fields,$where,$orderby,"partnerName");

$template->assign('partnerlist',json_encode( $partnerlist ));

$template->assign( "pageTitle", 'Manage Partners' );
$template->display('admin/basic/partners_list.tpl');

?>