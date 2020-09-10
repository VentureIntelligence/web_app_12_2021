<?php include_once("../globalconfig.php"); ?>
<?php 
session_save_path("/tmp");
session_start();
//echo "cookie=".$_COOKIE['cfsLoginAuth'];
include "header.php";

require_once MODULES_DIR."users.php";
$users = new users();

require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
//print $msg = base64_encode(base64_encode('97.74.200.225')).','.base64_encode(base64_encode('moneytalks')).','.base64_encode(base64_encode('Tm8Pdb5'));

           
//exit;

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//pr($_POST);

$username = $_POST["username"];



$password = $_POST["user_password"];



$Rs = $users->selectByUsernameNew($username,$password);


if($username== "" && $password==""){
    $sesID=session_id();
    $ipadd = $_SERVER['REMOTE_ADDR'];
    $logintime=date("Y-m-d")." ".date("H:i:s");
    $splitIpAdd= explode(".", $ipadd);
    $splitIpAdd1=$splitIpAdd[0];
    $splitIpAdd2=$splitIpAdd[1];
    $splitIpAdd3=$splitIpAdd[2];
    $splitIpAdd4=$splitIpAdd[3];

    $splitIpAddress=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3.".";
    $splitIpAddress2=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3;

    //$checkForIPAddress="select * from ipAddress where ipaddress='$splitIpAddress'";
    $checkForIPAddress="SELECT ip.group_id, us.username, us.user_password, us.firstname,ip.StartRange,ip.EndRange
            FROM user_cfs_ipaddress AS ip, users AS us,grouplist as gl
            WHERE (ip.ipaddress='$splitIpAddress' OR ip.ipaddress='$splitIpAddress2') and gl.status=0
            AND us.GroupList = ip.group_Id and gl.Group_Id=us.GroupList";
         //echo "<br>---" .$checkForIPAddress;
         

    if($rsip=mysql_query($checkForIPAddress))
    {
        $ipcnt= mysql_num_rows($rsip);
        if($ipcnt >0)
        {
            While($myrowIP=mysql_fetch_array($rsip, MYSQL_BOTH))
            {
                    if(($splitIpAdd4>=$myrowIP["StartRange"]) && ($splitIpAdd4<=$myrowIP["EndRange"]))
                    {
                            $groupId=$myrowIP["group_id"];
                            $UName=$myrowIP["username"];
                            $Pwd=$myrowIP["user_password"];
                            $authAdmin = $users->selectByUName($UName);
                            $groupstatus = $grouplist->select($authAdmin['GroupList']);
                            $processLoginFlag = 1;
                    }
                    else
                    {	$displayMessage= "Login Error - aDevice not authorized. Please contact your administrator.";}
            }
        }else{
        
            $displayMessage= "Login Error - Device not authorized. Please contact your administrator.";
    }
       
    }
}
if(($username !='') && ($password !='')){
	$authAdmin = $users->selectByUName($username);
	$UName = $authAdmin['username'];
	$Pwd = $authAdmin['user_password'];
        
        $groupstatus = $grouplist->select($authAdmin['GroupList']);
        //pr($groupstatus);
	//pr($test);
//	pr($test['username']); //exit;
   
}



