<?php

session_start();
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add User' );
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




if(isset($_REQUEST['groupid']) && $_REQUEST['groupid']>0){
    $groupid = $_REQUEST['groupid']; 
    $template->assign('groupid',$groupid);
}




if(isset($_POST["addUser"])){
       
                $uscount=0;
                foreach($_POST['Email'] as $email) {                    
                    
                    if($email=='') { continue;}
                    
                    
                    $fname =  $_POST['FirstName'][$uscount];
                    $lname = $_POST['LastName'][$uscount];
                    $password =  $_POST['Password'][$uscount];
                    $dev_allowed = $_POST['devCnt'][$uscount];
                    $ex_limit =  $_POST['expLmt'][$uscount];
                    $sendmail_cust = $_POST['sendmail_cust'][$uscount]; 
                     

                    $Insert_RegUser['firstname'] =$fname;
                    $Insert_RegUser['lastname'] =$lname;
                    $Insert_RegUser['email'] =$email;
                    $Insert_RegUser['username'] =$email;
                    $Insert_RegUser['user_password'] =md5($password);
                    $Insert_RegUser['deviceCount'] =$dev_allowed;
                    $Insert_RegUser['exportLimit'] =$ex_limit;
                    $Insert_RegUser['sendmail_cust'] =$sendmail_cust;
                    $Insert_RegUser['GroupList'] = $_POST['answer']["Group"];
                    $Insert_RegUser['Added_Date']   = date("Y-m-d:H:i:s");
                    
                    
                    
                   
                   
                    
                    $users->update($Insert_RegUser);
                    
                    $uscount++;
                    
                  
                }
                
                echo "<script>alert('Added Successfully'); window.location.href='users.php'; </script>";
                
	
}



	
$template->assign("companies" , $cprofile->getCompanies($where5,$order5));
$template->assign("industries" , $industries->getIndustries($where6,$order6));
$template->assign("Permissions" , $Permissions);
$template->assign("CountingStatus" , $CountingStatus);
$template->assign("grouplist" , $grouplist->getGroup($where7));
$template->assign('pageTitle',"CFS - Add Users ");
$template->assign('pageDescription',"CFS - Add Users ");
$template->assign('pageKeyWords',"CFS - Add Users ");
$template->display("admin/adduser.tpl");

?>