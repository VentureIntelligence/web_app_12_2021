<?php
ob_start();
//if(!isset($_SESSION)){
//    session_save_path("/tmp");
//    session_start();
//}
include("etc/conf.php");
include("path_Assign.php");
require_once MAIN_PATH.APP_NAME."/aws.php";	// load logins
require_once('aws.phar');

require_once MODULES_DIR."users.php";
$users = new users();

require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
use Aws\S3\S3Client;

//Username, password and ip checking
$username = $_POST["username"];
$password = $_POST["password"];

$Rs = $users->selectByUsernameNew($username,$password);
$success = $failure = '';
if(($username =='') || ($password =='')){
    
    $data['Status'] = "Failure";
    $data['Result'] = "Invalid username or password";
    echo json_encode($data);
    
}
elseif(($username !='') && ($password !='')){
   
	$authAdmin = $users->selectByUName($username);
	$UName = $authAdmin['username'];
	$Pwd = $authAdmin['user_password'];
        $groupstatus = $grouplist->select($authAdmin['GroupList']);
}

if($username == $UName && md5($password) == $Pwd && $username != "" && $_POST['password'] !="" && $authAdmin['usr_flag'] != 0 && $groupstatus['status']==0){
    
        $processLoginFlag = 0;

        $groupId = $authAdmin['GroupList'];
        $groupIp = $grouplist->getGroupIP($groupId);
        
        $groupPocArray = $grouplist->getGroupEmail($groupId);
        $groupPoc = $groupPocArray['poc'];
       
        if (count($groupIp) > 0){ //Process IP Restriction only if user has IP addeded to account

                if (checkIpRange($_SERVER['REMOTE_ADDR'],$groupId)){ //Check if users Ip falls within the range
                    $processLoginFlag = 1;

                }else{
                    
                     $data['Status'] = "Failure";
                    $data['Result'] = "Login Error - Device not authorized. Please contact Admin";
                    echo json_encode($data);
                }
           
        }else{
            $processLoginFlag = 1;
            
        }
        
        //END
    
        if ($processLoginFlag == 1){
            
            $dbhost = "localhost";
            $dbuser = "venture_admin16";
            $dbpassword = "V@dm!n2016";
            $dbname = "venture_peinvestments";
            $dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
                or die("Unable to connect to MySQL");
            $selected = mysql_select_db($dbname,$dbhandle) 
                or die("Database could not select");
                
            if(isset($_REQUEST['cin']) && $_REQUEST['cin'] !=''){
                   // $cin = base64_decode($_REQUEST['cin']);
                    $cin = $_REQUEST['cin'];
                    $cin_check = mysql_query("SELECT * FROM cprofile WHERE CIN='$cin'" );
                    $cin_check_count = mysql_num_rows($cin_check);
                    $cin_res = mysql_fetch_array($cin_check);
                    $cprofile_id = $cin_res['Company_Id'];
                    $data_inner = array();
                    if($cprofile_id != ''){
                        
                        $datas['Status'] = "Success";
                        
                        $data['companyName'] = $cin_res['SCompanyName'];
                        $c = $cin_res['FCompanyName'];
                        //PL Stranded
                        $res1 = array();
                        $PLStsQry = mysql_query("SELECT PLStandard_Id,CId_FK,IndustryId_FK,OptnlIncome,OtherIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,FY,TotalIncome,BINR,DINR,EmployeeRelatedExpenses,ForeignExchangeEarningandOutgo,EarninginForeignExchange,OutgoinForeignExchange FROM plstandard WHERE CId_FK = '$cprofile_id' and FY !='' and ResultType='0' ORDER BY FY DESC LIMIT 0,100");
                        if(mysql_num_rows($PLStsQry) > 0){
                            while($res = mysql_fetch_array($PLStsQry)){
                                $res1 = array();
                                $res1['PLStandard_Id'] = trim($res['PLStandard_Id']);
                                $res1['CId_FK'] = trim($res['CId_FK']);
                                $res1['IndustryId_FK'] = trim($res['IndustryId_FK']);
                                $res1['OptnlIncome'] = trim($res['OptnlIncome']);
                                $res1['OtherIncome'] = trim($res['OtherIncome']);
                                $res1['OptnlAdminandOthrExp'] = trim($res['OptnlAdminandOthrExp']);
                                $res1['OptnlProfit'] = trim($res['OptnlProfit']);
                                $res1['EBITDA'] = trim($res['EBITDA']);
                                $res1['Interest'] = trim($res['Interest']);
                                $res1['EBDT'] = trim($res['EBDT']);
                                $res1['Depreciation'] = trim($res['Depreciation']);
                                $res1['EBT'] = trim($res['EBT']);
                                $res1['Tax'] = trim($res['Tax']);
                                $res1['PAT'] = trim($res['PAT']);
                                $res1['FY'] = trim($res['FY']);
                                $res1['TotalIncome'] = trim($res['TotalIncome']);
                                $res1['BINR'] = trim($res['BINR']);
                                $res1['DINR'] = trim($res['DINR']);
                                /*$res1['EmployeeRelatedExpenses'] = $res['EmployeeRelatedExpenses'];
                                $res1['EarninginForeignExchange'] = $res['EarninginForeignExchange'];
                                $res1['OutgoinForeignExchange'] = $res['OutgoinForeignExchange'];*/
                                if($res['EmployeeRelatedExpenses']!= ""){
                                    $EmployeeRelatedExpenses1 = trim($res['EmployeeRelatedExpenses']);
                                }else{
                                    $EmployeeRelatedExpenses1 = "0";
                                }
                                $res1['EmployeeRelatedExpenses'] = $EmployeeRelatedExpenses1;

                                if($res['EarninginForeignExchange']!= ""){
                                    $EarninginForeignExchange1 = trim($res['EarninginForeignExchange']);
                                }else{
                                    $EarninginForeignExchange1 = "0";
                                }
                                $res1['EarninginForeignExchange'] = $EarninginForeignExchange1;

                                if($res['OutgoinForeignExchange']!= ""){
                                    $OutgoinForeignExchange1 = trim($res['OutgoinForeignExchange']);
                                }else{
                                    $OutgoinForeignExchange1 = "0";
                                }
                                $res1['OutgoinForeignExchange'] = $OutgoinForeignExchange1;
                                
                                if(!empty($res1)){
                                    
                                    $data_inner['plstandard'][] = $res1;
                                }else{
                                    $data_inner['plstandard'][] = "";
                                }
                                
                            }
                        }
                    
                        $growth = array();
                            $max_pls=mysql_query("SELECT min(FY) as FY FROM plstandard WHERE CId_FK='".$cprofile_id."'");
                            $max_pl = mysql_fetch_array($max_pls);

                            $GrowthQry = mysql_query("SELECT g.GrowthPerc_Id,g.CId_FK,g.IndustryId_FK,g.OptnlIncome,g.OtherIncome,g.OptnlAdminandOthrExp,g.OptnlProfit,g.EBITDA,g.Interest,g.EBDT,g.Depreciation,g.EBT,g.Tax,g.PAT,g.FY,g.TotalIncome,g.BINR,g.DINR,g.EmployeeRelatedExpenses,g.ForeignExchangeEarningandOutgo,g.EarninginForeignExchange,g.OutgoinForeignExchange FROM growthpercentage as g 
                                    INNER JOIN plstandard p on(g.CId_FK = p.CId_FK)  WHERE p.CId_FK = ".$cprofile_id." and p.FY !='' and p.FY=g.FY and g.FY > '".$max_pl['FY']."' and p.ResultType='0' ORDER BY FY DESC LIMIT 0,100");
                            //$PLStsQry = mysql_query("SELECT PLStandard_Id,CId_FK,IndustryId_FK,OptnlIncome,OtherIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,FY,TotalIncome,BINR,DINR,EmployeeRelatedExpenses,ForeignExchangeEarningandOutgo,EarninginForeignExchange,OutgoinForeignExchange FROM plstandard WHERE CId_FK = '$cprofile_id' and FY !='' and ResultType='0' ORDER BY FY DESC LIMIT 0,100");
                            if(mysql_num_rows($GrowthQry) > 0){
                                while($gres = mysql_fetch_array($GrowthQry)){
                                    $growth = array();
                                    $growth['PLStandard_Id'] = trim($gres['GrowthPerc_Id']);
                                    $growth['CId_FK'] = trim($gres['CId_FK']);
                                    $growth['IndustryId_FK'] = trim($gres['IndustryId_FK']);
                                    $growth['OptnlIncome'] = trim($gres['OptnlIncome']);
                                    $growth['OtherIncome'] = trim($gres['OtherIncome']);
                                    $growth['OptnlAdminandOthrExp'] = trim($gres['OptnlAdminandOthrExp']);
                                    $growth['OptnlProfit'] = trim($gres['OptnlProfit']);
                                    $growth['EBITDA'] = trim($gres['EBITDA']);
                                    $growth['Interest'] = trim($gres['Interest']);
                                    $growth['EBDT'] = trim($gres['EBDT']);
                                    $growth['Depreciation'] = trim($gres['Depreciation']);
                                    $growth['EBT'] = trim($gres['EBT']);
                                    $growth['Tax'] = trim($gres['Tax']);
                                    $growth['PAT'] = trim($gres['PAT']);
                                    $growth['FY'] = trim($gres['FY']);
                                    $growth['TotalIncome'] = trim($gres['TotalIncome']);
                                    $growth['BINR'] = trim($gres['BINR']);
                                    $growth['DINR'] = trim($gres['DINR']);
                                   /* $growth['EmployeeRelatedExpenses'] = $gres['EmployeeRelatedExpenses'];
                                    $growth['EarninginForeignExchange'] = $gres['EarninginForeignExchange'];
                                    $growth['OutgoinForeignExchange'] = $gres['OutgoinForeignExchange'];*/
                                    if($gres['EmployeeRelatedExpenses']!= ''){
                                        $EmployeeRelatedExpenses = trim($gres['EmployeeRelatedExpenses']);
                                    }else{
                                        $EmployeeRelatedExpenses = "0";
                                    }
                                    $growth['EmployeeRelatedExpenses'] = $EmployeeRelatedExpenses;

                                    if($gres['EarninginForeignExchange']!= ''){
                                         $EarninginForeignExchange = trim($gres['EarninginForeignExchange']);
                                    }else{
                                         $EarninginForeignExchange = "0";
                                    }
                                    $growth['EarninginForeignExchange'] = $EarninginForeignExchange;

                                    if($gres['OutgoinForeignExchange']!= ''){
                                        $OutgoinForeignExchange = trim($gres['OutgoinForeignExchange']);
                                    }else{
                                        $OutgoinForeignExchange = "0";
                                    }
                                    $growth['OutgoinForeignExchange'] = $OutgoinForeignExchange;
                                    
                                    if(!empty($growth)){
                                    
                                        $data_inner['growthPercentage'][] = $growth;
                                    }else{
                                        $data_inner['growthPercentage'][] = "";
                                    }
                                }
                            }
                            //Balancesheet
                            $Qry = mysql_query("SELECT * FROM balancesheet a INNER JOIN plstandard b ON a.FY = b.FY AND a.CID_FK = b.CID_FK WHERE a.CID_FK = '$cprofile_id' and b.ResultType='0' and a.ResultType='0' GROUP BY a.FY ORDER BY a.FY DESC LIMIT 0,100");
                            if(mysql_num_rows($Qry) > 0){
                                while($res = mysql_fetch_array($Qry)){
                                    $res1 = array();
                                    $res1['FY'] = trim($res['FY']);
                                    $res1['ShareCapital'] = trim($res['ShareCapital']);
                                    $res1['ShareApplication'] = trim($res['ShareApplication']);
                                    $res1['ReservesSurplus'] = trim($res['ReservesSurplus']);
                                    $res1['TotalFunds'] = trim($res['TotalFunds']);
                                    $res1['SecuredLoans'] = trim($res['SecuredLoans']);
                                    $res1['UnSecuredLoans'] = trim($res['UnSecuredLoans']);
                                    $res1['LoanFunds'] = trim($res['LoanFunds']);
                                    $res1['OtherLiabilities'] = trim($res['OtherLiabilities']);
                                    $res1['DeferredTax'] = trim($res['DeferredTax']);
                                    $res1['SourcesOfFunds'] = trim($res['SourcesOfFunds']);
                                    $res1['GrossBlock'] = trim($res['GrossBlock']);
                                    $res1['LessAccumulated'] = trim($res['LessAccumulated']);
                                    $res1['NetBlock'] = trim($res['NetBlock']);
                                    $res1['CapitalWork'] = trim($res['CapitalWork']);
                                    $res1['FixedAssets'] = trim($res['FixedAssets']);
                                    $res1['IntangibleAssets'] = trim($res['IntangibleAssets']);
                                    $res1['OtherNonCurrent'] = trim($res['OtherNonCurrent']);
                                    $res1['Investments'] = trim($res['Investments']);
                                    $res1['DeferredTaxAssets'] = trim($res['DeferredTaxAssets']);
                                    $res1['SundryDebtors'] = trim($res['SundryDebtors']);
                                    $res1['CashBankBalances'] = trim($res['CashBankBalances']);
                                    $res1['Inventories'] = trim($res['Inventories']);
                                    $res1['LoansAdvances'] = trim($res['LoansAdvances']);
                                    $res1['OtherCurrentAssets'] = trim($res['OtherCurrentAssets']);
                                    $res1['CurrentAssets'] = trim($res['CurrentAssets']);
                                    $res1['Provisions'] = trim($res['Provisions']);
                                    $res1['CurrentLiabilitiesProvision'] = trim($res['CurrentLiabilitiesProvision']);
                                    $res1['NetCurrentAssets'] = trim($res['NetCurrentAssets']);
                                    $res1['ProfitLoss'] = trim($res['ProfitLoss']);
                                    $res1['Miscellaneous'] = trim($res['Miscellaneous']);
                                    $res1['TotalAssets'] = trim($res['TotalAssets']);
                                    $res1['ResultType'] = trim($res['ResultType']);
  
                                    if(!empty($res1)){
                                    
                                        $data_inner['balancesheet'][] = $res1;
                                    }else{
                                        $data_inner['balancesheet'][] = "";
                                    }
                                }
                            }else{        
                                $Qry = mysql_query("SELECT * FROM balancesheet a WHERE a.CID_FK = '$cprofile_id' and a.ResultType='0' ORDER BY a.FY DESC LIMIT 0,100");
                                if(mysql_num_rows($Qry) > 0){
                                    while($res = mysql_fetch_array($Qry)){
                                        $res1 = array();
                                        $res1['FY'] = trim($res['FY']);
                                        $res1['ShareCapital'] = trim($res['ShareCapital']);
                                        $res1['ShareApplication'] = trim($res['ShareApplication']);
                                        $res1['ReservesSurplus'] = trim($res['ReservesSurplus']);
                                        $res1['TotalFunds'] = trim($res['TotalFunds']);
                                        $res1['SecuredLoans'] = trim($res['SecuredLoans']);
                                        $res1['UnSecuredLoans'] = trim($res['UnSecuredLoans']);
                                        $res1['LoanFunds'] = trim($res['LoanFunds']);
                                        $res1['OtherLiabilities'] = trim($res['OtherLiabilities']);
                                        $res1['DeferredTax'] = trim($res['DeferredTax']);
                                        $res1['SourcesOfFunds'] = trim($res['SourcesOfFunds']);
                                        $res1['GrossBlock'] = trim($res['GrossBlock']);
                                        $res1['LessAccumulated'] = trim($res['LessAccumulated']);
                                        $res1['NetBlock'] = trim($res['NetBlock']);
                                        $res1['CapitalWork'] = trim($res['CapitalWork']);
                                        $res1['FixedAssets'] = trim($res['FixedAssets']);
                                        $res1['IntangibleAssets'] = trim($res['IntangibleAssets']);
                                        $res1['OtherNonCurrent'] = trim($res['OtherNonCurrent']);
                                        $res1['Investments'] = trim($res['Investments']);
                                        $res1['DeferredTaxAssets'] = trim($res['DeferredTaxAssets']);
                                        $res1['SundryDebtors'] = trim($res['SundryDebtors']);
                                        $res1['CashBankBalances'] = trim($res['CashBankBalances']);
                                        $res1['Inventories'] = trim($res['Inventories']);
                                        $res1['LoansAdvances'] = trim($res['LoansAdvances']);
                                        $res1['OtherCurrentAssets'] = trim($res['OtherCurrentAssets']);
                                        $res1['CurrentAssets'] = trim($res['CurrentAssets']);
                                        $res1['Provisions'] = trim($res['Provisions']);
                                        $res1['CurrentLiabilitiesProvision'] = trim($res['CurrentLiabilitiesProvision']);
                                        $res1['NetCurrentAssets'] = trim($res['NetCurrentAssets']);
                                        $res1['ProfitLoss'] = trim($res['ProfitLoss']);
                                        $res1['Miscellaneous'] = trim($res['Miscellaneous']);
                                        $res1['TotalAssets'] = trim($res['TotalAssets']);
                                        $res1['ResultType'] = trim($res['ResultType']);
                                        
                                        if(!empty($res1)){
                                    
                                            $data_inner['balancesheet'][] = $res1;
                                        }else{
                                            $data_inner['balancesheet'][] = "";
                                        }
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
                                   
                                    if(!empty($ratio_cal)){
                                    
                                         $data_inner['ratio_balancesheet'][] = $ratio_cal;    
                                    }else{
                                         $data_inner['ratio_balancesheet'][] = "";    
                                    }
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
                                    
                                    if(!empty($res1)){
                                    
                                         $data_inner['balancesheet_new'][] = $res1; 
                                    }else{
                                         $data_inner['balancesheet_new'][] = "";
                                    }
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
                                        
                                        if(!empty($res1)){
                                    
                                            $data_inner['balancesheet_new'][] = $res1;
                                       }else{
                                            $data_inner['balancesheet_new'][] = "";
                                       }
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
                                      
                                    if(!empty($ratio_cal)){
                                    
                                        $data_inner['ratio_balancesheet_new'][] = $ratio_cal; 
                                    }else{
                                         $data_inner['ratio_balancesheet_new'][] = ""; 
                                    }
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
                            if(!empty($data_inner)){
                                
                                $data['Financials'] = $data_inner;
                            }else{
                                $data['Financials'] = "";
                            }
                            
                        
    //----------------------Company profile details------------------------------------------------------------------------------------------------------------------------
                        
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
                            $Status1 = "PE Backed";
                        }else if ($Permissions1 == '1'){
                            $Status1 = "Non-PE Backed";
                        }
                        // else if ($Permissions1 == '2'){
                        //     $Status1 = "Non-Transacted  and Fund Raising";
                        // }
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
                        
                        //Company master data
                       // =====================
                        include_once('simple_html_dom.php');
                        //Data from MCA website 
                        $companymasterdata = array();
                        try{ 
                            $urltopost = "http://www.mca.gov.in/mcafoportal/companyLLPMasterData.do";
                            $datatopost = array ("companyID" => $cin);
                            $ch = curl_init ($urltopost);
                            curl_setopt ($ch, CURLOPT_POST, true);
                            curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
                            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

                            if(curl_exec($ch) != false) {
                                $returndata = curl_exec ($ch); 
                                curl_close($ch);
                                $LLPMaster = str_get_html($returndata);
                                $LLPMasterForm = $LLPMaster->find('form[id=exportCompanyMasterData]', 0);

                                $LLPMasterProfile = $LLPMaster->find('div[id=companyMasterData]', 0);
                                if(isset($LLPMasterForm)){

                                    if(!empty($LLPMasterProfile)){

                                        $table = $LLPMasterProfile->find('table', 0);
                                        foreach($table->find('tr') as $row) {

                                            //$companymasterdata[$row->find('td',0)->plaintext]=$row->find('td',1)->plaintext;
                                             $companymasterdata[rtrim(ltrim(preg_replace('/\t/', '', $row->find('td',0)->plaintext)))]=$row->find('td',1)->plaintext;
                                        }
                                    }else{
                                        $companymasterdata['master_data']="No master data found";
                                    }

                                }
                            }  
                        }catch (Exception $e) {
                            echo $e;
                        }
                        //$data['companymasterdata'] = $companymasterdata;
                        $companyProfile['companymasterdata'] = $companymasterdata;
                        if(!empty($companyProfile)){
                            
                            $data['CompanyProfile'] = $companyProfile;
                        }else{
                            $data['CompanyProfile'] = "";
                        }
                        
                        
//---------------------- Filing for amazon--------------------------------------------------------------------------------------------------------------

                        $client = S3Client::factory(array(
                            'key'    => $GLOBALS['key'],
                            'secret' => $GLOBALS['secret']
                        ));

                        $bucket = $GLOBALS['bucket'];

                        $iterator = $client->getIterator('ListObjects', array(
                            'Bucket' => $bucket,
                            'Prefix' => $GLOBALS['root'] . $c
                        ));

                        $c1=0;$c2=0;$items = array();
                        //Echo '<OL>';
                        foreach ($iterator as $object) {

                                $fileName =  $object['Key'];

                                // Get a pre-signed URL for an Amazon S3 object
                                $signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');

                                $pieces = explode("/", $fileName);
                                $pieces = $pieces[ sizeof($pieces) - 1 ];

                                $fileNameExt = $pieces;
                                $ex_ext = explode(".", $fileName);
                                $ext = $ex_ext[count($ex_ext)-1];
                                if ( strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt) ){

                                    continue;
                                }
                                $c1 = $c1 + 1;

                                $string = "/\d{6,6}/";
                                $paragraph = $fileNameExt;
                                if (preg_match_all($string, $paragraph, $matches)) {
                                    
                                $dateFileName = $matches[0][ count($matches[0]) -1 ];	// get match from Right
                             
                                $d = substr($dateFileName, 0, 2);
                                $m = substr($dateFileName, 2, 2);
                                $y = substr($dateFileName, 4, 2);

                                if( intval($y) <30)	$y = (2000+ intval($y));
                                else $y = (1900+ intval($y));

                                $dateFileName= date_parse_from_format("jnY", $d. $m. $y);
                               if($dateFileName['day']!='' && $dateFileName['month']!='' && $dateFileName['year']!=''){
                                   
                                    $realdate = $dateFileName['day']."/".$dateFileName['month']."/".$dateFileName['year'];
                               }else{
                                    $realdate = "-";
                               }

                                }else{
                                   $realdate = "-";
                                }
                                 // end of match
                                $c2 = $c2 + 1;
                                
                                $str = "<a href='". $signedUrl ."' target='_blank'  >".  $pieces ."</a>";
                                $it=5;
                                if(count($items) <= $it){
                                    
                                    if($realdate=="--"){
                                        $formatdate = "-";
                                    }else{
                                        $formatdate = $realdate;
                                    }
                                    array_push($items, array('name'=>$str,'date' => $formatdate) );
                                }

                        }
                        
                        if(!empty($items)){
                            
                            $data['filings'] = $items;
                        }else{
                            $data['filings'] = "";
                        }
                        
//---------------------List of director and details-------------------------------------------------------------------------------------------------------

                        //Data from MCA website 
                        $companydirectorsdata = array();
                        try{ 
                            /*$directorurl= "http://www.mca.gov.in/mcafoportal/companyLLPMasterData.do";
                            $directordatatopost = array ("companyID" => $cin);
                            $ch2 = curl_init ($directorurl);
                            curl_setopt ($ch2, CURLOPT_POST, true);
                            curl_setopt ($ch2, CURLOPT_POSTFIELDS, $directordatatopost);
                            curl_setopt ($ch2, CURLOPT_RETURNTRANSFER, true);
                            if(curl_exec($ch2) != false) {
                                $returnddata = curl_exec ($ch2); 
                                curl_close($ch2);
                                $DirectorsMaster = str_get_html($returnddata);*/
                                $$DirectorsMasterForm = $LLPMaster->find('form[id=exportCompanyMasterData]', 0);
                                
                                $LLPMasterSignatories = $LLPMaster->find('div[id=signatories]', 0);
                                if(isset($$DirectorsMasterForm)){

                                    if(!empty($LLPMasterSignatories)){

                                            $table = $LLPMasterSignatories->find('table', 0);
                                            $dc=0;
                                           
                                            foreach($table->find('tr') as $row) {
                                                //echo trim($row->find('td',0)->plaintext);
                                                if(trim($row->find('td',0)->plaintext)!=''){

                                                    $companydirectorsdata[$dc]['DIN/PAN']=trim($row->find('td',0)->plaintext);
                                                    $companydirectorsdata[$dc]['Name']=$row->find('td',1)->plaintext;
                                                    $companydirectorsdata[$dc]['Begin_date']=$row->find('td',2)->plaintext;
                                                    $companydirectorsdata[$dc]['End_date']=$row->find('td',3)->plaintext;
                                                    $din = (int)trim($row->find('td',0)->plaintext);
                                                    if($din > 0 && $din !=''){

                                                    $din = (int)trim($row->find('td',0)->plaintext);

                                                    //Data from MCA website 
                                                    $alldatamasterurl = "http://www.mca.gov.in/mcafoportal/directorMasterDataPopup.do";

                                                    $datadin = array ("din" =>$din);

                                                    $ch4 = curl_init ($alldatamasterurl);
                                                    curl_setopt ($ch4, CURLOPT_POST, true);
                                                    curl_setopt ($ch4, CURLOPT_POSTFIELDS, $datadin);
                                                    curl_setopt ($ch4, CURLOPT_RETURNTRANSFER, true);
                                                    $returnmdata = curl_exec ($ch4);

                                                    curl_close($ch4);
                                                    $dirallMasterdata = str_get_html($returnmdata);
                                                    $dirMasterdata = $dirallMasterdata->find('div[id=dirMasterData]', 0);
                                                    $dirMastertabledata1 = $dirMasterdata->find('table', 0);
                                                    $dirMastertabledata2 = $dirMasterdata->find('table', 1);
                                                    $dirMastertabledata3 = $dirMasterdata->find('table', 2);
                                                    $generalinfo=array();$listofcompanies=array();$listofLLP=array();
                                                    foreach($dirMastertabledata1->find('tr') as $row) {

                                                        $generalinfo[$row->find('td',0)->plaintext]=$row->find('td',1)->plaintext;
                                                    }
                                                    $lc=0;$companies_array=array();
                                                    foreach($dirMastertabledata2->find('tr') as $row) {

                                                        if($row->find('td',0)->plaintext!=''){

                                                            $listofcompanies[$lc]['CIN/FCRN']=trim($row->find('td',0)->plaintext);
                                                            $listofcompanies[$lc]['companyName']=$row->find('td',1)->plaintext;
                                                            $listofcompanies[$lc]['Begin_date']=$row->find('td',2)->plaintext;
                                                            $listofcompanies[$lc]['End_date']=$row->find('td',3)->plaintext;
                                                            $lc++;
                                                        }

                                                    }
                                                    $company_array['listcompanies']=$listofcompanies;

                                                    $ll=0;$llp_array=array();
                                                    foreach($dirMastertabledata3->find('tr') as $row) {

                                                        if($row->find('td',0)->plaintext!=''){
                                                            
                                                            if($row->find('td',1)->plaintext!=''){
                                                                $LLPName = $row->find('td',1)->plaintext;
                                                            }else{
                                                                $LLPName="";
                                                            }
                                                            if($row->find('td',2)->plaintext!=''){
                                                                $Begin_date = $row->find('td',2)->plaintext;
                                                            }else{
                                                                 $Begin_date ="-";
                                                            }
                                                            if($row->find('td',3)->plaintext!=''){
                                                                $End_date = $row->find('td',3)->plaintext;
                                                            }else{
                                                                $End_date ="-";
                                                            }
                                                            $listofLLP[$ll]['LLPIN/FLLPIN']=trim($row->find('td',0)->plaintext);
                                                            $listofLLP[$ll]['LLPName']= $LLPName;
                                                            $listofLLP[$ll]['Begin_date']=$Begin_date;
                                                            $listofLLP[$ll]['End_date']=$End_date;
                                                            $ll++;
                                                        }

                                                    }
                                                        if(!empty($listofLLP)){
                                                            $llp_array['listofLLP']=$listofLLP;
                                                        }else{
                                                            $llp_array['listofLLP']='';
                                                        }
                                                        $companydirectorsdata[$dc]['viewDirectorMasterData']= array_merge($generalinfo,$company_array,$llp_array);
                                                        $dc++;
                                                    }else{
                                                        $companydirectorsdata[$dc]['viewDirectorMasterData']= '';
                                                        $dc++;
                                                    }
                                                }

                                            }
                                    }else{
                                        $companydirectorsdata['companymasterdata']="";
                                    }

                                }
                            /*}*/  
                        }catch (Exception $e) {
                            echo $e;
                        }
                        if(!empty($companydirectorsdata)){
                            
                            $data['companydirectorsdata'] = $companydirectorsdata;
                        }else{
                            $data['companydirectorsdata'] = "";
                        }

//---------------------Get Rating--------------------------------------------------------------------------------------------------------------------
                        
                       $rating = array();

                       $crisilRating = "http://www.crisil.com/ratings/company-wise-ratings.jsp?txtSearch=".$cin_res['FCompanyName'];
                       $careRating = "http://google.com/search?btnI=1&q=".$cin_res['FCompanyName']."+site:careratings.com";
                       $rating['crisilRating']=$crisilRating;
                       $rating['careRating']=$careRating;
                       $ICRAratingUrl = "http://icra.in/search.aspx?word=".$cin_res['FCompanyName'];
                       $rating['ICRArating']=$ICRAratingUrl;
                       $rating['ICRAratingUrl']=$ICRAratingUrl;
                       $SMERAratingUrl = "http://www.smera.in/live_ratings.php?company_name=".$cin_res['FCompanyName'];
                       $rating['SMERAratingUrl']=$SMERAratingUrl;
                       $BWratingUrl = "http://www.brickworkratings.com/CreditRatings.aspx";
                       $rating['brickworkrating']=$BWratingUrl;
                       
                       if(!empty($rating)){
                            
                            $data['rating'] = $rating;
                        }else{
                            $data['rating'] = "";
                        }
                        
// --------------------Indexofcharge----------------------------------------------------------------------------------------------------------------------
                       
                        $indexchargerows = array();
                           try{ 
                              $indexofchargeurl = "http://www.mca.gov.in/mcafoportal/viewIndexOfCharges.do";
                                   $iocdatapost = array ("companyID" => $cin);
                                   $ch1 = curl_init ($indexofchargeurl);
                                   curl_setopt ($ch1, CURLOPT_POST, true);
                                   curl_setopt ($ch1, CURLOPT_POSTFIELDS, $iocdatapost);
                                   curl_setopt ($ch1, CURLOPT_RETURNTRANSFER, true);

                                   if(curl_exec($ch1) != false)
                                   {

                                       $returndata = curl_exec ($ch1);
                                       curl_close($ch1);
                                       $LLPMasterCharges = str_get_html($returndata);
                                       $LLPMasterCharge = $LLPMasterCharges->find('table[id=charges]', 0);

                                       $rc=0;
                                       if(!empty($LLPMasterCharge)){

                                           foreach($LLPMasterCharge->find('tr') as $row) {

                                               if($row->find('td',0)->plaintext!=''){

                                                   $indexchargerows[$rc]['SNo']=$row->find('td',0)->plaintext;
                                                   $indexchargerows[$rc]['SRN']=$row->find('td',1)->plaintext;
                                                   $indexchargerows[$rc]['ChargeId']=$row->find('td',2)->plaintext;
                                                   $indexchargerows[$rc]['ChargeHolderName']=$row->find('td',3)->plaintext;
                                                   $indexchargerows[$rc]['DateofCreation']=$row->find('td',4)->plaintext;
                                                   $indexchargerows[$rc]['DateofModification']=$row->find('td',5)->plaintext;
                                                   $indexchargerows[$rc]['DateofSatisfaction']=$row->find('td',6)->plaintext;
                                                   $indexchargerows[$rc]['Amount']=$row->find('td',7)->plaintext;
                                                   $indexchargerows[$rc]['Address']=$row->find('td',8)->plaintext;
                                                   $rc++;
                                               }
                                           }
                                      }  
                                      else{

                                           $indexchargerows['indexofcharge']="";
                                       } 
                                   }

                           }catch (Exception $e) {
                               echo $e;
                           }
                           if(!empty($indexchargerows)){
                               $data['indexofcharge'] = $indexchargerows;
                           }else{
                               $data['indexofcharge'] = "";
                           }
                           
                           
//-----------------------------------------------------------similar companies------------------------------------------------------------------------------------------
                           
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
                        if(!empty($sim_array)){
                            
                            $data['similar_companies'] = $sim_array;
                        }else{
                            $data['similar_companies'] = "";
                        }     
                        
                        $datas['Result'] = $data;
                        
                    }else{
                        $datas['Status'] = "Failure";
                        $datas['Result'] = "CIN not match with any company";
                    }

                }else{
                    $datas['Status'] = "Failure";
                    $datas['Result'] = "CIN not found";
                }
                       
                    echo json_encode($datas);
            }
    
}
elseif(($username !='') && ($authAdmin['usr_flag'] == '0' ||  $groupstatus['status']!=0 )){
	//$template->assign("ErrMsg","Account Not Yet activated !");
        $data['Status'] = "Failure";
        $data['Result'] = "User Account Not Yet activated. Please contact Admin";
        echo json_encode($data);

}


function checkIpRange($userCIp,$groupId){
   
    $splitIpAdd= explode(".", $userCIp);
    $splitIpAdd1=$splitIpAdd[0];
    $splitIpAdd2=$splitIpAdd[1];
    $splitIpAdd3=$splitIpAdd[2];
    $splitIpAdd4=$splitIpAdd[3];
    $splitIpAddress=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3."";
    $splitIpAddress1=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3.".";
    
    $checkForIPAddress="SELECT ip.* FROM user_cfs_ipaddress AS ip ";
    $checkForIPAddress.=" WHERE (ip.ipAddress='".$splitIpAddress."' OR ip.ipAddress='".$splitIpAddress1."') AND (ip.StartRange <= '".$splitIpAdd4."' AND ip.EndRange >= '".$splitIpAdd4."')" ;
    $checkForIPAddress.=" AND group_Id='".$groupId."'"; 
    //echo $checkForIPAddress;
    
    $result = mysql_query($checkForIPAddress) or die(mysql_error());
    $ipCount = mysql_num_rows($result);
    if ($ipCount > 0){
        return true;
    }else{
        return false;
    }
}

 mysql_close(); ?>