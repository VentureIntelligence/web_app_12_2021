<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    $search=trim($_REQUEST['search']);
    //echo $search;exit;
    $getcomSql="SELECT DCompId,DCompanyName FROM `dealcompanies` where `DCompanyName` like '".$search."%' group by `DCompanyName`";
    $jsonarray=array();

    if ($rscity = mysql_query($getcomSql))
    {
        While($myrow=mysql_fetch_array($rscity, MYSQL_BOTH))
        {
            $CompId=$myrow["DCompId"];
            $ComName=trim($myrow["DCompanyName"]);
            $comNamelower=strtolower($ComName);

            $jsonarray[]=array('id'=>$CompId,'label'=>$ComName,'value'=>$comNamelower);

        }
    }
    
    echo json_encode($jsonarray);           
?>
