<?php
session_save_path("/tmp");
session_start();     
       
$dbhost2 = "localhost";
$dbuser2 = "venture_admin";
$dbpassword2 = "Admin2014";
$db2 = "venture_peinvestments";

$connection2 = mysql_connect($dbhost2,$dbuser2,$dbpassword2) or die (mysql_error());
mysql_select_db($db2,$connection2);
 
date_default_timezone_set ('Asia/Kolkata');
$date =  date('Y-m-d'); 


        if(isset($_GET['cfs'])){
             $email = $_SESSION['username'];
        
       }else{
         $email = $_SESSION['UserEmail']; 
       }
      
        $status = $_POST['status'];
       


        $check_userid = "select * from survey_stats where  email='" . $email . "'      ";

        $check_userid_exe = mysql_query($check_userid);

        if (mysql_num_rows($check_userid_exe) > 0) {

            $update_query = "update survey_stats SET status='" . $status . "', date='" . $date . "'  where  email='" . $email . "'   ";
            $update_query_exe = mysql_query($update_query);
            if ($update_query_exe) {
                echo "1";
            }
        } else {

             $insert_query = "insert into survey_stats(id,email,status,date) values('','" . $email . "','" . $status . "','" . $date . "')";

            $exe = mysql_query($insert_query);

            if ($exe) {
                echo "1";
            }
        }
        ?>


  
