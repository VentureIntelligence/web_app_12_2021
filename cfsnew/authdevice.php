<?php include_once("../globalconfig.php"); ?>
<?php
include "header.php";

require_once MODULES_DIR."users.php";
$users = new users();

require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();

$username = $_POST["user_email"];
$password = $_POST["user_password"];

$Rs = $users->selectByUsernameNew($username,$password);

if(($username !='') && ($password !='')){
    
    $authAdmin = $users->selectByUName($username);
    if(!($authAdmin)){
        $authAdmin = $users->selectByEmail($username);
    }
    $UName = $authAdmin['username'];
    $Pwd = $authAdmin['user_password'];

    $groupstatus = $grouplist->select($authAdmin['GroupList']);
        //pr($groupstatus);
	//pr($test);
//	pr($test['username']); //exit;
}
if(isset($_POST['dauth']) && isset($_POST['user_email']) && isset($_POST['user_password']) &&  isset($_POST['device_details'])){
$groupId = $authAdmin['GroupList'];

$groupIp = $grouplist->getGroupIP($groupId);
//  print_r($groupIp);
$groupPocArray = $grouplist->getGroupEmail($groupId);
$groupPoc = $groupPocArray['poc'];

//$sqlnewdevice = "update user_authorized_device set `device_details`='".$_POST['device_details']."' where id=".$_POST['dauth'];
  
//if($resChkdevice = mysql_query($sqlnewdevice) or die(mysql_error())){

  //  $sqlstatusupdate = "update user_authorized_device set `status`=0 where id=".$_POST['dauth'];
        
   // if($resstatus = mysql_query($sqlstatusupdate) or die(mysql_error())){
        
        sendAuthEmail($groupPoc,$authAdmin['GroupList'],$authAdmin['deviceCount'],$authAdmin['username']);

        header("Location:".BASE_URL."cfsnew/auth.php?device=".$_POST['dauth']."&email=".$_POST['user_email']."&device_detail=".$_POST['device_details']);
        die();
    } else {
        header("Location:".BASE_URL."cfsnew/login.php");
        die(); 
    }
  //  }
//}
    
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
    //$to    = $poc;
    //$to         = 'fidelis@kutung.com';
    $from 	= 'subscription@ventureintelligence.in';
    $subject 	= "Authorization Code for CFS Database(".$userEmail.")"; // Subject of the email

    //Message
    $message 	= 'Authorization Code for CFS Database. Please find the details below:';

    $message 	.= "<p><b>User Email :</b> ".$userEmail."</p>";
    $message 	.= "<p><b>Authorization Code:</b> ".$authcode."</p>";
    //$message 	.= "<p><b>Authorization Link:</b> <a href='" . BASE_URL . "cfsnew/auth.php?device=".$_POST['dauth']."&email=".$userEmail."'>http://www.ventureintelligence.asia/dev/cfsnew/auth.php</a></p>";
    
    $message 	.= "<p><b>Authorization Link:</b> <a href='".BASE_URL."cfsnew/auth.php?device=".$_POST['dauth']."&email=".$_POST['user_email']."&device_detail=".$_POST['device_details']."'>".BASE_URL."dealsnew/auth.php?device=".$_POST['dauth']."</a></p>";
    

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
?>
