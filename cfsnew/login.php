<?php
if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}

//echo "cookie=".$_COOKIE['cfsLoginAuth'];
include "header.php";

require_once MODULES_DIR."users.php";
$users = new users();

require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
//print $msg = base64_encode(base64_encode('97.74.200.225')).','.base64_encode(base64_encode('moneytalks')).','.base64_encode(base64_encode('Tm8Pdb5'));
/*echo BASE_URL;
exit();
*/
//exit;

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//pr($_POST);

/*$username = $_POST["username"];
$password = $_POST["user_password"];*/
if(isset($_SESSION['loginusername']) && isset($_SESSION['password']) && $_POST["username"] == "" && $_POST["user_password"] == ""){
  
  $username = $_SESSION['loginusername'];
  $password  = $_SESSION['password'];

 }else{
  $username = $_POST["username"];
  $password = $_POST["user_password"]; 
  $_SESSION['loginusername'] = $username;
  $_SESSION['password'] = $password;
}


$Rs = $users->selectByUsernameNew($username,$password);


if(($username !='') && ($password !='')){
	$authAdmin = $users->selectByUName($username);
       
        if(!($authAdmin)){
            $authAdmin = $users->selectByEmail($username);
        }
	$UName = $authAdmin['username'];
	$Pwd = $authAdmin['user_password'];

        $groupstatus = $grouplist->select($authAdmin['GroupList']);
//        pr($authAdmin);
//        pr($groupstatus);
//	pr($test);
//	pr($test['username']); exit;

}else{
    $authAdmin = array();
}




