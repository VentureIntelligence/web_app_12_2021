<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Company Financials' );
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//pr($_REQUEST);//exit;
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}
	



/*Delete Function Starts*/
if($_REQUEST["op"] == "delete" && $_REQUEST["extra"] != ""){
	$users->delete($_REQUEST["extra"]);
}
/*Delete Function Ends*/

/*Change Status Function Starts*/
if($_REQUEST["op"] == "changestatus" && $_REQUEST["status"] != ""){
	$UpdateStatus['user_id']     = $_REQUEST["status"];
	if($_REQUEST["edstatus"] == "Enable"){
		$UpdateStatus['usr_flag']    = 1;
	}else{
		$UpdateStatus['usr_flag']    = 0;
	}	
	$plstandard->update($UpdateStatus);
}
/*Change Status Function Ends*/
$z=0;
	for ($i=65; $i<=90; $i++) {
		$alphaletter[$z] = chr($i);
		$z++;
	}
	$template->assign('alphaletter',$alphaletter);
	if(isset($_GET['pag'])){
		$where = "SCompanyName like '".$_GET['pag']."%'";
	}
/*Pagination Starts*/
	$Page = ($_REQUEST["page"]) ? ($_REQUEST["page"]) : "1" ;
        
	//$Row = ($_GET["rows"]) ? ($_GET["rows"]) : $_REQUEST["rowperpage"];
        $Row = ($_REQUEST["rowperpage"]) ? ($_REQUEST["rowperpage"]) : '10';
	
	$Fields = array("a.PLStandard_Id","a.CId_FK", "a.IndustryId_FK","a.FY",'a.Added_Date','b.SCompanyName');
	
	$FinancialList = $plstandard->getFullListFinancials($Page,$Row,$Fields,"$where","a.PLStandard_Id desc","name");
	$ListCnt = $plstandard->countJnCprofile($where);
	$pages = pager($Page,$Row,$ListCnt);
       
	if($ListCnt == 0){
		$pages['first'] = '0';
		$pages['next'] = '0';
		$pages['previous'] = '0';
		$pages['last'] = '0';		
	}
        $pag=($_REQUEST['pag']!='') ? ('&pag='.$_REQUEST['pag']) : '';
        $pages['link'] = 'http://'.DOMAIN.WEB_DIR.'admin/fmanagement.php?rowperpage='.$Row.$pag.'&page=';
	$template->assign('pages_New', $pages);
        $template->assign('rowperpage', $rowperpage);
        
//pr($FinancialList);
/*Pagination Ends*/

$template->assign('FinancialList',$FinancialList);



$template->assign('pageTitle',"Financial Management");
$template->assign('pageDescription',"Financial Management");
$template->assign('pageKeyWords',"Financial Management");
$template->display('admin/fmanagement.tpl');

?>