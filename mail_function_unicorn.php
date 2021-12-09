

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
    $to         = 'weekly@ventureintelligence.com'; 
    $from 	    = 'info@ventureintelligence.in';               
    $subject 	= "Unicorn Report";

    $message 	= '<br><br>';
    
    $message  .= '<table width="80%" cellspacing="0" cellpadding="0" style="border: solid 1px #ccc;">';
    
    $message  .= '<tr><td colspan="2"  style="background-color: #EFEFEF;"> <h3 style="text-align:center">VC Handbook & Directory</h3> <br></td></tr>';
         
   
     if($name)
    $message 	.= "<tr><td width='30%' style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Name</td> <td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$name."</td></tr>";
    
   
    if($designation)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Designation</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$designation."</td></tr>";
    
    
    if($emailid)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Email Id</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$emailid."</td></tr>";
    
    
    if($companyname)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>City</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$companyname."</td></tr>";
    
    
    if($phone)
    $message 	.= "<tr><td style='font-weight: bold;border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>Phone</td><td style='border-bottom: solid 1px #E8E8E8; padding: 12px 20px;'>".$phone."</td></tr>";
    
      
    $message .= "</table>";



    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n"; 
    $headers .= "Reply-To: $to\r\n"; 
   // $headers .= 'Cc: subscription@ventureintelligence.com,fidelis@kutung.com' . "\r\n";
    $headers .= 'Cc: narasimman.p@praniontech.com' . "\r\n";

    if (mail($to, $subject, $message, $headers)){
        $mailStatus=1;
    }else{
        $mailStatus=0;
    }
    
    // echo $Status;
    
    if($mailStatus == 1)
    {
        if($emailid != "" && $name != ""  && $designation != ""  && $companyname != "" && $phone != "" )
        {
            $insunicornreport="insert into india_unicorn_report(email,name,companyname,designation,mobileno,created_at,created_by)
            values('$emailid','$name','$companyname','$designation','$phone','$created_at','')";
    
            $rsIndUniRep = mysql_query($insunicornreport);

            echo 1 ;
    
            // if($rsIndUniRep){
            //     echo '1';
            // }
            // else{
            //     echo '0';
            // }
        }else{
            echo 0 ;
        }
    }else{
        echo 0;
    }

   



    // echo $insunicornreport; exit;



?>