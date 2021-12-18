<?php
//other database

$tagandor = $_POST['tagandor'];
$tagradio = $_POST['tagradio'];
$invandor = $_POST['invandor'];
$invradio = $_POST['invradio'];
if ($_POST['listallcompanies'] == '') {
    $_POST['listallcompanies'] = 1;
}
if($_POST['tagsearch'] != "" || $_POST['tagsearch_auto'] != ""){
    $_POST['investorauto_sug']="";
    $_POST['searchallfield'] = "";
    $_POST['companysearch'] = "";
    $_POST['companyauto']="";
    $_POST['industry']="";
    $_POST['followonVCFund']="";
    $_POST['exitedstatus']="";
    $_POST['txtregion']="";
    $_POST['citysearch']="";
    $_POST['yearafter']="";
    $_POST['yearbefore']="";
}
$listallcompany = $_POST['listallcompanies'];
if (isset($_POST['all_keyword_other'])) {
    $all_keyword_other = trim($_POST['all_keyword_other']);
}
if (isset($_POST['searchallfield_other'])) {
    $searchallfield_other = $_POST['searchallfield_other'];

}
if (isset($_POST['investorauto_sug_other'])) {
    $investorauto_sug_other = $_POST['investorauto_sug_other'];
}
if (isset($_POST['keywordsearch_other'])) {
    $keywordsearch_other = $_POST['keywordsearch_other'];
}
if (isset($_POST['sectorsearch_other'])) {
    $sectorsearch_other = $_POST['sectorsearch_other'];
}
if (isset($all_keyword_other) && $all_keyword_other != '') {
    if (isset($keywordsearch_other) && $keywordsearch_other != '') {
        $ex_keywordsearch_other = explode(',', $keywordsearch_other);
        $ex_investorauto_sug_other = explode(',', $investorauto_sug_other);
        if (!in_array($all_keyword_other, $ex_keywordsearch_other)) {
            $_POST['keywordsearch_other'] = '';
            $_POST['investorauto_sug_other'] = '';
        } else {
            $key = array_search($all_keyword_other, $ex_keywordsearch_other);
            $_POST['keywordsearch_other'] = $all_keyword_other;
            $_POST['investorauto_sug_other'] = $ex_investorauto_sug_other[$key];
        }
    } else if (isset($searchallfield_other) && $searchallfield_other != '') {

        $ex_searchallfield_other = explode(',', $searchallfield_other);
    } else if (isset($sectorsearch_other) && $sectorsearch_other != '') {

        $ex_sectorsearch_other = explode(',', $sectorsearch_other);
        if (in_array($all_keyword_other, $ex_sectorsearch_other)) {
            $_POST['searchallfield_other'] = $all_keyword_other;
        }
    }
}

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
require_once "../dbconnectvi.php";
$Db = new dbInvestments();
$videalPageName = "AngelInv";
include 'checklogin.php';
$searchString = "Undisclosed";
$searchString = strtolower($searchString);
$searchString1 = "Unknown";
$searchString1 = strtolower($searchString1);
$buttonClicked = $_POST['hiddenbutton'];
$fetchRecords = true;
$totalDisplay = "";
$followonVCFund = 0;
$exited = 0;
$txtregion = "";
$citysearch = "";

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

if (isset($_POST['pe_company'])) {

    $pe_company = $_POST['pe_company'];
    $peEnableFlag = true;
}
//====================jagadeesh rework===================================================

if (isset($_POST['pe_hide_companies'])) {
    $pe_hide_companies = explode(',', $_POST['pe_hide_companies']);
    $peHideFlagCh = true;
}

