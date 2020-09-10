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

 
$link = mysql_connect('localhost', 'venture_cpslogin', 'Cps$2010'); 
if (!$link) { 
    die('Could not connect: ' . mysql_error()); 
} 
mysql_select_db('venture_cps',$link); 




$cin = $_GET['ID']; 
$vcid = $_GET['vcid'];

$cont = '';

$sql = "SELECT DISTINCT * FROM din_detail WHERE DIN=".$_GET['ID'];
$resultcps = mysql_query($sql,$link);
$bod_arr=array();$bocount=0;
if(mysql_num_rows($resultcps)>0){
    while ($rowcps = mysql_fetch_array($resultcps)) {
        if ($rowcps['Name of the Company']!=''){
            $bod_arr[$bocount]=$rowcps;
            $bocount++;
        }
        $dirname=$rowcps['Name of the Director'];
        
    }
}else{
    $cont = "<tr><td>No Records Found</td></tr>";
}

$template->assign('VCID',$vcid);
$template->assign('dir',$bod_arr);
$template->assign('nod',$dirname);
$template->assign('cont',$cont);

$template->assign('pageTitle',"CFS :: Board of Directors");
$template->assign('pageDescription',"CFS - Board of Directors");
$template->assign('pageKeyWords',"CFS - Board of Directors");

$template->display('bod.tpl');

include("footer.php");


?>
