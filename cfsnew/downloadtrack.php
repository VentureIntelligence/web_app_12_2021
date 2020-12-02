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
        $file=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls';
        $filename=$companyname[$_GET['vcid']].'_PL_Cons.xls';//die;
    }else{
        $file=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls';     
        $filename=$companyname[$_GET['vcid']].'_PL_Stand.xls';//die; 
	}
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
    // if(isset($_GET['type']) && $_GET['type']=='consolidated'){
    //     $file=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls';
    //     $filename=$companyname[$_GET['vcid']].'_PL_Cons.xls';//die;
    // }else{
    //     $file=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls';     
    //     $filename=$companyname[$_GET['vcid']].'_PL_Stand.xls';//die; 
    // }

    $filename= str_replace(' ', '_', $filename);
    $objPHPExcel = new PHPExcel();
    
if(isset($_GET['type']) && $_GET['type']=='consolidated'){
    $fields = array("PLStandard_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR","EmployeeRelatedExpenses","ForeignExchangeEarningandOutgo","EarninginForeignExchange","OutgoinForeignExchange","EBT_before_Priod_period","Priod_period","CostOfMaterialsConsumed","PurchasesOfStockInTrade","ChangesInInventories","CSRExpenditure","OtherExpenses","CurrentTax","DeferredTax","total_profit_loss_for_period","profit_loss_of_minority_interest");
	$order="FY DESC";
	$where = "CId_FK = ".$_GET['vcid']." and FY !='' and ResultType='1'";
	$FinanceAnnual = $plstandard->getFullList(1,100,$fields,$where,$order,"name");
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
		),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ) 
	);
	$headerboldStyle = array( 
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
	$frnExgEarnin = '';
	for($i=0;$i<count($FinanceAnnual);$i++){
		if($_GET['queryString']!='INR'){
if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
$frnExgEarnin = $FinanceAnnual[$i][EarninginForeignExchange];
		}
	}
 else {
	if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
		$frnExgEarnin = $FinanceAnnual[$i][EarninginForeignExchange];
		}

 }

	}


