<?php
//print_r($_REQUEST);
require("../dbconnectvi.php");
$Db = new dbInvestments();
$username= $_SESSION['name'];

    $deletedemails = array();
    
    if($_POST['perEmailId']!=''){
        
        $perEmailId = explode(",", $_POST['perEmailId']);
        $perEmailArrayLength = count($perEmailId);
    }
    
    if($_POST['perMAEmailId']){
        
        $perMAEmailId=explode(",", $_POST['perMAEmailId']);
        $perMAEmailArrayLength=count($perMAEmailId);
    }
    
    if($_POST['perREEmailId']!=''){
        
        $perREEmailId = explode(",", $_POST['perREEmailId']);
        $perREEmailArrayLength=count($perREEmailId);
    }

    
    $perEmailId1['PE']= $perEmailId;
    $perMAEmailId1['MA']=$perMAEmailId;
    $perREEmailId1['RE']=$perREEmailId;
    $companyId = explode(",", $_POST['companyId']);
    //print_r($companyId);
    $companyid=$companyId[0];
    //$array_count=$DeleteEmailArrayLength+$MDeleteEmailArrayLength+$RDeleteEmailArrayLength;
    $test_array=array_merge($perEmailId1,$perMAEmailId1,$perREEmailId1);
    
   // deletemail($test_array,$username,$companyid);
    
    if($perEmailArrayLength >= 0){
        //deletemail($DeleteEmailId,"PE",$username);
        for ($i=0;$i<$perEmailArrayLength;$i++)
        {
                $mailid=trim($perEmailId[$i]);
                
                $perMemberSql= "Update dealmembers set Deleted=1 where Emailid='$mailid' ";
                //echo "<Br>--" .$delMemberSql;
                if ($companyrs=mysql_query($perMemberSql))
                {
                        $deletedemails[]=$mailid."-- Permission changed (PE login)";
                }
                else
                {
                        $deletedemails[]=$mailid."-- Permission Failed (PE login)";

                }
        }
        $premail=implode('","',$perEmailId);
        $premail=trim($premail,',"');
        $uncheckedsql= 'Update dealmembers set Deleted=0 where Emailid NOT IN("'.$premail.'")';
        mysql_query($uncheckedsql);
        
    }

    if($perMAEmailArrayLength >= 0){
        //deletemail($MADeleteEmailId,"MA",$username);
        for ($j=0;$j<$perMAEmailArrayLength;$j++)
        {
                $MAmailid=trim($perMAEmailId[$j]);
                $perMAMemberSql="Update malogin_members set Deleted=1 where Emailid='$MAmailid'";
                //echo "<Br>--" .$MAdelMemberSql;
                if ($MAcompanyrs=mysql_query($perMAMemberSql))
                {
                        $deletedemails[]=$MAmailid."-- Permission changed (MA login)";
                }
                else
                {
                        $deletedemails[]=$MAmailid."-- Permission Failed (Merger login)";
                }
        }
        $premail1=implode('","',$perMAEmailId);
        $premail1=trim($premail1,',"');
        $uncheckedsql1= 'Update malogin_members set Deleted=0 where Emailid NOT IN("'.$premail1.'")';
        mysql_query($uncheckedsql1);
    }
     
    if($perREEmailArrayLength >= 0){
        //deletemail($REDeleteEmailId,"RE",$username);
        // re login
        for ($k=0;$k<$perREEmailArrayLength;$k++)
        {
                $REmailid=trim($perREEmailId[$k]);
                $perREMemberSql="Update RElogin_members set Deleted=1 where Emailid='$REmailid'";
                //echo "<Br>--" .$REdelMemberSql;
                if ($REcompanyrs=mysql_query($perREMemberSql))
                {
                    $deletedemails[]=$REmailid."-- Permission changed (RE login)";
                }
                else
                {
                    $deletedemails[]=$REmailid."-- Permission Failed (RE login)";
                }
        }
        $premail2=implode('","',$perREEmailId);
        $premail2=trim($premail2,',"');
        $uncheckedsql2= 'Update RElogin_members set Deleted=0 where Emailid NOT IN("'.$premail2.'")';
        mysql_query($uncheckedsql2);
    }
    // function deletemail($delPEIdtoDelete,$username,$companyid)
    // {  
        
        
    //     // $ids=implode("','",$delPEIdtoDelete);
    //     // $ids="'".str_replace(" ","",$ids)."'";
    //     date_default_timezone_set ( "Asia/Kolkata" );
    //     $currentTime = date("d-m-Y H:i:s");
    //     // if($dbtype == "PE"){
    //     //     $dbname = "dealmembers";
    //     // }else if($dbtype == "MA"){
    //     //     $dbname = "malogin_members";
    //     // }else if($dbtype == "RE"){
    //     //     $dbname = "RElogin_members";
    //     // }
    //     // $selectCompanyName = "SELECT DCompId from $dbname where EmailId IN ($ids)";
    //     // $companyid = array();
    //     // if ($companyrs = mysql_query($selectCompanyName))
	// 	// {
	// 	// 	While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
	// 	// 	{
	// 	// 		$companyid[] = $myrow['DCompId'];
    //     //     }
    //     // }
    //         $to    = 'arun@ventureintelligence.in, sales@ventureintelligence.com';
    //         $from 	= 'info@ventureintelligence.in';
	// 	    $subject 	= "Deleted Subscriber details"; // Subject of the email
	// 	    //Message
	// 	    $message 	= 'Please find the details below:';

	// 	    $message 	.= "<p></p>";

	// 	    $message 	.="<table style='border-spacing: 0px;'><tr><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Admin User name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Subscriber ID</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Subscriber Name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Database Type</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Deleted Time</th></tr>";
    //         // for($i=0;$i<$array_count;$i++){
    //         //     $message .="<tr><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$username."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$companyid."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$delPEIdtoDelete[$i]."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$dbtype."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$currentTime."</td></tr>";
    //         //     // $message .= "<p>&nbsp;</p>";
    //         // }
    //         foreach($delPEIdtoDelete as $key=>$value)
    //         {
    //             $dbname=$key;
    //             for($j=0;$j<count($delPEIdtoDelete[$key]);$j++){
    //                 $message .="<tr><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$username."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$companyid."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$delPEIdtoDelete[$key][$j]."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$key."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$currentTime."</td></tr>";
    //             }
                
    //         }
    //         $message .= "</table>";
	// 	    $headers  = 'MIME-Version: 1.0' . "\r\n";
	// 	    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	// 	    $headers .= 'From: VI Admin <info@ventureintelligence.in>' . "\r\n";
	// 	    $headers .= "Reply-To: no-reply@ventureintelligence.com\r\n";
	// 	    $headers .= 'Cc: heyram.vi@gmail.com, vijayakumar.k@praniontech.com' . "\r\n";
            
	// 	    if (@mail($to, $subject, $message, $headers)){
	// 	    }else{
	// 	    }
    // }
    echo json_encode($deletedemails);
    exit();
?>