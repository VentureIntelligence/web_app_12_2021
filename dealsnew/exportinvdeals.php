<?php include_once("../globalconfig.php"); ?>
<?php

//session_save_path("/tmp");
//session_start();

require("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
header('Location:../pelogin.php');
}
else
{

//Check Session Id 
$sesID = session_id();
$emailid = $_SESSION['UserEmail'];
$sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='" . $emailid . "' AND `dbTYpe`='PE'";
$resUserLogSel = mysql_query($sqlUserLogSel);
$cntUserLogSel = mysql_num_rows($resUserLogSel);
if ($cntUserLogSel > 0) {
    $resUserLogSel = mysql_fetch_array($resUserLogSel);
    $logSessionId = $resUserLogSel['sessionId'];
    if ($logSessionId != $sesID) {
        header('Location: logoff.php?value=caccess');
    }
}
$DcompanyId = $_SESSION['DcompanyId'];
if($DcompanyId == 697447099){
    $comp_industry_id_where = "and  pec.industry=3 ";
}

function updateDownload($res) {
    //Added By JFR-KUTUNG - Download Limit
    $recCount = mysql_num_rows($res);
    $dlogUserEmail = $_SESSION['UserEmail'];
    $today = date('Y-m-d');

    //Check Existing Entry
    $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '" . $dlogUserEmail . "' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
    $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
    $rowSelCount = mysql_num_rows($sqlSelResult);
    $rowSel = mysql_fetch_object($sqlSelResult);
    $downloads = $rowSel->recDownloaded;

    if ($rowSelCount > 0) {
        $upDownloads = $recCount + $downloads;
        $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='" . $upDownloads . "' WHERE `emailId` = '" . $dlogUserEmail . "' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
        $resUdt = mysql_query($sqlUdt) or die(mysql_error());
    } else {
        $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','" . $dlogUserEmail . "','" . $today . "','PE','" . $recCount . "')";
        mysql_query($sqlIns) or die(mysql_error());
    }
}

//include('onlineaccount.php');
$displayMessage = "";
$mailmessage = "";
//global $LoginAccess;
//global $LoginMessage;
$TrialExpired = "Your email login has expired. Please contact info@ventureintelligence.in";
$dbTypeSV = "SV";
$dbTypeIF = "IF";
$dbTypeCT = "CT";
$companyIdDel = 1718772497;
$companyIdSGR = 390958295;
$companyIdVA = 38248720;
$companyIdGlobal = 730002984;
$addDelind = "";
$hideWhere = '';
$dateValue=$_POST['txthidedate'];
                $hidedateStartValue=$_POST['txthidedateStartValue'];
                $hidedateEndValue=$_POST['txthidedateEndValue'];
                $industry=$_POST['txthideindustryid'];
                $sectorval=$_POST['txthidesectorval'];
                $subsectorval=$_POST['txthidesubsector'];
                $syndication=$_POST['txthidesyndication'];
                $dealsinvolvingvalue=$_POST['txthidedealsinvolving'];
                $stageval=$_POST['txthidestageval'];
                $round=$_POST['txthideround'];
                $regionId=$_POST['txthideregionid'];
                $city=$_POST['txthidecity'];
                $invType=$_POST['txthideinvtypeid'];
                $startRangeValue=$_POST['txthiderangeStartValue'];
                $endRangeValue=$_POST['txthiderangeEndValue'];
                $yearafter=$_POST['yearafter'];
                $yearbefore=$_POST['yearbefore'];
                $txthidepe=$_POST['txthidepe'];
                $state=$_POST['state'];
                $city=$_POST['cityid'];
                $companyType=$_POST['companyType'];
                $debt_equity=$_POST['debt_equity'];
                $listallcompany=$_POST['listallcompanies'];
                $exitstatusValue=$_POST['txthideexitstatusValue'];
                $valuationsql=$_POST['txthidevaluation'];
                $investor_head=$_POST['countryid'];
                $keyword = $_POST['txthideinvestor'];
                $invandor = $_POST['invandor'];
                $companysearch=$_POST['txthidecompany'];
                $advisorsearchstring_legal=$_POST['txthideadvisor_legal'];
                $tagsearch=$_POST['tagsearch'];
                $searchallfield=$_POST['txthidesearchallfield'];
               
if ($listallcompany != 1) {
     $isAggregate = 'AND pe.SPV=0 and pe.AggHide=0';
} else {
     $isAggregate = '';
}
               
            $industry=explode(",",$industry);
if ($industry != '' && (count($industry) > 0)) {
    $indusSql = $industryvalue = '';$industryvalueid = '';
    foreach ($industry as $industrys) {
        $indusSql .= " IndustryId=$industrys or ";
    }
    $indusSql = trim($indusSql, ' or ');
    $industrysql = "select industry,industryid from industry where $indusSql";

    if ($industryrs = mysql_query($industrysql)) {
        while ($myrow = mysql_fetch_array($industryrs, MYSQL_BOTH)) {
            $industryvalue .= $myrow["industry"] . ',';
            $industryvalueid .= $myrow["industryid"] . ',';
        }
    }
    $industryvalue = trim($industryvalue, ',');
    $industryvalueid = trim($industryvalueid, ',');
    $industry_hide = implode($industry, ',');
}
$sector=explode(",",$sector);
if ($sector != '' && (count($sector) > 0)) {
    $sectorvalue = '';
    $sectorstr = implode(',',$sector); 
    $sectorssql = "select sector_name,sector_id from pe_sectors where sector_id IN ($sectorstr)";
   
    if ($sectors = mysql_query($sectorssql)) {
        while ($myrow = mysql_fetch_array($sectors, MYSQL_BOTH)) {
            $sectorvalue .= $myrow["sector_name"] . ',';
            $sectorvalueid .= $myrow["sector_id"] . ',';
        }
    }
   
    $sectorvalue = trim($sectorvalue, ',');
    $sectorvalueid = trim($sectorvalueid, ',');
    $sector_hide = implode($sector, ',');
    // $industry_hide = implode($industry, ',');
}

if ($subsector != '' && (count($subsector) > 0)) {
    $subsectorvalue = '';
    $subsectorvalue = implode(',',$subsector); 
}


// Round Value
if (count($round) > 0) {
    $roundSql = $roundTxtVal = '';
    foreach ($round as $rounds) {
        $roundSql .= " `round` like '" . $rounds . "' or `round` like '" . $rounds . "-%' or ";
        $roundTxtVal .= $rounds . ',';
    }
    $roundTxtVal = trim($roundTxtVal, ',');
    $roundSqlStr = trim($roundSql, ' or ');
    $roundSql = "SELECT * FROM `peinvestments` where $roundSqlStr group by `round`";
   // echo $roundSql;
    if ($roundQuery = mysql_query($roundSql)) {
        $roundtxt = '';
        while ($myrow = mysql_fetch_array($roundQuery, MYSQL_BOTH)) {
            $roundtxt .= $myrow["round"] . ",";
        }
        $roundtxt = trim($roundtxt, ',');
    }
}

//
$stageCnt = 0;
$cnt = 0;
$stageCntSql = "select count(StageId) as cnt from stage";
if ($rsStageCnt = mysql_query($stageCntSql)) {
    while ($mystagecntrow = mysql_fetch_array($rsStageCnt, MYSQL_BOTH)) {
        $stageCnt = $mystagecntrow["cnt"];
    }
}
   
if ($boolStage == true) {
    foreach ($stageval as $stageid) {
        $stagesql = "select Stage,StageId from stage where StageId=$stageid";
        //    echo "<br>**".$stagesql;
        if ($stagers = mysql_query($stagesql)) {
            while ($myrow = mysql_fetch_array($stagers, MYSQL_BOTH)) {
                $cnt = $cnt + 1;
                $stagevaluetext = $stagevaluetext . "," . $myrow["Stage"];
                $stagevalueid .= $myrow["StageId"] . ',';
            }
        }
    }
    $stagevaluetext = substr_replace($stagevaluetext, '', 0, 1);
    if ($cnt == $stageCnt) {$stagevaluetext = "All Stages";

    }
} else {
    $stagevaluetext = "";
}

if ($getstage != '') {
    $stagevaluetext = $getstage;
} else if ($getrg != '') {
    $getrangevalue = $getrg;
} else if ($getinv != '') {
    $getinvestorvalue = $getinv;
} else if ($getreg != '') {
    $getregionevalue = $getreg;
} else if ($getindus != '') {
    $getindusvalue = $getindus;
}
//echo "<br>*************".$stagevaluetext;

//valuations
// if ($boolvaluations == true) {
//     $valuationsql = '';

//     $count = count($valuations);
//     foreach ($valuations as $v) {
//        $coa = ' and ';
//         $valuationsql .= " pe.$v!=0 $coa";
        
//     }
//     //$valuationsql.= trim($valuationsql," and ");
    
//     /*if ($count == 1) {$valuationsql = "pe.$valuations[0]!=0 AND ";} else if ($count == 2) {$valuationsql = "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0   AND ";} else if ($count == 3) {$valuationsql = "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0  AND  pe.$valuations[2]!=0  AND ";} else if ($count == 4) {$valuationsql = "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0  AND  pe.$valuations[2]!=0  AND   pe.$valuations[3]!=0  AND ";}*/
// //            $valuattext =substr_replace($valuattext, '', 0,1);
//     //echo $valuationsql; exit();
// } else { $valuationsql = '';}
//valuations
 
if ($companyType == "L") {
    $companyTypeDisplay = "Listed";
} elseif ($companyType == "U") {
    $companyTypeDisplay = "UnListed";
} elseif ($companyType == "--") {
    $companyTypeDisplay = "";
}

if ($debt_equity == 0) {
    $debt_equityDisplay = "Equity only";
} elseif ($debt_equity == 1) {
    $debt_equityDisplay = "Debt only";
} elseif ($debt_equity == "--") {
    $debt_equityDisplay = "Both";
}

if ($syndication == 0) {
    $syndication_Display = "Yes";
} elseif ($syndication == 1) {
    $syndication_Display = "No";
} elseif ($syndication == "--") {
    $syndication_Display = "Both";
}

if ($investorType != "--") {
    $invTypeSql = "select InvestorTypeName from investortype where InvestorType='$investorType'";
    if ($invrs = mysql_query($invTypeSql)) {
        while ($myrow = mysql_fetch_array($invrs, MYSQL_BOTH)) {
            $invtypevalue = $myrow["InvestorTypeName"];
        }
    }
}

if ($investor_head != "--") {
    $invheadSql = "select country from country where countryid='$investor_head'";
    if ($invrs = mysql_query($invheadSql)) {
        while ($myrow = mysql_fetch_array($invrs, MYSQL_BOTH)) {
            $invheadvalue = $myrow["country"];
        }
    }
}

if (count($regionId) > 0) {
    $region_Sql = $regionvalue = '';
    foreach ($regionId as $regionIds) {
        $region_Sql .= " RegionId=$regionIds or ";
    }
    $regionSqlStr = trim($region_Sql, ' or ');

    $regionSql = "select Region,RegionId from region where $regionSqlStr";
    if ($regionrs = mysql_query($regionSql)) {
        while ($myregionrow = mysql_fetch_array($regionrs, MYSQL_BOTH)) {
            $regionvalue .= $myregionrow["Region"] . ', ';
            $regionvalueId .= $myregionrow["RegionId"] . ', ';
        }
    }
    $regionvalue = trim($regionvalue, ', ');
    $region_hide = implode($regionId, ',');
}
$month1=$_POST['txtmonth1'];
$month2=$_POST['txtmonth2'];
$year1=$_POST['txtyear1'];
$year2=$_POST['txtyear2'];
$datevalue = $_POST['txthidedate'];
// $splityear1 = (substr($year1, 2));
// $splityear2 = (substr($year2, 2));


// if (($month1 != "--") && ($month2 !== "--") && ($year1 != "--") && ($year2 != "--")) {
//     $sdatevalueDisplay1 = returnMonthname($month1) . " " . $splityear1;
//     $edatevalueDisplay2 = returnMonthname($month2) . "  " . $splityear2;
//     $wheredates1 = "";
// }

// $datevalueDisplay1 = $sdatevalueDisplay1;
// $datevalueDisplay2 = $edatevalueDisplay2;

$orderby = "";
$ordertype = "";
if (!$_POST || $sectorsearch != '' || $tagsearch != '') {

    $stagevaluetext = '';
    $valuationstxt = '';
    $getrangevalue = '';
    $getinvestorvalue = '';
    $getregionevalue = '';
    $getindusvalue = '';
    $datevalueCheck1 = '';
    $industry = array();
    $sector = array();
    $subsector = array();
    $round = array();
    $companyType = '--';
    $investorType = '--';
    $investor_head='--';
    $regionId = array();
    $state = array();
    // $city = '--';
    // $cityid="--";
    $city = array();
    $startRangeValue = '';
    $endRangeValue = '';
    $exitstatusValue = array();
    $debt_equity = '--';
    $syndication = "--";
    $valuations = array();
    $yearbefore='';
    $yearafter='';
}

if ($_SESSION['PE_industries'] != '') {

    $comp_industry_id_where = ' AND pec.industry IN (' . $_SESSION['PE_industries'] . ') ';

}

$DcompanyId = $_SESSION['DcompanyId'];
//$DcompanyId = 697447099;
if ($DcompanyId == 697447099) {
    $comp_industry_id_where .= "and  pec.industry=3 ";
}

if ($getyear != '' || $getindus != '' || $getstage != '' || $getinv != '' || $getreg != '' || $getrg != '') {
    
    $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business,
                 amount,pe.Amount_INR, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod , pec.website, pec.city,
                 pec.region,pe.PEId,pe.comment,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId ,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
                                 (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                 FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
                                 WHERE dates between '" . $getdt1 . "' and '" . $getdt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                            " . $getind . " " . $getst . " " . $getinvest . " " . $getregion . " " . $getrange . " and pe.Deleted=0" . $addVCFlagqry . " " . $addDelind . " AND pe.PEId NOT
                                            IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                $comp_industry_id_where
                                            GROUP BY pe.PEId ";
    
} else if (!$_POST) {

    $yourquery = 0;
    $stagevaluetext = "";
    $industry = array();

    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    //echo "<br>Query for all records";


    
    $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR, round, s.stage,  stakepercentage, 
    DATE_FORMAT( dates, '%M-%Y' ) as dealperiod , pec.website, pec.city,pec.region,pe.PEId,pe.comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide,pe.dates as dates,pe.Exit_Status,
    (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
    JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
    JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
    JOIN industry AS i ON pec.industry = i.industryid
    JOIN stage AS s ON s.StageId=pe.StageId
    WHERE pe.dates between '" . $dt1 . "' and '" . $dt2 . "'
    and pe.Deleted=0 $isAggregate " . $addVCFlagqry . " " . $addDelind . "  
    AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = '$dbTypeSV' AND hide_pevc_flag =1)
    $comp_industry_id_where
    GROUP BY pe.PEId";

       
        $orderby = "dates";
        $ordertype = "desc";
    
                            // echo "<br>all records" .$companysql;
} elseif ($tagsearch != "") {
    $yourquery = 1;
    $industry = array();
    $stagevaluetext = "";
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";
    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";

    $tags = '';
    $ex_tags = explode(',', $tagsearch);
    if (count($ex_tags) > 0) {
        for ($l = 0; $l < count($ex_tags); $l++) {
            if ($ex_tags[$l] != '') {
                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                $value = str_replace(" ", "", $value);
                //$tags .= "pec.tags like '%:$value%' or ";
                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                if ($tagandor == 0) {
                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                } else {
                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                }
            }
        }
    }

    if ($tagandor == 0) {
        $tagsval = trim($tags, ' and ');
    } else {
        $tagsval = trim($tags, ' or ');
    }
    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

        $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

         $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

       $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

         $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

    }else{
         $hideWhere = " ";
    }
    $companysql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
                            pe.amount, pe.Amount_INR, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod ,
                            pec.website, pec.city, pec.region, pe.PEId,
                            pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
                            (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                            FROM peinvestments AS pe, industry AS i,
                            pecompanies AS pec,stage as s,
                            peinvestments_investors as peinv_invs,peinvestors as invs
                            WHERE dates between '" . $dt1 . "' and '" . $dt2 .  "' $hideWhere  AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                            AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0  $isAggregate" . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
                            AND pe.PEId NOT
                            IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId =  '$dbTypeSV'
                            AND hide_pevc_flag =1
                            )
                            $comp_industry_id_where GROUP BY pe.PEId ";

   
    $orderby = "dates";
    $ordertype = "desc";
    $popup_search = 1;
   
} elseif ($searchallfield != "") {
    $yourquery = 1;
    $industry = array();
    $stagevaluetext = "";
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";
    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

        $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

         $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

       $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

         $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

    }else{
         $hideWhere = " ";
    }
    if ($_POST['popup_select'] == 'exact') {

        $cityLike .= "pec.city REGEXP '[[:<:]]" . $searchallfield . "[[:>:]]'";
        $companyLike .= "pec.companyname REGEXP '[[:<:]]" . $searchallfield . "[[:>:]]'";
        $sectorLike .= "sector_business REGEXP '[[:<:]]" . $searchallfield . "[[:>:]]'";
        $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]" . $searchallfield . "[[:>:]]'";
        $investorLike .= "inv.investor REGEXP '[[:<:]]" . $searchallfield . "[[:>:]]'";
        $industryLike .= "i.industry REGEXP '[[:<:]]" . $searchallfield . "[[:>:]]'";
        $websiteLike .= "pec.website REGEXP '[[:<:]]" . $searchallfield . "[[:>:]]'";
        //$tagsLike .= "pec.tags LIKE '%$searchFieldExp%' AND "; // old vijay
        $tagsLike .= "(pec.tags REGEXP '[[.colon.]]$searchallfield' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,')";
        //$tagsLike .= "pec.tags LIKE '%$searchFieldExp%' AND "; // new varatha

        $cityLike = '(' . trim($cityLike) . ')';
        $companyLike = '(' . trim($companyLike) . ')';
        $sectorLike = '(' . trim($sectorLike) . ')';
        $moreInfoLike = '(' . trim($moreInfoLike) . ')';
        $investorLike = '(' . trim($investorLike) . ')';
        $industryLike = '(' . trim($industryLike) . ')';
        $websiteLike = '(' . trim($websiteLike) . ')';
        $tagsLike = '(' . trim($tagsLike) . ')';
        //$tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%' or pec.tags REGEXP '[[.colon.]]$searchallfield$' or pec.tags REGEXP '[[.colon.]]$searchallfield,'";
        $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike . ' OR ' . $industryLike . ' OR ' . $websiteLike . ' OR ' . $tagsLike;

    } else {

        $searchExplode = explode(' ', $searchallfield);
        foreach ($searchExplode as $searchFieldExp) {
            
            $cityLike .= "pec.city REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
            $companyLike .= "pec.companyname REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
            $sectorLike .= "sector_business REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
            $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
            $investorLike .= "inv.investor REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
            $industryLike .= "i.industry REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
            $websiteLike .= "pec.website REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
            //$tagsLike .= "pec.tags LIKE '%$searchFieldExp%' AND "; // old vijay
            $tagsLike .= "(pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,') and ";
            //$tagsLike .= "pec.tags LIKE '%$searchFieldExp%' AND "; // new varatha
        }
        $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";
        $cityLike = '(' . trim($cityLike, 'AND ') . ')';
        $companyLike = '(' . trim($companyLike, 'AND ') . ')';
        $sectorLike = '(' . trim($sectorLike, 'AND ') . ')';
        $moreInfoLike = '(' . trim($moreInfoLike, 'AND ') . ')';
        $investorLike = '(' . trim($investorLike, 'AND ') . ')';
        $industryLike = '(' . trim($industryLike, 'AND ') . ')';
        $websiteLike = '(' . trim($websiteLike, 'AND ') . ')';
        $tagsLike = '(' . trim($tagsLike, 'and ') . ')';
        //$tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%' or pec.tags REGEXP '[[.colon.]]$searchallfield$' or pec.tags REGEXP '[[.colon.]]$searchallfield,'";
        $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike . ' OR ' . $industryLike . ' OR ' . $websiteLike . ' OR ' . $tagsLike;

    }

   
     $companysql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,pe.amount, pe.Amount_INR, pe.round, s.Stage,  
                    pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod ,pec.website, pec.city, pec.region, pe.PEId,pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,(SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                JOIN industry AS i ON pec.industry = i.industryid
                JOIN stage AS s ON s.StageId=pe.StageId
                WHERE pe.dates between '" . $dt1 . "' and '" . $dt2 . "' " . $hideWhere . "  and pe.Deleted =0 ".$isAggregate . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
                AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1) $comp_industry_id_where
                GROUP BY pe.PEId ";

    $orderby = "dates";
    $ordertype = "desc";
    $popup_search = 1;

    //mysql_query("insert in to search_operations (user_id,user_name,keyword_search,PE,CFS) values(".$_SESSION['UserEmail'].",".$_SESSION['UserNames'].",".$searchallfield.",1,0");
    //echo "<bR>---" .$companysql;
} elseif ($sectorsearch != "") {

    $sectorsearchArray = explode(",", str_replace("'", "", $sectorsearch));
    $sector_sql = array(); // Stop errors when $words is empty
    $sectors_filter = '';
    foreach ($sectorsearchArray as $word) {
        $word = trim($word);
        $sector_sql[] = " sector_business = '$word' ";
        $sector_sql[] = " sector_business LIKE '$word(%' ";
        $sector_sql[] = " sector_business LIKE '$word (%' ";
        $sectors_filter .= $word . ',';
    }
    $sectors_filter = trim($sectors_filter, ',');
    $sector_filter = implode(" OR ", $sector_sql);

    $yourquery = 1;
    $industry = array();
    $stagevaluetext = "";
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";

    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";

    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

        $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";
    
    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){
    
         $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";
    
    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){
    
       $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";
    
    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){
    
         $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";
    
    }else{
         $hideWhere = " ";
    }

    $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
                pe.amount,pe.Amount_INR, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod ,pec.website, pec.city, pec.region, pe.PEId,
                pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,SPV,AggHide,pe.dates as dates ,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                FROM peinvestments AS pe, industry AS i,
                pecompanies AS pec,stage as s
                WHERE dates between '" . $dt1 . "' and '" . $dt2 .  "' $hideWhere AND  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                AND pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " AND  ($sector_filter)   AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )
                                $comp_industry_id_where
                                GROUP BY pe.PEId ";

    

    $orderby = "dates";
    $ordertype = "desc";
    $popup_search = 1;

    //    echo "<br>Query for company search";
    //         echo "<br> sector search--" .$companysql;
} elseif ($advisorsearchstring_trans != "" || $advisorsearchstring_legal != "") {
     if ($advisorsearchstring_trans != ""){
    $transtype='T';
    $advisorName=$advisorsearchstring_trans;
   }else{
    $transtype='L';
    $advisorName=$advisorsearchstring_legal;
   }
   if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

    $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

}elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

     $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

}elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

   $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

}elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

     $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

}else{
     $hideWhere = " ";
}
   $industry=array_filter($industry);
   if (count($industry) > 0) {
       $indusSql = '';
       foreach ($industry as $industrys) {
           $indusSql .= " pec.industry=$industrys or ";
       }
       $indusSql = trim($indusSql, ' or ');
       if ($indusSql != '') {
           $whereind = ' ( ' . $indusSql . ' ) ';
       }
   }
   $regionId=explode(",",$regionId);
   $regionId=array_filter($regionId);
    //print_r($industry);
     if (count($regionId) > 0) {
        $increg = "JOIN region AS r ON r.RegionId=pec.RegionId";
    }
     
     if((count($sector) > 0 && $sector !="") || (count($subsector) > 0 && $subsector !="")){
        $joinsectortable = ',pe_subsectors AS pe_sub ';
        $sectorcondition="pe_sub.PECompanyId = pec.PECompanyId and"; 
    } else {
        $sectorcondition='';
        $joinsectortable = '';
    } 

    if ($sectorval != '') {
        $sectorvalarray=explode(",", $sectorval);
        foreach($sectorvalarray as $key=>$sectorvals)
            {
                $sectorsql123="select sector_name from pe_sectors where sector_id=".$sectorvals;
               
                $sectorquery=mysql_query($sectorsql123);
                if($row=mysql_fetch_row($sectorquery))
                {
                    $sector123.="'".$row[0]."'";
                    $sector123.=',';
                }
            }
            
           $sectorString= trim($sector123,",");
           if($sectorString!=""){
            $wheresectorsql = " pe_sec.sector_name IN($sectorString)";
           }
           //$wheresectorsql = " pe_sub.sector_id IN($sectorval)";
        }
    if ($subsectorval != '') {
                     $wheresubsectorsql = " pe_sub.subsector_name IN($subsectorval)";
    }
    //
    $round=explode(",",$round);
    $round=array_filter($round);
    if (count($round) > 0) {
        $roundSql = '';
        foreach ($round as $rounds) {
            $roundSql .= " pe.round LIKE '" . $rounds . "' or  pe.round LIKE '" . $rounds . "%' or pe.round LIKE '%" . $rounds . "%' or";
        }
        if ($roundSql != '') {
            $whereRound = '(' . trim($roundSql, ' or ') . ')';
        }
    }
    //
    //  echo "<br> WHERE IND--" .$whereind;
    if (count($regionId) > 0) {
        $region_Sql = '';
        foreach ($regionId as $regionIds) {
            $region_Sql .= " pec.RegionId  =$regionIds or ";
        }
        $regionSqlStr = trim($region_Sql, ' or ');
        $qryRegionTitle = "Region - ";
        if ($regionSqlStr != '') {
            $whereregion = '(' . $regionSqlStr . ')';
        }
    }
    // if ($city != "") {
    //     $whereCity = "and pec.city LIKE '" . $city . "%'";
    // }else{
    //     $whereCity = "";
    // }
    //    echo " <bR> where REGION--- " .$whereregion;
    if ($companyType != "--" && $companyType != "") {
        $wherelisting_status = "and  pe.listing_status='" . $companyType . "'";
    }
    else{
        $wherelisting_status = "";
    }

    if ($debt_equity != "--" && $debt_equity != "") {if ($debt_equity == 1) {$whereSPVdebt = "and pe.SPV='" . $debt_equity . "'";
        $listallcompany = 1;} else { $whereSPVdebt = "and pe.SPV='" . $debt_equity . "'";}}else{
            $whereSPVdebt="";
        }

    if ($syndication != "--" && $syndication != "") {

        if ($syndication == 0) {
            $wheresyndication = " Having Investorcount > 1";
        } else {
            $wheresyndication = " Having Investorcount <= 1";
        }

    }else{
        $wheresyndication = "";
    }
    if ($invType != "--" ) {
        $qryInvType = "Investor Type - ";
        $whereInvType = " pe.InvestorType = '" . $invType . "'";
    }
     if ($investor_head != "--" && $investor_head != '') {
           $whereInvhead = "inv.countryid = '" . $investor_head . "'";
    } 
    if ($stageval!="")
    {
            $stagevalues="";
            $stageidvalues="";
            $stageval1 = explode(',',$stageval);
            if(count($stageval1) > 0){
                for($j=0;$j<count($stageval1);$j++)
            {
                    $stage = $stageval1[$j];
                    //echo "<br>****----" .$stage;
                        $stagevalues .= " pe.StageId=" .$stage." or ";
                    $stageidvalues=$stageidvalue.",".$stage;
            }
            }

            $wherestage = $stagevalues ;
            $qryDealTypeTitle="Stage  - ";
            $strlength=strlen($wherestage);
            $strlength=$strlength-3;
    //echo "<Br>----------------" .$wherestage;
    $wherestage= substr ($wherestage , 0,$strlength);
    $wherestage ="(".$wherestage.")";
    //echo "<br>---" .$stringto;

    } 
