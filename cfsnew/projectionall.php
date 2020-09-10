<?php

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
require_once MODULES_DIR."balancesheet.php";
$balancesheet = new balancesheet();

require_once MODULES_DIR."growthpercentage.php";
$growthpercentage = new growthpercentage();
require_once MODULES_DIR."cagr.php";
$cagr = new cagr();
require_once MODULES_DIR."state.php";
$state = new state();
require_once MODULES_DIR."city.php";
$city = new city();

//pr($_REQUEST);
if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in projectionall page(dev) -'.$_SESSION['username']); }

$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("*");
$where2 = "Group_Id =".$usergroup1;
$toturcount1 = $grouplist->getFullList('','',$fields2,$where2);
$template->assign("grouplimit",$toturcount1);
//pr($toturcount1);
//GET PREV NEXT ID
    $prevNextArr = array();
    $prevNextArr = $_SESSION['resultCompanyId'];

    $currentKey = array_search($_GET['vcid'],$prevNextArr);
    $prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
    $nextKey = $currentKey+1;
    
    $template->assign("prevNextArr",$prevNextArr);     
    $template->assign("prevKey",$prevKey);
    $template->assign("nextKey",$nextKey);

$Insert_CProfile['user_id']   = $authAdmin->user->elements['user_id'];
$visitdate=$users->selectByVisitCompany($Insert_CProfile['user_id']);
$Insert_CProfile2['visitcompany']  .= $visitdate['visitcompany'];
$Insert_CProfile2['visitcompany']  .= ",";
$Insert_CProfile2['visitcompany']  .= $_GET['vcid'];

$Insert_CProfile1['visitcompany'] = implode(',',array_unique(explode(',',$Insert_CProfile2['visitcompany'])));
//pr($Insert_CProfile1['visitcompany']);
//substr_count($Insert_CProfile1['visitcompany'], ',')+1;
$Insert_CProfile1['Visit'] = substr_count($Insert_CProfile1['visitcompany'], ',')+1;
$Insert_CProfile1['user_id']   = $authAdmin->user->elements['user_id'];
//pr($Insert_CProfile);
//pr($authAdmin->user->elements['user_id']);
$users->update($Insert_CProfile1);

$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("GroupList","Visit");
$where2 = "GroupList=".$usergroup1;
$toturcount1 = $users->getFullList('','',$fields2,$where2);
$total = 0;
foreach($toturcount1 as $array)
{
   $total += $array['Visit'];
}
$Insert_CGroup['Group_Id'] = $usergroup1;
$Insert_CGroup['Used'] = $total;
$grouplist->update($Insert_CGroup);
//pr($total);

$fields = array("PLStandard_Id","CId_FK","IndustryId_FK","OptnlIncome","OtherIncome","OptnlAdminandOthrExp","OptnlProfit","EBITDA","Interest","EBDT","Depreciation","EBT","Tax","PAT","FY","TotalIncome","BINR","DINR","EmployeeRelatedExpenses","ForeignExchangeEarningandOutgo","EarninginForeignExchange","OutgoinForeignExchange");
$where .= "CId_FK = ".$_GET['vcid']." and FY !='' ";
$order="FY DESC";
$FinanceAnnual = $plstandard->getFullList(1,100,$fields,$where,$order,"name");

//$FinanceAnnual["GroupStausName"] .= $GroupCStaus[$FinanceAnnual['GroupCStaus']];
//pr($FinanceAnnual);
$template->assign("FinanceAnnual",$FinanceAnnual);

$fields1 = array("*");
$where1 = "CId_FK = ".$_GET['vcid'];
$order1 = "FY DESC";
$FinanceAnnual1 = $balancesheet->getFullList(1,100,$fields1,$where1,$order1,"name");

//$FinanceAnnual["GroupStausName"] .= $GroupCStaus[$FinanceAnnual['GroupCStaus']];
//pr($FinanceAnnual1);
$template->assign("FinanceAnnual1",$FinanceAnnual1);
$template->assign("FinanceAnnual2",count($FinanceAnnual1));

if(isset($_GET['queryString1'])){
	//echo $_GET['queryString1'];
}

//Ratio calculation
$where3 = "a.CId_FK = ".$_GET['vcid'];
$RatioCalculation = $plstandard->radioFinacial($where3);
//pr($RatioCalculation);
$template->assign("RatioCalculation",$RatioCalculation);
$template->assign("RatioCalculation1",count($RatioCalculation));


$cprofile->select($_GET['vcid']);
$template->assign("searchv",$_GET["searchv"]);
$template->assign("VCID",$_GET['vcid']);
$template->assign("Company_Id",$cprofile->elements['Company_Id']);
$template->assign("SCompanyName" , $cprofile->elements['SCompanyName']);
$template->assign("FCompanyName" , $cprofile->elements['FCompanyName']);
$template->assign("industries" , $industries->getIndustries($where3,$order3));
$template->assign("sectors" , $sectors->getSectors($where4,$order4));


