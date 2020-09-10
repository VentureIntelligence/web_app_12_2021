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
				$dbTypeSV="SV";
				$dbTypeIF="IF";
				$dbTypeCT="CT";

				$searchString="Undisclosed";
			 	$searchString=strtolower($searchString);

			 	$searchString1="Unknown";
				$searchString1=strtolower($searchString1);

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
				$vcflagValue=$_POST['txtvcFlagValue'];
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
					$samplexls="../Sample_Sheet_Investments.xls";
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
	

?>


<?php 
	$topNav = 'Directory';
	include_once('header_search.php');
?>





<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td class="left-box">

<?php include_once('refine.php');?>

</td>
 <?php

				$exportToExcel=0;
			 $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$studentOption=$trialrow["Student"];
				}
			}

			if($yourquery==1)
				$queryDisplayTitle="Query:";
			elseif($yourquery==0)
				$queryDisplayTitle="";
					if(trim($buttonClicked==""))
					{
						$totalDisplay="Total";
				    	$industryAdded ="";
				    	$totalAmount=0.0;
				    	$totalInv=0;
						$compDisplayOboldTag="";
						$compDisplayEboldTag="";
				 	  //echo "<br> query final-----" .$companysql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($companysql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }

				           if($company_cnt > 0)
				           {
				           		//$searchTitle=" List of Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
				              	$notable=true;
				              	writeSql_for_no_records($companysql,$emailid);
				           }

					}
		           ?>


<td>
 

<td>

<div class="directory-cnt"> 

<div class="search-area">
<input name="" type="text" /> <input name="" type="button" />
</div>

<h3>Show by:</h3>

<div class="show-by-list">
<ul><li><a href="#">A</a></li><li><a href="#">B</a></li><li><a href="#">C</a></li><li><a href="#">D</a></li><li><a href="#">E</a></li><li><a href="#" class="active">F</a></li><li><a href="#">G</a></li><li><a href="#">H</a></li><li><a href="#">I</a></li><li><a href="#">J</a></li><li><a href="#">K</a></li><li><a href="#">L</a></li><li><a href="#">M</a></li><li><a href="#">N</a></li><li><a href="#">O</a></li><li><a href="#">P</a></li><li><a href="#">Q</a></li><li><a href="#"> R </a></li><li><a href="#">S </a></li><li><a href="#"> T  </a></li><li><a href="#">  U  </a></li><li><a href="#">   V   </a></li><li><a href="#">   W </a></li><li><a href="#">  X  </a></li><li><a href="#">   Y  </a></li><li><a href="#">   Z</a></li></ul></div>
<div class="directory-list">





<div class="pageLinks fl"><div class="holder"></div></div>

      <!-- item container -->
      <ul id="itemContainer">
 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 <li><div class="img-box"><img src="images/img-company.gif" width="56" height="56" alt="" /></div> <h4>Platinum Polymers</h4>
Unlisted, FY 3yrs</li>

 </ul>
 
 <div class="pageLinks fl"><div class="holder"></div></div>
      
 </div>     
 
       
    </div>
    </td>

</tr>
</table>
 
</div>
<div class=""></div>

</div>
</form>
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


    ?>
