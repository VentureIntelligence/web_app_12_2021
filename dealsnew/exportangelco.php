<?php

// session_save_path("/tmp");
// session_start();

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

$searchtitle = "List of Angel Deals";
$tsjtitle = "� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

$filter = '';
if ($_POST) {


    if ($_POST['companyhidden'] != '') {
        $companysearch = stripslashes($_POST['companyhidden']);
        $filter .= " a.company_name IN ($companysearch)  ";
    }

    if ($_POST['locationhidden'] != '') {
        $location = $_POST['locationhidden'];
      
        if ($filter == '')
            $filter .= "  a.location ='$location'  ";
        else
            $filter .= " and a.location ='$location'  ";
    }


    //amount filter
    if ($_POST['amount_from_hidden'] != '' || $_POST['amount_to_hidden'] != '') {

        $amount_from = $_POST['amount_from_hidden'];
        $amount_to = $_POST['amount_to_hidden'];


        if ($amount_from != '' && $amount_to == '') {

            $Amt_from = $amount_from * 1000;

            if ($filter == '')
                $filter .= "  a.raising_amount >=  $Amt_from     ";
            else
                $filter .= " and  a.raising_amount >=   $Amt_from   ";
        }
        elseif ($amount_from == '' && $amount_to != '') {

            $Amt_to = $amount_to * 1000;

            if ($filter == '')
                $filter .= "  a.raising_amount <=  $Amt_to     ";
            else
                $filter .= " and  a.raising_amount <=   $Amt_to   ";
        }
        elseif ($amount_from < $amount_to) {

            $Amt_from = $amount_from * 1000;
            $Amt_to = $amount_to * 1000;

            if ($filter == '')
                $filter .= "  a.raising_amount  BETWEEN  $Amt_from  and  $Amt_to   ";
            else
                $filter .= " and  a.raising_amount  BETWEEN  $Amt_from  and  $Amt_to   ";
        }
    }
    //amount filter end


    if ($filter != '') {
        $filter = '  WHERE ' . $filter;
    }
    else{
        $filter = '  WHERE raising_amount >= 10000  ';       
    }
} else {
    if ($filter == '') {
        $filter = '  WHERE raising_amount >= 10000  ';
    }
}

$ordertype = 'asc';
$query1 = " SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos   a LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id   $filter ";

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
header("Content-Disposition: attachment; filename=AngelCo.$file_ending");
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

//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
//-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
echo "Company" . "\t";
echo "Raising Amount" . "\t";
echo "Location" . "\t";
echo "Description" . "\t";
echo "Website" . "\t";
echo "AngelListUrl" . "\t";

print("\n");
print("\n");
//end of printing column names
//start while loop to get data


while ($row = mysql_fetch_array($result)) {

    $schema_insert = "";
    $companyName = $row['company_name'];
    $raisingamount = $row['raising_amount'];
    $location = $row['location'];
    $description = $row['high_concept'];
    $website = $row['company_url'];
    $angel_url=$row['angellist_url'];



    $schema_insert .= $companyName . $sep;
    $schema_insert .= $raisingamount . $sep;
    $schema_insert .= $location . $sep;
    $schema_insert .= $description . $sep;
    $schema_insert .= $website . $sep;
    $schema_insert .= $angel_url . $sep;
    $schema_insert .= "" . "\n";
    //following fix suggested by Josue (thanks, Josue!)
    //this corrects output in excel when table fields contain \n or \r
    //these two characters are now replaced with a space
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
}
    }

mysql_close();
    mysql_close($cnx);
    ?>
