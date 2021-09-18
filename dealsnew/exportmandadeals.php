<?php include_once("../globalconfig.php"); ?>
<?php

    //session_save_path("/tmp");
    //session_start();

    require("../dbconnectvi.php");
    $Db = new dbInvestments();
    if(!isset($_SESSION['UserNames']))
	{
	header('Location:../pelogin.php');
	}
	else
	{    
    //Check Session Id 
    $sesID=session_id();
    $emailid=$_SESSION['UserEmail'];
    $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='PE'";
    $resUserLogSel = mysql_query($sqlUserLogSel);
    $cntUserLogSel = mysql_num_rows($resUserLogSel);
    if ($cntUserLogSel > 0){
        $resUserLogSel = mysql_fetch_array($resUserLogSel);
        $logSessionId = $resUserLogSel['sessionId'];
        if ($logSessionId != $sesID){
            header( 'Location: logoff.php?value=caccess' ) ;
        }
    }
// Start T960
$exportvalue=$_POST['resultarray'];
if($exportvalue == "Select-All"){
    $exportvalue = "PortfolioCompany,CIN,YearFounded,ExitingInvestors,InvestorType,ExitStatus,Industry,SectorBusinessDescription,DealType,Type,Acquirer,DealDate,DealAmount,AdvisorSeller,AdvisorBuyer,Website,AddlnInfo,InvestmentDetails,Link,ReturnMultiple,IRR,MoreInfo,CompanyValuation,RevenueMultiple,EBITDAMultiple,PATMultiple,PricetoBook,Valuation,Revenue,EBITDA,PAT,BookValuePerShare,PricePerShare";    
}
$expval=explode(",",$exportvalue);
// end T960
    function updateDownload($res){
        //Added By JFR-KUTUNG - Download Limit
        $recCount = mysql_num_rows($res);
        $dlogUserEmail = $_SESSION['UserEmail'];
        $today = date('Y-m-d');

        //Check Existing Entry
        $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
        $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
        $rowSelCount = mysql_num_rows($sqlSelResult);
        $rowSel = mysql_fetch_object($sqlSelResult);
        $downloads = $rowSel->recDownloaded;

        if ($rowSelCount > 0){
            $upDownloads = $recCount + $downloads;
            $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
            $resUdt = mysql_query($sqlUdt) or die(mysql_error());
        }else{
            $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','PE','".$recCount."')";
            mysql_query($sqlIns) or die(mysql_error());
        }
    }        
  
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
    $investor_head=$_POST['invhead'];
    $exitstatusvalue=$_POST['txthideexitstatusvalue'];
    $hidedateStartValue=$_POST['txthidedateStartValue'];
    $hidedateEndValue=$_POST['txthidedateEndValue'];
    $dateValue=$_POST['txthidedate'];
    $tagsearch=$_POST['tagsearchval'];

    $hidetxtfrm=$_POST['txthideReturnMultipleFrm'];
    $hidetxtto=$_POST['txthideReturnMultipleTo'];

    $keyword=$_POST['txthideinvestor'];
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

    if (($keyword == "") && ($companysearch=="") && ($sectorsearch=="") &&  ($searchallfield=="")  && ($acquirersearch=="") && ($advisorsearch_legal=="") && ($advisorsearch_trans=="") && ($industry =="--") && ($InTypes =="")  && ($dealtype=="--") && ($invType == "--") && ($exitstatusvalue=="--") &&($hidedateStartValue == "------01") && ($hidedateEndValue == "------01"))
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

        $companysql = "SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId,pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname, i.industry, pec.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        DealAmount, website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM
        manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it
        WHERE pec.industry = i.industryid and dt.DealTypeId=pe.DealTypeId and it.InvestorType=pe.InvestorType
        AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15" .$addVCFlagqry .$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where.
        " order by companyname";

                            //	echo "<br>3 Query for All records" .$companysql;
    }
    elseif ($companysearch != "")
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
        $companysql="SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname, i.industry, sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM
        manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and  it.InvestorType=pe.InvestorType
        and pec.PEcompanyID = pe.PECompanyID
        AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where.
        " AND pec.PECompanyId IN ($companysearch)  
        order by companyname"; 
        //	echo "<br>Query for company search";
        //	 echo "<br> Company search--" .$companysql;
    }
    elseif ($sectorsearch != "")
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
                            
       $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
        $sector_sql = array(); // Stop errors when $words is empty

        foreach($sectorsearchArray as $word){
            $word =trim($word);
//                                                $sector_sql[] = " sector_business LIKE '$word%' ";
            $sector_sql[] = " sector_business = '$word' ";
            $sector_sql[] = " sector_business LIKE '$word(%' ";
            $sector_sql[] = " sector_business LIKE '$word (%' ";
        }
        $sector_filter = implode(" OR ", $sector_sql);

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
                $whereind=  ' ( '.$inSql.' ) and';
                //$whereRound="pe.round LIKE '".$round."'";
            }
        }
        if ($sector != '' || $subsector != '') {
                $joinsectortable = ",pe_subsectors as pe_sub";
                $wheresectortable = "and pec.PEcompanyID=pe_sub.PECompanyID";
            }
        if ($subsector != '') {
            $subsector=explode(",",$subsector);
                                    foreach ($subsector as $value){ 
                                     //   echo "value:".$value;

                                        $subsectorString .= "'".$value."'" ;
                                        $subsectorString .=',';
                                    } 
                                    $subsectorString = trim($subsectorString, ',');
                                    $wheresubsectorsql = " and pe_sub.subsector_name IN($subsectorString)";
                                }

        $companysql="SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname, i.industry, sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM
        manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it".$joinsectortable."
        WHERE".$whereind." DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and  it.InvestorType=pe.InvestorType
        and pec.PEcompanyID = pe.PECompanyID
        AND pe.Deleted =0 and pec.industry != 15 " .$wheresectortable.$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where. $wheresubsectorsql .
        " AND  ($sector_filter) 
        group by pe.MandAId
        order by companyname";
        
        	/*echo "<br>Query for company search";
        	 echo "<br> Company search--" .$companysql;*/
    }
    elseif($keyword!="") 
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

        $companysql="select pe.MandAId,pe.MandAId,pe.PECompanyId,pec.industry,pe.DealTypeId,pe.AcquirerID,peinv_inv.InvestorId,
        pec.companyname,i.industry,sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,pec.website,MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,
        EstimatedIRR,MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM
        manda_investors as peinv_inv,
        peinvestors as inv,
        manda as pe,dealtypes as dt,
        pecompanies as pec,industry as i,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'  and  
        pe.Deleted=0 and
        peinv_inv.MandAId=pe.MandAId and dt.DealTypeId=pe.DealTypeId and
        inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and it.InvestorType=pe.InvestorType
        and pec.PECompanyId=pe.PECompanyId and pec.industry != 15 " .$addVCFlagqry.$addhide_pms_qry  .$addDelind.$hideWhere.$comp_industry_id_where.
        " AND inv.InvestorId IN($keyword)  order by companyname";

       // echo "<br> Investor search- ".$companysql;
    }
    elseif($acquirersearch!="")
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
        $companysql="SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId,c.industry,pe.DealTypeId,pe.AcquirerId,
        c.companyname,i.industry, sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,c.website,MoreInfor,hideamount,hidemoreinfor, ac.Acquirer,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,c.yearfounded,c.CINNo
        FROM
        acquirers AS ac, manda AS pe, pecompanies AS c, industry AS i,dealtypes as dt ,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  ac.AcquirerId = pe.AcquirerId and dt.DealTypeId=pe.DealTypeId
        AND c.industry = i.industryid and pe.Deleted=0
        AND c.PECompanyId = pe.PECompanyId and it.InvestorType=pe.InvestorType
        AND c.industry !=15 " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where.
        " AND ac.AcquirerId IN ($acquirersearch) 
        order by companyname ";
        //	echo "<Br>Acquirer search--" .$companysql;
    }
    elseif ($searchallfield != "")
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

       /* $findTag = strpos($searchallfield,'tag:');
            $findTags = "$findTag";
            if($findTags == ''){
                $tagsval = "pec.city LIKE '%$searchallfield%' OR  pec.companyname LIKE '%$searchallfield%'
        OR sector_business LIKE '%$searchallfield%'  or  MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%'";                                    
            }else{
                $tags = '';
                $ex_tags = explode(',',$searchallfield);
                if(count($ex_tags) > 0){
                    for($l=0;$l<count($ex_tags);$l++){
                        if($ex_tags[$l] !=''){
                            $value = trim(str_replace('tag:','',$ex_tags[$l]));
                            $tags .= "pec.tags like '%:$value%' or ";
                        }
                    }
                }
                $tagsval = trim($tags,' or ');
            }*/
             $searchExplode = explode( ' ', $searchallfield );
            foreach( $searchExplode as $searchFieldExp ) {

                $cityLike .= "pec.city REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                $companyLike .= "pec.companyname REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                $sectorLike .= "sector_business REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                $investmentDealsLike .= "InvestmentDeals REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                $industryLike .= "i.industry REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                $websiteLike .= "pec.website REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";

                $tagsLike .= "(pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,') and ";
            }
            $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";
            $cityLike = '('.trim($cityLike,'AND ').')';
            $companyLike = '('.trim($companyLike,'AND ').')';
            $sectorLike = '('.trim($sectorLike,'AND ').')';
            $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
            $investmentDealsLike = '('.trim($investmentDealsLike,'AND ').')';
            $industryLike = '('.trim($industryLike,'AND ').')';
            $websiteLike = '('.trim($websiteLike,'AND ').')';
            $tagsLike = '('.trim($tagsLike,'AND ').')';
            $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investmentDealsLike . ' OR ' . $industryLike . ' OR ' . $websiteLike . ' OR ' . $tagsLike;                               
            
        $companysql="SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname, i.industry, sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM
        manda AS pe,
        industry AS i,
        pecompanies AS pec,
        dealtypes as dt,
        investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and
        pec.PEcompanyID = pe.PECompanyID and it.InvestorType=pe.InvestorType
        AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where.
        " AND ( $tagsval ) GROUP BY pe.MandAId
        order by DealDate,companyname asc";
        // echo "<br>Query for company search";
        // echo "<br> SEARCH FIELD search--" .$companysql;
        // exit;
    }
    elseif($advisorsearch_legal!="")
    {
        // echo 'Ist Else if';

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

        $companysql="(select pe.MandAId,pe.PECompanyId,pec.industry,pe.DealTypeId,adac.CIAId AS AcqCIAId,cia.CIAId,pe.AcquirerId,
        pec.companyname,i.industry,pec.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,pec.website,MoreInfor,hideamount,hidemoreinfor,cia.cianame,pe.InvestmentDeals,Link,
        EstimatedIRR,MoreInfoReturns, it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        from manda AS pe, pecompanies AS pec,industry AS i,advisor_cias AS cia,
        peinvestments_advisoracquirer AS adac,acquirers as ac,dealtypes as dt,investortype as it
        where DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and pe.Deleted=0 and
        pec.industry=i.industryid
        and ac.AcquirerId=pe.AcquirerId and pec.PECompanyId=pe.PECompanyId and it.InvestorType=pe.InvestorType   and AdvisorType='L'
        and adac.CIAId=cia.CIAID " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where.
        " AND adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearch_legal%' GROUP BY pe.MandAId)
        UNION
        (SELECT pe.MandAId, pe.PECompanyId,pec.industry,pe.DealTypeId,adcomp.CIAId AS AcqCIAId,cia.CIAId,pe.AcquirerId,
        pec.companyname, i.industry, pec.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,pec.website,MoreInfor,hideamount,hidemoreinfor,
        cia.cianame,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,it.InvestorTypeName,
        Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM manda AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
        peinvestments_advisorcompanies AS adcomp, acquirers AS ac,dealtypes as dt,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pe.Deleted=0 and
        pec.industry = i.industryid
        AND ac.AcquirerId = pe.AcquirerId and dt.DealTypeId=pe.DealTypeId   and AdvisorType='L'
        AND pec.PECompanyId = pe.PECompanyId  and it.InvestorType=pe.InvestorType
        AND adcomp.CIAId = cia.CIAID " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where.
        " AND adcomp.PEId = pe.MandAId AND cianame LIKE '%$advisorsearch_legal%' GROUP BY pe.MandAId)
        ORDER BY companyname";
            // echo "<br>Advisor search-- " .$companysql;
            // exit();
    }
    elseif($advisorsearch_trans!="")
    {
        // echo '2nd Else if';

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
        $companysql="(SELECT pe.MandAId, pe.PECompanyId,pec.industry,pe.DealTypeId,adcomp.CIAId AS CompCIAId,cia.CIAId,pe.AcquirerId,
        pec.companyname, i.industry, pec.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,pec.website,MoreInfor,hideamount,hidemoreinfor,
        cia.cianame,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,it.InvestorTypeName,
        Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple ,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM manda AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
        peinvestments_advisorcompanies AS adcomp, acquirers AS ac,dealtypes as dt,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pe.Deleted=0 and
        pec.industry = i.industryid
        AND ac.AcquirerId = pe.AcquirerId and dt.DealTypeId=pe.DealTypeId
        AND pec.PECompanyId = pe.PECompanyId  and it.InvestorType=pe.InvestorType    and AdvisorType='T'
        AND adcomp.CIAId = cia.CIAID " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where.
        " AND adcomp.PEId = pe.MandAId AND cianame LIKE '%$advisorsearch_trans%')
        UNION
        (SELECT pe.MandAId, pe.PECompanyId,pec.industry,pe.DealTypeId,adcomp.CIAId AS CompCIAId,cia.CIAId,pe.AcquirerId,
        pec.companyname, i.industry, pec.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,pec.website,MoreInfor,hideamount,hidemoreinfor,
        cia.cianame,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,it.InvestorTypeName,
        Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple ,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM manda AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
        peinvestments_advisorcompanies AS adcomp, acquirers AS ac,dealtypes as dt,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pe.Deleted=0 and
        pec.industry = i.industryid
        AND ac.AcquirerId = pe.AcquirerId and dt.DealTypeId=pe.DealTypeId
        AND pec.PECompanyId = pe.PECompanyId  and it.InvestorType=pe.InvestorType    and AdvisorType='T'
        AND adcomp.CIAId = cia.CIAID " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where.
        " AND adcomp.PEId = pe.MandAId AND cianame LIKE '%$advisorsearch_trans%')
        ORDER BY companyname";




        // $companysql="(select pe.MandAId,pe.PECompanyId,pec.companyname,i.industry,pec.sector_business as sector_business,pe.DealAmount,
        // cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
        // (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
        // from manda AS pe, pecompanies AS pec, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
        // dealtypes as dt
        // where DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and
        // Deleted=0 and pec.industry=i.industryid and ac.AcquirerId=pe.AcquirerId  " .$addVCFlagqry  .$addhide_pms_qry. $addDelind.$hideWhere.
        // " and pec.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='T' and
        // adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearch_trans%' $comp_industry_id_where GROUP BY pe.MandAId )
        // UNION
        // (SELECT pe.MandAId, pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.DealAmount, cia.CIAId,
        // cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
        // (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
        // FROM manda AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
        // peinvestments_advisorcompanies AS adcomp, acquirers AS ac,dealtypes as dt
        // WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and   Deleted=0 and pec.industry = i.industryid
        // AND ac.AcquirerId = pe.AcquirerId " .$addVCFlagqry . $addhide_pms_qry. $addDelind.$hideWhere.
        // " AND pec.PECompanyId = pe.PECompanyId
        // AND adcomp.CIAId = cia.CIAID  and AdvisorType='T'
        // AND adcomp.PEId = pe.MandAId
        // AND cianame LIKE '%$advisorsearch_trans%' $comp_industry_id_where GROUP BY pe.MandAId ) ";

        // $orderby="DealDate";
        //     $ordertype="desc";
        //     $fetchRecords=true;
        //     $fetchAggregate==false;
        //     $popup_search=1;

                // echo "<br>2Advisor search-- " .$companysql; exit;
    }
    elseif ($tagsearch != "")
        {
            $iftest=4;
            $yourquery=1;
            $datevalueDisplay1="";
            $datevalueCheck1="";
            /*$dt1 = $year1."-".$month1."-01";
            $dt2 = $year2."-".$month2."-31";*/
                
            $tags = '';
            $ex_tags = explode(',',$tagsearch);
            if(count($ex_tags) > 0){
                for($l=0;$l<count($ex_tags);$l++){
                    if($ex_tags[$l] !=''){
                        $value = trim(str_replace('tag:','',$ex_tags[$l]));
                        $value = str_replace(" ","",$value);
                        //$tags .= "pec.tags like '%:$value%' or ";
                        //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP 
                       /* $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]".$value."[[:>:]]'"." or";*/
                        if($tagandor==0){
                                            $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]".$value."[[:>:]]'"." and";
                                        }else{
                                              $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]".$value."[[:>:]]'"." or";
                                        }
                    }
                }
            }
            /*$tagsval = trim($tags,' or ');*/
            if($tagandor==0){
                                            $tagsval = trim($tags,' and ');
                                        }else{
                                             $tagsval = trim($tags,' or ');
                                        }
            $companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
            pe.DealAmount,pec.website, pe.MandAId,pe.Comment,MoreInfor,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others' separator ', ') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
            FROM manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt
            WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and   pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
            AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry . $addhide_pms_qry . $addDelind.
            " AND ( $tagsval ) $comp_industry_id_where GROUP BY pe.MandAId ";
             $companysql="SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname, i.industry, sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM
        manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and  it.InvestorType=pe.InvestorType
        and pec.PEcompanyID = pe.PECompanyID
        AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.$addhide_pms_qry .$addDelind.
        " AND  ($tagsval) 
        order by DealDate desc";
           
            //  echo "<br>Query for company search";
            //echo "<br> Company search--" .$companysql;
        }
    elseif (($industry !='') || ($dealtype !='') || ($invType != "--") || ($InTypes != "") || ($exitstatusvalue!="--") || ($dateValue!="---to---") || (($hidetxtfrm>=0) && ($hidetxtto>0)) || ($yearafter!="") || ($yearbefore!="") || ($investor_head != "--"))
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

        $companysql = "SELECT DISTINCT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId,pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname,i.industry,pec.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate, pe.DealAmount,pec.website,
        pe.MoreInfor,pe.hideamount,pe.hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type,pec.yearfounded,pec.CINNo
        FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it,manda_investors as mandainv,peinvestors as inv where";
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
            $addhide_pms_qry=" and dt.hide_for_exit in (0)"; 
        }
        if ($invType!= "--" && $invType!= "")
               { $whereInvType = " pe.InvestorType = '".$invType."'";
            $addhide_pms_qry=" and dt.hide_for_exit in (1)"; 
       }
        if ($investor_head != "--" && $investor_head != '') {
                   $whereInvhead = "inv.InvestorId=mandainv.InvestorId and inv.countryid = '" . $investor_head . "'";
            } 

        if ($InTypes!= "" && $InTypes!='--')
        {
                $whereType = " pe.type = '".$InTypes."'";
        }

        if($exitstatusvalue!="--" && $exitstatusvalue!='')
        {    
            $whereexitstatus=" pe.ExitStatus=".$exitstatusvalue; 
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
        pec.PEcompanyID = pe.PECompanyID  and dt.DealtypeId=pe.DealTypeId and   pe.InvestorType=it.InvestorType  and
         mandainv.MandAId=pe.MandAId and pe.Deleted=0  " .$addVCFlagqry.$addhide_pms_qry .$addDelind.$hideWhere.$comp_industry_id_where." order by companyname ";
        //	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
    }
    else
    {
            echo "<br> INVALID DATES GIVEN ";
            $fetchRecords=false;
    }
		//mail sending
    $checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
    dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
    dm.EmailId='$submitemail' AND dc.Deleted =0";
    if ($totalrs = mysql_query($checkUserSql))
    {

        $cnt= mysql_num_rows($totalrs);
        //echo "<Br>mail count------------------" .$hidesearchon;
        if ($cnt==1)
        {

            While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
            {
                if( date('Y-m-d')<=$myrow["ExpiryDate"])
                {

                    $OpenTableTag="<table border=1 cellpadding=1 cellspacing=0 ><td>";
                    $CloseTableTag="</table>";


                    $headers  = "MIME-Version: 1.0\n";
                    $headers .= "Content-type: text/html;
                    charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";

                    /* additional headers
                    $headers .= "Cc: sow_ram@yahoo.com\r\n"; */

                    $RegDate=date("M-d-Y");
                    $to="arun.natarajan@gmail.com,arun@ventureintelligence.com";
                                        //$to="sowmyakvn@gmail.com";
                    $filetitle="";
                    if($searchtitle==0)
                    {
                            $searchdisplay="PEExits-M&A";
                            $filetitle="PEExits-M&A";
                    }
                    elseif($searchtitle==1)
                    {
                            $searchdisplay="VCExits-M&A";
                            $filetitle="VCExits-M&A";

                    }
                    if($hide_pms==1)
                    {
                      $searchdisplay="Public Market Sales ".$searchdisplay;
                            $filetitle="Public_Market_Sales_".$filetitle;
                    }
                    /*elseif($searchtitle==2)
                    {
                            $searchdisplay="Real Estate";
                            $filetitle="";
                    }
                    else
                            $searchdisplay="";
                    */
                    if($hidesearchon==1)
                    {
                            $subject="Send Excel Data: Investments - $searchdisplay";
                            $message="<html><center><b><u> Send Investment : $searchdisplay - $submitemail</u></b></center><br>
                            <head>
                            </head>
                            <body >
                            <table border=1 cellpadding=0 cellspacing=0  width=74% >
                            <tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
                            <tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
                            <tr><td width=1%>Stage</td><td width=99%>$hidestagetext</td></tr>
                            <tr><td width=1%>Investment Type</td><td width=99%>$invtypevalue</td></tr>
                            <tr><td width=1%>Range</td><td width=99%>$rangeText</td></tr>
                            <tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
                            <tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
                            <tr><td width=1%>Company/Sector</td><td width=99%>$companysearch</td></tr>
                            <td width=29%> $CloseTableTag</td></tr>
                            </table>
                            </body>
                            </html>";
                    }
                    elseif($hidesearchon==2)
                    {
                            $subject="Send Excel Data: IPO Exits - $searchdisplay";
                            $message="<html><center><b><u> Send IPO Data: $searchdisplay to - $submitemail</u></b></center><br>
                            <head>
                            </head>
                            <body >
                            <table border=1 cellpadding=0 cellspacing=0  width=74% >
                            <tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
                            <tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
                            <tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
                            <tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
                            <tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>
                            <tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>

                            <td width=29%> $CloseTableTag</td></tr>
                            </table>
                            </body>
                            </html>";
                    }
                    elseif($hidesearchon==3)
                    {
                            $subject="Send Excel Data : M&A Exits - $searchdisplay ";
                            $message="<html><center><b><u> Send M&A Data :$searchdisplay to - $submitemail</u></b></center><br>
                            <head>
                            </head>
                            <body >
                            <table border=1 cellpadding=0 cellspacing=0  width=74% >
                            <tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
                            <tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
                            <tr><td width=1%>Deal Type </td><td width=99%>$dealtypetext</td></tr>
                            <tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
                            <tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
                            <tr><td width=1%>Investment Type</td><td width=99%>$invtypevalue</td></tr>
                            <tr><td width=1%>Exit Status Type</td><td width=99%>$exitstatusvalue</td></tr>
                            <tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>
                            <tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>
                            <tr><td width=1%>Acquirer</td><td width=99%>$acquirersearch</td></tr>
                            <td width=29%> $CloseTableTag</td></tr>
                            </table>
                            </body>
                            </html>";
                    }
                    elseif($hidesearchon==4)
                    {
                            $searchdisplay="";
                            $subject="Send Excel Data : Mergers & Acquistion - $searchdisplay ";
                            $message="<html><center><b><u> Send Mergers & Acquistion Data :$searchdisplay to - $submitemail</u></b></center><br>
                            <head>
                            </head>
                            <body >
                            <table border=1 cellpadding=0 cellspacing=0  width=74% >
                            <tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
                            <tr><td width=1%>Industry </td><td width=99%>$hideindustry</td></tr>
                            <tr><td width=1%>Deal Type </td><td width=99%>$dealtype</td></tr>
                            <tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
                            <tr><td width=1%>Target Company</td><td width=99%>$companysearch</td></tr>
                            <tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>
                            <tr><td width=1%>Acquirer</td><td width=99%>$acquirersearch</td></tr>
                            <tr><td width=1%>Target Country</td><td width=99%>$targetCountry</td></tr>
                            <tr><td width=1%>Acquirer Country</td><td width=99%>$acquirerCountry</td></tr>
                            <td width=29%> $CloseTableTag</td></tr>
                            </table>
                            </body>
                            </html>";
                    }
							//	mail($to,$subject,$message,$headers);
								//header( 'Location: http://www.ventureintelligence.com/deals/cthankyou.php' ) ;
                }
                elseif($myrow["ExpiryDate"] >= date('y-m-d'))
                {
                        $displayMessage= $TrialExpired;
                        $submitemail="";
                        $submitpassword="";
                }
            }
        }
        elseif ($cnt==0)
        {
                $displayMessage= "Invalid Login / Password";
                $submitemail="";
                $submitpassword="";
        }
    }

 $sql=$companysql;
 /*echo $tagsearch;*/
