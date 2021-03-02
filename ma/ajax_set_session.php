
<?php
session_save_path("/tmp");
session_start();
unset($_SESSION['ma_popup_display']);
require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    include ('machecklogin.php');
echo "success";
?>