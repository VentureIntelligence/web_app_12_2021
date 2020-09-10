<?php

$cookieName = 'PE'.$myrow['Name'].'-'.$myrow['DCompId'].'-'.rand();
$currCookieArray[$myrow['EmailId']]=$cookieName;
$currCookieJson=  json_encode($currCookieArray);
setcookie('peLoginAuth',$currCookieJson,0,'/'); // 86400 = 1 day //Create Cookie
//echo $_COOKIE['peLoginAuth'];
                                    //Store Cookie value in DB
$sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`,`auth_type`)";
$sqlInsCookie .= " VALUES ('".$myrow['EmailId']."','".$cookieName."','".$myrow['DCompId']."','PE','1')";
mysql_query($sqlInsCookie) or die(mysql_error());

?>