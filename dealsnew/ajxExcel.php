<?php

error_reporting(E_ALL);
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
require_once 'Classes/PHPExcel.php';
$count = 0;
//$sql = $_POST['exporttablesql'];
// $sql = stripcslashes($sql);
//echo $sql;
if(!isset($_SESSION['UserNames']))
   {
           header('Location:../pelogin.php');
   }
   else
   {
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
    $sql=$companysql;
$sql = stripcslashes($sql);

if ($sql != '') {

    $res = @mysql_query($sql) or die(mysql_error());
    $data = array();
    while ($row = @mysql_fetch_assoc($res)) {

        foreach ($row as $col => $val) {
            $data[$count][] = $val;
        }
        $count++;
    }
    echo '<pre>';
    //print_r($data);

    $dataArray = array();
    $arrhead = array();
    for ($i = 0; $i < count($data); $i++) {

        if (!in_array($data[$i][0], $arrhead)) {

            $arrhead[] = $data[$i][0];
        }
    }
    //print_r($arrhead);
    //Get Years
    $Years = array();

    for ($i = 0; $i < count($data); $i++) {

        if (!in_array($data[$i][1], $Years)) {

            $Years[] = $data[$i][1];
        }
    }

    //print_r($Years);

    for ($i = 0; $i < count($arrhead); $i++) {

        $tempArr = array();
        for ($j = 0; $j < count($data); $j++) {

            $values = array();
            if ($data[$j][0] == $arrhead[$i]) {

                if ($data[$j][2]) {
                    $values[] = $data[$j][2];
                } else {
                    $values[] = 0;
                }

                if ($data[$j][3]) {

                    $values[] = $data[$j][3];
                } else {
                    $values[] = 0;
                }

                $tempArr[$data[$j][1]] = $values;
            }
        }

        $dataArray[$arrhead[$i]] = $tempArr;
    }

    //print_r($dataArray);
    $column = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH');
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

    $objPHPExcel->getActiveSheet()->setTitle('PE_by_Industry');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'INDUSTRY');
    $objPHPExcel->getActiveSheet()->setCellValue('A2', '');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A1')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    $letters = 1;
    for ($i = 0; $i < count($Years); $i++) {
        //echo "'".$column[$letters].($i+1).":".$column[$letters+1].($i+1)."'";
        //$objPHPExcel->getActiveSheet()->mergeCells("'".$column[$letters].($i+1).":".$column[$letters+1].($i+1)."'");
        $objPHPExcel->getActiveSheet()->setCellValue($column[$letters] . '1', $Years[$i]);
        $objPHPExcel->getActiveSheet()->getStyle($column[$letters] . '1')->getFont()->setBold(true);
        //$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
        $objPHPExcel->getActiveSheet()->mergeCells($column[$letters] . '1' . ":" . $column[$letters + 1] . '1');
        $objPHPExcel->getActiveSheet()->getStyle($column[$letters] . '1' . ":" . $column[$letters + 1] . '1')->getAlignment()->setHorizontal('center');

        $objPHPExcel->getActiveSheet()->setCellValue($column[$letters] . '2', 'Deal');
        $objPHPExcel->getActiveSheet()->setCellValue($column[$letters + 1] . '2', 'Amount');

        $letters+=2;
    }

    //$val = array();
    $ind = 3;
    $dealcount = 3;
    for ($i = 0; $i < count($arrhead); $i++) {

        $letters = 1;
        $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + $ind), $arrhead[$i]);

        for ($j = 0; $j < count($Years); $j++) {
            $deal = '';
            $amt = '';
            $val = $dataArray[$arrhead[$i]][$Years[$j]];

            if ($val) {
                $deal = $val[0];
                $amt = $val[1];
            }

            $objPHPExcel->getActiveSheet()->setCellValue($column[$letters] . $dealcount, $deal);

            $objPHPExcel->getActiveSheet()->setCellValue($column[$letters + 1] . $dealcount, $amt);


            $letters+=2;
        }
        $dealcount++;
        //$letters+=1;
    }
	

	mysql_close();
    mysql_close($cnx);
						

    ob_end_clean();
    // Redirect output to a client’s web browser (Excel5)
    $filename = 'consumption_sans_report.xls'; //save our workbook as this file name
    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
    exit;
}
   }
?>