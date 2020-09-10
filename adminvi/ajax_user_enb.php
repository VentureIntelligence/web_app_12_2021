<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
 //session_save_path("/tmp");
session_start();
//print_r($_POST);
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    if( isset( $_POST ) ) {
        $user_id = $_POST[ 'userid' ];
        $permit = $_POST[ 'permit' ];
        $update = "UPDATE adminvi_user SET is_enabled = " . $permit . " WHERE id = " . $user_id;
        mysql_query( $update ) or die( mysql_error() );
        echo 1;
    } else {
        echo 2;
    }
?>
<?php

} // if resgistered loop ends
else
    header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>