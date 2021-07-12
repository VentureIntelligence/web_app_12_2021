<style>
.result-select-close a {
    margin: -5px 6px 0px 0px !important;
}
</style>
<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
        include('checklogin.php');
        $companyId=632270771;
	$compId=0;
	$currentyear = date("Y");
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
    $resetfield=$_POST['resetfield'];
    $lgDealCompId = $_SESSION['DcompanyId'];
    $usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
    $usrRgres = mysql_query($usrRgsql) or die(mysql_error());
    $usrRgs = mysql_fetch_array($usrRgres);
   // echo "tagsearh:".$_POST['tagsearch'];
    
	// if ($resetfield == "tagsearch") {
    //     $_POST['tagsearch'] = "";
    //     $tagsearch = "";
    // } else {
    //     $tagsearch = $_POST['tagsearch'];
    // }	
  // print_r($_POST['stage']);   
	$showdeals = $_POST['showdeals'];
	$numberofcom= $_POST['numberofcom'];
        
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
		$AdvisorString = explode("/", $value);
        $strvalue = explode("/", $value);        
                //format is  PE - pe/vc , manda - pe/vc , SV - 1(as of now)
		$SelCompRef=$AdvisorString[0];
		$pe_exit_advisorflag=$AdvisorString[1];
                 $vcflagValue=$AdvisorString[1];
                $dealvalue=$AdvisorString[2];
		$pe_vc_flag=$AdvisorString[2];
        if( $_POST['searchallfield']!=""){
            if($_POST["month1"]!="" && $_POST["year1"]!="" && $_POST["month2"]!="" && $_POST["year2"]!="")
              { 
                  if($_POST['autocomplete'] != ""|| $_POST['industry'] != ""|| $_POST['invType'] != "" || $_POST['stage'] != "" || $_POST['firmtype'] != "" || $_POST['citysearch'] != ""|| $_POST['round'] != "--"|| $_POST['invrangestart'] != "--" || $_POST['invrangeend'] != "--"){
                      $_POST['searchallfield']="";
                      $_POST['searchKeywordLeft']="";
                      $_POST['searchTagsField']="";
                      $searchallfield="";
                      }
              }else{
                      if($_POST['autocomplete'] != ""|| $_POST['industry'] != ""|| $_POST['invType'] != "" || $_POST['stage'] != "" || $_POST['firmtype'] != "" || $_POST['citysearch'] != ""|| $_POST['round'] != ""|| $_POST['invrangestart'] != "" || $_POST['invrangeend'] != ""){
                  
                      
                          $_POST['searchallfield']="";
                          $_POST['searchKeywordLeft']="";
                          $_POST['searchTagsField']="";
                          $searchallfield="";
                      
                      }
              }
      }
      else{
          if($_POST['autocomplete'] != "" || $_POST['industry'] != "" || $_POST['invType'] != "" || $_POST['stage'] != "" || $_POST['round'] != "" || $_POST['invrangestart'] != "" || $_POST['invrangeend'] != "" || $_POST['firmtype'] != "" || $_POST['citysearch'] != "" || $_POST['country'] != "" || $_POST['city'] != "" || $_POST['countryNIN'] != ""){
      
              $_POST['searchallfield']="";
              $_POST['searchKeywordLeft']="";
              $_POST['searchTagsField']="";
              $searchallfield="";
            
          }
      }        
// if($_POST['autocomplete'] != "" || $_POST['industry'] != "" || $_POST['invType'] != "" || $_POST['stage'] != "" || $_POST['round'] != "" || $_POST['invrangestart'] != "" || $_POST['invrangeend'] != "" || $_POST['firmtype'] != "" || $_POST['citysearch'] != "" || $_POST['country'] != "" || $_POST['city'] != "" || $_POST['countryNIN'] != ""){

//         $_POST['searchallfield']="";
//         $_POST['searchKeywordLeft']="";
//         $_POST['searchTagsField']="";
//         $searchallfield="";
// }
if ($resetfield == "tagsearch") {

    $_POST['tagsearch'] = "";
    $_POST['tagsearch_auto'] = "";
    $tagsearch = "";
    $tagandor = 0;

} else if ($_POST['tagsearch_auto'] && $_POST['tagsearch_auto'] != '' || $_POST['tagsearch'] != '') {
    
    

    //$tagsearchauto = $_POST['tagsearch'];
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
    
} 

 


if ($resetfield == "keywordsearch") {
    $_POST['keywordsearch'] = "";
    $keyword                = "";
} else {
    $keyword = trim($_POST['keywordsearch']);
}

if ($resetfield == "industry") {
    $_POST['industry'] = "";
    $industry          = "";
} else {
    $industry = trim($_POST['industry']);
}

if ($resetfield == "stage") {
    $_POST['stage'] = "";
    $stageval       = "";
} else {
    $stageval = $_POST['stage'];
}

if ($_POST['stage'] && $stageval != "") {
    $boolStage = true;
    //foreach($stageval as $stage)
    //  echo "<br>----" .$stage;
} else {
    $stage     = "--";
    $boolStage = false;
}
if ($resetfield == "round") {
    $_POST['round'] = "";
    $round          = "--";
} else {
    $round = trim($_POST['round']);
    if ($round != '--') {
        $searchallfield = '';
    }
}
if ($resetfield == "invType") {
    $_POST['invType'] = "";
    $investorType     = "";
} else {
    $investorType = trim($_POST['invType']);
}
if ($resetfield == "firmtype") {
    $_POST['firmtype'] = "";
    $firmtypetxt       = "";
} else {
    $firmtypetxt = trim($_POST['firmtype']);
}
// For Country 
if ($resetfield == "country") {
    $_POST['country']    = "";
    $countrytxt          = "";
    $_POST['city']       = "";
    $cityname            = "";
    $_POST['countryNIN'] = "";
    $countryNINtxt       = "";
} else {
    $countrytxt = $_POST['country'];
}

// For City 
if ($resetfield == "city") {
    $_POST['city'] = "";
    $cityid        = "";
} else {
    $cityid = $_POST['city'];
}

// For countryNIN 
if ($resetfield == "countryNIN") {
    $_POST['countryNIN'] = "";
    $countryNINtxt       = "";
} else {
    $countryNINtxt = $_POST['countryNIN'];
}
if ($resetfield == "range") {
    $_POST['invrangestart'] = "";
    $_POST['invrangeend']   = "";
    $startRangeValue        = "--";
    $endRangeValue          = "--";
    $regionId               = "";
} else {
    $startRangeValue = $_POST['invrangestart'];
    $endRangeValue   = $_POST['invrangeend'];
}
// For Firm Type 
if ($_POST['firmtype'] != '') {
    $firmtypetxt     = $_POST['firmtype'];
    $firmtypesql     = "SELECT FirmType FROM firmtypes WHERE FirmTypeId = " . $firmtypetxt;
    $firmtypesql     = mysql_query($firmtypesql);
    $firmtypedisplay = mysql_fetch_array($firmtypesql);
    $firmtypename    = $firmtypedisplay['FirmType'];
}
$firmtypevalue = implode(",", $firmtypetxt);
foreach ($firmtypetxt as $firmid) {
    $firmsql = "select FirmType from firmtypes where FirmTypeId=$firmid";
    if ($firmtyp = mysql_query($firmsql)) {
        While ($myrow = mysql_fetch_array($firmtyp, MYSQL_BOTH)) {
            $firmvaluetext = $firmvaluetext . "," . $myrow["FirmType"];
            // print_r($firmvaluetext);
        }
    }
}
$firmvaluetext = substr_replace($firmvaluetext, '', 0, 1);
if ($cityid != '') {
    
    if ($cityid == '--') {
        $cityname = "All City";
    } else {
        $citysql = "select city_name from city where city_id = $cityid";
        
        if ($citytype = mysql_query($citysql)) {
            While ($myrow = mysql_fetch_array($citytype, MYSQL_BOTH)) {
                $cityname = $myrow["city_name"];
                //echo $cityname;
            }
        }
    }
    
}

