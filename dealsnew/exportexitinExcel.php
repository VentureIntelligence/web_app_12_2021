<?php include_once ("../globalconfig.php"); ?>
<?php
ini_set('memory_limit', '2048M');
ini_set("max_execution_time", 10000);

?>
<?php

//session_save_path("/tmp");
//session_start();
require ("../dbconnectvi.php");
$Db = new dbInvestments();

function updateDownload($res){
    //Added By JFR-KUTUNG - Download Limit
    $recCount = mysql_num_rows($res);
    $dlogUserEmail =$_SESSION['UserEmail'];
    $today = date('Y-m-d');
    //print_r($_SESSION);
    $username=$_SESSION['UserNames'];
    $filtername = $_POST['exitfilter_name'];
    $filterType =$_POST['exitfilter_type'];
    $companyName=$_POST['exitcompany_name'];
    if($filtername == '')
    {
        $filtername = 'anonymous';  
    }
    //Check Existing Entry
    $sqlSelCount = "SELECT sum(`current_downloaded`) as `recDownloaded` FROM `advance_export_filter_log` WHERE `emailId` = '".$dlogUserEmail."'  AND ( `downloadDate` = CURRENT_DATE )";
    $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
    $rowSelCount = mysql_num_rows($sqlSelResult);
    $rowSel = mysql_fetch_object($sqlSelResult);
    $downloads = $rowSel->recDownloaded;

         $upDownloads = $recCount + $downloads;
    
        $sqlIns = "INSERT INTO `advance_export_filter_log` (`id`, `name`, `filter_name`, `filter_type`,`company_name`,`emailId`,`downloadDate`,`recDownloaded`,`current_downloaded`) VALUES (default,'".$username."','".$filtername."','".$filterType."','".$companyName."','" . $dlogUserEmail . "','" . $today . "','" . $upDownloads . "','".$recCount."')";
       //echo $sqlIns;exit();
        mysql_query($sqlIns) or die(mysql_error());
    
}

$tsjtitle = "© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
$tranchedisplay = "Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE. Target Company in [] indicated a debt investment. Not included in aggregate data.";

//include('onlineaccount.php');
$displayMessage="";
$mailmessage="";

//global $LoginAccess;
//	global $LoginMessage;
$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

$companyIdDel=1718772497;
$companyIdSGR=390958295;
$companyIdVA=38248720;
 $companyIdGlobal=730002984;
$addDelind="";

$submitemail=$_POST['txthideemail'];
//VCFLAG VALUE

$searchtitle=$_POST['txttitle'];
$hide_pms=$_POST['txthide_pms'];
//variable that differentiates, PE/VC/RealEstate
$hidesearchon=$_POST['txtsearchon'];

$industry=$_POST['txthideindustryid'];
$hideindustrytext=$_POST['txthideindustry'];

$InTypes=$_POST['txthidetype'];

$dealtypetext=$_POST['txthidedealtype'];
$dealtype=$_POST['txthidedealtypeid'];
$invtypevalue=$_POST['txthideinvtype'];
$invType=$_POST['txthideinvtypeid'];
//echo $invType;exit();
$investor_head=$_POST['invhead'];
$exitstatusvalue=$_POST['txthideexitstatusvalue'];
//echo $exitstatusvalue;exit(); 
$hidedateStartValue=$_POST['txthidedateStartValue'];
$hidedateEndValue=$_POST['txthidedateEndValue'];
$dateValue=$_POST['txthidedate'];
$tagsearch=$_POST['tagsearchval'];
// echo $_POST['exitQuery'];exit();
$hidetxtfrm=$_POST['txthideReturnMultipleFrm'];
$hidetxtto=$_POST['txthideReturnMultipleTo'];
$keyword=$_POST['txthideinvestor'];
//echo $_POST['txthideinvestor'];exit();
$investorString=$_POST['txthideInvestorString'];
$txthidepe=$_POST['txthidepe'];
$yearafter=$_POST['yearafter'];
$yearbefore=$_POST['yearbefore'];
$subsector=$_POST['txthidesubsectorsearch'];
if(($investorString!=="+") && ($investorString!==""))
{	$splitStringInv=explode("+", $investorString);
        $splitString1Inv=$splitStringInv[0];
        $splitString2Inv=$splitStringInv[1];
        if($splitString2Inv!="")
                $keyword=$splitString1Inv. " " .$splitString2Inv;
        else
                $keyword=$splitString1Inv;
}


$companysearch=$_POST['txthidecompany'];
$companyString=$_POST['txthideCompanyString'];
if(($companyString!=="+") && ($companyString!==""))
{	$splitStringComp=explode("+", $companyString);
        $splitString1Comp=$splitStringComp[0];
        $splitString2Comp=$splitStringComp[1];
        if($splitString2Comp!="")
                $companysearch=$splitString1Comp. " " .$splitString2Comp;
        else
                $companysearch=$splitString1Comp;
}
//$sectorsearch=$_POST['txthidesectorsearch'];
if($_POST['txthidesectorsearch']!=''){
    $sectorsearch=$_POST['txthidesectorsearch'];
 }else if($_POST['txthidesectorsearchval'] !=''){
     $sectorsearch=$_POST['txthidesectorsearchval'];
 }
$sectorsearch =stripslashes(ereg_replace("_"," ",$sectorsearch));
$acquirersearch=$_POST['txthideacquirer'];
$advisorsearch_legal=$_POST['txthideadvisor_legal'];
$advisorsearch_legal =ereg_replace("_"," ",$advisorsearch_legal);
$advisorsearch_trans=$_POST['txthideadvisor_trans'];
$advisorsearch_trans =ereg_replace("_"," ",$advisorsearch_trans);
$searchallfield=$_POST['txthidesearchallfield'];
$searchallfield =ereg_replace("-"," ",$searchallfield);
$searchallfield =ereg_replace("_"," ",$searchallfield);

//$addhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=0 ";
// $addhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=".$hide_pms;

$submitemail=$_POST['txthideemail'];

$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

$GetCompId="select dm.DCompId,dc.DCompId from dealcompanies as dc,dealmembers as dm
                                        where dm.EmailId='$submitemail' and dc.DCompId=dm.DCompId";
if($trialrs=mysql_query($GetCompId))
{
        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
        {
                $compId=$trialrow["DCompId"];

        }
}
if($searchtitle==0)
{
    if($compId==$companyIdDel)
    {
      $addDelind = " and (pec.industry=9 or pec.industry=24)";
    }
    if($compId==$companyIdSGR)
    {
      $addDelind = " and (pec.industry=3 or pec.industry=24)";
    }
    if($compId==$companyIdVA)
    {
      $addDelind = " and (pec.industry=1 or pec.industry=3)";
    }
     if($compId==$companyIdGlobal)
    {
      $addDelind = " and (pec.industry=24)";
    }
}
else{
    if($compId==$companyIdGlobal)
    {
      $addDelind = " and (pec.industry=24)";
    }
}
if($searchtitle==0)
{
        $addVCFlagqry = "" ;
        $searchTitle = "List of PE Exits - M&A ";
}
elseif($searchtitle==1)
{
        $addVCFlagqry = " and VCFlag=1 ";
        $searchTitle = "List of VC Exits - M&A ";
}

if($hide_pms==0)
{ 
    $var_hideforexit=0;
    $samplexls="../xls/sample-exits-via-m&a.xls";
}
elseif($hide_pms==1)
{ 
    $var_hideforexit=1;
    $searchTitle = "List of Public Market Sales - Exits";
    $samplexls="../xls/sample-exits-via-m&a(publicmarketsales).xls";
}
elseif($hide_pms==2)
{   $var_hideforexit='0,1';
    $searchTitle = "List of M&A and Public Market Sales - Exits";
    $samplexls="../xls/sample-exits-via-m&a(publicmarketsales).xls";
}

