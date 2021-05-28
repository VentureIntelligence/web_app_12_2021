<?php
require_once("../dbconnectvi.php");

$Db    = new dbInvestments();
$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

$strvalue = explode("/", $value);
//print_r($strvalue);
if (sizeof($strvalue) > 1) {
    $vcflagValue = $strvalue[1];
    $VCFlagValue = $strvalue[1];
} else {
    $vcflagValue = 0;
    $VCFlagValue = 0;
}

if ($vcflagValue == 0)
    $videalPageName = "PEDir";
if ($vcflagValue == 1)
    $videalPageName = "VCDir";

include('checklogin.php');
$lgDealCompId = $_SESSION['DcompanyId'];
$usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
$usrRgres = mysql_query($usrRgsql) or die(mysql_error());
$usrRgs = mysql_fetch_array($usrRgres);

/* CODE FOR FILTER : START */
$dealvalue  = $strvalue[2];
$resetfield = $_POST['resetfield'];

if($_POST['autocomplete'] != "" || $_POST['industry'] != "" || $_POST['invType'] != "" || $_POST['stage'] != "" || $_POST['round'] != "" || $_POST['invrangestart'] != "" || $_POST['invrangeend'] != "" || $_POST['firmtype'] != "" || $_POST['citysearch'] != "" || $_POST['country'] != "" || $_POST['city'] != "" || $_POST['countryNIN'] != ""){

        $_POST['searchallfield']="";
        $_POST['searchKeywordLeft']="";
        $_POST['searchTagsField']="";
        $searchallfield="";
}
if($resetfield=="keywordsearchdir")
        { 
        $_POST['keywordsearchdir']="";
        $keyworddir="";
        }
        else 
        {
            $keyworddir=trim($_POST['keywordsearchdir']);
        }
if ($resetfield == "tagsearch") {

    $_POST['tagsearch'] = "";
    $_POST['tagsearch_auto'] = "";
    $tagsearch = "";
    $tagandor = 0;

} else if ($_POST['tagsearch_auto'] && $_POST['tagsearch_auto'] != '' || $_POST['tagsearch'] != '') {

    //$tagsearchauto = $_POST['tagsearch'];
    if ($_POST['tagsearch'] != '') {
        if ($_POST['tagsearch_auto'] == '') {
            $tagsearch = $_POST['tagsearch'];
        } else {
            if ($_POST['tagsearch'] != $_POST['tagsearch_auto']) {
                $tagsearch = $_POST['tagsearch'] . "," . $_POST['tagsearch_auto'];
            } else {
                $tagsearch = $_POST['tagsearch'];
            }
        }

    } else {
        $tagsearch = $_POST['tagsearch_auto'];
    }
 $tagsearcharray = explode(',', $tagsearch);
    $response = array();
    $tag_filter = "";
    $i = 0;

    foreach ($tagsearcharray as $tagsearchnames) {
        $response[$i]['name'] = $tagsearchnames;
        $response[$i]['id'] = $tagsearchnames;
        $i++;
    }

    if ($response != '') {
        $tag_response = json_encode($response);
    } else {
        $tag_response = 'null';
    }
} 


if ($resetfield == "keywordsearch") {
    $_POST['keywordsearch'] = "";
    $keyword                = "";
} else {
    $keyword = trim($_POST['keywordsearch']);
}

if ($resetfield == "industry") {
    $_POST['industry'] = "";
    $industry          = "";
} else {
    $industry = trim($_POST['industry']);
}

if ($resetfield == "stage") {
    $_POST['stage'] = "";
    $stageval       = "";
} else {
    $stageval = $_POST['stage'];
}

if ($_POST['stage'] && $stageval != "") {
    $boolStage = true;
    //foreach($stageval as $stage)
    //  echo "<br>----" .$stage;
} else {
    $stage     = "--";
    $boolStage = false;
}
if ($resetfield == "round") {
    $_POST['round'] = "";
    $round          = "--";
} else {
    $round = trim($_POST['round']);
    if ($round != '--') {
        $searchallfield = '';
    }
}
if ($resetfield == "invType") {
    $_POST['invType'] = "";
    $investorType     = "";
} else {
    $investorType = trim($_POST['invType']);
}
if ($resetfield == "firmtype") {
    $_POST['firmtype'] = "";
    $firmtypetxt       = "";
} else {
    $firmtypetxt = trim($_POST['firmtype']);
}
// For Country 
if ($resetfield == "country") {
    $_POST['country']    = "";
    $countrytxt          = "";
    $_POST['city']       = "";
    $cityname            = "";
    $_POST['countryNIN'] = "";
    $countryNINtxt       = "";
} else {
    $countrytxt = $_POST['country'];
}

// For City 
if ($resetfield == "city") {
    $_POST['city'] = "";
    $cityid        = "";
} else {
    $cityid = $_POST['city'];
}

// For countryNIN 
if ($resetfield == "countryNIN") {
    $_POST['countryNIN'] = "";
    $countryNINtxt       = "";
} else {
    $countryNINtxt = $_POST['countryNIN'];
}
if ($resetfield == "range") {
    $_POST['invrangestart'] = "";
    $_POST['invrangeend']   = "";
    $startRangeValue        = "--";
    $endRangeValue          = "--";
    $regionId               = "";
} else {
    $startRangeValue = $_POST['invrangestart'];
    $endRangeValue   = $_POST['invrangeend'];
}
// For Firm Type 
if ($_POST['firmtype'] != '') {
    $firmtypetxt     = $_POST['firmtype'];
    $firmtypesql     = "SELECT FirmType FROM firmtypes WHERE FirmTypeId = " . $firmtypetxt;
    $firmtypesql     = mysql_query($firmtypesql);
    $firmtypedisplay = mysql_fetch_array($firmtypesql);
    $firmtypename    = $firmtypedisplay['FirmType'];
}
$firmtypevalue = implode(",", $firmtypetxt);
foreach ($firmtypetxt as $firmid) {
    $firmsql = "select FirmType from firmtypes where FirmTypeId=$firmid";
    if ($firmtyp = mysql_query($firmsql)) {
        While ($myrow = mysql_fetch_array($firmtyp, MYSQL_BOTH)) {
            $firmvaluetext = $firmvaluetext . "," . $myrow["FirmType"];
            // print_r($firmvaluetext);
        }
    }
}
$firmvaluetext = substr_replace($firmvaluetext, '', 0, 1);
if ($cityid != '') {
    
    if ($cityid == '--') {
        $cityname = "All City";
    } else {
        $citysql = "select city_name from city where city_id = $cityid";
        
        if ($citytype = mysql_query($citysql)) {
            While ($myrow = mysql_fetch_array($citytype, MYSQL_BOTH)) {
                $cityname = $myrow["city_name"];
                //echo $cityname;
            }
        }
    }
    
}

if ($countryNINtxt != '') {
    if ($countryNINtxt == 'All') {
        $countryNINname = "All Countries";
    } else {
        $countrysql = "select country from country where countryid = '" . $countryNINtxt . "'";
        
        if ($countrytype = mysql_query($countrysql)) {
            While ($myrow = mysql_fetch_array($countrytype, MYSQL_BOTH)) {
                $countryNINname = $myrow["country"];
                //echo $countryNINname;
            }
        }
    }
    
}

if ($countrytxt != "") {
    if ($countrytxt == "IN") {
        $countrynametxt = "India";
    } else if ($countrytxt == "NIN") {
        $countrynametxt = "Non India";
    }
}
$endRangeValueDisplay = $endRangeValue;
$whereind             = "";
$whereinvType         = "";
$wherestage           = "";
$wheredates           = "";
$whererange           = "";

if ($resetfield == "period" && !$_GET) {
    $month1          = "--";
    $year1           = "--";
    $month2          = "--";
    $year2           = "--";
    $_POST['month1'] = $_POST['month2'] = $_POST['year1'] = $_POST['year2'] = "";
} else {
    $month1 = ($_POST['month1']) ? $_POST['month1'] : date('m');
    $year1  = ($_POST['year1']) ? $_POST['year1'] : date('Y') - 3;
    $month2 = ($_POST['month2']) ? $_POST['month2'] : date('n');
    $year2  = ($_POST['year2']) ? $_POST['year2'] : date('Y');
}

if ($resetfield == "followonVCFund") {
    $_POST['followonVCFund'] = "";
    $followonVC              = "--";
} else {
    $followonVC = trim($_POST['followonVCFund']);
    if ($followonVC != '--' && $followonVC != '') {
        $searchallfield = '';
    }
}
if ($followonVC == "--") {
    $followonVCFund = "--";
} elseif ($followonVC == 1) {
    $followonVCFund = 1;
} elseif ($followonVC == 2) {
    $followonVCFund = 3;
}
if ($followonVCFund == "--") {
    $followonVCFundText == "";
} elseif ($followonVCFund == "1") {
    $followonVCFundText = "Follow on Funding";
} elseif ($followonVCFund == "3") {
    $followonVCFundText = "No Funding";
}

if ($resetfield == "exitedstatus") {
    $_POST['exitedstatus'] = "";
    $exitvalue             = "--";
} else {
    $exitvalue = trim($_POST['exitedstatus']);
    if ($exitvalue != '--' && $exitvalue != '') {
        $searchallfield = '';
    }
}
if ($exitvalue == "--")
    $exited = "--";
elseif ($exitvalue == 1)
    $exited = 1;
elseif ($exitvalue == 2)
    $exited = 3;

if ($exited == "--") {
    $exitedText = "";
} elseif ($exited == "1") {
    $exitedText = "Exited";
} elseif ($exited == "3") {
    $exitedText = "Not Exited";
    
}

$datevalue  = returnMonthname($month1) . "-" . $year1 . "to" . returnMonthname($month2) . "-" . $year2;
$splityear1 = (substr($year1, 2));
$splityear2 = (substr($year2, 2));

if (($month1 != "") && ($month2 !== "") && ($year1 != "") && ($year2 != "")) {
    $datevalueDisplay1 = returnMonthname($month1) . " " . $splityear1;
    $datevalueDisplay2 = returnMonthname($month2) . "  " . $splityear2;
    $wheredates1       = "";
}


if ($resetfield == "searchallfield") {
    $_POST['searchallfield'] = "";
    $searchallfield          = "";
} else {
    $searchallfield = trim($_POST['searchallfield']);
}

if ($resetfield == "dirsearch") {
    $_POST['dirsearch'] = "";
    $dirsearch          = "";
} else {
    $dirsearch = trim($_POST['dirsearch']);
}

if ($resetfield == "autocomplete") {
    $_POST['autocomplete'] = "";
    $dirsearch             = "";
} else {
    $dirsearch = trim($_POST['autocomplete']);
}

if ($resetfield == "city") {
    $_POST['citysearch'] = "";
    $city                = "";
} else {
    $city = trim($_POST['citysearch']);
    
}
if ($vcflagValue == 0) {
    
    $addVCFlagqry       = "";
    $checkForStage      = ' && (' . '$stage' . ' =="")';
    //$checkForStage = " && (" .'$stage'."=='--') ";
    $checkForStageValue = " || (" . '$stage' . ">0) ";
    $searchTitle        = "List of PE Investors ";
} elseif ($vcflagValue == 1) {
    $addVCFlagqry       = "";
    $addVCFlagqry       = "and s.VCview=1 and pe.amount<=20 ";
    $checkForStage      = '&& (' . '$stage' . '=="") ';
    //$checkForStage = " && (" .'$stage'."=='--') ";
    $checkForStageValue = " || (" . '$stage' . ">0) ";
    $searchTitle        = "List of VC Investors ";
    //  echo "<br>Check for stage** - " .$checkForStage;
}

