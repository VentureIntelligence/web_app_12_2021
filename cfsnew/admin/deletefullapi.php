<?php

include "header.php";
include( dirname(__FILE__)."/../../etc/conf.php");

require_once MODULES_DIR."xbrl.php";

if(!$_SESSION['business']['Auth']){
	header('Location: ../login.php');
	die();
}

$fullapi_user_id =  $_GET["pid"];

 $query = "DELETE FROM fullapi_user WHERE fullapi_user_id = $fullapi_user_id";

 //echo $query;exit();

     $api_partners_delete =  mysql_query ($query);

    if($api_partners_delete == 1)
    {
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