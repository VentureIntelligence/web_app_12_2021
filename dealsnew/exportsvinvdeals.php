<?php
 //session_save_path("/tmp");
  //  session_start();
      
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
    if(!isset($_SESSION['UserNames']))
        {
        header('Location:../pelogin.php');
        }
        else
        {
     $listallcompany = $_POST['listallcompanies'];   
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
            $exportvalue = "Company,CIN,CompanyType,Industry,Sector,Amount(M),Amount(Cr),Round,Stage,Investors,InvestorType,Stake,Date,ExitStatus,Website,YearFounded,City,Region,Advisors-Company,Advisors-Investors,MoreInformation,Link,PreMoneyValuation,PreRevenueMultiple,PreEBITDAMultiple,PrePATMultiple,PostMoneyValuation,PostRevenueMultiple,PostEBITDAMultiple,PostPATMultiple,EnterpriseValuation,EVRevenueMultiple,EVEBITDAMultiple,EVPATMultiple,PriceToBook,Valuation,Revenue,EBITDA,PAT,TotalDebt,CashCashEqu,BookValuePerShare,PricePerShare";    

            // $exportvalue = "Company,CompanyType,Industry,Sector,Amount(M),Amount(Cr),Round,Stage,Investors,InvestorType,Stake,Date,ExitStatus,Website,YearFounded,City,Region,Advisors-Company,Advisors-Investors,MoreInformation,Link,PreMoneyValuation,PreRevenueMultiple,PreEBITDAMultiple,PrePATMultiple,PostMoneyValuation,PostRevenueMultiple,PostEBITDAMultiple,PostPATMultiple,EnterpriseValuation,EVRevenueMultiple,EVEBITDAMultiple,EVPATMultiple,PriceToBook,Valuation,Revenue,EBITDA,PAT,TotalDebt,CashCashEqu,BookValuePerShare,PricePerShare,LinkforFinancials";    
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
        if($listallcompany==1)
        {
            $whereexport=$companysql;
            $whereexport1=$companysql;
        }else{
            $whereexport=$companysql."and SPV=0";
            $whereexport1=$companysql."and AggHide=0 and SPV=0";
        }
        //include('onlineaccount.php');
        $displayMessage="";
        $mailmessage="";

            //global $LoginAccess;
            //global $LoginMessage;
                $companyIdDel=1718772497;
                $companyIdSGR=390958295;
                $companyIdVA=38248720;
                $companyIdGlobal=730002984;
                $addDelind="";
                $TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";
                $currentyear = date("Y");
                $wherestage="";
                $submitemail=$_POST['txthideemail'];
                $searchtitle=$_POST['txttitle'];
                $debt_equity = $_POST['txthidedebt_equity'];
                $tagsearch      = $_POST['tagsearch'];
                $tagandor       = $_POST['tagandor'];
                
                $GetCompId="select dm.DCompId,dc.DCompId from dealcompanies as dc,dealmembers as dm
                                        where dm.EmailId='$submitemail' and dc.DCompId=dm.DCompId";
                if($trialrs=mysql_query($GetCompId))
                {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $compId=$trialrow["DCompId"];
                        }
                }
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
                
                if($searchtitle==3)
                {   $dbtype="SV";
                    $fname="svinv_deals";
                    $addVCFlagqrytl = " and c.industry!=15 ";
                }
                elseif($searchtitle==4)
                {   $dbtype="CT";
                    $fname="ctinv_deals";
                    $addVCFlagqrytl = " and c.industry!=15 ";
                }
                elseif($searchtitle==5)
                {
                    $dbtype="IF";
                    $fname="ifinv_deals";
                    $addVCFlagqrytl = " and c.industry!=15 ";
                }
                //echo "<br>*****".$searchtitle;
                $dateValue=$_POST['txthidedate'];
                $hidedateStartValue=$_POST['txthidedateStartValue'];
                $hidedateEndValue=$_POST['txthidedateEndValue'];
                $industry=$_POST['txthideindustryid'];

                $sectorval=$_POST['txthidesectorval'];
                $subsectorval=$_POST['txthidesubsector'];
                $syndication=$_POST['txthidesyndication'];
                $dealsinvolvingvalue=$_POST['txthidedealsinvolving'];
                $stageval=$_POST['txthidestageval'];
                $round=$_POST['txthideround'];
                $regionId=$_POST['txthideregionid'];
                $city=$_POST['txthidecity'];
                $invType=$_POST['txthideinvtypeid'];
                $startRangeValue=$_POST['txthiderangeStartValue'];
                $endRangeValue=$_POST['txthiderangeEndValue'];
                $yearafter=$_POST['yearafter'];
                $yearbefore=$_POST['yearbefore'];
                $txthidepe=$_POST['txthidepe'];
                $state=$_POST['state'];
                $cityid=$_POST['cityid'];
                if($stageval!="")
        {
                    $stageval1 = explode(',',$stageval);
                    $stagevaluetext = '';
                    if(count($stageval1) >0){
            for($j=0;$j<count($stageval1);$j++)
            {
                            $stageid = $stageval1[$j];
                $stagesql= "select Stage,StageId from stage where StageId=$stageid";
            //  echo "<br>**".$stagesql;
                if ($stagers = mysql_query($stagesql))
                {
                    While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                    {
                                                $cnt=$cnt+1;
                        $stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
                        $stagevalueid .= $myrow["StageId"] . ',';
                    }
                }
            }
                    }
            $stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
            if($cnt==$stageCnt)
            {      $stagevaluetext="All Stages";}
            }
        else
                {
            $stagevaluetext="";
                }
                if($regionId >0)
                {
                    $regionSql= "select Region from region where RegionId=$regionId";
                    if ($regionrs = mysql_query($regionSql))
                    {
                            While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
                            {
                                    $regionvalue=$myregionrow["Region"];
                            }
                    }
        }
     //   $invandor = $_POST['invandor'];
        $invradio = $_POST['invradio'];
       
                $keyword=$_POST['txthideinvestor'];
                    $keyword =ereg_replace("_"," ",$keyword);
                $companysearch=$_POST['txthidecompany'];
                    $companysearch =ereg_replace("_"," ",$companysearch);
                $sectorsearch=$_POST['txthidesector'];
                    $sectorsearch =stripslashes(ereg_replace("_"," ",$sectorsearch) );
                   
                $advisorsearch_legal=$_POST['txthideadvisor_legal'];
                    $advisorsearch_legal =ereg_replace("_"," ",$advisorsearch_legal);
                $advisorsearch_trans=$_POST['txthideadvisor_trans'];
                    $advisorsearch_trans =ereg_replace("_"," ",$advisorsearch_trans);
                $searchallfield=$_POST['txthidesearchallfield'];
              
                if($_POST['txthidedateStartValue']!='' && $_POST['txthidedateEndValue']!=''){                
                    $wheredatesexport= " dates between '" . $_POST['txthidedateStartValue']. "' and '" . $_POST['txthidedateEndValue'] . "'";
                }
                else {
                     $wheredatesexport= " dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
                }
               
                $exitstatusValue = $_POST['txthideexitstatusValue'];

                $whereind="";
                $whereregion="";
                $whereinvType="";

                $wheredates="";
                $whererange="";

                $submitemail=$_POST['txthideemail'];

                $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
                $exportstatusdisplay="Pls Note : Excel Export is available for transactions from Jan.2004 only, as part of search results. You can export transactions prior  to 2004 on a deal by deal basis from the deal details popup." ;


                $addVCFlagqry = " and pec.industry!=15 ";

                $checkForStage = '&& ('.'$stage'.'=="--") ';
                //$checkForStage = " && (" .'$stage'."=='--') ";
                //$checkForStageValue =  " || (" .'$stage'.">0) ";
                $searchTitle = "List of Social Venture Investments";
                $hideWhere = '';
                if($_SESSION['PE_industries']!=''){
            
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                    
                }
                    if($companysearch == "" && $sectorsearch == "" && $keyword=="" && $searchallfield == "" && $advisorsearch_legal==""  && $industry =="" && $stageval=="" && $regionId=="" && $invType== "" && ($startRangeValue== "" && $endRangeValue == ""))
                    {
                        if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                            $hideWhere = "  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) and";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                             $hideWhere = "  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) and";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                           $hideWhere = "  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) and";

                        }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                             $hideWhere = "  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) and";

                        }else{
                             $hideWhere = " ";
                        }
    
                        $companysql = "SELECT pe.PEId,pe.PEId,pe.PEId,pe.PECompanyId, pe.StageId,pec.countryid,
                        pec.industry,pec.companyname, i.industry, pec.sector_business,
                        amount, round, s.stage, it.InvestorTypeName, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod , pec.website, pec.city,
                        r.Region,MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide, Exit_Status,price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre,pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded as yearfounded,pec.CINNo
                        FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,country as c,investortype as it,region as r,peinvestments_dbtypes  as pedb
                        WHERE pec.industry = i.industryid and it.InvestorType=pe.InvestorType
                        AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid   and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                        and r.RegionId=pec.RegionId and " .$wheredatesexport . $hideWhere . "
                        and AggHide=0 and pe.Deleted=0 ".$whereexport .$addVCFlagqry.$comp_industry_id_where. " ".$addDelind." order by companyname";
                    }
                    elseif($keyword!="")
                    {
                        if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                            $hideWhere = "and  peinv.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                             $hideWhere = "and  peinv.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                           $hideWhere = "and  peinv.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                             $hideWhere = "and  peinv.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }else{
                             $hideWhere = " ";
                        }
                        $ex_tags = explode(',', $keyword);
                        $invval= count($ex_tags)-1;
                        if ($invradio == 0) {
                            if (count($ex_tags) > 1) {
                            $having=" having count(peinv_inv.PEId) >".$invval;
                            }else{
                                $having="";
                            }
                        }
                        else{
                            $having="";
                        }
                        $companysql="select peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,pec.industry,
                        peinv_inv.InvestorId,peinv_inv.PEId,
                        pec.companyname,i.industry,sector_business,peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                        DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
                        hideamount,hidestake,c.country,inv.Investor,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide,Exit_Status,price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR, peinv.Company_Valuation_pre, peinv.Revenue_Multiple_pre, peinv.EBITDA_Multiple_pre, peinv.PAT_Multiple_pre,peinv.Company_Valuation_EV, peinv.Revenue_Multiple_EV, peinv.EBITDA_Multiple_EV, peinv.PAT_Multiple_EV, peinv.Total_Debt, peinv.Cash_Equ, pec.yearfounded as yearfounded ,pec.CINNo
                        from peinvestments_investors as peinv_inv,peinvestors as inv,
                        peinvestments as peinv,pecompanies as pec,industry as i,stage as s,country as c,investortype as it,region as r ,peinvestments_dbtypes  as pedb,pe_subsectors as pe_sub,pe_sectors as pe_s
                        where pe_s.sector_id=pe_sub.sector_id and pec.PEcompanyID=pe_sub.PECompanyID and inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and
                         s.StageId=peinv.StageId and c.countryid=pec.countryid and it.InvestorType=peinv.InvestorType and AggHide=0 and peinv.Deleted=0 ".$whereexport." and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                        and peinv.PEId=peinv_inv.PEId and r.RegionId=pec.RegionId  and " .$wheredatesexport . $hideWhere . "
                        and pec.PECompanyId=peinv.PECompanyId " .$addVCFlagqry.$comp_industry_id_where." ".$addDelind." AND inv.InvestorId IN($keyword) group by peinv.PEId ".$having." order by companyname";

                                        //   echo "<br> Investor search- ".$companysql;
                                        //   exit();
                  }
                   elseif ($companysearch != "")
                    {
                       /* if( $txthidepe != '' && !empty( $txthidepe ) ) {
                          $hideWhere = " and pe.PEId NOT IN ( " . $txthidepe . " ) ";
                        }*/
                       
                       if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                            $hideWhere = "and pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                             $hideWhere = "and pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                           $hideWhere = "and pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                             $hideWhere = "and pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }else{
                             $hideWhere = " ";
                        }

                               $companysql="SELECT pe.PEId,pe.PEId,pe.PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
                                       pec.companyname, i.industry, pec.sector_business,
                                       pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
                                       pec.website, pec.city, r.Region,
                                       MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide, Exit_Status,price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre,pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded as yearfounded,pec.CINNo
                                       FROM peinvestments AS pe, industry AS i,
                                       pecompanies AS pec,stage as s,country as c,investortype as it,region as r,peinvestments_dbtypes  as pedb,pe_subsectors as pe_sub,pe_sectors as pe_s 
                                       WHERE pec.PEcompanyID=pe_sub.PECompanyID and pe_s.sector_id=pe_sub.sector_id and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                       and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId  and " .$wheredatesexport . $hideWhere . "   and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                        AND AggHide=0 and pe.Deleted =0 ".$whereexport .$addVCFlagqry. $comp_industry_id_where." ".$addDelind." AND  pec.PECompanyId IN ($companysearch) GROUP BY pe.PEId
                                       order by companyname";
                                    //  echo "<br>Query for company search";
                             //echo "<br> Company search--" .$companysql;
                      }
                    elseif ($sectorsearch != "")
                    {
                        /*if( $txthidepe != '' && !empty( $txthidepe ) ) {
                          $hideWhere = " and pe.PEId NOT IN ( " . $txthidepe . " ) ";
                        }*/
                        
                        if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                            $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                             $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                           $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                             $hideWhere = " and pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }else{
                             $hideWhere = " ";
                        }
                        
                            $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                            $sector_sql = array(); // Stop errors when $words is empty

                            foreach($sectorsearchArray as $word){
                                
//                                $sector_sql[] = " sector_business LIKE '$word%' ";
                                                $sector_sql[] = " sector_business = '$word' ";
                                                $sector_sql[] = " sector_business LIKE '$word(%' ";
                                                $sector_sql[] = " sector_business LIKE '$word (%' ";
                            }
                            $sector_filter = implode(" OR ", $sector_sql);
                            
                            
                            $yourquery=1;
                            $industry=0;
                            $stagevaluetext="";
                            $datevalueDisplay1="";
                             $datevalueCheck1="";
                              
                             $companysql="SELECT pe.PEId,pe.PEId,pe.PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
                                       pec.companyname, i.industry, pec.sector_business,
                                       pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
                                       pec.website, pec.city, r.Region,
                                       MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide, Exit_Status,price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre,pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ , pec.yearfounded as yearfounded,pec.CINNo
                                       FROM peinvestments AS pe, industry AS i,
                                       pecompanies AS pec,stage as s,country as c,investortype as it,region as r,peinvestments_dbtypes as pedb,
                                        peinvestments_investors as peinv_inv,peinvestors as inv
                                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                                        and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId   and " .$wheredatesexport . $hideWhere . " and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                        AND pe.Deleted =0 and pe.AggHide=0 and pe.SPV=0 " .$addVCFlagqry. $comp_industry_id_where." ".$addDelind." AND   ($sector_filter) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";
                    //  echo "<br>Query for company search";
                    // echo "<br> sector search--" .$companysql;
                    }
                   
                  elseif ($searchallfield != "")
                  {
                      //echo "s";
                  

                      /*if( $txthidepe != '' && !empty( $txthidepe ) ) {
                        $hideWhere = " and pe.PEId NOT IN ( " . $txthidepe . " ) ";
                      }*/
                      if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                            $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                             $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                           $hideWhere = "and  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                             $hideWhere = "and  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }else{
                             $hideWhere = " ";
                        }

                        $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    /*$tagsval = "pec.companyname LIKE '%$searchallfield%'
                                          OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%'";*/
                                    $searchExplode = explode( ' ', $searchallfield );
                                    foreach( $searchExplode as $searchFieldExp ) {
                                      // $cityLike .= "pec.city LIKE '$searchFieldExp%' AND ";
                                      // $companyLike .= "pec.companyname LIKE '%$searchFieldExp%' AND ";
                                      // $sectorLike .= "sector_business LIKE '%$searchFieldExp%' AND ";
                                      // $moreInfoLike .= "MoreInfor LIKE '%$searchFieldExp%' AND ";
                                      // $investorLike .= "inv.investor LIKE '%$searchFieldExp%' AND ";
                                      // $industryLike .= "i.industry LIKE '%$searchFieldExp%' AND ";
                                      // $websiteLike .= "pec.website LIKE '%$searchFieldExp%' AND ";
                                        $cityLike .= "pec.city REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                        $companyLike .= "pec.companyname REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                        $sectorLike .= "sector_business REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                        $moreInfoLike .= "MoreInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                        $investorLike .= "inv.investor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                        $industryLike .= "i.industry REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                        $websiteLike .= "pec.website REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                      $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,' OR ";
                                    }
                                    $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchallfield$' OR pec.tags REGEXP '[[.colon.]]$searchallfield,'";
                                    $cityLike = '('.trim($cityLike,'AND ').')';
                                    $companyLike = '('.trim($companyLike,'AND ').')';
                                    $sectorLike = '('.trim($sectorLike,'AND ').')';
                                    $moreInfoLike = '('.trim($moreInfoLike,'AND ').')';
                                    $investorLike = '('.trim($investorLike,'AND ').')';
                                    $industryLike = '('.trim($industryLike,'AND ').')';
                                    $websiteLike = '('.trim($websiteLike,'AND ').')';
                                    $tagsLike = '('.trim($tagsLike,'OR ').')';
                                    $tagsval = $cityLike . ' OR ' . $companyLike . ' OR ' . $sectorLike . ' OR ' . $moreInfoLike . ' OR ' . $investorLike . ' OR ' . $industryLike . ' OR ' . $websiteLike . ' OR ' . $tagsLike;                                    
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
                                  $companysql="SELECT pe.PEId,pe.PEId,pe.PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
                                          pec.companyname, i.industry, pec.sector_business,
                                          pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
                                          pec.website, pec.city, r.Region,
                                          MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide,
                                           Exit_Status,price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre,pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded as yearfounded,pec.CINNo
                                          FROM peinvestments AS pe, industry AS i,
                                          pecompanies AS pec,stage as s,country as c,investortype as it,region as r, peinvestments_dbtypes  as pedb, peinvestments_investors as peinv_inv, peinvestors as inv,pe_subsectors as pe_sub,
