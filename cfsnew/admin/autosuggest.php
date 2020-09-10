<?php 

error_reporting(0);

include "header.php";
	
	$html .= '<ul>';
		require_once MODULES_DIR."/cprofile.php";
		$cprofile = new cprofile();
//		print $key;
		$NotFound = "No Result Found for you Search !..";
		$where = "FCompanyName LIKE "."'".$_POST['queryString']."%'";
		$Companies = $cprofile->getCompaniesAutoSuggest($where,$order);
		if(array_keys($Companies)){
			foreach($Companies as $id => $name) {
				$html.="<li style='cursor:pointer;'onClick='fill(\"".addslashes($name)."\"),fillHidden($id)';>".$name."</li>";
			}
		}else{
			$html.="<li>".$NotFound."</li>";
		}	
	echo $html."</ul>";
?>
