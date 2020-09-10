<?php 

        include "header.php";
        include( dirname(__FILE__)."/../../etc/conf.php");
       // if($_POST){
                $user = $_POST['name'];
                $sqlrun=[];
                $array=array();
                $sql = "Select distinct a.user, 
                (select count(*) from apitracking where user='".$user."' and apiName='/profileData') as profileData,
                (select count(*) from apitracking where user='".$user."' and apiName='/financialData') as financialData,
                (select count(*) from apitracking where user='".$user."') as totalcount,
                (select count(DISTINCT(companyName)) from apitracking  where user='".$user."' and (companyName !='')) as TotalRequest 
                from apitracking as a where a.user='".$user."'";
               
                $sqlrun = mysql_query($sql);
                
                while($row = mysql_fetch_array($sqlrun )) {
                        $array['totalcount']=$row['totalcount'];
                        $array['profileData']=$row['profileData'];
                        $array['financialData']=$row['financialData'];
                        $array['totalusers']=$row['TotalRequest'];
                        echo json_encode($array);
                }
                
                
       // }     
       // echo $_GET['name'];
?>