if ($industry > 0) {
    $industrysql = "select industry from industry where IndustryId=$industry";
    if ($industryrs = mysql_query($industrysql)) {
        While ($myrow = mysql_fetch_array($industryrs, MYSQL_BOTH)) {
            $industryvalueflt = $myrow["industry"];
        }
    }
}

if ($boolStage == true) {
    foreach ($stageval as $stageid) {
        $stagesql = "select Stage from stage where StageId=$stageid";
        //  echo "<br>**".$stagesql;
        if ($stagers = mysql_query($stagesql)) {
            While ($myrow = mysql_fetch_array($stagers, MYSQL_BOTH)) {
                $stagevaluetext = $stagevaluetext . "," . $myrow["Stage"];
            }
        }
    }
    $stagevaluetext = substr_replace($stagevaluetext, '', 0, 1);
} else {
    $stagevaluetext = "";
    
    if ($investorType != "") {
        $invTypeSql = "select InvestorTypeName from investortype where InvestorType='$investorType'";
        if ($invrs = mysql_query($invTypeSql)) {
            While ($myrow = mysql_fetch_array($invrs, MYSQL_BOTH)) {
                $invtypevalue = $myrow["InvestorTypeName"];
            }
        }
    }
}

if ($resetfield == "txtregion") {
    $_POST['txtregion'] = "";
} else {
    $txtregion = $_POST['txtregion'];
    if ($txtregion != '--' && count($txtregion) > 0) {
        $searchallfield = '';
    }
}

if ($txtregion == "--") {
    $regionText = "";
} else {
    // $regionText="Region";
    if (count($txtregion) > 0) {
        $region_Sql = $regionvalue = '';
        foreach ($txtregion as $regionIds) {
            $region_Sql .= " RegionId=$regionIds or ";
        }
        $roundSqlStr = trim($region_Sql, ' or ');
        
        $regionSql = "select Region from region where $roundSqlStr";
        if ($regionrs = mysql_query($regionSql)) {
            While ($myregionrow = mysql_fetch_array($regionrs, MYSQL_BOTH)) {
                $regionvalue .= $myregionrow["Region"] . ', ';
            }
        }
        $regionText  = trim($regionvalue, ', ');
        $region_hide = implode($txtregion, ',');
    }
}
//echo "<br>*************".$stagevaluetext;
if ($companyType == "L")
    $companyTypeDisplay = "Listed";
elseif ($companyType == "U")
    $companyTypeDisplay = "UnListed";
elseif ($companyType == "--")
    $companyTypeDisplay = "";

if ($investorType != "") {
    $invTypeSql = "select InvestorTypeName from investortype where InvestorType='$investorType'";
    if ($invrs = mysql_query($invTypeSql)) {
        While ($myrow = mysql_fetch_array($invrs, MYSQL_BOTH)) {
            $invtypevalue = $myrow["InvestorTypeName"];
        }
    }
}

if ($regionId > 0) {
    $regionSql = "select Region from region where RegionId=$regionId";
    if ($regionrs = mysql_query($regionSql)) {
        While ($myregionrow = mysql_fetch_array($regionrs, MYSQL_BOTH)) {
            $regionvalue = $myregionrow["Region"];
        }
    }
}

if ($round != "--" || $round != null) {
    $roundSql = "SELECT * FROM `peinvestments` where `round` like '" . $round . "%'  group by `round`";
    if ($roundQuery = mysql_query($roundSql)) {
        $roundtxt = '';
        While ($myrow = mysql_fetch_array($roundQuery, MYSQL_BOTH)) {
            $roundtxt .= $myrow["round"] . ",";
        }
        $roundtxt = trim($roundtxt, ',');
    }
}

/* CODE FOR FILTER : END */

$searchString = "Undisclosed";
$searchString = strtolower($searchString);

$searchString1 = "Unknown";
$searchString1 = strtolower($searchString1);

$searchString2 = "Others";
$searchString2 = strtolower($searchString2);

$dbTypeSV = "SV";
$dbTypeIF = "IF";
$dbTypeCT = "CT";

if ($VCFlagValue == 0) {
    $getTotalQuery   = "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                FROM peinvestments AS pe, pecompanies AS pec
                WHERE pe.Deleted =0  and pe.PECompanyId=pec.PECompanyId
                AND pec.industry !=15 and pe.AggHide=0 and
                pe.PEId NOT
                        IN (
                        SELECT PEId
                        FROM peinvestments_dbtypes AS db
                        WHERE DBTypeId ='SV'
                        AND hide_pevc_flag =1
                        )";
    $pagetitle       = "PE Investments -> Search";
    $stagesql_search = "select StageId,Stage from stage ";
    $industrysql     = "select industryid,industry from industry where industryid IN (" . $_SESSION['PE_industries'] . ")" . $hideIndustry . " order by industry";
    // echo "<br>***".$industrysql;
} elseif ($VCFlagValue == 1) {
    
    $getTotalQuery   = "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                FROM peinvestments AS pe, stage AS s ,pecompanies as pec
                WHERE s.VCview =1 and  pe.amount<=20 and pec.industry !=15 and pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId
    and pe.Deleted=0 and
                pe.PEId NOT
                        IN (
                        SELECT PEId
                        FROM peinvestments_dbtypes AS db
                        WHERE DBTypeId =  'SV'
                        AND hide_pevc_flag =1
                        )  ";
    $pagetitle       = "VC Investments -> Search";
    $stagesql_search = "select StageId,Stage from stage where VCview=1 ";
    $industrysql     = "select industryid,industry from industry where industryid IN (" . $_SESSION['PE_industries'] . ")" . $hideIndustry . " order by industry";
    
    //echo "<Br>---" .$getTotalQuery;
} elseif ($VCFlagValue == 2) {
    
    $getTotalQuery = " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                FROM REinvestments AS pe, pecompanies AS pec
    WHERE pec.Industry =15 and pe.Deleted=0 AND pe.PEcompanyID = pec.PECompanyId ";
    $pagetitle     = "PE Investments - Real Estate -> Search";
    
    $stagesql_search = "";
    $industrysql     = "select industryid,industry from industry where industryid IN (" . $_SESSION['PE_industries'] . ")";
}

$investorId = $strvalue[0];

$pe_re = 1;
if ($pe_re == 1) {
    $industryvalue = " c.industry !=15";
    //$dealpage = "dirdealdetails.php";
    $dealpage      = "dealdetails.php";
} elseif ($pe_re == 2) {
    $industryvalue = " c.industry =15";
    $dealpage      = "redealinfo.php";
}
if ($industry > 0) {
    $industrysql = "select industry from industry where IndustryId=$industry";
    if ($industryrs = mysql_query($industrysql)) {
        While ($myrow = mysql_fetch_array($industryrs, MYSQL_BOTH)) {
            //$industryvalue=$myrow["industry"];
        }
    }
}

$exportToExcel = 0;
$TrialSql      = "select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
//echo "<br>---" .$TrialSql;
if ($trialrs = mysql_query($TrialSql)) {
    while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
        $exportToExcel = $trialrow["TrialLogin"];
    }
}

//$sql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId,
//      c.companyname,DATE_FORMAT( peinv.dates, '%b-%Y' )as dealperiod,inv.*
//      from peinvestments_investors as peinv_inv,peinvestors as inv,
//      peinvestments as peinv,pecompanies as c
//      where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
//      and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId order by peinv.dates desc";

/*$sql = "select * from peinvestors where InvestorId=$investorId";*/
$sql = "select * from limited_partners where LPId=$investorId";



if ($VCFlagValue == 2) {
    $angInvestmentsql = "select peinv_inv.InvestorId,peinv_inv.AngelDealId,peinv.InvesteeId,
                        c.companyname,c.industry,i.industry as indname,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,c.sector_business,peinv.Exited,inv.*
                        from angel_investors as peinv_inv,peinvestors as inv,
                        angelinvdeals as peinv,pecompanies as c,industry as i
                        where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
                        and peinv.AngelDealId=peinv_inv.AngelDealId and c.PECompanyId=peinv.InvesteeId and peinv.Deleted=0
                        and $industryvalue  and i.industryid=c.industry
                        order by peinv.DealDate desc";
}


$Investmentsql = "SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname,
                    peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,AggHide,peinv.Exit_Status,c.sector_business,lp.InstitutionName,inv.Investor
                   FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv,limited_partners as lp
                   WHERE peinv.Deleted =0
                   AND c.PECompanyId = peinv.PECompanyId
                   AND $industryvalue
                   AND i.industryid = c.industry
                   AND lp.LPId = $investorId and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, trim(REPLACE( inv.LimitedPartners,', ',',')))
                   AND inv.InvestorId = peinv_inv.InvestorId
                   AND peinv.PEId = peinv_inv.PEId
                   group by inv.Investor order by peinv.dates desc";

//For Angel - Exits
if ($VCFlagValue == 2) {
    
    $iposql = "select peinv_inv.InvestorId,peinv_inv.AngelDealId,peinv.InvesteeId,
                c.companyname,c.industry,i.industry as indname,
                DATE_FORMAT( peinv.DealDate, '%b-%Y' ) as dealperiod,inv.Investor,c.sector_business
                from angel_investors as peinv_inv,peinvestors as inv,
                angelinvdeals as peinv,pecompanies as c,industry as i
                where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
                and peinv.Deleted=0 and i.industryid=c.industry
                and peinv.AngelDealId=peinv_inv.AngelDealId and c.PECompanyId=peinv.InvesteeId and peinv.Exited=1
                and $industryvalue";
}
//   echo"<bR>---" .$iposql;
/*$mandasql = "select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,
                                c.companyname,c.industry , i.industry as indname,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,peinv.ExitStatus,c.sector_business,inv.*
                                from manda_investors as peinv_inv,peinvestors as inv,
                                manda as peinv,pecompanies as c,industry as i
                                where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
                                and peinv.MandAId=peinv_inv.MandAId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 and i.industryid=c.industry
                                and $industryvalue
                                order by DealDate desc";*/
//   echo"<br>---" .$mandasql;

/*$onMgmtSql = "select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,
                    exe.ExecutiveName,exe.Designation,exe.Company from
                    peinvestors as pec,executives as exe,peinvestors_management as mgmt
                    where pec.InvestorId=$investorId and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId";*/

/*$SVInvestmentsql = "SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId,
                         DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,AggHide,SPV,peinv.Exit_Status,c.sector_business
                          FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                          WHERE peinv.Deleted =0
                          AND c.PECompanyId = peinv.PECompanyId
                          AND $industryvalue
                          AND i.industryid = c.industry
                          AND peinv_inv.InvestorId =$investorId
                          AND inv.InvestorId = peinv_inv.InvestorId
                          AND peinv.PEId = peinv_inv.PEId
                          AND peinv.PEId
                          IN (
                          SELECT PEId
                          FROM peinvestments_dbtypes AS db
                          WHERE DBTypeId = '$dbTypeSV'
                          ) order by peinv.dates desc";*/
//echo "<br>-- ".$SVInvestmentsql;
/*$IFInvestmentsql = "SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.Exit_Status,c.sector_business FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                          WHERE peinv.Deleted =0
                          AND c.PECompanyId = peinv.PECompanyId
                          AND $industryvalue
                          AND i.industryid = c.industry
                          AND peinv_inv.InvestorId =$investorId
                          AND inv.InvestorId = peinv_inv.InvestorId
                          AND peinv.PEId = peinv_inv.PEId
                          AND peinv.PEId
                          IN (

                          SELECT PEId
                          FROM peinvestments_dbtypes AS db
                          WHERE DBTypeId = '$dbTypeIF'
                          ) order by peinv.dates desc";
*/
/*$CTInvestmentsql = "SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.Exit_Status,c.sector_business FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                          WHERE peinv.Deleted =0
                          AND c.PECompanyId = peinv.PECompanyId
                          AND $industryvalue
                          AND i.industryid = c.industry
                          AND peinv_inv.InvestorId =$investorId
                          AND inv.InvestorId = peinv_inv.InvestorId
                          AND peinv.PEId = peinv_inv.PEId
                          AND peinv.PEId
                          IN (

                          SELECT PEId
                          FROM peinvestments_dbtypes AS db
                          WHERE DBTypeId = '$dbTypeCT'
                          ) order by peinv.dates desc";*/
