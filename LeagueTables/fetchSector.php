<?php
//TRUNCATE TABLE league_table_data
include_once 'db.php';

$industryid = $_POST['id'];
if($industryid){
 $selectSector = mysql_query("select id,sector from sector where industry_id = '$industryid'");
 $options = "";
 $options = "<option value=''>-Select Sector-</option>";
 while($row = mysql_fetch_array($selectSector)){
     $options .= "<option value='".$row['id']."'>".$row['sector']."</option>";
 }
 echo $options;
}else{
 echo "";
}
?>