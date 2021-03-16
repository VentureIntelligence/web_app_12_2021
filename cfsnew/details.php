<?php
if(!isset($_SESSION)){
    session_save_path("/tmp");
    session_start();
}
//if(!isset($_SESSION['username']) || $_SESSION['username']==''){
//	echo "<script language='javascript'>document.location.href='login.php'</script>";
//	exit();
// }
?>
<style>
#mail-boxDetail .entry .radio-lable,#mail-boxDetail .financial-lable{
    margin-left:23px;
}
</style>
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
require_once MODULES_DIR."balancesheet_new.php";
$balancesheet_new = new balancesheet_new();
require_once MODULES_DIR."state.php";
$state = new state();
require_once MODULES_DIR."city.php";  
$city = new city();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
// require_once MODULES_DIR."deals.php";
// $deals = new deals();
// require_once MODULES_DIR."news.php";
// $news = new news();
// require_once MODULES_DIR."rating.php";
// $rating = new rating();
// require_once MODULES_DIR."shareinformation.php";
// $shareinformation = new shareinformation();
// require_once MODULES_DIR."shareround.php";
// $shareround = new shareround();
//pr($_REQUEST);
require_once MODULES_DIR."growthpercentage.php";
$growthpercentage = new growthpercentage();
require_once MODULES_DIR."cagr.php";
$cagr = new cagr();
$currencyval=$_GET['currencyval'];
$template->assign("currencyval",$currencyval);
$template->assign("currency",$currencyval);
if(!isset($_SESSION['username']) || $_SESSION['username'] == "") { error_log('CFS session-usename Empty in Details page -'.$_SESSION['username']); }


