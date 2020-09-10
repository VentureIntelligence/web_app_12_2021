<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
$req = $_REQUEST['opt'];
$str = $_REQUEST['q'];
$id=$_REQUEST['inv'];

if ($req=="investor"){
    $sql = "SELECT `InvestorId` as id,`Investor` as name FROM `peinvestors` WHERE `Investor` LIKE '".$str."%'";
    $res = mysql_query($sql) or die(mysql_error());
    $arr = array();
    while($obj = mysql_fetch_object($res)) {
        $arr[] = $obj;
    }
    $json_response = json_encode($arr);
    echo $json_response;
}
if ($req=="allfundname"){
    
    $sql = "SELECT `fundId` as id,`fundName` as name FROM `fundNames` WHERE `fundName` LIKE '".$str."%'";
    $res = mysql_query($sql) or die(mysql_error());
    $arr = array();
    while($obj = mysql_fetch_object($res)) {
        $arr[] = $obj;
    }
    $json_response = json_encode($arr);
    echo $json_response;
}
if ($req=="fundname"){
    
    $sql = "SELECT `fundId` as id,`fundName` as name FROM `fundNames` WHERE investorId='".$id."%'";
    $res = mysql_query($sql) or die(mysql_error());
    $arr = array();
    while($obj = mysql_fetch_object($res)) {
        $arr[] = $obj;
    }
    $json_response = json_encode($arr);
    echo $json_response;
}
