<?php
session_start();

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

include "header.php";
//userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Admin User' );
include "sessauth.php";
require_once MODULES_DIR."users.php";
$users = new users();
//pr($_REQUEST);//exit;

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

if(isset($_POST["Registration"])){
$CheckUNameExist = $adminviuserexternal->selectByUName($_POST['answer']["UserName"]);
$CheckEmailExist = $adminviuserexternal->selectByEmail($_POST['answer']["Email"]);
		
		if($CheckUNameExist["id"] != ""){
				$template->assign("ExistError","Username Already Exists");
		}else if($CheckEmailExist["id"] != ""){
				$template->assign("ExistError","Email Already Exists");
	
		}
                
}

                
if($CheckUNameExist["id"] == "" && $CheckEmailExist["id"] == ""){
		if(isset($_POST["Registration"])){
			if($_POST['answer']["Email"]!= "" && $_POST['answer']["Password"] !==""){			
				$email_check=$_POST['answer']["emailcheck"];
				if($email_check ==""){
					$where = "'".$_POST['answer']['Email']."'" ;
					
					$count = $adminviuserexternal->mailcount($where);
					if($count>0)
					{
						$template->assign("ExistError","Email Already Exists");
						$email_check = 1;
					}
				}
					
				if($email_check != 1){	
				    $Insert_RegUser1['user_name']       = $_POST['answer']["UserName"];
					$Insert_RegUser1['password']       = md5($_POST['answer']["Password"]);
					$Insert_RegUser1['first_name']      = $_POST['answer']["FirstName"];
					$Insert_RegUser1['last_name']       = $_POST['answer']["LastName"];
					$Insert_RegUser1['email']          = $_POST['answer']["Email"];
					$Insert_RegUser1['created_on']   = date("Y-m-d:H:i:s");
					$Insert_RegUser1['is_deleted']   = 0;
				//	if( isset( $_POST[ 'answer' ][ 'is_enabled' ] ) ) {
						$Insert_RegUser1['is_enabled']       = $_POST['answer']["is_enabled"];	
				//	}
					//$Insert_RegUser1['api_access']          = $_POST['answer']["api_access"];
					$Insert_RegUser1['external_api_access']          = $_POST['answer']["external_api_access"];
					$Insert_RegUser1['admin_api_access']          = $_POST['answer']["admin_api_access"];
					
					//$Insert_RegUser1['Added_Date']     = date("Y-m-d:H:i:s");
					
                                    //    print_r($Insert_RegUser1);
                                    //    exit;
                                        $adminviuserexternal->update($Insert_RegUser1);
					
					
					
					$template->assign("SucsMsg","Successfully Registered !");
					$_REQUEST = " ";
				}else{
					$template->assign("ExistError","Enter valid email id");
				}
				
			}
			else{
				$template->assign("ExistError","Enter email id and password");
			}	
		}
}//ExistChk If Ends





$template->assign('Request',$_REQUEST['answer']);
$template->assign('pageTitle',"CFS - Registration");
$template->assign('pageDescription',$DealsList["Meta_Desc"]);
$template->assign('pageKeyWords',$DealsList['Meta_Title']);

$template->display('admin/external_add_adminusers_pe.tpl');

?>