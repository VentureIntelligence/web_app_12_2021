<?php
error_reporting(E_ALL); 
ini_set( 'display_errors','1');
require("../dbconnectvi.php");
$Db = new dbInvestments();

$Id=$_POST['DelFundId'];
function deletemail($Id)
{   $ids= implode(",",$Id);
    $currentTime = date("Y-m-d h:i:s");
    $selectCompanyName = "SELECT fundNames.fundName ,fundNames.dbtype ,fundNames.fundId from fundRaisingDetails JOIN fundNames ON fundRaisingDetails.fundName = fundNames.fundId WHERE fundRaisingDetails.id IN ($ids)";

    $companyid = "";
        $to    = 'arun@ventureintelligence.in';
        $from 	= 'info@ventureintelligence.in';
        $subject 	= "Deleted Company Details"; // Subject of the email
        //Message
        $message 	= 'Please find the details below:';

        $message 	.= "<p></p>";

        $message 	.="<table style='border-spacing: 0px;'><tr><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Admin User name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Funding ID</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Funding Name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Database Type</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Deleted Time</th></tr>";
            if ($companyrs = mysql_query($selectCompanyName))
        {
            While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
            {
                $message .="<tr><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$username."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$myrow['fundId']."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$myrow['fundName']."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$myrow['dbtype']."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$currentTime."</td></tr>";
                // $message 	.= "<p>&nbsp;</p>";
            }
        }
        $message .= "</table>";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: VI Admin <info@ventureintelligence.in>' . "\r\n";
        $headers .= "Reply-To: no-reply@ventureintelligence.com\r\n";
        $headers .= 'Cc: heyram.vi@gmail.com, vijayakumar.k@praniontech.com' . "\r\n";

        
        if (@mail($to, $subject, $message, $headers)){
        }else{
        }
}
if($Id > 0)
{   deletemail($Id);
    foreach ($Id as $repId)
    {

        $query = "DELETE FROM fundRaisingDetails WHERE id='$repId'";
        mysql_query($query) or die(mysql_error());
    }
    header('Location: fundlist.php');
    exit();
}