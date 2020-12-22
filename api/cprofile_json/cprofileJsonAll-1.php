<?php
error_reporting( E_ALL );
ini_set('display_errors', 'On');
//ob_start();
//if(!isset($_SESSION)){
//    //session_save_path("/tmp");
//    session_start();
//}
$dirPath = dirname(__DIR__) . '/../cfsnew/';
include_once $dirPath."etc/conf.php";
include_once $dirPath . "path_Assign.php";
require_once MAIN_PATH.APP_NAME."/aws.php"; // load logins
require_once( $dirPath . 'aws.phar');
require_once MODULES_DIR."users.php";
$users = new users();

require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
use Aws\S3\S3Client;

/*$from = 'INR';
$to = 'USD';
$amount = 1;
$ch = curl_init( "http://demo.matrixau.net/currency_convert/convert.php?from=" .$from. "&to=" .$to. "&amount=" .$amount );
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$var= curl_exec($ch);
curl_close($ch); 
$pos = stripos($var,'=');
$removeString = substr($var,$pos+1);
$cn = preg_replace("/[^0-9,.]/", "", $removeString);*/
$currencyValue = getCurrencyRate();
$success = $failure = '';         
$dbhost = "localhost";
/*$dbuser = "root";
$dbpassword = "root";
$dbname = "venture_dev_xbrl";*/
$dbuser = "venturei_admin16";
$dbpassword = "[^Is&k~PQpMQ";
$dbname = "venturei_peinvestments";
$dbhandle = mysql_connect( $dbhost, $dbuser, $dbpassword ) or die( "Unable to connect to MySQL" );
$selected = mysql_select_db( $dbname,$dbhandle ) or die( "Database could not select" );

