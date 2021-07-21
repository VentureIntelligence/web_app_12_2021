<?php
ob_start();
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

//Username, password and ip checking
$username = $_POST["username"];
$password = $_POST["password"];
$curreny_code = $_POST["currency_code"];

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
            /*$dbuser = "root";
            $dbpassword = "root";
            $dbname = "venture_dev_xbrl";*/
            $dbuser = "venturei_admin16";
            $dbpassword = "[^Is&k~PQpMQ";
            $dbname = "venturei_peinvestments";
            $dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
                or die("Unable to connect to MySQL");
            $selected = mysql_select_db($dbname,$dbhandle) 
                or die("Database could not select");
                
            if(isset($_REQUEST['cin']) && $_REQUEST['cin'] !=''){
                if( isset( $curreny_code ) && $curreny_code !== '' ) {
                   // $cin = base64_decode($_REQUEST['cin']);
                    $cin = $_REQUEST['cin'];
                    $cin_check = mysql_query("SELECT * FROM cprofile WHERE CIN='$cin'" );
                    $cin_check_count = mysql_num_rows($cin_check);
                    $cin_res = mysql_fetch_array($cin_check);
                    $cprofile_id = $cin_res['Company_Id'];
                    $data_inner = array();
                    if($cprofile_id != ''){
                        
                        $datas['Status'] = "Success";
                        
                        $data['companyName'] = $cin_res['FCompanyName'];
                        $data[ 'companyID' ] = $cprofile_id;
                        $data['PreviouslyKnownAs'] = $cin_res['SCompanyName'];
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
                                $res1['OptnlIncome'] = ( $curreny_code == 'INR' ) ? trim( $res['OptnlIncome'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OptnlIncome'] ));
                                $res1['OtherIncome'] = ( $curreny_code == 'INR' ) ? trim( $res['OtherIncome'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherIncome'] ));
                                $res1['OptnlAdminandOthrExp'] = ( $curreny_code == 'INR' ) ? trim( $res['OptnlAdminandOthrExp'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OptnlAdminandOthrExp'] ));
                                $res1['OptnlProfit'] = ( $curreny_code == 'INR' ) ? trim( $res['OptnlProfit'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OptnlProfit'] ));
                                $res1['EBITDA'] = ( $curreny_code == 'INR' ) ? trim( $res['EBITDA'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EBITDA'] ));
                                $res1['Interest'] = ( $curreny_code == 'INR' ) ? trim( $res['Interest'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Interest'] ));
                                $res1['EBDT'] = ( $curreny_code == 'INR' ) ? trim( $res['EBDT'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EBDT'] ));
                                $res1['Depreciation'] = ( $curreny_code == 'INR' ) ? trim( $res['Depreciation'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Depreciation'] ));
                                $res1['EBT'] = ( $curreny_code == 'INR' ) ? trim( $res['EBT'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EBT'] ));
                                $res1['Tax'] = ( $curreny_code == 'INR' ) ? trim( $res['Tax'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Tax'] ));
                                $res1['PAT'] = ( $curreny_code == 'INR' ) ? trim( $res['PAT'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['PAT'] ));
                                $res1['FY'] = trim( $res['FY'] );
                                $res1['TotalIncome'] = ( $curreny_code == 'INR' ) ? trim( $res['TotalIncome'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalIncome'] ));
                                $res1['BINR'] = ( $curreny_code == 'INR' ) ? trim( $res['BINR'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['BINR'] ));
                                $res1['DINR'] = ( $curreny_code == 'INR' ) ? trim( $res['DINR'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DINR'] ));
                                /*$res1['EmployeeRelatedExpenses'] = $res['EmployeeRelatedExpenses'];
                                $res1['EarninginForeignExchange'] = $res['EarninginForeignExchange'];
                                $res1['OutgoinForeignExchange'] = $res['OutgoinForeignExchange'];*/
                                if($res['EmployeeRelatedExpenses']!= ""){
                                    $EmployeeRelatedExpenses1 = ( $curreny_code == 'INR' ) ? trim( $res['EmployeeRelatedExpenses'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EmployeeRelatedExpenses'] ));
                                }else{
                                    $EmployeeRelatedExpenses1 = "0";
                                }
                                $res1['EmployeeRelatedExpenses'] = $EmployeeRelatedExpenses1;

                                if($res['EarninginForeignExchange']!= ""){
                                    $EarninginForeignExchange1 = ( $curreny_code == 'INR' ) ? trim( $res['EarninginForeignExchange'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['EarninginForeignExchange'] ));
                                }else{
                                    $EarninginForeignExchange1 = "0";
                                }
                                $res1['EarninginForeignExchange'] = $EarninginForeignExchange1;

                                if($res['OutgoinForeignExchange']!= ""){
                                    $OutgoinForeignExchange1 = ( $curreny_code == 'INR' ) ? trim( $res['OutgoinForeignExchange'] ) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OutgoinForeignExchange'] ));
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
                                    $res1['ShareCapital'] = ( $curreny_code == 'INR' ) ? trim($res['ShareCapital']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareCapital'] ));
                                    $res1['ShareApplication'] = ( $curreny_code == 'INR' ) ? trim($res['ShareApplication']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareApplication'] ));
                                    $res1['ReservesSurplus'] = ( $curreny_code == 'INR' ) ? trim($res['ReservesSurplus']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ReservesSurplus'] ));
                                    $res1['TotalFunds'] = ( $curreny_code == 'INR' ) ? trim($res['TotalFunds']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalFunds'] ));
                                    $res1['SecuredLoans'] = ( $curreny_code == 'INR' ) ? trim($res['SecuredLoans']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SecuredLoans'] ));
                                    $res1['UnSecuredLoans'] = ( $curreny_code == 'INR' ) ? trim($res['UnSecuredLoans']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['UnSecuredLoans'] ));
                                    $res1['LoanFunds'] = ( $curreny_code == 'INR' ) ? trim($res['LoanFunds']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LoanFunds'] ));
                                    $res1['OtherLiabilities'] = ( $curreny_code == 'INR' ) ? trim($res['OtherLiabilities']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherLiabilities'] ));
                                    $res1['DeferredTax'] = ( $curreny_code == 'INR' ) ? trim($res['DeferredTax']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DeferredTax'] ));
                                    $res1['SourcesOfFunds'] = ( $curreny_code == 'INR' ) ? trim($res['SourcesOfFunds']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SourcesOfFunds'] ));
                                    $res1['GrossBlock'] = ( $curreny_code == 'INR' ) ? trim($res['GrossBlock']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['GrossBlock'] ));
                                    $res1['LessAccumulated'] = ( $curreny_code == 'INR' ) ? trim($res['LessAccumulated']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LessAccumulated'] ));
                                    $res1['NetBlock'] = ( $curreny_code == 'INR' ) ? trim($res['NetBlock']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['NetBlock'] ));
                                    $res1['CapitalWork'] = ( $curreny_code == 'INR' ) ? trim($res['CapitalWork']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CapitalWork'] ));
                                    $res1['FixedAssets'] = ( $curreny_code == 'INR' ) ? trim($res['FixedAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['FixedAssets'] ));
                                    $res1['IntangibleAssets'] = ( $curreny_code == 'INR' ) ? trim($res['IntangibleAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['IntangibleAssets'] ));
                                    $res1['OtherNonCurrent'] = ( $curreny_code == 'INR' ) ? trim($res['OtherNonCurrent']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherNonCurrent'] ));
                                    $res1['Investments'] = ( $curreny_code == 'INR' ) ? trim($res['Investments']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Investments'] ));
                                    $res1['DeferredTaxAssets'] = ( $curreny_code == 'INR' ) ? trim($res['DeferredTaxAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DeferredTaxAssets'] ));
                                    $res1['SundryDebtors'] = ( $curreny_code == 'INR' ) ? trim($res['SundryDebtors']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SundryDebtors'] ));
                                    $res1['CashBankBalances'] = ( $curreny_code == 'INR' ) ? trim($res['CashBankBalances']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CashBankBalances'] ));
                                    $res1['Inventories'] = ( $curreny_code == 'INR' ) ? trim($res['Inventories']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Inventories'] ));
                                    $res1['LoansAdvances'] = ( $curreny_code == 'INR' ) ? trim($res['LoansAdvances']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LoansAdvances'] ));
                                    $res1['OtherCurrentAssets'] = ( $curreny_code == 'INR' ) ? trim($res['OtherCurrentAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherCurrentAssets'] ));
                                    $res1['CurrentAssets'] = ( $curreny_code == 'INR' ) ? trim($res['CurrentAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CurrentAssets'] ));
                                    $res1['Provisions'] = ( $curreny_code == 'INR' ) ? trim($res['Provisions']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Provisions'] ));
                                    $res1['CurrentLiabilitiesProvision'] = ( $curreny_code == 'INR' ) ? trim($res['CurrentLiabilitiesProvision']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CurrentLiabilitiesProvision'] ));
                                    $res1['NetCurrentAssets'] = ( $curreny_code == 'INR' ) ? trim($res['NetCurrentAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['NetCurrentAssets'] ));
                                    $res1['ProfitLoss'] = ( $curreny_code == 'INR' ) ? trim($res['ProfitLoss']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ProfitLoss'] ));
                                    $res1['Miscellaneous'] = ( $curreny_code == 'INR' ) ? trim($res['Miscellaneous']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Miscellaneous'] ));
                                    $res1['TotalAssets'] = ( $curreny_code == 'INR' ) ? trim($res['TotalAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalAssets'] ));
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
                                        $res1['ShareCapital'] = ( $curreny_code == 'INR' ) ? trim($res['ShareCapital']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareCapital'] ));
                                        $res1['ShareApplication'] = ( $curreny_code == 'INR' ) ? trim($res['ShareApplication']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareApplication'] ));
                                        $res1['ReservesSurplus'] = ( $curreny_code == 'INR' ) ? trim($res['ReservesSurplus']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ReservesSurplus'] ));
                                        $res1['TotalFunds'] = ( $curreny_code == 'INR' ) ? trim($res['TotalFunds']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalFunds'] ));
                                        $res1['SecuredLoans'] = ( $curreny_code == 'INR' ) ? trim($res['SecuredLoans']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SecuredLoans'] ));
                                        $res1['UnSecuredLoans'] = ( $curreny_code == 'INR' ) ? trim($res['UnSecuredLoans']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['UnSecuredLoans'] ));
                                        $res1['LoanFunds'] = ( $curreny_code == 'INR' ) ? trim($res['LoanFunds']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LoanFunds'] ));
                                        $res1['OtherLiabilities'] = ( $curreny_code == 'INR' ) ? trim($res['OtherLiabilities']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherLiabilities'] ));
                                        $res1['DeferredTax'] = ( $curreny_code == 'INR' ) ? trim($res['DeferredTax']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DeferredTax'] ));
                                        $res1['SourcesOfFunds'] = ( $curreny_code == 'INR' ) ? trim($res['SourcesOfFunds']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SourcesOfFunds'] ));
                                        $res1['GrossBlock'] = ( $curreny_code == 'INR' ) ? trim($res['GrossBlock']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['GrossBlock'] ));
                                        $res1['LessAccumulated'] = ( $curreny_code == 'INR' ) ? trim($res['LessAccumulated']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LessAccumulated'] ));
                                        $res1['NetBlock'] = ( $curreny_code == 'INR' ) ? trim($res['NetBlock']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['NetBlock'] ));
                                        $res1['CapitalWork'] = ( $curreny_code == 'INR' ) ? trim($res['CapitalWork']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CapitalWork'] ));
                                        $res1['FixedAssets'] = ( $curreny_code == 'INR' ) ? trim($res['FixedAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['FixedAssets'] ));
                                        $res1['IntangibleAssets'] = ( $curreny_code == 'INR' ) ? trim($res['IntangibleAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['IntangibleAssets'] ));
                                        $res1['OtherNonCurrent'] = ( $curreny_code == 'INR' ) ? trim($res['OtherNonCurrent']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherNonCurrent'] ));
                                        $res1['Investments'] = ( $curreny_code == 'INR' ) ? trim($res['Investments']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Investments'] ));
                                        $res1['DeferredTaxAssets'] = ( $curreny_code == 'INR' ) ? trim($res['DeferredTaxAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['DeferredTaxAssets'] ));
                                        $res1['SundryDebtors'] = ( $curreny_code == 'INR' ) ? trim($res['SundryDebtors']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['SundryDebtors'] ));
                                        $res1['CashBankBalances'] = ( $curreny_code == 'INR' ) ? trim($res['CashBankBalances']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CashBankBalances'] ));
                                        $res1['Inventories'] = ( $curreny_code == 'INR' ) ? trim($res['Inventories']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Inventories'] ));
                                        $res1['LoansAdvances'] = ( $curreny_code == 'INR' ) ? trim($res['LoansAdvances']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['LoansAdvances'] ));
                                        $res1['OtherCurrentAssets'] = ( $curreny_code == 'INR' ) ? trim($res['OtherCurrentAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['OtherCurrentAssets'] ));
                                        $res1['CurrentAssets'] = ( $curreny_code == 'INR' ) ? trim($res['CurrentAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CurrentAssets'] ));
                                        $res1['Provisions'] = ( $curreny_code == 'INR' ) ? trim($res['Provisions']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Provisions'] ));
                                        $res1['CurrentLiabilitiesProvision'] = ( $curreny_code == 'INR' ) ? trim($res['CurrentLiabilitiesProvision']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['CurrentLiabilitiesProvision'] ));
                                        $res1['NetCurrentAssets'] = ( $curreny_code == 'INR' ) ? trim($res['NetCurrentAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['NetCurrentAssets'] ));
                                        $res1['ProfitLoss'] = ( $curreny_code == 'INR' ) ? trim($res['ProfitLoss']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ProfitLoss'] ));
                                        $res1['Miscellaneous'] = ( $curreny_code == 'INR' ) ? trim($res['Miscellaneous']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Miscellaneous'] ));
                                        $res1['TotalAssets'] = ( $curreny_code == 'INR' ) ? trim($res['TotalAssets']) : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalAssets'] ));
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
                                    $res1['ShareCapital'] = ( $curreny_code == 'INR' ) ? $res['ShareCapital'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareCapital'] ));
                                    $res1['ReservesSurplus'] = ( $curreny_code == 'INR' ) ? $res['ReservesSurplus'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ReservesSurplus'] ));
                                    $res1['TotalFunds'] = ( $curreny_code == 'INR' ) ? $res['TotalFunds'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalFunds'] ));
                                    $res1['ShareApplication'] = ( $curreny_code == 'INR' ) ? $res['ShareApplication'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareApplication'] ));
                                    $res1['L_term_borrowings'] = ( $curreny_code == 'INR' ) ? $res['L_term_borrowings'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_borrowings'] ));
                                    $res1['deferred_tax_liabilities'] = ( $curreny_code == 'INR' ) ? $res['deferred_tax_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['deferred_tax_liabilities'] ));
                                    $res1['O_long_term_liabilities'] = ( $curreny_code == 'INR' ) ? $res['O_long_term_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_long_term_liabilities'] ));
                                    $res1['L_term_provisions'] = ( $curreny_code == 'INR' ) ? $res['L_term_provisions'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_provisions'] )); 
                                    $res1['T_non_current_liabilities'] = ( $curreny_code == 'INR' ) ? $res['T_non_current_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_non_current_liabilities'] ));
                                    $res1['S_term_borrowings'] = ( $curreny_code == 'INR' ) ? $res['S_term_borrowings'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_borrowings'] ));
                                    $res1['Trade_payables'] = ( $curreny_code == 'INR' ) ? $res['Trade_payables'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Trade_payables'] ));
                                    $res1['O_current_liabilities'] = ( $curreny_code == 'INR' ) ? $res['O_current_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_current_liabilities'] ));
                                    $res1['S_term_provisions'] = ( $curreny_code == 'INR' ) ? $res['S_term_provisions'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_provisions'] ));
                                    $res1['T_current_liabilities'] = ( $curreny_code == 'INR' ) ? $res['T_current_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_current_liabilities'] ));
                                    $res1['T_equity_liabilities'] = ( $curreny_code == 'INR' ) ? $res['T_equity_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_equity_liabilities'] ));
                                    $res1['Tangible_assets'] = ( $curreny_code == 'INR' ) ? $res['Tangible_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Tangible_assets'] ));     
                                    $res1['Intangible_assets'] = ( $curreny_code == 'INR' ) ? $res['Intangible_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Intangible_assets'] ));
                                    $res1['T_fixed_assets'] = ( $curreny_code == 'INR' ) ? $res['T_fixed_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_fixed_assets'] ));
                                    $res1['N_current_investments'] = ( $curreny_code == 'INR' ) ? $res['N_current_investments'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['N_current_investments'] ));
                                    $res1['Deferred_tax_assets'] = ( $curreny_code == 'INR' ) ? $res['Deferred_tax_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Deferred_tax_assets'] ));
                                    $res1['L_term_loans_advances'] = ( $curreny_code == 'INR' ) ? $res['L_term_loans_advances'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_loans_advances'] ));
                                    $res1['O_non_current_assets'] = ( $curreny_code == 'INR' ) ? $res['O_non_current_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_non_current_assets'] ));
                                    $res1['T_non_current_assets'] = ( $curreny_code == 'INR' ) ? $res['T_non_current_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_non_current_assets'] ));
                                    $res1['Current_investments'] = ( $curreny_code == 'INR' ) ? $res['Current_investments'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Current_investments'] ));

                                    $res1['Inventories'] = ( $curreny_code == 'INR' ) ? $res['Inventories'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Inventories'] ));
                                    $res1['Trade_receivables'] = ( $curreny_code == 'INR' ) ? $res['Trade_receivables'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Trade_receivables'] ));
                                    $res1['Cash_bank_balances'] = ( $curreny_code == 'INR' ) ? $res['Cash_bank_balances'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Cash_bank_balances'] ));
                                    $res1['S_term_loans_advances'] = ( $curreny_code == 'INR' ) ? $res['S_term_loans_advances'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_loans_advances'] ));
                                    $res1['O_current_assets'] = ( $curreny_code == 'INR' ) ? $res['O_current_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_current_assets'] ));
                                    $res1['T_current_assets'] = ( $curreny_code == 'INR' ) ? $res['T_current_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_current_assets'] ));
                                    $res1['Total_assets'] = ( $curreny_code == 'INR' ) ? $res['Total_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Total_assets'] ));
                                    
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
                                    $res1['ShareCapital'] = ( $curreny_code == 'INR' ) ? $res['ShareCapital'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareCapital'] ));
                                    $res1['ReservesSurplus'] = ( $curreny_code == 'INR' ) ? $res['ReservesSurplus'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ReservesSurplus'] ));
                                    $res1['TotalFunds'] = ( $curreny_code == 'INR' ) ? $res['TotalFunds'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['TotalFunds'] ));
                                    $res1['ShareApplication'] = ( $curreny_code == 'INR' ) ? $res['ShareApplication'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['ShareApplication'] ));
                                    $res1['L_term_borrowings'] = ( $curreny_code == 'INR' ) ? $res['L_term_borrowings'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_borrowings'] ));
                                    $res1['deferred_tax_liabilities'] = ( $curreny_code == 'INR' ) ? $res['deferred_tax_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['deferred_tax_liabilities'] ));
                                    $res1['O_long_term_liabilities'] = ( $curreny_code == 'INR' ) ? $res['O_long_term_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_long_term_liabilities'] ));
                                    $res1['L_term_provisions'] = ( $curreny_code == 'INR' ) ? $res['L_term_provisions'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_provisions'] )); 
                                    $res1['T_non_current_liabilities'] = ( $curreny_code == 'INR' ) ? $res['T_non_current_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_non_current_liabilities'] ));
                                    $res1['S_term_borrowings'] = ( $curreny_code == 'INR' ) ? $res['S_term_borrowings'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_borrowings'] ));
                                    $res1['Trade_payables'] = ( $curreny_code == 'INR' ) ? $res['Trade_payables'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Trade_payables'] ));
                                    $res1['O_current_liabilities'] = ( $curreny_code == 'INR' ) ? $res['O_current_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_current_liabilities'] ));
                                    $res1['S_term_provisions'] = ( $curreny_code == 'INR' ) ? $res['S_term_provisions'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_provisions'] ));
                                    $res1['T_current_liabilities'] = ( $curreny_code == 'INR' ) ? $res['T_current_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_current_liabilities'] ));
                                    $res1['T_equity_liabilities'] = ( $curreny_code == 'INR' ) ? $res['T_equity_liabilities'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_equity_liabilities'] ));
                                    $res1['Tangible_assets'] = ( $curreny_code == 'INR' ) ? $res['Tangible_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Tangible_assets'] ));     
                                    $res1['Intangible_assets'] = ( $curreny_code == 'INR' ) ? $res['Intangible_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Intangible_assets'] ));
                                    $res1['T_fixed_assets'] = ( $curreny_code == 'INR' ) ? $res['T_fixed_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_fixed_assets'] ));
                                    $res1['N_current_investments'] = ( $curreny_code == 'INR' ) ? $res['N_current_investments'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['N_current_investments'] ));
                                    $res1['Deferred_tax_assets'] = ( $curreny_code == 'INR' ) ? $res['Deferred_tax_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Deferred_tax_assets'] ));
                                    $res1['L_term_loans_advances'] = ( $curreny_code == 'INR' ) ? $res['L_term_loans_advances'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['L_term_loans_advances'] ));
                                    $res1['O_non_current_assets'] = ( $curreny_code == 'INR' ) ? $res['O_non_current_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_non_current_assets'] ));
                                    $res1['T_non_current_assets'] = ( $curreny_code == 'INR' ) ? $res['T_non_current_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_non_current_assets'] ));
                                    $res1['Current_investments'] = ( $curreny_code == 'INR' ) ? $res['Current_investments'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Current_investments'] ));
                                    $res1['Inventories'] = ( $curreny_code == 'INR' ) ? $res['Inventories'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Inventories'] ));
                                    $res1['Trade_receivables'] = ( $curreny_code == 'INR' ) ? $res['Trade_receivables'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Trade_receivables'] ));
                                    $res1['Cash_bank_balances'] = ( $curreny_code == 'INR' ) ? $res['Cash_bank_balances'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Cash_bank_balances'] ));
                                    $res1['S_term_loans_advances'] = ( $curreny_code == 'INR' ) ? $res['S_term_loans_advances'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['S_term_loans_advances'] ));
                                    $res1['O_current_assets'] = ( $curreny_code == 'INR' ) ? $res['O_current_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['O_current_assets'] ));
                                    $res1['T_current_assets'] = ( $curreny_code == 'INR' ) ? $res['T_current_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['T_current_assets'] ));
                                    $res1['Total_assets'] = ( $curreny_code == 'INR' ) ? $res['Total_assets'] : (string)($currencyValue[ trim( $res['FY'] ) ]*trim( $res['Total_assets'] ));
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
                        include_once('simple_html_dom.php');
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
                        
                        
//---------------------- Filing for amazon--------------------------------------------------------------------------------------------------------------

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
                        
//---------------------List of director and details-------------------------------------------------------------------------------------------------------

                        //Data from MCA website 
                        /*$companydirectorsdata = array();
                        try{ */
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
                                /*$$DirectorsMasterForm = $LLPMaster->find('form[id=exportCompanyMasterData]', 0);
                                
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
                            /*}*/  
                       /* }catch (Exception $e) {
                            echo $e;
                        }*/
                        /*if(!empty($companydirectorsdata)){
                            
                            $data['companydirectorsdata'] = $companydirectorsdata;
                        }else{
                            $data['companydirectorsdata'] = "";
                        }*/

//---------------------Get Rating--------------------------------------------------------------------------------------------------------------------
                        
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
                        
// --------------------Indexofcharge----------------------------------------------------------------------------------------------------------------------
                       
                        /*$indexchargerows = array();
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
                           }*/
                           
//-----------------------------------------------------------Funding Details------------------------------------------------------------------------------------------
$getcompanysql = "select PECompanyId from pecompanies where CINNo ='".$_POST['cin']."'";
$companyrs = mysql_query($getcompanysql);          
$myrow=mysql_fetch_array($companyrs);
$fundingArray = array();
if( count($myrow) > 0 && $myrow['PECompanyId']!='') {
    //Main Query to get all the deal by company id
    $sql = "SELECT distinct pe.PECompanyId as PECompanyId,
            pec.companyname, 
            pec.industry, 
            i.industry as industry,
            pec.sector_business as sector_business, 
            pe.amount,
            DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , 
            pe.PEId, 
            pe.hideamount,
            pe.StageId,
            pe.SPV,
            pe.AggHide,
            pe.dates as dates,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
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
        
        if($myrow["AggHide"]==1 && $myrow["SPV"]==0)
        {
            $NoofDealsCntTobeDeducted=1;
            $amtTobeDeductedforAggHide=$myrow["amount"];
            
        }elseif($myrow["SPV"]==1 && $myrow["AggHide"]==0){

            $NoofDealsCntTobeDeducted=1;
            $amtTobeDeductedforAggHide=$myrow["amount"];
        }elseif($myrow["SPV"]==1 && $myrow["AggHide"]==1){
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
//-----------------------------------------------------------similar companies------------------------------------------------------------------------------------------
                           
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
                        if(!empty($sim_array)){
                            
                            $data['similar_companies'] = $sim_array;
                        }else{
                            $data['similar_companies'] = "";
                        }*/     
                        
                        $datas['Result'] = $data;
                        
                    }else{
                        $datas['Status'] = "Failure";
                        $datas['Result'] = "CIN not match with any company";
                    }
                } else {
                    $datas[ "Status" ] = "Failure";
                    $datas[ 'Result' ] = "Currency code not found";
                }

                } else {
                    $datas['Status'] = "Failure";
                    $datas['Result'] = "CIN not found";
                }
                    header('Content-Type: application/json');
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
    $convertnumber = $amount*$curr_value;
    return (string)$convertnumber;
}

 mysql_close(); ?>