if(($username == $UName ||  $username = $authAdmin['email'] ) && md5($password) == $Pwd && $username != "" && $password != "" && $authAdmin['usr_flag'] != 0 && $groupstatus['status']==0 && (strtotime($groupstatus['expiry_date'])=='' || $groupstatus['expiry_date']=="0000-00-00" || (strtotime($groupstatus['expiry_date']) >= strtotime(date('d-m-Y')))) ){
        //Added By JFR-KUTUNG
        //print_r($myrow);
        $processLoginFlag = 0;
        $device_authorized=0;
        $devicenotauthorized = 0;

//        pr($authAdmin);
//        exit();

        //Check if a user has IP added
//        $user_Id = $authAdmin['user_id'];
//        $userIp = $users->getUserIP($user_Id);
        //pr($userIp);
        $groupId = $authAdmin['GroupList'];
        $groupIp = $grouplist->getGroupIP($groupId);

      //  print_r($groupIp);

        $groupPocArray = $grouplist->getGroupEmail($groupId);
        $groupPoc = $groupPocArray['poc'];
        //echo "dddddddddddddddddddd".count($groupIp); exit;
        //if (count($groupIp) > 0){ //Process IP Restriction only if user has IP addeded to account
            //Check if cookie exists //Check if the cookie still has access
            if($authAdmin['user_authorized_status']==1){


                // NEW code for device restriction
                if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== FALSE){
                    $user_os =  'Windows';
                }elseif((strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== FALSE) && strpos($_SERVER['HTTP_USER_AGENT'], 'Linux')!==FALSE){
                    $user_os = 'Android';
                }elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Linux') !== FALSE) //For Supporting IE 11
                   { $user_os =  'Linux';}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== FALSE)
                  {  $user_os = 'IOS';}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE)
                   { $user_os = 'IOS';}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== FALSE)
                   { $user_os = 'iOS';}
                else{$user_os =  'Windows';}
            
               
              if($user_os=='IOS'){      

                  if(strpos($_SERVER['HTTP_USER_AGENT'], 'FxiOS') !== FALSE)
                      $user_browser = 'Firefox';
                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== FALSE)
                      $user_browser = 'Chrome';
                  else
                      $user_browser = "Safari";
              }else{

                if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
                {$user_browser =  'IE';}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
                    {$user_browser =  'IE';}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== FALSE) //For Supporting IE EDGE
                    {$user_browser =  'IE';}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
                    {$user_browser = 'Firefox';}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
                    {$user_browser = 'Chrome';}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
                    {$user_browser = "Opera_Mini";}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
                    {$user_browser = "Opera";}
                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
                    {$user_browser = "Safari";}
                else{$user_browser = 'Chrome';}
              }

                /* echo $_SERVER['HTTP_USER_AGENT'];
                 echo $user_os;
                 echo $user_browser;*/

                $exp_user = explode(' ',$_SERVER['HTTP_USER_AGENT']);
                 /*print_r($exp_user);*/

                if($user_os=='IOS'){

                    $searchKey = search_array($exp_user, 'Mobile');
                    $deviceId = str_replace('/', '_', $exp_user[$searchKey]);
                }else{

                    $searchKey = search_array($exp_user, $user_browser);
                    $deviceId = str_replace('/', '_', $exp_user[$searchKey]);
                }

                $device_details = $user_os."_".$user_browser."_".$deviceId;
                $os_browser=$user_os."_".$user_browser;

                $sqlChkdevice = "SELECT * FROM `user_authorized_device` WHERE `user_email`= '".$authAdmin['username']."' and `device_details` LIKE '".$os_browser."%' and `status`=1";
                $resChkdevice = mysql_query($sqlChkdevice) or die(mysql_error());
                $cntChkdevice = mysql_num_rows($resChkdevice);

                include "cookieconfigCFS.php";
                
                if($cntChkdevice > 0){

                    $processLoginFlag=1;
                }else{

                    $sqlChkdevices = "SELECT * FROM `user_authorized_device` WHERE `user_email`='".$authAdmin['username']."' ";
                    $resChkdevices = mysql_query($sqlChkdevices) or die(mysql_error());

                    // Same device validate
                    $myrow_valid=mysql_fetch_array($resChkdevices);
                    $Firstrowvalue = $myrow_valid[2];
                    while($myrow_valid=mysql_fetch_row($resChkdevices)){
                            $Secondrowvalue = $myrow_valid[2];
                    }
                    $selected_first_row = explode("_",$Firstrowvalue);
                    $selected_second_row = explode("_",$Secondrowvalue);
                    $selected_first_row_device = $selected_first_row[0].'_'.$selected_first_row[1];
                    $selected_second_row_device = $selected_second_row[0].'_'.$selected_second_row[1];

                    if($selected_first_row_device == $selected_second_row_device){
                        $cntChkdevice = 1;
                    }else{
                        $cntChkdevice = mysql_num_rows($resChkdevices);
                    }
                // End Same device validate

                    // $cntChkdevice = mysql_num_rows($resChkdevices);
                    if($cntChkdevice >= 2){
                        $device_list_flag=true;
                       // $displayMessage = 'Login Error - Three devices already exist for this User. To add the new device need to deauthorized one of the device. <a style="font-size:14px;font-weight:bold;cursor:pointer;text-decoration:none !important" id="deviceauth">Click here to complete authorization.</a>';

                    }else{

                        $sqlnewdevice = "insert into user_authorized_device (`user_email`,`device_details`,`status`) values ('".$authAdmin['username']."','".$device_details."',1)";
                        $resChkdevice = mysql_query($sqlnewdevice) or die(mysql_error());
                        

                        $processLoginFlag=1;

                    }

                }

            }else{
                $displayMessage = 'Login Error - Device not authorized. We have sent Authorization Code to your email address. <a href="' . BASE_URL . 'cfsnew/auth.php">Click Here to Complete Authorization</a>';
                $displayMessage2 = '<br><br><small style="color: #7b7c83;font-size: 12px;"><em>Please Note :</em> The authorization code is different from your password. Your password remains the same as previously.</small>';

                sendAuthEmail($groupPoc,$authAdmin['GroupList'],$authAdmin['deviceCount'],$authAdmin['username']);
            }

           /* if (get_magic_quotes_gpc() == true) {
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

           if($device_authorized){

            $sqlChkCookie = "SELECT `deviceId` FROM `userlog_device` WHERE `deviceId`='".$currUserCookie."' AND `EmailId`='".$authAdmin['email']."' AND `dbType`='CFS'";
            $resChkCookie = mysql_query($sqlChkCookie) or die(mysql_error());
            $cntChkCookie = mysql_num_rows($resChkCookie);

            if ($currUserCookie!='' && $cntChkCookie >= 1){
                //echo 'test1'; exit;
                $processLoginFlag = 1;
                //echo 'login with cookie';exit;
            }else{
                //echo 'test2'; exit;
             //   echo "remote >> $REMOTE_ADDR";
                if (checkIpRange($REMOTE_ADDR,$groupId)){ //Check if users Ip falls within the range      //un commend this line
               // $test = 0;  //commend this line
                //if ($test ==0){     //commend this line
                    $processLoginFlag = 1;
                     $cookieName = 'CFS'.$authAdmin['firstname'].'-'.$authAdmin['user_id'].'-'.rand();
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
               /* }else{
                    //Display Message and Send email with auth code
                    $displayMessage = 'Login Error - Device not authorized. We have sent Authorization Code to your email address. <a href="' . BASE_URL . 'cfsnew/auth.php">Click Here to Complete Authorization</a>';
                    $displayMessage2 = '<br><br><small style="color: #7b7c83;font-size: 12px;"><em>Please Note :</em> The authorization code is different from your password. Your password remains the same as previously.</small>';

                    sendAuthEmail($groupPoc,$authAdmin['GroupList'],$authAdmin['deviceCount'],$authAdmin['email']);

                }

            }
            
        }else{
                if($devicenotauthorized){
                     $displayMessage = 'Login Error - Two devices already Exist for the User. To add the new device need to deauthorized one of the device. <a id="deviceauth">Please click Here</a>';
                }else{
                    $displayMessage = 'Login Error - Device not authorized. Please contact your administrator.</a>';
                }
            }*/
        // }else{
        //     $processLoginFlag = 1;
        //     //echo "Login without restriction";
        // }



        //END

        if ($processLoginFlag == 1){
            
            $_SESSION['loginusername'] = $_SESSION['username'] = $UName;
            $_SESSION["user_id"] =  $authAdmin['user_id'];
            $_SESSION["UserEmail"] =  $authAdmin['email'];
            $_SESSION["type"] = 'C';
            $_SESSION['EXPIRES'] = time() + 3600;

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


             if ($_SESSION['redirectURL']!=''){
                $tempUrl = $_SESSION['redirectURL'];
                $_SESSION['redirectURL'] = '';
                header("location:$tempUrl");
            }else if($_REQUEST['pe']==1){
                
                echo "<script language='javascript'>document.location.href='".BASE_URL."cfsnew/details.php?vcid=".$_REQUEST['vcid']."'</script>";
            }else
            {
                
                
                    echo "<script language='javascript'>document.location.href='home.php'</script>";
                
            }
                exit();
        }

}
elseif(($username !='')  && (md5($password) == $Pwd) && ($authAdmin['usr_flag'] == '0' ||  $groupstatus['status']==1 ) && ($groupstatus['expiry_date']=='' || strtotime($groupstatus['expiry_date']) >= strtotime(date('d-m-Y')))){
	//$template->assign("ErrMsg","Account Not Yet activated !");
        $displayMessage = 'Account Not Yet activated !';

}elseif(($username !='') && (md5($password) == $Pwd)  && (strtotime($groupstatus['expiry_date']) <= strtotime(date('d-m-Y')))){
	//$template->assign("ErrMsg","Account Not Yet activated !");
        $displayMessage = 'Your login has expired. Please contact renewal@ventureintelligence.com';

}elseif( ($_POST['username'] && $_POST["user_password"] && ( (count($authAdmin) == 1 &&  count($groupstatus) == 0 ) || (md5($password) != $Pwd)))){

    $displayMessage = 'Please check Username/Password you have given';
}else{

    if($_POST && ($username =='' || $password =='')){
        
        $displayMessage = 'Please enter username and password !';
}
}


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
  //  echo $checkForIPAddress;

    $result = mysql_query($checkForIPAddress) or die(mysql_error());
    $ipCount = mysql_num_rows($result);
    if ($ipCount > 0){
        return true;
    }else{
        return false;
    }
}

