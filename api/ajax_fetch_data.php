<?php
ob_start();
require_once '../dbconnectvi.php';
$dirPath = dirname(__DIR__) . '/cfsnew/';
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

$username = $_POST["api_userName"];
$password = $_POST["api_password"];
if( isset( $_POST[ 'jsonl_gen' ] ) ) {
    $jsonl_gen = true;
}
if( isset( $_POST[ 'is_admin' ] ) ) {
    $is_admin = true;
}
if( isset( $_POST[ 'user_check' ] ) ) {
    $userCheck = true;
} else {
    $userCheck = false;
}
if( $jsonl_gen ) {
    $ext = pathinfo($_FILES[ 'excel_file' ][ 'name' ], PATHINFO_EXTENSION);
    if( $ext == 'csv' ) {
        $file = fopen( $_FILES[ 'excel_file' ][ 'tmp_name' ],"r");
        while( !feof( $file ) ) {
            $exCin = fgetcsv( $file );
            $cinArray[] = $exCin[ 0 ];
        }
        if( count( $cinArray ) > 150 ) {
            $data['Result'] = "CIN Limit exceeds the 150 numbers";
            $responseArray = array( 'html' => '', 'Status' => 'Failure', 'jsonresp' => $data );
            echo json_encode($responseArray);
            exit;
        }
        fclose($file);    
    } else {
        $data['Result'] = "Please choose CSV file";
        $responseArray = array( 'html' => '', 'Status' => 'Failure', 'jsonresp' => $data );
        echo json_encode($responseArray);
        exit;
    }
} else {
    if( !empty( $_POST[ 'cin' ] ) ) {
        foreach( $_POST[ 'cin' ] as $cin ) {
            if( !empty( $cin ) ) {
                $cinArray[] = $cin;
            }
        }
    }
}
$curreny_code = $_POST["currency_code"];
$cin = implode("','", $cinArray); 
$currencyValue = getCurrencyRate();
$success = $failure = '';
$processLoginFlag = 0;

if( !$is_admin || $userCheck ) {
    $Rs = $users->selectByUsernameNew($username,$password);
    if(($username =='') || ($password =='')){
        $data['Result'] = "Invalid username or password";
        $responseArray = array( 'html' => '', 'Status' => 'Failure', 'jsonresp' => $data );
        echo json_encode($responseArray);
        exit;
    }
    elseif(($username !='') && ($password !='')){
       
        $authAdmin = $users->selectByUName($username);
        $UName = $authAdmin['username'];
        $Pwd = $authAdmin['user_password'];
        $groupstatus = $grouplist->select($authAdmin['GroupList']);
    } 
    if($username == $UName && md5($password) == $Pwd && $username != "" && $_POST['api_password'] !="" && $authAdmin['usr_flag'] != 0 && $groupstatus['status'] == 0 ) {
        $groupId = $authAdmin['GroupList'];
        $groupIp = $grouplist->getGroupIP($groupId);
        
        $groupPocArray = $grouplist->getGroupEmail($groupId);
        $groupPoc = $groupPocArray['poc'];

        if (count($groupIp) > 0){ //Process IP Restriction only if user has IP addeded to account
            //$ipRangeNew = '49.207.182.159';
            $ipRangeNew = $_SERVER['REMOTE_ADDR'];
            if (checkIpRange($ipRangeNew,$groupId)){ //Check if users Ip falls within the range
                $processLoginFlag = 1;

            }else{
                
                $data['Result'] = "Login Error - Device not authorized. Please contact Admin";
                $responseArray = array( 'html' => '', 'Status' => 'Failure', 'jsonresp' => $data );
                echo json_encode($responseArray);
                exit;
            }
        }else{
            $processLoginFlag = 1;
            
        }
    } else if(($username !='') && ($authAdmin['usr_flag'] == '0' ||  $groupstatus['status']!=0 )){
        $data['Result'] = "User Account Not Yet activated. Please contact Admin";
        $responseArray = array( 'html' => '', 'Status' => 'Failure', 'jsonresp' => $data );
        echo json_encode($responseArray);
        exit;
    } else {
        $data['Result'] = "Invalid username or password";
        $responseArray = array( 'html' => '', 'Status' => 'Failure', 'jsonresp' => $data );
        echo json_encode($responseArray);
        exit;
    } 
} else {
    $processLoginFlag = 1;
}
    
