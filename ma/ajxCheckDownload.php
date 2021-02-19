<?php
session_save_path("/tmp");
session_start();
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include ('machecklogin.php');
$dlogUserEmail = $_SESSION['MAUserEmail'];
 //Get Current Downloads 
 $sqlSelCount = "SELECT sum(`recDownloaded`) as `recDownloaded` FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='MA' AND ( `downloadDate` = CURRENT_DATE || `downloadDate` = DATE_SUB(CURRENT_DATE,INTERVAL 1 DAY))";
 $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
 $rowSelCount = mysql_fetch_object($sqlSelResult);
 $downloads = $rowSelCount->recDownloaded;
 
 //Get Download Limit
 $sqlSelLimit = "SELECT `exportLimit` FROM `malogin_members` WHERE `EmailId`='".$dlogUserEmail."'";
 $sqlLmtResult= mysql_query($sqlSelLimit) or die(mysql_error());
 $rowLmt = mysql_fetch_object($sqlLmtResult);
 $downldLmt = $rowLmt->exportLimit;

$data = array();
$data['recDownloaded'] = $downloads;
$data['exportLimit'] = $downldLmt;

echo json_encode($data);
mysql_close();