/*function getDevicesUsedCount($email,$db){
    $sqlCheckDevice = "SELECT `deviceId` FROM `userlog_device` WHERE `EmailId`='".$email."' AND `dbType`='".$db."'   AND auth_type='0' ";
    $resCheckDevice = mysql_query($sqlCheckDevice) or die(mysql_error());
    $cntCheckDevice = mysql_num_rows($resCheckDevice);
    return $cntCheckDevice;
}*/

function getDevicesUsedCount($email){
    $sqlCheckDevice = "SELECT `id` FROM `user_authorized_device` WHERE `user_email`='".$email."'  AND status=1 ";
    $resCheckDevice = mysql_query($sqlCheckDevice) or die(mysql_error());
    $cntCheckDevice = mysql_num_rows($resCheckDevice);
    return $cntCheckDevice;
}

function search_array ( array $array, $term )
{
    foreach ( $array as $key => $value )
        if ( stripos( $value, $term ) !== false )
            return $key;

    return false;
}

function sendAuthEmail($poc,$groupId,$allowedDevices,$userEmail){
    //Generate Auth Code and Store it
    $authcode = 'CFS'.rand();
    $today = date('Y-m-d');
    $nextDate = date('Y-m-d', strtotime($date .' +3 day'));
    $sqlInsAuth = "INSERT INTO `user_auth_code` (`user_id`,`emailId`,`dbType`,`reqOn`,`authCode`,`expDate`,`status`) VALUES ('".$groupId."','".$userEmail."','CFS','".$today."','".$authcode."','".$nextDate."','Active')";
    $insResult = mysql_query($sqlInsAuth);

    $devicesUsed = getDevicesUsedCount($userEmail);
    //Send Email

    $to    = $userEmail;
    //$to         = 'fidelis@kutung.com';
    //$from 	= 'info@ventureintelligence.com';
    $from 	= 'subscription@ventureintelligence.in';
    $subject 	= "Authorization Code for CFS Database(".$userEmail.")"; // Subject of the email
    //Message
    $message 	= 'Authorization Code for CFS Database. Please find the details below:';
    $message 	.= "<p><b>User Email :</b> ".$userEmail."</p>";
    $message 	.= "<p><b>Authorization Code:</b> ".$authcode."</p>";
    $message 	.= "<p><b>Authorization Link:</b> <a href='".BASE_URL."cfsnew/auth.php'>".BASE_URL."cfsnew/auth.php</a></p>";
//    $message 	.= "<p><b>Devices already in use:</b> ".$devicesUsed."</p>";
//    $message 	.= "<p><b>Device Limit:</b> ".$allowedDevices."</p>";



    //$message 	.= "<p>System Note :Authorization will not be allowed if the device limit is exceeded.</p>";
    $message 	.= "<p>&nbsp;</p>";
    $message 	.= "<p>Thank you,<br><b>Venture Intelligence Support Team<br>Tel: +91-44-42185180</b></p>";
    $message 	.= "<br><p><small style=font-size:12px>Please add <i>subscription@ventureintelligence.com</i> to your email contact list to prevent emails getting delivered into Junk/Spam folder.</small></p>";


    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n";
    $headers .= "Reply-To: no-reply@ventureintelligence.com\r\n";
    $headers .= 'Cc: subscription@ventureintelligence.com' . "\r\n";
  
    if (@mail($to, $subject, $message, $headers)){
    }else{
    }

}

