<?php
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
	
	
	//SEARCH ON SUBMIT
	/*if(!$_POST){
		$_POST['month1'] = '1';
		$_POST['year1']  = date('Y'); 
		$_POST['month2'] = '12';
		$_POST['year2']  = date('Y');
	}*/
	
	
	//if($_POST){
                                $vcflagValue = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
				$dbTypeSV="SV";
				$dbTypeIF="IF";
				$dbTypeCT="CT";

				$searchString="Undisclosed";
			 	$searchString=strtolower($searchString);

			 	$searchString1="Unknown";
				$searchString1=strtolower($searchString1);
					
				$searchString2="Others";
				$searchString2=strtolower($searchString2);

			 	$buttonClicked=$_POST['hiddenbutton'];
				$fetchRecords=true;
				$totalDisplay="";
				$keyword=$_POST['keywordsearch'];

				$keywordhidden=$_POST['keywordsearch'];
				//echo "<Br>--" .$keywordhidden;
				$keywordhidden =ereg_replace(" ","_",$keywordhidden);

				//echo "<br>--" .$keywordhidden;

				$companysearch=$_POST['companysearch'];
				$companysearchhidden=ereg_replace(" ","_",$companysearch);

				$advisorsearchstring_legal=$_POST['advisorsearch_legal'];
				$advisorsearchhidden_legal=ereg_replace(" ","_",$advisorsearchstring_legal);

                                $advisorsearchstring_trans=$_POST['advisorsearch_trans'];
				$advisorsearchhidden_trans=ereg_replace(" ","_",$advisorsearchstring_trans);

				$searchallfield=$_POST['searchallfield'];
				$searchallfieldhidden=ereg_replace(" ","_",$searchallfield);

				//echo "<br>Key word ---" .$keyword;
				//$region=$_POST['region'];
				$industry=$_POST['industry'];
				$stageval=$_POST['stage'];
				if($_POST['stage'])
				{
					$boolStage=true;
					//foreach($stageval as $stage)
					//	echo "<br>----" .$stage;
				}
				else
				{
					$stage="--";
					$boolStage=false;
				}
				//echo "<br>**" .$stage;
				$companyType=$_POST['comptype'];
				//echo "<BR>---" .$companyType;
				$debt_equity=$_POST['dealtype_debtequity'];
				$investorType=$_POST['invType'];

				$regionId=$_POST['txtregion'];

				//$range=$_POST['invrange'];
				$startRangeValue=$_POST['invrangestart'];
				$endRangeValue=$_POST['invrangeend'];
				$endRangeValueDisplay =$endRangeValue;
				//echo "<br>Stge**" .$range;
				$whereind="";
				$whereregion="";
				$whereinvType="";
				$wherestage="";
				$wheredates="";
				$whererange="";
				$wherelisting_status="";
				$month1=($_POST['month1']) ?  $_POST['month1'] : '1';
				$year1 = ($_POST['year1']) ?  $_POST['year1'] : date('Y');
				$month2=($_POST['month2']) ?  $_POST['month2'] : '12';
				$year2 = ($_POST['year2']) ?  $_POST['year2'] : date('Y');

				$notable=false;
			//	echo "<br>FLAG VALIE--" .$vcflagValue;
                                $datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
                                $splityear1=(substr($year1,2));
                                $splityear2=(substr($year2,2));

                                if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
                                {	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
                                        $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
                                        $wheredates1= "";
                                }
                                $whereaddHideamount="";

		if($industry >0)
                {
                        $industrysql= "select industry from industry where IndustryId=$industry";
                        if ($industryrs = mysql_query($industrysql))
                        {
                                While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                                {
                                        $industryvalue=$myrow["industry"];
                                }
                        }
                }
		$stageCnt=0;
                $cnt=0;
                $stageCntSql="select count(StageId) as cnt from stage";
                if($rsStageCnt=mysql_query($stageCntSql))
                {
                  while($mystagecntrow=mysql_fetch_array($rsStageCnt,MYSQL_BOTH))
                   {
                     $stageCnt=$mystagecntrow["cnt"];
                   }
                }
                 if($boolStage==true)
		{
			foreach($stageval as $stageid)
			{
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
			$stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
			if($cnt==$stageCnt)
			{      $stagevaluetext="All Stages";}
       		}
		else
			$stagevaluetext="";
		//echo "<br>*************".$stagevaluetext;
		if($companyType=="L")
		        $companyTypeDisplay="Listed";
		elseif($companyType=="U")
                        $companyTypeDisplay="UnListed";
 	        elseif($companyType=="--")
                        $companyTypeDisplay="";

                if($investorType !="--")
			{
				$invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
						if ($invrs = mysql_query($invTypeSql))
						{
							While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
							{
								$invtypevalue=$myrow["InvestorTypeName"];
							}
						}
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


		$invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";



				if($vcflagValue==0)
				{
					$addVCFlagqry = " and pec.industry !=15 ";
					$checkForStage = ' && ('.'$stage'.' =="--")';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue = " || (" .'$stage'.">0) ";
					$searchTitle = "List of PE Investments ";
					$searchAggTitle = "Aggregate Data - PE Investments ";
					$aggsql= "select count(PEId) as totaldeals,sum(amount) as totalamount from peinvestments as pe,
					pecompanies as pec,industry as i where ";
					$samplexls="../xls/Sample_Sheet_Investments.xls";
				}
				elseif($vcflagValue==1)
				{
					$addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and pe.amount <=20 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of VC Investments ";
					$searchAggTitle = "Aggregate Data - VC Investments ";
					$aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
					$samplexls="Sample_Sheet_Investments(VC Deals).xls";
				//	echo "<br>Check for stage** - " .$checkForStage;
				}
				elseif($vcflagValue==2)
				{
					$addVCFlagqry = " and pec.industry =15 ";
					$stage="--";
					$checkForStage = "";
					$checkForStageValue = "";
					$searchTitle = "List of PE Investments - Real Estate";
					$searchAggTitle = "Aggregate Data - PE Investments - Real Estate";
					$aggsql= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					FROM peinvestments AS pe, pecompanies AS pec,industry as i where	";
				}

                                 if($vcflagValue==0)
                                    {
                                            $getTotalQuery="SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                                            FROM peinvestments AS pe, pecompanies AS pec
                                            WHERE pe.Deleted =0  and pe.PECompanyId=pec.PECompanyId
                                            AND pec.industry !=15 and pe.AggHide=0 and
                                            pe.PEId NOT
                                                    IN (
                                                    SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE DBTypeId ='SV'
                                                    AND hide_pevc_flag =1
                                                    )";
                                            $pagetitle="PE Investments -> Search";
                                            $stagesql_search = "select StageId,Stage from stage ";
                                            $industrysql_search="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
                                        // echo "<br>***".$industrysql;
                                    }
                                    elseif($vcflagValue==1)
                                    {
                                       $getTotalQuery= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                                            FROM peinvestments AS pe, stage AS s ,pecompanies as pec
                                            WHERE s.VCview =1 and  pe.amount<=20 and pec.industry !=15 and pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId
                                            and pe.Deleted=0
                                            and
                                            pe.PEId NOT
                                                    IN (
                                                    SELECT PEId
                                                    FROM peinvestments_dbtypes AS db
                                                    WHERE DBTypeId =  'SV'
                                                    AND hide_pevc_flag =1
                                                    )  ";
                                            $pagetitle="VC Investments -> Search";
                                            $stagesql_search = "select StageId,Stage from stage where VCview=1 ";
                                             $industrysql_search="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";

                                            //echo "<Br>---" .$getTotalQuery;
                                    }

				/* echo "<br>Check for stage value- " .$checkForStageValue;
				echo "<br>Ivn Type**".$invType;
				echo "<br>Industry**".$industry;
				echo "<br>Stage**".$stage;
				echo "<Br>Region**" .$region;
				echo "<br>Range**" .$range;
				echo "<Br>Dates**" .$month1. "**" .$year1. "**" .$month2. "*****" .$year2 ;
				echo "<br>Companysearch- " .$companysearch;
				echo "<Br>Keyword-".$keyword; */
		/*if($range != "--")
		{
			$rangesql= "select startRange,EndRange,RangeText from investmentrange where InvestRangeId=". $range ." ";
			if ($rangers = mysql_query($rangesql))
			{
				While($myrow=mysql_fetch_array($rangers, MYSQL_BOTH))
				{
					$startRangeValue=$myrow["startRange"];
					$endRangeValue=$myrow["EndRange"];
					$rangeTextDisplay=$myrow["RangeText"];
				}
			}
		}*/

			//if (($keyword == "") && ($searchallfield=="") && ($companysearch=="") && ($advisorsearchstring_trans=="") && ($advisorsearchstring_legal=="")  && ($industry =="--")  && ($regionId=="--") && ($invType == "--") && ($companyType=="--") && ($region == "--") && ($startRangeValue == "--") && ($endRangeValue == "--") && ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--") && ($stage=="--") && ($debt_equity=="--"))
			if(!$_POST){
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
		//		echo "<br>Query for all records";
				 $companysql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				 amount, round, s.stage,  stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pec.website, pec.city,
				 pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId ,SPV,AggHide
						 FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s
						 WHERE pec.industry = i.industryid
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
						 and pe.Deleted=0" .$addVCFlagqry. " AND pe.PEId NOT
                                                  IN (
                                                  SELECT PEId
                                                  FROM peinvestments_dbtypes AS db
                                                  WHERE DBTypeId = '$dbTypeSV'
                                                  AND hide_pevc_flag =1
                                                  ) order by companyname";
			//	     echo "<br>all records" .$companysql;
			}
			elseif ($companysearch != "")
			{
				$yourquery=1;
        			$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				website, city, region, PEId,
				COMMENT,MoreInfor,hideamount,hidestake,pe.StageId,SPV,AggHide FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$companysearch%'
				OR sector_business LIKE '%$companysearch%')   AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )
				order by companyname";
			//	echo "<br>Query for company search";
		// echo "<br> Company search--" .$companysql;
			}
			elseif($keyword!="")
			{
				$yourquery=1;
				$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
				$companysql="select pe.PECompanyId,pec.companyname,pec.industry,i.industry,sector_business,pe.amount,
				peinv_inv.InvestorId,peinv_inv.PEId,inv.Investor,pe.PECompanyId,pec.industry,
				pec.companyname,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,i.industry,hideamount,SPV,AggHide
			from peinvestments_investors as peinv_inv,peinvestors as inv,
			peinvestments as pe,pecompanies as pec,industry as i,stage as s
			where inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and  pe.StageId=s.StageId and pe.Deleted=0
			and pe.PEId=peinv_inv.PEId and pec.PECompanyId=pe.PECompanyId " .$addVCFlagqry." AND inv.investor like '$keyword%'
                        AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )
                        order by companyname";


			//echo "<br> Investor search- ".$companysql;
			}
			elseif($advisorsearchstring_legal!="")
			{
                          $stagevaluetext="";
				$yourquery=1;
				$industry=0;
				$datevalueDisplay1="";
			$companysql="(
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.amount,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac,stage as s

				WHERE pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. "
				AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                ) )
				UNION (
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.amount,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac,stage as s
				WHERE pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. "
				AND cia.cianame LIKE '%$advisorsearchstring_legal%'  and AdvisorType='L'
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )  )   order by companyname";
			//echo "<br>LEGAL -".$companysql;
			}
			elseif($advisorsearchstring_trans!="")
			{
                          $stagevaluetext="";
				$yourquery=1;
				$industry=0;
				$datevalueDisplay1="";
			$companysql="(
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.amount,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac,stage as s
				WHERE pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. "
				AND cia.cianame LIKE '%$advisorsearchstring_trans%'   and AdvisorType='T'
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                ) )
				UNION (
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.amount,
                                 cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac,stage as s
				WHERE pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. "
				AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId = '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )  )   order by companyname";
			//echo "<br>TRANS-".$vcflagValue;
			}
			elseif($searchallfield!="")
			{
				$yourquery=1;
				$industry=0;
				$stagevaluetext="";
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.amount, pe.round, s.Stage,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,
				website, city, region, PEId,
				COMMENT,MoreInfor,hideamount,hidestake,pe.StageId,SPV,AggHide FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$searchallfield%'
				OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' )
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                )

				order by companyname";
			//	echo "<bR>---" .$companysql;
			}

			elseif (($industry > 0) || ($companyType!="--") || ($debt_equity!="--") || ($invType != "--") || ($regionId>0)  || ($startRangeValue == "--") || ($endRangeValue == "--") || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")) .$checkForStageValue)
				{
					$yourquery=1;

					if(($year1<2004) && ($year2>=2004))
                                        {
                                           $exportdt1="2004-".$month1."-01";
                                           $exportdt2 = $year2."-".$month2."-01";
                                        }
                                        elseif(($year1<2004)&&($year2< 2004))
                                        {
                                           //$exportFlag="N";
				           $exportdt1 = "--------";
				           $exportdt2= "--------";
                                        }
                                        elseif(($year1>=2004)&&($year2>=2004))
                                        {

                                         	$exportdt1 = $year1."-".$month1."-01";
  					        $exportdt2 = $year2."-".$month2."-01";
                                        }
                                        elseif(($year1>=2004)&&($year2<2004))
                                        {

                                           $exportdt1 = "------01";
				           $exportdt2= "------01";
                                        }
                                        // if($year2<2004)
                                        //   $exportdt2="2004-".$month2."-01";
                                       // else
				        //   $exportdt2 = $year2."-".$month2."-01";
					//echo "<BR>DATE1---" .$dt1;
					$dt1 = $year1."-".$month1."-01";
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pe.PECompanyID,pec.companyname,pec.industry,i.industry,
					pec.sector_business,amount,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
					pec.website,pec.city,pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s where";
				//	echo "<br> individual where clauses have to be merged ";
					if ($industry > 0)
						{
							$whereind = " pec.industry=" .$industry ;
							$qryIndTitle="Industry - ";
						}
			//	echo "<br> WHERE IND--" .$whereind;
						if ($regionId > 0)
						{
							$qryRegionTitle="Region - ";
							$whereregion = " pec.RegionId  =".$regionId;
							}
					//	echo " <bR> where REGION--- " .$whereregion;
					        if($companyType!="--")
					        {
                                                  $wherelisting_status="pe.listing_status='".$companyType."'";
                                                  }
						if($debt_equity!="--")
                                                {  $whereSPVdebt=" pe.SPV=".$debt_equity; }
                                                if ($invType!= "--")
						{
							$qryInvType="Investor Type - " ;
							$whereInvType = " pe.InvestorType = '".$investorType."'";
						}
						if ($boolStage==true)
						{
							$stagevalue="";
							$stageidvalue="";
							foreach($stageval as $stage)
							{
								//echo "<br>****----" .$stage;
								$stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
								$stageidvalue=$stageidvalue.",".$stage;
							}

							$wherestage = $stagevalue ;
							$qryDealTypeTitle="Stage  - ";
							$strlength=strlen($wherestage);
							$strlength=$strlength-3;
						//echo "<Br>----------------" .$wherestage;
						$wherestage= substr ($wherestage , 0,$strlength);
						$wherestage ="(".$wherestage.")";
						//echo "<br>---" .$stringto;

						}
					//	echo "<br>Where stge---" .$wherestage;
						if (($startRangeValue!= "--") && ($endRangeValue != "")  )
						{
							$startRangeValue=$startRangeValue;
							$endRangeValue=$endRangeValue-0.01;
							$qryRangeTitle="Deal Range (M$) - ";
							if($startRangeValue < $endRangeValue)
							{
								$whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ." and AggHide=0";
							}
							elseif(($startRangeValue = $endRangeValue) )
							{
								$whererange = " pe.amount >= ".$startRangeValue ." and AggHide=0";
							}
						}
						//echo "<Br>***".$whererange;

						if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
						{
							$qryDateTitle ="Period - ";
							$wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";

						}
					if ($whereind != "")
						{
							$companysql=$companysql . $whereind ." and ";
							$aggsql=$aggsql . $whereind ." and ";
							$bool=true;
						}
						else
						{
							$bool=false;
						}
					if (($whereregion != "") )
						{
					//		echo "<br>TRUE";
						$companysql=$companysql . $whereregion . " and " ;
							$aggsql=$aggsql . $whereregion ." and ";
					//	echo "<br>----comp sql after region-- " .$companysql;
						$bool=true;
						}
						if (($wherestage != ""))
						{
						//	echo "<BR>--STAGE" ;
							$companysql=$companysql . $wherestage . " and " ;
							$aggsql=$aggsql . $wherestage ." and ";
							$bool=true;
						//	echo "<br>----comp sql after stage-- " .$companysql;

                                        	}
                                        	if($wherelisting_status!="")
                                        	{
                                                 $companysql=$companysql .$wherelisting_status . " and ";
                                                }
                                                if($whereSPVdebt!="")
                                                { $companysql=$companysql .$whereSPVdebt ." and "; }
					if (($whereInvType != "") )
						{
							$companysql=$companysql .$whereInvType . " and ";
							$aggsql = $aggsql . $whereInvType ." and ";
							$bool=true;
						}
					if (($whererange != "") )
						{
							$companysql=$companysql .$whererange . " and ";
							$aggsql=$aggsql .$whererange . " and ";
							$bool=true;
						}
					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates ." and ";
						$aggsql = $aggsql . $wheredates ." and ";
						$bool=true;
					}

					//the foll if was previously checked for range
					if($whererange  !="")
					{
						$companysql = $companysql . " pe.hideamount=0 and  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and
						pe.Deleted=0 " . $addVCFlagqry . "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                )
                                                order by companyname ";
					//	echo "<br>----" .$whererange;
					}
					elseif($whererange="--")
					{
						$companysql = $companysql . "  i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and
						pe.Deleted=0 " .$addVCFlagqry. "
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId =  '$dbTypeSV'
                                                AND hide_pevc_flag =1
                                                )
                                                order by companyname ";
					//	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
					}

				}
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
	//}
	//END OF POST
	
	
	
	
	$companyId=632270771;
	$compId=0;
	$currentyear = date("Y");
	
	$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
		where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
	
	if($trialrs=mysql_query($TrialSql))
	{
		while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
		{
			$exportToExcel=$trialrow["TrialLogin"];
			$compId=$trialrow["compid"];

		}
	}
	
   if($compId==$companyId){ 
   		$hideIndustry = " and display_in_page=1 "; 
	} else { 
		$hideIndustry=""; 
	}
	
	
	/*$getTotalQuery="SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
	FROM peinvestments AS pe, pecompanies AS pec
	WHERE pe.Deleted =0  and pe.PECompanyId=pec.PECompanyId
	AND pec.industry !=15 and pe.AggHide=0 and
				pe.PEId NOT
						IN (
						SELECT PEId
						FROM peinvestments_dbtypes AS db
						WHERE DBTypeId ='SV'
						AND hide_pevc_flag =1
						)";
	$pagetitle="PE Investments -> Search";
	$stagesql = "select StageId,Stage from stage ";*/
	
	//INDUSTRY
	$industrysql="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
	
	//Company Sector
	$searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
	
	$addVCFlagqry="";
	$pagetitle="PE-backed Companies";

	$getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
					FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
					WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
					AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
					AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
	ORDER BY pec.companyname";
	
	//Stage
	$stagesql = "select StageId,Stage from stage ";
	echo $companysql;

