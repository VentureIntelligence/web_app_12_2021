<?php
/**
 * Class addcfinancials
 *
 * Generated excel are procssed here and data is updated to the database. 
 * If old format is run - all FY data's are cleared and newly generated FY data are inserted for standlaone.
 * If new format is run - Data will be merged with the existing FY.
 * 
 *
 * 
 * Functions used plstandaloneadd, bsaddfinancialdata, growthpercentageadd
 * growthpercentageadd - Due to merging of new format data CAGR calculation existing code cannot be used. Existing system calculation is removed and new calcualtion is added from the bulk upload code. 
 * 
 * @author     Jagdeesh MV <jagadeesh@kutung.in>
 * @version    1.0
 * @created    20-07-2018
 */

require 'vendor/autoload.php';
require_once MODULES_DIR."industries.php";
require_once MODULES_DIR."plstandard.php";
require_once MODULES_DIR."cprofile.php";
require_once MODULES_DIR."balancesheet.php";
require_once MODULES_DIR."balancesheet_new.php";
require_once MODULES_DIR."growthpercentage.php";
require_once MODULES_DIR."cagr.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;

class addcfinancials {
	
	function __construct() {
		# code...
	}
	/*
	* PL data are processed for botn new or old and standalone or consolidated
	*/
	public function plstandaloneadd( $cin = '', $excel_type = '', $UploadedSourceFile, $type = '', $run_id = '', $processedCin = '', $logFileName = '' ) {
		global $Excelgenerate;
		global $logs;
		global $xbrl;
		//require_once '../Excel/reader.php';
		$logs->logWrite( "Add financial - PL Code started" );
		$xbrl->update_start_upload( $run_id, $cin, $processedCin, $logFileName );
		$industries = new industries();
		$plstandard = new plstandard();
		$cprofile = new cprofile();
		$balancesheet = new balancesheet();
		$balancesheet_new = new balancesheet_new();
		$growthpercentage = new growthpercentage();
		$cagr = new cagr();
		$where = "CIN = '" . $cin . "'";
		$Companies = $cprofile->getCompaniesAutoSuggest( $where );
		if( empty( $Companies ) ) {
			$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
	        $logs->logWrite( "Add financial - CIN not found in Database", true );
	        return true;
		}
		$companyIDArray = array_keys ( $Companies );
		$companyID = $companyIDArray[0];
		$companyName = $Companies[ $companyID ];
		$AddFinancials = 'MCA - Automated';

		$logs->logWrite( "Add financial started for company ID " . $companyID ); 
		// deletepltsandard.php code

		/*if( $type == 'O' && $excel_type == 'S' ) {
			$logs->logWrite( "Add financial - Old format processing standlaone. Delete P&L data" );
			$plstandard->deleteCompanyWithType( $companyID, 0 );
			$growthpercentage->deleteCompanyWithType( $companyID, 0 );
			$cagr->deleteCompanyWithType( $companyID, 0 );
			// $UploadedNewFilePath = "../../cfs-old/media/plstandard/PLStandard_".$companyID."_NEW.xls";
			// $UploadedOldFilePath = "../../cfs-old/media/plstandard/PLStandard_".$companyID."_OLD.xls";
			// unlink( $UploadedNewFilePath );
			// unlink( $UploadedOldFilePath );
		} else if( $type == 'O' && $excel_type == 'C' ) {
			$logs->logWrite( "Add financial - Old format processing consolidated. Delete P&L data" );
			$plstandard->deleteCompanyWithType( $companyID, 1 );
			$growthpercentage->deleteCompanyWithType( $companyID, 1 );
			$cagr->deleteCompanyWithType( $companyID, 1 );
			// $UploadedNewFilePath = "../../cfs-old/media/plstandard/PLStandard_".$companyID."_NEW_1.xls";
			// $UploadedOldFilePath = "../../cfs-old/media/plstandard/PLStandard_".$companyID."_OLD_1.xls";
			// unlink( $UploadedNewFilePath );
			// unlink( $UploadedOldFilePath );
		}*/
		
		if( $type == 'O' ) {
			$excel_filename_extend = '_OLD';
		} else {
			$excel_filename_extend = '_NEW';
		}
		// deletepltsandard.php code ends
		if( $excel_type == 'S' ) {
			$logs->logWrite( "Add financial - Standalone file detected" );
			$ResultType = 0;
		} else if( $excel_type == 'C' ) {
			$logs->logWrite( "Add financial - Consolidated file detected" );
			$ResultType = 1;
		}
		$DeleteHeaderImagePath = '';
		$PLStandard  = "plstandard";
		$Dir = FOLDER_CREATE_PATH.$PLStandard;
		try {
			if( !is_dir( $Dir ) ){
				mkdir($Dir,0777);chmod($Dir, 0777);
			}
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
		if( $ResultType == 0 ) {
			$imageFileName = "PLStandard_".$companyID . $excel_filename_extend . ".xls";
		}else{
			$imageFileName = "PLStandard_".$companyID . $excel_filename_extend . "_1.xls";
		}
		$Target_Path = $Dir.'/';
		$strOriginalPath = $Target_Path.$imageFileName;
		// uploadCommon.php code
		// DELETE FILE IF EXISTING
		/*if(file_exists($DeleteHeaderImagePath)) { 
			try {
				@chmod($DeleteHeaderImagePath, 0777); 
				unlink($DeleteHeaderImagePath); 
			} catch( Exception $e ) {
				echo $e->getMessage();
			}
		}*/
		/*try {
			if( copy( $UploadedSourceFile, $strOriginalPath ) ) {
				$old = umask(0);
				chmod( $strOriginalPath, 777, true );
				umask($old);
			} else {
				$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
		        $logs->logWrite( "Add financial - File copy error", true );
			}
		} catch( Exception $e ) {
			echo $e->getMessage();
		}*/
		// uploadCommon.php code ends
		try {
			$inputFileType = IOFactory::identify($UploadedSourceFile);
			$reader = IOFactory::createReader($inputFileType);
			$spreadsheet1 = $reader->load($UploadedSourceFile);
			$dataSheet = $spreadsheet1->getActiveSheet()->toArray(null, true, true, true);
			$YearCount = count($dataSheet[6]);
			$YearCount1 = count($dataSheet[6]);	
		} catch( Exception $e ) {
			//print_r( $e->getMessage() );
		}
		
		$excelIndex = $Excelgenerate->createColumnsArray( 'BZ' );
		$i=0;
		$logs->logWrite( "Add financial - Year count check" );
		for( $m = 0; $m <= $YearCount -2; $m++ ) {
			$x=6; $i=0;
			for ( $x; $x <= count($dataSheet)+3; $x++ ) {
				$i++;
				$Test[ $m ][ $i ] = ( $dataSheet[$x][$excelIndex[$m+1]] == '-' )?'NULL':$dataSheet[$x][$excelIndex[$m+1]]."<br>";
			}
		}
		$logs->logWrite( "Add financial - Test data populated" );
		$cprofile->select( $companyID );	
		$IndustryId = $cprofile->elements["Industry"];
		if( $ResultType == 0 ) {
			$Insert_YearCount[ 'Company_Id' ] = $companyID;
			$Insert_YearCount[ 'FYCount' ] = $YearCount1 - 1;
			$Insert_YearCount[ 'GFYCount' ] = $YearCount1 - 2;
			$cprofile->update($Insert_YearCount);
		}
		$FYList = $FYList_N = array();
		$detailCheck = mysql_query( "SELECT PLStandard_Id, FY FROM plstandard WHERE CId_FK='".$companyID."' and ResultType='".$ResultType."'" );
		if( mysql_num_rows( $detailCheck ) > 0 ){
			$logs->logWrite( "Add financial - Existing Data Check enter" );
	        while( $detailChecks = mysql_fetch_array( $detailCheck ) ) {
	            $FYList[] = trim( $detailChecks['FY'] );
	        }
	        for ( $k = 0; $k <= $YearCount-2; $k++ ) {
	            if( $Test[$k][1] != "<br>" && $Test[$k][1] != "" ){
	            	if(($Test[$k][2] == "<br>" || $Test[$k][2] == "") && ($Test[$k][3] == "<br>" || $Test[$k][3] == "") && ($Test[$k][4] == "<br>" || $Test[$k][4] == "") && ($Test[$k][5] == "<br>" || $Test[$k][5] == ""  || $Test[$k][5] == "NULL")){

					} else {
						$FYList_N[] = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
					}
	            }
	        }
	        //$result = array_diff( $FYList, $FYList_N );
	        $result = $FYList_N;
	        foreach( $result as $val ){
	            if( $val !='' ) {
	            	$logs->logWrite( "Add financial - Delete FY" . $val . " data from DB" );
	                mysql_query( "DELETE FROM plstandard WHERE CId_FK='".$companyID."' and ResultType='".$ResultType."' and FY='".$val."'" );
	                if( mysql_errno() ) {
	                	$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
	                	$logs->logWrite( "Add financial - FY" . $val . " existing pl data delete error", true );
	                }
	                mysql_query( "DELETE FROM cagr WHERE CId_FK='".$companyID."' and ResultType='".$ResultType."' and FY='".$val."'" );
	                if( mysql_errno() ) {
	                	$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
	                	$logs->logWrite( "Add financial - FY" . $Insert_PLStandard['FY'] . " existing cagr data delete error", true );
	                }
	                mysql_query( "DELETE FROM growthpercentage WHERE CId_FK='".$companyID."' and ResultType='".$ResultType."' and FY='".$val."'" );
	                if( mysql_errno() ) {
	                	$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
	                	$logs->logWrite( "Add financial - FY" . $Insert_PLStandard['FY'] . " existing GP data delete error", true );
	                }
	            }
	        }
	    }
	    $PLSFields = array( "PLStandard_Id","FY" );
		$PLSwhere = " CId_FK = ".$companyID." && ResultType = ".$ResultType;
		$PLSEXitsChk = $plstandard->getFullList(1,10,$PLSFields,$PLSwhere,"PLStandard_Id ASC","name");
		$k=0;
		$logs->logWrite( "Add financial - PL Insert loop started" );
		// echo '<pre>'; print_r( $Test ); echo '</pre>';
		// exit;
		for ( $k = 0; $k <= $YearCount-2; $k++ ) {
			if( $Test[$k][1] != "<br>" && $Test[$k][1] != "" ) {	
				if(($Test[$k][2] == "<br>" || $Test[$k][2] == "") && ($Test[$k][3] == "<br>" || $Test[$k][3] == "") && ($Test[$k][4] == "<br>" || $Test[$k][4] == "") && ($Test[$k][5] == "<br>" || $Test[$k][5] == ""  || $Test[$k][5] == "NULL")){
					
				}
				else {
					$Insert_PLStandard = array();
					$update_PLStandard = array();
					/*if($PLSEXitsChk[$k]['PLStandard_Id'] != " " && $PLSEXitsChk[$k]['PLStandard_Id'] != "") {
						$update_PLStandard['PLStandard_Id'] = $Insert_PLStandard['PLStandard_Id']  = $PLSEXitsChk[$k]['PLStandard_Id'];
						$Insert_PLStandard['updated_date']  = date("Y-m-d:H:i:s");
					} else {*/
	                    $Insert_PLStandard['Added_Date'] = date("Y-m-d:H:i:s");
	                /*}*///If Ends
					$Insert_PLStandard['CId_FK'] = $companyID;
					$Insert_PLStandard['ResultType'] = $ResultType;
		            $Insert_PLStandard['AddFinancials'] = $AddFinancials;
					$Insert_PLStandard['IndustryId_FK'] = $IndustryId;
					if($Test[$k][2] != "NULL"){					
						$Insert_PLStandard['OptnlIncome'] = $Test[$k][2];
					}
					$update_PLStandard['OptnlIncome'] = NULL;   
					if($Test[$k][3] != "NULL"){
						$Insert_PLStandard['OtherIncome'] = $Test[$k][3];
					}
		            $update_PLStandard['OtherIncome'] = NULL;
					if($Test[$k][4] != "NULL"){
						$Insert_PLStandard['TotalIncome'] = $Test[$k][4];
					}	
		            $update_PLStandard['TotalIncome'] = NULL;	

					if($Test[$k][5] != "NULL"){
						$Insert_PLStandard['OptnlAdminandOthrExp'] = $Test[$k][5];
					}
		            $update_PLStandard['OptnlAdminandOthrExp'] =  NULL;
					if($Test[$k][6] != "NULL"){
						$Insert_PLStandard['OptnlProfit'] = $Test[$k][6];
					}
					$update_PLStandard['OptnlProfit'] =  NULL;
					if($Test[$k][7] != "NULL"){
						$Insert_PLStandard['EBITDA'] = $Test[$k][7];
					}
					$update_PLStandard['EBITDA'] =  NULL;
					if($Test[$k][8] != "NULL"){
						$Insert_PLStandard['Interest'] = $Test[$k][8];
					}
					$update_PLStandard['Interest'] =  NULL;
					if($Test[$k][9] != "NULL"){
						$Insert_PLStandard['EBDT'] = $Test[$k][9];
					}
					$update_PLStandard['EBDT'] =  NULL;
					if($Test[$k][10] != "NULL"){
						$Insert_PLStandard['Depreciation'] = $Test[$k][10];
					}
					$update_PLStandard['Depreciation'] =  NULL;
					if($Test[$k][11] != "NULL"){
						$Insert_PLStandard['EBT_before_Priod_period'] = $Test[$k][11];
					}
					$update_PLStandard['EBT_before_Priod_period'] =  NULL;
					if($Test[$k][12] != "NULL"){
						$Insert_PLStandard['Priod_period'] = $Test[$k][12];
					}
					$update_PLStandard['Priod_period'] =  NULL;
					if($Test[$k][13] != "NULL"){
						$Insert_PLStandard['EBT'] = $Test[$k][13];
					}
					$update_PLStandard['EBT'] =  NULL;
					if($Test[$k][14] != "NULL"){
						$Insert_PLStandard['Tax'] = $Test[$k][14];
					}
					$update_PLStandard['Tax'] =  NULL;
					if($Test[$k][15] != "NULL"){
						$Insert_PLStandard['PAT'] = $Test[$k][15];
					}
					$update_PLStandard['PAT'] =  NULL;
					
					if( $ResultType == 0 ) {
						if($Test[$k][17] != "NULL"){
							$Insert_PLStandard['BINR'] = $Test[$k][17];
						}
						$update_PLStandard['BINR'] =  NULL;
						if($Test[$k][18] != "NULL"){
							$Insert_PLStandard['DINR'] = $Test[$k][18];
						}
		                $update_PLStandard['DINR'] =  NULL;
		                if($Test[$k][20] != "NULL"){
							$Insert_PLStandard['EmployeeRelatedExpenses'] = $Test[$k][20];
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
						if($Test[$k][23] != "NULL") {
							$Insert_PLStandard['OutgoinForeignExchange'] = $Test[$k][23];
						}
		                $update_PLStandard['OutgoinForeignExchange'] =  NULL;
					} else if( $ResultType = 1 ) {
						if($Test[$k][16] != "NULL"){
							$Insert_PLStandard['profit_loss_of_minority_interest'] = strip_tags( $Test[$k][16] );
						}
						$update_PLStandard['profit_loss_of_minority_interest'] =  NULL;
						if($Test[$k][17] != "NULL"){
							$Insert_PLStandard['total_profit_loss_for_period'] = strip_tags( $Test[$k][17] );
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
						if($Test[$k][25] != "NULL") {
							$Insert_PLStandard['OutgoinForeignExchange'] = $Test[$k][25];
						}
		                $update_PLStandard['OutgoinForeignExchange'] =  NULL;
					}
					
	                $Insert_PLStandard['FY']                     = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
	                if($PLSEXitsChk[$k]['PLStandard_Id'] != " " && $PLSEXitsChk[$k]['PLStandard_Id'] != "") {
	                    $plInsertCheck = $plstandard->update($update_PLStandard);
	                }
					$plInsertCheck = $plstandard->update($Insert_PLStandard);
					if( !$plInsertCheck ) {
						$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
						$logs->logWrite( "Add financial - FY" . $Insert_PLStandard['FY'] . " pl data insert error", true );
					} else {
						$logs->logWrite( "Add financial - FY" . $Insert_PLStandard['FY'] . " pl data inserted" );
					}
					unset($update_PLStandard);
					unset($Insert_PLStandard);
				}
					
			}//If Ends
		}
		$logs->logWrite( "Add financial - PL Insert loop ends" );
		// CAGR AND GROWTHPERCENTAGE ADD STARTS
		$this->growthpercentageadd( $companyID, $IndustryId, $ResultType, $run_id, $processedCin, $logFileName, $cin );
		// CAGR AND GROWTHPERCENTAGE ADD ENDS
		$logs->logWrite( "Add financial ends" );
		if( $excel_type == 'S' ) {
			$logs->logWrite( "Regen Excel for PL Standalone Started" );
			$this->generateStandalonePLexcel( $companyID, $ResultType, $companyName, $run_id, $processedCin, $logFileName, $cin );
		} else if( $excel_type == 'C' ) {
			$logs->logWrite( "Regen Excel for PL Consolidated Started" );
			$this->generateConsolidatedPLexcel( $companyID, $ResultType, $companyName, $run_id, $processedCin, $logFileName, $cin );
		}
		$logs->logWrite( "Regen Excel for PL Ended" ); 
		return true;
	}
	/*
	* BS data are processed for both new or old and standlaone or conslidated
	*/
	public function bsaddfinancialdata( $cin = '', $excel_type = '', $UploadedSourceFile = '', $type = '', $run_id = '', $processedCin = '', $logFileName = '' ) {
		global $Excelgenerate;
		global $logs;
		global $xbrl;
		//require_once '../Excel/reader.php';
		$logs->logWrite( "Add financial - BS Code started" );
		$xbrl->update_start_upload( $run_id, $cin, $processedCin, $logFileName );
		$industries = new industries();
		$plstandard = new plstandard();
		$cprofile = new cprofile();
		$balancesheet = new balancesheet();
		$balancesheet_new = new balancesheet_new();
		$where = "CIN = '" . $cin . "'";
		$Companies = $cprofile->getCompaniesAutoSuggest( $where );
		if( empty( $Companies ) ) {
			$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
	        $logs->logWrite( "Add BS - CIN not found in Database", true );
	        return true;
		}
		$companyIDArray = array_keys ( $Companies );
		$companyID = $companyIDArray[0];
		$companyName = $Companies[ $companyID ];
		$DeleteHeaderImagePath = '';
		if( $excel_type == 'S' ) {
			$ResultType = 0;
		} else if( $excel_type == 'C' ) {
			$ResultType = 1;
		}
		if( $type == 'O' ) {
			$excel_filename_extend = '_OLD';
		} else {
			$excel_filename_extend = '_NEW';
		}
		$logs->logWrite( "Add BS started for companyID " .$companyID ); 
		/*$BalSheet_new  = "balancesheet_new";
		$Dir = FOLDER_CREATE_PATH.$BalSheet_new;
		try {
			if( !is_dir( $Dir ) ) {
				mkdir( $Dir, 0777 ); chmod( $Dir, 0777 );
			}
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
		if( $ResultType == 0 ){
			$imageFileName = "New_BalSheet_".$companyID . $excel_filename_extend . ".xls"; // NEW STANDALONE
		}else{
			$imageFileName = "New_BalSheet_".$companyID . $excel_filename_extend . "_1.xls"; // NEW CONSOLIDATED
		}
		$Target_Path = $Dir.'/';
		$strOriginalPath = $Target_Path.$imageFileName;*/
		// uploadCommon.php code
		// DELETE FILE IF EXISTING
		/*if(file_exists($DeleteHeaderImagePath)) { 
			try {
				@chmod($DeleteHeaderImagePath, 0777); 
				unlink($DeleteHeaderImagePath); 
			} catch( Exception $e ) {
				echo $e->getMessage();
			}
		}
		try {
			if( copy( $UploadedSourceFile, $strOriginalPath ) ) {
				$old = umask(0);
				chmod( $strOriginalPath, 777, true );
				umask($old);
			} else {
				$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
				$logs->logWrite( "Add BS - File copy error", true );
			}
		} catch( Exception $e ) {
			echo $e->getMessage();
		}*/
		// uploadCommon.php code ends
		$inputFileType = IOFactory::identify( $UploadedSourceFile );
		$reader = IOFactory::createReader( $inputFileType );
		$spreadsheet1 = $reader->load( $UploadedSourceFile );
		$dataSheet = $spreadsheet1->getActiveSheet()->toArray(null, true, true, true);
		$YearCount = count( $dataSheet[6] );
		$excelIndex = $Excelgenerate->createColumnsArray( 'BZ' );
		$i=0;
		for ( $m = 0; $m <= $YearCount -2; $m++ ) {
			$x=6;
			$i=0;
			for ( $x; $x <= count($dataSheet)+8; $x++ ) {
				$i++;
				$Test[$m][$i] =  ($dataSheet[$x][$excelIndex[$m+1]]=='-')?'NULL':$dataSheet[$x][$excelIndex[$m+1]]."<br>";
			}
		}
		$logs->logWrite( "Add BS - Test data populated" );
		$cprofile->select( $companyID );	
		$IndustryId = $cprofile->elements["Industry"];
		$Insert_YearCount['Company_Id'] = $companyID;
		if ($YearCount > 0){
			// if( $type == 'O' ) {
			//     $balancesheet_new->deleteBalancesheet( $companyID, $ResultType );
			// }
		}
		
		$logs->logWrite( "Add BS - Loop starts" );
		for ($k = 0; $k <= $YearCount-2; $k++) {
			if($Test[$k][1] != "<br>" && $Test[$k][1] != ''){

				$logs->logWrite( "Add BS - FY check Query Started" );
				$fyCheck = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
				$BalanceFields1 = array( "a.BalanceSheet_Id", "a.FY" );
				$Balancewhere1 = " a.CId_FK = ".$companyID." && a.FY = '$fyCheck' && a.ResultType = ".$ResultType;
				$BalanceEXitsChk1 = $balancesheet_new->getFullList_withoutPL(1,10,$BalanceFields1,$Balancewhere1,"FY DESC","name");
				$logs->logWrite( "Add BS - FY check Query Ended" );

				$Insert_BalanceSheet = array();
				if($BalanceEXitsChk1['BalanceSheet_Id'] != " ") {
					$BalanceEXitsChk1['BalanceSheet_Id'];
					$logs->logWrite( "Add BS - " . $fyCheck . " exist and updating value" );
					$Insert_BalanceSheet['BalanceSheet_Id'] = $BalanceEXitsChk1['BalanceSheet_Id'];
					$Insert_BalanceSheet['updated_date'] = date("Y-m-d H:i:s");					
				}  else {
					$logs->logWrite( "Add BS - " . $fyCheck . " not exist and inserting value" );                                    
					$Insert_BalanceSheet['Added_Date'] = date("Y-m-d H:i:s");
                }//If Ends
				$Insert_BalanceSheet['CId_FK'] = $companyID;
				$Insert_BalanceSheet['ResultType'] = $ResultType;
				$Insert_BalanceSheet['IndustryId_FK'] = $IndustryId;
				if($Test[$k][2] != "NULL"){					
					$Insert_BalanceSheet['ShareCapital'] = $Test[$k][2];
				} else {
					$Insert_BalanceSheet['ShareCapital'] = NULL;
				}
				if($Test[$k][3] != "NULL"){
					$Insert_BalanceSheet['ReservesSurplus'] = $Test[$k][3];
				} else {
					$Insert_BalanceSheet['ReservesSurplus'] = NULL;
				}
				if($Test[$k][4] != "NULL"){
					$Insert_BalanceSheet['TotalFunds'] = $Test[$k][4];
				} else {
					$Insert_BalanceSheet['TotalFunds'] = NULL;
				}	
				if($Test[$k][5] != "NULL"){
					$Insert_BalanceSheet['ShareApplication'] = $Test[$k][5];
				} else {
					$Insert_BalanceSheet['ShareApplication'] = NULL;
				}
				if($Test[$k][7] != "NULL"){
					$Insert_BalanceSheet['N_current_liabilities'] = $Test[$k][7];
				} else {
					$Insert_BalanceSheet['N_current_liabilities'] = NULL;
				}
				if($Test[$k][8] != "NULL"){
					$Insert_BalanceSheet['L_term_borrowings'] = $Test[$k][8];
				} else {
					$Insert_BalanceSheet['L_term_borrowings'] = NULL;
				}                                        
                if($Test[$k][9] != "NULL"){
					$Insert_BalanceSheet['deferred_tax_liabilities'] = $Test[$k][9];
				} else {
					$Insert_BalanceSheet['deferred_tax_liabilities'] = NULL;
				}
				if($Test[$k][10] != "NULL"){
					$Insert_BalanceSheet['O_long_term_liabilities'] = $Test[$k][10];
				} else {
					$Insert_BalanceSheet['O_long_term_liabilities'] = NULL;
				} 
				if($Test[$k][11] != "NULL"){
					$Insert_BalanceSheet['L_term_provisions'] = $Test[$k][11];
				} else {
					$Insert_BalanceSheet['L_term_provisions'] = NULL;
				}
				if($Test[$k][12] != "NULL"){
					$Insert_BalanceSheet['T_non_current_liabilities'] = $Test[$k][12];
				} else {
					$Insert_BalanceSheet['T_non_current_liabilities'] = NULL;
				}                                    
				if($Test[$k][14] != "NULL"){
					$Insert_BalanceSheet['Current_liabilities'] = $Test[$k][14];
				} else {
					$Insert_BalanceSheet['Current_liabilities'] = NULL;
				}
				if($Test[$k][15] != "NULL"){
					$Insert_BalanceSheet['S_term_borrowings'] = $Test[$k][15];
				} else {
					$Insert_BalanceSheet['S_term_borrowings'] = NULL;
				}
				if($Test[$k][16] != "NULL"){
					$Insert_BalanceSheet['Trade_payables'] = $Test[$k][16];
				} else {
					$Insert_BalanceSheet['Trade_payables'] = NULL;
				}
				if($Test[$k][17] != "NULL"){
					$Insert_BalanceSheet['O_current_liabilities'] = $Test[$k][17];
				} else {
					$Insert_BalanceSheet['O_current_liabilities'] = NULL;
				}
				if($Test[$k][18] != "NULL"){
					$Insert_BalanceSheet['S_term_provisions'] = $Test[$k][18];
				} else {
					$Insert_BalanceSheet['S_term_provisions'] = NULL;
				}
				if($Test[$k][19] != "NULL"){
					$Insert_BalanceSheet['T_current_liabilities'] = $Test[$k][19];
				} else {
					$Insert_BalanceSheet['T_current_liabilities'] = NULL;
				}
				if($Test[$k][20] != "NULL"){
					$Insert_BalanceSheet['T_equity_liabilities'] = $Test[$k][20];
				} else {
					$Insert_BalanceSheet['T_equity_liabilities'] = NULL;
				}                 
				if($Test[$k][22] != "NULL"){
					$Insert_BalanceSheet['Assets']                  = $Test[$k][22];
				} else {
					$Insert_BalanceSheet['Assets'] = NULL;
				}                  
				if($Test[$k][24] != "NULL"){
					$Insert_BalanceSheet['N_current_assets']        = $Test[$k][24];
				} else {
					$Insert_BalanceSheet['N_current_assets'] = NULL;
				}                                    
				if($Test[$k][26] != "NULL"){
					$Insert_BalanceSheet['Fixed_assets']            = $Test[$k][26];
				} else {
					$Insert_BalanceSheet['Fixed_assets'] = NULL;
				}
				if($Test[$k][27] != "NULL"){
					$Insert_BalanceSheet['Tangible_assets']         = $Test[$k][27];
				} else {
					$Insert_BalanceSheet['Tangible_assets'] = NULL;
				}
				if($Test[$k][28] != "NULL"){
					$Insert_BalanceSheet['Intangible_assets']       = $Test[$k][28];
				} else {
					$Insert_BalanceSheet['Intangible_assets'] = NULL;
				}
				if($Test[$k][29] != "NULL"){
					$Insert_BalanceSheet['T_fixed_assets']          = $Test[$k][29];
				} else {
					$Insert_BalanceSheet['T_fixed_assets'] = NULL;
				}
				if($Test[$k][30] != "NULL"){
					$Insert_BalanceSheet['N_current_investments']   = $Test[$k][30];
				} else {
					$Insert_BalanceSheet['N_current_investments'] = NULL;
				}
				if($Test[$k][31] != "NULL"){
					$Insert_BalanceSheet['Deferred_tax_assets']     = $Test[$k][31];
				} else {
					$Insert_BalanceSheet['Deferred_tax_assets'] = NULL;
				}
				if($Test[$k][32] != "NULL"){
					$Insert_BalanceSheet['L_term_loans_advances']   = $Test[$k][32];
				} else {
					$Insert_BalanceSheet['L_term_loans_advances'] = NULL;
				}
				if($Test[$k][33] != "NULL"){
					$Insert_BalanceSheet['O_non_current_assets']    = $Test[$k][33];
				} else {
					$Insert_BalanceSheet['O_non_current_assets'] = NULL;
				}
				if($Test[$k][34] != "NULL"){
					$Insert_BalanceSheet['T_non_current_assets']    = $Test[$k][34];
				} else {
					$Insert_BalanceSheet['T_non_current_assets'] = NULL;
				}                
				if($Test[$k][36] != "NULL"){
					$Insert_BalanceSheet['Current_assets']          = $Test[$k][36];
				} else {
					$Insert_BalanceSheet['Current_assets'] = NULL;
				}
				if($Test[$k][37] != "NULL"){
					$Insert_BalanceSheet['Current_investments']     = $Test[$k][37];
				} else {
					$Insert_BalanceSheet['Current_investments'] = NULL;
				}
				if($Test[$k][38] != "NULL"){
					$Insert_BalanceSheet['Inventories']             = $Test[$k][38];
				} else {
					$Insert_BalanceSheet['Inventories'] = NULL;
				}
				if($Test[$k][39] != "NULL"){
					$Insert_BalanceSheet['Trade_receivables']       = $Test[$k][39];
				} else {
					$Insert_BalanceSheet['Trade_receivables'] = NULL;
				}
				if($Test[$k][40] != "NULL"){
					$Insert_BalanceSheet['Cash_bank_balances']      = $Test[$k][40];
				} else {
					$Insert_BalanceSheet['Cash_bank_balances'] = NULL;
				}
                if($Test[$k][41] != "NULL"){
					$Insert_BalanceSheet['S_term_loans_advances']   = $Test[$k][41];
				} else {
					$Insert_BalanceSheet['S_term_loans_advances'] = NULL;
				}
                if($Test[$k][42] != "NULL"){
					$Insert_BalanceSheet['O_current_assets']        = $Test[$k][42];
				} else {
					$Insert_BalanceSheet['O_current_assets'] = NULL;
				}
                if($Test[$k][43] != "NULL"){
					$Insert_BalanceSheet['T_current_assets']        = $Test[$k][43];
				} else {
					$Insert_BalanceSheet['T_current_assets'] = NULL;
				}
                if($Test[$k][44] != "NULL"){
					$Insert_BalanceSheet['Total_assets']            = $Test[$k][44];
				} else {
					$Insert_BalanceSheet['Total_assets'] = NULL;
				}
				if( $ResultType == 1 ) {
					if($Test[$k][6] != "NULL"){
						$Insert_BalanceSheet['minority_interest']            = strip_tags( $Test[$k][6] );
					} else {
						$Insert_BalanceSheet['minority_interest'] = NULL;
					}
				}
				$Insert_BalanceSheet['FY']                     = trim(ereg_replace("[^0-9]", " ", $Test[$k][1]));
				$respBS = $balancesheet_new->update($Insert_BalanceSheet);
				if( !$respBS ) {
					$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
					$logs->logWrite( "Add BS - FY" . $Insert_BalanceSheet['FY'] . " data insert error", true );
				} else {
					$logs->logWrite( "Add BS - FY" . $Insert_BalanceSheet['FY'] . " data inserted" );	
				}
				unset($Insert_BalanceSheet);
			}//If Ends
			$logs->logWrite( "Add BS - Loop ends" );               
		}
		$logs->logWrite( "Add BS ends" );
		$logs->logWrite( "Regen Excel for BS Started" );
		if( $excel_type == 'S' ) {
			$this->generateBSexcelStandalone( $companyID, $ResultType, $companyName, $run_id, $processedCin, $logFileName, $cin );
		} else {
			$this->generateBSexcelConsolidated( $companyID, $ResultType, $companyName, $run_id, $processedCin, $logFileName, $cin );
		}
		$logs->logWrite( "Regen Excel for BS Ended" );
		return true; 
	}
	/*
	* Growth percentage calculated
	*/
	public function growthpercentageadd( $cprofile_id = '', $IndustryId_FK = '', $ResultType = '', $run_id = '', $processedCin = '', $logFileName = '', $cin = '' ) {
		global $logs;
		global $xbrl;
		$pl_details = mysql_query("SELECT * FROM plstandard WHERE CId_FK='$cprofile_id' AND ResultType = " . $ResultType . " order by FY desc" );
        $pl_check_count = mysql_num_rows($pl_details);
        $logs->logWrite( "Add financial - CAGR function call entered" );
        if($pl_check_count > 0){
        	$logs->logWrite( "Add financial - Previous plstd check count satisfied" );
            $FYCount = $pl_check_count;
            $GFYCount = $pl_check_count - 1;
            mysql_query("UPDATE  `cprofile` SET FYCount='$FYCount',GFYCount='$GFYCount'  WHERE Company_Id='$cprofile_id'" );   
            $plDetails = array();
            while($pl_detail = mysql_fetch_array($pl_details)){
                $plDetails[] = $pl_detail;
            }
            $logs->logWrite( "Add financial - CAGR loop starts" );
            for($i=0;$i<$pl_check_count-1;$i++){ //echo $plDetails[$i]['FY'];
                $FY  = ereg_replace("[^0-9]", "", $plDetails[$i]['FY']);
                $Year = $i+1;
                $Added_Date = date("Y-m-d:H:i:s");
                //$ResultType = $plDetails[$i]['ResultType'];

                //Find growth percentage
                if(($plDetails[$i]['OptnlIncome'] != "NULL") && ($plDetails[$i+1]['OptnlIncome'] != "NULL")){
                    $growth_OptnlIncome = ($plDetails[$i]['OptnlIncome'] - $plDetails[$i+1]['OptnlIncome']) / ($plDetails[$i+1]['OptnlIncome'] )*100;  
                }else{
                    $growth_OptnlIncome = NULL;
                }
                if(($plDetails[$i]['OtherIncome'] != "NULL") && ($plDetails[$i+1]['OtherIncome'] != "NULL")){
                    $growth_OtherIncome = ($plDetails[$i]['OtherIncome'] - $plDetails[$i+1]['OtherIncome']) / (abs($plDetails[$i+1]['OtherIncome'] ))*100; 
                }else{
                    $growth_OtherIncome = NULL;
                }
                if(($plDetails[$i]['TotalIncome'] != "NULL") && ($plDetails[$i+1]['TotalIncome'] != "NULL")){
                    $growth_TotalIncome = ($plDetails[$i]['TotalIncome'] - $plDetails[$i+1]['TotalIncome']) / (abs($plDetails[$i+1]['TotalIncome'] ))*100; 
                }else{
                    $growth_TotalIncome = NULL;
                }
                if(($plDetails[$i]['OptnlAdminandOthrExp'] != "NULL") && ($plDetails[$i+1]['OptnlAdminandOthrExp'] != "NULL")){ 
                    $growth_OptnlAdminandOthrExp = ($plDetails[$i]['OptnlAdminandOthrExp'] - $plDetails[$i+1]['OptnlAdminandOthrExp']) / (abs($plDetails[$i+1]['OptnlAdminandOthrExp'] ))*100; 
                }else{
                    $growth_OptnlAdminandOthrExp = NULL;
                } 
                if(($plDetails[$i]['OptnlProfit'] != "NULL") && ($plDetails[$i+1]['OptnlProfit'] != "NULL")){
                    $growth_OptnlProfit = ($plDetails[$i]['OptnlProfit'] - $plDetails[$i+1]['OptnlProfit']) / (abs($plDetails[$i+1]['OptnlProfit'] ))*100;  
                }else{
                    $growth_OptnlProfit = NULL;
                }
                if(($plDetails[$i]['EBITDA'] != "NULL") && ($plDetails[$i+1]['EBITDA'] != "NULL")){
                    $growth_EBITDA = ($plDetails[$i]['EBITDA'] - $plDetails[$i+1]['EBITDA']) / (abs($plDetails[$i+1]['EBITDA'] ))*100;  
                }else{
                    $growth_EBITDA = NULL;
                } 
                if(($plDetails[$i]['Interest'] != "NULL") && ($plDetails[$i+1]['Interest'] != "NULL")){
                    $growth_Interest = ($plDetails[$i]['Interest'] - $plDetails[$i+1]['Interest']) / (abs($plDetails[$i+1]['Interest'] ))*100;  
                }else{
                    $growth_Interest = NULL;
                }
                if(($plDetails[$i]['EBDT'] != "NULL") && ($plDetails[$i+1]['EBDT'] != "NULL")){ 
                    $growth_EBDT = ($plDetails[$i]['EBDT'] - $plDetails[$i+1]['EBDT']) / (abs($plDetails[$i+1]['EBDT'] ))*100;  
                }else{
                    $growth_EBDT = NULL;
                } 
                if(($plDetails[$i]['Depreciation'] != "NULL") && ($plDetails[$i+1]['Depreciation'] != "NULL")){
                    $growth_Depreciation = ($plDetails[$i]['Depreciation'] - $plDetails[$i+1]['Depreciation']) / (abs($plDetails[$i+1]['Depreciation'] ))*100; 
                }else{
                    $growth_Depreciation = NULL;
                }
                if(($plDetails[$i]['EBT'] != "NULL") && ($plDetails[$i+1]['EBT'] != "NULL")){  
                    $growth_EBT = ($plDetails[$i]['EBT'] - $plDetails[$i+1]['EBT']) / (abs($plDetails[$i+1]['EBT'] ))*100;
                }else{
                    $growth_EBT = NULL;
                }
                if(($plDetails[$i]['Tax'] != "NULL") && ($plDetails[$i+1]['Tax'] != "NULL")){   
                    $growth_Tax = ($plDetails[$i]['Tax'] - $plDetails[$i+1]['Tax']) / (abs($plDetails[$i+1]['Tax'] ))*100; 
                }else{
                    $growth_Tax = NULL;
                }
                if(($plDetails[$i]['PAT'] != "NULL") && ($plDetails[$i+1]['PAT'] != "NULL")){  
                    $growth_PAT = ($plDetails[$i]['PAT'] - $plDetails[$i+1]['PAT']) / (abs($plDetails[$i+1]['PAT'] ))*100; 
                }else{
                    $growth_PAT = NULL;
                }
                if(($plDetails[$i]['BINR'] != "NULL") && ($plDetails[$i+1]['BINR'] != "NULL")){  
                    $growth_BINR = ($plDetails[$i]['BINR'] - $plDetails[$i+1]['BINR']) / (abs($plDetails[$i+1]['BINR'] ))*100; 
                }else{
                    $growth_BINR = NULL;
                }  
                if(($plDetails[$i]['DINR'] != "NULL") && ($plDetails[$i+1]['DINR'] != "NULL")){
                    $growth_DINR = ($plDetails[$i]['DINR'] - $plDetails[$i+1]['DINR']) / (abs($plDetails[$i+1]['DINR'] ))*100; 
                }else{
                    $growth_DINR = NULL;
                }
                $growth_details = mysql_query("SELECT GrowthPerc_Id FROM growthpercentage WHERE CId_FK='$cprofile_id' and FY='$FY' and ResultType='$ResultType' order by FY desc" );
                if( mysql_errno() ) {
                	$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
					$logs->logWrite( "GP-CAGR - GP select query error", true );
                }
                $growth_check_count = mysql_num_rows($growth_details);
                if($growth_check_count > 0){
                    $growth_detail = mysql_fetch_array($growth_details);
                    $GrowthPerc_Id = $growth_detail['GrowthPerc_Id'];
                    $updQuery = "UPDATE growthpercentage set 
                                    OptnlIncome='$growth_OptnlIncome', OtherIncome='$growth_OtherIncome', TotalIncome='$growth_TotalIncome', OptnlAdminandOthrExp='$growth_OptnlAdminandOthrExp', OptnlProfit='$growth_OptnlProfit', EBITDA='$growth_EBITDA', Interest='$growth_Interest', EBDT='$growth_EBDT',
                                    Depreciation='$growth_Depreciation', EBT='$growth_EBT', Tax='$growth_Tax', PAT='$growth_PAT', BINR='$growth_BINR', DINR='$growth_DINR', FY='$FY', GrowthYear='$Year', Updated_date='$Added_Date', IndustryId_FK='$IndustryId_FK', ResultType='$ResultType' 
                                WHERE GrowthPerc_Id='$GrowthPerc_Id'
                                ";
                    mysql_query( $updQuery ) or die( $updQuery );
                    if( mysql_errno() ) {
                    	$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
						$logs->logWrite( "GP-CAGR - FY" . $FY . " GP update error", true );
                    } else {
                    	$logs->logWrite( "Add financial - Growth percentage for FY" . $FY . " updated" );
                    } 
                }else{
                    $insQuery = "INSERT INTO growthpercentage 
                                ( OptnlIncome, OtherIncome, TotalIncome, OptnlAdminandOthrExp, OptnlProfit, EBITDA, Interest, EBDT, Depreciation, EBT, Tax, PAT, BINR, DINR, FY, GrowthYear, Added_Date, IndustryId_FK, ResultType, CId_FK ) 
                                VALUES('$growth_OptnlIncome', '$growth_OtherIncome', '$growth_TotalIncome', '$growth_OptnlAdminandOthrExp', '$growth_OptnlProfit', '$growth_EBITDA', '$growth_Interest', '$growth_EBDT', '$growth_Depreciation', '$growth_EBT', '$growth_Tax', '$growth_PAT', '$growth_BINR', '$growth_DINR', '$FY', '$Year', '$Added_Date', '$IndustryId_FK', '$ResultType', '$cprofile_id' )
                                ";
                    mysql_query( $insQuery ) or die( $insQuery );
                    if( mysql_errno() ) {
                    	$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
						$logs->logWrite( "GP-CAGR - FY" . $FY . " GP insert error", true );
                    } else {
                    	$logs->logWrite( "Add financial - Growth percentage for FY" . $FY . " inserted" );
                    }
                } 

                ///////////////////////////////////////////////////////

                //Find CAGR
                if(($plDetails[0]['OptnlIncome'] != "NULL") && ($plDetails[$i+1]['OptnlIncome'] != "NULL") && ($plDetails[0]['OptnlIncome'] > 0) && ($plDetails[$i+1]['OptnlIncome'] > 0)){
                    $cagr_OptnlIncome = (pow(($plDetails[0]['OptnlIncome'] / $plDetails[$i+1]['OptnlIncome']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_OptnlIncome = NULL;
                }
                if(($plDetails[0]['OtherIncome'] != "NULL") && ($plDetails[$i+1]['OtherIncome'] != "NULL") && ($plDetails[0]['OtherIncome'] > 0) && ($plDetails[$i+1]['OtherIncome'] > 0)){
                    $cagr_OtherIncome = (pow(($plDetails[0]['OtherIncome'] / $plDetails[$i+1]['OtherIncome']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_OtherIncome = NULL;
                }
                if(($plDetails[0]['TotalIncome'] != "NULL") && ($plDetails[$i+1]['TotalIncome'] != "NULL") && ($plDetails[0]['TotalIncome'] > 0) && ($plDetails[$i+1]['TotalIncome'] > 0)){
                    $cagr_TotalIncome = (pow(($plDetails[0]['TotalIncome'] / $plDetails[$i+1]['TotalIncome']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_TotalIncome = NULL;
                }
                if(($plDetails[0]['OptnlAdminandOthrExp'] != "NULL") && ($plDetails[$i+1]['OptnlAdminandOthrExp'] != "NULL") && ($plDetails[0]['OptnlAdminandOthrExp'] > 0) && ($plDetails[$i+1]['OptnlAdminandOthrExp'] > 0)){ 
                    $cagr_OptnlAdminandOthrExp = (pow(($plDetails[0]['OptnlAdminandOthrExp'] / $plDetails[$i+1]['OptnlAdminandOthrExp']), (1/($i+1)))-1)*100; 
                }else{
                    $cagr_OptnlAdminandOthrExp = NULL;
                } 
                if(($plDetails[0]['OptnlProfit'] != "NULL") && ($plDetails[$i+1]['OptnlProfit'] != "NULL") && ($plDetails[0]['OptnlProfit'] > 0) && ($plDetails[$i+1]['OptnlProfit'] > 0)){
                    $cagr_OptnlProfit = (pow(($plDetails[0]['OptnlProfit'] / $plDetails[$i+1]['OptnlProfit']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_OptnlProfit = NULL;
                }
                if(($plDetails[0]['EBITDA'] != "NULL") && ($plDetails[$i+1]['EBITDA'] != "NULL") && ($plDetails[0]['EBITDA'] > 0) && ($plDetails[$i+1]['EBITDA'] > 0)){
                    $cagr_EBITDA = (pow(($plDetails[0]['EBITDA'] / $plDetails[$i+1]['EBITDA']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_EBITDA = NULL;
                } 
                if(($plDetails[0]['Interest'] != "NULL") && ($plDetails[$i+1]['Interest'] != "NULL") && ($plDetails[0]['Interest'] > 0) && ($plDetails[$i+1]['Interest'] > 0)){
                    $cagr_Interest = (pow(($plDetails[0]['Interest'] / $plDetails[$i+1]['Interest']), (1/($i+1)))-1)*100;  
                }else{
                    $cagr_Interest = NULL;
                }
                if(($plDetails[0]['EBDT'] != "NULL") && ($plDetails[$i+1]['EBDT'] != "NULL") && ($plDetails[0]['EBDT'] > 0) && ($plDetails[$i+1]['EBDT'] > 0)){ 
                    $cagr_EBDT = (pow(($plDetails[0]['EBDT'] / $plDetails[$i+1]['EBDT']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_EBDT = NULL;
                } 
                if(($plDetails[0]['Depreciation'] != "NULL") && ($plDetails[$i+1]['Depreciation'] != "NULL") && ($plDetails[0]['Depreciation'] > 0) && ($plDetails[$i+1]['Depreciation'] > 0)){
                    $cagr_Depreciation = (pow(($plDetails[0]['Depreciation'] / $plDetails[$i+1]['Depreciation']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_Depreciation = NULL;
                }
                if(($plDetails[0]['EBT'] != "NULL") && ($plDetails[$i+1]['EBT'] != "NULL") && ($plDetails[0]['EBT'] > 0) && ($plDetails[$i+1]['EBT'] > 0)){  
                    $cagr_EBT = (pow(($plDetails[0]['EBT'] / $plDetails[$i+1]['EBT']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_EBT = NULL;
                }
                if(($plDetails[0]['Tax'] != "NULL") && ($plDetails[$i+1]['Tax'] != "NULL") && ($plDetails[0]['Tax'] > 0) && ($plDetails[$i+1]['Tax'] > 0)){   
                    $cagr_Tax = (pow(($plDetails[0]['Tax'] / $plDetails[$i+1]['Tax']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_Tax = NULL;
                }
                if(($plDetails[0]['PAT'] != "NULL") && ($plDetails[$i+1]['PAT'] != "NULL") && ($plDetails[0]['PAT'] > 0) && ($plDetails[$i+1]['PAT'] > 0)){  
                    $cagr_PAT = (pow(($plDetails[0]['PAT'] / $plDetails[$i+1]['PAT']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_PAT = NULL;
                }
                if(($plDetails[0]['BINR'] != "NULL") && ($plDetails[$i+1]['BINR'] != "NULL") && ($plDetails[0]['BINR'] > 0) && ($plDetails[$i+1]['BINR'] > 0)){  
                    $cagr_BINR = (pow(($plDetails[0]['BINR'] / $plDetails[$i+1]['BINR']), (1/($i+1)))-1)*100;
                }else{
                    $cagr_BINR = NULL;
                }  
                if(($plDetails[0]['DINR'] != "NULL") && ($plDetails[$i+1]['DINR'] != "NULL") && ($plDetails[0]['DINR'] > 0) && ($plDetails[$i+1]['DINR'] > 0)){
                    $cagr_DINR = (pow(($plDetails[0]['DINR'] / $plDetails[$i+1]['DINR']), (1/($i+1)))-1)*100; 
                }else{
                    $cagr_DINR = NULL;
                }

                $cagr_details = mysql_query("SELECT CAGR_Id FROM cagr WHERE CId_FK='$cprofile_id' and FY='$FY' and ResultType='$ResultType' order by FY desc" );
                if( mysql_errno() ) {
                	$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
					$logs->logWrite( "GP-CAGR - CAGR select query error", true );
                }
                $cagr_check_count = mysql_num_rows($cagr_details);
                if($cagr_check_count > 0){
                    $cagr_detail = mysql_fetch_array($cagr_details);
                    $CAGR_Id = $cagr_detail['CAGR_Id'];
                    $cagrUpd = "UPDATE cagr set 
                                OptnlIncome='$cagr_OptnlIncome', OtherIncome='$cagr_OtherIncome', TotalIncome='$cagr_TotalIncome', OptnlAdminandOthrExp='$cagr_OptnlAdminandOthrExp', OptnlProfit='$cagr_OptnlProfit', EBITDA='$cagr_EBITDA', Interest='$cagr_Interest', EBDT='$cagr_EBDT', Depreciation='$cagr_Depreciation', EBT='$cagr_EBT', Tax='$cagr_Tax', PAT='$cagr_PAT', BINR='$cagr_BINR', DINR='$cagr_DINR', FY='$FY', CAGRYear='$Year', Updated_date='$Added_Date', IndustryId_FK='$IndustryId_FK', ResultType='$ResultType'
                                WHERE CAGR_Id='$CAGR_Id'";
                    mysql_query( $cagrUpd ) or die( $cagrUpd );
                    if( mysql_errno() ) {
	                	$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
						$logs->logWrite( "GP-CAGR - CAGR update error", true );
	                } else {
	                	$logs->logWrite( "Add financial - CAGR for FY" . $FY . " updated" );	
	                }
                }else{
                    $cagrIns = "INSERT INTO cagr
                                ( OptnlIncome, OtherIncome, TotalIncome, OptnlAdminandOthrExp, OptnlProfit, EBITDA, Interest, EBDT, Depreciation, EBT, Tax, PAT, BINR, DINR, FY, CAGRYear, Added_Date, IndustryId_FK, ResultType, CId_FK )
                                VALUES( '$cagr_OptnlIncome', '$cagr_OtherIncome', '$cagr_TotalIncome', '$cagr_OptnlAdminandOthrExp', '$cagr_OptnlProfit', '$cagr_EBITDA', '$cagr_Interest', '$cagr_EBDT', '$cagr_Depreciation', '$cagr_EBT', '$cagr_Tax', '$cagr_PAT', '$cagr_BINR', '$cagr_DINR', '$FY', '$Year', '$Added_Date', '$IndustryId_FK', '$ResultType', '$cprofile_id' )
                                ";
                    mysql_query( $cagrIns ) or die( $cagrIns );
                    if( mysql_errno() ) {
	                	$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
						$logs->logWrite( "GP-CAGR - CAGR insert error", true );
	                } else {
	                	$logs->logWrite( "Add financial - CAGR for FY" . $FY . " inserted" );	
	                }
                }
            }
            $logs->logWrite( "Add financial - CAGR loop ends" );
        }
        $logs->logWrite( "Add financial - CAGR function call exit and return" );
        return true;
	}

	/*
	* PL Standalone Excel Re-Generate
	*/
	function generateStandalonePLexcel( $companyID = '', $ResultType = '', $companyName = '', $run_id, $processedCin, $logFileName, $cin ) {
		global $Excelgenerate;
		global $logs;
		$pl_details = mysql_query("SELECT * FROM plstandard WHERE CId_FK='$companyID' AND ResultType = " . $ResultType . " order by FY desc" );
        $pl_check_count = mysql_num_rows($pl_details);
        // Excel column styles are defined.
		$companyStyle = array( 
	        'font'  => array( 'bold' => true ) 
	    );
	    $boldStyle = array( 
	        'font'  => array( 'bold' => true ),
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        ) 
	    );
	    $boldWFill = array( 
	        'fill' => array( 'fillType' => Fill::FILL_SOLID, 'color' => array('rgb' => 'AAAAAA' ) ),
	        'font'  => array( 'bold'  =>  true ),
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        )
	    );
	    $defaultStyle = array( 
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        ) 
	    );
        $excelIndex = $Excelgenerate->createColumnsArray( 'BZ' );
        $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $companyName)->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR Rs.');
	    $sheet->setCellValue('A6', 'Particulars')->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', 'Operational Income')->getStyle("A7")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A8', 'Other Income')->getStyle("A8")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A9', 'Total Income')->getStyle("A9")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A10', 'Operational, Admin & Other Expenses')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', 'Operating Profit')->getStyle("A11")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A12', 'EBITDA')->getStyle("A12")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A13', 'Interest')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'EBDT')->getStyle("A14")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A15', 'Depreciation')->getStyle("A15")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A16', 'EBT before Exceptional Items')->getStyle("A16")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A17', 'Prior period/Exceptional /Extra Ordinary Items')->getStyle("A17")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A18', 'EBT')->getStyle("A18")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A19', 'Tax')->getStyle("A19")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A20', 'PAT')->getStyle("A20")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A21', 'EPS ')->getStyle("A21")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A22', '(Basic in INR)')->getStyle("A22")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A23', '(Diluted in INR)')->getStyle("A23")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A25', 'Employee Related Expenses')->getStyle("A25")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A26', 'Foreign Exchange Earning and Outgo:')->getStyle("A26")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A27', 'Earning in Foreign Exchange')->getStyle("A27")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A28', 'Outgo in Foreign Exchange')->getStyle("A28")->applyFromArray( $defaultStyle );
	    $sheet->getColumnDimension('A')->setWidth(50);
	    $i = 0;
	    $index = 1;
	    if( $pl_check_count > 0 ) {
        	while( $plDetails = mysql_fetch_array( $pl_details ) ) {
        		if($plDetails[ 'FY' ] != ""){
	        		$sheet->setCellValue( $excelIndex[ $index ] . '6', 'FY'.$plDetails[ 'FY' ])->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '7', $plDetails[ 'OptnlIncome' ] )->getStyle( $excelIndex[ $index ] . '7' )->applyFromArray( $defaultStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '8', $plDetails[ 'OtherIncome' ] )->getStyle( $excelIndex[ $index ] . '8' )->applyFromArray( $defaultStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '9', $plDetails[ 'TotalIncome' ] )->getStyle( $excelIndex[ $index ] . '9' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '10', $plDetails[ 'OptnlAdminandOthrExp' ] )->getStyle( $excelIndex[ $index ] . '10' )->applyFromArray( $defaultStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '11', $plDetails[ 'OptnlProfit' ] )->getStyle( $excelIndex[ $index ] . '11' )->applyFromArray( $defaultStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '12', $plDetails[ 'EBITDA' ] )->getStyle( $excelIndex[ $index ] . '12' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '13', $plDetails[ 'Interest' ] )->getStyle( $excelIndex[ $index ] . '13' )->applyFromArray( $defaultStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '14', $plDetails[ 'EBDT' ] )->getStyle( $excelIndex[ $index ] . '14' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '15', $plDetails[ 'Depreciation' ] )->getStyle( $excelIndex[ $index ] . '15' )->applyFromArray( $defaultStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '16', $plDetails[ 'EBT_before_Priod_period' ] )->getStyle( $excelIndex[ $index ] . '16' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '17', $plDetails[ 'Priod_period' ] )->getStyle( $excelIndex[ $index ] . '17' )->applyFromArray( $defaultStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '18', $plDetails[ 'EBT' ] )->getStyle( $excelIndex[ $index ] . '18' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '19', $plDetails[ 'Tax' ] )->getStyle( $excelIndex[ $index ] . '19' )->applyFromArray( $defaultStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '20', $plDetails[ 'PAT' ] )->getStyle( $excelIndex[ $index ] . '20' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '21', '' )->getStyle( $excelIndex[ $index ] . '21' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '22', $plDetails[ 'BINR' ] )->getStyle( $excelIndex[ $index ] . '22' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '23', $plDetails[ 'DINR' ] )->getStyle( $excelIndex[ $index ] . '23' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '25', $plDetails[ 'EmployeeRelatedExpenses' ] )->getStyle( $excelIndex[ $index ] . '25' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '26', '')->getStyle( $excelIndex[ $index ] . '26' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '27', $plDetails[ 'EarninginForeignExchange' ] )->getStyle( $excelIndex[ $index ] . '27' )->applyFromArray( $boldStyle );
			    	$sheet->setCellValue( $excelIndex[ $index ] . '28', $plDetails[ 'OutgoinForeignExchange' ] )->getStyle( $excelIndex[ $index ] . '28' )->applyFromArray( $boldStyle );
			    	$sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
			    	$i++;
			    	$index++;
		    	}
        	}
        }
        try {
	        $writer = new Xlsx( $spreadsheet );
	        try {
	        	$UploadedNewFilePath = "../../cfs-old/media/plstandard/PLStandard_".$companyID."_NEW.xls";
				$UploadedOldFilePath = "../../cfs-old/media/plstandard/PLStandard_".$companyID."_OLD.xls";
				if( file_exists( $UploadedNewFilePath ) ) {
					unlink( $UploadedNewFilePath );
				}
				if( file_exists( $UploadedOldFilePath ) ) {
					unlink( $UploadedOldFilePath );	
				}
				$DeleteHeaderImagePath = '';
				$PLStandard  = "plstandard";
				$Dir = FOLDER_CREATE_PATH.$PLStandard;
				try {
					if( !is_dir( $Dir ) ){
						mkdir($Dir,0777);chmod($Dir, 0777);
					}
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
				$imageFileName = "PLStandard_".$companyID.".xls";
				$Target_Path = $Dir.'/';
				$strOriginalPath = $Target_Path.$imageFileName;
				// uploadCommon.php code
	        	if( !file_exists( dirname(__FILE__).'/output1/' . $companyName ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output1/' . $companyName ) ) {
			        		$old = umask(0);
							chmod( dirname(__FILE__).'/output1/' . $companyName, 0777 );
							umask($old);
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in addcfinancials server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				$csvFile = dirname(__FILE__).'/output1/' . $companyName . '/' . $companyName . '_PL_STANDALONE.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
	            	$old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);	
	            } catch( Exception $e ) {
	            	//echo $e->getMessage();
	            }
	            $UploadedSourceFile = MAIN_PATH.'/admin/xbrl/output1/' . $companyName . '/' . $companyName . '_PL_STANDALONE.xlsx';
	            // DELETE FILE IF EXISTING
				if(file_exists($DeleteHeaderImagePath)) { 
					try {
						@chmod($DeleteHeaderImagePath, 0777); 
						unlink($DeleteHeaderImagePath); 
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				try {
					unlink($strOriginalPath);
					if( copy( $UploadedSourceFile, $strOriginalPath ) ) {
						$old = umask(0);
						chmod( $strOriginalPath, 777, true );
						umask($old);
						unlink( $csvFile );
					} else {
						$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
				        $logs->logWrite( "Add financial - File copy error in pl standard", true );
					}
				} catch( Exception $e ) {
					//echo $e->getMessage();
				}
	            
	            $logs->logWrite( "PL Standalone Excel Created and moved to cfs-old folder in addcfinancials" );    
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "PL Standalone Excel write failed in addcfinancials";
	            //echo $e->getMessage(); 
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Spreadsheet Plugin problem in addcfinancials";
	        //echo $e->getMessage(); 
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}

	/*
	* PL Consolidated Excel Re-Generate
	*/
	function generateConsolidatedPLexcel( $companyID = '', $ResultType = '', $companyName = '', $run_id, $processedCin, $logFileName, $cin ) {
		global $Excelgenerate;
		global $logs;
		$pl_details = mysql_query("SELECT * FROM plstandard WHERE CId_FK='$companyID' AND ResultType = " . $ResultType . " order by FY desc" );
        $pl_check_count = mysql_num_rows($pl_details);
        // Excel column styles are defined.
		$companyStyle = array( 
	        'font'  => array( 'bold' => true ) 
	    );
	    $boldStyle = array( 
	        'font'  => array( 'bold' => true ),
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        ) 
	    );
	    $boldWFill = array( 
	        'fill' => array( 'fillType' => Fill::FILL_SOLID, 'color' => array('rgb' => 'AAAAAA' ) ),
	        'font'  => array( 'bold'  =>  true ),
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        )
	    );
	    $defaultStyle = array( 
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        ) 
	    );
        $excelIndex = $Excelgenerate->createColumnsArray( 'BZ' );
        $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $companyName)->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR Rs.');
	    $sheet->setCellValue('A6', 'Particulars')->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', 'Operational Income')->getStyle("A7")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A8', 'Other Income')->getStyle("A8")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A9', 'Total Income')->getStyle("A9")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A10', 'Operational, Admin & Other Expenses')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', 'Operating Profit')->getStyle("A11")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A12', 'EBITDA')->getStyle("A12")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A13', 'Interest')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'EBDT')->getStyle("A14")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A15', 'Depreciation')->getStyle("A15")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A16', 'EBT before Exceptional Items')->getStyle("A16")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A17', 'Prior period/Exceptional /Extra Ordinary Items')->getStyle("A17")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A18', 'EBT')->getStyle("A18")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A19', 'Tax')->getStyle("A19")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A20', 'PAT')->getStyle("A20")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A21', 'Profit (loss) of minority interest')->getStyle("A21")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A22', 'Total profit (loss) for period')->getStyle("A22")->applyFromArray( $boldStyle );    
	    $sheet->setCellValue('A23', 'EPS ')->getStyle("A23")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A24', '(Basic in INR)')->getStyle("A24")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A25', '(Diluted in INR)')->getStyle("A25")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A27', 'Employee Related Expenses')->getStyle("A27")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A28', 'Foreign Exchange Earning and Outgo:')->getStyle("A28")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A29', 'Earning in Foreign Exchange')->getStyle("A29")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A30', 'Outgo in Foreign Exchange')->getStyle("A30")->applyFromArray( $defaultStyle );
	    $sheet->getColumnDimension('A')->setWidth(50);
	    $i = 0;
	    $index = 1;
	    if( $pl_check_count > 0 ) {
        	while( $plDetails = mysql_fetch_array( $pl_details ) ) {
        		$sheet->setCellValue( $excelIndex[ $index ] . '6', 'FY'.$plDetails[ 'FY' ] )->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '7', $plDetails[ 'OptnlIncome' ] )->getStyle( $excelIndex[ $index ] . '7' )->applyFromArray( $defaultStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '8', $plDetails[ 'OtherIncome' ] )->getStyle( $excelIndex[ $index ] . '8' )->applyFromArray( $defaultStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '9', $plDetails[ 'TotalIncome' ] )->getStyle( $excelIndex[ $index ] . '9' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '10', $plDetails[ 'OptnlAdminandOthrExp' ] )->getStyle( $excelIndex[ $index ] . '10' )->applyFromArray( $defaultStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '11', $plDetails[ 'OptnlProfit' ] )->getStyle( $excelIndex[ $index ] . '11' )->applyFromArray( $defaultStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '12', $plDetails[ 'EBITDA' ] )->getStyle( $excelIndex[ $index ] . '12' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '13', $plDetails[ 'Interest' ] )->getStyle( $excelIndex[ $index ] . '13' )->applyFromArray( $defaultStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '14', $plDetails[ 'EBDT' ] )->getStyle( $excelIndex[ $index ] . '14' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '15', $plDetails[ 'Depreciation' ] )->getStyle( $excelIndex[ $index ] . '15' )->applyFromArray( $defaultStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '16', $plDetails[ 'EBT_before_Priod_period' ] )->getStyle( $excelIndex[ $index ] . '16' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '17', $plDetails[ 'Priod_period' ] )->getStyle( $excelIndex[ $index ] . '17' )->applyFromArray( $defaultStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '18', $plDetails[ 'EBT' ] )->getStyle( $excelIndex[ $index ] . '18' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '19', $plDetails[ 'Tax' ] )->getStyle( $excelIndex[ $index ] . '19' )->applyFromArray( $defaultStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '20', $plDetails[ 'PAT' ] )->getStyle( $excelIndex[ $index ] . '20' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '21', $plDetails[ 'profit_loss_of_minority_interest' ] )->getStyle( $excelIndex[ $index ] . '21' )->applyFromArray( $defaultStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '22', $plDetails[ 'total_profit_loss_for_period' ] )->getStyle( $excelIndex[ $index ] . '22' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '23', '' )->getStyle( $excelIndex[ $index ] . '23' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '24', $plDetails[ 'BINR' ] )->getStyle( $excelIndex[ $index ] . '24' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '25', $plDetails[ 'DINR' ] )->getStyle( $excelIndex[ $index ] . '25' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '26', '' )->getStyle( $excelIndex[ $index ] . '25' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '27', $plDetails[ 'EmployeeRelatedExpenses' ] )->getStyle( $excelIndex[ $index ] . '27' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '28', '')->getStyle( $excelIndex[ $index ] . '28' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '29', $plDetails[ 'EarninginForeignExchange	' ] )->getStyle( $excelIndex[ $index ] . '29' )->applyFromArray( $boldStyle );
		    	$sheet->setCellValue( $excelIndex[ $index ] . '30', $plDetails[ 'OutgoinForeignExchange' ] )->getStyle( $excelIndex[ $index ] . '30' )->applyFromArray( $boldStyle );
		    	$sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
		    	$i++;
		    	$index++;
        	}
        }

        try {
	        $writer = new Xlsx( $spreadsheet );
	        try {
	        	$UploadedNewFilePath = "../../cfs-old/media/plstandard/PLStandard_".$companyID."_NEW_1.xls";
				$UploadedOldFilePath = "../../cfs-old/media/plstandard/PLStandard_".$companyID."_OLD_1.xls";
				if( file_exists( $UploadedNewFilePath ) ) {
					unlink( $UploadedNewFilePath );
				}
				if( file_exists( $UploadedOldFilePath ) ) {
					unlink( $UploadedOldFilePath );	
				}
				$DeleteHeaderImagePath = '';
				$PLStandard  = "plstandard";
				$Dir = FOLDER_CREATE_PATH.$PLStandard;
				try {
					if( !is_dir( $Dir ) ){
						mkdir($Dir,0777);chmod($Dir, 0777);
					}
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
				$imageFileName = "PLStandard_".$companyID."_1.xls";
				$Target_Path = $Dir.'/';
				$strOriginalPath = $Target_Path.$imageFileName;
				// uploadCommon.php code
	        	if( !file_exists( dirname(__FILE__).'/output1/' . $companyName ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output1/' . $companyName ) ) {
			        		$old = umask(0);
							chmod( dirname(__FILE__).'/output1/' . $companyName, 0777 );
							umask($old);
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in addcfinancials server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				$csvFile = dirname(__FILE__).'/output1/' . $companyName . '/' . $companyName . '_PL_CONSOLIDATED.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
	            	$old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);	
	            } catch( Exception $e ) {
	            	//echo $e->getMessage();
	            }
	            $UploadedSourceFile = MAIN_PATH.'/admin/xbrl/output1/' . $companyName . '/' . $companyName . '_PL_CONSOLIDATED.xlsx';
	            // DELETE FILE IF EXISTING
				if(file_exists($DeleteHeaderImagePath)) { 
					try {
						@chmod($DeleteHeaderImagePath, 0777); 
						unlink($DeleteHeaderImagePath); 
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				try {
					unlink($strOriginalPath);
					if( copy( $UploadedSourceFile, $strOriginalPath ) ) {
						$old = umask(0);
						chmod( $strOriginalPath, 777, true );
						umask($old);
						unlink( $csvFile );
					} else {
						$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
				        $logs->logWrite( "Add financial - File copy error in pl standard", true );
					}
				} catch( Exception $e ) {
					//echo $e->getMessage();
				}
	            
	            $logs->logWrite( "PL Consolidated Excel Created and moved to cfs-old folder in addcfinancials" );    
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "PL Consolidated Excel write failed in addcfinancials";
	            //echo $e->getMessage(); 
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Spreadsheet Plugin problem in addcfinancials";
	        //echo $e->getMessage(); 
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}

	/*
	* BS Standalone Excel Re-Generate
	*/
	function generateBSexcelStandalone( $companyID = '', $ResultType = '', $companyName = '', $run_id, $processedCin, $logFileName, $cin ) {
		global $Excelgenerate;
		global $logs;

		$pl_details = mysql_query("SELECT * FROM balancesheet_new WHERE CID_FK='$companyID' AND ResultType = " . $ResultType . " order by FY desc" );
        $pl_check_count = mysql_num_rows($pl_details);

		// Excel column styles are defined.
		$companyStyle = array( 
	        'font'  => array( 'bold' => true ) 
	    );
	    $boldStyle = array( 
	        'font'  => array( 'bold' => true ),
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        ) 
	    );
	    $boldWFill = array( 
	        'fill' => array( 'fillType' => Fill::FILL_SOLID, 'color' => array('rgb' => 'AAAAAA' ) ),
	        'font'  => array( 'bold'  =>  true ),
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        )
	    );
	    $defaultStyle = array( 
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        ) 
	    );
	    $excelIndex = $Excelgenerate->createColumnsArray( 'BZ' );
	    $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.    ')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $companyName )->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR Rs.');
	    $sheet->setCellValue('A6', "Shareholders funds [Abstract]")->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', 'Share capital')->getStyle("A7")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A8', 'Reserves and surplus')->getStyle("A8")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A9', "Total shareholders funds")->getStyle("A9")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A10', 'Share application money pending allotment')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', '')->getStyle("A11")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A12', 'Non-current liabilities [Abstract]')->getStyle("A12")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A13', 'Long-term borrowings')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'Deferred tax liabilities (net)')->getStyle("A14")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A15', 'Other long-term liabilities')->getStyle("A15")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A16', 'Long-term provisions')->getStyle("A16")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A17', 'Total non-current liabilities')->getStyle("A17")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A18', '')->getStyle("A18")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A19', 'Current liabilities [Abstract]')->getStyle("A19")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A20', 'Short-term borrowings')->getStyle("A20")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A21', 'Trade payables')->getStyle("A21")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A22', 'Other current liabilities')->getStyle("A22")->applyFromArray( $defaultStyle );    
	    $sheet->setCellValue('A23', 'Short-term provisions ')->getStyle("A23")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A24', 'Total current liabilities')->getStyle("A24")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A25', 'Total equity and liabilities')->getStyle("A25")->applyFromArray( $boldWFill );
	    $sheet->setCellValue('A26', '')->getStyle("A26")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A27', 'Assets [Abstract]')->getStyle("A27")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A28', '')->getStyle("A28")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A29', 'Non-current assets [Abstract]')->getStyle("A29")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A30', '')->getStyle("A30")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A31', 'Fixed assets [Abstract]')->getStyle("A31")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A32', 'Tangible assets')->getStyle("A32")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A33', 'Intangible assets')->getStyle("A33")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A34', 'Total fixed assets')->getStyle("A34")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A35', 'Non-current investments')->getStyle("A35")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A36', 'Deferred tax assets (net)')->getStyle("A36")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A37', 'Long-term loans and advances')->getStyle("A37")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A38', 'Other non-current assets')->getStyle("A38")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A39', 'Total non-current assets')->getStyle("A39")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A40', '')->getStyle("A40")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A41', 'Current assets [Abstract]')->getStyle("A41")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A42', 'Current investments')->getStyle("A42")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A43', 'Inventories')->getStyle("A43")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A44', 'Trade receivables')->getStyle("A44")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A45', 'Cash and bank balances')->getStyle("A45")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A46', 'Short-term loans and advances')->getStyle("A46")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A47', 'Other current assets')->getStyle("A47")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A48', 'Total current assets')->getStyle("A48")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A49', 'Total assets')->getStyle("A49")->applyFromArray( $boldWFill );
	    $sheet->getColumnDimension('A')->setWidth(50);

	    $i = 0;
	    $index = 1;
	    $logs->logWrite( "Addcfinanicals - BS Standalone Excel loop enter" );
	    if( $pl_check_count > 0 ) {
        	while( $plDetails = mysql_fetch_array( $pl_details ) ) {
		    	$sheet->setCellValue( $excelIndex[ $index ] . '6', 'FY'.$plDetails[ 'FY' ])->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '7', $plDetails[ 'ShareCapital' ] )->getStyle( $excelIndex[ $index ] . "7" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '8', $plDetails[ 'ReservesSurplus' ] )->getStyle( $excelIndex[ $index ] . "8" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '9', $plDetails[ 'TotalFunds' ] )->getStyle( $excelIndex[ $index ] . "9" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '10', $plDetails[ 'ShareApplication' ] )->getStyle( $excelIndex[ $index ] . "10" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '11', '' )->getStyle( $excelIndex[ $index ] . "11" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '12', '' )->getStyle( $excelIndex[ $index ] . "12" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '13', $plDetails[ 'L_term_borrowings' ] )->getStyle( $excelIndex[ $index ] . "13" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '14', $plDetails[ 'deferred_tax_liabilities' ] )->getStyle( $excelIndex[ $index ] . "14" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '15', $plDetails[ 'O_long_term_liabilities' ] )->getStyle( $excelIndex[ $index ] . "15" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '16', $plDetails[ 'L_term_provisions' ] )->getStyle( $excelIndex[ $index ] . "16" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '17', $plDetails[ 'T_non_current_liabilities' ] )->getStyle( $excelIndex[ $index ] . "17" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '18', '')->getStyle($excelIndex[ $index ] . "18")->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '19', '' )->getStyle( $excelIndex[ $index ] . "19" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '20', $plDetails[ 'S_term_borrowings' ] )->getStyle( $excelIndex[ $index ] . "20" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '21', $plDetails[ 'Trade_payables' ] )->getStyle( $excelIndex[ $index ] . "21" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '22', $plDetails[ 'O_current_liabilities' ] )->getStyle( $excelIndex[ $index ] . "22" )->applyFromArray( $defaultStyle );    
			    $sheet->setCellValue( $excelIndex[ $index ] . '23', $plDetails[ 'S_term_provisions' ] )->getStyle( $excelIndex[ $index ] . "23" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '24', $plDetails[ 'T_current_liabilities' ] )->getStyle( $excelIndex[ $index ] . "24" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '25', $plDetails[ 'T_equity_liabilities' ] )->getStyle( $excelIndex[ $index ] . "25" )->applyFromArray( $boldWFill );
			    $sheet->setCellValue( $excelIndex[ $index ] . '26', '')->getStyle( $excelIndex[ $index ] . "26" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '27', '' )->getStyle( $excelIndex[ $index ] . "27" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '28', '')->getStyle( $excelIndex[ $index ] . "28" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '29', '' )->getStyle( $excelIndex[ $index ] . "29" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '30', '')->getStyle( $excelIndex[ $index ] . "30" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '31', '' )->getStyle( $excelIndex[ $index ] . "31" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '32', $plDetails[ 'Tangible_assets' ] )->getStyle( $excelIndex[ $index ] . "32" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '33', $plDetails[ 'Intangible_assets' ] )->getStyle( $excelIndex[ $index ] . "33" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '34', $plDetails[ 'T_fixed_assets' ] )->getStyle( $excelIndex[ $index ] . "34" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '35', $plDetails[ 'N_current_investments' ] )->getStyle( $excelIndex[ $index ] . "35" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '36', $plDetails[ 'Deferred_tax_assets' ] )->getStyle( $excelIndex[ $index ] . "36" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '37', $plDetails[ 'L_term_loans_advances' ] )->getStyle( $excelIndex[ $index ] . "37" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '38', $plDetails[ 'O_non_current_assets' ] )->getStyle( $excelIndex[ $index ] . "38" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '39', $plDetails[ 'T_non_current_assets' ] )->getStyle( $excelIndex[ $index ] . "39" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '40', '')->getStyle( $excelIndex[ $index ] . "40" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '41', '' )->getStyle( $excelIndex[ $index ] . "41" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '42', $plDetails[ 'Current_investments' ] )->getStyle( $excelIndex[ $index ] . "42" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '43', $plDetails[ 'Inventories' ] )->getStyle( $excelIndex[ $index ] . "43" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '44', $plDetails[ 'Trade_receivables' ] )->getStyle( $excelIndex[ $index ] . "44" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '45', $plDetails[ 'Cash_bank_balances' ] )->getStyle( $excelIndex[ $index ] . "45" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '46', $plDetails[ 'S_term_loans_advances' ] )->getStyle( $excelIndex[ $index ] . "46" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '47', $plDetails[ 'O_current_assets' ] )->getStyle( $excelIndex[ $index ] . "47" )->applyFromArray( $defaultStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '48', $plDetails[ 'T_current_assets' ] )->getStyle( $excelIndex[ $index ] . "48" )->applyFromArray( $boldStyle );
			    $sheet->setCellValue( $excelIndex[ $index ] . '49', $plDetails[ 'Total_assets' ] )->getStyle( $excelIndex[ $index ] . "49" )->applyFromArray( $boldWFill );
		    	$sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
		    	$i++;
		    	$index++;
		    }
		}
	    $logs->logWrite( "Addcfinanicals - BS Standalone Excel loops ends" );
	    try {
	        $writer = new Xlsx( $spreadsheet );
	        $BalSheet_new  = "balancesheet_new";
			$Dir = FOLDER_CREATE_PATH.$BalSheet_new;
			try {
				if( !is_dir( $Dir ) ) {
					mkdir( $Dir, 0777 ); chmod( $Dir, 0777 );
				}
			} catch( Exception $e ) {
				echo $e->getMessage();
			}
			$DeleteHeaderImagePath = '';
			$imageFileName = "New_BalSheet_".$companyID . ".xls"; // NEW STANDALONE
			$Target_Path = $Dir.'/';
			$strOriginalPath = $Target_Path.$imageFileName;
	        try {
	        	if( !file_exists( dirname(__FILE__).'/output1/' . $companyName ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output1/' . $companyName ) ) {
							chmod( dirname(__FILE__).'/output1/' . $companyName, 0777 );
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				if( $type == 'old' ) {
					$excelgentype = 'OLD';
				} else {
					$excelgentype = 'NEW';
				}
	            $csvFile = dirname(__FILE__).'/output1/' . $companyName . '/' . $companyName . '_BS_STANDALONE.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
		            $old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
				$UploadedSourceFile = MAIN_PATH.'/admin/xbrl/output1/' . $companyName . '/' . $companyName . '_BS_STANDALONE.xlsx';
	            // DELETE FILE IF EXISTING
				if(file_exists($DeleteHeaderImagePath)) { 
					try {
						@chmod($DeleteHeaderImagePath, 0777); 
						unlink($DeleteHeaderImagePath); 
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				try {
					unlink($strOriginalPath);
					if( copy( $UploadedSourceFile, $strOriginalPath ) ) {
						$old = umask(0);
						chmod( $strOriginalPath, 777, true );
						umask($old);
						unlink( $csvFile );
					} else {
						$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
				        $logs->logWrite( "Add financial - File copy error in bs standard", true );
					}
				} catch( Exception $e ) {
					//echo $e->getMessage();
				}
	            
	            $logs->logWrite( "BS Standalone Excel Created and moved to cfs-old folder in addcfinancials" ); 
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "Addcfinanicals - BS Standalone Excel write failed";
	            //echo $e->getMessage(); 
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Addcfinanicals - Spreadsheet Plugin problem";
	        //echo $e->getMessage(); 
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}

	/*
	* BS COnsolidated Excel Re-Generate
	*/
	function generateBSexcelConsolidated( $companyID = '', $ResultType = '', $companyName = '', $run_id, $processedCin, $logFileName, $cin ) {
		global $Excelgenerate;
		global $logs;

		$pl_details = mysql_query("SELECT * FROM balancesheet_new WHERE CID_FK='$companyID' AND ResultType = " . $ResultType . " order by FY desc" );
        $pl_check_count = mysql_num_rows($pl_details);

		// Excel column styles are defined.
		$companyStyle = array( 
	        'font'  => array( 'bold' => true ) 
	    );
	    $boldStyle = array( 
	        'font'  => array( 'bold' => true ),
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        ) 
	    );
	    $boldWFill = array( 
	        'fill' => array( 'fillType' => Fill::FILL_SOLID, 'color' => array('rgb' => 'AAAAAA' ) ),
	        'font'  => array( 'bold'  =>  true ),
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        )
	    );
	    $defaultStyle = array( 
	        'borders' => array(
	            'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
	        ) 
	    );
	    $excelIndex = $Excelgenerate->createColumnsArray( 'BZ' );
	    $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.    ')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $companyName )->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR Rs.');
	    $sheet->setCellValue('A6', "Shareholders' funds [Abstract]")->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', 'Share capital')->getStyle("A7")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A8', 'Reserves and surplus')->getStyle("A8")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A9', "Total shareholders funds")->getStyle("A9")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A10', 'Share application money pending allotment')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', 'Minority interest')->getStyle("A11")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A12', 'Non-current liabilities [Abstract]')->getStyle("A12")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A13', 'Long-term borrowings')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'Deferred tax liabilities (net)')->getStyle("A14")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A15', 'Other long-term liabilities')->getStyle("A15")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A16', 'Long-term provisions')->getStyle("A16")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A17', 'Total non-current liabilities')->getStyle("A17")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A18', '')->getStyle("A18")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A19', 'Current liabilities [Abstract]')->getStyle("A19")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A20', 'Short-term borrowings')->getStyle("A20")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A21', 'Trade payables')->getStyle("A21")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A22', 'Other current liabilities')->getStyle("A22")->applyFromArray( $defaultStyle );    
	    $sheet->setCellValue('A23', 'Short-term provisions ')->getStyle("A23")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A24', 'Total current liabilities')->getStyle("A24")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A25', 'Total equity and liabilities')->getStyle("A25")->applyFromArray( $boldWFill );
	    $sheet->setCellValue('A26', '')->getStyle("A26")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A27', 'Assets [Abstract]')->getStyle("A27")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A28', '')->getStyle("A28")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A29', 'Non-current assets [Abstract]')->getStyle("A29")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A30', '')->getStyle("A30")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A31', 'Fixed assets [Abstract]')->getStyle("A31")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A32', 'Tangible assets')->getStyle("A32")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A33', 'Intangible assets')->getStyle("A33")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A34', 'Total fixed assets')->getStyle("A34")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A35', 'Non-current investments')->getStyle("A35")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A36', 'Deferred tax assets (net)')->getStyle("A36")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A37', 'Long-term loans and advances')->getStyle("A37")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A38', 'Other non-current assets')->getStyle("A38")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A39', 'Total non-current assets')->getStyle("A39")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A40', '')->getStyle("A40")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A41', 'Current assets [Abstract]')->getStyle("A41")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A42', 'Current investments')->getStyle("A42")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A43', 'Inventories')->getStyle("A43")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A44', 'Trade receivables')->getStyle("A44")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A45', 'Cash and bank balances')->getStyle("A45")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A46', 'Short-term loans and advances')->getStyle("A46")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A47', 'Other current assets')->getStyle("A47")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A48', 'Total current assets')->getStyle("A48")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A49', 'Total assets')->getStyle("A49")->applyFromArray( $boldWFill );
	    $sheet->getColumnDimension('A')->setWidth(50);

	    $i = 0;
	    $index = 1;
	    $logs->logWrite( "Addcfinanicals - BS Standalone Excel loop enter" );
	    if( $pl_check_count > 0 ) {
        	while( $plDetails = mysql_fetch_array( $pl_details ) ) {
		    	$sheet->setCellValue( $excelIndex[ $index ] . '6', 'FY'.$plDetails[ 'FY' ])->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '7', $plDetails[ 'ShareCapital' ] )->getStyle( $excelIndex[ $index ] . "7" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '8', $plDetails[ 'ReservesSurplus' ] )->getStyle( $excelIndex[ $index ] . "8" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '9', $plDetails[ 'TotalFunds' ] )->getStyle( $excelIndex[ $index ] . "9" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '10', $plDetails[ 'ShareApplication' ] )->getStyle( $excelIndex[ $index ] . "10" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '11', $plDetails[ 'minority_interest' ] )->getStyle( $excelIndex[ $index ] . "11" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '12', '' )->getStyle( $excelIndex[ $index ] . "12" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '13', $plDetails[ 'L_term_borrowings' ] )->getStyle( $excelIndex[ $index ] . "13" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '14', $plDetails[ 'deferred_tax_liabilities' ] )->getStyle( $excelIndex[ $index ] . "14" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '15', $plDetails[ 'O_long_term_liabilities' ] )->getStyle( $excelIndex[ $index ] . "15" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '16', $plDetails[ 'L_term_provisions' ] )->getStyle( $excelIndex[ $index ] . "16" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '17', $plDetails[ 'T_non_current_liabilities' ] )->getStyle( $excelIndex[ $index ] . "17" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '18', '')->getStyle($excelIndex[ $index ] . "18")->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '19', '' )->getStyle( $excelIndex[ $index ] . "19" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '20', $plDetails[ 'S_term_borrowings' ] )->getStyle( $excelIndex[ $index ] . "20" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '21', $plDetails[ 'Trade_payables' ] )->getStyle( $excelIndex[ $index ] . "21" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '22', $plDetails[ 'O_current_liabilities' ] )->getStyle( $excelIndex[ $index ] . "22" )->applyFromArray( $defaultStyle );    
		    $sheet->setCellValue( $excelIndex[ $index ] . '23', $plDetails[ 'S_term_provisions' ] )->getStyle( $excelIndex[ $index ] . "23" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '24', $plDetails[ 'T_current_liabilities' ] )->getStyle( $excelIndex[ $index ] . "24" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '25', $plDetails[ 'T_equity_liabilities' ] )->getStyle( $excelIndex[ $index ] . "25" )->applyFromArray( $boldWFill );
		    $sheet->setCellValue( $excelIndex[ $index ] . '26', '')->getStyle( $excelIndex[ $index ] . "26" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '27', '' )->getStyle( $excelIndex[ $index ] . "27" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '28', '')->getStyle( $excelIndex[ $index ] . "28" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '29', '' )->getStyle( $excelIndex[ $index ] . "29" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '30', '')->getStyle( $excelIndex[ $index ] . "30" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '31', '' )->getStyle( $excelIndex[ $index ] . "31" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '32', $plDetails[ 'Tangible_assets' ] )->getStyle( $excelIndex[ $index ] . "32" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '33', $plDetails[ 'Intangible_assets' ] )->getStyle( $excelIndex[ $index ] . "33" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '34', $plDetails[ 'T_fixed_assets' ] )->getStyle( $excelIndex[ $index ] . "34" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '35', $plDetails[ 'N_current_investments' ] )->getStyle( $excelIndex[ $index ] . "35" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '36', $plDetails[ 'Deferred_tax_assets' ] )->getStyle( $excelIndex[ $index ] . "36" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '37', $plDetails[ 'L_term_loans_advances' ] )->getStyle( $excelIndex[ $index ] . "37" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '38', $plDetails[ 'O_non_current_assets' ] )->getStyle( $excelIndex[ $index ] . "38" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '39', $plDetails[ 'T_non_current_assets' ] )->getStyle( $excelIndex[ $index ] . "39" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '40', '')->getStyle( $excelIndex[ $index ] . "40" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '41', '' )->getStyle( $excelIndex[ $index ] . "41" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '42', $plDetails[ 'Current_investments' ] )->getStyle( $excelIndex[ $index ] . "42" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '43', $plDetails[ 'Inventories' ] )->getStyle( $excelIndex[ $index ] . "43" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '44', $plDetails[ 'Trade_receivables' ] )->getStyle( $excelIndex[ $index ] . "44" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '45', $plDetails[ 'Cash_bank_balances' ] )->getStyle( $excelIndex[ $index ] . "45" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '46', $plDetails[ 'S_term_loans_advances' ] )->getStyle( $excelIndex[ $index ] . "46" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '47', $plDetails[ 'O_current_assets' ] )->getStyle( $excelIndex[ $index ] . "47" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '48', $plDetails[ 'T_current_assets' ] )->getStyle( $excelIndex[ $index ] . "48" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '49', $plDetails[ 'Total_assets' ] )->getStyle( $excelIndex[ $index ] . "49" )->applyFromArray( $boldWFill );
	    	$sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
		    	$i++;
		    	$index++;
		    }
		}
	    $logs->logWrite( "BS Consolidated Excel addcfinancials loops ends" );
	    try {
	        $writer = new Xlsx( $spreadsheet );
	        $BalSheet_new  = "balancesheet_new";
			$Dir = FOLDER_CREATE_PATH.$BalSheet_new;
			try {
				if( !is_dir( $Dir ) ) {
					mkdir( $Dir, 0777 ); chmod( $Dir, 0777 );
				}
			} catch( Exception $e ) {
				echo $e->getMessage();
			}
			$DeleteHeaderImagePath = '';
			$imageFileName = "New_BalSheet_".$companyID . "_1.xls"; // NEW STANDALONE
			$Target_Path = $Dir.'/';
			$strOriginalPath = $Target_Path.$imageFileName;
	        try {
	        	if( !file_exists( dirname(__FILE__).'/output1/' . $companyName ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output1/' . $companyName ) ) {
							chmod( dirname(__FILE__).'/output1/' . $companyName, 0777 );
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Addcfinancials BS Directory creation in server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				if( $type == 'old' ) {
					$excelgentype = 'OLD';
				} else {
					$excelgentype = 'NEW';
				}
	            $csvFile = dirname(__FILE__).'/output1/' . $companyName . '/' . $companyName . '_BS_CONSOLIDATED.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
		            $old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
				$UploadedSourceFile = MAIN_PATH.'/admin/xbrl/output1/' . $companyName . '/' . $companyName . '_BS_CONSOLIDATED.xlsx';
	            // DELETE FILE IF EXISTING
				if(file_exists($DeleteHeaderImagePath)) { 
					try {
						@chmod($DeleteHeaderImagePath, 0777); 
						unlink($DeleteHeaderImagePath); 
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				try {
					unlink($strOriginalPath);
					if( copy( $UploadedSourceFile, $strOriginalPath ) ) {
						$old = umask(0);
						chmod( $strOriginalPath, 777, true );
						umask($old);
						unlink( $csvFile );
					} else {
						$xbrl->update_upload_error( $run_id, $cin, $processedCin, $logFileName );
				        $logs->logWrite( "Add financial - File copy error in bs consolidated", true );
					}
				} catch( Exception $e ) {
					//echo $e->getMessage();
				}
	            
	            $logs->logWrite( "BS Consolidated Excel Created and moved to cfs-old folder in addcfinancials" ); 
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "Addcfinanicals - BS Standalone Excel write failed";
	            //echo $e->getMessage(); 
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Addcfinanicals - Spreadsheet Plugin problem";
	        //echo $e->getMessage(); 
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}
}
?>