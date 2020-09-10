<?php

session_start();
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Group Management' );
include "sessauth.php";

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

// require_once MODULES_DIR."grouplist.php";
// $grouplist = new grouplist();
require_once MODULES_DIR."users.php";
$user = new users();
require_once MODULES_DIR."dealcompanies.php";
$dealcompanies = new dealcompanies();

$url='';

if(isset($_REQUEST['sortby'])){
        $sortby = $_REQUEST['sortby'];
        $order = $_REQUEST['order']; 
        $orderby = $sortby."  ".$order;

        if($order=='asc'){ $ch_order='desc';}
        else if($order=='desc'){ $ch_order='asc';}

        if($sortby=='DCompanyName'){
                $clicksort2 ="('DCompanyName','$ch_order')";
                $template->assign('groupnameclicksort',$clicksort2 );
           }

//               $template->assign('sortby',$sortby);
//               $template->assign('order',$order);
              
               $url.="sortby=$sortby&order=$order&";
}
else {  
         $clicksort2 ="('DCompanyName','asc')";
         $template->assign('groupnameclicksort',$clicksort2 );         
}



// if(isset($_REQUEST['GroupStatusChange']) && $_REQUEST['GroupStatusChange']=='changestatus'){
    
    
//     if($_REQUEST['status']=='Disable' && $_REQUEST['Groupid']>0){        
//         $group_list['Group_Id']    = $_REQUEST['Groupid'];
//         $group_list['status']    = 1;
//         $dealcompanies->update($group_list);
        
        
//         // users
//         $user->updatepermission($_REQUEST['Groupid'],0);
        
        
//     }
//     else if($_REQUEST['status']=='Enable' && $_REQUEST['Groupid']>0){
//         $group_list['Group_Id']    = $_REQUEST['Groupid'];
//         $group_list['status']    = 0;
//         $dealcompanies->update($group_list);
        
        
//         // users
//        $user->updatepermission($_REQUEST['Groupid'],2);
//     }
    
    
    
    
// }



/*
if(isset($_POST["EditUser"])){
	if($_POST['answer']["GroupName"]!= ""){
		$Admin_User['Group_Id']    = $_POST['answer']["GroupName"];
		$Admin_User['VisitLimit']     = $_POST['answer']["Limit"];
		$Admin_User['ExLimit']       = $_POST['answer']["ExLimit"];
		if(isset($_POST['answer']["ExLimit"])){
		  $Insert_User['ExDownloadCompany']  = '';
		  $Insert_User['ExDownloadCount']  = '';
		  $user->update($Insert_User);
		}
		$Admin_User['SubLimit']       = $_POST['answer']["subLimit"];
		$grouplist->update($Admin_User);
//		pr($Admin_User);
		header("Location:editGroup.php");
	}	
}
*/
/*Group list*/
/*Pagination Starts*/
	$Page = ($_REQUEST["page"]) ? ($_REQUEST["page"]) : "1" ;
	$Row = ($_GET["rows"]) ? ($_GET["rows"]) : "20";
	
	//  $Fields = array("Group_Id","G_Name","VisitLimit","ExLimit","SubLimit","Used","Create_Date");
	//$Fields = array("*");
//pr($Fields);
	//   $GroupList1 = $grouplist->getFullList($Page,$Row,$Fields1=array('*'),$where,$order,"name");
	
        if(isset($_GET['name'])){
           $name = $_GET['name']; 
           $where = " DCompanyName LIKE '%$name%'"; 
           $url.= "name=$name&";           
           $template->assign('searchname', $name);
           
           
        }
        
        $Fields = array("DCompId","DCompanyName","api_access","admin_api_access");
        if($orderby==''){
            $orderby =" DCompanyName asc";
        }
        
        $GroupList1 = $dealcompanies->getFullListwithusercount($Page,$Row,$Fields,$where,$orderby,"name");
        //pr($GroupList1);
	
	foreach($GroupList1 as $key => $value){
           
            if ($value['expiry_date']!='') 
            { 
                $GroupList1[$key]['expiry_date'] = date('d M Y',  strtotime($value['expiry_date']));

            }
        }
        //pr($GroupList1);
	//pr($GroupList1[0]['Group_Id']);
	$template->assign('GroupList1',$GroupList1);
	
	$ListCnt = $dealcompanies->count($where);
	$pages = pager($Page,$Row,$ListCnt);
	if($ListCnt == 0){
		$pages['first'] = '0';
		$pages['next'] = '0';
		$pages['previous'] = '0';
		$pages['last'] = '0';		
	}
	
        
      //  $pages['link'] = 'http://localhost/ventureintelligence/cfsnew/admin/editGroup-api-pe.php?'.$url.'page=';
        $pages['link'] = 'http://'.DOMAIN.WEB_DIR.'admin/editGroup-api-pe.php?'.$url.'page=';
        
	
        $template->assign('pages_New', $pages);
//pr($UsersList);
/*Pagination Ends*/

$editgroupurl = ADMIN_BASE_URL."editadmingroup-pe.php?auid=";


$template->assign("grouplist" , $dealcompanies->getGroup($where2));
$template->assign("editgroupurl" , $editgroupurl);
$template->assign('pageTitle',"CFS - Group List");
$template->assign('pageDescription',"CFS -  Group List ");
$template->assign('pageKeyWords',"CFS -  Group List ");
$template->display("admin/editGroup-api-pe.tpl");

?>