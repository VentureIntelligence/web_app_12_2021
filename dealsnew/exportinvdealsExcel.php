<?php include_once("../globalconfig.php"); ?>
<?php

/*//session_save_path("/tmp");
session_start();

require("../dbconnectvi.php");
$Db = new dbInvestments();

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


$currentyear = date("Y");
$wherestage = "";
$submitemail = $_POST['txthideemail'];
$searchtitle = $_POST['txttitle'];
$industry = $_POST['txthideindustryid'];
$hideindustrytext = $_POST['txthideindustry'];
//echo "<Br>-----------" .$hideindustrytext;
$hidestagetext = $_POST['txthidestage'];
$stagearr = $_POST['txthidestageid'];
$round = $_POST['txthideround'];
//echo "<br>--". $hidestagetext;
$GetCompId = "select dm.DCompId,dc.DCompId from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$submitemail' and dc.DCompId=dm.DCompId";
if ($trialrs = mysql_query($GetCompId)) {
    while ($trialrow = mysql_fetch_array($trialrs, MYSQL_BOTH)) {
        $compId = $trialrow["DCompId"];
    }
}
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

if ($stagearr != "--") {
    $stageidvalue = explode(",", $stagearr);
    foreach ($stageidvalue as $stageid) {
        if (trim($stageid) !== "") {
            $stagevalue = $stagevalue . " pe.StageId=" . $stageid . " or ";
        }
    }
    $wherestage = $stagevalue;
    $qryDealTypeTitle = "Stage  - ";
    $strlength = strlen($wherestage);
    $strlength = $strlength - 3;

    $wherestage = substr($wherestage, 0, $strlength);
    if (trim($wherestage != ""))
        $wherestage = " (" . $wherestage . ")";
    else
        $wherestage == "";
    //echo "<Br>----------------" .$wherestage;
}
else {
    $stage = "--";
    $wherestage == "";
}
//VCFLAG VALUE
$hidesearchon = $_POST['txtsearchon'];

$companyType = $_POST['txthidecomptype'];
$debt_equity = $_POST['txthidedebt_equity'];
$invtypevalue = $_POST['txthideinvtype'];
$invType = $_POST['txthideinvtypeid'];
//echo "<Br>----". $invType;

$regionId = $_POST['txthideregionid'];
$regionValue = $_POST['txthideregionvalue'];
//echo "<br>REGION- " .$regionId;
$city = $_POST['txthidecity'];
$startRangeValue = $_POST['txthiderangeStartValue'];
$endRangeValue = $_POST['txthiderangeEndValue'];
$rangeText = $_POST['txthiderange'];
$syndication = $_POST['txthidesyndication'];
$datevalue = $_POST['txthidedate'];

$keyword = $_POST['txthideinvestor'];
//echo "<Br>**" .$keyword;
$keyword = ereg_replace("_", " ", $keyword);
// echo "<br>))))))))))))))))))))))))))))))))))))))))))" .$keyword;

$companysearch = $_POST['txthidecompany'];
$companysearch = ereg_replace("_", " ", $companysearch);

$sectorsearch = $_POST['txthidesector'];
$sectorsearch = stripslashes(ereg_replace("_", " ", $sectorsearch));
// exit;

$advisorsearch_legal = $_POST['txthideadvisor_legal'];
$advisorsearch_legal = ereg_replace("_", " ", $advisorsearch_legal);
$advisorsearch_trans = $_POST['txthideadvisor_trans'];
$advisorsearch_trans = ereg_replace("_", " ", $advisorsearch_trans);

//echo "<br>- ".$advisorsearch;

$searchallfield = $_POST['txthidesearchallfield'];
$searchallfield = ereg_replace("_", " ", $searchallfield);

$hidedateStartValue = $_POST['txthidedateStartValue'];
$hidedateEndValue = $_POST['txthidedateEndValue'];
$dateValue = $_POST['txthidedate'];
$exportflagvalue = $_POST['txtexportFlag'];

if ($_POST['txthidedateStartValue'] != '' && $_POST['txthidedateEndValue'] != '') {

    $wheredatesexport = " dates between '" . $_POST['txthidedateStartValue'] . "' and '" . $_POST['txthidedateEndValue'] . "'";
} else {
    $dates1 = "2004-01-01";
    $dates2 = $currentyear . "-12-01";
    $wheredatesexport = " dates between '" . $dates1 . "' and '" . $dates2 . "'";
}

$exitstatusValue = $_POST['txthideexitstatusValue'];
//	echo "<Br>****".$exportflagvalue;


$whereind = "";
$whereregion = "";
$whereinvType = "";
$wherelisting_status = "";
$wheredates = "";
$whererange = "";
$whereexitstatus = "";


$tsjtitle = "� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
$tranchedisplay = "Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.";
$exportstatusdisplay = "Pls Note : Excel Export is available for transactions from Jan.2004 only, as part of search results. You can export transactions prior  to 2004 on a deal by deal basis from the deal details popup.";
//echo "<bR>&&&&".$searchtitle;
if ($searchtitle == 0) {
    $addVCFlagqry = " and pec.industry !=15 ";
    $checkForStage = ' && (' . '$stage' . ' =="--")';
    //$checkForStage = " && (" .'$stage'."=='--') ";
    //$checkForStageValue = " || (" .'$stage'.">0) ";
    $searchTitle = "List of PE Investments ";
} elseif ($searchtitle == 1) {
    $addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and amount <=20 ";

    $checkForStage = '&& (' . '$stage' . '=="--") ';
    //$checkForStage = " && (" .'$stage'."=='--') ";
    //$checkForStageValue =  " || (" .'$stage'.">0) ";
    $searchTitle = "List of VC Investments ";
} elseif ($searchtitle == 2) {
    $addVCFlagqry = " and pec.industry =15 ";
    $stage = "--";
    $checkForStage = "";
    $checkForStageValue = "";
    $searchTitle = "List of PE Investments - Real Estate";
}


if (($keyword == "") && ($searchallfield == "") && ($companysearch == "") && ($advisorsearch_trans == "") && ($advisorsearch_legal == "") && ($regionId == "--" || $regionId =='') && ($industry == "--") && ($companyType == "") && ($invType == "--") && ($startRangeValue == "--") && ($endRangeValue == "--") && ($hidedateStartValue == "------01") && ($hidedateEndValue == "------01") && ($stage == "--") && ($debt_equity == "--")) {
    $companysql = "SELECT PEId,PEId,PEId,pe.PECompanyId, pe.StageId,pec.countryid,
						 pec.industry,pec.companyname, i.industry, pec.sector_business,
						 amount, round, s.stage, it.InvestorTypeName, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod , pec.website, pec.city,
						 r.Region,MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ
						 FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,country as c,investortype as it,region as r
						 WHERE pec.industry = i.industryid and it.InvestorType=pe.InvestorType
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid
						 and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) )  and " . $wheredatesexport . "
						  and pe.Deleted=0  " . $addVCFlagqry . " " . $addDelind . "
                                                 AND pe.PEId NOT
                                                  IN (
                                                  SELECT PEId
                                                  FROM peinvestments_dbtypes AS db
                                                  WHERE DBTypeId = '$dbTypeSV'
                                                  AND hide_pevc_flag =1
                                                  ) $comp_industry_id_where order by companyname";

    //	echo "<br>3 Query for All records" .$companysql;
} elseif ($companysearch != "") {
//print_r($_SESSION['pe_inv']);die;
    //$companysearch = implode($_SESSION['pe_inv'],',');
    $companysql = "SELECT PEId,PEId,PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
						pec.companyname, i.industry, pec.sector_business,
						pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
						pec.website, pec.city, r.Region,
						MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ
						FROM peinvestments AS pe, industry AS i,
						pecompanies AS pec,stage as s,country as c,investortype as it,region as r
						WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
						and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) )   and  " . $wheredatesexport . " 
						AND pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " AND  pec.PECompanyId IN ($companysearch)
						AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where
                                                order by companyname";//die;
    //	echo "<br>Query for company search";
    //echo "<br> Company search--" .$companysql;
} elseif ($sectorsearch != "") {

    
    
                     $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                            $sector_sql = array(); // Stop errors when $words is empty

                            foreach($sectorsearchArray as $word){
                                $word = trim($word);
//                                $sector_sql[] = " sector_business LIKE '$word%' ";
                                                $sector_sql[] = " sector_business = '$word' ";
                                                $sector_sql[] = " sector_business LIKE '$word(%' ";
                                                $sector_sql[] = " sector_business LIKE '$word (%' ";
                            }
                            $sector_filter = implode(" OR ", $sector_sql);
                            
                            
    $companysql = "SELECT PEId,PEId,PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
						pec.companyname, i.industry, pec.sector_business,
						pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
						pec.website, pec.city, r.Region,
						MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ
						FROM peinvestments AS pe, industry AS i,
						pecompanies AS pec,stage as s,country as c,investortype as it,region as r
						WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
						and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) ) 
                    and " . $wheredatesexport . "  AND pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " AND   ($sector_filter)    AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where
                    order by  companyname";
                    
                            
//    $companysql = "SELECT PEId,PEId,PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
//                    pec.companyname, i.industry, pec.sector_business,
//                    pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
//                    pec.website, pec.city, r.Region,
//                    MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,
//                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT
//                    FROM peinvestments AS pe, industry AS i,
//                    pecompanies AS pec,stage as s,country as c,investortype as it,region as r
//                    WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
//                    and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) ) 
//                    and " . $wheredatesexport . "  AND pe.Deleted =0 and pe.AggHide=0 and pe.SPV=0  " . $addVCFlagqry . " " . $addDelind . " AND   sector_business IN ($sectorsearch)    AND pe.PEId NOT
//                    IN (
//                    SELECT PEId
//                    FROM peinvestments_dbtypes AS db
//                    WHERE DBTypeId =  '$dbTypeSV'
//                    AND hide_pevc_flag =1
//                    )
//                    order by  companyname";
    /* echo "<br>Query for sector search";
      echo "<br> sector search--" .$companysql; ///////////////////////////////////////////////////////////////////////////////////////////
} elseif ($keyword != "") {
    $companysql = "select peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,pec.industry,
						peinv_inv.InvestorId,peinv_inv.PEId,
						pec.companyname,i.industry,sector_business,peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
						DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
						hideamount,hidestake,c.country,inv.Investor,Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR, peinv.Company_Valuation_pre, peinv.Revenue_Multiple_pre, peinv.EBITDA_Multiple_pre, peinv.PAT_Multiple_pre, peinv.Company_Valuation_EV, peinv.Revenue_Multiple_EV, peinv.EBITDA_Multiple_EV, peinv.PAT_Multiple_EV, peinv.Total_Debt, peinv.Cash_Equ
						from peinvestments_investors as peinv_inv,peinvestors as inv,
					peinvestments as peinv,pecompanies as pec,industry as i,stage as s,country as c,investortype as it,region as r
					where inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and
					 s.StageId=peinv.StageId and c.countryid=pec.countryid and it.InvestorType=peinv.InvestorType  and  peinv.Deleted=0
					and peinv.amount!=0 and peinv.PEId=peinv_inv.PEId and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) ) 
						and " . $wheredatesexport . "
					and pec.PECompanyId=peinv.PECompanyId " . $addVCFlagqry . " " . $addDelind . " AND inv.InvestorId IN($keyword)
                                        AND peinv.PEId NOT
                                        IN (
                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId =  '$dbTypeSV'
                                        AND hide_pevc_flag =1
                                        ) $comp_industry_id_where
                                 order by companyname";

    //echo "<br> Investor search- ".$companysql;
} elseif ($advisorsearch_legal != "") {
    $companysql = "(SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,pec.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
						pec.companyname, i.industry, pec.sector_business, peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
						DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
						hideamount,hidestake,co.country,cia.Cianame,Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR, peinv.Company_Valuation_pre, peinv.Revenue_Multiple_pre, peinv.EBITDA_Multiple_pre, peinv.PAT_Multiple_pre, peinv.Company_Valuation_EV, peinv.Revenue_Multiple_EV, peinv.EBITDA_Multiple_EV, peinv.PAT_Multiple_EV, peinv.Total_Debt, peinv.Cash_Equ
						FROM peinvestments AS peinv, pecompanies AS pec, industry AS i,stage as s,country as co,investortype as it,
						advisor_cias AS cia, peinvestments_advisorinvestors AS adac,region as r
						WHERE peinv.Deleted=0 and peinv.amount!=0 and pec.industry = i.industryid
						AND pec.PECompanyId = peinv.PECompanyId and
					 	s.StageId=peinv.StageId and co.countryid=pec.countryid and it.InvestorType=peinv.InvestorType
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.PEId and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) )   	and " . $wheredatesexport . "
						AND cia.cianame LIKE '%$advisorsearch_legal%'   and AdvisorType='L'" . $addVCFlagqry . " " . $addDelind . "
						AND peinv.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId = '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where )
						UNION (
						SELECT peinv.PEId,peinv.PECompanyId, peinv.StageId,pec.countryid,pec.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
						pec.companyname, i.industry, pec.sector_business, peinv.amount, peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
						DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
						hideamount,hidestake,co.country,cia.Cianame,Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR, peinv.Total_Debt, peinv.Cash_Equ
						FROM peinvestments AS peinv, pecompanies AS pec, industry AS i,stage as s,country as co,investortype as it,
						advisor_cias AS cia, peinvestments_advisorcompanies AS adac,region as r
						WHERE peinv.Deleted=0 and peinv.amount!=0 and pec.industry = i.industryid
						AND pec.PECompanyId = peinv.PECompanyId
						and
					 	s.StageId=peinv.StageId and co.countryid=pec.countryid and it.InvestorType=peinv.InvestorType
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.PEId and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) )    	and " . $wheredatesexport . "
						AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' " . $addVCFlagqry . " " . $addDelind . "
						AND peinv.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId = '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where )";
    //	echo "<Br>--LEGAL -Advisor search";
} elseif ($advisorsearch_trans != "") {
    $companysql = "(SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,pec.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
						pec.companyname, i.industry, pec.sector_business, peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
						DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
						hideamount,hidestake,co.country,cia.Cianame,Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT,price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR, peinv.Company_Valuation_pre, peinv.Revenue_Multiple_pre, peinv.EBITDA_Multiple_pre, peinv.PAT_Multiple_pre, peinv.Company_Valuation_EV, peinv.Revenue_Multiple_EV, peinv.EBITDA_Multiple_EV, peinv.PAT_Multiple_EV, peinv.Total_Debt, peinv.Cash_Equ
						FROM peinvestments AS peinv, pecompanies AS pec, industry AS i,stage as s,country as co,investortype as it,
						advisor_cias AS cia, peinvestments_advisorinvestors AS adac,region as r
						WHERE peinv.Deleted=0 and peinv.amount!=0 and pec.industry = i.industryid
						AND pec.PECompanyId = peinv.PECompanyId and
					 	s.StageId=peinv.StageId and co.countryid=pec.countryid and it.InvestorType=peinv.InvestorType
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.PEId and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) )   	and " . $wheredatesexport . "
						AND cia.cianame LIKE '%$advisorsearch_trans%'   and AdvisorType='T' " . $addVCFlagqry . " " . $addDelind . "
						AND peinv.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId = '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where )
						UNION (
						SELECT peinv.PEId,peinv.PECompanyId, peinv.StageId,pec.countryid,pec.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
						pec.companyname, i.industry, pec.sector_business, peinv.amount, peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
						DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
						hideamount,hidestake,co.country,cia.Cianame,Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR
						FROM peinvestments AS peinv, pecompanies AS pec, industry AS i,stage as s,country as co,investortype as it,
						advisor_cias AS cia, peinvestments_advisorcompanies AS adac,region as r
						WHERE peinv.Deleted=0 and peinv.amount!=0 and pec.industry = i.industryid
						AND pec.PECompanyId = peinv.PECompanyId
						and
					 	s.StageId=peinv.StageId and co.countryid=pec.countryid and it.InvestorType=peinv.InvestorType
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.PEId and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) )    	and " . $wheredatesexport . "
						AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T'  " . $addVCFlagqry . " " . $addDelind . "
						AND peinv.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId = '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where )";

    //echo "<br>*** Trans Advisor Search-" .$companysql;
} elseif ($searchallfield != "") {

    $findTag = strpos($searchallfield,'tag:');
    $findTags = "$findTag";
    if($findTags == ''){
        $searchExplode = explode( ' ', $searchallfield );
        foreach( $searchExplode as $searchFieldExp ) {
            $cityLike .= "pec.city LIKE '$searchFieldExp%' AND ";
            $companyLike .= "pec.companyname LIKE '%$searchFieldExp%' AND ";
            $sectorLike .= "sector_business LIKE '%$searchFieldExp%' AND ";
            $moreInfoLike .= "MoreInfor LIKE '%$searchFieldExp%' AND ";
            $investorLike .= "invs.investor LIKE '%$searchFieldExp%' AND ";
            //$tagsLike .= "pec.tags LIKE '%$searchFieldExp%' AND "; // old vijay
            $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,' OR ";
            //$tagsLike .= "pec.tags LIKE '%$searchFieldExp%' AND "; // new varatha
        }
        $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";
        $cityLike = '('.trim($cityLike,'AND ').')';
        $companyLike = '('.trim($companyLike,'AND ').')';
        $sectorLike = '('.trim($sectorLike,'AND ').')';
        $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
        $investorLike = '('.trim($investorLike,'AND ').')';
        $tagsLike = '('.trim($tagsLike,'OR ').')';
        $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike . ' OR ' . $tagsLike;
        /*$tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                    OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%' or pec.tags like '%$searchallfield%'";///////////////////////////////////////////////////////////////////////////////////////                                 
    }else{
        $tags = '';
        $ex_tags = explode(',',$searchallfield);
        if(count($ex_tags) > 0){
            for($l=0;$l<count($ex_tags);$l++){
                if($ex_tags[$l] !=''){
                    $value = trim(str_replace('tag:','',$ex_tags[$l]));
                    $tags .= "pec.tags like '%:$value%' or ";
                }
            }
        }
        $tagsval = trim($tags,' or ');
    }
    
    $companysql = "SELECT distinct pe.PEId,pe.PEId,pe.PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
						pec.companyname, i.industry, pec.sector_business,
						pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
						pec.website, pec.city, r.Region,
						MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book,book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ
						FROM peinvestments AS pe, industry AS i,
						pecompanies AS pec,stage as s,country as c,investortype as it,region as r,
                                                peinvestments_investors as peinv_invs,peinvestors as invs
						WHERE  dates between '" . $hidedateStartValue . "' and '" . $hidedateEndValue . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                                AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId
						and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) ) 
                    AND pe.Deleted =0 " . $addVCFlagqry . " " . $addDelind . " AND ( $tagsval )
						AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                ) $comp_industry_id_where
                                                order by companyname";
    //echo "<br>Query for SEARCH ALL  search";
    // echo "<br> Company search--" .$companysql;
} elseif (($industry != '') || ($round != "--" && $round != "") || ($city != "") || ($companyType != "--" && $companyType != "") || ($debt_equity != "--" && $debt_equity != "") || ($invType != "--" && $invType != "") || ($regionId != '' && $regionId != '--') || ($startRangeValue != "--" && $startRangeValue != "") || ($endRangeValue != "--" && $endRangeValue != "") || ($wherestage != "") || (($hidedateStartValue != "------01") && ($hidedateEndValue != "------01"))) {
    $txthidevaluation = $_REQUEST['txthidevaluation'];
    $companysql = "select pe.PEId,pe.PEId,pe.PEId,pe.PECompanyID,pe.StageId,pec.countryid,
                    pec.industry,pec.companyname,i.industry,pec.sector_business,amount,round,s.stage,
                    it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%M-%Y') as dealperiod,
                    pec.website,pec.city,r.Region,MoreInfor,hideamount,hidestake,c.country,c.country,
                    Link,pec.RegionId,Valuation,FinLink,
                    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ
                    from peinvestments as pe, industry as i,pecompanies as pec,stage as s,
                    country as c,investortype as it,region as r
                    where    " . $txthidevaluation . "  ";
    //	echo "<br> individual where clauses have to be merged ";

    if ($regionId != '' && $regionId != '--') {
        $regionSql = '';
        $regionId1 = explode(',',$regionId);
        foreach($regionId1 as $regionIds)
        {
            $regionSql .= " pec.RegionId  = '".$regionIds."' or ";
    }
        $regionSql = trim($regionSql,' or ');
        if($regionSql !=''){
            $whereregion=  ' ( '.$regionSql.' ) ';
            //$whereregion = " pec.RegionId  =" . $regionId;
        }
    }


    if ($industry != '' && $industry != '--') {
        $inSql = '';
        $industry1 = explode(',',$industry);
        foreach($industry1 as $industrys)
        {
            $inSql .= " pec.industry= '".$industrys."' or ";
    }
        $inSql = trim($inSql,' or ');
        if($inSql !=''){
            $whereind=  ' ( '.$inSql.' ) ';
            //$whereRound="pe.round LIKE '".$round."'";
        }
    }
    // Round
    if ($round != "--" && $round != "") {
        $roundSql = '';
        $round1 = explode(',',$round);
        foreach($round1 as $rounds)
        {
            $roundSql .= " pe.round LIKE '".$rounds."' or  pe.round LIKE '".$rounds."%' or ";
    }
        if($roundSql !=''){
            $whereRound=  '('.trim($roundSql,' or ').')';
            //$whereRound="pe.round LIKE '".$round."'";
        }
    }
    //
    if ($city != "") {
        $whereCity = "pec.city LIKE '" . $city . "%'";
    }

    if ($companyType != "--" && $companyType != "") {
        $wherelisting_status = " pe.listing_status='" . $companyType . "'";
    }
    if ($debt_equity != "--" && $debt_equity != "") {
        $whereSPVdebt = " pe.SPV=" . $debt_equity;
    }
    if($syndication!="--" && $syndication!="" ){
                                                    
        if($syndication==0){
            $wheresyndication=" Having Investorcount > 1";
        }
        else{
            $wheresyndication=" Having Investorcount <= 1";
        }


    }
    if ($invType != "--" && $invType != "") {
        $whereInvType = " pe.InvestorType = '" . $invType . "'";
    }
    //if ($stage!= "--")
    //	{
    //		$wherestage = " pe.StageId =" .$stage ;
    //	}
    $whererange = "";
    $wheredates = "";//echo $startRangeValue;
    if (($startRangeValue != "--") && ($startRangeValue != "") && ($endRangeValue != "")) {
        $startRangeValue = $startRangeValue;
        $endRangeValue = $endRangeValue - 0.01;
        if ($startRangeValue < $endRangeValue) {
            $whererange = " pe.amount between  " . $startRangeValue . " and " . $endRangeValue;
        } elseif ($startRangeValue = $endRangeValue) {
            $whererange = " pe.amount >= " . $startRangeValue;
        }
    }

    if ($datevalue != "---to---") {
        $wheredates = " dates between '" . $hidedateStartValue . "' and '" . $hidedateEndValue . "'";
    }
    if ($exitstatusValue != '' && $exitstatusValue != '--') {
        $exitstatusSql = '';
        $exitstatusValue1 = explode(',',$exitstatusValue);
        foreach($exitstatusValue1 as $exitstatusValues)
        {
            $exitstatusSql .= " Exit_Status = '$exitstatusValues' or ";
        }
        $exitstatusSql = trim($exitstatusSql,' or ');
        if($exitstatusSql !=''){
            $whereexitstatus=  '('.$exitstatusSql.')';
            //$whereexitstatus = " Exit_Status = $exitstatusValue";
        }

        
    }
    if ($whereind != "") {
        $companysql = $companysql . $whereind . " and ";
    }
    if (($wherestage != "")) {
        $companysql = $companysql . $wherestage . " and ";
    }
    // moorthi
    if ($whereRound != "") {
        $companysql = $companysql . $whereRound . " and ";
    }

    if ($whereCity != "") {
        $companysql = $companysql . $whereCity . " and ";
    }
    //
    if ($wherelisting_status != "") {
        $companysql = $companysql . $wherelisting_status . " and ";
    }
    if ($whereSPVdebt != "") {
        $companysql = $companysql . $whereSPVdebt . " and ";
    }
    if (($whereInvType != "")) {
        $companysql = $companysql . $whereInvType . " and ";
    }
    if (($whereregion != "")) {

        $companysql = $companysql . $whereregion . " and ";
        $aggsql = $aggsql . $whereregion . " and ";

        $bool = true;
    }
    if (($whererange != "")) {
        $companysql = $companysql . $whererange . " and ";
    }
    if (($wheredates !== "")) {
        $companysql = $companysql . $wheredates . " and ";
    }

    if ($whereexitstatus != "") {

        $companysql = $companysql . $whereexitstatus . " and ";
    }
    //the foll if was previously checked for range
    if ($whererange != "") {
        $companysql = $companysql . " i.industryid=pec.industry and
                                    pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid and
                                    it.InvestorType=pe.InvestorType and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) )  and
                                    pe.Deleted=0 " . $addVCFlagqry . " " . $addDelind . " 
                                    AND pe.PEId NOT
                                    IN (
                                    SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId =  '$dbTypeSV'
                                    AND hide_pevc_flag =1
                                    ) $comp_industry_id_where GROUP BY pe.PEId";
    } elseif ($whererange = "--") {
        $companysql = $companysql . "  i.industryid=pec.industry and
                                        pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid and
                                         it.InvestorType=pe.InvestorType and (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) )  and
                                        pe.Deleted=0 " . $addVCFlagqry . " " . $addDelind . "
                                        AND pe.PEId NOT
                                        IN (
                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId =  '$dbTypeSV'
                                        AND hide_pevc_flag =1
                                        ) $comp_industry_id_where GROUP BY pe.PEId";
        //   echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
    }
    if($wheresyndication!=''){
                                        
        $companysql = $companysql .$wheresyndication;
    }
                                        
    $companysql = $companysql ."  order by companyname";

   //  echo "<Br>--where caluse-".$companysql;die;
} else {
    echo "<br> INVALID DATES GIVEN ";
    $fetchRecords = false;
}

//mail sending
//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
//		{
$checkUserSql = "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
													dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
													dm.EmailId='$submitemail' AND dc.Deleted =0";

if ($totalrs = mysql_query($checkUserSql)) {

    $cnt = mysql_num_rows($totalrs);
    //echo "<Br>mail count------------------" .$hidesearchon;
    if ($cnt == 1) {

        While ($myrow = mysql_fetch_array($totalrs, MYSQL_BOTH)) {
            if (date('Y-m-d') <= $myrow["ExpiryDate"]) {

                $OpenTableTag = "<table border=1 cellpadding=1 cellspacing=0 ><td>";
                $CloseTableTag = "</table>";


                $headers = "MIME-Version: 1.0\n";
                $headers .= "Content-type: text/html;
								charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";

                /* additional headers
                  $headers .= "Cc: sow_ram@yahoo.com\r\n"; //////////////////////////////////////////////////////////////////////////

                $RegDate = date("M-d-Y");
                $to = "arun.natarajan@gmail.com,arun@ventureintelligence.in";
                //$to .="sowmyakvn@gmail.com";
                if ($searchtitle == 0) {
                    $searchdisplay = "PE Deals";
                } elseif ($searchtitle == 1) {
                    $searchdisplay = "VC Deals";
                } elseif ($searchtitle == 2) {
                    $searchdisplay = "Real Estate";
                } else
                    $searchdisplay = "";
                if ($hidesearchon == 1) {
                    $subject = "Send Excel Data: Investments - $searchdisplay";
                    $message = "<html><center><b><u> Send Investment : $searchdisplay - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
									<tr><td width=1%>Stage</td><td width=99%>$hidestagetext</td></tr>
									<tr><td width=1%>Region</td><td width=99%>$regionValue</td></tr>
                                                                       <tr><td width=1%>Company Type</td><td width=99%>$companyType</td></tr>
									<tr><td width=1%>Investment Type</td><td width=99%>$invtypevalue</td></tr>
									<tr><td width=1%>Range</td><td width=99%>$rangeText</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company/Sector</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>

									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
                } elseif ($hidesearchon == 2) {
                    $subject = "Send Excel Data: IPO - $searchdisplay";
                    $message = "<html><center><b><u> Send IPO Data: $searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustry</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>

									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
                } elseif ($hidesearchon == 3) {
                    $subject = "Send Excel Data : M&A - $searchdisplay ";
                    $message = "<html><center><b><u> Send M&A Data :$searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustry</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtype</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>
									<tr><td width=1%>Acquirer</td><td width=99%>$acquirersearch</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
                } elseif ($hidesearchon == 4) {
                    $searchdisplay = "";
                    $subject = "Send Excel Data : Mergers & Acquistion - $searchdisplay ";
                    $message = "<html><center><b><u> Send Mergers & Acquistion Data :$searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustry</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtype</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
									<tr><td width=1%>Target Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>
									<tr><td width=1%>Acquirer</td><td width=99%>$acquirersearch</td></tr>
									<tr><td width=1%>Target Country</td><td width=99%>$targetCountry</td></tr>
									<tr><td width=1%>Acquirer Country</td><td width=99%>$acquirerCountry</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
                }
                mail($to, $subject, $message, $headers);
                //header( 'Location: http://www.ventureintelligence.in/deals/cthankyou.php' ) ;
            } elseif ($myrow["ExpiryDate"] >= date('y-m-d')) {
                $displayMessage = $TrialExpired;
                $submitemail = "";
                $submitpassword = "";
            }
        }
    } elseif ($cnt == 0) {
        $displayMessage = "Invalid Login / Password";
        $submitemail = "";
        $submitpassword = "";
    }
}
//	}


$sql = $companysql;
//echo "<br>---" .$sql;die;
//exit;
//execute query
$result = @mysql_query($sql) or die("Error in connection:<br>");

updateDownload($result);
//print_r($result); exit();
//if this parameter is included ($w=1), file returned will be in word format ('.doc')
//if parameter is not included, file returned will be in excel format ('.xls')
if (isset($w) && ($w == 1)) {
    $file_type = "msword";
    $file_ending = "doc";
} else {
    $file_type = "vnd.ms-excel";
    $file_ending = "xls";
}
//header info for browser: determines file type ('.doc' or '.xls')
header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=peinv_deals.$file_ending");
header("Pragma: no-cache");
header("Expires: 0");

/*    Start of Formatting for Word or Excel    */



