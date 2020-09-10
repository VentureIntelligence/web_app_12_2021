<?php

session_save_path("/tmp");
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

$TrialExpired = "Your email login has expired. Please contact info@ventureintelligence.com";


$tsjtitle = "� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
$vcflagValue = $_POST['flaghidden'];
if($vcflagValue==0){
    $view_table = "PEnew_portfolio_cos";
}else{
    $view_table = 'VCnew_portfolio_cos';
}
if ($_POST['date_year1']=='') {

    $year1=$year2=date('Y');
    $month1='01';
    $month2='12';
    $dt1 = $year1.'-'.$month1.'-01';
    $dt2 = $year2.'-'.$month2.'-31';
    $defaultyear=1998;
    $defaultmonth=01;
    $prevyear = $year2 - 1;
    $defaultday= $defaultyear.'-'.$defaultmonth.'-01';
    $endDate= date('Y-m', strtotime($dt1." -1 month")).'-31';
    //echo "<br>all records" .$reportsql;
} else {
    
    $year1=$_POST['date_year1'];
    $year2=$_POST['date_year2'];
    $month1=$_POST['date_month1'];
    $month2=$_POST['date_month2'];
    $dt1 = $year1.'-'.$month1.'-01';
    $dt2 = $year2.'-'.$month2.'-31';
    if($dt1 > $dt2){        
        $year1=$year2=date('Y');
        $month1='01';
        $month2='12';
    }
    $defaultyear=1998;
    $defaultmonth=01;
    $prevyear = $year2 - 1;
    $defaultday= $defaultyear.'-'.$defaultmonth.'-01';
    $endDate= date('Y-m', strtotime($dt1." -1 month")).'-31';
    
}

if($vcflagValue==0){
        
   $reportsql = "SELECT count(peinv_inv.PEId) as deals,inv.Investor as investor,inv.InvestorId as id, count(DISTINCT pec.PECompanyId) as cos,pe.dates
    FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
    JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
    JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
    and pe.dates between '" . $dt1 . "' and '" . $dt2 . "' and peinv_inv.InvestorId !=9 and pe.Deleted = 0 and pec.industry !=15
    and peinv_inv.InvestorId NOT IN (SELECT peinv_inv.InvestorId from peinvestments_investors AS peinv_inv, peinvestments as pe  
           where pe.PEId = peinv_inv.PEId and pe.dates between  '" . $defaultday . "'  and  '" . $endDate . "' )
    group by peinv_inv.InvestorId order by investor asc";
}else{

   $reportsql = "SELECT count(peinv_inv.PEId) as deals,inv.Investor as investor,inv.InvestorId as id, count(DISTINCT pec.PECompanyId) as cos,pe.dates
    FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
    JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
    JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
    JOIN industry AS i ON pec.industry = i.industryid
    JOIN stage AS s ON pe.StageId = s.StageId
    and pe.dates between '" . $dt1 . "' and '" . $dt2 . "' and peinv_inv.InvestorId !=9 and pe.Deleted = 0 and s.VCview=1 and pe.amount <=20  and pec.industry !=15  
    and peinv_inv.InvestorId NOT IN (SELECT peinv_inv.InvestorId from peinvestments_investors AS peinv_inv, peinvestments as pe  
           where pe.PEId = peinv_inv.PEId and pe.dates between  '" . $defaultday . "'  and  '" . $endDate . "' )
    group by peinv_inv.InvestorId order by investor asc";

}

$query1 = $reportsql;

$searchtitle = "New Investors-$year";

function moneyFormatIndia($num) {
    $explrestunits = "";
    if (strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
        $restunits = (strlen($restunits) % 2 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if ($i == 0) {
                $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

function moneyFormatUS($num) {
    $explrestunits = "";
    if (strlen($num) > 3) {
        $lastthree = substr($num, strlen($num) - 3, strlen($num));
        $restunits = substr($num, 0, strlen($num) - 3); // extracts the last three digits
        $restunits = (strlen($restunits) % 3 == 1) ? "0" . $restunits : $restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 3);
        for ($i = 0; $i < sizeof($expunit); $i++) {
            // creates each of the 2's group and adds a comma to the end
            if ($i == 0) {
                $explrestunits .= (int) $expunit[$i] . ","; // if is first value , convert into integer
            } else {
                $explrestunits .= $expunit[$i] . ",";
            }
        }
        $thecash = $explrestunits . $lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}
//echo $query1;
//exit;
$result = @mysql_query($query1) or die("Couldn't execute query:<br>" . mysql_error() . "<br>" . mysql_errno());
//echo '<pre>';
//print_r($result);
//exit;
updateDownload($result);

////if this parameter is included ($w=1), file returned will be in word format ('.doc')
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
header("Content-Disposition: attachment; filename=newinvestorreport.$file_ending");
header("Pragma: no-cache");
header("Expires: 0");

/*    Start of Formatting for Word or Excel    */
/*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

//create title with timestamp:
if ($Use_Title == 1) {
    echo("$title\n");
}

echo ("$tsjtitle");
print("\n");
print("\n");
echo ("$searchtitle");
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
echo "Investor" . "\t";
echo "No.of Deals" . "\t";
echo "No.of Cos" . "\t";
print("\n");
print("\n");
//end of printing column names
//start while loop to get data


while ($row = mysql_fetch_array($result)) {

    $schema_insert = "";
    $investor = $row['investor'];
    $deals = $row['deals'];
    $Cos= $row['cos'];

    $schema_insert .= $investor . $sep;
    $schema_insert .= $deals . $sep;
    $schema_insert .= $Cos . $sep;
    $schema_insert .= "" . "\n";
    //following fix suggested by Josue (thanks, Josue!)
    //this corrects output in excel when table fields contain \n or \r
    //these two characters are now replaced with a space
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}


mysql_close();
    mysql_close($cnx);
    ?>
