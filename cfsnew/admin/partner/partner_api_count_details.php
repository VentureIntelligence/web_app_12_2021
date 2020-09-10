<?php 

    include "header.php";
    include( dirname(__FILE__)."/../../etc/conf.php");

    $TokenID = $_POST['token'];

    $sqlrun=[];
    $array=array();
       
    $sql = "SELECT DISTINCT api_partner.partner_id,
				(SELECT COUNT(DISTINCT(companyName)) FROM partner_apitracking
				 WHERE partnerToken='".$TokenID."' and (companyName !='')) AS searchApi,(SELECT COUNT(*) FROM partner_apitracking
                 WHERE partnerToken = '".$TokenID."') AS apiCount FROM api_partner";
                 
    $sqlrun = mysql_query($sql);
    while($row = mysql_fetch_array($sqlrun )) {
            $array['a_count']=$row['apiCount'];
            $array['s_count']=$row['searchApi'];
    }
    echo json_encode($array); 
?>