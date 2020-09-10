<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add City' );
require_once MODULES_DIR."state.php";
$state = new state();
require_once MODULES_DIR."countries.php";
$countries = new countries();
require_once MODULES_DIR."city.php";
$city = new city();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

if(!$_SESSION['business']['Auth']){
	header('Location: login.php');
	die();
}

if(isset($_POST["AddCity"])){
	if($_POST['answer']["State"]!= ""){
		$Insert_State['city_CountryID_FK']       = $_POST['answer']["AddressCountry"];
		$Insert_State['city_StateID_FK']       = $_POST['answer']["State"];
		$Insert_State['city_name']        = $_POST['answer']["City"];
		
		$city->update($Insert_State);
		$template->assign('SuccessMsg',"State Added Successfully");
		header("Location:addCity.php");
		//pr($_POST);
	}	
}

$template->assign("countries" , $countries->getCountries($where1,$order1));
$template->assign("State" , $state->getState($where2,$order2));
$template->assign('pageTitle',"Add City");
$template->assign('pageDescription',"Add City");
$template->assign('pageKeyWords',"Add City");
$template->display('admin/addCity.tpl');

?>