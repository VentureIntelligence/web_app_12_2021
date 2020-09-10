<?php
session_start();
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
require_once MODULES_DIR."state.php";
$state = new state();
require_once MODULES_DIR."city.php";  
$city = new city();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."deals.php";
$deals = new deals();
require_once MODULES_DIR."news.php";
$news = new news();
require_once MODULES_DIR."rating.php";
$rating = new rating();
require_once MODULES_DIR."shareinformation.php";
$shareinformation = new shareinformation();
require_once MODULES_DIR."shareround.php";
$shareround = new shareround();
//pr($_REQUEST);
require_once MODULES_DIR."growthpercentage.php";
$growthpercentage = new growthpercentage();
require_once MODULES_DIR."cagr.php";
$cagr = new cagr();



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
$where .= "CId_FK = ".$_GET['vcid'];
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

$template->assign("Company_Id",$cprofile->elements['Company_Id']);
$template->assign("SCompanyName" , $cprofile->elements['SCompanyName']);


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
 //echo FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls';
 
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

$company=$cprofile->elements['FCompanyName'];
$c=strtoupper($company);

if(empty($c)){
	echo "<script language='javascript'> 
            alert('Company not Found');
        document.location.href='home.php'</script>";
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

	if ($_POST && isset($_POST["Month1"]))
		if($dateFileName < $dateFrom || $dateFileName > $dateTo)
			{
			//echo "<BR>SKIPPED" . $dateFrom ."  " .$dateFrom;
			continue;
			}

	} // end of match
	// ----------------------------------------------

	$c2 = $c2 + 1;

	$str = "<li> <a href='". $signedUrl ."' target='_blank' >".  $pieces ."</a>&nbsp&nbsp&nbsp" .$object['Size'] ."</li><BR>";
	//echo $str;

	$str = "<a href='". $signedUrl ."' target='_blank'  >".  $pieces ."</a>&nbsp&nbsp&nbsp" .$object['Size'];
	//array_push($items, $str);

	array_push($items, array('name'=>$str,'uploaddate'=>($d."-".$m.'-'.$y)) );

}	// foreach

$result = $c2. " of ". $c1;

//-------------------------------------------------company details start----------------------------------------------

$fields2 = array("*");
$where3 ='';
$fields3='*';
$where3 .= " Company_Id = ".$_GET['vcid'];
$CompanyProfile = $cprofile->getFullList("","",$fields3,$where3,$order3,"name3");
$CompanyProfile["GroupStausName"] .= $GroupCStaus[$CompanyProfile['GroupCStaus']];
//pr($CompanyProfile);


//FETCH COMPANY WEBSITE ADDRESS USING GOOGLE URL FOR COMPANIES THAT HAS NO WEBSITE STORED IN DB
$wsUrlGoogle="";
if ($CompanyProfile["Website"] == ''){
    $gsCompany = $cprofile->elements['SCompanyName'];
    $gUrl = "http://www.google.com/search?btnI=1&q=".$gsCompany;
    $gUrl = str_replace(" ","%20",$gUrl);
    
    $head = curl_get_headers($gUrl);
   
    foreach($head as $headVal){
        $hvalue = explode(" ",$headVal);
        if ($hvalue[0]=="Location:"){
            $wsUrlGoogle = $hvalue[1];
            $cprofile->updateFetchedUrl($CompanyProfile['Company_Id'],$wsUrlGoogle);
            break;
        }
    }
    
   $CompanyProfile["Website"] = ($wsUrlGoogle!="") ? $wsUrlGoogle : $CompanyProfile["Website"];
}



$template->assign("CompanyProfile",$CompanyProfile);

$fields5 = array("Company_Id,FCompanyName,state_name");
$where5 = " Industry_Id= ".$CompanyProfile['Industry_Id'];
$order5="FCompanyName";
$Industry2 = $cprofile->getFullIndustry("","",$fields5,$where5,$order5,"name5");
//pr($Industry2);
$template->assign("industry1",$CompanyProfile['Industry_Id']);
$template->assign("industry2",$Industry2);
$competitorsListed=unserialize($CompanyProfile[competitorsListed]);
//pr($competitorsListed);
$template->assign("competitorsListedd",$competitorsListed);

$CompareCount1 = count($competitorsListed);
if($competitorsListed != ''){
	$ids = join(',',$competitorsListed); 
	$where2 .= "Company_Id IN (".$ids.")";
	$CompareResults2 = $cprofile->getFullListNew("","",$fields,$where2,$order,"name");
	//pr($CompareResults2);
	$template->assign("competitorsListed",$CompareResults2);
}

