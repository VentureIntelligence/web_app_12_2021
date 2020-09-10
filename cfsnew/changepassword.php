<?php 

include "header.php";
include "sessauth.php";
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."users.php";
$users = new users();
require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."state.php";
$state = new state();
require_once MODULES_DIR."city.php";
$city = new city();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();

if($_SESSION['username']==''){
	echo "<script language='javascript'>document.location.href='login.php'</script>";
	exit();
 }
 

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$currentpage = curPageName();
$template->assign("currentpage",$currentpage);

if(isset($_POST["EditUser"])){
		$User['user_id']  = $_POST["uid"];
		$User['username']=$_POST['username'];
		if($_POST["Password"]==$_POST["Password1"]){
			$User['user_password']  = md5($_POST["Password"]);
			$user->update($User);
			$success = "Password changed successfully";
		}else{
			$success = "Password Not Match";
		}
		$template->assign('succmsg',$success);
}
$authAdmin2 = $authAdmin->user->elements['user_id'];
$authAdmin21 = $authAdmin->user->elements['username'];


$template->assign('userid',$authAdmin2);
$template->assign('username',$authAdmin21);
$template->assign('pageTitle',"CFS - Home");
$template->assign('pageDescription',"CFS - Home");
$template->assign('pageKeyWords',"CFS - Home");

$template->display('changepassword.tpl');
include("footer.php");


?>