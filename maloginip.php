<?php include_once("globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
session_start();
/*
	filename - malogin.php
    formanme - malogin
    invoked from -  direct from website link
    invoked to - mahome.php
  */
  //setcookie("TCook");
                                require("dbconnectvi.php");
                                $Db = new dbInvestments();
                                $Db->dbInvestments();
                                $displayMessage="";
                                include "onlineaccount.php";
                                global $LoginAccess;
                                global $LoginMessage;
                                global $TrailExpired;
				$login=$_POST['emailid'];
				$login=trim($login);
				$pwd=$_POST['emailpassword'];
				$pwd=trim($pwd);
                                //if($_POST)
                               // {

                                if((trim($login)== "") && (trim($pwd)=="")){
                                    $sesID=session_id();
			 		//$ipadd=@$REMOTE_ADDR;
                                        $ipadd = $_SERVER['REMOTE_ADDR'];
			 		//$ipadd="202.174.120.230";
					//$ipadd="210.212.75.1";
			 		//echo "<Br>IPADDRESS-" .$ipadd;
					$logintime=date("Y-m-d")." ".date("H:i:s");
					$splitIpAdd= explode(".", $ipadd);
					$splitIpAdd1=$splitIpAdd[0];
					$splitIpAdd2=$splitIpAdd[1];
					$splitIpAdd3=$splitIpAdd[2];
					$splitIpAdd4=$splitIpAdd[3];

                                        $splitIpAddress=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3.".";
                                        $splitIpAddress2=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3;


					//$checkForIPAddress="select * from ipAddress where ipaddress='$splitIpAddress'";
					$checkForIPAddress="SELECT ip.DCompId, dm.EmailId, dm.Passwrd, dm.Name,ip.StartRange,ip.EndRange
						FROM ipAddressKey AS ip, malogin_members AS dm,dealcompanies as dc
						WHERE (ip.ipaddress='$splitIpAddress' OR ip.ipaddress='$splitIpAddress2')  and dm.Deleted=0
						AND dm.DCompId = ip.DCompId and dc.DCompId=ip.DCompId and dc.Student=1";
                                                //echo "<bR>--- " .$checkForIPAddress;
						if($rsip=mysql_query($checkForIPAddress))
						{
							$ipcnt= mysql_num_rows($rsip);

							if($ipcnt>0)
							{
								While($myrowIP=mysql_fetch_array($rsip, MYSQL_BOTH))
								{
									if(($splitIpAdd4>=$myrowIP["StartRange"]) && ($splitIpAdd4<=$myrowIP["EndRange"]))
									{
										$companyId=$myrowIP["DCompId"];
										$login=$myrowIP["EmailId"];
										$pwd=$myrowIP["Passwrd"];
										$cnt=1;
									}
									else
										{	$displayMessage= "Login Error - Device not authorized. Please contact your administrator.";}
								}
							}
							else
								$displayMessage= "Login Error - Device not authorized. Please contact your administrator.";
						}
                                }

				if((trim($login)!= "") && (trim($pwd)!=""))
				{
                    $pwd=$pwd;
					//session_regenerate_id();
			 		$sesID=session_id();
			 		//$ipadd=@$REMOTE_ADDR;
                                        $ipadd = $_SERVER['REMOTE_ADDR'];
			 		//echo "<Br>---Session id create-" .$sesID;
					$logintime=date("Y-m-d")." ".date("H:i:s");
				       $LogIntimeSql="insert into dealLog(LogSessionID,EmailId,LoggedIn,IpAdd,PE_MA) values('$sesID','$login','$logintime','$ipadd',1)";

				//	if($logrs=mysql_query($LogIntimeSql))
				//	{
				//	}

					$checkForUnknownLoginSql="select * from malogin_members where EmailId='$login'";
					if($rsRandom=mysql_query($checkForUnknownLoginSql))
					{
						$random_cnt= mysql_num_rows($rsRandom);
					}
					//echo "<bR>****".$random_cnt;
					if($random_cnt==1)
					{
						/*$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM malogin_members AS dm,
										dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND dc.MAMA=1 and
										dm.EmailId='$login' and dm.Passwrd='$pwd'
										AND dc.Deleted =0 and dc.IPAdd=0";*/
                                                $checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate,dc.IPAdd,dm.deviceCount,dm.exportLimit,dc.Student,dc.maindustries FROM malogin_members AS dm,
										dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND dc.MAMA=1 and
										dm.EmailId='$login' and dm.Passwrd='$pwd'
										AND dc.Deleted =0";




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
                                                                     $currCookie = $_COOKIE['maLoginAuth'];

                                                                    $currCookieArray=  json_decode($currCookie,true);
                                                                    $error = json_last_error();
                                                                    if($error!=JSON_ERROR_NONE)
                                                                    {
                                                                        $currCookieArray=array();
                                                                        $currUserCookie=$currCookie;
                                                                    }else{

                                                                        $currUserCookie=$currCookieArray[$myrow['EmailId']];

                                                                    }
                                                                    if ($myrow['IPAdd']==1){//If IPADD process IP Restriction

                                                                        //Check if cookie exists //Check if the cookie still has access
                                                                        $currCookie = $_COOKIE['maLoginAuth'];
                                                                        $sqlChkCookie = "SELECT `deviceId` FROM `userlog_device` WHERE `deviceId`='".$currUserCookie."' AND `EmailId`='".$myrow['EmailId']."' AND `dbType`='MA'";
                                                                        $resChkCookie = mysql_query($sqlChkCookie) or die(mysql_error());
                                                                        $cntChkCookie = mysql_num_rows($resChkCookie);

                                                                        if ($currUserCookie!='' && $cntChkCookie >= 1 && $myrow['Student']==0){
                                                                            $processLoginFlag = 1;
                                                                            //echo 'login with cookie';
                                                                        }else{
                                                                            if (checkIpRange($ipadd,$myrow['DCompId'])){ //Check if users Ip falls within the range
                                                                                $processLoginFlag = 1;
                                                                                //echo 'login with IP';
                                                                                //Check for device limit and devices already used
                                                                                $devicesUsed = getDevicesUsedCount($myrow['EmailId'],'MA');
//                                                                                if ($cntChkCookie==0)
                                                                                if ($devicesUsed < $myrow['deviceCount']){

                                                                                    $cookieName = 'MA'.$myrow['Name'].'-'.$myrow['DCompId'].'-'.rand();
                                                                                    $currCookieArray[$myrow['EmailId']]=$cookieName;
                                                                                    $currCookieJson=  json_encode($currCookieArray);
                                                                                    setcookie('maLoginAuth',$currCookieJson,time() + (86400 * 365)); // 86400 = 1 day //Create Cookie

                                                                                    //Store Cookie value in DB
                                                                                    $sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`)";
                                                                                    $sqlInsCookie .= " VALUES ('".$myrow['EmailId']."','".$cookieName."','".$myrow['DCompId']."','MA')";
                                                                                    mysql_query($sqlInsCookie) or die(mysql_error());
                                                                                    $processLoginFlag = 1;
                                                                                    //echo "Cookie Created and allowed login..";

                                                                                }else if ($myrow['Student']==1){
                                                                                    $processLoginFlag = 1;
                                                                                }else{
                                                                                    $processLoginFlag = 0;

                                                                                    $displayMessage = "Login Error - You have exceeded the allowed number of devices from which you can login. Please contact us at info@ventureintelligence.com for more details";
                                                                                }

                                                                            }else{
                                                                                //Display Message and Send email with auth code
                                                                                if ($myrow['Student']==0){
                                                                                    $displayMessage = 'Login Error - Device not authorized. Please contact your administrator for Authorization Code. <a href="/ma/auth.php">Authorize</a>';
                                                                                    sendAuthEmail($myrow['DCompId'],$myrow['EmailId'],$myrow['deviceCount']);
                                                                                }else{
                                                                                    $displayMessage = 'Login Error - Device not authorized. Please contact your administrator.</a>';
                                                                                }
                                                                            }

                                                                        }
                                                                    }else{
                                                                        $processLoginFlag = 1;
                                                                        //echo "Login without restriction";
                                                                    }
                                                                    //END

                                                                    if ($processLoginFlag==1){
									if( date('Y-m-d')<=$myrow["ExpiryDate"])
									{
										session_register("MAUserNames");
										session_register("MAUserEmail");
										session_register("MALastActivity");
                                                                                session_register("MALoginTime");
										$username=trim($myrow["Name"]);
										$_SESSION['MAUserNames']=$username;
										$_SESSION['MAUserEmail']=$myrow["EmailId"];
										$_SESSION['MADcompanyId']=$myrow["DCompId"];
                                        $_SESSION['MA_industries']=$myrow["maindustries"];
										$_SESSION['MALastActivity']=time();
                                                                                $_SESSION['MALoginTime']=$logintime;
										$_SESSION['MAIP']="M";
                                                                                $_SESSION['student']=$myrow["Student"];
                                                                                $_SESSION['MASession_Id']=$sesID;
                                                                                $LogIntimeSql="insert into dealLog(LogSessionID,EmailId,LoggedIn,IpAdd,PE_MA) values('$sesID','$login','$logintime','$ipadd',1)";
                                                                                if($logrs=mysql_query($LogIntimeSql))
                                                                                {
                                                                                }

                                                                                //Added by JFR-KUTUNG
                                                                                //Check if user already has log
                                                                                $deviceId = $currUserCookie;
                                                                                $sqlUserLogSel = "SELECT `id` FROM `user_log` WHERE `emailId`='".$myrow['EmailId']."' AND `dbTYpe`='MA'";
                                                                                $resUserLogSel = mysql_query($sqlUserLogSel);
                                                                                $cntUserLogSel = mysql_num_rows($resUserLogSel);
                                                                                if ($cntUserLogSel==0){
                                                                                    //Insert
                                                                                    $sqlInsUserLog = "INSERT INTO `user_log` (`userId`,`emailId`,`deviceId`,`sessionId`,`dbTYpe`) VALUES ('0','".$login."','".$deviceId."','".$sesID."','MA')";
                                                                                    $resInsUserLog = mysql_query($sqlInsUserLog);
                                                                                }else{
                                                                                    //Update
                                                                                    $resUserLogSel = mysql_fetch_row($resUserLogSel);
                                                                                    $logId = $resUserLogSel[0];
                                                                                    $sqlUpdUsrLog = "UPDATE `user_log` SET `sessionId` = '".$sesID."',`deviceId`='".$deviceId."' WHERE `id`='".$logId."'";
                                                                                    $resUpdUsrLog = mysql_query($sqlUpdUsrLog);
                                                                                }

                                                                                 header('location:'.BASE_URL.'ma/index.php');
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

				//}

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

function getDevicesUsedCount($email,$db){
    $sqlCheckDevice = "SELECT `deviceId` FROM `userlog_device` WHERE `EmailId`='".$email."' AND `dbType`='".$db."'";
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
    $authcode = 'MA'.rand();
    $today = date('Y-m-d');
    $nextDate = date('Y-m-d', strtotime($date .' +1 day'));
    $sqlInsAuth = "INSERT INTO `user_auth_code` (`user_id`,`emailId`,`dbType`,`reqOn`,`authCode`,`expDate`,`status`) VALUES ('0','".$userEmail."','MA','".$today."','".$authcode."','".$nextDate."','Active')";
    $insResult = mysql_query($sqlInsAuth);

    $devicesUsed = getDevicesUsedCount($userEmail,'MA');
    //Send Email

    $to    = $poc;
    //$to         = 'fidelis@kutung.com';
    $from 	= 'info@ventureintelligence.in';
    $subject 	= "Authorization Code for MA Database(".$userEmail.")"; // Subject of the email

    //Message
    $message 	= 'Authorization Code for MA Database. Please find the details below:';

    $message 	.= "<p><b>Company ID :</b> ".$companyId."</p>";
    $message 	.= "<p><b>User Email :</b> ".$userEmail."</p>";
    $message 	.= "<p><b>Devices already in use:</b> ".$devicesUsed."</p>";
    $message 	.= "<p><b>Device Limit:</b> ".$allowedDevices."</p>";
    $message 	.= "<p><b>Authorization Code:</b> ".$authcode."</p>";
    $message 	.= "<p><b>Authorization Link:</b> <a href='".BASE_URL."ma/auth.php'>".BASE_URL."ma/auth.php</a></p>";
    $message 	.= "<p>System Note :Authorization will not be allowed if the device limit is exceeded.</p>";
    $message 	.= "<p>&nbsp;</p>";
    $message 	.= "<p>Thank you,<br><b>Ventureintelligence</b></p>";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n";
    $headers .= "Reply-To: $userEmail\r\n";

    if (@mail($to, $subject, $message, $headers)){
    }else{
    }

}


//echo "<Br>######" .$displayMessage;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Venture Intelligence Private Equity & Venture Capital database</title>
<meta  name="description" content="PE - Login" />
<meta name="keywords" content="PE - Login" />
<link rel="stylesheet" href="css/login.css" />

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="js/ui.dropdownchecklist.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
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
  	if((document.malogin.emailid.value == "") || (document.malogin.emailpassword.value == ""))
    {
		alert("Please enter both Email Id and Password");
		return false
 	}
 	if(document.malogin.chkTerm.checked==false)
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
<div class="cnt-left"><div class="logo"><a href="<?php echo BASE_URL;?>"><img src="img/logo-b.png" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></div>

<ul>
<li><a href="<?php echo BASE_URL;?>index.htm">Home</a></li>
<li><a href="<?php echo BASE_URL;?>products.htm" class="active">Products</a></li>
<li><a href="<?php echo BASE_URL;?>events.htm">Events</a></li>
<li><a href="<?php echo BASE_URL;?>news.htm">News</a></li>
<li><a href="<?php echo BASE_URL;?>aboutus.htm">About Us</a></li>
<li class="last"><a href="<?php echo BASE_URL;?>contactus.htm">Contact Us</a></li>
</ul>
</div>


<div class="login-container">

<div   class="login-left">

<form name="malogin" onSubmit="return checkFields();" method="post" action="maloginip.php" >

<ul>
    <li><input type="text"  name="emailid" value=""  placeholder="Email"/></li>
    <li> <input type="password" name="emailpassword" value=""  placeholder="Password"/></li>

    <li>
    <div class="keeplogin"><input type="checkbox" name="chkTerm" CHECKED /> By accessing this database, you agree to the  <a href="../terms.htm">terms & conditions</a> of use upon which access is provided.</div>
    </li>

    <li><input type="submit" name="btnSubmit" value ="Login" class="fp"/> <a href="<?php echo BASE_URL;?>ma/forgetpwd.php?value=M" class="forgot-link">Forgot your password?</a> </li>
    <li><font color="red"><?php echo $displayMessage; ?></font></li>
<li><font color="green"><?php echo ($_GET['flag']=='ca') ? 'You have been logged off as you had logged in to another device or browser.' : ''; ?></font></li>
<li><font color="green"><?php echo ($_GET['auth']=='1') ? 'Authorization successful. Please login now' : ''; ?></font></li>
</ul>
</form>

</div>

<div class="login-right">

<h3>M&A Deal Database </h3>

<p>The Venture Intelligence <i> Mergers & Acquisitions Deal Database </i> lists inbound, outbound and domestic deals involving India-based companies.</p>

<p>Each deal listed in this database typically includes the name of the target company and acquirer, their locations, the Industry & Sector (of the target),
    transaction amount and the deal date. Information on advisors to the deal, target company valuation and financials are also included for a significant
    share of the transactions.</p>

<p>Apart from the deal-by-deal listing, the database also provides aggregate M&A statistics.</p>

<!--<div class="price-subscribe">For pricing/subscription details <a href="http://www.ventureintelligence.com/dd-subscribe.php">Click Here.</a></div>-->

<div class="free-trail"><span>Request a  demo</span> <a href="<?php echo BASE_URL;?>trial.htm">Request Now</a></div>

</div>

</div>

</div>

</body>
</html>