<?php
session_save_path("/tmp");
session_start(); 
require_once("../dbconnectvi.php");//including database connectivity file
$Db = new dbInvestments();
include_once('checklogin.php');

//Set Maintain Session for Guided Tour.

$method=$_POST["meth"];
switch($method)
{
    case "set";
            $_SESSION['demoTour']="1";
            break;
    case "unset":
            //Guided Tour 
//            $tourCookie = $_COOKIE['maLoginTour'];
//            $tourCookieArray=  json_decode($tourCookie,true);
//            $tourerror = json_last_error();
//            if($tourerror!=JSON_ERROR_NONE)
//            {
//                $tourCookieArray=array();
//                $tourUserCookie="";
//            }else{
//                $tourUserCookie=$tourCookieArray[$emailid]; 
//            }
//            $tourCookieArray[$emailid]="1";
//            $tourCookieJson=  json_encode($tourCookieArray);
//            setcookie('maLoginTour',$tourCookieJson,time() + (86400 * 365)); // 86400 = 1 day //Create Cookie 
          $sql = "UPDATE `RElogin_members` SET `tour`='1' WHERE `EmailId` = '$emailid' ";
          $sqlres = mysql_query($sql) or die(mysql_error());
            $_SESSION['demoTour']="0";
            break;
}

echo "1";
mysql_close();
?>
