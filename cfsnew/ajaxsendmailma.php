<?php

        $to=$_POST['to'];
       
        $subject=$_POST['subject'];
        $link=$_POST['message'];
        $message='';		             
        $userEmail = $_POST['userMail'];      
        //Message 
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "From: $userEmail\r\n"; 
        $headers .= "Reply-To: $userEmail\r\n"; 
        //$headers .= 'Bcc: junaid@kutung.com' . "\r\n";
        $headers .= 'Bcc: database-forward@ventureintelligence.com,arun.natarajan@gmail.com' . "\r\n";
        $message.='<strong>Link : </strong>'.$link.'<br><br>';
        
        
        if (@mail($to, $subject, $message, $headers)){
            echo "1";
        }else{
            echo "0";
        }
    
    
?>
