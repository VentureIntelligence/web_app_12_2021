<?php
//TRUNCATE TABLE league_table_data
include_once 'db.php';
include 'simplexlsx.class.php';
mysql_query("TRUNCATE table league_table_data");
$xlsx = new SimpleXLSX('LeagueTable.xlsx');
echo '<h1>$xlsx->rows()</h1>';
echo '<pre>';
print_r( $xlsx->rows() );
echo '</pre>';
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
    if((count($dataleague[$i]) == '10') || (count($dataleague[$i]) == '11')){
    $insert_Query = "INSERT INTO `league_table_data` (`id`, `advisor_name`, `deal`, `amount`, `industry`, `sector`, `date`, `deal_type`, `points`, `advisor_type`,`notable`) 
                     VALUES (NULL, '$advisorname', '$deal', '$amt', '$industry', '$sector', '$date_deal', '$dealtype', '$points', '$advisor_type','$notable ')";
    $insert_exec = mysql_query($insert_Query);
    }
    }
}    
    

?>