// echo "<br>---" .$sql;
// exit();
 //execute query
 $result = @mysql_query($sql)
     or die("Error in connection");
 updateDownload($result);

 //if this parameter is included ($w=1), file returned will be in word format ('.doc')
 //if parameter is not included, file returned will be in excel format ('.xls')
 	if (isset($w) && ($w==1))
 	{
 		$file_type = "msword";
 		$file_ending = "doc";
 	}
 	else
 	{
 		$file_type = "vnd.ms-excel";
 		$file_ending = "xls";
	}
        
        
        
        
        
        
        
        
        
        
   /*     
        
        
         $table .= '<table border="0" cellpadding="0" cellspacing="0" ><tr><td>';

            $table .= '<tr>';

            $table .= '<td>Time1</td>';
            $table .= '<td>Time2</td>';
             $table .= '<td>Time3</td>';

            $table .= '</tr>';

            $table .= '<tr>';

            
             $table .= '<tr>';

             $table .= '<td style="width:200px; height:500px; word-wrap: break-word;">Round1 (Apr 2002) INR 13.49 Cr Euronet invested INR 8.49 Cr for 26.44% stake. Kotak PE invested INR 5-Cr for 20.74% stake. Pricing details: Equity = FV Rs.10; Issue price Rs.30 CCPS = FV Rs.100; Issue price Rs.100 FIRST TRANCHE: (Apr 2002, INR 6.74 Cr) Issue of 17,500 equity shares and 419,125 CCPS to Euronet Issue of 10,000 equity shares and 247,000 CCPS to Kotak PE SECOND TRANCHE: (Jun 2002, INR 6.74 Cr) Issue of 17,500 equity shares and 419,125 CCPS to Euronet Issue of 10,000 equity shares and 247,000 CCPS to Kotak PE On Jan 14, 2005, all the CCPS were converted to equity shares in the following manner: 838,250 CCPS of Euronet were converted to equity shares at a conversion price of Rs.39.60 per share. Accordingly 2,117,317 equity shares were issued to Euronet. 494,000 CCPS of Kotak PE were converted to equity shares at a conversion price of Rs.29.61 per share. Accordingly 1,668,092 equity shares were issued to Kotak PE. Pre-IPO SHP: Euronet - 24.39% (2,152,317 equity shares) Kotak PE - 19.13% (1,688,092 equity shares)</td>';
             $table .= '<td>   </td>';
             $table .= '<td>Round1 (Apr 2002) INR 13.49 Cr Euronet invested INR 8.49 Cr for 26.44% stake. Kotak PE invested INR 5-Cr for 20.74% stake. Pricing details: Equity = FV Rs.10; Issue price Rs.30 CCPS = FV Rs.100; Issue price Rs.100 FIRST TRANCHE: (Apr 2002, INR 6.74 Cr) Issue of 17,500 equity shares and 419,125 CCPS to Euronet Issue of 10,000 equity shares and 247,000 CCPS to Kotak PE SECOND TRANCHE: (Jun 2002, INR 6.74 Cr) Issue of 17,500 equity shares and 419,125 CCPS to Euronet Issue of 10,000 equity shares and 247,000 CCPS to Kotak PE On Jan 14, 2005, all the CCPS were converted to equity shares in the following manner: 838,250 CCPS of Euronet were converted to equity shares at a conversion price of Rs.39.60 per share. Accordingly 2,117,317 equity shares were issued to Euronet. 494,000 CCPS of Kotak PE were converted to equity shares at a conversion price of Rs.29.61 per share. Accordingly 1,668,092 equity shares were issued to Kotak PE. Pre-IPO SHP: Euronet - 24.39% (2,152,317 equity shares) Kotak PE - 19.13% (1,688,092 equity shares)</td>';

            $table .= '</tr>';

            $table .= '<tr>';

           

            $table .= '</table>';

         

 

        header("Content-type: application/x-msdownload");
        
        # replace excelfile.xls with whatever you want the filename to default to

        header("Content-Disposition: attachment; filename=test.xls");

        header("Pragma: no-cache");

        header("Expires: 0");

        echo $table;

        
        exit;
        
     */   
        
 //header info for browser: determines file type ('.doc' or '.xls')
 header("Content-Type: application/$file_type");
 
 header("Content-Disposition: attachment; filename=$filetitle.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");

