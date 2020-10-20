<?php 

    include "header.php";
    include( dirname(__FILE__)."/../../etc/conf.php");

    $TokenID = $_POST['token'];

    $sqlrun=[];
    $array=array();
       
    $sql = "SELECT DISTINCT pe_api_partner.partner_id,
				(SELECT COUNT(apiName) FROM pe_partner_apitracking
				 WHERE token='".$TokenID."' and companyName IS NOT NULL and apiName in ('/deals/investments/pe/deallist','/deals/investments/vc/deallist','/deals/investments/social/deallist', '/deals/investments/cleantech/deallist','/deals/investments/infrastructure/deallist', '/deals/exits/pe-manda/deallist','/deals/exits/pe-publicmarket/deallist','/deals/exits/vc-manda/deallist', '/deals/exits/vc-publicmarket/deallist')) AS searchApi,(SELECT COUNT(companyName) FROM pe_partner_apitracking
                 WHERE token = '".$TokenID."' and dealCount IS NOT NULL
and apiName in ('/deals/investments/pe','/deals/investments/vc','/deals/investments/social',
'/deals/investments/cleantech','/deals/investments/infrastructure','/deals/exits/pe-manda',
'/deals/exits/pe-publicmarket','/deals/exits/vc-manda','/deals/exits/vc-publicmarket')) AS apiCount,(SELECT COUNT(*) FROM pe_partner_apitracking
                 WHERE token = '".$TokenID."') AS overallCount FROM pe_api_partner";
                 
    $sqlrun = mysql_query($sql);
    while($row = mysql_fetch_array($sqlrun )) {
            $array['a_count']=$row['apiCount'];
            $array['s_count']=$row['searchApi'];
            $array['o_count']=$row['overallCount'];
    }
   echo json_encode($array); 
?>