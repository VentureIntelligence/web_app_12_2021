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
            
                if(isset($_GET["expupdate"]) && $_GET["expupdate"]==1){
                    
                    $GroupList_ind = $grouplist->select($_GET["auid"]);   
                    if( strtotime($_POST['answer']["exp_date"]) > strtotime($GroupList_ind['expiry_date'])){
                        $Insert_Sector['status']       = 0;
                    }
                }
                
                $Insert_Sector['Group_Id']       = $_GET["auid"];
                $Insert_Sector['G_Name']       = $_POST['answer']["Group"];
		$Insert_Sector['VisitLimit']       = $_POST['answer']["Limit"];
		$Insert_Sector['ExLimit']       = $_POST['answer']["ExLimit"];
		$Insert_Sector['SubLimit']       = $_POST['answer']["subLimit"];
                $Insert_Sector['Permissions']       = $_POST['answer']["Permissions"];
                $Insert_Sector['poc']       = $_POST['answer']["poc"];
                $Insert_Sector['Industry']       = $industry;
		$Insert_Sector['Create_Date']      = date("Y-m-d H:i:s");
                $Insert_Sector['expiry_date']      = date("Y-m-d",  strtotime($_POST['answer']["exp_date"]));
                

                if( isset( $_POST['api_access'] ) ) {
                    $Insert_Sector['api_access']       = $_POST['api_access'];
                } else {
                    $Insert_Sector['api_access']       = 0;
                }
                if( isset( $_POST['mobile_app_access'] ) ) {
                    $Insert_Sector['mobile_app_access']       = $_POST['mobile_app_access'];
                } else {
                    $Insert_Sector['mobile_app_access']       = 0;
                }
                
                $updated = $grouplist->update($Insert_Sector);              
                
                $ipcount=0;
                
                $deletebygroup = "  group_Id='$_GET[auid]'";
                $user_cfs_ipaddress->delete($deletebygroup);  
                
                foreach($_POST['ipAddress'] as $ipdd) {
                    
                    if($ipdd=='' || $ipdd==0) { continue;}
                     
                    $ipstart = $_POST['startRange'][$ipcount];
                    $ipend =  $_POST['endRange'][$ipcount];


                    $Ip_Sector['ipAddress'] =$ipdd;
                    $Ip_Sector['StartRange'] =$ipstart;
                    $Ip_Sector['EndRange'] =$ipend;
                    $Ip_Sector['group_Id'] =$_GET["auid"];

                   // pr($Ip_Sector);
                    $user_cfs_ipaddress->update($Ip_Sector);      

                    $ipcount++;

                }
                
                $template->assign('updated',"Updated Successfully!!!");
               
	}	
}


if($_REQUEST["auid"] != ""){
	$where = "Group_Id = '".$_REQUEST['auid']."' ";
	$GroupList1 = $grouplist->getFullList("1","1",$fields=array("*"),$where,$order,"name");
       
        if ($GroupList1['poc']=='') { $GroupList1['poc'] = 'info@ventureintelligence.com';  }
        if ($GroupList1[0]['expiry_date']!='') 
        { 
            $GroupList1[0]['expiry_date'] = date('d-m-Y',  strtotime($GroupList1[0]['expiry_date']));
            
        }
        $GroupIp = $grouplist->getGroupIP($_REQUEST['auid']);
	//pr($GroupIp);
        
        $Industry = $GroupList1[0]['Industry'];
        $where= " Industry_Id  IN ($Industry)";        
        $getindustries = $industries->getIndustriesname($where);
         
        
        
        
	$template->assign("GroupList1",$GroupList1);
        $template->assign("GroupListIp",$GroupIp);
}		


$getindustriesid=array();
foreach($getindustries as $getindus)
{
           array_push($getindustriesid, $getindus['id']);    
}


$template->assign("industries" , $industries->getIndustries($where6,$order6));
$template->assign("getindustriesid" ,$getindustriesid);
$template->assign("grouplist" , $grouplist->getGroup($where2));
$template->assign('pageTitle',"CFS - Edit Group ");
$template->assign('pageDescription',"CFS - Edit Group ");
$template->assign('pageKeyWords',"CFS - Edit Group ");
$template->display("admin/editadmingroup.tpl");

?>