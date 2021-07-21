<?php

    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();

    // echo '<pre>'; print_r($_REQUEST); echo '</pre>';
    // exit;

    $VCFlagValue=$_REQUEST['vcflag'];
    $search=trim($_REQUEST['search']);
    //echo $search;exit;
    $getcitySql="SELECT * FROM `city` where `city_name` like '".$search."%' group by `city_name`";

    // echo '<pre>'; print_r($getcitySql); echo '</pre>';

    $jsonarray=array();

    if ($rscity = mysql_query($getcitySql))
    {
        // echo '<pre>'; print_r($rscity); echo '</pre>';

        While($myrow=mysql_fetch_array($rscity, MYSQL_BOTH))
        {
            // echo '<pre>'; print_r($myrow); echo '</pre>';

            $cityId=$myrow["city_id"];
            $cityName=trim($myrow["city_name"]);
            $cityNamelower=$cityName;
            $regionId=$myrow["regionId"];
            $stateId=$myrow["city_StateID_FK"];


            $jsonarray[]=array('id'=>$cityId,'label'=>$cityName,'value'=>$cityNamelower,'regionId'=>$regionId,'stateId'=>$stateId);

        }
    }
    
    echo json_encode($jsonarray);
            
               
?>
