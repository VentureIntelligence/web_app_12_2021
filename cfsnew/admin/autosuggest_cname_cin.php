<?php 

error_reporting(0);

//echo $_POST['queryString'];

include "header.php";
	
	$html .= '<ul>';
		require_once MODULES_DIR."/cprofile.php";
		$cprofile = new cprofile();
//		print $key;
		$NotFound = "No Result Found for you Search !..";
                
		if($_POST['searchby']=='FCompanyName'){
                $where = "FCompanyName LIKE "."'".$_POST['queryString']."%'";
                $slt='FCompanyName';
                }
                else if($_POST['searchby']=='CIN'){
                //$where = "CIN LIKE "."'".$_POST['queryString']."%'";
                //$slt='CIN';
                	$where = "CIN LIKE "."'".$_POST['queryString']."%' OR Old_CIN LIKE '%".$_POST['queryString']."%'";
                	$slt='CIN, Old_CIN';
                }
                
                $Companies = $cprofile->getCompaniesAutoSuggest_name_cin($slt,$where,$order);
		if(array_keys($Companies)){
			foreach($Companies as $id => $name) {
				if($slt == 'CIN, Old_CIN'){
					$name = explode(",",$name);
					foreach($name as $names){
						$html.="<li style='cursor:pointer;'onClick='fill(\"".addslashes($names)."\"),fillHidden($id)';>".$names."</li>";
					}
				} else {
					$html.="<li style='cursor:pointer;'onClick='fill(\"".addslashes($name)."\"),fillHidden($id)';>".$name."</li>";
				}
				//$html.="<li style='cursor:pointer;'onClick='fill(\"".addslashes($name)."\"),fillHidden($id)';>".$name."</li>";
			}
		}else{
			$html.="<li>".$NotFound."</li>";
		}	
	echo $html."</ul>";
?>
