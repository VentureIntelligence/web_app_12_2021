

<?php

require("dbconnectvi.php");
     $Db = new dbInvestments();

session_save_path("/tmp");
session_start();

// echo '<pre>'; print_r($_POST); echo '</pre>';exit;


    $emailid = $_POST['emailid'];
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $companyname = $_POST['companyname'];
    $phone = $_POST['phone'];
    $created_at =  date('Y-m-d H:i:s');


    //Send Email
    $to         = 'narasimman.p@praniontech.com'; 
    $from 	    = 'info@ventureintelligence.in';               
    $subject 	= "Unicorn Report";
    $message    = 'hi';



    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n"; 
    $headers .= "Reply-To: $to\r\n"; 
   // $headers .= 'Cc: subscription@ventureintelligence.com,fidelis@kutung.com' . "\r\n";
    $headers .= 'Cc: narasimman.p@praniontech.com' . "\r\n";

    if (@mail($to, $subject, $message, $headers)){
        $Status=1;
    }else{
        $Status=0;
    }
    
    // echo $Status;
    
    if($Status == 1)
    {
        if($emailid != "" && $name != ""  && $designation != ""  && $companyname != "" && $phone != "" )
        {
            $insunicornreport="insert into india_unicorn_report(email,name,companyname,designation,mobileno,created_at,created_by)
            values('$emailid','$name','$companyname','$designation','$phone','$created_at','')";
    
            $rsIndUniRep = mysql_query($insunicornreport);
    
            if($rsIndUniRep){
                echo '1';
            }
            else{
                echo '0';
            }
        }else{
            echo 0 ;
        }
    }else{
        echo 0;
    }

   



    // echo $insunicornreport; exit;



?>