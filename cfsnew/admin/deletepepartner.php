<?php

include "header.php";
include( dirname(__FILE__)."/../../etc/conf.php");

require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

$partner_id =  $_GET["pid"];

 $getUserid = mysql_query("SELECT * FROM `pe_api_partner` WHERE partner_id=$partner_id");
 $user_id = mysql_fetch_object($getUserid)->user_id;

 $query = "DELETE FROM pe_api_partner WHERE partner_id = $partner_id";
 $delete_rec = mysql_query($query);

 if($delete_rec == 1)
 {
     $query1 = "DELETE FROM pe_external_api_users WHERE `user_id`=$user_id";
     $api_users = mysql_query($query1);
    ?>
    <script> alert('Deleted Succesfully'); 
    window.location = './PE/partners-list.php';</script>
    <?php

    }else{
        ?>
        <script> alert("Error in Delete Partners");
        window.location = './PE/partners-list.php';</script>
        <?php
      
    }

   


?>