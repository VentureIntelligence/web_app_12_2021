<?php include_once("../globalconfig.php"); ?>
<?php
session_save_path("/tmp");
session_start();
//$sesID=session_id();
$sesID=$_SESSION['RESession_Id'];
$username=$_SESSION['REUserNames'];
$emailid=$_SESSION['REUserEmail'];
$ipadd=$_SESSION['REIP'];

if($_REQUEST['scr']=="EMAIL")
   $_SESSION['redirectURL'] = "HTTP://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
else    
   $_SESSION['redirectURL'] = '';

if (!isset($_SESSION['REUserNames']) )
{
    header( 'Location: '. GLOBAL_BASE_URL .'relogin.php' ) ;
    die();
}
else
{
    if($ipadd=="RIP")
        $logvar="RIP";
    else
        $logvar="R";
    

//Check Session Id 
//$deviceId = $_COOKIE['peLoginAuth'];
if ($_SESSION['student']==0){
    $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='RE'";
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

// if ($_SESSION['RE_EXPIRES'] < time()) {
//     unset($_SESSION['username']);
//         unset($_SESSION['type']);
//         unset($_SESSION["ipuser"]);
//         unset($_SESSION['UserNames']);
//         unset($_SESSION['MAUserNames']);
//         unset($_SESSION['REUserNames']);
//         unset($_SESSION['loginusername']);
//         unset($_SESSION['password']);  
//         session_destroy();
//         echo "<script type='text/javascript'> location.href='../relogin.php'; </script>";
// }
    
    //Code to check access rights
    $lgDealCompId = $_SESSION['REDcompanyId'];
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
    if($emailid=='ceo@makaanaurdukaan.com' || $emailid=='Spaggarwal2003@yahoo.com' || $emailid=='dangi_dhanvanti@hotmail.com' || $emailid=='deepak.patil@live.in' || $emailid=='deepak@plutuspro.com'){

        $accesserror=1;
        $accessdirectory=0;

    }
}
?>
