<?php
ini_set( 'max_execution_time', 1800);
$dbhost = "localhost";
$dbuser = "venture_admin16";
$dbpassword = "V@dm!n2016";
$dbname = "venture_peinvestments";
$dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db($dbname,$dbhandle) 
  or die("Database could not select");

//if(isset($_GET["action"]) && ($_GET["action"] == "upload")){
    //company upload    
    $added_date = date('Y-m-d H:i:s');
    $date = date('ymdHis');
    $b_outfile = "csv/bsnew-1.csv";
    $new_b_outfile = "csv/bsnew-1_".$date.".csv";
    $source_flag = 4;
    if( file_exists($b_outfile) ){
        $to = "jagadeesh@kutung.in";
        $subject = "File started - plstd bsnew";
        $txt = "Started successfully !!!";
        $headers = "From: Test";

        mail($to,$subject,$txt,$headers);
        /////////////Sheet Name - BS-new //////////////
        $file = fopen($b_outfile, "r");
        $count = 0;
        $result_type = 0;
        while (($balancenew = fgetcsv($file, 10000, ",")) !== FALSE) {
            $count++;
            if($count>1){
                if($balancenew[0] !=''){
                    $cin = $balancenew[0];
                    $result = mysql_query("SELECT Company_Id,Industry FROM cprofile WHERE CIN='$cin'");
                    if(mysql_num_rows($result) >0) {
                        $res = mysql_fetch_array($result);
                        $cprofile_id = $res['Company_Id'];
                        $L_term_borrowings = $balancenew[1];
                        $FY = $balancenew[2];
                        $FY_len = strlen($FY);
                        if($FY_len == 6){
                            #$FY = substr($FY,2,-2);  Previous code
                            $MY = substr($FY,4,2);
                            $FY = substr($FY,2,-2);
                            if( $MY == '12' ) {
                                $NY = $FY + 1;
                                $FY = $NY . ' 3112' . $FY;
                            }
                        }else if($FY_len == 4){
                            $FY = substr($FY,2);                        
                        }

                        $bs_check = mysql_query("SELECT BalanceSheet_Id FROM balancesheet_new WHERE CId_FK='$cprofile_id' and FY='$FY' and ResultType='$result_type'" );
                        $bs_check_count = mysql_num_rows($bs_check);
                        if($bs_check_count > 0){
                            $res = mysql_fetch_array($bs_check);
                            $bs_id = $res['BalanceSheet_Id'];
                            mysql_query("update balancesheet_new set L_term_borrowings='$L_term_borrowings' where CId_FK='$cprofile_id' and FY='$FY' and ResultType='$result_type'");
                        }
                    }
                }
            }
        }#die;
        rename($b_outfile,$new_b_outfile);
        

        $to = "jagadeesh@kutung.in";
        $subject = "File Ended - plstd bsnew";
        $txt = "Ended successfully !!!";
        $headers = "From: Test";
        mail($to,$subject,$txt,$headers);
    }else{
        $to = "jagadeesh@kutung.in";
        $subject = "File not found";
        $txt = "No files!!!";
        $headers = "From: Test";
        mail($to,$subject,$txt,$headers);
        exit;        
    }
  //  header("Location:upload.php");
//}
?>