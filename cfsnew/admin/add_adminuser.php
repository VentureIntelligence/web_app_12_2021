<?php
session_start();

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Admin User' );
include "sessauth.php";
require_once MODULES_DIR."users.php";
$users = new users();
//pr($_REQUEST);//exit;

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

if(isset($_POST["Registration"])){
$CheckUNameExist = $adminuser->selectByUName($_POST['answer']["UserName"]);
$CheckEmailExist = $adminuser->selectByEmail($_POST['answer']["Email"]);
		
		if($CheckUNameExist["Ident"] != ""){
				$template->assign("ExistError","Username Already Exists");
		}else if($CheckEmailExist["Ident"] != ""){
				$template->assign("ExistError","Email Already Exists");
	
		}
                
}

                
if($CheckUNameExist["Ident"] == "" && $CheckEmailExist["Ident"] == ""){
		if(isset($_POST["Registration"])){
			if($_POST['answer']["Email"]!= ""){			
	
					
						
					$Insert_RegUser1['UserName']       = $_POST['answer']["UserName"];
					$Insert_RegUser1['Password']       = md5($_POST['answer']["Password"]);
					$Insert_RegUser1['Firstname']      = $_POST['answer']["FirstName"];
					$Insert_RegUser1['Lastname']       = $_POST['answer']["LastName"];
					$Insert_RegUser1['Email']          = $_POST['answer']["Email"];
					$Insert_RegUser1['usr_flag']       = 0;
					if( isset( $_POST[ 'answer' ][ 'user_type' ] ) ) {
						$Insert_RegUser1['usr_type']       = $_POST['answer']["user_type"];	
					}
					$Insert_RegUser1['Added_Date']     = date("Y-m-d:H:i:s");
					
                                       // print_r($Insert_RegUser1);
                                       // exit;
                                        $adminuser->update($Insert_RegUser1);
					
					
					
					$template->assign("SucsMsg","Successfully Registered !");
					$_REQUEST = " ";
				
			}	
		}
}//ExistChk If Ends





$template->assign('Request',$_REQUEST['answer']);
$template->assign('pageTitle',"CFS - Registration");
$template->assign('pageDescription',$DealsList["Meta_Desc"]);
$template->assign('pageKeyWords',$DealsList['Meta_Title']);

$template->display('admin/add_adminuser.tpl');

?>