<?php
$din = $_POST['din'];
//Data from MCA website 
$urltopost = "http://www.mca.gov.in/mcafoportal/directorMasterDataPopup.do";
$datatopost = array ("din" => $din);
$headerArray = array( 
    // "Accept-Encoding" => "gzip, deflate", 
    // "Accept-Language" => "en-US,en;q=0.9", 
    // "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8", 
    // "Content-Type" => "application/x-www-form-urlencoded" 
        "Accept-Encoding" => "gzip, deflate", 
        "Accept-Language" => "en-US,en;q=0.9", 
        "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9", 
        "Content-Type" => "application/x-www-form-urlencoded",
        "Host"=>"http://www.mca.gov.in",
        "Upgrade-Insecure-Requests"=>"1",
        "Origin"=>"http://www.mca.gov.in",
        "Cookie"=>"HttpOnly"
);
//  $ch = curl_init ($urltopost);
// curl_setopt ($ch, CURLOPT_POST, true);
// curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.81 Safari/537.36');
// curl_setopt ($ch, CURLOPT_HTTPHEADER, $headerArray);
// curl_setopt($ch, CURLINFO_HEADER_OUT, true);
// echo $returndata = curl_exec ($ch);
$ch = curl_init ($urltopost);
curl_setopt ($ch, CURLOPT_POST, true);
curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT_MS, 60000);
curl_setopt ($ch, CURLOPT_REFERER, 'http://www.mca.gov.in/mcafoportal/login.do');
curl_setopt ($ch, CURLOPT_TIMEOUT, 120000);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36');
curl_setopt ($ch, CURLOPT_HTTPHEADER, $headerArray);
curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
echo $returndata = curl_exec ($ch);
curl_close($ch);
?>