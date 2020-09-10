<?php 

session_save_path("/tmp");
session_start(); 
require_once("../dbconnectvi.php");//including database connectivity file
$Db = new dbInvestments();
include_once('checklogin.php');

//$ip =  $_SERVER['REMOTE_ADDR']; 

//if($ip=='182.74.203.34') {  } else { exit; }
    if(isset($_SESSION['demoTour'])){ unset($_SESSION['demoTour']); }
    if(isset($_SESSION['VCdemoTour'])){ unset($_SESSION['VCdemoTour']); }
    if(isset($_SESSION['EXITSdemoTour'])){ unset($_SESSION['EXITSdemoTour']); }
    if(isset($_SESSION['DirectorydemoTour'])){ unset($_SESSION['DirectorydemoTour']); }

if(isset($_SESSION['demoTour'])) { $_SESSION['demoTour']="0"; }
$method=$_POST["meth"];
switch($method)
{
    case "set":
            $_SESSION['VCdemoTour']="1";
            break;
    case "unset":
            $sql = "UPDATE `dealmembers` SET `tour`='1' WHERE `emailId` = '".$emailid."' ";
            $sqlres = mysql_query($sql) or die(mysql_error());
            $_SESSION['VCdemoTour']="0";
            break;
}

echo "1";

    
?>



