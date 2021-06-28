<?php include_once ("../globalconfig.php"); ?>
<?php
ini_set('memory_limit', '2048M');
ini_set("max_execution_time", 10000);

?>
<?php

//session_save_path("/tmp");
//session_start();
require ("../dbconnectvi.php");
$Db = new dbInvestments();

function updateDownload($res)
{
    //Added By JFR-KUTUNG - Download Limit
    $recCount = mysql_num_rows($res);
    $dlogUserEmail = $_SESSION['UserEmail'];
    $today = date('Y-m-d');

    $username = $_SESSION['UserNames'];
    $filtername = $_POST['exportfilter_name'];
    $filterType = $_POST['exportfilter_type'];
    $companyName = $_POST['exportcompany_name'];
    if ($filtername == '')
    {
        $filtername = 'anonymous';
    }
    //Check Existing Entry
    $sqlSelCount = "SELECT sum(`current_downloaded`) as `recDownloaded` FROM `advance_export_filter_log` WHERE `emailId` = '" . $dlogUserEmail . "'  AND ( `downloadDate` = CURRENT_DATE )";
    $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
    $rowSelCount = mysql_num_rows($sqlSelResult);
    $rowSel = mysql_fetch_object($sqlSelResult);
    $downloads = $rowSel->recDownloaded;

    $upDownloads = $recCount + $downloads;
 
    $sqlIns = "INSERT INTO `advance_export_filter_log` (`id`, `name`, `filter_name`, `filter_type`,`company_name`,`emailId`,`downloadDate`,`recDownloaded`,`current_downloaded`) VALUES (default,'" . $username . "','" . $filtername . "','" . $filterType . "','" . $companyName . "','" . $dlogUserEmail . "','" . $today . "','" . $upDownloads . "','" . $recCount . "')";
    //echo $sqlIns;exit();
    mysql_query($sqlIns) or die(mysql_error());
}

$tsjtitle = "© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
$tranchedisplay = "Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE. Target Company in [] indicated a debt investment. Not included in aggregate data.";

$keyword = $_POST['investorvalue'];
$companytype = $_POST['companytype'];
$month1 = $_POST['month1'];
$month2 = $_POST['month2'];
$year1 = $_POST['year1'];
$year2 = $_POST['year2'];
$startDate = $year1 . '-' . $month1 . '-01';
$endYear = $year2 . '-' . $month2 . '-31';
$industry = $_POST['industry'];
$city = $_POST['city'];
$state = $_POST['state'];
$region = $_POST['region'];
$exitStatus = $_POST['exitStatus'];
$round = $_POST['round'];
$stage = $_POST['stage'];
$investorType = $_POST['investorType'];

if ($companytype != '' && $companytype != '--')
{
    $companytype = str_replace(",", "','", $companytype);
    $companytype = "'" . $companytype . "'";
    $companyTypeStatus = "and pe.listing_status IN (" . $companytype . ")";
}
else
{
    $companyTypeStatus = "";

}

