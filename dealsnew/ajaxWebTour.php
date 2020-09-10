<?php
session_save_path("/tmp");
session_start(); 
require_once("../dbconnectvi.php");//including database connectivity file
$Db = new dbInvestments();
include_once('checklogin.php');

//$ip =  $_SERVER['REMOTE_ADDR']; 

//if($ip=='182.74.203.34') {  } else { exit; }

$method=$_POST["meth"];
$toursection=$_POST["toursection"];


if($method=='set'){
    
    if(isset($_SESSION['demoTour'])){ unset($_SESSION['demoTour']); }
    if(isset($_SESSION['VCdemoTour'])){ unset($_SESSION['VCdemoTour']); }
    if(isset($_SESSION['EXITSdemoTour'])){ unset($_SESSION['EXITSdemoTour']); }
    if(isset($_SESSION['DirectorydemoTour'])){ unset($_SESSION['DirectorydemoTour']); }
    
   
    
    switch($toursection)
        {
            
            case "Exits":
                     echo $_SESSION['EXITSdemoTour']="1";
                     $_SESSION['currenttour']="ExitsTour";
                    break;    
            case "Directory":
                 echo $_SESSION['DirectorydemoTour']="1";
                 $_SESSION['currenttour']="DirectoryTour";
                break;    
        }
        
}
else if($method=='unset'){
    
            $sql = "UPDATE `dealmembers` SET `tour`='1' WHERE `emailId` = '".$emailid."' ";
            $sqlres = mysql_query($sql) or die(mysql_error());            
            $_SESSION['EXITSdemoTour']="0";
            $_SESSION['DirectorydemoTour']="0";
            unset($_SESSION['currenttour']);
}


    

?>