?>

<?php
	$topNav = 'Deals'; 
	include_once('header_search.php');
?>

<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td class="left-box">

<?php //include_once('refine.php');?>

</td>
 <?php
    $type=$_REQUEST['type'];
    if($_POST['year1'] !='')
    {
        $syear=$_POST['year1'];
        $fixstart=$_POST['year1'];
        $startyear=$syear."-01-01";
    }
    else
    {
         $fixstart=2009;
        $startyear="2009-01-01";
    }
    if($_POST['year2'] !='')
    {

        $eyear=$_POST['year2'];
        $fixend=$_POST['year2'];
        $endyear=$eyear."-01-01";
    }
    else
    {
        $endyear=date("Y-m-d");
        $fixend=date("Y-m-d");
    }
    if($type==1)
    {
    $sqlYear = "select year(`peinvestments`.`dates`),count(`peinvestments`.`PEId`),sum(`peinvestments`.`amount`) FROM `peinvestments` where (`peinvestments`.`amount` > 0 and `peinvestments`.`amount`<=5) and dates > '1997-01-01' and dates <='2013-12-31' group by year(`peinvestments`.`dates`)";
    $resultYear= mysql_query($sqlYear);
    }
    elseif ($type==2) 
    {
       $sqlindus = "select `industry`.`industry`,year(`peinvestments`.`dates`),count(`peinvestments`.`PEId`),sum(`peinvestments`.`amount`) FROM `peinvestments`,`pecompanies`,`industry` where `peinvestments`.`PECompanyId`=`pecompanies`.`PECompanyId` 
      and `pecompanies`.`industry`=`industry`.`industryid` and dates > '".$startyear."' and dates <= '".$endyear."' group by `pecompanies`.`industry`,year(`peinvestments`.`dates`)";
       $resultindus= mysql_query($sqlindus);
    }
    elseif($type==3)
    {
       $sqlstage = "select `stage`.`Stage`,year(`peinvestments`.`dates`),count(`peinvestments`.`PEId`),sum(`peinvestments`.`amount`) FROM `peinvestments`,`stage` where `peinvestments`.`StageId`=`stage`.`StageId` and dates > '".$startyear."' and 
      dates <= '".$endyear."' group by `stage`.`Stage`, year(`peinvestments`.`dates`)";
       $resultstage= mysql_query($sqlstage);
    }
    elseif($type==5)
    {
       $sqlinvestor = "select `investortype`.`InvestorTypeName`, year(`peinvestments`.`dates`),count(`peinvestments`.`PEId`),sum(`peinvestments`.`amount`) FROM `peinvestments`,`investortype` where `peinvestments`.`InvestorType`=`investortype`.`InvestorType` and dates > '".$startyear."' and 
      dates <= '".$endyear."' group by `investortype`.`InvestorTypeName`, year(`peinvestments`.`dates`)";
       $resultinvestor= mysql_query($sqlinvestor);
    }
    elseif($type==6)
    {
       $sqlregion = "SELECT  `region`.`Region` , YEAR(  `peinvestments`.`dates` ) , COUNT(  `peinvestments`.`PEId` ) , SUM(  `peinvestments`.`amount` ) FROM  `peinvestments` ,  `pecompanies` ,  `region` 
    WHERE  `peinvestments`.`PECompanyId` =  `pecompanies`.`PECompanyId` AND  `pecompanies`.`region` =  `region`.`Region` AND dates > '".$startyear."' AND dates <= '".$endyear."' AND  `region`.`Region` !=  ''
    GROUP BY  `region`.`Region` , YEAR(  `peinvestments`.`dates` )";
       $resultregion= mysql_query($sqlregion);
    }
 ?>

