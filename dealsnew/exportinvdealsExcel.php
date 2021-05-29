<?php include_once("../globalconfig.php"); ?>
<?php
ini_set('memory_limit', '2048M');
ini_set("max_execution_time", 10000);

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

//echo $_POST['companytype'];exit();
if($companytype != '' && $companytype != '--')
{
    $companytype=str_replace(",","','",$companytype);
    $companytype="'".$companytype."'";
   // echo 'hai';exit();
$companyTypeStatus="and pe.listing_status IN (".$companytype.")";
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
if($investorType != ''  && $investorType != '--')
{
    $investorType=str_replace(",","','",$investorType);
    $investorType="'".$investorType."'";
$InvestorType="and pe.InvestorType IN (".$investorType.")";
}
//echo $_POST['exitStatus'];exit();
if($_POST['invquery'] != "")
{
    $sql= $_POST['invquery'];
}
elseif($keyword == ""){
        $sql="SELECT pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod, pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor, (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId JOIN industry AS i ON pec.industry = i.industryid JOIN stage AS s ON s.StageId=pe.StageId WHERE  dates between '".$startDate."' and '".$endYear."'  and pe.Deleted=0 AND pe.SPV=0 and pe.AggHide=0 and pec.industry !=15 AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by dates desc,companyname asc";
}
else{
$sql="SELECT pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod, pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor, (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId JOIN industry AS i ON pec.industry = i.industryid JOIN stage AS s ON s.StageId=pe.StageId WHERE peinv_inv.InvestorId IN(".$keyword.")  and dates between '".$startDate."' and '".$endYear."' ".$companyTypeStatus." ".$industryType." ".$cityType." ".$stateId." ".$RegionId." ".$Exit_Status." ".$roundtype." ".$StageId." ".$InvestorType." and pe.Deleted=0 AND pe.SPV=0 and pe.AggHide=0 and pec.industry !=15 AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by dates desc,companyname asc";
}
//echo $sql;exit();
//execute query
$result = mysql_query($sql) or die(mysql_error());
$rowscount = mysql_num_rows($result);
//echo "There are " . $rowscount . " rows in my table.";exit();
if($rowscount == 0)
{
    echo $rowscount;exit();
}
else
{
$exportvalue=$_POST['resultarray'];
if($exportvalue == "Select-All"){
    $exportvalue = "Company,CIN,Company Type,Industry,City,State,Region,Exit Status,Round,Stage,Investor Type,Stake (%),Investors,Date,Website,Year Founded,Sector,Amount(US".'$M'."),Amount(INR Cr),Advisor-Company,Advisor-Investors,More Details,Link,Pre Money Valuation (INR Cr),Revenue Multiple (Pre),EBITDA Multiple (Pre),PAT Multiple (Pre),Post Money Valuation (INR Cr),Revenue Multiple (Post),EBITDA Multiple (Post),PAT Multiple (Post),Enterprise Valuation (INR Cr),Revenue Multiple (EV),EBITDA Multiple (EV),PAT Multiple (EV),Price to Book,Valuation,Revenue (INR Cr),EBITDA (INR Cr),PAT (INR Cr),Total Debt (INR Cr),Cash & Cash Equ. (INR Cr),Book Value Per Share,Price Per Share";    
    //$exportvalue = "Company,Company Type,Industry,City,State,Region,Exit Status,Round,Stage,Investor Type,Stake (%),Investors,Date,Website,Year Founded,Sector,Amount(US".'$M'."),Amount(INR Cr),Advisor-Company,Advisor-Investors,More Details,Link,Pre Money Valuation (INR Cr),Revenue Multiple (Pre),EBITDA Multiple (Pre),PAT Multiple (Pre),Post Money Valuation (INR Cr),Revenue Multiple (Post),EBITDA Multiple (Post),PAT Multiple (Post),Enterprise Valuation (INR Cr),Revenue Multiple (EV),EBITDA Multiple (EV),PAT Multiple (EV),Price to Book,Valuation,Revenue (INR Cr),EBITDA (INR Cr),PAT (INR Cr),Total Debt (INR Cr),Cash & Cash Equ. (INR Cr),Book Value Per Share,Price Per Share,Link for Financials";    

}
$expval=explode(",",$exportvalue);

// end T960
$rowArray=$expval;


updateDownload($result);
 //if this parameter is included ($w=1), file returned will be in word format ('.doc')
 //if parameter is not included, file returned will be in excel format ('.xls')
    
 if (isset($w) && ($w==1))
 {
         $file_type = "msword";
         $file_ending = "doc";
 }
 else
 {
         $file_type = "vnd.ms-excel";
         $file_ending = "xls";
 }
 
//header info for browser: determines file type ('.doc' or '.xls')
 
header("Content-Type: application/$file_type");
 header("Content-Disposition: attachment; filename=peinv_deals.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");
 if ($Use_Title == 1)
 {
     echo("$title\n");
 }
     /*echo ("$tsjtitle");

 print("\n");
 print("\n");
 echo "Target in () indicates sale of asset rather than the company. Target in {} indicates a minority stake acquisition.";
 print("\n");
 print("\n");*/
 
 //define separator (defines columns in excel & tabs in word)
 
 $sep = "\t"; //tabbed character

//start of printing column names as names of MySQL fields

if(in_array("Company", $rowArray))
{
    echo "Company"."\t";

}
if(in_array("CIN", $rowArray))
{
    echo "CIN"."\t";
}
if(in_array("Company Type", $rowArray))
{
    echo "Company Type"."\t";
}
if(in_array("Industry", $rowArray))
{
    echo "Industry"."\t";
}
if(in_array("City", $rowArray))
{
    echo "City"."\t";
}
if(in_array("State", $rowArray))
{
    echo "State"."\t";
}
if(in_array("Region", $rowArray))
{
    echo "Region"."\t";
}
if(in_array("Exit Status", $rowArray))
{
    echo "Exit Status"."\t";
}
if(in_array("Round", $rowArray))
{
    echo "Round"."\t";
}
if(in_array("Stage", $rowArray))
{
    echo "Stage"."\t";
}
if(in_array("Investor Type", $rowArray))
{
    echo "Investor Type"."\t";
}
if(in_array("Stake (%)", $rowArray))
{
    echo "Stake (%)"."\t";
}
if(in_array("Investors", $rowArray))
{
    echo "Investors"."\t";
}


if(in_array("Date", $rowArray))
{
    echo "Date"."\t";
}
if(in_array("Website", $rowArray))
{
    echo "Website"."\t";
}
if(in_array("Year Founded", $rowArray))
{
    echo "Year Founded"."\t";
}
if(in_array("Sector", $rowArray))
{
    echo "Sector"."\t";
}

if(in_array("Amount(US".'$M'.")", $rowArray))
{
    echo "Amount(US".'$M'.")"."\t";
}
if(in_array("Amount(INR Cr)", $rowArray))
{
    echo "Amount(INR Cr)"."\t";
}
if(in_array("Advisor-Company", $rowArray))
{
    echo "Advisor-Company"."\t";
}
if(in_array("Advisor-Investors", $rowArray))
{
    echo "Advisor-Investors"."\t";
}
if(in_array("More Details", $rowArray))
{
    echo "More Details"."\t";
}
if(in_array("Link", $rowArray))
{
    echo "Link"."\t";
}
if(in_array("Pre Money Valuation (INR Cr)", $rowArray))
{
    echo "Pre Money Valuation (INR Cr)"."\t";
}
if(in_array("Revenue Multiple (Pre)", $rowArray))
{
    echo "Revenue Multiple (Pre)"."\t";
}
if(in_array("EBITDA Multiple (Pre)", $rowArray))
{
    echo "EBITDA Multiple (Pre)"."\t";
}
if(in_array("PAT Multiple (Pre)", $rowArray))
{
    echo "PAT Multiple (Pre)"."\t";
}
if(in_array("Post Money Valuation (INR Cr)", $rowArray))
{
    echo "Post Money Valuation (INR Cr)"."\t";
}
if(in_array("Revenue Multiple (Post)", $rowArray))
{
    echo "Revenue Multiple (Post)"."\t";
}
if(in_array("EBITDA Multiple (Post)", $rowArray))
{
    echo "EBITDA Multiple (Post)"."\t";
}
if(in_array("PAT Multiple (Post)", $rowArray))
{
    echo "PAT Multiple (Post)"."\t";
}
if(in_array("Enterprise Valuation (INR Cr)", $rowArray))
{
    echo "Enterprise Valuation (INR Cr)"."\t";
}
if(in_array("Revenue Multiple (EV)", $rowArray))
{
    echo "Revenue Multiple (EV)"."\t";
}
if(in_array("EBITDA Multiple (EV)", $rowArray))
{
    echo "EBITDA Multiple (EV)"."\t";
}
if(in_array("PAT Multiple (EV)", $rowArray))
{
    echo "PAT Multiple (EV)"."\t";
}
if(in_array("Price to Book", $rowArray))
{
    echo "Price to Book"."\t";
}
if(in_array("Valuation", $rowArray))
{
    echo "Valuation"."\t";
}
if(in_array("Revenue (INR Cr)", $rowArray))
{
    echo "Revenue (INR Cr)"."\t";
}
if(in_array("EBITDA (INR Cr)", $rowArray))
{
    echo "EBITDA (INR Cr)"."\t";
}
if(in_array("PAT (INR Cr)", $rowArray))
{
    echo "PAT (INR Cr)"."\t";
}
if(in_array("Total Debt (INR Cr)", $rowArray))
{
    echo "Total Debt (INR Cr)"."\t";
}
if(in_array("Cash & Cash Equ. (INR Cr)", $rowArray))
{
    echo "Cash & Cash Equ. (INR Cr)"."\t";
}
if(in_array("Book Value Per Share", $rowArray))
{
    echo "Book Value Per Share"."\t";
}
if(in_array("Price Per Share", $rowArray))
{
    echo "Price Per Share"."\t";
}
 
 /*print("\n");*/
 print("\n");
 //end of printing column names

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
// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);
// date_default_timezone_set('Europe/London');
// if (PHP_SAPI == 'cli')
// 	die('This example should only be run from a Web Browser');
// /** Include PHPExcel */
// require_once '../PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
// // Create new PHPExcel object
// $objPHPExcel = new PHPExcel();
// // Set document properties
// $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
// 							 ->setLastModifiedBy("Maarten Balliauw")
// 							 ->setTitle("Office 2007 XLSX Test Document")
// 							 ->setSubject("Office 2007 XLSX Test Document")
// 							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
// 							 ->setKeywords("office 2007 openxml php")
// 							 ->setCategory("Test result file");
// // Add some data
// $rowArray = $expval;
// $objPHPExcel->getActiveSheet()
//     ->fromArray(
//         $rowArray,   // The data to set
//         NULL,        // Array values with this value will not be set
//         'A1'         // Top left coordinate of the worksheet range where
//                      //    we want to set these values (default is A1)
//     );
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
//$DataList = array();
$col = 0;  

    if(isset($rows['PEId'])){
        $PEId = $rows['PEId'];
    }else{
        $PEId = $rows[13];
    }
    
    $companiessql = "select pe.PEId,pe.PEId, pe.PEId, pe.PECompanyID, pe.StageId, pec.countryid, pec.industry, pec.companyname, i.industry,pec.sector_business,amount,round,s.stage, it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%M-%y') as dealperiod, pec.website,pec.city,r.Region, MoreInfor,hideamount,hidestake,c.country,c.country, Link,pec.RegionId,Valuation,FinLink, Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple, listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded,pec.state,pec.CINNo from peinvestments as pe
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
		peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',inv.InvestorId IN ('$keyword') desc ";

    }
    else{
       $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
        peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',inv.InvestorId desc ";
    }
    //echo $investorSql;exit();

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

//echo json_encode($rowArray).'hai';exit();
    // T960
    if(in_array("Company", $rowArray))
    {
        $schema_insert .= $companyName.$sep;
    }
    if(in_array("CIN", $rowArray))
    {
        $schema_insert .= $row[55].$sep;
    }
    if(in_array("Company Type", $rowArray))
    {
        $schema_insert .= $listing_status_display.$sep;
    }
    if(in_array("Industry", $rowArray))
    {
        $schema_insert .= $row[8].$sep;
    }
    if(in_array("City", $rowArray))
    {
        $schema_insert .= $row[17].$sep;
    }
    if(in_array("State", $rowArray))
    {
        $schema_insert .= $row[54].$sep;
    }
    if(in_array("Region", $rowArray))
    {
        $schema_insert .= $row[18].$sep;
    }
    if(in_array("Exit Status", $rowArray))
    {
        $schema_insert .= $exitstatusis.$sep;
    }
    if(in_array("Round", $rowArray))
    {
        $schema_insert .= $row[11].$sep;
    }
    if(in_array("Stage", $rowArray))
    {
        $schema_insert .= $row[12].$sep;
    }
    if(in_array("Investor Type", $rowArray))
    {
        $schema_insert .= $row[13].$sep;
    }
    if(in_array("Stake (%)", $rowArray))
    {
        $schema_insert .= $hidestake.$sep;
    }
    if(in_array("Investors", $rowArray))
    {
        $schema_insert .= $investorString.$sep;
    }
 
  
    if(in_array("Date", $rowArray))
    {
        $schema_insert .= $row[15].$sep;
    }
   
    if(in_array("Website", $rowArray))
    {
        $schema_insert .= $webdisplay.$sep;
    }
    if(in_array("Year Founded", $rowArray))
    {
        $schema_insert .= $yearfounded.$sep;
    }
    
    if(in_array("Sector", $rowArray))
    {
        $schema_insert .= $row[9].$sep;
    }
    if(in_array("Amount(US".'$M'.")", $rowArray))
    {
        $schema_insert .= $hideamount.$sep;
    }
    if(in_array("Amount(INR Cr)", $rowArray))
    {
        $schema_insert .= $hideamount_INR.$sep;
    }
    
    if(in_array("Advisor-Company", $rowArray))
    {
        $schema_insert .= $advisorCompanyString.$sep;
    }
    if(in_array("Advisor-Investors", $rowArray))
    {
        $schema_insert .= $advisorInvestorString.$sep;
    }
    if(in_array("More Details", $rowArray))
    {
        $schema_insert .= $resmoreinfo.$sep;
    }
    if(in_array("Link", $rowArray))
    {
        $schema_insert .= trim($row[24]).$sep;
    }
    if(in_array("Pre Money Valuation (INR Cr)", $rowArray))
    {
        $schema_insert .= $pre_company_valuation.$sep;
    }
    if(in_array("Revenue Multiple (Pre)", $rowArray))
    {
        $schema_insert .= $pre_revenue_multiple.$sep;
    }
    if(in_array("EBITDA Multiple (Pre)", $rowArray))
    {
        $schema_insert .= $pre_ebitda_multiple.$sep;
    }
    if(in_array("PAT Multiple (Pre)", $rowArray))
    {
        $schema_insert .= $pre_pat_multiple.$sep;
    }
    if(in_array("Post Money Valuation (INR Cr)", $rowArray))
    {
        $schema_insert .= $dec_company_valuation.$sep;
    }
    if(in_array("Revenue Multiple (Post)", $rowArray))
    {
        $schema_insert .= $dec_revenue_multiple.$sep;
    }
    if(in_array("EBITDA Multiple (Post)", $rowArray))
    {
        $schema_insert .= $dec_ebitda_multiple.$sep;
    }
    if(in_array("PAT Multiple (Post)", $rowArray))
    {
        $schema_insert .= $dec_pat_multiple.$sep;
    }
    if(in_array("Enterprise Valuation (INR Cr)", $rowArray))
    {
        $schema_insert .= $ev_company_valuation.$sep;
    }
    if(in_array("Revenue Multiple (EV)", $rowArray))
    {
        $schema_insert .= $ev_revenue_multiple.$sep;
    }
    if(in_array("EBITDA Multiple (EV)", $rowArray))
    {
        $schema_insert .= $ev_ebitda_multiple.$sep;
    }
    if(in_array("PAT Multiple (EV)", $rowArray))
    {
        $schema_insert .= $ev_pat_multiple.$sep;
    }
    if(in_array("Price to Book", $rowArray))
    {
        $schema_insert .= $price_to_book.$sep;
    }
    if(in_array("Valuation", $rowArray))
    {
        $schema_insert .= trim($row[26]).$sep;
    }
    if(in_array("Revenue (INR Cr)", $rowArray))
    {
        $schema_insert .= $dec_revenue.$sep;
    }
    if(in_array("EBITDA (INR Cr)", $rowArray))
    {
        $schema_insert .= $dec_ebitda.$sep;
    }
    if(in_array("PAT (INR Cr)", $rowArray))
    {
        $schema_insert .= $dec_pat.$sep;
    }
    if(in_array("Total Debt (INR Cr)", $rowArray))
    {
        $schema_insert .= $Total_Debt.$sep;
    }
    if(in_array("Cash & Cash Equ. (INR Cr)", $rowArray))
    {
        $schema_insert .= $Cash_Equ.$sep;
    }
    if(in_array("Book Value Per Share", $rowArray))
    {
        $schema_insert .= $book_value_per_share.$sep;
    }
    if(in_array("Price Per Share", $rowArray))
    {
        $schema_insert .= $price_per_share.$sep;
    }
    // if(in_array("Link for Financials", $rowArray))
    // {
    //     $DataList[]= $row[27];
    // }
    
    //$arrayData[] = $DataList;

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

    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert .= ""."\n";
            //following fix suggested by Josue (thanks, Josue!)
            //this corrects output in excel when table fields contain \n or \r
            //these two characters are now replaced with a space
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}
print("\n");
    print("\n");
    print("\n");
    print("\n");
    echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
    print("\n");
    print("\n");
    echo "Target in () indicates sale of asset rather than the company. Target in {} indicates a minority stake acquisition.";
    print("\n");
    print("\n");