if($_GET['flag']=='ca'){
    $displayMessage = 'You have been logged off as you had logged in to another device or browser.';
}

$auth = ($_GET['auth']=='1') ? 1 : 0;


$sqlChkdevices = "SELECT * FROM `user_authorized_device` WHERE `user_email`='".$_POST["username"]."'";
$resChkdevices1 = mysql_query($sqlChkdevices) or die(mysql_error());
$devices_array=[];
$device_array_items=[];

While($myrow=mysql_fetch_array($resChkdevices1, MYSQL_BOTH))
{ 
  $device_array_items[]= $myrow; 
} 
$count=count($device_array_items)-2;
$arraydel=array_splice($device_array_items, 0, $count);
            
foreach ($arraydel as $item) {
  $itemid=$item['id'];    
  $checkdevices = "DELETE FROM `user_authorized_device` WHERE id='$itemid'";
  mysql_query($checkdevices);
}

$resChkdevices = mysql_query($sqlChkdevices) or die(mysql_error());

While($myrow=mysql_fetch_array($resChkdevices, MYSQL_BOTH))
{
    $devices_array[]= $myrow;
    $devices_array_list[]= $myrow["device_details"];
}

if (isset($_SERVER['HTTP_USER_AGENT'])) {
if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== FALSE){
    $user_os =  'Windows';
}elseif((strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== FALSE) && strpos($_SERVER['HTTP_USER_AGENT'], 'Linux')!==FALSE){
    $user_os = 'Android';
}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Linux') !== FALSE) //For Supporting IE 11
   { $user_os =  'Linux';}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== FALSE)
  {  $user_os = 'IOS';}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE)
   { $user_os = 'IOS';}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== FALSE)
   { $user_os = 'iOS';}
