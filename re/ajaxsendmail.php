<?php

    
    $to=$_POST['to'];
    
    $subject=$_POST['subject'];
    $basesubject=$_POST['basesubject'];
    $link=$_POST['message'];
    $ymessage=$_POST['ymessage'];
    
    $userEmail=$_POST['userMail'];
    $message='';
 
    //Send Email
    
//    $to         = 'fidelis@kutung.com'; 		
    $from 	= 'info@ventureintelligence.in';               

    //Message 
  

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: ".$from."\r\n"; 
    $headers .= "Reply-To: ".$userEmail."\r\n"; 
    //$headers .= 'Bcc: database-forward@ventureintelligence.com,arun.natarajan@gmail.com' . "\r\n";
    $message='Your Friend/Colleague shared a '.$basesubject.',<br><br>';
    $message.='<strong>Link : </strong>'.$link.'<br><br>';
    if($ymessage!='')
    {
        $message.='<strong>Message : </strong><br><p>'.$ymessage.'</p>';
    }
    //$message=$message.'<br><br>'.$ymessage;
    if (@mail($to, $subject, $message, $headers)){
        echo "1";
    }else{
        echo "0";
    }
    
    
?>