// // T960
// $objPHPExcel->getActiveSheet()
//             ->fromArray(
//                 $arrayData,  // The data to set
//                 NULL,        // Array values with this value will not be set
//                 'A2'         // Top left coordinate of the worksheet range where
//                             //    we want to set these values (default is A1)
//             );


// $indexfortitle = $index + 5;
// $indexfortranche = $index + 7;

// $objPHPExcel->setActiveSheetIndex(0)
//             ->setCellValue('A'.$indexfortitle, $tsjtitle)
//             ->setCellValue('A'.$indexfortranche, $tranchedisplay);

// // Rename worksheet
// $objPHPExcel->getActiveSheet()->setTitle('Simple');

// // $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()
// //     ->setWidth(12);
// // T960 Changes
// // $objPHPExcel->getActiveSheet()
// //     ->getStyle('G2:G'.$index)
// //     ->getAlignment()
// //     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

// // $objPHPExcel->getActiveSheet()
// //     ->getStyle('L2:L'.$index)
// //     ->getAlignment()
// //     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// // T960 Changes
// $objPHPExcel->getActiveSheet()
//     ->getStyle('A2:A2')
//     ->getAlignment()
//     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

// // Set active sheet index to the first sheet, so Excel opens this as the first sheet
// $objPHPExcel->setActiveSheetIndex(0);
// // Redirect output to a client’s web browser (Excel5)
// header('Content-Type: application/vnd.ms-excel');
// header('Content-Disposition: attachment;filename="peinv_deals.xls"');
// header('Cache-Control: max-age=0');
// // If you're serving to IE 9, then the following may be needed
// header('Cache-Control: max-age=1');
// // If you're serving to IE over SSL, then the following may be needed
// header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
// header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
// header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
// header ('Pragma: public'); // HTTP/1.0
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
// $objWriter->save('php://output');
exit();
  

    }
//		}
//else
//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;
mysql_close();
mysql_close($cnx);
?>


	