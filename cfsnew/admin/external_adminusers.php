<?php


session_start();
include "header.php";
//userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Admin User' );
include "sessauth.php";

require_once MODULES_DIR."admin_user_external.php";
$adminuser = new adminuserexternal();
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

	if($sortby=='UserName'){
			$clicksort2 ="('UserName','$ch_order')";
			$template->assign('groupnameclicksort',$clicksort2 );
	   }

//               $template->assign('sortby',$sortby);
//               $template->assign('order',$order);
		  
		   $url.="sortby=$sortby&order=$order&";
}
else {  
	 $clicksort2 ="('UserName','asc')";
	 $template->assign('groupnameclicksort',$clicksort2 );         
}
	
/*Delete Function Starts*/
if($_REQUEST["op"] == "delete" && $_REQUEST["extra"] != ""){
	$adminuser->delete($_REQUEST["extra"]);
	//$adminuser->soft_delete($_REQUEST["extra"]);
}
/*Delete Function Ends*/

/*Change Status Function Starts*/
if($_REQUEST["op"] == "changestatus" && $_REQUEST["status"] != ""){
	$UpdateStatus['Ident']     = $_REQUEST["status"];
	if($_REQUEST["edstatus"] == "Enable"){
		$UpdateStatus['usr_flag']    = 2;
	}else{
		$UpdateStatus['usr_flag']    = 0;
	}	
	$adminuser->update($UpdateStatus);
}
/*Change Status Function Ends*/

if(isset($_GET['name'])){
	$name = $_GET['name']; 
	$where = " Email LIKE '%$name%' and is_deleted = 0 and external_api_access = 1 and usr_type = 7"; 
	$url.= "name=$name&";           
	$template->assign('searchname', $name);
	
	
 }else{
	$where = "is_deleted = 0 and external_api_access = 1 and usr_type = 7";
	
 }

/*Pagination Starts*/
	$Page = ($_REQUEST["page"]) ? ($_REQUEST["page"]) : "1" ;
	$Row = ($_GET["rows"]) ? ($_GET["rows"]) : "20";
	if($orderby==''){
		$orderby =" Added_Date desc";
	}
	
	$Fields = array("Ident","UserName","Password", "Firstname", "Lastname", "Email","usr_flag","Added_Date","api_access","external_api_access","usr_type");
	$AdminUserList = $adminuser->getFullList($Page,$Row,$Fields,$where,$orderby,"name");
	$ListCnt = $adminuser->count();
	$pages = pager($Page,$Row,$ListCnt);
	if($ListCnt == 0){
		$pages['first'] = '0';
		$pages['next'] = '0';
		$pages['previous'] = '0';
		$pages['last'] = '0';		
	}
	$pages['link'] = 'external_adminusers.php?page=';
	$template->assign('pages_New', $pages);
//pr($UsersList);
/*Pagination Ends*/

$template->assign('AdminUserList',$AdminUserList);





$template->assign('pageTitle',"User(s) Management");
$template->assign('pageDescription',"User(s) Management");
$template->assign('pageKeyWords',"User(s) Management");

$template->display('admin/external_adminusers.tpl');

?>