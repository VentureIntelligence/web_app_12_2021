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
//$template->assign("companies" , $cprofile->getCompanies($where2,$order2));
if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

$runID = date( 'ymdhis' );
$created_on = date( 'Y-m-d h:i:s' );

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
        for ($k = 0; $k <= $YearCount-2; $k++) {
            if($Test[$k][1] != "<br>" && $Test[$k][1] != ""){
                //$FYList_N[] = trim(ereg_replace("[^0-9mM()]", " ", $Test[$k][1]));
                $FYList_N[] = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
            }
        }
        $result=array_diff($FYList,$FYList_N);
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
					$Insert_GrowthPercent['ResultType']             = $_REQUEST['answer']['ResultType'];
					
					$Insert_GrowthPercent['IndustryId_FK']          = $IndustryId;
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
					if(($Test[$l][5] != "NULL") && ($Test[$l+1][5] != "NULL")){
						$Insert_GrowthPercent['OptnlAdminandOthrExp']            = ($Test[$l][5] - $Test[$l+1][5]) / (abs($Test[$l+1][5]))*100;
					}
					if(($Test[$l][6] != "NULL") && ($Test[$l+1][6] != "NULL")){
						$Insert_GrowthPercent['OptnlProfit']            = ($Test[$l][6] - $Test[$l+1][6]) / (abs($Test[$l+1][6]))*100;
					}
					if(($Test[$l][7] != "NULL") && ($Test[$l+1][7] != "NULL")){
						$Insert_GrowthPercent['EBITDA']                 = ($Test[$l][7] - $Test[$l+1][7]) / (abs($Test[$l+1][7]))*100;
					}
					if(($Test[$l][8] != "NULL") && ($Test[$l+1][8] != "NULL")){
						$Insert_GrowthPercent['Interest']               = ($Test[$l][8] - $Test[$l+1][8]) / (abs($Test[$l+1][8]))*100;
					}
					if(($Test[$l][9] != "NULL") && ($Test[$l+1][9] != "NULL")){
						$Insert_GrowthPercent['EBDT']                   = ($Test[$l][9] - $Test[$l+1][9]) / (abs($Test[$l+1][9]))*100;
					}
					if(($Test[$l][10] != "NULL") && ($Test[$l+1][10] != "NULL")){
						$Insert_GrowthPercent['Depreciation']           = ($Test[$l][10] - $Test[$l+1][10]) / (abs($Test[$l+1][10]))*100;
					}
					if(($Test[$l][13] != "NULL") && ($Test[$l+1][13] != "NULL")){
						$Insert_GrowthPercent['EBT']                    = ($Test[$l][13] - $Test[$l+1][13]) / (abs($Test[$l+1][13]))*100;
					}
					if(($Test[$l][14] != "NULL") && ($Test[$l+1][14] != "NULL")){
						$Insert_GrowthPercent['Tax']                  = ($Test[$l][14] - $Test[$l+1][14]) / (abs($Test[$l+1][14]))*100;
					}
					/*if(($Test[$l][13] != "NULL") && ($Test[$l+1][13] != "NULL")){
						$Insert_GrowthPercent['PAT']            = ($Test[$l][13] - $Test[$l+1][13]) / (abs($Test[$l+1][13]))*100;
					}*/
					if(($Test[$l][15] != "NULL") && ($Test[$l+1][15] != "NULL")){
						$Insert_GrowthPercent['PAT']            = ($Test[$l][15] - $Test[$l+1][15]) / (abs($Test[$l+1][15]))*100;
					}
					if(($Test[$l][17] != "NULL") && ($Test[$l+1][17] != "NULL")){
						$Insert_GrowthPercent['BINR']            = ($Test[$l][17] - $Test[$l+1][17]) / (abs($Test[$l+1][17]))*100;
					}
					if(($Test[$l][18] != "NULL") && ($Test[$l+1][18] != "NULL")){
						$Insert_GrowthPercent['DINR']            = ($Test[$l][18] - $Test[$l+1][18]) / (abs($Test[$l+1][18]))*100;
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
					$Insert_CAGR['ResultType']             = $_REQUEST['answer']['ResultType'];
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
					if(($Test[0][5] != "NULL") && ($Test[$l+1][5] != "NULL") && ($Test[0][5] > 0) && ($Test[$l+1][5] > 0)){
						$Insert_CAGR['OptnlAdminandOthrExp']   = (pow(($Test[0][5]/$Test[$l+1][5]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][6] != "NULL") && ($Test[$l+1][6] != "NULL") && ($Test[0][6] > 0) && ($Test[$l+1][6] > 0)){
						$Insert_CAGR['OptnlProfit']            = (pow(($Test[0][6]/$Test[$l+1][6]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][7] != "NULL") && ($Test[$l+1][7] != "NULL") && ($Test[0][7] > 0) && ($Test[$l+1][7] > 0)){
						$Insert_CAGR['EBITDA']                 = (pow(($Test[0][7]/$Test[$l+1][7]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][8] != "NULL") && ($Test[$l+1][8] != "NULL") && ($Test[0][8] > 0) && ($Test[$l+1][8] > 0)){
						$Insert_CAGR['Interest']               = (pow(($Test[0][8]/$Test[$l+1][8]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][9] != "NULL") && ($Test[$l+1][9] != "NULL")&& ($Test[0][9] > 0) && ($Test[$l+1][9] > 0)){
						$Insert_CAGR['EBDT']                   = (pow(($Test[0][9]/$Test[$l+1][9]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][10] != "NULL") && ($Test[$l+1][10] != "NULL") && ($Test[0][10] > 0) && ($Test[$l+1][10] > 0)){
						$Insert_CAGR['Depreciation']           = (pow(($Test[0][10]/$Test[$l+1][10]),(1/($l+1)))-1) * 1000;
					}
					if(($Test[0][13] != "NULL") && ($Test[$l+1][13] != "NULL") && ($Test[0][13] > 0) && ($Test[$l+1][13] > 0)){
						$Insert_CAGR['EBT']                    = (pow(($Test[0][13]/$Test[$l+1][13]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][14] != "NULL") && ($Test[$l+1][14] != "NULL") && ($Test[0][14] > 0) && ($Test[$l+1][14] > 0)){
						$Insert_CAGR['Tax']                    = (pow(($Test[0][14]/$Test[$l+1][14]),(1/($l+1)))-1) * 100;
					}
					/*if(($Test[0][13] != "NULL") && ($Test[$l+1][13] != "NULL") && ($Test[0][13] > 0) && ($Test[$l+1][13] > 0)){
						$Insert_CAGR['PAT']            		   = (pow(($Test[0][13]/$Test[$l+1][13]),(1/($l+1)))-1) * 100;
					}*/
					if(($Test[0][15] != "NULL") && ($Test[$l+1][15] != "NULL") && ($Test[0][15] > 0) && ($Test[$l+1][15] > 0)){
						$Insert_CAGR['PAT']            		   = (pow(($Test[0][15]/$Test[$l+1][15]),(1/($l+1)))-1) * 100;
					}
					if(($Test[0][17] != "NULL") && ($Test[$l+1][17] != "NULL") && ($Test[0][17] > 0) && ($Test[$l+1][17] > 0)){
						$Insert_CAGR['BINR']                   = (pow(($Test[0][17]/$Test[$l+1][17]),(1/($l+1)))-1) * 100;
					}	
					if(($Test[0][18] != "NULL") && ($Test[$l+1][18] != "NULL") && ($Test[0][18] > 0) && ($Test[$l+1][18] > 0)){
						$Insert_CAGR['DINR']                   = (pow(($Test[0][18]/$Test[$l+1][18]),(1/($l+1)))-1) * 100;
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
						$Insert_BalanceSheet['ShareCapital']            = $Test[$k][2];
					}
					if($Test[$k][3] != "NULL"){
						$Insert_BalanceSheet['ReservesSurplus']         = $Test[$k][3];
					}
					if($Test[$k][4] != "NULL"){
						$Insert_BalanceSheet['TotalFunds']              = $Test[$k][4];
					}	
					if($Test[$k][5] != "NULL"){
						$Insert_BalanceSheet['ShareApplication']        = $Test[$k][5];
					}
                                        
                                        
                                        
					if($Test[$k][7] != "NULL"){
						$Insert_BalanceSheet['N_current_liabilities']       = $Test[$k][7];
					}
					if($Test[$k][8] != "NULL"){
						$Insert_BalanceSheet['L_term_borrowings']           = $Test[$k][8];
					}                                        
                                        if($Test[$k][9] != "NULL"){
						$Insert_BalanceSheet['deferred_tax_liabilities']    = $Test[$k][9];
					}
					if($Test[$k][10] != "NULL"){
						$Insert_BalanceSheet['O_long_term_liabilities']     = $Test[$k][10];
					} 
					if($Test[$k][11] != "NULL"){
						$Insert_BalanceSheet['L_term_provisions']       = $Test[$k][11];
					}
					if($Test[$k][12] != "NULL"){
						$Insert_BalanceSheet['T_non_current_liabilities']   = $Test[$k][12];
					}
                                        
                                        
                                        
					if($Test[$k][14] != "NULL"){
						$Insert_BalanceSheet['Current_liabilities']     = $Test[$k][14];
					}
					if($Test[$k][15] != "NULL"){
						$Insert_BalanceSheet['S_term_borrowings']       = $Test[$k][15];
					}
					if($Test[$k][16] != "NULL"){
						$Insert_BalanceSheet['Trade_payables']          = $Test[$k][16];
					}
					if($Test[$k][17] != "NULL"){
						$Insert_BalanceSheet['O_current_liabilities']   = $Test[$k][17];
					}
					if($Test[$k][18] != "NULL"){
						$Insert_BalanceSheet['S_term_provisions']       = $Test[$k][18];
					}
					if($Test[$k][19] != "NULL"){
						$Insert_BalanceSheet['T_current_liabilities']   = $Test[$k][19];
					}
					if($Test[$k][20] != "NULL"){
						$Insert_BalanceSheet['T_equity_liabilities']    = $Test[$k][20];
					}
                                        
                                        
                                        
                                        
					if($Test[$k][22] != "NULL"){
						$Insert_BalanceSheet['Assets']                  = $Test[$k][22];
					}
                                        
                                        
					if($Test[$k][24] != "NULL"){
						$Insert_BalanceSheet['N_current_assets']        = $Test[$k][24];
					}
                                        
                                        
					if($Test[$k][26] != "NULL"){
						$Insert_BalanceSheet['Fixed_assets']            = $Test[$k][26];
					}
					if($Test[$k][27] != "NULL"){
						$Insert_BalanceSheet['Tangible_assets']         = $Test[$k][27];
					}
					if($Test[$k][28] != "NULL"){
						$Insert_BalanceSheet['Intangible_assets']       = $Test[$k][28];
					}
					if($Test[$k][29] != "NULL"){
						$Insert_BalanceSheet['T_fixed_assets']          = $Test[$k][29];
					}
					if($Test[$k][30] != "NULL"){
						$Insert_BalanceSheet['N_current_investments']   = $Test[$k][30];
					}
					if($Test[$k][31] != "NULL"){
						$Insert_BalanceSheet['Deferred_tax_assets']     = $Test[$k][31];
					}
					if($Test[$k][32] != "NULL"){
						$Insert_BalanceSheet['L_term_loans_advances']   = $Test[$k][32];
					}
					if($Test[$k][33] != "NULL"){
						$Insert_BalanceSheet['O_non_current_assets']    = $Test[$k][33];
					}
					if($Test[$k][34] != "NULL"){
						$Insert_BalanceSheet['T_non_current_assets']    = $Test[$k][34];
					}
                                        
                                        
					if($Test[$k][36] != "NULL"){
						$Insert_BalanceSheet['Current_assets']          = $Test[$k][36];
					}
					if($Test[$k][37] != "NULL"){
						$Insert_BalanceSheet['Current_investments']     = $Test[$k][37];
					}
					if($Test[$k][38] != "NULL"){
						$Insert_BalanceSheet['Inventories']             = $Test[$k][38];
					}
					if($Test[$k][39] != "NULL"){
						$Insert_BalanceSheet['Trade_receivables']       = $Test[$k][39];
					}
					if($Test[$k][40] != "NULL"){
						$Insert_BalanceSheet['Cash_bank_balances']      = $Test[$k][40];
					}
                                        if($Test[$k][41] != "NULL"){
						$Insert_BalanceSheet['S_term_loans_advances']   = $Test[$k][41];
					}
                                        if($Test[$k][42] != "NULL"){
						$Insert_BalanceSheet['O_current_assets']        = $Test[$k][42];
					}
                                        if($Test[$k][43] != "NULL"){
						$Insert_BalanceSheet['T_current_assets']        = $Test[$k][43];
					}
                                        if($Test[$k][44] != "NULL"){
						$Insert_BalanceSheet['Total_assets']            = $Test[$k][44];
					}
					
					//$Insert_BalanceSheet['FY']                     = trim(ereg_replace("[^0-9mM()]", " ", $Test[$k][1]));
					$Insert_BalanceSheet['FY']                     = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
					
                                        
                                       // print_r($Insert_BalanceSheet); 
                                       
					$balancesheet_new->update($Insert_BalanceSheet);
					unset($Insert_BalanceSheet);
					
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

$template->assign('pageTitle',"Add Company Financials");
$template->assign('pageDescription',"Add Company Financials");
$template->assign('pageKeyWords',"Add Company Financials");
$template->display('admin/addcfinancials.tpl');

?>