if ($countryNINtxt != '') {
    if ($countryNINtxt == 'All') {
        $countryNINname = "All Countries";
    } else {
        $countrysql = "select country from country where countryid = '" . $countryNINtxt . "'";
        
        if ($countrytype = mysql_query($countrysql)) {
            While ($myrow = mysql_fetch_array($countrytype, MYSQL_BOTH)) {
                $countryNINname = $myrow["country"];
                //echo $countryNINname;
            }
        }
    }
    
}

if ($countrytxt != "") {
    if ($countrytxt == "IN") {
        $countrynametxt = "India";
    } else if ($countrytxt == "NIN") {
        $countrynametxt = "Non India";
    }
}
$endRangeValueDisplay = $endRangeValue;
$whereind             = "";
$whereinvType         = "";
$wherestage           = "";
$wheredates           = "";
$whererange           = "";

if ($resetfield == "period" && !$_GET) {
    $month1          = "--";
    $year1           = "--";
    $month2          = "--";
    $year2           = "--";
    $_POST['month1'] = $_POST['month2'] = $_POST['year1'] = $_POST['year2'] = "";
} else {
    $month1 = ($_POST['month1']) ? $_POST['month1'] : date('m');
    $year1  = ($_POST['year1']) ? $_POST['year1'] : date('Y') - 3;
    $month2 = ($_POST['month2']) ? $_POST['month2'] : date('n');
    $year2  = ($_POST['year2']) ? $_POST['year2'] : date('Y');
}

if ($resetfield == "followonVCFund") {
    $_POST['followonVCFund'] = "";
    $followonVC              = "--";
} else {
    $followonVC = trim($_POST['followonVCFund']);
    if ($followonVC != '--' && $followonVC != '') {
        $searchallfield = '';
    }
}
if ($followonVC == "--") {
    $followonVCFund = "--";
} elseif ($followonVC == 1) {
    $followonVCFund = 1;
} elseif ($followonVC == 2) {
    $followonVCFund = 3;
}
if ($followonVCFund == "--") {
    $followonVCFundText == "";
} elseif ($followonVCFund == "1") {
    $followonVCFundText = "Follow on Funding";
} elseif ($followonVCFund == "3") {
    $followonVCFundText = "No Funding";
}

if ($resetfield == "exitedstatus") {
    $_POST['exitedstatus'] = "";
    $exitvalue             = "--";
} else {
    $exitvalue = trim($_POST['exitedstatus']);
    if ($exitvalue != '--' && $exitvalue != '') {
        $searchallfield = '';
    }
}
if ($exitvalue == "--")
    $exited = "--";
elseif ($exitvalue == 1)
    $exited = 1;
elseif ($exitvalue == 2)
    $exited = 3;

if ($exited == "--") {
    $exitedText = "";
} elseif ($exited == "1") {
    $exitedText = "Exited";
} elseif ($exited == "3") {
    $exitedText = "Not Exited";
    
}

$datevalue  = returnMonthname($month1) . "-" . $year1 . "to" . returnMonthname($month2) . "-" . $year2;
$splityear1 = (substr($year1, 2));
$splityear2 = (substr($year2, 2));

if (($month1 != "") && ($month2 !== "") && ($year1 != "") && ($year2 != "")) {
    $datevalueDisplay1 = returnMonthname($month1) . " " . $splityear1;
    $datevalueDisplay2 = returnMonthname($month2) . "  " . $splityear2;
    $wheredates1       = "";
}


if ($resetfield == "searchallfield") {
    $_POST['searchallfield'] = "";
    $searchallfield          = "";
} else {
    $searchallfield = trim($_POST['searchallfield']);
}

if ($resetfield == "dirsearch") {
    $_POST['dirsearch'] = "";
    $dirsearch          = "";
} else {
    $dirsearch = trim($_POST['dirsearch']);
}

if ($resetfield == "autocomplete") {
    $_POST['autocomplete'] = "";
    $dirsearch             = "";
} else {
    $dirsearch = trim($_POST['autocomplete']);
}

if ($resetfield == "city") {
    $_POST['citysearch'] = "";
    $city1                = "";
} else {
    $city1 = trim($_POST['citysearch']);
    
}

if ($resetfield == "companysearch") {
    $_POST['companysearch'] = "";
    $companysearch  = "";
} else {
    $companysearch = trim($_POST['companysearch']);
    
}

if ($resetfield == "sectorsearch") {
    $_POST['sectorsearch'] = "";
    $sectorsearch  = "";
} else {
    $sectorsearch = trim($_POST['sectorsearch']);
    
}

if ($vcflagValue == 0) {
    
    $addVCFlagqry       = "";
    $checkForStage      = ' && (' . '$stage' . ' =="")';
    //$checkForStage = " && (" .'$stage'."=='--') ";
    $checkForStageValue = " || (" . '$stage' . ">0) ";
    $searchTitle        = "List of PE Investors ";
} elseif ($vcflagValue == 1) {
    $addVCFlagqry       = "";
    $addVCFlagqry       = "and s.VCview=1 and pe.amount<=20 ";
    $checkForStage      = '&& (' . '$stage' . '=="") ';
    //$checkForStage = " && (" .'$stage'."=='--') ";
    $checkForStageValue = " || (" . '$stage' . ">0) ";
    $searchTitle        = "List of VC Investors ";
    //  echo "<br>Check for stage** - " .$checkForStage;
}

if ($industry > 0) {
    $industrysql = "select industry from industry where IndustryId=$industry";
    if ($industryrs = mysql_query($industrysql)) {
        While ($myrow = mysql_fetch_array($industryrs, MYSQL_BOTH)) {
            $industryvalueflt = $myrow["industry"];
        }
    }
}

if ($boolStage == true) {
    foreach ($stageval as $stageid) {
        $stagesql = "select Stage from stage where StageId=$stageid";
        //  echo "<br>**".$stagesql;
        if ($stagers = mysql_query($stagesql)) {
            While ($myrow = mysql_fetch_array($stagers, MYSQL_BOTH)) {
                $stagevaluetext = $stagevaluetext . "," . $myrow["Stage"];
            }
        }
    }
    $stagevaluetext = substr_replace($stagevaluetext, '', 0, 1);
} else {
    $stagevaluetext = "";
    
    if ($investorType != "") {
        $invTypeSql = "select InvestorTypeName from investortype where InvestorType='$investorType'";
        if ($invrs = mysql_query($invTypeSql)) {
            While ($myrow = mysql_fetch_array($invrs, MYSQL_BOTH)) {
                $invtypevalue = $myrow["InvestorTypeName"];
            }
        }
    }
}

if ($resetfield == "txtregion") {
    $_POST['txtregion'] = "";
} else {
    $txtregion = $_POST['txtregion'];
    if ($txtregion != '--' && count($txtregion) > 0) {
        $searchallfield = '';
    }
}

if ($txtregion == "--") {
    $regionText = "";
} else {
    // $regionText="Region";
    if (count($txtregion) > 0) {
        $region_Sql = $regionvalue = '';
        foreach ($txtregion as $regionIds) {
            $region_Sql .= " RegionId=$regionIds or ";
        }
        $roundSqlStr = trim($region_Sql, ' or ');
        
        $regionSql = "select Region from region where $roundSqlStr";
        if ($regionrs = mysql_query($regionSql)) {
            While ($myregionrow = mysql_fetch_array($regionrs, MYSQL_BOTH)) {
                $regionvalue .= $myregionrow["Region"] . ', ';
            }
        }
        $regionText  = trim($regionvalue, ', ');
        $region_hide = implode($txtregion, ',');
    }
}
//echo "<br>*************".$stagevaluetext;
if ($companyType == "L")
    $companyTypeDisplay = "Listed";