//echo "<br>---" .$SVInvestmentsql;
/*$followoninvsql  = "select distinct peinva.InvesteeId,pe.PEId,pe.PECompanyId,c.Companyname,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,peinva.Exited,c.sector_business,i.industry AS indname from angel_investors as peinv_inv,peinvestors as inv,
                                angelinvdeals as peinva,pecompanies as c,industry as i,
                                peinvestments as pe,peinvestments_investors as peinv
                                where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv.InvestorId
                                and peinva.Deleted=0 and i.industryid=c.industry
                                and peinva.AngelDealId=peinv_inv.AngelDealId and c.PECompanyId=peinva.InvesteeId and c.PECompanyId=pe.PECompanyId
                                and peinva.FollowonVCFund=1  and pe.PECompanyId=peinva.InvesteeId and peinv.PEId=pe.PEId
                                and $industryvalue order by dates desc";
//echo "<br>---" .$followoninvsql ;
$indSql = "SELECT DISTINCT i.industry as ind, c.industry, peinv_inv.InvestorId
                        FROM peinvestments_investors AS peinv_inv, peinvestors AS inv, pecompanies AS c, peinvestments AS peinv, industry AS i
                        WHERE peinv_inv.InvestorId =$investorId
                        AND inv.InvestorId = peinv_inv.InvestorId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND peinv.PEId = peinv_inv.PEId and i.industryid!=15  and peinv.Deleted=0
                        AND i.industryid = c.industry and $industryvalue order by i.industry";*/

echo "<div style='display:none'><br>====" . $indSql . "</div>";

/*$stageSql = "select distinct s.Stage,pe.StageId,peinv_inv.InvestorId
                    from peinvestments_investors as peinv_inv,peinvestors as inv,peinvestments as pe,stage as s
                    where peinv_inv.InvestorId=$investorId and inv.InvestorId=peinv_inv.InvestorId
                    and pe.PEId=peinv_inv.PEId and s.StageId=pe.StageId order by Stage ";

$getinvestorAmount = "select SUM(peinvestments_investors.Amount_M) as total_amount FROM peinvestments 
    JOIN peinvestments_investors ON peinvestments_investors.PEId = peinvestments.PEId 
    JOIN pecompanies ON pecompanies.PECompanyId = peinvestments.PECompanyId 
    where peinvestments_investors.InvestorId = " . $investorId . " and peinvestments_investors.exclude_dp = 0 AND peinvestments.Deleted=0 AND 
    peinvestments.AggHide=0 and peinvestments.SPV = 0 and pecompanies.industry !=15 AND 
    peinvestments.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 )";*/

$investor_amount  = '';
$investoramountrs = mysql_query($getinvestorAmount);
$investorrowrow   = mysql_fetch_row($investoramountrs, MYSQL_BOTH);
$investor_amount  = $investorrowrow['total_amount'];
//echo "<br>--" .$stageSql;

$strIndustry = "";
$strStage    = "";
if ($rsInd = mysql_query($indSql)) {
    While ($myIndrow = mysql_fetch_array($rsInd, MYSQL_BOTH)) {
        $strIndustry = $strIndustry . ", " . $myIndrow["ind"];
    }
    $strIndustry = substr_replace($strIndustry, '', 0, 1);
}

if ($rsStage = mysql_query($stageSql)) {
    While ($myStageRow = mysql_fetch_array($rsStage, MYSQL_BOTH)) {
        $strStage = $strStage . ", " . $myStageRow["Stage"];
    }
    $strStage = substr_replace($strStage, '', 0, 1);
}

$topNav = 'Directory';
$tour   = 'Allow';
include_once('dirnew_header.php');
?>

<div id="container" >
    <table cellpadding="0" cellspacing="0" width="100%" style="margin-top: -1px;" >
        <tr>
                <td class="left-td-bg" style="display: none"> 
                    <div class="acc_main" >
                        <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
                        <div id="panel" style="display:block; overflow:visible; clear:both;">
                        <?php
if ($_POST['investments'] == 2) {
    
    include_once('dirangelrefine.php');
} else {
    include_once('newdirrefine1.php');
}
?>
                          <input type="hidden" name="resetfield" value="" id="resetfield"/>
                        </div>
                    </div>
                </td>
            <td class="profile-view-left" style="width:100%;">
                <div class="result-cnt">
<?php
if ($accesserror == 1) {
?>
                      <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php
    echo BASE_URL;
?>contactus.htm" target="_blank">Click here</a></b></div>
    <?php
    exit;
}
?>  
                    <div class="result-title " style=""> 
                        <div class="title-links">

                            <input class="senddeal" type="button" id="senddeal" value="Send this profile to your colleague" name="senddeal">
<?php
if (($exportToExcel == 1)) {
?>
                              <span id="exportbtn"></span>
                            <?php
}
?>
                      </div>
            <?php
$value      = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
$strvalue   = explode("/", $value);
$SelCompRef = $strvalue[0];

//GET PREV NEXT ID
$prevNextArr = array();
$prevNextArr = $_SESSION['LPId'];

$currentKey = array_search($SelCompRef, $prevNextArr);
$prevKey    = ($currentKey == 0) ? '-1' : $currentKey - 1;
$nextKey    = $currentKey + 1;

$rsinvestors = mysql_query($sql);

if (isset($_REQUEST['angelco_only'])) {
    //$angelco_invID = $SelCompRef;
} else if (mysql_num_rows($rsinvestors) > 0) {
    
     $myrow            = mysql_fetch_array($rsinvestors, MYSQL_BOTH);
    //$angelco_invID    = $myrow["angelco_invID"];
    $institution         = $myrow["InstitutionName"];
    $contactperson         = $myrow["ContactPerson"];
    $designation         = $myrow["Designation"];
    $email           = $myrow["Email"];
    $address1              = $myrow["Address1"];
    $address2              = $myrow["Address2"];
    $city1              = $myrow["City"];
    $pincode            = $myrow["PinCode"];
    $country          = $myrow["Country"];
    $phone         = $myrow["Phone"];
    $fax      = $myrow["Fax"];
    $website      = $myrow["Website"];
    $typeofinstitution     = $myrow["TypeOfInstitution"];
}
?>

                        <?php
