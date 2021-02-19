<?php
if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
include "header.php";
include "sessauth.php";
include_once('simple_html_dom.php');
include("etc/conf.php");
include("path_Assign.php");
$dbhost = "localhost";
$dbuser = "venture_admin16";
$dbpassword = "V@dm!n2016";
$dbname = "venture_peinvestments";
$dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db($dbname,$dbhandle) 
  or die("Database could not select");
if(isset($_REQUEST['cin']) && $_REQUEST['cin'] !=''){
    $cin = base64_decode($_REQUEST['cin']);
    $cin_check = mysql_query("SELECT * FROM cprofile WHERE CIN='$cin'" );
    $cin_check_count = mysql_num_rows($cin_check);
    $cin_res = mysql_fetch_array($cin_check);
    $cprofile_id = $cin_res['Company_Id'];
    $data_inner = array();
    
    $data['companyName'] = $cin_res['SCompanyName'];
    
    //PL Stranded
    $res1 = array();
    $PLStsQry = mysql_query("SELECT PLStandard_Id,CId_FK,IndustryId_FK,OptnlIncome,OtherIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,FY,TotalIncome,BINR,DINR,EmployeeRelatedExpenses,ForeignExchangeEarningandOutgo,EarninginForeignExchange,OutgoinForeignExchange FROM plstandard WHERE CId_FK = '$cprofile_id' and FY !='' and ResultType='0' ORDER BY FY DESC LIMIT 0,100");
    if(mysql_num_rows($PLStsQry) > 0){
        while($res = mysql_fetch_array($PLStsQry)){
            $res1 = array();
            $res1['PLStandard_Id'] = $res['PLStandard_Id'];
            $res1['CId_FK'] = $res['CId_FK'];
            $res1['IndustryId_FK'] = $res['IndustryId_FK'];
            $res1['OptnlIncome'] = $res['OptnlIncome'];
            $res1['OtherIncome'] = $res['OtherIncome'];
            $res1['OptnlAdminandOthrExp'] = $res['OptnlAdminandOthrExp'];
            $res1['OptnlProfit'] = $res['OptnlProfit'];
            $res1['EBITDA'] = $res['EBITDA'];
            $res1['Interest'] = $res['Interest'];
            $res1['EBDT'] = $res['EBDT'];
            $res1['Depreciation'] = $res['Depreciation'];
            $res1['EBT'] = $res['EBT'];
            $res1['Tax'] = $res['Tax'];
            $res1['PAT'] = $res['PAT'];
            $res1['FY'] = $res['FY'];
            $res1['TotalIncome'] = $res['TotalIncome'];
            $res1['BINR'] = $res['BINR'];
            $res1['DINR'] = $res['DINR'];
            $res1['EmployeeRelatedExpenses'] = $res['EmployeeRelatedExpenses'];
            $res1['EarninginForeignExchange'] = $res['EarninginForeignExchange'];
            $res1['OutgoinForeignExchange'] = $res['OutgoinForeignExchange'];
            $data_inner['plstandard'][] = $res1;
        }
    }
    
    //Balancesheet
    $Qry = mysql_query("SELECT * FROM balancesheet a INNER JOIN plstandard b ON a.FY = b.FY AND a.CID_FK = b.CID_FK WHERE a.CID_FK = '$cprofile_id' and b.ResultType='0' and a.ResultType='0' GROUP BY a.FY ORDER BY a.FY DESC LIMIT 0,100");
    if(mysql_num_rows($Qry) > 0){
        while($res = mysql_fetch_array($Qry)){
            $res1 = array();
            $res1['FY'] = $res['FY'];
            $res1['ShareCapital'] = $res['ShareCapital'];
            $res1['ShareApplication'] = $res['ShareApplication'];
            $res1['ReservesSurplus'] = $res['ReservesSurplus'];
            $res1['TotalFunds'] = $res['TotalFunds'];
            $res1['SecuredLoans'] = $res['SecuredLoans'];
            $res1['UnSecuredLoans'] = $res['UnSecuredLoans'];
            $res1['LoanFunds'] = $res['LoanFunds'];
            $res1['OtherLiabilities'] = $res['OtherLiabilities'];
            $res1['DeferredTax'] = $res['DeferredTax'];
            $res1['SourcesOfFunds'] = $res['SourcesOfFunds'];
            $res1['GrossBlock'] = $res['GrossBlock'];
            $res1['LessAccumulated'] = $res['LessAccumulated'];
            $res1['NetBlock'] = $res['NetBlock'];
            $res1['CapitalWork'] = $res['CapitalWork'];
            $res1['FixedAssets'] = $res['FixedAssets'];
            $res1['IntangibleAssets'] = $res['IntangibleAssets'];
            $res1['OtherNonCurrent'] = $res['OtherNonCurrent'];
            $res1['Investments'] = $res['Investments'];
            $res1['DeferredTaxAssets'] = $res['DeferredTaxAssets'];
            $res1['SundryDebtors'] = $res['SundryDebtors'];
            $res1['CashBankBalances'] = $res['CashBankBalances'];
            $res1['Inventories'] = $res['Inventories'];
            $res1['LoansAdvances'] = $res['LoansAdvances'];
            $res1['OtherCurrentAssets'] = $res['OtherCurrentAssets'];
            $res1['CurrentAssets'] = $res['CurrentAssets'];
            $res1['Provisions'] = $res['Provisions'];
            $res1['CurrentLiabilitiesProvision'] = $res['CurrentLiabilitiesProvision'];
            $res1['NetCurrentAssets'] = $res['NetCurrentAssets'];
            $res1['ProfitLoss'] = $res['ProfitLoss'];
            $res1['Miscellaneous'] = $res['Miscellaneous'];
            $res1['TotalAssets'] = $res['TotalAssets'];
            $res1['ResultType'] = $res['ResultType'];
            
            $data_inner['balancesheet'][] = $res1;            
        }
    }else{        
        $Qry = mysql_query("SELECT * FROM balancesheet a WHERE a.CID_FK = '$cprofile_id' and a.ResultType='0' ORDER BY a.FY DESC LIMIT 0,100");
        if(mysql_num_rows($Qry) > 0){
            while($res = mysql_fetch_array($Qry)){
                $res1 = array();
                $res1['FY'] = $res['FY'];
                $res1['ShareCapital'] = $res['ShareCapital'];
                $res1['ShareApplication'] = $res['ShareApplication'];
                $res1['ReservesSurplus'] = $res['ReservesSurplus'];
                $res1['TotalFunds'] = $res['TotalFunds'];
                $res1['SecuredLoans'] = $res['SecuredLoans'];
                $res1['UnSecuredLoans'] = $res['UnSecuredLoans'];
                $res1['LoanFunds'] = $res['LoanFunds'];
                $res1['OtherLiabilities'] = $res['OtherLiabilities'];
                $res1['DeferredTax'] = $res['DeferredTax'];
                $res1['SourcesOfFunds'] = $res['SourcesOfFunds'];
                $res1['GrossBlock'] = $res['GrossBlock'];
                $res1['LessAccumulated'] = $res['LessAccumulated'];
                $res1['NetBlock'] = $res['NetBlock'];
                $res1['CapitalWork'] = $res['CapitalWork'];
                $res1['FixedAssets'] = $res['FixedAssets'];
                $res1['IntangibleAssets'] = $res['IntangibleAssets'];
                $res1['OtherNonCurrent'] = $res['OtherNonCurrent'];
                $res1['Investments'] = $res['Investments'];
                $res1['DeferredTaxAssets'] = $res['DeferredTaxAssets'];
                $res1['SundryDebtors'] = $res['SundryDebtors'];
                $res1['CashBankBalances'] = $res['CashBankBalances'];
                $res1['Inventories'] = $res['Inventories'];
                $res1['LoansAdvances'] = $res['LoansAdvances'];
                $res1['OtherCurrentAssets'] = $res['OtherCurrentAssets'];
                $res1['CurrentAssets'] = $res['CurrentAssets'];
                $res1['Provisions'] = $res['Provisions'];
                $res1['CurrentLiabilitiesProvision'] = $res['CurrentLiabilitiesProvision'];
                $res1['NetCurrentAssets'] = $res['NetCurrentAssets'];
                $res1['ProfitLoss'] = $res['ProfitLoss'];
                $res1['Miscellaneous'] = $res['Miscellaneous'];
                $res1['TotalAssets'] = $res['TotalAssets'];
                $res1['ResultType'] = $res['ResultType'];
                $data_inner['balancesheet'][] = $res1;
            }
        }        
    }
    //Ratio with Balancesheet
    $Qry = mysql_query("select * from plstandard a INNER JOIN balancesheet b ON a.FY = b.FY AND a.CID_FK = b.CID_FK where a.CID_FK = '$cprofile_id' and a.ResultType='0' GROUP BY a.FY ORDER BY a.FY DESC");
    if(mysql_num_rows($Qry) > 0){
    }else{
        $Qry = mysql_query("select * from balancesheet CID_FK = '$cprofile_id' and ResultType='0' FY DESC");
    }
    if(mysql_num_rows($Qry) > 0){
        while($res = mysql_fetch_array($Qry)){
            $ratio_cal['FY'] =$res['FY'];
            
            $x=$res['CurrentAssets'];  
            $a=$res['CurrentLiabilitiesProvision'];
            $equation=$x/$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['CurrentRatio'] = $equation1;
            
            $x=$res['CurrentAssets'];  
            $y = $res['Inventories'];
            $a=$res['CurrentLiabilitiesProvision'];
            $equation=($x-$y)/$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['QuickRatio'] = $equation1;
            
            $x=$res['PAT'];  
            $a=$res['TotalFunds'];
            $equation=$x/$a; if($equation !='') { 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['RoE'] = $equation1;
            }
            
            $x=$res['PAT'];  
            $a=$res['TotalAssets'];
            $equation=$x/$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['RoA'] = $equation1;
            
            $x=$res['EBITDA'];  
            $y = $res['TotalIncome'];
            $a=100;
            $equation=($x/$y)*$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['EBITDAMargin'] = $equation1.'%';
            
            $x=$res['PAT'];  
            $y = $res['TotalIncome'];
            $a=100;
            $equation=($x/$y)*$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['PATMargin'] = $equation1.'%';
            $data_inner['ratio_balancesheet'][] = $ratio_cal;            
        }
    }
    //Balancesheet New
    $Qry = mysql_query("SELECT * FROM balancesheet_new a INNER JOIN plstandard b ON a.FY = b.FY AND a.CID_FK = b.CID_FK WHERE a.CID_FK = '$cprofile_id' and b.ResultType='0' and a.ResultType='0' GROUP BY a.FY ORDER BY a.FY DESC LIMIT 0,100");
    if(mysql_num_rows($Qry) > 0){
        while($res = mysql_fetch_array($Qry)){
            $res1 = array();
            $res1['FY'] = $res['FY'];
            $res1['ShareCapital'] = $res['ShareCapital'];
            $res1['ReservesSurplus'] = $res['ReservesSurplus'];
            $res1['TotalFunds'] = $res['TotalFunds'];
            $res1['ShareApplication'] = $res['ShareApplication'];
            $res1['L_term_borrowings'] = $res['L_term_borrowings'];
            $res1['deferred_tax_liabilities'] = $res['deferred_tax_liabilities'];
            $res1['O_long_term_liabilities'] = $res['O_long_term_liabilities'];
            $res1['L_term_provisions'] = $res['L_term_provisions']; 
            $res1['T_non_current_liabilities'] = $res['T_non_current_liabilities'];
            $res1['S_term_borrowings'] = $res['S_term_borrowings'];
            $res1['Trade_payables'] = $res['Trade_payables'];
            $res1['O_current_liabilities'] = $res['O_current_liabilities'];
            $res1['S_term_provisions'] = $res['S_term_provisions'];
            $res1['T_current_liabilities'] = $res['T_current_liabilities'];
            $res1['T_equity_liabilities'] = $res['T_equity_liabilities'];
            $res1['Tangible_assets'] = $res['Tangible_assets'];     
            $res1['Intangible_assets'] = $res['Intangible_assets'];
            $res1['T_fixed_assets'] = $res['T_fixed_assets'];
            $res1['N_current_investments'] = $res['N_current_investments'];
            $res1['Deferred_tax_assets'] = $res['Deferred_tax_assets'];
            $res1['L_term_loans_advances'] = $res['L_term_loans_advances'];
            $res1['O_non_current_assets'] = $res['O_non_current_assets'];
            $res1['T_non_current_assets'] = $res['T_non_current_assets'];
            $res1['Current_investments'] = $res['Current_investments'];
            
            $res1['Inventories'] = $res['Inventories'];
            $res1['Trade_receivables'] = $res['Trade_receivables'];
            $res1['Cash_bank_balances'] = $res['Cash_bank_balances'];
            $res1['S_term_loans_advances'] = $res['S_term_loans_advances'];
            $res1['O_current_assets'] = $res['O_current_assets'];
            $res1['T_current_assets'] = $res['T_current_assets'];
            $res1['Total_assets'] = $res['Total_assets'];
            $data_inner['balancesheet_new'][] = $res1;
        }
    }else{        
        $Qry = mysql_query("SELECT * FROM balancesheet_new a WHERE a.CID_FK = '$cprofile_id' and a.ResultType='0' ORDER BY a.FY DESC LIMIT 0,100");
        if(mysql_num_rows($Qry) > 0){
            while($res = mysql_fetch_array($Qry)){
                $res1 = array();
                $res1['FY'] = $res['FY'];
            $res1['ShareCapital'] = $res['ShareCapital'];
            $res1['ReservesSurplus'] = $res['ReservesSurplus'];
            $res1['TotalFunds'] = $res['TotalFunds'];
            $res1['ShareApplication'] = $res['ShareApplication'];
            $res1['L_term_borrowings'] = $res['L_term_borrowings'];
            $res1['deferred_tax_liabilities'] = $res['deferred_tax_liabilities'];
            $res1['O_long_term_liabilities'] = $res['O_long_term_liabilities'];
            $res1['L_term_provisions'] = $res['L_term_provisions']; 
            $res1['T_non_current_liabilities'] = $res['T_non_current_liabilities'];
            $res1['S_term_borrowings'] = $res['S_term_borrowings'];
            $res1['Trade_payables'] = $res['Trade_payables'];
            $res1['O_current_liabilities'] = $res['O_current_liabilities'];
            $res1['S_term_provisions'] = $res['S_term_provisions'];
            $res1['T_current_liabilities'] = $res['T_current_liabilities'];
            $res1['T_equity_liabilities'] = $res['T_equity_liabilities'];
            $res1['Tangible_assets'] = $res['Tangible_assets'];     
            $res1['Intangible_assets'] = $res['Intangible_assets'];
            $res1['T_fixed_assets'] = $res['T_fixed_assets'];
            $res1['N_current_investments'] = $res['N_current_investments'];
            $res1['Deferred_tax_assets'] = $res['Deferred_tax_assets'];
            $res1['L_term_loans_advances'] = $res['L_term_loans_advances'];
            $res1['O_non_current_assets'] = $res['O_non_current_assets'];
            $res1['T_non_current_assets'] = $res['T_non_current_assets'];
            $res1['Current_investments'] = $res['Current_investments'];
            
            $res1['Inventories'] = $res['Inventories'];
            $res1['Trade_receivables'] = $res['Trade_receivables'];
            $res1['Cash_bank_balances'] = $res['Cash_bank_balances'];
            $res1['S_term_loans_advances'] = $res['S_term_loans_advances'];
            $res1['O_current_assets'] = $res['O_current_assets'];
            $res1['T_current_assets'] = $res['T_current_assets'];
            $res1['Total_assets'] = $res['Total_assets'];
                $data_inner['balancesheet_new'][] = $res1;
            }
        }        
    }
    //Ratio with Balancesheet new    
    $Qry = mysql_query("select * from plstandard a INNER JOIN balancesheet_new b ON a.FY = b.FY AND a.CID_FK = b.CID_FK where a.CID_FK = '$cprofile_id' and a.ResultType='0'  GROUP BY a.FY ORDER BY a.FY DESC");
    if(mysql_num_rows($Qry) > 0){
    }else{
        $Qry = mysql_query("select * from balancesheet_new CID_FK = '$cprofile_id' and ResultType='0' FY DESC");
    }
    if(mysql_num_rows($Qry) > 0){
        while($res = mysql_fetch_array($Qry)){
            $ratio_cal['FY'] =$res['FY'];
            
            $x=$res['T_current_assets'];  
            $a=$res['T_current_liabilities'];
            $equation=$x/$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['CurrentRatio'] = $equation1;
            
            $x=$res['T_current_assets'];  
            $y = $res['Inventories'];
            $a=$res['T_current_liabilities'];
            $equation=($x-$y)/$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['QuickRatio'] = $equation1;
            
            $x=$res['PAT'];  
            $a=$res['TotalFunds'];
            $equation=$x/$a; if($equation !='') { 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['RoE'] = $equation1;
            }
            
            $x=$res['PAT'];  
            $a=$res['Total_assets'];
            $equation=$x/$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['RoA'] = $equation1;
            
            $x=$res['EBITDA'];  
            $y = $res['TotalIncome'];
            $a=100;
            $equation=($x/$y)*$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['EBITDAMargin'] = $equation1.'%';
            
            $x=$res['PAT'];  
            $y = $res['TotalIncome'];
            $a=100;
            $equation=($x/$y)*$a; 
            $equation1 = sprintf("%.2f",$equation);
            $ratio_cal['PATMargin'] = $equation1.'%';
            $data_inner['ratio_balancesheet_new'][] = $ratio_cal;            
        }
    }
    
    //    Excel files
    // Plstandard Standalone
    if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'.xls')){
        $data_inner['PLExport']['Standalone'] = MEDIA_PATH.'plstandard/PLStandard_'.$cprofile_id.'.xls';
    }
    if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_1.xls')){
        $data_inner['PLExport']['Consolidated'] = MEDIA_PATH.'plstandard/PLStandard_'.$cprofile_id.'_1.xls';
    }
    if(file_exists(FOLDER_CREATE_PATH.'pldetailed/PLDetailed_'.$cprofile_id.'.xls')){
        $data_inner['DetailedPLExport'] = MEDIA_PATH.'pldetailed/PLDetailed_'.$cprofile_id.'.xls';
    }
    if(file_exists(FOLDER_CREATE_PATH.'balancesheet/BalSheet_'.$cprofile_id.'.xls')){
        $data_inner['BSheetExport']['Standalone'] = MEDIA_PATH.'balancesheet/BalSheet_'.$cprofile_id.'.xls';
    }
    if(file_exists(FOLDER_CREATE_PATH.'balancesheet/BalSheet_'.$cprofile_id.'_1.xls')){
        $data_inner['BSheetExport']['Consolidated'] = MEDIA_PATH.'balancesheet/BalSheet_'.$cprofile_id.'_1.xls';
    }
    if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'.xls')){
        $data_inner['BSheetNewExport']['Standalone'] = MEDIA_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'.xls';
    }
    if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_1.xls')){
        $data_inner['BSheetNewExport']['Consolidated'] = MEDIA_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_1.xls';
    }

    if(file_exists(FOLDER_CREATE_PATH.'cashflow/Cashflow_'.$cprofile_id.'.xls')){
        $data_inner['CashFlowExport'] = MEDIA_PATH.'cashflow/Cashflow_'.$cprofile_id.'.xls';
    }
    
    $data['Financials'] = $data_inner;
    //Company profile details
    $cin_check = mysql_query("SELECT * FROM cprofile LEFT JOIN industries b on(Industry = b.Industry_Id) INNER JOIN countries c on(Country = c.Country_Id) INNER JOIN city d on(City = d.city_id) INNER JOIN state e on(State = e.state_id) LEFT JOIN sectors f on(Sector = f.Sector_Id) WHERE Company_Id = '$cprofile_id'" );
    $cin_check_count = mysql_num_rows($cin_check);
    $cin_res = mysql_fetch_array($cin_check);
    $companyProfile['Industry'] = $cin_res['IndustryName'];
    $ListingStatus = $cin_res['ListingStatus'];
    if ($ListingStatus == '0'){
        $Status = "Both";
    }else if ($ListingStatus == '1'){
        $Status = "Listed";
    }else if ($ListingStatus == '2'){
        $Status = "Privately held(Ltd)";
    }else if ($ListingStatus == '3'){
        $Status = "Partnership";
    }else if ($ListingStatus == '4'){
        $Status = "Proprietorship";
    }
    $companyProfile['Status'] = $Status;
    
    $Permissions1 = $cin_res['Permissions1'];
    if ($Permissions1 == '0'){
        $Status1 = "Transacted";
    }else if ($Permissions1 == '1'){
        $Status1 = "Non Transacted";
    }else if ($Permissions1 == '2'){
        $Status1 = "Non-Transacted  and Fund Raising";
    }
    $companyProfile['TransactionStatus'] = $Status1;
    $companyProfile['Address'] = $cin_res['AddressHead'];
    $companyProfile['Telephone'] = $cin_res['Phone'];
    $companyProfile['Sector'] = $cin_res['SectorName'];
    $companyProfile['City'] = $cin_res['city_name'];
    $companyProfile['Email'] = $cin_res['Email'];    
    $companyProfile['ContactName'] = $cin_res['CEO'];
    $companyProfile['Designation'] = $cin_res['CFO'];
    $companyProfile['YearFounded'] = $cin_res['IncorpYear'];
    $companyProfile['Country'] = $cin_res['Country_Name'];
    $companyProfile['Website'] = $cin_res['Website'];
    $companyProfile['LinkedIn'] = $cin_res['LinkedIn'];
    $data['CompanyProfile'] = $companyProfile;
   
    
    $fields = "Company_Id,FCompanyName,state_name";
    $where = " Industry_Id= ".$cin_res['Industry'];
    $order="FCompanyName";
    $sql = "SELECT ".$fields." FROM cprofile ";
    $sql.= " INNER JOIN industries b on(Industry = b.Industry_Id) ";
    $sql.= " INNER JOIN countries c on(Country = c.Country_Id) ";
    $sql.= " INNER JOIN city d on(City = d.city_id) ";
    $sql.= " INNER JOIN state e on(	State = e.state_id) ";
    $sql.= " INNER JOIN sectors f on(Sector  = f.Sector_Id) ";
    if(strlen($where)) $sql.= " WHERE ".$where;
    if(strlen($order))   $sql.= " ORDER BY ".$order;
    $sql.= " LIMIT  5";
    $sim_qry = mysql_query($sql);
    $sim_array = array();
    $cont=0;
     while($res = mysql_fetch_array($sim_qry)){
            $sim_array[$cont]['Company_Id']=$res['Company_Id'];
            $sim_array[$cont]['CompanyName']=$res['FCompanyName'];
            $sim_array[$cont]['state']=$res['state_name'];
         $cont++;
     }
 $data['similar_companies'] = $sim_array;
    //MCA - Company profile
