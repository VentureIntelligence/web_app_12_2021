<?php include_once("../globalconfig.php"); ?>
<?php

if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
include "header.php";
include "sessauth.php";
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."plstandard.php";
$plstandard = new plstandard();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();
require_once MODULES_DIR."users.php";
$users = new users();
require_once MODULES_DIR."grouplist.php";
$grouplist = new grouplist();



if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in downloadtrack page -'.$_SESSION['username']); }

if(!isset($authAdmin->user->elements['user_id']) || $authAdmin->user->elements['user_id'] == "") { error_log('CFS authadmin userid Empty in Downloadtrck -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }
if(!isset($authAdmin->user->elements['GroupList']) || $authAdmin->user->elements['GroupList'] == "") { error_log('CFS authadmin GroupList Empty in Downloadtrck -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }



$Insert_CProfile['user_id'] = $authAdmin->user->elements['user_id'];
$ExDownloadCountdate = $users->selectByVisitCompany($Insert_CProfile['user_id']);
$Insert_CProfile2['ExDownloadCompany']  .= $ExDownloadCountdate['ExDownloadCompany'];
$Insert_CProfile2['ExDownloadCompany']  .= ",";
$Insert_CProfile2['ExDownloadCompany']  .= $_GET['vcid'];

$Insert_CProfile1['ExDownloadCompany'] = implode(',',array_unique(explode(',',$Insert_CProfile2['ExDownloadCompany'])));
//pr($Insert_CProfile1['ExDownloadCompany']);
//substr_count($Insert_CProfile1['ExDownloadCompany'], ',')+1;
$Insert_CProfile1['ExDownloadCount'] = substr_count($Insert_CProfile1['ExDownloadCompany'], ',')+1;
$Insert_CProfile1['user_id']   = $authAdmin->user->elements['user_id'];
//pr($Insert_CProfile);
//pr($authAdmin->user->elements['user_id']);
$users->update($Insert_CProfile1);

$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("GroupList","ExDownloadCount");
$where2 = "GroupList=".$usergroup1;
$toturcount1 = $users->getFullList('','',$fields2,$where2);
$total = 0;
foreach($toturcount1 as $array)
{
   $total += $array['ExDownloadCount'];
}
$Insert_CGroup['Group_Id'] = $usergroup1;
$Insert_CGroup['ExCount'] = $total;
$grouplist->update($Insert_CGroup);
//pr($total);

//limit condition check
$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("*");
$where2 = "Group_Id =".$usergroup1;
$toturcount2 = $grouplist->getFullList('','1000',$fields2,$where2);
$template->assign("grouplimit",$toturcount2);
//$value = $grouplist->getGroup();
//pr($toturcount2);
//pr($toturcount2[0][ExLimit]);
//pr($toturcount2[0][ExCount]);

//echo $toturcount22[0]['exportLimit']."<br>";
//echo $toturcount22[0]['ExDownloadCount']; exit;

if($toturcount2[0][3] >= $toturcount2[0][7]){
	/*echo "<script type='text/javascript'>document.body.offsetWidth=300px;document.body.offsetHeight=100px;</script>";
	echo "<div style='background-color:#F5F0E4;width:300px;height:100px;border-radius:10px;margin:0px auto;'><br/><br/><span style='color:#000000;width:150px;height:80px;border-radius:10px;margin-left:110px;'><a href='<?php echo GLOBAL_BASE_URL; ?>cfs/media/plstandard/PLStandard_".$_GET['vcid'].".xls' style='text-decoration:none;color:#800000;'>Download</a></span></div>";
	$file=GLOBAL_BASE_URL.'cfs/media/plstandard/PLStandard_'.$_GET['vcid'].'.xls';
	//readfile($file);*/
            // We'll be outputting a PDF
            $where2 = "Company_Id =".$_GET['vcid'];
            $order="";
            $companyname = $cprofile->getCompanies($where2,$order);
    if(isset($_GET['type']) && $_GET['type']=='consolidated'){
        $file=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'_1.xls';
        $filename=$companyname[$_GET['vcid']].'_CF_Cons.xls';//die;
    }else{
        $file=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'.xls';     
        $filename=$companyname[$_GET['vcid']].'_CF_Stand.xls';//die; 
    }

//echo $file;//die;

            // We'll be outputting a PDF


   

    $filename= str_replace(' ', '_', $filename);
  
    header('Content-Description: File Transfer');
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename='.basename($filename));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
	
}else{
	pr("Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription");
}
mysql_close();	
?>