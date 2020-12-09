<?php include_once("globalconfig.php"); ?>
<?php
/*
	filename - pelogin.php
    formanme - pelogin
    invoked from -  direct from website link
    invoked to - peauthenticate.php
  */
  //setcookie("TCook");
require("dbconnectvi.php");
$Db = new dbInvestments();
$Db->dbInvestments();
session_save_path("/tmp");
session_start();
$displayMessage="";
include "onlineaccount.php";
global $LoginAccess;
global $LoginMessage;
global $TrailExpired;

if(isset($_SESSION['loginusername'])&& isset($_SESSION['password']) && $_POST["emailid"] == "" && $_POST["emailpassword"] == ""){
  
  $login = $_SESSION['loginusername'];
  $pwd  = $_SESSION['password'];

 }else{
    $login=$_POST['emailid'];
    $login=trim($login);
    $pwd=$_POST['emailpassword'];
    $_SESSION['loginusername'] = $login;
    $_SESSION['password'] = $pwd;
}

/*$login=$_POST['emailid'];
$login=trim($login);
$pwd=$_POST['emailpassword'];*/
$pwd=md5(trim($pwd));
if((trim($login)!= "") && (trim($pwd)!=""))
{
    if (get_magic_quotes_gpc() == true) {
        foreach($_COOKIE as $key => $value) {
            $_COOKIE[$key] = stripslashes($value);
        }
    }
                                            //session_regenerate_id();
    $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
    $sesID=session_id();
    $ipadd=@$REMOTE_ADDR;
	//echo "<Br>---Session id create-" .$sesID;
    $logintime=date("Y-m-d")." ".date("H:i:s");
    $LogIntimeSql="insert into dealLog(LogSessionID,EmailId,LoggedIn,IpAdd,PE_MA) values('$sesID','$login','$logintime','$ipadd',0)";

    //	if($logrs=mysql_query($LogIntimeSql))
    //	{
    //	}

    $checkForUnknownLoginSql="select * from dealmembers where EmailId='$login'";
    if($rsRandom=mysql_query($checkForUnknownLoginSql))
    {
        $random_cnt= mysql_num_rows($rsRandom);
    }
    //echo "<bR>****".$random_cnt;
    if($random_cnt==1)
    {
        /*$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
                       dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
                       dm.EmailId='$login' and dm.Passwrd='$pwd'
                       AND dc.Deleted =0  and dc.IPAdd=0 ";*/

            $checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate,dc.IPAdd,dm.deviceCount,dm.exportLimit,dc.Student,dc.permission,dc.TrialLogin,dm.user_authorization_status,dc.peindustries FROM dealmembers AS dm,
            dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND dm.EmailId='$login' and dm.Passwrd='$pwd' AND dc.Deleted =0";
            
	//	echo "<bR>--".$checkUserSql;
        if ($totalrs = mysql_query($checkUserSql))
        {
            $cnt= mysql_num_rows($totalrs);
            if ($cnt==1)
            {
                While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
                {
                    //Added By JFR-KUTUNG
                    //print_r($myrow);
                    $processLoginFlag = 0;
                        $device_authorized=0;
                        $devicenotauthorized = 0;
                    $currCookie = $_COOKIE['peLoginAuth'];
                    //print_r($currCookie );
                    $currCookieArray=  json_decode($currCookie,true);
                   // print_r($currCookieArray);

                    $error = json_last_error();
                    //print_r($error);
                    if($error!=JSON_ERROR_NONE)
                    {
                        $currCookieArray=array();
                        $currUserCookie=$currCookie;
                    }else{

                        $currUserCookie=$currCookieArray[strtolower($myrow['EmailId'])];

                    }
                    if ($myrow['IPAdd']==1){//If IPADD process IP Restriction

                            if($myrow['user_authorization_status']==1){
                                 
                        //Check if cookie exists //Check if the cookie still has access
                            //$currCookie = $_COOKIE['peLoginAuth'];
                                if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== FALSE)
                                    $user_os =  'Windows';
                                elseif((strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== FALSE) && strpos($_SERVER['HTTP_USER_AGENT'], 'Linux')!==FALSE)
                                    $user_os = 'Android';
                                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Linux') !== FALSE) //For Supporting IE 11
                                    $user_os =  'Linux';
                                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== FALSE)
                                    $user_os = 'IOS';
                                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE)
                                    $user_os = 'IOS';
                                elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== FALSE)
                                    $user_os = 'iOS';

                              if($user_os=='IOS'){      

                                  if(strpos($_SERVER['HTTP_USER_AGENT'], 'FxiOS') !== FALSE)
                                      $user_browser = 'Firefox';
                                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== FALSE)
                                      $user_browser = 'Chrome';
                                  else
                                      $user_browser = "Safari";
                              }else{

                                  if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
                                      $user_browser =  'IE';
                                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
                                      $user_browser =  'IE';
                                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== FALSE) //For Supporting IE EDGE
                                      $user_browser =  'IE';
                                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
                                      $user_browser = 'Firefox';
                                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
                                      $user_browser = 'Chrome';
                                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
                                      $user_browser = "Opera_Mini";
                                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
                                      $user_browser = "Opera";
                                  elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
                                      $user_browser = "Safari";
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
                            
                            $sqlChkdevice = "SELECT * FROM `user_authorized_device` WHERE `user_email`= '".$myrow['EmailId']."' and `device_details` LIKE '".$os_browser."%' and `status`=1";
                            $resChkdevice = mysql_query($sqlChkdevice) or die(mysql_error());
                            $cntChkdevice = mysql_num_rows($resChkdevice);
                        
                            include "cookieconfig.php";

                            if($cntChkdevice > 0){
                                
                                // $sqlnewdevice = "update user_authorized_device set `status`=1, `device_details`='".$device_details."' where user_email=".$myrow['EmailId']." and device_details like '".$os_browser."%'";
                                // mysql_query($sqlnewdevice);
                               $processLoginFlag=1;
                            }else{
                                
                                $sqlChkdevices = "SELECT * FROM `user_authorized_device` WHERE `user_email`='".$myrow['EmailId']."' limit 2";
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
                                //print_r($selected_first_row_device);
                                
                                //echo $cntChkdevice;
                                if($cntChkdevice >= 2){
                                   $device_list_flag=true;
                                   // $displayMessage = 'Login Error - Three devices already exist for this User. To add the new device need to deauthorized one of the device. <a style="font-size:14px;font-weight:bold;cursor:pointer;text-decoration:none !important" id="deviceauth">Click here to complete authorization.</a>';
                                    
                                }else{
                                    
                                    $sqlnewdevice = "insert into user_authorized_device (`user_email`,`device_details`,`status`) values ('".$myrow['EmailId']."','".$device_details."',1)";
                                    $resChkdevice = mysql_query($sqlnewdevice) or die(mysql_error());
                                    
                                     $processLoginFlag=1;
                                    
                                }
                                
                            }
                            
                            
                          /*  if($device_authorized){
                            
                       $sqlChkCookie = "SELECT `deviceId` FROM `userlog_device` WHERE `deviceId`='".$currUserCookie."' AND `EmailId`='".$myrow['EmailId']."' AND `dbType`='PE'";
                        $resChkCookie = mysql_query($sqlChkCookie) or die(mysql_error());
                        $cntChkCookie = mysql_num_rows($resChkCookie);

                        if ($currUserCookie!='' && $cntChkCookie >= 1 && $myrow['Student']==0){
                            $processLoginFlag = 1;
                            //echo 'login with cookie';
                        }else{

                            if (checkIpRange($REMOTE_ADDR,$myrow['DCompId'])){ //Check if users Ip falls within the range  //un commend this line
                            //$test = 0;  //commend this line
                            //if ($test ==0){     //commend this line
                                $processLoginFlag = 1;
                                 $cookieName = 'PE'.$myrow['Name'].'-'.$myrow['DCompId'].'-'.rand();
                                    $currCookieArray[$myrow['EmailId']]=$cookieName;
                                    $currCookieJson=  json_encode($currCookieArray);
                                    setcookie('peLoginAuth',$currCookieJson,time() + (86400 * 365),'/'); // 86400 = 1 day //Create Cookie
                                    //Store Cookie value in DB
                                    $sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`,`auth_type`)";
                                    $sqlInsCookie .= " VALUES ('".$myrow['EmailId']."','".$cookieName."','".$myrow['DCompId']."','PE','1')";
                                    mysql_query($sqlInsCookie) or die(mysql_error());

                                    /*
                                    //echo 'login with IP';
                                    //Check for device limit and devices already used
                                    $devicesUsed = getDevicesUsedCount($myrow['EmailId'],'PE');
                                    if ($cntChkCookie==0)
                                    if ($devicesUs$displayMessage2ed < $myrow['deviceCount']){

                                        $cookieName = 'PE'.$myrow['Name'].'-'.$myrow['DCompId'].'-'.rand();
                                        $currCookieArray[$myrow['EmailId']]=$cookieName;
                                        $currCookieJson=  json_encode($currCookieArray);
                                        setcookie('peLoginAuth',$currCookieJson,time() + (86400 * 365),'/'); // 86400 = 1 day //Create Cookie

                                        //Store Cookie value in DB
                                        $sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`)";
                                        $sqlInsCookie .= " VALUES ('".$myrow['EmailId']."','".$cookieName."','".$myrow['DCompId']."','PE')";
                                        mysql_query($sqlInsCookie) or die(mysql_error());
                                        $processLoginFlag = 1;
                                        //echo "Cookie Created and allowed login..";

                                    }else if ($myrow['Student']==1){
                                        $processLoginFlag = 1;
                                    }else{
                                        $processLoginFlag = 0;

                                        $displayMessage = "Login Error - You have exceeded the allowed number of devices from which you can login. Please contact us at info@ventureintelligence.com for more details";
                                    }

                                     /////////////////////////////////////////////

                                }else{
                                        if ($myrow['Student']==0){
                                            //Display Message and Send email with auth code
                                            $displayMessage = 'Login Error - Device not authorized.We have sent Authorization Code to your email address. <a href="' . BASE_URL . 'dealsnew/auth.php">Click Here to Complete Authorization</a>';
                                            $displayMessage2 = '<br><br><small style="color: #7b7c83;"><em>Please Note :</em> The authorization code is different from your password. Your password remains the same as previously.</small>';
                                            if( date('Y-m-d')<=$myrow["ExpiryDate"])
                                                sendAuthEmail($myrow['DCompId'],$myrow['EmailId'],$myrow['deviceCount']);
                                            else
                                                $displayMessage = $TrialExpired;
                                        }else{
                                            $displayMessage = 'Login Error - Device not authorized. Please contact your administrator.</a>';
                                        }
                                }

                            }
                        }else{
                                if($devicenotauthorized){
                                     $displayMessage = 'Login Error - Two devices already Exist for the User. To add the new device need to deauthorized one of the device. <a id="deviceauth">Please click Here</a>';
                                }else{
                                    $displayMessage = 'Login Error - Device not authorized. Please contact your administrator.</a>';
                                }
                            }*/
                            }else{
                                
                                $displayMessage = 'Login Error - Device not authorized.We have sent Authorization Code to your email address. <a href="' . BASE_URL . 'dealsnew/auth.php">Click Here to Complete Authorization</a>';
                                $displayMessage2 = '<br><br><small style="color: #7b7c83;"><em>Please Note :</em> The authorization code is different from your password. Your password remains the same as previously.</small>';
                                if( date('Y-m-d')<=$myrow["ExpiryDate"])
                                    sendAuthEmail($myrow['DCompId'],$myrow['EmailId'],$myrow['deviceCount']);
                                else
                                    $displayMessage = $TrialExpired;
                            }
                        }else{
                            $processLoginFlag = 1;
                            //echo "Login without restriction";
                        }
                        
                                                                    //END


                        if ($processLoginFlag==1){

                            if( date('Y-m-d')<=$myrow["ExpiryDate"])
                            {
                                session_register("UserNames");
                                session_register("UserEmail");
                                session_register("LastActivity");
                                session_register("LoginTime");
                                $username=trim($myrow["Name"]);
                                $_SESSION['UserNames']=$username;
                                $_SESSION['UserEmail']=$myrow["EmailId"];
                                $_SESSION['DcompanyId']=$myrow["DCompId"];
                                $_SESSION["type"] = 'P';
                                $_SESSION['student']=$myrow["Student"];
                                $_SESSION['LastActivity']=time();
                                $_SESSION['LoginTime']=$logintime;
                                $_SESSION['PESession_Id']=$sesID;
                                $_SESSION['PE_TrialLogin']=$myrow["TrialLogin"];
                                    $_SESSION['PE_industries']=$myrow["peindustries"];
                                    $_SESSION['PE_EXPIRES'] = time() + 3600;
                                //echo "<bR>---" .$username;
                                //$explodeLogin=explode('@',$login);
                                //if($explodeLogin[1]!='ventureintelligence.com')
                                //{

                                $LogIntimeSql="insert into dealLog(LogSessionID,EmailId,LoggedIn,IpAdd,PE_MA) values('$sesID','$login','$logintime','$ipadd',0)";
                                if($logrs=mysql_query($LogIntimeSql))
                                {
                                }
                                //Added by JFR-KUTUNG
                                //Check if user already has log
                                $deviceId = $currUserCookie;
                                $sqlUserLogSel = "SELECT `id` FROM `user_log` WHERE `emailId`='".$myrow['EmailId']."' AND `dbTYpe`='PE'";
                                $resUserLogSel = mysql_query($sqlUserLogSel);
                                $cntUserLogSel = mysql_num_rows($resUserLogSel);
                                if ($cntUserLogSel==0){
                                    //Insert
                                    $sqlInsUserLog = "INSERT INTO `user_log` (`userId`,`emailId`,`deviceId`,`sessionId`,`dbTYpe`) VALUES ('0','".$login."','".$deviceId."','".$sesID."','PE')";
                                    $resInsUserLog = mysql_query($sqlInsUserLog);
                                }else{
                                    //Update
                                    $resUserLogSel = mysql_fetch_row($resUserLogSel);
                                    $logId = $resUserLogSel[0];
                                    $sqlUpdUsrLog = "UPDATE `user_log` SET `sessionId` = '".$sesID."',`deviceId`='".$deviceId."' WHERE `id`='".$logId."'";
                                    $resUpdUsrLog = mysql_query($sqlUpdUsrLog);
                                }

                                if ($_SESSION['pedirectURL']!=''){
                                    $tempUrl = $_SESSION['pedirectURL'];
                                    $_SESSION['pedirectURL'] = '';
                                    header("location:$tempUrl");
                                }elseif($_REQUEST['value']!='' && $_REQUEST['cfs']==1){
                                    header( 'Location: ' . BASE_URL . 'dealsnew/dealdetails.php?value='.$_REQUEST['value'].'/0' ) ;
                                }else{ 

                                    if($myrow['permission']==1){
                                        $_SESSION['peonly']=1;
                                        unset($_SESSION['vconly']);
                                        header( 'Location: ' . BASE_URL . 'dealsnew/index.php' ) ;
                                    }
                                    else if($myrow['permission']==2){
                                        $_SESSION['vconly']=1;
                                        unset($_SESSION['peonly']);
                                        header( 'Location: ' . BASE_URL . 'dealsnew/index.php?value=1' ) ;
                                    }
                                    else {
                                        unset($_SESSION['peonly']);
                                        unset($_SESSION['vconly']);
                                        header( 'Location: ' . BASE_URL . 'dealsnew/index.php' ) ;
                                    }
                               }
                            }
                            elseif($myrow["ExpiryDate"] >= date('y-m-d'))
                            {
                                    $displayMessage= $TrialExpired;
                            }

                        }

                    }
                }
                elseif ($cnt==0)
                {
                        $displayMessage= $LoginAccess;
                }
        }
    }
    else
    {
            $noaccess=1;
            $RandomLogSql="insert into dealLog values('$sesID','$login','$logintime','0000-00-00 00:00:00','$ipadd',$noaccess,0)";
            //echo "<br>^^^^^ ".$RandomLogSql;
            if($unauthorisedlogrs=mysql_query($RandomLogSql))
            {
            }

            $displayMessage= $UnauthorisedLoginMessage;
    }
}

