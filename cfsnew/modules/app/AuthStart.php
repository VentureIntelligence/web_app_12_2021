<?php session_start();

//include_once('header.php');
require_once MODULES_DIR."users.php";
$user = new users();

require_once MODULES_DIR."Auth.php";
$authAdmin = new Auth();
$authAdmin->setLoginAttempts(AUTH_MAX_LOGIN_ATTEMPTS);
//$isAuth = $authAdmin->doAuth();


//For Facebook Integration

/*$loginPath =  WEB_DIR.'login.php';
$logoutPath =  WEB_DIR.'logout.php';
$termsPath = WEB_DIR.'terms.php';
$aboutus = WEB_DIR.'aboutus.php';
$contactus = WEB_DIR.'contactus.php';
$noticeboard = WEB_DIR.'noticeboard.php';
$sitemap = WEB_DIR.'sitemap.php';
$suggestion = WEB_DIR.'suggestion.php';
$faq = WEB_DIR.'faq.php';
$rconfirm = WEB_DIR.'rconfirm.php';
$profile = WEB_DIR.'profile.php';

$registerPath = WEB_DIR.'register.php';
$forgetpath = WEB_DIR.'forget.php';
$indexPath = WEB_DIR.'index.php';
$ajaxPath = WEB_DIR.'ajax.php';

if( (strstr($_SERVER['PHP_SELF'],WEB_ADMIN_DIR)) or 
	($_SERVER['PHP_SELF'] == $logoutPath) or 
	($_SERVER['PHP_SELF'] ==  $registerPath)  or 
	($_SERVER['PHP_SELF'] ==  $ajaxPath)  or 
	($_SERVER['PHP_SELF'] == $termsPath) or	
	($_SERVER['PHP_SELF'] == $aboutus) or	
	($_SERVER['PHP_SELF'] == $contactus) or	
	($_SERVER['PHP_SELF'] == $noticeboard) or	
	($_SERVER['PHP_SELF'] == $sitemap) or	
	($_SERVER['PHP_SELF'] == $suggestion) or	
	($_SERVER['PHP_SELF'] == $faq) or
	($_SERVER['PHP_SELF'] == $rconfirm) or	
	($_SERVER['PHP_SELF'] == $profile) or	
	($_SERVER['PHP_SELF'] ==  $forgetpath) ) {
		// Do nothing
} elseif($isAuth) {
	if( ($_SERVER['PHP_SELF'] ==  $loginPath) or ($_SERVER['PHP_SELF'] == $indexPath) ) {
		if($_GET['dest']) {
			header('Location: '.$_GET['dest']);
			exit();	
		} else {
			header('Location: '.WEB_DIR.'home.php');
			exit();
		}	
	}
} else {
	if($_SERVER['PHP_SELF'] !=  $loginPath) {
		header('Location: '.WEB_DIR.'login.php?dest='.$_SERVER['REQUEST_URI']);
		exit();
	}
}*/

?>