<?php
error_reporting(0);
//live
$dbhost = "localhost";
$dbuser = "venture_admin16";
$dbpassword = "V@dm!n2016";
$dbname = "venture_peinvestments";
$dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db($dbname,$dbhandle) 
  or die("Database could not select");
    //company upload    
    $added_date = date('Y-m-d H:i:s');
    $date = date('ymdHis');
    $c_outfile = "csv/findbulkuploadcompany.csv";
    if(file_exists($c_outfile)) {
        $file = fopen($c_outfile, "r");
        $count = 0; 
        while (($cprofile = fgetcsv($file, 10000, ",")) !== FALSE) {
            $count++;
            if($count>1){ 
               $cin = $cprofile[0]; 
                if(!empty($cin)){ echo "UPDATE  `cprofile` SET source_flag =1 WHERE CIN='$cin'";
                    $cin_check = mysql_query("UPDATE  `cprofile` SET source_flag =1 WHERE CIN='$cin'" );                    
                }
            }
        }
    }
?>