//echo $UName."====".$Pwd."====".$authAdmin['usr_flag']."===".$groupstatus['status'];die;
if($UName!='' && $Pwd!='' && $groupstatus['status']==0){
    
        //Added By JFR-KUTUNG 
        //print_r($myrow);
        $processLoginFlag = 0;
        
             
        //pr($authAdmin);
        
        //Check if a user has IP added
//        $user_Id = $authAdmin['user_id'];
//        $userIp = $users->getUserIP($user_Id);
        //pr($userIp);
        $groupId = $authAdmin['GroupList'];
        $groupIp = $grouplist->getGroupIP($groupId);
        
        
        
        $groupPocArray = $grouplist->getGroupEmail($groupId);
        $groupPoc = $groupPocArray['poc'];
        //echo "dddddddddddddddddddd".count($groupIp); exit;
        if (count($groupIp) > 0){ //Process IP Restriction only if user has IP addeded to account
            //Check if cookie exists //Check if the cookie still has access
            
            
            
             
            if (get_magic_quotes_gpc() == true) {
            foreach($_COOKIE as $key => $value) {
              $_COOKIE[$key] = stripslashes($value);
             }
           }
            $currCookie = $_COOKIE['cfsLoginAuth'];                                                       
            $currCookieArray=  json_decode($currCookie,true);
            $error = json_last_error();
            if($error!=JSON_ERROR_NONE)
            {
                $currCookieArray=array();
                $currUserCookie=$currCookie;
            }else{

                $currUserCookie=$currCookieArray[strtolower($authAdmin['email'])]; 

            }
            
          
            $sqlChkCookie = "SELECT `deviceId` FROM `userlog_device` WHERE `deviceId`='".$currUserCookie."' AND `EmailId`='".$authAdmin['email']."' AND `dbType`='CFS'";
            $resChkCookie = mysql_query($sqlChkCookie) or die(mysql_error());
            $cntChkCookie = mysql_num_rows($resChkCookie);
            
            
            
            if ($currUserCookie!='' && $cntChkCookie >= 1){
                //echo 'test1'; exit;
                                
                $processLoginFlag = 1;
                //echo 'login with cookie';exit;
            }else{
                //echo 'test2'; exit;
                //echo "remote >> $REMOTE_ADDR";
                if (checkIpRange($ipadd,$groupId)){ //Check if users Ip falls within the range
                    $processLoginFlag = 1;
                     $cookieName = 'CFS'.$authAdmin['firstname'].'-'.$authAdmin['user_id'].'-'.$groupstatus['G_'].rand();
                     
                        $currCookieArray[$authAdmin['email']]=$cookieName;
                        $currCookieJson=  json_encode($currCookieArray);
                        setcookie('cfsLoginAuth',$currCookieJson,time() + (86400 * 365),'/dev'); // 86400 = 1 day //Create Cookie  
                         //Store Cookie value in DB
                        $sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`,`auth_type`)";
                        $sqlInsCookie .= " VALUES ('".$authAdmin['email']."','".$cookieName."','0','CFS','1')";
                        mysql_query($sqlInsCookie) or die(mysql_error()); 
                    /*
                    //echo 'login with IP';
                    //Check for device limit and devices already used
                    $devicesUsed = getDevicesUsedCount($authAdmin['email'],'CFS');
                    if ($cntChkCookie==0)
                    if ($devicesUsed < $authAdmin['deviceCount']){

                        $cookieName = 'CFS'.$authAdmin['firstname'].'-'.$authAdmin['user_id'].'-'.rand();
                        $currCookieArray[$authAdmin['email']]=$cookieName;
                        $currCookieJson=  json_encode($currCookieArray);
                        setcookie('cfsLoginAuth',$currCookieJson,time() + (86400 * 365),'/dev'); // 86400 = 1 day //Create Cookie  

                        //Store Cookie value in DB
                        $sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`)";
                        $sqlInsCookie .= " VALUES ('".$authAdmin['email']."','".$cookieName."','0','CFS')";
                        mysql_query($sqlInsCookie) or die(mysql_error());
                        $processLoginFlag = 1;
                        //echo "Cookie Created and allowed login..";

                    }else{
                        $processLoginFlag = 0;

                        $displayMessage = "Login Error - You have exceeded the allowed number of devices from which you can login. Please contact us at info@ventureintelligence.com for more details";
                    }
                     
                     */

                }else{
                    //Display Message and Send email with auth code
                    $displayMessage = 'Login Error - Device not authorized. We have sent Authorization Code to your email address. <a href="auth.php">Click Here to Complete Authorization</a>';                    
                    $displayMessage2 = '<br><br><small style="color: #7b7c83;font-size: 12px;"><em>Please Note :</em> The authorization code is different from your password. Your password remains the same as previously.</small>';
                    
                   
                    sendAuthEmail($groupPoc,$authAdmin['GroupList'],$authAdmin['deviceCount'],$authAdmin['email']);
                    
                }

            }            
        }else{
            $processLoginFlag = 1;
            //echo "Login without restriction";
        }
        
        
        
        //END
    
        if ($processLoginFlag == 1){
            session_start();session_save_path("/tmp");
            $_SESSION['username'] = $UName;
             $_SESSION['loginusername'] = $UName;
            // testing
            $_SESSION['testusername'] = $UName;
            // end testing
            error_log('CFS user login success - '.$UName);
            $_SESSION["user_id"] =  $authAdmin['user_id'];
            $_SESSION["UserEmail"] =  $authAdmin['email'];
            $_SESSION["ipuser"] = '1';
            
            
            //Added by JFR-KUTUNG 
            //Check if user already has log
            if (get_magic_quotes_gpc() == true) {
            foreach($_COOKIE as $key => $value) {
              $_COOKIE[$key] = stripslashes($value);
             }
           }
                                                                   
            $deviceId = $_COOKIE['cfsLoginAuth'];
            $sqlUserLogSel = "SELECT `id` FROM `user_log` WHERE `emailId`='".$authAdmin['email']."' AND `dbTYpe`='CFS' AND `userId`='".$authAdmin['user_id']."'";
            $resUserLogSel = mysql_query($sqlUserLogSel);
            $cntUserLogSel = mysql_num_rows($resUserLogSel);
            $sesID=session_id();
            $_SESSION['CFSSession_id'] = $sesID;
            if ($cntUserLogSel==0){
                //Insert
                $sqlInsUserLog = "INSERT INTO `user_log` (`userId`,`emailId`,`deviceId`,`sessionId`,`dbTYpe`) VALUES ('".$authAdmin['user_id']."','".$authAdmin['email']."','".$deviceId."','".$sesID."','CFS')";
                $resInsUserLog = mysql_query($sqlInsUserLog);
            }else{
                //Update
                $resUserLogSel = mysql_fetch_row($resUserLogSel);
                $logId = $resUserLogSel[0];
                $sqlUpdUsrLog = "UPDATE `user_log` SET `sessionId` = '".$sesID."',`deviceId`='".$deviceId."' WHERE `id`='".$logId."'";
                $resUpdUsrLog = mysql_query($sqlUpdUsrLog);
            }
            //die;
            //header('location:http://www.ventureintelligence.com/dev/cfsnew/home.php') ;
            //echo $cntUserLogSel;die;
            
             if ($_SESSION['redirectURL']!=''){
                $tempUrl = $_SESSION['redirectURL'];
                $_SESSION['redirectURL'] = '';
                header("location:$tempUrl");
                }else
            {
                echo "<script language='javascript'>document.location.href='home.php'</script>";
            }
                exit();
        }
    
}
/*elseif(($username !='') && ($authAdmin['usr_flag'] == '0' ||  $groupstatus['status']!=0 )){
	//$template->assign("ErrMsg","Account Not Yet activated !");
        $displayMessage = 'Account Not Yet activated !';

}elseif(($username !='') && ($password !='')){
	//$template->assign("ErrMsg","Please check Username/Password you have given");
    $displayMessage = 'Please check Username/Password you have given';
}*/


