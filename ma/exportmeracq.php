<?php include_once("../globalconfig.php"); ?>
<?php
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
    //session_start();
    include ('machecklogin.php');     
    //Check Session Id 
    $sesID=session_id();
    $emailid=$_SESSION['MAUserEmail'];
    $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='MA'";
    $resUserLogSel = mysql_query($sqlUserLogSel);
    $cntUserLogSel = mysql_num_rows($resUserLogSel);
    if ($cntUserLogSel > 0){
        $resUserLogSel = mysql_fetch_array($resUserLogSel);
        $logSessionId = $resUserLogSel['sessionId'];
        if ($logSessionId != $sesID){
            header( 'Location: logoff.php?value=caccess' ) ;
        }
    }
        
    function updateDownload($res){
        //Added By JFR-KUTUNG - Download Limit
        $recCount = mysql_num_rows($res);
        $dlogUserEmail = $_SESSION['MAUserEmail'];
        $today = date('Y-m-d');

        //Check Existing Entry
        $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='MA' AND `downloadDate` = CURRENT_DATE";
        $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
        $rowSelCount = mysql_num_rows($sqlSelResult);
        $rowSel = mysql_fetch_object($sqlSelResult);
        $downloads = $rowSel->recDownloaded;

        if ($rowSelCount > 0){
            $upDownloads = $recCount + $downloads;
            $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='MA' AND `downloadDate` = CURRENT_DATE";
            $resUdt = mysql_query($sqlUdt) or die(mysql_error());
        }else{
            $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','MA','".$recCount."')";
            mysql_query($sqlIns) or die(mysql_error());
        }
    }
        
    $acquirerId=trim($_POST['txthideacquirerId']);
        
    //include('onlineaccount.php');
    $displayMessage="";
    $mailmessage="";

    //  global $LoginAccess;
    //  global $LoginMessage;
    $TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

    $submitemail=$_POST['txthideemail'];
    $hidesearchon=$_POST['txtsearchon'];
    $hideindustry=$_POST['txthideindustry'];
    $hideindustryvalue=$_POST['txthideindustryvalue'];
    $rangeText=$_POST['txthiderange'];
    $datevalue=$_POST['txthidedate'];
                    //echo "<Br>****".$datevalue;

    $targetcompanysearch=$_POST['txthidecompany'];

    //echo "<Br>***".$targetcompanysearch;
    if(($targetcompanysearch!=="_") && ($targetcompanysearch!==""))
    {   $splitString=explode("_", $targetcompanysearch);
            $splitString1=$splitString[0];
            $splitString2=$splitString[1];
            if($splitString2!="")
                    $targetcompanysearch=$splitString1. " " .$splitString2;
            else
                    $targetcompanysearch=$splitString1;
    }
    //echo "<br>--".$targetcompanysearch;

    $sectorsearch=$_POST['txthidesector'];
                                       
    $advisorsearch_legal=$_POST['txthideadvisor_legal'];
    $advisorsearch_legal =ereg_replace("-"," ",$advisorsearch_legal);
    $advisorsearch_trans=$_POST['txthideadvisor_trans'];
    $advisorsearch_trans =ereg_replace("-"," ",$advisorsearch_trans);

    $acquirersearch=$_POST['txthideacquirer'];
    if(($acquirersearch!=="_") && ($acquirersearch!==""))
    {   $splitString=explode("_", $acquirersearch);
            $splitString1=$splitString[0];
            $splitString2=$splitString[1];
            if($splitString2!="")
                    $targetaquirersearch=$splitString1. " " .$splitString2;
            else
                    $targetaquirersearch=$splitString1;
    }
                                                            
    $searchallfield=$_POST['txthidesearchallfield'];
    $searchallfield =ereg_replace("-"," ",$searchallfield);
    $dealtype=$_POST['txthidedealtype'];
    $dealtypevalue=$_POST['txthidedealtypevalue'];
    $SPVvalue=$_POST['txthideSPV'];
    if($SPVvalue ==1)
            $projecttypename="Entity";
    elseif($SPVvalue ==2)
            $projecttypename="Project / Asset";
    else
            $projecttypename="";

    //       echo "<br>^^^^".$SPVvalue;
    $hiderangeStartValue=$_POST['txthiderangeStartValue'];
    $hiderangeEndValue=$_POST['txthiderangeEndValue'];
    $hidedateStartValue=$_POST['txthidedateStartValue'];
    $hidedateEndValue=$_POST['txthidedateEndValue'];
    $dateValue=$_POST['txthidedate'];
    $submitpassword=$_POST['txtemailpassword'];
    $targetCountryId=$_POST['txttargetcountry'];
    $acquirerCountryId=$_POST['txtacquirercountry'];
    $target_comptype=$_POST['txthidetargetcomptype'];
    $acquirer_comptype=$_POST['txthideacquirercomptype'];
    
    if($_SESSION['MA_industries']!=''){

        $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['MA_industries'].') ';
    }

    $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
    
    if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){
        $txthideMAMA = ' AND pe.MAMAId IN ('.$_POST[ 'export_checkbox_enable' ].') ';
        
    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){
        $txthideMAMA = ' AND pe.MAMAId NOT IN ('.$_POST[ 'txthidepe' ].') ';
        
    }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){
        $txthideMAMA = ' AND pe.MAMAId NOT IN ('.$_POST[ 'txthidepe' ].') ';
    }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){
        $txthideMAMA = ' AND pe.MAMAId IN ('.$_POST[ 'export_checkbox_enable' ].') ';
    }else{
        $txthideMAMA = '';
    }
    
    // echo $txthideMAMA;
    // exit();

    if (($hideindustry == "") && ($dealtype == "--") &&  ($target_comptype == "--") && ($acquirer_comptype == "--") &&($SPVvalue == "") && ($hiderangeStartValue == "--") && ($hiderangeEndValue == "--") && (($hidedateStartValue != "--") && ($hidedateEndValue != "--")) && ($targetCountryId == "--") && ($acquirerCountryId == "--"))
    {
        
        $companysqlFinal="SELECT DISTINCT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT
        FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
        WHERE  md.MADealTypeId=pe.MADealTypeId and DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and i.industryid=pec.industry 
        and pec.PEcompanyID = pe.PECompanyID and c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId $comp_industry_id_where
        and pe.Deleted=0 ".$txthideMAMA." order by companyname";
    }
    else if($targetaquirersearch!="")
    {
        $acquirerId=trim($_POST['txthideacquirerId']);
        $companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT
        FROM
        mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
        WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
        AND pec.PEcompanyID = pe.PECompanyID
        and ac.AcquirerId = pe.AcquirerId
        and c.CountryId=pec.countryid AND pe.Deleted =0
        $comp_industry_id_where  AND (ac.AcquirerId IN ($acquirerId)) ".$txthideMAMA." order by companyname ";
            //echo "<br> Acquirer search- ".$companysqlFinal;
    }
    elseif($advisorsearch_legal!="")
    {
        $companysqlFinal="(SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT,
        cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId
        FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md,
        advisor_cias AS cia,mama_advisoracquirer AS adac
        where DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
        AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 $comp_industry_id_where and
        c.CountryId=pec.countryId
         and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='L' and cia.cianame LIKE '$advisorsearch_legal')
        UNION
        (SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT,
        cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId
        FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md,
        advisor_cias AS cia,mama_advisorcompanies AS adac
        where DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
        AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 $comp_industry_id_where and
        c.CountryId=pec.countryId
        and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='L' and cia.cianame LIKE '$advisorsearch_legal')
        order by Target_Company";
        //  echo "<br> Advisor  search- ".$companysqlFinal;
    }
    elseif($advisorsearch_trans!="")
    {
        $companysqlFinal="(SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT,
        cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId
        FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md,
        advisor_cias AS cia,mama_advisoracquirer AS adac
        where DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
        AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 $comp_industry_id_where and
        c.CountryId=pec.countryId
         and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='T' and cia.cianame LIKE '$advisorsearch_trans')
        UNION
        (SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT,
        cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId
        FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md,
        advisor_cias AS cia,mama_advisorcompanies AS adac
        where DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
        AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 $comp_industry_id_where and
        c.CountryId=pec.countryId
         and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='T' and cia.cianame LIKE '$advisorsearch_trans')
        order by Target_Company";
        //  echo "<br> Advisor  search- ".$companysqlFinal;
    }               
    elseif ($targetcompanysearch != "")
    {
        $targetCompanyId=trim($_POST['txthidecompanyId']);

        $companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT
        FROM
        mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
        WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
        AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
        and c.CountryId=pec.countryid
        AND pe.Deleted =0 $comp_industry_id_where " .$addVCFlagqry.
        " AND (pec.PECompanyId IN ($targetCompanyId)) ".$txthideMAMA."
        order by companyname";

        $fetchRecords=true;
        $fetchAggregate==false;
        //  echo "<br>Query for company search";
        //  echo "<Br>***".$targetcompanysearch;
        // echo "<br> Company search--" .$companysqlFinal;
    }
    elseif (($sectorsearch!=="_") && ($sectorsearch!==""))
    {
        $targetsectorsearch=stripslashes(trim($_POST['txthidesector']));
        $targetsectorsearch = str_replace("_"," ",$targetsectorsearch);

        $sectorsearchArray = explode(",", str_replace("'","",$targetsectorsearch)); 
        $sector_sql = array(); // Stop errors when $words is empty

        foreach($sectorsearchArray as $word){

        // $sector_sql[] = " sector_business LIKE '$word%' ";
            $word = trim($word);
            $sector_sql[] = " sector_business = '$word' ";
            $sector_sql[] = " sector_business LIKE '$word(%' ";
            $sector_sql[] = " sector_business LIKE '$word (%' ";
        }
        $sector_filter = implode(" OR ", $sector_sql);

        if ($dealtype!= "--" && $dealtype!= "")
        {
            $wheredealtype = " And pe.MADealTypeId IN (" .$dealtype.") ";
        }else{
            $wheredealtype = '';
        }
                                            
        $companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT
        FROM
        mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
        WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
        AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
        and c.CountryId=pec.countryid".$wheredealtype."
        AND pe.Deleted =0 $comp_industry_id_where " .$addVCFlagqry.
        " AND ($sector_filter) ".$txthideMAMA."
        order by companyname";

        $fetchRecords=true;
        $fetchAggregate==false;
        //  echo "<br>Query for company search";
        //  echo "<Br>***".$targetcompanysearch;
        // echo "<br> Company search--" .$companysqlFinal;
    }
    elseif (trim($searchallfield != ""))
    {
        $searchallfield=$_POST['txthidesearchallfield'];
        $searchExplode = explode( '_', $searchallfield );

        foreach( $searchExplode as $searchFieldExp ) {
                                   
            $companyLike .= "pec.companyname REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
            $sectorLike .= "sector_business REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
            $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
            $investorLike .= "ac.Acquirer REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
        }
        
        $companyLike = '('.trim($companyLike,'AND ').')';
        $sectorLike = '('.trim($sectorLike,'AND ').')';
        $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
        $investorLike = '('.trim($investorLike,'AND ').')';
        
        //$tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%' or pec.tags REGEXP '[[.colon.]]$searchallfield$' or pec.tags REGEXP '[[.colon.]]$searchallfield,'";
        $tagsval =  $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike;
        
        $companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT
        FROM
        mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
        WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
        AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
        and c.CountryId=pec.countryid
        AND pe.Deleted =0 $comp_industry_id_where " .$addVCFlagqry.
        " AND ($tagsval) 
        ".$txthideMAMA." order by companyname";

        $fetchRecords=true;
        $fetchAggregate==false;
        
    //                   echo "<br> Company search--" .$companysqlFinal;
    //                                         exit;
    }
    elseif (($hideindustry > 0) || ($dealtype != "--") ||  ($target_comptype!="--") || ($acquirer_comptype!="--") ||($SPVvalue > 0) || ($hiderangeStartValue !="--") || ($hiderangeEndValue != "--") || (($hidedateStartValue != "--") && ($hidedateEndValue!="--")) || ($targetCountryId!="--") || ($acquirerCountryId!="--"))
    {
        $txthidevaluation = $_REQUEST['txthidevaluation'];
                                             
        $companysql = "SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
        ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
        pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
        sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
        DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
        pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
        Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT
        FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
        where     ".$txthidevaluation."     md.MADealTypeId=pe.MADealTypeId and ";

        $wheretargetcomptype="";
        $whereacquirercomptype="";
        $whereSPVCompanies="";
        if ($hideindustry != '') {
            $inSql = '';
            $industry1 = explode(',',$hideindustry);
            foreach($industry1 as $industrys)
        {
                $inSql .= " pec.industry= '".$industrys."' or ";
        }
            $inSql = trim($inSql,' or ');
            if($inSql !=''){
                $whereind=  ' ( '.$inSql.' ) ';
            }
        }
        if ($dealtype!= "--" && $dealtype!= "")
        {
                $wheredealtype = " pe.MADealTypeId IN (" .$dealtype.") ";
        }

        if($target_comptype!="--")
                $wheretargetcomptype= " pe.target_listing_status='$target_comptype'";
        if($acquirer_comptype!="--")
                $whereacquirercomptype= " pe.acquirer_listing_status='$acquirer_comptype'";

         if($SPVvalue==1)
                           $whereSPVCompanies=" pe.Asset=0";
                    elseif($SPVvalue==2)
                           $whereSPVCompanies=" pe.Asset=1";
       // echo "<br>********" .$whereSPVCompanies;
        $whererange ="";

        if (($hiderangeStartValue!= "--") && ($hiderangeEndValue != ""))
        {

            if($hiderangeStartValue == $hiderangeEndValue)
            {
                    $whererange = " pe.Amount = ".$hiderangeStartValue ."";
            }
            elseif($hiderangeStartValue < $hiderangeEndValue)
            {
                    $whererange = " pe.Amount between  ".$hiderangeStartValue ." and ". $hiderangeEndValue ."";
            }
                //echo "<br>-- ".$whererange;
        }
        if ($targetCountryId != '') {
            $inSql = '';
            $targetCountryId1 = explode(',',$targetCountryId);
            foreach($targetCountryId1 as $targetCountryIds)
        {
                $inSql .= " pec.countryId='" .$targetCountryIds. "' or ";
        }
            $inSql = trim($inSql,' or ');
            if($inSql !=''){
                $wheretargetCountry=  ' ( '.$inSql.' ) ';
            }
        }
        if ($acquirerCountryId != '') {
            $inSql = '';
            $acquirerCountryId1 = explode(',',$acquirerCountryId);
            foreach($acquirerCountryId1 as $acquirerCountryIds)
        {
                $inSql .= " ac.countryId='" .$acquirerCountryIds. "' or ";
            }
            $inSql = trim($inSql,' or ');
            if($inSql !=''){
                $whereacquirerCountry=  ' ( '.$inSql.' ) and c.countryid=ac.countryid ';
            }
        }
        if($datevalue!="---to---")
        {
                $wheredates= " DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
        }
        else
        {
                $wheredates="";
        }

        if ($whereind != "")
        {
                $companysql=$companysql . $whereind ." and ";
                $bool=true;
        }
        if (($wheredealtype != ""))
        {
                $companysql=$companysql . $wheredealtype . " and " ;
                $bool=true;
        }
        if($wheretargetcomptype!="")
                 $companysql=$companysql .$wheretargetcomptype . " and ";

        if($whereacquirercomptype!="")
                 $companysql=$companysql .$whereacquirercomptype . " and ";
         if (($whereSPVCompanies != "") )
                    {
                            $companysql=$companysql .$whereSPVCompanies . " and ";
                            $bool=true;
                    }
        if (($whererange != "") )
        {
                $companysql=$companysql .$whererange . " and ";
                $bool=true;
        }
        if($wheretargetCountry!="")
        {
                $companysql=$companysql .$wheretargetCountry . " and ";
        }
        //  echo "<br>-###" .$wheredates;
        if($wheredates !== "")
        {
        //  echo "<bR>----------".$wheredates;
                $companysql = $companysql . $wheredates ." and ";
                $bool=true;
        }
        $companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
        and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
        $comp_industry_id_where and pe.Deleted=0 ".$txthideMAMA." order by companyname ";
        if($whereacquirerCountry!="")
        {
                $companysql=$companysql .$whereacquirerCountry. " and ";
        //  echo "<br>".$companysql;
                $companysqlFinal = $companysql . " i.industryid=pec.industry
                and  pec.PEcompanyID = pe.PECompanyID
                and  ac.AcquirerId = pe.AcquirerId
                $comp_industry_id_where and pe.Deleted=0 ".$txthideMAMA." order by companyname ";
        }


        $fetchRecords=true;
        $fetchAggregate==false;
        //echo "<br><br>WHERE CLAUSE SQL---" .$companysqlFinal;
    }
    else
    {
        //echo "<br> INVALID DATES GIVEN ";
        $fetchRecords=false;
        $fetchAggregate==false;
    }

