<?php
$dbhost = "localhost";
$dbuser = "venture_admin16";
$dbpassword = "V@dm!n2016";
$dbname = "venture_peinvestments";
$dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db($dbname,$dbhandle) 
  or die("Database could not select");

    //company upload    
    $date = date('ymdHis');
    //$c_outfile = "csv/cprofile_all_new_company.csv";
    //$c_outfile = "csv/cprofile_all.csv";
    $c_outfile = "csv/cprofile_all.csv";
    $new_c_outfile = "csv/cprofile_all".$date.".csv";
    if(file_exists($c_outfile)){
        echo "SELECT start_id,total_cnt FROM test order by id desc";
                    $result12 = mysql_query("SELECT start_id,total_cnt FROM test order by id desc");
                    if(mysql_num_rows($result12) >0){
                        $res = mysql_fetch_array($result12);
                        $start = $res['start_id']+$res['total_cnt'];
                    }else{
                        $start = 1;
                    }
                    $end = $start+700;
        $to = "saranya@kutung.in";
        $subject = "File started cprofile";
        $txt = "Started successfully !!! started @ $start";
        $headers = "From: Test";

        mail($to,$subject,$txt,$headers);
        
        ////// Sheet Name - Company Profile ///////////////
        $file = fopen($c_outfile, "r");
        $count = 0; 
        $flag_add = $flag_update = 0;
                    $added_date = date('Y-m-d H:i:s');
        while (($cprofile = fgetcsv($file, 10000, ",")) !== FALSE) { //print_r($cprofile);
            $count++;
            if($count>$start && $count <= $end){  //print_r($cprofile);
                $flag_add++;
                echo "count--".$count;echo "<br/>";
           echo     $cin = $cprofile[46];   //CIN              
                // Duplicate check /
                if(!empty($cin)){
                    //echo "SELECT * FROM cprofile WHERE CIN='$cin'" ;
                    $cin_check = mysql_query("SELECT * FROM cprofile WHERE CIN='$cin'" );
                    $cin_check_count = mysql_num_rows($cin_check);
                    $cin_check_old = mysql_query("SELECT * FROM cprofile_old WHERE CIN='$cin'" );
                    $cin_check_count_old = mysql_num_rows($cin_check_old);
                    if($cin_check_count>0 && $cin_check_count_old == 0){
                        $cin_res = mysql_fetch_array($cin_check);
                        $cprofile_id = $cin_res['Company_Id'];
                        $IncorpYear = substr($cin,8,4);
                        $listing = substr($cin,0,1);
                        if($listing == 'L'){
                            $listing_status = '1';
                        }else if($listing == 'U'){
                            $listing_status = '2';
                        }
                        echo $sql_update = "UPDATE cprofile SET IncorpYear='$IncorpYear',ListingStatus='$listing_status',source_flag2=3123 WHERE Company_id='$cprofile_id'"; echo "<br/>";
                        $result_insert = mysql_query($sql_update) or die(mysql_error());  
                        $flag_update++;
                    }
                }
            }
        }
            $total_cnt = $flag_add;
        mysql_query("insert into test (start_id,added_date,update_cnt,total_cnt) values ('$start','$added_date','$flag_update','$total_cnt')");
                        $_SESSION['msg']['update'] = $flag_update." Companies Updated sucessfully";
        exit;
    }else{
        $to = "saranya@kutung.in";
        $subject = "File not found";
        $txt = "No files!!!";
        $headers = "From: Test";
        mail($to,$subject,$txt,$headers);
        exit;        
    }
?>