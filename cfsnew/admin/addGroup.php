<?php

session_start();
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Group' );
include "sessauth.php";

require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
require_once MODULES_DIR."industries.php";
$industries = new industries();


require_once MODULES_DIR."user_cfs_ipaddress.php";
$user_cfs_ipaddress = new user_cfs_ipaddress();




/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}
//pr($_POST);
if(isset($_POST["AddGroup"])){
    
      
        //$indusArray = explode(',',$_POST['industry']);
         $industry = implode(',',array_unique($_POST['industry']));
         
    
	if($_POST['answer']["Group"]!= ""){
            
		$Insert_Sector['G_Name']       = $_POST['answer']["Group"];
		$Insert_Sector['VisitLimit']       = $_POST['answer']["Limit"];
		$Insert_Sector['ExLimit']       = $_POST['answer']["ExLimit"];
		$Insert_Sector['SubLimit']       = $_POST['answer']["subLimit"];
                $Insert_Sector['Permissions']       = $_POST['answer']["Permissions"];
                $Insert_Sector['poc']       = $_POST['answer']["poc"];
                $Insert_Sector['Industry']       = $industry;
		$Insert_Sector['Create_Date']      = date("Y-m-d H:i:s");
            
            if( isset( $_POST['api_access'] ) ) {
                $Insert_Sector['api_access']       = $_POST['api_access'];
            }

            if( isset( $_POST['mobile_app_access'] ) ) {
                $Insert_Sector['mobile_app_access']       = $_POST['mobile_app_access'];
            }    
            
                
                //pr($Insert_Sector);
		//exit;
                $groupid = $grouplist->update($Insert_Sector);              
                
                
                
                $ipcount=0;
                foreach($_POST['ipAddress'] as $ipdd) {                    
                    
                    if($ipdd=='' || $ipdd==0) { continue;}
                    
                    $ipstart = $_POST['startRange'][$ipcount];
                    $ipend =  $_POST['endRange'][$ipcount];


                    $Ip_Sector['ipAddress'] =$ipdd;
                    $Ip_Sector['StartRange'] =$ipstart;
                    $Ip_Sector['EndRange'] =$ipend;
                    $Ip_Sector['group_Id'] =$groupid;

                    //pr($Ip_Sector);
                    $user_cfs_ipaddress->update($Ip_Sector);      

                    $ipcount++;

                }
                
                //exit;
                
                
		echo "<script>alert('Added Successfully'); window.location.href='editGroup.php'; </script>";
		
		
	}
        
        
}

$template->assign("grouplist" , $grouplist->getGroup($where2));
$template->assign("industries" , $industries->getIndustries($where6,$order6));
$template->assign('pageTitle',"Add Group");
$template->assign('pageDescription'," Add Group");
$template->assign('pageKeyWords',"Add Group");
$template->display('admin/addGroup.tpl');

?>