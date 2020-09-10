<?php
require("../dbconnectvi.php");
     $Db = new dbInvestments();

$Id=$_POST['DelCompId'];
    if($Id > 0)
    {
        foreach ($Id as $repId)
        {
            
            // Delete HTML FIle
            $nanoSql="select `nanobi_EC` from nanotool WHERE `id`='".$repId."'";
            $result = mysql_query($nanoSql) or die(mysql_error());
            $row=mysql_fetch_array($result);
            $rpLink = "./nanofolder/".$row['nanobi_EC'];
            unlink($rpLink);
            
            $query = "DELETE FROM nanotool WHERE id='$repId'";
            //echo  $query;
            mysql_query($query) or die(mysql_error());
        }
         header('Location: viewlist.php');
        exit();
    }