//    try{ 
//    //Data from MCA website 
//    $urltopost = "http://www.mca.gov.in/mcafoportal/companyLLPMasterData.do";
//    $datatopost = array ("companyID" => $cin);
//     $ch = curl_init ($urltopost);
//    curl_setopt ($ch, CURLOPT_POST, true);
//    curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
//    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
//    if(curl_exec($ch) !== false)
//    {
//     $returndata = curl_exec ($ch); 
//
//    curl_close($ch);
//    $LLPMaster = str_get_html($returndata);
//    $LLPMasterForm = $LLPMaster->find('form[id=exportCompanyMasterData]', 0);
//
//    $LLPMasterProfile = $LLPMaster->find('div[id=companyMasterData]', 0);
//    $LLPMasterSignatories = $LLPMaster->find('div[id=signatories]', 0);
//    $LLPMasterFormSubmit = $LLPMaster->find('input[id=exportCompanyMasterData_0]', 0);
//    $LLPMasterFormAltScheme = $LLPMaster->find('input[id=altScheme]', 0);
//    $LLPMasterFormExportCompanyMasterData_companyID = $LLPMaster->find('input[id=exportCompanyMasterData_companyID]', 0);
//    $LLPMasterFormExportCompanyMasterData_companyName = $LLPMaster->find('input[id=exportCompanyMasterData_companyName]', 0);
//
//    /*$template->assign("LLPMasterForm",$LLPMasterForm);
//    $template->assign("LLPMasterProfile",$LLPMasterProfile);
//    $template->assign("LLPMasterSignatories",$LLPMasterSignatories);
//    $template->assign("LLPMasterFormSubmit",$LLPMasterFormSubmit);
//    $template->assign("LLPMasterFormAltScheme",$LLPMasterFormAltScheme);
//    $template->assign("LLPMasterFormExportCompanyMasterData_companyID",$LLPMasterFormExportCompanyMasterData_companyID);
//    $template->assign("LLPMasterFormExportCompanyMasterData_companyName",$LLPMasterFormExportCompanyMasterData_companyName);*/
//
//    }
//    
//    //Index of charges tata from MCA website 
//    $urltopost = "http://www.mca.gov.in/mcafoportal/viewIndexOfCharges.do";
//    $datatopost = array ("companyID" => $cin);
//     $ch = curl_init ($urltopost);
//    curl_setopt ($ch, CURLOPT_POST, true);
//    curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
//    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
//    if(curl_exec($ch) !== false)
//    {
//    $returndata = curl_exec ($ch);
//
//    curl_close($ch);
//
//    $LLPMasterCharges = str_get_html($returndata);
//    $LLPMasterCharges = $LLPMasterCharges->find('table[id=charges]', 0);
//
//    $template->assign("LLPMasterCharges",$LLPMasterCharges);
//    }
//}  catch (Exception $e) {
//    echo $e;
//}
    //Filings
    
  /*  if ($_POST && isset($_POST["Month1"])) {

            // when date range is used
            $dateFrom = date_parse_from_format("jnY","1/" .$_POST["Month1"] ."/" .$_POST["Year1"] );	// d/m/y
            $dateTo = date_parse_from_format("jnY","1/" .$_POST["Month2"] ."/" .$_POST["Year2"] );	// d/m/y

    }

    require_once MAIN_PATH.APP_NAME."/aws.php";	// load logins
    require_once('aws.phar');

    require_once('aws.phar');
    //use Aws\S3\S3Client;

    $client = S3Client::factory(array(
        'key'    => $GLOBALS['key'],
        'secret' => $GLOBALS['secret']
    ));

    $bucket = $GLOBALS['bucket'];

    $iterator = $client->getIterator('ListObjects', array(
        'Bucket' => $bucket,
        'Prefix' => $GLOBALS['root'].$c
    ));

    $c1=$c2=0;
    $items = array();

    //$valCount = count(iterator_to_array($iterator));
    try{

    echo    $valCount = iterator_count($iterator);
    }catch(Exception $e){}

    if($valCount > 0)
    {
        //Echo '<OL>';
        foreach ($iterator as $object) 
        {
        //echo $object['Key'] . "<br>";
            $fileName =  $object['Key'];

                // Get a pre-signed URL for an Amazon S3 object
            $signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');
            // > https://my-bucket.s3.amazonaws.com/data.txt?AWSAccessKeyId=[...]&Expires=[...]&Signature=[...]


            $pieces = explode("/", $fileName);
            $pieces = $pieces[ sizeof($pieces) - 1 ];

            $fileNameExt = $pieces;
            //$ext = ".pdf";

            $ex_ext = explode(".", $fileName);
            $ext = $ex_ext[count($ex_ext)-1];

            // ----------------------------------
            // test if the word ends with '.pdf'
            if ( strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt) ){
                    //echo "<BR>EXT";
                    continue;
                    }
            // ----------------------------------

            $c1 = $c1 + 1;

            // ----------------------------------------------
            // detect date pattern from filename

            $string = "/\d{6,6}/";

            $paragraph = $fileNameExt;

            if (preg_match_all($string, $paragraph, $matches)) {
              //echo count($matches[0])  // Total size

            $dateFileName = $matches[0][ count($matches[0]) -1 ];	// get match from Right
            //echo $dateFileName .'<br>';

            $d = substr($dateFileName, 0, 2);
            $m = substr($dateFileName, 2, 2);
            $y = substr($dateFileName, 4, 2);

            if( intval($y) <30)	$y = (2000+ intval($y));
            else $y = (1900+ intval($y));

            //print_r( date_parse_from_format("jnY", $d. $m. $y) );
            $dateFileName= date_parse_from_format("jnY", $d. $m. $y);

            //print_r($dateFileName);

            // if date out of range

            if ($_POST && isset($_POST["Month1"]))
                    if($dateFileName < $dateFrom || $dateFileName > $dateTo)
                            {
                            //echo "<BR>SKIPPED" . $dateFrom ."  " .$dateFrom;
                            continue;
                            }

            } // end of match
            // ----------------------------------------------

            $c2 = $c2 + 1;

            $str = "<li> <a href='". $signedUrl ."' target='_blank' >".  $pieces ."</a>&nbsp&nbsp&nbsp" .$object['Size'] ."</li><BR>";
            //echo $str;

            $str = "<a href='". $signedUrl ."' target='_blank'  >".  $pieces ."</a>&nbsp&nbsp&nbsp" .$object['Size'];
            //array_push($items, $str);

            array_push($items, array('name'=>$str,'uploaddate'=>($d."-".$m.'-'.$y)) );

        }	// foreach

    }
    $result = $c2. " of ". $c1;
    $data['Filings'] = $items;
    */
    
    //REGISTERED
    $con1 = mysql_connect("localhost","venture_cpslogin","Cps$2010",true) or die(mysql_error());
    if (!$con1)
    {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db("venture_cps", $con1);

    $result = mysql_query("SELECT * FROM cin_detail where CIN = '$cin' limit 0,1", $con1);
    $row = mysql_fetch_assoc($result);        
   $rocdetail=$row['ROC Code'];
   if($rocdetail !=''){
        $data["REGISTERED"] = $rocdetail;
   }  
   echo '<pre>';
   print_r($data);
    //echo json_encode($data);
}

mysql_close(); ?>