<?php

include_once '../LeagueTables/db.php';
include '../LeagueTables/simplexlsx.class.php';
$uploadOk = 1;
$username=$_REQUEST['username'];

if(isset($_FILES['leaguefilepath']))
{
    if($_FILES['leaguefilepath']['tmp_name'])
    {
        if(!$_FILES['leaguefilepath']['error'])
        {
            $target_dir = "importfiles/";
            $inputFile = $_FILES['leaguefilepath']['tmp_name'];
            //$inputFilename = $_FILES['leaguefilepath']['name'];
            $file = $_FILES['leaguefilepath']['name'];
            $array = explode('.', $file);
            $fileName=$array[0];
            $fileExt=$array[1];
            $inputFilename=$fileName."_".date('d-m-Y_hi').".".$fileExt;
            $target_file = $target_dir . basename($inputFilename);
            $extension = strtoupper(pathinfo($inputFilename, PATHINFO_EXTENSION));
            if (file_exists($target_file)) {
                if($_GET['override']){
                    $uploadOk = 1;
                } else {
                    echo "File exists";
                    $uploadOk = 0;
                }
               
            }
            
            if($extension != 'XLSX'){
                echo "File Format";
                $uploadOk = 0;
            }   
            if($uploadOk != 0){
                if (move_uploaded_file($inputFile, $target_file)) {
                    //TRUNCATE TABLE league_table_data
                    mysql_query("TRUNCATE table league_table_data");
                    $xlsx = new SimpleXLSX($target_file);
                    $dataleague = $xlsx->rows();
                    for($i=1;$i<count($dataleague); $i++){
                        if(trim($dataleague[$i][6]) != ""){    
                            $ts = ($dataleague[$i][6] - 25569)*86400;
                            $date_deal = gmdate('Y-m-d', $ts);
                        }else{
                            $date_deal = "0000-00-00";    
                        }    
                        $advisorname = (trim($dataleague[$i][1]) != "") ? trim($dataleague[$i][1]) : "";
                        $deal = (trim($dataleague[$i][2]) != "") ? trim($dataleague[$i][2]) : "";
                        $amt = (trim($dataleague[$i][3]) != "") ? trim($dataleague[$i][3]) : "";
                        $industry = (trim($dataleague[$i][4]) != "") ? trim($dataleague[$i][4]) : "";
                        $sector = (trim($dataleague[$i][5]) != "") ? trim($dataleague[$i][5]) : "";
                        $dealtype = (trim($dataleague[$i][7]) != "") ? trim($dataleague[$i][7]) : "";
                        $points = (trim($dataleague[$i][8]) != "") ? trim($dataleague[$i][8]) : "";
                        $advisor_type = (trim($dataleague[$i][9]) != "") ? trim($dataleague[$i][9]) : "";
                        $notable = (trim($dataleague[$i][10]) != "") ? trim($dataleague[$i][10]) : "";
                        
                        $select_Query = "SELECT id FROM `league_table_data` WHERE advisor_name='$advisorname' AND deal='$deal' AND amount='$amt' AND industry='$industry' AND sector='$sector' AND date='$date_deal' AND deal_type='$dealtype' AND points='$points' AND advisor_type='$advisor_type'";
                        $exec_sel = mysql_query($select_Query);
                        $selcnt = mysql_num_rows($exec_sel);
                        if($selcnt == 0){
                            $rowcount++;
                           // if((count($dataleague[$i]) == '10') || (count($dataleague[$i]) == '11')){
                            $insert_Query = "INSERT INTO `league_table_data` (`id`, `advisor_name`, `deal`, `amount`, `industry`, `sector`, `date`, `deal_type`, `points`, `advisor_type`,`notable`,`created_date`) 
                            VALUES (NULL, '$advisorname', '$deal', '$amt', '$industry', '$sector', '$date_deal', '$dealtype', '$points', '$advisor_type','$notable',now())";
                            $insert_exec = mysql_query($insert_Query);
                           // }
                        }
                    }
                    $select_Query1 = "SELECT id FROM `league_table_data` ";
                    $exec_sel1 = mysql_query($select_Query1);
                    $tablecount = mysql_num_rows($exec_sel1);
                    $yearVal = mysql_query("SELECT YEAR(date) as year FROM league_table_data GROUP BY YEAR(date)");
                    while ($y = mysql_fetch_array($yearVal)) {

                        if( $y['year'] > 0 && $y['year'] != 1899 ){
                            $Lyears[] = $y['year'];
                        }
                    }
                    $Lyears = array_unique($Lyears);
                    $latestyear=end($Lyears);
                    $date= date("Y-m-d h:i:s");
                   // rsort($Lyears);
                    // echo "filename:".$inputFilename;
                    // echo "excelcount:".$rowcount;
                    // echo "dbcount:".$tablecount;
                    // echo "year:".$latestyear;
                    // echo "username:".$username;	
                    if($inputFilename !="" || $rowcount !="" || $tablecount !="" ||  $latestyear !="" ||  $username !="" ){
                       
                           $insert_Query = "INSERT INTO `leaguetable_log` (`username`, `logfile`, `excel_total_rows`, `table_total_rows`, `latestyear`, `created_date`) 
                                            VALUES ( '$username', '$inputFilename', '$rowcount', '$tablecount', '$latestyear', now())";
                            
                            $insert_exec = mysql_query($insert_Query);
                      
                    }
                    $to    = 'arun@ventureintelligence.in';
                    $from 	= 'info@ventureintelligence.in';
                    $subject 	= "League table main page data upload"; // Subject of the email
                    //Message
                    $message 	= 'Please find the details below:';
        
                    $message 	.= "<p></p>";
		            $message .="<table style='border-spacing: 0px;'><tr><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Admin User name</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Page</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Host</th><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Updated time</th></tr>";
                    $message .="<tr><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$username."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>LeagueTable Page</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$_SERVER[HTTP_HOST]."</td><td style='padding: 3px 6px;border: 1px solid #cccfcf;'>".$date."</td></tr>";
                    $message .= "</table>";
                   // $message 	.=".$username. -- uploaded the file in leagues main page ";
        
                    $headers  = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: VI Admin <info@ventureintelligence.in>' . "\r\n";
                    $headers .= "Reply-To: no-reply@ventureintelligence.com\r\n";
                    $headers .= 'Cc: heyram.vi@gmail.com, vijayakumar.k@praniontech.com' . "\r\n";
       
                    if (@mail($to, $subject, $message, $headers)){
                    }else{
                    }
                    echo "Success";
                }   
            } 
        }
    }
}

?>