<?php 

error_reporting(0);

include "header.php";
	

if($_REQUEST['suggest']=='suggest2') { $fillHidden = 'fillHidden2'; $fill='fill2'; }
else if($_REQUEST['suggest']=='suggest3') { $fillHidden = 'fillHidden3';  $fill='fill3'; }
else if($_REQUEST['suggest']=='suggest4') { $fillHidden = 'fillHidden4';  $fill='fill4'; }
else if($_REQUEST['suggest']=='suggest5') { $fillHidden = 'fillHidden5';  $fill='fill5'; }

	$html .= '<ul>';
		require_once MODULES_DIR."/cprofile.php";
		$cprofile = new cprofile();
//		print $key;
		$NotFound = "No Result Found for you Search !..";
		$where = "FCompanyName LIKE "."'".$_POST['queryString']."%'";
		$Companies = $cprofile->getCompaniesAutoSuggest($where,$order);
		if(array_keys($Companies)){
			foreach($Companies as $id => $name) {
				$html.="<li style='cursor:pointer;'onClick='$fill(\"".addslashes($name)."\"),$fillHidden($id)';>".$name."</li>";
			}
		}else{
			$html.="<li>".$NotFound."</li>";
		}	
	echo $html."</ul>";
?>