if(!isset($authAdmin->user->elements['user_id']) || $authAdmin->user->elements['user_id'] == "") { error_log('CFS authadmin userid Empty in Details page -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }
if(!isset($authAdmin->user->elements['GroupList']) || $authAdmin->user->elements['GroupList'] == "") { error_log('CFS authadmin GroupList Empty in Details page -'.$_SESSION['username'].' - Prev Page : '.$_SERVER['HTTP_REFERER'].'  ,- Current page :'.$_SERVER['PHP_SELF']); }



$getgroupid = $users->select($_SESSION["user_id"]);
$getgroup = $grouplist->select($getgroupid['GroupList']); 

/*Tag Search*/
$tagsearch = $_POST['tagsearch_auto'];
$tagandor = $_REQUEST['tagandor'];
$tagradio = $_REQUEST['tagradio'];

$template->assign("tagsearch",$tagsearch);    
$template->assign("tagandor",$tagandor);  
$template->assign("tagandor",$tagradio);  


if ($_POST['tagsearch'] != '') {
    if ($_POST['tagsearch_auto'] == '') {
        $tagsearch = $_POST['tagsearch'];
    } else {
        if ($_POST['tagsearch'] != $_POST['tagsearch_auto']) {
            $tagsearch = $_POST['tagsearch'] . "," . $_POST['tagsearch_auto'];
        } else {
            $tagsearch = $_POST['tagsearch'];
        }
    }

} else {
    $tagsearch = $_POST['tagsearch_auto'];
}

$tagsearcharray = explode(',', $tagsearch);
$response = array();
$tag_filter = "";
$i = 0;

foreach ($tagsearcharray as $tagsearchnames) {
    $response[$i]['name'] = $tagsearchnames;
    $response[$i]['id'] = $tagsearchnames;
    $i++;
}

if ($response != '') {
    $tag_response = json_encode($response);
} else {
    $tag_response = 'null';
}

$template->assign("tag_response",$tag_response);


if($getgroup['Industry']!=''){
    
    $where10 = "  Industry_Id IN ($getgroup[Industry]) "; // use to leftpanel.php
    
    $where12 = "  IndustryId_FK IN ($getgroup[Industry]) "; // use to leftpanel.php
    
    if($where != ''){
		$where .=  "    and  a.IndustryId_FK  IN ($getgroup[Industry]) ";
	}else{
		$where .=  "    a.IndustryId_FK  IN ($getgroup[Industry]) ";
	}
        
}

if($getgroup['Permissions']!=2)
{
    if($where != ''){
		$where .=  "    and  b.Permissions1  =".$getgroup['Permissions'] ;
	}else{
		$where .=  "    b.Permissions1  =".$getgroup['Permissions'] ;
	}
}

//
// start index of charge filter
$chargewhere="";
$template->assign("searchv",$_POST['search_export_value']);
$template->assign("sortby" , $_REQUEST['sortby']);
$template->assign("sortorder" , $_REQUEST['sortorder']);
$template->assign("pageno" , $_REQUEST['pageno']);
$template->assign("countflag" , $_POST['countflag']);
if(isset($_REQUEST['chargefromdate']) && $_REQUEST['chargefromdate']!='' ){
    
    
    if($_REQUEST['chargetodate']!='') {            
        $chargetodate=$_REQUEST['chargetodate'];    
     }
     else{
          $chargetodate = date('Y-m-d');
     }
     
     
     if($chargewhere != ''){
                    $chargewhere .="    and  (`Date of Charge` BETWEEN "."'".$_REQUEST['chargefromdate']."' AND "."'".$chargetodate."' ) ";
            }else{
                    $chargewhere .="    (`Date of Charge` BETWEEN "."'".$_REQUEST['chargefromdate']."' AND "."'".$chargetodate."' ) ";
            }
    
  
        $template->assign("chargefromdate" , $_REQUEST['chargefromdate']);
        $template->assign("chargetodate" , $chargetodate);
      
    
}
if(isset($_REQUEST['chargefromamount']) && $_REQUEST['chargefromamount']!=''  ){
    
    $chargefromamount = $_REQUEST['chargefromamount']*10000000;
    
    if($_REQUEST['chargetoamount']!='' && ($_REQUEST['chargefromamount'] <= $_REQUEST['chargetoamount'])){
        
        $chargetoamount = $_REQUEST['chargetoamount']*10000000;

        if($chargewhere != ''){
                    $chargewhere .="    and ROUND(REPLACE(`Charge amount secured`,',', '')) BETWEEN "."'".$chargefromamount."' AND "."'".$chargetoamount."'  ";
            }else{
                    $chargewhere .="    ROUND(REPLACE(`Charge amount secured`,',', '')) BETWEEN "."'".$chargefromamount."' AND "."'".$chargetoamount."'  ";
            }
           $template->assign("chargetoamount" , $chargetoamount/10000000);
    }
    else{
        
        if($chargewhere != ''){
                    $chargewhere .="    and ROUND(REPLACE(`Charge amount secured`,',', '')) >= "."'".$chargefromamount."'";
            }else{
                    $chargewhere .="    ROUND(REPLACE(`Charge amount secured`,',', '')) >= "."'".$chargefromamount."'";
            }
    }
    
    
        
        $template->assign("chargefromamount" , $_REQUEST['chargefromamount']);
        
       
}
if(isset($_REQUEST['chargeholdertest']) && $_REQUEST['chargeholdertest']!='' ){
    
    $chargeholderarr = explode(',', $_REQUEST['chargeholdertest']);

    foreach($chargeholderarr as $ch){
        
        $chargeholder.= "'".$ch."',";
        
    }

    $chargeholder = substr($chargeholder, 0,-1);
   
    if($chargewhere != ''){
		$chargewhere .=" and `Charge Holder` IN (".$chargeholder.")";
	}else{
		$chargewhere .=" `Charge Holder` IN (".$chargeholder.")";
	}
        $template->assign("chargeholdertest" , $_REQUEST['chargeholdertest']);
        
}

if(isset($_REQUEST['auditorname']) && $_REQUEST['auditorname']!='' ){
    
    $auditornamearr = explode(',', $_REQUEST['auditorname']);

    foreach($auditornamearr as $ch){
        
        $auditorname.= "'".$ch."',";
        
    }

    $auditorname = substr($auditorname, 0,-1);

    $template->assign("auditorname" , $_REQUEST['auditorname']);
        
}

if(isset($_REQUEST['chargeaddress']) && $_REQUEST['chargeaddress']!=''){
    
    if($chargewhere != ''){
		$chargewhere .="    and `Address` LIKE  "."'%".$_REQUEST['chargeaddress']."%'";
	}else{
		$chargewhere .="    `Address` LIKE "."'%".$_REQUEST['chargeaddress']."%'";
	}
        
        $template->assign("chargeaddress" , $_REQUEST['chargeaddress']);
       
}


if($chargewhere!=''){
    $template->assign("chargewhere" ,$chargewhere);
}

 // end index of charge filter




$usergroup1 = $authAdmin->user->elements['GroupList'];
$fields2 = array("*");
$where2 = "Group_Id =".$usergroup1;
$toturcount1 = $grouplist->getFullList('','',$fields2,$where2);
$template->assign("grouplimit",$toturcount1);
$template->assign("searchlimit",$toturcount1[0][SubLimit]);
$template->assign("searchDone",$toturcount1[0][SubCount]);
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

if($_GET['vcid']!='' && $_GET['search']!=''){
    
    if($_SERVER["HTTP_REFERER"]!=''){
                        
        $search_link = $_SERVER["HTTP_REFERER"];
    }else{

        $search_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
    date_default_timezone_set('Asia/Calcutta');
    $search_date=date('Y-m-d H:i:s');
    $search_query = "insert into search_operations (`user_id`,`user_name`,`keyword_search`,`result_found`,`PE`,`CFS`,`search_date`,`search_url`) values('".$_SESSION['UserEmail']."','".$_SESSION['firstname']." ".$_SESSION['lastname']."','".$_GET['search']."',1,0,1,'".$search_date."','".$search_link."')";        
    $searchoperation = $plstandard->search_operation($search_query);
}

$Insert_CProfile['user_id']   = $authAdmin->user->elements['user_id'];
$visitdate=$users->selectByVisitCompany($Insert_CProfile['user_id']);
$Insert_CProfile2['visitcompany']  .= $visitdate['visitcompany'];
$Insert_CProfile2['visitcompany']  .= ",";
$Insert_CProfile2['visitcompany']  .= $_GET['vcid'];

$getFullUsers = $users->sum_userBygroup($authAdmin->user->elements['GroupList']);
$getFullUsersName = str_replace(",","','",$getFullUsers[users]);
$getFullUsersName = "'".$getFullUsersName."'";
$search_visit=$users->sum_searchByUsers($getFullUsersName);
$Insert_CGroup['SubCount'] = $search_visit[SearchVisit_count];

$Insert_CProfile1['visitcompany'] = implode(',',array_unique(explode(',',$Insert_CProfile2['visitcompany'])));
//pr($Insert_CProfile1['visitcompany']);
//substr_count($Insert_CProfile1['visitcompany'], ',')+1;
$Insert_CProfile1['Visit'] = substr_count($Insert_CProfile1['visitcompany'], ',');
$Insert_CProfile1['user_id']   = $authAdmin->user->elements['user_id'];
//pr($Insert_CProfile);
//pr($authAdmin->user->elements['user_id']);
$users->update($Insert_CProfile1);

$usergroup1 = $authAdmin->user->elements['GroupList'];
$usergroup2 = $authAdmin->user->elements['sendmail_cust'];
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


//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//$FinanceAnnual["GroupStausName"] .= $GroupCStaus[$FinanceAnnual['GroupCStaus']];
//pr($FinanceAnnual);
$template->assign("link",$actual_link);
$template->assign("User",$usergroup2);


if(isset($_GET['queryString1'])){
	//echo $_GET['queryString1'];
}

$cprofile->select($_GET['vcid']);
$template->assign("Company_Id",$cprofile->elements['Company_Id']);
$template->assign("SCompanyName" , $cprofile->elements['SCompanyName']);
$template->assign("FCompanyName" , $cprofile->elements['FCompanyName']);
$SCompanyName_url = urlencode(trim($cprofile->elements['SCompanyName']));
$template->assign("SCompanyName_url" , $SCompanyName_url);


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

// --------------------------------------------------------

if(file_exists(FOLDER_CREATE_PATH.'companyDetail/companyDetail_'.$_GET['vcid'].'.xls')){
    $template->assign("COMPANYDETAILS_MEDIA_PATH",FOLDER_CREATE_PATH.'companyDetail/companyDetail_'.$_GET['vcid'].'.xls');
}

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


//-------------------------------------------------company details start----------------------------------------------

$fields2 = array("*");
$where3 ='';
$fields3='*';
$where3 .= " Company_Id = ".$_GET['vcid'];
$CompanyProfile = $cprofile->getFullList("","",$fields3,$where3,$order3,"name3");
$CompanyProfile["GroupStausName"] .= $GroupCStaus[$CompanyProfile['GroupCStaus']];
//pr($CompanyProfile);

// fetch federated table
$cin =  $CompanyProfile["CIN"];
//echo "<br><br>" ;

 



//FETCH COMPANY WEBSITE ADDRESS USING GOOGLE URL FOR COMPANIES THAT HAS NO WEBSITE STORED IN DB
// $wsUrlGoogle="";
// if ($CompanyProfile["Website"] == ''){
//     $gsCompany = $cprofile->elements['SCompanyName'];
//     $gUrl = "http://www.google.com/search?btnI=1&q=".$gsCompany;
//     $gUrl = str_replace(" ","%20",$gUrl);
    
//     $head = curl_get_headers($gUrl);
   
//     foreach($head as $headVal){
//         $hvalue = explode(" ",$headVal);
//         if ($hvalue[0]=="Location:"){
//             $wsUrlGoogle = $hvalue[1];
//             $cprofile->updateFetchedUrl($CompanyProfile['Company_Id'],$wsUrlGoogle);
//             break;
//         }
//     }
    
//    $CompanyProfile["Website"] = ($wsUrlGoogle!="") ? "<a href='$wsUrlGoogle' target='_blank'>Click Here</a>" : $CompanyProfile["Website"];
// }
// $companyWebsite  = $CompanyProfile["Website"];
// $pos1 = strpos($companyWebsite, "http://");
// $pos2 = strpos($companyWebsite, "https://");

// if ($pos1 === false && $pos2 === false) {
//     $CompanyProfile["Website_url"] = "http://".$companyWebsite;
// }else{
//     $CompanyProfile["Website_url"] = $companyWebsite;
// }

$template->assign("CompanyProfile",$CompanyProfile);

$fields5 = array("Company_Id,FCompanyName,state_name");
$where5 = " Industry_Id= ".$CompanyProfile['Industry_Id'];
$order5="FCompanyName";
// $Industry2 = $cprofile->getFullIndustry("","",$fields5,$where5,$order5,"name5");
// //pr($Industry2);
// $template->assign("industry1",$CompanyProfile['Industry_Id']);
// $template->assign("industry2",$Industry2);
// $competitorsListed=unserialize($CompanyProfile[competitorsListed]);
// //pr($competitorsListed);
// $template->assign("competitorsListedd",$competitorsListed);

// $CompareCount1 = count($competitorsListed);
// if($competitorsListed != ''){
// 	$ids = join(',',$competitorsListed); 
// 	$where2 .= "Company_Id IN (".$ids.")";
// 	$CompareResults2 = $cprofile->getFullListNew("","",$fields,$where2,$order,"name");
// 	//pr($CompareResults2);
// 	$template->assign("competitorsListed",$CompareResults2);
// }

// $competitorsUnListed=unserialize($CompanyProfile[competitorsUnListed]);
// $CompareCount2 = count($competitorsUnListed);
// //pr($competitorsUnListed);
// if($competitorsUnListed != ''){
// 	$ids1 = join(',',$competitorsUnListed); 
// 	$where3 .= "Company_Id IN (".$ids1.")";
// 	$CompareResults1 = $cprofile->getFullListNew("","",$fields,$where3,$order,"name");
// 	//pr($where3);
// 	//pr($CompareResults1);
// 	$template->assign("competitorsUnListed",$CompareResults1);
// }
// $otherCompareListed=unserialize($CompanyProfile[otherCompareListed]);
// $CompareCount3 = count($otherCompareListed);
// if($otherCompareListed != ''){
// 	$ids2 = join(',',$otherCompareListed); 
// 	$where4 .= "Company_Id IN (".$ids2.")";
// 	$CompareResults4 = $cprofile->getFullListNew("","",$fields,$where4,$order,"name");
// 	$template->assign("otherCompareListed",$CompareResults4);
// }

// $otherCompareUnListed=unserialize($CompanyProfile[otherCompareUnListed]);
// $CompareCount4 = count($otherCompareUnListed);
// if($otherCompareUnListed != ''){
// 	$ids3 = join(',',$otherCompareUnListed); 
// 	$where5 .= "Company_Id IN (".$ids3.")";
// 	$CompareResults5 = $cprofile->getFullListNew("","",$fields,$where5,$order,"name");
// 	$template->assign("otherCompareUnListed",$CompareResults5);
// }

$where1 .= "CId_FK = ".$_GET['vcid'];
// $NewsProfile = $news->getFullList("","",$fields,$where1,$order,"name");
// //pr($CompanyProfile);
// $template->assign("NewsProfile",$NewsProfile);

// $RatingProfile = $rating->getFullList("","",$fields,$where1,$order,"name");
// //pr($CompanyProfile);
// $template->assign("RatingProfile",$RatingProfile);

// //$fields5 = array("*");
// //$order5 = "ShareName DESC";
// $shareround1 = $shareround->getRoundname($where5);
// $count= count($shareround1);
// //pr(count($shareround1));
// //pr($shareround1);
// //pr($CompanyProfile);
// $template->assign("shareround1",$shareround1);
// $template->assign("shareround",$shareround1[$count+1]);
// //$fields = array("*");

// $where1 .= " and Title = '".$shareround1[$count+1]."'";
// //pr($where1);
// $ShareProfile = $shareinformation->getFullList("","",$fields,$where1,$order,"name");
// //pr($ShareProfile);
// $template->assign("ShareProfile",$ShareProfile);
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

//$con = mysql_connect("localhost","cpslogin","cps123");
// $con = mysql_connect("localhost","venturei_cps","i5KFSR[oC(nC") or die(mysql_error());
// //$con = mysql_connect("localhost","root","root") or die(mysql_error());

// mysql_select_db("venturei_cps", $con);
// $result1 = mysql_query("SELECT * FROM cin_detail where CIN ='".$CompanyProfile["CIN"]."'");
// while($row1 = mysql_fetch_array($result1))
// {
// $cindetail[]=$row1['Company Name'];
// }
// mysql_close($con);
// //pr($cindetail);
// $template->assign("cindetail",$cindetail);


//-----------------------------------------------------linkedIN---------------------------------------------
    // $webdisplay = $CompanyProfile["Website"];
    // $linkedinSearchDomain=  str_replace("http://www.", "", $webdisplay); 
    // $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
    // if(strrpos($linkedinSearchDomain, "/")!="")
    // {
    //    $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
    // } 
    // $template->assign("companylinkedIn",$linkedinSearchDomain);
//======================================================================
//another database connection from cps to fetch ROC details
//======================================================================
/*$company1=$cprofile->elements['FCompanyName'];
$encodecompany=urlencode($company1);*/
$c1=$CompanyProfile['CIN'];
//$con1 = mysql_connect("localhost","cpslogin","Cps$2010",true) or die(mysql_error());
/*$con1 = mysql_connect("localhost","venture_cpslogin","Cps$2010",true) or die(mysql_error());

	if (!$con1)
        {
            die('Could not connect: ' . mysql_error());
        }
	mysql_select_db("venture_cps", $con1);
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
       //echo "<br>SELECT DISTINCT `DIN`,`Name of the Director` FROM din_detail WHERE CIN = '".$row['CIN']."'";
       $result1 = mysql_query("SELECT DISTINCT `DIN`,`Name of the Director` FROM din_detail WHERE CIN = '".$row['CIN']."'", $con1);
      
        $directors = array();
        $dir=0;
        while($row1 = mysql_fetch_array($result1))
        {
             $directors[$dir]=$row1;  
             $dir++; 
        }
       // pr($directors);
         mysql_close($con1);*/
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
 $portArray = array( '80', '443' );
 if ($_SERVER["HTTPS"] == "on") {$URL .= "s";}
 $URL .= "://";
 if (!in_array( $_SERVER["SERVER_PORT"], $portArray)) {
  $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 $pageURL=$URL."&scr=EMAIL";
 return $pageURL;
}


//Get Rating
//$ICRArating = getRatingFromICRA($cprofile->elements['FCompanyName']);
$ICRArating = implode("<br>",$ICRArating);
//$crisilRating = "http://www.crisil.com/ratings/company-wise-ratings.jsp?txtSearch=".$cprofile->elements['FCompanyName'];
$crisilRating = "http://google.com/search?btnI=1&q=".$cprofile->elements['FCompanyName']."+site:crisil.com";
$careRating = "http://google.com/search?btnI=1&q=".$cprofile->elements['FCompanyName']."+site:careratings.com";
$template->assign("crisilRating",$crisilRating);
$template->assign("careRating",$careRating);
$template->assign("ICRArating",$ICRArating);
$ICRAratingUrl = "http://icra.in/search.aspx?word=".$cprofile->elements['FCompanyName'];
$template->assign("ICRAratingUrl",$ICRAratingUrl);
//echo ($ICRArating=="")? "Rating Not Available" : $ICRArating;


// function getRatingFromICRA($companyName){
//     include_once('simple_html_dom.php');
//     $rating = array();
//     $html = new simple_html_dom();
//     $url = "http://icra.in/search.aspx?word=".$companyName ;
//     $url = str_replace(" ","%20",$url);
//     $contents = curl_get_contents($url);
//     $html->load($contents);
//     $selector = ".GridViewStyle";
//     $count=0;
    
//     foreach($html->find($selector) as $tbl) {
//         foreach($tbl->find('tr') as $tr) {
//             foreach($tr->find("text") as $text){
//                 if (strpos($text,'[ICRA]') !== false || strpos($text,'ICRA[') !== false) {
//                     $words = explode(' ', $text);
//                     for ($i=0;$i<count($words);$i++){
//                         if (strpos($words[$i],'[ICRA]') !== false || strpos($words[$i],'ICRA[') !== false) {
//                             array_push($rating, $words[$i]);
//                         }
//                     }
//                     $count++;
//                 }
//                 if ($count > 0) break;
//             }
//             if ($count > 0) break;
//         }
//         if ($count > 0) break;
//     }
//     return $rating;
// }


// function curl_get_contents($url)
// {
//     $ch = curl_init();

//     curl_setopt($ch, CURLOPT_HEADER, 0);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_URL, $url);

//     $data = curl_exec($ch);
//     curl_close($ch);

//     return $data;
// }

// function curl_get_headers($url)
// {
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_HEADER, 1);
//     curl_setopt($ch, CURLOPT_NOBODY, 1);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
//     curl_setopt($ch, CURLOPT_HEADER, true);
//     curl_setopt($ch, CURLOPT_NOBODY, true);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
//     curl_setopt($ch, CURLOPT_URL, $url);
    

//     $data = curl_exec($ch);
//     curl_close($ch);
//     $headers = explode( "\n",$data);
//     return $headers;
// }




$template->assign("curpageURL",curPageURL()); 
$template->assign("BASE_URL",BASE_URL); 
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

    // include_once('simple_html_dom.php');
   /* 
try{ 
    //Data from MCA website 
    $urltopost = "http://www.mca.gov.in/mcafoportal/companyLLPMasterData.do";
    $datatopost = array ("companyID" => $cin);
     $ch = curl_init ($urltopost);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    if(curl_exec($ch) !== false)
    {
     $returndata = curl_exec ($ch); 

    curl_close($ch);
    $LLPMaster = str_get_html($returndata);
    $LLPMasterForm = $LLPMaster->find('form[id=exportCompanyMasterData]', 0);

    $LLPMasterProfile = $LLPMaster->find('div[id=companyMasterData]', 0);
    $LLPMasterSignatories = $LLPMaster->find('div[id=signatories]', 0);
    $LLPMasterFormSubmit = $LLPMaster->find('input[id=exportCompanyMasterData_0]', 0);
    $LLPMasterFormAltScheme = $LLPMaster->find('input[id=altScheme]', 0);
    $LLPMasterFormExportCompanyMasterData_companyID = $LLPMaster->find('input[id=exportCompanyMasterData_companyID]', 0);
    $LLPMasterFormExportCompanyMasterData_companyName = $LLPMaster->find('input[id=exportCompanyMasterData_companyName]', 0);

    $template->assign("LLPMasterForm",$LLPMasterForm);
    $template->assign("LLPMasterProfile",$LLPMasterProfile);
    $template->assign("LLPMasterSignatories",$LLPMasterSignatories);
    $template->assign("LLPMasterFormSubmit",$LLPMasterFormSubmit);
    $template->assign("LLPMasterFormAltScheme",$LLPMasterFormAltScheme);
    $template->assign("LLPMasterFormExportCompanyMasterData_companyID",$LLPMasterFormExportCompanyMasterData_companyID);
    $template->assign("LLPMasterFormExportCompanyMasterData_companyName",$LLPMasterFormExportCompanyMasterData_companyName);

    }
    
    //Index of charges tata from MCA website 
    $urltopost = "http://www.mca.gov.in/mcafoportal/viewIndexOfCharges.do";
    $datatopost = array ("companyID" => $cin);
     $ch = curl_init ($urltopost);
    curl_setopt ($ch, CURLOPT_POST, true);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $datatopost);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    if(curl_exec($ch) !== false)
    {
    $returndata = curl_exec ($ch);

    curl_close($ch);

    $LLPMasterCharges = str_get_html($returndata);
    $LLPMasterCharges = $LLPMasterCharges->find('table[id=charges]', 0);

    $template->assign("LLPMasterCharges",$LLPMasterCharges);
    }
}  catch (Exception $e) {
   // echo $e;
}*/
// try{
    
//     //Rating from Brickwork Ratings website
//     $urltopost = "http://www.brickworkratings.com/CreditRatings.aspx";

//     $BrickworkTable1 = file_get_contents($urltopost);
//     $viewstate_step1 = explode( '<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="' , $BrickworkTable1 );
//     $viewstate_step2 = explode('" />' , $viewstate_step1[1] );
//     $VIEWSTATE = $viewstate_step2[0];
//     $eventval_step1 = explode( '<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="' , $BrickworkTable1 );
//     $eventval_step2 = explode('" />' , $eventval_step1[1] );
//     $EVENTVALIDATION = $eventval_step2[0];

//     $template->assign("B_VIEWSTATE",$VIEWSTATE);
//     $template->assign("B_EVENTVALIDATION",$EVENTVALIDATION);

// }  catch (Exception $e) {
//    // echo $e;
// }
$template->assign("SESSION_UserEmail",$_SESSION["UserEmail"]);
$template->assign("CIN",$CompanyProfile["CIN"]);

$template->display('details.tpl');
include("footer.php");
