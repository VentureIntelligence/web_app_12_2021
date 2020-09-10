<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Company Profile' );
include "conf_Admin.php";
require_once MODULES_DIR."countries.php";
$countries = new countries();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
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
	
if(isset($_POST["AddCProfile"])){
	if($_POST['answer']["SCompanyName"]!= ""){
		$Insert_CProfile['SCompanyName']       = $_POST['answer']["SCompanyName"];
		$Insert_CProfile['FCompanyName']          = $_POST['answer']["FCompanyName"];
		$Insert_CProfile['GroupCStaus']    = $_POST['answer']["GroupCStaus"];
		$Insert_CProfile['ParentCompany']    = $_POST['answer']["ParentCompany"];
		$Insert_CProfile['FormerlyCalled']           = $_POST['answer']["FormerlyCalled"];
		$Insert_CProfile['Permissions1']	= $_POST['answer']['permissions'];
		//$Insert_CProfile['UserStatus']	=	$_POST['answer']['UserStatus'];
		$Insert_CProfile['Industry']       = $_POST['answer']["Industry"];
		$Insert_CProfile['Sector']      = $_POST['answer']["Sector"];
		$Insert_CProfile['SubSector']           = $_POST['answer']["SubSector"];


		$Insert_CProfile['BusinessDesc']       = $_POST['answer']["BusinessDesc"];
		$Insert_CProfile['Brands']          = $_POST['answer']["Brands"];
		$Insert_CProfile['Country']    = '113'; // 113 = india
		$Insert_CProfile['RegionId_FK']    = $_POST['answer']["Region"];
		$Insert_CProfile['IncorpYear']           = $_POST['answer']["IncorpYear"];
		$Insert_CProfile['ListingStatus']       = $_POST['answer']["ListingStatus"];
		
		$Insert_CProfile['company_status']           = $_POST['answer']["company_status"];
		$Insert_CProfile['RocCode']           = $_POST['answer']["RocCode"];
		$Insert_CProfile['RegNumber']         = $_POST['answer']["RegNumber"];
		$Insert_CProfile['AuthorisedCapital'] = $_POST['answer']["AuthorisedCapital"];
		$Insert_CProfile['PaidCapital']       = $_POST['answer']["PaidCapital"];

		$Insert_CProfile['StockBSE']      = $_POST['answer']["StockBSE"];
		$Insert_CProfile['StockNSE']           = $_POST['answer']["StockNSE"];
		$Insert_CProfile['IPODate']       = $_POST['answer']["IPODate"];
		$Insert_CProfile['AddressHead']          = $_POST['answer']["AddressHead"];
		$Insert_CProfile['AddressLine2']    = $_POST['answer']["AddressLine2"];
		$Insert_CProfile['City']    = $_POST['answer']["City"];
		$Insert_CProfile['State']           = $_POST['answer']["State"];
		$Insert_CProfile['Pincode']       = $_POST['answer']["Pincode"];
		$Insert_CProfile['AddressCountry']      = $_POST['answer']["AddressCountry"];
		$Insert_CProfile['Phone']           = $_POST['answer']["Phone"];
		$Insert_CProfile['Fax']       = $_POST['answer']["Fax"];
		$Insert_CProfile['Email']          = $_POST['answer']["Email"];
		$Insert_CProfile['Website']    = $_POST['answer']["Website"];
                $linkedInURL=rtrim($_POST['answer']["LinkedIn"],'/');
                $linkedInURL=str_replace('/company-beta/','/company/',$linkedInURL);
                $Insert_CProfile['LinkedIn']    = $linkedInURL;
		$Insert_CProfile['CEO']    = $_POST['answer']["CEO"];
		$Insert_CProfile['CFO']           = $_POST['answer']["CFO"];
		$Insert_CProfile['auditor_name']           = $_POST['answer']["auditor_name"];
                $Insert_CProfile['rgthcr']           = $_POST['answer']["rgthcr"];
		$Insert_CProfile['Added_Date']      = date("Y-m-d:H:i:s");
		$Insert_CProfile['CIN']           = $_POST['answer']["CIN"];
		$Insert_CProfile['Old_CIN']           = $_POST['answer']["Old_CIN"];
		$Insert_CProfile['Total_Income_equal_OpIncome']    = $_POST['answer']["Total_Income_equal_OpIncome"];
		
		$Insert_CProfile1['CIN']           = $_POST['answer']["CIN"];
		$Insert_CProfile1['tags']    = $_POST['answer']["tags"];
		
		$sectors->updatenaicscode($Insert_CProfile[ 'Sector' ], $Insert_CProfile['Industry'], $_POST['answer']["Naics_code"]);
		$cprofile->update($Insert_CProfile);
		
		$cprofile->tagsinput($Insert_CProfile1,"insert");

                //print_r($cprofile);
                //end of cprofile insertion
                //start of plstandard insertion
                $CId_No = $cprofile->elements['Company_Id'];
               
                $PLSFields = array("PLStandard_Id","FY");
                $PLSwhere = " CId_FK = ".$CId_No." && (ResultType =0 || ResultType =1)";
                $PLSEXitsChk = $plstandard->getFullList(1,10,$PLSFields,$PLSwhere,"PLStandard_Id ASC","name");
                 //pr($PLSEXitsChk);//exit;

                if($PLSEXitsChk[0]['PLStandard_Id'] != ""){
                         $template->assign('AskConfirm',"AskConfirm");
                         $template->assign('CompanyId',$this->elements[$this->pkName]);

                 }
                 $Insert_PLStandard = array();
                    if($PLSEXitsChk[$k]['PLStandard_Id'] != " "){
                            $Insert_PLStandard['PLStandard_Id']          = $PLSEXitsChk[$k]['PLStandard_Id'];

                    }
                 $Insert_PLStandard['CId_FK']                 = $CId_No;
                 $plstandard->update($Insert_PLStandard);
                 
		header("Location:pmanagement.php");
	}	
}


/*Delete Function Starts*/
if($_REQUEST["op"] == "delete" && $_REQUEST["extra"] != ""){
	$cprofile->delete($_REQUEST["extra"]);
}
/*Delete Function Ends*/

//pr($ListingStatus);
$template->assign('GroupCStaus',$GroupCStaus);
$template->assign('ListingStatus',$ListingStatus);
$template->assign('CountryList',$CountryList);

/*Year Starts*/
$currentyear=date('Y');
	$BYearArry[""] = "Please Select a Year";
	for($i=1800; $i<=$currentyear; $i++){
		$BYearArry[$i] .= $i;	
	}
	$template->assign('BYearArry', $BYearArry);
/*Year Ends*/	

$where2=" Country_Id='113'  ";  // 113 = india
        
$order4 = 'SectorName ASC';        
$template->assign("countries" , $countries->getCountries($where2,$order2));
$template->assign("industries" , $industries->getIndustries($where3,$order3));
$template->assign("sectors" , $sectors->getSectors($where4,$order4));
$template->assign('pageTitle',"Add Company Profile");
$template->assign('pageDescription',"Add Company Profile");
$template->assign('pageKeyWords',"Add Company Profile");
$template->display('admin/addcprofile.tpl');

?>