$frnExgOutgoin = '';
	for($i=0;$i<count($FinanceAnnual);$i++){
	if($_GET['queryString']!='INR'){
		if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
		 $frnExgOutgoin =  $FinanceAnnual[$i][OutgoinForeignExchange] ;
		}
	}
 else {
	if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
		$frnExgOutgoin =  $FinanceAnnual[$i][OutgoinForeignExchange];
		}

 }

	}
	
    $col = 1;
			$objPHPExcel->getActiveSheet()->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->setCellValue('A3', $companyname)->getStyle("A3")->getFont()->setBold(true);
	        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'All Figures (unless otherwise specified) is in '.$currencytext);
			$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Particulars')->getStyle("A6")->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Operational Income')->getStyle("A7")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Other Income')->getStyle("A8") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A9', 'Total Income')->getStyle("A9") ->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Cost of materials consumed')->getStyle("A10")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A11', 'Purchases of stock-in-trade')->getStyle("A11")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Changes in Inventories')->getStyle("A12") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A13', 'Employee benefit expense')->getStyle("A13")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A14', 'CSR expenditure')->getStyle("A14") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A15', 'Other Expenses')->getStyle("A15")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A16', 'Operational, Admin & Other Expenses')->getStyle("A16")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A17', 'Operating Profit')->getStyle("A17")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A18', 'EBITDA')->getStyle("A18")->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A19', 'Interest')->getStyle("A19")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A20', 'EBDT')->getStyle("A20")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A21', 'Depreciation')->getStyle("A21")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A22', 'EBT before Exceptional Items')->getStyle("A22")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A23', 'Prior period/Exceptional /Extra Ordinary Items')->getStyle("A23")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A24', 'EBT')->getStyle("A24")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A25', 'Current tax')->getStyle("A25")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A26', 'Deferred tax')->getStyle("A26")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A27', 'Tax')->getStyle("A27")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A28', 'PAT')->getStyle("A28")->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A29', 'Profit (loss) of minority interest')->getStyle("A29")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A30', 'Total profit (loss) for period')->getStyle("A30")->applyFromArray($headerArray) ;    
			$objPHPExcel->getActiveSheet()->setCellValue('A31', 'EPS ')->getStyle("A31")->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A32', '(Basic in INR)')->getStyle("A32")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A33', '(Diluted in INR)')->getStyle("A33")->applyFromArray($headerArray) ;
			if($frnExgEarnin!='' || $frnExgOutgoin!=''){
			$objPHPExcel->getActiveSheet()->setCellValue('A35', 'Foreign Exchange Earning and Outgo:')->getStyle("A35") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A36', 'Earning in Foreign Exchange')->getStyle("A36")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A37', 'Outgo in Foreign Exchange')->getStyle("A37")->applyFromArray($headerArray) ;
			}
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
			$objPHPExcel->getActiveSheet()->setTitle('Consolidated');
			for($i=0;$i<count($FinanceAnnual);$i++){
				$row = 6;
				// if($_GET['queryString']!='INR'){
                //      if($FinanceAnnual[$i][OptnlIncome]==0){$OptnlIncome ='0';}else{ $vale = $FinanceAnnual[$i][OptnlIncome];$tot=$vale/$convalue;$OptnlIncome = round($tot,2);  if($vale==''){$OptnlIncome = '0';}} 
             
                // }
                // else
                // {
                //      if($_GET['rconv'] =='r'){ 
				// 		 if($FinanceAnnual[$i][OptnlIncome]==0){$OptnlIncome ='0';}else{$tot=($FinanceAnnual[$i][OptnlIncome]/$convalue);$OptnlIncome =round($tot,2); } 
                //     } else {  if($FinanceAnnual[$i][OptnlIncome]==0){$OptnlIncome ='0';}else{ $tot= ($FinanceAnnual[$i][OptnlIncome]/$convalue);$OptnlIncome =round($tot,2); } 
                //      } 
				// }
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
					if($FinanceAnnual[$i][OptnlIncome]==0){$OptnlIncome ='-';}else{ $vale = $FinanceAnnual[$i][OptnlIncome]*$usdconversion;$tot=$vale/$convalue;$OptnlIncome = round($tot,2);  if($vale==''){$OptnlIncome = '-';}} 
					if($FinanceAnnual[$i][OtherIncome]==0){$OtherIncome ='-';}else{ $vale = $FinanceAnnual[$i][OtherIncome]*$usdconversion;$tot=$vale/$convalue;$OtherIncome = round($tot,2);  if($vale==''){$OtherIncome = '-';}} 
					if($FinanceAnnual[$i][TotalIncome]==0){$TotalIncome ='-';}else{ $vale = $FinanceAnnual[$i][TotalIncome]*$usdconversion;$tot=$vale/$convalue;$TotalIncome = round($tot,2);  if($vale==''){$TotalIncome = '-';}}
					if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){$CostOfMaterialsConsumed ='-';}else{ $vale = $FinanceAnnual[$i][CostOfMaterialsConsumed]*$usdconversion;$tot=$vale/$convalue;$CostOfMaterialsConsumed = round($tot,2);  if($vale==''){$CostOfMaterialsConsumed = '-';}} 
					if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){$PurchasesOfStockInTrade ='-';}else{ $vale = $FinanceAnnual[$i][PurchasesOfStockInTrade]*$usdconversion;$tot=$vale/$convalue;$PurchasesOfStockInTrade = round($tot,2);  if($vale==''){$PurchasesOfStockInTrade = '-';}}
					if($FinanceAnnual[$i][ChangesInInventories]==0){$ChangesInInventories ='-';}else{ $vale = $FinanceAnnual[$i][ChangesInInventories]*$usdconversion;$tot=$vale/$convalue;$ChangesInInventories = round($tot,2);  if($vale==''){$ChangesInInventories = '-';}}
					if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){$EmployeeRelatedExpenses ='-';}else{ $vale = $FinanceAnnual[$i][EmployeeRelatedExpenses]*$usdconversion;$tot=$vale/$convalue;$EmployeeRelatedExpenses = round($tot,2);  if($vale==''){$EmployeeRelatedExpenses = '-';}}
					if($FinanceAnnual[$i][CSRExpenditure]==0){$CSRExpenditure ='-';}else{ $vale = $FinanceAnnual[$i][CSRExpenditure]*$usdconversion;$tot=$vale/$convalue;$CSRExpenditure = round($tot,2);  if($vale==''){$CSRExpenditure = '-';}}
					if($FinanceAnnual[$i][OtherExpenses]==0){$OtherExpenses ='-';}else{ $vale = $FinanceAnnual[$i][OtherExpenses]*$usdconversion;$tot=$vale/$convalue;$OtherExpenses = round($tot,2);  if($vale==''){$OtherExpenses = '-';}}
					if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){$OptnlAdminandOthrExp ='-';}else{ $vale = $FinanceAnnual[$i][OptnlAdminandOthrExp]*$usdconversion;$tot=$vale/$convalue;$OptnlAdminandOthrExp = round($tot,2);  if($vale==''){$OptnlAdminandOthrExp = '-';}}
					if($FinanceAnnual[$i][OptnlProfit]==0){$OptnlProfit ='-';}else{ $vale = $FinanceAnnual[$i][OptnlProfit]*$usdconversion;$tot=$vale/$convalue;$OptnlProfit = round($tot,2);  if($vale==''){$OptnlProfit = '-';}}
					if($FinanceAnnual[$i][EBITDA]==0){$EBITDA ='-';}else{ $vale = $FinanceAnnual[$i][EBITDA]*$usdconversion;$tot=$vale/$convalue;$EBITDA = round($tot,2);  if($vale==''){$EBITDA = '-';}}
					if($FinanceAnnual[$i][Interest]==0){$Interest ='-';}else{ $vale = $FinanceAnnual[$i][Interest]*$usdconversion;$tot=$vale/$convalue;$Interest = round($tot,2);  if($vale==''){$Interest = '-';}}
					if($FinanceAnnual[$i][EBDT]==0){$EBDT ='-';}else{ $vale = $FinanceAnnual[$i][EBDT]*$usdconversion;$tot=$vale/$convalue;$EBDT = round($tot,2);  if($vale==''){$EBDT = '-';}}
					if($FinanceAnnual[$i][Depreciation]==0){$Depreciation ='-';}else{ $vale = $FinanceAnnual[$i][Depreciation]*$usdconversion;$tot=$vale/$convalue;$Depreciation = round($tot,2);  if($vale==''){$Depreciation = '-';}}
					if($FinanceAnnual[$i][EBT_before_Priod_period]==0){$EBT_before_Priod_period ='-';}else{ $vale = $FinanceAnnual[$i][EBT_before_Priod_period]*$usdconversion;$tot=$vale/$convalue;$EBT_before_Priod_period = round($tot,2);  if($vale==''){$EBT_before_Priod_period = '-';}}
					if($FinanceAnnual[$i][Priod_period]==0){$Priod_period ='-';}else{ $vale = $FinanceAnnual[$i][Priod_period]*$usdconversion;$tot=$vale/$convalue;$Priod_period = round($tot,2);  if($vale==''){$Priod_period = '-';}}
					if($FinanceAnnual[$i][EBT]==0){$OptnlAdminandOthrExp ='-';}else{ $vale = $FinanceAnnual[$i][EBT]*$usdconversion;$tot=$vale/$convalue;$EBT = round($tot,2);  if($vale==''){$EBT = '-';}}
					if($FinanceAnnual[$i][CurrentTax]==0){$CurrentTax ='-';}else{ $vale = $FinanceAnnual[$i][CurrentTax]*$usdconversion;$tot=$vale/$convalue;$CurrentTax = round($tot,2);  if($vale==''){$CurrentTax = '-';}}
					if($FinanceAnnual[$i][DeferredTax]==0){$DeferredTax ='-';}else{ $vale = $FinanceAnnual[$i][DeferredTax]*$usdconversion;$tot=$vale/$convalue;$DeferredTax = round($tot,2);  if($vale==''){$DeferredTax = '-';}}
					if($FinanceAnnual[$i][Tax]==0){$Tax ='-';}else{ $vale = $FinanceAnnual[$i][Tax]*$usdconversion;$tot=$vale/$convalue;$Tax = round($tot,2);  if($vale==''){$Tax = '-';}}
					if($FinanceAnnual[$i][PAT]==0){$PAT ='-';}else{ $vale = $FinanceAnnual[$i][PAT]*$usdconversion;$tot=$vale/$convalue;$PAT = round($tot,2);  if($vale==''){$PAT = '-';}}
					if($FinanceAnnual[$i][BINR]==0){$BINR ='-';}else{ $vale = $FinanceAnnual[$i][BINR]*$usdconversion;$tot=$vale/$convalue;$BINR = round($tot,2);  if($vale==''){$BINR = '-';}}
					if($FinanceAnnual[$i][DINR]==0){$DINR ='-';}else{ $vale = $FinanceAnnual[$i][DINR]*$usdconversion;$tot=$vale/$convalue;$DINR = round($tot,2);  if($vale==''){$DINR = '-';}}
					if($FinanceAnnual[$i][profit_loss_of_minority_interest]==0){$profit_loss_of_minority_interest ='-';}else{ $vale = $FinanceAnnual[$i][profit_loss_of_minority_interest]*$usdconversion;$tot=$vale/$convalue;$profit_loss_of_minority_interest = round($tot,2);  if($vale==''){$profit_loss_of_minority_interest = '-';}}
					if($FinanceAnnual[$i][total_profit_loss_for_period]==0){$total_profit_loss_for_period ='-';}else{ $vale = $FinanceAnnual[$i][total_profit_loss_for_period]*$usdconversion;$tot=$vale/$convalue;$total_profit_loss_for_period = round($tot,2);  if($vale==''){$total_profit_loss_for_period = '-';}}
					if($FinanceAnnual[$i][EarninginForeignExchange]==0){$EarninginForeignExchange ='-';}else{ $vale = $FinanceAnnual[$i][EarninginForeignExchange]*$usdconversion;$tot=$vale/$convalue;$EarninginForeignExchange = round($tot,2);  if($vale==''){$EarninginForeignExchange = '-';}}
					if($FinanceAnnual[$i][OutgoinForeignExchange]==0){$OutgoinForeignExchange ='-';}else{ $vale = $FinanceAnnual[$i][OutgoinForeignExchange]*$usdconversion;$tot=$vale/$convalue;$OutgoinForeignExchange = round($tot,2);  if($vale==''){$OutgoinForeignExchange = '-';}}

			
			   }
			   else
			   {
					
						if($FinanceAnnual[$i][OptnlIncome]==0){$OptnlIncome ='-';}else{$tot=($FinanceAnnual[$i][OptnlIncome]/$convalue);if($_GET['rconv'] =='r'){$OptnlIncome =number_format("$tot",2);}else{$OptnlIncome =round($tot,2);} }
						if($FinanceAnnual[$i][OtherIncome]==0){$OtherIncome ='-';}else{$tot=($FinanceAnnual[$i][OtherIncome]/$convalue);if($_GET['rconv'] =='r'){$OtherIncome =number_format("$tot",2);}else{$OtherIncome =round($tot,2);} } 
						if($FinanceAnnual[$i][TotalIncome]==0){$TotalIncome ='-';}else{$tot=($FinanceAnnual[$i][TotalIncome]/$convalue);if($_GET['rconv'] =='r'){$TotalIncome =number_format("$tot",2);}else{$TotalIncome =round($tot,2);} }
						if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){$CostOfMaterialsConsumed ='-';}else{$tot=($FinanceAnnual[$i][CostOfMaterialsConsumed]/$convalue);if($_GET['rconv'] =='r'){$CostOfMaterialsConsumed =number_format("$tot",2);}else{$CostOfMaterialsConsumed =round($tot,2);} }
						if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){$PurchasesOfStockInTrade ='-';}else{$tot=($FinanceAnnual[$i][PurchasesOfStockInTrade]/$convalue);if($_GET['rconv'] =='r'){$PurchasesOfStockInTrade =number_format("$tot",2);}else{$PurchasesOfStockInTrade =round($tot,2);} }
						if($FinanceAnnual[$i][ChangesInInventories]==0){$ChangesInInventories ='-';}else{$tot=($FinanceAnnual[$i][ChangesInInventories]/$convalue);if($_GET['rconv'] =='r'){$ChangesInInventories =number_format("$tot",2);}else{$ChangesInInventories =round($tot,2);} }
						if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){$EmployeeRelatedExpenses ='-';}else{$tot=($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);if($_GET['rconv'] =='r'){$EmployeeRelatedExpenses =number_format("$tot",2);}else{$EmployeeRelatedExpenses =round($tot,2);} }
						if($FinanceAnnual[$i][CSRExpenditure]==0){$CSRExpenditure ='-';}else{$tot=($FinanceAnnual[$i][CSRExpenditure]/$convalue);if($_GET['rconv'] =='r'){$CSRExpenditure =number_format("$tot",2);}else{$CSRExpenditure =round($tot,2);} }
						if($FinanceAnnual[$i][OtherExpenses]==0){$OtherExpenses ='-';}else{$tot=($FinanceAnnual[$i][OtherExpenses]/$convalue);if($_GET['rconv'] =='r'){$OtherExpenses =number_format("$tot",2);}else{$OtherExpenses =round($tot,2);} }
						if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){$OptnlAdminandOthrExp ='-';}else{$tot=($FinanceAnnual[$i][OptnlAdminandOthrExp]/$convalue);if($_GET['rconv'] =='r'){$OptnlAdminandOthrExp =number_format("$tot",2);}else{$OptnlAdminandOthrExp =round($tot,2);} }
						if($FinanceAnnual[$i][OptnlProfit]==0){$OptnlProfit ='-';}else{$tot=($FinanceAnnual[$i][OptnlProfit]/$convalue);if($_GET['rconv'] =='r'){$OptnlProfit =number_format("$tot",2);}else{$OptnlProfit =round($tot,2);} }
						if($FinanceAnnual[$i][EBITDA]==0){$EBITDA ='-';}else{$tot=($FinanceAnnual[$i][EBITDA]/$convalue);if($_GET['rconv'] =='r'){$EBITDA =number_format("$tot",2);}else{$EBITDA =round($tot,2);}}
						if($FinanceAnnual[$i][Interest]==0){$Interest ='-';}else{$tot=($FinanceAnnual[$i][Interest]/$convalue);if($_GET['rconv'] =='r'){$Interest =number_format("$tot",2);}else{$Interest =round($tot,2);}}
						if($FinanceAnnual[$i][EBDT]==0){$EBDT ='-';}else{$tot=($FinanceAnnual[$i][EBDT]/$convalue);if($_GET['rconv'] =='r'){$EBDT =number_format("$tot",2);}else{$EBDT =round($tot,2);} }
						if($FinanceAnnual[$i][Depreciation]==0){$Depreciation ='-';}else{$tot=($FinanceAnnual[$i][Depreciation]/$convalue);if($_GET['rconv'] =='r'){$Depreciation =number_format("$tot",2);}else{$Depreciation =round($tot,2);} }
						if($FinanceAnnual[$i][EBT_before_Priod_period]==0){$EBT_before_Priod_period ='-';}else{$tot=($FinanceAnnual[$i][EBT_before_Priod_period]/$convalue);if($_GET['rconv'] =='r'){$EBT_before_Priod_period =number_format("$tot",2);}else{$EBT_before_Priod_period =round($tot,2);}}
						if($FinanceAnnual[$i][Priod_period]==0){$Priod_period ='-';}else{$tot=($FinanceAnnual[$i][Priod_period]/$convalue);if($_GET['rconv'] =='r'){$Priod_period =number_format("$tot",2);}else{$Priod_period =round($tot,2);}}
						if($FinanceAnnual[$i][EBT]==0){$EBT ='-';}else{$tot=($FinanceAnnual[$i][EBT]/$convalue);if($_GET['rconv'] =='r'){$EBT =number_format("$tot",2);}else{$EBT =round($tot,2);} }
						if($FinanceAnnual[$i][CurrentTax]==0){$CurrentTax ='-';}else{$tot=($FinanceAnnual[$i][CurrentTax]/$convalue);if($_GET['rconv'] =='r'){$CurrentTax =number_format("$tot",2);}else{$CurrentTax =round($tot,2);} }
						if($FinanceAnnual[$i][DeferredTax]==0){$DeferredTax ='-';}else{$tot=($FinanceAnnual[$i][DeferredTax]/$convalue);if($_GET['rconv'] =='r'){$DeferredTax =number_format("$tot",2);}else{$DeferredTax =round($tot,2);} }
						if($FinanceAnnual[$i][Tax]==0){$Tax ='-';}else{$tot=($FinanceAnnual[$i][Tax]/$convalue);if($_GET['rconv'] =='r'){$Tax =number_format("$tot",2);}else{$Tax =round($tot,2);} }
						if($FinanceAnnual[$i][PAT]==0){$PAT ='-';}else{$tot=($FinanceAnnual[$i][PAT]/$convalue);if($_GET['rconv'] =='r'){$PAT =number_format("$tot",2);}else{$PAT =round($tot,2);} }
						if($FinanceAnnual[$i][BINR]==0){$BINR ='-';}else{$tot=($FinanceAnnual[$i][BINR]);$BINR =round($tot,2); }
						if($FinanceAnnual[$i][DINR]==0){$DINR ='-';}else{$tot=($FinanceAnnual[$i][DINR]);$DINR =round($tot,2); }
						if($FinanceAnnual[$i][profit_loss_of_minority_interest]==0){$profit_loss_of_minority_interest ='-';}else{$tot=($FinanceAnnual[$i][profit_loss_of_minority_interest]/$convalue);if($_GET['rconv'] =='r'){$profit_loss_of_minority_interest =number_format("$tot",2);}else{$profit_loss_of_minority_interest =round($tot,2);}}
						if($FinanceAnnual[$i][total_profit_loss_for_period]==0){$total_profit_loss_for_period ='-';}else{$tot=($FinanceAnnual[$i][total_profit_loss_for_period]/$convalue);if($_GET['rconv'] =='r'){$total_profit_loss_for_period =number_format("$tot",2);}else{$total_profit_loss_for_period =round($tot,2);} }
						if($FinanceAnnual[$i][EarninginForeignExchange]==0){$EarninginForeignExchange ='-';}else{$tot=($FinanceAnnual[$i][EarninginForeignExchange]/$convalue);if($_GET['rconv'] =='r'){$EarninginForeignExchange =number_format("$tot",2);}else{$EarninginForeignExchange =round($tot,2);} }
						if($FinanceAnnual[$i][OutgoinForeignExchange]==0){$OutgoinForeignExchange ='-';}else{$tot=($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue);if($_GET['rconv'] =='r'){$OutgoinForeignExchange =number_format("$tot",2);}else{$OutgoinForeignExchange =round($tot,2);} }
						
					
			   }
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,"FY".$FinanceAnnual[$i][FY] )->getStyleByColumnAndRow($col,$row)->applyFromArray($headerboldStyle);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$OptnlIncome )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$OtherIncome )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$TotalIncome )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$CostOfMaterialsConsumed )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$PurchasesOfStockInTrade )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$ChangesInInventories )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$EmployeeRelatedExpenses )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$CSRExpenditure )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$OtherExpenses )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$OptnlAdminandOthrExp )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$OptnlProfit )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EBITDA )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$Interest )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EBDT )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$Depreciation )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EBT_before_Priod_period )->getStyleByColumnAndRow($col,$row)->applyFromArray($headerArray) ->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Priod_period )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EBT )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$CurrentTax )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$DeferredTax )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Tax )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$PAT )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$profit_loss_of_minority_interest )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$total_profit_loss_for_period )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row=$row+2;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$BINR )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$DINR )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row=$row+3;
				if($frnExgEarnin!='' || $frnExgOutgoin!=''){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EarninginForeignExchange )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$OutgoinForeignExchange )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				}
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('20');
				$col++;	
			}	
				



}else{
    $fields = array("PLStandard_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR","EmployeeRelatedExpenses","ForeignExchangeEarningandOutgo","EarninginForeignExchange","OutgoinForeignExchange","EBT_before_Priod_period","Priod_period","CostOfMaterialsConsumed","PurchasesOfStockInTrade","ChangesInInventories","CSRExpenditure","OtherExpenses","CurrentTax","DeferredTax","total_profit_loss_for_period","profit_loss_of_minority_interest");
    $order="FY DESC";
    $where = "CId_FK = ".$_GET['vcid']." and FY !='' and ResultType='0'";
    $FinanceAnnual = $plstandard->getFullList(1,100,$fields,$where,$order,"name");
   // print_r($FinanceAnnual);
  // $excelIndex = $this->createColumnsArray( 'BZ' );
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
		),
		'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ) 
	);
	$headerboldStyle = array( 
		'font'  => array( 'bold' => true ),
		'borders' => array(
			'allborders' => array(
				'style' => PHPExcel_Style_Border::BORDER_THIN
			  )
		) 
	);
	$frnExgEarnin = '';
	for($i=0;$i<count($FinanceAnnual);$i++){
		if($_GET['queryString']!='INR'){
if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
$frnExgEarnin = $FinanceAnnual[$i][EarninginForeignExchange];
		}
	}
 else {
	if($FinanceAnnual[$i][EarninginForeignExchange]!=0){
		$frnExgEarnin = $FinanceAnnual[$i][EarninginForeignExchange];
		}

 }

	}


