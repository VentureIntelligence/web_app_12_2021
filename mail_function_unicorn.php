

<?php

require("dbconnectvi.php");
     $Db = new dbInvestments();

session_save_path("/tmp");
session_start();

// echo '<pre>'; print_r($_POST); echo '</pre>';exit;


$emailid = $_POST['emailid'];
$name = $_POST['name'];
$designation = $_POST['designation'];
$companyname = $_POST['companyname'];
$phone = $_POST['phone'];

 $created_at =  date('Y-m-d H:i:s');


    if($emailid != "" && $name != ""  && $designation != ""  && $companyname != "" && $phone != "" )
    {
        $insunicornreport="insert into india_unicorn_report(email,name,companyname,designation,mobileno,created_at,created_by)
        values('$emailid','$name','$companyname','$designation','$phone','$created_at','')";

        $rsIndUniRep = mysql_query($insunicornreport);

        if($rsIndUniRep){
            echo '1';
        }
        else{
            echo '0';
        }
    }else{
        echo 0 ;
    }



    // echo $insunicornreport; exit;



?>