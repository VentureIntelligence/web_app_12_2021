<?php

include "header.php";
include( dirname(__FILE__)."/../../etc/conf.php");

require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

    $partner_id =  $_GET["pid"];

    $getUserid = mysql_query("SELECT * FROM `basic_api_partners` WHERE partner_id=$partner_id");
    $user_id = mysql_fetch_object($getUserid)->user_id;

    $query = "DELETE FROM basic_api_partners WHERE partner_id = $partner_id";
    $delete_rec = mysql_query($query);

    if($delete_rec == 1)
    {
        $query1 = "DELETE FROM basic_api_users WHERE `user_id`=$user_id";
        $api_users = mysql_query($query1);

        if($api_users == 1) {
            ?>
                <script> alert('Deleted Succesfully'); 
            window.location = './basic/partners-list.php';</script>
            <?php

        }else{
            ?>
            <script>  alert("Error in Delete Partners Users");
            window.location = './basic/partners-list.php';</script>
            <?php
        }
       
    }else{
        ?>
        <script> alert("Error in Delete Partners");
        window.location = './basic/partners-list.php';</script>
       <?php
    }

// $getUserid = mysql_query("SELECT * FROM `basic_api_partners` WHERE partner_id=$partner_id");

// $user_id = mysql_fetch_object($getUserid)->user_id;


//     $query = "UPDATE basic_api_partners SET delete_status ='0' WHERE partner_id=$partner_id";
//      $api_partners_delete =  mysql_query ($query);

//     if($api_partners_delete == 1)
//     {
//         $query1 = "UPDATE basic_api_users SET delete_status ='0' WHERE `user_id`=$user_id";
//         $api_users = mysql_query($query1);

//         if($api_users == 1) {
//             ?>
             <!-- <script> alert('Deleted Succesfully'); 
//             window.location = './basic/partners-list.php';</script> -->
           <?php

//         }else{
//             ?>
            <!-- <script>  alert("Error in Delete Partners Users");
//             window.location = './basic/partners-list.php';</script> -->
            <?php
//         }
//     }else{
//         ?>
        <!-- <script> alert("Error in Delete Partners");
//         window.location = './basic/partners-list.php';</script> -->
       <?php
      
//     }

   


?>