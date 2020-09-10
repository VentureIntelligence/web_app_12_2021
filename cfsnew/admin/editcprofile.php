<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Edit Company Profile' );
include "conf_Admin.php";
require_once MODULES_DIR."countries.php";
$countries = new countries();
require_once MODULES_DIR."city.php";
$city = new city();
require_once MODULES_DIR."state.php";
$state = new state();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."growthpercentage.php";
$growthpercentage = new growthpercentage();
require_once MODULES_DIR."cagr.php";
$cagr = new cagr();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

//pr($_POST);//exit;
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

//pr($_REQUEST);//exit;
//pr($_FILES);
//PL Standard
$PLSFields = array("PLStandard_Id","FY");
$PLSwhere = " CId_FK = ".$_GET['cpid'];
$PLSEXitsChk = $plstandard->getFullList(1,10,$PLSFields,$PLSwhere,"PLStandard_Id ASC","name");
$YearCount=count($PLSEXitsChk);//exit;

//Growth percentage
$GRFields = array("GrowthPerc_Id","FY");
$GRwhere = " CId_FK = ".$_GET['cpid'];
$GREXitsChk = $growthpercentage->getFullList(1,10,$GRFields,$GRwhere,"GrowthPerc_Id ASC","name");
$YearCount1=count($GREXitsChk);//exit;
//pr($GREXitsChk);

//cagr
$CAGRFields = array("CAGR_Id","FY");
$CAGRwhere = " CId_FK = ".$_GET['cpid'];
$CAGREXitsChk = $cagr->getFullList(1,10,$CAGRFields,$CAGRwhere,"CAGR_Id ASC","name");
$YearCount2=count($CAGREXitsChk);//exit;

//T-950 cfs tag 
$where = "Company_Id = '".$_REQUEST['cpid']."' ";
	$CProfileList = $cprofile->getFullListNew("1","1",$fields=array("*"),$where,$order,"name");
	//pr($CProfileList);
	$template->assign("CProfileList",$CProfileList);
	$where = "IndustryId_FK = ".$CProfileList[0]['Industry']." AND Sector_Id = " . $CProfileList[0]['Sector'];
	$wheretag= "cin = '".$CProfileList[0]['CIN']."'";
	$tagcin=$cprofile->tagcininput($wheretag);

//pr($CAGREXitsChk);

