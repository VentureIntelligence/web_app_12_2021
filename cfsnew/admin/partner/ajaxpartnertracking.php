<?php 

        include "header.php";
        include( dirname(__FILE__)."/../../etc/conf.php");
       // if($_POST){

                $user = $_POST['username'];
                $drp = $_POST['drp'];
                $dates = explode("-", $drp);
                $from_date = date('Y-m-d', strtotime($dates[0]));
                $to_date = date('Y-m-d', strtotime($dates[1]));
                $sqlrun=[];
                $array=array();
                $sql = "Select distinct a.user,
                (select count(*) from partner_apitracking where user='".$user."' and apiName='/profileData') as profileData,
                (select count(*) from partner_apitracking where user='".$user."' and apiName='/financialData')  as financialData,
                (select count(*) from partner_apitracking where user='".$user."')   as totalcount,
                (select count(DISTINCT(companyName)) from partner_apitracking  where user='".$user."' and (companyName !='')) as TotalRequest,
                (select count(DISTINCT(companyName)) from partner_apitracking  where user='".$user."' and (companyName !='')) as betweendateCount
                from partner_apitracking as a where a.user='".$user."' and date(createdAt) between '$from_date' and '$to_date'";

                $sqlrun = mysql_query($sql);
                while($row = mysql_fetch_array($sqlrun )) {
                        $array['totalcount']=$row['totalcount'];
                        $array['profileData']=$row['profileData'];
                        $array['financialData']=$row['financialData'];
                        $array['totalusers']=$row['TotalRequest'];
                        $array['betweendateCount']=$row['betweendateCount'];
                        echo json_encode($array);
                }
       // }     
       // echo $_GET['name'];
?>