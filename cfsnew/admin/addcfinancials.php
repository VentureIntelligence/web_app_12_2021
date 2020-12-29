<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add Company Financials' );
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."balancesheet.php";
$balancesheet = new balancesheet();
require_once MODULES_DIR."balancesheet_new.php";
$balancesheet_new = new balancesheet_new();
require_once MODULES_DIR."xbrl.php";
$xbrl = new xbrl_insert();
require_once MODULES_DIR."cashflow.php";
$cashflow = new cashflow();

include_once('PHPExcel/Classes/PHPExcel.php');

require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."city.php";
$city = new city();
require_once MODULES_DIR."countries.php";
$countries = new countries();

//$template->assign("companies" , $cprofile->getCompanies($where2,$order2));
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

$runID = date( 'ymdhis' );
$created_on = date( 'Y-m-d h:i:s' );
if($_REQUEST['answer']['CompanyId'] != ''){
	$companyProfileID = $_REQUEST['answer']['CompanyId'];
} else if($_REQUEST['answer']['New_BSCompanyId']) {
	$companyProfileID = $_REQUEST['answer']['New_BSCompanyId'];
} else if($_REQUEST['answer']['BSCompanyId']) {
	$companyProfileID = $_REQUEST['answer']['BSCompanyId'];
} else if($_REQUEST['answer']['CFCompanyIdnew']) {
	$companyProfileID = $_REQUEST['answer']['CFCompanyIdnew'];
}

//pr($_REQUEST);exit;
//pr($_FILES);
//pr( $_FILES['answer']['tmp_name']["PLStandard"]);

if($_FILES["answer"]["name"]["PLStandard"] != NULL){
			if($_FILES['answer']['name']["PLStandard"] != ""){
			 	//$ExcelCheck = ExcelValid($_FILES['answer']['name']["PLStandard"],$_FILES['answer']['tmp_name']["PLStandard"]);
				//if($ExcelCheck == "1"){
					$PLStandard  = "plstandard";
					$Dir = FOLDER_CREATE_PATH.$PLStandard;
					//pr($Dir);
					if(!is_dir($Dir)){
						mkdir($Dir,0777);chmod($Dir, 0777);
					}
					$UploadedSourceFile = $_FILES['answer']['tmp_name']["PLStandard"];
					if($_REQUEST['ResultType']==0){
						$imageFileName = "PLStandard_".$_REQUEST['answer']['CompanyId'].".xls";
					}else{
						$imageFileName = "PLStandard_".$_REQUEST['answer']['CompanyId']."_1.xls";
					}
					$Target_Path = $Dir.'/';
	//				pr($imageFileName)
					$strOriginalPath = $Target_Path.$imageFileName;
					//pr($strOriginalPath);
					 //move_uploaded_file($_FILES['answer']['tmp_name']["PLStandard"], $strOriginalPath);
					include('uploadCommon.php');
				//}else{
				//	$Error .= "Image Not Valid";
				//}	
		 }
}	
/*Image Upload Ends*/


/*$filename ="excelreport.xls";
$contents = "testdata1 \t testdata2 \t testdata3 \t \n";
header('Content-type: application/ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
echo $contents;*/
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

