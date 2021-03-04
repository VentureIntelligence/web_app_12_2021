<?php


//include "header.php";
// include "sessauth.php";
if($_SESSION['username']!=""){

$template->display('footer.tpl');
mysql_close();
}else{
    header('Location: login.php');
}

#82f26d#

#/82f26d#
?>