// $addhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=".$var_hideforexit;
$addhide_pms_qry ="  and dt.hide_for_exit in (".$var_hideforexit.")";
$hideWhere = '';
if($_SESSION['PE_industries']!=''){

    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
}


if($_POST['exitquery'] != "")
        {
            $companysql = $_POST['exitquery'] ;
           // echo $_POST['exitQuery'];exit();
        }
        elseif($keyword == "")
                {
                    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                        $hideWhere = " and pe.MandAId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";
            
                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){
            
                         $hideWhere = " and pe.MandAId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";
            
                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){
            
                       $hideWhere = " and pe.MandAId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";
            
                    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){
            
                         $hideWhere = " and pe.MandAId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";
            
                    }else{
                         $hideWhere = " ";
                    }
            
                    $companysql = "SELECT Distinct pe.mandaid,
                    pe.mandaid,
                    pe.pecompanyid,
                    pec.industry,
                    pe.dealtypeid,
                    pe.acquirerid,
                    mandainv.investorid,
                    pec.companyname,
                    i.industry,
                    sector_business,
                    dt.dealtype,
                    -- Date_format(dealdate, '%M-%Y') AS DealDate,
                    dealdate,
                    pe.dealamount,
                    pec.website,
                    moreinfor,
                    hideamount,
                    hidemoreinfor,
                    pe.investmentdeals,
                    pe.investmentdeals,
                    link,
                    estimatedirr,
                    moreinforeturns,
                    it.investortypename,
                    valuation,
                    finlink,
                    company_valuation,
                    revenue_multiple,
                    ebitda_multiple,
                    pat_multiple,
                    exitstatus,
                    revenue,
                    ebitda,
                    pat,
                    price_to_book,
                    book_value_per_share,
                    price_per_share,
                    type,
                    pec.yearfounded,pec.CINNo FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,
                    manda_investors as mandainv ,peinvestors as inv ,investortype AS it where";
                    $whereind="";
                    $wheredates="";
                    $wheredealtype=""; 
                    $whereReturnMultiple="";
                        if ($industry != '' && $industry != '--' && $industry!= null) {
                        $inSql = '';
                        $industry1 = explode(',',$industry);
                        foreach($industry1 as $industrys)
                        {
                            if($industrys != '--'){
                                $inSql .= " pec.industry= '".$industrys."' or ";
                            }
                        }
                        $inSql = trim($inSql,' or ');
                        if($inSql !=''){
                            $whereind=  ' ( '.$inSql.' ) ';
                            //$whereRound="pe.round LIKE '".$round."'";
                        }
                    }
                    if ($dealtype != '' && $dealtype != '--') {
                        $dealSql = '';
                        $dealtype1 = explode(',',$dealtype);
                        foreach($dealtype1 as $dealtypes)
                        {
                            if($dealtype != '--'){
                                $dealSql .= " pe.DealTypeId= '".$dealtypes."' or ";
                            }
                        }
                        $dealSql = trim($dealSql,' or ');
                        if($dealSql !=''){
                            $wheredealtype=  ' ( '.$dealSql.' ) ';
                            //$whereRound="pe.round LIKE '".$round."'";
                        }
                        $addhide_pms_qry=" and dt.hide_for_exit in (0,1)"; 
                    }
                    if ($invType!= "--" && $invType!= "")
                           { 
                            $invType=str_replace(",","','",$invType);
                            $invType="'".$invType."'";   
                            $whereInvType = " pe.InvestorType IN (".$invType.")";
                        $addhide_pms_qry=" and dt.hide_for_exit in (0,1)"; 
                   }
                    if ($investor_head != "--" && $investor_head != '') {
                               $whereInvhead = "inv.InvestorId=mandainv.InvestorId and inv.countryid = '" . $investor_head . "'";
                        } 
            
                    if ($InTypes!= "" && $InTypes!='--')
                    {
                        $InTypes=str_replace(",","','",$InTypes);
                            $InTypes="'".$InTypes."'";
                            $whereType = " pe.type IN (".$InTypes.")";
                    }
            
                    if($exitstatusvalue!="--" && $exitstatusvalue!='')
                    {    $exitstatusvalue=str_replace(",","','",$exitstatusvalue);
                        $exitstatusvalue="'".$exitstatusvalue."'";
                        $whereexitstatus=" pe.ExitStatus IN(".$exitstatusvalue.")"; 
                    }
                      if(trim($hidetxtfrm=="") && trim($hidetxtto>0))
                     {
                       $qryReturnMultiple="Return Multiple - ";
                       $whereReturnMultiple=" mandainv.MultipleReturn < ".$hidetxtto;
                     }
                     elseif(trim($hidetxtfrm >0) && trim($hidetxtto==""))
                     {
                       $qryReturnMultiple="Return Multiple - ";
                       $whereReturnMultiple=" mandainv.MultipleReturn > ".$hidetxtfrm;
                     }
                     elseif(($hidetxtfrm>0) &&($hidetxtto > 0))
                     {
                                   $qryReturnMultiple="Return Multiple - ";
                                   $whereReturnMultiple=" mandainv.MultipleReturn > " .$hidetxtfrm . " and  mandainv.MultipleReturn <".$hidetxtto;
                            }
            
                    if($dateValue!="---to---")
                            $wheredates= " DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
            
            
                    if ($yearafter != '' && $yearbefore == '') {
                                                $whereyearaftersql = " pec.yearfounded >= $yearafter";
                                            }
            
                                            if ($yearbefore != '' && $yearafter == '') {
                                                $whereyearbeforesql = " pec.yearfounded <= $yearbefore";
                                            }
            
                                            if ($yearbefore != '' && $yearafter != '') {
                                                $whereyearfoundedesql = " pec.yearfounded >= $yearafter and pec.yearfounded <= $yearbefore";
                                            }
            
                    if ($whereind != "")
                                    $companysql=$companysql . $whereind ." and ";
                    if (($wheredealtype != ""))
                            $companysql=$companysql . $wheredealtype . " and " ;
                    if (($whereInvType != "") )
                            $companysql=$companysql .$whereInvType . " and ";
            
                    if (($whereType != "") )
            
                            $companysql=$companysql .$whereType . " and ";
            
                     if($whereexitstatus!="")
                      {     $companysql=$companysql .$whereexitstatus . " and ";     }
                    if($wheredates !== "")
                            $companysql = $companysql . $wheredates ." and ";
                    if($whereReturnMultiple!= "")
                            {
                             $companysql = $companysql . $whereReturnMultiple ." and ";
                            }
                            if ($whereyearaftersql != "") {
                                                $companysql = $companysql . $whereyearaftersql . " and ";
                                            }
                                            if ($whereyearbeforesql != "") {
                                                $companysql = $companysql . $whereyearbeforesql . " and ";
                                            }
                                            if ($whereyearfoundedesql != "") {
                                                $companysql = $companysql . $whereyearfoundedesql . " and ";
                                            }   
                     if (($whereInvhead != "")) {
                                $companysql = $companysql .$whereInvhead . " and ";
                                $aggsql = $aggsql . $whereInvhead . " and ";
                                $bool = true;
                            }
                    $companysql = $companysql . "  i.industryid=pec.industry and
                    pec.PEcompanyID = pe.PECompanyID  and inv.InvestorId=mandainv.InvestorId and
                     mandainv.MandAId=pe.MandAId and pec.industry != 15 and pe.Deleted=0  and pe.DealTypeId= dt.DealTypeId AND it.investortype = pe.investortype " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere." AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)   
                      GROUP BY pe.MandAId  order by  DealDate desc,companyname ";
                          }
    elseif ( ($keyword != "") || ($invType != "--") || ($InTypes != "") || ($exitstatusvalue!="--") || ($dateValue!="---to---") || (($hidetxtfrm>=0) && ($hidetxtto>0)) || ($yearafter!="") || ($yearbefore!="") || ($investor_head != "--"))
    {
       // echo $keyword;exit();
        if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

            $hideWhere = " and pe.MandAId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

             $hideWhere = " and pe.MandAId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

           $hideWhere = " and pe.MandAId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

        }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

             $hideWhere = " and pe.MandAId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

        }else{
             $hideWhere = " ";
        }

        $companysql = "SELECT Distinct pe.mandaid,
        pe.mandaid,
        pe.pecompanyid,
        pec.industry,
        pe.dealtypeid,
        pe.acquirerid,
        mandainv.investorid,
        pec.companyname,
        i.industry,
        sector_business,
        dt.dealtype,
        -- Date_format(dealdate, '%M-%Y') AS DealDate,
        dealdate,
        pe.dealamount,
        pec.website,
        moreinfor,
        hideamount,
        hidemoreinfor,
        pe.investmentdeals,
        pe.investmentdeals,
        link,
        estimatedirr,
        moreinforeturns,
        it.investortypename,
        valuation,
        finlink,
        company_valuation,
        revenue_multiple,
        ebitda_multiple,
        pat_multiple,
        exitstatus,
        revenue,
        ebitda,
        pat,
        price_to_book,
        book_value_per_share,
        price_per_share,
        type,
        pec.yearfounded,pec.CINNo FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,
        manda_investors as mandainv ,peinvestors as inv ,investortype AS it where";
        $whereind="";
        $wheredates="";
        $wheredealtype=""; 
        $whereReturnMultiple="";
            if ($industry != '' && $industry != '--' && $industry!= null) {
            $inSql = '';
            $industry1 = explode(',',$industry);
            foreach($industry1 as $industrys)
            {
                if($industrys != '--'){
                    $inSql .= " pec.industry= '".$industrys."' or ";
                }
            }
            $inSql = trim($inSql,' or ');
            if($inSql !=''){
                $whereind=  ' ( '.$inSql.' ) ';
                //$whereRound="pe.round LIKE '".$round."'";
            }
        }
        if ($dealtype != '' && $dealtype != '--') {
            $dealSql = '';
            $dealtype1 = explode(',',$dealtype);
            foreach($dealtype1 as $dealtypes)
            {
                if($dealtype != '--'){
                    $dealSql .= " pe.DealTypeId= '".$dealtypes."' or ";
                }
            }
            $dealSql = trim($dealSql,' or ');
            if($dealSql !=''){
                $wheredealtype=  ' ( '.$dealSql.' ) ';
                //$whereRound="pe.round LIKE '".$round."'";
            }
            $addhide_pms_qry=" and dt.hide_for_exit in (0,1)"; 
        }
        if ($invType!= "--" && $invType!= "")
               { 
                $invType=str_replace(",","','",$invType);
                $invType="'".$invType."'";   
                $whereInvType = " pe.InvestorType IN (".$invType.")";
            $addhide_pms_qry=" and dt.hide_for_exit in (0,1)"; 
       }
        if ($investor_head != "--" && $investor_head != '') {
                   $whereInvhead = "inv.InvestorId=mandainv.InvestorId and inv.countryid = '" . $investor_head . "'";
            } 

        if ($InTypes!= "" && $InTypes!='--')
        {
            $InTypes=str_replace(",","','",$InTypes);
                $InTypes="'".$InTypes."'";
                $whereType = " pe.type IN (".$InTypes.")";
        }

        if($exitstatusvalue!="--" && $exitstatusvalue!='')
        {    $exitstatusvalue=str_replace(",","','",$exitstatusvalue);
            $exitstatusvalue="'".$exitstatusvalue."'";
            $whereexitstatus=" pe.ExitStatus IN(".$exitstatusvalue.")"; 
        }
          if(trim($hidetxtfrm=="") && trim($hidetxtto>0))
         {
           $qryReturnMultiple="Return Multiple - ";
           $whereReturnMultiple=" mandainv.MultipleReturn < ".$hidetxtto;
         }
         elseif(trim($hidetxtfrm >0) && trim($hidetxtto==""))
         {
           $qryReturnMultiple="Return Multiple - ";
           $whereReturnMultiple=" mandainv.MultipleReturn > ".$hidetxtfrm;
         }
         elseif(($hidetxtfrm>0) &&($hidetxtto > 0))
         {
                       $qryReturnMultiple="Return Multiple - ";
                       $whereReturnMultiple=" mandainv.MultipleReturn > " .$hidetxtfrm . " and  mandainv.MultipleReturn <".$hidetxtto;
                }

        if($dateValue!="---to---")
                $wheredates= " DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";


        if ($yearafter != '' && $yearbefore == '') {
                                    $whereyearaftersql = " pec.yearfounded >= $yearafter";
                                }

                                if ($yearbefore != '' && $yearafter == '') {
                                    $whereyearbeforesql = " pec.yearfounded <= $yearbefore";
                                }

                                if ($yearbefore != '' && $yearafter != '') {
                                    $whereyearfoundedesql = " pec.yearfounded >= $yearafter and pec.yearfounded <= $yearbefore";
                                }

        if ($whereind != "")
                        $companysql=$companysql . $whereind ." and ";
        if (($wheredealtype != ""))
                $companysql=$companysql . $wheredealtype . " and " ;
        if (($whereInvType != "") )
                $companysql=$companysql .$whereInvType . " and ";

        if (($whereType != "") )

                $companysql=$companysql .$whereType . " and ";

         if($whereexitstatus!="")
          {     $companysql=$companysql .$whereexitstatus . " and ";     }
        if($wheredates !== "")
                $companysql = $companysql . $wheredates ." and ";
        if($whereReturnMultiple!= "")
                {
                 $companysql = $companysql . $whereReturnMultiple ." and ";
                }
                if ($whereyearaftersql != "") {
                                    $companysql = $companysql . $whereyearaftersql . " and ";
                                }
                                if ($whereyearbeforesql != "") {
                                    $companysql = $companysql . $whereyearbeforesql . " and ";
                                }
                                if ($whereyearfoundedesql != "") {
                                    $companysql = $companysql . $whereyearfoundedesql . " and ";
                                }   
         if (($whereInvhead != "")) {
                    $companysql = $companysql .$whereInvhead . " and ";
                    $aggsql = $aggsql . $whereInvhead . " and ";
                    $bool = true;
                }
        $companysql = $companysql . "  i.industryid=pec.industry and
        pec.PEcompanyID = pe.PECompanyID  and inv.InvestorId=mandainv.InvestorId and
         mandainv.MandAId=pe.MandAId and pec.industry != 15 and pe.Deleted=0  and pe.DealTypeId= dt.DealTypeId AND it.investortype = pe.investortype " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere." AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)   
         AND inv.InvestorId IN($keyword)  GROUP BY pe.MandAId  order by  DealDate desc,companyname ";
        	//echo "<br><br>WHERE CLAUSE SQL---" .$companysql;exit();
    }
