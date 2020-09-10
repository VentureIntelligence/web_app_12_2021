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

$StateWhere = "state_CountryID_FK = 113";
$template->assign("state" , $state->getState($StateWhere,$order7));
$template->assign("city" , $city->getCity());


if($_SESSION['username']==''){
	echo "<script language='javascript'>document.location.href='login.php'</script>";
	exit();
 }


$template->assign('backcid',$_GET['cid']);

//left panel


$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("*");
$where2 = "Group_Id =".$usergroup1;
$toturcount1 = $grouplist->getFullList('','',$fields2,$where2);
$template->assign("grouplimit",$toturcount1);
//pr($toturcount1);


$companylimit = count($authAdmin->user->elements['company']);
$companylimit1 = $companylimit - 1;
//pr($companylimit1);

if($companylimit1 != 0){
	$template->assign("companylimit",$companylimit1);
}else{
    $value='Unlimited';
	$template->assign("companylimit",$value);
}

$template->assign("fdownload",$authAdmin->user->elements['ExDownloadCount']);

/*
if ($_POST) {

	$c = $_REQUEST["c"];
        
	//echo "COMPANY:  " .$c ."<br><br>";

}
else
if (isset($_REQUEST["c"]) && !empty($_REQUEST["c"]) ){

	$c = urldecode($_REQUEST["c"]);
	//echo "COMPANY:  " .$c ."<br><br>";
        $template->assign("companyName",$c);
 }*/

$cprofile->select($_GET['cid']);
$c = $cprofile->elements['FCompanyName'];

if( !isset($c) || empty($c) ){
	echo "<script language='javascript'>document.location.href='home.php'</script>";
	exit();
}

// ==========================================================
// When Dates are selected and "Filter button is pressed
// ==========================================================

if ($_POST && isset($_POST["Month1"])) {

	// when date range is used
	$dateFrom = date_parse_from_format("jnY","1/" .$_POST["Month1"] ."/" .$_POST["Year1"] );	// d/m/y
	$dateTo = date_parse_from_format("jnY","1/" .$_POST["Month2"] ."/" .$_POST["Year2"] );	// d/m/y

}

require_once MAIN_PATH.APP_NAME."/aws.php";	// load logins

require_once('aws.phar');

use Aws\S3\S3Client;

$client = S3Client::factory(array(
    'key'    => $GLOBALS['key'],
    'secret' => $GLOBALS['secret']
));

$bucket = $GLOBALS['bucket'];

$iterator = $client->getIterator('ListObjects', array(
    'Bucket' => $bucket,
    'Prefix' => $GLOBALS['root'] . $c
));


$c1=0;$c2=0;

$items = $object1 = array();
//Echo '<OL>';
foreach ($iterator as $object) {
	$fileName =  $object['Key'];
    // Get a pre-signed URL for an Amazon S3 object
	$signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');
	// > https://my-bucket.s3.amazonaws.com/data.txt?AWSAccessKeyId=[...]&Expires=[...]&Signature=[...]

	$pieces = explode("/", $fileName);
	$pieces = $pieces[ sizeof($pieces) - 1 ];

	//foreach ($pieces as $it)
    //	echo $it ."<br>";
        
	$fileNameExt = $pieces;
	$ex_ext = explode(".", $fileNameExt);
        $ext = $ex_ext[count($ex_ext)-1];
        $find_year1 = $ex_ext[count($ex_ext)-2];
       // $find_year = substr($find_year1, -4);
        $find_first_letter = substr($find_year1, 0, 6);
        $object['filename'] = $fileNameExt; 
        $find_first_letter = strtolower(trim($find_first_letter));
        if($find_first_letter == 'annual' || $find_first_letter == 'anual'){
            $string = "/\d{4,4}/";

            $paragraph1 = $fileNameExt;

            if (preg_match_all($string, $paragraph1, $matches1)) {
              //echo count($matches[0])  // Total size

                $find_year = $matches1[0][ count($matches1[0]) -1 ];	// get match from Right
            }
            $object['f_year'] = $find_year; 
        }else{
            $object['f_year'] = '';             
        }
        
        
	// ----------------------------------------------
	// detect date pattern from filename

	$string = "/\d{6,8}/";

	$paragraph = $fileNameExt;

	if (preg_match_all($string, $paragraph, $matches)) {
	  //echo count($matches[0])  // Total size

	$dateFileName = $matches[0][ count($matches[0]) -1 ];	// get match from Right
	//echo $dateFileName .'<br>';

	$d = substr($dateFileName, 0, 2);
	$m = substr($dateFileName, 2, 2);
        if(strlen($dateFileName) == 6){
            $y = substr($dateFileName, 4, 2);
        }else{
            $y = substr($dateFileName, 4, 4);            
        }
        
        if(strlen($y) == 4 ){
            $y = $y;
        }else if( intval($y) <30){
            $y = (2000+ intval($y));
        }
	else{
            $y = (1900+ intval($y));
        }
        $file_date = $y.'-'.$m.'-'.$d;
        }
        if($y !='' && $m !='' && $d !=''){
            $object['form_date'] = $file_date;
        }else{
            $object['form_date'] = '';            
        }
        $object1[] = $object;
}	// foreach
sort($object1);
foreach ($object1 as $key1 => $row) {
    $f_year[$key1]  = $row['f_year'];
    $form_date[$key1] = $row['form_date'];
        $filename[$key1] = $row['filename'];
}

