<?php include_once("../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
	session_start();
            
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
        
        //Check Session Id 
        $sesID=session_id();
        $emailid=$_SESSION['REUserEmail'];
        $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='RE'";
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
            $dlogUserEmail = $_SESSION['REUserEmail'];
            $today = date('Y-m-d');

            //Check Existing Entry
           $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='RE' AND `downloadDate` = CURRENT_DATE";
           $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
           $rowSelCount = mysql_num_rows($sqlSelResult);
           $rowSel = mysql_fetch_object($sqlSelResult);
           $downloads = $rowSel->recDownloaded;

           if ($rowSelCount > 0){
               $upDownloads = $recCount + $downloads;
               $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='RE' AND `downloadDate` = CURRENT_DATE";
               $resUdt = mysql_query($sqlUdt) or die(mysql_error());
           }else{
               $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','RE','".$recCount."')";
               mysql_query($sqlIns) or die(mysql_error());
           }
        }
        
        
        
	//include('onlineaccount.php');
	$displayMessage="";
	$mailmessage="";
	//global $LoginAccess;
	//global $LoginMessage;
	$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

	$submitemail=$_POST['txthideemail'];
	$industry=$_POST['txthideindustryid'];
	$hideindustrytext=$_POST['txthideindustry'];

	$hidestagetext=$_POST['txthidestage'];
	$stage=$_POST['txthidestageid'];
	$SPVCompany=$_POST['txthideSPVCompany'];
	$SPVCompanyvalue=$_POST['txthideSPVCompanyValue'];
	$companyType=$_POST['txthidecomptype'];
	$invtypevalue=$_POST['txthideinvtype'];
	$invType=$_POST['txthideinvtypeid'];
	$regionId=$_POST['txthideregionid'];
	$ex_city=$_POST['txthidecity'];

	$regionValue=$_POST['txthideregionvalue'];

	$startRangeValue=$_POST['txthiderangeStartValue'];
	$endRangeValue=$_POST['txthiderangeEndValue'];
	$rangeText=$_POST['txthiderange'];

	$datevalue=$_POST['txthidedate'];
	$datevalueDisplay=$datevalue;
	$keyword=$_POST['txthideinvestor'];
	$keywordsearch=$_POST['txthideinvestorsearch'];
	$keyword =ereg_replace("-"," ",$keyword);

	$companysearch=$_POST['txthidecompany'];
	$sectorsearch=$_POST['txthide_sectorsearch'];
//	$companysearch =ereg_replace("-"," ",$companysearch);

	//$advisorsearch=$_POST['txthideadvisor'];

        $advisorsearch_legal=$_POST['txthideadvisor_legal'];
        $advisorsearch_legal =ereg_replace("-"," ",$advisorsearch_legal);
        $advisorsearch_trans=$_POST['txthideadvisor_trans'];
        $advisorsearch_trans =ereg_replace("-"," ",$advisorsearch_trans);

        $searchallfield=trim($_POST['txthidesearchallfield']);
        $searchallfield =ereg_replace("-"," ",$searchallfield);
	//echo "<br>-*- ".$advisorsearch_legal;

	$hidedateStartValue=$_POST['txthidedateStartValue'];
	$hidedateEndValue=$_POST['txthidedateEndValue'];
	$dateValue=$_POST['txthidedate'];
$exitstatusValue = $_POST['txthideexitstatusValue'];
// echo $companyType;
// echo $invType;
	//$submitemail=$_POST['txthideemail'];