if($_GET['D'] == "Yes"){
//$filename ="exporte.xls";
//$filename ="/media/plstandard/PLStandard_".$_GET['vcid']."xls";
//$contents = "testdata1 \t testdata2 \t testdata3 \t \n";

//header('Content-type: application/ms-excel');
//header('Content-Disposition: attachment; filename='.$filename);
//echo $contents;
}

$template->assign("VCID",$_GET['vcid']);

// ------------
if (isset($_GET["c"]) && !empty($_GET["c"]) )
$template->assign("c",$_GET['c']);
// --------------

if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls')){
	$template->assign("PLSTANDARD_MEDIA_PATH",FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls');
}
if(file_exists(FOLDER_CREATE_PATH.'pldetailed/PLDetailed_'.$_GET['vcid'].'.xls')){
	$template->assign("PLDETAILED_MEDIA_PATH",FOLDER_CREATE_PATH.'pldetailed/PLDetailed_'.$_GET['vcid'].'.xls');
}
if(file_exists(FOLDER_CREATE_PATH.'balancesheet/BalSheet_'.$_GET['vcid'].'.xls')){
	$template->assign("BSHEET_MEDIA_PATH",FOLDER_CREATE_PATH.'balancesheet/BalSheet_'.$_GET['vcid'].'.xls');
}
if(file_exists(FOLDER_CREATE_PATH.'cashflow/Cashflow_'.$_GET['vcid'].'.xls')){
	$template->assign("CASHFLOW_MEDIA_PATH",FOLDER_CREATE_PATH.'cashflow/Cashflow_'.$_GET['vcid'].'.xls');
}


// --------------------------------------------------------
// --------------------------------------------------------


require_once('aws.phar');
use Aws\S3\S3Client;

if (isset($_GET["c"]) && !empty($_GET["c"]) ){

$client = S3Client::factory(array(
    'key'    => 'AKIAJCWUBWTBTKKNPQZQ',
    'secret' => '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'
));



$bucket='heggooo';

$iterator = $client->getIterator('ListObjects', array(
    'Bucket' => $bucket,
    'Prefix' => 'Upload1/' . $c
));


$c1=0;$c2=0;


$items = array();


//Echo '<OL>';
foreach ($iterator as $object) {
    //echo $object['Key'] . "<br>";



	$fileName =  $object['Key'];

	// Get a pre-signed URL for an Amazon S3 object
	$signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');
	// > https://my-bucket.s3.amazonaws.com/data.txt?AWSAccessKeyId=[...]&Expires=[...]&Signature=[...]

	$pieces = explode("/", $fileName);
	$pieces = $pieces[ sizeof($pieces) - 1 ];


	//foreach ($pieces as $it)
    //	echo $it ."<br>";


	$fileNameExt = $pieces;
	$ext = ".pdf";



	// ----------------------------------
	// test if the word ends with '.pdf'
	if ( strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt) ){
		//echo "<BR>EXT";
		continue;
		}
	// ----------------------------------

  	$c1 = $c1 + 1;

	// ----------------------------------------------
	// detect date pattern from filename

/*

	$string = "/\d{6,6}/";

	$paragraph = $fileNameExt;

	if (preg_match_all($string, $paragraph, $matches)) {
	  //echo count($matches[0])  // Total size

	$dateFileName = $matches[0][ count($matches[0]) -1 ];	// get match from Right
	//echo $dateFileName .'<br>';

	$d = substr($dateFileName, 0, 2);
	$m = substr($dateFileName, 2, 2);
	$y = substr($dateFileName, 4, 2);


	if( intval($y) <30)	$y = (2000+ intval($y));
	else $y = (1900+ intval($y));


	//print_r( date_parse_from_format("jnY", $d. $m. $y) );
	$dateFileName= date_parse_from_format("jnY", $d. $m. $y);


	//print_r($dateFileName);

	// if date out of range


	if ($_POST)
		if($dateFileName < $dateFrom || $dateFileName > $dateTo)
			{
			//echo "<BR>SKIPPED" . $dateFrom ."  " .$dateFrom;
			continue;
			}

	} // end of match
	// ----------------------------------------------
*/



	$c2 = $c2 + 1;

	$str = "<a href=''  onclick=\"return check('". $signedUrl ."')\">".  $pieces ."</a>&nbsp&nbsp&nbsp" .$object['Size'];
	array_push($items, array('name'=>$str) );

}	// foreach

}
//======================================================================

include "leftpanel.php";
$template->assign("searchResults",$items);

$template->assign('pageTitle',"CFS :: Projection");
$template->assign('pageDescription',"CFS - Projection");
$template->assign('pageKeyWords',"CFS - Projection");

$template->display('projection.tpl');
include("footer.php");