<td>
<div class="result-cnt">

<!--div class="result-title"><h2>794 results for</h2> <ul><li>PE Investments <!--<a href="#"><img src="images/icon-close.png" width="9" height="8" border="0"/>--></a></li> <!--<li>Industry: All <a href="#"><img src="images/icon-close.png" width="9" height="8" border="0" /></a></li> <li>Sector: All <a href="#"><img src="images/icon-close.png" width="9" height="8" border="0" /></a></li> <li>Last 2 Months <a href="#"><img src="images/icon-close.png" width="9" height="8" border="0" /></a></li>> </ul> <h2> No. of Deals - 32     Value (US$ M) - 456</h2>

<div class="alert-note">Note: Target/Company in () indicates tranche rather than a new round. Target/Company in indicates a debt investment. Not included in aggregate data.</div></div-->
<div class="veiw-tab"><ul>
<li><a href="index.php"><i class="i-list-view"></i>List View</a></li>
<li ><a href="dealdetails.php?value=<?php echo $SelCompRef;?>/<?php echo $flagvalue;?>/<?php echo $searchstring;?>"><i class="i-profile-view"></i>Deal Details View</a></li>
<li class="active"><a href="trendview.php?type=1"><i class="i-trend-view"></i>Trend View</a></li>
</ul><br>

