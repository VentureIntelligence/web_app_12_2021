<?php
if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
include "header.php";
    include "sessauth.php";
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$dlogUserEmail = $_SESSION['UserEmail'];



 //Get Current Downloads 
 //$sqlSelCount = "SELECT sum(`recDownloaded`) as `recDownloaded` FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='CFS' AND ( `downloadDate` = CURRENT_DATE || `downloadDate` = DATE_SUB(CURRENT_DATE,INTERVAL 1 DAY))";
 $sqlSelCount = "SELECT sum(`recDownloaded`) as `recDownloaded` FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='CFS' AND ( `downloadDate` = CURRENT_DATE )"; 
 $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
 $rowSelCount = mysql_fetch_object($sqlSelResult);
 $downloads = $rowSelCount->recDownloaded;
 
 if(is_null($downloads)){
    $downloads=0;
 }
 

 //Get Download Limit
 $dloguser_id = $_SESSION['user_id'];
 $sqlSelLimit = "SELECT `exportLimit` FROM `users` WHERE `user_id`='".$dloguser_id."'";
 $sqlLmtResult= mysql_query($sqlSelLimit) or die(mysql_error());
 $rowLmt = mysql_fetch_object($sqlLmtResult);
 $downldLmt = $rowLmt->exportLimit;

$data = array();
$data['recDownloaded'] = $downloads;
$data['exportLimit'] = $downldLmt;

echo json_encode($data);
mysql_close(); 