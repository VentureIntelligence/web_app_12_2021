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
    $c_outfile = "csv/cprofile_cin_industry.csv";
    if(file_exists($c_outfile)) {
        $file = fopen($c_outfile, "r");
        $count = 0; 
        while (($cprofile = fgetcsv($file, 10000, ",")) !== FALSE) {
            $count++;
           // if($count>1){
            // if($count>1 && $count < 2001){
            // if($count>2000 && $count < 3501){
             //if($count>3500 && $count < 5001){
            // if($count>5000 && $count < 6501){
             if($count>6500){
             echo "IndustryId_FK - "; echo  $IndustryId_FK = $cprofile[0]; 
             echo "sector - "; echo  $sector = $cprofile[1]; 
             echo "CIN - "; echo  $cin = $cprofile[2]; 
                if(!empty($cin)){
                    $cin_check = mysql_query("SELECT Company_Id,Industry,Sector FROM cprofile WHERE CIN='$cin'" );
                    $cin_check_count = mysql_num_rows($cin_check);
                    if($cin_check_count > 0){
                        $cin_res = mysql_fetch_array($cin_check);
                        $cprofile_id = $cin_res['Company_Id'];
                        echo "A Industry - "; echo  $cin_res['Industry'];
                        echo "A Sector - "; echo  $cin_res['Sector'];
                        mysql_query("update cprofile set Industry='$IndustryId_FK',Sector='$sector' where Company_Id='$cprofile_id'");
                        mysql_query("update plstandard set IndustryId_FK='$IndustryId_FK' where CId_FK='$cprofile_id'");
                        mysql_query("update balancesheet set IndustryId_FK='$IndustryId_FK' where CId_FK='$cprofile_id'");
                        mysql_query("update balancesheet_new set IndustryId_FK='$IndustryId_FK' where CId_FK='$cprofile_id'");
                        mysql_query("update growthpercentage set IndustryId_FK='$IndustryId_FK' where CId_FK='$cprofile_id'");
                        mysql_query("update cagr set IndustryId_FK='$IndustryId_FK' where CId_FK='$cprofile_id'");
                        echo "<br/>";
                    }
                }
            }
        }
    }
?>