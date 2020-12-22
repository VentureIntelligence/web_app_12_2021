<?php 
	include "header.php";
	require_once MODULES_DIR."/sectors.php";
	$sectors = new sectors();
        if($_REQUEST['queryString1']!='null')
        {
            $where .= "IndustryId_FK IN( ".$_REQUEST['queryString1'].")";
            echo '<select id="answer[Sector]" name="answer[Sector][]" class="multi" forError="Sector" style="width: 210px;" multiple>';
			
        }
        else{
        	echo '<select id="answer[Sector]" name="answer[Sector][]" class="multi" forError="Sector" style="width: 210px;" multiple disabled>';
        	
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