<?php
exit;
include_once('header.php');
require_once MODULES_DIR."users.php";
$users = new users();
//pr($_REQUEST);//exit;

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

$CheckUNameExist = $adminuser->selectByUName($_POST['answer']["UserName"]);
$CheckEmailExist = $adminuser->selectByEmail($_POST['answer']["Email"]);
		
		if($CheckUNameExist["Ident"] != ""){
				$template->assign("ExistError","UserName Already Exists");
		}else if($CheckEmailExist["Ident"] != ""){
				$template->assign("ExistError","Email Already Exists");
	
		}
if($CheckUNameExist["Ident"] == "" && $CheckEmailExist["Ident"] == ""){
		if(isset($_POST["Registration"])){
			if($_POST['answer']["Email"]!= ""){
				if($_POST['answer']["Role"]=='Admin'){	
	
					$Insert_RegUser['username']       = $_POST['answer']["UserName"];
					$Insert_RegUser['user_password']       = md5($_POST['answer']["Password"]);
					$Insert_RegUser['firstname']      = $_POST['answer']["FirstName"];
					$Insert_RegUser['lastname']       = $_POST['answer']["LastName"];
					$Insert_RegUser['email']          = $_POST['answer']["Email"];
					$Insert_RegUser['usr_flag']       = 1;
					$Insert_RegUser['Added_Date']     = date("Y-m-d:H:i:s");
					$users->update($Insert_RegUser);
						
					$Insert_RegUser1['UserName']       = $_POST['answer']["UserName"];
					$Insert_RegUser1['Password']       = md5($_POST['answer']["Password"]);
					$Insert_RegUser1['Firstname']      = $_POST['answer']["FirstName"];
					$Insert_RegUser1['Lastname']       = $_POST['answer']["LastName"];
					$Insert_RegUser1['Email']          = $_POST['answer']["Email"];
					$Insert_RegUser1['usr_flag']       = 0;
					$Insert_RegUser1['Added_Date']     = date("Y-m-d:H:i:s");
					$adminuser->update($Insert_RegUser1);
					
					
					
					$template->assign("SucsMsg","Successfully Registered !");
					$_REQUEST = " ";
				}elseif($_POST['answer']["Role"]=='User'){
					$Insert_RegUser['username']       = $_POST['answer']["UserName"];
					$Insert_RegUser['user_password']       = md5($_POST['answer']["Password"]);
					$Insert_RegUser['firstname']      = $_POST['answer']["FirstName"];
					$Insert_RegUser['lastname']       = $_POST['answer']["LastName"];
					$Insert_RegUser['email']          = $_POST['answer']["Email"];
					$Insert_RegUser['usr_flag']       = 1;
					$Insert_RegUser['Added_Date']     = date("Y-m-d:H:i:s");
					$users->update($Insert_RegUser);
					$template->assign("SucsMsg","Successfully Registered !");
					$_REQUEST = " ";
				}
			}	
		}
}//ExistChk If Ends





$template->assign('Request',$_REQUEST['answer']);
$template->assign('pageTitle',"CFS - Registration");
$template->assign('pageDescription',$DealsList["Meta_Desc"]);
$template->assign('pageKeyWords',$DealsList['Meta_Title']);

$template->display('admin/register.tpl');

?>