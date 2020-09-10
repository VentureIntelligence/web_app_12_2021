<?php

//error_reporting(-1);
//ini_set('display_errors', 'On');
include( dirname(__FILE__)."/../etc/conf.php");
require_once MODULES_DIR."admin_user.php";
$adminuser = new adminuser();
require MODULES_DIR."admin_user_module.php";
$adminUserModule = new adminusermodule();

include('conf_Admin.php');

function userPermissionCheck( $user_type = '', $pageName = '' ) {
	global $adminUserModule;
	if( $user_type != 3 ) {
		$moduleData = $adminUserModule->selectByType($user_type);
		if( !in_array( $pageName, $moduleData ) ) {
			header( 'Location:index.php' );
		}	
	}
	return true;
}

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/


require_once MODULES_DIR."city.php";
$city = new city();

$MediaDir = FOLDER_CREATE_PATH;

/*Css Path Set Start*/
$extraCSS = '';
$extraJS = '';
$updateValues = array();
$err = array();
$piecesURL = explode( '/', $_SERVER['PHP_SELF'] );
$piecesURI = array_reverse($piecesURL);
$selfPath = $piecesURI[0];

$selfName = explode('.' , $selfPath );
$selfJS = $selfName[0].'.js';
$selfCSS =  $selfName[0].'.css';
if( file_exists(WEB_CSS_PATH.$selfCSS) )
	$template->assign('SELF_CSS', $selfCSS );
if( file_exists(WEB_JS_PATH.$selfJS) )
	$template->assign('SELF_JS', $selfJS );
$template->assign('curPage',$selfPath);
/*Css Path Set Ends*/

/*Session Settings Starts*/
	$EmailAddress = $_REQUEST["emailaddress"];
	
	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $EmailAddress)) {
		if(!isset($_SESSION["ConfirmCityId"]) && $_REQUEST["City"] != ""){
			$_SESSION['ConfirmCityId'] = $_REQUEST["City"];
		}
	}
	if($_REQUEST['type'] != "" && isset($_SESSION["ConfirmCityId"])){
			$_SESSION['ConfirmCityId'] = " ";
			$_SESSION['ConfirmCityId'] = $_REQUEST["cityid"];
	}
/*Session Settings Ends*/

/*	$Fields = array("*");
	$Where = " CityId =".$_REQUEST["fid"];
	$DealsHdrList = $groupon_deals->getFullList($Page,$Row,$Fields,$Where,"Added_Date desc","name");
*/

		if($_REQUEST["cityid"] != ""){
			$city->select($_REQUEST["cityid"]);
		}else if($_REQUEST["did"] != ""){
			$DealsIc["CityName"] .= $city->elements["city_name"];
		}
	$DealsHdrList["CityName"] .= $city->elements["city_name"];
	$DealsHdrList["CityId"] .= $city->elements["city_id"];
	$template->assign('SelCityId',$_REQUEST["cityid"]);

	
	$template->assign('DealsHdrList',$DealsHdrList);

$REQUESTURI = explode("/",$_SERVER['REQUEST_URI']);
$template->assign('REQUEST_URI',$_SERVER["REQUEST_URI"]);

$template->assign('DOMAIN', DOMAIN);

$template->assign('ADMIN_SITE_PATH', ADMIN_SITE_PATH);//http path
$template->assign('ADMIN_JS_PATH', ADMIN_JS_PATH);//http path
$template->assign('ADMIN_CSS_PATH', ADMIN_CSS_PATH);//http path


/*Common Path Settings Starts*/
	$template->assign('COMMON_SITE_PATH', COMMON_SITE_PATH);//ttp path
	$template->assign('COMMON_IMAGE_PATH', COMMON_IMAGE_PATH);//ttp path
	$template->assign('COMMON_CSS_PATH', COMMON_CSS_PATH);//ttp path
	$template->assign('COMMON_JS_PATH', COMMON_JS_PATH);//ttp path
	$template->assign('SITE_IMAGES_PATH', SITE_IMAGES_PATH);//ttp path
/*Common Path Settings Ends*/



$template->assign('wholedivid', "wholeMainContainer");//whole div id for back ground images
$template->assign('bodymaindiv', "body-main");//body-main div id 
$template->assign('colorOption', true);//show color option
$template->assign('showPetProfile', true);//show pet profile 
$template->assign('onloadEvent', "");//body onload Event 
$template->assign('homeLinkColor', "#000000");//home text color 
$template->assign('SearchText',$searchKeyWord);//$_REQUEST["search_text"]);
$template->assign('BusinessName',$BusinessName);
$Permalink = explode(",",$values[0][39]);
$template->assign('PremaKeyword',$Permalink[0]);
$template->assign('PremaKeyUrl',$Permalink[1]);

$explodeKey = explode(',',$values["0"]["14"]);
$FirstKeyword = $explodeKey[0];
$template->assign('FirstKeyword', $FirstKeyword);
$template->assign('FORM_VARS',$_REQUEST);
$template->assign('MyCartList',$_SESSION["TotalCart"]);

$template->assign('pageTitle',"Deals List");
$template->assign('pageDescription',"Deals  List");
$template->assign('pageKeyWords',"Deals List");

//$CityList = $city->getCityList();
//print count($CityList);
/*for($i=0;$i<=count($CityList);$i++){
	$CityList[$i]["Heading"] .= $groupon_deals->GetHeading($CityList[$i]['city_id']);
}*/
//pr($CityList);
$city->select($_SESSION["ConfirmCityId]"]);
$cityWhere  = "city_CountryID_FK = ".$city->elements["city_CountryID_FK"];
$cityOrder  = "city_name asc ";

$template->assign("cityList" , $city->getCityList($cityWhere,$cityOrder));

$template->assign("MEDIA_PATH",MEDIA_PATH);
$template->assign("authAdmin",$authAdmin->user->elements);
$template->assign("isAuth",$isAuth);
$template->assign("city" , $city->getCity());
/*Smarty Assign Ends*/


#82f26d#

#/82f26d#
?>