elseif ($companyType == "U")
    $companyTypeDisplay = "UnListed";
elseif ($companyType == "--")
    $companyTypeDisplay = "";

if ($investorType != "") {
    $invTypeSql = "select InvestorTypeName from investortype where InvestorType='$investorType'";
    if ($invrs = mysql_query($invTypeSql)) {
        While ($myrow = mysql_fetch_array($invrs, MYSQL_BOTH)) {
            $invtypevalue = $myrow["InvestorTypeName"];
        }
    }
}

if ($regionId > 0) {
    $regionSql = "select Region from region where RegionId=$regionId";
    if ($regionrs = mysql_query($regionSql)) {
        While ($myregionrow = mysql_fetch_array($regionrs, MYSQL_BOTH)) {
            $regionvalue = $myregionrow["Region"];
        }
    }
}

if ($round != "--" || $round != null) {
    $roundSql = "SELECT * FROM `peinvestments` where `round` like '" . $round . "%'  group by `round`";
    if ($roundQuery = mysql_query($roundSql)) {
        $roundtxt = '';
        While ($myrow = mysql_fetch_array($roundQuery, MYSQL_BOTH)) {
            $roundtxt .= $myrow["round"] . ",";
        }
        $roundtxt = trim($roundtxt, ',');
    }
}
		$exportToExcel=0;
                $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
                where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
                //echo "<br>---" .$TrialSql;
                if($trialrs=mysql_query($TrialSql))
                {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $exportToExcel=$trialrow["TrialLogin"];
                        }
                }
		$exportToExcel1=0;
                $TrialSql1="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,malogin_members as dm
                where dm.EmailId='$maemailid' and dc.DCompId=dm.DCompId";
                //echo "<br>---" .$TrialSql;
                if($trialrs1=mysql_query($TrialSql1))
                {
                        while($trialrow1=mysql_fetch_array($trialrs1,MYSQL_BOTH))
                        {
                                $exportToExcel1=$trialrow1["TrialLogin"];
                        }
                }

					$AdvisorSql="select * from advisor_cias where CIAId=$SelCompRef";


                                $dealpage="dealdetails.php";
                                
                                if($pe_exit_advisorflag==1)
				{
                                  //   echo "<br>Inside PE";
				//	$dealpage="dealinfo.php";
                                        $dealpage="dealdetails.php";
                                        $headerurl="tvheader_search.php";
					if($pe_vc_flag==0)
                                        {       
                                                
						$addVCFlagqry="";
						$pagetitle="PE Advisors";
					}
					elseif($pe_vc_flag==1)
					{
                                            
						$addVCFlagqry = "and s.VCview=1 and peinv.amount<=20 ";
						$pagetitle="VC Advisors";
					}
                                        $tdtitle =" Investors";

				 $advisor_to_companysql="
					SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt,peinv.PEId as PEId
					FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac, stage as s
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef order by dates";
                                        

					$advisor_to_investorsql="
					SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.PEId as PEId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef order by dates";

				}
	//echo "<br>********----company".$advisor_to_companysql;
	//echo "<br>*******-----Investor".$advisor_to_investorsql;

				if($pe_exit_advisorflag==2)
				{
                                     //  echo "<br>Inside M&A";
				//	$dealpage="mandadealinfo.php";
                                        $dealpage="mandadirdealdetails.php";
                                        $headerurl="mandaheader_search.php";
					if($pe_vc_flag==0)
					{
						$addVCFlagqry="";
						$pagetitle="M&A Exits - PE Advisors";
					}
					elseif($pe_vc_flag==1)
					{
						$addVCFlagqry = "and VCFlag=1 ";
						$pagetitle="M&A Exits -  VC Advisors";
					}
					$tdtitle =" Acquirer";
					 $advisor_to_companysql="
					SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MandAId as PEId
					FROM manda AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac
					WHERE peinv.Deleted=0 " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by Cianame";

					$advisor_to_investorsql="
					SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MandaId  as PEId ,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisoracquirer AS adac
					WHERE peinv.Deleted=0 ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by dt";
                        	}
                        	
                        	if($pe_exit_advisorflag==3)
				{
                                     //   echo "<br>Inside SV";
                                         //SV investments
					//$dealpage="dealinfo.php";
                                        $headerurl="tvheader_search.php";
                                        $dealpage="dealdetails.php";
					//echo "<bR>&&&&&".$pe_vc_flag;
					if($pe_vc_flag==3)
					{
						$addVCFlagqry="";
						$pagetitle="SV Advisors";
						$dbtype="SV";
                                          // echo "<bR>$$$".$pe_vc_flag;
					}
					if($pe_vc_flag==4)
					{
						$addVCFlagqry="";
						$pagetitle="CT Advisors";
						$dbtype="CT";
                                          // echo "<bR>$$$".$pe_vc_flag;
					}
					if($pe_vc_flag==5)
					{
						$addVCFlagqry="";
						$pagetitle="IF Advisors";
						$dbtype="IF";
                                          // echo "<bR>$$$".$pe_vc_flag;
					}
					//elseif($pe_vc_flag==1)
					//{
					//	$addVCFlagqry = "and s.VCview=1 and peinv.amount<=20 ";
					//	$pagetitle="VC Advisors";
					//}
				       $tdtitle =" Investors";

					$advisor_to_companysql="
					SELECT  distinct peinv.PEId as PEId,adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac, stage as s
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef 
                                        
                                        AND peinv.PEId
                                        IN (

                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId='$dbtype'
                                        )
                                        order by dates desc";

					$advisor_to_investorsql="
					SELECT distinct peinv.PEId as PEId, peinv.PECompanyId,adac.CIAId AS AcqCIAId,c.Companyname,
					DATE_FORMAT( dates, '%M-%Y' ) AS dt
					FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef 

                                        AND peinv.PEId
                                        IN (

                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId='$dbtype'
                                        )
                                        order by peinv.dates desc";


                                        //echo "<br>********company".$advisor_to_companysql;
                                       // echo "<br>*******Investor".$advisor_to_investorsql;
				}
                                if($pe_exit_advisorflag==4)
				{
                                      // echo "<br>Inside MAMA";
					$dealpage="meracqdetail.php";
					 $headerurl="tvheader_search.php";
                                         $dealpage="dealdetails.php";
					if($pe_vc_flag==1)
					{
						$addVCFlagqry="";
						$pagetitle="M&A Advisors";
					}

					$tdtitle =" Acquirer";
					$advisor_to_companysql="
					SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MAMAId as PEId
					FROM mama AS peinv, pecompanies AS c,  advisor_cias AS cia,
					mama_advisorcompanies AS adac
					WHERE peinv.Deleted=0 " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.MAMAId = peinv.MAMAId and adac.CIAId=$SelCompRef order by DealDate";

					$advisor_to_investorsql="
					SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MAMAId  as PEId ,c.Companyname,
					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
					FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia,
					mama_advisoracquirer AS adac
					WHERE peinv.Deleted=0 ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.MAMAId = peinv.MAMAId and adac.CIAId=$SelCompRef order by DealDate";
				
                        	}

?>



<?php 

