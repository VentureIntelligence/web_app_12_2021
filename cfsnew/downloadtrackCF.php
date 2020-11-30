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
require_once MODULES_DIR."cashflow.php";
$cashflow = new cashflow();


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
        $file=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'_1.xls';
        $filename=$companyname[$_GET['vcid']].'_CF_Cons.xls';//die;
    }else{
        $file=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'.xls';     
        $filename=$companyname[$_GET['vcid']].'_CF_Stand.xls';//die; 
    }

//echo $file;//die;

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
   

                $filename= str_replace(' ', '_', $filename);
                $objPHPExcel = new PHPExcel();
                if(isset($_GET['type']) && $_GET['type']=='consolidated'){
                  $fieldscf = array("a.cashflow_id","a.CId_FK","a.IndustryId_FK","a.CashflowApplicable","a.NetPLBefore","a.CashflowFromOperation",
                  "a.NetcashUsedInvestment","a.NetcashFromFinance","a.NetIncDecCash","a.EquivalentBeginYear","a.EquivalentEndYear","a.FY","a.ResultType");
                  $wherecf= "a.CId_FK = ".$_GET['vcid']." and a.ResultType='1'";
                  $ordercash = "a.FY DESC";
                  $groupcash = "a.FY";
                  $FinanceAnnual= $cashflow->getFullList(1,100,$fieldscf,$wherecf,$ordercash,"name",$groupcash); 
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
                            $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Particulars')->getStyle("A6")->applyFromArray($boldStyle);
                            $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Statement of cash flows')->getStyle("A7")->applyFromArray($boldStyle);
                            $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Net Profit/Loss Before Extraordinary Items And Tax')->getStyle("A8")->applyFromArray($boldStyle);
                            $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Net CashFlow From Operating Activities')->getStyle("A9") ->applyFromArray($headerArray);
                            $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Net Cash Used In Investing Activities')->getStyle("A10")->applyFromArray($headerArray) ;
                            $objPHPExcel->getActiveSheet()->setCellValue('A11', 'Net Cash Used From Financing Activities')->getStyle("A11")->applyFromArray($headerArray) ;
                            $objPHPExcel->getActiveSheet()->setCellValue('A12', 'Net Inc/Dec In Cash And Cash Equivalents')->getStyle("A12")->applyFromArray($boldStyle);
                            $objPHPExcel->getActiveSheet()->setCellValue('A13', 'Cash And Cash Equivalents End Of Year')->getStyle("A14") ->applyFromArray($headerArray);
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
                                    if($FinanceAnnual[$i][NetPLBefore]==0){$NetPLBefore ='-';}else{ $vale = $FinanceAnnual[$i][NetPLBefore]*$usdconversion;$tot=$vale/$convalue;$NetPLBefore = round($tot,2);  if($vale==''){$NetPLBefore = '-';}} 
                                    if($FinanceAnnual[$i][CashflowFromOperation]==0){$CashflowFromOperation ='-';}else{ $vale = $FinanceAnnual[$i][CashflowFromOperation]*$usdconversion;$tot=$vale/$convalue;$CashflowFromOperation = round($tot,2);  if($vale==''){$CashflowFromOperation = '-';}} 
                                    if($FinanceAnnual[$i][NetcashUsedInvestment]==0){$NetcashUsedInvestment ='-';}else{ $vale = $FinanceAnnual[$i][NetcashUsedInvestment]*$usdconversion;$tot=$vale/$convalue;$NetcashUsedInvestment = round($tot,2);  if($vale==''){$NetcashUsedInvestment = '-';}}
                                    if($FinanceAnnual[$i][NetcashFromFinance]==0){$NetcashFromFinance ='-';}else{ $vale = $FinanceAnnual[$i][NetcashFromFinance]*$usdconversion;$tot=$vale/$convalue;$NetcashFromFinance = round($tot,2);  if($vale==''){$NetcashFromFinance = '-';}} 
                                    if($FinanceAnnual[$i][NetIncDecCash]==0){$NetIncDecCash ='-';}else{ $vale = $FinanceAnnual[$i][NetIncDecCash]*$usdconversion;$tot=$vale/$convalue;$NetIncDecCash = round($tot,2);  if($vale==''){$NetIncDecCash = '-';}}
                                    if($FinanceAnnual[$i][EquivalentEndYear]==0){$EquivalentEndYear ='-';}else{ $vale = $FinanceAnnual[$i][EquivalentEndYear]*$usdconversion;$tot=$vale/$convalue;$EquivalentEndYear = round($tot,2);  if($vale==''){$EquivalentEndYear = '-';}}
                                    
                            
                               }
                               else
                               {
                                    
                                        if($FinanceAnnual[$i][NetPLBefore]==0){$NetPLBefore ='-';}else{$tot=($FinanceAnnual[$i][NetPLBefore]/$convalue);$NetPLBefore =round($tot,2); }
                                        if($FinanceAnnual[$i][CashflowFromOperation]==0){$CashflowFromOperation ='-';}else{$tot=($FinanceAnnual[$i][CashflowFromOperation]/$convalue);$CashflowFromOperation =round($tot,2); } 
                                        if($FinanceAnnual[$i][NetcashUsedInvestment]==0){$NetcashUsedInvestment ='-';}else{$tot=($FinanceAnnual[$i][NetcashUsedInvestment]/$convalue);$NetcashUsedInvestment =round($tot,2); }
                                        if($FinanceAnnual[$i][NetcashFromFinance]==0){$NetcashFromFinance ='-';}else{$tot=($FinanceAnnual[$i][NetcashFromFinance]/$convalue);$NetcashFromFinance =round($tot,2); }
                                        if($FinanceAnnual[$i][NetIncDecCash]==0){$NetIncDecCash ='-';}else{$tot=($FinanceAnnual[$i][NetIncDecCash]/$convalue);$NetIncDecCash =round($tot,2); }
                                        if($FinanceAnnual[$i][EquivalentEndYear]==0){$EquivalentEndYear ='-';}else{$tot=($FinanceAnnual[$i][EquivalentEndYear]/$convalue);$EquivalentEndYear =round($tot,2); }
                                        
                                    
                               }
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,"FY".$FinanceAnnual[$i][FY] )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
                                $row=$row+2;
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$NetPLBefore )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                                $row++;
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$CashflowFromOperation )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                                $row++;
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$NetcashUsedInvestment )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                                $row++;
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$NetcashFromFinance )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                                $row++;
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$NetIncDecCash )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                                $row++;
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$EquivalentEndYear )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                                $row++;
                                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setWidth('20');
                                $col++;	
                            }	
                                
                
                
                
                }else{
                  $fieldscf = array("a.cashflow_id","a.CId_FK","a.IndustryId_FK","a.CashflowApplicable","a.NetPLBefore","a.CashflowFromOperation",
                  "a.NetcashUsedInvestment","a.NetcashFromFinance","a.NetIncDecCash","a.EquivalentBeginYear","a.EquivalentEndYear","a.FY","a.ResultType");
                  $wherecf= "a.CId_FK = ".$_GET['vcid']." and a.ResultType='0'";
                  $ordercash = "a.FY DESC";
                  $groupcash = "a.FY";
                  $FinanceAnnual = $cashflow->getFullList(1,100,$fieldscf,$wherecf,$ordercash,"name",$groupcash); 
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
                        ) 
                    );
                    //print_r($FinanceAnnual);
                    //$excelIndex = $this->createColumnsArray( 'BZ' );
                  
                    // 1-based index
                    $col = 1;
                    $objPHPExcel->getActiveSheet()->setCellValue('A1', '© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('A3', $companyname)->getStyle("A3")->getFont()->setBold(true);
                    $objPHPExcel->getActiveSheet()->setCellValue('A4', 'All Figures (unless otherwise specified) is in '.$currencytext);
                    $objPHPExcel->getActiveSheet()->setCellValue('A6', 'Particulars')->getStyle("A6")->applyFromArray($boldStyle);
                    $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Statement of cash flows')->getStyle("A7")->applyFromArray($boldStyle);
                    $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Net Profit/Loss Before Extraordinary Items And Tax')->getStyle("A8")->applyFromArray($boldStyle);
                    $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Net CashFlow From Operating Activities')->getStyle("A9") ->applyFromArray($headerArray);
                    $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Net Cash Used In Investing Activities')->getStyle("A10")->applyFromArray($headerArray) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('A11', 'Net Cash Used From Financing Activities')->getStyle("A11")->applyFromArray($headerArray) ;
                    $objPHPExcel->getActiveSheet()->setCellValue('A12', 'Net Inc/Dec In Cash And Cash Equivalents')->getStyle("A12")->applyFromArray($boldStyle);
                    $objPHPExcel->getActiveSheet()->setCellValue('A13', 'Cash And Cash Equivalents End Of Year')->getStyle("A14") ->applyFromArray($headerArray);
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
                                  if($FinanceAnnual[$i][NetPLBefore]==0){$NetPLBefore ='-';}else{ $vale = $FinanceAnnual[$i][NetPLBefore]*$usdconversion;$tot=$vale/$convalue;$NetPLBefore = round($tot,2);  if($vale==''){$NetPLBefore = '-';}} 
                                  if($FinanceAnnual[$i][CashflowFromOperation]==0){$CashflowFromOperation ='-';}else{ $vale = $FinanceAnnual[$i][CashflowFromOperation]*$usdconversion;$tot=$vale/$convalue;$CashflowFromOperation = round($tot,2);  if($vale==''){$CashflowFromOperation = '-';}} 
                                  if($FinanceAnnual[$i][NetcashUsedInvestment]==0){$NetcashUsedInvestment ='-';}else{ $vale = $FinanceAnnual[$i][NetcashUsedInvestment]*$usdconversion;$tot=$vale/$convalue;$NetcashUsedInvestment = round($tot,2);  if($vale==''){$NetcashUsedInvestment = '-';}}
                                  if($FinanceAnnual[$i][NetcashFromFinance]==0){$NetcashFromFinance ='-';}else{ $vale = $FinanceAnnual[$i][NetcashFromFinance]*$usdconversion;$tot=$vale/$convalue;$NetcashFromFinance = round($tot,2);  if($vale==''){$NetcashFromFinance = '-';}} 
                                  if($FinanceAnnual[$i][NetIncDecCash]==0){$NetIncDecCash ='-';}else{ $vale = $FinanceAnnual[$i][NetIncDecCash]*$usdconversion;$tot=$vale/$convalue;$NetIncDecCash = round($tot,2);  if($vale==''){$NetIncDecCash = '-';}}
                                  if($FinanceAnnual[$i][EquivalentEndYear]==0){$EquivalentEndYear ='-';}else{ $vale = $FinanceAnnual[$i][EquivalentEndYear]*$usdconversion;$tot=$vale/$convalue;$EquivalentEndYear = round($tot,2);  if($vale==''){$EquivalentEndYear = '-';}}
                                  
                            
                               }
                               else
                               {
                                    
                                if($FinanceAnnual[$i][NetPLBefore]==0){$NetPLBefore ='-';}else{$tot=($FinanceAnnual[$i][NetPLBefore]/$convalue);$NetPLBefore =round($tot,2); }
                                if($FinanceAnnual[$i][CashflowFromOperation]==0){$CashflowFromOperation ='-';}else{$tot=($FinanceAnnual[$i][CashflowFromOperation]/$convalue);$CashflowFromOperation =round($tot,2); } 
                                if($FinanceAnnual[$i][NetcashUsedInvestment]==0){$NetcashUsedInvestment ='-';}else{$tot=($FinanceAnnual[$i][NetcashUsedInvestment]/$convalue);$NetcashUsedInvestment =round($tot,2); }
                                if($FinanceAnnual[$i][NetcashFromFinance]==0){$NetcashFromFinance ='-';}else{$tot=($FinanceAnnual[$i][NetcashFromFinance]/$convalue);$NetcashFromFinance =round($tot,2); }
                                if($FinanceAnnual[$i][NetIncDecCash]==0){$NetIncDecCash ='-';}else{$tot=($FinanceAnnual[$i][NetIncDecCash]/$convalue);$NetIncDecCash =round($tot,2); }
                                if($FinanceAnnual[$i][EquivalentEndYear]==0){$EquivalentEndYear ='-';}else{$tot=($FinanceAnnual[$i][EquivalentEndYear]/$convalue);$EquivalentEndYear =round($tot,2); }
                                 
                                    
                               }
                               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,"FY".$FinanceAnnual[$i][FY] )->getStyleByColumnAndRow($col,$row)->applyFromArray($boldStyle);
                               $row=$row+2;
                               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$NetPLBefore )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                               $row++;
                               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$CashflowFromOperation )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                               $row++;
                               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$NetcashUsedInvestment )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                               $row++;
                               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$NetcashFromFinance )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                               $row++;
                               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $col,$row,$NetIncDecCash )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
                               $row++;
                               $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col,$row,$EquivalentEndYear )->getStyleByColumnAndRow($col,$row)->applyFromArray($styleArray);
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