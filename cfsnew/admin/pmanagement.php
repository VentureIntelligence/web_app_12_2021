<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Company profile' );
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();

require_once MODULES_DIR."countries.php";
$countries = new countries();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//pr($_REQUEST);//exit;
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}
	
/*Delete Function Starts*/
if($_REQUEST["op"] == "delete" && $_REQUEST["extra"] != ""){
	$cprofile->delete($_REQUEST["extra"]);
}
/*Delete Function Ends*/

/*Change Status Function Starts*/
if($_REQUEST["op"] == "changestatus" && $_REQUEST["status"] != ""){
	$UpdateStatus['Company_Id']     = $_REQUEST["status"];
	if($_REQUEST["edstatus"] == "Enable"){
		$UpdateStatus['Profile_Flag']    = 1;
	}else{
		$UpdateStatus['Profile_Flag']    = 0;
	}	
	$cprofile->update($UpdateStatus);
}
/*Change Status Function Ends*/
$z=0;
	for ($i=65; $i<=90; $i++) {
		$alphaletter[$z] = chr($i);
		$z++;
	}
	$template->assign('alphaletter',$alphaletter);
	
        if(isset($_GET['pag'])){
		$where = "FCompanyName like '".$_GET['pag']."%'";   
                $template->assign('setalphaletter',$_GET['pag']);
                
	}
        
        if(isset($_GET['searchname'])){
		 if($_GET['searchby']==0){$where = "FCompanyName like '%".$_GET['searchname']."%'";}
                 else if($_GET['searchby']==1){
                 	//$where = "CIN like '%".$_GET['searchname']."%'";
                 	$where = "CIN like '%".$_GET['searchname']."%' OR Old_CIN like '%".$_GET['searchname']."%'";
                 }
                 
                
                $template->assign('searchname',$_GET['searchname']);
                $template->assign('searchby',$_GET['searchby']);
                
	}
        
/*Pagination Starts*/
	$Page = ($_REQUEST["page"]) ? ($_REQUEST["page"]) : "1" ;
	$Row = ($_GET["rows"]) ? ($_GET["rows"]) : "50";
	
	$Fields = array("Company_Id","SCompanyName","FCompanyName", "ParentCompany", "CIN", "Country", "Email","Website","CEO","CFO","Profile_Flag","Added_Date");
	
	$CProfileList = $cprofile->getFullListAdmin($Page,$Row,$Fields,"$where","FCompanyName asc","name");
	//pr($CProfileList);
	
        if(isset($_GET['pag'])){ 
            $ListCnt = $cprofile->count($where);   
            $pag=$_GET['pag'];
            
        } else if(isset($_GET['searchname'])){ 
            $ListCnt = $cprofile->count($where);   
            $search_pag=$_GET['searchname'];
            $search_by=$_GET['searchby'];
            
        } else {
            $ListCnt = $cprofile->count();           
            
        }
	$pages = pager($Page,$Row,$ListCnt);
	if($ListCnt == 0){
		$pages['first'] = '0';
		$pages['next'] = '0';
		$pages['previous'] = '0';
		$pages['last'] = '0';		
	}
	
        if($pag!=''){
        $pages['link'] = 'http://'.DOMAIN.WEB_DIR.'admin/pmanagement.php?pag='.$pag.'&page=';
        }
        else if($search_pag!=''){
        $pages['link'] = 'http://'.DOMAIN.WEB_DIR.'admin/pmanagement.php?searchname='.$search_pag.'&searchby='.$search_by.'&page=';
        }
        else {
         $pages['link'] = 'http://'.DOMAIN.WEB_DIR.'admin/pmanagement.php?page='; 
        }
        
        $template->assign('pages_New', $pages);
//pr($UsersList);
/*Pagination Ends*/

$template->assign('CProfileList',$CProfileList);


$template->assign('pageTitle',"Profile Management");
$template->assign('pageDescription',"Profile Management");
$template->assign('pageKeyWords',"Profile Management");
$template->display('admin/pmanagement.tpl');

?>