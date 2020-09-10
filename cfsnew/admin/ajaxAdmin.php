<?php
$af = $_REQUEST['af'];  // Ajax function to call
$key = $_REQUEST['key'];  // Primary Key 
$isAuth = '1' ;

if(function_exists($af))$af('1',$key); // Call the function equivalant to op

function loadSector($isAuth,$key){
include "header.php";
	$html .= '<select name="answer[Sector]" id="answer[Sector]" class="req_value" onchange="loadNaicsCode(this.value)">';
	$html.="<option value=''>Please Select a Sector</option>";
		require_once MODULES_DIR."/sectors.php";
		$sector = new sectors();
		$where = "IndustryId_FK = ".$key;
		$order = "SectorName ASC";
		$Sector =  $sector->getSectors($where,$order);		
		foreach($Sector as $id => $name) {
			$html.="<option value='".$id."'>".$name."</option>";
		}
	echo $html."</select>";		
	exit();
}//End of Function

function loadCity($isAuth,$key){
include "header.php";
	$html .= '<select name="answer[City]" id="answer[City]" class="req_value">';
	$html.="<option value=''>Please Select a City</option>";
		require_once MODULES_DIR."/city.php";
		$city = new city();
		$where = "city_StateID_FK = ".$key;
		$order = "city_name ASC";
		$City =  $city->getCity($where,$order);		
		foreach($City as $id => $name) {
			$html.="<option value='".$id."'>".$name."</option>";
		}
	echo $html."</select>";		
	exit();
}//End of Function

function loadState($isAuth,$key){
include "header.php";
	$html .= '<select name="answer[State]" id="answer[State]" class="req_value" onChange="loadCity(this.value);">';
	$html.="<option value=''>Please Select a State</option>";
		require_once MODULES_DIR."/state.php";
		$state = new state();
		$where = "state_CountryID_FK = ".$key;
		$order = "state_name ASC";
		$States =  $state->getState($where,$order);		
		foreach($States as $id => $name) {
			$html.="<option value='".$id."'>".$name."</option>";
		}
	echo $html."</select>";		
	exit();
}//End of Function


function loadStateforAdmin($isAuth,$key){
include "header.php";
include_once('path_Assign.php');
	$html .= '<select name="answer[StateIdforAdmin]" id="answer[StateIdforAdmin]" class="req_value" style="width:210px;" onChange="loadCity(this.value);">';
	$html.="<option value=''>Select a State</option>";
		require_once MODULES_DIR."/state.php";
		$state = new state();
		$where = "state_CountryID_FK = ".$key;
		$order = "state_name ASC";
		$States =  $state->getState($where,$order);		
		foreach($States as $id => $name) {
			$html.="<option value='".$id."'>".$name."</option>";
		}
	echo $html."</select>";		
	exit();
}//End of Function




function loadArea($isAuth,$key){
include "header.php";
include_once('path_Assign.php');
	$html .= '<select name="answer[AreaId]" id="answer[AreaId]" class="req_value" style="width:210px;">';
	$html.="<option value=''>Select a Area</option>";
		require_once MODULES_DIR."adminBusiness/classifieds/cf_categories.php";
		$cf_categories = new cf_categories();
		$where = "area_cityID_FK = ".$key;
		$order = "area_name ASC";
		$Areas =  $cf_categories->getArea($where);		
		foreach($Areas as $id => $name) {
			$html.="<option value='".$id."'>".$name."</option>";
		}
	echo $html."</select>";		
	exit();
}//End of Function


function EmailExistChk($isAuth,$key){
include "header.php";
	require_once MODULES_DIR."admin_user.php";
	$adminuser = new adminuser();
	
			$returnText = $adminuser->selectByEmail($key);
			print $returnText['Ident'];
			exit();
}//End of Function

function UserNameExistChk($isAuth,$key){
include "header.php";
	require_once MODULES_DIR."admin_user.php";
	$adminuser = new adminuser();
	
			$returnText = $adminuser->selectByUName($key);
			print $returnText['Ident'];
			exit();
}//End of Function


function CompanyExists($isAuth,$key){
include "header.php";
	require_once MODULES_DIR."plstandard.php";
	$plstandard = new plstandard();
	$PLSFields = array("PLStandard_Id","FY");
	$PLSwhere = " CId_FK = ".$key;
	$PLSEXitsChk = $plstandard->getFullList(1,10,$PLSFields,$PLSwhere,"PLStandard_Id desc","name");
			$returnText = $PLSEXitsChk[0]['PLStandard_Id'];
			print $returnText;
			exit();
}//End of Function

function loadNaicsCode($isAuth,$key){
	$industryID = $_REQUEST[ 'industryID' ];
include "header.php";
	require_once MODULES_DIR."/sectors.php";
	$sector = new sectors();
	$where = "IndustryId_FK = ".$industryID." AND Sector_Id = " . $key;
	$Sector =  $sector->getSectorsNaicsCode($where);
	print $Sector[0];
	exit();
}//End of Function


?>