/*Excel Upload Starts*/
if($_REQUEST['answer']['CompanyId'] != ""){
	if($_REQUEST['ResultType']==0){
		$excel_type = 'S';
                $UploadedFile = "PLStandard_".$_REQUEST['answer']['CompanyId'].".xls";
        }else{
        	$excel_type = 'C';
                $UploadedFile = "PLStandard_".$_REQUEST['answer']['CompanyId']."_1.xls";
        }

    $where11 = "Company_Id = '".$_REQUEST['answer']['CompanyId']."'";
	$Companies11 = $cprofile->getCompaniesCIN( $where11 );
	$companyIDArray = array_keys ( $Companies11 );
	$companyID = $companyIDArray[0];
    $Insert_RegUser['log_file'] = '';
	$Insert_RegUser['cin'] = $companyID;
	$Insert_RegUser['is_error'] = 0;
	$Insert_RegUser['run_id'] = $runID;
	$Insert_RegUser['xml_type'] = '';
	$Insert_RegUser['excel_type'] = $excel_type;
	$Insert_RegUser['view_index'] = 0;
	$Insert_RegUser['created_on'] = $created_on;
	$Insert_RegUser[ 'user_id' ] = $_SESSION[ 'business' ][ 'Ident' ];
	$Insert_RegUser[ 'user_name' ] = $_SESSION[ 'business' ][ 'loggedUserName' ];
	$Insert_RegUser[ 'run_type' ] = 2;
	$Insert_RegUser[ 'run_file' ] = 'PL';
	$xbrl->update( $Insert_RegUser );

        //$UploadedFile = "PLStandard_".$_REQUEST['answer']['CompanyId'].".xls";
	//$UploadedFilePath = "../media/plstandard/".$UploadedFile;
        $UploadedFilePath = FOLDER_CREATE_PATH."plstandard/".$UploadedFile;
        
	require_once 'Excel/reader.php';
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($UploadedFilePath);
	

$YearCount = count($data->sheets[0]['cells'][6]);
$YearCount1 = count($data->sheets[0]['cells'][6]);
//pr($data->sheets);//exit;
	$i=0;
	for ($m = 0; $m <= $YearCount -2; $m++ ) {
			$x=6;
			$i=0;
			for ($x; $x <= count($data->sheets[0]["cells"])+3; $x++) {
				$i++;
				$Test[$m][$i] =  ($data->sheets[0]["cells"][$x][$m+2]=='-')?'NULL':$data->sheets[0]["cells"][$x][$m+2]."<br>";
				//pr($Test[$m][$i]);
			}
	}
    $rowname =  $data->sheets[0]["cells"][10][1];
    $rowname1 =  $data->sheets[0]["cells"][11][1];
	//pr($rowvalue);
$cprofile->select($_REQUEST['answer']['CompanyId']);	
$IndustryId = $cprofile->elements["Industry"];
if($_REQUEST['ResultType'] == 0){
$Insert_YearCount['Company_Id'] = $_REQUEST['answer']['CompanyId'];
$Insert_YearCount['FYCount'] = $YearCount1 - 1;
$Insert_YearCount['GFYCount'] = $YearCount1 - 2;
$cprofile->update($Insert_YearCount);
}
//Find privious data
$FYList = $FYList_N = array();
    $detailCheck=mysql_query("SELECT PLStandard_Id, FY FROM plstandard WHERE CId_FK='".$_REQUEST['answer']['CompanyId']."' and ResultType='".$_REQUEST['ResultType']."'");
    if(mysql_num_rows($detailCheck) > 0){
        while($detailChecks = mysql_fetch_array($detailCheck)){
            $FYList[] = trim($detailChecks['FY']);
        }
       /* for ($k = 0; $k <= $YearCount-2; $k++) {
            if($Test[$k][1] != "<br>" && $Test[$k][1] != ""){
                //$FYList_N[] = trim(ereg_replace("[^0-9mM()]", " ", $Test[$k][1]));
                $FYList_N[] = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
            }
        }
        $result=array_diff($FYList,$FYList_N);*/
        $result= $FYList;
        foreach($result as $val){ 
            if($val !=''){
                mysql_query("DELETE FROM plstandard WHERE CId_FK='".$_REQUEST['answer']['CompanyId']."' and ResultType='".$_REQUEST['ResultType']."' and FY='".$val."'");
                mysql_query("DELETE FROM cagr WHERE CId_FK='".$_REQUEST['answer']['CompanyId']."' and ResultType='".$_REQUEST['ResultType']."' and FY='".$val."'");
                mysql_query("DELETE FROM growthpercentage WHERE CId_FK='".$_REQUEST['answer']['CompanyId']."' and ResultType='".$_REQUEST['ResultType']."' and FY='".$val."'");
            }
        }
    }
//pr($Insert_YearCount['FYCount']);
$PLSFields = array("PLStandard_Id","FY");
$PLSwhere = " CId_FK = ".$_REQUEST['answer']['CompanyId']." && ResultType = ".$_REQUEST['ResultType'];
$PLSEXitsChk = $plstandard->getFullList(1,10,$PLSFields,$PLSwhere,"PLStandard_Id ASC","name");
//pr($PLSEXitsChk);//exit;

if($PLSEXitsChk[0]['PLStandard_Id'] != ""){
	$template->assign('AskConfirm',"AskConfirm");
	$template->assign('CompanyId',$_REQUEST['answer']['CompanyId']);
	
}
//pr($_FILES["answer"]["name"]["PLStandard"]);
$k=0;
	for ($k = 0; $k <= $YearCount-2; $k++) {

		if($Test[$k][1] != "<br>" && $Test[$k][1] != ""){	
				$Insert_PLStandard = array();
				$update_PLStandard = array();
				if($_REQUEST['PLStandardFormat']==1 && $rowname=="Operational, Admin & Other Expenses" && $rowname1=="Operating Profit"){ 
				if($PLSEXitsChk[$k]['PLStandard_Id'] != " " && $PLSEXitsChk[$k]['PLStandard_Id'] != ""){
					$update_PLStandard['PLStandard_Id'] = $Insert_PLStandard['PLStandard_Id']  = $PLSEXitsChk[$k]['PLStandard_Id'];
					$Insert_PLStandard['updated_date']  = date("Y-m-d:H:i:s");
				}  else {
                                    $Insert_PLStandard['Added_Date'] = date("Y-m-d:H:i:s");
                                }//If Ends
					$Insert_PLStandard['CId_FK'] = $_REQUEST['answer']['CompanyId'];
					$Insert_PLStandard['ResultType'] = $_REQUEST['ResultType'];
                                        $Insert_PLStandard['AddFinancials'] = $_REQUEST['answer']['AddFinancials'];
					
					//pr($Insert_PLStandard['ResultType']);
					
					   $Insert_PLStandard['IndustryId_FK']          = $IndustryId;
					if($Test[$k][2] != "NULL"){					
						$Insert_PLStandard['OptnlIncome']            = $Test[$k][2];
					}
					$update_PLStandard['OptnlIncome'] = NULL;   
					//pr($Test[$k][2]);
					if($Test[$k][3] != "NULL"){
						$Insert_PLStandard['OtherIncome']    		 = $Test[$k][3];
					}
                                        $update_PLStandard['OtherIncome'] =  NULL;
					if($Test[$k][4] != "NULL"){
						$Insert_PLStandard['TotalIncome']    		 = $Test[$k][4];
					}	
                                        $update_PLStandard['TotalIncome'] =  NULL;	
						//if($Test[$k][4]=='-'){
							//pr(count($Test[$k][4]));
							//pr($Test[$k][4]);
						//}
					//}
				//pr($Test[$k][4]);
					if($Test[$k][5] != "NULL"){
						$Insert_PLStandard['OptnlAdminandOthrExp']   = $Test[$k][5];
					}
                                        $update_PLStandard['OptnlAdminandOthrExp'] =  NULL;
				//pr($Test[$k][5]);
					if($Test[$k][6] != "NULL"){
						$Insert_PLStandard['OptnlProfit']            = $Test[$k][6];
					}
                                        $update_PLStandard['OptnlProfit'] =  NULL;
					if($Test[$k][7] != "NULL"){
						$Insert_PLStandard['EBITDA']                 = $Test[$k][7];
					}
                                        $update_PLStandard['EBITDA'] =  NULL;
					if($Test[$k][8] != "NULL"){
						$Insert_PLStandard['Interest']               = $Test[$k][8];
					}
                                        $update_PLStandard['Interest'] =  NULL;
					if($Test[$k][9] != "NULL"){
						$Insert_PLStandard['EBDT']                   = $Test[$k][9];
					}
                                        $update_PLStandard['EBDT'] =  NULL;
					if($Test[$k][10] != "NULL"){
						$Insert_PLStandard['Depreciation']           = $Test[$k][10];
					}
                                        $update_PLStandard['Depreciation'] =  NULL;
					if($Test[$k][11] != "NULL"){
						$Insert_PLStandard['EBT_before_Priod_period']                    = $Test[$k][11];
					}
                                        $update_PLStandard['EBT_before_Priod_period'] =  NULL;
					if($Test[$k][12] != "NULL"){
						$Insert_PLStandard['Priod_period']                    = $Test[$k][12];
					}
                                        $update_PLStandard['Priod_period'] =  NULL;
					if($Test[$k][13] != "NULL"){
						$Insert_PLStandard['EBT']                    = $Test[$k][13];
					}
                                        $update_PLStandard['EBT'] =  NULL;
					if($Test[$k][14] != "NULL"){
						$Insert_PLStandard['Tax']                    = $Test[$k][14];
					}
                                        $update_PLStandard['Tax'] =  NULL;
					if($Test[$k][15] != "NULL"){
						$Insert_PLStandard['PAT']                    = $Test[$k][15];
					}
                    $update_PLStandard['PAT'] =  NULL;


                    if($_REQUEST['ResultType'] == 0){

                    	if($Test[$k][17] != "NULL"){
							$Insert_PLStandard['BINR'] = $Test[$k][17];
						}
	                    $update_PLStandard['BINR'] =  NULL;
						if($Test[$k][18] != "NULL"){
							$Insert_PLStandard['DINR'] = $Test[$k][18];
						}
	                    $update_PLStandard['DINR'] =  NULL;
	                    if($Test[$k][20] != "NULL"){
							$Insert_PLStandard['EmployeeRelatedExpenses']  = $Test[$k][20];
						}	
	                    $update_PLStandard['EmployeeRelatedExpenses'] =  NULL;
						if($Test[$k][21] != "NULL"){
							$Insert_PLStandard['ForeignExchangeEarningandOutgo'] = $Test[$k][21];
						}
	                    $update_PLStandard['ForeignExchangeEarningandOutgo'] =  NULL;
						if($Test[$k][22] != "NULL"){
							$Insert_PLStandard['EarninginForeignExchange'] = $Test[$k][22];
						}
	                    $update_PLStandard['EarninginForeignExchange'] =  NULL;
						if($Test[$k][23] != "NULL"){
							$Insert_PLStandard['OutgoinForeignExchange'] = $Test[$k][23];
						}
	                    $update_PLStandard['OutgoinForeignExchange'] =  NULL;

                    } else if($_REQUEST['ResultType'] == 1){
                    	if($Test[$k][16] != "NULL"){
							$Insert_PLStandard['profit_loss_of_minority_interest'] = strip_tags($Test[$k][16]);
						}
	                    $update_PLStandard['profit_loss_of_minority_interest'] =  NULL;
	                    if($Test[$k][17] != "NULL"){
							$Insert_PLStandard['total_profit_loss_for_period'] = strip_tags($Test[$k][17]);
						}
	                    $update_PLStandard['total_profit_loss_for_period'] =  NULL;
	                    if($Test[$k][19] != "NULL"){
							$Insert_PLStandard['BINR'] = $Test[$k][19];
						}
	                    $update_PLStandard['BINR'] =  NULL;
	                    if($Test[$k][20] != "NULL"){
							$Insert_PLStandard['DINR'] = $Test[$k][20];
						}
	                    $update_PLStandard['DINR'] =  NULL;
	                    if($Test[$k][22] != "NULL"){
							$Insert_PLStandard['EmployeeRelatedExpenses'] = $Test[$k][22];
						}
	                    $update_PLStandard['EmployeeRelatedExpenses'] =  NULL;
	                    if($Test[$k][23] != "NULL"){
							$Insert_PLStandard['ForeignExchangeEarningandOutgo'] = $Test[$k][23];
						}
	                    $update_PLStandard['ForeignExchangeEarningandOutgo'] =  NULL;
	                    if($Test[$k][24] != "NULL"){
							$Insert_PLStandard['EarninginForeignExchange'] = $Test[$k][24];
						}
	                    $update_PLStandard['EarninginForeignExchange'] =  NULL;
	                    if($Test[$k][25] != "NULL"){
							$Insert_PLStandard['OutgoinForeignExchange'] = $Test[$k][25];
						}
	                    $update_PLStandard['OutgoinForeignExchange'] =  NULL;
                    	
                    }
                    if($_REQUEST['Restate'] == 1){
						$Companies = $cprofile->updateRestart( $companyID , true );
						$Companieslog = $xbrl->updateRestart( $companyID,$runID, true );
					} else {
						$Companies = $cprofile->updateRestart( $companyID , false );
						$Companieslog = $xbrl->updateRestart( $companyID,$runID, false );
					}
                }else if($_REQUEST['PLStandardFormat']==2 && $rowname=="Cost of materials consumed" && $rowname1=="Purchases of stock-in-trade")
                {
                	if($PLSEXitsChk[$k]['PLStandard_Id'] != " " && $PLSEXitsChk[$k]['PLStandard_Id'] != ""){
						$update_PLStandard['PLStandard_Id'] = $Insert_PLStandard['PLStandard_Id']  = $PLSEXitsChk[$k]['PLStandard_Id'];
						$Insert_PLStandard['updated_date']  = date("Y-m-d:H:i:s");
					}  else {
                                    $Insert_PLStandard['Added_Date'] = date("Y-m-d:H:i:s");
                                }//If Ends
					$Insert_PLStandard['CId_FK'] = $_REQUEST['answer']['CompanyId'];
					$Insert_PLStandard['ResultType'] = $_REQUEST['ResultType'];
                                        $Insert_PLStandard['AddFinancials'] = $_REQUEST['answer']['AddFinancials'];
					
					//pr($Insert_PLStandard['ResultType']);
					
					   $Insert_PLStandard['IndustryId_FK']          = $IndustryId;
					if($Test[$k][2] != "NULL"){					
						$Insert_PLStandard['OptnlIncome']            = $Test[$k][2];
					}
					$update_PLStandard['OptnlIncome'] = NULL;   
					//pr($Test[$k][2]);
					if($Test[$k][3] != "NULL"){
						$Insert_PLStandard['OtherIncome']    		 = $Test[$k][3];
					}
                                        $update_PLStandard['OtherIncome'] =  NULL;
					if($Test[$k][4] != "NULL"){
						$Insert_PLStandard['TotalIncome']    		 = $Test[$k][4];
					}	
                                        $update_PLStandard['TotalIncome'] =  NULL;	
					
					if($Test[$k][5] != "NULL"){
						$Insert_PLStandard['CostOfMaterialsConsumed'] = $Test[$k][5];
					}
					$update_PLStandard['CostOfMaterialsConsumed'] =  NULL;
					if($Test[$k][6] != "NULL"){
						$Insert_PLStandard['PurchasesOfStockInTrade'] = $Test[$k][6];
					}
					$update_PLStandard['PurchasesOfStockInTrade'] =  NULL;
					if($Test[$k][7] != "NULL"){
						$Insert_PLStandard['ChangesInInventories'] = $Test[$k][7];
					}
					$update_PLStandard['ChangesInInventories'] =  NULL;
					if($Test[$k][9] != "NULL"){
						$Insert_PLStandard['CSRExpenditure'] = $Test[$k][9];
					}
					$update_PLStandard['CSRExpenditure'] =  NULL;
					if($Test[$k][10] != "NULL"){
						$Insert_PLStandard['OtherExpenses'] = $Test[$k][10];
					}
		            $update_PLStandard['OtherExpenses'] =  NULL;

					if($Test[$k][11] != "NULL"){
						$Insert_PLStandard['OptnlAdminandOthrExp'] = $Test[$k][11];
					}
		            $update_PLStandard['OptnlAdminandOthrExp'] =  NULL;
					if($Test[$k][12] != "NULL"){
						$Insert_PLStandard['OptnlProfit'] = $Test[$k][12];
					}
					$update_PLStandard['OptnlProfit'] =  NULL;
					if($Test[$k][13] != "NULL"){
						$Insert_PLStandard['EBITDA'] = $Test[$k][13];
					}
					$update_PLStandard['EBITDA'] =  NULL;
					if($Test[$k][14] != "NULL"){
						$Insert_PLStandard['Interest'] = $Test[$k][14];
					}
					$update_PLStandard['Interest'] =  NULL;
					if($Test[$k][15] != "NULL"){
						$Insert_PLStandard['EBDT'] = $Test[$k][15];
					}
					$update_PLStandard['EBDT'] =  NULL;
					if($Test[$k][16] != "NULL"){
						$Insert_PLStandard['Depreciation'] = $Test[$k][16];
					}
					$update_PLStandard['Depreciation'] =  NULL;
					if($Test[$k][17] != "NULL"){
						$Insert_PLStandard['EBT_before_Priod_period'] = $Test[$k][17];
					}
					$update_PLStandard['EBT_before_Priod_period'] =  NULL;
					if($Test[$k][18] != "NULL"){
						$Insert_PLStandard['Priod_period'] = $Test[$k][18];
					}
					$update_PLStandard['Priod_period'] =  NULL;
					if($Test[$k][19] != "NULL"){
						$Insert_PLStandard['EBT'] = $Test[$k][19];
					}
					$update_PLStandard['EBT'] =  NULL;

					if($Test[$k][20] != "NULL"){
						$Insert_PLStandard['CurrentTax'] = $Test[$k][20];
					}
					$update_PLStandard['CurrentTax'] =  NULL;
					if($Test[$k][21] != "NULL"){
						$Insert_PLStandard['DeferredTax'] = $Test[$k][21];
					}
					$update_PLStandard['DeferredTax'] =  NULL;

					if($Test[$k][22] != "NULL"){
						$Insert_PLStandard['Tax'] = $Test[$k][22];
					}
					$update_PLStandard['Tax'] =  NULL;
					if($Test[$k][23] != "NULL"){
						$Insert_PLStandard['PAT'] = $Test[$k][23];
					}
					$update_PLStandard['PAT'] =  NULL;
					
					if( $_REQUEST['ResultType'] == 0 ) {
						if($Test[$k][25] != "NULL"){
							$Insert_PLStandard['BINR'] = $Test[$k][25];
						}
						$update_PLStandard['BINR'] =  NULL;
						if($Test[$k][26] != "NULL"){
							$Insert_PLStandard['DINR'] = $Test[$k][26];
						}
		                $update_PLStandard['DINR'] =  NULL;
		                if($Test[$k][8] != "NULL"){
							$Insert_PLStandard['EmployeeRelatedExpenses'] = $Test[$k][8];
						}
						$update_PLStandard['EmployeeRelatedExpenses'] =  NULL;
						if($Test[$k][28] != "NULL"){
							$Insert_PLStandard['ForeignExchangeEarningandOutgo'] = $Test[$k][28];
						}
						$update_PLStandard['ForeignExchangeEarningandOutgo'] =  NULL;
						if($Test[$k][29] != "NULL"){
							$Insert_PLStandard['EarninginForeignExchange'] = $Test[$k][29];
						}
						$update_PLStandard['EarninginForeignExchange'] =  NULL;
						if($Test[$k][30] != "NULL") {
							$Insert_PLStandard['OutgoinForeignExchange'] = $Test[$k][30];
						}
		                $update_PLStandard['OutgoinForeignExchange'] =  NULL;
					} else if($_REQUEST['ResultType'] == 1){
						if($Test[$k][24] != "NULL"){
							$Insert_PLStandard['profit_loss_of_minority_interest'] = strip_tags( $Test[$k][24] );
						}
						$update_PLStandard['profit_loss_of_minority_interest'] =  NULL;
						if($Test[$k][25] != "NULL"){
							$Insert_PLStandard['total_profit_loss_for_period'] = strip_tags( $Test[$k][25] );
						}
						$update_PLStandard['total_profit_loss_for_period'] =  NULL;
						if($Test[$k][27] != "NULL"){
							$Insert_PLStandard['BINR'] = $Test[$k][27];
						}
						$update_PLStandard['BINR'] =  NULL;
						if($Test[$k][28] != "NULL"){
							$Insert_PLStandard['DINR'] = $Test[$k][28];
						}
		                $update_PLStandard['DINR'] =  NULL;
		                if($Test[$k][8] != "NULL"){
							$Insert_PLStandard['EmployeeRelatedExpenses'] = $Test[$k][8];
						}
						$update_PLStandard['EmployeeRelatedExpenses'] =  NULL;
						if($Test[$k][30] != "NULL"){
							$Insert_PLStandard['ForeignExchangeEarningandOutgo'] = $Test[$k][30];
						}
						$update_PLStandard['ForeignExchangeEarningandOutgo'] =  NULL;
						if($Test[$k][31] != "NULL"){
							$Insert_PLStandard['EarninginForeignExchange'] = $Test[$k][31];
						}
						$update_PLStandard['EarninginForeignExchange'] =  NULL;
						if($Test[$k][32] != "NULL") {
							$Insert_PLStandard['OutgoinForeignExchange'] = $Test[$k][32];
						}
		                $update_PLStandard['OutgoinForeignExchange'] =  NULL;
                    	
                    }
                    if($_REQUEST['Restate'] == 1){
						$Companies = $cprofile->updateRestart( $companyID , true );
						$Companieslog = $xbrl->updateRestart( $companyID,$runID, true );
					} else {
						$Companies = $cprofile->updateRestart( $companyID , false );
						$Companieslog = $xbrl->updateRestart( $companyID,$runID, false );
					}
                }
                else{
                	//echo "format mismatch <br/>";
                	$template->assign('updated',"Format mismatch");
                	break;
                }
                                        $Insert_PLStandard['FY']                     = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
					//$Insert_PLStandard['FY']                     = trim(ereg_replace("[^0-9mM()]", " ", $Test[$k][1]));
					//pr($Insert_PLStandard);
                                        //print_r($Insert_PLStandard); echo '<br><br>';
                                        if($PLSEXitsChk[$k]['PLStandard_Id'] != " " && $PLSEXitsChk[$k]['PLStandard_Id'] != ""){
                                            $plstandard->update($update_PLStandard);
                                        }
					$plstandard->update($Insert_PLStandard);
                                        //print_r($update_PLStandard);
                                        //print_r($Insert_PLStandard);
					unset($update_PLStandard);
					unset($Insert_PLStandard);
					
		}//If Ends				
	}//For Ends
	//pr($Test);
	

/*Growth Based % Values Insertion Starts*/
require_once MODULES_DIR."growthpercentage.php";
$growthpercentage = new growthpercentage();

$GBFields = array("GrowthPerc_Id","FY");
$GBwhere = " CId_FK = ".$_REQUEST['answer']['CompanyId'];
$GBSearchSEXitsChk = $growthpercentage->getFullList(1,10,$GBFields,$GBwhere,"GrowthPerc_Id ASC","name");
//pr($GBSearchSEXitsChk);
$l=0;	
for ($l = 0; $l <= $YearCount-3; $l++) {			

				$Insert_GrowthPercent = array();
				if($GBSearchSEXitsChk[$l]['GrowthPerc_Id'] != " " && $GBSearchSEXitsChk[$l]['GrowthPerc_Id'] != ''){
					$Insert_GrowthPercent['GrowthPerc_Id']          = $GBSearchSEXitsChk[$l]['GrowthPerc_Id'];
				}//If Ends
					$Insert_GrowthPercent['CId_FK']                 = $_REQUEST['answer']['CompanyId'];
					$Insert_GrowthPercent['ResultType']             = $_REQUEST['ResultType'];
					
					$Insert_GrowthPercent['IndustryId_FK']          = $IndustryId;
					//pr($Test[$l][2]);
					if(($Test[$l][2] != "NULL") && ($Test[$l+1][2] != "NULL")){
						$Insert_GrowthPercent['OptnlIncome']            = ($Test[$l][2] - $Test[$l+1][2]) / ($Test[$l+1][2] )*100;
					}
			///							$Insert_GrowthPercent['OptnlIncome']            = if(isstring(($Test[$l][2]),NULL,$Test[$l][2]) - //if(isstring(($Test[$l+1][2]),NULL,$Test[$l+1][2]) / ($Test[$l+1][2] )*100;
					if(($Test[$l][3] != "NULL") && ($Test[$l+1][3] != "NULL")){
						$Insert_GrowthPercent['OtherIncome']            = ($Test[$l][3] - $Test[$l+1][3]) / (abs($Test[$l+1][3]))*100;
					}
					if(($Test[$l][4] != "NULL") && ($Test[$l+1][4] != "NULL")){
						$Insert_GrowthPercent['TotalIncome']            = ($Test[$l][4] - $Test[$l+1][4]) / (abs($Test[$l+1][4]))*100;
					}
					if(($Test[$l][11] != "NULL") && ($Test[$l+1][11] != "NULL")){
						$Insert_GrowthPercent['OptnlAdminandOthrExp']            = ($Test[$l][11] - $Test[$l+1][11]) / (abs($Test[$l+1][11]))*100;
					}
					if(($Test[$l][12] != "NULL") && ($Test[$l+1][12] != "NULL")){
						$Insert_GrowthPercent['OptnlProfit']            = ($Test[$l][12] - $Test[$l+1][12]) / (abs($Test[$l+1][12]))*100;
					}
					if(($Test[$l][13] != "NULL") && ($Test[$l+1][13] != "NULL")){
						$Insert_GrowthPercent['EBITDA']                 = ($Test[$l][13] - $Test[$l+1][13]) / (abs($Test[$l+1][13]))*100;
					}
					if(($Test[$l][14] != "NULL") && ($Test[$l+1][14] != "NULL")){
						$Insert_GrowthPercent['Interest']               = ($Test[$l][14] - $Test[$l+1][14]) / (abs($Test[$l+1][14]))*100;
					}
					if(($Test[$l][15] != "NULL") && ($Test[$l+1][15] != "NULL")){
						$Insert_GrowthPercent['EBDT']                   = ($Test[$l][15] - $Test[$l+1][15]) / (abs($Test[$l+1][15]))*100;
					}
					if(($Test[$l][16] != "NULL") && ($Test[$l+1][16] != "NULL")){
						$Insert_GrowthPercent['Depreciation']           = ($Test[$l][16] - $Test[$l+1][16]) / (abs($Test[$l+1][16]))*100;
					}
					if(($Test[$l][19] != "NULL") && ($Test[$l+1][19] != "NULL")){
						$Insert_GrowthPercent['EBT']                    = ($Test[$l][19] - $Test[$l+1][19]) / (abs($Test[$l+1][19]))*100;
					}
					if(($Test[$l][22] != "NULL") && ($Test[$l+1][22] != "NULL")){
						$Insert_GrowthPercent['Tax']                  = ($Test[$l][22] - $Test[$l+1][22]) / (abs($Test[$l+1][22]))*100;
					}
					/*if(($Test[$l][13] != "NULL") && ($Test[$l+1][13] != "NULL")){
						$Insert_GrowthPercent['PAT']            = ($Test[$l][13] - $Test[$l+1][13]) / (abs($Test[$l+1][13]))*100;
					}*/
					if(($Test[$l][23] != "NULL") && ($Test[$l+1][23] != "NULL")){
						$Insert_GrowthPercent['PAT']            = ($Test[$l][23] - $Test[$l+1][23]) / (abs($Test[$l+1][23]))*100;
					}
					if( $_REQUEST['ResultType'] == 0 ) {
						if(($Test[$l][25] != "NULL") && ($Test[$l+1][25] != "NULL")){
							$Insert_GrowthPercent['BINR']            = ($Test[$l][25] - $Test[$l+1][25]) / (abs($Test[$l+1][25]))*100;
						}
						if(($Test[$l][26] != "NULL") && ($Test[$l+1][26] != "NULL")){
							$Insert_GrowthPercent['DINR']            = ($Test[$l][26] - $Test[$l+1][26]) / (abs($Test[$l+1][26]))*100;
						}
					}else if($_REQUEST['ResultType'] == 1){
						if(($Test[$l][27] != "NULL") && ($Test[$l+1][27] != "NULL")){
							$Insert_GrowthPercent['BINR']            = ($Test[$l][27] - $Test[$l+1][27]) / (abs($Test[$l+1][27]))*100;
						}
						if(($Test[$l][28] != "NULL") && ($Test[$l+1][28] != "NULL")){
							$Insert_GrowthPercent['DINR']            = ($Test[$l][28] - $Test[$l+1][28]) / (abs($Test[$l+1][28]))*100;
						}
					}
					
					$Insert_GrowthPercent['FY']            = trim(ereg_replace("[^0-9]", " ", $Test[$l][1]));
					$Insert_GrowthPercent['GrowthYear']               = $l+1;
					$Insert_GrowthPercent['Added_Date']             = date("Y-m-d:H:i:s");
					$Insert_GrowthPercent['Updated_date']             = date("Y-m-d:H:i:s");
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

				$Insert_CAGR = array();		
				if($CAGRSearchSEXitsChk[$l]['CAGR_Id'] != " " && $CAGRSearchSEXitsChk[$l]['CAGR_Id'] != ''){
					$Insert_CAGR['CAGR_Id']          = $CAGRSearchSEXitsChk[$l]['CAGR_Id'];
				}//If Ends
					$Insert_CAGR['CId_FK']                 = $_REQUEST['answer']['CompanyId'];
					$Insert_CAGR['ResultType']             = $_REQUEST['ResultType'];
					$Insert_CAGR['IndustryId_FK']          = $IndustryId;
/*					print "Hrer";
					print $Test[$l][2]."<br>";
					print $Test[$l+1][2]."<br>";//exit;
					*/	
									
					if(($Test[0][2] != "NULL") && ($Test[$l+1][2] != "NULL") && ($Test[0][2] > 0) && ($Test[$l+1][2] > 0)){
						$Insert_CAGR['OptnlIncome']            = (pow(($Test[0][2]/$Test[$l+1][2]),(1/($l+1)))-1) * 100;//echo pow(($Test[$l][2]/$Test[$l+1][2]),(1/2))-1;
					}
					if(($Test[0][3] != "NULL") && ($Test[$l+1][3] != "NULL") && ($Test[0][3] > 0) && ($Test[$l+1][3] > 0)){
						$Insert_CAGR['OtherIncome']            = (pow(($Test[0][3]/$Test[$l+1][3]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][4] != "NULL") && ($Test[$l+1][4] != "NULL") && ($Test[0][4] > 0) && ($Test[$l+1][4] > 0)){
						$Insert_CAGR['TotalIncome']            = (pow(($Test[0][4]/$Test[$l+1][4]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][11] != "NULL") && ($Test[$l+1][11] != "NULL") && ($Test[0][11] > 0) && ($Test[$l+1][11] > 0)){
						$Insert_CAGR['OptnlAdminandOthrExp']   = (pow(($Test[0][11]/$Test[$l+1][11]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][12] != "NULL") && ($Test[$l+1][12] != "NULL") && ($Test[0][12] > 0) && ($Test[$l+1][12] > 0)){
						$Insert_CAGR['OptnlProfit']            = (pow(($Test[0][12]/$Test[$l+1][12]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][13] != "NULL") && ($Test[$l+1][13] != "NULL") && ($Test[0][13] > 0) && ($Test[$l+1][13] > 0)){
						$Insert_CAGR['EBITDA']                 = (pow(($Test[0][13]/$Test[$l+1][13]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][14] != "NULL") && ($Test[$l+1][14] != "NULL") && ($Test[0][14] > 0) && ($Test[$l+1][14] > 0)){
						$Insert_CAGR['Interest']               = (pow(($Test[0][14]/$Test[$l+1][14]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][15] != "NULL") && ($Test[$l+1][15] != "NULL")&& ($Test[0][15] > 0) && ($Test[$l+1][15] > 0)){
						$Insert_CAGR['EBDT']                   = (pow(($Test[0][15]/$Test[$l+1][15]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][16] != "NULL") && ($Test[$l+1][16] != "NULL") && ($Test[0][16] > 0) && ($Test[$l+1][16] > 0)){
						$Insert_CAGR['Depreciation']           = (pow(($Test[0][16]/$Test[$l+1][16]),(1/($l+1)))-1) * 1000;
					}
					if(($Test[0][19] != "NULL") && ($Test[$l+1][19] != "NULL") && ($Test[0][19] > 0) && ($Test[$l+1][19] > 0)){
						$Insert_CAGR['EBT']                    = (pow(($Test[0][19]/$Test[$l+1][19]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][22] != "NULL") && ($Test[$l+1][22] != "NULL") && ($Test[0][22] > 0) && ($Test[$l+1][22] > 0)){
						$Insert_CAGR['Tax']                    = (pow(($Test[0][22]/$Test[$l+1][22]),(1/($l+1)))-1) * 100;
					}
					/*if(($Test[0][13] != "NULL") && ($Test[$l+1][13] != "NULL") && ($Test[0][13] > 0) && ($Test[$l+1][13] > 0)){
						$Insert_CAGR['PAT']            		   = (pow(($Test[0][13]/$Test[$l+1][13]),(1/($l+1)))-1) * 100;
					}*/
					if(($Test[0][23] != "NULL") && ($Test[$l+1][23] != "NULL") && ($Test[0][23] > 0) && ($Test[$l+1][23] > 0)){
						$Insert_CAGR['PAT']            		   = (pow(($Test[0][23]/$Test[$l+1][23]),(1/($l+1)))-1) * 100;
					}
					if( $_REQUEST['ResultType'] == 0 ) {
						if(($Test[0][25] != "NULL") && ($Test[$l+1][25] != "NULL") && ($Test[0][25] > 0) && ($Test[$l+1][25] > 0)){
							$Insert_CAGR['BINR']                   = (pow(($Test[0][25]/$Test[$l+1][25]),(1/($l+1)))-1) * 100;
						}	
						if(($Test[0][26] != "NULL") && ($Test[$l+1][26] != "NULL") && ($Test[0][26] > 0) && ($Test[$l+1][26] > 0)){
							$Insert_CAGR['DINR']                   = (pow(($Test[0][26]/$Test[$l+1][26]),(1/($l+1)))-1) * 100;
						}
					}else if($_REQUEST['ResultType'] == 1){
						if(($Test[0][27] != "NULL") && ($Test[$l+1][27] != "NULL") && ($Test[0][27] > 0) && ($Test[$l+1][27] > 0)){
							$Insert_CAGR['BINR']                   = (pow(($Test[0][27]/$Test[$l+1][27]),(1/($l+1)))-1) * 100;
						}	
						if(($Test[0][28] != "NULL") && ($Test[$l+1][28] != "NULL") && ($Test[0][28] > 0) && ($Test[$l+1][28] > 0)){
							$Insert_CAGR['DINR']                   = (pow(($Test[0][28]/$Test[$l+1][28]),(1/($l+1)))-1) * 100;
						}
					}	
					$Insert_CAGR['FY']                     = trim(ereg_replace("[^0-9]", " ", $Test[$l][1]));
					$Insert_CAGR['CAGRYear']               = $l+1;

					$Insert_CAGR['Added_Date']             = date("Y-m-d:H:i:s");
					$Insert_CAGR['Updated_date']             = date("Y-m-d:H:i:s");
				
					$cagr->update($Insert_CAGR);
				//pr($Insert_CAGR);
}
/*CAGR Insertion Ends*/	
	
}//If Ends	
/*Excel Upload Ends*/


/*Upload P & L Detailed Starts*/
	if($_FILES["answer"]["name"]["PLDetailed"] != NULL){
		if($_FILES['answer']['name']["PLDetailed"] != ""){
			//$ExcelCheck = ExcelValid($_FILES['answer']['name']["BalSheet"],$_FILES['answer']['tmp_name']["BalSheet"]);
			//if($ExcelCheck == "1"){
				$PLDetailed  = "pldetailed";
				$Dir = FOLDER_CREATE_PATH.$PLDetailed;
				if(!is_dir($Dir)){
					mkdir($Dir,0777);chmod($Dir, 0777);
				}
				$UploadedSourceFile = $_FILES['answer']['tmp_name']["PLDetailed"];
				$imageFileName = "PLDetailed_".$_REQUEST['answer']['AddPLDetailCompanyId'].".xls";
				$Target_Path = $Dir.'/';
				$strOriginalPath = $Target_Path.$imageFileName;
				include('uploadCommon.php');
			//}else{
			//	$Error .= "Image Not Valid";
			//}	
		 }
	}	
/*Upload P & L Detailed Ends*/

        
        
if($_REQUEST['BalSheet_template']==1){ 
     
/*Upload Balance Sheet Starts*/
	if($_FILES["answer"]["name"]["BalSheet"] != NULL){
		if($_FILES['answer']['name']["BalSheet"] != ""){
			//$ExcelCheck = ExcelValid($_FILES['answer']['name']["BalSheet"],$_FILES['answer']['tmp_name']["BalSheet"]);
			//if($ExcelCheck == "1"){
				$BalSheet  = "balancesheet";
				$Dir = FOLDER_CREATE_PATH.$BalSheet;
				if(!is_dir($Dir)){
					mkdir($Dir,0777);chmod($Dir, 0777);
				}
				$UploadedSourceFile = $_FILES['answer']['tmp_name']["BalSheet"];
				if($_REQUEST['balanceResultType']==0){
					$imageFileName = "BalSheet_".$_REQUEST['answer']['BSCompanyId'].".xls";
				}else{
					$imageFileName = "BalSheet_".$_REQUEST['answer']['BSCompanyId']."_1.xls";
				}
				$Target_Path = $Dir.'/';
				$strOriginalPath = $Target_Path.$imageFileName;
				include('uploadCommon.php');
			//}else{
			//	$Error .= "Image Not Valid";
			//}	
		 }
	}	
/*Upload Balance Sheet Ends*/

/*Balance Excel Upload Starts*/
if($_REQUEST['answer']['BSCompanyId'] != ""){
	//$UploadedFile = "BalSheet_".$_REQUEST['answer']['BSCompanyId'].".xls";//exit;
	//$UploadedFilePath = "../media/balancesheet/".$UploadedFile;
        $UploadedFilePath = FOLDER_CREATE_PATH."balancesheet/".$imageFileName;

    if( $_REQUEST['balanceResultType']==0 ) {
    	$excel_type = 'S';
    } else {
    	$excel_type = 'C';
    }    
    $where11 = "Company_Id = '".$_REQUEST['answer']['BSCompanyId']."'";
	$Companies11 = $cprofile->getCompaniesCIN( $where11 );
	$companyIDArray = array_keys ( $Companies11 );
	$companyID = $companyIDArray[0];
    $Insert_RegUser['log_file'] = '';
	$Insert_RegUser['cin'] = $companyID;
	$Insert_RegUser['is_error'] = 0;
	$Insert_RegUser['run_id'] = $runID;
	$Insert_RegUser['xml_type'] = '';
	$Insert_RegUser['excel_type'] = $excel_type;
	$Insert_RegUser['view_index'] = 0;
	$Insert_RegUser['created_on'] = $created_on;
	$Insert_RegUser[ 'user_id' ] = $_SESSION[ 'business' ][ 'Ident' ];
	$Insert_RegUser[ 'user_name' ] = $_SESSION[ 'business' ][ 'loggedUserName' ];
	$Insert_RegUser[ 'run_type' ] = 2;
	$Insert_RegUser[ 'run_file' ] = 'BSO';
	$xbrl->update( $Insert_RegUser );

	require_once 'Excel/reader.php';
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($UploadedFilePath);
	

//pr($data->sheets);//exit;
	$YearCount = count($data->sheets[0]['cells'][6]);
	$i=0;
	for ($m = 0; $m <= $YearCount -2; $m++) {
			$x=6;
			$i=0;
			for ($x; $x <= count($data->sheets[0]["cells"])+3; $x++) {
				$i++;
				$Test[$m][$i] =  ($data->sheets[0]["cells"][$x][$m+2]=='-')?'NULL':$data->sheets[0]["cells"][$x][$m+2]."<br>";
				//pr($Test[$m][$i]);
			}
	}

$cprofile->select($_REQUEST['answer']['BSCompanyId']);	
$IndustryId = $cprofile->elements["Industry"];
$Insert_YearCount['Company_Id'] = $_REQUEST['answer']['BSCompanyId'];
//pr($Insert_YearCount['FYCount']);

//Delete previous entries
if ($YearCount > 0){
    $balancesheet->deleteBalancesheet($_REQUEST['answer']['BSCompanyId'],$_REQUEST['balanceResultType']);
}


$BalanceFields = array("a.BalanceSheet_Id","a.FY");
$Balancewhere = " a.CId_FK = ".$_REQUEST['answer']['BSCompanyId']." && a.ResultType = ".$_REQUEST['balanceResultType'];
$BalanceEXitsChk = $balancesheet->getFullList(1,10,$BalanceFields,$Balancewhere,"BalanceSheet_Id ASC","name");

//pr($BalanceEXitsChk);

if($BalanceEXitsChk[0]['BalanceSheet_Id'] != ""){
	$template->assign('AskConfirm',"AskConfirm");
	$template->assign('BSCompanyId',$_REQUEST['answer']['BSCompanyId']);
}
$k=0;

	for ($k = 0; $k <= $YearCount-2; $k++) {
                
		if($Test[$k][1] != "<br>" && $Test[$k][1] != ''){	
				$Insert_BalanceSheet = array();
				if($BalanceEXitsChk[$k]['BalanceSheet_Id'] != " " && $BalanceEXitsChk[$k]['BalanceSheet_Id'] !=''){
					$Insert_BalanceSheet['BalanceSheet_Id']          = $BalanceEXitsChk[$k]['BalanceSheet_Id'];
					
				}//If Ends
					$Insert_BalanceSheet['CId_FK']                 = $_REQUEST['answer']['BSCompanyId'];
					$Insert_BalanceSheet['ResultType']             = $_REQUEST['balanceResultType'];
					
					//pr($Insert_BalanceSheet['ResultType']);
					
					   $Insert_BalanceSheet['IndustryId_FK']          = $IndustryId;
					
					if($Test[$k][4] != "NULL"){					
						$Insert_BalanceSheet['ShareCapital']            = $Test[$k][4];
					}
					if($Test[$k][5] != "NULL"){
						$Insert_BalanceSheet['ShareApplication']    		 = $Test[$k][5];
					}
					if($Test[$k][6] != "NULL"){
						$Insert_BalanceSheet['ReservesSurplus']    		 = $Test[$k][6];
					}	
					if($Test[$k][7] != "NULL"){
						$Insert_BalanceSheet['TotalFunds']   = $Test[$k][7];
					}
					if($Test[$k][9] != "NULL"){
						$Insert_BalanceSheet['SecuredLoans']            = $Test[$k][9];
					}
					if($Test[$k][10] != "NULL"){
						$Insert_BalanceSheet['UnSecuredLoans']            = $Test[$k][10];
					}
					if($Test[$k][11] != "NULL"){
						$Insert_BalanceSheet['LoanFunds']                 = $Test[$k][11];
					}
					if($Test[$k][12] != "NULL"){
						$Insert_BalanceSheet['OtherLiabilities']               = $Test[$k][12];
					}
					if($Test[$k][13] != "NULL"){
						$Insert_BalanceSheet['DeferredTax']                   = $Test[$k][13];
					}
					if($Test[$k][14] != "NULL"){
						$Insert_BalanceSheet['SourcesOfFunds']           = $Test[$k][14];
					}
					if($Test[$k][18] != "NULL"){
						$Insert_BalanceSheet['GrossBlock']                    = $Test[$k][18];
					}
					if($Test[$k][19] != "NULL"){
						$Insert_BalanceSheet['LessAccumulated']                    = $Test[$k][19];
					}
					if($Test[$k][20] != "NULL"){
						$Insert_BalanceSheet['NetBlock']                    = $Test[$k][20];
					}
					if($Test[$k][21] != "NULL"){
						$Insert_BalanceSheet['CapitalWork']                    = $Test[$k][21];
					}
					if($Test[$k][22] != "NULL"){
						$Insert_BalanceSheet['FixedAssets']                   = $Test[$k][22];
					}
					if($Test[$k][23] != "NULL"){
						$Insert_BalanceSheet['IntangibleAssets']                   = $Test[$k][23];
					}
					if($Test[$k][24] != "NULL"){
						$Insert_BalanceSheet['OtherNonCurrent']                   = $Test[$k][24];
					}
					if($Test[$k][25] != "NULL"){
						$Insert_BalanceSheet['Investments']            = $Test[$k][25];
					}
					if($Test[$k][26] != "NULL"){
						$Insert_BalanceSheet['DeferredTaxAssets']                 = $Test[$k][26];
					}
					if($Test[$k][28] != "NULL"){
						$Insert_BalanceSheet['SundryDebtors']               = $Test[$k][28];
					}
					if($Test[$k][29] != "NULL"){
						$Insert_BalanceSheet['CashBankBalances']                   = $Test[$k][29];
					}
					if($Test[$k][30] != "NULL"){
						$Insert_BalanceSheet['Inventories']           = $Test[$k][30];
					}
					if($Test[$k][31] != "NULL"){
						$Insert_BalanceSheet['LoansAdvances']                    = $Test[$k][31];
					}
					if($Test[$k][32] != "NULL"){
						$Insert_BalanceSheet['OtherCurrentAssets']                    = $Test[$k][32];
					}
					if($Test[$k][33] != "NULL"){
						$Insert_BalanceSheet['CurrentAssets']                    = $Test[$k][33];
					}
					if($Test[$k][35] != "NULL"){
						$Insert_BalanceSheet['CurrentLiabilities']                    = $Test[$k][35];
					}
					if($Test[$k][36] != "NULL"){
						$Insert_BalanceSheet['Provisions']                   = $Test[$k][36];
					}
					if($Test[$k][37] != "NULL"){
						$Insert_BalanceSheet['CurrentLiabilitiesProvision']                   = $Test[$k][37];
					}
					if($Test[$k][38] != "NULL"){
						$Insert_BalanceSheet['NetCurrentAssets']                   = $Test[$k][38];
					}
					if($Test[$k][39] != "NULL"){
						$Insert_BalanceSheet['ProfitLoss']                   = $Test[$k][39];
					}
					if($Test[$k][40] != "NULL"){
						$Insert_BalanceSheet['Miscellaneous']                   = $Test[$k][40];
					}
					if($Test[$k][41] != "NULL"){
						$Insert_BalanceSheet['TotalAssets']                   = $Test[$k][41];
					}
					
					//$Insert_BalanceSheet['FY']                     = trim(ereg_replace("[^0-9mM()]", " ", $Test[$k][1]));
					$Insert_BalanceSheet['FY']                     = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
					//pr($Insert_BalanceSheet);
					$Insert_BalanceSheet['Added_Date']             = date("Y-m-d:H:i:s");
					$balancesheet->update($Insert_BalanceSheet);
					unset($Insert_BalanceSheet);
					
		}//If Ends				
	}//For Ends
	//pr($Test);

}//If Ends	
/*Balance Excel Upload Ends*/


}

else if($_REQUEST['BalSheet_template']==2){     


/*Upload New Balance Sheet Starts*/
	if($_FILES["answer"]["name"]["New_BalSheet"] != NULL){
		if($_FILES['answer']['name']["New_BalSheet"] != ""){
			//$ExcelCheck = ExcelValid($_FILES['answer']['name']["BalSheet"],$_FILES['answer']['tmp_name']["BalSheet"]);
			//if($ExcelCheck == "1"){
				$BalSheet_new  = "balancesheet_new";
				$Dir = FOLDER_CREATE_PATH.$BalSheet_new;
				if(!is_dir($Dir)){
					mkdir($Dir,0777);chmod($Dir, 0777);
				}
				$UploadedSourceFile = $_FILES['answer']['tmp_name']["New_BalSheet"];
				if($_REQUEST['balanceResultType']==0){
					$imageFileName = "New_BalSheet_".$_REQUEST['answer']['New_BSCompanyId'].".xls";
				}else{
					$imageFileName = "New_BalSheet_".$_REQUEST['answer']['New_BSCompanyId']."_1.xls";
				}
				$Target_Path = $Dir.'/';
				$strOriginalPath = $Target_Path.$imageFileName;
				include('uploadCommon.php');
			//}else{
			//	$Error .= "Image Not Valid";
			//}	
                                
		 }
	}
/*Upload New Balance Sheet Ends*/
        
        /*Balance Excel Upload Starts*/
if($_REQUEST['answer']['New_BSCompanyId'] != ""){
    
	//$UploadedFile = "New_BalSheet_".$_REQUEST['answer']['New_BSCompanyId'].".xls";//exit;
	//$UploadedFilePath = "../media/balancesheet/".$UploadedFile;
        $UploadedFilePath = FOLDER_CREATE_PATH."balancesheet_new/".$imageFileName;
    
    if( $_REQUEST['balanceResultType']==0 ) {
    	$excel_type = 'S';
    } else {
    	$excel_type = 'C';
    }    
    $where11 = "Company_Id = '".$_REQUEST['answer']['New_BSCompanyId']."'";
	$Companies11 = $cprofile->getCompaniesCIN( $where11 );
	$companyIDArray = array_keys ( $Companies11 );
	$companyID = $companyIDArray[0];
    $Insert_RegUser['log_file'] = '';
	$Insert_RegUser['cin'] = $companyID;
	$Insert_RegUser['is_error'] = 0;
	$Insert_RegUser['run_id'] = $runID;
	$Insert_RegUser['xml_type'] = '';
	$Insert_RegUser['excel_type'] = $excel_type;
	$Insert_RegUser['view_index'] = 0;
	$Insert_RegUser['created_on'] = $created_on;
	$Insert_RegUser[ 'user_id' ] = $_SESSION[ 'business' ][ 'Ident' ];
	$Insert_RegUser[ 'user_name' ] = $_SESSION[ 'business' ][ 'loggedUserName' ];
	$Insert_RegUser[ 'run_type' ] = 2;
	$Insert_RegUser[ 'run_file' ] = 'BSN';
	$xbrl->update( $Insert_RegUser );

	require_once 'Excel/reader.php';
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	$data->read($UploadedFilePath);
	

//pr($data->sheets);//exit;
	$YearCount = count($data->sheets[0]['cells'][6]);
	$i=0;
	for ($m = 0; $m <= $YearCount -2; $m++) {
			$x=6;
			$i=0;
			for ($x; $x <= count($data->sheets[0]["cells"])+8; $x++) {
				$i++;
				$Test[$m][$i] =  ($data->sheets[0]["cells"][$x][$m+2]=='-')?'NULL':$data->sheets[0]["cells"][$x][$m+2]."<br>";
				//pr($Test[$m][$i]);
			}
                       
	}
	$bsrowname =  $data->sheets[0]["cells"][7][1];
    $bsrowname1 =  $data->sheets[0]["cells"][8][1];

$cprofile->select($_REQUEST['answer']['New_BSCompanyId']);	
$IndustryId = $cprofile->elements["Industry"];
$Insert_YearCount['Company_Id'] = $_REQUEST['answer']['New_BSCompanyId'];
//pr($Insert_YearCount['FYCount']);

//Delete previous entries
if ($YearCount > 0){
    $balancesheet_new->deleteBalancesheet($_REQUEST['answer']['New_BSCompanyId'],$_REQUEST['balanceResultType']);
}

$BalanceFields1 = array("a.BalanceSheet_Id","a.FY");
$Balancewhere1 = " a.CId_FK = ".$_REQUEST['answer']['New_BSCompanyId']." && a.ResultType = ".$_REQUEST['balanceResultType'];
$BalanceEXitsChk1 = $balancesheet_new->getFullList(1,10,$BalanceFields1,$Balancewhere1,"FY DESC","name");

$k=0;

	for ($k = 0; $k <= $YearCount-2; $k++) {
                
		if($Test[$k][1] != "<br>" && $Test[$k][1] != ''){	
				$Insert_BalanceSheet = array();
				if($bsrowname=="Share capital" && $bsrowname1=="Reserves and surplus"){
					if($BalanceEXitsChk1[$k]['BalanceSheet_Id'] != " "){
						$Insert_BalanceSheet['BalanceSheet_Id']          = $BalanceEXitsChk1[$k]['BalanceSheet_Id'];
						$Insert_BalanceSheet['updated_date']             = date("Y-m-d H:i:s");					
					}  else {                                    
					$Insert_BalanceSheet['Added_Date']             = date("Y-m-d H:i:s");
                                }//If Ends
					$Insert_BalanceSheet['CId_FK']                 = $_REQUEST['answer']['New_BSCompanyId'];
					$Insert_BalanceSheet['ResultType']             = $_REQUEST['balanceResultType'];
					//$Insert_BalanceSheet['ResultType']             = '';
					
					//pr($Insert_BalanceSheet['ResultType']);
					
					   $Insert_BalanceSheet['IndustryId_FK']                = $IndustryId;
					
					
					if($Test[$k][2] != "NULL"){					
						$Insert_BalanceSheet['ShareCapital']            =str_replace(",","",$Test[$k][2]); 
					}
					if($Test[$k][3] != "NULL"){
						$Insert_BalanceSheet['ReservesSurplus']         = str_replace(",","",$Test[$k][3]); 
					}
					if($Test[$k][4] != "NULL"){
						$Insert_BalanceSheet['TotalFunds']              = str_replace(",","",$Test[$k][4]); 
					}	
					if($Test[$k][5] != "NULL"){
						$Insert_BalanceSheet['ShareApplication']        = str_replace(",","",$Test[$k][5]);
					}
					//Lines added for minority_interest field to db
                     if($_REQUEST['balanceResultType']==1){
						if($Test[$k][6] != "NULL"){
						$Insert_BalanceSheet['minority_interest']        = str_replace(",","",$Test[$k][6]);
						}
					}                
                                        
                                        
					if($Test[$k][7] != "NULL"){
						$Insert_BalanceSheet['N_current_liabilities']       = str_replace(",","",$Test[$k][7]);
					}
					if($Test[$k][8] != "NULL"){
						$Insert_BalanceSheet['L_term_borrowings']           = str_replace(",","",$Test[$k][8]);
					}                                        
                                        if($Test[$k][9] != "NULL"){
						$Insert_BalanceSheet['deferred_tax_liabilities']    = str_replace(",","",$Test[$k][9]);
					}
					if($Test[$k][10] != "NULL"){
						$Insert_BalanceSheet['O_long_term_liabilities']     = str_replace(",","",$Test[$k][10]);
					} 
					if($Test[$k][11] != "NULL"){
						$Insert_BalanceSheet['L_term_provisions']       = str_replace(",","",$Test[$k][11]);
					}
					if($Test[$k][12] != "NULL"){
						$Insert_BalanceSheet['T_non_current_liabilities']   = str_replace(",","",$Test[$k][12]);
					}
                                        
                                        
                                        
					if($Test[$k][14] != "NULL"){
						$Insert_BalanceSheet['Current_liabilities']     = str_replace(",","",$Test[$k][14]);
					}
					if($Test[$k][15] != "NULL"){
						$Insert_BalanceSheet['S_term_borrowings']       = str_replace(",","",$Test[$k][15]);
					}
					if($Test[$k][16] != "NULL"){
						$Insert_BalanceSheet['Trade_payables']          = str_replace(",","",$Test[$k][16]);
					}
					if($Test[$k][17] != "NULL"){
						$Insert_BalanceSheet['O_current_liabilities']   = str_replace(",","",$Test[$k][17]);
					}
					if($Test[$k][18] != "NULL"){
						$Insert_BalanceSheet['S_term_provisions']       = str_replace(",","",$Test[$k][18]);
					}
					if($Test[$k][19] != "NULL"){
						$Insert_BalanceSheet['T_current_liabilities']   = str_replace(",","",$Test[$k][19]);
					}
					if($Test[$k][20] != "NULL"){
						$Insert_BalanceSheet['T_equity_liabilities']    = str_replace(",","",$Test[$k][20]);
					}
                                        
                                        
                                        
                                        
					if($Test[$k][22] != "NULL"){
						$Insert_BalanceSheet['Assets']                  = str_replace(",","",$Test[$k][22]);
					}
                                        
                                        
					if($Test[$k][24] != "NULL"){
						$Insert_BalanceSheet['N_current_assets']        = str_replace(",","",$Test[$k][24]);
					}
                                        
                                        
					if($Test[$k][26] != "NULL"){
						$Insert_BalanceSheet['Fixed_assets']            = str_replace(",","",$Test[$k][26]);
					}
					if($Test[$k][27] != "NULL"){
						$Insert_BalanceSheet['Tangible_assets']         = str_replace(",","",$Test[$k][27]);
					}
					if($Test[$k][28] != "NULL"){
						$Insert_BalanceSheet['Intangible_assets']       =str_replace(",","",$Test[$k][28]);
					}
					if($Test[$k][29] != "NULL"){
						$Insert_BalanceSheet['T_fixed_assets']          = str_replace(",","",$Test[$k][29]);
					}
					if($Test[$k][30] != "NULL"){
						$Insert_BalanceSheet['N_current_investments']   = str_replace(",","",$Test[$k][30]);
					}
					if($Test[$k][31] != "NULL"){
						$Insert_BalanceSheet['Deferred_tax_assets']     = str_replace(",","",$Test[$k][31]);
					}
					if($Test[$k][32] != "NULL"){
						$Insert_BalanceSheet['L_term_loans_advances']   =str_replace(",","",$Test[$k][32]);
					}
					if($Test[$k][33] != "NULL"){
						$Insert_BalanceSheet['O_non_current_assets']    = str_replace(",","",$Test[$k][33]);
					}
					if($Test[$k][34] != "NULL"){
						$Insert_BalanceSheet['T_non_current_assets']    = str_replace(",","",$Test[$k][34]);
					}
                                        
                                        
					if($Test[$k][36] != "NULL"){
						$Insert_BalanceSheet['Current_assets']          = str_replace(",","",$Test[$k][36]);
					}
					if($Test[$k][37] != "NULL"){
						$Insert_BalanceSheet['Current_investments']     = str_replace(",","",$Test[$k][37]);
					}
					if($Test[$k][38] != "NULL"){
						$Insert_BalanceSheet['Inventories']             = str_replace(",","",$Test[$k][38]);
					}
					if($Test[$k][39] != "NULL"){
						$Insert_BalanceSheet['Trade_receivables']       = str_replace(",","",$Test[$k][39]);
					}
					if($Test[$k][40] != "NULL"){
						$Insert_BalanceSheet['Cash_bank_balances']      = str_replace(",","",$Test[$k][40]);
					}
                                        if($Test[$k][41] != "NULL"){
						$Insert_BalanceSheet['S_term_loans_advances']   = str_replace(",","",$Test[$k][41]);
					}
                                        if($Test[$k][42] != "NULL"){
						$Insert_BalanceSheet['O_current_assets']        = str_replace(",","",$Test[$k][42]);
					}
                                        if($Test[$k][43] != "NULL"){
						$Insert_BalanceSheet['T_current_assets']        = str_replace(",","",$Test[$k][43]);
					}
                                        if($Test[$k][44] != "NULL"){
						$Insert_BalanceSheet['Total_assets']            = str_replace(",","",$Test[$k][44]);
					}
					
					//$Insert_BalanceSheet['FY']                     = trim(ereg_replace("[^0-9mM()]", " ", $Test[$k][1]));
					$Insert_BalanceSheet['FY']                     = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
					
                                        
                                       // print_r($Insert_BalanceSheet); 
                                       
					$balancesheet_new->update($Insert_BalanceSheet);
					unset($Insert_BalanceSheet);
				} else {
					$template->assign('updated',"Format mismatch");
                	break;
				}
					
					
		}//If Ends
                
                
	}//For Ends
	//pr($Test);

}//If Ends	
/*Balance Excel Upload Ends*/
        
}

/*Upload Cash Flow Starts*/
	if($_FILES["answer"]["name"]["Cashflow"] != NULL){
		if($_FILES['answer']['name']["Cashflow"] != ""){
			//$ExcelCheck = ExcelValid($_FILES['answer']['name']["BalSheet"],$_FILES['answer']['tmp_name']["BalSheet"]);
			//if($ExcelCheck == "1"){
				$Cashflow  = "cashflow";
				$Dir = FOLDER_CREATE_PATH.$Cashflow;
				if(!is_dir($Dir)){
					mkdir($Dir,0777);chmod($Dir, 0777);
				}
				$UploadedSourceFile = $_FILES['answer']['tmp_name']["Cashflow"];
				$imageFileName = "Cashflow_".$_REQUEST['answer']['CFCompanyId'].".xls";
				$Target_Path = $Dir.'/';
				$strOriginalPath = $Target_Path.$imageFileName;
				include('uploadCommon.php');
			//}else{
			//	$Error .= "Image Not Valid";
			//}	
		 }
	}	
/*Upload Cash Flow Ends*/


/*Cashflow - new*/	
if($_FILES["answer"]["name"]["Cashflownew"] != NULL){
			if($_FILES['answer']['name']["Cashflownew"] != ""){
			 	//$ExcelCheck = ExcelValid($_FILES['answer']['name']["PLStandard"],$_FILES['answer']['tmp_name']["PLStandard"]);
				//if($ExcelCheck == "1"){
					$cashflowpath  = "cashflow_xbrl2";
					$Dir = FOLDER_CREATE_PATH.$cashflowpath;
					if(!is_dir($Dir)){
						mkdir($Dir,0777);chmod($Dir, 0777);
					}
					$UploadedSourceFile = $_FILES['answer']['tmp_name']["Cashflownew"];
					if($_REQUEST['ResultType']==0){
						$imageFileName = "CASHFLOW_".$_REQUEST['answer']['CFCompanyIdnew'].".xls";
					}else{
						$imageFileName = "CASHFLOW_".$_REQUEST['answer']['CFCompanyIdnew']."_1.xls";
					}
					$Target_Path = $Dir.'/';
					$strOriginalPath = $Target_Path.$imageFileName;
				//	pr($strOriginalPath);
					// move_uploaded_file($_FILES['answer']['tmp_name']["CASHFLOW"], $strOriginalPath);
					include('uploadCommon.php');
				//}else{
				//	$Error .= "Image Not Valid";
				//}	
		 }
}	


if($_REQUEST['answer']['CFCompanyIdnew'] != ""){

    if($_REQUEST['ResultType']==0){
        $excel_type = 'S';
                $UploadedFile = "CASHFLOW_".$_REQUEST['answer']['CFCompanyIdnew'].".xls";
        }else{
            $excel_type = 'C';
                $UploadedFile = "CASHFLOW_".$_REQUEST['answer']['CFCompanyIdnew']."_1.xls";
        }
//echo $UploadedFile;
    $where11 = "Company_Id = '".$_REQUEST['answer']['CFCompanyIdnew']."'";
    $Companies11 = $cprofile->getCompaniesCIN( $where11 );
    $companyIDArray = array_keys ( $Companies11 );
    $companyID = $companyIDArray[0];
    $Insert_RegUser['log_file'] = '';
    $Insert_RegUser['cin'] = $companyID;
    $Insert_RegUser['is_error'] = 0;
    $Insert_RegUser['run_id'] = $runID;
    $Insert_RegUser['xml_type'] = '';
    $Insert_RegUser['excel_type'] = $excel_type;
    $Insert_RegUser['view_index'] = 0;
    $Insert_RegUser['created_on'] = $created_on;
    $Insert_RegUser[ 'user_id' ] = $_SESSION[ 'business' ][ 'Ident' ];
    $Insert_RegUser[ 'user_name' ] = $_SESSION[ 'business' ][ 'loggedUserName' ];
    $Insert_RegUser[ 'run_type' ] = 2;
    $Insert_RegUser[ 'run_file' ] = 'CF';
    $xbrl->update( $Insert_RegUser );

        //$UploadedFile = "PLStandard_".$_REQUEST['answer']['CompanyId'].".xls";
    //$UploadedFilePath = "../media/plstandard/".$UploadedFile;
        $UploadedFilePath = FOLDER_CREATE_PATH."cashflow_xbrl2/".$UploadedFile;
   //  echo $UploadedFilePath;  
    require_once 'Excel/reader.php';
    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('CP1251');
    $data->read($UploadedFilePath);

    

$YearCount = count($data->sheets[0]['cells'][6]);
$YearCount1 = count($data->sheets[0]['cells'][6]);
//	pr($data->sheets);//exit;
    $i=0;
    for ($m = 0; $m <= $YearCount -2; $m++ ) {
            $x=6;
            $i=0;
            for ($x; $x <= count($data->sheets[0]["cells"])+3; $x++) {
                $i++;
                $Test[$m][$i] =  ($data->sheets[0]["cells"][$x][$m+2]=='-')?'NULL':$data->sheets[0]["cells"][$x][$m+2]."<br>";
                //pr($Test[$m][$i]);
            }
    }
    $rowname =  $data->sheets[0]["cells"][8][2];
   /* $rowname1 =  $data->sheets[0]["cells"][11][1];*/
   // pr($rowname);
$cprofile->select($_REQUEST['answer']['CFCompanyIdnew']);    
$IndustryId = $cprofile->elements["Industry"];
	if($_REQUEST['ResultType'] == 0){
	$Insert_YearCount['Company_Id'] = $_REQUEST['answer']['CFCompanyIdnew'];
	$Insert_YearCount['FYCount'] = $YearCount1 - 1;
	$Insert_YearCount['GFYCount'] = $YearCount1 - 2;
	$cprofile->update($Insert_YearCount);
}
//Find privious data
$FYList = $FYList_N = array();
    $detailCheck=mysql_query("SELECT cashflow_id, FY FROM cash_flow WHERE CId_FK='".$_REQUEST['answer']['CFCompanyIdnew']."' and ResultType='".$_REQUEST['ResultType']."'");
    //echo mysql_num_rows($detailCheck);
    if(mysql_num_rows($detailCheck) > 0){

        while($detailChecks = mysql_fetch_array($detailCheck)){
            $FYList[] = trim($detailChecks['FY']);

        }
       // print_r($FYList);
       /* for ($k = 0; $k <= $YearCount-2; $k++) {
            if($Test[$k][1] != "<br>" && $Test[$k][1] != ""){
                //$FYList_N[] = trim(ereg_replace("[^0-9mM()]", " ", $Test[$k][1]));
                $FYList_N[] = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
            }
        }

        $result= $FYList_N;*/
     	$result= $FYList;
        foreach($result as $val){ 
            if($val !=''){
                mysql_query("DELETE FROM cash_flow WHERE CId_FK='".$_REQUEST['answer']['CFCompanyIdnew']."' and ResultType='".$_REQUEST['ResultType']."' and FY='".$val."'");
               
            }
        }
    }

    
//pr($Insert_YearCount['FYCount']);
// $CFFields = array("cashflow_id","FY");
// $CFwhere = " CId_FK = ".$_REQUEST['answer']['CFCompanyIdnew']." && ResultType = ".$_REQUEST['ResultType'];
// $CFEXitsChk = $cashflow->getFullList(1,10,$CFFields,$CFwhere,"cashflow_id ASC","name");
// //pr($PLSEXitsChk);//exit;

// if($CFEXitsChk[0]['cashflow_id'] != ""){
//     $template->assign('AskConfirm',"AskConfirm");
//     $template->assign('CompanyId',$_REQUEST['answer']['CFCompanyIdnew']);
    
// }

//pr($_FILES["answer"]["name"]["PLStandard"]);
	$k=0;

    for ($k = 0; $k <= $YearCount-2; $k++) {

        if($Test[$k][1] != "<br>" && $Test[$k][1] != ""){  

                $Insert_CFStandard = array();
                $update_CFStandard = array();
               		$update_CFStandard['cashflow_id'] = $Insert_CFStandard['cashflow_id'];
	                    $Insert_CFStandard['updated_date']  = date("Y-m-d:H:i:s");
	                    $Insert_CFStandard['Added_Date'] = date("Y-m-d:H:i:s");
	                // if($CFEXitsChk[$k]['cashflow_id'] != " " && $CFEXitsChk[$k]['cashflow_id'] != ""){
	                //     $update_CFStandard['cashflow_id'] = $Insert_CFStandard['cashflow_id']  = $CFEXitsChk[$k]['cashflow_id'];
	                //     $Insert_CFStandard['updated_date']  = date("Y-m-d:H:i:s");
	                // }  else {
                 //        $Insert_PLStandard['Added_Date'] = date("Y-m-d:H:i:s");
                 //    }//If Ends
                    $Insert_CFStandard['CId_FK'] = $_REQUEST['answer']['CFCompanyIdnew'];
                    $Insert_CFStandard['ResultType'] = $_REQUEST['ResultType'];

                                    //    $Insert_PLStandard['AddFinancials'] = $_REQUEST['answer']['AddFinancials'];
                    
                    $Insert_CFStandard['IndustryId_FK']          = $IndustryId;
                    if($Test[$k][3] != "NULL"){                    
                        $Insert_CFStandard['NetPLBefore']            = $Test[$k][3];
                    }
                    $update_CFStandard['NetPLBefore'] = NULL;   
                    
                    if($Test[$k][4] != "NULL"){
                        $Insert_CFStandard['CashflowFromOperation']             = $Test[$k][4];
                    }
                    $update_CFStandard['CashflowFromOperation'] =  NULL;
                    if($Test[$k][5] != "NULL"){
                        $Insert_CFStandard['NetcashUsedInvestment']             = $Test[$k][5];
                    }    
                    $update_CFStandard['NetcashUsedInvestment'] =  NULL;    
                    if($Test[$k][6] != "NULL"){
                        $Insert_CFStandard['NetcashFromFinance']   = $Test[$k][6];
                    }
                    $update_CFStandard['NetcashFromFinance'] =  NULL;
                    if($Test[$k][7] != "NULL"){
                        $Insert_CFStandard['NetIncDecCash']  = $Test[$k][7];
                    }
                    $update_CFStandard['NetIncDecCash'] =  NULL;
                    if($Test[$k][9] != "NULL"){
                        $Insert_CFStandard['EquivalentEndYear']  = $Test[$k][9];
                    }
                    $update_CFStandard['EquivalentEndYear'] =  NULL;
                   
            
                
                                        $Insert_CFStandard['FY']  = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));

                    //$Insert_PLStandard['FY']                     = trim(ereg_replace("[^0-9mM()]", " ", $Test[$k][1]));
                    //pr($Insert_PLStandard);
                                        //print_r($Insert_PLStandard); echo '<br><br>';
                                        // if($CFEXitsChk[$k]['cashflow_id'] != " " && $CFEXitsChk[$k]['cashflow_id'] != ""){
                                        //     $cashflow->update($update_CFStandard);
                                        // }
                                        
                    
                                        $cashflow->update($Insert_CFStandard);
                                        //print_r($update_PLStandard);
                                        //print_r($Insert_PLStandard);
                    unset($update_CFStandard);
                    unset($Insert_CFStandard);

                    
        }//If Ends                
    }
}




/*For Export All Excel */ 

if($_FILES["answer"]["name"]["PLStandard"] != NULL || $_FILES['answer']['name']["PLStandard"] != "" || $_FILES["answer"]["name"]["Cashflownew"] != NULL || $_FILES["answer"]["name"]["Cashflownew"] != "" || $_REQUEST['answer']['BSCompanyId'] != "" || $_REQUEST['answer']['BSCompanyId'] != NULL || $_REQUEST['answer']['New_BSCompanyId'] != "" || $_REQUEST['answer']['New_BSCompanyId'] != NULL){
	combineAllExcel($companyProfileID,$cprofile,$industries,$sectors,$city,$countries);
}
/**
* Function To Combine All the Excel of the company
*
*/
function combineAllExcel($companyProfileID,$cprofile,$industries,$sectors,$city,$countries)
{
		
	
	$filenames = array();
	$_GET['vcid'] = $companyProfileID;

	if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls')){
	    $PLSTANDARD_MEDIA_PATH_CON=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls';
	    $filenames['P&L Consolidated'] = $PLSTANDARD_MEDIA_PATH_CON;
	}
	if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls')){
	    $PLSTANDARD_MEDIA_PATH=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls';
	    $filenames['P&L Standalone'] = $PLSTANDARD_MEDIA_PATH;
	}

	if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'_1.xls')){
	    $BSHEET_MEDIA_PATH_NEW_CON=FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'_1.xls';
	    $filenames['BS Consolidated'] = $BSHEET_MEDIA_PATH_NEW_CON;
	}
	if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'.xls')){
	    $BSHEET_MEDIA_PATH_NEW=FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'.xls';
	    $filenames['BS Standalone'] = $BSHEET_MEDIA_PATH_NEW;
	}
	if(file_exists(FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'_1.xls')){
	    $CASHFLOW_MEDIA_PATH_NEW_CON=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'_1.xls';
	    $filenames['CF Consolidated'] = $CASHFLOW_MEDIA_PATH_NEW_CON;
	}
	if(file_exists(FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'.xls')){
	    $CASHFLOW_MEDIA_PATH=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'.xls';
	    $filenames['CF Standalone'] = $CASHFLOW_MEDIA_PATH;
	}

	$fields3 ='*';
	$order3 = '';
	$sep = '';
	$where3 = " Company_Id = ".$_GET['vcid'];
	//$where3 = " Company_Id = 994";

	$CompanyProfile = $cprofile->getFullList("","",$fields3,$where3,$order3,"name3");
	//print_r($CompanyProfile);exit();
	$where5 = " Industry_Id= ".$CompanyProfile['Industry'];
	$order5="";
	$compdetail = $industries->getsingleIndustries($where5,$order5);
	$industry="";
	$industry=$compdetail[0];

	$where6 = "Sector_Id= ".$CompanyProfile['Sector'];
	$order6="";
	$sectordetail = $sectors->getsingleSectors($where6,$order6);
	$sectorname="";
	$sectorname=$sectordetail[0];

	$naicsdetail = $sectors->getSectorsNaicsCode($where6,$order6);
	$naicsCode=$naicsdetail[0];

	if($CompanyProfile['ListingStatus']==1)
	{
	    $ListingStatus = 'Listed';
	}
	elseif($CompanyProfile['ListingStatus']==2)
	{
	    $ListingStatus = 'UnListed';
	}
	elseif($CompanyProfile['ListingStatus']==3)
	{
	    $ListingStatus = 'Partnership';
	}
	elseif($CompanyProfile['ListingStatus']==4)
	{
	    $ListingStatus = 'Proprietorship';
	}else{
	    $ListingStatus = '';
	}
	                        //Transaction status
	if($CompanyProfile['Permissions1']==0)
	{
	    $Permissions = 'PE Backed';
	}
	elseif($CompanyProfile['Permissions1']==1)
	{
	    $Permissions = 'Non-PE Backed';
	}
	else{
	    $Permissions = '';
	}
	// elseif($CompanyProfile['Permissions1']==2)
	// {
	//     $Permissions = 'Non-Transacted and Fund Raising';
	// }

	$where7 = " city_id = ".$CompanyProfile['City'];
	$getcity = $city->getsinglecity($where7);

	$replace_array = array('\t','\n','<br>','<br/>','<br />','\r','\v');

	$BusinessDesc  = preg_replace("/\r\n|\r|\n/", '<br/>', $CompanyProfile['BusinessDesc']);
	$BusinessDesc  = str_replace($replace_array, '', $BusinessDesc);
	$BusinessDesc  = preg_replace("/\s+/", " ", $BusinessDesc);
	$BusinessDesc = trim(stripslashes($BusinessDesc)) . $sep; //BusinessDesc
	$AddressHead  = trim($CompanyProfile['AddressHead']);
	$AddressHead  = preg_replace("/\s+/", " ", $AddressHead);
	$AddressHead  = preg_replace("/\r\n|\r|\n/", '<br/>', $AddressHead);
	$AddressHead  = str_replace($replace_array, '', $AddressHead);
	$AddressLine2 = trim($CompanyProfile['AddressLine2']);
	$AddressLine2 = preg_replace("/\s+/", " ", $AddressLine2);
	$AddressLine2 = preg_replace("/\r\n|\r|\n/", '<br/>', $AddressLine2);
	$AddressLine2 = str_replace($replace_array, '', $AddressLine2);
	$Address      = trim((stripslashes($AddressHead) . ',' . stripslashes($AddressLine2)), ',');
	$Address = trim(stripslashes($Address)) . $sep; //Address
	$city = trim($getcity[0]) . $sep; //city
	$where7     = " Country_Id = " . $CompanyProfile['AddressCountry'];
	$getcountry = $countries->getsinglecountry($where7);
	$Country = $getcountry[0] . $sep; //Country

	$Phone = trim($CompanyProfile['Phone']);
	$Phone = preg_replace("/\r\n|\r|\n/", '<br/>', $Phone);
	$Phone = preg_replace("/\s+/", " ", $Phone);
	$Phone = str_replace($replace_array, '', $Phone);
	$Phone = trim(stripslashes($Phone)) . $sep; //Phone

	$CEO = trim($CompanyProfile['CEO']);
	$CEO = preg_replace("/\r\n|\r|\n/", '<br/>', $CEO);
	$CEO = preg_replace("/\s+/", " ", $CEO);
	$CEO = str_replace($replace_array, '', $CEO);
	$Contactperson = trim(stripslashes($CEO)) . $sep; //Contact person

	$CFO = trim($CompanyProfile['CFO']);
	$CFO = preg_replace("/\r\n|\r|\n/", '<br/>', $CFO);
	$CFO = preg_replace("/\s+/", " ", $CFO);
	$CFO = str_replace($replace_array, '', $CFO);
	$designation = trim(stripslashes($CFO)) . $sep; //designation

	$auditor_name = trim($CompanyProfile['auditor_name']);
	$auditor_name = preg_replace("/\r\n|\r|\n/", '<br/>', $auditor_name);
	$auditor_name = preg_replace("/\s+/", " ", $auditor_name);
	$auditor_name = str_replace($replace_array, '', $auditor_name);
	$auditor_name = trim(stripslashes($auditor_name)) . $sep; //auditor_name

	$Email = trim($CompanyProfile['Email']);
	$Email = preg_replace("/\r\n|\r|\n/", '<br/>', $Email);
	$Email = preg_replace("/\s+/", " ", $Email);
	$Email = str_replace($replace_array, '', $Email);
	$Email = trim(stripslashes($Email)) . $sep; //Email

	$websit = trim($CompanyProfile['Website']) . $sep; //websit

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);

	$cprofileExcel = new PHPExcel();
	$cprofileExcel->getActiveSheet()->setTitle('C Profile');
	$cprofileExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
	$cprofileExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Company Name')
	            ->setCellValue('B1', 'CIN Number')
	            ->setCellValue('C1', 'Brand Name')
	            ->setCellValue('D1', 'Industry')
	            ->setCellValue('E1', 'Sector')
	            ->setCellValue('F1', 'NAICS Code')
	            ->setCellValue('G1', 'Entity Type')
	            ->setCellValue('H1', 'Transaction Status')
	            ->setCellValue('I1', 'Year Founded')
	            ->setCellValue('J1', 'Business Description')
	            ->setCellValue('K1', 'Address')
	            ->setCellValue('L1', 'City')
	            ->setCellValue('M1', 'Country')
	            ->setCellValue('N1', 'Telephone')
	            ->setCellValue('O1', 'Contact Name')
	            ->setCellValue('P1', 'Designation')
	            ->setCellValue('Q1', 'Auditor Name')
	            ->setCellValue('R1', 'Email')
	            ->setCellValue('S1', 'Website');


	$cprofileExcel->setActiveSheetIndex(0)
	            ->setCellValue('A2', $CompanyProfile['FCompanyName'])
	            ->setCellValue('B2', $CompanyProfile['CIN'])
	            ->setCellValue('C2', $CompanyProfile['SCompanyName'])
	            ->setCellValue('D2', $industry)
	            ->setCellValue('E2', $sectorname)
	            ->setCellValue('F2', $naicsCode)
	            ->setCellValue('G2', $ListingStatus)
	            ->setCellValue('H2', $Permissions)
	            ->setCellValue('I2', $CompanyProfile['IncorpYear'])
	            ->setCellValue('J2', $BusinessDesc)
	            ->setCellValue('K2', $Address)
	            ->setCellValue('L2', $city)
	            ->setCellValue('M2', $Country)
	            ->setCellValue('N2', $Phone)
	            ->setCellValue('O2', $Contactperson)
	            ->setCellValue('P2', $designation)
	            ->setCellValue('Q2', $auditor_name)
	            ->setCellValue('R2', $Email)
	            ->setCellValue('S2', $websit);

	$outputFile = 'companyDetail_'.$CompanyProfile['Company_Id'].".xls";

	$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
            )
        )
    );
    
	foreach ($filenames as $key=>$filename) {

	    $excel = new PHPExcel();
	    $excel = PHPExcel_IOFactory::load($filename);
	    
	    $findEndDataRow = $excel->getActiveSheet()->getHighestRow();
	    $findEndDataColumn = $excel->getActiveSheet()->getHighestColumn('6:');
	    $colNumber = PHPExcel_Cell::columnIndexFromString($findEndDataColumn);
	    $colString = PHPExcel_Cell::stringFromColumnIndex($colNumber);
	    $findEndDataRow = $findEndDataRow + 1;
	    $excel->getActiveSheet()->getStyle($colString.'6:Z500')->applyFromArray($styleArray);
	    $excel->getActiveSheet()->getStyle('A2:Z2')->applyFromArray($styleArray);
	    $excel->getActiveSheet()->getStyle('A5:Z5')->applyFromArray($styleArray);
	    $excel->getActiveSheet()->getStyle('A'.$findEndDataRow.':Z500')->applyFromArray($styleArray);
	    $excel->getActiveSheet()->setTitle($key);
	    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
	    
	    foreach($excel->getSheetNames() as $sheetName) {
	       $sheet = $excel->getSheetByName($sheetName);
	       $sheet->setTitle($sheet->getTitle());
	       if($sheet->getTitle() == $key){
	           $cprofileExcel->addExternalSheet($sheet);
	       }
	    }
	}

	$companyDetailpath  = "companyDetail";
	$Dir = FOLDER_CREATE_PATH.$companyDetailpath;
	if(!is_dir($Dir)){
		mkdir($Dir,0777);chmod($Dir, 0777);
	}
	
	$Target_Path = $Dir.'/';
	$strOriginalPath = $Target_Path.$outputFile;
	if(file_exists($strOriginalPath)) { 
		chmod($strOriginalPath, 0777); 
		unlink($strOriginalPath); 
	}
	$objWriter = PHPExcel_IOFactory::createWriter($cprofileExcel, "Excel2007");//echo $strOriginalPath;exit();
	$objWriter->setPreCalculateFormulas(true);
	// header("Content-Type: application/vnd.ms-excel");
	// header("Content-Disposition: attachment; filename=$outputFile");
	// header("Cache-Control: max-age=0");
	$objWriter->save($strOriginalPath);
	//exit();

}

$template->assign('pageTitle',"Add Company Financials");
$template->assign('pageDescription',"Add Company Financials");
$template->assign('pageKeyWords',"Add Company Financials");
$template->display('admin/addcfinancials.tpl');

?>