<?php 
if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
//ob_end_clean();
//include("header.php");

//session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");

//ob_start();


$af = $_REQUEST['af'];  // Ajax function to call
$key = $_REQUEST['key'];  // Primary Key 

if(function_exists($af))$af('1',$key); // Call the function equivalant to op
//if(function_exists($af))$af($isAuth,$key); // Call the function equivalant to op



function loadAutoSuggest($isAuth,$key){
include "header.php";
	$html .= '<ul>';
		require_once MODULES_DIR."/cprofile.php";
		$cprofile = new cprofile();
//		print $key;
		$where = "FCompanyName LIKE "."'".$key."%'";
		$Companies = $cprofile->getCompaniesAutoSuggest($where);
		foreach($Companies as $id => $name) {
			$html.="<li style='cursor:pointer'><option   onclick='insertautoVal($id);' value='".$id."'>".$name."</option></li>";
		}
	echo $html."</ul>";		
	exit();
}//End of Function

function insertautoVal($isAuth,$key){
include "header.php";
		require_once MODULES_DIR."/cprofile.php";
		$cprofile = new cprofile();
		$Companies = $cprofile->select($key);
	echo $cprofile->elements['SCompanyName'];		
	exit();
}//End of Function




?>