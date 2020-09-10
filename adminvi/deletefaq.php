<?php
require("../dbconnectvi.php");
     $Db = new dbInvestments();

$repId=$_POST['DelCompId'];

 $query = "update faq set status='1' WHERE id='$repId'";
            //echo  $query;
            mysql_query($query) or die(mysql_error());
			header('Location: viewfaqlist.php');
			
    /* if($Id > 0)
    {
        foreach ($Id as $repId)
        {
            
            $query = "update faq set status='1' WHERE id='$repId'";
            mysql_query($query) or die(mysql_error());
        }
         header('Location: viewfaqlist.php');
        exit();
    } */