
<?php
session_save_path("/tmp");
session_start();
unset($_SESSION['re_popup_display']);
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include ('checklogin.php');
echo "success";
?>