<!--div class="pagination-profile"> <a href="javascript:history.back(-1)">< Back</a>  <!--a href="javascript:history.back(1)">Next ></a> </div-->

</div>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Indusrty</label>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>

</td></tr>
</table>
</div>
 <div class="profile-view-title"> 
 <?php 
 if($type==1)
 {
 ?>
    <h2>PE - Year on Year</h2>
<?php
 }
 elseif($type==2)
 {
     ?>
     <h2>PE - By Industry</h2>
 <?php
 }
  elseif($type==3)
 {
     ?>
     <h2>PE - By Stage</h2>
 <?php
 }
  elseif($type==4)
 {
     ?>
     <h2>PE - By Range</h2>
 <?php
 }
  elseif($type==5)
 {
     ?>
     <h2>PE - By Investor</h2>
 <?php
 } elseif($type==6)
 {
     ?>
     <h2>PE - By Region</h2>
 <?php
 }
 ?>
 </div>
<?php
if($type==2 || $type==3 || $type==4 || $type==5 || $type==6)
{
?>
<div class="refine">
    <br> <h4>From <span style="margin-left: 35px;"> To</span></h4>
<SELECT NAME="year1" id="year1">
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
		if($yearSql=mysql_query($yearsql))
		{
                        
                        if($_POST['year1']=='')
                        {
                            echo $year1=2009;
                        }
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
                                $isselected = ($year1==$id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
			}		
		}
	?> 
</SELECT>

<SELECT NAME="year2" id="year2">
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates asc";
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}		
		}
	?> 
