<?php
include "header.php";
include "sessauth.php";
    $from=$_POST['from'];
    $to=$_POST['to'];
    
    $subject=$_POST['subject'];
    $message=$_POST['message'];
    $cc=$_POST['cc'];
    
    $url_link=$_POST['url_link'];
    if($url_link !=''){
        $message .= "<br/> Link -".$url_link;
    }

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n"; 
    $headers .= "Cc: $cc\r\n";

    if (@mail($to, $subject, $message, $headers)){
        echo "1";
    }else{
        echo "0";
    }
    
    
?>
