<?php 

    include "header.php";
    include( dirname(__FILE__)."/../../etc/conf.php");

    $TokenID = $_POST['token'];

    $sqlrun=[];
    $array=array();
       
    $sql = "SELECT DISTINCT pe_api_partner.partner_id,
				(SELECT COUNT(DISTINCT(apiName)) FROM pe_partner_apitracking
				 WHERE partnerToken='".$TokenID."' and (companyName !='')) AS searchApi,(SELECT COUNT(DISTINCT(companyName)) FROM pe_partner_apitracking
                 WHERE partnerToken = '".$TokenID."') AS apiCount,(SELECT COUNT(*) FROM pe_partner_apitracking
                 WHERE partnerToken = '".$TokenID."') AS overallCount FROM pe_api_partner";
                 
    $sqlrun = mysql_query($sql);
    while($row = mysql_fetch_array($sqlrun )) {
            $array['a_count']=$row['apiCount'];
            $array['s_count']=$row['searchApi'];
            $array['o_count']=$row['overallCount'];
    }
   echo json_encode($array); 
?>