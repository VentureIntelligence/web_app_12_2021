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
$CheckUNameExist = $adminuserexternal->selectByUName($_POST['answer']["UserName"]);
$CheckEmailExist = $adminuserexternal->selectByEmail($_POST['answer']["Email"]);
		
		if($CheckUNameExist["Ident"] != ""){
				$template->assign("ExistError","Username Already Exists");
		}else if($CheckEmailExist["Ident"] != ""){
				$template->assign("ExistError","Email Already Exists");
	
		}
                
}

//  echo "email".$_POST['answer']["Email"];
//  exit();               
if($CheckUNameExist["Ident"] == "" && $CheckEmailExist["Ident"] == ""){
		if(isset($_POST["Registration"])){
			if($_POST['answer']["Email"]!= ""  && $_POST['answer']["Password"]!=""){		
						$email_check=$_POST['answer']["emailcheck"];
						if($email_check ==""){
							$where = "'".$_POST['answer']['Email']."'" ;
                            
						$count = $adminuserexternal->count($where);
							if($count>0)
							{
								echo "Email id is already exists";
								$email_check=1;
							}
						}	
				//echo "email".$_POST['answer']["Email"];
					if($email_check!= 1){
						
				    $Insert_RegUser1['UserName']       = $_POST['answer']["UserName"];
					$Insert_RegUser1['Password']       = md5($_POST['answer']["Password"]);
					$Insert_RegUser1['Firstname']      = $_POST['answer']["FirstName"];
					$Insert_RegUser1['Lastname']       = $_POST['answer']["LastName"];
					$Insert_RegUser1['Email']          = $_POST['answer']["Email"];
					$Insert_RegUser1['usr_flag']       = $_POST['answer']["usr_flag"];
					//if( isset( $_POST[ 'answer' ][ 'usr_flag' ] ) ) {
						$Insert_RegUser1['usr_flag']       = $_POST['answer']["usr_flag"];	
					
					if( isset( $_POST[ 'answer' ][ 'user_type' ] ) ) {
						$Insert_RegUser1['usr_type']       = $_POST['answer']["user_type"];	
					}
					$Insert_RegUser1['api_access']          = $_POST['answer']["api_access"];
					$Insert_RegUser1['external_api_access']          = $_POST['answer']["external_api_access"];
					
					$Insert_RegUser1['Added_Date']     = date("Y-m-d:H:i:s");
					
                                    //    print_r($Insert_RegUser1);
                                    //    exit;
                                        $adminuserexternal->update($Insert_RegUser1);
					
					
					
					$template->assign("SucsMsg","Successfully Registered !");
					$_REQUEST = " ";
				}else{
					$template->assign("ExistError","Enter valid email id");
				}
				
			}else{
				$template->assign("ExistError","Enter email id and password");
			}
		}
}//ExistChk If Ends





$template->assign('Request',$_REQUEST['answer']);
$template->assign('pageTitle',"CFS - Registration");
$template->assign('pageDescription',$DealsList["Meta_Desc"]);
$template->assign('pageKeyWords',$DealsList['Meta_Title']);

$template->display('admin/external_add_adminuser.tpl');

?>