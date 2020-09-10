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
    $c_outfile = "PCompanylist.csv";
    $file_type = "vnd.ms-excel";
    $file_ending = "xls";
 //header info for browser: determines file type ('.doc' or '.xls')
 header("Content-Type: application/$file_type");
 header("Content-Disposition: attachment; filename=PEcompanylist.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");
 
 
 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character
 echo "pecompid"."\t";
	echo "Company Name"."\t";
    if(file_exists($c_outfile)) {
        $file = fopen($c_outfile, "r");
        $count = 0; 
        while (($cprofile = fgetcsv($file, 10000, ",")) !== FALSE) {
         $schema_insert = "";
            $count++;
            if($count>1){
             $id= $cprofile[0];
                    $cin_check = mysql_query("SELECT PECompanyId,companyname FROM pecompanies WHERE PECompanyId='$id'" );
                    $cin_check_count = mysql_num_rows($cin_check);
                    if($cin_check_count > 0){
                        $cin_res = mysql_fetch_array($cin_check);
                        $schema_insert .= $cin_res['PECompanyId'].$sep;
                        $schema_insert .= $cin_res['companyname'].$sep;
                    }
            }
	     $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert .= ""."\n";
 		//following fix suggested by Josue (thanks, Josue!)
 		//this corrects output in excel when table fields contain \n or \r
 		//these two characters are now replaced with a space
 		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
         $schema_insert .= "\t";
         print(trim($schema_insert));
         print "\n";
        }
    }
?>