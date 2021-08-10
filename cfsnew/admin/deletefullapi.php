<?php

include "header.php";
include( dirname(__FILE__)."/../../etc/conf.php");

require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

$fullapi_user_id =  $_GET["pid"];


 $getUserid = mysql_query("SELECT * FROM `fullapi_user` WHERE fullapi_user_id=$fullapi_user_id");
 $user_id = mysql_fetch_object($getUserid)->user_id;

 $query = "DELETE FROM fullapi_user WHERE fullapi_user_id = $fullapi_user_id";
 $delete_rec = mysql_query($query);

 if($delete_rec == 1)
 {
     $query1 = "DELETE FROM external_fullapi_users WHERE `fullapi_user_id`=$user_id";
     $api_users = mysql_query($query1);
    ?>
    <script> alert('Deleted Succesfully'); 
        window.location = './fullapi/users-fullapilist.php';</script>
    <?php

    }else{
        ?>
        <script> alert("Error in Delete Partners");
        window.location = './fullapi/users-fullapilist.php';</script>
        <?php
      
    }

   


?>