</SELECT>
    <input type="submit" name="fliter_stage" value="Go">
    </form></div>
<?php
}
?>
<div class="view-table"><div class="restable"><table class="responsive" cellpadding="0" cellspacing="0">

    <thead>
   
    <?php
    if($type==1)
    {
        ?>
    
        <tr><th colspan="1" style="text-align:center">Year</th>
            <th colspan="1" style="text-align:center">No. of Deals</th>
            <th colspan="1" style="text-align:center">Amount($m)</th>
        </tr>
<?php
    }
    elseif($type==2)
    {
    ?>

   
    <tr><th rowspan="2"  style="text-align:center">Industry</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
            if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
  <?php   
    }
    elseif($type==3)
    {
        ?>
  <tr><th rowspan="2"  style="text-align:center">Stage</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                 if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==5)
    {
        ?>
   
       <tr><th rowspan="2"  style="text-align:center">Investor</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
           echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php     
    }
    else if($type==4)
    {
        ?>
        <tr><th rowspan="2"  style="text-align:center">Range</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==6)
    {
        ?>
    <tr><th rowspan="2"  style="text-align:center">Region</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
             echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php
    }
    ?></thead>
 <?php
if($type==2)
{
    while($rowindus = mysql_fetch_array($resultindus))	
    {  
       $deal[$rowindus['industry']][$rowindus[1]]['dealcount']=$rowindus[2];
       $deal[$rowindus['industry']][$rowindus[1]]['sumamount']=$rowindus[3];  
    }  
}
elseif($type==3)
{
     while($rowstage = mysql_fetch_array($resultstage))	
    {  
       $deal[$rowstage['Stage']][$rowstage[1]]['dealcount']=$rowstage[2];
       $deal[$rowstage['Stage']][$rowstage[1]]['sumamount']=$rowstage[3];  
    }
}
else if($type ==4)
{
    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
    for($r=0;$r<count($range);$r++)
    {
        if($r == count($range)-1)
        {
             $sqlrange = "select year(`peinvestments`.`dates`),count(`peinvestments`.`PEId`),sum(`peinvestments`.`amount`) FROM `peinvestments` where (`peinvestments`.`amount` > 200) and dates > '".$startyear."' and dates <= '".$endyear."' group by year(`peinvestments`.`dates`)";
              $resultrange= mysql_query($sqlrange);
        }
        else
        {
            $limit=(string)$range[$r];
            $elimit=explode("-", $limit);
            $sqlrange = "select year(`peinvestments`.`dates`),count(`peinvestments`.`PEId`),sum(`peinvestments`.`amount`) FROM `peinvestments` where (`peinvestments`.`amount` > ".$elimit[0]." and `peinvestments`.`amount`<= ".$elimit[1].") and dates > '".$startyear."' and dates <= '".$endyear."' group by year(`peinvestments`.`dates`)";
             $resultrange= mysql_query($sqlrange);
        }
        while ($rowrange = mysql_fetch_array($resultrange))
        {
            $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
            $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
        }

    }
}
else if($type==5)
{
     while($rowinvestor = mysql_fetch_array( $resultinvestor))	
    {  
       $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['dealcount']=$rowinvestor[2];
       $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['sumamount']=$rowinvestor[3];  
    }
}
else if($type==6)
{
     while($rowregion = mysql_fetch_array( $resultregion))	
    {  
       $deal[$rowregion['Region']][$rowregion[1]]['dealcount']=$rowregion[2];
       $deal[$rowregion['Region']][$rowregion[1]]['sumamount']=$rowregion[3];  
    }
}
?>
 <tbody>
     <tbody>
      <?php
    if($type==1)
    {
        while($rowsyear = mysql_fetch_array($resultYear))	
        {
                echo "<tr style=\"text-align:center;\">
                <td>".$rowsyear[0]."</td>
                <td>".$rowsyear[1]."</td>
                <td>".$rowsyear[2]."</td>
                </tr>";		                                                                           
        }
    }
    else if($type==2)
    {
        $content ='';
   
        foreach($deal as $industry => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$industry.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 
        echo $content;
    }
    else if($type==3)
    {
        $content ='';
   
        foreach($deal as $Stage => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$Stage.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 
        echo $content;
    }
    else if($type == 4)
    {
        $content ='';
   
        foreach($deal as $range => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$range.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 

        echo $content;
    }
    else if($type==5)
    {
         $content ='';
   
        foreach($deal as $InvestorTypeName => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$InvestorTypeName.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 

        echo $content;   
    }
    else if($type==6)
    {
        $content ='';

        foreach($deal as $range => $values){
            $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
            $content .= '<td>'.$range.'</td>';
             for($i=$fixstart;$i<=$fixend;$i++){
                 $content .= "<td>".$values[$i]['dealcount']."</td>";
                 $content .= "<td>".$values[$i]['sumamount']."</td>";
             }
             $content.= '</tr>';
        } 

        echo $content;
    }
    ?>
    </tbody>

        </table></div>
 
          
</div>
    
    </div>
</td>

</tr>
</table>
 
</div>

<div class=""></div>

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

?>
