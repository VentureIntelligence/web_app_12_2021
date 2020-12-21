<?php
//other database
require_once "../dbconnectvi.php";
$Db = new dbInvestments();
//session_save_path("/tmp");
session_start();
//   echo '<div style="display:none;" ><pre>';
//   print_r($_POST);
//   echo '</pre></div>';

if($_POST['tagsearch'] != "" || $_POST['tagsearch_auto'] != ""){
    $_POST['keywordsearch'] = "";
    $_POST['searchallfield'] = "";
    $_POST['investorauto_sug'] = "";
    $_POST['companysearch'] = "";
    $_POST['companyauto_sug'] = "";
    $_POST['advisorsearch_legal'] = "";
    $_POST['advisorsearch_legalauto'] = "";
    $_POST['advisorsearch_trans'] = "";
    $_POST['advisorsearch_transauto'] = "";
    $_POST['stage'] = "";
    $_POST['state'] = "--";
   // $_POST['city'] = "";
   $_POST['city'] = "--";
}

$popup_search = 0;
$listallcompany = $_POST['listallcompanies'];
$all_keyword_other = trim($_POST['all_keyword_other']);
$searchallfield_other = $_POST['searchallfield_other'];
$investorauto_sug_other = $_POST['investorauto_sug_other'];
$keywordsearch_other = $_POST['keywordsearch_other'];
$companyauto_other = $_POST['companyauto_other'];
$companysearch_other = $_POST['companysearch_other'];
$sectorsearch_other = $_POST['sectorsearch_other'];
$advisorsearch_legal_other = $_POST['advisorsearch_legal_other'];
$advisorsearch_trans_other = $_POST['advisorsearch_trans_other'];
$tagandor = $_POST['tagandor'];
$tagradio = $_POST['tagradio'];
$invandor = $_POST['invandor'];
$invradio = $_POST['invradio'];
$state = $_POST['state'];
$city = $_POST['city'];
$investorSearchFlag = $companySearchFlag = $sectorSearchFlag = $legalAdvisorSearchFlag = $transactionAdvisorSearchFlag = false;
if ($all_keyword_other != '') {
    if (isset($keywordsearch_other) && $keywordsearch_other != '') {
        $ex_keywordsearch_other = explode(',', $keywordsearch_other);
        $ex_investorauto_sug_other = explode(',', $investorauto_sug_other); //echo $all_keyword_other;print_r($ex_keywordsearch_other);
        if (!in_array($all_keyword_other, $ex_keywordsearch_other)) {
            if (!in_array($all_keyword_other, $ex_investorauto_sug_other)) {
                $_POST['keywordsearch_other'] = '';
                $_POST['investorauto_sug_other'] = '';
            } else {
                $key = array_search($all_keyword_other, $ex_keywordsearch_other);
                $_POST['keywordsearch_other'] = $ex_investorauto_sug_other[$key];
                $_POST['investorauto_sug_other'] = $all_keyword_other;
                $incubation_from = "yes";
            }
        } else {
            $key = array_search($all_keyword_other, $ex_keywordsearch_other);
            $_POST['keywordsearch_other'] = $all_keyword_other;
            $_POST['investorauto_sug_other'] = $ex_investorauto_sug_other[$key];
        }
    } else if (isset($companyauto_other) && $companyauto_other != '') {
        $ex_companyauto_other = explode(',', $companyauto_other);
        $ex_companysearch_other = explode(',', $companysearch_other);
        if (!in_array($all_keyword_other, $ex_companyauto_other)) {
            $_POST['companyauto_other'] = '';
            $_POST['companysearch_other'] = '';
        } else {
            $key = array_search($all_keyword_other, $ex_companyauto_other);
            $_POST['companyauto_other'] = $all_keyword_other;
            $_POST['companysearch_other'] = $ex_companysearch_other[$key];
        }
    } else if (isset($sectorsearch_other) && $sectorsearch_other != '') {
        $ex_sectorsearch_other = explode(',', $sectorsearch_other);
        if (!in_array($all_keyword_other, $ex_sectorsearch_other)) {
            $_POST['sectorsearch_other'] = '';
        } else {
            $_POST['sectorsearch_other'] = $all_keyword_other;
        }
    } else if (isset($advisorsearch_legal_other) && $advisorsearch_legal_other != '') {
        if ($all_keyword_other != $advisorsearch_legal_other) {
            $_POST['advisorsearch_legal_other'] = '';
        } else {
            $_POST['advisorsearch_legal_other'] = $all_keyword_other;
        }
    } else if (isset($advisorsearch_trans_other) && $advisorsearch_trans_other != '') {
        if ($all_keyword_other != $advisorsearch_trans_other) {
            $_POST['advisorsearch_trans_other'] = '';
        } else {
            $_POST['advisorsearch_trans_other'] = $all_keyword_other;
        }
    } else if (isset($searchallfield_other) && $searchallfield_other != '') {
        $ex_searchallfield_other = explode(',', $searchallfield_other);
    }
}

// OTHER DB SEARCH TRIGGER
if (trim($_POST['investorauto_sug']) || trim($_POST['investorauto_sug_other']) || ($_POST['popup_select'] == 'investor' && trim($_POST['popup_keyword']))) {
    $investorSearchFlag = true;
}
if (trim($_POST['companyauto_sug']) || trim($_POST['companyauto_sug_other']) || ($_POST['popup_select'] == 'company' && trim($_POST['popup_keyword']))) {
    $companySearchFlag = true;
}
if (trim($_POST['sectorsearch']) || trim($_POST['sectorsearch_other']) || ($_POST['popup_select'] == 'sector' && trim($_POST['popup_keyword']))) {
    $sectorSearchFlag = true;
}
if (trim($_POST['advisorsearch_legal']) || trim($_POST['advisorsearch_legal_other']) || ($_POST['popup_select'] == 'legal_advisor' && trim($_POST['popup_keyword']))) {
    $legalAdvisorSearchFlag = true;
}
if (trim($_POST['advisorsearch_trans']) || trim($_POST['advisorsearch_trans_other']) || ($_POST['popup_select'] == 'transaction_advisor' && trim($_POST['popup_keyword']))) {
    $transactionAdvisorSearchFlag = true;
}

//====================junaid============================================================

if (isset($_POST['pe_checkbox']) && !empty($_POST['pe_checkbox'])) {
    $pe_checkbox = explode(',', $_POST['pe_checkbox']);

    if (count($pe_checkbox) <= 0 && !empty($_POST['uncheckRows'])) {

        $pe_checkbox = explode(',', $_POST['uncheckRows']);
    }
} else {
    $pe_checkbox = '';
}

if (isset($_POST['pe_checkbox_enable']) && !empty($_POST['pe_checkbox_enable'])) {

    $pe_checkbox_enable = explode(',', $_POST['pe_checkbox_enable']);

    if (count($pe_checkbox_enable) <= 0 && !empty($_POST['checkedRow'])) {

        $pe_checkbox_enable = explode(',', $_POST['checkedRow']);
    }

    $pe_checkbox = '';
} else {
    $pe_checkbox_enable = '';

}

//=====================================================================================
if (isset($_POST['pe_amount']) && !empty($_POST['pe_amount'])) {
    $pe_amount = $_POST['pe_amount'];
}
if (isset($_POST['pe_company'])) {
    $pe_company = $_POST['pe_company'];
    $peEnableFlag = true;
}

//====================jagadeesh rework===================================================

if (isset($_POST['pe_hide_companies'])) {
    $pe_hide_companies = explode(',', $_POST['pe_hide_companies']);
    $peHideFlagCh = true;
}

//====================================================================================
// if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
//     header('X-UA-Compatible: IE=edge,chrome=1');
//echo "dddddddddddddddddddddddddddddddddd".$max_post = return_bytes(ini_get('post_max_size'));

function emptyhiddendata()
{
    $_POST['total_inv_deal'] = "";
    $_POST['total_inv_amount'] = "";
    $_POST['total_inv_inr_amount'] = "";
    $_POST['total_inv_company'] = "";
}

$drilldownflag = 0;
$companyId = 632270771;
$companyIdDel = 1718772497;
$companyIdSGR = 390958295; //688981071;//
$companyIdVA = 38248720;
$companyIdGlobal = 730002984;
$compId = 0;
$vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : 0;
$VCFlagValue = $vcflagValue;
if ($vcflagValue == 0) {
    $videalPageName = "PEInv";
} elseif ($vcflagValue == 1) {
    $videalPageName = "VCInv";
}
include 'checklogin.php';
 //echo "vc:".$_SESSION['accesserrorpage'];
//echo "check:".$_SESSION['VCcheckflag'];
// echo "flagvalue:".$VCFlagValue;
?>

    
    
        
            <?php if($accesserror ==1 && $VCFlagValue !=1 && ($_SESSION['VCcheckflag']==0 || $_SESSION['VCcheckflag']=="") ){
                header("Location:".BASE_URL."dealsnew/index.php?value=1/");
              
                 $_SESSION['VCcheckflag'] = 1;
            }?>
        
    
<?php


if ($listallcompany != 1) {
    $isAggregate = 'AND pe.SPV=0 and pe.AggHide=0';
} else {
    $isAggregate = '';
}


//include("../survey/survey.php");

/*echo '<div style="display:none;">';
print_r( $_POST );
echo '</div>';*/

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
$getyear = $_REQUEST['y'];
$getsy = $_REQUEST['sy'];
$getey = $_REQUEST['ey'];
$getindus = $_REQUEST['i'];
$getstage = $_REQUEST['s'];
$getinv = $_REQUEST['inv'];
$getreg = $_REQUEST['reg'];
$getrg = $_REQUEST['rg'];
$resetfield = $_POST['resetfield'];
$newArray = array_filter($_POST);
$sub_values = array_values($newArray);

if (isset($_POST[period_flag])) {
    $period_flag = $_POST['period_flag'];
} else {
    $period_flag = 1;
}

if (isset($_POST['popup_select'])) {
    $month1 = 01;
    $year1 = 1998;
    $month2 = date('n');
    $year2 = date('Y');
    $fixstart = $year1;
    $startyear = $fixstart . "-" . $month1 . "-01";
    $fixend = $year2;
    $endyear = $fixend . "-" . $month2 . "-31";
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($getyear != "") {
        $month1 = 01;
        $year1 = $getyear;
        $month2 = 12;
        $year2 = $getyear;
        $fixstart = $year1;
        $startyear = $fixstart . "-" . $month1 . "-01";
        $fixend = $year2;
        $endyear = $fixend . "-" . $month2 . "-31";
    } else if ($getsy != '' && $getey != '') {
        $month1 = 01;
        $year1 = $getsy;
        $month2 = 12;
        $year2 = $getey;
        $fixstart = $year1;
        $startyear = $fixstart . "-" . $month1 . "-01";
        $fixend = $year2;
        $endyear = $fixend . "-" . $month2 . "-31";
        //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
    } else {
        $month1 = date('n');
        $year1 = date('Y', strtotime(date('Y') . " -1  Year"));
        $month2 = date('n');
        $year2 = date('Y');
        $fixstart = date('Y', strtotime(date('Y') . " -1  Year"));
        $startyear = $fixstart . "-" . $month1 . "-01";
        $fixend = date("Y");
        $endyear = date("Y-m-d");
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($resetfield == "period") {
        $month1 = date('n');
        $year1 = date('Y', strtotime(date('Y') . " -1  Year"));
        $month2 = date('n');
        $year2 = date('Y');
        $_POST['month1'] = "";
        $_POST['year1'] = "";
        $_POST['month2'] = "";
        $_POST['year2'] = "";
    } elseif (($resetfield == "searchallfield") || ($resetfield == "sectorsearch") || ($resetfield == "companysearch") || ($resetfield == "advisorsearch_legal") || ($resetfield == "advisorsearch_trans")) {
        emptyhiddendata();
        $month1 = date('n');
        $year1 = date('Y', strtotime(date('Y') . " -1  Year"));
        $month2 = date('n');
        $year2 = date('Y');
        $_POST['month1'] = "";
        $_POST['year1'] = "";
        $_POST['month2'] = "";
        $_POST['year2'] = "";
        $_POST['searchallfield'] = "";
    } else if (trim($_POST['searchallfield']) != "" || trim($_POST['investorauto_sug']) != "" || trim($_POST['companyauto_sug']) != "" || trim($_POST['searchKeywordLeft']) != "" || trim($_POST['searchTagsField']) != "" || trim($_POST['sectorsearch']) != "" || trim($_POST['advisorsearch_legal']) != "" || trim($_POST['advisorsearch_trans']) != "") {
        //echo "ddddddddddddd";
        //   if(trim($_POST['searchallfield'])!=""){
        if (($_POST['month1'] == date('n')) && $_POST['year1'] == date('Y', strtotime(date('Y') . " -1  Year")) && $_POST['month2'] == date('n') && $_POST['year2'] == date('Y')) {

//                        echo "ddddddddddd"
            //                       print_r($_POST);
           // echo $period_flag;
            if ($_POST['tagsfield'] == 1 || ($_POST['searchallfield'] && $period_flag == 2) || ($_POST['investorauto_sug'] && $period_flag == 2) || ($_POST['companyauto_sug'] && $period_flag == 2)) {

                $month1 = ($_POST['month1'] || ($_POST['month1'] != "")) ? $_POST['month1'] : date('n');
                $year1 = ($_POST['year1'] || ($_POST['year1'] != "")) ? $_POST['year1'] : date('Y', strtotime(date('Y') . " -1  Year"));
                $month2 = ($_POST['month2'] || ($_POST['month2'] != "")) ? $_POST['month2'] : date('n');
                $year2 = ($_POST['year2'] || ($_POST['year2'] != "")) ? $_POST['year2'] : date('Y');
            } else {
                $month1 = 01;
                $year1 = 1998;
                $month2 = date('n');
                $year2 = date('Y');
            }

        } else {
            $month1 = ($_POST['month1'] || ($_POST['month1'] != "")) ? $_POST['month1'] : date('n');
            $year1 = ($_POST['year1'] || ($_POST['year1'] != "")) ? $_POST['year1'] : date('Y', strtotime(date('Y') . " -1  Year"));
            $month2 = ($_POST['month2'] || ($_POST['month2'] != "")) ? $_POST['month2'] : date('n');
            $year2 = ($_POST['year2'] || ($_POST['year2'] != "")) ? $_POST['year2'] : date('Y');
        }
        //   }
        //                if(trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!=""){
        //                    $month1=01;
        //                    $year1 = 1998;
        //                    $month2= date('n');
        //                    $year2 = date('Y');
        //                }
    } elseif ((count($_POST['industry']) > 0) || (count($_POST['sector']) > 0)  || (count($_POST['subsector']) > 0) || (count($_POST['stage']) > 0) || (count($_POST['round']) > 0) || ($_POST['comptype'] != "--") || ($_POST['dealtype_debtequity'] != "--")
        || ($_POST['Syndication'] != "--") || (count($_POST['txtregion']) > 0) || ($_POST['citysearch'] != "") || ($_POST['invType'] != "--") || ($_POST['invrangestart'] != "--")
        //|| ($_POST['invrangeend'] != "--") || (count($_POST['exitstatus']) > 0) || (count($_POST['valuations']) > 0 ) || $_POST['tagsearch'] != '' || $_POST['tagsearch_auto'] != '' || $_POST['city'] !="" || $_POST['state'] !="--") {
        || ($_POST['invrangeend'] != "--") || (count($_POST['exitstatus']) > 0) || (count($_POST['valuations']) > 0 ) || $_POST['tagsearch'] != '' || $_POST['tagsearch_auto'] != '' || $_POST['city'] !="--" || $_POST['state'] !="--") {

        if (($_POST['month1'] == date('n')) && $_POST['year1'] == date('Y', strtotime(date('Y') . " -1  Year")) && $_POST['month2'] == date('n') && $_POST['year2'] == date('Y')) {
            //echo $period_flag;
            
            if($period_flag == 2 || $period_flag == 1 ){
                $month1 = $_POST['month1'];
                $year1 = $_POST['year1'];
            } else {
                $month1=01;
                $year1 = 1998;
            }
            
            $month2 = date('n');
            $year2 = date('Y');

        } else {
            $month1 = ($_POST['month1'] || ($_POST['month1'] != "")) ? $_POST['month1'] : date('n');
            $year1 = ($_POST['year1'] || ($_POST['year1'] != "")) ? $_POST['year1'] : date('Y', strtotime(date('Y') . " -1  Year"));
            $month2 = ($_POST['month2'] || ($_POST['month2'] != "")) ? $_POST['month2'] : date('n');
            $year2 = ($_POST['year2'] || ($_POST['year2'] != "")) ? $_POST['year2'] : date('Y');
        }

    } else {
        $month1 = ($_POST['month1'] || ($_POST['month1'] != "")) ? $_POST['month1'] : date('n');
        $year1 = ($_POST['year1'] || ($_POST['year1'] != "")) ? $_POST['year1'] : date('Y', strtotime(date('Y') . " -1  Year"));
        $month2 = ($_POST['month2'] || ($_POST['month2'] != "")) ? $_POST['month2'] : date('n');
        $year2 = ($_POST['year2'] || ($_POST['year2'] != "")) ? $_POST['year2'] : date('Y');
    }

    $fixstart = $year1;
    $startyear = $fixstart . "-" . $month1 . "-01";
    $fixend = $year2;
    $endyear = $fixend . "-" . $month2 . "-31";

}

if ($getyear != '') {
    $getdt1 = $getyear . '-01-01';
    $getdt2 = $getyear . '-12-31';
    //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
}
if ($getsy != '' && $getey != '') {
    $getdt1 = $getsy . '-01-01';
    $getdt2 = $getey . '-12-31';
    //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
}
if ($getindus != '') {
    $isql = "select industryid,industry from industry where industry='" . $getindus . "'";
    $irs = mysql_query($isql);
    $irow = mysql_fetch_array($irs);
    $geti = $irow['industryid'];
    $getind = " and pec.industry=" . $geti;
}
if ($getstage != '') {
    $ssql = "select StageId,Stage from stage where Stage='" . $getstage . "'";
    $srs = mysql_query($ssql);
    $srow = mysql_fetch_array($srs);
    $gets = $srow['StageId'];
    $getst = " and pe.StageId=" . $gets;
}
if ($getinv != '') {
    $invsql = "select InvestorType,InvestorTypeName from investortype where Hide=0 and InvestorTypeName='" . $getinv . "'";
    $invrs = mysql_query($invsql);
    $invrow = mysql_fetch_array($invrs);
    $getinv = $invrow['InvestorType'];
    $getinvest = " and pe.InvestorType = '" . $getinv . "'";
}
if ($getreg != '') {
    if ($getreg == 'empty') {
        $getreg = '';
    } else {
        $getreg;
    }
    $regsql = "select RegionId,Region from region where Region='" . $getreg . "'";
    $regrs = mysql_query($regsql);
    $regrow = mysql_fetch_array($regrs);
    $getreg = $regrow['RegionId'];
    $getregion = " and pec.RegionId  =" . $getreg . " and pec.RegionId IS NOT NULL";
}
if ($getrg != '') {
    if ($getrg == '200+') {
        $getrange = " and pe.amount > 200";
    } else {
        $range = explode("-", $getrg);
        $getrange = " and pe.amount > " . $range[0] . " and pe.amount <= " . $range[1] . "";
    }

}
$TrialSql = "select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm   where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
if ($trialrs = mysql_query($TrialSql)) {
    while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
        $exportToExcel = $trialrow["TrialLogin"];
        $compId = $trialrow["compid"];
    }
}
/*if ($exportToExcel == 0) {
    if ($_POST['valuations'] == "") {
        $_POST['valuations'][0] = "Revenue_Multiple";
    }
}*/
if ($compId == $companyId) {
    $hideIndustry = " and display_in_page=1 ";

} elseif ($compId == $companyIdDel) {
    $hideIndustry = " and display_in_page=2 ";
} elseif ($compId == $companyIdSGR) {
    $hideIndustry = " and (industryid=3 or industryid=24) ";
} elseif ($compId == $companyIdVA) {
    $hideIndustry = " and (industryid=1 or industryid=3) ";
} else if ($compId == $companyIdGlobal) {
    $hideIndustry = " and (industryid=24) ";
} else {
    $hideIndustry = "";
}

$invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";
if ($vcflagValue == 0) {
    $addVCFlagqry = " and pec.industry !=15 ";
    $checkForStage = ' && (' . '$stage' . ' =="--")';
    $view_table = "PEnew_portfolio_cos";
    //$checkForStage = " && (" .'$stage'."=='--') ";
    $checkForStageValue = " || (" . '$stage' . ">0) ";
    $searchTitle = "List of PE Investments ";
    $searchAggTitle = "Aggregate Data - PE Investments ";
    $aggsql = "select count(PEId) as totaldeals,sum(amount) as totalamount from peinvestments as pe,
            pecompanies as pec,industry as i where ";
    /*$samplexls="../Sample_Sheet_Investments.xls";*/
    $samplexls = "../Sample sheet.xlsx";
} elseif ($vcflagValue == 1) {
    $addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and pe.amount <=20 ";
    $view_table = 'VCnew_portfolio_cos';
    $checkForStage = '&& (' . '$stage' . '=="--") ';
    //$checkForStage = " && (" .'$stage'."=='--') ";
    $checkForStageValue = " || (" . '$stage' . ">0) ";
    $searchTitle = "List of VC Investments ";
    $searchAggTitle = "Aggregate Data - VC Investments ";
    $aggsql = "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
            FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  ";
    $samplexls = "../xls/Sample_Sheet_Investments(VC Deals).xls";
    //    echo "<br>Check for stage** - " .$checkForStage;
}
if($_POST['filtersector'] != ''){
    $filtersector = $_POST['filtersector'];
} else {
    $filtersector = '';
}

if($_POST['filtersubsector'] != ''){
    $filtersubsector = $_POST['filtersubsector'];
} else {
    $filtersubsector = '';
}


if ($vcflagValue == 0) {
    $getTotalQuery = "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
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
    $pagetitle = "PE Investments -> Search";
    $stagesql_search = "select StageId,Stage from stage ";
    
    if($_POST['filtersector'] != ''){
        $sectorsql = "select sector_id,sector_name from pe_sectors where sector_id IN ($filtersector) order by sector_name ";
    }
    if($_POST['filtersubsector'] != ''){
        $subsectorsql = "select DISTINCT(subsector_name) from pe_subsectors where subsector_id IN ($filtersubsector) AND subsector_name != '' order by subsector_name";
    }
    if ($_SESSION['DcompanyId'] != 269229159) {
        $industrysql_search = "select industryid,industry from industry where industryid IN (" . $_SESSION['PE_industries'] . ")" . $hideIndustry . " order by industry";
    } else {
        $industrysql_search = "select industryid,industry from industry where industryid IN (" . $_SESSION['PE_industries'] . ") and industryid =3" . $hideIndustry . " order by industry";
    }

    // echo "<br>***".$industrysql;
} elseif ($vcflagValue == 1) {
    $getTotalQuery = "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                 FROM peinvestments AS pe, stage AS s ,pecompanies as pec
                 WHERE s.VCview =1 and  pe.amount<=20 and pec.industry !=15 and pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId
                 and pe.Deleted=0
                 and
                 pe.PEId NOT
                         IN (
                         SELECT PEId
                         FROM peinvestments_dbtypes AS db
                         WHERE DBTypeId =  'SV'
                         AND hide_pevc_flag =1
                         )  ";
    $pagetitle = "VC Investments -> Search";
    $stagesql_search = "select StageId,Stage from stage where VCview=1 ";
    if($_POST['filtersector'] != ''){
        $sectorsql = "select sector_id,sector_name from pe_sectors where sector_id IN ($filtersector) order by sector_name ";
    }
    if($_POST['filtersubsector'] != ''){
        $subsectorsql = "select DISTINCT(subsector_name) from pe_subsectors where subsector_id IN ($filtersubsector) AND subsector_name != '' order by subsector_name";
    }
    if ($_SESSION['DcompanyId'] != 269229159) {
        $industrysql_search = "select industryid,industry from industry where industryid IN (" . $_SESSION['PE_industries'] . ")" . $hideIndustry . " order by industry";
    } else {
        $industrysql_search = "select industryid,industry from industry industryid IN (" . $_SESSION['PE_industries'] . ")" . $hideIndustry . " order by industry";
    }

    //echo "<Br>---" .$getTotalQuery;
}
if ($totalrs = mysql_query($getTotalQuery)) {
    while ($myrow = mysql_fetch_array($totalrs, MYSQL_BOTH)) {
        $totDeals = $myrow["totaldeals"];
        $totDealsAmount = $myrow["totalamount"];
    }
}

$dbTypeSV = "SV";
$dbTypeIF = "IF";
$dbTypeCT = "CT";
$addDelind = "";

if ($compId == $companyIdDel) {
    $addDelind = " and (pec.industry=9 or pec.industry=24)";
}
if ($compId == $companyIdSGR) {
    $addDelind = " and (pec.industry=3 or pec.industry=24)";
}
if ($compId == $companyIdVA) {
    $addDelind = " and (pec.industry=1 or pec.industry=3)";
}
if ($compId == $companyIdGlobal) {
    $addDelind = " and (pec.industry=24)";
}

$addDelindhidden = preg_replace('/\s+/', '_', $addDelind);

$searchString = "Undisclosed";
$searchString = strtolower($searchString);

$searchString1 = "Unknown";
$searchString1 = strtolower($searchString1);

$buttonClicked = $_POST['hiddenbutton'];
$fetchRecords = true;
$totalDisplay = "";

if ($resetfield == "refcloseall") {
    $_POST['investments'] = "";
    $_POST['industry'] = "--";
    $_POST['sector'] = "--";
    $_POST['comptype'] = "--";
    $_POST['dealtype_debtequity'] = "--";
    $_POST['txtregion'] = "--";
    $_POST['invType'] = "--";
    $_POST['stage'] = "";
    $_POST['round'] = "--";
    $_POST['citysearch'] = "";
    $_POST['invrangestart'] = "";
    $_POST['invrangeend'] = "";
    $_POST['keywordsearch'] = "";
    $_POST['companysearch'] = "";
    $_POST['sectorsearch'] = "";
    $_POST['advisorsearch_legal'] = "";
    $_POST['advisorsearch_trans'] = "";
}

if ($resetfield == "searchallfield") {
    $_POST['searchallfield'] = "";
    $_POST['searchKeywordLeft'] = "";
    $_POST['searchTagsField'] = "";
    $searchallfield = "";
    emptyhiddendata();
} else {
    if (isset($_POST['searchallfield']) && trim($_POST['searchallfield']) != '') {
        $searchallfield = trim($_POST['searchallfield']);
    } else if (isset($_POST['searchKeywordLeft']) && $_POST['searchKeywordLeft'] != '') {
        $searchallfield = trim($_POST['searchKeywordLeft']);
    } else if ($_POST['searchallfieldHide'] != '') {
        $searchallfield = '';
    } else if ($_POST['popup_select'] == '' && $_POST['popup_keyword'] != '') {
        $searchallfield = trim($_POST['popup_keyword']);
    }
    if ($searchallfield != "") {
        $_POST['keywordsearch'] = "";
        $_POST['investorauto_sug'] = "";
        $_POST['companysearch'] = "";
        $_POST['companyauto_sug'] = "";
        $_POST['sectorsearch'] = "";
        $_POST['sectorauto'] = "";
        $_POST['advisorsearch_legal'] = "";
        $_POST['advisorsearch_legalauto'] = "";
        $_POST['advisorsearch_trans'] = "";
        $_POST['advisorsearch_transauto'] = "";
        $_POST['tagsearch'] = "";
        $_POST['tagsearch_auto'] = "";
    }
}
$searchallfieldhidden = preg_replace('/\s+/', '_', $searchallfield);

if ($resetfield == "keywordsearch") {
 //    $_POST['keywordsearch'] = "";
    // $_POST['popup_keyword'] = "";
 //    $_POST['investorauto_sug'] = "";
 //    $keyword = "";
 //    $keywordhidden = "";
 //    $investorauto = '';
    $investorarray = explode(',', $_POST['investorauto_sug']);
    $pos = array_search($_POST['resetfieldid'], $investorarray);
    $keyword = $investorarray;
    unset($keyword[$pos]);
    $keyword = implode(',', $keyword);
        // $_POST['keywordsearch'] = $keyword;
        // $_POST['popup_keyword'] = $keyword;
        $_POST['investorauto_sug'] = $keyword;
        // $keyword = $keyword;
        $keywordhidden = $keyword;
        $investorauto = $keyword;

    if ($incubation_from == "yes") {
        $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where Investor like '$keyword' order by InvestorId";
    } else {
        $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
    }

    $sql_investorauto_sug_Exe = mysql_query($sql_investorauto_sug);
    // print_r($getInvestorSql_Exe);
    $response = array();
    $invester_filter = "";
    $i = 0;
    while ($myrow = mysql_fetch_array($sql_investorauto_sug_Exe, MYSQL_BOTH)) {
        if ($incubation_from == "yes") {
            $investorauto = $myrow['id'];
        }
        $response[$i]['id'] = $myrow['id'];
        $response[$i]['name'] = $myrow['name'];
        if ($i != 0) {

            $invester_filter .= ",";
            $invester_filter_id .= ",";
        }
        $invester_filter .= $myrow['name'];
        $invester_filter_id .= $myrow['id'];
        $i++;

    }
    if ($response != '') {
        $investorsug_response = json_encode($response);
    } else {
        $investorsug_response = 'null';
    }

    if ($_POST['keywordsearch'] != '') {
        $searchallfield = '';
    }

} else {
    $keyword1 = trim($_POST['keywordsearch']);
    if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'investor') {
        $investorauto = $keyword = trim(implode(',', $_POST['search_multi']));
        $keywordhidden = trim($_POST['popup_keyword']);
    } else if (isset($_POST['investorauto_sug_other'])) {
        $investorauto = $_POST['investorauto_sug_other'];
        $keyword = trim($_POST['investorauto_sug_other']);
        $keywordhidden = preg_replace('/\s+/', '_', $keyword);
        // $month1 = 01;
        // $year1 = 1998;
        // $month2 = date('n');
        // $year2 = date('Y');
        // $dt1 = $startyear = $year1 . "-" . $month1 . "-01";
    } else if ($_POST['searchallfieldHide'] == 'remove' || $_POST['searchallfieldHide'] != 'content_exit') {
        if (isset($_POST['investorauto_sug'])) {
            $investorauto = $keyword = trim($_POST['investorauto_sug']);
            $keywordhidden = trim($_POST['investorauto_sug']);
        } else {
            $investorauto = $keyword = $keywordhidden = '';
        }
    } else if ($_POST['searchallfieldHide'] == '' && isset($_POST['investorauto_sug'])) {
        $investorauto = $keyword = trim($_POST['investorauto_sug']);
        $keywordhidden = trim($_POST['investorauto_sug']);
    } else {
        $investorauto = $keyword = $keywordhidden = '';
    }
    if ($incubation_from == "yes") {
        $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where Investor like '$keyword' order by InvestorId";
    } else {
        $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
    }

    $sql_investorauto_sug_Exe = mysql_query($sql_investorauto_sug);
    // print_r($getInvestorSql_Exe);
    $response = array();
    $invester_filter = "";
    $i = 0;
    while ($myrow = mysql_fetch_array($sql_investorauto_sug_Exe, MYSQL_BOTH)) {
        if ($incubation_from == "yes") {
            $investorauto = $myrow['id'];
        }
        $response[$i]['id'] = $myrow['id'];
        $response[$i]['name'] = $myrow['name'];
        if ($i != 0) {

            $invester_filter .= ",";
            $invester_filter_id .= ",";
        }
        $invester_filter .= $myrow['name'];
        $invester_filter_id .= $myrow['id'];
        $i++;

    }
    if ($response != '') {
        $investorsug_response = json_encode($response);
    } else {
        $investorsug_response = 'null';
    }

    if ($_POST['keywordsearch'] != '') {
        $searchallfield = '';
    }

}
$keywordhidden = preg_replace('/\s+/', '_', $keywordhidden);

