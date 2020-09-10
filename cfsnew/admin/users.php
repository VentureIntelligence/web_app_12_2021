<?php

session_start();
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'User Management' );
include "sessauth.php";

require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();

require_once MODULES_DIR."admin_user.php";
$adminuser = new adminuser();

require_once MODULES_DIR."users.php";
$user = new users();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//pr($_REQUEST);//exit;
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}
	
$url='';

if(isset($_REQUEST['sortby'])){
        $sortby = $_REQUEST['sortby'];
        $order = $_REQUEST['order']; 
        $orderby = $sortby."  ".$order;

        if($order=='asc'){ $ch_order='desc';}
        else if($order=='desc'){ $ch_order='asc';}

           if($sortby=='username'){
                $clicksort1 ="('username','$ch_order')";
                $template->assign('usernameclicksort',$clicksort1 );

                $clicksort2 ="('G_Name','asc')";
                $template->assign('groupnameclicksort',$clicksort2 );
           }
           else if($sortby=='G_Name'){

                $clicksort1 ="('username','asc')";
                $template->assign('usernameclicksort',$clicksort1 );

                $clicksort2 ="('G_Name','$ch_order')";
                $template->assign('groupnameclicksort',$clicksort2 );
           }

//               $template->assign('sortby',$sortby);
//               $template->assign('order',$order);
              
               $url.="sortby=$sortby&order=$order&";
}
else {
         $clicksort1 ="('username','asc')";
         $template->assign('usernameclicksort',$clicksort1 );
         
         
         $clicksort2 ="('G_Name','asc')";
         $template->assign('groupnameclicksort',$clicksort2 );
         
}


if(isset($_REQUEST['groupid']) && $_REQUEST['groupid']>0){
    $groupid = $_REQUEST['groupid']; 
    $template->assign('groupid',$groupid);
    $where = "  GroupList=$groupid  ";
    $url.= "groupid=$groupid&";
}

// multi delete
if(isset($_REQUEST['dlt_userid']) && count($_REQUEST['dlt_userid'])>0 ){
    
    foreach($_REQUEST['dlt_userid'] as $dltuserid){        
       $user->delete($dltuserid);
    }
   
}


if(isset($_REQUEST['usernamesuggest']) && $_REQUEST['usernamesuggest']!=''){
    $usernamesuggest = $_REQUEST['usernamesuggest']; 
    $template->assign('usernamesuggest',$usernamesuggest);
    $where = "  username LIKE '%$usernamesuggest%'  ";
    $url.= "usernamesuggest=$usernamesuggest&";
}

/*Delete Function Starts*/
if($_REQUEST["op1"] == "delete" && $_REQUEST["extra1"] != ""){
       
	 $user->delete($_REQUEST["extra1"]);
}
/*Delete Function Ends*/

/*Change Status Function Starts*/
if($_REQUEST["op1"] == "changestatus" && $_REQUEST["status1"] != ""){
	$UpdateStatus['user_id']     = $_REQUEST["status1"];
	if($_REQUEST["edstatus1"] == "Enable"){
		$UpdateStatus['usr_flag']    = 2;
	}else{
		$UpdateStatus['usr_flag']    = 0;
	}	
	$user->update($UpdateStatus);
}
/*Change Status Function Ends*/




/*Pagination Starts*/
	$Page = ($_REQUEST["page"]) ? ($_REQUEST["page"]) : "1" ;
	$Row = ($_GET["rows"]) ? ($_GET["rows"]) : "20";
	
	$Fields1 = array("user_id","trim(username) as username","firstname", "lastname", "user_password", "email","usr_flag","Added_Date", "G_Name");
	
        if($orderby==''){
            $orderby = 'Added_Date desc';
        }
        
	$UserList = $user->getFullList_withgroupname($Page,$Row,$Fields1,$where,$orderby,"name");
        
        
        $ListCnt = $user->count_withgroupname($where);
        //echo $ListCnt; exit;
	$pages = pager($Page,$Row,$ListCnt);
	if($ListCnt == 0){
		$pages['first'] = '0';
		$pages['next'] = '0';
		$pages['previous'] = '0';
		$pages['last'] = '0';		
	}
        
        $pages['link'] = 'users.php?'.$url.'page=';        
	//pr($pages);
        $template->assign('pages_New', $pages);
        
         $template->assign('Page', $Page);
        
        
//pr($UsersList);
/*Pagination Ends*/

$template->assign('UserList',$UserList);


$template->assign("grouplist" , $grouplist->getGroup($where7));
$template->assign('pageTitle',"User(s) Management");
$template->assign('pageDescription',"User(s) Management");
$template->assign('pageKeyWords',"User(s) Management");
$template->display('admin/users.tpl');

?>