if(isset($_POST["UpdateCProfile"])){
	if($_POST['answer']["SCompanyName"]!= ""){
		$Update_CProfile['Company_Id']       = $_GET['cpid'];
		$Update_CProfile['SCompanyName']       = $_POST['answer']["SCompanyName"];
		$Update_CProfile['FCompanyName']          = $_POST['answer']["FCompanyName"];
		$Update_CProfile['GroupCStaus']    = $_POST['answer']["GroupCStaus"];
		$Update_CProfile['ParentCompany']    = $_POST['answer']["ParentCompany"];
		$Update_CProfile['FormerlyCalled']   = $_POST['answer']["FormerlyCalled"];
		$Update_CProfile['Industry']       = $_POST['answer']["Industry"];
		$Update_CProfile['Permissions1']	= $_POST['answer']['permissions'];
		//$Update_CProfile['UserStatus']	=	$_POST['answer']['UserStatus'];
		$Update_CProfile['Sector']      = $_POST['answer']["Sector"];
		$Update_CProfile['SubSector']           = $_POST['answer']["SubSector"];


		$Update_CProfile['BusinessDesc']       = $_POST['answer']["BusinessDesc"];
		$Update_CProfile['Brands']          = $_POST['answer']["Brands"];
		$Insert_CProfile['Country']    = '113'; // 113 = india
		$state->select($_POST['answer']["State"]);
		$Update_CProfile['RegionId_FK']    = $state->elements["Region"];
		$Update_CProfile['IncorpYear']           = $_POST['answer']["IncorpYear"];
		$Update_CProfile['ListingStatus']       = $_POST['answer']["ListingStatus"];

		$Update_CProfile['company_status']       = $_POST['answer']["company_status"];
		$Update_CProfile['RocCode']           = $_POST['answer']["RocCode"];
		$Update_CProfile['RegNumber']         = $_POST['answer']["RegNumber"];
		$Update_CProfile['AuthorisedCapital'] = $_POST['answer']["AuthorisedCapital"];
		$Update_CProfile['PaidCapital']       = $_POST['answer']["PaidCapital"];
		
		$Update_CProfile['StockBSE']      = $_POST['answer']["StockBSE"];
		$Update_CProfile['StockNSE']           = $_POST['answer']["StockNSE"];
		$Update_CProfile['IPODate']       = $_POST['answer']["IPODate"];
		$Update_CProfile['AddressHead']          = $_POST['answer']["AddressHead"];
		$Update_CProfile['AddressLine2']    = $_POST['answer']["AddressLine2"];
		$Update_CProfile['City']    = $_POST['answer']["City"];
		$Update_CProfile['State']           = $_POST['answer']["State"];
		$Update_CProfile['Pincode']       = $_POST['answer']["Pincode"];
		$Update_CProfile['AddressCountry']      = $_POST['answer']["AddressCountry"];
		$Update_CProfile['Phone']           = $_POST['answer']["Phone"];
		$Update_CProfile['Fax']       = $_POST['answer']["Fax"];
		$Update_CProfile['Email']          = $_POST['answer']["Email"];
		$Update_CProfile['Website']    = $_POST['answer']["Website"];
                $linkedInURL=rtrim($_POST['answer']["LinkedIn"],'/');
                $linkedInURL=str_replace('/company-beta/','/company/',$linkedInURL);
                $Update_CProfile['LinkedIn']    = $linkedInURL;
		$Update_CProfile['CEO']    = $_POST['answer']["CEO"];
		$Update_CProfile['CFO']           = $_POST['answer']["CFO"];
		$Update_CProfile['auditor_name']           = $_POST['answer']["auditor_name"];
                $Update_CProfile['rgthcr']           = $_POST['answer']["rgthcr"];
		$Update_CProfile['Added_Date']      = date("Y-m-d:H:i:s");
		$Update_CProfile['CIN']           = $_POST['answer']["CIN"];
		$Update_CProfile['Old_CIN']           = $_POST['answer']["Old_CIN"];
		$Update_CProfile['Total_Income_equal_OpIncome']    = $_POST['answer']["Total_Income_equal_OpIncome"];
	
//T-950 cfs tag
		$Update_CProfile1['CIN']           = $_POST['answer']["CIN"];
		$Update_CProfile1['tags']    = $_POST['answer']["tags"];
		
		//pr($_POST['answer']["Phone"]);
		//pr($Update_CProfile);
		$sectors->updatenaicscode($Update_CProfile[ 'Sector' ], $Update_CProfile['Industry'], $_POST['answer']["Naics_code"]);
		$cprofile->update($Update_CProfile);
		//T-950 cfs tag
		if(empty($tagcin)) {
			$cprofile->tagsinput($Update_CProfile1,"insert");
	   }else{
		$cprofile->tagsinput($Update_CProfile1,"update");
	   }
		//pr($cprofile);
                $rgthcrVal = $cprofile->elements['rgthcr'];
                $CId_No = $cprofile->elements['Company_Id'];
                if($rgthcrVal > 0)
                {
                    $PLSFields = array("PLStandard_Id","FY");
                    $PLSwhere = " CId_FK = ".$CId_No." && (ResultType =0 || ResultType =1)";
                    $PLSEXitsChk = $plstandard->getFullList(1,10,$PLSFields,$PLSwhere,"PLStandard_Id ASC","name");
                     //pr($PLSEXitsChk);
                    $Insert_PLStandard['CId_FK'] = $CId_No;
                    if($PLSEXitsChk[0]['PLStandard_Id'] == ""){
                        
                             $plstandard->update($Insert_PLStandard);
                     }  
                     header("Location:editcprofile.php?cpid=".$CId_No);
                }
                else
                {
			$cprofile->select($_GET['cpid']);	
			$IndustryId = $cprofile->elements["Industry"];
			$k=0;
			for ($k = 0; $k < $YearCount; $k++) {
					$Insert_PLStdrd['PLStandard_Id']          = $PLSEXitsChk[$k]['PLStandard_Id'];
					$Insert_PLStdrd['CId_FK']                 = $_GET['cpid'];
						
						$Insert_PLStdrd['IndustryId_FK']          = $IndustryId;
						$Insert_PLStdrd['Added_Date']             = date("Y-m-d:H:i:s");
						$plstandard->update($Insert_PLStdrd);
			}
			$cprofile->select($_GET['cpid']);	
			$IndustryId = $cprofile->elements["Industry"];
			$i=0;
			for ($i = 0; $i < $YearCount1; $i++) {
					$Insert_GRStdrd['GrowthPerc_Id']          = $GREXitsChk[$i]['GrowthPerc_Id'];
					$Insert_GRStdrd['CId_FK']                 = $_GET['cpid'];
						
						$Insert_GRStdrd['IndustryId_FK']          = $IndustryId;
						$Insert_GRStdrd['Added_Date']             = date("Y-m-d:H:i:s");
						$growthpercentage->update($Insert_GRStdrd);
			}
			$cprofile->select($_GET['cpid']);	
			$IndustryId = $cprofile->elements["Industry"];
			$j=0;
			for ($j = 0; $j < $YearCount2; $j++) {
					$Insert_CAGRStdrd['CAGR_Id']          = $CAGREXitsChk[$j]['CAGR_Id'];
					$Insert_CAGRStdrd['CId_FK']                 = $_GET['cpid'];
						
						$Insert_CAGRStdrd['IndustryId_FK']          = $IndustryId;
						$Insert_CAGRStdrd['Added_Date']             = date("Y-m-d:H:i:s");
						$cagr->update($Insert_CAGRStdrd);
			}
                }
            }	
		//pr($PLSEXitsChk);//exit;
		//header("Location:pmanagement.php");
}
//T-950 cfs tag
if($_REQUEST["cpid"] != ""){
	$where = "Company_Id = '".$_REQUEST['cpid']."' ";
	$CProfileList = $cprofile->getFullListNew("1","1",$fields=array("*"),$where,$order,"name");
	//pr($CProfileList);
	$template->assign("CProfileList",$CProfileList);
	$where = "IndustryId_FK = ".$CProfileList[0]['Industry']." AND Sector_Id = " . $CProfileList[0]['Sector'];
	$wheretag= "cin = '".$CProfileList[0]['CIN']."'";
	$tagcin=$cprofile->tagcininput($wheretag);
	//pr($tagcin);
	$template->assign("taglist",$tagcin);
	$naics_code = $sectors->getSectorsNaicsCode( $where );
	$template->assign("Naics_code",$naics_code);
	
}	


