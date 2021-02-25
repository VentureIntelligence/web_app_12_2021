<?php
//  session_save_path("/tmp");
// 	session_start();
        
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
                $stageval=$_POST['txthidestageval'];
                $round=$_POST['txthideround'];
                $regionId=$_POST['txthideregionid'];
                $city=$_POST['txthidecity'];
                $invType=$_POST['txthideinvtypeid'];
                $startRangeValue=$_POST['txthiderangeStartValue'];
                $endRangeValue=$_POST['txthiderangeEndValue'];
                if($stageval!="")
		{
                    $stageval1 = explode(',',$stageval);
                    $stagevaluetext = '';
                    if(count($stageval1) >0){
			for($j=0;$j<count($stageval1);$j++)
			{
                            $stageid = $stageval1[$j];
				$stagesql= "select Stage from stage where StageId=$stageid";
			//	echo "<br>**".$stagesql;
				if ($stagers = mysql_query($stagesql))
				{
					While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
					{
                                                $cnt=$cnt+1;
						$stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
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

                $tsjtitle="� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
                $exportstatusdisplay="Pls Note : Excel Export is available for transactions from Jan.2004 only, as part of search results. You can export transactions prior  to 2004 on a deal by deal basis from the deal details popup." ;


                $addVCFlagqry = " and pec.industry!=15 ";

                $checkForStage = '&& ('.'$stage'.'=="--") ';
                //$checkForStage = " && (" .'$stage'."=='--') ";
                //$checkForStageValue =  " || (" .'$stage'.">0) ";
                $searchTitle = "List of Social Venture Investments";

                    if($companysearch == "" && $sectorsearch == "" && $keyword=="" && $searchallfield == "" && $advisorsearch_legal==""  && $industry =="" && $stageval=="" && $regionId=="" && $invType== "" && ($startRangeValue== "" && $endRangeValue == ""))
                    {
                            $companysql = "SELECT pe.PEId,pe.PEId,pe.PEId,pe.PECompanyId, pe.StageId,pec.countryid,
                            pec.industry,pec.companyname, i.industry, pec.sector_business,
                            amount, round, s.stage, it.InvestorTypeName, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod , pec.website, pec.city,
                            r.Region,MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide
                            FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,country as c,investortype as it,region as r,peinvestments_dbtypes  as pedb
                            WHERE pec.industry = i.industryid and it.InvestorType=pe.InvestorType
                            AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid   and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                            and r.RegionId=pec.RegionId and " .$wheredatesexport ."
                            and AggHide=0 and pe.Deleted=0" .$addVCFlagqry. " ".$addDelind." order by companyname";
                            //echo "<br>3 Query for All records" .$companysql;
                    }
                    elseif($keyword!="")
                    {
                                  $companysql="select peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,pec.industry,
                                  peinv_inv.InvestorId,peinv_inv.PEId,
                                  pec.companyname,i.industry,sector_business,peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                                  DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
                                  hideamount,hidestake,c.country,inv.Investor,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide
                                  from peinvestments_investors as peinv_inv,peinvestors as inv,
                                  peinvestments as peinv,pecompanies as pec,industry as i,stage as s,country as c,investortype as it,region as r ,peinvestments_dbtypes  as pedb
                                  where inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and
                                   s.StageId=peinv.StageId and c.countryid=pec.countryid and it.InvestorType=peinv.InvestorType and AggHide=0 and peinv.Deleted=0  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                  and peinv.PEId=peinv_inv.PEId and r.RegionId=pec.RegionId  and " .$wheredatesexport ."
                                  and pec.PECompanyId=peinv.PECompanyId " .$addVCFlagqry." ".$addDelind." AND inv.InvestorId IN($keyword)  order by companyname";

                                          //echo "<br> Investor search- ".$companysql;
                  }
                   elseif ($companysearch != "")
                    {

                               $companysql="SELECT pe.PEId,pe.PEId,pe.PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
                                       pec.companyname, i.industry, pec.sector_business,
                                       pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
                                       pec.website, pec.city, r.Region,
                                       MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide
                                       FROM peinvestments AS pe, industry AS i,
                                       pecompanies AS pec,stage as s,country as c,investortype as it,region as r,peinvestments_dbtypes  as pedb
                                       WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                       and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId  and " .$wheredatesexport ."   and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                        AND AggHide=0 and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND  pec.PECompanyId IN ($companysearch) 
                                       order by companyname";
                                    //	echo "<br>Query for company search";
                             //echo "<br> Company search--" .$companysql;
                      }
                    elseif ($sectorsearch != "")
                    {
                        
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
                                       MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide 
                                       FROM peinvestments AS pe, industry AS i,
                                       pecompanies AS pec,stage as s,country as c,investortype as it,region as r,peinvestments_dbtypes as pedb,
                                        peinvestments_investors as peinv_inv,peinvestors as inv
                                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                                        and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId   and " .$wheredatesexport ." and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                        AND pe.Deleted =0 and pe.AggHide=0 and pe.SPV=0 " .$addVCFlagqry. " ".$addDelind." AND   ($sector_filter) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";
                    //	echo "<br>Query for company search";
                    // echo "<br> sector search--" .$companysql;
                    }
                   
                  elseif ($searchallfield != "")
                  {
                      $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "pec.companyname LIKE '%$searchallfield%'
                                          OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%'";                                    
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
                                          MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Revenue,EBITDA,PAT,AggHide
                                          FROM peinvestments AS pe, industry AS i,
                                          pecompanies AS pec,stage as s,country as c,investortype as it,region as r, peinvestments_dbtypes  as pedb
                                          WHERE dates between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                          and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId  and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                          AND AggHide=0 and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $tagsval )
                                          order by companyname";
                                       //echo "<br> Company search--" .$companysql;
                                       //exit;
                    }
                    elseif($advisorsearch_legal!="")
                    {
                    $companysql="(
                            SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorinvestors AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and   pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype' and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID   and AggHide=0
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId  and " .$wheredatesexport ." 
                            AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' " .$addVCFlagqry. " ".$addDelind."
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
                            AND adac.CIAId = cia.CIAID and AggHide=0
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId  and " .$wheredatesexport ." 
                            AND cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' " .$addVCFlagqry. " ".$addDelind."
                            )";
                    //	echo "<Br>---Advisor search";

                    }
                    elseif($advisorsearch_trans!="")
                    {
                    $companysql="(
                            SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
                            c.companyname, i.industry, c.sector_business, peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
                            DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
                            hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide
                            FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
                            advisor_cias AS cia, peinvestments_advisorinvestors AS adac,region as r, peinvestments_dbtypes  as pedb
                            WHERE peinv.Deleted=0 and c.industry = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId and   pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype' and
                            s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
                            AND adac.CIAId = cia.CIAID   and AggHide=0
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId  and " .$wheredatesexport ." 
                            AND cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' " .$addVCFlagqry. " ".$addDelind."
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
                            AND adac.CIAId = cia.CIAID and AggHide=0
                            AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId   	and " .$wheredatesexport ."
                            AND cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' " .$addVCFlagqry. " ".$addDelind."
                            )";
                            //echo "<Br>---Advisor search".$companysql;
                    }
                    else if (($industry !="--" && $industry !="" && $industry > 0) || ($round != "--") || ($city != "") || ($stageval!="") || ($regionId!="--" && $regionId !="")|| ($invType!= "--" && $invType!= "") || ($startRangeValue!= "--" && $endRangeValue != "") || $dateValue != "")
                    {
                        $txthidevaluation = $_REQUEST['txthidevaluation'];
                            $companysql = "select pe.PEId,pe.PEId,pe.PEId,pe.PECompanyID,pe.StageId,pec.countryid,
                            pec.industry,pec.companyname,i.industry,pec.sector_business,amount,round,s.stage,
                            it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
                            pec.website,pec.city,r.Region,MoreInfor,hideamount,hidestake,c.country,c.country,
                            Link,pec.RegionId,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,SPV,listing_status,Revenue,EBITDA,PAT,AggHide,
                                GROUP_CONCAT( inv.Investor ORDER BY Investor='others') AS Investor,count(inv.Investor) AS Investorcount
                            from peinvestments as pe, industry as i,pecompanies as pec,stage as s,
                            country as c,investortype as it,region as r ,peinvestments_dbtypes  as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
                            where ".$txthidevaluation;
                            
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
                            if($city != "")
                            {
                                $whereCity=" pec.city LIKE '".$city."%'";
                            }
                            //
                            
    if ($debt_equity != "--" && $debt_equity != "") {
        $whereSPVdebt = " pe.SPV=" . $debt_equity;
    }
                            if ($invType!= "--")
                            {
                            $whereInvType = " pe.InvestorType = '".$invType."'";
                            }
                            $whererange ="";
                            $wheredates="";
                            if (($startRangeValue!= "--") && ($endRangeValue != ""))
                            {
                                    $startRangeValue=$startRangeValue;
                                    $endRangeValue=$endRangeValue-0.01;
                                    if($startRangeValue < $endRangeValue)
                                    {
                                            $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                    }
                                    elseif($startRangeValue = $endRangeValue)
                                    {
                                            $whererange = " pe.amount >= ".$startRangeValue ."";
                                    }
                            }
                               else if($startRangeValue== "--" && $endRangeValue >0 )
                                                {
                                                    $startRangeValue=0;
                                                    $endRangeValue=$endRangeValue-0.01;
                                                    $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";                                     
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
                            if ($whereind != "")
                            {
                                    $companysql=$companysql . $whereind ." and ";
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
                            if($whererange  !="")
                            {
                                // pe.hideamount=0 and 
                                    $companysql = $companysql . " pec.industry = i.industryid and
                                    pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid and
                                    it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId  and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                     and pe.Deleted=0 " . $addVCFlagqry . " ".$addDelind." and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId order by companyname ";
                            }
                            else
                            if($whererange=="")
                            {
                                    $companysql = $companysql . "  i.industryid=pec.industry and
                                    pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid and
                                     it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId   and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                     and pe.Deleted=0 " .$addVCFlagqry. " ".$addDelind." and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId order by companyname ";
                                
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
//exit;

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

 	echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");

            echo ("$exportstatusdisplay");
 	      print("\n");
 	      print("\n");


 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
	echo "Company"."\t";
        echo "Company Type"."\t";
	echo "Industry"."\t";
	echo "Sector"."\t";
	echo "Amount (US\$M)"."\t";
	echo "Round"."\t";
	echo "Stage"."\t";
	echo "Investors"."\t";
	echo "Investor Type"."\t";
	echo "Stake (%)"."\t";
	echo "Date"."\t";
	echo "Website"."\t";
	echo "City"."\t";
	echo "Region"."\t";
	echo "Advisors-Company"."\t";
	echo "Advisors-Investors"."\t";
	echo "More Information"."\t";
        echo "Link"."\t";
        //if($searchtitle==5)
        //{
          echo "Company Valuation (INR Cr)"."\t";
          echo "Revenue Multiple"."\t";
          echo "EBITDA Multiple"."\t";
          echo "PAT Multiple"."\t";
        // }
        echo "Valuation"."\t";
        echo "Revenue (INR Cr)" . "\t";
        echo "EBITDA (INR Cr)" . "\t";
        echo "PAT (INR Cr)" . "\t";
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
           $schema_insert .= $listing_status_display.$sep; //listing status;
          $schema_insert .= $row[8].$sep;  //industry
            $schema_insert .= $row[9].$sep;
            if($row[20]==1)
            	$hideamount="";
            else
            	$hideamount=$row[10];

	         $schema_insert .= $hideamount.$sep;
	           $schema_insert .= $row[11].$sep;
	         $schema_insert .= $row[12].$sep;


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
				$schema_insert .= $investorString.$sep;


				 $schema_insert .= $row[13].$sep;
				 if($row[21]==1 || ($row[14]<=0))
				   	$hidestake="";
				 else
            		$hidestake=$row[14];

				  $schema_insert .= $hidestake.$sep;
				   $schema_insert .= $row[15].$sep;


				     $schema_insert .= $webdisplay.$sep;

				       $schema_insert .= $row[17].$sep;
				         $schema_insert .= $row[18].$sep;


		 if($advisorcompanyrs = mysql_query($advcompanysql))
		 {
			 $advisorCompanyString="";
		   while($row1 = mysql_fetch_array($advisorcompanyrs))
			{
				$advisorCompanyString=$advisorCompanyString.",".$row1[2]."(" .$row1[3].")";
			}
				$advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
		}
		$schema_insert .= $advisorCompanyString.$sep;


		if($advisorinvestorrs = mysql_query($advinvestorssql))
		 {
			 $advisorInvestorString="";
		   while($row2 = mysql_fetch_array($advisorinvestorrs))
			{
				$advisorInvestorString=$advisorInvestorString.",".$row2[2]."(" .$row2[3].")";
			}
				$advisorInvestorString=substr_replace($advisorInvestorString, '', 0,1);
		}
		$schema_insert .= $advisorInvestorString.$sep;
        $schema_insert .= $row[19].$sep;      //moreinfor
        $schema_insert .= $row[24].$sep;  //link

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

       $schema_insert .= $dec_company_valuation.$sep;  //company valuation
       $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
       $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
       $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
       // }


	$schema_insert .= $row[26].$sep; //Valuation
        
             
        
                                                            $dec_revenue=$row[34];
                                                            if($dec_revenue==0 || $dec_revenue=='' || $dec_revenue=='0.00'){
                                                               $schema_insert .= ''.$sep;
                                                            }else{                                                             
                                                             $schema_insert .= $dec_revenue.$sep;  //Revenue 
                                                            }
                                                            

                                                            $dec_ebitda=$row[35];
                                                            if($dec_ebitda==0 || $dec_ebitda=='' || $dec_ebitda=='0.00'){
                                                                $schema_insert .= ''.$sep;
                                                            }else{
                                                                $schema_insert .= $dec_ebitda.$sep;  //EBITDA 
                                                            }

                                                            $dec_pat=$row[36];
                                                            if($dec_pat==0 || $dec_pat=='' || $dec_pat=='0.00'){
                                                                $schema_insert .= ''.$sep;
                                                            }else{   
                                                               $schema_insert .= $dec_pat.$sep;  //PAT 
                                                            }
        
        
        
	$schema_insert .= $row[27].$sep;  //link for financial
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
    }
  mysql_close();
    mysql_close($cnx);
    ?>