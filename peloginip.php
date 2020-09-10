<?php include_once("globalconfig.php"); ?>
<?php
session_save_path("/tmp");
session_start();
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
                                $displayMessage="";
                                include "onlineaccount.php";
                                global $LoginAccess;
                                global $LoginMessage;
                                global $TrailExpired;
				$login=$_POST['emailid'];
				$login=trim($login);
				$pwd=$_POST['emailpassword'];
				$pwd=trim($pwd);


                                /*Override for students*/
                                if((trim($login)== "") && (trim($pwd)=="")){
                                    $sesID=session_id();
			 		//$ipadd=@$REMOTE_ADDR;
                                        $ipadd = $_SERVER['REMOTE_ADDR'];
                                     //   echo $ipadd;
			 		//$ipadd="202.174.120.45";
					//$ipadd="115.111.95.19";
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
						FROM ipAddressKey AS ip, dealmembers AS dm,dealcompanies as dc
						WHERE (ip.ipaddress='$splitIpAddress' OR ip.ipaddress='$splitIpAddress2') and dm.Deleted=0
						AND dm.DCompId = ip.DCompId and dc.DCompId=ip.DCompId and dc.Student=1";
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
										$companyId=$myrowIP["DCompId"];
										$login=$myrowIP["EmailId"];
										$pwd=$myrowIP["Passwrd"];
										$cnt=1;
									}
									else
									{	$displayMessage= "Login Error - aDevice not authorized. Please contact your administrator.";}
								}
							}
							else
								$displayMessage= "Login Error - Device not authorized. Please contact your administrator.";
						}
                                }



				if((trim($login)!= "") && (trim($pwd)!=""))
				{
                    
					//session_regenerate_id();
                     $sesID=session_id();
                     
			 		//$ipadd=@$REMOTE_ADDR;
                                        $ipadd = $_SERVER['REMOTE_ADDR'];
			 		//echo "<Br>---Session id create-" .$sesID;
                                        $logintime=date("Y-m-d")." ".date("H:i:s");
				       $LogIntimeSql="insert into dealLog(LogSessionID,EmailId,LoggedIn,IpAdd,PE_MA) values('$sesID','$login','$logintime','$ipadd',0)";
$pwd=$pwd;
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

                                                  $checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate,dc.IPAdd,dm.deviceCount,dm.exportLimit,dc.Student,dc.peindustries FROM dealmembers AS dm,
										dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
										dm.EmailId='$login' and dm.Passwrd='$pwd'
										AND dc.Deleted =0 ";
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
                                                                    $currCookie = $_COOKIE['peLoginAuth'];

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
                                                                        $currCookie = $_COOKIE['peLoginAuth'];

                                                                        $sqlChkCookie = "SELECT `deviceId` FROM `userlog_device` WHERE `deviceId`='".$currUserCookie."' AND `EmailId`='".$myrow['EmailId']."' AND `dbType`='PE'";
                                                                        $resChkCookie = mysql_query($sqlChkCookie) or die(mysql_error());
                                                                        $cntChkCookie = mysql_num_rows($resChkCookie);

                                                                        if ($currUserCookie!='' && $cntChkCookie >= 1 && $myrow['Student']==0){
                                                                            $processLoginFlag = 1;
                                                                           // echo 'login with cookie';
                                                                        }else{
                                                                            //  echo 'login without cookie';
                                                                            if (checkIpRange($ipadd,$myrow['DCompId'])){ //Check if users Ip falls within the range



                                                                                $processLoginFlag = 1;
//                                                                                echo 'login with IP';
                                                                                //Check for device limit and devices already used
                                                                                $devicesUsed = getDevicesUsedCount($myrow['EmailId'],'PE');
//                                                                                if ($cntChkCookie==0)
                                                                                if ($devicesUsed < $myrow['deviceCount']){

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
                                                                                
                                                                            }else{
                                                                                if ($myrow['Student']==0){
                                                                                    //Display Message and Send email with auth code
                                                                                    $displayMessage = 'Login Error - Device not authorized. Please contact your administrator for Authorization Code. <a href="/dev/dealsnew/auth.php">Authorize</a>';
                                                                                    sendAuthEmail($myrow['DCompId'],$myrow['EmailId'],$myrow['deviceCount']);
                                                                                }else{
                                                                                    $displayMessage = 'Login Error - Device not authorized. Please contact your administrator.';
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
										session_register("UserNames");
										session_register("UserEmail");
										session_register("LastActivity");
                                                                                session_register("LoginTime");
										$username=trim($myrow["Name"]);
										$_SESSION['UserNames']=$username;
										$_SESSION['UserEmail']=$myrow["EmailId"];
										$_SESSION['DcompanyId']=$myrow["DCompId"];
                                                                                $_SESSION['student']=$myrow["Student"];
										$_SESSION['LastActivity']=time();
                                                                                $_SESSION['LoginTime']=$logintime;
                                                                                $_SESSION['PESession_Id']=$sesID;
                                                                                $_SESSION['PE_industries']=$myrow["peindustries"];
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
                                                                                        header('Location:'.BASE_URL.'dealsnew/index.php') ;
										//}
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
    $authcode = 'PE'.rand();
    $today = date('Y-m-d');
    $nextDate = date('Y-m-d', strtotime($date .' +1 day'));
    $sqlInsAuth = "INSERT INTO `user_auth_code` (`user_id`,`emailId`,`dbType`,`reqOn`,`authCode`,`expDate`,`status`) VALUES ('0','".$userEmail."','PE','".$today."','".$authcode."','".$nextDate."','Active')";
    $insResult = mysql_query($sqlInsAuth);

    $devicesUsed = getDevicesUsedCount($userEmail,'PE');
    //Send Email

    $to    = $poc;
    //$to         = 'fidelis@kutung.com';
    $from 	= 'info@ventureintelligence.in';
    $subject 	= "Authorization Code for PE Database(".$userEmail.")"; // Subject of the email

    //Message
    $message 	= 'Authorization Code for PE Database. Please find the details below:';

    $message 	.= "<p><b>Company ID :</b> ".$companyId."</p>";
    $message 	.= "<p><b>User Email :</b> ".$userEmail."</p>";
    $message 	.= "<p><b>Devices already in use:</b> ".$devicesUsed."</p>";
    $message 	.= "<p><b>Device Limit:</b> ".$allowedDevices."</p>";
    $message 	.= "<p><b>Authorization Code:</b> ".$authcode."</p>";
    $message 	.= "<p><b>Authorization Link:</b> <a href='".BASE_URL."dealsnew/auth.php'>".BASE_URL."dealsnew/auth.php</a></p>";
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
<li><a href="<?php echo BASE_URL; ?>news.htm">News</a></li>
<li><a href="<?php echo BASE_URL; ?>aboutus.htm">About Us</a></li>
<li class="last"><a href="<?php echo BASE_URL; ?>contactus.htm">Contact Us</a></li>
</ul>
</div>


<div class="login-container">

<div   class="login-left">

<form name="pelogin" onSubmit="return checkFields();" method="post" action="peloginip.php" >

<ul>
    <li><input type="text"  name="emailid" value=""  placeholder="Email"/></li>
    <li> <input type="password" name="emailpassword" value=""  placeholder="Password"/></li>

    <li>
    <div class="keeplogin"><input type="checkbox" name="chkTerm" CHECKED /> By accessing this database, you agree to the  <a href="../terms.htm">terms & conditions</a> of use upon which access is provided.</div>
    </li>

    <li><input type="submit" name="btnSubmit" value ="Login" class="fp"/> <a href="<?php echo BASE_URL; ?>dealsnew/forgetpwd.php?value=P"  class="forgot-link">Forgot your password?</a> </li>
    <li><font color="red"><?php echo $displayMessage; ?></font></li>
<li><font color="green"><?php echo ($_GET['flag']=='ca') ? 'You have been logged off as you had logged in to another device or browser.' : ''; ?></font></li>
<li><font color="green"><?php echo ($_GET['auth']=='1') ? 'Authorization successful. Please login now' : ''; ?></font></li>
</ul>
</form>

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

<div class="free-trail"><span>Request a free demo</span> <a href="<?php echo BASE_URL; ?>trial.htm">Request Now</a></div>

</div>

</div>

</div>

</body>
</html>