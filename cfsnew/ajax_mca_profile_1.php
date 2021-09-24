<?php
include "header.php";
include "sessauth.php";
//echo posix_getpid();
// if(!isset($_SESSION)){
//     //session_save_path("/tmp");
//     session_start();
// }
$_SESSION[ 'procees_pid' ] = posix_getpid();
$cin = $_REQUEST['cin'];
include_once('simple_html_dom.php');

//Data from MCA website 
try{ 
    // $urltopost = "https://www.mca.gov.in/mcafoportal/companyLLPMasterData.do";

    $urltopost = "https://www.mca.gov.in/mcafoportal/companyLLPMasterData.do";

    $datatopost = array ("companyID" => $cin);
    $headerArray = array( 
        "Accept-Encoding" => "gzip, deflate", 
        "Accept-Language" => "en-US,en;q=0.9", 
        "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9", 
        "Content-Type" => "application/x-www-form-urlencoded",
        "Host"=>"https://www.mca.gov.in",
        "Upgrade-Insecure-Requests"=>"1",
        "Origin"=>"https://www.mca.gov.in",
        "Cookie"=>"HttpOnly"
    );
    $ch = curl_init ($urltopost);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT_MS, 60000);
     curl_setopt ($ch, CURLOPT_REFERER, 'http://www.mca.gov.in/mcafoportal/login.do');
    curl_setopt ($ch, CURLOPT_TIMEOUT, 120000);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36');
    curl_setopt ($ch, CURLOPT_HTTPHEADER, $headerArray);
    //curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
     curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
   
    
    
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
   // print_r(curl_getinfo($ch));
   // print_r($headerArray);
    if( $response != false) {
        if( $httpcode != 200 ) {
            // echo $httpcode;
            echo '<div id="masterData_403_error"><b>Unable to connect to MCA Server, please try after sometime</b></div>';
        } else {
           echo $response;    
        }
    }
    curl_close($ch);
}  catch (Exception $e) {
    print_r( $e );
}
 ?>
