<?php

    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    $VCFlagValue=$_REQUEST['vcflag'];
    $search=trim($_REQUEST['search']);
    //echo $search;exit;
    $getcitySql="SELECT * FROM `city` where `city_name` like '".$search."%' group by `city_name`";
    $jsonarray=array();

    if ($rscity = mysql_query($getcitySql))
    {
        While($myrow=mysql_fetch_array($rscity, MYSQL_BOTH))
        {
            $cityId=$myrow["city_id"];
            $cityName=trim($myrow["city_name"]);
            $cityNamelower=$cityName;
            $regionId=$myrow["regionId"];

            $jsonarray[]=array('id'=>$cityId,'label'=>$cityName,'value'=>$cityNamelower,'regionId'=>$regionId);

        }
    }
    
    echo json_encode($jsonarray);
            
               
?>
