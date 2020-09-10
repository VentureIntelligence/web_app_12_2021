<?php include_once("../globalconfig.php"); ?>
<?php

if($_REQUEST['scr']=="EMAIL")
{$_SESSION['redirectURL'] = "HTTP://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

}
else    
   $_SESSION['redirectURL'] = '';

if($_SESSION['username']==''){
    
        if($_REQUEST['pe']==1){
            echo "<script language='javascript'>document.location.href='login.php?vcid=".$_REQUEST['vcid']."&pe=1'</script>";
            exit();
        }else{
            echo "<script language='javascript'>document.location.href='login.php'</script>";
            exit();
        }
 }else{
     if($_REQUEST['pe']==1){
            echo "<script language='javascript'>document.location.href='<?php echo GLOBAL_BASE_URL; ?>cfsnew/details.php?vcid=".$_REQUEST['vcid']."'</script>";
            exit();
        }
 }
 
 
 if($_SESSION['username']!=$_SESSION['loginusername']) { error_log('Username mismatch in sessauth -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }

if(isset($_SESSION['EXPIRES'])){
    if ($_SESSION['EXPIRES'] < time()) {
        unset($_SESSION['username']);
        unset($_SESSION['loginusername']);
        unset($_SESSION['type']);
        header('Location: login.php');
    }
}
 
 /*if($_GET['session']){
     
        $user_id = $_SESSION['user_id'];
        $sesID=session_id();
       echo $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `userId`='".$user_id."' AND `dbTYpe`='CFS'";
        $resUserLogSel = mysql_query($sqlUserLogSel);
        $cntUserLogSel = mysql_num_rows($resUserLogSel);
        if ($cntUserLogSel > 0){
            $resUserLogSel = mysql_fetch_array($resUserLogSel);
            echo "Ddddddddddddddd".$logSessionId = $resUserLogSel['sessionId'];
            exit();
            if ($logSessionId != $_SESSION['CFSSession_id']){
                session_unset('CFSSession_id');
                session_unset('username');
                header( 'Location: login.php?flag=ca' ) ;
                exit;
            }
        }
        exit();
}*/
 //Check Session Id 
$user_id = $_SESSION['user_id'];
$sesID=session_id();
$sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `userId`='".$user_id."' AND `dbTYpe`='CFS'";
$resUserLogSel = mysql_query($sqlUserLogSel);
$cntUserLogSel = mysql_num_rows($resUserLogSel);
if ($cntUserLogSel > 0){
    $resUserLogSel = mysql_fetch_array($resUserLogSel);
    $logSessionId = $resUserLogSel['sessionId'];
    if ($logSessionId != $_SESSION['CFSSession_id']){
        session_unset('CFSSession_id');
        session_unset('username');
        header( 'Location: login.php?flag=ca' ) ;
        exit;
    }
}
 mysql_close();
 ?>