/*    Start of Formatting for Word or Excel    */



 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	if ($Use_Title == 1)
 	{
 		echo("$title\n");
 	}

 	/*echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");*/

 //define separator (defines columns in excel & tabs in word)
 $sep = " \t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }


// echo "Portfolio Company"."\t";
// echo "Year Founded"."\t";
// 	//echo "PE Firm(s)"."\t";
//     echo "Exiting Investors"."\t";
// 	echo "Investor Type"."\t";
// 	 echo "Exit Status"."\t";
//         echo "Industry"."\t";
// 	echo "Sector_Business Description"."\t";
// 	echo "Deal Type"."\t";
//         if($hide_pms==1){
//             echo "Type"."\t";
//         }
// 	echo "Acquirer "."\t";
// 	echo "Deal Date"."\t";
// 	echo "Deal Amount (US\$M)"."\t";
// 	echo "Advisor-Seller"."\t";
// 	echo "Advisor-Buyer"."\t";
// 	echo "Website"."\t";
// 	echo "Addln Info"."\t";
// 	echo "Investment Details"."\t";
	
         
//     echo "Link"."\t";
//     echo "Return Multiple"."\t";
//     echo "IRR (%)"."\t";
//     //echo "Estimated Returns"."\t";
// 	echo "More Info(Returns)"."\t"; 
//         echo "Company Valuation (INR Cr)"."\t";
//         echo "Revenue Multiple"."\t";
//         echo "EBITDA Multiple"."\t";
//         echo "PAT Multiple"."\t";
		