else{$user_os =  'Windows';}
}else{$user_os =  'Windows';}

if($user_os=='IOS'){      

  if(strpos($_SERVER['HTTP_USER_AGENT'], 'FxiOS') !== FALSE)
      $user_browser = 'Firefox';
  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== FALSE)
      $user_browser = 'Chrome';
  else
      $user_browser = "Safari";
}else{
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
    {$user_browser =  'IE';}
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
        {$user_browser =  'IE';}
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== FALSE) //For Supporting IE EDGE
        {$user_browser =  'IE';}
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
        {$user_browser = 'Firefox';}
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
        {$user_browser = 'Chrome';}
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
        {$user_browser = "Opera_Mini";}
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
        {$user_browser = "Opera";}
    elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
        {$user_browser = "Safari";}
    else{$user_browser = 'Chrome';}
} else{$user_browser = 'Chrome';}
}


   /* echo $_SERVER['HTTP_USER_AGENT'];
    echo $user_os;
    echo $user_browser;*/

$exp_user = explode(' ',$_SERVER['HTTP_USER_AGENT']);
 /*print_r($exp_user);*/

if($user_os=='IOS'){

    $searchKey = search_array($exp_user, 'Mobile');
    $deviceId = str_replace('/', '_', $exp_user[$searchKey]);
}else{

    $searchKey = search_array($exp_user, $user_browser);
    $deviceId = str_replace('/', '_', $exp_user[$searchKey]);
}

$device_details = $user_os."_".$user_browser."_".$deviceId;

    $template->assign("devices_array",$devices_array);
    $template->assign("device_details",$device_details);
    $template->assign("user_browser",$user_browser);
    $template->assign("devices_array_list",$devices_array_list); 
    $template->assign("emailid",$_POST["username"]);
    $template->assign("emailpassword",$_POST["user_password"]);
    $template->assign("auth",$auth);
    $template->assign("ErrMsg",$displayMessage);
    $template->assign("ErrMsg2",$displayMessage2);
    $template->assign('pageTitle',"Private Company Financials Database - Login");
    $template->assign('pageDescription',"CFS - Login");
    $template->assign('pageKeyWords',"CFS - Login");
    $template->assign("device_list_flag",$device_list_flag);
    $template->display('login.tpl'); 

mysql_close();

#82f26d#

#/82f26d#


?>