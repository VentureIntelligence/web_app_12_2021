<?php
include "header.php";

require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."news.php";
$news = new news();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."growthpercentage.php";
$growthpercentage = new growthpercentage();
require_once MODULES_DIR."cagr.php";
$cagr = new cagr();

$template->assign("companies" , $cprofile->getCompanies());

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}
//pr($_POST);
if(isset($_POST["EditPLStandard"])){
	if($_POST['answer']["CompanyId"]!= ""){
	    
		if($_POST['answer']["TypeId"]=='plstandard'){
		
			$fields = array("PLStandard_Id","FY","CId_FK","EBITDA","EBDT","EBT","PAT","TotalIncome");
			$where .= "CId_FK = ".$_POST['answer']["CompanyId"];
			$FinanceAnnual = $plstandard->getFullList(1,100,$fields,$where,$order,"name");
			$template->assign("FinanceAnnual",$FinanceAnnual);
			
			$cprofile->select($_POST['answer']["CompanyId"]);
			$template->assign("SCompanyName" , $cprofile->elements['SCompanyName'].'(PL Standard)');
		
		}elseif($_POST['answer']["TypeId"]=='growthpercentage'){
		
			$fields = array("GrowthPerc_Id","FY","CId_FK","EBITDA","EBDT","EBT","PAT","TotalIncome");
			$where .= "CId_FK = ".$_POST['answer']["CompanyId"];
			$FinanceAnnual = $growthpercentage->getFullList(1,100,$fields,$where,$order,"name");
			$template->assign("FinanceAnnual",$FinanceAnnual);
			
			$cprofile->select($_POST['answer']["CompanyId"]);
			$template->assign("SCompanyName" , $cprofile->elements['SCompanyName'].'(YOY Percentage)');
		
		}elseif($_POST['answer']["TypeId"]=='cagr'){
		
			$fields = array("CAGR_Id","FY","CId_FK","EBITDA","EBDT","EBT","PAT","TotalIncome");
			$where .= "CId_FK = ".$_POST['answer']["CompanyId"];
			$FinanceAnnual = $cagr->getFullList(1,100,$fields,$where,$order,"name");
			$template->assign("FinanceAnnual",$FinanceAnnual);
			
			$cprofile->select($_POST['answer']["CompanyId"]);
			$template->assign("SCompanyName" , $cprofile->elements['SCompanyName'].'(CAGR Percentage)');
		
		}
	}	
}

if(isset($_POST['AddPLstandard'])){

$k=0;
	for ($k = 0; $k <= $YearCount-2; $k++) {
			$Insert_PLStandard['PLStandard_Id']          = $PLSEXitsChk[$k]['PLStandard_Id'];
			$Insert_PLStandard['TotalIncome']    		 = $Test[$k][4];
			$Insert_PLStandard['EBITDA']                 = $Test[$k][7];
			$Insert_PLStandard['EBDT']                   = $Test[$k][9];
			$Insert_PLStandard['EBT']                    = $Test[$k][11];
			$Insert_PLStandard['PAT']                    = $Test[$k][13];
			//pr($Insert_PLStandard);
			$Insert_PLStandard['Added_Date']             = date("Y-m-d:H:i:s");
			$plstandard->update($Insert_PLStandard);
	}//For Ends
	//pr($Test);
$l=0;	
for ($l = 0; $l <= $YearCount-3; $l++) {			
		$Insert_GrowthPercent['GrowthPerc_Id']          = $GBSearchSEXitsChk[$l]['GrowthPerc_Id'];
		$Insert_GrowthPercent['TotalIncome']            = ($Test[$l][4] - $Test[$l+1][4]) / ($Test[$l+1][4] )*100;
		$Insert_GrowthPercent['EBITDA']                 = ($Test[$l][7] - $Test[$l+1][7]) / ($Test[$l+1][7] )*100;
		$Insert_GrowthPercent['EBDT']                   = ($Test[$l][9] - $Test[$l+1][9]) / ($Test[$l+1][9] )*100;
		$Insert_GrowthPercent['EBT']                    = ($Test[$l][11] - $Test[$l+1][11]) / ($Test[$l+1][11] )*100;
		$Insert_GrowthPercent['PAT']            = ($Test[$l][13] - $Test[$l+1][13]) / ($Test[$l+1][13] )*100;
		$Insert_GrowthPercent['Added_Date']             = date("Y-m-d:H:i:s");
		//pr($Insert_GrowthPercent);
		$growthpercentage->update($Insert_GrowthPercent);
			
}
/*Growth Based % Values Insertion Ends*/	
	

/*CAGR Insertion Starts*/
require_once MODULES_DIR."cagr.php";
$cagr = new cagr();

$CAGRFields = array("CAGR_Id","FY");
$CAGRwhere = " CId_FK = ".$_REQUEST['answer']['CompanyId'];
$CAGRSearchSEXitsChk = $cagr->getFullList(1,10,$CAGRFields,$CAGRwhere,"CAGR_Id ASC","name");
//pr($GBSearchSEXitsChk);
//pr($Test);//exit;
$l=0;	
for ($l = 0; $l <= $YearCount-3; $l++) {			
		$Insert_CAGR['CAGR_Id']          = $CAGRSearchSEXitsChk[$l]['CAGR_Id'];
		$Insert_CAGR['TotalIncome']            = (pow(($Test[0][4]/$Test[$l+1][4]),(1/2))-1) * 100;
		$Insert_CAGR['EBITDA']                 = (pow(($Test[0][7]/$Test[$l+1][7]),(1/2))-1) * 100;
		$Insert_CAGR['EBDT']                   = (pow(($Test[0][9]/$Test[$l+1][9]),(1/2))-1) * 100;
		$Insert_CAGR['EBT']                    = (pow(($Test[0][11]/$Test[$l+1][11]),(1/2))-1) * 100;
		$Insert_CAGR['PAT']            		   = (pow(($Test[0][13]/$Test[$l+1][13]),(1/2))-1) * 100;
		$Insert_CAGR['Added_Date']             = date("Y-m-d:H:i:s");
				
		$cagr->update($Insert_CAGR);
		//pr($Insert_CAGR);exit;
}
/*CAGR Insertion Ends*/	
	


}
$template->assign('pageTitle',"Add Edit PLStandard");
$template->assign('pageDescription',"Add Edit PLStandard");
$template->assign('pageKeyWords',"Add Edit PLStandard");
$template->display('admin/editplstandard.tpl');

?>