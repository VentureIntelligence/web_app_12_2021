<?php 

    include "header.php";
    include( dirname(__FILE__)."/../../etc/conf.php");

    $TokenID = $_POST['token'];

    $sqlrun=[];
    $array=array();
       
    $sql = "SELECT DISTINCT fullapi_user.fullapi_user_id,
				(SELECT COUNT(DISTINCT(companyName)) FROM fullapi_tracking
				 WHERE userToken='".$TokenID."' and (companyName !='')) AS searchApi,(SELECT COUNT(*) FROM fullapi_tracking
                 WHERE userToken = '".$TokenID."') AS apiCount FROM fullapi_user";
                 
    $sqlrun = mysql_query($sql);
    while($row = mysql_fetch_array($sqlrun )) {
            $array['a_count']=$row['apiCount'];
            $array['s_count']=$row['searchApi'];
    }
    echo json_encode($array); 
?>