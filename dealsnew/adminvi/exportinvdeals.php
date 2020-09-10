<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
		include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";


				global $LoginAccess;
				global $LoginMessage;
				global $TrialExpired;
					$wherestage="";
					$submitemail=$_POST['txthideemail'];
					$searchtitle=$_POST['txttitle'];
					$industry=$_POST['txthideindustryid'];
					$hideindustrytext=$_POST['txthideindustry'];
					//echo "<Br>-----------" .$hideindustrytext;
					$hidestagetext=$_POST['txthidestage'];
					$stagearr=$_POST['txthidestageid'];
					if($stagearr!="--")
					{
						$stageidvalue=explode(",",$stagearr);
						foreach ($stageidvalue as $stageid)
						{
							if(trim($stageid)!=="")
							{
								$stagevalue= $stagevalue. " pe.StageId=" .$stageid." or ";
							}
						}
						$wherestage = $stagevalue ;
						$qryDealTypeTitle="Stage  - ";
						$strlength=strlen($wherestage);
						$strlength=$strlength-3;

						$wherestage= substr ($wherestage , 0,$strlength);
						$wherestage =" (".$wherestage.")";
						//echo "<Br>----------------" .$wherestage;
					}
					else
						$stage="--";

					//VCFLAG VALUE
					$hidesearchon=$_POST['txtsearchon'];

					//echo "<Br>****".$datevalue;

					//echo "<br>--".$targetcompanysearch;


					$invtypevalue=$_POST['txthideinvtype'];
					$invType=$_POST['txthideinvtypeid'];
					//echo "<Br>----". $invType;

					$regionId=$_POST['txthideregionid'];
					$regionValue=$_POST['txthideregionvalue'];
					//echo "<br>REGION- " .$regionId;

					$startRangeValue=$_POST['txthiderangeStartValue'];
					$endRangeValue=$_POST['txthiderangeEndValue'];
					$rangeText=$_POST['txthiderange'];

					$datevalue=$_POST['txthidedate'];

					$keyword=$_POST['txthideinvestor'];
					$keyword =ereg_replace("-"," ",$keyword);

					//echo "<Br>--" .$keyword;
					$companysearch=$_POST['txthidecompany'];
					$companysearch =ereg_replace("-"," ",$companysearch);

					$advisorsearch=$_POST['txthideadvisor'];
					$advisorsearch =ereg_replace("-"," ",$advisorsearch);
					//echo "<br>- ".$advisorsearch;

					$searchallfield=$_POST['txthidesearchallfield'];
					$searchallfield =ereg_replace("-"," ",$searchallfield);

					$hidedateStartValue=$_POST['txthidedateStartValue'];
					$hidedateEndValue=$_POST['txthidedateEndValue'];
					$dateValue=$_POST['txthidedate'];


				$whereind="";
				$whereregion="";
				$whereinvType="";

				$wheredates="";
				$whererange="";

					$submitemail=$_POST['txthideemail'];

					$tsjtitle="© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

				if($searchtitle==0)
				{
					$addVCFlagqry = " and pec.industry !=15 ";
					$checkForStage = ' && ('.'$stage'.' =="--")';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					//$checkForStageValue = " || (" .'$stage'.">0) ";
					$searchTitle = "List of PE Investments ";
				}
				elseif($searchtitle==1)
				{
					$addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and amount <=20 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					//$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of VC Investments ";
				}
				elseif($searchtitle==2)
				{
					$addVCFlagqry = " and pec.industry =15 ";
					$stage="--";
					$checkForStage = "";
					$checkForStageValue = "";
					$searchTitle = "List of PE Investments - Real Estate";
				}

				/*echo "<br>Industry Id-----------------**".$hideindustryid;
				echo "<br>Inv type id-----------------**".$invtypevalueid;
				echo "<br>Start Range Value-----------------**".$hiderangeStartValue;
				echo "<br>End Range value-----------------**".$hiderangeEndValue;
				*/
				//echo "<br>start Date-----------------**".$hidedateStartValue;
				//echo "<br>End Date-----------------**".$dateValue;
				//echo "<br>Deal Type---**". $dealtype;


			if (($keyword == "") &&  ($searchallfield=="") && ($companysearch=="") && ($regionId=="--") && ($industry =="--") && 	($invType == "--") && ($startRangeValue == "--") && ($endRangeValue == "--") && ($hidedateStartValue == "------01") && ($hidedateEndValue == "------01") && ($stage=="--"))
				{
						 $companysql = "SELECT PEId,PEId,PEId,pe.PECompanyId, pe.StageId,pec.countryid,
						 pec.industry,pec.companyname, i.industry, pec.sector_business,
						 amount, round, s.stage, it.InvestorTypeName, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod , pec.website, pec.city,
						 r.Region,MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink
						 FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,country as c,investortype as it,region as r
						 WHERE pec.industry = i.industryid and it.InvestorType=pe.InvestorType
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid
						 and r.RegionId=pec.RegionId
						 and pe.Deleted=0" .$addVCFlagqry. "order by companyname";

				//echo "<br>3 Query for All records" .$companysql;
					}
				elseif ($companysearch != "")
					{

					$companysql="SELECT PEId,PEId,PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
						pec.companyname, i.industry, pec.sector_business,
						pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
						pec.website, pec.city, r.Region,
						MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuatin,FinLink
						FROM peinvestments AS pe, industry AS i,
						pecompanies AS pec,stage as s,country as c,investortype as it,region as r
						WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
						and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId
						AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$companysearch%'
						OR sector_business LIKE '%$companysearch%' )
						order by companyname";
					//	echo "<br>Query for company search";
				// echo "<br> Company search--" .$companysql;
					}
				elseif($keyword!="")
					{
						$companysql="select peinv.PEId,peinv.PECompanyId,peinv.StageId,pec.countryid,pec.industry,
						peinv_inv.InvestorId,peinv_inv.PEId,
						pec.companyname,i.industry,sector_business,peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
						DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,pec.website,pec.city,r.Region,MoreInfor,
						hideamount,hidestake,c.country,inv.Investor,Link,pec.RegionId,Valuation,FinLink
						from peinvestments_investors as peinv_inv,peinvestors as inv,
					peinvestments as peinv,pecompanies as pec,industry as i,stage as s,country as c,investortype as it,region as r
					where inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and
					 s.StageId=peinv.StageId and c.countryid=pec.countryid and it.InvestorType=peinv.InvestorType and peinv.Deleted=0
					and peinv.PEId=peinv_inv.PEId and r.RegionId=pec.RegionId and
					pec.PECompanyId=peinv.PECompanyId " .$addVCFlagqry." AND inv.investor like '$keyword%' order by companyname";

					//	echo "<br> Investor search- ".$companysql;
					}

					elseif($advisorsearch!="")
					{
						$companysql="(
						SELECT peinv.PEId,peinv.PECompanyId,peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
						c.companyname, i.industry, c.sector_business, peinv.amount,peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
						DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
						hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink
						FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
						advisor_cias AS cia, peinvestments_advisorinvestors AS adac,region as r
						WHERE peinv.Deleted=0 and c.industry = i.industryid
						AND c.PECompanyId = peinv.PECompanyId and
					 	s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId
						AND cia.cianame LIKE '%$advisorsearch%'
						)
						UNION (
						SELECT peinv.PEId,peinv.PECompanyId, peinv.StageId,c.countryid,c.industry,cia.CIAId,adac.CIAId AS AcqCIAId,
						c.companyname, i.industry, c.sector_business, peinv.amount, peinv.round,s.Stage,it.InvestorTypeName,peinv.stakepercentage,
						DATE_FORMAT( peinv.dates, '%M-%Y' )as dealperiod,c.website,c.city,r.Region,MoreInfor,
						hideamount,hidestake,co.country,cia.Cianame,Link,c.RegionId,Valuation,FinLink
						FROM peinvestments AS peinv, pecompanies AS c, industry AS i,stage as s,country as co,investortype as it,
						advisor_cias AS cia, peinvestments_advisorcompanies AS adac,region as r
						WHERE peinv.Deleted=0 and c.industry = i.industryid
						AND c.PECompanyId = peinv.PECompanyId
						and
					 	s.StageId=peinv.StageId and co.countryid=c.countryid and it.InvestorType=peinv.InvestorType
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.PEId and r.RegionId=c.RegionId
						AND cia.cianame LIKE '%$advisorsearch%'
						)";

					}
					elseif ($searchallfield != "")
					{

					$companysql="SELECT PEId,PEId,PEId,pe.PECompanyId,pe.StageId,pec.countryid,pec.industry,
						pec.companyname, i.industry, pec.sector_business,
						pe.amount, pe.round, s.Stage,it.InvestorTypeName,  pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dealperiod,
						pec.website, pec.city, r.Region,
						MoreInfor,hideamount,hidestake,c.country,c.country,Link,pec.RegionId,Valuation,FinLink
						FROM peinvestments AS pe, industry AS i,
						pecompanies AS pec,stage as s,country as c,investortype as it,region as r
						WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
						and c.countryid=pec.countryid and it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId
						AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$searchallfield%'
						OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' )
						order by companyname";
					//	echo "<br>Query for company search";
				    // echo "<br> Company search--" .$companysql;
					}
					elseif (($industry > 0) || ($invType != "--")  || ($regionId > 0) || ($startRangeValue !="--") || ($endRangeValue != "--") || ($wherestage!="") || (($hidedateStartValue != "------01") && ($hidedateEndValue!="------01")) )
					{
							$companysql = "select pe.PEId,pe.PEId,pe.PEId,pe.PECompanyID,pe.StageId,pec.countryid,
							pec.industry,pec.companyname,i.industry,pec.sector_business,amount,round,s.stage,
							it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%M-%Y') as dealperiod,
							pec.website,pec.city,r.Region,MoreInfor,hideamount,hidestake,c.country,c.country,
							Link,pec.RegionId,Valuation,FinLink
							from peinvestments as pe, industry as i,pecompanies as pec,stage as s,
							country as c,investortype as it,region as r
							where";
						//	echo "<br> individual where clauses have to be merged ";

							if($regionId >0)
							{
								$whereregion = " pec.RegionId  =".$regionId;
							}


							if ($industry > 0)
								{
									$whereind = " pec.industry=" .$industry ;
								}

							if ($invType!= "--")
								{
								$whereInvType = " pe.InvestorType = '".$invType."'";
								}
							//if ($stage!= "--")
							//	{
							//		$wherestage = " pe.StageId =" .$stage ;
							//	}
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

								if($datevalue!="---to---")
								{
									$wheredates= " dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
								}
							if ($whereind != "")
								{
									$companysql=$companysql . $whereind ." and ";
								}
							if (($wherestage != ""))
								{
									$companysql=$companysql . $wherestage . " and " ;
								}
							if (($whereInvType != "") )
								{
									$companysql=$companysql .$whereInvType . " and ";
								}
							if (($whereregion != "") )
							{

							$companysql=$companysql . $whereregion . " and " ;
							$aggsql=$aggsql . $whereregion ." and ";

							$bool=true;
							}
							if (($whererange != "") )
								{
									$companysql=$companysql .$whererange . " and ";
								}
							if(($wheredates !== "") )
							{
								$companysql = $companysql . $wheredates ." and ";
							}

							//the foll if was previously checked for range
							if($whererange  !="")
							{
								$companysql = $companysql . " pe.hideamount=0 and  i.industryid=pec.industry and
								pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid and
								it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId and
								pe.Deleted=0 " . $addVCFlagqry . " order by companyname ";
							}
							elseif($whererange="--")
							{
								$companysql = $companysql . "  i.industryid=pec.industry and
								pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and c.countryid=pec.countryid and
								 it.InvestorType=pe.InvestorType and r.RegionId=pec.RegionId and
								pe.Deleted=0 " .$addVCFlagqry. "order by companyname ";
							 //   echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
							}

						}
						else
						{
							echo "<br> INVALID DATES GIVEN ";
							$fetchRecords=false;
						}