//=======================================================================================
//print_r($_POST);
if (isset($_POST[period_flag])) {
    $period_flag = $_POST['period_flag'];
} else {
    $period_flag = 1;
}
$resetfield = $_POST['resetfield'];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $test = "1";
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
    //   echo "2";
    if ($resetfield == "period") {
        $month1 = date('n');
        $year1 = date('Y', strtotime(date('Y') . " -1  Year"));
        $month2 = date('n');
        $year2 = date('Y');
        $_POST['month1'] = "";
        $_POST['year1'] = "";
        $_POST['month2'] = "";
        $_POST['year2'] = "";
    } elseif (($resetfield == "searchallfield") || ($resetfield == "companysearch")) {
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
    } else if ($_POST['searchallfield_other']!=""|| trim($_POST['searchallfield']) != "" || trim($_POST['searchTagsField']) != "" || trim($_POST['investorauto_sug']) != "" || trim($_POST['companysearch']) != "") {
        if (($_POST['month1'] == date('n')) && $_POST['year1'] == date('Y', strtotime(date('Y') . " -1  Year")) && $_POST['month2'] == date('n') && $_POST['year2'] == date('Y')) {

            $findTag = strpos($_POST['searchallfield'], 'tag:');
            $findTags = "$findTag";
            if ($_POST['tagsfield'] == 1 || $period_flag == 2 || $findTags != ''  ) {

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

    } elseif ((count($_POST['industry']) > 0) || ($_POST['exitedstatus'] != "--") || ($_POST['followonVCFund'] != "--")
        || (count($_POST['txtregion']) > 0) || ($_POST['citysearch'] != "")  || $_POST['tagsearch'] != ''  || $_POST['tagsearch_auto'] != '') {
        if (($_POST['month1'] == date('n')) && $_POST['year1'] == date('Y', strtotime(date('Y') . " -1  Year")) && $_POST['month2'] == date('n') && $_POST['year2'] == date('Y')) {

            if($period_flag == 2){
                $month1 = $_POST['month1'];
                $year1 = $_POST['year1'];
            } else {
                $month1=01;
                $year1 = 1998;
            }
            // $month1 = $_POST['month1'];
            // $year1 = $_POST['year1'];
            $month2 = date('n');
            $year2 = date('Y');

        } else {

            $month1 = ($_POST['month1'] || ($_POST['month1'] != "")) ? $_POST['month1'] : date('n');
            $year1 = ($_POST['year1'] || ($_POST['year1'] != "")) ? $_POST['year1'] : date('Y', strtotime(date('Y') . " -1  Year"));
            $month2 = ($_POST['month2'] || ($_POST['month2'] != "")) ? $_POST['month2'] : date('n');
            $year2 = ($_POST['year2'] || ($_POST['year2'] != "")) ? $_POST['year2'] : date('Y');
        }
    } else {
        $month1 = ($_POST['month1']) ? $_POST['month1'] : date('n');
        $year1 = ($_POST['year1']) ? $_POST['year1'] : date('Y', strtotime(date('Y') . " -1  Year"));
        $month2 = ($_POST['month2']) ? $_POST['month2'] : date('n');
        $year2 = ($_POST['year2']) ? $_POST['year2'] : date('Y');
    }
    $fixstart = $year1;
    $startyear = $fixstart . "-" . $month1 . "-01";
    $fixend = $year2;
    $endyear = $fixend . "-" . $month2 . "-31";
}

if ($resetfield == "searchallfield") {
    $_POST['searchallfield'] = "";
    $searchallfield = "";
} else {
    if (isset($_POST['searchallfield']) && trim($_POST['searchallfield']) != '') {
        $searchallfield = trim($_POST['searchallfield']);
    }
    if ($searchallfield != "") {
        if ($searchallfield != "") {
            $_POST['keywordsearch'] = "";
            $_REQUEST['investorauto'] = "";
            $_POST['investorauto_sug'] = "";
            $_POST['companysearch'] = "";
            $_REQUEST['companyauto'] = "";
            $_POST['tagsearch'] = "";
            $_POST['tagsearch_auto'] = "";
        }
    }

}

$searchallfieldhidden = ereg_replace(" ", "_", $searchallfield);
if ($resetfield == "keywordsearch") {
    // $_POST['keywordsearch'] = "";
    // $keyword = "";
    // $keywordhidden = "";
    // $investorauto = '';
    $investorarray = explode(',', $_POST['investorauto_sug']);
    $pos = array_search($_POST['resetfieldid'], $investorarray);
    $keyword = $investorarray;
    unset($keyword[$pos]);
    $keyword = implode(',', $keyword);
    $_POST['investorauto_sug'] = $keyword;
    $keywordhidden = $keyword;
    $investorauto = $keyword;

    $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
    $sql_investorauto_sug_Exe = mysql_query($sql_investorauto_sug);
    $response = array();
    $invester_filter = "";
    $i = 0;
    if (mysql_num_rows($sql_investorauto_sug_Exe) > 0) {

        while ($myrow = mysql_fetch_array($sql_investorauto_sug_Exe, MYSQL_BOTH)) {

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
    }
    $investorsug_response = json_encode($response);

    if ($keyword != '') {
        $searchallfield = '';
    }
    $investorauto = $_REQUEST['investorauto_sug'];

} else {
    $keyword1 = trim($_POST['keywordsearch']);
    if (isset($_POST['investorauto_sug_other'])) {
        $investorauto = $_POST['investorauto_sug_other'];
        $keyword = trim($_POST['investorauto_sug_other']);
        $keywordhidden = ereg_replace(" ", "_", $keyword);
        $month1 = 01;
        $year1 = 1998;
        $month2 = date('n');
        $year2 = date('Y');
    } else if (isset($_POST['investorauto_sug'])) {
        $investorauto = $keyword = trim($_POST['investorauto_sug']);
        $keywordhidden = trim($_POST['investorauto_sug']);
    } else {
        $investorauto = $keyword = $keywordhidden = '';
    }
    $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
    $sql_investorauto_sug_Exe = mysql_query($sql_investorauto_sug);
    $response = array();
    $invester_filter = "";
    $i = 0;
    if (mysql_num_rows($sql_investorauto_sug_Exe) > 0) {

        while ($myrow = mysql_fetch_array($sql_investorauto_sug_Exe, MYSQL_BOTH)) {

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
    }
    $investorsug_response = json_encode($response);

    if ($keyword != '') {
        $searchallfield = '';
    }
    $investorauto = $_REQUEST['investorauto_sug'];
}

$keywordhidden = ereg_replace(" ", "-", $keywordhidden);

if ($resetfield == "companysearch") {
    $_POST['companysearch'] = "";
    $companysearch = "";
    $companyauto = '';
} else {
    // $companysearch = trim($_POST['companysearch']);
    // $companyauto = $_POST['companyauto'];
    if($_POST['companyauto_sug']!=''){
        $companysearch = $_POST['companyauto_sug'];
          $companyauto = $_POST['companysearch'];
        }else{
            $companysearch=trim($_POST['companysearch']);
            $companyauto=$_POST['companyauto'];
          }  
    if (isset($_POST['companyauto_other']) && $_POST['companyauto_other'] != '') {

        $companyauto = $_POST['companyauto_other'];
        $companysearch = trim($_POST['companysearch_other']);
        $companysearchhidden = ereg_replace(" ", "_", $companysearch);
        $month1 = 01;
        $year1 = 1998;
        $month2 = date('n');
        $year2 = date('Y');
    }

    if ($companysearch != '') {
        $searchallfield = '';
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
        }
        $company_filter .= $myrow['name'];
        $i++;
    }
    $companysearchhidden = ereg_replace(" ", "_", $companysearch);
}

if ($resetfield == "industry") {
    // $_POST['industry'] = "";
    // $industry = 0;
    $pos = array_search($_POST['resetfieldid'], $_POST['industry']);
    $industry = $_POST['industry'];
    unset($industry[$pos]);
    emptyhiddendata();
} else {
    $industry = $_POST['industry'];
    if ($industry != '--' && $industry != '' && count($industry) > 0) {
        $searchallfield = '';
    }
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
            if( $yearafter !=''|| $yearbefore !=''){
                $searchallfield='';
            }

        }


if ($resetfield == "followonVCFund") {
    $_POST['followonVCFund'] = "";
    $followonVC = "--";
    emptyhiddendata();
} else {
    $followonVC = trim($_POST['followonVCFund']);
    if ($followonVC != '--' && $followonVC != '') {
        $searchallfield = '';
    }
}

if ($followonVC == "--") {
    $followonVCFund = "--";
}

if ($followonVC == 1) {
    $followonVCFund = 1;
} elseif ($followonVC == 2) {
    $followonVCFund = 3;
}

if ($resetfield == "exitedstatus") {
    $_POST['exitedstatus'] = "";
    $exitvalue = "--";
    emptyhiddendata();
} else {
    $exitvalue = trim($_POST['exitedstatus']);
    if ($exitvalue != '--' && $exitvalue != '') {
        $searchallfield = '';
    }
}

if ($exitvalue == "--") {
    $exited = "--";
} elseif ($exitvalue == 1) {
    $exited = 1;
} elseif ($exitvalue == 2) {
    $exited = 3;
}

if ($resetfield == "txtregion") {
   // $_POST['txtregion'] = "";
     $pos = array_search($_POST['resetfieldid'], $_POST['txtregion']);
    
    $txtregion = $_POST['txtregion'];
    unset($txtregion[$pos]);
    emptyhiddendata();
} else {
    $txtregion = $_POST['txtregion'];
    if ($txtregion != '--' && count($txtregion) > 0) {
        $searchallfield = '';
    }
}

if ($resetfield == "citysearch") {
    $_POST['citysearch'] = "";
    emptyhiddendata();
} else {
    $citysearch = trim($_POST['citysearch']);
}

$whereind = "";
$whereinvType = "";
$wherestage = "";
$wheredates = "";
$whererange = "";
$wherelisting_status = "";

$notable = false;
$vcflagValue = isset($_POST['txtvcFlagValue']) ? $_POST['txtvcFlagValue'] : 2;
//echo "<br>FLAG VALIE--" .$vcflagValue;
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

$wherefollowonVCFund = "";
$whereexited = "";
$whereregion = "";
$wherecity = "";

if (isset($_POST['searchallfield_other'])) {

    $searchallfield = $_POST['searchallfield_other'];
    $searchallfieldhidden = ereg_replace(" ", "_", $searchallfield);
    $month1 = 01;
    $year1 = 1998;
    $month2 = date('n');
    $year2 = date('Y');
}

// if($resetfield=="tagsearch")
// {
//     $_POST['tagsearch']="";
//     $tagsearch="";emptyhiddendata();
// }
// elseif($_POST['tagsearch']  && $_POST['tagsearch'] !=''){

//     $tagsearch="tag:".trim($_POST['tagsearch']);
// }else if(isset($_POST['searchTagsField']) && trim($_POST['searchTagsField']) !=''){

//     $tagsearch=trim($_POST['searchTagsField']);
//     $_POST['tagsearch']=trim($_POST['searchTagsField']);
// }

if ($resetfield == "tagsearch") {

   /* $_POST['tagsearch'] = "";
    $_POST['tagsearch_auto'] = "";
    $tagsearch = "";
    $tagandor = 0;*/
            $arrayval=explode(",",$_POST['tagsearch']);
            $pos = array_search($_POST['resetfieldid'], $arrayval);
            $tagsearch = $arrayval;
            unset($tagsearch[$pos]);
            $tagsearch = implode(",",$tagsearch);
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
}

if ($industry != '' && count($industry)) {
    $indusSql = $industryvalue = '';
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

if ($followonVCFund == "--") {
    $followonVCFundText == "";
} elseif ($followonVCFund == "1") {
    $followonVCFundText = "Follow on Funding";
} elseif ($followonVCFund == "3") {
    $followonVCFundText = "No Funding";
}

if ($exited == "--") {
    $exitedText = "";
} elseif ($exited == "1") {
    $exitedText = "Exited";
} elseif ($exited == "3") {
    $exitedText = "Not Exited";

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

        $regionSql = "select Region,RegionId from region where $roundSqlStr";
        if ($regionrs = mysql_query($regionSql)) {
            while ($myregionrow = mysql_fetch_array($regionrs, MYSQL_BOTH)) {
                $regionvalue .= $myregionrow["Region"] . ', ';
                $regionvalueId .= $myregionrow["RegionId"] . ', ';
            }
        }
        $regionText = trim($regionvalue, ', ');
        $region_hide = implode($txtregion, ',');
    }
}

if ($citysearch == "--") {
    $cityText = "";
} else {
    $cityText = $citysearch;
}

$TrialSql = "select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
                                                                where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
if ($trialrs = mysql_query($TrialSql)) {
    while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
        $exportToExcel = $trialrow["TrialLogin"];
        $compId = $trialrow["DCompId"];
    }
}

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

$addVCFlagqry = " and pec.industry !=15 ";
$searchTitle = "Angel Investments";

if ($_SESSION['PE_industries'] != '') {

    $comp_industry_id_where = ' AND pec.industry IN (' . $_SESSION['PE_industries'] . ') ';
}
//print_r($_POST);
// if (($keyword == "") && ($companysearch =="") && ($industry =="--")  && ($followonVCFund == "--") && ($exited=="--") && (($month1 == "--") && (year1 == "--")  && ($month2 =="--") && ($year2 == "--")))
$orderby = "";
$ordertype = "";
if (!$_POST) {
    $iftest = 1;
    $yourquery = 0;
    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    if ($listallcompany == 1) {
        $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId,pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                     DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') AS Investor
                     FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
        WHERE  DealDate between '" . $dt1 . "' and '" . $dt2 . "' and i.industryid  = pec.industry AND pec.PEcompanyID = pe.InvesteeId  and pe.Deleted=0
        and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId " . $addVCFlagqry . " " . $addDelind . "
        $comp_industry_id_where GROUP BY pe.AngelDealId";
        $orderby = "DealDate";
        $ordertype = "desc";
    } else {
        $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId,pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                     DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') AS Investor
                     FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
        WHERE  DealDate between '" . $dt1 . "' and '" . $dt2 . "' and i.industryid  = pec.industry AND pec.PEcompanyID = pe.InvesteeId  and pe.Deleted=0 and pe.AggHide=0
        and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId " . $addVCFlagqry . " " . $addDelind . "
        $comp_industry_id_where GROUP BY pe.AngelDealId";
        $orderby = "DealDate";
        $ordertype = "desc";
    }
    //echo "<br>all records" .$companysql;
} elseif ($tagsearch != "") {
    $iftest = 4;
    $yourquery = 1;
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
                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]$'";
                /* $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]".$value."[[:>:]]'"." or";*/
                if ($tagandor == 0) {
                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                } else {
                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                }
            }
        }
    }
    /* $tagsval = trim($tags,' or ');*/
    if ($tagandor == 0) {
        $tagsval = trim($tags, ' and ');
    } else {
        $tagsval = trim($tags, ' or ');
    }

    if ($listallcompany == 1) {
        $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
            DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,
             pe.Comment,pe.MoreInfor,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') AS Investor
            FROM angelinvdeals AS pe, industry AS i,    pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
            WHERE DealDate between '" . $dt1 . "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId
            AND pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND
            ( $tagsval ) $comp_industry_id_where GROUP BY pe.AngelDealId ";
        $orderby = "DealDate";
        $ordertype = "desc";
    } else {
        $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
            DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,
             pe.Comment,pe.MoreInfor,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') AS Investor
            FROM angelinvdeals AS pe, industry AS i,    pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
            WHERE DealDate between '" . $dt1 . "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId
            AND pe.Deleted =0 and pe.AggHide=0" . $addVCFlagqry . " " . $addDelind . " and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND
            ( $tagsval ) $comp_industry_id_where GROUP BY pe.AngelDealId ";
        $orderby = "DealDate";
        $ordertype = "desc";
    }

    //echo "<bR>---" .$companysql;
} elseif ($searchallfield != "") {
    $iftest = 4;
    $yourquery = 1;
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";
    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";

    /*$tagsval = "pec.region LIKE '$searchallfield%' OR pec.city LIKE '$searchallfield%' OR pec.companyname LIKE '$searchallfield%' OR  sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or pec.tags like '%$searchallfield%' or pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";*/
    $searchExplode = explode(' ', $searchallfield);
    foreach ($searchExplode as $searchFieldExp) {

        /* $regionLike .= "pec.region LIKE '$searchFieldExp%' AND ";
        $cityLike .= "pec.city LIKE '$searchFieldExp%' AND ";
        $companyLike .= "pec.companyname LIKE '$searchFieldExp%' AND ";
        $sectorLike .= "sector_business LIKE '%$searchFieldExp%' AND ";
        $moreInfoLike .= "MoreInfor LIKE '%$searchFieldExp%' AND ";
        $investorLike .= "inv.investor LIKE '%$searchFieldExp%' AND ";
        $industryLike .= "i.industry LIKE '%$searchFieldExp%' AND ";
        $websiteLike .= "pec.website LIKE '%$searchFieldExp%' AND ";*/

        $regionLike .= "pec.region REGEXP '[[:<:]]" . $searchFieldExp . "[[:>:]]' AND ";
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
    $regionLike = '(' . trim($regionLike, 'AND ') . ')';
    $cityLike = '(' . trim($cityLike, 'AND ') . ')';
    $companyLike = '(' . trim($companyLike, 'AND ') . ')';
    $sectorLike = '(' . trim($sectorLike, 'AND ') . ')';
    $moreInfoLike = '(' . trim($moreInfoLike, 'AND ') . ')';
    $investorLike = '(' . trim($investorLike, 'AND ') . ')';
    $industryLike = '(' . trim($industryLike, 'AND ') . ')';
    $websiteLike = '(' . trim($websiteLike, 'AND ') . ')';
    $tagsLike = '(' . trim($tagsLike, 'AND ') . ')';

    $tagsval = $cityLike . ' OR ' . $regionLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike . ' OR ' . $industryLike . ' OR ' . $websiteLike . ' OR ' . $tagsLike;

    if ($listallcompany == 1) {
        $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                        DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,
                         pe.Comment,pe.MoreInfor,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') AS Investor
                         FROM angelinvdeals AS pe, industry AS i,    pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                        WHERE DealDate between '" . $dt1 . "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId
                        AND pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND
            ( $tagsval ) $comp_industry_id_where GROUP BY pe.AngelDealId ";
        $orderby = "DealDate";
        $ordertype = "desc";
    } else {
        $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                        DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,
                         pe.Comment,pe.MoreInfor,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') AS Investor
                         FROM angelinvdeals AS pe, industry AS i,    pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                        WHERE DealDate between '" . $dt1 . "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId
                        AND pe.Deleted =0 and pe.AggHide =0" . $addVCFlagqry . " " . $addDelind . " and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND
            ( $tagsval ) $comp_industry_id_where GROUP BY pe.AngelDealId ";
        $orderby = "DealDate";
        $ordertype = "desc";
    }
    //echo "<bR>---" .$companysql;
} elseif ($companysearch != "") {
    $iftest = 2;
    $yourquery = 1;
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";
    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    $combineSearchFlag = true;
    if ($listallcompany == 1) {
        $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
        DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') AS Investor
                    FROM angelinvdeals AS pe, industry AS i,  pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                    WHERE DealDate between '" . $dt1 . "' and '" . $dt2 . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId
        AND pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND
        pec.PECompanyId IN ($companysearch) $comp_industry_id_where  GROUP BY pe.AngelDealId";
        $orderby = "DealDate";
        $ordertype = "desc";
    } else {
        $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
        DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') AS Investor
                    FROM angelinvdeals AS pe, industry AS i,  pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                    WHERE DealDate between '" . $dt1 . "' and '" . $dt2 . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId
        AND pe.Deleted =0 and pe.AggHide=0" . $addVCFlagqry . " " . $addDelind . " and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND
        pec.PECompanyId IN ($companysearch) $comp_industry_id_where  GROUP BY pe.AngelDealId";
        $orderby = "DealDate";
        $ordertype = "desc";
    }
    //    echo "<br>Query for company search";
    //echo "<br> Company search--" .$companysql;
} elseif ($keyword != "") {
    $iftest = 3;
    $yourquery = 1;
    $datevalueDisplay1 = "";
    $datevalueCheck1 = "";
    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-31";
    $combineSearchFlag = true;
    $ex_tags = explode(',', $keyword);
    $invval= count($ex_tags)-1;
   if ($invandor == 0) {
    $query="select InvestorId,Investor from peinvestors where InvestorId IN(".$keyword.") order by InvestorId desc";
                                       // echo $query;
                                        $queryval=mysql_query($query);
                                       
                                         $invreg='REGEXP "';
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
                                 $invreg.='"';
                                  
                                 $invregsubquery=" and ( SELECT GROUP_CONCAT(p.Investor  ORDER BY Investor='others' separator ', ') from peinvestors p JOIN  angel_investors a ON  a.InvestorId=p.InvestorId where  a.AngelDealId =pe.AngelDealId  ) ".$invreg;
       /* if (count($ex_tags) > 1) {
        $having=" having count(peinv_inv.AngelDealId) >".$invval;
        }else{
            $having="";
        }
    }
    else{
        $having="";*/
    }
    
    if ($listallcompany == 1) {
        $companysql = "select pe.AngelDealId,pec.PECompanyId,pe.AggHide,pec.companyname,pec.industry,i.industry,sector_business as sector_business,
                    peinv_inv.InvestorId,inv.Investor,pe.InvesteeId,pec.industry,
                    pec.companyname,DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,i.industry,pe.Dealdate as Dealdate,
                    ( SELECT GROUP_CONCAT(p.Investor  ORDER BY Investor='others' separator ', ') from peinvestors p JOIN  angel_investors a ON  a.InvestorId=p.InvestorId where  a.AngelDealId =pe.AngelDealId  ) AS  Investor
                    from angel_investors as peinv_inv,peinvestors as inv,
                    angelinvdeals as pe,pecompanies as pec,industry as i
                    where DealDate between '" . $dt1 . "' and '" . $dt2 . "' and  inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid  and pe.Deleted=0
                    and pe.AngelDealId=peinv_inv.AngelDealId and pec.PECompanyId=pe.InvesteeId " . $addVCFlagqry . " " . $addDelind . " AND
            inv.InvestorId IN($keyword) $comp_industry_id_where ".$invregsubquery."  GROUP BY pe.AngelDealId ";

        $orderby = "DealDate";
        $ordertype = "desc";
    } else {
        $companysql = "select pe.AngelDealId,pec.PECompanyId,pe.AggHide,pec.companyname,pec.industry,i.industry,sector_business as sector_business,
                    peinv_inv.InvestorId,inv.Investor,pe.InvesteeId,pec.industry,
                    pec.companyname,DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,i.industry,pe.Dealdate as Dealdate,
                    ( SELECT GROUP_CONCAT(p.Investor  ORDER BY Investor='others' separator ', ') from peinvestors p JOIN  angel_investors a ON  a.InvestorId=p.InvestorId where  a.AngelDealId =pe.AngelDealId  ) AS  Investor
                    from angel_investors as peinv_inv,peinvestors as inv,
                    angelinvdeals as pe,pecompanies as pec,industry as i
                    where DealDate between '" . $dt1 . "' and '" . $dt2 . "' and  inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid  and pe.Deleted=0 and pe.AggHide=0
                    and pe.AngelDealId=peinv_inv.AngelDealId and pec.PECompanyId=pe.InvesteeId " . $addVCFlagqry . " " . $addDelind . " AND
            inv.InvestorId IN($keyword) $comp_industry_id_where ".$invregsubquery." GROUP BY pe.AngelDealId ";

        $orderby = "DealDate";
        $ordertype = "desc";
    }
    //echo "<br> Investor search- ".$companysql;
} elseif ((($industry > 0) || ($followonVCFund >= 0) || ($exited >= 0) || ($txtregion != '') || ($citysearch != '')) && (($month1 != "--") && (year1 != "--") && ($month2 != "--") && ($year2 != "--")) || ($yearafter != "") || ($yearbefore != "")) {
    $iftest = 5;
    $yourquery = 1;
    $dt1 = $year1 . "-" . $month1 . "-01";
    $dt2 = $year2 . "-" . $month2 . "-01";

    $companysql = "select r.Region,pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId,pec.companyname,pec.industry,i.industry,
        pec.sector_business as sector_business,DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod,pe.Dealdate as Dealdate,
        GROUP_CONCAT( inv.Investor  ORDER BY Investor='others' separator ', ') AS Investor
                            from angelinvdeals as pe, industry as i,pecompanies as pec,angel_investors as peinv_inv,peinvestors as inv,region as r where";
    //    echo "<br> individual where clauses have to be merged ";

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
    if ($yearafter != '' && $yearbefore == '') {
        $whereyearaftersql = " pec.yearfounded >= $yearafter";
    }

    if ($yearbefore != '' && $yearafter == '') {
        $whereyearbeforesql = " pec.yearfounded <= $yearbefore";
    }

    if ($yearbefore != '' && $yearafter != '') {
        $whereyearfoundedesql = " pec.yearfounded >= $yearafter and pec.yearfounded <= $yearbefore";
    }
    if (($followonVCFund == "3") || ($followonVCFund == "1")) {
        if($followonVCFund == "1"){
            $wherefollowonVCFund = " pe.FollowonVCFund = " . $followonVCFund;
        }else{
            $wherefollowonVCFund = " pe.FollowonVCFund != 1" ;
        }
        $qryDealTypeTitle = "Follow on Funding Status  - ";
    }

    if (($exited == "3") || ($exited == "1")) {
        $whereexited = " pe.Exited =" . $exited;
        $qryDealTypeTitle = "Exited  - ";
    }
    if (count($txtregion) > 0) {
        $region_Sql = '';
        foreach ($txtregion as $regionIds) {
            $region_Sql .= " pec.RegionId  =$regionIds or ";
        }
        $roundSqlStr = trim($region_Sql, ' or ');
        $qryRegionTitle = "Region - ";
        if ($roundSqlStr != '') {

            $whereregion = '(' . $roundSqlStr . ')';
        }
        $qryDealTypeTitle = "Region  - ";
    }

    if ($citysearch != "") {
        $wherecity = " pec.city = '$citysearch'";
        $qryDealTypeTitle = "City  - ";
    }

    if (($month1 != "--") && (year1 != "--") && ($month2 != "--") && ($year2 != "--")) {
        $qryDateTitle = "Period - ";
        $wheredates = " DealDate between '" . $dt1 . "' and '" . $dt2 . "'";
    }

    if ($whereind != "") {
        $companysql = $companysql . $whereind . " and ";
    }

    if ($wherefollowonVCFund != "") {
        $companysql = $companysql . $wherefollowonVCFund . " and ";
    }

    if ($whereexited != "") {
        $companysql = $companysql . $whereexited . " and ";
    }

    if ($whereregion != "") {
        $companysql = $companysql . $whereregion . " and ";
    }

    if ($wherecity != "") {
        $companysql = $companysql . $wherecity . " and ";
    }

    if ($wheredates !== "") {
        $companysql = $companysql . $wheredates . " and ";
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
    if ($listallcompany == 1) {
        $companysql = $companysql . "  i.industryid=pec.industry and pec.PEcompanyID = pe.InvesteeId and r.RegionId=pec.RegionId
        and pe.Deleted=0 and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId " . $addVCFlagqry . "  " . $addDelind . "
        $comp_industry_id_where GROUP BY pe.AngelDealId ";
        //echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
        //die;
        $orderby = "DealDate";
        $ordertype = "desc";
    } else {
        $companysql = $companysql . "  i.industryid=pec.industry and pec.PEcompanyID = pe.InvesteeId and r.RegionId=pec.RegionId
        and pe.Deleted=0 and pe.AggHide=0 and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId " . $addVCFlagqry . "  " . $addDelind . "
        $comp_industry_id_where GROUP BY pe.AngelDealId ";
        //echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
        //die;
        $orderby = "DealDate";
        $ordertype = "desc";
    }
} else {
    echo "<br> Invalid input selection ";
    $fetchRecords = false;
}

$ajaxcompanysql = urlencode($companysql);
if ($companysql != "" && $orderby != "" && $ordertype != "") {
    $companysql = $companysql . " order by  Dealdate desc,companyname asc ";
}

//}
//END OF POST
$compId = 0;
$currentyear = date("Y");

$topNav = 'Deals';
include_once 'angelheader_search.php';
?>

<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
 <td class="left-td-bg" >
     <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>

    <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php include_once 'angelrefine.php';?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
     <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>
</div>
     </div>
</td>
    <?php

$exportToExcel = 0;
$TrialSql = "select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
                                                                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
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
    $totalInv = 0;

    $cos_array = array();
    if ($_SESSION['coscount']) {unset($_SESSION['coscount']);}
    if ($_SESSION['totalcount']) {unset($_SESSION['totalcount']);}
    $compDisplayOboldTag = "";
    $compDisplayEboldTag = "";
    //   echo $test."adssa".$dt1.$dt2."<br> query final-----".$iftest."/".($companysearch != "--")."/".$companysearch.$companysql;
    /* Select queries return a resultset */
    //echo $companysql;
    if ($companyrsall = mysql_query($companysql)) {
        $company_cntall = mysql_num_rows($companyrsall);
        while ($myrow = mysql_fetch_array($companyrsall, MYSQL_BOTH)) {
            //$cos_array[]=$myrow["PECompanyId"];
        }
    }

    $_SESSION['coscount'] = count(array_count_values($cos_array));
    $_SESSION['totalcount'] = @mysql_num_rows($companyrsall);

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

        $companysqlwithlimit = $companysql . " limit $offset, $rec_limit";
        if ($companyrs = mysql_query($companysqlwithlimit)) {
            $company_cnt = mysql_num_rows($companyrs);
        }
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
    ?>

    <td class="profile-view-left" style="width:100%;">

        <div class="result-cnt" style="margin-bottom: 50px;">
        <?php if ($accesserror == 1) {?>
                <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
                <?php exit;}?>

            <div class="result-title">
                <div class="filter-key-result">
                    <div style="float: left; margin: 20px 10px 0px 0px;font-size: 20px;">
                        <!-- <a  class="help-icon tooltip"><strong>Note</strong>
                            <span>
                                <img class="showtextlarge" src="images/callout.gif">
                                Target/Company in () indicates the deal is not to be used for calculating aggregate data.
                            </span>
                        </a>  -->
                        <!-- <a href="#popup1" class="help-icon"><img  width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle"></a> -->
                    </div>

                    <?php if (!$_POST) {?>

                        <div class="lft-cn">
                            <ul class="result-select">
                                <?php
if ($datevalueDisplay1 != "") {?>
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
                            </ul>
                        </div>
                        <div class="result-rt-cnt">
                            <div class="result-count">
                                <?php
if ($studentOption == 1) {
            ?>
                                 <!--<span class="result-no"><?php //echo @mysql_num_rows($companyrsall); ?> Results Found (across <?php //echo count(array_count_values($cos_array)); ?> cos)</span>-->
                                   <span class="result-no" id="show-total-deal">Results found</span>
                                 <?php
} else {
            /*if($exportToExcel==1)
            {*/
            ?>
                                       <!--<span class="result-no"><?php echo @mysql_num_rows($companyrsall); ?> Results Found (across <?php echo count(array_count_values($cos_array)); ?> cos)</span> -->
                                   <span class="result-no" id="show-total-deal">Results found</span>
                                     <?php
/*}
        else
        {
        ?>
        <span class="result-no">XXX Results Found</span>
        <?php
        }*/
        }
        ?>
                             <!--  <span class="result-for" style="float:left;margin-right: 10px;"> for Angel Investments</span> -->
                              <span class="result-for" style="float:left;margin-right: 10px;"></span>
                              <!-- <a href="#popup1" class="help-icon"><img  width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle"></a> -->
                               <input class="postlink" type="hidden" name="numberofcom" value="<?php echo @mysql_num_rows($companyrs); ?>">
                               <div class="title-links " id="exportbtn"><a class ="export_new" id="expshowdeals" name="showdeals">Export</a></div>
                            </div>
                        </div>
                               <?php
} else {
        ?>
                    <div class="lft-cn">
                        <ul  class="result-select">
                            <?php
                             $cl_count = count($_POST);
                             if ($cl_count >= 6) {
                                 ?>
                                                  <li class="result-select-close"><a href="angelindex.php"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                                  <?php
                     }
if ($industry > 0 && $industry != null) {?>
                           <!--  <li>
                            <?php //echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li> -->
                            <?php 
                                    $industryarray = explode(",",$industryvalue); 
                                    $industryidarray = explode(",",$industryvalueid); 
                                    foreach ($industryarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('industry',<?php echo $industryidarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                            <?php }
        if ($followonVC != "--" && $followonVC != "") {?>
                            <li>
                            <?php echo $followonVCFundText ?><a  onclick="resetinput('followonVCFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }if ($exited != "--" && $exitedText != '') {?>
                            <li>
                            <?php echo $exitedText ?><a  onclick="resetinput('exitedstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }
        if ($txtregion != "--" && $txtregion != "") {?>
                           <!--  <li>
                            <?php echo $regionText ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li> -->
                             <?php $regionarray = explode(",",$regionText); 
                               $regionidarray = explode(",",$regionvalueId);
                                    foreach ($regionarray as $key=>$value){  if($value!=''){?>
                                      <li>
                                         <?php echo $value; ?><a  onclick="resetmultipleinput('txtregion','<?php echo $regionidarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
             </li>
                                    <?php }} ?>
                                  <?php }
                            
        if ($citysearch != "--" && $citysearch != "") {?>
                            <li>
                            <?php echo $cityText ?><a  onclick="resetinput('citysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }
        if ($datevalueDisplay1 != "") {?>
                            <li>
                            <?php echo $datevalueDisplay1 . "-" . $datevalueDisplay2; ?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } else if ($datevalueCheck1 != "") {
            ?>
                            <li style="padding:1px 10px 1px 10px;">
                            <?php echo $datevalueCheck1 . "-" . $datevalueCheck2; ?>
                            </li>
                            <?php
} else if (trim($_POST['searchallfield']) != "" || trim($_POST['keywordsearch']) != "" || trim($_POST['companysearch']) != "") {
            ?>
                            <li style="padding:1px 10px 1px 10px;">
                            <?php echo $sdatevalueDisplay1 . "-" . $edatevalueDisplay2; ?>
                            </li>
                            <?php
}
        if ($keyword != "" && $keyword != " ") {?>
                            <!-- <li>
                            <?php //echo $invester_filter; ?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li> -->
                            <?php 
                                    $investerarray = explode(",",$invester_filter); 
                                    $investeridarray = explode(",",$invester_filter_id); 
                                    foreach ($investerarray as $key=>$value){  ?>
                                      <li>
                                          <?php echo $value; ?><a  onclick="resetmultipleinput('keywordsearch',<?php echo $investeridarray[$key]; ?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                      </li>
                                    <?php } ?>
                            <?php }
        if ($companysearch != "" && $companysearch != " ") {?>
                            <li>
                            <?php echo $company_filter ?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }
                            if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                                    <li> 
                                        <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                <?php } 
        if ($tagsearch != '') {

            // $ex_tags_filter = explode(':',$tagsearch);

            // if(count($ex_tags_filter) > 1){
            //     $tagsearch = trim($tagsearch);
            // }else{

            //     $tagsearch = "tag:".trim($tagsearch);

            // }
            ?>
            <?php $tagarray = explode(",",$tagsearch); 
             foreach ($tagarray as $key=>$value){  ?>
                  <li>
                      <?php echo "tag:".$value; ?><a  onclick="resetmultipleinput('tagsearch','<?php echo $tagarray[$key]; ?>');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                  </li>
                <?php } ?> 

                               <!--  <li><?php echo "tag:" . trim($tagsearch) ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li> -->
                            <?php
}
        if ($searchallfield != "") {?>
                            <li>
                                <?php echo $searchallfield ?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }
        $_POST['resetfield'] = "";
        foreach ($_POST as $value => $link) {
            if ($link == "" || $link == "--" || $link == " ") {
                unset($_POST[$value]);
            }
        }

       
        ?>
                        </ul>
                    </div>
                    <div class="result-rt-cnt">

                        <div class="result-count">
                            <?php
if ($studentOption == 1) {
            ?>
                            <span class="result-no" id="show-total-deal">Results found</span>
                            <?php
} else {

            ?>
                               <span class="result-no" id="show-total-deal">Results found</span>
                             <?php

        }
        ?>
                            <!-- <span class="result-for" style="float:left"> for Angel Investments</span> -->
                            <span class="result-for" style="float:left"></span>
                            <span class="result-amount" id="show-total-amount">  </span> </h2>
                            <!-- <a href="#popup1"><img src="images/help.png" width="18" height="18" alt="" border="0" style="vertical-align:middle"></a> -->
                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo @mysql_num_rows($companyrs); ?>">
                            <div class="title-links " id="exportbtn"><a class ="export_new" id="expshowdeals" name="showdeals">Export</a></div>
                        </div>
                    </div>

             <?php }?>

                </div>
            </div>


       <!--  <div style="margin-top: -25px; margin-left: 30%; position: absolute;width: 450px;float: left;">
            <label style="float:left"  ><input type="radio" name="angelnav" class="angelnav" value="1" checked >Funded Companies</label>
            <label style="float:left; margin-left: 15px;" ><input type="radio" name="angelnav" class="angelnav" value="2" >Fundraising Companies
              <img src="img/powered_by.png" style="position: absolute;    right: 25px;    top: -9px;" >
            </label>
        </div>  -->
      <?php
//echo $notable;
    if ($notable == 0) {
        ?>
       <!-- <div class="list-tab mt-trend-tab" style="margin-top: 140px !important;"><ul>
        <li class="active"><a class="postlink"   href="angelindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
         <?php
$count = 0;
        while ($myrow = mysql_fetch_array($companyrs, MYSQL_BOTH)) {
            if ($count == 0) {
                $comid = $myrow["AngelDealId"];
                $count++;
            }
        }
        ?>
        <li><a id="icon-detailed-view" class="postlink" href="angeldealdetails.php?value=<?php echo $comid; ?>/<?php echo $vcflagValue; ?>" ><i></i> Detail  View</a></li>
        </ul></div>-->
           <?php
if ($company_cntall > 0) {
            $hidecount = 0;
            //Code to add PREV /NEXT
            $icount = 0;
            $isflased = false;
            if ($_SESSION['resultId']) {
                unset($_SESSION['resultId']);
            }

            mysql_data_seek($companyrsall, 0);
            while ($myrow = mysql_fetch_array($companyrsall, MYSQL_BOTH)) {
                if (trim($myrow["sector_business"]) == "") {
                    $showindsec = $myrow["industry"];
                } else {
                    $showindsec = $myrow["sector_business"];
                }

                $companyName = trim($myrow["companyname"]);
                $companyName = strtolower($companyName);
                $compResult = substr_count($companyName, $searchString);
                $compResult1 = substr_count($companyName, $searchString1);

                if (($compResult == 0) && ($compResult1 == 0)) {
                    //Session Variable for storing Id. To be used in Previous / Next Buttons
                    $_SESSION['resultId'][$icount++] = $myrow["AngelDealId"];
                }
                if ($myrow["AggHide"] == 1) {
                    $NoofDealsCntTobeDeducted = 1;
                    $isflased = true;
                } else {
                    $NoofDealsCntTobeDeducted = 0;
                    $cos_array[] = $myrow["PECompanyId"];
                }
                $industryAdded = $myrow[2];
                $totalInv = $totalInv + 1 - $NoofDealsCntTobeDeducted;
                $totalAmount = $totalAmount + $myrow["amount"] - $amtTobeDeductedforAggHide;

            }
        }
        $total_cos = count(array_count_values($cos_array));
        if ($peEnableFlag) {
            if (empty($pe_company)) {
                $cos_array1 = '';
                $total_cos1 = 0;
            } else {
                $cos_array1 = explode(',', $pe_company);
                $total_cos1 = count(array_count_values($cos_array1));
            }
        } else {
            $cos_array1 = $cos_array;
        }

        if (isset($_POST['pe_checkbox']) && !empty($_POST['pe_checkbox'])) {
            $pecheckcount = count($pe_checkbox);
            $totalInv = $totalInv - $pecheckcount;
            $_SESSION['totalcount'] = $totalInv;
        }
         $totalInv=$_SESSION['totalcount'] ;
       
        //========================================junaid==========================================
        foreach (array_count_values($cos_array) as $key => $value) {
            $company_array[] = $key;
        }
        $comp_count = count(array_count_values($cos_array));
        $company_array_comma = implode(",", $company_array); // junaid
        //=========================================================================================
        ?>
               <?php
if ($studentOption == 1) {
            ?>
                    <script type="text/javascript" >
                           $("#show-total-deal").html('<span class="res_total"><?php echo $totalInv; ?></span> Results found (across <span class="comp_total"><?php echo $total_cos; ?></span> cos) ');
                    </script>
                    <?php
} else {
            ?>
                        <script type="text/javascript" >
                           /*$("#show-total-deal").html('<span class="res_total"><?php //if ($_POST['total_inv_deal'] != '') {echo $_POST['total_inv_deal'];} else {echo $totalInv;}?></span> Results found (across <span class="comp_total"><?php //echo $total_cos;?></span> cos) ');*/
                            $("#show-total-deal").html('<span class="res_total"><?php if($totalInv!=""){echo $totalInv;}else{echo $_POST['total_inv_deal'];}?></span> Results found (across <span class="comp_total"><?php echo $total_cos;?></span> cos) ');
                        </script>
                    <?php
}
        ?>

                 <?php if ($listallcompany != 1) {?>
             <div class="include" style="float: left; margin-bottom:10px;margin-top: 20px;">
                          <!-- <label style="font-size:13px;float:left;" class=""><input type="checkbox" name="listallcompanies" id="Listall" class="listall" value="1" <?php// if(($listallcompany || $listhidden) ==1){// echo "checked"; }  ?> style="vertical-align: middle;"> -->

                              <label style="font-size:13px;float:left;" class="">
                          <input type="checkbox" class="listall" value="<?php echo $listallcompany; ?>" <?php if (($listallcompany || $listhidden) == 1) {echo "checked";}?> style="vertical-align: middle;">


                                          <b class="blinktext">Include Deals that are not counted for aggregate data calculation</b>
                          </label>
                           <a style="margin-top: 0px !important;" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                <span style="width: 25%;">
                                <img class="showtextlarge" src="images/callout.gif" style="left:5px;">
                                By default, this database is restricted to investments by organized Angel Networks and Resident Individuals who have made active investments since 2004. Other Angel Investments are included in ().

                                </span>
                            </a>
             </div>
             <?php } else {?>
                <div class="include" style="float: left; margin-bottom:10px;margin-top:20px;">
                          <!-- <label style="font-size:13px;float:left;" class=""><input type="checkbox" name="listallcompanies" id="Listall" class="listall" value="1" <?php// if(($listallcompany || $listhidden) ==1){ echo "checked"; }  ?> style="vertical-align: middle;"> -->

                             <label style="font-size:13px;float:left;" class="">
                          <input type="checkbox" class="listall" value="<?php echo $listallcompany; ?>" <?php if (($listallcompany || $listhidden) == 1) {echo "checked";}?> style="vertical-align: middle;">


                                          <b>Include Deals that are not counted for aggregate data calculation</b>
                          </label>
                           <a style="margin-top: 0px !important;" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                <span style="width: 25%;">
                                <img class="showtextlarge" src="images/callout.gif" style="left: 95%;">
                                By default, this database is restricted to investments by organized Angel Networks and Resident Individuals who have made active investments since 2004. Other Angel Investments are included in ().

                                </span>
                            </a>
             </div>
             <?php }?>
        </div>


            <a id="detailpost" class="postlink"></a>
            <div class="view-table view-table-list">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
              <thead><tr>
               <?php
if ($searchallfield != '' || (count($_POST['industry']) > 0) || ($_POST['exitedstatus'] != "--" && $_POST['exitedstatus'] != "") || ($_POST['followonVCFund'] != "--" && $_POST['followonVCFund'] != "") || (count($_POST['txtregion']) > 0) || ($_POST['citysearch'] != "" || $_POST['tagsearch'] != ''  || $tagsearch != '') || $_POST['companyauto'] != '' || $_POST['investorauto_sug'] != '' || $_POST['yearbefore'] != '' || $_POST['yearafter'] != '') {

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
                <?php }
        ?>
                <th class="header <?php echo ($orderby == "companyname") ? $ordertype : ""; ?>"  id="companyname">Investee</th>
                <th class="header <?php echo ($orderby == "sector_business") ? $ordertype : ""; ?>" id="sector_business">Sector</th>
                 <th style="width: 260px;" class="header <?php echo ($orderby == "investor") ? $ordertype : ""; ?>" id="investor">Investor</th>
                <th style="width: 150px;" class="header <?php echo ($orderby == "DealDate") ? $ordertype : ""; ?>" id="DealDate">Date</th>

              </tr></thead>
              <tbody id="movies">
              <!--   <div class="include" style="float: right; margin-bottom:10px;">
                          <label style="font-size:13px;float:left;" class=""><input type="checkbox" name="listallcompanies" id="Listall" class="listall" value="1" <?php if (($listallcompany || $listhidden) == 1) {echo "checked";}?> style="vertical-align: middle;">
                          <b>Include Deals that are not counted for aggregate data calculation</b></label>
                           <a style="margin-top: 0px !important;" class="help-icon tooltip"><img width="18" height="18" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                <span style="left: 70%;">
                                <img class="showtextlarge" src="images/callout.gif" style="left: 90%;">
                                Target/Company in () indicates the deal is not to be used for calculating aggregate data.

                                </span>
                            </a>
              </div> -->
                                        <!--  </thead>  -->
                                <?php
if ($company_cnt > 0) {
            $hidecount = 0;
            mysql_data_seek($companyrs, 0);
            while ($myrow = mysql_fetch_array($companyrs, MYSQL_BOTH)) {
                $hideFlagset = 0;
                if (trim($myrow["sector_business"]) == "") {
                    $showindsec = $myrow["industry"];
                } else {
                    $showindsec = $myrow["sector_business"];
                }

                $companyName = trim($myrow["companyname"]);
                $companyName = strtolower($companyName);
                $compResult = substr_count($companyName, $searchString);
                $compResult1 = substr_count($companyName, $searchString1);

                if ($myrow["AggHide"] == 1) {
                    $openBracket = "(";
                    $closeBracket = ")";
                    $hideFlagset = 1;
                } else {
                    $openBracket = "";
                    $closeBracket = "";
                }
                ?>

                                      <?php
/*  if( $searchallfield != '' ) {
                if( !empty( $pe_checkbox ) ) {
                if( in_array( $myrow["AngelDealId"], $pe_checkbox ) ) {
                $peChecked = '';
                $rowClass = 'event_stop';
                } else {
                $peChecked = 'checked';
                $rowClass = '';
                }
                } else {
                $peChecked = 'checked';
                $rowClass = '';
                }
                }*/

                // ------------------------------------------junaid--------------------------------------------------

                if (count($pe_checkbox) > 0 && $pe_checkbox[0] != '' && count($pe_checkbox_enable) > 0 && $pe_checkbox_enable[0] != '') {

                    if ((in_array($myrow["AngelDealId"], $pe_checkbox))) {
                        $checked = '';
                        $rowClass = 'event_stop';

                    } elseif ((in_array($myrow["AngelDealId"], $pe_checkbox_enable))) {
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

                    if ((in_array($myrow["AngelDealId"], $pe_checkbox))) {
                        $checked = '';
                        $rowClass = 'event_stop';

                    } elseif ($_POST['full_uncheck_flag'] == 1) {
                        $checked = '';
                        $rowClass = 'event_stop';
                    } else {
                        $checked = 'checked';
                        $rowClass = '';
                    }

                } elseif (!empty($pe_checkbox_enable) && $pe_checkbox_enable[0] != '') { //=========================junaid=================

                    if ((in_array($myrow["AngelDealId"], $pe_checkbox_enable))) {
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
                // --------------------------------------------------------------------------------------------
                ?>


                                        <tr class="details_link <?php echo $rowClass; ?>" valueId="<?php echo $myrow["AngelDealId"]; ?>/<?php echo $vcflagValue; ?>">
                                           <?php
if ($searchallfield != '' || (count($_POST['industry']) > 0) || ($_POST['exitedstatus'] != "--" && $_POST['exitedstatus'] != "") || ($_POST['followonVCFund'] != "--" && $_POST['followonVCFund'] != "") || (count($_POST['txtregion']) > 0) || ($_POST['citysearch'] != "" || $_POST['tagsearch'] != '' || $tagsearch !='') || $_POST['companyauto'] != '' || $_POST['investorauto_sug'] != '' || $_POST['yearbefore'] != '' || $_POST['yearafter'] != '') {
                    ?>
                                          <td><input type="checkbox" data-hide-flag="<?php echo $hideFlagset; ?>" data-company-id="<?php echo $myrow['PECompanyId']; ?>" <?php echo $checked; ?> class="pe_checkbox" value="<?php echo $myrow["AngelDealId"]; ?>" /></td>
                                          <?php
}
                ?>

                                        <?php
if (($compResult == 0) && ($compResult1 == 0)) {
                    ?>
                                                <td ><?php echo $openDebtBracket; ?><?php echo $openBracket; ?><a class="postlink" href="angeldealdetails.php?value=<?php echo $myrow["AngelDealId"]; ?>/<?php echo $vcflagValue; ?> "><?php echo trim($myrow["companyname"]); ?></a><?php echo $closeBracket; ?><?php echo $closeDebtBracket; ?></td>
                                        <?php
} else {
                    ?>
                                                <td><a class="postlink" href="angeldealdetails.php?value=<?php echo $myrow["AngelDealId"]; ?>/<?php echo $vcflagValue; ?> "><?php echo ucfirst("$searchString"); ?></a></td>
                                        <?php
}
                ?>

                                                <td><a class="postlink" href="angeldealdetails.php?value=<?php echo $myrow["AngelDealId"]; ?>/<?php echo $vcflagValue; ?>" style="text-decoration: none"><?php echo trim($showindsec); ?></a></td>
                                                <td style="width: 260px;"><a class="postlink" href="angeldealdetails.php?value=<?php echo $myrow["AngelDealId"]; ?>/<?php echo $vcflagValue; ?>" style="text-decoration: none"><?php echo $myrow["Investor"]; ?></a></td>
                                                <td><a class="postlink" href="angeldealdetails.php?value=<?php echo $myrow["AngelDealId"]; ?>/<?php echo $vcflagValue; ?>" style="text-decoration: none"><?php echo $myrow["dealperiod"]; ?></a></td>
                                        </tr>
                                        <?php
}
        }
        ?>

        </tbody>
    </table>

    </div>
            <input type="hidden" name="pe_checkbox_disbale" id="pe_checkbox_disbale" value="<?php echo implode(',', $pe_checkbox); ?>">
            <input type="hidden" name="pe_checkbox_enable" id="pe_checkbox_enable" value="<?php echo implode(',', $pe_checkbox_enable); ?>">
            <input type="hidden" name="pe_checkbox_company" id="pe_checkbox_company" value="<?php echo implode(',', $cos_array1); ?>">
            <input type="hidden" name="listallcompanies" class="listallcompanies" value=<?php echo $listallcompany; ?> >
             <input type="hidden" name="hide_company_array" id="hide_company_array" value="<?php echo $_POST['pe_hide_companies']; ?>">
             <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php if ($_POST['total_inv_deal'] != '' && $searchallfield != '') {echo $_POST['total_inv_deal'];} else {echo $totalInv;}?>">
                <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php if ($_POST['total_inv_company'] != '' && $searchallfield != '') {echo $_POST['total_inv_company'];} else {echo $total_cos;}?>">
                <input type="hidden" name="array_comma_company" id="array_comma_company" value="<?php echo $company_array_comma; ?>">
            

       <?php
if ($searchallfield != '' || (count($_POST['industry']) > 0) || ($_POST['exitedstatus'] != "--" && $_POST['exitedstatus'] != "") || ($_POST['followonVCFund'] != "--" && $_POST['followonVCFund'] != "") || (count($_POST['txtregion']) > 0) || ($_POST['citysearch'] != "" || $_POST['tagsearch'] != '') || $_POST['companyauto'] != '' || $_POST['investorauto_sug'] != '' || $_POST['yearbefore'] != '' || $_POST['yearafter'] != '' ) {?>

                <input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php if ($_POST['real_total_inv_deal'] != '') {echo $_POST['real_total_inv_deal'];} else {echo $totalInv;}?>">
                <!-- <input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php if ($_POST['real_total_inv_company'] != '') {echo $_POST['real_total_inv_company'];} else {echo $total_cos;}?>"> -->

                <input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php if ($_POST['total_inv_deal'] != '') {echo $_POST['total_inv_deal'];} else {echo $totalInv;}?>">
                <input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php if ($total_cos != '') {echo $total_cos;} else {echo $_POST['total_inv_company'];}?>">
                <input type="hidden" name="all_checkbox_search" id="all_checkbox_search" value="<?php if ($_POST['full_uncheck_flag'] != '') {echo $_POST['full_uncheck_flag'];} else {echo "";}?>">
                <input type="hidden" name="array_comma_company" id="array_comma_company" value="<?php echo $company_array_comma; ?>">

                <input type="hidden" name="hide_company_array" id="hide_company_array" value="<?php echo $_POST['pe_hide_companies']; ?>">

           <?php }
    }
    /*   else
{
?>

<div class="list-tab"><ul>
<li class="active"><a class="postlink"   href="angelindex.php"  id="icon-grid-view"><i></i> List  View</a></li>
<?php
$count=0;
While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
{
if($count == 0)
{
$comid = $myrow["AngelDealId"];
$count++;
}
}
?>
<li><a id="icon-detailed-view" class="postlink" href="angeldealdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>" ><i></i> Detailed  View</a></li>
</ul></div>
<?php
}*/
}
?>
 <!-- <div class="pageinationManual"> -->
    <div class="holder" style="float:none; text-align: center;clear:both;">
      <div class="paginate-wrapper" style="display: inline-block;">
                 <?php
$totalpages = ceil($company_cntall / $rec_limit);
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

   
                     <!-- </div> -->

                        <center>
    <div class="pagination-section"><input type="text" name = "paginaitoninput" id = "paginationinput" class = "paginationtextbox" placeholder = "P.no" onkeyup = "paginationfun(this.value)">
    <button class = "jp-page1 button pagevalue" name="pagination" id="pagination" type="submit"  onclick = "validpagination()">Go</button></div>
    </center>

    <div>&nbsp;</div>
    <div>&nbsp;</div>

    </div>

        <?php /*if( $company_cnt > 0 ) {*/?>
         <div class="other_db_search">

        <div class="other_db_searchresult">
            <p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>
        </div>
        </div>
        <?php /*}*/?>
        <?php

if (!isset($_POST['tagsfield'])) {
    include "angeltag_report.php";
}

?>

    </td>
<input type="hidden" name="period_flag" id="period_flag" value="<?php echo $period_flag; ?>" />
    </tr>
    </table>

    </div>
  </form>
  <form name="companyDisplay" id="pelisting" method="post" action="exportangeldeals.php">
      <input type="hidden" name="listallcompanies" class="listallcompanies" value="<?php echo $listallcompany; ?>" >
      <input type="hidden" name="addVCFlagqryhidden" value="<?php echo $addVCFlagqry; ?>" >
      <input type="hidden" name="addDelindhidden" value="<?php echo $addDelind; ?>" >
      <input type="hidden" name="month1hidden" value="<?php echo $month1; ?>" >
      <input type="hidden" name="year1hidden" value="<?php echo $year1; ?>" >
      <input type="hidden" name="month2hidden" value="<?php echo $month2; ?>" >
      <input type="hidden" name="year2hidden" value="<?php echo $year2; ?>" >
      <input type="hidden" name="industryhidden" value="<?php echo $industry_hide; ?>" >
      <input type="hidden" name="regionhidden" value="<?php echo $region_hide; ?>" >
      <input type="hidden" name="followonVCFundhidden" value="<?php echo $followonVCFund; ?>" >
      <input type="hidden" name="exitedhidden" value="<?php echo $exited; ?>" >
      <input type="hidden" name="keywordhidden" value="<?php echo $keyword; ?>" >
      <input type="hidden" name="companysearchhidden" value="<?php echo $companysearch; ?>" >
      <input type="hidden" name="searchallfieldhidden" value="<?php echo $searchallfield; ?>" >
      <input type="hidden" name="cityhidden" value="<?php echo $citysearch; ?>" >
       <input type="hidden" name="yearafter" value=<?php echo $yearafter; ?> >
    <input type="hidden" name="yearbefore" value=<?php echo $yearbefore; ?> >
        <input type="hidden" name="txthidepe" id="txthidepe" value="<?php echo implode(',', $pe_checkbox); ?>">
        <input type="hidden" name="export_checkbox_enable" id="export_checkbox_enable" value="<?php echo implode(',', $pe_checkbox_enable); ?>">
        <input type="hidden" name="export_full_uncheck_flag" id="export_full_uncheck_flag" value="<?php if ($_POST['full_uncheck_flag'] != '') {echo $_POST['full_uncheck_flag'];} else {echo "";}?>">
        <input type="hidden" name="hide_company_array" id="hide_company_array" value="<?php echo $_POST['pe_hide_companies']; ?>">
        <input type="hidden" name="tagsearch" value="<?php echo $tagsearch; ?>" >
        <input type="hidden" name="tagandor" value="<?php echo $tagandor; ?>" >
        <input type="hidden" id="invradio" name="invradio" value="<?php if($invandor!=''){echo $invandor;}else {echo 0;}?>" placeholder="" style="width:220px;"> 
    
  </form>
    <div class=""></div>

    </div>


            <input type="hidden" id="prev" value="<?php echo $prevpage; ?>"/>
            <input type="hidden" id="current" value="<?php echo $currentpage; ?>"/>
            <input type="hidden" id="next" value="<?php echo $nextpage; ?>"/>
            <script src="js/listviewfunctions.js"></script>
            <script type="text/javascript">
                orderby='<?php echo $orderby; ?>';
                 ordertype='<?php echo $ordertype; ?>';
                $(".jp-next").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    pageno=$("#next").val();
                    $("#paginationinput").val('');
                    loadhtml(pageno,orderby,ordertype);}
                    return  false;
                });
                $(".jp-page").live("click",function(){
                    pageno=$(this).text();
                    $("#paginationinput").val('');
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });
                $(".jp-page1").live("click",function(){
                    pageno=$(this).val();
                    loadhtml(pageno,orderby,ordertype);
                    return  false;
                });

                $(".jp-previous").live("click",function(){
                    if(!$(this).hasClass('jp-disabled')){
                    pageno=$("#prev").val();
                    $("#paginationinput").val('');
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
                $( document ).ready(function() {
               
                var x = localStorage.getItem("pageno");
                //alert(x);
                if(x != 'null' && x != null)
                {
                loadhtml(x,orderby,ordertype)
                }
                else
                {
                    loadhtml(1,orderby,ordertype)
 
                }
                });
               function loadhtml(pageno,orderby,ordertype)
               {
                localStorage.setItem("pageno", pageno);
                $('#paginationinput').val(pageno)


                var peuncheckVal = $( '#pe_checkbox_disbale' ).val();
                var full_check_flag =  $( '#all_checkbox_search' ).val();//junaid
                var pecheckedVal = $( '#pe_checkbox_enable' ).val();//junaid
                jQuery('#preloading').fadeIn(1000);
                $.ajax({
                type : 'POST',
                url  : 'ajaxListview_angel.php',
                data: {

                        sql : '<?php echo addslashes($ajaxcompanysql); ?>',
                        totalrecords : '<?php echo addslashes($company_cntall); ?>',
                        page: pageno,
                        vcflagvalue:'<?php echo $vcflagValue; ?>',
                        orderby:orderby,
                        ordertype:ordertype,
                        searchField: '<?php echo $searchallfield; ?>',
                        industry:'<?php echo $industry; ?>',
                        followonVC: '<?php echo $followonVC; ?>',
                        exitvalue:'<?php echo $exitvalue; ?>',
                        region: '<?php echo $txtregion; ?>',
                        citysearch:'<?php echo $citysearch; ?>',
                        investor: '<?php echo $investorauto_sug_other; ?>',
                        company:'<?php echo $companysearch; ?>',
                        tagsearch:'<?php echo $tagsearch; ?>',
                        uncheckRows: peuncheckVal,
                        checkedRow:pecheckedVal,
                        full_uncheck_flag :  full_check_flag

                },
                success : function(data){
                        $(".view-table-list").html(data);
                        $(".jp-current").text(pageno);
                        var prev=parseInt(pageno)-1
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
                        $(".selectgroup select").multiselect('refresh') 

                        return  false;
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {
                        jQuery('#preloading').fadeOut(500);
                        alert('There was an error');
                }
            });
               }
               var pehideFlag = '';
            $( '.pe_checkbox' ).on( 'ifChanged', function(event) {
                //var amountChnage = true;
                var peuncheckCompdId = $( event.target ).val();
                
                //var peuncheckAmount = $(event.target).data('deal-amount');
                var peuncheckCompany = $( event.target ).data( 'company-id' );
                pehideFlag = $(event.target).data('hide-flag');
                var total_invdeal = $("#real_total_inv_deal").val(); //junaid
                var total_invcompany = $("#real_total_inv_company").val();//junaid
                /*if( peuncheckAmount == '--' ) {
                    amountChnage = false;
                } else {
                    peuncheckAmount = parseFloat( $(event.target).data('deal-amount') );
                }*/
                var cur_val = $("#pe_checkbox_disbale").val();
                var cur_val1 = $("#hide_company_array").val();//junaid
                var cur_va2 = $("#pe_checkbox_enable").val();//junaid
                var lastElement = $(event.target).parents('#myTable tbody .details_link').is(':last-child');

                if( $( event.target ).prop('checked') ) {

                    $(event.target).parents('.details_link').removeClass('event_stop');
                    //------------------------------junaid--------------------------------
                  
                    if( cur_va2 != '' ) {
                        $('#pe_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );
                        $('#export_checkbox_enable').val( cur_va2 + "," + peuncheckCompdId );

                    } else {
                        $('#pe_checkbox_enable').val( peuncheckCompdId );
                        $('#export_checkbox_enable').val( peuncheckCompdId );

                    }
                //----------------------------------------------------------------------------------
                    var strArray = cur_val.split(',');
                    for( var i = 0; i < strArray.length; i++ ) {
                        if ( strArray[i] === peuncheckCompdId ) {
                            strArray.splice(i, 1);
                        }
                    }
                    $('#pe_checkbox_disbale').val( strArray );
                    $('#txthidepe').val( strArray );
                    //------------------------------junaid--------------------------------
                    var strArray1 = cur_val1.split(',');
                    for( var i = 0; i < strArray1.length; i++ ) {
                        if ( strArray1[i] === peuncheckCompdId ) {
                            strArray1.splice(i, 1);
                        }
                    }
                    if( pehideFlag == 1 ) {
                        $( '#hide_company_array' ).val( strArray1 );
                    }
               //--------------------------------------------------------------
                    updateCountandAmount( 'add', pehideFlag , total_invdeal);
                    updateCompanyCount( peuncheckCompany, 'add', lastElement, pehideFlag,total_invcompany  );
                } else {

                    $(event.target).parents('.details_link').addClass('event_stop');
                    //------------------------------junaid--------------------------------
                    var strArray2 = cur_va2.split(',');
                    for( var i = 0; i < strArray2.length; i++ ) {
                        if ( strArray2[i] === peuncheckCompdId ) {
                            strArray2.splice(i, 1);
                        }
                    }
                    $('#pe_checkbox_enable').val( strArray2 );
                    $('#export_checkbox_enable').val( strArray2 );
                //--------------------------------------------------------------
                    if( cur_val != '' ) {
                        $('#pe_checkbox_disbale').val( cur_val + "," + peuncheckCompdId );
                        $('#txthidepe').val( cur_val + "," + peuncheckCompdId );
                    } else {
                        $('#pe_checkbox_disbale').val( peuncheckCompdId );
                        $('#txthidepe').val( peuncheckCompdId );
                    }
                    //------------------------------jagadeesh rework--------------------------------
                    if( pehideFlag == 1 ) {
                        if( cur_val1 != '' ) {
                            $('#hide_company_array').val( cur_val1 + "," + peuncheckCompdId );
                        } else {
                            $('#hide_company_array').val( peuncheckCompdId );
                }
                    }
                    //---------------------------------------------------------------
                    updateCountandAmount( 'remove', pehideFlag, total_invdeal );
                    updateCompanyCount( peuncheckCompany, 'remove', lastElement, pehideFlag,total_invcompany );
                }

            });

               //------------------------------junaid--------------------------------

             $( '.all_checkbox' ).on( 'ifChanged', function(event) {

                 if( $( event.target ).prop('checked') ) {

                    $( '#pe_checkbox_company' ).val($("#array_comma_company").val());

                     $( '#show-total-deal span.res_total' ).text( $("#real_total_inv_deal").val() );
                    $( '#show-total-deal span.comp_total' ).text($("#real_total_inv_company").val());
                    $( '#pe_checkbox_disbale' ).val('');

                    $( '#total_inv_deal' ).val($("#real_total_inv_deal").val());
                     $( '#total_inv_company' ).val($("#real_total_inv_company").val());

                     $( '#pe_checkbox_enable' ).val('');
                     $( '#export_checkbox_enable' ).val('');
                     $( '#txthidepe' ).val('');
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
                     $( '#export_checkbox_enable' ).val('');
                     $( '#pe_checkbox_disbale').val('');
                     $( '#show-total-deal span.res_total' ).text('0');
                     $( '#show-total-deal span.comp_total' ).text('0');
                     $( '#total_inv_deal' ).val('0');
                     $( '#total_inv_company' ).val('0');
                     $( '#all_checkbox_search' ).val('1');
                     $( '#export_full_uncheck_flag' ).val('1');
                     $( '#hide_company_array' ).val('');
                     $( '#expshowdeals').hide();

                    $('.pe_checkbox').each(function(){ //iterate all listed checkbox items

                        $(this).parents('.details_link').addClass('event_stop');
                        $(this).prop('checked',false);
                    });
                    $('.icheckbox_flat-red').removeClass('checked');

                 }
            });
        //---------------------------------------------------------------------------------------

            function updateCountandAmount( type, pehideFlag, total_invdeal ) {
                /*var cur_val = $("#pe_checkbox_disbale").val();
                var strArray = cur_val.split(',');
                console.log( strArray );
                var unchekedlength = strArray.length;*/
                var totalFound = parseFloat( $( '#show-total-deal span.res_total' ).text() );
                //var totalResAmount = parseFloat( $( '#show-total-amount h2 span' ).text().replace(',','').replace(' ','') );
                if( type == 'add' ) {
                    //var currAmount = totalResAmount + elementAmount;

                    if(pehideFlag!=1){
                    var currTotal = totalFound + 1;
                    }else{
                        var currTotal = totalFound;
                    }
                } else {
                    //var currAmount = totalResAmount - elementAmount;

                    if(pehideFlag!=1){
                    var currTotal = totalFound - 1;
                    }else{
                        var currTotal = totalFound;
                }
                }

                if(  currTotal == 0 ) {

                     $( '#expshowdeals').hide(); //junaid
                }else{
                    $( '#expshowdeals').show(); //junaid
                }
                 //------------------------------junaid-------------------------------

                if(currTotal >= total_invdeal && $('#hide_company_array').val()==''){
                    $('#export_checkbox_enable').val('');
                    $('#all_checkbox').prop('checked',true);
                    $('#all_checkbox').parents('.icheckbox_flat-red').addClass('checked');
                }else{
                    $('#all_checkbox').prop('checked',false);
                    $('#all_checkbox').parents('.icheckbox_flat-red').removeClass('checked');

                }
               //--------------------------------------------------------------------------
                /*if( amountFlag ) {
                    $( '#show-total-amount h2 span' ).text( currAmount.toFixed(2) );
                    $( '#show-total-amount h2 span' ).text( $( '#show-total-amount h2 span' ).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
                }*/
                if( pehideFlag == 0 ) {
                  $( '#show-total-deal span.res_total' ).text( currTotal );
                  $( '#total_inv_deal').val(currTotal); // junaid
                }
            }

            function updateCompanyCount( elementCompany, type, lastElement, pehideFlag, total_invcompany ) {
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
                        removedcompanyData = companyData.replace( elementCompany, '' ); //replaced by jagadeesh
                        removedcompanyData = removedcompanyData.replace(/(^,)|(,$)/g, ""); //replaced by jagadeesh
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
                            counts[value] = 1;
                        } else {
                            counts[value]++;
                        }
                    }
                });
                $( '#show-total-deal span.comp_total' ).text( Object.keys(counts).length );
                //alert(Object.keys(counts).length);
                $( '#total_inv_company').val(Object.keys(counts).length); //junaid
            }

           /* $('#expshowdeals').click(function(){
                jQuery('#preloading').fadeIn();
                initExport();
                return false;
            });*/

            $('#expshowdeals').click(function(){

                jQuery('#maskscreen').fadeIn(1000);
                jQuery('#popup-box-copyrights').fadeIn();
                return false;

            })

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
                                hrefval= 'exportangeldeals.php';
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
            </script>
            <script type="text/javascript">
                $("a.postlink").click(function(){
                    $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;

                });
                function resetinput(fieldname)
                {

               // alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                //  alert( $("#resetfield").val());
                  $("#pesearch").submit();
                    return false;
                }
                /*$(document).on('click', 'tr .details_link', function(){

                idval=$(this).attr("valueId");
                $("#detailpost").attr("href","<?php echo BASE_URL; ?>dealsnew/angeldealdetails.php?value="+idval).trigger("click");
            });*/
            </script>


             <form id="other_db_submit" method="post">
                <input type="hidden" name="searchallfield_other" id="other_searchallfield" value="<?php echo $searchallfield; ?>">
                <input type="hidden" name="companyauto_other" id="companyauto_other" value="<?php echo $companyauto; ?>">
                <input type="hidden" name="companysearch_other" id="companysearch_other" value="<?php echo $companysearch; ?>">
                <input type="hidden" name="investorauto_sug_other" id="investorauto_sug_other" value="<?php echo $investorauto; ?>">
                <input type="hidden" name="keywordsearch_other" id="keywordsearch_other" value="<?php echo $invester_filter; ?>">
                <input type="hidden" name="all_keyword_other" id="all_keyword_other" value="">
            </form>

<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">

        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>

<script>
 $(document).ready(function(){

$('input.listall').on('ifToggled', function(event){
 //  var list=$("#Listall").val();
 //  console.log(list);
 // $list1=$('.listhidden').val(list);

 // $(".datesubmit").trigger('click');
   var list = $(this).val();
   if(list == 1){
        $(".listallcompanies").val('0');
    } else if(list == 0){
        $(".listallcompanies").val('1');
    }

  $("#pesearch").submit();


});
 $(".listall").parent().removeClass();
  $(".listall").removeAttr('style');
  $('.include label div').css("display","inline-block");
  $('.include input').css("vertical-align","middle");
});
$('#agreebtn').click(function(){

    jQuery('#popup-box-copyrights').fadeOut();
    jQuery('#maskscreen').fadeOut(1000);
    jQuery('#preloading').fadeIn();
    initExport();
    return false;
});
$('#expcancelbtn').click(function(){

    jQuery('#popup-box-copyrights').fadeOut();
    jQuery('#maskscreen').fadeOut(1000);
    return false;
});
</script>

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
mysql_close();
?>



    <script>
        $(document).ready(function(){



                       $('.angelnav').on('ifChecked', function(event){
                            val = $('input[name=angelnav]:checked').val();
                            if(val==1){
                                window.location.href='angelindex.php';
                            }
                             else if(val==2){
                               window.location.href='angelcoindex.php';
                            }
                         });



                        //  $('input.listall').on('ifToggled', function(event){
                        //         var list=$("#Listall").val();
                        //         console.log(list);
                        //         $list1=$('.listhidden').val(list);

                        //         $(".datesubmit").trigger('click');

                          //  });
                     });


  </script>

 <script type="text/javascript" >


        <?php /* if($_POST || $vcflagValue==2)
{ ?>
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
<?php } */?>

    </script>



      <style>
     
       @keyframes blinker {
  50% { opacity: 0.0; }
}
.blinktext{animation: blinker 2s linear infinite;}
        .other_db_search{
            display: none;
            width: 100%;
            float: left;
            margin-bottom: 50px;
        }
        .other_db_searchresult a{
            margin-left: 5px;
        }
        .other_db_searchresult{
            background: #F2EDE1;
            padding: 10px;
            margin: 0 17px;
            font-weight: bold;
            font-size: 14px;

        }
        .other_loading{
            margin: 0;
            text-align: center;
            font-weight: bold;
        }
        .other_db_link,.other_db_links{
            background: #a2753a;
            padding: 2px 5px;
            color: #fff;
            text-decoration: none;
            border-radius: 2px;
        }
         .other_db_link:hover,.other_db_links:hover{
            background:#413529;
            color: #fff;
        }
    </style>


    <script>
    <?php

if ($searchallfield != ''|| $combineSearchFlag!='') {?>
        $(document).ready(function(){

            <?php if ($company_cnt == 0) {?>
                              $('.other_db_search').css('margin-top','25px');
            <?php }
            if($combineSearchFlag !=''){
                    $searchStringGmail = "&industry=".implode(",",$industry)."&sector=".implode(",",$sector)."&subsector=".$subsectorString."&keyword=".$keyword."&companysearch=".$companysearch."&round=".implode(",",$round)."&regionId=".implode(",",$regionId)."&city=".$city."&companyType=".$companyType."&debt_equity=".$debt_equity."&syndication=".$syndication."&investorType=".$investorType."&exitstatusValue=".implode(",",$exitstatusValue);
                     $filed_name = 'combinesearch';

                 }
            ?>
            var filed_name='';
            filed_name = <?php echo "'".$filed_name."'"; ?>;
            $('.other_db_search').fadeIn();
            $.get( "gmail_like_search.php?section=VC-Inv-Angel&search=<?php echo $searchallfield; ?><?php echo $searchStringGmail; ?>&filed_name="+filed_name, function( data ) {

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
    // Tag Search
    var tagsearchval = $('#tagsearch').val();
    if(tagsearchval == ''){
        $('.acc_trigger.helptag').removeClass('active').next().hide();
    }
    // Tag search

 <?php if (($company_cnt == 0) && (trim($invester_filter) != '' || trim($companyauto) != '' || trim($sectorsearch) != '' || trim($advisorsearchstring_legal) != '' || trim($advisorsearchstring_trans) != '')) {

    $searchList = $invester_filter . $companyauto . str_replace("'", "", trim($sectorsearch)) . $advisorsearchstring_legal . $advisorsearchstring_trans;
    $searchList = explode(',', $searchList);
    $count = 0;
    /*if ($invester_filter != '') {
        $filed_name = 'investor';
    } else if ($companyauto != '') {
        $filed_name = 'company';
    }*/
    ?>

       $('.other_db_search').css('margin-top','25px');
       $('.other_db_search').fadeIn();
       $('.other_db_searchresult').html('');
       var href='';
     <?php
foreach ($searchList as $searchtext) {
        $searchallfield = trim($searchtext);

        $count++;
        ?>
       console.log('<?php echo $searchallfield; ?>');
       var link ="gmail_like_search.php?section=<?php echo $section; ?>-not&search=<?php echo $searchallfield; ?>&filed_name=<?php echo $filed_name; ?>";
      var text = 'Click here to search';

        href += '<div class="refine_to_global"> "<?php echo $searchallfield ?>" - <a class="refine_to_global_link" style="text-decoration: none;font-family: sans-serif" href="'+link+'" id="refinesearch_<?php echo $count ?>" >'+text+'</a><div style="font-weight: normal;" class="other_db_searchresult refinesearch_<?php echo $count ?>"></div><div>';

 <?php }?>

  $('.other_db_searchresult').html('<b style="font-size:16px">Search in other databases</b><br><br><br>'+href);


   $(".refine_to_global_link").click(function() {
       var getLink = $(this).attr('href');
       var classname = this.id;

       $('.'+classname).html('<p class="other_loading">Please wait while we search for results in other databases<br><img  src="images/other_loading.gif"></p>');

      // alert(getLink);

       $.get(getLink, function( data ) {

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

        $(document).on('click','.count_percent',function(){

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
  });





    </script>
    <?php
mysql_close();
mysql_close($cnx);
?>


<script>
    function paginationfun(val)
    {
        $(".pagevalue").val(val);
    }
    function validpagination()
            {
                var pageval = $("#paginationinput").val();
                if(pageval == "")
                {
                    alert('Please enter the page Number...');
                    location.reload();
                }else{
                    
                }
            }
    var wage = document.getElementById("paginationinput");
                wage.addEventListener("keydown", function (e) {debugger;
                    if (e.code === "Enter") {  //checks whether the pressed key is "Enter"
                        //paginationForm();
                        event.preventDefault();
                        document.getElementById("pagination").click();

                    }
                })
    </script>

    <style>

.paginationtextbox{
        width:3%;
        padding: 3px;
    }

    input[type='text']::placeholder

{   

text-align: center;      /* for Chrome, Firefox, Opera */

}
        .button{
        background-color: #a2753a; /* Green */
    border: none;
    color: white;
    padding: 4px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
        }

        .pageinationManual{
        display: flex;
        position: absolute;

        left: 40%;


    }
    </style>
