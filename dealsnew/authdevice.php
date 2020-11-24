<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
$Db->dbInvestments();
$displayMessage="";
include "../onlineaccount.php";

if(isset($_POST['dauth']) && isset($_POST['user_email']) && isset($_POST['user_password']) &&  isset($_POST['device_details'])){

// echo "POST['dauth']) = ".$_POST['dauth'].'<br />';
// echo "POST['user_email']) = ".$_POST['user_email'].'<br />';
// echo "POST['user_password']) = ".$_POST['user_password'].'<br />';
// echo "POST['device_details']) = ".$_POST['device_details'].'<br />';



   $checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate,dc.IPAdd,dm.deviceCount,dm.exportLimit,dc.Student,dc.permission,dc.TrialLogin FROM dealmembers AS dm,
    dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
    dm.EmailId='".$_POST['user_email']."' and dm.Passwrd='".md5($_POST['user_password'])."'
    AND dc.Deleted =0";
    
    //$sqlnewdevice = "update user_authorized_device set `device_details`='".$_POST['device_details']."' where id=".$_POST['dauth'];
  
    //if($resChkdevice = mysql_query($sqlnewdevice) or die(mysql_error())){

       // $sqlstatusupdate = "update user_authorized_device set `status`=0 where id=".$_POST['dauth'];
        
        //if($resstatus = mysql_query($sqlstatusupdate) or die(mysql_error())){
            
            // $totalrs = mysql_query($checkUserSql) -- Need to check

            $totalrs = mysql_query($checkUserSql);
            $rowsFound = mysql_num_rows($totalrs);
            if ($rowsFound > 0) 
            {     
                While($myrow = mysql_fetch_array($totalrs))
                { 
                    if( date('Y-m-d')<=$myrow["ExpiryDate"]){  
                        if($myrow['EmailId'] != ''){  
                            sendAuthEmail($myrow['DCompId'],$myrow['EmailId'],$myrow['deviceCount']); 
                            header("Location: ".BASE_URL."dealsnew/auth.php?device=".$_POST['dauth']."&email=".$_POST['user_email']."&device_detail=".$_POST['device_details']); 
                            die();
                        }else{
                            header("Location:".BASE_URL."pelogin.php?emailValidation=0");
                            die();
                        }
                    } 
                    else{
                        $displayMessage = $TrialExpired;
                    }
                }
            }else{
                header("Location:".BASE_URL."pelogin.php");
                die();
            }
       // }
   // }
} else {
    header("Location:".BASE_URL."pelogin.php");
    die(); 
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

    // echo 'Insdide Function - userEmail = '. $userEmail . "<br />";
    //die();

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
    //$to    = "vijayakumar.k@praniontech.com";
    //$to    = $poc;
    //$to         = 'fidelis@kutung.com';
    $from 	= 'subscription@ventureintelligence.in';
    $subject 	= "Authorization Code for PE Database(".$userEmail.")"; // Subject of the email
    //Message
    $message 	= 'Authorization Code for PE Database. Please find the details below:';

    $message 	.= "<p><b>User Email :</b> ".$userEmail."</p>";
    $message 	.= "<p><b>Authorization Code:</b> ".$authcode."</p>";
    $message 	.= "<p><b>Authorization Link:</b> <a href='".BASE_URL."dealsnew/auth.php?device=".$_POST['dauth']."&email=".$_POST['user_email']."&device_detail=".$_POST['device_details']."'>".BASE_URL."dealsnew/auth.php?device=".$_POST['dauth']."</a></p>";
    
    

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
    $headers .= 'Bcc: vijayakumar.k@praniontech.com, krishna.s@praniontech.com' . "\r\n";
    // $headers .= 'Cc: krishna.s@praniontech.com' . "\r\n";
    if (@mail($to, $subject, $message, $headers)){
    }else{
    }

}
?>