pe_sectors as pe_s WHERE pec.PEcompanyID=pe_sub.PECompanyID and pe_s.sector_id=pe_sub.sector_id and dates between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' " . $hideWhere . " and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                          and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId  and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                          AND AggHide=0 and pe.Deleted =0 ".$whereexport .$addVCFlagqry. $comp_industry_id_where." ".$addDelind." AND ( $tagsval ) AND peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId
                                          GROUP BY pe.PEId
                                          order by companyname";
                                    //    echo "<br> Company search--" .$companysql;
                                    //    exit;
                    }
                    elseif($advisorsearch_legal!="")
                    {
                      /*if( $txthidepe != '' && !empty( $txthidepe ) ) {
                        $hideWhere = " and peinv.PEId NOT IN ( " . $txthidepe . " ) ";
                      }*/
                        
                        if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                            $hideWhere = "and  peinv.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                             $hideWhere = "and  peinv.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                           $hideWhere = "and  peinv.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                             $hideWhere = "and  peinv.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }else{
                             $hideWhere = " ";
                        }
                      
                      if($_SESSION['PE_industries']!=''){
            
                        $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';

                    }

                    /*$companysql="(
                            SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorinvestors AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and   pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype' and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID   and AggHide=0 ".$whereexport."
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId  and " .$wheredatesexport . $hideWhere . " 
                            AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' " .$addVCFlagqry. $comp_industry_id_where." ".$addDelind."
                            )
                            UNION (
                            SELECT peinv.PEId,peinv.PECompanyId, peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount, peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorcompanies AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                            and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID and AggHide=0 ".$whereexport."
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId  and " .$wheredatesexport . $hideWhere . " 
                            AND cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' " .$addVCFlagqry. $comp_industry_id_where." ".$addDelind."
                            )";*/
                             $companysql="(
                            SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide,Exit_Status,price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR, peinv.Company_Valuation_pre, peinv.Revenue_Multiple_pre, peinv.EBITDA_Multiple_pre, peinv.PAT_Multiple_pre,peinv.Company_Valuation_EV, peinv.Revenue_Multiple_EV, peinv.EBITDA_Multiple_EV, peinv.PAT_Multiple_EV, peinv.Total_Debt, peinv.Cash_Equ , pec.yearfounded as yearfounded,pec.CINNo
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorinvestors AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and   pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype' and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID   and AggHide=0 ".$whereexport."
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId  and " .$wheredatesexport . $hideWhere . " 
                            AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' " . $comp_industry_id_where." ".$addDelind."
                            )
                            UNION (
                            SELECT peinv.PEId,peinv.PECompanyId, peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount, peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide,Exit_Status,price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR, peinv.Company_Valuation_pre, peinv.Revenue_Multiple_pre, peinv.EBITDA_Multiple_pre, peinv.PAT_Multiple_pre,peinv.Company_Valuation_EV, peinv.Revenue_Multiple_EV, peinv.EBITDA_Multiple_EV, peinv.PAT_Multiple_EV, peinv.Total_Debt, peinv.Cash_Equ , pec.yearfounded as yearfounded
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorcompanies AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                            and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID and AggHide=0 ".$whereexport."
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId  and " .$wheredatesexport . $hideWhere . " 
                            AND cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' " . $comp_industry_id_where." ".$addDelind."
                            )";
                    //  echo "<Br>---Advisor search";

                    }
                    elseif($advisorsearch_trans!="")
                    {
                      /*if( $txthidepe != '' && !empty( $txthidepe ) ) {
                        $hideWhere = " and peinv.PEId NOT IN ( " . $txthidepe . " ) ";
                      }*/
                        
                        if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                            $hideWhere = "and  peinv.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                             $hideWhere = "and  peinv.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                           $hideWhere = "and  peinv.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " )  ";

                        }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                             $hideWhere = "and  peinv.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                        }else{
                             $hideWhere = " ";
                        }
                      
                      if($_SESSION['PE_industries']!=''){
            
                        $comp_industry_id_where = ' AND c.industry IN ('.$_SESSION['PE_industries'].') ';

                    }
                   /* $companysql="(
                            SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorinvestors AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and   pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype' and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID   and AggHide=0 ".$whereexport."
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId  and " .$wheredatesexport . $hideWhere . " 
                            AND cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' " .$addVCFlagqry. $comp_industry_id_where." ".$addDelind."
                            )
                            UNION (
                            SELECT peinv.PEId,peinv.PECompanyId, peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount, peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorcompanies AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                            and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID and AggHide=0 ".$whereexport."
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId    and " .$wheredatesexport . $hideWhere . "
                            AND cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' " .$addVCFlagqry. $comp_industry_id_where." ".$addDelind."
                            )";*/

                           $companysql="(
                            SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide,Exit_Status,price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR, peinv.Company_Valuation_pre, peinv.Revenue_Multiple_pre, peinv.EBITDA_Multiple_pre, peinv.PAT_Multiple_pre,peinv.Company_Valuation_EV, peinv.Revenue_Multiple_EV, peinv.EBITDA_Multiple_EV, peinv.PAT_Multiple_EV, peinv.Total_Debt, peinv.Cash_Equ , pec.yearfounded as yearfounded,pec.CINNo
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorinvestors AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and   pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype' and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID   and AggHide=0 ".$whereexport."
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId  and " .$wheredatesexport . $hideWhere . " 
                            AND cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' " . $comp_industry_id_where." ".$addDelind."
                            )
                            UNION (
                            SELECT peinv.PEId,peinv.PECompanyId, peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount, peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide,Exit_Status,price_to_book, book_value_per_share, price_per_share,peinv.Amount_INR, peinv.Company_Valuation_pre, peinv.Revenue_Multiple_pre, peinv.EBITDA_Multiple_pre, peinv.PAT_Multiple_pre,peinv.Company_Valuation_EV, peinv.Revenue_Multiple_EV, peinv.EBITDA_Multiple_EV, peinv.PAT_Multiple_EV, peinv.Total_Debt, peinv.Cash_Equ , pec.yearfounded as yearfounded
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorcompanies AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                            and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID and AggHide=0 ".$whereexport."
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId    and " .$wheredatesexport . $hideWhere . "
                            AND cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' " . $comp_industry_id_where." ".$addDelind."
                            )";
                          //  echo "<Br>---Advisor search".$companysql;

                    }
                    else if (($industry !="--" && $industry !="" && $industry > 0)|| ($sectorval !="--" && $sectorval !="" && $sectorval > 0)|| ($subsectorval !="--" && $subsectorval !="" && $subsectorval > 0) || ($round != "--") || ($city != "") || ($stageval!="") || ($yearafter!="") || ($yearbefore!="") || ($regionId!="--" && $regionId !="")|| ($invType!= "--" && $invType!= "") || ($startRangeValue!= "" && $endRangeValue != "") || $dateValue != "" || ($syndication !="--" && $syndication !="" && $syndication > 0)  || $cityid !="" ||  ( $tagsearch !='')|| $dealsinvolvingvalue !="")
                    {
                        /*if( $txthidepe != '' && !empty( $txthidepe ) ) {
                          $hideWhere = " and pe.PEId NOT IN ( " . $txthidepe . " ) ";
                        }*/
                        
                        if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                            $hideWhere = "  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) and";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                             $hideWhere = "  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) and";

                        }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                           $hideWhere = "  pe.PEId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) and";

                        }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                             $hideWhere = "  pe.PEId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) and";

                        }else{
                             $hideWhere = " ";
                        }
                        $txthidevaluation = $_REQUEST['txthidevaluation'];
                            $companysql = "select pe.PEId,pe.PEId,pe.PEId,pe.PECompanyID,pe.StageId,pec.countryid,
                            pec.industry,pec.companyname,i.industry,pec.sector_business,amount,round,s.stage,
                            it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
                            pec.website,pec.city,r.Region,MoreInfor,hideamount,hidestake,c.country,c.country,
                            Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide,
                            Exit_Status,price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre,pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ ,
                             pec.yearfounded as yearfounded,pec.CINNo,GROUP_CONCAT( inv.Investor ORDER BY Investor='others') AS Investor,count(inv.Investor) AS Investorcount
                            from peinvestments as pe, industry as i,pecompanies as pec,stage as s,
                            country as c,investortype as it,region as r ,peinvestments_dbtypes  as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv, pe_subsectors as pe_sub,pe_sectors as pe_s
                            where ".$txthidevaluation . $hideWhere;
                            
                            
                            if ($industry != '') {
                                $inSql = '';
                                $industry1 = explode(',',$industry);
                                foreach($industry1 as $industrys)
                                {
                                    $inSql .= " pec.industry= '".$industrys."' or ";
                                }
                                $inSql = trim($inSql,' or ');
                                if($inSql !=''){
                                    $whereind=  ' ( '.$inSql.' ) ';
                                    //$whereRound="pe.round LIKE '".$round."'";
                                }
                            }
                            if ($state !="") {

                                $stateSql = '';
                                $stateSql1 = explode(',',$state);
                                //echo "statesql";print_r($stateSql1);

                                foreach ($stateSql1  as $states) {
                                   
                                        $stateSql .= " pec.stateid='".$states."' or ";
                                    }
                                $stateSql = trim($stateSql, ' or ');
                                
                                if ($stateSql != '') {
                                    $wherestate = ' ( ' . $stateSql . ' ) ';
                                }
                                
                               
                            }
                            // if ($cityid != "--") 
                            // {

                            //      $citysql1= "select city_name from city where city_id = $cityid";
               
                            //     if ($citytype = mysql_query($citysql1))
                            //     {
                            //         While($myrow = mysql_fetch_array($citytype, MYSQL_BOTH))
                            //         {
                            //             $cityname = ucwords(strtolower($myrow["city_name"] ));
                                    
                            //         }
                            //     }
               
                            //     $whereCity=" pec.city LIKE '".$cityname."%'";
                            // }
                            if ($cityid != '--') {
                                 $citysql = "select city_id,city_name from city where city_id IN($cityid)";
                                
                                 if ($citys = mysql_query($citysql)) {
                                     while ($myrow = mysql_fetch_array($citys, MYSQL_BOTH)) {
                                         $cityvalue .= $myrow["city_name"] . ',';
                                         $cityvalueid .= $myrow["city_id"] . ',';
                                     }
                                 }
                                 $cityvalue = trim($cityvalue, ',');
                                 $cityvalueid = trim($cityvalueid, ',');
                                 
                             }
                            if ($stageval!="")
                            {
                                    $stagevalues="";
                                    $stageidvalues="";
                                    $stageval1 = explode(',',$stageval);
                                    if(count($stageval1) > 0){
                                        for($j=0;$j<count($stageval1);$j++)
                                    {
                                            $stage = $stageval1[$j];
                                            //echo "<br>****----" .$stage;
                                                $stagevalues .= " pe.StageId=" .$stage." or ";
                                            $stageidvalues=$stageidvalue.",".$stage;
                                    }
                                    }

                                    $wherestage = $stagevalues ;
                                    $qryDealTypeTitle="Stage  - ";
                                    $strlength=strlen($wherestage);
                                    $strlength=$strlength-3;
                            //echo "<Br>----------------" .$wherestage;
                            $wherestage= substr ($wherestage , 0,$strlength);
                            $wherestage ="(".$wherestage.")";
                            //echo "<br>---" .$stringto;

                            } 
                            if ($regionId != '') {
                                $regionSql = '';
                                $regionId1 = explode(',',$regionId);
                                foreach($regionId1 as $regionIds)
                            {
                                    $regionSql .= " pec.RegionId  = '".$regionIds."' or ";
                            }
                                $regionSql = trim($regionSql,' or ');
                                if($regionSql !=''){
                                $qryRegionTitle="Region - ";
                                    $whereregion=  ' ( '.$regionSql.' ) ';
                                    //$whereregion = " pec.RegionId  =" . $regionId;
                            }
                            }

                            if ($yearafter != '' && $yearbefore == '') {
                                    $whereyearaftersql = " pec.yearfounded >= $yearafter";
                                }

                                if ($yearbefore != '' && $yearafter == '') {
                                    $whereyearbeforesql = " pec.yearfounded <= $yearbefore";
                                }

                                if ($yearbefore != '' && $yearafter != '') {
                                    $whereyearfoundedesql = " pec.yearfounded >= $yearafter and pec.yearfounded <= $yearbefore";
                                }

                            // Round
                            if ($round != "--" && $round != "") {
                                $roundSql = '';
                                $round1 = explode(',',$round);
                                foreach($round1 as $rounds)
                            {
                                    $roundSql .= " pe.round LIKE '".$rounds."%' or ";
                            }
                                if($roundSql !=''){
                                    $whereRound=  '('.trim($roundSql,' or ').')';
                                    //$whereRound="pe.round LIKE '".$round."'";
                                }
                            }
                            // City
                            // if($city != "")
                            // {
                            //     $whereCity=" pec.city LIKE '".$city."%'";
                            // }
                            // //
                            if ($cityid!="") {
                                 $cityarray = explode(",",$cityvalue);
                                 foreach($cityarray as $cities) {
                                     $citySql .= " pec.city= '".$cities."' or ";
                                 }
                                 $citySql = trim($citySql, ' or ');
                                 if ($citysql != '') {
                                     $whereCity = ' ( ' . $citySql . ' ) ';
                                 }
                             }
                            
                            if ($debt_equity != "--" && $debt_equity != "") {
                                $whereSPVdebt = " pe.SPV=" . $debt_equity;
                            }
                            if ($invType!= "--")
                            {
                            $whereInvType = " pe.InvestorType = '".$invType."'";
                            }
                            $whererange ="";
                            $wheredates="";
                            if (($startRangeValue!= "") && ($endRangeValue != ""))
                            {
                                    $startRangeValue=$startRangeValue;
                                   // $endRangeValue=$endRangeValue-0.01;
                                    if($startRangeValue < $endRangeValue)
                                    {
                                           // $whererange = " pe.amount  ".$startRangeValue ." and ". $endRangeValue ."";
                                           $whererange = " pe.amount >=  ".$startRangeValue ." and  pe.amount <". $endRangeValue ."";
                                    }
                                    elseif($startRangeValue = $endRangeValue)
                                    {
                                            $whererange = " pe.amount >= ".$startRangeValue ."";
                                    }
                            }
                               else if($startRangeValue== "" && $endRangeValue >0 )
                                                {
                                                    $startRangeValue=0;
                                                   // $endRangeValue=$endRangeValue-0.01;
                                                  //  $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";   
                                                  $whererange = " pe.amount >=  ".$startRangeValue ." and  pe.amount <". $endRangeValue ."";                                  
                                                }

                            if($hidedateStartValue!="" && $hidedateEndValue!="")
                            {
                                    $wheredates= " dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
                            }
                            if ($exitstatusValue != '' && $exitstatusValue != '--') {
                                $exitstatusSql = '';
                                $exitstatusValue1 = explode(',',$exitstatusValue);
                                foreach($exitstatusValue1 as $exitstatusValues)
                                {
                                    $exitstatusSql .= " Exit_Status = '$exitstatusValues' or ";
                                }
                                $exitstatusSql = trim($exitstatusSql,' or ');
                                if($exitstatusSql !=''){
                                    $whereexitstatus=  '('.$exitstatusSql.')';
                                    //$whereexitstatus = " Exit_Status = $exitstatusValue";
                                }


                            }
                            if ($dealsinvolvingvalue != '' && $dealsinvolvingValue != '--') {
                                $dealsinvolvingvalue1 = explode(',',$dealsinvolvingvalue);
                                if(count($dealsinvolvingvalue1)>1){
                                    if($dealsinvolvingValue1 == 1 && $dealsinvolvingValue1 == 2){
                                        $dealsinvolving .="peinv_inv.newinvestor = '1' or peinv_inv.existinvestor = '1'";
                                    }
                                }else{
                                    foreach ($dealsinvolvingvalue1 as $dealsinvolvingValue1) {
                                        if ($dealsinvolvingValue1 != '--' && $dealsinvolvingValue1 != '') {
                                            if($dealsinvolvingValue1 == 1)
                                                {
                                                    // $dealsinvolving .= "peinv_inv.newinvestor = '1' and NOT EXISTS(select 'x' from peinvestments_investors where peid= peinv_inv.peid and existinvestor = 1)
                                                    // and NOT EXISTS(select 'x' from peinvestments_investors where peid= peinv_inv.peid and newinvestor = 0) ";
                                                    $dealsinvolving .= "peinv_inv.newinvestor = '1' ";
                                                }
                                                if($dealsinvolvingValue1 == 2)
                                                {
                                                    $dealsinvolving .= "peinv_inv.existinvestor = '1' and NOT EXISTS(select 'x' from peinvestments_investors where peid= peinv_inv.peid and newinvestor = 1)
                                                    and NOT EXISTS(select 'x' from peinvestments_investors where peid= peinv_inv.peid and existinvestor = 0) ";
                                                }
                                            //$exitstatusSql .= " Exit_Status  = '" . $exitstatusValues . "' or ";
                                        }
                                    }
                               }
                                $wheredealsinvolving = trim($dealsinvolving, ' or ');
                                if ($wheredealsinvolving != '') {
                                    $wheredealsinvolving = '     (' . $wheredealsinvolving . ')';
                                }
                               
                            } 
                            if ($sectorval != '') {
                                $sectorvalarray=explode(",", $sectorval);
                                foreach($sectorvalarray as $key=>$sectorvals)
                                    {
                                        $sectorsql123="select sector_name from pe_sectors where sector_id=".$sectorvals;
                                       
                                        $sectorquery=mysql_query($sectorsql123);
                                        if($row=mysql_fetch_row($sectorquery))
                                        {
                                            $sector123.="'".$row[0]."'";
                                            $sector123.=',';
                                        }
                                    }
                                    
                                   $sectorString= trim($sector123,",");
                                   if($sectorString!=""){
                                    $wheresectorsql = " pe_s.sector_name IN($sectorString)";
                                   }
                                   //$wheresectorsql = " pe_sub.sector_id IN($sectorval)";
                                }
                            if ($subsectorval != '') {
                                             $wheresubsectorsql = " pe_sub.subsector_name IN($subsectorval)";
                            }
                             if($syndication!="--" && $syndication!="" ){
                                                    
                                        if($syndication==0){
                                            $wheresyndication=" Having Investorcount > 1";
                                        }
                                        else{
                                            $wheresyndication=" Having Investorcount <= 1";
                                        }


                                    }
                            if($tagsearch !="")
                            {
                                $ex_tags = explode(',', $tagsearch);
                                if (count($ex_tags) > 0) {
                                    for ($l = 0; $l < count($ex_tags); $l++) {
                                        if ($ex_tags[$l] != '') {
                                            $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                            $value = str_replace(" ", "", $value);
                                            //$tags .= "pec.tags like '%:$value%' or ";
                                            //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                            if ($tagandor == 0) {
                                                $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                            } else {
                                                $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                            }
                                        }
                                    }
                                }

                                if ($tagandor == 0) {
                                    $tagsval = trim($tags, ' and ');
                                } else  {
                                    $tagsval = trim($tags, ' or ');
                                }

                            }


                            if ($wheresectorsql != "") {
                                    $companysql = $companysql . $wheresectorsql . " and ";
                            }
                            if ($wheresubsectorsql != "") {
                                    $companysql = $companysql . $wheresubsectorsql . " and ";
                            } 
                            
                            if ($whereind != "")
                            {
                                    $companysql=$companysql . $whereind ." and ";
                            }
                            if ($wherestate != "") {
                                $companysql = $companysql . $wherestate . " and ";
                                
                            } 
                            if (($wherestage != ""))
                            {
                                    $companysql=$companysql . $wherestage . " and " ;
                            }
                            // moorthi
                            if($whereRound !="")
                            {
                                $companysql=$companysql.$whereRound." and ";
                            }

                            if($whereCity !="")
                            {
                                $companysql=$companysql.$whereCity." and ";
                            }
                            if ($whereSPVdebt != "") {
                                $companysql = $companysql . $whereSPVdebt . " and ";
                            }
                            //
                            if (($whereregion != "") )
                            {

                            $companysql=$companysql . $whereregion . " and " ;
                            }
                            if (($whereInvType != "") )
                            {
                                    $companysql=$companysql .$whereInvType . " and ";
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
                            if($tagsval!="")
                            {
                                $companysql=$companysql ." (".$tagsval . ") and " ;
                            }      
                            if (($whererange != "") )
                            {
                                    $companysql=$companysql .$whererange . " and ";
                            }
                            if(($wheredates !== "") )
                            {
                                    $companysql = $companysql . $wheredates ." and ";
                            }
                            if ($whereexitstatus != "") {
                                $companysql = $companysql . $whereexitstatus . " and ";
                            }
                            if ($wheredealsinvolving != "") {

                                $companysql = $companysql . $wheredealsinvolving . " and ";
                            }
                            if($whererange  !="")
                            {
                                // pe.hideamount=0 and 
                                    $companysql = $companysql . " pec.industry = i.industryid and
                                    pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid and
                                    it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId  and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                     and pe.Deleted=0 " .$whereexport1  . $addVCFlagqry . $comp_industry_id_where." ".$addDelind." and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId and pec.PEcompanyID=pe_sub.PECompanyID 
 and pe_s.sector_id=pe_sub.sector_id GROUP BY pe.PEId ".$wheresyndication." order by companyname ";
                            }
                            else
                            if($whererange=="")
                            {
                                    $companysql = $companysql . "  i.industryid=pec.industry and
                                    pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid and
                                     it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId   and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                     and pe.Deleted=0 " .$whereexport1  .$addVCFlagqry. $comp_industry_id_where." ".$addDelind." and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId and pec.PEcompanyID=pe_sub.PECompanyID 
 and pe_s.sector_id=pe_sub.sector_id GROUP BY pe.PEId ".$wheresyndication." order by companyname ";
                                
                                   /* $companysql = $companysql . " pec.industry = i.industryid and it.InvestorType=pe.InvestorType
                                    AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid   and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                    and r.RegionId=pec.RegionId and AggHide=0 and pe.Deleted=0" .$addVCFlagqry. "order by companyname";*/
                                //echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                            }
                            //and SPV=0
                        }
                        else
                        {
                                echo "<br> INVALID DATES GIVEN ";
                                $fetchRecords=false;
                        }


$sql=$companysql;
//echo "<br>---" .$sql;die;
// exit;

 //execute query
 $result = @mysql_query($sql)
     or die("Error in connection:<br>");
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
 header("Content-Disposition: attachment; filename=$fname.$file_ending");
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

            echo ("$exportstatusdisplay");
          print("\n");
          print("\n");*/


 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
//  echo mysql_field_name($result,$i) . "\t";
// }
if(in_array("Company", $expval))
{
    echo "Company"."\t";
}
if(in_array("CIN", $expval))
{
    echo "CIN"."\t";
}
if(in_array("CompanyType", $expval))
{
    echo "Company Type"."\t";
}
if(in_array("Industry", $expval))
{   
    echo "Industry"."\t";
}
if(in_array("Sector", $expval))
{
    echo "Sector"."\t";
}
if(in_array("Amount(M)", $expval))
{
    echo "Amount (US\$M)"."\t";
}
if(in_array("Amount(Cr)", $expval))
{
    echo "Amount(INR Cr)"."\t";
}
if(in_array("Round", $expval))
{
    echo "Round"."\t";
}
if(in_array("Stage", $expval))
{
    echo "Stage"."\t";
}
if(in_array("Investors", $expval))
{  
     echo "Investors"."\t";
}
if(in_array("InvestorType", $expval))
{   
    echo "Investor Type"."\t";
}
if(in_array("Stake", $expval))
{    
    echo "Stake (%)"."\t";
}
if(in_array("Date", $expval))
{
    echo "Date"."\t";
}
if(in_array("ExitStatus", $expval))
{
    echo "Exit Status"."\t";
}
if(in_array("Website", $expval))
{
    echo "Website"."\t";
}
if(in_array("YearFounded", $expval))
{
    echo "Year Founded"."\t";
}
if(in_array("City", $expval))
{
    echo "City"."\t";
}
if(in_array("Region", $expval))
{   
    echo "Region"."\t";
}
if(in_array("Advisors-Company", $expval))
{
    echo "Advisors-Company"."\t";
}
if(in_array("Advisors-Investors", $expval))
{
    echo "Advisors-Investors"."\t";
}
if(in_array("MoreInformation", $expval))
{
    echo "More Information"."\t";
}
if(in_array("Link", $expval))
{
    echo "Link"."\t";
}
if(in_array("PreMoneyValuation", $expval))
{
    echo "Pre Money Valuation (INR Cr)"."\t";
}
if(in_array("PreRevenueMultiple", $expval))
{
    echo "Revenue Multiple (Pre)"."\t";
}
if(in_array("PreEBITDAMultiple", $expval))
{
    echo "EBITDA Multiple (Pre)"."\t";
}
if(in_array("PrePATMultiple", $expval))
{
    echo "PAT Multiple (Pre)"."\t";
}
if(in_array("PostMoneyValuation", $expval))
{
    echo "Post Money Valuation (INR Cr)"."\t";
}
if(in_array("PostRevenueMultiple", $expval))
{
    echo "Revenue Multiple (Post)"."\t";
}
if(in_array("PostEBITDAMultiple", $expval))
{
    echo "EBITDA Multiple (Post)"."\t";
}
if(in_array("PostPATMultiple", $expval))
{
    echo "PAT Multiple (Post)"."\t";
}
if(in_array("EnterpriseValuation", $expval))
{
    echo "Enterprise Valuation (INR Cr)"."\t";
}
if(in_array("EVRevenueMultiple", $expval))
{
    echo "Revenue Multiple (EV)"."\t";
}
if(in_array("EVEBITDAMultiple", $expval))
{
    echo "EBITDA Multiple (EV)"."\t";
}
if(in_array("EVPATMultiple", $expval))
{
    echo "PAT Multiple (EV)"."\t";
}
if(in_array("PriceToBook", $expval))
{
    echo "Price to Book"."\t";
}
if(in_array("Valuation", $expval))
{
    echo "Valuation"."\t";
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
if(in_array("TotalDebt", $expval))
{
    echo "Total Debt (INR Cr)"."\t";
}
if(in_array("CashCashEqu", $expval))
{
    echo "Cash & Cash Equ. (INR Cr)" . "\t";
}
if(in_array("BookValuePerShare", $expval))
{
    echo "Book Value Per Share" . "\t";
}
if(in_array("PricePerShare", $expval))
{
    echo "Price Per Share" . "\t";
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
         $PEId=$row[0];
        $companyName = $row[7];
        if($row[33]=="L")
                       $listing_status_display="Listed";
                elseif($row[33]=="U")
                       $listing_status_display="Unlisted";
        $companyName=strtolower($companyName);
        $compResult=substr_count($companyName,$searchString);
        //echo $compResult;
                if($row[37]==1)
                {
                        $openBracket="(";
                        $closeBracket=")";
                }
                else
                {
                        $openBracket="";
                        $closeBracket="";
                }
        if($row[32]==1)
         {
                         $openDebtBracket="[";
                         $closeDebtBracket="]";
                 }
                 else
                 {
                         $openDebtBracket="";
                         $closeDebtBracket="";
                 }
        //echo $compResult;
                // print_r($row);exit();
        if (in_array("Company", $expval))
        {
            if($compResult==0)
            {
                    $schema_insert .= $openDebtBracket.$openBracket.$row[7].$closeBracket.$closeDebtBracket.$sep;
                    $webdisplay=$row[16];
                }
            else
            {
                $schema_insert .= $searchStringDisplay.$sep;
                $webdisplay="";
            }
        }
        if(in_array("CIN", $expval))
        {
            $schema_insert .= $row[54].$sep;
        }
        if(in_array("CompanyType", $expval))
        {
            $schema_insert .= $listing_status_display.$sep; //listing status;
        }
        
        if(in_array("Industry", $expval))
        {    
            $schema_insert .= $row[8].$sep;  //industry
        }
        if(in_array("Sector", $expval))
        {
            $schema_insert .= $row[9].$sep;
        }

            if($row[20]==1)
                $hideamount="";
            else
                $hideamount=$row[10];

            if(in_array("Amount(M)", $expval))
            {
                $schema_insert .= $hideamount.$sep;
            }
              if($row[20] == 1)
              {
                $hideamount1="";
             }
            else{
                if($row[42] != "" &&  $row[42]!=0)
                {
                $hideamount1=$row[42];
            }else{
                $hideamount1=""; 
            }
        }
        if(in_array("Amount(Cr)", $expval))
        {
            $schema_insert .=  $hideamount1.$sep;
        }
        if(in_array("Round", $expval))
        {
            $schema_insert .= $row[11].$sep;
        }
        if(in_array("Stage", $expval))
        {
            $schema_insert .= $row[12].$sep;
        }

    $investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
        peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others' ";
    //echo "<Br>Investor".$investorSql;

    $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from peinvestments_advisorcompanies as advcomp,
    advisor_cias as cia where advcomp.PEId=$PEId and advcomp.CIAId=cia.CIAId";
    //echo "<Br>".$advcompanysql;

    $advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisorinvestors as advinv,
    advisor_cias as cia where advinv.PEId=$PEId and advinv.CIAId=cia.CIAId";

                if($investorrs = mysql_query($investorSql))
                 {

                    $investorString="";
                    $AddOtherAtLast="";
                    $AddUnknowUndisclosedAtLast="";
                   while($rowInvestor = mysql_fetch_array($investorrs))
                    /*{
                        $investorString=$investorString.",".$rowInvestor[2];
                    }
                        $investorString=substr_replace($investorString, '', 0,1);

                    */

                    {
                        $Investorname=$rowInvestor[2];
                        $Investorname=strtolower($Investorname);

                        $invResult=substr_count($Investorname,$searchString);
                        $invResult1=substr_count($Investorname,$searchString1);
                        $invResult2=substr_count($Investorname,$searchString2);

                        if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                            $investorString=$investorString .", ".$rowInvestor[2];
                        elseif(($invResult==1) || ($invResult1==1))
                            $AddUnknowUndisclosedAtLast=$rowInvestor[2];
                        elseif($invResult2==1)
                            $AddOtherAtLast=$rowInvestor[2];
                    }

                        if($AddUnknowUndisclosedAtLast!=="")
                            $investorString=$investorString .", ".$AddUnknowUndisclosedAtLast;
                        if($AddOtherAtLast!="")
                            $investorString=$investorString .", ".$AddOtherAtLast;

                    $investorString =substr_replace($investorString, '', 0,1);


                }
                if (in_array("Investors", $expval))
                { 
                    $schema_insert .= $investorString.$sep;
                }
                if (in_array("InvestorType", $expval))
                { 
                    $schema_insert .= $row[13].$sep;
                }

                 if($row[21]==1 || ($row[14]<=0))
                    $hidestake="";
                 else
                    $hidestake=$row[14];

                if (in_array("Stake", $expval))
                {
                    $schema_insert .= $hidestake.$sep;
                }
                if (in_array("Date", $expval))
                {
                    $schema_insert .= $row[15].$sep;
                }
                
                    $exitstatusSql = "select id,status from exit_status where id=$row[38]";
                    if ($exitstatusrs = mysql_query($exitstatusSql)) {
                        $exitstatus_cnt = mysql_num_rows($exitstatusrs);
                    }
                    if ($exitstatus_cnt > 0) {
                        While ($myrow = mysql_fetch_array($exitstatusrs, MYSQL_BOTH)) {
                            $exitstatusis = $myrow[1];
                        }
                    } else {
                        $exitstatusis = 'Unexited';
                    }
                    //  $schema_insert .= $exitstatusis.$sep;

                    //  $schema_insert .= $webdisplay.$sep;
                    //  $schema_insert .= $row[55].$sep;

                    //    $schema_insert .= $row[17].$sep;

                      
                    //      $schema_insert .= $row[18].$sep;
                    if (in_array("ExitStatus", $expval))
                    {
                        $schema_insert .= $exitstatusis.$sep;
                    }
                    if (in_array("Website", $expval))
                    {
                        $schema_insert .= $webdisplay.$sep;
                    }
                    if (in_array("YearFounded", $expval))
                    {
                        $schema_insert .= $row[53].$sep;
                    }
                    if (in_array("City", $expval))
                    {
                        $schema_insert .= $row[17].$sep;
                    }
                    if (in_array("Region", $expval))
                    {  
                        $schema_insert .= $row[18].$sep;
                    }


         if($advisorcompanyrs = mysql_query($advcompanysql))
         {
             $advisorCompanyString="";
           while($row1 = mysql_fetch_array($advisorcompanyrs))
            {
                $advisorCompanyString=$advisorCompanyString.",".$row1[2]."(" .$row1[3].")";
            }
                $advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
        }
        // $schema_insert .= $advisorCompanyString.$sep;
        if (in_array("Advisors-Company", $expval))
        {
            $schema_insert .= $advisorCompanyString.$sep;
        }


        if($advisorinvestorrs = mysql_query($advinvestorssql))
         {
             $advisorInvestorString="";
           while($row2 = mysql_fetch_array($advisorinvestorrs))
            {
                $advisorInvestorString=$advisorInvestorString.",".$row2[2]."(" .$row2[3].")";
            }
                $advisorInvestorString=substr_replace($advisorInvestorString, '', 0,1);
        }
        if (in_array("Advisors-Investors", $expval))
        {
            $schema_insert .= $advisorInvestorString.$sep;
        }
        if (in_array("MoreInformation", $expval))
        {
            $schema_insert .= $row[19].$sep;      //moreinfor
        }

      //  $schema_insert .= $row[24].$sep;  //link
      if (in_array("Link", $expval))
      {
          $schema_insert .= str_replace('"', '', $row[24]).$sep;  //link str replace for removing " {Issues happend}
      }
        $pre_company_valuation=$row[43];
             if ($pre_company_valuation <=0)
                $pre_company_valuation="";

            $pre_revenue_multiple=$row[44];
            if($pre_revenue_multiple<=0)
                $pre_revenue_multiple="";

            $pre_ebitda_multiple=$row[45];
            if($pre_ebitda_multiple<=0)
                $pre_ebitda_multiple="";

            $pre_pat_multiple=$row[46];
            if($pre_pat_multiple<=0)
               $pre_pat_multiple="";

        // $schema_insert .= $pre_company_valuation.$sep;
        // $schema_insert .= $pre_revenue_multiple.$sep;
        // $schema_insert .= $pre_ebitda_multiple.$sep;
        // $schema_insert .= $pre_pat_multiple.$sep;
        if (in_array("PreMoneyValuation", $expval))
        {
            $schema_insert .= $pre_company_valuation.$sep;
        }
        if (in_array("PreRevenueMultiple", $expval))
        {
            $schema_insert .= $pre_revenue_multiple.$sep;
        }
        if (in_array("PreEBITDAMultiple", $expval))
        {
            $schema_insert .= $pre_ebitda_multiple.$sep;
        }
        if (in_array("PrePATMultiple", $expval))
        {
            $schema_insert .= $pre_pat_multiple.$sep;
        }

        //if($searchtitle==5)
        //{
          $dec_company_valuation=$row[28];
             if ($dec_company_valuation <=0)
                $dec_company_valuation="";

            $dec_revenue_multiple=$row[29];
            if($dec_revenue_multiple<=0)
                $dec_revenue_multiple="";

            $dec_ebitda_multiple=$row[30];
            if($dec_ebitda_multiple<=0)
                $dec_ebitda_multiple="";

            $dec_pat_multiple=$row[31];
            if($dec_pat_multiple<=0)
               $dec_pat_multiple="";

    //    $schema_insert .= $dec_company_valuation.$sep;  //company valuation
    //    $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
    //    $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
    //    $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
       // }

       if (in_array("PostMoneyValuation", $expval))
        {
        $schema_insert .= $dec_company_valuation.$sep;  //company valuation
        }
        if (in_array("PostRevenueMultiple", $expval))
        {
        $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
        }
        if (in_array("PostEBITDAMultiple", $expval))
        {
        $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
        }
        if (in_array("PostPATMultiple", $expval))
        { 
        $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
        }
        $EV_company_valuation=$row[47];
             if ($EV_company_valuation <=0)
                $EV_company_valuation="";

            $EV_revenue_multiple=$row[48];
            if($EV_revenue_multiple<=0)
                $EV_revenue_multiple="";

            $EV_ebitda_multiple=$row[49];
            if($EV_ebitda_multiple<=0)
                $EV_ebitda_multiple="";

            $EV_pat_multiple=$row[50];
            if($EV_pat_multiple<=0)
               $EV_pat_multiple="";


    //    $schema_insert .= $EV_company_valuation.$sep;
    //    $schema_insert .= $EV_revenue_multiple.$sep;
    //    $schema_insert .= $EV_ebitda_multiple.$sep;
    //    $schema_insert .= $EV_pat_multiple.$sep;
    if (in_array("EnterpriseValuation", $expval))
    {
    $schema_insert .= $EV_company_valuation.$sep;
    }
    if (in_array("EVRevenueMultiple", $expval))
    {
    $schema_insert .= $EV_revenue_multiple.$sep;
    }
    if (in_array("EVEBITDAMultiple", $expval))
    {
    $schema_insert .= $EV_ebitda_multiple.$sep;
    }
    if (in_array("EVPATMultiple", $expval))
    {
    $schema_insert .= $EV_pat_multiple.$sep;
    }
       $price_to_book=$row[39];
            if($price_to_book<=0)
                $price_to_book="";
                if (in_array("PriceToBook", $expval))
                {
                    $schema_insert .= $price_to_book.$sep;//price to book
                }
                if (in_array("Valuation", $expval))
                {
                    $schema_insert .= $row[26].$sep; //Valuation
                }
        
                if (in_array("Revenue", $expval))
                {     
                    $dec_revenue=$row[34];
                    if($dec_revenue==0 || $dec_revenue=='' || $dec_revenue=='0.00'){
                        $schema_insert .= ''.$sep;
                    }else{                                                             
                        $schema_insert .= $dec_revenue.$sep;  //Revenue 
                    }
                }
        
                if (in_array("EBITDA", $expval))
                {
                    $dec_ebitda=$row[35];
                    if($dec_ebitda==0 || $dec_ebitda=='' || $dec_ebitda=='0.00'){
                        $schema_insert .= ''.$sep;
                    }else{
                        $schema_insert .= $dec_ebitda.$sep;  //EBITDA 
                    }
                }
                if(in_array("PAT", $expval))
                {
                    $dec_pat=$row[36];
                    if($dec_pat==0 || $dec_pat=='' || $dec_pat=='0.00'){
                        $schema_insert .= ''.$sep;
                    }else{   
                        $schema_insert .= $dec_pat.$sep;  //PAT 
                    }
                } 
    $TotalDebt=$row[51];
            if($TotalDebt<=0)
                $TotalDebt="";
    $Cash_Cash_Equ=$row[52];
            if($Cash_Cash_Equ<=0)
                $Cash_Cash_Equ="";
    $Book_value=$row[40];
            if($Book_value<=0)
                $Book_value="";
    $Price_per=$row[41];
            if($Price_per<=0)
                $Price_per="";
                if (in_array("TotalDebt", $expval))
                {
                    $schema_insert .= $TotalDebt.$sep;//Total Debt
                }
                if (in_array("CashCashEqu", $expval))
                {
                    $schema_insert .= $Cash_Cash_Equ.$sep; //Cash & cash EQU
                }
                if (in_array("BookValuePerShare", $expval))
                {
                    $schema_insert .= $Book_value.$sep;//Book value
                }
                if (in_array("PricePerShare", $expval))
                {
                    $schema_insert .= $Price_per.$sep; //Price per share
                }
                // if (in_array("LinkforFinancials", $expval))
                // { 
                //     $schema_insert .= $row[27].$sep;  //link for financial
                // }
   
    
    
        // $schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert .= ""."\n";
        //following fix suggested by Josue (thanks, Josue!)
        //this corrects output in excel when table fields contain \n or \r
        //these two characters are now replaced with a space
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
         $schema_insert .= "\t";
         print(trim($schema_insert));
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

    echo ("$exportstatusdisplay");
    print("\n");
    print("\n");
    }
  mysql_close();
    mysql_close($cnx);
    ?>