/*Delete Function Starts*/
if($_REQUEST["op"] == "delete" && $_REQUEST["extra"] != ""){
	$cprofile->delete($_REQUEST["extra"]);
}
/*Delete Function Ends*/

//pr($DealsList);
$template->assign('GroupCStaus',$GroupCStaus);
$template->assign('ListingStatus',$ListingStatus);
$template->assign('CountryList',$CountryList);


// if($_REQUEST["cpid"] != ""){
// 	$where = "Company_Id = '".$_REQUEST['cpid']."' ";
// 	$CProfileList = $cprofile->getFullListNew("1","1",$fields=array("*"),$where,$order,"name");
// 	//pr($CProfileList[0]);
// 	$template->assign("CProfileList",$CProfileList);
// 	$where = "IndustryId_FK = ".$CProfileList[0]['Industry']." AND Sector_Id = " . $CProfileList[0]['Sector'];
// 	$naics_code = $sectors->getSectorsNaicsCode( $where );
// 	$template->assign("Naics_code",$naics_code);
// }		

/*Year Starts*/
$currentyear=date('Y');
	for($i=1800; $i<=$currentyear; $i++){
		$BYearArry[$i] = $i;	
	}
	
	$Selectedyear = date('Y');
	$template->assign('selectedYear', $Selectedyear);
	$template->assign('BYearArry', $BYearArry);
/*Year Ends*/
 $where2=" Country_Id='113'  ";  // 113 = india

$template->assign("cid" , $_REQUEST['cpid']);
$template->assign("countries" , $countries->getCountries($where2,$order2));
$template->assign("state" , $state->getState());
$template->assign("city" , $city->getCity());
$template->assign("industries" , $industries->getIndustries());
$template->assign("sectors" , $sectors->getSectors('','SectorName ASC'));
$template->assign('pageTitle',"Edit Company Profile");
$template->assign('pageDescription',"Edit Company Profile");
$template->assign('pageKeyWords',"Edit Company Profile");
$template->display('admin/editcprofile.tpl');

?>