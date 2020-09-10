<?php
   function insertlog($delPEIdtoDelete,$dbtype,$username)
    {
        $currentTime = date("Y-m-d h:i:s");

        $selectCompanyName = "SELECT pec.companyname from pecompanies as pec JOIN peinvestments as peinv on peinv.PECompanyId = pec.PECompanyId where PEId = $delPEIdtoDelete";
        $companyname = "";
        if ($companyrs = mysql_query($selectCompanyName))
		{
			
			While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
			{
				$companyname = $myrow['companyname'];
			}
		}
        $log_query = "insert into pedelete_log (username,PEId,companyname,dbtype,Deleted_date) values ('$username','$delPEIdtoDelete','$companyname','$dbtype','$currentTime')  ";
       
        if($log = mysql_query($log_query))
        {
          	$to    = 'arun@ventureintelligence.in';
		    //$to    = $poc;
		    //$to         = 'fidelis@kutung.com';
		    $from 	= 'info@ventureintelligence.in';
		    $subject 	= "Deleted Company Details"; // Subject of the email
		    //Message
		    $message 	= 'Please find the details below:';

		    $message 	.= "<p></p>";

		    $message 	.="<table style='border-spacing: 0px;'><tr><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Admin User name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>PE Company ID</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Company Name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Database Type</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Deleted Time</th></tr>";
		    
		    $message 	.="<tr><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$username."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$delPEIdtoDelete."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$companyname."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$dbtype."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$currentTime."</td></tr></table>";
		//     $message 	.= "<p><b>Admin User name :</b> ".$username."</p>";
		//     $message 	.= "<p><b>PE Company ID :</b> ".$delPEIdtoDelete."</p>";
		//     $message 	.= "<p><b>Database Type :</b> ".$dbtype."</p>";
		// //    $message 	.= "<p><b>Devices already in use:</b> ".$devicesUsed."</p>";
		// //    $message 	.= "<p><b>Device Limit:</b> ".$allowedDevices."</p>";
		//     $message 	.= "<p><b>Deleted Time :</b> ".$currentTime."</p>";

		    //$message 	.= "<p>System Note :Authorization will not be allowed if the device limit is exceeded.</p>";
		    $message 	.= "<p>&nbsp;</p>";

		    $headers  = 'MIME-Version: 1.0' . "\r\n";
		    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		    $headers .= 'From: VI Admin <info@ventureintelligence.in>' . "\r\n";
		    $headers .= "Reply-To: no-reply@ventureintelligence.com\r\n";
		    $headers .= 'Cc: heyram.vi@gmail.com, vijayakumar.k@praniontech.com' . "\r\n";

		    if (@mail($to, $subject, $message, $headers)){
		    }else{
		    }
        }
       

    }
?>

