<?php include_once("../globalconfig.php"); ?>
<?php
require_once 'PHPExcel/Classes/PHPExcel.php';
if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
include "header.php";
include "sessauth.php";
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."users.php";
$users = new users();
require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
require_once MODULES_DIR."balancesheet.php";
$balancesheet = new balancesheet();
require_once MODULES_DIR."balancesheet_new.php";
$balancesheet_new = new balancesheet_new();
include_once('conversionarray.php');


if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in downloadtrack page -'.$_SESSION['username']); }

if(!isset($authAdmin->user->elements['user_id']) || $authAdmin->user->elements['user_id'] == "") { error_log('CFS authadmin userid Empty in Downloadtrck -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }
if(!isset($authAdmin->user->elements['GroupList']) || $authAdmin->user->elements['GroupList'] == "") { error_log('CFS authadmin GroupList Empty in Downloadtrck -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }



$Insert_CProfile['user_id'] = $authAdmin->user->elements['user_id'];
$ExDownloadCountdate = $users->selectByVisitCompany($Insert_CProfile['user_id']);
$Insert_CProfile2['ExDownloadCompany']  .= $ExDownloadCountdate['ExDownloadCompany'];
$Insert_CProfile2['ExDownloadCompany']  .= ",";
$Insert_CProfile2['ExDownloadCompany']  .= $_GET['vcid'];

$Insert_CProfile1['ExDownloadCompany'] = implode(',',array_unique(explode(',',$Insert_CProfile2['ExDownloadCompany'])));
//pr($Insert_CProfile1['ExDownloadCompany']);
//substr_count($Insert_CProfile1['ExDownloadCompany'], ',')+1;
$Insert_CProfile1['ExDownloadCount'] = substr_count($Insert_CProfile1['ExDownloadCompany'], ',')+1;
$Insert_CProfile1['user_id']   = $authAdmin->user->elements['user_id'];
//pr($Insert_CProfile);
//pr($authAdmin->user->elements['user_id']);
$users->update($Insert_CProfile1);

$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("GroupList","ExDownloadCount");
$where2 = "GroupList=".$usergroup1;
$toturcount1 = $users->getFullList('','',$fields2,$where2);
$total = 0;
foreach($toturcount1 as $array)
{
   $total += $array['ExDownloadCount'];
}
$Insert_CGroup['Group_Id'] = $usergroup1;
$Insert_CGroup['ExCount'] = $total;
$grouplist->update($Insert_CGroup);
//pr($total);

//limit condition check
$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("*");
$where2 = "Group_Id =".$usergroup1;
$toturcount2 = $grouplist->getFullList('','1000',$fields2,$where2);
$template->assign("grouplimit",$toturcount2);
//$value = $grouplist->getGroup();
//pr($toturcount2);
//pr($toturcount2[0][ExLimit]);
//pr($toturcount2[0][ExCount]);

//echo $toturcount22[0]['exportLimit']."<br>";
//echo $toturcount22[0]['ExDownloadCount']; exit;

if($toturcount2[0][3] >= $toturcount2[0][7]){
	/*echo "<script type='text/javascript'>document.body.offsetWidth=300px;document.body.offsetHeight=100px;</script>";
	echo "<div style='background-color:#F5F0E4;width:300px;height:100px;border-radius:10px;margin:0px auto;'><br/><br/><span style='color:#000000;width:150px;height:80px;border-radius:10px;margin-left:110px;'><a href='<?php echo GLOBAL_BASE_URL; ?>cfs/media/plstandard/PLStandard_".$_GET['vcid'].".xls' style='text-decoration:none;color:#800000;'>Download</a></span></div>";
	$file=GLOBAL_BASE_URL.'cfs/media/plstandard/PLStandard_'.$_GET['vcid'].'.xls';
	//readfile($file);*/
            // We'll be outputting a PDF
            $where2 = "Company_Id =".$_GET['vcid'];
            $order="";
            $companyname = $cprofile->getCompanies($where2,$order);
    if(isset($_GET['type']) && $_GET['type']=='consolidated'){
        $file=FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'_1.xls';
        $filename=$companyname[$_GET['vcid']].'_BS_Cons.xls';//die;
    }else{
        $file=FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'.xls';  
        $filename=$companyname[$_GET['vcid']].'_BS_Stand.xls';//die;    
    }

// echo $file;die;

            // We'll be outputting a PDF

            if($_GET['queryString']=='INR'){
		
                if($_GET['rconv']=='m'){
                    $convalue = "1000000";
                    $currencytext="INR(Million)";
                }elseif($_GET['rconv']=='c'){
                    $convalue = "10000000";
                    $currencytext="INR(Crore)";
                }elseif($_GET['rconv']=='l'){
                    $convalue = "100000";
                    $currencytext="INR(Lakh)";
                }elseif($_GET['rconv']=='r'){
                    $convalue = "1";
                    $currencytext="INR";
                }else{
                    $convalue = "1";
                    $currencytext="INR";
                }
                }
                else
                {
                    if($_GET['rconv']=='m'){
                    $convalue = "1000000";
                    $currencytext="USD(Million)";
                    }else{
                        $convalue = "1";
                        $currencytext="USD";
                    }
                    
                }
				
  //$filename= str_replace(' ', '_', $filename);
  $filename= str_replace(' ', '_', $filename);
  $objPHPExcel = new PHPExcel();
  
  if(isset($_GET['type']) && $_GET['type']=='consolidated'){
    //$fields = array("PLStandard_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR","EmployeeRelatedExpenses","ForeignExchangeEarningandOutgo","EarninginForeignExchange","OutgoinForeignExchange","EBT_before_Priod_period","Priod_period","CostOfMaterialsConsumed","PurchasesOfStockInTrade","ChangesInInventories","CSRExpenditure","OtherExpenses","CurrentTax","DeferredTax","total_profit_loss_for_period","profit_loss_of_minority_interest");
	$fields1 = array("*");
	$wherebs_new = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='1' and a.ResultType='1'";
	$group1 = "a.FY";
	$order1 = "a.FY DESC";
    $FinanceAnnual= $balancesheet_new->getFullList(1,100,$fields1,$wherebs_new,$order1,"name",$group1);
	$finquery=mysql_query("SELECT `FCompanyName` FROM `cprofile` WHERE `Company_Id`='".$FinanceAnnual[0][CId_FK]."'");
	while($myrow=mysql_fetch_array($finquery)){
		$companyname=$myrow[0];
	}
	$headerArray = array(
		'borders' => array(
		  'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		  )
		)
	  );
	$styleArray = array(
		'borders' => array(
		  'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		  )
		  ),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
	  );
	  $boldStyle = array( 
		'font'  => array( 'bold' => true ),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			  )
		) 
	);
	//print_r($FinanceAnnual);
    //$excelIndex = $this->createColumnsArray( 'BZ' );
    // 1-based index
    $col = 1;
			$objPHPExcel->getActiveSheet()->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->setCellValue('A3', $companyname)->getStyle("A3")->getFont()->setBold(true);
	        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'All Figures (unless otherwise specified) is in '.$currencytext);
			$objPHPExcel->getActiveSheet()->setCellValue('A6', "Shareholders' funds [Abstract]")->getStyle("A6")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Share capital')->getStyle("A7")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Reserves and surplus')->getStyle("A8") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A9', 'Total shareholders funds')->getStyle("A9") ->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Share application money pending allotment')->getStyle("A10")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A11', '')->getStyle("A11")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Non-current liabilities [Abstract]')->getStyle("A12") ->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A13', 'Long-term borrowings')->getStyle("A13")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A14', 'Deferred tax liabilities (net)')->getStyle("A14") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A15', 'Other long-term liabilities')->getStyle("A15")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A16', 'Long-term provisions')->getStyle("A16")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A17', 'Total non-current liabilities')->getStyle("A17")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A18', '')->getStyle("A18")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A19', 'Current liabilities [Abstract]')->getStyle("A19")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A20', 'Short-term borrowings')->getStyle("A20")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A21', 'Trade payables')->getStyle("A21")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A22', 'Other current liabilities')->getStyle("A22")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A23', 'Short-term provisions')->getStyle("A23")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A24', 'Total current liabilities')->getStyle("A24")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A25', 'Total equity and liabilities')->getStyle("A25")->applyFromArray($boldStyle)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BBBBBB');
			$objPHPExcel->getActiveSheet()->setCellValue('A26', '')->getStyle("A26")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A27', 'Assets [Abstract]')->getStyle("A27")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A28', '')->getStyle("A28")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A29', 'Non-current assets [Abstract]')->getStyle("A29")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A30', '')->getStyle("A30")->applyFromArray($headerArray) ;    
			$objPHPExcel->getActiveSheet()->setCellValue('A31', 'Fixed assets [Abstract] ')->getStyle("A31")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A32', 'Tangible assets')->getStyle("A32")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A33', 'Intangible assets')->getStyle("A33")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A34', 'Total fixed assets')->getStyle("A34") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A35', 'Non-current investments')->getStyle("A35")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A36', 'Deferred tax assets (net)')->getStyle("A36")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A37', 'Long-term loans and advances')->getStyle("A37")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A38', 'Other non-current assets')->getStyle("A38")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A39', 'Total non-current assets')->getStyle("A39")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A40', '')->getStyle("A40")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A41', 'Current assets [Abstract]')->getStyle("A41")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A42', 'Current investments')->getStyle("A42")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A43', 'Inventories')->getStyle("A43")->applyFromArray($headerArray) ;    
			$objPHPExcel->getActiveSheet()->setCellValue('A44', 'Trade receivables')->getStyle("A44")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A45', 'Cash and bank balances')->getStyle("A45")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A46', 'Short-term loans and advances')->getStyle("A46")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A47', 'Other current assets')->getStyle("A47") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A48', 'Total current assets')->getStyle("A48")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A49', 'Total assets')->getStyle("A49")->applyFromArray($boldStyle)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BBBBBB');
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
			$objPHPExcel->getActiveSheet()->setTitle('Consolidated');
			for($i=0;$i<count($FinanceAnnual);$i++){
				$row = 6;
				
				    $position= strpos($FinanceAnnual[$i][FY]," ");
                    if($position!=''){
                      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
                    }else{
                      $year=$FinanceAnnual[$i][FY];
					}
					if($_GET['queryString']!='INR'){
						$usdconversion=$yearcurrency[$year];
					}else{
						$usdconversion="1";
					}
					
				if($_GET['queryString']!='INR'){
					if($FinanceAnnual[$i][ShareCapital]==0){$ShareCapital ='-';}else{ $vale = $FinanceAnnual[$i][ShareCapital]*$usdconversion;$tot=$vale/$convalue;$ShareCapital = round($tot,2);  if($vale==''){$ShareCapital = '-';}} 
					if($FinanceAnnual[$i][ReservesSurplus]==0){$ReservesSurplus ='-';}else{ $vale = $FinanceAnnual[$i][ReservesSurplus]*$usdconversion;$tot=$vale/$convalue;$ReservesSurplus = round($tot,2);  if($vale==''){$ReservesSurplus = '-';}} 
					if($FinanceAnnual[$i][TotalFunds]==0){$TotalIncome ='-';}else{ $vale = $FinanceAnnual[$i][TotalFunds]*$usdconversion;$tot=$vale/$convalue;$TotalFunds = round($tot,2);  if($vale==''){$TotalFunds = '-';}}
					if($FinanceAnnual[$i][ShareApplication]==0){$ShareApplication ='-';}else{ $vale = $FinanceAnnual[$i][ShareApplication]*$usdconversion;$tot=$vale/$convalue;$ShareApplication = round($tot,2);  if($vale==''){$ShareApplication = '-';}} 
					if($FinanceAnnual[$i][N_current_liabilities]==0){$N_current_liabilities ='';}else{ $vale = $FinanceAnnual[$i][N_current_liabilities]*$usdconversion;$tot=$vale/$convalue;$N_current_liabilities = round($tot,2);  if($vale==''){$N_current_liabilities = '';}}
					if($FinanceAnnual[$i][L_term_borrowings]==0){$L_term_borrowings ='-';}else{ $vale = $FinanceAnnual[$i][L_term_borrowings]*$usdconversion;$tot=$vale/$convalue;$L_term_borrowings = round($tot,2);  if($vale==''){$L_term_borrowings = '-';}}
					if($FinanceAnnual[$i][deferred_tax_liabilities]==0){$deferred_tax_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][deferred_tax_liabilities]*$usdconversion;$tot=$vale/$convalue;$deferred_tax_liabilities = round($tot,2);  if($vale==''){$deferred_tax_liabilities = '-';}}
					if($FinanceAnnual[$i][O_long_term_liabilities]==0){$O_long_term_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][O_long_term_liabilities]*$usdconversion;$tot=$vale/$convalue;$O_long_term_liabilities = round($tot,2);  if($vale==''){$O_long_term_liabilities = '-';}}
					if($FinanceAnnual[$i][L_term_provisions]==0){$OtherExpenses ='-';}else{ $vale = $FinanceAnnual[$i][L_term_provisions]*$usdconversion;$tot=$vale/$convalue;$L_term_provisions = round($tot,2);  if($vale==''){$L_term_provisions = '-';}}
					if($FinanceAnnual[$i][T_non_current_liabilities]==0){$T_non_current_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][T_non_current_liabilities]*$usdconversion;$tot=$vale/$convalue;$T_non_current_liabilities = round($tot,2);  if($vale==''){$T_non_current_liabilities = '-';}}
					if($FinanceAnnual[$i][Current_liabilities]==0){$Current_liabilities ='';}else{ $vale = $FinanceAnnual[$i][Current_liabilities]*$usdconversion;$tot=$vale/$convalue;$Current_liabilities = round($tot,2);  if($vale==''){$Current_liabilities = '';}}
					if($FinanceAnnual[$i][S_term_borrowings]==0){$S_term_borrowings ='-';}else{ $vale = $FinanceAnnual[$i][S_term_borrowings]*$usdconversion;$tot=$vale/$convalue;$S_term_borrowings = round($tot,2);  if($vale==''){$S_term_borrowings = '-';}}
					if($FinanceAnnual[$i][Trade_payables]==0){$Trade_payables ='-';}else{ $vale = $FinanceAnnual[$i][Trade_payables]*$usdconversion;$tot=$vale/$convalue;$Trade_payables = round($tot,2);  if($vale==''){$Trade_payables = '-';}}
					if($FinanceAnnual[$i][O_current_liabilities]==0){$O_current_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][O_current_liabilities]*$usdconversion;$tot=$vale/$convalue;$O_current_liabilities = round($tot,2);  if($vale==''){$O_current_liabilities = '-';}}
					if($FinanceAnnual[$i][S_term_provisions]==0){$S_term_provisions ='-';}else{ $vale = $FinanceAnnual[$i][S_term_provisions]*$usdconversion;$tot=$vale/$convalue;$S_term_provisions = round($tot,2);  if($vale==''){$S_term_provisions = '-';}}
					if($FinanceAnnual[$i][T_current_liabilities]==0){$T_current_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][T_current_liabilities]*$usdconversion;$tot=$vale/$convalue;$T_current_liabilities = round($tot,2);  if($vale==''){$T_current_liabilities = '-';}}
					if($FinanceAnnual[$i][T_equity_liabilities]==0){$T_equity_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][T_equity_liabilities]*$usdconversion;$tot=$vale/$convalue;$T_equity_liabilities = round($tot,2);  if($vale==''){$T_equity_liabilities = '-';}}
					if($FinanceAnnual[$i][Assets]==0){$Assets ='';}else{ $vale = $FinanceAnnual[$i][Assets]*$usdconversion;$tot=$vale/$convalue;$Assets = round($tot,2);  if($vale==''){$Assets = '';}}
					if($FinanceAnnual[$i][N_current_assets]==0){$N_current_assets ='';}else{ $vale = $FinanceAnnual[$i][N_current_assets]*$usdconversion;$tot=$vale/$convalue;$N_current_assets = round($tot,2);  if($vale==''){$N_current_assets = '';}}
					if($FinanceAnnual[$i][Fixed_assets]==0){$Fixed_assets ='';}else{ $vale = $FinanceAnnual[$i][Fixed_assets]*$usdconversion;$tot=$vale/$convalue;$Fixed_assets = round($tot,2);  if($vale==''){$Fixed_assets = '';}}
					if($FinanceAnnual[$i][Tangible_assets]==0){$Tangible_assets ='-';}else{ $vale = $FinanceAnnual[$i][Tangible_assets]*$usdconversion;$tot=$vale/$convalue;$Tangible_assets = round($tot,2);  if($vale==''){$Tangible_assets = '-';}}
					if($FinanceAnnual[$i][Intangible_assets]==0){$Intangible_assets ='-';}else{ $vale = $FinanceAnnual[$i][Intangible_assets]*$usdconversion;$tot=$vale/$convalue;$Intangible_assets = round($tot,2);  if($vale==''){$Intangible_assets = '-';}}
					if($FinanceAnnual[$i][T_fixed_assets]==0){$T_fixed_assets ='-';}else{ $vale = $FinanceAnnual[$i][T_fixed_assets]*$usdconversion;$tot=$vale/$convalue;$T_fixed_assets = round($tot,2);  if($vale==''){$T_fixed_assets = '-';}}
					if($FinanceAnnual[$i][N_current_investments]==0){$N_current_investments ='-';}else{ $vale = $FinanceAnnual[$i][N_current_investments]*$usdconversion;$tot=$vale/$convalue;$N_current_investments = round($tot,2);  if($vale==''){$N_current_investments = '-';}}
					if($FinanceAnnual[$i][Deferred_tax_assets]==0){$Deferred_tax_assets ='-';}else{ $vale = $FinanceAnnual[$i][Deferred_tax_assets]*$usdconversion;$tot=$vale/$convalue;$Deferred_tax_assets = round($tot,2);  if($vale==''){$Deferred_tax_assets = '-';}}
					if($FinanceAnnual[$i][L_term_loans_advances]==0){$L_term_loans_advances ='-';}else{ $vale = $FinanceAnnual[$i][L_term_loans_advances]*$usdconversion;$tot=$vale/$convalue;$L_term_loans_advances = round($tot,2);  if($vale==''){$L_term_loans_advances = '-';}}
					if($FinanceAnnual[$i][O_non_current_assets]==0){$O_non_current_assets ='-';}else{ $vale = $FinanceAnnual[$i][O_non_current_assets]*$usdconversion;$tot=$vale/$convalue;$O_non_current_assets = round($tot,2);  if($vale==''){$O_non_current_assets = '-';}}
					if($FinanceAnnual[$i][T_non_current_assets]==0){$T_non_current_assets ='-';}else{ $vale = $FinanceAnnual[$i][T_non_current_assets]*$usdconversion;$tot=$vale/$convalue;$T_non_current_assets = round($tot,2);  if($vale==''){$T_non_current_assets = '-';}}
					if($FinanceAnnual[$i][Current_assets]==0){$Current_assets ='';}else{ $vale = $FinanceAnnual[$i][Current_assets]*$usdconversion;$tot=$vale/$convalue;$Current_assets = round($tot,2);  if($vale==''){$Current_assets = '';}}
					if($FinanceAnnual[$i][Current_investments]==0){$Current_investments ='-';}else{ $vale = $FinanceAnnual[$i][Current_investments]*$usdconversion;$tot=$vale/$convalue;$Current_investments = round($tot,2);  if($vale==''){$Current_investments = '-';}}
					if($FinanceAnnual[$i][Inventories]==0){$Inventories ='-';}else{ $vale = $FinanceAnnual[$i][Inventories]*$usdconversion;$tot=$vale/$convalue;$Inventories = round($tot,2);  if($vale==''){$Inventories = '-';}}
					if($FinanceAnnual[$i][Trade_receivables]==0){$Trade_receivables ='-';}else{ $vale = $FinanceAnnual[$i][Trade_receivables]*$usdconversion;$tot=$vale/$convalue;$Trade_receivables = round($tot,2);  if($vale==''){$Trade_receivables = '-';}}
					if($FinanceAnnual[$i][Cash_bank_balances]==0){$Cash_bank_balances ='-';}else{ $vale = $FinanceAnnual[$i][Cash_bank_balances]*$usdconversion;$tot=$vale/$convalue;$Cash_bank_balances = round($tot,2);  if($vale==''){$Cash_bank_balances = '-';}}
					if($FinanceAnnual[$i][S_term_loans_advances]==0){$S_term_loans_advances ='-';}else{ $vale = $FinanceAnnual[$i][S_term_loans_advances]*$usdconversion;$tot=$vale/$convalue;$S_term_loans_advances = round($tot,2);  if($vale==''){$S_term_loans_advances = '-';}}
					if($FinanceAnnual[$i][O_current_assets]==0){$O_current_assets ='-';}else{ $vale = $FinanceAnnual[$i][O_current_assets]*$usdconversion;$tot=$vale/$convalue;$O_current_assets = round($tot,2);  if($vale==''){$O_current_assets = '-';}}
					if($FinanceAnnual[$i][T_current_assets]==0){$T_current_assets ='-';}else{ $vale = $FinanceAnnual[$i][T_current_assets]*$usdconversion;$tot=$vale/$convalue;$T_current_assets = round($tot,2);  if($vale==''){$T_current_assets = '-';}}
					if($FinanceAnnual[$i][Total_assets]==0){$Total_assets ='-';}else{ $vale = $FinanceAnnual[$i][Total_assets]*$usdconversion;$tot=$vale/$convalue;$Total_assets = round($tot,2);  if($vale==''){$Total_assets = '-';}}
			
			   }
			   else
			   {
					
				if($FinanceAnnual[$i][ShareCapital]==0){$ShareCapital ='-';}else{$tot=($FinanceAnnual[$i][ShareCapital]/$convalue);$ShareCapital =round($tot,2); }
				if($FinanceAnnual[$i][ReservesSurplus]==0){$ReservesSurplus ='-';}else{$tot=($FinanceAnnual[$i][ReservesSurplus]/$convalue);$ReservesSurplus =round($tot,2); } 
				if($FinanceAnnual[$i][TotalFunds]==0){$TotalFunds ='-';}else{$tot=($FinanceAnnual[$i][TotalFunds]/$convalue);$TotalFunds =round($tot,2); }
				if($FinanceAnnual[$i][ShareApplication]==0){$ShareApplication ='-';}else{$tot=($FinanceAnnual[$i][ShareApplication]/$convalue);$ShareApplication =round($tot,2); }
				if($FinanceAnnual[$i][N_current_liabilities]==0){$N_current_liabilities ='';}else{$tot=($FinanceAnnual[$i][N_current_liabilities]/$convalue);$N_current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][L_term_borrowings]==0){$L_term_borrowings ='-';}else{$tot=($FinanceAnnual[$i][L_term_borrowings]/$convalue);$L_term_borrowings =round($tot,2); }
				if($FinanceAnnual[$i][deferred_tax_liabilities]==0){$deferred_tax_liabilities ='-';}else{$tot=($FinanceAnnual[$i][deferred_tax_liabilities]/$convalue);$deferred_tax_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][O_long_term_liabilities]==0){$O_long_term_liabilities ='-';}else{$tot=($FinanceAnnual[$i][O_long_term_liabilities]/$convalue);$O_long_term_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][L_term_provisions]==0){$L_term_provisions ='-';}else{$tot=($FinanceAnnual[$i][L_term_provisions]/$convalue);$L_term_provisions =round($tot,2); }
				if($FinanceAnnual[$i][T_non_current_liabilities]==0){$T_non_current_liabilities ='-';}else{$tot=($FinanceAnnual[$i][T_non_current_liabilities]/$convalue);$T_non_current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][Current_liabilities]==0){$Current_liabilities ='';}else{$tot=($FinanceAnnual[$i][Current_liabilities]/$convalue);$Current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][S_term_borrowings]==0){$S_term_borrowings ='-';}else{$tot=($FinanceAnnual[$i][S_term_borrowings]/$convalue);$S_term_borrowings =round($tot,2); }
				if($FinanceAnnual[$i][Trade_payables]==0){$Trade_payables ='-';}else{$tot=($FinanceAnnual[$i][Trade_payables]/$convalue);$Trade_payables =round($tot,2); }
				if($FinanceAnnual[$i][O_current_liabilities]==0){$O_current_liabilities ='-';}else{$tot=($FinanceAnnual[$i][O_current_liabilities]/$convalue);$O_current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][S_term_provisions]==0){$S_term_provisions ='-';}else{$tot=($FinanceAnnual[$i][S_term_provisions]/$convalue);$S_term_provisions =round($tot,2); }
				if($FinanceAnnual[$i][T_current_liabilities]==0){$T_current_liabilities ='-';}else{$tot=($FinanceAnnual[$i][T_current_liabilities]/$convalue);$T_current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][T_equity_liabilities]==0){$T_equity_liabilities ='-';}else{$tot=($FinanceAnnual[$i][T_equity_liabilities]/$convalue);$T_equity_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][Assets]==0){$Assets ='';}else{$tot=($FinanceAnnual[$i][Assets]/$convalue);$Assets =round($tot,2); }
				if($FinanceAnnual[$i][N_current_assets]==0){$N_current_assets ='';}else{$tot=($FinanceAnnual[$i][N_current_assets]/$convalue);$N_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][Fixed_assets]==0){$Fixed_assets ='';}else{$tot=($FinanceAnnual[$i][Fixed_assets]/$convalue);$Fixed_assets =round($tot,2); }
				if($FinanceAnnual[$i][Tangible_assets]==0){$Tangible_assets ='-';}else{$tot=($FinanceAnnual[$i][Tangible_assets]/$convalue);$Tangible_assets =round($tot,2); }
				if($FinanceAnnual[$i][Intangible_assets]==0){$Intangible_assets ='-';}else{$tot=($FinanceAnnual[$i][Intangible_assets]/$convalue);$Intangible_assets =round($tot,2); }
				if($FinanceAnnual[$i][T_fixed_assets]==0){$T_fixed_assets ='-';}else{$tot=($FinanceAnnual[$i][T_fixed_assets]/$convalue);$T_fixed_assets =round($tot,2); }
				if($FinanceAnnual[$i][N_current_investments]==0){$N_current_investments ='-';}else{$tot=($FinanceAnnual[$i][N_current_investments]/$convalue);$N_current_investments =round($tot,2); }
				if($FinanceAnnual[$i][Deferred_tax_assets]==0){$Deferred_tax_assets ='-';}else{$tot=($FinanceAnnual[$i][Deferred_tax_assets]/$convalue);$Deferred_tax_assets =round($tot,2); }
				if($FinanceAnnual[$i][L_term_loans_advances]==0){$L_term_loans_advances ='-';}else{$tot=($FinanceAnnual[$i][L_term_loans_advances]/$convalue);$L_term_loans_advances =round($tot,2); }
				if($FinanceAnnual[$i][O_non_current_assets]==0){$O_non_current_assets ='-';}else{$tot=($FinanceAnnual[$i][O_non_current_assets]/$convalue);$O_non_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][T_non_current_assets]==0){$T_non_current_assets ='-';}else{$tot=($FinanceAnnual[$i][T_non_current_assets]/$convalue);$T_non_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][Current_assets]==0){$Current_assets ='';}else{$tot=($FinanceAnnual[$i][Current_assets]/$convalue);$Current_assets =round($tot,2); }
				if($FinanceAnnual[$i][Current_investments]==0){$Current_investments ='-';}else{$tot=($FinanceAnnual[$i][Current_investments]/$convalue);$Current_investments =round($tot,2); }
				if($FinanceAnnual[$i][Inventories]==0){$Inventories ='-';}else{$tot=($FinanceAnnual[$i][Inventories]/$convalue);$Inventories =round($tot,2); }
				if($FinanceAnnual[$i][Trade_receivables]==0){$Trade_receivables ='-';}else{$tot=($FinanceAnnual[$i][Trade_receivables]/$convalue);$Trade_receivables =round($tot,2); }
				if($FinanceAnnual[$i][Cash_bank_balances]==0){$Cash_bank_balances ='-';}else{$tot=($FinanceAnnual[$i][Cash_bank_balances]/$convalue);$Cash_bank_balances =round($tot,2); }
				if($FinanceAnnual[$i][S_term_loans_advances]==0){$S_term_loans_advances ='-';}else{$tot=($FinanceAnnual[$i][S_term_loans_advances]/$convalue);$S_term_loans_advances =round($tot,2); }
				if($FinanceAnnual[$i][O_current_assets]==0){$O_current_assets ='-';}else{$tot=($FinanceAnnual[$i][O_current_assets]/$convalue);$O_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][T_current_assets]==0){$T_current_assets ='-';}else{$tot=($FinanceAnnual[$i][T_current_assets]/$convalue);$T_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][Total_assets]==0){$Total_assets ='-';}else{$tot=($FinanceAnnual[$i][Total_assets]/$convalue);$Total_assets =round($tot,2); }
					
					
			   }
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,"FY".$FinanceAnnual[$i][FY] )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$ShareCapital )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$ReservesSurplus )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$TotalFunds )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$ShareApplication )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row=$row+2;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$N_current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$L_term_borrowings )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$deferred_tax_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$O_long_term_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$L_term_provisions )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_non_current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row=$row+2;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$Current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$S_term_borrowings )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$Trade_payables )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$O_current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$S_term_provisions )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_equity_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BBBBBB');;
			   $row=$row+2;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row=$row+2;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$N_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle); 
			   $row=$row+2;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Fixed_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Tangible_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Intangible_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_fixed_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$N_current_investments )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Deferred_tax_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$L_term_loans_advances )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$O_non_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_non_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row=$row+2;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Current_investments )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Inventories )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Trade_receivables )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Cash_bank_balances )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$S_term_loans_advances )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$O_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
			   $row++;
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Total_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BBBBBB');
			   $row++;

				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('20');
				$col++;	
			}	
				



}else{
    $fields1 = array("*");
	$wherebs_new = "a.CID_FK = ".$_GET['vcid']." and b.ResultType='0' and a.ResultType='0'";
	$group1 = "a.FY";
	$order1 = "a.FY DESC";
    $FinanceAnnual= $balancesheet_new->getFullList(1,100,$fields1,$wherebs_new,$order1,"name",$group1);
	$finquery=mysql_query("SELECT `FCompanyName` FROM `cprofile` WHERE `Company_Id`='".$FinanceAnnual[0][CId_FK]."'");
	while($myrow=mysql_fetch_array($finquery)){
		$companyname=$myrow[0];
	}
	
	$headerArray = array(
		'borders' => array(
		  'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		  )
		)
	  );
	  $styleArray = array(
		'borders' => array(
		  'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN
		  )
		),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        )
	  );
	  $boldStyle = array( 
		'font'  => array( 'bold' => true ),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			  )
		) 
	);
	//print_r($FinanceAnnual);
    //$excelIndex = $this->createColumnsArray( 'BZ' );
  
    // 1-based index
    $col = 1;
    $objPHPExcel->getActiveSheet()->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->setCellValue('A3', $companyname)->getStyle("A3")->getFont()->setBold(true);
	        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'All Figures (unless otherwise specified) is in '.$currencytext);
			$objPHPExcel->getActiveSheet()->setCellValue('A6', "Shareholders' funds [Abstract]")->getStyle("A6")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Share capital')->getStyle("A7")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Reserves and surplus')->getStyle("A8") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A9', 'Total shareholders funds')->getStyle("A9") ->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Share application money pending allotment')->getStyle("A10")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A11', '')->getStyle("A11")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Non-current liabilities [Abstract]')->getStyle("A12") ->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A13', 'Long-term borrowings')->getStyle("A13")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A14', 'Deferred tax liabilities (net)')->getStyle("A14") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A15', 'Other long-term liabilities')->getStyle("A15")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A16', 'Long-term provisions')->getStyle("A16")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A17', 'Total non-current liabilities')->getStyle("A17")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A18', '')->getStyle("A18")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A19', 'Current liabilities [Abstract]')->getStyle("A19")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A20', 'Short-term borrowings')->getStyle("A20")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A21', 'Trade payables')->getStyle("A21")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A22', 'Other current liabilities')->getStyle("A22")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A23', 'Short-term provisions')->getStyle("A23")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A24', 'Total current liabilities')->getStyle("A24")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A25', 'Total equity and liabilities')->getStyle("A25")->applyFromArray($boldStyle)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BBBBBB');
			$objPHPExcel->getActiveSheet()->setCellValue('A26', '')->getStyle("A26")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A27', 'Assets [Abstract]')->getStyle("A27")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A28', '')->getStyle("A28")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A29', 'Non-current assets [Abstract]')->getStyle("A29")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A30', '')->getStyle("A30")->applyFromArray($headerArray) ;    
			$objPHPExcel->getActiveSheet()->setCellValue('A31', 'Fixed assets [Abstract] ')->getStyle("A31")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A32', 'Tangible assets')->getStyle("A32")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A33', 'Intangible assets')->getStyle("A33")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A34', 'Total fixed assets')->getStyle("A34") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A35', 'Non-current investments')->getStyle("A35")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A36', 'Deferred tax assets (net)')->getStyle("A36")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A37', 'Long-term loans and advances')->getStyle("A37")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A38', 'Other non-current assets')->getStyle("A38")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A39', 'Total non-current assets')->getStyle("A39")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A40', '')->getStyle("A40")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A41', 'Current assets [Abstract]')->getStyle("A41")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A42', 'Current investments')->getStyle("A42")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A43', 'Inventories')->getStyle("A43")->applyFromArray($headerArray) ;    
			$objPHPExcel->getActiveSheet()->setCellValue('A44', 'Trade receivables')->getStyle("A44")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A45', 'Cash and bank balances')->getStyle("A45")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A46', 'Short-term loans and advances')->getStyle("A46")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A47', 'Other current assets')->getStyle("A47") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A48', 'Total current assets')->getStyle("A48")->applyFromArray($boldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A49', 'Total assets')->getStyle("A49")->applyFromArray($boldStyle)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BBBBBB');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
			$objPHPExcel->getActiveSheet()->setTitle('Standalone');
			for($i=0;$i<count($FinanceAnnual);$i++){
				$row = 6;
				$position= strpos($FinanceAnnual[$i][FY]," ");
                    if($position!=''){
                      $year=str_replace(" ","_",$FinanceAnnual[$i][FY]);
                    }else{
                      $year=$FinanceAnnual[$i][FY];
					}
					if($_GET['queryString']!='INR'){
						$usdconversion=$yearcurrency[$year];
					}else{
						$usdconversion="1";
					}
					
				if($_GET['queryString']!='INR'){
					if($FinanceAnnual[$i][ShareCapital]==0){$ShareCapital ='-';}else{ $vale = $FinanceAnnual[$i][ShareCapital]*$usdconversion;$tot=$vale/$convalue;$ShareCapital = round($tot,2);  if($vale==''){$ShareCapital = '-';}} 
					if($FinanceAnnual[$i][ReservesSurplus]==0){$ReservesSurplus ='-';}else{ $vale = $FinanceAnnual[$i][ReservesSurplus]*$usdconversion;$tot=$vale/$convalue;$ReservesSurplus = round($tot,2);  if($vale==''){$ReservesSurplus = '-';}} 
					if($FinanceAnnual[$i][TotalFunds]==0){$TotalIncome ='-';}else{ $vale = $FinanceAnnual[$i][TotalFunds]*$usdconversion;$tot=$vale/$convalue;$TotalFunds = round($tot,2);  if($vale==''){$TotalFunds = '-';}}
					if($FinanceAnnual[$i][ShareApplication]==0){$ShareApplication ='-';}else{ $vale = $FinanceAnnual[$i][ShareApplication]*$usdconversion;$tot=$vale/$convalue;$ShareApplication = round($tot,2);  if($vale==''){$ShareApplication = '-';}} 
					if($FinanceAnnual[$i][N_current_liabilities]==0){$N_current_liabilities ='';}else{ $vale = $FinanceAnnual[$i][N_current_liabilities]*$usdconversion;$tot=$vale/$convalue;$N_current_liabilities = round($tot,2);  if($vale==''){$N_current_liabilities = '';}}
					if($FinanceAnnual[$i][L_term_borrowings]==0){$L_term_borrowings ='-';}else{ $vale = $FinanceAnnual[$i][L_term_borrowings]*$usdconversion;$tot=$vale/$convalue;$L_term_borrowings = round($tot,2);  if($vale==''){$L_term_borrowings = '-';}}
					if($FinanceAnnual[$i][deferred_tax_liabilities]==0){$deferred_tax_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][deferred_tax_liabilities]*$usdconversion;$tot=$vale/$convalue;$deferred_tax_liabilities = round($tot,2);  if($vale==''){$deferred_tax_liabilities = '-';}}
					if($FinanceAnnual[$i][O_long_term_liabilities]==0){$O_long_term_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][O_long_term_liabilities]*$usdconversion;$tot=$vale/$convalue;$O_long_term_liabilities = round($tot,2);  if($vale==''){$O_long_term_liabilities = '-';}}
					if($FinanceAnnual[$i][L_term_provisions]==0){$OtherExpenses ='-';}else{ $vale = $FinanceAnnual[$i][L_term_provisions]*$usdconversion;$tot=$vale/$convalue;$L_term_provisions = round($tot,2);  if($vale==''){$L_term_provisions = '-';}}
					if($FinanceAnnual[$i][T_non_current_liabilities]==0){$T_non_current_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][T_non_current_liabilities]*$usdconversion;$tot=$vale/$convalue;$T_non_current_liabilities = round($tot,2);  if($vale==''){$T_non_current_liabilities = '-';}}
					if($FinanceAnnual[$i][Current_liabilities]==0){$Current_liabilities ='';}else{ $vale = $FinanceAnnual[$i][Current_liabilities]*$usdconversion;$tot=$vale/$convalue;$Current_liabilities = round($tot,2);  if($vale==''){$Current_liabilities = '';}}
					if($FinanceAnnual[$i][S_term_borrowings]==0){$S_term_borrowings ='-';}else{ $vale = $FinanceAnnual[$i][S_term_borrowings]*$usdconversion;$tot=$vale/$convalue;$S_term_borrowings = round($tot,2);  if($vale==''){$S_term_borrowings = '-';}}
					if($FinanceAnnual[$i][Trade_payables]==0){$Trade_payables ='-';}else{ $vale = $FinanceAnnual[$i][Trade_payables]*$usdconversion;$tot=$vale/$convalue;$Trade_payables = round($tot,2);  if($vale==''){$Trade_payables = '-';}}
					if($FinanceAnnual[$i][O_current_liabilities]==0){$O_current_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][O_current_liabilities]*$usdconversion;$tot=$vale/$convalue;$O_current_liabilities = round($tot,2);  if($vale==''){$O_current_liabilities = '-';}}
					if($FinanceAnnual[$i][S_term_provisions]==0){$S_term_provisions ='-';}else{ $vale = $FinanceAnnual[$i][S_term_provisions]*$usdconversion;$tot=$vale/$convalue;$S_term_provisions = round($tot,2);  if($vale==''){$S_term_provisions = '-';}}
					if($FinanceAnnual[$i][T_current_liabilities]==0){$T_current_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][T_current_liabilities]*$usdconversion;$tot=$vale/$convalue;$T_current_liabilities = round($tot,2);  if($vale==''){$T_current_liabilities = '-';}}
					if($FinanceAnnual[$i][T_equity_liabilities]==0){$T_equity_liabilities ='-';}else{ $vale = $FinanceAnnual[$i][T_equity_liabilities]*$usdconversion;$tot=$vale/$convalue;$T_equity_liabilities = round($tot,2);  if($vale==''){$T_equity_liabilities = '-';}}
					if($FinanceAnnual[$i][Assets]==0){$Assets ='';}else{ $vale = $FinanceAnnual[$i][Assets]*$usdconversion;$tot=$vale/$convalue;$Assets = round($tot,2);  if($vale==''){$Assets = '';}}
					if($FinanceAnnual[$i][N_current_assets]==0){$N_current_assets ='';}else{ $vale = $FinanceAnnual[$i][N_current_assets]*$usdconversion;$tot=$vale/$convalue;$N_current_assets = round($tot,2);  if($vale==''){$N_current_assets = '';}}
					if($FinanceAnnual[$i][Fixed_assets]==0){$Fixed_assets ='';}else{ $vale = $FinanceAnnual[$i][Fixed_assets]*$usdconversion;$tot=$vale/$convalue;$Fixed_assets = round($tot,2);  if($vale==''){$Fixed_assets = '';}}
					if($FinanceAnnual[$i][Tangible_assets]==0){$Tangible_assets ='-';}else{ $vale = $FinanceAnnual[$i][Tangible_assets]*$usdconversion;$tot=$vale/$convalue;$Tangible_assets = round($tot,2);  if($vale==''){$Tangible_assets = '-';}}
					if($FinanceAnnual[$i][Intangible_assets]==0){$Intangible_assets ='-';}else{ $vale = $FinanceAnnual[$i][Intangible_assets]*$usdconversion;$tot=$vale/$convalue;$Intangible_assets = round($tot,2);  if($vale==''){$Intangible_assets = '-';}}
					if($FinanceAnnual[$i][T_fixed_assets]==0){$T_fixed_assets ='-';}else{ $vale = $FinanceAnnual[$i][T_fixed_assets]*$usdconversion;$tot=$vale/$convalue;$T_fixed_assets = round($tot,2);  if($vale==''){$T_fixed_assets = '-';}}
					if($FinanceAnnual[$i][N_current_investments]==0){$N_current_investments ='-';}else{ $vale = $FinanceAnnual[$i][N_current_investments]*$usdconversion;$tot=$vale/$convalue;$N_current_investments = round($tot,2);  if($vale==''){$N_current_investments = '-';}}
					if($FinanceAnnual[$i][Deferred_tax_assets]==0){$Deferred_tax_assets ='-';}else{ $vale = $FinanceAnnual[$i][Deferred_tax_assets]*$usdconversion;$tot=$vale/$convalue;$Deferred_tax_assets = round($tot,2);  if($vale==''){$Deferred_tax_assets = '-';}}
					if($FinanceAnnual[$i][L_term_loans_advances]==0){$L_term_loans_advances ='-';}else{ $vale = $FinanceAnnual[$i][L_term_loans_advances]*$usdconversion;$tot=$vale/$convalue;$L_term_loans_advances = round($tot,2);  if($vale==''){$L_term_loans_advances = '-';}}
					if($FinanceAnnual[$i][O_non_current_assets]==0){$O_non_current_assets ='-';}else{ $vale = $FinanceAnnual[$i][O_non_current_assets]*$usdconversion;$tot=$vale/$convalue;$O_non_current_assets = round($tot,2);  if($vale==''){$O_non_current_assets = '-';}}
					if($FinanceAnnual[$i][T_non_current_assets]==0){$T_non_current_assets ='-';}else{ $vale = $FinanceAnnual[$i][T_non_current_assets]*$usdconversion;$tot=$vale/$convalue;$T_non_current_assets = round($tot,2);  if($vale==''){$T_non_current_assets = '-';}}
					if($FinanceAnnual[$i][Current_assets]==0){$Current_assets ='';}else{ $vale = $FinanceAnnual[$i][Current_assets]*$usdconversion;$tot=$vale/$convalue;$Current_assets = round($tot,2);  if($vale==''){$Current_assets = '';}}
					if($FinanceAnnual[$i][Current_investments]==0){$Current_investments ='-';}else{ $vale = $FinanceAnnual[$i][Current_investments]*$usdconversion;$tot=$vale/$convalue;$Current_investments = round($tot,2);  if($vale==''){$Current_investments = '-';}}
					if($FinanceAnnual[$i][Inventories]==0){$Inventories ='-';}else{ $vale = $FinanceAnnual[$i][Inventories]*$usdconversion;$tot=$vale/$convalue;$Inventories = round($tot,2);  if($vale==''){$Inventories = '-';}}
					if($FinanceAnnual[$i][Trade_receivables]==0){$Trade_receivables ='-';}else{ $vale = $FinanceAnnual[$i][Trade_receivables]*$usdconversion;$tot=$vale/$convalue;$Trade_receivables = round($tot,2);  if($vale==''){$Trade_receivables = '-';}}
					if($FinanceAnnual[$i][Cash_bank_balances]==0){$Cash_bank_balances ='-';}else{ $vale = $FinanceAnnual[$i][Cash_bank_balances]*$usdconversion;$tot=$vale/$convalue;$Cash_bank_balances = round($tot,2);  if($vale==''){$Cash_bank_balances = '-';}}
					if($FinanceAnnual[$i][S_term_loans_advances]==0){$S_term_loans_advances ='-';}else{ $vale = $FinanceAnnual[$i][S_term_loans_advances]*$usdconversion;$tot=$vale/$convalue;$S_term_loans_advances = round($tot,2);  if($vale==''){$S_term_loans_advances = '-';}}
					if($FinanceAnnual[$i][O_current_assets]==0){$O_current_assets ='-';}else{ $vale = $FinanceAnnual[$i][O_current_assets]*$usdconversion;$tot=$vale/$convalue;$O_current_assets = round($tot,2);  if($vale==''){$O_current_assets = '-';}}
					if($FinanceAnnual[$i][T_current_assets]==0){$T_current_assets ='-';}else{ $vale = $FinanceAnnual[$i][T_current_assets]*$usdconversion;$tot=$vale/$convalue;$T_current_assets = round($tot,2);  if($vale==''){$T_current_assets = '-';}}
					if($FinanceAnnual[$i][Total_assets]==0){$Total_assets ='-';}else{ $vale = $FinanceAnnual[$i][Total_assets]*$usdconversion;$tot=$vale/$convalue;$Total_assets = round($tot,2);  if($vale==''){$Total_assets = '-';}}
			
			
			   }
			   else
			   {
				if($FinanceAnnual[$i][ShareCapital]==0){$ShareCapital ='-';}else{$tot=($FinanceAnnual[$i][ShareCapital]/$convalue);$ShareCapital =round($tot,2); }
				if($FinanceAnnual[$i][ReservesSurplus]==0){$ReservesSurplus ='-';}else{$tot=($FinanceAnnual[$i][ReservesSurplus]/$convalue);$ReservesSurplus =round($tot,2); } 
				if($FinanceAnnual[$i][TotalFunds]==0){$TotalFunds ='-';}else{$tot=($FinanceAnnual[$i][TotalFunds]/$convalue);$TotalFunds =round($tot,2); }
				if($FinanceAnnual[$i][ShareApplication]==0){$ShareApplication ='-';}else{$tot=($FinanceAnnual[$i][ShareApplication]/$convalue);$ShareApplication =round($tot,2); }
				if($FinanceAnnual[$i][N_current_liabilities]==0){$N_current_liabilities ='';}else{$tot=($FinanceAnnual[$i][N_current_liabilities]/$convalue);$N_current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][L_term_borrowings]==0){$L_term_borrowings ='-';}else{$tot=($FinanceAnnual[$i][L_term_borrowings]/$convalue);$L_term_borrowings =round($tot,2); }
				if($FinanceAnnual[$i][deferred_tax_liabilities]==0){$deferred_tax_liabilities ='-';}else{$tot=($FinanceAnnual[$i][deferred_tax_liabilities]/$convalue);$deferred_tax_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][O_long_term_liabilities]==0){$O_long_term_liabilities ='-';}else{$tot=($FinanceAnnual[$i][O_long_term_liabilities]/$convalue);$O_long_term_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][L_term_provisions]==0){$L_term_provisions ='-';}else{$tot=($FinanceAnnual[$i][L_term_provisions]/$convalue);$L_term_provisions =round($tot,2); }
				if($FinanceAnnual[$i][T_non_current_liabilities]==0){$T_non_current_liabilities ='-';}else{$tot=($FinanceAnnual[$i][T_non_current_liabilities]/$convalue);$T_non_current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][Current_liabilities]==0){$Current_liabilities ='';}else{$tot=($FinanceAnnual[$i][Current_liabilities]/$convalue);$Current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][S_term_borrowings]==0){$S_term_borrowings ='-';}else{$tot=($FinanceAnnual[$i][S_term_borrowings]/$convalue);$S_term_borrowings =round($tot,2); }
				if($FinanceAnnual[$i][Trade_payables]==0){$Trade_payables ='-';}else{$tot=($FinanceAnnual[$i][Trade_payables]/$convalue);$Trade_payables =round($tot,2); }
				if($FinanceAnnual[$i][O_current_liabilities]==0){$O_current_liabilities ='-';}else{$tot=($FinanceAnnual[$i][O_current_liabilities]/$convalue);$O_current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][S_term_provisions]==0){$S_term_provisions ='-';}else{$tot=($FinanceAnnual[$i][S_term_provisions]/$convalue);$S_term_provisions =round($tot,2); }
				if($FinanceAnnual[$i][T_current_liabilities]==0){$T_current_liabilities ='-';}else{$tot=($FinanceAnnual[$i][T_current_liabilities]/$convalue);$T_current_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][T_equity_liabilities]==0){$T_equity_liabilities ='-';}else{$tot=($FinanceAnnual[$i][T_equity_liabilities]/$convalue);$T_equity_liabilities =round($tot,2); }
				if($FinanceAnnual[$i][Assets]==0){$Assets ='';}else{$tot=($FinanceAnnual[$i][Assets]/$convalue);$Assets =round($tot,2); }
				if($FinanceAnnual[$i][N_current_assets]==0){$N_current_assets ='';}else{$tot=($FinanceAnnual[$i][N_current_assets]/$convalue);$N_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][Fixed_assets]==0){$Fixed_assets ='';}else{$tot=($FinanceAnnual[$i][Fixed_assets]/$convalue);$Fixed_assets =round($tot,2); }
				if($FinanceAnnual[$i][Tangible_assets]==0){$Tangible_assets ='-';}else{$tot=($FinanceAnnual[$i][Tangible_assets]/$convalue);$Tangible_assets =round($tot,2); }
				if($FinanceAnnual[$i][Intangible_assets]==0){$Intangible_assets ='-';}else{$tot=($FinanceAnnual[$i][Intangible_assets]/$convalue);$Intangible_assets =round($tot,2); }
				if($FinanceAnnual[$i][T_fixed_assets]==0){$T_fixed_assets ='-';}else{$tot=($FinanceAnnual[$i][T_fixed_assets]/$convalue);$T_fixed_assets =round($tot,2); }
				if($FinanceAnnual[$i][N_current_investments]==0){$N_current_investments ='-';}else{$tot=($FinanceAnnual[$i][N_current_investments]/$convalue);$N_current_investments =round($tot,2); }
				if($FinanceAnnual[$i][Deferred_tax_assets]==0){$Deferred_tax_assets ='-';}else{$tot=($FinanceAnnual[$i][Deferred_tax_assets]/$convalue);$Deferred_tax_assets =round($tot,2); }
				if($FinanceAnnual[$i][L_term_loans_advances]==0){$L_term_loans_advances ='-';}else{$tot=($FinanceAnnual[$i][L_term_loans_advances]/$convalue);$L_term_loans_advances =round($tot,2); }
				if($FinanceAnnual[$i][O_non_current_assets]==0){$O_non_current_assets ='-';}else{$tot=($FinanceAnnual[$i][O_non_current_assets]/$convalue);$O_non_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][T_non_current_assets]==0){$T_non_current_assets ='-';}else{$tot=($FinanceAnnual[$i][T_non_current_assets]/$convalue);$T_non_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][Current_assets]==0){$Current_assets ='';}else{$tot=($FinanceAnnual[$i][Current_assets]/$convalue);$Current_assets =round($tot,2); }
				if($FinanceAnnual[$i][Current_investments]==0){$Current_investments ='-';}else{$tot=($FinanceAnnual[$i][Current_investments]/$convalue);$Current_investments =round($tot,2); }
				if($FinanceAnnual[$i][Inventories]==0){$Inventories ='-';}else{$tot=($FinanceAnnual[$i][Inventories]/$convalue);$Inventories =round($tot,2); }
				if($FinanceAnnual[$i][Trade_receivables]==0){$Trade_receivables ='-';}else{$tot=($FinanceAnnual[$i][Trade_receivables]/$convalue);$Trade_receivables =round($tot,2); }
				if($FinanceAnnual[$i][Cash_bank_balances]==0){$Cash_bank_balances ='-';}else{$tot=($FinanceAnnual[$i][Cash_bank_balances]/$convalue);$Cash_bank_balances =round($tot,2); }
				if($FinanceAnnual[$i][S_term_loans_advances]==0){$S_term_loans_advances ='-';}else{$tot=($FinanceAnnual[$i][S_term_loans_advances]/$convalue);$S_term_loans_advances =round($tot,2); }
				if($FinanceAnnual[$i][O_current_assets]==0){$O_current_assets ='-';}else{$tot=($FinanceAnnual[$i][O_current_assets]/$convalue);$O_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][T_current_assets]==0){$T_current_assets ='-';}else{$tot=($FinanceAnnual[$i][T_current_assets]/$convalue);$T_current_assets =round($tot,2); }
				if($FinanceAnnual[$i][Total_assets]==0){$Total_assets ='-';}else{$tot=($FinanceAnnual[$i][Total_assets]/$convalue);$Total_assets =round($tot,2); }
								
					
			   }
			   $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,"FY".$FinanceAnnual[$i][FY] )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$ShareCapital )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$ReservesSurplus )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$TotalFunds )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$ShareApplication )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row=$row+2;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$N_current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$L_term_borrowings )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$deferred_tax_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$O_long_term_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$L_term_provisions )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_non_current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row=$row+2;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$Current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$S_term_borrowings )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$Trade_payables )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$O_current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$S_term_provisions )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_current_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_equity_liabilities )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BBBBBB');;
				$row=$row+2;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row=$row+2;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$N_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle); 
				$row=$row+2;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Fixed_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Tangible_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Intangible_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_fixed_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$N_current_investments )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Deferred_tax_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$L_term_loans_advances )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$O_non_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_non_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row=$row+2;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Current_investments )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
			   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Inventories )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Trade_receivables )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
			   	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Cash_bank_balances )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$S_term_loans_advances )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$O_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$T_current_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Total_assets )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('BBBBBB');
				$row++;
				
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('20');
				$col++;	
			}	
				

		  
}
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.basename($filename));
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
    // header('Content-Description: File Transfer');
    // header('Content-Type: application/xls');
    // header('Content-Disposition: attachment; filename='.basename($filename));
    // header('Content-Transfer-Encoding: binary');
    // header('Expires: 0');
    // header('Cache-Control: must-revalidate');
    // header('Pragma: public');
    // header('Content-Length: ' . filesize($file));
    // ob_clean();
    // flush();
    // readfile($file);
    exit;
	
}else{
	pr("Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription");
}
mysql_close();	
?>