//echo "<Br>######" .$displayMessage;





function checkIpRange($userIp,$companyId){
    $splitIpAdd= explode(".", $userIp);
    $splitIpAdd1=$splitIpAdd[0];
    $splitIpAdd2=$splitIpAdd[1];
    $splitIpAdd3=$splitIpAdd[2];
    $splitIpAdd4=$splitIpAdd[3];
    $splitIpAddress=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3."";
    $splitIpAddress1=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3.".";

    $checkForIPAddress="SELECT ip.StartRange,ip.EndRange FROM ipAddressKey AS ip ";
    $checkForIPAddress.=" WHERE (ip.ipaddress='".$splitIpAddress."' OR ip.ipaddress='".$splitIpAddress1."') AND (ip.StartRange <= '".$splitIpAdd4."' AND ip.EndRange >= '".$splitIpAdd4."')" ;
    $checkForIPAddress.=" AND DCompId='".$companyId."'";
    //echo $checkForIPAddress;

    $result = mysql_query($checkForIPAddress) or die(mysql_error());
    return mysql_num_rows($result);
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

function sendAuthEmail($companyId,$userEmail,$allowedDevices){
    //Get Point of contact
    $sqlGetPoc = "SELECT `poc` FROM `dealcompanies` WHERE `DCompId`='".$companyId."'";
    $resGetPoc = mysql_query($sqlGetPoc);
    $result = mysql_fetch_row($resGetPoc);
    $poc = $result[0];

    //Generate Auth Code and Store it
    $authcode = 'PE'.rand();
    $today = date('Y-m-d');
    $nextDate = date('Y-m-d', strtotime($date .' +3 day'));
    $sqlInsAuth = "INSERT INTO `user_auth_code` (`user_id`,`emailId`,`dbType`,`reqOn`,`authCode`,`expDate`,`status`) VALUES ('0','".$userEmail."','PE','".$today."','".$authcode."','".$nextDate."','Active')";
    $insResult = mysql_query($sqlInsAuth);

    $devicesUsed = getDevicesUsedCount($userEmail);
    //Send Email
    $to    = $userEmail;
    //$to    = $poc;
    //$to         = 'fidelis@kutung.com';
    $from 	= 'subscription@ventureintelligence.in';
    $subject 	= "Authorization Code for PE Database(".$userEmail.")"; // Subject of the email
    //Message
    $message 	= 'Authorization Code for PE Database. Please find the details below:';

    $message 	.= "<p><b>User Email :</b> ".$userEmail."</p>";
    $message 	.= "<p><b>Authorization Code:</b> ".$authcode."</p>";
    $message 	.= "<p><b>Authorization Link:</b> <a href='" . BASE_URL . "dealsnew/auth.php'>" . BASE_URL . "dealsnew/auth.php</a></p>";
//    $message 	.= "<p><b>Devices already in use:</b> ".$devicesUsed."</p>";
//    $message 	.= "<p><b>Device Limit:</b> ".$allowedDevices."</p>";
    $message 	.= "<p><b>Company ID :</b> ".$companyId."</p>";

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

function search_array ( array $array, $term )
{
    foreach ( $array as $key => $value )
        if ( stripos( $value, $term ) !== false )
            return $key;

    return false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- <title>Venture Intelligence Private Equity & Venture Capital database</title> -->
<title>Private Equity Deal Database</title>
<meta  name="description" content="PE - Login" />
<meta name="keywords" content="PE - Login" />
<link rel="stylesheet" href="css/login.css" />
<link rel="shortcut icon" href="img/fave-icon.png">
<script src="//www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.7.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="js/ui.dropdownchecklist.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-168374697-1');
</script>
<script language="JavaScript" type="text/javascript">
function checkFields()
 {
  	if((document.pelogin.emailid.value == "") || (document.pelogin.emailpassword.value == ""))
    {
		alert("Please enter both Email Id and Password");
		return false
 	}
 	if(document.pelogin.chkTerm.checked==false)
 	{
 		alert("Please agree to Terms & Conditions");
 		return false
 	}
}
</script>

</head>

<body class="loginpage">

<!--Header-->

<div class="login-screen">

<div class="headerlg">
<div class="cnt-left"><div class="logo"><a href="<?php echo BASE_URL; ?>"><img src="img/logo-b.png" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></div>

<ul>
<li><a href="<?php echo BASE_URL; ?>index.htm">Home</a></li>
<li><a href="<?php echo BASE_URL; ?>products.htm" class="active">Products</a></li>
<li><a href="<?php echo BASE_URL; ?>events.htm">Events</a></li>
<!--<li><a href="<?php echo BASE_URL; ?>news.htm">News</a></li>-->
<li><a href="<?php echo BASE_URL; ?>aboutus.htm">About Us</a></li>
<li class="last"><a href="<?php echo BASE_URL; ?>contactus.htm">Contact Us</a></li>
</ul>
</div>


<div class="login-container">

<div   class="login-left">

<form name="pelogin" onSubmit="return checkFields();" method="post" action="pelogin.php" >
<input type="hidden" name="value" value="<?php echo $_REQUEST['value']; ?>" />
    <input type="hidden" name="cfs" value="<?php echo $_REQUEST['cfs']; ?>" />
<ul>
    <li><input type="text"  name="emailid" value=""  placeholder="Email"/></li>
    <li> <input type="password" name="emailpassword" value=""  placeholder="Password"/></li>

    <li>
    <div class="keeplogin"><input type="checkbox" name="chkTerm" CHECKED /> By accessing this database, you agree to the  <a href="<?php echo BASE_URL; ?>terms.htm">terms & conditions</a> of use upon which access is provided.</div>
    </li>

    <li><input type="submit" name="btnSubmit" value ="Login" class="fp"/> <a href="<?php echo BASE_URL; ?>forgetpwd.php?value=P" class="forgot-link">Forgot your password?</a> </li>
    <li><font color="red"><?php echo $displayMessage; ?></font> <?php echo $displayMessage2 ?> </li>
<li><font color="green"><?php echo ($_GET['flag']=='ca') ? 'You have been logged off as you had logged in to another device or browser.' : ''; ?></font></li>
<li><font color="green"><?php echo ($_GET['auth']=='1') ? 'Authorization successful. Please login now' : ''; ?></font></li>
</ul>
</form>
<div style="margin-top: 0px;">
  <p style="color: #000;    padding: 5px 2px;   margin-bottom: 2px;">Funding Data at Your Fingertips:</p>
    <a href="https://play.google.com/store/apps/details?id=com.intelligence.venture" target="_blank"><img src="images/googleplay.png" width="160" height="50"></a>
</div>
<div style="margin-top: 15px;">
    <a href="https://apps.apple.com/us/app/venture-intelligence-pe-vc/id1500244706?ls=1" target="_blank"><img src="images/app.png" width="160" height="50"></a>
</div>

</div>

<div class="login-right">

<h3>Private Equity Deal Database  </h3>

<p>The Venture Intelligence <i> Private Equity Deal Database </i> lists cash-for-equity investments (since 1998) and exits (since 2004) in India-based companies
     	by private equity and venture capital firms. The database also includes financial investments by Strategic Investors which function similar to PE/VC firms
        and often co-invest with them. The database also includes sub-databases tracking Angel Investing, Social Venture/Impact Investing, Cleantech Deals and
        Incubation/Acceleration activity.</p>

<p>Each deal listed in the database typically includes the name of the investee company, its location, Industry & Sector it operates in, the investors involved,
    the amount & date. Information on advisors to the deal,target company valuation multiples and financials are also included for a significant share of the transactions.
    The database also includes profiles of PE & VC firms; PE/VC-backed companies and Companies incubated at various Incubators/Accelerators across India.</p>

<p>Apart from the deal-by-deal listing, the database also provides aggregate private equity and venture capital statistics that includes data on deals that have been
    disclosed in confidence to Venture Intelligence.</p>


<!--<div class="price-subscribe">For pricing/subscription details <a href="http://www.ventureintelligence.com/dd-subscribe.php">Click Here.</a></div>-->

<div class="free-trail"><span>Request a  demo</span> <a href="<?php echo BASE_URL; ?>trial.htm">Click Here</a></div>

</div>

</div>

</div>
<div style="clear: both;"></div> 
<footer class="footer-container">
    <div class="footer-sec"> <span>&copy; TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
</footer>
<style>
div.token-input-dropdown-facebook{
    z-index: 999;
}
.popup_content ul.token-input-list-facebook{
    height: 39px !important;
    width: 537px !important;
}
.popup_main
{
        position: fixed;
        left:0;
        top:0px;
        bottom:0px;
        right:0px;
        background: rgba(2,2,2,0.5);
        z-index: 999;
}
.popup_box
{
	width:500px;
	height: 0;
	position: relative;
	left:0px;
	right:0px;
	bottom:0px;
	top:35px;
	margin: auto;
	
}

.pop_menu ul li {
    margin-right: 0;
    background: #413529;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: rgba(255,255,255,1);
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
}

.pop_menu ul li:first-child {
    margin-right: 0;
    background: #ffffff;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: #413529;
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
    border:1px solid #413529;
}
.popup_content
{
	background: #ececec;
        border:3px solid #211B15;
}
.popup_form
{
	width:700px;
	border:1px solid #d5d5d5;
	background: #fff;
	height: 40px;
}
.popup_dropdown
{
	 width: 155px;
	 margin:0px;
	 border: none;
	 height: 40px;
	 -webkit-appearance: none;
	 -moz-appearance: none;
	 appearance: none;
	 background: url("images/polygon1.png") no-repeat 95% center;
	 padding-left: 17px;
	 cursor: pointer;
	 font-size: 14px;
}
.popup_text
{
	width:538px;
	border: none;
	border-left:1px solid #d5d5d5;
	padding-left: 17px;
	box-sizing: border-box;
	height: 40px;
	font-size: 16px;
	float: right;
}
.auto_keywords
{
	position: absolute;
	top: 106px;
	width:537px;
	background: #fff;
        border:1px solid #d5d5d5;
        border-top: none;
        display: none;
}
.auto_keywords ul
{
	line-height: 25px;
	font-size: 16px;
}

.auto_keywords ul li
{
 padding-left: 20px; 
 cursor:pointer;
}
.auto_keywords ul li a
{
  text-decoration: none;
  color: #414141;
}
.auto_keywords ul li:hover
{
   background: #f2f2f2;                                 
}
.popup_btn
{
	text-align: center;
	padding: 33px 0 50px;
	
}
.popup_cancel
{
	background: #d5d5d5;
	cursor: pointer;
	padding:10px 27px;
	text-align: center;
	color: #767676;
	text-decoration: none;
	margin-right: 16px;
	font-size: 16px;
	display: none;
	
}
.popup_btn input[type="button"]
{
	background: #a27639;
	cursor: pointer;
	padding:10px 27px;
	text-align: center;
	color: #fff;
	text-decoration: none;
	font-size: 16px;
	float: right;

}
.popup_close
{
    color: #fff;
    right: 0px;
    font-size: 20px;
    position: absolute;
    top: 1px;
    width: 15px;
    background: #413529;
    text-align: center;
}
.popup_close a
{
	color: #fff;
	text-decoration: none;
	cursor: pointer;
}
.popup_searching
{
	width:538px;
	float: right;
        position: relative;
}
div.token-input-dropdown{
        z-index: 999 !important;
}

.detail-table-div { display:block; float:left; overflow:hidden;border:1px solid #B3B3B3;}
.detail-table-div table{ border-top:0 !important; border-bottom:0 !important; width:auto !important; margin:0 !important;  }
.detail-table-div th{background:#E5E5E5; text-align:right !important;}
.detail-table-div td{ background:#fff; min-width:130px; text-align:right !important;}
/*.detail-table-div th:first-child {    max-width: 280px; text-align:left !important;
    min-width: 280px;  background:#C9C2AF;}*/
.detail-table-div th:first-child {    max-width: 240px; text-align:left !important;min-width: 240px;  background:#C9C2AF;padding:8px;}
.detail-table-div td:first-child {    max-width: 240px; text-align:left !important;min-width: 240px; background:#E0D8C3;}
.detail-table-div td { padding:8px;}
    
.tab-res{ display:block; overflow-y:hidden !important; overflow:auto; border:1px solid #B3B3B3; margin:10px 0 !important;}
.tab-res table{ border-top:0 !important; border-bottom:1px solid #B3B3B3; border-right:1px solid #B3B3B3; width:auto !important; margin:0 !important;  }
.tab-res th{background:#E5E5E5; text-align:right !important;}
.tab-res td{ background:#fff; min-width:150px; text-align:right !important;padding:8px; border-right: 1px solid #b3b3b3;}
.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
    border-right: 1px solid #b3b3b3;
    text-align: left;
    padding: 8px;
    font-weight: bold;
}

.tab-res th {
    background: #E5E5E5;
    text-align: right !important;
}
detail-table-div table thead th:last-child {
    border-right: 0 !important;
}

.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
}

#allfinancial {
    display: inline-block; 
    font-size: 17px;
    color:#804040;
    font-weight: bolder;
    cursor:pointer;
    float:right;
}

.recommended {
    float:left;
    width:22%;
}


.popup-label { 
    /* margin:5px 10px 30px 40px !important; */
    float:left !important;
   
}
.popup-label-text { width:75% !important;  } 

.pop-div{
    padding: 0px 0px 0px 25px;
}

.pop-btn{
    margin: 10px 0px 10px 0px;
}
.pop-header{
    text-align: center;
    font-size: 14px; 
    font-weight: bold;
    padding: 10px 0px 0px 0px;
}
.authnotes{
    font-size:12px;
    text-align: center;
}

@media (min-width:1366px) and (max-width: 2559px) {
    #allfinancial {
        margin-right: 5px;
    }
}

@media (max-width:1500px){
    .popup_content {
        background: #ececec; 
        overflow-y: auto;
    }
    .popup_main {
        top: 45px;
    }
    
}

@media (max-width:1025px){
       .popup_content {
            min-height: 500px;
        }
        .popup_main {
            top: 80px;
        }
        
}
@media (min-width:780px){
    
    .popup_content {
            min-height: 225px;
        }
    .list_companyname{
        margin-left:160px !important;
    }
    .popup-label {   margin:3px 5px 5px 10px; }
    .popup_box
    {
            
            top:250px !important;
        
    }
    

}
@media (max-width:600px){
    .popup_box
    {
        width:20% !important;
    }
    
}
@media (min-width:1280px){
       
    .list_companyname{
        margin-left:250px !important;
    }
}
@media (min-width:1439px){
       
    .list_companyname{
        margin-left:340px !important;
    }
}
@media (min-width:1639px){
       
    .list_companyname{
        margin-left:520px !important;
    }
}

@media (min-width:1921px){
    
    .popup_content
    {
        background: #ececec;
        height: 600px;
        overflow-y: auto;
    }
    
}
    
.text-center{
  text-align: center;
}
/* Styles */


</style>

<?php 

if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== FALSE)
$user_os =  'Windows';
elseif((strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== FALSE) && strpos($_SERVER['HTTP_USER_AGENT'], 'Linux')!==FALSE)
$user_os = 'Android';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Linux') !== FALSE) //For Supporting IE 11
$user_os =  'Linux';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== FALSE)
$user_os = 'IOS';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE)
$user_os = 'IOS';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== FALSE)
$user_os = 'iOS';

if($user_os=='IOS'){      

if(strpos($_SERVER['HTTP_USER_AGENT'], 'FxiOS') !== FALSE)
  $user_browser = 'Firefox';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== FALSE)
  $user_browser = 'Chrome';
else
  $user_browser = "Safari";
}else{

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
  $user_browser =  'IE';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
  $user_browser =  'IE';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== FALSE) //For Supporting IE EDGE
  $user_browser =  'IE';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
  $user_browser = 'Firefox';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
  $user_browser = 'Chrome';
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
  $user_browser = "Opera_Mini";
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
  $user_browser = "Opera";
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
  $user_browser = "Safari";
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

?>

 

<?php //if($device_list_flag) {  ?> 
<div class="popup_main" id="popup_main" style="display:none;">  
<div class="popup_box">
<!--  <h1 class="popup_header">Financial Details</h1>-->
<span class="popup_close"><a href="javascript: void(0);">X</a></span>
  <div class="popup_content" id="popup_content">
      
      <form name="authform" method="post" action="dealsnew/authdevice.php" onSubmit="return checkpopup();">
      <p  class="pop-header">Your Login is already authorized in the following 2 Browsers*. <br> Please select one of them to deauthorize</p>
      <div class="pop-div">
      <?php 
            $sqlChkdevices = "SELECT * FROM `user_authorized_device` WHERE `user_email`='".$_POST['emailid']."'";
            $resChkdevices1 = mysql_query($sqlChkdevices) or die(mysql_error());
            //$resChkdevices_list = mysql_query($sqlChkdevices) or die(mysql_error());
            $count= 1;  $targer_device_compare=""; $device_array_items=[]; $device_array=[]; $device_array_list=[]; $deviceDetail_devices =[]; $min_version=""; $targer_device_compare="";  $deviceDetail_versions=[];

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
                $device_array[]= $myrow; 
                $device_array_list[]= $myrow['device_details']; 
            } 
           // print_r($device_array_list); 
            foreach($device_array_list as $device_name_array) { 
                $current_device_name_match = preg_match("/(.+)\_[0-9]+/", $device_name_array, $current_matched_name);
                $current_matched_name_string = $current_matched_name[1];  
                array_push($deviceDetail_devices,$current_matched_name_string);
            } 
            //print_r($deviceDetail_devices); 
            $repeated_device_name = array_not_unique($deviceDetail_devices);
            $repeated_device_name = $repeated_device_name[0];
            
            foreach($device_array_list as $da){
                $counts = array_count_values($deviceDetail_devices);   
                $current_device_name_match = preg_match("/(.+)\_[0-9]+/", $da, $current_matched_name);
                $current_matched_name_string = $current_matched_name[1];
                if($counts) {
                    @$repeated_device_count = $counts[$current_matched_name_string]; 
                    if($repeated_device_count >=2 && $repeated_device_name == $current_matched_name_string ) { 
                        $targer_device = $da; 
                        $current_device_version_match = preg_match("/([0-9].+)/", $da, $current_matched_version);
                        $current_device_version_match = $current_matched_version[1]; 
                        array_push($deviceDetail_versions,$current_device_version_match);   
                        //$min_version = min(@$deviceDetail_versions); 
                    }   
                }	 
            } 
            
            natsort($deviceDetail_versions);
            $min_version = array_shift($deviceDetail_versions);
            $targer_device_compare = $repeated_device_name."_".$min_version;   

          //    $count=count($device_array)-3;
          //   $arraydel=array_splice($device_array, 0, $count);
          // foreach ($arraydel as $item) {
          //     $itemid=$item['id'];    
          //     $checkdevices = "DELETE FROM `user_authorized_device` WHERE id='$itemid'";
          //     mysql_query($checkdevices);
          // }
             
           foreach($device_array as $device_array_item) { 
            $device_array_item_selected = explode("_",$device_array_item['device_details']);
            $device_selected = $device_array_item_selected[0].'_'.$device_array_item_selected[1];
                if ($device_array_item['device_details'] == @$targer_device_compare) {	
                    echo "<p> <b class='recommended'>Recommended</b> <input type='radio' name='dauth' value=".$device_array_item['id'].' id="dauth'.$count.'" class="popup-label" ><label class="popup-label-text" for="dauth'.$count.'">'.$device_selected.'</label></p>';
                } else {
                    echo "<p><b class='recommended'> &nbsp; </b> <input type='radio' name='dauth' value=".$device_array_item['id'].' id="dauth'.$count.'" class="popup-label" ><label class="popup-label-text" for="dauth'.$count.'">'.$device_selected.'</label></p>';
                }
                $count++;  
           }


          
      ?>
          
      <input type="hidden" name="device_details" value="<?php echo $device_details; ?>" >
      <input type="hidden" name="user_email" value="<?php echo $_POST['emailid']; ?>" >
          <input type="hidden" name="user_password" value="<?php echo $_POST['emailpassword']; ?>" >
      <div class="text-center" style="margin-left: -25px;">
        <button type="submit" class="pop-btn"> Submit </button>
      </div>
      </div>
      <p class="authnotes">* Note: Updated versions of your browser get counted as a "new" browser. </p>
      </form>
</div>

</div>	
</div>
<?php // } ?>


<?php
/** Check condition to show the alertbox **/ 
if(($device_list_flag == 1) && (count($device_array) >= 1)) {  ?> 
         <script> $("#popup_main").show(); </script>     
<?php  } else {
        ?>     <script> $("#popup_main").hide();  </script>   <?php 
}   
/** End condition to show the alertbox **/ 
?>

<?php  
function array_not_unique($input) {
    $duplicates=array();
    $processed=array();
    foreach($input as $i) {
        if(in_array($i,$processed)) {
            $duplicates[]=$i;
        } else {
            $processed[]=$i;
        }
    }
    return $duplicates; 
} 
?>
 
<script>    
   
    $(document).ready(function(){
        
        $('.popup_close a').click(function(){
            $(".popup_main").hide();
            
         });
    
        $(document).on('click','#pop_menu li',function(){
               window.open('<?php echo BASE_URL; ?>cfsnew/details.php?vcid='+$(this).attr("data-row")+'&pe=1', '_blank');
        });
   
       /* $(document).on('click','#deviceauth',function(){
            alert("ddddddddddddddddddd");
                $(".popup_main").show();
               
        });*/
        
        $('#deviceauth').click(function(){
            $(".popup_main").show();
            
         });
    });
    

function checkpopup()
 {
  	if((document.authform.dauth.value == ""))
        {
		alert("Please choose any one of the existing device.");
		return false
 	}
 	
}
</script>
<style>
.entry-pad{
padding:0px 10px; }
        .mobileRedirectPopup {
            position: absolute !important;
            background: #fff;
            height: 185px;
            width:700px;
            border-radius: 10px;
            left:50%;
            top:25%;
            margin-top:-92.5px;
            margin-left:-350px;
            -webkit-box-shadow: -1px -3px 10px 0px rgba(50, 50, 50, 0.75);
            -moz-box-shadow: -1px -3px 10px 0px rgba(50, 50, 50, 0.75);
            box-shadow: -1px -3px 10px 0px rgba(50, 50, 50, 0.75);
            z-index:1001;
           
        }
        .backdrop{
            height:100vh;
            width:100vw;
            background:rgba(50, 50, 50, 0.75);
            z-index:1000;
            position:absolute;
            top:0px;
            left:0px;
            overflow:hidden;
        }
        .app-text-col h5{
            font-size:1em !important;
            color:#302922 !important;
            margin-left: 20px;
        }
        h5 {
            margin: 10px 0px;
        }

        .text-left {
            text-align: left;
        }

        .btn {
            padding: 10px;
            width: 100%;
            border-radius: 25px;
            border: 0px solid #000;
            -webkit-box-shadow: 0px 0px 2px 0px rgba(50, 50, 50, 0.75);
            -moz-box-shadow: 0px 0px 2px 0px rgba(50, 50, 50, 0.75);
            box-shadow: 0px 0px 2px 0px rgba(50, 50, 50, 0.75);
            text-decoration: none;
        }
         .redirect-button-col .btn {
            margin-top: 2px;
        }
        .redirect-button-col .btn-primary {
            background: #302922 !important;
        }
        .redirect-button-col .btn-primary a{
            color: white !important;
        }
        .redirect-button-col .btn-default {
            background: unset !important;
            color: #302922;
        }

        .d-none {
            display: none;
        }

        .d-block {
            display: block;
        }

        .row {
            width: 100%;
            display: flex;
            /* margin-left: -15px;
            margin-left: -15px; */
            margin: 18px 0;
        }

        .image-col {
            width: 18%;
            padding-right: 0px;
            padding-left: 15px;
        }

        .app-text-col {
            width: 50%;
            padding-right: 15px;
            padding-left: 0px;
        }

        .redirect-button-col {
            width: 35%;
            padding-right: 15px;
            padding-left: 15px;
            text-align: center;
        }

        .w-100 {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }
        .popup-title{
            padding-left:20px;
            padding-right:20px;
            margin-bottom:15px;
        }
        .popup-title h5 {
            border-bottom: 1.25px solid #302922;
            padding-bottom: 10px;
            padding-top: 5px;
            font-size:1rem;
        }

        .image-col img {
            max-width: 50px !important;
            border-radius: 50px;
            height: 40px;
            margin-top:1px;
        }

        .btn a {
            text-decoration: none;
            color: #000;
        }

        .btn.btn-primary a {
            color: #fff !important;
        }

        .btn:focus {
            outline: none;
        }
    </style> 
<div class="backdrop"></div>
    <div class="mobileRedirectPopup">
        <div class="popup-title ">
            <h5 class="text-center">See Venture Intelligence in ...</h5>
        </div>
        <div class="row">
            <div class="image-col text-center"><img
                    src="dealsnew/images/pe_app_icon@2x.png"
                    alt=""></div>
            <div class="app-text-col">
                <h5 class="text-left vi_app">
                    VI <span class="login-type"></span> App
                </h5>
            </div>
            <div class="redirect-button-col">
                <button class="btn btn-primary"><a href="#" class="redirectApp">Open</a></button>
            </div>
        </div>
        <div class="row">
            <div class="image-col text-center">
            <?php if($user_browser=="Safari"){?>
                <img
                    src="https://www.pngfind.com/pngs/m/314-3147164_download-png-ico-icns-flat-safari-icon-png.png"
            alt=""><?php }else if($user_browser=="Chrome"){?>
            <img
                    src="https://www.pngfind.com/pngs/m/98-981105_chrome-icon-free-download-at-icons8-icono-google.png"
                    alt="">
                   <?php } ?>
            </div>
            <div class="app-text-col">
                <h5 class="text-left">
                    <?php echo $user_browser;?>
                </h5>
            </div>
            <div class="redirect-button-col">
                <button class="btn btn-default continue">Continue</button>
            </div>
        </div>
    </div>
    
<script>
   $(document).ready(function () {
    //    alert(window.innerWidth);
    //    var innerwidth=window.innerWidth;
    
            var userAgent = navigator.userAgent.toLowerCase();
            var login = "pe";
            var Android = navigator.userAgent.match(/Android/i);
            var IOS = navigator.userAgent.match(/iPhone|iPad|iPod|macintosh/i);
            var redirectButton = $(".redirectApp");
            var loginTextSpan = $(".login-type");
            
            if (Android) {
                if (login == "cfs") {
                    loginTextSpan.text("CFS");
                    redirectButton.attr("href", "intent://scan/#Intent;scheme=Venture+intelligence;package=com.venture.intelligence;S.browser_fallback_url=https://play.google.com/store/apps/details?id=com.venture.intelligence;end")

                } else if (login == "pe") {
                    loginTextSpan.text("PE");
                    redirectButton.attr("href", " intent://scan/#Intent;scheme=Venture+intelligence;package=com.intelligence.venture;S.browser_fallback_url=https://play.google.com/store/apps/details?id=com.intelligence.venture;end")
                }
                // alert("Android")
            } else if (IOS) {
                loginTextSpan.text("PE");
                redirectButton.attr("href", "https://apps.apple.com/in/app/pe-vc-deals-database/id1500244706");
            }
        })
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        $(".redirect-button-col .btn").on("click", function () {
            setCookie("mobilepopuppe", "show", 1);
        });
        $(".continue").on("click", function () {
            $(".mobileRedirectPopup").hide();
            $(".backdrop").hide();
            setCookie("mobilepopuppe", "show", 1);
        })

        $(document).ready(function(){
    //         var outerWidth =  window.outerWidth;
    //         var innerWidth =  600;
    //         console.log("innerWidth",innerWidth)
    //         var outerHeight =  window.outerHeight;
    //         popup(outerWidth);
    //         var Android = navigator.userAgent.match(/Android/i);
    //         var IOS = navigator.userAgent.match(/iPhone|iPad|iPod/i);
    //         if(Android){
    //             outerWidth=  window.innerWidth;
               
    //            $(".mobileRedirectPopup").css("transform","scale(1.2)");
    //            $(".mobileRedirectPopup").css("margin-left","0px");
    //            $(".mobileRedirectPopup").css("left","10%");
    //            outerWidth="80%";
    //           innerWidth=outerWidth;
    //         }else if(IOS){
    //             outerWidth=  window.innerWidth;
    //             if(outerWidth < 326){
    //                 $(".mobileRedirectPopup").css("transform","scale(1)");
    //                 $(".mobileRedirectPopup").css("left","94%");
    //                 $(".mobileRedirectPopup").css("top","25%");
    //                 outerWidth="100%";
    //             }else if(outerWidth < 400){
    //                 $(".mobileRedirectPopup").css("transform","scale(1)");
    //                 $(".mobileRedirectPopup").css("left","80%");
    //                 $(".mobileRedirectPopup").css("top","25%");
    //                 outerWidth="100%";
    //             }else if(outerWidth < 600){
    //                 $(".mobileRedirectPopup").css("transform","scale(1)");
    //                 $(".mobileRedirectPopup").css("left","72%");
    //                 $(".mobileRedirectPopup").css("top","25%");
    //                 outerWidth="100%";
    //             }else if(outerWidth < 1025){
    //                 $(".mobileRedirectPopup").css("transform","scale(1)");
    //                 $(".mobileRedirectPopup").css("left","58%");
    //                 $(".mobileRedirectPopup").css("top","25%");
    //                 outerWidth="60%";
    //             }else{
    //                 $(".mobileRedirectPopup").css("transform","scale(1)");
    //                 $(".mobileRedirectPopup").css("left","59%");
    //                 outerWidth="60%";
    //             }
    //             innerWidth=outerWidth;

                
    //         }            
    //         $(".mobileRedirectPopup").width(innerWidth);
    //         $(window).resize(function(){
    //             var ow =  window.outerWidth;
    //             popup(ow);
    //         });
    //    })

    //    function popup(ow){
            var Android = navigator.userAgent.match(/Android/i);
            IOS = navigator.userAgent.match(/iPhone|iPad|iPod|macintosh/i);
            
            if(Android || IOS){
                 
                    var popup = getCookie("mobilepopuppe");
                    if (popup == "show") {
                        $(".mobileRedirectPopup").hide();
                        $(".backdrop").hide();  
                    } else {
                        
                            $(".mobileRedirectPopup").show();
                            $(".backdrop").show();
                       
                    }
                
            }
            else{
                $(".mobileRedirectPopup").hide();
                $(".backdrop").hide();
            }
      // }  
    })
</script>
<?php if($_GET['emailValidation'] == "0"){ ?>
<script> $('#popup_main').attr("style", "display: none !important"); </script> 
<?php } ?>
</body>
</html>
