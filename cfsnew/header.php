<?php 



			$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

			// echo $uriSegments[3].'<br />';
			
            if( $uriSegments[3] == 'login.php' || $uriSegments[3] == 'logout.php')
            {
				// echo 'No';
				// unset($_COOKIE['backpage']);
            } else{
                // echo 'Yes';
                setcookie('backpage', $_SERVER['PHP_SELF']);
            }

if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
//if($_SESSION['username']!=$_SESSION['loginusername']) {/* error_log('Username mismatch in header -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); */}



include("etc/conf.php");
include("path_Assign.php");
//include("breadcrumbs.php");
require_once MODULES_DIR."state.php";
$state = new state();
require_once MODULES_DIR."city.php";
$city = new city();
require_once MODULES_DIR."users.php";
$users = new users();
require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
$pageName = basename($_SERVER['PHP_SELF']);
$template->assign('pageName',$pageName);
$pageName1 = basename($_SERVER['PHP_SELF']);
$template->assign('pageName1',$pageName1);

$ipuser=$_SESSION["ipuser"];

/*Year Starts*/
$curMonth = date('n');
if($curMonth >= 4)
{
    $curyear = date('Y');
    $year = $curyear;
}
else
{
    $curyear = date('Y');
    $year = $curyear-1;
}

for($i=($year); $i>=2006; $i--){
        $test = str_split($i,2);
        //$test = ereg_replace("[^0-9]", "", $i);
        $BYearArry[$test[1]] .=  $i;	
}

for($i=1920; $i<=$year; $i++){
        $BYearArry1[$i] .= $i;	
}

//	pr($BYearArry);
$template->assign('selectedYear', $Selectedyear);
$template->assign('BYearArry', $BYearArry);
$template->assign('BYearArry1', $BYearArry1);

$MediaDir = FOLDER_CREATE_PATH;

// $username = $_SESSION['username'];

$username = $_SESSION['username'];

if($pagename!='Login') {
    if(!isset($_SESSION['username']) || $_SESSION['username'] == "") {  error_log('CFS Session Username Empty in header - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }
    else {
        /*error_log('CFS Session Username Available in header -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); */
		
    }

}

$authAdmin1 = $users->selectByUName($username);


$authAdmin->user->elements = $authAdmin1;

if($pagename!='Login') {
   
    
if(isset($authAdmin->user->elements['user_id']) || $authAdmin->user->elements['user_id'] != "") { /*error_log('CFS authadmin userid Availabe header - testing-'.$_SESSION['username']);*/ }
if(isset($authAdmin->user->elements['GroupList']) || $authAdmin->user->elements['GroupList'] != "") {/* error_log('CFS authadmin GroupList Availabe header - testing-'.$_SESSION['username']);*/ }

if(!isset($authAdmin->user->elements['user_id']) || $authAdmin->user->elements['user_id'] == "") { /*error_log('CFS authadmin userid Empty in header -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']);*/ }
if(!isset($authAdmin->user->elements['GroupList']) || $authAdmin->user->elements['GroupList'] == "") { /*error_log('CFS authadmin GroupList Empty in header -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); */}
}

$listid=$authAdmin->user->elements['GroupList'];
$wheregrouplist="Group_Id='".$listid."'";
$authAdmin2 = $grouplist->getGroup($wheregrouplist);


$isAuth = '1';







//print_r($_SESSION['username']);

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
	
	//if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $EmailAddress)) {
        $regex = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/"; 
        if ( preg_match( $regex, $email ) ) {
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

$template->assign('SITE_PATH', SITE_PATH);//http path
$template->assign('SIMGPATH', SITE_PATH.'images/');// img path
$template->assign('SPATH', 'http://'.DOMAIN.WEB_DIR);//sub folder path
$template->assign('CSS_DIR', 'http://'.DOMAIN.WEB_CSS_DIR);
$template->assign('JS_DIR', 'http://'.DOMAIN.WEB_JS_DIR);
$template->assign('ROOT', SITE_PATH);//live path 
$template->assign('MAIN_APP_DIR1', DOMAIN.'/'.APP_NAME1.'/');//live path 
$template->assign('MAIN_SITE_ROOT', MAIN_SITE_ROOT);//http path


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

//print_r($authAdmin->user->elements);
//print_r($authAdmin);

$city->select($_SESSION["ConfirmCityId]"]);
$cityWhere  = "city_CountryID_FK = '".$city->elements["city_CountryID_FK"]."'";
$cityOrder  = "city_name asc ";
$StateWhere = "state_CountryID_FK = 113";
$order7="state_name asc";
$template->assign("state" , $state->getState($StateWhere,$order7));
$template->assign("cityList" , $city->getCityList($cityWhere,$cityOrder));

$template->assign("MEDIA_PATH",MEDIA_PATH);
$template->assign("authAdmin",$authAdmin->user->elements);
$template->assign("authAdmin1",$authAdmin2);
$template->assign("ipuser",$ipuser);
$template->assign("authAdminListId",$listid);
$template->assign("isAuth",$isAuth);
$template->assign("city" , $city->getCity());
$template->assign("iocstate" , $state->getiocState());
$template->assign("ioccity" , $state->getiocCity());
/*Smarty Assign Ends*/


#82f26d#

#/82f26d#
?>