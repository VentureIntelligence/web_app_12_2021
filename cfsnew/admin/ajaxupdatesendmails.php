<?php
    include "header.php";
    require_once MODULES_DIR."cprofile.php";
    $cprofile = new cprofile();
    require_once MODULES_DIR."mail_log.php";
    $maillog = new mail_log();

    $from=$_POST['from'];
    $to=$_POST['to'];
    $cc = $_POST['cc'];
    $bcc = $_POST['bcc'];
    $financials = $_POST['financials'];
    $annual_filings = $_POST['annual_filings']; 
    $latest_financials = $_POST['latest_financials'];
    $last_filled = $_POST['last_filled'];
    $radioVal = $_POST["message"];
    $companyId = $_POST["companyId"];
    $signature = $_POST["signature"];
    $textMessage = $_POST["textMessage"];
    $company = $cprofile->getCompaniesnames($companyId);
    $subject = 'Financials of '.$company['FCompanyName'].' - '.$company['SCompanyName'];
    $inser_mail_log['companyId'] = $_POST["companyId"];
    $inser_mail_log['from_address'] = $_POST["from"];
    $inser_mail_log['to_address'] = $_POST["to"];
    $inser_mail_log['cc_address'] = $_POST["cc"];
    $inser_mail_log['bcc_address'] = $_POST["bcc"];
    $inser_mail_log['textMessage'] = $_POST["textMessage"];
    //echo $subject;
    
    if($radioVal == "0")
    {
        $message .= '<label>We have updated Latest Financials and Annual Filings of the company. Please visit the following link to access the same:</label><br/><br/><div ><label><b>Financials &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;</b></label>'.$financials.'<br/><br/><label><b>Annual Filings&nbsp;&nbsp;: &nbsp;&nbsp;</b></label>'.$annual_filings.'</div><br/>';
    }
    else if ($radioVal == "1")
    {
        $message .= '<label>Latest financial <b>FY '.$latest_financials.'</b> unavailable. Company has last filed <b>FY '.$last_filled.'</b></label><br/><br/>';
    }

    $message .= $textMessage;
    $message .= "<br><br><br/>";
    $message .= $signature;
   
  
   $savemessage = strip_tags(preg_replace("/\s|&nbsp;/",' ',$message));
   //echo strip_tags($savemessage);
    
    
    //echo $companyId;
    //echo $company['FCompanyName'];
    $inser_mail_log['message'] = $savemessage;

    $maillog->update($inser_mail_log);

    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n"; 
    $headers .= "Cc: $cc\r\n";
    $headers .= "Bcc: $bcc\r\n";
   
    //echo $message;
    if (@mail($to, $subject, $message, $headers)){
        echo "1";
    }else{
        echo "0";
    }
    //echo "1";
    
?>
