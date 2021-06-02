<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
if($_POST['exportexit'] == "exportexit")
{
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
    //echo 'hai';
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

    $companysql = "SELECT DISTINCT pe.mandaid,
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
    Date_format(dealdate, '%M-%Y') AS DealDate,
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
        if ($industry != '' && $industry != '--') {
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
          
          $sqlSelResult = mysql_query($companysql) or die(mysql_error());

          $rowscount = mysql_num_rows($sqlSelResult);

    echo $rowscount;exit();
}
else
{
    $keyword = $_POST['investorvalue'];
    $companytype = $_POST['companytype'];
    $month1=$_POST['month1'];
    $month2=$_POST['month2'];
    $year1=$_POST['year1'];
    $year2=$_POST['year2'];
    $startDate=$year1.'-'.$month1.'-01';
    $endYear=$year2.'-'.$month2.'-31';
    $industry=$_POST['industry'];
    $city=$_POST['city'];
    $state=$_POST['state'];
    $region=$_POST['region'];
    $exitStatus=$_POST['exitStatus'];
    $round=$_POST['round'];
    $stage=$_POST['stage'];
    $investorType=$_POST['investorType'];
    //echo json_encode(explode(",",$industry));exit();
    
    //echo $_POST['companytype'];exit();
    if($companytype != '' && $companytype != '--')
    {
        $companytype=str_replace(",","','",$companytype);
        $companytype="'".$companytype."'";
       // echo 'hai';exit();
    $companyTypeStatus="and pe.listing_status IN (".$companytype.")";
    }
    //echo $companyTypeStatus;exit();
    if($industry != '')
    {
       $industryType="and pec.industry IN (".$industry.")";
    }
    if($city != '')
    {
        $query="select * from city where city_id IN (".$city.")";
        $sqlSelResult = mysql_query($query) or die(mysql_error());
    
        while ($row = mysql_fetch_assoc($sqlSelResult)) {
        $geti .= $row['city_name'] ."," ;;
        }
        $investorvalArray = explode (",", $geti);
    
        $cityType='and pec.city IN ("'. implode('","', $investorvalArray) .'")';
    }
    if($state)
    {
        $stateId="and pec.stateid IN (".$state.")";
    
    }
    if($region != '')
    {
        $RegionId="and pec.RegionId IN (".$region.")";
    }
    if($exitStatus != '')
    {
        $Exit_Status="and Exit_Status IN (".$exitStatus.")";
    }
    if($round != '')
    {
        $roundtype=explode(",",$round);
        if (count($roundtype) > 0) {
         $roundSql = '';
            foreach ($roundtype as $rounds) {
                $roundSql .= " pe.round LIKE '" . $rounds . "' or  pe.round LIKE '" . $rounds . "%' or pe.round LIKE '%" . $rounds . "%' or";
            }
            if ($roundSql != '') {
                $roundtype = 'and (' . trim($roundSql, ' or ') . ')';
            }
        }
    }
    if($stage != '')
    {
    $StageId="and pe.StageId IN (".$stage.")";
    }
    if($investorType != ''  && $investorType != '--')
    {
        $investorType=str_replace(",","','",$investorType);
        $investorType="'".$investorType."'";
    $InvestorType="and pe.InvestorType IN (".$investorType.")";
    }
    
    $sql="SELECT  Distinct pe.PECompanyID as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod, pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor, (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId JOIN industry AS i ON pec.industry = i.industryid JOIN stage AS s ON s.StageId=pe.StageId WHERE dates between '".$startDate."' and '".$endYear."' ".$companyTypeStatus." ".$industryType." ".$cityType." ".$stateId." ".$RegionId." ".$Exit_Status." ".$roundtype." ".$StageId." ".$InvestorType." and pe.Deleted=0 AND pe.SPV=0 and pe.AggHide=0 and pec.industry !=15 AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by dates desc,companyname asc";
   // echo $sql;
    $sqlSelResult = mysql_query($sql) or die(mysql_error());

    $rowscount = mysql_num_rows($sqlSelResult);
    
    echo $rowscount;exit();
}
?>