$invcompaniessql="(SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					dates,peinv.PEId as PEId
					FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac, stage as s
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef order by dates) 
                   UNION
                   (SELECT  distinct peinv.PEId as PEId,adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					dates
					FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac, stage as s
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef 
                                        
                                        AND peinv.PEId
                                        IN (

                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId='$dbtype'
                                        )
                                        order by dates desc)";


$existcompaniessql= "SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
					DealDate,peinv.MandAId as PEId
					FROM manda AS peinv, pecompanies AS c,  advisor_cias AS cia,
					peinvestments_advisorcompanies AS adac
					WHERE peinv.Deleted=0 " .$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by DealDate desc, Cianame asc";


$invadvisor_to_investorsql="(SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.PEId as PEId,c.Companyname,
					dates
					FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef) 
                              UNION (
					SELECT distinct peinv.PEId as PEId, peinv.PECompanyId,adac.CIAId AS AcqCIAId,c.Companyname,
					dates
					FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
					WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
					AND adac.PEId = peinv.PEId and adac.CIAId=$SelCompRef 

                                        AND peinv.PEId
                                        IN (

                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId='$dbtype'
                                        ))";

        $existadvisor_to_investorsql="  SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MandaId  as PEId ,c.Companyname,DealDate
					FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia,
					peinvestments_advisoracquirer AS adac
					WHERE peinv.Deleted=0 ".
					" AND c.PECompanyId = peinv.PECompanyId
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.MandAId and adac.CIAId=$SelCompRef order by DealDate desc, Companyname asc "

?>


<?php
	$topNav = 'Directory';
	include_once('dirnew_header.php');
