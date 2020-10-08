<?php
//print_r($_REQUEST);
require("../dbconnectvi.php");
$Db = new dbInvestments();
$username= $_SESSION['name'];

    $deletedemails = array();
    
    if($_POST['DelEmailId']!=''){
        
        $DeleteEmailId = explode(",", $_POST['DelEmailId']);
        $DeleteEmailArrayLength = count($DeleteEmailId);
    }
    
    if($_POST['MADelEmailId']){
        
        $MADeleteEmailId=explode(",", $_POST['MADelEmailId']);
        $MDeleteEmailArrayLength=count($MADeleteEmailId);
    }
    
    if($_POST['REDelEmailId']!=''){
        
        $REDeleteEmailId = explode(",", $_POST['REDelEmailId']);
        $RDeleteEmailArrayLength=count($REDeleteEmailId);
    }

    if($DeleteEmailArrayLength > 0){
        deletemail($DeleteEmailId,"PE",$username);
        for ($i=0;$i<$DeleteEmailArrayLength;$i++)
        {
                $mailid=trim($DeleteEmailId[$i]);
                $delMemberSql="delete from dealmembers where Emailid='$mailid'";
                //$delMemberSql= "Update dealmembers set Deleted=1 where 					//Emailid='$mailid' ";
                //echo "<Br>--" .$delMemberSql;
                if ($companyrs=mysql_query($delMemberSql))
                {
                        $deletedemails[]=$mailid."-- Deleted (PE login)";
                }
                else
                {
                        $deletedemails[]=$mailid."-- Delete Failed (PE login)";

                }
        }
    }

    if($MDeleteEmailArrayLength >0){
        
        for ($j=0;$j<$MDeleteEmailArrayLength;$j++)
        {
                $MAmailid=trim($MADeleteEmailId[$j]);
                deletemail($MADeleteEmailId,"MA",$username);
                $MAdelMemberSql="delete from malogin_members where Emailid='$MAmailid'";
                //echo "<Br>--" .$MAdelMemberSql;
                if ($MAcompanyrs=mysql_query($MAdelMemberSql))
                {
                        $deletedemails[]=$MAmailid."-- Deleted (MA login)";
                }
                else
                {
                        $deletedemails[]=$MAmailid."-- Delete Failed (Merger login)";
                }
        }
    }
     
    if($RDeleteEmailArrayLength >0){
        // re login
        for ($k=0;$k<$RDeleteEmailArrayLength;$k++)
        {
                $REmailid=trim($REDeleteEmailId[$k]);
                //echo $REmailid.'<br>';
                deletemail($REDeleteEmailId,"RE",$username);
                $REdelMemberSql="delete from RElogin_members where Emailid='$REmailid'";
                //echo "<Br>--" .$REdelMemberSql;
                if ($REcompanyrs=mysql_query($REdelMemberSql))
                {
                    $deletedemails[]=$REmailid."-- Deleted (RE login)";
                }
                else
                {
                    $deletedemails[]=$REmailid."-- Delete Failed (RE login)";
                }
        }
    }
    function deletemail($delPEIdtoDelete,$dbtype,$username)
    {  
        $ids=implode("','",$delPEIdtoDelete);
        $ids="'".str_replace(" ","",$ids)."'";
        date_default_timezone_set ( "Asia/Kolkata" );
        $currentTime = date("d-m-Y H:i:s");
        if($dbtype == "PE"){
            $dbname = "dealmembers";
        }else if($dbtype == "MA"){
            $dbname = "malogin_members";
        }else if($dbtype == "RE"){
            $dbname = "RElogin_members";
        }
        $selectCompanyName = "SELECT DCompId from $dbname where EmailId IN ($ids)";
        $companyid = array();
        if ($companyrs = mysql_query($selectCompanyName))
		{
			While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
			{
				$companyid[] = $myrow['DCompId'];
            }
        }
            //$to    = 'arun@ventureintelligence.in, sales@ventureintelligence.com';
            $to    = 'krishna.s@praniontech.com';
		    $from 	= 'info@ventureintelligence.in';
		    $subject 	= "Deleted Subscriber details"; // Subject of the email
		    //Message
		    $message 	= 'Please find the details below:';

		    $message 	.= "<p></p>";

		    $message 	.="<table style='border-spacing: 0px;'><tr><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Admin User name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Subscriber ID</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Subscriber Name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Database Type</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Deleted Time</th></tr>";
            for($i=0;$i<count($companyid);$i++){
                $message .="<tr><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$username."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$companyid[$i]."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$delPEIdtoDelete[$i]."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$dbtype."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$currentTime."</td></tr>";
                // $message .= "<p>&nbsp;</p>";
            }
            $message .= "</table>";
		    $headers  = 'MIME-Version: 1.0' . "\r\n";
		    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		    $headers .= 'From: VI Admin <info@ventureintelligence.in>' . "\r\n";
		    $headers .= "Reply-To: no-reply@ventureintelligence.com\r\n";
		    // $headers .= 'Cc: heyram.vi@gmail.com, vijayakumar.k@praniontech.com' . "\r\n";
            $headers .= 'Cc:  vijayakumar.k@praniontech.com' . "\r\n";
            
		    if (@mail($to, $subject, $message, $headers)){
		    }else{
		    }
    }
    echo json_encode($deletedemails);
    exit();
?>