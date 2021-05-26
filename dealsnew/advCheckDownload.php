<?php
session_save_path("/tmp");
session_start();
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$dlogUserEmail = $_SESSION['UserEmail'];
//print_r($_SESSION);exit();
 //Get Current Downloads 
 if(!isset($_SESSION['UserNames']))
 {
          header('Location:../pelogin.php');
 }
 else
 {
 //$sqlSelCount = "SELECT sum(`recDownloaded`) as `recDownloaded` FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND ( `downloadDate` = CURRENT_DATE || `downloadDate` = DATE_SUB(CURRENT_DATE,INTERVAL 1 DAY))";
 $sqlSelCount = "SELECT sum(`recDownloaded`) as `recDownloaded` FROM `advance_export_filter_log` WHERE `emailId` = '".$dlogUserEmail."'  AND ( `downloadDate` = CURRENT_DATE )";

 //echo $sqlSelCount ;exit();
 $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
 $rowSelCount = mysql_fetch_object($sqlSelResult);
 $downloads = $rowSelCount->recDownloaded;
 
 //Get Download Limit
 $sqlSelLimit = "SELECT `custom_export_limit` FROM `dealcompanies` WHERE `DCompId`='".$_SESSION['DcompanyId']."'";
 $sqlLmtResult= mysql_query($sqlSelLimit) or die(mysql_error());
 $rowLmt = mysql_fetch_object($sqlLmtResult);
 $downldLmt = $rowLmt->custom_export_limit;

$data = array();
$data['recDownloaded'] = $downloads;
$data['exportLimit'] = $downldLmt;

echo json_encode($data);
mysql_close();
    mysql_close($cnx);
 }
?>