<?php

include "header.php";
include "sessauth.php";
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();

//pr($_REQUEST);

$totcompany = $cprofile->count($where66);

pr($totcompany);

/*Year Starts*/
	for($i=2011; $i>=2006; $i--){
		$test = str_split($i,2);
		//$test = ereg_replace("[^0-9]", "", $i);
		$BYearArry[$test[1]] .=  $i;	
	}
	$template->assign('selectedYear', $Selectedyear);
	$template->assign('BYearArry', $BYearArry);
/*Year Ends*/	
if($authAdmin->user->elements['Permissions'] == 0){
	$where .=  "  Permissions1  = ".$authAdmin->user->elements['Permissions'];
	//pr($where);
}elseif($authAdmin->user->elements['Permissions'] == 1){
	$where .=  "  Permissions1  = ".$authAdmin->user->elements['Permissions'];
//	pr($where);
}	

if($authAdmin->user->elements['CountingStatus'] == 0){
	$where .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
	//pr($where);
}elseif($authAdmin->user->elements['CountingStatus'] == 1){
	$where .=  " and UserStatus  = ".$authAdmin->user->elements['CountingStatus'];
}	
//pr($authAdmin);
$order = " SCompanyName Asc";
$template->assign("companies" , $cprofile->getCompaniesCompare($where,$order));

$template->assign('pageTitle',"CFS - Compare Company(s)");
$template->assign('pageDescription',"CFS - Compare Company(s)");
$template->assign('pageKeyWords',"CFS - Compare Company(s)");


//testing purpose

if($authAdmin->user->elements['Permissions'] == 0){
	$where76 .=  "b.Permissions1  = ".$authAdmin->user->elements['Permissions']." and ";
	//pr($where);
}elseif($authAdmin->user->elements['Permissions'] == 1){
	$where76 .=  "b.Permissions1  = ".$authAdmin->user->elements['Permissions']." and ";
//	pr($where);
}	

if($authAdmin->user->elements['CountingStatus'] == 0){
	$where76 .=  "b.UserStatus  = ".$authAdmin->user->elements['CountingStatus']." and";;
	//pr($where);
}elseif($authAdmin->user->elements['CountingStatus'] == 1){
	$where76 .=  "b.UserStatus  = ".$authAdmin->user->elements['CountingStatus']." and";
}	
$fields76 = array("a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus","a.TotalIncome","b.FYCount","b.Permissions1","b.UserStatus");
$where76 .= " a.CId_FK = b.Company_Id"; // Original Where
$group76 = " b.SCompanyName ";
//pr($where76);
$SearchResults76 = $plstandard->SearchHome($fields76,$where76,$order76,$group76);
//pr($SearchResults6);
$totcprofile1=count($SearchResults76);
pr($totcprofile1);



$template->display('compare.tpl');
include("footer.php");

?>