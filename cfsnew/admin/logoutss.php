<?php session_start();session_save_path("/tmp");
ob_start();
//include_once('conf_AdminBusiness.php');
	$_SESSION['business']['UName'] = '';
	$_SESSION['business']['Pwd'] = '';
	$_SESSION['business']['Ident'] =  '';
	$_SESSION['business']['Auth'] = false;
	session_unset('business'); 
	session_destroy();
	header('Location: login.php');
	exit();
//$template->display('adminBusiness/login.tpl');
?>