/* echo "<br>Stage ".$stage;
echo "<br>Industry " .$industry;
echo "<Br>Inv Type " .$invType;
echo "<br>SPV " .$SPVCompany;
echo "<br>Start " .$hidedateStartValue;
echo "<Br>Start Range " .$startRangeValue;
*/

				$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

				$searchtitle = 2;

				if($searchtitle==0)
				{
					$addVCFlagqry = " and pec.industry =15 ";
					$checkForStage = ' && ('.'$stage'.' =="--")';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue = " || (" .'$stage'.">0) ";

				}
				elseif($searchtitle==1)
				{
					$addVCFlagqry = " and pec.industry=15  and s.VCview=1 and pe.amount <=20 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of VC Investments ";
				}
				elseif($searchtitle==2)
				{
                                    if(count($industry)>0){
                                        $addVCFlagqry = "";
                                    }
                                    else{
						$addVCFlagqry="";
                                    }
					$checkForStage = "";
					$checkForStageValue = "";
					$searchTitle = "List of PE Investments - Real Estate";
				}


			if (($keyword == "") && ($companysearch=="") && ($sectorsearch=="") && ($advisorsearch_legal=="") && ($advisorsearch_trans=="") && (count($industry) <= 0) && ($regionId<=0) && ($ex_city !='') && ($invType == "--") && ($SPVCompany=="--") && ($companyType=="") && ($startRangeValue == "--") && ($endRangeValue == "--") && ($hidedateStartValue == "") && ($hidedateEndValue == "") && (count($stage)>0) && ($searchallfield == ""))
			{
			     $companysql = "SELECT PEId,PEId,PEId,pe.PECompanyId, pe.StageId,pec.countryid,
			     pe.IndustryId,pec.companyname, i.industry, pe.sector as sector_business,
			     amount, round, s.REType, it.InvestorTypeName, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod , pec.website, pe.city,
			     r.region,MoreInfor,hideamount,hidestake,c.country,pe.SPV,pe.SPV,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status,AggHide
			     FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,country as c,investortype as it,region as r
			     WHERE pe.IndustryId = i.industryid and it.InvestorType=pe.InvestorType
			     AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and c.countryid=pec.countryid and r.RegionId=pe.RegionId
			     and pe.Deleted=0 " .$addVCFlagqry. " order by companyname";
			    $datevalueDisplay="";
			//echo "<br>3 Query for All records" .$companysql;
			}
                        elseif ($searchallfield != "")
			{
			  
                                
                               $companysql="SELECT pe.PEId,pe.PEId,pe.PEId,pe.PECompanyId,pe.StageId,pec.countryid,pe.IndustryId,
					pec.companyname, i.industry, pe.sector as sector_business,
					pe.amount, pe.round, s.REType,it.InvestorTypeName,  pe.stakepercentage,
                    DATE_FORMAT( pe.dates, '%M-%Y' ) as dealperiod,pec.website, pe.city, r.region,
					MoreInfor,hideamount,hidestake,c.country,pe.SPV,pe.SPV,Link,Valuation,FinLink,ProjectName,listing_status,pe.Exit_Status,pe.AggHide
					FROM REinvestments AS pe, reindustry AS i,
                                        REcompanies AS pec,realestatetypes as s,REinvestments_investors as peinv_inv,REinvestors as inv,
					country as c,investortype as it,region as r, REadvisorcompanies_advisorinvestors as reacai
					WHERE pe.dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
                                        AND inv.InvestorId=peinv_inv.InvestorId and pe.PEId=peinv_inv.PEId
					and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pe.RegionId   
					AND pe.Deleted =0 " .$addVCFlagqry. " AND (pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
					OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or inv.investor like '$searchallfield%' or (reacai.Cianame like '$searchallfield%'  and  reacai.dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'  AND reacai.PEId=peinv_inv.PEId))
					GROUP BY pe.PEId order by companyname";
			}
				elseif($advisorsearch_legal!="")
				{
					$companysql="(
					SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,c.countryid,c.industry,cia.CIAId,
                                        adac.CIAId AS AcqCIAId,
					c.companyname, i.industry, peinv.sector as sector_business, peinv.amount,peinv.round,
                                        s.REType,it.InvestorTypeName,peinv.stakepercentage,
					DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,peinv.city,r.region,MoreInfor,
					hideamount,hidestake,co.country,cia.Cianame,SPV,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status,AggHide
					FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i,realestatetypes as s,
                                        country as co,investortype as it,region as r,
					REadvisor_cias AS cia,REinvestments_advisorinvestors AS adac
					WHERE peinv.Deleted=0 and c.industry =15 and peinv.IndustryId = i.industryid
					AND c.PECompanyId = peinv.PECompanyId and r.RegionId=peinv.RegionId
					and s.RETypeId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId  and AdvisorType='L'
					AND cia.cianame LIKE '$advisorsearch_legal%'
					)
					UNION (
					SELECT peinv.PEId,peinv.PECompanyId, peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
					c.companyname, i.industry, peinv.sector as sector_business, peinv.amount, peinv.round,s.REType,it.InvestorTypeName,peinv.stakepercentage,
					DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.region,MoreInfor,
					hideamount,hidestake,co.country,cia.Cianame,SPV,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status,AggHide
					FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i,realestatetypes as s,country as co,investortype as it,region as r,
					REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
					WHERE dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  peinv.Deleted=0 and c.industry =15 and peinv.IndustryId = i.industryid
					AND c.PECompanyId = peinv.PECompanyId
					and r.RegionId=peinv.RegionId and
					s.RETypeId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId  and AdvisorType='L'
					AND cia.cianame LIKE '$advisorsearch_legal%'
					)";
					$datevalueDisplay="";
					//echo "<br><br>-ADVISOR search--" .$companysql;exit();
				}
				elseif($advisorsearch_trans!="")
				{
					$companysql="(
					SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,c.countryid,c.industry,cia.CIAId,
                                        adac.CIAId AS AcqCIAId,
					c.companyname, i.industry, peinv.sector as sector_business, peinv.amount,peinv.round,
                                        s.REType,it.InvestorTypeName,peinv.stakepercentage,
					DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,peinv.city,r.region,MoreInfor,
					hideamount,hidestake,co.country,cia.Cianame,SPV,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status,AggHide
					FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i,realestatetypes as s,
                                        country as co,investortype as it,region as r,
					REadvisor_cias AS cia,REinvestments_advisorinvestors AS adac
					WHERE peinv.Deleted=0 and c.industry =15 and peinv.IndustryId = i.industryid
					AND c.PECompanyId = peinv.PECompanyId and r.RegionId=peinv.RegionId
					and s.RETypeId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId  and AdvisorType='T'
					AND cia.cianame LIKE '$advisorsearch_trans%'
					)
					UNION (
					SELECT peinv.PEId,peinv.PECompanyId, peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
					c.companyname, i.industry, peinv.sector as sector_business, peinv.amount, peinv.round,s.REType,it.InvestorTypeName,peinv.stakepercentage,
					DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.region,MoreInfor,
					hideamount,hidestake,co.country,cia.Cianame,SPV,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status,AggHide
					FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i,realestatetypes as s,country as co,investortype as it,region as r,
					REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
					WHERE dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  peinv.Deleted=0 and c.industry =15 and peinv.IndustryId = i.industryid
					AND c.PECompanyId = peinv.PECompanyId
					and r.RegionId=peinv.RegionId and
					s.RETypeId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
					AND adac.CIAId = cia.CIAID
					AND adac.PEId = peinv.PEId  and AdvisorType='T'
					AND cia.cianame LIKE '$advisorsearch_trans%'
					)";
					$datevalueDisplay="";
					//echo "<br><br>-ADVISOR search--" .$companysql;
				}

				elseif ($companysearchold != "")
				{

				$companysql="SELECT PEId,PEId,PEId,pe.PECompanyId,pe.StageId,pec.countryid,pe.IndustryId,
					pec.companyname, i.industry, pe.sector as sector_business,
					pe.amount, pe.round, s.REType,it.InvestorTypeName,  pe.stakepercentage,
                    DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,pec.website, pe.city, r.region,
					MoreInfor,hideamount,hidestake,c.country,pe.SPV,pe.SPV,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status,AggHide
					FROM REinvestments AS pe, reindustry AS i,
					REcompanies AS pec,realestatetypes as s,country as c,investortype as it,region as r
					WHERE dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
					and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pe.RegionId
					AND pe.Deleted =0 and pe.IndustryId =15 " .$addVCFlagqry. " AND  pec.PECompanyId IN ($companysearch) 
					order by companyname";
					$datevalueDisplay="";
				//	echo "<br>Query for company search";
				// echo "<br> Company search--" .$companysql;
				}
				elseif ($sectorsearchold != "")
				{
                                    
                                    $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                                            $sector_sql = array(); // Stop errors when $words is empty

                                            foreach($sectorsearchArray as $word){

//                                                $sector_sql[] = " sector_business LIKE '$word%' ";
                                                $sector_sql[] = " pe.sector = '$word' ";
                                                $sector_sql[] = " pe.sector LIKE '$word(%' ";
                                                $sector_sql[] = " pe.sector LIKE '$word (%' ";
                                            }
                                            $sector_filter = implode(" OR ", $sector_sql);
                                            

				$companysql="SELECT PEId,PEId,PEId,pe.PECompanyId,pe.StageId,pec.countryid,pe.IndustryId,
					pec.companyname, i.industry, pe.sector as sector_business,
					pe.amount, pe.round, s.REType,it.InvestorTypeName,  pe.stakepercentage,
                    DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,pec.website, pe.city, r.region,
					MoreInfor,hideamount,hidestake,c.country,pe.SPV,pe.SPV,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status,AggHide
					FROM REinvestments AS pe, reindustry AS i,
					REcompanies AS pec,realestatetypes as s,country as c,investortype as it,region as r
					WHERE dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
					and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pe.RegionId
					AND pe.Deleted =0 " .$addVCFlagqry. " AND  ($sector_filter) 
					order by companyname";
					$datevalueDisplay="";
				//	echo "<br>Query for company search";
				// echo "<br> Company search--" .$companysql;
				}
				elseif($keywordold!="")
				{
					$companysql="select peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,peinv.IndustryId,
					peinv_inv.InvestorId,peinv_inv.PEId,
					pec.companyname,i.industry,peinv.sector as sector_business,peinv.amount,peinv.round,
                                        s.REType,it.InvestorTypeName,peinv.stakepercentage,
					DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,peinv.city,r.region,MoreInfor,
					hideamount,hidestake,c.country,inv.Investor,peinv.SPV,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status,AggHide
					from REinvestments_investors as peinv_inv,REinvestors as inv,region as r,
				REinvestments as peinv,REcompanies as pec,reindustry as i,realestatetypes as s,country as c,investortype as it
				where dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and  inv.InvestorId=peinv_inv.InvestorId and peinv.IndustryId = i.industryid and
				 s.RETypeId=peinv.StageId and c.countryid=pec.countryid and it.InvestorType=peinv.InvestorType and r.RegionId=peinv.RegionId and peinv.Deleted=0  " .$addVCFlagqry. "
				and peinv.PEId=peinv_inv.PEId and pec.PECompanyId=peinv.PECompanyId " .$addVCFlagqry." AND inv.InvestorId IN ($keywordsearch)  order by companyname";
				$datevalueDisplay="";

			//			echo "<br> Investor search- ".$companysql;
				}

				elseif ( $companysearch != "" ||  $sectorsearch != "" || $keyword !="" || (count($industry) > 0) || ($companyType!="--")  || (count($stage) > 0)  || ($regiondId >0 ) || ($ex_city !='' ) || ($invType != "--") || ($SPVCompany !="--") || ($startRangeValue !="--") || ($endRangeValue != "--") || (($hidedateStartValue != "------01") && ($hidedateEndValue!="------01")))
					{
						 
						
					 // .$checkForStageValue
						$companysql = "select pe.PEId,pe.PEId,pe.PEId,pe.PECompanyID,pe.StageId,pec.countryid,pe.IndustryId,
						pec.companyname,i.industry,pe.sector as sector_business,amount,round,s.REType,it.InvestorTypeName,
						stakepercentage,DATE_FORMAT(dates,'%M-%Y') as dealperiod,pec.website,pe.city,r.region,MoreInfor,
						hideamount,	hidestake,c.country,SPV,SPV,Link,Valuation,FinLink,ProjectName,listing_status,Exit_Status,AggHide
						from REinvestments as pe, reindustry as i,REcompanies as pec,realestatetypes as s,country as c,investortype as it,region as r,REinvestors AS REinv, REinvestments_investors AS REinvoinv
						where";
						//T-993
						if($keyword !=""){
							if(isset($_POST['popup_select']) && $_POST['popup_select']=='investor'){
								$keyaft=" (".$inv_qry.")";  
								$keywordsearch = $_POST['popup_keyword'];                                              
							}else{
								$keywordsearch=$_POST['txthideinvestorsearch'];
								$keyaft=" and  REinv.InvestorId IN ($keywordsearch)";
							}
						}
						if($sectorsearch!=""){
							$sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
							$sector_sql = array(); // Stop errors when $words is empty

							foreach($sectorsearchArray as $word){

//                                                $sector_sql[] = " sector_business LIKE '$word%' ";
								$sector_sql[] = " pe.sector = '$word' ";
								$sector_sql[] = " pe.sector LIKE '$word(%' ";
								$sector_sql[] = " pe.sector LIKE '$word (%' ";
							}
							$sector_filter = implode(" OR ", $sector_sql);
						}
						if($companysearch !=""){
							if(isset($_POST['popup_select']) && $_POST['popup_select']=='company'){
								$keyaftcom=" (".$trend_com_qry.")";                                                
							}else{
								$keyaftcom=" and  pec.PECompanyId IN ($companysearch) ";
							}
						}
						if($sector_filter != ''){
							$sector_filter_valid = " and (".$sector_filter.")";
						}else{
							$sector_filter_valid = "";
						}
						
						//T-993
						
						if($industry == ""){
							$whereindustry = "and pe.IndustryId IN ( 15 )";
						} else {
							$industry = implode(",",$industry);
							$whereindustry = "and pe.IndustryId IN ( ".$industry." )";
						} 
                                                if (count($industry) > 0 && $industry[0]!='')
                                                {
                                                    $indusSql = '';
                                                    foreach($industry as $industrys)
                                                    {
                                                        $indusSql .= " pec.industry=$industrys or ";
                                                    }
                                                    $indusSql = trim($indusSql,' or ');
                                                    if($indusSql !=''){
                                                        $whereind = ' ( '.$indusSql.' ) ';
                                                    }
                                                    $qryIndTitle="Industry - ";
                                                    $addVCFlagqry='';
                                                } 
						if ($invType!= "--" && $invType!="" && $invType!=" ")
							{
							$whereInvType = " pe.InvestorType = '".$invType."'";
							}
						if($companyType!="--"  && $companyType!="")
                                                        {$wherelisting_status=" pe.listing_status='".$companyType."'";}
						if (!empty($stage) && count($stage) > 0) {
                                                    
                                                    $stagevalue="";
                                                    foreach($stage as $stageval)
                                                    {
                                                            //echo "<br>****----" .$stage;
                                                            $stagevalue= $stagevalue. " pe.StageId=" .$stageval." or ";
                                                    }
                                                    $stagevalue = trim($stagevalue,' or ');
                                                    if($stagevalue !=''){
                                                        $wherestage = ' ( '.$stagevalue .' ) ';
                                                    }
                                                }
						if ($regionId > 0 )
							{
								$whereregion = " pe.RegionId= $regionId ";
							}
						if ($ex_city !='' )
							{
								$wherecity = " pe.city like '$ex_city%' ";
							}

						if($SPVCompany==1)
							$whereSPVCompanies=" pe.SPV=0";
						elseif($SPVCompany==2)
							$whereSPVCompanies=" pe.SPV=1";

							$whererange ="";
							$wheredates="";
                                                        $whereexitstatus="";
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

							if($datevalue!="---to---")
							{
								$wheredates= " dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
							}

                                                   if ($exitstatusValue != '' && $exitstatusValue != '--') {

                                                        $whereexitstatus = " Exit_Status = $exitstatusValue";
                                                    }


						if (($wherestage != ""))
							{
								$companysql=$companysql . $wherestage . " and " ;
							}
						if (($whereInvType != "") )
							{
								$companysql=$companysql .$whereInvType . " and ";
							}
						 if($wherelisting_status!="")
                                                        	{
									$companysql=$companysql . $wherelisting_status . " and " ;
							        }
						if($whereregion!="")
						{
							$companysql=$companysql .$whereregion . " and ";
                                                }
						if($wherecity!="")
						{
							$companysql=$companysql .$wherecity . " and ";
                                                }
						if (($whereSPVCompanies != "") )
							{
								$companysql=$companysql .$whereSPVCompanies . " and ";
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
                                                                        
    
						//the foll if was previously checked for range
						if($whererange  !="")
						{
							$companysql = $companysql . "  i.industryid=pe.IndustryId and
							pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and c.countryid=pec.countryid and
							it.InvestorType=pe.InvestorType and r.RegionId=pe.RegionId and
							pe.Deleted=0 and REinvoinv.PEId = pe.PEId   AND REinv.InvestorId = REinvoinv.InvestorId " . $addVCFlagqry . $whereindustry.$keyaft.$keyaftcom.$sector_filter_valid." GROUP BY pe.PEId  order by companyname ";
						}
						elseif($whererange="--")
						{
							$companysql = $companysql . "  i.industryid=pe.IndustryId and
							pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and c.countryid=pec.countryid and
							 it.InvestorType=pe.InvestorType and  r.RegionId=pe.RegionId and
							pe.Deleted=0 and REinvoinv.PEId = pe.PEId   AND REinv.InvestorId = REinvoinv.InvestorId " . $addVCFlagqry . $whereindustry.$keyaft.$keyaftcom.$sector_filter_valid." GROUP BY pe.PEId order by companyname ";
						//	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
						}
					}

					else
					{
						echo "<br> INVALID DATES GIVEN ";
						$fetchRecords=false;

					}
//mail sending
 $insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,industry,dealtype,period,companysearch,advisorsearch_legal,advisorsearch_trans,investorsearch,target_listing_status)
 values('$submitemail','RE','Inv','$hideindustry','$dealtype','$datevalueDisplay','$companysearch','$advisorsearch_legal','$advisorsearch_trans','$keyword','$companyType')";
      if ($rsinsert_download = mysql_query($insert_downloadlog_sql))
      {
        //echo "<br>***".$insert_downloadlog_sql;
      }

			$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM RElogin_members AS dm,
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


									$subject="'Downloaded Data : $searchdisplay ";
									$message="<html><center><b><u> Downloaded :$searchdisplay  - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
									<tr><td width=1%>Sector </td><td width=99%>$hidestagetext</td></tr>
                                                                        <tr><td width=1%>Region </td><td width=99%>$regionValue</td></tr>
                                                                        <tr><td width=1%>Type </td><td width=99%>$SPVCompanyvalue</td></tr>

									<tr><td width=1%>Period</td><td width=99%>$datevalueDisplay</td></tr>
									<tr><td width=1%>Company Type</td><td width=99%>$companyType</td></tr>
                                                                        <tr><td width=1%>Investor Type</td><td width=99%>$invtypevalue</td></tr>
                                                                        <tr><td width=1%>Deal Range (US$M)</td><td width=99%>$rangeText</td></tr>

									<tr><td width=1%> Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Legal Advisor</td><td width=99%>$advisorsearch_legal</td></tr>
									<tr><td width=1%>Transaction Advisor</td><td width=99%>$advisorsearch_trans</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
								mail($to,$subject,$message,$headers);
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
		// echo "<br>---" .$sql;exit;
               
		 //execute query
		 $result = @mysql_query($sql)
			 or die("Error in Connection");
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
		 header("Content-Disposition: attachment; filename=reinv_deals.$file_ending");
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
		  $sep = "\t"; //tabbed character

		    echo "Company"."\t";
		    echo "Company Type"."\t";
		    echo "ProjectName"."\t";
		    echo "Industry"."\t";
		    echo "Sector"."\t";
	            echo "Type"."\t";

                     echo "Amount (US\$M)"."\t";
		    echo "Round"."\t";

		    echo "Investors"."\t";
		    echo "Investor Type"."\t";
		    echo "Stake (%)"."\t";
		    echo "Date"."\t";
                    echo "Exit Status" . "\t";
		    echo "Website"."\t";
		    echo "City"."\t";
		    echo "Region"."\t";
		    echo "Advisors-Company"."\t";
		    echo "Advisors-Investors"."\t";
		    echo "More Information"."\t";
                    echo "Link"."\t";
		    echo "Valuation"."\t";
		    echo "Link for Financials"."\t";

		  print("\n");

		  /*print("\n");*/
 //end of printing column names

  //start while loop to get data
  /*  note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".  */

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
		$companyName=strtolower($companyName);
		$compResult=substr_count($companyName,$searchString);
		//echo $compResult;
		if($row[24]==1)
		{
			$openBracket="(";
			$closeBracket=")";
		}
		else
		{
			$openBracket="";
			$closeBracket="";
		}
                
		if($row[31]==1)
		{
			$openaggBracket="{";
			$closeaggBracket="}";
		}
		else
		{
			$openaggBracket="";
			$closeaggBracket="";
		}

		if($compResult==0)
		{
           $schema_insert .=$openBracket.$openaggBracket.$row[7].$closeaggBracket.$closeBracket.$sep;
           $webdisplay=$row[16];
         }
		else
		{
			$schema_insert .= $searchStringDisplay.$sep;
			$webdisplay="";
		}
		$schema_insert .= $row[29].$sep; //company type (listing status)
		$schema_insert .= $row[28].$sep;   //Project Name for SPV companies
		$schema_insert .= $row[8].$sep; //industry
		$schema_insert .= $row[9].$sep;
		$schema_insert .= $row[12].$sep;
		if($row[20]==1)
			$hideamount="";
		else
			$hideamount=$row[10];

		$schema_insert .= $hideamount.$sep;
		$schema_insert .= $row[11].$sep;


		$investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor from REinvestments_investors as peinv,
				REinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId";
			//echo "<Br>Investor".$investorSql;

		$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from REinvestments_advisorcompanies as advcomp,
		REadvisor_cias as cia where advcomp.PEId=$PEId and advcomp.CIAId=cia.CIAId";
			//echo "<Br>".$advcompanysql;

		$advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from REinvestments_advisorinvestors as advinv,
		REadvisor_cias as cia where advinv.PEId=$PEId and advinv.CIAId=cia.CIAId";

			if($investorrs = mysql_query($investorSql))
			 {

				$investorString="";
				$AddOtherAtLast="";
				$AddUnknowUndisclosedAtLast="";
			   while($rowInvestor = mysql_fetch_array($investorrs))
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

                           
                           //
                           $exitstatusis='';
                            $exitstatusSql = "select id,status from exit_status where id=$row[30]";
                            if ($exitstatusrs = mysql_query($exitstatusSql))
                            {
                              $exitstatus_cnt = mysql_num_rows($exitstatusrs);
                            }
                            if($exitstatus_cnt > 0)
                            {
                                    While($myrow=mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                                    {
                                            $exitstatusis = $myrow[1];
                                    }
                            }
                            else{
                                $exitstatusis='';
                            }
                            
                            $schema_insert .= $exitstatusis . $sep;
                           //
                            
                            $schema_insert .= $webdisplay.$sep; // website
                            
			   $schema_insert .= $row[17].$sep;
			   $schema_insert .= $row[18].$sep;

			 if($advisorcompanyrs = mysql_query($advcompanysql))
			 {
				 $advisorCompanyString="";
			   while($row1 = mysql_fetch_array($advisorcompanyrs))
				{
					$advisorCompanyString=$advisorCompanyString.",".$row1[2]."(".$row1[3].")";
				}
					$advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
			}
			$schema_insert .= $advisorCompanyString.$sep;


			if($advisorinvestorrs = mysql_query($advinvestorssql))
			 {
				 $advisorInvestorString="";
			   while($row2 = mysql_fetch_array($advisorinvestorrs))
				{
					$advisorInvestorString=$advisorInvestorString.",".$row2[2]."(".$row2[3].")";
				}
					$advisorInvestorString=substr_replace($advisorInvestorString, '', 0,1);
			}

			$schema_insert .= $advisorInvestorString.$sep;


			 $schema_insert .= $row[19].$sep;
			 $schema_insert .= $row[25].$sep;   //Link
			 $schema_insert .= $row[26].$sep;   //Valuation
			 $schema_insert .= $row[27].$sep;   //Link for financials

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
 mysql_close();  
?>