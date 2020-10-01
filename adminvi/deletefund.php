<?php
// error_reporting(E_ALL); 
// ini_set( 'display_errors','1');
require("../dbconnectvi.php");
$Db = new dbInvestments();
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd")){
    $sesID=session_id();
    $Id=$_POST['DelFundId'];
    $userinfo= $_SESSION['name'];
    function deletemail($Id,$userinfo)
    {   $ids= implode(",",$Id);
        $currentTime = date("d-m-Y H:i:s");
        date_default_timezone_set ( "Asia/Kolkata" );
        $selectCompanyName = "SELECT peinvestors.Investor,fundRaisingDetails.dbType ,fundRaisingDetails.id  from fundRaisingDetails LEFT JOIN peinvestors ON fundRaisingDetails.investorId = peinvestors.InvestorId WHERE fundRaisingDetails.id IN ($ids)";
        
        $companyid = "";
            $to    = 'arun@ventureintelligence.in';
            $from 	= 'info@ventureintelligence.in';
            $subject 	= "Deleted Fund details"; // Subject of the email
            //Message
            $message 	= 'Please find the details below:';

            $message 	.= "<p></p>";

            $message 	.="<table style='border-spacing: 0px;'><tr><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Admin User name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Funding ID</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Investor Name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Database Type</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Deleted Time</th></tr>";
            if ($companyrs = mysql_query($selectCompanyName))
            {
               while($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
                {
                    $message .="<tr><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$userinfo."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$myrow['id']."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$myrow['Investor']."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$myrow['dbType']."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$currentTime."</td></tr>";
                     
                }
               
            }
            $message .= "</table>";
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: VI Admin <info@ventureintelligence.in>' . "\r\n";
            $headers .= "Reply-To: no-reply@ventureintelligence.com\r\n";
            $headers .= 'Cc: heyram.vi@gmail.com, vijayakumar.k@praniontech.com, krishna.s@praniontech.com' . "\r\n";

            
            if (@mail($to, $subject, $message, $headers)){
            }else{
            }
    }
    if($Id > 0)
    {   deletemail($Id,$userinfo);
        foreach ($Id as $repId)
        {

            $query = "DELETE FROM fundRaisingDetails WHERE id='$repId'";
            mysql_query($query);
        }
        header('Location:fundlist.php');
        exit();
    }
}