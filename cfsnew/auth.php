<?php 

include "header.php";

require_once MODULES_DIR."users.php";
$users = new users();

if ($_POST['btnSubmit']=='Authorize'){
    $displayMessage = '';
    
    //Valdation
    if ($_POST['emailid']=='')
        $displayMessage = 'Please enter your email address<br>';
    if ($_POST['authCode']=='')
        $displayMessage .= 'Please enter the authorization code<br>';
    
    
    if ($displayMessage==''){
        $userEmail = strtolower($_POST['emailid']);
        $authCode  = $_POST['authCode'];
        $today     = date('Y-m-d');
        
        $currCookie = $_COOKIE['cfsLoginAuth'];
        $currCookieArray=  json_decode($currCookie,true);
        
        //Check if the auth code is correct
        $sqlAuthCheck = "SELECT `expDate` FROM `user_auth_code` WHERE `emailId`='".$userEmail."' AND `dbType`='CFS' AND `authCode`='$authCode' AND `expDate` >= '".$today."'";
        $resAuthCheck = mysql_query($sqlAuthCheck);
        $cntAuthCheck = mysql_num_rows($resAuthCheck);
        
        if($_POST['autdevice']){
             
            // $sqlnewdevice = "update user_authorized_device set `status`=1 where id=".$_POST['autdevice'];
            // mysql_query($sqlnewdevice);
        }
        
        if($_POST['autdevice'] > 0 && $_POST['autdevice']!=''){

                // $sqlnewdevice = "update user_authorized_device set `status`=1 where id=".$_POST['autdevice'];
                // mysql_query($sqlnewdevice);
               
                // $sqluserstatus = "update users set user_authorized_status=1 where email ='".$userEmail."' or username = '".$userEmail."'";
                // mysql_query($sqluserstatus) or die(mysql_error());
                
        }else{
            
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

            /*echo $_SERVER['HTTP_USER_AGENT'];
               echo $user_os;
               echo $user_browser;*/

               $exp_user = explode(' ',$_SERVER['HTTP_USER_AGENT']);

               if($user_os=='IOS'){

                   $searchKey = search_array($exp_user, 'Mobile');
                   $deviceId = str_replace('/', '_', $exp_user[$searchKey]);
               }else{

                   $searchKey = search_array($exp_user, $user_browser);
                   $deviceId = str_replace('/', '_', $exp_user[$searchKey]);
               }

                $device_details = $user_os."_".$user_browser."_".$deviceId;

                $sqlgetdeviceCnt = "SELECT * FROM user_authorized_device WHERE `user_email`='".$userEmail."' and device_details='".$device_details."' ";
                $resgetdeviceCnt = mysql_query($sqlgetdeviceCnt) or die(mysql_error());

                if(mysql_num_rows($resgetdeviceCnt) > 0){ 
                    // $sqlnewdevice = "update user_authorized_device set `status`=1 WHERE `user_email`='".$userEmail."' and device_details='".$device_details."'";
                    // mysql_query($sqlnewdevice) or die(mysql_error());
                }else{

                    $sqlnewdevice = "insert into user_authorized_device (user_email,device_details,status) values ('".$userEmail."','".$device_details."',1 )";
                    mysql_query($sqlnewdevice) or die(mysql_error());
                }
               
                $sqlmemberstatus = "update users set user_authorized_status=1 where email ='".$userEmail."' or username = '".$userEmail."'";
                mysql_query($sqlmemberstatus) or die(mysql_error());
        }
         
        if ($cntAuthCheck==1){
            
            //Check if cookie can be created. Should not have exceeded device limit
            $authAdmin = $users->selectByUName($userEmail);
            //print_r($authAdmin);
            if(!($authAdmin)){
                $authAdmin = $users->selectByEmail($userEmail);                
            }
            $devicesUsed = getDevicesUsedCount($userEmail);
            $allowedNoDevices = $authAdmin['deviceCount'];
            
            /*$sqlgetdevCnt = "SELECT * FROM `dealmembers` WHERE `EmailId`='".$userEmail."'";
            $resgetdevCnt = mysql_query($sqlgetdevCnt);
            $cntgetdevRes = mysql_fetch_array($resgetdevCnt);*/
            
           
            
            if ($devicesUsed <= $allowedNoDevices){
                //Create Cookie
                $cookieName = 'CFS'.$authAdmin['firstname'].'-'.$authAdmin['user_id'].'-'.rand();
                $currCookieArray[$userEmail]=$cookieName;
                $currCookieJson=  json_encode($currCookieArray);
                setcookie('cfsLoginAuth',$currCookieJson,time() + (86400 * 365)); // 86400 = 1 day //Create Cookie  
                
                //Store Cookie value in DB
                $sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`)";
                $sqlInsCookie .= " VALUES ('".$userEmail."','".$cookieName."','0','CFS')";
                mysql_query($sqlInsCookie) or die(mysql_error());
                                
                //Delete authcode record in DB
                $sqlDelAuthCode = "DELETE FROM `user_auth_code` WHERE `emailId`='".$userEmail."' AND `dbType`='CFS' AND `authCode`='$authCode'";
                mysql_query($sqlDelAuthCode);

                //Message to login
                /*$successMessage = 'You have successfully authorized this device. <a href="login.php">Login Here</a>';
                $userEmail = '';
                $authCode  = '';*/
                $sqlnewdevice = "update user_authorized_device set `status`=1, `device_details`='".$_GET['device_detail']."' where id=".$_POST['autdevice'];
                mysql_query($sqlnewdevice);

                // $sqlnewdevice = "update user_authorized_device set `status`=1 where id=".$_POST['autdevice'];
                // mysql_query($sqlnewdevice);
               
                $sqluserstatus = "update users set user_authorized_status=1 where email ='".$userEmail."' or username = '".$userEmail."'";
                mysql_query($sqluserstatus) or die(mysql_error());

                header("location:login.php?auth=1");
                exit;
                
            }else{
                $displayMessage = 'You have exceeded the allowed number of devices from which you can login. Please contact us at subscription@ventureintelligence.com for more details';
            }
        }else{
            $displayMessage = 'Invalid Email / Authorization Code or Authorization Code has expired';
        }
       
    }
}

/*function getDevicesUsedCount($email,$db){
    $sqlCheckDevice = "SELECT `deviceId` FROM `userlog_device` WHERE `EmailId`='".$email."' AND `dbType`='".$db."'  AND auth_type='0' ";
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
$template->assign('device',$_REQUEST['device']);
$template->assign('authCode',$authCode);
//$template->assign('emailid',$userEmail);
$template->assign('emailid',$_REQUEST['email']);
$template->assign('successMessage',$successMessage);
$template->assign('displayMessage',$displayMessage);
$template->assign('pageTitle',"CFS - Device Authentication");
$template->assign('pageDescription',"CFS - Device Authentication");
$template->assign('pageKeyWords',"CFS - Device Authentication");
$template->display('auth.tpl');


 mysql_close();
#82f26d#

#/82f26d#
?>