if ($resetfield == "companysearch") {
    $arrayval=explode(",",$_POST['companyauto_sug']);
    $pos = array_search($_POST['resetfieldid'], $arrayval);
    $companysearch = $arrayval;
    unset($companysearch[$pos]);
    $companysearch=implode(",",$companysearch);
    $_POST['companysearch'] = $companysearch;
   
    /*$_POST['companysearch'] = "";
    $_POST['popup_keyword'] = "";
    $_POST['companyauto_sug'] = "";
    $companysearch = "";
    $companyauto = '';*/
    //echo $companysearch;

    $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";
    $sql_company_Exe = mysql_query($sql_company);
    $company_filter = "";
    $response = array();
    $i = 0;
    while ($myrow = mysql_fetch_array($sql_company_Exe, MYSQL_BOTH)) {

        $response[$i]['id'] = $myrow['id'];
        $response[$i]['name'] = $myrow['name'];
        if ($i != 0) {

            $company_filter .= ",";
            $company_id .= ",";
        }
        $company_filter .= $myrow['name'];
        $company_id .=$myrow['id'];
        $i++;

    }
    if ($response != '') {
        $companysug_response = json_encode($response);
    } else {
        $companysug_response = 'null';
    }
    if ($companysearch != '') {
        $searchallfield = '';
        $month1 = 01;
        $year1 = 1998;
        $month2 = date('n');
        $year2 = date('Y');
        $dt1 = $startyear = $year1 . "-" . $month1 . "-01";
    }

    //$companysearchhidden = preg_replace('/\s+/', '_', $companysearch);
} else {
    $companysearch = trim($_POST['companysearch']);
    $companyauto = $_POST['companyauto_sug'];
    if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'company') {
        //$companysearch=trim($_POST['popup_keyword']);
        $companyauto = $companysearch = trim(implode(',', $_POST['search_multi']));

        $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";

        $sql_company_Exe = mysql_query($sql_company);
        $company_filter = "";
        $response = array();
        $i = 0;
        while ($myrow = mysql_fetch_array($sql_company_Exe, MYSQL_BOTH)) {

            $response[$i]['id'] = $myrow['id'];
            $response[$i]['name'] = $myrow['name'];
            if ($i != 0) {

                $company_filter .= ",";
                $company_id .= ",";
            }
            $company_filter .= $myrow['name'];
            $company_id .=$myrow['id'];
            $i++;

        }
    } else if (isset($_POST['companyauto_sug_other']) && $_POST['companyauto_sug_other'] != '') {
        $companyauto = $_POST['companyauto_sug_other'];
        $companysearch = trim($_POST['companyauto_sug_other']);
        $companysearchhidden = preg_replace('/\s+/', '_', $companysearch);
        $month1 = 01;
        $year1 = 1998;
        $month2 = date('n');
        $year2 = date('Y');
        $dt1 = $startyear = $year1 . "-" . $month1 . "-01";
    } else if ($_POST['searchallfieldHide'] == 'remove' || $_POST['searchallfieldHide'] != 'content_exit') {
        if (isset($_POST['companyauto_sug'])) {
            $companyauto = $companysearch = trim($_POST['companyauto_sug']);
            $companysearchhidden = trim($_POST['companyauto_sug']);
        } /*else {
            $companyauto = $companysearch = $companysearchhidden = '';
        }*/
    } else if ($_POST['searchallfieldHide'] == '' && isset($_POST['companyauto_sug'])) {
        $companyauto = $companysearch = trim($_POST['companyauto_sug']);
        $companysearchhidden = trim($_POST['companyauto_sug']);
    }
    $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";
    $sql_company_Exe = mysql_query($sql_company);
    $company_filter = "";
    $response = array();
    $i = 0;
    while ($myrow = mysql_fetch_array($sql_company_Exe, MYSQL_BOTH)) {

        $response[$i]['id'] = $myrow['id'];
        $response[$i]['name'] = $myrow['name'];
        if ($i != 0) {

            $company_filter .= ",";
            $company_id .= ",";
        }
        $company_filter .= $myrow['name'];
        $company_id .=$myrow['id'];
        $i++;

    }
    if ($response != '') {
        $companysug_response = json_encode($response);
    } else {
        $companysug_response = 'null';
    }
    if ($companysearch != '') {
        $searchallfield = '';
    }

   
}
 $companysearchhidden = preg_replace('/\s+/', '_', $companysearch);
if ($resetfield == "sectorsearch") {
    $_POST['sectorsearch'] = "";
    $_POST['popup_keyword'] = "";
    $sectorsearch = "";
} else {
    $sectorsearch = stripslashes(trim($_POST['sectorsearch']));
    if ($sectorsearch != '') {
        $searchallfield = '';
    } else if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'sector') {
        $sectorsearch = trim($_POST['popup_keyword']);
        $response = array();
        /* $sql_sector = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";

    $sql_company_Exe=mysql_query($sql_sector);
    $sectors_filter="";
    $i = 0;
    While($myrow = mysql_fetch_array($$sql_sector_Exe,MYSQL_BOTH)){

    if($i!=0){

    $sectors_filter.=",";
    }
    $sectors_filter.=$myrow['name'];
    $i++;

    }*/
    } else if (isset($_POST['sectorsearch_other']) && $_POST['sectorsearch_other'] != '') {
        $sectorsearch = $_POST['sectorsearch_other'];
        $sectorsearchhidden = preg_replace('/\s+/', '_', $sectorsearch);
        $month1 = 01;
        $year1 = 1998;
        $month2 = date('n');
        $year2 = date('Y');
        $dt1 = $startyear = $year1 . "-" . $month1 . "-01";
    }
}
$sectorsearchhidden = preg_replace('/\s+/', '_', $sectorsearch);

if ($resetfield == "advisorsearch_legal") {
    $_POST['advisorsearch_legal'] = "";
    $_POST['popup_keyword'] = "";
    $advisorsearchstring_legal = "";
} else {
    $advisorsearchstring_legal = trim($_POST['advisorsearch_legal']);
    if ($advisorsearchstring_legal != '') {
        $searchallfield = '';
    } else if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'legal_advisor') {
        $advisorsearchstring_legal_id = trim($_POST['popup_keyword']);

        $advisorsql = "select cianame from advisor_cias where cianame='$advisorsearchstring_legal_id'";
        if ($advisorrs = mysql_query($advisorsql)) {
            while ($myrow = mysql_fetch_array($advisorrs, MYSQL_BOTH)) {
                $legal_filter = $advisorsearchstring_legal = $myrow["cianame"];
            }
        }

    } else if (isset($_POST['advisorsearch_legal_other']) && $_POST['advisorsearch_legal_other'] != '') {
        $advisorsearchstring_legal = $_POST['advisorsearch_legal_other'];
        $month1 = 01;
        $year1 = 1998;
        $month2 = date('n');
        $year2 = date('Y');
        $dt1 = $startyear = $year1 . "-" . $month1 . "-01";
    }
}
$advisorsearchhidden_legal = preg_replace('/\s+/', '_', $advisorsearchstring_legal);

if ($resetfield == "advisorsearch_trans") {
    $_POST['advisorsearch_trans'] = "";
    $_POST['popup_keyword'] = "";
    $advisorsearchstring_trans = "";
} else {
    $advisorsearchstring_trans = trim($_POST['advisorsearch_trans']);
    if ($advisorsearchstring_trans != '') {
        $searchallfield = '';
    } else if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'transaction_advisor') {
        $advisorsearchstring_trans_id = trim($_POST['popup_keyword']);

        $advisorsql = "select cianame from advisor_cias where cianame='$advisorsearchstring_trans_id'";

        if ($advisorrs = mysql_query($advisorsql)) {
            while ($myrow = mysql_fetch_array($advisorrs, MYSQL_BOTH)) {
                $transaction_filter = $advisorsearchstring_trans = $myrow["cianame"];
            }
        }
    } else if (isset($_POST['advisorsearch_trans_other']) && $_POST['advisorsearch_trans_other'] != '') {
        $advisorsearchstring_trans = $_POST['advisorsearch_trans_other'];
        $month1 = 01;
        $year1 = 1998;
        $month2 = date('n');
        $year2 = date('Y');
        $dt1 = $startyear = $year1 . "-" . $month1 . "-01";
    }
}
$advisorsearchhidden_trans = preg_replace('/\s+/', '_', $advisorsearchstring_trans);

if ($resetfield == "industry") {
    
    $pos = array_search($_POST['resetfieldid'], $_POST['industry']);
    $industry = $_POST['industry'];
    unset($industry[$pos]);
    // $_POST['industry'] = "";
    // $industry = array();
    $_POST['filtersector'] = "";$_POST['filtersubsector'] = "";$_POST['sector'] = "";$_POST['subsector'] = "";
    $filtersubsector = '';$filtersector = '';
    emptyhiddendata();
} else {
    $industry = $_POST['industry'];
    if ($industry != '--' && count($industry) > 0) {
        $searchallfield = '';
    }
}

if ($resetfield == "sector") {
     $pos = array_search($_POST['resetfieldid'], $_POST['sector']);
    $sector = $_POST['sector'];
    unset($sector[$pos]);
   // $_POST['sector'] = "";
    $_POST['subsector'] = "";
    $_POST['filtersubsector'] = "";
    $filtersubsector = '';
    emptyhiddendata();
} else {
    $sector = $_POST['sector'];
    if ($sector != '--' && count($sector) > 0) {
        $searchallfield = '';
    }
}

if ($resetfield == "subsector") {
     $pos = array_search($_POST['resetfieldid'], $_POST['subsector']);
     $subsector = $_POST['subsector'];
     unset($subsector[$pos]);
    //$_POST['subsector'] = "";
    emptyhiddendata();
} else {
    $subsector = $_POST['subsector'];
    if ($subsector != '--' && count($subsector) > 0) {
        $searchallfield = '';
    }
}
// if ($resetfield == "state") {
//                 $pos = array_search($_POST['resetfieldid'], $_POST['state']);
//                 $state = $_POST['state'];
//                 unset($state[$pos]);
//                 /*$_POST['filtersector'] = "";$_POST['filtersubsector'] = "";$_POST['sector'] = "";$_POST['subsector'] = "";
//                 $filtersubsector = '';$filtersector = '';*/
//                 emptyhiddendata();
//             } else {
//                 $state = $_POST['state'];
//                 if ($state != '--' && count($state) > 0) {
//                     $searchallfield = '';
//                 }
//             }

//         if($resetfield=="city")
//             { 
//                 $_POST['city']="";
//                 $cityid ="";
//                 $cityname="";
//                 emptyhiddendata();
//             }
//             else 
//             {
//                 $cityid = $_POST['city'];
//             }
//             if($cityid != ''){
           
//                 if($cityid == '--'){
//                     $cityname = "All City";
//                 } else {
//                     $citysql= "select city_name from city where city_id = $cityid";
               
//                     if ($citytype = mysql_query($citysql))
//                     {
//                         While($myrow = mysql_fetch_array($citytype, MYSQL_BOTH))
//                         {
//                             $cityname = ucwords(strtolower($myrow["city_name"] ));
                        
//                         }
//                     }
//                 }
//             }
if ($resetfield == "state") {
    $pos = array_search($_POST['resetfieldid'], $_POST['state']);
    $state = $_POST['state'];
    $city = $_POST['city'];
    if(count($state)==1 && count($city)>0)
    {
        foreach ($city as $key => $row) { 

            
                 unset($city[$key]);  
           
        }
        $_POST['city']=$city;
        
    }
    unset($state[$pos]);
    /*$_POST['filtersector'] = "";$_POST['filtersubsector'] = "";$_POST['sector'] = "";$_POST['subsector'] = "";
    $filtersubsector = '';$filtersector = '';*/
    emptyhiddendata();
} else {
    $state = $_POST['state'];
    if ($state != '--' && count($state) > 0) {
        $searchallfield = '';
    }
}
// Edited for multi select city
if ($resetfield == "city") {
$pos = array_search($_POST['resetfieldid'], $_POST['city']);
$city = $_POST['city'];
unset($city[$pos]);
emptyhiddendata();
} else {
$city = $_POST['city'];
//print_r($city);
if ( count($city) > 0) {
$searchallfield = '';

}
}

if ( (count($city) > 0)) {
//print_r($city);
$cityindusSql = $cityvalue = '';$cityvalueid = '';
foreach ($city as $cities) {
$cityindusSql .= " city_id=$cities or ";
}
//echo $cityindusSql;
$cityindusSql = trim($cityindusSql, ' or ');
$citysql = "select city_id,city_name from city where $cityindusSql";

if ($citys = mysql_query($citysql)) {
while ($myrow = mysql_fetch_array($citys, MYSQL_BOTH)) {
    $cityvalue .= $myrow["city_name"] . ',';
    $cityvalueid .= $myrow["city_id"] . ',';
}
}
$cityvalue = trim($cityvalue, ',');
$cityvalueid = trim($cityvalueid, ',');
$city_hide = implode($city, ',');

// print_r($cityvalue);
// exit();
}
// End Multi selected city


if ($state != '' && (count($state) > 0)) {
            $indusSql = $statevalue = '';$statevalueid = '';
            foreach ($state as $states) {
                $indusSql .= " state_id=$states or ";
            }
            $indusSql = trim($indusSql, ' or ');
            $statesql = "select state_name,state_id from state where $indusSql";

            if ($staters = mysql_query($statesql)) {
                while ($myrow = mysql_fetch_array($staters, MYSQL_BOTH)) {
                    $statevalue .= $myrow["state_name"] . ',';
                    $statevalueid .= $myrow["state_id"] . ',';
                }
            }
            $statevalue = trim($statevalue, ',');
            $statevalueid = trim($statevalueid, ',');
            $state_hide = implode($state, ',');
        }
        /*Year Founded*/
        if($resetfield=="yearfounded")
        { 
            $_POST['yearafter']="";
            $_POST['yearbefore']="";
            $yearafter="";
            $yearbefore="";
            emptyhiddendata();
        }
        else 
        {
            $yearafter=trim($_POST['yearafter']);
            $yearbefore=trim($_POST['yearbefore']);
           /* if($yearafter != NULL && $yearafter !='' && $yearbefore != NULL && $yearbefore !=''){*/
            if($yearafter !='' ||  $yearbefore !=''){
                $searchallfield='';
            }

        }

if ($resetfield == "stage") {
    $pos = array_search($_POST['resetfieldid'], $_POST['stage']);
    
    $stageval = $_POST['stage'];
     if($_POST['stage'] == ""){

     $stageval = "--";
     }
    unset($stageval[$pos]);
     // if($_POST['stage'] == ""){

     // $stageval = "--";
     // }
    emptyhiddendata();
} else {
    $stageval = $_POST['stage'];
    if ($stageval != '') {
        $searchallfield = '';
    }
}

if ($_POST['stage'] && $stageval != "" && $stageval != "--") {
    
    $boolStage = true;
    //foreach($stageval as $stage)
    //    echo "<br>----" .$stage;
} else {
     
    $stage = "--";
    $boolStage = false;
}


// Round
if ($resetfield == "round") {
    $pos = array_search($_POST['resetfieldid'], $_POST['round']);
   // print_r($round);
    $round = $_POST['round'];
    unset($round[$pos]);

    //$_POST['round'] = "";
    //$round = array();
    emptyhiddendata();
} else {
    $round = $_POST['round'];
    if (count($round) > 0) {
        $searchallfield = '';
    }
}
if ($exportToExcel == 0) {
    $trialuserload=$_POST['trialuserload'];
    if($trialuserload==0){
     if ($_POST['valuations'] == "") {
            $_POST['valuations'][0] = "Revenue_Multiple";
             $trialuserload=1;
            }     
        }
        else {
           if($_POST['valuationcheck']!=1 && $_POST['valuations'][0] == "Revenue_Multiple"){
            echo "adf";

             $_POST['valuations']='';
           // $_POST['valuations']=$_POST['valuations'];
           }else{
            $_POST['valuations']=$_POST['valuations'];
           }
            
        }
}



//valuation
if ($resetfield == "valuations") {
 
    $pos = array_search($_POST['resetfieldid'], $_POST['valuations']);
    $valuations = $_POST['valuations'];
    
     if($_POST['valuations'] == ""){

         $valuations = "--";
     }

    unset($valuations[$pos]);
 
   emptyhiddendata();
} else {

     
$valuations = $_POST['valuations'];
   if($valuations != '') {
        $searchallfield = '';
    }
}

if ($_POST['valuations'] && $valuations != "" && $valuations != "--") {
    $boolvaluations = true;
     $c = 1;
    foreach ($valuations as $v) {
        if ($c > 1) {$coa = ',';}
        $valuationstxt .= "$coa $v";
        $c++;
    }
    
} else {
    $valuations = "--";
    $boolvaluations = false;
}

//echo "<br>**" .$stage;
if ($resetfield == "comptype") {
    $_POST['comptype'] = "";
    $companyType = "--";
    emptyhiddendata();
} else {
    $companyType = trim($_POST['comptype']);
    if ($companyType != '--' && $companyType != '') {
        $searchallfield = '';
    }
}

if ($resetfield == "dealtype_debtequity") {
    $_POST['dealtype_debtequity'] = "";
    $debt_equity = "--";
    $listallcompany = "";
    emptyhiddendata();
} else {
    $debt_equity = trim($_POST['dealtype_debtequity']);
    if ($debt_equity != '--' && $debt_equity != '') {
        $searchallfield = '';
    }
}
if ($resetfield == "syndication") {

    $_POST['Syndication'] = "";
    $syndication = "--";
    emptyhiddendata();
} else {
    $syndication = trim($_POST['Syndication']);
    if ($syndication != '--' && $syndication != '') {
        $searchallfield = '';
    }
}
if ($resetfield == "dealsinvolving") {
    if (count($_POST['dealsinvolving']) > 0) {
          
        foreach ($_POST['dealsinvolving'] as $dealsinvolvingvaltag) {
            
            if ($dealsinvolvingvaltag == 1) {

                $dealsinvolvingfiltertag .= 'New Investor, ';

            } else if ($dealsinvolvingvaltag == 2) {

                $dealsinvolvingfiltertag .= 'Existing Investor, ';

            } else {
                $dealsinvolvingfiltertag = '';
            }
        }
        $dealsinvolvingfiltertag = trim($dealsinvolvingfiltertag, ', ');
    }
    $dealsarraytag = explode(",",$dealsinvolvingfiltertag); 
    $pos = array_search($_POST['resetfieldid'],$dealsarraytag);
    $dealsinvolvingvalue = $_POST['dealsinvolving'];
    unset($dealsinvolvingvalue[$pos]);
    emptyhiddendata();
 } else {
    $dealsinvolvingvalue = $_POST['dealsinvolving'];
    if (count($dealsinvolvingvalue) > 0) {
        $searchallfield = '';
    }
 }
if ($resetfield == "invType") {
    $_POST['invType'] = "";
    $investorType = "--";
    emptyhiddendata();
} else {
    $investorType = $_POST['invType'];
    if ($investorType != '--' && $investorType != '') {
        $searchallfield = '';
    }
}
if ($resetfield == "invhead") {
    $_POST['invhead'] = "";
    $investor_head = "--";
    emptyhiddendata();
} else {
    $investor_head = $_POST['invhead'];
    if ($investor_head != '--' && $investor_head != '') {
        $searchallfield = '';
    }
}

if ($resetfield == "txtregion") {
    /*$_POST['txtregion'] = "";
    $regionId = array();*/
     $pos = array_search($_POST['resetfieldid'], $_POST['txtregion']);
    
    $regionId = $_POST['txtregion'];
    unset($regionId[$pos]);
    emptyhiddendata();
} else {
    $regionId = $_POST['txtregion'];
    if (count($regionId) > 0) {
        $searchallfield = '';
    }
}

// if ($resetfield == "city") {
//     $_POST['citysearch'] = "";
//     $city = "";
//     emptyhiddendata();
// } else {
//     $city = trim($_POST['citysearch']);
//     if ($city != null) {
//         $searchallfield = '';
//     }
// }

if ($resetfield == "range") {
    $_POST['invrangestart'] = "";
    $_POST['invrangeend'] = "";
    $startRangeValue = "";
    $endRangeValue = "";
    $regionId = array();
    emptyhiddendata();
} else {
    $startRangeValue = $_POST['invrangestart'];
    $endRangeValue = $_POST['invrangeend'];
   // if ($startRangeValue != "--" && $endRangeValue != "--" && $startRangeValue != "" && $endRangeValue != "") {
    if ($startRangeValue != "" && $endRangeValue != "") {
        $searchallfield = '';
    }
}
$endRangeValueDisplay = $endRangeValue;
//echo "<br>Stge**" .$range refcloseall;

if ($resetfield == "exitstatus") {
     $pos = array_search($_POST['resetfieldid'], $_POST['exitstatus']);
    
    $exitstatusValue = $_POST['exitstatus'];

    unset($exitstatusValue[$pos]);
    
    /*$_POST['exitstatus'] = "";
    $exitstatusValue = array();*/
    emptyhiddendata();
} else {
    $exitstatusValue = $_POST['exitstatus'];
    if (count($exitstatusValue) > 0) {
        $searchallfield = '';
    }
}

$whereind = "";
$whereregion = "";
$whereinvType = "";
$wherestage = "";
$wheredates = "";
$whererange = "";
$wherelisting_status = "";
$whereexitstatus = "";

$whereaddHideamount = "";

if (isset($_POST['searchallfield_other']) && $_POST['searchallfield_other'] != '') {
    $searchallfield = $_POST['searchallfield_other'];
    $searchallfieldhidden = preg_replace('/\s+/', '_', $searchallfield);
    $month1 = 01;
    $year1 = 1998;
    $month2 = date('n');
    $year2 = date('Y');
}

if (isset($_POST['sectorsearch_other']) && $_POST['sectorsearch_other'] != '') {
    $sectorsearch = $_POST['sectorsearch_other'];
    $sectorsearchhidden = preg_replace('/\s+/', '_', $sectorsearch);
    $month1 = 01;
    $year1 = 1998;
    $month2 = date('n');
    $year2 = date('Y');
}

if ($_POST['popup_select'] == '' && $_POST['popup_keyword'] != '') {
    $searchallfield = trim($_POST['popup_keyword']);
} elseif ($_POST['popup_select'] == 'exact' && $_POST['popup_keyword'] != '') {
    $searchallfield = trim($_POST['popup_keyword']);
}
$searchallfieldhidden = preg_replace('/\s+/', '_', $searchallfield);

// if($resetfield=="tagsearch")
// {
//     $_POST['tagsearch']="";
//     $tagsearch="";emptyhiddendata();
// }elseif($_POST['tagsearch']  && $_POST['tagsearch'] !=''){

//     $tagsearch="tag:".trim($_POST['tagsearch']);

// }else if(isset($_POST['searchTagsField']) && trim($_POST['searchTagsField']) !=''){

//     $tagsearch=trim($_POST['searchTagsField']);
//     $_POST['tagsearch'] = trim($_POST['searchTagsField']);
// }else if($_POST['popup_select'] == 'tags' && $_POST['popup_keyword'] !=''){

//     $tagsearch="tag:".trim($_POST['popup_keyword']);
//     $_POST['tagsearch'] = $_POST['popup_keyword'];
// }

