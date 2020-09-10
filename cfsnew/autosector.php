<?php 
	include "header.php";
	require_once MODULES_DIR."/sectors.php";
	$sectors = new sectors();
        if($_GET['queryString1']!='')
        {
            $where .= "IndustryId_FK = ".$_GET['queryString1'];
            echo '<select id="answer[Sector]" name="answer[Sector]"  class="" forError="Sector">';
			echo '<option value="">Please Select a Sector</option>';
        }
        else{
        	echo '<select id="answer[Sector]" name="answer[Sector]"  class="" forError="Sector" disabled>';
        	echo '<option value="">Please Select a Sector</option>';
        }
	$order .= "SectorName asc";
	$Companies = $sectors->getFullList(1,100,$fields,$where,$order,"name");
	//pr($Companies);
	
	for($i=0;$i<count($Companies);$i++){
?>
<option value="<?php echo $Companies[$i]['Sector_Id']; ?>"><?php echo $Companies[$i]['SectorName']; ?></option>
<?php
}
	echo '</select>';
        
mysql_close(); ?>