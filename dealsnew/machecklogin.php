<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
session_save_path("/tmp");
session_start();
ob_start();
$sesID=session_id();
$username=$_SESSION['MAUserNames'];
$emailid=$_SESSION['MAUserEmail'];
$UserEmail=$_SESSION['MAUserEmail'];
$companyId=632270771;
$compId=0;
if (!(session_is_registered("MAUserNames")) )
{
	header( 'Location: '. GLOBAL_BASE_URL .'dealsnew/malogin.php' ) ;
    die();
}

//Code to check access rights
$lgDealCompId = $_SESSION['DcompanyId'];
$usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
$usrRgres = mysql_query($usrRgsql) or die(mysql_error());
$usrRgs = mysql_fetch_array($usrRgres);
$accesserror=0;

if ($videalPageName != ''){
	$_SESSION['accesserrorpage']='';
	if ($usrRgs[$videalPageName]!=1 && $videalPageName != 'PMS'){
		$_SESSION['accesserrorpage'] = $videalPageName;
		$accesserror=1;
	}
	
	if ($videalPageName == 'PMS' && ($usrRgs['PEIpo']!=1 && $usrRgs['PEMa']!=1)){
		$_SESSION['accesserrorpage'] = $videalPageName;
		$accesserror=1;
	}
}
?>
