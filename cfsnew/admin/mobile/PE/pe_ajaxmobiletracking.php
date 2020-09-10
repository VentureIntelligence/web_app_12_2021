<?php 

        include "header.php";
        include( dirname(__FILE__)."/../../../etc/conf.php");
       // if($_POST){
       
                $user = $_POST['username'];
                $api = $_POST['apiname'];
                $drp = $_POST['drp'];
                $dates = explode("-", $drp);
                $from_date = date('Y-m-d', strtotime($dates[0]));
                $to_date = date('Y-m-d', strtotime($dates[1]));
                $sqlrun=[];
                $array=array();
               
                // $sql = "Select distinct a.user,
                // (select count(*) from pe_apitracking where user='".$user."' and apiName='/deals/search') as search,
                // (select count(*) from pe_apitracking where user='".$user."' and apiName='/deals/investments/company-list')  as companylist,
                // (select count(*) from pe_apitracking where user='".$user."')   as totalcount
                // from pe_apitracking as a where a.user='".$user."' and date(createdAt) between '$from_date' and '$to_date'";
                $sql = "Select distinct apiName as apinamevalue,apiURL as apiurl,
                (select count(*) from pe_apitracking where user='".$user."' and apiName='".$api."' and date(createdAt) between '".$from_date."' and '".$to_date."') as search,
                (select count(*) from pe_apitracking where user='".$user."')   as totalcount
                from pe_apitracking where user='".$user."' and apiName='".$api."' and date(createdAt) between '$from_date' and '$to_date'";
              // echo $sql;
                $sqlrun = mysql_query($sql);


                while($row = mysql_fetch_array($sqlrun )) {
                        $array['apinamevalue']=$row['apinamevalue'];
                        $array['apiurl']=$row['apiurl'];
                        $array['totalcount']=$row['totalcount'];
                        $array['search']=$row['search'];
                       
                       
                        echo json_encode($array);
                }
       // }     
       // echo $_GET['name'];
?>