array_multisort($f_year, SORT_DESC,$form_date, SORT_DESC, $filename, SORT_ASC,  $object1);
//echo "<pre>";print_r($object1);echo "</pre>";

foreach($object1 as $object){
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
	$ex_ext = explode(".", $fileName);
        $ext = $ex_ext[count($ex_ext)-1];
	//$ext = ".pdf";
        
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

	/*$string = "/\d{6,8}/";

	$paragraph = $fileNameExt;

	if (preg_match_all($string, $paragraph, $matches)) {
	  //echo count($matches[0])  // Total size

	$dateFileName = $matches[0][ count($matches[0]) -1 ];	// get match from Right
	//echo $dateFileName .'<br>';

	$d = substr($dateFileName, 0, 2);
	$m = substr($dateFileName, 2, 2);
        if(strlen($dateFileName) == 6){
	$y = substr($dateFileName, 4, 2);
        }else{
            $y = substr($dateFileName, 4, 4);            
        }

        if(strlen($y) == 4 ){
            $y = $y;
        }else if( intval($y) <30){
            $y = (2000+ intval($y));
        }
	else{
            $y = (1900+ intval($y));
        }
        $file_date = $d.'-'.$m.'-'.$y;
        if($y !='' && $m !='' && $d !=''){
            $uploaddate = $file_date;
        }else{
            $uploaddate = '';            
        }
	//print_r( date_parse_from_format("jnY", $d. $m. $y) );
	$dateFileName= date_parse_from_format("jnY", $d. $m. $y);


	// if date out of range

	if ($_POST && isset($_POST["Month1"]) )
		if($dateFileName < $dateFrom || $dateFileName > $dateTo)
			{
			//echo "<BR>SKIPPED" . $dateFrom ."  " .$dateFrom;
			continue;
			}

	} // end of match*/
        if($object['form_date'] !=''){
            $uploaddate = date('d-m-Y',strtotime($object['form_date']));
        }else{
            $uploaddate = '';
        }
	// ----------------------------------------------




	$c2 = $c2 + 1;

	//Echo "<li> <a href=". $signedUrl .">".  $pieces ."</a>&nbsp&nbsp&nbsp"  .($object['Size']/1024.0) ."KB </li><BR>";



	//Echo "<li> <a id='google-link' href='' value=". $signedUrl .">".  $pieces ."</a>&nbsp&nbsp&nbsp" .$object['Size'] ."</li><BR>";


	//Echo "<li> <a href=''  onclick=\"return check('http://villasaraya.com/2.txt')\">".  $pieces ."</a>&nbsp&nbsp&nbsp" .$object['Size'] ."</li><BR>";

	$str = "<li> <a href='". $signedUrl ."' target='_blank' >".  $pieces ."</a></li><BR>";
	//echo $str;


	$str = "<a href='". $signedUrl ."' target='_blank'  >".  $pieces ."</a>";
	//array_push($items, $str);
 //echo $object['Key'] . "<br>";
	array_push($items, array('name'=>$str) );

}	// foreach

//Echo '</OL>';

//print_r($items);

//Echo $c2. " of ". $c1;

$result = $c2. " of ". $c1;



?>
<!--
<script type="text/javascript">
$('#result').val( "<?php echo ($c2. " of ". $c1); ?>" );
</Script>

-->
<?php


//======================================================================

//echo count($items);

$template->assign("companyName" , $c);
//$template->assign("FCompanyName" , $cprofile->elements['FCompanyName']);

$template->assign("searchResults",$items);
//$template->assign("companyName",$c);
$template->assign("VCID",$_GET["cid"]);

$template->assign("year1",$_POST["Year1"]);
$template->assign("month1",$_POST["Month1"]);

$template->assign("year2",$_POST["Year2"]);
$template->assign("month2",$_POST["Month2"]);
$template->assign("searchv",$_POST["search_export_value"]);


$template->assign("showresult",$result);
include "leftpanel.php";

$template->assign('pageTitle',"CFS :: View Filings");
$template->assign('pageDescription',"CFS - View Filings");
$template->assign('pageKeyWords',"CFS - View Filings");


$template->display('viewfiling.tpl');


include("footer.php");
?>