if ($industry != '')
{
    $industryType = "and pec.industry IN (" . $industry . ")";
}
else
{
    $industryType = "";
  
}
if ($city != '')
{
    $query = "select * from city where city_id IN (" . $city . ")";
    $sqlSelResult = mysql_query($query) or die(mysql_error());

    while ($row = mysql_fetch_assoc($sqlSelResult))
    {
        $geti .= $row['city_name'] . ",";;
    }
    $investorvalArray = explode(",", $geti);

    $cityType = 'and pec.city IN ("' . implode('","', $investorvalArray) . '")';
}
else{
    $cityType = '';

}
if ($state)
{
    $stateId = "and pec.stateid IN (" . $state . ")";

}
else
{
    $stateId = "";

}
if ($region != '')
{
    $RegionId = "and pec.RegionId IN (" . $region . ")";
}
else{
    $RegionId = "";

}
if ($exitStatus != '')
{
    $Exit_Status = "and Exit_Status IN (" . $exitStatus . ")";
}
else{
    $Exit_Status = "";

}
if ($round != '')
{
    $roundtype = explode(",", $round);
    if (count($roundtype) > 0)
    {
        $roundSql = '';
        foreach ($roundtype as $rounds)
        {
            $roundSql .= " pe.round LIKE '" . $rounds . "' or  pe.round LIKE '" . $rounds . "%' or pe.round LIKE '%" . $rounds . "%' or";
        }
        if ($roundSql != '')
        {
            $roundtype = 'and (' . trim($roundSql, ' or ') . ')';
        }
    }
}
else{
    $roundtype = '';

}
if ($stage != '')
{
    $StageId = "and pe.StageId IN (" . $stage . ")";
}
else{
    $StageId = "";
 
}
if ($investorType != '' && $investorType != '--')
{
    $investorType = str_replace(",", "','", $investorType);
    $investorType = "'" . $investorType . "'";
    $InvestorType = "and pe.InvestorType IN (" . $investorType . ")";
}
else{
    $InvestorType = '';
  
}
if ($_POST['invquery'] != "")
{
    $sql = $_POST['invquery'];
}
elseif ($keyword == "")
{
    // $sql="SELECT pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod, pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor, (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId JOIN industry AS i ON pec.industry = i.industryid JOIN stage AS s ON s.StageId=pe.StageId WHERE  dates between '".$startDate."' and '".$endYear."'  and pe.Deleted=0 AND pe.SPV=0 and pe.AggHide=0 and pec.industry !=15 AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by dates desc,companyname asc";
    $sql = "SELECT Distinct pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod, pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor, (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId JOIN industry AS i ON pec.industry = i.industryid JOIN stage AS s ON s.StageId=pe.StageId WHERE dates between '" . $startDate . "' and '" . $endYear . "' " . $companyTypeStatus . " " . $industryType . " " . $cityType . " " . $stateId . " " . $RegionId . " " . $Exit_Status . " " . $roundtype . " " . $StageId . " " . $InvestorType . " and pe.Deleted=0 AND pe.SPV=0 and pe.AggHide=0 and pec.industry !=15 AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by dates desc,companyname asc";

}
else
{
    $sql = "SELECT Distinct pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod, pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor, (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId JOIN industry AS i ON pec.industry = i.industryid JOIN stage AS s ON s.StageId=pe.StageId WHERE peinv_inv.InvestorId IN(" . $keyword . ")  and dates between '" . $startDate . "' and '" . $endYear . "' " . $companyTypeStatus . " " . $industryType . " " . $cityType . " " . $stateId . " " . $RegionId . " " . $Exit_Status . " " . $roundtype . " " . $StageId . " " . $InvestorType . " and pe.Deleted=0 AND pe.SPV=0 and pe.AggHide=0 and pec.industry !=15 AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by dates desc,companyname asc";
}
//echo $sql;exit();
//execute query
$result = mysql_query($sql) or die(mysql_error());
$rowscount = mysql_num_rows($result);
//echo "There are " . $rowscount . " rows in my table.";exit();
//$_SESSION['rowcount']=$rowscount;
if ($rowscount == 0)
{
    echo $rowscount;
    exit();
}
else
{
    if($_POST['exportcount'] == "")
    {
        $exportvalue = $_POST['resultarray'];
        if ($exportvalue == "Select-All")
        {
            $exportvalue = "Company,CIN,Company Type,Industry,City,State,Region,Exit Status,Round,Stage,Investor Type,Stake (%),Investors,Date,Website,Year Founded,Sector,Amount(US" . '$M' . "),Amount(INR Cr),Advisor-Company,Advisor-Investors,More Details,Link,Pre Money Valuation (INR Cr),Revenue Multiple (Pre),EBITDA Multiple (Pre),PAT Multiple (Pre),Post Money Valuation (INR Cr),Revenue Multiple (Post),EBITDA Multiple (Post),PAT Multiple (Post),Enterprise Valuation (INR Cr),Revenue Multiple (EV),EBITDA Multiple (EV),PAT Multiple (EV),Price to Book,Valuation,Revenue (INR Cr),EBITDA (INR Cr),PAT (INR Cr),Total Debt (INR Cr),Cash & Cash Equ. (INR Cr),Book Value Per Share,Price Per Share";
            //$exportvalue = "Company,Company Type,Industry,City,State,Region,Exit Status,Round,Stage,Investor Type,Stake (%),Investors,Date,Website,Year Founded,Sector,Amount(US".'$M'."),Amount(INR Cr),Advisor-Company,Advisor-Investors,More Details,Link,Pre Money Valuation (INR Cr),Revenue Multiple (Pre),EBITDA Multiple (Pre),PAT Multiple (Pre),Post Money Valuation (INR Cr),Revenue Multiple (Post),EBITDA Multiple (Post),PAT Multiple (Post),Enterprise Valuation (INR Cr),Revenue Multiple (EV),EBITDA Multiple (EV),PAT Multiple (EV),Price to Book,Valuation,Revenue (INR Cr),EBITDA (INR Cr),PAT (INR Cr),Total Debt (INR Cr),Cash & Cash Equ. (INR Cr),Book Value Per Share,Price Per Share,Link for Financials";
            
        }
        $expval = explode(",", $exportvalue);
        //print_r($expval);exit();
        // end T960
        

        updateDownload($result);
        $sheet_count = 0;
        $keywordval=explode(',',$keyword);
   


        $searchString = "Undisclosed";
        $searchString = strtolower($searchString);
        $searchStringDisplay = "Undisclosed";

        $searchString1 = "Unknown";
        $searchString1 = strtolower($searchString1);

        $searchString2 = "Others";
        $searchString2 = strtolower($searchString2);

        $dbTypeSV = 'PE';

        $tsjtitle = "© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
        $tranchedisplay = "Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE. Target Company in [] indicated a debt investment. Not included in aggregate data.";

        $replace_array = array(
            '\t',
            '\n',
            '<br>',
            '<br/>',
            '<br />',
            '\r',
            '\v'
        );
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', true);
        ini_set('display_startup_errors', true);
        date_default_timezone_set('Europe/London');
        if (PHP_SAPI == 'cli') die('This example should only be run from a Web Browser');
        /** Include PHPExcel */
        require_once '../PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()
            ->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

            if($keyword !="")
            {
                foreach( $keywordval as $keywordvalue){
                    $sql = "SELECT Distinct pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod, pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor, (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId JOIN industry AS i ON pec.industry = i.industryid JOIN stage AS s ON s.StageId=pe.StageId WHERE peinv_inv.InvestorId =" . $keywordvalue . "  and dates between '" . $startDate . "' and '" . $endYear . "' " . $companyTypeStatus . " " . $industryType . " " . $cityType . " " . $stateId . " " . $RegionId . " " . $Exit_Status . " " . $roundtype . " " . $StageId . " " . $InvestorType . " and pe.Deleted=0 AND pe.SPV=0 and pe.AggHide=0 and pec.industry !=15 AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by dates desc,companyname asc";
                    //echo $sql;
                    $result = mysql_query($sql) or die(mysql_error());
    
                    $sqlQuery=mysql_query("SELECT investor FROM `peinvestors` where InvestorId=$keywordvalue") or die(mysql_error());
                    
                    
    
                // Add some data
                $rowArray = $expval;
                $objPHPExcel->getActiveSheet()
                    ->fromArray($rowArray, // The data to set
                NULL, // Array values with this value will not be set
                'A1'
                // Top left coordinate of the worksheet range where
                //    we want to set these values (default is A1)
                );
            
            $index = 2;
    
            $peidcheck = '';
    
            $arrayData = array();
            while ($rows = mysql_fetch_array($result))
            {
                $DataList = array();
                $col = 0;
    
                if (isset($rows['PEId']))
                {
                    $PEId = $rows['PEId'];
                }
                else
                {
                    $PEId = $rows[13];
                }
    
                $companiessql = "select Distinct pe.PEId,pe.PEId, pe.PEId, pe.PECompanyID, pe.StageId, pec.countryid, pec.industry, pec.companyname, i.industry,pec.sector_business,amount,round,s.stage, it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%b-%y') as dealperiod, pec.website,pec.city,r.Region, MoreInfor,hideamount,hidestake,c.country,c.country, Link,pec.RegionId,Valuation,FinLink, Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple, listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded,pec.state,pec.CINNo from peinvestments as pe
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
                    where pe.Deleted=0 and pec.industry !=15 and pe.PEId=" . $PEId . " AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = '$dbTypeSV' AND hide_pevc_flag =1 ) order by companyname";
    
                $result2 = mysql_query($companiessql) or die(mysql_error());
                $row = mysql_fetch_row($result2);
    
                if ($row[35] == 1)
                { //Agghide
                    //echo "<br>***".$row[7];
                    $openBracket = "(";
                    $closeBracket = ")";
                    $amtTobeDeductedforAggHide = $row[10];
                }
                else
                {
                    $openBracket = "";
                    $closeBracket = "";
                    $amtTobeDeductedforAggHide = 0;
                }
                if ($row[34] == 1)
                { //Debt
                    $openDebtBracket = "[";
                    $closeDebtBracket = "]";
                    $amtTobeDeductedforDebt = $row[10];
                    $amtTobeDeductedforAggHide = $row[10];
                    $NoofDealsCntTobeDeductedDebt = 1;
                }
                else
                {
                    $openDebtBracket = "";
                    $closeDebtBracket = "";
                    $amtTobeDeductedforDebt = 0;
                    $NoofDealsCntTobeDeductedDebt = 0;
                }
                if ($row[35] == 1 || $row[34] == 1)
                {
                    $NoofDealsCntTobeDeducted = 1;
                }
                else
                {
                    $NoofDealsCntTobeDeducted = 0;
                }
    
                $schema_insert = "";
                $PEId = $row[0];
                $companyName = $row[7];
                $companyName = strtolower($companyName);
                $compResult = substr_count($companyName, $searchString);
    
                if ($row[32] == "L") $listing_status_display = "Listed";
                elseif ($row[32] == "U") $listing_status_display = "Unlisted";
    
                //echo $compResult;
                if ($compResult == 0)
                {
                    //echo "<BR>--- ".$openBracket;
                    $companyName = $openDebtBracket . $openBracket . $row[7] . $closeBracket . $closeDebtBracket;
                    $webdisplay = $row[16];
                }
                else
                {
                    $companyName = $searchStringDisplay;
                    $webdisplay = "";
                }
    
                if (!empty($row[51]))
                {
                    $Total_Debt = $row[51];
                }
                else
                {
                    $Total_Debt = '';
                }
    
                if (!empty($row[52]))
                {
                    $Cash_Equ = $row[52];
                }
                else
                {
                    $Cash_Equ = '';
                }
                if (!empty($row[53]))
                {
                    $yearfounded = $row[53];
                }
                else
                {
                    $yearfounded = '';
                }
                $hideamount_INR = "";
                if ($row[20] == 1)
                {
                    $hideamount = "";
                }
                else
                {
                    $hideamount = $row[10];
                    if ($row[42] != 0.00)
                    {
                        $hideamount_INR = $row[42];
                    }
                }
    
                if ($row[21] == 1 || ($row[14] <= 0)) $hidestake = "";
                else $hidestake = $row[14];
    
                $exitstatusis = '';
                $exitstatusSql = "select id,status from exit_status where id=$row[33]";
                if ($exitstatusrs = mysql_query($exitstatusSql))
                {
                    $exitstatus_cnt = mysql_num_rows($exitstatusrs);
                }
                if ($exitstatus_cnt > 0)
                {
                    while ($myrow = mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                    {
                        $exitstatusis = $myrow[1];
                    }
                }
                else
                {
                    $exitstatusis = 'Unexited';
                }
    
                if ($keyword != '')
                {
                    // $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
                    // peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY inv.InvestorId desc "; //commented in bug 919
                    $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
                peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',inv.InvestorId IN ($keyword) desc ";
    
                }
                else
                {
                    $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
                peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',inv.InvestorId desc ";
                }
    
                $advcompanysql = "select advcomp.PEId,advcomp.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorcompanies as advcomp,
            advisor_cias as cia where advcomp.PEId=$PEId and advcomp.CIAId=cia.CIAId";
    
                $advinvestorssql = "select advinv.PEId,advinv.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorinvestors as advinv,
            advisor_cias as cia where advinv.PEId=$PEId and advinv.CIAId=cia.CIAId";
    
                if ($investorrs = mysql_query($investorSql) or die(mysql_error()))
                {
    
                    $investorString = "";
                    $AddOtherAtLast = "";
                    $AddUnknowUndisclosedAtLast = "";
    
                    $invcount = 1;
                    $firstinv = '';
    
                    if ($peidcheck == $PEId)
                    {
    
                        $whilecount = 0;
                        while ($rowInvestor = mysql_fetch_array($investorrs))
                        {
                            if ($whilecount == $invcount)
                            {
    
                                $firstinv = $rowInvestor[2];
                            }
                            else
                            {
    
                                $Investorname = $rowInvestor[2];
                                $Investorname = strtolower($Investorname);
    
                                $invResult = substr_count($Investorname, $searchString);
                                $invResult1 = substr_count($Investorname, $searchString1);
    
                                if (($invResult == 0) && ($invResult1 == 0)) $investorString = $investorString . ", " . $rowInvestor[2];
                                elseif (($invResult == 1) || ($invResult1 == 1)) $AddUnknowUndisclosedAtLast = $rowInvestor[2];
                                elseif ($invResult2 == 1) $AddOtherAtLast = $rowInvestor[2];
                            }
    
                            $whilecount++;
                        }
    
                        $investorString = $firstinv . $investorString;
                        $invcount++;
                    }
                    else
                    {
    
                        while ($rowInvestor = mysql_fetch_array($investorrs))
                        {
    
                            $Investorname = $rowInvestor[2];
                            $Investorname = strtolower($Investorname);
    
                            $invResult = substr_count($Investorname, $searchString);
                            $invResult1 = substr_count($Investorname, $searchString1);
                            //$invResult2 = substr_count($Investorname, $searchString2);
                            if (($invResult == 0) && ($invResult1 == 0)) $investorString = $investorString . ", " . $rowInvestor[2];
                            elseif (($invResult == 1) || ($invResult1 == 1)) $AddUnknowUndisclosedAtLast = $rowInvestor[2];
                            elseif ($invResult2 == 1) $AddOtherAtLast = $rowInvestor[2];
                        }
                        if ($AddUnknowUndisclosedAtLast !== "") $investorString = $investorString . ", " . $AddUnknowUndisclosedAtLast;
                        if ($AddOtherAtLast != "") $investorString = $investorString . ", " . $AddOtherAtLast;
    
                        $investorString = substr_replace($investorString, '', 0, 2);
                        $peidcheck = $PEId;
                        $invcount = 1;
                    }
    
                }
    
                if ($advisorcompanyrs = mysql_query($advcompanysql))
                {
                    $advisorCompanyString = "";
                    while ($row1 = mysql_fetch_array($advisorcompanyrs))
                    {
                        $advisorCompanyString = $advisorCompanyString . "," . $row1[2] . "(" . $row1[3] . ")";
                    }
                    $advisorCompanyString = substr_replace($advisorCompanyString, '', 0, 1);
                }
    
                if ($advisorinvestorrs = mysql_query($advinvestorssql))
                {
                    $advisorInvestorString = "";
                    while ($row2 = mysql_fetch_array($advisorinvestorrs))
                    {
                        $advisorInvestorString = $advisorInvestorString . "," . $row2[2] . "(" . $row2[3] . ")";
                    }
                    $advisorInvestorString = substr_replace($advisorInvestorString, '', 0, 1);
                }
    
                $resmoreinfo = preg_replace("/\r\n|\r|\n/", '<br/>', $row[19]);
                $resmoreinfo = str_replace($replace_array, ' ', $resmoreinfo);
                $resmoreinfo = trim($resmoreinfo); //BusinessDesc
                $resmoreinfo = preg_replace('/(\v|\s)+/', ' ', $resmoreinfo); //more details
                $pre_company_valuation = $row[43];
                if ($pre_company_valuation <= 0) $pre_company_valuation = "";
    
                $pre_revenue_multiple = $row[44];
                if ($pre_revenue_multiple <= 0) $pre_revenue_multiple = "";
    
                $pre_ebitda_multiple = $row[45];
                if ($pre_ebitda_multiple <= 0) $pre_ebitda_multiple = "";
    
                $pre_pat_multiple = $row[46];
                if ($pre_pat_multiple <= 0) $pre_pat_multiple = "";
    
                $dec_company_valuation = $row[28];
                if ($dec_company_valuation <= 0) $dec_company_valuation = "";
    
                $dec_revenue_multiple = $row[29];
                if ($dec_revenue_multiple <= 0) $dec_revenue_multiple = "";
    
                $dec_ebitda_multiple = $row[30];
                if ($dec_ebitda_multiple <= 0) $dec_ebitda_multiple = "";
    
                $dec_pat_multiple = $row[31];
                if ($dec_pat_multiple <= 0) $dec_pat_multiple = "";
    
                $ev_company_valuation = $row[47];
                if ($ev_company_valuation <= 0) $ev_company_valuation = "";
    
                $ev_revenue_multiple = $row[48];
                if ($ev_revenue_multiple <= 0) $ev_revenue_multiple = "";
    
                $ev_ebitda_multiple = $row[49];
                if ($ev_ebitda_multiple <= 0) $ev_ebitda_multiple = "";
    
                $ev_pat_multiple = $row[50];
                if ($ev_pat_multiple <= 0) $ev_pat_multiple = "";
    
                $price_to_book = $row[39];
                if ($price_to_book <= 0) $price_to_book = "";
    
                $book_value_per_share = $row[40];
                if ($book_value_per_share <= 0) $book_value_per_share = "";
    
                $price_per_share = $row[41];
                if ($price_per_share <= 0) $price_per_share = "";
    
                $dec_revenue = $row[36];
                if ($dec_revenue < 0 || $dec_revenue > 0)
                {
                    $dec_revenue = $dec_revenue; //Revenue
                    
                }
                else
                {
                    if ($dec_company_valuation > 0 && $dec_revenue_multiple > 0)
                    {
    
                        $dec_revenue = number_format($dec_company_valuation / $dec_revenue_multiple, 2, '.', '');
                    }
                    else
                    {
                        $dec_revenue = '';
                    }
                }
    
                $dec_ebitda = $row[37];
                if ($dec_ebitda < 0 || $dec_ebitda > 0)
                {
                    $dec_ebitda = $dec_ebitda; //EBITDA
                    
                }
                else
                {
                    if ($dec_company_valuation > 0 && $dec_ebitda_multiple > 0)
                    {
    
                        $dec_ebitda = number_format($dec_company_valuation / $dec_ebitda_multiple, 2, '.', '');
                    }
                    else
                    {
                        $dec_ebitda = '';
                    }
                }
    
                $dec_pat = $row[38];
                if ($dec_pat < 0 || $dec_pat > 0)
                {
                    $dec_pat = $dec_pat; //PAT
                    
                }
                else
                {
                    if ($dec_company_valuation > 0 && $dec_pat_multiple > 0)
                    {
    
                        $dec_pat = number_format($dec_company_valuation / $dec_pat_multiple, 2, '.', '');
                    }
                    else
                    {
                        $dec_pat = '';
                    }
                }
    
                // T960
                
    
                if (in_array("Company", $rowArray))
                {
                    $DataList[] = $companyName;
                }
                if (in_array("CIN", $rowArray))
                {
                    $DataList[] = $row[55];
                }
                if (in_array("Company Type", $rowArray))
                {
                    $DataList[] = $listing_status_display;
                }
                if (in_array("Industry", $rowArray))
                {
                    $DataList[] = $row[8];
                }
                if (in_array("City", $rowArray))
                {
                    $DataList[] = $row[17];
                }
                if (in_array("State", $rowArray))
                {
                    $DataList[] = $row[54];
                }
                if (in_array("Region", $rowArray))
                {
                    $DataList[] = $row[18];
                }
                if (in_array("Exit Status", $rowArray))
                {
                    $DataList[] = $exitstatusis;
                }
                if (in_array("Round", $rowArray))
                {
                    $DataList[] = $row[11];
                }
                if (in_array("Stage", $rowArray))
                {
                    $DataList[] = $row[12];
                }
                if (in_array("Investor Type", $rowArray))
                {
                    $DataList[] = $row[13];
                }
                if (in_array("Stake (%)", $rowArray))
                {
                    $DataList[] = $hidestake;
                }
                if (in_array("Investors", $rowArray))
                {
                    $DataList[] = $investorString;
                }
                if (in_array("Date", $rowArray))
                {
                    $DataList[] = $row[15];
                }
    
                if (in_array("Website", $rowArray))
                {
                    $DataList[] = $webdisplay;
                }
                if (in_array("Year Founded", $rowArray))
                {
                    $DataList[] = $yearfounded;
                }
                if (in_array("Sector", $rowArray))
                {
                    $DataList[] = $row[9];
                }
                if (in_array("Amount(US" . '$M' . ")", $rowArray))
                {
                    $DataList[] = $hideamount;
                }
                if (in_array("Amount(INR Cr)", $rowArray))
                {
                    $DataList[] = $hideamount_INR;
                }
    
                if (in_array("Advisor-Company", $rowArray))
                {
                    $DataList[] = $advisorCompanyString;
                }
                if (in_array("Advisor-Investors", $rowArray))
                {
                    $DataList[] = $advisorInvestorString;
                }
                if (in_array("More Details", $rowArray))
                {
                    $DataList[] = $resmoreinfo;
                }
                if (in_array("Link", $rowArray))
                {
                    $DataList[] = trim($row[24]);
                }
                if (in_array("Pre Money Valuation (INR Cr)", $rowArray))
                {
                    $DataList[] = $pre_company_valuation;
                }
                if (in_array("Revenue Multiple (Pre)", $rowArray))
                {
                    $DataList[] = $pre_revenue_multiple;
                }
                if (in_array("EBITDA Multiple (Pre)", $rowArray))
                {
                    $DataList[] = $pre_ebitda_multiple;
                }
                if (in_array("PAT Multiple (Pre)", $rowArray))
                {
                    $DataList[] = $pre_pat_multiple;
                }
                if (in_array("Post Money Valuation (INR Cr)", $rowArray))
                {
                    $DataList[] = $dec_company_valuation;
                }
                if (in_array("Revenue Multiple (Post)", $rowArray))
                {
                    $DataList[] = $dec_revenue_multiple;
                }
                if (in_array("EBITDA Multiple (Post)", $rowArray))
                {
                    $DataList[] = $dec_ebitda_multiple;
                }
                if (in_array("PAT Multiple (Post)", $rowArray))
                {
                    $DataList[] = $dec_pat_multiple;
                }
                if (in_array("Enterprise Valuation (INR Cr)", $rowArray))
                {
                    $DataList[] = $ev_company_valuation;
                }
                if (in_array("Revenue Multiple (EV)", $rowArray))
                {
                    $DataList[] = $ev_revenue_multiple;
                }
                if (in_array("EBITDA Multiple (EV)", $rowArray))
                {
                    $DataList[] = $ev_ebitda_multiple;
                }
                if (in_array("PAT Multiple (EV)", $rowArray))
                {
                    $DataList[] = $ev_pat_multiple;
                }
                if (in_array("Price to Book", $rowArray))
                {
                    $DataList[] = $price_to_book;
                }
                if (in_array("Valuation", $rowArray))
                {
                    $DataList[] = trim($row[26]);
                }
                if (in_array("Revenue (INR Cr)", $rowArray))
                {
                    $DataList[] = $dec_revenue;
                }
                if (in_array("EBITDA (INR Cr)", $rowArray))
                {
                    $DataList[] = $dec_ebitda;
                }
                if (in_array("PAT (INR Cr)", $rowArray))
                {
                    $DataList[] = $dec_pat;
                }
                if (in_array("Total Debt (INR Cr)", $rowArray))
                {
                    $DataList[] = $Total_Debt;
                }
                if (in_array("Cash & Cash Equ. (INR Cr)", $rowArray))
                {
                    $DataList[] = $Cash_Equ;
                }
                if (in_array("Book Value Per Share", $rowArray))
                {
                    $DataList[] = $book_value_per_share;
                }
                if (in_array("Price Per Share", $rowArray))
                {
                    $DataList[] = $price_per_share;
                }
                // if(in_array("Link for Financials", $rowArray))
                // {
                //     $DataList[]= $row[27];
                // }
                $arrayData[] = $DataList;
     
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

                $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('A'.$indexfortitle, $tsjtitle)
                            ->setCellValue('A'.$indexfortranche, $tranchedisplay);

                // Rename worksheet
                while($rows = mysql_fetch_array($sqlQuery))
                {
                $objPHPExcel->getActiveSheet()->setTitle($rows['investor']);
                }            
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
                $objPHPExcel->setActiveSheetIndex($sheet_count);
                $sheet_count++;
                $objPHPExcel->createSheet($sheet_count);
         
                $objPHPExcel->setActiveSheetIndex($sheet_count);
                //$objWorkSheet = $objPHPExcel->getActiveSheet($sheet_count);
               

        
            }

            $objPHPExcel->removeSheetByIndex(
                $objPHPExcel->getIndex(
                    $objPHPExcel->getSheetByName('Worksheet')
                )
            );

            }
            else
            {
                    // Add some data
    $rowArray = $expval;
    $objPHPExcel->getActiveSheet()
        ->fromArray(
            $rowArray,   // The data to set
            NULL,        // Array values with this value will not be set
            'A1'         // Top left coordinate of the worksheet range where
                         //    we want to set these values (default is A1)
        );
    
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
        
        $companiessql = "select Distinct pe.PEId,pe.PEId, pe.PEId, pe.PECompanyID, pe.StageId, pec.countryid, pec.industry, pec.companyname, i.industry,pec.sector_business,amount,round,s.stage, it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%b-%y') as dealperiod, pec.website,pec.city,r.Region, MoreInfor,hideamount,hidestake,c.country,c.country, Link,pec.RegionId,Valuation,FinLink, Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple, listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded,pec.state,pec.CINNo from peinvestments as pe
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
            if(in_array("CIN", $rowArray))
            {
                $DataList[] = $row[55];
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
            // if(in_array("Link for Financials", $rowArray))
            // {
            //     $DataList[]= $row[27];
            // }
        
        $arrayData[] = $DataList;
    

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
    $objPHPExcel->getActiveSheet()->setTitle('pe_invdeals');
    
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

            }
          
             // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="peinv_deals.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit();
    

    }
    else
    {
        echo $rowscount;
        exit();
    }
}
?>