?>
</form>
<form name="advisorprofile" id="advisorprofile" method="post" action="exportadvisor.php">
<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
 <?php

  	if($advisorrs=mysql_query($AdvisorSql))
		{
			while($advisorrow=mysql_fetch_array($advisorrs,MYSQL_BOTH))
			{
				$advisorname=$advisorrow["cianame"];
                                 $advisorid=$advisorrow["CIAId"];
                                 $website=$advisorrow["website"];
                                 $advisortype=$advisorrow["AdvisorType"];
                                 $advisortype=($advisortype=="T")?("Transaction Advisor"):(($advisortype=="L")?"Legal Advisor":"");
                                 $address=$advisorrow["address"];
                                 $city  =$advisorrow["city"];
                                 $country=$advisorrow["country"];
                                 $phoneno=$advisorrow["phoneno"];
                                 $contactperson=$advisorrow["contactperson"];
                                 $designation   =$advisorrow["designation"];
                                 $emailid=$advisorrow["email"];
                                 $linkedIn=$advisorrow["linkedin"];
			}
        
	?>
		<input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >
		<input type="hidden" name="hidepeexitflag" value="<?php echo $pe_exit_advisorflag;?>" >
		<input type="hidden" name="hidevcflagValue" value="<?php echo $vcflagValue;?>" >
		<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
        <input type="hidden" name="advname" value="<?php echo rtrim($advisorname);?>" >
		

		
<td>

<div class="result-cnt">

  
    <div class="result-title" style="position: relative;">
   
    	<!--  <ul class="result-select"><?php if($tagsearch!=""){ ?>
          <li><?php// echo $tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li><?php } ?>
           <li class="result-select-close"><a href="pedirview.php?value=<?php echo $vcflagValue;?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"></a></li>        </ul> -->
           <?php 
             if($searchallfield !="" || $industry > 0 || ($followonVC!="--" && $followonVC!="") || ($exited !="--" && $exitedText !='') || $stagevaluetext!="" || ($round!="--" && $round!=null) || 
                                     ($investorType !="--" && $investorType!=null) || $regionId > 0 || ($txtregion !="--" && $txtregion !="") || ($txtregion !="--" && $txtregion !="")
                                     || ($startRangeValue!= "--") && ($endRangeValue != "") || $city1!=""  || $keyword!="" || $companysearch!="" || $sectorsearch!=""
                                     || $advisorsearch_trans!="" || $advisorsearch_legal!="" || $dirsearch!="" || (($firmvaluetext!="") && ($firmvaluetext != "--")) || $countrytxt != "" || $tagsearch != ""){ ?>
                            

                            <ul class="result-select">
                                <?php
                                 $cl_count = count($_POST);
                                 if ($cl_count > 4) {
                             ?>
                                                           <li class="result-select-close" style="border:none"><a href="pedirview.php?value=<?php
                                     echo $vcflagValue;
                             ?>"><img width="7" height="7" border="0" alt="" src="images/icon-close-ul.png"> </a></li>
                                                           <?php
                                 }
    if ($industry > 0 && $industry != null) {
    ?>
                              <li title="Industry">
                                    <?php
        echo $industryvalueflt;
?><a   onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($followonVC != "--" && $followonVC != "") {
?>
                          <li>
                            <?php
        echo $followonVCFundText;
?><a  onclick="resetinput('followonVCFund');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php
    }
    if ($exited != "--" && $exitedText != '') {
?>
                          <li>
                            <?php
        echo $exitedText;
?><a  onclick="resetinput('exitedstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php
    }
    if ($stagevaluetext != "" && $stagevaluetext != null) {
?>
                              <li> 
                                    <?php
        echo $stagevaluetext;
?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($round != "--" && $round != null) {
        $drilldownflag = 0;
?>
                                  <li class="postlink" > 
                                        <?php
        echo $round;
?><a  onclick="resetinput('round');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                    <?php
    }
    if ($investorType != "--" && $investorType != null) {
?>
                              <li> 
                                    <?php
        echo $invtypevalue;
?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($regionId > 0) {
?>
                              <li> 
                                    <?php
        echo $regionvalue;
?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($txtregion != "--" && $txtregion != "") {
?>
                          <li>
                            <?php
        echo $regionText;
?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php
    }
    if (($startRangeValue != "--") && ($endRangeValue != "")) {
?>
                              <li> 
                                    <?php
        echo "(USM)" . $startRangeValue . "-" . $endRangeValueDisplay;
?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($city1 != "") {
        $drilldownflag = 0;
?>
                                  <li > 
                                        <?php
        echo $city1;
?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <!-- -->
                                <?php
    }
    if (trim($sdatevalueCheck1) != '') {
?>
                              <li> 
                                    <?php
        echo $sdatevalueCheck1 . "-" . $edatevalueCheck2;
?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($keyword != "") {
?>
                              <li> 
                                    <?php
        echo $keyword;
?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }

   
    if ($companysearch != "") {
?>
                              <li> 
                                    <?php
        echo $companysearch;
?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($sectorsearch != "") {
?>
                              <li> 
                                    <?php
        echo $sectorsearch;
?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($advisorsearch_trans != "") {
?>
                              <li> 
                                    <?php
        echo $advisorsearch_trans;
?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($firmvaluetext != "--" && $firmvaluetext != null) {
        $drilldownflag = 0;
?>
                              <li> 
                                    <?php
        echo $firmvaluetext;
?><a  onclick="resetinput('firmtype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    
    if ($vcflagValue != 2 && $vcflagValue != 3 && $vcflagValue != 4 && $vcflagValue != 5 && $vcflagValue != 6 && $dealvalue != 103 && $dealvalue != 104 && $dealvalue != 102) {
        if ($countryname != "--" && $countryname != null && ($cityname != '' || $countryNINname != '')) {
            $drilldownflag = 0;
?>
                                      <li> 
                                             
                                            <?php
            echo $countrynametxt . "," . ucwords(strtolower($cityname)) . $countryNINname;
?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                        </li>
                                    <?php
        }
    }
    
    if ($advisorsearch_legal != "") {
?>
                              <li> 
                                    <?php
        echo $advisorsearch_legal;
?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($dirsearch != "") {
?>
                              <li> 
                                    <?php
        echo $dirsearch;
?><a  onclick="resetinput('autocomplete');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php
    }
    if ($searchallfield != "") {
        $drilldownflag = 0;
?>
                              <li> 
                                    <?php
        echo trim($searchallfield);
?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                 <?php
    }
    $_POST['resetfield'] = "";
    foreach ($_POST as $value => $link) {
        if ($link == "" || $link == "--" || $link == " ") {
            unset($_POST[$value]);
        }
    }
    //print_r($_POST);
   
    if ($tagsearch != '') {

                                            $ex_tags_filter = explode(':', $tagsearch);

                                            if (count($ex_tags_filter) > 1) {
                                                $tagsearch = trim($tagsearch);
                                            } else {

                                                $tagsearch = "tag:" . trim($tagsearch);
                                            }
                                            ?>
                                                <li><?php echo $tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a></li>
                                            <?php
                                }
?>
                           </ul>
                           
<?php
}?>
 
             

        <div class="title-links">
                                
            <input class="senddeal" type="button" id="senddeal" value="Send this advisor profile to your colleague" name="senddeal">
            <?php 

            if(($exportToExcel==1))
                 {
                 ?>
                        <span id="exportbtn"></span>

                 <?php
                 }
             ?>
        </div>
            
           <?php //GET PREV NEXT ID
		$prevNextArr = array();
		$prevNextArr = $_SESSION['advisorId'];

		$currentKey = array_search($SelCompRef,$prevNextArr);
		$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
		$nextKey = $currentKey+1;
//         ?>
            <?php if(!$_POST){
                                   // echo $VCFlagValue;
                                   if($VCFlagValue==0)
                                   {
                                     ?>
                                           
                                           <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo count($prevNextArr); ?> Results found</span>
                                           <span class="result-for">for PE Directory</span>
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo count($prevNextArr); ?>">
                                           </h2>             
                             <?php }
                                    else
                                    {?>
                                            <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo count($prevNextArr); ?> Results found</span>
                                            <span class="result-for">for VC Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo count($prevNextArr); ?>">
                                            </h2>
                                 <?php } ?>
                                
                                   <?php }
                                   else 
                                   {
                                   if($VCFlagValue==0)
                                   { ?>
                                            <h2>
                                           <span class="result-no" id="show-total-deal"> <?php echo count($prevNextArr); ?> Results found</span>
                                           <span class="result-for">for PE Directory</span>
                                           <input class="postlink" type="hidden" name="numberofcom" value="<?php echo count($prevNextArr); ?>">
                                           </h2>  
                                                <?php }
                                else
                                   {?>
                                            <h2>
                                            <span class="result-no" id="show-total-deal"> <?php echo count($prevNextArr); ?> Results found</span>
                                            <span class="result-for">for VC Directory</span>
                                            <input class="postlink" type="hidden" name="numberofcom" value="<?php echo count($prevNextArr); ?>">
                                            </h2>
                                 <?php } ?>
                           <?php } ?> 
    </div><br><br><br>
         <br/>             
<div class="list-tab">
        <ul>
                <li><a  class="postlink" href="pedirview.php?value=<?php echo $vcflagValue; ?>" id="icon-grid-view"><i></i> List  View</a></li>
                <li class="active"><a id="icon-detailed-view" class="postlink" href="" ><i></i> Detail  View</a></li> 
        </ul>
</div> 

<div class="lb" id="popup-box">
        <div class="title">Send this to your Colleague</div>
        <form>
            <div class="entry">
                    <label> To</label>
                    <input type="text" name="toaddress" id="toaddress"  />
            </div>
            <div class="entry">
                    <h5>Subject</h5>
                    <p>Checkout this profile- <?php echo rtrim($advisorname);?> - in Venture Intelligence</p>
                    <input type="hidden" name="subject" id="subject" value="Checkout this profile- <?php echo rtrim($advisorname);?> - in Venture Intelligence"  />
            </div>
            <div class="entry">
                    <h5>Message</h5>
                    <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtn" />
                <input type="button" value="Cancel" id="cancelbtn" />
            </div>

        </form>
    </div>
 <div class="view-detailed">
    
    <!--div class="detailed-title-links"><h2><?php echo rtrim($advisorname);?></h2>
    <?php 
    $backlink=$_SERVER["HTTP_REFERER"];
    if ($backlink!='') {?> <a  class="postlink" id="previous" href="<?php echo $backlink; ?>">< Back</a><?php } ?> 
    </div-->
      <div class="detailed-title-links"> <h2><?php echo rtrim($advisorname);?></h2>
		<?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="diradvisor.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>">< Previous</a><?php } ?> 
        <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="diradvisor.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $vcflagValue;?>/<?php echo $dealvalue;?>"> Next > </a>  <?php } ?>
                    </div>  
     <?php  if($advisortype!="" || $website!=""){ ?>
     <div class="profilemain">
 <h2>Advisor Profile</h2>
 <div class="profiletable" style="position:  relative;">
     
<ul>
      <?php 
  if ($advisortype != "") 
  { ?>                                        
        <li><h4>Advisor Type  </h4><p> <?php echo $advisortype; ?></p></li>
  <?php
  }if (trim($address) != "") 
  { ?>
  <li><h4>Address    </h4><p><?php echo $address; ?></p></li>
   <?php
    }
if (trim($city) != "") 
  { ?>
  <li><h4>City    </h4><p><?php echo $city; ?></p></li>
   <?php
    }
if (trim($country) != "") 
  { ?>
  <li><h4>Country    </h4><p><?php echo $country; ?></p></li>
   <?php
    }
if (trim($phoneno) != "") 
  { ?>
  <li><h4>Phone No.    </h4><p><?php echo $phoneno; ?></p></li>
   <?php
    }
if (trim($website) != "") 
  { ?>
  <li><h4>Website    </h4><p><a href=<?php echo $website; ?> target="_blank"><?php echo $website; ?></a></p></li>
   <?php
    }
if (trim($contactperson) != "") 
  { ?>
  <li><h4>Contact Person    </h4><p><?php echo $contactperson; ?></p></li>
   <?php
    }
if (trim($designation) != "") 
  { ?>
  <li><h4>Designation    </h4><p><?php echo $designation; ?></p></li>
   <?php
    }
if (trim($emailid) != "") 
  { ?>
  <li><h4>Email ID    </h4><p><?php echo $emailid; ?></p></li>
   <?php
    }
    ?>

   </ul>
 <!-- LINKED IN START -->
                  
                     <?php 
                    //  if($linkedIn!=''){ 

                    //  $url = $linkedIn;
                    //  $keys = parse_url($url); // parse the url
                    //  $path = explode("/", $keys['path']); // splitting the path
                    //  $companyid = (int)end($path); // get the value of the last element  

                    ?>
                  <!-- <div class="com-col linkedindiv" style="display: none">
                      <div class="linked-com">
                    <div class="linkedin-bg">

                    <script type="text/javascript" > 

                        $(document).ready(function () {
                            $('#lframe,#lframe1').on('load', function () {
                    //            $('#loader').hide();

                            });
                        });

                        function autoResize(id){
                            var newheight;
                            var newwidth;

                            if(document.getElementById){
                                newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
                                newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
                            }

                            document.getElementById(id).height= (newheight) + "px";
                            document.getElementById(id).width= (newwidth) + "px";
                        }
                    </script> -->

                    <!-- <script type="text/javascript" src="//platform.linkedin.com/in.js"> 
                        api_key:65623uxbgn8l
                        authorize:true
                        onLoad: onLinkedInLoad
                        </script>
                        <script type="text/javascript" > 
                        var idvalue=<?php echo $companyid; ?>;

                        function onLinkedInLoad() {
                           $("#viewlinkedin_loginbtn").hide(); 
                           var profileDiv = document.getElementById("sample");

                                    if(idvalue)
                                    {                          
                                        $("#lframe").css({"height": "220px"});
                                        $("#lframe1").css({"height": "300px"});

                                        var inHTML='loadlinkedin.php?data_id='+idvalue;
                                        var inHTML2='linkedprofiles.php?data_id='+idvalue;
                                        $('#lframe').attr('src',inHTML);
                                        $('#lframe1').attr('src',inHTML2);
                                        $('.linkedindiv').show();
                                    }
                                    else
                                    {
                                         $('#lframe').hide();
                                         $('#lframe1').hide();
                                         $('#loader').hide();
                                         $('.linkedindiv').hide();
                                    }

                          }

                    </script>

                    <div  id="sample" style="padding:10px 10px 0 0;">

                        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
                    </div>

                    <input type="hidden" name="dataId" id="dataId" >

                 </div>
                   <div class="fl" style="padding:10px 10px 0 0;">
                   <iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div> 

                    </div>
                      </div>


                     <?php //}
    //                  else{

    //   $linkedinSearchDomain=  str_replace("http://www.", "", $website); 
    //   $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
    //     if(strrpos($linkedinSearchDomain, "/")!="")
    //     {
    //        $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
    //     }
    // if($linkedinSearchDomain!=""){ ?>
                  <div class="com-col linkedindiv"  style="display: none">
                      <div class="linked-com">
  <div class="linkedin-bg">

     <script type="text/javascript" > 
            
            $(document).ready(function () {
        $('#lframe,#lframe1').on('load', function () {
//            $('#loader').hide();
            
        });
            });
            
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
 </script> -->


   
        <!-- <script type="text/javascript" src="//platform.linkedin.com/in.js">
        api_key:65623uxbgn8l
        authorize:true
        onLoad: LinkedAuth
        </script>
        <script type="text/javascript" > 
        var idvalue;
         //document.getElementById("sa").textContent='asdasdasd'; 
         
        function LinkedAuth() {
            if(IN.User.isAuthorized()==1){
               $("#viewlinkedin_loginbtn").hide();      
            }
            else {
                 $("#viewlinkedin_loginbtn").show();   
            }
            
            IN.Event.on(IN, "auth", onLinkedInLoad);

          } 
        
        function onLinkedInLoad() {
           $("#viewlinkedin_loginbtn").hide(); 
           var profileDiv = document.getElementById("sample");

               //var url = "/companies?email-domain=<?php echo $linkedinSearchDomain ?>";
                               var url ="/company-search:(companies:(id,website-url))?keywords=<?php echo $advisorname ?>";

            
                IN.API.Raw(url).result(function(response) {   
                   
                    //console.log(response['companies']['values'].length);                  
                    //console.log(response['companies']['values'][0]['id']);
                    //console.log(response['companies']['values'][0]['websiteUrl']);
                    var searchlength = response['companies']['values'].length;
                    
                    var domain='';
                    var website = '<?php echo $linkedinSearchDomain?>';
                   
                    for(var i=0; i<searchlength; i++){
                        
                        if(response['companies']['values'][i]['websiteUrl']){
                            domain = response['companies']['values'][i]['websiteUrl'].replace('www.','');
                            domain = domain.replace('http://','');
                            domain = domain.replace('/','');
                            if(domain == website){
                                idvalue = response['companies']['values'][i]['id'];
                                break;
                            }
                        }
                    }
                 
                    
                    if(idvalue)
                        {                          
                    $("#lframe").css({"height": "220px"});
                    $("#lframe1").css({"height": "300px"});
                   
                   var inHTML='loadlinkedin.php?data_id='+idvalue;
                    var inHTML2='linkedprofiles.php?data_id='+idvalue;
                    $('#lframe').attr('src',inHTML);
                    $('#lframe1').attr('src',inHTML2);
                                         $('.linkedindiv').show();
                    }
                    else
                        {
                             $('#lframe').hide();
                             $('#lframe1').hide();
                             $('#loader').hide();
                                         $('.linkedindiv').hide();
                        }
                        
                    //  profileDiv.innerHtml=inHTML;
                    //document.getElementById('sa').innerHTML='<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                }).error( function(error){
                   $('#lframe').hide();
                   $('#lframe1').hide();
                                   $('#loader').hide(); 
                                    $('.linkedindiv').hide();
                               });
          }


        </script> -->
<!-- 
    <div  id="sample" style="padding:10px 10px 0 0;">
        
        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
    </div>

    <input type="hidden" name="dataId" id="dataId" >
   
 </div>
                   <div class="fl" style="padding:10px 10px 0 0;">
                   <iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div> 
                    </div>
                      </div> -->
                 <?php //} 
                   
  //}
    ?>
  
                  <!-- LINKED IN END -->
 </div>
     </div> <?php } ?>
    <div class="postContainer postContent masonry-container">
        <?php
        if ($getcompanyrs = mysql_query($invcompaniessql))
        {
             $comp_cnt = mysql_num_rows($getcompanyrs);
        }
        if($comp_cnt>0)
        { 
        ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to company(Investment)</h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
        <tr>
           <td><p>
                    <?php
				if ($getcompanyrs = mysql_query("select * from ( $invcompaniessql ) a order by dates desc, Companyname asc"))
                                {
                                        $AddOtherAtLast="";
                                        $AddUnknowUndisclosedAtLast="";
                                        While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                {
                                        //$AddOtherAtLast="";
                                        $companyname=trim($myInvrow["Companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($pe_exit_advisorflag==4)
                                            {
                                              ?>
                                            <?php echo $myInvrow["Companyname"]; ?>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                            <a href='companydetails.php?value=<?php echo $myInvrow["PECompanyId"].'/'.$vcflagValue.'/'.$dealvalue.'/Directory';?>' title="Company Details"><?php echo $myInvrow["Companyname"]; ?></a>
                                            <?php
                                            }
                                            ?>
                                           <?php if($usrRgs[PEInv] !=0){?>
                                            ( <a href="dealdetails.php?value=<?php echo $myInvrow["PEId"].'/'.$vcflagValue.'/'.$dealvalue.'/Directory';?>" title="Deal Details">
                                                            <?php echo date('M-Y',strtotime($myInvrow["dates"]));?> </a>)
                                                            <BR/>
                                                            <?php }else{?>
                                                                ( <a  title="Deal Details">
                                                            <?php echo date('M-Y',strtotime($myInvrow["dates"]));?> </a>)
                                                            <BR/>
                                                                <?php }?>
                                        <?php
                                        }
                                        else
                                                {
                                                        $AddOtherAtLast=$myInvrow["Companyname"];
                                                }
                                }
                                }
                        ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
               </p>
                </td>
            </tr>
       </tbody>
       </table>
        </div>
        <?php
        }
       if ($getcompanyrs = mysql_query($existcompaniessql))
       {
             $exist_cnt = mysql_num_rows($getcompanyrs);
       }
        if($exist_cnt>0)
        { 
        ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to company (Exit)</h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
        <tr>
           <td><p>
                    <?php
				if ($getcompanyrs = mysql_query($existcompaniessql))
                                {
                                        $AddOtherAtLast="";
                                        $AddUnknowUndisclosedAtLast="";
                                        While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                {
                                        //$AddOtherAtLast="";
                                        $companyname=trim($myInvrow["Companyname"]);
                                        $companyname=strtolower($companyname);

                                        $invResult=substr_count($companyname,$searchString);
                                        $invResult1=substr_count($companyname,$searchString1);
                                        $invResult2=substr_count($companyname,$searchString2);

                                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                        {
                                            if($pe_exit_advisorflag==4)
                                            {
                                              ?>
                                            <?php echo $myInvrow["Companyname"]; ?>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                            <a href='companydetails.php?value=<?php echo $myInvrow["PECompanyId"].'/'.$vcflagValue.'/'.$dealvalue.'/Directory';?>' title="Company Details"><?php echo $myInvrow["Companyname"]; ?></a>
                                            <?php
                                            }
                                            ?>
                                            ( <a href="mandadealdetails.php?value=<?php echo $myInvrow["PEId"].'/'.$vcflagValue.'/'.$dealvalue.'/Directory';?>" title="Deal Details">
                                                            <?php echo date('M-Y',strtotime($myInvrow["DealDate"]));?>  </a>)
                                                            <BR/>
                                        <?php
                                        }
                                        else
                                                {
                                                        $AddOtherAtLast=$myInvrow["Companyname"];
                                                }
                                }
                                }
                        ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
               </p>
                </td>
            </tr>
       </tbody>
       </table>
        </div>
        <?php
        }
        if ($getcompanyrs = mysql_query($existadvisor_to_investorsql))
        {
             $existadvisor_cnt = mysql_num_rows($getcompanyrs);
        }
        if($existadvisor_cnt>0)
        { 
        ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to <?php echo "Acquirer";?></h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
            <tr><td><p>
                    <?php
				if ($getcompanyrs = mysql_query($existadvisor_to_investorsql))
                                    {
                                            $AddOtherAtLast="";
                                            $AddUnknowUndisclosedAtLast="";
                                            While($myInvestrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                            {
                                            //$AddOtherAtLast="";
                                            $companyname1=trim($myInvestrow["Companyname"]);
                                            $companyname1=strtolower($companyname);

                                            $Result=substr_count($companyname1,$searchString);
                                            $Result1=substr_count($companyname1,$searchString1);
                                            $Result2=substr_count($companyname1,$searchString2);

                                            if(($Result==0) && ($Result1==0) && ($Result2==0))
                                            {
                                           
                                        ?>        
                                            <a href='companydetails.php?value=<?php echo $myInvestrow["PECompanyId"].'/'.$vcflagValue.'/'.$dealvalue.'/Directory';?>' title="Company Details"><?php echo $myInvestrow["Companyname"]; ?></a>
                                            ( <a href="mandadealdetails.php?value=<?php echo $myInvestrow["PEId"].'/'.$vcflagValue.'/'.$dealvalue.'/Directory';?>" title="Deal Details">
                                            <?php echo date('M-Y',strtotime($myInvestrow["DealDate"]));?></a>)
                                                            <BR/>
                                        <?php
                                        }
                                        else
                                                {
                                                      $AddOtherAtLast=$myInvrow["Companyname"];
                                                }
                                }
                                }
                        ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                    </p>
                </td>
            </tr>
            </tbody>
            </table>
        </div>
        <?php
        }
       if ($getcompanyrs = mysql_query($invadvisor_to_investorsql))
       {
             $invadvisor_cnt = mysql_num_rows($getcompanyrs);
       }
        if($invadvisor_cnt>0)
        {
        ?>
        <div  class="work-masonry-thumb col-2" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Advisor to <?php echo "Investor"?></h2>
       <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
       <tbody>
            <tr><td><p>
                    <?php
				if ($getcompanyrs = mysql_query("select * from ( $invadvisor_to_investorsql ) a order by dates desc, Companyname asc"))
                                    {
                                            $AddOtherAtLast="";
                                            $AddUnknowUndisclosedAtLast="";
                                            While($myInvestrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                            {
                                            //$AddOtherAtLast="";
                                            $companyname1=trim($myInvestrow["Companyname"]);
                                            $companyname1=strtolower($companyname);

                                            $Result=substr_count($companyname1,$searchString);
                                            $Result1=substr_count($companyname1,$searchString1);
                                            $Result2=substr_count($companyname1,$searchString2);

                                            if(($Result==0) && ($Result1==0) && ($Result2==0))
                                            {
                                           
                                        ?>        
                                            <a href='companydetails.php?value=<?php echo $myInvestrow["PECompanyId"].'/'.$vcflagValue.'/'.$dealvalue.'/Directory';?>' title="Company Details"><?php echo $myInvestrow["Companyname"]; ?></a>
                                            ( <a href="dealdetails.php?value=<?php echo $myInvestrow["PEId"].'/'.$vcflagValue.'/'.$dealvalue.'/Directory';?>" title="Deal Details">
                                            <?php echo date('M-Y',strtotime($myInvestrow["dates"]));?> </a>)
                                                            <BR/>
                                        <?php
                                        }
                                        else
                                                {
                                                      $AddOtherAtLast=$myInvrow["Companyname"];
                                                }
                                }
                                }
                        ?>
                         
					<?php echo $AddUnknowUndisclosedAtLast."<BR/>"; ?>
					<?php echo $AddOtherAtLast; ?>
                    </p>
                </td>
            </tr>
            </tbody>
            </table>
        </div>
        <?php
        }
        ?>
    </div>
    
            <?php
					if(($exportToExcel==1) || ($exportToExcel1==1))
					{
					?>
							<span style="float:right" class="one">
                                                            <input type="submit" class="export"  value="Export" name="showdeal">
							</span>
                                                         <script type="text/javascript">
                                                                $('#exportbtn').html(' <input type="submit" class="export"  value="Export" id="showdeal" name="showdeal">');
                                                        </script>

					<?php
					}
					?>
 </div>
</td>
        




        <?php } ?>
</tr>

</table>
       
    </div>

 
<div class=""></div>

</form>
<form name="pesearch" action="pedirview.php?value=<?php echo $vcflagValue; ?>" method="post" id="pesearchtag">  
<?php 
    $stagecount=count($_POST['stage']);
    $firmtypecount=count($_POST['firmtype']);
?>
	<input type="hidden" name="tagsearch" value="<?php echo $tagsearch; ?>"/>
	<input type="hidden" name="tagsearch_auto" value="<?php echo $tagsearch; ?>"/>
	<input type="hidden" name="tagandor" value="<?php echo $_POST['tagandor']; ?>"/>
	<input type="hidden" name="showdeals" value="<?php echo $showdeals; ?>"/>
	<input type="hidden" name="numberofcom" value="<?php echo $numberofcom; ?>"/>
	
            
            <input type="hidden" name="industry" value="<?php echo $industry;?>" >
            <input type="hidden" name="keywordsearch" value="<?php echo $keyword;?>" >
            <input type="hidden" name="investorauto" value="<?php echo $keyword;?>" >
            <input type="hidden" name="companysearch" value="<?php echo $companysearch;?>" >
            <input type="hidden" name="companyauto" value="<?php echo $companysearch;?>" >
            <input type="hidden" name="sectorsearch" value="<?php echo $sectorsearch;?>" >
            <input type="hidden" name="sectorauto" value="<?php echo $sectorsearch;?>" >
            <input type="hidden" name="advisorsearch_legal" value="<?php echo $advisorsearch_legal;?>" >
            <input type="hidden" name="advisorsearch_trans" value="<?php echo $advisorsearch_trans;?>" >
            <input type="hidden" name="stageidvalue" value="<?php echo $stageidvalue;?>" >
            <input type="hidden" name="round" value="<?php echo $round; ?>">
            <input type="hidden" name="invrangestart" value="<?php echo $startRangeValue;?>" >
            <input type="hidden" name="invrangeend" value="<?php echo $endRangeValue;?>" >
            <input type="hidden" name="investorType" value="<?php echo $investorType;?>" >
            <input type="hidden" name="vcflagValue" value="<?php echo $vcflagValue;?>" >
            <input type="hidden" name="invType" value="<?php echo $investorType;?>" >
            <input type="hidden" name="searchallfield" value="<?php echo $searchallfield;?>" >
            <?php 
                if(count($_POST['stage'])>0){
                    foreach($_POST['stage'] as $val) {
            ?>
                    <input type="text" name="stage[]" value="<?php echo $val;?>" /> 
             <?php
             }
            }?>
            <?php 
                if(count($_POST['firmtype'])>0){
                    foreach($_POST['firmtype'] as $val) {
            ?>
                    <input type="text" name="firmtype[]" value="<?php echo $val;?>" /> 
             <?php
             }
            }?>
            
            <input type="hidden" name="citysearch" value="<?php echo $city1;?>">

</form>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>
</body>
</html>

<?php
	function returnMonthname($mth)
		{
			if($mth==1)
				return "Jan";
			elseif($mth==2)
				return "Feb";
			elseif($mth==3)
				return "Mar";
			elseif($mth==4)
				return "Apr";
			elseif($mth==5)
				return "May";
			elseif($mth==6)
				return "Jun";
			elseif($mth==7)
				return "Jul";
			elseif($mth==8)
				return "Aug";
			elseif($mth==9)
				return "Sep";
			elseif($mth==10)
				return "Oct";
			elseif($mth==11)
				return "Nov";
			elseif($mth==12)
				return "Dec";
	}
function writeSql_for_no_records($sqlqry,$mailid)
 {
 $write_filename="pe_query_no_records.txt";
 //echo "<Br>***".$sqlqry;
    $schema_insert="";
    //TRYING TO WRIRE IN EXCEL
    //define separator (defines columns in excel & tabs in word)
            $sep = "\t"; //tabbed character
            $cr = "\n"; //new line

            //start of printing column names as names of MySQL fields

                   print("\n");
                    print("\n");
            //end of printing column names
                           $schema_insert .=$cr;
                           $schema_insert .=$mailid.$sep;
                           $schema_insert .=$sqlqry.$sep;
                           $schema_insert = str_replace($sep."$", "", $schema_insert);
               $schema_insert .= ""."\n";

                           if (file_exists($write_filename))
                           {
                                   //echo "<br>break 1--" .$file;
                                    $fp = fopen($write_filename,"a+"); // $fp is now the file pointer to file
                                            if($fp)
                                            {//echo "<Br>-- ".$schema_insert;
                                                   fwrite($fp,$schema_insert);    //    Write information to the file
                                                     fclose($fp);  //    Close the file
                                                   // echo "File saved successfully";
                                            }
                                            else
                                                   {
                                                   echo "Error saving file!"; }
                           }

    print "\n";

 }
 function highlightWords($text, $words)
 {

         /*** loop of the array of words ***/
         foreach ($words as $worde)
         {

                 /*** quote the text for regex ***/
                 $word = preg_quote($worde);
                 /*** highlight the words ***/
                 $text = preg_replace("/\b($worde)\b/i", '<span class="highlight_word">\1</span>', $text);
         }
         /*** return the text ***/
         return $text;
 }

function return_insert_get_RegionIdName($regionidd)
{
        $dbregionlink = new dbInvestments();
        $getRegionIdSql = "select Region from region where RegionId=$regionidd";

        if ($rsgetInvestorId = mysql_query($getRegionIdSql))
        {
                $regioncnt=mysql_num_rows($rsgetInvestorId);
                //echo "<br>Investor count-- " .$investor_cnt;

                if($regioncnt==1)
                {
                        While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
                        {
                                $regionIdname = $myrow[0];
                                //echo "<br>Insert return investor id--" .$invId;
                                return $regionIdname;
                        }
                }
        }
        $dbregionlink.close();
}
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
?>
<script type="text/javascript" >
        $("a.postlink").click(function(){

            hrefval= $(this).attr("href");

            $("#pesearch").attr("action", hrefval);
            $("#pesearch").submit();
            $("#pesearchtag").submit();
            return false;

        });
        
        
                
        $("#panel").animate({width: 'toggle'}, 200); 
        $(".btn-slide").toggleClass("active"); 

        if ($('.left-td-bg').css("min-width") == '264px') {
        $('.left-td-bg').css("min-width", '36px');
        $('.acc_main').css("width", '35px');
        }
        else {
        $('.left-td-bg').css("min-width", '264px');
        $('.acc_main').css("width", '264px');
        } 

        $('.export').click(function(){ 
               jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
               return false;
           });

        $('#senddeal').click(function(){ 
            jQuery('#maskscreen').fadeIn(1000);
            jQuery('#popup-box').fadeIn();   
            return false;
        });
        $('#cancelbtn').click(function(){ 

            jQuery('#popup-box').fadeOut();   
             jQuery('#maskscreen').fadeOut(1000);
            return false;
        });

        function validateEmail(field) {
            var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return (regex.test(field)) ? true : false;
        }
        function checkEmail() {

            var email = $("#toaddress").val();
                if (email != '') {
                    var result = email.split(",");
                    for (var i = 0; i < result.length; i++) {
                        if (result[i] != '') {
                            if (!validateEmail(result[i])) {

                                alert('Please check, `' + result[i] + '` email addresses not valid!');
                                email.focus();
                                return false;
                            }
                        }
                    }
            }
            else
            {
                alert('Please enter email address');
                email.focus();
                return false;
            }
            return true;
        }   
        function initExport(){
                $.ajax({
                    url: 'ajxCheckDownload.php',
                    dataType: 'json',
                    success: function(data){
                        var downloaded = data['recDownloaded'];
                        var exportLimit = data.exportLimit;
                        var currentRec = 1;

                        //alert(currentRec + downloaded);
                        var remLimit = exportLimit-downloaded;

                        if (currentRec <= remLimit){

                            $("#advisorprofile").submit();
                            jQuery('#preloading').fadeOut();
                        }else{
                            jQuery('#preloading').fadeOut();
                            //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                            alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                        }
                    },
                    error:function(){
                        jQuery('#preloading').fadeOut();
                        alert("There was some problem exporting...");
                    }

                });
        }
        $('#mailbtn').click(function(){ 
                        
            if(checkEmail())
            {


            $.ajax({
                    url: 'ajaxsendmail.php',
                     type: "POST",
                    data: { to : $("#toaddress").val(), subject : $("#subject").val(), message : $("#message").val() , userMail : $("#useremail").val() },
                    success: function(data){
                            if(data=="1"){
                                 alert("Mail Sent Successfully");
                                jQuery('#popup-box').fadeOut();   
                                jQuery('#maskscreen').fadeOut(1000);

                        }else{
                            jQuery('#popup-box').fadeOut();   
                            jQuery('#maskscreen').fadeOut(1000);
                            alert("Try Again");
                        }
                    },
                    error:function(){
                        jQuery('#preloading').fadeOut();
                        alert("There was some problem sending mail...");
                    }

                });
                }

            }); 
             
        $(document).on('click','#agreebtn',function(){
            $('#popup-box-copyrights').fadeOut();   
            $('#maskscreen').fadeOut(1000);
            $('#preloading').fadeIn();   
            initExport();
            return false; 
        });
             
        $(document).on('click','#expcancelbtn',function(){

            jQuery('#popup-box-copyrights').fadeOut();   
            jQuery('#maskscreen').fadeOut(1000);
            return false;
        });   
        function resetinput(fieldname)
                {
                 $("#resetfield").val(fieldname);
                 $("#pesearch").submit();
                 /*$("#pesearchtag").submit();*/
                 return false;
                }
</script>
