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
if($vcflagValue==0 || $vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5){
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
    $industry=$_POST['txthideindustryid'];
    $stageval=$_POST['txthidestageid'];
    $firmtypeid=$_POST['txthidefirmtypeid'];
    if($industry!='')
    {
        $whereindustry=" and `pecompanies`.industry= $industry";
    }
    if($stageval!='')
    {
        $wherestage =" and`peinvestments`.StageId IN(" .$stageval.")";
    }
    if($firmtypeid!='')
    {
        $wherefirmtypetxt = " and `peinvestors`.FirmTypeId IN (".$firmtypeid.")";
    }
    if($vcflagValue==0){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0'  $whereindustry $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId` and peinvestments.Deleted =0 order by deals desc";
    }
    else if($vcflagValue==1){

        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PEcompanyID`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from 
            `peinvestments_investors`,`peinvestments`,`peinvestors` ,`pecompanies`,`industry`,`stage` where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` 
            and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `pecompanies`.`PEcompanyID` = `peinvestments`.`PECompanyID` 
            and `pecompanies`.`industry` = `industry`.`industryid` and `peinvestments`.`StageId` = `stage`.StageId and `peinvestments`.`dates` between '" . $dt1 . "' 
            and '" . $dt2 . "' and `peinvestments`.`amount` <=20 and `stage`.`VCview`=1 and `pecompanies`.`industry` !=15 and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0  $whereindustry $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId` order by deals desc";
  
    }else if($vcflagValue==3){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'SV' )  $whereindustry $wherestage $wherefirmtypetxt  group by `peinvestments_investors`.`InvestorId`  order by deals desc";
    }else if($vcflagValue==4){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'CT'  )  $whereindustry $wherestage $wherefirmtypetxt  group by `peinvestments_investors`.`InvestorId` order by deals desc";
    }else if($vcflagValue==5){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'IF'  )  $whereindustry $wherestage $wherefirmtypetxt  group by `peinvestments_investors`.`InvestorId` order by deals desc";
    }else if($vcflagValue==2){
        
        $reportsql = "SELECT count(peinv_inv.AngelDealId) as deals, inv.Investor as investor, inv.InvestorId as id, count(peinv.InvesteeId) as cos
FROM angel_investors AS peinv_inv, peinvestors AS inv, angelinvdeals AS peinv, pecompanies AS c
WHERE inv.InvestorId = peinv_inv.InvestorId
AND peinv.AngelDealId = peinv_inv.AngelDealId
AND c.PECompanyId = peinv.InvesteeId
AND peinv.Deleted =0 and inv.InvestorId !=9 and peinv.DealDate between '" . $dt1 . "' and '" . $dt2 . "'  $whereindustry $wherestage $wherefirmtypetxt 
Group by inv.InvestorId order by deals desc"; 
}
    $query1 = $reportsql;
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
    $industry=$_POST['txthideindustryid'];
    $stageval=$_POST['txthidestageid'];
    $firmtypeid=$_POST['txthidefirmtypeid'];
    
    
    if($industry!='')
    {
        $whereindustry=" and `pecompanies`.industry= $industry";
    }
    if($stageval!='')
    {
        $wherestage =" and`peinvestments`.StageId IN(" .$stageval.")";
    }
    if($firmtypeid!='')
    {
        $wherefirmtypetxt = " and `peinvestors`.FirmTypeId IN (".$firmtypeid.")";
    }
   if($vcflagValue==0){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 $whereindustry $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId` order by deals desc";
    }else if($vcflagValue==1){

        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PEcompanyID`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from 
            `peinvestments_investors`,`peinvestments`,`peinvestors` ,`pecompanies`,`industry`,`stage` where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` 
            and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `pecompanies`.`PEcompanyID` = `peinvestments`.`PECompanyID` 
            and `pecompanies`.`industry` = `industry`.`industryid` and `peinvestments`.`StageId` = `stage`.StageId and `peinvestments`.`dates` between '" . $dt1 . "' 
            and '" . $dt2 . "' and `peinvestments`.`amount` <=20 and `stage`.`VCview`=1 and `pecompanies`.`industry` !=15 and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 $whereindustry $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId` order by deals desc";
  
    }else if($vcflagValue==3){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'SV' )  $whereindustry $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId` order by deals desc";
    }else if($vcflagValue==4){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'CT'  ) $whereindustry $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId` order by deals desc";
    }else if($vcflagValue==5){
        
        $reportsql = "SELECT count(`peinvestments_investors`.`PEId`) as deals,`peinvestors`.`Investor` as investor,`peinvestors`.`InvestorId` as id, count(DISTINCT `pecompanies`.`PECompanyId`) as cos,(Select count(PECompanyId) as newCos from $view_table where deal_date between '" . $dt1 . "' and '" . $dt2 . "' and InvestorId=`peinvestors`.`InvestorId`) as newPCos from `peinvestments_investors`,`peinvestments`,`peinvestors`,`pecompanies`
        where `peinvestments_investors`.`PEId` =`peinvestments`.`PEId` and `peinvestments_investors`.`InvestorId` =`peinvestors`.`InvestorId` and `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId`
        and `peinvestments`.`dates` between '" . $dt1 . "' and '" . $dt2 . "' and `peinvestments_investors`.`InvestorId`!=9 and `peinvestments`.AggHide='0' and `peinvestments`.SPV='0' and peinvestments.Deleted =0 AND peinvestments.PEId IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'IF'  ) $whereindustry $wherestage $wherefirmtypetxt group by `peinvestments_investors`.`InvestorId` order by deals desc";
    }else if($vcflagValue==2){
        
        $reportsql = "SELECT count(peinv_inv.AngelDealId) as deals, inv.Investor as investor, inv.InvestorId as id, count(peinv.InvesteeId) as cos
FROM angel_investors AS peinv_inv, peinvestors AS inv, angelinvdeals AS peinv, pecompanies AS c
WHERE inv.InvestorId = peinv_inv.InvestorId
AND peinv.AngelDealId = peinv_inv.AngelDealId
AND c.PECompanyId = peinv.InvesteeId
AND peinv.Deleted =0 and inv.InvestorId !=9 and peinv.DealDate between '" . $dt1 . "' and '" . $dt2 . "' $whereindustry $wherestage $wherefirmtypetxt
Group by inv.InvestorId order by deals desc"; 
}
    $query1 = $reportsql;
}
$searchtitle = "Most Active Investors-$year";

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
header("Content-Disposition: attachment; filename=investorreport.$file_ending");
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
if($vcflagValue!=2){echo "New Portfolio Cos" . "\t";}
print("\n");
print("\n");
//end of printing column names
//start while loop to get data


while ($row = mysql_fetch_array($result)) {

    $schema_insert = "";
    $investor = $row['investor'];
    $deals = $row['deals'];
    $Cos= $row['cos'];
    $NewCos= $row['newPCos'];


    $schema_insert .= $investor . $sep;
    $schema_insert .= $deals . $sep;
    $schema_insert .= $Cos . $sep;
    if($vcflagValue!=2){$schema_insert .= $NewCos . $sep;}
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
