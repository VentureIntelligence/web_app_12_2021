<?php
session_start();
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}
include "header.php";
//userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Edit Admin User' );
include "sessauth.php";

if(isset($_POST["EditAdminUser"])){
	if($_POST['answer']["Email"]!= ""){
		$Admin_User['id']        = $_GET["auid"];
		$Admin_User['user_name']    = $_POST['answer']["UserName"];
		$Admin_User['first_name']    = $_POST['answer']["FirstName"];
		$Admin_User['last_name']     = $_POST['answer']["LastName"];
		$Admin_User['email']        = $_POST['answer']["Email"];
		$Admin_User['created_on']   = date("Y-m-d:H:i:s");
		//if( isset( $_POST[ 'answer' ][ 'is_enabled' ] ) ) {
			$Admin_User['is_enabled']    	= $_POST['answer']["is_enabled"];
		//}
		if($_POST['answer']["Password"]!=""){
			$Admin_User['password']        = md5($_POST['answer']["Password"]);
		}
		$Admin_User['external_api_access']          = $_POST['answer']["external_api_access"];
		$Admin_User['admin_api_access']          = $_POST['answer']["admin_api_access"];
		$adminviuserexternal->update($Admin_User);
		$template->assign("SucsMsg","Updated Successfully !");
		
		//header("Location:external_adminusers_pe.php");
	}else{
		$template->assign("ExistError","Enter email id");
	}	
}


if($_REQUEST["auid"] != ""){
	$where = "id = '".$_REQUEST['auid']."' ";
	$AdminUser = $adminviuserexternal->getFullList("1","1",$fields=array("*"),$where,$order,"name");
	 
	$template->assign("AdminUser",$AdminUser);
}		

// if($_REQUEST["uid"] != ""){
// 	$where = "user_id = '".$_REQUEST['uid']."' ";
// 	$AdminUser = $user->getFullList("1","1",$fields=array("*"),$where,$order,"name");
// 	$template->assign("User",$AdminUser);
// }	

$template->assign('pageTitle',"CFS - Edit User Profile ".$AdminUser["firstname"]);
$template->assign('pageDescription',"CFS - Edit User Profile ".$authAdmin->user->elements["firstname"]);
$template->assign('pageKeyWords',"CFS - Edit User Profile ".$authAdmin->user->elements["firstname"]);
$template->display("admin/external_editadminusers_pe.tpl");
$template->display('admin/footer.tpl');

?>