/*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   //////////////////////////////////////////////////////////////////////////

//create title with timestamp:
if ($Use_Title == 1) {
    echo("$title\n");
}

echo ("$tsjtitle");
print("\n");
print("\n");
echo ("$tranchedisplay");
print("\n");
print("\n");
echo ("$exportstatusdisplay");
print("\n");
print("\n");


//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
//-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
echo "Company" . "\t";
echo "Company Type" . "\t";
echo "Industry" . "\t";
echo "Sector" . "\t";
echo "Amount(US\$M)" . "\t";
echo "Amount(INR Cr)" . "\t";
echo "Round" . "\t";
echo "Stage" . "\t";
echo "Investors" . "\t";
echo "Investor Type" . "\t";
echo "Stake (%)" . "\t";
echo "Date" . "\t";
echo "Exit Status" . "\t";
echo "Website" . "\t";
echo "City" . "\t";
echo "Region" . "\t";
echo "Advisor-Company" . "\t";
echo "Advisor-Investors" . "\t";
echo "More Details" . "\t";
echo "Link" . "\t";

/*echo "Company Valuation-Equity - Post Money (INR Cr)" . "\t";
echo "Revenue Multiple(based on Equity Value/Market Cap)" . "\t";
echo "EBITDA Multiple(based on Equity Value)" . "\t";
echo "PAT Multiple(based on Equity Value)" . "\t";

echo "Company Valuation-Equity - EV Money (INR Cr)" . "\t";
echo "Revenue Multiple(based on Equity Value/Market Cap)" . "\t";
echo "EBITDA Multiple(based on Equity Value)" . "\t";
echo "PAT Multiple(based on Equity Value)" . "\t";

echo "Company Valuation-Equity - Pre Money (INR Cr)" . "\t";
echo "Revenue Multiple(based on Equity Value/Market Cap)" . "\t";
echo "EBITDA Multiple(based on Equity Value)" . "\t";
echo "PAT Multiple(based on Equity Value)" . "\t";////////////////////////////////////////////////////////////////////////////

echo "Pre Money" . "\t";
echo "Revenue Multiple" . "\t";
echo "EBITDA Multiple" . "\t";
echo "PAT Multiple" . "\t";

echo "Post Money" . "\t";
echo "Revenue Multiple" . "\t";
echo "EBITDA Multiple" . "\t";
echo "PAT Multiple" . "\t";

echo "EV (Enterprise Valuation)" . "\t";
echo "Revenue Multiple" . "\t";
echo "EBITDA Multiple" . "\t";
echo "PAT Multiple" . "\t";

	// New Feature 08-08-2016 start
	
		echo "Price to Book"."\t";
	
	//New Feature 08-08-2016 end


echo "Valuation" . "\t";
echo "Revenue (INR Cr)" . "\t";
echo "EBITDA (INR Cr)" . "\t";
echo "PAT (INR Cr)" . "\t";
echo "Total Debt (INR Cr)" . "\t";
echo "Cash & Cash Equ. (INR Cr)" . "\t";
echo "Book Value Per Share"."\t";
echo "Price Per Share"."\t";
echo "Link for Financials" . "\t";


print("\n");

print("\n");
//end of printing column names
//start while loop to get data
/*
  note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
//////////////////////////////////////////////////////////////////////////////////

$searchString = "Undisclosed";
$searchString = strtolower($searchString);
$searchStringDisplay = "Undisclosed";

$searchString1 = "Unknown";
$searchString1 = strtolower($searchString1);

$searchString2 = "Others";
$searchString2 = strtolower($searchString2);



$replace_array = array('\t','\n','<br>','<br/>','<br />','\r','\v');
while ($row = mysql_fetch_row($result)) {
    /*echo '<pre>'; print_r( $row ); echo '</pre>';
    exit;////////////////////////////////////////////////////////////////////////////////////////////////////////
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
    //set_time_limit(60); // HaRa
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
        $schema_insert .= $openDebtBracket . $openBracket . $row[7] . $closeBracket . $closeDebtBracket . $sep;
        $webdisplay = $row[16];
    } else {
        $schema_insert .= $searchStringDisplay . $sep;
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

    $schema_insert.=$listing_status_display . $sep; //listingstatus
    $schema_insert .= $row[8] . $sep;   //industry
    $schema_insert .= $row[9] . $sep;
   /* if ($row[20] == 1)
        $hideamount = "";
    else
        $hideamount = $row[10];
    $schema_insert .= $hideamount . $sep;////////////////////////////////////////////////////////////////////////////////////////////
    $hideamount_INR="";
    if($row[20]==1){
            $hideamount="";
    }else{
            $hideamount=$row[10];
            if($row[42] != 0.00){
                $hideamount_INR=$row[42];
            }
    }
    $schema_insert .= $hideamount.$sep; //amount
    $schema_insert .= $hideamount_INR.$sep; //amount INR
                                                
    $schema_insert .= $row[11] . $sep;
    $schema_insert .= $row[12] . $sep;

    if($keyword!=''){

    $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
		peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY inv.InvestorId IN($keyword) desc,Investor='Others' asc";//ORDER BY inv.InvestorId IN ($keyword) desc ";
    
    }
    else{
        $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
		peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='Others' asc";//ORDER BY inv.InvestorId IN ($keyword) desc ";
   
    }
    //echo "<Br>Investor".$investorSql;
    $advcompanysql = "select advcomp.PEId,advcomp.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$PEId and advcomp.CIAId=cia.CIAId";
    //echo "<Br>".$advcompanysql;

    $advinvestorssql = "select advinv.PEId,advinv.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorinvestors as advinv,
	advisor_cias as cia where advinv.PEId=$PEId and advinv.CIAId=cia.CIAId";

    if ($investorrs = mysql_query($investorSql)) {

        $investorString = "";
        $AddOtherAtLast = "";
        $AddUnknowUndisclosedAtLast = "";
        /*while ($rowInvestor = mysql_fetch_array($investorrs))
        {
            $Investorname = $rowInvestor[2];
            $Investorname = strtolower($Investorname);

            $invResult = substr_count($Investorname, $searchString);
            $invResult1 = substr_count($Investorname, $searchString1);
            $invResult2 = substr_count($Investorname, $searchString2);

            if (($invResult == 0) && ($invResult1 == 0) && ($invResult2 == 0))
                $investorString = $investorString . ", " . $rowInvestor[2];
            elseif (($invResult == 1) || ($invResult1 == 1))
                $AddUnknowUndisclosedAtLast = $rowInvestor[2];
            elseif ($invResult2 == 1)
                $AddOtherAtLast = $rowInvestor[2];
        }////////////////////////////////////////////////////////////////////////////////////////////////////////
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
                    //$invResult2 = substr_count($Investorname, $searchString2);

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

            $investorString = substr_replace($investorString, '', 0, 1);
            $peidcheck = $PEId;
            $invcount=1;
        }

    }
    $schema_insert .= $investorString . $sep;


    $schema_insert .= $row[13] . $sep;
    if ($row[21] == 1 || ($row[14] <= 0))
        $hidestake = "";
    else
        $hidestake = $row[14];

    $schema_insert .= $hidestake . $sep;
    $schema_insert .= $row[15] . $sep;


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
    $schema_insert .= $exitstatusis . $sep;

    $schema_insert .= $webdisplay . $sep;

    $schema_insert .= $row[17] . $sep;
    $schema_insert .= $row[18] . $sep;

    if ($advisorcompanyrs = mysql_query($advcompanysql)) {
        $advisorCompanyString = "";
        while ($row1 = mysql_fetch_array($advisorcompanyrs)) {
            $advisorCompanyString = $advisorCompanyString . "," . $row1[2] . "(" . $row1[3] . ")";
        }
        $advisorCompanyString = substr_replace($advisorCompanyString, '', 0, 1);
    }
    $schema_insert .= $advisorCompanyString . $sep;


    if ($advisorinvestorrs = mysql_query($advinvestorssql)) {
        $advisorInvestorString = "";
        while ($row2 = mysql_fetch_array($advisorinvestorrs)) {
            $advisorInvestorString = $advisorInvestorString . "," . $row2[2] . "(" . $row2[3] . ")";
        }
        $advisorInvestorString = substr_replace($advisorInvestorString, '', 0, 1);
    }
    $schema_insert .= $advisorInvestorString . $sep;
   // $schema_insert .= $row[19] . $sep;      //moreinfor
    $resmoreinfo = preg_replace("/\r\n|\r|\n/",'<br/>',$row[19]);
    $resmoreinfo =  str_replace($replace_array, ' ', $resmoreinfo);
    $resmoreinfo = trim($resmoreinfo);//BusinessDesc
 $resmoreinfo = preg_replace('/(\v|\s)+/', ' ', $resmoreinfo);//more details
$schema_insert .=  $resmoreinfo.$sep; 
    $schema_insert .=  trim($row[24]). $sep;  //link

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

    $schema_insert .= $pre_company_valuation . $sep;  //company valuation PRE
    $schema_insert .= $pre_revenue_multiple . $sep;  //Revenue Multiple
    $schema_insert .= $pre_ebitda_multiple . $sep;  //EBITDA Multiple
    $schema_insert .= $pre_pat_multiple . $sep;  //PAT Multiple


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

    //New Feature 08-08-2016 start
                                 
      $price_to_book=$row[39]; 
      if($price_to_book<=0)
         $price_to_book="";
      
         
      $book_value_per_share=$row[40]; 
      if($book_value_per_share<=0)
        $book_value_per_share="";
      
      
     $price_per_share=$row[41]; 
      if($price_per_share<=0)
         $price_per_share="";
         
    //New Feature 08-08-2016 end

    $schema_insert .= $dec_company_valuation . $sep;  //company valuation post
    $schema_insert .= $dec_revenue_multiple . $sep;  //Revenue Multiple
    $schema_insert .= $dec_ebitda_multiple . $sep;  //EBITDA Multiple
    $schema_insert .= $dec_pat_multiple . $sep;  //PAT Multiple

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


    $schema_insert .= $ev_company_valuation . $sep;  //company valuation EV
    $schema_insert .= $ev_revenue_multiple . $sep;  //Revenue Multiple
    $schema_insert .= $ev_ebitda_multiple . $sep;  //EBITDA Multiple
    $schema_insert .= $ev_pat_multiple . $sep;  //PAT Multiple


	 $schema_insert .= $price_to_book.$sep;  //price_to_book

    $schema_insert .= trim($row[26]). $sep; //Valuation
    
    $dec_revenue=$row[36];
    if($dec_revenue < 0 || $dec_revenue > 0){
        $schema_insert .= $dec_revenue.$sep;  //Revenue 
    }else{
        if ($dec_company_valuation > 0 && $dec_revenue_multiple > 0) {

            $schema_insert .= number_format($dec_company_valuation / $dec_revenue_multiple, 2, '.', '') . $sep;
        } else {
            $schema_insert .= '' . $sep;
        }
    }


    $dec_ebitda = $row[37];
    if ($dec_ebitda < 0 || $dec_ebitda > 0) {
        $schema_insert .= $dec_ebitda . $sep;  //EBITDA 
    }else{
        if ($dec_company_valuation > 0 && $dec_ebitda_multiple > 0) {

            $schema_insert .= number_format($dec_company_valuation / $dec_ebitda_multiple, 2, '.', '') . $sep;
        } else {
            $schema_insert .= '' . $sep;
        }
    }

    $dec_pat = $row[38];
    if ($dec_pat < 0 || $dec_pat > 0) {
        $schema_insert .= $dec_pat . $sep;  //PAT 
    }else{
        if ($dec_company_valuation > 0 && $dec_pat_multiple > 0) {

            $schema_insert .= number_format($dec_company_valuation / $dec_pat_multiple, 2, '.', '') . $sep;
        } else {
            $schema_insert .= '' . $sep;
        }
    }

    $schema_insert .= $Total_Debt . $sep;  //Total Debt
    $schema_insert .= $Cash_Equ . $sep;  //Cash & Cash Equ.

	 $schema_insert .= $book_value_per_share.$sep;  //book_value_per_share
	 $schema_insert .= $price_per_share.$sep;  //price_per_share
         //
//    $schema_insert .= $row[36] . $sep; //Revenue
//    $schema_insert .= $row[37] . $sep; //ebitda
//    $schema_insert .= $row[38] . $sep; //PAT
    $schema_insert .= $row[27] . $sep;  //link for financial
    // $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert .= "" . "\n";
    //following fix suggested by Josue (thanks, Josue!)
    //this corrects output in excel when table fields contain \n or \r
    //these two characters are now replaced with a space
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}

//		}
//else
//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;
mysql_close();
    mysql_close($cnx);*/
