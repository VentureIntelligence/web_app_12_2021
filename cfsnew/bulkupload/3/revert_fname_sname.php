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
   /* $date = date('ymdHis');
        $to = "saranya@kutung.in";
        $subject = "File started cprofile";
        $txt = "Started successfully !!! update fname & sname";
        $headers = "From: Test";

        mail($to,$subject,$txt,$headers);*/
        
        ////// Sheet Name - Company Profile ///////////////
        $source_flag = 312;
    $added_date = date('Y-m-d H:i:s');
                    $cin_check = mysql_query("SELECT Company_Id,SCompanyName,FCompanyName FROM cprofile WHERE source_flag='3'" );
            echo "count-";     echo   $cin_check_count = mysql_num_rows($cin_check);
            $old_cnt = 0;
                    if($cin_check_count>0){
                        while($cin_res = mysql_fetch_array($cin_check)){
                            $cprofile_id = $cin_res['Company_Id'];
                            $cin_check_old = mysql_query("SELECT SCompanyName,FCompanyName FROM cprofile_old WHERE Company_id='$cprofile_id'" );
                            $cin_check_count_old = mysql_num_rows($cin_check_old);
                            if($cin_check_count_old>0){ $old_cnt++;
                                $cin_res_old = mysql_fetch_array($cin_check_old);
                            //if(!empty($GFY_count)){
                             //   $g_count = $cprofile[43];
                            //}
                                $sname = stripslashes($cin_res_old['SCompanyName']);
                                $fname = stripslashes($cin_res_old['FCompanyName']);
                                echo $sql_update = "UPDATE cprofile SET SCompanyName='".addslashes($sname)."',FCompanyName='".addslashes($fname)."' WHERE Company_id='$cprofile_id'"; echo "<br/>";
                                $result_insert = mysql_query($sql_update) or die(mysql_error()); 
                                if($sname != $cin_res['SCompanyName'] || $fname != $cin_res['FCompanyName']){
                                    mysql_query("insert into test_cin (cin,file_name,added_date,source_flag) values ('$cprofile_id','revert','$added_date','$source_flag')");
                                }else{
                                    mysql_query("insert into test_cin (cin,file_name,added_date,source_flag) values ('$cprofile_id','old','$added_date','$source_flag')");                                    
                                }
                            }
                        }
                    }
                    echo "old count- ".$old_cnt;
                    
?>