//mail sending
//echo $companysqlFinal; exit;
//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
//      {
    $insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,industry,dealtype,period,dealrange,companysearch,advisorsearch_legal,advisorsearch_trans,acquirersearch,targetcountry,acquirercountry,target_listing_status,acquirer_listing_status)
        values('$submitemail','MA','MAMA','$hideindustryvalue','$dealtypevalue','$datevalue','$rangeText','$companysearch','$advisorsearch_legal','$advisorsearch_trans','$acquirersearch','$targetCountryId','$acquirerCountryId','$target_comptype','$acquirer_comptype')";

      if ($rsinsert_download = mysql_query($insert_downloadlog_sql))
      {
        //echo "<br>***".$insert_downloadlog_sql;
      }

    $checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM malogin_members AS dm,
                    dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND dm.EmailId='$submitemail' AND dc.Deleted =0";

        if ($totalrs = mysql_query($checkUserSql))
        {
            $cnt= mysql_num_rows($totalrs);

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
                        if($searchtitle==0)
                        {
                                $searchdisplay="PE Deals";
                        }
                        elseif($searchtitle==1)
                        {
                                $searchdisplay="VC Deals";
                        }
                        elseif($searchtitle==2)
                        {
                                $searchdisplay="Real Estate";
                        }
                        else
                                $searchdisplay="";
                        
                        if($hidesearchon==1)
                        {
                                $subject="Send Excel Data: Investments - $searchdisplay";
                                $message="<html><center><b><u> Send Investment : $searchdisplay - $submitemail</u></b></center><br>
                                <head>
                                </head>
                                <body >
                                <table border=1 cellpadding=0 cellspacing=0  width=74% >
                                <tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
                                <tr><td width=1%>Industry </td><td width=99%>$hideindustryvalue</td></tr>
                                <tr><td width=1%>Stage</td><td width=99%>$hidestage</td></tr>
                                <tr><td width=1%>Investment Type</td><td width=99%>$invtypevalue</td></tr>
                                <tr><td width=1%>Range</td><td width=99%>$rangeText</td></tr>
                                <tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
                                <tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
                                <tr><td width=1%>Company/Sector</td><td width=99%>$companysearch</td></tr>
                                <td width=29%> $CloseTableTag</td></tr>
                                </table>
                                </body>
                                </html>";
                        }
                        elseif($hidesearchon==2)
                        {
                            $subject="Send Excel Data: IPO - $searchdisplay";
                            $message="<html><center><b><u> Send IPO Data: $searchdisplay to - $submitemail</u></b></center><br>
                            <head>
                            </head>
                            <body >
                            <table border=1 cellpadding=0 cellspacing=0  width=74% >
                            <tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
                            <tr><td width=1%>Industry </td><td width=99%>$hideindustryvalue</td></tr>
                            <tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
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
                            $subject="Send Excel Data : M&A - $searchdisplay ";
                            $message="<html><center><b><u> Send M&A Data :$searchdisplay to - $submitemail</u></b></center><br>
                            <head>
                            </head>
                            <body >
                            <table border=1 cellpadding=0 cellspacing=0  width=74% >
                            <tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
                            <tr><td width=1%>Industry </td><td width=99%>$hideindustryvalue</td></tr>
                            <tr><td width=1%>Deal Type </td><td width=99%>$dealtype</td></tr>
                            <tr><td width=1%>Project Type </td><td width=99%>$projecttypename</td></tr>
                            <tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
                            <tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
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
                            <tr><td width=1%>Industry </td><td width=99%>$hideindustryvalue</td></tr>
                            <tr><td width=1%>Deal Type </td><td width=99%>$dealtypevalue</td></tr>
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
                        mail($to,$subject,$message,$headers);
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

    $sql=$companysqlFinal;
//  echo "<br>---" .$sql;
//    exit();
    //execute query
    $result = @mysql_query($sql) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
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
    
 //header info for browser: determines file type ('.doc' or '.xls')
    
  header("Content-Type: application/$file_type");
    header("Content-Disposition: attachment; filename=M&A_Report.$file_ending");
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
    print("\n");
    echo "Target in () indicates sale of asset rather than the company. Target in {} indicates a minority stake acquisition.";
    print("\n");
    print("\n");*/
    
    //define separator (defines columns in excel & tabs in word)
    
    $sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields

    echo "Target_Company"."\t";
    echo "Target_Company Type"."\t";
    echo "Acquirer"."\t";
    echo "Acquirer_Company Type"."\t";
    echo "Industry_Target"."\t";
    echo "Sector_Target"."\t";
    echo "Amount (US\$M)"."\t";
    echo "Stake (%)"."\t";
    echo "Deal Date"."\t";
    echo "Type"."\t";

    echo "Advisor_Target"."\t";
    echo "Advisor_Acquirer"."\t";
    echo "City_Target"."\t";
    echo "Country_Target"."\t";
    echo "Industry_Acquirer"."\t";
    echo "Group_Acquirer"."\t";
    echo "City_Acquirer"."\t";
    echo "Country_Acquirer"."\t";
    echo "Website_Target"."\t";
    echo "More Information"."\t";
    echo "Link"."\t";

    echo "Company Valuation-Enterprise Value(INR Cr)"."\t";
    echo "Revenue Multiple(based on EV)"."\t";
    echo "EBITDA Multiple(based on EV)"."\t";
    echo "PAT Multiple(based on EV)"."\t";
    echo "Valuation (More Info)"."\t";
    echo "Revenue(INR Cr)"."\t";
    echo "EBITDA (INR Cr)"."\t";
    echo "PAT (INR Cr)"."\t";
    echo "Link for Financials"."\t";
    
    /*print("\n");*/
    print("\n");
    //end of printing column names

    //start while loop to get data
    /*
    note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
    */
    while($row = mysql_fetch_row($result))
    {
        $searchString="Undisclosed";
        $searchString=strtolower($searchString);
        $searchStringDisplay="Undisclosed";

        $searchString1="Unknown";
        $searchString1=strtolower($searchString1);
        $searchString1Display="Unknown";

        $searchString2="Others";
        $searchString2=strtolower($searchString2);
        $searchString2Display="Others";

        $searchString3="Individual";
        $searchString3=strtolower($searchString3);
        $searchString3ForDisplay="Individual";


        $searchString4="PE Firm(s)";
        $searchString4ForDisplay="PE Firm(s)";
        $searchString4=strtolower($searchString4);

        $schema_insert = "";
        $MAMAId=$row[2];
        $AcquirerId=$row[4];
        $PECompanyId=$row[0];

        $companyName=$row[9];
        $companyName=strtolower($companyName);
        $compResult=substr_count($companyName,$searchString);
        $compResult1=substr_count($companyName,$searchString1);

        $acquirerName=$row[10];
        $acquirerName=strtolower($acquirerName);
        $compResultAcquirer=substr_count($acquirerName,$searchString4);
        $compResultAcquirer1=substr_count($acquirerName,$searchString);
        $compResultAcquirer3=substr_count($acquirerName,$searchString3);

        $target_listing_status_display="";
        $acquirer_listing_status_display="";

               if($row[27]=="L")
             $target_listing_status_display="Listed";
                elseif($row[27]=="U")
             $target_listing_status_display="Unlisted";

                if($row[28]=="L")
             $acquirer_listing_status_display="Listed";
                elseif($row[28]=="U")
             $acquirer_listing_status_display="Unlisted";

        if(($compResult==0) && ($compResult1==0))
            $comp=$row[9];
        else
            $comp=$searchStringDisplay;

        if ($row[6] == 1) {     
            $openBracket = "(";
            $closeBracket = ")";
        } else {
            $openBracket = "";
            $closeBracket = "";
        }
        
        if ($row[29] == 1) {          
            $openDebtBracket = "{";
            $closeDebtBracket = "}";
        } else {
            $openDebtBracket = "";
            $closeDebtBracket = "";
        }               

        //echo $compResult;
        if ($comp!="") {
            //echo "<BR>--- ".$openBracket;
            $schema_insert .= $openBracket . $openDebtBracket . $comp . $closeDebtBracket . $closeBracket . $sep;
        } else {
            $schema_insert .= "".$sep;
        }
                
        if($target_listing_status_display!="")
            $schema_insert .= $target_listing_status_display.$sep;
        else
            $schema_insert .= "".$sep;
                
        if(($compResultAcquirer==0) && ($compResultAcquirer1==0) && ($compResultAcquirer3==0) )
                $acquirerDisplay=$row[10];
        elseif($compResultAcquirer==1)
                $acquirerDisplay=$searchString4ForDisplay;
        elseif($compResultAcquirer1==1)
                $acquirerDisplay=$searchStringDisplay;
        elseif($compResultAcquirer3==1)
                $acquirerDisplay=$searchString3ForDisplay;
                
        if($acquirerDisplay!="")
            $schema_insert .= $acquirerDisplay.$sep;
        else
            $schema_insert .= "".$sep;

        if($acquirer_listing_status_display!="")
            $schema_insert .= $acquirer_listing_status_display.$sep;
        else
            $schema_insert .= "".$sep;
       
        for($j=11; $j<17;$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            if($row[$j] != "")
            {
                if(($j==13))
                {
                    if($row[$j]<=0)
                        {$schema_insert .= "".$sep;}
                    elseif(($row[$j]>0) && ($row[22]==1))
                        {$schema_insert .= "".$sep;}
                    else
                        {$schema_insert .= "$row[$j]".$sep;}
                }
                elseif(($j==14))
                {
                    if($row[$j]<=0)
                        {$schema_insert .= "".$sep;}
                    else
                        {$schema_insert .= "$row[$j]".$sep;}
                }
                else{
                       $schema_insert .= "$row[$j]".$sep;
                }

            }
            else{
                    $schema_insert .= "".$sep;
            }
        }


    //Deal Date
    // $schema_insert .= $row[15].$sep;
    //dealType
    // $schema_insert .= $row[16].$sep;

       $mama_advisorTargetSql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisorcompanies as advcomp,
                advisor_cias as cia where advcomp.MAMAId=$MAMAId and advcomp.CIAId=cia.CIAId";
        
        $targetString="";
        if($resultTarget = mysql_query($mama_advisorTargetSql))
        {
            
            while($rowTarget = mysql_fetch_array($resultTarget))
            {
                $targetString=$targetString.",".$rowTarget[2]."(".$rowTarget[3].")";
            }
            $targetString=substr_replace($targetString, '', 0,1);
        }
        
        if($targetString!="")
        {
            $schema_insert .= $targetString.$sep;
        }
        else
        {
            $schema_insert .= "".$sep;
        }

        $mama_advisoracquirerSql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisoracquirer as advcomp,
            advisor_cias as cia where advcomp.MAMAId=$MAMAId and advcomp.CIAId=cia.CIAId";
        
        $acquirerString="";
        if($result1 = mysql_query($mama_advisoracquirerSql))
        {   
            while($row1 = mysql_fetch_array($result1))
            {
                $acquirerString=$acquirerString.",".$row1[2]."(".$row1[3].")";
            }
            $acquirerString=substr_replace($acquirerString, '', 0,1);
        }

        if($acquirerString!="")
        {
           $schema_insert .= $acquirerString.$sep;
        }
        else
        {
           $schema_insert .= "".$sep;
        }

        $targetCityCountrySql="select pe.city,pe.CountryId,co.Country from pecompanies as pe,country as co where pe.PECompanyId=$PECompanyId and co.CountryId=pe.CountryId";
         // echo "<bR>---" .$targetCityCountrySql;
        $targetCity="";$targetCountry="";
        if($targetrs=mysql_query($targetCityCountrySql))
        {
            while($targetrow=mysql_fetch_array($targetrs))
            {
                $targetCity=$targetrow[0];
                $targetCountry=$targetrow[2];
            }
        }
           
        if($targetCity!="")
        {
            $schema_insert .= $targetCity.$sep;
        }
        else
        {
            $schema_insert .= "".$sep;
        }
        
        if($targetCountry!="")
        {
            $schema_insert .= $targetCountry.$sep;
        }
        else
        {
            $schema_insert .= "".$sep;
        }
        
       $acquirerCityCountrySql="select ac.CityId,ac.CountryId,co.Country,ac.IndustryId,i.industry,ac.Acqgroup,ac.Acquirer from acquirers as ac,country as co,industry as i where ac.AcquirerId=$AcquirerId and co.CountryId=ac.CountryId and i.industryid=ac.IndustryId";

        if($acquirerrs=mysql_query($acquirerCityCountrySql))
        {
            while($acquirerrow=mysql_fetch_array($acquirerrs))
            {
                $acquirerCity=$acquirerrow[0];
                $acquirerCountry=$acquirerrow[2];
                $acquirerIndustry=$acquirerrow[4];
                $acquirergroup=$acquirerrow[5];
            }
        }
        //acquirerIndustry
        if($acquirerIndustry!="")
        {
            $schema_insert .= $acquirerIndustry.$sep;
        }
        else
        {
            $schema_insert .= "".$sep;
        }
        //acquirergroup
        if($acquirergroup!="")
        {
            $schema_insert .= $acquirergroup.$sep;
        }
        else
        {
            $schema_insert .= "".$sep;
        }
        //acquirerCity
        if($acquirerCity!="")
        {
            $schema_insert .= $acquirerCity.$sep;
        }
        else
        {
            $schema_insert .= "".$sep;
        }
        //acquirerCountry
        if($acquirerCountry!="")
        {
            $schema_insert .= $acquirerCountry.$sep;
        }
        else
        {
            $schema_insert .= "".$sep;
        }
                
        if($row[17]!="")
            $schema_insert .= $row[17].$sep; //website
        else
             $schema_insert .= "".$sep; 

        if($row[18]!="")
        {
            $res = str_replace( array( '\'', '"',
            ',' , ';', '<', '>','$' ), ' ',  $row[18]);

            $schema_insert .= $res.$sep; //moreinfor
        }
        else
        {
            $schema_insert .= "".$sep; 
        }

                if($row[20]!="")
                    $schema_insert .= $row[20].$sep;    //Link
        else
             $schema_insert .= "".$sep; 

        ////    pls check the header and hardcode the headers instead of fetching the column name
            $dec_company_valuation=$row[23];
        if ($dec_company_valuation <=0)
            $dec_company_valuation="";

            $dec_revenue_multiple=$row[24];
        if($dec_revenue_multiple<=0)
            $dec_revenue_multiple="";

            $dec_ebitda_multiple=$row[25];
        if($dec_ebitda_multiple<=0)
            $dec_ebitda_multiple="";

            $dec_pat_multiple=$row[26];
        if($dec_pat_multiple<=0)
           $dec_pat_multiple="";
            
        $schema_insert .= $dec_company_valuation.$sep;  //company valuation
        $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
        $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
        $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
            $schema_insert .= $row[21].$sep;    //Valuation

            
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
           $schema_insert .= $row[22].$sep;    //Lin for Financial
         //     $schema_insert .= $row[22].$sep;  //hideamount column in sqlquery*/

        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert .= ""."\n";
                //following fix suggested by Josue (thanks, Josue!)
                //this corrects output in excel when table fields contain \n or \r
                //these two characters are now replaced with a space
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }
    print("\n");
    print("\n");
    print("\n");
    print("\n");
    echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
    print("\n");
    print("\n");
    echo "Target in () indicates sale of asset rather than the company. Target in {} indicates a minority stake acquisition.";
    print("\n");
    print("\n");
mysql_close();
//      }
//else
//  header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
?>