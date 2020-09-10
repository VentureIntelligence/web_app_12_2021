<?php 
 //session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
 session_start();
ob_start();
//include_once('conf_AdminBusiness.php');
	$_SESSION['business']['UName'] = '';
	$_SESSION['business']['Pwd'] = '';
	$_SESSION['business']['Ident'] =  '';
	$_SESSION['business']['Auth'] = false;
	$_SESSION['business']['loggedUserName'] = '';
	//session_unset('business'); 
	//session_destroy();
	header('Location: login.php');
	exit();
//$template->display('adminBusiness/login.tpl');
?>