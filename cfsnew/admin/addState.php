<?php
include "header.php";
userPermissionCheck( $_SESSION[ 'business' ][ 'UsrType' ], 'Add State' );
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

if(isset($_POST["AddCountry"])){
	if($_POST['answer']["State"]!= ""){
		$Insert_State['state_CountryID_FK']       = $_POST['answer']["AddressCountry"];
		$Insert_State['state_name']       = $_POST['answer']["State"];
		$Insert_State['Region']        = $_POST['answer']["Region"];
		
		$state->update($Insert_State);
		$template->assign('SuccessMsg',"State Added Successfully");
		header("Location:addState.php");
		//pr($_POST);
	}	
}

$template->assign("countries" , $countries->getCountries($where1,$order1));
$template->assign('pageTitle',"Add State");
$template->assign('pageDescription',"Add State");
$template->assign('pageKeyWords',"Add State");
$template->display('admin/addState.tpl');

?>