?>
<?php
//session_save_path("/tmp");
session_start();
require("../dbconnectvi.php");
$Db = new dbInvestments();

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

$tsjtitle = "© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
$tranchedisplay = "Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE. Target Company in [] indicated a debt investment. Not included in aggregate data.";
/*$exportstatusdisplay = "Pls Note : Excel Export is available for transactions from Jan.2004 only, as part of search results. You can export transactions prior  to 2004 on a deal by deal basis from the deal details popup.";*/

//$sql = $_POST['sql'];
if( !empty( $_POST[ 'split_sql1' ] ) ) {
    
    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){
        $sql = $_POST[ 'split_sql' ] . ' AND pe.PEId  IN ('.$_POST[ 'export_checkbox_enable' ].') ' . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . ' AND pe.PEId  IN ('.$_POST[ 'export_checkbox_enable' ].') ' . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];    
    }else{
        //$sql = $_POST[ 'split_sql' ] . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . ' AND pe.PEId IN ('.$_POST[ 'export_checkbox_enable' ].') ' . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];    
        $sql = $_POST[ 'split_sql' ] . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];
    }
    
    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){
        $sql = $_POST[ 'split_sql' ] . ' AND pe.PEId NOT IN ('.$_POST[ 'txthidepe' ].') ' . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . ' AND pe.PEId NOT IN ('.$_POST[ 'txthidepe' ].') ' . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];    
    }else{
        $sql = $_POST[ 'split_sql' ] . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . ' AND pe.PEId NOT IN ('.$_POST[ 'txthidepe' ].') ' . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];    
    }
    
    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){
        $sql = $_POST[ 'split_sql' ] . ' AND pe.PEId NOT IN ('.$_POST[ 'txthidepe' ].') ' . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . ' AND pe.PEId NOT IN ('.$_POST[ 'txthidepe' ].') ' . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];    
    }else{
        $sql = $_POST[ 'split_sql' ] . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . ' AND pe.PEId NOT IN ('.$_POST[ 'txthidepe' ].') ' . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];    
    }
    
    if(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){
        $sql = $_POST[ 'split_sql' ] . ' AND pe.PEId  IN ('.$_POST[ 'export_checkbox_enable' ].') ' . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . ' AND pe.PEId IN ('.$_POST[ 'export_checkbox_enable' ].') ' . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];    
    }else{
        //$sql = $_POST[ 'split_sql' ] . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . ' AND pe.PEId  IN ('.$_POST[ 'export_checkbox_enable' ].') ' . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];    
        $sql = $_POST[ 'split_sql' ] . $_POST[ 'split_group' ] . $_POST[ 'split_sql1' ] . $_POST[ 'split_group1' ] . $_POST[ 'split_orderby' ];
    }
    
}else {
    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){
        
        $sql = $_POST[ 'split_sql' ] . ' AND pe.PEId IN ('.$_POST[ 'export_checkbox_enable' ].') ' . $_POST[ 'split_group' ] . $_POST[ 'split_orderby' ];
        
    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){
        
        $sql = $_POST[ 'split_sql' ] . ' AND pe.PEId NOT IN ('.$_POST[ 'txthidepe' ].') ' . $_POST[ 'split_group' ] . $_POST[ 'split_orderby' ];
        
    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){
        $sql = $_POST[ 'split_sql' ] . ' AND pe.PEId NOT IN ('.$_POST[ 'txthidepe' ].') ' . $_POST[ 'split_group' ] . $_POST[ 'split_orderby' ];
    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){
        $sql = $_POST[ 'split_sql' ] . ' AND pe.PEId IN ('.$_POST[ 'export_checkbox_enable' ].') ' . $_POST[ 'split_group' ] . $_POST[ 'split_orderby' ];
    }else{
        $sql = $_POST[ 'split_sql' ] . '' . $_POST[ 'split_group' ] . $_POST[ 'split_orderby' ];
    }
    
    
    
}

