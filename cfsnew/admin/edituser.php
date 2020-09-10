<?php

session_start();
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Edit User' );
include "sessauth.php";

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}


require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
require_once MODULES_DIR."users.php";
$users = new users();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."industries.php";
$industries = new industries();

if(isset($_POST["EditUser"])){
	if($_POST['answer']["Email"]!= ""){
            
		$Update_RegUser['user_id']        = $_GET["uid"];
		$Update_RegUser['firstname']    = $_POST['answer']["FirstName"];
		$Update_RegUser['lastname']     = $_POST['answer']["LastName"];
		$Update_RegUser['email']        = $_POST['answer']["Email"];
		if($_POST['answer']["Password"]!=""){
			$Update_RegUser['user_password']        = md5($_POST['answer']["Password"]);
		}
		$Update_RegUser['GroupList']        = $_POST['answer']["Group"];
		
		//$Update_RegUser['expire']        = $_POST['answer']["expiry"];
		//$Update_RegUser['ExpireDate']    = strtotime(date("Y-m-d")."+".$_POST['answer']["expiry"]." day");
		$Update_RegUser['Added_Date']   = date("Y-m-d:H:i:s");		
		
        $Update_RegUser['deviceCount']  = $_POST["devCnt"];
        $Update_RegUser['exportLimit']  = $_POST["expLmt"];
		if( isset( $_POST[ 'answer' ][ 'sendmail_cust' ] ) ) {
				$Update_RegUser['sendmail_cust'] = $_POST['answer']["sendmail_cust"];
		} else {
				$Update_RegUser['sendmail_cust']= 0;
		}
                //pr($Update_RegUser);
                
               $users->update($Update_RegUser);
		$template->assign('updated',"Updated Successfully!!!");
               
		//header("Location:adminusers.php");
		
	}	
}



if($_REQUEST["uid"] != ""){
	$where = "user_id = '".$_REQUEST['uid']."' ";
	$User = $user->getFullList("1","1",$fields=array("*"),$where,$order,"name");
        if ($User['poc']=='') { $User['poc'] = 'info@ventureintelligence.com';  }
        
        $UserIp = $user->getUserIP($_REQUEST['uid']);
        //print_r($UserIp);
        $template->assign("User",$User);
        $template->assign("UserIp",$UserIp);
}	
$template->assign("companies" , $cprofile->getCompanies($where5,$order5));
$template->assign("industries" , $industries->getIndustries($where6,$order6));
$template->assign("Permissions" , $Permissions);
$template->assign("CountingStatus" , $CountingStatus);
$template->assign("grouplist" , $grouplist->getGroup($where7));
$template->assign('pageTitle',"CFS - Edit User Profile ".$User["firstname"]);
$template->assign('pageDescription',"CFS - Edit User Profile ".$User["firstname"]);
$template->assign('pageKeyWords',"CFS - Edit User Profile ".$User["firstname"]);
$template->display("admin/edituser.tpl");

?>