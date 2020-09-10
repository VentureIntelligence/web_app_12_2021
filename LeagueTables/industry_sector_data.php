<?php
//TRUNCATE TABLE league_table_data
include_once 'db.php';
include 'simplexlsx.class.php';

$xlsx = new SimpleXLSX('IndustryandSector.xlsx');
echo '<h1>$xlsx->rows()</h1>';
echo '<pre>';
print_r( $xlsx->rows() );
echo '</pre>';
$dataleague = $xlsx->rows();
$temp_industry = "";
for($i=1;$i<count($dataleague); $i++){

    $industry = (trim($dataleague[$i][0]) != "") ? trim($dataleague[$i][0]) : "";
    $sector = (trim($dataleague[$i][1]) != "") ? trim($dataleague[$i][1]) : "";
    if($industry != $temp_industry){
        $select_Query = "SELECT id FROM `industry` WHERE industry='$industry'";
        $exec_sel = mysql_query($select_Query);
        $selcnt = mysql_num_rows($exec_sel);
        if($selcnt == 0){
            $insert_Query = "INSERT INTO `industry` (`id`, `industry`) 
                             VALUES (NULL, '$industry')";
            $insert_exec = mysql_query($insert_Query);    
            $industry_id =  mysql_insert_id();
        }else{
            $industry_fetch = mysql_fetch_array($exec_sel);
            $industry_id = $industry_fetch['id'];
        }    
    }
        $sector_Query = "SELECT id FROM `sector` WHERE sector='$sector'";
        $exec_sec = mysql_query($sector_Query);
        $seccnt = mysql_num_rows($exec_sec);
        if($seccnt == 0){
            $insert_sector = mysql_query("INSERT INTO `sector` (`id`, `industry_id`, `sector`) 
                             VALUES (NULL, '$industry_id', '$sector')");
        }      
    $temp_industry = $industry;
    //$select_Query = "SELECT id FROM `league_table_data` WHERE advisor_name='$advisorname' AND deal='$deal' AND amount='$amt' AND industry='$industry' AND sector='$sector' AND date='$date_deal' AND deal_type='$dealtype' AND points='$points' AND advisor_type='$advisor_type'";
    //$exec_sel = mysql_query($select_Query);
    //$selcnt = mysql_num_rows($exec_sel);
    //if($selcnt == 0){
    //$insert_Query = "INSERT INTO `league_table_data` (`id`, `advisor_name`, `deal`, `amount`, `industry`, `sector`, `date`, `deal_type`, `points`, `advisor_type`) 
    //                 VALUES (NULL, '$advisorname', '$deal', '$amt', '$industry', '$sector', '$date_deal', '$dealtype', '$points', '$advisor_type')";
    //$insert_exec = mysql_query($insert_Query);
    //}
}    
    

?>