$competitorsUnListed=unserialize($CompanyProfile[competitorsUnListed]);
$CompareCount2 = count($competitorsUnListed);
//pr($competitorsUnListed);
if($competitorsUnListed != ''){
	$ids1 = join(',',$competitorsUnListed); 
	$where3 .= "Company_Id IN (".$ids1.")";
	$CompareResults1 = $cprofile->getFullListNew("","",$fields,$where3,$order,"name");
	//pr($where3);
	//pr($CompareResults1);
	$template->assign("competitorsUnListed",$CompareResults1);
}
$otherCompareListed=unserialize($CompanyProfile[otherCompareListed]);
$CompareCount3 = count($otherCompareListed);
if($otherCompareListed != ''){
	$ids2 = join(',',$otherCompareListed); 
	$where4 .= "Company_Id IN (".$ids2.")";
	$CompareResults4 = $cprofile->getFullListNew("","",$fields,$where4,$order,"name");
	$template->assign("otherCompareListed",$CompareResults4);
}

$otherCompareUnListed=unserialize($CompanyProfile[otherCompareUnListed]);
$CompareCount4 = count($otherCompareUnListed);
if($otherCompareUnListed != ''){
	$ids3 = join(',',$otherCompareUnListed); 
	$where5 .= "Company_Id IN (".$ids3.")";
	$CompareResults5 = $cprofile->getFullListNew("","",$fields,$where5,$order,"name");
	$template->assign("otherCompareUnListed",$CompareResults5);
}

$where1 .= "CId_FK = ".$_GET['vcid'];
$NewsProfile = $news->getFullList("","",$fields,$where1,$order,"name");
//pr($CompanyProfile);
$template->assign("NewsProfile",$NewsProfile);

$RatingProfile = $rating->getFullList("","",$fields,$where1,$order,"name");
//pr($CompanyProfile);
$template->assign("RatingProfile",$RatingProfile);

//$fields5 = array("*");
//$order5 = "ShareName DESC";
$shareround1 = $shareround->getRoundname($where5);
$count= count($shareround1);
//pr(count($shareround1));
//pr($shareround1);
//pr($CompanyProfile);
$template->assign("shareround1",$shareround1);
$template->assign("shareround",$shareround1[$count+1]);
//$fields = array("*");

$where1 .= " and Title = '".$shareround1[$count+1]."'";
//pr($where1);
$ShareProfile = $shareinformation->getFullList("","",$fields,$where1,$order,"name");
//pr($ShareProfile);
$template->assign("ShareProfile",$ShareProfile);
$template->assign("CompanyId",$_GET['vcid']);

$LastYear=date('y')-1;
$template->assign("LastYear",$LastYear);
//$template->assign("industries" , $industries->getIndustries($where4,$order4));
//$template->assign("sectors" , $sectors->getSectors($where5,$order5));


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

include "leftpanel.php";

//pr($CompanyProfile["CIN"]);

$con = mysql_connect("ventureintelligence.ipowermysql.com","cpslogin","cps123");
mysql_select_db("cps", $con);
$result1 = mysql_query("SELECT * FROM cin_detail where CIN ='".$CompanyProfile["CIN"]."'");
while($row1 = mysql_fetch_array($result1))
{
$cindetail[]=$row1['Company Name'];
}
mysql_close($con);
//pr($cindetail);
$template->assign("cindetail",$cindetail);


//-----------------------------------------------------linkedIN---------------------------------------------
    $webdisplay = $CompanyProfile["Website"];
    $linkedinSearchDomain=  str_replace("http://www.", "", $webdisplay); 
    $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
    if(strrpos($linkedinSearchDomain, "/")!="")
    {
       $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
    }
    $template->assign("companylinkedIn",$linkedinSearchDomain);
