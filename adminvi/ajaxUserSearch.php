<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    $search=trim($_REQUEST['search']);
    //echo $search;exit;
    $getcomSql="SELECT DCompId,EmailId FROM `dealmembers` where `EmailId` like '".$search."%' and substring_index(EmailId, '@', -1)  NOT IN ('kutung.com') group by `EmailId` ";
    $jsonarray=array();

    if ($rscity = mysql_query($getcomSql))
    {
        While($myrow=mysql_fetch_array($rscity, MYSQL_BOTH))
        {
            $CompId=$myrow["DCompId"];
            $ComName=trim($myrow["EmailId"]);
            $comNamelower=strtolower($ComName);

            $jsonarray[]=array('id'=>$CompId,'label'=>$ComName,'value'=>$comNamelower);

        }
    }
    
    echo json_encode($jsonarray);           
?>
