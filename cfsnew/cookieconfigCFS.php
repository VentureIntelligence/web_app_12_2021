<?php

$cookieName = 'CFS'.$authAdmin['firstname'].'-'.$authAdmin['user_id'].'-'.rand();
$currCookieArray[$authAdmin['email']]=$cookieName;
$currCookieJson=  json_encode($currCookieArray);
setcookie('cfsLoginAuth',$currCookieJson,0,'/'); // 86400 = 1 day //Create Cookie
                        //Store Cookie value in DB
$sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`)";
$sqlInsCookie .= " VALUES ('".$authAdmin['email']."','".$cookieName."','0','CFS')";
mysql_query($sqlInsCookie) or die(mysql_error());

?>