if( $processLoginFlag == 1 ) {
    // CIN Processing started
    $companySql = "SELECT b.Old_CIN,b.CIN, b.FCompanyName, b.Company_Id, b.SCompanyName, max(a.ResultType) as ResultType FROM plstandard a INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY INNER JOIN ( SELECT CId_FK, max(FY) as MFY FROM plstandard GROUP BY CId_FK ) as aa ON a.CId_FK = aa.CId_FK AND a.FY = aa.MFY WHERE b.ListingStatus IN (1,2,3,4) and b.Permissions1 IN (0,1) and b.UserStatus = 0 and b.Industry != '' and b.State != '' and b.CIN IN('" . $cin . "') GROUP BY b.SCompanyName ORDER BY b.CIN ASC";
    $companyRes = mysql_query( $companySql ) or die( mysql_error() );
    $companyRows = mysql_num_rows( $companyRes );
    $str = '<table>
                <thead>
                    <tr>
                        <th>Company ID</th>
                        <th>Company name</th>
                        <th>Company Profile</th>
                        <th>CIN</th>
                        <th>Financials</th>
                        <th>Funding</th>
                    </tr>
                </thead>
                <tbody>';
    if( $companyRows > 0 ) { // CIN Rows check
        while( $companyResult = mysql_fetch_array( $companyRes ) ) { // Looping through Company data.
            if( !empty( $companyResult[ 'CIN' ] ) || $companyResult[ 'CIN' ] != '' ) {
                $c = $companyResult['FCompanyName'];
                $cprofile_id = $companyResult[ 'Company_Id' ];
                $data['companyName'] = $c;
                $data[ "CIN" ] = $companyResult[ 'CIN' ];
                $data['Old_CINs'] = $companyResult['Old_CIN'];
                $data[ 'companyID' ] = $cprofile_id;
                $data['PreviouslyKnownAs'] = $companyResult['SCompanyName'];
                if($companyResult['ResultType'] == 1){ 
                    $financialinfo = '<span class="financialinfo-link info-link">Standalone</span>&nbsp;/&nbsp;<span class="financialinfo-link-con info-link">Consolidated</span>';
                } else if($companyResult['ResultType'] == 0){
                    $financialinfo = '<span class="financialinfo-link info-link">Standalone</span>';
                }
                $data_inner = array();
                $data_inner_1=array();
                $data_inner_2=array();
                $str .= '<tr>
                            <td>' . $companyResult[ 'Company_Id' ] . '</td>
                            <td>' . $companyResult['FCompanyName'] . '</td>
                            <!-- <td>' . $companyResult['SCompanyName'] . '</td> -->
                            <td><span class="companyinfo-link info-link">Show details</span></td>
                            <td>' . $companyResult[ 'CIN' ] . '</td>
                            <td>'.$financialinfo.'</td>
                            <td><span class="fundinginfo-link info-link">Show details</span></td>
                        </tr>';
                $str .= '<tr class="infoTR financialRow" style="display: none;">
                            <td colspan="6" class="no-pd">
                                <div class="fin-wpr">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#plstd' . $cprofile_id . '">PL standard</a></li>
                                        <li><a data-toggle="tab" href="#growth_per' . $cprofile_id . '">Growth percentage</a></li>
                                        <li><a data-toggle="tab" href="#balan_shet' . $cprofile_id . '">Balance sheet</a></li>
                                        <li><a data-toggle="tab" href="#ratio_balan' . $cprofile_id . '">Ratio of balance sheet</a></li>
                                        <li><a data-toggle="tab" href="#balan_shet_new' . $cprofile_id . '">Balance sheet<span>New</span></a></li>
                                        <li><a data-toggle="tab" href="#ratio_balan_new' . $cprofile_id . '">Ratio of balance sheet<span>New</span></a></li>
                                    </ul>
                                    <div class="tab-content tbl-cnt">
                                        <div id="plstd' . $cprofile_id . '" class="tab-pane fade in active">';
                //PL STANDARD STARTED
                $res1 = array();
                $plQuery = "SELECT PLStandard_Id,CId_FK,IndustryId_FK,OptnlIncome,OtherIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,FY,TotalIncome,BINR,DINR,EmployeeRelatedExpenses,ForeignExchangeEarningandOutgo,EarninginForeignExchange,OutgoinForeignExchange FROM plstandard WHERE CId_FK = '" . $cprofile_id . "' and FY !='' and ResultType='0' ORDER BY FY DESC LIMIT 0,100";
                $PLStsQry = mysql_query( $plQuery ) or die( mysql_error() );
                if( mysql_num_rows( $PLStsQry) > 0 ) {
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>PLStandard_Id</span></li>
                                                <li><span>CId_FK</span></li>
                                                <li><span>IndustryId_FK</span></li>
                                                <li><span>OptnlIncome</span></li>
                                                <li><span>OtherIncome</span></li>
                                                <li><span>OptnlAdminandOthrExp</span></li>
                                                <li><span>OptnlProfit</span></li>
                                                <li><span>EBITDA</span></li>
                                                <li><span>Interest</span></li>
                                                <li><span>EBDT</span></li>
                                                <li><span>Depreciation</span></li>
                                                <li><span>EBT</span></li>
                                                <li><span>Tax</span></li>
                                                <li><span>PAT</span></li>
                                                <li><span>TotalIncome</span></li>
                                                <li><span>BINR</span></li>
                                                <li><span>DINR</span></li>
                                                <li><span>EmployeeRelatedExpenses</span></li>
                                                <li><span>EarninginForeignExchange</span></li>
                                                <li><span>OutgoinForeignExchange</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
                    while( $res = mysql_fetch_array( $PLStsQry ) ) {
                        $res1 = array();
                        $res1['PLStandard_Id'] = trim($res['PLStandard_Id']);
                        $res1['CId_FK'] = trim($res['CId_FK']);
                        $res1['IndustryId_FK'] = trim( $res['IndustryId_FK']);
                        $res1['OptnlIncome_INR'] = trim( $res['OptnlIncome'] );
                        $res1['OptnlIncome_USD'] = (string)(trim( $res['OptnlIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['OtherIncome_INR'] = trim( $res['OtherIncome'] );
                        $res1['OtherIncome_USD'] = (string)(trim( $res['OtherIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['OptnlAdminandOthrExp_INR'] = trim( $res['OptnlAdminandOthrExp'] );
                        $res1['OptnlAdminandOthrExp_USD'] = (string)(trim( $res['OptnlAdminandOthrExp'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['OptnlProfit_INR'] = trim( $res['OptnlProfit'] );
                        $res1['OptnlProfit_USD'] = (string)(trim( $res['OptnlProfit'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['EBITDA_INR'] = trim( $res['EBITDA'] );
                        $res1['EBITDA_USD'] = (string)(trim( $res['EBITDA'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['Interest_INR'] = trim( $res['Interest'] );
                        $res1['Interest_USD'] = (string)(trim( $res['Interest'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['EBDT_INR'] = trim( $res['EBDT'] );
                        $res1['EBDT_USD'] = (string)(trim( $res['EBDT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['Depreciation_INR'] = trim( $res['Depreciation'] );
                        $res1['Depreciation_USD'] = (string)(trim( $res['Depreciation'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['EBT_INR'] = trim( $res['EBT'] );
                        $res1['EBT_USD'] = (string)(trim( $res['EBT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['Tax_INR'] = trim( $res['Tax'] );
                        $res1['Tax_USD'] = (string)(trim( $res['Tax'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['PAT_INR'] = trim( $res['PAT'] );
                        $res1['PAT_USD'] = (string)(trim( $res['PAT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['FY'] = trim( $res['FY'] );
                        $res1['TotalIncome_INR'] = trim( $res['TotalIncome'] );
                        $res1['TotalIncome_USD'] = (string)(trim( $res['TotalIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['BINR_INR'] = trim( $res['BINR'] );
                        $res1['BINR_USD'] = (string)(trim( $res['BINR'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['DINR_INR'] = trim( $res['DINR'] );
                        $res1['DINR_USD'] = (string)(trim( $res['DINR'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        if($res['EmployeeRelatedExpenses']!= ""){
                            $EmployeeRelatedExpenses1_INR = trim( $res['EmployeeRelatedExpenses'] );
                            $EmployeeRelatedExpenses1_USD = (string)(trim( $res['EmployeeRelatedExpenses'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        }else{
                            $EmployeeRelatedExpenses1_INR = $EmployeeRelatedExpenses1_USD = "0";
                        }
                        $res1['EmployeeRelatedExpenses_INR'] = $EmployeeRelatedExpenses1_INR;
                        $res1['EmployeeRelatedExpenses_USD'] = $EmployeeRelatedExpenses1_USD;

                        if($res['EarninginForeignExchange']!= ""){
                            $EarninginForeignExchange1_INR = trim( $res['EarninginForeignExchange'] );
                            $EarninginForeignExchange1_USD = (string)(trim( $res['EarninginForeignExchange'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        }else{
                            $EarninginForeignExchange1_INR = $EarninginForeignExchange1_USD = "0";
                        }
                        $res1['EarninginForeignExchange_INR'] = $EarninginForeignExchange1_INR;
                        $res1['EarninginForeignExchange_USD'] = $EarninginForeignExchange1_USD;

                        if($res['OutgoinForeignExchange']!= ""){
                            $OutgoinForeignExchange1_INR = trim( $res['OutgoinForeignExchange'] );
                            $OutgoinForeignExchange1_USD = (string)(trim( $res['OutgoinForeignExchange'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        }else{
                            $OutgoinForeignExchange1_INR = $OutgoinForeignExchange1_USD = "0";
                        }
                        $res1['OutgoinForeignExchange_INR'] = $OutgoinForeignExchange1_INR;
                        $res1['OutgoinForeignExchange_USD'] = $OutgoinForeignExchange1_USD;
                        
                        // if(! empty( $res1 ) ) {
                        //     $data_inner['plstandard'][] = $res1;
                        // }else{
                        //     $data_inner['plstandard'][] = "";
                        // }
                        if(! empty( $res1 ) ) {
                            $data_inner_1['Standalone'][] = $res1;
                        }else{
                            $data_inner_1['Standalone'][] = "";
                        }
                         if(! empty( $data_inner_1 ) ) {
                            $data_inner['plstandard'] = $data_inner_1;
                        }else{
                            $data_inner['plstandard'] = "";
                        }
                                            $OptnlIncome = ( $curreny_code == 'INR' ) ? trim( $res['OptnlIncome'] ) : (string)(trim( $res['OptnlIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $OtherIncome = ( $curreny_code == 'INR' ) ? trim( $res['OtherIncome'] ) : (string)(trim( $res['OtherIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $OptnlAdminandOthrExp = ( $curreny_code == 'INR' ) ? trim( $res['OptnlAdminandOthrExp'] ) : (string)(trim( $res['OptnlAdminandOthrExp'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $OptnlProfit = ( $curreny_code == 'INR' ) ? trim( $res['OptnlProfit'] ) : (string)(trim( $res['OptnlProfit'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EBITDA = ( $curreny_code == 'INR' ) ? trim( $res['EBITDA'] ) : (string)(trim( $res['EBITDA'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $Interest = ( $curreny_code == 'INR' ) ? trim( $res['Interest'] ) : (string)(trim( $res['Interest'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EBDT = ( $curreny_code == 'INR' ) ? trim( $res['EBDT'] ) : (string)(trim( $res['EBDT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $Depreciation = ( $curreny_code == 'INR' ) ? trim( $res['Depreciation'] ) : (string)(trim( $res['Depreciation'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EBT = ( $curreny_code == 'INR' ) ? trim( $res['EBT'] ) : (string)(trim( $res['EBT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $Tax = ( $curreny_code == 'INR' ) ? trim( $res['Tax'] ) : (string)(trim( $res['Tax'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $PAT = ( $curreny_code == 'INR' ) ? trim( $res['PAT'] ) : (string)(trim( $res['PAT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $TotalIncome = ( $curreny_code == 'INR' ) ? trim( $res['TotalIncome'] ) : (string)(trim( $res['TotalIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $BINR = ( $curreny_code == 'INR' ) ? trim( $res['BINR'] ) : (string)(trim( $res['BINR'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $DINR = ( $curreny_code == 'INR' ) ? trim( $res['DINR'] ) : (string)(trim( $res['DINR'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EmployeeRelatedExpenses = ( $curreny_code == 'INR' ) ? trim( $res['EmployeeRelatedExpenses'] ) : (string)(trim( $res['EmployeeRelatedExpenses'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EarninginForeignExchange = ( $curreny_code == 'INR' ) ? trim( $res['EarninginForeignExchange'] ) : (string)(trim( $res['EarninginForeignExchange'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $OutgoinForeignExchange = ( $curreny_code == 'INR' ) ? trim( $res['OutgoinForeignExchange'] ) : (string)(trim( $res['OutgoinForeignExchange'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $str .= '<ul>
                                                        <li><span>' . trim( $res['FY'] ) . '</span></li>
                                                        <li><span>' . trim($res['PLStandard_Id']) . '</span></li>
                                                        <li><span>' . trim($res['CId_FK']) . '</span></li>
                                                        <li><span>' . trim( $res['IndustryId_FK']) . '</span></li>
                                                        <li><span>' . $OptnlIncome . '</span></li>
                                                        <li><span>' . $OtherIncome . '</span></li>
                                                        <li><span>' . $OptnlAdminandOthrExp . '</span></li>
                                                        <li><span>' . $OptnlProfit . '</span></li>
                                                        <li><span>' . $EBITDA . '</span></li>
                                                        <li><span>' . $Interest . '</span></li>
                                                        <li><span>' . $EBDT . '</span></li>
                                                        <li><span>' . $Depreciation . '</span></li>
                                                        <li><span>' . $EBT . '</span></li>
                                                        <li><span>' . $Tax . '</span></li>
                                                        <li><span>' . $PAT . '</span></li>
                                                        <li><span>' . $TotalIncome . '</span></li>
                                                        <li><span>' . $BINR . '</span></li>
                                                        <li><span>' . $DINR . '</span></li>
                                                        <li><span>' . $EmployeeRelatedExpenses . '</span></li>
                                                        <li><span>' . $EarninginForeignExchange . '</span></li>
                                                        <li><span>' . $OutgoinForeignExchange . '</span></li>
                                                    </ul>';
                    }
                    $str .= '                   </div>
                                            </div>';
                } else {
                    $str .= 'No data found.';
                }
                
                $str .= '               </div>
                                        <div id="growth_per' . $cprofile_id . '" class="tab-pane fade">';
                                        // GROWTH PERCENTAGE
                                        $growth = array();
                                        $max_pls=mysql_query("SELECT min(FY) as FY FROM plstandard WHERE CId_FK='".$cprofile_id."'");
                                        $max_pl = mysql_fetch_array($max_pls);

                                        $GrowthQry = mysql_query("SELECT g.GrowthPerc_Id,g.CId_FK,g.IndustryId_FK,g.OptnlIncome,g.OtherIncome,g.OptnlAdminandOthrExp,g.OptnlProfit,g.EBITDA,g.Interest,g.EBDT,g.Depreciation,g.EBT,g.Tax,g.PAT,g.FY,g.TotalIncome,g.BINR,g.DINR,g.EmployeeRelatedExpenses,g.ForeignExchangeEarningandOutgo,g.EarninginForeignExchange,g.OutgoinForeignExchange FROM growthpercentage as g 
                                                INNER JOIN plstandard p on(g.CId_FK = p.CId_FK)  WHERE p.CId_FK = ".$cprofile_id." and p.FY !='' and p.FY=g.FY and g.FY > '".$max_pl['FY']."' and p.ResultType='0' ORDER BY FY DESC LIMIT 0,100");
                                        if(mysql_num_rows($GrowthQry) > 0){
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>PLStandard_Id</span></li>
                                                <li><span>CId_FK</span></li>
                                                <li><span>IndustryId_FK</span></li>
                                                <li><span>OptnlIncome</span></li>
                                                <li><span>OtherIncome</span></li>
                                                <li><span>OptnlAdminandOthrExp</span></li>
                                                <li><span>OptnlProfit</span></li>
                                                <li><span>EBITDA</span></li>
                                                <li><span>Interest</span></li>
                                                <li><span>EBDT</span></li>
                                                <li><span>Depreciation</span></li>
                                                <li><span>EBT</span></li>
                                                <li><span>Tax</span></li>
                                                <li><span>PAT</span></li>
                                                <li><span>TotalIncome</span></li>
                                                <li><span>BINR</span></li>
                                                <li><span>DINR</span></li>
                                                <li><span>EmployeeRelatedExpenses</span></li>
                                                <li><span>EarninginForeignExchange</span></li>
                                                <li><span>OutgoinForeignExchange</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
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
                                            $str .= '<ul>
                                                        <li><span>' . trim($gres['FY']) . '</span></li>
                                                        <li><span>' . trim($gres['GrowthPerc_Id']) . '</span></li>
                                                        <li><span>' . trim($gres['CId_FK']) . '</span></li>
                                                        <li><span>' . trim($gres['IndustryId_FK']) . '</span></li>
                                                        <li><span>' . trim($gres['OptnlIncome']) . '</span></li>
                                                        <li><span>' . trim($gres['OtherIncome']) . '</span></li>
                                                        <li><span>' . trim($gres['OptnlAdminandOthrExp']) . '</span></li>
                                                        <li><span>' . trim($gres['OptnlProfit']) . '</span></li>
                                                        <li><span>' . trim($gres['EBITDA']) . '</span></li>
                                                        <li><span>' . trim($gres['Interest']) . '</span></li>
                                                        <li><span>' . trim($gres['EBDT']) . '</span></li>
                                                        <li><span>' . trim($gres['Depreciation']) . '</span></li>
                                                        <li><span>' . trim($gres['EBT']) . '</span></li>
                                                        <li><span>' . trim($gres['Tax']) . '</span></li>
                                                        <li><span>' . trim($gres['PAT']) . '</span></li>
                                                        <li><span>' . trim($gres['TotalIncome']) . '</span></li>
                                                        <li><span>' . trim($gres['BINR']) . '</span></li>
                                                        <li><span>' . trim($gres['DINR']) . '</span></li>
                                                        <li><span>' . trim($gres['EmployeeRelatedExpenses']) . '</span></li>
                                                        <li><span>' . trim($gres['EarninginForeignExchange']) . '</span></li>
                                                        <li><span>' . trim($gres['OutgoinForeignExchange']) . '</span></li>
                                                    </ul>';
                                            }
                                $str .= '       </div>
                                            </div>';
                                        } else {
                                            $str .= 'No data found.';
                                        }                                                  
                                $str .= '</div>
                                        <div id="balan_shet' . $cprofile_id . '" class="tab-pane fade">';
                                        //BALANCESHEET
                                        $Qry = mysql_query("SELECT * FROM balancesheet a INNER JOIN plstandard b ON a.FY = b.FY AND a.CID_FK = b.CID_FK WHERE a.CID_FK = '$cprofile_id' and b.ResultType='0' and a.ResultType='0' GROUP BY a.FY ORDER BY a.FY DESC LIMIT 0,100");
                                        if(mysql_num_rows($Qry) > 0) {
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>ShareCapital</span></li>
                                                <li><span>ShareApplication</span></li>
                                                <li><span>ReservesSurplus</span></li>
                                                <li><span>TotalFunds</span></li>
                                                <li><span>SecuredLoans</span></li>
                                                <li><span>UnSecuredLoans</span></li>
                                                <li><span>LoanFunds</span></li>
                                                <li><span>OtherLiabilities</span></li>
                                                <li><span>DeferredTax</span></li>
                                                <li><span>SourcesOfFunds</span></li>
                                                <li><span>GrossBlock</span></li>
                                                <li><span>LessAccumulated</span></li>
                                                <li><span>NetBlock</span></li>
                                                <li><span>CapitalWork</span></li>
                                                <li><span>FixedAssets</span></li>
                                                <li><span>IntangibleAssets</span></li>
                                                <li><span>OtherNonCurrent</span></li>
                                                <li><span>Investments</span></li>
                                                <li><span>DeferredTaxAssets</span></li>
                                                <li><span>SundryDebtors</span></li>
                                                <li><span>CashBankBalances</span></li>
                                                <li><span>Inventories</span></li>
                                                <li><span>LoansAdvances</span></li>
                                                <li><span>OtherCurrentAssets</span></li>
                                                <li><span>CurrentAssets</span></li>
                                                <li><span>Provisions</span></li>
                                                <li><span>CurrentLiabilitiesProvision</span></li>
                                                <li><span>CurrentLiabilitiesProvision</span></li>
                                                <li><span>NetCurrentAssets</span></li>
                                                <li><span>ProfitLoss</span></li>
                                                <li><span>Miscellaneous</span></li>
                                                <li><span>TotalAssets</span></li>
                                                <li><span>ResultType</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
                                            while($res = mysql_fetch_array($Qry)) {
                                                $res1 = array();
                                                $res1['FY'] = trim( $res['FY'] );
                                                $res1['ShareCapital_INR'] = trim( $res['ShareCapital'] );
                                                $res1['ShareCapital_USD'] = (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['ShareApplication_INR'] = trim( $res['ShareApplication'] );
                                                $res1['ShareApplication_USD'] = (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['ReservesSurplus_INR'] = trim( $res['ReservesSurplus'] );
                                                $res1['ReservesSurplus_USD'] = (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['TotalFunds_INR'] = trim( $res['TotalFunds'] );
                                                $res1['TotalFunds_USD'] = (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['SecuredLoans_INR'] = trim( $res['SecuredLoans'] );
                                                $res1['SecuredLoans_USD'] = (string)(trim( $res['SecuredLoans'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['UnSecuredLoans_INR'] = trim( $res['UnSecuredLoans'] );
                                                $res1['UnSecuredLoans_USD'] = (string)(trim( $res['UnSecuredLoans'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['LoanFunds_INR'] = trim( $res['LoanFunds'] );
                                                $res1['LoanFunds_USD'] = (string)(trim( $res['LoanFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['OtherLiabilities_INR'] = trim( $res['OtherLiabilities'] );
                                                $res1['OtherLiabilities_USD'] = (string)(trim( $res['OtherLiabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['DeferredTax_INR'] = trim( $res['DeferredTax'] );
                                                $res1['DeferredTax_USD'] = (string)(trim( $res['DeferredTax'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['SourcesOfFunds_INR'] = trim( $res['SourcesOfFunds'] );
                                                $res1['SourcesOfFunds_USD'] = (string)(trim( $res['SourcesOfFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['GrossBlock_INR'] = trim( $res['GrossBlock'] );
                                                $res1['GrossBlock_USD'] = (string)(trim( $res['GrossBlock'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['LessAccumulated_INR'] = trim( $res['LessAccumulated'] );
                                                $res1['LessAccumulated_USD'] = (string)(trim( $res['LessAccumulated'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['NetBlock_INR'] = trim( $res['NetBlock'] );
                                                $res1['NetBlock_USD'] = (string)(trim( $res['NetBlock'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['CapitalWork_INR'] = trim( $res['CapitalWork'] );
                                                $res1['CapitalWork_USD'] = (string)(trim( $res['CapitalWork'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['FixedAssets_INR'] = trim( $res['FixedAssets'] );
                                                $res1['FixedAssets_USD'] = (string)(trim( $res['FixedAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['IntangibleAssets_INR'] = trim( $res['IntangibleAssets'] );
                                                $res1['IntangibleAssets_USD'] = (string)(trim( $res['IntangibleAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['OtherNonCurrent_INR'] = trim( $res['OtherNonCurrent'] );
                                                $res1['OtherNonCurrent_USD'] = (string)(trim( $res['OtherNonCurrent'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['Investments_INR'] = trim( $res['Investments'] );
                                                $res1['Investments_USD'] = (string)(trim( $res['Investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['DeferredTaxAssets_INR'] = trim( $res['DeferredTaxAssets'] );
                                                $res1['DeferredTaxAssets_USD'] = (string)(trim( $res['DeferredTaxAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['SundryDebtors_INR'] = trim( $res['SundryDebtors'] );
                                                $res1['SundryDebtors_USD'] = (string)(trim( $res['SundryDebtors'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['CashBankBalances_INR'] = trim( $res['CashBankBalances'] );
                                                $res1['CashBankBalances_USD'] = (string)(trim( $res['CashBankBalances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['Inventories_INR'] = trim( $res['Inventories'] );
                                                $res1['Inventories_USD'] = (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['LoansAdvances_INR'] = trim( $res['LoansAdvances'] );
                                                $res1['LoansAdvances_USD'] = (string)(trim( $res['LoansAdvances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['OtherCurrentAssets_INR'] = trim( $res['OtherCurrentAssets'] );
                                                $res1['OtherCurrentAssets_USD'] = (string)(trim( $res['OtherCurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['CurrentAssets_INR'] = trim( $res['CurrentAssets'] );
                                                $res1['CurrentAssets_USD'] = (string)(trim( $res['CurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['Provisions_INR'] = trim( $res['Provisions'] );
                                                $res1['Provisions_USD'] = (string)(trim( $res['Provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['CurrentLiabilitiesProvision_INR'] = trim( $res['CurrentLiabilitiesProvision'] );
                                                $res1['CurrentLiabilitiesProvision_USD'] = (string)(trim( $res['CurrentLiabilitiesProvision'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['NetCurrentAssets_INR'] = trim( $res['NetCurrentAssets'] );
                                                $res1['NetCurrentAssets_USD'] = (string)(trim( $res['NetCurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['ProfitLoss_INR'] = trim( $res['ProfitLoss'] );
                                                $res1['ProfitLoss_USD'] = (string)(trim( $res['ProfitLoss'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['Miscellaneous_INR'] = trim( $res['Miscellaneous'] );
                                                $res1['Miscellaneous_USD'] = (string)(trim( $res['Miscellaneous'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['TotalAssets_INR'] = trim( $res['TotalAssets'] );
                                                $res1['TotalAssets_USD'] = (string)(trim( $res['TotalAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $res1['ResultType'] = trim( $res['ResultType'] );
                                                if(!empty($res1)){
                                                    $data_inner['balancesheet'][] = $res1;
                                                }else{
                                                    $data_inner['balancesheet'][] = "";
                                                }

                                                $ShareCapital = ( $curreny_code == 'INR' ) ? trim($res['ShareCapital']) : (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $ShareApplication = ( $curreny_code == 'INR' ) ? trim($res['ShareApplication']) : (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $ReservesSurplus = ( $curreny_code == 'INR' ) ? trim($res['ReservesSurplus']) : (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $TotalFunds = ( $curreny_code == 'INR' ) ? trim($res['TotalFunds']) : (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $SecuredLoans = ( $curreny_code == 'INR' ) ? trim($res['SecuredLoans']) : (string)(trim( $res['SecuredLoans'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $UnSecuredLoans = ( $curreny_code == 'INR' ) ? trim($res['UnSecuredLoans']) : (string)(trim( $res['UnSecuredLoans'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $LoanFunds = ( $curreny_code == 'INR' ) ? trim($res['LoanFunds']) : (string)(trim( $res['LoanFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $OtherLiabilities = ( $curreny_code == 'INR' ) ? trim($res['OtherLiabilities']) : (string)(trim( $res['OtherLiabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $DeferredTax = ( $curreny_code == 'INR' ) ? trim($res['DeferredTax']) : (string)(trim( $res['DeferredTax'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $SourcesOfFunds = ( $curreny_code == 'INR' ) ? trim($res['SourcesOfFunds']) : (string)(trim( $res['SourcesOfFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $GrossBlock = ( $curreny_code == 'INR' ) ? trim($res['GrossBlock']) : (string)(trim( $res['GrossBlock'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $LessAccumulated = ( $curreny_code == 'INR' ) ? trim($res['LessAccumulated']) : (string)(trim( $res['LessAccumulated'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $NetBlock = ( $curreny_code == 'INR' ) ? trim($res['NetBlock']) : (string)(trim( $res['NetBlock'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $CapitalWork = ( $curreny_code == 'INR' ) ? trim($res['CapitalWork']) : (string)(trim( $res['CapitalWork'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $FixedAssets = ( $curreny_code == 'INR' ) ? trim($res['FixedAssets']) : (string)(trim( $res['FixedAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $IntangibleAssets = ( $curreny_code == 'INR' ) ? trim($res['IntangibleAssets']) : (string)(trim( $res['IntangibleAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $OtherNonCurrent = ( $curreny_code == 'INR' ) ? trim($res['OtherNonCurrent']) : (string)(trim( $res['OtherNonCurrent'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $Investments = ( $curreny_code == 'INR' ) ? trim($res['Investments']) : (string)(trim( $res['Investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $DeferredTaxAssets = ( $curreny_code == 'INR' ) ? trim($res['DeferredTaxAssets']) : (string)(trim( $res['DeferredTaxAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $SundryDebtors = ( $curreny_code == 'INR' ) ? trim($res['SundryDebtors']) : (string)(trim( $res['SundryDebtors'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $CashBankBalances = ( $curreny_code == 'INR' ) ? trim($res['CashBankBalances']) : (string)(trim( $res['CashBankBalances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $Inventories = ( $curreny_code == 'INR' ) ? trim($res['Inventories']) : (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $LoansAdvances = ( $curreny_code == 'INR' ) ? trim($res['LoansAdvances']) : (string)(trim( $res['LoansAdvances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $OtherCurrentAssets = ( $curreny_code == 'INR' ) ? trim($res['OtherCurrentAssets']) : (string)(trim( $res['OtherCurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $CurrentAssets = ( $curreny_code == 'INR' ) ? trim($res['CurrentAssets']) : (string)(trim( $res['CurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $Provisions = ( $curreny_code == 'INR' ) ? trim($res['Provisions']) : (string)(trim( $res['Provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $CurrentLiabilitiesProvision = ( $curreny_code == 'INR' ) ? trim($res['CurrentLiabilitiesProvision']) : (string)(trim( $res[''] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $NetCurrentAssets = ( $curreny_code == 'INR' ) ? trim($res['NetCurrentAssets']) : (string)(trim( $res['NetCurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $ProfitLoss = ( $curreny_code == 'INR' ) ? trim($res['ProfitLoss']) : (string)(trim( $res['ProfitLoss'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $Miscellaneous = ( $curreny_code == 'INR' ) ? trim($res['Miscellaneous']) : (string)(trim( $res['Miscellaneous'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                 $TotalAssets = ( $curreny_code == 'INR' ) ? trim($res['TotalAssets']) : (string)(trim( $res['TotalAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $str .= '<ul>
                                                            <li><span>' . trim( $res['FY'] ) . '</span></li>
                                                            <li><span>' . $ShareCapital . '</span></li>
                                                            <li><span>' . $ShareApplication . '</span></li>
                                                            <li><span>' . $ReservesSurplus . '</span></li>
                                                            <li><span>' . $TotalFunds . '</span></li>
                                                            <li><span>' . $SecuredLoans . '</span></li>
                                                            <li><span>' . $UnSecuredLoans . '</span></li>
                                                            <li><span>' . $LoanFunds . '</span></li>
                                                            <li><span>' . $OtherLiabilities . '</span></li>
                                                            <li><span>' . $DeferredTax . '</span></li>
                                                            <li><span>' . $SourcesOfFunds . '</span></li>
                                                            <li><span>' . $GrossBlock . '</span></li>
                                                            <li><span>' . $LessAccumulated . '</span></li>
                                                            <li><span>' . $NetBlock . '</span></li>
                                                            <li><span>' . $CapitalWork . '</span></li>
                                                            <li><span>' . $FixedAssets . '</span></li>
                                                            <li><span>' . $IntangibleAssets . '</span></li>
                                                            <li><span>' . $OtherNonCurrent . '</span></li>
                                                            <li><span>' . $Investments . '</span></li>
                                                            <li><span>' . $DeferredTaxAssets . '</span></li>
                                                            <li><span>' . $SundryDebtors . '</span></li>
                                                            <li><span>' . $CashBankBalances . '</span></li>
                                                            <li><span>' . $Inventories . '</span></li>
                                                            <li><span>' . $LoansAdvances . '</span></li>
                                                            <li><span>' . $OtherCurrentAssets . '</span></li>
                                                            <li><span>' . $CurrentAssets . '</span></li>
                                                            <li><span>' . $Provisions . '</span></li>
                                                            <li><span>' . $CurrentLiabilitiesProvision . '</span></li>
                                                            <li><span>' . $NetCurrentAssets . '</span></li>
                                                            <li><span>' . $ProfitLoss . '</span></li>
                                                            <li><span>' . $Miscellaneous . '</span></li>
                                                            <li><span>' . $TotalAssets . '</span></li>
                                                            <li><span>' . trim($res['ResultType']) . '</span></li>
                                                        </ul>';
                                            }
                                    $str .= '   </div>
                                            </div>';
                                        } else {
                                            $Qry = mysql_query("SELECT * FROM balancesheet a WHERE a.CID_FK = '$cprofile_id' and a.ResultType='0' ORDER BY a.FY DESC LIMIT 0,100");
                                            if(mysql_num_rows($Qry) > 0){
                                        $str .= '<ul class="fix-ul">
                                                    <li><span>FY</span></li>
                                                    <li><span>ShareCapital</span></li>
                                                    <li><span>ShareApplication</span></li>
                                                    <li><span>ReservesSurplus</span></li>
                                                    <li><span>TotalFunds</span></li>
                                                    <li><span>SecuredLoans</span></li>
                                                    <li><span>UnSecuredLoans</span></li>
                                                    <li><span>LoanFunds</span></li>
                                                    <li><span>OtherLiabilities</span></li>
                                                    <li><span>DeferredTax</span></li>
                                                    <li><span>SourcesOfFunds</span></li>
                                                    <li><span>GrossBlock</span></li>
                                                    <li><span>LessAccumulated</span></li>
                                                    <li><span>NetBlock</span></li>
                                                    <li><span>CapitalWork</span></li>
                                                    <li><span>FixedAssets</span></li>
                                                    <li><span>IntangibleAssets</span></li>
                                                    <li><span>OtherNonCurrent</span></li>
                                                    <li><span>Investments</span></li>
                                                    <li><span>DeferredTaxAssets</span></li>
                                                    <li><span>SundryDebtors</span></li>
                                                    <li><span>CashBankBalances</span></li>
                                                    <li><span>Inventories</span></li>
                                                    <li><span>LoansAdvances</span></li>
                                                    <li><span>OtherCurrentAssets</span></li>
                                                    <li><span>CurrentAssets</span></li>
                                                    <li><span>Provisions</span></li>
                                                    <li><span>CurrentLiabilitiesProvision</span></li>
                                                    <li><span>CurrentLiabilitiesProvision</span></li>
                                                    <li><span>NetCurrentAssets</span></li>
                                                    <li><span>ProfitLoss</span></li>
                                                    <li><span>Miscellaneous</span></li>
                                                    <li><span>TotalAssets</span></li>
                                                    <li><span>ResultType</span></li>
                                                </ul>
                                                <div class="tab-cont-sec">
                                                    <div class="tab-scroll">';
                                                while($res = mysql_fetch_array($Qry)){
                                                    $res1 = array();
                                                    $res1['FY'] = trim($res['FY']);
                                                    $res1['ShareCapital_INR'] = trim($res['ShareCapital']);
                                                    $res1['ShareCapital_USD'] = (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['ShareApplication_INR'] = trim($res['ShareApplication']);
                                                    $res1['ShareApplication_USD'] = (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['ReservesSurplus_INR'] = trim($res['ReservesSurplus']);
                                                    $res1['ReservesSurplus_USD'] = (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['TotalFunds_INR'] = trim($res['TotalFunds']);
                                                    $res1['TotalFunds_USD'] = (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['SecuredLoans_INR'] = trim($res['SecuredLoans']);
                                                    $res1['SecuredLoans_USD'] = (string)(trim( $res['SecuredLoans'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['UnSecuredLoans_INR'] = trim($res['UnSecuredLoans']);
                                                    $res1['UnSecuredLoans_USD'] = (string)(trim( $res['UnSecuredLoans'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['LoanFunds_INR'] = trim($res['LoanFunds']);
                                                    $res1['LoanFunds_USD'] = (string)(trim( $res['LoanFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['OtherLiabilities_INR'] = trim($res['OtherLiabilities']);
                                                    $res1['OtherLiabilities_USD'] = (string)(trim( $res['OtherLiabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['DeferredTax_INR'] = trim($res['DeferredTax']);
                                                    $res1['DeferredTax_USD'] = (string)(trim( $res['DeferredTax'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['SourcesOfFunds_INR'] = trim($res['SourcesOfFunds']);
                                                    $res1['SourcesOfFunds_USD'] = (string)(trim( $res['SourcesOfFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['GrossBlock_INR'] = trim($res['GrossBlock']);
                                                    $res1['GrossBlock_USD'] = (string)(trim( $res['GrossBlock'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['LessAccumulated_INR'] = trim($res['LessAccumulated']);
                                                    $res1['LessAccumulated_USD'] = (string)(trim( $res['LessAccumulated'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['NetBlock_INR'] = trim($res['NetBlock']);
                                                    $res1['NetBlock_USD'] = (string)(trim( $res['NetBlock'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['CapitalWork_INR'] = trim($res['CapitalWork']);
                                                    $res1['CapitalWork_USD'] = (string)(trim( $res['CapitalWork'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['FixedAssets_INR'] = trim($res['FixedAssets']);
                                                    $res1['FixedAssets_USD'] = (string)(trim( $res['FixedAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['IntangibleAssets_INR'] = trim($res['IntangibleAssets']);
                                                    $res1['IntangibleAssets_USD'] = (string)(trim( $res['IntangibleAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['OtherNonCurrent_INR'] = trim($res['OtherNonCurrent']);
                                                    $res1['OtherNonCurrent_USD'] = (string)(trim( $res['OtherNonCurrent'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Investments_INR'] = trim($res['Investments']);
                                                    $res1['Investments_USD'] = (string)(trim( $res['Investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['DeferredTaxAssets_INR'] = trim($res['DeferredTaxAssets']);
                                                    $res1['DeferredTaxAssets_USD'] = (string)(trim( $res['DeferredTaxAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['SundryDebtors_INR'] = trim($res['SundryDebtors']);
                                                    $res1['SundryDebtors_USD'] = (string)(trim( $res['SundryDebtors'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['CashBankBalances_INR'] = trim($res['CashBankBalances']);
                                                    $res1['CashBankBalances_USD'] = (string)(trim( $res['CashBankBalances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Inventories_INR'] = trim($res['Inventories']);
                                                    $res1['Inventories_USD'] = (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['LoansAdvances_INR'] = trim($res['LoansAdvances']);
                                                    $res1['LoansAdvances_USD'] = (string)(trim( $res['LoansAdvances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['OtherCurrentAssets_INR'] = trim($res['OtherCurrentAssets']);
                                                    $res1['OtherCurrentAssets_USD'] = (string)(trim( $res['OtherCurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['CurrentAssets_INR'] = trim($res['CurrentAssets']);
                                                    $res1['CurrentAssets_USD'] = (string)(trim( $res['CurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Provisions_INR'] = trim($res['Provisions']);
                                                    $res1['Provisions_USD'] = (string)(trim( $res['Provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['CurrentLiabilitiesProvision_INR'] = trim($res['CurrentLiabilitiesProvision']);
                                                    $res1['CurrentLiabilitiesProvision_USD'] = (string)(trim( $res['CurrentLiabilitiesProvision'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['NetCurrentAssets_INR'] = trim($res['NetCurrentAssets']);
                                                    $res1['NetCurrentAssets_USD'] = (string)(trim( $res['NetCurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['ProfitLoss_INR'] = trim($res['ProfitLoss']);
                                                    $res1['ProfitLoss_USD'] = (string)(trim( $res['ProfitLoss'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Miscellaneous_INR'] = trim($res['Miscellaneous']);
                                                    $res1['Miscellaneous_USD'] = (string)(trim( $res['Miscellaneous'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['TotalAssets_INR'] = trim($res['TotalAssets']);
                                                    $res1['TotalAssets_USD'] = (string)(trim( $res['TotalAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['ResultType'] = trim($res['ResultType']);
                                                    
                                                    if(!empty($res1)){
                                                        $data_inner['balancesheet'][] = $res1;
                                                    }else{
                                                        $data_inner['balancesheet'][] = "";
                                                    }

                                                    $ShareCapital = ( $curreny_code == 'INR' ) ? trim($res['ShareCapital']) : (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $ShareApplication = ( $curreny_code == 'INR' ) ? trim($res['ShareApplication']) : (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $ReservesSurplus = ( $curreny_code == 'INR' ) ? trim($res['ReservesSurplus']) : (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $TotalFunds = ( $curreny_code == 'INR' ) ? trim($res['TotalFunds']) : (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $SecuredLoans = ( $curreny_code == 'INR' ) ? trim($res['SecuredLoans']) : (string)(trim( $res['SecuredLoans'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $UnSecuredLoans = ( $curreny_code == 'INR' ) ? trim($res['UnSecuredLoans']) : (string)(trim( $res['UnSecuredLoans'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $LoanFunds = ( $curreny_code == 'INR' ) ? trim($res['LoanFunds']) : (string)(trim( $res['LoanFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $OtherLiabilities = ( $curreny_code == 'INR' ) ? trim($res['OtherLiabilities']) : (string)(trim( $res['OtherLiabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $DeferredTax = ( $curreny_code == 'INR' ) ? trim($res['DeferredTax']) : (string)(trim( $res['DeferredTax'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $SourcesOfFunds = ( $curreny_code == 'INR' ) ? trim($res['SourcesOfFunds']) : (string)(trim( $res['SourcesOfFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $GrossBlock = ( $curreny_code == 'INR' ) ? trim($res['GrossBlock']) : (string)(trim( $res['GrossBlock'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $LessAccumulated = ( $curreny_code == 'INR' ) ? trim($res['LessAccumulated']) : (string)(trim( $res['LessAccumulated'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $NetBlock = ( $curreny_code == 'INR' ) ? trim($res['NetBlock']) : (string)(trim( $res['NetBlock'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $CapitalWork = ( $curreny_code == 'INR' ) ? trim($res['CapitalWork']) : (string)(trim( $res['CapitalWork'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $FixedAssets = ( $curreny_code == 'INR' ) ? trim($res['FixedAssets']) : (string)(trim( $res['FixedAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $IntangibleAssets = ( $curreny_code == 'INR' ) ? trim($res['IntangibleAssets']) : (string)(trim( $res['IntangibleAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $OtherNonCurrent = ( $curreny_code == 'INR' ) ? trim($res['OtherNonCurrent']) : (string)(trim( $res['OtherNonCurrent'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $Investments = ( $curreny_code == 'INR' ) ? trim($res['Investments']) : (string)(trim( $res['Investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $DeferredTaxAssets = ( $curreny_code == 'INR' ) ? trim($res['DeferredTaxAssets']) : (string)(trim( $res['DeferredTaxAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $SundryDebtors = ( $curreny_code == 'INR' ) ? trim($res['SundryDebtors']) : (string)(trim( $res['SundryDebtors'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $CashBankBalances = ( $curreny_code == 'INR' ) ? trim($res['CashBankBalances']) : (string)(trim( $res['CashBankBalances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $Inventories = ( $curreny_code == 'INR' ) ? trim($res['Inventories']) : (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $LoansAdvances = ( $curreny_code == 'INR' ) ? trim($res['LoansAdvances']) : (string)(trim( $res['LoansAdvances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $OtherCurrentAssets = ( $curreny_code == 'INR' ) ? trim($res['OtherCurrentAssets']) : (string)(trim( $res['OtherCurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $CurrentAssets = ( $curreny_code == 'INR' ) ? trim($res['CurrentAssets']) : (string)(trim( $res['CurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $Provisions = ( $curreny_code == 'INR' ) ? trim($res['Provisions']) : (string)(trim( $res['Provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $CurrentLiabilitiesProvision = ( $curreny_code == 'INR' ) ? trim($res['CurrentLiabilitiesProvision']) : (string)(trim( $res[''] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $NetCurrentAssets = ( $curreny_code == 'INR' ) ? trim($res['NetCurrentAssets']) : (string)(trim( $res['NetCurrentAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $ProfitLoss = ( $curreny_code == 'INR' ) ? trim($res['ProfitLoss']) : (string)(trim( $res['ProfitLoss'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $Miscellaneous = ( $curreny_code == 'INR' ) ? trim($res['Miscellaneous']) : (string)(trim( $res['Miscellaneous'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                 $TotalAssets = ( $curreny_code == 'INR' ) ? trim($res['TotalAssets']) : (string)(trim( $res['TotalAssets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                $str .= '<ul>
                                                           <li><span>' . trim( $res['FY'] ) . '</span></li>
                                                            <li><span>' . $ShareCapital . '</span></li>
                                                            <li><span>' . $ShareApplication . '</span></li>
                                                            <li><span>' . $ReservesSurplus . '</span></li>
                                                            <li><span>' . $TotalFunds . '</span></li>
                                                            <li><span>' . $SecuredLoans . '</span></li>
                                                            <li><span>' . $UnSecuredLoans . '</span></li>
                                                            <li><span>' . $LoanFunds . '</span></li>
                                                            <li><span>' . $OtherLiabilities . '</span></li>
                                                            <li><span>' . $DeferredTax . '</span></li>
                                                            <li><span>' . $SourcesOfFunds . '</span></li>
                                                            <li><span>' . $GrossBlock . '</span></li>
                                                            <li><span>' . $LessAccumulated . '</span></li>
                                                            <li><span>' . $NetBlock . '</span></li>
                                                            <li><span>' . $CapitalWork . '</span></li>
                                                            <li><span>' . $FixedAssets . '</span></li>
                                                            <li><span>' . $IntangibleAssets . '</span></li>
                                                            <li><span>' . $OtherNonCurrent . '</span></li>
                                                            <li><span>' . $Investments . '</span></li>
                                                            <li><span>' . $DeferredTaxAssets . '</span></li>
                                                            <li><span>' . $SundryDebtors . '</span></li>
                                                            <li><span>' . $CashBankBalances . '</span></li>
                                                            <li><span>' . $Inventories . '</span></li>
                                                            <li><span>' . $LoansAdvances . '</span></li>
                                                            <li><span>' . $OtherCurrentAssets . '</span></li>
                                                            <li><span>' . $CurrentAssets . '</span></li>
                                                            <li><span>' . $Provisions . '</span></li>
                                                            <li><span>' . $CurrentLiabilitiesProvision . '</span></li>
                                                            <li><span>' . $NetCurrentAssets . '</span></li>
                                                            <li><span>' . $ProfitLoss . '</span></li>
                                                            <li><span>' . $Miscellaneous . '</span></li>
                                                            <li><span>' . $TotalAssets . '</span></li>
                                                            <li><span>' . trim($res['ResultType']) . '</span></li>
                                                        </ul>';
                                                }
                                    $str .= '   </div>
                                            </div>';
                                            } else {
                                                $str .= 'No data found.';
                                            }
                                        }
                                $str .= '</div>
                                        <div id="ratio_balan' . $cprofile_id . '" class="tab-pane fade">';
                                        //Ratio with Balancesheet
                                        $Qry = mysql_query("select * from plstandard a INNER JOIN balancesheet b ON a.FY = b.FY AND a.CID_FK = b.CID_FK where a.CID_FK = '$cprofile_id' and a.ResultType='0' GROUP BY a.FY ORDER BY a.FY DESC");
                                        if(mysql_num_rows($Qry) > 0){
                                        }else{
                                            $Qry = mysql_query("select * from balancesheet CID_FK = '$cprofile_id' and ResultType='0' FY DESC");
                                        }
                                        if(mysql_num_rows($Qry) > 0){
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>CurrentRatio</span></li>
                                                <li><span>QuickRatio</span></li>
                                                <li><span>RoE</span></li>
                                                <li><span>RoA</span></li>
                                                <li><span>EBITDAMargin</span></li>
                                                <li><span>PATMargin</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
                                            while($res = mysql_fetch_array($Qry)){

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

                                            $str .= '<ul>
                                                        <li><span>' . trim( $res['FY'] ) . '</span></li>
                                                        <li><span>' . $ratio_cal['CurrentRatio'] . '</span></li>
                                                        <li><span>' . $ratio_cal['QuickRatio'] . '</span></li>
                                                        <li><span>' . $ratio_cal['RoE'] . '</span></li>
                                                        <li><span>' . $ratio_cal['RoA'] . '</span></li>
                                                        <li><span>' . $ratio_cal['EBITDAMargin'] . '</span></li>
                                                        <li><span>' . $ratio_cal['PATMargin'] . '</span></li>
                                                    </ul>';
                                            }
                                        $str .= '</div>
                                            </div>';
                                        } else {
                                            $str .= 'No data found.';
                                        }
                                $str .= '</div>
                                        <div id="balan_shet_new' . $cprofile_id . '" class="tab-pane fade">';
                                            //Balancesheet New
                                            $Qry = mysql_query("SELECT * FROM balancesheet_new a INNER JOIN plstandard b ON a.FY = b.FY AND a.CID_FK = b.CID_FK WHERE a.CID_FK = '$cprofile_id' and b.ResultType='0' and a.ResultType='0' GROUP BY a.FY ORDER BY a.FY DESC LIMIT 0,100");
                                            if(mysql_num_rows($Qry) > 0){
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>ShareCapital</span></li>
                                                <li><span>ReservesSurplus</span></li>
                                                <li><span>TotalFunds</span></li>
                                                <li><span>ShareApplication</span></li>
                                                <li><span>L_term_borrowings</span></li>
                                                <li><span>deferred_tax_liabilities</span></li>
                                                <li><span>O_long_term_liabilities</span></li>
                                                <li><span>L_term_provisions</span></li>
                                                <li><span>T_non_current_liabilities</span></li>
                                                <li><span>S_term_borrowings</span></li>
                                                <li><span>Trade_payables</span></li>
                                                <li><span>O_current_liabilities</span></li>
                                                <li><span>S_term_provisions</span></li>
                                                <li><span>T_current_liabilities</span></li>
                                                <li><span>T_equity_liabilities</span></li>
                                                <li><span>Tangible_assets</span></li>
                                                <li><span>Intangible_assets</span></li>
                                                <li><span>T_fixed_assets</span></li>
                                                <li><span>N_current_investments</span></li>
                                                <li><span>Deferred_tax_assets</span></li>
                                                <li><span>L_term_loans_advances</span></li>
                                                <li><span>O_non_current_assets</span></li>
                                                <li><span>T_non_current_assets</span></li>
                                                <li><span>Current_investments</span></li>
                                                <li><span>Inventories</span></li>
                                                <li><span>Trade_receivables</span></li>
                                                <li><span>Cash_bank_balances</span></li>
                                                <li><span>S_term_loans_advances</span></li>
                                                <li><span>O_current_assets</span></li>
                                                <li><span>T_current_assets</span></li>
                                                <li><span>Total_assets</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
                                                while($res = mysql_fetch_array($Qry)){
                                                    $res1 = array();
                                                    $res1['FY'] = $res['FY'];
                                                    $res1['ShareCapital_INR'] = $res['ShareCapital'];
                                                    $res1['ShareCapital_USD'] = (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['ReservesSurplus_INR'] = $res['ReservesSurplus'];
                                                    $res1['ReservesSurplus_USD'] = (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['TotalFunds_INR'] = $res['TotalFunds'];
                                                    $res1['TotalFunds_USD'] = (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['ShareApplication_INR'] = $res['ShareApplication'];
                                                    $res1['ShareApplication_USD'] = (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['L_term_borrowings_INR'] = $res['L_term_borrowings'];
                                                    $res1['L_term_borrowings_USD'] = (string)(trim( $res['L_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['deferred_tax_liabilities_INR'] = $res['deferred_tax_liabilities'];
                                                    $res1['deferred_tax_liabilities_USD'] = (string)(trim( $res['deferred_tax_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['O_long_term_liabilities_INR'] = $res['O_long_term_liabilities'];
                                                    $res1['O_long_term_liabilities_USD'] = (string)(trim( $res['O_long_term_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['L_term_provisions_INR'] = $res['L_term_provisions']; 
                                                    $res1['L_term_provisions_USD'] = (string)(trim( $res['L_term_provisions'] ))/$currencyValue[ trim( $res['FY'] ) ]; 
                                                    $res1['T_non_current_liabilities_INR'] = $res['T_non_current_liabilities'];
                                                    $res1['T_non_current_liabilities_USD'] = (string)(trim( $res['T_non_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['S_term_borrowings_INR'] = $res['S_term_borrowings'];
                                                    $res1['S_term_borrowings_USD'] = (string)(trim( $res['S_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Trade_payables_INR'] = $res['Trade_payables'];
                                                    $res1['Trade_payables_USD'] = (string)(trim( $res['Trade_payables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['O_current_liabilities_INR'] = $res['O_current_liabilities'];
                                                    $res1['O_current_liabilities_USD'] = (string)(trim( $res['O_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['S_term_provisions_INR'] = $res['S_term_provisions'];
                                                    $res1['S_term_provisions_USD'] = (string)(trim( $res['S_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_current_liabilities_INR'] = $res['T_current_liabilities'];
                                                    $res1['T_current_liabilities_USD'] = (string)(trim( $res['T_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_equity_liabilities_INR'] = $res['T_equity_liabilities'];
                                                    $res1['T_equity_liabilities_USD'] = (string)(trim( $res['T_equity_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Tangible_assets_INR'] = $res['Tangible_assets'];
                                                    $res1['Tangible_assets_USD'] = (string)(trim( $res['Tangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);  
                                                    $res1['Intangible_assets_INR'] = $res['Intangible_assets'];
                                                    $res1['Intangible_assets_USD'] = (string)(trim( $res['Intangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_fixed_assets_INR'] = $res['T_fixed_assets'];
                                                    $res1['T_fixed_assets_USD'] = (string)(trim( $res['T_fixed_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['N_current_investments_INR'] = $res['N_current_investments'];
                                                    $res1['N_current_investments_USD'] = (string)(trim( $res['N_current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Deferred_tax_assets_INR'] = $res['Deferred_tax_assets'];
                                                    $res1['Deferred_tax_assets_USD'] = (string)(trim( $res['Deferred_tax_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['L_term_loans_advances_INR'] = $res['L_term_loans_advances'];
                                                    $res1['L_term_loans_advances_USD'] = (string)(trim( $res['L_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['O_non_current_assets_INR'] = $res['O_non_current_assets'];
                                                    $res1['O_non_current_assets_USD'] = (string)(trim( $res['O_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_non_current_assets_INR'] = $res['T_non_current_assets'];
                                                    $res1['T_non_current_assets_USD'] = (string)(trim( $res['T_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Current_investments_INR'] = $res['Current_investments'];
                                                    $res1['Current_investments_USD'] = (string)(trim( $res['Current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Inventories_INR'] = $res['Inventories'];
                                                    $res1['Inventories_USD'] = (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Trade_receivables_INR'] = $res['Trade_receivables'];
                                                    $res1['Trade_receivables_USD'] = (string)(trim( $res['Trade_receivables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Cash_bank_balances_INR'] = $res['Cash_bank_balances'];
                                                    $res1['Cash_bank_balances_USD'] = (string)(trim( $res['Cash_bank_balances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['S_term_loans_advances_INR'] = $res['S_term_loans_advances'];
                                                    $res1['S_term_loans_advances_USD'] = (string)(trim( $res['S_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['O_current_assets_INR'] = $res['O_current_assets'];
                                                    $res1['O_current_assets_USD'] = (string)(trim( $res['O_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_current_assets_INR'] = $res['T_current_assets'];
                                                    $res1['T_current_assets_USD'] = (string)(trim( $res['T_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Total_assets_INR'] = $res['Total_assets'];
                                                    $res1['Total_assets_USD'] = (string)(trim( $res['Total_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    // if(!empty($res1)){
                                                    //      $data_inner['balancesheet_new'][] = $res1; 
                                                    // }else{
                                                    //      $data_inner['balancesheet_new'][] = "";
                                                    // }
                                                    if(! empty($res1) ) {
                                                        $data_inner_2['Standalone'][] = $res1;
                                                    }else{
                                                        $data_inner_2['Standalone'][]   = "";
                                                    }
                                                    if(! empty( $data_inner_2 ) ) {
                                                        $data_inner['balancesheet_new'] = $data_inner_2;
                                                    }else{
                                                        $data_inner['balancesheet_new'] = "";
                                                    }

                                                    $ShareCapital = ( $curreny_code == 'INR' ) ? $res['ShareCapital'] : (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $ReservesSurplus = ( $curreny_code == 'INR' ) ? $res['ReservesSurplus'] : (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $TotalFunds = ( $curreny_code == 'INR' ) ? $res['TotalFunds'] : (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $ShareApplication = ( $curreny_code == 'INR' ) ? $res['ShareApplication'] : (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $L_term_borrowings = ( $curreny_code == 'INR' ) ? $res['L_term_borrowings'] : (string)(trim( $res['L_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $deferred_tax_liabilities = ( $curreny_code == 'INR' ) ? $res['deferred_tax_liabilities'] : (string)(trim( $res['deferred_tax_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $O_long_term_liabilities = ( $curreny_code == 'INR' ) ? $res['O_long_term_liabilities'] : (string)(trim( $res['O_long_term_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $L_term_provisions = ( $curreny_code == 'INR' ) ? $res['L_term_provisions'] : (string)(trim( $res['L_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_non_current_liabilities = ( $curreny_code == 'INR' ) ? $res['T_non_current_liabilities'] : (string)(trim( $res['T_non_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $S_term_borrowings = ( $curreny_code == 'INR' ) ? $res['S_term_borrowings'] : (string)(trim( $res['S_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Trade_payables = ( $curreny_code == 'INR' ) ? $res['Trade_payables'] : (string)(trim( $res['Trade_payables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $O_current_liabilities = ( $curreny_code == 'INR' ) ? $res['O_current_liabilities'] : (string)(trim( $res['O_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $S_term_provisions = ( $curreny_code == 'INR' ) ? $res['S_term_provisions'] : (string)(trim( $res['S_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_current_liabilities = ( $curreny_code == 'INR' ) ? $res['T_current_liabilities'] : (string)(trim( $res['T_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_equity_liabilities = ( $curreny_code == 'INR' ) ? $res['T_equity_liabilities'] : (string)(trim( $res['T_equity_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Tangible_assets = ( $curreny_code == 'INR' ) ? $res['Tangible_assets'] : (string)(trim( $res['Tangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Intangible_assets = ( $curreny_code == 'INR' ) ? $res['Intangible_assets'] : (string)(trim( $res['Intangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_fixed_assets = ( $curreny_code == 'INR' ) ? $res['T_fixed_assets'] : (string)(trim( $res['T_fixed_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $N_current_investments = ( $curreny_code == 'INR' ) ? $res['N_current_investments'] : (string)(trim( $res['N_current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Deferred_tax_assets = ( $curreny_code == 'INR' ) ? $res['Deferred_tax_assets'] : (string)(trim( $res['Deferred_tax_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $L_term_loans_advances = ( $curreny_code == 'INR' ) ? $res['L_term_loans_advances'] : (string)(trim( $res['L_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $O_non_current_assets = ( $curreny_code == 'INR' ) ? $res['O_non_current_assets'] : (string)(trim( $res['O_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_non_current_assets = ( $curreny_code == 'INR' ) ? $res['T_non_current_assets'] : (string)(trim( $res['T_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Current_investments = ( $curreny_code == 'INR' ) ? $res['Current_investments'] : (string)(trim( $res['Current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Inventories = ( $curreny_code == 'INR' ) ? $res['Inventories'] : (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Trade_receivables = ( $curreny_code == 'INR' ) ? $res['Trade_receivables'] : (string)(trim( $res['Trade_receivables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Cash_bank_balances = ( $curreny_code == 'INR' ) ? $res['Cash_bank_balances'] : (string)(trim( $res['Cash_bank_balances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $S_term_loans_advances = ( $curreny_code == 'INR' ) ? $res['S_term_loans_advances'] : (string)(trim( $res['S_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $O_current_assets = ( $curreny_code == 'INR' ) ? $res['O_current_assets'] : (string)(trim( $res['O_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_current_assets = ( $curreny_code == 'INR' ) ? $res['T_current_assets'] : (string)(trim( $res['T_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Total_assets = ( $curreny_code == 'INR' ) ? $res['Total_assets'] : (string)(trim( $res['Total_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $str .= '<ul>
                                                                <li><span>' . $res['FY'] . '</span></li>
                                                                <li><span>' . $ShareCapital . '</span></li>
                                                                <li><span>' . $ReservesSurplus . '</span></li>
                                                                <li><span>' . $TotalFunds . '</span></li>
                                                                <li><span>' . $ShareApplication . '</span></li>
                                                                <li><span>' . $L_term_borrowings . '</span></li>
                                                                <li><span>' . $deferred_tax_liabilities . '</span></li>
                                                                <li><span>' . $O_long_term_liabilities . '</span></li>
                                                                <li><span>' . $L_term_provisions . '</span></li> 
                                                                <li><span>' . $T_non_current_liabilities . '</span></li>
                                                                <li><span>' . $S_term_borrowings . '</span></li>
                                                                <li><span>' . $Trade_payables . '</span></li>
                                                                <li><span>' . $O_current_liabilities . '</span></li>
                                                                <li><span>' . $S_term_provisions . '</span></li>
                                                                <li><span>' . $T_current_liabilities . '</span></li>
                                                                <li><span>' . $T_equity_liabilities . '</span></li>
                                                                <li><span>' . $Tangible_assets . '</span></li>  
                                                                <li><span>' . $Intangible_assets . '</span></li>
                                                                <li><span>' . $T_fixed_assets . '</span></li>
                                                                <li><span>' . $N_current_investments . '</span></li>
                                                                <li><span>' . $Deferred_tax_assets . '</span></li>
                                                                <li><span>' . $L_term_loans_advances . '</span></li>
                                                                <li><span>' . $O_non_current_assets . '</span></li>
                                                                <li><span>' . $T_non_current_assets . '</span></li>
                                                                <li><span>' . $Current_investments . '</span></li>
                                                                <li><span>' . $Inventories . '</span></li>
                                                                <li><span>' . $Trade_receivables . '</span></li>
                                                                <li><span>' . $Cash_bank_balances . '</span></li>
                                                                <li><span>' . $S_term_loans_advances . '</span></li>
                                                                <li><span>' . $O_current_assets . '</span></li>
                                                                <li><span>' . $T_current_assets . '</span></li>
                                                                <li><span>' . $Total_assets . '</span></li>
                                                            </ul>';
                                                }
                                        $str .= '</div>
                                            </div>';
                                            } else {
                                                $Qry = mysql_query("SELECT * FROM balancesheet_new a WHERE a.CID_FK = '$cprofile_id' and a.ResultType='0' ORDER BY a.FY DESC LIMIT 0,100");
                                                if(mysql_num_rows($Qry) > 0){
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>ShareCapital</span></li>
                                                <li><span>ReservesSurplus</span></li>
                                                <li><span>TotalFunds</span></li>
                                                <li><span>ShareApplication</span></li>
                                                <li><span>L_term_borrowings</span></li>
                                                <li><span>deferred_tax_liabilities</span></li>
                                                <li><span>O_long_term_liabilities</span></li>
                                                <li><span>L_term_provisions</span></li>
                                                <li><span>T_non_current_liabilities</span></li>
                                                <li><span>S_term_borrowings</span></li>
                                                <li><span>Trade_payables</span></li>
                                                <li><span>O_current_liabilities</span></li>
                                                <li><span>S_term_provisions</span></li>
                                                <li><span>T_current_liabilities</span></li>
                                                <li><span>T_equity_liabilities</span></li>
                                                <li><span>Tangible_assets</span></li>
                                                <li><span>Intangible_assets</span></li>
                                                <li><span>T_fixed_assets</span></li>
                                                <li><span>N_current_investments</span></li>
                                                <li><span>Deferred_tax_assets</span></li>
                                                <li><span>L_term_loans_advances</span></li>
                                                <li><span>O_non_current_assets</span></li>
                                                <li><span>T_non_current_assets</span></li>
                                                <li><span>Current_investments</span></li>
                                                <li><span>Inventories</span></li>
                                                <li><span>Trade_receivables</span></li>
                                                <li><span>Cash_bank_balances</span></li>
                                                <li><span>S_term_loans_advances</span></li>
                                                <li><span>O_current_assets</span></li>
                                                <li><span>T_current_assets</span></li>
                                                <li><span>Total_assets</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
                                                    while($res = mysql_fetch_array($Qry)){
                                                        $res1 = array();
                                                        $res1['FY'] = $res['FY'];
                                                        $res1['ShareCapital_INR'] = $res['ShareCapital'];
                                                        $res1['ShareCapital_USD'] = (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['ReservesSurplus_INR'] = $res['ReservesSurplus'];
                                                        $res1['ReservesSurplus_USD'] = (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['TotalFunds_INR'] = $res['TotalFunds'];
                                                        $res1['TotalFunds_USD'] = (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['ShareApplication_INR'] = $res['ShareApplication'];
                                                        $res1['ShareApplication_USD'] = (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['L_term_borrowings_INR'] = $res['L_term_borrowings'];
                                                        $res1['L_term_borrowings_USD'] = (string)(trim( $res['L_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['deferred_tax_liabilities_INR'] = $res['deferred_tax_liabilities'];
                                                        $res1['deferred_tax_liabilities_USD'] = (string)(trim( $res['deferred_tax_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['O_long_term_liabilities_INR'] = $res['O_long_term_liabilities'];
                                                        $res1['O_long_term_liabilities_USD'] = (string)(trim( $res['O_long_term_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['L_term_provisions_INR'] = $res['L_term_provisions']; 
                                                        $res1['L_term_provisions_USD'] = (string)(trim( $res['L_term_provisions'] ))/$currencyValue[ trim( $res['FY'] ) ]; 
                                                        $res1['T_non_current_liabilities_INR'] = $res['T_non_current_liabilities'];
                                                        $res1['T_non_current_liabilities_USD'] = (string)(trim( $res['T_non_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['S_term_borrowings_INR'] = $res['S_term_borrowings'];
                                                        $res1['S_term_borrowings_USD'] = (string)(trim( $res['S_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Trade_payables_INR'] = $res['Trade_payables'];
                                                        $res1['Trade_payables_USD'] = (string)(trim( $res['Trade_payables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['O_current_liabilities_INR'] = $res['O_current_liabilities'];
                                                        $res1['O_current_liabilities_USD'] = (string)(trim( $res['O_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['S_term_provisions_INR'] = $res['S_term_provisions'];
                                                        $res1['S_term_provisions_USD'] = (string)(trim( $res['S_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_current_liabilities_INR'] = $res['T_current_liabilities'];
                                                        $res1['T_current_liabilities_USD'] = (string)(trim( $res['T_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_equity_liabilities_INR'] = $res['T_equity_liabilities'];
                                                        $res1['T_equity_liabilities_USD'] = (string)(trim( $res['T_equity_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Tangible_assets_INR'] = $res['Tangible_assets']; 
                                                        $res1['Tangible_assets_USD'] = (string)(trim( $res['Tangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ] ); 
                                                        $res1['Intangible_assets_INR'] = $res['Intangible_assets'];
                                                        $res1['Intangible_assets_USD'] = (string)(trim( $res['Intangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_fixed_assets_INR'] = $res['T_fixed_assets'];
                                                        $res1['T_fixed_assets_USD'] = (string)(trim( $res['T_fixed_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['N_current_investments_INR'] = $res['N_current_investments'];
                                                        $res1['N_current_investments_USD'] = (string)(trim( $res['N_current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Deferred_tax_assets_INR'] = $res['Deferred_tax_assets'];
                                                        $res1['Deferred_tax_assets_USD'] = (string)(trim( $res['Deferred_tax_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['L_term_loans_advances_INR'] = $res['L_term_loans_advances'];
                                                        $res1['L_term_loans_advances_USD'] = (string)(trim( $res['L_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['O_non_current_assets_INR'] = $res['O_non_current_assets'];
                                                        $res1['O_non_current_assets_USD'] = (string)(trim( $res['O_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_non_current_assets_INR'] = $res['T_non_current_assets'];
                                                        $res1['T_non_current_assets_USD'] = (string)(trim( $res['T_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Current_investments_INR'] = $res['Current_investments'];
                                                        $res1['Current_investments_USD'] = (string)(trim( $res['Current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Inventories_INR'] = $res['Inventories'];
                                                        $res1['Inventories_USD'] = (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Trade_receivables_INR'] = $res['Trade_receivables'];
                                                        $res1['Trade_receivables_USD'] = (string)(trim( $res['Trade_receivables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Cash_bank_balances_INR'] = $res['Cash_bank_balances'];
                                                        $res1['Cash_bank_balances_USD'] = (string)(trim( $res['Cash_bank_balances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['S_term_loans_advances_INR'] = $res['S_term_loans_advances'];
                                                        $res1['S_term_loans_advances_USD'] = (string)(trim( $res['S_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['O_current_assets_INR'] = $res['O_current_assets'];
                                                        $res1['O_current_assets_USD'] = (string)(trim( $res['O_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_current_assets_INR'] = $res['T_current_assets'];
                                                        $res1['T_current_assets_USD'] = (string)(trim( $res['T_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Total_assets_INR'] = $res['Total_assets'];
                                                        $res1['Total_assets_USD'] = (string)(trim( $res['Total_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        // if( !empty( $res1 ) ) {
                                                        //     $data_inner['balancesheet_new'][] = $res1;
                                                        // } else {
                                                        //     $data_inner['balancesheet_new'][] = "";
                                                        // }
                                                        if(! empty($res1) ) {
                                                            $data_inner_2['Standalone'][] = $res1;
                                                        }else{
                                                            $data_inner_2['Standalone'][]   = "";
                                                        }
                                                        if(! empty( $data_inner_2 ) ) {
                                                            $data_inner['balancesheet_new'] = $data_inner_2;
                                                        }else{
                                                            $data_inner['balancesheet_new'] = "";
                                                        }

                                            $str .= '<ul>
                                                        <li><span>' . $res1[''] = $res['FY'] . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['ShareCapital'] : (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['ReservesSurplus'] : (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['TotalFunds'] : (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['ShareApplication'] : (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['L_term_borrowings'] : (string)(trim( $res['L_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['deferred_tax_liabilities'] : (string)(trim( $res['deferred_tax_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['O_long_term_liabilities'] : (string)(trim( $res['O_long_term_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['L_term_provisions'] : (string)(trim( $res['L_term_provisions'] ))/$currencyValue[ trim( $res['FY'] ) ] . '</span></li> 
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_non_current_liabilities'] : (string)(trim( $res['T_non_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['S_term_borrowings'] : (string)(trim( $res['S_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Trade_payables'] : (string)(trim( $res['Trade_payables'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['O_current_liabilities'] : (string)(trim( $res['O_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['S_term_provisions'] : (string)(trim( $res['S_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_current_liabilities'] : (string)(trim( $res['T_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_equity_liabilities'] : (string)(trim( $res['T_equity_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Tangible_assets'] : (string)(trim( $res['Tangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ] ) . '</span></li> 
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Intangible_assets'] : (string)(trim( $res['Intangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_fixed_assets'] : (string)(trim( $res['T_fixed_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['N_current_investments'] : (string)(trim( $res['N_current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Deferred_tax_assets'] : (string)(trim( $res['Deferred_tax_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['L_term_loans_advances'] : (string)(trim( $res['L_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['O_non_current_assets'] : (string)(trim( $res['O_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_non_current_assets'] : (string)(trim( $res['T_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Current_investments'] : (string)(trim( $res['Current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Inventories'] : (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Trade_receivables'] : (string)(trim( $res['Trade_receivables'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Cash_bank_balances'] : (string)(trim( $res['Cash_bank_balances'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['S_term_loans_advances'] : (string)(trim( $res['S_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['O_current_assets'] : (string)(trim( $res['O_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_current_assets'] : (string)(trim( $res['T_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Total_assets'] : (string)(trim( $res['Total_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                    </ul>';
                                                    }
                                        $str .= '</div>
                                            </div>';
                                                } else {
                                                    $str .= 'No data found.';
                                                }
                                            }
                                $str .= '</div>
                                        <div id="ratio_balan_new' . $cprofile_id . '" class="tab-pane fade">';
                                        //Ratio with Balancesheet new    
                                        $Qry = mysql_query("select * from plstandard a INNER JOIN balancesheet_new b ON a.FY = b.FY AND a.CID_FK = b.CID_FK where a.CID_FK = '$cprofile_id' and a.ResultType='0'  GROUP BY a.FY ORDER BY a.FY DESC");
                                        if(mysql_num_rows($Qry) > 0){
                                        }else{
                                            $Qry = mysql_query("select * from balancesheet_new CID_FK = '$cprofile_id' and ResultType='0' FY DESC");
                                        }
                                        if(mysql_num_rows($Qry) > 0){
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>CurrentRatio</span></li>
                                                <li><span>QuickRatio</span></li>
                                                <li><span>RoE</span></li>
                                                <li><span>RoA</span></li>
                                                <li><span>EBITDAMargin</span></li>
                                                <li><span>PATMargin</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
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

                                            $str .= '<ul>
                                                        <li><span>' . $ratio_cal['FY'] . '</span></li>
                                                        <li><span>' . $ratio_cal['CurrentRatio'] . '</span></li>
                                                        <li><span>' . $ratio_cal['QuickRatio'] . '</span></li>
                                                        <li><span>' . $ratio_cal['RoE'] . '</span></li>
                                                        <li><span>' . $ratio_cal['RoA'] . '</span></li>
                                                        <li><span>' . $ratio_cal['EBITDAMargin'] . '</span></li>
                                                        <li><span>' . $ratio_cal['PATMargin'] . '</span></li>
                                                    </ul>';
                                            }
                                        $str .= '</div>
                                            </div>';
                                        }
                                $str .= '</div>
                                    </div>
                                </div>        
                            </td>';                               
              
                $str .= '</tr>';
                $str .= '<tr class="infoTR financialRow-con" style="display: none;">
                            <td colspan="6" class="no-pd">
                                <div class="fin-wpr">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#plstd1' . $cprofile_id . '">PL standard</a></li>
                                        <li><a data-toggle="tab" href="#balan_shet_new1' . $cprofile_id . '">Balance sheet<span>New</span></a></li>
                                       </ul>
                                    <div class="tab-content tbl-cnt">
                                        <div id="plstd1' . $cprofile_id . '" class="tab-pane fade in active">';
                //PL STANDARD STARTED
                $res1 = array();
                $plQuery = "SELECT PLStandard_Id,CId_FK,IndustryId_FK,OptnlIncome,OtherIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,FY,TotalIncome,BINR,DINR,EmployeeRelatedExpenses,ForeignExchangeEarningandOutgo,EarninginForeignExchange,OutgoinForeignExchange FROM plstandard WHERE CId_FK = '" . $cprofile_id . "' and FY !='' and ResultType='1' ORDER BY FY DESC LIMIT 0,100";
                $PLStsQry = mysql_query( $plQuery ) or die( mysql_error() );
                if( mysql_num_rows( $PLStsQry) > 0 ) {
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>PLStandard_Id</span></li>
                                                <li><span>CId_FK</span></li>
                                                <li><span>IndustryId_FK</span></li>
                                                <li><span>OptnlIncome</span></li>
                                                <li><span>OtherIncome</span></li>
                                                <li><span>OptnlAdminandOthrExp</span></li>
                                                <li><span>OptnlProfit</span></li>
                                                <li><span>EBITDA</span></li>
                                                <li><span>Interest</span></li>
                                                <li><span>EBDT</span></li>
                                                <li><span>Depreciation</span></li>
                                                <li><span>EBT</span></li>
                                                <li><span>Tax</span></li>
                                                <li><span>PAT</span></li>
                                                <li><span>TotalIncome</span></li>
                                                <li><span>BINR</span></li>
                                                <li><span>DINR</span></li>
                                                <li><span>EmployeeRelatedExpenses</span></li>
                                                <li><span>EarninginForeignExchange</span></li>
                                                <li><span>OutgoinForeignExchange</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
                    while( $res = mysql_fetch_array( $PLStsQry ) ) {
                        $res1 = array();
                        $res1['PLStandard_Id'] = trim($res['PLStandard_Id']);
                        $res1['CId_FK'] = trim($res['CId_FK']);
                        $res1['IndustryId_FK'] = trim( $res['IndustryId_FK']);
                        $res1['OptnlIncome_INR'] = trim( $res['OptnlIncome'] );
                        $res1['OptnlIncome_USD'] = (string)(trim( $res['OptnlIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['OtherIncome_INR'] = trim( $res['OtherIncome'] );
                        $res1['OtherIncome_USD'] = (string)(trim( $res['OtherIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['OptnlAdminandOthrExp_INR'] = trim( $res['OptnlAdminandOthrExp'] );
                        $res1['OptnlAdminandOthrExp_USD'] = (string)(trim( $res['OptnlAdminandOthrExp'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['OptnlProfit_INR'] = trim( $res['OptnlProfit'] );
                        $res1['OptnlProfit_USD'] = (string)(trim( $res['OptnlProfit'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['EBITDA_INR'] = trim( $res['EBITDA'] );
                        $res1['EBITDA_USD'] = (string)(trim( $res['EBITDA'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['Interest_INR'] = trim( $res['Interest'] );
                        $res1['Interest_USD'] = (string)(trim( $res['Interest'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['EBDT_INR'] = trim( $res['EBDT'] );
                        $res1['EBDT_USD'] = (string)(trim( $res['EBDT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['Depreciation_INR'] = trim( $res['Depreciation'] );
                        $res1['Depreciation_USD'] = (string)(trim( $res['Depreciation'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['EBT_INR'] = trim( $res['EBT'] );
                        $res1['EBT_USD'] = (string)(trim( $res['EBT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['Tax_INR'] = trim( $res['Tax'] );
                        $res1['Tax_USD'] = (string)(trim( $res['Tax'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['PAT_INR'] = trim( $res['PAT'] );
                        $res1['PAT_USD'] = (string)(trim( $res['PAT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['FY'] = trim( $res['FY'] );
                        $res1['TotalIncome_INR'] = trim( $res['TotalIncome'] );
                        $res1['TotalIncome_USD'] = (string)(trim( $res['TotalIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['BINR_INR'] = trim( $res['BINR'] );
                        $res1['BINR_USD'] = (string)(trim( $res['BINR'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        $res1['DINR_INR'] = trim( $res['DINR'] );
                        $res1['DINR_USD'] = (string)(trim( $res['DINR'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        if($res['EmployeeRelatedExpenses']!= ""){
                            $EmployeeRelatedExpenses1_INR = trim( $res['EmployeeRelatedExpenses'] );
                            $EmployeeRelatedExpenses1_USD = (string)(trim( $res['EmployeeRelatedExpenses'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        }else{
                            $EmployeeRelatedExpenses1_INR = $EmployeeRelatedExpenses1_USD = "0";
                        }
                        $res1['EmployeeRelatedExpenses_INR'] = $EmployeeRelatedExpenses1_INR;
                        $res1['EmployeeRelatedExpenses_USD'] = $EmployeeRelatedExpenses1_USD;

                        if($res['EarninginForeignExchange']!= ""){
                            $EarninginForeignExchange1_INR = trim( $res['EarninginForeignExchange'] );
                            $EarninginForeignExchange1_USD = (string)(trim( $res['EarninginForeignExchange'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        }else{
                            $EarninginForeignExchange1_INR = $EarninginForeignExchange1_USD = "0";
                        }
                        $res1['EarninginForeignExchange_INR'] = $EarninginForeignExchange1_INR;
                        $res1['EarninginForeignExchange_USD'] = $EarninginForeignExchange1_USD;

                        if($res['OutgoinForeignExchange']!= ""){
                            $OutgoinForeignExchange1_INR = trim( $res['OutgoinForeignExchange'] );
                            $OutgoinForeignExchange1_USD = (string)(trim( $res['OutgoinForeignExchange'] )/$currencyValue[ trim( $res['FY'] ) ]);
                        }else{
                            $OutgoinForeignExchange1_INR = $OutgoinForeignExchange1_USD = "0";
                        }
                        $res1['OutgoinForeignExchange_INR'] = $OutgoinForeignExchange1_INR;
                        $res1['OutgoinForeignExchange_USD'] = $OutgoinForeignExchange1_USD;
                        
                       /* if(! empty( $res1 ) ) {
                            $data_inner['plstandard'][] = $res1;
                        }else{
                            $data_inner['plstandard'][] = "";
                        }*/
                        if(! empty($res1) ) {
                            $data_inner_1['Consolidated'][] = $res1;
                        }else{
                            $data_inner_1['Consolidated'][]   = "";
                        }
                        if(! empty( $data_inner_1 ) ) {
                            $data_inner['plstandard'] = $data_inner_1;
                        }else{
                            $data_inner['plstandard'] = "";
                        }
                                            $OptnlIncome = ( $curreny_code == 'INR' ) ? trim( $res['OptnlIncome'] ) : (string)(trim( $res['OptnlIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $OtherIncome = ( $curreny_code == 'INR' ) ? trim( $res['OtherIncome'] ) : (string)(trim( $res['OtherIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $OptnlAdminandOthrExp = ( $curreny_code == 'INR' ) ? trim( $res['OptnlAdminandOthrExp'] ) : (string)(trim( $res['OptnlAdminandOthrExp'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $OptnlProfit = ( $curreny_code == 'INR' ) ? trim( $res['OptnlProfit'] ) : (string)(trim( $res['OptnlProfit'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EBITDA = ( $curreny_code == 'INR' ) ? trim( $res['EBITDA'] ) : (string)(trim( $res['EBITDA'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $Interest = ( $curreny_code == 'INR' ) ? trim( $res['Interest'] ) : (string)(trim( $res['Interest'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EBDT = ( $curreny_code == 'INR' ) ? trim( $res['EBDT'] ) : (string)(trim( $res['EBDT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $Depreciation = ( $curreny_code == 'INR' ) ? trim( $res['Depreciation'] ) : (string)(trim( $res['Depreciation'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EBT = ( $curreny_code == 'INR' ) ? trim( $res['EBT'] ) : (string)(trim( $res['EBT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $Tax = ( $curreny_code == 'INR' ) ? trim( $res['Tax'] ) : (string)(trim( $res['Tax'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $PAT = ( $curreny_code == 'INR' ) ? trim( $res['PAT'] ) : (string)(trim( $res['PAT'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $TotalIncome = ( $curreny_code == 'INR' ) ? trim( $res['TotalIncome'] ) : (string)(trim( $res['TotalIncome'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $BINR = ( $curreny_code == 'INR' ) ? trim( $res['BINR'] ) : (string)(trim( $res['BINR'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $DINR = ( $curreny_code == 'INR' ) ? trim( $res['DINR'] ) : (string)(trim( $res['DINR'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EmployeeRelatedExpenses = ( $curreny_code == 'INR' ) ? trim( $res['EmployeeRelatedExpenses'] ) : (string)(trim( $res['EmployeeRelatedExpenses'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $EarninginForeignExchange = ( $curreny_code == 'INR' ) ? trim( $res['EarninginForeignExchange'] ) : (string)(trim( $res['EarninginForeignExchange'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $OutgoinForeignExchange = ( $curreny_code == 'INR' ) ? trim( $res['OutgoinForeignExchange'] ) : (string)(trim( $res['OutgoinForeignExchange'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                            $str .= '<ul>
                                                        <li><span>' . trim( $res['FY'] ) . '</span></li>
                                                        <li><span>' . trim($res['PLStandard_Id']) . '</span></li>
                                                        <li><span>' . trim($res['CId_FK']) . '</span></li>
                                                        <li><span>' . trim( $res['IndustryId_FK']) . '</span></li>
                                                        <li><span>' . $OptnlIncome . '</span></li>
                                                        <li><span>' . $OtherIncome . '</span></li>
                                                        <li><span>' . $OptnlAdminandOthrExp . '</span></li>
                                                        <li><span>' . $OptnlProfit . '</span></li>
                                                        <li><span>' . $EBITDA . '</span></li>
                                                        <li><span>' . $Interest . '</span></li>
                                                        <li><span>' . $EBDT . '</span></li>
                                                        <li><span>' . $Depreciation . '</span></li>
                                                        <li><span>' . $EBT . '</span></li>
                                                        <li><span>' . $Tax . '</span></li>
                                                        <li><span>' . $PAT . '</span></li>
                                                        <li><span>' . $TotalIncome . '</span></li>
                                                        <li><span>' . $BINR . '</span></li>
                                                        <li><span>' . $DINR . '</span></li>
                                                        <li><span>' . $EmployeeRelatedExpenses . '</span></li>
                                                        <li><span>' . $EarninginForeignExchange . '</span></li>
                                                        <li><span>' . $OutgoinForeignExchange . '</span></li>
                                                    </ul>';
                    }
                    $str .= '                   </div>
                                            </div>';
                } else {
                    $str .= 'No data found.';
                }
                
                $str .= '               </div>
                                        <div id="balan_shet_new1' . $cprofile_id . '" class="tab-pane fade">';
                                            //Balancesheet New
                                            $Qry = mysql_query("SELECT * FROM balancesheet_new a INNER JOIN plstandard b ON a.FY = b.FY AND a.CID_FK = b.CID_FK WHERE a.CID_FK = '$cprofile_id' and b.ResultType='1' and a.ResultType='1' GROUP BY a.FY ORDER BY a.FY DESC LIMIT 0,100");
                                            if(mysql_num_rows($Qry) > 0){
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>ShareCapital</span></li>
                                                <li><span>ReservesSurplus</span></li>
                                                <li><span>TotalFunds</span></li>
                                                <li><span>ShareApplication</span></li>
                                                <li><span>L_term_borrowings</span></li>
                                                <li><span>deferred_tax_liabilities</span></li>
                                                <li><span>O_long_term_liabilities</span></li>
                                                <li><span>L_term_provisions</span></li>
                                                <li><span>T_non_current_liabilities</span></li>
                                                <li><span>S_term_borrowings</span></li>
                                                <li><span>Trade_payables</span></li>
                                                <li><span>O_current_liabilities</span></li>
                                                <li><span>S_term_provisions</span></li>
                                                <li><span>T_current_liabilities</span></li>
                                                <li><span>T_equity_liabilities</span></li>
                                                <li><span>Tangible_assets</span></li>
                                                <li><span>Intangible_assets</span></li>
                                                <li><span>T_fixed_assets</span></li>
                                                <li><span>N_current_investments</span></li>
                                                <li><span>Deferred_tax_assets</span></li>
                                                <li><span>L_term_loans_advances</span></li>
                                                <li><span>O_non_current_assets</span></li>
                                                <li><span>T_non_current_assets</span></li>
                                                <li><span>Current_investments</span></li>
                                                <li><span>Inventories</span></li>
                                                <li><span>Trade_receivables</span></li>
                                                <li><span>Cash_bank_balances</span></li>
                                                <li><span>S_term_loans_advances</span></li>
                                                <li><span>O_current_assets</span></li>
                                                <li><span>T_current_assets</span></li>
                                                <li><span>Total_assets</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
                                                while($res = mysql_fetch_array($Qry)){
                                                    $res1 = array();
                                                    $res1['FY'] = $res['FY'];
                                                    $res1['ShareCapital_INR'] = $res['ShareCapital'];
                                                    $res1['ShareCapital_USD'] = (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['ReservesSurplus_INR'] = $res['ReservesSurplus'];
                                                    $res1['ReservesSurplus_USD'] = (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['TotalFunds_INR'] = $res['TotalFunds'];
                                                    $res1['TotalFunds_USD'] = (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['ShareApplication_INR'] = $res['ShareApplication'];
                                                    $res1['ShareApplication_USD'] = (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['L_term_borrowings_INR'] = $res['L_term_borrowings'];
                                                    $res1['L_term_borrowings_USD'] = (string)(trim( $res['L_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['deferred_tax_liabilities_INR'] = $res['deferred_tax_liabilities'];
                                                    $res1['deferred_tax_liabilities_USD'] = (string)(trim( $res['deferred_tax_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['O_long_term_liabilities_INR'] = $res['O_long_term_liabilities'];
                                                    $res1['O_long_term_liabilities_USD'] = (string)(trim( $res['O_long_term_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['L_term_provisions_INR'] = $res['L_term_provisions']; 
                                                    $res1['L_term_provisions_USD'] = (string)(trim( $res['L_term_provisions'] ))/$currencyValue[ trim( $res['FY'] ) ]; 
                                                    $res1['T_non_current_liabilities_INR'] = $res['T_non_current_liabilities'];
                                                    $res1['T_non_current_liabilities_USD'] = (string)(trim( $res['T_non_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['S_term_borrowings_INR'] = $res['S_term_borrowings'];
                                                    $res1['S_term_borrowings_USD'] = (string)(trim( $res['S_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Trade_payables_INR'] = $res['Trade_payables'];
                                                    $res1['Trade_payables_USD'] = (string)(trim( $res['Trade_payables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['O_current_liabilities_INR'] = $res['O_current_liabilities'];
                                                    $res1['O_current_liabilities_USD'] = (string)(trim( $res['O_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['S_term_provisions_INR'] = $res['S_term_provisions'];
                                                    $res1['S_term_provisions_USD'] = (string)(trim( $res['S_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_current_liabilities_INR'] = $res['T_current_liabilities'];
                                                    $res1['T_current_liabilities_USD'] = (string)(trim( $res['T_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_equity_liabilities_INR'] = $res['T_equity_liabilities'];
                                                    $res1['T_equity_liabilities_USD'] = (string)(trim( $res['T_equity_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Tangible_assets_INR'] = $res['Tangible_assets'];
                                                    $res1['Tangible_assets_USD'] = (string)(trim( $res['Tangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);  
                                                    $res1['Intangible_assets_INR'] = $res['Intangible_assets'];
                                                    $res1['Intangible_assets_USD'] = (string)(trim( $res['Intangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_fixed_assets_INR'] = $res['T_fixed_assets'];
                                                    $res1['T_fixed_assets_USD'] = (string)(trim( $res['T_fixed_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['N_current_investments_INR'] = $res['N_current_investments'];
                                                    $res1['N_current_investments_USD'] = (string)(trim( $res['N_current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Deferred_tax_assets_INR'] = $res['Deferred_tax_assets'];
                                                    $res1['Deferred_tax_assets_USD'] = (string)(trim( $res['Deferred_tax_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['L_term_loans_advances_INR'] = $res['L_term_loans_advances'];
                                                    $res1['L_term_loans_advances_USD'] = (string)(trim( $res['L_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['O_non_current_assets_INR'] = $res['O_non_current_assets'];
                                                    $res1['O_non_current_assets_USD'] = (string)(trim( $res['O_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_non_current_assets_INR'] = $res['T_non_current_assets'];
                                                    $res1['T_non_current_assets_USD'] = (string)(trim( $res['T_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Current_investments_INR'] = $res['Current_investments'];
                                                    $res1['Current_investments_USD'] = (string)(trim( $res['Current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Inventories_INR'] = $res['Inventories'];
                                                    $res1['Inventories_USD'] = (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Trade_receivables_INR'] = $res['Trade_receivables'];
                                                    $res1['Trade_receivables_USD'] = (string)(trim( $res['Trade_receivables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Cash_bank_balances_INR'] = $res['Cash_bank_balances'];
                                                    $res1['Cash_bank_balances_USD'] = (string)(trim( $res['Cash_bank_balances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['S_term_loans_advances_INR'] = $res['S_term_loans_advances'];
                                                    $res1['S_term_loans_advances_USD'] = (string)(trim( $res['S_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['O_current_assets_INR'] = $res['O_current_assets'];
                                                    $res1['O_current_assets_USD'] = (string)(trim( $res['O_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['T_current_assets_INR'] = $res['T_current_assets'];
                                                    $res1['T_current_assets_USD'] = (string)(trim( $res['T_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $res1['Total_assets_INR'] = $res['Total_assets'];
                                                    $res1['Total_assets_USD'] = (string)(trim( $res['Total_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    /*if(!empty($res1)){
                                                         $data_inner['balancesheet_new'][] = $res1; 
                                                    }else{
                                                         $data_inner['balancesheet_new'][] = "";
                                                    }*/
                                                    if(!empty($res1) ) {
                                                        $data_inner_2['Consolidated'][] = $res1;
                                                    }else{
                                                        $data_inner_2['Consolidated'][]   = "";
                                                    }
                                                    if(!empty( $data_inner_2 ) ) {
                                                        $data_inner['balancesheet_new'] = $data_inner_2;
                                                    }else{
                                                        $data_inner['balancesheet_new'] = "";
                                                    }

                                                    $ShareCapital = ( $curreny_code == 'INR' ) ? $res['ShareCapital'] : (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $ReservesSurplus = ( $curreny_code == 'INR' ) ? $res['ReservesSurplus'] : (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $TotalFunds = ( $curreny_code == 'INR' ) ? $res['TotalFunds'] : (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $ShareApplication = ( $curreny_code == 'INR' ) ? $res['ShareApplication'] : (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $L_term_borrowings = ( $curreny_code == 'INR' ) ? $res['L_term_borrowings'] : (string)(trim( $res['L_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $deferred_tax_liabilities = ( $curreny_code == 'INR' ) ? $res['deferred_tax_liabilities'] : (string)(trim( $res['deferred_tax_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $O_long_term_liabilities = ( $curreny_code == 'INR' ) ? $res['O_long_term_liabilities'] : (string)(trim( $res['O_long_term_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $L_term_provisions = ( $curreny_code == 'INR' ) ? $res['L_term_provisions'] : (string)(trim( $res['L_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_non_current_liabilities = ( $curreny_code == 'INR' ) ? $res['T_non_current_liabilities'] : (string)(trim( $res['T_non_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $S_term_borrowings = ( $curreny_code == 'INR' ) ? $res['S_term_borrowings'] : (string)(trim( $res['S_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Trade_payables = ( $curreny_code == 'INR' ) ? $res['Trade_payables'] : (string)(trim( $res['Trade_payables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $O_current_liabilities = ( $curreny_code == 'INR' ) ? $res['O_current_liabilities'] : (string)(trim( $res['O_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $S_term_provisions = ( $curreny_code == 'INR' ) ? $res['S_term_provisions'] : (string)(trim( $res['S_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_current_liabilities = ( $curreny_code == 'INR' ) ? $res['T_current_liabilities'] : (string)(trim( $res['T_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_equity_liabilities = ( $curreny_code == 'INR' ) ? $res['T_equity_liabilities'] : (string)(trim( $res['T_equity_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Tangible_assets = ( $curreny_code == 'INR' ) ? $res['Tangible_assets'] : (string)(trim( $res['Tangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Intangible_assets = ( $curreny_code == 'INR' ) ? $res['Intangible_assets'] : (string)(trim( $res['Intangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_fixed_assets = ( $curreny_code == 'INR' ) ? $res['T_fixed_assets'] : (string)(trim( $res['T_fixed_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $N_current_investments = ( $curreny_code == 'INR' ) ? $res['N_current_investments'] : (string)(trim( $res['N_current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Deferred_tax_assets = ( $curreny_code == 'INR' ) ? $res['Deferred_tax_assets'] : (string)(trim( $res['Deferred_tax_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $L_term_loans_advances = ( $curreny_code == 'INR' ) ? $res['L_term_loans_advances'] : (string)(trim( $res['L_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $O_non_current_assets = ( $curreny_code == 'INR' ) ? $res['O_non_current_assets'] : (string)(trim( $res['O_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_non_current_assets = ( $curreny_code == 'INR' ) ? $res['T_non_current_assets'] : (string)(trim( $res['T_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Current_investments = ( $curreny_code == 'INR' ) ? $res['Current_investments'] : (string)(trim( $res['Current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Inventories = ( $curreny_code == 'INR' ) ? $res['Inventories'] : (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Trade_receivables = ( $curreny_code == 'INR' ) ? $res['Trade_receivables'] : (string)(trim( $res['Trade_receivables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Cash_bank_balances = ( $curreny_code == 'INR' ) ? $res['Cash_bank_balances'] : (string)(trim( $res['Cash_bank_balances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $S_term_loans_advances = ( $curreny_code == 'INR' ) ? $res['S_term_loans_advances'] : (string)(trim( $res['S_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $O_current_assets = ( $curreny_code == 'INR' ) ? $res['O_current_assets'] : (string)(trim( $res['O_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $T_current_assets = ( $curreny_code == 'INR' ) ? $res['T_current_assets'] : (string)(trim( $res['T_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $Total_assets = ( $curreny_code == 'INR' ) ? $res['Total_assets'] : (string)(trim( $res['Total_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                    $str .= '<ul>
                                                                <li><span>' . $res['FY'] . '</span></li>
                                                                <li><span>' . $ShareCapital . '</span></li>
                                                                <li><span>' . $ReservesSurplus . '</span></li>
                                                                <li><span>' . $TotalFunds . '</span></li>
                                                                <li><span>' . $ShareApplication . '</span></li>
                                                                <li><span>' . $L_term_borrowings . '</span></li>
                                                                <li><span>' . $deferred_tax_liabilities . '</span></li>
                                                                <li><span>' . $O_long_term_liabilities . '</span></li>
                                                                <li><span>' . $L_term_provisions . '</span></li> 
                                                                <li><span>' . $T_non_current_liabilities . '</span></li>
                                                                <li><span>' . $S_term_borrowings . '</span></li>
                                                                <li><span>' . $Trade_payables . '</span></li>
                                                                <li><span>' . $O_current_liabilities . '</span></li>
                                                                <li><span>' . $S_term_provisions . '</span></li>
                                                                <li><span>' . $T_current_liabilities . '</span></li>
                                                                <li><span>' . $T_equity_liabilities . '</span></li>
                                                                <li><span>' . $Tangible_assets . '</span></li>  
                                                                <li><span>' . $Intangible_assets . '</span></li>
                                                                <li><span>' . $T_fixed_assets . '</span></li>
                                                                <li><span>' . $N_current_investments . '</span></li>
                                                                <li><span>' . $Deferred_tax_assets . '</span></li>
                                                                <li><span>' . $L_term_loans_advances . '</span></li>
                                                                <li><span>' . $O_non_current_assets . '</span></li>
                                                                <li><span>' . $T_non_current_assets . '</span></li>
                                                                <li><span>' . $Current_investments . '</span></li>
                                                                <li><span>' . $Inventories . '</span></li>
                                                                <li><span>' . $Trade_receivables . '</span></li>
                                                                <li><span>' . $Cash_bank_balances . '</span></li>
                                                                <li><span>' . $S_term_loans_advances . '</span></li>
                                                                <li><span>' . $O_current_assets . '</span></li>
                                                                <li><span>' . $T_current_assets . '</span></li>
                                                                <li><span>' . $Total_assets . '</span></li>
                                                            </ul>';
                                                }
                                        $str .= '</div>
                                            </div>';
                                            } else {
                                                $Qry = mysql_query("SELECT * FROM balancesheet_new a WHERE a.CID_FK = '$cprofile_id' and a.ResultType='1' ORDER BY a.FY DESC LIMIT 0,100");
                                                if(mysql_num_rows($Qry) > 0){
                                    $str .= '<ul class="fix-ul">
                                                <li><span>FY</span></li>
                                                <li><span>ShareCapital</span></li>
                                                <li><span>ReservesSurplus</span></li>
                                                <li><span>TotalFunds</span></li>
                                                <li><span>ShareApplication</span></li>
                                                <li><span>L_term_borrowings</span></li>
                                                <li><span>deferred_tax_liabilities</span></li>
                                                <li><span>O_long_term_liabilities</span></li>
                                                <li><span>L_term_provisions</span></li>
                                                <li><span>T_non_current_liabilities</span></li>
                                                <li><span>S_term_borrowings</span></li>
                                                <li><span>Trade_payables</span></li>
                                                <li><span>O_current_liabilities</span></li>
                                                <li><span>S_term_provisions</span></li>
                                                <li><span>T_current_liabilities</span></li>
                                                <li><span>T_equity_liabilities</span></li>
                                                <li><span>Tangible_assets</span></li>
                                                <li><span>Intangible_assets</span></li>
                                                <li><span>T_fixed_assets</span></li>
                                                <li><span>N_current_investments</span></li>
                                                <li><span>Deferred_tax_assets</span></li>
                                                <li><span>L_term_loans_advances</span></li>
                                                <li><span>O_non_current_assets</span></li>
                                                <li><span>T_non_current_assets</span></li>
                                                <li><span>Current_investments</span></li>
                                                <li><span>Inventories</span></li>
                                                <li><span>Trade_receivables</span></li>
                                                <li><span>Cash_bank_balances</span></li>
                                                <li><span>S_term_loans_advances</span></li>
                                                <li><span>O_current_assets</span></li>
                                                <li><span>T_current_assets</span></li>
                                                <li><span>Total_assets</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
                                                    while($res = mysql_fetch_array($Qry)){
                                                        $res1 = array();
                                                        $res1['FY'] = $res['FY'];
                                                        $res1['ShareCapital_INR'] = $res['ShareCapital'];
                                                        $res1['ShareCapital_USD'] = (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['ReservesSurplus_INR'] = $res['ReservesSurplus'];
                                                        $res1['ReservesSurplus_USD'] = (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['TotalFunds_INR'] = $res['TotalFunds'];
                                                        $res1['TotalFunds_USD'] = (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['ShareApplication_INR'] = $res['ShareApplication'];
                                                        $res1['ShareApplication_USD'] = (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['L_term_borrowings_INR'] = $res['L_term_borrowings'];
                                                        $res1['L_term_borrowings_USD'] = (string)(trim( $res['L_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['deferred_tax_liabilities_INR'] = $res['deferred_tax_liabilities'];
                                                        $res1['deferred_tax_liabilities_USD'] = (string)(trim( $res['deferred_tax_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['O_long_term_liabilities_INR'] = $res['O_long_term_liabilities'];
                                                        $res1['O_long_term_liabilities_USD'] = (string)(trim( $res['O_long_term_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['L_term_provisions_INR'] = $res['L_term_provisions']; 
                                                        $res1['L_term_provisions_USD'] = (string)(trim( $res['L_term_provisions'] ))/$currencyValue[ trim( $res['FY'] ) ]; 
                                                        $res1['T_non_current_liabilities_INR'] = $res['T_non_current_liabilities'];
                                                        $res1['T_non_current_liabilities_USD'] = (string)(trim( $res['T_non_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['S_term_borrowings_INR'] = $res['S_term_borrowings'];
                                                        $res1['S_term_borrowings_USD'] = (string)(trim( $res['S_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Trade_payables_INR'] = $res['Trade_payables'];
                                                        $res1['Trade_payables_USD'] = (string)(trim( $res['Trade_payables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['O_current_liabilities_INR'] = $res['O_current_liabilities'];
                                                        $res1['O_current_liabilities_USD'] = (string)(trim( $res['O_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['S_term_provisions_INR'] = $res['S_term_provisions'];
                                                        $res1['S_term_provisions_USD'] = (string)(trim( $res['S_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_current_liabilities_INR'] = $res['T_current_liabilities'];
                                                        $res1['T_current_liabilities_USD'] = (string)(trim( $res['T_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_equity_liabilities_INR'] = $res['T_equity_liabilities'];
                                                        $res1['T_equity_liabilities_USD'] = (string)(trim( $res['T_equity_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Tangible_assets_INR'] = $res['Tangible_assets']; 
                                                        $res1['Tangible_assets_USD'] = (string)(trim( $res['Tangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ] ); 
                                                        $res1['Intangible_assets_INR'] = $res['Intangible_assets'];
                                                        $res1['Intangible_assets_USD'] = (string)(trim( $res['Intangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_fixed_assets_INR'] = $res['T_fixed_assets'];
                                                        $res1['T_fixed_assets_USD'] = (string)(trim( $res['T_fixed_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['N_current_investments_INR'] = $res['N_current_investments'];
                                                        $res1['N_current_investments_USD'] = (string)(trim( $res['N_current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Deferred_tax_assets_INR'] = $res['Deferred_tax_assets'];
                                                        $res1['Deferred_tax_assets_USD'] = (string)(trim( $res['Deferred_tax_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['L_term_loans_advances_INR'] = $res['L_term_loans_advances'];
                                                        $res1['L_term_loans_advances_USD'] = (string)(trim( $res['L_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['O_non_current_assets_INR'] = $res['O_non_current_assets'];
                                                        $res1['O_non_current_assets_USD'] = (string)(trim( $res['O_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_non_current_assets_INR'] = $res['T_non_current_assets'];
                                                        $res1['T_non_current_assets_USD'] = (string)(trim( $res['T_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Current_investments_INR'] = $res['Current_investments'];
                                                        $res1['Current_investments_USD'] = (string)(trim( $res['Current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Inventories_INR'] = $res['Inventories'];
                                                        $res1['Inventories_USD'] = (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Trade_receivables_INR'] = $res['Trade_receivables'];
                                                        $res1['Trade_receivables_USD'] = (string)(trim( $res['Trade_receivables'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Cash_bank_balances_INR'] = $res['Cash_bank_balances'];
                                                        $res1['Cash_bank_balances_USD'] = (string)(trim( $res['Cash_bank_balances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['S_term_loans_advances_INR'] = $res['S_term_loans_advances'];
                                                        $res1['S_term_loans_advances_USD'] = (string)(trim( $res['S_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['O_current_assets_INR'] = $res['O_current_assets'];
                                                        $res1['O_current_assets_USD'] = (string)(trim( $res['O_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['T_current_assets_INR'] = $res['T_current_assets'];
                                                        $res1['T_current_assets_USD'] = (string)(trim( $res['T_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        $res1['Total_assets_INR'] = $res['Total_assets'];
                                                        $res1['Total_assets_USD'] = (string)(trim( $res['Total_assets'] )/$currencyValue[ trim( $res['FY'] ) ]);
                                                        /*if( !empty( $res1 ) ) {
                                                            $data_inner['balancesheet_new'][] = $res1;
                                                        } else {
                                                            $data_inner['balancesheet_new'][] = "";
                                                        }*/
                                                        if(!empty($res1) ) {
                                                            $data_inner_2['Consolidated'][] = $res1;
                                                        }else{
                                                            $data_inner_2['Consolidated'][]   = "";
                                                        }
                                                        if(!empty( $data_inner_2 ) ) {
                                                            $data_inner['balancesheet_new'] = $data_inner_2;
                                                        }else{
                                                            $data_inner['balancesheet_new'] = "";
                                                        }

                                            $str .= '<ul>
                                                        <li><span>' . $res1[''] = $res['FY'] . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['ShareCapital'] : (string)(trim( $res['ShareCapital'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['ReservesSurplus'] : (string)(trim( $res['ReservesSurplus'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['TotalFunds'] : (string)(trim( $res['TotalFunds'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['ShareApplication'] : (string)(trim( $res['ShareApplication'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['L_term_borrowings'] : (string)(trim( $res['L_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['deferred_tax_liabilities'] : (string)(trim( $res['deferred_tax_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['O_long_term_liabilities'] : (string)(trim( $res['O_long_term_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['L_term_provisions'] : (string)(trim( $res['L_term_provisions'] ))/$currencyValue[ trim( $res['FY'] ) ] . '</span></li> 
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_non_current_liabilities'] : (string)(trim( $res['T_non_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['S_term_borrowings'] : (string)(trim( $res['S_term_borrowings'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Trade_payables'] : (string)(trim( $res['Trade_payables'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['O_current_liabilities'] : (string)(trim( $res['O_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['S_term_provisions'] : (string)(trim( $res['S_term_provisions'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_current_liabilities'] : (string)(trim( $res['T_current_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_equity_liabilities'] : (string)(trim( $res['T_equity_liabilities'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Tangible_assets'] : (string)(trim( $res['Tangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ] ) . '</span></li> 
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Intangible_assets'] : (string)(trim( $res['Intangible_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_fixed_assets'] : (string)(trim( $res['T_fixed_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['N_current_investments'] : (string)(trim( $res['N_current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Deferred_tax_assets'] : (string)(trim( $res['Deferred_tax_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['L_term_loans_advances'] : (string)(trim( $res['L_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['O_non_current_assets'] : (string)(trim( $res['O_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_non_current_assets'] : (string)(trim( $res['T_non_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Current_investments'] : (string)(trim( $res['Current_investments'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Inventories'] : (string)(trim( $res['Inventories'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Trade_receivables'] : (string)(trim( $res['Trade_receivables'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Cash_bank_balances'] : (string)(trim( $res['Cash_bank_balances'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['S_term_loans_advances'] : (string)(trim( $res['S_term_loans_advances'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['O_current_assets'] : (string)(trim( $res['O_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['T_current_assets'] : (string)(trim( $res['T_current_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                        <li><span>' . ( $curreny_code == 'INR' ) ? $res['Total_assets'] : (string)(trim( $res['Total_assets'] )/$currencyValue[ trim( $res['FY'] ) ]) . '</span></li>
                                                    </ul>';
                                                    }
                                        $str .= '</div>
                                            </div>';
                                                } else {
                                                    $str .= 'No data found.';
                                                }
                                            }
                                $str .= '</div> 
                                    </div>
                                </div>        
                            </td>';                               
                $str .= '</tr>';
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
                $cin_check_director = mysql_query("SELECT cin_detail_din_directors.Name, cin_detail_din_directors.DIN  FROM cin_detail_din_directors  LEFT JOIN cprofile i ON ( i.CIN = cin_detail_din_directors.CIN ) WHERE Company_Id =$cprofile_id");
                $cin_check_director_count = mysql_num_rows($cin_check_director);
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
                $companyProfile['City'] = $cin_res['city_name'];
                $companyProfile['Pincode'] = $cin_res['Pincode'];
                $companyProfile['State'] = $cin_res['state_name'];
                $companyProfile['Country'] = $cin_res['Country_Name'];
                $companyProfile['Telephone'] = $cin_res['Phone'];
                $companyProfile['Sector'] = $cin_res['SectorName'];
                $companyProfile['NAICSCode'] = $cin_res['naics_code'];
                $companyProfile['Email'] = $cin_res['Email'];
                $companyProfile['FormerlyCalled'] = $cin_res['FormerlyCalled'];    
                $companyProfile['ContactName'] = $cin_res['CEO'];
                $companyProfile['Designation'] = $cin_res['CFO'];
                $companyProfile['YearFounded'] = $cin_res['IncorpYear'];
                $companyProfile['Website'] = $cin_res['Website'];
                $companyProfile['CompanyStatus'] = $cin_res['company_status'];
                $companyProfile['LinkedIn'] = $cin_res['LinkedIn'];
                if($cin_check_director_count>0){
                    $directorContent = '<table style="margin-left:10px;"><tbody><tr style="border-bottom:none;text-align:left;"> <th style="padding-left: 10px;">DIN</th><th style="padding-left: 10px;">Director Name</th> </tr>';
                    while ($directorRow = mysql_fetch_array($cin_check_director)) { 
                        $directorContent .='<tr style="border-bottom:none;text-align: left;"> <td style="padding: 10px 10px;">'.$directorRow['DIN'].'</td> <td style="padding: 10px 10px;">'.$directorRow['Name'].'</td> </tr>';
                        
                        /* Start for JSON Build  */
                        $directorsDetail['DIN']=$directorRow['DIN'];
                        $directorsDetail['Name']=$directorRow['Name'];
                         if(!empty($directorsDetail)) { 
                            $companyProfile['Director'][]=$directorsDetail;
                        } else { 
                            $companyProfile['Director'][]='';
                          }
                        /* End for JSON Build  */  
                    }
                    
                    $directorContent .='</tbody></table>'; 
                    }else{$directorContent="<table><tbody><tr ><td></td></tr></tbody></table>";}
                $str .= '<tr class="infoTR companyRow" style="display: none;">
                            <td colspan="6" class="no-pd">
                                <div class="fin-wpr">
                                    <div class="tab-content tbl-cnt comp-cnt">
                                        <div class="tab-pane fade in active">
                                            <ul class="fix-ul side-title">
                                                <li><span>Old CINs</span></li>
                                                <li><span>PreviouslyKnownAs</span></li>
                                                <li><span>TransactionStatus</span></li>
                                                <li><span>BusinessDescription</span></li>
                                                <li><span>Address</span></li>
                                                <li><span>City</span></li>
                                                <li><span>Pincode</span></li>
                                                <li><span>State</span></li>
                                                <li><span>Country</span></li>
                                                <li><span>Telephone</span></li>
                                                <li><span>Sector</span></li>
                                                <li><span>NAICSCode</span></li>
                                                <li><span>Email</span></li>
                                                <li><span>FormerlyCalled</span></li>
                                                <li><span>ContactName</span></li>
                                                <li><span>Designation</span></li>
                                                <li><span>YearFounded</span></li>
                                                <li><span>Website</span></li>
                                                <li><span>Company Status</span></li>
                                                <li><span>LinkedIn</span></li>
                                                <li><span>Directors</span></li>
                                            </ul>
                                            <ul style="width:50%;" class="side-content">
                                                <li><span>' . $cin_res['Old_CIN'] . '</span></li>
                                                <li><span>' . $companyResult['SCompanyName'] . '</span></li>
                                                <li><span>' . $Status1 . '</span></li>
                                                <li><span>' . $cin_res['BusinessDesc'] . '</span></li>
                                                <li><span>' . $cin_res['AddressHead'] . '</span></li>
                                                <li><span>' . $cin_res['city_name'] . '</span></li>
                                                <li><span>' . $cin_res['Pincode'] . '</span></li>
                                                <li><span>' . $cin_res['state_name'] . '</span></li>
                                                <li><span>' . $cin_res['Country_Name'] . '</span></li>
                                                <li><span>' . $cin_res['Phone'] . '</span></li>
                                                <li><span>' . $cin_res['SectorName'] . '</span></li>
                                                <li><span>' . $cin_res['naics_code'] . '</span></li>
                                                <li><span>' . $cin_res['Email'] . '</span></li>
                                                <li><span>' . $cin_res['FormerlyCalled'] . '</span></li>
                                                <li><span>' . $cin_res['CEO'] . '</span></li>
                                                <li><span>' . $cin_res['CFO'] . '</span></li>
                                                <li><span>' . $cin_res['IncorpYear'] . '</span></li>
                                                <li><span>' . $cin_res['Website'] . '</span></li>
                                                <li><span>' . $cin_res['company_status'] . '</span></li>
                                                <li><span>' . $cin_res['LinkedIn'] . '</span></li>
                                                <li>'.$directorContent.'</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>';
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
                $getcompanysql = "select PECompanyId from pecompanies where CINNo ='".$companyResult[ 'CIN' ]."'";
                $companyrs = mysql_query($getcompanysql);          
                $myrow=mysql_fetch_array($companyrs);
                $fundingArray = array();
                if( count($myrow) > 0 && $myrow['PECompanyId']!='') {
                    $str .= '<tr class="infoTR fundingRow" style="display: none;">
                                <td colspan="6" class="no-pd">
                                    <div class="fin-wpr">
                                        <div class="tbl-cnt">';
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
                        $str .= '           <ul class="fix-ul">
                                                <li><span>Company</span></li>
                                                <li><span>Sector</span></li>
                                                <li><span>Investor</span></li>
                                                <li><span>Date</span></li>
                                                <li><span>Exit Status</span></li>
                                                <li><span>Amount</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                            <div class="tab-scroll">';
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
                            $str .= '       <ul>
                                                <li><span>' . trim( $ped[ "companyname" ] ) . '</span></li>
                                                <li><span>' . trim( $showindsec ) . '</span></li>
                                                <li><span>' . $ped[ "Investor" ] . '</span></li>
                                                <li><span>' . $ped[ "dealperiod" ] . '</span></li>
                                                <li><span>' . $exitstatus_name . '</span></li>
                                                <li><span>' . $hideamount . '</span></li>
                                            </ul>';
                            $fi++;
                        }
                        $data['funding'] = $fundingArray;
                    } else {
                        $data['funding'] = "";
                    }
                    $str .= '           </div>
                                        </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>';
                } else {
                    $data['funding'] = "";
                    $str .= '<tr class="infoTR fundingRow" style="display: none;">
                                <td colspan="6" class="no-pd">
                                    <div class="fin-wpr">
                                        <div class="tbl-cnt">
                                            No data found
                                        </div>
                                    </div>
                                </td>
                            </tr>';
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
            //echo '<pre>'; print_r( $data ); echo '</pre>';
            if( $jsonl_gen ) {
                $final_data .= json_encode( $data )."\n";        
            } else {
                $finalData[ $companyResult[ 'CIN' ] ] = $data;
            }

        }
        $str .= '</tbody>
            </table>';
    }
}

/*header('Content-Type: application/json');
echo json_encode( $finalData );*/
if( $jsonl_gen ) {
    $responseArray = array( 'html' => $str, 'Status' => 'Success', 'jsonresp' => $final_data );
} else {
    //$finalData[ 'Status' ] = 'Success';
    $responseArray = array( 'html' => $str, 'Status' => 'Success', 'jsonresp' => $finalData );
}
echo json_encode( $responseArray );

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