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
	
	$where = "CId_FK = ".$_GET['vcid']." and FY !='' and ResultType='1'";
	$FinanceAnnual = $plstandard->getFullList(1,100,$fields,$where,$order,"name");
	$finquery=mysql_query("SELECT `FCompanyName` FROM `cprofile` WHERE `Company_Id`='".$FinanceAnnual[0][CId_FK]."'");
	while($myrow=mysql_fetch_array($finquery)){
		$companyname=$myrow[0];
	}
	$styleArray = array(
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
	        $objPHPExcel->getActiveSheet()->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR');
			$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Particulars')->getStyle("A6")->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Operational Income')->getStyle("A7") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Other Income')->getStyle("A8") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A9', 'Total Income')->getStyle("A9") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Cost of materials consumed')->getStyle("A10") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A11', 'Purchases of stock-in-trade')->getStyle("A11") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Changes in Inventories')->getStyle("A12") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A13', 'Employee benefit expense')->getStyle("A13") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A14', 'CSR expenditure')->getStyle("A14") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A15', 'Other Expenses')->getStyle("A15") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A16', 'Operational, Admin & Other Expenses')->getStyle("A16") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A17', 'Operating Profit')->getStyle("A17") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A18', 'EBITDA')->getStyle("A18") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A19', 'Interest')->getStyle("A19") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A20', 'EBDT')->getStyle("A20") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A21', 'Depreciation')->getStyle("A21") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A22', 'EBT before Exceptional Items')->getStyle("A22") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A23', 'Prior period/Exceptional /Extra Ordinary Items')->getStyle("A23") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A24', 'EBT')->getStyle("A24") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A25', 'Current tax')->getStyle("A25") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A26', 'Deferred tax')->getStyle("A26") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A27', 'Tax')->getStyle("A27") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A28', 'PAT')->getStyle("A28") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A29', 'Profit (loss) of minority interest')->getStyle("A29") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A30', 'Total profit (loss) for period')->getStyle("A30") ;    
			$objPHPExcel->getActiveSheet()->setCellValue('A31', 'EPS ')->getStyle("A31") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A32', '(Basic in INR)')->getStyle("A32") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A33', '(Diluted in INR)')->getStyle("A33") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A35', 'Foreign Exchange Earning and Outgo:')->getStyle("A35") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A36', 'Earning in Foreign Exchange')->getStyle("A36") ;
			$objPHPExcel->getActiveSheet()->setCellValue('A37', 'Outgo in Foreign Exchange')->getStyle("A37") ;
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
			$objPHPExcel->getActiveSheet()->setTitle('Annual P&L Consolidated');
			for($i=0;$i<count($FinanceAnnual);$i++){
				$row = 6;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,"FY".$FinanceAnnual[$i][FY] )->getStyleByColumnAndRow($col,$row)->getFont()->setBold(true);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$FinanceAnnual[$i][OptnlIncome] )->applyFromArray($styleArray);
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][OtherIncome] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$FinanceAnnual[$i][TotalIncome] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][CostOfMaterialsConsumed] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$FinanceAnnual[$i][PurchasesOfStockInTrade] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][ChangesInInventories] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$FinanceAnnual[$i][EmployeeRelatedExpenses] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][CSRExpenditure] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$FinanceAnnual[$i][OtherExpenses] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][OptnlAdminandOthrExp] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$FinanceAnnual[$i][OptnlProfit] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][EBITDA] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$FinanceAnnual[$i][Interest] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][EBDT] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$FinanceAnnual[$i][Depreciation] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][EBT_before_Priod_period] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][Priod_period] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][EBT] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][CurrentTax] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][DeferredTax] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][Tax] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][PAT] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][profit_loss_of_minority_interest] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][total_profit_loss_for_period] );
				$row=$row+2;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][BINR] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][DINR] );
				$row=$row+3;
				
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][EarninginForeignExchange] );
				$row++;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$FinanceAnnual[$i][OutgoinForeignExchange] );
				$row++;
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
   $i = 0;
   $index = 1;
   $objPHPExcel->getActiveSheet()->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
   $objPHPExcel->getActiveSheet()->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR');
		   $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Particulars')->getStyle("A6")->getFont()->setBold(true);
		   $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Operational Income')->getStyle("A7") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Other Income')->getStyle("A8") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Total Income')->getStyle("A9") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Cost of materials consumed')->getStyle("A10") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A11', 'Purchases of stock-in-trade')->getStyle("A11") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A12', 'Changes in Inventories')->getStyle("A12") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A13', 'Employee benefit expense')->getStyle("A13") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A14', 'CSR expenditure')->getStyle("A14") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A15', 'Other Expenses')->getStyle("A15") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A16', 'Operational, Admin & Other Expenses')->getStyle("A16") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A17', 'Operating Profit')->getStyle("A17") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A18', 'EBITDA')->getStyle("A18") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A19', 'Interest')->getStyle("A19") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A20', 'EBDT')->getStyle("A20") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A21', 'Depreciation')->getStyle("A21") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A22', 'EBT before Exceptional Items')->getStyle("A22") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A23', 'Prior period/Exceptional /Extra Ordinary Items')->getStyle("A23") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A24', 'EBT')->getStyle("A24") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A25', 'Current tax')->getStyle("A25") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A26', 'Deferred tax')->getStyle("A26") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A27', 'Tax')->getStyle("A27") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A28', 'PAT')->getStyle("A28") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A29', 'Profit (loss) of minority interest')->getStyle("A29") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A30', 'Total profit (loss) for period')->getStyle("A30") ;    
		   $objPHPExcel->getActiveSheet()->setCellValue('A31', 'EPS ')->getStyle("A31") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A32', '(Basic in INR)')->getStyle("A32") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A33', '(Diluted in INR)')->getStyle("A33") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A35', 'Foreign Exchange Earning and Outgo:')->getStyle("A35") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A36', 'Earning in Foreign Exchange')->getStyle("A36") ;
		   $objPHPExcel->getActiveSheet()->setCellValue('A37', 'Outgo in Foreign Exchange')->getStyle("A37") ;
		   $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
		   $objPHPExcel->getActiveSheet()->setTitle('Annual P&L Standard');
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