//======================================================================
//another database connection from cps to fetch ROC details
//======================================================================
/*$company1=$cprofile->elements['FCompanyName'];
$encodecompany=urlencode($company1);*/
$c1=$CompanyProfile['CIN'];
$con1 = mysql_connect("ventureintelligence.ipowermysql.com","cpslogin","Cps$2010",true);

	if (!$con1)
        {
            die('Could not connect: ' . mysql_error());
        }
	mysql_select_db("cps", $con1);
        //@mysql_ping() ? 'true' : 'false';
        $where = '';
            if($c1!=''){
                    if($where == ''){
                            $where = " CIN = '".$c1."'";
                    }else{
                            $where .= "and CIN = '".$c1."'";
                    }
            }
           
        
        $result = mysql_query("SELECT * FROM cin_detail where $where limit 0,1", $con1);
        $row = mysql_fetch_assoc($result);
        
       $rocdetail=$row['ROC Code'];
       
       $result1 = mysql_query("SELECT DISTINCT `DIN`,`Name of the Director` FROM din_detail WHERE CIN = '".$row['CIN']."'", $con1);
      
        $directors = array();
        $dir=0;
        while($row1 = mysql_fetch_array($result1))
        {
             $directors[$dir]=$row1;  
             $dir++; 
        }
        //pr($directors);
         mysql_close($con1);
      /* $subclass = $row['Sub-Class']; 
    $comp_details = array();
        $result3 = mysql_query("SELECT * FROM cin_detail WHERE `Sub-Class` like '".$row['Sub-Class']."' limit 0,5", $con1);
        
        while($row3 = mysql_fetch_array($result3))
        {
         $comp_details[] = $row3;
        }
       
        
      /*  $idc=0;
        for($i=0;$i < count($company);$i++)
        {
            echo "SELECT * FROM cprofile WHERE `FCompanyName` like '".$company[$i]."' limit 1";
            $sid = mysql_query("SELECT * FROM cprofile WHERE `FCompanyName` like '".$company[$i]."' limit 1");
            $row = mysql_fetch_assoc($sid);
            $idc[$i]=$row['id'];
        }*/
        //print_r($comp_details);
        $convalue = 10000000;
//======================================================================
function curPageURL() {
 $URL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $URL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $pageURL=$URL."&scr=EMAIL";
 return $pageURL;
}


//Get Rating
$ICRArating = getRatingFromICRA($cprofile->elements['FCompanyName']);
$ICRArating = implode("<br>",$ICRArating);
$crisilRating = "http://www.crisil.com/ratings/company-wise-ratings.jsp?txtSearch=".$cprofile->elements['FCompanyName'];
$careRating = "http://google.com/search?btnI=1&q=".$cprofile->elements['FCompanyName']."+site:careratings.com";
$template->assign("crisilRating",$crisilRating);
$template->assign("careRating",$careRating);
$template->assign("ICRArating",$ICRArating);
$ICRAratingUrl = "http://icra.in/search.aspx?word=".$cprofile->elements['FCompanyName'];
$template->assign("ICRAratingUrl",$ICRAratingUrl);
//echo ($ICRArating=="")? "Rating Not Available" : $ICRArating;


function getRatingFromICRA($companyName){
    include('simple_html_dom.php');
    $rating = array();
    $html = new simple_html_dom();
    $url = "http://icra.in/search.aspx?word=".$companyName ;
    $url = str_replace(" ","%20",$url);
    $contents = curl_get_contents($url);
    $html->load($contents);
    $selector = ".GridViewStyle";
    $count=0;
    
    foreach($html->find($selector) as $tbl) {
        foreach($tbl->find('tr') as $tr) {
            foreach($tr->find("text") as $text){
                if (strpos($text,'[ICRA]') !== false || strpos($text,'ICRA[') !== false) {
                    $words = explode(' ', $text);
                    for ($i=0;$i<count($words);$i++){
                        if (strpos($words[$i],'[ICRA]') !== false || strpos($words[$i],'ICRA[') !== false) {
                            array_push($rating, $words[$i]);
                        }
                    }
                    $count++;
                }
                if ($count > 0) break;
            }
            if ($count > 0) break;
        }
        if ($count > 0) break;
    }
    return $rating;
}


function curl_get_contents($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function curl_get_headers($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    

    $data = curl_exec($ch);
    curl_close($ch);
    $headers = explode( "\n",$data);
    return $headers;
}




$template->assign("curpageURL",curPageURL()); 
$template->assign("convalue",$convalue ); 
$template->assign("encodedcompany",$c);     
$template->assign("companies",$comp_details);
$template->assign("directors",$directors);
$template->assign("roc",$rocdetail);
$template->assign("industry",$industryrs);
$template->assign("rowcompid",$row['CIN']); 
$template->assign("boardResults", $rowi);     
$template->assign("companyResults", $rowcom);
$template->assign("searchResults",$items);

$template->assign('pageTitle',"CFS :: Company Profile");
$template->assign('pageDescription',"CFS - Company Profile");
$template->assign('pageKeyWords',"CFS - Company Profile");

$template->display('details.tpl');
include("footer.php");