if (($startRangeValue != "--") && ($endRangeValue != "") && ($startRangeValue != "") && ($endRangeValue != "--")) {
$startRangeValue = $startRangeValue;
// $endRangeValue = $endRangeValue - 0.01;
$qryRangeTitle = "Deal Range (M$) - ";
if ($startRangeValue < $endRangeValue) {
// $whererange = " pe.amount between  " . $startRangeValue . " and " . $endRangeValue;
$whererange = " pe.amount >=  ".$startRangeValue ." and  pe.amount <". $endRangeValue ."";
} elseif (($startRangeValue = $endRangeValue)) {
$whererange = " pe.amount >= " . $startRangeValue;
}
} else if ($startRangeValue == "--" && $endRangeValue > 0) {
$startRangeValue = 0;
//   $endRangeValue = $endRangeValue - 0.01;
// $whererange = " pe.amount between  " . $startRangeValue . " and " . $endRangeValue;
$whererange = " pe.amount >=  ".$startRangeValue ." and  pe.amount <". $endRangeValue ."";
}
//echo "<Br>***".$whererange;
$exitstatusValue=explode(",",$exitstatusValue);
if ($exitstatusValue != '' && $exitstatusValue != '--' && count($exitstatusValue) > 0) {
foreach ($exitstatusValue as $exitstatusValues) {
if ($exitstatusValues != '--' && $exitstatusValues != '') {
$exitstatusSql .= " Exit_Status  = '" . $exitstatusValues . "' or ";
}
}
$whereexitstatus = trim($exitstatusSql, ' or ');
if ($whereexitstatus != '') {
$whereexitstatus = '(' . $whereexitstatus . ')';
}
$exitstatusValue_hide = implode($exitstatusValue, ',');
}

   
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";

    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    
    $companysql = "(
                                    SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount,pe.Amount_INR,
                                                     cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%M-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                                    (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
                                                    (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount
                                    FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                    peinvestments_advisorinvestors AS adac,stage as s ".$joinsectortable. " WHERE dates between '" . $dt1 . "' and '" . $dt2 .  "' $hideWhere AND   pe.Deleted=0 and pec.industry = i.industryid
                                    AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and 
$valuationsql  $sectorcondition
                                     adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . $whereind . $wheresectorsql . $wheresubsectorsql . $whereRound . $whereregion . $whereCity . $wherelisting_status . $whereSPVdebt.$whereInvType. $wherestage .$whererange.$whereexitstatus.$whereInvhead." AND cia.cianame LIKE '%$advisorName%'  and AdvisorType='".$transtype."'
                                    AND pe.PEId NOT
                                                    IN (
                                                    SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE DBTypeId = '$dbTypeSV'
                                                    AND hide_pevc_flag =1
                                                    ) $comp_industry_id_where GROUP BY pe.PEId ".$wheresyndication.")
                                    UNION (
                                    SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,pe.Amount_INR,
                                                     cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%M-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                                    (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
                                                    (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount
                                    FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                    peinvestments_advisorcompanies AS adac,stage as s  ".$joinsectortable. " 
                                                    WHERE dates between '" . $dt1 . "' and '" . $dt2 .  "' $hideWhere and pe.Deleted=0 and pec.industry = i.industryid ".$isAggregate."
                                    AND pec.PECompanyId = pe.PECompanyId
                                    AND adac.CIAId = cia.CIAID and 
$valuationsql  $sectorcondition
                                     adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind .$whereind.$wheresectorsql.$wheresubsectorsql.$whereRound.$whereregion.$whereCity. $wherelisting_status.$whereSPVdebt.$whereInvType. $wherestage .$whererange.$whereexitstatus .$whereInvhead." AND cia.cianame LIKE '%$advisorName%'  and AdvisorType='".$transtype."'
                                    AND pe.PEId NOT
                                                    IN (
                                                    SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE DBTypeId = '$dbTypeSV'
                                                    AND hide_pevc_flag =1
                                                    )
                                                    $comp_industry_id_where
                                                    GROUP BY pe.PEId ".$wheresyndication.")";
   
   
    $orderby = "companyname";
    $ordertype = "asc";
    $popup_search = 1;
  
} 
//elseif (count($industry) > 0 || count($sector) > 0 || count($subsector) > 0 || $keyword != "" || $companysearch != "" || count($round) > 0 || ($city != "") || ($companyType != "--") || ($debt_equity != "--") || ($syndication != "--") || ($yearafter != "") || ($yearbefore != "") || ($investorType != "--") || ($investor_head != "--")|| (count($regionId) > 0) || ($startRangeValue == "--") || ($endRangeValue == "--") || (count($exitstatusValue) > 0) || (count($dealsinvolvingvalue) > 0)  || (($month1 != "--") && ($year1 != "--") && ($month2 != "--") && ($year2 != "--")) . $checkForStageValue || count($state)>0 || (count($city)>0 )) {
    else if ($companysearch !="" || $keyword != "" || $companyType !='' || ($industry !="--" && $industry !="" && $industry > 0)|| ($sectorval !="--" && $sectorval !="" && $sectorval > 0)|| ($subsectorval !="--" && $subsectorval !="" && $subsectorval > 0) || ($round != "--") || ($city != "") || ($stageval!="") || ($yearafter!="") || ($yearbefore!="") || ($regionId!="--" && $regionId !="")|| ($invType!= "--" && $invType!= "") || ($startRangeValue!= "" && $endRangeValue != "") || $dateValue != "" || ($syndication !="--" && $syndication !="" && $syndication > 0)  || $cityid !="" ||  ( $tagsearch !='')|| $dealsinvolvingvalue !="" || $invType !='' || $investor_head!="")
                    {
    $yourquery = 1;
    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    
    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

        $hideWhere = "and pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

         $hideWhere = "and pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

       $hideWhere = "and pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

         $hideWhere = "and pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

    }else{
         $hideWhere = " ";
    }
    $regionId=explode(",",$regionId);
    $regionId=array_filter($regionId);
    if (count($regionId) > 0) {
        $increg = "JOIN region AS r ON r.RegionId=pec.RegionId";
    }
     
     if(count($sector) > 0 || count($subsector) > 0){
        /*$joinsectortable = 'JOIN pe_subsectors AS pe_sub ON pec.PEcompanyID=pe_sub.PECompanyID';*/
        $joinsectortable = 'JOIN pe_subsectors AS pe_sub ON pec.PEcompanyID=pe_sub.PECompanyID JOIN pe_sectors as pe_sec on pe_sec.sector_id = pe_sub.sector_id';
    } else {
        $joinsectortable = '';
    } 
    $companysql = "SELECT pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry,
                    pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%M-%Y') as dealperiod,
                    pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status,
                                        (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
                    (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount
                                                    FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
                                                    JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
                                                    JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                                                    JOIN industry AS i ON pec.industry = i.industryid
                                                    JOIN stage AS s ON s.StageId=pe.StageId $increg ".$joinsectortable. " WHERE " . $valuationsql . "";
    //    echo "<br> individual where clauses have to be merged ";


    if ($keyword != '') {
        $ex_tags = explode(',', $keyword);
        $invval= count($ex_tags)-1;
        
       if ($invandor == 0) {
            $query="select InvestorId,Investor from peinvestors where InvestorId IN(".$keyword.") order by InvestorId desc";
                                       // echo $query;
                                        $queryval=mysql_query($query);
                                       
                                         $invreg="REGEXP '";
                                        while($myrow=mysql_fetch_row($queryval))
                                        {

                                            if($myrow[1] == 'Others'){
                                                $others = 1;
                                                break;
                                            }else{
                                                $others = 0;
                                            }

                                            $invreg.= $myrow[1];
                                            $invreg.= ".*";
                                            
                                        }
                                        if($others == 1){
                                            $invreg.= "Others.*";
                                        }
                                        $invreg=trim($invreg,".*");
                                 $invreg.="'";
                                  
                                 $invregsubquery=" and (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) ".$invreg;
        }
        
        $combineSearchFlag = true;
        $whereinvestorsql = " peinv_inv.InvestorId IN($keyword)";

    }

    if ($companysearch != '') {
        $combineSearchFlag = true;
        $wherecompanysql = " pec.PECompanyId IN($companysearch)";
    }
  
    if ($sectorval != '') {
        $sectorvalarray=explode(",", $sectorval);
        foreach($sectorvalarray as $key=>$sectorvals)
            {
                $sectorsql123="select sector_name from pe_sectors where sector_id=".$sectorvals;
               
                $sectorquery=mysql_query($sectorsql123);
                if($row=mysql_fetch_row($sectorquery))
                {
                    $sector123.="'".$row[0]."'";
                    $sector123.=',';
                }
            }
            
           $sectorString= trim($sector123,",");
           if($sectorString!=""){
            $wheresectorsql = " pe_sec.sector_name IN($sectorString)";
           }
           //$wheresectorsql = " pe_sub.sector_id IN($sectorval)";
        }
    if ($subsectorval != '') {
                     $wheresubsectorsql = " pe_sub.subsector_name IN($subsectorval)";
    }
    $industry=array_filter($industry);
    if (count($industry) > 0) {
        $indusSql = '';
        foreach ($industry as $industrys) {
            $indusSql .= " pec.industry=$industrys or ";
        }
        $indusSql = trim($indusSql, ' or ');
        if ($indusSql != '') {
            $whereind = ' ( ' . $indusSql . ' ) ';
        }
        $qryIndTitle = "Industry - ";
    }
    $state=explode(",",$state);
    $state=array_filter($state);    
     if (count($state) > 0) {
                                    $stateSql = '';
                                    foreach ($state as $states) {
                                        $stateSql .= " pec.stateid=$states or ";
                                    }
                                    $stateSql = trim($stateSql, ' or ');
                                    if ($indusSql != '') {
                                        $wherestate = ' ( ' . $stateSql . ' ) ';
                                    }
                                    //$qryIndTitle = "Industry - ";
                                    
                                }
     if ($city != '--') {
        $citysql = "select city_id,city_name from city where city_id IN($city)";
        if ($citys = mysql_query($citysql)) {
             while ($myrow = mysql_fetch_array($citys, MYSQL_BOTH)) {
                $cityvalue .= $myrow["city_name"] . ',';
                $cityvalueid .= $myrow["city_id"] . ',';
             }
            }
                $cityvalue = trim($cityvalue, ',');
                $cityvalueid = trim($cityvalueid, ',');
      }
     
    //city multiselect
    $city=explode(",",$city);
    $city=array_filter($city);
    if (count($city) > 0) {
        $citySql = '';
        $cityarray = explode(",",$cityvalue);
        foreach ($cityarray as $cities) {
            $citySql .= " pec.city= '".$cities."' or ";
        }
        $citySql = trim($citySql, ' or ');
        if ($citySql != '') {
            $wherecity = ' ( ' . $citySql . ' ) ';
        }
    }
    
    $round=explode(",",$round);
    $round=array_filter($round);
    if (count($round) > 0) {
        $roundSql = '';
        foreach ($round as $rounds) {
            $roundSql .= " pe.round LIKE '" . $rounds . "' or  pe.round LIKE '" . $rounds . "%' or pe.round LIKE '%" . $rounds . "%' or";
        }
        if ($roundSql != '') {
            $whereRound = '(' . trim($roundSql, ' or ') . ')';
        }
    }
    if ($yearafter != '' && $yearbefore == '') {
        $whereyearaftersql = " pec.yearfounded >= $yearafter";
    }

    if ($yearbefore != '' && $yearafter == '') {
        $whereyearbeforesql = " pec.yearfounded <= $yearbefore";
    }

    if ($yearbefore != '' && $yearafter != '') {
        $whereyearfoundedesql = " pec.yearfounded >= $yearafter and pec.yearfounded <= $yearbefore";
    }
   
   
    if (count($regionId) > 0) {
        $region_Sql = '';
        foreach ($regionId as $regionIds) {
            $region_Sql .= " pec.RegionId  =$regionIds or ";
        }
        $regionSqlStr = trim($region_Sql, ' or ');
        $qryRegionTitle = "Region - ";
        if ($regionSqlStr != '') {
            $whereregion = '(' . $regionSqlStr . ')';
        }
    }
   
    if ($companyType != "--" && $companyType != "") {
        $wherelisting_status = " pe.listing_status='" . $companyType . "'";
    }
   
    if ($debt_equity != "--" && $debt_equity != "") { if ($debt_equity == 1) {$whereSPVdebt = " pe.SPV='" . $debt_equity . "'";
        $listallcompany = 1;} else { $whereSPVdebt = " pe.SPV='" . $debt_equity . "'";}}else{
            $isAggregate = $isAggregate;
        }

    if ($syndication != "--" && $syndication != "") {

        if ($syndication == 0) {
            $wheresyndication = " Having Investorcount > 1";
        } else {
            $wheresyndication = " Having Investorcount <= 1";
        }

    }
   
    if ($invType != "--" ) {
        $qryInvType = "Investor Type - ";
        $whereInvType = " pe.InvestorType = '" . $invType . "'";
    }
     if ($investor_head != "--" && $investor_head != '') {
           $whereInvhead = "inv.countryid = '" . $investor_head . "'";
    } 
    
    if ($stageval!="")
                            {
                                    $stagevalues="";
                                    $stageidvalues="";
                                    $stageval1 = explode(',',$stageval);
                                    if(count($stageval1) > 0){
                                        for($j=0;$j<count($stageval1);$j++)
                                    {
                                            $stage = $stageval1[$j];
                                            //echo "<br>****----" .$stage;
                                                $stagevalues .= " pe.StageId=" .$stage." or ";
                                            $stageidvalues=$stageidvalue.",".$stage;
                                    }
                                    }

                                    $wherestage = $stagevalues ;
                                    $qryDealTypeTitle="Stage  - ";
                                    $strlength=strlen($wherestage);
                                    $strlength=$strlength-3;
                            //echo "<Br>----------------" .$wherestage;
                            $wherestage= substr ($wherestage , 0,$strlength);
                            $wherestage ="(".$wherestage.")";
                            //echo "<br>---" .$stringto;

                            } 
    if (($startRangeValue != "--") && ($endRangeValue != "") && ($startRangeValue != "") && ($endRangeValue != "--")) {
        $startRangeValue = $startRangeValue;
       // $endRangeValue = $endRangeValue - 0.01;
        $qryRangeTitle = "Deal Range (M$) - ";
        if ($startRangeValue < $endRangeValue) {
           // $whererange = " pe.amount between  " . $startRangeValue . " and " . $endRangeValue;
           $whererange = " pe.amount >=  ".$startRangeValue ." and  pe.amount <". $endRangeValue ."";
        } elseif (($startRangeValue = $endRangeValue)) {
            $whererange = " pe.amount >= " . $startRangeValue;
        }
    } else if ($startRangeValue == "--" && $endRangeValue > 0) {
        $startRangeValue = 0;
     //   $endRangeValue = $endRangeValue - 0.01;
       // $whererange = " pe.amount between  " . $startRangeValue . " and " . $endRangeValue;
       $whererange = " pe.amount >=  ".$startRangeValue ." and  pe.amount <". $endRangeValue ."";
    }
    //echo "<Br>***".$whererange;
    $exitstatusValue=explode(",",$exitstatusValue);
    if ($exitstatusValue != '' && $exitstatusValue != '--' && count($exitstatusValue) > 0) {
        foreach ($exitstatusValue as $exitstatusValues) {
            if ($exitstatusValues != '--' && $exitstatusValues != '') {
                $exitstatusSql .= " Exit_Status  = '" . $exitstatusValues . "' or ";
            }
        }
        $whereexitstatus = trim($exitstatusSql, ' or ');
        if ($whereexitstatus != '') {
            $whereexitstatus = '(' . $whereexitstatus . ')';
        }
        $exitstatusValue_hide = implode($exitstatusValue, ',');
    }
    $dealsinvolvingvalue=explode(",",$dealsinvolvingvalue);
    if ($dealsinvolvingvalue != '' && $dealsinvolvingValue != '--' && count($dealsinvolvingvalue) > 0) {
        if(count($dealsinvolvingvalue)>1){
            if($dealsinvolvingValue == 1 && $dealsinvolvingValue == 2){
                $dealsinvolving .="peinv_inv.newinvestor = '1' or peinv_inv.existinvestor = '1'";
            }
        }else{
        foreach ($dealsinvolvingvalue as $dealsinvolvingValue) {
            if ($dealsinvolvingValue != '--' && $dealsinvolvingValue != '') {
                if($dealsinvolvingValue == 1)
                {
                    // $dealsinvolving .= "peinv_inv.newinvestor = '1' and NOT EXISTS(select 'x' from peinvestments_investors where peid= peinv_inv.peid and existinvestor = 1)
                    // and NOT EXISTS(select 'x' from peinvestments_investors where peid= peinv_inv.peid and newinvestor = 0) ";
                    $dealsinvolving .= "peinv_inv.newinvestor = '1' ";
                }
                if($dealsinvolvingValue == 2)
                {
                    $dealsinvolving .= "peinv_inv.existinvestor = '1' and NOT EXISTS(select 'x' from peinvestments_investors where peid= peinv_inv.peid and newinvestor = 1)
                    and NOT EXISTS(select 'x' from peinvestments_investors where peid= peinv_inv.peid and existinvestor = 0) ";
                }
                
                //$exitstatusSql .= " Exit_Status  = '" . $exitstatusValues . "' or ";
            }
        }
    }
        // $wheredealsinvolving = trim($dealsinvolving, ' or ');
        $wheredealsinvolving = trim($dealsinvolving);
        if ($wheredealsinvolving != '') {
            $wheredealsinvolving = '     (' . $wheredealsinvolving . ')';
        }
       // echo $wheredealsinvolving;
       
    }
    if (($month1 != "--") && ($year1 != "--") && ($month2 != "--") && ($year2 != "--")) {
        $qryDateTitle = "Period - ";
        $wheredates = " dates between '" . $dt1 . "' and '" . $dt2 . "'";

    }
    if ($whereind != "") {
        $companysql = $companysql . $whereind . " and ";
        $aggsql = $aggsql . $whereind . " and ";
        $bool = true;
    } else {
        $bool = false;
    }
    if (($whereregion != "")) {
        $companysql = $companysql . $whereregion . " and ";
        $aggsql = $aggsql . $whereregion . " and ";
        //    echo "<br>----comp sql after region-- " .$companysql;
        $bool = true;
    }
    if (($wherestage != "")) {
        //    echo "<BR>--STAGE" ;
        $companysql = $companysql . $wherestage . " and ";
        $aggsql = $aggsql . $wherestage . " and ";
        $bool = true;
        //    echo "<br>----comp sql after stage-- " .$companysql;

    }
    // moorthi
    if ($whereRound != "") {
        $companysql = $companysql . $whereRound . " and ";
    }
    if ($wherecity != "") {
        $companysql = $companysql . $wherecity . " and ";
        //$bool = true;
    } 
    // if ($whereCity != "") {
    //     $companysql = $companysql . $whereCity . " and ";
    // }
    if ($whereinvestorsql != "") {
        $companysql = $companysql . $whereinvestorsql . " and ";
    }
    if ($wherecompanysql != "") {
        $companysql = $companysql . $wherecompanysql . " and ";
    }
    if ($wheresectorsql != "") {
        $companysql = $companysql . $wheresectorsql . " and ";
    }
    if ($wheresubsectorsql != "") {
        $companysql = $companysql . $wheresubsectorsql . " and ";
    }
     if ($wherestate != "") {
                                    $companysql = $companysql . $wherestate . " and ";
                                    $aggsql = $aggsql . $wherestate . " and ";
                                    $bool = true;
                                } else {
                                    $bool = false;
                                }
                                
     if ($whereyearaftersql != "") {
                                    $companysql = $companysql . $whereyearaftersql . " and ";
                                }
                                if ($whereyearbeforesql != "") {
                                    $companysql = $companysql . $whereyearbeforesql . " and ";
                                }
                                if ($whereyearfoundedesql != "") {
                                    $companysql = $companysql . $whereyearfoundedesql . " and ";
                                }
    
    //
    if ($wherelisting_status != "") {
        $companysql = $companysql . $wherelisting_status . " and ";
    }
    if ($whereSPVdebt != "") {$companysql = $companysql . $whereSPVdebt . " and ";}
    if (($whereInvType != "")) {
        $companysql = $companysql . $whereInvType . " and ";
        $aggsql = $aggsql . $whereInvType . " and ";
        $bool = true;
    }
    if (($whereInvhead != "")) {
        $companysql = $companysql . $whereInvhead . " and ";
        $aggsql = $aggsql . $whereInvhead . " and ";
        $bool = true;
    }
    if (($whererange != "")) {
        $companysql = $companysql . $whererange . " and ";
        $aggsql = $aggsql . $whererange . " and ";
        $bool = true;
    }
    if (($wheredates !== "")) {
        $companysql = $companysql . $wheredates . " and ";
        $aggsql = $aggsql . $wheredates . " and ";
        $bool = true;
    }
    if ($whereexitstatus != "") {

        $companysql = $companysql . $whereexitstatus . " and ";
        $aggsql = $aggsql . $whereexitstatus . " and ";
        $bool = true;

    }
    if ($wheredealsinvolving != "") {

        $companysql = $companysql . $wheredealsinvolving . " and ";
        $aggsql = $aggsql . $wheredealsinvolving . " and ";
        $bool = true;

    }
    if (($whereregion != "")) {
        $incconreg = "and  r.RegionId=pec.RegionId";

    }
    
    //the foll if was previously checked for range
    if ($whererange != "") {
        
     
        $companysql = $companysql . " pe.Deleted=0 " . $addVCFlagqry . " " . $addDelind .$hideWhere. "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where $invregsubquery $isAggregate GROUP BY pe.PEId";
        $orderby = "dates";
        $ordertype = "desc";

//                        echo "<br>----" .$whererange;
    } elseif ($whererange == "--" || $whererange == "") {
       
       
        $companysql = $companysql . " pe.Deleted=0 " . $addVCFlagqry . " " . $addDelind .$hideWhere. "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where $invregsubquery $isAggregate GROUP BY pe.PEId";
        $orderby = "dates";
        $ordertype = "desc";
    }
    
    if ($wheresyndication != '') {

        $companysql = $companysql . $wheresyndication;
    }
    
    $popup_search = 1;
    
} else {
    echo "<br> INVALID DATES GIVEN ";
    $fetchRecords = false;
}

if ($companysql != "" && $orderby != "" && $ordertype != "") {

    $companysql = $companysql . " order by  dates desc,companyname asc ";
    $exportSplitOrderBy = " order by  dates desc,companyname asc";
}





//echo $companysql;exit();
//execute query
$result = mysql_query($companysql) or die(mysql_error());

// Start T960
$exportvalue=$_POST['resultarray'];
if($exportvalue == "Select-All"){
    $exportvalue = "Company,Company Type,Industry,Sector,Amount(US".'$M'."),Amount(INR Cr),Round,Stage,Investors,Investor Type,Stake (%),Date,Exit Status,Website,Year Founded,City,State,Region,Advisor-Company,Advisor-Investors,More Details,Link,Pre Money Valuation (INR Cr),Revenue Multiple (Pre),EBITDA Multiple (Pre),PAT Multiple (Pre),Post Money Valuation (INR Cr),Revenue Multiple (Post),EBITDA Multiple (Post),PAT Multiple (Post),Enterprise Valuation (INR Cr),Revenue Multiple (EV),EBITDA Multiple (EV),PAT Multiple (EV),Price to Book,Valuation,Revenue (INR Cr),EBITDA (INR Cr),PAT (INR Cr),Total Debt (INR Cr),Cash & Cash Equ. (INR Cr),Book Value Per Share,Price Per Share,Link for Financials";    
}
$expval=explode(",",$exportvalue);

// end T960


updateDownload($result);


$searchString = "Undisclosed";
$searchString = strtolower($searchString);
$searchStringDisplay = "Undisclosed";

$searchString1 = "Unknown";
$searchString1 = strtolower($searchString1);

$searchString2 = "Others";
$searchString2 = strtolower($searchString2);

$dbTypeSV='PE';

$tsjtitle = "© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
$tranchedisplay = "Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE. Target Company in [] indicated a debt investment. Not included in aggregate data.";

$replace_array = array('\t','\n','<br>','<br/>','<br />','\r','\v');
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
/** Include PHPExcel */
require_once '../PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
// Add some data
$rowArray = $expval;
$objPHPExcel->getActiveSheet()
    ->fromArray(
        $rowArray,   // The data to set
        NULL,        // Array values with this value will not be set
        'A1'         // Top left coordinate of the worksheet range where
                     //    we want to set these values (default is A1)
    );
// $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A1', 'Company')
//             ->setCellValue('B1', 'Company Type')
//             ->setCellValue('C1', 'Industry')
//             ->setCellValue('D1', 'Sector')
//             ->setCellValue('E1', 'Amount(US$M)')
//             ->setCellValue('F1', 'Amount(INR Cr)')
//             ->setCellValue('G1', 'Round')
//             ->setCellValue('H1', 'Stage')
//             ->setCellValue('I1', 'Investors')
//             ->setCellValue('J1', 'Investor Type')
//             ->setCellValue('K1', 'Stake (%)')
//             ->setCellValue('L1', 'Date')
//             ->setCellValue('M1', 'Exit Status')
//             ->setCellValue('N1', 'Website')
//             ->setCellValue('O1', 'Year Founded')
//             ->setCellValue('P1', 'City')
//             ->setCellValue('Q1', 'State')
//             ->setCellValue('R1', 'Region')
//             ->setCellValue('S1', 'Advisor-Company')
//             ->setCellValue('T1', 'Advisor-Investors')
//             ->setCellValue('U1', 'More Details')
//             ->setCellValue('V1', 'Link')
//             ->setCellValue('W1', 'Pre Money Valuation (INR Cr)')
//             ->setCellValue('X1', 'Revenue Multiple')
//             ->setCellValue('Y1', 'EBITDA Multiple')
//             ->setCellValue('Z1', 'PAT Multiple')
//             ->setCellValue('AA1', 'Post Money Valuation (INR Cr)')
//             ->setCellValue('AB1', 'Revenue Multiple')
//             ->setCellValue('AC1', 'EBITDA Multiple')
//             ->setCellValue('AD1', 'PAT Multiple')
//             ->setCellValue('AE1', 'Enterprise Valuation (INR Cr)')
//             ->setCellValue('AF1', 'Revenue Multiple')
//             ->setCellValue('AG1', 'EBITDA Multiple')
//             ->setCellValue('AH1', 'PAT Multiple')
//             ->setCellValue('AI1', 'Price to Book')
//             ->setCellValue('AJ1', 'Valuation')
//             ->setCellValue('AK1', 'Revenue (INR Cr)')
//             ->setCellValue('AL1', 'EBITDA (INR Cr)')
//             ->setCellValue('AM1', 'PAT (INR Cr)')
//             ->setCellValue('AN1', 'Total Debt (INR Cr)')
//             ->setCellValue('AO1', 'Cash & Cash Equ. (INR Cr)')
//             ->setCellValue('AP1', 'Book Value Per Share')
//             ->setCellValue('AQ1', 'Price Per Share')
//             ->setCellValue('AR1', 'Link for Financials');

$index = 2;

$peidcheck = '';

$arrayData = array();
while ($rows = mysql_fetch_array($result)) {
$DataList = array();
$col = 0;  

    if(isset($rows['PEId'])){
        $PEId = $rows['PEId'];
    }else{
        $PEId = $rows[13];
    }
    
    $companiessql = "select pe.PEId,pe.PEId, pe.PEId, pe.PECompanyID, pe.StageId, pec.countryid, pec.industry, pec.companyname, i.industry,pec.sector_business,amount,round,s.stage, it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%M-%Y') as dealperiod, pec.website,pec.city,r.Region, MoreInfor,hideamount,hidestake,c.country,c.country, Link,pec.RegionId,Valuation,FinLink, Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple, listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded,pec.state from peinvestments as pe
            LEFT JOIN pecompanies as pec
            ON pec.PEcompanyID = pe.PECompanyID
            LEFT JOIN industry as i
            ON pec.industry = i.industryid
            LEFT JOIN stage as s
            ON pe.StageId=s.StageId
            LEFT JOIN country as c
            ON c.countryid=pec.countryid
            LEFT JOIN region as r
            ON r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1)
            LEFT JOIN investortype as it ON it.InvestorType = pe.InvestorType 
            where pe.Deleted=0 and pec.industry !=15 and pe.PEId=".$PEId." AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = '$dbTypeSV' AND hide_pevc_flag =1 ) order by companyname";
    
    $result2 = mysql_query($companiessql) or die( mysql_error() );
    $row = mysql_fetch_row($result2);
    
    if ($row[35] == 1) {     //Agghide
        //echo "<br>***".$row[7];
        $openBracket = "(";
        $closeBracket = ")";
        $amtTobeDeductedforAggHide = $row[10];
    } else {
        $openBracket = "";
        $closeBracket = "";
        $amtTobeDeductedforAggHide = 0;
    }
    if ($row[34] == 1) {          //Debt
        $openDebtBracket = "[";
        $closeDebtBracket = "]";
        $amtTobeDeductedforDebt = $row[10];
        $amtTobeDeductedforAggHide = $row[10];
        $NoofDealsCntTobeDeductedDebt = 1;
    } else {
        $openDebtBracket = "";
        $closeDebtBracket = "";
        $amtTobeDeductedforDebt = 0;
        $NoofDealsCntTobeDeductedDebt = 0;
    }
    if ($row[35] == 1 || $row[34] == 1) {
        $NoofDealsCntTobeDeducted = 1;        
    }else{
        $NoofDealsCntTobeDeducted = 0;        
    }

    $schema_insert = "";
    $PEId = $row[0];
    $companyName = $row[7];
    $companyName = strtolower($companyName);
    $compResult = substr_count($companyName, $searchString);

    if ($row[32] == "L")
        $listing_status_display = "Listed";
    elseif ($row[32] == "U")
        $listing_status_display = "Unlisted";

    //echo $compResult;
    if ($compResult == 0) {
        //echo "<BR>--- ".$openBracket;
        $companyName = $openDebtBracket . $openBracket . $row[7] . $closeBracket . $closeDebtBracket;
        $webdisplay = $row[16];
    } else {
        $companyName = $searchStringDisplay;
        $webdisplay = "";
    }

    if( !empty( $row[51] ) ) {
        $Total_Debt = $row[51];
    } else {
        $Total_Debt = '';
    }

    if( !empty( $row[52] ) ) {
        $Cash_Equ = $row[52];
    } else {
        $Cash_Equ = '';
    }
    if( !empty( $row[53] ) ) {
        $yearfounded = $row[53];
    } else {
        $yearfounded = '';
    }
    $hideamount_INR="";
    if($row[20]==1){
            $hideamount="";
    }else{
            $hideamount=$row[10];
            if($row[42] != 0.00){
                $hideamount_INR=$row[42];
            }
    }

    if ($row[21] == 1 || ($row[14] <= 0))
        $hidestake = "";
    else
        $hidestake = $row[14];

    $exitstatusis = '';
    $exitstatusSql = "select id,status from exit_status where id=$row[33]";
    if ($exitstatusrs = mysql_query($exitstatusSql)) {
        $exitstatus_cnt = mysql_num_rows($exitstatusrs);
    }
    if ($exitstatus_cnt > 0) {
        While ($myrow = mysql_fetch_array($exitstatusrs, MYSQL_BOTH)) {
            $exitstatusis = $myrow[1];
        }
    } else {
        $exitstatusis = 'Unexited';
    }

    if($keyword!=''){
        // $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
        // peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY inv.InvestorId desc "; //commented in bug 919
        $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
		peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',inv.InvestorId IN ($keyword) desc ";

    }
    else{
       $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
        peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',inv.InvestorId desc ";
    }
    
    $advcompanysql = "select advcomp.PEId,advcomp.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$PEId and advcomp.CIAId=cia.CIAId";

    $advinvestorssql = "select advinv.PEId,advinv.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorinvestors as advinv,
	advisor_cias as cia where advinv.PEId=$PEId and advinv.CIAId=cia.CIAId";

    if ($investorrs = mysql_query($investorSql) or die(mysql_error())) {

        $investorString = "";
        $AddOtherAtLast = "";
        $AddUnknowUndisclosedAtLast = "";
      
        $invcount =1;$firstinv='';
        
        if($peidcheck == $PEId){
            
            $whilecount =0;
            while ($rowInvestor = mysql_fetch_array($investorrs))
            {
                if($whilecount==$invcount){
                    
                    $firstinv= $rowInvestor[2];
                }
                else{
                    
                    $Investorname = $rowInvestor[2];
                    $Investorname = strtolower($Investorname);

                    $invResult = substr_count($Investorname, $searchString);
                    $invResult1 = substr_count($Investorname, $searchString1);

                    if (($invResult == 0) && ($invResult1 == 0))
                        $investorString = $investorString . ", " . $rowInvestor[2];
                    elseif (($invResult == 1) || ($invResult1 == 1))
                        $AddUnknowUndisclosedAtLast = $rowInvestor[2];
                    elseif ($invResult2 == 1)
                        $AddOtherAtLast = $rowInvestor[2];
                }
                
                $whilecount++;
            }
            
            $investorString = $firstinv.$investorString;
            $invcount++;
        }else{
            
            while ($rowInvestor = mysql_fetch_array($investorrs))
            {
                
                $Investorname = $rowInvestor[2];
                $Investorname = strtolower($Investorname);

                $invResult = substr_count($Investorname, $searchString);
                $invResult1 = substr_count($Investorname, $searchString1);
                //$invResult2 = substr_count($Investorname, $searchString2);

                if (($invResult == 0) && ($invResult1 == 0))
                    $investorString = $investorString . ", " . $rowInvestor[2];
                elseif (($invResult == 1) || ($invResult1 == 1))
                    $AddUnknowUndisclosedAtLast = $rowInvestor[2];
                elseif ($invResult2 == 1)
                    $AddOtherAtLast = $rowInvestor[2];
            }
            if ($AddUnknowUndisclosedAtLast !== "")
            $investorString = $investorString . ", " . $AddUnknowUndisclosedAtLast;
            if ($AddOtherAtLast != "")
                $investorString = $investorString . ", " . $AddOtherAtLast;

            $investorString = substr_replace($investorString, '', 0, 2);
            $peidcheck = $PEId;
            $invcount=1;
        }

    }

    if ($advisorcompanyrs = mysql_query($advcompanysql)) {
        $advisorCompanyString = "";
        while ($row1 = mysql_fetch_array($advisorcompanyrs)) {
            $advisorCompanyString = $advisorCompanyString . "," . $row1[2] . "(" . $row1[3] . ")";
        }
        $advisorCompanyString = substr_replace($advisorCompanyString, '', 0, 1);
    }

    if ($advisorinvestorrs = mysql_query($advinvestorssql)) {
        $advisorInvestorString = "";
        while ($row2 = mysql_fetch_array($advisorinvestorrs)) {
            $advisorInvestorString = $advisorInvestorString . "," . $row2[2] . "(" . $row2[3] . ")";
        }
        $advisorInvestorString = substr_replace($advisorInvestorString, '', 0, 1);
    }
    
    $resmoreinfo = preg_replace("/\r\n|\r|\n/",'<br/>',$row[19]);
    $resmoreinfo =  str_replace($replace_array, ' ', $resmoreinfo);
    $resmoreinfo = trim($resmoreinfo);//BusinessDesc
    $resmoreinfo = preg_replace('/(\v|\s)+/', ' ', $resmoreinfo);//more details

    $pre_company_valuation = $row[43];
    if ($pre_company_valuation <= 0)
        $pre_company_valuation = "";

    $pre_revenue_multiple = $row[44];
    if ($pre_revenue_multiple <= 0)
        $pre_revenue_multiple = "";

    $pre_ebitda_multiple = $row[45];
    if ($pre_ebitda_multiple <= 0)
        $pre_ebitda_multiple = "";

    $pre_pat_multiple = $row[46];
    if ($pre_pat_multiple <= 0)
        $pre_pat_multiple = "";

    $dec_company_valuation = $row[28];
    if ($dec_company_valuation <= 0)
        $dec_company_valuation = "";

    $dec_revenue_multiple = $row[29];
    if ($dec_revenue_multiple <= 0)
        $dec_revenue_multiple = "";

    $dec_ebitda_multiple = $row[30];
    if ($dec_ebitda_multiple <= 0)
        $dec_ebitda_multiple = "";

    $dec_pat_multiple = $row[31];
    if ($dec_pat_multiple <= 0)
        $dec_pat_multiple = "";

    $ev_company_valuation = $row[47];
    if ($ev_company_valuation <= 0)
        $ev_company_valuation = "";

    $ev_revenue_multiple = $row[48];
    if ($ev_revenue_multiple <= 0)
        $ev_revenue_multiple = "";

    $ev_ebitda_multiple = $row[49];
    if ($ev_ebitda_multiple <= 0)
        $ev_ebitda_multiple = "";

    $ev_pat_multiple = $row[50];
    if ($ev_pat_multiple <= 0)
        $ev_pat_multiple = "";

    $price_to_book=$row[39]; 
        if($price_to_book<=0)
        $price_to_book="";
         
    $book_value_per_share=$row[40]; 
        if($book_value_per_share<=0)
        $book_value_per_share="";

    $price_per_share=$row[41]; 
        if($price_per_share<=0)
        $price_per_share="";

    $dec_revenue=$row[36];
    if($dec_revenue < 0 || $dec_revenue > 0){
        $dec_revenue = $dec_revenue;  //Revenue 
    }else{
        if ($dec_company_valuation > 0 && $dec_revenue_multiple > 0) {

            $dec_revenue = number_format($dec_company_valuation / $dec_revenue_multiple, 2, '.', '');
        } else {
            $dec_revenue = '';
        }
    }

    $dec_ebitda = $row[37];
    if ($dec_ebitda < 0 || $dec_ebitda > 0) {
        $dec_ebitda = $dec_ebitda;  //EBITDA 
    }else{
        if ($dec_company_valuation > 0 && $dec_ebitda_multiple > 0) {

            $dec_ebitda = number_format($dec_company_valuation / $dec_ebitda_multiple, 2, '.', '');
        } else {
            $dec_ebitda = '';
        }
    }

    $dec_pat = $row[38];
    if ($dec_pat < 0 || $dec_pat > 0) {
        $dec_pat = $dec_pat;  //PAT 
    }else{
        if ($dec_company_valuation > 0 && $dec_pat_multiple > 0) {

            $dec_pat = number_format($dec_company_valuation / $dec_pat_multiple, 2, '.', '');
        } else {
            $dec_pat = '';
        }
    }


    // T960
    if(in_array("Company", $rowArray))
    {
        $DataList[] = $companyName;
    }
    if(in_array("Company Type", $rowArray))
    {
        $DataList[] = $listing_status_display;
    }
    if(in_array("Industry", $rowArray))
    {
        $DataList[] = $row[8];
    }
    if(in_array("Sector", $rowArray))
    {
        $DataList[] = $row[9];
    }
    if(in_array("Amount(US".'$M'.")", $rowArray))
    {
        $DataList[] = $hideamount;
    }
    if(in_array("Amount(INR Cr)", $rowArray))
    {
        $DataList[] = $hideamount_INR;
    }
    if(in_array("Round", $rowArray))
    {
        $DataList[] = $row[11];
    }
    if(in_array("Stage", $rowArray))
    {
        $DataList[] = $row[12];
    }
    if(in_array("Investors", $rowArray))
    {
        $DataList[] = $investorString;
    }
    if(in_array("Investor Type", $rowArray))
    {
        $DataList[] = $row[13];
    }
    if(in_array("Stake (%)", $rowArray))
    {
        $DataList[] = $hidestake;
    }
    if(in_array("Date", $rowArray))
    {
        $DataList[] = $row[15];
    }
    if(in_array("Exit Status", $rowArray))
    {
        $DataList[] = $exitstatusis;
    }
    if(in_array("Website", $rowArray))
    {
        $DataList[] = $webdisplay;
    }
    if(in_array("Year Founded", $rowArray))
    {
        $DataList[] = $yearfounded;
    }
    if(in_array("City", $rowArray))
    {
        $DataList[] = $row[17];
    }
    if(in_array("State", $rowArray))
    {
        $DataList[] = $row[54];
    }
    if(in_array("Region", $rowArray))
    {
        $DataList[] = $row[18];
    }
    if(in_array("Advisor-Company", $rowArray))
    {
        $DataList[] = $advisorCompanyString;
    }
    if(in_array("Advisor-Investors", $rowArray))
    {
        $DataList[] = $advisorInvestorString;
    }
    if(in_array("More Details", $rowArray))
    {
        $DataList[] = $resmoreinfo;
    }
    if(in_array("Link", $rowArray))
    {
        $DataList[] = trim($row[24]);
    }
    if(in_array("Pre Money Valuation (INR Cr)", $rowArray))
    {
        $DataList[] = $pre_company_valuation;
    }
    if(in_array("Revenue Multiple (Pre)", $rowArray))
    {
        $DataList[] = $pre_revenue_multiple;
    }
    if(in_array("EBITDA Multiple (Pre)", $rowArray))
    {
        $DataList[] = $pre_ebitda_multiple;
    }
    if(in_array("PAT Multiple (Pre)", $rowArray))
    {
        $DataList[] = $pre_pat_multiple;
    }
    if(in_array("Post Money Valuation (INR Cr)", $rowArray))
    {
        $DataList[] = $dec_company_valuation;
    }
    if(in_array("Revenue Multiple (Post)", $rowArray))
    {
        $DataList[]= $dec_revenue_multiple;
    }
    if(in_array("EBITDA Multiple (Post)", $rowArray))
    {
        $DataList[]= $dec_ebitda_multiple;
    }
    if(in_array("PAT Multiple (Post)", $rowArray))
    {
        $DataList[] = $dec_pat_multiple;
    }
    if(in_array("Enterprise Valuation (INR Cr)", $rowArray))
    {
        $DataList[]= $ev_company_valuation;
    }
    if(in_array("Revenue Multiple (EV)", $rowArray))
    {
        $DataList[]= $ev_revenue_multiple;
    }
    if(in_array("EBITDA Multiple (EV)", $rowArray))
    {
        $DataList[]= $ev_ebitda_multiple;
    }
    if(in_array("PAT Multiple (EV)", $rowArray))
    {
        $DataList[]= $ev_pat_multiple;
    }
    if(in_array("Price to Book", $rowArray))
    {
        $DataList[] = $price_to_book;
    }
    if(in_array("Valuation", $rowArray))
    {
        $DataList[]= trim($row[26]);
    }
    if(in_array("Revenue (INR Cr)", $rowArray))
    {
        $DataList[]= $dec_revenue;
    }
    if(in_array("EBITDA (INR Cr)", $rowArray))
    {
        $DataList[] = $dec_ebitda;
    }
    if(in_array("PAT (INR Cr)", $rowArray))
    {
        $DataList[]= $dec_pat;
    }
    if(in_array("Total Debt (INR Cr)", $rowArray))
    {
        $DataList[]= $Total_Debt;
    }
    if(in_array("Cash & Cash Equ. (INR Cr)", $rowArray))
    {
        $DataList[]= $Cash_Equ;
    }
    if(in_array("Book Value Per Share", $rowArray))
    {
        $DataList[]= $book_value_per_share;
    }
    if(in_array("Price Per Share", $rowArray))
    {
        $DataList[]= $price_per_share;
    }
    if(in_array("Link for Financials", $rowArray))
    {
        $DataList[]= $row[27];
    }
    
    $arrayData[] = $DataList;

     //Setting Values
    //  $objPHPExcel->setActiveSheetIndex(0)
    //         ->setCellValue('A'.$index, $companyName)
    //         ->setCellValue('B'.$index, $listing_status_display)
    //         ->setCellValue('C'.$index, $row[8])
    //         ->setCellValue('D'.$index, $row[9])
    //         ->setCellValue('E'.$index, $hideamount)
    //         ->setCellValue('F'.$index, $hideamount_INR)
    //         ->setCellValue('G'.$index, $row[11])
    //         ->setCellValue('H'.$index, $row[12])
    //         ->setCellValue('I'.$index, $investorString)
    //         ->setCellValue('J'.$index, $row[13])
    //         ->setCellValue('K'.$index, $hidestake)
    //         ->setCellValue('L'.$index, $row[15])
    //         ->setCellValue('M'.$index, $exitstatusis)
    //         ->setCellValue('N'.$index, $webdisplay)
    //         ->setCellValue('O'.$index, $yearfounded)
    //         ->setCellValue('P'.$index, $row[17])
    //         ->setCellValue('Q'.$index, $row[54])
    //         ->setCellValue('R'.$index, $row[18])
    //         ->setCellValue('S'.$index, $advisorCompanyString)
    //         ->setCellValue('T'.$index, $advisorInvestorString)
    //         ->setCellValue('U'.$index, $resmoreinfo)
    //         ->setCellValue('V'.$index, trim($row[24]))
    //         ->setCellValue('W'.$index, $pre_company_valuation)
    //         ->setCellValue('X'.$index, $pre_revenue_multiple)
    //         ->setCellValue('Y'.$index, $pre_ebitda_multiple)
    //         ->setCellValue('Z'.$index, $pre_pat_multiple)
    //         ->setCellValue('AA'.$index, $dec_company_valuation)
    //         ->setCellValue('AB'.$index, $dec_revenue_multiple)
    //         ->setCellValue('AC'.$index, $dec_ebitda_multiple)
    //         ->setCellValue('AD'.$index, $dec_pat_multiple)
    //         ->setCellValue('AE'.$index, $ev_company_valuation)
    //         ->setCellValue('AF'.$index, $ev_revenue_multiple)
    //         ->setCellValue('AG'.$index, $ev_ebitda_multiple)
    //         ->setCellValue('AH'.$index, $ev_pat_multiple)
    //         ->setCellValue('AI'.$index, $price_to_book)
    //         ->setCellValue('AJ'.$index, trim($row[26]))
    //         ->setCellValue('AK'.$index, $dec_revenue)
    //         ->setCellValue('AL'.$index, $dec_ebitda)
    //         ->setCellValue('AM'.$index, $dec_pat)
    //         ->setCellValue('AN'.$index, $Total_Debt)
    //         ->setCellValue('AO'.$index, $Cash_Equ)
    //         ->setCellValue('AP'.$index, $book_value_per_share)
    //         ->setCellValue('AQ'.$index, $price_per_share)
    //         ->setCellValue('AR'.$index, $row[27]);
     $index++;
}

// T960
$objPHPExcel->getActiveSheet()
            ->fromArray(
                $arrayData,  // The data to set
                NULL,        // Array values with this value will not be set
                'A2'         // Top left coordinate of the worksheet range where
                            //    we want to set these values (default is A1)
            );


$indexfortitle = $index + 5;
$indexfortranche = $index + 7;

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$indexfortitle, $tsjtitle)
            ->setCellValue('A'.$indexfortranche, $tranchedisplay);

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');

// $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()
//     ->setWidth(12);
// T960 Changes
// $objPHPExcel->getActiveSheet()
//     ->getStyle('G2:G'.$index)
//     ->getAlignment()
//     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

// $objPHPExcel->getActiveSheet()
//     ->getStyle('L2:L'.$index)
//     ->getAlignment()
//     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// T960 Changes
$objPHPExcel->getActiveSheet()
    ->getStyle('A2:A2')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="peinv_deals.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit();
        }
//		}
//else
//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;
mysql_close();
mysql_close($cnx);
?>


	