//mail sending

//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
//		{
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
								//$to .="sowmyakvn@gmail.com";
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
									<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
									<tr><td width=1%>Stage</td><td width=99%>$hidestagetext</td></tr>
									<tr><td width=1%>Region</td><td width=99%>$regionValue</td></tr>
									<tr><td width=1%>Investment Type</td><td width=99%>$invtypevalue</td></tr>
									<tr><td width=1%>Range</td><td width=99%>$rangeText</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company/Sector</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>

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
									<tr><td width=1%>Industry </td><td width=99%>$hideindustry</td></tr>
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
									<tr><td width=1%>Industry </td><td width=99%>$hideindustry</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtype</td></tr>
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
								mail($to,$subject,$message,$headers);
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
	//	}


 $sql=$companysql;
//echo "<br>---" .$sql;
 //execute query
 $result = @mysql_query($sql)
     or die("Error in connection:<br>");

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
 header("Content-Disposition: attachment; filename=peinv_deals.$file_ending");
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
 $sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
	echo "Company"."\t";
	echo "Industry"."\t";
	echo "Sector"."\t";
	echo "Amount"."\t";
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
	 echo "Valuation"."\t";
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
		$companyName=strtolower($companyName);
		$compResult=substr_count($companyName,$searchString);
		//echo $compResult;
		if($compResult==0)
		{
          $schema_insert .= $row[7].$sep;
           $webdisplay=$row[16];
         }
		 else
		{
			$schema_insert .= $searchStringDisplay.$sep;
			 $webdisplay="";
		}

          $schema_insert .= $row[8].$sep;
            $schema_insert .= $row[9].$sep;
            if($row[20]==1)
            	$hideamount="";
            else
            	$hideamount=$row[10];

	         $schema_insert .= $hideamount.$sep;
	           $schema_insert .= $row[11].$sep;
	         $schema_insert .= $row[12].$sep;


	$investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
		peinvestors as inv where peinv.PEId=$PEId and inv.InvestorId=peinv.InvestorId";
	//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$PEId and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame from peinvestments_advisorinvestors as advinv,
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
				$advisorCompanyString=$advisorCompanyString.",".$row1[2];
			}
				$advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
		}
		$schema_insert .= $advisorCompanyString.$sep;


		if($advisorinvestorrs = mysql_query($advinvestorssql))
		 {
			 $advisorInvestorString="";
		   while($row2 = mysql_fetch_array($advisorinvestorrs))
			{
				$advisorInvestorString=$advisorInvestorString.",".$row2[2];
			}
				$advisorInvestorString=substr_replace($advisorInvestorString, '', 0,1);
		}
		$schema_insert .= $advisorInvestorString.$sep;
        $schema_insert .= $row[19].$sep;      //moreinfor
      $schema_insert .= $row[24].$sep;  //link
	$schema_insert .= $row[26].$sep; //Valuation
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

//		}
//else
//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
?>