if ($resetfield == "tagsearch") {
    $arrayval=explode(",",$_POST['tagsearch']);
    $pos = array_search($_POST['resetfieldid'], $arrayval);
    $tagsearch = $arrayval;
    unset($tagsearch[$pos]);
    $tagsearch = implode(",",$tagsearch);
    /*$_POST['tagsearch'] = "";
    $_POST['tagsearch_auto'] = "";
    $tagsearch = "";*/
    if($tagsearch == ""){
    $tagandor = 0;
    }else{
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
} else if (isset($_POST['searchTagsField']) && trim($_POST['searchTagsField']) != '') {
    $tagsearch = trim($_POST['searchTagsField']);
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
} else if ($_POST['popup_select'] == 'tags' && $_POST['popup_keyword'] != '') {
    $tagsearch = trim($_POST['popup_keyword']);
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
if ($boolvaluations == true) {
    $valuationsql = '';

    $count = count($valuations);
    foreach ($valuations as $v) {
       $coa = ' and ';
        $valuationsql .= " pe.$v!=0 $coa";
        
    }
    //$valuationsql.= trim($valuationsql," and ");
    
    /*if ($count == 1) {$valuationsql = "pe.$valuations[0]!=0 AND ";} else if ($count == 2) {$valuationsql = "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0   AND ";} else if ($count == 3) {$valuationsql = "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0  AND  pe.$valuations[2]!=0  AND ";} else if ($count == 4) {$valuationsql = "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0  AND  pe.$valuations[2]!=0  AND   pe.$valuations[3]!=0  AND ";}*/
//            $valuattext =substr_replace($valuattext, '', 0,1);
    //echo $valuationsql; exit();
} else { $valuationsql = '';}
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

$datevalue = returnMonthname($month1) . "-" . $year1 . "to" . returnMonthname($month2) . "-" . $year2;
$splityear1 = (substr($year1, 2));
$splityear2 = (substr($year2, 2));

if (($month1 != "--") && ($month2 !== "--") && ($year1 != "--") && ($year2 != "--")) {
    $sdatevalueDisplay1 = returnMonthname($month1) . " " . $splityear1;
    $edatevalueDisplay2 = returnMonthname($month2) . "  " . $splityear2;
    $wheredates1 = "";
}

$datevalueDisplay1 = $sdatevalueDisplay1;
$datevalueDisplay2 = $edatevalueDisplay2;

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
                 amount,pe.Amount_INR, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
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
    $exportSplitSql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business,
                 amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
                 pec.region,pe.PEId,pe.comment,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId ,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
                                 (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                 FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
                                 WHERE dates between '" . $getdt1 . "' and '" . $getdt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                            " . $getind . " " . $getst . " " . $getinvest . " " . $getregion . " " . $getrange . " and pe.Deleted=0" . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . " AND pe.PEId NOT
                                            IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )" . $comp_industry_id_where;
    $exportSplitGroup = " GROUP BY pe.PEId";
    $orderby = "dates";
    $ordertype = "desc";
    // } else {
    //     $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business,
    //                             amount,pe.Amount_INR, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
    //                             pec.region,pe.PEId,pe.comment,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId ,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
    //                                             (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                             FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
    //                                             WHERE dates between '" . $getdt1 . "' and '" . $getdt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
    //                                                        " . $getind . " " . $getst . " " . $getinvest . " " . $getregion . " " . $getrange . " and pe.Deleted=0 and pe.SPV=0 and pe.AggHide=0" . $addVCFlagqry . " " . $addDelind . " AND pe.PEId NOT
    //                                                        IN (
    //                                                            SELECT PEId
    //                                                            FROM peinvestments_dbtypes AS db
    //                                                            WHERE hide_pevc_flag =1
    //                                                            )
    //                                                            $comp_industry_id_where
    //                                                        GROUP BY pe.PEId ";
    //     $exportSplitSql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business,
    //                             amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
    //                             pec.region,pe.PEId,pe.comment,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId ,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
    //                                             (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                             FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
    //                                             WHERE dates between '" . $getdt1 . "' and '" . $getdt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
    //                                                        " . $getind . " " . $getst . " " . $getinvest . " " . $getregion . " " . $getrange . " and pe.Deleted=0 and pe.SPV=0 and pe.AggHide=0" . $addVCFlagqry . " " . $addDelind . " AND pe.PEId NOT
    //                                                        IN (
    //                                                            SELECT PEId
    //                                                            FROM peinvestments_dbtypes AS db
    //                                                            WHERE hide_pevc_flag =1
    //                                                            )" . $comp_industry_id_where;
    //     $exportSplitGroup = " GROUP BY pe.PEId";
    //     $orderby = "dates";
    //     $ordertype = "desc";

    // }
    //echo "<br>all dashboard" .$companysql;
} else if (!$_POST) {

    $yourquery = 0;
    $stagevaluetext = "";
    $industry = array();

    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    //echo "<br>Query for all records";
    if ($listallcompany != 1) {
        $isAggregate = 'AND pe.SPV=0 and pe.AggHide=0';
    } else {
        $isAggregate = '';
    }

//     $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
//                           amount,pe.Amount_INR, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
//                           pec.region,pe.PEId,pe.comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide,pe.dates as dates,pe.Exit_Status,pe_s.sector_name,pe_sub.subsector_name,pe_sub.Additional_subsector,
//                           (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
//                           FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,peinvestments_investors as peinv_inv,peinvestors as inv,pe_subsectors as pe_sub,pe_sectors as pe_s
//                           WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
//                           and pe.Deleted=0 $isAggregate AND peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId 
// and pec.PEcompanyID=pe_sub.PECompanyID and pe_s.sector_id=pe_sub.sector_id " . $addVCFlagqry . " " . $addDelind . " AND pe.PEId NOT
//                              IN (
//                              SELECT PEId
//                              FROM peinvestments_dbtypes AS db
//                              WHERE DBTypeId = '$dbTypeSV'
//                              AND hide_pevc_flag =1
//                              )
//                             $comp_industry_id_where
//                                 GROUP BY pe.PEId ";
//         $exportSplitSql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
//     amount,pe.Amount_INR, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
//     pec.region,pe.PEId,pe.comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide,pe.dates as dates,pe.Exit_Status,pe_s.sector_name,pe_sub.subsector_name,pe_sub.Additional_subsector,
//     (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
//     FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,peinvestments_investors as peinv_inv,peinvestors as inv,pe_subsectors as pe_sub,pe_sectors as pe_s
//     WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
//     and pe.Deleted=0 $isAggregate AND peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId 
// and pec.PEcompanyID=pe_sub.PECompanyID and pe_s.sector_id=pe_sub.sector_id" . $addVCFlagqry . " " . $addDelind . " AND pe.PEId NOT
//        IN (
//        SELECT PEId
//        FROM peinvestments_dbtypes AS db
//        WHERE DBTypeId = '$dbTypeSV'
//        AND hide_pevc_flag =1
//        )" . $comp_industry_id_where;

    $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR, round, s.stage,  stakepercentage, 
    DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,pec.region,pe.PEId,pe.comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide,pe.dates as dates,pe.Exit_Status,
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

        $exportSplitSql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR, round, s.stage,  stakepercentage, 
    DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,pec.region,pe.PEId,pe.comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide,pe.dates as dates,pe.Exit_Status,
    (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
    JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
    JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
    JOIN industry AS i ON pec.industry = i.industryid
    JOIN stage AS s ON s.StageId=pe.StageId
    WHERE pe.dates between '" . $dt1 . "' and '" . $dt2 . "'
    and pe.Deleted=0 $isAggregate " . $addVCFlagqry . " " . $addDelind . "  
    AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = '$dbTypeSV' AND hide_pevc_flag =1)
    $comp_industry_id_where";

        $exportSplitGroup = " GROUP BY pe.PEId ";
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

    $companysql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
                            pe.amount, pe.Amount_INR, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
                            pec.website, pec.city, pec.region, pe.PEId,
                            pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
                            (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                            FROM peinvestments AS pe, industry AS i,
                            pecompanies AS pec,stage as s,
                            peinvestments_investors as peinv_invs,peinvestors as invs
                            WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                            AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
                            AND pe.PEId NOT
                            IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId =  '$dbTypeSV'
                            AND hide_pevc_flag =1
                            )
                            $comp_industry_id_where GROUP BY pe.PEId ";

    $exportSplitSql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
                            pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
                            pec.website, pec.city, pec.region, pe.PEId,
                            pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
                            (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                            FROM peinvestments AS pe, industry AS i,
                            pecompanies AS pec,stage as s,
                            peinvestments_investors as peinv_invs,peinvestors as invs
                            WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                            AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
                            AND pe.PEId NOT
                            IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId =  '$dbTypeSV'
                            AND hide_pevc_flag =1
                            )" . $comp_industry_id_where;
    $exportSplitGroup = " GROUP BY pe.PEId ";
    $orderby = "dates";
    $ordertype = "desc";
    $popup_search = 1;
    // } else {
    //     $companysql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
    //                         pe.amount,pe.Amount_INR, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
    //                         pec.website, pec.city, pec.region, pe.PEId,
    //                         pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
    //                         (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                         FROM peinvestments AS pe, industry AS i,
    //                         pecompanies AS pec,stage as s,
    //                         peinvestments_investors as peinv_invs,peinvestors as invs
    //                         WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
    //                         AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0  and pe.SPV=0 and pe.AggHide=0 " . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
    //                         AND pe.PEId NOT
    //                         IN (
    //                         SELECT PEId
    //                         FROM peinvestments_dbtypes AS db
    //                         WHERE DBTypeId =  '$dbTypeSV'
    //                         AND hide_pevc_flag =1
    //                         )
    //                         $comp_industry_id_where GROUP BY pe.PEId ";

    //     $exportSplitSql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
    //                         pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
    //                         pec.website, pec.city, pec.region, pe.PEId,
    //                         pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
    //                         (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                         FROM peinvestments AS pe, industry AS i,
    //                         pecompanies AS pec,stage as s,
    //                         peinvestments_investors as peinv_invs,peinvestors as invs
    //                         WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
    //                         AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0  and pe.SPV=0 and pe.AggHide=0" . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
    //                         AND pe.PEId NOT
    //                         IN (
    //                         SELECT PEId
    //                         FROM peinvestments_dbtypes AS db
    //                         WHERE DBTypeId =  '$dbTypeSV'
    //                         AND hide_pevc_flag =1
    //                         )" . $comp_industry_id_where;
    //     $exportSplitGroup = " GROUP BY pe.PEId ";
    //     $orderby = "dates";
    //     $ordertype = "desc";
    //     $popup_search = 1;
    // }
    //mysql_query("insert in to search_operations (user_id,user_name,keyword_search,PE,CFS) values(".$_SESSION['UserEmail'].",".$_SESSION['UserNames'].",".$searchallfield.",1,0");
    //echo "<bR>---" .$companysql;
} elseif ($searchallfield != "") {
    $yourquery = 1;
    $industry = array();
    $stagevaluetext = "";
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";
    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";

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
            /* $cityLike .= "pec.city LIKE '$searchFieldExp%' AND ";
            $companyLike .= "pec.companyname LIKE '%$searchFieldExp%' AND ";
            $sectorLike .= "sector_business LIKE '%$searchFieldExp%' AND ";
            $moreInfoLike .= "MoreInfor LIKE '%$searchFieldExp%' AND ";
            $investorLike .= "invs.investor LIKE '%$searchFieldExp%' AND ";
            $industryLike .= "i.industry LIKE '%$searchFieldExp%' AND ";
            $websiteLike .= "pec.website LIKE '%$searchFieldExp%' AND ";*/
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

    // $companysql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
    //                             pe.amount, pe.Amount_INR, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
    //                             pec.website, pec.city, pec.region, pe.PEId,
    //                             pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
    //                                             (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                             FROM peinvestments AS pe, industry AS i,
    //                             pecompanies AS pec,stage as s,
    //                                             peinvestments_investors as peinv_invs,peinvestors as invs
    //                             WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
    //                             AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
    //                             AND pe.PEId NOT
    //                                             IN (
    //                                             SELECT PEId
    //                                             FROM peinvestments_dbtypes AS db
    //                                             WHERE DBTypeId =  '$dbTypeSV'
    //                                             AND hide_pevc_flag =1
    //                                             )
    //                                             $comp_industry_id_where GROUP BY pe.PEId ";

  

    // $exportSplitSql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
    //                             pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
    //                             pec.website, pec.city, pec.region, pe.PEId,
    //                             pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,
    //                                             (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                             FROM peinvestments AS pe, industry AS i,
    //                             pecompanies AS pec,stage as s,
    //                                             peinvestments_investors as peinv_invs,peinvestors as invs
    //                             WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
    //                             AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 $isAggregate" . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
    //                             AND pe.PEId NOT
    //                                             IN (
    //                                             SELECT PEId
    //                                             FROM peinvestments_dbtypes AS db
    //                                             WHERE DBTypeId =  '$dbTypeSV'
    //                                             AND hide_pevc_flag =1
    //                                             )" . $comp_industry_id_where;

     $companysql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,pe.amount, pe.Amount_INR, pe.round, s.Stage,  
                    pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,pec.website, pec.city, pec.region, pe.PEId,pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,(SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                JOIN industry AS i ON pec.industry = i.industryid
                JOIN stage AS s ON s.StageId=pe.StageId
                WHERE pe.dates between '" . $dt1 . "' and '" . $dt2 . "' and pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
                AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1) $comp_industry_id_where
                GROUP BY pe.PEId ";

    $exportSplitSql = "SELECT distinct pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,pe.amount, pe.Amount_INR, pe.round, s.Stage,  
                    pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,pec.website, pec.city, pec.region, pe.PEId,pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,pe.SPV,pe.AggHide,pe.dates as dates,pe.Exit_Status,(SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                JOIN industry AS i ON pec.industry = i.industryid
                JOIN stage AS s ON s.StageId=pe.StageId
                WHERE pe.dates between '" . $dt1 . "' and '" . $dt2 . "' and pe.Deleted =0  $isAggregate" . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval)
                AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1) $comp_industry_id_where";


    $exportSplitGroup = " GROUP BY pe.PEId ";
    $orderby = "dates";
    $ordertype = "desc";
    $popup_search = 1;

    //mysql_query("insert in to search_operations (user_id,user_name,keyword_search,PE,CFS) values(".$_SESSION['UserEmail'].",".$_SESSION['UserNames'].",".$searchallfield.",1,0");
    //echo "<bR>---" .$companysql;
} elseif ($companysearchadas != "") {
    $yourquery = 1;
    $industry = array();
    $stagevaluetext = "";
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";

    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";

   
    $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
                                pe.amount,pe.Amount_INR, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
                                pec.website, pec.city, pec.region, pe.PEId,
                                pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,SPV,AggHide,pe.dates as dates ,pe.Exit_Status,
                                                (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                                FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s
                                                WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                AND pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " AND  pec.PECompanyId IN ($companysearch)  AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                )
                                                $comp_industry_id_where
                                                GROUP BY pe.PEId ";
    $exportSplitSql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
                                pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
                                pec.website, pec.city, pec.region, pe.PEId,
                                pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,SPV,AggHide,pe.dates as dates ,pe.Exit_Status,
                                                (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                                FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s
                                                WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                AND pe.Deleted =0 " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . " AND  pec.PECompanyId IN ($companysearch)  AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                )" . $comp_industry_id_where;
    $exportSplitGroup = " GROUP BY pe.PEId ";
    $orderby = "dates";
    $ordertype = "desc";
    $popup_search = 1;

    //    echo "<br>Query for company search";
             //echo $companysql;
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

    /*
    $companysql="SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
    pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,pec.website, pec.city, pec.region, pe.PEId,
    pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,SPV,AggHide,pe.dates as dates ,pe.Exit_Status,
    (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    FROM peinvestments AS pe, industry AS i,
    pecompanies AS pec,stage as s
    WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
    AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND  sector_business IN ($sectorsearch)   AND pe.PEId NOT
    IN (
    SELECT PEId
    FROM peinvestments_dbtypes AS db
    WHERE DBTypeId =  '$dbTypeSV'
    AND hide_pevc_flag =1
    ) GROUP BY pe.PEId";
     */


    $companysql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
                pe.amount,pe.Amount_INR, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,pec.website, pec.city, pec.region, pe.PEId,
                pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,SPV,AggHide,pe.dates as dates ,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                FROM peinvestments AS pe, industry AS i,
                pecompanies AS pec,stage as s
                WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                AND pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " AND  ($sector_filter)   AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )
                                $comp_industry_id_where
                                GROUP BY pe.PEId ";

    $exportSplitSql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,
                pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,pec.website, pec.city, pec.region, pe.PEId,
                pe.COMMENT,pe.MoreInfor,pe.hideamount,pe.hidestake,pe.StageId,SPV,AggHide,pe.dates as dates ,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others')  FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                FROM peinvestments AS pe, industry AS i,
                pecompanies AS pec,stage as s
                WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                AND pe.Deleted =0 " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . " AND  ($sector_filter)   AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )" . $comp_industry_id_where;
    $exportSplitGroup = " GROUP BY pe.PEId ";

    $orderby = "dates";
    $ordertype = "desc";
    $popup_search = 1;

    //    echo "<br>Query for company search";
    //         echo "<br> sector search--" .$companysql;
} elseif ($keywordsasf != "") {
    $yourquery = 1;
    $industry = array();
    $stagevaluetext = "";
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";

    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    if ($_GET["newCos"] != "") {
        $wherenewCos = " AND pec.PECompanyId IN (SELECT DISTINCT(PECompanyId) FROM " . $view_table . " AS newCos WHERE deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=" . $keyword . " ) ";
        $groupby = " GROUP BY pe.PECompanyId";
    } else {
        $wherenewCos = '';
        $groupby = " GROUP BY pe.PEId";
    }
    if ($incubation_from == "yes") {
        
        $companysql = "select pe.PECompanyId as PECompanyId,pec.companyname,pec.industry,i.industry as industry,sector_business as sector_business,pe.amount,pe.Amount_INR,
                                    peinv_invs.InvestorId,peinv_invs.PEId,invs.Investor,pe.PECompanyId,pec.industry,
                                    pec.companyname,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,hideamount,SPV,AggHide,pe.dates as dates,pe.Exit_Status,
                                    (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                    from peinvestments as pe,pecompanies as pec,industry as i,stage as s,peinvestments_investors as peinv_invs,peinvestors as invs
                                    where dates between '" . $dt1 . "' and '" . $dt2 . "' AND  pec.industry = i.industryid and  pe.StageId=s.StageId and peinv_invs.PEId=pe.PEId and invs.InvestorId=peinv_invs.InvestorId AND pe.Deleted=0
                                    and pec.PECompanyId=pe.PECompanyId " . $addVCFlagqry . " " . $addDelind . " AND invs.Investor like '$keyword'
                                    AND pe.PEId NOT
                                    IN (
                                    SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId =  '$dbTypeSV'
                                    AND hide_pevc_flag =1
                                    )
                                    $comp_industry_id_where
                                    GROUP BY pe.PEId ";
        $exportSplitSql = "select pe.PECompanyId as PECompanyId,pec.companyname,pec.industry,i.industry as industry,sector_business as sector_business,pe.amount,
                                    peinv_invs.InvestorId,peinv_invs.PEId,invs.Investor,pe.PECompanyId,pec.industry,
                                    pec.companyname,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,hideamount,SPV,AggHide,pe.dates as dates,pe.Exit_Status,
                                    (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                    from peinvestments as pe,pecompanies as pec,industry as i,stage as s,peinvestments_investors as peinv_invs,peinvestors as invs
                                    where dates between '" . $dt1 . "' and '" . $dt2 . "' AND  pec.industry = i.industryid and  pe.StageId=s.StageId and peinv_invs.PEId=pe.PEId and invs.InvestorId=peinv_invs.InvestorId AND pe.Deleted=0
                                    and pec.PECompanyId=pe.PECompanyId " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . " AND invs.Investor like '$keyword'
                                    AND pe.PEId NOT
                                    IN (
                                    SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId =  '$dbTypeSV'
                                    AND hide_pevc_flag =1
                                    )" . $comp_industry_id_where;
        $exportSplitGroup = " GROUP BY pe.PEId ";

    } else {
        
        $companysql = "select pe.PECompanyId as PECompanyId,pec.companyname,pec.industry,i.industry as industry,sector_business as sector_business,pe.amount,pe.Amount_INR,
                                    peinv_invs.InvestorId,peinv_invs.PEId,invs.Investor,pe.PECompanyId,pec.industry,
                                    pec.companyname,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,hideamount,SPV,AggHide,pe.dates as dates,pe.Exit_Status,
                                    (SELECT GROUP_CONCAT( inv.Investor   ORDER BY inv.InvestorId IN ($keyword) desc) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                    from peinvestments as pe,pecompanies as pec,industry as i,stage as s,peinvestments_investors as peinv_invs,peinvestors as invs
                                    where dates between '" . $dt1 . "' and '" . $dt2 . "' AND  pec.industry = i.industryid and  pe.StageId=s.StageId and peinv_invs.PEId=pe.PEId and invs.InvestorId=peinv_invs.InvestorId AND pe.Deleted=0
                                    and pec.PECompanyId=pe.PECompanyId " . $addVCFlagqry . " " . $addDelind . " AND invs.InvestorId IN($keyword)
                                    AND pe.PEId NOT
                                    IN (
                                    SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId =  '$dbTypeSV'
                                    AND hide_pevc_flag =1
                                    )
                                    " . $wherenewCos . "
                                    $comp_industry_id_where
                                    " . $groupby . "";

        $exportSplitSql = "select pe.PECompanyId as PECompanyId,pec.companyname,pec.industry,i.industry as industry,sector_business as sector_business,pe.amount,
                                    peinv_invs.InvestorId,peinv_invs.PEId,invs.Investor,pe.PECompanyId,pec.industry,
                                    pec.companyname,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,hideamount,SPV,AggHide,pe.dates as dates,pe.Exit_Status,
                                    (SELECT GROUP_CONCAT( inv.Investor   ORDER BY inv.InvestorId IN ($keyword) desc) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                    from peinvestments as pe,pecompanies as pec,industry as i,stage as s,peinvestments_investors as peinv_invs,peinvestors as invs
                                    where dates between '" . $dt1 . "' and '" . $dt2 . "' AND  pec.industry = i.industryid and  pe.StageId=s.StageId and peinv_invs.PEId=pe.PEId and invs.InvestorId=peinv_invs.InvestorId AND pe.Deleted=0
                                    and pec.PECompanyId=pe.PECompanyId " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . " AND invs.InvestorId IN($keyword)
                                    AND pe.PEId NOT
                                    IN (
                                    SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId =  '$dbTypeSV'
                                    AND hide_pevc_flag =1
                                    )" . $wherenewCos . "
                                    $comp_industry_id_where
                                    " . $groupby . "";
        /*$exportSplitGroup = " GROUP BY pe.PEId ";*/

    }
    $orderby = "dates";
    $ordertype = "desc";
    $popup_search = 1;

    //echo "<br> Investor search- ".$companysql;
} elseif ($advisorsearchstring_legalold != "") {
    $stagevaluetext = "";
    $yourquery = 1;
    $industry = array();
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";

    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";

   

    $companysql = "(
                SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,pe.Amount_INR,
                                cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND   pe.Deleted=0 and pec.industry = i.industryid
                AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
                AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
                AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                ) $comp_industry_id_where GROUP BY pe.PEId  )
                UNION (
                SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,pe.Amount_INR,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pe.Deleted=0 and pec.industry = i.industryid
                AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
                AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
                AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )
                                $comp_industry_id_where
                                GROUP BY pe.PEId )";
    $exportSplitSql = "(
                SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
                                cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                peinvestments_advisorinvestors AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND   pe.Deleted=0 and pec.industry = i.industryid
                AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
                AND adac.PEId = pe.PEId " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
                AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )" . $comp_industry_id_where;
    $exportSplitGroup = " GROUP BY pe.PEId  )";
    $exportSplitSql1 = "UNION (
                SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                peinvestments_advisorcompanies AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pe.Deleted=0 and pec.industry = i.industryid
                AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
                AND adac.PEId = pe.PEId " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
                AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )" . $comp_industry_id_where;
    $exportSplitGroup1 = " GROUP BY pe.PEId )";
    $orderby = "companyname";
    $ordertype = "asc";
    $popup_search = 1;
    // } else {
    //     $companysql = "(
    //                                     SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,pe.Amount_INR,
    //                                                     cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
    //                                                     (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                     FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
    //                                     peinvestments_advisorinvestors AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND   pe.Deleted=0 and SPV=0 and AggHide=0  and pec.industry = i.industryid
    //                                     AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
    //                                     AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
    //                                     AND pe.PEId NOT
    //                                                     IN (
    //                                                     SELECT PEId
    //                                                     FROM peinvestments_dbtypes AS db
    //                                                     WHERE DBTypeId = '$dbTypeSV'
    //                                                     AND hide_pevc_flag =1
    //                                                     ) $comp_industry_id_where GROUP BY pe.PEId  )
    //                                     UNION (
    //                                     SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,pe.Amount_INR,
    //                                                      cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
    //                                                     (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                     FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
    //                                     peinvestments_advisorcompanies AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pe.Deleted=0 and SPV=0 and AggHide=0 and pec.industry = i.industryid
    //                                     AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
    //                                     AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
    //                                     AND pe.PEId NOT
    //                                                     IN (
    //                                                     SELECT PEId
    //                                                     FROM peinvestments_dbtypes AS db
    //                                                     WHERE DBTypeId = '$dbTypeSV'
    //                                                     AND hide_pevc_flag =1
    //                                                     )
    //                                                     $comp_industry_id_where
    //                                                     GROUP BY pe.PEId )";
    //     $exportSplitSql = "(
    //                                     SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
    //                                                     cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
    //                                                     (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                     FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
    //                                     peinvestments_advisorinvestors AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND   pe.Deleted=0 and SPV=0 and AggHide=0 and pec.industry = i.industryid
    //                                     AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
    //                                     AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
    //                                     AND pe.PEId NOT
    //                                                     IN (
    //                                                     SELECT PEId
    //                                                     FROM peinvestments_dbtypes AS db
    //                                                     WHERE DBTypeId = '$dbTypeSV'
    //                                                     AND hide_pevc_flag =1
    //                                                     )" . $comp_industry_id_where;
    //     $exportSplitGroup = " GROUP BY pe.PEId  )";
    //     $exportSplitSql1 = "UNION (
    //                                     SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
    //                                                      cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
    //                                                     (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                     FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
    //                                     peinvestments_advisorcompanies AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND pe.Deleted=0 and SPV=0 and AggHide=0 and pec.industry = i.industryid
    //                                     AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
    //                                     AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
    //                                     AND pe.PEId NOT
    //                                                     IN (
    //                                                     SELECT PEId
    //                                                     FROM peinvestments_dbtypes AS db
    //                                                     WHERE DBTypeId = '$dbTypeSV'
    //                                                     AND hide_pevc_flag =1
    //                                                     )" . $comp_industry_id_where;
    //     $exportSplitGroup1 = " GROUP BY pe.PEId )";
    //     $orderby = "companyname";
    //     $ordertype = "asc";
    //     $popup_search = 1;
    // }
    //echo "<br>LEGAL -".$companysql;
} elseif ($advisorsearchstring_trans != "" || $advisorsearchstring_legal != "") {
     if ($advisorsearchstring_trans != ""){
    $transtype='T';
    $advisorName=$advisorsearchstring_trans;
   }else{
    $transtype='L';
    $advisorName=$advisorsearchstring_legal;
   }
    if (count($industry) > 0) {
        $indusSql = '';
        foreach ($industry as $industrys) {
            $indusSql .= " pec.industry=$industrys or ";
        }
        $indusSql = trim($indusSql, ' or ');
        if ($indusSql != '') {
            $whereind = 'and ( ' . $indusSql . ' ) ';
        }
        else{
            $whereind = '';
        }
       /* $qryIndTitle = "Industry - ";*/
    }
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

   if (count($sector) > 0 && $sector !="") {
        $sectorString = implode(',',$sector);
        $wheresectorsql = "and pe_sub.sector_id IN($sectorString) ";
    }else{
         $wheresectorsql = "";
    }
    
    if (count($subsector) > 0 && $subsector !="") {
        foreach ($subsector as $value){ 
            $subsectorString .= "'".$value."'" . ',';
        } 
        $subsectorString = trim($subsectorString, ',');
        $wheresubsectorsql = "and pe_sub.subsector_name IN($subsectorString)";
    }
    else{
            $wheresubsectorsql = '';
        }

    
    //
    if (count($round) > 0) {
        $roundSql = '';
        foreach ($round as $rounds) {
            $roundSql .= " pe.round LIKE '" . $rounds . "' or  pe.round LIKE '" . $rounds . "%' or pe.round LIKE '%" . $rounds . "%' or";
        }
        if ($roundSql != '') {
            $whereRound = 'and (' . trim($roundSql, ' or ') . ')';
        }else{
            $whereRound = '';
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
            $whereregion = 'and (' . $regionSqlStr . ')';
        }else{
            $whereregion = '';
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
    if ($investorType != "--" && $investorType != '') {
        $qryInvType = "Investor Type - ";
        $whereInvType = "and  pe.InvestorType = '" . $investorType . "'";
    }else{
        $whereInvType = "";
    }
    if ($investor_head != "--" && $investor_head != '') {
           $whereInvhead = "and  inv.countryid = '" . $investor_head . "'";
    }    
    else{
        $whereInvhead = "";
    }
    if ($boolStage == true) {
        $stagevalue = "";
        $stageidvalue = "";
        foreach ($stageval as $stage) {
            //echo "<br>****----" .$stage;
            $stagevalue = $stagevalue . " pe.StageId=" . $stage . " or ";
            $stageidvalue = $stageidvalue . "," . $stage;
        }

        $wherestage = $stagevalue;
        $qryDealTypeTitle = "Stage  - ";
        $strlength = strlen($wherestage);
        $strlength = $strlength - 3;
        $wherestage = substr($wherestage, 0, $strlength);
        if($wherestage !=""){
        $wherestage = "and (" . $wherestage . ")";
    }

    }
     else{
        $wherestage = "";
    }
    if (($startRangeValue != "--") && ($endRangeValue != "") && ($startRangeValue != "") && ($endRangeValue != "--")) {
        $startRangeValue = $startRangeValue;
       // $endRangeValue = $endRangeValue - 0.01;
        $qryRangeTitle = "Deal Range (M$) - ";
        if ($startRangeValue < $endRangeValue) {
            //$whererange = "and pe.amount between  " . $startRangeValue . " and " . $endRangeValue;
            $whererange = " pe.amount >=  ".$startRangeValue ." and  pe.amount <". $endRangeValue ."";
        } elseif (($startRangeValue = $endRangeValue)) {
            $whererange = "and pe.amount >= " . $startRangeValue;
        }
    } else if ($startRangeValue == "--" && $endRangeValue > 0) {
        $startRangeValue = 0;
       // $endRangeValue = $endRangeValue - 0.01;
        //$whererange = "and  pe.amount between  " . $startRangeValue . " and " . $endRangeValue;
        $whererange = " pe.amount >=  ".$startRangeValue ." and  pe.amount <". $endRangeValue ."";
    }
    else{
        $whererange = "";
    }
    //echo "<Br>***".$whererange;
    if ($exitstatusValue != '' && $exitstatusValue != '--' && count($exitstatusValue) > 0) {
        foreach ($exitstatusValue as $exitstatusValues) {
            if ($exitstatusValues != '--' && $exitstatusValues != '') {
                $exitstatusSql .= " Exit_Status  = '" . $exitstatusValues . "' or ";
            }
        }
        $whereexitstatus = trim($exitstatusSql, ' or ');
        if ($whereexitstatus != '') {
            $whereexitstatus = 'and (' . $whereexitstatus . ')';
        }
        $exitstatusValue_hide = implode($exitstatusValue, ',');
    }
    else{
        $exitstatusValue_hide = "";
    }

   
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";

    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    
    $companysql = "(
                                    SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount,pe.Amount_INR,
                                                     cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                                    (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
                                                    (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount
                                    FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                    peinvestments_advisorinvestors AS adac,stage as s ".$joinsectortable. " WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND   pe.Deleted=0 and pec.industry = i.industryid
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
                                                     cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                                    (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor,
                                                    (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE   peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount
                                    FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                    peinvestments_advisorcompanies AS adac,stage as s  ".$joinsectortable. " 
                                                    WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' and pe.Deleted=0 and pec.industry = i.industryid
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
    $exportSplitSql = "(
                                    SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount,
                                                     cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                                    (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                    FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                    peinvestments_advisorinvestors AS adac,stage as s  ".$joinsectortable. "  WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND   pe.Deleted=0 and pec.industry = i.industryid
                                    AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID 
                                   and 
$valuationsql  $sectorcondition adac.PEId = pe.PEId " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind .$whereind.$wheresectorsql.$wheresubsectorsql.$whereRound.$whereregion.$whereCity. $wherelisting_status.$whereSPVdebt.$whereInvType. $wherestage .$whererange.$whereexitstatus .$whereInvhead. " AND cia.cianame LIKE '%$advisorName%'  and AdvisorType='".$transtype."'
                                    AND pe.PEId NOT
                                                    IN (
                                                    SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE DBTypeId = '$dbTypeSV'
                                                    AND hide_pevc_flag =1
                                                    )" . $comp_industry_id_where;
    $exportSplitGroup = " GROUP BY pe.PEId ".$wheresyndication.")";
    $exportSplitSql1 = "UNION (
                                    SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
                                                     cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                                    (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
                                    FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                    peinvestments_advisorcompanies AS adac,stage as s  ".$joinsectortable. " 
                                                    WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' and pe.Deleted=0 and pec.industry = i.industryid
                                    AND pec.PECompanyId = pe.PECompanyId
                                    AND adac.CIAId = cia.CIAID 
                                    and 
$valuationsql  $sectorcondition adac.PEId = pe.PEId " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind .$whereind.$wheresectorsql.$wheresubsectorsql.$whereRound.$whereregion.$whereCity. $wherelisting_status.$whereSPVdebt.$whereInvType. $wherestage .$whererange.$whereexitstatus .$whereInvhead. " AND cia.cianame LIKE '%$advisorName%'  and AdvisorType='".$transtype."'
                                    AND pe.PEId NOT
                                                    IN (
                                                    SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE DBTypeId = '$dbTypeSV'
                                                    AND hide_pevc_flag =1
                                                    )" . $comp_industry_id_where;
    $exportSplitGroup1 = " GROUP BY pe.PEId ".$wheresyndication.")";
    $orderby = "companyname";
    $ordertype = "asc";
    $popup_search = 1;
    // } else {
    //     $companysql = "(
    //                                         SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount,pe.Amount_INR,
    //                                                          cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
    //                                                         (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                         FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
    //                                         peinvestments_advisorinvestors AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND   pe.Deleted=0 and SPV=0 and AggHide=0 and pec.industry = i.industryid
    //                                         AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
    //                                         AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_trans%'  and AdvisorType='T'
    //                                         AND pe.PEId NOT
    //                                                         IN (
    //                                                         SELECT PEId
    //                                                         FROM peinvestments_dbtypes AS db
    //                                                         WHERE DBTypeId = '$dbTypeSV'
    //                                                         AND hide_pevc_flag =1
    //                                                         ) $comp_industry_id_where GROUP BY pe.PEId )
    //                                         UNION (
    //                                         SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,pe.Amount_INR,
    //                                                          cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
    //                                                         (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                         FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
    //                                         peinvestments_advisorcompanies AS adac,stage as s
    //                                                         WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' and pe.Deleted=0 and SPV=0 and AggHide=0 and pec.industry = i.industryid
    //                                         AND pec.PECompanyId = pe.PECompanyId
    //                                         AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
    //                                         AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_trans%'  and AdvisorType='T'
    //                                         AND pe.PEId NOT
    //                                                         IN (
    //                                                         SELECT PEId
    //                                                         FROM peinvestments_dbtypes AS db
    //                                                         WHERE DBTypeId = '$dbTypeSV'
    //                                                         AND hide_pevc_flag =1
    //                                                         )
    //                                                         $comp_industry_id_where
    //                                                         GROUP BY pe.PEId )";
    //     $exportSplitSql = "(
    //                                         SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount,
    //                                                          cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
    //                                                         (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                         FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
    //                                         peinvestments_advisorinvestors AS adac,stage as s WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' AND   pe.Deleted=0 and SPV=0 and AggHide=0 and pec.industry = i.industryid
    //                                         AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
    //                                         AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_trans%'  and AdvisorType='T'
    //                                         AND pe.PEId NOT
    //                                                         IN (
    //                                                         SELECT PEId
    //                                                         FROM peinvestments_dbtypes AS db
    //                                                         WHERE DBTypeId = '$dbTypeSV'
    //                                                         AND hide_pevc_flag =1
    //                                                         )" . $comp_industry_id_where;
    //     $exportSplitGroup = " GROUP BY pe.PEId )";
    //     $exportSplitSql1 = "UNION (
    //                                         SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
    //                                                          cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
    //                                                         (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor
    //                                         FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
    //                                         peinvestments_advisorcompanies AS adac,stage as s
    //                                                         WHERE dates between '" . $dt1 . "' and '" . $dt2 . "' and pe.Deleted=0 and SPV=0 and AggHide=0 and pec.industry = i.industryid
    //                                         AND pec.PECompanyId = pe.PECompanyId
    //                                         AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
    //                                         AND adac.PEId = pe.PEId " . $addVCFlagqry . " " . $addDelind . " AND cia.cianame LIKE '%$advisorsearchstring_trans%'  and AdvisorType='T'
    //                                         AND pe.PEId NOT
    //                                                         IN (
    //                                                         SELECT PEId
    //                                                         FROM peinvestments_dbtypes AS db
    //                                                         WHERE DBTypeId = '$dbTypeSV'
    //                                                         AND hide_pevc_flag =1
    //                                                         )" . $comp_industry_id_where;
    //     $exportSplitGroup1 = " GROUP BY pe.PEId )";
    //     $orderby = "companyname";
    //     $ordertype = "asc";
    //     $popup_search = 1;

    // }
    //echo "<br>TRANS-".$vcflagValue;
    //echo $companysql;
} elseif (count($industry) > 0 || count($sector) > 0 || count($subsector) > 0 || $keyword != "" || $companysearch != "" || count($round) > 0 || ($city != "") || ($companyType != "--") || ($debt_equity != "--") || ($syndication != "--") || ($yearafter != "") || ($yearbefore != "") || ($investorType != "--") || ($investor_head != "--")|| (count($regionId) > 0) || ($startRangeValue == "--") || ($endRangeValue == "--") || (count($exitstatusValue) > 0) || (count($dealsinvolvingvalue) > 0)  || (($month1 != "--") && ($year1 != "--") && ($month2 != "--") && ($year2 != "--")) . $checkForStageValue || count($state)>0 || (count($city)>0 )) {
    $yourquery = 1;

    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";

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
                    pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
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
   
    if ($sector != '') {
         foreach($sector as $key=>$sectorval)
        {
            $sectorsql123="select sector_name from pe_sectors where sector_id=".$sectorval;
           
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
        /*$sectorString = implode(',',$sector);
        $wheresectorsql = " pe_sub.sector_id IN($sectorString)";*/
    }
    
    if ($subsector != '') {
        foreach ($subsector as $value){ 
            $subsectorString .= "'".$value."'" . ',';
        } 
        $subsectorString = trim($subsectorString, ',');
        if($subsectorString!=""){
        $wheresubsectorsql = " pe_sub.subsector_name IN($subsectorString)";
        }
    }

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
    //city multiselect
    if (count($city) > 0) {
        $citySql = '';
        $cityarray = explode(",",$cityvalue);
        foreach ($cityarray as $cities) {
            $citySql .= " pec.city= '".$cities."' or ";
        }
        $citySql = trim($citySql, ' or ');
        if ($cityindusSql != '') {
            $wherecity = ' ( ' . $citySql . ' ) ';
        }
    }
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
    /*if ($city != "") {
        $whereCity = "pec.city LIKE '" . $city . "%'";
    }*/
    //  if ($cityname != "" && $cityid != "--") {
    //     $whereCity = "pec.city LIKE '" . $cityname . "%'";
    // }
    //    echo " <bR> where REGION--- " .$whereregion;
    if ($companyType != "--" && $companyType != "") {
        $wherelisting_status = " pe.listing_status='" . $companyType . "'";
    }
    if ($debt_equity != "--" && $debt_equity != "") {if ($debt_equity == 1) {$whereSPVdebt = " pe.SPV='" . $debt_equity . "'";
        $listallcompany = 1;} else { $whereSPVdebt = " pe.SPV='" . $debt_equity . "'";}}

    if ($syndication != "--" && $syndication != "") {

        if ($syndication == 0) {
            $wheresyndication = " Having Investorcount > 1";
        } else {
            $wheresyndication = " Having Investorcount <= 1";
        }

    }
    if ($investorType != "--" && $investorType != '') {
        $qryInvType = "Investor Type - ";
        $whereInvType = " pe.InvestorType = '" . $investorType . "'";
    }
     if ($investor_head != "--" && $investor_head != '') {
           $whereInvhead = "inv.countryid = '" . $investor_head . "'";
    } 
    if ($boolStage == true) {
        $stagevalue = "";
        $stageidvalue = "";
        foreach ($stageval as $stage) {
            //echo "<br>****----" .$stage;
            $stagevalue = $stagevalue . " pe.StageId=" . $stage . " or ";
            $stageidvalue = $stageidvalue . "," . $stage;
        }

        $wherestage = $stagevalue;
        $qryDealTypeTitle = "Stage  - ";
        $strlength = strlen($wherestage);
        $strlength = $strlength - 3;
        $wherestage = substr($wherestage, 0, $strlength);
        if($wherestage !=""){
        $wherestage = "(" . $wherestage . ")";
    }

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
                                if ($wherecity != "") {
                                    $companysql = $companysql . $wherecity . " and ";
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
        
        $exportSplitSql = $companysql . " pe.Deleted=0 " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where $invregsubquery";
        $exportSplitGroup = " GROUP BY pe.PEId";
        $companysql = $companysql . " pe.Deleted=0 " . $addVCFlagqry . " " . $addDelind . "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where $invregsubquery GROUP BY pe.PEId";
        $orderby = "dates";
        $ordertype = "desc";

//                        echo "<br>----" .$whererange;
    } elseif ($whererange == "--" || $whererange == "") {
       
        $exportSplitSql = $companysql . " pe.Deleted=0 " . $isAggregate . " " . $addVCFlagqry . " " . $addDelind . "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where $invregsubquery";
        $exportSplitGroup = " GROUP BY pe.PEId";
        $companysql = $companysql . " pe.Deleted=0 " . $addVCFlagqry . " " . $addDelind . "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where $invregsubquery GROUP BY pe.PEId";
        $orderby = "dates";
        $ordertype = "desc";
    }
    
    if ($wheresyndication != '') {

        $companysql = $companysql . $wheresyndication;
    }
    $popup_search = 1;
                              //       echo   $companysql;
} else {
    echo "<br> INVALID DATES GIVEN ";
    $fetchRecords = false;
}
$ajaxcompanysql = urlencode($companysql);
if ($companysql != "" && $orderby != "" && $ordertype != "") {

    $companysql = $companysql . " order by  dates desc,companyname asc ";
    $exportSplitOrderBy = " order by  dates desc,companyname asc";
}
//}
//INDUSTRY
$industrysql = "select industryid,industry from industry where industryid !=15" . $hideIndustry . " order by industry";

//Company Sector
$searchString = "Undisclosed";
$searchString = strtolower($searchString);

$searchString1 = "Unknown";
$searchString1 = strtolower($searchString1);

$searchString2 = "Others";
$searchString2 = strtolower($searchString2);

$addVCFlagqry = "";
$pagetitle = "PE-backed Companies";

$getcompaniesSql = "SELECT DISTINCT pe.PECompanyId as PECompanyId, pec. * , i.industry, r.Region
                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                        WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId " . $addVCFlagqry . "
                        ORDER BY pec.companyname";

//Stage
$stagesql = "select StageId,Stage from stage ";

echo "<div style='display:none'>$companysql</div>";
//exit;
$topNav = 'Deals';
$defpage = $vcflagValue;
$investdef = 1;
$stagedef = 1;
$tour = 'Allow';
include_once 'tvindex_search.php';

?>
<style type="text/css">
.title-links .export_new, .title-links .export_new:hover {
    line-height: 30px !important;
 }
    .inr-note{
            text-align: right;
font-size: 12px;
padding-top: 35px;
margin: 0px;
margin-right: 95px;
    }
    .is-inr{
            color: #bfa07c;
            float: left;
            font-size: 16px;
            padding: 0px 5px;
    }
     @keyframes blinker {
  50% { opacity: 0.0; }
}
.blinktext{animation: blinker 2s linear infinite;}
</style>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>

<td class="left-td-bg"  id="tdfilter">
    <div class="acc_main" id="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active"  id="openRefine">Slide Panel</a></div>

    <div id="panel" style="display:block; overflow:visible; clear:both;">
                        <?php include_once 'refine.php';?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
     <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>
     <input type="hidden" name="trialuserload" value="<?php if($trialuserload==""){echo 0;}else{echo $trialuserload;}?>">
     <input type='hidden' name='valuationcheck' class="valuationcontainer">
</div>
    </div>
</td>
 <?php
$exportToExcel = 0;
$firstlogin = mysql_num_rows(mysql_query("SELECT * FROM dealLog WHERE EmailId='$emailid' AND PE_MA='0' "));

$TrialSql = "select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
                                                                where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
//echo "<br>---" .$TrialSql;
if ($trialrs = mysql_query($TrialSql)) {
    while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
        $exportToExcel = $trialrow["TrialLogin"];
        $studentOption = $trialrow["Student"];
    }
}

if ($yourquery == 1) {
    $queryDisplayTitle = "Query:";
} elseif ($yourquery == 0) {
    $queryDisplayTitle = "";
}

if (trim($buttonClicked == "")) {
    $totalDisplay = "Total";
    $industryAdded = "";
    $totalAmount = 0.0;
    $totalINRAmount = 0.0;
    $totalInv = 0;
    $compDisplayOboldTag = "";
    $compDisplayEboldTag = "";
    //echo "<br> query final-----" .$companysql;
    /* Select queries return a resultset */
    $exportsql = $companysql;
    if ($companyrsall = mysql_query($companysql)) {
        $company_cntall = mysql_num_rows($companyrsall);
        //echo "totrow count".$company_cntall = mysql_num_rows($companyrsall);
    }
    if ($company_cntall > 0) {
        if ($searchallfield != '') {

            if ($_SERVER["HTTP_REFERER"] != '') {

                $search_link = $_SERVER["HTTP_REFERER"];
            } else {

                $search_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            }
            date_default_timezone_set('Asia/Calcutta');
            $search_date = date('Y-m-d H:i:s');
            $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('" . $_SESSION['UserEmail'] . "','" . $_SESSION['UserNames'] . "','" . $searchallfield . "',1,1,0,'" . $search_date . "','" . $search_link . "')";
            mysql_query($search_query);
        }

        $rec_limit = 50;
        $rec_count = $company_cntall;

        if (isset($_GET{'page'})) {
            $currentpage = $page;
            $page = $_GET{'page'}+1;
            $offset = $rec_limit * $page;
        } else {
            $currentpage = 1;
            $page = 1;
            $offset = 0;
        }
        // $ajaxcompanysql=  urlencode($companysql);
        $companysqlwithlimit = $companysql . " limit $offset, $rec_limit";
        if ($companyrs = mysql_query($companysqlwithlimit)) {
            $company_cnt = mysql_num_rows($companyrs);
        }
        //$searchTitle=" List of Deals";
    } else {
        if ($searchallfield != '') {

            if ($_SERVER["HTTP_REFERER"] != '') {

                $search_link = $_SERVER["HTTP_REFERER"];
            } else {

                $search_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            }
            date_default_timezone_set('Asia/Calcutta');
            $search_date = date('Y-m-d H:i:s');
            $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('" . $_SESSION['UserEmail'] . "','" . $_SESSION['UserNames'] . "','" . $searchallfield . "',0,1,0,'" . $search_date . "','" . $search_link . "')";
            mysql_query($search_query);
        }
        $searchTitle = $searchTitle . " -- No Deal(s) found for this search ";
        $notable = true;
        writeSql_for_no_records($companysql, $emailid);
    }

    echo '<div style="display: none">' . $companysqlwithlimit . '</div>';
    ?>

<td class="profile-view-left" style="width:100%;">
<div class="result-cnt">
    <?php  if ($accesserror == 1  && ($_SESSION['VCcheckflag']==1 )){?>
           <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm">Click here</a></b></div>
            <?php
exit;
    }
   
    ?>

    <div class="result-title">

      <div class="filter-key-result">
        <div style="display: inline-flex">
          <div style="float: left; margin: 15px 0px 0px 0px;font-size: 20px;">
          <!-- <a  class="help-icon tooltip"><strong>Note</strong>
                    <span>
                    <img class="showtextlarge" src="images/callout.gif">
                    Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.
Target/Company in [] indicates a debt investment. Not included in aggregate data.

                    </span>
                </a>  -->
                <a href="#popup1" class="help-icon tooltip" style="margin-right:0px !important;"><img width="20" height="20" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                    <span>
                    <img class="callout" src="images/callout.gif">
                    <strong>Definitions
                    </strong>
                    </span>
                </a>
          </div>
        <div class="lft-cn">
        <?php if (!$_POST) {?>

         <ul class="result-select">
             <?php
if ($stagevaluetext != "") {?>

            <li>
              <?php echo $stagevaluetext; ?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
            </li>

          <?php }?>

           <?php
if ($valuationstxt != "") {?>

            <li>
              <?php echo str_replace('_', ' ', $valuationstxt); ?><a  onclick="resetinput('valuations');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
            </li>

          <?php }?>

           <?php if (($getrangevalue != "")) {?>
          <li>
              <?php echo "(USM)" . $getrangevalue; ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
          </li>
          <?php } else { /*
?>
<li>
<?php echo "(USM) 0-2000"; ?><a></a>
</li>

<?php */}?>
          <?php
if (($getinvestorvalue != "")) {?>
          <li>
              <?php echo $getinvestorvalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
          </li>
          <?php }
        if (($getregionevalue != "")) {?>
          <li>
              <?php echo $getregionevalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
          </li>
          <?php }
        if ($getindusvalue != "") { ?>
           <li>
                <?php $industryarray = explode(",",$getindusvalue); 
              //  print_r($industryarray);
                foreach ($industryarray as $value){  ?>
                  <?php echo $value; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                <?php } ?>
                          
            </li>
          <?php }
        if ($datevalueDisplay1 != "") {
            ?>
                  <li>
                    <?php echo $datevalueDisplay1 . "-" . $datevalueDisplay2; ?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
          <?php } else if ($datevalueCheck1 != "") {
            ?>
              <li style="padding:1px 10px 1px 10px;">
                <?php echo $datevalueCheck1 . "-" . $datevalueCheck2; ?>
              </li>
          <?php
}
        ?>
              <!--li class="result-select-close"><a onclick="resetinput('refcloseall');"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li-->
         </ul>
        <?php
} else {?>

          <ul class="result-select">
              <?php
$_POST['resetfield'] = "";
        foreach ($_POST as $value => $link) {
            if ($link == "" || $link == "--" || $link == " ") {
                unset($_POST[$value]);
            }
        }
        //    print_r($_POST);
        $cl_count = count($_POST);
        if ($cl_count == 3 || $cl_count >= 7) {
            ?>
                <li class="result-select-close"><a id="overall-close" href="index.php?value=<?php echo $vcflagValue; ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                <?php
}
        //echo $queryDisplayTitle;
        if ($industry > 0 && $industry != null) {$drilldownflag = 0;?>

            <?php $industryarray = explode(",",$industryvalue); 
            $industryidarray = explode(",",$industryvalueid); 
                foreach ($industryarray as $key=>$value){  ?>
                  <li>
                      <?php echo $value; ?><a  onclick="resetmultipleinput('industry',<?php echo $industryidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?>
              <?php }
               if ($state > 0 && $state != null) {$drilldownflag = 0;?>
                                   <?php $statearray = explode(",",$statevalue); 
                                $stateidarray = explode(",",$statevalueid); 
                                    foreach ($statearray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('state',<?php echo $stateidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                                  <?php }

              if ($sector > 0 && $sector != null) { $drilldownflag = 0;?>
              <!-- <li>
                  <?php echo $sectorvalue; ?><a  onclick="resetinput('sector');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li> -->
              <?php
               $sectorarray = explode(",",$sectorvalue); 
                               $sectoridarray = explode(",",$sectorvalueid); 
                                    foreach ($sectorarray as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('sector',<?php echo $sectoridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                                  <?php }
              
              if ($subsector > 0 && $subsector != null) { $drilldownflag = 0;?>
               <!--  <li>
                    <?php echo $subsectorvalue; ?><a  onclick="resetinput('subsector');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li> -->
                <?php
               //$subsectorarray = explode(",",$subsector); 
                              // $stageidarray = explode(",",$stagevalueid); 
                foreach ($subsector as $key=>$value){  ?>
                <li>
                    <?php echo $value; ?><a  onclick="resetmultipleinput('subsector','<?php echo $subsector[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
                <?php } ?>
                <?php }
        if ($stagevaluetext != "" && $stagevaluetext != null) {$drilldownflag = 0;?>
             
              
                <?php $stagearray = explode(",",$stagevaluetext); 
                               $stageidarray = explode(",",$stagevalueid); 
                                    foreach ($stagearray as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('stage',<?php echo $stageidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                                  <?php }
        if (count($round) > 0 && $roundTxtVal != '') {$drilldownflag = 0;?>
            <?php $roundarray = explode(",",$roundTxtVal); 
                               
                                    foreach ($roundarray as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('round','<?php echo $roundarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                                  <?php }
             
        if ($companyType != "--" && $companyType != null) {$drilldownflag = 0;?>
              <li>
                  <?php echo $companyTypeDisplay; ?><a  onclick="resetinput('comptype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php }
        if ($investorType != "--" && $investorType != null) {$drilldownflag = 0;?>
              <li>
                  <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php }
              if ($investor_head != "--" && $investor_head != null) {$drilldownflag = 0;?>
              <li>
                  <?php echo $invheadvalue; ?><a  onclick="resetinput('invhead');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php }
        if (count($regionId) > 0) {$drilldownflag = 0;?>
              <!-- <li>
                  <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li> -->
               <!-- City -->
              
              <?php $regionarray = explode(",",$regionvalue); 
                                $regionidarray = explode(",",$regionvalueId);
                                    foreach ($regionarray as $key=>$value){  ?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('txtregion','<?php echo $regionidarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                                  <?php }
        /*if ($city != "") {$drilldownflag = 0;?>
              <li>
                  <?php echo $city; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <!-- -->
              <?php }*/
            /*  if ($cityid != "--" && $cityname !="") {$drilldownflag = 0;?>
              <li>
                  <?php echo $cityname; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              
              <?php }*/
              //   multiple city
            if( $_POST['cityflag']!=0 ){
           
                $cityflagvalidate=1;     
                } else{$cityflagvalidate=0;}       
                if ($city > 0 && $city != null && $cityflagvalidate ==1  )  {$drilldownflag = 0;?>
                                            <?php 
                                            $cityarray = explode(",",$cityvalue); 
                                        $cityidarray = explode(",",$cityvalueid); 
                                        //echo $cityflag;
                                        
                                          foreach ($cityarray as $key=>$value){?>
                                            <li>
                                                <?php echo ucwords(strtolower($value)); ?><a  onclick="resetmultipleinput('city','<?php echo $cityidarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                            </li>
                                            <?php } ?>
                                        
                                        <?php }
                
                if (($startRangeValue != "" && $endRangeValue != "") || ($startRangeValue == "--" && $endRangeValue > 0)) {$drilldownflag = 0;?>
                    <li>
                        <?php echo "(USM)" . $startRangeValue . "-" . $endRangeValue; ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                    </li>
                    <?php }
        if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                <?php }     ?>
              
        <?php if ($valuationstxt != "") {?>

            <?php $valuationarray = explode(",",$valuationstxt); 
                                //print_r($valuations);
                                    foreach ($valuationarray as $key=>$value){  ?>
                                      <li>
                                         <?php echo str_replace('_', ' ', $value); ?><a  onclick="resetmultipleinput('valuations','<?php echo $valuations[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php } ?>
                                  <?php }

                         
        if ($datevalueDisplay1 != "") {
            ?>
              <li>
                  <?php echo $datevalueDisplay1 . "-" . $datevalueDisplay2; ?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php } else if ($datevalueCheck1 != "") {
            ?>
               <li style="padding:1px 10px 1px 10px;">
                  <?php echo $datevalueCheck1 . "-" . $datevalueCheck2; ?>
              </li>
              <?php
} else if (trim($_POST['searchallfield']) != "" || trim($_POST['searchKeywordLeft']) != "" || trim($_POST['searchTagsField']) != "" || trim($_POST['keywordsearch']) != "" || trim($_POST['sectorsearch']) != "" || trim($_POST['companysearch']) != "" || trim($_POST['advisorsearch_legal']) != "" || trim($_POST['advisorsearch_trans']) != "") {

            ?>
               <li style="padding:1px 10px 1px 10px;">
                  <?php echo $sdatevalueDisplay1 . "-" . $edatevalueDisplay2; ?>
              </li>
              <?php
}
        if ($debt_equity != "--" && $debt_equity != null) {$drilldownflag = 0;?>
              <li>
                  <?php echo $debt_equityDisplay; ?><a  onclick="resetinput('dealtype_debtequity');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php }
        if ($syndication != "--" && $syndication != null) {$drilldownflag = 0;?>
              <li>
                  <?php echo $syndication_Display; ?><a  onclick="resetinput('syndication');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php }
        if ($keyword != "") {$drilldownflag = 0;?>
             <?php $investerarray = explode(",",$invester_filter); 

            $investeridarray = explode(",",$invester_filter_id); 
                foreach ($investerarray as $key=>$value){  ?>
                  <li>
                      <?php echo $value; ?><a  onclick="resetmultipleinput('keywordsearch',<?php echo $investeridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?>
             
              <?php }
        if ($csearch != "") {$drilldownflag = 0;?>
               <!-- <li>
                  <?php echo trim($company_filter); ?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>  -->
             <?php $companyarray = explode(",",$company_filter); 

            $companyidarray = explode(",",$company_id); 
                foreach ($companyarray as $key=>$value){  ?>
                  <li>
                      <?php echo $value; ?><a  onclick="resetmultipleinput('companysearch',<?php echo $companyidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?> 
            
              <?php }
             
        if ($ssearch != "") {$drilldownflag = 0;?>
              <li>
                  <?php echo trim($sauto); ?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php }
        if ($advisorsearchstring_legal != "") {$drilldownflag = 0;?>
              <li>
                  <?php echo trim($advisorsearchstring_legal); ?><a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php }
        if ($advisorsearchstring_trans != "") {$drilldownflag = 0;?>
              <li>
                  <?php echo trim($advisorsearchstring_trans); ?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php }if ($searchallfield != "") {$drilldownflag = 0;?>
              <li>
                  <?php echo trim($searchallfield) ?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
               <?php }
        if ($tagsearch != '') {

            $ex_tags_filter = explode(':', $tagsearch);

            /*if (count($ex_tags_filter) > 1) {
                $tagsearch = trim($tagsearch);
            } else {

                $tagsearch = "tag:" . trim($tagsearch);
            }*/
            ?>
                <!-- <li><?php echo $tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
                  <?php $tagarray = explode(",",$tagsearch); 

            //$exitidarray = explode(",",$exitstatusValue); 
                foreach ($tagarray as $key=>$value){  ?>
                  <li>
                      <?php echo "tag:".$value; ?><a  onclick="resetmultipleinput('tagsearch','<?php echo $tagarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?>
            <?php
        }
        if (count($exitstatusValue) > 0) {

            foreach ($exitstatusValue as $exitstatusValues) {
                if ($exitstatusValues == 1) {

                    $exitstatusfilter .= 'Unexited, ';

                } else if ($exitstatusValues == 2) {

                    $exitstatusfilter .= 'Partially Exited, ';

                } else if ($exitstatusValues == 3) {

                    $exitstatusfilter .= 'Fully Exited, ';

                } else {
                    $exitstatusfilter = '';
                }
            }
            $exitstatusfilter = trim($exitstatusfilter, ', ');
        }
        if ($exitstatusfilter != '') {?>
               <!--  <li>
                   <?php echo $exitstatusfilter; ?><a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li> -->
              
               <?php $exitarray = explode(",",$exitstatusfilter); 

            //$exitidarray = explode(",",$exitstatusValue); 
                foreach ($exitarray as $key=>$value){  ?>
                  <li>
                      <?php echo $value; ?><a  onclick="resetmultipleinput('exitstatus','<?php echo $exitstatusValue[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?>
             
              <?php }
        if (count($dealsinvolvingvalue) > 0) {
          
          foreach ($dealsinvolvingvalue as $dealsinvolvingval) {
              
              if ($dealsinvolvingval == 1) {

                  $dealsinvolvingfilter .= 'New Investor, ';

              } else if ($dealsinvolvingval == 2) {

                  $dealsinvolvingfilter .= 'Existing Investor, ';

              } else {
                  $dealsinvolvingfilter = '';
              }
          }
          $dealsinvolvingfilter = trim($dealsinvolvingfilter, ', ');
      }
        if ($dealsinvolvingfilter != '') {?>
            
            
             <?php $dealsarray = explode(",",$dealsinvolvingfilter); 

         
              foreach ($dealsarray as $key=>$value){ ?>
                <li>
                    <?php echo $value; ?><a  onclick="resetmultipleinput('dealsinvolving','<?php echo $dealsarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
              <?php } ?>

              <?php }?>
           </ul>
        <?php }?>
           </div>
       </div>

          <div class='result-rt-cnt'>

              <div class="result-count">
                <?php if (!$_POST) {?>
                    <!--h2-->

                 <?php
if ($vcflagValue == 0) {
        ?>

                            <span class="result-no" id="show-total-deal" <?php if ($listallcompany == 1) {echo "style='opacity:0.4'";}?>>Results found</span>
                            <span class="result-amount"></span>
                            <span class="result-amount-no" id="show-total-amount" <?php if ($listallcompany == 1) {echo "style='opacity:0.4'";}?>></span>
                            <span class="result-amount-no" id="show-total-inr-amount" <?php if ($_POST['listallcompanies'] == 1) {echo "style='opacity:0.4'";}?>><h2>/ (INR CR) <span></span></h2></span>
                             <span class="is-inr">*</span>
                <?php } else {?>

                            <span class="result-no" id="show-total-deal" <?php if ($listallcompany == 1) {echo "style='opacity:0.4'";}?>>Results found </span>
                            <span class="result-amount"></span>
                             <span class="result-amount-no" id="show-total-amount" <?php if ($listallcompany == 1) {echo "style='opacity:0.4'";}?>></span>
                             <span class="result-amount-no" id="show-total-inr-amount" <?php if ($_POST['listallcompanies'] == 1) {echo "style='opacity:0.4'";}?>><h2>/ (INR CR) <span></span></h2></span>
                             <span class="is-inr">*</span>
                    <?php }
        ?>


                <?php } else {?>

                       <?php
if ($vcflagValue == 0) {
        ?>

                        <span class="result-no" id="show-total-deal" <?php if ($listallcompany == 1) {echo "style='opacity:0.4'";}?>>Results found</span>
                         <span class="result-amount"></span>
                          <span class="result-amount-no" id="show-total-amount" <?php if ($listallcompany == 1) {echo "style='opacity:0.4'";}?>></span>
                          <span class="result-amount-no" id="show-total-inr-amount" <?php if ($_POST['listallcompanies'] == 1) {echo "style='opacity:0.4'";}?>><h2>/ (INR CR) <span></span></h2></span>
                             <span class="is-inr">*</span>
                <?php } else {?>
                            <span class="result-no" id="show-total-deal" <?php if ($listallcompany == 1) {echo "style='opacity:0.4'";}?>>Results found </span>
                            <span class="result-amount"></span>
                             <span class="result-amount-no" id="show-total-amount" <?php if ($listallcompany == 1) {echo "style='opacity:0.4'";}?>></span>
                             <span class="result-amount-no" id="show-total-inr-amount" <?php if ($_POST['listallcompanies'] == 1) {echo "style='opacity:0.4'";}?>><h2>/ (INR CR) <span></span></h2></span>
                             <span class="is-inr">*</span>
                <?php }
    }
    ?>
                <!-- <a href="#popup1" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                    <span>
                    <img class="callout" src="images/callout.gif">
                    <strong>Definitions
                    </strong>
                    </span>
                </a> -->
                 <div class="title-links " id="exportbtn"></div>
            </div>
              <p class="inr-note"><b>* Based on current USD / INR Rate</b></p>
        </div>
    </div>
    <!--<div class="alert-note"><div class="alert-para">Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.
Target/Company in [] indicates a debt investment. Not included in aggregate data. </div>

    <div class="list-tab"><ul style="float:left;">
    <li class="active"><a class="postlink"   href="index.php?value=0"  id="icon-grid-view"><i></i> List View</a></li>
    <?php
$count = 0;
    if ($companyrs == true) {

        while ($myrow = mysql_fetch_array($companyrs, MYSQL_BOTH)) {
            if ($count == 0) {
                $comid = $myrow["PEId"];
                $count++;
            }
        }
    }
    ?>
    <li><a id="icon-detailed-view" class="postlink" href="dealdetails.php?value=<?php echo $comid; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?>" ><i></i> Detail View</a></li>
    </ul>

    </div>-->
    </div>

<?php
$cos_array = $cos_array_Agg = $cos_array_Agg1 = $cos_withdebt_array = array();
    $company_array = [];
    $company_array_comma = '';
    if ($_SESSION['coscount']) {unset($_SESSION['coscount']);}
    if ($_SESSION['totalcount']) {unset($_SESSION['totalcount']);}
    if ($notable == false) {
        if ($company_cntall > 0) {
            $hidecount = 0;
            $icount = 0;
            mysql_data_seek($companyrsall, 0);

            //Code to add PREV /NEXT
            if ($_SESSION['resultId']) {
                unset($_SESSION['resultId']);
            }

            if ($_SESSION['resultCompanyId']) {
                unset($_SESSION['resultCompanyId']);
            }

            $totaldet = 0;
            $totalno = 1;
            $hideinrcount = 0;
            $inrnote = "";
            $isflased = false;
            while ($myrow = mysql_fetch_array($companyrsall, MYSQL_BOTH)) {
                //SPV changed to AggHide
                $amtTobeDeductedforAggHide = 0;
                $inramtTobeDeductedforAggHide = 0;
                $prd = $myrow["dealperiod"];

                if ($myrow["AggHide"] == 1) {
                    $NoofDealsCntTobeDeducted = 1;
                    $agghide += 1;
                    $cos_array_Agg[] = $myrow["PECompanyId"];
                    $isflased = true;
                } else if ($myrow["SPV"] == 1) {

                    $spvhide += 1;
                    $NoofDealsCntTobeDeducted = 1;
                    $cos_array_Agg[] = $myrow["PECompanyId"];
                    $isflased = true;
                } elseif ($myrow["amount"] == 0) {

                    $NoofDealsCntTobeDeducted = 0;
                    $cos_array_Agg1[] = $myrow["PECompanyId"];
                } else {

                    $NoofDealsCntTobeDeducted = 0;
                    $cos_array[] = $myrow["PECompanyId"];
                }

                $cos_withdebt_array[] = $myrow["PECompanyId"];
                if ($myrow["AggHide"] == 1) {
                    $amtTobeDeductedforAggHide = $myrow["amount"];
                    $inramtTobeDeductedforAggHide = $myrow["Amount_INR"];
                    //$NoofDealsCntTobeDeducted=1;
                } else {
                    $amtTobeDeductedforAggHide = 0;
                    // $NoofDealsCntTobeDeducted=0;
                }
                if ($myrow["SPV"] == 1) //Debt
                {
                    $amtTobeDeductedforDebt = $myrow["amount"];
                    $inramtTobeDeductedforDebt = $myrow["Amount_INR"];
                    $amtTobeDeductedforAggHide = $myrow["amount"];
                    $inramtTobeDeductedforAggHide = $myrow["Amount_INR"];
                    $NoofDealsCntTobeDeductedDebt = 1;
                    // $NoofDealsCntTobeDeducted=1;
                } else {
                    $amtTobeDeductedforDebt = 0;
                    $NoofDealsCntTobeDeductedDebt = 0;
                }
                if ($myrow["hideamount"] == 1) {
                    $hideamount = "--";
                    if($myrow["SPV"] != 1 &&  $myrow["AggHide"] != 1){
                        $hidecount = $hidecount + 1;
                    }
                } else {
                    $hideamount = $myrow["amount"];
                }
                /** if($myrow["amount"]==0 && $myrow["AggHide"]==0)
                {
                $NoofDealsCntTobeDeducted=1;
                }*/
                $companyName = trim($myrow["companyname"]);
                $companyName = strtolower($companyName);
                $compResult = substr_count($companyName, $searchString);
                $compResult1 = substr_count($companyName, $searchString1);

                $_SESSION['resultId'][$icount] = $myrow["PEId"];
                $_SESSION['resultCompanyId'][$icount] = $myrow["PECompanyId"];
                $icount++;

                $industryAdded = $myrow[2];
                $exportflag = $exportflag + $NoofDealsCntTobeDeducted;
                $totaldet += $NoofDealsCntTobeDeducted;
                if ($myrow["Amount_INR"] == 0) {
                    $hideinrcount = $hideinrcount + 1;
                }
                if ($debt_equity == 1) {
                    $totalInv = $totalInv + 1;
                    $cos_array = $cos_withdebt_array;
                    $totalAmount = $totalAmount + $myrow["amount"];
                    $totalINRAmount = $totalINRAmount + $myrow["Amount_INR"];
                } else {
                    $totalno = $totalno + $NoofDealsCntTobeDeducted;
                    $totalInv = $totalInv + 1 - $NoofDealsCntTobeDeducted;
                    $totalAmount = $totalAmount + $myrow["amount"] - $amtTobeDeductedforAggHide;
                    $totalINRAmount = $totalINRAmount + $myrow["Amount_INR"] - $inramtTobeDeductedforAggHide;

                    //echo $totalInv . ' ====== ' . $myrow["amount"] . ' ====== ' . $totalAmount . ' ===== ' . $NoofDealsCntTobeDeducted . ' ==== ' . $myrow[ 'AggHide' ] . ' === ' . $myrow[ 'SPV' ] . ' === <br/>';
                }

            }

            $inrvalue = "SELECT value FROM configuration WHERE purpose='USD_INR'";
            $inramount = mysql_query($inrvalue);
            while ($inrAmountRow = mysql_fetch_array($inramount, MYSQL_BOTH)) {
                $usdtoinramount = $inrAmountRow['value'];
            }
            if ($hideinrcount > 0) {
                $totalINRAmount = $totalAmount * 1000000 * $usdtoinramount / 10000000;
                $inrnote = "* Based on current USD / INR Rate";
            }
            //echo "ddddddddd".$totalno;
            //echo "agghide".$agghide;
            //echo "spv".$spvhide;
            //echo "totalInv".$totalInv;
            $_SESSION['coscount'] = count(array_count_values($cos_array));
            $_SESSION['totalcount'] = $totalInv;

            foreach (array_count_values($cos_array) as $key => $value) {
                $company_array[] = $key;
            }
            $comp_count = count(array_count_values($cos_array));
            $company_array_comma = implode(",", $company_array);
        }

        ?>

          <?php
if ($isflased == true && $listallcompany != 1) {?>
       <div class="include" style="float: left; margin-bottom:10px;margin-top:15px;">
                          <label style="font-size:13px;    float: left;" ><input type="checkbox" name="listallcompanies" id="Listall"  class="listall" value="1" <?php if ($listallcompany == 1) {echo "checked";}?>/>
                                      <b class="blinktext">Include Deals that are not counted for aggregate data calculation</b>
                           <a style="margin-top: 0px !important;cursor: pointer;  float: right !important;" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                <span style="width: 25%;">
                                <img class="showtextlarge" src="images/callout.gif" style="left:5px;">
                                Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.
            Target/Company in [] indicates a debt investment. Not included in aggregate data.

                                </span>
                            </a>
                          </div>
                          <?php } else {?>
                            <div class="include" style="float: left; margin-bottom:10px;margin-top:15px;">
                          <label style="font-size:13px;    float: left;" ><input type="checkbox" name="listallcompanies" id="Listall"  class="listall" value="1" <?php if ($listallcompany == 1) {echo "checked";}?>/>
                                      <b >Include Deals that are not counted for aggregate data calculation</b>
                           <a style="margin-top: 0px !important;cursor: pointer;  float: right !important;" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                <span style="width: 25%;">
                                <img class="showtextlarge" src="images/callout.gif" style="left: 5px;">
                                Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.
            Target/Company in [] indicates a debt investment. Not included in aggregate data.

                                </span>
                            </a>
                          </div>
                          <?php }?>



    </div>
            <a id="detailpost" class="postlink"></a>
            <div class="view-table view-table-list " style="clear: both;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                    <thead><tr>
                      <?php if ($searchallfield != '' || $_POST['popup_keyword'] != '' || (count($_POST['industry']) > 0) || (count($_POST['sector']) > 0) || (count($_POST['subsector']) > 0) || (count($_POST['stage']) > 0) || (count($_POST['round']) > 0) || (count($_POST['txtregion']) > 0) || $_POST['citysearch'] != "" || (count($_POST['exitstatus']) > 0) || (count($_POST['valuations']) > 0) || $_POST['comptype'] != '' || $_POST['dealtype_debtequity'] != "" || $_POST['Syndication'] != "" || $_POST['invType'] != "" || ($_POST['invrangestart'] != "" && $_POST['invrangeend'] != "") || $_POST['investorauto_sug'] != "" || $_POST['companyauto_sug'] != "" || $_POST['sectorsearch'] != "" || $_POST['advisorsearch_legal'] != "" || $_POST['advisorsearch_trans'] != "" || $_POST['tagsearch'] != '' || $tagsearch !=''  || $_POST['yearbefore'] != '' || $_POST['yearafter'] != '' || $_POST['invhead'] != '' || (count($_POST['state']) > 0) || (count($_POST['city']) > 0)) {

            $uncheckRows = $_POST['uncheckRows'];
            $pe_checkbox = explode(',', $uncheckRows);
            if (count($_POST['uncheckRows']) > 0) {
                $allchecked = '';
            } else {
                $allchecked = 'checked';
            }

            if ($_POST['full_uncheck_flag'] != '' && $_POST['full_uncheck_flag'] == 1) {

                $allchecked = '';
            }
            ?>

                            <th class=""><input type="checkbox" class="all_checkbox" id="all_checkbox" <?php echo $allchecked; ?>/></th>
                        <?php }?>

                        <th style="width: 22%;" class="header <?php echo ($orderby == "companyname") ? $ordertype : ""; ?>" id="companyname">Company</th>
                        <th style="width: 34%;" class="header <?php echo ($orderby == "sector_business") ? $ordertype : ""; ?>" id="sector_business">Sector</th>
                        <th style="width: 16%;" class="header <?php echo ($orderby == "investor") ? $ordertype : ""; ?>" id="investor">investor</th>
                        <th style="width: 10%;" class="header <?php echo ($orderby == "dates") ? $ordertype : ""; ?>" id="dates">Date</th>
                        <th style="width: 10%;" class="header <?php echo ($orderby == "Exit_Status") ? $ordertype : ""; ?>" id="Exit_Status">Exit Status</th>
                        <th style="width: 8%;" class="alignr header asc <?php echo ($orderby == "amount") ? $ordertype : ""; ?>" id="amount">Amount (US$M)</th>
                        </tr></thead>
                    <tbody id="movies">
                  <!--   <div class="include" style="float: right; margin-bottom:10px;">
                          <label style="font-size:13px;    float: left;" ><input type="checkbox" name="listallcompanies" id="Listall"  class="listall" value="1" <?php if ($listallcompany == 1) {echo "checked";}?>/>
                          <b>Include Deals that are not counted for aggregate data calculation</b></label>
                           <a style="margin-top: 0px !important;cursor: pointer;" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                <span style="left: 70%;">
                                <img class="showtextlarge" src="images/callout.gif" style="left: 90%;">
                                Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.
            Target/Company in [] indicates a debt investment. Not included in aggregate data.

                                </span>
                            </a>
                          </div> -->
                <?php
if ($company_cnt > 0) {
            $hidecount = 0;
            $hideBracketRow = false;
            mysql_data_seek($companyrs, 0);

            //Code to add PREV /NEXT
            while ($myrow = mysql_fetch_array($companyrs, MYSQL_BOTH)) {
                //SPV changed to AggHide
                $amtTobeDeductedforAggHide = 0;
                $hideFlagset = 0;
                $prd = $myrow["dealperiod"];

                if ($myrow["AggHide"] == 1 || $myrow["SPV"] == 1) {
                    $hideBracketRow = true;
                } else {
                    $hideBracketRow = false;
                }
                if ($myrow["AggHide"] == 1) {
                    $openBracket = "(";
                    $closeBracket = ")";
                    $hideFlagset = 1;

                    //$amtTobeDeductedforAggHide=$myrow["amount"];
                    //$NoofDealsCntTobeDeducted=1;
                } else {
                    $openBracket = "";
                    $closeBracket = "";
                    $amtTobeDeductedforAggHide = 0;
                    // $NoofDealsCntTobeDeducted=0;
                }

                if ($myrow["SPV"] == 1) //Debt
                {
                    $openDebtBracket = "[";
                    $closeDebtBracket = "]";
                    $amtTobeDeductedforDebt = $myrow["amount"];
                    $hideFlagset = 1;
                    //$amtTobeDeductedforAggHide= $myrow["amount"];
                    $NoofDealsCntTobeDeductedDebt = 1;
                    //$NoofDealsCntTobeDeducted=1;
                } else {
                    $openDebtBracket = "";
                    $closeDebtBracket = "";
                    $amtTobeDeductedforDebt = 0;
                    $NoofDealsCntTobeDeductedDebt = 0;
                }

                if (trim($myrow[17]) == "") {
                    $compDisplayOboldTag = "";
                    $compDisplayEboldTag = "";
                } else {
                    $compDisplayOboldTag = "<b><i>";
                    $compDisplayEboldTag = "</b></i>";
                }

                if ($myrow["hideamount"] == 1 ) {
                    $hideamount = "--";
                    if($myrow["SPV"] != 1 &&  $myrow["AggHide"] != 1){
                        $hidecount = $hidecount + 1;
                    }
                } else {
                    $hideamount = $myrow["amount"];
                }

                if ($myrow["amount"] == 0) {
                    //$NoofDealsCntTobeDeducted=1;
                }

                if (($vcflagValue == 0) || ($vcflagValue == 1)) {
                    if (trim($myrow["sector_business"]) == "") {
                        $showindsec = $myrow[3];
                    } else {
                        $showindsec = $myrow["sector_business"];
                    }
                   
                    // if($myrow[25] != '' && $myrow[26] != ''){
                    //     $subsectorsec = " (".$myrow[25]." - " .$myrow[26].")";
                    // } else if($myrow[25] != '') {
                    //     $subsectorsec = " (".$myrow[25].")";
                    // } else {
                    //     $subsectorsec = '';
                    // }
                    // $showindsec = $myrow[24].$subsectorsec;
                
                }

                if ($myrow["Exit_Status"] == 1) {
                    $exitstatus_name = 'Unexited';
                } else if ($myrow["Exit_Status"] == 2) {
                    $exitstatus_name = 'Partially Exited';
                } else if ($myrow["Exit_Status"] == 3) {
                    $exitstatus_name = 'Fully Exited';
                } else {
                    $exitstatus_name = '--';
                }

                $companyName = trim($myrow["companyname"]);
                $companyName = strtolower($companyName);
                $compResult = substr_count($companyName, $searchString);
                $compResult1 = substr_count($companyName, $searchString1);

                 if ($searchallfield != '' || $_POST['popup_keyword'] != '' || (count($_POST['industry']) > 0) || (count($_POST['sector']) > 0) || (count($_POST['subsector']) > 0) || (count($_POST['stage']) > 0) || (count($_POST['round']) > 0) || (count($_POST['txtregion']) > 0) || $_POST['citysearch'] != "" || (count($_POST['exitstatus']) > 0) || (count($_POST['valuations']) > 0) || $_POST['comptype'] != '' || $_POST['dealtype_debtequity'] != "" || $_POST['Syndication'] != "" || $_POST['invType'] != "" || ($_POST['invrangestart'] != "" && $_POST['invrangeend'] != "") || $_POST['investorauto_sug'] != "" || $_POST['companyauto_sug'] != "" || $_POST['sectorsearch'] != "" || $_POST['advisorsearch_legal'] != "" || $_POST['advisorsearch_trans'] != "" || $_POST['tagsearch'] != '' || $tagsearch !='' || $_POST['yearbefore'] != '' || $_POST['yearafter'] != '' || $_POST['invhead'] != '' || (count($_POST['state']) > 0) || ($_POST['city']!="" && $_POST['city']!="--")) {
                    /*if( !empty( $pe_checkbox ) ) {
                    if( in_array( $myrow["PEId"], $pe_checkbox ) ) {
                    $peChecked = '';
                    $rowClass = 'event_stop';
                    } else {
                    $peChecked = 'checked';
                    $rowClass = '';
                    }
                    } else {
                    $peChecked = 'checked';
                    $rowClass = '';
                    }*/
                    if (count($pe_checkbox) > 0 && $pe_checkbox[0] != '' && count($pe_checkbox_enable) > 0 && $pe_checkbox_enable[0] != '') {

                        if ((in_array($myrow["PEId"], $pe_checkbox))) {
                            $checked = '';
                            $rowClass = 'event_stop';

                        } elseif ((in_array($myrow["PEId"], $pe_checkbox_enable))) {
                            $checked = 'checked';
                            $rowClass = '';

                        } elseif ($_POST['full_uncheck_flag'] == 1) {
                            $checked = '';
                            $rowClass = 'event_stop';
                        } elseif ($_POST['full_uncheck_flag'] == '') {
                            $rowClass = '';
                            $checked = 'checked';
                        }

                    } elseif (!empty($pe_checkbox) && $pe_checkbox[0] != '') {

                        if ((in_array($myrow["PEId"], $pe_checkbox))) {
                            $checked = '';
                            $rowClass = 'event_stop';

                        } elseif ($_POST['full_uncheck_flag'] == 1) {
                            $checked = '';
                            $rowClass = 'event_stop';
                        } else {
                            $checked = 'checked';
                            $rowClass = '';
                        }

                    } elseif (!empty($pe_checkbox_enable) && $pe_checkbox_enable[0] != '') {

                        if ((in_array($myrow["PEId"], $pe_checkbox_enable))) {
                            $checked = 'checked';
                            $rowClass = '';

                        } elseif ($_POST['full_uncheck_flag'] == 1) {
                            $checked = '';
                            $rowClass = 'event_stop';
                        } else {
                            $checked = '';
                            $rowClass = 'event_stop';
                        }

                    } elseif ($_POST['full_uncheck_flag'] == 1) {

                        $checked = '';
                        $rowClass = 'event_stop';
                    } else {

                        $checked = 'checked';
                        $rowClass = '';
                    }
                }
                ?>

                                <tr class="details_link <?php echo $rowClass; ?>" <?php if ($hideBracketRow == true && $listallcompany != 1) {echo "style='display:none';";}?> valueId="<?php echo $myrow["PEId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?>">
                                     <?php if ($searchallfield != '' || $_POST['popup_keyword'] != '' || (count($_POST['industry']) > 0) || (count($_POST['sector']) > 0) || (count($_POST['subsector']) > 0) || (count($_POST['stage']) > 0) || (count($_POST['round']) > 0) || (count($_POST['txtregion']) > 0) || $_POST['citysearch'] != "" || (count($_POST['exitstatus']) > 0) || (count($_POST['valuations']) > 0) || $_POST['comptype'] != '' || $_POST['dealtype_debtequity'] != "" || $_POST['Syndication'] != "" || $_POST['invType'] != "" || ($_POST['invrangestart'] != "" && $_POST['invrangeend'] != "") || $_POST['investorauto_sug'] != "" || $_POST['companyauto_sug'] != "" || $_POST['sectorsearch'] != "" || $_POST['advisorsearch_legal'] != "" || $_POST['advisorsearch_trans'] != "" || $_POST['tagsearch'] != '' || $tagsearch !=''  || $_POST['yearbefore'] != '' || $_POST['yearafter'] != '' || $_POST['invhead'] != '' || (count($_POST['state']) > 0) || (count($_POST['city']) > 0)) {?>

                                    <td><input type="checkbox" data-deal-amount="<?php echo $myrow["amount"]; ?>" data-deal-inramount="<?php echo $myrow["Amount_INR"]; ?>" data-hide-flag="<?php echo $hideFlagset; ?>" data-company-id="<?php echo $myrow['PECompanyId']; ?>" class="pe_checkbox" <?php echo $checked; ?> value="<?php echo $myrow["PEId"]; ?>" /></td>
                                    <?php
}
                ?>
                                    <?php
if (($compResult == 0) && ($compResult1 == 0)) {
                    //Session Variable for storing Id. To be used in Previous / Next Buttons
                    ?>
                                                                <td style="width: 22%;" id="tour<?php echo $myrow["PEId"]; ?>"><?php echo $openDebtBracket; ?><?php echo $openBracket; ?><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?> "   id="dealid<?php echo $myrow["PEId"]; ?>" ><?php echo trim($myrow["companyname"]); ?>  </a> <?php echo $closeBracket; ?><?php echo $closeDebtBracket; ?></td>
                                    <?php
} else {
                    ?>
                                                    <td style="width: 22%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?> "><?php echo ucfirst("$searchString"); ?></a></td>
                                    <?php
}
                ?>
                                                                    <td style="width: 34%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?> " ><?php echo trim($showindsec); ?></a></td>
                                                                    <td style="width: 16%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?> " ><?php echo $myrow["Investor"]; ?></a></td>
                                                                    <td style="width: 10%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?> " ><?php echo $prd; ?></a></td>
                                                                    <td style="width: 10%;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?> " ><?php echo $exitstatus_name; ?></a></td>
                                                                    <td style="width: 8%; text-align: right;"><a class="postlink" href="dealdetails.php?value=<?php echo $myrow["PEId"]; ?>/<?php echo $vcflagValue; ?>/<?php echo $searchallfield; ?> " ><?php echo $hideamount; ?>&nbsp;</a></td>
                                </tr>
                                <?php
}
        }

        if (isset($_POST['pe_checkbox']) && !empty($_POST['pe_checkbox'])) {
            $pecheckcount = count($pe_checkbox);
            $totalInv = $totalInv - $pecheckcount;
            $_SESSION['totalcount'] = $totalInv;
        }
        //-------------------------------------junaid-------------------------------------
        if (isset($_POST['pe_hide_companies']) && !empty($_POST['pe_hide_companies'])) {
            $hideCountCh = count($pe_hide_companies);
            $totalInv = $totalInv + $hideCountCh;
            $_SESSION['totalcount'] = $totalInv;
        }
        //--------------------------------------------------------------------------
        if (isset($_POST['pe_amount']) && !empty($_POST['pe_amount'])) {
            $totalAmount = $pe_amount;
        }

        if ($peEnableFlag) {
            if (!empty($pe_company)) {

                $cos_array1 = explode(',', $pe_company);
                $total_cos = count(array_count_values($cos_array1));
            } elseif (!empty($_POST['hide_pe_company'])) {
                $cos_array1 = explode(',', $_POST['hide_pe_company']);
                $total_cos = count(array_count_values($cos_array1));
            } else {

                $cos_array1 = '';
                $total_cos = 0;
            }
        } else {
            $cos_array1 = $cos_array;
        }

        if ($hidecount == 1) {
            $totalAmount = "--";
            $totalINRAmount = "--";
        }?>
                        </tbody>
                </table>
            </div>
            <?php
}
}
?>
        <input type="hidden" name="pe_checkbox_disbale" id="pe_checkbox_disbale" value="<?php echo implode(',', $pe_checkbox); ?>">
        <input type="hidden" name="pe_checkbox_enable" id="pe_checkbox_enable" value="<?php echo implode(',', $pe_checkbox_enable); ?>">
        <input type="hidden" name="pe_checkbox_amount" id="pe_checkbox_amount" value="">
        <!-- edited -->
        <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php if ($_POST['total_inv_deal'] != '' && $searchallfield != '') {echo $_POST['total_inv_deal'];} else {echo $totalInv;}?>">
        <input type="hidden" name="real_total_inv_amount" id="real_total_inv_amount" value="<?php
if ($_POST['total_inv_amount'] != '' && $searchallfield != '') {echo number_format($_POST['total_inv_amount'], 2);} else {
        if ($totalAmount > 0) {
            echo number_format($totalAmount, 2);
        } else {
            echo "--";
        }
    }?>">
        <input type="hidden" name="real_total_inv_inr_amount" id="real_total_inv_inr_amount" value="<?php
if ($_POST['total_inv_inr_amount'] != '' && $searchallfield != '') {echo number_format($_POST['total_inv_inr_amount'], 2);} else {
        if ($totalINRAmount > 0) {
            echo number_format(($totalINRAmount), "2");
            // echo number_format($totalINRAmount,2);
        } else {
            echo "--";
        }
    }?>">
        <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php if ($_POST['total_inv_company'] != '' && $searchallfield != '') {echo $_POST['total_inv_company'];} else {echo $comp_count;}?>">

        <input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php if ($_POST['total_inv_deal'] != '') {echo $_POST['total_inv_deal'];} else {echo $totalInv;}?>">
      <!--   <input type="hidden" name="total_inv_amount" id="total_inv_amount" value="<?php if ($_POST['total_inv_amount'] != '') {echo $_POST['total_inv_amount'];} else {echo $totalAmount;}?>">
        <input type="hidden" name="total_inv_inr_amount" id="total_inv_inr_amount" value="<?php if ($_POST['total_inv_inr_amount'] != '') {echo $_POST['total_inv_inr_amount'];} else {echo number_format(($totalINRAmount), "2");}?>">
 -->        <input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php if ($_POST['total_inv_company'] != '') {echo $_POST['total_inv_company'];} else {echo $comp_count;}?>">
        <input type="hidden" name="all_checkbox_search" id="all_checkbox_search" value="<?php if ($_POST['full_uncheck_flag'] != '') {echo $_POST['full_uncheck_flag'];} else {echo "";}?>">
        <input type="hidden" name="array_comma_company" id="array_comma_company" value="<?php echo $company_array_comma; ?>">
        <input type="hidden" name="hide_company_array" id="hide_company_array" value="<?php echo $_POST['pe_hide_companies']; ?>">
        <!-- end  -->


        <input type="hidden" name="pe_checkbox_company" id="pe_checkbox_company" value="<?php echo implode(',', $cos_array1); ?>">
         <?php if ($searchallfield != '' || $_POST['popup_keyword'] != '' || (count($_POST['industry']) > 0) || (count($_POST['sector']) > 0) || (count($_POST['subsector']) > 0) || (count($_POST['stage']) > 0) || (count($_POST['round']) > 0) || (count($_POST['txtregion']) > 0) || $_POST['citysearch'] != "" || (count($_POST['exitstatus']) > 0) || (count($_POST['valuations']) > 0) || $_POST['comptype'] != '' || $_POST['dealtype_debtequity'] != "" || $_POST['Syndication'] != "" || $_POST['invType'] != "" || ($_POST['invrangestart'] != "" && $_POST['invrangeend'] != "") || $_POST['investorauto_sug'] != "" || $_POST['companyauto_sug'] != "" || $_POST['sectorsearch'] != "" || $_POST['advisorsearch_legal'] != "" || $_POST['advisorsearch_trans'] != "" || $_POST['tagsearch'] != '' || $_POST['yearbefore'] != '' || $_POST['yearafter'] != '' || $_POST['invhead'] != '' || (count($_POST['state']) > 0)|| (count($_POST['city']) > 0)) {?>

                <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php if ($_POST['real_total_inv_deal'] != '') {echo $_POST['real_total_inv_deal'];} else {echo $totalInv;}?>">
                <input type="hidden" name="real_total_inv_amount" id="real_total_inv_amount" value="<?php if ($_POST['real_total_inv_amount'] != '') {echo $_POST['real_total_inv_amount'];} else {echo $totalAmount;}?>">
                <input type="hidden" name="real_total_inv_inr_amount" id="real_total_inv_inr_amount" value="<?php if ($_POST['real_total_inv_inr_amount'] != '') {echo $_POST['real_total_inv_inr_amount'];} else {echo number_format(($totalINRAmount), "2");}?>">
                <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php if ($_POST['real_total_inv_company'] != '') {echo $_POST['real_total_inv_company'];} else {echo $comp_count;}?>">

                <input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php if ($_POST['total_inv_deal'] != '') {echo $_POST['total_inv_deal'];} else {echo $totalInv;}?>">
                <input type="hidden" name="total_inv_amount" id="total_inv_amount" value="<?php if ($_POST['total_inv_amount'] != '') {echo $_POST['total_inv_amount'];} else {echo $totalAmount;}?>">
                <input type="hidden" name="total_inv_inr_amount" id="total_inv_inr_amount" value="<?php if ($_POST['total_inv_inr_amount'] != '') {echo $_POST['total_inv_inr_amount'];} else {echo number_format(($totalINRAmount), "2");}?>">
                <input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php if ($_POST['total_inv_company'] != '') {echo $_POST['total_inv_company'];} else {echo $comp_count;}?>">
                <input type="hidden" name="all_checkbox_search" id="all_checkbox_search" value="<?php if ($_POST['full_uncheck_flag'] != '') {echo $_POST['full_uncheck_flag'];} else {echo "";}?>">
                <input type="hidden" name="array_comma_company" id="array_comma_company" value="<?php echo $company_array_comma; ?>">

                <input type="hidden" name="hide_company_array" id="hide_company_array" value="<?php echo $_POST['pe_hide_companies']; ?>">

           <?php }?>
            <?php if ($totalno > 0) {?>
            <div class="holder" style="float:none; text-align: center;">
                <div class="paginate-wrapper" style="display: inline-block;">
                 <?php
if ($rec_limit > 0) {
    $totalpages = ceil($company_cntall / $rec_limit);
} else {
    $totalpages = 0;
}

    $firstpage = 1;
    $lastpage = $totalpages;
    $prevpage = (($currentpage - 1) > 0) ? ($currentpage - 1) : 1;
    $nextpage = (($currentpage + 1) < $totalpages) ? ($currentpage + 1) : $totalpages;
    ?>

                  <?php
$pages = array();
    $pages[] = 1;
    $pages[] = $currentpage - 2;
    $pages[] = $currentpage - 1;
    $pages[] = $currentpage;
    $pages[] = $currentpage + 1;
    $pages[] = $currentpage + 2;
    $pages[] = $totalpages;
    $pages = array_unique($pages);
    sort($pages);
    if ($currentpage < 2) {
        ?>
                 <a class="jp-previous jp-disabled" >&#8592; Previous</a>
                 <?php } else {?>
                 <a class="jp-previous" >&#8592; Previous</a>
                 <?php }
    for ($i = 0; $i < count($pages); $i++) {
        if ($pages[$i] > 0 && $pages[$i] <= $totalpages) {
            ?>
                 <a class='<?php echo ($pages[$i] == $currentpage) ? "jp-current" : "jp-page" ?>'  ><?php echo $pages[$i]; ?></a>
                 <?php }
    }
    if ($currentpage < $totalpages) {
        ?>
                 <a class="jp-next">Next &#8594;</a>
                     <?php } else {?>
                  <a class="jp-next jp-disabled">Next &#8594;</a>
                     <?php }?>
                     </div>
             </div>
           <?php
}
if ($studentOption == 1) {
    ?>
                     <script type="text/javascript" >
                           $("#show-total-deal").html('<span class="res_total"><?php echo $totalInv;?></span> Results found (across <span class="comp_total"><?php echo $comp_count;?></span> cos) ');
                           $("#show-total-amount").html('<h2>Amount (US$ M) <span><?php

        if ($totalAmount > 0) {
            echo number_format($totalAmount, 2);
        } else {
            echo "--";
        }
    ?></span></h2>');

                           $("#show-total-inr-amount").html('<h2 style="margin-left: 5px;">/ (INR CR) <span><?php

        if ($totalINRAmount > 0) {
            echo number_format(($totalINRAmount), "2");
            //echo number_format($totalINRAmount,2);
        } else {
            echo "--";
        }
    ?></span></h2>');

                    </script>
                    <?php
if ($exportToExcel == 1) {
        ?>
                        <span style="float:right" class="one">
                        <input class ="export" type="button"  value="Export" name="showdeals">
                        </span>
                              <div class="title-links" id="exportbtn"></div>
                        <script type="text/javascript">
                              $('#exportbtn').html('<a class="export_new" id="expshowdeals" name="showdeals">Export</a>');
                        </script>
                    <?php
}
} else {
    /*if($exportToExcel==1)
    {*/
    ?>
                               <script type="text/javascript" >
                                $("#show-total-deal").html('<span class="res_total"><?php echo $totalInv;?></span> Results found (across <span class="comp_total"><?php echo $comp_count;?></span> cos)');
                                $("#show-total-amount").html('<h2> Amount (US$ M) <span><?php
        if ($totalAmount > 0) {
            echo number_format($totalAmount, 2);
        } else {
            echo "--";
        }

    ?></span></h2>');

                                $("#show-total-inr-amount").html('<h2 style="margin-left: 5px;">/ (INR CR) <span><?php
        if ($totalINRAmount > 0) {
            echo number_format(($totalINRAmount), "2");
            // echo number_format($totalINRAmount,2);
        } else {
            echo "--";
        }
    ?></span></h2>');

                            </script>


                            <?php if ($inrnote == "") {?>
                                <script type="text/javascript" >
                                    $(".inr-note").hide();
                                    $(".is-inr").hide();
                                </script>
                             <?php }?>

                    <?php
/*}
    else
    {
    ?>
    <script type="text/javascript" >
    $("#show-total-deal").html('XXX Results found ');
    $("#show-total-amount").html('<h2> Amount (US$ M) YYY</h2>');
    </script>
    <div><p>Aggregate data for each search result is displayed here for Paid Subscribers </p></div>
    <?php
    }*/
    if (($totalInv > 0 || $exportflag > 0) && ($exportToExcel == 1)) {
        ?>
                        <span style="float:right; padding: 0px 20px;" class="one">
                            <a class ="export_new" id="expshowdealsbt" name="showdeals">Export</a>
                        </span>
                        <script type="text/javascript">
                            <?php  if($vcflagValue == '0'){?>
                                $('#exportbtn').html('<a class ="export_new" id="expshowdeals" data-type="multicheckbox" name="showdeals">Export</a>');
                            <?php }else{?>
                                $('#exportbtn').html('<a class ="export_new" id="expshowdeals" data-type="nomulticheckbox" name="showdeals">Export</a>');
                            <?php } ?>
                        </script>

                            <?php
} elseif (($totalInv > 0 || $exportflag > 0) && ($exportToExcel == 0)) {$tourautostart = 'ON';
        ?>
                                    <div>
                                    <span>
                                    <p><b>Note:</b> Only paid subscribers will be able to export data on to Excel.Clicking Sample Export button for a sample spreadsheet containing PE investments.  </p>
                                    <span style="float:right;margin-right: 20px;" class="one">
                                         <!--a class ="export" type="submit"  value="Export" name="showdeals"></a-->
                                    <a class ="export" target="_blank" href="<?php echo $samplexls; ?> ">Sample Export</a>
                                    </span>
                                    <script type="text/javascript">
                        $('#exportbtn').html('<a class="export"  href="<?php echo $samplexls; ?>">Export Sample</a>');
                                    </script>
                                    </span>
                                </div>
                    <?php
}
}
?>




    </div>
    <?php /*if( $company_cnt > 0 ) {*/?>
    <div class="other_db_search" >
        <div class="other_db_searchresult" style="<?php if ($totalno == 0) {echo "margin-top:20px;";}?>">
            <p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>
        </div>
    </div>
    <?php /*}*/?>
    <?php
if (!isset($_POST['tagsfield'])) {
    include "tag_report.php";
}
?>
    <!--<div class="overview-cnt mt-trend-tab">
        <div class="showhide-link-wrap">
            <!--div class="showhide-link"><a href="#" class="show_hide <?php echo ($_GET['type'] != '') ? 'active' : ''; ?>" rel="#slidingTable"><i></i><span>Trend View</span></a></div-->
            <!--<div class="showhide-link" id="trendnav" style="z-index: 100000"><a href="#" class="show_hide <?php echo ($_GET['type'] != '') ? '' : ''; ?>" rel="#slidingTable" id='ldtrend'><i></i><span>Trend View</span></a></div>
        </div>
        <div  id="slidingTable" style="display: none;overflow:hidden;">
            <?php
//include_once("trendviewlatest.php");
?>
            <table width="100%">
                    <?php
if ($type != 1) {
    ?>
                    <tr>
                        <td width="50%" class="profile-view-left">
                         <div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;z-index:-10"></div>
                        </td>
                        <td class="profile-view-rigth" width="50%" >
                          <div id="visualization3" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>
                        </td>
                    </tr>

                    <tr>
                        <td width="50%" class="profile-view-left" id="chartbar">
                                <div id="visualization1" style="max-width: 100%; height: 750px;overflow-x: auto;overflow-y: hidden;"></div>
                        </td>
                        <td  id="chartbar" class="profile-view-rigth" width="50%" >
                                <div id="visualization" style="max-width: 100%; height: 700px;overflow-x: auto;overflow-y: hidden;"></div>
                        </td>
                    </tr>
                    <?php
} else {
    ?>
                    <tr>
                        <td colspan="2" width="100%">
                            <div id="visualization2" style="max-width: 100%; height: 600px;overflow-x: auto;overflow-y: hidden;z-index:-10"></div>
                        </td>
                    </tr>
                    <?php
}
?>
                    <tr>
                         <td class="profile-view-left" colspan="2">
                             <input class ="export" type="button" id="exporttrend"  value="Export" name="exporttrend">
                             <div class="showhide-link link-expand-table">
                                <a href="#" class="show_hide" rel="#slidingDataTable">View Table</a>
                             </div><br>
                             <div class="view-table expand-table" id="slidingDataTable" style="display:none; overflow:hidden;">
                                <div class="restable">
                                    <table class="testTable1" cellpadding="0" cellspacing="0" id="restable">
                                        <tr><td>&nbsp;</td></tr>
                                    </table>
                                </div>
                             </div>
                         </td>
                    </tr>
            </table>
        </div>
    </div>-->
</td>
<input type="hidden" name="period_flag" id="period_flag" value="<?php echo $period_flag; ?>" />
</tr>
</table>

</div>
<div class=""></div>
</form>
            <!--input class="postlink" type="hidden" name="numberofcom" value="<?php echo $totalInv; ?>"-->
            <form name="pelisting" id="pelisting"  method="post" action="exportinvdeals.php">
                 <input type="hidden" name="sql" value="<?php echo $exportsql; ?>" >
                 <input type="hidden" name="split_sql" value="<?php echo $exportSplitSql; ?>" >
                 <input type="hidden" name="split_group" value="<?php echo $exportSplitGroup; ?>" >
                 <input type="hidden" name="split_sql1" value="<?php echo $exportSplitSql1; ?>" >
                 <input type="hidden" name="split_group1" value="<?php echo $exportSplitGroup1; ?>" >
                 <input type="hidden" name="split_orderby" value="<?php echo $exportSplitOrderBy; ?>" >
                 <input type="hidden" name="txthideinvestor" value="<?php echo $keywordhidden; ?>" >
                 <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode(',', $pe_checkbox); ?>">
                 <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode(',', $pe_checkbox_enable); ?>">
                 <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if ($_POST['full_uncheck_flag'] != '') {echo $_POST['full_uncheck_flag'];} else {echo "";}?>">
                <!-- T960 ---------------------------------------->
                <input type="hidden" class="resultarray" name="resultarray" value=""/>
                 <!-- T960 end ------------------------------------>
                 <?php /*if($_POST) { ?>
<input type="hidden" name="txtsearchon" value="1" >
<input type="hidden" name="txttitle" value=<?php echo  $vcflagValue; ?> >
<input type="hidden" name="txthidename" value=<?php echo $username; ?> >
<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
<input type="hidden" name="txthideindustry" value=<?php echo ($industryvalue)?$industryvalue:""; ?> >
<input type="hidden" name="txthideindustryid" value=<?php echo $industry_hide; ?> >
<input type="hidden" name="txthidestage" value=<?php echo $stagevaluetext; ?> >
<input type="hidden" name="txthidestageid" value=<?php echo $stageidvalue; ?> >
<input type="hidden" name="txthideround" value="<?php echo $roundTxtVal; ?>">
<input type="hidden" name="txthidevaluation" value="<?php echo $valuationsql; ?> ">

<input type="hidden" name="txthidecomptype" value=<?php echo $companyType; ?> >
<input type="hidden" name="txthidedebt_equity" value=<?php echo $debt_equity; ?> >
<input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
<input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
<input type="hidden" name="txthideregionvalue" value=<?php echo $regionvalue; ?> >
<input type="hidden" name="txthideregionid" value=<?php echo $region_hide; ?> >
<input type="hidden" name="txthidecity" value="<?php echo $city; ?>">
<input type="hidden" name="txthiderange" value=<?php echo $startRangeValue; ?>-<?php  echo $endRangeValueDisplay-0.01; ?> >
<input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?>>
<input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValueDisplay-0.01; ?> >
<input type="hidden" name="txthideexitstatusValue" value=<?php echo $exitstatusValue_hide; ?> >

<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

<input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
<input type="hidden" name="txthidecompany" value=<?php echo $companysearchhidden; ?> >
<input type="hidden" name="txthidesector" value="<?php echo $sectorsearchhidden; ?>" >
<input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
<input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >
<input type="hidden" name="txthideaddDelind" value=<?php echo $addDelindhidden; ?> >

<?php } else { ?>

<input type="hidden" name="txtsearchon" value="1" >
<input type="hidden" name="txttitle" value=<?php echo  $vcflagValue; ?> >
<input type="hidden" name="txthidename" value=<?php echo $username; ?> >
<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
<input type="hidden" name="txthideindustry" value="">
<input type="hidden" name="txthideindustryid" value="--">
<input type="hidden" name="txthidestage" value="">
<input type="hidden" name="txthidestageid" value="">
<input type="hidden" name="txthideround" value="--">
<input type="hidden" name="txthidecomptype" value="--">
<input type="hidden" name="txthidedebt_equity" value="--">
<input type="hidden" name="txthideinvtype" value="">
<input type="hidden" name="txthideinvtypeid" value="--">
<input type="hidden" name="txthideregionvalue" value="">
<input type="hidden" name="txthideregionid" value="--">
<input type="hidden" name="txthidecity" value="">
<input type="hidden" name="txthiderange" value="-----">
<input type="hidden" name="txthiderangeStartValue" value="--">
<input type="hidden" name="txthiderangeEndValue" value="--">

<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

<input type="hidden" name="txthideinvestor" value="">
<input type="hidden" name="txthidecompany" value="">
<input type="hidden" name="txthidesector" value="" >
<input type="hidden" name="txthideadvisor_legal" value="">
<input type="hidden" name="txthideadvisor_trans" value="">
<input type="hidden" name="txthidesearchallfield" value="">
<input type="hidden" name="txthideaddDelind" value=<?php echo $addDelindhidden; ?> >

<?php } */?>

    </form>
    <form name="exporttrend" id="exporttable"  method="post" action="ajxExcel.php">
        <input type="hidden" id="exporttablesql" name="exporttablesql" value="<?php echo $companysql; ?>" >
    </form>

            <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
            <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
            <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
            <script src="js/listviewfunctions.js"></script>
             <script type="text/javascript">
               var  orderby='<?php echo $orderby; ?>';
               var  ordertype='<?php echo $ordertype; ?>';
                $(".jp-next").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                  var  pageno=$("#next").val();
                    loadhtml(pageno,orderby,ordertype);}
                    return  false;
                });
                $(".jp-page").live("click",function(){
                   var pageno=$(this).text();
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });
                $(".jp-previous").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    var pageno=$("#prev").val();
                    loadhtml(pageno,orderby,ordertype);
                    }
                    return  false;
                });
        $(".header").live("click",function(){
                    orderby=$(this).attr('id');

                    if($(this).hasClass("asc"))
                        ordertype="desc";
                    else
                        ordertype="asc";
                    loadhtml(1,orderby,ordertype);
                    return  false;
                });

            //     $(document).on('click','#agreebtn',function(){
            //         $('#popup-box-copyrights').fadeOut();
            //        $('#maskscreen').fadeOut(1000);
            //        $('#preloading').fadeIn();
            //        initExport();
            //        return false;
            //    });

            //    $(document).on('click','#expcancelbtn',function(){

            //        jQuery('#popup-box-copyrights').fadeOut();
            //        jQuery('#maskscreen').fadeOut(1000);
            //        return false;
            //    });
             // T960 Start ---------------------------------------------------
             $(document).on('click','#agreebtn-filter',function(){
                    if($('.exportcheck:checked').length == 0){
                        alert('Please select minimum one field');
                        return false;
                    }
                    $('#popup-box-copyrights').fadeOut();   
                    $('#maskscreen').fadeIn();
                    $('#preloading').fadeIn();  
                    $('#popup-box-copyrights-filter').fadeIn(); 
                    
                });
                $(document).on('click','#expcancelbtn-filter',function(){

                    jQuery('#popup-box-copyrights-filter').fadeOut();   
                    jQuery('#maskscreen').fadeOut(1000);
                    $('#preloading').fadeOut();
                    return false;
                });
                $(document).on('click','#agreebtn',function(){
                    $('#popup-box-copyrights-filter').fadeOut();   
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
                // T960 End ------------------------------------------------------

                function loadhtml(pageno,orderby,ordertype)
                {
                    var peuncheckVal = $( '#pe_checkbox_disbale' ).val();
                    var full_check_flag =  $( '#all_checkbox_search' ).val();
                    var pecheckedVal = $( '#pe_checkbox_enable' ).val();
                    jQuery('#preloading').fadeIn(1000);
                    $.ajax({
                        type : 'POST',
                        url  : 'ajaxListview.php',
                        data: {

                            sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                            totalrecords : '<?php echo addslashes($company_cntall); ?>',
                            page: pageno,
                            vcflagvalue:'<?php echo $vcflagValue; ?>',
                            orderby:orderby,
                            ordertype:ordertype,
                            searchField: '<?php echo $searchallfield; ?>',
                            industry:'<?php echo $industry; ?>',
                            stage:'<?php echo $stageval; ?>',
                            round:'<?php echo $round; ?>',
                            company:'<?php echo $companyType; ?>',
                            dealtype:'<?php echo $debt_equity; ?>',
                            syndication:'<?php echo $syndication; ?>',
                            region:'<?php echo $regionId; ?>',
                            city:'<?php echo $city; ?>',
                            investortype:'<?php echo $investorType; ?>',
                            startrange:'<?php echo $startRangeValue; ?>',
                            endrange:'<?php echo $endRangeValue; ?>',
                            exit:'<?php echo $exitstatusValue; ?>',
                            valuation:'<?php echo $valuations; ?>',
                            investor:'<?php echo $investorauto_sug_other; ?>',
                            companysearch:'<?php echo $companysearch_other; ?>',
                            sectorsearch:'<?php echo $sectorsearch_other; ?>',
                            legalAdvisor:'<?php echo $advisorsearch_legal_other; ?>',
                            transactionAdvisor:'<?php echo $advisorsearch_trans_other; ?>',
                            tagsearch:'<?php echo $tagsearch; ?>',
                            uncheckRows: peuncheckVal,
                            checkedRow:pecheckedVal,
                            full_uncheck_flag :  full_check_flag,
                            listallcompany : '<?php echo $listallcompany; ?>'
                        },
                        success : function(data){
                                $(".view-table-list").html(data);
                                $(".jp-current").text(pageno);
                                var  prev=parseInt(pageno)-1
                                if(prev>0)
                                $("#prev").val(pageno-1);
                                else
                                {
                                $("#prev").val(1);
                        //                        $(".jp-previous").addClass('.jp-disabled').removeClass('.jp-previous');
                                }
                                $("#current").val(pageno);
                                var next=parseInt(pageno)+1;
                                if(next < <?php echo $totalpages ?> )
                                 $("#next").val(next);
                                else
                                {
                                $("#next").val(<?php echo $totalpages ?>);
                        //                        $(".jp-next").addClass('.jp-disabled').removeClass('.jp-next');
                                }
                                drawNav(<?php echo $totalpages ?>,parseInt(pageno))
                                jQuery('#preloading').fadeOut(500);

                                return  false;
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                                jQuery('#preloading').fadeOut(500);
                                alert('There was an error');
                        }
                    });
                }
                var pehideFlag = '';
                $(document).on( 'ifChanged','.pe_checkbox', function(event) {

                    var amountChnage = true;
                    var isconverted = <?php echo $hideinrcount . ";" ?>
                    var peuncheckCompdId = $( event.target ).val();
                    var peuncheckAmount = $(event.target).data('deal-amount');
                    if(isconverted == 0){
                        var peuncheckINRAmount = $(event.target).data('deal-inramount');
                    } else {
                        var peuncheckINRAmount = $(event.target).data('deal-amount');
                    }
                    var peuncheckCompany = $( event.target ).data( 'company-id' );
                    pehideFlag = $(event.target).data('hide-flag');
                    var total_invdeal = $("#real_total_inv_deal").val();
                    var total_invcompany = $("#real_total_inv_company").val();

                    if( peuncheckAmount == '--' || pehideFlag == 1 ) {
                        amountChnage = false;
                    } else {
                        peuncheckAmount = parseFloat( $(event.target).data('deal-amount') );
                        if(isconverted == 0){
                            peuncheckINRAmount = parseFloat( $(event.target).data('deal-inramount') );
                        } else {
                            peuncheckINRAmount = parseFloat( $(event.target).data('deal-amount') );
                        }
                    }

                    var cur_val = $("#pe_checkbox_disbale").val();
                    var cur_val1 = $("#hide_company_array").val();
                    var cur_va2 = $("#pe_checkbox_enable").val();

                    var lastElement = $(event.target).parents('#myTable tbody .details_link').is(':last-child');

                    if( $( event.target ).prop('checked') ) {

                        $(event.target).parents('.details_link').removeClass('event_stop');
                        if( cur_va2 != '' ) {
                            $('#pe_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );
                            $('#export_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );

                        } else {
                            $('#pe_checkbox_enable').val( peuncheckCompdId );
                            $('#export_checkbox_enable').val( peuncheckCompdId );

                        }
                        var strArray = cur_val.split(',');
                        for( var i = 0; i < strArray.length; i++ ) {
                            if ( strArray[i] === peuncheckCompdId ) {
                                strArray.splice(i, 1);
                            }
                        }
                        $('#pe_checkbox_disbale').val( strArray );
                        $('#txthidepe').val( strArray );

                        var strArray1 = cur_val1.split(',');
                        for( var i = 0; i < strArray1.length; i++ ) {
                            if ( strArray1[i] === peuncheckCompdId ) {
                                strArray1.splice(i, 1);
                            }
                        }
                        if( pehideFlag == 1 ) {

                            $( '#hide_company_array' ).val( strArray1 );
                        }

                        updateCountandAmount( peuncheckINRAmount, peuncheckAmount, 'add', amountChnage, pehideFlag, total_invdeal);
                        updateCompanyCount( peuncheckCompany, 'add', lastElement, pehideFlag,total_invcompany );
                    }else {

                        $(event.target).parents('.details_link').addClass('event_stop');

                        var strArray2 = cur_va2.split(',');
                        for( var i = 0; i < strArray2.length; i++ ) {
                            if ( strArray2[i] === peuncheckCompdId ) {
                                strArray2.splice(i, 1);
                            }
                        }
                        $('#pe_checkbox_enable').val( strArray2 );
                        $('#export_checkbox_enable').val( strArray2 );

                        if( cur_val != '' ){
                            $('#pe_checkbox_disbale').val( cur_val + "," + peuncheckCompdId );
                            $('#txthidepe').val( cur_val + "," + peuncheckCompdId );
                        }else{
                            $('#pe_checkbox_disbale').val( peuncheckCompdId );
                            $('#txthidepe').val( peuncheckCompdId );
                        }
                        if( pehideFlag == 1 ) {

                            if( cur_val1 != '' ) {
                                $('#hide_company_array').val( cur_val1 + "," + peuncheckCompdId );
                            } else {
                                $('#hide_company_array').val( peuncheckCompdId );
                            }

                        }
                        updateCountandAmount( peuncheckINRAmount, peuncheckAmount, 'remove', amountChnage, pehideFlag,total_invdeal);
                        updateCompanyCount( peuncheckCompany, 'remove', lastElement, pehideFlag,total_invcompany );
                    }

                });

                $( '.all_checkbox' ).on( 'ifChanged', function(event) {

                    if( $( event.target ).prop('checked') ) {

                        $( '#pe_checkbox_company' ).val($("#array_comma_company").val());

                        $( '#show-total-deal span.res_total' ).text( $("#real_total_inv_deal").val() );
                        $( '#show-total-amount h2 span' ).text($("#real_total_inv_amount").val() );
                        $( '#show-total-inr-amount h2 span' ).text($("#real_total_inv_inr_amount").val() );
                        $( '#show-total-deal span.comp_total' ).text($("#real_total_inv_company").val());
                        $( '#pe_checkbox_disbale' ).val('');

                        $( '#total_inv_deal' ).val($("#real_total_inv_deal").val());
                        $( '#total_inv_amount' ).val($("#real_total_inv_amount").val());
                        $( '#total_inv_inr_amount' ).val($("#real_total_inv_inr_amount").val());
                        $( '#total_inv_company' ).val($("#real_total_inv_company").val());
                        $( '#txthidepe' ).val('');
                        $( '#pe_checkbox_enable' ).val('');
                        $( '#export_checkbox_enable' ).val('');
                        $( '#all_checkbox_search' ).val('');
                        $( '#export_full_uncheck_flag' ).val('');
                        $( '#hide_company_array' ).val('');
                        $( '#expshowdeals').show();

                        $('.pe_checkbox').each(function(){ //iterate all listed checkbox items
                            $(this).prop("checked",true);
                            $(this).parents('.details_link').removeClass('event_stop');
                            $(this).parents('.icheckbox_flat-red').addClass('checked');
                        });

                    }else{

                        $(event.target).parents('.details_link').addClass('event_stop');
                        $( '#pe_checkbox_company' ).val('');
                        $( '#pe_checkbox_enable' ).val('');
                        $( '#hide_company_array' ).val('');
                        $( '#export_checkbox_enable' ).val('');
                        $( '#pe_checkbox_disbale').val('');
                        $( '#show-total-deal span.res_total' ).text( 0 );
                        $( '#show-total-amount h2 span' ).text(0 );
                        $( '#show-total-inr-amount h2 span' ).text(0 );
                        $( '#show-total-deal span.comp_total' ).text(0);
                        $( '#total_inv_deal' ).val('0');
                        $( '#total_inv_amount' ).val('0');
                        $( '#total_inv_inr_amount' ).val('0');
                        $( '#total_inv_company' ).val('0');
                        $( '#all_checkbox_search' ).val('1');
                        $( '#export_full_uncheck_flag' ).val('1');
                        $( '#expshowdeals').hide();

                        $('.pe_checkbox').each(function(){ //iterate all listed checkbox items

                           $(this).parents('.details_link').addClass('event_stop');
                           $(this).prop('checked',false);
                        });
                        $('.icheckbox_flat-red').removeClass('checked');
                    }
                });

          /*  $( '.all_checkbox' ).on( 'ifChanged', function(event) {

                 if( $( event.target ).prop('checked') ) {

                    $( '#show-total-deal span.res_total' ).text( $("#total_inv_deal").val() );
                     $( '#show-total-amount h2 span' ).text($("#total_inv_amount").val() );
                     $( '#show-total-deal span.comp_total' ).text($("#total_inv_company").val());
                     $( '#pe_checkbox_disbale' ).val('');
                     $( '#all_checkbox_search' ).val('0');
                     //$( '#pe_checkbox_company' ).val($("#array_comma_company").val());
                     $('.pe_checkbox').each(function(){ //iterate all listed checkbox items
                        $(this).prop("checked",true);
                        $(this).parents('.icheckbox_flat-red').addClass('checked');
                    });

                 }else{

                     $( '#show-total-deal span.res_total' ).text( 0 );
                     $( '#show-total-amount h2 span' ).text(0 );
                     $( '#show-total-deal span.comp_total' ).text(0);
                     $( '#pe_checkbox_company' ).val('');
                     $( '#all_checkbox_search' ).val('1');

                    $('.pe_checkbox').each(function(){ //iterate all listed checkbox items

                        $(this).prop('checked',false);
                    });
                    $('.icheckbox_flat-red').removeClass('checked');

                 }
            });*/

            // $('#expshowdeals').click(function(){

            //     jQuery('#maskscreen').fadeIn();
            //     jQuery('#popup-box-copyrights').fadeIn();
            //     return false;

            // });
                // Start T960 -------------------------------------------------------------
            $('#expshowdeals').click(function(){
                $exportmultiselect = $('#expshowdeals').attr("data-type");
                if($exportmultiselect == 'multicheckbox'){
                    jQuery('#maskscreen').fadeIn();
                    jQuery('#popup-box-copyrights').fadeIn();
                    $('.exportcheck').iCheck('destroy');
                    $('.companyexportcheck').iCheck('destroy');
                    $('.allexportcheck').iCheck('destroy');
                    $('.allexportcheck').iCheck('check');
                    $(".resultarray").val('Select-All');
                    $('.exportcolumn .exportcheck').attr('checked', true); 
                    return false;
                }else if($exportmultiselect == 'nomulticheckbox'){
                    jQuery('#maskscreen').fadeIn();
                    jQuery('#popup-box-copyrights-filter').fadeIn();
                    $(".resultarray").val('Select-All');
                    return false;    
                }
                
            });
            // End T960 -----------------------------------------------------------

            $('#expshowdealsbt').click(function(){
                /*jQuery('#preloading').fadeIn();
                initExport();
                return false;*/

                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();
                return false;
            });

             function updateCountandAmount( elementINRAmount, elementAmount, type, amountFlag, pehideFlag, total_invdeal ) {
                /*var cur_val = $("#pe_checkbox_disbale").val();
                var strArray = cur_val.split(',');
                console.log( strArray );
                var unchekedlength = strArray.length;*/
                var isconverted = <?php echo $hideinrcount . ";" ?>
                var currentusd = <?php echo $usdtoinramount . ";" ?>
                var totalFound = parseFloat( $( '#show-total-deal span.res_total' ).text() );
                var labelAmount = $( '#show-total-amount h2 span' ).text();
                var labelINRAmount = $( '#show-total-inr-amount h2 span' ).text();
                var amountChange = true;
                if( labelAmount == '--' ) {
                    amountChange = false;
                } else {
                    var totalResAmount = parseFloat( labelAmount.replace(',','').replace(' ','') );
                    var totalResINRAmount = parseFloat( labelINRAmount.replace(',','').replace(' ','') );
                }
                if( type == 'add' ) {
                    var currAmount = totalResAmount + elementAmount;
                    if(isconverted == 0){
                        var currINRAmount = totalResINRAmount + elementINRAmount;
                    } else {
                        var currINRAmount = currAmount * 1000000 * currentusd / 10000000;

                    }
                   if(pehideFlag!=1){
                        var currTotal = totalFound + 1;
                    }else{
                        var currTotal = totalFound;
                    }
                } else {
                    var currAmount = totalResAmount - elementAmount;
                    if(isconverted == 0){
                        var currINRAmount = totalResINRAmount - elementINRAmount;
                    } else {
                        var currINRAmount = currAmount * 1000000 * currentusd / 10000000;

                    }
                    if(pehideFlag!=1){
                        var currTotal = totalFound - 1;
                    }else{
                        var currTotal = totalFound;
                    }
                }
                if( currAmount < 0 || currTotal == 0 ) {
                    currAmount = 0;
                    $( '#expshowdeals').hide(); //junaid
                }else{
                    $( '#expshowdeals').show(); //junaid
                }
                if( amountFlag && amountChange ) {
                    $( '#show-total-amount h2 span' ).text( currAmount.toFixed(2) );
                    $( '#show-total-inr-amount h2 span' ).text( currINRAmount.toFixed(2) );
                    $( '#show-total-amount h2 span' ).text( $( '#show-total-amount h2 span' ).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
                    $( '#show-total-inr-amount h2 span' ).text( $( '#show-total-inr-amount h2 span' ).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
                    $( '#pe_checkbox_amount' ).val( currAmount.toFixed(2) );
                    $( '#total_inv_amount').val(currAmount.toFixed(2));
                    $( '#total_inv_inr_amount').val(currINRAmount.toFixed(2));
                }

                 //------------------------------junaid--------------------------------

                if(currTotal >= total_invdeal && $('#hide_company_array').val()==''){
                    $('#export_checkbox_enable').val('');
                    $('#all_checkbox').prop('checked',true);
                    $('#all_checkbox').parents('.icheckbox_flat-red').addClass('checked');
                    //$( '#all_checkbox_search' ).val('1');
                }else{
                    $('#all_checkbox').prop('checked',false);
                    $('#all_checkbox').parents('.icheckbox_flat-red').removeClass('checked');

                }
                //-------------------------------------------------------
                if( pehideFlag == 0 ) {
                    $( '#show-total-deal span.res_total' ).text( currTotal );
                    $( '#total_inv_deal').val(currTotal); //junaid
                }
            }

            function updateCompanyCount( elementCompany, type, lastElement, pehideFlag,total_invcompany ) {
                var counts = {};
                var removedcompanyData = '';
                var companyData = $( '#pe_checkbox_company' ).val();
                if( type == 'remove' ) {
                    if( pehideFlag == 0 ) {
//                        if( lastElement ) {
//                            removedcompanyData = companyData.replace( elementCompany, '' );
//                        } else {
//                            removedcompanyData = companyData.replace( elementCompany+',', '' );
//                        }
                        removedcompanyData = companyData.replace( elementCompany, '' );
                        removedcompanyData = removedcompanyData.replace(/(^,)|(,$)/g, "");
                        $('#pe_checkbox_company').val( removedcompanyData );
                    }
                } else {
                    if( pehideFlag == 0 ) {
                        if( companyData != '' ) {
                            $('#pe_checkbox_company').val( companyData + "," + elementCompany );
                        } else {
                            $('#pe_checkbox_company').val( elementCompany );
                        }
                    }
                }
                var newCompanyData = $( '#pe_checkbox_company' ).val();
                var arr = newCompanyData.split(',');
                jQuery.each(arr, function(key,value) {
                    if( value != '' ) {
                        if (!counts.hasOwnProperty(value)) {
                            counts[value] = 0;
                        } else {
                            counts[value]++;
                        }
                    }
                });
                $( '#show-total-deal span.comp_total' ).text( Object.keys(counts).length );
                 $( '#total_inv_company').val(Object.keys(counts).length); //junaid
            }

            function initExport(){
                    $.ajax({
                        url: 'ajxCheckDownload.php',
                        dataType: 'json',
                        success: function(data){
                            var downloaded = data['recDownloaded'];
                            var exportLimit = data.exportLimit;
                            var currentRec = <?php echo $totalInv; ?>;

                            //alert(currentRec + downloaded);
                            var remLimit = exportLimit-downloaded;

                            if (currentRec < remLimit){
                                hrefval= 'exportinvdeals.php';
                                $("#pelisting").attr("action", hrefval);
                                $("#pelisting").submit();
                                jQuery('#preloading').fadeOut();
                            }else{
                                jQuery('#preloading').fadeOut();
                                //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                            }
                        },
                        error:function(){
                            jQuery('#preloading').fadeOut();
                            alert("There was some problem exporting...");
                        }

                    });
                }

                $("a.postlink").click(function(){

                    $('<input>').attr({
                    type: 'hidden',
                    id: 'foo',
                    name: 'searchallfield',
                    value:'<?php echo $searchallfield; ?>'
                    }).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;

                });
                function resetinput(fieldname)
                {
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }

                function resetmultipleinput(fieldname,fieldid)
                {
                    
                  $("#resetfield").val(fieldname);
                  $("#resetfieldid").val(fieldid);
                  
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }

            </script>
            <script type="text/javascript">

            /*$('#expshowdeals').click(function(){
                    hrefval= 'exportinvdeals.php';
            $("#pelisting").attr("action", hrefval);
            $("#pelisting").submit();
            return false;
            });*/

                $("a.postlink").live('click',function(){

                    $('<input>').attr({
                    type: 'hidden',
                    id: 'foo',
                    name: 'searchallfield',
                    value:'<?php echo $searchallfield; ?>'
                    }).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;

                });
                function resetinput(fieldname)
                {
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
                function resetmultipleinput(fieldname,fieldid)
                {
                    
                  $("#resetfield").val(fieldname);
                  $("#resetfieldid").val(fieldid);
                  
                  //alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }


           /* $(document).on('click', 'tr .details_link', function(){

                idval=$(this).attr("valueId");
                $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/dealdetails.php?value="+idval).trigger("click");
            });*/
            </script>

<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>



             <form id="other_db_submit" method="post">
                <input type="hidden" name="searchallfield_other" id="other_searchallfield" value="<?php echo $searchallfield; ?>">
                <input type="hidden" name="companyauto_sug_other" id="companyauto_sug_other" value="<?php echo $companyauto; ?>">
                <input type="hidden" name="companysearch_other" id="companysearch_other" value="<?php echo $company_filter; ?>">
                <input type="hidden" name="investorauto_sug_other" id="investorauto_sug_other" value="<?php echo $investorauto; ?>">
                <input type="hidden" name="keywordsearch_other" id="keywordsearch_other" value="<?php echo $invester_filter; ?>">
                <input type="hidden" name="sectorsearch_other" id="sectorsearch_other" value="<?php echo $sectors_filter; ?>">
                <input type="hidden" name="advisorsearch_legal_other" id="advisorsearch_legal_other" value="<?php echo $advisorsearchstring_legal; ?>">
                <input type="hidden" name="advisorsearch_trans_other" id="advisorsearch_trans_other" value="<?php echo $advisorsearchstring_trans; ?>">
                <input type="hidden" name="all_keyword_other" id="all_keyword_other" value="">
            </form>
   <!-- <div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">

        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div> -->
<!-- T960 start-------------------------------------------------------------------->
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 100% !important; display: none;"></div>
    <div class="lb" id="popup-box-copyrights" style="width:65% !important;left:20%;top:10%;">
    <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body">
        <h3  style="text-align: center;font-size:19px;">Select fields for excel file export</h3>
        <div class="row">
            <label style="font-weight: 600;"><input type="checkbox" class="allexportcheck" id="allexportcheck"/> Select All</label>
            <ul class="exportcolumn">
                <!-- <li><input type="checkbox" class="companyexportcheck" name="skills" value="Company" checked/> <span> Company</span></li> -->
                <li><input type="checkbox" class="exportcheck" name="skills" value="Company"/> <span> Company</span></li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Company Type" /> Company Type</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Industry" /> Industry</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Sector" /> Sector</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Amount(US$M)" /> Amount (US$M)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Amount(INR Cr)" /> Amount(INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Round" /> Round</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Stage" /> Stage</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Investors" /> Investors</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Investor Type" /> Investor Type</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Stake (%)"/> Stake (%)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Date"/> Date</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Exit Status" /> Exit Status</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Website" /> Website</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Year Founded" /> Year Founded</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="City" /> City</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="State" /> State</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Region" /> Region</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Advisor-Company" /> Advisor-Company</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Advisor-Investors" /> Advisor-Investors</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="More Details" /> More Details</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Link" /> Link</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Pre Money Valuation (INR Cr)" /> Pre Money Valuation (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue Multiple (Pre)" /> Revenue Multiple (Pre)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA Multiple (Pre)" /> EBITDA Multiple (Pre)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="PAT Multiple (Pre)" /> PAT Multiple (Pre)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Post Money Valuation (INR Cr)" /> Post Money Valuation (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue Multiple (Post)" /> Revenue Multiple (Post)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA Multiple (Post)" /> EBITDA Multiple (Post)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="PAT Multiple (Post)" /> PAT Multiple (Post)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Enterprise Valuation (INR Cr)" /> Enterprise Valuation (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue Multiple (EV)" /> Revenue Multiple (EV)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA Multiple (EV)" /> EBITDA Multiple (EV)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="PAT Multiple (EV)" /> PAT Multiple (EV)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Price to Book" /> Price to Book</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Valuation" /> Valuation</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Revenue (INR Cr)" /> Revenue (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="EBITDA (INR Cr)" /> EBITDA (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="PAT (INR Cr)" /> PAT (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Total Debt (INR Cr)" /> Total Debt (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Cash & Cash Equ. (INR Cr)" /> Cash & Cash Equ. (INR Cr)</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Book Value Per Share" /> Book Value Per Share</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Price Per Share" /> Price Per Share</li>
                <li><input type="checkbox" class="exportcheck" name="skills" value="Link for Financials" /> Link for Financials</li>
            </ul>
        </div>
        <div class="cr_entry" style="text-align:center;margin-top:25px;">
            <input type="button" value="Submit" id="agreebtn-filter" />
        </div>
   </div>
</div>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 100% !important; display: none;"></div>
<div class="lb" id="popup-box-copyrights-filter" style="width:650px !important;">
   <span id="expcancelbtn-filter" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;margin-top:25px;">
        <input type="button" value="Submit" id="agreebtn" />
    </div>
</div>
<!-- T960 end--------------------------------------------------------------------------->

</body>
</html>

<?php
function returnMonthname($mth)
{
    if ($mth == 1) {
        return "Jan";
    } elseif ($mth == 2) {
        return "Feb";
    } elseif ($mth == 3) {
        return "Mar";
    } elseif ($mth == 4) {
        return "Apr";
    } elseif ($mth == 5) {
        return "May";
    } elseif ($mth == 6) {
        return "Jun";
    } elseif ($mth == 7) {
        return "Jul";
    } elseif ($mth == 8) {
        return "Aug";
    } elseif ($mth == 9) {
        return "Sep";
    } elseif ($mth == 10) {
        return "Oct";
    } elseif ($mth == 11) {
        return "Nov";
    } elseif ($mth == 12) {
        return "Dec";
    }

}
function writeSql_for_no_records($sqlqry, $mailid)
{
    $write_filename = "pe_query_no_records.txt";
    //echo "<Br>***".$sqlqry;
    $schema_insert = "";
    //TRYING TO WRIRE IN EXCEL
    //define separator (defines columns in excel & tabs in word)
    $sep = "\t"; //tabbed character
    $cr = "\n"; //new line

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
            echo "Error saving file!";}
    }

    print "\n";

}

?>
 <script language="javascript">
 //T960 start ------------------------------------------------------------------->
$(document).ready(function () {
    $('.exportcheck').iCheck('destroy');
    $('.allexportcheck').iCheck('destroy');
    $('.companyexportcheck').iCheck('destroy');
    $('.allexportcheck').iCheck('check');
    $(".resultarray").val('Select-All');
    $(document).on("click",".allexportcheck",function() {
        if ($(this).is(':checked')) {
            $('.exportcolumn .exportcheck').attr('checked', true);
            $('.exportcolumn .exportcheck').trigger('change');
        }else {
            $('.allexportcheck').attr('checked', false);
            $('.exportcolumn .exportcheck').attr('checked', false);
            $(".resultarray").val('');
        }
    });
    $(document).on("click",".companyexportcheck",function() {
        if ($(this).is(':checked')) {
            $('.exportcolumn .companyexportcheck').attr('checked', true);
            $('.exportcolumn .companyexportcheck').trigger('change');
        }else {
            $('.companyexportcheck').attr('checked', true);
        }
    });
    $(document).on("change",".exportcheck",function() {
        var result = $('.exportcolumn input[type="checkbox"]:checked'); // this return collection of items checked
        var totalcheckbox = $('.exportcolumn input[type="checkbox"]');
        if (result.length > 0) {
            var resultString ="";
            result.each(function () {
                resultString += $(this).val() + "," ;
                // resultString+= $(this).val() + "<br/>";
            });
            resultString =  resultString.replace(/,\s*$/, "");
			$(".resultarray").val(resultString);
        }
        if(result.length==totalcheckbox.length)
        {
            $('.allexportcheck').attr('checked', true);
        }
        else{
            $('.allexportcheck').attr('checked', false);
        }
    });
});
// T960 end -------------------------------------------------------------------->
 
     $(document).ready(function(){
            $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){

                     //$('.list-tab').css('position', 'relative');
                     //$('.view-table table thead').css('position', 'relative');
                     $('.view-table table thead').css('z-index', '1000');
                    }
                    else
                    {
                         //$('.list-tab').css('position', 'fixed');
                         //$('.view-table table thead').css('position', 'fixed');
                         $('.view-table table thead').css('z-index', '1000');
                    }
            });
    });
    </script>
<?php if ($type == 1 && $vcflagValue == 0) {?>

    <script language="javascript">
    $(document).ready(function(){
        $("#ldtrend").click(function () {



            if($(".show_hide").attr('class')!='show_hide'){

                         /*$('.list-tab').css('position', 'relative');
                         $('.view-table-list').css('margin-top', '');*/
                var htmlinner = $(".profile-view-title").html();
                $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                //Execute SQL
                $.ajax({
                    type : 'POST',
                    url  : 'ajxQuery.php',
                    dataType : 'json',
                    data: {
                        sql : '<?php echo addslashes($companysql); ?>'
                    },
                    success : function(data){
                        drawVisualization(data);
                        $(".profile-view-title").html(htmlinner);
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('There was an error');
                    }
                });
            }

        });
    });
    </script>


    <script type="text/javascript">
      function drawVisualization(dealdata) {

        var data = new google.visualization.DataTable();
        data.addColumn('string','Year');
        data.addColumn('number', 'No of Deals');
        data.addColumn('number', 'Amount($m)');
        data.addRows(dealdata.length);
        for (var i=0; i< dealdata.length ;i++){
            for(var j=0; j< dealdata[i].length ;j++){
                if (j!=0)
                    data.setValue(i, j,Math.round(dealdata[i][j]-0));
                else
                    data.setValue(i, j,dealdata[i][j]);
            }
        }

        // Create and draw the visualization.
        var chart = new google.visualization.LineChart(document.getElementById('visualization2'));

        divwidth  =  document.getElementById("visualization2").offsetWidth;
        divheight =  document.getElementById("visualization2").offsetHight;

       function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=0&y='+topping;
             <?php if ($drilldownflag == 1) {?>
                window.location.href = 'index.php?'+query_string;
             <?php }?>
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'No of Deals'
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );

             //Fill table
             var pintblcnt = '';
             var tblCont = '';

             pintblcnt = '<table class="testTable1" cellpadding="0" cellspacing="0" id="restable">';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';
             //pintblcnt = pintblcnt + '</thead>';
             //pintblcnt = pintblcnt + '<tbody>';

             //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';
             for (var i=0; i< dealdata.length ;i++){
                tblCont = tblCont + '<tr>';
                for(var j=0; j< dealdata[i].length ;j++){
                    if (j==0){
                        pintblcnt = pintblcnt + '<tr><th style="text-align:center">'+ dealdata[i][j] + '</th><tr>';
                    }
                    tblCont = tblCont + '<td style="text-align:center">'+ dealdata[i][j] + '</td>';
                }
                tblCont = tblCont + '</tr>';

             }
             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';
             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);

             //updateTables();
      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
      <?php

} else if ($type == 1 && $vcflagValue == 1) {?>

    <script language="javascript">
    $(document).ready(function(){
        $("#ldtrend").click(function () {
            if($(".show_hide").attr('class')!='show_hide'){
                var htmlinner = $(".profile-view-title").html();
                $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                //Execute SQL
                $.ajax({
                    type : 'POST',
                    url  : 'ajxQuery.php',
                    dataType : 'json',
                    data: {
                        sql : '<?php echo addslashes($companysql); ?>',
                    },
                    success : function(data){
                        drawVisualization(data);
                        $(".profile-view-title").html(htmlinner);
                                                $(window).trigger('resize');
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('There was an error');
                    }
                });
            }
        });
    });
    </script>


    <script type="text/javascript">
      function drawVisualization(dealdata) {

        var data = new google.visualization.DataTable();
        data.addColumn('string','Year');
        data.addColumn('number', 'No of Deals');
        data.addColumn('number', 'Amount($m)');
        data.addRows(dealdata.length);
        for (var i=0; i< dealdata.length ;i++){
            for(var j=0; j< dealdata[i].length ;j++){
                if (j!=0)
                    data.setValue(i, j,Math.round(dealdata[i][j]-0));
                else
                    data.setValue(i, j,dealdata[i][j]);
            }
        }
        // Create and draw the visualization.
        var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
        divwidth=  document.getElementById("visualization2").offsetWidth;
        divheight=  document.getElementById("visualization2").offsetHight;

       function selectHandler() {

          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=1&y='+topping;
             <?php if ($drilldownflag == 1) {?>
             window.location.href = 'index.php?'+query_string;
            <?php }?>
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'No of Deals'
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
//                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );

            //Fill table
             var pintblcnt = '';
             var tblCont = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">Year</th><tr>';

             //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">Year</th><th style="text-align:center">No. of Deals</th><th style="text-align:center">Amount($m)</th></tr>';
             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';
             for (var i=0; i< dealdata.length ;i++){
                tblCont = tblCont + '<tr>';
                                tblCont = tblCont + '<th>&nbsp;</th>';
                for(var j=0; j< dealdata[i].length ;j++){
                    if (j==0){
                        pintblcnt = pintblcnt + '<tr><th style="text-align:center">'+ dealdata[i][j] + '</th><tr>';
                    }
                    tblCont = tblCont + '<td style="text-align:center">'+ dealdata[i][j] + '</td>';
                }
                tblCont = tblCont + '</tr>';

             }
              pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '<tbody>';
             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);

      }
      //google.setOnLoadCallback(drawVisualization);
    </script>
      <?php

} else if ($type == 2 && $vcflagValue == 0) { //  print_r($deal);   ?>

    <script language="javascript">

    $(document).ready(function(){
            setTimeout(function (){
                    $( "#ldtrend" ).trigger( "click" );
            },1000);

        $("#ldtrend").click(function () {
            if($(".show_hide").attr('class')!='show_hide'){
                var htmlinner = $(".profile-view-title").html();
                $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                //Execute SQL
                $.ajax({
                    type : 'POST',
                    url  : 'ajxQuery.php',
                    dataType : 'json',
                    data: {
                        sql : '<?php echo addslashes($companysql); ?>',
                    },
                    success : function(data){
                        drawVisualization(data);
                        $(".profile-view-title").html(htmlinner);

                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        alert('There was an error');
                    }
                });
            }
        });
                $("#exporttrend").click(function(){

//                    var tab_text=$('.restable').html();
//                    if(tab_text=='undefined' || tab_text==''){
//                        tab_text=$('.responsiveTableContainer').html();
                    $("#exporttable").submit();
                });
//              $("#exporttrend").click(function (e) {
//
//                        //var tab_text="'"+$('.restable').html()+"'";
//                        var tab_text=$('.restable').html();
//
//                        //alert(dataArr);
//                        $.ajax({
//                  type : 'POST',
//                  url  : 'ajxExcel.php',
//                                        dataType: 'html',
//                  data: {
//                      content:tab_text,
//                  },
//                  success : function(data){
//                                                //alert(data);
//                                                window.open('ajxExcel.php');
//                  },
//                  error : function(XMLHttpRequest, textStatus, errorThrown) {
//                      alert('There was an error');
//                  }
//              });

//
//                        var textRange; var j=0;
//                        tab_text=$('.restable').html();
//                        tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
//                        tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
//                        tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
//
//                        var ua = window.navigator.userAgent;
//                        var msie = ua.indexOf("MSIE ");
//
//                        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
//                        {
//
////                            txtArea1.document.open("txt/html","replace");
////                            txtArea1.document.write(tab_text);
////                            txtArea1.document.close();
////                            txtArea1.focus();
////                            txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
//
//                        }
//                        else{
//                            //other browser not tested on IE 11
//                                // download stuff
//                                var fileName = "export.xls";
//                                var buffer = tab_text;
//                                var blob = new Blob([buffer], {
//                                    "type": "mimeType;"
//                                });
//                                var link = document.createElement("a");
//
//                                if (link.download !== undefined) { // feature detection
//                                    // Browsers that support HTML5 download attribute
//                                    link.setAttribute("href", window.URL.createObjectURL(blob));
//                                    link.setAttribute("download", fileName);
//                                    document.body.appendChild(link);
//                                    link.click();
//                                    document.body.removeChild(link);
//                                } else {
//                                    alert('CSV export only works in Chrome, Firefox, and Opera.');
//                                }
//                        }


           // });
    });
    </script>


    <script type="text/javascript">
            function in_array(array, id) {
                    for(var i=0;i<array.length;i++) {
                            if(array[i] == id) {
                                    return true;
                            }
                    }
                    return false;
            }

        function drawVisualization(dealdata) {

            var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var arrval = [];
                arrval.push(Years[j]);
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);

            // Create and populate the data table.
            var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
            divwidth=  document.getElementById("visualization1").offsetWidth;
            divheight=  document.getElementById("visualization1").offsetHight;

            function selectHandler() {
                var selectedItem = chart1.getSelection()[0];
                if (selectedItem) {
                    var topping = data1.getValue(selectedItem.row, 0);
                    var industry = data1.getColumnLabel(selectedItem.column).toString();
                    //alert('The user selected ' + topping +industry);

                    var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
                    <?php if ($drilldownflag == 1) {?>
                     window.location.href = 'index.php?'+query_string;
                    <?php }?>
                  }
            }

            google.visualization.events.addListener(chart1, 'select', selectHandler);
            chart1.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
//                colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
//"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],
                isStacked : true,
              });


            //Graph 2
            var data = new google.visualization.DataTable();
            data.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var arrval = [];
                arrval.push(Years[j]);
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            var data = google.visualization.arrayToDataTable(dataArray);
            //var data = new google.visualization.DataTable();

            var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));

             function selectHandler2() {
              var selectedItem = chart2.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var industry = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);

                var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
                <?php if ($drilldownflag == 1) {?>
                 window.location.href = 'index.php?'+query_string;
                <?php }?>
              }
            }
             google.visualization.events.addListener(chart2, 'select', selectHandler2);
              chart2.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
//                  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
//"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],
                    isStacked : true
                  }
              );


            //Graph 3
            var data3 = new google.visualization.DataTable();
            data3.addColumn('string','Industry');
            data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }



            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization2')).
              draw(data3, {title:"No of Deals"/*,
              colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


            //Graph 4

            var data4 = new google.visualization.DataTable();
            data4.addColumn('string','Industry');
            data4.addColumn('number', 'Amount');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(Math.round(dealdata[i][3]-0));
                    dataArray.push(temArray);
                }
            }

            //console.log(dataArray);
            //console.log(dealdata);

            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);
            }

            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount"/*,
             colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


            //Fill table

            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            //console.log(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table class="testTable1" >';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';

                         //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">INDUSTRY</th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                 if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';

                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    //flag =1;
                }
                tblCont = tblCont + '<tr>';
                //console.log(dataArray[arrhead[i]]);
            }

             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
        }
//      function trendview(dealdata){
//
//                            var dataArray = [];
//          var arrhead = [];
//          for (var i=0; i< dealdata.length ;i++){
//              if (!in_array(arrhead,dealdata[i][0]))
//               arrhead.push(dealdata[i][0]);
//          }
//
//
//          //Get Years
//          var Years = [];
//          for (var i=0; i< dealdata.length ;i++){
//              if (!in_array(Years,dealdata[i][1]))
//               Years.push(dealdata[i][1]);
//          }
//
//
//          for(var i=0;i<arrhead.length;i++){
//              var tempArr = [];
//              for (var j=0; j< dealdata.length ;j++){
//                  var values = [];
//                  if (dealdata[j][0]==arrhead[i]){
//                      if (dealdata[j][2])
//                          values.push(dealdata[j][2]);
//                      else
//                          values.push('0');
//
//                      if (dealdata[j][3])
//                          values.push(dealdata[j][3]);
//                      else
//                          values.push('0');
//
//                      tempArr[dealdata[j][1]] =  values;
//                  }
//              }
//              dataArray[arrhead[i]] = tempArr;
//          }
//
//          //console.log(dataArray);
//
//           var tblCont = '';
//           var pintblcnt = '';
//
//           pintblcnt = '<div id=dvdata>'
//           pintblcnt = pintblcnt + '<table class="testTable1" >';
//           pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';
//
//                         //tblCont = '<thead>';
//           tblCont = tblCont + '<tr><th style="text-align:center">INDUSTRY</th>';
//           for (var i=0; i< Years.length ;i++){
//              tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
//           }
//           tblCont = tblCont + '</tr>';
//            tblCont = tblCont + '<tr><th style="text-align:center"></th>';
//           for (var i=0; i< Years.length ;i++){
//               if (i==0){
//                   pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
//               }
//              tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
//           }
//           tblCont = tblCont + '</tr>';
//
//
//           //tblCont = tblCont + '</thead>';
//           //tblCont = tblCont + '<tbody>';
//
//           /*for(i=0;i<dataArray.length;i++){
//               console.log(dataArray[i]);
//           }*/
//          var val= [];
//
//          for(var i=0;i<arrhead.length;i++){
//              tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
//              pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
//
//              //var flag =0;
//              for(var j=0;j<Years.length;j++){
//                  var deal = '';
//                  var amt  = '';
//                  val = dataArray[arrhead[i]][Years[j]];
//                  if (val){
//                          deal = val['0'];
//                          amt = val['1'];
//                  }
//                  /*if(flag==1)
//                      tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
//                  else*/
//                      tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
//                  //flag =1;
//              }
//              tblCont = tblCont + '<tr>';
//              //console.log(dataArray[arrhead[i]]);
//          }
//
//           pintblcnt = pintblcnt + '</table>';
//                         window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
//                         e.preventDefault();
//
//
//                }
        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }
    </script>


   <?php
} else if ($type == 2 && $vcflagValue == 1) {
    ?>
        <script language="javascript">
            $(document).ready(function(){
              setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
              },1000);
            $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){
                        var htmlinner = $(".profile-view-title").html();
                        $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                        //Execute SQL
                        $.ajax({
                            type : 'POST',
                            url  : 'ajxQuery.php',
                            dataType : 'json',
                            data: {
                                sql : '<?php echo addslashes($companysql); ?>',
                            },
                            success : function(data){
                                drawVisualization(data);
                                $(".profile-view-title").html(htmlinner);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('There was an error');
                            }
                        });
                    }
                });
            });
        </script>

        <script type="text/javascript">
            //Graph 1
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }

        function drawVisualization(dealdata) {

            var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var arrval = [];
                arrval.push(Years[j]);
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);

            // Create and populate the data table.
            var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
            divwidth=  document.getElementById("visualization1").offsetWidth;
            divheight=  document.getElementById("visualization1").offsetHight;

            function selectHandler() {
                var selectedItem = chart1.getSelection()[0];
                if (selectedItem) {
                    var topping = data1.getValue(selectedItem.row, 0);
                    var industry = data1.getColumnLabel(selectedItem.column).toString();
                    //alert('The user selected ' + topping +industry);

                    var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
                    <?php if ($drilldownflag == 1) {?>
                     window.location.href = 'index.php?'+query_string;
                    <?php }?>
                  }
            }

            google.visualization.events.addListener(chart1, 'select', selectHandler);
            chart1.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true,
              });


            //Graph 2
            var data = new google.visualization.DataTable();
            data.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var arrval = [];
                arrval.push(Years[j]);
                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            var data = google.visualization.arrayToDataTable(dataArray);
            //var data = new google.visualization.DataTable();

            var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));

             function selectHandler2() {
              var selectedItem = chart2.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var industry = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);

                var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
                <?php if ($drilldownflag == 1) {?>
                 window.location.href = 'index.php?'+query_string;
                <?php }?>
              }
            }
             google.visualization.events.addListener(chart2, 'select', selectHandler2);
              chart2.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }
              );


            //Graph 3
            var data3 = new google.visualization.DataTable();
            data3.addColumn('string','Industry');
            data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }



            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization2')).
              draw(data3, {title:"No of Deals"/*,
              colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


            //Graph 4

            var data4 = new google.visualization.DataTable();
            data4.addColumn('string','Industry');
            data4.addColumn('number', 'Amount');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(Math.round(dealdata[i][3]-0));
                    dataArray.push(temArray);
                }
            }

            //console.log(dataArray);
            //console.log(dealdata);

            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);
            }

            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount"/*,
             colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


            //Fill table

            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }


            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INDUSTRY</th><tr>';

                        //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">INDUSTRY</th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    //flag =1;
                }
                tblCont = tblCont + '<tr>';

                //console.log(dataArray[arrhead[i]]);
            }

             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);

        }

        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }
        </script>


    <?php
} else if ($type == 3 && $vcflagValue == 0) {
    ?>

    <script language="javascript">
            $(document).ready(function(){
                setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
              },1000);
                $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){
                        var htmlinner = $(".profile-view-title").html();
                        $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                        //Execute SQL
                        $.ajax({
                            type : 'POST',
                            url  : 'ajxQuery.php',
                            dataType : 'json',
                            data: {
                                sql : '<?php echo addslashes($companysql); ?>',
                            },
                            success : function(data){
                                drawVisualization(data);
                                $(".profile-view-title").html(htmlinner);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('There was an error');
                            }
                        });
                    }
                });
            });
        </script>

    <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }

        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }

        function drawVisualization(dealdata) {



        var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);


        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
              <?php if ($drilldownflag == 1) {?>
             window.location.href = 'index.php?'+query_string;
            <?php }?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );

            //Garaph 2
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var totalamt = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal amount of the year
                for (var i=1;i<arrhead.length;i++){
                    totalamt += datayear[j][arrhead[i]];
                }

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push((((datayear[j][arrhead[i]]/totalamt)*100).toFixed(2))-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            //Graph 1
            var data = google.visualization.arrayToDataTable(dataArray);
             var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
              var selectedItem = chart5.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var stage = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);

               var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
                 <?php if ($drilldownflag == 1) {?>
                 window.location.href = 'index.php?'+query_string;
                <?php }?>
              }
            }
             google.visualization.events.addListener(chart5, 'select', selectHandler2);
             chart5.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Amount"},
                  /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }
              );


              //Graph 3
              var data3 = new google.visualization.DataTable();
              data3.addColumn('string','Stage');
                data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }
            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization2')).
              draw(data3, {title:"No of Deals"/*,
              colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


             //Graph 4
            var data4 = new google.visualization.DataTable();
            data4.addColumn('string','Stage');
            data4.addColumn('number', 'Amount');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(Math.round(dealdata[i][3]-0));
                    dataArray.push(temArray);
                }
            }

            //console.log(dataArray);
            //console.log(dealdata);

            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);
            }
             // Create and draw the visualization.
            var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
            chart.draw(data4, {title:"Amount"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
            google.visualization.events.addListener(chart, 'select', function() {
                var selection = chart.getSelection();
                //console.log(selection);
            });


            //Fill table

            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }


            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">STAGE</th><tr>';

                         //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">STAGE</th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                 if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    flag =1;
                }

                tblCont = tblCont + '<tr>';
                //console.log(dataArray[arrhead[i]]);
            }
            pintblcnt = pintblcnt + '</table>';
            //tblCont = tblCont + '</tbody>';

            $('#restable').html(tblCont);
            $('.pinned').html(pintblcnt);
        }
    </script>


    <?php
} else if ($type == 3 && $vcflagValue == 1) {
    ?>
         <script language="javascript">
            $(document).ready(function(){
              setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
              },1000);
                $("#ldtrend").click(function () {
                    if($(".show_hide").attr('class')!='show_hide'){
                        var htmlinner = $(".profile-view-title").html();
                        $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');
                        //Execute SQL
                        $.ajax({
                            type : 'POST',
                            url  : 'ajxQuery.php',
                            dataType : 'json',
                            data: {
                                sql : '<?php echo addslashes($companysql); ?>',
                            },
                            success : function(data){
                                drawVisualization(data);
                                $(".profile-view-title").html(htmlinner);
                            },
                            error : function(XMLHttpRequest, textStatus, errorThrown) {
                                alert('There was an error');
                            }
                        });
                    }
                });
            });
        </script>

    <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }

        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }

        function drawVisualization(dealdata) {



        var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push((((datayear[j][arrhead[i]]/totalDeals)*100).toFixed(2))-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);


        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
              <?php if ($drilldownflag == 1) {?>
             window.location.href = 'index.php?'+query_string;
            <?php }?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );

            //Garaph 2
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                var totalamt = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal amount of the year
                for (var i=1;i<arrhead.length;i++){
                    totalamt += datayear[j][arrhead[i]];
                }

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push((((datayear[j][arrhead[i]]/totalamt)*100).toFixed(2))-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            //Graph 1
            var data = google.visualization.arrayToDataTable(dataArray);
             var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
              var selectedItem = chart5.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var stage = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);

               var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
                 <?php if ($drilldownflag == 1) {?>
                 window.location.href = 'index.php?'+query_string;
                <?php }?>
              }
            }
             google.visualization.events.addListener(chart5, 'select', selectHandler2);
             chart5.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                   /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }
              );


              //Graph 3
              var data3 = new google.visualization.DataTable();
              data3.addColumn('string','Stage');
                data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }
            // Create and draw the visualization.
            new google.visualization.PieChart(document.getElementById('visualization2')).
              draw(data3, {title:"No of Deal"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


             //Graph 4
            var data4 = new google.visualization.DataTable();
            data4.addColumn('string','Stage');
            data4.addColumn('number', 'Amount');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(Math.round(dealdata[i][3]-0));
                    dataArray.push(temArray);
                }
            }

            //console.log(dataArray);
            //console.log(dealdata);

            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);
            }
             // Create and draw the visualization.
            var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
            chart.draw(data4, {title:"Amount"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
            google.visualization.events.addListener(chart, 'select', function() {
                var selection = chart.getSelection();
            });


            //Fill table

            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }


            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">STAGE</th><tr>';

                         //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">STAGE</th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    //flag =1;
                }
                tblCont = tblCont + '<tr>';
                //console.log(dataArray[arrhead[i]]);
            }

             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
        }
    </script>
    <?php
} else if ($type == 4 && $vcflagValue == 0) {
    ?>
    <script language="javascript">
        $(document).ready(function(){
                    setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
              },1000);
            $("#ldtrend").click(function () {
                if($(".show_hide").attr('class')!='show_hide'){
                    var htmlinner = $(".profile-view-title").html();
                    $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

                    //Execute SQL
                    $.ajax({
                        type : 'POST',
                        url  : 'ajxQuery.php',
                        dataType : 'json',
                        data: {
                            sql : '<?php echo addslashes($compRangeSql); ?>',
                            typ : '4',
                            rng : '<?php echo implode('#', $range); ?>',
                        },
                        success : function(data){
                            drawVisualization(data);
                            $(".profile-view-title").html(htmlinner);
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('There was an error');
                        }
                    });
                }
            });
        });
    </script>
   <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }

        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }

        function drawVisualization(dealdata) {

        //alert(dealdata.length);

        var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);

            var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
              var selectedItem = chart6.getSelection()[0];
              if (selectedItem) {
                var topping = data1.getValue(selectedItem.row, 0);
                var range = data1.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);

               var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
                 <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
              }
            }
             google.visualization.events.addListener(chart6, 'select', selectHandler);
              chart6.draw(data1,
                   {
                    title:"No of Deals",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Deals"},
                    /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }

              );



            //Graph 2
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            var data = google.visualization.arrayToDataTable(dataArray);

            var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
                         function selectHandler2() {
              var selectedItem = chart7.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var range = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);

               var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
                 <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;<?php }?>
              }
                          }

             google.visualization.events.addListener(chart7, 'select', selectHandler2);
              chart7.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }
              );

            //Graph 3
             var data3 = new google.visualization.DataTable();
              data3.addColumn('string','Stage');
                data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }

            // Create and draw the visualization.
              new google.visualization.PieChart(document.getElementById('visualization2')).
                  draw(data3, {title:"No of Deals"/*,
                  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});



            //Graph 4
            var data4 = new google.visualization.DataTable();
            data4.addColumn('string','Stage');
            data4.addColumn('number', 'Amount');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(Math.round(dealdata[i][3]-0));
                    dataArray.push(temArray);
                }
            }

            //console.log(dataArray);
            //console.log(dealdata);

            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);
            }

            // Create and draw the visualization.
              new google.visualization.PieChart(document.getElementById('visualization3')).
                  draw(data4, {title:"Amount"/*,
                  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});



            //Fill table
            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }


            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';

                         //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">RANGE</th>';
             for (var i=0; i< Years.length ;i++){
                if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    //flag =1;
                }

                //console.log(dataArray[arrhead[i]]);
            }


             //tblCont = tblCont + '</tbody>';
             pintblcnt = pintblcnt + '</table>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);

        }
    </script>

    <?php
} else if ($type == 4 && $vcflagValue == 1) {?>

        <script language="javascript">
        $(document).ready(function(){
            setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
              },1000);
            $("#ldtrend").click(function () {
                if($(".show_hide").attr('class')!='show_hide'){
                    var htmlinner = $(".profile-view-title").html();
                    $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

                    //Execute SQL
                    $.ajax({
                        type : 'POST',
                        url  : 'ajxQuery.php',
                        dataType : 'json',
                        data: {
                            sql : '<?php echo addslashes($compRangeSql); ?>',
                            typ : '4',
                            rng : '<?php echo implode('#', $range); ?>',
                        },
                        success : function(data){
                            drawVisualization(data);
                            $(".profile-view-title").html(htmlinner);
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('There was an error');
                        }
                    });
                }
            });
        });
    </script>
   <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }

        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }

        function drawVisualization(dealdata) {

        //alert(dealdata.length);

        var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            //Graph 1
            var data1 = google.visualization.arrayToDataTable(dataArray);

            var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
              var selectedItem = chart6.getSelection()[0];
              if (selectedItem) {
                var topping = data1.getValue(selectedItem.row, 0);
                var range = data1.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);

               var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
                 <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
              }
            }
             google.visualization.events.addListener(chart6, 'select', selectHandler);
              chart6.draw(data1,
                   {
                    title:"No of Deals",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "No of Deals"},
                    /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }

              );



            //Graph 2
            var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }

            var data = google.visualization.arrayToDataTable(dataArray);

            var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
            function selectHandler2() {
              var selectedItem = chart7.getSelection()[0];
              if (selectedItem) {
                var topping = data.getValue(selectedItem.row, 0);
                var range = data.getColumnLabel(selectedItem.column).toString();
                //alert('The user selected ' + topping +industry);

               var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
                 <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
              }
            }
             google.visualization.events.addListener(chart7, 'select', selectHandler2);
              chart7.draw(data,
                   {
                    title:"Amount",
                    width:500, height:700,
                    hAxis: {title: "Year"},
                    vAxis: {title: "Amount"},
                    /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                    isStacked : true
                  }
              );

            //Graph 3
             var data3 = new google.visualization.DataTable();
              data3.addColumn('string','Stage');
                data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }

            // Create and draw the visualization.
              new google.visualization.PieChart(document.getElementById('visualization2')).
                  draw(data3, {title:"No of Deals"/*,
                  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});



            //Graph 4
            var data4 = new google.visualization.DataTable();
            data4.addColumn('string','Stage');
            data4.addColumn('number', 'Amount');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(Math.round(dealdata[i][3]-0));
                    dataArray.push(temArray);
                }
            }

            //console.log(dataArray);
            //console.log(dealdata);

            data4.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data4.setValue(i,0,dataArray[i][0]);
                data4.setValue(i,1,dataArray[i][1]-0);
            }

            // Create and draw the visualization.
              new google.visualization.PieChart(document.getElementById('visualization3')).
                  draw(data4, {title:"Amount"/*,
                  colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


            //Fill table
            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }


            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">RANGE</th><tr>';

                         //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">RANGE</th>';
             for (var i=0; i< Years.length ;i++){
                 if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    flag =1;
                }

                //console.log(dataArray[arrhead[i]]);
            }


             //tblCont = tblCont + '</tbody>';
             pintblcnt = pintblcnt + '</table>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);


        }
    </script>

    <?php
} else if ($type == 5 && $vcflagValue == 0) {?>

        <script language="javascript">
        $(document).ready(function(){
                            setTimeout(function (){
                            $( "#ldtrend" ).trigger( "click" );
                        },1000);
                            $("#ldtrend").click(function () {
                if($(".show_hide").attr('class')!='show_hide'){
                    var htmlinner = $(".profile-view-title").html();
                    $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

                    //Execute SQL
                    $.ajax({
                        type : 'POST',
                        url  : 'ajxQuery.php',
                        dataType : 'json',
                        data: {
                            sql : '<?php echo addslashes($companysql); ?>',
                        },
                        success : function(data){
                                           //console.log(data);
                            drawVisualization(data);
                            $(".profile-view-title").html(htmlinner);
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('There was an error');
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }

        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }

        function drawVisualization(dealdata) {

        var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }


            var data1 = google.visualization.arrayToDataTable(dataArray);

        var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
              /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );

          //Graph 2
                var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }


            var data = google.visualization.arrayToDataTable(dataArray);

          var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );


          //Graph 3
            var data3 = new google.visualization.DataTable();
            data3.addColumn('string','Stage');
            data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }

          // Create and draw the visualization.
          new google.visualization.PieChart(document.getElementById('visualization2')).
              draw(data3, {title:"By Deal"/*,
              /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


        //Graph 4
        var data4 = new google.visualization.DataTable();
        data4.addColumn('string','Stage');
        data4.addColumn('number', 'Amount');

        //Remove Duplicate and make sum
        var dataArray = [];
        for (var i=0; i< dealdata.length ;i++){
            dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

            if (dealcnt==0){
                var temArray = [];
                temArray.push(dealdata[i][0]);
                temArray.push(Math.round(dealdata[i][3]-0));
                dataArray.push(temArray);
            }
        }

        //console.log(dataArray);
        //console.log(dealdata);

        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);
        }
    // Create and draw the visualization.
      new google.visualization.PieChart(document.getElementById('visualization3')).
          draw(data4, {title:"Amount"/*,
          colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


          //Fill table
            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }


            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';

                         //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">INVESTOR</th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    //flag =1;
                }
                tblCont = tblCont + '<tr>';
                //console.log(dataArray[arrhead[i]]);
            }

             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);


        }

        </script>

    <?php
} else if ($type == 5 && $vcflagValue == 1) {
    ?>
    <script language="javascript">
        $(document).ready(function(){
            setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
                        },1000);
                            $("#ldtrend").click(function () {
                if($(".show_hide").attr('class')!='show_hide'){
                    var htmlinner = $(".profile-view-title").html();
                    $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

                    //Execute SQL
                    $.ajax({
                        type : 'POST',
                        url  : 'ajxQuery.php',
                        dataType : 'json',
                        data: {
                            sql : '<?php echo addslashes($companysql); ?>',
                        },
                        success : function(data){
                            drawVisualization(data);
                            $(".profile-view-title").html(htmlinner);
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('There was an error');
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }

        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }

        function drawVisualization(dealdata) {

        var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }


            var data1 = google.visualization.arrayToDataTable(dataArray);

        var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );

          //Graph 2
                var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }


            var data = google.visualization.arrayToDataTable(dataArray);

          var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );


          //Graph 3
            var data3 = new google.visualization.DataTable();
            data3.addColumn('string','Stage');
            data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }

          // Create and draw the visualization.
          new google.visualization.PieChart(document.getElementById('visualization2')).
              draw(data3, {title:"By Deal"/*,
              colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


        //Graph 4
        var data4 = new google.visualization.DataTable();
        data4.addColumn('string','Stage');
        data4.addColumn('number', 'Amount');

        //Remove Duplicate and make sum
        var dataArray = [];
        for (var i=0; i< dealdata.length ;i++){
            dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

            if (dealcnt==0){
                var temArray = [];
                temArray.push(dealdata[i][0]);
                temArray.push(Math.round(dealdata[i][3]-0));
                dataArray.push(temArray);
            }
        }

        //console.log(dataArray);
        //console.log(dealdata);

        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);
        }
    // Create and draw the visualization.
      new google.visualization.PieChart(document.getElementById('visualization3')).
          draw(data4, {title:"Amount"/*,
          colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});

          //Fill table
            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }


            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">INVESTOR</th><tr>';

                         //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">INVESTOR</th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';

                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    //flag =1;
                }
                tblCont = tblCont + '<tr>';
                //console.log(dataArray[arrhead[i]]);
            }

             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
        }

        </script>

    <?php
} else if ($type == 6 && $vcflagValue == 0) {
    ?>
        <script language="javascript">
        $(document).ready(function(){
            setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
              },1000);
        $("#ldtrend").click(function () {
                if($(".show_hide").attr('class')!='show_hide'){
                    var htmlinner = $(".profile-view-title").html();
                    $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

                    //Execute SQL
                    $.ajax({
                        type : 'POST',
                        url  : 'ajxQuery.php',
                        dataType : 'json',
                        data: {
                            sql : '<?php echo addslashes($companysql); ?>',
                        },
                        success : function(data){
                            drawVisualization(data);
                            $(".profile-view-title").html(htmlinner);
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('There was an error');
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }

        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }

        function drawVisualization(dealdata) {
        //Grpah 1
        var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }


        var data1 = google.visualization.arrayToDataTable(dataArray);

        chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
        function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );


          //Graph 2
           var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }


            var data = google.visualization.arrayToDataTable(dataArray);

          var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );


          //Graph 3
            var data3 = new google.visualization.DataTable();
            data3.addColumn('string','Stage');
            data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }

          // Create and draw the visualization.
          new google.visualization.PieChart(document.getElementById('visualization2')).
              draw(data3, {title:"No of Deals"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


        //Graph 4
        var data4 = new google.visualization.DataTable();
        data4.addColumn('string','Stage');
        data4.addColumn('number', 'Amount');

        //Remove Duplicate and make sum
        var dataArray = [];
        for (var i=0; i< dealdata.length ;i++){
            dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

            if (dealcnt==0){
                var temArray = [];
                temArray.push(dealdata[i][0]);
                temArray.push(Math.round(dealdata[i][3]-0));
                dataArray.push(temArray);
            }
        }

        //console.log(dataArray);
        //console.log(dealdata);

        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);
        }

        // Create and draw the visualization.
          new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount"/*,
              colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


          //Fill table
            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }


            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">REGION</th><tr>';

                         //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">REGION</th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';

                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    flag =1;
                }
                tblCont = tblCont + '<tr>';
                //console.log(dataArray[arrhead[i]]);
            }

             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);

        }
      </script>

    <?php } else if ($type == 6 && $vcflagValue == 1) {?>

        <script language="javascript">
        $(document).ready(function(){
            setTimeout(function (){
                      $( "#ldtrend" ).trigger( "click" );
              },1000);
        $("#ldtrend").click(function () {
                if($(".show_hide").attr('class')!='show_hide'){
                    var htmlinner = $(".profile-view-title").html();
                    $(".profile-view-title").html(htmlinner + '<br><br><font color="green">Please wait while we load the graph...</font>');

                    //Execute SQL
                    $.ajax({
                        type : 'POST',
                        url  : 'ajxQuery.php',
                        dataType : 'json',
                        data: {
                            sql : '<?php echo addslashes($companysql); ?>',
                        },
                        success : function(data){
                            drawVisualization(data);
                            $(".profile-view-title").html(htmlinner);
                        },
                        error : function(XMLHttpRequest, textStatus, errorThrown) {
                            alert('There was an error');
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript">
        function in_array(array, id) {
            for(var i=0;i<array.length;i++) {
                if(array[i] == id) {
                    return true;
                }
            }
            return false;
        }

        function dealcount(ind,dataArray,dlCnt){
            var dealcount = 0;
            for(i=0;i<dataArray.length;i++){
                if(dataArray[i][0]==ind){
                    dealcount = dataArray[i][1];
                    dataArray[i][1] = (dealcount-0) + (dlCnt-0);
                }
            }
            return dealcount;
        }

        function drawVisualization(dealdata) {
        //Grpah 1
        var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][2]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }


        var data1 = google.visualization.arrayToDataTable(dataArray);

        chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
        function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );


          //Graph 2
           var data1 = new google.visualization.DataTable();
            data1.addColumn('string','Year');
            for (var i=0; i< dealdata.length ;i++){
                data1.addColumn('number',dealdata[i][0]);
            }

            //Create Head
            var dataArray = [];
            var arrhead = [];
            arrhead.push('Year');
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }
            dataArray.push(arrhead);

            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }

            //Data by Year and industry
            var datayear = [];

            for(var j=0; j < Years.length ;j++){
                var dataind = [];
                for (var i=0; i< dealdata.length ;i++){
                    if (dealdata[i][1]==Years[j]){
                        dataind[dealdata[i][0]] = dealdata[i][3]-0;
                    }
                }
                datayear[j] = dataind;
            }

            var arrbody = [];
            for(var j=0;j<Years.length;j++){
                //var totalDeals = 0;
                var arrval = [];
                arrval.push(Years[j]);

                //get totlal deal count of the year
                /*for (var i=1;i<arrhead.length;i++){
                    totalDeals += datayear[j][arrhead[i]];
                }*/

                for (var i=1;i<arrhead.length;i++){
                    if (datayear[j][arrhead[i]])
                        arrval.push(datayear[j][arrhead[i]]-0);
                    else
                        arrval.push(0)
                }
                dataArray.push(arrval);
            }


            var data = google.visualization.arrayToDataTable(dataArray);

          var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );


          //Graph 3
            var data3 = new google.visualization.DataTable();
            data3.addColumn('string','Stage');
            data3.addColumn('number', 'No of Deals');

            //Remove Duplicate and make sum
            var dataArray = [];
            for (var i=0; i< dealdata.length ;i++){
                dealcnt = dealcount(dealdata[i][0],dataArray,dealdata[i][2]);
                if (dealcnt==0){
                    var temArray = [];
                    temArray.push(dealdata[i][0]);
                    temArray.push(dealdata[i][2]-0);
                    dataArray.push(temArray);
                }
            }

            data3.addRows(dataArray.length);
            for (var i=0; i< dataArray.length ;i++){
                data3.setValue(i,0,dataArray[i][0]);
                data3.setValue(i,1,dataArray[i][1]-0);
            }

          // Create and draw the visualization.
          new google.visualization.PieChart(document.getElementById('visualization2')).
              draw(data3, {title:"No of Deals"/*,colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});


        //Graph 4
        var data4 = new google.visualization.DataTable();
        data4.addColumn('string','Stage');
        data4.addColumn('number', 'Amount');

        //Remove Duplicate and make sum
        var dataArray = [];
        for (var i=0; i< dealdata.length ;i++){
            dealcnt = dealcount(dealdata[i][0],dataArray,Math.round(dealdata[i][3]-0));

            if (dealcnt==0){
                var temArray = [];
                temArray.push(dealdata[i][0]);
                temArray.push(Math.round(dealdata[i][3]-0));
                dataArray.push(temArray);
            }
        }

        //console.log(dataArray);
        //console.log(dealdata);

        data4.addRows(dataArray.length);
        for (var i=0; i< dataArray.length ;i++){
            data4.setValue(i,0,dataArray[i][0]);
            data4.setValue(i,1,dataArray[i][1]-0);
        }

        // Create and draw the visualization.
          new google.visualization.PieChart(document.getElementById('visualization3')).
              draw(data4, {title:"Amount"/*,
              colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});

          //Fill table
            //Create Head
            var dataArray = [];
            var arrhead = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(arrhead,dealdata[i][0]))
                 arrhead.push(dealdata[i][0]);
            }


            //Get Years
            var Years = [];
            for (var i=0; i< dealdata.length ;i++){
                if (!in_array(Years,dealdata[i][1]))
                 Years.push(dealdata[i][1]);
            }


            for(var i=0;i<arrhead.length;i++){
                var tempArr = [];
                for (var j=0; j< dealdata.length ;j++){
                    var values = [];
                    if (dealdata[j][0]==arrhead[i]){
                        if (dealdata[j][2])
                            values.push(dealdata[j][2]);
                        else
                            values.push('0');

                        if (dealdata[j][3])
                            values.push(dealdata[j][3]);
                        else
                            values.push('0');

                        tempArr[dealdata[j][1]] =  values;
                    }
                }
                dataArray[arrhead[i]] = tempArr;
            }

            //console.log(dataArray);

             var tblCont = '';
             var pintblcnt = '';

             pintblcnt = '<table>';
             pintblcnt = pintblcnt + '<tr><th style="text-align:center">REGION</th><tr>';

                         //tblCont = '<thead>';
             tblCont = tblCont + '<tr><th style="text-align:center">REGION</th>';
             for (var i=0; i< Years.length ;i++){
                tblCont = tblCont + '<th style="text-align:center" colspan="2">'+Years[i]+'</th>';
             }
             tblCont = tblCont + '</tr>';
              tblCont = tblCont + '<tr><th style="text-align:center"></th>';
             for (var i=0; i< Years.length ;i++){
                if (i==0){
                     pintblcnt = pintblcnt + '<tr><th style="text-align:center">&nbsp;</th><tr>';
                 }
                tblCont = tblCont + '<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
             }
             tblCont = tblCont + '</tr>';


             //tblCont = tblCont + '</thead>';
             //tblCont = tblCont + '<tbody>';

             /*for(i=0;i<dataArray.length;i++){
                 console.log(dataArray[i]);
             }*/
            var val= [];

            for(var i=0;i<arrhead.length;i++){
                tblCont = tblCont + '<tr><td>'+arrhead[i]+'</td>';
                pintblcnt = pintblcnt + '<tr><th>'+ arrhead[i] + '</th><tr>';
                //var flag =0;
                for(var j=0;j<Years.length;j++){
                    var deal = '';
                    var amt  = '';
                    val = dataArray[arrhead[i]][Years[j]];
                    if (val){
                            deal = val['0'];
                            amt = val['1'];
                    }
                    /*if(flag==1)
                        tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
                    else*/
                    tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td>';
                    flag =1;
                }
                tblCont = tblCont + '<tr>';

                //console.log(dataArray[arrhead[i]]);
            }

             pintblcnt = pintblcnt + '</table>';
             //tblCont = tblCont + '</tbody>';

             $('#restable').html(tblCont);
             $('.pinned').html(pintblcnt);
        }
      </script>
    <?php
}
if ($type == 14 && $vcflagValue == 0 && $_POST) {
    ?>
    <script type="text/javascript">
      function drawVisualization() {

  divwidth=  document.getElementById("visualization").offsetWidth;

  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.

          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach ($deal as $range => $values) {
        echo ",'" . $range . "'";
    }?>],
                       <?php
for ($i = $fixstart; $i <= $fixend; $i++) {
        ?>   ["<?php echo $i; ?>"
                             <?php foreach ($deal as $range => $values) {?>,<?php echo ($values[$i]['dealcount'] != "") ? $values[$i]['dealcount'] : 0;
        } ?>],
                           <?php
}
    ?> ]);
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
            <?php if ($drilldownflag == 1) {?>
             window.location.href = 'index.php?'+query_string;
            <?php }?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );

           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach ($deal as $range => $values) {
        echo ",'" . $range . "'";
    }?>],
                       <?php
for ($i = $fixstart; $i <= $fixend; $i++) {
        ?>   ["<?php echo $i; ?>"
                             <?php foreach ($deal as $range => $values) {?>,<?php echo ($values[$i]['sumamount'] != "") ? round($values[$i]['sumamount']) : 0;
        } ?>],
                           <?php
}
    ?> ]);
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );

   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php

    foreach ($deal as $range => $values) {
        $sumdeal = 0;
        ?>  [ <?php echo "'" . $range . "'" . ",";
        for ($i = $fixstart; $i <= $fixend; $i++) {
            ?><?php $realdeal = ($values[$i]['dealcount'] != "") ? $values[$i]['dealcount'] : 0;
            $sumdeal = $sumdeal + $realdeal;

        }
        echo $sumdeal;?>],
                           <?php
}
    ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals"/*,
      colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});

       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php

    foreach ($deal as $range => $values) {
        $sumamount = 0;
        ?>  [ <?php echo "'" . $range . "'" . ",";
        for ($i = $fixstart; $i <= $fixend; $i++) {
            ?><?php $realamount = ($values[$i]['sumamount'] != "") ? round($values[$i]['sumamount']) : 0;
            $sumamount = $sumamount + $realamount;

        }
        echo $sumamount;?>],
                           <?php
}
    ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount"/*,
     colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
//$('#slidingTable').hide();
<?php echo ($_GET['type'] == '') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>

    <?php
} else if ($type == 14 && $vcflagValue == 1 && $_POST) {
    ?>
    <script type="text/javascript">
      function drawVisualization() {

  divwidth=  document.getElementById("visualization").offsetWidth;

  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.

          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach ($deal as $range => $values) {
        echo ",'" . $range . "'";
    }?>],
                       <?php
for ($i = $fixstart; $i <= $fixend; $i++) {
        ?>   ["<?php echo $i; ?>"
                             <?php foreach ($deal as $range => $values) {?>,<?php echo ($values[$i]['dealcount'] != "") ? $values[$i]['dealcount'] : 0;
        } ?>],
                           <?php
}
    ?> ]);
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               /*colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );

           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach ($deal as $range => $values) {
        echo ",'" . $range . "'";
    }?>],
                       <?php
for ($i = $fixstart; $i <= $fixend; $i++) {
        ?>   ["<?php echo $i; ?>"
                             <?php foreach ($deal as $range => $values) {?>,<?php echo ($values[$i]['sumamount'] != "") ? round($values[$i]['sumamount']) : 0;
        } ?>],
                           <?php
}
    ?> ]);
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);

           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if ($drilldownflag == 1) {?>             window.location.href = 'index.php?'+query_string;            <?php }?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               /* colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"],*/
                isStacked : true
              }
          );

   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php

    foreach ($deal as $range => $values) {
        $sumdeal = 0;
        ?>  [ <?php echo "'" . $range . "'" . ",";
        for ($i = $fixstart; $i <= $fixend; $i++) {
            ?><?php $realdeal = ($values[$i]['dealcount'] != "") ? $values[$i]['dealcount'] : 0;
            $sumdeal = $sumdeal + $realdeal;

        }
        echo $sumdeal;?>],
                           <?php
}
    ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals"/*,
      colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});

       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php

    foreach ($deal as $range => $values) {
        $sumamount = 0;
        ?>  [ <?php echo "'" . $range . "'" . ",";
        for ($i = $fixstart; $i <= $fixend; $i++) {
            ?><?php $realamount = ($values[$i]['sumamount'] != "") ? round($values[$i]['sumamount']) : 0;
            $sumamount = $sumamount + $realamount;

        }
        echo $sumamount;?>],
                           <?php
}
    ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount"/*,
      colors:["#7a644b","#8a7050","#9a8366","#ab8f6d","#b6936b","#ceb27d","#dcc290","#e8d19f","#e8c188","#e8b66d","#dea655","#ca9b5f","#b18b5e",
"#967855","#816346","#725e46","#625645","#504941","#EAB875","#DCBB93","#C18842","#6C5536"]*/});
//$('#slidingTable').hide();
<?php echo ($_GET['type'] == '') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>

    <?php
}
mysql_close();