$keyword = $_POST['investorvalue'];
$companytype = $_POST['companytype'];
$month1=$_POST['month1'];
$month2=$_POST['month2'];
$year1=$_POST['year1'];
$year2=$_POST['year2'];
$startDate=$year1.'-'.$month1.'-01';
$endYear=$year2.'-'.$month2.'-31';
$industry=$_POST['industry'];
$city=$_POST['city'];
$state=$_POST['state'];
$region=$_POST['region'];
$exitStatus=$_POST['exitStatus'];
$round=$_POST['round'];
$stage=$_POST['stage'];
$investorType=$_POST['investorType'];
//echo json_encode(explode(",",$industry));exit();

//echo $companytype;exit();
if($companytype != '')
{
$companyTypeStatus="and pe.listing_status='".$companytype."'";
}
//echo $companyTypeStatus;exit();
if($industry != '')
{
   $industryType="and pec.industry IN (".$industry.")";
}
if($city != '')
{
    $query="select * from city where city_id IN (".$city.")";
    $sqlSelResult = mysql_query($query) or die(mysql_error());

    while ($row = mysql_fetch_assoc($sqlSelResult)) {
    $geti .= $row['city_name'] ."," ;;
    }
    $investorvalArray = explode (",", $geti);

    $cityType='and pec.city IN ("'. implode('","', $investorvalArray) .'")';
}
if($state)
{
    $stateId="and pec.stateid IN (".$state.")";

}
if($region != '')
{
    $RegionId="and pec.RegionId IN (".$region.")";
}
if($exitStatus != '')
{
    $Exit_Status="and Exit_Status IN (".$exitStatus.")";
}
if($round != '')
{
    $roundtype=explode(",",$round);
    if (count($roundtype) > 0) {
     $roundSql = '';
        foreach ($roundtype as $rounds) {
            $roundSql .= " pe.round LIKE '" . $rounds . "' or  pe.round LIKE '" . $rounds . "%' or pe.round LIKE '%" . $rounds . "%' or";
        }
        if ($roundSql != '') {
            $roundtype = 'and (' . trim($roundSql, ' or ') . ')';
        }
    }
}
if($stage != '')
{
$StageId="and pe.StageId IN (".$stage.")";
}
if($investorType != '')
{
$InvestorType="and pe.InvestorType='".$investorType."'";
}
//echo $_POST['exitStatus'];exit();
if($_POST['invquery'] != "")
{
    $sql= $_POST['invquery'];
}
else{
$sql="SELECT pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod, pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor, (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId JOIN industry AS i ON pec.industry = i.industryid JOIN stage AS s ON s.StageId=pe.StageId WHERE peinv_inv.InvestorId IN(".$keyword.")  and dates between '".$startDate."' and '".$endYear."' ".$companyTypeStatus." ".$industryType." ".$cityType." ".$stateId." ".$RegionId." ".$Exit_Status." ".$roundtype." ".$StageId." ".$InvestorType." and pe.Deleted=0 AND pe.SPV=0 and pe.AggHide=0 and pec.industry !=15 AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by dates desc,companyname asc";
}
//echo $sql;exit();
//execute query
$result = mysql_query($sql) or die(mysql_error());

