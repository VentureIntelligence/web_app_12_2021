<?php
//print_r($_REQUEST);
require("../dbconnectvi.php");
$Db = new dbInvestments();

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
    echo json_encode($deletedemails);
    exit();
?>