?>

 <script type="text/javascript" >


              var containerWidth = $('#container').width();
              var refineWidth = $('#panel').width();
             var searchkeyWidth = $('.result-rt-cnt').width();
             var searchTitleWidth = $('.result-title').width();

             var filtersHeight = $('.filter-key-result').height();
             var tabHeight = $('.list-tab').height();
             var alertHeight = $('.alert-note').height();



           /*  alert(filtersHeight+","+tabHeight+","+alertHeight);

             var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 14;
             alert(searchTitleHeight);
             alert(window.innerWidth);*/
             //var searchTitleHeight = $('.result-cnt').height();
           /* if (window.innerWidth > 1700)
            {
                var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 10;
                $('.result-select').css({"max-width":'100%'});
                 //var resultcntHeight = $('.result-cnt').height()-13;
            }
            else if (window.innerWidth > 1024 )
            {
                var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 15;
                $('.result-select').css({"max-width":'96%'});
                 //var resultcntHeight = $('.result-cnt').height()-18;
             }
            else
            {
                var searchTitleHeight = filtersHeight + tabHeight + alertHeight + 45;
                $('.result-select').css({"max-width":'96%'});
                 //var resultcntHeight = $('.result-cnt').height()-21;
            }*/


            //$('.result-cnt').width(containerWidth-refineWidth-20);
            var resultcntHeight = $('.result-cnt').height()+10;

           // $('.view-table').css({"margin-top":resultcntHeight});
            $('.expand-table').css({"margin-top":0});

            $('.btn-slide').click(function(){

                $('.result-select').css('width', 'auto');
                $('.title-links').css('padding', '3px');
                var containerWidth = $('#container').width();
                var refineWidth = $('#panel').width();
                var searchkeyWidth = $('.result-rt-cnt').width();
                var searchTitleWidth = $('.result-title').width();
                var searchTitleHeight = $('.result-cnt').height();
                if($('.left-td-bg').width()==264){
                    var wid = 35
                }else{
                    var wid = 264
                }
                var f = wid/ $('#container').parent().width() * 100;

               // $('.result-cnt').width((100-f.toFixed()-2)+'%');
               // $('.result-select').width(searchTitleWidth-searchkeyWidth-250);
                /*if (window.innerWidth > 1700)
                {
                    $('.result-select').css({"max-width":'100%'});


                }
                else if (window.innerWidth > 1024 )
                {
                    $('.result-select').css({"max-width":'96%'});
                 }
                else
                {
                    $('.result-select').css({"max-width":'96%'});
                }*/

                if ($('.left-td-bg').width() < 264) {
                    //$('.result-cnt').width(containerWidth-refineWidth-40);

                    var searchTitleHeight = $('.result-cnt').height()+10;
                    //$('.view-table').css({"margin-top":searchTitleHeight});
                                 $('.expand-table').css({"margin-top":0});
                } else {
                    //$('.result-cnt').width(containerWidth-refineWidth+188);
                                //$('.result-select').width(searchTitleWidth-searchkeyWidth);

                    var searchTitleHeight = $('.result-cnt').height()+10;
                    //$('.view-table').css({"margin-top":searchTitleHeight});
                                 $('.expand-table').css({"margin-top":0});
                }





                  ///// tour

                if(demotour==1 || vcdemotour==1)
                    {
                      $(".hopscotch-bubble").removeClass("tourboxshake");
                      $(".hopscotch-bubble").hide();
                     $('body').animate({scrollTop:0},500);

                   if(demotour==1){ setTimeout(function() { $(".hopscotch-bubble").show(); hopscotch.startTour(tour, 3); },1000); }
                   else if(vcdemotour==1){ setTimeout(function() { $(".hopscotch-bubble").show(); hopscotch.startTour(tour, 23); },1000); }

                    $("#acc_main").animate({ scrollTop: $("#acc_main").height() }, 5000);

                    var autoscroll = setTimeout(function() {
                       $('#acc_main').animate({scrollTop:0},3000);
                       $('body').animate({scrollTop:0}, 1000);
//                       $('#firstrefine').show();
                    },5000);


                   var closefrefine = setTimeout(function() {
                       // clearTimeout(autoscroll);
                       //$( "#firstrefine" ).toggle(2000);
                       $( "#firstrefine" ).animate({ "height": "0px" },2000);
                    },3000);


                   var openfrefine =  setTimeout(function() {
                        // clearTimeout(closefrefine);
                        $( "#firstrefine" ).animate({ "height": "609px" },2000);
                      // $( "#firstrefine" ).toggle(2000);
                    },8000);


                    var intervel = setTimeout(function(){

                    // clearTimeout(openfrefine);
                    // auto open
                    function multislt() {
                       var offset = $('#sltindustry').offset();
                        var height = $('#stage').height();
                        var width = $('#stage').width();
                        var top = offset.top + height + "px";
                        var right = offset.left + width + "px";
                        $(".ui-multiselect-menu:first").css({
                        top: top,
                        left:'10px'
                    }).fadeIn();
                    $(".ui-multiselect").addClass('ui-state-active');
                    }


                    function multislt2() {
                       var offset = $('#invrangestart').offset();
                        var height = $('#stage').height();
                        var width = $('#stage').width();
                        var top = offset.top + height + "px";
                        var right = offset.left + width + "px";
                        $(".ui-multiselect-menu:last").css({
                        top: top,
                        left:'10px'
                    }).fadeIn();
                    $(".ui-multiselect").addClass('ui-state-active');
                    }


                    /* select box click - trigger
                      function open(elem) {
                        if (document.createEvent) {
                            var e = document.createEvent("MouseEvents");
                            e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                            elem[0].dispatchEvent(e);
                        } else if (element.fireEvent) {
                            elem[0].fireEvent("onmousedown");
                        }
                    }
                     open($('#sltindustry'));
                    */

                    var a = setTimeout(function(){  if(demotour==1 || vcdemotour==1){  $("#sltindustry").attr('size', 5).fadeIn(); } },2000);
                    var b = setTimeout(function(){  if(demotour==1 || vcdemotour==1){  $("#sltindustry").removeAttr('size');  multislt();   } },4000);
                    var c = setTimeout(function(){  if(demotour==1 || vcdemotour==1){  $(".ui-multiselect-menu:first").fadeOut(); $("#comptype").attr('size', 2).fadeIn();  } },6000);
                    var d = setTimeout(function(){  if(demotour==1 || vcdemotour==1){  $("#comptype").removeAttr('size'); $("#dealtype_debtequity").attr('size', 2).fadeIn();  } },8000);
                    var e = setTimeout(function(){  if(demotour==1 || vcdemotour==1){  $("#dealtype_debtequity").removeAttr('size');  $("#txtregion").attr('size', 2).fadeIn();  } },10000);
                    var f = setTimeout(function(){  if(demotour==1 || vcdemotour==1){  $("#txtregion").removeAttr('size');   $("#invType").attr('size', 2).fadeIn();    } },12000);
                    var g = setTimeout(function(){  if(demotour==1 || vcdemotour==1){  $("#invType").removeAttr('size');   $("#invrangestart").attr('size', 2).fadeIn(); $("#invrangeend").attr('size', 2).fadeIn();     } },14000);
                    var h = setTimeout(function(){  if(demotour==1 || vcdemotour==1){  $("#invrangestart").removeAttr('size'); $("#invrangeend").removeAttr('size'); multislt2();   } },16000);
                    var i = setTimeout(function(){  if(demotour==1 || vcdemotour==1){  $(".ui-multiselect-menu:last").fadeOut();  } },18000);
                    var j = setTimeout(function(){  if(demotour==1){   hopscotch.startTour(tour, 4);  }
                        else if(vcdemotour==1){   hopscotch.startTour(tour, 24);  } },19000);
                    // end auto open


                       //  hopscotch.startTour(tour, 4);
                       //  clearInterval(intervel);

                    },9000);

                    }







            });


        <?php if (($vcflagValue == 0 && $_SERVER['REQUEST_METHOD'] == "GET") || ($_POST) || $vcflagValue == 1) {?>
             //$("#panel").animate({width: 'toggle'}, 200);
             //$(".btn-slide").toggleClass("active");

             if ($('.left-td-bg').css("min-width") != '264px') {
             $('.left-td-bg').css("min-width", '36px');
             $('.acc_main').css("width", '35px');
              $("#panel").css("display","none");
             }
             else {
             $('.left-td-bg').css("min-width", '264px');
             $('.acc_main').css("width", '264px');
             $("#panel").css("display","block");
             }
        <?php }?>

            $(window).resize(function() {

                var containerWidth = $('#container').width();
                var refineWidth = $('#panel').width();
                var searchkeyWidth = $('.result-rt-cnt').width();
                var searchTitleWidth = $('.result-title').width();
                var searchTitleHeight = $('.result-cnt').height()+10;


                //$('.view-table').css({"margin-top":searchTitleHeight});

                $('.expand-table').css({"margin-top":0});
                //$('.result-select').width(searchTitleWidth-searchkeyWidth);

                if (window.innerWidth > 1700)
                {
                   // $('.result-select').css({"max-width":'100%'});
                    $("div").removeClass("restable");
                }
                else if (window.innerWidth > 1024 )
                {
                  //  $('.result-select').css({"max-width":'96%'});
                    $("div").removeClass("restable");
                 }
                else
                {
                   // $('.result-select').css({"max-width":'96%'});
                    $("div").removeClass("restable");
                }

                var f = $('.left-td-bg').width()/ $('#container').parent().width() * 100;
                //alert(f);

                //$('.result-cnt').width((100-f.toFixed()-2)+'%');
                /*if ($('.left-td-bg').width() < 264) {
                    //$('.result-cnt').width(containerWidth-refineWidth+188);
                } else {
                    //$('.result-cnt').width(containerWidth-refineWidth-40);
                } */
            });

            /*if ($('.left-td-bg').width() < 264) {
               // $('.result-cnt').width(containerWidth-refineWidth+188);
            } else {
               // $('.result-cnt').width(containerWidth-refineWidth-40);
            } */

            function openrefine(){

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
            }
    </script>

    <style>
    /*T960 start -------------------------------------------------------*/
    ul.exportcolumn {
            -webkit-column-count: 4;
            -moz-column-count: 4;
            column-count: 4;
        }
    .exportcolumn li,.copyright-body label{
        line-height:35px;
    }
    /*T960 end -----------------------------------------------------*/
     @keyframes blinker {
  50% { opacity: 0.0; }
}
.blinktext{animation: blinker 2s linear infinite;}
        .other_db_search{
            display: none;
            width: 100%;
            float: left;
        }
        .other_db_searchresult a{
            margin-left: 5px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .other_db_searchresult{
            background: #F2EDE1;
            padding: 10px;
            margin: 0 17px;
            font-weight: bold;
            font-size: 14px;
            /*line-height: 24px; */
        }
        .other_loading{
            margin: 0;
            text-align: center;
            font-weight: bold;
        }
        .other_db_link{
            background: #a2753a;
            padding: 2px 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 2px;
        }
         .other_db_link:hover{
            background:#413529;
            color: #fff;
        }
        .other_db_links{
            background: #a2753a;
            padding: 2px 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 2px;
        }
         .other_db_links:hover{
            background:#413529;
            color: #fff;
        }
    </style>


    <script>
     /*Checkbox script*/
     $(document).ready(function(){
 $('#valuations').on("change",function(){   
    $( ".valuationcontainer" ).attr("value","1");
    });
$('input.listall').on('ifToggled', function(event){
  var list=$("#Listall").val();
  console.log(list);
 $list1=$('.listhidden').val(list);

 $(".datesubmit").trigger('click');

});
$(".listall").parent().removeClass();
   $(".listall").removeAttr('style');
   $('.include label div').css("display","inline-block");
   $('.include input').css("vertical-align","middle");

});
    <?php

if ($vcflagValue == 0) {
    $section = "PE-Inv";
} elseif ($vcflagValue == 1) {
    $section = "VC-Inv";
}

if ($searchallfield != '' || $combineSearchFlag || $legalAdvisorSearchFlag || $transactionAdvisorSearchFlag) {?>
        $(document).ready(function(){
            <?php if ($company_cnt == 0) {?>
                $('.other_db_search').css('margin-top','150px');
            <?php }?>
            var filed_name = '';
            <?php
if ($legalAdvisorSearchFlag) {
    $searchallfield = $advisorsearchstring_legal;
    ?>
                filed_name = "alegal";
            <?php
?>
            <?php
} else if ($transactionAdvisorSearchFlag) {
    $searchallfield = $advisorsearchstring_trans;
    ?>
                filed_name = "atrans";
            <?php
} else if ($combineSearchFlag) {
   
    

    $searchStringGmail = "&industry=".implode(",",$industry)."&sector=".implode(",",$sector)."&subsector=".$subsectorString."&keyword=".$keyword."&companysearch=".$companysearch."&round=".implode(",",$round)."&regionId=".implode(",",$regionId)."&city=".$city."&companyType=".$companyType."&debt_equity=".$debt_equity."&syndication=".$syndication."&investorType=".$investorType."&exitstatusValue=".implode(",",$exitstatusValue);
    //$searchallfield = 'combineSearchFlag';
    
    ?>
                filed_name = "combinesearch";
            <?php
}
    ?>

            $('.other_db_search').fadeIn();
           $.get( "gmail_like_search.php?section=<?php echo $section; ?>&search=<?php echo $searchallfield; ?><?php echo $searchStringGmail; ?>&filed_name="+filed_name, function( data ) {

            var data = jQuery.parseJSON(data);
            console.log(data);

            var html='';
            html += data.message+' ';

            if(data.result ==1){
                 var count=1;
                 $.each( data.sections, function( key, value ) {
                        //if(count>1){html +=',';}
                        html += value.html;
                   count++;
                  });
                  //html +='.';
                  $('.other_db_searchresult').html(html);
                  $('.other_db_search').fadeIn();
            }else{
                 $('.other_db_searchresult').html('<p class="other_loading">No matching results found in other database.</p>');
                 $('.other_db_search').fadeOut(10000);
            }

          });


           $(".other_db_link").live( "click", function() {
              var href = $(this).attr('href');
              $('#other_db_submit').attr('action',href);
              $('#other_db_submit').submit();

               return false;
           });


        });
    <?php }?>






  $(document).ready(function(){

 <?php if (($company_cnt == 0) && (trim($invester_filter) != '' || trim($companyauto) != '' || trim($sectorsearch) != '' || trim($advisorsearchstring_legal) != '' || trim($advisorsearchstring_trans) != '')) {

    $searchList = $invester_filter . $companyauto . str_replace("'", "", trim($sectorsearch)) . $advisorsearchstring_legal . $advisorsearchstring_trans;
    $searchList = explode(',', $searchList);
    $count = 0;
    if ($invester_filter != '') {
        $filed_name = 'investor';
    } else if ($companyauto != '') {
        $filed_name = 'company';
    } else if ($sectorsearch != '') {
        $filed_name = 'sector';
    } else if ($advisorsearchstring_legal != '') {
        $filed_name = 'alegal';
    } else if ($advisorsearchstring_trans != '') {
        $filed_name = 'atrans';
    }
    ?>

       $('.other_db_search').css('margin-top','150px');
       $('.other_db_search').fadeIn();
       $('.other_db_searchresult').html('');
       var href='';
     <?php
if ($filed_name == 'company') {
        $svCompanyName = explode(',', $company_filter);
    }
    foreach ($searchList as $searchtext) {
        if ($filed_name == 'company') {
            $searchallfield = trim($searchtext);
            $searchallfieldName = trim($svCompanyName[$count]);
        } else {
            $searchallfield = trim($searchtext);
            $searchallfieldName = trim($searchtext);
        }
        $count++;
        ?>
       var link ="gmail_like_search.php?section=<?php echo $section; ?>-not&search=<?php echo $searchallfield; ?>&filed_name=<?php echo $filed_name; ?>";
       var text = 'Click here to search';

        href += '<div class="refine_to_global"> "<?php echo $searchallfieldName ?>" - <a class="refine_to_global_link" style="text-decoration: none;font-family: sans-serif" href="'+link+'" id="refinesearch_<?php echo $count ?>" >'+text+'</a><div class="other_db_searchresult refinesearch_<?php echo $count ?>" style="font-weight: normal;"></div><div>';

 <?php }?>

  $('.other_db_searchresult').html('<b style="font-size:15px">Search in other databases</b><br><br><br>'+href);


   $(".refine_to_global_link").click(function() {
       var getLink = $(this).attr('href');
       var classname = this.id;

       $('.'+classname).html('<p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>');

      // alert(getLink);

       $.get(getLink, function( data ) {

            var data = jQuery.parseJSON(data);

            var html='';
            html += data.message+' ';

            if(data.result ==1){
                 var count=1;
                 $.each( data.sections, function( key, value ) {
                        //if(count>1){html +=',';}
                        html += value.html;
                   count++;
                  });
                  //html +='.';
                  $('.'+classname).html(html);
                  $('.other_db_search').fadeIn();
            }else{
                 $('.'+classname).html('<p class="other_loading">No matching results found in other database.</p>');
                 //$('.other_db_search').fadeOut(10000);
            }

          });

       return false;
   });


    $(".other_db_link").live( "click", function() {

              var href = $(this).attr('href');
              var searchValue = $(this).attr('data-value');

              $('#other_searchallfield').val(searchValue);
              $('#other_db_submit').attr('action',href);
              $('#other_db_submit').submit();

               return false;
           });

 <?php }?>

$(".other_db_search").on('click', '.other_db_link', function() {

        var search_val = $(this).attr('data-search_val');
        $('#all_keyword_other').val(search_val);
       });
  });



    </script>


     <?php if ($firstlogin == 1 || $exportToExcel == 0) {$tourautostart = 'ON';}?>


    <script src="hopscotch.js"></script>

   <?php if ($_SESSION['vconly'] == 1) {?>
    <script src="demo_vconly.js"></script>
    <script type="text/javascript" > var vconly=1; </script>
   <?php } else {?>
       <script src="demo_new.js?111"></script>
    <script type="text/javascript" > var vconly=0; </script>
   <?php }?>

    <script type="text/javascript" >

    var demotour=0;
    var vcdemotour=0;



      <?php if ($tourautostart == 'ON') {?>
       $(document).ready(function(){

         <?php if (!isset($_SESSION["tourautostart"])) {
    $_SESSION["tourautostart"] = $_SESSION["demoTour"] = 1;

    ?>
                hopscotch.startTour(tour, 0);
                $("#tourlibtn").hide();
                $("#tourlist").hide();
                $("#autostartstopbtn").show();
        <?php }?>

        });
      <?php }?>


       $(document).ready(function(){
    // Tag Search
var tagsearchval = $('#tagsearch').val();
if(tagsearchval == ''){
    $('.acc_trigger.helptag').removeClass('active').next().hide();
}
// Tag search

       <?php if (isset($_SESSION["demoTour"]) && $_SESSION["demoTour"] == '1') {?>
                openrefine();
                demotour=1;
            <?php
if ($_POST["searchallfield"] == 'Offshore' || $_POST["searchallfield"] == 'offshore') {?>
                   hopscotch.startTour(tour, 17);
             <?php } else if (isset($_POST["industry"]) && ($_POST["industry"] == '66')) {?>
                   hopscotch.startTour(tour, 5);
             <?php } else if (isset($_POST["searchpe"]) || ($_POST["month1"] == '1' && $_POST["month2"] == '3' && $_POST["year1"] == '2014' && $_POST["year2"] == '2014')) {?>
                   hopscotch.startTour(tour, 2);
                   $(".hopscotch-bubble").addClass("tourboxshake");
                  var tourshake =  setInterval(function(){
                       $(".tourboxshake").effect( "shake",{times:1}, 2000 );
                   },5000);

             <?php } else {?>
                    hopscotch.startTour(tour, 0);
                   // alert('start');
            <?php }?>


                   //// multi select checkbox hide
            $('.ui-multiselect').attr('id','uimultiselect');

           $("#uimultiselect, #uimultiselect span").click(function() {
                if(demotour==1)
                        {  showErrorDialog(warmsg); $('.ui-multiselect-menu').hide(); }
            });

      <?php } else if (isset($_SESSION["VCdemoTour"]) && $_SESSION["VCdemoTour"] == '1' && $_GET["value"] == 1) {?>
            openrefine();
            vcdemotour=1;

             <?php if ($_POST["searchallfield"] == 'E-Commerce' || $_POST["searchallfield"] == 'e-commerce') {?>
                   hopscotch.startTour(tour, 37);
             <?php } else if (isset($_POST["industry"]) && ($_POST["industry"] == '1')) {?>
                   hopscotch.startTour(tour, 25);
             <?php } else if (isset($_POST["searchpe"]) || ($_POST["month1"] == '1' && $_POST["month2"] == '3' && $_POST["year1"] == '2011' && $_POST["year2"] == '2011')) {?>
                   hopscotch.startTour(tour, 22);
                   $(".hopscotch-bubble").addClass("tourboxshake");
                  var tourshake =  setInterval(function(){
                       $(".tourboxshake").effect( "shake",{times:1}, 2000 );
                   },5000);

             <?php } else {?>
                    hopscotch.startTour(tour, 19+vconly);
                <?php }?>


                         //// multi select checkbox hide
            $('.ui-multiselect').attr('id','uimultiselect');

           $("#uimultiselect, #uimultiselect span").click(function() {
                if(vcdemotour==1)
                        {  showErrorDialog(warmsg); $('.ui-multiselect-menu').hide(); }
            });


      <?php }?>



//     alert("pe ="+demotour);
//     alert("vc ="+vcdemotour);


       });
$(".other_db_search").on('click', '.other_db_link', function() {

        var search_val = $(this).attr('data-search_val');
        $('#all_keyword_other').val(search_val);
       });

        $( '.typeoff-tagnva2' ).on( 'ifChecked', function() {
            if( $( this ).val() == 1 ) {
                $( ".count_percent" ).show();
                $( ".amount_percent" ).hide();
            } else {
                $( ".count_percent" ).hide();
                $( ".amount_percent" ).show();
            }
        });

        $('.count_percent, .amount_percent').click(function(){
            $("#searchTagsField").val($(this).find('a').data('name'));
            $('#tagForm').submit();
        });

        $( '.lbl-action' ).click( function() {
            $( '#export_tags' ).submit();
        });

        $( '#month1' ).on( 'change', function() {
            $( '#period_flag' ).val(2);
        });
        $( '#year1' ).on( 'change', function() {
            $( '#period_flag' ).val(2);
        });
        $( '#month2' ).on( 'change', function() {
            $( '#period_flag' ).val(2);
        });

        </script>
        <?php include "../survey/survey.php";?>

        <?php

//( !isset($_SESSION['popup_display']) || $_SESSION['popup_display'] != 'none')
if ($tourautostart != 'ON' && $popup_search == 0) {?>
            <script>
                $(document).ready(function(){
                 $('.popup_close a').click(function(){
                     $(".popup_main").hide();
                  });
                });
            </script>
            <style>
                div.token-input-dropdown-facebook{
                    z-index: 999;
                }
                .popup_content ul.token-input-list-facebook{
                    height: 39px !important;
                    width: 537px !important;
                }
            .popup_main
            {
                position: fixed;
                left:0;
                top:0px;
                bottom:0px;
                right:0px;
                background: rgba(2,2,2,0.5);
                z-index: 999;
            }
.popup_box {
    width:746px;
    height: 0;
    position: absolute;
    left:0px;
    right:0px;
    bottom:0px;
    top:0px;
    margin: auto;

}
.popup_header
{
    background: #414141;
    color: #fff;
    font-size: 18px;
    padding: 12px 0 12px 18px;
    margin: 0px;
}
.popup_content
{
    background: #ececec;
        padding: 30px 25px 85px;
}
.popup_form
{
    width:700px;
    border:1px solid #d5d5d5;
    background: #fff;
    height: 40px;
}
.popup_dropdown
{
     width: 155px;
     margin:0px;
     border: none;
     height: 40px;
     -webkit-appearance: none;
     -moz-appearance: none;
     appearance: none;
     background: url("images/polygon1.png") no-repeat 95% center;
     padding-left: 17px;
     cursor: pointer;
     font-size: 14px;
}
.popup_text
{
    width:538px;
    border: none;
    border-left:1px solid #d5d5d5;
    padding-left: 17px;
    box-sizing: border-box;
    height: 40px;
    font-size: 16px;
    float: right;
}
.auto_keywords
{
    position: absolute;
    top: 106px;
    width:537px;
    background: #fff;
        border:1px solid #d5d5d5;
        border-top: none;
        display: none;
}
.auto_keywords ul
{
    line-height: 25px;
    font-size: 16px;
}

.auto_keywords ul li
{
 padding-left: 20px;
 cursor:pointer;
}
.auto_keywords ul li a
{
  text-decoration: none;
  color: #414141;
}
.auto_keywords ul li:hover
{
   background: #f2f2f2;
}
.popup_btn
{
    text-align: center;
    padding: 33px 0 50px;

}
.popup_cancel
{
    background: #d5d5d5;
    cursor: pointer;
    padding:10px 27px;
    text-align: center;
    color: #767676;
    text-decoration: none;
    margin-right: 16px;
    font-size: 16px;
    display: none;

}
.popup_btn input[type="button"]
{
    background: #a27639;
    cursor: pointer;
    padding:10px 27px;
    text-align: center;
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    float: right;

}
.popup_close
{
    color: #fff;
    right:20px;
    font-size: 15px;
    position:absolute;
    top:12px;
}
.popup_close a
{
    color: #fff;
    text-decoration: none;
    cursor: pointer;
}
.popup_searching
{
    width:538px;
    float: right;
        position: relative;
}
div.token-input-dropdown{
        z-index: 999 !important;
}
</style>
<div class="popup_main">
            <div class="popup_box">
  <h1 class="popup_header">Quick Search</h1>
  <span class="popup_close"><a href="javascript: void(0);">X</a></span>
  <div class="popup_content">
      <form name="searchallleftmenu12" action="<?php echo $actionlink; ?>" method="post" id="searchallleftmenu12" autocomplete="off">
      <div class="popup_form">
          <select class="popup_dropdown" name="popup_select" id="popup_select">
              <option value="">All</option>
              <option value="exact">All(Exact Match)</option>
              <option value="investor">Investor</option>
              <option value="company">Company</option>
              <option value="sector">Sector</option>
              <option value="legal_advisor">Legal Advisor</option>
              <option value="transaction_advisor">Transaction Advisor</option>
              <option value="tags">Tags</option>
         </select>
         <div class="popup_searching">
            <input type="text" name="popup_keyword" id="popup_keyword" value="" placeholder="Enter Keyword" class="popup_text" autocomplete="off" />
            <input type="hidden" name="advisor_type" id="advisor_type" value="" />
            <div id="search_load" style="  overflow-y: scroll;  max-height: 130px;  background: #fff;display:none;  width: 300px;position: absolute;top: 40px;">
            <span id="com_clearall" title="Clear All" onclick="clear_allsearch();" style="background: rgb(191, 160, 116); position: absolute; top: 29px; right: 30px; padding: 3px; display: block;">(X)</span>
            <div class="auto_keywords">
                <ul class="popup_auto_result"></ul>
           </div>
         </div>
      </div>
      <div class="popup_btn">
             <!--<a href="javascript:void(0)" class="popup_cancel">Cancel</a>
             <a href="javascript:void(0)" class="popup_search">Search</a>-->
             <a href="javascript:void(0)" class="popup_cancel">Cancel</a>
             <input type="button" name="popup_submit" class="popup_search" value="Search" onclick="this.form.submit();" >
      </div>
      </form>
  </div>
</div>
</div>
    </div>

<script>
/*$('#agreebtn').click(function(){

    jQuery('#popup-box-copyrights').fadeOut();
    jQuery('#maskscreen').fadeOut();
    jQuery('#preloading').fadeIn();
    initExport();
    return false;
});
$('#expcancelbtn').click(function(){

    jQuery('#popup-box-copyrights').fadeOut();
    jQuery('#maskscreen').fadeOut(1000);
    return false;
});*/
</script>
<?php
//$_SESSION['popup_display'] = 'none';
    mysql_close();

}?>
