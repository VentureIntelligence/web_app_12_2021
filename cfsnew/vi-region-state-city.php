<?php include_once("../globalconfig.php"); ?>
<?php
include "header.php";
include "sessauth.php";
//https://www.ventureintelligence.com/cfsnew/vi-region-state-city.php
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
    $file_type = "vnd.ms-excel";
    $file_ending = "xls";
 //header info for browser: determines file type ('.doc' or '.xls')
 header("Content-Type: application/$file_type");
 header("Content-Disposition: attachment; filename=region-state-city.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");
 
 
 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character
 echo "REGIONS"."\t";
echo "STATE"."\t";
echo "CITY"."\t";
 echo "\n";
$cin_check = mysql_query("SELECT RegionId,Region FROM region WHERE Region !='' and Region != 'Overseas' and Region != 'Unknown'" );
$cin_check_count = mysql_num_rows($cin_check);
if($cin_check_count > 0){
    while($cin_res = mysql_fetch_array($cin_check)){
        $schema_insert .= $cin_res['Region'].$sep;
        $state_check = mysql_query("SELECT state_id,state_name FROM state WHERE Region ='".$cin_res['Region']."'" );
        $state_check_count = mysql_num_rows($state_check);
        if($state_check_count > 0){
            while($state_res = mysql_fetch_array($state_check)){
                $schema_insert .= $state_res['state_name'].$sep;  
                $city_check = mysql_query("SELECT city_id,city_name FROM city WHERE city_StateID_FK ='".$state_res['state_id']."'" );
                $city_check_count = mysql_num_rows($city_check);
                if($city_check_count > 0){
                    while($city_res = mysql_fetch_array($city_check)){
                        $schema_insert .= $city_res['city_name'].$sep;   
                        $schema_insert .= "\n\t\t";         
                    }
                } 
                $schema_insert .= "\n\t";         
            }
        }
        $schema_insert .= "\n";
    }
   // $schema_insert = str_replace($sep."$", "", $schema_insert);
   // $schema_insert .= ""."\n";
    //following fix suggested by Josue (thanks, Josue!)
    //this corrects output in excel when table fields contain \n or \r
    //these two characters are now replaced with a space
   // $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
     $schema_insert .= "\t";
     print(trim($schema_insert));
     print "\n";
     mysql_close();
}
?>