//echo $companysql;exit();
//execute query
$result = mysql_query($companysql) or die(mysql_error());
$rowscount = mysql_num_rows($result);
//echo "There are " . $rowscount . " rows in my table.";exit();
//$_SESSION['rowcount']=$rowscount;
if ($rowscount == 0)
{
    echo $rowscount;
    exit();
}
else
{
    if($_POST['exitexportcount'] == "")
    {
        $exportvalue=$_POST['exitresultarray'];
        //echo $exportvalue;exit();
        if($exportvalue == "Select-All"){
            $exportvalue = "PortfolioCompany,CIN,YearFounded,ExitingInvestors,InvestorType,ExitStatus,Industry,SectorBusinessDescription,DealType,Type,Acquirer,DealDate,DealAmount,AdvisorSeller,AdvisorBuyer,Website,AddlnInfo,InvestmentDetails,Link,ReturnMultiple,IRR,MoreInfo,CompanyValuation,RevenueMultiple,EBITDAMultiple,PATMultiple,PricetoBook,Valuation,Revenue,EBITDA,PAT,BookValuePerShare,PricePerShare";    
        
           // $exportvalue = "PortfolioCompany,YearFounded,ExitingInvestors,InvestorType,ExitStatus,Industry,SectorBusinessDescription,DealType,Type,Acquirer,DealDate,DealAmount,AdvisorSeller,AdvisorBuyer,Website,AddlnInfo,InvestmentDetails,Link,ReturnMultiple,IRR,MoreInfo,CompanyValuation,RevenueMultiple,EBITDAMultiple,PATMultiple,PricetoBook,Valuation,Revenue,EBITDA,PAT,BookValuePerShare,PricePerShare,LinkforFinancials";    
        }
        $expval=explode(",",$exportvalue);
        //print_r($expval);exit();
        // end T960
        

        updateDownload($result);
        $sheet_count = 0;
        $keywordval=explode(',',$keyword);
   


        $searchString = "Undisclosed";
        $searchString = strtolower($searchString);
        $searchStringDisplay = "Undisclosed";

        $searchString1 = "Unknown";
        $searchString1 = strtolower($searchString1);

        $searchString2 = "Others";
        $searchString2 = strtolower($searchString2);

        $dbTypeSV = 'PE';

        $tsjtitle = "© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
        $tranchedisplay = "Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE. Target Company in [] indicated a debt investment. Not included in aggregate data.";

        $replace_array = array(
            '\t',
            '\n',
            '<br>',
            '<br/>',
            '<br />',
            '\r',
            '\v'
        );
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', true);
        ini_set('display_startup_errors', true);
        date_default_timezone_set('Europe/London');
        if (PHP_SAPI == 'cli') die('This example should only be run from a Web Browser');
        /** Include PHPExcel */
        require_once '../PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        // Set document properties
        $objPHPExcel->getProperties()
            ->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

            if($keyword !="")
            {
                foreach( $keywordval as $keywordvalue){
                    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                        $hideWhere = " and pe.MandAId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";
            
                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){
            
                         $hideWhere = " and pe.MandAId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";
            
                    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){
            
                       $hideWhere = " and pe.MandAId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";
            
                    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){
            
                         $hideWhere = " and pe.MandAId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";
            
                    }else{
                         $hideWhere = " ";
                    }
            
                    $companysql = "SELECT Distinct pe.mandaid,
                    pe.mandaid,
                    pe.pecompanyid,
                    pec.industry,
                    pe.dealtypeid,
                    pe.acquirerid,
                    mandainv.investorid,
                    pec.companyname,
                    i.industry,
                    sector_business,
                    dt.dealtype,
                    -- Date_format(dealdate, '%M-%Y') AS DealDate,
                    dealdate,
                    pe.dealamount,
                    pec.website,
                    moreinfor,
                    hideamount,
                    hidemoreinfor,
                    pe.investmentdeals,
                    pe.investmentdeals,
                    link,
                    estimatedirr,
                    moreinforeturns,
                    it.investortypename,
                    valuation,
                    finlink,
                    company_valuation,
                    revenue_multiple,
                    ebitda_multiple,
                    pat_multiple,
                    exitstatus,
                    revenue,
                    ebitda,
                    pat,
                    price_to_book,
                    book_value_per_share,
                    price_per_share,
                    type,
                    pec.yearfounded,pec.CINNo FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,
                    manda_investors as mandainv ,peinvestors as inv ,investortype AS it where";
                    $whereind="";
                    $wheredates="";
                    $wheredealtype=""; 
                    $whereReturnMultiple="";
                    $whereInvType="";
                    $whereType="";
                    $whereexitstatus="";
                    $whereyearaftersql=""; 
                    $whereyearbeforesql="";
                    $whereyearfoundedesql="";
                    $whereInvhead="";

                        if ($industry != '' && $industry != '--' && $industry!= null) {
                        $inSql = '';
                        $industry1 = explode(',',$industry);
                        foreach($industry1 as $industrys)
                        {
                            if($industrys != '--'){
                                $inSql .= " pec.industry= '".$industrys."' or ";
                            }
                        }
                        $inSql = trim($inSql,' or ');
                        if($inSql !=''){
                            $whereind=  ' ( '.$inSql.' ) ';
                            //$whereRound="pe.round LIKE '".$round."'";
                        }
                    }
                    if ($dealtype != '' && $dealtype != '--') {
                        $dealSql = '';
                        $dealtype1 = explode(',',$dealtype);
                        foreach($dealtype1 as $dealtypes)
                        {
                            if($dealtype != '--'){
                                $dealSql .= " pe.DealTypeId= '".$dealtypes."' or ";
                            }
                        }
                        $dealSql = trim($dealSql,' or ');
                        if($dealSql !=''){
                            $wheredealtype=  ' ( '.$dealSql.' ) ';
                            //$whereRound="pe.round LIKE '".$round."'";
                        }
                        $addhide_pms_qry=" and dt.hide_for_exit in (0,1)"; 
                    }
                    if ($invType!= "--" && $invType!= "")
                           { 
                           // $invType=str_replace(",",$invType);
                            $whereInvType = " pe.InvestorType IN (".$invType.")";
                        $addhide_pms_qry=" and dt.hide_for_exit in (0,1)"; 
                   }
                    if ($investor_head != "--" && $investor_head != '') {
                               $whereInvhead = "inv.InvestorId=mandainv.InvestorId and inv.countryid = '" . $investor_head . "'";
                        } 
            
                    if ($InTypes!= "" && $InTypes!='--')
                    {
                       // $InTypes=str_replace(",",$InTypes);
                           // $InTypes="'".$InTypes."'";
                            $whereType = " pe.type IN ($InTypes)";
                    }
            
                    if($exitstatusvalue!="--" && $exitstatusvalue!='')
                    {   // $exitstatusvalue=str_replace(",",$exitstatusvalue);
                        //$exitstatusvalue="'".$exitstatusvalue."'";
                        $whereexitstatus=" pe.ExitStatus IN(".$exitstatusvalue.")"; 
                    }
                      if(trim($hidetxtfrm=="") && trim($hidetxtto>0))
                     {
                       $qryReturnMultiple="Return Multiple - ";
                       $whereReturnMultiple=" mandainv.MultipleReturn < ".$hidetxtto;
                     }
                     elseif(trim($hidetxtfrm >0) && trim($hidetxtto==""))
                     {
                       $qryReturnMultiple="Return Multiple - ";
                       $whereReturnMultiple=" mandainv.MultipleReturn > ".$hidetxtfrm;
                     }
                     elseif(($hidetxtfrm>0) &&($hidetxtto > 0))
                     {
                                   $qryReturnMultiple="Return Multiple - ";
                                   $whereReturnMultiple=" mandainv.MultipleReturn > " .$hidetxtfrm . " and  mandainv.MultipleReturn <".$hidetxtto;
                            }
            
                    if($dateValue!="---to---")
                            $wheredates= " DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
            
            
                    if ($yearafter != '' && $yearbefore == '') {
                                                $whereyearaftersql = " pec.yearfounded >= $yearafter";
                                            }
            
                                            if ($yearbefore != '' && $yearafter == '') {
                                                $whereyearbeforesql = " pec.yearfounded <= $yearbefore";
                                            }
            
                                            if ($yearbefore != '' && $yearafter != '') {
                                                $whereyearfoundedesql = " pec.yearfounded >= $yearafter and pec.yearfounded <= $yearbefore";
                                            }
            
                    if ($whereind != "")
                                    $companysql=$companysql . $whereind ." and ";
                    if (($wheredealtype != ""))
                            $companysql=$companysql . $wheredealtype . " and " ;
                    if (($whereInvType != "") )
                            $companysql=$companysql .$whereInvType . " and ";
                    
            
                    if (($whereType != "") )
            
                            $companysql=$companysql .$whereType . " and ";
            
                     if($whereexitstatus!="")
                      {     $companysql=$companysql .$whereexitstatus . " and ";     }
                    if($wheredates !== "")
                            $companysql = $companysql . $wheredates ." and ";
                    if($whereReturnMultiple!= "")
                            {
                             $companysql = $companysql . $whereReturnMultiple ." and ";
                            }
                            if ($whereyearaftersql != "") {
                                                $companysql = $companysql . $whereyearaftersql . " and ";
                                            }
                                            if ($whereyearbeforesql != "") {
                                                $companysql = $companysql . $whereyearbeforesql . " and ";
                                            }
                                            if ($whereyearfoundedesql != "") {
                                                $companysql = $companysql . $whereyearfoundedesql . " and ";
                                            }   
                     if (($whereInvhead != "")) {
                                $companysql = $companysql .$whereInvhead . " and ";
                                $aggsql = $aggsql . $whereInvhead . " and ";
                                $bool = true;
                            }
                    $companysql = $companysql . "  i.industryid=pec.industry and
                    pec.PEcompanyID = pe.PECompanyID  and inv.InvestorId=mandainv.InvestorId and
                     mandainv.MandAId=pe.MandAId and pec.industry != 15 and pe.Deleted=0  and pe.DealTypeId= dt.DealTypeId AND it.investortype = pe.investortype " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere." AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)   
                     AND inv.InvestorId =$keywordvalue  GROUP BY pe.MandAId  order by  DealDate desc,companyname ";
                                //echo $companysql."<br>";
                    $result = mysql_query($companysql) or die(mysql_error());
    
                    $sqlQuery=mysql_query("SELECT investor FROM `peinvestors` where InvestorId=$keywordvalue") or die(mysql_error());
                    
                    
    
                // Add some data
                $rowArray = $expval;
                $objPHPExcel->getActiveSheet()
                    ->fromArray($rowArray, // The data to set
                NULL, // Array values with this value will not be set
                'A1'
                // Top left coordinate of the worksheet range where
                //    we want to set these values (default is A1)
                );
            
            $index = 2;
    
            $peidcheck = '';
    
            $arrayData = array();
            while ($row = mysql_fetch_array($result))
            {
                $DataList = array();
                $MandAId=$row[0];

                if($row[29]==0)
                  $exitstatusdisplay="Partial";
                elseif($row[29]==1)
                  $exitstatusdisplay="Complete";
       
                $mandaAcquirerId=$row[6];
       
                if(in_array("PortfolioCompany", $expval))
                {
                    $DataList[]= $row[7];
                }
                if(in_array("CIN", $expval))
                {
                    $DataList[]= $row[38];
                }
                if(in_array("YearFounded", $expval))
                {
                    $DataList[]= $row[37]; //year founded
                }
       
               $AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from manda as peinv,acquirers as ac
               where peinv.MandAId=$MandAId and ac.AcquirerId=peinv.AcquirerId";
       
               $investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor,MultipleReturn,InvMoreInfo,IRR from manda_investors as peinv,
               peinvestors as inv where peinv.MandAId=$MandAId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others' ";
           //echo "<Br>Investor".$investorSql;
       
           $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame ,AdvisorType from peinvestments_advisorcompanies as advcomp,
           advisor_cias as cia where advcomp.PEId=$MandAId and advcomp.CIAId=cia.CIAId";
       
           $adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisoracquirer as advinv,
           advisor_cias as cia where advinv.PEId=$MandAId and advinv.CIAId=cia.CIAId";
               //echo "<Br>".$adacquirersql;
       
       
       //	echo "<Br>".$advcompanysql;
       
               // if ($rsgetAcquirerSql = mysql_query($AcquirerSql))
               // {
               // 	While($myAcquirerrow=mysql_fetch_array($rsgetAcquirerSql, MYSQL_BOTH))
               // 	{
               // 		$Acquirer=$myAcquirerrow["Acquirer"];
               // 		$AcquirerId=$myAcquirerrow["AcquirerId"];
               // 	}
               //  }
                
               // Changes
               if ($rsgetAcquirerSql = mysql_query($AcquirerSql))
               {   $rowcount = mysql_num_rows($rsgetAcquirerSql);
                   if($rowcount != 0){
                   While($myAcquirerrow=mysql_fetch_array($rsgetAcquirerSql, MYSQL_BOTH))
                   {
                      // print_r($myAcquirerrow);
                       $Acquirer=$myAcquirerrow["Acquirer"];
                       $AcquirerId=$myAcquirerrow["AcquirerId"];
                   }
                  }else{
                   $Acquirer="Nil";
                  }
                }
               //  End
       
       
                $invIRRString = "";
               if($investorrs = mysql_query($investorSql))
                {
                    $investorString="";
                    $AddUnknowUndisclosedAtLast="";
                    $AddOtherAtLast="";
                    $investorStringMoreInfo="";
                  while($rowInvestor = mysql_fetch_array($investorrs))
                   {
                       $Investorname=$rowInvestor[2];
                       $Investorname=strtolower($Investorname);
                                       $multiplereturn=$rowInvestor[3];
                       $invmoreinfo=$rowInvestor[4];
                       /*if($multiplereturn>0)
                       {   $addreturnstring= ",".$multiplereturn."x";
                                           if(($invmoreinfo!="") && ($invmoreinfo!= " "))
                                           {  $addreturnstring= $addreturnstring .",".$invmoreinfo;}
                                       }
                                       */
                       if($rowInvestor[5] > 0.00 || $rowInvestor[5] > 0){
       
                           $invIRRString.=$rowInvestor[2].",".$rowInvestor[5]."; ";    
                       } 
       
                       $invResult=substr_count($Investorname,$searchString);
                       $invResult1=substr_count($Investorname,$searchString1);
                       $invResult2=substr_count($Investorname,$searchString2);
       
                       if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                       {	$investorString=$investorString .", ".$rowInvestor[2];
                           if($multiplereturn>0)
                               {   $addreturnstring= ",".$multiplereturn."x";
                                               
       //                                            if(($invmoreinfo!="") && ($invmoreinfo!= " "))
       //                                            {  $addreturnstring= $addreturnstring .",".$invmoreinfo;}
                                               
                                                   $investorStringMoreInfo=$investorStringMoreInfo ."; ".$rowInvestor[2].$addreturnstring;
                                                }
                                                else
                                                {   $addreturnstring=" ";}
                                               // echo "<bR>--- ".$investorStringMoreInfo;
                       }
                       elseif(($invResult==1) || ($invResult1==1))
                           $AddUnknowUndisclosedAtLast=$rowInvestor[2];
                       elseif($invResult2==1)
                           $AddOtherAtLast=$rowInvestor[2];
       
       
                   }
                   $invIRRString = rtrim(trim($invIRRString),';');
                   $investorString =substr_replace($investorString, '', 0,1);
                               $investorStringMoreInfo=substr_replace($investorStringMoreInfo, '', 0,1);
       
                       if($AddUnknowUndisclosedAtLast!=="")
                           $investorString=$investorString .", ".$AddUnknowUndisclosedAtLast;
                       if($AddOtherAtLast!="")
                           $investorString=$investorString .", ".$AddOtherAtLast;
               }
       
                if($advisorcompanyrs = mysql_query($advcompanysql))
                {
                    $advisorCompanyString="";
                    while($row1 = mysql_fetch_array($advisorcompanyrs))
                   {
                       $advisorCompanyString=$advisorCompanyString.",".$row1[2]."(".$row1[3].")";
                   }
                       $advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
               }
       
       
                if($advisoracquirerrs = mysql_query($adacquirersql))
                {
                    $advisorAcquirerString="";
                    while($row2 = mysql_fetch_array($advisoracquirerrs))
                   {
                       $advisorAcquirerString=$advisorAcquirerString.",".$row2[2]."(".$row2[3].")";
                   }
                       $advisorAcquirerString=substr_replace($advisorAcquirerString, '', 0,1);
               }
               if(in_array("ExitingInvestors", $expval))
               {
                   //investors
                   $DataList[]= $investorString;
               }
               if(in_array("InvestorType", $expval))
               {
                   //investor type
                   $DataList[]= $row[22];
               }
               if(in_array("ExitStatus", $expval))
               {
                   //exit status
                   $DataList[]= $exitstatusdisplay;
               }
               if(in_array("Industry", $expval))
               {
                   //industry
                   $DataList[]= $row[8];
               }
               if(in_array("SectorBusinessDescription", $expval))
               {
                   //sector
                   $DataList[]= $row[9];
               }
               if(in_array("DealType", $expval))
               {
                   //dealtype
                   $DataList[]= $row[10];
               }   
               if(in_array("Type", $expval))
               {          
                   //Type
                   $type_val = '';
                   
                     
                           if($row[36] == 1){ $type_val = "IPO"; } else if($row[36] == 2){ $type_val = "Open Market Transaction"; }else if($row[36] == 3){ $type_val = "Reverse Merger";}else {$type_val = "Open Market Transaction";}
                       
                       $DataList[]= $type_val;
                   
               }
               if(in_array("Acquirer", $expval))
               { 
                   //Acquirer Name
                   $DataList[]= $Acquirer;
               }
               if(in_array("DealDate", $expval))
               {
                   //deal date
                //    date("Y-m-d H:i:s"); 
                   $DataList[]= date("M-Y", strtotime($row[11]));


                //    $originalDate = "2010-03-21";
                    // $newDate = date("d-m-Y", strtotime($originalDate));


                    
               }
               if(in_array("DealAmount", $expval))
               {
                   //deal amount
                   if(($row[15]==1) || ($row[12]<=0))
                       $hideamount="";
                   else
                       $hideamount=$row[12];
                               
                   $DataList[]= $hideamount;
               }
               if(in_array("AdvisorSeller", $expval))
               {
                   $DataList[]= $advisorCompanyString;
               }
               if(in_array("AdvisorBuyer", $expval))
               {
                   $DataList[]= $advisorAcquirerString;
               }
               if(in_array("Website", $expval))
               {
                   //website
                   $DataList[]= $row[13];
               }
                   
                                        
                         $price_to_book=$row[33]; 
                         if($price_to_book<=0)
                            $price_to_book="";
                         
                            
                         $book_value_per_share=$row[34]; 
                         if($book_value_per_share<=0)
                           $book_value_per_share="";
                         
                         
                        $price_per_share=$row[35]; 
                         if($price_per_share<=0)
                            $price_per_share="";
                            
                       //New Feature 08-08-2016 end
                       
                       if(in_array("AddlnInfo", $expval))
                       {
                           //additional info
                           if($row[16]==1)
                           {
                               $hidemoreinfor="";
                           }
                           else{
                               $hidemoreinfor=$row[14];
                           }
                           $DataList[]= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $hidemoreinfor));
                       }
                       if(in_array("InvestmentDetails", $expval))
                       {
                           $DataList[]= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $row[18])); // InvestmentDetails
                       }
                       if(in_array("Link", $expval))
                       {
                           if($row[19]!='')
                           {
                            $DataList[]= $row[19]; //Link
                           }else{
                            $DataList[]= ""; //Link
                           }
                       }
                       if(in_array("ReturnMultiple", $expval))
                       {
                        $DataList[]= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $investorStringMoreInfo));
                       }
                                $dec_company_valuation=$row[25];
                                  if ($dec_company_valuation <=0)
                                     $dec_company_valuation="";
       
                                 $dec_revenue_multiple=$row[26];
                                 if($dec_revenue_multiple<=0)
                                     $dec_revenue_multiple="";
       
                                 $dec_ebitda_multiple=$row[27];
                                 if($dec_ebitda_multiple<=0)
                                     $dec_ebitda_multiple="";
       
                                 $dec_pat_multiple=$row[28];
                                 if($dec_pat_multiple<=0)
                                    $dec_pat_multiple="";
       
                                    if(in_array("IRR", $expval))
                                    {
                                        $DataList[]=$invIRRString;   // IRR
                                    }
                                    if(in_array("MoreInfo", $expval))
                                    {
                                        $DataList[]= $invmoreinfo; // MoreInfo Returns
                                    }
                                    if(in_array("CompanyValuation", $expval))
                                    {
                                        $DataList[]= $dec_company_valuation;  //company valuation
                                    }                     
                                    if(in_array("RevenueMultiple", $expval))
                                    {
                                        $DataList[]= $dec_revenue_multiple;  //Revenue Multiple
                                    }                  
                                    if(in_array("EBITDAMultiple", $expval))
                                    {
                                        $DataList[]= $dec_ebitda_multiple;  //EBITDA Multiple
                                    }
                                    if(in_array("PATMultiple", $expval))
                                    {
                                        $DataList[]= $dec_pat_multiple;  //PAT Multiple
                                    }
                                    if(in_array("PricetoBook", $expval))
                                    {
                                        $DataList[]= $price_to_book;  //price_to_book
                                    }
                                    if(in_array("Valuation", $expval))
                                    {
                                        $DataList[]= $row[23];  //Valuation
                                    }
                                    if(in_array("Revenue", $expval))
                                    {
                                        $dec_revenue=$row[30];
                                        if($dec_revenue < 0 || $dec_revenue > 0){
                                            $DataList[]= $dec_revenue;  //Revenue 
                                        }else{
                                            if($dec_company_valuation >0 && $dec_revenue_multiple >0){
                            
                                                $DataList[]= number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', '');
                                            }
                                            else{
                                                $DataList[]= '';
                                            }
                                        }
                                    }
                                    if(in_array("EBITDA", $expval))
                                    {
                                        $dec_ebitda=$row[31];
                                        if($dec_ebitda < 0 || $dec_ebitda > 0){
                                            $DataList[]= $dec_ebitda;  //EBITDA 
                                        }else{
                                            if($dec_company_valuation >0 && $dec_ebitda_multiple >0){
                            
                                                $DataList[]= number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '');
                                            }
                                            else{
                                                $DataList[]= '';
                                            }
                                        }
                                    }
                                    if(in_array("PAT", $expval))
                                    {
                                        $dec_pat=$row[32];
                                        if($dec_pat < 0 || $dec_pat > 0){
                                            $DataList[]= $dec_pat;  //PAT 
                                        }else{
                                            if($dec_company_valuation >0 && $dec_pat_multiple >0){
                            
                                                $DataList[]= number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', '');
                                            }
                                            else{
                                                $DataList[]= '';
                                            }
                                        }
                                    }
                                    if(in_array("BookValuePerShare", $expval))
                                    {
                                        $DataList[]= $book_value_per_share;  //book_value_per_share
                                    }
                                    if(in_array("PricePerShare", $expval))
                                    {
                                        $DataList[]= $price_per_share;  //price_per_share
                                    }
                                    // if(in_array("LinkforFinancials", $expval))
                                    // {
                                    //     $DataList[]= $row[24];  //Financial link
                                    // }
       
                $arrayData[] = $DataList;
     
                $index++;
            }
    
     
                    // T960
                    $objPHPExcel->getActiveSheet()
                    ->fromArray(
                        $arrayData,  // The data to set
                        NULL,        // Array values with this value will not be set
                        'A2'         // Top left coordinate of the worksheet range where
                                    //    we want to set these values (default is A1)
                    );


                $indexfortitle = $index + 5;
                $indexfortranche = $index + 7;

                $objPHPExcel->setActiveSheetIndex($sheet_count)
                            ->setCellValue('A'.$indexfortitle, $tsjtitle)
                            ->setCellValue('A'.$indexfortranche, $tranchedisplay);

                // Rename worksheet
                while($rows = mysql_fetch_array($sqlQuery))
                {
                $objPHPExcel->getActiveSheet()->setTitle($rows['investor']);
                }            
                // $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()
                //     ->setWidth(12);
                // T960 Changes
                // $objPHPExcel->getActiveSheet()
                //     ->getStyle('G2:G'.$index)
                //     ->getAlignment()
                //     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                // $objPHPExcel->getActiveSheet()
                //     ->getStyle('L2:L'.$index)
                //     ->getAlignment()
                //     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                // T960 Changes
                $objPHPExcel->getActiveSheet()
                    ->getStyle('A2:A2')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $objPHPExcel->setActiveSheetIndex($sheet_count);
                $sheet_count++;
                $objPHPExcel->createSheet($sheet_count);
         
                $objPHPExcel->setActiveSheetIndex($sheet_count);
                //$objWorkSheet = $objPHPExcel->getActiveSheet($sheet_count);
        
            }

            $objPHPExcel->removeSheetByIndex(
                $objPHPExcel->getIndex(
                    $objPHPExcel->getSheetByName('Worksheet')
                )
            );

            }
            else
            {
                    // Add some data
    $rowArray = $expval;
    $objPHPExcel->getActiveSheet()
        ->fromArray(
            $rowArray,   // The data to set
            NULL,        // Array values with this value will not be set
            'A1'         // Top left coordinate of the worksheet range where
                         //    we want to set these values (default is A1)
        );
    
    $index = 2;
    
    $peidcheck = '';
    
    $arrayData = array();
    while ($row = mysql_fetch_array($result))
    {
        $DataList = array();
        $MandAId=$row[0];

        if($row[29]==0)
          $exitstatusdisplay="Partial";
        elseif($row[29]==1)
          $exitstatusdisplay="Complete";

        $mandaAcquirerId=$row[6];

        if(in_array("PortfolioCompany", $expval))
        {
            $DataList[]= $row[7];
        }
        if(in_array("CIN", $expval))
        {
            $DataList[]= $row[38];
        }
        if(in_array("YearFounded", $expval))
        {
            $DataList[]= $row[37]; //year founded
        }

       $AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from manda as peinv,acquirers as ac
       where peinv.MandAId=$MandAId and ac.AcquirerId=peinv.AcquirerId";

       $investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor,MultipleReturn,InvMoreInfo,IRR from manda_investors as peinv,
       peinvestors as inv where peinv.MandAId=$MandAId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others' ";
   //echo "<Br>Investor".$investorSql;

   $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame ,AdvisorType from peinvestments_advisorcompanies as advcomp,
   advisor_cias as cia where advcomp.PEId=$MandAId and advcomp.CIAId=cia.CIAId";

   $adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisoracquirer as advinv,
   advisor_cias as cia where advinv.PEId=$MandAId and advinv.CIAId=cia.CIAId";
       //echo "<Br>".$adacquirersql;


//	echo "<Br>".$advcompanysql;

       // if ($rsgetAcquirerSql = mysql_query($AcquirerSql))
       // {
       // 	While($myAcquirerrow=mysql_fetch_array($rsgetAcquirerSql, MYSQL_BOTH))
       // 	{
       // 		$Acquirer=$myAcquirerrow["Acquirer"];
       // 		$AcquirerId=$myAcquirerrow["AcquirerId"];
       // 	}
       //  }
        
       // Changes
       if ($rsgetAcquirerSql = mysql_query($AcquirerSql))
       {   $rowcount = mysql_num_rows($rsgetAcquirerSql);
           if($rowcount != 0){
           While($myAcquirerrow=mysql_fetch_array($rsgetAcquirerSql, MYSQL_BOTH))
           {
              // print_r($myAcquirerrow);
               $Acquirer=$myAcquirerrow["Acquirer"];
               $AcquirerId=$myAcquirerrow["AcquirerId"];
           }
          }else{
           $Acquirer="Nil";
          }
        }
       //  End


        $invIRRString = "";
       if($investorrs = mysql_query($investorSql))
        {
            $investorString="";
            $AddUnknowUndisclosedAtLast="";
            $AddOtherAtLast="";
            $investorStringMoreInfo="";
          while($rowInvestor = mysql_fetch_array($investorrs))
           {
               $Investorname=$rowInvestor[2];
               $Investorname=strtolower($Investorname);
                               $multiplereturn=$rowInvestor[3];
               $invmoreinfo=$rowInvestor[4];
               /*if($multiplereturn>0)
               {   $addreturnstring= ",".$multiplereturn."x";
                                   if(($invmoreinfo!="") && ($invmoreinfo!= " "))
                                   {  $addreturnstring= $addreturnstring .",".$invmoreinfo;}
                               }
                               */
               if($rowInvestor[5] > 0.00 || $rowInvestor[5] > 0){

                   $invIRRString.=$rowInvestor[2].",".$rowInvestor[5]."; ";    
               } 

               $invResult=substr_count($Investorname,$searchString);
               $invResult1=substr_count($Investorname,$searchString1);
               $invResult2=substr_count($Investorname,$searchString2);

               if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
               {	$investorString=$investorString .", ".$rowInvestor[2];
                   if($multiplereturn>0)
                       {   $addreturnstring= ",".$multiplereturn."x";
                                       
//                                            if(($invmoreinfo!="") && ($invmoreinfo!= " "))
//                                            {  $addreturnstring= $addreturnstring .",".$invmoreinfo;}
                                       
                                           $investorStringMoreInfo=$investorStringMoreInfo ."; ".$rowInvestor[2].$addreturnstring;
                                        }
                                        else
                                        {   $addreturnstring=" ";}
                                       // echo "<bR>--- ".$investorStringMoreInfo;
               }
               elseif(($invResult==1) || ($invResult1==1))
                   $AddUnknowUndisclosedAtLast=$rowInvestor[2];
               elseif($invResult2==1)
                   $AddOtherAtLast=$rowInvestor[2];


           }
           $invIRRString = rtrim(trim($invIRRString),';');
           $investorString =substr_replace($investorString, '', 0,1);
                       $investorStringMoreInfo=substr_replace($investorStringMoreInfo, '', 0,1);

               if($AddUnknowUndisclosedAtLast!=="")
                   $investorString=$investorString .", ".$AddUnknowUndisclosedAtLast;
               if($AddOtherAtLast!="")
                   $investorString=$investorString .", ".$AddOtherAtLast;
       }

        if($advisorcompanyrs = mysql_query($advcompanysql))
        {
            $advisorCompanyString="";
            while($row1 = mysql_fetch_array($advisorcompanyrs))
           {
               $advisorCompanyString=$advisorCompanyString.",".$row1[2]."(".$row1[3].")";
           }
               $advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
       }


        if($advisoracquirerrs = mysql_query($adacquirersql))
        {
            $advisorAcquirerString="";
            while($row2 = mysql_fetch_array($advisoracquirerrs))
           {
               $advisorAcquirerString=$advisorAcquirerString.",".$row2[2]."(".$row2[3].")";
           }
               $advisorAcquirerString=substr_replace($advisorAcquirerString, '', 0,1);
       }
       if(in_array("ExitingInvestors", $expval))
       {
           //investors
           $DataList[]= $investorString;
       }
       if(in_array("InvestorType", $expval))
       {
           //investor type
           $DataList[]= $row[22];
       }
       if(in_array("ExitStatus", $expval))
       {
           //exit status
           $DataList[]= $exitstatusdisplay;
       }
       if(in_array("Industry", $expval))
       {
           //industry
           $DataList[]= $row[8];
       }
       if(in_array("SectorBusinessDescription", $expval))
       {
           //sector
           $DataList[]= $row[9];
       }
       if(in_array("DealType", $expval))
       {
           //dealtype
           $DataList[]= $row[10];
       }   
       if(in_array("Type", $expval))
       {          
           //Type
           $type_val = '';
           
             
                   if($row[36] == 1){ $type_val = "IPO"; } else if($row[36] == 2){ $type_val = "Open Market Transaction"; }else if($row[36] == 3){ $type_val = "Reverse Merger";}else {$type_val = "Open Market Transaction";}
               
               $DataList[]= $type_val;
           
       }
       if(in_array("Acquirer", $expval))
       { 
           //Acquirer Name
           $DataList[]= $Acquirer;
       }
       if(in_array("DealDate", $expval))
       {
           //deal date
           $DataList[]= date("M-Y", strtotime($row[11]));

           
       }
       if(in_array("DealAmount", $expval))
       {
           //deal amount
           if(($row[15]==1) || ($row[12]<=0))
               $hideamount="";
           else
               $hideamount=$row[12];
                       
           $DataList[]= $hideamount;
       }
       if(in_array("AdvisorSeller", $expval))
       {
           $DataList[]= $advisorCompanyString;
       }
       if(in_array("AdvisorBuyer", $expval))
       {
           $DataList[]= $advisorAcquirerString;
       }
       if(in_array("Website", $expval))
       {
           //website
           $DataList[]= $row[13];
       }
           
                                
                 $price_to_book=$row[33]; 
                 if($price_to_book<=0)
                    $price_to_book="";
                 
                    
                 $book_value_per_share=$row[34]; 
                 if($book_value_per_share<=0)
                   $book_value_per_share="";
                 
                 
                $price_per_share=$row[35]; 
                 if($price_per_share<=0)
                    $price_per_share="";
                    
               //New Feature 08-08-2016 end
               
               if(in_array("AddlnInfo", $expval))
               {
                   //additional info
                   if($row[16]==1)
                   {
                       $hidemoreinfor="";
                   }
                   else{
                       $hidemoreinfor=$row[14];
                   }
                   $DataList[]= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $hidemoreinfor));
               }
               if(in_array("InvestmentDetails", $expval))
               {
                   $DataList[]= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $row[18])); // InvestmentDetails
               }
               if(in_array("Link", $expval))
               {
                   if($row[19]!='')
                   {
                    $DataList[]= $row[19]; //Link
                   }else{
                    $DataList[]= ""; //Link
                   }
               }
               if(in_array("ReturnMultiple", $expval))
               {
                $DataList[]= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $investorStringMoreInfo));
               }
                        $dec_company_valuation=$row[25];
                          if ($dec_company_valuation <=0)
                             $dec_company_valuation="";

                         $dec_revenue_multiple=$row[26];
                         if($dec_revenue_multiple<=0)
                             $dec_revenue_multiple="";

                         $dec_ebitda_multiple=$row[27];
                         if($dec_ebitda_multiple<=0)
                             $dec_ebitda_multiple="";

                         $dec_pat_multiple=$row[28];
                         if($dec_pat_multiple<=0)
                            $dec_pat_multiple="";

                            if(in_array("IRR", $expval))
                            {
                                $DataList[]=$invIRRString;   // IRR
                            }
                            if(in_array("MoreInfo", $expval))
                            {
                                $DataList[]= $invmoreinfo; // MoreInfo Returns
                            }
                            if(in_array("CompanyValuation", $expval))
                            {
                                $DataList[]= $dec_company_valuation;  //company valuation
                            }                     
                            if(in_array("RevenueMultiple", $expval))
                            {
                                $DataList[]= $dec_revenue_multiple;  //Revenue Multiple
                            }                  
                            if(in_array("EBITDAMultiple", $expval))
                            {
                                $DataList[]= $dec_ebitda_multiple;  //EBITDA Multiple
                            }
                            if(in_array("PATMultiple", $expval))
                            {
                                $DataList[]= $dec_pat_multiple;  //PAT Multiple
                            }
                            if(in_array("PricetoBook", $expval))
                            {
                                $DataList[]= $price_to_book;  //price_to_book
                            }
                            if(in_array("Valuation", $expval))
                            {
                                $DataList[]= $row[23];  //Valuation
                            }
                            if(in_array("Revenue", $expval))
                            {
                                $dec_revenue=$row[30];
                                if($dec_revenue < 0 || $dec_revenue > 0){
                                    $DataList[]= $dec_revenue;  //Revenue 
                                }else{
                                    if($dec_company_valuation >0 && $dec_revenue_multiple >0){
                    
                                        $DataList[]= number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', '');
                                    }
                                    else{
                                        $DataList[]= '';
                                    }
                                }
                            }
                            if(in_array("EBITDA", $expval))
                            {
                                $dec_ebitda=$row[31];
                                if($dec_ebitda < 0 || $dec_ebitda > 0){
                                    $DataList[]= $dec_ebitda;  //EBITDA 
                                }else{
                                    if($dec_company_valuation >0 && $dec_ebitda_multiple >0){
                    
                                        $DataList[]= number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '');
                                    }
                                    else{
                                        $DataList[]= '';
                                    }
                                }
                            }
                            if(in_array("PAT", $expval))
                            {
                                $dec_pat=$row[32];
                                if($dec_pat < 0 || $dec_pat > 0){
                                    $DataList[]= $dec_pat;  //PAT 
                                }else{
                                    if($dec_company_valuation >0 && $dec_pat_multiple >0){
                    
                                        $DataList[]= number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', '');
                                    }
                                    else{
                                        $DataList[]= '';
                                    }
                                }
                            }
                            if(in_array("BookValuePerShare", $expval))
                            {
                                $DataList[]= $book_value_per_share;  //book_value_per_share
                            }
                            if(in_array("PricePerShare", $expval))
                            {
                                $DataList[]= $price_per_share;  //price_per_share
                            }
                            // if(in_array("LinkforFinancials", $expval))
                            // {
                            //     $DataList[]= $row[24];  //Financial link
                            // }

        $arrayData[] = $DataList;

        $index++;
    }
    
    // T960
    $objPHPExcel->getActiveSheet()
                ->fromArray(
                    $arrayData,  // The data to set
                    NULL,        // Array values with this value will not be set
                    'A2'         // Top left coordinate of the worksheet range where
                                //    we want to set these values (default is A1)
                );
    
    
    $indexfortitle = $index + 5;
    $indexfortranche = $index + 7;
    
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$indexfortitle, $tsjtitle)
                ->setCellValue('A'.$indexfortranche, $tranchedisplay);
    
    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('pe_invdeals');
    
    // $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()
    //     ->setWidth(12);
    // T960 Changes
    // $objPHPExcel->getActiveSheet()
    //     ->getStyle('G2:G'.$index)
    //     ->getAlignment()
    //     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    
    // $objPHPExcel->getActiveSheet()
    //     ->getStyle('L2:L'.$index)
    //     ->getAlignment()
    //     ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    // T960 Changes
    $objPHPExcel->getActiveSheet()
        ->getStyle('A2:A2')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

            }
          
             // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="PEExits.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit();
    

    }
    else
    {
        echo $rowscount;
        exit();
    }
}
?>