if (!$_POST) {
    // echo $VCFlagValue;
    if ($VCFlagValue == 0) {
?>

                                <!-- <h2>
                                    <span class="result-no" id="show-total-deal"> <?php
        echo count($prevNextArr);
?> Results found</span>
                                    <span class="result-for">for PE Directory</span>
                                    <input class="postlink" type="hidden" name="numberofcom" value="<?php
        echo count($prevNextArr);
?>">
                                </h2> -->
                                <input class="postlink" type="hidden" name="numberofcom" value="<?php
        echo count($prevNextArr);
?>">             
                                <input class="postlink" type="hidden" name="keywordsearchdir" value="<?php
        echo $_POST['keywordsearchdir'];
?>">             
                            <?php
    } else {
?>
                              <!-- <h2>
                                    <span class="result-no" id="show-total-deal"> <?php
        echo count($prevNextArr);
?> Results found</span>
                                    <span class="result-for">for VC Directory</span>
                                    <input class="postlink" type="hidden" name="numberofcom" value="<?php
        echo count($prevNextArr);
?>">
                                </h2> -->
                                <input class="postlink" type="hidden" name="numberofcom" value="<?php
        echo count($prevNextArr);
?>">
<input class="postlink" type="hidden" name="keywordsearchdir" value="<?php
        echo $_POST['keywordsearchdir'];
?>">             
                            <?php
    }
?>
                          <ul class="result-select">
                            <?php
    if ($datevalueDisplay1 != "") {
?>
                                  <li> 
                                <?php
        echo $datevalueDisplay1 . "-" . $datevalueDisplay2;
?><a  onclick="resetinput('year1');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                            <?php
    }
?>

                            </ul>
                        <?php
} else {
    if ($VCFlagValue == 0) {
?>
                              <!-- <h2>
                                    <span class="result-no" id="show-total-deal"> <?php
        echo count($prevNextArr);
?> Results found</span>
                                    <span class="result-for">for PE Directory</span>
                                    <input class="postlink" type="hidden" name="numberofcom" value="<?php
        echo count($prevNextArr);
?>">
                                </h2> --> 
                                <input class="postlink" type="hidden" name="numberofcom" value="<?php
        echo count($prevNextArr);
?>"> 
 <input class="postlink" type="hidden" name="keywordsearchdir" value="<?php
        echo $_POST['keywordsearchdir'];
?>">             
                            <?php
    } else {
?>
                              <!-- <h2>
                                    <span class="result-no" id="show-total-deal"> <?php
        echo count($prevNextArr);
?> Results found</span>
                                    <span class="result-for">for VC Directory</span>
                                    <input class="postlink" type="hidden" name="numberofcom" value="<?php
        echo count($prevNextArr);
?>">
                                </h2> -->
                                <input class="postlink" type="hidden" name="numberofcom" value="<?php
        echo count($prevNextArr);
?>">
 <input class="postlink" type="hidden" name="keywordsearchdir" value="<?php
        echo $_POST['keywordsearchdir'];
?>">             
                            <?php
    }
?>

                            <input class="postlink" type="hidden" name="country" value="<?php
    echo $countrytxt;
?>">
                                <input class="postlink" type="hidden" name="countryNIN" value="<?php
    echo $countryNINtxt;
?>">
                                <input class="postlink" type="hidden" name="city" value="<?php
    echo $cityid;
?>">
                                <input type="hidden" name="searchallfield" value="<?php
    echo $searchallfield;
?>" >
                                <input type="hidden" name="autocomplete" value="<?php
    echo $dirsearch;
?>" >
<?php  if($searchallfield!="" || $industry > 0 || ($followonVC!="--" && $followonVC!="") || ($exited !="--" && $exitedText !='') || $stagevaluetext!="" || ($round!="--" && $round!=null) || 
                                     ($investorType !="--" && $investorType!=null) || $regionId > 0 || ($txtregion !="--" && $txtregion !="") || ($txtregion !="--" && $txtregion !="")
                                     || ($startRangeValue!= "--") && ($endRangeValue != "") || $city!=""  || $keyword!="" || $companysearch!="" || $sectorsearch!=""
                                     || $advisorsearch_trans!="" || $advisorsearch_legal!="" || $dirsearch!="" || (($firmvaluetext!="") && ($firmvaluetext != "--")) || $countrytxt != "" || $keyworddir !=""){ ?>
                            
                            <ul class="result-select">
                                <?php
                                $cl_count = count($_POST);
                                if ($cl_count > 4) {
                            ?>
                                                          <li class="result-select-close" style="border:none;"><a href="pedirview.php?value=<?php
                                    echo $vcflagValue;
                            ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                                          <?php
                                }
    if ($industry > 0 && $industry != null) {
    ?>
                              <li title="Industry">
                                    <?php
        echo $industryvalueflt;
?><a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($followonVC != "--" && $followonVC != "") {
?>
                          <li>
                            <?php
        echo $followonVCFundText;
?><a  onclick="resetinput('followonVCFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php
    }
    if ($exited != "--" && $exitedText != '') {
?>
                          <li>
                            <?php
        echo $exitedText;
?><a  onclick="resetinput('exitedstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php
    }
    if ($stagevaluetext != "" && $stagevaluetext != null) {
?>
                              <li> 
                                    <?php
        echo $stagevaluetext;
?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($round != "--" && $round != null) {
        $drilldownflag = 0;
?>
                                  <li> 
                                        <?php
        echo $round;
?><a  onclick="resetinput('round');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                    <?php
    }
    if ($investorType != "--" && $investorType != null) {
?>
                              <li> 
                                    <?php
        echo $invtypevalue;
?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($regionId > 0) {
?>
                              <li> 
                                    <?php
        echo $regionvalue;
?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($txtregion != "--" && $txtregion != "") {
?>
                          <li>
                            <?php
        echo $regionText;
?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php
    }
    if (($startRangeValue != "--") && ($endRangeValue != "")) {
?>
                              <li> 
                                    <?php
        echo "(USM)" . $startRangeValue . "-" . $endRangeValueDisplay;
?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($city != "") {
        $drilldownflag = 0;
?>
                                  <li> 
                                        <?php
        echo $city;
?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                <?php
    }
    if (trim($sdatevalueCheck1) != '') {
?>
                              <li> 
                                    <?php
        echo $sdatevalueCheck1 . "-" . $edatevalueCheck2;
?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($keyword != "") {
?>
                              <li> 
                                    <?php
        echo $keyword;
?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
     if ($keyworddir != "") {
?>
                              <li> 
                                    <?php
        echo $keyworddir;
?><a  onclick="resetinput('keywordsearchdir');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($companysearch != "") {
?>
                              <li> 
                                    <?php
        echo $companysearch;
?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($sectorsearch != "") {
?>
                              <li> 
                                    <?php
        echo $sectorsearch;
?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($advisorsearch_trans != "") {
?>
                              <li> 
                                    <?php
        echo $advisorsearch_trans;
?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($firmvaluetext != "--" && $firmvaluetext != null) {
        $drilldownflag = 0;
?>
                              <li> 
                                    <?php
        echo $firmvaluetext;
?><a  onclick="resetinput('firmtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    
    if ($vcflagValue != 2 && $vcflagValue != 3 && $vcflagValue != 4 && $vcflagValue != 5 && $vcflagValue != 6 && $dealvalue != 103 && $dealvalue != 104 && $dealvalue != 102) {
        if ($countryname != "--" && $countryname != null && ($cityname != '' || $countryNINname != '')) {
            $drilldownflag = 0;
?>
                                      <li> 
                                             
                                            <?php
            echo $countrynametxt . "," . ucwords(strtolower($cityname)) . $countryNINname;
?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                    <?php
        }
    }
    
    if ($advisorsearch_legal != "") {
?>
                              <li> 
                                    <?php
        echo $advisorsearch_legal;
?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($dirsearch != "") {
?>
                              <li> 
                                    <?php
        echo $dirsearch;
?><a  onclick="resetinput('autocomplete');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($searchallfield != "") {
        $drilldownflag = 0;
?>
                              <li> 
                                    <?php
        echo trim($searchallfield);
?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                 <?php
    }
    $_POST['resetfield'] = "";
    foreach ($_POST as $value => $link) {
        if ($link == "" || $link == "--" || $link == " ") {
            unset($_POST[$value]);
        }
    }
    //print_r($_POST);
    
    if ($tagsearch != '') {

                                            $ex_tags_filter = explode(':', $tagsearch);

                                            if (count($ex_tags_filter) > 1) {
                                                $tagsearch = trim($tagsearch);
                                            } else {

                                                $tagsearch = "tag:" . trim($tagsearch);
                                            }
                                            ?>
                                                <li><?php echo $tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                                            <?php
                                }
?>
                           </ul>
                           
<?php
}else{
    ?>
    <script>
        $(document).ready(function(){
        
        $('.result-title').css("height","85px");
         $(".result-title").css("padding","28px 0 20px");
     });
    </script>
    <?php
}

}
?>           
                    </div>     
                    <div class="list-tab mt-list-tab"><ul>
                            <li><a href="pedirview.php?value=<?php
                                echo $strvalue[1];
                                ?>"  id="icon-grid-view" class="postlink"><i></i> List  View</a></li>
                             <li class="active"><a id="icon-detailed-view" class="postlink" href="lpdirdetails.php?value=<?php
                                echo $_GET['value'];
                                ?>" ><i></i> Detail View</a></li> 
                        </ul></div> 
                    <div class="lb" id="popup-box">
                        <div class="title">Send this to your Colleague</div>
                        <form>
                            <div class="entry">
                                <label> To</label>
                                <input type="text" name="toaddress" id="toaddress"  />
                            </div>
                            <div class="entry">
                                <h5>Subject</h5>
                                <p>Checkout this profile- <?php
                                    echo $myrow["Investor"];
                                    ?> - in Venture Intelligence</p>
                                                                    <input type="hidden" name="subject" id="subject" value="Checkout this profile- <?php
                                    echo $myrow["Investor"];
                                    ?> - in Venture Intelligence"  />
                                                                </div>
                                                                <div class="entry">
                                                                    <h5>Message</h5>
                                                                    <p><?php
                                    echo curPageURL();
                                    ?>   <input type="hidden" name="message" id="message" value="<?php
                                    echo curPageURL();
                                    ?>"  />   <input type="hidden" name="useremail" id="useremail" value="<?php
                                    echo $_SESSION['UserEmail'];
                                    ?>"  /> </p>
                            </div>
                            <div class="entry">
                                <input type="button" value="Submit" id="mailbtn" />
                                <input type="button" value="Cancel" id="cancelbtn" />
                            </div>

                        </form>
                    </div>
                        
                          <div class="detailed-title-links">  
                              <h2>  <?php
                                    echo $myrow["InstitutionName"];
                                ?>  
                                </h2>
                                <?php
                                if ($prevKey != '-1') {
                                ?> <a  class="postlink" id="previous" href="lpdirdetails.php?value=<?php
                                    echo $prevNextArr[$prevKey];
                                ?>/<?php
                                    echo $VCFlagValue;
                                ?>/<?php
                                    echo $dealvalue;
                                ?>">< Previous</a><?php
                                }
                                ?> 
                                <?php
                                if ($nextKey < count($prevNextArr)) {
                                ?><a class="postlink" id="next" href="lpdirdetails.php?value=<?php
                                    echo $prevNextArr[$nextKey];
                                ?>/<?php
                                    echo $VCFlagValue;
                                ?>/<?php
                                    echo $dealvalue;
                                ?>"> Next > </a>  <?php
                                }
                                ?>
                      </div>        
                        
                        
                    <div class="view-detailed">


                        <!-- new -->
                            <?php
if ($angelco_invID != '') {
    
    
    $profileurl = "https://api.angel.co/1/users/$angelco_invID/?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&include_details=investor";
    
    //role=founder&
    $roleurl = "https://api.angel.co/1/users/$angelco_invID/roles?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer";
    
    $profilejson = file_get_contents($profileurl);
    $profile     = json_decode($profilejson);
    
    
    $rolejson = file_get_contents($roleurl);
    $roles    = json_decode($rolejson);
    $roles    = $roles->startup_roles;
    
    echo "<pre>";
    // print_r($roles);
    echo "</pre>";
}
?>



                        <div class="com-wrapper ">
                            
                            
                          
                           <section class="com-cnt-sec directoryheader1"  id="investorProfile">
                                <header>
                                    <h3 class="fl">Limited Partner Profile</h3>
                                     <?php
if ($angelco_invID != '') {
?>
                                  <img src="img/angle-list.png" alt="angle-list" class="fr mar-top">
                                    <?php
}
?>
                              </header>
                                
                                <?php
if ($angelco_invID != '') {
?>
                              <div class="com-col InvPro-bg">
                                    
                                    <div class="inv-detail-pos" style="padding: 10px 20px 40px;">
                                    <span class="fl inv-detail-avt" style="padding-right: 20px;"><?php
    if ($profile->image) {
?> <img src="<?php
        echo $profile->image;
?>"  style="width: 145px;"> <?php
    }
?></span>
                                    <h2 style="font-size: 36px;"> <?php
    if ($profile->name) {
        echo $profile->name;
    }
?></h2> 
                                    <p style="font-size: 21px;"> <?php
    if ($profile->bio) {
        echo $profile->bio;
    }
?></p>
                                   </div> 
                                    
                                    
                                    <div class="com-sec-lg">
                                        <table class="inv-pro-table">
                                            <tbody>
                                                
                                                    <?php
    if ($angelco_invID != '' && count($roles) > 0) {
        $founder = array();
        foreach ($roles as $f) {
            if ($f->role == 'founder') {
                $founder[] = $f->startup->name;
            }
        }
        if (count($founder) > 0) {
            echo "<tr><td><span>Founder</span></td><td>";
            echo implode(", ", $founder);
            echo "</td></tr>";
        }
        //DSG Growth, DSG Consumer Partners, Beacon India Private Equity Fund 
    }
?>
                                                  
                                                
                                                
                                              
                                                    <?php
    if ($angelco_invID != '' && count($roles) > 0) {
        $employee = array();
        foreach ($roles as $e) {
            if ($e->role == 'employee') {
                $employee[] = $e->startup->name;
            }
        }
        if (count($employee) > 0) {
            echo "<tr><td><span>Employee</span></td><td>";
            echo implode(", ", $employee);
            echo "</td></tr>";
        }
        //Bain & Company, Reuters Venture Capital 
    }
?>
                                                 
                                                
                                               

                                                    <?php
    if ($angelco_invID != '' && count($roles) > 0) {
        $past_investor = array();
        foreach ($roles as $i) {
            if ($i->role == 'past_investor') {
                $past_investor[] = $i->startup->name;
            }
        }
        if (count($past_investor) > 0) {
            echo "<tr><td><span>Investor</span></td><td>";
            echo implode(", ", $past_investor);
            echo "</td></tr>";
        }
        
        // Cleartrip, Vouch Financial, Navdy, Birdi, Authy, Faraday Bicycles, Rockbot, Weaved, Gil Penchina Backers Fund I, Onfleet, AngelList Syndicates Fund I, SkyKick, Lenda, RedMart, Airdog, Recarga.com, Chope, ZipDial, GOQii, OYO Rooms, EkStop, Doonya, Indian Home Gourmet Pvt., Bakers Circle, Exito Gourmet, 7 more...</td>
    }
?>

                                               
                                                
                                                    <?php
    if ($angelco_invID != '' && count($profile->skills) > 0) {
        $skills = array();
        foreach ($profile->skills as $s) {
            if ($s->display_name) {
                $skills[] = $s->display_name;
            }
        }
        if (count($skills) > 0) {
            echo "<tr><td><span>Skills</span></td><td>";
            echo implode(", ", $skills);
            echo "</td></tr>";
        }
        // Private Equity, Venture Capital, Consumer Businesses
    }
?>
                                                  
                                                
                                                
                                              
                                                    <?php
    if ($angelco_invID != '' && count($profile->locations) > 0) {
        $locations = array();
        foreach ($profile->locations as $l) {
            if ($l->display_name) {
                $locations[] = $l->display_name;
            }
        }
        if (count($locations) > 0) {
            echo "<tr><td><span>Locations</span></td><td>";
            echo implode(", ", $locations);
            echo "</td></tr>";
        }
        // Bain & Company, Reuters Venture Capital
    }
?>
                                                 
                                                        
                                                    <?php
    if ($angelco_invID != '' && count($profile->investor_details->markets) > 0) {
        $markets = array();
        foreach ($profile->investor_details->markets as $m) {
            if ($m->display_name) {
                $markets[] = $m->display_name;
            }
        }
        if (count($markets) > 0) {
            echo "<tr><td><span>Markets</span></td><td>";
            echo implode(", ", $markets);
            echo "</td></tr>";
        }
        // Bain & Company, Reuters Venture Capital
    }
?>
                                                 
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pro-inve-exp">
                                        
                                                         <?php
    if (count($profile->investor_details->investments) > 0) {
        echo "<p><span>Experience</span>";
        echo count($profile->investor_details->investments) . " Confirmed Investments �";
        if ($profile->investor_details->average_amount) {
            echo $profile->investor_details->average_amount;
        }
        echo "</p>";
    }
?>
                                      
                                    </div>
                                </div>
                                <?php
}
?>
                              
                                <?php
if (!isset($_REQUEST['angelco_only'])) {
?>  
                                <div class="com-col InvPro-bg">
                                    <div class="table-sec custom-table">
                                        <table id="firstTable" class="inv-pro-table dirdetail" >






                                                        <?php
    if ($myrow["InstitutionName"] != "") {
?>                                        

                                                <tr>
                                                    <td><span>Institution Name</span></td>
                                                    <td><?php
        echo $myrow["InstitutionName"];
?></td>
                                                </tr>

                                                <?php if ($contactperson != "") {?>
                                                <tr>
                                                    <td><span>Contact Person</span></td>
                                                    <td><?php echo $contactperson;?></td>
                                                </tr>
                                                <?php } ?>

                                                           
    <?php
    }
    if ($email != "") {
?>
                                              <tr>
                                                    <td><span>Email</span></td>
                                                    <td><?php
        echo $email;
?></td>
                                                </tr>
    <?php
    }
    if (($phone != "") ) {
?>
                                              <tr>
                                                    <td><span>TelePhone</span></td>
                                                    <td><?php
        echo $phone;
?></td>
                                                </tr>  
    <?php
    }
    if (($website != "") ) {
?>
                                              <tr>
                                                    <td><span>Website</span></td>
                                                    <td><a href="<?php echo $website;?>">Click here</a></td>
                                                </tr>  
    <?php
    }
    if (($typeofinstitution != "") ) {
?>
                                              <tr>
                                                    <td><span>Type Of Institution</span></td>
                                                    <td><?php
        echo $typeofinstitution;
?></td>
                                                </tr>  
                                                 <?php
    }
    if ($address1 != "" ) {
?>
                                              <tr>
                                                    <td><span>Address Line1</span></td>
                                                    <td><?php
        echo $address1;
?></td>
                                                </tr>
    <?php
    }
?>
                                          
<?php
    if ($address2 != "") {
?>
                                              <tr>
                                                    <td><span>Address Line2</span></td>
                                                    <td><?php
        echo $address2;
?></td>
                                                </tr>  
    <?php
    }
    
    if ($city1 != "") {
?>
                                              <tr>
                                                    <td><span>City</span></td>
                                                    <td><?php
        echo $city1;?> <?php if ($pincode != "") {
        echo " and ".$pincode; } 
?>

    
</td>
                                                </tr>   
                                                <?php
    }
    
?>
                                               
                                                        <?php
    
    if ($country != "") {
?>
                                                <tr>
                                                    <td><span>Country</span></td>
                                                    <td><?php
        echo $country;
?> </td>
                                                </tr> 
                                                
                                                <?php
    }
    
?>
                                             
    
                                             

                                        </table>   

                                  <!--   <img src="img/co-sec-logo.png" class="fr pad-20" alt="vi"> -->
                                </div>
                                <?php
}
?>
                              
                                
                            </section>
                            <section class="com-cnt-sec directoryheader investor-sec mar-10" id="ventureInvestment" style="width:100%">     
                                <header>
                                    <h3 class="fl">Investments</h3>
                                    <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
                                </header>
                                <div class="com-col pe-dirdetails">
                                    <div class="inv-cnt">
                                        <div class="inv-com-name">

                
                            <div class="clearfix"></div>

<div class="accordions">
  
        <?php
       
if ($getcompanyinvrs = mysql_query($Investmentsql)) {
    $inv_cnt = mysql_num_rows($getcompanyinvrs);
}
/*if ($getIFcompanyinvrs = mysql_query($IFInvestmentsql)) {
    $investmentIf_cnt = mysql_num_rows($getIFcompanyinvrs);
}
if ($getCTcompanyinvrs = mysql_query($CTInvestmentsql)) {
    $investmentct_cnt = mysql_num_rows($getCTcompanyinvrs);
}

if ($getANGLcompInv = mysql_query($angInvestmentsql)) {
    $angelinv_cnt = mysql_num_rows($getANGLcompInv);
}
*/
if ($inv_cnt > 0 || $investmentIf_cnt > 0 || $investmentct_cnt > 0 || $angelinv_cnt > 0) {
?><div id="tabsholder2">
<div class="accordions_title"> <ul   class="tabs">
    <?php
    if ($inv_cnt > 0) {
?>

                                                                <li id="tabz1">Investments</li>
        <?php
    } 
?>
                                                       

                                                        </ul> <span></span>
                                                   
                                                    </div>
 
                                            
                                                <?php
    if ($inv_cnt > 0) {
?>
 <div class="accordions_content">
    <p>
        <div  class="for-nai">

                         <div id="contentz1" class="tabscontent work-masonry-thumb" > 
                                 <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                     <thead><tr><th>Investor Name</th></tr></thead>
                                 <tbody>
                                                                        <?php
        $addTrancheWordtxt = "";
        
        While ($myInvestrow = mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH)) {
            
            /*$companyName = trim($myInvestrow["companyname"]);
            $companyName = strtolower($companyName);
            $compResult  = substr_count($companyName, $searchString);
            $compResult1 = substr_count($companyName, $searchString1);
            if ($myInvestrow["AggHide"] == 1) {
                $addTrancheWord    = "; NIA";
                $addTrancheWordtxt = $addTrancheWord;
            } else
                $addTrancheWord = "";
            if ($myInvestrow['Exit_Status'] == 1) {
                $exitstatusis = 'Unexited';
            } else if ($myInvestrow['Exit_Status'] == 2) {
                $exitstatusis = 'Partially Exited';
            } else if ($myInvestrow['Exit_Status'] == 3) {
                $exitstatusis = 'Fully Exited';
            } else {
                $exitstatusis = '-';
            }
            if (($compResult == 0) && ($compResult1 == 0)) {*/
?>
                                                                                   <tr><td style="alt">
                                                                                            <a href='dirdetails.php?value=<?php
                echo $myInvestrow["InvestorId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>' title="Company Details" target="_blank"><?php
                echo $myInvestrow["Investor"];
?></a></td></tr>
                                                                        <?php
            }
?>
                            
                                                                                
                                                              

                                                                        </tbody>
                                                                    </table>

                                                             
                                                                    </div>
                                                                     
                                                                
                                                                </div>
                                                            
                                                                <?php
    } else if ($angelinv_cnt > 0) {
?> <div class="accordions_content">
    <p>
<div  class=" for-nai">
                                                                <div id="contentz1" class="tabscontent work-masonry-thumb"> 
                                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                                                        <thead><tr><th>Company Name</th><th>Industry Name</th><th style="text-align: left;">Sector</th><th>Deal Period</th><!-- <th>Exited</th> --></tr></thead>
                                                                        <tbody>
                                                                            <?php
        While ($myInvestrow = mysql_fetch_array($getANGLcompInv, MYSQL_BOTH)) {
            $companyName = trim($myInvestrow["companyname"]);
            $companyName = strtolower($companyName);
            $compResult  = substr_count($companyName, $searchString);
            $compResult1 = substr_count($companyName, $searchString1);
            if ($myrow["Exited"] == 1) {
                $exitedstatus = "Yes";
            } else {
                $exitedstatus = "No";
            }
            if (($compResult == 0) && ($compResult1 == 0)) {
?>
                                                                                  <tr><td style="alt">
                                                                                            <a href='companydetails.php?value=<?php
                echo $myInvestrow["InvesteeId"] . '/' . $vcflagValue . '/' . $dealvalue . '/' . $topNav;
?>' title="Company Details"><?php
                echo $myInvestrow["companyname"];
?></a></td>
                                                                                    <?php
            } else {
?>
                                                                                  <tr><td >
                <?php
                echo ucfirst("$searchString");
?>
                                                                                      <?php
            }
?>
                                                                                  <td><?php
            echo $myInvestrow["indname"];
?></td>
<td style="text-align: left;"   ><?php
            echo $myInvestrow["sector_business"];
?></td> 
<td><a href="angeldirdetails.php?value=<?php
            echo $myInvestrow["AngelDealId"] . '/' . $VCFlagValue . '/' . $dealvalue;
?>" title="Deal Details">
                                                                                        <?php
            echo $myInvestrow["dealperiod"];
?></a></td> 
<!-- <td  ><?php
            echo $exitedstatus;
?></td>  -->
 </tr>
                                                                                        <?php
        }
?>

                                                                        </tbody>
                                                                    </table></div></div></p></div>


        <?php
    }
    
    if ($investmentIf_cnt > 0) {
?><div  class="  for-nai">
                                                               <div id="contentzinfrascruture" class="tabscontent work-masonry-thumb"> 
                                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                                                        <thead><tr><th>Company Name</th><th>Industry Name</th><th style="text-align: left;">Sector</th><th class="deal-period">Deal Period</th><th class="exit-status">Exit Status</th></tr></thead>
                                                                        <tbody>
                                                                <?php
        While ($myIFInvestrow = mysql_fetch_array($getIFcompanyinvrs, MYSQL_BOTH)) {
            $IFcompanyName = trim($myIFInvestrow["companyname"]);
            $IFcompanyName = strtolower($IFcompanyName);
            $compResultaa  = substr_count($IFcompanyName, $searchString);
            $compResult1bb = substr_count($IFcompanyName, $searchString1);
            if ($myIFInvestrow['Exit_Status'] == 1) {
                $exitstatusis = 'Unexited';
            } else if ($myIFInvestrow['Exit_Status'] == 2) {
                $exitstatusis = 'Partially Exited';
            } else if ($myIFInvestrow['Exit_Status'] == 3) {
                $exitstatusis = 'Fully Exited';
            } else {
                $exitstatusis = '-';
            }
?>

                                                                                <?php
            if (($compResultaa == 0) && ($compResult1bb == 0)) {
?>
                                                                                  <tr><td style="alt">
                                                                                            <a href='companydetails.php?value=<?php
                echo $myIFInvestrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>' title="Company Details"><?php
                echo $myIFInvestrow["companyname"];
?></a></td>
                                                                                    <?php
            } else {
?>
                                                                                  <tr><td style="alt">
                                                                                    <?php
                echo ucfirst("$searchString");
?></td>
                <?php
            }
?>
                                                                                  <td><?php
            echo $myIFInvestrow["indname"];
?></td><td style="text-align: left;"   ><?php
            echo $myIFInvestrow["sector_business"];
?></td>

<?php if($usrRgs['PEInv'] == 0 || $usrRgs['VCInv'] == 0) { ?>
<td><a title="Deal Details" style="text-decoration: underline;">
                                                                                    <?php
            echo $myIFInvestrow["dealperiod"];
?> </a></td>
<?php } else { ?>
<td><a href="<?php
            echo $dealpage;
?>?value=<?php
            echo $myIFInvestrow["PEId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>" title="Deal Details">
                                                                                    <?php
            echo $myIFInvestrow["dealperiod"];
?> </a></td>
<?php } ?>

<td><?php
            echo $exitstatusis;
?></td>


                                                                                </tr>
                                                                                        <?php
        }
?>  

                                                                        </tbody>
                                                                    </table> </div></div>
                                                                                        <?php
    }
    if ($investmentct_cnt > 0) {
?>  <div  class="  for-nai">                                     
                                                                <div id="contentzcleantech" class="tabscontent work-masonry-thumb"> 
                                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                                                        <thead><tr><th>Company Name</th><th>Industry Name</th><th style="text-align: left;">Sector</th><th class="deal-period">Deal Period</th><th class="exit-status">Exit Status</th></tr></thead>
                                                                        <tbody>

                                                                <?php
        While ($myCTInvestrow = mysql_fetch_array($getCTcompanyinvrs, MYSQL_BOTH)) {
            $CTcompanyName = trim($myCTInvestrow["companyname"]);
            $CTcompanyName = strtolower($CTcompanyName);
            $compResulta   = substr_count($CTcompanyName, $searchString);
            $compResult1b  = substr_count($CTcompanyName, $searchString1);
            if ($myCTInvestrow['Exit_Status'] == 1) {
                $exitstatusis = 'Unexited';
            } else if ($myCTInvestrow['Exit_Status'] == 2) {
                $exitstatusis = 'Partially Exited';
            } else if ($myCTInvestrow['Exit_Status'] == 3) {
                $exitstatusis = 'Fully Exited';
            } else {
                $exitstatusis = '-';
            }
?>
          <?php
            if (($compResulta == 0) && ($compResult1b == 0)) {
?>
                                                                                  <tr><td style="alt">
                                                                                            <a href='companydetails.php?value=<?php
                echo $myCTInvestrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>' title="Company Details"><?php
                echo $myCTInvestrow["companyname"];
?></a></td>
                                                                                    <?php
            } else {
?>
                                                                                  <tr><td style="alt">
                                                                                    <?php
                echo ucfirst("$searchString");
?></td>
                                                                                    <?php
            }
?>
                                                                                  <td><?php
            echo $myCTInvestrow["indname"];
?></td>
<td style="text-align: left;"   ><?php
            echo $myCTInvestrow["sector_business"];
?></td>

<?php if($usrRgs['PEInv'] == 0 || $usrRgs['VCInv'] == 0) { ?>
<td><a title="Deal Details" style="text-decoration: underline;">
            <?php
            echo $myCTInvestrow["dealperiod"];
?> </a></td>
<?php } else { ?>
<td><a href="<?php
            echo $dealpage;
?>?value=<?php
            echo $myCTInvestrow["PEId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>" title="Deal Details">
            <?php
            echo $myCTInvestrow["dealperiod"];
?> </a></td>
<?php } ?>

<td><?php
            echo $exitstatusis;
?></td>


                                                                                </tr>
                                                                                    <?php
        }
?>                                                                                                                       
                                                                        </tbody>
                                                                    </table></div></div>
                                                                                    <?php
    }
?></p>
                                                        </div>

                                                         </div>
                                                  <!--  </div>                                                       
                                                </div>  -->   
                                                <?php
}
?>
<?php
if ($getSVcompanyinvrs = mysql_query($SVInvestmentsql)) {
    $investment_cnt = mysql_num_rows($getSVcompanyinvrs);
    if ($investment_cnt > 0) {
?>
 <div class="accordions_title"><h2> Social Venture Investments </h2><span></span></div>
  <div class="accordions_content">
    <p> 
                                   <div  class="work-masonry-thumb col-2 for-nai" href="http://erikjohanssonphoto.com/work/aizone/">
                                        <!-- <h2> Social Venture Investments </h2> -->
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Industry Name</th><th style="text-align: left;">Sector</th><th class="deal-period">Deal Period</th><th class="exit-status">Exit Status</th></tr></thead>
                                            <tbody>
                                                            <?php
        $addSocialTrancheWordtxt = "";
        
        While ($mySVInvestrow = mysql_fetch_array($getSVcompanyinvrs, MYSQL_BOTH)) {
            $SVcompanyName = trim($mySVInvestrow["companyname"]);
            $SVcompanyName = strtolower($SVcompanyName);
            $compResult    = substr_count($SVcompanyName, $searchString);
            $compResult1   = substr_count($SVcompanyName, $searchString1);
            if ($mySVInvestrow["AggHide"] == 1) {
                $addTrancheWordSV        = "; NIA";
                $addSocialTrancheWordtxt = $addTrancheWordSV;
                $addTrancheWordSV_2      = "NIA";
            } else {
                $addTrancheWordSV = "";
            }
            if ($mySVInvestrow["SPV"] == 1) {
                $addDebtWordSV      = "; Debt";
                $addTrancheWordSV_2 = "Debt";
            } else
            {
                $addDebtWordSV = "";
            }
             if ($mySVInvestrow['Exit_Status'] == 1) {
                $exitstatusis = 'Unexited';
            } else if ($mySVInvestrow['Exit_Status'] == 2) {
                $exitstatusis = 'Partially Exited';
            } else if ($mySVInvestrow['Exit_Status'] == 3) {
                $exitstatusis = 'Fully Exited';
            } else {
                $exitstatusis = '-';
            }
?>
                                                                  <?php
            if (($compResult == 0) && ($compResult1 == 0)) {
?>
                                                      <tr>
                                                            <td  >
                                                                <a href='companydetails.php?value=<?php
                echo $mySVInvestrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>' title="Company Details"><?php
                echo $mySVInvestrow["companyname"];
?></a></td>
                <?php
            } else {
?>
                                                      <tr><td  >
                <?php
                echo ucfirst("$searchString");
?></td>
                                                                    <?php
            }
?>
                                                      <td><?php
            echo $mySVInvestrow["indname"];
?></td>
<td style="text-align: left;"   ><?php
            echo $mySVInvestrow["sector_business"];
?></td>

<?php if($usrRgs['PEInv'] == 0 || $usrRgs['VCInv'] == 0) { ?>
<td><a title="Deal Details" style="text-decoration: underline;">
                                                    <?php
            echo $mySVInvestrow["dealperiod"];
?></a><?php
            echo $addTrancheWordSV;
?><?php
            echo $addDebtWordSV_2;
?></td>
<?php } else { ?>
<td><a href="<?php
            echo $dealpage;
?>?value=<?php
            echo $mySVInvestrow["PEId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>" title="Deal Details">
                                                    <?php
            echo $mySVInvestrow["dealperiod"];
?></a><?php
            echo $addTrancheWordSV;
?><?php
            echo $addDebtWordSV_2;
?></td>
<?php } ?>

<td><?php
            echo $exitstatusis;
?></td>
                                                       <!--  <td> </td> -->


                                                    </tr>
            <?php
        }
?> 
                                            </tbody>
                                        </table>
                                        <?php
        if ($addSocialTrancheWordtxt == "; NIA") {
?>
                                          <p class="note-nia"  style="">*NIA - Not Included for Aggregate</p>
                                        <?php
        }
?>

                                    </div>
                                    
                                   </p>
  </div>
   <?php
    }
}
?>
<?php
if ($rsipoinvestors = mysql_query($iposql)) {
    $ipo_cnt = mysql_num_rows($rsipoinvestors);
}
if ($ipo_cnt > 0) {
?>
  <?php
    if ($VCFlagValue == 2) { // FOR Exits - Angel - variable names need to change  
?> <div class="accordions_title"><h2>Exits</h2><span></span></div>
  <div class="accordions_content">
    <p>
                                    <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
                                       <!--  <h2> Exits</h2> -->
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Industry Name</th><th style="text-align: left;">Sector</th><th class="deal-period">Deal Period</th><th class="exit-status">Exit Status</th></tr></thead>
                                            <tbody>
                                                <?php
        While ($ipmyrow = mysql_fetch_array($rsipoinvestors, MYSQL_BOTH)) {
            $exitstatusdisplayforIPO = "";
            $exitstatusvalueforIPO   = $ipmyrow["ExitStatus"];
            if ($exitstatusvalueforIPO == 0) {
                $exitstatusdisplayforIPO = "Partial Exit";
            } elseif ($exitstatusvalueforIPO == 1) {
                $exitstatusdisplayforIPO = "Complete Exit";
            }
?>

                                                    <tr>
                                                        <td><a href='companydetails.php?value=<?php
            echo $ipmyrow["InvesteeId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>' title="Company Details"><?php
            echo $ipmyrow["companyname"];
?></a></td>
                                                        <td><?php
            echo $ipmyrow["indname"];
?></td>
<td><?php
            echo $ipmyrow["sector_business"];
?></td>

<?php if($usrRgs['PEInv'] == 0 || $usrRgs['VCInv'] == 0) { ?>
<td><a title="Deal Details" style="text-decoration: underline;"><?php
            echo $ipmyrow["dealperiod"];
?></a></td> 
<?php } else { ?>
<td><a href='angeldirdetails.php?value=<?php
            echo $ipmyrow["AngelDealId"] . '/' . $VCFlagValue . '/' . $dealvalue;
?>' title="Deal Details"><?php
            echo $ipmyrow["dealperiod"];
?></a></td> 
<?php } ?>

<td><?php
            echo $exitstatusdisplayforIPO;
?></td>

                                                    </tr>
                                        <?php
        }
?>
                                          </tbody>
                                        </table>
                                    </div>  
                                     </p>
  </div> 
                                <?php
    } else {
?><div class="accordions_title"><h2>Exits - IPO</h2><span></span></div>
  <div class="accordions_content">
    <p>
                                   <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
                                       <!--  <h2> Exits - IPO</h2> -->
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Industry Name</th><th style="text-align: left;">Sector</th><th class="deal-period">Deal Period</th><th class="exit-status">Exit Status</th></tr></thead>
                                            <tbody>
        <?php
        While ($ipmyrow = mysql_fetch_array($rsipoinvestors, MYSQL_BOTH)) {
            $exitstatusdisplayforIPO = "";
            $exitstatusvalueforIPO   = $ipmyrow["ExitStatus"];
            if ($exitstatusvalueforIPO == 0) {
                $exitstatusdisplayforIPO = "Partial Exit";
            } elseif ($exitstatusvalueforIPO == 1) {
                $exitstatusdisplayforIPO = "Complete Exit";
            }
?>

                                                    <tr>
                                                        <td><a href='companydetails.php?value=<?php
            echo $ipmyrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>' title="Company Details"><?php
            echo $ipmyrow["companyname"];
?></a></td>
                                                        <td><?php
            echo $ipmyrow["indname"];
?></td>
<td><?php
            echo $ipmyrow["sector_business"];
?></td>

<?php if($usrRgs['PEInv'] == 0 || $usrRgs['VCInv'] == 0) { ?>
<td><a title="Deal Details" style="text-decoration: underline;"><?php
            echo $ipmyrow["dealperiod"];
?></a></td> 
<?php } else { ?>
<td><a href='diripodetails.php?value=<?php
            echo $ipmyrow["IPOId"] . '/' . $VCFlagValue . '/' . $dealvalue;
?>' title="Deal Details"><?php
            echo $ipmyrow["dealperiod"];
?></a></td> 
<?php } ?>


                                                        <td><?php
            echo $exitstatusdisplayforIPO;
?></td>
                                                    </tr>
                                                    <?php
        }
?>
                                          </tbody>
                                        </table>
                                    </div>  </p>
  </div>  
                                            <?php
    }
?>
                                          <?php
}
if ($rsmandainvestors = mysql_query($mandasql)) {
    if ($mandamyrow1 = mysql_fetch_array($rsmandainvestors, MYSQL_BOTH)) {
?><div class="accordions_title"><h2> Exits - M&A </h2><span></span></div>
  <div class="accordions_content">
    <p>
                                   <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
                                       <!--  <h2> Exits - M&A </h2> -->
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Industry Name</th><th style="text-align: left;">Sector</th><th class="deal-period">Deal Period</th><th class="exit-status">Exit Status</th></tr></thead>
                                            <tbody>
                                                    <?php
        if ($getcompanyrs = mysql_query($mandasql)) {
            While ($mandamyrow = mysql_fetch_array($getcompanyrs, MYSQL_BOTH)) {
                $exitstatusdisplay = "";
                $exitstatusvalue   = $mandamyrow["ExitStatus"];
                if ($exitstatusvalue == 0) {
                    $exitstatusdisplay = "Partial Exit";
                } elseif ($exitstatusvalue == 1) {
                    $exitstatusdisplay = "Complete Exit";
                }
?>

                                                        <tr>
                                                            <td><a href='companydetails.php?value=<?php
                echo $mandamyrow["PECompanyId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>' title="Company Details" ><?php
                echo $mandamyrow["companyname"];
?></a></td>
                                                            <td><?php
                echo $mandamyrow["indname"];
?></td>
<td><?php
                echo $mandamyrow["sector_business"];
?></td>

<?php if($usrRgs['PEInv'] == 0 || $usrRgs['VCInv'] == 0) { ?>
<td><a title="Deal Details" style="text-decoration: underline;"><?php
                echo $mandamyrow["dealperiod"];
?></a></td> 
<?php } else { ?>
<td><a href='dirmandadetails.php?value=<?php
                echo $mandamyrow["MandAId"] . '/' . $VCFlagValue . '/' . $dealvalue;
?>' title="Deal Details"><?php
                echo $mandamyrow["dealperiod"];
?></a></td> 
<?php } ?>

                                                            <td><?php
                echo $exitstatusdisplay;
?></td>
                                                        </tr>
                                                        <?php
            }
        }
?>
                                          </tbody>
                                        </table>
                                    </div> </p>
  </div> 
                                    <?php
    }
}
?>   
  
                                           
                                            
                               
                                             <?php
if ($getfollowinvrs = mysql_query($followoninvsql)) {
    $investmentfollow_cnt = mysql_num_rows($getfollowinvrs);
    
    if ($investmentfollow_cnt > 0) {
        
?>
<div class="accordions_title"><h2> Follow on Investments </h2><span></span></div>
  <div class="accordions_content">
    <p>
                                   <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aizone/">
                                        <!-- <h2> Follow on Investments </h2> -->
                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
                                            <thead><tr><th>Company Name</th><th>Industry Name</th><th style="text-align: left;">Sector</th><th class="deal-period">Deal Period</th><!-- <th class="exit-status">Exit Status</th> --></tr></thead>
                                            <tbody>

                                                                <?php
        While ($myfollowInvestrow = mysql_fetch_array($getfollowinvrs, MYSQL_BOTH)) {
            if ($myfollowInvestrow["Exited"] == 1) {
                $exitedstatus = "Yes";
            } else {
                $exitedstatus = "No";
            }
?>
                                                  <tr><td style="alt">
                                                            <a href='companydetails.php?value=<?php
            echo $myfollowInvestrow["InvesteeId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $topNav;
?>' title="Company Details"><?php
            echo $myfollowInvestrow["Companyname"];
?></a></td>
<td><?php
                echo $myfollowInvestrow["indname"];
?></td>
<td><?php
                echo $myfollowInvestrow["sector_business"];
?></td>

<?php if($usrRgs['PEInv'] == 0 || $usrRgs['VCInv'] == 0) { ?>
<td><a title="Deal Details" style="text-decoration: underline;">
                                                                    <?php
            echo $myfollowInvestrow["dealperiod"];
?></a></td>
<?php } else { ?>
<td><a href="<?php
            echo $dealpage;
?>?value=<?php
            echo $myfollowInvestrow["PEId"] . '/' . $VCFlagValue . '/' . $dealvalue . '/' . $dealpage;
?>" title="Deal Details">
                                                                    <?php
            echo $myfollowInvestrow["dealperiod"];
?></a></td> 
<?php } ?>


</td> 
                                                            <!-- <td><?php
                echo $exitedstatus;
?></td> -->


                                                    </tr>
                                                                            <?php
        }
?>
                                          </tbody>
                                        </table>
                                    </div>
                                    </p>
  </div>
        <?php
    }
}
?>


</div>


                                    
                                           
                                            
                                            
                                         

                                            
                                            
                                    
                            
                                            
                                            
                             <script type="text/javascript">
                            $(document).ready(function() {
                                          var moreinfobox =  $( ".moreinfobox" ).has( "td" ).length ;
                                          if(moreinfobox==0){
                                                $( ".moreinfobox" ).hide() ;
                                          }
                                        
                            });
                            </script>
                            <script>
   
    /*$(".accordions_title span").on("click", function() {
    
    $(this).parent().toggleClass("active").next().slideToggle();
    });*/
    // T-473 added
     $(".accordions_title ").on("click", function() {
  
    $(this).toggleClass("active").next().slideToggle();

    
    });
      $(".accordions_title ul li").on("click",function(){
      
         //$(this).parent().parent().toggleClass("active").next().css("display","block");
        if($(this).parent().parent().next().css('display') == 'none'){
            $(this).parent().parent().toggleClass("active").next().css("display","block");
        } else {
            $(this).parent().parent().next().css("display","block");
        }

     });
    
</script>
                                            
                            
                            
                            
<?php
While ($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH)) {
    $designation = $mymgmtrow["Designation"];
    if ($mymgmtrow["Designation"] == "")
        $designation = "";
    else
        $designation = $mymgmtrow["Designation"];
?>
                              
                                            
                                
                            <tr>
                                    <td><h4><?php
    echo $designation;
?></h4> <p><?php
    echo $mymgmtrow["ExecutiveName"];
?> </p></td>
                                </tr>
                                        <?php
}
?>
                         
                        </div>
                                            
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                            </section>
                            
                     
                            
                            
                            <div class="clearfix"></div>
                            <?php
if ($angelco_invID != '') {
?>
                          <section class="com-cnt-sec directoryheader inv-col3-main  " id="angelInvestment" style="clear: both">
                                <header>
                                    <h3 class="fl">Funding</h3>
                                    <img src="img/angle-list.png" alt="angle-list" class="fr mar-top">
                                </header>
                                <div class="com-col">
                                    <div class="fun-li-cnt">
                                        <?php
    if ($angelco_invID != '' && count($roles) > 0) {
        
        foreach ($roles as $f) {
            if ($f->role == 'past_investor') {
?>

                                                    <div class="inv-funding-li">
                                                        <img src="<?php
                echo $f->startup->thumb_url;
?>" alt="dsg">
                                                        <div class="inv-lf-li">
                                                            <h5><a href="<?php
                echo $f->startup->angellist_url;
?>" target="_blank"><?php
                echo $f->startup->name;
?></a></h5>
                                                            <p><?php
                echo $f->startup->high_concept;
?></p>
                                                <!--    <span>Founder, Managing Director</span>-->
                                                        </div>
                                                    </div>
                                                    <?php
            }
        }
    }
?>




                                        <!--            <div class="inv-funding-li">
                                                        <img src="img/dsg.png" alt="dsg">
                                                        <div class="inv-lf-li">
                                                                <h5>DSG Consumer Partners</h5>
                                                            <p>Consumer focused investment company.</p>
                                                            <span>Founder, Managing Director</span>
                                                        </div>
                                                    </div>-->

                                    </div>
                                </div>
                            </section>
                            <?php
}
?>
                          
                        </div>

                        <!-- new -->







                       



<!--                        <div class="profilemain">
                            <h2>Investor Profile</h2>

                            <div class="profiletable" style="position:  relative;">
                            </div>
                        </div>     

                        <div class="postContainer postContent masonry-container">
                        

                    </div>-->





                </div>


                </div>
            </td>


        </tr>

    </table>
</div>
</form>
<?php
if ($VCFlagValue == 2) {
?>
  <form name="investorDetails" method="post" id="investorDetails" action="angelinvestorexport.php">
        <input type="hidden" name="txthideinvestorId" value="<?php
    echo $investorId;
?>" >
        <input type="hidden" name="txthidepevalue" value="<?php
    echo $VCFlagValue;
?>" >
        <input type="hidden" name="hidepeipomandapage" value="5" >
        <input type="hidden" name="txthideemail" value="<?php
    echo $emailid;
?>" >  
<input type="hidden" name="invname" id="invname" value=" <?php echo $myrow["Investor"];?>"  />
    </form> 
                                            <?php
} else {
?>
 <form name="LPDetails" method="post" id="LPDetails" action="exportlpprofile.php">
        <input type="hidden" name="txthidelpId" value="<?php
    echo $investorId;
?>" >
        <input type="hidden" name="txthidepevalue" value="<?php
    echo $VCFlagValue;
?>" >
        <input type="hidden" name="hidepeipomandapage" value="5" >
        <input type="hidden" name="txthideemail" value="<?php
    echo $emailid;
?>" >  
<input type="hidden" name="invname" id="invname" value=" <?php echo $myrow["InstitutionName"];?>"  />
    </form>

                                            <?php
}
?>

<?php
//echo $exportToExcel;
if (($exportToExcel == 1)) {
?>
  <span style="float:right padding-right: 10px;" class="one title-links">
        <a class ="export" type="button"  value="Export" name="showdeals" id="expshowdealsbtn">Export</a>
    </span>
    <script type="text/javascript">
        $('#exportbtn').html('<a class ="export" id="expshowdeals"  name="showdeals">Export</a>');
    </script>
                                            <?php
}
?>

</form>


<script type="text/javascript">
     
     
     $(document).ready(function() {
        var ventureInvestment =  $( "#ventureInvestment" ).has( "td" ).length ;
        if(ventureInvestment==0){ $( "#ventureInvestment" ).hide() ;   }
        
        
         var investorProfile =  $( "#investorProfile" ).has( "td" ).length ;
        if(investorProfile==0){ $( "#investorProfile" ).hide() ;   }
        
        
        var angelInvestment =  $( "#angelInvestment" ).has( "h5" ).length ;
        if(angelInvestment==0){ $( "#angelInvestment" ).hide() ;   }
        
        
     });
     
</script>
 
 


<script type="text/javascript">
    $("a.postlink").click(function () {

        hrefval = $(this).attr("href");

        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;

    });

    function resetinput(fieldname)
    {
        // alert($('[name="'+fieldname+'"]').val());
        hrefval = 'pedirview.php';
        $("#pesearch").attr("action", hrefval);
        $("#resetfield").val(fieldname);
        $("#pesearch").submit();
        return false;
    }
    /*$(".export").click(function (){
     $("#investorDetails").submit();  
     });*/

    $('.export').click(function () {
        
        jQuery('#maskscreen').fadeIn();
        jQuery('#popup-box-copyrights').fadeIn();   
        return false;
    });
    
    $('#senddeal').click(function () {
        
        jQuery('#maskscreen').fadeIn(1000);
        jQuery('#popup-box').fadeIn();
        return false;
    });
    
    $('#cancelbtn').click(function () {

        jQuery('#popup-box').fadeOut();
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });

    function validateEmail(field) {
        var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return (regex.test(field)) ? true : false;
    }
    function checkEmail() {

        var email = $("#toaddress").val();
        if (email != '') {
            var result = email.split(",");
            for (var i = 0; i < result.length; i++) {
                if (result[i] != '') {
                    if (!validateEmail(result[i])) {

                        alert('Please check, `' + result[i] + '` email addresses not valid!');
                        email.focus();
                        return false;
                    }
                }
            }
        }
        else
        {
            alert('Please enter email address');
            email.focus();
            return false;
        }
        return true;
    }

    function initExport() {
        $.ajax({
            url: 'ajxCheckDownload.php',
            dataType: 'json',
            success: function (data) {
                var downloaded = data['recDownloaded'];
                var exportLimit = data.exportLimit;
                var currentRec = 1;

                //alert(currentRec + downloaded);
                var remLimit = exportLimit - downloaded;

                if (currentRec <= remLimit) {

                    $("#LPDetails").submit();
                    jQuery('#preloading').fadeOut();
                } else {
                    jQuery('#preloading').fadeOut();
                    //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                    alert("Currently your export action is crossing the limit of " + exportLimit + " records. You can download " + remLimit + " more records. To increase the limit please contact info@ventureintelligence.com");
                }
            },
            error: function () {
                jQuery('#preloading').fadeOut();
                alert("There was some problem exporting...");
            }

        });
    }

    $('#mailbtn').click(function () {

        if (checkEmail())
        {


            $.ajax({
                url: 'ajaxsendmail.php',
                type: "POST",
                data: {to: $("#toaddress").val(), subject: $("#subject").val(), message: $("#message").val(), userMail: $("#useremail").val()},
                success: function (data) {
                    if (data == "1") {
                        alert("Mail Sent Successfully");
                        jQuery('#popup-box').fadeOut();
                        jQuery('#maskscreen').fadeOut(1000);

                    } else {
                        jQuery('#popup-box').fadeOut();
                        jQuery('#maskscreen').fadeOut(1000);
                        alert("Try Again");
                    }
                },
                error: function () {
                    jQuery('#preloading').fadeOut();
                    alert("There was some problem sending mail...");
                }

            });
        }

    });
</script>
<?php include('backbuttondisable.php'); ?>
<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>
</body>
</html>

<?php

function returnMonthname($mth)
{
    if ($mth == 1)
        return "Jan";
    elseif ($mth == 2)
        return "Feb";
    elseif ($mth == 3)
        return "Mar";
    elseif ($mth == 4)
        return "Apr";
    elseif ($mth == 5)
        return "May";
    elseif ($mth == 6)
        return "Jun";
    elseif ($mth == 7)
        return "Jul";
    elseif ($mth == 8)
        return "Aug";
    elseif ($mth == 9)
        return "Sep";
    elseif ($mth == 10)
        return "Oct";
    elseif ($mth == 11)
        return "Nov";
    elseif ($mth == 12)
        return "Dec";
}

function writeSql_for_no_records($sqlqry, $mailid)
{
    $write_filename = "pe_query_no_records.txt";
    //echo "<Br>***".$sqlqry;
    $schema_insert  = "";
    //TRYING TO WRIRE IN EXCEL
    //define separator (defines columns in excel & tabs in word)
    $sep            = "\t"; //tabbed character
    $cr             = "\n"; //new line
    //start of printing column names as names of MySQL fields
    
    print("\n");
    print("\n");
    //end of printing column names
    $schema_insert .= $cr;
    $schema_insert .= $mailid . $sep;
    $schema_insert .= $sqlqry . $sep;
    $schema_insert = str_replace($sep . "$", "", $schema_insert);
    $schema_insert .= "" . "\n";
    
    if (file_exists($write_filename)) {
        //echo "<br>break 1--" .$file;
        $fp = fopen($write_filename, "a+"); // $fp is now the file pointer to file
        if ($fp) { //echo "<Br>-- ".$schema_insert;
            fwrite($fp, $schema_insert); //    Write information to the file
            fclose($fp); //    Close the file
            // echo "File saved successfully";
        } else {
            echo "Error saving file!";
        }
    }
    
    print "\n";
}

function highlightWords($text, $words)
{
    
    /*     * * loop of the array of words ** */
    foreach ($words as $worde) {
        
        /*         * * quote the text for regex ** */
        $word = preg_quote($worde);
        /*         * * highlight the words ** */
        $text = preg_replace("/\b($worde)\b/i", '<span class="highlight_word">\1</span>', $text);
    }
    /*     * * return the text ** */
    return $text;
}

function return_insert_get_RegionIdName($regionidd)
{
    $dbregionlink   = new dbInvestments();
    $getRegionIdSql = "select Region from region where RegionId=$regionidd";
    
    if ($rsgetInvestorId = mysql_query($getRegionIdSql)) {
        $regioncnt = mysql_num_rows($rsgetInvestorId);
        //echo "<br>Investor count-- " .$investor_cnt;
        
        if ($regioncnt == 1) {
            While ($myrow = mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH)) {
                $regionIdname = $myrow[0];
                //echo "<br>Insert return investor id--" .$invId;
                return $regionIdname;
            }
        }
    }
    $dbregionlink . close();
}

mysql_close();

function curPageURL() {
    $URL = 'http';
    $portArray = array( '80', '443' );
    if ($_SERVER["HTTPS"] == "on") {$URL .= "s";}
    $URL .= "://";
    if (!in_array( $_SERVER["SERVER_PORT"], $portArray)) {
     $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    } else {
     $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    }
    $pageURL=$URL."&scr=EMAIL";
    return $pageURL;
   }   return $pageURL;

?>
<script type="text/javascript" >
<?php
if ($_POST) {
?>
      $("#panel").animate({width: 'toggle'}, 200);
        $(".btn-slide").toggleClass("active");

        if ($('.left-td-bg').css("min-width") == '264px') {
            $('.left-td-bg').css("min-width", '36px');
            $('.acc_main').css("width", '35px');
        }
        else {
            $('.left-td-bg').css("min-width", '264px');
            $('.acc_main').css("width", '264px');
        }
<?php
}
?>

    $(document).on('click','#agreebtn',function(){
        
        $('#popup-box-copyrights').fadeOut();   
        $('#maskscreen').fadeOut(1000);
        $('#preloading').fadeIn();   
        initExport();
        return false; 
     });
    
     $(document).on('click','#expcancelbtn',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });
</script> 




<script src="hopscotch.js"></script>
<?php
if (isset($_SESSION['currenttour'])) {
    echo ' <script src="' . $_SESSION['currenttour'] . '.js?24feb"></script> ';
}
?>
<script src="TourStart.js"></script>     
<script type="text/javascript">
    $(document).ready(function () {

<?php
if (isset($_SESSION["DirectorydemoTour"]) && $_SESSION["DirectorydemoTour"] == '1') {
?>
          Directorydemotour = 1;

            hopscotch.startTour(tour, 4);
            $(".hopscotch-bubble").hide();

            $('body,html').animate({scrollTop: $(document).height()}, 20000);

            setTimeout(function () {
                if (Directorydemotour == 1) {
                    $('body,html').animate({scrollTop: 0}, 25000);
                    $(".hopscotch-bubble").show();
                    $(".tourDialog").css({"position": "fixed", "top": "35%"});
                }
            }, 18000);

            setTimeout(function () {
                if (Directorydemotour == 1) {
                    hopscotch.startTour(tour, 4);
                }
            }, 35000);

<?php
}
?>

    });
</script>

<style>
/*.profiledetails
{width:50%;}
@media only screen and (device-width:768px){
    .profiledetails
    {width:auto;}
}
table.inv-pro-table tr td:first-child {
    width: 45%!important;
}*/

.accordions_title span:after {
 content: " ";
 background-image: url( images/expand_plus.png);
 width: 28px;
 height: 28px;
 display: block;
 background-position: -5px -5px;
 margin-right: 5px;
 border-radius: 50px;
}

.accordions_title.active span:after {
 background-image: url(images/expand_minus.png);
 width: 28px;
 height: 28px;
 display: block;
 background-position: -5px -5px;
 margin-right: 5px;
 border-radius: 50px;
}

.directoryheader1 header{
    background:#fff !important;
    border:1px solid #ccc !important;
    padding: 10px;
    border-bottom: none !important;
}
.directoryheader1 header h3{
    color: #c09f74 !important;
    font-weight: bold;
        font-size: 18px;
        padding: 0px;

}
.directoryheader1 td span,.directoryheader1 td h6{
color: #535353 !important;
font-size:16px; 
font-weight:200;
}

.directoryheader1 td{
color: #535353 !important;
font-size:16px; 
font-weight:bold;
}
.note-nia {
        position: absolute;
        
        font-size: 13px;
        margin-bottom: 0px;
        padding-top: 7px;
    }
    .work-masonry-thumb.col-2,.work-masonry-thumb.col-3{
        float:left;
        width:48.6%;
        margin: 10px;
    }
    .detailed-title-links{
        padding-bottom: 10px
    }
    .detailed-title-links h2{
        margin-bottom: 0; 
        padding: 18px 0 0;
    }
    .view-detailed{
        padding:0
    }
    /* More Info CSS Change Start */ 
    .com-col.pe-dirdetails {
        background: #fff;
        margin: 10px 10px 6px;
        padding: 20px 10px;
        overflow: auto;
        padding-top: 30px;
    }
    .pe-dirdetails .work-masonry-thumb.col-2,.pe-dirdetails .work-masonry-thumb.col-3 {
        float: left;
        width: 50%;
        margin: 0px;
        margin-bottom: 30px;
    }
    .pe-dirdetails .work-masonry-thumb.col-3.moreinfobox {
        box-sizing: border-box;
        width: 100%;
        margin: 0px;
        margin-bottom: 10px;
    }
    .moreinfobox .tablelistview{
        padding: 10px 20px;
        box-sizing: border-box;
    }
    .moreinfobox .tablelistview td {
        color: #6c6c6c;
        padding: 8px 10px 8px 10px;
    }
    .work-masonry-thumb.moreinfobox td {
        vertical-align: top;
    }
    .moreinfobox .tablelistview p{
        padding: 0px;
    }
    
    .moreinfobox .tablelistview h4{
        min-width: 150px;
    }
    .moreinfobox .tablelistview h4.assert {
        width: 270px;
    }
    .moreinfobox .tablelistview h4.mininvs{
        width: 295px;
    }
    .moreinfobox .tablelistview h4.addinfo{
        min-width: 185px;
    }
    .investor-sec table td {
        padding-left: 10px;
       /* font-size: 16px;*/
       font-size: 14px;
    }
    .investor-sec table th {
       
        font-size: 14px;
    }
    /*12-06-2019*/
    /*.pe-dirdetails table.tableview td:nth-child(3){
        text-align: right;
    }
    .pe-dirdetails table.tableview th:nth-child(3){
        text-align: right;
    }*/
    
    .deal-period
    {
        width:15%;
    }
    .exit-status{
        width:12%;
    }
    /*.inv-pro-table tbody {
    column-count: 2;
    display: block;
}*/
.dirdetail{
    width:50%;
}
.inv-pro-table td:first-child {
    width: 250px;
}
#secondTable td:first-child {
    width: 130px;
}
    /* More Info CSS Change End */
}
</style>
<script>
    $(document).ready(function() {
    var $mainTable = $(".inv-pro-table");
    var count =  Math.round(($('.inv-pro-table tr').length)/2);
    var splitBy = count;
    var rows = $mainTable.find ( "tr" ).slice( splitBy );
    var $secondTable = $(".inv-pro-table").parent().append("<table id='secondTable' class='inv-pro-table dirdetail' '><tbody></tbody></table>");
    $secondTable.find("tbody").append(rows);
    $mainTable.find ( "tr" ).slice( splitBy ).remove();
});
    $(document).ready(function() {
        var max = 0;
        $("#secondTable td:first-child").each(function(){
            if(max < $(this).find('span').width()){
                max = $(this).find('span').width();
            }
        });
        $("#secondTable td:first-child").css("width",max + 50);
        var max1= 0;
        $("#firstTable td:first-child").each(function(){
            if(max1 < $(this).find('span').width()){
                max1 = $(this).find('span').width();
            }
        });
        $("#firstTable td:first-child").css("width",max1 + 20);
    });
</script>
<?php
mysql_close();
mysql_close($cnx);
?>