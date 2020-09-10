<?php include_once("../globalconfig.php"); ?>
<?php

	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
session_save_path("/tmp");
session_start();
//$sesID=session_id();
$sesID=$_SESSION['PESession_Id'];
$username=$_SESSION['UserNames'];
$emailid=$_SESSION['UserEmail'];
$UserEmail=$_SESSION['UserEmail'];


$companyId=632270771;
$compId=0;

//if (!(session_is_registered("UserNames")) )
//if ($_SESSION['UserNames']=="")

if($_REQUEST['scr']=="EMAIL")
   $_SESSION['pedirectURL'] = "HTTP://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
else    
   $_SESSION['pedirectURL'] = '';


if (!isset($_SESSION['UserNames']))
{

    if($_REQUEST['cfs']==1){
        
        header( 'Location: ' . BASE_URL . 'pelogin.php?value='.$_REQUEST['value'].'&cfs='.$_REQUEST['cfs'] ) ;

        die();
    }else{
        
        //echo BASE_URL . 'pelogin.php';
       /* header( 'Location: ' . BASE_URL . 'pelogin.php' ) ;*/
      /* echo "<script type='text/javascript'> document.location = '+BASE_URL+'pelogin.php'; </script>";*/
      echo "<script type='text/javascript'> location.href='../pelogin.php'; </script>";
         //header( "Location: https://www.ventureintelligence.asia/dev/pelogin.php" ) ;
        die();
    }
    
     
}

if(isset($_SESSION['PE_EXPIRES'])){
    if ($_SESSION['PE_EXPIRES'] < time()) {
        unset($_SESSION['UserNames']);
        unset($_SESSION['loginusername']);
        echo "<script type='text/javascript'> location.href='../pelogin.php'; </script>";
    }
}


//Check Session Id 
//$deviceId = $_COOKIE['peLoginAuth'];
if ($_SESSION['student']==0){
    $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='PE'";
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

//Code to check access rights
$lgDealCompId = $_SESSION['DcompanyId'];
$usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
$usrRgres = mysql_query($usrRgsql) or die(mysql_error());
$usrRgs = mysql_fetch_array($usrRgres);
$accesserror=0;
if ($videalPageName != ''){
   	$_SESSION['accesserrorpage']='';
	
       
                if ($usrRgs[$videalPageName]!=1 && $videalPageName != 'PMS' && $videalPageName != 'VCPMS' && $videalPageName != 'MAPM'){
                        $_SESSION['accesserrorpage'] = $videalPageName;
                       
                        $accesserror=1;
                        
                        
                }
       
	
	if ($videalPageName == 'PMS' && ($usrRgs['PEIpo']!=1 && $usrRgs['PEMa']!=1)){
		$_SESSION['accesserrorpage'] = $videalPageName;
        $accesserror=1;
        
	}
        
         if ($videalPageName == 'VCPMS' && ($usrRgs['VCIpo']!=1 && $usrRgs['VCma']!=1)){
		$_SESSION['accesserrorpage'] = $videalPageName;
        $accesserror=1;
        
    }
    if ($videalPageName == 'MAPM' && ($usrRgs['PEMa']!=1 && $usrRgs['VCma']!=1)){
		$_SESSION['accesserrorpage'] = $videalPageName;
        $accesserror=1;
        
	}
}



if($usrRgs['permission']==1){ 
    $_SESSION['peonly']=1;
    unset($_SESSION['vconly']);
}
else if($usrRgs['permission']==2){ 
    $_SESSION['vconly']=1;
    unset($_SESSION['peonly']);
}
else {
    unset($_SESSION['peonly']);
    unset($_SESSION['vconly']);
}

    ?>