/*function checkIpRange($REMOTE_ADDR,$userIp){
    $splitIpAdd= explode(".", $REMOTE_ADDR);
    $splitIpAdd1=$splitIpAdd[0];
    $splitIpAdd2=$splitIpAdd[1];
    $splitIpAdd3=$splitIpAdd[2];
    $splitIpAdd4=$splitIpAdd[3];
    $splitIpAddress=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3."";
    $splitIpAddress1=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3.".";
    
    if (($userIp['ipAddress']==$splitIpAddress || $userIp['ipAddress'] == $splitIpAddress1 ) && ($splitIpAdd4 >= $userIp['StartRange'] && $splitIpAdd4 <= $userIp['EndRange'])){
        return true;
    }else{
        return false;
    }
}*/


function checkIpRange($userCIp,$groupId){
    $splitIpAdd= explode(".", $userCIp);
    $splitIpAdd1=$splitIpAdd[0];
    $splitIpAdd2=$splitIpAdd[1];
    $splitIpAdd3=$splitIpAdd[2];
    $splitIpAdd4=$splitIpAdd[3];
    $splitIpAddress=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3."";
    $splitIpAddress1=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3.".";
    
    $checkForIPAddress="SELECT ip.* FROM user_cfs_ipaddress AS ip ";
    $checkForIPAddress.=" WHERE (ip.ipAddress='".$splitIpAddress."' OR ip.ipAddress='".$splitIpAddress1."') AND (ip.StartRange <= '".$splitIpAdd4."' AND ip.EndRange >= '".$splitIpAdd4."')" ;
    $checkForIPAddress.=" AND group_Id='".$groupId."'"; 
    //echo $checkForIPAddress;
    
    $result = mysql_query($checkForIPAddress) or die(mysql_error());
    $ipCount = mysql_num_rows($result);
    if ($ipCount > 0){
        return true;
    }else{
        return false;
    }
}




