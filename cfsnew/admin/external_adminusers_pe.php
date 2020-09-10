<?php


session_start();
include "header.php";
//userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Admin User' );
include "sessauth.php";

// require_once MODULES_DIR."admin_user.php";
// $adminuser = new adminuser();
require_once MODULES_DIR."adminvi_user_external.php";
$adminviuser = new adminviuserexternal();
require_once MODULES_DIR."users.php";
$user = new users();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//pr($_REQUEST);//exit;
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}


if(isset($_REQUEST['sortby'])){
	$sortby = $_REQUEST['sortby'];
	$order = $_REQUEST['order']; 
	$orderby = $sortby."  ".$order;

	if($order=='asc'){ $ch_order='desc';}
	else if($order=='desc'){ $ch_order='asc';}

	if($sortby=='user_name'){
			$clicksort2 ="('user_name','$ch_order')";
			$template->assign('groupnameclicksort',$clicksort2 );
	   }

//               $template->assign('sortby',$sortby);
//               $template->assign('order',$order);
		  
		   $url.="sortby=$sortby&order=$order&";
}
else {  
	 $clicksort2 ="('user_name','asc')";
	 $template->assign('groupnameclicksort',$clicksort2 );         
}
	
/*Delete Function Starts*/
if($_REQUEST["op"] == "delete" && $_REQUEST["extra"] != ""){
	$adminviuser->delete($_REQUEST["extra"]);
	//$adminuser->soft_delete($_REQUEST["extra"]);
}
/*Delete Function Ends*/


// /*Change Status Function Starts*/
// if($_REQUEST["op"] == "changestatus" && $_REQUEST["status"] != ""){
// 	$UpdateStatus['id']     = $_REQUEST["status"];
// 	if($_REQUEST["edstatus"] == "Enable"){
// 		$UpdateStatus['usr_flag']    = 2;
// 	}else{
// 		$UpdateStatus['usr_flag']    = 0;
// 	}	
// 	$adminviuser->update($UpdateStatus);
// }
// /*Change Status Function Ends*/
/*Change Status Function Starts*/
if( $_REQUEST["status"] != ""){
	$UpdateStatus['id']     = $_REQUEST["status"];
	// if($_REQUEST["edstatus"] == "Enable"){
	// 	$UpdateStatus['usr_flag']    = 2;
	// }else{
	// 	$UpdateStatus['usr_flag']    = 0;
	// }	
	$adminviuser->update($UpdateStatus);
}
/*Change Status Function Ends*/

if(isset($_GET['name'])){
	$name = $_GET['name']; 
	$where = " email LIKE '%$name%' and is_deleted = 0 and external_api_access = 1"; 
	$url.= "name=$name&";           
	$template->assign('searchname', $name);
	
	
 }else{
	$where = "is_deleted = 0 and external_api_access = 1";
	
 }

/*Pagination Starts*/
	$Page = ($_REQUEST["page"]) ? ($_REQUEST["page"]) : "1" ;
	$Row = ($_GET["rows"]) ? ($_GET["rows"]) : "20";
	if($orderby==''){
		$orderby =" created_on desc";
	}
	$Fields = array("id","user_name","password", "email", "first_name", "last_name","created_on","last_login","is_deleted","is_enabled","external_api_access");
	
	$AdminUserList = $adminviuser->getFullList($Page,$Row,$Fields,$where,$orderby,"name");
	$ListCnt = $adminviuser->count();
	$pages = pager($Page,$Row,$ListCnt);
	if($ListCnt == 0){
		$pages['first'] = '0';
		$pages['next'] = '0';
		$pages['previous'] = '0';
		$pages['last'] = '0';		
	}
	$pages['link'] = 'external_adminusers_pe.php?page=';
	$template->assign('pages_New', $pages);
//pr($UsersList);
/*Pagination Ends*/

$template->assign('AdminUserList',$AdminUserList);





$template->assign('pageTitle',"User(s) Management");
$template->assign('pageDescription',"User(s) Management");
$template->assign('pageKeyWords',"User(s) Management");

$template->display('admin/external_adminusers_pe.tpl');

?>