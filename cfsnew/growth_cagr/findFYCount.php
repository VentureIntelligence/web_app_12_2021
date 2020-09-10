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
    $cprofile_check = mysql_query("SELECT Company_Id FROM cprofile WHERE source_flag='1'" );
    $cin_check_count = mysql_num_rows($cprofile_check);
    if($cin_check_count > 0){
        while($cprofileDetails = mysql_fetch_array($cprofile_check)){            
            $pl_details = mysql_query("SELECT PLStandard_Id FROM plstandard WHERE CId_FK='".$cprofileDetails['Company_Id']."' group by FY" );
            $pl_check_count = mysql_num_rows($pl_details);
            $FYCount = $pl_check_count;
            if($pl_check_count >0){
                $GFYCount = $pl_check_count - 1;
            }
            echo "UPDATE  `cprofile` SET FYCount='$FYCount',GFYCount='$GFYCount'  WHERE Company_Id='".$cprofileDetails['Company_Id']."' and source_flag =1";
            mysql_query("UPDATE  `cprofile` SET FYCount='$FYCount',GFYCount='$GFYCount'  WHERE Company_Id='".$cprofileDetails['Company_Id']."' and source_flag =1" );    
        }
    }
?>