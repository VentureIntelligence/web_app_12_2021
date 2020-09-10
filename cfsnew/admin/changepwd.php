<?php

include "../header.php";
include "Image_ValidCheck.php";
include "conf_Admin.php";
require_once MODULES_DIR."admin_user.php";
$adminuser = new adminuser();

$adminuser->select($_SESSION["business"]["Ident"]);

if(!empty($_POST['pwd'])){
	$update_value = array();	
	$update_value['Ident'] = $_SESSION["business"]["Ident"];
	$update_value['Password'] = $_POST['pwd'];	
	$adminuser->update($update_value);
	$_SESSION['business']['UName'] = $adminuser->elements['userName'];
	$_SESSION['business']['Pwd'] = $update_value['Password'];
	$_SESSION['business']['Auth'] = true;
	$template->assign('msg',"Password changed Successfully");
}


$template->display('groupon/admin/changepwd.tpl');

?>