$frnExgOutgoin = '';
	for($i=0;$i<count($FinanceAnnual);$i++){
	if($_GET['queryString']!='INR'){
		if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
		 $frnExgOutgoin =  $FinanceAnnual[$i][OutgoinForeignExchange] ;
		}
	}
 else {
	if($FinanceAnnual[$i][OutgoinForeignExchange]!=0){
		$frnExgOutgoin =  $FinanceAnnual[$i][OutgoinForeignExchange];
		}

 }

	}
	//print_r($FinanceAnnual);
    //$excelIndex = $this->createColumnsArray( 'BZ' );
  
    // 1-based index
    $col = 1;
			$objPHPExcel->getActiveSheet()->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->setCellValue('A3', $companyname)->getStyle("A3")->getFont()->setBold(true);
	        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'All Figures (unless otherwise specified) is in '.$currencytext);
			$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Particulars')->getStyle("A6")->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Operational Income')->getStyle("A7")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Other Income')->getStyle("A8") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A9', 'Total Income')->getStyle("A9") ->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Cost of materials consumed')->getStyle("A10")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A11', 'Purchases of stock-in-trade')->getStyle("A11")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Changes in Inventories')->getStyle("A12") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A13', 'Employee benefit expense')->getStyle("A13")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A14', 'CSR expenditure')->getStyle("A14") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A15', 'Other Expenses')->getStyle("A15")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A16', 'Operational, Admin & Other Expenses')->getStyle("A16")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A17', 'Operating Profit')->getStyle("A17")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A18', 'EBITDA')->getStyle("A18")->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A19', 'Interest')->getStyle("A19")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A20', 'EBDT')->getStyle("A20")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A21', 'Depreciation')->getStyle("A21")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A22', 'EBT before Exceptional Items')->getStyle("A22")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A23', 'Prior period/Exceptional /Extra Ordinary Items')->getStyle("A23")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A24', 'EBT')->getStyle("A24")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A25', 'Current tax')->getStyle("A25")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A26', 'Deferred tax')->getStyle("A26")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A27', 'Tax')->getStyle("A27")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A28', 'PAT')->getStyle("A28")->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A29', 'EPS ')->getStyle("A29")->applyFromArray($headerboldStyle);
			$objPHPExcel->getActiveSheet()->setCellValue('A30', '(Basic in INR)')->getStyle("A30")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A31', '(Diluted in INR)')->getStyle("A31")->applyFromArray($headerArray) ;
			if($frnExgEarnin!='' || $frnExgOutgoin!=''){
			$objPHPExcel->getActiveSheet()->setCellValue('A33', 'Foreign Exchange Earning and Outgo:')->getStyle("A33") ->applyFromArray($headerArray);
			$objPHPExcel->getActiveSheet()->setCellValue('A34', 'Earning in Foreign Exchange')->getStyle("A34")->applyFromArray($headerArray) ;
			$objPHPExcel->getActiveSheet()->setCellValue('A35', 'Outgo in Foreign Exchange')->getStyle("A35")->applyFromArray($headerArray) ;
			}
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
					if($FinanceAnnual[$i][OptnlIncome]==0){$OptnlIncome ='-';}else{ $vale = $FinanceAnnual[$i][OptnlIncome]*$usdconversion;$tot=$vale/$convalue;$OptnlIncome = round($tot,2);  if($vale==''){$OptnlIncome = '-';}} 
					if($FinanceAnnual[$i][OtherIncome]==0){$OtherIncome ='-';}else{ $vale = $FinanceAnnual[$i][OtherIncome]*$usdconversion;$tot=$vale/$convalue;$OtherIncome = round($tot,2);  if($vale==''){$OtherIncome = '-';}} 
					if($FinanceAnnual[$i][TotalIncome]==0){$TotalIncome ='-';}else{ $vale = $FinanceAnnual[$i][TotalIncome]*$usdconversion;$tot=$vale/$convalue;$TotalIncome = round($tot,2);  if($vale==''){$TotalIncome = '-';}}
					if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){$CostOfMaterialsConsumed ='-';}else{ $vale = $FinanceAnnual[$i][CostOfMaterialsConsumed]*$usdconversion;$tot=$vale/$convalue;$CostOfMaterialsConsumed = round($tot,2);  if($vale==''){$CostOfMaterialsConsumed = '-';}} 
					if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){$PurchasesOfStockInTrade ='-';}else{ $vale = $FinanceAnnual[$i][PurchasesOfStockInTrade]*$usdconversion;$tot=$vale/$convalue;$PurchasesOfStockInTrade = round($tot,2);  if($vale==''){$PurchasesOfStockInTrade = '-';}}
					if($FinanceAnnual[$i][ChangesInInventories]==0){$ChangesInInventories ='-';}else{ $vale = $FinanceAnnual[$i][ChangesInInventories]*$usdconversion;$tot=$vale/$convalue;$ChangesInInventories = round($tot,2);  if($vale==''){$ChangesInInventories = '-';}}
					if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){$EmployeeRelatedExpenses ='-';}else{ $vale = $FinanceAnnual[$i][EmployeeRelatedExpenses]*$usdconversion;$tot=$vale/$convalue;$EmployeeRelatedExpenses = round($tot,2);  if($vale==''){$EmployeeRelatedExpenses = '-';}}
					if($FinanceAnnual[$i][CSRExpenditure]==0){$CSRExpenditure ='-';}else{ $vale = $FinanceAnnual[$i][CSRExpenditure]*$usdconversion;$tot=$vale/$convalue;$CSRExpenditure = round($tot,2);  if($vale==''){$CSRExpenditure = '-';}}
					if($FinanceAnnual[$i][OtherExpenses]==0){$OtherExpenses ='-';}else{ $vale = $FinanceAnnual[$i][OtherExpenses]*$usdconversion;$tot=$vale/$convalue;$OtherExpenses = round($tot,2);  if($vale==''){$OtherExpenses = '-';}}
					if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){$OptnlAdminandOthrExp ='-';}else{ $vale = $FinanceAnnual[$i][OptnlAdminandOthrExp]*$usdconversion;$tot=$vale/$convalue;$OptnlAdminandOthrExp = round($tot,2);  if($vale==''){$OptnlAdminandOthrExp = '-';}}
					if($FinanceAnnual[$i][OptnlProfit]==0){$OptnlProfit ='-';}else{ $vale = $FinanceAnnual[$i][OptnlProfit]*$usdconversion;$tot=$vale/$convalue;$OptnlProfit = round($tot,2);  if($vale==''){$OptnlProfit = '-';}}
					if($FinanceAnnual[$i][EBITDA]==0){$EBITDA ='-';}else{ $vale = $FinanceAnnual[$i][EBITDA]*$usdconversion;$tot=$vale/$convalue;$EBITDA = round($tot,2);  if($vale==''){$EBITDA = '-';}}
					if($FinanceAnnual[$i][Interest]==0){$Interest ='-';}else{ $vale = $FinanceAnnual[$i][Interest]*$usdconversion;$tot=$vale/$convalue;$Interest = round($tot,2);  if($vale==''){$Interest = '-';}}
					if($FinanceAnnual[$i][EBDT]==0){$EBDT ='-';}else{ $vale = $FinanceAnnual[$i][EBDT]*$usdconversion;$tot=$vale/$convalue;$EBDT = round($tot,2);  if($vale==''){$EBDT = '-';}}
					if($FinanceAnnual[$i][Depreciation]==0){$Depreciation ='-';}else{ $vale = $FinanceAnnual[$i][Depreciation]*$usdconversion;$tot=$vale/$convalue;$Depreciation = round($tot,2);  if($vale==''){$Depreciation = '-';}}
					if($FinanceAnnual[$i][EBT_before_Priod_period]==0){$EBT_before_Priod_period ='-';}else{ $vale = $FinanceAnnual[$i][EBT_before_Priod_period]*$usdconversion;$tot=$vale/$convalue;$EBT_before_Priod_period = round($tot,2);  if($vale==''){$EBT_before_Priod_period = '-';}}
					if($FinanceAnnual[$i][Priod_period]==0){$Priod_period ='-';}else{ $vale = $FinanceAnnual[$i][Priod_period]*$usdconversion;$tot=$vale/$convalue;$Priod_period = round($tot,2);  if($vale==''){$Priod_period = '-';}}
					if($FinanceAnnual[$i][EBT]==0){$OptnlAdminandOthrExp ='-';}else{ $vale = $FinanceAnnual[$i][EBT]*$usdconversion;$tot=$vale/$convalue;$EBT = round($tot,2);  if($vale==''){$EBT = '-';}}
					if($FinanceAnnual[$i][CurrentTax]==0){$CurrentTax ='-';}else{ $vale = $FinanceAnnual[$i][CurrentTax]*$usdconversion;$tot=$vale/$convalue;$CurrentTax = round($tot,2);  if($vale==''){$CurrentTax = '-';}}
					if($FinanceAnnual[$i][DeferredTax]==0){$DeferredTax ='-';}else{ $vale = $FinanceAnnual[$i][DeferredTax]*$usdconversion;$tot=$vale/$convalue;$DeferredTax = round($tot,2);  if($vale==''){$DeferredTax = '-';}}
					if($FinanceAnnual[$i][Tax]==0){$Tax ='-';}else{ $vale = $FinanceAnnual[$i][Tax]*$usdconversion;$tot=$vale/$convalue;$Tax = round($tot,2);  if($vale==''){$Tax = '-';}}
					if($FinanceAnnual[$i][PAT]==0){$PAT ='-';}else{ $vale = $FinanceAnnual[$i][PAT]*$usdconversion;$tot=$vale/$convalue;$PAT = round($tot,2);  if($vale==''){$PAT = '-';}}
					if($FinanceAnnual[$i][BINR]==0){$BINR ='-';}else{ $vale = $FinanceAnnual[$i][BINR]*$usdconversion;$tot=$vale/$convalue;$BINR = round($tot,2);  if($vale==''){$BINR = '-';}}
					if($FinanceAnnual[$i][DINR]==0){$DINR ='-';}else{ $vale = $FinanceAnnual[$i][DINR]*$usdconversion;$tot=$vale/$convalue;$DINR = round($tot,2);  if($vale==''){$DINR = '-';}}
					if($FinanceAnnual[$i][EarninginForeignExchange]==0){$EarninginForeignExchange ='-';}else{ $vale = $FinanceAnnual[$i][EarninginForeignExchange]*$usdconversion;$tot=$vale/$convalue;$EarninginForeignExchange = round($tot,2);  if($vale==''){$EarninginForeignExchange = '-';}}
					if($FinanceAnnual[$i][OutgoinForeignExchange]==0){$OutgoinForeignExchange ='-';}else{ $vale = $FinanceAnnual[$i][OutgoinForeignExchange]*$usdconversion;$tot=$vale/$convalue;$OutgoinForeignExchange = round($tot,2);  if($vale==''){$OutgoinForeignExchange = '-';}}

			
			   }
			   else
			   {
					
						if($FinanceAnnual[$i][OptnlIncome]==0){$OptnlIncome ='-';}else{$tot=($FinanceAnnual[$i][OptnlIncome]/$convalue);if($_GET['rconv'] =='r'){$OptnlIncome =number_format("$tot",2);}else{$OptnlIncome =round($tot,2);} }
						if($FinanceAnnual[$i][OtherIncome]==0){$OtherIncome ='-';}else{$tot=($FinanceAnnual[$i][OtherIncome]/$convalue);if($_GET['rconv'] =='r'){$OtherIncome =number_format("$tot",2);}else{$OtherIncome =round($tot,2);} } 
						if($FinanceAnnual[$i][TotalIncome]==0){$TotalIncome ='-';}else{$tot=($FinanceAnnual[$i][TotalIncome]/$convalue);if($_GET['rconv'] =='r'){$TotalIncome =number_format("$tot",2);}else{$TotalIncome =round($tot,2);} }
						if($FinanceAnnual[$i][CostOfMaterialsConsumed]==0){$CostOfMaterialsConsumed ='-';}else{$tot=($FinanceAnnual[$i][CostOfMaterialsConsumed]/$convalue);if($_GET['rconv'] =='r'){$CostOfMaterialsConsumed =number_format("$tot",2);}else{$CostOfMaterialsConsumed =round($tot,2);} }
						if($FinanceAnnual[$i][PurchasesOfStockInTrade]==0){$PurchasesOfStockInTrade ='-';}else{$tot=($FinanceAnnual[$i][PurchasesOfStockInTrade]/$convalue);if($_GET['rconv'] =='r'){$PurchasesOfStockInTrade =number_format("$tot",2);}else{$PurchasesOfStockInTrade =round($tot,2);} }
						if($FinanceAnnual[$i][ChangesInInventories]==0){$ChangesInInventories ='-';}else{$tot=($FinanceAnnual[$i][ChangesInInventories]/$convalue);if($_GET['rconv'] =='r'){$ChangesInInventories =number_format("$tot",2);}else{$ChangesInInventories =round($tot,2);} }
						if($FinanceAnnual[$i][EmployeeRelatedExpenses]==0){$EmployeeRelatedExpenses ='-';}else{$tot=($FinanceAnnual[$i][EmployeeRelatedExpenses]/$convalue);if($_GET['rconv'] =='r'){$EmployeeRelatedExpenses =number_format("$tot",2);}else{$EmployeeRelatedExpenses =round($tot,2);} }
						if($FinanceAnnual[$i][CSRExpenditure]==0){$CSRExpenditure ='-';}else{$tot=($FinanceAnnual[$i][CSRExpenditure]/$convalue);if($_GET['rconv'] =='r'){$CSRExpenditure =number_format("$tot",2);}else{$CSRExpenditure =round($tot,2);} }
						if($FinanceAnnual[$i][OtherExpenses]==0){$OtherExpenses ='-';}else{$tot=($FinanceAnnual[$i][OtherExpenses]/$convalue);if($_GET['rconv'] =='r'){$OtherExpenses =number_format("$tot",2);}else{$OtherExpenses =round($tot,2);} }
						if($FinanceAnnual[$i][OptnlAdminandOthrExp]==0){$OptnlAdminandOthrExp ='-';}else{$tot=($FinanceAnnual[$i][OptnlAdminandOthrExp]/$convalue);if($_GET['rconv'] =='r'){$OptnlAdminandOthrExp =number_format("$tot",2);}else{$OptnlAdminandOthrExp =round($tot,2);}}
						if($FinanceAnnual[$i][OptnlProfit]==0){$OptnlProfit ='-';}else{$tot=($FinanceAnnual[$i][OptnlProfit]/$convalue);if($_GET['rconv'] =='r'){$OptnlProfit =number_format("$tot",2);}else{$OptnlProfit =round($tot,2);} }
						if($FinanceAnnual[$i][EBITDA]==0){$EBITDA ='-';}else{$tot=($FinanceAnnual[$i][EBITDA]/$convalue);if($_GET['rconv'] =='r'){$EBITDA =number_format("$tot",2);}else{$EBITDA =round($tot,2);} }
						if($FinanceAnnual[$i][Interest]==0){$Interest ='-';}else{$tot=($FinanceAnnual[$i][Interest]/$convalue);if($_GET['rconv'] =='r'){$Interest =number_format("$tot",2);}else{$Interest =round($tot,2);}}
						if($FinanceAnnual[$i][EBDT]==0){$EBDT ='-';}else{$tot=($FinanceAnnual[$i][EBDT]/$convalue);if($_GET['rconv'] =='r'){$EBDT =number_format("$tot",2);}else{$EBDT =round($tot,2);} }
						if($FinanceAnnual[$i][Depreciation]==0){$Depreciation ='-';}else{$tot=($FinanceAnnual[$i][Depreciation]/$convalue);if($_GET['rconv'] =='r'){$Depreciation =number_format("$tot",2);}else{$Depreciation =round($tot,2);} }
						if($FinanceAnnual[$i][EBT_before_Priod_period]==0){$EBT_before_Priod_period ='-';}else{$tot=($FinanceAnnual[$i][EBT_before_Priod_period]/$convalue);if($_GET['rconv'] =='r'){$EBT_before_Priod_period =number_format("$tot",2);}else{$EBT_before_Priod_period =round($tot,2);}}
						if($FinanceAnnual[$i][Priod_period]==0){$Priod_period ='-';}else{$tot=($FinanceAnnual[$i][Priod_period]/$convalue);if($_GET['rconv'] =='r'){$Priod_period =number_format("$tot",2);}else{$Priod_period =round($tot,2);} }
						if($FinanceAnnual[$i][EBT]==0){$EBT ='-';}else{$tot=($FinanceAnnual[$i][EBT]/$convalue);if($_GET['rconv'] =='r'){$EBT =number_format("$tot",2);}else{$EBT =round($tot,2);} }
						if($FinanceAnnual[$i][CurrentTax]==0){$CurrentTax ='-';}else{$tot=($FinanceAnnual[$i][CurrentTax]/$convalue);if($_GET['rconv'] =='r'){$CurrentTax =number_format("$tot",2);}else{$CurrentTax =round($tot,2);}}
						if($FinanceAnnual[$i][DeferredTax]==0){$DeferredTax ='-';}else{$tot=($FinanceAnnual[$i][DeferredTax]/$convalue);if($_GET['rconv'] =='r'){$DeferredTax =number_format("$tot",2);}else{$DeferredTax =round($tot,2);}}
						if($FinanceAnnual[$i][Tax]==0){$Tax ='-';}else{$tot=($FinanceAnnual[$i][Tax]/$convalue);if($_GET['rconv'] =='r'){$Tax =number_format("$tot",2);}else{$Tax =round($tot,2);} }
						if($FinanceAnnual[$i][PAT]==0){$PAT ='-';}else{$tot=($FinanceAnnual[$i][PAT]/$convalue);if($_GET['rconv'] =='r'){$PAT =number_format("$tot",2);}else{$PAT =round($tot,2);} }
						if($FinanceAnnual[$i][BINR]==0){$BINR ='-';}else{$tot=($FinanceAnnual[$i][BINR]);$BINR =round($tot,2); }
						if($FinanceAnnual[$i][DINR]==0){$DINR ='-';}else{$tot=($FinanceAnnual[$i][DINR]);$DINR =round($tot,2); }
						if($FinanceAnnual[$i][EarninginForeignExchange]==0){$EarninginForeignExchange ='-';}else{$tot=($FinanceAnnual[$i][EarninginForeignExchange]/$convalue);if($_GET['rconv'] =='r'){$EarninginForeignExchange =number_format("$tot",2);}else{$EarninginForeignExchange =round($tot,2);} }
						if($FinanceAnnual[$i][OutgoinForeignExchange]==0){$OutgoinForeignExchange ='-';}else{$tot=($FinanceAnnual[$i][OutgoinForeignExchange]/$convalue);if($_GET['rconv'] =='r'){$OutgoinForeignExchange =number_format("$tot",2);}else{$OutgoinForeignExchange =round($tot,2);} }
						
					
			   }
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,"FY".$FinanceAnnual[$i][FY] )->getStyleByColumnAndRow($col,$row)->applyFromArray($headerboldStyle);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$OptnlIncome)->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$OtherIncome )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$TotalIncome )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$CostOfMaterialsConsumed )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$PurchasesOfStockInTrade )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$ChangesInInventories )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$EmployeeRelatedExpenses )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$CSRExpenditure )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$OtherExpenses )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$OptnlAdminandOthrExp )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$OptnlProfit )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EBITDA )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$Interest )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EBDT )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$Depreciation )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EBT_before_Priod_period )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Priod_period )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EBT )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$CurrentTax )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$DeferredTax )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$Tax )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$PAT )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle)->getNumberFormat()->setFormatCode('0');
				$row=$row+2;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$BINR )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$DINR )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row=$row+3;
				if($frnExgEarnin!='' || $frnExgOutgoin!=''){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$EarninginForeignExchange )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$OutgoinForeignExchange )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('0');
				$row++;
				}
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('20');
				$col++;	
			}	
				

		  
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename='.basename($filename));
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
           


  
//   $filename= str_replace(' ', '_', $filename);
  
//     header('Content-Description: File Transfer');
//     header('Content-Type: application/xls');
//     header('Content-Disposition: attachment; filename='.basename($filename));
//     header('Content-Transfer-Encoding: binary');
//     header('Expires: 0');
//     header('Cache-Control: must-revalidate');
//     header('Pragma: public');
//     header('Content-Length: ' . filesize($file));
//     ob_clean();
//     flush();
//     readfile($file);
    exit;
	
}else{
	pr("Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription");
}
mysql_close();	
?>