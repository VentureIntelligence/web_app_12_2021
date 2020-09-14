<?php

session_start();
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Edit Group' );
include "sessauth.php";

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
} 

require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
require_once MODULES_DIR."dealcompanies.php";
$dealcompanies = new dealcompanies();

require_once MODULES_DIR."users.php";
$user = new users();

require_once MODULES_DIR."industries.php";
$industries = new industries();

require_once MODULES_DIR."user_cfs_ipaddress.php";
$user_cfs_ipaddress = new user_cfs_ipaddress();



if(isset($_POST["EditUser"])){ 
        //$indusArray = explode(',',$_POST['industry']);
        $industry = implode(',',array_unique($_POST['industry']));
        
	    if($_POST['answer']["Group"]!= ""){
       

            if( isset( $_POST['api_access'] ) ) {
                $Insert_Sector['api_access']       = $_POST['api_access'];
                } else {
                    $Insert_Sector['api_access']       = 0;
                }
                if( isset( $_POST['admin_api_access'] ) ) {
                    $Insert_Sector['admin_api_access']       = $_POST['admin_api_access'];
                    } else {
                        $Insert_Sector['admin_api_access']       = 0;
                    }
                
                $Insert_Sector['DCompId']       = $_GET["auid"];

                $updated = $dealcompanies->updateAPIAccess($Insert_Sector);    
                
                if($updated) { 
                    $template->assign('updated',"Updated Successfully!!!");
                }        
        
            }	
}


if($_REQUEST["auid"] != ""){
	$where = "DCompId = '".$_REQUEST['auid']."' ";
	$GroupList1 = $dealcompanies->getFullList("1","1",$fields=array("*"),$where,$order,"name");
       
        // if ($GroupList1['poc']=='') { $GroupList1['poc'] = 'info@ventureintelligence.com';  }
        // if ($GroupList1[0]['expiry_date']!='') 
        // { 
        //     $GroupList1[0]['expiry_date'] = date('d-m-Y',  strtotime($GroupList1[0]['expiry_date']));
            
        // }
        // $GroupIp = $grouplist->getGroupIP($_REQUEST['auid']);
	//pr($GroupIp);
        
        // $Industry = $GroupList1[0]['Industry'];
        // $where= " Industry_Id  IN ($Industry)";        
        // $getindustries = $industries->getIndustriesname($where);
         
        
        
        
	$template->assign("GroupList1",$GroupList1);
     //   $template->assign("GroupListIp",$GroupIp);
}		


// $getindustriesid=array();
// foreach($getindustries as $getindus)
// {
//            array_push($getindustriesid, $getindus['id']);    
// }


$template->assign("industries" , $industries->getIndustries($where6,$order6));
$template->assign("getindustriesid" ,$getindustriesid);
$template->assign("grouplist" , $dealcompanies->getGroup($where2));
$template->assign('pageTitle',"CFS - Edit Group ");
$template->assign('pageDescription',"CFS - Edit Group ");
$template->assign('pageKeyWords',"CFS - Edit Group ");
$template->display("admin/editadmingroup-api-pe.tpl");

?>