// 		// New Feature 08-08-2016 start
	
// 			echo "Price to Book"."\t";
		
// 		//New Feature 08-08-2016 end
		
//         echo "Valuation (More Info)"."\t";
//         echo "Revenue (INR Cr)" . "\t";
//         echo "EBITDA (INR Cr)" . "\t";
//         echo "PAT (INR Cr)" . "\t";
// 			echo "Book Value Per Share"."\t";
// 			echo "Price Per Share"."\t";
// 	echo "Link for Financials"."\t";

if(in_array("PortfolioCompany", $expval))
{
    echo "Portfolio Company"."\t";
}
if(in_array("CIN", $expval))
{
    echo "CIN"."\t";
}
if(in_array("YearFounded", $expval))
{
    echo "Year Founded"."\t";
}
if(in_array("ExitingInvestors", $expval))
{
    echo "Exiting Investors"."\t";
}
if(in_array("InvestorType", $expval))
{
    echo "Investor Type"."\t";
}
if(in_array("ExitStatus", $expval))
{
    echo "Exit Status"."\t";
}
if(in_array("Industry", $expval))
{
    echo "Industry"."\t";
}
if(in_array("SectorBusinessDescription", $expval))
{   
    echo "Sector_Business Description"."\t";
}
if(in_array("DealType", $expval))
{
    echo "Deal Type"."\t";
}
if(in_array("Type", $expval))
{
    if($hide_pms==1){
        echo "Type"."\t";
    }
}
if(in_array("Acquirer", $expval))
{
    echo "Acquirer "."\t";
}
if(in_array("DealDate", $expval))
{
    echo "Deal Date"."\t";
}
if(in_array("DealAmount", $expval))
{
    echo "Deal Amount (US\$M)"."\t";
}
if(in_array("AdvisorSeller", $expval))
{
    echo "Advisor-Seller"."\t";
}
if(in_array("AdvisorBuyer", $expval))
{
    echo "Advisor-Buyer"."\t";
}
if(in_array("Website", $expval))
{
    echo "Website"."\t";
}
if(in_array("AddlnInfo", $expval))
{
    echo "Addln Info"."\t";
}
if(in_array("InvestmentDetails", $expval))
{   
    echo "Investment Details"."\t";
}
if(in_array("Link", $expval))
{
    echo "Link"."\t";
}
if(in_array("ReturnMultiple", $expval))
{
    echo "Return Multiple"."\t";
}
if(in_array("IRR", $expval))
{
    echo "IRR (%)"."\t";
}
if(in_array("MoreInfo", $expval))
{
    echo "More Info(Returns)"."\t"; 
}
if(in_array("CompanyValuation", $expval))
{
    echo "Company Valuation (INR Cr)"."\t";
}
if(in_array("RevenueMultiple", $expval))
{
    echo "Revenue Multiple"."\t";
}
if(in_array("EBITDAMultiple", $expval))
{
    echo "EBITDA Multiple"."\t";
}
if(in_array("PATMultiple", $expval))
{
    echo "PAT Multiple"."\t";		
}
// New Feature 08-08-2016 start	
if(in_array("PricetoBook", $expval))
{
    echo "Price to Book"."\t";		
}
//New Feature 08-08-2016 end		
if(in_array("Valuation", $expval))
{
    echo "Valuation (More Info)"."\t";
}
if(in_array("Revenue", $expval))
{    
    echo "Revenue (INR Cr)" . "\t";
}
if(in_array("EBITDA", $expval))
{
    echo "EBITDA (INR Cr)" . "\t";
}
if(in_array("PAT", $expval))
{
    echo "PAT (INR Cr)" . "\t";
}
if(in_array("BookValuePerShare", $expval))
{
    echo "Book Value Per Share"."\t";
}
if(in_array("PricePerShare", $expval))
{
    echo "Price Per Share"."\t";
}
// if(in_array("LinkforFinancials", $expval))
// {
//     echo "Link for Financials"."\t";
// }
       
 print("\n");

 /*print("\n");*/
 //end of printing column names

 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */
 $searchString="Undisclosed";
  $searchString=strtolower($searchString);
   $searchStringDisplay="Undisclosed";

  $searchString1="Unknown";
  $searchString1=strtolower($searchString1);

  $searchString2="Others";
 $searchString2=strtolower($searchString2);

     while($row = mysql_fetch_row($result))
     {
         //set_time_limit(60); // HaRa
         $schema_insert = "";
         $MandAId=$row[0];

         if($row[29]==0)
           $exitstatusdisplay="Partial";
         elseif($row[29]==1)
           $exitstatusdisplay="Complete";

         $mandaAcquirerId=$row[6];

         if(in_array("PortfolioCompany", $expval))
         {
             $schema_insert .= $row[7].$sep;
         }
         if(in_array("CIN", $expval))
         {
             $schema_insert .= $row[38].$sep;
         }
         if(in_array("YearFounded", $expval))
         {
             $schema_insert .= $row[37].$sep; //year founded
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
            $schema_insert .= $investorString.$sep;
        }
        if(in_array("InvestorType", $expval))
        {
            //investor type
            $schema_insert .= $row[22].$sep;
        }
        if(in_array("ExitStatus", $expval))
        {
            //exit status
            $schema_insert .= $exitstatusdisplay.$sep;
        }
        if(in_array("Industry", $expval))
        {
            //industry
            $schema_insert .= $row[8].$sep;
        }
        if(in_array("SectorBusinessDescription", $expval))
        {
            //sector
            $schema_insert .= $row[9].$sep;
        }
        if(in_array("DealType", $expval))
        {
            //dealtype
            $schema_insert .= $row[10].$sep;
        }   
        if(in_array("Type", $expval))
        {          
            //Type
            $type_val = '';
            if($hide_pms==1){
                if($row[5] == 4){
                    if($row[36] == 1){ $type_val = "IPO"; } else if($row[36] == 2){ $type_val = "Open Market Transaction"; }else if($row[36] == 3){ $type_val = "Reverse Merger";}else {$type_val = "Open Market Transaction";}
                }
                $schema_insert .= $type_val.$sep;
            }
        }
        if(in_array("Acquirer", $expval))
        { 
            //Acquirer Name
            $schema_insert .= $Acquirer.$sep;
        }
        if(in_array("DealDate", $expval))
        {
		    //deal date
            $schema_insert .= $row[11].$sep;
        }
        if(in_array("DealAmount", $expval))
        {
		    //deal amount
			if(($row[15]==1) || ($row[12]<=0))
				$hideamount="";
			else
				$hideamount=$row[12];
                        
            $schema_insert .= $hideamount.$sep;
        }
        if(in_array("AdvisorSeller", $expval))
        {
            $schema_insert .= $advisorCompanyString.$sep;
        }
        if(in_array("AdvisorBuyer", $expval))
        {
            $schema_insert .= $advisorAcquirerString.$sep;
        }
        if(in_array("Website", $expval))
        {
            //website
            $schema_insert .= $row[13].$sep;
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
                    $schema_insert .= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $hidemoreinfor)).$sep;
                }
                if(in_array("InvestmentDetails", $expval))
                {
                    $schema_insert .= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $row[18])).$sep; // InvestmentDetails
                }
                if(in_array("Link", $expval))
                {
                    if($row[19]!='')
                    {
                        $schema_insert .= $row[19].$sep; //Link
                    }else{
                        $schema_insert .= "".$sep; //Link
                    }
                }
                if(in_array("ReturnMultiple", $expval))
                {
                    $schema_insert .= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $investorStringMoreInfo)).$sep;
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
                                 $schema_insert .=$invIRRString.$sep;   // IRR
                             }
                             if(in_array("MoreInfo", $expval))
                             {
                                 $schema_insert .= $invmoreinfo.$sep; // MoreInfo Returns
                             }
                             if(in_array("CompanyValuation", $expval))
                             {
                                 $schema_insert .= $dec_company_valuation.$sep;  //company valuation
                             }                     
                             if(in_array("RevenueMultiple", $expval))
                             {
                                 $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
                             }                  
                             if(in_array("EBITDAMultiple", $expval))
                             {
                                 $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
                             }
                             if(in_array("PATMultiple", $expval))
                             {
                                 $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
                             }
                             if(in_array("PricetoBook", $expval))
                             {
                                 $schema_insert .= $price_to_book.$sep;  //price_to_book
                             }
                             if(in_array("Valuation", $expval))
                             {
                                 $schema_insert .= $row[23].$sep;  //Valuation
                             }
                             if(in_array("Revenue", $expval))
                             {
                                 $dec_revenue=$row[30];
                                 if($dec_revenue < 0 || $dec_revenue > 0){
                                     $schema_insert .= $dec_revenue.$sep;  //Revenue 
                                 }else{
                                     if($dec_company_valuation >0 && $dec_revenue_multiple >0){
                     
                                         $schema_insert .= number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', '').$sep;
                                     }
                                     else{
                                         $schema_insert .= ''.$sep;
                                     }
                                 }
                             }
                             if(in_array("EBITDA", $expval))
                             {
                                 $dec_ebitda=$row[31];
                                 if($dec_ebitda < 0 || $dec_ebitda > 0){
                                     $schema_insert .= $dec_ebitda.$sep;  //EBITDA 
                                 }else{
                                     if($dec_company_valuation >0 && $dec_ebitda_multiple >0){
                     
                                         $schema_insert .= number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '').$sep;
                                     }
                                     else{
                                         $schema_insert .= ''.$sep;
                                     }
                                 }
                             }
                             if(in_array("PAT", $expval))
                             {
                                 $dec_pat=$row[32];
                                 if($dec_pat < 0 || $dec_pat > 0){
                                     $schema_insert .= $dec_pat.$sep;  //PAT 
                                 }else{
                                     if($dec_company_valuation >0 && $dec_pat_multiple >0){
                     
                                         $schema_insert .= number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', '').$sep;
                                     }
                                     else{
                                         $schema_insert .= ''.$sep;
                                     }
                                 }
                             }
                             if(in_array("BookValuePerShare", $expval))
                             {
                                 $schema_insert .= $book_value_per_share.$sep;  //book_value_per_share
                             }
                             if(in_array("PricePerShare", $expval))
                             {
                                 $schema_insert .= $price_per_share.$sep;  //price_per_share
                             }
                            //  if(in_array("LinkforFinancials", $expval))
                            //  {
                            //      $schema_insert .= $row[24].$sep;  //Financial link
                            //  }
                   


	     $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert .= ""."\n";
 		//following fix suggested by Josue (thanks, Josue!)
 		//this corrects output in excel when table fields contain \n or \r
 		//these two characters are now replaced with a space
 		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
         $schema_insert .= "\t";
        
         
           
                print($schema_insert);
           //  print(trim($schema_insert));
         
         print "\n";
     }
    print "\n";
    print "\n";
    print "\n";
    print "\n";
    print "\n";
    echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
    print("\n");
    print("\n");
    }
mysql_close();
    mysql_close($cnx);
    ?>


