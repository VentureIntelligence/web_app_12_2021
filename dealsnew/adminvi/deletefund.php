<?php
error_reporting(E_ALL); 
ini_set( 'display_errors','1');
require("../dbconnectvi.php");
$Db = new dbInvestments();

$Id=$_POST['DelFundId'];
if($Id > 0)
{
    foreach ($Id as $repId)
    {

        $query = "DELETE FROM fundRaisingDetails WHERE id='$repId'";
        mysql_query($query) or die(mysql_error());
    }
    header('Location: fundlist.php');
    exit();
}