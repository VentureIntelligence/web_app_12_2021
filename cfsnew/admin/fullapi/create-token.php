<?php

$fullapi_info = $_POST['fullapi_info'];
date_default_timezone_set("Asia/Calcutta");
//Default Token
$token = md5(uniqid(rand(), true));
$token_trim = uniqid();
//Date And Time Token

$t = microtime(true);
$micro = sprintf("%06d",($t - floor($t)) * 1000000);
$d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

echo $date_time_token = $d->format("ymdHisu").$token_trim; // note at point on "u"
?>