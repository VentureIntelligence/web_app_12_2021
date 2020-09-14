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
		$Admin_User['Ident']        = $_GET["auid"];
		$Admin_User['UserName']    = $_POST['answer']["UserName"];
		$Admin_User['Firstname']    = $_POST['answer']["FirstName"];
		$Admin_User['Lastname']     = $_POST['answer']["LastName"];
		$Admin_User['Email']        = $_POST['answer']["Email"];
		$Admin_User['Added_Date']   = date("Y-m-d:H:i:s");
		if( isset( $_POST[ 'answer' ][ 'user_type' ] ) ) {
			$Admin_User['usr_type']    	= $_POST['answer']["user_type"];
		}
		//if( isset( $_POST[ 'answer' ][ 'usr_flag' ] ) ) {
			$Admin_User['usr_flag']    	= $_POST['answer']["usr_flag"];
	//	}
		// else{
		// 	$Admin_User['usr_flag']    	= 0;
		// }
		if($_POST['answer']["Password"]!=""){
			$Admin_User['Password']        = md5($_POST['answer']["Password"]);
		}
		$Admin_User['external_api_access']          = $_POST['answer']["external_api_access"];
		$Admin_User['api_access']          = $_POST['answer']["api_access"];
		$adminuserexternal->update($Admin_User);
		$template->assign("SucsMsg","Updated Successfully !");
		
		//header("Location:external_adminusers.php");
	}else{
		$template->assign("ExistError","Enter email id");
	}
}


if($_REQUEST["auid"] != ""){
	$where = "Ident = '".$_REQUEST['auid']."' ";
	$AdminUser = $adminuserexternal->getFullList("1","1",$fields=array("*"),$where,$order,"name");
	$template->assign("AdminUser",$AdminUser);
}		

if($_REQUEST["uid"] != ""){
	$where = "user_id = '".$_REQUEST['uid']."' ";
	$AdminUser = $user->getFullList("1","1",$fields=array("*"),$where,$order,"name");
	$template->assign("User",$AdminUser);
}	

$template->assign('pageTitle',"CFS - Edit User Profile ".$AdminUser["firstname"]);
$template->assign('pageDescription',"CFS - Edit User Profile ".$authAdmin->user->elements["firstname"]);
$template->assign('pageKeyWords',"CFS - Edit User Profile ".$authAdmin->user->elements["firstname"]);
$template->display("admin/external_editadminuser.tpl");
$template->display('admin/footer.tpl');

?>