// Start T960
$exportvalue=$_POST['resultarray'];
if($exportvalue == "Select-All"){
   // $exportvalue = "Company,Company Type,Industry,Sector,Amount(US".'$M'."),Amount(INR Cr),Round,Stage,Investors,Investor Type,Stake (%),Date,Exit Status,Website,Year Founded,City,State,Region,Advisor-Company,Advisor-Investors,More Details,Link,Pre Money Valuation (INR Cr),Revenue Multiple (Pre),EBITDA Multiple (Pre),PAT Multiple (Pre),Post Money Valuation (INR Cr),Revenue Multiple (Post),EBITDA Multiple (Post),PAT Multiple (Post),Enterprise Valuation (INR Cr),Revenue Multiple (EV),EBITDA Multiple (EV),PAT Multiple (EV),Price to Book,Valuation,Revenue (INR Cr),EBITDA (INR Cr),PAT (INR Cr),Total Debt (INR Cr),Cash & Cash Equ. (INR Cr),Book Value Per Share,Price Per Share,Link for Financials";    
   $exportvalue = "Company,Company Type,Industry,City,State,Region,Exit Status,Round,Stage,Investor Type,Stake (%),Investors,Date,Website,Year Founded,Sector,Amount(US".'$M'."),Amount(INR Cr),Advisor-Company,Advisor-Investors,More Details,Link,Pre Money Valuation (INR Cr),Revenue Multiple (Pre),EBITDA Multiple (Pre),PAT Multiple (Pre),Post Money Valuation (INR Cr),Revenue Multiple (Post),EBITDA Multiple (Post),PAT Multiple (Post),Enterprise Valuation (INR Cr),Revenue Multiple (EV),EBITDA Multiple (EV),PAT Multiple (EV),Price to Book,Valuation,Revenue (INR Cr),EBITDA (INR Cr),PAT (INR Cr),Total Debt (INR Cr),Cash & Cash Equ. (INR Cr),Book Value Per Share,Price Per Share,Link for Financials";    

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
    
    $companiessql = "select pe.PEId,pe.PEId, pe.PEId, pe.PECompanyID, pe.StageId, pec.countryid, pec.industry, pec.companyname, i.industry,pec.sector_business,amount,round,s.stage, it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%b-%y') as dealperiod, pec.website,pec.city,r.Region, MoreInfor,hideamount,hidestake,c.country,c.country, Link,pec.RegionId,Valuation,FinLink, Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple, listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded,pec.state from peinvestments as pe
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
        if(in_array("Exit Status", $rowArray))
        {
            $DataList[] = $exitstatusis;
        }
       if(in_array("Round", $rowArray))
        {
            $DataList[] = $row[11];
        }
        if(in_array("Stage", $rowArray))
        {
            $DataList[] = $row[12];
        }
       if(in_array("Investor Type", $rowArray))
        {
            $DataList[] = $row[13];
        }
     if(in_array("Stake (%)", $rowArray))
        {
            $DataList[] = $hidestake;
        }
     if(in_array("Investors", $rowArray))
        {
            $DataList[] = $investorString;
        }
        if(in_array("Date", $rowArray))
        {
            $DataList[] = $row[15];
        }
    
        if(in_array("Website", $rowArray))
        {
            $DataList[] = $webdisplay;
        }
        if(in_array("Year Founded", $rowArray))
        {
            $DataList[] = $yearfounded;
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

//		}
//else
//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;
mysql_close();
mysql_close($cnx);
?>


	