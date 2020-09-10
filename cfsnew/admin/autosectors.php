<?php 

error_reporting(0);

//echo $_POST['queryString'];
//exit;
include "header.php";
	
	$html .= '';
		require_once MODULES_DIR."/sectors.php";
		$sectors = new sectors();
//		print $key;
		$NotFound = "No Result Found for you Search !..";
		$where = "IndustryId_FK = ".$_POST['queryString'];
              
                $order='';
		$Companies = $sectors->getSectors($where,$order);
               // print_r($Companies);
               //   exit;
		if(array_keys($Companies)){
			foreach($Companies as $Sector_Id => $SectorName) {
				$html.="<option value=".$Sector_Id.">".$SectorName."</li>";
			}
		}else{
			$html.="<option>".$NotFound."</option>";
		}	
	echo $html;
?>
