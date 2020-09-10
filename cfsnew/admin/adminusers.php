<?php


session_start();
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Admin User' );
include "sessauth.php";

require_once MODULES_DIR."admin_user.php";
$adminuser = new adminuser();
require_once MODULES_DIR."users.php";
$user = new users();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//pr($_REQUEST);//exit;
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
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



/*Pagination Starts*/
	$Page = ($_REQUEST["page"]) ? ($_REQUEST["page"]) : "1" ;
	$Row = ($_GET["rows"]) ? ($_GET["rows"]) : "20";
	
	$Fields = array("Ident","UserName","Password", "Firstname", "Lastname", "Email","usr_flag","Added_Date","api_access");
	$where = "is_deleted = 0";
	$AdminUserList = $adminuser->getFullList($Page,$Row,$Fields,$where,"Added_Date desc","name");
	$ListCnt = $adminuser->count();
	$pages = pager($Page,$Row,$ListCnt);
	if($ListCnt == 0){
		$pages['first'] = '0';
		$pages['next'] = '0';
		$pages['previous'] = '0';
		$pages['last'] = '0';		
	}
	$pages['link'] = 'adminusers.php?page=';
	$template->assign('pages_New', $pages);
//pr($UsersList);
/*Pagination Ends*/

$template->assign('AdminUserList',$AdminUserList);





$template->assign('pageTitle',"User(s) Management");
$template->assign('pageDescription',"User(s) Management");
$template->assign('pageKeyWords',"User(s) Management");

$template->display('admin/adminusers.tpl');

?>