/*$companySql = "SELECT b.CIN, b.FCompanyName, b.Company_Id, b.SCompanyName FROM plstandard a INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY INNER JOIN ( SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK ) as aa ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY WHERE b.ListingStatus IN (1,2,3,4) and b.Permissions1 IN (0,1) and b.UserStatus = 0 and b.Industry != '' and b.State != '' and a.ResultType = 0 AND b.CIN IN('" . $cins . "') GROUP BY b.SCompanyName";*/
$companySql = "SELECT b.CIN, b.FCompanyName, b.Company_Id, b.SCompanyName FROM plstandard a INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY INNER JOIN ( SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK ) as aa ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY WHERE b.ListingStatus IN (1,2,3,4) and b.Permissions1 IN (0,1) and b.UserStatus = 0 and b.Industry != '' and b.State != '' and a.ResultType = 0 AND b.CIN IN('L24100MH1983PLC029442') GROUP BY b.SCompanyName";
$companyRes = mysql_query( $companySql ) or die( mysql_error() );
$companyRows = mysql_num_rows( $companyRes );
if( $companyRows > 0 ) {
    while( $companyResult = mysql_fetch_array( $companyRes ) ) {
        if( !empty( $companyResult[ 'CIN' ] ) || $companyResult[ 'CIN' ] != '' ) {
            $c = $companyResult['FCompanyName'];
            $cprofile_id = $companyResult[ 'Company_Id' ];
            $data['companyName'] = $c;
            $data[ 'companyID' ] = $cprofile_id;
            $data['PreviouslyKnownAs'] = $companyResult['SCompanyName'];
            $data_inner = array();
            //PL STANDARD
            $res1 = array();
            $plQuery = "SELECT PLStandard_Id,CId_FK,IndustryId_FK,OptnlIncome,OtherIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,FY,TotalIncome,BINR,DINR,EmployeeRelatedExpenses,ForeignExchangeEarningandOutgo,EarninginForeignExchange,OutgoinForeignExchange FROM plstandard WHERE CId_FK = '" . $cprofile_id . "' and FY !='' and ResultType='0' ORDER BY FY DESC LIMIT 0,100";
            $PLStsQry = mysql_query( $plQuery ) or die( mysql_error() );
            if( mysql_num_rows( $PLStsQry) > 0 ) {
                while( $res = mysql_fetch_array( $PLStsQry ) ) {
                    $res1 = array();
                    $res1['PLStandard_Id'] = trim($res['PLStandard_Id']);
                    $res1['CId_FK'] = trim($res['CId_FK']);
                    $res1['IndustryId_FK'] = trim( $res['IndustryId_FK']);
                    $res1['OptnlIncome_INR'] = trim( $res['OptnlIncome'] );
                    $res1['OptnlIncome_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OptnlIncome'] ));
                    $res1['OtherIncome_INR'] = trim( $res['OtherIncome'] );
                    $res1['OtherIncome_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherIncome'] ));
                    $res1['OptnlAdminandOthrExp_INR'] = trim( $res['OptnlAdminandOthrExp'] );
                    $res1['OptnlAdminandOthrExp_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OptnlAdminandOthrExp'] ));
                    $res1['OptnlProfit_INR'] = trim( $res['OptnlProfit'] );
                    $res1['OptnlProfit_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OptnlProfit'] ));
                    $res1['EBITDA_INR'] = trim( $res['EBITDA'] );
                    $res1['EBITDA_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EBITDA'] ));
                    $res1['Interest_INR'] = trim( $res['Interest'] );
                    $res1['Interest_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Interest'] ));
                    $res1['EBDT_INR'] = trim( $res['EBDT'] );
                    $res1['EBDT_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EBDT'] ));
                    $res1['Depreciation_INR'] = trim( $res['Depreciation'] );
                    $res1['Depreciation_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Depreciation'] ));
                    $res1['EBT_INR'] = trim( $res['EBT'] );
                    $res1['EBT_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EBT'] ));
                    $res1['Tax_INR'] = trim( $res['Tax'] );
                    $res1['Tax_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Tax'] ));
                    $res1['PAT_INR'] = trim( $res['PAT'] );
                    $res1['PAT_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['PAT'] ));
                    $res1['FY'] = trim( $res['FY'] );
                    $res1['TotalIncome_INR'] = trim( $res['TotalIncome'] );
                    $res1['TotalIncome_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalIncome'] ));
                    $res1['BINR_INR'] = trim( $res['BINR'] );
                    $res1['BINR_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['BINR'] ));
                    $res1['DINR_INR'] = trim( $res['DINR'] );
                    $res1['DINR_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DINR'] ));
                    if($res['EmployeeRelatedExpenses']!= ""){
                        $EmployeeRelatedExpenses1_INR = trim( $res['EmployeeRelatedExpenses'] );
                        $EmployeeRelatedExpenses1_USD = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EmployeeRelatedExpenses'] ));
                    }else{
                        $EmployeeRelatedExpenses1_INR = $EmployeeRelatedExpenses1_USD = "0";
                    }
                    $res1['EmployeeRelatedExpenses_INR'] = $EmployeeRelatedExpenses1_INR;
                    $res1['EmployeeRelatedExpenses_USD'] = $EmployeeRelatedExpenses1_USD;

                    if($res['EarninginForeignExchange']!= ""){
                        $EarninginForeignExchange1_INR = trim( $res['EarninginForeignExchange'] );
                        $EarninginForeignExchange1_USD = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EarninginForeignExchange'] ));
                    }else{
                        $EarninginForeignExchange1_INR = $EarninginForeignExchange1_USD = "0";
                    }
                    $res1['EarninginForeignExchange_INR'] = $EarninginForeignExchange1_INR;
                    $res1['EarninginForeignExchange_USD'] = $EarninginForeignExchange1_USD;

                    if($res['OutgoinForeignExchange']!= ""){
                        $OutgoinForeignExchange1_INR = trim( $res['OutgoinForeignExchange'] );
                        $OutgoinForeignExchange1_USD = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OutgoinForeignExchange'] ));
                    }else{
                        $OutgoinForeignExchange1_INR = $OutgoinForeignExchange1_USD = "0";
                    }
                    $res1['OutgoinForeignExchange_INR'] = $OutgoinForeignExchange1_INR;
                    $res1['OutgoinForeignExchange_USD'] = $OutgoinForeignExchange1_USD;
                    
                    if(! empty( $res1 ) ) {
                        $data_inner['plstandard'][] = $res1;
                    }else{
                        $data_inner['plstandard'][] = "";
                    }
                }
            }

            // GROWTH PERCENTAGE
            $growth = array();
            $max_pls=mysql_query("SELECT min(FY) as FY FROM plstandard WHERE CId_FK='".$cprofile_id."'");
            $max_pl = mysql_fetch_array($max_pls);

            $GrowthQry = mysql_query("SELECT g.GrowthPerc_Id,g.CId_FK,g.IndustryId_FK,g.OptnlIncome,g.OtherIncome,g.OptnlAdminandOthrExp,g.OptnlProfit,g.EBITDA,g.Interest,g.EBDT,g.Depreciation,g.EBT,g.Tax,g.PAT,g.FY,g.TotalIncome,g.BINR,g.DINR,g.EmployeeRelatedExpenses,g.ForeignExchangeEarningandOutgo,g.EarninginForeignExchange,g.OutgoinForeignExchange FROM growthpercentage as g 
                    INNER JOIN plstandard p on(g.CId_FK = p.CId_FK)  WHERE p.CId_FK = ".$cprofile_id." and p.FY !='' and p.FY=g.FY and g.FY > '".$max_pl['FY']."' and p.ResultType='0' ORDER BY FY DESC LIMIT 0,100");
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
            //BALANCESHEET
            $Qry = mysql_query("SELECT * FROM balancesheet a INNER JOIN plstandard b ON a.FY = b.FY AND a.CID_FK = b.CID_FK WHERE a.CID_FK = '$cprofile_id' and b.ResultType='0' and a.ResultType='0' GROUP BY a.FY ORDER BY a.FY DESC LIMIT 0,100");
            if(mysql_num_rows($Qry) > 0) {
                while($res = mysql_fetch_array($Qry)) {
                    $res1 = array();
                    $res1['FY'] = trim( $res['FY'] );
                    $res1['ShareCapital_INR'] = trim( $res['ShareCapital'] );
                    $res1['ShareCapital_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareCapital'] ));
                    $res1['ShareApplication_INR'] = trim( $res['ShareApplication'] );
                    $res1['ShareApplication_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareApplication'] ));
                    $res1['ReservesSurplus_INR'] = trim( $res['ReservesSurplus'] );
                    $res1['ReservesSurplus_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ReservesSurplus'] ));
                    $res1['TotalFunds_INR'] = trim( $res['TotalFunds'] );
                    $res1['TotalFunds_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalFunds'] ));
                    $res1['SecuredLoans_INR'] = trim( $res['SecuredLoans'] );
                    $res1['SecuredLoans_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SecuredLoans'] ));
                    $res1['UnSecuredLoans_INR'] = trim( $res['UnSecuredLoans'] );
                    $res1['UnSecuredLoans_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['UnSecuredLoans'] ));
                    $res1['LoanFunds_INR'] = trim( $res['LoanFunds'] );
                    $res1['LoanFunds_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LoanFunds'] ));
                    $res1['OtherLiabilities_INR'] = trim( $res['OtherLiabilities'] );
                    $res1['OtherLiabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherLiabilities'] ));
                    $res1['DeferredTax_INR'] = trim( $res['DeferredTax'] );
                    $res1['DeferredTax_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DeferredTax'] ));
                    $res1['SourcesOfFunds_INR'] = trim( $res['SourcesOfFunds'] );
                    $res1['SourcesOfFunds_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SourcesOfFunds'] ));
                    $res1['GrossBlock_INR'] = trim( $res['GrossBlock'] );
                    $res1['GrossBlock_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['GrossBlock'] ));
                    $res1['LessAccumulated_INR'] = trim( $res['LessAccumulated'] );
                    $res1['LessAccumulated_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LessAccumulated'] ));
                    $res1['NetBlock_INR'] = trim( $res['NetBlock'] );
                    $res1['NetBlock_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['NetBlock'] ));
                    $res1['CapitalWork_INR'] = trim( $res['CapitalWork'] );
                    $res1['CapitalWork_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CapitalWork'] ));
                    $res1['FixedAssets_INR'] = trim( $res['FixedAssets'] );
                    $res1['FixedAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['FixedAssets'] ));
                    $res1['IntangibleAssets_INR'] = trim( $res['IntangibleAssets'] );
                    $res1['IntangibleAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['IntangibleAssets'] ));
                    $res1['OtherNonCurrent_INR'] = trim( $res['OtherNonCurrent'] );
                    $res1['OtherNonCurrent_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherNonCurrent'] ));
                    $res1['Investments_INR'] = trim( $res['Investments'] );
                    $res1['Investments_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Investments'] ));
                    $res1['DeferredTaxAssets_INR'] = trim( $res['DeferredTaxAssets'] );
                    $res1['DeferredTaxAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DeferredTaxAssets'] ));
                    $res1['SundryDebtors_INR'] = trim( $res['SundryDebtors'] );
                    $res1['SundryDebtors_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SundryDebtors'] ));
                    $res1['CashBankBalances_INR'] = trim( $res['CashBankBalances'] );
                    $res1['CashBankBalances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CashBankBalances'] ));
                    $res1['Inventories_INR'] = trim( $res['Inventories'] );
                    $res1['Inventories_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Inventories'] ));
                    $res1['LoansAdvances_INR'] = trim( $res['LoansAdvances'] );
                    $res1['LoansAdvances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LoansAdvances'] ));
                    $res1['OtherCurrentAssets_INR'] = trim( $res['OtherCurrentAssets'] );
                    $res1['OtherCurrentAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherCurrentAssets'] ));
                    $res1['CurrentAssets_INR'] = trim( $res['CurrentAssets'] );
                    $res1['CurrentAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CurrentAssets'] ));
                    $res1['Provisions_INR'] = trim( $res['Provisions'] );
                    $res1['Provisions_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Provisions'] ));
                    $res1['CurrentLiabilitiesProvision_INR'] = trim( $res['CurrentLiabilitiesProvision'] );
                    $res1['CurrentLiabilitiesProvision_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CurrentLiabilitiesProvision'] ));
                    $res1['NetCurrentAssets_INR'] = trim( $res['NetCurrentAssets'] );
                    $res1['NetCurrentAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['NetCurrentAssets'] ));
                    $res1['ProfitLoss_INR'] = trim( $res['ProfitLoss'] );
                    $res1['ProfitLoss_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ProfitLoss'] ));
                    $res1['Miscellaneous_INR'] = trim( $res['Miscellaneous'] );
                    $res1['Miscellaneous_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Miscellaneous'] ));
                    $res1['TotalAssets_INR'] = trim( $res['TotalAssets'] );
                    $res1['TotalAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalAssets'] ));
                    $res1['ResultType'] = trim( $res['ResultType'] );
                    if(!empty($res1)){
                        $data_inner['balancesheet'][] = $res1;
                    }else{
                        $data_inner['balancesheet'][] = "";
                    }
                }
            } else {
                $Qry = mysql_query("SELECT * FROM balancesheet a WHERE a.CID_FK = '$cprofile_id' and a.ResultType='0' ORDER BY a.FY DESC LIMIT 0,100");
                if(mysql_num_rows($Qry) > 0){
                    while($res = mysql_fetch_array($Qry)){
                        $res1 = array();
                        $res1['FY'] = trim($res['FY']);
                        $res1['ShareCapital_INR'] = trim($res['ShareCapital']);
                        $res1['ShareCapital_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareCapital'] ));
                        $res1['ShareApplication_INR'] = trim($res['ShareApplication']);
                        $res1['ShareApplication_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareApplication'] ));
                        $res1['ReservesSurplus_INR'] = trim($res['ReservesSurplus']);
                        $res1['ReservesSurplus_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ReservesSurplus'] ));
                        $res1['TotalFunds_INR'] = trim($res['TotalFunds']);
                        $res1['TotalFunds_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalFunds'] ));
                        $res1['SecuredLoans_INR'] = trim($res['SecuredLoans']);
                        $res1['SecuredLoans_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SecuredLoans'] ));
                        $res1['UnSecuredLoans_INR'] = trim($res['UnSecuredLoans']);
                        $res1['UnSecuredLoans_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['UnSecuredLoans'] ));
                        $res1['LoanFunds_INR'] = trim($res['LoanFunds']);
                        $res1['LoanFunds_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LoanFunds'] ));
                        $res1['OtherLiabilities_INR'] = trim($res['OtherLiabilities']);
                        $res1['OtherLiabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherLiabilities'] ));
                        $res1['DeferredTax_INR'] = trim($res['DeferredTax']);
                        $res1['DeferredTax_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DeferredTax'] ));
                        $res1['SourcesOfFunds_INR'] = trim($res['SourcesOfFunds']);
                        $res1['SourcesOfFunds_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SourcesOfFunds'] ));
                        $res1['GrossBlock_INR'] = trim($res['GrossBlock']);
                        $res1['GrossBlock_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['GrossBlock'] ));
                        $res1['LessAccumulated_INR'] = trim($res['LessAccumulated']);
                        $res1['LessAccumulated_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LessAccumulated'] ));
                        $res1['NetBlock_INR'] = trim($res['NetBlock']);
                        $res1['NetBlock_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['NetBlock'] ));
                        $res1['CapitalWork_INR'] = trim($res['CapitalWork']);
                        $res1['CapitalWork_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CapitalWork'] ));
                        $res1['FixedAssets_INR'] = trim($res['FixedAssets']);
                        $res1['FixedAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['FixedAssets'] ));
                        $res1['IntangibleAssets_INR'] = trim($res['IntangibleAssets']);
                        $res1['IntangibleAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['IntangibleAssets'] ));
                        $res1['OtherNonCurrent_INR'] = trim($res['OtherNonCurrent']);
                        $res1['OtherNonCurrent_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherNonCurrent'] ));
                        $res1['Investments_INR'] = trim($res['Investments']);
                        $res1['Investments_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Investments'] ));
                        $res1['DeferredTaxAssets_INR'] = trim($res['DeferredTaxAssets']);
                        $res1['DeferredTaxAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DeferredTaxAssets'] ));
                        $res1['SundryDebtors_INR'] = trim($res['SundryDebtors']);
                        $res1['SundryDebtors_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SundryDebtors'] ));
                        $res1['CashBankBalances_INR'] = trim($res['CashBankBalances']);
                        $res1['CashBankBalances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CashBankBalances'] ));
                        $res1['Inventories_INR'] = trim($res['Inventories']);
                        $res1['Inventories_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Inventories'] ));
                        $res1['LoansAdvances_INR'] = trim($res['LoansAdvances']);
                        $res1['LoansAdvances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LoansAdvances'] ));
                        $res1['OtherCurrentAssets_INR'] = trim($res['OtherCurrentAssets']);
                        $res1['OtherCurrentAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherCurrentAssets'] ));
                        $res1['CurrentAssets_INR'] = trim($res['CurrentAssets']);
                        $res1['CurrentAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CurrentAssets'] ));
                        $res1['Provisions_INR'] = trim($res['Provisions']);
                        $res1['Provisions_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Provisions'] ));
                        $res1['CurrentLiabilitiesProvision_INR'] = trim($res['CurrentLiabilitiesProvision']);
                        $res1['CurrentLiabilitiesProvision_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CurrentLiabilitiesProvision'] ));
                        $res1['NetCurrentAssets_INR'] = trim($res['NetCurrentAssets']);
                        $res1['NetCurrentAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['NetCurrentAssets'] ));
                        $res1['ProfitLoss_INR'] = trim($res['ProfitLoss']);
                        $res1['ProfitLoss_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ProfitLoss'] ));
                        $res1['Miscellaneous_INR'] = trim($res['Miscellaneous']);
                        $res1['Miscellaneous_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Miscellaneous'] ));
                        $res1['TotalAssets_INR'] = trim($res['TotalAssets']);
                        $res1['TotalAssets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalAssets'] ));
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
                    $res1['ShareCapital_INR'] = $res['ShareCapital'];
                    $res1['ShareCapital_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareCapital'] ));
                    $res1['ReservesSurplus_INR'] = $res['ReservesSurplus'];
                    $res1['ReservesSurplus_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ReservesSurplus'] ));
                    $res1['TotalFunds_INR'] = $res['TotalFunds'];
                    $res1['TotalFunds_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalFunds'] ));
                    $res1['ShareApplication_INR'] = $res['ShareApplication'];
                    $res1['ShareApplication_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareApplication'] ));
                    $res1['L_term_borrowings_INR'] = $res['L_term_borrowings'];
                    $res1['L_term_borrowings_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_borrowings'] ));
                    $res1['deferred_tax_liabilities_INR'] = $res['deferred_tax_liabilities'];
                    $res1['deferred_tax_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['deferred_tax_liabilities'] ));
                    $res1['O_long_term_liabilities_INR'] = $res['O_long_term_liabilities'];
                    $res1['O_long_term_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_long_term_liabilities'] ));
                    $res1['L_term_provisions_INR'] = $res['L_term_provisions']; 
                    $res1['L_term_provisions_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_provisions'] )); 
                    $res1['T_non_current_liabilities_INR'] = $res['T_non_current_liabilities'];
                    $res1['T_non_current_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_non_current_liabilities'] ));
                    $res1['S_term_borrowings_INR'] = $res['S_term_borrowings'];
                    $res1['S_term_borrowings_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_borrowings'] ));
                    $res1['Trade_payables_INR'] = $res['Trade_payables'];
                    $res1['Trade_payables_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Trade_payables'] ));
                    $res1['O_current_liabilities_INR'] = $res['O_current_liabilities'];
                    $res1['O_current_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_current_liabilities'] ));
                    $res1['S_term_provisions_INR'] = $res['S_term_provisions'];
                    $res1['S_term_provisions_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_provisions'] ));
                    $res1['T_current_liabilities_INR'] = $res['T_current_liabilities'];
                    $res1['T_current_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_current_liabilities'] ));
                    $res1['T_equity_liabilities_INR'] = $res['T_equity_liabilities'];
                    $res1['T_equity_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_equity_liabilities'] ));
                    $res1['Tangible_assets_INR'] = $res['Tangible_assets'];
                    $res1['Tangible_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Tangible_assets'] ));    
                    $res1['Intangible_assets_INR'] = $res['Intangible_assets'];
                    $res1['Intangible_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Intangible_assets'] ));
                    $res1['T_fixed_assets_INR'] = $res['T_fixed_assets'];
                    $res1['T_fixed_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_fixed_assets'] ));
                    $res1['N_current_investments_INR'] = $res['N_current_investments'];
                    $res1['N_current_investments_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['N_current_investments'] ));
                    $res1['Deferred_tax_assets_INR'] = $res['Deferred_tax_assets'];
                    $res1['Deferred_tax_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Deferred_tax_assets'] ));
                    $res1['L_term_loans_advances_INR'] = $res['L_term_loans_advances'];
                    $res1['L_term_loans_advances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_loans_advances'] ));
                    $res1['O_non_current_assets_INR'] = $res['O_non_current_assets'];
                    $res1['O_non_current_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_non_current_assets'] ));
                    $res1['T_non_current_assets_INR'] = $res['T_non_current_assets'];
                    $res1['T_non_current_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_non_current_assets'] ));
                    $res1['Current_investments_INR'] = $res['Current_investments'];
                    $res1['Current_investments_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Current_investments'] ));
                    $res1['Inventories_INR'] = $res['Inventories'];
                    $res1['Inventories_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Inventories'] ));
                    $res1['Trade_receivables_INR'] = $res['Trade_receivables'];
                    $res1['Trade_receivables_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Trade_receivables'] ));
                    $res1['Cash_bank_balances_INR'] = $res['Cash_bank_balances'];
                    $res1['Cash_bank_balances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Cash_bank_balances'] ));
                    $res1['S_term_loans_advances_INR'] = $res['S_term_loans_advances'];
                    $res1['S_term_loans_advances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_loans_advances'] ));
                    $res1['O_current_assets_INR'] = $res['O_current_assets'];
                    $res1['O_current_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_current_assets'] ));
                    $res1['T_current_assets_INR'] = $res['T_current_assets'];
                    $res1['T_current_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_current_assets'] ));
                    $res1['Total_assets_INR'] = $res['Total_assets'];
                    $res1['Total_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Total_assets'] ));
                    if(!empty($res1)){
                         $data_inner['balancesheet_new'][] = $res1; 
                    }else{
                         $data_inner['balancesheet_new'][] = "";
                    }
                }
            } else {
                $Qry = mysql_query("SELECT * FROM balancesheet_new a WHERE a.CID_FK = '$cprofile_id' and a.ResultType='0' ORDER BY a.FY DESC LIMIT 0,100");
                if(mysql_num_rows($Qry) > 0){
                    while($res = mysql_fetch_array($Qry)){
                        $res1 = array();
                        $res1['FY'] = $res['FY'];
                        $res1['ShareCapital_INR'] = $res['ShareCapital'];
                        $res1['ShareCapital_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareCapital'] ));
                        $res1['ReservesSurplus_INR'] = $res['ReservesSurplus'];
                        $res1['ReservesSurplus_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ReservesSurplus'] ));
                        $res1['TotalFunds_INR'] = $res['TotalFunds'];
                        $res1['TotalFunds_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalFunds'] ));
                        $res1['ShareApplication_INR'] = $res['ShareApplication'];
                        $res1['ShareApplication_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareApplication'] ));
                        $res1['L_term_borrowings_INR'] = $res['L_term_borrowings'];
                        $res1['L_term_borrowings_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_borrowings'] ));
                        $res1['deferred_tax_liabilities_INR'] = $res['deferred_tax_liabilities'];
                        $res1['deferred_tax_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['deferred_tax_liabilities'] ));
                        $res1['O_long_term_liabilities_INR'] = $res['O_long_term_liabilities'];
                        $res1['O_long_term_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_long_term_liabilities'] ));
                        $res1['L_term_provisions_INR'] = $res['L_term_provisions']; 
                        $res1['L_term_provisions_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_provisions'] )); 
                        $res1['T_non_current_liabilities_INR'] = $res['T_non_current_liabilities'];
                        $res1['T_non_current_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_non_current_liabilities'] ));
                        $res1['S_term_borrowings_INR'] = $res['S_term_borrowings'];
                        $res1['S_term_borrowings_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_borrowings'] ));
                        $res1['Trade_payables_INR'] = $res['Trade_payables'];
                        $res1['Trade_payables_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Trade_payables'] ));
                        $res1['O_current_liabilities_INR'] = $res['O_current_liabilities'];
                        $res1['O_current_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_current_liabilities'] ));
                        $res1['S_term_provisions_INR'] = $res['S_term_provisions'];
                        $res1['S_term_provisions_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_provisions'] ));
                        $res1['T_current_liabilities_INR'] = $res['T_current_liabilities'];
                        $res1['T_current_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_current_liabilities'] ));
                        $res1['T_equity_liabilities_INR'] = $res['T_equity_liabilities'];
                        $res1['T_equity_liabilities_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_equity_liabilities'] ));
                        $res1['Tangible_assets_INR'] = $res['Tangible_assets']; 
                        $res1['Tangible_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Tangible_assets'] ));     
                        $res1['Intangible_assets_INR'] = $res['Intangible_assets'];
                        $res1['Intangible_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Intangible_assets'] ));
                        $res1['T_fixed_assets_INR'] = $res['T_fixed_assets'];
                        $res1['T_fixed_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_fixed_assets'] ));
                        $res1['N_current_investments_INR'] = $res['N_current_investments'];
                        $res1['N_current_investments_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['N_current_investments'] ));
                        $res1['Deferred_tax_assets_INR'] = $res['Deferred_tax_assets'];
                        $res1['Deferred_tax_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Deferred_tax_assets'] ));
                        $res1['L_term_loans_advances_INR'] = $res['L_term_loans_advances'];
                        $res1['L_term_loans_advances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_loans_advances'] ));
                        $res1['O_non_current_assets_INR'] = $res['O_non_current_assets'];
                        $res1['O_non_current_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_non_current_assets'] ));
                        $res1['T_non_current_assets_INR'] = $res['T_non_current_assets'];
                        $res1['T_non_current_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_non_current_assets'] ));
                        $res1['Current_investments_INR'] = $res['Current_investments'];
                        $res1['Current_investments_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Current_investments'] ));
                        $res1['Inventories_INR'] = $res['Inventories'];
                        $res1['Inventories_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Inventories'] ));
                        $res1['Trade_receivables_INR'] = $res['Trade_receivables'];
                        $res1['Trade_receivables_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Trade_receivables'] ));
                        $res1['Cash_bank_balances_INR'] = $res['Cash_bank_balances'];
                        $res1['Cash_bank_balances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Cash_bank_balances'] ));
                        $res1['S_term_loans_advances_INR'] = $res['S_term_loans_advances'];
                        $res1['S_term_loans_advances_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_loans_advances'] ));
                        $res1['O_current_assets_INR'] = $res['O_current_assets'];
                        $res1['O_current_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_current_assets'] ));
                        $res1['T_current_assets_INR'] = $res['T_current_assets'];
                        $res1['T_current_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_current_assets'] ));
                        $res1['Total_assets_INR'] = $res['Total_assets'];
                        $res1['Total_assets_USD'] = (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Total_assets'] ));
                        if( !empty( $res1 ) ) {
                            $data_inner['balancesheet_new'][] = $res1;
                        } else {
                            $data_inner['balancesheet_new'][] = "";
                        }
                    }
                }
            }
            //Balancesheet New Ends

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
            //Ratio with Balancesheet new Ends

            //    Excel files
            // Plstandard Standalone
            if( file_exists( FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_OLD.xls' ) || file_exists( FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_NEW.xls' ) ){
                if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_OLD.xls')){
                    $data_inner[ 'PLExport' ][ 'Standalone' ][ 'Old' ] = MEDIA_PATH.'plstandard/PLStandard_'.$cprofile_id.'_OLD.xls';
                }
                if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_NEW.xls')){
                    $data_inner[ 'PLExport' ][ 'Standalone' ][ 'New' ] = MEDIA_PATH.'plstandard/PLStandard_'.$cprofile_id.'_NEW.xls';
                }
            } else {
                if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'.xls')){
                    $data_inner['PLExport']['Standalone'][ 'Manual' ] = MEDIA_PATH.'plstandard/PLStandard_'.$cprofile_id.'.xls';
                }
            }
            if( file_exists( FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_OLD_1.xls' ) || file_exists( FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_NEW_1.xls' ) ){
                if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_OLD_1.xls')){
                    $data_inner[ 'PLExport' ][ 'Consolidated' ][ 'Old' ] = MEDIA_PATH.'plstandard/PLStandard_'.$cprofile_id.'_OLD_1.xls';
                }
                if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_NEW_1.xls')){
                    $data_inner[ 'PLExport' ][ 'Consolidated' ][ 'New' ] = MEDIA_PATH.'plstandard/PLStandard_'.$cprofile_id.'_NEW_1.xls';
                }
            } else {
                if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$cprofile_id.'_1.xls')){
                    $data_inner['PLExport']['Consolidated'][ 'Manual' ] = MEDIA_PATH.'plstandard/PLStandard_'.$cprofile_id.'_1.xls';
                }
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

            if( file_exists( FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_OLD.xls' ) || file_exists( FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_NEW.xls' ) ) {
                if( file_exists( FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_OLD.xls' ) ) {
                    $data_inner['BSheetNewExport']['Standalone'][ 'Old' ] = MEDIA_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_OLD.xls';
                }
                if( file_exists( FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_NEW.xls' ) ){
                    $data_inner['BSheetNewExport']['Standalone'][ 'New' ] = MEDIA_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_NEW.xls';
                }
            } else {
                if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'.xls')){
                    $data_inner['BSheetNewExport']['Standalone'][ 'Manual' ] = MEDIA_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'.xls';
                }
            }

            if( file_exists( FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_OLD_1.xls' ) || file_exists( FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_NEW_1.xls' ) ) {
                if( file_exists( FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_OLD_1.xls' ) ) {
                    $data_inner['BSheetNewExport']['Consolidated'][ 'Old' ] = MEDIA_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_OLD_1.xls';
                }
                if( file_exists( FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_NEW_1.xls' ) ){
                    $data_inner['BSheetNewExport']['Consolidated'][ 'New' ] = MEDIA_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_NEW_1.xls';
                }
            } else {
                if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_1.xls')){
                    $data_inner['BSheetNewExport']['Consolidated'][ 'Manual' ] = MEDIA_PATH.'balancesheet_new/New_BalSheet_'.$cprofile_id.'_1.xls';
                }
            }
            if(file_exists(FOLDER_CREATE_PATH.'cashflow/Cashflow_'.$cprofile_id.'.xls')){
                $data_inner['CashFlowExport'] = MEDIA_PATH.'cashflow/Cashflow_'.$cprofile_id.'.xls';
            }
            if(!empty($data_inner)){
                
                $data['Financials'] = $data_inner;
            }else{
                $data['Financials'] = "";
            }
            //    Excel files ENDS
            //----------------------Company profile details--------------------------------------
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
            $companyProfile['BusinessDescription'] = $cin_res['BusinessDesc'];
            $companyProfile['Address'] = $cin_res['AddressHead'];
            $companyProfile['Telephone'] = $cin_res['Phone'];
            $companyProfile['Sector'] = $cin_res['SectorName'];
            $companyProfile['NAICSCode'] = $cin_res['naics_code'];
            $companyProfile['City'] = $cin_res['city_name'];
            $companyProfile['Email'] = $cin_res['Email'];
            $companyProfile['FormerlyCalled'] = $cin_res['FormerlyCalled'];    
            $companyProfile['ContactName'] = $cin_res['CEO'];
            $companyProfile['Designation'] = $cin_res['CFO'];
            $companyProfile['YearFounded'] = $cin_res['IncorpYear'];
            $companyProfile['Country'] = $cin_res['Country_Name'];
            $companyProfile['Website'] = $cin_res['Website'];
            $companyProfile['LinkedIn'] = $cin_res['LinkedIn'];
            //Company master data
            // =====================
            //Data from MCA website 
            /*$companymasterdata = array();
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
            }*/
            //$data['companymasterdata'] = $companymasterdata;
            //$companyProfile['companymasterdata'] = $companymasterdata;
            if(!empty($companyProfile)){
                $data['CompanyProfile'] = $companyProfile;
            }else{
                $data['CompanyProfile'] = "";
            }
            //----------------------Company profile details Ends--------------------------------------
            //---------------------- Filing for amazon------------------------------------------------
            /*$client = S3Client::factory(array(
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
                        
                    $dateFileName = $matches[0][ count($matches[0]) -1 ];   // get match from Right
                 
                    $d = substr($dateFileName, 0, 2);
                    $m = substr($dateFileName, 2, 2);
                    $y = substr($dateFileName, 4, 2);

                    if( intval($y) <30) $y = (2000+ intval($y));
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
            }*/
            //---------------------- Filing for amazon ends------------------------------------------------
            //---------------------List of director and details----------------------------------
            //Data from MCA website 
            /*$companydirectorsdata = array();
            try{ 
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
                }*/
           /*}catch (Exception $e) {
                echo $e;
            }*/
            /*if(!empty($companydirectorsdata)){
                
                $data['companydirectorsdata'] = $companydirectorsdata;
            }else{
                $data['companydirectorsdata'] = "";
            }*/
            //---------------------List of director and details ends----------------------------------
            //---------------------Get Rating---------------------------------------------------
            /*$rating = array();
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
            }*/
            //---------------------Get Rating ends--------------------------------------------------
            // --------------------Indexofcharge-------------------------------------------------
            /*$indexchargerows = array();
            try{ 
                $indexofchargeurl = "http://www.mca.gov.in/mcafoportal/viewIndexOfCharges.do";
                $iocdatapost = array ("companyID" => $cin);
                $ch1 = curl_init ($indexofchargeurl);
                curl_setopt ($ch1, CURLOPT_POST, true);
                curl_setopt ($ch1, CURLOPT_POSTFIELDS, $iocdatapost);
                curl_setopt ($ch1, CURLOPT_RETURNTRANSFER, true);

                if(curl_exec($ch1) != false) {
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
                    } else{
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
            }*/
            // --------------------Indexofcharge ends-------------------------------------------------
            //----------------------Funding Details-----------------
            $getcompanysql = "select PECompanyId from pecompanies where CINNo ='".$_POST['cin']."'";
            $companyrs = mysql_query($getcompanysql);          
            $myrow=mysql_fetch_array($companyrs);
            $fundingArray = array();
            if( count($myrow) > 0 && $myrow['PECompanyId']!='') {
                //Main Query to get all the deal by company id
                $sql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business, pe.amount,
                DATE_FORMAT( dates, '%b-%Y' ) as dealperiod, pe.PEId, pe.hideamount, pe.StageId, pe.SPV, pe.AggHide, pe.dates as dates,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM peinvestments AS pe, 
                industry AS i, 
                pecompanies AS pec,
                stage as s, 
                peinvestments_investors as peinv_invs,
                peinvestors as invs 
                WHERE 
                pec.industry = i.industryid 
                AND pec.PEcompanyID = pe.PECompanyID 
                and pe.StageId=s.StageId 
                AND invs.InvestorId=peinv_invs.InvestorId 
                and pe.PEId=peinv_invs.PEId 
                and pe.Deleted =0 
                and pec.industry !=15 
                and pec.PECompanyId=".$myrow['PECompanyId']."
                GROUP BY pe.PEId order by dates desc";
                $pers = mysql_query($sql);          
                $cont=0;$pedata = array();$totalInv=0;$totalAmount=0;
                While($myrow=mysql_fetch_array($pers, MYSQL_BOTH)) { // while process to count total deals and amount and data save in array
                    $amtTobeDeductedforAggHide=0;
                    $NoofDealsCntTobeDeducted=0;
                    if($myrow["AggHide"]==1 && $myrow["SPV"]==0) {
                        $NoofDealsCntTobeDeducted=1;
                        $amtTobeDeductedforAggHide=$myrow["amount"];
                    } else if($myrow["SPV"]==1 && $myrow["AggHide"]==0){
                        $NoofDealsCntTobeDeducted=1;
                        $amtTobeDeductedforAggHide=$myrow["amount"];
                    } else if($myrow["SPV"]==1 && $myrow["AggHide"]==1){
                        $NoofDealsCntTobeDeducted=1;
                        $amtTobeDeductedforAggHide=$myrow["amount"];
                    }
                    $totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
                    $totalAmount=$totalAmount+ $myrow["amount"]-$amtTobeDeductedforAggHide;
                    $pedata[$cont]=$myrow;
                    $cont++;
                }
                if(count($pedata) > 0) {
                    $fundingArray[ 'resultCountData' ] = $totalInv.' Results found (across 1 cos)';
                    $fundingArray[ 'resultAmountData' ] = 'Amount (US$ M) '.$totalAmount;
                    $fi = 0;
                    foreach( $pedata as $ped ) {
                        if( trim( $ped[ "sector_business" ] ) == "" ){
                            $showindsec = $ped["industry"];
                        } else {
                            $showindsec = $ped["sector_business"];
                        }
                        if( $ped[ "Exit_Status" ] == 1 ){
                            $exitstatus_name = 'Unexited';
                        } elseif( $ped[ "Exit_Status" ] == 2 ){
                            $exitstatus_name = 'Partially Exited';
                        } elseif( $ped[ "Exit_Status" ] == 3 ){
                            $exitstatus_name = 'Fully Exited';
                        } else{
                            $exitstatus_name = '--';
                        }
                        if( $ped[ "hideamount" ] == 1 ) {
                            $hideamount = "--";
                        } else {
                            $hideamount = $ped["amount"];
                        }
                        $fundingArray[ 'fundList' ][ $fi ][ 'Company' ] = trim( $ped[ "companyname" ] );
                        $fundingArray[ 'fundList' ][ $fi ][ 'Sector' ] = trim( $showindsec );
                        $fundingArray[ 'fundList' ][ $fi ][ 'Investor' ] = $ped[ "Investor" ];
                        $fundingArray[ 'fundList' ][ $fi ][ 'Date' ] = $ped[ "dealperiod" ];
                        $fundingArray[ 'fundList' ][ $fi ][ 'Exit Status' ] = $exitstatus_name;
                        $fundingArray[ 'fundList' ][ $fi ][ 'Amount' ] = $hideamount;
                        $fi++;
                    }
                    $data['funding'] = $fundingArray;
                } else {
                    $data['funding'] = "";
                }
            } else {
                $data['funding'] = "";
            }
            //----------------------Funding Details ends-----------------
            //------------------similar companies-----------------------
            /*$fields = "Company_Id,FCompanyName,state_name";
            $where = " Industry_Id= ".$cin_res['Industry'];
            $order="FCompanyName";
            $sql = "SELECT ".$fields." FROM cprofile ";
            $sql.= " INNER JOIN industries b on(Industry = b.Industry_Id) ";
            $sql.= " INNER JOIN countries c on(Country = c.Country_Id) ";
            $sql.= " INNER JOIN city d on(City = d.city_id) ";
            $sql.= " INNER JOIN state e on( State = e.state_id) ";
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
            if(!empty($sim_array)) {
                $data['similar_companies'] = $sim_array;
            } else {
                $data['similar_companies'] = "";
            }*/
            //------------------similar companies ends -----------------------
        }
        if( !empty( $data_inner ) ) {
            $data['Financials'] = $data_inner;
        } else {
            $data['Financials'] = "";
        }
        
        /*if( file_exists( 'bulk.json' ) ) {
            $current_data = file_get_contents('bulk.json');
            $array_data = json_decode( $current_data, true );
            $array_data[][ $companyResult[ 'CIN' ] ] = $data; 
            $final_data = json_encode( $array_data );  
            file_put_contents( 'bulk.json', $final_data );
        } else {
            $fp = fopen( "bulk.json", 'w');
            fwrite( $fp, json_encode( array( array( $companyResult[ 'CIN' ] => $data ) ) ) );
            fclose($fp);    
        }*/
        $fp = fopen( $companyResult[ 'FCompanyName' ].'.json', 'w');
        fwrite( $fp, json_encode( $data ) );
        fclose($fp);
    }
}
/*header('Content-Type: application/json');
echo json_encode( $finalData )*/;

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
function getCurrencyRate() {
    $select = "SELECT dollar_rate, FY FROM conversion_rate WHERE 1 = 1";
    $res = mysql_query( $select ) or die( mysql_error() );
    $numRows = mysql_num_rows( $res );
    if( $numRows > 0 ) {
        while( $result = mysql_fetch_array( $res ) ) {
            $resp[ $result[ 'FY' ] ] = $result[ 'dollar_rate' ];
        }
    }
    return $resp;
}
function currency_convert( $amount, $from_currency, $to_currency ) {
    global $cn;
    //print_r($_SESSION['typevalue']);
    $comp_key=$from_currency."-".$to_currency;
    if( $to_currency != 'INR' ) {
        $curr_value=$cn;
    } else {
        $curr_value=1;
    }
    $convertnumber = $amount* $curr_value;
    return (string)$convertnumber;
}
                
               
 mysql_close(); ?>