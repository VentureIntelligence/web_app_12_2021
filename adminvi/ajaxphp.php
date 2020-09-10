<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
$dbtype = $_REQUEST['dbtype'];

$req = $_REQUEST['opt'];
$str = $_REQUEST['q'];
$id=$_REQUEST['inv'];




if ($dbtype=='PE') {
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
        
        
        
        if ($req=="checkdate"){
            $checkmonth=$_REQUEST['checkmonth'];
            $checkyear=$_REQUEST['checkyear'];
            $checkinvestor=$_REQUEST['checkinvestor'];
            
           // $sql = "SELECT dbType,investorId,fundDate FROM  fundRaisingDetails  WHERE dbType='PE' AND investorId='$checkinvestor' AND month(fundDate)='$checkmonth' AND year(fundDate)='$checkyear' ";
            
           $sql = "SELECT dbType,investorId,fundDate FROM  fundRaisingDetails  WHERE dbType='PE' AND investorId='$checkinvestor' AND MONTH(fundDate)='$checkmonth' AND YEAR(fundDate)='$checkyear' ";
                     
            $res = mysql_query($sql) or die(mysql_error());
           // $arr = array();
           // while($obj = mysql_fetch_object($res)) {
           //     $arr[] = $obj;
           // }
           // $json_response = json_encode($arr);
            echo mysql_num_rows($res);
        }
        
        
 }
 
 if ($dbtype=='RE') {
        if ($req=="investor"){
            $sql = "SELECT `InvestorId` as id,`Investor` as name FROM `REinvestors` WHERE `Investor` LIKE '".$str."%'";
            $res = mysql_query($sql) or die(mysql_error());
            $arr = array();
            while($obj = mysql_fetch_object($res)) {
                $arr[] = $obj;
            }
            $json_response = json_encode($arr);
            echo $json_response;
        }
       
        
         if ($req=="checkdate"){
            $checkmonth=$_REQUEST['checkmonth'];
            $checkyear=$_REQUEST['checkyear'];
            $checkinvestor=$_REQUEST['checkinvestor'];
          
            $sql = "SELECT dbType,investorId,fundDate FROM  fundRaisingDetails  WHERE dbType='RE' AND investorId='$checkinvestor' AND MONTH(fundDate)='$checkmonth' AND YEAR(fundDate)='$checkyear' ";
                                
            $res = mysql_query($sql) or die(mysql_error());
          
            echo mysql_num_rows($res);
        }
        
}





        
        
        if ($req=="allfundname"){

            $sql = "SELECT `fundId` as id,`fundName` as name FROM `fundNames` WHERE `fundName` LIKE '".$str."%'  ";
            $res = mysql_query($sql) or die(mysql_error());
            $arr = array();
            while($obj = mysql_fetch_object($res)) {
                $arr[] = $obj;
            }
            $json_response = json_encode($arr);
            echo $json_response;
        }
        if ($req=="fundname"){

            $sql = "SELECT `fundId` as id,`fundName` as name FROM `fundNames` WHERE investorId='".$id."%'  AND dbtype='".$dbtype."' ";
            $res = mysql_query($sql) or die(mysql_error());
            $arr = array();
            while($obj = mysql_fetch_object($res)) {
                $arr[] = $obj;
            }
            $json_response = json_encode($arr);
            echo $json_response;
        }



