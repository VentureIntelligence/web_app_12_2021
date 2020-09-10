<?php
if(!isset($_SESSION)){
    //session_save_path("/tmp");
    session_start();
}
$_SESSION[ 'procees_pid' ] = posix_getpid();
$cin = $_REQUEST['cin'];
include_once('simple_html_dom.php');
//Data from MCA website 
try{ 
    $urltopost = "http://www.mca.gov.in/mcafoportal/companyLLPMasterData.do";
    $datatopost = array ("companyID" => $cin);
    $headerArray = array( 
        "Accept-Encoding" => "gzip, deflate", 
        "Accept-Language" => "en-US,en;q=0.9", 
        "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8", 
        "Content-Type" => "application/x-www-form-urlencoded" 
    );
    $ch = curl_init ($urltopost);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT_MS, 60000);
    curl_setopt($ch, CURLOPT_TIMEOUT,   60000);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.81 Safari/537.36');
    curl_setopt ($ch, CURLOPT_HTTPHEADER, $headerArray);
    curl_setopt($ch, CURLINFO_HEADER_OUT, true);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $response = curl_exec($ch);
    if( $response !== false) {
        if( $httpcode == 403 ) {
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