function getDevicesUsedCount($email,$db){
    $sqlCheckDevice = "SELECT `deviceId` FROM `userlog_device` WHERE `EmailId`='".$email."' AND `dbType`='".$db."'   AND auth_type='0' ";
    $resCheckDevice = mysql_query($sqlCheckDevice) or die(mysql_error());
    $cntCheckDevice = mysql_num_rows($resCheckDevice);
    return $cntCheckDevice;
}

function sendAuthEmail($poc,$groupId,$allowedDevices,$userEmail){
    //Generate Auth Code and Store it
    $authcode = 'CFS'.rand(); 
    $today = date('Y-m-d');
    $nextDate = date('Y-m-d', strtotime($date .' +3 day'));
    $sqlInsAuth = "INSERT INTO `user_auth_code` (`user_id`,`emailId`,`dbType`,`reqOn`,`authCode`,`expDate`,`status`) VALUES ('".$groupId."','".$userEmail."','CFS','".$today."','".$authcode."','".$nextDate."','Active')";
    $insResult = mysql_query($sqlInsAuth);
  
    $devicesUsed = getDevicesUsedCount($userEmail,'CFS');
    //Send Email
    
    $to    = $userEmail; 		
    //$to         = 'fidelis@kutung.com'; 		
    $from 	= 'info@ventureintelligence.in';               
    $subject 	= "Authorization Code for CFS Database(".$userEmail.")"; // Subject of the email

    //Message 
    $message 	= 'Authorization Code for CFS Database. Please find the details below:';

    $message 	.= "<p><b>User Email :</b> ".$userEmail."</p>";
    $message 	.= "<p><b>Authorization Code:</b> ".$authcode."</p>";
    $message 	.= "<p><b>Authorization Link:</b> <a href='".BASE_URL."cfsnew/auth.php'>".BASE_URL."cfsnew/auth.php</a></p>";
    $message 	.= "<p><b>Devices already in use:</b> ".$devicesUsed."</p>";
    $message 	.= "<p><b>Device Limit:</b> ".$allowedDevices."</p>";
     
    
    
    //$message 	.= "<p>System Note :Authorization will not be allowed if the device limit is exceeded.</p>";
    $message 	.= "<p>&nbsp;</p>";
    $message 	.= "<p>Thank you,<br><b>Venture Intelligence Support Team<br>Tel: +91-44-42185180</b></p>";
    $message 	.= "<br><p><small style=font-size:12px>Please add <i>info@ventureintelligence.com</i> to your email contact list to prevent emails getting delivered into Junk/Spam folder.</small></p>";
    

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n"; 
    $headers .= "Reply-To: $userEmail\r\n"; 

    if (@mail($to, $subject, $message, $headers)){
    }else{
    }
    
} 

if($_GET['flag']=='ca'){
    $displayMessage = 'You have been logged off as you had logged in to another device or browser.';
}

$auth = ($_GET['auth']=='1') ? 1 : 0;

$template->assign("auth",$auth);	
$template->assign("ErrMsg",$displayMessage);
$template->assign("ErrMsg2",$displayMessage2);
$template->assign('pageTitle',"CFS - Login");
$template->assign('pageDescription',"CFS - Login");
$template->assign('pageKeyWords',"CFS - Login");
$template->display('login.tpl');

mysql_close();

#82f26d#

#/82f26d#


?>