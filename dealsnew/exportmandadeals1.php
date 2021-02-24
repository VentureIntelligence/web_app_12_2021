<?php include_once("../globalconfig.php"); ?>
<?php
    // session_save_path("/tmp");
    // session_start();

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
    $exitstatusvalue=$_POST['txthideexitstatusvalue'];
    $hidedateStartValue=$_POST['txthidedateStartValue'];
    $hidedateEndValue=$_POST['txthidedateEndValue'];
    $dateValue=$_POST['txthidedate'];

    $hidetxtfrm=$_POST['txthideReturnMultipleFrm'];
    $hidetxtto=$_POST['txthideReturnMultipleTo'];

    $keyword=$_POST['txthideinvestor'];
    $investorString=$_POST['txthideInvestorString'];
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
    $sectorsearch=$_POST['txthidesectorsearch'];
    $sectorsearch =stripslashes(ereg_replace("_"," ",$sectorsearch));
    $acquirersearch=$_POST['txthideacquirer'];
    $advisorsearch_legal=$_POST['txthideadvisor_legal'];
    $advisorsearch_legal =ereg_replace("_"," ",$advisorsearch_legal);
    $advisorsearch_trans=$_POST['txthideadvisor_trans'];
    $advisorsearch_trans =ereg_replace("_"," ",$advisorsearch_trans);
    $searchallfield=$_POST['txthidesearchallfield'];
    $searchallfield =ereg_replace("-"," ",$searchallfield);

    //$addhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=0 ";
    $addhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=".$hide_pms;

    $submitemail=$_POST['txthideemail'];

    $tsjtitle="� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

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

    $addhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=".$var_hideforexit;

    if (($keyword == "") && ($companysearch=="") && ($sectorsearch=="") &&  ($searchallfield=="")  && ($acquirersearch=="") && ($advisorsearch_legal=="") && ($advisorsearch_trans=="") && ($industry =="--") && ($InTypes =="")  && ($dealtype=="--") && ($invType == "--") && ($exitstatusvalue=="--") &&($hidedateStartValue == "------01") && ($hidedateEndValue == "------01"))
    {
        $companysql = "SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId,pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname, i.industry, pec.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        DealAmount, website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
        FROM
        manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it
        WHERE pec.industry = i.industryid and dt.DealTypeId=pe.DealTypeId and it.InvestorType=pe.InvestorType
        AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15" .$addVCFlagqry .$addhide_pms_qry .$addDelind.
        " order by companyname";

                            //	echo "<br>3 Query for All records" .$companysql;
    }
    elseif ($companysearch != "")
    {
        $companysql="SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname, i.industry, sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
        FROM
        manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and  it.InvestorType=pe.InvestorType
        and pec.PEcompanyID = pe.PECompanyID
        AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.$addhide_pms_qry .$addDelind.
        " AND pec.PECompanyId IN ($companysearch)  
        order by companyname"; 
        //	echo "<br>Query for company search";
        //	 echo "<br> Company search--" .$companysql;
    }
    elseif ($sectorsearch != "")
    {
                            
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

        $companysql="SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname, i.industry, sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
        FROM
        manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and  it.InvestorType=pe.InvestorType
        and pec.PEcompanyID = pe.PECompanyID
        AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.$addhide_pms_qry .$addDelind.
        " AND  ($sector_filter) 
        order by companyname";
        
        //	echo "<br>Query for company search";
        //	 echo "<br> Company search--" .$companysql;
    }
    elseif($keyword!="") 
    {
        $companysql="select pe.MandAId,pe.MandAId,pe.PECompanyId,c.industry,pe.DealTypeId,pe.AcquirerID,peinv_inv.InvestorId,
        c.companyname,i.industry,sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,c.website,MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,
        EstimatedIRR,MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
        FROM
        manda_investors as peinv_inv,
        peinvestors as inv,
        manda as pe,dealtypes as dt,
        pecompanies as c,industry as i,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'  and  
        pe.Deleted=0 and
        peinv_inv.MandAId=pe.MandAId and dt.DealTypeId=pe.DealTypeId and
        inv.InvestorId=peinv_inv.InvestorId and c.industry = i.industryid and it.InvestorType=pe.InvestorType
        and c.PECompanyId=pe.PECompanyId and c.industry != 15 " .$addVCFlagqry.$addhide_pms_qry  .$addDelind.
        " AND inv.InvestorId IN($keyword)  order by companyname";

        //echo "<br> Investor search- ".$companysql;
    }
    elseif($acquirersearch!="")
    {
        $companysql="SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId,c.industry,pe.DealTypeId,pe.AcquirerId,
        c.companyname,i.industry, sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,c.website,MoreInfor,hideamount,hidemoreinfor, ac.Acquirer,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
        FROM
        acquirers AS ac, manda AS pe, pecompanies AS c, industry AS i,dealtypes as dt ,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  ac.AcquirerId = pe.AcquirerId and dt.DealTypeId=pe.DealTypeId
        AND c.industry = i.industryid and pe.Deleted=0
        AND c.PECompanyId = pe.PECompanyId and it.InvestorType=pe.InvestorType
        AND c.industry !=15 " .$addVCFlagqry.$addhide_pms_qry .$addDelind.
        " AND ac.AcquirerId IN ($acquirersearch) 
        order by companyname ";
        //	echo "<Br>Acquirer search--" .$companysql;
    }
    elseif ($searchallfield != "")
    {
        $findTag = strpos($searchallfield,'tag:');
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
            }
        $companysql="SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname, i.industry, sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
        FROM
        manda AS pe,
        industry AS i,
        pecompanies AS pec,
        dealtypes as dt,
        investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and
        pec.PEcompanyID = pe.PECompanyID and it.InvestorType=pe.InvestorType
        AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.$addhide_pms_qry .$addDelind.
        " AND ( $tagsval )
        order by companyname";
        //echo "<br>Query for company search";
        //echo "<br> SEARCH FIELD search--" .$companysql;
        // exit;
    }
    elseif($advisorsearch_legal!="")
    {
            $companysql="(select pe.MandAId,pe.PECompanyId,c.industry,pe.DealTypeId,adac.CIAId AS AcqCIAId,cia.CIAId,pe.AcquirerId,
            c.companyname,i.industry,c.sector_business,
            dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
            pe.DealAmount,c.website,MoreInfor,hideamount,hidemoreinfor,cia.cianame,pe.InvestmentDeals,Link,
            EstimatedIRR,MoreInfoReturns, it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
            from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,
            peinvestments_advisoracquirer AS adac,acquirers as ac,dealtypes as dt,investortype as it
            where pe.Deleted=0 and
            c.industry=i.industryid
            and ac.AcquirerId=pe.AcquirerId and dt.DealType=pe.DealTypeId
            and c.PECompanyId=pe.PECompanyId and it.InvestorType=pe.InvestorType   and AdvisorType='L'
            and adac.CIAId=cia.CIAID " .$addVCFlagqry.$addhide_pms_qry .$addDelind.
            " AND adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearch_legal%')
            UNION
            (SELECT pe.MandAId, pe.PECompanyId,c.industry,pe.DealTypeId,adcomp.CIAId AS CompCIAId,cia.CIAId,pe.AcquirerId,
            c.companyname, i.industry, c.sector_business,
            dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
            pe.DealAmount,c.website,MoreInfor,hideamount,hidemoreinfor,
            cia.cianame,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,it.InvestorTypeName,
            Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
            FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
            peinvestments_advisorcompanies AS adcomp, acquirers AS ac,dealtypes as dt,investortype as it
            WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pe.Deleted=0 and
            c.industry = i.industryid
            AND ac.AcquirerId = pe.AcquirerId and dt.DealTypeId=pe.DealTypeId   and AdvisorType='L'
            AND c.PECompanyId = pe.PECompanyId  and it.InvestorType=pe.InvestorType
            AND adcomp.CIAId = cia.CIAID " .$addVCFlagqry.$addhide_pms_qry .$addDelind.
            " AND adcomp.PEId = pe.MandAId AND cianame LIKE '%$advisorsearch_legal%')
            ORDER BY companyname";
            //echo "<br>Advisor search-- " .$companysql;
    }
    elseif($advisorsearch_trans!="")
    {
        $companysql="(select pe.MandAId,pe.PECompanyId,c.industry,pe.DealTypeId,adac.CIAId AS AcqCIAId,cia.CIAId,pe.AcquirerId,
        c.companyname,i.industry,c.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,c.website,MoreInfor,hideamount,hidemoreinfor,cia.cianame,pe.InvestmentDeals,Link,
        EstimatedIRR,MoreInfoReturns, it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
        from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,
        peinvestments_advisoracquirer AS adac,acquirers as ac,dealtypes as dt,investortype as it
        where pe.Deleted=0 and
        c.industry=i.industryid
        and ac.AcquirerId=pe.AcquirerId and dt.DealType=pe.DealTypeId
        and c.PECompanyId=pe.PECompanyId and it.InvestorType=pe.InvestorType   and AdvisorType='T'
        and adac.CIAId=cia.CIAID " .$addVCFlagqry.$addhide_pms_qry .$addDelind.
        " AND adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearch_trans%')
        UNION
        (SELECT pe.MandAId, pe.PECompanyId,c.industry,pe.DealTypeId,adcomp.CIAId AS CompCIAId,cia.CIAId,pe.AcquirerId,
        c.companyname, i.industry, c.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
        pe.DealAmount,c.website,MoreInfor,hideamount,hidemoreinfor,
        cia.cianame,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,it.InvestorTypeName,
        Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple ,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
        FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
        peinvestments_advisorcompanies AS adcomp, acquirers AS ac,dealtypes as dt,investortype as it
        WHERE DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pe.Deleted=0 and
        c.industry = i.industryid
        AND ac.AcquirerId = pe.AcquirerId and dt.DealTypeId=pe.DealTypeId
        AND c.PECompanyId = pe.PECompanyId  and it.InvestorType=pe.InvestorType    and AdvisorType='T'
        AND adcomp.CIAId = cia.CIAID " .$addVCFlagqry.$addhide_pms_qry .$addDelind.
        " AND adcomp.PEId = pe.MandAId AND cianame LIKE '%$advisorsearch_trans%')
        ORDER BY companyname";
                //echo "<br>Advisor search-- " .$companysql;
    }
    elseif (($industry !='') || ($dealtype !='') || ($invType != "--") || ($InTypes != "") || ($exitstatusvalue!="--") || ($dateValue!="---to---") || (($hidetxtfrm>=0) && ($hidetxtto>0)))
    {

        $companysql = "SELECT DISTINCT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId,pec.industry,pe.DealTypeId,pe.AcquirerId,
        pec.companyname,i.industry,pec.sector_business,
        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate, pe.DealAmount,pec.website,
        pe.MoreInfor,pe.hideamount,pe.hidemoreinfor,pe.InvestmentDeals,pe.InvestmentDeals,Link,EstimatedIRR,
        MoreInfoReturns,it.InvestorTypeName,Valuation,FinLink ,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,type
        FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it,manda_investors as mandainv where";
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
        }
        if ($invType!= "--" && $invType!= "")
                $whereInvType = " pe.InvestorType = '".$invType."'";

        if ($InTypes!= "")
        {
                $whereType = " pe.type = '".$InTypes."'";
        }

        if($exitstatusvalue!="--")
        {    $whereexitstatus=" pe.ExitStatus=".$exitstatusvalue;  }
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
        $companysql = $companysql . "  i.industryid=pec.industry and
        pec.PEcompanyID = pe.PECompanyID  and dt.DealtypeId=pe.DealTypeId and   pe.InvestorType=it.InvestorType  and
         mandainv.MandAId=pe.MandAId and pe.Deleted=0 " .$addVCFlagqry.$addhide_pms_qry .$addDelind." order by companyname ";
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
								//header( 'Location: https://www.ventureintelligence.com/deals/cthankyou.php' ) ;
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
//echo "<br>---" .$sql;
//exit();
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

 	echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");

 //define separator (defines columns in excel & tabs in word)
 $sep = " \t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }


echo "Portfolio Company"."\t";
	echo "PE Firm(s)"."\t";
	echo "Investor Type"."\t";
	 echo "Exit Status"."\t";
        echo "Industry"."\t";
	echo "Sector_Business Description"."\t";
	echo "Deal Type"."\t";
        if($hide_pms==1){
            echo "Type"."\t";
        }
	echo "Acquirer "."\t";
	echo "Deal Date"."\t";
	echo "Deal Amount (US\$M)"."\t";
	echo "Advisor-Seller"."\t";
	echo "Advisor-Buyer"."\t";
	echo "Website"."\t";
	echo "Addln Info"."\t";
	echo "Investment Details"."\t";
	
         
    echo "Link"."\t";
    echo "Return Multiple"."\t";
    //echo "Estimated Returns"."\t";
	echo "More Info(Returns)"."\t"; 
        echo "Company Valuation (INR Cr)"."\t";
        echo "Revenue Multiple"."\t";
        echo "EBITDA Multiple"."\t";
        echo "PAT Multiple"."\t";
		
		// New Feature 08-08-2016 start
	
			echo "Price to Book"."\t";
		
		//New Feature 08-08-2016 end
		
        echo "Valuation (More Info)"."\t";
        echo "Revenue (INR Cr)" . "\t";
        echo "EBITDA (INR Cr)" . "\t";
        echo "PAT (INR Cr)" . "\t";
			echo "Book Value Per Share"."\t";
			echo "Price Per Share"."\t";
	echo "Link for Financials"."\t";
       
 print("\n");

 print("\n");
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

          $schema_insert .= $row[7].$sep;

		$AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from manda as peinv,acquirers as ac
		where peinv.MandAId=$MandAId and ac.AcquirerId=peinv.AcquirerId";

		$investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor,MultipleReturn,InvMoreInfo from manda_investors as peinv,
		peinvestors as inv where peinv.MandAId=$MandAId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others' ";
	//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame ,AdvisorType from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$MandAId and advcomp.CIAId=cia.CIAId";

	$adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisoracquirer as advinv,
	advisor_cias as cia where advinv.PEId=$MandAId and advinv.CIAId=cia.CIAId";
		//echo "<Br>".$adacquirersql;


//	echo "<Br>".$advcompanysql;

		if ($rsgetAcquirerSql = mysql_query($AcquirerSql))
		{
			While($myAcquirerrow=mysql_fetch_array($rsgetAcquirerSql, MYSQL_BOTH))
			{
				$Acquirer=$myAcquirerrow["Acquirer"];
				$AcquirerId=$myAcquirerrow["AcquirerId"];
			}
	     }

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

		//investors
			$schema_insert .= $investorString.$sep;
	        //investor type
		         $schema_insert .= $row[22].$sep;
		//exit status
                $schema_insert .= $exitstatusdisplay.$sep;
                //industry
		 	$schema_insert .= $row[8].$sep;
		 //sector
			$schema_insert .= $row[9].$sep;
		//dealtype
			$schema_insert .= $row[10].$sep;
                //Type
                        $type_val = '';
                        if($hide_pms==1){
                            if($row[5] == 4){
                                if($row[36] == 1){ $type_val = "IPO"; } else if($row[36] == 2){ $type_val = "Open Market Transaction"; }else if($row[36] == 3){ $type_val = "Reverse Merger";}else {$type_val = "Open Market Transaction";}
                            }
                            $schema_insert .= $type_val.$sep;
                        }
		//Acquirer Name
			$schema_insert .= $Acquirer.$sep;
		//deal date
			$schema_insert .= $row[11].$sep;
		//deal amount
			if(($row[15]==1) || ($row[12]<=0))
				$hideamount="";
			else
				$hideamount=$row[12];
                        
			$schema_insert .= $hideamount.$sep;
			$schema_insert .= $advisorCompanyString.$sep;
                        $schema_insert .= $advisorAcquirerString.$sep;

                //website
                $schema_insert .= $row[13].$sep;
				
				
				
				
				//New Feature 08-08-2016 start
								 
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
				
				
				

                //additional info
                if($row[16]==1)
                {
                    $hidemoreinfor="";
                }
                else{
                    $hidemoreinfor=$row[14];
                }
	         $schema_insert .= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $hidemoreinfor)).$sep;
	         $schema_insert .= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $row[18])).$sep; // InvestmentDetails
                  
                  if($row[19]!='')
                  {
                      $schema_insert .= $row[19].$sep; //Link
                  }else{
                      $schema_insert .= "".$sep; //Link
                  }
                  
                  $schema_insert .= preg_replace('/[ \t]+/', ' ', preg_replace('/[\r\n]+/', "\n", $investorStringMoreInfo)).$sep;
                  
//                    if($row[20]!="")
//                    {
//                            $estimatedirrvalue=$row[20];
//                            $moreinforeturnsvalue=$row[21];
//                    }
//                    else
//                    {
//                            $estimatedirrvalue="";
//                            $moreinforeturnsvalue="";
//                    }
                    //$schema_insert .= $estimatedirrvalue.$sep; //EstimatedIRR
		   	

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
                          
                           $schema_insert .= $invmoreinfo.$sep; // MoreInfo Returns

                     $schema_insert .= $dec_company_valuation.$sep;  //company valuation
                     $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
                     $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
                     $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
					 
					 
					 $schema_insert .= $price_to_book.$sep;  //price_to_book

                     $schema_insert .= $row[23].$sep;  //Valuation
                     
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
						   $schema_insert .= $book_value_per_share.$sep;  //book_value_per_share
						   $schema_insert .= $price_per_share.$sep;  //price_per_share
                                                   
                     $schema_insert .= $row[24].$sep;  //Financial link
                     
                   


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
    }
mysql_close();
    mysql_close($cnx);
    ?>


