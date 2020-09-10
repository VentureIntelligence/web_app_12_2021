<?php include_once("../globalconfig.php"); ?>
<?php
session_save_path("/tmp");
session_start();
//$sesID=session_id();
$sesID=$_SESSION['MASession_Id'];
$username=$_SESSION['MAUserNames'];
$emailid=$_SESSION['MAUserEmail'];
$UserEmail=$_SESSION['MAUserEmail'];
$companyId=632270771;
$compId=0;

if($_REQUEST['scr']=="EMAIL")
   $_SESSION['madirectURL'] = "HTTP://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
else    
   $_SESSION['madirectURL'] = '';

if (!isset($_SESSION['MAUserNames']) )
{
	header( 'Location: '. GLOBAL_BASE_URL .'malogin.php' ) ;
        die();
}
//Code to check access rights
$lgDealCompId = $_SESSION['MADcompanyId'];
$usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
$usrRgres = mysql_query($usrRgsql) or die(mysql_error());
$usrRgs = mysql_fetch_array($usrRgres);
$accesserror=0;

//  if ($_SESSION['MA_EXPIRES'] < time()) {
//         unset($_SESSION['username']);
//         unset($_SESSION['type']);
//         unset($_SESSION["ipuser"]);
//         unset($_SESSION['UserNames']);
//         unset($_SESSION['MAUserNames']);
//         unset($_SESSION['REUserNames']);
//         unset($_SESSION['loginusername']);
//         unset($_SESSION['password']);  
//         session_destroy();
//         echo "<script type='text/javascript'> location.href='../malogin.php'; </script>";
// }

//Check Session Id 
//$deviceId = $_COOKIE['peLoginAuth'];
if ($_SESSION['student']==0){
    $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='MA'";
    $resUserLogSel = mysql_query($sqlUserLogSel);
    $cntUserLogSel = mysql_num_rows($resUserLogSel);
    if ($cntUserLogSel > 0){
        $resUserLogSel = mysql_fetch_array($resUserLogSel);
        $logSessionId = $resUserLogSel['sessionId'];
        if ($logSessionId != $sesID){
            header( 'Location: logoff.php?value=caccess' ) ;
        }
    }    
}


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
